<!--添加图书-->
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
<div class="addBook">
    <h2>图书馆管理系统</h2>
    <form action="addcheck.php" method="get">
        图书id：<input type="text" name="bookid" placeholder="图书id"><br><br>
        图书名：<input type="text" name="bookname" placeholder="图书名"><br><br>
        作者：<input type="text" name="author" placeholder="作者"><br><br>
        出版社：<input type="text" name="press" placeholder="出版社"><br><br>
        位置：<input type="text" name="position" placeholder="位置"><br><br>
        数量：<input type="text" name="num" placeholder="数量"><br><br>
        类型：<input type="text" name="catid" placeholder="类型"><br><br>
        <button type="submit" name="add">添加</button>
    </form>
</div>
</body>
</html>