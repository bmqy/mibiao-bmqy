<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/check_login.php' ?>

<?php
    $con = getConnection();
    $sql = 'SELECT * FROM mb_user WHERE 1=1';
    $rs = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($rs)){
        $username = $row['username'];
        $password = $row['password'];
        $email = $row['email'];
        $realname = $row['realname'];
        $createdTime = $row['createdTime'];
        $modifiedTime = $row['modifiedTime'];
    }
    closeConnection($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>账户管理</title>
    <?php include RootPath .'/inc/common/css.php'?>
</head>
<body>

<div class="panel panel-primary" id="listDomain">
    <div class="panel-heading clearfix">
        账户管理
    </div>
    <div class="panel-body">
        <form id="usersForm" class="form-horizontal" method="post">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label"><span class="input_must">*</span>用户名</label>
                <div class="col-sm-10">
                    <input type="text" id="username" name="username" class="form-control" value="<?php output($username) ?>" placeholder="字数不能超过 50 字符">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">密码</label>
                <div class="col-sm-10">
                    <input type="text" id="password" name="password" class="form-control" value="" placeholder="如需修改密码请填写，否则请留空" autocomplete="false">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">邮箱</label>
                <div class="col-sm-10">
                    <input type="email" id="email" name="email" class="form-control" value="<?php output($email) ?>" placeholder="请填写有效邮箱地址">
                </div>
            </div>
            <div class="form-group">
                <label for="realname" class="col-sm-2 control-label">真实姓名</label>
                <div class="col-sm-10">
                    <input type="text" id="realname" name="realname" class="form-control" value="<?php output($realname) ?>" placeholder="字数不能超过 50 字符">
                </div>
            </div>
            <div class="form-group">
                <label for="createdTime" class="col-sm-2 control-label">创建时间</label>
                <div class="col-sm-10">
                    <p class="form-control" readonly=""><?php output($createdTime) ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="modifiedTime" class="col-sm-2 control-label">修改时间</label>
                <div class="col-sm-10">
                    <p class="form-control" readonly=""><?php output($modifiedTime) ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="btnSubmit" type="button" class="btn btn-primary btn-block">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include RootPath .'/inc/common/js.php'?>
<script>
    var oForm = $('#usersForm');
    var oUsername = $('#username');
    $('#btnSubmit').on('click', function () {
        if(oUsername.val() === ''){
            parent.layer.alert('用户名不能为空！');
        }
        else{
            $.ajax({
                url: '/admin/system/action.php',
                type: 'post',
                data: 'action=updateUsers&'+ oForm.serialize(),
                success: function (res) {
                    var _data = JSON.parse(res);
                    if(_data.status === 0){
                        location.reload();
                    }
                    else if(_data.status === 2){
                        parent.layer.alert(_data.result, function () {
                            parent.location.reload();
                        });
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