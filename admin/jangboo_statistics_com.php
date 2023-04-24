<?php
$t_start = array_sum(explode(' ', microtime()));
include ("../inc/Template.php");
$TPL = new Template;
include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");

if ( !admin_secure("결제관리") )
{
	error("접속권한이 없습니다.");
	exit;
}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

$skin_folder = "html";

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
	$s_date_info = $s_date = $dayChk[365];
}
if ($_GET[e_date]){
	$e_date_info = $_GET[e_date];
}
else {
	$e_date_info = $e_date = date('Y-m-d');
}

if ($s_date_info > $e_date_info){
	error('검색범위를 다시 정해주세요');
	exit;
}


/**********************************************************		FLASH 통계를 JAVASCRIPT 로 교체함		****************************************************************/


include ("../inc/google_chart.php");

$happy_analytics_graph_js			= "";
$happy_analytics_graph_js			.= '
<script type="text/javascript">';
$happy_analytics_graph_js		.= "
google.charts.load('current', {'packages':['corechart']});
google.charts.load('current', {'packages':['bar']});
		";



$group_sql = " AND `group` = '2' ";


if($s_date && $e_date)
{
	$che_date = date("Y-m-d", happy_mktime());
	if($e_date > date("Y-m-d", happy_mktime()))
	{
		$e_date = $che_date;
	}

	$WHERE = " AND jangboo_date >= '$s_date' AND jangboo_date <= '$e_date'";
	$WHERE2 = " AND reg_date >= '$s_date' AND reg_date <= '$e_date'";

	$s_temp = explode("-", $s_date);
	$e_temp = explode("-", $e_date);

	#시작 월이 더 클 경우...
	if($s_temp[1] > $e_temp[1])
	{
		$for_year = $e_temp[0] - $s_temp[0] - 1;
		$for_month = ($e_temp[1] + 12) - $s_temp[1];
	}
	else if(($s_temp[1] <= $e_temp[1]))
	{
		$for_year = $e_temp[0] - $s_temp[0];
		$for_month = $e_temp[1] - $s_temp[1];
	}

	$for_cnt = ($for_year * 12) + $for_month;
}



#총회원수를 구하자!
$sql = "SELECT count(*) from $happy_member where 1=1 $group_sql ";
$TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));

#검색조건에 만족하는 회원수를 구하자!
$sql = "SELECT count(*) from $happy_member WHERE 1=1 $WHERE2 $group_sql";
$SEARCH_TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));

#총 결제액을 구하자(결제된 금액)
$PRICE_TOTAL_SQL = "SELECT SUM(goods_price) from $jangboo WHERE in_check = '1'";
$PRICE_TOTAL_RESULT = query($PRICE_TOTAL_SQL);
$PRICE_TOTAL_DATA = happy_mysql_fetch_array($PRICE_TOTAL_RESULT);

#총 결제액을 구하자(미결제된 금액)
$PRICE_TOTAL_SQL_N = "SELECT SUM(goods_price) from $jangboo ";
$PRICE_TOTAL_RESULT_N = query($PRICE_TOTAL_SQL_N);
$PRICE_TOTAL_DATA_N = happy_mysql_fetch_array($PRICE_TOTAL_RESULT_N);

#총 미결재 금액
$PRICE_TOTAL_NO_PAY = $PRICE_TOTAL_DATA_N[0] - $PRICE_TOTAL_DATA[0];

$PRICE_TOTAL_DATA[0] = number_format($PRICE_TOTAL_DATA[0]);
$PRICE_TOTAL_DATA_N[0] = number_format($PRICE_TOTAL_DATA_N[0]);
$PRICE_TOTAL_NO_PAY = number_format($PRICE_TOTAL_NO_PAY);


$결제금액별배열	= array();
for($i = 0 ; $i < sizeof($pay_moneys) ; $i++)
{
	#1000원 이하 금액만
	if($i == 0)
	{
		$Sql = "SELECT SUM(goods_price) as g_price, count(goods_price) as ct from $jangboo  WHERE goods_price <= '$pay_moneys[$i]' AND in_check = '1' $WHERE";
	}
	#1000원 이상 금액
	else
	{
		$k = $i -1;
		if($pay_moneys[$i] == 'etc'){
			$Sql = "SELECT SUM(goods_price) as g_price, count(goods_price) as ct from $jangboo  WHERE goods_price > '$pay_moneys[$k]' AND in_check = '1' $WHERE";
		}
		else{
			$Sql = "SELECT SUM(goods_price) as g_price, count(goods_price) as ct from $jangboo  WHERE goods_price > '$pay_moneys[$k]' AND goods_price <= '$pay_moneys[$i]' AND in_check = '1' $WHERE";
		}
	}

	#echo $Sql.";<br>";
	$Result = query($Sql);
	$Data = happy_mysql_fetch_array($Result);
	//$pay_moneys_value[$i] = iconv("euc-kr","utf-8", "$pay_moneys_value[$i]");
	$aData[$pay_moneys_value[$i]] = "$Data[g_price]($Data[ct]회)";
	$결제금액별배열[]		= "$pay_moneys_value[$i]|".$Data[ct];
}
$결제금액별_데이터		= implode("\n",$결제금액별배열);

//브라우저별 그래프4(파이)
$columns			= array
(
	0				=> '',
	1				=> '결제 금액별'
);
$options			= array
(
	"sliceVisibilityThreshold"			=> .03,
);
$happy_analytics_graph_js		.= google_pie_graph_js("drawChart1","my_chart1",google_pie_graph_data_str($결제금액별_데이터),$columns,$options);


array_push($pay_type,"무통장입금");

$결제타입별배열	= array();
for($i = 0 ; $i < sizeof($pay_type) ; $i++)
{
	$Sql = "SELECT SUM(goods_price) as g_price from $jangboo  WHERE or_method like '$pay_type[$i]%' AND in_check = '1' $WHERE";
	$Result = query($Sql);
	$Data = happy_mysql_fetch_array($Result);
	//$pay_type[$i] = iconv("euc-kr","utf-8", $pay_type[$i]);
	#$aData[$pay_type[$i]] = $Data[g_price];
	$결제타입별배열[]		= $pay_type[$i]."|".$Data[g_price];
}
$결제타입별_데이터		= implode("\n",$결제타입별배열);
#print_r2($결제타입별배열);


//브라우저별 그래프4(파이)
$columns			= array
(
	0				=> '',
	1				=> '결제 타입별'
);
$options			= array
(
	"sliceVisibilityThreshold"			=> .03,
);
$happy_analytics_graph_js		.= google_pie_graph_js("drawChart2","my_chart2",google_pie_graph_data_str($결제타입별_데이터),$columns,$options);




$결제입금미입배열		= array();
$결제입금미입배열[]		= "결제여부|'입금'|'미입'";
#echo google_area_graph_data_str($결제입금미입별_데이터);  exit;
for($i = $for_cnt ; $i >=0 ; $i--)
{
	$x_date_text[] = $s_temp[0]."-".$s_temp[1];
	$temp = $s_temp[0]."년".$s_temp[1]."월";

	#ECHO $temp."<bR>";
	$s_temp[1]++;

	if($s_temp[1] >12){
		$s_temp[0]++;
		$s_temp[1] = 1;
	}

	if($s_temp[1] < 10)
			$s_temp[1] = "0".$s_temp[1];

	#입금 내역
	$Sql = "SELECT COUNT(*) as ct ,SUM(goods_price) as total_price FROM $jangboo WHERE in_check = '1' AND left(DATE_SUB(  '$e_date',  INTERVAL $i month  ) ,7) = left(jangboo_date,7) $WHERE";

	$Result	= query($Sql);
	$J_zero = happy_mysql_fetch_array($Result);
	$J_zero[total_price] = ( $J_zero[total_price] == 0 ) ? 0 : $J_zero[total_price];
	#print_r2($J_zero);


	#미입 내역
	$Sql = "SELECT COUNT(*) as ct ,SUM(goods_price) as total_price FROM $jangboo WHERE in_check = '0' AND left(DATE_SUB(  '$e_date',  INTERVAL $i month  ) ,7) = left(jangboo_date,7) $WHERE";
	$Result	= query($Sql);
	$J_zero2 = happy_mysql_fetch_array($Result);
	$J_zero2[total_price] = ( $J_zero2[total_price] == 0 ) ? 0 : $J_zero2[total_price];

	$결제입금미입배열[]		= "$temp|$J_zero[total_price]|$J_zero2[total_price]";
}
$결제입금미입별_데이터		= implode("\n",$결제입금미입배열);


$columns			= array
(
	0				=> '',
	1				=> '입금/미입에 따른 결제 통계'
);

$options			= array
(
	"width"				=> '75%',
	//"height"			=> $for_cnt*70,
	"height"			=> 600,
	"x_title"			=> "결제금액",
);
$happy_analytics_graph_js		.= google_double_bar_graph_js("drawChart3","my_chart3",google_area_graph_data_str($결제입금미입별_데이터),$columns,$options);


/*
var options = {
	height:700,
	chartArea: {width: '70%', },
	hAxis: {
	  title: '결제금액',
	  minValue: 0
	},
	vAxis: {
	  title: ''
	}
};
*/




$happy_analytics_graph_js		.= '';
$happy_analytics_graph_js		.= "</script>";


/**********************************************************		FLASH 통계를 JAVASCRIPT 로 교체함		****************************************************************/











$TPL->define("출력", "$skin_folder/jangboo_statistics_com.html");
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