<?php include $_SERVER['DOCUMENT_ROOT'] . '/inc/config.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/check_login.php' ?>

<?php
$action = $_POST['action'];
$uploadType = ['image/jpg','image/jpeg','image/gif','image/png','image/x-png'];
$uploadSize = 2048000; // 限制：<2mb
$file = $_FILES["file"];
$uploadRealPath = RootPath .'/upload/'. date('Y') .'/'. date('md') .'/';
$uploadPath = '/upload/'. date('Y') .'/'. date('md') .'/';

switch ($action){
    case 'uploadIcon':
        doUploadIcon();
        break;
    default:
        break;
}

// 检测上传文件
function checkUpload($file){
    global $uploadType,
           $uploadSize,
           $file;

    if(in_array($file['type'],$uploadType)){
        if($file["size"] <= $uploadSize ){
            return 0;
        }
        else{
            return 2;
        }
    }
    else{
        return 1;
    }
}

// 获取时间毫秒数
function getMillisecond() {
    list($s1, $s2) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
}

// 上传
function doUploadIcon(){
    global $file,
           $uploadRealPath,
           $uploadPath;

    if (checkUpload() === 1){
        echo '<script>parent.layer.alert("文件类型错误！");</script>';
    }
    elseif(checkUpload() === 2){
        echo '<script>parent.layer.alert("文件大小超过限制！");</script>';
    }
    else{
        if ($file["error"] > 0){
            echo "错误: " . $file["error"] . "<br />";
            echo '<script>parent.layer.alert("错误：'. $file["error"] .'");</script>';
        }
        else{
            $oldname = $file["name"];
            $newname = date('YmdHi') . getMillisecond() .'.'. explode('.', $oldname)[1];
            if (file_exists($uploadRealPath . $newname)){
                echo $newname . " 已存在！ ";
            }
            else{
                if(!file_exists($uploadRealPath)){
                    mkdir($uploadRealPath, 0777,true);
                }
                move_uploaded_file($file["tmp_name"],$uploadRealPath . $newname);
                echo "已保存: " . $uploadPath . $newname;
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>文件上传</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <style>
        html,body{
            overflow: hidden;
        }
    </style>
</head>
<body>
<form class="form-inline" action="" method="post" enctype="multipart/form-data" onsubmit="return checkForm();">
    <div class="form-group">
        <label for="file" class="sr-only hide">上传文件</label>
        <input type="file" id="file" name="file">
    </div>
    <div class="form-group">
        <button class="btn btn-success btn-sm">上传</button>
        <input type="hidden" name="action" value="uploadIcon">
    </div>
</form>

<?php include RootPath .'/inc/common/js.php'?>
<script>
    function checkForm() {
        if($('#file').val() === ''){
            parent.layer.alert('请选择上传文件！');
            return false;
        }
    }
</script>
</body>
</html>