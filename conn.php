<?php
$host='your-hostname';//域名
$dbUser='your-database-username';//数据库用户名
$dbPassword='your-database-user-password';//数据库用户密码
$dbName='your-database-name';//数据库名

// 创建连接
$conn = new mysqli($host, $user, $password, $dbName);
echo "正在尝试连接 ".$dbName." 数据库" . "<br>";
 
// 检测连接
if ($conn->connect_error) {
    die("连接数据库失败: " . $conn->connect_error . "<br><br>");
} 
echo "连接数据库成功" . "<br><br>";
?>