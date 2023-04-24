<?
	include "./inc/config.php";
	include "./inc/function.php";

	foreach($_COOKIE as $key => $n_val) { $_COOKIE[$key] = preg_replace('~[^0-9a-zA-Z+/=_]~',"",$_COOKIE[$key]); ${$key} = $_COOKIE[$key]; }
	foreach($_REQUEST as $key => $n_val) { $_REQUEST[$key] = preg_replace('~[^0-9a-zA-Z+/=_]~',"",$_REQUEST[$key]); ${$key} = $_REQUEST[$key]; }
	foreach($_GET as $key => $n_val) { $_GET[$key] = preg_replace('~[^0-9a-zA-Z+/=_]~',"",$_GET[$key]); ${$key} = $_GET[$key]; }
	foreach($_POST as $key => $n_val) { $_POST[$key] = preg_replace('~[^0-9a-zA-Z+/=_]~',"",$_POST[$key]); ${$key} = $_POST[$key]; }

	function print_r2($var)
	{
		ob_start();
		print_r($var);
		$str = ob_get_contents();
		ob_end_clean();
		$str = preg_replace("/ /", "&nbsp;", $str);
		echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
	}



	if($_GET['select'] == 'ipin' || $_GET['type'] == 'step2_ipin')
	{
		$HAPPY_CONFIG['kcb_check_type'] = "ipin";
	}
	else if($_GET['select'] == 'hp' || $_GET['type'] == 'step2_hp')
	{
		$HAPPY_CONFIG['kcb_check_type'] = "hp";

		if($ipin_test == '1' || $demo_lock == '1')
		{
			msgclose("테스트 모드에서는 휴대폰인증을 지원하지 않습니다.\\n\\n아이핀인증을 이용해주세요 ^^");
			exit;
		}
	}

	if( $HAPPY_CONFIG['kcb_check_type'] == "ipin" )
	{
		if( $_GET['mode'] == 'lostid' )
		{
			$FILLER01				= "lostid";
			$NAME_CHECK_IPIN['returnUrl']	= "https://".$_SERVER["HTTP_HOST"]."/${wys_url}kcb_ipin_search.php?type=step2_ipin";
		}
		else if( $_GET['mode'] == 'lostpass' )
		{
			$FILLER01				= "lostpass";
			$NAME_CHECK_IPIN['returnUrl']	= "https://${_SERVER[HTTP_HOST]}${wys_url}/kcb_ipin_search.php?type=step2_ipin";
		}

		if($_GET['type'] == '')
		{
			$cmd = "$NAME_CHECK_IPIN[exe] $NAME_CHECK_IPIN[keypath] $NAME_CHECK_IPIN[kcb_mid] \"{$NAME_CHECK_IPIN[reserved1]}\" \"{$NAME_CHECK_IPIN[reserved2]}\" $NAME_CHECK_IPIN[EndPointURL] $NAME_CHECK_IPIN[logpath] $NAME_CHECK_IPIN[kcb_option]";

			if($system_function_ok		== "1")
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
				function certKCBIpin(){
					<?=$NAME_CHECK_IPIN['KCB_Script_action'];?>;
					document.kcbInForm.submit();
					return;
				}
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
			  <input type="hidden" name="FILLER01" value="<?=$FILLER01?>" />
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
			//exec , system 함수의 보안 때문에 패치함.		hun
			foreach($_REQUEST as $key)
			{
				$_REQUEST[$key]	= str_replace(" ","",$_REQUEST[$key]);
				${$key}			= $_REQUEST[$key];
			}
			//exec , system 함수의 보안 때문에 패치함.		hun


			//아이핀팝업에서 조회한 PERSONALINFO이다.
			@$encPsnlInfo = $_REQUEST["encPsnlInfo"];

			//KCB서버 공개키
			@$WEBPUBKEY = trim($_REQUEST["WEBPUBKEY"]);
			//KCB서버 서명값
			@$WEBSIGNATURE = trim($_REQUEST["WEBSIGNATURE"]);

			//유효성 코드 체크기능 추가.
			if(preg_match('~[^0-9a-zA-Z+/=]~', $encPsnlInfo, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}
			if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBPUBKEY, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}
			if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBSIGNATURE, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}

			$cpubkey = $WEBPUBKEY;       //server publickey
			$csig = $WEBSIGNATURE;    //server signature
			$encdata = $encPsnlInfo;     //PERSONALINFO


			$NAME_CHECK_IPIN['kcb_option']		= "S";

			$cmd = "$NAME_CHECK_IPIN[exe] $NAME_CHECK_IPIN[keypath] $NAME_CHECK_IPIN[kcb_mid] $NAME_CHECK_IPIN[EndPointURL] $cpubkey $csig $encdata $NAME_CHECK_IPIN[logpath] $NAME_CHECK_IPIN[kcb_option]";



			if($system_function_ok		== "1")
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

			if($field[1] != '')
			{
				if( $adult_check == '1' )
				{
					if( $field[8] < 7 )
					{
						msg("성인만 가입가능 합니다.");
						exit;
					}
				}

				if( $_REQUEST['FILLER01'] == 'lostid' )
				{
					echo "
						<script>
						opener.document.lost_id_form.coinfo1.value='${field[1]}';
						opener.document.lost_id_form.namecheck_type.value='ipin';
						opener.document.lost_id_form.submit();
						self.close();
						</script>
						";
				}
				else if( $_REQUEST['FILLER01'] == 'lostpass' )
				{
					echo "
						<script>
						opener.document.lost_pass_form.coinfo1.value='${field[1]}';
						opener.document.getElementById('lost_pass_div').style.display='';
						opener.document.lost_pass_form.namecheck_type.value='ipin';
						self.close();
						</script>
						";
				}


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
				echo "
				<script>
					alert('데모에서 휴대폰인증을 통한 회원찾기는 사용불가능 합니다.');
					self.close();
				</script>
				";
				exit;
			}

			if( $_GET['mode'] == 'lostid' )
			{
				$hsCertRqstCausCd	= "99";							// 99:기타 이지만  회원아이디 찾기로 사용하자.)
			}
			else if( $_GET['mode'] == 'lostpass' )
			{
				$hsCertRqstCausCd	= "03";							// 03:비밀번호찾기)
			}


			$NAME_CHECK_HP['returnUrl']			= "https://".$_SERVER["HTTP_HOST"]."/${wys_url}kcb_ipin_search.php?type=step2_hp";

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


			$returnMsg				= "x";									// 리턴메시지 (고정값 'x')
			$NAME_CHECK_HP['option']= "Q";

			$cmd = "$NAME_CHECK_HP[exe] $svcTxSeqno \"$name\" $birthday $gender $ntvFrnrTpCd $mblTelCmmCd $mbphnNo $rsv1 $rsv2 $rsv3 \"$returnMsg\" $NAME_CHECK_HP[returnUrl] $inTpBit $hsCertMsrCd $hsCertRqstCausCd $NAME_CHECK_HP[kcb_mid] $NAME_CHECK_HP[clientIp] $NAME_CHECK_HP[clientDomain] $NAME_CHECK_HP[EndPointURL] $NAME_CHECK_HP[logpath] $NAME_CHECK_HP[option]";

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
			<input type="hidden" name="rqst_data"				value="<?=$e_rqstData?>">		<!-- 요청데이터 -->
			<input type="hidden" name="target_id"				value="<?=$targetId?>">				<!-- 타겟ID -->
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
			$NAME_CHECK_HP[keypath]	= $NAME_CHECK_HP[keypath]."safecert_$idcfMbrComCd.key";
			$cpubkey				= $WEBPUBKEY;       //server publickey
			$csig					= $WEBSIGNATURE;    //server signature
			$NAME_CHECK_HP['option']= "S";

			//유효성 코드 체크기능 추가.		휴대폰전용
			if(preg_match('~[^0-9a-zA-Z+/=]~', $encInfo, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}
			if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBPUBKEY, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}
			if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBSIGNATURE, $match)) {echo "유효성 체크에 문제가 있습니다.<br>관리자에게 문의 해 주십시요."; exit;}


			$NAME_CHECK_HP['returnUrl']			= "https://".$_SERVER["HTTP_HOST"]."/${wys_url}kcb_ipin_search.php?type=step2_hp";


			// 명령어
			$cmd = "$NAME_CHECK_HP[exe] $NAME_CHECK_HP[keypath] $idcfMbrComCd $NAME_CHECK_HP[EndPointURL] $WEBPUBKEY $WEBSIGNATURE $encInfo $NAME_CHECK_HP[logpath] $NAME_CHECK_HP[option]";

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

			if($field[0] == 'B000')			//본인인증 성공
			{
				if( $hsCertRqstCausCd == '99' )				//ID 찾기
				{
					echo "
						<script>
						opener.document.lost_id_form.cl.value='${field[5]}';
						opener.document.lost_id_form.namecheck_type.value='hp';
						opener.document.lost_id_form.submit();
						self.close();
						</script>
						";
				}
				else if( $hsCertRqstCausCd == '03' )		//PASS 찾기
				{
					$Sql	= "select * from $happy_member where cl = '$field[5]'";
					$Result	= query($Sql);
					$Tmp	= happy_mysql_fetch_array($Result);

					if($Tmp[user_id] != '')
					{
						echo "
						<script>
						opener.document.lost_pass_form.cl.value='${field[5]}';
						opener.document.lost_pass_form.namecheck_type.value='hp';
						opener.document.getElementById('lost_pass_div').style.display='';
						self.close();
						</script>
						";
					}
					else
					{
						echo "
						<script>
						alert('존재하지 않는 회원입니다.');
						self.close();
						</script>
						";
					}

				}
				exit;
			}
			else							//본인인증 실패
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
		}
	}
?>