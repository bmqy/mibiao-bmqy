<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/check_login.php' ?>

<?php
$con = getConnection();
$sql = 'SELECT id,title,url,description,status,orderNumber FROM mb_links WHERE 1=1';
$sql = $sql .' ORDER BY id DESC';
$rs = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>友链管理</title>
    <?php include RootPath .'/inc/common/css.php'?>
</head>
<body>

<div class="panel panel-primary" id="listDomain">
    <div class="panel-heading clearfix">
        友链管理
    </div>
    <div class="panel-body">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                所有友链
                <div class="btn-toolbar pull-right" role="toolbar">
                    <button id="btnOrder" type="button" class="btn btn-info btn-xs">排序</button>
                    <button id="btnDelete" type="button" class="btn btn-info btn-xs">删除</button>
                    <button id="btnAdd" type="button" class="btn btn-info btn-xs">添加</button>
                </div>
            </div>
            <div class="panel-body">
                <form id="listForm" method="post">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th width="16"><input type="checkbox" class="checkbox" onclick="selectAll(this, 'linkId');" style="margin-top: -16px;"></th>
                            <th>标题</th>
                            <th>链接</th>
                            <th>简介</th>
                            <th width="60" class="text-center">状态</th>
                            <th width="50" class="text-center">排序</th>
                            <th width="100" class="text-center">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($rs)){
                        ?>
                        <tr>
                            <td><input type="checkbox" name="linkId[]" value="<?php output($row['id']) ?>" onclick="selectIt(this);"></td>
                            <td><?php output($row['title']); ?></td>
                            <td><?php output($row['url']); ?></td>
                            <td><?php formatOutput($row['description'], '[略]'); ?></td>
                            <td class="text-center"><?php output($row['status']); ?></td>
                            <td class="text-center">
                                <input type="number" name="orderNumber[]" value="<?php output($row['orderNumber']); ?>" class="disabled text-center form-control" disabled>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button id="btnEdit" class="btn btn-link btn-xs" type="button"  onclick="editIt(<?php output($row['id']) ?>);" >编辑</button>
                                    <button id="btnDelete" class="btn btn-link btn-xs" type="button" onclick="deleteIt(<?php output($row['id']) ?>);" >删除</button>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="panel-footer">
                 <p class="text-danger">注：最多 10 条友链，在精不在多</p>
            </div>
        </div>
    </div>
</div>
<?php include RootPath .'/inc/common/js.php'?>
<script>
    // 批量修改排序
    $('#btnOrder').on('click', function () {
        var oForm = $('#listForm');
        if($('input[name="linkId[]"]:checked').size() > 0){
            $.ajax({
               url: 'action.php',
               type: 'post',
               data: 'action=updateOrder&'+ oForm.serialize(),
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
        }
        else{
            parent.layer.alert('请选择！');
        }
    });

    // 批量删除友链
    $('#btnDelete').on('click', function () {
        var oForm = $('#listForm');
        if($('input[name="linkId[]"]:checked').size() > 0){
            $.ajax({
               url: 'action.php',
               type: 'post',
               data: 'action=deleteLinks&'+ oForm.serialize(),
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
        }
        else{
            parent.layer.alert('请选择！');
        }
    });

    // 添加友链
    $('#btnAdd').on('click', function () {
        if($(top.document).find('.layui-layer').size() === 0){
            parent.layer.open({
                type: 2,
                title: '添加友链',
                area: ['450px','345px'],
                content: ['./links/edit.php', 'no']
            });
        }
    });

    // 编辑指定友链
    function editIt(id) {
        if(!id){
            parent.layer.alert('ID错误！');
        }
        else{
            if($(top.document).find('.layui-layer').size() === 0){
                parent.layer.open({
                    type: 2,
                    title: '编辑友链',
                    area: ['450px','495px'],
                    content: ['./links/edit.php?id='+ id, 'no']
                });
            }
        }
    }

    // 删除指定友链
    function deleteIt(id) {
        if(!id){
            parent.layer.alert('ID错误！');
        }
        else{
            parent.layer.confirm('确定要删除吗？',function (index) {
                $.ajax({
                    url: 'action.php',
                    type: 'post',
                    data: 'action=deleteLinks&linkId='+ id,
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