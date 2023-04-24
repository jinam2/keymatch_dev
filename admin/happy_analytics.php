<?php
$t_start = array_sum(explode(' ', microtime()));
include ("../inc/Template.php");
$TPL = new Template;
include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");
include ("../inc/google_chart.php");			#2021-02-25 hun 구글차트



#관리자 접속 체크 루틴
if ( !admin_secure("접속통계") ) {
	error("접속권한이 없습니다.   ");
	exit;
}
#관리자 접속 체크 루틴




include ("tpl_inc/top_new.php");



$main_url = "http://".$_SERVER['HTTP_HOST']."/".$wys_url;



$skin_folder = "html";


#현재위치 $admin_now_location [YOON : 2009-09-08 ]
#현재 서브메뉴 굵게표시 CSS [ YOON : 2009-09-08 ] > 통계관리
if ( $action=="happy_analytics_keyword") {
	$admin_now_location="<A HREF='happy_analytics.php'>결제/통계관리</A> > <A HREF='happy_analytics.php'>접속통계요약정보</A> > 키워드검색TOP100";
	echo "<STYLE TYPE=\"text/css\">.submenu_now_5_02{font-weight:bold;}</STYLE>";
}else if ( $action=="happy_analytics_refer") {
	$admin_now_location="<A HREF='happy_analytics.php'>결제/통계관리</A> > <A HREF='happy_analytics.php'>접속통계요약정보</A> > 이전접속경로TOP100";
	echo "<STYLE TYPE=\"text/css\">.submenu_now_5_03{font-weight:bold;}</STYLE>";
}else if ( $action=="happy_analytics_bestview") {
	$admin_now_location="<A HREF='happy_analytics.php'>결제/통계관리</A> > <A HREF='happy_analytics.php'>접속통계요약정보</A> > 가장많이본페이지TOP100";
	echo "<STYLE TYPE=\"text/css\">.submenu_now_5_04{font-weight:bold;}</STYLE>";
}else if ( $action=="happy_analytics_return") {
	$admin_now_location="<A HREF='happy_analytics.php'>결제/통계관리</A> > <A HREF='happy_analytics.php'>접속통계요약정보</A> > 가장많이떠난페이지TOP100";
	echo "<STYLE TYPE=\"text/css\">.submenu_now_5_05{font-weight:bold;}</STYLE>";
}else {
	$admin_now_location="<A HREF='happy_analytics.php'>결제/통계관리</A> > 접속통계요약정보";
	echo "<STYLE TYPE=\"text/css\">.submenu_now_5_01{font-weight:bold;}</STYLE>";
}



#[ YOON : 2009-09-09 ]
print <<<END

			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">

			<tr>
				<td><div style="text-align:right; padding:5px 5px 5px 0; margin-bottom:3px;">구글통계 서비스 설정은 [ <a href="happy_config_view.php?number=23"><b>여기</b></a> ]를 클릭하세요.</div></td>
			</tr>
			</table>

END;




#검색날짜 지정
$today		= date("Y-m-d");
$dayArray	= Array(30,60,90,182,365,730);
$dayChk		= Array();
for ( $i=0,$max=sizeof($dayArray) ; $i<$max ; $i++ )
{
	$dayChk[$dayArray[$i]]	= date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")-$dayArray[$i],date("Y")) );
}



#최초 검색범위는 30일로
if ($_GET[s_date]){
	$s_date_info = $_GET[s_date];
}
else {
	$s_date_info = $dayChk[30];
}
if ($_GET[e_date]){
	$e_date_info = $_GET[e_date];
}
else {
	$e_date_info = date('Y-m-d');
}



	$sql = "select * from $happy_analytics_tb where last_read = '1' ";
	$result = query($sql);
	$GOOGLE = happy_mysql_fetch_array($result);
	$s_date_info = $GOOGLE[sdate];
	$e_date_info = $GOOGLE[edate];



if ($s_date_info > $e_date_info){
	error('검색범위를 다시 정해주세요');
	exit;
}


#2021-02-25 hun 구글차트
$happy_analytics_graph_js			= "";
$happy_analytics_graph_js			.= '
<script type="text/javascript">';
$happy_analytics_graph_js		.= "
google.charts.load('current', {'packages':['corechart']});
google.charts.load('current', {'packages':['bar']});
		";
#2021-02-25 hun 구글차트


if ($_GET[action] == ''){
	$tpl_main = 'happy_analytics_main';

	#2021-02-25 hun 구글차트
	//방문자수 그래프1
	$columns			= array
	(
		0				=> 'Year',
		1				=> '총방문자수'
	);
	$options			= array
	(
		"showTextEvery"			=> 16,
		"colors"				=> '#0077CC',
	);
	$happy_analytics_graph_js		.= google_area_graph_js("drawChart1","my_chart1",google_area_graph_data_str($GOOGLE['getVisitors']),$columns,$options);


	//브라우저별 그래프4(파이)
	$columns			= array
	(
		0				=> '',
		1				=> '브라우저별'
	);
	$options			= array
	(
		"sliceVisibilityThreshold"			=> .03,
	);
	$happy_analytics_graph_js		.= google_pie_graph_js("drawChart4","my_chart4",google_pie_graph_data_str($GOOGLE['getBrowsers']),$columns,$options);


	//해상도별 그래프5(파이)
	$columns			= array
	(
		0				=> '',
		1				=> '해상도별'
	);
	$options			= array
	(
		"sliceVisibilityThreshold"			=> .03,
	);
	$happy_analytics_graph_js		.= google_pie_graph_js("drawChart5","my_chart5",google_pie_graph_data_str($GOOGLE['getScreenResolution']),$columns,$options);


	//my_chart2		총 페이지뷰
	$columns			= array
	(
		0				=> 'Year',
		1				=> '총 페이지뷰'
	);
	$options			= array
	(
		"showTextEvery"			=> 2,
		"colors"				=> '#D5D370',
	);
	$happy_analytics_graph_js		.= google_area_graph_js("drawChart2","my_chart2",google_area_graph_data_str($GOOGLE['getVisitsPerHour']),$columns,$options);

	//my_chart7		이전 접속사이트
	$columns			= array
	(
		0				=> '',
		1				=> '이전 접속 경로별'
	);
	$options			= array
	(
		"colors"			=> "#009eff",
		"height"			=> 600,
	);
	$happy_analytics_graph_js		.= google_bar_graph_js("drawChart7","my_chart7",google_area_graph_data_str($GOOGLE['getReferrers']),$columns,$options);

	//my_chart3		시간대별
	$columns			= array
	(
		0				=> 'Year',
		1				=> '시간대별 사용자 접속 수'
	);
	$options			= array
	(
		"showTextEvery"			=> 2,
		"colors"				=> '#D5D370',
	);
	$happy_analytics_graph_js		.= google_area_graph_js("drawChart3","my_chart3",google_area_graph_data_str($GOOGLE['getVisitsPerHour']),$columns,$options);
	#2021-02-25 hun 구글차트

}
elseif ($_GET[action] == 'happy_analytics_keyword'){
	$tpl_main = 'happy_analytics_keyword';

	//키워드별 그래프7(막대)
	$columns			= array
	(
		0				=> '',
		1				=> '키워드 TOP100'
	);
	$options			= array
	(
		"colors"			=> "#009eff",
		"height"			=> 2000,
	);
	$happy_analytics_graph_js		.= google_bar_graph_js("drawChart6","my_chart6",google_keyword_graph_data_str($GOOGLE['getSearchWords']),$columns,$options);
}
elseif ($_GET[action] == 'happy_analytics_refer'){
	$tpl_main = 'happy_analytics_refer';

	//매체별 페이지뷰 비율 그래프(파이)
	$columns			= array
	(
		0				=> '',
		1				=> '매체별 페이지뷰 비율'
	);
	$options			= array
	(
		"sliceVisibilityThreshold"			=> .03,
	);
	$happy_analytics_graph_js		.= google_pie_graph_js("drawChart7s","my_chart7s",google_pie_graph_data_str($GOOGLE['getReferrers']),$columns,$options);


	//브라우저별 그래프(파이)
	$columns			= array
	(
		0				=> '',
		1				=> '브라우저별'
	);
	$options			= array
	(
		"sliceVisibilityThreshold"			=> .03,
	);
	$happy_analytics_graph_js		.= google_pie_graph_js("drawChart4","my_chart4",google_pie_graph_data_str($GOOGLE['getBrowsers']),$columns,$options);


	//매체별 페이지뷰 그래프(막대)
	$columns			= array
	(
		0				=> '',
		1				=> '매체별 페이지뷰'
	);
	$options			= array
	(
		"colors"			=> "#009eff",
		"height"			=> 600,
	);
	$happy_analytics_graph_js		.= google_bar_graph_js("drawChart7","my_chart7",google_area_graph_data_str($GOOGLE['getReferrers']),$columns,$options);
}
elseif ($_GET[action] == 'happy_analytics_bestview'){
	$tpl_main = 'happy_analytics_bestview';

	//많이 접속한 페이지 비율 그래프(파이)
	$columns			= array
	(
		0				=> '',
		1				=> '많이 접속한 페이지 비율'
	);
	$options			= array
	(
		"sliceVisibilityThreshold"			=> .01,
	);
	$happy_analytics_graph_js		.= google_pie_graph_js("drawChart9s","my_chart9s",google_pie_graph_data_str($GOOGLE['getManyviews']),$columns,$options);


	//많이 접속한 페이지 수 그래프(막대)
	$columns			= array
	(
		0				=> '',
		1				=> '많이 접속한 페이지 수'
	);
	$options			= array
	(
		"colors"			=> "#009eff",
		"height"			=> 600,
	);
	$happy_analytics_graph_js		.= google_bar_graph_js("drawChart9","my_chart9",google_area_graph_data_str($GOOGLE['getManyviews']),$columns,$options);
}
elseif ($_GET[action] == 'happy_analytics_return'){
	$tpl_main = 'happy_analytics_return';

	//많이 이탈한 페이지 비율 그래프(파이)
	$columns			= array
	(
		0				=> '',
		1				=> '많이 이탈한 페이지 비율'
	);
	$options			= array
	(
		"sliceVisibilityThreshold"			=> .01,
	);
	$happy_analytics_graph_js		.= google_pie_graph_js("drawChart11s","my_chart11s",google_pie_graph_data_str($GOOGLE['getOutpage']),$columns,$options);


	//많이 이탈한 페이지뷰 수 그래프(막대)
	$columns			= array
	(
		0				=> '',
		1				=> '많이 이탈한 페이지뷰 수'
	);
	$options			= array
	(
		"colors"			=> "#009eff",
		"height"			=> 600,
	);
	$happy_analytics_graph_js		.= google_bar_graph_js("drawChart11","my_chart11",google_area_graph_data_str($GOOGLE['getOutpage']),$columns,$options);
}
elseif ($_GET[action] == 'happy_analytics_exits'){
	$tpl_main = 'happy_analytics_exits';
}
elseif ($_GET[action] == 'happy_analytics_term'){
	$tpl_main = 'happy_analytics_term';
}
else {$tpl_main = 'happy_analytics_main';}


#2021-02-25 hun 구글차트
$happy_analytics_graph_js		.= '';
$happy_analytics_graph_js		.= "</script>";
#2021-02-25 hun 구글차트




//echo $skin_folder."/".$tpl_main."<br><BR><BR><BR><BR>";


$TPL->define("출력", "$skin_folder/$tpl_main.html");
$TPL->tprint();

	/*
	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<hr>Query Time : $exec_time sec";
	print $쿼리시간;
	*/




END;
include ("tpl_inc/bottom.php");

?>