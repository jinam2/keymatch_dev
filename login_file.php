<?php
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");

$file		= $_GET["file"];
$tmp		= explode(".",$file);
$file_ext	= $tmp[sizeof($tmp)-1];
$file		= str_replace($file_ext,"",$file);
$file		= preg_replace("/\W/","",$file) .".". $file_ext;

$TPL->define("상세", "./$skin_folder/$file");
$TPL->assign("상세");
$내용 = &$TPL->fetch();

$TPL->define("껍데기", "./$skin_folder/login_default.html");
$TPL->assign("껍데기");
echo $TPL->fetch();

exit;



?>