<?php
namespace Home\util;

/**
 * 封装增、删、改、查四种操作为两个个通用方法
 * @author Administrator
 *
 */
class DBUtil{
    
    //保存pdo连接数据的dsn、用户名、密码的数组
    private $pdoMysql;
    
    //PDO对象
    private $pdo;
    
    public function __construct(){
//         $this->pdoMysql = XMLParse::parseDBXML();
//         $this->pdo = new \PDO($this->pdoMysql[0], $this->pdoMysql[1], $this->pdoMysql[2], array(\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION));
        $this->pdo = new \PDO(C("DB_TYPE").":host=".C("DB_HOST").";dbname=".C("DB_NAME"), C("DB_USER"), C("DB_PWD"), C("DB_PARAMS"));
    }
    
    public function getPdo(){
        return $this->pdo;
    }
    
    /**
     * 通用的DML语句执行方法
     * @param unknown $sql 将要执行的DML语句字符串，可以带有问号占位符
     * @param array $params 可选参数，当$sql中有问号时，此参数必填；
     *   问号个数必须与此数组内元素个数相同且注意顺序。
     *   若$sql中无问号则此可不填或者填一个null、array()
     * @return true表示执行成功 false表示执行失败
     */
    public function executeDML($sql, array $params=null){
        $b = true;
        try{
            $ps = $this->pdo->prepare($sql);
            //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params != null && count($params) > 0){
                $ps->execute($params);
            }else{
                $ps->execute();
            }
//             $ps->closeCursor();//关闭预处理对象
        }catch(\PDOException $e){
            $b = false;
        }
        $this->free($this->pdo, $ps);
        return $b;
    }
    
    /**
     * 通用的执行查询语句的方法-并且分页
     * @param string $sql 将要执行的查询语句字符串 可以带问号
     * @param array $params 可选参数，当$sql中有问号时，此参数必填；
     *   问号个数必须与此数组内元素个数相同且注意顺序。
     *   若$sql中无问号则此参数可不填或者填一个null、array()
     * @param int $fetchStyle 可选参数，提取数据的方式，
     *   默认为PDO::FETCH_NUM，可选值有PDO::FETCH_ASSOC或PDO::FETCH_OBJ
     * @param string $className 可选参数，当$fetchStyle的值为
     *   PDO::FETCH_OBJ时此参数要求必须填入实体类的全名（命名空间\类名）；
     *   当$fetchStyle的值不为PDO::FETCH_OBJ时此参数可不填。
     * @return array 当查询有数据则返回数据组成的数组，当无数据时返回array()
     */
    public function executeQuery($sql, array $params=null, $fetchStyle=\PDO::FETCH_NUM, $className=null){
        $datas = array();
        try{
            $ps = $this->pdo->prepare($sql);
            //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params != null && count($params) > 0){
                $ps->execute($params);
            }else{
                $ps->execute();
            }
            if($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                $datas = $objs;
            }else{
                $objs = array();
                while($obj = $ps->fetch($fetchStyle)){
                    array_push($objs, $obj);
                }
                $datas = $objs;
//                 $datas = $ps->fetchAll($fetchStyle);
            }
        }catch(\PDOException $e){
            //如果方法执行抛异常，将返回一个空数组
        }
        $this->free($this->pdo, $ps);
        return $datas;
    }
    
    /**
     * 通用的执行查询语句的方法-并且分页-不能带子查询
     * @param string $dataSql 将要执行的查询语句字符串 可以带问号
     * @param int $pageNo 当前页码 最小为1
     * @param int $pageSize 当前页显示多少行数据
     * @param array $params 可选参数，当$sql中有问号时，此参数必填；
     *   问号个数必须与此数组内元素个数相同且注意顺序。
     *   若$sql中无问号则此参数可不填或者填一个null、array()
     * @param int $fetchStyle 可选参数，提取数据的方式，
     *   默认为PDO::FETCH_NUM，可选值有PDO::FETCH_ASSOC或PDO::FETCH_OBJ
     * @param string $className 可选参数，当$fetchStyle的值为
     *   PDO::FETCH_OBJ时此参数要求必须填入实体类的全名（命名空间\类名）；
     *   当$fetchStyle的值不为PDO::FETCH_OBJ时此参数可不填。
     * @return array 关联数组 索引total表示总共有多少行，索引rows表示当前页的数据数组
     */
    public function executePageQuery($dataSql, $pageNo, $pageSize, array $params=null, $fetchStyle=\PDO::FETCH_NUM, $className=null){
        //total   rows
        $page = array("total"=>0,"rows"=>array());
        try{
            //查询当前页的数据
            $ps = $this->pdo->prepare($dataSql);
            //手动绑定limit后面的两个参数
            $begin = ($pageNo-1)*$pageSize;
            //统计原sql中包含多少个问号  最少都要包含2个问号（limit后面的）
            $countWenhao = 0;
            str_replace("?", "?", $dataSql, $countWenhao);
            $ps->bindParam($countWenhao-1, $begin, \PDO::PARAM_INT);
            $ps->bindParam($countWenhao, $pageSize, \PDO::PARAM_INT);
            
            //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params != null && count($params) > 0){
                $ps->execute($params);
            }else{
                $ps->execute();
            }
            if($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                $page['rows'] = $objs;
            }else{
                $page['rows'] = $ps->fetchAll($fetchStyle);
            }
            
            
            
            //查询总共有多少行数据
            $index1 = strpos($dataSql, "from");
            $index2 = strpos($dataSql, "limit");
            $countSql = "select count(*) ".substr($dataSql, $index1, $index2-$index1);
            $ps = $this->pdo->prepare($countSql);
            if($params != null && count($params) > 0){
                $ps->execute($params);
            }else{
                $ps->execute();
            }
            $page["total"] = $ps->fetch(\PDO::FETCH_NUM)[0];
        }catch(\PDOException $e){
            //如果方法执行抛异常，将返回一个空数组array();
        }
        $this->free($this->pdo, $ps);
        return $page;
    }
    
    /**
     * 通用的执行查询语句的方法-并且分页-可以带子查询 也可以不带子查询
     * @param string $dataSql 将要执行的查询语句字符串 可以带问号
     * @param string $countSql 查询数据行数的sql语句，它的筛选条件必须与$dataSql相同。
     * @param int $pageNo 当前页码 最小为1
     * @param int $pageSize 当前页显示多少行数据
     * @param array $params 可选参数，当$sql中有问号时，此参数必填；
     *   问号个数必须与此数组内元素个数相同且注意顺序。
     *   若$sql中无问号则此参数可不填或者填一个null、array()
     * @param int $fetchStyle 可选参数，提取数据的方式，
     *   默认为PDO::FETCH_NUM，可选值有PDO::FETCH_ASSOC或PDO::FETCH_OBJ
     * @param string $className 可选参数，当$fetchStyle的值为
     *   PDO::FETCH_OBJ时此参数要求必须填入实体类的全名（命名空间\类名）；
     *   当$fetchStyle的值不为PDO::FETCH_OBJ时此参数可不填。
     * @return array 关联数组 索引total表示总共有多少行，索引rows表示当前页的数据数组
     */
    public function executePageSubQuery($dataSql, $countSql, $pageNo, $pageSize, array $params=null, $fetchStyle=\PDO::FETCH_NUM, $className=null){
        //total   rows
        $page = array("total"=>0,"rows"=>array());
        try{
            //查询当前页的数据
            $ps = $this->pdo->prepare($dataSql);
            //手动绑定limit后面的两个参数
            $begin = ($pageNo-1)*$pageSize;
            //统计原sql中包含多少个问号  最少都要包含2个问号（limit后面的）
            $countWenhao = 0;
            str_replace("?", "?", $dataSql, $countWenhao);
            if($countWenhao > 0){
                $ps->bindParam($countWenhao-1, $begin, \PDO::PARAM_INT);
                $ps->bindParam($countWenhao, $pageSize, \PDO::PARAM_INT);
            }
    
            //参数数组不为空 并且元素个数大于0 需要绑定参数
            if($params != null && count($params) > 0){
                $ps->execute($params);
            }else{
                $ps->execute();
            }
            if($fetchStyle == \PDO::FETCH_OBJ){
                $objs = array();
                while($obj = $ps->fetchObject($className)){
                    array_push($objs, $obj);
                }
                $page['rows'] = $objs;
            }else{
                $page['rows'] = $ps->fetchAll($fetchStyle);
            }
    
    
    
            //查询总共有多少行数据
            $ps = $this->pdo->prepare($countSql);
            if($params != null && count($params) > 0){
                $ps->execute($params);
            }else{
                $ps->execute();
            }
            $page["total"] = $ps->fetch(\PDO::FETCH_NUM)[0];
        }catch(\PDOException $e){
            //如果方法执行抛异常，将返回一个空数组array();
        }
        $this->free($this->pdo, $ps);
        return $page;
    }
    
    /**
     * 释放内存
     * @param unknown $pdo
     * @param unknown $ps
     */
    public function free($pdo, $ps){
        if(null != $pdo){
            $pdo = null;
        }
        if(null != $ps){
            $ps = null;
        }
    }
    
}

?>