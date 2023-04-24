<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");

	#관리자 접속 체크 루틴
	if ( !admin_secure("배너관리툴") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	#관리자 접속 체크 루틴

	include ("tpl_inc/top_new.php");

	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);
	$group_select	= $_GET['group_select'];



	#등록된 그룹명 뽑아오기
	$Sql		= "SELECT groupid FROM $happy_banner_tb GROUP BY groupid ";
	$Record		= query($Sql);
	$i			= 0;
	$groupBox	= "<select name='group_select' __onChange__ ><option value=''>- 그룹선택 -</option>";
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$GROUP[$i++]	= $Data['groupid'];
		$selected		= $Data['groupid'] == $group_select ? "selected" : "";
		$groupBox		.= "<option value='$Data[groupid]' $selected>$Data[groupid]</option>";
	}
	$groupBox	.= "</select>";






	if ( $type == "" )									# 배너 리스트출력 ################################################
	{
		#검색
		$search_type	= $_GET["search_type"];
		$search_word	= $_GET["search_word"];

		$WHERE		= "";
		if ( $search_word != "" )
		{
			$WHERE	.= " AND $search_type like '%${search_word}%' ";
		}

		if ( $search_type == "groupid")
		{
			$selected = "selected";
		}

		if ( $search_type == "title")
		{
			$selected2 = "selected";
		}

		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 15;

		$WHERE			.= $group_select == '' ? "" : " AND groupid='$group_select' ";

		$Sql	= "select count(*) from $happy_banner_tb WHERE 1=1 $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Count	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 6;

		$searchMethod	= "";
			#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
				$searchMethod	.= "&search_order=$search_order&keyword=$keyword&search_type=$search_type&search_word=".urlencode($search_word)."&group_select=$group_select";
			#검색값 입력완료

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################


		$Sql	= "SELECT * FROM $happy_banner_tb WHERE 1=1 $WHERE ORDER BY number desc LIMIT $start,$scale ";
		$Record	= query($Sql);

		$groupBox	= str_replace("__onChange__","onChange='this.form.submit()'",$groupBox);


		echo "

			<script>
			function review_del(no)
			{
				if ( confirm('정말 삭제하시겠습니까?') )
				{
					window.location.href = '?type=del&start=$start&search_order=$search_order&keyword=$keyword&search_type=$search_type&search_word=$search_word&number='+no;
				}
			}
			</script>

	<div class='main_title'>$now_location_subtitle
		<span class='small_btn'>
			<a href='#' onClick=\"window.open('http://cgimall.co.kr/happy_manual/board_detail.cgi?db=manual_job3&thread=45','popwin','top=21,left=0,width=880,height=620,scrollbars=1,toolbar=0,menubar=0,status=0,location=0,directories=0');\" class='btn_small_yellow'>도움말</a>
		</span>
	</div>

	<div style='background:#f9f9f9; border:1px solid #dfdfdf; padding:10px; margin-bottom:10px;' class='input_style_adm'>
		<form name='search_frm' action='banner_admin.php' style='margin:0;'>
			$groupBox
			<select name='search_type'>
			<option value='groupid' $selected>그룹명</option>
			<option value='title' $selected2>배너명</option>
			</select>
			<input type='text' name='search_word' value='$_GET[search_word]' class='input_type1' style='vertical-align:middle'>
			<input type='submit' value='검색하기' class='btn_small_dark' style='height:29px'>

		</form>
	</div>
	<div class='help_style'>
		<div class='box_1'></div>
		<div class='box_2'></div>
		<div class='box_3'></div>
		<div class='box_4'></div>
		<span class='help'>도움말</span>
		<p>그룹명을 클릭하시면 해당그룹의 통계를 보실수 있습니다<br>png의 경우 ie6를위한 배경색을 투명하게 해주는 자바스크립트로인해 한번호출시 2번 카운팅이 됩니다. 참조하세요.<br>플래시 배너의 경우 url 아이콘을 클릭해서 저장되는 url로 링크를 걸어주시면 클릭통계에 반영됩니다.</p>
	</div>

	<div id='list_style'>
		<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
		<tr>
			<th>번호</th>
			<th>그룹명</th>
			<th>배너제목</th>
			<th>노출수</th>
			<th>클릭수</th>
			<th>클릭율</th>
			<th>출력</th>
			<th>등록일</th>
			<th>마지막노출</th>
			<th>배너마감일</th>
			<th style='width:145px;'>관리툴</th>
		</tr>
		";

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$nowDate			= date("Y-m-d");
			$regdate			= substr($Data['regdate'],0,10);
			$editdate			= substr($Data['editdate'],0,10);
			$viewdate			= substr($Data['viewdate'],0,10);
			$linkdate			= substr($Data['linkdate'],0,10);
			$enddate			= substr($Data['enddate'],0,10);

			$regdate			= $nowDate == $regdate  ? substr($Data['regdate'],10,9)  : $regdate;
			$editdate			= $nowDate == $editdate ? substr($Data['editdate'],10,9) : $editdate;
			$viewdate			= $nowDate == $viewdate ? substr($Data['viewdate'],10,9) : $viewdate;
			$linkdate			= $nowDate == $linkdate ? substr($Data['linkdate'],10,9) : $linkdate;
			//$enddate			= $nowDate == $enddate  ? substr($Data['enddate'],10,9)  : $enddate;

			$Data['title']		= $Data['title'] == "" ? "등록된 제목이 없습니다.":$Data['title'];
			$Data['groupid']	= $Data['groupid'] == "" ? "[빈그룹]":$Data['groupid'];

			#png일경우 한번호출에 2번씩 카운팅 되므로 2로 나누어준다.
			#$Data['viewcount']	= strpos($Data['img'],"png") ? @($Data['viewcount'] / 2) : $Data['viewcount'];

			$percent			= $Data['mode']=='flash2'?"-":number_format( @($Data['linkcount']/$Data['viewcount'])*100 , 2).'%';
			$breakText			= " style='word-wrap:break-word;word-break:break-all' ";

			#플래시에서 사용할 배너링크
			$main_url = $main_url.$wys_url;
			$banner_url = "$main_url/banner_link.php?number=$Data[number]";

			if($Data['display'] == "Y")
			{
				$display = "Yes";
			}
			else
			{
				$display = "No";
			}

			// 배너 이미지 미리 보기
			switch ( $Data['mode'] )
			{
				case "image" :
					$preview_banner		= "<img src='" . $wys_url . "/" . $Data['img'] . "' alt='" . $Data['title'] . "' title='" . $Data['title'] . "'  width='80' style='border:1px solid #dedede;'>";
				break;
				default :
					$preview_banner		= '';
				break;
			}

			echo "
				<tr>
					<td style='text-align:center;'>$listNo</td>
					<td><a href='banner_admin_stats.php?groupID=$Data[groupid]' style=' color:#676565;'>$Data[groupid]</a></td>
					<td><div style='margin-bottom:5px;'>$preview_banner</div>$Data[title]</td>
					<td style='text-align:center;'>$Data[viewcount]</td>
					<td style='text-align:center;'>$Data[linkcount]</td>
					<td style='text-align:center;'>${percent}</td>
					<td style='text-align:center;'>$display</td>
					<td style='text-align:center;'>$regdate</td>
					<td style='text-align:center;'>$viewdate</td>
					<td style='text-align:center;'>$enddate</td>
					<td style='text-align:center;'>

					<a href='?type=add&number=$Data[number]&start=$start&search_order=$search_order&keyword=$keyword' class='btn_small_red' style='display:inline-block !important; width:41px;'>수정</a><a href='#delete' onClick=\"review_del('$Data[number]')\" class='btn_small_dark' style='display:inline-block !important; width:41px; margin-left:2px;'>삭제</a><a href='banner_admin_stats.php?bannerID=$Data[number]' class='btn_small_blue' style='display:inline-block !important; width:41px; margin-top:3px;'>통계</a><a href='#stat_reset' onClick=\"if ( confirm('통계 초기화를 하시면 복구가 불가능합니다.\\n초기화를 진행하시겠습니까?') ){ window.location.href = '?type=statsreset&number=$Data[number]';}\" class='btn_small_blue' style='display:inline-block !important; width:41px; margin-top:3px; margin-left:2px;'>초기화</a>
					</td>
				</tr>


			";
			$listNo--;

		}

		echo "
			</table>
		</div>
		<div align='center' style='position:relative; padding:10px 0 30px 0;'>
			$paging
			<div style='position:absolute; right:0; top:10px;'><a href='banner_admin_stats.php' class='btn_small_stand'>전체통계</a> <a href='?type=add' class='btn_small_blue'>배너추가하기</a></div>
		</div>
		<div align='center' style='padding:10px 0 30px 0;'><a href='banner_admin.php?type=add' class='btn_big'>등록하기</a></dic>

";


	}
	else if ( $type == "add" )							# 배너 작성하기 ##################################################
	{

		if ( $number != '' )		## 수정모드일때 ##
		{
			$Sql	= "SELECT * FROM $happy_banner_tb WHERE number='$number' ";
			$Data	= happy_mysql_fetch_array(query($Sql));
			switch ( $Data['mode'] )
			{
				case "html" :
						$mode3_chk	= 'checked';
						$content_display	= '';
						$image_display		= 'none';
						$link_display		= '';
						break;
				case "flash" :
						$mode2_chk	= 'checked';
						$content_display	= 'none';
						$image_display		= '';
						$link_display		= '';
						break;
				case "image" :
						$mode1_chk	= 'checked';
						$content_display	= 'none';
						$image_display		= '';
						$link_display		= '';
						if ( $Data['width'] == 0 && $Data['height'] == 0 )
							$preview_banner		= "<img src='../$Data[img]' style='border:1px solid #dedede;'>";
						else {
							$tmp_width		= $Data[width]/3;
							$tmp_height		= $Data[height]/3;
							$preview_banner		= "<img src='../$Data[img]' width='$tmp_width' height='$tmp_height' style='border:1px solid #dedede;'>";
						}
						break;
			}
			//$Data['content']	= addslashes(str_replace("\n","",str_replace("\r","",$Data['content'])));
			$Data['title']		= addslashes($Data['title']);
			$Data['groupid']	= addslashes($Data['groupid']);

			$button_title		= '수정';


			$startdate = $Data['startdate'];
			$enddate = $Data['enddate'];

			$display_y = "";
			$display_n = "";

			if ( $Data['display'] == 'Y' )
			{
				$display_y = " checked ";
			}
			else
			{
				$display_n = " checked ";
			}

		}
		else						## 새로작성할때 ##
		{
			$mode1_chk			= 'checked';
			$mode2_chk			= '';
			$mode3_chk			= '';
			$content_display	= 'none';
			$image_display		= '';
			$link_display		= '';
			$button_title		= '등록';
			$display_y = " checked ";
		}

		$groupBox	= str_replace("__onChange__","onChange='changeGroup()'",$groupBox);
		$groupBox	= str_replace("- 그룹선택 -","그룹명직접입력",$groupBox);
		$groupBox	.= "<script>document.banner_frm.group_select.value='$Data[groupid]';changeGroup();</script>";

		$wys_url	= eregi_replace("\/$","",$wys_url);

        //위지윅에디터CSS
        $editor_css = happy_wys_css("ckeditor","../");
        $editor_js = happy_wys_js("ckeditor","../");

        $editor_menu_content = happy_wys("ckeditor","가로100%","세로300","content","{Data.content}","../","happycgi_normal");

		#폼출력
		echo "
			<script>
				function mode_change( no )
				{
					if ( no == 'image' )
					{
						display1	= 'none';
						display2	= '';
						display3	= '';
					}
					else if ( no == 'flash' )
					{
						display1	= 'none';
						display2	= '';
						display3	= '';
					}
					else if ( no == 'html' )
					{
						display1	= '';
						display2	= 'none';
						display3	= '';
					}
					document.getElementById('content_display').style.display	= display1;
					document.getElementById('image1_display').style.display		= display2;
					document.getElementById('link_display').style.display		= display3;
					document.getElementById('image2_display').style.display		= display2;
					document.getElementById('image3_display').style.display		= display2;
				}

				function changeGroup()
				{
					var nowValue	= document.banner_frm.group_select.options[document.banner_frm.group_select.selectedIndex].value;

					if ( nowValue == '' )
					{
						document.banner_frm.groupid.readOnly	= false;
						document.banner_frm.groupid.value		= '';
						document.banner_frm.groupid.focus();
					}
					else
					{
						document.banner_frm.groupid.value		= nowValue;
						document.banner_frm.groupid.readOnly	= true;
					}
				}

			</script>


<!-- 달력에 필요한프레임 -->
<iframe width=188 height=166 name=\"gToday:datetime:agenda.js:gfPop:plugins_time.js\" id=\"gToday:datetime:agenda.js:gfPop:plugins_time.js\" src=\"../js/time_calrendar/ipopeng.htm\" scrolling=\"no\" frameborder=\"0\" style=\"visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;\">
</iframe>

<p class='main_title'>배너관리툴 배너$button_title</p>

$editor_css
$editor_js

<form name='banner_frm' action='?type=reg' method='post' enctype='multipart/form-data' style='margin:0;'>
<input type='hidden' name='number' value='$number'>

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
	<tr>
		<th>그룹명</th>
		<td class='input_style_adm'>
			<p class='short'>배너의 그룹을 선택 하거나 입력하세요</p>
			<input type='text' name='groupid' value='$Data[groupid]' size='20'> $groupBox
		</td>
	</tr>
	<tr>
		<th>배너제목</th>
		<td>
			<p class='short'>배너의 제목을 입력하세요.</p>
			<input type='text' name='title' size=55 value='$Data[title]'>
		</td>
	</tr>
	<tr>
		<th>배너형식</th>
		<td>
			<p class='short'>배너의 형식을 선택하세요.</p>
			<input type='radio' name='mode' value='image' $mode1_chk onClick=\"mode_change('image');\"> 이미지배너 <input type='radio' name='mode' value='flash' $mode2_chk onClick=\"mode_change('flash');\"> 플레쉬배너 <input type='radio' name='mode' value='html' $mode3_chk onClick=\"mode_change('html');\"> 직접입력
		</td>
	</tr>
	<tr style='display:$content_display' id='content_display'>
		<th>HTML편집</th>
		<td>
			<p class='short'>배너의 내용을 입력하세요.</p>
			$editor_menu_content
		</td>
	</tr>
	<tr style='display:$image_display' id='image1_display'>
		<th>배너업로드</th>
		<td>
			<p class='short'>업로드할 배너를 선택하세요.</p>
			<input type='file' name='img' style='width:500px;'><div style='padding-top:10px;'>$preview_banner</div>
		</td>
	</tr>
	<tr style='display:$link_display' id='link_display'>
		<th>링크</th>
		<td class='input_style_adm'>
			<p class='short'>배너 클릭시 이동할 주소를 입력 하세요.</p>
			<input type='text' name='link' value='$Data[link]' size=40>
			<select name='linkTarget' id='linkTarget'>
				<option value=''>현재창에서</option>
				<option value='window'>새창으로</option>
			</select>
			<a href='#1' onClick=\"alert('플래시배너에서 사용할 링크가 복사되었습니다.\\nCtrl+ V를 이용해서 붙여넣기 하세요.\\n$banner_url ');window.clipboardData.setData('text','$banner_url');\" class='btn_small_gray'>플래시배너용 링크보기</a>
			<script>
				document.banner_frm.linkTarget.value = '$Data[linkTarget]';
			</script>
			<br><br>
			<div class='help_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>
				<span class='help'>도움말</span>
				<p style='margin-bottom:10px;'>플래시배너일 경우는 해당하지 않습니다. 플래시배너는 플래시배너파일 제작시 링크정보를 넣어야 합니다. <br>또한 플래시배너를 적용하실 때는 배너코드형식으로 사용하여야 합니다. <br> 그리고, 플래시배너를 먼저 등록을 하신다음 [수정] 페이지에서 버튼을 클릭하여 링크주소 보고<br> 해당 배너플래시파일에 넣어주시면 됩니다.</p>
				<p>
				<img src='img/flash_info_img.gif' border='0'>
				</p>
			</div>
		</td>
	</tr>
	<tr style='display:$image_display' id='image2_display'>
		<th>가로크기</th>
		<td class='font_12'><input type='text' name='width' onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" value='$Data[width]' style='width:100px;'> px</td>
	</tr>
	<tr style='display:$image_display' id='image3_display'>
		<th>세로크기</th>
		<td class='font_12'><input type='text' name='height' onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" value='$Data[height]' style='width:100px;'> px</td>
	</tr>
	<tr id='image3_display'>
		<th>시작시간</th>
		<td><input type='text' name='startdate' value='$startdate' style='width:130px;'> <a href=\"javascript:void(0)\" onclick=\"if(self.gfPop)gfPop.fPopCalendar(document.banner_frm.startdate);return false;\" ><img name=\"popcal\" src=\"../calendar/calbtn.gif\" alt=\"\" ></a></td>
	</tr>
	<tr id='image3_display'>
		<th>마감시간</th>
		<td><input type='text' name='enddate' value='$enddate' style='width:130px;'> <a href=\"javascript:void(0)\" onclick=\"if(self.gfPop)gfPop.fPopCalendar(document.banner_frm.enddate);return false;\" ><img name=\"popcal\" src=\"../calendar/calbtn.gif\" alt=\"\"></a></td>
	</tr>
	<tr id='image3_display'>
		<th>출력여부</th>
		<td>
			<input type='radio' name='display' id='display_y' value='Y' $display_y > <label for='display_y'>출력함</label>&nbsp;&nbsp;&nbsp;
			<input type='radio' name='display' id='display_n' value='N' $display_n > <label for='display_n'>출력안함</label>
		</td>
	</tr>
	</table>
</div>
<div align='center' style='padding:20px 0 20px 0;'><input type='submit' value='설정을 저장합니다.' class='btn_big'></div>

</form>

		";
	}
	else if ( $type == "reg" )
	{
		#넘어온 변수값 정리
		$groupid	= $_POST['groupid'];
		$title		= $_POST['title'];
		$mode		= $_POST['mode'];
		$content	= $_POST['content'];
		$link		= $_POST['link'];
		$linkTarget	= $_POST['linkTarget'];
		$width		= $_POST['width'];
		$height		= $_POST['height'];
		$startdate	= $_POST['startdate'];
		$enddate	= $_POST['enddate'];
		$display	= $_POST['display'];
		$number		= preg_replace('/\D/', '',$_POST['number']);


		#첨부된 파일
		$img_name		= 'img';
		$upImageName	= $_FILES[$img_name]["name"];
		$upImageTemp	= $_FILES[$img_name]["tmp_name"];
		$now_time		= happy_mktime();

		$rand_number	= rand(1,999999);
		$rand_number2	= rand(1,999999);
		$temp_name		= explode(".",$upImageName);
		$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

		if ( $ext=="html" || $ext=="htm" || $ext=="php" || $ext=="cgi" || $ext=="inc" || $ext=="php3" || $ext=="pl" )
		{
			error("등록이 불가능한 확장자 입니다.");
			exit;
		}

		$pngClass		= $ext == "png" ? "png":"";

		$imgFileName	= $pngClass.md5("${rand_number2}${now_time}${rand_number}");
		$img_url_re		= "$banner_folder_admin/".$imgFileName;
		$img			= "$banner_folder/".$imgFileName;

		if ($upImageTemp != "")
		{
			if ( copy($upImageTemp,"$img_url_re") )
			{
				$fileSql	= " img = '$img', ";
				@unlink($upImageTemp);
			}
		}


		if ( $banner_auto_addslashe == '' )
		{
			$content	= addslashes($_POST["content"]);
			$title		= addslashes($_POST["title"]);
			$groupid	= addslashes($_POST["groupid"]);
		}


		#쿼리문 생성
		$SetSql		= "
						groupid		= '$groupid',
						title		= '$title',
						mode		= '$mode',
						content		= '$content',
						$fileSql
						link		= '$link',
						linkTarget	= '$linkTarget',
						width		= '$width',
						height		= '$height',
						editdate	= now(),
						startdate	= '$startdate',
						enddate		= '$enddate',
						display		= '$display'
		";

		if ( $number == '' )
		{
			$Sql	= "
						INSERT INTO
								$happy_banner_tb
						SET
								$SetSql ,
								viewcount	= 0,
								linkcount	= 0,
								regdate		= now()
			";
			$okMsg	= "등록되었습니다.";
		}
		else
		{
			$Sql	= "UPDATE $happy_banner_tb SET $SetSql WHERE number = '$number'";
			$okMsg	= "수정되었습니다.";

			#그룹명이 바뀔지 모르니 로그에 그룹명 변경
			$Sql2	= "UPDATE $happy_banner_log_tb SET groupID='$groupid' WHERE bannerID='$number'";
			query($Sql2);
		}

		#echo nl2br($Sql);exit;
		query($Sql);

		gomsg($okMsg, "?");


	}
	else if ( $type == "del" )							#배너 삭제하기 ##################################################
	{
		$number	= preg_replace("/\D/","",$number);

		$Sql	= "DELETE FROM $happy_banner_tb WHERE number='$number' ";
		query($Sql);

		$Sql	= "DELETE FROM $happy_banner_log_tb WHERE bannerID='$number' ";
		query($Sql);
		gomsg("삭제되었습니다.","?");
	}
	else if ( $type == "statsreset" )
	{
		$number	= preg_replace("/\D/","",$number);
		$Sql	= "UPDATE $happy_banner_tb SET viewcount=0, linkcount=0 WHERE number='$number' ";
		query($Sql);

		$Sql	= "DELETE FROM $happy_banner_log_tb WHERE bannerID='$number' ";
		query($Sql);

		gomsg("초기화되었습니다.","?");
	}



	#하단 공통 HTML
	echo "";


	include ("tpl_inc/bottom.php");


?>