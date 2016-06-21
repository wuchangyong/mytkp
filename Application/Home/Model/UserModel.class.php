<?php
namespace Home\Model;

use Home\util\DBUtil;
class UserModel{
    
    private $dbUtil;
    
    public function __construct(){
        $this->dbUtil = new DBUtil();
    }
    
    /**
     * 登录验证
     * @param unknown $userName 用户名
     * @param unknown $userPass 密码
     * @return number 1表示登录成功  2表示用户名不存在  3表示密码错误
     */
    public function login($userName, $userPass){
        $sql = "select * from tb_user where userName=?";
        $datas = $this->dbUtil->executeQuery($sql, array($userName));
        if(count($datas) == 1){
            //用户名存在
            if($userPass == $datas[0][2]){
                //用户名正确，密码正确
                return 1;
            }else{
                //密码错误
                return 3;
            }
        }else{
            //用户名不存在
            return 2;
        }
    }
    
    /**
     * 通过用户名加载整个用户数据数组 - 表中的一行数据
     * @param unknown $userName
     * @return mixed|NULL 用户数据数组 若无此用户名的数据返回null
     */
    public function loadUserByName($userName){
        $sql = "select * from tb_user where userName=?";
        //, \PDO::FETCH_OBJ, 'Home\entity\User'
        $datas = $this->dbUtil->executeQuery($sql, array($userName));
        if(count($datas) == 1){
            return $datas[0];
        }else{
            return null;
        }
    }
    
}

?>