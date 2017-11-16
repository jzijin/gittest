<?php
require('./lib/init.php');
if(empty($_POST)) {
    require(ROOT. '/view/admin/login.html');
} else {
    $name = trim($_POST['username']);
    $password = trim($_POST['password']);
    $sql = "select 1 from user where name='$name' and password='$password'";
    $rs = mQuery($sql);
    if(!mysqli_num_rows($rs) == 1) {
        error('your name or password is wrong');
    } else {
        setcookie('name', $name);
        header('Location: artlist.php');
    }
}