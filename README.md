## 总述

通过PHP连接MySQL数据库需要有以下关键的五个步骤

- 连接数据库
- 创建数据表
- 插入数据
- 获取数据
- 结束连接

而基于这五个步骤，即可做一个简易的登录注册系统

|                             首页                             |                         登录成功页面                         |
| :----------------------------------------------------------: | :----------------------------------------------------------: |
| ![image-20211115193930140](http://etherealdreamfuture.com/wp-imgs/image-20211115193930140.png) | ![image-20211115193940674](http://etherealdreamfuture.com/wp-imgs/image-20211115193940674.png) |

```treeview
├── conn.php
├── index.html
├── login.php
├── reg.php
└── result.php
```

`index.html`为首页

`result.php`为结果页

`conn.php`为连接数据库

`reg.php`和`login.php`分别处理注册和登录的业务逻辑

## 关键步骤

### 连接数据库

```php
$host='your-hostname';//域名
$dbUser='your-database-username';//数据库用户名
$dbPassword='your-database-user-password';//数据库用户密码
$dbName='your-database-name';//数据库名

// 创建连接
$conn = new mysqli($host, $dbUser, $dbPassword, $dbName);
 
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
echo "连接成功";
```

### 创建数据表

```php
 //使用 sql 创建数据表 User
 $sql = "CREATE TABLE User (
 id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
 username VARCHAR(30) NOT NULL,
 password VARCHAR(30) NOT NULL
 )";
 
 if ($conn->query($sql) === TRUE) {
     echo "Table MyGuests created successfully";
 } else {
     echo "创建数据表错误: " . $conn->error;
 }
```

### 插入数据

```php
$sql = "INSERT INTO User (username, password)
VALUES ('test', '123456')";
 
if ($conn->query($sql) === TRUE) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
```

### 获取数据

```php
$sql = "SELECT username, password FROM User";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        echo "用户名: " . $row["username"]. " - 密码: " . $row["password"]. "<br>";
    }
} else {
    echo "0 结果";
}

```

### 结束连接

```php
$conn->close();
```

## 系统代码

### index.html

```html
<html>
<head>
    <meta charset="utf-8">
</head>
<body> 

<h1>登录注册系统</h1>
<form action="result.php" method="post"> 
<table> 
<tr>
    <td>请输入你的用户名</td>
    <td><input type="text" name="username"></td>
</tr>
<tr>
    <td>请输入你的密码</td>
    <td><input type="text" name="password"></td>
</tr>
<tr> 
    <td colspan="2">
        <input type="submit" name="login" value="登录">
        <input type="submit" name="reg" value="注册">
    <td>
</tr> 
</table>
</form>
</body>

</html>
```

### result.php

```php
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
```

### login.php

```php
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
```

### reg.php

```php
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
```

### conn.php

```php
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
```



