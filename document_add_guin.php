<?
	//기업회원이 개인회원에서 온라인입사지원 요청
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$number	= ($_GET["number"]!="")?$_GET["number"]:$_POST["number"];
	$mode	= $_POST["mode"];

	if ( $user_id == "" )
	{
		echo "
		<script>
		if ( opener )
		{
			opener.location.href = 'happy_member_login.php?returnUrl=".urlencode($_SERVER['REQUEST_URI'])."';
		}
		</script>
		";

		msgclose("로그인 후 이용하세요");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[4]."요청") || $number == "" )
	{
		error($happy_member_secure_text[4]."요청"."권한이 없습니다.");
		exit;
	}


	if ( $mode == "" )
	{
		$Sql	= "SELECT number,guin_title FROM $guin_tb WHERE guin_id='$user_id' AND ( guin_end_date >= curdate() OR guin_choongwon='1' ) ";
		$Record	= query($Sql);

		$array			= Array();
		$array_number	= Array();

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			array_push($array,kstrcut($Data["guin_title"], 50, "..."));
			array_push($array_number,$Data["number"]);
		}

		$구인선택	= make_selectbox3($array,$array_number,"채용공고를 선택해주세요.","guin_number","");


		$file		= "document_add_guin.html";


		$TPL->define("상세", "./$skin_folder/$file");
		$TPL->assign("상세");
		echo $TPL->fetch();

	}
	else
	{
		$Sql	= "SELECT user_id FROM $per_document_tb WHERE number='$number' ";
		$Data	= happy_mysql_fetch_array(query($Sql));

		if ( $Data["user_id"] == "" )
		{
			error("이력서를 작성한 사람이 탈퇴를 했거나 관리자가 작성한 이력서입니다. 메일 전송이 불가능합니다.");
			exit;
		}

		$guin_number	= $_POST["guin_number"];

		if ( $guin_number == "" )
		{
			error("입사지원요청하실 채용정보를 선택해주세요.");
			exit;
		}

		$Sql	= "SELECT COUNT(*) FROM $com_want_doc_tb WHERE com_id='$user_id' AND per_id='$Data[user_id]' AND doc_number='$number' AND guin_number='$guin_number' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp[0] == 0 )
		{
			$Sql	= "
						INSERT INTO
								$com_want_doc_tb
						SET
								com_id		= '$user_id',
								per_id		= '$Data[user_id]',
								doc_number	= '$number',
								guin_number	= '$guin_number',
								read_ok		= 'N',
								alert_ok	= 'N'
					";

			query($Sql);

			// SMS N 쪽지 보내기 :: 개인회원
			if( $Data["user_id"] != '' )
			{
				$Member			= happy_member_information($Data["user_id"]);

				if ( $HAPPY_CONFIG['msg_job_app_indi_use'] == "1" )
				{
					$HAPPY_CONFIG['msg_job_app_indi']		= str_replace("{{아이디}}",$Member['user_id'],$HAPPY_CONFIG['msg_job_app_indi']);
					$HAPPY_CONFIG['msg_job_app_indi']		= str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['msg_job_app_indi']);

					$HAPPY_CONFIG['msg_job_app_indi']		= addslashes($HAPPY_CONFIG['msg_job_app_indi']);

					$sql = "INSERT INTO ";
					$sql.= $message_tb." ";
					$sql.= "SET ";
					$sql.= "sender_id = '".$Member['user_id']."', ";
					$sql.= "sender_name = '".$Member['user_name']."', ";
					$sql.= "sender_admin = 'n', ";
					$sql.= "receive_id = '".$admin_id."', ";
					$sql.= "receive_name = '관리자', ";
					$sql.= "receive_admin = 'y', ";
					$sql.= "message = '".$HAPPY_CONFIG['msg_job_app_indi']."', ";
					$sql.= "regdate = now() ";
					query($sql);
				}

				if ( $HAPPY_CONFIG['sms_job_app_indi_use'] == "1" || $HAPPY_CONFIG['sms_job_app_indi_use'] == "kakao" )
				{
					$SMSMSG["sms_job_app_indi"] = sms_convert($HAPPY_CONFIG["sms_job_app_indi"],'','','','',$site_phone,'','','',$Member['user_id']);

					$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['sms_job_app_indi'],5,$sms_testing,'',$HAPPY_CONFIG['sms_job_app_indi_use'],$HAPPY_CONFIG['sms_job_app_indi_ktplcode']);
					send_sms_socket($dataStr);
				}
			}

			// SMS N 쪽지 보내기 :: 기업회원
			if( $happy_member_login_value != '' )
			{
				$Member			= happy_member_information($happy_member_login_value);
				$Member_per		= happy_member_information($Data["user_id"]);

				if ( $HAPPY_CONFIG['msg_job_app_corp_use'] == "1" )
				{
					$HAPPY_CONFIG['msg_job_app_corp']		= str_replace("{{아이디}}",$Member_per['user_id'],$HAPPY_CONFIG['msg_job_app_corp']);
					$HAPPY_CONFIG['msg_job_app_corp']		= str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['msg_job_app_corp']);

					$HAPPY_CONFIG['msg_job_app_corp']		= addslashes($HAPPY_CONFIG['msg_job_app_corp']);

					$sql = "INSERT INTO ";
					$sql.= $message_tb." ";
					$sql.= "SET ";
					$sql.= "sender_id = '".$Member['user_id']."', ";
					$sql.= "sender_name = '".$Member['user_name']."', ";
					$sql.= "sender_admin = 'n', ";
					$sql.= "receive_id = '".$admin_id."', ";
					$sql.= "receive_name = '관리자', ";
					$sql.= "receive_admin = 'y', ";
					$sql.= "message = '".$HAPPY_CONFIG['msg_job_app_corp']."', ";
					$sql.= "regdate = now() ";
					query($sql);
				}

				if ( $HAPPY_CONFIG['sms_job_app_corp_use'] == "1" || $HAPPY_CONFIG['sms_job_app_corp_use'] == "kakao" )
				{
					$SMSMSG["sms_job_app_corp"] = sms_convert($HAPPY_CONFIG["sms_job_app_corp"],'','','','',$site_phone,'','','',$Member_per['user_id']);

					$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['sms_job_app_corp'],5,$sms_testing,'',$HAPPY_CONFIG['sms_job_app_corp_use'],$HAPPY_CONFIG['sms_job_app_corp_ktplcode']);
					send_sms_socket($dataStr);
				}
			}

			$method	= explode("?", $_SERVER["REQUEST_URI"]);
			msgclose("요청이 성공적으로 되었습니다.");

		}
		else
		{
			msgclose("이미 입사지원요청을 하신 이력서입니다.");
			exit;
		}
	}
?>