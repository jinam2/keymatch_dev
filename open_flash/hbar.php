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

	if ($goval_theme == 'yellow'){
		$dot_color = '#968F2E';
		$dot_line = '#968F2E';
		$dot_size = 3;
		$fill_color = '#D5D370';
	}
	elseif ($goval_theme == 'green'){
		$dot_color = '#5FA958';
		$dot_line = '#5FA958';
		$dot_size = 3;
		$fill_color = '#89F27E';
	}
	else {
		$dot_color = '#0077CC';
		$dot_line = '#0077CC';
		$dot_size = 4;
		$fill_color = '#E6F2FA';
	}


	$sql = "select * from $happy_analytics_tb where last_read = '1' ";
	$result = query($sql);
	$GOOGLE = happy_mysql_fetch_array($result);
	$goval_sdate = $GOOGLE[sdate];

	//$GOOGLE[$goval_info] = iconv("euc-kr","utf-8", $GOOGLE[$goval_info]);
	//$goval_title = iconv("euc-kr","utf-8", $goval_title);

	if (strlen($GOOGLE[getVisitors]) < 5){
		$no_sample = '';
		for ($i = 1 ; $i <= 100 ; $i++){
			if ($i == '100'){
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
	foreach ($DATA as $list){
		list($tit,$val) = split("\|",$list);
		$aData[$tit] = $val;
	}


####################################
#여기서부터 함수시작
####################################
function utf_logn_strcut($str, $len, $tail='...'){
	global $utf_add_cut;
	if ($len > 15){
	$len = $len - $utf_add_cut;
	}
	$rtn = array();
	return preg_match('/.{'.$len.'}/su', $str, $rtn) ? $rtn[0].$tail : $str;
}


function open_flash_hbar($aData,$s_Text,$view_num = '20'){
	global $A_max , $A_step , $iSelectedMonth , $total_num , $hbar , $refer_name , $goval_kind;


	$tmp_array = array();
	$refer_name = array();

	$total_num = '';
    $iMax = max($aData);
	$A_step = round ($iMax / 5);
	$A_max = $iMax + $A_step;
    if ($iMax == 0){
        $content = 0;
        return $content;
    }


	$i = 0;
    foreach($aData as $sKey => $sValue){
		$t = $sValue + 0;
		$total_num = $total_num + $sValue;

		#검색단어키워드면 맨앞에꺼는 날린다
		if ($goval_kind == 'top_remove' && $iMax == $sValue ){
		}
		else {
		$sKey = utf_logn_strcut($sKey, 40 , "...");
		array_unshift($refer_name,$sKey);
		$tmp_array[] = $sValue;
		$i ++;
		}


		if ($i > $view_num){
			 return $tmp_array;
		}
    }


    return $tmp_array;

}


####################################

	if ($goval_sizeinfo == 'big'){
		$list_num = '100';
		$view_y_text = '30';
		$fontsize = '16';
	}
	else {
		$list_num = '20';
		$view_y_text = '10';
		$fontsize = '13';
	}


	$hbar = new hbar( '#247ECB');
	$hbar->set_tooltip( '#val#회 페이지뷰' );
	$get_value = open_flash_hbar($aData,'명 방문',$list_num);

	$title = new title( "$goval_title" );
	#$title = new title( "$goval_title TOP$list_num" );


	$title->set_style( "{font-size: ${fontsize}px; font-family: 돋움; font-weight: bold; color: #F97688; text-align: center;}" );


	$hbar->set_values( $get_value );

	$chart = new open_flash_chart();
	$chart->set_title( $title );
	$chart->add_element( $hbar );


	$x = new x_axis();
	$x->set_offset( false );
	$x->set_colour('#AAAAAA');
	$x->set_grid_colour( '#EBEBEB' );
	$x->set_steps( 60 );

	$chart->set_x_axis( $x );

	$y = new y_axis();
	$y->set_offset( true );
	$y->set_labels( $refer_name );
	$y->set_colour('#AAAAAA');
	$y->set_grid_colour( '#EBEBEB' );
	$y->set_steps( 1 );

	$chart->add_y_axis( $y );

	$tooltip = new tooltip();
	//
	// LOOK:
	//
	$tooltip->set_hover();
	//
	//
	//
	$tooltip->set_stroke( 1 );
	$tooltip->set_colour( "#000000" );
	$tooltip->set_background_colour( "#ffffff" );
	$chart->set_tooltip( $tooltip );
	$chart->set_bg_colour('#FFFFFF');

	echo $chart->toPrettyString();





?>