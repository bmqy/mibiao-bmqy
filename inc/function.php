<?php

// 输出信息到页面
function output($str){
    echo $str;
}

// 跳转到指定网址
function redirect($url){
    header('Location:'. $url);
}

// 设置cookie
function setCookies($name, $value, $expire){
    if(empty($expire)){
        $expire = time()+3600*24;
    }
    setcookie($name, $value, $expire, '/');
}

// 值为空时，输出自定义默认值
function formatOutput($input, $defaultOutput){
    if(empty($input)){
        echo $defaultOutput;
    }
    else{
        echo $input;
    }
}
// 值为空时，返回自定义默认值
function formatReturn($input, $defaultOutput){
    if(empty($input)){
        return $defaultOutput;
    }
    else{
        return $input;
    }
}

// 判断条件真假输出所需内容
function outputByBoolean($boolean, $trueOutput, $falseOutput){
    if($boolean){
        echo $trueOutput;
    }
    else{
        echo $falseOutput;
    }
}
// 判断条件真假返回所需值
function returnByBoolean($boolean, $trueReturn, $falseReturn){
    if($boolean){
        return $trueReturn;
    }
    else{
        return $falseReturn;
    }
}

// 判断是否移动设备
function isMobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = Array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte");
    $is_mobile = false;

    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}

// 生成 a 链接
function getALinks($url, $title, $target, $className){
    if(empty($url)){
        return;
    }
    $output = '<a href="'. $url .'"';
    if(empty($title)){
        $title = $url;
    }
    if(empty($target)){
        $target = getConfigValue('site_link_target');
    }
    $output = $output .' title="'. $title .'"';
    $output = $output .' target="'. $target .'"';
    if(!empty($className)){
        $output = $output .' class="'. $className .'"';
    }
    $output = $output .'>';
    $output = $output . $title;
    $output = $output .'</a>';
    echo $output;
}

// 返回带单位的价格
function getPriceWithUnit($price){
    if(empty($price)){
        return;
    }
    $output = $price .'￥';
    return $output;
}

// 获取指定网站配置项
function getConfigValue($keys){
    $result = '';
    $con = getConnection();
    $sql = 'SELECT config_val FROM mb_config WHERE config_key ="'. $keys .'"';
    $rs = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($rs)){
        $result = $row['config_val'];
    }
    if(empty($result)){
        $result = '';
    }
    mysqli_close($con);
    return $result;
}

// 更新域名浏览次数
function updateDomainViewsCount($id){
    if(!empty($id)){
        $con = getConnection();
        $sql = 'UPDATE mb_domain SET viewsCount = viewsCount + 1 WHERE id ='. $id;
        mysqli_query($con, $sql);
        mysqli_close($con);
    }
}

// 获取域名出售状态
function getDomainSaleStatusText($values){
    switch ($values){
        case 1:
            return '已出售';
            break;
        case 2:
            return '推荐';
            break;
        case 3:
            return '特价/优惠';
            break;
        default:
            return '出售中';
            break;
    }
}

// 获取域名whois信息
class getDomainWhois {
    private $resultType = 'json';
    private $domain;

    public function __construct($domain){
        $this->domain = $domain;
    }

    public function getWhoisApi(){
        $whoisapi = 'https://www.whoisxmlapi.com/whoisserver/WhoisService?domainName='. $this->domain.'&outputFormat='. $this->resultType .'&username=88268459&password=1472350698';
        return $this->whoisapi = $whoisapi;
    }

    public function getResult(){
        $result = file_get_contents($this->getWhoisApi());
        return json_decode($result,true);
    }

    public function getCreatedDate(){
        return $this->getResult()['WhoisRecord']['registryData']['createdDate'];
    }

    public function getUpdatedDate(){
        return $this->getResult()['WhoisRecord']['registryData']['updatedDate'];
    }

    public function getExpiresDate(){
        return $this->getResult()['WhoisRecord']['registryData']['expiresDate'];
    }
}

// 生成指定表、指定字段下拉列表
function getSelectOptions($table, $fieldId, $fieldName, $defaultId){
    $con = getConnection();
    $argsCount = func_num_args();
    if($argsCount < 3){
        return '参数错误';
    }
    else{
        $sql = 'SELECT '. $fieldId .','. $fieldName .' FROM '. $table .' WHERE 1=1';
        $rs = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($rs)){
            echo '<option value="'. $row[$fieldId] .'" '. returnByBoolean($row[$fieldId]===$defaultId, 'selected', '') .'>'. $row[$fieldName] .'</option>';
        }
    }
}

// 获取域名注册商
function getDomainRegistrarName($registrarId){
    $result = '';
    if(!empty($registrarId)){
        $con = getConnection();
        $sql = 'SELECT name FROM mb_registrar WHERE id ='. $registrarId;
        $rs = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($rs)){
            $result = $row['name'];
        }
        if(empty($result)){
            $result = '未知';
        }
        mysqli_close($con);
    }
    return $result;
}

// 获取注册商域名出售页链接
function getRegistrarSalePage($registrarId, $domain){
    $con = getConnection();
    if(!empty($registrarId)){
        $sql = 'SELECT name,salePageUrl FROM mb_registrar WHERE id='. $registrarId;
        $rs = mysqli_query($con,$sql);
        if($row = mysqli_fetch_array($rs)){
            if(!empty($row['salePageUrl'])){
                getALinks(str_replace('{domain}', $domain, $row['salePageUrl']),getDomainRegistrarName($registrarId), '_blank', 'btn btn-links btn-info btn-xs');
            }
            else{
                echo getDomainRegistrarName($registrarId);
            }
        }
    }
}

// 获取bing背景图
function getBingBgimg(){
    $s = $_GET['s'];
    if($s == 'big'){
        $str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');
        $array = json_decode($str);
        $imgurl = $array->{"images"}[0]->{"url"};//图片URL
        //$copyright = $array->{"images"}[0]->{"copyright"};//图片描述版权
    }else{
        $str=file_get_contents('http://cn.bing.com/HPImageArchive.aspx?idx=0&n=1');
        if(preg_match("/<url>(.+?)<\/url>/ies",$str,$matches)){
            $imgurl='http://cn.bing.com'.$matches[1];
        }
    }
    if(empty($imgurl)){
        $imgurl = 'https://bmqy.github.io/css/imgs/bg.jpg';
    }
    return $imgurl;
}

?>