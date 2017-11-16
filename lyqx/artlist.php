<?php

require('./lib/init.php');
if(!acc()) {
    header('Location: login.php');
    exit;
}
$sql = 'select art.*,cat.catname from art,cat where art.cat_id = cat.cat_id order by art.art_id desc';
$arts = mGetAll($sql);
require(ROOT.'/view/admin/artlist.html');






