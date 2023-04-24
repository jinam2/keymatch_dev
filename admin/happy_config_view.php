<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");


	#관리자 접속 체크 루틴
	/*
	if ( admin_secure("슈퍼관리자") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	*/
	#관리자 접속 체크 루틴

	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);
	$group_select	= $_GET['group_select'];

	if ( $number == '' )
	{
		$number			= preg_replace('/\D/', '',$_POST['number']);
	}

	if ( $number == '' )
	{
		error("잘못된 경로로 접근하셨네요.");
		exit;
	}

	$Group			= happy_mysql_fetch_array(query("SELECT * FROM $happy_config_group WHERE number='$number'"));

	#print_r($Group['group_title']);
	//exit;

	#부관리자 권한 체크
	$회원관리 = array("회원가입 관련설정");
	$유료결제관리 = array("결제 환경설정","유료옵션 설정","이력서 유료옵션 아이콘 관리","채용정보 유료옵션 아이콘 관리","유료옵션 결제관련 설정");
	$플래쉬로고관리 = array("플래시지도 환경설정","메인플래시배너 환경설정","메인플래시업체출력 설정","플래시메뉴 설정","클라우드태그 환경설정");
	$게시판관리 = array("게시판 환경설정");
	$구인등록관리 = array("채용정보 등록설정");
	$구직등록관리 = array("이력서 상세화면 보기 권한");
	$미니앨범관리 = array("미니앨범 관리");
	$추천키워드 = array("추천키워드 설정");

	if ( in_array($Group['group_title'],$회원관리) )
	{
		if ( !admin_secure("회원관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$추천키워드) )
	{
		if ( !admin_secure("추천키워드") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$유료결제관리) )
	{
		if ( !admin_secure("결제관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$플래쉬로고관리) )
	{
		if ( !admin_secure("플래쉬|로고관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$게시판관리) )
	{
		if ( !admin_secure("게시판관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$구인등록관리) )
	{
		if ( !admin_secure("구인리스트") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$구직등록관리) )
	{
		if ( !admin_secure("구직리스트") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$미니앨범관리) )
	{
		if ( !admin_secure("미니앨범관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else
	{
		if ( !admin_secure("최고관리자") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	#부관리자 권한 체크



	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################






############################################################################################################################







	echo happy_config_group_load($number,'all','ok');











############################################################################################################################



	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################




#	echo "<br><hr>테스트중<br>";
#	echo happy_config_group_load(2,'','ok');


?>