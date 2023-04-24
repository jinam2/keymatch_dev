<?php
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	//$현재위치 = "$prev_stand_bbs > <a href='./bbs_index.php'>커뮤티니</a> ";
	$현재위치 = "<li class=\"home\"><img src=\"./img/ico_home.gif\" alt=\"아이콘\" width=\"15\" height=\"15\"> <a href=\"./\">HOME</a></li>
		<li class=\"loc_name\"><a href=\"./bbs_customer.php\">고객센터</a></li>
		<li class='loc_name_end'><div class='n1'></div><div class='n2'>메인</div></li>
	";

	if ($_GET["mode"] == "customer_center")
	{
		$TPL->define("리스트", "$skin_folder_bbs/bbs_customer_center.html");
	}
	else
	{
		$TPL->define("리스트", "$skin_folder_bbs/bbs_customer_center.html");
	}
	$내용 = &$TPL->fetch();

	#오늘날짜 뽀너스로 구하기
	setlocale (LC_TIME, "ko_KR.UTF-8");
	$TPL->define("리스트", "$skin_folder_bbs/bbs_default.html");
	$TPL->assign("리스트");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	if ($demo_lock)
	{
		$exec_time = array_sum(explode(' ', microtime())) - $t_start;
		$exec_time = round ($exec_time, 2);

		$쿼리시간 =  "<p align='center' style='clear:both; font-family:Arial; font-size:11px; padding-bottom:20px; border:0px solid red;'>Query Time : $exec_time sec</p>";
	}
	$TPL->tprint();

?>