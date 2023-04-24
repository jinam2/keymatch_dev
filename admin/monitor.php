<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");


	if ( !admin_secure("슈퍼관리자전용") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	//모니터링 관리자 인증 쿠키 생성
	if ( $_COOKIE['happy_monitor_admin'] == "" )
	{
		setcookie('happy_monitor_admin','ok',0,"/",$cookie_url);
	}


	//관리자메뉴 [ YOON :2009-10-07 ]
	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################

	//모니터링 내용부분 파일
	$monitor_include_check	= 1;

	$type					= $_GET['type'];

	if ( $type == "setting" )
	{
		include ("../monitor/setting.php");
	}
	else
	{
		include ("../monitor/content.php");
	}


	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################


?>