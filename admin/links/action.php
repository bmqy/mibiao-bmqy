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
    case 'addLinks':
        doAddLinks();
        break;
    case 'updateLinks':
        doUpdateLinks();
        break;
    case 'deleteLinks':
        doDeleteLinks();
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

// 添加友链
function doAddLinks(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $title = $_POST['title'];
    $url = $_POST['url'];
    $desc = $_POST['description'];
    $createdTime = $modifiedTime = date('Y-m-d H:i:s');

    if(empty($title)){
        $status = 1;
    }
    elseif (empty($url)){
        $status = 2;
    }
    else{
        $sql = 'INSERT INTO mb_links (title, url';
        if(!empty($desc)){
            $sql = $sql .', description';
        }
        $sql = $sql .', createdTime, modifiedTime) VALUES ("'. $title .'", "'. $url .'"';
        if(!empty($desc)){
            $sql = $sql .', "'. $desc .'"';
        }
        $sql = $sql .', "'. $createdTime .'", "'. $modifiedTime .'")';
        $isSuccess = mysqli_query($con, $sql);
    }

    if($isSuccess){
        $result = '添加成功！';
    }
    else{
        if($status === 1){
            $result = '标题不能为空！';
        }
        elseif ($status === 2){
            $result = '链接不能为空！';
        }
        else{
            $status = 3;
            $result = '出问题了，过会儿再试试！';
        }
    }

    // 删除多余数据
    $sql = 'DELETE FROM mb_links WHERE id NOT IN(SELECT l.id FROM (SELECT id FROM mb_links ORDER BY id DESC LIMIT 10) AS l )';
    mysqli_query($con, $sql);
    mysqli_close($con);

    echo json_encode([
        'status' => $status,
        'result' => $result
    ]);
}

// 更新友链
function doUpdateLinks(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $linkId = $_POST['id'];
    $title = $_POST['title'];
    $url = $_POST['url'];
    $desc = $_POST['description'];
    $icon = $_POST['icon'];
    $orderNumber = $_POST['orderNumber'];
    $modifiedTime = date('Y-m-d H:i:s');

    if(empty($linkId)){
        $status = 1;
    }
    else{
        $sql = 'UPDATE mb_links SET title="'. $title .'", url="'. $url .'", description="'. $desc .'",modifiedTime="'. $modifiedTime .'" WHERE id='. $linkId;
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

// 删除友链
function doDeleteLinks(){
    global $status,
           $result;
    $con = getConnection();
    $isSuccess = false;

    $linkId = $_POST['linkId'];
    if(is_array($linkId)){
        for($i=0; $i<count($linkId); $i++){
            if(!empty($linkId[$i])){
                $sql = 'DELETE FROM mb_links WHERE id='. $linkId[$i];
            }
        }
    }
    else{
        if($linkId){
            $sql = 'DELETE FROM mb_links WHERE id='. $linkId;
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

    $linkId = $_POST['linkId'];
    $orderNumber = $_POST['orderNumber'];
    $modifiedTime = date('Y-m-d H:i:s');

    for($i=0; $i<count($linkId); $i++){
        if(!empty($linkId[$i])){
            $sql = 'UPDATE mb_links SET orderNumber='. returnByBoolean($orderNumber[$i], $orderNumber[$i], 99) .',modifiedTime="'. $modifiedTime .'" WHERE id='. $linkId[$i];
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