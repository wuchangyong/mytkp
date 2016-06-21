<?php
namespace Home\Controller;

use Think\Controller;
class EmptyController extends Controller{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        echo "你访问的控制器不存在";
    }
    
}

?>