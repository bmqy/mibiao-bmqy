<?php
include $_SERVER['DOCUMENT_ROOT'] .'/inc/db.php';
include $_SERVER['DOCUMENT_ROOT'] .'/inc/function.php';

$action = $_POST['action'];
$status = 0;
$result = '操作成功！';

switch ($action){
    case 'addLikesCount':
        DoAddLikesCount();
        break;
    case 'searchDomainList':
        DoSearchDomainList();
        break;
    default:
        echo json_encode([
            'result' => '非法操作！'
        ]);
        break;
}

// 更新域名喜欢次数
function DoAddLikesCount(){
    global $status,
           $result;
    $id = $_POST['id'];
    if(!empty($id)){
        $con = getConnection();
        $sql = 'UPDATE mb_domain SET likesCount = likesCount + 1 WHERE id ='. $id;
        mysqli_query($con, $sql);
        if(mysqli_affected_rows($con)){
            $result = '好域名，不要错过哦，赶紧联系卖家吧！';
        }
        else{
            $status = 1;
            $result = '出问题了，过会儿再试试！';
        }
        mysqli_close($con);
    }

    $resultJson = json_encode([
        'status'=>$status,
        'message'=>$result
    ]);
    echo $resultJson;
}

// 搜索域名并返回结果数组
function DoSearchDomainList(){
    global $status,
           $result;
    $con = getConnection();
    $searchKeyword = $_POST['searchKeyword'];
    $sql = 'SELECT id,title,price FROM mb_domain WHERE title LIKE "%'. $searchKeyword .'%" ORDER BY id DESC';
    $rs = mysqli_query($con, $sql);
    $dataArr = array();
    while ($row = mysqli_fetch_object($rs)){
        $dataArr[] = $row;
    }
    $resultJson = json_encode([
        'status'=>$status,
        'data'=>$dataArr,
        'message'=>'ok'
    ]);
    mysqli_close($con);
    echo $resultJson;
}
?>