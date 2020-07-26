<!--管理员登录管理界面主页面-->
<?php
include_once('header.php');
include_once("conn.php");
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>图书馆管理系统</title>
    <link href="style/style.css" rel="stylesheet" type="text/css">

</head>
<body>
<div id="userinfo">
    <h2>个人信息</h2>
    <?php
        $id = $_SESSION['id'];
        $query = "select * from adminuser where adminid='$id'";
        $stmt= $dbh->query($query);
        foreach ($stmt as $row){
            echo "<h3>ID&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['adminid']}</h3>";
            echo "<h3>姓名&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['adname']}</h3>";
            echo "<h3>邮箱&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['email']}</h3>";
        }
    ?>
</div>
</body>
</html>

