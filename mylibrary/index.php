<?php
include_once("conn.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图书馆管理系统</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="Login_Register">
    <h2>图书馆管理系统</h2>
    <form action="login.php" method="post">
        用户名：<input type="text" name="userid" placeholder="请输入用户id"><br><br>
        密&nbsp&nbsp&nbsp&nbsp码：<input type="password" name="password" placeholder="请输入密码"><br><br>
        <h3 id="borrowMan">用户：<input type="radio" name="operation" value="0" checked>管理员&nbsp&nbsp&nbsp<input type="radio" name="operation" value="1">学生</h3>
        <button type="submit" name="login">登录</button>
    </form>
</div>
</body>
