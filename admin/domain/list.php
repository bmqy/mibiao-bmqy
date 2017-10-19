<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/check_login.php' ?>

<?php
$con = getConnection();
$urlParameter = '';
$sort = 1;
if($_GET['sort']){
    $sort = $_GET['sort'];
    $urlParameter = $urlParameter .'sort='. $sort;
}

$sql = 'SELECT * FROM mb_domain WHERE 1=1';
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
$rs = mysqli_query($con, $sql);
$pages = new pages($rs, PagesSize, '');
$sql = $sql .' LIMIT '. ($cp - 1) * PagesSize .', '. PagesSize;
$rs = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>域名管理</title>
    <?php include RootPath .'/inc/common/css.php'?>
</head>
<body>

<div class="panel panel-primary" id="listDomain">
    <div class="panel-heading clearfix">
        域名管理
        <button id="btnAdd" type="button" class="btn btn-primary btn-xs"><span class="iconfont icon-tianjia"></span></button>

        <div class="btn-group btn-group-xs pull-right" data-toggle="buttons" id="btnSorts">
            <label class="btn btn-primary <?php outputByBoolean($sort ==1, ' active', '' ) ?>" data-toggle="tooltip" data-placement="bottom" title="默认排序">
                <input type="radio" name="sortDomainList" value="1" autocomplete="off"> 默认
                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
            </label>
            <label class="btn btn-primary <?php outputByBoolean($sort ==2, ' active', '' ) ?>" data-toggle="tooltip" data-placement="bottom" title="按价格由低到高">
                <input type="radio" name="sortDomainList" value="2" autocomplete="off"> 价格
                <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
            </label>
            <label class="btn btn-primary <?php outputByBoolean($sort ==3, ' active', '' ) ?>" data-toggle="tooltip" data-placement="bottom" title="按浏览次数由高到低">
                <input type="radio" name="sortDomainList" value="3" autocomplete="off"> 浏览
                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
            </label>
            <label class="btn btn-primary <?php outputByBoolean($sort ==4, ' active', '' ) ?>" data-toggle="tooltip" data-placement="bottom" title="按喜欢数由高到低">
                <input type="radio" name="sortDomainList" value="4" autocomplete="off"> 喜欢
                <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
            </label>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>域名</th>
                    <th>价格</th>
                    <th>简介</th>
                    <th class="text-center">注册商</th>
                    <th width="100" class="text-center"><span data-toggle="tooltip" data-placement="top" data-original-title="前台访问时，自动获取">到期时间 <i class="iconfont icon-question text-info"></i></span></th>
                    <th width="100"  class="text-center">成本（元）</th>
                    <th class="text-center">状态</th>
                    <th class="text-center">浏览</th>
                    <th class="text-center">喜欢</th>
                    <th width="90" class="text-center">添加时间</th>
                    <th width="100" class="text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($rs)){
                ?>
                <tr>
                    <td><?php output($row['title']) ?></td>
                    <td><?php output($row['price']) ?></td>
                    <td><?php formatOutput($row['description'], '[略]') ?></td>
                    <td class="text-center"><?php output(getDomainRegistrarName($row['registrarId'])) ?></td>
                    <td class="text-center"><?php output(date("Y-m-d", strtotime($row['domainExpirationTime']))) ?></td>
                    <td class="text-center"><?php formatOutput($row['cost'], '[略]') ?></td>
                    <td class="text-center"><?php output(getDomainSaleStatusText($row['saleStatus'])) ?></td>
                    <td class="text-center"><?php output($row['viewsCount']) ?></td>
                    <td class="text-center"><?php output($row['likesCount']) ?></td>
                    <td class="text-center"><?php output(date("Y-m-d", strtotime($row['createdTime']))) ?></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button id="btnEdit" class="btn btn-link btn-xs" type="button"
                                    onclick="editIt(<?php output($row['id']) ?>);">编辑
                            </button>
                            <button id="btnDelete" class="btn btn-link btn-xs" type="button"
                                    onclick="deleteIt(<?php output($row['id']) ?>);">删除
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php $pages->getPages() ?>
            </ul>
        </nav>
    </div>
</div>
<?php include RootPath .'/inc/common/js.php'?>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    // 添加域名
    $('#btnAdd').on('click', function () {
        if($(top.document).find('.layui-layer').size() === 0){
            parent.layer.open({
                type: 2,
                title: '添加域名',
                area: ['450px','494px'],
                content: ['./domain/edit.php', 'no']
            });
        }
    });

    // 编辑指定域名
    function editIt(id) {
        if(!id){
            parent.layer.alert('ID错误！');
        }
        else{
            if($(top.document).find('.layui-layer').size() === 0){
                parent.layer.open({
                    type: 2,
                    title: '编辑域名',
                    area: ['450px','642px'],
                    content: ['./domain/edit.php?id='+ id, 'no']
                });
            }
        }
    }

    // 删除指定域名
    function deleteIt(id) {
        if(!id){
            parent.layer.alert('ID错误！');
        }
        else{
            parent.layer.confirm('确定要删除吗？',function (index) {
                $.ajax({
                    url: 'action.php',
                    type: 'post',
                    data: 'action=deleteDomain&domainId='+ id,
                    success: function (res) {
                        var _data = JSON.parse(res);
                        if(_data.status === 0){
                            parent.layer.alert(_data.result, function () {
                                parent.layer.closeAll();
                                parent.document.getElementById('iframe').contentWindow.location.reload(true);
                            });
                        }
                        else{
                            parent.layer.alert(_data.result);
                        }
                    }
                })
            },function (index) {
                parent.layer.msg('已取消', {icon: -1}, function () {
                    parent.layer.clone(index);
                });
            });
        }
    }
</script>
</body>
</html>