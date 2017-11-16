<?php 
require('./lib/init.php');
$art_id = $_GET['art_id'];
if(!is_numeric($art_id)) {
    error('sorry wrong');
} 
// $sql = "select 1 from art where art_id = $art_id";
// $rs = mQuery($sql);
// if(mysqli_num_rows($rs) != 1) {
//     error('article no exist');
// }
$sql = "select * from art where art_id=$art_id";
$data = mGetRow($sql);

 if(!$data) {
     error('文章不存在');
 }
$sql = "delete from art where art_id = $art_id";
if(!mQuery($sql)) {
    error('失败');
} else {
    $sql = "update cat set num=num-1 where cat_id=$data[cat_id]";
    if(!mQuery($sql)) {
        error(mysqli_error(mConn()));
    }
    succ('ok');
}