<?php

	###################################################################
	###		SNS 로그인 사이트 개별 연동 파일 - 로그인 처리페이지	###
	###################################################################

	ob_start();
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");
	ob_end_clean();

	$happy_secure_key		= md5($site_name.$db_user.session_id().$_SERVER['REMOTE_ADDR']);

	if ( $_POST )
	{
		$SNS					= Array();
		$SNS['sns_id']			= $_POST['sns_id'];
		$SNS['sns_name']		= $_POST['sns_name'];
		$SNS['sns_username']	= $_POST['sns_username'];
		$SNS['sns_email']		= $_POST['sns_email'];
		$SNS['sns_image']		= $_POST['sns_image'];
		$SNS['sns_site']		= $_POST['sns_site'];
		$SNS['sns_hphone']		= $_POST['sns_hphone'];
		$SNS['sns_birthyear']	= $_POST['sns_birthyear'];
		$SNS['sns_birthmonth']	= $_POST['sns_birthmonth'];
		$SNS['sns_birthday']	= $_POST['sns_birthday'];
		$SNS['sns_gender']		= $_POST['sns_gender'];

		//팝업창인 경우 창을 닫기위해
		switch ( $SNS['sns_site'] )
		{
			// 키메디 SSO
			case 'keymedi'	:
				$is_sns_login_type	= "frame";
				break;
			case 'twitter'	:
			case 'kakao'	:
			case 'naver'	:
				$is_sns_login_type	= "popup";
				break;

			case 'facebook'	:
			case 'google'	:
				$is_sns_login_type	= "frame";
				break;
		}

		if ( $happy_secure_key != $_POST['post_happy_secure_key'] )
		{
			$alert_msg				= " SNS 로그인 검증키 확인이 실패했습니다.\\n 정상적인 경로를 이용해주세요.";
		}

		# 탈퇴한 회원인지 체크
		$Sql					= "SELECT Count(*) FROM $happy_member_out WHERE out_id = '$SNS[sns_site]_$SNS[sns_id]' ";
		list($outChk)			= happy_mysql_fetch_array(query($Sql));

		if ( $outChk > 0 )
		{
			$alert_msg				= " 탈퇴한 회원입니다.\\n 해당 아이디로 가입이 불가능합니다.";
		}

		# 휴면회원 체크
		$Sql					= "SELECT * FROM $happy_member_quies WHERE user_id = '$SNS[sns_site]_$SNS[sns_id]' ";
		$Rec					= query($Sql);
		$MEMBER_QUIES			= happy_mysql_fetch_assoc($Rec);

		if ( $MEMBER_QUIES['number'] != '' )
		{
			happy_member_quies_move('decrypt',$MEMBER_QUIES);
		}

		if ( $alert_msg != "" )
		{
			if ( $is_sns_login_type == "popup" )
			{
				msgclose($alert_msg);
			}
			else if ( $is_sns_login_type == "frame" )
			{
				msg($alert_msg);
			}
			exit;
		}

		//SNS 로그인 회원가입 처리 - hong
		$password				= happy_sns_login_member_join($SNS);

		//되돌아갈 URL
		$returnUrl				= ( $_POST['returnUrl'] != "" ) ? $_POST['returnUrl'] : $main_url;

		//로그인페이지로 submit
		echo "
		<form name='login_form' action='../happy_member_login.php?mode=login_reg' method='post'>
			<input type='hidden' name='returnUrl' value='$returnUrl'>
			<input type='hidden' name='member_id' value='$SNS[sns_site]_$SNS[sns_id]' />
			<input type='hidden' name='member_pass' value='$password' />
			<input type='hidden' name='is_sns_login_type' value='$is_sns_login_type' />
		</form>

		<script>
			window.onload = function() { document.forms['login_form'].submit(); }
		</script>
		";
		exit;
	}
	else
	{
		msgclose("전송된 정보가 없습니다.");
	}
?>