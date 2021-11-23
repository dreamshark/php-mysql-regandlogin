<?php 
$arg1=$_REQUEST['username']; 
$arg2=$_REQUEST['password'];
$flag=0;
if($arg1=="" || $arg2==""){
    $flag=1;
    $final =1;
    // echo " 用户名或密码不能为空！ " . "<br>";
}
else if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        if($arg1==$row["username"]){
            $final=5;
                // echo " 此用户名已存在 " . "<br>";
            break;
        }
    }
}
if(!$flag){

$sql = "INSERT INTO User (username, password)
VALUES ('" . $arg1 . "','" . $arg2 . "')";

    //  echo $sql;
    if ($conn->query($sql) === TRUE) {
        $final=6;
        // echo " 注册成功 " . "<br>";
    } else {
        $final=7;        
        // echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>