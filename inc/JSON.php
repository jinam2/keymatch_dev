<?php
include_once('happy_function.php');

$apache_ssl_all_use	= "";
/**********************************************
// $apache_ssl_all_use 설정 변경시
// /home/new3/www/inc/config.php
// /home/new3/crontab/songjang_update.php
// /home/new3/crontab/songjang_update2.php
// 도메인의 http:// -> https:// 로 변경 필요
**********************************************/
if ($apache_ssl_all_use != "")
{
	//$img_url	= str_replace("http:","https:",$img_url);
	//$main_url	= str_replace("http:","https:",$main_url);

	$ssl_port	= "443";

	if ( $_SERVER['HTTPS'] != "on" )
	{
		if(!preg_match("/axes_note_url/",$_SERVER['SCRIPT_NAME']) )
		{
			$https_go_url   = $main_url.":".$ssl_port.$_SERVER['REQUEST_URI'];
		}
	}
	if ( $https_go_url != "" )
	{
		header("Location: $https_go_url");
		exit;
	}
}


//메일 발송할때만 사용하는 변수.
$site_name2 = "リアルファブリック";

//현재접속자
#$session_dir = $org_path."community/data/session";
#session_save_path($session_dir);

@session_start();
/*
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
*/
Header("Content-type: text/html; charset=utf-8");
/*
$HTML_META_CACHE_NO		=<<<END
<meta http-equiv="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT">	<!-- 위의 명시된 날짜 이후가 되면 페이지가 캐싱되지 않습니다. -->
<meta http-equiv="Expires" content="-1">	<!-- 캐시된 페이지가 만료되어 삭제되는 시간을 정의합니다. 특별한 경우가 아니면 -1로 설정합니다. -->
<meta http-equiv="Pragma" content="no-cache">	<!-- 페이지 로드시마다 페이지를 캐싱하지 않습니다. (HTTP 1.0) -->
<meta http-equiv="Cache-Control" content="no-cache">	<!-- 페이지 로드시마다 페이지를 캐싱하지 않습니다. (HTTP 1.1) -->
END;
*/

//IE9 에서 위지윅 작동 되도록 IE8로 인식하도록
if( !preg_match("/multi_iframe.php/i",$_SERVER['SCRIPT_NAME']) && !preg_match("/multi_printing.php/i",$_SERVER['SCRIPT_NAME']) && !preg_match("/openmarket_jangboo_detail.php/i",$_SERVER['SCRIPT_NAME']) )
{
	#header('X-UA-Compatible: IE=EmulateIE8');
}

if(!preg_match("/fabrics_graph\.php/i",$_SERVER[SCRIPT_NAME]))
{
	@header('X-UA-Compatible: IE=EmulateIE8');
}
else
{
	@header('X-UA-Compatible: IE=edge');
}

$relative_path = preg_replace("`\/[^/]*\.php$`i", "/", $_SERVER['PHP_SELF']);
if($relative_path != "/admin/")
{
	//echo $_SERVER[SCRIPT_NAME];
	if($_SERVER[SCRIPT_NAME] != "/fabrics_graph.php" || $_SERVER[SCRIPT_NAME] != "/view_iframe.php")
	{
		@header('X-UA-Compatible: IE=edge');
	}
}
else
{
	//echo $relative_path;
	@header('X-UA-Compatible: IE=EmulateIE8');

	//관리자모드 회원 포인트 변동내역 레이어 팝업때문에 추가 - 2021-01-18 hong
	/*
	if(preg_match("/happy_member\.php\?type=add/i",$_SERVER['REQUEST_URI']))
	{
		@header('X-UA-Compatible: IE=edge');
	}
	else
	{
		@header('X-UA-Compatible: IE=EmulateIE8');
	}
	*/
}



error_reporting(E_ALL ^ E_NOTICE);

@ini_set("memory_limit",-1);
@ini_set("max_execution_time",600);
##########################################################################################
# HappyOpen Ver2.0 function.php
# Copyrightⓒ1997~2006 CGIMALL All rights reserved Powered By HappyCGI
# 본솔루션을 무단 복제시 법적인 제제를 받을수 있습니다.
# http://www.happycgi.com
# http://www.cgimall.co.kr
# 개발자 : 윤영웅
# 연락처 : webmaster@happycgi.com
# Last update : 2010.04.19
##########################################################################################


###############################################################################
//DB테이블이름 변수를 다른 곳에서 선언하지 말고 이곳에서 모두 선언할것

//DB테이블명의 PrefixName
$table_prefix_name = '';

//배너설정테이블
$happy_banner_tb		= $table_prefix_name.'happy_banner';
$happy_banner_log_tb	= $table_prefix_name.'happy_banner_log';
//상품 메인DB
$auction_product = $table_prefix_name."auction_product";
//오픈마켓 카테고리
$car_category = $table_prefix_name."auction_category";
//회원테이블
$per_tb = $table_prefix_name."auction_member";
//미니샵 테이블
$auction_minihome_tb = $table_prefix_name."auction_minihome";
//미니홈 테이블
$member_minihome = $table_prefix_name.'auction_minihome';
//게시판 리스트
$board_list = $table_prefix_name.'board_list';
//게시판 댓글
$board_short_comment = $table_prefix_name."board_short_comment";
//접속통계수집
$auction_stats = $table_prefix_name."auction_stats";
//장바구니 테이블
$auction_cart = $table_prefix_name."auction_cart";
//포인트 변경내역
$auction_point_jangboo  = $table_prefix_name."auction_point_jangboo ";
//우편번호 테이블
$zip_tb	= $table_prefix_name."auction_zip";
//찜상품 테이블
$car_zzim = $table_prefix_name."auction_zzim";
//예전투표 테이블
$car_vote = $table_prefix_name."auction_vote";
//환경설정 테이블
$car_conf = $table_prefix_name."auction_conf";
//팝업설정 테이블
$car_popup = $table_prefix_name."auction_popup";
//팝업설정 테이블
$auction_popup			= $table_prefix_name.'auction_popup';
//1:1문의 게시판 테이블
$board_onetoone = $table_prefix_name.'board_onetoone';
//오늘본 상품 테이블
$auction_today_view = $table_prefix_name.'auction_today_view';
//SMS인증번호 테이블
$auction_sms_confirm  = $table_prefix_name.'auction_sms_confirm';
//메일링 테이블
$mailing_tb				= $table_prefix_name.'auction_mailing';
//사업자정보 테이블
$auction_saupinfo = $table_prefix_name.'auction_saupinfo';
//상품정보 색상 사이즈 재고 추가금액
$auction_product_cate1 = $table_prefix_name.'auction_product_cate1';
$auction_product_cate2 = $table_prefix_name.'auction_product_cate2';
$auction_product_cate3 = $table_prefix_name.'auction_product_cate3'; #사용안함
$auction_product_cate4 = $table_prefix_name.'auction_product_cate4'; #사용안함
$auction_product_cate5 = $table_prefix_name.'auction_product_cate5'; #사용안함
//happy_config 관련 테이블
$happy_config		= $table_prefix_name.'happy_config';
$happy_config_group	= $table_prefix_name.'happy_config_group';
$happy_config_part	= $table_prefix_name.'happy_config_part';
$happy_config_field	= $table_prefix_name.'happy_config_field';

//부관리자 테이블
$admin_member = $table_prefix_name."auction_admin_member";
//실시간 인기검색어 테이블
$keyword_tb			= $table_prefix_name."auction_keyword";
//구글통계 수집 테이블
$happy_analytics_tb = $table_prefix_name.'happy_analytics';
//미니샾 카테고리테이블
$minihome_category = $table_prefix_name."minihome_category";

$auction_product_keyword	= $table_prefix_name.'auction_product_keyword';
//메인플래시배너 테이블
$auction_main_banner  = $table_prefix_name.'auction_main_banner';
//프로그램상 변수를 따로 쓰는곳이 있음
$main_banner_tb		= $auction_main_banner;

//?
$buy_tb = $table_prefix_name."buy_table";

//게시글중복추천방지로그 2010-04-14 kad
$board_pick_log = $table_prefix_name."board_pick_log";

//아이콘관리 2010-06-16 kad
$happy_icon_list		= $table_prefix_name.'happy_icon_list';
$happy_menu_conf		= $table_prefix_name.'happy_menu_conf';


//인기검색어드랍 2011-07-27 kad
$auto_search_tb = $table_prefix_name."auto_search_word";



############### 아이콘 관리 설정 ######################################################

$happy_org_path			= $org_path;					# 사이트 루트 서버경로
$skin_icon_folder		= 'img/skin_icon';				# 아이콘 PNG 업로드 폴더
$skin_icon_maker_folder	= 'img/skin_icon/make_icon';	# 생성된 아이콘 저장 폴더
$happy_icon_group		= Array(
								'그룹A',
								'그룹B',
								'그룹C',
								'그룹D',
								'그룹F'
						);								# 아이콘 그룹 지정

################################################################################

#위지윅 설정###################################################
$wys_url = '';
$garo_gi_joon = '800'; #상세상품설명 이미지 가로기준
$sero_gi_joon = '600'; #상세상품설명 이미지 세로기준
$file_attach_folder = "/wys2/file_attach";
$file_attach_thumb_folder = "/wys2/file_attach_thumb";
$gi_joon_ihc = '600'; //wys2 insertHtmlCode
###############################################################

#utf 글자자르기시 미리 조금더 잘라주기
$utf_add_cut = '12';
###############################################################
$picture_quality = '100'; #이미지화질 : 100 최상 , 0 최악


//만들어낼 섬네일 이미지의 화질 (0-100);
$server_info = getenv('HTTP_HOST');
if (preg_match("/cgimall/",$server_info) || preg_match("/aaa/",$server_info))
{
	#데모면 일단 100%준다
	$picture_quality		= '100';
}

#웹호스팅기준 기본 2M 임
$file_upload_limit = '100000';
###############################################################

$trust_folder			= 'upload/trust';

#새로운 배너관리툴 설정
$banner_folder_admin	= '../upload/banner';
$banner_folder			= 'upload/banner';
$banner_auto_addslashe	= '1';
$banner_no_banner_img	= 'img/no_banner.gif';

/*
//SSL 보안인증서 연동 - hong
$ssl_use		= "";
//$ssl_port		= "443";
$ssl_main_url	= $main_url;

if ( $ssl_use )
{
	$ssl_main_url	= str_replace("http://","",$ssl_main_url);
	$ssl_main_url	= str_replace("www.","",$ssl_main_url);
	$ssl_main_url	= "https://" . $ssl_main_url . ":" . $ssl_port;
}
*/

function ssl_return_url($url)
{
	return;
	global $main_url, $ssl_port;

	$url	= str_replace("https://","",$url);
	$url	= str_replace("www.","",$url);
	$url	= str_replace(":$ssl_port","",$url);
	$url	= str_replace(str_replace("www.","",$main_url),"",$url);

	if ( $url == "" || $url == "/" || $url == "./" )
	{
		return $main_url;
	}
	else
	{
		return $main_url . $url;
	}
}
//SSL 보안인증서 연동 - hong

include ('key.php');
include ('happy.php');
query("set names utf8");
include('happy_secret.php');
include ('secure.php');


$CONF		= load_config();

### 관리자모드 설정툴 관련 셋팅 ##############
$happy_config_auto_addslashe	= '1';
$happy_config_upload_folder		= 'upload/happy_config';	# 맨앞에 슬러쉬 없이 경로 작성. 끝에도 슬러쉬 없음. 폴더/폴더/폴더
function happy_config_loading()
{
	global $happy_config;
	global $HAPPY_CONFIG;

	$Sql	= "SELECT * FROM $happy_config ORDER BY number ASC";
	$Record	= query($Sql);

	while ( $Value = mysql_fetch_array($Record) )
	{
		if ( $Value['conf_out_type'] == 'array' )
		{
			$Value['conf_value']	= explode(",",$Value['conf_value']);
		}
		else if ( $Value['conf_out_type'] == 'nl2br' )
		{
			$Value['conf_value']	= nl2br($Value['conf_value']);
		}
		$GLOBALS[$Value['conf_name']]	= $Value['conf_value'];
		$HAPPY_CONFIG[$Value['conf_name']]	= $Value['conf_value'];
	}
}
happy_config_loading();


$_STORE_NUM	= array(
	'ko'	=> 1,
	'jp'	=> 2,
	'us'	=> 3
);


/*		국가정보 및 수차단위						*/
$geo_ip_table				= "realfabic_geoip";			//IP 대역별 국가코드가 저장하는 테이블

/*		111.1.1.1 의 아이디를 전달하면 111001001001 형태로 변환해 주는 함수이고 접속자의 아이피를 이용하여 아이피 범위 구간을 찾을때 사용한다.		*/
function ip_convert( $ip )
{
	if( $ip == '' ){
		return false;
	}

	$ip2					= 0;
	$ip_tmp					= explode(".",$ip);

	for( $i = 3, $j = 0 ; $i > 0 ; $i--, $j++ ){
		$point					= 1;
		for( $z = $i ; $z > 0 ; $z-- )
		{
			$point					= $point * 1000;
		}
		$ip2			+= $ip_tmp[$j] * $point;
	}
	$ip2			+= $ip_tmp[3];

	return $ip2;
}

function check_user_country()
{
	global $geo_ip_table, $cookie_url, $_NOW_LANGUAGE, $_STORE_NUM;

	$cookie_name_country	= "now_country";

	$_get_location	= '';
	if( $_GET['loc_chg'] != '' )
	{
		foreach( $_STORE_NUM AS $key => $val )
		{
			if( $key == $_GET['loc_chg'] )
			{
				$_get_location	= $_GET['loc_chg'];
			}
		}

		if( $_get_location != 'ok' )
		{
			setcookie($cookie_name_country,$_get_location,0,"/",$cookie_url);
			$_COOKIE[$cookie_name_country]	= $_get_location;

			echo "<script>location.replace(\"index.php\");</script>";
			exit;
		}
	}

	if( $_COOKIE[$cookie_name_country] != '' )
	{
		$_NOW_LANGUAGE	= $_COOKIE[$cookie_name_country];
		return;
	}

	#$_SERVER['REMOTE_ADDR'] = '113.29.0.0';

	$user_ip_point	= ip_convert( $_SERVER['REMOTE_ADDR'] );

	$Sql			= "SELECT * FROM {$geo_ip_table} WHERE {$user_ip_point} BETWEEN start_ip_point AND end_ip_point";
	$Result			= query($Sql);
	$DATA			= mysql_fetch_assoc($Result);

	if( $DATA['country_code'] == '' )		//국가를 알수 없는 상태이므로 ko 으로 처리한다.
	{
		setcookie($cookie_name_country,'ko',0,"/",$cookie_url);
		$_COOKIE[$cookie_name_country]	= 'ko';
	}
	else
	{
		$DATA['country_code']	= strtolower(str_replace("KR","KO",$DATA['country_code']));

		setcookie($cookie_name_country,$DATA['country_code'],0,"/",$cookie_url);
		$_COOKIE[$cookie_name_country]	= $DATA['country_code'];
	}
	$_NOW_LANGUAGE	= $_COOKIE[$cookie_name_country];
}

check_user_country();

//2016-08-22 sum커마(langue파일분리 작업)
#if(is_file($org_path."/lang/".$_NOW_LANGUAGE.".php") && is_file($org_path."/lang/".$_NOW_LANGUAGE."_html.php") && $_COOKIE['happy_mobile'] == 'on' )
if(is_file($org_path."/lang/".$_NOW_LANGUAGE.".php") && is_file($org_path."/lang/".$_NOW_LANGUAGE."_html.php") )
{
	//echo $org_path."lang/".$_NOW_LANGUAGE.".php";
	include($org_path."lang/".$_NOW_LANGUAGE.".php");
	include($org_path."lang/".$_NOW_LANGUAGE."_html.php");
}
else
{
	#msg("lang 파일을 호출할수없습니다. 파일을 확인해보시길 바랍니다.");
	#exit;
}
//2016-08-22 sum커마(langue파일분리 작업)


//print_r($HAPPY_CONFIG);
### 관리자모드 설정툴 관련 셋팅 ##############




#메인플래시 배너 변수들
$CONF['banner_total_use'] = $banner_total_use;					#배너총개수
$CONF['banner_rotation'] = $banner_rotation;						#배너로테이션속도
$CONF['banner_move'] = $banner_move;							#배너무빙속도
$CONF['banner_size_width'] = $banner_size_width;				#배너가로
$CONF['banner_size_height'] = $banner_size_height;				#배너세로
$CONF['banner_round'] = $banner_round;							#배너라운드여부
$CONF['banner_round_color'] = $banner_round_color;				#배너라운드색상
$CONF['banner_spaceX'] = $banner_spaceX;						#버튼의간격
$CONF['banner_btnalpha'] = $banner_btnalpha;						#버튼의 알파값
$CONF['banner_btnalign'] = $banner_btnalign;						#버튼출력위치
$CONF['banner_numcolor'] = $banner_numcolor;					#버튼의 색상

$working	= "";

//템플릿 파일 디렉토리
$skin_folder = "html"; #스킨폴더기본
$skin_folder_file = "html_file"; #스킨폴더 외부파일
$skin_folder_bbs = "html_bbs"; #스킨폴더 게시판

$server_character = "utf8";		//euckr or utf8 사용캐릭터셋


#################디자인 / 프로그램 디버깅용설정###################
//$query_print = ''; #프로그램 디버깅용 sql query printing
if( preg_match("/115\.93\.87\.16/i",$_SERVER["REMOTE_ADDR"]) )  //hun
{
	$bench_mark = ''; #프로그램 벤치마크용 sql query time check
}
$file_name_view_option = $CONF['template_view'];   #디자인작업시 템플릿파일확인용
//$file_name_view_option = 1;   #디자인작업시 템플릿파일확인용
$working = ''; #upgrade module
$ajax_sleep_time = '200000'; #0.2초 휴식 ^^;;; ajax로딩속도
###############################################################

#메인로고,카피라이트,워터마크 변경
$main_logo_folder	= "../img";
$copyright_logo_folder = "../img";
$water_logo_folder	= "../img/";


//사용되는 위치를 찾을수가 없는 변수들
$seller_send_no_point = "10"; #(사용되는 부분을 찾을수가 없음)
$member_img_size = '150'; #회원첨부사진 가로 사이즈 (사용되는 부분을 찾을수가 없음)
//사용되는 위치를 찾을수가 없는 변수들


#기타설정
$SCROLL[top100] = '65'; #메인 top100 상품 스크롤링
$SCROLL[main_ext] = '140'; #메인 추출 상품 스크롤링

$now_year= date("Y");
//$now_year = "20" . $now_year;


if (!$apache_ssl_use)
{
	//$main_ssl_url = $main_url;
}


#포인트장부 텍스트

$pay_type_msg = "商品の購入によるマイレージ積算";
//my_pay.php 파일에서 사용
$pay_type_msg2 = "商品の購入によるマイレージ使用";
//my_buy_send.php 파일에서 사용
$pay_type_msg3 = "購入キャンセルによるマイレージ積算";


//2016-05-19 sum서진요청(마일리지 장부 내용부분 텍스트 수정위치 통일)
$pay_type_msg4 = "フォトレビュー登録マイレージ積算";
$pay_type_msg5 = "レビュー登録マイレージ積算";
//my_buy_choice_write.php 파일에서 사용

$pay_type_msg6 = "デザイン登録料およびオプション料金";
//product_add_reg.php 파일에서 사용

$pay_type_msg7 = "デザイン登録料およびオプション料金(商品の修正)";
//modify.php파일에서 사용

$pay_type_msg8 = 'カード決済';
$pay_type_msg9 = '口座入金';
$pay_type_msg10 = '핸드폰결제';
$pay_type_msg11 = '振込み';
$pay_type_msg12 = 'コンビニ決済';
//my_point_charge_reg.php 파일에서 사용
//2016-05-19 sum서진요청(마일리지 장부 내용부분 텍스트 수정위치 통일)

//happy_member.php에서 사용
$pay_type_msg13 = '会員登録のマイレージ';
$pay_type_msg14 = $LANG['function'][pay_type_msg14];

#포인트장부 텍스트

$point_title_name = "マイレージ";


#팝업설정
//팝업카테고리설정
$popupMenuNames			= array($popupMenu1,$popupMenu2,$popupMenu3,$popupMenu4,$popupMenu5,$popupMenu6,$popupMenu7,$popupMenu8,$popupMenu9);
//$popupCloseCookieDate	= 3;
//$popupCloseCookieMsg	= '3일동안 이창을 다시 열지 않습니다.';
$popupLinkTypeName		= array("부모창","새창","현재창","상위프레임","최상위프레임");
$popupLinkTypeValue		= array(
								"부모창"		=> "opener.window.location.href='{{linkUrl}}';{{closeScript}}",
								"새창"			=> "window.open('{{linkUrl}}','_blank');{{closeScript}}",
								"현재창"		=> "window.location.href='{{linkUrl}}';{{closeScript}}",
								"현재창레이어"	=> "window.location.href='{{linkUrl}}';",
								"상위프레임"	=> "window.open('{{linkUrl}}','_parent');{{closeScript}}",
								"최상위프레임"	=> "window.open('{{linkUrl}}','_top');{{closeScript}};"
							);



//메일링 회원 검색 필드
$member_search_name		= Array("전체검색","아이디","이름","이메일","주소검색","상세주소검색");
$member_search_value	= Array("all","user_id","user_name","user_email","user_addr1","user_addr2");

$memtype_search_name	= Array("전체회원","일반회원","불량회원","우수회원","스페셜회원","입점업체회원");
$memtype_search_value	= Array("all","1","2","3","5","9");

$memtype_add_name		= Array("전체회원","활동회원","대기회원");
$memtype_add_value		= Array("all","0","1");

$member_prefix_name		= Array("성별검색","남성","여성");
$member_prefix_value	= Array("all","1","2");

$mailing_send_size		= 17;		// 메일발송시 몇명단위로 발송할건지 호출 주기 ( 기본값 : 37 )




#########################################################################################################################


$cookie_title = "OP";
$cookie_title_p = "RP";	#상품등록시 구분자


//메인 템플릿
$home_main = "main.html";

//카테고리 선택 리스트갯수
//$make_si_selectbox_size = '10';

//게시판 템플릿
$bbs_temp = "default.html";


//게시판 게시물 출력 개수
$bbs_pagenum = 15;


//부관리자 기능 (변경하지마십시오!!)
$adminMenuNames		= array(
									"디렉토리관리",
									"마켓상품관리",
									"신용도설정",
									"마켓장부관리",
									"포인트결제관리",
									"회원관리",
									"회원메일링",
									"게시판관리",
									"플래쉬|로고관리",
									"추천키워드",
									"접속통계보기",
									"투표설정",
									"환경설정",
									"팝업창설정",
									"편집관리", // Edit Management
									"tiff서버관리"
								);


#####################################################
############ 절대 건드리지 마세요.  #################
#####################################################

	$TemplateM_name	= Array(
							"공유디자인목록",
							"게시판보기",
							"하부카테고리강제출력",
							"배너",

							"팝업",
							"설문",
							"이미지",

							"카테고리출력",
							"회원폼",
							"로그인박스",
							"검색부분",
							"카테고리검색체크박스",

							"색상선택",
							"글자르기",
							"카피라이터",
							"롤링상품",
							"텍스트이미지",

							'HTML호출',
							'게시판목록추출',
							"슬라이드배너",
							"홈페이지즐겨찾기",

							'모달팝업',
	);

	$TemplateM_func	= Array(
							"auction_product_list",
							"board_extraction_list",
							"category_viewer",
							"echo happy_banner",

							"call_popup",
							"poll_read",
							"echo happy_image",

							"echo sub_category_view",
							"happy_member_user_form",
							"happy_member_login_form",
							"echo make_search_menu",
							"echo make_category_checkbox",

							"Color_Code",
							"Happy_StrCut",
							"call_copyright",
							"main_extraction_rolling",
							"happy_text_image",

							'main_top_menu',
							'board_keyword_extraction',
							"happy_banner_slide",
							"echo bookmark_addhome",

							'echo happy_modal_popup',
	);
#####################################################


#실시간인기검색어 설정
//$keyword_rank_day	= "355";		// 실시간검색 랭킹기준 일수
//$rankIcon_new		= "3";
//$rankIcon_up		= "1";
//$rankIcon_down		= "2";
//$rankIcon_equal		= "0";
//$rankIcon_new_color		= "FF0000";
//$rankIcon_up_color		= "0033FF";
//$rankIcon_down_color	= "AFAFAF";
//$rankIcon_equal_color	= "000000";
//$keyword_delete_day	= "365";	// 365일이 지난 실시간 데이타는 자동삭제 0일경우 자동 삭제 안함(계속보관).

#파일업로드 금지 확장자 배열(회원가입/수정시)
$FILEUPLOAD_DENY_EXT = array (	'0' => 'html',
												'1' => 'htm',
												'2' => 'php',
												'3' => 'cgi',
												'4' => 'inc',
												'5' => 'php3',
												'6' => 'pl'
											);


$dobae_number = '37595'; #도배방지를 위한 키숫자. 4자리이상입력 할것.




#주문취소시 재고증가로 인한 상품상태 변경 여부
#0 : 상품상태 변경안함 / 판매중지 -> 판매중지
#1 : 상품상태 변경됨 / 판매중지 -> 판매중
//$BuyCancelChangeStats = "1";

//디자인 상품 추출개수 2022-06-13 sunyoung (가로 수의 배수로 넣어야 함에 유의.)
$list_limit_size			= array("24","48","72","96");
$admin_not_login_display	= "none";

if ($_COOKIE['admin_id'] != "" && $_COOKIE['admin_id'] == $admin_id)
{
	$admin_not_login_display="";
}


#구글날씨 기본 지역설정
//$google_weather_area = 'Seoul';


#게시판 new 아이콘 날짜
$board_new_cut		= 1;

function load_config()
{
	global $car_conf;
	$Sql	= "Select * from $car_conf ";
	$Record	= query($Sql);

	while ( $Data = mysql_fetch_array($Record) )
	{
		$CONF[$Data["title"]]	= $Data["value"];
		//echo $Data["title"] ." - ". $CONF[$Data["title"]]."<br>";
	}

	return $CONF;
}

$main_logo_img = $info_logo;		#메인로고
$copyright_logo_img = $copyright;	#카피라이터
$logo_file = $logo;						#워터마크

//상품이미지에 합성할 로고
//$Logo_Img_Name = "./img/logo/my_logo.png";
$Logo_Img_Name = "./".$logo_file;


//회원이미지 업로드 디렉토리
$upload_member_img = "upload/member_img";


#아이디/비밀번호 찾기 타입 email : 메일발송 / phone : 휴대폰전송
$search_id_type = $HAPPY_CONFIG["search_id_type"];
#아이디 찾기시 사용할 sms 문자 포맷
$CONF_PHONE["lost_id_text"] = $HAPPY_CONFIG["lost_id_text"];
#비밀번호 찾기시 사용할 sms 문자 포맷
$CONF_PHONE["lost_pass_text"] = $HAPPY_CONFIG["lost_pass_text"];




### 상품삭제시 삭제대기로 갈것인지 여부
$product_wait_mode = "y";


#### 회원통합 관련 셋팅 #####################
include "function_happy_member.php";
##############################################





#로그인 체크 하자!		쿠키를 이용한 정보노출, 해킹 때문에 추가 하였습니다.
function login_check()
{
	global $happy_member,$happy_member_login_value_url,$admin_member,$admin_id,$admin_pw,$happy_member_login_value_name;

	if($_COOKIE[$happy_member_login_value_name] != '')
	{
		$Sql			= "
							SELECT
									user_pass
							FROM
									$happy_member
							WHERE
									user_id = '".addslashes($_COOKIE[$happy_member_login_value_name])."'
		";
		list($user_pass) = mysql_fetch_array(query($Sql));


		if($_COOKIE['shop_member_pass'] != $user_pass || $_COOKIE['shop_member_pass'] == '')
		{
			setcookie($happy_member_login_value_name,'',0,"/",$happy_member_login_value_url);
			setcookie("level",'',0,"/",$happy_member_login_value_url);
			//setcookie("shop_member_id",'',0,"/",$happy_member_login_value_url);
			setcookie("shop_member_pass",'',0,"/",$happy_member_login_value_url);

			go("./");
			exit;
		}
	}
	else if($_SESSION[$happy_member_login_value_name] != '')
	{
		$Sql			= "
							SELECT
									user_pass
							FROM
									$happy_member
							WHERE
									user_id = '".addslashes($_SESSION[$happy_member_login_value_name])."'
		";

		list($user_pass) = mysql_fetch_array(query($Sql));


		if($_COOKIE['shop_member_pass'] != $user_pass || $_COOKIE['shop_member_pass'] == '')
		{
			$_SESSION[$happy_member_login_value_name]	= "";
			session_destroy();

			setcookie("level",'',0,"/",$happy_member_login_value_url);
			setcookie("shop_member_pass",'',0,"/",$happy_member_login_value_url);

			go("./");
			exit;
		}
	}

	if( $_COOKIE['ad_id'] != '' )//ad_pass
	{
		if ( $_COOKIE['ad_id'] == $admin_id )					//슈퍼관리자일 경우...
		{
			if( $_COOKIE['ad_pass'] != md5($admin_pw) )
			{
				setcookie("ad_id","",0,"/",$happy_member_login_value_url);
				setcookie("ad_pass","",0,"/",$happy_member_login_value_url);

				go("./");
				exit;
			}
		}
		else													//부관리자일 경우
		{
			$Sql			= "
									SELECT
											pass
									FROM
											$admin_member
									WHERE
											id = '".addslashes($_COOKIE['ad_id'])."'
				";
			list($ad_pass)	= mysql_fetch_array(query($Sql));

			if( $_COOKIE['ad_pass'] != md5($ad_pass) || $_COOKIE['ad_pass'] == '' )
			{
				setcookie("ad_id","",0,"/",$happy_member_login_value_url);
				setcookie("ad_pass","",0,"/",$happy_member_login_value_url);

				go("./");
				exit;
			}
		}
	}
}

if($demo_lock == '')
{
	//login_check($happy_member_login_value_type);
}

$happy_admin_ipTable	= $DB_Prefix."happy_admin_ipTable";
$happy_admin_ipCheck	= '';		# on/off
$happy_admin_ip			= Array (
									'192.168',
);									# IP설정

//자동완성단어 레이어영역에 단어(줄)수
$자동완성수 = 8;

/********************************************************************************************************************
*		아래부터는 커스터마이징으로 인해 생성된 함수의 설정들 입니다.		변경하시기전 꼭 문의 해 주십시요.		*
********************************************************************************************************************/



//작업 내용 오픈 여부 hong
$custom_open				= true; //true or false

//썸네일 생성 및 원단 가로 변경시에 사용될 기본 Inch 이다.
$Default_Inch					= 8;
$Default_DPI					= 200;
$My_image_div_width				= 580;			//29
$My_image_div_width_in			= 560;			//29
$My_image_div_height			= 495;
$My_image_div_height_in			= 475;
$줄자최소길이					= 21;



$Layer_Option_name_Arr	= Array(
								"Centered",
								"Basic Repeat",
								"Half - Drop",
								"Half - Brick",
								"Mirror Repeat",
								);

//인쇄의 플로우
/*
$stats_print_text	= array(
						'인쇄전',
						'인쇄후',
						'후가공',
						'재인쇄요청',
						'승인완료'
					);
*/
$stats_print_text	= array(
						$LANG['function'][stats_print_text][인쇄전],
						$LANG['function'][stats_print_text][인쇄후],
						$LANG['function'][stats_print_text][후가공],
						$LANG['function'][stats_print_text][재인쇄요청],
						$LANG['function'][stats_print_text][승인완료]
					);

$stats_print_text_value	= array('100','200','300','400','500');

$stats_print_text_combine = array_combine($stats_print_text_value, $stats_print_text);

//발송전(발송요청) , 구매결정(발송중) 단계에서만 프린트상태를 검색하기 위해..
$print_use_stats		= Array('3','4');

$wait_setting			= "n";		//y로 변경하신 경우.. 등록시 바로 노출 됩니다.

//상품등록시 사용자가 선택 가능한 원단종류 갯수 설정
$user_select_fabircs_count	= 3;



//update auction_product set select_color = replace(select_color,'406f80','0a4681') where select_color like '%406f80%';
//패턴 디자인의 색상을 선택할 수 있는 기능.
$fabrics_color_Arr		= Array(
								"893f26",
								"957d37",
								"768b3e",
								"307b43",
								"2e967b",
								"1b799f",
								"0a4681",
								"402a7f",
								"823386",
								"aa145e",
								"a40025",
								"000000",
								"ff602c",
								"ffcb2a",
								"b3ef01",
								"06cc39",
								"09efb1",
								"2bc8ff",
								"2b5fff",
								"602bff",
								"c119ea",
								"eb3792",
								"d20001",
								"6a6a6a",
								"ffa181",
								"ffdf80",
								"d7f96e",
								"6def8f",
								"7fffde",
								"80dfff",
								"7fa0ff",
								"a080ff",
								"e270fc",
								"f377b5",
								"f4696c",
								"d9d9d9",
								"ffe9e1",
								"fef1ce",
								"eefbc5",
								"c6fdd5",
								"c0fdee",
								"c2f0ff",
								"c5d4ff",
								"d6cbfd",
								"f3bffd",
								"ffd3f4",
								"f8d0d1",
								"ffffff",






						);

//솜씨자랑 게시판에 글작성시 부여할 포인트
$board_boast_point		= 1000;


//관리자가 구매자에게 세금계산서를 발행시 사업자번호 등을 한명의 회원정보로 사용하기 위해 추가함.	hun
$default_seller_id = "test";



$deny_borad_file_type			= "*.php *.php3 *.php4 *.html *.inc *.js *.htm *.cgi *.pl"; # // 게시판 업로드 불가형식


$택배사운임기본비용				= "2500";



//금액계산에서 서진에서는 뒷자리 백원단위는 날려 달라고하셔서 설정으로 빼둠. view.php , ajax_view.php , view_bid_reg.php => 일본사이트에선 사용안한다고함.
$cut_price					= 1;




$slide_banner_conf				= "slide_banner_conf";
$slide_banner					= "slide_banner";
$links							= "links";


//영수증 발행기능 때문에 사업자 번호를 1개의 회원으로 지정함.
$target_saupinfo			= "realfd";


#2016-04-12 sum커마(장바구니, 위시리스트 보관기간 설정.)
//$HAPPY_CONFIG['auto_basket_delete_day']		= "1";			//장바구니에 담긴 상품이  x일 이 지나면 자동으로 삭제가 됩니다.
//$HAPPY_CONFIG['auto_wish_delete_day']		= "1";			//위시리스트에 담긴 상품이 x일 이 지나면 자동으로 삭제가 됩니다.

# 문자열 자르기
function kstrcut($str,$len,$tail='') {
     $len = preg_replace("/\D/",'',$len);
     $pattern = array('/<!--(.*?)-->/s', '/<script[>]*?>(.*?)<\/script>/is', '/<style[>]*?>(.*?)<\/style>/is', '/<(.*?)>/s');
     $str = preg_replace($pattern, '', $str);

    $c = substr(str_pad(decbin(ord($str{$len})),8,'0',STR_PAD_LEFT),0,2);
    if ($c == '10')
        for (;$c != '11' && $c{0} == 1;$c = substr(str_pad(decbin(ord($str{--$len})),8,'0',STR_PAD_LEFT),0,2));
    return @substr($str,0,$len) . (strlen($str)-strlen($tail) >= $len ? $tail : '');
}


//팝빌전자 세금계산서API 2014-07-11 kad
function popbill_load()
{
	global $LinkID;
	$popbill_load = "";
	if ( file_exists('popBill/PopbillTaxinvoice/PopbillTaxinvoice.php') )
	{
		require_once 'popBill/PopbillTaxinvoice/PopbillTaxinvoice.php';
		$popbill_load = "1";
	}
	else if ( file_exists('../popBill/PopbillTaxinvoice/PopbillTaxinvoice.php') )
	{
		require_once '../popBill/PopbillTaxinvoice/PopbillTaxinvoice.php';
		$popbill_load = "1";
	}

	if ( $popbill_load == "1" )
	{
		$LinkID = 'CGIMALLSOL';
		$SecretKey = 'baYR6JuQB1FQlM1sZTcYUOgv8C75rAiMNNPTtwY3bEw=';
		$TaxinvoiceService = new TaxinvoiceService($LinkID,$SecretKey);
		$SecretKey = '';
	}

	return $TaxinvoiceService;
}

if( $mem_id == 'happycgi' )
{
	//$custom_playing			= true;			//2015-11-09	hun 커스터마이징
}
$custom_playing			= true;			//2015-11-09	hun 커스터마이징


/*
echo "<pre>";
print_r($jp_zip_disallow_addr);
exit;
*/



//2016-06-15 sum서진요청(비회원=> 일본명칭으로 변경요청에따른 function.php에 글로벌선언)
$no_member_name = "非会員";

//2016-07-15 sum서진요청(광고KPI지표 스크립트삽입)
/*
광고코드 등 스크립트 삽입시에 아래에 추가만해주시면 사용처에 자동으로 입력됩니다.
$AD_INDICATOR_SCRIPT['joinus_reg']			회원가입성공시
$AD_INDICATOR_SCRIPT['order_success']		주문성공시
*/

$ADD_INDICATOR_SCRIPT['joinus2']		= "
	<!--2016-07-26 서진요청 (구글에널리스틱 추적코드삽입)-->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-32315635-62', 'auto');
	  ga('send', 'pageview');
	</script>
	<!--2016-07-26 서진요청 (구글에널리스틱 추적코드삽입)-->


";

$ADD_INDICATOR_SCRIPT['joinus2_click_event'] =" onclick=\"ga('send','event','회원가입페이지', 'Click', '회원가입완료');\"";


$ADD_INDICATOR_SCRIPT['common']			= "

<script type='text/javascript'>
/* <![CDATA[ */
var google_conversion_id = 833188935;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type='text/javascript' src='//www.googleadservices.com/pagead/conversion.js'>
</script>
<noscript>
<div style='display:inline;'>
<img height='1' width='1' style='border-style:none;' alt='' src='//googleads.g.doubleclick.net/pagead/viewthroughconversion/833188935/?guid=ON&amp;script=0'/>
</div>
</noscript>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '139226283382970');
  fbq('track', 'PageView');
</script>
<noscript><img height='1' width='1' style='display:none'
  src='https://www.facebook.com/tr?id=139226283382970&ev=PageView&noscript=1'
/></noscript>
<!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Ads: 878207896 -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=AW-878207896\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-878207896');
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src='https://www.googletagmanager.com/gtag/js?id=G-XMSVFMVFVK'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-XMSVFMVFVK');
</script>

<!-- Yahoo -->
<script async src='https://s.yimg.jp/images/listing/tool/cv/ytag.js'></script>
<script>
window.yjDataLayer = window.yjDataLayer || [];
function ytag() { yjDataLayer.push(arguments); }
ytag({'type':'ycl_cookie'});
</script>

<!-- LINE Tag Base Code -->
<!-- Do Not Modify -->
<script>
(function(g,d,o){
  g._ltq=g._ltq||[];g._lt=g._lt||function(){g._ltq.push(arguments)};
  var h=location.protocol==='https:'?'https://d.line-scdn.net':'http://d.line-cdn.net';
  var s=d.createElement('script');s.async=1;
  s.src=o||h+'/n/line_tag/public/release/v1/lt.js';
  var t=d.getElementsByTagName('script')[0];t.parentNode.insertBefore(s,t);
    })(window, document);
_lt('init', {
  customerType: 'lap',
  tagId: '988b857a-abc7-41b7-8a3a-c6680ab3bde3'
});
_lt('send', 'pv', ['988b857a-abc7-41b7-8a3a-c6680ab3bde3']);
</script>
<noscript>
  <img height='1' width='1' style='display:none'
       src='https://tr.line.me/tag.gif?c_t=lap&t_id=988b857a-abc7-41b7-8a3a-c6680ab3bde3&e=pv&noscript=1' />
</noscript>
<!-- End LINE Tag Base Code -->


";

$google_login_track .= $ADD_INDICATOR_SCRIPT['common'];							//해더에 있어야한다는 프리미엄로그측의 답변으로 일단 여기에 넣음.


$ADD_INDICATOR_SCRIPT['joinus_reg']		= "
	<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
	<!-- Yahoo Code for your Conversion Page -->
	<script type='text/javascript'>
        /* <![CDATA[ */
        var yahoo_conversion_id = 1000406776;
        var yahoo_conversion_label = '0t6QCO-g2HUQ_-KkjQM';
        var yahoo_conversion_value = 0;
        /* ]]> */
    </script>
    <script type='text/javascript' src='https://s.yimg.jp/images/listing/tool/cv/conversion.js'>
    </script>
    <noscript>
        <div style='display:inline;'>
            <img height='1' width='1' style='border-style:none;' alt='' src='https://b91.yahoo.co.jp/pagead/conversion/1000406776/?value=0&label=0t6QCO-g2HUQ_-KkjQM&guid=ON&script=0&disvt=true'/>
        </div>
    </noscript>
    <script type='text/javascript' language='javascript'>
	  /* <![CDATA[ */
	  var yahoo_ydn_conv_io = 'ehgUQw0OLDWbL_JGcn9L';
	  var yahoo_ydn_conv_label = 'JLPIAGUSJPJWBZU5QEU412597';
	  var yahoo_ydn_conv_transaction_id = '';
	  var yahoo_ydn_conv_amount = '0';
	  /* ]]> */
	</script>
	<script type='text/javascript' language='javascript' charset='UTF-8' src='https://b90.yahoo.co.jp/conv.js'></script>

    <!-- Google Code for &#20250;&#21729;&#30331;&#37682; Conversion Page -->
	<script type='text/javascript'>
    /* <![CDATA[ */
    var google_conversion_id = 833188935;
    var google_conversion_language = 'en';
    var google_conversion_format = '3';
    var google_conversion_color = 'ffffff';
    var google_conversion_label = 'T1KiCKSj2HUQx-iljQM';
    var google_remarketing_only = false;
    /* ]]> */
    </script>
    <script type='text/javascript' src='//www.googleadservices.com/pagead/conversion.js'>
    </script>
    <noscript>
    <div style='display:inline;'>
    <img height='1' width='1' style='border-style:none;' alt='' src='//www.googleadservices.com/pagead/conversion/833188935/?label=T1KiCKSj2HUQx-iljQM&amp;guid=ON&amp;script=0'/>
    </div>
    </noscript>

    <script>
　  fbq('track', 'CompleteRegistration');
　　</script>

	<!-- Event snippet for JP_회원가입 conversion page -->
	<script>
	  gtag('event', 'conversion', {'send_to': 'AW-878207896/7bxLCKOq1dUBEJjH4aID'});
	</script>

	<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
";


$ADD_INDICATOR_SCRIPT['order_success']	= "
	<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
	<!-- Yahoo Code for your Conversion Page -->
	<script type='text/javascript'>
        /* <![CDATA[ */
        var yahoo_conversion_id = 1000406776;
        var yahoo_conversion_label = 'QrImCNrExXUQ_-KkjQM';
        var yahoo_conversion_value = 0;
        /* ]]> */
    </script>
    <script type='text/javascript' src='https://s.yimg.jp/images/listing/tool/cv/conversion.js'>
    </script>
    <noscript>
        <div style='display:inline;'>
            <img height='1' width='1' style='border-style:none;' alt='' src='https://b91.yahoo.co.jp/pagead/conversion/1000406776/?value=0&label=QrImCNrExXUQ_-KkjQM&guid=ON&script=0&disvt=true'/>
        </div>
    </noscript>
    <script type='text/javascript' language='javascript'>
	  /* <![CDATA[ */
	  var yahoo_ydn_conv_io = 'ehgUQw0OLDWbL_JGcn9L';
	  var yahoo_ydn_conv_label = 'NO0I4PYQFHJAVSSLKRG412596';
	  var yahoo_ydn_conv_transaction_id = '';
	  var yahoo_ydn_conv_amount = '0';
	  /* ]]> */
	</script>
	<script type='text/javascript' language='javascript' charset='UTF-8' src='https://b90.yahoo.co.jp/conv.js'></script>


	<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

	<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
	<!-- Google Code for &#36092;&#20837; Conversion Page -->
	<script type='text/javascript'>
    /* <![CDATA[ */
    var google_conversion_id = 833188935;
    var google_conversion_language = 'en';
    var google_conversion_format = '3';
    var google_conversion_color = 'ffffff';
    var google_conversion_label = 'TTtdCIji3XUQx-iljQM';
    var google_remarketing_only = false;
    /* ]]> */
    </script>
    <script type='text/javascript' src='//www.googleadservices.com/pagead/conversion.js'>
    </script>
    <noscript>
    <div style='display:inline;'>
    <img height='1' width='1' style='border-style:none;' alt='' src='//www.googleadservices.com/pagead/conversion/833188935/?label=TTtdCIji3XUQx-iljQM&amp;guid=ON&amp;script=0'/>
    </div>
    </noscript>
	<!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <script>
　　  fbq('track', 'Purchase');
　　</script>

	<script>
	ga('require', 'ecommerce', 'ecommerce.js');

	ga('ecommerce:addTransaction', {
	  'id': '%주문번호%', // 시스템에서 생성된 주문번호. 필수.
	  'revenue': '%구매금액%' // 구매총액. 필수.
	});
	ga('ecommerce:addItem', {
	  'id': '%주문번호%', //시스템에서 생성된 주문번호. 필수.
	  'name': 'Fablic', // 제품명. 필수.
	  'sku': '', // SKU 또는 제품고유번호. 선택사항.
	  'category': 'Fabric', // 제품 분류.
	  'price': '%구매금액%', // 제품 단가.
	  'quantity': '1' // 제품 수량.
	});

	ga('ecommerce:send');
	</script>

	<!-- Event snippet for JP_주문완료 conversion page -->
	<script>
	  gtag('event', 'conversion', {
		  'send_to': 'AW-878207896/g4l1CLmTx9UBEJjH4aID',
		  'value': '%구매금액%',
		  'currency': 'JPY',
		  'transaction_id': '%주문번호%'
	  });

	  gtag('event', 'purchase', {
		  'transaction_id': '%주문번호%',
		  'currency': 'JPY',
		  'value': %구매금액%
	  });

	</script>

	<!-- naver line Conversion -->
	<script>
	_lt('send', 'cv', {
	  type: 'Conversion'
	},['988b857a-abc7-41b7-8a3a-c6680ab3bde3']);
	</script>

";
//2016-07-15 sum서진요청(광고KPI지표 스크립트삽입)



// 커스터마이징 2017-05-18 x2chi 상품문의리스트 - 커뮤니티 DB;
$new_community		= "new3_community";



//2017-02-13 sum(모바일 작업 - 게시판연동)
//공지사항, FAQ, QNA
$community_target_board = array(
								"customer_notice"	=> "board_notice",
								"customer_faq"		=> "board_faq",
								"customer_qna"		=> "board_qna"
);

$board_count_day				= 3;										# 조회수 중복 카운팅 방지 체크 일수
//2017-02-13 sum(모바일 작업 - 게시판연동)





#$allow_joinus_member_array	= array("14", "16", "27", "28","29");
$allow_joinus_member_array	= array("14", "16");
$group_number_convert_array	= array(
								"14"					=> "24",			//일반회원
								"16"					=> "25"			//디자이너회원
								#"27"					=> "30",			//골드회원
								#"28"					=> "31",			//플레티넘회원
								#"29"					=> "32"				//VIP회원
);

$wt3d_use					= true;			//false 는 미사용, true 는 사용
$auction_product_wt3d		= "auction_product_wt3d";

if( $_NOW_LANGUAGE == 'jp' )
{
	$wt3d_category				= 53;						//2차 카테고리번호이며 한국 카테고리를 뜻함.
	$wt3d_fabirc_category		= 76;						//패턴 등록 카테고리 한국은 75, 일본은 76
	$wt3d_CURLOPT_TIMEOUT		= 20;
}
else if( $_NOW_LANGUAGE == 'us' )
{
	$wt3d_category				= 50;						//2차 카테고리번호이며 한국 카테고리를 뜻함.
	$wt3d_fabirc_category		= 75;						//패턴 등록 카테고리 한국은 75, 일본은 76
	$wt3d_CURLOPT_TIMEOUT		= 70;
}
else
{
	$wt3d_category				= 50;						//2차 카테고리번호이며 한국 카테고리를 뜻함.
	$wt3d_fabirc_category		= 75;						//패턴 등록 카테고리 한국은 75, 일본은 76
	$wt3d_CURLOPT_TIMEOUT		= 10;
}

$wt3d_default_url			= "http://211.37.176.228:7000";
$wt3d_save_fabric_url		= "http://211.37.176.228:7000/api/save_fabric";
$wt3d_delete_fabric_url		= "http://211.37.176.228:7000/api/delete_fabric";
$wt3d_simulation_url		= "http://211.37.176.228:7000/api/simulation";

$wt3d_simulation_path		= $org_path."simulation";

// 입점사 관리
$store_mgmt					= "store_mgmt";
// 각 입점사 카테고리와 현 사이트 카테고리 매칭
$auction_category_set		= "auction_category_set";

$_NOW_Y			= date("Y");
$_NOW_M			= date("m");
$_NOW_D			= date("d");
$_NOW_MKTIME	= happy_mktime();

//2016-08-30 sum커마(서진랭파일분리작업)
function lang_convert($str)
{
	global $LANG, $LANG_HTML;

	//가변 번역		=> ex 작업전) echo "현재함수는 커버팅함수 $i 의 예제중하나입니다.";
	//				=> ex 작업후) echo lang_conver($LANG[쇼핑몰][예제]);
	if( preg_match("/%(.*?)%/",$str) )
	{
		$str_array				= array();
		$replace_str_array		= array();
		$replace_str_array_2	= array();

		preg_match_all("/%(.*?)%/", $str, $matches);

		$str_array = $matches[1];

		foreach( $str_array as $k => $v )
		{
			$str_array[$k] = str_replace("%","",$v);

			//배역인지검사
			if(preg_match( "/\[(.*?)\]/", $v))
			{
				preg_match_all("/\[(.*?)\]/", $v, $matches2);
				$period = $matches2[1][0];

				$v = str_replace("[".$period."]","",$v);
				global ${$v};
				$replace_str_array["%".$v."[".$period."]%"] = ${$v}[$period];
			}
			else
			{
				global ${$v};
				$replace_str_array["%".$v."%"] = ${$v};
			}
		}

		foreach( $replace_str_array as $k2 => $v2 )
		{
			$str = str_replace($k2, $v2, $str);
		}
	}

	return $str;
}
//2016-08-30 sum커마(서진랭파일분리작업)



$mini_bbs_array_value = array($DB_Prefix.'board_mini_gallery',$DB_Prefix.'board_mini_board',$board_detail_gallery,$DB_Prefix.'board_calendar');


?>