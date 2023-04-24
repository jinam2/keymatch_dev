<?
	include "inc/config.php";
	include "./inc/Template.php";
	$TPL = new Template;
	include "inc/function.php";
	include "inc/lib.php";
	include "inc/lib_sns.php";

	header("Content-Type: text/html; charset=UTF-8");

	$sns_site				= $_GET['sns_site'];
	$sns_id					= $_GET['sns_id'];
	$userkey				= $_GET['userkey'];

	//트위터, 카카오, 네이버 개별연동시 팝업창 닫기 - hong
	if ( $HAPPY_CONFIG['happy_sns_login_use_'.$sns_site] == "each" )
	{
		if ( happy_member_login_check() != "" )
		{
			echo 'ok';
		}
		exit;
	}
	else
	{
		$source_info			= get_url_fsockopen("http://analytics.cafe24.com/sns/sns_ajax_return.php?sns_site=$sns_site&sns_id=$sns_id&userkey=$userkey");

		$source					= sns_decode($happy_sns_securekey,$source_info);
	}

	if ( $source != '' )
	{
		$SNS					= sns_urldecode( $source );

		setcookie('sns_login_info', $source_info,0,"/");

		# 탈퇴한 회원인지 체크
		$Sql			= "SELECT Count(*) FROM $happy_member_out WHERE out_id = '${sns_site}_$SNS[sns_id]' ";
		list($outChk)	= happy_mysql_fetch_array(query($Sql));

		if ( $outChk > 0 )
		{
			echo "out_member";
			exit;
		}

		echo $SNS['status'].'___cut___';

		/*
		if ( $source['status'] == 'ok' )
		{
			echo
			echo "RETURN Data (encode) : ";
			print_r2($source);
		}
		*/
		#echo $_SERVER['REMOTE_ADDR'];


		if ( $SNS['status'] != 'ok' )
		{
			exit;
		}


		//SNS 로그인 회원가입 처리 - hong
		$SNS['sns_site']	= $sns_site;
		$SNS['is_ajax']		= true;
		$password			= happy_sns_login_member_join($SNS);


		echo "
			<form action='./happy_member_login.php?mode=login_reg' method='post' name='sns_auto_login'>
				<input type='hidden' name='returnUrl' id='returnUrl' value=''>
				<input type='hidden' name='member_id' id='member_id' value='${sns_site}_$SNS[sns_id]' />
				<input type='hidden' name='member_pass' id='member_pass' value='$password' />
			</form>
		";
	}
?>