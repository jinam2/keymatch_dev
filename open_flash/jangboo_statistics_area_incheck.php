<?php

include './php-ofc-library/open-flash-chart.php';
include ("../inc/config.php");
include ("../inc/function.php");

if (!$_GET[info]){
	print "No define _GET !!";
	exit;
}



$data_1 = array();

$data_1[] = 3;
$data_1[] = 8;
$data_1[] = 2;
$data_1[] = new bar_value(7);
$tmp = new bar_value(3);
$tmp->set_colour( '#000000' );
$tmp->set_tooltip( '푸핫 BAR<br><br><br>총 입금시도 #top# 회');
$data_1[] = $tmp;
$data_1[] = 1;
$data_1[] = 5;

$bar = new bar_3d();
$bar->set_values( $data_1 );
$bar->set_tooltip( 'Blue bar<br>Value:#val#' );

$data_2 = array();
$data_2[] = 4;
$data_2[] = 9;
$data_2[] = 8;
$data_2[] = 4;
$data_2[] = 1;
$data_2[] = 6;
$data_2[] = 3;

$bar_2 = new bar_3d();
$bar_2->set_values( $data_2 );
$bar_2->set_colour( '#FF1292' );
$bar_2->set_tooltip( 'Yello bar<br>Value:#val#' );

$chart = new open_flash_chart();
$chart->set_title( new title( date("D M d Y") ) );
$chart->add_element( $bar );
$chart->add_element( $bar_2 );
$chart->set_bg_colour( '#FFFFFF' );

echo $chart->toPrettyString();


/*
<?php

include './php-ofc-library/open-flash-chart.php';
include ("../inc/config.php");
include ("../inc/function.php");

if (!$_GET[info]){
	print "No define _GET !!";
	exit;
}

$goval_info = "ㅇㅇ";
$goval_sizeinfo = "big";
$goval_title = "해피CGI 접속순위";
$goval_theme = "멍미";
$goval_sdate = '2009-11-10';

global $TOTAL_MEM_COUNT;
global $SEARCH_TOTAL_MEM_COUNT;

list($goval_info,$goval_sizeinfo,$goval_theme,$s_date,$e_date) = split("\|",$_GET[info]);

$goval_title = iconv("euc-kr","utf-8", $goval_title);


#이부분에 날짜 범위 검색 할수 있는 WHERE 절 넣자!
if($s_date && $e_date)
{

	$che_date = date("Y-m-d", happy_mktime());
	if($e_date > date("Y-m-d", happy_mktime()))
	{
		$e_date = $che_date;
	}

	$WHERE = " AND jangboo_date >= '$s_date' AND jangboo_date <= '$e_date'";

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


/*
#총회원수를 구하자!
$sql = "SELECT count(*) from $per_tb";
$TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));

#검색조건에 만족하는 회원수를 구하자!
$sql = "SELECT count(*) from $per_tb WHERE 1=1 $WHERE";
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
*/

if ($goval_theme == 'yellow'){
	$dot_color = '#968F2E';
	$dot_line = '#968F2E';
	$dot_size = 1;
	$fill_color = '#D5D370';
	$title_color= '#0077CC';
}
elseif ($goval_theme == 'green'){
	$dot_color = '#5FA958';
	$dot_line = '#5FA958';
	$dot_size = 1;
	$fill_color = '#89F27E';
	$title_color= '#0077CC';
}
else {
	$dot_color = '#0077CC';
	$dot_line = '#0077CC';
	$dot_size = 1;
	$fill_color = '#E6F2FA';
	$title_color= '#0077CC';
}

#########	금액별 결제 현황 inc/function.php 제일 하단에 $pay_moneys 배열로 가격은 미리 설정 되어 있습니다.	########
if($goval_info == "In_check")
{
	$tail_text = '명';
	for ($i = $for_cnt ; $i >= 0 ; $i --){
		#$Sql = "select count(per_name) as ct , left(DATE_SUB(curdate(), INTERVAL $i month), 7) as moinfo from $per_tb WHERE left(DATE_SUB(  curdate(),  INTERVAL $i month  ) ,7) = left(per_date,7) AND per_date >= '2008-06-09' AND per_date <= '2010-06-09'";

		#입금	미입 횟수 -> ct		미입합계 -> total_price		계산하고 있는 필드의 date -> moinfo
		$Sql = "SELECT COUNT(goods_price) as ct ,SUM(goods_price) as total_price ,left(DATE_SUB(curdate(), INTERVAL $i month), 7) as moinfo  FROM $jangboo WHERE in_check = '1' AND left(DATE_SUB(  curdate(),  INTERVAL $i month  ) ,7) = left(jangboo_date,7) $WHERE";

		#echo $Sql."<br>";

		$Record	= query($Sql);
		$J_zero = happy_mysql_fetch_array($Record);
		$aData[$J_zero[moinfo]] = $J_zero[ct];
		$x_date_text[] = $J_zero[moinfo]."($J_zero[price]원)";
		$Count[] = $J_zero[ct];


		#미입	미입 횟수 -> ct		미입합계 -> total_price		계산하고 있는 필드의 date -> moinfo
		$Sql2 = "SELECT COUNT(goods_price) as ct ,SUM(goods_price) as total_price ,left(DATE_SUB(curdate(), INTERVAL $i month), 7) as moinfo FROM $jangboo WHERE in_check = '0' AND left(DATE_SUB(  curdate(),  INTERVAL $i month  ) ,7) = left(jangboo_date,7) $WHERE";
		$Record2	= query($Sql2);
		$J_zero2 = happy_mysql_fetch_array($Record2);
		$aData2[$J_zero2[moinfo]] = $J_zero2[ct];
		$x_date_text2[] = $J_zero2[moinfo] ."($J_zero2[price]원)";
		$Count2[] = $J_zero2[ct];
	}
}

/*
print_r($aData);
echo "<br><br>";
print_r($x_date_text);
echo "<br><br>";
print_r($Count);

echo "<br><br>";
echo "<br><br>";

print_r($aData2);
echo "<br><br>";
print_r($x_date_text2);
echo "<br><br>";
print_r($Count2);
exit;
*/



/*
3. 입금/미입별 통계 출력

4. 년도/월별로 실제 입금/미입금 별 금액 통계
*/

##### 함수 시작 #####
function open_flash_line($aData,$s_Text,$dot_size = '4',$dot_color = '#0077CC',$goval_info = '')
{
	global $A_max , $A_step , $iSelectedMonth , $total_num ,$d , $goval_year , $x_date_text , $goval_sdate , $goval_sdate , $d , $Count;
	global $X_label_step;

	//$goval_sdate = '2008-10-01';
	list($gs_year,$gs_month,$gs_day) = split("-",$goval_sdate);

	$tmp_array = array();
	$total_num = '';
	$iMax = max($aData);
	$A_step = round ($iMax / 3);
	$A_max = $iMax + $A_step;

	$X_label_step = count($aData) / 4 ;
	$X_label_step = round ($X_label_step);
	if ($iMax == 0)
	{
		$content = 0;
		return $content;
	}
		$d = new solid_dot();

	$i = 0;
	$tmp_date = '';
	foreach($aData as $sKey => $sValue){

		$tmp_date = date("Y-m-d",happy_mktime(0,0,0,$gs_month,$gs_day,$gs_year)+60*60*24*$i);
		//print $tmp_date . "<br>";
		//$x_date_text[] = $aData;

		$t = $sValue + 0;
		$total_num = $total_num + $sValue;
		$d->size($dot_size);
		$d->halo_size(2);
		$d->colour("$dot_color");
		$d->tooltip("#val#$s_Text <br>#x_label# ");

		$tmp_array[] = $t;
		$i ++;
	}
	//exit;
	return $tmp_array;
}





$title = new title( " 검색 회원수 : $SEARCH_TOTAL_MEM_COUNT[0]명 (전체 $TOTAL_MEM_COUNT[0]명 중..)" );

$data_1 = open_flash_line($aData,$tail_text,$dot_size,$dot_color,'$goval_info');
$d = new hollow_dot();
$line_1 = new line();
$line_1->set_width( 2 );
$line_1->set_default_dot_style($d);
$line_1->set_colour( '#3399FF' );
$line_1->set_values( $data_1 );


$data_2 = open_flash_line($aData2,$tail_text,$dot_size,$dot_color,'$goval_info');
$d = new hollow_dot();
$line_2 = new line();
$line_2->set_width( 2 );
$line_2->set_default_dot_style($d);
$line_2->set_colour( '#FF8F92' );
$line_2->set_values( $data_2 );

##### 이 부분이 실직적으로 배열에 값을 넣어서 .. 출력을 가능한 형식으로 바꿔주는 부분이다!!!	#####

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $line_1 );
$chart->add_element( $line_2 );
##### 즉 $title, $line 등의 값을 제대로 만들어서 넣어주면 OK 인데..								#####

$y_axis = new y_axis();
$y_axis->set_range( 0, $A_max, $A_step );
$y_axis->labels = null;
$y_axis->set_offset( false );
$y_axis->set_colour('#AAAAAA');
$y_axis->set_grid_colour( '#EBEBEB' );

$x_axis = new x_axis();
$x_axis->labels = $data;
$x_axis->set_steps( 1 );
$x_axis->set_colour('#AAAAAA');
$x_axis->set_grid_colour( '#EBEBEB' );

$x_labels = new x_axis_labels();
$x_labels->set_steps( $X_label_step );
$x_labels->set_labels( $x_date_text );
$x_axis->set_labels( $x_labels );
$chart->add_y_axis( $y_axis );
$chart->x_axis = $x_axis;

/*
##### 이 부분이 실직적으로 배열에 값을 넣어서 .. 출력을 가능한 형식으로 바꿔주는 부분이다!!!	#####
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $line_1 );
$chart->add_element( $line_2 );
$chart->add_element( $line_3 );
##### 즉 $title, $line 등의 값을 제대로 만들어서 넣어주면 OK 인데..								#####
*/
$chart->set_y_axis( $y );

echo $chart->toPrettyString();

?>



<?php

/*
include './php-ofc-library/open-flash-chart.php';
include ("../inc/config.php");
include ("../inc/function.php");

if (!$_GET[info]){
	print "No define _GET !!";
	exit;
}

$goval_info = "ㅇㅇ";
$goval_sizeinfo = "big";
$goval_title = "해피CGI 접속순위";
$goval_theme = "멍미";
$goval_sdate = '2009-11-10';

global $TOTAL_MEM_COUNT;
global $SEARCH_TOTAL_MEM_COUNT;

list($goval_info,$goval_sizeinfo,$goval_theme,$s_date,$e_date) = split("\|",$_GET[info]);

$goval_title = iconv("euc-kr","utf-8", $goval_title);


#이부분에 날짜 범위 검색 할수 있는 WHERE 절 넣자!
if($s_date && $e_date)
{

	$che_date = date("Y-m-d", happy_mktime());
	if($e_date > date("Y-m-d", happy_mktime()))
	{
		$e_date = $che_date;
	}

	$WHERE = " AND jangboo_date >= '$s_date' AND jangboo_date <= '$e_date'";

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



#####	총회원수를 구하자!		#####
#			요기에 넣어라!			#
#####################################


if ($goval_theme == 'yellow'){
	$dot_color = '#968F2E';
	$dot_line = '#968F2E';
	$dot_size = 1;
	$fill_color = '#D5D370';
	$title_color= '#0077CC';
}
elseif ($goval_theme == 'green'){
	$dot_color = '#5FA958';
	$dot_line = '#5FA958';
	$dot_size = 1;
	$fill_color = '#89F27E';
	$title_color= '#0077CC';
}
else {
	$dot_color = '#0077CC';
	$dot_line = '#0077CC';
	$dot_size = 1;
	$fill_color = '#E6F2FA';
	$title_color= '#0077CC';
}

#########	금액별 결제 현황 inc/function.php 제일 하단에 $pay_moneys 배열로 가격은 미리 설정 되어 있습니다.	########
if($goval_info == "In_check")
{
	$tail_text = '명';
	for ($i = $for_cnt ; $i >= 0 ; $i --)
	{
		#입금	미입 횟수 -> ct		미입합계 -> total_price		계산하고 있는 필드의 date -> moinfo
		$Sql = "SELECT COUNT(goods_price) as ct ,SUM(goods_price) as total_price ,left(DATE_SUB(curdate(), INTERVAL $i month), 7) as moinfo  FROM $jangboo WHERE in_check = '1' AND left(DATE_SUB(  curdate(),  INTERVAL $i month  ) ,7) = left(jangboo_date,7) $WHERE";
		$Result	= query($Sql);
		$J_zero = happy_mysql_fetch_array($Result);
		$aData[$J_zero[moinfo]] = $J_zero[ct];
		if($J_zero[total_price] == "")
			$J_zero[total_price] = 0;
		$x_date_text[] = $J_zero[moinfo]."($J_zero[total_price]원)";
		$Count[] = $J_zero[ct];

		#미입	미입 횟수 -> ct		미입합계 -> total_price		계산하고 있는 필드의 date -> moinfo
		$Sql2 = "SELECT COUNT(goods_price) as ct ,SUM(goods_price) as total_price ,left(DATE_SUB(curdate(), INTERVAL $i month), 7) as moinfo FROM $jangboo WHERE in_check = '0' AND left(DATE_SUB(  curdate(),  INTERVAL $i month  ) ,7) = left(jangboo_date,7) $WHERE";
		$Result2 = query($Sql2);
		$J_zero2 = happy_mysql_fetch_array($Result2);
		$aData2[$J_zero2[moinfo]] = $J_zero2[ct];
		$x_date_text2[] = $J_zero2[moinfo] ."($J_zero2[total_price]원)";
		$Count2[] = $J_zero2[ct];
	}
}

#걍 배열만 만들면 끝! ^^


if ($goval_theme == 'yellow'){
$dot_color = '#968F2E';
$dot_line = '#968F2E';
$dot_size = 3;
$fill_color = '#D5D370';
$title_color= '#0077CC';
}
elseif ($goval_theme == 'green'){
$dot_color = '#5FA958';
$dot_line = '#5FA958';
$dot_size = 3;
$fill_color = '#89F27E';
$title_color= '#0077CC';
}
else {
$dot_color = '#0077CC';
$dot_line = '#0077CC';
$dot_size = 4;
$fill_color = '#E6F2FA';
$title_color= '#0077CC';
}

#####################################
#		여기서부터 함수 시작		#
#####################################
function open_flash_line($aData,$s_Text,$dot_size = '4',$dot_color = '#0077CC',$goval_info = '')
{
	global $A_max , $A_step , $x_date_text , $goval_sdate, $d , $Count;
	global $X_label_step;

	$A_max = 0;
	$A_step = 0;
	$X_label_step = 0;

	#echo $X_label_step;
	#exit;

	//$goval_sdate = '2008-10-01';
	list($gs_year,$gs_month,$gs_day) = split("-",$goval_sdate);

	$tmp_array = array();
	$total_num = '';
	$iMax = max($aData);
	$A_step = round ($iMax / 3);
	$A_max = $iMax + $A_step;

	$X_label_step = count($aData) / 4 ;
	$X_label_step = round ($X_label_step);
	if ($iMax == 0)
	{
		$content = 0;
		return $content;
	}
		$d = new solid_dot();

	$i = 0;
	$tmp_date = '';
	foreach($aData as $sKey => $sValue){

		$tmp_date = date("Y-m-d",happy_mktime(0,0,0,$gs_month,$gs_day,$gs_year)+60*60*24*$i);
		//print $tmp_date . "<br>";
		//$x_date_text[] = $aData;

		$t = $sValue + 0;
		$total_num = $total_num + $sValue;
		$d->size($dot_size);
		$d->halo_size(2);
		$d->colour("$dot_color");
		$d->tooltip("#val#$s_Text <br>#x_label# ");

		$tmp_array[] = $t;
		$i ++;
	}
	//exit;
	return $tmp_array;
}
############################################################################################################



#####################################
#		여기서부터 함수 시작		#
#####################################
function open_flash_line2($aData2,$s_Text,$dot_size = '4',$dot_color = '#0077CC',$goval_info = '')
{
	global $A_max , $A_step , $x_date_text2 , $goval_sdate, $d2 , $Count2;
	global $X_label_step2;

	$A_max = 0;
	$A_step = 0;
	#$X_label_step = 0;

	//$goval_sdate = '2008-10-01';
	list($gs_year,$gs_month,$gs_day) = split("-",$goval_sdate);

	$tmp_array = array();
	$total_num = '';
	$iMax = max($aData2);
	$A_step = round ($iMax / 3);
	$A_max = $iMax + $A_step;

	$X_label_step = count($aData2) / 4 ;
	$X_label_step = round ($X_label_step);
	if ($iMax == 0)
	{
		$content = 0;
		return $content;
	}

	$d2 = new solid_dot();

	$i = 0;
	$tmp_date = '';
	foreach($aData2 as $sKey => $sValue){

		$tmp_date = date("Y-m-d",happy_mktime(0,0,0,$gs_month,$gs_day,$gs_year)+60*60*24*$i);
		//print $tmp_date . "<br>";
		//$x_date_text[] = $aData;

		$t = $sValue + 0;
		$total_num = $total_num + $sValue;
		$d2->size($dot_size);
		$d2->halo_size(2);
		$d2->colour("$dot_color");
		$d2->tooltip("#val#$s_Text <br>#x_label# ");

		$tmp_array[] = $t;
		$i ++;
	}
	//exit;
	return $tmp_array;
}
############################################################################################################


if ($goval_sizeinfo == 'big'){
	$fontsize = '16';
}
else {
	$fontsize = '13';
}

#타이틀은 한번만 불러서 쓰면 된다!
$title = new title( " 검색 회원수 : $SEARCH_TOTAL_MEM_COUNT[0]명 (전체 $TOTAL_MEM_COUNT[0]명 중..)" );
$title->set_style( "{font-size: ${fontsize}px; font-family: 돋움; font-weight: bold; color: ${title_color}; text-align: center;}" );


####		chart 1 START 	####
$data = open_flash_line($aData,$tail_text,$dot_size,$dot_color,'$goval_info');

$chart = new open_flash_chart();
$chart->set_title( $title );

$area = new area();
#set the circle line width:
$area->set_width( 3 );
$area->set_default_dot_style( $d );
$area->set_colour( "$dot_line" );
$area->set_fill_colour( "$fill_color" );
$area->set_fill_alpha( 0.7 );

#$area->on_show(new line_on_show('pop-up', 0, 0));
$area->set_values( $data );

// add the area object to the chart:
$chart->add_element( $area );
####		chart one END 	####



####		chart 2 START 	####
$data2 = open_flash_line2($aData2,$tail_text,$dot_size,$dot_color,'$goval_info');

$chart2 = new open_flash_chart();
#$chart->set_title( $title );

$area2 = new area();
#set the circle line width:
$area2->set_width( 3 );
$area2->set_default_dot_style( $d2 );
$area2->set_colour( "$dot_line" );
$area2->set_fill_colour( "$fill_color" );
$area2->set_fill_alpha( 0.7 );

#$area->on_show(new line_on_show('pop-up', 0, 0));
$area->set_values( $data2 );

// add the area object to the chart:
$chart2->add_element( $area2 );
####		chart one END 	####



########	이 밑으로는 xy 축에 대한 값 설정 부분이다. 1번 호출이면 끝!!	#########
$y_axis = new y_axis();
$y_axis->set_range( 0, $A_max, $A_step );
$y_axis->labels = null;
$y_axis->set_offset( false );
$y_axis->set_colour('#AAAAAA');
$y_axis->set_grid_colour( '#EBEBEB' );

$x_axis = new x_axis();
$x_axis->labels = $data;
$x_axis->set_steps( 1 );
$x_axis->set_colour('#AAAAAA');
$x_axis->set_grid_colour( '#EBEBEB' );

$x_labels = new x_axis_labels();
$x_labels->set_steps( $X_label_step );
$x_labels->set_labels( $x_date_text );
//$x_labels->set_vertical();
// Add the X Axis Labels to the X Axis
$x_axis->set_labels( $x_labels );
$chart->add_y_axis( $y_axis );
$chart->x_axis = $x_axis;
$chart->set_bg_colour('#FFFFFF');
echo $chart->toPrettyString();

*/

?>
*/

?>