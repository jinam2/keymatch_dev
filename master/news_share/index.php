<?php
	//뉴스 공유 client
	include ("../../inc/config.php");
	include ("../../inc/config_server.php");
	include("inc/function.php");
	include("../../inc/ns_lib_encode.php");
	include("inc/lib.php");
	include("../../inc/ns_Template.php");
	include("../../inc/ns_Template_make.php");

	if ( $demo_lock == 1 )
	{
		//msgclose("뉴스 솔루션 데모에서는 사용하실수 없는 기능입니다.");
		//exit;
	}

	//print_r($GLOBALS);

	//뉴스 솔루션 관리자 체크
	if ( news_admin_check() == false )
	{
		error("접속 권한이 없습니다.");
		exit;
	}


	//뉴스상점 로그인 체크
	$login_info = get_news_store_info();

	if ( news_store_login_result($login_info['id'],$login_info['pass']) == "ok" )
	{
		$str = '<form name="regiform" action="'.$news_store_url2.$news_store_login_path.'?mode=login_reg" method="post">';
		$str.= '<input type="hidden" name="member_id" value="'.$login_info['id'].'">';
		$str.= '<input type="hidden" name="member_pass" value="'.$login_info['pass'].'">';
		$str.= '<input type="hidden" name="pass_type" value="enc">';
		$str.= '<input type="hidden" name="returnUrl" value="/">';
		//조용히 로그인
		$str.= '<input type="hidden" name="ready_check" value="no">';
		$str.= '<input type="hidden" name="alert_check" value="no">';
		//작은사이즈용 쿠키변수
		$str.= '<input type="hidden" name="ns_small_site" value="on">';
		$str.= '</form>';
		$str.= '<script>document.regiform.submit();</script>';
		echo $str;
		exit;
	}
	else
	{
		msg("뉴스 상점 사이트에 로그인하기 위한 정보가 잘못 되었습니다.");
		go("store_login.php?mode=setting&returnUrl=/");
		exit;
	}


?>

