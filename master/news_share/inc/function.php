<?php
/**
* 뉴스 공유 환경설정 파일
*
* 뉴스 스토어 연동시 고려할 부분
1. 납품된 솔루션의 캐릭터셋
2. 납품된 솔루션의 관리자모드 비밀번호 암호화 방식
3. 납품된 솔루션의 버젼
4. date_order 사용여부
5. 테이블 프리픽스 사용여부
6. 위지윅업로드 첨부파일 사용여부
*/

//구인구직 솔루션용
/*
2015-06-02
관리자 아이디/비밀번호가 $admin_tb 에 저장되어 있어서 달라짐
*/
$admin_tb = "job_admin";


//뉴스솔루션인지 1 or 빈값
$use_store_news = "";
//게시글만 받아가는 용도로 쓰는지 1 or 빈값
$use_store_bbs = "1";


//magic_quotes_gpc 가 on 또는 off
$magic_quotes_gpc = "on";

//뉴스솔루션 관리자아이디
$news_admin_id = $_COOKIE['ad_id'];
//뉴스솔루션 관리자비밀번호
$news_admin_pass = $_COOKIE['ad_pass'];
$pass_encrypt_type = 'md5';


//뉴스상점 url
$news_store_url = 'http://newsstore.co.kr';
//뉴스상점 url2 관리자모드에서 열리는 작은페이지용 url
$news_store_url2 = 'http://popup.newsstore.co.kr';
//뉴스상점 로그인체크 path
$news_store_login_check_path = "/store_login.php";
//뉴스상점 로그인 path
$news_store_login_path = "/happy_member_login.php";


//뉴스사이트 url
$news_site_url = $main_url;
//뉴스솔루션이 하부경로에 설치시 /news/detail.php 형태로 설정
$news_site_detail_url = '/detail.php';
//뉴스사이트가 설치된 하부경로 예) news 디렉토리에 설치된 경우 /news 입력
//하부설치가 아닌 경우 빈값
$news_site_wys_url = '';

//뉴스DB prefix
$db_prefix = "";

//뉴스DB date_order 존재여부
//납품된 뉴스솔루션 버젼에 따라 다름 1로 설정시 사용함
//0 또는 빈값 설정시 사용안함
$date_order_use = "1";
$news_article_index = $db_prefix."news_article_index";

//위지윅으로 업로드된 파일관리 여부
//1로 설정시 사용
//빈값 설정시 사용안함
$happy_upload_files_use = "";
$happy_upload_files = $db_prefix.'happy_upload_files';



//뉴스DB 테이블명
$news_article = $db_prefix.'news_article';
//뉴스섹션DB 테이블명
$news_category = $db_prefix.'news_category';


//뉴스상점 로그인정보 테이블명
$news_store_login = 'news_store_login';


$NEWS_FIELD = array();
//뉴스 고유번호 필드명
$NEWS_FIELD['number'] = 'number';
//뉴스 제목 필드명
$NEWS_FIELD['title'] = 'title';
//뉴스 부제목 필드명
$NEWS_FIELD['sub_title'] = 'sub_title';
//뉴스 섹션 필드명
$NEWS_FIELD['category'] = 'category';
//뉴스 본문 필드명
$NEWS_FIELD['comment'] = 'comment';
//뉴스 날짜 필드명
$NEWS_FIELD['date'] = 'date';
//뉴스 기자명 필드명
$NEWS_FIELD['reporter'] = 'reporter';
//뉴스 기자이메일 필드명
$NEWS_FIELD['reporter_email'] = 'reporter_email';
//뉴스 기자아이디 필드명
$NEWS_FIELD['id'] = 'id';
//동영상 필드명
$NEWS_FIELD['avi_url'] = 'avi_url';
//지역뉴스
$NEWS_FIELD['area'] = 'etc1';
//추출용사진
$NEWS_FIELD['extract_img'] = 'extract_img';
//뉴스타입
$NEWS_FIELD['news_type'] = 'news_type';



//뉴스솔루션 캐릭터셋 : e or u
//e : eu-ckr
//u : ut-f8
//뉴스상점으로 뉴스데이터 전송은 ut-f8 이 기본 인코딩셋
$news_encoding = 'u';





//html 템플릿 파일
$skin_folder = "html";

######################################################################################################
# 솔루션 디버그 설정
######################################################################################################
$bench_mark				= '';	#프로그램쿼리확인 1 아닐때 0
$bench_mark2			= '0';	#explain 결과를 보여줌 ( bench_mark가 1일때 사용가능 ) # 2일때 무조건 explain 결과가 나옴
$bench_mark_time		= 0.02;	#속도 체크 -> 속도 오바시 쿼리문이 빨간색으로 표시 되며 bench_mark2활성화시 explain 결과 보여줌
######################################################################################################



#####################################################
############ 절대 건드리지 마세요.  #################
#####################################################

	$TemplateM_name	= Array(

	);

	$TemplateM_func	= Array(

	);
#####################################################


//2015-02-09 게시글로 보내기
$board_list = 'board_list';

//happy_board_key 를 사용하는지, 사용하면 1
$use_happy_board_key = "";
//happy_board_key 의 board_tb 에 db_prefix 를 포함해서 저장하면 1
$prefix_type = "1";
$happy_board_key = "social_board_key";


$BOARD_FIELD = array();
//게시글 고유번호 필드명
$BOARD_FIELD['number'] = 'number';
//게시글 제목 필드명
$BOARD_FIELD['title'] = 'bbs_title';
//게시글 본문 필드명
$BOARD_FIELD['comment'] = 'bbs_review';
//게시글 날짜 필드명
$BOARD_FIELD['date'] = 'bbs_date';
//게시글 기자명 필드명
$BOARD_FIELD['reporter'] = 'bbs_name';
//게시글 기자이메일 필드명
$BOARD_FIELD['reporter_email'] = 'bbs_email';
//게시글 기자아이디 필드명
$BOARD_FIELD['id'] = 'bbs_id';


//솔루션이 하부경로에 설치시 /news/bbs_detail.php 형태로 설정
$news_site_bbs_detail_url = '/bbs_detail.php';

//게시글 작성인 기본값
$bbs_name_default = "운영자";

?>