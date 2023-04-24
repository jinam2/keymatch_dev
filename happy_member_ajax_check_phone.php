<?
include ("./inc/config.php");
include ("./inc/Template.php");
$t_start = array_sum(explode(' ', microtime()));
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");
include ("./inc/happy_sms.php");


$per_cell	= $_GET['per_cell'];
$mem_id		= $_GET['mem_id'];

if ( $per_cell == "" )
{
	echo "핸드폰번호가 없습니다.";
	exit;
}

if( strlen($per_cell) < 10 )
{
	echo "휴대폰 번호가 너무 짧습니다.";
	exit;
}

if ( preg_match("/[a-zA-Zㄱ-힝]/",$per_cell) )
{
	echo "핸드폰 번호의 형식이 틀렸습니다.";
	exit;
}

$per_cell2	= preg_replace("/\-/","",$per_cell);


$happy_member_login_id	= happy_member_login_check();
$id_query = "";
if ( $happy_member_login_id != "" )
{
	$id_query = " and user_id != '".$happy_member_login_id."' ";
}

$sql = "select * from $happy_member where ( user_hphone='$per_cell' or user_hphone = '$per_cell2' ) $id_query ";
$result = query($sql);
$pid = mysql_fetch_row($result);


$sql = "select * from $happy_member_quies where ( user_hphone='$per_cell' or user_hphone = '$per_cell2' ) $id_query ";
$result = query($sql);
$pid2 = mysql_fetch_row($result);



//$pid[0] = '';
//동일한 폰번호가 존재하는 경우.
if( $pid[0] > 0 || $pid2[0] > 0 )
{
	echo "동일한 휴대폰번호가 존재합니다.";
	exit;
}
else
{
	$success_message = "success___CUT___";
	#사용자가 입력한 전화번호를 잘라놓자
	$per_cell_a		= explode("-",$per_cell);

	$per_cell2		= preg_replace('/\D/', '', $per_cell);
	$confirm_number	= rand(100000,999999);

	$happy_member_iso_phone_message	= happy_member_sms_convert($happy_member_iso_phone_message,Array('{{인증번호}}'=>$confirm_number));

	if ( $demo_lock || preg_match("/".base64_decode("YWFhLmNvbQ==")."/",$_SERVER['SERVER_NAME']))
	{
		//echo $happy_member_iso_phone_message;
		$demo_number = $happy_member_iso_phone_message;
	}

	#새 핸드폰번호를 DB에 넣자 (기존에 있다면 지우고 넣자)
	$sql	= "DELETE  FROM $happy_member_sms_confirm WHERE phone_number ='$per_cell2'";
	$result	= query($sql);

	$sql	= "
				INSERT INTO
						$happy_member_sms_confirm
				SET
						phone_number	= '$per_cell2',
						confirm_code	= '$confirm_number'
	";
	query($sql);
	//echo $sql;

	#문자를 발송해주고 입력모드로 가자
	//happy_sms_send_snoopy( $sms_userid, $sms_user_pass, $sms_phone, $sms_callback,$sms_message, $sms_type = 1, $sms_returnUrl = '', $returyType = '' )
	happy_sms_send_snoopy( "$HAPPY_CONFIG[sms_userid]", "$HAPPY_CONFIG[sms_userpass]", "$per_cell", "$site_phone","$happy_member_iso_phone_message", "", '', '' );
	//echo $buyer_send	= sms_send(0,"$per_cell","$site_phone","","$happy_member_iso_phone_message","1000");

	$TPL->define("휴대폰인증창", "$happy_member_skin_folder/iso_hphone_check.html");
	$휴대폰인증창 = &$TPL->fetch();

	$success_message .= $휴대폰인증창;

	echo $success_message;
	exit;
}
?>