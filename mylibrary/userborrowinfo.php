<?php
include_once("header.php");
include_once("conn.php");
if(!is_null($_GET['stuid'])){
    $id=$_GET['stuid'];
}
else{
    echo "<script>alert('请输入学生id');location.href='usermanager.php'</script>";
}
?>

<?php

$query = "select bookid,bookname,borrow_date,due_date 
          from borrow_view
          where stuid ='$id'";
$stmt= $dbh->query($query);
$query2 = "select name,collage,degree from student where stuid=$id";
$result = $dbh->query($query2);
if($result->rowCount()>0){
    foreach ($result as $row){
        echo "<h3>姓名&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['name']}</h3>";
        echo "<h3>学院&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['collage']}</h3>";
        echo "<h3>学生类别&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp{$row['degree']}</h3>";
    }
    echo "<table border='1px gray solid' width='600px' align='center' style='margin-top: 10px;' cellpadding='0' cellspacing='0'>";
    echo "<caption><h2>学生借阅信息界面</h2></caption>";
    echo "<tr style='line-height: 40px;'><th>图书id</th><th>图书名称</th><th>借书时间</th><th>应还时间</th><th>逾期情况</th></tr>";
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
    echo "</table>";
}
else{
    echo "<script>alert('不存在该学生!');location.href='usermanager.php'</script>";
}
?>
