<?php
$dsn = 'mysql:dbname=library;host=localhost;charset=utf8';
$user = 'root';//用户名
$pwd = 'root';//密码

try
{
    $dbh = new PDO($dsn, $user, $pwd);
}catch(PDOException $e)
{
    echo '数据库连接错误'.$e->getMessage();
    exit;
}
?>