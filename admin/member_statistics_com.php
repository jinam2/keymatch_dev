<?php
$t_start = array_sum(explode(' ', microtime()));
include ("../inc/Template.php");
$TPL = new Template;
include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");

#관리자 접속 체크 루틴
if ( !admin_secure("접속통계") ) {
	error("접속권한이 없습니다.   ");
	exit;
}
#관리자 접속 체크 루틴

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

$skin_folder = "html";



#현재위치 $admin_now_location [YOON : 2009-09-08 ]
#현재 서브메뉴 굵게표시 CSS [ YOON : 2009-09-08 ] > 통계관리
$admin_now_location="<A HREF='admin.php?a=mem&mode=m_list'>업소회원관리</A> > <A HREF='member_statistics.php'>접속통계요약정보</A>";
echo "<STYLE TYPE=\"text/css\">.submenu_now_5_02{font-weight:bold;}</STYLE>";

#[ YOON : 2009-09-09 ]
print <<<END



END;


#검색날짜 지정
$today		= date("Y-m-d");
$dayArray	= Array(30,60,90,182,365,730);
$dayChk		= Array();
for ( $i=0,$max=sizeof($dayArray) ; $i<$max ; $i++ )
{
	$dayChk[$dayArray[$i]]	= date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")-$dayArray[$i],date("Y")) );
}


#최초 검색범위는1년으로
if ($_GET[s_date]){
	$s_date_info = $_GET[s_date];
}
else {
	$s_date_info = $dayChk[365];
}
if ($_GET[e_date]){
	$e_date_info = $_GET[e_date];
}
else {
	$e_date_info = date('Y-m-d');
}


if ($s_date_info > $e_date_info){
	error('검색범위를 다시 정해주세요');
	exit;
}

$sql = "select count(*) from $happy_member where `group` = '2' and reg_date between '$s_date_info' and '$e_date_info'";
//echo $sql;
$result = query($sql);
list($cnt) = happy_mysql_fetch_array($result);
$no_stats = "";
if ($cnt == 0)
{
	$graph_display_css = "style='display:none'";
	$no_stats = "1";
}

$TPL->define("출력", "$skin_folder/member_statistics_com.html");
$TPL->tprint();

	/*
	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<hr>Query Time : $exec_time sec";
	print $쿼리시간;
	*/

	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################
?>