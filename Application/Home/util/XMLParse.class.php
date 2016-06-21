<?php
/**
 * XML解析的工具类
 * @author Administrator
 *
 */
namespace Home\util;
class XMLParse{
    /**
     * SimpleXML解析
     * @return 数据库dsn 用户名 密码组成数组
     */
    public static function parseDBXML(){
        
        //得到根节点
        $sx =  simplexml_load_file(dirname(__DIR__)."/config/db.xml");
        // // echo $sx->getName();
        //获取某个节点下所有子节点  返回数组
        $children = $sx->children();
        // echo count($children);
        $pdoMysql = array((string)$children[0]->dsn, (string)$children[0]->username, (string)$children[0]->password);
        // $pdoOracle = array($dsn->item(1)->nodeValue, $username->item(1)->nodeValue, $password->item(1)->nodeValue);
        
        
        return $pdoMysql;
        
    }
    
    /**
     * 基于事件的Expat解析器
     */
    // $parser = xml_parser_create();
    // $str = file_get_contents("db.xml");
    // xml_parse_into_struct($parser, $str, $values,$index);
    // xml_parser_free($parser);
    // echo $values[2]["value"];
    // echo "<br />";
    // echo $values[4]["value"];
    // echo "<br />";
    // echo $values[6]["value"];
    
    
    
    
    /**
     * 基于DOM解析XML
     * 与JS中的DOM相同
     */
    // //初始化解析器
    // $document = new DOMDocument();
    // //$document->validateOnParse = true;
    
    // //加载xml文件
    // $document->load("db.xml");
    
    // //通过元素名称获取元素数组
    // $dsn = $document->getElementsByTagName("dsn");
    // $username = $document->getElementsByTagName("username");
    // $password = $document->getElementsByTagName("password");
    
    // $pdoMysql = array($dsn->item(0)->nodeValue, $username->item(0)->nodeValue, $password->item(0)->nodeValue);
    // $pdoOracle = array($dsn->item(1)->nodeValue, $username->item(1)->nodeValue, $password->item(1)->nodeValue);
    
    // echo $dsn->item(0)->nodeValue; //获取元素的文本内容
    // echo "<br />";
    // echo $username->item(0)->nodeValue; //获取元素的文本内容
    // echo "<br />";
    // echo $password->item(0)->nodeValue; //获取元素的文本内容
    
    
    // //获取根元素
    // $root = $document->documentElement;
    //echo $root->nodeName;
    // for($i=0;$i<$root->childNodes->length;$i++){
    //     echo $root->childNodes->item($i)->nodeValue."<br />";
    // }
    // echo $dsn->item(0)->getAttribute("id"); //获取id属性的值
    //echo $dsn->item(0)->nodeName; //获取元素名称
    
    /**
     * SimpleXML解析
     */
    
    //得到根节点
    //         $sx =  simplexml_load_file(dirname(__FILE__)."/config/db.xml");
    //         // // echo $sx->getName();
    
    //         //获取某个节点下所有子节点  返回数组
    //         $children = $sx->children();
    //         // echo count($children);
    //         $pdoMysql = array((string)$children[0]->dsn, (string)$children[0]->username, (string)$children[0]->password);
    // $pdoOracle = array($dsn->item(1)->nodeValue, $username->item(1)->nodeValue, $password->item(1)->nodeValue);
    
    
    // //遍历根节点的子节点
    // // foreach($sx as $c){
    // //     echo $c->attributes()["id"]."=".$c->getName()."<br />";
    // // }
    // //得到该节点下某个子节点的文本内容
    // echo $sx->dsn."<br />";
    // echo $sx->username."<br />";
    // echo $sx->password."<br />";
}
?>