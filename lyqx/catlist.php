<?php

require('./lib/init.php');

$sql = "select *from cat";
$cats = mGetAll($sql);
require(ROOT.'/view/admin/catlist.html');







?>