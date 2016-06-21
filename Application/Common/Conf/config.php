<?php
//应用配置 全局配置
return array(
	//'配置项'=>'配置值'
	//'SESSION_AUTO_START'=>false,
	
    
	
    //修改默认的模版目录结构为  控制器类名称_操作方法名.html
    //'TMPL_FILE_DEPR'=>'_',
    
    //数据库PDO配置
    //"DSN"=>"mysql:host=localhost;dbname=sys",
//     "PDOOPTIONS"=>array(
//         \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION
//     ),
    
//     数据库连接信息-字符串格式
//     'DB_DSN' => "mysql://root:lovo1234@localhost:3306/sys#utf8",
//     数据库连接信息-数组格式
//     "DB_ARRAY"=>array(
//         'db_type'   =>  'mysql',
//         'db_host'   =>  'localhost',
//         'db_user'   =>  'root',
//         'db_pwd'    =>  'lovo1234',
//         'db_port'   =>  3306,
//         'db_name'   =>  'sys',
//         'db_charset'=>  'utf8'
//     ),
    
    
    
    /* 数据库设置 Model的数据库连接配置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型   必须
    'DB_USER'               =>  'root',      // 用户名         必须
    'DB_PWD'                =>  'lovo1234',  // 密码            必须  
    'DB_NAME'               =>  'sys',       // 数据库名      必须
    'DB_HOST'               =>  'localhost', // 服务器地址   非必须 默认为本机
    'DB_PORT'               =>  '3306',      // 端口            非必须 默认3306
//     'DB_PREFIX'             =>  '',          // 数据库表前缀 非必须
    'DB_PARAMS'          	=>  array(
        \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION
    ),     // 数据库连接参数 非必须   
//     'DB_DEBUG'  			=>  TRUE,        // 数据库调试模式 开启后可以记录SQL日志 非必须
//     'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存 非必须
//     'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8 非必须
//     'DB_DEPLOY_TYPE'        =>  0,           // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器) 非必须
//     'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效 非必须
//     'DB_MASTER_NUM'         =>  1,           // 读写分离后 主服务器数量 非必须
//     'DB_SLAVE_NO'           =>  '',          // 指定从服务器序号 非必须
    
    
    
    
    
    
    //分页查询相关配置
    "PAGENO"=>1,
    "PAGESIZE"=>10,
    
    //控制器级别 默认为1
    //"CONTROLLER_LEVEL"=>2,
    
    //Action参数绑定
    //'URL_PARAMS_BIND' => true
    //设置参数绑定方式为按顺序绑定 默认是按变量名称绑定
    //'URL_PARAMS_BIND_TYPE' => 1
    
    
    //设置URL模式为rewrite模式
    //'URL_MODEL'=>2
    
    //开启路由
    'URL_ROUTER_ON'=>true,
    'URL_ROUTE_RULES'=>array(
        ///:userName/:userPass
        'tttt/:userName/:userPass'  =>  "Home/Index/index",//静态的规则路由和动态的相结合
//         '/^bbb\/(\d{4})\/(\d{2})\/(\d{2})$/'=>"Home/Index/test"
        'bbb/:year/:month/:date'=>"Home/Index/test"
    ),
    'URL_MAP_RULES'=>array(
        'ttt'   =>  "Home/Index/index",//静态的规则路由
        'login' =>  "Home/User/login",
        'aaa'   =>  array("http://www.baidu.com",302)
    )
    
    
    
    
    
    
);