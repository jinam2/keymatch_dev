<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");
?>

	<html>
	<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
	<meta name="format-detection" content="telephone=no"/>

	<style type='text/css'>
		html,body { height:100%; margin:0px; padding:0px;}
	</style>

	<script language='JavaScript' >

	//ID 체크후 값 되돌리기
	function lastsetting(per_cell,confirm_number) {
		opener.document.happy_member_reg.user_hphone.value			= per_cell;
		opener.document.happy_member_reg.user_hphone_check.value	= confirm_number;
		//opener.document.happy_member_reg.user_hphone.readOnly		= true;
		try
		{
			opener.document.happy_member_reg.iso_hphone.value					= 'y';
			opener.document.happy_member_reg.user_hphone_original.value			= per_cell;
			opener.document.getElementById('iso_button_hphone').style.display	= 'none';
		}
		catch (e)
		{
		}
		self.close();
	}

	</script>
	</head>

	<body>

<?




	if ( $per_cell == "" ) {
		msgclose("핸드폰 번호를 입력하세요");
		exit;
	}

	if ($mode == '')
	{
		#사용자가 입력한 전화번호를 잘라놓자
		$per_cell_a		= explode("-",$per_cell);

		$per_cell		= preg_replace('/\D/', '', $per_cell);
		$confirm_number	= rand(100000,999999);

		$happy_member_iso_phone_message	= happy_member_sms_convert($happy_member_iso_phone_message,Array('{{인증번호}}'=>$confirm_number));

		/*
		if ( $happy_member_iso_phone_test == 'test' )
		{
			echo $happy_member_iso_phone_message;
		}
		*/

		if ( $demo_lock )
		{
			echo $happy_member_iso_phone_message;
		}

		#새 핸드폰번호를 DB에 넣자 (기존에 있다면 지우고 넣자)
		$sql	= "DELETE  FROM $happy_member_sms_confirm WHERE phone_number ='$per_cell'";
		$result	= query($sql);

		$sql	= "
					INSERT INTO
							$happy_member_sms_confirm
					SET
							phone_number	= '$per_cell',
							confirm_code	= '$confirm_number'
		";
		query($sql);

		#echo $happy_member_iso_phone_message;

		#문자를 발송해주고 입력모드로 가자
		//$buyer_send	= sms_send(0,"$per_cell","$site_phone","","$happy_member_iso_phone_message","1000");
		send_sms_socket(send_sms_msg($sms_userid,$per_cell,$site_phone,$happy_member_iso_phone_message,5,$sms_testing,'','',''));

		#문자 발송했으면 되돌리자
		$per_cell = implode("-", (array) $per_cell_a);

		#데모면 문자 보낸 번호를 보여주자
		if ( $demo_lock )
		{
			$demo_value = $confirm_number;
		}
		else
		{
			$demo_value = '';
		}


		echo "
				<div style='display:none;'>$buyer_send <!-- 요거 없애면 안됨--></div>
				<form name='f' method='post' action='$PHP_SELF' style='margin:0px; padding:0px; height:100%;'>
				<input type=hidden name=per_cell value='$per_cell'>
				<input type=hidden name=mode value='confirm_ok'>
				<input type='hidden' name='quies_mode' value='$_POST[quies_mode]'> <!-- happy_member_quies -->

				<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
				<tr>
					<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
						<strong>> 휴대폰인증</strong>
					</td>
				</tr>
				<tr>
					<td style='text-align:center;'>
						<div style='color:#333333; font-size:20px;'><strong>$per_cell</strong><div>
						<div style='color:#333333; font-size:12px; margin-top:10px; line-height:20px;'>문자가 발송되었습니다.<br />발송된 인증번호를 입력하세요.</div>
						<div style='font-size:12px; color:#4260fe; width:80%; margin:0 auto;'>$happy_member_iso_phone_message</div>
						<div style='margin-top:10px;'>
							<input type='text' name='input_confirm_number' value='$demo_value' style='width:80%; height:30px; line-height:30px; padding-left:10px; border:2px solid #dfdfdf; background:#fafafa;'>
						</div>
					</td>
				</tr>
				<tr>
					<td style='height:40px;'>
						<input type='submit' value='인증번호입력' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
					</td>
				</tr>
				</table>
				</form>
		";
		exit;

	}

	elseif ($mode == 'confirm_ok')
	{
		#잘라놓자
		$per_cell_a	= explode("-",$per_cell);
		$per_cell	= preg_replace('/\D/', '', $per_cell);


		if($_SESSION['user_id_quies'] != "")
		{
			$SWAP_MEMBER			= Array();
			$Sql					= "SELECT * FROM $happy_member_quies WHERE user_id='$_SESSION[user_id_quies]' ";
			$Rec					= query($Sql);
			while($MEMBER_QUIES		= happy_mysql_fetch_assoc($Rec))
			{
				$QUIES_DECRYPT	= happy_member_quies_crypt('decrypt',Array('user_hphone' => $MEMBER_QUIES['user_hphone']));

				if(preg_replace('/\D/','',$QUIES_DECRYPT['user_hphone']) == $per_cell)
				{
					$SWAP_MEMBER	= $MEMBER_QUIES;
					break;
				}
			}

			if(sizeof($SWAP_MEMBER) == 0)
			{
				msgclose("잘못된 정보입니다");
				exit;
			}
		}



		$sql		= "SELECT * FROM  $happy_member_sms_confirm WHERE phone_number ='$per_cell' AND confirm_code = '$input_confirm_number' ";
		$result		= query($sql);
		$CHECK		= happy_mysql_fetch_array($result);

		#합치자
		$per_cell	= implode("-", (array) $per_cell_a);

		if ($CHECK[number]) #인증이 되었으면
		{
			if($_POST['quies_mode'] == 1 && sizeof($SWAP_MEMBER) > 0)
			{
				happy_member_quies_move('decrypt',$SWAP_MEMBER);	//휴면해제
				$_SESSION['user_id_quies']	= "";
			}
			#창을 끄고 자바스크립트로 모창에 값도 넣고 핸드폰번호 못고치게도 하자.
			echo "
					<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
					<tr>
						<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
							<strong>> 휴대폰인증성공</strong>
						</td>
					</tr>
					<tr>
						<td style='text-align:center;'>
							<div style='color:#333333; font-size:20px;'><strong>$per_cell</strong><div>
							<div style='color:#333333; font-size:12px; margin-top:10px; line-height:20px;'>
								인증이 성공하였습니다.
							</div>
						</td>
					</tr>
					<tr>
						<td style='height:40px;'>
							<input type='submit' onclick='self.close()' value='핸드폰인증확인' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
						</td>
					</tr>
					</table>

			";
		}
		else {
			msgclose('인증번호가 일치하지 않습니다.');
			exit;
		}

	}

?>

</body>
</html>