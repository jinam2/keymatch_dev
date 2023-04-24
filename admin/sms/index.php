<?
include "../../inc/config.php";
include "../../inc/function.php";

if ( !isset($HTTP_COOKIE_VARS["ad_id"]) && !$admin) {
		echo "<script>alert('로그인후 이용해주십시오.');window.location.href='../';</script>";
		exit;
}
else
{

	echo "
	<form name='sms_login_frm' method='post' action='https://happysms.cgimall.co.kr/login.php'>
	<input type='hidden' name='userid' value='$sms_userid' >
	</form>
	<script>
		document.forms[0].submit();
		history.go(-1);
	</script>
	";
}
?>