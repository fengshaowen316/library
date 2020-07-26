<?php
include_once"conn.php";
	$id=$_GET['bookid'];
	$bookname=$_GET['bookname'];
	$author=$_GET['author'];
	$press=$_GET['press'];
	$position=$_GET['position'];
	$sum_num=$_GET['num'];
	$lo_num=$_GET['num'];
	$catid=$_GET['catid'];
	$query2 = "insert into book values('$id','$bookname','$author','$press','$position','$sum_num','$lo_num','$catid')";
	$dbh->exec($query2);
	$t=$dbh->errorCode();
	if($t=='00000'){
		echo "<script>alert('添加成功！');location.href='addbook.php'</script>";
	}
	else{
		$str="添加失败！".$dbh->errorInfo()[2];
		echo "<script>alert('$str');location.href='addbook.php'</script>";
	}
?>