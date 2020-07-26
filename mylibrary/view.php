<?php
include_once('header.php');
include_once("conn.php");
?>
<div style="width:100%;text-align:center">
<form action="view.php" method="get">
        <input type="text" id="input"  placeholder="输入搜索内容" name="keyword" style="width:150px">
        <h5 id="searchway">查询方式：<input type="radio" name="operation" value="0" checked>ID查询&nbsp&nbsp&nbsp<input type="radio" name="operation" value="1">书名查询</h3>
        <button type="submit" name="search">搜索</button>
</form><br><br>
<a href="addbook.php">新书上架</a>
<a href="deletebook.php">删除图书</a>
</div>
<?php
if(isset($_GET['keyword'])){
    if($_GET['operation']==0){//按id查询
        $query = "select * from book where bookid=".$_GET['keyword'];
        $stmt= $dbh->query($query);
    }
    else{//按书名查询
        $query= "select * from book where bookname like '%".$_GET['keyword']."%'";
        $stmt=$dbh->query($query);
    }
}
else{
    $query = "select * from book";
    $stmt = $dbh->query($query);
}
?>
<div id="FanYe">
    <ul>
        <?php
            $count = 0;
            echo "<h2 style='text-align: center'>图书详情</h2>";
            foreach ($stmt as $row){
                echo "<li>";
                echo "图书id：{$row['bookid']}&nbsp&nbsp&nbsp&nbsp&nbsp";
                echo "图书名：{$row['bookname']}&nbsp&nbsp&nbsp&nbsp&nbsp";
                echo "作者：{$row['author']}&nbsp&nbsp&nbsp&nbsp&nbsp";
                echo "位置: {$row['position']}&nbsp&nbsp&nbsp&nbsp&nbsp";
                echo "可借复本：{$row['lo_num']}&nbsp&nbsp&nbsp&nbsp&nbsp";
                echo "</li><br>";
                if($count>10){
                    $count=0;
                }else{
                    $count++;
                }
            }

        ?>
    </ul>

</div>
<?php
$string = <<<EOT
<div class="layui-box layui-laypage layui-laypage-molv" id="layui-laypage-1">

            <a href="javascript:" class="layui-laypage-first" data-page="0">首页</a>
            <a href="javascript:" class="layui-laypage-pre" data-page="2">上一页</a>
            <a href="javascript:" class="layui-laypage-next" data-page="2">下一页</a>
            <a href="javascript:" class="layui-laypage-last" data-page="2">末页</a>
</div>
EOT;
echo $string;
?>