<?php 
$arg1=$_REQUEST['username']; 
$arg2=$_REQUEST['password'];
$flag=0;
if($arg1=="" || $arg2==""){
    $final =1;
    // echo " 用户名或密码不能为空！ " . "<br>";
}
else if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        if($arg1==$row["username"]){
            $flag=1;
            if($arg2==$row["password"])
                $final =2;
                // echo " 登录成功 " . "<br>";
            else
                $final =3;
                // echo " 密码错误 " . "<br>";
            break;
        }
    }
    if(!$flag)
        $final =4;
        // echo " 不存在此用户 " . "<br>";
} else {
    $final =4;
    // echo " 不存在此用户 " . "<br>";
}
?>