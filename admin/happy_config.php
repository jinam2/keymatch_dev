<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");


	#관리자 접속 체크 루틴
	if ( !admin_secure("슈퍼관리자") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	#관리자 접속 체크 루틴
/*
CREATE TABLE happy_config_group (
 number int not null auto_increment primary key,
 group_title varchar(100) not null default '',
 group_header text not null default '',
 group_footer text not null default '',
 group_etc1 varchar(250) not null default '',
 group_etc2 varchar(250) not null default '',
 group_etc3 varchar(250) not null default '',
 group_etc4 varchar(250) not null default '',
 group_etc5 varchar(250) not null default '',
 group_display tinyint not null default 0,
 group_sort int not null default 0,
 menu_group varchar(30) not null default '',
 reg_date datetime not null default '0000-00-00 00:00:00',
 mod_date datetime not null default '0000-00-00 00:00:00',
 key(group_display),
 key(group_sort),
 key(menu_group)
);

CREATE TABLE happy_config_part (
 number int not null auto_increment primary key,
 group_number int not null,
 part_title varchar(100) not null default '',
 part_sub_title varchar(250) not null default '',
 part_content text not null default '',
 part_etc1 varchar(250) not null default '',
 part_etc2 varchar(250) not null default '',
 part_etc3 varchar(250) not null default '',
 part_sort int not null default 0,
 reg_date datetime not null default '0000-00-00 00:00:00',
 mod_date datetime not null default '0000-00-00 00:00:00',
 key(group_number),
 key(part_sort)
);

CREATE TABLE happy_config_field (
 number int not null auto_increment primary key,
 group_number int not null,
 part_number int not null,
 field_name varchar(100) not null default '',
 field_type varchar(30) not null default '',
 field_value varchar(250) not null default '',
 field_option varchar(250) not null default '',
 field_out_type varchar(30) not null default '',
 field_memo text not null default '',
 reg_date datetime not null default '0000-00-00 00:00:00',
 mod_date datetime not null default '0000-00-00 00:00:00',
 key(group_number),
 key(part_number)
);

CREATE TABLE happy_config (
 number int not null auto_increment primary key,
 conf_name varchar(100) not null default '',
 conf_value text not null default '',
 conf_out_type varchar(30) not null default '',
 reg_date datetime not null default '0000-00-00 00:00:00',
 mod_date datetime not null default '0000-00-00 00:00:00'
);
*/





	//관리자메뉴 메인버튼 이미지 [ YOON : 2009-08-19 ]
	//.gif 파일확장자 앞에 ov 를 붙이면 오버용 이미지
	$admin_main_menu_01="<img src='img/main_menu_01.gif' border=0>";
	$admin_main_menu_02="<img src='img/main_menu_02.gif' border=0>";
	$admin_main_menu_03="<img src='img/main_menu_03.gif' border=0>";
	$admin_main_menu_04="<img src='img/main_menu_04.gif' border=0>";
	$admin_main_menu_05="<img src='img/main_menu_05.gif' border=0>";
	$admin_main_menu_06="<img src='img/main_menu_06.gif' border=0>";
	$admin_main_menu_07="<img src='img/main_menu_07.gif' border=0>";
	$admin_main_menu_08="<img src='img/main_menu_08.gif' border=0>";


	include ("tpl_inc/top_new.php");



	echo<<<END





END;








echo<<<END

END;

############################################################################################################################















	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);
	$group_select	= $_GET['group_select'];



	if ( $type == "" )									# 설정 리스트출력 ################################################
	{


		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 30;

		$WHERE			.= $group_select == '' ? "" : " AND groupid='$group_select' ";

		$Sql	= "select count(*) from $happy_config_group WHERE 1=1 $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Count	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 6;

		$searchMethod	= "";
			#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
				$searchMethod	.= "&search_order=$search_order&keyword=$keyword&group_select=$group_select";
			#검색값 입력완료

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################


		$Sql	= "SELECT * FROM $happy_config_group WHERE 1=1 $WHERE ORDER BY group_sort ASC, number ASC LIMIT $start,$scale ";
		$Record	= query($Sql);

		$groupBox	= str_replace("__onChange__","onChange='this.form.submit()'",$groupBox);


		echo<<<END




					<script>
					function review_del(no)
					{
						if ( confirm('정말 삭제하시겠습니까?') )
						{
							window.location.href = '?type=del&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]&number='+no;
						}
					}
					</script>


					<script language='javascript'>
					function OpenWindow(url,intWidth,intHeight) {
					window.open(url, '_blank', 'width='+intWidth+',height='+intHeight+',resizable=1,scrollbars=1');
					}
					</script>

					<p class="main_title cover">관리자 환경설정관리 <a href="happy_config.php?type=add"><img src="img/btn_group_add.gif" border="0"></a> <label class="right"><a href='happy_config.php?type=add'><img src='img/config_add.gif' alt='설정그룹추가' border=0></a></label></p>

					<div id="list_style">
						<table cellspacing="0" cellpadding="0" border="0" class="bg_style table_line">
						<colgroup>
							<col style="width:4%"></col>
							<col style="width:13%"></col>
							<col></col>
							<col style="width:7%"></col>
							<col style="width:6%"></col>
							<col style="width:6%"></col>
							<col style="width:5%"></col>
							<col style="width:8%"></col>
							<col style="width:18%"></col>
						</colgroup>
						<tr>
							<th>번호</th>
							<th>분류그룹명</th>
							<th>그룹명</th>
							<th>노출상태</th>
							<th>파트갯수</th>
							<th>필드갯수</th>
							<th>순서</th>
							<th>등록일</th>
							<th>관리자툴</th>
						</tr>

END;



		$nowDate	= date("Y-m-d");
		while ( $Data = happy_mysql_fetch_array($Record) )
		{

			$regdate				= substr($Data['reg_date'],0,10);
			$regdate				= $nowDate == $regdate  ? substr($Data['reg_date'],10,9)  : $regdate;

			$Data['group_display']	= ( $Data['group_display'] == '1' )? "<font color='blue'>출력중</font>" : "비공개";

			$Sql					= "SELECT Count(*) FROM $happy_config_part WHERE group_number='$Data[number]'";
			list($part_count)		= happy_mysql_fetch_array(query($Sql));

			$Sql					= "SELECT Count(*) FROM $happy_config_field WHERE group_number='$Data[number]'";
			list($field_count)		= happy_mysql_fetch_array(query($Sql));

			echo<<<END
					<tr>
						<td style="text-align:center;">$listNo</td>
						<td>$Data[menu_group]<br><font color='#AAAAAA'>링크번호:[$Data[number]]</font></td>
						<td>$Data[group_title]</td>
						<td style="text-align:center;">$Data[group_display]</td>
						<td style="text-align:center;">${part_count}개</td>
						<td style="text-align:center;">${field_count}개</td>
						<td style="text-align:center;">$Data[group_sort]</td>
						<td style="text-align:center;">$regdate</td>
						<td style="text-align:center;">
							<a href='happy_config_view.php?number=$Data[number]' class="btn_small_stand">보기</a>
							<a href='?type=part&number=$Data[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]' class="btn_small_stand">편집</a>
							<a href='?type=add&number=$Data[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]' class="btn_small_gray">수정</a>
							<a onClick="review_del('$Data[number]')" class="btn_small_gray">삭제</a>
						</td>
					</tr>

END;

			$listNo--;


		}


		#하단부분
		echo<<<END

					</table>
				</div>

				<div align="center">$paging</div>



END;


	}
	else if ( $type == "add" )							# 설정그룹 작성하기 ##################################################
	{

		if ( $number != '' )		## 수정모드일때 ##
		{
			$Sql					= "SELECT * FROM $happy_config_group WHERE number='$number' ";
			$Data					= happy_mysql_fetch_array(query($Sql));

			//$Data['group_header']	= str_replace("\n","\\n",str_replace("\r","\\r",addslashes($Data['group_header'])));
			//$Data['group_footer']	= str_replace("\n","\\n",str_replace("\r","\\r",addslashes($Data['group_footer'])));
			$Data['group_title']	= addslashes($Data['group_title']);

			${"group_display".$Data['group_display']}	= 'checked';

			$button_title			= '수정';
		}
		else						## 새로작성할때 ##
		{
			$button_title			= '등록';
			$group_display1			= 'checked';
		}

		if ( $happy_config_auto_addslashe == '' )
		{
			$_GET['search_order']	= addslashes($_GET['search_order']);
			$_GET['keyword']		= addslashes($_GET['keyword']);
		}

		$wys_url	= eregi_replace("\/$","",$wys_url);

		#등록된 그룹명 뽑아오기
		$Sql		= "SELECT menu_group FROM $happy_config_group WHERE menu_group !='' GROUP BY menu_group ";
		$Record		= query($Sql);
		$i			= 0;
		$groupBox	= "<select name='group_select' __onChange__ ><option value=''>그룹명 직접입력</option>";
		while ( $subData = happy_mysql_fetch_array($Record) )
		{
			$GROUP[$i++]	= $subData['menu_group'];
			$groupBox		.= "<option value='$subData[menu_group]' $selected>$subData[menu_group]</option>";
		}
		$groupBox	.= "</select>";
		$groupBox	= str_replace("__onChange__","onChange='changeGroup()'",$groupBox);
		$groupBox	.= "<script>document.happy_config_frm.group_select.value='$Data[menu_group]';changeGroup();</script>";


		//위지윅에디터CSS
		$editor_css = happy_wys_css("ckeditor","../");
		$editor_js = happy_wys_js("ckeditor","../");

		$editor_group_header = happy_wys("ckeditor","가로100%","세로300","group_header","{Data.group_header}","../","happycgi_normal");
		$editor_group_footer = happy_wys("ckeditor","가로100%","세로300","group_footer","{Data.group_footer}","../","happycgi_normal");


		#[ YOON : 2009-09-22 ] 그룹명이 없을 시
		#if($Data[group_title] == "" ) $Data[group_title] = "현재 노출메뉴명 없음";

		#설정그룹추가 | 수정
		echo <<<END

				<script>
					function changeGroup()
					{
						var nowValue	= document.happy_config_frm.group_select.options[document.happy_config_frm.group_select.selectedIndex].value;

						if ( nowValue == '' )
						{
							document.happy_config_frm.menu_group.readOnly	= false;
							document.happy_config_frm.menu_group.value		= '';
							document.happy_config_frm.menu_group.focus();
						}
						else
						{
							document.happy_config_frm.menu_group.value		= nowValue;
							document.happy_config_frm.menu_group.readOnly	= true;
						}
					}
				</script>

				$editor_css
				$editor_js

				<!-- 설정그룹추가 [ start ] -->
				<form name='happy_config_frm' action='?type=reg' method='post' enctype='multipart/form-data'>
				<input type='hidden' name='number' value='$number'>
				<input type='hidden' name='start' value='$_GET[start]'>
				<input type='hidden' name='search_order' value='$_GET[search_order]'>
				<input type='hidden' name='keyword' value='$_GET[keyword]'>

				<p class='main_title cover'><font color='#0080FF'>$Data[group_title]</font> 설정그룹${button_title} <span class='small_btn'><a href='?start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]'><img src='img/happy_config_group_list.gif' alt='그룹 리스트' border='0'></a> <a href='?type=part&number=$_GET[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]'><img src='img/happy_config_part_list.gif' alt='파트리스트' border='0'></a></span></p>

				<div id='box_style'>
					<div class="box_1"></div>
					<div class="box_2"></div>
					<div class="box_3"></div>
					<div class="box_4"></div>
					<table cellspacing='1' cellpadding='0' border='0'  class='bg_style box_height'>
					<tr>
						<th>노출메뉴명</th>
						<td><input type='text' name='group_title' value='$Data[group_title]' style='width:100%;'></td>
					</tr>
					<tr>
						<th>메뉴그룹명</th>
						<td>
							<input type='text' name='menu_group' value='$Data[menu_group]'> $groupBox
							<p style='padding-top:5px; line-height:18px;'>
							새로운 그룹명으로 등록할 때는 선택폼에서 <strong>[그룹명 직접입력]</strong>을 선택한 후 입력폼에 그룹명을 입력합니다.<br>
							기존 그룹명으로 등록할 때는 선택폼에서 기존 그룹명을 선택합니다.
							</p>
						</td>
					</tr>
					<tr>
						<th>그룹상단<br>( HTML 형식 )</th>
						<td>
							$editor_group_header
						</td>
					</tr>
					<tr>
						<th>그룹하단<br>( HTML 형식 )</th>
						<td>
							$editor_group_footer
						</td>
					</tr>
					<tr>
						<th class='bg_green'>그룹노출설정</th>
						<td>
							<input type='radio' name='group_display' value='1' $group_display1 class=cfg_input_chk id=group_display1> <label for="group_display1" class=label_txt>출력</label>
							<input type='radio' name='group_display' value='0' $group_display0 class=cfg_input_chk id=group_display2> <label for="group_display2" class=label_txt>숨김</label>
						</td>
					</tr>
					<tr>
						<th>출력순서</th>
						<td>
							<input type='text' name='group_sort' value='$Data[group_sort]' onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'>
							<font color=gray>낮을수록 위쪽으로 표시 됩니다. (미입력시 0으로 저장됩니다.)</font>
						</td>
					</tr>
					</table>
				</div>

				<div style='text-align:center;'><input type='submit' value='설정을 저장합니다' class='btn_big'> <A HREF="javascript:history.go(-1);" class='btn_big_gray'>목록</A></div>
				</form>
END;


#하단부분
echo<<<END


END;

	}
	else if ( $type == "part" )									# 설정 리스트출력 ################################################
	{
		$number	= preg_replace("/\D/","",$_GET['number']);

		$GROUP	= happy_mysql_fetch_array(query("SELECT * FROM $happy_config_group WHERE number='$number'"));


		#파트 설정편집 페이지
		echo<<<END


				<p class="main_title">$GROUP[group_title] <span><img src="img/happy_config_txt_sort.gif" style='vertical-align:middle;'> <span class="blue">[ $GROUP[group_sort] ]</span></span>
				<span class="small_btn">
					<a href='?start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]' style='font-size:8pt'><img src='img/happy_config_group_list.gif' alt='그룹리스트' border=0></a>
					<a href='?type=part_add&number=$GROUP[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]' style='font-size:8pt'><img src='img/happy_config_part_add.gif' alt='파트추가' border=0></a>
				</span>
				</p>

				<div id="box_style">
					<div class="box_1"></div>
					<div class="box_2"></div>
					<div class="box_3"></div>
					<div class="box_4"></div>
					<table cellspacing="1" cellpadding="0" border="0" class="bg_style box_height">

END;

		$PartRecord	= query("SELECT * FROM $happy_config_part WHERE group_number = '$GROUP[number]' ORDER BY part_sort ASC, number ASC ");

		$FGCount = 0;
		while ( $Part = happy_mysql_fetch_array($PartRecord) )
		{

			$FGCount++;

			//카카오 알림톡 템플릿찾기 hong
			$Part['part_content']	= preg_replace("/%알림톡템플릿찾기-(.*)-(.*)-(.*)-알림톡템플릿찾기%/","<a href='javascript:void(0);' onClick=\"kakao_template_find('".$KAKAO_CONFIG['tpl_url']."','\\1','\\2','\\3');\">".$KAKAO_CONFIG['find_icon']."</a>", $Part['part_content']);
			$Part['part_content']	= str_replace("%알림톡도움말%", "<img alt='' border='0' onclick=\"window.open('http://cgimall.co.kr/happy_manual/faq_viewer_detail.cgi?db=board_faq&thread=340','happy_report','scrollbars=yes,width=700,height=600');\" src='img/btn_help.gif' style='vertical-align: middle; cursor: pointer; scrolling: yes;' alt='알림톡 도움말' title='알림톡 도움말' />", $Part['part_content']);

			$Sql	= "SELECT * FROM $happy_config_field WHERE part_number='$Part[number]' ";
			$FieldRecord	= query($Sql);


			while ( $Field = happy_mysql_fetch_array($FieldRecord) )
			{


				$nowForm		= happy_config_field_maker($Field['number']);

				$field_name		= $Field['field_name'];

				$Part['part_content']	= str_replace("%".$field_name."%", $nowForm, $Part['part_content']);

			}



			if ($Part[part_sub_title] == "" ) $Part[part_sub_title] = "<font color='#999999'>짧은 설명내용이 없습니다.</font>";
			echo <<<END
						<tr>
							<th>
								<p style="margin-bottom:5px;">$Part[part_title]</p>
								<div style="color:#777; padding:5px 0 5px 0; border-bottom:1px solid #dbdbdb; border-top:1px solid #dbdbdb; margin-bottom:10px;">소팅번호: <b>$Part[part_sort]</b></div>
								<a href='?type=part_add&number=$GROUP[number]&part_number=$Part[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]' class="btn_small_stand">수정</a> <a onClick="if ( confirm('정말 삭제하시겠습니까?') ) { window.location.href = '?type=part_del&number=$GROUP[number]&part_number=$Part[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]'; }" class="btn_small_stand">삭제</a>
							</th>
							<td>
								<p class="short">$Part[part_sub_title]</p>
								$Part[part_content]
							</td>
						</tr>
END;
		}

		#저장된 필드리스트가 없을 때 [ YOON : 2009-09-21 ]
		if($FGCount	== 0) echo"<tr><td align=center colspan=2 style=\" font-size:10pt; font-family:맑은 고딕,돋움; padding:10 0;\">사용중인 그룹리스트가 없습니다.</td></tr>";




			echo <<<END
						</table>
					</div>
				</div>
				<div style="text-align:right;">
					<a href='?start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]' style='font-size:8pt'><img src='img/happy_config_group_list.gif' alt='그룹리스트' border=0></a>
					<a href='?type=part_add&number=$GROUP[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]' style='font-size:8pt'><img src='img/happy_config_part_add.gif' alt='파트추가' border=0></a>
				</div>

END;

#하단부분
echo <<<END

END;


	}
	else if ( $type == "part_add" )
	{
		$number			= preg_replace("/\D/","",$_GET['number']);
		$part_number	= preg_replace("/\D/","",$_GET['part_number']);

		$GROUP			= happy_mysql_fetch_array(query("SELECT * FROM $happy_config_group WHERE number='$number'"));


		if ( $part_number != '' )		## 수정모드일때 ##
		{
			$Sql					= "SELECT * FROM $happy_config_part WHERE number='$part_number' ";
			$Data					= happy_mysql_fetch_array(query($Sql));

			//$Data['part_content']	= str_replace("\n","\\n",str_replace("\r","\\r",addslashes($Data['part_content'])));
			$Data['part_title']		= addslashes($Data['part_title']);
			//$Data['part_sub_title']	= addslashes($Data['part_sub_title']);
			$Data[part_sub_title] = str_replace("\"","&quot;",$Data[part_sub_title]);

			$button_title			= '수정';
		}
		else						## 새로작성할때 ##
		{
			$button_title			= '등록';
		}

		if ( $happy_config_auto_addslashe == '' )
		{
			$_GET['search_order']	= addslashes($_GET['search_order']);
			$_GET['keyword']		= addslashes($_GET['keyword']);
		}

#자바스크립트
echo <<<END
<script>
	var happyConfigRequest;
	var happyConfigHandleFunction	= '';

	if (window.XMLHttpRequest) {
	happyConfigRequest = new XMLHttpRequest();
	} else {
	happyConfigRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}


	function happyConfigStartRequest( linkUrl, handleFunc )
	{
		happyConfigHandleFunction	= handleFunc;
		happyConfigRequest.open("GET", linkUrl , true);
		happyConfigRequest.onreadystatechange = happyConfigHandleStateChange;
		happyConfigRequest.send(null);
	}


	function happyConfigHandleStateChange()
	{
		if (happyConfigRequest.readyState == 4)
		{
			if (happyConfigRequest.status == 200)
			{
				var response = happyConfigRequest.responseText;
				window.status="전송완료"
				eval(happyConfigHandleFunction +"(\""+ response +"\")");
			}
		}
		if (happyConfigRequest.readyState == 1)  {
			window.status="로딩중"
		}
	}

	function filed_add()
	{
		happyConfigStartRequest('happy_config_field.php','ddd');
	}


	function field_type_change()
	{
		obj	= document.getElementById('field_type');
		val	= obj.options[obj.selectedIndex].value;

		len	= obj.length;
		for ( i=0 ; i<len ; i++ )
		{
			nowVal	= obj.options[i].value;

			objName	= "field_out_type_"+nowVal;
			nowObj	= document.getElementById(objName);

			if ( nowObj )
			{
				if ( val == nowVal )
				{
					nowObj.style.display = '';
					document.getElementById('field_out_type').value	= nowObj.options[nowObj.selectedIndex].value;
				}
				else
				{
					nowObj.style.display = 'none';
				}
			}
		}

		if ( val == 'checkbox' || val == 'radio' || val == 'select' )
		{
			document.getElementById('field_option_layer').style.display		= '';
			document.getElementById('field_style_name_layer').innerHTML		= '폼 스타일(CSS)';
			document.getElementById('field_option_name_layer').innerHTML	= '필드 value 값';
		}
		else if ( val == 'wys' )
		{
			document.getElementById('field_option_layer').style.display		= '';
			document.getElementById('field_style_name_layer').innerHTML		= '에디터 높이(px)<br>(미입력시 300px)';
			document.getElementById('field_option_name_layer').innerHTML	= '에디터 Toolbar<br>(미입력시 happycgi)';
		}
		else if ( val == 'file' )
		{
			document.getElementById('field_option_layer').style.display		= '';
			document.getElementById('field_style_name_layer').innerHTML		= '폼 스타일(CSS)';
			document.getElementById('field_option_name_layer').innerHTML	= '업로드 확장자<br>(쉼표구분)';
		}
		else
		{
			document.getElementById('field_style_name_layer').innerHTML		= '폼 스타일(CSS)';
			document.getElementById('field_option_layer').style.display		= 'none';
		}
	}


	function happy_field_mod(number)
	{
		document.getElementById('field_add_layer').style.display	= '';
		field_name		= document.getElementById('field_name_'+number).value;
		field_type		= document.getElementById('field_type_'+number).value;
		field_option	= document.getElementById('field_option_'+number).value;
		field_value		= document.getElementById('field_value_'+number).value;
		field_memo		= document.getElementById('field_memo_'+number).value;

		document.happy_config_field_frm.field_name.value	= field_name;
		document.happy_config_field_frm.field_type.value	= field_type;
		field_type_change();
		document.happy_config_field_frm.field_option.value	= field_option;
		document.happy_config_field_frm.field_value.value	= field_value;
		document.happy_config_field_frm.field_memo.value	= field_memo;
		document.happy_config_field_frm.field_number.value	= number;


		document.getElementById('happy_config_field_reg_title').innerHTML	= "<b><font color='#FA5300'>%"+field_name+"%</font> <font color='#555555'>필드수정<?font></b>";
		document.getElementById('happy_config_field_add_button').value		= "필드수정";

		window.location.href	= '#field_add_index';
		document.happy_config_field_frm.field_name.focus();
	}

	function happy_field_del(number)
	{
		field_name		= document.getElementById('field_name_'+number).value;
		if ( confirm( field_name+" 필드를 삭제하시겠습니까?") )
		{
			document.happy_config_field_action.location.href	= "?type=field_del&number="+number;
		}
	}

	function happy_field_add()
	{
		document.getElementById('field_add_layer').style.display	= '';
		document.happy_config_field_frm.reset();
		field_type_change();
		document.getElementById('happy_config_field_reg_title').innerHTML	= "<b>새로운 필드 추가</b>";
		document.getElementById('happy_config_field_add_button').value		= "필드등록";

		window.location.href	= '#field_add_index';
		document.happy_config_field_frm.field_name.focus();

	}
</script>
END;



		#if ($Data[part_title] == "") $Data[part_title] = "제목없음";

		echo happy_wys_css('ckeditor','../');
		echo happy_wys_js('ckeditor','../');

		#파트수정페이지 | 새로운필드추가 | 폼출력
		echo<<<END

			<p class="main_title cover"><font color='#0080FF'>$Data[part_title]</font> 파트${button_title} <label class="right"><a href='?type=part&number=$_GET[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]'><img src='img/happy_config_part_list.gif' alt='파트 리스트' border='0'></a></label>
			</p>

			<form name='happy_config_frm' action='?type=part_reg' method='post' enctype='multipart/form-data'>
			<input type='hidden' name='number' value='$number'>
			<input type='hidden' name='part_number' value='$part_number'>
			<input type='hidden' name='start' value='$_GET[start]'>
			<input type='hidden' name='search_order' value='$_GET[search_order]'>
			<input type='hidden' name='keyword' value='$_GET[keyword]'>
			<div id="box_style">
				<div class="box_1"></div>
				<div class="box_2"></div>
				<div class="box_3"></div>
				<div class="box_4"></div>

				<table cellspacing='1' cellpadding='0' border='0' class='bg_style'>
				<colgroup>
					<col style='width:18%'></col>
					<col></col>
				</colgroup>
				<tr>
					<th>파트제목</th>
					<td><input type='text' name='part_title' value='$Data[part_title]' style='width:500px;'></td>
				</tr>
				<tr>
					<th>파트짧은설명</th>
					<td><input type='text' name='part_sub_title' value="$Data[part_sub_title]" style='width:500px;'></td>
				</tr>
				<tr>
					<th>소팅번호</th>
					<td>
						<input type='text' name='part_sort' value='$Data[part_sort]' onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;' > <font color=gray>낮을수록 위쪽으로 표시 됩니다. (미입력시 0으로 저장됩니다.)</font>
					</td>
				</tr>
				<tr>
					<th><b>출력 HTML</b></th>
					<td>
								<!-- 위지윅 시작 -->
END;
								echo happy_wys('ckeditor','가로100%','세로650','part_content','{Data.part_content}','../','happycgi_normal','all');
		echo<<<END
								<!-- 위지윅끝 -->
					</td>
				</tr>
				</table>
			</div>
			</form>


			<p class="main_title"><font color='#0080FF'>사용중인 필드</font> <img src='img/happy_config_add_field.gif' alt='새로운 필드 추가' onClick='happy_field_add()'><label class="font_st_12">생성된 태그명을 위 <b>출력HTML</b> 항목에 기입해주셔야 출력됩니다.</label></p>

			<div id="list_style">

				<table cellspacing='0' cellpadding='0' border='0' class='bg_style table_line'>
				<colgroup>
						<col style='width:18%'></col>
						<col></col>
						<col style='width:10%'></col>
				</colgroup>
				<tr>
					<th>태그명</th>
					<th>출력형식 미리보기 및 메모</th>
					<th>관리툴</th>
				</tr>

END;


						$Sql	= "SELECT * FROM $happy_config_field WHERE part_number='$part_number' ORDER BY number ASC";
						$Record	= query($Sql);

						$FCount	= 0;
						while ( $Field = happy_mysql_fetch_array($Record) )
						{
							$FCount++;
							$nowForm		= happy_config_field_maker($Field['number']);

							$field_name		= (str_replace('"',"'",$Field['field_name']));
							$field_type		= (str_replace('"',"'",$Field['field_type']));
							$field_option	= (str_replace('"',"'",$Field['field_option']));
							$field_value	= (str_replace('"',"'",$Field['field_value']));
							$field_memo		= (str_replace('"',"'",$Field['field_memo']));

							$Field['field_memo']	= nl2br($Field['field_memo']);



							###[ YOON  : 2009-09-22 ] 필드메모 내용 유무관련 ###
							if ($Field['field_memo'] == ""){
								$cfg_field_memo = "<div id='cfg_field_memo' style='display:none;'></div>";
							}else{
								$cfg_field_memo = "<br><br><div class='help_style'><div class='box_1'></div><div class='box_2'></div><div class='box_3'></div><div class='box_4'></div><span class='help'>메모내용</span><p>".$Field[field_memo]."</p></div>";
							}

							#리스트필드내용
							echo<<<END
								<textarea style='display:none' name='field_name_$Field[number]' id='field_name_$Field[number]'>$field_name</textarea>
								<textarea style='display:none' name='field_type_$Field[number]' id='field_type_$Field[number]'>$field_type</textarea>
								<textarea style='display:none' name='field_option_$Field[number]' id='field_option_$Field[number]'>$field_option</textarea>
								<textarea style='display:none' name='field_value_$Field[number]' id='field_value_$Field[number]'>$field_value</textarea>
								<textarea style='display:none' name='field_memo_$Field[number]' id='field_memo_$Field[number]'>$field_memo</textarea>

								<tr>
									<td class='b_border_td'>%$Field[field_name]%</td>
									<td class='b_border_td'>
										$nowForm
										$cfg_field_memo
									</td>
									<td class='b_border_td'><a onClick="happy_field_mod('$Field[number]');" class="btn_small_stand">수정</a> <a onClick="happy_field_del('$Field[number]');" class="btn_small_stand">삭제</a></td>
								</tr>

END;
						}

						#저장된 필드가 없을 때
						if ( $FCount == 0 )
						{
							echo "
								<tr>
									<td align=center colspan=3 style=\"color:gray; font-size:10pt; font-family:맑은 고딕,돋움; padding:10px 0;\">사용중인 필드항목이 없습니다.</td>
								</tr>
							";
						}




						#리스트 끝
						echo <<<END
						</table>
					</div>

END;


						#저장된 파트가 있다면 파트가 출력되고 [필드추가] 버튼이 보임
						if ( $part_number != '' )
						{
							echo "
								<div style='text-align:right; padding:10px 0 10px 0;'><img src='img/happy_config_add_field.gif' alt='새로운 필드 추가' onClick='happy_field_add()' style='cursor:pointer'></div>
							";
						}
						else
						{
							#등록된 파트정보가 없을 때
							echo "
								<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr>
									<td align=center style=\"color:#F05C00; font-size:8pt; font-family:맑은 고딕,돋움; padding:0 0;\">필드를 추가 하실려면 현재 파트를 등록(저장)해 주셔야 합니다.</td>
								</tr>
								</table>
							";
						}


						#필드추가/수정 담당레이어 : 기본값 : 안보임 [ start ]
						echo<<<END

						<a name='field_add_index'></a><br><br>
						<div id='field_add_layer' style='display:none;'>

							<iframe name='happy_config_field_action' width="100%" height=150 style='display:none;'></iframe>

							<form name='happy_config_field_frm' action='?type=field_reg' target='happy_config_field_action' method='post'>
							<input type='hidden' name='number' value='$number'>
							<input type='hidden' name='part_number' value='$part_number'>
							<input type='hidden' name='field_number' value=''>

							<div id='box_style'>
								<div class="box_1"></div>
								<div class="box_2"></div>
								<div class="box_3"></div>
								<div class="box_4"></div>

								<table cellspacing='1' cellpadding='0' border='0' class='bg_style'>
								<colgroup>
								<col style='width:15%;'></col>
								<col style='width:35%;'></col>
								<col style='width:15%;'></col>
								<col style='width:35%;'></col>
								</colgroup>
								<tr>
									<th colspan='4' class='bg_green'><strong id='happy_config_field_reg_title'>새로운 필드추가</strong></th>
								</tr>
								<tr>
									<th>필드명</th>
									<td><input type='text' name='field_name' value=''></td>
									<th>필드타입(Type)</th>
									<td>
										<select name='field_type' id='field_type' onChange='field_type_change()'>
										<option value='text'>일반텍스트입력박스</option>
										<option value='textarea'>TEXTAREA</option>
										<option value='wys'>위지윅에디터</option>
										<option value='phone'>휴대폰메세지창</option>
										<option value='select'>셀렉트박스</option>
										<option value='checkbox'>체크박스</option>
										<option value='radio'>라디오박스</option>
										<option value='file'>파일업로드</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>변수출력타입(Type)</th>
									<td colspan='3'>
										<input type='hidden' name='field_out_type' id='field_out_type' value=''>
										<select name='field_out_type_text' id='field_out_type_text' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value=''>단순변수</option>
										<option value='array'>배열로 리턴</option>
										</select>

										<select name='field_out_type_textarea' id='field_out_type_textarea' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value=''>입력한대로 리턴</option>
										<option value='nl2br'>개행문자 &lt;br&gt;처리</option>
										</select>

										<select name='field_out_type_wys' id='field_out_type_textarea' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value=''>입력한대로 리턴</option>
										</select>

										<select name='field_out_type_phone' id='field_out_type_phone' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value=''>입력한대로 리턴</option>
										<option value='nl2br'>개행문자 &lt;br&gt;처리</option>
										</select>

										<select name='field_out_type_text' id='field_out_type_text' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value=''>단순변수</option>
										<option value='array'>배열로 리턴</option>
										</select>

										<select name='field_out_type_select' id='field_out_type_select' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value=''>단순변수</option>
										<option value='array'>배열로 리턴</option>
										</select>

										<select name='field_out_type_checkbox' id='field_out_type_checkbox' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value='checkbox'>단순변수(쉼표로 묶어줌)</option>
										<option value='checkbox_array'>배열로 리턴</option>
										</select>

										<select name='field_out_type_radio' id='field_out_type_radio' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value=''>단순변수</option>
										</select>

										<select name='field_out_type_file' id='field_out_type_file' onChange="document.getElementById('field_out_type').value=this.options[this.selectedIndex].value;" style='display:none'>
										<option value=''>파일명 리턴</option>
										</select>
									</td>
								</tr>
								<tr>
									<th><div id='field_style_name_layer'></div></th>
									<td colspan='3'>
										<input type='text' name='field_option' style='margin-bottom:5px; width:100%;'><br>
										폼 스타일 입력시 <b>style="속성:속성값"</b> 형식으로 입력하세요.
									</td>
								</tr>
								<tr id='field_option_layer' style='display:none;'>
									<th><div id='field_option_name_layer'></div></th>
									<td colspan='3'>
										<input type='text' name='field_value' style='margin-bottom:5px; width:100%;'><br>
										셀렉트박스, 라디오박스의 경우 value값 입력형식은 각각 value|text 값 입력형식입니다.<br>
										value 값들 사이의 구분자는 쉼표(,)로 구분합니다.<br>
										입력 예1) 5|5번 , 6|6번 , 7|7번<br>
										입력 예2) 5번 , 6번 , 7번<br>
									</td>
								</tr>
								<script>
								field_type_change();
								</script>
								<tr>
									<th>필드 짧은설명</th>
									<td colspan='3'>
										<textarea name='field_memo' style='width:100%; height:80px;'></textarea>
									</td>
								</tr>
								</table>
								<div style='text-align:right;'><span class='font_st_11'>필드를 등록 또는 수정시 페이지가 새로고침 됩니다.</span></div>
								<div style='text-align:center; margin-bottom:20px;'>
									<input type='submit' name='happy_config_field_add_button' id='happy_config_field_add_button'  value='필드등록' class='btn_small_yellow'>
									<input type='button' value='취소' onClick="document.getElementById('field_add_layer').style.display='none';" class='btn_small_dark'>
								</div>
							</div>
							</form>
						</div>
						<!-- 필드수정 담당 레이어 [ end ] -->


END;




						echo<<<END

				</form>


				<!-- 파트저장 | 수정 버튼 -->
				<div style='text-align:center;'><input type='button' value='파트 ${button_title}하기' onClick='document.happy_config_frm.submit()' class="btn_big"></div>

END;

		#하단부분
		echo<<<END

END;
	}
	else if ( $type == "reg" )
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 이용하실수 없습니다.");
			exit;
		}
		#넘어온 변수값 정리
		$group_title	= $_POST['group_title'];
		$group_header	= $_POST['group_header'];
		$group_footer	= $_POST['group_footer'];
		$group_etc1		= $_POST['group_etc1'];
		$group_etc2		= $_POST['group_etc2'];
		$group_etc3		= $_POST['group_etc3'];
		$group_etc4		= $_POST['group_etc4'];
		$group_etc5		= $_POST['group_etc5'];
		$group_display	= $_POST['group_display'];
		$group_sort		= $_POST['group_sort'];
		$menu_group		= $_POST['menu_group'];

		$start			= $_POST['start'];
		$search_order	= $_POST['search_order'];
		$keyword		= $_POST['keyword'];

		$number			= preg_replace('/\D/', '',$_POST['number']);


		if ( $happy_config_auto_addslashe == '' )
		{
			$group_title	= addslashes($_POST["group_title"]);
			//$group_header	= addslashes($_POST["group_header"]);
			$group_header	= $_POST["group_header"];
			//$group_footer	= addslashes($_POST["group_footer"]);
			$group_footer	= $_POST["group_footer"];
			$menu_group	= addslashes($_POST["menu_group"]);
		}


		#쿼리문 생성
		$SetSql		= "
						group_title		= '$group_title',
						group_header	= '$group_header',
						group_footer	= '$group_footer',
						group_etc1		= '$group_etc1',
						group_etc2		= '$group_etc2',
						group_etc3		= '$group_etc3',
						group_etc4		= '$group_etc4',
						group_etc5		= '$group_etc5',
						group_display	= '$group_display',
						group_sort		= '$group_sort',
						menu_group		= '$menu_group',
						mod_date		= now()

		";

		if ( $number == '' )
		{
			$Sql	= "
						INSERT INTO
								$happy_config_group
						SET
								$SetSql ,
								reg_date		= now()
			";

			#하단부분
			echo<<<END

END;
			$okMsg	= "등록되었습니다.";
		}
		else
		{
			$Sql	= "UPDATE $happy_config_group SET $SetSql WHERE number = '$number'";

			#하단부분

END;
			$okMsg	= "수정되었습니다.";
		}

		#echo nl2br($Sql);exit;
		query($Sql);

		gomsg($okMsg, "?start=$start&search_order=$search_order&keyword=$keyword");


	}
	else if ( $type == "part_reg" )
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 이용하실수 없습니다.");
			exit;
		}
		#넘어온 변수값 정리
		$part_title		= $_POST['part_title'];
		$part_sub_title	= $_POST['part_sub_title'];
		$part_content	= $_POST['part_content'];
		$part_etc1		= $_POST['part_etc1'];
		$part_etc2		= $_POST['part_etc2'];
		$part_etc3		= $_POST['part_etc3'];
		$part_sort		= $_POST['part_sort'];

		$start			= $_POST['start'];
		$search_order	= $_POST['search_order'];
		$keyword		= $_POST['keyword'];

		$number			= preg_replace('/\D/', '',$_POST['number']);
		$part_number	= preg_replace('/\D/', '',$_POST['part_number']);
		$group_number	= $number;

		if ( $happy_config_auto_addslashe == '' )
		{
			$part_title		= addslashes($_POST["part_title"]);
			$part_sub_title	= addslashes($_POST["part_sub_title"]);
			//$part_content	= addslashes($_POST["part_content"]);
			$part_content	= $_POST["part_content"];
		}


		#쿼리문 생성
		$SetSql		= "
						group_number	= '$group_number',
						part_title		= '$part_title',
						part_sub_title	= '$part_sub_title',
						part_content	= '$part_content',
						part_etc1		= '$part_etc1',
						part_etc2		= '$part_etc2',
						part_etc3		= '$part_etc3',
						part_sort		= '$part_sort',
						mod_date		= now()
		";

		if ( $part_number == '' )
		{
			$Sql	= "
						INSERT INTO
								$happy_config_part
						SET
								$SetSql ,
								reg_date		= now()
			";

			#하단부분
			echo<<<END

END;
			$okMsg	= "등록되었습니다.";
		}
		else
		{
			$Sql	= "UPDATE $happy_config_part SET $SetSql WHERE number = '$part_number'";

			#하단부분
			echo<<<END

END;
			$okMsg	= "수정되었습니다.";
		}

		#echo nl2br($Sql);exit;
		query($Sql);

		gomsg($okMsg, "?type=part&number=$number&start=$start&search_order=$search_order&keyword=$keyword");
	}
	else if ( $type == "part_del" )
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 이용하실수 없습니다.");
			exit;
		}
		$number			= preg_replace("/\D/","",$_GET['number']);
		$part_number	= preg_replace("/\D/","",$_GET['part_number']);

		$start			= $_POST['start'];
		$search_order	= $_POST['search_order'];
		$keyword		= $_POST['keyword'];

		#설정값 삭제
		$Sql	= "SELECT field_name FROM $happy_config_field WHERE part_number='$part_number'";
		$Record	= query($Sql);

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Tmp	= happy_mysql_fetch_array(query("SELECT count(*) FROM $happy_config WHERE conf_name='$Data[field_name]'"));
			if ( $Tmp[0] == 1 )
			{
				query("DELETE FROM $happy_config WHERE conf_name='$Data[field_name]'");
			}
		}

		query("DELETE FROM $happy_config_part WHERE number='$part_number'");
		query("DELETE FROM $happy_config_field WHERE part_number='$part_number'");

		gomsg("삭제되었습니다.", "?type=part&number=$number&start=$start&search_order=$search_order&keyword=$keyword");
	}
	else if ( $type == "field_reg" )
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 이용하실수 없습니다.");
			exit;
		}
		#넘어온 변수값 정리
		$field_name		= $_POST['field_name'];
		$field_type		= $_POST['field_type'];
		$field_value	= $_POST['field_value'];
		$field_option	= $_POST['field_option'];
		$field_out_type	= $_POST['field_out_type'];
		$field_memo		= $_POST['field_memo'];

		$number			= preg_replace('/\D/', '',$_POST['number']);
		$part_number	= preg_replace('/\D/', '',$_POST['part_number']);
		$field_number	= preg_replace('/\D/', '',$_POST['field_number']);
		$group_number	= $number;

		if ( $happy_config_auto_addslashe == '' )
		{
			$field_name		= addslashes($_POST["field_name"]);
			$field_option	= addslashes($_POST["field_option"]);
			$field_memo		= addslashes($_POST["field_memo"]);
		}


		#쿼리문 생성
		$SetSql		= "
						group_number	= '$group_number',
						part_number		= '$part_number',
						field_name		= '$field_name',
						field_type		= '$field_type',
						field_value		= '$field_value',
						field_option	= '$field_option',
						field_out_type	= '$field_out_type',
						field_memo		= '$field_memo',
						mod_date		= now()

		";

		if ( $field_number == '' )
		{
			$Sql	= "
						INSERT INTO
								$happy_config_field
						SET
								$SetSql ,
								reg_date		= now()
			";
			$okMsg	= "등록되었습니다.";
		}
		else
		{
			$Sql	= "UPDATE $happy_config_field SET $SetSql WHERE number = '$field_number'";
			$okMsg	= "수정되었습니다.";
		}

		#echo nl2br($Sql);exit;
		query($Sql);

		echo "
			<script>
				parent.window.location.reload();
			</script>
		";

		exit;

	}
	else if ( $type == "field_del" )
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 이용하실수 없습니다.");
			exit;
		}
		$number	= preg_replace("/\D/","",$number);

		#설정값 삭제
		$Sql	= "SELECT field_name FROM $happy_config_field WHERE number='$number'";
		$Record	= query($Sql);

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Tmp	= happy_mysql_fetch_array(query("SELECT count(*) FROM $happy_config WHERE conf_name='$Data[field_name]'"));
			if ( $Tmp[0] == 1 )
			{
				query("DELETE FROM $happy_config WHERE conf_name='$Data[field_name]'");
			}
		}

		$Sql	= "DELETE FROM $happy_config_field WHERE number='$number' ";
		query($Sql);

		echo "
			<script>
				alert('삭제되었습니다.');
				parent.window.location.reload();
			</script>
		";

		exit;
	}
	else if ( $type == "del" )							#설정 삭제하기 ##################################################
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 이용하실수 없습니다.");
			exit;
		}
		$number	= preg_replace("/\D/","",$number);

		$start			= $_GET['start'];
		$search_order	= $_GET['search_order'];
		$keyword		= $_GET['keyword'];

		#설정값 삭제
		$Sql	= "SELECT field_name FROM $happy_config_field WHERE group_number='$number'";
		$Record	= query($Sql);

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Tmp	= happy_mysql_fetch_array(query("SELECT count(*) FROM $happy_config WHERE conf_name='$Data[field_name]'"));
			if ( $Tmp[0] == 1 )
			{
				query("DELETE FROM $happy_config WHERE conf_name='$Data[field_name]'");
			}
		}

		$Sql	= "DELETE FROM $happy_config_group WHERE number='$number' ";
		query($Sql);

		$Sql	= "DELETE FROM $happy_config_part WHERE group_number='$number' ";
		query($Sql);

		$Sql	= "DELETE FROM $happy_config_field WHERE group_number='$number' ";
		query($Sql);

		gomsg("삭제되었습니다.","?start=$start&search_order=$search_order&keyword=$keyword");
	}



	echo "";




############################################################################################################################
	#하단 공통 HTML
	echo <<<END


END;


include ("tpl_inc/bottom.php");



#	echo "<br><hr>테스트중<br>";
#	echo happy_config_group_load(2,'','ok');


?>