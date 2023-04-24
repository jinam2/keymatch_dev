<?php

include './php-ofc-library/open-flash-chart.php';
include ("../inc/config.php");
include ("../inc/function.php");

if (!$_GET[info]){
	print "No define _GET !!";
	exit;
}
#########	금액별 결제 현황 inc/function.php 제일 하단에 $pay_moneys 배열로 가격은 미리 설정 되어 있습니다.	########


$goval_info = "ㅇㅇ";
$goval_sizeinfo = "big";
$goval_title = "해피CGI 접속순위";
$goval_theme = "멍미";
$goval_sdate = '2009-11-10';

global $TOTAL_MEM_COUNT;
global $SEARCH_TOTAL_MEM_COUNT;

list($goval_info,$goval_sizeinfo,$goval_theme,$s_date,$e_date) = split("\|",$_GET[info]);

//$goval_title = iconv("euc-kr","utf-8", $goval_title);

#이부분에 날짜 범위 검색 할수 있는 WHERE 절 넣자!
if($s_date && $e_date)
{

	$che_date = date("Y-m-d", happy_mktime());
	if($e_date > date("Y-m-d", happy_mktime()))
	{
		$e_date = $che_date;
	}

	#$WHERE = " AND per_date >= '$s_date' AND per_date <= '$e_date'";

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
else{
	echo "잘못된 접근입니다.";
	exit;
}

$data_1 = array();
$data_2 = array();
$x_date_text = array();

$max1 = 0;
$max2 = 0;

for($i = $for_cnt ; $i >=0 ; $i--)
{
	#툴팁과 X 축의 출력 값을 구하기 위해 START
	$x_date_text[] = $s_temp[0]."-".$s_temp[1];
	$temp = $s_temp[0]."년".$s_temp[1]."월";
	$s_temp[1]++;

	if($s_temp[1] >12){
		$s_temp[0]++;
		$s_temp[1] = 1;
	}

	if($s_temp[1] < 10)
			$s_temp[1] = "0".$s_temp[1];
	#툴팁과 X 축의 출력 값을 구하기 위해 END

	#입금 내역
	$Sql = "SELECT COUNT(*) as ct ,SUM(goods_price) as total_price FROM $jangboo WHERE in_check = '1' AND left(DATE_SUB(  curdate(),  INTERVAL $i month  ) ,7) = left(jangboo_date,7) $WHERE";

	$Result	= query($Sql);
	$J_zero = happy_mysql_fetch_array($Result);
	$J_zero[total_price] = number_format($J_zero[total_price]);

	$tmp = new bar_value(intVal($J_zero[ct]));

	#Bar1의 색상을 설정하라!
	$tmp->set_colour( '#8E9BFE' );

	#년/월까지 툴팁에 표시하기를 원할 경우는 아래의 주석을 푸시오!
	#$tmp->set_tooltip("입금#val#건 <br>".$J_zero[total_price]."원<br>".$temp);
	$tmp->set_tooltip("입금#val#건 <br>".$J_zero[total_price]."원");
	$data_1[] = $tmp;
	if($max1 < $J_zero[ct])
		$max1 = $J_zero[ct];


	#미입 내역
	$Sql = "SELECT COUNT(*) as ct ,SUM(goods_price) as total_price FROM $jangboo WHERE in_check = '0' AND left(DATE_SUB(  curdate(),  INTERVAL $i month  ) ,7) = left(jangboo_date,7) $WHERE";
	$Result	= query($Sql);
	$J_zero2 = happy_mysql_fetch_array($Result);
	$J_zero2[total_price] = number_format($J_zero2[total_price]);

	$tmp = new bar_value(intVal($J_zero2[ct]));

	#Bar2의 색상을 설정하라!
	$tmp->set_colour( '#FF777A' );

	#년/월까지 툴팁에 표시하기를 원할 경우는 아래의 주석을 푸시오!
	#$tmp->set_tooltip("미입#val#건 <br>".$J_zero2[total_price]."원<br>".$temp);
	$tmp->set_tooltip("미입#val#건 <br>".$J_zero2[total_price]."원");
	$data_2[] = $tmp;
	if($max2 < $J_zero2[ct])
		$max2 = $J_zero2[ct];
}

#Y 축의 최고 값을 구하기 위해..
if($max1 > $max2)
	$A_max = $max1 + 5;
else
	$A_max = $max2 + 5;
#Y축에 대한 표시 단위 $A_step 만큼 증가하면서 표시하라(현재는5씩 증가하면서 표시됨!)
$A_step = 5;

$bar = new bar_3d();
$bar->set_values( $data_1 );

$bar_2 = new bar_3d();
$bar_2->set_values( $data_2 );

$chart = new open_flash_chart();
$chart->set_title( new title( date("D M d Y") ) );
$chart->add_element( $bar );
$chart->add_element( $bar_2 );
$chart->set_bg_colour( '#FFFFFF' );

$y_axis = new y_axis();
$y_axis->set_range( 0, $A_max, $A_step );
$y_axis->labels = null;
$y_axis->set_offset( false );
$y_axis->set_colour('#AAAAAA');
$y_axis->set_grid_colour( '#EBEBEB' );

$x_axis = new x_axis();
$X_label_step = 2;

$x_labels = new x_axis_labels();
$x_labels->set_steps( $X_label_step );
$x_labels->set_labels( $x_date_text );
$x_axis->set_labels( $x_labels );
$chart->add_y_axis($y_axis);
$chart->x_axis = $x_axis;

echo $chart->toPrettyString();
?>