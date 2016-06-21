<?php
namespace Home\Model;
use Home\util\DBUtil;
use Home\entity\Menu;
/**
 * 专注于访问menu表
 * @author Administrator
 *
 */
class MenuModel{
    
    private $dbUtil;
    
    public function __construct(){
        $this->dbUtil = new DBUtil();
    }
    
    /**
     * 根据当前登录用户的uid加载首页左侧树形菜单数据
     * @param $uid 当前登录用户的主键id
     * @return 所有的二级菜单，且每个二级菜单下面都包含自己的子菜单
     */
    public function loadTreeMenu($uid){
        $menus2 = array();
        $m2s = array();
        $sql = "select m.* from userrole ur,rolemenu rm,menu m where ur.rid=rm.rid and rm.menuid=m.menuid and m.isshow=1 and ur.uid=? and parentid=?";
        //查询一级菜单 只有一个 , \PDO::FETCH_OBJ, 'Home\entity\Menu'
        $menus = $this->dbUtil->executeQuery($sql, array($uid,-1));
        if(count($menus) > 0){
            $menu1 = $menus[0];
            
            //查询二级菜单 通过一级菜单主键ID去查询
            $menus2 = $this->dbUtil->executeQuery($sql, array($uid,$menu1[0]));
            //循环每一个二级菜单，通过每一个二级菜单的主键ID去查询它下面的子菜单
            foreach($menus2 as $second){
                $m2 = array();
                array_push($m2, $second[0],$second[1],$second[2],$second[3],$second[4]);
                $menus3 = $this->dbUtil->executeQuery($sql, array($uid,$second[0]));
                //设置二级菜单的children属性
//                 $second->setChildren($menus3);
                array_push($m2, $menus3);
                array_push($m2s, $m2);
            }
        }
        return $m2s;
    }
    
    /**
     * 分页查询菜单列表
     * @param unknown $pageNo
     * @param unknown $pageSize
     * @return 返回带total和rows索引的二维数组
     */
    public function loadMenuByPage($pageNo, $pageSize){
        $begin = ($pageNo-1)*$pageSize;
        $sql = "select m.menuid,m.name,m.url,(select m2.name from menu m2 where m2.menuid=m.parentid) as parentName,m.isshow from menu m limit $begin,$pageSize";
        $sql2 = "select count(*) from menu";
//         $sql = "select m.menuid,m.name,m.url,m2.name as parentName,m.isshow from menu m,menu m2 where m.parentid=m2.menuid limit ?,?";
        $page = $this->dbUtil->executePageSubQuery($sql, $sql2, $pageNo, $pageSize, null,\PDO::FETCH_ASSOC);
        return $page;
    }
    
    /**
     * 加载1级 2级菜单 供添加和修改菜单时的表单父级菜单下拉列表填充选项
     * @return 返回所有的1级和2级菜单组成的数组
     */
    public function load12Menu(){
        $fsmenu = array();
        //添加一个默认的提示选项
        array_push($fsmenu, Menu::getInstance(-1, "请选择父级菜单", "", -2, 0));
        
        $sql = "select * from menu where parentid=?";
        //查询一级菜单 只有一个 
        $menus = $this->dbUtil->executeQuery($sql, array(-1), \PDO::FETCH_OBJ, 'Home\entity\Menu');
        $menu1 = $menus[0];
        $menu1->setName("一级-".$menu1->getName());
        array_push($fsmenu, $menu1);
    
        //查询二级菜单 通过一级菜单主键ID去查询
        $menus2 = $this->dbUtil->executeQuery($sql, array($menu1->getMenuid()), \PDO::FETCH_OBJ, 'Home\entity\Menu');
        foreach ($menus2 as $second){
            $second->setName("二级-".$second->getName());
            array_push($fsmenu, $second);
        }
        return $fsmenu;
    }
    
    /**
     * 添加或者修改菜单
     * @param string $name
     * @param string $url
     * @param int $parentid
     * @param int $isshow
     * @param int $menuid 可选参数 传入大于0的整数则执行修改，传入0则执行新增
     */
    public function saveOrUpdateMenu($name, $url, $parentid, $isshow, $menuid=0){
        $b = true;
        if($menuid == 0){
            //无主键值  新增
            $sql  = "insert into menu(name,url,parentid,isshow) values(?,?,?,?)";
            $b = $this->dbUtil->executeDML($sql, array($name, $url, $parentid, $isshow));
        }else{
            //有主键值 修改
            $sql  = "update menu set name=?,url=?,parentid=?,isshow=? where menuid=?";
            $b = $this->dbUtil->executeDML($sql, array($name, $url, $parentid, $isshow, $menuid));
        }
        return $b;
    }
    
    /**
     * 通过主键id加载菜单对象数据
     * @param int $menuid
     */
    public function loadMenuByID($menuid){
        $sql = "select * from menu where menuid=?";
        $menus = $this->dbUtil->executeQuery($sql, array($menuid), \PDO::FETCH_ASSOC);
        return $menus[0];
    }
    
    /**
     * 删除菜单
     */
    public function deleteMenus($menuids){
        $sql = "delete from menu where menuid in($menuids)";
        $this->dbUtil->executeDML($sql);
    }
    
}

?>