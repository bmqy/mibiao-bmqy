<?php
// 数据库信息
$db_server = 'localhost';
$db_userName = 'username';
$db_password = 'password';
$db_baseName = 'basename';
$db_port = '3301';
$db_char = "utf8" ;

// 连接数据库
function getConnection(){
    global $db_char,
           $db_server,
           $db_userName,
           $db_password,
           $db_baseName;
    $con = mysqli_connect($db_server,$db_userName,$db_password, $db_baseName);
    mysqli_set_charset( $con , $db_char );
    if(!$con) {
        return false;
    }
    else{
        return $con;
    }
}

// 关闭数据库连接
function closeConnection($con){
    if($con){
        mysqli_close($con);
    }
}

?>