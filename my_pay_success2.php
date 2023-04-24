<?php
include ("./inc/Template.php");
$TPL = new Template;

include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");
include ("./inc/lib_pay.php");

if($_GET['type'] != "point")
{
	if($pg_company_info == "daoupay")
	{
		$pg_target	= ($_COOKIE['happy_mobile'] != "on")?"opener.top":"top";
		if($_GET['location_chk'] != 1)
		{
			echo "
					<script>
						{$pg_target}.location.href='$_SERVER[REQUEST_URI]&location_chk=1';
						window.close();
					</script>
			";
			exit;
		}
	}
}



$res_cd = $_REQUEST[respcode];
$Opt01 = $_REQUEST[oid];


if ($res_cd == "0000")  //결제 성공
{
	$현재위치	= "$prev_stand > <a href='./member_index.php'>마이페이지</a> > 유료결제성공";
	$template	= $main_url."/html_file.php?file=my_pay_success.html&file2=default.html";


	#결제성공시 관리자에게 쪽지 보내기 2009-11-17 kad
	if ( $HAPPY_CONFIG['MessageUryoSuccessUse'] == "1" )
	{
		$HAPPY_CONFIG['MessageUryoSuccess'] = str_replace("{{아이디}}",$mem_id,$HAPPY_CONFIG['MessageUryoSuccess']);
		$HAPPY_CONFIG['MessageUryoSuccess'] = str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['MessageUryoSuccess']);

		$HAPPY_CONFIG['MessageUryoSuccess'] = addslashes($HAPPY_CONFIG['MessageUryoSuccess']);

		$sql = "select * from ".$happy_member." where user_id = '".$mem_id."'";
		$result = query($sql);
		$Tmem = happy_mysql_fetch_assoc($result);

		$sql = "INSERT INTO ";
		$sql.= $message_tb." ";
		$sql.= "SET ";
		$sql.= "sender_id = '".$mem_id."', ";
		$sql.= "sender_name = '".$Tmem['user_name']."', ";
		$sql.= "sender_admin = 'n', ";
		$sql.= "receive_id = '".$admin_id."', ";
		$sql.= "receive_name = '관리자', ";
		$sql.= "receive_admin = 'y', ";
		$sql.= "message = '".$HAPPY_CONFIG['MessageUryoSuccess']."', ";
		$sql.= "regdate = now() ";
		query($sql);
	}
	#결제성공시 관리자에게 쪽지 보내기 2009-11-17 kad

	#결제성공시 관리자에게 문자발송하기
	if ( $HAPPY_CONFIG['SmsUryoSuccessUse'] == "1" || $HAPPY_CONFIG['SmsUryoSuccessUse'] == "kakao" )
	{
		#sms_convert($sms_text,$per_name='',$or_no='',$stats='',$per_pass='',$per_cell='',$product_name='',$etc='',$confirm_number='',$per_id = '')
		#문자보낼문자열,이름,주문번호,상태,비밀번호,휴대폰번호,상품명,기타,인증번호,아이디
		$SMSMSG["SmsUryoSuccess"] = sms_convert($HAPPY_CONFIG["SmsUryoSuccess"],'','','','',$site_phone,'','','',$mem_id);

		#사용법 echo sms_send(전송후반응타입,받을사람전번,회신전번,전송후이동주소,sms메세지,암호화여부(on/off));
		//echo $regist_send = sms_send(0,$site_phone,$site_phone,"",$SMSMSG["SmsUryoSuccess"],"1000","","",$HAPPY_CONFIG["SmsUryoSuccessUse"],$HAPPY_CONFIG["SmsUryoSuccess_ktplcode"]);
		$dataStr = send_sms_msg($sms_userid,$site_phone,$site_phone,$SMSMSG['SmsUryoSuccess'],5,$sms_testing,'',$HAPPY_CONFIG['SmsUryoSuccessUse'],$HAPPY_CONFIG['SmsUryoSuccess_ktplcode']);
		send_sms_socket($dataStr);
		#gomsg("아이디를 SMS문자로 발송했습니다.","index.php");
	}
	#결제성공시 관리자에게 문자발송하기

	$sql		= "select * from $jangboo where or_no='$oid' ";
	$JANGBOO	= happy_mysql_fetch_assoc(query($sql));

	$sql		= "select * from $jangboo2 where or_no='$oid' ";
	$JANGBOO2	= happy_mysql_fetch_assoc(query($sql));

	//개인회원용
	if ( $JANGBOO['number'] == "" && $JANGBOO2['number'] != "" )
	{
		$JANGBOO	= $JANGBOO2;
	}

	if( $JANGBOO['number'] > 0 && $JANGBOO['in_check'] == '1' )
	{
		$Member			= happy_member_information($JANGBOO['or_id']);

		if ( $HAPPY_CONFIG['MessageUryoSuccessMyUse'] == "1" )
		{
			$HAPPY_CONFIG['MessageUryoSuccessMy'] = str_replace("{{아이디}}",$Member['user_id'],$HAPPY_CONFIG['MessageUryoSuccessMy']);
			$HAPPY_CONFIG['MessageUryoSuccessMy'] = str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['MessageUryoSuccessMy']);

			$HAPPY_CONFIG['MessageUryoSuccessMy'] = addslashes($HAPPY_CONFIG['MessageUryoSuccessMy']);

			$sql = "select * from ".$happy_member." where user_id = '".$mem_id."'";
			$result = query($sql);
			$Tmem = happy_mysql_fetch_assoc($result);

			$sql = "INSERT INTO ";
			$sql.= $message_tb." ";
			$sql.= "SET ";
			$sql.= "sender_id = '".$Member['user_id']."', ";
			$sql.= "sender_name = '".$Member['user_name']."', ";
			$sql.= "sender_admin = 'n', ";
			$sql.= "receive_id = '".$admin_id."', ";
			$sql.= "receive_name = '관리자', ";
			$sql.= "receive_admin = 'y', ";
			$sql.= "message = '".$HAPPY_CONFIG['MessageUryoSuccessMy']."', ";
			$sql.= "regdate = now() ";
			query($sql);
		}

		if ( $HAPPY_CONFIG['SmsUryoSuccessMyUse'] == "1" || $HAPPY_CONFIG['SmsUryoSuccessMyUse'] == "kakao" )
		{
			$SMSMSG["SmsUryoSuccessMy"] = sms_convert($HAPPY_CONFIG["SmsUryoSuccessMy"],'','','','',$site_phone,'','','',$Member['user_id']);

			$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['SmsUryoSuccessMy'],5,$sms_testing,'',$HAPPY_CONFIG['SmsUryoSuccessMyUse'],$HAPPY_CONFIG['SmsUryoSuccessMy_ktplcode']);
			send_sms_socket($dataStr);
		}
	}
}
else
{
	$현재위치 = "$prev_stand > <a href='./member_index.php'>마이페이지</a> > 유료결제실패";
	$template	= $main_url."/html_file.php?file=my_pay_failure.html&file2=default.html";
}

echo "<script>window.location.href = '$template';</script>";
exit;


?>