<?php
include_once("conn.php");
include_once("frontheader.php");
if(isset($_POST['ok'])){
    if(is_null($_POST['bookid'])){
        echo "<script>alert('输入不能为空!');location.href='borrowmanager.php'</script>";
    }
    else{
        $num = $_POST['operation'];
        $userid = $_SESSION['id'];
        $bookid = $_POST['bookid'];
        if($num==0){//借书操作
            
            $time = time();
            $borrow_date = date("Y-m-d",$time);
            $due_date = date("Y-m-d",strtotime("+1 month"));
            $query="call borrowbook('$userid','$bookid','$borrow_date','$due_date',@strresult)";
            $dbh->query($query);
            $query2 = "select @strresult";
            $jieguo2=$dbh->query($query2)->fetch();
            echo "<script>alert('$jieguo2[0]');location.href='borrowmanager.php'</script>";
        }else{//还书操作
            $time = time();
            $back_date = date("Y-m-d",$time);
            $query = "call returnbook('$userid','$bookid','$back_date',@strresult)";
            $dbh->query($query);
            $query2 = "select @strresult";
            $jieguo = $dbh->query($query2)->fetch();
            echo "<script>alert('$jieguo[0]');location.href = 'borrowmanager.php'</script>";
        }
    }
}
if (isset($_POST['ok2'])){
    header("Location:borrowmanager.php");
}
?>