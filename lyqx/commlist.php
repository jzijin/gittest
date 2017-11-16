<?php

require('./lib/init.php');
$sql = "select *from comment order by comment_id desc";
$comms = mGetAll($sql);
require('./view/admin/commlist.html');