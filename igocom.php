<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$num		= ( $_POST["num"] != "" )?$_POST["num"]:$_GET["num"];
	$mode		= $_POST["mode"];
	$trick_code	= rand(10000,99999);

	if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] ) {
		msgclose("로그인 후 이용하세요");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[6]) && $_COOKIE["ad_id"] == "")
	{
		msgclose($happy_member_secure_text[6]."권한이 없습니다.");
		exit;
	}


	if ( $num == "" )
	{
		msgclose("잘못된 경로로 접근하셨습니다.");
		exit;
	}


	if ( $mode == "okletsmoveout" )
	{
		global $_POST, $site_name, $master_name, $admin_email, $_SESSION, $links;
		global $사이트이름, $운영자이름, $회원이름, $회원아이디, $회원패스워드;
		global $happy_member;

		$name		= $_POST["mail_name"];
		$email		= $_POST["mail_email"];
		$phone		= $_POST["mail_phone"];

		$comment	= nl2br($_POST["mail_content"]);
		$mail_content	= $comment;
		$secure			= @implode(",", (array) $_POST["secure"]);

		$spamcheck	= $_POST["spamcheck"];
		$realspam	= $_SESSION["antispam"];

		$_GET["number"]	= $_POST["number"];
		$number			= $_POST["number"];

		if ( $number == "" )
		{
			error("접수하실 이력서를 선택해주세요.");
			exit;
		}
		else if ( $spamcheck != $realspam )
		{
			msgclose("이미지의 문자와 일치하지 않습니다.");
			exit;
		}
		else
		{


			// 이메일 입사지원 중복체크
			$sql				= "SELECT count(*) FROM $job_email_jiwon_log WHERE pNumber = '$number' AND cNumber = '$num' ";
			$result				= query($sql);
			list($alcnt)		= happy_mysql_fetch_array($result);
			if ( $alcnt >= 1 )
			{
				error("이미 이메일 입사지원을 한 채용정보입니다.");
				exit;
			}


			$추가내용	= $comment;
			#$바로가기	= $main_url."/html_file.php?file=login.html&file2=login_default.html&go_url=".urlencode($main_url ."/document_view.php?number=$number");
			$바로가기 = $main_url."/document_view.php?number=$number";


			#이력서정보
			$sql = "select * from $per_document_tb where number = '$number'";
			$result = query($sql);
			$PER = happy_mysql_fetch_assoc($result);

			#채용정보
			$Sql	= "SELECT guin_name, guin_email, guin_id, guin_com_name FROM $guin_tb WHERE number='$num' ";
			$Temp	= happy_mysql_fetch_array(query($Sql));


			/*
			// 중복체크를 위해서 이메일 입사지원한 로그만 남김 2022-05-03 kad
			// 이메일 내용에 이력서 바로가기 버튼을 제거함
			// 온라인 입사지원과 섞어 놓지 않음
				CREATE TABLE  `job_email_jiwon_log` (
				 `number` INT NOT NULL AUTO_INCREMENT ,
				 `pNumber` int(11) NOT NULL DEFAULT '0',
				 `cNumber` int(11) NOT NULL DEFAULT '0',
				 `com_id` varchar(150) NOT NULL DEFAULT '',
				 `per_id` varchar(150) NOT NULL DEFAULT '',
				 `secure` varchar(250) NOT NULL DEFAULT '',
				 `regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				 PRIMARY KEY (`number`),
				 KEY `pNumber` (`pNumber`),
				 KEY `com_id` (`com_id`),
				 KEY `per_id` (`per_id`),
				 KEY `cNumber` (`cNumber`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			*/

			//아래에 있던 코드를 위로 가져옴. 입사지원 고유번호 찾아서 메일에 넣어주기 위해서 2022-05-02 hun
			$Sql		= "SELECT number,user_name,user_id FROM $happy_member WHERE user_id='$user_id'";
			$Tmp		= happy_mysql_fetch_array(query($Sql));
			$per_name	= $Tmp["per_name"];

			$Sql	= "
					INSERT INTO
							$job_email_jiwon_log
					SET
							pNumber		= '$number',
							cNumber		= '$num',
							com_id		= '$Temp[guin_id]',
							per_id		= '$user_id',
							secure		= '$secure',

							regdate		= now()
			";
			//echo $Sql;exit;
			query($Sql);
			//아래에 있던 코드를 위로 가져옴. 입사지원 고유번호 찾아서 메일에 넣어주기 위해서 2022-05-02 hun

			$Reciveemail	 = $Temp["guin_email"];
			$Recivename		= $Temp["user_name"];

			//$Reciveemail	  = "kadrien@happycgi.com";

			##################################################################################################################

			$mainTemplate	= "doc_igo_main.html";
			$workTemplate	= "doc_igo_work.html";
			$skillTemplate	= "doc_igo_skill.html";
			$langTemplate	= "doc_igo_lang.html";
			$yunsooTemplate	= "doc_igo_yunsoo.html";
			$schoolTemplate	= "doc_view_school.html";

			// 로고이미지 src
			$main_logo_src		= $main_url.str_replace("//","/",("/".$wys_url."/upload/happy_config/main_logo.png"));

			$comment		= document_view( $mainTemplate, $workTemplate, $skillTemplate, $langTemplate, $yunsooTemplate );

			######################################################################################################################

			//이미지 절대경로
			$comment = str_replace("upload/happy_config/",$main_url."/upload/happy_config/",$comment);
			$comment = str_replace($main_url."/".$main_url."/upload/happy_config/",$main_url."/upload/happy_config/",$comment);


			#$Reciveemail	= "twoblade16@naver.com,twoblade16@yahoo.co.kr";

			$title		= "${name}님으로부터 이메일입사지원이 접수되었습니다.";

			//메일 함수 통합 - hong
			//$email			= "kadrien@happycgi.com";
			//$Reciveemail	= "cgi_kad@nate.com,kadrien@happycgi.com,upapa2@naver.com";
			HappyMail($name, $email,$Reciveemail,$title,$comment);
			//echo $comment;exit;			// kad 작업하려고 임시

			//여기에 있던 $com_guin_per_tb 에 입사지원 insert 코드를 상단으로 옮김		2022-05-02 hun


			// SMS N 쪽지 보내기 :: 개인회원
			if( $happy_member_login_value != '' )
			{
				$Member			= happy_member_information($happy_member_login_value);

				if ( $HAPPY_CONFIG['msg_email_in_indi_use'] == "1" )
				{
					$HAPPY_CONFIG['msg_email_in_indi']		= str_replace("{{아이디}}",$Member['user_id'],$HAPPY_CONFIG['msg_email_in_indi']);
					$HAPPY_CONFIG['msg_email_in_indi']		= str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['msg_email_in_indi']);

					$HAPPY_CONFIG['msg_email_in_indi']		= addslashes($HAPPY_CONFIG['msg_email_in_indi']);

					$sql = "INSERT INTO ";
					$sql.= $message_tb." ";
					$sql.= "SET ";
					$sql.= "sender_id = '".$Member['user_id']."', ";
					$sql.= "sender_name = '".$Member['user_name']."', ";
					$sql.= "sender_admin = 'n', ";
					$sql.= "receive_id = '".$admin_id."', ";
					$sql.= "receive_name = '관리자', ";
					$sql.= "receive_admin = 'y', ";
					$sql.= "message = '".$HAPPY_CONFIG['msg_email_in_indi']."', ";
					$sql.= "regdate = now() ";
					query($sql);
				}

				if ( $HAPPY_CONFIG['sms_email_in_indi_use'] == "1" || $HAPPY_CONFIG['sms_email_in_indi_use'] == "kakao" )
				{
					$SMSMSG["sms_email_in_indi"] = sms_convert($HAPPY_CONFIG["sms_email_in_indi"],'','','','',$site_phone,'','','',$Member['user_id']);

					$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['sms_email_in_indi'],5,$sms_testing,'',$HAPPY_CONFIG['sms_email_in_indi_use'],$HAPPY_CONFIG['sms_email_in_indi_ktplcode']);
					send_sms_socket($dataStr);
				}
			}

			// SMS N 쪽지 보내기 :: 기업회원
			if( $Temp['guin_id'] != '' )
			{
				$Member			= happy_member_information($Temp['guin_id']);
				$Member_per		= happy_member_information($happy_member_login_value);

				if ( $HAPPY_CONFIG['msg_email_in_corp_use'] == "1" )
				{
					$HAPPY_CONFIG['msg_email_in_corp']		= str_replace("{{아이디}}",$Member_per['user_id'],$HAPPY_CONFIG['msg_email_in_corp']);
					$HAPPY_CONFIG['msg_email_in_corp']		= str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['msg_email_in_corp']);

					$HAPPY_CONFIG['msg_email_in_corp']		= addslashes($HAPPY_CONFIG['msg_email_in_corp']);

					$sql = "INSERT INTO ";
					$sql.= $message_tb." ";
					$sql.= "SET ";
					$sql.= "sender_id = '".$Member['user_id']."', ";
					$sql.= "sender_name = '".$Member['user_name']."', ";
					$sql.= "sender_admin = 'n', ";
					$sql.= "receive_id = '".$admin_id."', ";
					$sql.= "receive_name = '관리자', ";
					$sql.= "receive_admin = 'y', ";
					$sql.= "message = '".$HAPPY_CONFIG['msg_email_in_corp']."', ";
					$sql.= "regdate = now() ";
					query($sql);
				}

				if ( $HAPPY_CONFIG['sms_email_in_corp_use'] == "1" || $HAPPY_CONFIG['sms_email_in_corp_use'] == "kakao" )
				{
					$SMSMSG["sms_email_in_corp"] = sms_convert($HAPPY_CONFIG["sms_email_in_corp"],'','','','',$site_phone,'','','',$Member_per['user_id']);

					$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['sms_email_in_corp'],5,$sms_testing,'',$HAPPY_CONFIG['sms_email_in_corp_use'],$HAPPY_CONFIG['sms_online_in_corp_ktplcode']);
					send_sms_socket($dataStr);
				}
			}

			msgclose("성공적으로 메일이 발송되었습니다.");
			exit;
		}
	}

	$Sql	= "SELECT user_name as per_name, user_hphone as per_cell,user_email as per_email FROM $happy_member WHERE user_id='$user_id'";
	$USER	= happy_mysql_fetch_array(query($Sql));

	$Sql	= "SELECT number,title FROM $per_document_tb WHERE user_id='$user_id' AND display = 'Y' ";
	$Record	= query($Sql);

	$array			= Array();
	$array_number	= Array();

	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		array_push($array,kstrcut($Data["title"], 55, "..."));
		array_push($array_number,$Data["number"]);
	}

	$구인선택	= make_selectbox2($array,$array_number,"이력서를 선택해주세요.","number","",380);

	//무료화로 운영중일경우에는 개인정보 공개 / 비공개 체크박스 안보이도록 패치
	$display_secure = '';
	if ( $CONF['guin_docview'] == "" && $CONF['guin_docview2'] == ""  )
	{
		$display_secure = " style='display:none;' ";
	}
	//무료화로 운영중일경우에는 개인정보 공개 / 비공개 체크박스 안보이도록 패치


	$file		= "igocom.html";
	$fullTemp	= "login_default.html";


	$TPL->define("상세", "./$skin_folder/$file");
	$TPL->assign("상세");
	echo $TPL->fetch();


?>