<!--删除图书-->
<?php
include_once "conn.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图书馆管理系统</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div>
	<a href="view.php">返回</a>
</div>
<div class="deleteBook">
	<h2>图书馆管理系统</h2>
    <form action="deletecheck.php" method="get">
    图书id：<input type="text" name="bookid" placeholder="图书id"><br><br>
    <button type="submit" name="deletebook">删除</button>
    </form>
</div>
</body>
</html>
