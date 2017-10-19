<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/check_login.php' ?>

<?php
    $con = getConnection();
    $sql = 'SELECT * FROM mb_config WHERE 1=1';
    $rs = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>系统设置</title>
    <?php include RootPath .'/inc/common/css.php'?>
</head>
<body>

<div class="panel panel-primary" id="listDomain">
    <div class="panel-heading clearfix">
        系统设置
    </div>
    <div class="panel-body">
        <form id="settingForm" class="form-horizontal" method="post" enctype="multipart/form-data">
            <?php
            while ($row = mysqli_fetch_array($rs)){
                if($row['config_key'] === 'site_logo'){
            ?>
            <div class="form-group">
                <label for="<?php output($row['config_key']) ?>" class="col-sm-2 control-label"><?php output($row['config_title']) ?></label>
                <div class="col-sm-8">
                    <input type="text" id="<?php output($row['config_key']) ?>" name="<?php output($row['config_key']) ?>" class="form-control upload_logo" value="<?php output($row['config_val']) ?>">
                </div>
                <div class="col-sm-2">
                    <label for="uploadLogo" class="btn btn-info" onclick="openUpload('logo');">上传文件</label>
                </div>
            </div>
            <div class="form-group upload_iframe_logo hide">
                <div class="col-md-10 col-md-offset-2">
                    <iframe src="/inc/common/upload.php?type=logo" width="100%" height="30px;" frameborder="0"></iframe>
                </div>
            </div>
            <?php
                }
            else if($row['config_key'] === 'site_contact_wechat') {
            ?>
            <div class="form-group">
                <label for="<?php output($row['config_key']) ?>" class="col-sm-2 control-label"><?php output($row['config_title']) ?></label>
                <div class="col-sm-8">
                    <input type="text" id="<?php output($row['config_key']) ?>" name="<?php output($row['config_key']) ?>" class="form-control upload_wechat" value="<?php output($row['config_val']) ?>">
                </div>
                <div class="col-sm-2">
                    <label for="uploadWechat" class="btn btn-info" onclick="openUpload('wechat');">上传文件</label>
                </div>
            </div>
            <div class="form-group upload_iframe_wechat hide">
                <div class="col-md-10 col-md-offset-2">
                    <iframe src="/inc/common/upload.php?type=wechat" width="100%" height="30px;" frameborder="0"></iframe>
                </div>
            </div>
            <?php
            }
            else {
            ?>
            <div class="form-group">
                <label for="<?php output($row['config_key']) ?>" class="col-sm-2 control-label"><?php outputByBoolean($row['config_key'] === 'site_title' or $row['config_key'] === 'site_contact_name' or $row['config_key'] === 'site_contact_qq','<span class="input_must">*</span>','') ?><?php output($row['config_title']) ?></label>
                <div class="col-sm-10">
                    <input type="text" id="<?php output($row['config_key']) ?>"
                           name="<?php output($row['config_key']) ?>" class="form-control"
                           value="<?php output($row['config_val']) ?>" <?php outputByBoolean($row['config_key'] === 'site_version', 'disabled', '') ?>>
                </div>
            </div>
            <?php
                }
            }
            ?>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" id="btnSubmit" class="btn btn-primary btn-block">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include RootPath .'/inc/common/js.php'?>
<script>
    var oForm = $('#settingForm');
    var oTitle = $('#site_title');
    var oContact = $('#site_contact_name');
    var oQQ = $('#site_contact_qq');
    $('#btnSubmit').on('click', function () {
        if(oTitle.val() === ''){
            parent.layer.alert('网站名称不能为空！');
        }
        else if(oContact.val() === ''){
            parent.layer.alert('联系人不能为空！');
        }
        else if(oQQ.val() === ''){
            parent.layer.alert('QQ号码不能为空！');
        }
        else{
            $.ajax({
               url: '/admin/system/action.php',
               type: 'post',
               data: 'action=updateSetting&'+ oForm.serialize(),
               success: function (res) {
                   var _data = JSON.parse(res);
                   if(_data.status === 0){
                       location.reload();
                   }
                   else{
                       parent.layer.alert(_data.result);
                   }
               }
            });
        }
    })
</script>
</body>
</html>