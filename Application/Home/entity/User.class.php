<?php
namespace Home\entity;
class User{
    
    public $uid;
    
    public $userName;
    
    public $userPass;
    
    public $phone;
    
    public $age;
    
    public $sex;
    
    public $email;
    /**
     * @return $uid
     */
    public function getUid(){
        return $this->uid;
    }

    /**
     * @return $userName
     */
    public function getUserName(){
        return $this->userName;
    }

    /**
     * @return $userPass
     */
    public function getUserPass(){
        return $this->userPass;
    }

    /**
     * @return $phone
     */
    public function getPhone(){
        return $this->phone;
    }

    /**
     * @return $age
     */
    public function getAge(){
        return $this->age;
    }

    /**
     * @return $sex
     */
    public function getSex(){
        return $this->sex;
    }

    /**
     * @return $email
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUid($uid){
        $this->uid = $uid;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUserName($userName){
        $this->userName = $userName;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setUserPass($userPass){
        $this->userPass = $userPass;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setPhone($phone){
        $this->phone = $phone;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setAge($age){
        $this->age = $age;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setSex($sex){
        $this->sex = $sex;
    }

    /**
     * @param !CodeTemplates.settercomment.paramtagcontent!
     */
    public function setEmail($email){
        $this->email = $email;
    }

    
}

?>