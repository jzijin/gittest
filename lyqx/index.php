<?php
require('./lib/init.php');
if(isset($_GET['cat_id'])) {
    $where = " and art.cat_id=$_GET[cat_id]";
    //如果栏目下没有文章 重定向到首页
    $sql = "select 1 from art where art.cat_id=$_GET[cat_id]";
    $rs = mQuery($sql);
    if(mysqli_num_rows($rs) < 1) {
        header('Location: index.php');
    }
} else {
    $where = '';
}
//分页代码
$sql = "select count(*) from art where 1 $where";
$num = mGetOne($sql)['count(*)'];
$curr = isset($_GET['page']) ? $_GET['page'] : 1;
$cnt = 2 ;//每页显示条数
$max = ceil($num/$cnt);
$page = getPage($num , $curr , $cnt);
//上一页
$up = $curr-1;
if($up < 1) {
    $up = $curr;
}
$down = $curr+1;
if($down > $max) {
    $down = $max;
}

$sql = "select art.*,cat.catname from art,cat where art.cat_id=cat.cat_id $where order by art_id desc limit ". ($curr-1)*$cnt.','.$cnt;
$arts = mGetAll($sql);

$sql = 'select *from cat';
$cats = mGetAll($sql); 
require(ROOT. '/view/front/index.html');