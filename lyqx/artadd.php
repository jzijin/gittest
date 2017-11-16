<?php

require('./lib/init.php');
if(empty($_POST)) {
    $sql = 'select catname,cat_id from cat';
    $cats = mGetAll($sql);
    require(ROOT.'/view/admin/artadd.html');
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
    if(!($_FILES['pic']['name'] == '') && $_FILES['pic']['error'] == 0) {
        $filename = createDir() . '/' .randStr() .getExt($_FILES['pic']['name']);
        if(move_uploaded_file($_FILES['pic']['tmp_name'] , ROOT .$filename)) {
            $art['pic'] = ltrim($filename,'/');
            // makeThumb($filename);
            $art['thumb'] = ltrim(makeThumb($filename),'/'); 
        }
    }
    $art['arttag'] = trim($_POST['tags']);
    $art['pubtime'] = time();

    if(!mExec('art', $art)) {
        error('fail post artical');
    } else {
        if($art['arttag'] == '') {
            $sql = "update cat set num=num+1 where cat_id=$art[cat_id]";
            mQuery($sql);
            succ('artical post ok');
        } else {
            $art_id = getLastId();
            $sql = "insert into tag (art_id,tag) values ";
            $tag = explode(',' , $art['arttag']);
            foreach($tag as $v) {
                $sql .="(" . $art_id . ",'" .$v . "') , ";
            }
            $sql = rtrim($sql , " ,");
            //echo $sql;
           // $sql = "insert into tag (art_id,tag) values ($art_id,"
           if(mQuery($sql)) {
               $sql = "update cat set num=num+1 where cat_id=$art[cat_id]";
               mQuery($sql);
               succ('文章添加成功');
           } else {
               //tag 添加失败 删除元文章
               $sql = "delete from art where art_id=$art_id";
               if(mQuery($sql)) {
                   $sql = "update cat set num=num-1 where cat_id=$art[cat_id]";
                   mQuery($sql);
                   error('文章添加失败');
               }
            }
            
        }
    }
    
}



