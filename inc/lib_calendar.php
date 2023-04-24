<?
	#달력출력 함수
	#{{달력출력 껍데기템플릿,알맹이템플릿,상품이있을때배경색,상품이없을때배경색}}
	function happy_schedule_calrendar($template_d,$template_r,$bg_exist,$bg_exist_not)
	{

		global $TPL, $skin_folder;
		global $CALRENDAR, $CAL_ADD, $PRESENT, $rows_cal, $이전달링크, $다음달링크, $해당일링크, $Cal_bg_color;
		global $레이어아이디,$껍데기템플릿,$상세템플릿,$배경색1,$배경색2,$달력타입,$아작스껍데기템플릿, $클릭이벤트, $객실리스트;
		global $happy_schedule_icon_year , $calendar_dojang_tb;
		global $day_number,$cal_day,$cal_day2, $roomData, $달력아이콘;
		global $dojang_info;
		global $mem_id;


		$껍데기템플릿	= $template_d;
		$상세템플릿		= $template_r;
		$배경색1		= $bg_exist;
		$배경색2		= $bg_exist_not;




		#관리자 체크 # true or false

		$PRESENT = array();


		if ( $_GET['get_select_date'] != '' )
		{
			$date_tmp		= explode("-",$_GET['get_select_date']);

			$_GET['s_year']		= $date_tmp[0];
			$_GET['s_month']	= $date_tmp[1];
			$_GET['s_day']		= $date_tmp[2];
		}

		if (!$_GET["s_year"])
		{
			$s_y = date("Y",happy_mktime());
		}
		else
		{
			$s_y = $_GET["s_year"];
		}

		if (!$_GET["s_month"])
		{
			$s_m = date("m",happy_mktime());
		}
		else
		{
			$s_m = $_GET["s_month"];
		}

		if (!$_GET["s_day"])
		{
			$s_d = date("d",happy_mktime());
		}
		else
		{
			$s_d = $_GET["s_day"];
		}




		$re_year	= $s_y;
		$re_month	= $s_m;






		#타임스탬프 구하고
		$m_stamp = happy_mktime(0,0,0,$s_m,1,$s_y);
		$d_stamp = happy_mktime(0,0,0,$s_m,$s_d,$s_y);



		#이전달 다음달 구하고
		$prev_date = explode("-",date("Y-m",happy_mktime(0,0,0,$s_m - 1,1,$s_y)));
		$next_date = explode("-",date("Y-m",happy_mktime(0,0,0,$s_m + 1,1,$s_y)));

		#그달의 총 일수 / 그달의 시작요일 / 주
		$StartYoil = date("w",$m_stamp);
		$TotalDays = date("t",$d_stamp);
		$TotalDays_w = $TotalDays + $StartYoil;

		$Week = ceil($TotalDays_w / 7);
		$TotalCount = $Week * 7;

		$PRESENT["year"] = $s_y;
		$PRESENT["month"] = $s_m;
		$PRESENT["day"] = $s_d;
		$이전달링크 = "s_year=".$prev_date[0]."&s_month=".$prev_date[1];
		$다음달링크 = "s_year=".$next_date[0]."&s_month=".$next_date[1];

		$PRESENT['prev_year']	= $prev_date[0];
		$PRESENT['prev_month']	= $prev_date[1];
		$PRESENT['next_year']	= $next_date[0];
		$PRESENT['next_month']	= $next_date[1];
		#echo "총:".$TotalDays."/시작요일:".$StartYoil."/주:".$Week."<bR>";


		#달력 아이콘 추출#
		$year_tmp	= $PRESENT['year'];

		$PRESENT['year_icon']	= "";
		for ( $i=0 ; $i<4 ; $i++ )
		{
			$PRESENT['year_icon']	.= "<img src='".$happy_schedule_icon_year[$year_tmp[$i]]."' align='absmiddle' border='0'>";
			$PRESENT['year_icon2']	.= "<img src='".$happy_schedule_icon_year2[$year_tmp[$i]]."' align='absmiddle' border='0'>";
		}

		$month_tmp	= $PRESENT['month'];

		$PRESENT['month_icon']	= "";
		for ( $i=0 ; $i<2 ; $i++ )
		{
			$PRESENT['month_icon']	.= "<img src='".$happy_schedule_icon_month[$month_tmp[$i]]."' align='absmiddle' border='0'>";
			$PRESENT['month_icon2']	.= "<img src='".$happy_schedule_icon_month2[$month_tmp[$i]]."' align='absmiddle' border='0'>";
		}

		$template_n = str_replace(".html","_no.html",$template_r);

		$TPL->define("달력껍데기",$skin_folder."/".$template_d);
		$TPL->define("달력알맹이",$skin_folder."/".$template_r);
		$TPL->define("없는날짜알맹이",$skin_folder."/".$template_n);



		$cal_day = 1;
		$i = 1;

		for ( $w = 0; $w<$TotalCount; $w++ )
		{
			$Cal_bg_color = $bg_exist_not;

			if ( $w < $StartYoil )
			{
				$one_row = &$TPL->fetch("없는날짜알맹이");
			}
			elseif ( $cal_day > $TotalDays )
			{
				$one_row = &$TPL->fetch("없는날짜알맹이");
			}
			else
			{

				$Cal_bg_color	= $bg_exist;
				$cal_day2		= str_pad($cal_day,2,"0", STR_PAD_LEFT);
				$nowDate		= $s_y ."-". $s_m ."-". $cal_day2;
				$sql = "select * from $calendar_dojang_tb where id = '$mem_id' and   left(reg_date,10) = '$PRESENT[year]-$PRESENT[month]-$cal_day2'   ";
				$result = query($sql);
				$DJ = happy_mysql_fetch_array($result);

				if ($DJ[number]){
					$dojang_info = 'img/chooldojang.gif';
					#$dojang_info = "<img src=img/chooldojang.gif width=78 height=72>";
				}
				else {
					$dojang_info = "";
				}

				$day_number = $cal_day;

				$PRESENT['day_color']	= $day_number;
				if ( $i % 7 == "1" )
				{
					$PRESENT['day_color']	= 'red'.$day_number;
					$day_number = "<font color=red>".$day_number."</font>";
				}
				elseif ( $i % 7 == "0" )
				{
					$PRESENT['day_color']	= 'gray'.$day_number;
					$day_number = "<font color=blue>".$day_number."</font>";
				}


				$link_date = "s_year=".$s_y."&s_month=".$s_m."&s_day=".$cal_day;
				$해당일링크 = $link_date;

				$one_row = &$TPL->fetch("달력알맹이");
				$cal_day++;

			}

			#일주일은 7일이니까 7칸만
			$rows .= table_adjust($one_row,7,$i);
			$i++;

		}

		$rows_cal = "<table cellpadding='0' cellspacing='0' border='0' width='100%'>$rows</table>";

		$달력껍데기 = $TPL->fetch("달력껍데기");


		return $달력껍데기;

	}










	#가로세로정리
	/*
	function table_adjust($main_new,$ex_width,$i){
		$main_new_out = "";

		#TD를 정리하자
		if ($ex_width == "1")
		{
			$main_new = "<tr><td valign='top'>".$main_new."</td></tr>";
		}
		elseif ($i % $ex_width == "1")
		{
			$main_new = "<tr><td valign='top'>".$main_new."</td>";
		}
		elseif ($i % $ex_width == "0")
		{
			$main_new = "<td valign='top'>".$main_new."</td></tr>";
		}
		else
		{
			$main_new = "<td valign='top'>".$main_new."</td>";
		}
		$main_new_out .= $main_new;

		return $main_new_out;
	}
	*/






//댓글리스트
function calendar_extraction_list($ex_limit,$ex_width,$ex_cut,$ex_category,$ex_template,$ex_paging ='',$ex_ajax_id_name = '' , $ex_sub_call = '' , $ex_get_id = '', $ex_garbage = '0' , $ex_action = '',$ex_number = '',$ex_search_type = '',$ex_search_word = '') {


#{{게시판보기 페이지당20개,가로1개,제목길이50자,질문과 답변,bbs_list.html}}
#{{게시판보기 페이지당20개,가로1개,제목길이50자,현재테이블,bbs_list.html}}
	global $PHP_SELF,$num,$skin_folder_bbs,$level,$mem_id,$tb,$board_list,$B_CONF,$skin_folder,$tb,$BOARD,$TPL,
		$페이지출력,$pg,$board_short_comment,$board_pick_cut_day,
     $action,$search,$keyword,$게시판권한,$numb,$search_board,$search_page,$master_check,$LANG,$mini_homepi,$auction_product;

	global $Happy_Img_Name,$wys_url,$file_attach_folder,$file_attach_thumb_folder;
	global $calendar_view_tb, $mem_id,$admin_id,$admin_pw;
	global $happy_member, $happy_sns_array;

	if( $ex_template == ""  ) {
	return "템플릿파일을 선언하세요.";
	}


	#문자열을 정리해서 숫자만 뽑아주자
	$ex_limit = preg_replace('/\D/', '', $ex_limit);
	$ex_width = preg_replace('/\D/', '', $ex_width);
	$ex_cut = preg_replace('/\D/', '', $ex_cut);
	$ex_category  = preg_replace('/\n/', '', $ex_category);
	$ex_template  = preg_replace('/\n/', '', $ex_template);
	$ex_ajax_id_name  = preg_replace('/\n/', '', $ex_ajax_id_name);
	$ex_sub_call  = preg_replace('/\n/', '', $ex_sub_call); #웹페이지콜인지 ajax 콜인지
	$ex_get_id  = preg_replace('/\n/', '', $ex_get_id); #던져준값이먼지
	$ex_category  = urlencode($ex_category);
	$ex_garbage = preg_replace('/\D/', '', $ex_garbage); #누락

	#bbs_list_get('페이지당2개','가로1개','제목길이40자','나의일대일게시글','bbs_rows_one.html','ajax','bbs_list_page','here1','1')
	#AJAX초기처리
	if ($ex_paging == 'ajax' && $ex_sub_call == ''){ #ajax이면서 페이지콜
		if (!$ex_get_id){
			if ($_GET[num]){ #미니홈피상세화면에서 num/id 두개호출시 num을 우선으로해야함.
				$ex_get_id = $_GET[num];
			}
			else {
				$ex_get_id = $_GET[id];
			}
		}
		$main_new_out = <<<END

		<SPAN id='$ex_ajax_id_name'><br><center><font style=color:gray;font-size:11px>게시물을 읽어오고 있습니다.</font></SPAN>
		<script>
		if ( bbs_ajax_hidden_write  != 'ok')
		{
			document.write("<input type='hidden' name='bbs_ajax_hidden' id='bbs_ajax_hidden' value=''>");
			bbs_ajax_hidden_write	= 'ok';
		}
		document.getElementById('bbs_ajax_hidden').value = document.getElementById('bbs_ajax_hidden').value + "bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','0','$ex_ajax_id_name','$ex_get_id','$ex_garbage');";

		window.onload =  function () {
			bbs_ajax_start = document.getElementById('bbs_ajax_hidden').value;
			//eval("alert(\""+bbs_ajax_start+"\")");
			eval(bbs_ajax_start);
		}

		</script>


END;
	return $main_new_out;
	}

	$order_query = "number desc";

#검색일경우
if ($ex_action == 'search'){
	if ($ex_search_type == ''){
		$search_query = " and ( id like '%$ex_search_word%' or comment like '%$ex_search_word%' )";
	}
	else {
		$search_query = " and ($ex_search_type like '%$ex_search_word%' )";
	}
}


	#외부명으로 게시판 table을 구한다
	$sql = "select * from $calendar_view_tb where left(reg_date,10) = curdate() $search_query";
	$result = query($sql);
	$numb = mysql_num_rows($result);//총레코드수

#########################################################################

	#정렬부분
	if ($ex_garbage == "")
	{
		$ex_garbage = '0';
		$tmp_limit = '0';
	}
	else
	{
		$tmp_limit = $ex_garbage;
		$tmp_limit = $view_rows + $ex_garbage;
	}

if ($start == "")
{
	$start = $_GET[start];
}
if($start==0 || $start=="")
{
	$start=0;
}

//페이지 나누기
$numb = $numb - $startLimit; #추가

$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
$total_page = floor($total_page);

$view_rows = $start + $ex_garbage;
$auto_number  =  $numb - $start;


#외부 pg에 영향을 받지 않는 추출용
if ($ex_paging && $ex_paging != 'ajax'){
	$view_rows = '0';
	$auto_number = $ex_limit;
}


if ($num){
	$num_link = "&num=$num";
}
elseif ($_GET[id]) {
	$num_link = "&id=$_GET[id]";
}

$main_new = "";
$sql = "select * from $calendar_view_tb where left(reg_date,10) = curdate() $search_query  order by $order_query limit $view_rows,$ex_limit";
$result = query($sql);
$게시판갯수 = mysql_num_rows($result);//총레코드수

#echo $sql;

# 마이페이지 -> 게시판클릭시 상품정보 안나오는 부분 처리해야 함.
//print "$sql <br>$numb $ex_paging (110번째줄 삭제해야함)<br>";
##########################################################################
		$i = "1";
		$main_new_out = "<table width=100% cellpadding=0 cellspacing=0  border=0>";

		$TPL->define("board_그림_$ex_template", "$skin_folder/$ex_template");

		$Happy_Img_Name = array();


		if ( $_COOKIE["ad_id"] == "$admin_id" && $_COOKIE["ad_pass"] == md5($admin_pw) ) {
			$master_check = '1';
		}
		else {
			$master_check = '';
		}


		while  ($BOARD = happy_mysql_fetch_array($result))
		{
			if ($mem_id == $BOARD[id] || $master_check){
				$BOARD[delete_action] = <<<END
				<a href='#3' onclick=bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$prestart','$ex_ajax_id_name','$ex_get_id','$ex_garbage','delete','$BOARD[number]')><IMG SRC='/img/btn_t2_logoff.gif' BORDER=0 ALT='삭제' align=absmiddle></a>
END;
			}
			else {
				$BOARD[delete_action] = "";
			}

			#시간만 뽑자
			list($BOARD[reg_date_info1],$BOARD[reg_date_info2]) = explode(" ",$BOARD[reg_date]);
			#자동번호
			$BOARD[auto_number] = $auto_number;
			$BOARD[comment]= strip_tags($BOARD[comment]);

			# SNS LOGIN 처리 추가
			$comment_user			= happy_mysql_fetch_array(query("SELECT user_nick, sns_site FROM $happy_member WHERE user_id='$BOARD[id]'"));
			$BOARD['id']	= ( $comment_user['user_nick'] == '' ) ? $BOARD['id'] : $comment_user['user_nick'];

			$SNS_CHECK			= $happy_sns_array[$comment_user['sns_site']];
			if ( is_array($SNS_CHECK) === true )
			{
				if ( $SNS_CHECK['icon_use_calendar'] !== false )
				{
					$BOARD['id']	= "<img src='". $SNS_CHECK['icon_use_calendar']. "' border='0' align='absmiddle'>". $BOARD['id'];
				}
			}

			$main_new = &$TPL->fetch("board_그림_$ex_template");

			#TD를 정리하자
			if ($i % $ex_width == "1") {
				$main_new = "<tr><td valign=top align=center>" . $main_new . "</td>";
			}
			elseif
			($i % $ex_width == "0") {
				$main_new = "<td valign=top align=center>" . $main_new . "</td></tr>";
			}
			else {
				$main_new = "<td valign=top align=center>" . $main_new . "</td>";
			}
			$main_new_out .= $main_new;
			$auto_number --;
			$i ++;
		}
		$main_new_out .= "</table>";

		#무조건 ajax호출
		//include ("./calendar_view_page_ajax.php");

		############ 페이징처리 ############
		$Total			= $numb;
		$scale			= $ex_limit;
		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 2 : 6;

		$searchMethod	.= "";

		$getVals		= "$ex_limit,$ex_width,$ex_cut,$ex_category,$ex_template,$ex_paging,$ex_ajax_id_name,$ex_get_id,$ex_garbage,$ex_action,$ex_number,$ex_search_type,$ex_search_word";

		$page_print		= newPaging_ajax_bbs( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod, $getVals);
		############ 페이징처리 ############


		if (!$게시판갯수){
		$main_new_out = "<table border=0 width=100%><tr><td align=center height=40><font style='font-size:11px'>오늘 남긴 출석댓글이 없습니다.</td></tr></table>";

			#7일전의 글은 일단 지운다. 과부하 걸리니깡.
			$sql212 = "delete from $calendar_view_tb where left(reg_date ,10) <= left(DATE_SUB(curdate() , interval 7 day),10)";
			$result212 = query($sql212);

		}

		if ($ex_paging == 'ajax' && $ex_sub_call == ''){ #ajax이면서 페이지콜
			#$main_new_out = str_replace('"',"'",$main_new_out);
			$main_new_out = str_replace("\n",'',$main_new_out);
			$main_new_out = str_replace("\r",'',$main_new_out);
			$main_new_out = <<<END
			<SPAN id='$ex_ajax_id_name'>게시물본문</SPAN>
			<script>
			var tmp_div = "$main_new_out<center style='padding:5px'>$page_print</center>";
			eval('${ex_ajax_id_name}.innerHTML=tmp_div');
			</script>
END;
		}
		elseif ($ex_paging == 'ajax' && $ex_sub_call == 'sub_call'){ #ajax이면서 ajax콜
			#$main_new_out = str_replace('"',"'",$main_new_out);
			$main_new_out = str_replace("\n",'',$main_new_out);
			$main_new_out = str_replace("\r",'',$main_new_out);
			$main_new_out = "$main_new_out<center style='padding:5px'>$page_print</center>";
		}


		print "$main_new_out ";
		return;
		$페이지출력 = $page_print;
}

?>