<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\UserModel;
use Home\Model\MenuModel;

class UserController extends Controller{
    private $userModel;
    private $menuModel;
    private $userModel2;
    
    public function __construct(){
        parent::__construct();
        $this->userModel = new UserModel();
        $this->menuModel = new MenuModel();
        $this->userModel2 = M("tb_user");
    }
    
    public function login(){
           
        $userName = $_POST["userName"];
        $userPass = $_POST["userPass"];
        $i = $this->userModel->login($userName, $userPass);
        if($i == 1){
            $user = $this->userModel->loadUserByName($userName);
            session_start();
            $_SESSION["loginUser"] = $user;
            
            //取出当前登录用户的主键uid，用来查询他拥有的菜单
            $uid = $_SESSION["loginUser"][0];
            $secondMenu = $this->menuModel->loadTreeMenu($uid);
            $_SESSION["secondMenu"] = $secondMenu;
            
            header("location:http://localhost:8000/mytkp/welcome.php");
        }elseif ($i == 2){
            
        }else {
            
        }
    }
    
    /**
     * 查询班主任 回填班主任下拉列表框
     */
    public function loadAllHeader(){
        $options = array(array("uid"=>-1,"truename"=>"请指定合并后班主任名称"));
        $data = $this->userModel2->field("uid,trueName")->where("userType=2")->select();
        foreach ($data as $d){
            array_push($options, $d);
        }
        $this->ajaxReturn($options);
    }
    
    /**
     * 查询班主任 回填班主任下拉列表框
     */
    public function loadAllManager(){
        $options = array(array("uid"=>-1,"truename"=>"请指定合并后项目经理名称"));
        $data = $this->userModel2->field("uid,trueName")->where("userType=3")->select();
        foreach ($data as $d){
            array_push($options, $d);
        }
        $this->ajaxReturn($options);
    }
    
}

?>