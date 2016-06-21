<?php
namespace model;
use util\DBUtil;
class RoleModel{
    
    private $dbUtil;
    
    public function __construct(){
        $this->dbUtil = new DBUtil();
    }
    
    /**
     * 加载所有角色 不分页
     */
    public function loadAllRoles(){
        $sql = "select * from role order by rid";
        return $this->dbUtil->executeQuery($sql);
    }
    
    
    /**
     * 加载角色菜单，并给出当前角色是否拥有此菜单的判断依据
     * 第三列若为1表示当前角色拥有此菜单，若为null表示没有此菜单权限
     * @param unknown $rid
     */
    public function loadRoleMenu($rid){
        $sql = "select m.menuid,m.name,(select 1 from rolemenu rm where rm.menuid=m.menuid and rm.rid=?) from menu m";
        return $this->dbUtil->executeQuery($sql, array($rid));
    }
    
    /**
     * 修改角色菜单
     * @param unknown $rid
     * @param array $menuids
     */
    public function modifyRoleMenu($rid, array $menuids){
        $pdo = $this->dbUtil->getPdo();
        try{
            $pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT, false);
            $pdo->beginTransaction();
            $sql = "delete from rolemenu where rid=?";
            $ps = $pdo->prepare($sql);
            $ps->execute(array($rid));
            
            $sql = "insert into rolemenu(rid,menuid) values(?,?)";
            foreach($menuids as $mid){
                $ps = $pdo->prepare($sql);
                $ps->execute(array($rid, $mid));
            }
            $pdo->commit();
            $pdo->setAttribute(\PDO::ATTR_AUTOCOMMIT, true);
            $this->dbUtil->free($pdo, $ps);
        }catch(\PDOException $e){
            $pdo->rollBack();
        }
        
    }
    
    
}

?>