<?php
//header("Content-type:image/png");
//��ά�����ɲ���
include ".".DIRECTORY_SEPARATOR."phpqrcode".DIRECTORY_SEPARATOR."qrlib.php";
$value = 'http://www.qq.com/'; //��ά������ 

$errorCorrectionLevel = 'H';//�ݴ��� 

$matrixPointSize = 10;//����ͼƬ��С 1--10

//QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2);//�ڶ�������Ϊfalse�������ά��ͼƬ
//$imgfile = QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2);
//QRcode::png($value,'false.png', $errorCorrectionLevel, $matrixPointSize, 2);
//$img_str = QRcode::png($value,'false.png', $errorCorrectionLevel, $matrixPointSize, 2);
//$im = imagecreatefrompng(QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2)); 
//imagepng($im);
//imagedestroy($im);
QRcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2);