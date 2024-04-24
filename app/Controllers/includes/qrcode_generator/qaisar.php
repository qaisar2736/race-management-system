<?php 

$PNG_TEMP_DIR = FCPATH . '/' . 'qr_code_images'.'/';//dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

//html PNG location prefix
$PNG_WEB_DIR = FCPATH . '/' . 'qr_code_images'. '/';//'temp/';

include "qrlib.php";    

$errorCorrectionLevel = 'M';
if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
    $errorCorrectionLevel = $_REQUEST['level'];    

$matrixPointSize = 5;
if (isset($_REQUEST['size']))
    $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);



$filename = $PNG_TEMP_DIR.$image;

QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   

