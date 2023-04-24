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

#info=local|big| |2009-06-08|2010-06-08
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

	$WHERE = " AND per_date >= '$s_date' AND per_date <= '$e_date'";

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
$sql = "SELECT count(*) from $per_tb";
$TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));

#검색조건에 만족하는 회원수를 구하자!
$sql = "SELECT count(*) from $per_tb WHERE 1=1 $WHERE";
$SEARCH_TOTAL_MEM_COUNT = happy_mysql_fetch_array(query($sql));


#걍 배열만 만들면 끝! ^^
$aData = array();
$Count = array();
$x_date_text = array();

#시간별 회원가입현황
if($goval_info == "time")
{
	$tail_text = '명';
	for($i =0 ; $i < 25 ; $i++)
	{
		$Sql = "SELECT count(*) as per_time from $per_tb WHERE $i <= SUBSTRING(per_date, 12, 2) AND SUBSTRING(per_date, 12, 2) < $i+1 $WHERE";
		$Result = query($Sql);
		while($Data = happy_mysql_fetch_array($Result))
		{
			$aData[$i."시"] = $Data[per_time];
			$Count[$i] = $Data[per_time];
			$x_date_text[] = $i."시";
		}
	}
}

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
$percent = 0;
function open_flash_line($aData,$s_Text,$dot_size = '4',$dot_color = '#0077CC',$goval_info = ''){
	global $A_max , $A_step , $iSelectedMonth , $total_num ,$d , $goval_year , $x_date_text , $goval_sdate , $goval_sdate , $d , $Count;
	global $X_label_step, $t_count, $percent;

	//$goval_sdate = '2008-10-01';
	list($gs_year,$gs_month,$gs_day) = split("-",$goval_sdate);

	$tmp_array = array();
	$total_num = '';
	$iMax = max($aData);
	$A_step = round ($iMax / 3);
	$A_max = $iMax + $A_step;

	$X_label_step = count($aData) / 4 ;
	$X_label_step = round ($X_label_step);
	if ($iMax == 0){
		$content = 0;
		return $content;
	}
		$d = new solid_dot();

	$i = 0;
	$tmp_date = '';
	foreach($aData as $sKey => $sValue){

		$tmp_date = date("Y-m-d",happy_mktime(0,0,0,$gs_month,$gs_day,$gs_year)+60*60*24*$i);

		$t = $sValue + 0;
		$total_num = $total_num + $sValue;
		$d->size($dot_size);
		$d->halo_size(2);
		$d->colour("$dot_color");
		$d->tooltip("#val#$s_Text <br> #x_label# ");

		$tmp_array[] = $t;
		$i ++;

	}

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

$total_num_comma = number_format($total_num);

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


$area2 = new area();
// set the circle line width:
$area2->set_width( 3 );
$area2->set_default_dot_style( $d );
$area2->set_colour( "$dot_line" );
$area2->set_fill_colour( "$fill_color" );
$area2->set_fill_alpha( 0.7 );


#시작속도
$randnum = rand(0,1);
$randnum = $randnum / 10;

#뜨는속도
$randnum2 = rand(0,1);
$randnum2 = $randnum2 / 10;

#$area->on_show(new line_on_show('pop-up', 0, 0));
$area->set_values( $data );

// add the area object to the chart:
$chart->add_element( $area );

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

?>