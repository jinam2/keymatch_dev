<?
include ("$path/inc/lib_pay_crypt.php");

//수정불가
$pg_module_folder	= "pg_module";
$pg_module_path		= "{$path}$pg_module_folder";
$pg_company_info	= ($_COOKIE['happy_mobile'] != "on")?$HAPPY_CONFIG['pg_company']:$HAPPY_CONFIG['pg_company_mobile'];
//수정불가 END


//각 PG사별 결제창 호출전 정리
function pg_company_send($REQ_VAL)
{
	global $TPL,$skin_folder,$REQ_VAL2;
	global $HAPPY_CONFIG,$server_character,$pg_module_folder,$pg_company_info,$main_url,$site_name;

	if($_COOKIE['happy_mobile'] == "on")
	{
		if(preg_match("/dacom|daoupay|inicis/",$pg_company_info))
		{
			$TPL->define("pay_design", "$skin_folder/pay_design.html");
		}
		else
		{
			$TPL->define("pay_design", "$skin_folder/pay_design_utf.html");
		}
	}

	$REQ_VAL2							= Array();
	$REQ_VAL2							= $REQ_VAL;

	$REQ_VAL2['site_name']				= $site_name;

	$REQ_VAL2['amount_comma']			= number_format($REQ_VAL2['amount']);

	$REQ_VAL2['buyer_id']				= ($REQ_VAL2['buyer_id'] == "")?"정보없음":$REQ_VAL2['buyer_id'];
	$REQ_VAL2['buyer_name']				= ($REQ_VAL2['buyer_name'] == "")?"정보없음":$REQ_VAL2['buyer_name'];
	$REQ_VAL2['buyer_email']			= ($REQ_VAL2['buyer_email'] == "")?"00000000000":$REQ_VAL2['buyer_email'];
	$REQ_VAL2['buyer_hphone']			= ($REQ_VAL2['buyer_hphone'] == "")?"00000000000":$REQ_VAL2['buyer_hphone'];
	$REQ_VAL2['buyer_addr']				= ($REQ_VAL2['buyer_addr'] == "")?"정보없음":$REQ_VAL2['buyer_addr'];

	$REQ_VAL2['receive_name']			= ($REQ_VAL2['receive_name'] == "")?"정보없음":$REQ_VAL2['receive_name'];
	$REQ_VAL2['receive_email']			= ($REQ_VAL2['receive_email'] == "")?"00000000000":$REQ_VAL2['receive_email'];
	$REQ_VAL2['receive_hphone']			= ($REQ_VAL2['receive_hphone'] == "")?"00000000000":$REQ_VAL2['receive_hphone'];
	$REQ_VAL2['receive_addr']			= ($REQ_VAL2['receive_addr'] == "")?"정보없음":$REQ_VAL2['receive_addr'];

	$REQ_VAL2['etc_remark']				= ($REQ_VAL2['etc_remark'] == "")?"정보없음":$REQ_VAL2['etc_remark'];


	switch($REQ_VAL2['pay_type'])
	{
		case "card":					$REQ_VAL2['pay_type_text']			= "카드 결제";
										$REQ_VAL2['LGD_CUSTOM_USABLEPAY']	= "SC0010";				//U+
										$REQ_VAL2['allthegate_Job']			= "onlycard";			//allthegate
										$REQ_VAL2['allthegate_Job_mobile']	= "cardnormal";			//allthegate
										$d_folder							= ($_COOKIE['happy_mobile'] != "on")?"card":"m/card";
										$REQ_VAL2['daoupay_pay_url']		= "https://".$REQ_VAL2['daoupay_ssl_url'].".daoupay.com/".$d_folder."/DaouCardMng.jsp";		//daoupay
										$REQ_VAL2['inicis_gopaymethod']		= "Card";				//inicis
										$REQ_VAL2['inicis_paymethod']		= "wcard";				//inicis_mobile
										break;


		case "bank":					$REQ_VAL2['pay_type_text']			= "실시간 계좌이체";
										$REQ_VAL2['LGD_CUSTOM_USABLEPAY']	= "SC0030";				//U+
										$REQ_VAL2['allthegate_Job']			= "onlyiche";			//allthegate
										$REQ_VAL2['daoupay_pay_url']		= "https://".$REQ_VAL2['daoupay_ssl_url'].".daoupay.com/bank/DaouBankMng.jsp";				//daoupay
										$REQ_VAL2['inicis_gopaymethod']		= "DirectBank";			//inicis
										$REQ_VAL2['inicis_paymethod']		= "bank";				//inicis_mobile
										break;


		case "phone":					$REQ_VAL2['pay_type_text']			= "휴대폰 결제";
										$REQ_VAL2['LGD_CUSTOM_USABLEPAY']	= "SC0060";				//U+
										$REQ_VAL2['allthegate_Job']			= "onlyhp";				//allthegate
										$REQ_VAL2['allthegate_Job_mobile']	= "hp";					//allthegate
										$d_folder							= ($_COOKIE['happy_mobile'] != "on")?"2.0/mobile":"m/mobile";
										$REQ_VAL2['daoupay_pay_url']		= "https://".$REQ_VAL2['daoupay_ssl_url'].".daoupay.com/".$d_folder."/DaouMobileMng.jsp";	//daoupay
										$REQ_VAL2['inicis_gopaymethod']		= "HPP";				//inicis
										$REQ_VAL2['inicis_paymethod']		= "mobile";				//inicis_mobile
										break;
	}
	unset($d_folder);





	//U+ dacom
	$REQ_VAL2['CST_HTTP']		= ($_SERVER['SERVER_PORT']!=443)?'http':'https';
	if($HAPPY_CONFIG['pg_pay_mode'] == "test")
	{
		$REQ_VAL2['CST_PORT']		= ($_SERVER['SERVER_PORT']!=443)?":7080":":7443";
	}

	$REQ_VAL2['LGD_ENCODING']		= strtoupper($server_character);
	$REQ_VAL2['LGD_MERTKEY']		= $HAPPY_CONFIG['dacom_mertkey'];

	if($_COOKIE['happy_mobile'] == "on")
	{
		if(preg_match("/iPhone|iPod|iPad/i",$_SERVER['HTTP_USER_AGENT']))
		{
			$REQ_VAL2['LGD_KVPMISPAUTOAPPYN']		= "N";
			$REQ_VAL2['LGD_MTRANSFERAUTOAPPYN']		= "N";
		}
		else
		{
			$REQ_VAL2['LGD_KVPMISPAUTOAPPYN']		= "A";
			$REQ_VAL2['LGD_MTRANSFERAUTOAPPYN']		= "A";
		}
	}
	//U+ dacom END



	//allthegate
	if($HAPPY_CONFIG['pg_pay_mode'] == "test")
	{
		$REQ_VAL2['allthegate_demomsg']	= "alert('올더게이트 데모 결제는 카드결제만 가능합니다');";
	}

	if(preg_match("/utf/",$server_character))
	{
		$REQ_VAL2['allthegate_js']		= "AGSWallet_utf8.js";
	}
	else
	{
		$REQ_VAL2['allthegate_js']		= "AGSWallet.js";
	}
	$REQ_VAL2['AGS_HASHDATA']			= md5($REQ_VAL2["mid"] . $REQ_VAL2['oid'] . $REQ_VAL2['amount']);
	//allthegate END


	//inicis
	$REQ_VAL2['inicis_acceptmethod_hpp']	= $HAPPY_CONFIG['inicis_acceptmethod_hpp'];
	$REQ_VAL2['inicis_charset']				= ( preg_match("/utf/",$server_character) ? "UTF-8" : "EUC-KR" );
	//inicis END


	//daoupay
	if($_COOKIE['happy_mobile'] != "on")
	{
		$REQ_VAL2['daoupay_pop_up_option']	= "
												DAOUPAY = window.open('', 'DAOUPAY', 'width=570,height=535');
												DAOUPAY.focus();
												pf.target = 'DAOUPAY';
		";
	}
	else
	{
		$REQ_VAL2['daoupay_pop_up_option']	= "";
	}
	//daoupay END


	if(preg_match("/utf/i",$server_character) AND !preg_match("/allthegate/",$pg_company_info))
	{
		$character_info				= base64_decode("ZXVjLWty"); //euc-kr str
		$REQ_VAL2["site_name"]		= iconv("utf-8",$character_info,$REQ_VAL2['site_name']);
		$REQ_VAL2["pay_type_text"]	= iconv("utf-8",$character_info,$REQ_VAL2["pay_type_text"]);
		$REQ_VAL2['buyer_name']		= iconv("utf-8",$character_info,$REQ_VAL2['buyer_name']);
		$REQ_VAL2['buyer_addr']		= iconv("utf-8",$character_info,$REQ_VAL2['buyer_addr']);
		$REQ_VAL2['receive_name']	= iconv("utf-8",$character_info,$REQ_VAL2['receive_name']);
		$REQ_VAL2['receive_addr']	= iconv("utf-8",$character_info,$REQ_VAL2['receive_addr']);
		$REQ_VAL2['etc_remark']		= iconv("utf-8",$character_info,$REQ_VAL2['etc_remark']);

		$REQ_VAL2['product_title']	= iconv("utf-8",$character_info,$REQ_VAL2['product_title']);

		$REQ_VAL2['allthegate_demomsg']		= iconv("utf-8",$character_info,$REQ_VAL2['allthegate_demomsg']);

		header("Content-Type: text/html; charset=$character_info");
	}

	$REQ_VAL2['pay_design'] = &$TPL->fetch("pay_design");



	if($_COOKIE['happy_mobile'] != "on")
	{
		switch($HAPPY_CONFIG['pg_company'])
		{
			case "dacom":		$REQ_VAL2['pay_launch_script']	= "setTimeout('launchCrossPlatform()',100);";
								$req_html						= pg_req_lgdacom($REQ_VAL2);
								break;

			case "allthegate":	$req_html						= pg_req_allthegate($REQ_VAL2);
								break;

			case "daoupay":		$REQ_VAL2['pay_launch_script']	= "setTimeout('fnSubmit()',100);";
								$req_html						= pg_req_daoupay($REQ_VAL2);
								break;

			case "inicis":		$req_html						= pg_req_inicis($REQ_VAL2);
								break;
		}
	}
	else
	{
		switch($HAPPY_CONFIG['pg_company_mobile'])
		{
			case "dacom":		$REQ_VAL2['pay_launch_script']	= "function pay_launch(){launchCrossPlatform();}";
								$req_html						= pg_req_lgdacom($REQ_VAL2);
								break;

			case "allthegate":	$req_html						= pg_req_allthegate_mobile($REQ_VAL2);
								break;

			case "daoupay":		$REQ_VAL2['pay_launch_script']	= "function pay_launch(){fnSubmit();}";
								$req_html						= pg_req_daoupay($REQ_VAL2);
								break;

			case "inicis":		$req_html						= pg_req_inicis_mobile($REQ_VAL2);
								break;
		}
	}

	return $req_html;
}










//관리자 결제환경설정
function pg_lgdacom_conf() {

global $HAPPY_CONFIG,$server_character,$pg_module_path;

if($HAPPY_CONFIG['pg_pay_mode'] == "test")
{
	$HAPPY_CONFIG['pg_mid']		= "happycgi";
}
$output_UTF8	= (preg_match("/utf/i",$server_character))?1:0;
$dacom_mertkey	= ($_POST['dacom_mertkey'] != "")?$_POST['dacom_mertkey']:$HAPPY_CONFIG['dacom_mertkey'];


$file	= "$pg_module_path/lgdacom/conf/mall.conf";
$noti	= "

server_id = 01


timeout = 60


log_level = 1


verify_cert = 1


verify_host = 1


report_error = 1


output_UTF8 = $output_UTF8


auto_rollback = 0



log_dir = $pg_module_path/lgdacom/log









t{$HAPPY_CONFIG[pg_mid]} = $dacom_mertkey
$HAPPY_CONFIG[pg_mid] = $dacom_mertkey


";

$fp = fopen($file, "w+");
ob_start();
print_r($noti);
$msg = ob_get_contents();
ob_end_clean();
fwrite($fp, $msg);
fclose($fp);

}



##############################결제인증요청##############################
function pg_req_lgdacom($REQ_VAL)
{
	global $HAPPY_CONFIG,$pg_module_folder,$pg_module_path,$main_url;


	/*
     * [결제 인증요청 페이지(STEP2-1)]
     *
     * 샘플페이지에서는 기본 파라미터만 예시되어 있으며, 별도로 필요하신 파라미터는 연동메뉴얼을 참고하시어 추가 하시기 바랍니다.
     */

    /*
     * 1. 기본결제 인증요청 정보 변경
     *
     * 기본정보를 변경하여 주시기 바랍니다.(파라미터 전달시 POST를 사용하세요)
     */


    $CST_PLATFORM               = $REQ_VAL["CST_PLATFORM"];							//LG유플러스 결제 서비스 선택(test:테스트, service:서비스)
    $CST_MID                    = $REQ_VAL["mid"];									//상점아이디(LG유플러스으로 부터 발급받으신 상점아이디를 입력하세요)
																					//테스트 아이디는 't'를 반드시 제외하고 입력하세요.
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;		//상점아이디(자동생성)
    $LGD_OID                    = $REQ_VAL["oid"];									//주문번호(상점정의 유니크한 주문번호를 입력하세요)
    $LGD_AMOUNT                 = $REQ_VAL["amount"];								//결제금액("," 를 제외한 결제금액을 입력하세요)
    $LGD_BUYER                  = substr($REQ_VAL["buyer_name"],0,10);				//구매자명
    $LGD_PRODUCTINFO            = $REQ_VAL["product_title"];						//상품명
    $LGD_BUYEREMAIL             = $REQ_VAL["buyer_email"];							//구매자 이메일
    $LGD_TIMESTAMP              = date(YmdHms);										//타임스탬프
    $LGD_CUSTOM_SKIN            = "red";											//상점정의 결제창 스킨 (red, purple, yellow)
    $LGD_CUSTOM_USABLEPAY       = $REQ_VAL["LGD_CUSTOM_USABLEPAY"];					//상점정의 초기 결제 수단.
    $LGD_WINDOW_VER             = "2.5";											//결제창 버젼정보
    $LGD_MERTKEY				= $REQ_VAL['LGD_MERTKEY'];							//상점MertKey(mertkey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실수 있습니다)
	$configPath 				= "$pg_module_path/lgdacom"; 						//LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.
    $LGD_BUYERID                = substr($REQ_VAL["buyer_id"],0,15);				//구매자 아이디
    $LGD_BUYERIP                = $_SERVER['REMOTE_ADDR'];							//구매자IP

    /*
     * 가상계좌(무통장) 결제 연동을 하시는 경우 아래 LGD_CASNOTEURL 을 설정하여 주시기 바랍니다.
     */
    $LGD_CASNOTEURL		= "http://상점URL/cas_noteurl.php";

    /*
     * LGD_RETURNURL 을 설정하여 주시기 바랍니다. 반드시 현재 페이지와 동일한 프로트콜 및  호스트이어야 합니다. 아래 부분을 반드시 수정하십시요.
     */
    //$LGD_RETURNURL		= "http://상점URL/returnurl.jsp";							// FOR MANUAL

	$main_url2 = "http://".$_SERVER['HTTP_HOST'];
global $apache_ssl_all_use;
if ($apache_ssl_all_use != "") { $main_url2 = "https://".$_SERVER['HTTP_HOST']; }
else { $main_url2 = "http://".$_SERVER['HTTP_HOST']; }
	if($_COOKIE['happy_mobile'] != "on")
	{
		$CST_WINDOW_TYPE				= "popup";
		$LGD_VERSION					= "PHP_XPay_2.5";
		$LGD_CUSTOM_SWITCHINGTYPE		= "";
		$LGD_RETURNURL					= "$main_url2/$pg_module_folder/lgdacom/returnurl.php";			// FOR MANUAL
	}
	else
	{
		$CST_WINDOW_TYPE				= "submit";
		$LGD_VERSION					= "PHP_SmartXPay_1.0";
		$LGD_CUSTOM_SWITCHINGTYPE		= "SUBMIT";
		$LGD_RETURNURL					= "$main_url2/$pg_module_folder/lgdacom/returnurl_mobile.php";	// FOR MANUAL
	}


    /*
     *************************************************
     * 2. MD5 해쉬암호화 (수정하지 마세요) - BEGIN
     *
     * MD5 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
     *************************************************
     *
     * 해쉬 암호화 적용( LGD_MID + LGD_OID + LGD_AMOUNT + LGD_TIMESTAMP + LGD_MERTKEY )
     * LGD_MID          : 상점아이디
     * LGD_OID          : 주문번호
     * LGD_AMOUNT       : 금액
     * LGD_TIMESTAMP    : 타임스탬프
     * LGD_MERTKEY      : 상점MertKey (mertkey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실수 있습니다)
     *
     * MD5 해쉬데이터 암호화 검증을 위해
     * LG유플러스에서 발급한 상점키(MertKey)를 환경설정 파일(lgdacom/conf/mall.conf)에 반드시 입력하여 주시기 바랍니다.
     */
    require_once("$pg_module_path/lgdacom/XPayClient.php");
    $xpay = &new XPayClient($configPath, $CST_PLATFORM);
   	$xpay->Init_TX($LGD_MID);
    $LGD_HASHDATA = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_TIMESTAMP.$xpay->config[$LGD_MID]);
    $LGD_CUSTOM_PROCESSTYPE = "TWOTR";
    /*
     *************************************************
     * 2. MD5 해쉬암호화 (수정하지 마세요) - END
     *************************************************
     */




   /*Return URL에서 인증 결과 수신 시 셋팅될 파라미터 입니다.*/
	$LGD_RESPCODE = "";
	$LGD_RESPMSG = "";
	$LGD_PAYKEY = "";





	//모바일 result_mobile.php 때문에 추가
	//$LGD_KVPMISPNOTEURL						= "http://상점URL/note_url.php";
    //$LGD_KVPMISPWAPURL						= "http://상점URL/mispwapurl.php?LGD_OID=".$LGD_OID;   //ISP 카드 결제시, URL 대신 앱명 입력시, 앱호출함
    //$LGD_KVPMISPCANCELURL					= "http://상점URL/cancel_url.php";


	$payReqMap['CST_PLATFORM']				= $CST_PLATFORM;					// 테스트, 서비스 구분
    $payReqMap['CST_WINDOW_TYPE']			= $CST_WINDOW_TYPE;					// 수정불가
    $payReqMap['CST_MID']					= $CST_MID;							// 상점아이디
    $payReqMap['LGD_MID']					= $LGD_MID;							// 상점아이디
    $payReqMap['LGD_OID']					= $LGD_OID;							// 주문번호
    $payReqMap['LGD_BUYER']					= $LGD_BUYER;            			// 구매자
    $payReqMap['LGD_PRODUCTINFO']			= $LGD_PRODUCTINFO;     			// 상품정보
    $payReqMap['LGD_AMOUNT']				= $LGD_AMOUNT;						// 결제금액
    $payReqMap['LGD_BUYEREMAIL']			= $LGD_BUYEREMAIL;					// 구매자 이메일
    $payReqMap['LGD_CUSTOM_SKIN']			= $LGD_CUSTOM_SKIN;					// 결제창 SKIN
    $payReqMap['LGD_CUSTOM_PROCESSTYPE']	= $LGD_CUSTOM_PROCESSTYPE;			// 트랜잭션 처리방식
    $payReqMap['LGD_TIMESTAMP']				= $LGD_TIMESTAMP;					// 타임스탬프
    $payReqMap['LGD_HASHDATA']				= $LGD_HASHDATA;					// MD5 해쉬암호값
    $payReqMap['LGD_RETURNURL']   			= $LGD_RETURNURL;      				// 응답수신페이지
    $payReqMap['LGD_VERSION']         		= $LGD_VERSION;						// 버전정보 (삭제하지 마세요)
    $payReqMap['LGD_CUSTOM_FIRSTPAY']  		= $LGD_CUSTOM_FIRSTPAY;				// 디폴트 결제수단
	$payReqMap['LGD_CUSTOM_SWITCHINGTYPE']  = $LGD_CUSTOM_SWITCHINGTYPE;		// 신용카드 카드사 인증 페이지 연동 방식

	$payReqMap['LGD_CUSTOM_ROLLBACK']		= "";			   	   				// 비동기 ISP에서 트랜잭션 처리여부
    $payReqMap['LGD_KVPMISPNOTEURL']		= $LGD_KVPMISPNOTEURL;				// 비동기 ISP(ex. 안드로이드) 승인결과를 받는 URL
    $payReqMap['LGD_KVPMISPWAPURL']			= $LGD_KVPMISPWAPURL;				// 비동기 ISP(ex. 안드로이드) 승인완료후 사용자에게 보여지는 승인완료 URL
    $payReqMap['LGD_KVPMISPCANCELURL']		= $LGD_KVPMISPCANCELURL;			// ISP 앱에서 취소시 사용자에게 보여지는 취소 URL




	// 안드로이드 에서 신용카드 적용  ISP(국민/BC)결제에만 적용 (선택)
    $payReqMap['LGD_KVPMISPAUTOAPPYN']		= $REQ_VAL['LGD_KVPMISPAUTOAPPYN'];		//동기 = A
    $payReqMap['LGD_MTRANSFERAUTOAPPYN']	= $REQ_VAL['LGD_MTRANSFERAUTOAPPYN'];	//동기 = A
    // Y: 안드로이드에서 ISP신용카드 결제시, 고객사에서 'App To App' 방식으로 국민, BC카드사에서 받은 결제 승인을 받고 고객사의 앱을 실행하고자 할때 사용

    // 가상계좌(무통장) 결제연동을 하시는 경우  할당/입금 결과를 통보받기 위해 반드시 LGD_CASNOTEURL 정보를 LG 유플러스에 전송해야 합니다 .
    $payReqMap['LGD_CASNOTEURL']		= $LGD_CASNOTEURL;               // 가상계좌 NOTEURL

    //Return URL에서 인증 결과 수신 시 셋팅될 파라미터 입니다.*/
    $payReqMap['LGD_RESPCODE']          = "";
    $payReqMap['LGD_RESPMSG']           = "";
    $payReqMap['LGD_PAYKEY']            = "";

	$payReqMap['pay_type_option']       = $REQ_VAL['pay_type_option'];
    $_SESSION['PAYREQ_MAP']				= $payReqMap;
	//모바일 result_mobile.php 때문에 추가 END






	$req_result	= "
					<html>
						<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
						<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
						<title>LG U+ eCredit</title>

						<script type='text/javascript'>

						/*
						* iframe으로 결제창을 호출하시기를 원하시면 iframe으로 설정 (변수명 수정 불가)
						*/
							var LGD_window_type = '".$CST_WINDOW_TYPE."';
						/*
						* 수정불가
						*/
						function launchCrossPlatform(){
							  lgdwin = open_paymentwindow(document.getElementById('LGD_PAYINFO'), '".$CST_PLATFORM."', LGD_window_type);
						}
						/*
						* FORM 명만  수정 가능
						*/
						function getFormObject() {
								return document.getElementById('LGD_PAYINFO');
						}

						/*
						 * 인증결과 처리
						 */
						function payment_return(LGD_RESPCODE, LGD_RESPMSG, LGD_PAYKEY) {
							if (LGD_RESPCODE == '0000') {
								/*
								* 인증성공 화면 처리
								*/
								//alert('결제요청 합니다...');
								document.getElementById('LGD_RESPCODE').value = LGD_RESPCODE;
								document.getElementById('LGD_RESPMSG').value = LGD_RESPMSG;
								document.getElementById('LGD_PAYKEY').value = LGD_PAYKEY;
								//alert('LGD_PAYKEY	='+LGD_PAYKEY);
								document.getElementById('LGD_PAYINFO').action = './$pg_module_folder/pg_db_update.php';
								document.getElementById('LGD_PAYINFO').target = '_self';
								document.getElementById('LGD_PAYINFO').submit();
							} else {
								alert('인증실패 : ' + LGD_RESPMSG);
								/*
								* 인증실패 화면 처리
								*/
							}
						}

						//-->
						</script>

						</head>
						<body>


						$REQ_VAL[pay_design]


						<form method='post' name ='LGD_PAYINFO' id='LGD_PAYINFO' action='{$pg_module_folder}/pg_db_update.php'>

						<br>
						<input type='hidden' name='CST_PLATFORM'                id='CST_PLATFORM'		value='$CST_PLATFORM'>						<!-- 테스트, 서비스 구분 -->
						<input type='hidden' name='CST_MID'                     id='CST_MID'			value='$CST_MID'>							<!-- 상점아이디 -->
						<input type='hidden' name='CST_WINDOW_TYPE'             id='CST_WINDOW_TYPE'	value='$CST_WINDOW_TYPE'>					<!-- 윈도우 타입 -->
						<input type='hidden' name='LGD_MID'                     id='LGD_MID'			value='$LGD_MID'>							<!-- 상점아이디 -->
						<input type='hidden' name='LGD_OID'                     id='LGD_OID'			value='$LGD_OID'>							<!-- 주문번호 -->
						<input type='hidden' name='LGD_BUYER'                   id='LGD_BUYER'			value='$LGD_BUYER'>							<!-- 구매자 -->
						<input type='hidden' name='LGD_PRODUCTINFO'             id='LGD_PRODUCTINFO'	value='$LGD_PRODUCTINFO'>					<!-- 상품정보 -->
						<input type='hidden' name='LGD_AMOUNT'                  id='LGD_AMOUNT'			value='$LGD_AMOUNT'>						<!-- 결제금액 -->
						<input type='hidden' name='LGD_BUYEREMAIL'              id='LGD_BUYEREMAIL'		value='$LGD_BUYEREMAIL'>					<!-- 구매자 이메일 -->
						<input type='hidden' name='LGD_CUSTOM_SKIN'             id='LGD_CUSTOM_SKIN'   	value='$LGD_CUSTOM_SKIN'>					<!-- 결제창 SKIN -->
						<input type='hidden' name='LGD_WINDOW_VER'         	    id='LGD_WINDOW_VER'	    value='$LGD_WINDOW_VER'>					<!-- 결제창버전정보 (삭제하지 마세요) -->
						<input type='hidden' name='LGD_CUSTOM_PROCESSTYPE'      id='LGD_CUSTOM_PROCESSTYPE'		value='$LGD_CUSTOM_PROCESSTYPE'>	<!-- 트랜잭션 처리방식 -->
						<input type='hidden' name='LGD_TIMESTAMP'               id='LGD_TIMESTAMP'		value='$LGD_TIMESTAMP'>						<!-- 타임스탬프 -->
						<input type='hidden' name='LGD_HASHDATA'                id='LGD_HASHDATA'		value='$LGD_HASHDATA'>						<!-- MD5 해쉬암호값 -->
						<input type='hidden' name='LGD_PAYKEY'                  id='LGD_PAYKEY'>													<!-- LG유플러스 PAYKEY(인증후 자동셋팅)-->
						<input type='hidden' name='LGD_VERSION'         		id='LGD_VERSION'		value='$LGD_VERSION'>						<!-- 버전정보 (삭제하지 마세요) -->
						<input type='hidden' name='LGD_BUYERIP'                 id='LGD_BUYERIP'		value='$LGD_BUYERIP'>           			<!-- 구매자IP -->
						<input type='hidden' name='LGD_BUYERID'                 id='LGD_BUYERID'		value='$LGD_BUYERID'>           			<!-- 구매자ID -->

						<!-- 가상계좌(무통장) 결제연동을 하시는 경우  할당/입금 결과를 통보받기 위해 반드시 LGD_CASNOTEURL 정보를 LG 유플러스에 전송해야 합니다 . -->
						<input type='hidden' name='LGD_CASNOTEURL'          	id='LGD_CASNOTEURL'		value='$LGD_CASNOTEURL'>					<!-- 가상계좌 NOTEURL -->

						<!--LGD_RETURNURL  => 응답 수신 페이지 . -->
						<input type='hidden' name='LGD_RETURNURL'          		id='LGD_RETURNURL'		value='$LGD_RETURNURL'>						<!-- 응답 수신 페이지 -->
						<input type='hidden' name='LGD_CUSTOM_USABLEPAY'        id='LGD_CUSTOM_USABLEPAY'	value='$LGD_CUSTOM_USABLEPAY'>			<!-- 디폴트 결제수단 -->
						<input type='hidden' name='LGD_CUSTOM_SWITCHINGTYPE'    id='LGD_CUSTOM_SWITCHINGTYPE'	value='$LGD_CUSTOM_SWITCHINGTYPE'>	<!-- 신용카드 카드사 인증 페이지 연동 방식 -->


						<input type='hidden' name='LGD_RESPCODE'          	id='LGD_RESPCODE'		value='$LGD_RESPCODE'>							<!-- 응답 수신 페이지 -->
						<input type='hidden' name='LGD_RESPMSG'          	id='LGD_RESPMSG'		value='$LGD_RESPMSG'>							<!-- 디폴트 결제수단 -->

						<input type='hidden' name='LGD_ENCODING'          	id='LGD_ENCODING'		value='EUC-KR'>					<!-- 결제창호출문자 인코딩방식 -->

						<input type='hidden' name='pay_type_option'         id='pay_type_option'	value='$REQ_VAL[pay_type_option]'>				<!-- 결제타입 -->


						<!-- 모바일 추가값 -->
						<input type='hidden' name='LGD_KVPMISPNOTEURL'      id='LGD_KVPMISPNOTEURL'		value='$LGD_KVPMISPNOTEURL'>				<!-- 비동기방식이용 -->
						<input type='hidden' name='LGD_KVPMISPWAPURL'       id='LGD_KVPMISPWAPURL'		value='$LGD_KVPMISPWAPURL'>					<!-- 비동기방식이용 -->
						<input type='hidden' name='LGD_KVPMISPCANCELURL'    id='LGD_KVPMISPCANCELURL'	value='$LGD_KVPMISPCANCELURL'>				<!-- 비동기방식이용 -->

						<input type='hidden' name='LGD_MTRANSFERNOTEURL'    id='LGD_MTRANSFERNOTEURL'	value=''>									<!-- 비동기방식이용 -->
						<input type='hidden' name='LGD_MTRANSFERWAPURL'     id='LGD_MTRANSFERWAPURL'	value=''>									<!-- 비동기방식이용 -->
						<input type='hidden' name='LGD_MTRANSFERCANCELURL'  id='LGD_MTRANSFERCANCELURL'	value=''>									<!-- 비동기방식이용 -->

						<input type='hidden' name='LGD_KVPMISPAUTOAPPYN'    id='LGD_KVPMISPAUTOAPPYN'	value='$REQ_VAL[LGD_KVPMISPAUTOAPPYN]'>		<!-- 동기방식은 A -->
						<input type='hidden' name='LGD_MTRANSFERAUTOAPPYN'  id='LGD_MTRANSFERAUTOAPPYN'	value='$REQ_VAL[LGD_MTRANSFERAUTOAPPYN]'>	<!-- 동기방식은 A -->
						<!-- 모바일 추가값 END -->


						</form>
						</body>

						<script language='javascript' src='".$REQ_VAL['CST_HTTP']."://xpay.uplus.co.kr".$REQ_VAL['CST_PORT']."/xpay/js/xpay_crossplatform.js' type='text/javascript'></script>

						<script>
							$REQ_VAL[pay_launch_script]
						</script>
						</html>


	";

	echo $req_result;
	exit;
}




function pg_req_allthegate($REQ_VAL)
{
	global $HAPPY_CONFIG,$pg_module_folder,$pg_module_path,$site_name,$main_url;


	$_SESSION['ALLTHEGATE_AMOUNT']			= $REQ_VAL["amount"];

	$req_result = "
					<html>
					<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<title>allthegate</title>
					<script language=javascript src='http://www.allthegate.com/plugin/$REQ_VAL[allthegate_js]'></script>
					<!-- ※ UTF8 언어 형식으로 페이지 제작시 아래 경로의 js 파일을 사용할 것!! -->
					<!-- script language=javascript src='http://www.allthegate.com/plugin/AGSWallet_utf8.js'></script -->
					<!-- Euc-kr 이 아닌 다른 charset 을 이용할 경우에는 AGS_pay_ing(결제처리페이지) 상단의
						[ AGS_pay.html 로 부터 넘겨받을 데이터파라미터 ] 선언부에서 파라미터 값들을 euc-kr로
						인코딩 변환을 해주시기 바랍니다.
					<!-- ※ SSL 보안을 이용할 경우 아래 경로의 js 파일을 사용할 것!! -->
					<!-- script language=javascript src='https://www.allthegate.com/plugin/AGSWallet_ssl.js'></script -->
					<script language=javascript>
					<!--
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// 올더게이트 플러그인 설치를 확인합니다.
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////

					StartSmartUpdate();

					function Pay(form){
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// MakePayMessage() 가 호출되면 올더게이트 플러그인이 화면에 나타나며 Hidden 필드
						// 에 리턴값들이 채워지게 됩니다.
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////

						if(form.Flag.value == 'enable'){
							//////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// 입력된 데이타의 유효성을 검사합니다.
							//////////////////////////////////////////////////////////////////////////////////////////////////////////////

							if(Check_Common(form) == true){
								//////////////////////////////////////////////////////////////////////////////////////////////////////////////
								// 올더게이트 플러그인 설치가 올바르게 되었는지 확인합니다.
								//////////////////////////////////////////////////////////////////////////////////////////////////////////////

								if(document.AGSPay == null || document.AGSPay.object == null){
									alert('plugin install.');
								}else{
									//////////////////////////////////////////////////////////////////////////////////////////////////////////////
									// 올더게이트 플러그인 설정값을 동적으로 적용하기 JavaScript 코드를 사용하고 있습니다.
									// 상점설정에 맞게 JavaScript 코드를 수정하여 사용하십시오.
									//
									// [1] 일반/무이자 결제여부
									// [2] 일반결제시 할부개월수
									// [3] 무이자결제시 할부개월수 설정
									// [4] 인증여부
									//////////////////////////////////////////////////////////////////////////////////////////////////////////////

									//////////////////////////////////////////////////////////////////////////////////////////////////////////////
									// [1] 일반/무이자 결제여부를 설정합니다.
									//
									// 할부판매의 경우 구매자가 이자수수료를 부담하는 것이 기본입니다. 그러나,
									// 상점과 올더게이트간의 별도 계약을 통해서 할부이자를 상점측에서 부담할 수 있습니다.
									// 이경우 구매자는 무이자 할부거래가 가능합니다.
									//
									// 예제)
									// 	(1) 일반결제로 사용할 경우
									// 	form.DeviId.value = '9000400001';
									//
									// 	(2) 무이자결제로 사용할 경우
									// 	form.DeviId.value = '9000400002';
									//
									// 	(3) 만약 결제 금액이 100,000원 미만일 경우 일반할부로 100,000원 이상일 경우 무이자할부로 사용할 경우
									// 	if(parseInt(form.Amt.value) < 100000)
									//		form.DeviId.value = '9000400001';
									// 	else
									//		form.DeviId.value = '9000400002';
									//////////////////////////////////////////////////////////////////////////////////////////////////////////////

									form.DeviId.value = '9000400001';

									//////////////////////////////////////////////////////////////////////////////////////////////////////////////
									// [2] 일반 할부기간을 설정합니다.
									//
									// 일반 할부기간은 2 ~ 12개월까지 가능합니다.
									// 0:일시불, 2:2개월, 3:3개월, ... , 12:12개월
									//
									// 예제)
									// 	(1) 할부기간을 일시불만 가능하도록 사용할 경우
									// 	form.QuotaInf.value = '0';
									//
									// 	(2) 할부기간을 일시불 ~ 12개월까지 사용할 경우
									//		form.QuotaInf.value = '0:3:4:5:6:7:8:9:10:11:12';
									//
									// 	(3) 결제금액이 일정범위안에 있을 경우에만 할부가 가능하게 할 경우
									// 	if((parseInt(form.Amt.value) >= 100000) || (parseInt(form.Amt.value) <= 200000))
									// 		form.QuotaInf.value = '0:2:3:4:5:6:7:8:9:10:11:12';
									// 	else
									// 		form.QuotaInf.value = '0';
									//////////////////////////////////////////////////////////////////////////////////////////////////////////////

									//결제금액이 5만원 미만건을 할부결제로 요청할경우 결제실패
									if(parseInt(form.Amt.value) < 50000)
										form.QuotaInf.value = '0';
									else
										form.QuotaInf.value = '0:2:3:4:5:6:7:8:9:10:11:12';

									////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									// [3] 무이자 할부기간을 설정합니다.
									// (일반결제인 경우에는 본 설정은 적용되지 않습니다.)
									//
									// 무이자 할부기간은 2 ~ 12개월까지 가능하며,
									// 올더게이트에서 제한한 할부 개월수까지만 설정해야 합니다.
									//
									// 100:BC
									// 200:국민
									// 201:NH
									// 300:외환
									// 310:하나SK
									// 400:삼성
									// 500:신한
									// 800:현대
									// 900:롯데
									//
									// 예제)
									// 	(1) 모든 할부거래를 무이자로 하고 싶을때에는 ALL로 설정
									// 	form.NointInf.value = 'ALL';
									//
									// 	(2) 국민카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
									// 	form.NointInf.value = '200-2:3:4:5:6';
									//
									// 	(3) 외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
									// 	form.NointInf.value = '300-2:3:4:5:6';
									//
									// 	(4) 국민,외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
									// 	form.NointInf.value = '200-2:3:4:5:6,300-2:3:4:5:6';
									//
									//	(5) 무이자 할부기간 설정을 하지 않을 경우에는 NONE로 설정
									//	form.NointInf.value = 'NONE';
									//
									//	(6) 전카드사 특정개월수만 무이자를 하고 싶은경우(2:3:6개월)
									//	form.NointInf.value = '100-2:3:6,200-2:3:6,201-2:3:6,300-2:3:6,310-2:3:6,400-2:3:6,500-2:3:6,800-2:3:6,900-2:3:6';
									//
									////////////////////////////////////////////////////////////////////////////////////////////////////////////////

									if(form.DeviId.value == '9000400002')
										form.NointInf.value = 'ALL';

									if(MakePayMessage(form) == true){
										Disable_Flag(form);

										//var openwin = window.open('AGS_progress.html','popup','width=300,height=160'); //'지불처리중' 이라는 팝업창연결 부분

										form.submit();
									}else{
										//alert('pay fail.');// 취소시 이동페이지 설정부분
									}
								}
							}
						}
					}

					function Enable_Flag(form){
							form.Flag.value = 'enable'
					}

					function Disable_Flag(form){
							form.Flag.value = 'disable'
					}

					function Check_Common(form){
						if(form.StoreId.value == ''){
							alert('상점아이디를 입력하십시오.');
							return false;
						}
						else if(form.StoreNm.value == ''){
							alert('상점명을 입력하십시오.');
							return false;
						}
						else if(form.OrdNo.value == ''){
							alert('주문번호를 입력하십시오.');
							return false;
						}
						else if(form.ProdNm.value == ''){
							alert('상품명을 입력하십시오.');
							return false;
						}
						else if(form.Amt.value == ''){
							alert('금액을 입력하십시오.');
							return false;
						}
						else if(form.MallUrl.value == ''){
							alert('상점URL을 입력하십시오.');
							return false;
						}
						return true;
					}

					-->
					</script>
					</head>
					<!-- 주의) onload 이벤트에서 아래와 같이 javascript 함수를 호출하지 마십시오. -->
					<!-- onload='javascript:Enable_Flag(frmAGS_pay);Pay(frmAGS_pay);' -->
					<body topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0 onload='javascript:Enable_Flag(frmAGS_pay);'>
					<form name=frmAGS_pay method=post action={$pg_module_folder}/pg_db_update.php>

						<!--
						1) 본 지불요청 페이지를 상점에 맞게 적절하게 수정하여 사용하십시오.<br>
						2) 본 페이지에서는 올더게이트 플러그인을 다운로드하여 설치하도록 되어 있습니다. 다운로드후에  <font color=#006C6C>보안경고창이 뜨면 확인 버튼('예')을 선택하여</font> 플러그인을 설치해 주십시오. 만약 설치에 실패하였을 경우 수동으로 <a href='http://www.allthegate.com/plugin/AGSPayPluginV10.exe'><font color=#006C6C>다운로드</font></a>하여 설치해 주십시오.<br>
						3) 지불요청을 위해 필요한 정보를 모두 입력후 '지불요청'버튼을 클릭하시면 올더게이트 플러그인을 실행합니다.<br>
						4) 신용카드만 사용시 꼭 <font color=#006C6C>결제지불방법</font>을 <font color=#006C6C><b>신용카드(전용)</b></font>으로 설정해 주십시오.<br>
						5) DB 작업을 하실 경우 <font color=#006C6C>결제성공여부(rSuccYn)</font>을 확인후에 작업하여 주십시오.<br>
						6) 핸드폰 결제 사용시 올더게이트에서 발급받은[핸드폰결제아이디,비밀번호,상품코드,상품타입]을 입력하여 주십시오.<br>
						7) 데이터 입력시 <font color=#006C6C>'|'</font>는 올더게이트에서 구분자로 사용하는 문자이므로 입력하지 말아 주십시오.
						-->


						<!-- 계좌이체,핸드폰결제를 사용하지 않는 상점은 지불방법을 꼭 신용카드(전용)으로 설정하시기 바랍니다. -->
						<!-- 신용카드만 사용하도록 연동 <input type=hidden name=Job value='onlycard'> -->
						<!-- 계좌이체만 사용하도록 연동 <input type=hidden name=Job value='onlyiche'> -->
						<!-- 핸드폰결제만 사용하도록 연동 <input type=hidden name=Job value='onlyhp'> -->
						<input type=hidden name=Job value='$REQ_VAL[allthegate_Job]'>								<!--[필수]지불방법-->
						<input type=hidden name=TempJob maxlength=20 value=''>										<!--지불방법 직접입력 예) card:iche-->
						<input type=hidden name=StoreId maxlength=20 value='$REQ_VAL[mid]'>							<!--[필수]상점아이디-->
						<input type=hidden name=OrdNo maxlength=40 value='$REQ_VAL[oid]'>							<!--[필수]주문번호 (40)-->
						<input type=hidden name=Amt maxlength=12 value='$REQ_VAL[amount]'>							<!--[필수]금액 (12) 콤마(,)입력불가-->
						<input type=hidden name=StoreNm value='$REQ_VAL[site_name]'>								<!--[필수]상점명 (50)-->
						<input type=hidden name=ProdNm maxlength=300 value='$REQ_VAL[product_title]'>				<!--[필수]상품명 (300)-->
						<input type=hidden name=MallUrl value='$main_url'>											<!--[필수]상점URL (50) http://www.allthegate.com-->
						<input type=hidden name=UserEmail maxlength=50 value='$REQ_VAL[buyer_email]'>				<!--주문자이메일 (50) test@test.com-->

						<!-- 결제창 좌측상단에 상점의 로고이미지(85 * 38)를 표시할 수 있습니다. -->
						<!-- 잘못된 값을 입력하거나 미입력시 이지스올더게이트의 로고가 표시됩니다. -->
						<input type=hidden name=ags_logoimg_url maxlength=200 value='http://www.allthegate.com/hyosung/images/aegis_logo.gif'>	<!--상점로고이미지 URL-->

						<!-- 제목은 1컨텐츠당 5자 이내이며, 상점명;상품명;결제금액;제공기간; 순으로 입력해 주셔야 합니다. -->
						<!-- 입력 예)업체명;판매상품;계산금액;제공기간; -->
						<input type=hidden name=SubjectData value=''>	<!--결제창제목입력 예)업체명;판매상품;계산금액;2012.09.01 ~ 2012.09.30;-->

						<!-- [신용카드, 핸드폰] 결제와 [현금영수증자동발행]을 사용하시는 경우에 반드시 입력해 주시기 바랍니다. -->
						<input type=hidden name=UserId maxlength=20 value='$REQ_VAL[buyer_id]'>						<!--회원아이디 (20)-->


						<!--+ 카드 & 가상계좌 결제 사용 변수-->
						<input type=hidden name=OrdNm maxlength=40 value='$REQ_VAL[buyer_name]'>					<!--주문자명 (40) 홍길동-->
						<input type=hidden name=OrdPhone maxlength=21 value='$REQ_VAL[buyer_hphone]'>				<!--주문자연락처 (21) 02-111-1111-->
						<input type=hidden name=OrdAddr maxlength=100 value='$REQ_VAL[buyer_addr]'>					<!--주문자주소 (100) 서울시 강남구 청담동 가상계좌추가 -->
						<input type=hidden name=RcpNm maxlength=40 value='$REQ_VAL[receive_name]'>					<!--수신자명 (40) 김길동-->
						<input type=hidden name=RcpPhone maxlength=21 value='$REQ_VAL[receive_hphone]'>				<!--수신자연락처 (21) 02-111-1111-->
						<input type=hidden name=DlvAddr maxlength=100 value='$REQ_VAL[receive_addr]'>				<!--배송지주소 (100) 서울시 강남구 청담동-->
						<input type=hidden name=Remark maxlength=350 value='$REQ_VAL[etc_remark]'>					<!--기타요구사항 (350) 오후에 배송요망-->
						<input type=hidden name=CardSelect value=''>												<!--카드사선택 예)  BC, 국민을 사용하고자 하는 경우 ☞ 100:200-->

						<!--+ 핸드폰 결제 사용 변수-->
						<input type=hidden name=HP_ID maxlength=10 value='$HAPPY_CONFIG[allthegate_hp_id]'>			<!--CP아이디 (10)-->
						<input type=hidden name=HP_PWD maxlength=10 value='$HAPPY_CONFIG[allthegate_hp_pwd]'>		<!--CP비밀번호 (10)-->
						<input type=hidden name=HP_SUBID maxlength=10 value='$HAPPY_CONFIG[allthegate_hp_subid]'>	<!--SUB-CP아이디 (10)-->
						<input type=hidden name=ProdCode maxlength=10 value='$HAPPY_CONFIG[allthegate_prodcode]'>	<!--상품코드 (10)-->

						<!-- 상품종류를 핸드폰 결제 실거래 전환후에는 발급받으신 상품종류로 변경하여 주시기 바랍니다. -->
						<!-- 판매하는 상품이 디지털(컨텐츠)일 경우 = 1, 실물(상품)일 경우 = 2 -->
						<input type=hidden name=HP_UNITType value='$HAPPY_CONFIG[allthegate_HP_UNITType]'>


						<!--+ 가상계좌 결제 사용 변수-->

						<!-- 가상계좌 결제에서 입/출금 통보를 위한 필수 입력 사항 입니다. -->
						<!-- 페이지주소는 도메인주소를 제외한 '/'이후 주소를 적어주시면 됩니다. -->
						<input type=hidden name=MallPage value=''>	<!--통보페이지 (100) 예) /mall/AGS_VirAcctResult.php-->

						<!-- 가상계좌 결제에서 입금가능한 기한을 지정하는 기능입니다. -->
						<!-- 발급일자로부터 최대 15일 이내로만 설정하셔야 합니다. -->
						<!-- 값을 입력하지 않을 경우, 자동으로 발급일자로부터 5일 이후로 설정됩니다. -->
						<input type=hidden name=VIRTUAL_DEPODT value=''>	<!--가상계좌 입금예정일 (8) 예) 20100120-->


						<input type=hidden name=pay_type_option value='$REQ_VAL[pay_type_option]'>





						<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->

						<!-- 각 결제 공통 사용 변수 -->
						<input type=hidden name=Flag value=''>				<!-- 스크립트결제사용구분플래그 -->
						<input type=hidden name=AuthTy value=''>			<!-- 결제형태 -->
						<input type=hidden name=SubTy value=''>				<!-- 서브결제형태 -->
						<input type=hidden name=AGS_HASHDATA value='<?=$REQ_VAL[AGS_HASHDATA]?>'>	<!-- 암호화 HASHDATA -->

						<!-- 신용카드 결제 사용 변수 -->
						<input type=hidden name=DeviId value=''>			<!-- (신용카드공통)		단말기아이디 -->
						<input type=hidden name=QuotaInf value='0'>			<!-- (신용카드공통)		일반할부개월설정변수 -->
						<input type=hidden name=NointInf value='NONE'>		<!-- (신용카드공통)		무이자할부개월설정변수 -->
						<input type=hidden name=AuthYn value=''>			<!-- (신용카드공통)		인증여부 -->
						<input type=hidden name=Instmt value=''>			<!-- (신용카드공통)		할부개월수 -->
						<input type=hidden name=partial_mm value=''>		<!-- (ISP사용)			일반할부기간 -->
						<input type=hidden name=noIntMonth value=''>		<!-- (ISP사용)			무이자할부기간 -->
						<input type=hidden name=KVP_RESERVED1 value=''>		<!-- (ISP사용)			RESERVED1 -->
						<input type=hidden name=KVP_RESERVED2 value=''>		<!-- (ISP사용)			RESERVED2 -->
						<input type=hidden name=KVP_RESERVED3 value=''>		<!-- (ISP사용)			RESERVED3 -->
						<input type=hidden name=KVP_CURRENCY value=''>		<!-- (ISP사용)			통화코드 -->
						<input type=hidden name=KVP_CARDCODE value=''>		<!-- (ISP사용)			카드사코드 -->
						<input type=hidden name=KVP_SESSIONKEY value=''>	<!-- (ISP사용)			암호화코드 -->
						<input type=hidden name=KVP_ENCDATA value=''>		<!-- (ISP사용)			암호화코드 -->
						<input type=hidden name=KVP_CONAME value=''>		<!-- (ISP사용)			카드명 -->
						<input type=hidden name=KVP_NOINT value=''>			<!-- (ISP사용)			무이자/일반여부(무이자=1, 일반=0) -->
						<input type=hidden name=KVP_QUOTA value=''>			<!-- (ISP사용)			할부개월 -->
						<input type=hidden name=CardNo value=''>			<!-- (안심클릭,일반사용)	카드번호 -->
						<input type=hidden name=MPI_CAVV value=''>			<!-- (안심클릭,일반사용)	암호화코드 -->
						<input type=hidden name=MPI_ECI value=''>			<!-- (안심클릭,일반사용)	암호화코드 -->
						<input type=hidden name=MPI_MD64 value=''>			<!-- (안심클릭,일반사용)	암호화코드 -->
						<input type=hidden name=ExpMon value=''>			<!-- (일반사용)			유효기간(월) -->
						<input type=hidden name=ExpYear value=''>			<!-- (일반사용)			유효기간(년) -->
						<input type=hidden name=Passwd value=''>			<!-- (일반사용)			비밀번호 -->
						<input type=hidden name=SocId value=''>				<!-- (일반사용)			주민등록번호/사업자등록번호 -->

						<!-- 계좌이체 결제 사용 변수 -->
						<input type=hidden name=ICHE_OUTBANKNAME value=''>	<!-- 이체계좌은행명 -->
						<input type=hidden name=ICHE_OUTACCTNO value=''>	<!-- 이체계좌예금주주민번호 -->
						<input type=hidden name=ICHE_OUTBANKMASTER value=''><!-- 이체계좌예금주 -->
						<input type=hidden name=ICHE_AMOUNT value=''>		<!-- 이체금액 -->

						<!-- 핸드폰 결제 사용 변수 -->
						<input type=hidden name=HP_SERVERINFO value=''>		<!-- 서버정보 -->
						<input type=hidden name=HP_HANDPHONE value=''>		<!-- 핸드폰번호 -->
						<input type=hidden name=HP_COMPANY value=''>		<!-- 통신사명(SKT,KTF,LGT) -->
						<input type=hidden name=HP_IDEN value=''>			<!-- 인증시사용 -->
						<input type=hidden name=HP_IPADDR value=''>			<!-- 아이피정보 -->

						<!-- ARS 결제 사용 변수 -->
						<input type=hidden name=ARS_PHONE value=''>			<!-- ARS번호 -->
						<input type=hidden name=ARS_NAME value=''>			<!-- 전화가입자명 -->

						<!-- 가상계좌 결제 사용 변수 -->
						<input type=hidden name=ZuminCode value=''>			<!-- 가상계좌입금자주민번호 -->
						<input type=hidden name=VIRTUAL_CENTERCD value=''>	<!-- 가상계좌은행코드 -->
						<input type=hidden name=VIRTUAL_NO value=''>		<!-- 가상계좌번호 -->

						<input type=hidden name=mTId value=''>

						<!-- 에스크로 결제 사용 변수 -->
						<input type=hidden name=ES_SENDNO value=''>			<!-- 에스크로전문번호 -->

						<!-- 계좌이체(소켓) 결제 사용 변수 -->
						<input type=hidden name=ICHE_SOCKETYN value=''>		<!-- 계좌이체(소켓) 사용 여부 -->
						<input type=hidden name=ICHE_POSMTID value=''>		<!-- 계좌이체(소켓) 이용기관주문번호 -->
						<input type=hidden name=ICHE_FNBCMTID value=''>		<!-- 계좌이체(소켓) FNBC거래번호 -->
						<input type=hidden name=ICHE_APTRTS value=''>		<!-- 계좌이체(소켓) 이체 시각 -->
						<input type=hidden name=ICHE_REMARK1 value=''>		<!-- 계좌이체(소켓) 기타사항1 -->
						<input type=hidden name=ICHE_REMARK2 value=''>		<!-- 계좌이체(소켓) 기타사항2 -->
						<input type=hidden name=ICHE_ECWYN value=''>		<!-- 계좌이체(소켓) 에스크로여부 -->
						<input type=hidden name=ICHE_ECWID value=''>		<!-- 계좌이체(소켓) 에스크로ID -->
						<input type=hidden name=ICHE_ECWAMT1 value=''>		<!-- 계좌이체(소켓) 에스크로결제금액1 -->
						<input type=hidden name=ICHE_ECWAMT2 value=''>		<!-- 계좌이체(소켓) 에스크로결제금액2 -->
						<input type=hidden name=ICHE_CASHYN value=''>		<!-- 계좌이체(소켓) 현금영수증발행여부 -->
						<input type=hidden name=ICHE_CASHGUBUN_CD value=''>	<!-- 계좌이체(소켓) 현금영수증구분 -->
						<input type=hidden name=ICHE_CASHID_NO value=''>	<!-- 계좌이체(소켓) 현금영수증신분확인번호 -->

						<!-- 텔래뱅킹-계좌이체(소켓) 결제 사용 변수 -->
						<input type=hidden name=ICHEARS_SOCKETYN value=''>	<!-- 텔레뱅킹계좌이체(소켓) 사용 여부 -->
						<input type=hidden name=ICHEARS_ADMNO value=''>		<!-- 텔레뱅킹계좌이체 승인번호 -->
						<input type=hidden name=ICHEARS_POSMTID value=''>	<!-- 텔레뱅킹계좌이체 이용기관주문번호 -->
						<input type=hidden name=ICHEARS_CENTERCD value=''>	<!-- 텔레뱅킹계좌이체 은행코드 -->
						<input type=hidden name=ICHEARS_HPNO value=''>		<!-- 텔레뱅킹계좌이체 휴대폰번호 -->

						<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->

					</form>


					<script>
						$REQ_VAL[allthegate_demomsg]
						setTimeout('Pay(frmAGS_pay)',100);
					</script>


					</body>
					</html>
	";

	echo $req_result;
	exit;

}



function pg_req_allthegate_mobile($REQ_VAL)
{
	global $HAPPY_CONFIG,$pg_module_folder,$pg_module_path,$site_name,$main_url;


	$_SESSION['ALLTHEGATE_AMOUNT']			= $REQ_VAL["amount"];
	$REQ_VAL['buyer_id']					= substr($REQ_VAL['buyer_id'],0,20);
	$REQ_VAL['buyer_addr']					= substr($REQ_VAL['buyer_addr'],0,100);
	$REQ_VAL['buyer_hphone']				= substr($REQ_VAL['buyer_hphone'],0,21);


	$req_result	= "
					<html>
					<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<title>allthegate</title>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi'/>
					<script type='text/javascript' charset='euc-kr' src='https://www.allthegate.com/payment/mobilev2/csrf/csrf.real.js'></script>
					<script type='text/javascript' charset='euc-kr'>

						function doPay(form) {

							////////////////////////////////////////////////////////////////////////////////////////////////////////////
							//
							// 올더게이트 플러그인 설정값을 동적으로 적용하기 JavaScript 코드를 사용하고 있습니다.
							// 상점설정에 맞게 JavaScript 코드를 수정하여 사용하십시오.
							//
							// [1] 일반/무이자 결제여부
							// [2] 일반결제시 할부개월수
							// [3] 무이자결제시 할부개월수 설정
							// [4] 인증여부
							//////////////////////////////////////////////////////////////////////////////////////////////////////////////

							//////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// [1] 일반/무이자 결제여부를 설정합니다.
							//
							// 할부판매의 경우 구매자가 이자수수료를 부담하는 것이 기본입니다. 그러나,
							// 상점과 올더게이트간의 별도 계약을 통해서 할부이자를 상점측에서 부담할 수 있습니다.
							// 이경우 구매자는 무이자 할부거래가 가능합니다.
							//
							// 예제)
							//  (1) 일반결제로 사용할 경우
							//  form.DeviId.value = '9000400001';
							//
							//  (2) 무이자결제로 사용할 경우
							//  form.DeviId.value = '9000400002';
							//
							//  (3) 만약 결제 금액이 100,000원 미만일 경우 일반할부로 100,000원 이상일 경우 무이자할부로 사용할 경우
							//  if(parseInt(form.Amt.value) < 100000)
							//      form.DeviId.value = '9000400001';
							//  else
							//      form.DeviId.value = '9000400002';
							//////////////////////////////////////////////////////////////////////////////////////////////////////////////


							//////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// [2] 일반 할부기간을 설정합니다.
							//
							// 일반 할부기간은 2 ~ 12개월까지 가능합니다.
							// 0:일시불, 2:2개월, 3:3개월, ... , 12:12개월
							//
							// 예제)
							//  (1) 할부기간을 일시불만 가능하도록 사용할 경우
							//  form.QuotaInf.value = '0';
							//
							//  (2) 할부기간을 일시불 ~ 12개월까지 사용할 경우
							//      form.QuotaInf.value = '0:2:3:4:5:6:7:8:9:10:11:12';
							//
							//  (3) 결제금액이 일정범위안에 있을 경우에만 할부가 가능하게 할 경우
							//  if((parseInt(form.Amt.value) >= 100000) || (parseInt(form.Amt.value) <= 200000))
							//      form.QuotaInf.value = '0:2:3:4:5:6:7:8:9:10:11:12';
							//  else
							//      form.QuotaInf.value = '0';
							//////////////////////////////////////////////////////////////////////////////////////////////////////////////

							//결제금액이 5만원 미만건을 할부결제로 요청할경우 일시불로 결제
							if(parseInt(form.Amt.value) < 50000)
								form.QuotaInf.value = '0';
							else {
								form.QuotaInf.value = '0:2:3:4:5:6:7:8:9:10:11:12';
							}

							////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// [3] 무이자 할부기간을 설정합니다.
							// (일반결제인 경우에는 본 설정은 적용되지 않습니다.)
							//
							// 무이자 할부기간은 2 ~ 12개월까지 가능하며,
							// 올더게이트에서 제한한 할부 개월수까지만 설정해야 합니다.
							//
							// 100:BC
							// 200:국민
							// 300:외환
							// 400:삼성
							// 500:신한
							// 800:현대
							// 900:롯데
							//
							// 예제)
							//  (1) 모든 할부거래를 무이자로 하고 싶을때에는 ALL로 설정
							//  form.NointInf.value = 'ALL';
							//
							//  (2) 국민카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
							//  form.NointInf.value = '200-2:3:4:5:6';
							//
							//  (3) 외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
							//  form.NointInf.value = '300-2:3:4:5:6';
							//
							//  (4) 국민,외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
							//  form.NointInf.value = '200-2:3:4:5:6,300-2:3:4:5:6';
							//
							//  (5) 무이자 할부기간 설정을 하지 않을 경우에는 NONE로 설정
							//  form.NointInf.value = 'NONE';
							//
							//  (6) 전카드사 특정개월수만 무이자를 하고 싶은경우(2:3:6개월)
							//  form.NointInf.value = '100-2:3:6,200-2:3:6,300-2:3:6,400-2:3:6,500-2:3:6,600-2:3:6,800-2:3:6,900-2:3:6';
							//
							////////////////////////////////////////////////////////////////////////////////////////////////////////////////

							//	모든 할부거래를 무이자
							if(form.DeviId.value == '9000400002') {
								form.NointInf.value = 'ALL';
							}


							AllTheGate.pay(document.form);
							return false;
						}

					</script>
					</head>
					<body>

					$REQ_VAL[pay_design]

					<form method='post' action='https://www.allthegate.com/payment/mobilev2/intro.jsp' name='form'>
						<input type='hidden' name='OrdNo' value='$REQ_VAL[oid]'/>											<!--주문번호-->
						<input type='hidden' name='ProdNm'  value='$REQ_VAL[product_title]'/>								<!--상품명-->
						<input type='hidden' name='Amt' value='$REQ_VAL[amount]'/>											<!--가격-->
						<input type='hidden' name='DutyFree' value='0'/>													<!--면세금액-->
						<input type='hidden' name='OrdNm'  value='$REQ_VAL[buyer_name]'/>									<!--구매자이름-->
						<input type='hidden' name='StoreNm'  value='$REQ_VAL[site_name]'/>									<!--상점이름-->
						<input type='hidden' name='OrdPhone'  value='$REQ_VAL[buyer_hphone]'/>								<!--휴대폰번호-->
						<input type='hidden' name='UserEmail'  value='$REQ_VAL[buyer_email]'/>								<!--이메일-->
						<input type='hidden' name='Job' value='$REQ_VAL[allthegate_Job_mobile]'>							<!--결제방법-->
						<input type='hidden' name='StoreId' maxlength='20' value='$REQ_VAL[mid]'/>							<!--상점아이디-->
						<input type='hidden' name='MallUrl' value='$main_url'/>												<!--상점URL-->
						<input type='hidden' name='UserId' maxlength='20' value='$REQ_VAL[buyer_id]'>						<!--회원아이디-->
						<input type='hidden' name='OrdAddr' value='$REQ_VAL[buyer_addr]'>									<!--주문자주소-->
						<input type='hidden' name='RcpNm' value='$REQ_VAL[receive_name]'>									<!--수신자명-->
						<input type='hidden' name='RcpPhone' value='$REQ_VAL[receive_hphone]'>								<!--수신자연락처-->
						<input type='hidden' name='DlvAddr' value='$REQ_VAL[receive_addr]'>									<!--배송지주소-->
						<input type='hidden' name='Remark' value='$REQ_VAL[etc_remark]'>									<!--기타요구사항-->
						<input type='hidden' name='CardSelect'  value=''>													<!--카드사선택-->
						<input type='hidden' name='RtnUrl' value='$main_url/$pg_module_folder/pg_db_update.php'>			<!--성공 URL-->

						<!--앱 URL Scheme (독자앱일 경우)-->
						<!--네이버 예시 :  naversearchapp://inappbrowser?url= -->
						<!--AppRtnScheme + RtnUrl을 합친 값으로 다시 앱을 호출합니다.-->
						<!--독자앱이 아닌경우 빈값으로 세팅-->
						<input type='hidden'  name='AppRtnScheme' value=''>

						<input type='hidden'  name='CancelUrl' value='$_SERVER[HTTP_REFERER]'>								<!--취소 URL-->
						<input type='hidden'  name='Column1' maxlength='200' value='$REQ_VAL[pay_type_option]'>				<!--추가사용필드1-->
						<input type='hidden'  name='Column2' maxlength='200' value=''>										<!--추가사용필드2-->
						<input type='hidden'  name='Column3' maxlength='200' value=''>										<!--추가사용필드3-->

						<!--가상계좌 결제 사용 변수-->
						<input type='hidden' name='MallPage' maxlength='100' value=''>										<!--통보페이지-->
						<input type='hidden' name='VIRTUAL_DEPODT' maxlength=8 value=''>									<!--입금예정일-->

						<!--핸드폰 결제 사용 변수-->
						<input type='hidden' name='HP_ID' maxlength='10' value='$HAPPY_CONFIG[allthegate_hp_id]'>			<!--CP아이디-->
						<input type='hidden' name='HP_PWD' maxlength='10' value='$HAPPY_CONFIG[allthegate_hp_pwd]'>			<!--CP비밀번호-->
						<input type='hidden' name='HP_SUBID' maxlength='10' value='$HAPPY_CONFIG[allthegate_hp_subid]'>		<!--SUB-CP아이디-->
						<input type='hidden' name='ProdCode' maxlength='10' value='$HAPPY_CONFIG[allthegate_prodcode]'>		<!--상품코드-->
						<input type='hidden' name='HP_UNITType' value='$HAPPY_CONFIG[allthegate_HP_UNITType]'>				<!--상품종류-->
						<input type='hidden' name='SubjectData' value=''>													<!--상품제공기간 금액;품명;2014.09.21~28-->


						<input type='hidden' name='DeviId' value='9000400001'>
						<input type='hidden' name='QuotaInf' value='0'>
						<input type='hidden' name='NointInf' value='NONE'>



					</form>

					<script>
						function pay_launch()
						{
							doPay(document.form);
						}
					</script>

					</body>
					</html>
	";


	echo $req_result;
	exit;


}




function pg_req_daoupay($REQ_VAL)
{
	global $HAPPY_CONFIG,$pg_module_folder,$pg_module_path,$main_url;


	$_SESSION['DAOUPAY_AMOUNT']			= $REQ_VAL["amount"];
	$REQ_VAL['buyer_id']				= substr($REQ_VAL['buyer_id'],0,30);
	$REQ_VAL['product_title']			= substr($REQ_VAL['product_title'],0,50);

	$req_result	= "
					<html>
					<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<title>DAOUPAY</title>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<meta http-equiv='Cache-Control' content='no-cache'/>
					<meta http-equiv='Expires' content='0'/>
					<meta http-equiv='Pragma' content='no-cache'/>

					<script language='javascript'>
					var pf;


					function fnSubmit() {
						var fileName;
						//fileName = 'http://ssltest.daoupay.com/creditCard/DaouCreditCardMng.jsp';
						fileName = '$REQ_VAL[daoupay_pay_url]';

						pf = document.frmConfirm

						$REQ_VAL[daoupay_pop_up_option]

						pf.action = fileName;
						pf.method = 'post';
						pf.submit();
					}


					function fnCheck() {

						var frm = document.frmConfirm;

						//주문번호
						if(trim(frm.ORDERNO.value) == '' || getByteLen(frm.ORDERNO.value) > 50) {
							alert('주문번호 (ORDERNO) 를 입력해주세요. (최대:50byte, 현재:' + getByteLen(frm.ORDERNO.value) + ')');
							return;
						}
						//상품구분
						if(trim(frm.PRODUCTTYPE.value) == '' || getByteLen(frm.PRODUCTTYPE.value) > 2) {
							alert('상품구분 (PRODUCTTYPE) 를 입력해주세요. (최대:2byte, 현재:' + getByteLen(frm.PRODUCTTYPE.value) + ')');
							return;
						}
						//과금유형
						if(trim(frm.BILLTYPE.value) == '' || getByteLen(frm.BILLTYPE.value) > 2) {
							alert('과금유형 (BILLTYPE) 를 입력해주세요. (최대:2byte, 현재:' + getByteLen(frm.BILLTYPE.value) + ')');
							return;
						}
						//결제금액
						if(trim(frm.AMOUNT.value) == '' || getByteLen(frm.AMOUNT.value) > 10) {
							alert('결제금액 (AMOUNT) 를 입력해주세요. (최대:10byte, 현재:' + getByteLen(frm.AMOUNT.value) + ')');
							return;

						}
						/********************  필수 입력 체크 끝  ***/
					}


					function trim(txt) {
						while (txt.indexOf(' ') >= 0) {
							txt = txt.replace(' ','');
						}
						return txt;
					}



					function getByteLen(p_val) {
						var onechar;
						var tcount = 0;

						for(i = 0; i < p_val.length; i++) {
							onechar = p_val.charAt(i);
							if(escape(onechar).length > 4)
								tcount += 2;
							else if(onechar != '\\r')
								tcount++;
						}
						return tcount;
					}


					</script>

					</head>

					<BODY>

					$REQ_VAL[pay_design]

					<form name='frmConfirm'>
						<input type='hidden' name='CPID' size='50' maxlength='50' value='$REQ_VAL[mid]'>			<!--[필수]가맹점ID-->
						<input type='hidden' name='ORDERNO' size='50' maxlength='50'value='$REQ_VAL[oid]'>			<!--[필수]주문번호-->
						<input type='hidden' name='PRODUCTTYPE' size='10' maxlength='2' value='$HAPPY_CONFIG[daoupay_producttype]'>	<!--[필수]상품구분(1:디지털,2:실물)-->
						<input type='hidden' name='BILLTYPE' size='10' maxlength='2'  value='1'>					<!--[필수]과금유형(1:일반)-->
						<input type='hidden' name='TAXFREECD' value='00'>											<!--[필수]과세비과세(00:과세,01:비과세)-->
						<input type='hidden' name='AMOUNT' size='10' maxlength='10' value='$REQ_VAL[amount]'>		<!--[필수]결제금액-->
						<input type='hidden' name='EMAIL' size='100' maxlength='100' value='$REQ_VAL[buyer_email]'>	<!--EMAIL-->
						<input type='hidden' name='USERID' size='30' maxlength='30' value='$REQ_VAL[buyer_id]'>		<!--고객아이디-->
						<input type='hidden' name='USERNAME' size='50' maxlength='50' value='$REQ_VAL[buyer_name]'>	<!--고객명-->
						<input type='hidden' name='PRODUCTCODE' size='10' value=''>									<!--상품코드-->
						<input type='hidden' name='PRODUCTNAME' size='50' value='$REQ_VAL[product_title]'>			<!--상품명-->
						<input type='hidden' name='TELNO1' size='50' value=''>										<!--고객전화번호-->
						<input type='hidden' name='TELNO2' size='50' value='$REQ_VAL[buyer_hphone]'>				<!--고객휴대폰번호-->
						<input type='hidden' name='RESERVEDINDEX1' size='20' value='$REQ_VAL[pay_type_option]'>		<!--예약항목1-->
						<input type='hidden' name='RESERVEDINDEX2' size='20' value=''>								<!--예약항목2-->
						<input type='hidden' name='RESERVEDSTRING' size='100' value=''>								<!--예약항목-->
						<input type='hidden' name='RETURNURL' value=''>												<!--결제 완료 후, 이동할 url(새창)-->
						<input type='hidden' name='HOMEURL' value='$REQ_VAL[daoupay_success_page]'>							<!--결제 완료 후, 이동할 url(결제창)-->
						<input type='hidden' name='CLOSEURL' value=''>					<!-- 모바일전용 취소버튼시 URL  -->
						<input type='hidden' name='DIRECTRESULTFLAG' value='Y'>										<!--다우페이 결제완료창 없이 HOMEURL로 바로이동(Y/N)-->

						<!--나머지 상점 옵션값-->
						<input type=hidden name=kcp_noint value=''>
						<input type=hidden name=kcp_noint_quota   value=''>
						<input type=hidden name=quotaopt         value=''>
						<input type=hidden name=fix_inst         value=''>
						<input type=hidden name=not_used_card    value=''>
						<input type=hidden name=save_ocb         value=''>
						<input type=hidden name=used_card_YN   value=''>
						<input type=hidden name=used_card         value=''>
						<input type=hidden name=eng_flag         value=''>
						<input type=hidden name=kcp_site_logo         value=''>
						<input type=hidden name=kcp_site_img         value=''>

					</form>

					<script>
						$REQ_VAL[pay_launch_script]
					</script>

					</BODY>
					</HTML>


	";

	echo $req_result;
	exit;
}










// 이니시스 Non Active-X update : 2015-11-24 - x2chi
function pg_req_inicis($REQ_VAL)
{
	global $pg_module_folder,$main_url;

	$main_url2 = "http://".$_SERVER['HTTP_HOST'];
global $apache_ssl_all_use;
if ($apache_ssl_all_use != "") { $main_url2 = "https://".$_SERVER['HTTP_HOST']; }
else { $main_url2 = "http://".$_SERVER['HTTP_HOST']; }
	$REQ_VAL['product_title']			= substr($REQ_VAL['product_title'],0,80);
	$REQ_VAL['buyer_name']				= substr($REQ_VAL['buyer_name'],0,40);
	$REQ_VAL['buyer_hphone']			= substr($REQ_VAL['buyer_hphone'],0,20);
	$REQ_VAL['buyer_email']				= substr($REQ_VAL['buyer_email'],0,40);

	require_once($pg_module_folder.'/inicis/libs/INIStdPayUtil.php');
	$SignatureUtil	= new INIStdPayUtil();

	//############################################
	// 1.전문 필드 값 설정(***가맹점 개발수정***)
	//############################################
	// 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
	$mid								= $REQ_VAL['mid'];  // 가맹점 ID(가맹점 수정후 고정)
	//인증
	$signKey							= $REQ_VAL['inicis_signkey']; //"SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
	$timestamp							= $SignatureUtil->getTimestamp();   // util에 의해서 자동생성
	$orderNumber						= $REQ_VAL['oid']; // $mid . "_" . $timestamp; // 가맹점 주문번호(가맹점에서 직접 설정)
	$price								= $REQ_VAL["amount"];        // 상품가격(특수기호 제외, 가맹점에서 직접 설정)
	$_SESSION['INI_PRICE']				= $price;				// 금액 위변조 방지 가격 세션 저장

	$cardNoInterestQuota	= "11-2:3:,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
	$cardQuotaBase			= "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
	//
	//###################################
	// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
	//###################################
	$mKey			= hash("sha256", $signKey);

	/*
	  //*** 위변조 방지체크를 signature 생성 ***
	  oid, price, timestamp 3개의 키와 값을
	  key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값
	  ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004
	 * key기준 알파벳 정렬
	 * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그데로 사용하여야함
	 */
	$params			= "oid=" . $orderNumber . "&price=" . $price . "&timestamp=" . $timestamp;
	$sign			= hash("sha256", $params);

	/* 기타 */
	$siteDomain = $main_url2; //가맹점 도메인 입력
	// 페이지 URL에서 고정된 부분을 적는다.
	// Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
	//                 http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.



	$req_result	= "
		<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html>
			<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
				<!-- 이니시스 표준결제 js -->
				<script language=\"javascript\" type=\"text/javascript\" src=\"HTTPS://".$REQ_VAL['inicis_SVR'].".inicis.com/stdjs/INIStdPay.js\" charset=\"UTF-8\"></script>
				<script type=\"text/javascript\">
					function paybtn() {
						INIStdPay.pay('SendPayForm_id');
					}
				</script>
			</head>
			<body bgcolor=\"#FFFFFF\" text=\"#242424\" leftmargin=0 topmargin=15 marginwidth=0 marginheight=0 bottommargin=0 rightmargin=0>
				<!-- <button onclick=\"paybtn()\" style=\"padding:10px\">결제요청</button> -->
				<form id=\"SendPayForm_id\" name=\"\" method=\"POST\" >

					<!-- <input type=\"submit\" name=\"btn_pay\" value=\"결제요청\" id=\"btn_pay\" /> -->

					<!-- ** 필수 ** -->
						<!-- [version]-->		<input type=\"hidden\" name=\"version\" value=\"1.0\" >
						<!-- [mid] -->			<input type=\"hidden\" name=\"mid\" value=\"".$mid."\" >
						<!-- [goodname] -->		<input type=\"hidden\" name=\"goodname\" value=\"".$REQ_VAL['product_title']."\" >
						<!-- [oid] -->			<input type=\"hidden\" name=\"oid\" value=\"".$orderNumber."\" >
						<!-- [price] -->		<input type=\"hidden\" name=\"price\" value=\"".$price."\" >
						<!-- [currency] -->		<input type=\"hidden\" name=\"currency\" value=\"WON\" >
												<!-- [WON|USD] -->
						<!-- [buyername] -->	<input type=\"hidden\" name=\"buyername\" value=\"".$REQ_VAL['buyer_name']."\" >
						<!-- [buyertel] -->		<input type=\"hidden\" name=\"buyertel\" value=\"".$REQ_VAL['buyer_hphone']."\" >
						<!-- [buyeremail] -->	<input type=\"hidden\" name=\"buyeremail\" value=\"".$REQ_VAL['buyer_email']."\" >
						<!-- [timestamp] -->	<input type=\"hidden\" name=\"timestamp\" value=\"".$timestamp."\" >
						<!-- [signature] -->	<input type=\"hidden\" name=\"signature\" value=\"".$sign."\" >
						<!-- [returnUrl] -->	<input type=\"hidden\" name=\"returnUrl\" value=\"".$siteDomain."/pg_module/pg_db_update.php\" >
						<!-- [mKey] -->			<input type=\"hidden\"  name=\"mKey\" value=\"".$mKey."\" >


					<!-- ** 기본 옵션 ** -->
						<!-- [gopaymethod] -->	<input type=\"hidden\" name=\"gopaymethod\" value=\"".$REQ_VAL['inicis_gopaymethod']."\" >
												<!-- [Card,DirectBank,HPP,Vbank,kpay,Swallet,Paypin,EasyPay,PhoneBill,GiftCard,EWallet,onlypoint,onlyocb,onyocbplus,onlygspt,onlygsptplus,onlyupnt,onlyupntplus] -->
						<!-- [offerPeriod] -->	<input type=\"hidden\" name=\"offerPeriod\" value=\"\" >
												<!-- 제공기간 ex)20150101-20150331, [Y2:년단위결제, M2:월단위결제, yyyyMMdd-yyyyMMdd : 시작일-종료일] -->
						<!-- [acceptmethod] -->	<input type=\"hidden\" name=\"acceptmethod\" value=\"HPP(".$REQ_VAL['inicis_acceptmethod_hpp']."):no_receipt:va_receipt:vbanknoreg(0):vbank(20150611):below1000\" >
												<!-- acceptmethod  ex) CARDPOINT:SLIMQUOTA(코드-개월:개월):no_receipt:va_receipt:vbanknoreg(0):vbank(20150425):va_ckprice:vbanknoreg: -->
												<!-- KWPY_TYPE(0):KWPY_VAT(10|0) 기타 옵션 정보 및 설명은 연동정의보 참조 구분자 \":\" -->

					<!-- ** 표시 옵션 ** -->
						<!-- [languageView] -->	<input type=\"hidden\" name=\"languageView\" value=\"ko\" >
												<!-- 초기 표시 언어 [ko|en] (default:ko) -->
						<!-- [charset] -->		<input type=\"hidden\" name=\"charset\" value=\"".$REQ_VAL['inicis_charset']."\" >
												<!-- 리턴 인코딩 [UTF-8|EUC-KR] (default:UTF-8) -->
						<!-- [payViewType] -->	<input type=\"hidden\" name=\"payViewType\" value=\"popup\" >
												<!-- 결제창 표시방법 [overlay|popup] (default:overlay) -->
						<!-- [closeUrl] -->		<input type=\"hidden\" name=\"closeUrl\" value=\"".$siteDomain."/pg_module/inicis/close.php\" > <!-- 안되는듯...???? -->
												<!-- payViewType='overlay','popup'시 취소버튼 클릭시 창닫기 처리 URL(가맹점에 맞게 설정) -->
												<!-- close.jsp 샘플사용(생략가능, 미설정시 사용자에 의해 취소 버튼 클릭시 인증결과 페이지로 취소 결과를 보냅니다.) -->
						<!-- [popupUrl] -->		<input type=\"hidden\" name=\"popupUrl\" value=\"".$siteDomain."/pg_module/inicis/popup.php\" >
												<!-- payViewType='popup'시 팝업을 띄울수 있도록 처리해주는 URL(가맹점에 맞게 설정) -->
												<!-- popup.jsp 샘플사용(생략가능,payViewType='popup'으로 사용시에는 반드시 설정) -->


					<!-- ** 결제 수단별 옵션 ** -->
						<!-- 카드(간편결제도 사용) -->
							<!-- [nointerest] -->	<input type=\"hidden\" name=\"nointerest\" value=\"".$cardNoInterestQuota."\" >
													<!-- 무이자 할부 개월 ex) 11-2:3:4,04-2:3:4 -->
							<!-- [quotabase] -->	<input type=\"hidden\" name=\"quotabase\" value=\"".$cardQuotaBase."\" >
													<!-- 할부 개월 ex) 2:3:4 -->
						<!-- 가상계좌 -->
							<!-- [INIregno] -->		<input type=\"hidden\" name=\"vbankRegNo\" value=\"\" >
													<!-- 주민번호 설정 기능 - 13자리(주민번호),10자리(사업자번호),미입력시(화면에서입력가능) -->


					<!-- 추가 옵션 -->
						<!-- [merchantData] -->		<input type=\"hidden\" name=\"merchantData\" value=\"".$REQ_VAL['pay_type_option']."\" >
													<!-- 가맹점 관리데이터(2000byte) 인증결과 리턴시 함께 전달됨 -->
				</form>

				<script>
					function inicis_launch()
					{
						paybtn();
					}
					setTimeout('inicis_launch()',100);
				</script>

			</body>
		</html>
	";

	echo $req_result;
	exit;
}



function pg_req_inicis_mobile($REQ_VAL)
{
	global $HAPPY_CONFIG,$pg_module_folder,$pg_module_path,$main_url;


	$_SESSION['INI_PRICE']			= $REQ_VAL["amount"];     //가격
	$REQ_VAL['product_title']		= substr($REQ_VAL['product_title'],0,80);
	$REQ_VAL['buyer_name']			= substr($REQ_VAL['buyer_name'],0,30);
	$REQ_VAL['buyer_hphone']		= substr($REQ_VAL['buyer_hphone'],0,15);
	$REQ_VAL['buyer_email']			= substr($REQ_VAL['buyer_email'],0,30);

	$P_RETURN_URL					= "$main_url/$pg_module_folder/pg_db_update.php?P_NOTI=pay_type_option=$REQ_VAL[pay_type_option],oid=$REQ_VAL[oid]";
	if( $REQ_VAL['inicis_paymethod'] == "bank" )
	{
		switch($REQ_VAL['pay_type_option'])
		{
			case 'company' :
				$P_RETURN_URL		= "$main_url/my_pay_success.php?oid=$REQ_VAL[oid]&respcode=0000";
				break;
			case 'person' :
			case 'person_package' :
			case 'company_package' :
				$P_RETURN_URL		= "$main_url/my_pay_success2.php?oid=$REQ_VAL[oid]&respcode=0000";
				break;
			case 'point' :
				$P_RETURN_URL		= "$main_url/my_pay_point_success.php?oid=$REQ_VAL[oid]&respcode=0000";
				break;
		}
	}

	$req_result	= "
					<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
					<html xmlns='http://www.w3.org/1999/xhtml'>
					<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<meta name='viewport' content='width=device-width'/>
					<title>INIpayMobile</title>

					<script language=javascript>
					function on_web()
					{
						var order_form = document.ini;
						var paymethod = order_form.paymethod.value;

						order_form.target = '';
						order_form.action = 'https://mobile.inicis.com/smart/' + paymethod + '/';
						order_form.submit();
					}


					</script>
					</head>

					<body topmargin='0'  leftmargin='0' marginwidth='0' marginheight='0'>

					$REQ_VAL[pay_design]

					<form id='form1' name='ini' method='post' action='' >
						<input type='hidden' name='P_OID' value='$REQ_VAL[oid]'>											<!--[필수]주문번호-->
						<input type='hidden' name='P_GOODS' value='$REQ_VAL[product_title]'>								<!--[필수]상품명-->
						<input type='hidden' name='P_AMT' value='$REQ_VAL[amount]'>											<!--[필수]가격-->
						<input type='hidden' name='P_UNAME' value='$REQ_VAL[buyer_name]'>									<!--[필수]구매자이름-->

						<input type='hidden' name='P_MNAME' value=''>														<!--상점이름-->
						<input type='hidden' name='P_MOBILE' value='$REQ_VAL[buyer_hphone]'>								<!--휴대폰번호-->
						<input type='hidden' name='P_EMAIL' value='$REQ_VAL[buyer_email]'>									<!--이메일-->
						<input type='hidden' name='paymethod' value='$REQ_VAL[inicis_paymethod]'>							<!--결제방법(wcard,DBANK,mobile)-->

						<input type='hidden' name='P_MID' value='$REQ_VAL[mid]'>											<!--[필수]상점아이디-->
						<input type='hidden' name='P_RESERVED' value='twotrs_isp=Y&block_isp=Y&twotrs_isp_noti=N'/>            <!--[필수]복합 파라미터정보(ISP인증승인 분리옵션 등)-->
						<input type=hidden name='P_NEXT_URL' value='$main_url/$pg_module_folder/pg_db_update.php'>			<!--[필수]ISP,계좌이체,삼성월렛,Kpay제외한 모든수단-->
						<input type=hidden name='P_NOTI_URL' value='$main_url/$pg_module_folder/pg_db_update.php'>			<!--[필수]가상계좌,계좌이체,삼성월렛,Kpay만사용-->
						<input type=hidden name='P_RETURN_URL' value='$P_RETURN_URL'>		<!--[필수]ISP,계좌이체,삼성월렛,Kpay만사용-->
						<input type=hidden name='P_HPP_METHOD' value='$REQ_VAL[inicis_acceptmethod_hpp]'>					<!--[필수]상품구분(1:디지털,2:실물)-->

						<input type='hidden' name='P_NOTI' value='pay_type_option=$REQ_VAL[pay_type_option],oid=$REQ_VAL[oid]'>			<!--기타주문정보-->
					 </form>


					<script>
						function pay_launch()
						{
							on_web();
						}
					</script>

					</body>
					</html>

	";

	echo $req_result;
	exit;
}

##############################결제인증요청 END##############################







##############################결제결과DB업데이트##############################
#데이콤장부업데이를 위한 임시(기업회원)
function company_pay_ok(){

	global $guin_tb,$oid,$jangboo,$boodong_tb,$option_array_name,$last_date_read,$USER_ID,$CONF,$guin_tb,$ARRAY,$ARRAY_NAME,$ARRAY_NAME2,$jangboo;

	global $real_gap;
	global $happy_member,$happy_member_option_type;


	#장부에 해당저장정보를 읽어오자
	$sql = "select * from $jangboo where or_no='$oid' ";
	$result = query($sql);
	$JANGBOO = happy_mysql_fetch_array($result);


	if ($JANGBOO[in_check] == "1")
	{
		//note_url 로 함수 이동시에는 return 으로 함수 종료만 해야함
		gomsg("이미 입금완료 처리된 내역입니다.   ",'happy_member.php?mode=mypage');
		exit;
	}


	if ($JANGBOO[number] == "")
	{
		//note_url 로 함수 이동시에는 return 으로 함수 종료만 해야함
		gomsg("잘못된 접근입니다   ",'happy_member.php?mode=mypage');
		exit;
	}


	#날짜정보를 읽어서 업데이트를 실시한다.
	$GET_DAY = split(",",$JANGBOO[goods_name]);

	#장부에 해당정보를 찍자
	$sql = "update $jangboo set in_check = '1' where or_no='$oid'";
	$result2 = query($sql);

	if ( $JANGBOO[member_type] )
	{
		#넘어온 번호로 GUIN_INFO를 구하자
		$sql = "select * from $happy_member where number='$JANGBOO[links_number]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);
	}
	else
	{
		#넘어온 번호로 GUIN_INFO를 구하자
		$sql = "select * from $guin_tb where number='$JANGBOO[links_number]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);
	}

	#NOTI값이 왔다고 가정한다
	#$P_NOTI = "10 : 800|1:2|1:10|1:2|1 : 100|1:2|1 : 100|101|test";
	$JANGBOO[goods_name] = str_replace(" ", "", "$JANGBOO[goods_name]");
	list($guin_banner1,$guin_banner2,$guin_banner3,$guin_bold,$guin_list_hyung,$guin_pick,$guin_ticker,$guin_docview,$guin_docview2,$guin_smspoint,$guin_bgcolor,$guin_freeicon,$guin_uryo1,$guin_uryo2,$guin_uryo3,$guin_uryo4,$guin_uryo5,$guin_jump) = split(",",$JANGBOO[goods_name]);

	list($guin_banner1,$tmp)	= split(":",$guin_banner1);
	list($guin_banner2,$tmp)	= split(":",$guin_banner2);
	list($guin_banner3,$tmp)	= split(":",$guin_banner3);
	list($guin_bold,$tmp)		= split(":",$guin_bold);
	list($guin_list_hyung,$tmp)	= split(":",$guin_list_hyung);
	list($guin_pick,$tmp)		= split(":",$guin_pick);
	list($guin_ticker,$tmp)		= split(":",$guin_ticker);
	list($guin_docview,$tmp)	= split(":",$guin_docview);
	list($guin_docview2,$tmp)	= split(":",$guin_docview2);
	list($guin_smspoint,$tmp)	= split(":",$guin_smspoint);
	#배경색+아이콘 추가됨
	list($guin_bgcolor,$tmp)	= split(":",$guin_bgcolor);
	list($guin_freeicon,$tmp)	= split(":",$guin_freeicon);
	#추가옵션 5개
	list($guin_uryo1,$tmp)	= split(":",$guin_uryo1);
	list($guin_uryo2,$tmp)	= split(":",$guin_uryo2);
	list($guin_uryo3,$tmp)	= split(":",$guin_uryo3);
	list($guin_uryo4,$tmp)	= split(":",$guin_uryo4);
	list($guin_uryo5,$tmp)	= split(":",$guin_uryo5);

	//채용정보 점프
	list($guin_jump,$tmp)	= split(":",$guin_jump);

	if ($JANGBOO[member_type])
	{
		#회원정보에 업데이트 찍자

		//이력서보기기간
		$MemberDataOption['guin_docview'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_docview');
		$MemberDataOption['guin_docview'] = $MemberDataOption['guin_docview'] < $real_gap ? $real_gap : $MemberDataOption['guin_docview'];
		$tmp_guin_docview = $MemberDataOption['guin_docview'] + $guin_docview;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_docview',$tmp_guin_docview,'int(11)');

		//이력서보기회수
		$MemberDataOption['guin_docview2'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_docview2');
		$tmp_guin_docview2 = $MemberDataOption['guin_docview2'] + $guin_docview2;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_docview2',$tmp_guin_docview2,'int(11)');

		//sms발송포인트
		$MemberDataOption['guin_smspoint'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_smspoint');
		$guin_smspoint2 = $MemberDataOption['guin_smspoint'] + $guin_smspoint;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_smspoint',$guin_smspoint2,'int(11)');


		//채용정보 점프
		$MemberDataOption['guin_jump'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_jump');
		$guin_jump2 = $MemberDataOption['guin_jump'] + $guin_jump;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_jump',$guin_jump2,'int(11)');

	}
	else
	{
		//이력서보기기간
		$MemberDataOption['guin_docview'] = happy_member_option_get($happy_member_option_type,$DETAIL['guin_id'],'guin_docview');
		$MemberDataOption['guin_docview'] = $MemberDataOption['guin_docview'] < $real_gap ? $real_gap : $MemberDataOption['guin_docview'];
		$tmp_guin_docview = $MemberDataOption['guin_docview'] + $guin_docview;

		happy_member_option_set($happy_member_option_type,$DETAIL['guin_id'],'guin_docview',$tmp_guin_docview,'int(11)');

		//이력서보기회수
		$MemberDataOption['guin_docview2'] = happy_member_option_get($happy_member_option_type,$DETAIL['guin_id'],'guin_docview2');
		$tmp_guin_docview2 = $MemberDataOption['guin_docview2'] + $guin_docview2;

		happy_member_option_set($happy_member_option_type,$DETAIL['guin_id'],'guin_docview2',$tmp_guin_docview2,'int(11)');

		//sms발송포인트
		$MemberDataOption['guin_smspoint'] = happy_member_option_get($happy_member_option_type,$DETAIL['guin_id'],'guin_smspoint');
		$guin_smspoint2 = $MemberDataOption['guin_smspoint'] + $guin_smspoint;

		happy_member_option_set($happy_member_option_type,$DETAIL['guin_id'],'guin_smspoint',$guin_smspoint2,'int(11)');


		//채용정보 점프
		$MemberDataOption['guin_jump'] = happy_member_option_get($happy_member_option_type,$DETAIL['guin_id'],'guin_jump');
		$guin_jump2 = $MemberDataOption['guin_jump'] + $guin_jump;

		happy_member_option_set($happy_member_option_type,$DETAIL['guin_id'],'guin_jump',$guin_jump2,'int(11)');

		#guin 정보를 업데이트 한다.
		if ( $CONF['guin_banner1_option'] == '기간별' )
		{
			$DETAIL['guin_banner1']		= $DETAIL['guin_banner1'] < $real_gap ? $real_gap : $DETAIL['guin_banner1'];
		}
		else
		{
			$DETAIL['guin_banner1']		= $DETAIL['guin_banner1'] < 0 ? 0 : $DETAIL['guin_banner1'];
		}

		if ( $CONF['guin_banner2_option'] == '기간별' )
		{
			$DETAIL['guin_banner2']		= $DETAIL['guin_banner2'] < $real_gap ? $real_gap : $DETAIL['guin_banner2'];
		}
		else
		{
			$DETAIL['guin_banner2']		= $DETAIL['guin_banner2'] < 0 ? 0 : $DETAIL['guin_banner2'];
		}

		if ( $CONF['guin_banner3_option'] == '기간별' )
		{
			$DETAIL['guin_banner3']		= $DETAIL['guin_banner3'] < $real_gap ? $real_gap : $DETAIL['guin_banner3'];
		}
		else
		{
			$DETAIL['guin_banner3']		= $DETAIL['guin_banner3'] < 0 ? 0 : $DETAIL['guin_banner3'];
		}

		if ( $CONF['guin_bold_option'] == '기간별' )
		{
			$DETAIL['guin_bold']		= $DETAIL['guin_bold'] < $real_gap ? $real_gap : $DETAIL['guin_bold'];
		}
		else
		{
			$DETAIL['guin_bold']		= $DETAIL['guin_bold'] < 0 ? 0 : $DETAIL['guin_bold'];
		}

		if ( $CONF['guin_list_hyung_option'] == '기간별' )
		{
			$DETAIL['guin_list_hyung']	= $DETAIL['guin_list_hyung'] < $real_gap ? $real_gap : $DETAIL['guin_list_hyung'];
		}
		else
		{
			$DETAIL['guin_list_hyung']	= $DETAIL['guin_list_hyung'] < 0 ? 0 : $DETAIL['guin_list_hyung'];
		}

		if ( $CONF['guin_pick_option'] == '기간별' )
		{
			$DETAIL['guin_pick']		= $DETAIL['guin_pick'] < $real_gap ? $real_gap : $DETAIL['guin_pick'];
		}
		else
		{
			$DETAIL['guin_pick']		= $DETAIL['guin_pick'] < 0 ? 0 : $DETAIL['guin_pick'];
		}

		if ( $CONF['guin_ticker_option'] == '기간별' )
		{
			$DETAIL['guin_ticker']		= $DETAIL['guin_ticker'] < $real_gap ? $real_gap : $DETAIL['guin_ticker'];
		}
		else
		{
			$DETAIL['guin_ticker']		= $DETAIL['guin_ticker'] < 0 ? 0 : $DETAIL['guin_ticker'];
		}

		#배경색+아이콘 추가됨
		if ( $CONF['guin_bgcolor_com_option'] == '기간별' )
		{
			$DETAIL['guin_bgcolor_com']		= $DETAIL['guin_bgcolor_com'] < $real_gap ? $real_gap : $DETAIL['guin_bgcolor_com'];
		}
		else
		{
			$DETAIL['guin_bgcolor_com']		= $DETAIL['guin_bgcolor_com'] < 0 ? 0 : $DETAIL['guin_bgcolor_com'];
		}

		#아이콘
		if ( $CONF['freeicon_comDate_option'] == '기간별' )
		{
			$DETAIL['freeicon_comDate']		= $DETAIL['freeicon_comDate'] < $real_gap ? $real_gap : $DETAIL['freeicon_comDate'];
		}
		else
		{
			$DETAIL['freeicon_comDate']		= $DETAIL['freeicon_comDate'] < 0 ? 0 : $DETAIL['freeicon_comDate'];
		}

		#추가5개
		if ( $CONF['guin_uryo1_option'] == '기간별' )
		{
			$DETAIL['guin_uryo1']		= $DETAIL['guin_uryo1'] < $real_gap ? $real_gap : $DETAIL['guin_uryo1'];
		}
		else
		{
			$DETAIL['guin_uryo1']		= $DETAIL['guin_uryo1'] < 0 ? 0 : $DETAIL['guin_uryo1'];
		}
		if ( $CONF['guin_uryo2_option'] == '기간별' )
		{
			$DETAIL['guin_uryo2']		= $DETAIL['guin_uryo2'] < $real_gap ? $real_gap : $DETAIL['guin_uryo2'];
		}
		else
		{
			$DETAIL['guin_uryo2']		= $DETAIL['guin_uryo2'] < 0 ? 0 : $DETAIL['guin_uryo2'];
		}
		if ( $CONF['guin_uryo3_option'] == '기간별' )
		{
			$DETAIL['guin_uryo3']		= $DETAIL['guin_uryo3'] < $real_gap ? $real_gap : $DETAIL['guin_uryo3'];
		}
		else
		{
			$DETAIL['guin_uryo3']		= $DETAIL['guin_uryo3'] < 0 ? 0 : $DETAIL['guin_uryo3'];
		}
		if ( $CONF['guin_uryo4_option'] == '기간별' )
		{
			$DETAIL['guin_uryo4']		= $DETAIL['guin_uryo4'] < $real_gap ? $real_gap : $DETAIL['guin_uryo4'];
		}
		else
		{
			$DETAIL['guin_uryo4']		= $DETAIL['guin_uryo4'] < 0 ? 0 : $DETAIL['guin_uryo4'];
		}
		if ( $CONF['guin_uryo5_option'] == '기간별' )
		{
			$DETAIL['guin_uryo5']		= $DETAIL['guin_uryo5'] < $real_gap ? $real_gap : $DETAIL['guin_uryo5'];
		}
		else
		{
			$DETAIL['guin_uryo5']		= $DETAIL['guin_uryo5'] < 0 ? 0 : $DETAIL['guin_uryo5'];
		}

		$guin_banner1		= $DETAIL['guin_banner1'] + $guin_banner1;
		$guin_banner2		= $DETAIL['guin_banner2'] + $guin_banner2;
		$guin_banner3		= $DETAIL['guin_banner3'] + $guin_banner3;
		$guin_bold			= $DETAIL['guin_bold'] + $guin_bold;
		$guin_list_hyung	= $DETAIL['guin_list_hyung'] + $guin_list_hyung;
		$guin_pick			= $DETAIL['guin_pick'] + $guin_pick;
		$guin_ticker		= $DETAIL['guin_ticker'] + $guin_ticker;
		#배경색+아이콘 추가됨
		$guin_bgcolor		= $DETAIL['guin_bgcolor_com'] + $guin_bgcolor;
		$freeicon_comDate		= $DETAIL['freeicon_comDate'] + $guin_freeicon;
		#추가5개
		$guin_uryo1 = $DETAIL['guin_uryo1'] + $guin_uryo1;
		$guin_uryo2 = $DETAIL['guin_uryo2'] + $guin_uryo2;
		$guin_uryo3 = $DETAIL['guin_uryo3'] + $guin_uryo3;
		$guin_uryo4 = $DETAIL['guin_uryo4'] + $guin_uryo4;
		$guin_uryo5 = $DETAIL['guin_uryo5'] + $guin_uryo5;


		$sql = "update $guin_tb set
		guin_banner1 = '$guin_banner1',
		guin_banner2 = '$guin_banner2',
		guin_banner3 = '$guin_banner3',
		guin_bold  = '$guin_bold',
		guin_list_hyung   = '$guin_list_hyung',
		guin_pick   = '$guin_pick',
		guin_ticker = '$guin_ticker',
		guin_bgcolor_com = '$guin_bgcolor',
		freeicon_comDate = '$freeicon_comDate',
		guin_uryo1 = '$guin_uryo1',
		guin_uryo2 = '$guin_uryo2',
		guin_uryo3 = '$guin_uryo3',
		guin_uryo4 = '$guin_uryo4',
		guin_uryo5 = '$guin_uryo5'
		where number='$JANGBOO[links_number]'";
		#print $sql;
		#exit;
		query($sql);
	}

}





function pay_ok_package()
{
	global $oid,$jangboo,$jangboo2;

	//패키지결제추가됨 2011-06-20 kad
	global $job_money_package,$job_package;


	#장부에 해당저장정보를 읽어오자
	$sql = "select * from $jangboo where or_no='$oid' ";
	$result = query($sql);
	$JANGBOO = happy_mysql_fetch_array($result);

	$sql = "select * from $jangboo2 where or_no='$oid' ";
	$result = query($sql);
	$JANGBOO2 = happy_mysql_fetch_array($result);

	//개인회원용
	if ( $JANGBOO['number'] == "" && $JANGBOO2['number'] != "" )
	{
		$JANGBOO = $JANGBOO2;
		$jangboo = $jangboo2;
	}


	if ( $JANGBOO['number'] == "" )
	{
		return false;
	}

	if ( $JANGBOO['in_check'] == '1' )
	{
		return false;
	}


	#장부에 해당정보를 찍자
	$sql = "update $jangboo set in_check = '1' where or_no='$oid'";
	$result2 = query($sql);



	//패키지 결제
	if ( $JANGBOO['member_type'] == "100" || $JANGBOO['member_type'] == "200" )
	{
		$package = explode(",",$JANGBOO['goods_name']);
		if ( is_array($package) )
		{
			foreach($package as $p)
			{
				$tmp_details = "";

				$sql = "select * from $job_money_package where number = '$p'";
				$result = query($sql);
				$Package = happy_mysql_fetch_assoc($result);

				if ( $Package['number'] != "" )
				{
					$tmp_details = explode(",",$Package['uryo_detail']);

					foreach($tmp_details as $v)
					{
						$tmp_str = "";
						$tmp_option_name = "";
						$tmp_option_day = "";
						$tmp_option_cnt = "";
						$tmp_end_date = "";

						//유료옵션,옵션기간또는회수,사용회수
						list($tmp_option_name,$tmp_option_day,$tmp_option_cnt) = explode(":",$v);

						//패키지권 테이블에 넣자.
						for ($i=0;$i<$tmp_option_cnt;$i++)
						{
							$sql = "insert into $job_package set ";
							$sql.= "title = '".$Package['title']."',";
							$sql.= "id = '".$JANGBOO['or_id']."',";
							$sql.= "or_no = '".$JANGBOO['or_no']."',";
							$sql.= "option_name = '".$tmp_option_name."',";
							$sql.= "option_day = '".$tmp_option_day."',";
							$sql.= "reg_date = now(),";
							$sql.= "end_date = DATE_ADD( curdate(), INTERVAL '".$Package['end_day']."' DAY ),";
							$sql.= "use_date = '0000-00-00'";
							//echo $sql."<br>";
							query($sql);
						}
					}
				}
			}
		}
	}
	//패키지 결제



}



function pay_ok(){

	global $guin_tb,$oid,$jangboo2,$boodong_tb,$option_array_name, $per_document_tb,
	$last_date_read,$USER_ID,$CONF,$guin_tb,$ARRAY,$ARRAY_NAME,$ARRAY_NAME2,$jangboo2,$PER_ARRAY;
	global $PER_ARRAY_DB,$real_gap;
	global $happy_member,$happy_member_option_type;


	#장부에 해당저장정보를 읽어오자
	$sql = "select * from $jangboo2 where or_no='$oid' ";
	$result = query($sql);
	$JANGBOO = happy_mysql_fetch_array($result);


	if ($JANGBOO[in_check] == "1") {
		gomsg("이미 입금완료 처리된 내역입니다.   ",'happy_member.php?mode=mypage');
		exit;
	}

	if ($JANGBOO[number] == "") {
		gomsg("잘못된 접근입니다   ",'happy_member.php?mode=mypage');
		exit;
	}

	#날짜정보를 읽어서 업데이트를 실시한다.
	$GET_DAY = split(",",$JANGBOO[goods_name]);
	#장부에 해당정보를 찍자
	$sql = "update $jangboo2 set in_check = '1' where or_no='$oid'";
	$result2 = query($sql);


	######################### 결제성공 했으니 관련 처리 해줍시다 ############################
	if ( $JANGBOO['member_type'] == "0" )
	{
		$Sql		= "SELECT * FROM $per_document_tb WHERE number='$JANGBOO[links_number]' ";
		$Data		= happy_mysql_fetch_array(query($Sql));

		$SetSql		= "";
		$options	= explode(",",$JANGBOO["goods_name"]);

		if ( $JANGBOO["doc_skin"] != "" ) {
			$SetSql	.= ( $SetSql == "" )?"":",";
			$SetSql	.= " skin_html='$JANGBOO[doc_skin]' ";
		}
		if ( $JANGBOO["freeicon"] != "" ) {
			$SetSql	.= ( $SetSql == "" )?"":",";
			$SetSql	.= " freeicon='$JANGBOO[freeicon]' ";
		}

		$names		= $PER_ARRAY;
		$nowstamp	= happy_mktime();
		$nowDate	= date("Y-m-d H:i:s");

		for ( $i=0 , $max=sizeof($names) ; $i<$max ; $i++ )
		{
			if ( $options[$i] != "" )
			{
				$option	= explode(":",$options[$i]);

				$chkDate	= ( $Data[$names[$i]] < $nowDate )?$nowDate:$Data[$names[$i]];
				$chkDate	= explode(" ",$chkDate);
				$Dates		= explode("-", $chkDate[0]);

				#자유아이콘
				if ( $names[$i] == "freeiconDate" && $JANGBOO["freeicon"] == "" ) {
					$outDate = "";
				} else {
					$outDate	= date("Y-m-d 00:00:00",happy_mktime(0,0,0,$Dates[1],$Dates[2]+$option[0],$Dates[0]));
				}
				#자유아이콘
				$SetSql	.= ( $SetSql == "" )?"":",";
				$SetSql	.= $names[$i] ." = '$outDate' ";

				$$PER_ARRAY_DB[$i] = $outDate;
			}
		}

		$Sql	= "
					UPDATE
							$per_document_tb
					SET
							$SetSql
					WHERE
							number='$JANGBOO[links_number]'
		";

		//echo $Sql;


		query($Sql);
	}
	else
	{
		#추가된 회원결제
		$options	= explode(",",$JANGBOO["goods_name"]);

		$sql = "select * from ".$happy_member." where user_id = '".$JANGBOO['or_id']."' ";
		$result = query($sql);
		$MEM = happy_mysql_fetch_assoc($result);

		$MEM['guzic_view'] = happy_member_option_get($happy_member_option_type,$MEM['user_id'],'guzic_view');
		$MEM['guzic_view2'] = happy_member_option_get($happy_member_option_type,$MEM['user_id'],'guzic_view2');
		$MEM['guzic_smspoint'] = happy_member_option_get($happy_member_option_type,$MEM['user_id'],'guzic_smspoint');

		for ( $i=14;$i<=16;$i++ )
		{
			$option = "";
			$update_value = "";

			if ( $options[$i] != "" )
			{
				$field_name = $PER_ARRAY_DB[$i];
				$option	= explode(":",$options[$i]);
				if ( $i == 14 )
				{
					if ( $MEM['guzic_view'] <= $real_gap )
					{
						$update_value = $real_gap + $option[0];
					}
					else
					{
						$update_value = $MEM['guzic_view'] + $option[0];
					}
				}
				else
				{
					$update_value = $MEM[$field_name] + $option[0];
				}

				//echo $field_name.":".$update_value."<br>";
				happy_member_option_set($happy_member_option_type,$MEM['user_id'],$field_name,$update_value,'int(11)');
			}
		}

		$alert_msg = '옵션추가가 완료되었습니다.';
		#추가된 회원결제
	}

	################################### 처리 끝ㅌㅌㅌㅌ #####################################

}





function pay_point_ok()
{
	global $point_jangboo,$or_no,$main_url,$point_jangboo,$oid;
	global $happy_member;

	$or_no = $oid;

	if ($or_no == "")
	{
		gomsg("잘못된 접근방식입니다","$main_url");
		exit;
	}

	#장부를 업데이트 한다.
	$sql = "select * from $point_jangboo  where or_no='$or_no' ";
	$result = query($sql);
	$JANGBOO = happy_mysql_fetch_array($result);


	if ($JANGBOO[number] == "")
	{
		gomsg("포인트 장부에 해당내역이 존재하지 않습니다","$main_url");
		exit;
	}
	if ($JANGBOO[in_check] == "1")
	{
		gomsg("이미 입금완료된 내역입니다","$main_url");
		exit;
	}

	#장부입금자동처리
	$sql = "update $point_jangboo set in_check = '1'  where or_no='$or_no'";
	$result2 = query($sql);

	#회원포인트 업
	#포인트|결제금액 형식임
	$tmpPoint = explode("|",$JANGBOO['point']);
	$point_in = $tmpPoint[0];

	$sql = "update $happy_member set point =  point + '$point_in'  where user_id='$JANGBOO[id]'";
	$result2 = query($sql);

}

##############################결제결과DB업데이트 END##############################



?>