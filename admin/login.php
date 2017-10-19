<?php include $_SERVER['DOCUMENT_ROOT'] .'/inc/config.php' ?>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: bmqy
 * Date: 2017/9/25
 * Time: 17:27
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录<?php output(getConfigValue('site_title_symbol') . getConfigValue('site_title')); ?></title>
    <?php include RootPath .'/inc/common/css.php'?>
</head>
<body>
    <div class="container">
        <div class="col-md-4 col-md-offset-4" style="margin-top: 15%;">
            <form id="loginForm" method="post">
                <div class="form-group">
                    <label for="username">用户名</label>
                    <input type="text" class="form-control input-lg" id="username" name="username" placeholder="用户名">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-lg" id="password" name="password" placeholder="密码">
                </div>
                <button type="button" id="btnLogin" class="btn btn-primary btn-block btn-lg">登录</button>
            </form>
        </div>
    </div>
    <?php include RootPath .'/inc/common/js.php'?>
    <script>
        var oForm = $('#loginForm');
        var oUsername = $('#username');
        var oPassword = $('#password');
        var oBtnLogin = $('#btnLogin');

        $(document).on('keyup',function (e) {
            if(e.keyCode === 13 && $('.modal:visible').size() === 0){
                checkLoginForm();
            }
        });
        oBtnLogin.on('click', function () {
            checkLoginForm();
        });

        function checkLoginForm() {
            if(oUsername.val() === ''){
                modal({
                    'content': '请输入用户名！'
                });
            }
            else if(oPassword.val() === ''){
                modal({
                    'content': '请输入密码！'
                });
            }
            else{
                $.ajax({
                    url: 'cb/',
                    type: 'POST',
                    data: 'action=login&'+ oForm.serialize(),
                    success: function (res) {
                        var _data = JSON.parse(res);
                        if(_data.status === 0){
                            location.href = '/admin/';
                        }
                        else{
                            modal({
                                title: '注意',
                                content: _data.result
                            });
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>
