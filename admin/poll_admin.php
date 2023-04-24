<?

include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/function.php");
include ("../inc/lib.php");

	if ( !admin_secure("투표관리") ) {
			error("접속권한이 없습니다.");
			exit;
	}

include ("tpl_inc/top_new.php");

$mode			= $_GET["mode"];
	$search_order	= $_GET["search_order"];
	$keyword		= $_GET["keyword"];
	$nowDate		= date("Y-m-d H:i:s");
	$nowDateNotime		= date("Y-m-d");


###################### 투표 리스트 시작 #######################
	if ( $mode == "" || $mode == "list" )
	{


		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 15;

		$Sql	= "select count(*) from $upso2_poll_1 WHERE 1=1 $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Count	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 6;

		$searchMethod	= "";
			#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
				$searchMethod	.= "&search_order=$search_order&keyword=$keyword";
			#검색값 입력완료

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################


		$Sql	= "SELECT * FROM $upso2_poll_1 ORDER BY number desc LIMIT $start,$scale ";
		$Record	= query($Sql);


		echo "
			<!--// 투표관리 [START] //-------------------------------------------------------------------------------->

			<script>
			function review_del(no)
			{
				if ( confirm('정말 삭제하시겠습니까?') )
				{
				window.location.href = '?mode=delete&start=$start&search_order=$search_order&keyword=$keyword&number='+no;
				}
			}
			</script>

<script language='JavaScript' src='../js/flash.js' type='text/javascript'></script>

<div class='main_title'>$now_location_subtitle <font color='blue'>( 총 $Total 개 )</font>
	<span class='small_btn'>
		<a href='http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=55' target='_blank' class='btn_small_yellow'>도움말</a>
	</span>
</div>

<div class='help_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<span class='help'>도움말</span>
	<p>
		메인페이지 상단 설문조사 링크가 출력됩니다.<br>
		출력태그로 특정투표만 또는 모든투표를 출력할수 있습니다.<br>
		참고) 동일 아이디로 같은 투표에 두번 투표하지 못합니다.<br>
	</p>
</div>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
	<tr>
		<th style='width:40px;'>번호</th>
		<th>제목</th>
		<th style='width:180px;'>투표설정기간</th>
		<th style='width:70px;'>참여</th>
		<th style='width:90px;'>진행상황</th>
		<th style='width:110px;'>관리툴</th>
	</tr>


		";

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$tableColor	= ( $Count++ % 2 == 0 )?"white":"#F8F8F8";
			$Data["real_title"]		= kstrcut($Data["real_title"], 55, "...");

			if ( $Data["endDate"] > $nowDate && $Data["progress"] == "Y" )
			{
				$Data["progress"]	= "<font color='#0080FF'>진행중</font>";
			}
			else if ( $Data["endDate"] < $nowDate || $Data["progress"] == "N" )
			{
				$Data["progress"]	= "<font color=gray>마감</font>";
			}

			$Data["startDate"]	= substr($Data["startDate"],0,10);
			$Data["endDate"]	= substr($Data["endDate"],0,10);

			echo "
				<tr>
					<td style='text-align:center; height:35px'>$listNo</td>
					<td>$Data[real_title]</td>
					<td style='text-align:center;'>$Data[startDate] ~ $Data[endDate]</td>
					<td style='text-align:center;'>$Data[hit]</td>
					<td style='text-align:center;'>$Data[progress]</td>
					<td style='text-align:center;'><a href='?mode=modify&number=$Data[number]&start=$start&search_order=$search_order&keyword=$keyword' class='btn_small_dark3'>수정</a> <a href='#1' onClick=\"review_del('$Data[number]')\" class='btn_small_red2' style='margin-top:3px'>삭제</a></td>
				</tr>
			";
			$listNo--;

		}

		echo "
			</table>
		</div>
		<div align='center' style='padding:20px 0 20px 0;'><a onClick=\"window.location.href='?mode=add'\" class='btn_big'>신규투표등록</a></div>



		";
		echo "";



	}	############## 리스트 끝 #################


######################## 투표 수정 시작 ###########################
	else if ( $mode == "modify" || $mode == "add" )
	{
		$number	= $_GET["number"];
		$start	= $_GET["start"];
		if ( $mode != "add" )
		{
			$Sql	= "SELECT * FROM $upso2_poll_1 WHERE number='$number'";
			$Data	= happy_mysql_fetch_array(query($Sql));

			$Sql1	= "SELECT title,vote FROM $upso2_poll_2 WHERE poll_1_number='$number' AND sort='1' ";
			$Data1	= happy_mysql_fetch_array(query($Sql1));
			$Sql2	= "SELECT title,vote FROM $upso2_poll_2 WHERE poll_1_number='$number' AND sort='2' ";
			$Data2	= happy_mysql_fetch_array(query($Sql2));
			$Sql3	= "SELECT title,vote FROM $upso2_poll_2 WHERE poll_1_number='$number' AND sort='3' ";
			$Data3	= happy_mysql_fetch_array(query($Sql3));
			$Sql4	= "SELECT title,vote FROM $upso2_poll_2 WHERE poll_1_number='$number' AND sort='4' ";
			$Data4	= happy_mysql_fetch_array(query($Sql4));
			$Sql5	= "SELECT title,vote FROM $upso2_poll_2 WHERE poll_1_number='$number' AND sort='5' ";
			$Data5	= happy_mysql_fetch_array(query($Sql5));
			$Sql6	= "SELECT title,vote FROM $upso2_poll_2 WHERE poll_1_number='$number' AND sort='6' ";
			$Data6	= happy_mysql_fetch_array(query($Sql6));
		}

		$now_time = date('Y-m-d H:i:s');
		$startDate_date	= ($Data['startDate']=='')?date('Y-m-d'):substr($Data['startDate'],0,10);
		$startDate_h	= ($Data['startDate']=='')?date('H'):substr($Data['startDate'],11,2);
		$hour_info1		= dateSelectBox( "startDate_h", 0, 23, $startDate_h, "시", "시간선택", "" );

		$endDate_date	= ($Data['endDate']=='')?date('Y-m-d'):substr($Data['endDate'],0,10);
		$endDate_h		= ($Data['endDate']=='')?date('H'):substr($Data['endDate'],11,2);
		$hour_info2		= dateSelectBox( "endDate_h", 0, 23, $endDate_h, "시", "시간선택", "" );

		if ( $Data["progress"] == "Y" ) {
			$progress1 = "checked";
		}

		if ( $Data["progress"] == "N" || $Data["endDate"] < $now_time )
		{
			$progress2 = "checked";
		}
		$real_title		= $Data["real_title"];

		$title[0]		= $Data1["title"];
		$title[1]		= $Data2["title"];
		$title[2]		= $Data3["title"];
		$title[3]		= $Data4["title"];
		$title[4]		= $Data5["title"];
		$title[5]		= $Data6["title"];

		$vote[0]		= $Data1["vote"];
		$vote[1]		= $Data2["vote"];
		$vote[2]		= $Data3["vote"];
		$vote[3]		= $Data4["vote"];
		$vote[4]		= $Data5["vote"];
		$vote[5]		= $Data6["vote"];

		$width			= $Data["width"];
		$height			= $Data["height"];
		$w_top			= $Data["w_top"];
		$w_left			= $Data["w_left"];
		$graph_width	= $Data["graph_width"];
		$keyword		= $Data["keyword"];

		$submit_button	= ( $mode == "add" )?"등록":"수정";


		echo "
			<!--// 투표관리 수정하기 [START] //-------------------------------------------------------------------------------->

			<script>
			function sendit( frm )
			{
			if ( frm.name.value == '' )
			{
			alert('이름을 입력해주세요.');
			frm.name.focus();
			return false;
			}

			}
			</script>

			<script src='../js/calendar.js'></script>

			<script language=javascript>
				createLayer('Calendar');
			</script>

			<script language='JavaScript' src='../js/flash.js' type='text/javascript'></script>

			<div class='main_title'>투표 $submit_button</div>

<iframe width=200 height=189 name=\"gToday:normal:agenda.js\" id=\"gToday:normal:agenda.js\" src=\"./js/calendar_google/ipopeng.htm\" scrolling=\"no\" frameborder=\"0\" style=\"visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;\"></iframe>


<form method='post' name='popup_regist' action='poll_admin.php?mode=modify_reg' onSubmit='return sendit(this)' style='margin:0;'>
<input type='hidden' name='number' value='$number'>
<input type='hidden' name='mode_chk' value='$mode'>
<input type='hidden' name='start' value='$start'>
<input type='hidden' name='search_order' value='$search_order'>

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>

	<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
	<tr>
		<th>시작시간</th>
		<td class='input_style_adm'>
			<p class='short'>투표가 출력되기 시작할 시간을 설정 합니다.</p>
			<input type='text' name='startDate_date' value='$startDate_date' size=10  onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" onClick=\" if(self.gfPop)gfPop.fPopCalendar(document.popup_regist.startDate_date);return false;\" readonly>
			$hour_info1
			<SPAN id=iCalendar1 name='iCalendar1'>
			<img src='img/btn_calender.gif' onClick=\" if(self.gfPop)gfPop.fPopCalendar(document.popup_regist.startDate_date);return false;\" style='vertical-align:middle; cursor:pointer'>
			</SPAN>
		</td>
	</tr>
	<tr>
		<th>종료시간</th>
		<td class='input_style_adm'>
			<p class='short'>투표가 종료될 시간을 설정 합니다.</p>
			<input type='text' name='endDate_date' value='$endDate_date' size=10  onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" onClick=\" if(self.gfPop)gfPop.fPopCalendar(document.popup_regist.endDate_date);return false;\" readonly>
			$hour_info2
			<SPAN id=iCalendar2 name='iCalendar2'>
			<img src='img/btn_calender.gif' width='25' height='21' onClick=\" if(self.gfPop)gfPop.fPopCalendar(document.popup_regist.endDate_date);return false;\" align=absmiddle style='cursor:pointer'>
			</SPAN>
		</td>
	</tr>
	<tr>
		<th>진행여부</th>
		<td>
			<p class='short'>투표를 진행할지 하지 않을지 설정할 수 있습니다.</p>
			<input type='radio' name='progress' value='Y' $progress1 > 진행중 <input type='radio' name='progress' value='N' $progress2 > 마감
		</td>
	</tr>
	<tr>
		<th>투표제목</th>
		<td>
			<p class='short'>투표의 제목을 입력 합니다.</p>
			<input type=text name=real_title value='$real_title' style='width:100%;'>
		</td>
	</tr>
	<tr>
		<th>항목1</th>
		<td>
			<p class='short'>투표에서 선택할 항목의 제목의 설정 합니다.</p>
			<input type=text size=25 name=title[] value='$title[0]' style='width:90%;'> <input type=text size=3 name=vote[] value=$vote[0]> 표 <input type=hidden name=sort[] value='1'>
		</td>
	</tr>
	<tr>
		<th>항목2</th>
		<td>
			<p class='short'>투표에서 선택할 항목의 제목의 설정 합니다.</p>
			<input type=text size=25 name=title[] value='$title[1]' style='width:90%;'> <input type=text size=3 name=vote[] value=$vote[1]> 표 <input type=hidden name=sort[] value='2'>
		</td>
	</tr>
	<tr>
		<th>항목3</th>
		<td>
			<p class='short'>투표에서 선택할 항목의 제목의 설정 합니다.</p>
			<input type=text size=25 name=title[] value='$title[2]' style='width:90%;'> <input type=text size=3 name=vote[] value=$vote[2]> 표 <input type=hidden name=sort[] value='3'>
		</td>
	</tr>
	<tr>
		<th>항목4</th>
		<td>
			<p class='short'>투표에서 선택할 항목의 제목의 설정 합니다.</p>
			<input type=text size=25 name=title[] value='$title[3]' style='width:90%;'> <input type=text size=3 name=vote[] value=$vote[3]> 표 <input type=hidden name=sort[] value='4'>
		</td>
	</tr>
	<tr>
		<th>항목5</th>
		<td>
			<p class='short'>투표에서 선택할 항목의 제목의 설정 합니다.</p>
			<input type=text size=25 name=title[] value='$title[4]' style='width:90%;'> <input type=text size=3 name=vote[] value=$vote[4]> 표 <input type=hidden name=sort[] value='5'>
		</td>
	</tr>
	<tr>
		<th>항목6</th>
		<td>
			<p class='short'>투표에서 선택할 항목의 제목의 설정 합니다.</p>
			<input type=text size=25 name=title[] value='$title[5]' style='width:90%;'> <input type=text size=3 name=vote[] value=$vote[5]> 표 <input type=hidden name=sort[] value='6'>
		</td>
	</tr>
	<tr>
		<th>팝업크기</th>
		<td>
			<p class='short'>투표결과를 보여줄 팝업창의 사이즈를 정할 수 있습니다.</p>
			가로 : <input type=text size=3 name=width value='$width'> px <b>×</b> 세로 : <input type=text size=3 name=height value='$height'> px
		</td>
	</tr>
	<tr>
		<th>팝업위치</th>
		<td>
			<p class='short'>투표결과를 보여줄 팝업창의 위치를 정할 수 있습니다.</p>
			위쪽여백 : <input type=text size=3 name=w_top value='$w_top'> px <b>×</b> 왼쪽여백 : <input type=text size=3 name=w_left value='$w_left'> px
		</td>
	</tr>
	<tr>
		<th>결과 그래프길이</th>
		<td>
			<p class='short'>투표결과창에서 보여줄 그래프의 최대길이를 정할 수 있습니다.</p>
			<input type=text size=3 name=graph_width value='$graph_width'> px
		</td>
	</tr>
	<tr>
		<th>키워드</th>
		<td>
			<p class='short'>투표를 추출하실때 키워드별로 추출할 경우 사용할 키워드를 입력 합니다.</p>
			<input type=text size='25' maxlength='25' name='keyword' value='$keyword'>
		</td>
	</tr>
	</table>
</div>

<div align='center' style='padding:20px 0 20px 0;'><input type='submit' value='설정을 저장합니다.' class='btn_big'> <input type='button' onClick='history.back()' value='목록보기' class='btn_big_gray'></div>
</form>

		";
	}	############# 투표 수정 끝 #############



######################## 투표 수정 DB입력 시작 ###########################
	else if ( $mode == "modify_reg" )
	{
		$number			= $_POST["number"];
		$start			= $_POST["start"];
		$search_order	= $_POST["search_order"];
		$keyword		= $_POST["keyword"];
		$mode_chk		= $_POST["mode_chk"];

		$startDate		= $_POST["startDate_date"]." ".$_POST["startDate_h"].":00:00";
		$endDate		= $_POST["endDate_date"]." ".$_POST["endDate_h"].":00:00";
		$progress 		= $_POST["progress"];

		$real_title		= $_POST["real_title"];

		$title[]		= $_POST["title[]"];
		$vote[]			= $_POST["vote[]"];
		$sort[]			= $_POST["sort[]"];

		$width			= $_POST["width"];
		$height			= $_POST["height"];
		$w_top			= $_POST["w_top"];
		$w_left			= $_POST["w_left"];
		$graph_width	= $_POST["graph_width"];
		$keyword		= $_POST["keyword"];


		if ( $auto_addslashe )
		{
			$title			= addslashes($_POST["title"]);
		}


		$SetSql	= "
				startDate	= '$startDate',
				endDate		= '$endDate',
				progress	= '$progress',
				real_title	= '$real_title',
				width		= '$width',
				height		= '$height',
				w_top		= '$w_top',
				w_left		= '$w_left',
				graph_width	= '$graph_width',
				keyword		= '$keyword'

		";

		for ($i=0,$j=1; $j<count($vote); $i++, $j++)
		{
			$hit += $vote[$i];
		}

		if ( $mode_chk == "add" )
		{
			$msg	= "등록되었습니다.";
			$Sql	= "
						INSERT INTO
								$upso2_poll_1
						SET
								$SetSql
								,hit		= '$hit'
								,reg_date	= now()
			";

			query($Sql);

			$Sql	= "select number from $upso2_poll_1 WHERE real_title='$real_title'  ";
			$Temp	= happy_mysql_fetch_array(query($Sql));

			for ($i=0,$j=1; $j<count($title) ; $i++,$j++)
			{

				$Sql2	= "
							INSERT INTO
									$upso2_poll_2
							SET
								poll_1_number = '$Temp[number]'
								,title	= '$title[$i]'
								,vote	= '$vote[$i]'
								,sort	= '$sort[$i]'
				";
				query($Sql2);
			}
		}
		else
		{
			$msg	= "수정완료 되었습니다.";
			$Sql	= "
					UPDATE
							$upso2_poll_1
					SET
							$SetSql
							,hit		= '$hit'
					WHERE
							number = '$number'
			";

			query($Sql);

			for ($i=0,$j=1; $j<count($title) ; $i++,$j++)
			{

				$Sql2	= "
							UPDATE
									$upso2_poll_2
							SET
								title	= '$title[$i]'
								,vote	= '$vote[$i]'
							WHERE
								poll_1_number = '$number'
							AND
								sort	= '$sort[$i]'
				";
				query($Sql2);
			}
		}


		gomsg($msg,"poll_admin.php?start=$start&search_order=$search_order&keyword=$keyword");

	}	############# 투표 수정 DB입력 끝 #############



######################## 투표 삭제 시작 ###########################
	else if ( $mode == "delete" )
	{
		$number	= $_GET["number"];
		$start	= $_GET["start"];

		$Sql	= "DELETE FROM $upso2_poll_1 WHERE number='$number' ";
		query($Sql);
		$Sql2	= "DELETE FROM $upso2_poll_2 WHERE poll_1_number='$number' ";
		query($Sql2);

		gomsg("삭제완료 되었습니다.","poll_admin.php?start=$start&search_order=$search_order&keyword=$keyword");

	}	############# 투표 삭제 끝 #############





	include ("tpl_inc/bottom.php");
?>