<?php
$url = "www.mytest.com/index3.php";
$filename = 'curl.jpg';
getImg($url, $filename);
/*
  *@通过curl方式获取制定的图片到本地
  *@ 完整的图片地址
  *@ 要存储的文件名
 */
function getImg($url = "", $filename = "") {
    if(is_dir(basename($filename))) {
        echo "The Dir was not exits";
        return false;
    }
    //去除URL连接上面可能的引号
    //$url = preg_replace( '/(?:^['"]+|['"/]+$)/', '', $url );
    $hander = curl_init();
    $fp = fopen($filename,'wb');
    curl_setopt($hander,CURLOPT_URL,$url);
    curl_setopt($hander,CURLOPT_FILE,$fp);
    curl_setopt($hander,CURLOPT_HEADER,0);
    curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($hander,CURLOPT_RETURNTRANSFER,true);//以数据流的方式返回数据,当为false是直接显示出来
    curl_setopt($hander,CURLOPT_TIMEOUT,60);
    /*$options = array(
        CURLOPT_URL=> '/thum-f3ccdd27d2000e3f9255a7e3e2c4880020110622095243.jpg',
        CURLOPT_FILE => $fp,
        CURLOPT_HEADER => 0,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_TIMEOUT => 60
    );
    curl_setopt_array($hander, $options);
    */
    curl_exec($hander);
    curl_close($hander);
    fclose($fp);
    return  true;
}
?>