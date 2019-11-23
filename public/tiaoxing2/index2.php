<?php
//header("Content-type:image/png");
//二维码生成测试
include ".".DIRECTORY_SEPARATOR."phpqrcode".DIRECTORY_SEPARATOR."qrlib.php";
$value = 'http://www.qq.com/'; //二维码内容 

$errorCorrectionLevel = 'H';//容错级别 

$matrixPointSize = 10;//生成图片大小 1--10

//QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2);//第二个参数为false不保存二维码图片
//$imgfile = QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2);
//QRcode::png($value,'false.png', $errorCorrectionLevel, $matrixPointSize, 2);
//$img_str = QRcode::png($value,'false.png', $errorCorrectionLevel, $matrixPointSize, 2);
//$im = imagecreatefrompng(QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2)); 
//imagepng($im);
//imagedestroy($im);
QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2);