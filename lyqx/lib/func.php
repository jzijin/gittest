<?php
/**
 * 提示函数
 */
function succ($msg = '成功') {
    $res = 'success';
    include(ROOT.'/view/front/info.html');
    exit;
}
function error($msg = '失败') {
    $res = 'fail';
    include(ROOT.'/view/front/info.html');
    exit;
}

/**
 * 获取来访者的IP
 */
function getIp() {
    static $realip = null;
    if($realip !== null) {
        return $realip;
    }
    if(getenv('HTTP_X_FORWADED_FOR')) {
        $realip = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('HTTP_CLIENT_IP')) {
        $realip = getenv('HTTP_CLIENT_IP');
    } else {
        $realip = getenv('REMOTE_ADDR');
    }
    return $realip;
}
/**
 * 分页类
 * $num 文章总数
 * $curr 当前页数
 * $cnt 每一页显示多少条文章
 */
function getPage($num, $curr, $cnt) {
    $max = ceil($num/$cnt);
    $left = max($curr-2, 1);
    $right = $left+4;
    $right = min($max, $right);
    $left = $right - 4;
    $left = max($left, 1);
    for($i=$left; $i<=$right; $i++) {
        $_GET['page'] = $i;
        $pages[$i] = http_build_query($_GET);
    }
    return $pages;
}
//生成随机字符串
//int $num 生成的随机字符串个数

function randStr($num=6) {
    $str = str_shuffle('abcedfghjkmnpqrstuvwxyzABCEDFGHJKMNPQRSTUVWXYZ23456789');
    return substr($str , 0 ,$num);
}

//创建目录

function createDir() {
    $path = '/upload/' .date('Y/m/d');
    $fpath = ROOT . $path;
    if(is_dir($fpath) || mkdir($fpath , 0777 , true)) {
        return $path;
    } else {
        return false;
    }
}

//获取文件后缀

function getExt($filename) {
    return strrchr($filename , '.');
}
 //生成缩略图
//str oimg 
//int $sw 生成缩略图的宽 int $sh
//返回路径
function makeThumb($oimg , $sw=200 ,$sh=200) {
    //缩略图存放的路径和文件名称
    $simg = dirname($oimg) . '/' . randStr() . '.png';
    //获取大图和缩略图的绝对路径
    $opath = ROOT . $oimg;
    $spath = ROOT . $simg;

    //创建小画布；
    $spic = imagecreatetruecolor($sw , $sh);
    //创建白色背景
    $white = imagecolorallocate($spic , 255, 255, 255);
    imagefill($spic ,0 , 0 , $white);

    //获取大图信息
    list($bw , $bh , $btype) = getimagesize($opath);
    $map = array(
        1=>'imagecreatefromgif',
        2=>'imagecreatefromjpeg',
        3=>'imagecreatefrompng',
        15=>'imagecreatefromwbmp'
    );
    if(!isset($map[$btype])) {
        return false;
    }
    $opic = $map[$btype]($opath);//大图资源
    //计算缩略比
    $rate = min($sw/$bw , $sh/$bh);
    $zw = $bw * $rate;//最终返回的缩略小兔
    $zh = $bh * $rate;

    imagecopyresampled($spic , $opic , ($sw-$zw)/2 , ($sh-$zh)/2 , 0 , 0 , $zw , $zh , $bw , $bh);
    imagepng($spic , $spath);
    imagedestroy($spic);
    imagedestroy($opic);
    return $simg;
}

/**
 * 检测是否登录
 */
function acc() {
    return isset($_COOKIE['name']);
}

?>