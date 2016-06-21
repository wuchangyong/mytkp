<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\MenuModel;
class MenuController extends Controller {
    
    private $menuModel;
    
    public function __construct(){
        parent::__construct();
        $this->menuModel = new MenuModel();
    }
    
    public function menuManage(){
//         $this->assign("root",ROOT);
        $this->display();
    }
    
    
    
    /**
     * 分页查询菜单列表
     * @param number $pageNo  参数绑定
     * @param number $pageSize参数绑定
     */
    public function loadMenuByPage($pageNo=1, $pageSize=10){
        $page = $this->menuModel->loadMenuByPage($pageNo, $pageSize);
        $this->ajaxReturn($page);
    }
    
    /**
     * 添加或者修改菜单时，父级菜单下拉列表加载数据
     */
    public function load12Menu(){
        $menu12 = $this->menuModel->load12Menu();
        $this->ajaxReturn($menu12);
    }
    
    /**
     * 添加或者修改菜单
     * @param unknown $menuid       参数绑定
     * @param unknown $name         参数绑定
     * @param unknown $url          参数绑定
     * @param unknown $parentid     参数绑定
     * @param unknown $isshow       参数绑定
     */
    public function saveOrUpdateMenu($menuid,$name,$url,$parentid,$isshow) {
        if($menuid == ""){
            $this->menuModel->saveOrUpdateMenu($name, $url, $parentid, $isshow, 0);
            $this->ajaxReturn("insertok","eval");
        }else{
            $this->menuModel->saveOrUpdateMenu($name, $url, $parentid, $isshow, (int)$menuid);
            $this->ajaxReturn("updateok","eval");
        }
    }
    
    /**
     * 通过主键id加载菜单对象数据
     * @param unknown $menuid
     */
    public function loadMenuByID($menuid){
        $menu = $this->menuModel->loadMenuByID($menuid);
        $this->ajaxReturn($menu);
    }
    
    /**
     * 删除菜单
     * @param unknown $menuids
     */
    public function deleteMenus($menuids) {
        $this->menuModel->deleteMenus($menuids);
        $this->ajaxReturn("OK","eval");
    }
    
    
}