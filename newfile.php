<?php
header("Content-Type:text/html;charset=UTF-8");
echo "中国你好啊";
//phpinfo();

// $connect = mysql_connect("localhost","root","lovo1234");
// //第二步：选择数据库 相当于use 数据库名称; 进行切换
// mysql_select_db("sys", $connect);
// //第三步：书写sql语句
// $sql = "select * from tb_user";
// //第四步：执行上面的sql语句
// $result = mysql_query($sql, $connect);
// //第五步：处理结果
// if($result){
//     echo "查询到".mysql_num_rows($result)."行，每一行".mysql_num_fields($result)."列<br/>";
//     $datas = array();//二维数组
// //     $row = mysql_fetch_array($result, MYSQL_NUM)
//     echo "<table border='1' bordercolor='blue' cellspacing='0' width='100%'>";
//     echo "<tr><td>编号ID</td><td>用户名</td><td>姓名</td></tr>";
//     while($row = mysql_fetch_row($result)){
//         echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[4]</td></tr>";
//         //array_push($datas, $row);
//     }
//     echo "</table>";
// }
$pdo = new PDO("mysql:host=localhost;dbname=sys","root","lovo1234");
$ps = $pdo->prepare("select * from tb_user");
$ps->execute();
while ($row = $ps->fetch(PDO::FETCH_ASSOC)){
    echo $row["uid"]."--".$row["userName"]."--".$row["trueName"]."<br/>";
}