<?
##########################
#	딜러 회원 통계 입니다.
##########################
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

	//$goval_title = iconv("euc-kr","utf-8", $goval_title);


	#이부분에 날짜 범위 검색 할수 있는 WHERE 절 넣자!
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
	else{
		echo "잘못된 접근입니다.";
		exit;
	}

	$group_sql = " AND `group` = '2' ";

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

	#########	금액별 결제 현황 inc/function.php 제일 하단에 $pay_moneys 배열로 가격은 미리 설정 되어 있습니다.	########
	if($goval_info == "Money")
	{
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
		}
		#exit;
	}
	#echo $Sql;
	#exit;
	#print_r($aData);
	#exit;

####################################
#여기서부터 함수시작
####################################
//직할시 도 등등 합쳐서 17개 이므로 16 넣음! view_num 은 몇개까지를 나타낼껀지 정하는것!
function open_flash_pie($aData,$s_Text,$view_num = '100'){
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
			$tmp->set_label($sKey, '#706E6E', 11 ); #맨끝숫자는 글자크기 , 파이그래프글자 색조절
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
	else if ($goval_sizeinfo == 'big_typeA'){
		$list_num = '100';
		$view_y_text = '30';
		$fontsize = '13';
		$title_color = '#5B646F';
	}
	else if ($goval_sizeinfo == 'large'){
		$list_num = '100';
		$view_y_text = '30';
		$fontsize = '20';
		$title_color = '#7BADE3';
	}
	else {
		$list_num = '20';
		$view_y_text = '10';
		$fontsize = '13';
	}

	$title = new title( "검색 회원수 : $SEARCH_TOTAL_MEM_COUNT[0]명 (전체 $TOTAL_MEM_COUNT[0]명 중..) \n 총결제금액&nbsp;&nbsp; : $PRICE_TOTAL_DATA[0] 원 \n 총미결제금액 : $PRICE_TOTAL_NO_PAY 원 \n (총결제 시도금액 : $PRICE_TOTAL_DATA_N[0] 원)" );
	$title->set_style( "{font-size: ${fontsize}px; font-family:맑은 고딕,돋움; font-weight:bold; color: ${title_color}; text-align: center;}" );

	$d = open_flash_pie($aData,'명 방문');

	$pie = new pie();
	$pie->start_angle(90);
	$pie->add_animation( new pie_fade() );
	$pie->add_animation( new pie_bounce(10) );
	// ->label_colour('#432BAF') // <-- uncomment to see all labels set to blue
	$pie->gradient_fill();
	$pie->tooltip( '#val# 원 <br> #percent# of 100%' );
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