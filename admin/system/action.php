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
    case 'updateSetting':
        doUpdateSetting();
        break;
    case 'updateUsers':
        doUpdateUsers();
        break;
    default:
        echo '非法操作！';
        break;
}

// 更新系统设置项
function doUpdateSetting(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $site_title = $_POST['site_title'];
    $site_title_symbol = $_POST['site_title_symbol'];
    $site_contact_name = $_POST['site_contact_name'];
    $site_contact_qq = $_POST['site_contact_qq'];
    $site_link_target = $_POST['site_link_target'];

    if(empty($site_title)){
        $status = 1;
    }
    elseif (empty($site_contact_name)){
        $status = 2;
    }
    elseif (empty($site_contact_qq)){
        $status = 3;
    }
    else{
        $sql = 'SELECT config_key,config_val FROM mb_config';
        $rs = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($rs)){
            if($row['config_key'] !== 'site_version'){
                if($row['config_key'] === 'site_title_symbol'){
                    if(empty($site_title_symbol)){
                        $sql1 = 'UPDATE mb_config SET config_val="_" WHERE config_key="site_title_symbol"';
                    }
                    else{
                        $sql1 = 'UPDATE mb_config SET config_val="'. $site_title_symbol .'" WHERE config_key="site_title_symbol"';
                    }
                }
                elseif($row['config_key'] === 'site_link_target'){
                    if(empty($site_link_target)){
                        $sql1 = 'UPDATE mb_config SET config_val="_blank" WHERE config_key="site_link_target"';
                    }
                    else{
                        $sql1 = 'UPDATE mb_config SET config_val="'. $site_link_target .'" WHERE config_key="site_link_target"';
                    }
                }
                else{
                    $sql1 = 'UPDATE mb_config SET config_val="'. $_POST[$row['config_key']] .'" WHERE config_key="'. $row['config_key'] .'"';
                }
                $isSuccess = mysqli_query($con, $sql1);
            }
        }
    }

    if($isSuccess){
        $result = '更新成功！';
    }
    else{
        if($status === 1){
            $result = '网站名称不能为空！';
        }
        elseif ($status === 2){
            $result = '联系人不能为空！';
        }
        elseif ($status === 3){
            $result = 'QQ号码不能为空！';
        }
        else{
            $status = 4;
            $result = '出问题了，过会儿再试试！';
        }
    }
    mysqli_close($con);

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}

// 更新账户
function doUpdateUsers(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $realname = empty($_POST['realname']) ? '管理员' : $_POST['realname'];
    $modifiedTime = date('Y-m-d H:i:s');

    if(empty($username)){
        $status = 1;
    }
    else{
        $sql = 'UPDATE mb_user SET username="'. $username .'"';
        if(!empty($password)){
            $status = 2;
            $sql = $sql .',password="'. md5($password) .'"';
        }
        $sql = $sql .',email="'. $email .'",realname="'. $realname .'",modifiedTime="'. $modifiedTime .'" WHERE id=1';
        $isSuccess = mysqli_query($con, $sql);
    }

    if($isSuccess){
        if ($status === 2){
            $result = '密码已修改，请重新登录！';
            setCookies('userId', '', time()-3600);
        }
        else{
            $result = '更新成功！';
        }
    }
    else{
        if($status === 1){
            $result = '用户名不能为空！';
        }
        else{
            $status = 3;
            $result = '出问题了，过会儿再试试！';
        }
    }
    mysqli_close($con);

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}