<?php

$js_make_date = '20220801';			# js/default.css?ver={{js_make_date}}
$css_make_date = '20220801';		# css/style.css?ver={{css_make_date}}

$apache_ssl_all_use = '1';
$ssl_port = "443";
$ssl_domain = str_replace("http://","",$main_url);
$ssl_domain_array = explode("/",$ssl_domain);
$main_ssl_url = "https://".$ssl_domain_array[0].":".$ssl_port; #SSL 주소 및 포트
if (!$apache_ssl_use) { $main_ssl_url = $main_url; }

###########################################################################
include("config_server.php"); //서버세팅 관련 소스
include("happy_config_maker.php"); //happy_config 생성
include ('key.php');
include ('happy.php');
include('happy_secret.php');
include ('secure.php');
include('function_connect.php'); //현재접속자
if($HAPPY_CONFIG_FILE_SAVE && function_exists('HAPPY_CONFIG_FILE'))
	HAPPY_CONFIG_FILE(1);
// woo TEST
if( $_SERVER["REMOTE_ADDR"] ==  "115.93.87.163")
{
$HAPPY_CONFIG['template_view'] = $template_view = '';
}

//헤드헌팅
$hunting_use		= ( $happy_hunting_use == '' ) ? false : true; //헤드헌팅 사용유무 , true OR false



#포인트 충전 및 장부 사용여부 - sun
$HAPPY_CONFIG['point_charge_jangboo_use'] == "";
if ($HAPPY_CONFIG['point_charge_use'] == "none" && $HAPPY_CONFIG['point_jangboo_use'] == "none")
{
	$HAPPY_CONFIG['point_charge_jangboo_use'] = "none";
}



//TABLE variables
$admin_tb			= "job_admin";
$admin_member		= "job_admin_member";
$conf_table			= "job_conf";
$vote_tb			= "job_vote";
//$com_tb				= "job_com_member";
//$per_tb				= "job_per_member";

$guin_banner_tb		= "guin_banner";
$zip_tb				= "job_zip";
$area_tb			= "job_area";
$guin_tb			= "job_guin";
$guin_stats_tb		= "job_guin_stats";
$si_tb				= "job_si";
$gu_tb				= "job_si_gu";
$dong_tb			= "job_si_gu_dong";
$type_tb			= "job_type";
$type_sub_tb		= "job_type_sub";
$type_sub_sub_tb	= "job_type_sub_sub";	// 3차
//$guzic_tb			= "job_guzic";
$jangboo			= "job_jangboo";
$jangboo2			= "job_jangboo2";
$per_document_tb	= "job_per_document";
$per_academy_tb		= "job_per_academy"; // 학력사항
$per_career_tb		= "job_per_career"; // 경력사항
$per_worklist_tb	= "job_per_worklist";
$per_skill_tb		= "job_per_skill";
$per_language_tb	= "job_per_language";
$per_yunsoo_tb		= "job_per_yunsoo";
//$per_mylist_tb		= "job_per_mylist";				#개인맞춤구직테이블
$per_file_tb		= "job_per_file";				#개인이미지 테이블
$com_guin_per_tb	= "job_com_guin_per";			#구인에 이력서 신청 테이블
$com_want_doc_tb	= "job_com_want_doc";			#기업회원이 특정 이력서(개인회원)에게 입사지원요청 하는 테이블
$scrap_tb			= "job_scrap";					#개인,기업 스크랩 테이블
$job_com_doc_view_tb= "job_com_doc_view";		#이력서 회수별보기가능 테이블
$job_per_guin_view_tb= "job_per_guin_view";			#채용정보 회수별보기가능 테이블
$job_main_banner_tb = 'job_main_banner';			#메인플래쉬 테이블
$job_underground_tb	= 'job_underground';			#역세권 테이블
$per_noViewList		= "job_per_noViewList";
$board_list			= "board_list";
$board_short_comment= "board_short_comment";
$board_top_gonggi	= "board_top_gonggi";
$keyword_tb			= "job_keyword";
$happy_banner_tb		= 'happy_banner';
$happy_banner_log_tb	= 'happy_banner_log';
$happy_icon_list		= 'happy_icon_list';
$happy_menu_conf		= 'happy_menu_conf';
$upso2_poll_1		= 'job_poll_1';
$upso2_poll_2		= 'job_poll_2';
#중복투표방지로그 2010-02-10 kad
$upso2_poll_log		= 'job_poll_log';
#구인에 이력서 신청 테이블 상태 변경내역테이블
$com_guin_per_tb_log	= "job_com_guin_per_log";
#이메일 입사지원 로그 테이블
$job_email_jiwon_log	= "job_email_jiwon_log";

#회원가입 관련 별도 껍데기 템플릿파일 설정
$happy_member_default2_template		= "happy_member_default.html";
$auction_weather_info	= 'auction_weather_info';

//인기검색어드랍 2011-07-27 kad
$auto_search_tb = "auto_search_word";

//2010-10-12 hun 관리자모드 퀵메뉴 기능추가
$happy_quick_menu		= "happy_quick_menu";

$per_want_doc_tb	= "job_per_want_doc";			#기업회원이 특정 이력서(개인회원)에게 면접제의요청 하는 테이블

//채용정보 점프내역
$job_guin_jump = "job_guin_jump";

$stats_tb			= "job_stats";					#사용하는 테이블명

#팝업기능 추가
$happy_popup = "happy_popup";

#메일링
$happy_mailing = 'happy_mailing';

#쪽지기능 설정
$message_tb			= 'happy_message';				#쪽지 DB 테이블명 입력 -> message_ajax.php 파일에도 설정해야합니다.

#포인트장부
$point_jangboo  = "point_jangboo";

#맞춤인재검색테이블
$job_com_want_search = "job_com_want_search";
#맞춤구인검색테이블
$job_per_want_search = "job_per_want_search";

#통계테이블
$happy_analytics_tb = 'job_analytics';

//회사로고 배경이미지테이블
$logo_bgimage_list = "logo_bgimage_list";
$logo_bgimage_folder = "upload/logo_bgimage";
//선택가능한 폰트들
$logo_bgimage_fonts = array("arial","JejuGothic","JejuHallasan","NanumBrush","NanumGothic",
							"NanumGothicBold","NanumGothicExtraBold","NanumMyeongjo","NanumMyeongjoBold","NanumMyeongjoExtraBold",
							"NanumPen","SeoulHangangB","SeoulHangangEB","SeoulHangangL","SeoulHangangM",
							"SeoulNamsanB","SeoulNamsanEB","SeoulNamsanL","SeoulNamsanM","SeoulNamsanvert");


$recomment_depth = 2;	# 대댓글 sikim9201


$sql	= "select * from $admin_tb where number='1'";
$result	= query($sql);	list($admin_number,$admin_id,$admin_pw,$admin_email,$admin_name,$bbs_ad_id,$bbs_ad_pw,$main_url2,$pagenum,$mainnum,$gu_mainnum,$prev_stand,$pay_guin,$main2,$default,$info,$guin_list,$guzic_list,$bbs,$admin_date,$admin_etc1,$admin_etc2,$admin_etc3,$admin_etc4,$admin_etc5)	= mysql_fetch_row($result);



//관리자에게 쪽지//
$관리자쪽지 = "window.open('happy_message.php?mode=send&receiveid=$admin_id&receiveAdmin=y','happy_message','width=700,height=500,toolbar=no,scrollbars=no')";


//패키지유료설정테이블
$job_money_package		= 'job_money_package';
$job_package			= 'job_package';
$job_jangboo_package	= 'job_jangboo_package';

//패키지즉시적용
$job_money_package2		= 'job_money_package2';

#문의하기 폼설정 추가 - hong
$happy_inquiry					= 'happy_inquiry';
$happy_inquiry_form				= 'happy_inquiry_form';
$happy_inquiry_comment			= 'happy_inquiry_comment';
$happy_inquiry_links			= $guin_tb;
$happy_inquiry_upload_folder	= 'upload/inquiry_image';

$happy_inquiry_stats_array		= Array(
										0 => "접수중",
										1 => "접수확인",
										2 => "처리중",
										3 => "답변완료",
										4 => "답변보류",
										5 => "연락불능"
								);
$happy_mail_send_type		= 'default';							# 메일 발송시 mail()함수 이용 : default
																# 메일 발송시 직접 sendmail 실행시 : direct

# 관리자모드 메뉴 설정
$admin_menu				= 'job_admin_menu';

// 추천인  - 16.10.17 x2chi 이전
$recommend_join		= "recommend_join";
#추천인 기능에 사용될 GET값 - 13.01.16 hong 추가
$recommend_get_id	= "reco";

//채용정보 열람 사용자 인원수 체크 hong
$guin_detail_view_log	= "job_guin_detail_view_log";

# 메뉴 관리툴 추가 hong
$happy_menu						= 'happy_menu';
# 메뉴 아이콘 그룹지정 (최대 10개)
$happy_menu_icon_group			= Array('대메뉴아이콘');
# 메뉴 아이콘 저장경로
$happy_menu_icon_group_folder	= 'upload/menu_icon';


#기존설정
conf_read();



### 출석게시판 추가 ralear
$calendar_view_tb = "calendar_view";
$calendar_dojang_tb = "calendar_dojang";
$calendar_dojang_point = $HAPPY_CONFIG['calendar_dojang_point']; //출석도장설정 포인트


#기존 $CONF에서 참조하던 값을 happy_config 의 데이터로 교체함 2009-11-12 kad
$CONF['site_phone'] = $site_phone;								#SMS발신번호
$CONF['sms_userid'] = $sms_userid;								#SMS아이디
$CONF['sms_testing'] = $sms_testing;							#SMS사용방식(정상,테스트)
$CONF['sms_send_option'] = $sms_send_option;				#SMS사용여부(사용,안함)

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


#추천키워드
$CONF['pick_keyword'] = $pick_keyword;			#추천키워드
$CONF['pick_keyword_size'] = $pick_keyword_size;	#추천키워드 출력개수
$CONF['pick_keyword_setting'] = $pick_keyword_setting;		#추천키워드 출력형식(랜덤,차례)
$CONF['pick_gubun'] = $pick_keyword_gubun;					#추천키워드출력 구분자 (,)
$CONF['pick_color'] = $pick_keyword_color;

#echo $HAPPY_CONFIG['MessageSendPoint'];				#쪽지발송시 차감할 포인트

#유료결제
$CONF['m_id'] = $m_id;									#상점아이디
$uryo_title = $product_title;				#유료결제타이틀

$bench_mark = '';
$CONF['template_view'] = $template_view;						#템플릿 파일명 보기
$CONF['bench_mark'] = $bench_mark;							#쿼리출력

$CONF['money_bank'] = $money_bank;				#무통장입금계좌정보
$계좌정보 = nl2br($CONF['money_bank']);

$CONF['bank_conf'] = $HAPPY_CONFIG['bank_conf'];							#실시간계좌이체
$CONF['card_conf'] = $HAPPY_CONFIG['card_conf'];							#신용카드
$CONF['phone_conf'] = $HAPPY_CONFIG['phone_conf'];						#휴대폰결제
$CONF['bank_soodong_conf'] = $HAPPY_CONFIG['bank_soodong_conf'];	#무통장입금
$CONF['point_conf'] = $HAPPY_CONFIG['point_conf'];	#포인트결제


$CONF['bank_conf_mobile'] = $HAPPY_CONFIG['bank_conf_mobile'];							#실시간계좌이체
$CONF['card_conf_mobile'] = $HAPPY_CONFIG['card_conf_mobile'];							#신용카드
$CONF['phone_conf_mobile'] = $HAPPY_CONFIG['phone_conf_mobile'];						#휴대폰결제
$CONF['bank_soodong_conf_mobile'] = $HAPPY_CONFIG['bank_soodong_conf_mobile'];	#무통장입금
$CONF['point_conf_mobile'] = $HAPPY_CONFIG['point_conf_mobile'];	#포인트결제

//$HAPPY_CONFIG['MemberRegistAgreement'] = strip_tags($HAPPY_CONFIG['MemberRegistAgreement']);	#약관
//$HAPPY_CONFIG['MemberRegistPrivate'] = strip_tags($HAPPY_CONFIG['MemberRegistPrivate']);			#개인정보보호정책

$CONF['kcb_adultcheck_use'] = $kcb_adultcheck_use;



//print_r($HAPPY_CONFIG);


#$dobae_number = '81244'; #도배방지를 위한 키숫자. 4자리이상입력 할것.

#$doc_view_secure	= "0";							#이력서를 회원만 볼수있게 할려면 1로 설정

#$max_file_size		= "2048";
#$uryo_title			= "막강 해피잡 유료결재 데모";

$skin_folder		= "temp";
$skin_folder_file	= "html_file";
#$skin_folder_bbs	= "html_bbs";

#$upload_folder		= "upload";						#업로드폴더
#$per_document_file	= "upload/document";			#이력서 첨부파일 업로드 폴더
#$per_document_pic	= "upload/pic";				#이력서 사진첨부 업로드 폴더


#$keyword_rank_day	= "150";		// 실시간검색 랭킹기준 일수
#$rankIcon_up		= "1";
#$rankIcon_down		= "2";
#$rankIcon_new		= "3";
#$rankIcon_equal		= "4";
#$rankIcon_new_color		= "FF0000";
#$rankIcon_up_color		= "0033FF";
#$rankIcon_down_color	= "AFAFAF";
#$rankIcon_equal_color	= "000000";
#$keyword_delete_day	= "3650";	// 365일이 지난 실시간 데이타는 자동삭제 0일경우 자동 삭제 안함(계속보관).

#SMS 설정
$sms_userid			= $CONF["sms_userid"];	# HAPPYCGI에서 발급 받은 sms아이디
$sms_testing		= $CONF["sms_testing"];	# 테스트하실때 test 입력
$sms_send_option	= $CONF["sms_send_option"];		#sms발송여부


#새로운 배너관리툴 설정

$banner_folder_admin	= 'banner';
$banner_folder			= 'admin/banner';
$banner_auto_addslashe	= '1';
#$banner_no_banner_img	= 'img/no_banner.gif';


#개인 이력서 이미지첨부 관련 설정
#$doc_img_width_big		= '400';
#$doc_img_height_big		= '600';
#$doc_img_width_small	= '120';
#$doc_img_height_small	= '150';
#$doc_img_quality		= '100';
#$doc_img_path			= 'upload/per_img/';
#$doc_img_url			= 'upload/per_img/';
#$doc_mini_album_use		= '1';					#미니앨범 사용유무 사용시 1로 변경 - 사용불가능한 기능

//2011-05-11 HYO $추가 // 트위터, 페이스북, 미투데이
$server_character		= 'utf8';
$server_character_mail	= ( preg_match("/euc/",$server_character) ) ? "EUC-KR" : "UTF-8";

############### 아이콘 관리 설정 ######################################################

$happy_org_path			= $path;						# 사이트 루트 서버경로
$skin_icon_folder		= 'img/skin_icon';				# 아이콘 PNG 업로드 폴더
$skin_icon_maker_folder	= 'img/skin_icon/make_icon';	# 생성된 아이콘 저장 폴더
$happy_icon_group		= Array(
								'기본색상',
								'서브색상',
								'상단메뉴',
								'카피라이터',
								'메인페이지',
								'서브페이지',
								'커뮤니티',
								'기타페이지',
								'기타페이지2',
								'게시판1',
								'게시판2',
								'모바일_기본색상',
								'모바일_서브색상',
								'모바일_상단메뉴',
								'모바일_카피라이터',
								'모바일_메인페이지',
								'모바일_서브페이지',
								'모바일_커뮤니티',
								'모바일_기타페이지',
								'모바일_기타페이지2'
						);								# 아이콘 그룹 지정
#######################################################################################

#투표관련
$progress_end = "<center><img src='".$HAPPY_CONFIG['PollEndImg1']."' border='0'></center>";
#투표관련 끝



#희망연봉을 연봉제가 아닐경우 사용되는 값
$want_money_arr		= Array($WantMoneyArr2,$WantMoneyArr3,$WantMoneyArr4,$WantMoneyArr5,$WantMoneyArr6);


$want_money_img_arr2	= Array(
							$WantMoneyArr2		=> $WantMoneyArr2_1,
							$WantMoneyArr3		=> $WantMoneyArr3_1,
							$WantMoneyArr4		=> $WantMoneyArr4_1,
							$WantMoneyArr5		=> $WantMoneyArr5_1,
							$WantMoneyArr6		=> $WantMoneyArr6_1
					);

$want_money_img_arr	= Array(
							''=> "<img src='".$HAPPY_CONFIG['WantMoneyArrImg7']."' border='0' align='absmiddle'>",
							$WantMoneyArr2		=> "<img src='".$HAPPY_CONFIG['WantMoneyArrImg2']."' border='0' align='absmiddle'>",
							$WantMoneyArr3		=> "<img src='".$HAPPY_CONFIG['WantMoneyArrImg3']."' border='0' align='absmiddle'>",
							$WantMoneyArr4		=> "<img src='".$HAPPY_CONFIG['WantMoneyArrImg4']."' border='0' align='absmiddle'>",
							$WantMoneyArr5		=> "<img src='".$HAPPY_CONFIG['WantMoneyArrImg5']."' border='0' align='absmiddle'>",
							$WantMoneyArr6		=> "<img src='".$HAPPY_CONFIG['WantMoneyArrImg6']."' border='0' align='absmiddle'>"
					);




#메인로고,카피라이트,워터마크 변경
#관리자모드로 이동할 필요가 없음
$main_logo_folder	= "../upload/happy_config";
$copyright_logo_folder = "../upload/happy_config";
$water_logo_folder	= "../upload/happy_config";

$main_logo_img		= "main_logo.jpg";		#메인로고 파일명 고정
$copyright_logo_img	= "copyright.gif";
$water_logo_png		= "logo.png";

$preview = "<img src='$main_logo_folder/$main_logo_img'>";
$preview2 = "<img src='$copyright_logo_folder/$copyright_logo_img' width='200'>";
$preview3 = "<img src='$water_logo_folder/$water_logo_png'>";

//새로운썸네일
$Logo_Img_Name = $HAPPY_CONFIG['logo'];


#업로드를 위한 자동폴더생성
$now_year= date("y");
$now_year = "20" . $now_year;
$now_month=date("m");
$now_day=date("d");
$file_attach_folder = "upload";
$jaego_attach_folder = "$path";
#업로드를 위한 자동폴더생성끝



#$naver_key			= "ca2c18136ddac0128644b8d131aa7e34";	//네이버 지도 aaa 꺼
//echo $naver_key;

//$daum_key = "b9d1130cdefe65520065699cbf24809da9da0478";


#$xml_under_folder	= "xml_under";					#역세권 지하철플레쉬 연동xml 저장될 폴더명

#사용용도가 불분명
$photo_news_width	= "100";						#게시판 포토뉴스 가로길이
$photo_width		= "80";							#게시판 갤러리 가로길이
#사용용도가 불분명

#회사로고사이즈
$COMLOGO_DST_W = array ( $ComLogoDstW );
$COMLOGO_DST_H = array( $ComLogoDstH );
#회사배너사이즈
$COMBANNER_DST_W = array ( $ComBannerDstW );
$COMBANNER_DST_H = array( $ComBannerDstH );

#개인회원사진사이즈
$PERPOTHO_DST_W = array ( $PerPhotoDstW );
$PERPOTHO_DST_H = array ( $PerPhotoDstH );





$gi_joon[0]			= $COMLOGO_DST_W['0'];						#기업회원사진 가로길이
$gi_joon[1]			= $COMBANNER_DST_W['0'];							#기업회원광고 배너 가로길이


//이력서 등록방식 simple or complex
$document_reg_type = "simple";
//$document_reg_type = "complex";
$HAPPY_CONFIG['document_reg_type'] = $document_reg_type;

//온라인입사지원 단계
$HAPPY_CONFIG['tonline_stats'] = str_replace("\r","",$HAPPY_CONFIG['tonline_stats']);
$online_stats = explode("\n",$HAPPY_CONFIG['tonline_stats']);




$create_num = "1";
//썸네일 생성타입
#0 : 세로로 남는 부분 짤라버림
#1 : 원본그대로 확대/축소
#2 : 가로가 왔다갔다 함
#3 : 세로가 왔다갔다 함
#4 : 캔버스 고정 / 결과 이미지 가로 + 세로 비율대로 줄이거나 늘림
#$thumb_type = "4";
#$thumb_type_per = "0";		#일반회원 사진 업로드시 썸네일 생성 타입
//회사로고

$doc_pic_width[0]	= $doc_pic_width_0;						#이력서작성시 사진 가로길이
$doc_pic_width[1]	= $doc_pic_width_1;						#이력서작성시 사진 배너 가로길이
$doc_pic_height[0]	= $doc_pic_height_0;						#이력서작성시 사진 세로길이
$doc_pic_height[1]	= $doc_pic_height_1;						#이력서작성시 사진 배너 세로길이
/*
echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
echo $doc_pic_width[0]."<br>";
echo $doc_pic_width[1]."<br>";
echo $doc_pic_height[0]."<br>";
echo $doc_pic_height[1]."<br>";
*/




$guin_pic_width[0]	= $guin_pic_width_0;						#구인등록시 관련사진 가로길이
$guin_pic_width[1]	= $guin_pic_width_1;						#구인등록시 관련사진 배너 가로길이
$guin_pic_height[0]	= $guin_pic_height_0;						#구인등록시 관련사진 세로길이
$guin_pic_height[1]	= $guin_pic_height_1;						#구인등록시 관련사진 배너 세로길이

//echo $guin_pic_width[0];
//echo $guin_pic_height[0];

$person_logo_width	= $PERPOTHO_DST_W['0'];						#개인회원사진 가로길이
#$pic_ok_ext			= array('jpg','jpeg','gif');	#첨부가능한 사진 확장명
$pic_ok_ext			= array($pic_ok_ext1,$pic_ok_ext2,$pic_ok_ext3);	#첨부가능한 사진 확장명

#안쓰는 변수임
$per_doc_top_color	= "red";						#이력서 작성 상단에 현재작성단계를 출력시 글자색
#안쓰는 변수임

#$oaArray			= Array("상","중","하","선택안함");		#이력서 검색폼 - OA 등급
#$oaValArray			= Array("3","2","1","[none]");			#이력서 검색폼 - OA 등급의 option값
$oaArray			= Array($oaArray1,$oaArray2,$oaArray3,$oaArray4);		#이력서 검색폼 - OA 등급
$oaValArray			= Array($oaValArray1,$oaValArray2,$oaValArray3,$oaValArray4);			#이력서 검색폼 - OA 등급의 option값


#$prefixText			= Array("무관","남자","여자");					#이력서 검색폼 - 성별선택
#$prefixValue		= Array("","man","girl");					#이력서 검색폼 - 성별선택 option값
$prefixText			= Array($prefixText1,$prefixText2,$prefixText3);					#이력서 검색폼 - 성별선택
$prefixValue		= Array($prefixValue1,$prefixValue2,$prefixValue3);					#이력서 검색폼 - 성별선택 option값


#$doc_title_color	= "red";								#이력서 유료결제된 타이틀색상
#$doc_title_bgcolor	= "#deff00";								#이력서 유료결제된 배경색상
#$guin_title_bgcolor	= "#deff00";					#채용정보 유료결제된 배경색상

#$doc_search_color	= "navy";								#이력서 리스트에서 제목검색시 검색어와 일치하는 색상

$under_print_width	= 1;									#지하철 역세권 검색시 한줄에 출력할 역의 갯수
															#수정후 적용을 할려면 관리자모드 - 역세권설정에서 DB저장버튼을 눌러야함

#$dacom_mertkey		= "2a5478d3f0115a675299207e3f4ae2bd";

#채용정보 유료옵션 관련 설정 7,8,9는 회원관련유료
$ARRAY				= array(	0 => 'guin_banner1',
									1 => 'guin_banner2',
									2 => 'guin_banner3',
									3 => 'guin_bold',
									4 => 'guin_list_hyung',
									5 => 'guin_pick',
									6 => 'guin_ticker',
									7 => 'guin_docview',
									8 => 'guin_docview2',
									9 => 'guin_smspoint',
									10 => 'guin_bgcolor_com',
									11 => 'freeicon_comDate',
									12 => 'guin_uryo1',
									13 => 'guin_uryo2',
									14 => 'guin_uryo3',
									15 => 'guin_uryo4',
									16 => 'guin_uryo5'
								);
$ARRAY_NAME			= array(	'우대등록',
										'프리미엄',
										'스피드',
										'볼드',
										'스페셜',
										'추천',
										'뉴스티커',
										'이력서상세보기',
										'이력서상세보기',
										'SMS전송횟수',
										'배경색',
										'아이콘',
										$CONF['guin_uryo1_title'],
										$CONF['guin_uryo2_title'],
										$CONF['guin_uryo3_title'],
										$CONF['guin_uryo4_title'],
										$CONF['guin_uryo5_title']
									);


//print_r($ARRAY_NAME);
$ARRAY_FILE			= array(	'banner_focus.html',
										'banner_pre.html',
										'banner_speed.html',
										'banner_bold.html',
										'banner_spec.html',
										'banner_pick.html',
										'banner_ticker.html'
									);
#$ARRAY_NAME2		= array('icon_udae.gif','icon_pre.gif','icon_speed.gif','icon_bold.gif','icon_spec.gif','icon_pick.gif','icon_ticker.gif','icon_docview.gif','icon_docview2.gif','icon_smspoint.gif','icon_bgcolor.gif','icon_freeicon.gif');
$ARRAY_NAME2		= array(	$HAPPY_CONFIG['IconGuinUdae1'],
										$HAPPY_CONFIG['IconGuinPre1'],
										$HAPPY_CONFIG['IconGuinSpeed1'],
										$HAPPY_CONFIG['IconGuinBold1'],
										$HAPPY_CONFIG['IconGuinSpec1'],
										$HAPPY_CONFIG['IconGuinPick1'],
										$HAPPY_CONFIG['IconGuinTicker1'],
										$HAPPY_CONFIG['IconGuinDocView1'],
										$HAPPY_CONFIG['IconGuinDocView2'],
										$HAPPY_CONFIG['IconGuinSms1'],
										$HAPPY_CONFIG['IconGuinBgcolor1'],
										$HAPPY_CONFIG['IconGuinIcon1'],
										$HAPPY_CONFIG['IconGuinUryo1'],
										$HAPPY_CONFIG['IconGuinUryo2'],
										$HAPPY_CONFIG['IconGuinUryo3'],
										$HAPPY_CONFIG['IconGuinUryo4'],
										$HAPPY_CONFIG['IconGuinUryo5']
									);

//채용정보 점프기능
if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
{
	array_push($ARRAY,'guin_jump');
	array_push($ARRAY_NAME,'채용정보 점프');
	array_push($ARRAY_NAME2,$HAPPY_CONFIG['IconGuinJump1']);
}
//채용정보 점프기능

//채용정보 유료옵션별 검색 추가 hong
$ARRAY_SEARCH		= array(
							0	=> 'guin_banner1',
							1	=> 'guin_banner2',
							2	=> 'guin_banner3',
							3	=> 'guin_list_hyung',
							4	=> 'guin_pick'
);

$ARRAY_SEARCH_NAME	= array(
							0	=> '우대등록',
							1	=> '프리미엄',
							2	=> '스피드',
							3	=> '스페셜',
							4	=> '추천'
);


#채용정보 유료옵션 관련 설정

#이력서 유료옵션관련 설정
#이력서는 이력서테이블과 환경설정 변수명이 달라서 배열을 새로 하나 생성함
#환경설정배열
#14,15,16 회원관련 유료옵션
$PER_ARRAY_DB		= Array(	"guin_special",
										"guin_focus",
										"guin_powerlink",
										"guin_docskin",
										"guin_icon",
										"guin_bolder",
										"guin_color",
										"guin_freeicon",
										"guin_bgcolor",
										"GuzicUryoDate1",
										"GuzicUryoDate2",
										"GuzicUryoDate3",
										"GuzicUryoDate4",
										"GuzicUryoDate5",
										"guzic_view",
										"guzic_view2",
										"guzic_smspoint"
									);

#이력서테이블 필드이름배열
$PER_ARRAY		= Array(	"specialDate",
									"focusDate",
									"powerlinkDate",
									"skin_date",
									"iconDate",
									"bolderDate",
									"colorDate",
									"freeiconDate",
									"bgcolorDate",
									"GuzicUryoDate1",
									"GuzicUryoDate2",
									"GuzicUryoDate3",
									"GuzicUryoDate4",
									"GuzicUryoDate5",
									"guzic_view",
									"guzic_view2",
									"guzic_smspoint"
								);
#유료옵션명칭배열
$PER_ARRAY_NAME	= Array(	"스페셜",
										"포커스",
										"파워링크",
										"이력서스킨",
										"아이콘",
										"볼드",
										"칼라",
										"자유아이콘",
										"배경색",
										$CONF['GuzicUryoDate1_title'],
										$CONF['GuzicUryoDate2_title'],
										$CONF['GuzicUryoDate3_title'],
										$CONF['GuzicUryoDate4_title'],
										$CONF['GuzicUryoDate5_title'],
										"구인보기",
										"구인보기",
										"SMS포인트"
									);


#$PER_ARRAY_ICON	= Array("icon_spec.gif","icon_focus.gif","icon_powerlink.gif","guzic_skin.gif","icon_icon.gif","icon_bold.gif","guzic_color.gif","guzic_freeicon.gif","icon_bgcolor.gif");
$PER_ARRAY_ICON	= Array(	$HAPPY_CONFIG['IconGuzicSpec1'],
										$HAPPY_CONFIG['IconGuzicFocus1'],
										$HAPPY_CONFIG['IconGuzicPowerLink1'],
										$HAPPY_CONFIG['IconGuzicSkin1'],
										$HAPPY_CONFIG['IconGuzicIcon1'],
										$HAPPY_CONFIG['IconGuzicBold1'],
										$HAPPY_CONFIG['IconGuzicColor1'],
										$HAPPY_CONFIG['IconGuzicFreeIcon1'],
										$HAPPY_CONFIG['IconGuzicBgcolor1'],
										$HAPPY_CONFIG['IconGuzicUryo1'],
										$HAPPY_CONFIG['IconGuzicUryo2'],
										$HAPPY_CONFIG['IconGuzicUryo3'],
										$HAPPY_CONFIG['IconGuzicUryo4'],
										$HAPPY_CONFIG['IconGuzicUryo5'],
										$HAPPY_CONFIG['IconGuzicView'],
										$HAPPY_CONFIG['IconGuzicView2'],
										$HAPPY_CONFIG['IconGuzicSms']
									);
#이력서 유료옵션관련 설정

#버튼관련
#$com_guin_per_button[0]	= "<img src='img/bt_gujik_send.gif' align='absmiddle' border='0'>";
#$com_guin_per_button[1]	= "<img src='img/bt_gujik_send2.gif' align='absmiddle' border='0' alt='이메일접수'>";
#$com_guin_per_button[2]	= "<img src='img/bt_gujik_send3.gif' align='absmiddle' border='0' alt='전화접수'>";
#$com_guin_per_button[3]	= "<img src='img/bt_gujik_send4.gif' align='absmiddle' border='0' alt='우편접수'>";
#$com_guin_per_button[4]	= "<img src='img/bt_gujik_send5.gif' align='absmiddle' border='0' alt='방문접수'>";

#온라인입사지원 버튼
$com_guin_per_button[0]	= "<img src='".$HAPPY_CONFIG['bt_gujik_send1']."' align='absmiddle' border='0' style='margin-right:5px;'>";

#이메일접수 버튼
$com_guin_per_button[1]	= "<img src='".$HAPPY_CONFIG['bt_gujik_send2']."' align='absmiddle' border='0' alt='이메일접수'  style='margin-right:5px;'>";
#전화접수 버튼
$com_guin_per_button[2]	= "<img src='".$HAPPY_CONFIG['bt_gujik_send3']."' align='absmiddle' border='0' alt='전화접수'  style='margin-right:5px;'>";
#우편접수 버튼
$com_guin_per_button[3]	= "<img src='".$HAPPY_CONFIG['bt_gujik_send4']."' align='absmiddle' border='0' alt='우편접수'  style='margin-right:5px;'>";
#방문접수 버튼
$com_guin_per_button[4]	= "<img src='".$HAPPY_CONFIG['bt_gujik_send5']."' align='absmiddle' border='0' alt='방문접수'>";


#홈페이지 카운트 관련
$duplication		= "";							#접속통계 중복방지 1일경우 ON 으로 설정됩니다.
$stats_name			= array("메인접속","게시판","로그인시도","결재시도");
$stats_file			= array("index.php","bbs_","login","my_pay.php");

#$board_pick_cut_day	= "1000"; #게시판에 추천게시물로 존재할 날짜
$garo_gi_joon		= '191'; #추출썸네일가로
$sero_gi_joon		= '150'; #추출썸네일세로

#위지윅 업그레이드로 추가됨
$garo_gi_joon_wys2 = $garo_gi_joon;
$sero_gi_joon_wys2 = $sero_gi_joon;
$logo_position = $HAPPY_CONFIG['logo_position'];
//print_r($HAPPY_CONFIG);

$logo_file = $HAPPY_CONFIG['logo_file'];						#워터마크

$gi_joon_ihc = "550"; //wys2 plugins insertHtmlCode

$camera_move		= '1'; #길이 비율이 일정하지 않을때 카메라무빙기능을 쓸것인지여부 1 이면작동,0이면 작동하지 않음
$picture_quality	= '100'; #썸네일 품질 (100일 경우 가장좋음, 용량이 커짐)
#본문이미지 클릭시 팝업원본 이미지를 보여줄것인지? , 사용하게 되면 이미지의 링크를 걸어도 소실됨.
$file_attach_clickpop	= '1';
$thumbnail_cut_action	= '1';		#기존 비율을 유지한채 원본사진을 자르지 않을경우 빈값 (빈값일때 이미지 찌그러짐에 유의)


# happy_image 함수에서 사용되는 퀄리티 기본 지정값 kwak16 - 20180416
$happy_image_sizes			= Array(
									'기본퀄리티'	=> 93,
									'화질좋음'		=> 100,
									'화질낮음'		=> 85,
									'기타화질A'		=> 93,
									'기타화질B'		=> 93,
									'기타화질C'		=> 93,
);


#utf 인 경우 글자 미리잘라줌 기능.
$utf_add_cut = '10';


#년도 입력
$year_arr			= array("2009","2008","2007","2006","2005","2004","2003","2002","2001","2000");
$year_co			= count($year_arr);

#구인등록시 마감일 최소 몇일이후인지
#$chkDay				= 7;

#게시판 new 아이콘 날짜
#$board_new_cut		= 3;


#게시글 상세화면에서 첨부파일등록시 썸네일 가로사이즈(500 일때 500을 넘어가면 아래줄에 출력)
#$attach_file_align_size = 600;


#부관리자 메뉴 설정
$adminMenuNames		= array("회원관리","회원메일링","구인리스트","구직리스트","투표관리","결제관리","접속통계","직종설정","지역설정","구인구직옵션설정","유료옵션설정","게시판관리","환경설정","추천키워드","플래쉬|로고관리","팝업관리","미니앨범관리","메뉴관리");
################################################################################################################
$guin_menu			= "";
$sql				= "select * from $area_tb where number='1'";
$result				= query($sql);
$rootData			= mysql_fetch_row($result);

foreach ( $rootData as $Key => $tValue )
{
	$rootData[$Key]		= trim($tValue);
}

//헤드헌팅 제거
if ( $hunting_use == false )
{
	$rootData[2]		= str_replace(">헤드헌팅","",$rootData[2]);
}

$area				= explode("/",$rootData[1]);
$job_arr			= explode(">",$rootData[2]);	#고용형태
$woodae_arr			= explode(">",$rootData[3]);	#구인우대조건

$bokri_arr			= explode(">",$rootData[4]);	#구인복리후생
if ( is_array($bokri_arr) )
{
	foreach($bokri_arr as $k => $v )
	{
		$Tbokri = explode(":",$v);
		$bokri_arr_title[] = $Tbokri[1];
	}
}
//print_r($bokri_arr);
//print_r($bokri_arr_title);

$money_arr			= explode(">",$rootData[5]);	#연봉선택사항
$edu_arr			= explode(">",$rootData[6]);	#학력선택사항

//학력무관 한 채용정보 버그패치 2018-01-22 kad
$edu_arr2 = $edu_arr;
array_unshift($edu_arr2,"학력무관");

$career_arr			= explode(">",$rootData[7]);	#경력선택사항
$grade_arr			= explode(">",$rootData[8]);	#직급선택사항
$lang_arr			= explode(">",$rootData[9]);	#외국어능력선택사항
$guin_license_arr	= explode(">",$rootData[10]);	#자격증선택사항
$document_keyword	= explode(">",$rootData[11]);	#이력서키워드
$root_schooltype	= explode(">",$rootData[12]);	#학교계열선택
$root_money2		= explode(">",$rootData[13]);	#과거회사 연봉선택
$root_lang			= explode(">",$rootData[14]);	#외국어자격증종류
$root_country		= explode(">",$rootData[15]);	#연수국가선택
$guin_howjoin		= explode(">",$rootData[16]);	#구인등록시 구직접수방법 종류
$career_start_arr	= explode(">",$rootData[17]);	#경력검색 시작부분 옵션
$career_end_arr		= explode(">",$rootData[18]);	#경력검색 종료부분 옵션
$tHopeSize		= explode(">",$rootData[19]);	#희망회사규모

$gender_arr			= Array("남자","여자","무관");
$skillArray			= Array("skill_word","skill_ppt","skill_excel","skill_search");
################################################################################################################


//전국(지역) 고유넘버
$Area_All_Number			= 30; //전국TEXT가 바뀔것을 대비


#항상공통부분 실행
#conf_read();
admin_read();
si_read();
gu_read();
type_read();
type_sub_read();
type_sub_sub_read();




###[ YOON : 2008-10-30 ]#########################################################
$message_print		= '%쪽지수%';			#{{쪽지메세지}} 출력형식 입력 (로그인후 로그인 박스 대신 보이는곳에 추가) => 쪽지가 없을때
$message_print2		= "%쪽지수%";			#{{쪽지메세지}} 출력형식 입력 (로그인후 로그인 박스 대신 보이는곳에 추가) => 쪽지가 있을때
###[ YOON : 2008-10-30 ]#########################################################

/***** 백업용 ********************** 맛집버전
$message_print		= '<table style=cursor:pointer;cursor:hand><tr><td><img src=img/message/icon_mess_no.gif border=0 align=absmiddle></td><td class=smfont>(%쪽지수%)</td></tr></table>';			#{{쪽지메세지}} 출력형식 입력 (로그인후 로그인 박스 대신 보이는곳에 추가) => 쪽지가 없을때
$message_print2		= "<table style=cursor:pointer;cursor:hand><tr><td><img src=img/message/icon_mess_ok.gif border=0 align=absmiddle></td><td class=smfont>(<font color=red><b>%쪽지수%</b></font>)</td></tr></table>";			#{{쪽지메세지}} 출력형식 입력 (로그인후 로그인 박스 대신 보이는곳에 추가) => 쪽지가 있을때
**************************************/

#$message_setTime	= '3000';						#AJAX로 실시간 쪽지체크시 체크주기시간 (ms기준) 1000 -> 1초


######################################################################################################
# KCB 아이핀,휴대폰인증 모듈 설정
######################################################################################################
#주의! :	일반적인 웹호스팅에서 제공되는 system() 함수가 서버에서 지원되어야함.
#			보안상 웹호스팅업체에서 막아두는 경우 , 웹호스팅업체쪽으로 system() 함수 지원요청을 해야함.
#Site URL (서비스신청하기) : http://www.ok-name.co.kr/acs/cn/companyreg/reg_companyRegForm.jsp?menu_id=3
#
#만약 system 함수가 안될경우 exec 라도 지원이 되어야함.
######################################################################################################

//본인인증 hun		START
//고객에게 맞춰서 버젼을 설정해 주세요.
//$linux_bit				= '64';
$glibc_ver				= '2.12';
$ipin_ssl_use			= '';			//값이 없을 경우 SSL 인증서가 없거나 사이트 전체를 https 로 구동할 경우 입니다.
										//1로 설정 -> 본인인증 프로그램만 https 로 구동하는 조건.
/*
리눅스의 비트 확인하려면 SSH 에서 getconf LONG_BIT 를 입력하세요.
리눅스의 GLIBC 버젼을 체크 하려면 SSH 에서 getconf -a | grep libc 를 입력하세요.
*/

#데모일때만 사용함
if ( $demo_lock )
{
	$kcb_namecheck_use		= $demo_kcb_namecheck_use;			//아이핀사용여부
	$kcb_mid				= $demo_kcb_mid;					#kcb측에서 발급한 memid

	//$linux_bit				= $demo_linux_bit;					//데모는 리눅스 32비트 이므로 고정입니다. 변경하지 마세요!!

	$ipin_test				= $demo_ipin_test;		//KCB IPIN 테스트 연동시 값을 1로 입력하세요.
}
else
{
	$kcb_namecheck_use		= $HAPPY_CONFIG['kcb_namecheck_use']; #실명인증쓸것인지?
	$kcb_mid				= $HAPPY_CONFIG['kcb_mid']; #kcb측에서 발급한 memid

	$ipin_test				= '';		//KCB IPIN 테스트 연동시 값을 1로 입력하세요.
}

//리눅스운영체제 비트 체크 자동화
if(PHP_INT_MAX == 2147483647){
	$linux_bit				= '32';
}
else{
	$linux_bit				= '64';
}


$system_function_ok		= "1";		//서버에서 system 함수를 지원하는 경우.	만약 system 함수를 지원하지 않을 경우 exec 함수는 꼭 지원 되어야함.


//파일명 구성 : okname.x비트,glibc버젼 입니다.
$okname_comment_file	= "okname.x".$linux_bit.".".$glibc_ver;


$NAME_CHECK_IPIN		= ARRAY(
							"kcb_mid"				=> $kcb_mid,
							"adult_check"			=> "",
							"idpUrl"				=> "https://ipin.ok-name.co.kr/tis/ti/POTI90B_SendCertInfo.jsp",
							"idpCode"				=> "V",
							"exe"					=> "${path}namecheck/ipin/${okname_comment_file}",
							"keypath"				=> "${path}namecheck/ipin/key/okname.key",
							"reserved1"				=> "0",
							"reserved2"				=> "0",
							"EndPointURL"			=> "http://www.ok-name.co.kr/KcbWebService/OkNameService",
							"logpath"				=> "${path}data/kcb_log/",
							"kcb_option"			=> "C",
							"KCB_Script_action"		=> "document.kcbInForm.action='https://ipin.ok-name.co.kr/tis/ti/POTI01A_LoginRP.jsp'",
					);

$NAME_CHECK_HP			= ARRAY(
								"kcb_mid"				=> $kcb_mid,
								"clientIp"				=> $_SERVER["SERVER_ADDR"],
								"clientDomain"			=> $_SERVER["HTTP_HOST"],
								"exe"					=> "${path}namecheck/hpcheck/${okname_comment_file}",
								"keypath"				=> "${path}namecheck/hpcheck/key/",
								"EndPointURL"			=> "http://safe.ok-name.co.kr/KcbWebService/OkNameService",
								"logpath"				=> "${path}data/kcb_log",
								"commonSvlUrl"			=> "https://safe.ok-name.co.kr/CommonSvl",
						);

if($ipin_test)
{
	$NAME_CHECK_IPIN["kcb_mid"]				= "P00000000000";
	$NAME_CHECK_IPIN["idpUrl"]				= "https://test.ok-name.co.kr:9080/tis/test/register_case5.jsp";
	$NAME_CHECK_IPIN["EndPointURL"]			= "http://twww.ok-name.co.kr:8888/KcbWebService/OkNameService";
	$NAME_CHECK_IPIN["KCB_Script_action"]	= "document.kcbInForm.action ='https://tipin.ok-name.co.kr:8443/tis/ti/POTI01A_LoginRP.jsp'";
}

$kcb_error_code = array(
						"B001"		=> "주민번호 미존재 오류",
						"B002"		=> "이름 미존재 오류",
						"B003"		=> "주민번호 형식 체계 오류",
						"B004"		=> "요청 서버 IP 오류",
						"B005"		=> "요청 서버 도메인 오류",
						"B006"		=> "잔여건수 사용초과, 충전제사용시 잔액부족",
						"B007"		=> "제휴가맹점 유효기간 만료",
						"B008"		=> "제휴가맹점 코드오류",
						"B009"		=> "제휴가맹점 키 오류",
						"B010"		=> "계약되지 않은 서비스 타입",
						"B011"		=> "복호화 혹은 서버 OS 종류 오류.",
						"B012"		=> "데이터 암호화 오류",
						"B013"		=> "미승인 가맹점",
						"B014"		=> "클라이언트 체크타입 오류",
						"B015"		=> "접근 가능 대역 오류",
						"B016"		=> "명의 차단상태",
						"B017"		=> "입력값 오류",
						"B018"		=> "실명요청 승인대기 상태",
						"B019"		=> "실명요청 반려상태",
						"B020"		=> "통신오류(KAIT)",
						"B100"		=> "입력하신 정보가 올바르지 않습니다.",
				);

//아이핀추가 hun			END
######################################################################################################


if ( $demo_lock )
{
	$picture_quality		= $demo_picture_quality;  #데모면 일단 100%준다

	$happy_sns_login_use_facebook	= $HAPPY_CONFIG['happy_sns_login_use_facebook']		= $demo_sns_login_use_facebook;
	$happy_sns_login_use_google		= $HAPPY_CONFIG['happy_sns_login_use_google']		= $demo_sns_login_use_google;
	$happy_sns_login_use_twitter	= $HAPPY_CONFIG['happy_sns_login_use_twitter']		= $demo_sns_login_use_twitter;
	$happy_sns_login_use_kakao		= $HAPPY_CONFIG['happy_sns_login_use_kakao']		= $demo_sns_login_use_kakao;
	$happy_sns_login_use_naver		= $HAPPY_CONFIG['happy_sns_login_use_naver']		= $demo_sns_login_use_naver;
	$happy_sns_login_key_naver		= $HAPPY_CONFIG['happy_sns_login_key_naver']		= $demo_sns_login_key_naver;
	$happy_sns_login_callback_naver	= $HAPPY_CONFIG['happy_sns_login_callback_naver']	= $demo_sns_login_callback_naver;

}


$working			= "";
$bench_mark			= $bench_mark;


$file_name_view_option	= $HAPPY_CONFIG['template_view'];		// 1일경우 템플릿 파일명 출력
//$file_name_view_option	= 1;		// 1일경우 템플릿 파일명 출력
$template_tag_view_option = $HAPPY_CONFIG['template_tag_view'];   #디자인작업시 템플릿 태그 확인용

#관리자가 아닌 경우 OFF처리 , banner_view.php 도 제외
if ( $_COOKIE["ad_id"] != $admin_id || md5($admin_pw) != $_COOKIE["ad_pass"] || strpos($_SERVER['SCRIPT_NAME'], 'banner_view.php') !== false || strpos($_SERVER['SCRIPT_NAME'], 'tag_print_pop.php') !== false )
{
	$file_name_view_option	= '';
}

$is_cgimall_office		= preg_match("/^115\.93\.87\./",$_SERVER['REMOTE_ADDR']);

if ( $_GET['happy_test'] == date("Ymd") && ($_COOKIE['ad_id'] == $admin_id || $is_cgimall_office == "1") )
{
	$bench_mark	= '1';
}

if ( $_GET['happy_test2'] == date("Ymd") && ($_COOKIE['ad_id'] == $admin_id || $is_cgimall_office == "1") )
{
	$template_tag_view_option	= '1';
}

#기간별의 real_gap은?
$sql22 = "select (TO_DAYS(curdate())-TO_DAYS('2005-10-21')) ";
$result22 = query($sql22);
list($real_gap) = mysql_fetch_row($result22);

#관리자인지?
if ( $_COOKIE["ad_id"] == $admin_id
	&& $_COOKIE["ad_pass"] == $admin_pw
	&& $admin_id
	&& $admin_pw ) {
	$master_check = '1';
}




$prev_stand = "<a href='$main_url' ><span>HOME</span></a>";
$prev_stand_bbs = "<img src='img/icon_home.gif' align='absmiddle' style='margin-right:5px;'> <a href='$main_url'><span class='fon_st_11'>HOME</span></a> > <a href=$main_url/html_file.php?file=bbs_index.html&file2=bbs_default_community.html>커뮤니티</a>";


######################################################################################################
# 게시판 현재위치 변경
$guidepage_array = array(
					$DB_Prefix.'board_notice',
					$DB_Prefix.'board_faq',
					$DB_Prefix.'board_qna',
					$DB_Prefix.'board_bannerreg',
					$DB_Prefix.'board_cust_member',
					$DB_Prefix.'board_guzic',
					$DB_Prefix.'board_coop',
					$DB_Prefix.'board_reservation',
					$DB_Prefix.'board_moneyset',
					$DB_Prefix.'board_onetoone'
					);

$guidepage_array_check = '';
foreach ($guidepage_array as $list)
{
	if ($list == $_GET['tb'] )
	{
		$guidepage_array_check = '1';
		break;
	}
}
if ($guidepage_array_check)
{
	$prev_stand_bbs = " <img src='img/icon_home.gif' align='absmiddle' style='margin-right:5px;'> <a href='$main_url'>홈</a> > <a href=$main_url/html_file.php?file=bbs_index_customer.html&file2=bbs_default.html>고객지원</a>";
}
else
{
	###[ YOON : 2008-11-04 ]####################################
	$prev_stand_bbs = " <img src='img/icon_home.gif' align='absmiddle' style='margin-right:5px; margin-bottom:2px;'> <a href='$main_url'>홈</a> > <a href=$main_url/html_file.php?file=bbs_index.html&file2=bbs_default_community.html>커뮤니티</a>";
	//$prev_stand_board = " <a href=./>$site_name</a> > <a href=bbs_index.php>커뮤니티</a>";
	//$prev_stand_board = " <a href=html_file.php?file=community.html>커뮤니티</a>";
}


/*
$job_arr = array("광고/홍보","자재관리","건설직","교육직","기술직","무역","미디어","금융/증권","병역특례","서비스","생산직","영업직","의료직","운수직","프랜차이즈","일반사무","임원직","외국계","디자인","판매","전산직","회계/경리","프리랜서","유통직","제조업","전문직","부업","IT전문직","컴퓨터/정보통신","기타");

$job_co = count($job_arr);
*/


# SNS LOGIN 관련 설정
$happy_sns_id			= 'kwak16test';								# HAPPYCGI에서 발급
$happy_sns_securekey	= 'ODMyMjU4Njc2OTgwNDQ3NTcxNjY=';			# 매우 중요한 키
$happy_sns_userkey		= happy_mktime().rand(0,10000);
$happy_sns_member_group	= 18;										# SNS_LOGIN 회원그룹 고유번호

$happy_sns_array		= Array(
								'facebook'			=> Array (
																'icon_use_main'			=> false,
																'icon_use_reply'		=> 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_infoReply'	=> 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_messageList'	=> 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_messageView'	=> 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_mypage'		=> 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_memberModify'	=> 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_calendar'		=> 'img/sns_icon/icon_conn_facebook.gif',
																'name'					=> '페이스북',
																'id_field'				=> 'user_nick',
																'icon_use_trustList'	=> 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_autionIpchalList' => 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_bbs'	=> 'img/sns_icon/s_icon_facebook.png',
								),
								'google'			=> Array (
																'icon_use_main'			=> false,
																'icon_use_reply'		=> 'img/sns_icon/icon_conn_google.gif',
																'icon_use_infoReply'	=> 'img/sns_icon/icon_conn_google.gif',
																'icon_use_messageList'	=> 'img/sns_icon/icon_conn_facebook.gif',
																'icon_use_messageView'	=> 'img/sns_icon/icon_conn_google.gif',
																'icon_use_mypage'		=> 'img/sns_icon/icon_conn_google.gif',
																'icon_use_memberModify'	=> 'img/sns_icon/icon_conn_google.gif',
																'icon_use_calendar'		=> 'img/sns_icon/icon_conn_google.gif',
																'name'					=> '구글',
																'id_field'				=> 'user_nick',
																'icon_use_trustList'	=> 'img/sns_icon/icon_conn_google.gif',
																'icon_use_autionIpchalList' => 'img/sns_icon/icon_conn_google.gif',
																'icon_use_bbs'	=> 'img/sns_icon/s_icon_google.png',
								),
								'twitter'			=> Array (
																'icon_use_main'			=> false,
																'icon_use_reply'		=> 'img/sns_icon/icon_conn_twitter.gif',
																'icon_use_infoReply'	=> 'img/sns_icon/icon_conn_twitter.gif',
																'icon_use_messageList'	=> 'img/sns_icon/icon_conn_twitter.gif',
																'icon_use_messageView'	=> 'img/sns_icon/icon_conn_twitter.gif',
																'icon_use_mypage'		=> 'img/sns_icon/icon_conn_twitter.gif',
																'icon_use_memberModify'	=> 'img/sns_icon/icon_conn_twitter.gif',
																'icon_use_calendar'		=> 'img/sns_icon/icon_conn_twitter.gif',
																'name'					=> '트위터',
																'id_field'				=> 'user_nick',
																'icon_use_trustList'	=> 'img/sns_icon/icon_conn_twitter.gif',
																'icon_use_autionIpchalList' => 'img/sns_icon/icon_conn_twitter.gif',
																'icon_use_bbs'	=> 'img/sns_icon/s_icon_twitter.png',
								),
								'kakao'			=> Array (
																'icon_use_main'			=> false,
																'icon_use_reply'		=> 'img/sns_icon/icon_conn_kakao.gif',
																'icon_use_infoReply'	=> 'img/sns_icon/icon_conn_kakao.gif',
																'icon_use_messageList'	=> 'img/sns_icon/icon_conn_kakao.gif',
																'icon_use_messageView'	=> 'img/sns_icon/icon_conn_kakao.gif',
																'icon_use_mypage'		=> 'img/sns_icon/icon_conn_kakao.gif',
																'icon_use_memberModify'	=> 'img/sns_icon/icon_conn_kakao.gif',
																'icon_use_calendar'		=> 'img/sns_icon/icon_conn_kakao.gif',
																'name'					=> '카카오',
																'id_field'				=> 'user_nick',
																'icon_use_trustList'	=> 'img/sns_icon/icon_conn_kakao.gif',
																'icon_use_autionIpchalList' => 'img/sns_icon/icon_conn_kakao.gif',
																'icon_use_bbs'	=> 'img/sns_icon/s_icon_kakao.png',
								),
								'naver'			=> Array (
																'icon_use_main'			=> false,
																'icon_use_reply'		=> 'img/sns_icon/icon_conn_naver.gif',
																'icon_use_infoReply'	=> 'img/sns_icon/icon_conn_naver.gif',
																'icon_use_messageList'	=> 'img/sns_icon/icon_conn_naver.gif',
																'icon_use_messageView'	=> 'img/sns_icon/icon_conn_naver.gif',
																'icon_use_mypage'		=> 'img/sns_icon/icon_conn_naver.gif',
																'icon_use_memberModify'	=> 'img/sns_icon/icon_conn_naver.gif',
																'icon_use_calendar'		=> 'img/sns_icon/icon_conn_naver.gif',
																'name'					=> '네이버',
																'id_field'				=> 'user_nick',
																'icon_use_trustList'	=> 'img/sns_icon/icon_conn_naver.gif',
																'icon_use_autionIpchalList' => 'img/sns_icon/icon_conn_naver.gif',
																'icon_use_bbs'	=> 'img/sns_icon/s_icon_naver.png',
								)
);

# SNS 적용 해야 되는곳 리스트
# 게시판댓글, 출석체크, 출석체크댓글, 게시글리스트, 쪽지, 현재접속자, 게시글작성시 아이디대신 닉네임
# 이력서 상세


//헤드헌팅
$job_company				= "job_company";
$hunting_use_dis			= 'none';

#### 회원통합 관련 셋팅 #####################
//관리자아이디 / 비밀번호 선언이후에 인클루드 됨
include "function_happy_member.php";
##############################################

//헤드헌팅
if ( $hunting_use == true )
{
	include "happy_head_hunting.php";

	$Secure_Bool				= false;
	if ( $happy_member_admin_id == $_COOKIE[$happy_member_admin_id_cookie_val] && md5($happy_member_admin_pw) == $_COOKIE[$happy_member_admin_pw_cookie_val] )
	{
		$Secure_Bool				= true;
	}
	else
	{
		$Secure_Bool				= secure_member_bool($happy_member_login_value, $hunting_secure_text);
	}

	$hunting_use_dis			= $Secure_Bool == true ? '' : 'none';
}


######## 검색관련셋팅 ######################################################################################################


	#추가될 게시판 이름을 작성합니다.
	#$check_part에서 추가된 이름을 토대로 all_search.html 파일에서 해당 게시판을 추출할수 있습니다.
	#반드시 형식에 맞춰서 추가를 해주셔야 합니다.
	#각 게시판 사이에는 쉼표를 넣으셔서 구분해주셔야 하며 끝에는 쉼표를 넣으시면 안됩니다.
	#이곳에 추가해서 사용시 아래의 모든 변수의 해당위치에 값이 존재해야합니다. (경우에 따라 빈값도 상관없음)
	$search_result_type	= "0";		#검색된 결과가 없을경우에도 해당 파트 출력하고자 할경우 1 아닐경우 빈값
	$check_part	= Array(
					"구인"			=> 0,
					"구직"			=> 1,
					"공지사항"		=> 2,
					"구인구직 가이드"	=> 3,
					"행사/이벤트"	=> 4,
					"질문과답변"	=> 5,
					"잡(JOB)뉴스"	=> 6,
					"포토갤러리"	=> 7,
					"인재인터뷰"	=> 8,
					"자주묻는질문"	=> 9,
					"알바채용리스트"	=> 10,
					"알바구직리스트"	=> 11
				);

	#검색할 테이블명을 입력하시면 됩니다. ( tb )
	#형식은 동일합니다. 쉼표구분으로 구분해주시면 됩니다.
	// 검색할 테이블명 입력
	$search_table			= array($guin_tb,$per_document_tb,"board_notice","board_news","board_event","board_qna","board_jobinfo","board_photo","board_modelinterview","board_faq","board_albaguin","board_albaguzic");


	#검색할 필드명을 입력합니다.
	#게시판의 경우 bbs_title을 입력하시면 됩니다.
	#구분자는 마찬가지로 쉼표입니다.
	// 검색할 필드명 입력
	$search_field			= array(
								"guin_com_name+guin_title+guin_phone+guin_fax+guin_homepage+keyword",
								"title+user_name+user_addr1+user_addr2+user_homepage+keyword",
								"bbs_title",
								"bbs_title",
								"bbs_title",
								"bbs_title",
								"bbs_title",
								"bbs_title",
								"bbs_title",
								"bbs_title",
								"bbs_title",
								"bbs_title"
							);


	#number값을 입력하시면 됩니다. 위에서 추가된 개수만큼 만들어주셔야겠죠..
	// 검색결과 출력 순서
	$search_orderby			= array("number","number","number","number","number","number","number","number","number","number","number","number");

	#수정하지마세요.
	// 검색시 넘어오는 값 ex) search.php?keyword=kkk -> $search_keyword = "keyword";
	$search_keyword			= "all_keyword";

	#제목칼럼을 지정하는곳입니다.
	#게시판의 경우 bbs_title로 추가해주시면 됩니다.
	// 제목칼럼지정 (글자자르기위해)
	$search_title_field		= array("guin_title","title","bbs_title","bbs_title","bbs_title","bbs_title","bbs_title","bbs_title","bbs_title","bbs_title","bbs_title","bbs_title");

	#날짜칼럼을 입력하는곳입니다.
	#게시판의 경우 bbs_date입니다.
	// 날짜칼럼지정 (글자정리~)
	$search_date_field		= array("guin_date","regdate","bbs_date","bbs_date","bbs_date","bbs_date","bbs_date","bbs_date","bbs_date","bbs_date","bbs_date","bbs_date");

	#추가안하셔도 됩니다. - 특수상황시 사용
	// where에 들어갈 추가옵션.
	$sql_today = date("Y-m-d");
	$search_where			= array(" AND (guin_end_date >= '$sql_today' or guin_choongwon ='1') "," and display = 'Y' ","","","");

	#더많은 결과보기 링크주소 입니다.
	#게시판의 경우 아래와같이 링크합니다.
	# bbs_list.php?action=search&search=bbs_title&tb={{테이블명}}&keyword=
	# 위에서 {{테이블명}}에 해당하는 위치에 테이블명을 입력하시면 됩니다. (위와 똑같이 쓰시면 안됩니다^^)
	// 더많은결과링크주소
	$search_view_all_link	= array(
									"guin_list.php?action=search&title_read=",
									"guzic_list.php?action=search&guzic_keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_notice&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_news&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_event&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_qna&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_jobinfo&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_photo&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_modelinterview&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_faq&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_albaguin&keyword=",
									"bbs_list.php?action=search&search=bbs_title&tb=board_albaguzic&keyword="
							);


	#위 변수들은 반드시 개수가 동일해야 합니다. ( $search_where 과 $search_keyword 제외 )
	#수정하신후 temp/all_search.html 파일을 수정하시면 됩니다.
	#{{검색결과 제목50글자,가로1개,세로10개,all_search_bbs_faq.html,all_search_bbs_notice_rows.html,자주묻는질문}} 형식으로 사용됩니다.

############################################################################################################################



//이력서 스킨 타이틀
$doc_skinfilename = array ( 'doc_skin1.html' => '1번스킨' ,
										'doc_skin2.html' => '2번스킨' ,
										'doc_skin3.html' => '3번스킨' ,
										'doc_skin4.html' => '4번스킨' ,
										'doc_skin5.html' => '5번스킨'
									);




$main_banner_tb		= 'job_main_banner';
$main_banner_url	= 'flash_banner';
$main_banner_path	= "$path"."flash_banner";



#팝업설정
$popupMenuNames			= array($popupMenu1,$popupMenu2,$popupMenu3,$popupMenu4,$popupMenu5,$popupMenu6,$popupMenu7,$popupMenu8,$popupMenu9);//팝업카테고리설정
#팝업카테고리설정
#$popupCloseCookieDate	= 3;
#$popupCloseCookieMsg	= '3일동안 이창을 다시 열지 않습니다.';
$popupLinkTypeName		= array("부모창","새창","현재창","상위프레임","최상위프레임");
$popupLinkTypeValue		= array(
								"부모창"		=> "opener.window.location.href='{{linkUrl}}';{{closeScript}}",
								"새창"			=> "window.open('{{linkUrl}}','_blank');{{closeScript}}",
								"현재창"		=> "window.location.href='{{linkUrl}}';{{closeScript}}",
								"현재창레이어"	=> "window.location.href='{{linkUrl}}';",
								"상위프레임"	=> "window.open('{{linkUrl}}','_parent');{{closeScript}}",
								"최상위프레임"	=> "window.open('{{linkUrl}}','_top');{{closeScript}};"
							);


#메일링관련 추가
$mailing_send_size = "20";




#클라우드태그 개별설정
#1~10 개의 키워드를 둘러쌀 html 태그
#각각 등수에 맞게 폰트 및 배경을 다르게 하기 위해서는 모든 등수에 대해서 아래 배열이 존재해야 합니다.
#아래 설정은
#1~2위 같은 옵션 ,
#3~4위 같은 옵션,
#5~6위 같은 옵션,
#7~9위 같은 옵션
#10위 옵션
#으로 출력되는 예제
/*
$Cloudtag_FontBg = array (
							'1' => array (
										'font' => '<b><font color="#FFFFFF" size="14">',
										'bg' => $배경색상
									),
							'3' => array (
										'font' => '<b><font color="#'.$배경색상.'" size="14">',
										'bg' => ''
									),
							'8' => array (
										'font' => '<b><font color="#'.$배경색['그룹A'].'">',
										'bg' => ''
									),
							'11' => array (
										'font' => '',
										'bg' => ''
									)
							);
*/

$Cloudtag_FontBg = array (
							$CloudtagRank1 => array (
										'font' => $CloudtagRank1_Font,
										'bg' => $CloudtagRank1_Bg
									),
							$CloudtagRank2 => array (
										'font' => $CloudtagRank2_Font,
										'bg' => $CloudtagRank2_Bg
									),
							$CloudtagRank3 => array (
										'font' => $CloudtagRank3_Font,
										'bg' => $CloudtagRank3_Bg
									),
							$CloudtagRank4 => array (
										'font' => $CloudtagRank4_Font,
										'bg' => $CloudtagRank4_Bg
									)
							);




#클라우트태그 공통설정
/*
$cloudtag_Wgap = "15";					#가로갭
$cloudtag_Hgap = "0";					#세로갭
$cloudtag_Width = "180";					#가로사이즈
$cloudtag_selectCOLOR = "FFFFFF";		#선택컬러
$cloudtag_selectBG = $배경색['그룹A'];			#선택배경컬러
$cloudtag_cutlineCOLOR = "cccccc";	#구분선색상
*/


$happy_admin_ipTable	= $DB_Prefix."happy_admin_ipTable";
$happy_admin_ipCheck	= '';		# on/off
$happy_admin_ip			= Array (
									'192.168',
);									# IP설정


#####################################################
############ 절대 건드리지 마세요.  #################
#####################################################

	include("define_attack_check.php");

	$TemplateM_name	= Array(
							"게시판보기",
							"구인추출",
							"직종리스트",
							"구인리스트",
							"이력서리스트",

							"이력서추출",
							"서브카테고리출력",
							"직종전체보기",
							"검색결과",
							"실시간검색",

							"현재위치확인",
							"지하철플레쉬",
							"지도",
							"배너",
							"설문",

							"팝업",
							"티커구인추출",
							"미니앨범출력",
							"구인리스트아작스",
							"이력서리스트아작스",

							"플래시구인추출",
							"플래시이력서리스트",
							"구직회원결제내역",
							"포인트결제내역",
							"구인회원결제내역",

							"내가등록한구인리스트",
							"다음지도",
							"본인인증",
							"구글지도",
							"회원폼",

							"로그인박스",
							"게시판스케쥴",
							"온라인입사지원내역",
							"구름태그3d",
							"이미지",

							"텍스트이미지",
							"패키지보유리스트",
							"패키지리스트",
							"게시판목록추출",
							'네이버검색',

							'접속자리스트',
							'배경이미지리스트',
							'HTML호출',
							'글자자르기',
							'콤마',

							'배너스크롤',
							'슬라이드배너',
							'인코드',
							'검색그룹',
							'textarea_출력',

							'게시판제목',
							'게시판링크',
							'신고버튼',
							'카카오톡링크',

							'문의하기폼',
							'문의내역출력',
							'문의댓글출력',
							'즐겨찾기링크',
							'네이버블로그글전송',
							'실시간인기검색어롤링',

							'방문자수',
							'지도출력',
							'SNS로그인',
							'슬라이드배너_모바일',
							'메뉴출력',

							'위지윅에디터CSS',
							'위지윅에디터JS',
							'위지윅에디터',
							'날씨출력',
							'고용형태리스트',

							'모바일이미지업로드',
							'네이버톡톡버튼',
							'클라우드태그',
							'인클루드',
							'페이징노출옵션'
	);

	$TemplateM_func	= Array(
							"board_extraction_list",
							"guin_main_extraction",
							"jikjok_extraction_list",
							"guin_extraction",
							"document_extraction_list",

							"document_extraction_list_main",
							"make_category_list",
							"make_category_jikjong_list",
							"search_keyword_result",
							"keyword_rank_read",

							"call_now_nevi",
							"subway_flash",
							"echo naver_map_call",
							"echo happy_banner",
							"poll_read",

							"call_popup",
							"ticker_tag_maker",
							"mini_album_view",
							"guin_extraction_ajax",
							"document_extraction_list_ajax",

							"flash_guin_tag_maker",
							"flash_guzic_tag_maker",
							"echo jangboo_list_per",
							"echo point_jangboo_list",
							"echo jangboo_list_com",

							"echo guin_extraction_myreg",
							"daum_map_call",
							"namecheck",
							"google_map_call",
							"happy_member_user_form",

							"happy_member_login_form",
							"board_extraction_calendar",
							"echo online_jiwon_list",
							"cloud_tag_3d",
							"echo happy_image",

							"happy_text_image",
							"echo package_have_list",
							"package_list",
							"board_keyword_extraction",
							'echo naver_search_api',

							'echo call_connection',
							'echo bg_image_list',
							'include_template',
							'happy_string_cut',
							"echo happy_number_format",

							'happy_banner_scroll',
							'happy_banner_slide',
							'happy_urlencode',
							'search_group',
							'nl2br_print',

							'board_name_out',
							'board_link',
							'report_button',
							'echo kakaotalk_link',

							'happy_inquiry_form',
							'happy_inquiry_list',
							'happy_inquiry_comment_list',
							'echo add_bookmark_link',
							'echo naver_blog_send_btn',
							'keyword_rank_read_roll',

							'echo stats_print',
							'happy_map_call',
							'echo happy_sns_login',
							'happy_banner_slide_mobile',
							'happy_menu_list',

							'echo happy_wys_css',
							'echo happy_wys_js',
							'echo happy_wys',
							'echo happy_weather_print',
							'job_type_list',

							'happy_mobile_image_upload',
							'echo naver_talktalk_btn',
							'cloud_tag_txt',
							'include_template',
							'newPaging_option'
	);

	//헤드헌팅
	if ( $hunting_use == true )
	{
		array_push($TemplateM_name, "회사리스트");
		array_push($TemplateM_name, "회사박스");
		array_push($TemplateM_name, "헤드헌팅검색박스");
		array_push($TemplateM_func, "company_extraction_list");
		array_push($TemplateM_func, "company_select_box");
		array_push($TemplateM_func, "company_search_box");
	}

#####################################################


$happy_weather_areas = Array('서울','인천','대전','대구','광주','부산','제주','강릉','강진군','강화','거제','거창','경주시','고산','고창','고창군','고흥','광양시','구미','군산','금산','김해시','남원','남해','대관령','동두천','동해','목포','문경','밀양','백령도','보령','보성군','보은','봉화','부안','부여','북강릉','북창원','북춘천','산청','상주','서귀포','서산','성산','속초','수원','순창군','순천','안동','양산시','양평','여수','영광군','영덕','영월','영주','영천','완도','울릉도','울산','울진','원주','의령군','의성','이천','인제','임실','장수','장흥','전주','정선군','정읍','제천','진도','진도군','진주','창원','천안','철원','청송군','청주','추풍령','춘천','충주','태백','통영','파주','포항','함양군','합천','해남','홍성','홍천','흑산도');


#휴대폰번호 Array
$TCellNumbers = explode("\n",str_replace("\r","",trim($HAPPY_CONFIG['CellNumbers'])));

#지역번호 Array
$TPhoneNumbers = explode("\n",str_replace("\r","",trim($HAPPY_CONFIG['PhoneNumbers'])));

#이메일계정 Array
$TEmailAccount = explode("\n",str_replace("\r","",trim($HAPPY_CONFIG['EmailAccounts'])));

#근무가능요일 Array
$TDayIcons = array($IconMonday1,$IconTuesday1,$IconWednesday1,$IconThursday1,$IconFriday1,$IconSaturday1,$IconSunday1);
$TDayNames = array ( "월","화","수","목","금","토","일");
$TDayIconsTag = array(
							'<img src="'.$IconMonday1.'" border="0" align="absmiddle">',
							'<img src="'.$IconTuesday1.'" border="0" align="absmiddle">',
							'<img src="'.$IconWednesday1.'" border="0" align="absmiddle">',
							'<img src="'.$IconThursday1.'" border="0" align="absmiddle">',
							'<img src="'.$IconFriday1.'" border="0" align="absmiddle">',
							'<img src="'.$IconSaturday1.'" border="0" align="absmiddle">',
							'<img src="'.$IconSunday1.'" border="0" align="absmiddle">'
						);
#근무가능요일 Array

#근무시간 Array
$TTime1 = array("오전","오후");
$TTime2 = array("01","02","03","04","05","06","07","08","09","10","11","12");
$TTime3 = array("00분","30분");

#구직자
$TGuzicPerson = array($GuzicPerson1,$GuzicPerson2);
#학력
$TEducation = array($Education1,$Education2,$Education3,$Education4,$Education5);
#국적
$TNational = array($National1,$National2,$National3,$National4);
#결혼
$TMarried = array($Married1,$Married2);
#자격/수료증
$TLicence = array($Licence1,$Licence2);
#파견업체연락
$TSiCompany = array($SiCompany1,$SiCompany2);
#금지단어
$TDenyWordList = explode(",",$DenyWordList);
#구인자
$TGuinPerson = array($GuzicPerson1,$GuzicPerson2);

#최근등록일부터 몇일?
$TLastRegDayCnt = "300";
$TLastRegDay = array();
$TLastRegDayN= array();
for($i=1;$i<=$TLastRegDayCnt;$i++)
{
	$o = $i." 일전";
	array_push($TLastRegDayN,$o);
	array_push($TLastRegDay,$i);
}

#print_r($TDenyWordList);
//print_r($TEmailAccount);







###############################################################################
#함수모음
#관리자모드로 안뽑아도 되는 코드들은 이 아래로
#
#
#
#
###############################################################################

function utfstrcut($str, $len, $tail='...'){
	global $utf_add_cut;

	if ($len > 15)
	{
		$len = $len - $utf_add_cut;
	}

	$rtn = array();
	return preg_match('/.{'.$len.'}/su', $str, $rtn) ? $rtn[0].$tail : $str;
}



function go_top($url) {
print <<<END
<html>
<script>
window.top.location.replace("$url");
</script>
</html>
END;
exit;
}

function valueprint( $Arrays, $depth ) {
	foreach ( $Arrays as $key )
	{
		$updepth = $depth + 1;
		for ( $i=0 ; $i<$depth ; $i++ )
		{
			echo "&nbsp; &nbsp; &nbsp; ";
		}
		echo "★ <font color=red>".key($Arrays) ."</font> : ";
		next($Arrays);
		echo $key."<br>";

		if ( is_array($key) )
		valueprint( $key, $updepth );
	}
}
#valueprint($GLOBALS , 0);

#다행방식
function conf_read()
{
	global $value,$CONF,$conf_table;

	$sql4		= "select * from $conf_table ";
	$result4	= query($sql4);

	while (list($number,$title,$value,$option,$max,$subject,$pay_use,$pay_necessary) = mysql_fetch_row($result4))
	{
		$title_option			= "$title" . "_option";
		$title_max				= "$title" . "_max";
		$title_subject = $title."_title";
		$title_use = $title."_use";
		$title_necessary = $title."_necessary";

		$CONF[$title]			= $value;
		$CONF[$title_option]	= $option;
		$CONF[$title_max]		= $max;
		$CONF[$title_subject] = $subject;
		$CONF[$title_use] = $pay_use;
		$CONF[$title_necessary] = $pay_necessary;
	}
}

function read_RGB()
{
	global $배경색상, $배경색, $MConf, $happy_menu_conf;
	global $배경색상RGB;

	$Sql		= "SELECT * FROM $happy_menu_conf ORDER BY number DESC ";
	$MenuRec	= query($Sql);

	while ( $MConf = happy_mysql_fetch_array($MenuRec) )
	{
		$MenuRecType	= $MConf['type'];
		if ( $MConf['type'] == '' )
		{
			$MenuRecType	= 'happy_default';
		}
		$배경색[$MenuRecType]	= str_replace('#','',$MConf['conf_bgcolor']);
		#echo $MenuRec['type']."<hr>";
	}

	$배경색상	= $배경색['happy_default'];

	//배경색상 RGB
	$배경색상RGB = happy_colortorgb($배경색상);

	//echo $배경색상RGB;
}



function happy_colortorgb($color)
{
	$color = str_replace('#','',$color);

	$sep = ",";

	$rgb = "255".$sep."255".$sep."255";

	if ( strlen($color) != 6 )
	{
		return $rgb;
	}
	else
	{
		$r = hexdec('0x'.$color[0].$color[1]);
		$g = hexdec('0x'.$color[2].$color[3]);
		$b = hexdec('0x'.$color[4].$color[5]);

		$rgb = $r.$sep.$g.$sep.$b;

		return $rgb;
	}
}

//RGB 색상값 구하기
read_RGB();
//RGB 색상값 구하기

function si_read()
{
	global $value,$SI,$si_tb,$SI_NUMBER,$SI_ARRAY,$SI_ARRAY_NAME;
	global $Area_All_Number;

	$sql4		= "select * from $si_tb order by sort_number asc";
	$result4	= query($sql4);
	$SI_ARRAY	= array();
	$SI_ARRAY_NAME	= array();

	while (list($number,$si,$sort_number) = mysql_fetch_row($result4))
	{
		$SI[$number]	= $si;
		$SI_NUMBER[$si]	= $number;
		array_push($SI_ARRAY,$number);
		array_push($SI_ARRAY_NAME,$si);
	}

	$SI_NUMBER[전국]	= $Area_All_Number;

	if ( $SI_NUMBER[전국] == '' )
		$SI_NUMBER[전국]	= '999999999';
}

//지역개선작업
function gu_read()
{
	global $value,$GU,$GU_NUMBER,$GU_ARRAY_NAME,$gu_tb;

	global $GU_NUMBER2, $gu_temp_array, $gu_temp_array2;

	$sql4		= "select * from $gu_tb ";
	$result4	= query($sql4);
	$GU_ARRAY_NAME	= Array();
	while (list($number,$si,$gu) = mysql_fetch_row($result4))
	{
		$GU[$number]	= $gu;
		$GU_NUMBER[$gu]	= $number;

		$GU_NUMBER2[$si][$gu]	= $number;

		array_push($GU_ARRAY_NAME,$gu);
	}

	$sql = "select number, si, gu from $gu_tb";
	$record = query($sql);
	$gu_temp_array = array();
	while ( $rows = happy_mysql_fetch_assoc($record) )
	{
		$temp = explode(" ", $rows['gu']); // 예제) 고양시 덕양구 , 고양시 일산동구

		if ( sizeof($temp) > 1 && $GU_NUMBER2[$rows['si']][$temp[0]] != '' )
		{
			$gu_number = $GU_NUMBER2[$rows['si']][$temp[0]];

			if ( $gu_temp_array["부모값_".$gu_number] != 'sub' && $gu_number != '' )
			{
				$gu_temp_array["부모값_".$gu_number]			= 'sub';
				$gu_temp_array2["오리지날_".$rows['number']]	= $gu_number;
			}
		}
	}
}
//지역개선작업

function type_read()
{
	global $value,$TYPE,$TYPE_NUMBER,$type_tb,$TYPE_ARRAY,$TYPE_ARRAY_NAME;
	$sql4		= "select * from $type_tb order by sort_number asc ";
	$result4	= query($sql4);
	$TYPE_ARRAY	= array();
	$TYPE_ARRAY_NAME	= array();
	while (list($number,$si,$gu) = mysql_fetch_row($result4))
	{
		$TYPE[$number]		= $si;
		$TYPE_NUMBER[$si]	= $number;
		array_push($TYPE_ARRAY,$number);
		array_push($TYPE_ARRAY_NAME,$si);
	}
}
function type_sub_read()
{
	global $value,$TYPE_SUB,$TYPE_SUB_NUMBER,$TYPE_SUB_NAME,$type_sub_tb;
	$sql4		= "select * from $type_sub_tb ";
	$result4	= query($sql4);
	$TYPE_SUB_NAME	= Array();
	while (list($number,$si,$gu) = mysql_fetch_row($result4))
	{
		$TYPE_SUB[$number]		= $gu;
		$TYPE_SUB_NUMBER[$gu]	= $number;
		array_push($TYPE_SUB_NAME,$gu);
	}
}
function type_sub_sub_read()
{
	global $value,$TYPE_SUB_SUB,$TYPE_SUB_SUB_NUMBER,$TYPE_SUB_SUB_NAME,$type_sub_sub_tb;
	$sql4		= "select * from $type_sub_sub_tb ";
	$result4	= query($sql4);
	$TYPE_SUB_SUB_NAME	= Array();
	while (list($number,$si,$gu) = mysql_fetch_row($result4))
	{
		$TYPE_SUB_SUB[$number]		= $gu;
		$TYPE_SUB_SUB_NUMBER[$gu]	= $number;
		array_push($TYPE_SUB_SUB_NAME,$gu);
	}
}


function job_read()
{
	global $value,$CONF,$conf_table;
	$sql4		= "select * from $conf_table ";
	$result4	= query($sql4);
	while (list($number,$title,$value,$option,$max,$subject,$pay_use,$pay_necessary) = mysql_fetch_row($result4))
	{
		$title_option			= "$title" . "_option";
		$title_max				= "$title" . "_max";
		$title_subject = $title."_title";
		$title_use = $title."_use";
		$title_necessary = $title."_necessary";

		$CONF[$title]			= $value;
		$CONF[$title_option]	= $option;
		$CONF[$title_max]		= $max;
		$CONF[$title_subject] = $subject;
		$CONF[$title_use] = $pay_use;
		$CONF[$title_necessary] = $pay_necessary;
	}
}


#일열방식
function admin_read()
{
	global $value,$ADMIN,$admin_tb;
	$sql4 = "select * from $admin_tb where number = '1' ";
	$result4 = query($sql4);
	$ADMIN = happy_mysql_fetch_array($result4);
}


////////////////////////////인스톨

function send_mail_ok($to_email,$from_name,$subject,$from_email,$send_main)
{

	$headers	 = "From: $from_name <$admin_email>\n";
	$headers	.= "Reply-to: $admin_email\n";
	$headers	.= "Return-Path: $admin_email\n";
	$headers	.= "Content-Type: text/html; charset=utf-8";

	mail ($com_email,$subject,$send_main,$headers);


}

function image_resize($imgfile, $width, $height,$border,$border_color,$hspace, $vspace)
{

	if ( !$border ) {	$border = 0; }
	$temp = getimagesize($imgfile);

	if ( ( $temp[0] / $width ) > ( $temp[1] / $height ) ){
		$new_width		= $width;
		 $new_height	= ($temp[1]* $width) / $temp[0];
		 $new_width		= round($new_width);
		 $new_height	= round($new_height);
		return "<img src='$imgfile' width='$new_width' height='$new_height' border='$border' style='border-color=$border_color' hspace='$hspace' vspace='$vspace' align='absmiddle'>";
	}
	else {
		$new_height		= $height;
		 $new_width		= ($temp[0]* $height) / $temp[1];
		 $new_width		= round($new_width);
		 $new_height	= round($new_height);
		return "<img src='$imgfile' width='$new_width' height='$new_height'  border='$border' style='border-color=$border_color' hspace='$hspace' vspace='$vspace' align='absmiddle'>";
	}
}


// 카테고리 추가
function get_type_selectbox_js()
{
	global $type_sub_tb, $type_sub_sub_tb;

	$return_arr	= array();

	$type2_arr	= array();
	$sql		= "SELECT * FROM {$type_sub_tb} ORDER BY sort_number ASC";
	$rec		= query($sql);
	while($row = mysql_fetch_assoc($rec))
	{
		$type2_arr[$row['type']][$row['number']]	= $row['type_sub'];
	}

	$type2_key_js	= "var type2_key = new Array();" . PHP_EOL;
	$type2_val_js	= "var type2_val = new Array();" . PHP_EOL;
	foreach($type2_arr AS $key => $val)
	{
		$type2_key_js	.= "type2_key[{$key}] = new Array(";
		$type2_val_js	.= "type2_val[{$key}] = new Array(";
		$type2_key_tmp	= array();
		$type2_val_tmp	= array();
		foreach($val AS $key2 => $val2)
		{
			$type2_key_tmp[]    = "'{$key2}'";
			$type2_val_tmp[]    = "'{$val2}'";
		}
		$type2_key_js    .= @implode(",",$type2_key_tmp);
		$type2_val_js    .= @implode(",",$type2_val_tmp);

		$type2_key_js    .= ");".PHP_EOL;
		$type2_val_js    .= ");".PHP_EOL;
	}

	$type3_arr	= array();
	$sql		= "SELECT * FROM {$type_sub_sub_tb} ORDER BY sort_number ASC";
	$rec		= query($sql);
	while($row = mysql_fetch_assoc($rec))
	{
		$type3_arr[$row['type_sub']][$row['number']]	= $row['title'];
	}

	$type3_key_js	= "var type3_key = new Array();" . PHP_EOL;
	$type3_val_js	= "var type3_val = new Array();" . PHP_EOL;
	foreach($type3_arr AS $key => $val)
	{
		$type3_key_js	.= "type3_key[{$key}] = new Array(";
		$type3_val_js	.= "type3_val[{$key}] = new Array(";
		$type3_key_tmp	= array();
		$type3_val_tmp	= array();
		foreach($val AS $key2 => $val2)
		{
			$type3_key_tmp[]	= "'{$key2}'";
			$type3_val_tmp[]	= "'{$val2}'";
		}
		$type3_key_js	.= @implode(",",$type3_key_tmp);
		$type3_val_js	.= @implode(",",$type3_val_tmp);

		$type3_key_js	.= ");".PHP_EOL;
		$type3_val_js	.= ");".PHP_EOL;
	}

	$return_arr['type2_key_js']	= $type2_key_js;
	$return_arr['type2_val_js']	= $type2_val_js;
	$return_arr['type3_key_js']	= $type3_key_js;
	$return_arr['type3_val_js']	= $type3_val_js;

	return $return_arr;
}

$selectbox_js_arr	= get_type_selectbox_js();
$type2_key_js		= $selectbox_js_arr['type2_key_js'];
$type2_val_js		= $selectbox_js_arr['type2_val_js'];
$type3_key_js		= $selectbox_js_arr['type3_key_js'];
$type3_val_js		= $selectbox_js_arr['type3_val_js'];

function search_form()
{
	global $job_type_read,$구인타입,$job_arr,$search_si,$search_gu,$search_type,$search_type_sub, $확장지역검색 ,  $확장업종검색,
	$학력검색,$edu_arr,$money_arr,$grade_arr,$검색부분,$심플검색부분,$확장검색부분,$상세검색부분, $숨은검색부분,$career,
	$area,$TPL,$search_form,$지역검색,$직급선택,$업종검색,$경력검색,$성별검색,$연봉검색,$최종학력체크박스,$고용형태체크박스,$연령검색박스,$학력검색타입,
	$area_read,$jobclass_read,$edu_read,$career_read, $career_start_arr, $career_end_arr, $gender_read,$title_read,$type_read,$pay_read,$grade_read,$skin_folder,$career_arr, $경력검색시작, $경력검색종료;
	global $document_keyword,$키워드검색박스,$keyword_read;
	//print "$search_gu / $search_si";

	//인기검색어드랍 2011-07-27 kad
	global $auto_search_tb, $자동완성검색;

	global $메인검색부분모바일,$확장업종검색모바일,$확장지역검색모바일,$확장지역검색통합,$확장지역검색모바일2;
	global $확장지역검색_구인, $guzic_si, $guzic_gu;

	$지역검색		= make_si_selectbox("search_si","search_gu","$search_si","$search_gu","275","275","s_f_guin");
	$확장지역검색	= make_si_selectbox("search_si","search_gu","$search_si","$search_gu","327","327","a_f_guin");
	$확장지역검색모바일	= make_si_selectbox("search_si","search_gu","$search_si","$search_gu","100%","100%","a_f_guin2");
	$확장지역검색모바일2	= make_si_selectbox("search_si","search_gu","$search_si","$search_gu","200","200","a_f_guin2");

	$확장지역검색_구인	= make_si_selectbox("guzic_si","guzic_gu","$guzic_si","$guzic_gu","275","275","a_f_guin");

	$search_si2 = "";
	if ( $_GET['search_si'] != "" )
	{
		$search_si2 = $_GET['search_si'];
	}
	else if ( $_GET['guzic_si'] != "" )
	{
		$search_si2 = $_GET['guzic_si'];
	}
	$search_gu2 = "";
	if ( $_GET['search_gu'] != "" )
	{
		$search_gu2 = $_GET['search_gu'];
	}
	else if ( $_GET['guzic_gu'] != "" )
	{
		$search_gu2 = $_GET['guzic_gu'];
	}

	$확장지역검색통합	= make_si_selectbox("search_si","",$search_si2,"","80","0","search_frm","시만출력");

	$search_type	= ( $search_type == "" )?$_GET["guzic_jobtype1"]:$search_type;
	$search_type_sub	= ( $search_type_sub == "" )?$_GET["guzic_jobtype2"]:$search_type_sub;
	$업종검색		= make_type_selectbox("search_type","search_type_sub","$search_type","$search_type_sub","275","275","s_f_guin");

	//$확장업종검색	= make_type_selectbox("search_type","search_type_sub","$search_type","$search_type_sub","275","275","a_f_guin");
	global $type_opt,$type_sub_opt,$type_sub_sub_opt;
	$js_arr				= get_type_selectbox($search_type,$search_type_sub,$search_type_sub_sub);
	$type_opt			= $js_arr['type_opt'];
	$type_sub_opt		= $js_arr['type_sub_opt'];
	$type_sub_sub_opt	= $js_arr['type_sub_sub_opt'];
	$확장업종검색모바일	= make_type_selectbox("search_type","search_type_sub","$search_type","$search_type_sub","100%","100%","a_f_guin2");

	$구인타입		= make_selectbox($job_arr,'--선택--',job_type_read,"$job_type_read");


	$career			= $career_arr;
	$career_start	= $career_start_arr;
	$career_end		= $career_end_arr;
	array_unshift($career,"신입");

	$career_read	= $career_read == '' ? $_GET['career_read_start'] : $career_read;
	$경력검색		= make_selectbox($career,'--선택--',career_read,"$career_read");

	$경력검색시작	= make_selectbox($career_start,'--선택--',career_read_start,$_GET['career_read_start']);
	$경력검색종료	= make_selectbox($career_end,'--선택--',career_read_end,$_GET['career_read_end']);

	$gender			= array('무관','남자','여자');
	$성별검색		= make_selectbox($gender,'--선택--',gender_read,"$gender_read");
	$연봉검색		= make_selectbox($money_arr,'--선택--',pay_read,"$pay_read");
	$학력검색		= make_selectbox($edu_arr,'--선택--',edu_read,"$edu_read");
	$학력검색타입	= make_selectbox(array("이상","이하"),'---선택---',guzic_school_type,$_GET['guzic_school_type']);

	global $edu_arr2,$학력검색_구인;
	$학력검색_구인	= make_selectbox($edu_arr2,'--선택--',edu_read,"$edu_read");

	$직급선택		= make_selectbox($grade_arr,'--선택--',grade_read,"$grade_read");

	$최종학력체크박스	= make_checkbox2( $edu_arr, $edu_arr, 4, "edu_read", "edu_read", "__".@implode("__", (array) $_GET["edu_read"])."__","__");

	$고용형태체크박스	= make_checkbox2( $job_arr, $job_arr, 4, "job_type_read", "job_type_read", "__".@implode("__", (array) $_GET["job_type_read"])."__","__");

	$연령검색박스	= dateSelectBox( "guin_age", 2010, 1900, $_GET["guin_age"], "년생", "연령선택", "" , -1);

	$키워드검색박스 = make_selectbox($document_keyword,'--선택--',keyword_read,"$keyword_read");


	//인기검색어드랍 2011-07-27 kad
	$auto_check = happy_mysql_fetch_array(query("select * from $auto_search_tb where number = 1"));
	if( $auto_check["auto_use"] )
	{
		//$자동완성검색 = " onkeyup=\"startMethod();\" onmouseup=\"startMethod();\" AUTOCOMPLETE=\"off\"";
		$자동완성검색 = " onkeyup=\"startMethod(event.keyCode);\" onkeydown=\"moveLayer(event.keyCode);\" onmouseup=\"startMethod();\" AUTOCOMPLETE=\"off\"";

	}
	//인기검색어드랍 2011-07-27 kad


	//채용정보 유료옵션별 검색 추가 hong
	global $ARRAY_SEARCH, $ARRAY_SEARCH_NAME, $구인옵션검색, $search_option;
	$구인옵션검색	= make_selectbox2($ARRAY_SEARCH_NAME,$ARRAY_SEARCH,'--선택--',search_option,"$search_option");


	if(!preg_match("/pg_module/",$_SERVER['PHP_SELF']))
	{
		$search_form	= "";
		$TPL->define("구인검색", "./$skin_folder/search_form.html");
		$TPL->assign("구인검색");
		$tmp_guin		= &$TPL->fetch("구인검색");
		$search_form	.= $tmp_guin;
		$검색부분		= $search_form;

		$search_form	= "";
		$TPL->define("구인검색1", "./$skin_folder/search_form_advance.html");
		$TPL->assign("구인검색1");
		$tmp_guin		= &$TPL->fetch("구인검색1");
		$search_form	.= $tmp_guin;
		$확장검색부분	= $search_form;

		$search_form	= "";
		$TPL->define("구인검색2", "./$skin_folder/search_form_simple.html");
		$TPL->assign("구인검색2");
		$tmp_guin		= &$TPL->fetch("구인검색2");
		$search_form	.= $tmp_guin;
		$심플검색부분	= $search_form;


		$search_form	= "";
		$TPL->define("구인검색3", "./$skin_folder/search_form_hard.html");
		$TPL->assign("구인검색3");
		$tmp_guin		= &$TPL->fetch("구인검색3");
		$search_form	.= $tmp_guin;
		$상세검색부분	= $search_form;


		$search_form	= "";
		$TPL->define("구인검색4", "./$skin_folder/search_form_hidden.html");
		$TPL->assign("구인검색4");
		$tmp_guin		= &$TPL->fetch("구인검색4");
		$search_form	.= $tmp_guin;
		$숨은검색부분	= $search_form;
	}

}


#안쓰는 로그인 파일 부분은 주석처리
function adultjob_login()
{
	//회원로그인 기능
	global $mem_id,$member_id,$demo_lock,$demos;
	global $배경색상;
	global $point_form, $HAPPY_CONFIG;
	global $happy_member_option_type;
	global $happy_member,$userid;
	global $MEM;
	global $사용자이름;

	if ( happy_member_login_check() == "" )
	{
		if ( $demo_lock )
		{
			$demos["script_per"]	= "onClick=\"changeIMG(1);changeIMG(2);document.happy_member_login_form.member_id.value='asdf'; document.happy_member_login_form.member_pass.value='asdf';\"";
			$demos["script_com"]	= "onClick=\"changeIMG(1);changeIMG(2);document.happy_member_login_form.member_id.value='test'; document.happy_member_login_form.member_pass.value='test';\"";
			$demos["onload_per"]	= "<script>changeIMG(1);changeIMG(2);document.happy_member_login_form.member_id.value='asdf'; document.happy_member_login_form.member_pass.value='asdf';</script>";
			$demos["onload_com"]	= "<script>changeIMG(1);changeIMG(2);document.happy_member_login_form.member_id.value='test'; document.happy_member_login_form.member_pass.value='test';</script>";
		}
	}
	else
	{

		if ( $demo_lock && $_GET['file'] == "adultcheck_only.html" )
		{
			$demos["onload_kcb"]	= "<script>document.regiform.name.value='CGIMALL'; document.regiform.joomin1.value='750101';document.regiform.joomin2.value='2222222';</script>";
		}

		$sql = "SELECT * FROM $happy_member WHERE user_id='$userid' ";
		$result = query($sql);
		$MEM = happy_mysql_fetch_array($result);

		//기존회원기능과 다른 변수명들 유지
		$MEM['id'] = $MEM['user_id'];
		$MEM['per_name'] = $MEM['user_name'];
		$사용자이름 = $MEM['user_name'];

		if ( $HAPPY_CONFIG['point_conf'] == "1" )
		{
			if ( happy_member_secure('포인트기능') )
			{
				#포인트추가됨
				$Data['point'] = number_format($MEM['point']);
				$point_form = "
				<table cellspacing='0' style='width:100%;'>
				<tr style='display:$HAPPY_CONFIG[point_charge_jangboo_use];'>
					<td><img src='img/icon_login_point.gif' align='absmiddle'> <img alt='' src='happy_imgmaker.php?fsize=9&news_title=$Data[point]&outfont=NanumGothicExtraBold&fcolor=86,86,86&format=PNG&bgcolor=255,255,255' align='absmiddle'/></td>
					<td align='right' style='display:$HAPPY_CONFIG[point_charge_use];'><img src='img/btn_login_point_charge.gif' border='0' alt='포인트충전' onclick=\"window.open('my_point_charge.php','charge_win','width=440,height=360,scrollbars=no')\" style='cursor:pointer' align='absmiddle'></td>
				</tr>
				</table>
				";
				#포인트추가됨
			}
			else
			{
				$point_form = "";
			}
		}

		$mem_id		= $member_id;
		$회원아이디	= $member_id;

		$MEM['point_comma'] = number_format($MEM['point']);
	}

	return $main_logon;
}


function submit_msg( $msg , $url="" )
{
	echo "<script>parent.submit_change();alert('$msg');</script>";

	if ( $url != "" && $url != "[none]" )
	{
		echo "<script>parent.window.location.href = '$url'; </script>";
	}
	exit;
}

function html_remove( $str )
{
	$str	= str_replace("&","&amp;",$str);
	$str	= str_replace("<","&lt;",$str);
	$str	= str_replace(">","&gt;",$str);
	return $str;
}


#구글날씨 기본 지역설정
$google_weather_area = 'Daegu';

//print_r($배경색);


##############	검색에 사용될 name 과 value 추가! 2010-06-24 Hun  START  ################
$member_search_name_com			= Array("아이디","이름","주소","이메일","전화번호","핸드폰");
$member_search_value_com		= Array("id","com_name","com_addr1","com_email","com_phone","com_cell");

$member_search_name_per			= Array("아이디","이름","주소","이메일","전화번호","핸드폰");
$member_search_value_per		= Array("id","per_name","per_addr1","per_email","per_phone","per_cell");

$member_level_search_name	= Array("정회원","준회원");
$member_level_search_value	= Array("1", "2");

#생년월일은 function.php에 admin.php에 선언되어 있습니다.
#이유 없이 계속 불려져서 연산하는 것을 막기 위해서.. admin.php에 선언함!

$member_sex_search_name		= Array("남성","여성");
$member_sex_search_value	= Array("남자","여자");


//채용정보 볼드 옵션일때 리스트 추출시 제목 색상지정
//$guin_title_color = "red";


##############	결제 통계에 사용될 금액들과 설정들 추가됨! 2010-09-24 Hun START #########
$pay_moneys			= Array("1000", "5000", "10000", "30000", "50000", "etc");
$pay_moneys_value	= Array("1000 이하", "1000 ~ 5000", "5000 ~ 10000", "10000 ~ 30000", "30000 ~ 50000", "50000 이상");

$pay_type			= Array("핸드폰","실시간","포인트","계좌","카드");
##############	결제 통계에 사용될 금액들과 설정들 추가됨! 2010-09-24 Hun END #########



function write_log($file, $noti) {
	$fp = fopen($file, "a+");
	ob_start();
	print_r($noti);
	$msg = ob_get_contents();
	ob_end_clean();
	fwrite($fp, $msg);
	fclose($fp);
}

function print_r3($var)
{
	ob_start();
	print_r($var);
	$str = ob_get_contents();
	ob_end_clean();
	$str = preg_replace("/ /", "&nbsp;", $str);
	echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
}


#로그인 체크 하자!		쿠키를 이용한 정보노출, 해킹 때문에 추가 하였습니다.
function login_check($Login_Value_Type)
{
	global $happy_member,$happy_member_login_value_url,$admin_member,$admin_id,$admin_pw;

	//print_r($_COOKIE);
	if($Login_Value_Type == 'cookie')
	{
		if($_COOKIE['happyjob_userid'] != '')
		{
			$Sql			= "
								SELECT
										user_pass
								FROM
										$happy_member
								WHERE
										user_id = '".addslashes($_COOKIE[happyjob_userid])."'
			";
			list($user_pass) = happy_mysql_fetch_array(query($Sql));


			if($_COOKIE['job_password'] != $user_pass || $_COOKIE['job_password'] == '')
			{
				setcookie("job_level",'',0,"/",$happy_member_login_value_url);
				setcookie("job_name",'',0,"/",$happy_member_login_value_url);
				setcookie("happyjob_userid",'',0,"/",$happy_member_login_value_url);
				setcookie("job_password",'',0,"/",$happy_member_login_value_url);

				go("./");
				exit;
			}
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
			list($ad_pass)	= happy_mysql_fetch_array(query($Sql));

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



if($demo_lock == '' && !preg_match("/ajax_sns_login\.php|pg_db_update\.php/",$_SERVER['REQUEST_URI']) )
{
	login_check($happy_member_login_value_type);
}


//자동완성단어 레이어영역에 단어(줄)수
$자동완성수 = 8;


################################################################################
//모바일 관련 설정
$m_version				= '1'; #모바일솔루션 지원

$where_mobile			= " AND mobile_mode = '' ";
if ( $m_version != '' && $_COOKIE['happy_mobile'] == 'on' )
{
	$where_mobile			= " AND mobile_mode = 'y' ";
}

$naver_no_member_call_id	= 'test';		# 비회원으로 지도 인접매물검색 페이지 접근시 기준점이 되어야 할 회원의 주소 (아이디입력)

//모바일 템플릿 기능 추가.
$file_name_view_option	= $HAPPY_CONFIG['template_view'];		// 1일경우 템플릿 파일명 출력
//$file_name_view_option	= 1;		// 1일경우 템플릿 파일명 출력
$template_tag_view_option = $HAPPY_CONFIG['template_tag_view'];   #디자인작업시 템플릿 태그 확인용


# 일단 둘다 전체(대한민국)맵이 나오게 변수통일
if ( $m_version && $_COOKIE['happy_mobile'] == 'on' )
{
	$boodong_metor	= 50000;	# 인접 지역 검색시 몇 미터 이하의 매물 검색
}
else
{
	$boodong_metor	= 50000;	# 인접 지역 검색시 몇 미터 이하의 매물 검색
}

//인접매물검색시 범위 단위는 미터임
$search_metor = "100000";


//2011.03.21 hun 패치함.
if(preg_match("/admin/",$SCRIPT_NAME) )
{
	@setcookie("happy_mobile","off",0,"/", $cookie_url);
	$_COOKIE['happy_mobile'] = "off";
	$happy_mobile = "off";
}


if ($m_version)
{
	include($path."m/mobile_function.php");
}

$where_mobile			= " AND mobile_mode = '' ";
if ( $m_version != '' && $_COOKIE['happy_mobile'] == 'on' )
{
	$where_mobile			= " AND mobile_mode = 'y' ";
}


//모바일일때 유료옵션 색상을 교체
if ( $_COOKIE['happy_mobile'] == "on" )
{
	$doc_title_color = $doc_title_color_mobile;
	$HAPPY_CONFIG['doc_title_color'] = $doc_title_color_mobile;

	$doc_title_bgcolor = $doc_title_bgcolor_mobile;
	$HAPPY_CONFIG['doc_title_bgcolor'] = $doc_title_bgcolor_mobile;

	$guin_title_bgcolor = $guin_title_bgcolor_mobile;
	$HAPPY_CONFIG['guin_title_bgcolor'] = $guin_title_bgcolor_mobile;

	$guin_title_color = $guin_title_color_mobile;
	$HAPPY_CONFIG['guin_title_color'] = $guin_title_color_mobile;

	$guin_title_bold = $guin_title_bold_mobile;
	$HAPPY_CONFIG['guin_title_bold'] = $guin_title_bold_mobile;

	//온라인입사지원
	//$com_guin_per_button[0]	= "<img src='".$HAPPY_CONFIG['bt_gujik_send1_mobile']."' alt='온라인입사지원버튼' >";
}


//위치기반
$wgs_get_type				= $HAPPY_CONFIG['wide_map_type'];					# 지역정보 호출을 구글에서 할지? 네이버에서 할지?

$wgs_setting['type']		= 'auto_no';					# auto : 위도 기준으로 1초당 거리를 자동으로 계산
													# 기타값 : 수동으로 1초당 거리를 입력 ( $wgs_setting['xpoint'] , $wgs_setting['ypoint'] 값에 강제로 입력 해야함 )
$wgs_setting['xpoint']		= 30.828;					# 위도 1초의 길이 (M) 강제지정
$wgs_setting['ypoint']		= 24.697;					# 경도 1초의 길이 (M) 강제지정

##############	인접매물검색 반경 범위 추가됨!	2010-06-17 ralear START	###############
$memul_search_range = Array("10000","20000");	// 미터 단위
##############	인접매물검색 반경 범위 추가됨!	2010-06-17 ralear END	###############

// 와이드맵 파일명
$happy_wide_map_fileName	= '/happy_map.php';
$happy_wide_map_fileName2	= '/happy_map_guzic.php';
//위치기반
################################################################################



	############# Naver Open API (search) ##############
	$naver_search_local_st	= '대구광역시 달서구 두류동 776-9';


	$naver_search_type		= Array(
								'지식인'	=> Array(
													'target'	=> 'kin',
													'response'	=> Array('title', 'link', 'description')
											),
								'책'		=> Array(
													'target'	=> 'book',
													'response'	=> Array('title', 'link', 'description', 'image', 'author', 'price', 'discount', 'publisher', 'pubdate', 'isbn')
											),
								'쇼핑'		=> Array(
													'target'	=> 'shop',
													'response'	=> Array('title', 'link', 'image', 'lprice', 'hprice', 'mallName')
											),
								'카페'		=> Array(
													'target'	=> 'cafe',
													'response'	=> Array('title', 'link', 'description', 'ranking', 'member', 'totalarticles', 'newarticles')
											),
								'영화'		=> Array(
													'target'	=> 'movie',
													'response'	=> Array('title', 'link', 'image', 'subtitle', 'pubDate', 'director', 'actor', 'userRating')
											),
								'자동차'	=> Array(
													'target'	=> 'car',
													'response'	=> Array('title', 'link', 'image', 'pubDate', 'maker', 'type')
											),
								'카페글'	=> Array(
													'target'	=> 'cafearticle',
													'response'	=> Array('title', 'link', 'description', 'cafename', 'cafeurl')
											),
								'이미지'	=> Array(
													'target'	=> 'image',
													'response'	=> Array('title', 'link', 'thumbnail', 'sizeheight', 'sizewidth')
											),
								'백과사전'	=> Array(
													'target'	=> 'encyc',
													'response'	=> Array('title', 'link', 'description', 'thumbnail')
											),
								'웹문서'	=> Array(
													'target'	=> 'webkr',
													'response'	=> Array('title', 'link', 'description')
											),
								'전문자료'	=> Array(
													'target'	=> 'doc',
													'response'	=> Array('title', 'link', 'description')
											),
								'지역'		=> Array(
													'target'	=> 'local',
													'response'	=> Array('title', 'link', 'description', 'telephone', 'address', 'mapx', 'mapy')
											),
								'블로그'	=> Array(
													'target'	=> 'blog',
													'response'	=> Array('title', 'link', 'description', 'bloggername', 'bloggerlink')
											),
								'뉴스'		=> Array(
													'target'	=> 'news',
													'response'	=> Array('title', 'link', 'description', 'originallink', 'pubDate')
											),
	);



//새로운툴팁
$tool_tip_layer	= '';
$tool_tip_num	= 0;


# 2013-02-07 도로명 주소 설정 woo
$zipcode_site				= 'post.cgimall.co.kr';
$zipcode_road_file			= 'zipcode_road_return.php';
$zipcode_juso_file			= 'zipcode_juso_return.php';	// 도로명
$zipcode_return_file		= 'zipcode_return.php';			// 우편번호
# type 은 curl / fsock / snoopy 가 있음
$sock_connect_type			= 'fsock';
$area1_title_text			= '지역선택';
$area2_title_text			= '구선택';
$area3_title_text			= '동선택';
# 도로명 woo
$area4_title_text			= '도로명선택';


####################################################################################################################
//플래시 지역검색 및 ebook 작업때문에 추가된 것들

#xmlAddressCreate() 함수에 쓰이는 변수들 ( xml옵션들 )
$xmlAddress_NcontA		= "5";	 #5개이상
$xmlAddress_NcontB		= "10";	#10개이상
$xmlAddress_NcontC		= "15";	#15개이상

$xmlAddress_CcontA		= "facdb1";		#없을때
$xmlAddress_CcontB		= "fab68c";
$xmlAddress_CcontC		= "fd9759";
$xmlAddress_CcontD		= "ff6000";

$xmlAddress_mapbg		= "facdb1";
$xmlAddress_ovcolor		= "F56236";
$xmlAddress_linecolor	= "FFFFFF";
$xmlAddress_titlecolor	= "F56236";
$xmlAddress_speed		= "1000";

#xml지도 지역관련 설정 (가급적! 변경하지마세요.)
$xml_area1	= Array("서울","인천","경기도","강원도","충청남도","대전","충청북도","경상북도","대구","울산","전라북도","경상남도","부산","광주","전라남도","제주도","세종시");

//도로명 때문에 hun 추가함.
$xml_area_full_name	= Array("서울특별시","인천광역시","경기도","강원도","충청남도","대전광역시","충청북도","경상북도","대구광역시","울산광역시","전라북도","경상남도","부산광역시","광주광역시","전라남도","제주특별자치도","세종특별자치시");


#플래시 지도관련 설정
$xml_flash		= Array(
				'서울'		=> "flash_swf/map_seoul.swf",
				'인천'		=> "flash_swf/map_incheon.swf",
				'경기도'	=> "flash_swf/map_gyeonggi.swf",
				'강원도'	=> "flash_swf/map_gangwon.swf",
				'충청남도'	=> "flash_swf/map_chungnam.swf",
				'대전'		=> "flash_swf/map_daejeon.swf",
				'충청북도'	=> "flash_swf/map_chungbuk.swf",
				'경상북도'	=> "flash_swf/map_gyeongbuk.swf",
				'대구'		=> "flash_swf/map_daegu.swf",
				'울산'		=> "flash_swf/map_ulsan.swf",
				'전라북도'	=> "flash_swf/map_jeonbuk.swf",
				'경상남도'	=> "flash_swf/map_gyeongnam.swf",
				'부산'		=> "flash_swf/map_busan.swf",
				'광주'		=> "flash_swf/map_gwangju.swf",
				'전라남도'	=> "flash_swf/map_jeonnam.swf",
				'제주도'	=> "flash_swf/map_jeju.swf",
				'세종시'	=> "flash_swf/map_sejong.swf",
				);

//xml메인페이지 지도 호출시 사용되는 짧은지명
$xml_area1_short	= Array("서울","인천","경기","강원","충남","대전","충북","경북","대구","울산","전북","경남","부산","광주","전남","제주","세종");

$xml_area2	= Array(
				'서울'		=> Array(
									"강북구","도봉구","노원구","은평구","성북구","중랑구","서대문구","종로구","동대문구","중 구","성동구","광진구","강동구","강서구","마포구","용산구","양천구","영등포구","동작구","구로구","금천구","관악구","서초구","강남구","송파구"
								),

				'인천'		=> Array(
									"강화군","신도시","서 구","계양구","부평구","동 구","중 구","옹진군","남 구","연수구","남동구"
								),

				'경기도'	=> Array(
									"연천군","파주시","양주시","동두천시","포천시","가평군","김포시","고양시","의정부시","남양주시","구리시","하남시","양평군","부천시","시흥시","광명시","안양시","과천시","성남시","광주시","여주군","안산시","군포시","화성시","의왕시","수원시","오산시","용인시","이천시","평택시","안성시"
								),

				'강원도'	=> Array(
									"철원군","화천군","양구군","인제군","고성군","속초시","양양군","춘천시","홍천군","강릉시","횡성군","평창군","정선군","동해시","원주시","영월군","태백시","삼척시"
								),

				'충청남도'	=> Array(
									"태안군","서산시","당진군","예산군","아산시","천안시","홍성군","청양군","공주시","연기군","보령시","부여군","서천군","논산시","계룡시","금산군"
								),

				'대전'		=> Array(
									"유성구","대덕구","서 구","중 구","동 구"
								),

				'충청북도'	=> Array(
									"진천군","음성군","충주시","제천시","단양군","청주시","청원군","괴산군","보은군","옥천군","영동군","증평군"
								),

				'경상북도'	=> Array(
									"문경시","예천군","영주시","안동시","봉화군","영양군","울진군","상주시","의성군","청송군","영덕군","김천시","구미시","군위군","영천시","포항시","성주군","칠곡군","경산시","경주시","고령군","청도군","울릉군"
								),

				'대구'		=> Array(
									"북구","동구","달성군","달서구","서 구","중 구","남 구","수성구"
								),

				'울산'		=> Array(
									"울주군","북 구","중 구","남 구","동 구"
								),

				'전라북도'	=> Array(
									"군산시","익산시","완주군","진안군","무주군","김제시","전주시","부안군","고창군","정읍시","순창군","임실군","장수군","남원시"
								),

				'경상남도'	=> Array(
									"거창군","합천군","의령군","창녕군","밀양시","함양군","산청군","진주시","함안군","마산시","창원시","진해시","김해시","양산시","하동군","사천시","고성군","남해군","통영시","거제시"
								),

				'부산'		=> Array(
									"강서구","북 구","사상구","사하구","금정구","동래구","연제구","부산진구","동 구","중 구","서 구","영도구","남 구","수영구","해운대구","기장군"
								),

				'광주'		=> Array(
									"광산구","북 구","서 구","남 구","동 구"
								),

				'전라남도'	=> Array(
									"영광군","장성군","담양군","곡성군","구례군","함평군","나주시","화순군","순천시","광양시","무안군","신안군","목포시","영암군","진도군","해남군","완도군","강진군","장흥군","보성군","고흥군","여수시"
								),

				'제주도'	=> Array(
									"제주시","서귀포시"
								),
				'세종시'	=> Array(
									"소정면", "전의면", "전동면", "연서면", "조치원읍", "장군면", "부강면", "연동면", "연기면", "금남면", "고운동", "아름동", "도담동", "종촌동", "어진동", "다정동", "새롬동", "나성동", "한솔동", "가람동", "대평동", "보람동", "소담동", "반곡동"
								),
			);

$xml_area_file			= Array(
						'서울'		=> "xml/mapurl_seoul.xml",
						'인천'		=> "xml/mapurl_incheon.xml",
						'경기도'	=> "xml/mapurl_gyeonggi.xml",
						'강원도'	=> "xml/mapurl_gangwon.xml",
						'충청남도'	=> "xml/mapurl_chungnam.xml",
						'대전'		=> "xml/mapurl_daejeon.xml",
						'충청북도'	=> "xml/mapurl_chungbuk.xml",
						'경상북도'	=> "xml/mapurl_gyeongbuk.xml",
						'대구'		=> "xml/mapurl_daegu.xml",
						'울산'		=> "xml/mapurl_ulsan.xml",
						'전라북도'	=> "xml/mapurl_jeonbuk.xml",
						'경상남도'	=> "xml/mapurl_gyeongnam.xml",
						'부산'		=> "xml/mapurl_busan.xml",
						'광주'		=> "xml/mapurl_gwangju.xml",
						'전라남도'	=> "xml/mapurl_jeonnam.xml",
						'제주도'	=> "xml/mapurl_jeju.xml",
						'세종시'	=> "xml/mapurl_sejong.xml",
						);

	$AREA_SI			= array();
	$AREA_SI_TITLE		= array();
	$AREA_SI_NUMBER		= array();

	$sql				= "select * from $si_tb order by sort_number asc";
	$result				= query($sql);

	while ($AREA = happy_mysql_fetch_array($result))
	{
		$AREA_SI{$AREA[number]}		= $AREA[si];		#번호로 지역을 알수있도록
		array_push($AREA_SI_TITLE,$AREA[si]);

		$AREA_SI_NUMBER{$AREA[si]} = $AREA[number];		#지역명으로 번호를 알도록
	}

//도로명 때문에 hun 추가함.
$xml_area_full_name	= Array("서울특별시","인천광역시","경기도","강원도","충청남도","대전광역시","충청북도","경상북도","대구광역시","울산광역시","전라북도","경상남도","부산광역시","광주광역시","전라남도","제주특별자치도","세종특별자치시");


$upso2_si = $si_tb;
$upso2_si_gu = $gu_tb;
$upso2_si_dong = $dong_tb;



#슬라이드 배너
$happy_banner_slide			= 'job_happy_banner_slide';
$banner_folder_admin_slide	= 'banner_slide';
$banner_folder_slide		= 'admin/banner_slide';
#슬라이드 배너 END

//쪽지신고하기
$happy_nomember_report_use	= true; // 비회원 쪽지신고하기 , true or false

$base64_main_url = str_replace("=","",base64_encode($_SERVER['HTTP_HOST']));
if(preg_match("/utf/i",$server_character)) { $zipcode_add_get = "&encoding=utf8"; } else { $zipcode_add_get = ""; }
$zipcode_add_get		.= "&ht=1";

$happy_naver_blog_send	= "happy_naver_blog_send";







// 파일삭제 - 2015-09-30 - x2chi - 커스터마이징
function delFiles ( $fileLink, $subKey = "", $maskKey = "" )
{
	global $path, $demo_lock;

	if ( $demo_lock )
	{
		return "Not Delete Demo.";
	}

	$return = "error.";
	$fileCnt = 0;

	if( strlen( $fileLink ) > 0 )
	{
		$fileLink = $path.$fileLink;
		if( is_file($fileLink) )
		{
			if( unlink($fileLink) )
			{
				$return = "delete one(0) [".$fileLink."].<br>";
				$fileCnt++;
			}
			else
			{
				$return = "delete error(0) [".$fileLink."].<br>";
			}
		}

		if( strlen($subKey) > 0 AND strlen($maskKey) > 0 )
		{
			$srchKey	= explode( $subKey, $fileLink);
			$maskWord	= $srchKey[0].$maskKey;
			$srchList	= glob( $maskWord );
			$fileCnt	+= count( $srchList );
			array_map( "unlink", $srchList );
			$return = "delete all (".$fileCnt.") [".$mask."].<br>";

		}

		if( $fileCnt == 0 )
		{
			$return = "error (none files).";
		}
	}
	else
	{
		$return = "error (none file name).";
	}
	return $return;
}

function HAPPY_EXIF_READ_CHANGE($FILE="",$type="")
{
	global $path;
	global $exif_data_name;

	$IMAGE_MIME_TYPE		= ARRAY("jpg","jpeg","gif","png");

	if( $type == '' )				//이미지를 등록하고 변환하기를 원할 경우...
	{
		$is_make_array				= false;
		if( !is_array( $FILE ) )				//단일변수면 배열에 담아서 사용.
		{
			$is_make_array				= true;
			$TMP_FILE					= ARRAY();
			$TMP_FILE[0]					= $FILE;
		}
		else
		{
			$TMP_FILE					= $FILE;
		}

		foreach( $TMP_FILE as $key => $value )
		{
			if ( preg_match("/\.jp/i",$value ) )
			{
				$EXIFDATA				= @exif_read_data($value);
				if($EXIFDATA['Orientation'] == 6)												//시계방향으로 90도 돌려줘야 정상인데 270도 돌려야 정상적으로 출력됨
				{
					$degree					= 270;
				}
				else if($EXIFDATA['Orientation'] == 8)											// 반시계방향으로 90도 돌려줘야 정상
				{
					$degree					= 90;
				}
				else if($EXIFDATA['Orientation'] == 3)
				{
					$degree					= 180;
				}

				if($degree)
				{
					if($EXIFDATA[FileType] == 1)
					{
						$source						= imagecreatefromgif($value);
						$source						= imagerotate ($source , $degree, 0);
						imagegif($source, $value);
					}
					else if($EXIFDATA[FileType] == 2)
					{
						$source						= imagecreatefromjpeg($value);
						$source						= imagerotate ($source , $degree, 0);
						imagejpeg($source, $value);
					}
					else if($EXIFDATA[FileType] == 3)
					{
						$source						= imagecreatefrompng($value);
						$source						= imagerotate ($source , $degree, 0);
						imagepng($source, $value);
					}

					imagedestroy($source);
					$exif_data_name[$key]			= $value;
				}
			}

			$TMP_FILE[$key]		= $value;
		}

		if( $is_make_array == true )
		{
			return $TMP_FILE[0];
		}
		else
		{
			return $TMP_FILE;
		}
	}
	else if( $type == 'del' )					//변환을 마감하고 삭제하기를 원할 경우...
	{
		foreach( $exif_data_name as $key => $value )
		{
			unlink($value);
		}
		$exif_data_name		= Array();			//이미지 삭제를 다 했으므로 배열초기화
	}
}

//회사로고 gif 원본출력여부 hong
$is_logo_gif_org_print	= true;		//true or false



function is_mobile_ok()
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


// 카카오 알림톡 관련설정
$KAKAO_CONFIG					= Array(
										'tpl_url'		=> 'http://happysms.happycgi.com/kakao/tpl.php',
										'xml_url'		=> 'http://happysms.happycgi.com/kakao/xml.php',
										'close_url'		=> 'http://happysms.happycgi.com/kakao/close.html',
										'connect_type'	=> $sock_connect_type, # type 은 curl / fsock / snoopy 가 있음
										'userid'		=> $sms_userid,
										'referer'		=> $_SERVER['SERVER_NAME'],
										'find_icon'		=> "<img src='img/btn_kakao_template_find.gif' border='0' alt='알림톡 템플릿찾기' title='알림톡 템플릿찾기'>",
										'ssl_use'		=> ( $_SERVER['HTTPS'] == "on" ) ? "y" : ""
);

$KAKAO_CONFIG['encode_url']		= "?userid=".urlencode(base64_encode($KAKAO_CONFIG['userid']));
$KAKAO_CONFIG['encode_url']		.="&referer=".urlencode(base64_encode($KAKAO_CONFIG['referer']));

$KAKAO_CONFIG['tpl_url']		= $KAKAO_CONFIG['tpl_url'].$KAKAO_CONFIG['encode_url']."&ssl_use=".$KAKAO_CONFIG['ssl_use'];
$KAKAO_CONFIG['xml_url']		= $KAKAO_CONFIG['xml_url'].$KAKAO_CONFIG['encode_url'];

//웹폰트 소스
$webfont_js = <<<END
<link rel="stylesheet" type="text/css" href="./webfont/webfont.css"/>
<script src="../webfont/web_font.js"></script>
<script type="text/javascript">
	WebFont.load({
		google: {
		  families: ['Noto Sans KR']
		}
	});
</script>
END;

// 관리자모드 SMS 및 이메일 발송시 회원 리스트 출력 제한 hong
$happy_sms_email_send_list_limit	= 100;	//명



#로그삭제 관련 변수 - ranksa
$HAPPY_LOG_DELETE_DAY_ARRAY				= Array(
												$happy_banner_log_tb	=> 730,				//배너로그
												$upso2_poll_log			=> 730,				//투표
												$com_guin_per_tb_log	=> 730,				//구인에 이력서 신청 테이블
												$stats_tb				=> 730,				//사이트통계
												$job_email_jiwon_log	=> 730,				//이메일 입사지원 로그
												$guin_detail_view_log	=> 730,				//채용정보 열람 사용자 로그
												$auction_weather_info	=> 730,				//날씨
												$calendar_view_tb		=> 730,				//출석댓글
												$calendar_dojang_tb		=> 730,				//출석도장
);

$HAPPY_LOG_DATE_FIELD_ARRAY	= Array(
												$happy_banner_log_tb	=> "regdate",		//배너로그
												$upso2_poll_log			=> "date",			//투표
												$com_guin_per_tb_log	=> "regdate",		//구인에 이력서 신청 테이블
												$stats_tb				=> "regdate",		//사이트통계
												$job_email_jiwon_log	=> "regdate",		//이메일 입사지원 로그
												$guin_detail_view_log	=> "log_date",		//채용정보 열람 사용자 로그
												$auction_weather_info	=> "xml_date",		//날씨
												$calendar_view_tb		=> "reg_date",		//출석댓글
												$calendar_dojang_tb		=> "reg_date",		//출석도장
);
#로그삭제 관련 변수 END

$_TYPE_DEPTH_TXT_ARR	= array(
	0 => '대표진료과',
	1 => '세부진료과',
	2 => '세세부진료과'
);




/*
function get_type_selectbox_js()
{
	global $type_sub_tb, $type_sub_sub_tb;

	$return_arr	= array();

	$type2_arr	= array();
	$sql		= "SELECT * FROM {$type_sub_tb} ORDER BY sort_number ASC";
	$rec		= query($sql);
	while($row = mysql_fetch_assoc($rec))
	{
		$type2_arr[$row['type']][$row['number']]	= $row['type_sub'];
	}

	$type2_key_js	= "";
	$type2_val_js	= "";
	foreach($type2_arr AS $key => $val)
	{
		$type2_key_js	.= "var type2_key_{$key} = [";
		$type2_val_js	.= "var type2_val_{$key} = [";
		$type2_key_tmp	= array();
		$type2_val_tmp	= array();
		foreach($val AS $key2 => $val2)
		{
			$type2_key_tmp[]    = "'{$key2}'";
			$type2_val_tmp[]    = "'{$val2}'";
		}
		$type2_key_js    .= @implode(",",$type2_key_tmp);
		$type2_val_js    .= @implode(",",$type2_val_tmp);

		$type2_key_js    .= "];".PHP_EOL;
		$type2_val_js    .= "];".PHP_EOL;
	}

	$type3_arr	= array();
	$sql		= "SELECT * FROM {$type_sub_sub_tb} ORDER BY sort_number ASC";
	$rec		= query($sql);
	while($row = mysql_fetch_assoc($rec))
	{
		$type3_arr[$row['type_sub']][$row['number']]	= $row['title'];
	}

	$type3_key_js	= "";
	$type3_val_js	= "";
	foreach($type3_arr AS $key => $val)
	{
		$type3_key_js	.= "var type3_key_{$key} = [";
		$type3_val_js	.= "var type3_val_{$key} = [";
		$type3_key_tmp	= array();
		$type3_val_tmp	= array();
		foreach($val AS $key2 => $val2)
		{
			$type3_key_tmp[]	= "'{$key2}'";
			$type3_val_tmp[]	= "'{$val2}'";
		}
		$type3_key_js	.= @implode(",",$type3_key_tmp);
		$type3_val_js	.= @implode(",",$type3_val_tmp);

		$type3_key_js	.= "];".PHP_EOL;
		$type3_val_js	.= "];".PHP_EOL;
	}

	$return_arr['type2_key_js']	= $type2_key_js;
	$return_arr['type2_val_js']	= $type2_val_js;
	$return_arr['type3_key_js']	= $type3_key_js;
	$return_arr['type3_val_js']	= $type3_val_js;

	return $return_arr;
}
*/


// 키메디 SSO

/**
 *  SSO TEST Sample :   config.php
 *  Memo    : 키값들 설정 파일
 *
 *  README.md 파일 참고
 */

define("DEBUG_FLAG", 0) ;   //  디버깅용

$_DEBUG_FLAG	= DEBUG_FLAG;
//  파트너업체마다 부여되는 고유 키값( 개발팀 샘플 키값입니다. )
//  고유 코드들로 변경해주셔야 됩니다.
define("CHANNEL_CODE", "cgimall") ;    //  업체고유코드번호
define("SECRET_KEY", "cHEMtg535xXeni2A") ;  //  암호화생성키값

//  테스트 환경, 라이브환경 구분 값
//  각 파트너 제휴사의 스테이징 및 라이브 도메인으로 변경해주셔야 됩니다.
define("ENV_FLAG", 0) ; //  테스트 0, 라이브 1 ;
if( ENV_FLAG ==0 ) {
    //define("KEYMEDI_SSO_LOGIN_DOMAIN", "devweb.keymedidev.com") ;
    //define("KEYMEDI_SSO_USER_DOMAIN", "devkid.keymedidev.com") ;
    define("KEYMEDI_SSO_LOGIN_DOMAIN", "web.keymedidev.com") ;
    define("KEYMEDI_SSO_USER_DOMAIN", "kid.keymedidev.com") ;
} else {
    define("KEYMEDI_SSO_LOGIN_DOMAIN", "www.keymedi.com") ;
    define("KEYMEDI_SSO_USER_DOMAIN", "kid.keymedi.com") ;
}

//  SSO 로그인을 위해 호출할 URL, 고정 URL이며 수정하시면 안됩니다.
define("KEYMEDI_LOGIN_URL", "https://".KEYMEDI_SSO_LOGIN_DOMAIN."/kid/oauth?channel_code=".CHANNEL_CODE) ;
//  키메디 사용자 정보 가져오기 호출 URL, 고정 URL 이며 수정하시면 안 됩니다.
define("KEYMEDI_USERINFO_URL", "https://".KEYMEDI_SSO_USER_DOMAIN."/api/oauth/getMyInfo") ;

$_KEYMEDI_LOGIN_URL = KEYMEDI_LOGIN_URL;

//  암호키 생성시 사용되는 고정 값.
define("SKID", "kid_") ;

if( DEBUG_FLAG==1 ) {
    //error_reporting(E_ALL);
    //ini_set("display_errors", 1);
}

/**
 *  SSO TEST Sample :   sso_library.php
 *  Memo    : 키값들 설정 파일
 *
 *  README.md 파일 참고
 */


/**
 *  키메디 호출시 전달될 s_token 값 만들기
 *  Params
 *      $uidx   :   키메디에서 전달받은 유저의 고유값
 *  Return
 *      $s_token:   인코딩값( 키메디 회원정보 호출시 사용 )
 */
function generate_s_token($uidx) {
    $str = SKID.CHANNEL_CODE.'_'.$uidx.'_'.SECRET_KEY ;     //  암호화키 생성 규칙.
    $s_token = hash('sha256', $str);
    return $s_token ;
}

/**
 *  키메디 사용자정보 가져오기 API 호출
 *  Params
 *      $token   :   키메디에서 전달받은 유저 accessToken
 *      $stoken :   인코딩으로 만든 값.
 *  Return
 *      $res
 *      {
 *        "code": 0,
 *        "message": "ok",
 *        "data": {
 *            "name": "테스터",
 *            "mobile": "01012341234",
 *            "email": "test@keymedi.com",
 *            "license_number": "098765",
 *            "main_medical_part": "피부과"
 *        }
 *      }
 *
 */
function get_my_info($token, $stoken) {

    $data = array() ;
    $data['channel_code'] = CHANNEL_CODE ;
    $data['s_token'] = $stoken ;
    $headers = array() ;
    $headers[] = 'Accept: application/json';
    $headers[] = 'Content-Type: multipart/form-data';
    $headers[] = "Authorization: Bearer ".$token;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, KEYMEDI_USERINFO_URL);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($curl);

    if (!$result) {
        $res = array() ;
        $res['code'] = 0 ;
    } else {
        $res = json_decode($result, true);
    }
    curl_close($curl);

    return $res;
}
// 키메디 SSO END
?>