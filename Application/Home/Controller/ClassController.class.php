<?php
namespace Home\Controller;

use Think\Controller;
use Think\Model;
use Home\entity\Menu;
class ClassController extends Controller{
    
    private $classModel;
    
    
    
    public function __construct(){
        parent::__construct();
        //直接实例化Model类，用来完成简单的增删改查操作
//         $this->classModel = new Model("class","",C("DB_DSN"));
        $this->classModel = M("class");//new Model("class");
    }
    
    
    public function classManage(){
        $this->display();
    }
    
    /**
     * 分页查询班级列表
     * @param number $pageNo  参数绑定
     * @param number $pageSize参数绑定
     */
    public function loadClassByPage($pageNo=1, $pageSize=10, 
        $className=null, $createtime1=null, $createtime2=null, 
        $headerName=null, $begintime1=null, $begintime2=null, 
        $managerName=null, $endtime1=null, $endtime2=null, $status=-1){
        
        
        $sql = " from class c,tb_user u1,tb_user u2 where c.headerid=u1.uid and c.managerid=u2.uid";
        //第一行   
        if(null != $className){
            $sql .= " and c.name like '%$className%'";
        }
        if(null != $createtime1){
            $sql .= " and c.createTime >= '".$createtime1."'";
        }
        if(null != $createtime2){
            $sql .= " and c.createTime <= '".$createtime2."'";
        }
        //第二行
        if(null != $headerName){
            $sql .= " and u1.trueName like '%$headerName%'";
        }
        if(null != $begintime1){
            $sql .= " and c.beginTime >= '".$begintime1."'";
        }
        if(null != $begintime2){
            $sql .= " and c.beginTime <= '".$begintime2."'";
        }
        //第三行
        if(null != $managerName){
            $sql .= " and u2.trueName like '%$managerName%'";
        }
        if(null != $endtime1){
            $sql .= " and c.endTime >= '".$endtime1."'";
        }
        if(null != $endtime2){
            $sql .= " and c.endTime <= '".$endtime2."'";
        }
        //状态
        if($status > 0){
            $sql .= " and c.status = $status";
        }
        
        $count = $this->classModel->query("select count(*) as cc".$sql)[0]["cc"];
        $page["total"] = $count;
        
        
        $begin = ($pageNo-1)*$pageSize;
        $rows = $this->classModel->query("select c.cid,c.name,c.classtype,c.status,
            c.createtime,c.begintime,c.endtime,u1.truename headername,
            u2.truename managername,c.stucount,c.remark".$sql." order by cid limit $begin,$pageSize");
        $page["rows"] = $rows;
        
        $this->ajaxReturn($page);
    }
    
    
    /**
     * 检查所选班级今天是否有考试
     * @param unknown $cids 参数绑定 格式为1,2,3
     */
    public function checkExamToday($cids=null){
        $d = date("Y-m-d");
        $db = $d." 00:00:00";
        $de = $d." 23:59:59";
        $data = $this->classModel->table("exam")->where("classid in($cids) and beginTime between '$db' and '$de'")->select();
        if(count($data) > 0){
            //获取到今天有考试的班级id，用于提示哪些班有考试
            $classids = array();
            foreach($data as $exam){
                array_push($classids, $exam["classid"]);
            }
            $str = implode(",",$classids);
            //查询今天有考试的班级名称
            $cnames = $this->classModel->field("name")->where("cid in($str)")->select();
            //存放今天有考试的班级名称的数组
            $names = array();
            foreach($cnames as $n){
                array_push($names, $n["name"]);
            }
            $this->ajaxReturn("对不起，".implode(",",$names)."今天有考试，不能参与班级合并！","EVAL");
        }else{
            $this->ajaxReturn("ok","EVAL");
        }
    }
    
    
    /**
     * 合并班级
     * @param unknown $cids 要合并的班级id  格式为1,2,3
     * @param unknown $combinedClassid  合并后保留的班级id
     * @param unknown $combinedHeaderid 合并后该班的班主任id
     * @param unknown $combinedManagerid 合并后该班的项目经理id
     */
    public function hebingClasses($cids=null,$combinedClassid=-1,$combinedHeaderid=-1,$combinedManagerid=-1){
        try{
            $this->classModel->setProperty(\PDO::ATTR_AUTOCOMMIT, false);
            $this->classModel->startTrans();//开启事务
            
            $classes = $this->classModel->table("class")->where("cid in($cids)")->select();
            $totalCount = 0;
            foreach($classes as $c){
                if($c["cid"] == $combinedClassid){
                    //要保留的班级
                }else{
                    //不保留的班级
                    $totalCount += $c["stucount"];
                    $c["stucount"] = 0;//被合并之后人数清零
                    $c["status"] = 3;//被合并
                    $this->classModel->save($c);
                    
                    //修改tb_user表中classid为不保留的班级id的改为保留的班级id
                    $sql = "update tb_user set classid=%d where classid=%d";
                    $this->classModel->execute($sql,$combinedClassid,$c["cid"]);
                }
            }
            
            //查询合并后要保留的班级信息
            $combinedClass = $this->classModel->table("class")->where("cid=%d",$combinedClassid)->find();
            $combinedClass["headerid"] = $combinedHeaderid;
            $combinedClass["managerid"] = $combinedManagerid;
            $combinedClass["stucount"] += $totalCount;
            $this->classModel->save($combinedClass);
            
            $this->classModel->commit();//提交事务
        }catch(\Exception $e){
            $this->classModel->rollback();//事务回滚到上一次提交后的数据状态
        }
        $this->loadClassByPage();
    }
    
    
    
    public function loadAllClasses(){
//         $param["cid"] = array("GT",1);
//         $data = $this->classModel->where($param)->select();
//         $data = $this->classModel->where("cid>%d",1)->select();
        //->bind(":cid",2)
//         $data = $this->classModel->field("u.trueName,p.name pname,c.name cname")->table("tb_user u,province p,city c")->where("u.pid=p.pid and u.cid=c.cid")->select();
//         print_r($data);
        
    }
    
    public function reg(){
//         $data = array("name"=>"u22","status"=>1,"classType"=>4);
//         $this->classModel->data($data)->save();
//         $cid = $this->classModel->save();
//         echo $cid;
//         $this->classModel->where("cid=1")->setInc("stucount");
//         $this->classModel->delete("4");
        //保存一个标量变量
        $this->assign("ttt","中国你好");
        
        //保存索引数组
        $arr = array(11,22,33,44,55);
        $this->assign("arr",$arr);
        
        //保存关联数组
        $arr2 = array("aa"=>"这个","bb"=>"师姐");
        $this->assign("arr2",$arr2);
        
        //保存一个二维数组
        $data = $this->classModel->select();
        $this->assign("data",$data);
        $this->assign("arrayLength",count($data));
        $this->assign("msg","<b style='color:red;'>对不起，没有找到任何数据... </b>");
        
        //保存一个对象
        $menu = Menu::getInstance(111, "武当山管理", "aaa.html", 1, 1);
        $this->assign("menu",$menu);
        
        $host = $_SERVER["HTTP_HOST"];
        $this->assign("host",$host);
        
        //演示模版中使用函数
        $this->assign("str","abcdefg");
        
        //演示模版中使用运算符
        $this->assign("i",2);
        $this->assign("j",5);
        
        $this->display();//查找默认的模版进行展示
        //$this->display("index");//查找另一个模版进行展示
        //$this->display("User/user");//跨目录查找另一个模版进行展示
    }
    
    
    
}

?>