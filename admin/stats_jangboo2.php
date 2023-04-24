<?

include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");

//$sql_list = "title ,sorting_number ,display ,product_count ,display_number ,display_width ,template ,pick_width ,pick_display_number ,pick_template ,speed_width ,speed_display_number ,speed_template ,pop_width ,pop_display_number ,pop_template";
//$sql_values = "$title ,$sorting_number ,$display ,$product_count ,$display_number ,$display_width ,$template ,$pick_width ,$pick_display_number ,$pick_template ,$speed_width ,$speed_display_number ,$speed_template ,$pop_width ,$pop_display_number ,$pop_template";


if ( !admin_secure("접속통계") && !admin_secure("결제관리") ) {
	error("접속권한이 없습니다.   ");
	exit;
}


include ("tpl_inc/top_new.php");
if ($action == "") {
	view();
}
elseif ($action == "detail") {
	detail();
}

include ("tpl_inc/bottom.php");

function view(){
global $duplication,$jangboo2,$car_stats,$pg,$page_print,$now_location_subtitle;

$graph_length = "200";
$graph_length_detail = "400";


print <<<END
<p class='main_title'>$now_location_subtitle</p>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' border='0' class='bg_style table_line'>
	<tr>
		<th>번호</th>
		<th>기간</th>
		<th>시도횟수</th>
		<th>입금횟수</th>
		<th>미입횟수</th>
		<th>총금액</th>
		<th>입금금액</th>
		<th >미입금액</th>
		<th>총금액 비율</th>
	</tr>
END;
	$pagenum = 15;
	if($pg==0){$pg=1;}


 #월별 통계를 보여준다.

 #SELECT left(jangboo_date,7) as tt FROM `car_jangboo` group by tt

	$sql31 = "SELECT count(*) FROM $jangboo2 group by left(jangboo_date,7)";
	$result31 = query($sql31);
	$numb = mysql_num_rows($result31);//총레코드수
	$total_page = ( $numb - 1 ) / $pagenum+1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = ($pg - 1) * $pagenum;
	$co  =  $numb  -  $pagenum  *  ( $pg - 1 );

	#가장많은 접속을 기준으로 200에 대해서 100%를 줘야 한다.
	$sql2 = "select sum(goods_price) from  $jangboo2 group by left(jangboo_date,7) ";
	$result2 = query($sql2);
	$max_array = array();
	while ( list($max_access) = mysql_fetch_row($result2)){
		$max_array[] = $max_access;
	}
	rsort($max_array);
	$max_number = $max_array[0];

	//그래프 출력 개선 hong
	$last_total_money	= array_sum($max_array);


	$sql = "SELECT
	left(jangboo_date,7) as tt ,
	sum(goods_price) ,
	sum(if(in_check = 1,goods_price,0)) as in_total ,
	count(number)	as total_count,
	sum(if(in_check = 1,in_check,0)) as in_count
	FROM $jangboo2 group by tt order by number desc limit $view_rows,$pagenum";
	$result = query($sql);
//	print "$sql";

	while ( list($get_date,$total_money,$in_total,$total_count,$in_count) = mysql_fetch_row($result)){

		//그래프 출력 개선 hong
		$graph_text		= "총 ".number_format($total_money)."원 장부상 결제";
		$graph_out		= 0;
		$graph_percent	= '0%';
		if ( $total_money > 0 )
		{
			#전체를 100으로 보고 거기에 대한 비율은
			#전체
			#200 : 현재길이 = 100 : x
			#전체길이 = 100 x 현재길이 / X
			$graph_out		= ($graph_length * $total_money) / $max_number;
			$graph_out		= ceil($graph_out);
			$graph_percent	= round($total_money/$last_total_money*100,1) . '%';
		}

		$not_in_count = $total_count - $in_count;
		$not_in_total = $total_money - $in_total;
		$not_in_total = number_format($not_in_total);
		$total_money = number_format($total_money);
		$in_total = number_format($in_total);
		print "
			<tr>
				<td style='text-align:center; height:35px'>$co</td>
				<td style='text-align:center;'><a href=stats_jangboo2.php?action=detail&number=$get_date style='color:#333'>$get_date</a></td>
				<td style='text-align:right;'>$total_count 회</td>
				<td style='text-align:right;'>$in_count 회</td>
				<td style='text-align:right;'>$not_in_count 회</td>
				<td style='text-align:right;'>$total_money 원</td>
				<td style='text-align:right;'>$in_total 원</td>
				<td style='text-align:right;'>$not_in_total 원</td>
				<td style='text-align:right;'>$graph_percent <img src=../img/vote/leftbar.gif height=15><img src=../img/vote/mainbar.gif width=$graph_out height=15 alt='$graph_text' title='$graph_text'><img src=../img/vote/rightbar.gif height=15></td>
			</tr>
		";
	$co--;
	}
	include("../page.php");

	print "
	</table>
</div>
<div align='center' style='padding:20px 0 10px 0;'>$page_print</div>

	";
}


function detail(){

global $jangboo2,$car_stats,$pg,$page_print,$number;

$graph_length = "200";
$graph_length_detail = "400";

$DATE = split("-",$number);

print <<<END

<p class='main_title'>개인회원 결제통계 $DATE[0]년 $DATE[1]월 상세통계</p>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' border='0' class='bg_style table_line'>
	<tr>
		<th>번호</th>
		<th>기간</th>
		<th>시도횟수</th>
		<th>입금횟수</th>
		<th>미입횟수</th>
		<th>총금액</th>
		<th>입금금액</th>
		<th >미입금액</th>
		<th>총금액 비율</th>
	</tr>
END;


	#가장많은 접속을 기준으로 200에 대해서 100%를 줘야 한다.
	$sql2 = "select sum(goods_price) from  $jangboo2 where left(jangboo_date,7) = '$number'  group by left(jangboo_date,10)  ";
	$result2 = query($sql2);
	$max_array = array();
	while ( list($max_access) = mysql_fetch_row($result2)){
		$max_array[] = $max_access;
	}
	rsort($max_array);
	$max_number = $max_array[0];

	//그래프 출력 개선 hong
	$last_total_money	= array_sum($max_array);

	$sql = "SELECT
	left(jangboo_date,10) as tt ,
	sum(goods_price) ,
	sum(if(in_check = 1,goods_price,0)) as in_total ,
	count(number)	as total_count,
	sum(if(in_check = 1,in_check,0)) as in_count
	FROM $jangboo2  where left(jangboo_date,7) = '$number' group by tt   order by number desc";
	$result = query($sql);
//	print "$sql";

	while ( list($get_date,$total_money,$in_total,$total_count,$in_count) = mysql_fetch_row($result)){

		//그래프 출력 개선 hong
		$graph_text		= "총 ".number_format($total_money)."원 장부상 결제";
		$graph_out		= 0;
		$graph_percent	= '0%';
		if ( $total_money > 0 )
		{
			#전체를 100으로 보고 거기에 대한 비율은
			#전체
			#200 : 현재길이 = 100 : x
			#전체길이 = 100 x 현재길이 / X
			$graph_out		= ($graph_length * $total_money) / $max_number;
			$graph_out		= ceil($graph_out);
			$graph_percent	= round($total_money/$last_total_money*100,1) . '%';
		}

		$not_in_count = $total_count - $in_count;
		$not_in_total = $total_money - $in_total;
		$not_in_total = number_format($not_in_total);
		$total_money = number_format($total_money);
		$in_total = number_format($in_total);
		print "
			<tr>
				<td style='text-align:center;'>--</td>
				<td style='text-align:center;'>$get_date</td>
				<td style='text-align:right;'>$total_count 회</td>
				<td style='text-align:right;'>$in_count 회</td>
				<td style='text-align:right;'>$not_in_count 회</td>
				<td style='text-align:right;'>$total_money 원</td>
				<td style='text-align:right;'>$in_total 원</td>
				<td style='text-align:right;'>$not_in_total 원</td>
				<td style='text-align:right;'><img src=../img/vote/leftbar.gif height=15><img src=../img/vote/mainbar.gif width=$graph_out height=15 alt='총 $total_money 원 장부상 결재'><img src=../img/vote/rightbar.gif height=15></td>
			</tr>";
	}
	include("../page.php");

	print "
	</table>
</div>

	";


}
