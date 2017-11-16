<?php
/** 
 * 连接数据库 
 */
function mConn() {
    static $conn = null;
    if($conn === null) {
        $cfg = include(ROOT.'/lib/conf.php');
        $conn = mysqli_connect($cfg['host'], $cfg['user'], $cfg['pwd'], $cfg['db']);
        mysqli_query($conn, 'set names '.$cfg['charset']);
    }
    return $conn;
}
/**
 * 执行查询函数
 */
function mQuery($sql) {
    $rs = mysqli_query(mConn(), $sql);
    if($rs === false) {
        mLog($sql."\n".mysqli_error(mConn()));
        return $rs;
    }
    mLog($sql);
    return $rs;
}

function mLog($log) {
    $path = ROOT.'/log/'.date('Ymd',time()).'.txt';
    $head = '----------------------------'."\n".date('Y/m/d H:i:s',time())."\n";
    file_put_contents($path, $head.$log."\n"."\n",FILE_APPEND);
}

/**
 * 查询select语句返回多行数据，适合用来查询多行数据
 */
function mGetAll($sql) {
    $rs = mQuery($sql);
    if(!$rs) {
        return false;
    } else {
        $list = array();
        while($row = mysqli_fetch_assoc($rs)) {
            $list[] = $row;
        }
    }
    return $list;
}

/**
 * 查询返回一行数据
 */
function mGetRow($sql) {
    $rs = mQuery($sql);
    return $rs?mysqli_fetch_assoc($rs) : false;
}

/**
 * 查询select语句并返回一个单元
 * 返回一个标量值未查到返回false
 */
function mGetOne($sql) {
    $rs = mQuery($sql);
    if($rs) {
        $row = mysqli_fetch_assoc($rs);
        return $row;
    } else {
        return false;
    }
}

/**
 * 拼接sql语句
 */
function mExec($table, $data, $act='insert',$where='0') {
    if($act == 'insert') {
        $sql = "insert into $table (";
        $sql .= implode(',', array_keys($data)) . ") values ('";
        $sql .= implode("','", array_values($data))."')";
        return mQuery($sql);
    } else if($act == 'update') {
        $sql = "update $table set ";
        foreach($data as $k=>$v) {
            $sql .= $k . "='" .$v . "',";
        }
        $sql = rtrim($sql ,',');
        $sql .= ' where '.$where;
        return mQuery($sql);
    }

}

function getLastId() {
    return mysqli_insert_id(mConn());
}

?>