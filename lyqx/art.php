<?php

require('./lib/init.php');
$art_id = $_GET['art_id'];
if(!is_numeric($art_id)) {
    error('文章的id不合法');
}
$sql = "select 1 from art where art_id = $art_id";
$rs = mQuery($sql);
if(mysqli_num_rows($rs) < 1) {
    error('文章不存在');
    exit;
}
$sql = "select art.*,cat.catname from art,cat where art.cat_id=cat.cat_id and art_id=$art_id";
$art = mGetRow($sql);
// $art['pic'] = ltrim($art['pic'], '/');
// echo $art['pic'];
$sql = "select * from cat";
$cats = mGetAll($sql);
$sql = "select *from comment where art_id=$art_id";
$comms = mGetAll($sql);
if(!empty($_POST)) {
    $comm['art_id'] = $art_id;
    $comm['nick'] = $_POST['username'];
    $comm['email'] = $_POST['email'];
    $comm['content'] = trim($_POST['content']);
    $comm['pubtime'] = time();
    $comm['ip'] = sprintf('%u', ip2long(getIp()));
    $rs = mExec('comment',$comm);
    if($rs) {
        //评论发布成功 在art将评论数加1
        $sql = "update art set comm=comm+1 where art_id=$art_id";
        mQuery($sql);
        //跳转到上一个页面
        $ref = $_SERVER['HTTP_REFERER'];
        header("Location: $ref");
    }
}
require('./view/front/art.html');
