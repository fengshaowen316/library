<!--用户登录判断界面-->
<?php
session_start();
include_once("conn.php");
if(isset($_POST['login'])){//点击登录按钮
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $num = $_POST['operation'];
    if($num==0){
        $strQuery = "select * from adminuser where adminid = '$userid' and password ='$password'";
        $stmt= $dbh->query($strQuery);
        if($stmt->rowCount()==0){
            echo "账号或密码错误，请重新输入！";
        }else{                      //账号密码正确，成功进入系统       
            $_SESSION['id'] = $userid;
            header('Location:admin.php');
        }
    }
    else{
        $strquery = "select * from student where stuid = '$userid' and password = '$password'";
        $stmt=$dbh->query($strquery);
        if($stmt->rowCount()==0){
            echo "账号或密码错误，请重新输入！";
        }
        else{
            $_SESSION['id'] = $userid;
            header('Location:frontadmin.php');
        }
    }

}
else{
    echo "请输入用户名和密码！";
}
?>
