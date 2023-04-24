<?
include './php-ofc-library/open-flash-chart.php';
include ("../inc/config.php");
include ("../inc/function.php");


	if (!$_GET[info]){
		print "No define _GET !!";
		exit;
	}
	else {
		$info = $_GET[info];
	}

	list($goval_info,$goval_kind,$goval_sizeinfo,$goval_title,$goval_theme) = split("\|",$_GET[info]);


	$sql = "select * from $happy_analytics_tb where last_read = '1' ";
	$result = query($sql);
	$GOOGLE = happy_mysql_fetch_array($result);
	$goval_sdate = $GOOGLE[sdate];

	//$GOOGLE[$goval_info] = iconv("euc-kr","utf-8", $GOOGLE[$goval_info]);
	//$goval_title = iconv("euc-kr","utf-8", $goval_title);


	if (strlen($GOOGLE[getVisitors]) < 5){
		$no_sample = '';
		for ($i = 1 ; $i <= 30 ; $i++){
			if ($i == '30'){
				$mark_num= '1';
			}
			else {
				$mark_num= '0';
			}
		$no_sample .= "정보없음$i|$mark_num\n";

		}
		$GOOGLE[$goval_info] = $no_sample;
	}


	$DATA = split("\n",$GOOGLE[$goval_info]);
	$aData = array();
	$x_date_text = array();
	foreach ($DATA as $list){
		list($tit,$val) = split("\|",$list);
		$aData[$tit] = $val;
		$x_date_text[] = $tit;
	}


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

function open_flash_line($aData,$s_Text,$dot_size = '4',$dot_color = '#0077CC'){
	global $A_max , $A_step , $iSelectedMonth , $total_num ,$d , $goval_year , $x_date_text , $goval_sdate , $goval_sdate , $d;
	global $X_label_step;


	//$goval_sdate = '2008-10-01';
	list($gs_year,$gs_month,$gs_day) = split("-",$goval_sdate);

	$tmp_array = array();
	$total_num = '';
    $iMax = max($aData);
	$A_step = round ($iMax / 2);
	$A_max = $iMax + $A_step;

	$X_label_step = count($aData) / 6;
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
		//print $tmp_date . "<br>";
		//$x_date_text[] = $aData;

		$t = $sValue + 0;
		$total_num = $total_num + $sValue;
		$d->size($dot_size);
		$d->halo_size(2);
		$d->colour("$dot_color");
		$d->tooltip("#val# $s_Text<br>#x_label# ");

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


	$data = open_flash_line($aData,'명 방문',$dot_size,$dot_color);
	$chart = new open_flash_chart();

	$total_num_comma = number_format($total_num);

	$title = new title( "$goval_title (${total_num_comma}명)" );

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

	#시작속도
	$randnum = rand(10,20);
	$randnum = $randnum / 10;

	#뜨는속도
	$randnum2 = rand(5,20);
	$randnum2 = $randnum2 / 10;

	$area->on_show(new line_on_show('pop-up', $randnum2, $randnum));
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
	$x_axis->set_steps( 2 );
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