<?php
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$현재위치 = "$prev_stand_bbs > <a href='./bbs_index.php'>커뮤티니</a> ";

	$TPL->define("리스트", "$skin_folder_bbs/bbs_index.html");
	$내용 = &$TPL->fetch();

	#오늘날짜 뽀너스로 구하기
	setlocale (LC_TIME, "ko_KR.UTF-8");
	$TPL->define("리스트", "$skin_folder_bbs/bbs_default.html");
	$TPL->assign("리스트");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";
	$TPL->tprint();

?>