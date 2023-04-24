<?
// samesite 정책
// 크롬80 samesite 정책에 의해서 쿠키를 전달 안해줌
// 크롬94 samesite 를 끄는 방법이 제거됨
// 브라우저가 전달하는 쿠키는 무시(휴대폰별, 브라우저별, 버전별로 전달여부가 달라서, 믿을수 없음)
$_COOKIE['happy_mobile'] = "";
function pg_is_mobile_ok()
{
	if(
		preg_match("/Windows CE; PPC/i",$_SERVER['HTTP_USER_AGENT'] ) ||
		preg_match("/iPhone/i",$_SERVER['HTTP_USER_AGENT']) ||
		preg_match("/lgtelecom/i",$_SERVER['HTTP_USER_AGENT']) ||	//LG
		preg_match("/IEMobile/i",$_SERVER['HTTP_USER_AGENT']) ||	//LG+삼성
		preg_match("/BlackBerry/i",$_SERVER['HTTP_USER_AGENT']) ||
		preg_match("/Android/i",$_SERVER['HTTP_USER_AGENT']) ||
		preg_match("/Nokia/i",$_SERVER['HTTP_USER_AGENT']) ||
		preg_match("/SAMSUNG-SGH/i",$_SERVER['HTTP_USER_AGENT']) ||
		preg_match("/SAMSUNG-SCH/i",$_SERVER['HTTP_USER_AGENT']) ||
		preg_match("/iPod/i",$_SERVER['HTTP_USER_AGENT']) ||
		preg_match("/iPad/i",$_SERVER['HTTP_USER_AGENT']) ||
		preg_match("/mobile/i",$_SERVER['HTTP_USER_AGENT'])
	)
		return true;
	else
		return false;
}
if ( $_COOKIE['happy_mobile'] == "" )
{
	if ( pg_is_mobile_ok() == true )
	{
		$_COOKIE['happy_mobile'] = "on";
	}
	else
	{
		$_COOKIE['happy_mobile'] = "off";
	}
}
//echo var_dump($_COOKIE['happy_mobile']);
// samesite 정책


ob_start();
include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/Template.php");
$TPL = new Template;
include ("../inc/lib.php");
include ("../inc/lib_pay.php");
ob_end_clean();


if(!$_GET && !$_POST)
{
	exit;
}





function write_log22($file, $noti) {
	$fp = fopen($file, "a+");
	ob_start();
	print_r($noti);
	$msg = ob_get_contents();
	ob_end_clean();
	fwrite($fp, $msg);
	fclose($fp);
}
$log_file = "../data/".$pg_company_info."_".date("Ym").".log";
#write_log22($log_file, $_REQUEST); //daoupay get


if(preg_match("/dacom|allthegate/",$pg_company_info))
{
	$pg_pay_mode_type	= $_POST['pay_type_option'];
}
else if($pg_company_info == "daoupay")
{
	$pg_pay_mode_type	= $_GET['RESERVEDINDEX1'];
}
else if($pg_company_info == "inicis")
{
	$pg_pay_mode_type	= $_REQUEST["merchantData"]; // 결제 타입 - happycgi - [contents,premium,point]

	if($_REQUEST[P_NOTI] != "")
	{
		$P_NOTI_EX			= Array();
		$P_NOTI				= $_REQUEST[P_NOTI];
		$p_noti_ex			= explode(",",$P_NOTI);
		foreach($p_noti_ex AS $p_key => $p_val)
		{
			$p_noti_ex2		= explode("=",$p_val);
			$P_NOTI_EX[$p_noti_ex2[0]]	= $p_noti_ex2[1];
		}
		unset($p_key,$p_val);
		$pg_pay_mode_type	= $P_NOTI_EX['pay_type_option']; //하단 location 때문
	}
}



$TABLE_NAME	= Array(
					"company"			=> "$jangboo",
					"company_package"	=> "$jangboo",
					"person"			=> "$jangboo2",
					"person_package"	=> "$jangboo2",
					"point"				=> "$point_jangboo"
			);

$FIELD_F	= Array(
					"company"			=> "goods_price",
					"company_package"	=> "goods_price",
					"person"			=> "goods_price",
					"person_package"	=> "goods_price",
					"point"				=> "point"
			);
$FIELD_W	= Array(
					"company"			=> "or_no",
					"company_package"	=> "or_no",
					"person"			=> "or_no",
					"person_package"	=> "or_no",
					"point"				=> "or_no"
			);

$FIELD_F_PTYPE		= Array(
							"company"			=> "or_method",
							"company_package"	=> "or_method",
							"person"			=> "or_method",
							"person_package"	=> "or_method",
							"point"				=> "pay_type"
					);

$FIELD_F_SUCCESS	= Array(
							"company"			=> "in_check",
							"company_package"	=> "in_check",
							"person"			=> "in_check",
							"person_package"	=> "in_check",
							"point"				=> "in_check"
					);



//결제금액체크(다우페이,이니시스)
function pg_jangboo_chk($pay_type,$oid)
{
	global $jangboo,$jangboo2,$point_jangboo;
	global $TABLE_NAME,$FIELD_F,$FIELD_W,$FIELD_F_PTYPE,$FIELD_F_SUCCESS;


	$PAY_DATA				= Array();
	$PAY_DATA['pay_type']	= $pay_type;

	$tn_val	= $TABLE_NAME[$pay_type];
	$fw_val	= $FIELD_W[$pay_type];
	$sql = "select * from $tn_val where $fw_val ='$oid' ";
	$result = query($sql);
	$JANGBOO = happy_mysql_fetch_array($result);

	if($pay_type == "point")
	{
		$tmpPrice			= explode("|",$JANGBOO[$FIELD_F[$pay_type]]);
		$PAY_DATA['total_price']		= $tmpPrice[1];
	}
	else
	{
		$PAY_DATA['total_price']		= $JANGBOO[$FIELD_F[$pay_type]];
	}

	$PAY_DATA['in_check']				= $JANGBOO[$FIELD_F_SUCCESS[$pay_type]];

	switch($JANGBOO[$FIELD_F_PTYPE[$pay_type]])
	{
		case "실시간계좌이체"	:		$PAY_DATA['pay_method']			= "bank";break;
	}

	return $PAY_DATA;
}


//결제건에 대한 업데이트
function pg_db_update()
{
	global $HAPPY_CONFIG,$oid,$or_no,$pg_pay_mode_type;




	switch($pg_pay_mode_type)
	{
		case "company":				company_pay_ok();break;
		case "company_package":		pay_ok_package();break;
		case "person":				pay_ok();break;
		case "person_package":		pay_ok_package();break;
		case "point":				pay_point_ok();break;
	}

}




//결제요청 응답건에 대한 업데이트
function pg_response_update()
{
	global $oid,$or_no,$pg_pay_mode_type;
	global $TABLE_NAME,$FIELD_F,$FIELD_W,$FIELD_F_PTYPE,$FIELD_F_SUCCESS;
	global $pg_response_code,$pg_response_msg;

	/*
	승인코드 정리

	[U+]
	- PC		: 0000
	- Mobile	: 0000

	[올더게이트]
	- PC		: y
	- Mobile	: ok

	[다우페이]
	- 정상처리 외 응답하지않음

	[이니시스]
	- PC		: 0000
	- Moblie	: 00
	*/


	$tn_val		= $TABLE_NAME[$pg_pay_mode_type];
	$fw_val		= $FIELD_W[$pg_pay_mode_type];
	$Sql		= "
					UPDATE
						$tn_val
					SET
						pg_response_code='$pg_response_code',
						pg_response_msg='$pg_response_msg'
					WHERE
						$fw_val ='$oid'
	";
	query($Sql);
}




if($_COOKIE['happy_mobile'] == "on")
{
	$dot_url	= "../";
}
else
{
	$dot_url	= "../../";
}


if($pg_company_info == "dacom")
{
	/*
	 * [최종결제요청 페이지(STEP2-2)]
	 *
	 * LG유플러스으로 부터 내려받은 LGD_PAYKEY(인증Key)를 가지고 최종 결제요청.(파라미터 전달시 POST를 사용하세요)
	 */

	/* ※ 중요
	* 환경설정 파일의 경우 반드시 외부에서 접근이 가능한 경로에 두시면 안됩니다.
	* 해당 환경파일이 외부에 노출이 되는 경우 해킹의 위험이 존재하므로 반드시 외부에서 접근이 불가능한 경로에 두시기 바랍니다.
	* 예) [Window 계열] C:\inetpub\wwwroot\lgdacom ==> 절대불가(웹 디렉토리)
	*/

	$configPath = "$pg_module_path/lgdacom"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf,/conf/mall.conf") 위치 지정.

	/*
	 *************************************************
	 * 1.최종결제 요청 - BEGIN
	 *  (단, 최종 금액체크를 원하시는 경우 금액체크 부분 주석을 제거 하시면 됩니다.)
	 *************************************************
	 */


	$CST_PLATFORM               = $_POST["CST_PLATFORM"];
	$CST_MID                    = $_POST["CST_MID"];
	$LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
	$LGD_PAYKEY                 = $_POST["LGD_PAYKEY"];

	/*  $CST_PLATFORM               = $HTTP_POST_VARS["CST_PLATFORM"];
	$CST_MID                    = $HTTP_POST_VARS["CST_MID"];
	$LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
	$LGD_PAYKEY                 = $HTTP_POST_VARS["LGD_PAYKEY"];*/

	/*
	echo "CST_PLATFORM = " . $CST_PLATFORM . "<br>";
	echo "CST_MID = " . $CST_MID . "<br>";
	echo "LGD_MID = " . $LGD_MID . "<br>";
	echo "LGD_PAYKEY = " . $LGD_PAYKEY . "<br>";
	*/
	require_once("$pg_module_path/lgdacom/XPayClient.php");
	$xpay = &new XPayClient($configPath, $CST_PLATFORM);
	$xpay->Init_TX($LGD_MID);

	$xpay->Set("LGD_TXNAME", "PaymentByKey");
	$xpay->Set("LGD_PAYKEY", $LGD_PAYKEY);

	//금액을 체크하시기 원하는 경우 아래 주석을 풀어서 이용하십시요.
	//$DB_AMOUNT = "DB나 세션에서 가져온 금액"; //반드시 위변조가 불가능한 곳(DB나 세션)에서 금액을 가져오십시요.
	//$xpay->Set("LGD_AMOUNTCHECKYN", "Y");
	//$xpay->Set("LGD_AMOUNT", $DB_AMOUNT);

	/*
	 *************************************************
	 * 1.최종결제 요청(수정하지 마세요) - END
	 *************************************************
	 */

	/*
	 * 2. 최종결제 요청 결과처리
	 *
	 * 최종 결제요청 결과 리턴 파라미터는 연동메뉴얼을 참고하시기 바랍니다.
	 */
	if ($xpay->TX()) {
		//1)결제결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)

		/*
		echo "결제요청이 완료되었습니다.  <br>";
		echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
		echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";

		echo "거래번호 : " . $xpay->Response("LGD_TID",0) . "<br>";
		echo "상점아이디 : " . $xpay->Response("LGD_MID",0) . "<br>";
		echo "상점주문번호 : " . $xpay->Response("LGD_OID",0) . "<br>";
		echo "결제금액 : " . $xpay->Response("LGD_AMOUNT",0) . "<br>";
		echo "결과코드 : " . $xpay->Response("LGD_RESPCODE",0) . "<br>";
		echo "결과메세지 : " . $xpay->Response("LGD_RESPMSG",0) . "<p>";
		*/


		$keys = $xpay->Response_Names();

		/*
		foreach($keys as $name) {
			echo $name . " = " . $xpay->Response($name, 0) . "<br>";
		}

		echo "<p>";
		*/


		$oid					= $xpay->Response("LGD_OID",0);
		$or_no					= $xpay->Response("LGD_OID",0);
		$LGD_TID				= $xpay->Response("LGD_TID",0);
		$pg_response_code		= $xpay->Response("LGD_RESPCODE",0);
		$pg_response_msg		= $xpay->Response("LGD_RESPMSG",0);
		pg_response_update();	//결제요청 응답건에 대한 업데이트



		if( "0000" == $xpay->Response_Code() ) {
			//최종결제요청 결과 성공 DB처리
			//echo "최종결제요청 결과 성공 DB처리하시기 바랍니다.<br>";

			$result_code= "0000";


			if($xpay->Response("LGD_AMOUNT",0) != $_SESSION['PAYREQ_MAP']['LGD_AMOUNT'])
			{
				$isDBOK	= false;
				$xpay->Rollback("상점 결제금액 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");

				$pg_response_code		= "price_fail";
				$pg_response_msg		= "결제금액 오류";
				pg_response_update();	//결제요청 응답건에 대한 업데이트
				exit;
			}
			else
			{
				pg_db_update();


				//최종결제요청 결과 성공 DB처리 실패시 Rollback 처리
				$isDBOK = true; //DB처리 실패시 false로 변경해 주세요.
				if( !$isDBOK ) {

					/*
					echo "<p>";
					$xpay->Rollback("상점 DB처리 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");

					echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br>";
					echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";

					if( "0000" == $xpay->Response_Code() ) {
						echo "<script>alert('상점 DB처리 실패로 인하여 Rollback 처리\\n자동취소가 정상적으로 완료 되었습니다\\n관리자에게 문의하세요');</script>";
					}else{
						echo "<script>alert('상점 DB처리 실패로 인하여 Rollback 처리\\n자동취소가 정상적으로 처리되지 않았습니다\\n관리자에게 문의하세요');</script>";
					}
					*/

				}

			}



		}else{
			//최종결제요청 결과 실패 DB처리
			//echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";
		}
	}else {
		/*
		//2)API 요청실패 화면처리
		echo "결제요청이 실패하였습니다.  <br>";
		echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
		echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";

		//최종결제요청 결과 실패 DB처리
		echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";
		*/
	}
}
else if($pg_company_info == "allthegate")
{

	if($_COOKIE['happy_mobile'] != "on")
	{
		/*
		*  ※ 유의사항 ※
		*  1.  "|"(파이프) 값은 결제처리 중 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
		*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
		*/


		/****************************************************************************
		*
		* [1] 라이브러리(AGSLib.php)를 인클루드 합니다.
		*
		****************************************************************************/
		require ("$pg_module_path/allthegate/lib/AGSLib.php");


		/****************************************************************************
		*
		* [2]. agspay4.0 클래스의 인스턴스를 생성합니다.
		*
		****************************************************************************/
		$agspay = new agspay40;


		if(preg_match("/utf/i",$server_character))
		{
			foreach ( $_POST as $k => $v )
			{
				$_POST[$k]  = iconv("utf-8","EUC-KR",$v);
			}
		}

		/****************************************************************************
		*
		* [3] AGS_pay.html 로 부터 넘겨받을 데이타
		*
		****************************************************************************/

		/*공통사용*/
		//$agspay->SetValue("AgsPayHome","C:/htdocs/agspay");			//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)
		$agspay->SetValue("AgsPayHome","$pg_module_path/allthegate");	//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)
		$agspay->SetValue("StoreId",trim($_POST["StoreId"]));		//상점아이디
		$agspay->SetValue("log","true");							//true : 로그기록, false : 로그기록안함.
		$agspay->SetValue("logLevel","ERROR");						//로그레벨 : DEBUG, INFO, WARN, ERROR, FATAL (해당 레벨이상의 로그만 기록됨)
		$agspay->SetValue("UseNetCancel","true");					//true : 망취소 사용		. false: 망취소 미사용
		$agspay->SetValue("Type", "Pay");							//고정값(수정불가)
		$agspay->SetValue("RecvLen", 7);							//수신 데이터(길이) 체크 에러시 6 또는 7 설정.

		$agspay->SetValue("AuthTy",trim($_POST["AuthTy"]));			//결제형태
		$agspay->SetValue("SubTy",trim($_POST["SubTy"]));			//서브결제형태
		$agspay->SetValue("OrdNo",trim($_POST["OrdNo"]));			//주문번호
		$agspay->SetValue("Amt",trim($_POST["Amt"]));				//금액
		$agspay->SetValue("UserEmail",trim($_POST["UserEmail"]));	//주문자이메일
		$agspay->SetValue("ProdNm",trim($_POST["ProdNm"]));			//상품명
		$AGS_HASHDATA 		= trim( $_POST["AGS_HASHDATA"] );		//암호화 HASHDATA

		/*신용카드&가상계좌사용*/
		$agspay->SetValue("MallUrl",trim($_POST["MallUrl"]));		//MallUrl(무통장입금) - 상점 도메인 가상계좌추가
		$agspay->SetValue("UserId",trim($_POST["UserId"]));			//회원아이디


		/*신용카드사용*/
		$agspay->SetValue("OrdNm",trim($_POST["OrdNm"]));			//주문자명
		$agspay->SetValue("OrdPhone",trim($_POST["OrdPhone"]));		//주문자연락처
		$agspay->SetValue("OrdAddr",trim($_POST["OrdAddr"]));		//주문자주소 가상계좌추가
		$agspay->SetValue("RcpNm",trim($_POST["RcpNm"]));			//수신자명
		$agspay->SetValue("RcpPhone",trim($_POST["RcpPhone"]));		//수신자연락처
		$agspay->SetValue("DlvAddr",trim($_POST["DlvAddr"]));		//배송지주소
		$agspay->SetValue("Remark",trim($_POST["Remark"]));			//비고
		$agspay->SetValue("DeviId",trim($_POST["DeviId"]));			//단말기아이디
		$agspay->SetValue("AuthYn",trim($_POST["AuthYn"]));			//인증여부
		$agspay->SetValue("Instmt",trim($_POST["Instmt"]));			//할부개월수
		$agspay->SetValue("UserIp",$_SERVER["REMOTE_ADDR"]);		//회원 IP

		/*신용카드(ISP)*/
		$agspay->SetValue("partial_mm",trim($_POST["partial_mm"]));		//일반할부기간
		$agspay->SetValue("noIntMonth",trim($_POST["noIntMonth"]));		//무이자할부기간
		$agspay->SetValue("KVP_CURRENCY",trim($_POST["KVP_CURRENCY"]));	//KVP_통화코드
		$agspay->SetValue("KVP_CARDCODE",trim($_POST["KVP_CARDCODE"]));	//KVP_카드사코드
		$agspay->SetValue("KVP_SESSIONKEY",$_POST["KVP_SESSIONKEY"]);	//KVP_SESSIONKEY
		$agspay->SetValue("KVP_ENCDATA",$_POST["KVP_ENCDATA"]);			//KVP_ENCDATA
		$agspay->SetValue("KVP_CONAME",trim($_POST["KVP_CONAME"]));		//KVP_카드명
		$agspay->SetValue("KVP_NOINT",trim($_POST["KVP_NOINT"]));		//KVP_무이자=1 일반=0
		$agspay->SetValue("KVP_QUOTA",trim($_POST["KVP_QUOTA"]));		//KVP_할부개월

		/*신용카드(안심)*/
		$agspay->SetValue("CardNo",trim($_POST["CardNo"]));			//카드번호
		$agspay->SetValue("MPI_CAVV",$_POST["MPI_CAVV"]);			//MPI_CAVV
		$agspay->SetValue("MPI_ECI",$_POST["MPI_ECI"]);				//MPI_ECI
		$agspay->SetValue("MPI_MD64",$_POST["MPI_MD64"]);			//MPI_MD64

		/*신용카드(일반)*/
		$agspay->SetValue("ExpMon",trim($_POST["ExpMon"]));				//유효기간(월)
		$agspay->SetValue("ExpYear",trim($_POST["ExpYear"]));			//유효기간(년)
		$agspay->SetValue("Passwd",trim($_POST["Passwd"]));				//비밀번호
		$agspay->SetValue("SocId",trim($_POST["SocId"]));				//주민등록번호/사업자등록번호

		/*계좌이체사용*/
		$agspay->SetValue("ICHE_OUTBANKNAME",trim($_POST["ICHE_OUTBANKNAME"]));		//이체은행명
		$agspay->SetValue("ICHE_OUTACCTNO",trim($_POST["ICHE_OUTACCTNO"]));			//이체계좌번호
		$agspay->SetValue("ICHE_OUTBANKMASTER",trim($_POST["ICHE_OUTBANKMASTER"]));	//이체계좌소유주
		$agspay->SetValue("ICHE_AMOUNT",trim($_POST["ICHE_AMOUNT"]));				//이체금액

		/*핸드폰사용*/
		$agspay->SetValue("HP_SERVERINFO",trim($_POST["HP_SERVERINFO"]));	//SERVER_INFO(핸드폰결제)
		$agspay->SetValue("HP_HANDPHONE",trim($_POST["HP_HANDPHONE"]));		//HANDPHONE(핸드폰결제)
		$agspay->SetValue("HP_COMPANY",trim($_POST["HP_COMPANY"]));			//COMPANY(핸드폰결제)
		$agspay->SetValue("HP_ID",trim($_POST["HP_ID"]));					//HP_ID(핸드폰결제)
		$agspay->SetValue("HP_SUBID",trim($_POST["HP_SUBID"]));				//HP_SUBID(핸드폰결제)
		$agspay->SetValue("HP_UNITType",trim($_POST["HP_UNITType"]));		//HP_UNITType(핸드폰결제)
		$agspay->SetValue("HP_IDEN",trim($_POST["HP_IDEN"]));				//HP_IDEN(핸드폰결제)
		$agspay->SetValue("HP_IPADDR",trim($_POST["HP_IPADDR"]));			//HP_IPADDR(핸드폰결제)

		/*ARS사용*/
		$agspay->SetValue("ARS_NAME",trim($_POST["ARS_NAME"]));				//ARS_NAME(ARS결제)
		$agspay->SetValue("ARS_PHONE",trim($_POST["ARS_PHONE"]));			//ARS_PHONE(ARS결제)

		/*가상계좌사용*/
		$agspay->SetValue("VIRTUAL_CENTERCD",trim($_POST["VIRTUAL_CENTERCD"]));	//은행코드(가상계좌)
		$agspay->SetValue("VIRTUAL_DEPODT",trim($_POST["VIRTUAL_DEPODT"]));		//입금예정일(가상계좌)
		$agspay->SetValue("ZuminCode",trim($_POST["ZuminCode"]));				//주민번호(가상계좌)
		$agspay->SetValue("MallPage",trim($_POST["MallPage"]));					//상점 입/출금 통보 페이지(가상계좌)
		$agspay->SetValue("VIRTUAL_NO",trim($_POST["VIRTUAL_NO"]));				//가상계좌번호(가상계좌)

		/*에스크로사용*/
		$agspay->SetValue("ES_SENDNO",trim($_POST["ES_SENDNO"]));				//에스크로전문번호

		/*계좌이체(소켓) 결제 사용 변수*/
		$agspay->SetValue("ICHE_SOCKETYN",trim($_POST["ICHE_SOCKETYN"]));			//계좌이체(소켓) 사용 여부
		$agspay->SetValue("ICHE_POSMTID",trim($_POST["ICHE_POSMTID"]));				//계좌이체(소켓) 이용기관주문번호
		$agspay->SetValue("ICHE_FNBCMTID",trim($_POST["ICHE_FNBCMTID"]));			//계좌이체(소켓) FNBC거래번호
		$agspay->SetValue("ICHE_APTRTS",trim($_POST["ICHE_APTRTS"]));				//계좌이체(소켓) 이체 시각
		$agspay->SetValue("ICHE_REMARK1",trim($_POST["ICHE_REMARK1"]));				//계좌이체(소켓) 기타사항1
		$agspay->SetValue("ICHE_REMARK2",trim($_POST["ICHE_REMARK2"]));				//계좌이체(소켓) 기타사항2
		$agspay->SetValue("ICHE_ECWYN",trim($_POST["ICHE_ECWYN"]));					//계좌이체(소켓) 에스크로여부
		$agspay->SetValue("ICHE_ECWID",trim($_POST["ICHE_ECWID"]));					//계좌이체(소켓) 에스크로ID
		$agspay->SetValue("ICHE_ECWAMT1",trim($_POST["ICHE_ECWAMT1"]));				//계좌이체(소켓) 에스크로결제금액1
		$agspay->SetValue("ICHE_ECWAMT2",trim($_POST["ICHE_ECWAMT2"]));				//계좌이체(소켓) 에스크로결제금액2
		$agspay->SetValue("ICHE_CASHYN",trim($_POST["ICHE_CASHYN"]));				//계좌이체(소켓) 현금영수증발행여부
		$agspay->SetValue("ICHE_CASHGUBUN_CD",trim($_POST["ICHE_CASHGUBUN_CD"]));	//계좌이체(소켓) 현금영수증구분
		$agspay->SetValue("ICHE_CASHID_NO",trim($_POST["ICHE_CASHID_NO"]));			//계좌이체(소켓) 현금영수증신분확인번호

		/*계좌이체-텔래뱅킹(소켓) 결제 사용 변수*/
		$agspay->SetValue("ICHEARS_SOCKETYN", trim($_POST["ICHEARS_SOCKETYN"]));	//텔레뱅킹계좌이체(소켓) 사용 여부
		$agspay->SetValue("ICHEARS_ADMNO", trim($_POST["ICHEARS_ADMNO"]));			//텔레뱅킹계좌이체 승인번호
		$agspay->SetValue("ICHEARS_POSMTID", trim($_POST["ICHEARS_POSMTID"]));		//텔레뱅킹계좌이체 이용기관주문번호
		$agspay->SetValue("ICHEARS_CENTERCD", trim($_POST["ICHEARS_CENTERCD"]));	//텔레뱅킹계좌이체 은행코드
		$agspay->SetValue("ICHEARS_HPNO", trim($_POST["ICHEARS_HPNO"]));			//텔레뱅킹계좌이체 휴대폰번호

		/****************************************************************************
		*
		* [4] 올더게이트 결제서버로 결제를 요청합니다.
		*
		****************************************************************************/
		$agspay->startPay();


		/****************************************************************************
		*
		* [5] 결제결과에 따른 상점DB 저장 및 기타 필요한 처리작업을 수행하는 부분입니다.
		*
		*	아래의 결과값들을 통하여 각 결제수단별 결제결과값을 사용하실 수 있습니다.
		*
		*	-- 공통사용 --
		*	업체ID : $agspay->GetResult("rStoreId")
		*	주문번호 : $agspay->GetResult("rOrdNo")
		*	상품명 : $agspay->GetResult("rProdNm")
		*	거래금액 : $agspay->GetResult("rAmt")
		*	성공여부 : $agspay->GetResult("rSuccYn") (성공:y 실패:n)
		*	결과메시지 : $agspay->GetResult("rResMsg")
		*
		*	1. 신용카드
		*
		*	전문코드 : $agspay->GetResult("rBusiCd")
		*	거래번호 : $agspay->GetResult("rDealNo")
		*	승인번호 : $agspay->GetResult("rApprNo")
		*	할부개월 : $agspay->GetResult("rInstmt")
		*	승인시각 : $agspay->GetResult("rApprTm")
		*	카드사코드 : $agspay->GetResult("rCardCd")
		*
		*	2.계좌이체(인터넷뱅킹/텔레뱅킹)
		*	에스크로주문번호 : $agspay->GetResult("ES_SENDNO") (에스크로 결제시)
		*
		*	3.가상계좌
		*	가상계좌의 결제성공은 가상계좌발급의 성공만을 의미하며 입금대기상태로 실제 고객이 입금을 완료한 것은 아닙니다.
		*	따라서 가상계좌 결제완료시 결제완료로 처리하여 상품을 배송하시면 안됩니다.
		*	결제후 고객이 발급받은 계좌로 입금이 완료되면 MallPage(상점 입금통보 페이지(가상계좌))로 입금결과가 전송되며
		*	이때 비로소 결제가 완료되게 되므로 결제완료에 대한 처리(배송요청 등)은  MallPage에 작업해주셔야 합니다.
		*	결제종류 : $agspay->GetResult("rAuthTy") (가상계좌 일반 : vir_n 유클릭 : vir_u 에스크로 : vir_s)
		*	승인일자 : $agspay->GetResult("rApprTm")
		*	가상계좌번호 : $agspay->GetResult("rVirNo")
		*
		*	4.핸드폰결제
		*	핸드폰결제일 : $agspay->GetResult("rHP_DATE")
		*	핸드폰결제 TID : $agspay->GetResult("rHP_TID")
		*
		*	5.ARS결제
		*	ARS결제일 : $agspay->GetResult("rHP_DATE")
		*	ARS결제 TID : $agspay->GetResult("rHP_TID")
		*
		****************************************************************************/

		$oid					= $agspay->GetResult("rOrdNo");
		$or_no					= $agspay->GetResult("rOrdNo");
		$rApprNo				= $agspay->GetResult("rApprNo");
		$pg_response_code		= $agspay->GetResult("rSuccYn");
		$pg_response_msg		= $agspay->GetResult("rResMsg");
		pg_response_update();	//결제요청 응답건에 대한 업데이트

		if($agspay->GetResult("rSuccYn") == "y")
		{
			if($agspay->GetResult("AuthTy") == "virtual"){
				//가상계좌결제의 경우 입금이 완료되지 않은 입금대기상태(가상계좌 발급성공)이므로 상품을 배송하시면 안됩니다.

			}else{
				// 결제성공에 따른 상점처리부분
				//echo ("결제가 성공처리되었습니다. [" . $agspay->GetResult("rSuccYn")."]". $agspay->GetResult("rResMsg").". " );

				if($agspay->GetResult("rAmt") == $_SESSION['ALLTHEGATE_AMOUNT'])
				{
					$result_code= "0000";
					pg_db_update();
				}
				else
				{
					$agspay->SetValue("Type", "Cancel"); // 고정
					$agspay->SetValue("CancelMsg", "PRICE FAIL"); // 취소사유
					$agspay->startPay();

					$pg_response_code		= "price_fail";
					$pg_response_msg		= "결제금액 오류";
					pg_response_update();	//결제요청 응답건에 대한 업데이트
					exit;
				}
			}
		}
		else
		{
			// 결제실패에 따른 상점처리부분
			//echo ("결제가 실패처리되었습니다. [" . $agspay->GetResult("rSuccYn")."]". $agspay->GetResult("rResMsg").". " );
		}


		/*******************************************************************
		* [6] 결제가 정상처리되지 못했을 경우 $agspay->GetResult("NetCancID") 값을 이용하여
		* 결제결과에 대한 재확인요청을 할 수 있습니다.
		*
		* 추가 데이터송수신이 발생하므로 결제가 정상처리되지 않았을 경우에만 사용하시기 바랍니다.
		*
		* 사용방법 :
		* $agspay->checkPayResult($agspay->GetResult("NetCancID"));
		*
		*******************************************************************/

		/*
		$agspay->SetValue("Type", "Pay"); // 고정
		$agspay->checkPayResult($agspay->GetResult("NetCancID"));
		*/

		/*******************************************************************
		* [7] 상점DB 저장 및 기타 처리작업 수행실패시 강제취소
		*
		* $cancelReq : "true" 강제취소실행, "false" 강제취소실행안함.
		*
		* 결제결과에 따른 상점처리부분 수행 중 실패하는 경우
		* 아래의 코드를 참조하여 거래를 취소할 수 있습니다.
		*	취소성공여부 : $agspay->GetResult("rCancelSuccYn") (성공:y 실패:n)
		*	취소결과메시지 : $agspay->GetResult("rCancelResMsg")
		*
		* 유의사항 :
		* 가상계좌(virtual)는 강제취소 기능이 지원되지 않습니다.
		*******************************************************************/

		// 상점처리부분 수행실패시 $cancelReq를 "true"로 변경하여
		// 결제취소를 수행되도록 할 수 있습니다.
		// $cancelReq의 "true"값으로 변경조건은 상점에서 판단하셔야 합니다.

		/*
		$cancelReq = "false";

		if($cancelReq == "true")
		{
			$agspay->SetValue("Type", "Cancel"); // 고정
			$agspay->SetValue("CancelMsg", "DB FAIL"); // 취소사유
			$agspay->startPay();
		}
		*/
	}
	else
	{
		///////////////////////////////////////////////////////////////////////////////////////////////////
		//
		// 올더게이트 모바일 승인 페이지 (EUC-KR)
		//
		///////////////////////////////////////////////////////////////////////////////////////////////////

		require_once ("$pg_module_path/allthegate/lib/AGSMobile.php");

		$tracking_id = $_REQUEST["tracking_id"];
		$transaction = $_REQUEST["transaction"];
		$StoreId = $_REQUEST["StoreId"];
		$log_path = null;
		// log파일 저장할 폴더의 경로를 지정합니다.
		// 경로의 값이 null로 되어있을 경우 "현재 작업 디렉토리의 /lib/log/"에 저장됩니다.

		$agsMobile = new AGSMobile($store_id,$tracking_id,$transaction, $log_path);
		$agsMobile->setLogging(true); //true : 로그기록, false : 로그기록안함.

		////////////////////////////////////////////////////////
		//
		// getTrackingInfo() 는 최초 올더게이트 페이지를 호출할 때 전달 했던 Form 값들이 Array()로 저장되어 있습니다.
		//
		////////////////////////////////////////////////////////

		$info = $agsMobile->getTrackingInfo(); //$info 변수는 array() 형식입니다.

		/////////////////////////////////////////////////////////////////////////////////
		//  -- tracking_info에 들어있는 컬럼 --
		//
		//	  결제방법 : AuthTy (card,hp,virtual)
		//	  서브결제방법 : SubTy (카드일 경우 세팅 : isp,visa3d)
		//
		//    회원아이디 : UserId
		//    구매자이름 : OrdNm
		//    상점이름 : StoreNm
		//    결제방법 : Job
		//    상품명 : ProdNm
		//
		//    휴대폰번호 : OrdPhone
		//    수신자명 : RcpNm
		//    수신자연락처 : RcpPhone
		//    주문자주소 : OrdAddr
		//    주문번호 : OrdNo
		//    배송지주소 : DlvAddr
		//    상품코드 : ProdCode
		//    입금예정일 : VIRTUAL_DEPODT
		//    상품종류 : HP_UNITType
		//    성공 URL : RtnUrl
		//    상점아이디 : StoreId
		//    가격 : Amt
		//    이메일 : UserEmail
		//    상점URL : MallUrl
		//    취소 URL : CancelUrl
		//    통보페이지 : MallPage
		//
		//    기타요구사항 : Remark
		//    추가사용필드1 : Column1
		//    추가사용필드1 : Column2
		//    추가사용필드1 : Column3
		//    CP아이디 : HP_ID
		//    CP비밀번호 :  HP_PWD
		//    SUB-CP아이디 : HP_SUBID
		//    상품코드 :  ProdCode
		//    결제정보 : DeviId ( 9000400001:일반결제, 9000400002:무이자결제)
		//    카드사선택 : CardSelect
		//    할부기간 :  QuotaInf
		//    무이자 할부기간: NointInf
		//
		////////////////////////////////////////////////////////////////////////////////////////////////

		// tracking_info의 정보들은 아래의 방법으로 가져오시면 됩니다
		//
		//    print_r($info); //tracking_info
		//    echo "주문번호 : ".$info["OrdNo"]."</br>";
		//    echo "상품명 : ".$info["ProdNm"]."</br>";
		//    echo "결제방법 : ".$info["Job"]."</br>";
		//    echo "회원아이디 : ".$info["UserId"]."</br>";
		//    echo "구매자이름 : ".$info["OrdNm"]."</br>";
		//

		/*
		echo "AuthTy : ".$info["AuthTy"]."</br>";
		echo "SubTy : ".$info["SubTy"]."</br>";
		*/


		$ret = $agsMobile->approve();


		 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 //
		 // 결제결과에 따른 상점DB 저장 및 기타 필요한 처리작업을 수행하는 부분입니다.
		 // 아래의 결과값들을 통하여 각 결제수단별 결제결과값을 사용하실 수 있습니다.
		 //
		 // $ret는 array() 형식으로 다음과 같은 구조를 가집니다.
		 //
		 // $ret = array (
		 //        'status' => 'ok' | 'error' //승인성공일 경우 ok , 실패면 error
		 //		  'message' => '에러일 경우 에러메시지'
		 //		  'data' => 결제수단별 정보 array() //승인성공일 경우만 세팅됩니다.
		 //	)
		 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		$_POST['pay_type_option']	= $info["Column1"];
		$pg_pay_mode_type			= $info["Column1"];
		$oid						= $ret["data"]["OrdNo"];
		$or_no						= $ret["data"]["OrdNo"];
		$rApprNo					= $ret["data"]["AdmNo"];
		$pg_response_code			= $ret['status'];
		$pg_response_msg			= $ret["message"];
		pg_response_update();		//결제요청 응답건에 대한 업데이트



		if ($ret['status'] == "ok") {
			/// 승인 성공

			/*
			echo "성공여부: ".$ret['status']."<br/>";   //ok이면 성공..
			echo "결과메시지: ".$ret["message"]."<br/>";
			*/


			/*
			//data 이하에 서버 응답 메시지가 있습니다.
			echo "업체ID : ".$ret["data"]["StoreId"]."<br/>";
			echo "주문번호: ".$ret["data"]["OrdNo"]."<br/>";
			echo "거래금액: ".$ret["data"]["Amt"]."원 <br/>";
			echo "tracking_id: ".$tracking_id."<br/>";
			*/




			if($ret['data']['Amt'] == $_SESSION['ALLTHEGATE_AMOUNT'])
			{
				$result_code	= "0000";
				pg_db_update();
			}
			else
			{
				$agsMobile->forceCancel();

				$pg_response_code		= "price_fail";
				$pg_response_msg		= "결제금액 오류";
				pg_response_update();	//결제요청 응답건에 대한 업데이트
				exit;
			}


			if($ret["paytype"] == "card"){

				/*
				/// 카드 결제 후 받은 정보
				echo "AuthTy : ".$ret["data"]["AuthTy"]."<br/>";
				echo "SubTy: ".$ret["data"]["SubTy"]."<br/>";

				echo "업체ID : ".$ret["data"]["StoreId"]."<br/>";
				echo "망취소ID : ".$ret["data"]["NetCancelId"]."<br/>";
				echo "주문번호: ".$ret["data"]["OrdNo"]."<br/>";
				echo "거래금액: ".$ret["data"]["Amt"]."원 <br/>";
				echo "에스크로여부 : ".$ret["data"]["EscrowYn"]."<br/>";  //y이면 escrow
				echo "무이자여부: ".$ret["data"]["NoInt"]."<br/>";  //y이면 무이자
				echo "에스크로전문번호 : ".$ret["data"]["EscrowSendNo"]."<br/>";


				echo "전문코드 : ".$ret["data"]["BusiCd"]."<br/>";
				echo "거래번호: ".$ret["data"]["DealNo"]."<br/>";
				echo "승인번호: ".$ret["data"]["AdmNo"]."<br/>";
				echo "승인시각: ".$ret["data"]['AdmTime']."<br/>";
				echo "카드사코드: ".$ret["data"]["CardCd"]."<br/>";
				echo "카드사명: ".$ret["data"]["CardNm"]."<br/>";
				echo "할부개월수: ".$ret["data"]["PartialMm"]."<br/>";
				*/

				/////////////////////////////////////////
				//
				// 카드 거래의 경우,
				// 상점 DB 및 기타 상점측 예외상황으로 결제를 바로 취소해야 한다면
				// 아래의 승인 이후 아래의 함수 호출로 취소가 가능합니다.
				//
				/////////////////////////////////////////

				// 아래 부분을 주석해제 하면 바로 강제 취소 할 수 있습니다. (카드 정상 승인 이후에만 가능)


				/*
				$cancelRet = $agsMobile->forceCancel();

				// 상점은 아래에서 처리하세요
				if ($cancelRet['status'] == "ok") {
					echo "취소 성공<br/>";
					echo "업체ID : ".$cancelRet["data"]["StoreId"]."<br/>";
					echo "승인번호: ".$cancelRet["data"]["AdmNo"]."<br/>";
					echo "승인시각: ".$cancelRet["data"]["AdmTime"]."<br/>";
					echo "코드: ".$cancelRet["data"]['Code']."<br/>";

				}else {
					//취소 통신 실패
					echo "취소 실패 : ".$cancelRet['message']; // 에러 메시지
				}
	*/



				//////////////////////////////////////////////
				//
				// 영수증 사용시 아래의 링크를 사용하시면 됩니다.
				//
				//////////////////////////////////////////////

				$url = "http://www.allthegate.com/customer/receiptLast3.jsp";
				$url .= "?sRetailer_id=".$ret["data"]["StoreId"];
				$url .= "?approve=".$ret["data"]["AdmNo"];
				$url .= "?send_no=".$ret["data"]["DealNo"];
				$url .= "?send_dt=".substr($ret["data"]["AdmTime"],0,8);




			}else if($ret["paytype"] == "hp"){
				/*
				/// 핸드폰 결제 후 받은 정보
				echo "AuthTy : ".$ret["data"]["AuthTy"]."<br/>";
				echo "SubTy: ".$ret["data"]["SubTy"]."<br/>";

				echo "업체ID : ".$ret["data"]["StoreId"]."<br/>";
				echo "망취소ID : ".$ret["data"]["NetCancelId"]."<br/>";
				echo "주문번호: ".$ret["data"]["OrdNo"]."<br/>";
				echo "거래금액: ".$ret["data"]["Amt"]."원 <br/>";

				echo "핸드폰통신사 : ".$ret["data"]["PhoneCompany"]."<br/>";
				echo "핸드폰번호 : ".$ret["data"]["Phone"]."<br/>";
				echo "핸드폰결제 TID : ".$ret["data"]["AdmTID"]."<br/>";
				*/

				/////////////////////////////////////////
				//
				// 휴대폰 거래의 경우,
				// 상점 DB 및 기타 상점측 예외상황으로 결제를 바로 취소해야 한다면
				// 아래의 승인 이후 아래의 함수 호출로 취소가 가능합니다.
				//
				/////////////////////////////////////////

				// 아래 부분을 주석해제 하면 바로 강제 취소 할 수 있습니다. (휴대폰 정상 승인 이후에만 가능)

	//            $cancelRet = $agsMobile->forceCancel();
	//
	//			// 상점은 아래에서 처리하세요
	//			if ($cancelRet['status'] == "ok") {
	//
	//		        echo "업체ID : ".$cancelRet["data"]["StoreId"]."<br/>";
	//		   		echo "핸드폰결제 TID : ".$cancelRet["data"]["AdmTID"]."<br/>";
	//
	//			}else {
	//				//취소 통신 실패
	//				echo "취소 실패 : ".$cancelRet['message']; // 에러 메시지
	//			}

			}else if($ret["paytype"] == "virtual"){
				/// 가상계좌 처리 후 받은 정보 ///

				////////////////////////////////////////////////////////
				//
				//   가상계좌의 결제성공은 가상계좌발급의 성공만을 의미하며 입금대기상태로 실제 고객이 입금을 완료한 것은 아닙니다.
				//   따라서 가상계좌 결제완료시 결제완료로 처리하여 상품을 배송하시면 안됩니다.
				//   결제후 고객이 발급받은 계좌로 입금이 완료되면 MallPage(상점 입금통보 페이지(가상계좌))로 입금결과가 전송되며
				//   이때 비로소 결제가 완료되게 되므로 결제완료에 대한 처리(배송요청 등)은  MallPage에 작업해주셔야 합니다.
				//
				//   승인일자 : $ret["data"]["SuccessTime"]
				//   가상계좌번호 : $ret["data"]["VirtualNo"]
				//   입금은행코드 : $ret["data"]["BankCode"]
				//
				////////////////////////////////////////////////////////

				/*
				echo "AuthTy : ".$ret["data"]["AuthTy"]."<br/>";
				echo "SubTy: ".$ret["data"]["SubTy"]."<br/>";


				echo "업체ID : ".$ret["data"]["StoreId"]."<br/>";
				echo "망취소ID : ".$ret["data"]["NetCancelId"]."<br/>";
				echo "주문번호: ".$ret["data"]["OrdNo"]."<br/>";
				echo "거래금액: ".$ret["data"]["Amt"]."원 <br/>";
				echo "에스크로여부 : ".$ret["data"]["EscrowYn"]."<br/>";  //y이면 escrow
				echo "에스크로전문번호 : ".$ret["data"]["EscrowSendNo"]."<br/>";

				echo "승인일자 : ".$ret["data"]["SuccessTime"]."<br/>";
				echo "가상계좌번호 : ".$ret["data"]["VirtualNo"]."<br/>";
				echo "입금은행코드 : ".$ret["data"]["BankCode"]."<br/>";
				echo "입금기한 : ".$ret["data"]["DueDate"]."<br/>";
				*/
			}



		}else {
			/// 승인 실패
			/*
			echo "승인실패 : ".$ret['message']."<br/>"; // 에러 메시지
			*/
		}
	}


}
else if($pg_company_info == "daoupay")
{
	$pg_ip_ex		= explode(".",getenv("REMOTE_ADDR"));
	$pg_ip1			= $pg_ip_ex[0].".".$pg_ip_ex[1].".".$pg_ip_ex[2];
	$pg_ip2			= $pg_ip_ex[3];

	if($pg_ip1 == "27.102.213" && ($pg_ip2 >= 200 && $pg_ip2 <= 209))
	{
	}
	else
	{
		exit;
	}


	$oid	= $_GET['ORDERNO'];
	$or_no	= $_GET['ORDERNO'];
	if($HAPPY_CONFIG['pg_pay_mode'] != "test")
	{
		$PAY_DATA        = pg_jangboo_chk($_GET['RESERVEDINDEX1'],$oid);
		if($PAY_DATA['total_price'] == $_GET['AMOUNT'])
		{
			$result_code	= "0000";
			ob_start();
			pg_db_update();
			ob_end_clean();

			echo "
					<html>
					<body>
						<RESULT>SUCCESS</RESULT>
					</body>
					</html>
			";
		}
		else
		{
			exit;
		}
	}
	else
	{
		ob_start();
		pg_db_update();
		ob_end_clean();
		echo "
				<html>
				<body>
					<RESULT>SUCCESS</RESULT>
				</body>
				</html>
		";
	}
}
else if($pg_company_info == "inicis")
{
	$PGIP				= getenv("REMOTE_ADDR");


	//[모바일] PG에서 보냈는지 IP로 체크. 계좌이체때문에 상단으로 옮겨짐
	if($PGIP == "211.219.96.165" || $PGIP == "118.129.210.25" || $PGIP == "183.109.71.153" || $PGIP == "39.115.212.9") //P_NOTI_URL
	{
		// 이니시스 NOTI 서버에서 받은 Value
		$P_TID;				// 거래번호
		$P_MID;				// 상점아이디
		$P_AUTH_DT;			// 승인일자
		$P_STATUS;			// 거래상태 (00:성공, 01:실패)
		$P_TYPE;			// 지불수단
		$P_OID;				// 상점주문번호
		$P_FN_CD1;			// 금융사코드1
		$P_FN_CD2;			// 금융사코드2
		$P_FN_NM;			// 금융사명 (은행명, 카드사명, 이통사명)
		$P_AMT;				// 거래금액
		$P_UNAME;			// 결제고객성명
		$P_RMESG1;			// 결과코드
		$P_RMESG2;			// 결과메시지
		$P_NOTI;			// 노티메시지(상점에서 올린 메시지)
		$P_AUTH_NO;			// 승인번호


		$P_TID = $_REQUEST[P_TID];
		$P_MID = $_REQUEST[P_MID];
		$P_AUTH_DT = $_REQUEST[P_AUTH_DT];
		$P_STATUS = $_REQUEST[P_STATUS];
		$P_TYPE = $_REQUEST[P_TYPE];
		$P_OID = $_REQUEST[P_OID];
		$P_FN_CD1 = $_REQUEST[P_FN_CD1];
		$P_FN_CD2 = $_REQUEST[P_FN_CD2];
		$P_FN_NM = $_REQUEST[P_FN_NM];
		$P_AMT = $_REQUEST[P_AMT];
		$P_UNAME = $_REQUEST[P_UNAME];
		$P_RMESG1 = $_REQUEST[P_RMESG1];
		$P_RMESG2 = $_REQUEST[P_RMESG2];
		$P_NOTI = $_REQUEST[P_NOTI];
		$P_AUTH_NO = $_REQUEST[P_AUTH_NO];


		//WEB 방식의 경우 가상계좌 채번 결과 무시 처리
		//(APP 방식의 경우 해당 내용을 삭제 또는 주석 처리 하시기 바랍니다.)
		if($P_TYPE == "VBANK")	//결제수단이 가상계좌이며
		{
			if($P_STATUS != "02") //입금통보 "02" 가 아니면(가상계좌 채번 : 00 또는 01 경우)
			{
				echo "OK";
				return;
			}
		}



		$PageCall_time = date("H:i:s");

		$value = array(
				"PageCall time" => $PageCall_time,
				"P_TID"			=> $P_TID,
				"P_MID"     => $P_MID,
				"P_AUTH_DT" => $P_AUTH_DT,
				"P_STATUS"  => $P_STATUS,
				"P_TYPE"    => $P_TYPE,
				"P_OID"     => $P_OID,
				"P_FN_CD1"  => $P_FN_CD1,
				"P_FN_CD2"  => $P_FN_CD2,
				"P_FN_NM"   => $P_FN_NM,
				"P_AMT"     => $P_AMT,
				"P_UNAME"   => $P_UNAME,
				"P_RMESG1"  => $P_RMESG1,
				"P_RMESG2"  => $P_RMESG2,
				"P_NOTI"    => $P_NOTI,
				"P_AUTH_NO" => $P_AUTH_NO
				);


		// 결제처리에 관한 로그 기록
		//write_log22($log_file, $value);


		/***********************************************************************************
		 ' 위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 이니시스로 실패시는 "FAIL" 을
		 ' 리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
		 ' (주의) OK를 리턴하지 않으시면 이니시스 지불 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
		 ' 기타 다른 형태의 echo "" 는 하지 않으시기 바랍니다
		'***********************************************************************************/

		$oid	= $P_OID;
		$or_no	= $P_OID;
		$m_tid	= $P_TID;
		$pg_response_code			= $P_STATUS;
		$pg_response_msg			= $P_RMESG1;
		pg_response_update();		//결제요청 응답건에 대한 업데이트

		if($P_STATUS == "00")
		{
			pg_db_update();

			echo "OK";
		}

		// if(데이터베이스 등록 성공 유무 조건변수 = true)
		//	echo "OK"; //절대로 지우지 마세요
		// else
		//	 echo "FAIL";
		exit;
	}


	if($_COOKIE['happy_mobile'] != "on")
	{
		require_once($pg_module_path.'/inicis/libs/INIStdPayUtil.php');
		require_once($pg_module_path.'/inicis/libs/HttpClient.php');

		$util = new INIStdPayUtil();

		//try {
			//#############################
			// 인증결과 파라미터 일괄 수신
			//#############################
			//		$var = $_REQUEST["data"];
			//		System.out.println("paramMap : "+ paramMap.toString());
			//#####################
			// 인증이 성공일 경우만
			//#####################
			if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

				//echo "####인증성공/승인요청####";
				//echo "<br/>";

				//############################################
				// 1.전문 필드 값 설정(***가맹점 개발수정***)
				//############################################

				$pg_pay_mode_type			= $_REQUEST["merchantData"]; //하단 location 때문

				$mid = $_REQUEST["mid"];     // 가맹점 ID 수신 받은 데이터로 설정

				$signKey = $HAPPY_CONFIG['inicis_signkey']; // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지

				$timestamp = $util->getTimestamp();   // util에 의해서 자동생성

				$charset = $_REQUEST["charset"];        // 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)

				$format = "JSON";        // 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)
				// 추가적 noti가 필요한 경우(필수아님, 공백일 경우 미발송, 승인은 성공시, 실패시 모두 Noti발송됨) 미사용
				//String notiUrl	= "";

				$authToken = $_REQUEST["authToken"];   // 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)

				$authUrl = $_REQUEST["authUrl"];    // 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)

				$netCancel = $_REQUEST["netCancel"];   // 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

				$ackUrl = $_REQUEST["checkAckUrl"];   // 가맹점 내부 로직 처리후 최종 확인 API URL(수신 받은 값으로 설정, 임의 세팅 금지)

				///$mKey = $util->makeHash(signKey, "sha256"); // 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
				$mKey = hash("sha256", $signKey);

				//#####################
				// 2.signature 생성
				//#####################
				$signParam["authToken"] = $authToken;  // 필수
				$signParam["timestamp"] = $timestamp;  // 필수
				// signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
				$signature = $util->makeSignature($signParam);


				//#####################
				// 3.API 요청 전문 생성
				//#####################
				$authMap["mid"] = $mid;   // 필수
				$authMap["authToken"] = $authToken; // 필수
				$authMap["signature"] = $signature; // 필수
				$authMap["timestamp"] = $timestamp; // 필수
				$authMap["charset"] = $charset;  // default=UTF-8
				$authMap["format"] = $format;  // default=XML
				//if(null != notiUrl && notiUrl.length() > 0){
				//	authMap.put("notiUrl"		,notiUrl);
				//}


				//try {

					$httpUtil = new HttpClient();

					//#####################
					// 4.API 통신 시작
					//#####################

					$authResultString = "";
					if ($httpUtil->processHTTP($authUrl, $authMap)) {
						$authResultString = $httpUtil->body;
					} else {
						echo "Http Connect Error\n";
						echo $httpUtil->errormsg;

						//throw new Exception("Http Connect Error");
					}

					//############################################################
					//5.API 통신결과 처리(***가맹점 개발수정***)
					//############################################################
					//echo "## 승인 API 결과 ##";

					if( $charset != "UTF-8" )
					{
						$authResultString = iconv("EUC-KR","UTF-8",$authResultString);
					}

					$resultMap = json_decode($authResultString, true);

					if( $charset != "UTF-8" )
					{
						foreach ( $resultMap as $k => $v )
						{
							$resultMap[$k] = iconv("UTF-8","EUC-KR",$v);
						}
					}

					// 로그 생성
					$LOG_FILE				= $pg_module_path."/inicis/log/INIPHP_".date("ymd").".log";
					$LOG_LIST['LOG_START']	= "====[ ".date("Y-m-d H:i:s")." ]===========================================================================\n";
					$LOG_LIST['resultMap']	= $resultMap;
					//$LOG_LIST['REQUEST']	= $_REQUEST;
					$LOG_LIST['LOG_END']	= "====[ ".date("Y-m-d H:i:s")." ]===========================================================================\n\n\n\n\n\n\n\n\n\n";
					//ksort($LOG_LIST);
					//write_log22($LOG_FILE, $LOG_LIST);


					$oid						= $resultMap["MOID"];
					$or_no						= $resultMap["MOID"];
					$m_tid						= $resultMap["tid"];
					$pg_response_code			= $resultMap["resultCode"];
					$pg_response_msg			= $resultMap['resultMsg'];
					pg_response_update();		//결제요청 응답건에 대한 업데이트



					if (strcmp("0000", $resultMap["resultCode"]) == 0) {

						/*                         * ***************************************************************************
						* 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.
						[중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
						처리중 에러 발생시 망취소를 한다.
						* **************************************************************************** */

						/*                         *
						**************************************************************************
						내부로직 처리가 정상적으로 완료 되면 ackUrl로 결과 통신한다.
						만약 ACK통신중 에러 발생시(exeption) 망취소를 한다.
						* **************************************************************************** */
						$checkMap["mid"] = $mid;        // 필수
						$checkMap["tid"] = $resultMap["tid"];    // 필수
						$checkMap["applDate"] = $resultMap["applDate"];  // 필수
						$checkMap["applTime"] = $resultMap["applTime"];  // 필수
						$checkMap["price"] = $resultMap["TotPrice"];   // 필수
						$checkMap["goodName"] = $resultMap["goodname"];  // 필수
						$checkMap["charset"] = $charset;  // default=UTF-8
						$checkMap["format"] = $format;  // default=XML

						$ackResultString = "";
						if ($httpUtil->processHTTP($ackUrl, $checkMap)) {
							$ackResultString = $httpUtil->body;
						} else {
							echo "Http Connect Error\n";
							echo $httpUtil->errormsg;

							//throw new Exception("Http Connect Error");
						}


						if( $charset != "UTF-8" )
						{
							$ackResultString = iconv("EUC-KR","UTF-8",$ackResultString);
						}

						$ackMap = json_decode($ackResultString,true);

						if( $charset != "UTF-8" )
						{
							foreach ( $ackMap as $k => $v )
							{
								$ackMap[$k] = iconv("UTF-8","EUC-KR",$v);
							}
						}
						echo "<p>거래 성공 여부</p>";
						echo "<p>성공</p>";


						if( $ackMap['resultMsg'] == "succ" AND $ackMap['resultCode'] == "0000" )
						{

							echo "<p>결제완료처리 : 성공</p>";



							//$total_price	= pg_jangboo_chk($_GET['RESERVEDINDEX1'],$oid);  AND $total_price == $_SESSION['INI_PRICE'] - 기존 검토 함수 문제  - 포인트 복합결제시 정확하지 않음.


							if ( $ackMap['resultCode'] == "0000" )
							{
								$result_code	= "0000";
								pg_db_update();
							}
							else
							{
								/* * ************************
								 * 1. 라이브러리 인클루드 *
								 * ************************ */
								require($pg_module_path."/inicis/libs/INILib.php");

								/* * *************************************
								 * 2. INIpay41 클래스의 인스턴스 생성 *
								 * ************************************* */
								$inipay = new INIpay50;

								/* * *******************
								 * 3. 취소 정보 설정 *
								 * ******************* */
								$inipay->SetField("inipayhome", $pg_module_path.'/inicis/'); // 이니페이 홈디렉터리(상점수정 필요)
								$inipay->SetField("type", "cancel");                            // 고정 (절대 수정 불가)
								$inipay->SetField("debug", "true");                             // 로그모드("true"로 설정하면 상세로그가 생성됨.)
								$inipay->SetField("mid", $mid);                                 // 상점아이디
								/* * ************************************************************************************************
								 * admin 은 키패스워드 변수명입니다. 수정하시면 안됩니다. 1111의 부분만 수정해서 사용하시기 바랍니다.
								 * 키패스워드는 상점관리자 페이지(https://iniweb.inicis.com)의 비밀번호가 아닙니다. 주의해 주시기 바랍니다.
								 * 키패스워드는 숫자 4자리로만 구성됩니다. 이 값은 키파일 발급시 결정됩니다.
								 * 키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오.
								 * ************************************************************************************************ */
								$inipay->SetField("admin", $HAPPY_CONFIG['inicis_key_pwd']);
								$inipay->SetField("tid", $m_tid);                                 // 취소할 거래의 거래아이디
								$inipay->SetField("cancelmsg", "결제금액 위변조");                           // 취소사유

								/* * **************
								 * 4. 취소 요청 *
								 * ************** */
								$inipay->startAction();


								$pg_response_code		= "price_fail";
								$pg_response_msg		= "결제금액 오류";
								pg_response_update();	//결제요청 응답건에 대한 업데이트



								echo "<p>장부처리 실패 취소 (결제금액 위변조)</p>";
								echo "<p><button onclick=\"self.close();\">창 닫기</button></p>";
								exit;
							}
						}
						else
						{
							echo "<p>결제완료처리 : 실패</p>";
							exit;
						}


					} else {
						echo "<p>거래 성공 여부</p>";
						echo "<p>실패</p>";
						echo $resultMap['resultMsg'];
						echo "<p><button onclick=\"self.close();\">창 닫기</button></p>";
						echo "<script> alert('결제 실패 : ".$resultMap['resultMsg']."'); self.close(); </script>";
						exit;
					}


					// 수신결과를 파싱후 resultCode가 "0000"이면 승인성공 이외 실패
					// 가맹점에서 스스로 파싱후 내부 DB 처리 후 화면에 결과 표시
					// payViewType을 popup으로 해서 결제를 하셨을 경우
					// 내부처리후 스크립트를 이용해 opener의 화면 전환처리를 하세요
					//throw new Exception("강제 Exception");
				/*} catch (Exception $e) {
					//    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
					//####################################
					// 실패시 처리(***가맹점 개발수정***)
					//####################################
					//---- db 저장 실패시 등 예외처리----//
					$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
					echo $s;

					//#####################
					// 망취소 API
					//#####################

					$netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)
					if ($httpUtil->processHTTP($netCancel, $authMap)) {
						$netcancelResultString = $httpUtil->body;
					} else {
						echo "Http Connect Error\n";
						echo $httpUtil->errormsg;

						throw new Exception("Http Connect Error");
					}

					//echo "## 망취소 API 결과 ##";

					$netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
					$netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);

					echo "<pre>", $netcancelResultString . "</pre>";
					// 취소 결과 확인
				}*/
			} else {

				//#############
				// 인증 실패시
				//#############
				echo "<br/>";
				echo "####인증실패####";

				echo "<pre>" . var_dump($_REQUEST) . "</pre>";
				exit;
			}
		//} catch (Exception $e) {
		//	$s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
		//	echo $s;
		//}
	}
	else
	{

		//P_NEXT_URL,P_RETURN_URL
		$PAY_DATA						= pg_jangboo_chk($P_NOTI_EX['pay_type_option'],$P_NOTI_EX['oid']);
		if(preg_match("/bank/i",$PAY_DATA['pay_method']))
		{
			if($PAY_DATA['in_check'] == '' || $PAY_DATA['in_check'] == 0)
			{
				gomsg("결제 실패하였습니다.",$main_url);
				exit;
			}
		}
		else
		{
			$oid						= $P_NOTI_EX['oid'];
			$or_no						= $P_NOTI_EX['oid'];
			$pg_response_code			= $_REQUEST['P_STATUS'];
			$pg_response_msg			= $_REQUEST['P_RMESG1'];
			pg_response_update();		//결제요청 응답건에 대한 업데이트


			if($_REQUEST['P_STATUS'] == "00" && $PAY_DATA['total_price'] == $_REQUEST['P_AMT'])
			{
				require($pg_module_path."/inicis/libs/INImx.php");

				$inimx = new INImx;


				/////////////////////////////////////////////////////////////////////////////
				///// 1. 변수 초기화 및 POST 인증값 받음                                 ////
				/////////////////////////////////////////////////////////////////////////////

				$inimx->reqtype 		= "PAY";  //결제요청방식
				$inimx->inipayhome 		= $pg_module_path.'/inicis/'; //로그기록 경로 (이 위치의 하위폴더에 log폴더 생성 후 log폴더에 대해 777 권한 설정)
				$inimx->status			= $_REQUEST['P_STATUS'];
				$inimx->rmesg1			= $_REQUEST['P_RMESG1'];
				$inimx->tid				= $_REQUEST['P_TID'];
				$inimx->req_url			= $_REQUEST['P_REQ_URL'];
				$inimx->noti			= $_REQUEST['P_NOTI'];


				/////////////////////////////////////////////////////////////////////////////
				///// 2. 상점 아이디 설정 :                                              ////
				/////    결제요청 페이지에서 사용한 MID값과 동일하게 세팅해야 함...      ////
				/////    인증TID를 잘라서 사용가능 : substr($P_TID,'10','10');           ////
				/////////////////////////////////////////////////////////////////////////////
				$inimx->id_merchant = substr($_REQUEST['P_TID'],'10','10');  //




				/////////////////////////////////////////////////////////////////////////////
				///// 3. 인증결과 확인 :                                                 ////
				/////    인증값을 가지고 성공/실패에 따라 처리 방법                      ////
				/////////////////////////////////////////////////////////////////////////////
				if($inimx->status =="00")   // 모바일 인증이 성공시
				{

					/////////////////////////////////////////////////////////////////////////////
					///// 4. 승인요청 :                                                      ////
					/////    인증성공시  P_REQ_URL로 승인요청을 함...                        ////
					/////////////////////////////////////////////////////////////////////////////
					$inimx->startAction();  // 승인요청



					$inimx->getResult();  //승인결과 파싱, P_REQ_URL에서 내려준 결과값 파싱


					/**
					결과값 파싱 전문은 INImx내 변수로 담아 표현하고 있습니다. ( 메뉴얼얼내 값 대조하여 필요한 값 저장할 수 있도록 부탁드립니다.)

					--공통
					$this->m_tid  = $resultString['P_TID'];                                     // 거래번호
					$this->m_resultCode = $resultString['P_STATUS'];                            // 거래상태 - 지불결과 성공:00, 실패:00 이외 실패
					$this->m_resultMsg  = $resultString['P_RMESG1'];                            // 지불 결과 메시지
					$this->m_cardQuota  = $resultString['P_RMESG2'];                            // 신용카드 할부 개월 수 (메뉴얼 확인 필요)
					$this->m_payMethod = $resultString['P_TYPE'];                               // 지불수단
					$this->m_mid  = $resultString['P_MID'];                                     // 상점아이디
					$this->m_moid  = $resultString['P_OID'];                                    // 상점주문번호
					$this->m_resultprice = $resultString['P_AMT'];                              // 거래금액
					$this->m_buyerName  = $resultString['P_UNAME'];                             // 구매자명
					$this->m_nextUrl  = $resultString['P_NEXT_URL'];                            // 가맹점 전달 P_NEXT_URL
					$this->m_notiUrl  = $resultString['P_NOTEURL'];                             // 가맹점 전달 NOTE_URL --->>이거도 설명 에매하네
					$this->m_authdt  = $resultString['P_AUTH_DT'];                              // 승인일자(YYYYmmddHHmmss)
					$this->m_pgAuthDate  = substr($resultString['P_AUTH_DT'],'0','8');
					$this->m_pgAuthTime  = substr($resultString['P_AUTH_DT'],'8','6');
					$this->m_mname  = $resultString['P_MNAME'];                                 // 가맹점명
					$this->m_noti  = $resultString['P_NOTI'];                                   // 기타주문정보
					$this->m_authCode = $resultString['P_AUTH_NO'];                             // 신용카드 승인번호 - 신용카드 거래에서만 사용
					$this->m_cardCode = $resultString['P_FN_CD1'];                              // 카드코드


					--신용카드
					$this->m_cardIssuerCode = $resultString['P_CARD_ISSUER_CODE'];              // 발급사 코드
					$this->m_cardNum  = $resultString['P_CARD_NUM'];                            // 카드번호
					$this->m_cardMumbernum  = $resultString['P_CARD_MEMBER_NUM'];               // 가맹점번호
					$this->m_cardpurchase  = $resultString['P_CARD_PURCHASE_CODE'];             // 매입사 코드
					$this->m_prtc  = $resultString['P_CARD_PRTC_CODE'];                         // 부분취소 가능 여부
					$this->m_cardinterest  = $resultString['P_CARD_INTEREST'];                  // 무이자 할부여부 (일반 : 0, 무이자 : 1)
					$this->m_cardcheckflag  = $resultString['P_CARD_CHECKFLAG'];                // 체크카드여부 (신용카드:0, 체크카드:1, 기프트카드:2)
					$this->m_cardName  = $resultString['P_FN_NM'];                              // 결제카드한글명
					$this->m_cardSrcCode  = $resultString['P_SRC_CODE'];                        // 앱연동 여부 P : 페이핀, K : 국민앱카드


					--휴대폰
					$this->m_codegw  = $resultString['P_HPP_CORP'];                             // 휴대폰 통신사코드
					$this->m_hppapplnum  = $resultString['P_APPL_NUM'];                         // 휴대폰결제 승인번호
					$this->m_hppnum  = $resultString['P_HPP_NUM'];                              // 고객 휴대폰 번호


					--가상계좌
					$this->m_vacct  = $resultString['P_VACT_NUM'];                              // 입금할 계좌 번호
					$this->m_dtinput = $resultString['P_VACT_DATE'];                            // 입금마감일자(YYYYmmdd)
					$this->m_tminput = $resultString['P_VACT_TIME'];                            // 입금마감시간(hhmmss)
					$this->m_nmvacct = $resultString['P_VACT_NAME'];                            // 계좌주명
					$this->m_vcdbank = $resultString['P_VACT_BANK_CODE'];                       // 은행코드
					*/



					/*
					switch($inimx->m_payMethod)
					{

						case(CARD):  //신용카드 안심클릭


						echo("승인결과코드:".$inimx->m_resultCode."<br>");
						echo("결과메시지:".$inimx->m_resultMsg."<br>");
						echo("지불수단:".$inimx->m_payMethod."<br>");
						echo("주문번호:".$inimx->m_moid."<br>");
						echo("TID:".$inimx->m_tid."<br>");
						echo("승인금액:".$inimx->m_resultprice."<br>");
						echo("승인일:".$inimx->m_pgAuthDate."<br>");
						echo("승인시각:".$inimx->m_pgAuthTime."<br>");
						echo("상점ID:".$inimx->m_mid."<br>");
						echo("구매자명:".$inimx->m_buyerName."<br>");
						echo("P_NOTI:".$inimx->m_noti."<br>");
						echo("NEXT_URL:".$inimx->m_nextUrl."<br>");
						echo("NOTI_URL:".$inimx->m_notiUrl."<br>");
						echo("승인번호:".$inimx->m_authCode."<br>");
						echo("할부개월:".$inimx->m_cardQuota."<br>");
						echo("카드코드:".$inimx->m_cardCode."<br>");
						echo("발급사코드:".$inimx->m_cardIssuerCode."<br>");
						echo("카드번호:".$inimx->m_cardNumber."<br>");
						echo("가맹점번호:".$inimx->m_cardMember."<br>");
						echo("매입사코드:".$inimx->m_cardpurchase."<br>");
						echo("부분취소가능여부(0:불가, 1:가능):".$inimx->m_prtc."<br>");


						break;

						case(MOBILE):  //휴대폰결제

						echo("승인결과코드:".$inimx->m_resultCode."<br>");
						echo("결과메시지:".$inimx->m_resultMsg."<br>");
						echo("지불수단:".$inimx->m_payMethod."<br>");
						echo("주문번호:".$inimx->m_moid."<br>");
						echo("TID:".$inimx->m_tid."<br>");
						echo("승인금액:".$inimx->m_resultprice."<br>");
						echo("승인일:".$inimx->m_pgAuthDate."<br>");
						echo("승인시각:".$inimx->m_pgAuthTime."<br>");
						echo("상점ID:".$inimx->m_mid."<br>");
						echo("구매자명:".$inimx->m_buyerName."<br>");
						echo("P_NOTI:".$inimx->m_noti."<br>");
						echo("NEXT_URL:".$inimx->m_nextUrl."<br>");
						echo("NOTI_URL:".$inimx->m_notiUrl."<br>");
						echo("통신사:".$inimx->m_codegw."<br>");

						break;

						case(VBANK):  //가상계좌

						echo("승인결과코드:".$inimx->m_resultCode."<br>");
						echo("결과메시지:".$inimx->m_resultMsg."<br>");
						echo("지불수단:".$inimx->m_payMethod."<br>");
						echo("주문번호:".$inimx->m_moid."<br>");
						echo("TID:".$inimx->m_tid."<br>");
						echo("승인금액:".$inimx->m_resultprice."<br>");
						echo("요청일:".$inimx->m_pgAuthDate."<br>");
						echo("요청시각:".$inimx->m_pgAuthTime."<br>");
						echo("상점ID:".$inimx->m_mid."<br>");
						echo("구매자명:".$inimx->m_buyerName."<br>");
						echo("P_NOTI:".$inimx->m_noti."<br>");
						echo("NEXT_URL:".$inimx->m_nextUrl."<br>");
						echo("NOTI_URL:".$inimx->m_notiUrl."<br>");
						echo("가상계좌번호:".$inimx->m_vacct."<br>");
						echo("입금예정일:".$inimx->m_dtinput."<br>");
						echo("입금예정시각:".$inimx->m_tminput."<br>");
						echo("예금주:".$inimx->m_nmvacct."<br>");
						echo("은행코드:".$inimx->m_vcdbank."<br>");

						break;

						default: //문화상품권,해피머니

						echo("승인결과코드:".$inimx->m_resultCode."<br>");
						echo("결과메시지:".$inimx->m_resultMsg."<br>");
						echo("지불수단:".$inimx->m_payMethod."<br>");
						echo("주문번호:".$inimx->m_moid."<br>");
						echo("TID:".$inimx->m_tid."<br>");
						echo("승인금액:".$inimx->m_resultprice."<br>");
						echo("승인일:".$inimx->m_pgAuthDate."<br>");
						echo("승인시각:".$inimx->m_pgAuthTime."<br>");
						echo("상점ID:".$inimx->m_mid."<br>");
						echo("구매자명:".$inimx->m_buyerName."<br>");
						echo("P_NOTI:".$inimx->m_noti."<br>");
						echo("NEXT_URL:".$inimx->m_nextUrl."<br>");
						echo("NOTI_URL:".$inimx->m_notiUrl."<br>");
					}
					*/


					$m_tid						= $inimx->m_tid;
					$pg_response_code			= $inimx->m_resultCode;
					$pg_response_msg			= $inimx->m_resultMsg;
					pg_response_update();		//결제요청 응답건에 대한 업데이트


					if($inimx->m_resultCode == "00")
					{
						$result_code			= "0000";
						pg_db_update();
					}
					else
					{
						gomsg("결제실패",$main_url);
						exit;
					}

				}
				else                      // 모바일 인증 실패
				{
					echo("인증결과코드:".$inimx->status);
					echo("<br>");
					echo("인증결과메시지:".$inimx->rmesg1);
				}
			}
			else
			{
				gomsg("결제실패",$main_url);
				exit;
			}
		}

	}

}









// 결제완료 리턴 타겟팅
if( $pg_company_info == "inicis" AND $_COOKIE['happy_mobile'] != "on" )
{
	// 이니시스
	//$return_js['company']['target']		= "top.opener.opener.parent.document.";
	$return_js['company']['target']		= "top.opener.parent.document.";
	$return_js['company']['close']		= "top.opener.close();";

	$return_js['person']['target']		= "top.opener.parent.document.";
	$return_js['person']['close']		= "self.close();";

	$return_js['point']['target']		= "top.opener.parent.opener.document.";
	$return_js['point']['close']		= "top.opener.parent.close(); self.close();";
}
else
{
	// default
	$return_js['company']['target']		= "top.document.";
	$return_js['company']['close']		= "";

	$return_js['person']['target']		= "top.document.";
	$return_js['person']['close']		= "";

	if( $_COOKIE['happy_mobile'] == "on" )
	{
		// mobile
		$return_js['point']['target']	= "top.document.";
		$return_js['point']['close']	= "";
	}
	else
	{
		$return_js['point']['target']	= "top.opener.document.";
		$return_js['point']['close']	= "top.close();";
	}
}



if($pg_pay_mode_type == "company")
{
	echo "<script>".$return_js['company']['target']."location = '{$dot_url}my_pay_success.php?oid=$oid&respcode=$result_code'; ".$return_js['company']['close']."</script>";
}
else if($pg_pay_mode_type == "person" || $pg_pay_mode_type == "person_package" || $pg_pay_mode_type == "company_package")
{
	echo "<script>".$return_js['person']['target']."location = '{$dot_url}my_pay_success2.php?oid=$oid&respcode=$result_code'; ".$return_js['person']['close']."</script>";
}
else if($pg_pay_mode_type == "point")
{
	echo "<script>".$return_js['point']['target']."location = '{$dot_url}my_pay_point_success.php?oid=$oid&respcode=$result_code'; ".$return_js['point']['close']."</script>";
}

?>