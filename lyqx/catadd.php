<?php
require('./lib/init.php');
if(empty($_POST)) {
    require(ROOT.'/view/admin/catadd.html');
} else {
    $catname = trim($_POST['catname']);
    if(empty($catname)) {
        exit('栏目不能为空');
    }
    $sql = "select 1 from cat where catname='$catname'";
    $rs = mQuery($sql);
    if(mysqli_num_rows($rs) >= 1) {
        error('栏目已经存在');
    }
    $sql = "insert into cat (catname) values ('$catname')";
    if(!mQuery($sql)) {
        error(mysqli_error(mConn()));
    } else {
        succ('ok i have done!');
    }
}




?>