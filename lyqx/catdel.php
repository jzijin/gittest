<?php
require('./lib/init.php');
$cat_id = $_GET['cat_id'];
if(!is_numeric($cat_id)) {
    error('sorry wrong');
} 
$sql = "select 1 from art where cat_id=$cat_id";
$rs = mQuery($sql);
if(mysqli_num_rows($rs) >= 1) {
    error('exist art');
}
$sql = "delete from cat where cat_id = $cat_id";
if(!mQuery($sql)) {
    error('失败');
} else {
    succ('ok');
}





?>