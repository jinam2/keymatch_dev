<?php
	$t_start = array_sum(explode(' ', microtime()));

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	#load_config();

	$happy_member_login_id	= happy_member_login_check();

	if( $happy_member_login_id == ""  ) {
		$returnUrl = $_SERVER['PHP_SELF']."?mode=".$_GET['mode'];

		gomsg("로그인후 이용가능합니다.",$main_url."/happy_member_login.php?returnUrl=".$returnUrl);
		#gomsg("회원로그인후 사용할수 있는 페이지입니다","index.php");
		exit;
	}

	$mode					= ( $_GET['mode'] != "" ) ? $_GET['mode'] : $_POST['mode'];
	$number					= ( $_GET['number'] != "" ) ? $_GET['number'] : $_POST['number'];;

	if ( $number == "" )
	{
		error("문의 고유번호가 없습니다.");
		exit;
	}

	$Sql				= "SELECT * FROM $happy_inquiry WHERE number = '$number' ";
	$Result				= query($Sql);
	$Data				= happy_mysql_fetch_array($Result);

	if ( $happy_member_login_id != $Data['receive_id'] && $happy_member_login_id != $Data['send_id'] )
	{
		error('권한이 없습니다.');
		exit;
	}

	$Sql				= "SELECT * FROM $happy_inquiry_links WHERE number='$Data[links_number]' ";
	$Result				= query($Sql);
	$Links				= happy_mysql_fetch_array($Result);

	$고유번호			= $number;
	$담당자			= ( $Links['guin_name'] == "" )	? "정보없음" : $Links['guin_name'];
	$메일주소			= ( $Links['guin_email'] == "" )		? "정보없음" : $Links['guin_email'];
	$연락처				= ( $Links['guin_phone'] == "" )		? "정보없음" : $Links['guin_phone'];
	$채용정보제목				= $Links["guin_title"];
	$업체이미지			= $Links["photo2"];
	$처리상태			= $happy_inquiry_stats_title[$Data['stats']];

	$no_links_display	= "";
	if ( $Links['number'] == "" )
	{
		$no_links_display	= " display:none; ";
	}


	$templateFile		= "happy_inquiry_print.html";
	$default_skin		= "default_blank_pop.html";

	if( !(is_file("$skin_folder/$templateFile")) ) {
		print "$skin_folder/$templateFile 파일이 존재하지 않습니다. ";
		exit;
	}

	$TPL->define("알맹이", "$skin_folder/$templateFile");
	$내용 = &$TPL->fetch();


	if( !(is_file("$skin_folder/$default_skin")) ) {
		print "$skin_folder/$default_skin 파일이 존재하지 않습니다. ";
		exit;
	}

	$TPL->define("리스트", "$skin_folder/$default_skin");
	$TPL->assign("리스트");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();


?>