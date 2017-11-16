<?php
require('./lib/init.php');
$comment_id = $_GET['comment_id'];
$sql = "select art_id from comment where comment_id=$comment_id";
$art_id = mGetOne($sql)['art_id'];
$sql = "delete from comment where comment_id=$comment_id";
mQuery($sql);
if($art_id) {
    $sql = "update art set comm=comm-1 where art_id=$art_id";
    mQuery($sql);
}
$ref = $_SERVER['HTTP_REFERER'];
header("Location: $ref");