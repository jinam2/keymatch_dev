<?php

include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/function.php");
include ("../inc/lib.php");


$trigger = $_GET['trigger'];
$target = $_GET['target'];
$target2 = $_GET['target2'];
$target3 = $_GET['target3'];
$form = $_GET['form'];
$size = $_GET['size'];
$level = $_GET['level'];

$thread_r = $trigger . "r";

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// 항상 변경됨
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");



// 이쯤에서 db 처리해주고....
	$sql = "select * from $car_si_gu_dong where gu_number = '$trigger' ";
	$result = query($sql);
	$SI = happy_mysql_fetch_array($result);
	if ($SI[dong_title]){
		$etc_java = str_replace("/","\n",$SI[dong_title]);
		header("Content-Type: text/html; charset=utf-8");
		print "$form---cut---$etc_java";
	}
	else {
		header("Content-Type: text/html; charset=utf-8");
		print "$form---cut---";

	}








?>