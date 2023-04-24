<?php
include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");


//$_GET
//$_POST
//$_COOKIE



if ( !admin_secure("유료결제장부") ) {
		error("접속권한이 없습니다.");
		exit;
}




#[ YOON : 2009-09-07 ]
################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################





$ex_limit = '30';


if ($action == "search")
{
	$viewOnOff = "//";
	$search_query = " WHERE $search_type like '%$search_word%' AND pay_type like '%$pay_type_field%' AND in_check like '%$in_check%' ";

	if ( $send_date1 )
		$search_query .= " AND reg_date >= '$send_date1'";
	if ( $send_date2 )
		$search_query .= " AND reg_date <= '$send_date2'";
}


#토탈 등록갯수를 알려주자
$sql21 = "select count(*) from $point_jangboo  $search_query";
$result21 = query($sql21);
list($numb) = happy_mysql_fetch_array($result21);

	if ($pg == ""){
		$pg = $_GET[pg];
	}

	if($pg==0 || $pg==""){$pg=1;}

	//페이지 나누기
	$total_page = ( $numb - 1 ) / $ex_limit+1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = ($pg - 1) * $ex_limit;
	$co  =  $numb  -  $ex_limit  *  ( $pg - 1 );


	#결제종류
	//$select_width = "120";
	//$array_name = array('카드결제','핸드폰결제','포인트결제');
	//$array_value = array('카드결제','핸드폰결제','포인트결제');
	//$search_pay_info = make_selectbox2($array_name,$array_value,"결제방식선택",pay_type_field,$pay_type_field,$select_width);

	#입금확인종류
	$select_width		= "110";
	$array_name			= array('미입','입금','소모');
	$array_value		= array('0','1','2');
	$search_cost_info	= make_selectbox2($array_name,$array_value,'입금확인선택',in_check, $in_check ,$select_width);

	#검색옵션
	$select_width = '80';
	$array_name = array('아이디', '결제번호', '결제방식');
	$array_value = array('id','or_no','pay_type');
	$var_name = 'search_type';
	$select_name = 'search_type';
	$search_type_info = make_selectbox2($array_name,$array_value,$mod,$var_name,$_GET['search_type'],$select_width);

	$sql = "select * from $point_jangboo $search_query order by number desc limit $view_rows,$ex_limit ";
	$result = query($sql);
	$Count	= 0;
		$i = "1";
		$main_new_out = "";
		while  ($MONEY = happy_mysql_fetch_array($result))
		{
			$tableColor	= ( $Count++ % 2 == 0 )?"#ffffff":"#F8F8F8";

			#입금인지 아닌지 정리
			if ($MONEY[in_check] == "0"){
				$MONEY[in_check_info] = "<img src='img/btn/btn_20_no.gif' border=0  alt='미입'>";
				$text_info = "<font color=gray>포인트<font color=#0080FF>충전</font></font>";
			}
			elseif ($MONEY[in_check] == "1"){
				$MONEY[in_check_info] = "<img src='img/btn/btn_20_ok.gif' border=0  alt='입금'>";
				$text_info = "<font color=gray>포인트<font color=#0080FF>충전</font></font>";
			}
			elseif ($MONEY[in_check] == "2"){
				$MONEY[in_check_info] = "<img src='img/btn/btn_20_somo.gif' border=0  alt='소모'>";
				$text_info = "<font color=gray>포인트<font color=#66BF72>결제</font></font>";
			}
			else {
				$MONEY[in_check_info] = " <img src=../img/in_check_1.gif border=0 align=absmiddle >";
			}



			#결재금액에숫자를
			$tmpPoint = explode("|",$MONEY['point']);

			#$MONEY[point_comma] = number_format($MONEY[point]);
			$MONEY[point_comma] = number_format($tmpPoint[0]);
			$MONEY[money_comma] = number_format($tmpPoint[1]);


			#구매내역 정리끝

			#입금여부
			$select_width = "50";
			$array_name = array('미입','입금','소모');
			$array_value = array('0','1','2');
			$var_name = 'in_check';
			$select_name = $MONEY[in_check];
			$in_check_info = make_selectbox2($array_name,$array_value,$mod,$var_name,$select_name,$common_text);


			//결제실패사유 출력 - ranksa
			$pg_response_display	= "display:none";
			$pg_response_msg		= "";
			//승인코드 pg_db_update.php 참고
			if(
				$MONEY['pg_response_code'] != "" &&
				$MONEY['pg_response_code'] != "0000" &&
				$MONEY['pg_response_code'] != "00" &&
				!preg_match("/y|ok/",$MONEY['pg_response_code'])
			)
			{
				$pg_response_msg	= "<font color='red'>".$MONEY['pg_response_msg']."</font>";
				$pg_response_display= "";
			}


			$main_new_out .= <<<END
			<tr>
				<td style="height:35px">$MONEY[or_no]</td>
				<td><font class=1>$MONEY[point_comma]</font> $text_info</td>
				<td>$MONEY[id]</td>
				<td style='text-align:right;'>$MONEY[money_comma] <font>원</font></td>
				<td style='text-align:center;'>$MONEY[pay_type]</td>
				<td style='text-align:center;'>$MONEY[reg_date]</td>
				<td style='text-align:center;'>$MONEY[in_check_info]</td>
				<td style='text-align:center;'><a href="javascript:view_box('dt_$MONEY[number]')" title="현재 포인트 결제정보 수정" class='btn_small_dark3'>수정</a> <a href="javascript:bbsdel('./jangboo_point_update.php?pg=$pg&number=$MONEY[number]&action=del_reg');" title="현재 포인트 결제정보 삭제" class='btn_small_red2' style='margin-top:3px'>삭제</a></td>
			</tr>

			<tr style='$pg_response_display'>
				<td colspan='10' style='background:#f4f4f4; text-align:center; padding:10px 0 10px 0; '>$pg_response_msg </td>
			</tr>

			<!-- 수정시 출력되는 부분 -->
			<form method="post" action="jangboo_point_update.php?action=mod_reg" name=register onsubmit="return CheckReple(this)" style='margin:0px'>
			<input type=hidden name="number" value='$MONEY[number]'>
			<input type=hidden name="org_in_check" value='$MONEY[in_check]'>
			<input type=hidden name="org_point" value='$tmpPoint[0]'>
			<input type=hidden name="member_type" value='$MONEY[member_type]'>
				<tr id='dt_$MONEY[number]' style='display:none;' class='bg_green'>
					<td style="height:35px">$MONEY[or_no]</td>
					<td><font class=1>$MONEY[point_comma]</font> $text_info</td>
					<td><input type=text name=id value='$MONEY[id]' style='width:100px;'></td>
					<td style='text-align:right;'>$MONEY[money_comma] <font>원</font></td>
					<td style='text-align:center;'><input type=text name=pay_type value='$MONEY[pay_type]' style='width:100px;'></td>
					<td style='text-align:center;'><input type=text name=reg_date value='$MONEY[reg_date]' style='width:100px;'></td>
					<td style='text-align:center;'>$in_check_info</td>
					<td style='text-align:center; width:50px'><input type='submit' value='수정' alt='수정하기' title='수정하기' class='btn_small_dark'></td>
				</tr>
			</form>
			<tr id='dt_${MONEY[number]}_line' style='display:none;'></tr>


END;

		$i ++;

	}

	if ( isset($_REQUEST['action']) )
	{
		if ( $_REQUEST['action'] != '' )
		{
			$plus.= "&action=".$_REQUEST['action'];
		}
	}

	if ( isset($_REQUEST['pay_type_field']) )
	{
		if ( $_REQUEST['pay_type_field'] != '' )
		{
			$plus.= "&pay_type_field=".urlencode($_REQUEST['pay_type_field']);
		}
	}

	if ( isset($_REQUEST['search_type']) )
	{
		if ( $_REQUEST['search_type'] != '' )
		{
			$plus.= "&search_type=".$_REQUEST['search_type'];
		}
	}

	if ( isset($_REQUEST['search_word']) )
	{
		if ( $_REQUEST['search_word'] != '' )
		{
			$plus.= "&search_word=".$_REQUEST['search_word'];
		}
	}

	if ( isset($_REQUEST['in_check']) )
	{
		if ( $_REQUEST['in_check'] != '' )
		{
			$plus.= "&in_check=".$_REQUEST['in_check'];
			$is_search = 'y';
		}
	}

	if ( isset($_REQUEST['send_date1']) )
	{
		if ( $_REQUEST['send_date1'] != '' )
		{
			$plus.= "&send_date1=".$_REQUEST['send_date1'];
			$is_search = 'y';
		}
	}

	if ( isset($_REQUEST['send_date2']) )
	{
		if ( $_REQUEST['send_date2'] != '' )
		{
			$plus.= "&send_date2=".$_REQUEST['send_date2'];
			$is_search = 'y';
		}
	}

	include ("../page.php");


	if ($numb == "0"){
		$content = "<tr><td colspan=6 bgcolor=white height=50><center>포인트 충전내역이 없습니다</td></tr> ";
	}else {
		$내용 =  "$main_new_out ";
		$페이지출력 = $page_print;
	}





	#포인트장부 목록
	print <<<END

	<script language="javascript">
	<!--
		function bbsdel(strURL) {
			var msg = "장부내역을 삭제하시겠습니까?   ";
			if (confirm(msg)){
				window.location.href= strURL;
			}
		}


		function view_box(val) {
			box_reple = eval(val);
			box_reple_line = eval(val + "_line");

			if (box_reple.style.display == 'none'){
				box_reple.style.display = '';
				box_reple_line.style.display = '';

			}else{
				box_reple.style.display = 'none';
				box_reple_line.style.display = 'none';
			}

		}


		function CheckReple(theForm)
		{

				/*
				if (theForm.point.value.length < 1	)
				{
					 alert("포인트를 입력하세요. ");
					 theForm.point.focus();
					 return (false);
				 }
				 */


				if (theForm.id.value.length < 1	)
				{
					 alert("구매자를  입력하세요.");
					 theForm.id.focus();
					 return (false);
				}

				if (theForm.pay_type.value.length < 1	)
				{
					 alert("결제방식을  입력하세요.");
					 theForm.pay_type.focus();
					 return (false);
				  }
				if (theForm.reg_date.value.length < 1	)
				{
					 alert("결제일을  입력하세요.");
					 theForm.reg_date.focus();
					 return (false);
				  }

		}

	-->
	</script>



	<STYLE TYPE="text/css">
		/* 포인트장부관리 기간선택폼 */
		#google_stats_date1,#google_stats_date2{width:135px;}
		#google_stats_date1 div,#google_stats_date2 div{float:left;}
		#google_stats_date1 div input,#google_stats_date2 div input{font:10pt arial;}
		#google_stats_date1 .google_date_input1, #google_stats_date2 .google_date_input1{height:24px; background:transparent url('img/bg_date_input01a.gif') no-repeat 0px 0px; padding:2px 0px 0px 5px;}
		#google_stats_date1 .google_date_input1 input, #google_stats_date2 .google_date_input1 input{width:70px; height:18px; border:0px solid}
		#google_stats_date1 .google_date_input2, #google_stats_date2 .google_date_input2{width:40px;height:24px;}
		#google_stats_date1 .google_date_input3, #google_stats_date2 .google_date_input3{width:10px; height:24px; font-family:맑은 고딕,돋움; padding:6px 5px 0 4px;}


		#box_style .input_style_adm input[type=text] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:28px; line-height:27px; margin:2px 0; }
		#box_style .input_style_adm input[type=password] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:28px; line-height:27px; margin:2px 0; }
		#box_style .input_style_adm input[type=file] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:30px; line-height:29px; margin:2px 0; }
		#box_style .input_style_adm select { padding:5px; border:1px solid #bdbdc0; height:30px; line-height:24px; font-family:맑은 고딕;}
		#box_style .input_style_adm textarea { border:1px solid #bdbdc0; background:#f3f3f3; padding:5px; height:200px; }
		#box_style .input_style_adm input[type=checkbox]
		#box_style .input_style_adm input[type=radio] { vertical-align:middle; margin:-4px 0 0 1px; border:none; cursor:pointer;  }
		#box_style .input_style_config input[type=radio] { vertical-align:middle; margin:0px 0 0 10px; border:none; cursor:pointer;  }
	</STYLE>

	<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop1:plugins_time.js' id='gToday:datetime:agenda.js:gfPop1:plugins_time.js' src='../js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>
	<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop2:plugins_time.js' id='gToday:datetime:agenda.js:gfPop2:plugins_time.js' src='../js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>

	<div class="main_title">
		$now_location_subtitle
	</div>

	<div id="box_style" stlye="margin-bottom:10px;" align="center">
		<div class="box_1"></div>
		<div class="box_2"></div>
		<div class="box_3"></div>
		<div class="box_4"></div>
		<form name='point_search' action='jangboo_point.php' method='get' style='margin:0px'>
			<input type='hidden' name='action' value='search'>
			<table border="0" cellspacing="0" cellpadding="0" id=admin_search_frm >
			<tr>
				<td style="text-align:right; padding:0;">
					<div class="input_style_adm">
						<input type='text' name='send_date1' id='send_date1' value='$send_date1' readonly  class='' style='width:135px; vertical-align:middle; border-right:none;' onclick='if(self.gfPop1)gfPop1.fPopCalendar(document.point_search.send_date1); text_period(1); return false; '><a href='javascript:void(0)' onclick='if(self.gfPop1)gfPop1.fPopCalendar(document.point_search.send_date1); text_period(1); return false; '><img class="PopcalTrigger" align="absmiddle" src="img/calbtn.gif" border="0" alt="" style="vertical-align:middle"></a>
					</div>
				</td>
				<td >
					~
				</td>
				<td style="padding:0;">
					<div class="input_style_adm" >
						<input type='text' name='send_date2' id='send_date2' value='$send_date2' readonly style="width:135px; vertical-align:middle; border-right:none;" onclick='if(self.gfPop2)gfPop2.fPopCalendar(document.point_search.send_date2); text_period(2); return false;'><a href='javascript:void(0)' onclick='if(self.gfPop2)gfPop2.fPopCalendar(document.point_search.send_date2); text_period(2); return false;'><img class="PopcalTrigger" align="absmiddle" src="img/calbtn.gif" border="0" alt="" style="vertical-align:middle"></a>
					</div>
					<!-- 달력 레이어  -->
				</td>
				<td class="input_style_adm">
					<span id='search_frm_onoff'>
					$search_cost_info
					$search_type_info
					</span>
				</td>
				<td style="padding:0;" class="input_style_adm"><input type="text" name="search_word" value="$_REQUEST[search_word]" id='search_word' style="width:300px; margin-right:5px;"><input type='submit' value='검색' id='search_btn' class="btn_small_dark"></td>
			</tr>
			</table>
		</form>
	</div>

	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td style="font-size:12px; padding:10px 0px;" align="right">
				<!--<a href="happy_config_view.php?number=19" class="btn_small_blue"><b>포인트지급 설정</b>바로가기</a>-->
				<a href="happy_config_view.php?number=48" class="btn_small_green"><b>출석게시판 일일지급포인트 설정</b>바로가기</a>
			</td>
		</tr>
	</table>


	<script language="JavaScript">
	<!--
		function text_period(num) {
			var  send_date1 = document.getElementById('send_date1').style;
			var  send_date2 = document.getElementById('send_date2').style;

			if(num == "1") {
				send_date1.backgroundImage = "url('./img/txt_search_blank.gif')";
				send_date1.backgroundRepeat = "no-repeat";
				send_date1.backgroundPosition = "3px center";
			}else if(num == "2") {
				send_date2.backgroundImage = "url('./img/txt_search_blank.gif')";
				send_date2.backgroundRepeat = "no-repeat";
				send_date2.backgroundPosition = "3px center";
			}else{
				send_date1.backgroundImage = "url('./img/txt_search_start.gif')";
				send_date2.backgroundImage = "url('./img/txt_search_end.gif')";
				send_date1.backgroundRepeat = "no-repeat";
				send_date2.backgroundRepeat = "no-repeat";
				send_date1.backgroundPosition = "3px center";
				send_date2.backgroundPosition = "3px center";
			}
		}
		//검색 후 함수 주석처리하기:viewOnOff
		${viewOnOff}text_period();

	//-->
	</script>


<div id="list_style">
	<table cellspacing='0' cellpadding='0' class='bg_style table_line' style='table-layout:fixed'>
	<tr>
		<th>결제번호</th>
		<th>결제내역</th>
		<th>결제인</th>
		<th>결제금액</th>
		<th style='width:130px;'>결제방식</th>
		<th style='width:150px;'>결제일</th>
		<th style='width:70px;'>입금확인</th>
		<th style='width:50px;'>관리자툴</th>
	</tr>
	$내용
	</table>
</div>
<div align="center" style="padding:20px 0 20px 0;">$페이지출력</div>



END;




################################################
#하단부분 HTML 소스코드
include ("tpl_inc/bottom.php");
################################################