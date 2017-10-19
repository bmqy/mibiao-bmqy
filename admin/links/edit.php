<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/check_login.php' ?>

<?php
$con = getConnection();
$linkId = $_GET['id'];
$action = 'addLinks';

if(!empty($linkId)){
    $action = 'updateLinks';
    $sql = 'SELECT title,url,description,createdTime,modifiedTime,orderNumber,status FROM mb_links WHERE id='. $linkId;
    $rs = mysqli_query($con, $sql);
    if($row = mysqli_fetch_array($rs)){
        $title = $row['title'];
        $url = $row['url'];
        $desc = $row['description'];
        $createdTime = $row['createdTime'];
        $modifiedTime = $row['modifiedTime'];
        $orderNumber = $row['orderNumber'];
        $status = $row['status'];
    }
}

closeConnection($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>编辑友情链接</title>
    <?php include RootPath .'/inc/common/css.php'?>
</head>
<body>
<div class="panel panel-default">
    <div class="panel-body">
        <form id="linksForm" class="form form-horizontal" action="action.php" method="post">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label"><span class="input_must">*</span>标题</label>
                <div class="col-sm-10">
                    <input type="text" id="title" name="title" class="form-control" value="<?php output($title) ?>" placeholder="字数不能超过 100 字符">
                </div>
            </div>
            <div class="form-group">
                <label for="url" class="col-sm-2 control-label"><span class="input_must">*</span>链接</label>
                <div class="col-sm-10">
                    <input type="url" id="url" name="url" class="form-control" value="<?php output($url) ?>" placeholder="例如：http://example.com">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">简介</label>
                <div class="col-sm-10">
                    <input type="text" id="description" name="description" class="form-control" value="<?php output($desc) ?>" placeholder="非必填，字数不能超过 100 字符">
                </div>
            </div>
            <?php
            if(!empty($linkId)) {
            ?>
            <div class="form-group">
                <label for="createdTime" class="col-sm-2 control-label">创建时间</label>
                <div class="col-sm-10">
                    <input type="text" id="createdTime" name="createdTime" class="form-control" value="<?php output($createdTime) ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="modifiedTime" class="col-sm-2 control-label">修改时间</label>
                <div class="col-sm-10">
                    <input type="text" id="modifiedTime" name="modifiedTime" class="form-control" value="<?php output($modifiedTime) ?>" disabled>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" id="btnSubmit" class="btn btn-primary btn-block">提交</button>
                    <input type="hidden" name="action" value="<?php output($action) ?>">
                    <input type="hidden" name="id" value="<?php output($linkId) ?>">
                </div>
            </div>
        </form>
    </div>
</div>
<?php include RootPath .'/inc/common/js.php'?>
<script>
    var oForm = $('#linksForm');
    var oTitle = oForm.find('#title');
    var oUrl = oForm.find('#url');
    var oDesc = oForm.find('#description');
    var oBtn = $('#btnSubmit');

    $("#linksForm").validate({
        onfocusout: function (e) {
            $(e).valid();
        },
        focusInvalid: true,
        focusCleanup: true,
        rules: {
            title: {
                required: true,
                maxlength: 100
            },
            url: {
                required: true,
                url: true
            },
            description: {
                maxlength: 100
            }
        },
        messages: {
            title: {
                required: '请填写标题',
                maxlength: '标题字数不能超过 100 字符'
            },
            url: {
                required: '请填写链接！',
                url: '链接地址错误！'
            },
            description: {
                maxlength: '简介字数不能超过 100 字符'
            }
        },
        errorPlacement: function (error, element) {
            parent.layer.alert(error.text());
        }
    });

    oBtn.on('click', function () {
        var isCheckForm = $("#linksForm").valid();
        if(!isCheckForm){
            return false;
        }
        else{
            $.ajax({
                url: 'action.php',
                type: 'post',
                data: oForm.serialize(),
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
    });
</script>
</body>
</html>