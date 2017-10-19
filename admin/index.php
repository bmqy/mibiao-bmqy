<?php include $_SERVER['DOCUMENT_ROOT'] .'/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] .'/admin/check_login.php' ?>
<?php
    $action = $_GET['action'];
    if($action === 'loginout'){
        setCookies('userId', '', time()-3600);
        redirect('/admin/');
    }

    $con = getConnection();
    $userId = $_COOKIE['userId'];
    $sql = 'SELECT username,realname FROM mb_user WHERE id='. $userId;
    $rs = mysqli_query($con, $sql);
    if($row = mysqli_fetch_array($rs)){
        $username = $row['username'];
        $realname = $row['realname'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php output( '后台管理'. getConfigValue('site_title')) ?></title>
<?php include RootPath .'/inc/common/css.php'?>

    <style>
        #body{
            overflow: hidden;
            position: absolute;
            top: 72px;
            left: 15px;
            right: 15px;
            bottom: 52px;
        }
        #bodyRight{
            height: 100%;
        }
        #footer{
            text-align: center;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div id="head">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        后台管理
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/admin/">首页 <span class="sr-only">(current)</span></a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a><i class="iconfont icon-huiyuan"></i>
                                <?php
                                output($username);
                                if(!empty($realname)){
                                    output('['. $realname .']');
                                }
                                ?>
                            </a>
                        </li>
                        <li><a href="/" title="前台首页" target="_blank"><i class="iconfont icon-shouye"></i> 首页</a>
                        <li><a href="?action=loginout" title="退出登录"><i class="iconfont icon-loginout"></i> 退出</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="body" class="row">
        <div id="bodyLeft" class="col-md-2">
            <div class="list-group">
                <a href="javascript:;" class="list-group-item active">
                    菜单列表
                </a>
                <a href="/admin/domain/list.php" target="iframe" class="list-group-item">
                    域名管理
                </a>
                <a href="/admin/system/users.php" class="list-group-item" target="iframe">
                    账户管理
                </a>
                <a href="/admin/links/list.php" class="list-group-item" target="iframe">
                    友链管理
                </a>
                <a href="/admin/registrar/list.php" class="list-group-item" target="iframe">
                    注册商管理
                </a>
                <a href="/admin/system/setting.php" target="iframe" class="list-group-item">
                    系统设置
                </a>
            </div>
        </div>
        <div id="bodyRight" class="col-md-10">
            <iframe id="iframe" name="iframe" src="domain/list.php" frameborder="0" width="100%" height="100%" scrolling="auto"></iframe>
        </div>
    </div>
    <div id="footer">
        <div class="">
            <p class="text-center">版权所有 &copy;2017 <?php getALinks('http://www.bmqy.net', '米表程序' ,null) ?></p>
        </div>
    </div>
</div>
<?php include RootPath .'/inc/common/js.php'?>
</body>
</html>