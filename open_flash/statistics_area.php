<?
include './php-ofc-library/open-flash-chart.php';
include ("../inc/config.php");
include ("../inc/function.php");

$goval_info = "ㅇㅇ";
$goval_sizeinfo = "big";
$goval_title = "해피CGI 접속순위";
$goval_theme = "멍미";
$goval_sdate = '2009-11-10';

global $TOTAL_MEM_COUNT;
global $SEARCH_TOTAL_MEM_COUNT;

list($goval_info,$goval_sizeinfo,$goval_theme,$s_date,$e_date,$member_type) = split("\|",$_GET[info]);

//$goval_title = iconv("euc-kr","utf-8", $goval_title);

if($member_type == "per")
{
	$per_tb = $happy_member;
	$per_date = "reg_date";
	$per_name = "user_name";
	$group_sql = " AND `group` = '1' ";
}
else
{
	$per_tb = $happy_member;
	$per_date = "reg_date";
	$per_name = "user_name";
	$group_sql = " AND `group` = '2' ";
}

#이부분에 날짜 범위 검색 할수 있는 WHERE 절 넣자!
if($s_date && $e_date)
{
	$che_date = date("Y-m-d", happy_mktime());
	if($e_date > date("Y-m-d", happy_mktime()))
	{
		$e_date = $che_date;
	}

	$WHERE = " AND $per_date >= '$s_date' AND $per_date <= '$e_date'";

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

#총회원수를 구하자!
$sql = "SELECT count(*) from $happy_member where 1=1 $group_sql ";
$TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));

#검색조건에 만족하는 회원수를 구하자!
$sql = "SELECT count(*) from $happy_member WHERE 1=1 $WHERE $group_sql";
$SEARCH_TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));

#걍 배열만 만들면 끝! ^^
$aData = array();
$Count = array();
$x_date_text = array();
$x_date_text2 = array();

if ($goval_info == "Month"){
	#echo $goval_info."<br>";
	$tail_text = '명';

	/* 어떤 조건이든 최근1년만 집계되어서 아래로 교체함
	for ($i = $for_cnt ; $i >= 0 ; $i --){
		$Sql = "select count($per_name) as ct , left(DATE_SUB(curdate(), INTERVAL $i month), 7) as moinfo from $per_tb WHERE left(DATE_SUB(  curdate(),  INTERVAL $i month  ) ,7) = left($per_date,7) $WHERE $group_sql";
		$Record	= query($Sql);
		$J_zero = happy_mysql_fetch_array($Record);
		$aData[$J_zero[moinfo]] = $J_zero[ct];
		$x_date_text[] = $J_zero[moinfo] . "($J_zero[ct]명)";
		$Count[] = $J_zero[ct];
	}
	*/

	$aData = array();
	list($Y,$M,$D) = explode("-",$e_date);
	$k = 0;
	for ($i = $for_cnt ; $i >= 0 ; $i --)
	{
		//echo $i." month before "." ===> "; echo date("Y-m",happy_mktime(0,0,0,$M-$i,$D,$Y)); echo "<br>";
		$J_zero[moinfo] = date("Y-m",happy_mktime(0,0,0,$M-$i,$D,$Y));

		$aData[$J_zero[moinfo]] = "0";
		$x_date_text2[$J_zero[moinfo]] = $k;
		$x_date_text[$k] = $J_zero[moinfo] . "(0명)";
		$k++;
	}

	$Sql = "select left(reg_date,7) as moinfo, count(*) as ct from happy_member where 1=1 $WHERE $group_sql group by left(reg_date,7) ";
	//echo $Sql;
	$result = query($Sql);
	while($J_zero = happy_mysql_fetch_assoc($result))
	{
		$aData[$J_zero[moinfo]] = $J_zero[ct];
		$x_date_text[$x_date_text2[$J_zero[moinfo]]] = $J_zero[moinfo] . "($J_zero[ct]명)";
		$Count[] = $J_zero[ct];
	}
	/*
	print_r($aData);
	echo "<br><br>";
	print_r($x_date_text);
	echo "<br><br>";
	print_r($Count);
	exit;
	*/
}
else if($goval_info == "week"){

	$week_name = Array("일", "월", "화", "수", "목", "금", "토");

	#배열값 0으로 초기화!
	for($i = 0 ; $i < sizeof($week_name) ; $i++)
		$week[] = 0;

	$tail_text = '명';
	$Sql = "select LEFT($per_date, 10) as temp_date from $per_tb WHERE 1=1 $WHERE $group_sql";

	$Result	= query($Sql);
	while($Data = happy_mysql_fetch_array($Result))
	{
		$temp1 = explode("-", $Data[temp_date]);
		#시 분 초 월 일 년
		$time = happy_mktime(0,0,0, $temp1[1], $temp1[2], $temp1[0]);
		$temp = date("w", $time);

		##### 요기부터 하면 됨.. 배열에 밀어 넣자!!! #####
		switch($temp){
			case 0:
				$week[0]++;
				break;
			case 1:
				$week[1]++;
				break;
			case 2:
				$week[2]++;
				break;
			case 3:
				$week[3]++;
				break;
			case 4:
				$week[4]++;
				break;
			case 5:
				$week[5]++;
				break;
			case 6:
				$week[6]++;
				break;
			default:
				break;
		}
	}

	for($i = 0 ; $i < 7 ; $i ++)
	{
		$aData[$week_name[$i]] = $week[$i];
		$x_date_text[] = $week_name[$i] . "($week[$i]명)";
		$Count[$week_name[$i]] = $week[$i];
	}
}



#총회원수를 구하자!
$sql = "SELECT count(*) from $happy_member where 1=1 $group_sql ";
$TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));

#검색조건에 만족하는 회원수를 구하자!
$sql = "SELECT count(*) from $happy_member WHERE 1=1 $WHERE $group_sql";
$SEARCH_TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));



#걍 배열만 만들면 끝! ^^

####################################
#여기서부터 함수시작
####################################

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

function open_flash_line($aData,$s_Text,$dot_size = '4',$dot_color = '#0077CC',$goval_info = '')
{
	global $A_max , $A_step , $x_date_text , $goval_sdate, $d , $Count;
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
		//return $content;
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

####################################


if ($goval_sizeinfo == 'big'){
	$fontsize = '16';
}
else {
	$fontsize = '13';
}


$data = open_flash_line($aData,$tail_text,$dot_size,$dot_color,'$goval_info');

$chart = new open_flash_chart();

$title = new title( " 검색 회원수 : $SEARCH_TOTAL_MEM_COUNT[0]명 (전체 $TOTAL_MEM_COUNT[0]명 중..)" );

$title->set_style( "{font-size: ${fontsize}px; font-family: 돋움; font-weight: bold; color: ${title_color}; text-align: center;}" );
$chart->set_title( $title );
//
// Make our area chart:
//
$area = new area();
// set the circle line width:
$area->set_width( 3 );
$area->set_default_dot_style( $d );
$area->set_colour( "$dot_line" );
$area->set_fill_colour( "$fill_color" );
$area->set_fill_alpha( 0.7 );



#$area->on_show(new line_on_show('pop-up', 0, 0));
$area->set_values( $data );

// add the area object to the chart:
$chart->add_element( $area );

$y_axis = new y_axis();
$y_axis->set_range( 0, $A_max + 1, $A_step );
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

?>