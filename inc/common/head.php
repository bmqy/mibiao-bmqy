<div class="container" id="head">
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
                    <?php output(getConfigValue('site_title')) ?>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/">首页 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">资讯</a></li>
                </ul>
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <input type="text" id="searchKeyword" name="searchKeyword" class="form-control" placeholder="想要什么...">
                    </div>
                </form>

                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if(!empty(getConfigValue('site_contact_mobile'))){
                    ?>
                    <li><a href="tel:<?php output(getConfigValue('site_contact_mobile')) ?>" title="联系我吧"><i class="iconfont icon-dianhua2"></i> <?php output(getConfigValue('site_contact_mobile')) ?></a></li>
                    <?php
                    }
                    if(!empty(getConfigValue('site_contact_qq'))){
                    ?>
                    <li><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php output(getConfigValue('site_contact_qq')) ?>&site=qq&menu=yes" target="_blank"  title="Q我吧"><i class="iconfont icon-qq"></i> <?php output(getConfigValue('site_contact_qq')) ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</div>