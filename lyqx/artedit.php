<?php
require('./lib/init.php');
$art_id = $_GET['art_id'];
if(empty($_POST)) {
    $sql = "select * from art where art_id = $art_id";
    $art = mGetOne($sql);
    if(!$art) {
        error('文章不存在');
    }
    $sql = "select * from cat";
    $cats = mGetAll($sql);
    $sql = "select *from tag where art_id=$art_id";
    $tag = mGetAll($sql);
    $tags = '';
    foreach($tag as $t) {
        $tags .= $t['tag'].',';
    }
    $tags = rtrim($tags, ',');
    require('./view/admin/artedit.html');
} else {
    $art['title'] = trim($_POST['title']);
    if(empty($art['title'])) {
        error('empty title');
    }

    $art['cat_id'] = $_POST['cat_id'];
    $art['content'] = trim($_POST['content']);
    if(empty($art['content'])) {
        error('empty content');
    }
    $art['lastup'] = time();
    $art['arttag'] = trim($_POST['tags']);
    $sql = "select 1 from art where art_id=$art_id";
    $rs = mQuery($sql);
    if(!$rs) {
        error('this artical is not exist');
    }

    if(!mExec('art', $art, 'update',"art_id=$art_id")) {
        error('fail post artical');
    } else {
        $sql = "delete from tag where art_id=$art_id";
        if(!mQuery($sql)) {
            error(mysqli_error(mConn()));
        }
        $sql = "insert into tag (art_id,tag) values ";
        $tag = explode(',' , $art['arttag']);
        foreach($tag as $v) {
            $sql .="(" . $art_id . ",'" .$v . "') , ";
        }
        $sql = rtrim($sql , " ,");
        if(!mQuery($sql)) {
            error(mysqli_error(mConn()));
        }
        succ('artical post ok');
    }
}