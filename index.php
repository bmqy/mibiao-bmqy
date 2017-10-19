<?php include $_SERVER['DOCUMENT_ROOT'] .'/inc/config.php' ?>
<?php
$con = getConnection();
$urlParameter = '';
$sort = 1;
if($_GET['sort']){
    $sort = $_GET['sort'];
    $urlParameter = $urlParameter .'sort='. $sort;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php output(getConfigValue('site_title') .'|'. getConfigValue('site_subTitle')) ?></title>
    <?php include RootPath ."/inc/common/css.php"?>
</head>
<body>
<?php include RootPath . "/inc/common/head.php" ?>

<div class="container" id="body">
    <div class="panel panel-primary" id="tejiaDomain">
        <div class="panel-heading clearfix">
            推荐域名
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 col-md-3 text-center">
                    <div class="thumbnail">
                        <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVlYjg1MWQwYTcgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWViODUxZDBhNyI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44MDQ2ODc1IiB5PSIxMDUuMSI+MjQyeDIwMDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" alt="...">
                        <div class="caption">
                            <h3>asdmn.com</h3>
                            <p>爱尚大美妞</p>
                            <p><a href="#" class="btn btn-danger" role="button">购买</a> <a href="#" class="btn btn-primary" role="button">详情</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <div class="thumbnail">
                        <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVlYjg1MWQwYTcgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWViODUxZDBhNyI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44MDQ2ODc1IiB5PSIxMDUuMSI+MjQyeDIwMDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" alt="...">
                        <div class="caption">
                            <h3>51b1.com</h3>
                            <p>51b1</p>
                            <p><a href="#" class="btn btn-danger" role="button">购买</a> <a href="#" class="btn btn-primary" role="button">详情</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <div class="thumbnail">
                        <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVlYjg1MWQwYTcgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWViODUxZDBhNyI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44MDQ2ODc1IiB5PSIxMDUuMSI+MjQyeDIwMDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" alt="...">
                        <div class="caption">
                            <h3>asdmn.com</h3>
                            <p>爱尚大美妞</p>
                            <p><a href="#" class="btn btn-danger" role="button">购买</a> <a href="#" class="btn btn-primary" role="button">详情</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <div class="thumbnail">
                        <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTVlYjg1MWQwYTcgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNWViODUxZDBhNyI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44MDQ2ODc1IiB5PSIxMDUuMSI+MjQyeDIwMDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" alt="...">
                        <div class="caption">
                            <h3>51b1.com</h3>
                            <p>51b1</p>
                            <p><a href="#" class="btn btn-danger" role="button">购买</a> <a href="#" class="btn btn-primary" role="button">详情</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-primary" id="listDomain">
        <div class="panel-heading clearfix">
            所有域名
            <div class="btn-group btn-group-xs pull-right" data-toggle="buttons" id="btnSorts">
                <label class="btn btn-primary <?php outputByBoolean($sort ==1, ' active', '' ) ?>" data-toggle="tooltip" data-placement="top" title="默认排序">
                    <input type="radio" name="sortDomainList" value="1" autocomplete="off"> 默认
                    <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                </label>
                <label class="btn btn-primary <?php outputByBoolean($sort ==2, ' active', '' ) ?>" data-toggle="tooltip" data-placement="top" title="按价格由低到高">
                    <input type="radio" name="sortDomainList" value="2" autocomplete="off"> 价格
                    <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                </label>
                <label class="btn btn-primary <?php outputByBoolean($sort ==3, ' active', '' ) ?>" data-toggle="tooltip" data-placement="top" title="按浏览次数由高到低">
                    <input type="radio" name="sortDomainList" value="3" autocomplete="off"> 浏览
                    <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                </label>
                <label class="btn btn-primary <?php outputByBoolean($sort ==4, ' active', '' ) ?>" data-toggle="tooltip" data-placement="top" title="按喜欢数由高到低">
                    <input type="radio" name="sortDomainList" value="4" autocomplete="off"> 喜欢
                    <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
                </label>
            </div>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-8 col-md-2">域名</div>
                        <div class="col-xs-4 col-md-2 text-center">价格</div>
                        <div class="hidden-xs col-md-7">简介</div>
                        <div class="hidden-xs col-md-1 text-center">喜欢</div>
                    </div>
                </li>
                <?php
                $sql = 'SELECT id,title,price,description,icon,registrarId,domainExpirationTime,cost,saleStatus,viewsCount,likesCount FROM mb_domain';
                $rs = mysqli_query($con, $sql);
                $pages = new pages($rs, PagesSize, '');
                if($sort == 2){
                    $sql = $sql .' ORDER BY price ASC';
                }
                else if ($sort == 3){
                    $sql = $sql .' ORDER BY viewsCount DESC';
                }
                else if ($sort == 4){
                    $sql = $sql .' ORDER BY likesCount DESC';
                }
                else{
                    $sql = $sql .' ORDER BY id DESC';
                }
                $sql = $sql .' limit '. ($cp - 1) * PagesSize .','. PagesSize;
                $rs = mysqli_query($con, $sql);
                while($row = mysqli_fetch_array($rs)){
                ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-xs-8 col-md-2">
                                <?php
                                getALinks('detail.php?id='. $row['id'], $row['title'], null);
                                ?>
                            </div>
                            <div class="col-xs-4 col-md-2 text-center">
                                <div class="hidden-xs">
                                    <?php
                                    output('<a href="detail.php?id='. $row['id'] .'" title="'. $row['title'] .'" target="'. getConfigValue('site_link_target') .'" rel="nofollow"><span class="label_price">' . getPriceWithUnit($row['price']) .'</span></a>');
                                    ?>
                                </div>
                                <div class="hidden-md hidden-lg">
                                    <?php
                                    output('<a href="detail.php?id='. $row['id'] .'" title="'. $row['title'] .'" target="'. getConfigValue('site_link_target') .'" rel="nofollow"><span class="price">' . getPriceWithUnit($row['price']) .'</span></a>');
                                    ?>
                                </div>
                            </div>
                            <div class="hidden-xs col-md-7">
                                <?php
                                output('<a href="detail.php?id='. $row['id'] .'" title="'. $row['title'] .'" target="'. getConfigValue('site_link_target') .'" rel="nofollow">'. formatReturn($row['description'], '[略]').'</a>');
                                ?>
                            </div>
                            <div class="hidden-xs col-md-1 text-center">
                                <?php
                                output('<a href="detail.php?id='. $row['id'] .'" title="'. $row['title'] .'" target="'. getConfigValue('site_link_target') .'" rel="nofollow"><span class="label_xihuan">'. formatReturn($row['likesCount'], '0').'</span></a>');
                                ?>
                            </div>
                        </div>
                    </li>
                <?php
                    }
                ?>
            </ul>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php $pages->getPages() ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include RootPath . "/inc/common/footer.php" ?>
<script>
    $(function () {
        $('#listDomain .btn').tooltip();
    })
</script>
</body>
</html>