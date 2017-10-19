<?php
    date_default_timezone_set("Asia/Shanghai");

    // 网站配置信息
    define("RootPath", $_SERVER['DOCUMENT_ROOT']);
    define('ListFile', 'domain.txt', true); #米表文件
    define('PriceUnit', '元', true); #价格单位
    define('PagesSize', 15, true);  #每页显示条数
    define('PagesCount', 5, true); #分页显示数量

    // 必要文件
    include RootPath .'/inc/db.php';
    include RootPath .'/inc/function.php';
    include RootPath .'/inc/pages.php';
?>