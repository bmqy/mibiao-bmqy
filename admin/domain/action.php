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
    case 'addDomain':
        doAddDomain();
        break;
    case 'updateDomain':
        doUpdateDomain();
        break;
    case 'deleteDomain':
        doDeleteDomain();
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

// 添加域名
function doAddDomain(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $title = $_POST['title'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $registrarId = $_POST['registrarId'];
    $cost = $_POST['cost'];
    $createdTime = $modifiedTime = date('Y-m-d H:i:s');

    if(empty($title)){
        $status = 1;
    }
    elseif (empty($price)){
        $status = 2;
    }
    else{
        $sql = 'INSERT INTO mb_domain (title, price';
        if(!empty($desc)){
            $sql = $sql .', description';
        }
        if(!empty($registrarId)){
            $sql = $sql .', registrarId';
        }
        if(!empty($cost)){
            $sql = $sql .', cost';
        }
        $sql = $sql .', createdTime, modifiedTime) VALUES ("'. $title .'", "'. $price .'"';
        if(!empty($desc)){
            $sql = $sql .', "'. $desc .'"';
        }
        if(!empty($registrarId)){
            $sql = $sql .', "'. $registrarId .'"';
        }
        if(!empty($cost)){
            $sql = $sql .', "'. $cost .'"';
        }
        $sql = $sql .', "'. $createdTime .'", "'. $modifiedTime .'")';
        $isSuccess = mysqli_query($con, $sql);
    }

    if($isSuccess){
        $result = '添加成功！';
    }
    else{
        if($status === 1){
            $result = '域名不能为空！';
        }
        elseif ($status === 2){
            $result = '售价不能为空！';
        }
        else{
            $status = 3;
            $result = '出问题了，过会儿再试试！';
        }
    }

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}

// 更新域名
function doUpdateDomain(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $domainId = $_POST['id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $registrarId = $_POST['registrarId'];
    $cost = $_POST['cost'];
    $icon = $_POST['icon'];
    $modifiedTime = date('Y-m-d H:i:s');

    if(empty($domainId)){
        $status = 1;
    }
    else{
        $sql = 'UPDATE mb_domain SET title="'. $title .'", price="'. $price .'", description="'. $desc .'", registrarId='. $registrarId .', cost='. $cost .',modifiedTime="'. $modifiedTime .'" WHERE id='. $domainId;
        $isSuccess = mysqli_query($con, $sql);
    }

    if($isSuccess){
        $result = '更新成功！';
    }
    else{
        if($status === 1){
            $result = 'ID错误！';
        }
        else{
            $status = 2;
            $result = '出问题了，过会儿再试试！';
        }
    }
    mysqli_close($con);

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}

// 删除域名
function doDeleteDomain(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $domainId = $_POST['domainId'];
    if(is_array($domainId)){
        for($i=0; $i<count($domainId); $i++){
            if(!empty($domainId[$i])){
                $sql = 'DELETE FROM mb_domain WHERE id='. $domainId[$i];
            }
        }
    }
    else{
        if($domainId){
            $sql = 'DELETE FROM mb_domain WHERE id='. $domainId;
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

    $domainId = $_POST['linkId'];
    $orderNumber = $_POST['orderNumber'];
    $modifiedTime = date('Y-m-d H:i:s');

    for($i=0; $i<count($domainId); $i++){
        if(!empty($domainId[$i])){
            $sql = 'UPDATE mb_domain SET orderNumber='. returnByBoolean($orderNumber[$i], $orderNumber[$i], 99) .',modifiedTime="'. $modifiedTime .'" WHERE id='. $domainId[$i];
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