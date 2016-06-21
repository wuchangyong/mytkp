<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index($userPass=null,$userName=null){
//         echo "路由测试".$_GET["userName"]."---".$_GET["userPass"];
//         echo $_GET['name']."---".$_GET["pwd"];
        echo $userName."------".$userPass;
//         $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    
    public function test($year,$month,$date){
        echo I("param.year")."~".I("param.month")."~".I("param.date");
//         echo I("request.year")."~".I("request.month")."~".I("request.date");
//         echo I("get.year")."~".I("get.month")."~".I("get.date");
//         echo $_GET["year"]."-".$_GET["month"]."-".$_GET["date"];
//         echo I("path.1")."/".I("path.2")."/".I("path.3");
//         $this->redirect(U("ttt"));
//         redirect("http://www.baidu.com");
    }
    
//     public function _before_index(){
//         echo "before-----index<br/>";
//     }
    
//     public function _after_index(){
//         echo "after-----index<br/>";
//     }

    public function _empty() {
        echo "你访问的资源不存在";
    }
    
}