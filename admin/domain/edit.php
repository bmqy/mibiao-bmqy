<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/check_login.php' ?>

<?php
$con = getConnection();
$domainId = $_GET['id'];
$action = 'addDomain';

if(!empty($domainId)){
    $action = 'updateDomain';
    $sql = 'SELECT title,price,description,icon,registrarId,domainExpirationTime,cost,saleStatus,viewsCount,likesCount,createdTime,modifiedTime FROM mb_domain WHERE id='. $domainId;
    $rs = mysqli_query($con, $sql);
    if($row = mysqli_fetch_array($rs)){
        $title = $row['title'];
        $price = $row['price'];
        $desc = $row['description'];
        $icon = $row['icon'];
        $registrarId = $row['registrarId'];
        $expirationTime = $row['domainExpirationTime'];
        $cost = $row['cost'];
        $saleStatus = $row['saleStatus'];
        $viewsCount = $row['viewsCount'];
        $likesCount = $row['likesCount'];
        $createdTime = $row['createdTime'];
        $modifiedTime = $row['modifiedTime'];
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
	<title>编辑域名</title>
    <?php include RootPath .'/inc/common/css.php'?>
</head>
<body>
<div class="panel panel-default">
    <div class="panel-body">
        <form id="linksForm" class="form form-horizontal" action="action.php" method="post">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label"><span class="input_must">*</span>域名</label>
                <div class="col-sm-10">
                    <input type="text" id="title" name="title" class="form-control" value="<?php output($title) ?>" placeholder="例如：example.com">
                </div>
            </div>
            <div class="form-group">
                <label for="price" class="col-sm-2 control-label"><span class="input_must">*</span>售价</label>
                <div class="col-sm-10">
                    <input type="number" id="price" name="price" class="form-control" value="<?php output($price) ?>" placeholder="请填写售价">
                </div>
            </div>
            <div class="form-group">
                <label for="cost" class="col-sm-2 control-label">成本</label>
                <div class="col-sm-10">
                    <input type="number" id="cost" name="cost" class="form-control" value="<?php output($cost) ?>" placeholder="请填写成本价">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">简介</label>
                <div class="col-sm-10">
                    <input type="text" id="description" name="description" class="form-control" value="<?php output($desc) ?>" placeholder="非必填，字数不能超过 100 字符">
                </div>
            </div>
            <div class="form-group">
                <label for="registrarId" class="col-sm-2 control-label">注册商</label>
                <div class="col-sm-10">
                    <select name="registrarId" id="registrarId" class="form-control">
                        <option value="">请选择</option>
                        <?php getSelectOptions('mb_registrar', 'id', 'name', $registrarId) ?>
                    </select>
                </div>
            </div>
            <?php
            if(!empty($domainId)) {
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
                    <input type="hidden" name="id" value="<?php output($domainId) ?>">
                </div>
            </div>
        </form>
    </div>
</div>
<?php include RootPath .'/inc/common/js.php'?>
<script>
    var oForm = $('#linksForm');
    var oTitle = oForm.find('#title');
    var oPrice = oForm.find('#price');
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
                isDomain: true,
                maxlength: 100
            },
            price: {
                required: true,
                number: true
            },
            description: {
                maxlength: 100
            }
        },
        messages: {
            title: {
                required: '请填写域名',
                isDomain: '请检查域名是否正确',
                maxlength: '域名字数不能超过 100 字符'
            },
            price: {
                required: '请填写价格！',
                number: '售价错误！'
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