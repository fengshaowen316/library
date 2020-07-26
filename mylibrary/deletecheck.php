<?php
include_once"conn.php";
$dbh->beginTransaction();
$id=$_GET['bookid'];
$str ="select bookid from book where bookid='$id' ";
$result=$dbh->query($str);
$query="delete from book where bookid = $id";
$stmt = $dbh->exec($query);
$query2 = "delete from book_return where bookid = '$id'";
$stmt2= $dbh->exec($query2);
$query3 = "select * from borrow where bookid = '$id'";
$stmt3 = $dbh->query($query3);
if($result->rowCount()==0){
	$dbh->rollBack();
	echo "<script>alert('您要删除的图书不存在!');location.href='deletebook.php'</script>";
}
elseif($stmt3->rowCount()==0){
	$dbh->commit();
	echo "<script>alert('删除成功！');location.href='deletebook.php'</script>";
}
else{
	$dbh->rollBack();
	echo "<script>alert('删除失败！该图书还未全部归还!');location.href='deletebook.php'</script>";
}
?>