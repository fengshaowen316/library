<?php
include_once('frontheader.php');
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
        $query = "select * from student where stuid='$id'";
        $stmt= $dbh->query($query);
        foreach ($stmt as $row){
            echo "<h3>ID&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['stuid']}</h3>";
            echo "<h3>姓名&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['name']}</h3>";
            echo "<h3>学院&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['collage']}</h3>";
            echo "<h3>学生类别&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['degree']}</h3>";
            echo "<h3>借阅图书&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['book_num']}</h3>";
        }
    ?>
    <?php

        $query = "select borrow.bookid,bookname,borrow_date,due_date 
                  from borrow,book 
                  where borrow.bookid = book.bookid and stuid = '$id'";
        $stmt= $dbh->query($query);

        echo "<table border='1px gray solid' width='600px' align='center' style='margin-top: 10px;' cellpadding='0' cellspacing='0'>";
        echo "<caption><h2>个人借阅信息界面</h2></caption>";
        echo "<tr style='line-height: 40px;'><th>图书号</th><th>图书名称</th><th>借书时间</th><th>应还时间</th><th>详情</th></tr>";
        $time = time();
        $borrow_date = date("Y-m-d",$time);
        $a = strtotime($borrow_date);
        foreach ($stmt as $row){
            echo "<tr style='text-align: center;line-height: 40px'>";
            echo "<td>".$row['bookid']."</td>";
            echo "<td>".$row['bookname']."</td>";
            echo "<td>".$row['borrow_date']."</td>";
            echo "<td>".$row['due_date']."</td>";
            $b = strtotime($row['due_date']);
            if($a<=$b){
                echo "<td><span style='color: #5cb85c'>正常</span></td>";
            }else{
                echo "<td><span style='color: #d43f3a'>逾期</span></td>";
            }
            echo "</tr>";
        }
        echo "</table>"
    ?>
</div>
</body>
</html>
