<?
	$t_start = array_sum(explode(' ', microtime()));

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");


	if ( !admin_secure("직종설정") ) {
			error("접속권한이 없습니다.");
			exit;
	}


	//관리자메뉴 [ YOON :2009-10-07 ]
	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################

	$mode				= ( $_GET['mode'] != "" ) ? $_GET['mode'] : $_POST['mode'];
	$number				= ( $_GET['number'] != "" ) ? $_GET['number'] : $_POST['number'];

	if ( $mode == "del_reg" )
	{
		if ( $number == "" )
		{
			error("문의내역 고유번호가 없습니다.");
			exit;
		}

		//댓글 삭제
		$Sql				= "DELETE FROM $happy_inquiry_comment WHERE links_number = '$number' ";
		query($Sql);

		//문의내역 삭제
		$Sql				= "DELETE FROM $happy_inquiry WHERE number = '$number' ";
		query($Sql);

		gomsg("문의내역이 삭제 되었습니다.","happy_inquiry_list.php?pg=$_GET[pg]");
		exit;
	}

	$search_type		= $_GET['search_type'];
	$search_keyword		= $_GET['search_keyword'];
	$send_date1			= $_GET['send_date1'];
	$send_date2			= $_GET['send_date2'];
	$stats					= $_GET['stats'];

	$WHERE				= "";
	if ( $search_type != "" && $search_keyword != "" )
	{
		$search_keyword2	= preg_replace('/\D/','',$_GET['search_keyword']);

		if ( $_GET['search_type'] == "user_phone" )
		{
			$WHERE				.= " AND ( user_phone like '%$search_keyword%' OR user_phone like '%$search_keyword2%' ";
			$WHERE				.= " OR user_hphone like '%$search_keyword%' OR user_hphone like '%$search_keyword2%' ) ";

			$WHERE2				.= " AND ( A.user_phone like '%$search_keyword%' OR A.user_phone like '%$search_keyword2%' ";
			$WHERE2				.= " OR A.user_hphone like '%$search_keyword%' OR A.user_hphone like '%$search_keyword2%' ) ";
		}
		else
		{
			$WHERE				.= " AND ( $search_type like '%$search_keyword%' )";
			$WHERE2				.= " AND ( A.$search_type like '%$search_keyword%' )";
		}
	}

	if ( $send_date1 != "" )
	{
		$WHERE				.= " AND reg_date >= '$send_date1'";
		$WHERE2				.= " AND A.reg_date >= '$send_date1'";
	}

	if ( $send_date2 != "" )
	{
		$WHERE				.= " AND reg_date <= '$send_date2'";
		$WHERE2				.= " AND A.reg_date <= '$send_date2'";
	}

	if ( $stats != "" )
	{
		$WHERE				.= " AND stats = '$stats'";
		$WHERE2				.= " AND A.stats = '$stats' ";
	}


	#토탈 등록갯수를 알려주자
	$Sql				= "SELECT COUNT(*) FROM $happy_inquiry WHERE 1=1 $WHERE";
	$Result				= query($Sql);
	list($numb)			= happy_mysql_fetch_array($Result);
	$listNum			= $numb;

	//페이지 나누기
	$ex_limit			= '15';
	$pg					= ($pg == "") ? $_GET['pg'] : $pg;
	$pg					= ($pg==0 || $pg=="") ? $pg=1 : $pg;
	$total_page			= ( $numb - 1 ) / $ex_limit+1; //총페이지수
	$total_page			= floor($total_page);
	$view_rows			= ($pg - 1) * $ex_limit;
	$co					= $numb - $ex_limit * ( $pg - 1 );

	$Sql				= "
							SELECT
									A.*,
									B.guin_name,
									B.guin_phone,
									B.guin_email
							FROM
									$happy_inquiry AS A
							LEFT JOIN
									$happy_inquiry_links AS B
							ON
									A.links_number = B.number
							WHERE
									1=1
									$WHERE2
							ORDER BY
									number desc
							LIMIT
									$view_rows,$ex_limit
	";
	$Result				= query($Sql);

	//echo nl2br($Sql);

	$main_new_out		= "";
	while ( $Data = happy_mysql_fetch_array($Result) )
	{
		$tableColor			= ( $Count++ % 2 == 0 )?"#ffffff":$rows_color;

		$Sender				= happy_member_information($Data['send_id']);
		$Receiver			= happy_member_information($Data['receive_id']);

		$stats_text			= $happy_inquiry_stats_array[$Data['stats']];
		$stats_icon			= "<img src='../img/happy_inquiry_stats_icon_$Data[stats].gif' alt=' $stats_text' border='0' align='absmiddle'>";

		$main_new_out		.= <<<END

		<tr onMouseOut="this.style.backgroundColor=''">
			<td class='b_border_td' style="text-align:center; height:35px">$Data[number]</td>
			<td class='b_border_td' style="text-align:center;">$Data[user_name] ($Data[send_id])</td>
			<td class='b_border_td' style="text-align:center;">$Data[user_phone]</td>
			<td class='b_border_td' style="text-align:left;">$Data[links_title]</td>
			<td class='b_border_td' style="text-align:center;">$Data[receive_id]</td>
			<td class='b_border_td' style="text-align:center;">$Data[reg_date]</td>
			<td class='b_border_td' style="text-align:center;">$stats_icon</td>
			<td class='b_border_td' style="text-align:center;">
				<a href="happy_inquiry_view.php?number=$Data[number]" class='btn_small_dark'>보기</a> <a href="javascript:bbsdel('./happy_inquiry_list.php?pg=$pg&number=$Data[number]&mode=del_reg');" class='btn_small_red'>삭제</a>
			</td>
		</tr>
END;

	}

	$plus	.= "&stats=$_GET[stats]";
	$plus	.= "&search_type=$_GET[search_type]";
	$plus	.= "&send_date1=$_GET[send_date1]";
	$plus	.= "&send_date2=$_GET[send_date2]";
	$plus	.= "&search_keyword=".urlencode($_GET['search_keyword']);

	include ("../page.php");


	if ($numb == "0"){
		$main_new_out = "<tr><td colspan=17 bgcolor=white height=50><center>문의내역이 없습니다</td></tr> ";
	}else {
		$페이지출력 = $page_print;
	}

	$내용 = " $main_new_out ";

	//검색부분 출력
	$search_field_title	= Array("채용정보","접수자명","접수자연락처","보낸사람ID","받는사람ID");
	$search_field_value	= Array("links_title","user_name","user_phone","send_id","receive_id");

	$검색필드선택		= make_selectbox2($search_field_title,$search_field_value,"",'search_type',$_GET['search_type'],'150');
	$처리상태검색		= make_selectbox2($happy_inquiry_stats_array,array_keys($happy_inquiry_stats_array),"-- 처리상태 --",'stats',$_GET['stats'],'120');

	print <<<END

	<script language="javascript" src="../inc/lib.js"></script>
	<script language="javascript" src="../js/bubble-tooltip.js"></script>
	<link rel="stylesheet" href="../css/bubble-tooltip.css" type="text/css">

	<script type="text/javascript" src="../js/ajax_popup/ap.js"></script>
	<link href="../js/ajax_popup/ap.css" rel="stylesheet" type="text/css" />

	<script language="javascript">
	<!--
		function bbsdel(strURL) {
			var msg = "삭제하시겠습니까?";
			if (confirm(msg)){
				window.location.href= strURL;

			}
		}
		-->
	</script>

	<STYLE TYPE="text/css">
		/* 문의하기 검색 기간선택폼 */
		#google_stats_date1,#google_stats_date2{width:135px;}
		#google_stats_date1 div,#google_stats_date2 div{float:left;}
		#google_stats_date1 div input,#google_stats_date2 div input{font:10pt arial;}
		#google_stats_date1 .google_date_input1, #google_stats_date2 .google_date_input1{height:24px; background:transparent url('img/bg_date_input01a.gif') no-repeat 0px 0px; padding:2px 0px 0px 5px;}
		#google_stats_date1 .google_date_input1 input, #google_stats_date2 .google_date_input1 input{width:70px; height:18px; border:0px solid}
		#google_stats_date1 .google_date_input2, #google_stats_date2 .google_date_input2{width:40px;height:24px;}
		#google_stats_date1 .google_date_input3, #google_stats_date2 .google_date_input3{width:10px; height:24px; font-family:맑은 고딕,돋움; padding:6px 5px 0 4px;}
	</STYLE>

	<STYLE TYPE="text/css">
		/* 문의하기 검색 기간선택폼 */
		#google_stats_date1,#google_stats_date2{width:135px;}
		#google_stats_date1 div,#google_stats_date2 div{float:left;}
		#google_stats_date1 div input,#google_stats_date2 div input{font:10pt arial;}
		#google_stats_date1 .google_date_input1, #google_stats_date2 .google_date_input1{height:24px; background:transparent url('img/bg_date_input01a.gif') no-repeat 0px 0px; padding:2px 0px 0px 5px;}
		#google_stats_date1 .google_date_input1 input, #google_stats_date2 .google_date_input1 input{width:70px; height:18px; border:0px solid}
		#google_stats_date1 .google_date_input2, #google_stats_date2 .google_date_input2{width:40px;height:24px;}
		#google_stats_date1 .google_date_input3, #google_stats_date2 .google_date_input3{width:10px; height:24px; font-family:맑은 고딕,돋움; padding:6px 5px 0 4px;}
	</STYLE>



	<p class="main_title">$now_location_subtitle</p>

	<!-- 문의내역 검색부분 -->
	<form name="search_form" method="GET" style="margin:0px; padding:0px;">
	<input type="hidden" name="mode" value="$_GET[mode]" style="margin:0px; padding:0px;">
	<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:5px;">
	<tr>
		<td align="left">
			<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					<table cellpadding="0" cellspacing="0">
					<tr>
						<td width="135" valign="top">
							<div id=google_stats_date1>
								<div class=google_date_input1><input type='text' name='send_date1' id='send_date1' value='$send_date1' readonly  class='input_noline'></div>
								<div class=google_date_input2><a href='javascript:void(0)' onclick='if(self.gfPop1)gfPop1.fPopCalendar(document.search_form.send_date1); text_period(1); return false; '><img class="PopcalTrigger" align="absmiddle" src="img/google_stats/bg_date_input01b.gif" border="0" alt=""></a></div>
								<div class=google_date_input3>~</div>
							</div>

							<!-- 달력 레이어  -->
							<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop1:plugins_time.js' id='gToday:datetime:agenda.js:gfPop1:plugins_time.js' src='../js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>
						</td>
						<td width="120" valign="top" >
							<div id=google_stats_date2>
								<div class=google_date_input1><input type='text' name='send_date2' id='send_date2' value='$send_date2' readonly class='input_noline'></div>
								<div class=google_date_input2><a href='javascript:void(0)' onclick='if(self.gfPop2)gfPop2.fPopCalendar(document.search_form.send_date2); text_period(2); return false;'><img class="PopcalTrigger" align="absmiddle" src="img/google_stats/bg_date_input01b.gif" border="0" alt=""></a></div>
							</div>

							<!-- 달력 레이어  -->
							<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop2:plugins_time.js' id='gToday:datetime:agenda.js:gfPop2:plugins_time.js' src='../js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>
						</td>
					</tr>
					</table>
				</td>
				<td align='right'>
					<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="input_style_adm">$처리상태검색</td>
						<td  class="input_style_adm" style="padding-left:5px;">$검색필드선택</td>
						<td style="padding-left:5px;"  class="input_style_adm"><input type="text" name="search_keyword" value="$_GET[search_keyword]" style=''></td>
						<td style="padding-left:5px;"><input type="submit" value="검색" class='btn_small_dark' style="height:30px"></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</form>

	<div id="list_style" >
		<table cellspacing="0" cellpadding="0" border="0" class='bg_style b_border'>
		<colspan>
		<col style='width:5%;'></col>
		<col style='width:12%;'></col>
		<col style='width:10%;'></col>
		<col></col>
		<col style='width:10%;'></col>
		<col style='width:15%;'></col>
		<col style='width:8%;'></col>
		<col style='width:10%;'></col>
		</colspan>
		<tr>
			<th>번호</th>
			<th>접수자명(ID)</th>
			<th>접수자 연락처</th>
			<th>채용정보</th>
			<th>받는사람ID</th>
			<th>접수일</th>
			<th>처리상태</th>
			<th class="last">관리자툴</th>
		</tr>

		$내용

		</table>
	</div>

	<div align="center" style="padding:20px 0 20px 0;">$페이지출력</div>



	<script language="JavaScript">
	<!--
		function text_period(num) {
			var  send_date1 = document.getElementById('send_date1').style;
			var  send_date2 = document.getElementById('send_date2').style;

			if(num == "1") {
				send_date1.backgroundImage = "url('./img/txt_search_blank.gif')";
				send_date1.backgroundRepeat = "no-repeat";
			}else if(num == "2") {
				send_date2.backgroundImage = "url('./img/txt_search_blank.gif')";
				send_date2.backgroundRepeat = "no-repeat";
			}else{
				send_date1.backgroundImage = "url('./img/txt_search_start.gif')";
				send_date2.backgroundImage = "url('./img/txt_search_end.gif')";
				send_date1.backgroundRepeat = "no-repeat";
				send_date2.backgroundRepeat = "no-repeat";
			}
		}
		//검색 후 함수 주석처리하기:viewOnOff
		${viewOnOff}text_period();

	//-->
	</script>

END;


	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}


	# YOON : 2009-10-29 ###
	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################
?>