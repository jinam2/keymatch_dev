<?
include './php-ofc-library/open-flash-chart.php';
include ("../inc/config.php");
include ("../inc/function.php");




	list($goval_info,$goval_kind,$goval_sizeinfo,$goval_title,$goval_theme) = split("\|",$_GET[info]);


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
	foreach ($DATA as $list){
		list($tit,$val) = split("\|",$list);
		$aData[$tit] = $val;
	}

		$aData = array();



		$Sql	= "SELECT COUNT(*) FROM $links where pop > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$pop_count	= $Data[0];
#		$aData[인기업체수] = $pop_count	;
		$aData[A] = $pop_count	;

		$Sql	= "SELECT COUNT(*) FROM $links where new > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$new_count	= $Data[0];
#		$aData[신규업체수] = $new_count	;
		$aData[B] = $new_count	;

		$Sql	= "SELECT COUNT(*) FROM $links where pick > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$pick_count	= $Data[0];
#		$aData[추천업체수] = $pick_count	;
		$aData[C] = $pick_count	;

		$Sql	= "SELECT COUNT(*) FROM $links where spec > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$spec_count	= $Data[0];
#		$aData[프리미엄업체수] = $spec_count	;
		$aData[D] = $spec_count	;

		$Sql	= "SELECT COUNT(*) FROM $links WHERE wait = '1' ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$wait_upso_count	= $Data[0];
#		$aData[대기업체수] = $wait_upso_count	;
		$aData[E] = $wait_upso_count	;

		$Sql	= "SELECT COUNT(*) FROM $links WHERE coopon!='' ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$coopon_upso_count	= $Data[0];
#		$aData[쿠폰업체수] = $coopon_upso_count	;
		$aData[F] = $coopon_upso_count	;

		$Sql	= "SELECT COUNT(*) FROM $links WHERE hompi_end_date >= curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$mini_upso_count	= $Data[0];
#		$aData[미니홈피업체수] = $mini_upso_count	;
		$aData[G] = $mini_upso_count	;




####################################
#여기서부터 함수시작
####################################

function open_flash_pie($aData,$s_Text,$view_num = '5'){
	global $A_max , $A_step , $iSelectedMonth , $total_num , $goval_kind;
	$tmp_array = array();
	$d = array();

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
		$tmp = new pie_value($t, "");
		$tmp->set_label("$sKey", '#706E6E', 8 ); #맨끝숫자는 글자크기 , 파이그래프글자 색조절
		$tmp_array[] = $tmp;
		}




		#$tmp_array[] = $d->colour('#1F98FF')->tooltip("#val# $s_Text<br>${sKey}시");
		$i ++;
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


	$title = new title( "$goval_title" );
	$title->set_style( "{font-size: ${fontsize}px; font-family: 돋움; font-weight: bold; color: ${title_color}; text-align: center;}" );

	$d = open_flash_pie($aData,'명 방문');



	$pie = new pie();
		$pie->start_angle(90);
		$pie->add_animation( new pie_fade() );
		$pie->add_animation( new pie_bounce(15) );
		// ->label_colour('#432BAF') // <-- uncomment to see all labels set to blue
		$pie->gradient_fill();
		$pie->tooltip( '#val# of #total#<br>#percent# of 100%' );
		$pie->colours(
			array(
				'#FF4448',    // <-- blue
				'#2F4CFF',    // <-- grey
				'#36FF3A',    // <-- green
				'#FDF400' ,   // <-- light green
				'#090800' ,   // <-- light green
				'#8E9BFE',   // <-- light green
				'#FF86F2'   // <-- light green
			) );

	$pie->set_values( $d );

	$chart = new open_flash_chart();
	$chart->set_title( $title );
	$chart->add_element( $pie );
	$chart->set_bg_colour('#FFFFFF');

	echo $chart->toPrettyString();





?>