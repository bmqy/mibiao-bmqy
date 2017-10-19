<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/check_login.php' ?>

<?php
$con = getConnection();
$registrarId = $_GET['id'];
$action = 'addRegistrar';

if(!empty($registrarId)){
    $action = 'updateRegistrar';
    $sql = 'SELECT * FROM mb_registrar WHERE id='. $registrarId;
    $rs = mysqli_query($con, $sql);
    if($row = mysqli_fetch_array($rs)){
        $name = $row['name'];
        $enName = $row['enName'];
        $domain = $row['domain'];
        $salePageUrl = $row['salePageUrl'];
        $createdTime = $row['createdTime'];
        $modifiedTime = $row['modifiedTime'];
        $orderNumber = $row['orderNumber'];
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
	<title>编辑注册商</title>
    <?php include RootPath .'/inc/common/css.php'?>
</head>
<body>
<div class="panel panel-default">
    <div class="panel-body">
        <form id="registrarForm" class="form form-horizontal" action="action.php" method="post">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label"><span class="input_must">*</span>名称</label>
                <div class="col-sm-10">
                    <input type="text" id="name" name="name" class="form-control" value="<?php output($name) ?>" placeholder="字数不能超过 50 字符">
                </div>
            </div>
            <div class="form-group">
                <label for="enName" class="col-sm-2 control-label"><span class="input_must">*</span>英文名</label>
                <div class="col-sm-10">
                    <input type="text" id="enName" name="enName" class="form-control" value="<?php output($enName) ?>" placeholder="字数不能超过 100 字符">
                </div>
            </div>
            <div class="form-group">
                <label for="domain" class="col-sm-2 control-label"><span class="input_must">*</span>网站地址</label>
                <div class="col-sm-10">
                    <input type="url" id="domain" name="domain" class="form-control" value="<?php output($domain) ?>" placeholder="例如：http://example.com">
                </div>
            </div>
            <div class="form-group">
                <label for="salePageUrl" class="col-sm-2 control-label"><span class="input_must">*</span>域名出售页地址</label>
                <div class="col-sm-10">
                    <input type="url" id="salePageUrl" name="salePageUrl" class="form-control" value="<?php output($salePageUrl) ?>" placeholder="字数不能超过 100 字符">
                </div>
                <div class="col-sm-10 col-md-offset-2">
                    <p class="text-danger" style="margin-bottom: 0;">注：“{domain}” 部分为被出售域名。</p>
                </div>
            </div>
            <?php
            if(!empty($registrarId)) {
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
                    <input type="hidden" name="id" value="<?php output($registrarId) ?>">
                </div>
            </div>
        </form>
    </div>
</div>
<?php include RootPath .'/inc/common/js.php'?>
<script>
    var oForm = $('#registrarForm');
    var oName = oForm.find('#name');
    var oEnName = oForm.find('#enName');
    var oDomain = oForm.find('#domain');
    var oBtn = $('#btnSubmit');

    $("#registrarForm").validate({
        onfocusout: function (e) {
            $(e).valid();
        },
        focusInvalid: true,
        focusCleanup: true,
        rules: {
            name: {
                required: true,
                maxlength: 50
            },
            enName: {
                required: true,
                maxlength: 100
            },
            domain: {
                required: true,
                url: true,
                maxlength: 100
            },
            salePageUrl: {
                required: true,
                url: true,
                maxlength: 200
            }
        },
        messages: {
            name: {
                required: '请填写名称',
                maxlength: '标题字数不能超过 50 字符'
            },
            enName: {
                required: '请填写英文名！',
                maxlength: '标题字数不能超过 100 字符'
            },
            domain: {
                required: '请填写网站地址',
                url: '链接地址错误',
                maxlength: '简介字数不能超过 100 字符'
            },
            salePageUrl: {
                required: '请填写域名出售页地址',
                url: '网站域名出售页地址错误',
                maxlength: '出售页地址字数不能超过 200 字符'
            }
        },
        errorPlacement: function (error, element) {
            parent.layer.alert(error.text());
        }
    });

    oBtn.on('click', function () {
        var isCheckForm = $("#registrarForm").valid();
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