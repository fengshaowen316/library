<?php
include_once('header.php');
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
<div class="deleteBook">
    <h2>图书馆管理系统</h2>
    <form action="userborrowinfo.php" method="get">
    学生id：<input type="text" name="stuid" placeholder="学生id"><br><br>
    <button type="submit" name="stusearch">查询</button>
    </form>
</div>
</body>
</html>
