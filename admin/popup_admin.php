<?

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");

	if ( !admin_secure("팝업관리") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	include ("tpl_inc/top_new.php");

	$mode			= $_GET["mode"];
	$search_order	= $_GET["search_order"];
	$keyword		= $_GET["keyword"];
	$nowDate		= date("Y-m-d H:i:s");


###################### 팝업 리스트 시작 #######################
	if ( $mode == "" || $mode == "list" )
	{


		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 15;

		$Sql	= "select count(*) from $happy_popup WHERE 1=1 $WHERE ";
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


		$Sql	= "SELECT * FROM $happy_popup ORDER BY number desc LIMIT $start,$scale ";
		$Record	= query($Sql);


		echo "
			<!--// 팝업관리 [START] //-------------------------------------------------------------------------------->

			<script>
			function review_del(no)
			{
			if ( confirm('정말 삭제하시겠습니까?') )
			{
			window.location.href = '?mode=delete&start=$start&search_order=$search_order&keyword=$keyword&number='+no;
			}
			}
			</script>


<div class='main_title'>$now_location_subtitle <span class='font_st_11_tahoma'>( 현재시간 : $nowDate )</span> <a href='happy_config_view.php?number=5' class='btn_small_stand'>팝업환경설정 바로가기</a>
	<span class='small_btn'>
		<img src='img/ico_txt_reg_popup.gif' border='0' align='absmiddle'> 총 <font color='blue' style='font-size:10pt; font-weight:600; font-family:verdana;'>$Total</font> 개 <a href='http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=49' target='_blank' class='btn_small_yellow'>도움말</a>
	</span>
</div>

<div class='help_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<span class='help'>도움말</span>
	<p>
	출력태그로 원하는 페이지에 원하는 팝업을 출력 할 수 있습니다.<br>
	껍데기파일에 팝업추출태그 ( {{팝업 메인페이지,#f1f1f1,랜덤}} ) 사용시 팝업이 출력됩니다.
	</p>
</div>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
	<tr>
		<th>번호</th>
		<th>제목</th>
		<th style='width:160px;'>팝업설정기간</th>
		<th style='width:90px;'>팝업위치</th>
		<th style='width:90px;'>팝업크기</th>
		<th style='width:120px;'>출력여부</th>
		<th style='width:110px;'>관리툴</th>
	</tr>

		";

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Data["title"]		= kstrcut($Data["title"], 30, "...");
			$Data["category"]	= ( $Data["category"] == "" )?"<font color='gray'>없음</font>":$Data["category"];

			if ( $Data["startDate"] < $nowDate && $Data["endDate"] > $nowDate && $Data["display"] == "Y" )
			{
				$Data["display"]	= "<font color='blue'>출력중</font>";
			}
			else
				$Data["display"]	= "미출력";

			$Data["startDate"]	= substr($Data["startDate"],0,10);
			$Data["endDate"]	= substr($Data["endDate"],0,10);
			$Data["openType"]	= ( $Data["openType"] == "L" )?"레이어":"새창";

			echo "

				<tr>
					<td style='text-align:center;'>$listNo</td>
					<td>[$Data[category]] $Data[title]</td>
					<td style='text-align:center;'>$Data[startDate] ~ $Data[endDate]</td>
					<td style='text-align:center;'>$Data[topSize] X $Data[leftSize]</td>
					<td style='text-align:center;'>$Data[widthSize] X $Data[heightSize]</td>
					<td style='text-align:center;'>$Data[display] ($Data[openType])</td>
					<td style='text-align:center;'><a href='?mode=modify&number=$Data[number]&start=$start&search_order=$search_order&keyword=$keyword' class='btn_small_dark3'>수정</a> <a href='#1' onClick=\"review_del('$Data[number]')\" class='btn_small_red2' style='margin-top:3px'>삭제</a></td>
				</tr>
			";
			$listNo--;

		}

		echo "
		</table>
	</div>
	<div align='center' style='padding:20px 0 20px 0;'><a onClick=\"window.location.href='?mode=add'\" class='btn_big'>팝업등록하기</a></div>
		";
		echo "";



	}	############## 리스트 끝 #################


######################## 팝업 수정 시작 ###########################
	else if ( $mode == "modify" || $mode == "add" )
	{
		$number	= $_GET["number"];
		$start	= $_GET["start"];
		if ( $mode != "add" )
		{
			$Sql	= "SELECT * FROM $happy_popup WHERE number='$number'";
			$Data	= happy_mysql_fetch_array(query($Sql));
		}

		$category_info	= "<select name='category'>";
		for ( $i=0,$max=sizeof($popupMenuNames) ; $i<$max ; $i++ )
		{
			if ( $popupMenuNames[$i] != '' )
			{
				$selected		= ( $Data["category"] == $popupMenuNames[$i] )?" selected":"";
				$category_info	.= "<option value='$popupMenuNames[$i]' $selected>$popupMenuNames[$i]</option>";
			}
		}
		$category_info	.= "</select>";

		$linkType_info	= "<select name='linkType'>";
		for ( $i=0,$max=sizeof($popupLinkTypeName) ; $i<$max ; $i++ )
		{
			$selected		= ( $Data["linkType"] == $popupLinkTypeName[$i] )?" selected":"";
			$linkType_info	.= "<option value=\"$popupLinkTypeName[$i]\" $selected>$popupLinkTypeName[$i]</option>";
		}
		$linkType_info	.= "</select>";


		$display1		= ( $Data["display"] != "N" )?" checked ":"";
		$display2		= ( $Data["display"] == "N" )?" checked ":"";

		$openType1		= ( $Data["openType"] != "P" )?" checked ":"";
		$openType2		= ( $Data["openType"] == "P" )?" checked ":"";

		$startDate_date	= ($Data['startDate']=='')?date('Y-m-d'):substr($Data['startDate'],0,10);
		$startDate_h	= ($Data['startDate']=='')?date('H'):substr($Data['startDate'],11,2);
		$hour_info1		= dateSelectBox( "startDate_h", 0, 23, $startDate_h, "시", "시간선택", "" );

		$endDate_date	= ($Data['endDate']=='')?date('Y-m-d'):substr($Data['endDate'],0,10);
		$endDate_h		= ($Data['endDate']=='')?date('H'):substr($Data['endDate'],11,2);
		$hour_info2		= dateSelectBox( "endDate_h", 0, 23, $endDate_h, "시", "시간선택", "" );

		$submit_button	= ( $mode == "add" )?"등록":"수정";


		//$Data[content]		= addslashes(str_replace("\n","",str_replace("\r","",$Data[content])));
		$Data[topSize]		= ( $Data[topSize] == "" )?"180":$Data[topSize];
		$Data[leftSize]		= ( $Data[leftSize] == "" )?"200":$Data[leftSize];
		$Data[widthSize]	= ( $Data[widthSize] == "" )?"300":$Data[widthSize];
		$Data[heightSize]	= ( $Data[heightSize] == "" )?"400":$Data[heightSize];

		//위지윅에디터CSS
		$editor_css = happy_wys_css("ckeditor","../");
		$editor_js = happy_wys_js("ckeditor","../");

		$editor_menu_content = happy_wys("ckeditor","가로100%","세로300","content","{Data.content}","../","happycgi_normal");




		echo "
			<!--// 팝업관리 수정하기 [START] //-------------------------------------------------------------------------------->

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

$editor_css
$editor_js

			<div class='main_title'>$now_location_subtitle <span class='font_st_12_tahoma'>( 현재시간 : $nowDate )</span>
			<label><a href='http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=49' target='_blank'><img src=\"img/btn_help.gif\" border=\"0\"></a></label>
			</div>

<iframe width=200 height=189 name=\"gToday:normal:agenda.js\" id=\"gToday:normal:agenda.js\" src=\"./js/calendar_google/ipopeng.htm\" scrolling=\"no\" frameborder=\"0\" style=\"visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;\"></iframe>

			<form method='post' name='popup_regist' action='popup_admin.php?mode=modify_reg' onSubmit='return sendit(this)'>
			<input type='hidden' name='number' value='$number'>
			<input type='hidden' name='mode_chk' value='$mode'>
			<input type='hidden' name='start' value='$start'>
			<input type='hidden' name='search_order' value='$search_order'>
			<input type='hidden' name='keyword' value='$keyword'>

			<div id='box_style'>
				<table cellspacing='1' cellpadding='0' class='bg_style'>
				<tr>
					<th>카테고리</th>
					<td class='input_style_adm'>
						$category_info<br><br>
						<div class='help_style'>
							<div class='box_1'></div>
							<div class='box_2'></div>
							<div class='box_3'></div>
							<div class='box_4'></div>
							<span class='help'>도움말</span>
							<p>※ 같은그룹명의 팝업 랜덤추출시 사용<br>
							미리 설정된 팝업그룹명을 선택하세요.<br>
							템플릿(HTML) 파일에서 팝업출력 태그명령어 사용시 설정된 그룹별로 출력합니다.<br>
							템플릿(HTML) 파일에서 팝업출력 태그명령어는 {{팝업 팝업그룹명,본문내용바탕색}}<br>
							(예) {{팝업 메인페이지,white}} </p>
						</div>
					</td>
				</tr>
				<tr>
					<th>시작시간</th>
					<td class='input_style_adm'>
						<input type='text' name='startDate_date' value='$startDate_date' size=10  onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\"onClick=\" if(self.gfPop)gfPop.fPopCalendar(document.popup_regist.startDate_date);return false;\" readonly>
						$hour_info1
						<SPAN id=iCalendar1 name='iCalendar1'>
						<img src='img/btn_calender.gif' width='25' height='21' onClick=\" if(self.gfPop)gfPop.fPopCalendar(document.popup_regist.startDate_date);return false;\" align=absmiddle style='cursor:pointer'>
						</SPAN>
					</td>
				</tr>
				<tr>
					<th>종료시간</th>
					<td class='input_style_adm'>
						<input type='text' name='endDate_date' value='$endDate_date' size=10  onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" onClick=\" if(self.gfPop)gfPop.fPopCalendar(document.popup_regist.endDate_date);return false;\" readonly>
						$hour_info2
						<SPAN id=iCalendar2 name='iCalendar2'>
						<img src='img/btn_calender.gif' width='25' height='21' onClick=\" if(self.gfPop)gfPop.fPopCalendar(document.popup_regist.endDate_date);return false;\" align=absmiddle style='cursor:pointer'>
						</SPAN>
					</td>
				</tr>
				<tr>
					<th>출력여부</th>
					<td>
						<input type='radio' name='display' value='Y' $display1 style='width:13px; height:13px; vertical-align:middle;'> 출력
						<input type='radio' name='display' value='N' $display2  style='width:13px; height:13px; vertical-align:middle;'> 안함
					</td>
				</tr>
				<tr>
					<th>출력형식</th>
					<td>
						<input type='radio' name='openType' value='L' $openType1  style='width:13px; height:13px; vertical-align:middle;'> 레이어형식
						<input type='radio' name='openType' value='P' $openType2  style='width:13px; height:13px; vertical-align:middle;'> 팝업형식
					</td>
				</tr>
				<tr>
					<th>팝업사이즈</th>
					<td>
						가로크기 <input type='text' name='widthSize' value='$Data[widthSize]' onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" size=4 style='text-align:right'> px <b>×</b>
						세로크기 <input type='text' name='heightSize' value='$Data[heightSize]' onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" size=4 style='text-align:right'> px
					</td>
				</tr>
				<tr>
					<th>팝업위치</th>
					<td>
						TOP <input type='text' name='topSize' value='$Data[topSize]' onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" size=4 style='text-align:right'> px <b>×</b> LEFT <input type='text' name='leftSize' value='$Data[leftSize]' onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" size=4 style='text-align:right'> px
					</td>
				</tr>
				<tr>
					<th>링크주소</th>
					<td class='input_style_adm'>
						<p class='short'>
							레이어팝업창일 경우 새창,현재창만 사용하세요.<br>
							부모창: 윈도우 팝업창일 경우에만 사용하세요.<br>
							상위,최상위프레임: 프레임셋으로 나누어진 경우에 사용합니다.<br>
						</p>
						<input type='text' name='linkUrl' value='$Data[linkUrl]' style='width:250px'> $linkType_info
					</td>
				</tr>
				<tr>
					<th>팝업창제목</th>
					<td>
						<input type='text' name='title' value='$Data[title]' style='width:99%'>
					</td>
				</tr>
				<tr>
					<th>팝업내용</th>
					<td>
						$editor_menu_content
					</td>
				</tr>
				</table>
			</div>

			<div align='center' style='padding:10px 0 20px 0;'>
				<input type='submit' value='등록하기' class='btn_big'> <input type='button' value='목록으로' onClick='history.back()' class='btn_big_gray'>
			</div>

			</form>

		";
	}	############# 팝업 수정 끝 #############



######################## 팝업 수정 DB입력 시작 ###########################
	else if ( $mode == "modify_reg" )
	{
		$number			= $_POST["number"];
		$start			= $_POST["start"];
		$search_order	= $_POST["search_order"];
		$keyword		= $_POST["keyword"];
		$mode_chk		= $_POST["mode_chk"];

		$category		= $_POST["category"];
		$display		= $_POST["display"];
		$openType		= $_POST["openType"];
		$startDate		= $_POST["startDate_date"]." ".$_POST["startDate_h"].":00:00";
		$endDate		= $_POST["endDate_date"]." ".$_POST["endDate_h"].":00:00";
		$title			= $_POST["title"];
		$content		= $_POST["content"];
		$topSize		= $_POST["topSize"];
		$leftSize		= $_POST["leftSize"];
		$widthSize		= $_POST["widthSize"];
		$heightSize		= $_POST["heightSize"];
		$linkUrl		= $_POST["linkUrl"];
		$linkType		= $_POST["linkType"];

		if ( $auto_addslashe )
		{
			$title			= addslashes($_POST["title"]);
			$linkUrl		= addslashes($_POST["linkUrl"]);
			$linkType		= addslashes($_POST["linkType"]);
		}


		$SetSql	= "
				category	= '$category',
				display		= '$display',
				openType	= '$openType',
				startDate	= '$startDate',
				endDate		= '$endDate',
				title		= '$title',
				content		= '$content',
				topSize		= '$topSize',
				leftSize	= '$leftSize',
				widthSize	= '$widthSize',
				heightSize	= '$heightSize',
				linkUrl		= '$linkUrl',
				linkType	= '$linkType'
		";

		if ( $mode_chk == "add" )
		{
			$msg	= "등록되었습니다.";
			$Sql	= "
						INSERT INTO
								$happy_popup
						SET
								$SetSql
								,regDate	= now()
			";
		}
		else
		{
			$msg	= "수정완료 되었습니다.";
			$Sql	= "
					UPDATE
							$happy_popup
					SET
							$SetSql
					WHERE
							number = '$number'
			";
		}
		query($Sql);

		gomsg($msg,"popup_admin.php?start=$start&search_order=$search_order&keyword=$keyword");

	}	############# 팝업 수정 DB입력 끝 #############



######################## 팝업 삭제 시작 ###########################
	else if ( $mode == "delete" )
	{
		$number	= $_GET["number"];
		$start	= $_GET["start"];

		$Sql	= "DELETE FROM $happy_popup WHERE number='$number' ";
		query($Sql);

		gomsg("삭제완료 되었습니다.","popup_admin.php?start=$start&search_order=$search_order&keyword=$keyword");

	}	############# 팝업 삭제 끝 #############




	include ("tpl_inc/bottom.php");
?>