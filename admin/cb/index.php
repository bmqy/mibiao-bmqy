<?php include $_SERVER['DOCUMENT_ROOT'] ."/inc/config.php"; ?>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: bmqy
 * Date: 2017/9/28
 * Time: 12:41
 */

$action = $_POST['action'];
$status = 0;
$result = '操作成功！';
switch ($action){
    case 'login':
        doLogin();
        break;
    default:
        echo json_encode([
            'result' => '非法操作！'
        ]);
        break;
}

// 登录
function doLogin(){
    global $status,
           $result;
    $con = getConnection();
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = 'SELECT id,username,password FROM mb_user WHERE username="'. $username .'"';
    $rs = mysqli_query($con, $sql);
    if($row = mysqli_fetch_array($rs)){
        if($password === $row['password']){
            setCookies('userId', $row['id']);
            $result = '登录成功！';
        }
        else{
            $status = 2;
            $result = '密码错误！';
        }
    }
    else{
        $status = 1;
        $result = '用户名错误！';
    }

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}