<?php
require('./lib/init.php');
$cat_id = $_GET['cat_id'];
if(empty($_POST)) {
    if(!is_numeric($cat_id)) {
        error('sorry wrong');
    } 
    $sql = "select *from cat where cat_id=$cat_id";
    $cat = mGetRow($sql);
    require(ROOT.'/view/admin/catedit.html');
} else {
    $catname = trim($_POST['catname']);
    if(empty($catname)) {
        error('栏目不能为空');
    }
    $sql = "select 1 from cat where catname='$catname'";
    $rs = mQuery($sql);
    if(mysqli_num_rows($rs) >= 1) {
        error('栏目已经存在');
    }
    $sql = "update cat set catname='$catname' where cat_id=$cat_id";
    if(!mQuery($sql)) {
        error(mysqli_error(mConn()));
    } else {
        succ('ok i have done');
    }
}







?>