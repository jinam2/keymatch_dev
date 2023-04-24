<?
	include "./inc/config.php";
	include "./inc/function.php";

	foreach($_COOKIE as $key => $n_val) { $_COOKIE[$key] = preg_replace('~[^0-9a-zA-Z+/=_]~',"",$_COOKIE[$key]); ${$key} = $_COOKIE[$key]; }
	foreach($_REQUEST as $key => $n_val) { $_REQUEST[$key] = preg_replace('~[^0-9a-zA-Z+/=_]~',"",$_REQUEST[$key]); ${$key} = $_REQUEST[$key]; }
	foreach($_GET as $key => $n_val) { $_GET[$key] = preg_replace('~[^0-9a-zA-Z+/=_]~',"",$_GET[$key]); ${$key} = $_GET[$key]; }
	foreach($_POST as $key => $n_val) { $_POST[$key] = preg_replace('~[^0-9a-zA-Z+/=_]~',"",$_POST[$key]); ${$key} = $_POST[$key]; }

	if($_GET['select'] == 'ipin' || $_GET['type'] == 'step2_ipin')
	{
		$HAPPY_CONFIG['kcb_check_type'] = "ipin";
	}
	else if($_GET['select'] == 'hp' || $_GET['type'] == 'step2_hp')
	{
		$HAPPY_CONFIG['kcb_check_type'] = "hp";
		if($ipin_test == '1')
		{
			msgclose("휴대폰인증은 KCB 의 실제결제 코드가 필요합니다.\\n\\n아이핀인증을 이용해주세요 ^^");
			exit;
		}
	}

	if( $HAPPY_CONFIG['kcb_check_type'] == "ipin" )
	{
		//$returnUrl				= "https://".$_SERVER["HTTP_HOST"]."/${wys_url}html_file_kcb_ipin.php?type=step2";

		$NAME_CHECK_IPIN['returnUrl']	= "https://".$_SERVER["HTTP_HOST"]."/${wys_url}html_file_kcb_ipin.php?type=step2_ipin";

		if($_GET['type'] == '')
		{
			$cmd = "$NAME_CHECK_IPIN[exe] $NAME_CHECK_IPIN[keypath] $NAME_CHECK_IPIN[kcb_mid] \"{$NAME_CHECK_IPIN[reserved1]}\" \"{$NAME_CHECK_IPIN[reserved2]}\" $NAME_CHECK_IPIN[EndPointURL] $NAME_CHECK_IPIN[logpath] $NAME_CHECK_IPIN[kcb_option]";

			//print_r2($NAME_CHECK_IPIN); exit;

			if($system_function_ok == "1")
			{
				ob_start();
				system($cmd);
				$output = ob_get_contents();
				ob_end_clean();

				$out = explode("\n",$output);
			}
			else
			{
				//Happy Server 는 exec 보안 때문에 사용불가능..
				exec($cmd, $out, $ret);
			}

			$pubkey=$out[0];
			$sig=$out[1];
			$curtime=$out[2];
?>
			<html>
			  <head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
				<script language="JavaScript">
				//<!--
				function certKCBIpin(){
					<?=$NAME_CHECK_IPIN['KCB_Script_action'];?>;
					document.kcbInForm.submit();
					//popupWindow.focus();
					return;
				}
				//-->
				</script>

			  </head>
			<body>
			<form name="kcbInForm" method="post" >
			  <input type="hidden" name="IDPCODE" value="<?=$NAME_CHECK_IPIN['idpCode']?>" />
			  <input type="hidden" name="IDPURL" value="<?=$NAME_CHECK_IPIN['idpUrl']?>" />
			  <input type="hidden" name="CPCODE" value="<?=$NAME_CHECK_IPIN['kcb_mid']?>" />
			  <input type="hidden" name="CPREQUESTNUM" value="<?=$curtime?>" />
			  <input type="hidden" name="RETURNURL" value="<?=$NAME_CHECK_IPIN['returnUrl']?>" />
			  <input type="hidden" name="WEBPUBKEY" value="<?=$pubkey?>" />
			  <input type="hidden" name="WEBSIGNATURE" value="<?=$sig?>" />
			</form>
			<form name="kcbOutForm" method="post">
			  <input type="hidden" name="encPsnlInfo" />
			  <input type="hidden" name="virtualno" />
			  <input type="hidden" name="dupinfo" />
			  <input type="hidden" name="realname" />
			  <input type="hidden" name="cprequestnumber" />
			  <input type="hidden" name="age" />
			  <input type="hidden" name="sex" />
			  <input type="hidden" name="nationalinfo" />
			  <input type="hidden" name="birthdate" />
			  <input type="hidden" name="coinfo1" />
			  <input type="hidden" name="coinfo2" />
			  <input type="hidden" name="ciupdate" />
			  <input type="hidden" name="cpcode" />
			  <input type="hidden" name="authinfo" />
			</form>

			<script type="text/javascript">
			<!--
				certKCBIpin();
			//-->
			</script>
			</body>
			</html>

<?

		}
		else if( $_GET['type'] == 'step2_ipin' )
		{
			@$encPsnlInfo = $_REQUEST["encPsnlInfo"];
			@$WEBPUBKEY = trim($_REQUEST["WEBPUBKEY"]);
			@$WEBSIGNATURE = trim($_REQUEST["WEBSIGNATURE"]);

			$cpubkey = $WEBPUBKEY;       //server publickey
			$csig = $WEBSIGNATURE;    //server signature
			$encdata = $encPsnlInfo;     //PERSONALINFO
			//$kcb_option = "S";

			$NAME_CHECK_IPIN['kcb_option']		= "S";

			$cmd = "$NAME_CHECK_IPIN[exe] $NAME_CHECK_IPIN[keypath] $NAME_CHECK_IPIN[kcb_mid] $NAME_CHECK_IPIN[EndPointURL] $cpubkey $csig $encdata $NAME_CHECK_IPIN[logpath] $NAME_CHECK_IPIN[kcb_option]";

			if($system_function_ok == "1")
			{
				ob_start();
				system($cmd);
				$output = ob_get_contents();
				ob_end_clean();

				$out = explode("\n",$output);
			}
			else
			{
				//Happy Server 는 exec 보안 때문에 사용불가능..
				exec($cmd, $out, $ret);
			}


			foreach($out as $a => $b) {
				if($a < 13) {
					$field[$a] = $b;
				}
			}

			/*
			$field[0]		= "아이핀제조사 + 회원주민번호 를 복호화 한것";
			$field[1]		= "회원주민번호 를 복호화 한것";
			$field[6]		= "회원이름";
			$field[7]		= "실명인증한 시간";
			$field[8]		= "7 : 만 20세 이상			0 : 9세 미만		1 : 만 12세 미만		2 : 만 14세 미만 ....나머지는 메뉴얼 참고.";
			$field[9]		= "성별을 표시 1 = 남자 , 2 = 여자";
			$field[11]		= "생년월일";
			*/

			if($field[1] != '')
			{
				if( $HAPPY_CONFIG['kcb_adultcheck_use'] == '1' )
				{
					if( $field[8] !=  7 )
					{
						msgclose("성인만 가입가능 합니다.");
						exit;
					}
				}

				$ju1 = substr($field[11],2,6);

				setcookie("job_adultcheck",$ju1,0,"/",$cookie_url);
				setcookie("adult_check","OK",0,"/",$cookie_url);

				if($ipin_test == 1)
				{
					msg("아이핀연동 테스트 = 테스트서버로 부터 받은 값이 정상입니다.");
				}


				if ($_REQUEST["go_url"] != "")
				{
					$go_url = urldecode($_REQUEST["go_url"]);
					//go($go_url);
					echo "<script>opener.location.replace('$_REQUEST[go_url]'); self.close();</script>";
				}
				else
				{
					echo "<script>opener.location.replace('index.php'); self.close();</script>";
				}
				exit;
			}
			else
			{
				msgclose("아이핀 연동에 문제가 있습니다.");
				exit;
			}
		}
	}
	else if( $HAPPY_CONFIG['kcb_check_type'] == "hp" )
	{
		if( $_GET['type'] == "" )
		{
			if($demo_lock != '')
			{
				$ju1		= "741021";
				setcookie("job_adultcheck",$ju1,0,"/",$cookie_url);
				setcookie("adult_check","OK",0,"/",$cookie_url);

				echo "<script>alert('데모에서는 휴대폰인증이 그냥 통과 됩니다. ^^');opener.location.replace('index.php'); self.close();</script>";
				exit;
			}

			$NAME_CHECK_HP['returnUrl']			= "https://".$_SERVER["HTTP_HOST"]."/${wys_url}html_file_kcb_ipin.php?type=step2_hp";

			/*		설정 변경 금지		*/
			$inTpBit				= "0";								// 입력구분코드(고정값 '0' : KCB팝업에서 개인정보 입력)
			$name					= "x";								// 성명 (고정값 'x')
			$birthday				= "x";								// 생년월일 (고정값 'x')
			$gender					= "x";								// 성별 (고정값 'x')
			$ntvFrnrTpCd			="x";								// 내외국인구분 (고정값 'x')
			$mblTelCmmCd			="x";								// 이동통신사코드 (고정값 'x')
			$mbphnNo				="x";								// 휴대폰번호 (고정값 'x')

			$rand					= rand(123,999);
			$svcTxSeqno				= date("YmdHis").$rand;				// 거래번호. 동일문자열을 두번 사용할 수 없음. ( 20자리의 문자열. 0-9,A-Z,a-z 사용.)
			/*		설정 변경 금지		*/

			$rsv1					= "0";								// 예약 항목
			$rsv2					= "0";								// 예약 항목
			$rsv3					= "0";								// 예약 항목
			$hsCertMsrCd			= "10";								// 인증수단코드 2byte  (10:핸드폰)
			$hsCertRqstCausCd		= "01";								// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)

			$returnMsg				= "x";									// 리턴메시지 (고정값 'x')
			$NAME_CHECK_HP['option']= "Q";

			$cmd = "$NAME_CHECK_HP[exe] $svcTxSeqno \"$name\" $birthday $gender $ntvFrnrTpCd $mblTelCmmCd $mbphnNo $rsv1 $rsv2 $rsv3 \"$returnMsg\" $NAME_CHECK_HP[returnUrl] $inTpBit $hsCertMsrCd $hsCertRqstCausCd $NAME_CHECK_HP[kcb_mid] $NAME_CHECK_HP[clientIp] $NAME_CHECK_HP[clientDomain] $NAME_CHECK_HP[EndPointURL] $NAME_CHECK_HP[logpath] $NAME_CHECK_HP[option]";

			//echo $cmd; exit;

			//cmd 실행
			if($system_function_ok == "1")
			{
				ob_start();
				system($cmd);
				$output = ob_get_contents();
				ob_end_clean();

				$out = explode("\n",$output);
			}
			else
			{
				//Happy Server 는 exec 보안 때문에 사용불가능..
				exec($cmd, $out, $ret);
			}


			/**************************************************************************
			okname 응답 정보
			**************************************************************************/
			$retcode = "";										// 결과코드
			$retmsg = "";										// 결과메시지
			$e_rqstData = "";									// 암호화된요청데이터

			if ($ret == 0) {//성공일 경우 변수를 결과에서 얻음
				$retcode = $out[0];
				$retmsg  = $out[1];
				$e_rqstData = $out[2];
			}
			else {
				$retcode = $out[0];
				$retmsg  = $out[1];
			}

			$targetId = "";				// 타겟ID (팝업오픈 스크립트의 window.name 과 동일하게 설정
	?>
			<html>
			<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>KCB 생년월일 본인 확인서비스 샘플</title>
			<script>
				function request(){
				window.name = "<?=$targetId?>";

				document.form1.action = "<?=$NAME_CHECK_HP[commonSvlUrl]?>";
				document.form1.method = "post";

				document.form1.submit();
			}
			</script>
			</head>

		 <body>
			<form name="form1">
			<!-- 인증 요청 정보 -->
			<!--// 필수 항목 -->
			<input type="hidden" name="tc" value="kcb.oknm.online.safehscert.popup.cmd.P901_CertChoiceCmd">				<!-- 변경불가-->
			<input type="hidden" name="rqst_data" value="<?=$e_rqstData?>">		<!-- 요청데이터 -->
			<input type="hidden" name="target_id" value="<?=$targetId?>">				<!-- 타겟ID -->
			<!-- 필수 항목 //-->
			</form>
	<?
			if ($retcode == "B000") {
				//인증요청
				echo ("<script>request();</script>");
			} else {
				//요청 실패 페이지로 리턴
				echo ("<script>alert(\"$retcode\"); self.close();</script>");
			}
	?>
		 </body>
		</html>
<?
		}
		elseif( $_GET['type'] == "step2_hp" )
		{
			/* 공통 리턴 항목 */
			$idcfMbrComCd			=	$_REQUEST["idcf_mbr_com_cd"];		// 고객사코드
			$hsCertSvcTxSeqno		=	$_REQUEST["hs_cert_svc_tx_seqno"];	// 거래번호
			$rqstSiteNm				=	$_REQUEST["rqst_site_nm"];			// 접속도메인
			$hsCertRqstCausCd		=	$_REQUEST["hs_cert_rqst_caus_cd"];	// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)

			$resultCd				=	$_REQUEST["result_cd"];			// 결과코드
			$resultMsg				=	$_REQUEST["result_msg"];			// 결과메세지
			$certDtTm				=	$_REQUEST["cert_dt_tm"];			// 인증일시

			/**************************************************************************
			 * 모듈 호출	; 생년월일 본인 확인서비스 결과 데이터를 복호화한다.
			 **************************************************************************/
			$encInfo				= $_REQUEST["encInfo"];
			$WEBPUBKEY				= trim($_REQUEST["WEBPUBKEY"]);
			$WEBSIGNATURE			= trim($_REQUEST["WEBSIGNATURE"]);

			//유효성 코드 체크기능 추가.		휴대폰전용
			if(preg_match('~[^0-9a-zA-Z+/=]~', $encInfo, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}
			if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBPUBKEY, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}
			if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBSIGNATURE, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}

			$NAME_CHECK_HP[keypath]	= $NAME_CHECK_HP[keypath]."safecert_$idcfMbrComCd.key";
			$cpubkey				= $WEBPUBKEY;       //server publickey
			$csig					= $WEBSIGNATURE;    //server signature
			$NAME_CHECK_HP['option']= "S";

			// 명령어
			$cmd = "$NAME_CHECK_HP[exe] $NAME_CHECK_HP[keypath] $idcfMbrComCd $NAME_CHECK_HP[EndPointURL] $WEBPUBKEY $WEBSIGNATURE $encInfo $NAME_CHECK_HP[logpath] $NAME_CHECK_HP[option]";

			//$cmd = "$exe $keypath $idcfMbrComCd $EndPointURL $WEBPUBKEY $WEBSIGNATURE $encInfo $logpath $option";


			if($system_function_ok == "1")
			{
				ob_start();
				system($cmd);
				$output = ob_get_contents();
				ob_end_clean();

				$out = explode("\n",$output);
			}
			else
			{
				//Happy Server 는 exec 보안 때문에 사용불가능..
				exec($cmd, $out, $ret);
			}

			if($ret == 0)
			{
				foreach($out as $a => $b)
				{
					if($a < 17)
					{
						$field[$a] = $b;
					}
				}
			}
			else
			{
				msgclose("휴대폰인증에 문제가 있습니다.");
				exit;
			}

			if($field[0] == 'B000')
			{
				if( $HAPPY_CONFIG['kcb_adultcheck_use'] == '1' )
				{
					//만나이 계산하자 ㅜㅜ
					$target_year		= substr($field[8],0,4);
					$target_month		= substr($field[8],4,2);
					$target_day			= substr($field[8],6,2);

					$adult_year			= $now_year - 19;
					$limit_time			= happy_mktime(0,0,0,$now_month,$now_day,$adult_year);
					$target_titme		= happy_mktime(0,0,0,$target_month,$target_day,$target_year);

					//성인일 경우에만 접근가능.
					if( $target_titme <= $limit_time )
					{
						$ju1 = substr($field[8],2,6);
						setcookie("job_adultcheck",$ju1,0,"/",$cookie_url);
						setcookie("adult_check","OK",0,"/",$cookie_url);

						if ($_REQUEST["go_url"] != "")
						{
							$go_url = urldecode($_REQUEST["go_url"]);
							echo "<script>opener.location.replace('$_REQUEST[go_url]'); self.close();</script>";
						}
						else
						{
							echo "<script>opener.location.replace('index.php'); self.close();</script>";
						}
						exit;
					}
				}
				else
				{
					echo "<script>alert('성인인증이 꺼져있습니다.');opener.location.replace('index.php'); self.close();</script>";
				}
			}
			else
			{
				$message_alert = false;
				foreach($kcb_error_code as $key => $value)
				{
					if( $field[0] == $key )
					{
						$message_alert = true;
						msgclose("$value \\n[ 오류번호:$key ]");
						exit;
					}
				}

				if($message_alert == false)
				{
					msgclose("오류번호 :$field[0] \\nKCB 실명인증 업체에 문의 해주십시요.");
				}
				exit;
			}

/*
			echo "처리결과코드		:$field[0]	<br/>";
			echo "처리결과메시지	:$field[1]	<br/>";
			echo "거래일련번호		:$field[2]	<br/>";
			echo "인증일시			:$field[3]	<br/>";
			echo "DI				:$field[4]	<br/>";
			echo "CI				:$field[5]	<br/>";
			echo "성명				:$field[7]	<br/>";
			echo "생년월일			:$field[8]	<br/>";
			echo "성별				:$field[9]	<br/>";
			echo "내외국인구분		:$field[10]	<br/>";
			echo "통신사코드		:$field[11]	<br/>";
			echo "휴대폰번호		:$field[12]	<br/>";
			echo "리턴메시지		:$field[16]	<br/>";
*/
		}
	}
?>