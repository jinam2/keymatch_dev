<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	if($_SESSION['user_id_quies'] == "")
	{
		gomsg("정상적인 접근이 아닙니다","happy_member_login.php");
		exit;
	}

	$Sql				= "SELECT * FROM $happy_member_quies WHERE user_id='$_SESSION[user_id_quies]' ";
	$Rec				= query($Sql);
	$User				= happy_mysql_fetch_assoc($Rec);

	if($User['user_id'] == "")
	{
		gomsg("정상적인 접근이 아닙니다","happy_member_login.php");
		exit;
	}


	$quies_date					= date("Y년 m월 d일", strtotime($User['login_date']."+{$HAPPY_CONFIG[quies_day]} day"));


	$user_id_urlencode		= urlencode($User['user_id']);

	$user_email_decrypt		= happy_member_quies_crypt("decrypt",Array('user_email' => $User['user_email']));
	$user_email_urlencode	= urlencode($user_email_decrypt['user_email']);

	$user_hphone_decrypt	= happy_member_quies_crypt("decrypt",Array('user_hphone' => $User['user_hphone']));
	$user_hphone_urlencode	= urlencode($user_hphone_decrypt['user_hphone']);
	setcookie('happy_tmp_id',$User['user_id'],0,"/",$happy_member_login_value_url);

	

	//preg_match(/email.*hphone/)
	if(preg_match("/email.+hphone+/",$HAPPY_CONFIG['quies_clear_type']))
	{
		$email_img				= "<img src='img/btn_member_quies_iso_email.gif' style='cursor:pointer' onClick=\"quies_iso_popup('email');\" alt='이메일인증'>";
		$hphone_img				= "<img src='img/btn_member_quies_iso_phone.gif' style='cursor:pointer; margin-top:3px;' onClick=\"quies_iso_popup('hphone');\" alt='휴대폰인증'>";

		$email_img_mobile	= "<img src='mobile_img/btn_member_quies_iso_email.gif' style='cursor:pointer; max-width:100%; height:auto;' onClick=\"quies_iso_popup('email');\" alt='이메일인증'>";
		$hphone_img_mobile	= "<img src='mobile_img/btn_member_quies_iso_phone.gif' style='cursor:pointer; margin-top:3px; max-width:100%; height:auto;' onClick=\"quies_iso_popup('hphone');\" alt='휴대폰인증'>";
	}
	else if($HAPPY_CONFIG['quies_clear_type'] == "email")
	{
		$email_img				= "<img src='img/' style='cursor:pointer' onClick=\"quies_iso_popup('email');\" alt='이메일인증'>";
		$email_img_mobile	= "<img src='mobile_img/btn_member_quies_iso_email.gif' style='cursor:pointer; max-width:100%; height:auto;' onClick=\"quies_iso_popup('email');\" alt='이메일인증'>";
	}
	else if($HAPPY_CONFIG['quies_clear_type'] == "hphone")
	{
		$hphone_img	= "<img src='img/btn_member_quies_iso_phone.gif' style='cursor:pointer' onClick=\"quies_iso_popup('hphone');\" alt='휴대폰인증'>";
		$hphone_img_mobile	= "<img src='mobile_img/btn_member_quies_iso_phone.gif' style='cursor:pointer; max-width:100%; height:auto;' onClick=\"quies_iso_popup('hphone');\" alt='휴대폰인증'>";
	}
	else
	{
		$quies_admin_message	= "관리자에게 문의하세요";
	}

	$TPL->define("로그인페이지", "$happy_member_skin_folder/happy_member_quies_iso.html");
	$content = &$TPL->fetch("로그인페이지");


	$내용	= $content;



	if( !(is_file("$happy_member_skin_folder/happy_member_login_default.html")) ) {
		$content = "껍데기 $happy_member_skin_folder/happy_member_login_default.html 파일이 존재하지 않습니다. <br>";
		return;
	}
	$TPL->define("껍데기", "$happy_member_skin_folder/happy_member_login_default.html");
	$content = &$TPL->fetch();


	echo $content;


	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' && $_COOKIE['happy_mobile'] != "on" )
	{
		print $쿼리시간;
	}



?>