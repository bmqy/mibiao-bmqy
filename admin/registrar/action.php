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
    case 'addRegistrar':
        doAddRegistrar();
        break;
    case 'updateRegistrar':
        doUpdateRegistrar();
        break;
    case 'deleteRegistrar':
        doDeleteRegistrar();
        break;
    case 'updateOrder':
        doUpdateOrder();
        break;
    default:
        echo json_encode([
            'result' => '非法操作！'
        ]);
        break;
}

// 添加注册商
function doAddRegistrar(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $name = $_POST['name'];
    $enName = strtolower($_POST['enName']);
    $domain = $_POST['domain'];
    $salePageUrl = $_POST['salePageUrl'];
    $createdTime = $modifiedTime = date('Y-m-d H:i:s');

    if(empty($name)){
        $status = 1;
    }
    elseif (empty($enName)){
        $status = 2;
    }
    elseif (empty($domain)){
        $status = 3;
    }
    elseif (empty($salePageUrl)){
        $status = 4;
    }
    else{
        $sql = 'INSERT INTO mb_registrar (name, enName, domain, salePageUrl, createdTime, modifiedTime) VALUES ("'. $name .'", "'. $enName .'", "'. $domain .'", "'. $salePageUrl .'", "'. $createdTime .'", "'. $modifiedTime .'")';
        $isSuccess = mysqli_query($con, $sql);
    }

    if($isSuccess){
        $result = '添加成功！';
    }
    else{
        if($status === 1){
            $result = '名称不能为空！';
        }
        elseif ($status === 2){
            $result = '英文名不能为空！';
        }
        elseif ($status === 3){
            $result = '网站地址不能为空！';
        }
        elseif ($status === 4){
            $result = '网站域名出售页不能为空！';
        }
        else{
            $status = 5;
            $result = '出问题了，过会儿再试试！';
        }
    }

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}

// 更新注册商
function doUpdateRegistrar(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $registrarId = $_POST['registrarId'];
    $name = $_POST['name'];
    $enName = strtolower($_POST['enName']);
    $domain = $_POST['domain'];
    $salePageUrl = $_POST['salePageUrl'];
    $orderNumber = $_POST['orderNumber'];
    $modifiedTime = date('Y-m-d H:i:s');

    if(empty($registrarId)){
        $status = 1;
    }
    elseif (empty($name)){
        $status = 2;
    }
    elseif (empty($enName)){
        $status = 3;
    }
    elseif (empty($domain)){
        $status = 4;
    }
    elseif (empty($salePageUrl)){
        $status = 5;
    }
    else{
        $sql = 'UPDATE mb_registrar SET name="'. $name .'", enName="'. $enName .'", domain="'. $domain .'", salePageUrl="'. $salePageUrl .'",modifiedTime="'. $modifiedTime .'" WHERE id='. $registrarId;
        $isSuccess = mysqli_query($con, $sql);
    }

    if($isSuccess){
        $result = '更新成功！';
    }
    else{
        if($status === 1){
            $result = 'ID错误！';
        }
        elseif($status === 2){
            $result = '名称不能为空！';
        }
        elseif ($status === 3){
            $result = '英文名不能为空！';
        }
        elseif ($status === 4){
            $result = '网站地址不能为空！';
        }
        elseif ($status === 5){
            $result = '网站域名出售页不能为空！';
        }
        else{
            $status = 6;
            $result = '出问题了，过会儿再试试！';
        }
    }
    mysqli_close($con);

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}

// 删除注册商
function doDeleteRegistrar(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $registrarId = $_POST['registrarId'];
    if(is_array($registrarId)){
        for($i=0; $i<count($registrarId); $i++){
            if(!empty($registrarId[$i])){
                $sql = 'DELETE FROM mb_registrar WHERE id='. $registrarId[$i];
            }
        }
    }
    else{
        if($registrarId){
            $sql = 'DELETE FROM mb_registrar WHERE id='. $registrarId;
        }
    }
    $isSuccess = mysqli_query($con, $sql);

    if($isSuccess){
        $result = '删除成功！';
    }
    else{
        $status = 1;
        $result = '出问题了，过会儿再试试！';
    }
    mysqli_close($con);

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}

// 更新排序
function doUpdateOrder(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $registrarId = $_POST['registrarId'];
    $orderNumber = $_POST['orderNumber'];
    $modifiedTime = date('Y-m-d H:i:s');

    for($i=0; $i<count($registrarId); $i++){
        if(!empty($registrarId[$i])){
            $sql = 'UPDATE mb_registrar SET orderNumber='. returnByBoolean($orderNumber[$i], $orderNumber[$i], 99) .',modifiedTime="'. $modifiedTime .'" WHERE id='. $registrarId[$i];
            $isSuccess = mysqli_query($con, $sql);
        }
    }

    if($isSuccess){
        $result = '更新成功！';
    }
    else{
        $status = 1;
        $result = '出问题了，过会儿再试试！';
    }
    mysqli_close($con);

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}