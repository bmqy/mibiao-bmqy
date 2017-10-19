<?php include $_SERVER['DOCUMENT_ROOT'] .'/inc/config.php' ?>
<?php
    $con = getConnection();
    $id = $_GET['id'];
    $contactName = getConfigValue('site_contact_name');
    $contactMobile = getConfigValue('site_contact_mobile');
    $contactEmail = getConfigValue('site_contact_email');
    $contactQQ = getConfigValue('site_contact_qq');
    $contactWechat = getConfigValue('site_contact_wechat');

    $sql = 'SELECT * FROM mb_domain WHERE id ='. $id;
    $rs = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($rs)){
        $domainName = $row['title'];
        $domainPrice = $row['price'];
        $domainDesc = $row['description'];
        $domainIcon = $row['icon'];
        $domainRegistrarId = $row['registrarId'];
        $domainCreatedTime = $row['domainCreatedTime'];
        $domainExpirationTime = $row['domainExpirationTime'];
        $domainUpdatedDate = $row['domainUpdatedDate'];
        $domainCost = $row['cost'];
        $domainSaleStatus = $row['saleStatus'];
        $domainViewsCount = $row['viewsCount'];
        $domainLikesCount = $row['likesCount'];
    }

    updateDomainViewsCount($id);

    if(empty($domainCreatedTime) or empty($domainExpirationTime) or empty($domainUpdatedDate)){
        $a = new getDomainWhois($domainName);
        if(empty($domainCreatedTime)){
            $domainCreatedTime = date('Y-m-d H:s:i', strtotime($a->getCreatedDate()));

            $sql = 'UPDATE mb_domain SET domainCreatedTime="'. $domainCreatedTime .'" WHERE id='. $id;
            mysqli_query($con, $sql);
        }
        if(empty($domainExpirationTime)){
            $domainExpirationTime = date('Y-m-d H:s:i', strtotime($a->getExpiresDate()));

            $sql = 'UPDATE mb_domain SET domainExpirationTime="'. $domainExpirationTime .'" WHERE id='. $id;
            mysqli_query($con, $sql);
        }
        if(empty($domainUpdatedDate)){
            $domainUpdatedDate = date('Y-m-d H:s:i', strtotime($a->getUpdatedDate()));

            $sql = 'UPDATE mb_domain SET domainUpdatedDate="'. $domainUpdatedDate .'" WHERE id='. $id;
            mysqli_query($con, $sql);
        }
    }

    mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php output($domainName . getConfigValue('site_title_symbol') . getConfigValue('site_title') .'|'. getConfigValue('site_subTitle')) ?></title>
    <?php include dirname(__FILE__)."/inc/common/css.php"?>
    <link rel="stylesheet" href="http://www.jq22.com/demo/GoogleDesign20161230/waves.min.css?v=0.7.4">
    <link rel="stylesheet" href="http://www.jq22.com/demo/jQueryTxNav201706242328/css/gooey.min.css">
    <link rel="stylesheet" href="lib/layui-v1.0.9/layui/css/layui.css">
    <style>
        html,body{
            height: 100%;
        }
        body { background-image: url(<?php output(getBingBgimg()) ?>); background-repeat: no-repeat; background-position: center; background-size: cover; }

        #detail{
            min-width: 300px;
            max-width: 600px;
            height: auto;
            margin: 15% auto;
            -webkit-box-shadow: 0 0 20px 1px #455a64;
            -moz-box-shadow: 0 0 20px 1px #455a64;
            box-shadow: 0 0 20px 1px #455a64;
            background-color: rgba(255,255,255,0.65);
        }
        #detail .list-group-item {
            background-color: rgba(255,255,255,0.2);
            border: 1px solid rgba(0,0,0,0.2);
            font-family: Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;
            font-size: 16px;
            color: #455a64;
            text-shadow: 1px 1px 1px rgba(255,255,255,0.45),-1px -1px 1px rgba(115,115,115,0.6),0 0 2px rgba(115,115,115,0.6),1px 1px 30px #455a64;
            line-height: 1.5;
        }
        #detail .panel-footer {
            background-color: rgba(255,255,255,0.36);
        }

        .navimenu {
            min-width: 100px;
            min-height: 50px;
            height: 50px;
            margin: 0;
            padding-top: 0;
            padding-left: 0;
        }
        .waves-circle {
            width: 50px;
            height: 50px;
            font-size: 16px;
            line-height: 50px;
        }
        #gooey-h a.gooey-menu-item i { font-size: 18px;color: #fff; }
        #gooey-h a.gooey-menu-item:nth-of-type(1) i { background: #ff6400; }
        #gooey-h a.gooey-menu-item:nth-of-type(2) i { background: #d54f38; }
        #gooey-h a.gooey-menu-item:nth-of-type(3) i { background: #eb4d7e; }
        #gooey-h a.gooey-menu-item:nth-of-type(4) i { background: #d138c8; }
        #gooey-h a.gooey-menu-item:nth-of-type(5) i { background: #bd73ff; }
        #gooey-h a.gooey-menu-item:nth-of-type(6) i { background: #ff6666; }

        #gooeySVG0 {
            width: 320px;
            height: 40px;
        }

        #bingBgTips{
            text-align: right;
            font-size: 12px;
            color: #999;
            text-shadow: 1px 1px 10px rgba(255,255,255,0.45);
            position: absolute;
            right: 10px;
            bottom: 10px;
        }
        #bingBgTips a{
            color: #999;
        }

        #bdggw{
            width: 200px;
            height: 50px;
            overflow: hidden;
        }

        @media (max-width:1024px) {
            #detail{
                min-width: 300px;
                max-width: 600px;
            }
            #detail .list-group-item {
                font-size: 18px;
                line-height: 1.5;
            }
            .waves-circle {
                width: 45px;
                height: 45px;
                font-size: 14px;
                line-height: 45px;
            }
        }
        @media (max-width:750px) {
            #detail{
                min-width: 290px;
                max-width: 320px;
            }
            #detail .list-group-item {
                font-size: 14px;
                line-height: 1;
            }
            .waves-circle {
                width: 35px;
                height: 35px;
                font-size: 14px;
                line-height: 35px;
            }

            #gooeySVG0 {
                width: 260px;
                height: 40px;
            }

            #bdggw{
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container" id="body">
    <div id="detail" class="panel">
        <div class="panel-body">
            <ul class="list-group" style="margin-bottom:0;">
                <li class="list-group-item">域&#12288;&#12288;名：<?php output($domainName) ?></li>
                <li class="list-group-item">出售价格：<?php output($domainPrice .' '. PriceUnit) ?></li>
                <li class="list-group-item">简&#12288;&#12288;介：<?php formatOutput($domainDesc, '[略]') ?></li>
                <li class="list-group-item">注&ensp;册&ensp;商：<?php getRegistrarSalePage($domainRegistrarId, $domainName) ?></li>
                <li class="list-group-item">注册时间：<?php output(date('Y-m-d', strtotime($domainCreatedTime))) ?></li>
                <li class="list-group-item">到期时间：<?php output(date('Y-m-d', strtotime($domainExpirationTime))) ?></li>
                <li class="list-group-item">更新时间：<?php output(date('Y-m-d', strtotime($domainUpdatedDate))) ?></li>
                <li class="list-group-item">浏览次数：<?php output($domainViewsCount) ?> </li>
                <li class="list-group-item">中意次数：<span id="likesCount"><?php output($domainLikesCount) ?></span> </li>
            </ul>
        </div>
        <div class="panel-footer clearfix">
            <nav id="gooey-h" class="pull-left">
                <input type="checkbox" class="menu-open" name="menu-open2" id="menu-open2"/>
                <label class="open-button" for="menu-open2">
                    <span class="burger burger-1"></span>
                    <span class="burger burger-2"></span>
                    <span class="burger burger-3"></span>
                </label>

                <a href="/" title="回首页" class="gooey-menu-item"><i class="iconfont icon-shouye float-icon-light waves-effect waves-circle waves-float waves-light"></i></a>
                <a href="tel:<?php output($contactMobile) ?>" title="打电话" class="gooey-menu-item"><i class="iconfont icon-dianhua1 float-icon-light waves-effect waves-circle waves-float waves-light"></i></a>
                <a href="mailto:<?php output($contactEmail) ?>" title="发邮件" class="gooey-menu-item"><i class="iconfont icon-youjian1 float-icon-light waves-effect waves-circle waves-float waves-light"></i></a>
                <a href="#" title="发微信" id="wechatQrcode" class="gooey-menu-item"><i class="iconfont icon-weixin-copy float-icon-light waves-effect waves-circle waves-float waves-light"></i></a>
                <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php output($contactQQ) ?>&site=qq&menu=yes" target="_blank" title="发QQ" class="gooey-menu-item"><i class="iconfont icon-qq float-icon-light waves-effect waves-circle waves-float waves-light"></i></a>
                <a href="#" title="中意它" class="gooey-menu-item" onclick="addLikesCount(this, <?php output($id) ?>)"><i class="iconfont icon-dianzan-copy float-icon-light waves-effect waves-circle waves-float waves-light"></i></a>
            </nav>
            <div id="bdggw" class="pull-right">
                <script type="text/javascript">
                    /*asdmn.com|详情页|创建于 2017/9/4*/
                    var cpro_id = "u3078752";
                </script>
                <script type="text/javascript" src="http://cpro.baidustatic.com/cpro/ui/c.js"></script>
            </div>
        </div>
    </div>
    <p id="bingBgTips">背景图片：源自 <a href="https://www.bing.com/" title="Bing" target="_blank">Bing</a>，感谢提供</p>
</div>
<script src="/js/jquery.2.1.4.min.js" charset="utf-8"></script>
<script src="/lib/layui-v1.0.9/layui/layui.js" charset="utf-8"></script>
<script src="/js/waves.min.js"></script>
<script src="/js/gooey.min.js"></script>
<script type="text/javascript">
    var config = {
        // How long Waves effect duration
        // when it's clicked (in milliseconds)
        duration: 500,

        // Delay showing Waves effect on touch
        // and hide the effect if user scrolls
        // (0 to disable delay) (in milliseconds)
        delay: 200
    };

    // Initialise Waves with the config
    Waves.init(config);
    Waves.attach('.flat-icon', ['waves-circle']);
    Waves.attach('.float-icon', ['waves-circle', 'waves-float']);
    Waves.attach('.float-icon-light', ['waves-circle', 'waves-float', 'waves-light']);

    $(function() {
        $("#gooey-h").gooeymenu({
            bgColor: "#ff6666",
            style: "horizontal",
            contentColor: "white",
            horizontal: {
                menuItemPosition: 'glue'
            },
            size: 50,
            margin: 'small'
        });

        layui.use('layer', function(){
            var layer = layui.layer;

            $('#wechatQrcode').on('click', function () {
                layer.open({
                    title: '扫一扫，微信开聊！',
                    content: '<img src="<?php formatOutput(getConfigValue('site_contact_wechat'), 'images/qrcode_for_bmqygzh.jpg') ?>" alt="关注微信号" style="margin: 0 auto;display: block;" width="200" height="200" />'
                });
            });
        });
    });

    function addLikesCount(obj, id){
        $.ajax({
            url: '/callback/',
            type: 'POST',
            data: {
                action: 'addLikesCount',
                id: id
            },
            success: function (res) {
                var oResult = JSON.parse(res);
                var oLikesCount = $('#likesCount');
                if(oResult.status === 0){
                    oLikesCount.text(parseInt(oLikesCount.text()) + 1);
                    layer.msg(oResult.message, {icon: 6});
                }
                else{
                    layer.msg(oResult.message, {icon: 5});
                }
            }
        });
    }
</script>
</body>
</html>