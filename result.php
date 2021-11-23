<?php 
include('conn.php');
$sql = "SELECT username, password FROM User";
$result = $conn->query($sql);
$final = 0;
if(!empty($_REQUEST['login'])){
    include("login.php");
}
else if(!empty($_REQUEST['reg'])){
    include("reg.php");
}
switch ($final) {
    case 0:
        echo " 初始结果 " . "<br>";
        break;
    case 1:
        echo " 用户名或密码不能为空！ " . "<br>";
        break;
    case 2:
        echo " 登录成功 " . "<br>";
        break;
    case 3:
        echo " 密码错误 " . "<br>";
        break;
    case 4:
        echo " 不存在此用户 " . "<br>";
        break;
    case 5:
        echo " 此用户名已存在 " . "<br>";
        break;
    case 6:
        echo " 注册成功 " . "<br>";
        break; 
    case 7:
        echo "Error: " . $sql . "<br>" . $conn->error. "<br>";
        break; 
    default:
        echo " 默认结果 " . "<br>";
        break;
}
?>