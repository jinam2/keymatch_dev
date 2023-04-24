<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");
	include ("../class/color.php");

	#관리자 접속 체크 루틴
	if ( !admin_secure("환경설정") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	#관리자 접속 체크 루틴

	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################

	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);
	$group_select	= $_GET['group_select'];

/*
create table happy_icon_list (
 number int not null auto_increment primary key,
 icon_name varchar(100) not null default '',
 icon_jpg_file varchar(150) not null default '',
 icon_png_file varchar(150) not null default '',
 icon_width int not null default '0',
 icon_height int not null default '0',
 icon_border int not null default '0',
 icon_align varchar(20) not null default 'absmiddle',
 icon_option varchar(250) not null default '',
 reg_date datetime not null default '0000-00-00 00:00:00'
);

create table happy_menu_conf (
 number int not null auto_increment primary key,
 type varchar(30) not null default '',
 conf_bgcolor varchar(30) not null default '',
 key(type)
);

insert into happy_menu_conf set type='', conf_bgcolor='FFFFFF';
{{아이콘 아이콘이름}}


# 그룹기능 패치 ####### 2009/10/19 # kwak16
alter table happy_icon_list ADD `group` varchar(100) not null default ''  AFTER icon_option;
# 위 SQL문을 실행후 admin/happy_icon_admin.php 파일을 덮어쓰고
# inc/function.php 파일의 셋팅부분과 inc/lib.php 파일에서 news_icon_maker() 함수를 덮어쓴다.
# function.php 파일의 $배경색상 루틴 조절
*/

	#아이콘아래 상단 HTML


	### YOON : 2009-06-04 ####
	if($type == "add") $now_locate_icon = "> 등록하기";
	else $now_locate_icon = "";
	if($type == "add" && $number) $now_locate_icon = "> 수정하기";

	$group	= '';
	if ( is_array($happy_icon_group) )
	{
		$group			= $_GET['group'] == '' ? $_POST['group'] : $_GET['group'];
		$groupSelect	= "<select name='group' onChange=\"window.location.href = '?group='+ this.value +'&search_field=$_GET[search_field]&search_keyword=$_GET[search_keyword]';\">";
		$groupSelect	.= "<option value=''>전체</option>";
		#복사할 셀렉트
		$groupSelectCopy = "<select name='group' style='vertical-align:middle'>";

		foreach( $happy_icon_group AS $key )
		{
			$selected		= $group == $key ? 'selected' : '';
			$groupSelect	.= "<option value='$key' $selected >$key</option>";
			#복사할 셀렉트
			$groupSelectCopy	.= "<option value='$key'>$key</option>";
		}
		$groupSelect	.= "</select>";
		$groupSelectCopy .= "</select>";
	}


	$select_icon_name = "";
	$select_icon_jpg_file = "";
	$select_icon_png_file = "";
	if ( $_GET['search_field'] == "icon_name" )
	{
		$select_icon_name = " selected ";
	}
	else if ( $_GET['search_field'] == "icon_jpg_file" )
	{
		$select_icon_jpg_file = " selected ";
	}
	else if ( $_GET['search_field'] == "icon_png_file" )
	{
		$select_icon_png_file = " selected ";
	}



	echo "

<!-- 풍선도움말 관련 -->
<!--
<script language='javascript' type='text/javascript' src='../js/balloon.js'></script>
<link rel='stylesheet' type='text/css' href='css/style.css'>
-->


	";


	if ( $type == "" )									# 아이콘 리스트출력 ################################################
	{
		$WHERE	= ( $group == '' )? " WHERE type='' " : " WHERE type='$group' ";
		$Sql		= "SELECT * FROM $happy_menu_conf $WHERE ORDER BY number DESC LIMIT 0,1";
		$MenuConf	= happy_mysql_fetch_array(query($Sql));

		$MenuConf['conf_bgcolor']	= $MenuConf['conf_bgcolor'] == '' ? '#ffffff' : $MenuConf['conf_bgcolor'];

		#hex to rgb to Color of Class : NeoHero
		$GetMycolor = color::hex2rgb("$MenuConf[conf_bgcolor]") ;


		echo <<<END

		<script>
		function review_del(no,grp)
		{
			if ( confirm('정말 삭제하시겠습니까?') )
			{
				window.location.href = '?type=del&group='+grp+'&start=$start&search_order=$search_order&keyword=$keyword&number='+no;
			}
		}
		function cripboard_copy(copy_msg) {
			clipboardData.setData('Text', copy_msg);
			alert(copy_msg + '   \\n-------------------------------------------------- \\n이미지 경로가 복사되었습니다.\\n템플릿파일에서 이미지로 바로 사용할 수 있는 \\n용도로 이미지경로를 복사합니다.  ');
		}
		</script>



<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../js/jqColorPicker.min.js"></script>
<script type="text/javascript">


	function checkchk(form)
	{
		cnt = form.length;
		chk = false;
		for ( i=0; i<cnt; i++ )
		{
			if ( form[i].type == "checkbox" )
			{
				if ( form[i].checked == true )
				{
					chk = true;
					break;
				}
			}
		}

		if ( chk == false )
		{
			alert("복사할 아이콘을 하나라도 선택하셔야 합니다.");
			return false;
		}
		else
		{
			return true;
		}
	}

	function allcheck(form)
	{
		cnt = form.length;
		chk = false;
		for ( i=0; i<cnt; i++ )
		{
			if ( form[i].type == "checkbox" )
			{
				if ( form[i].checked == true )
				{
					form[i].checked = false;
				}
				else
				{
					form[i].checked = true;
				}
			}
		}
	}
</script>
<!-- colorpicker2 END -->

<p class='main_title'>$now_location_subtitle <span class="small_btn"><a href='http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=64' target='_blank' class='btn_small_yellow'>도움말</a></span></p>

<div class="help_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	<span class="help">도움말</span>
	<p>
	- 아래에 등록된 아이콘 이미지(PNG 파일형식 이미지)의 배경색상을 설정합니다.<br>
	- 아이콘 배경 색상 및 템플릿파일에 <strong style='color:#0080FF'>{{배경색상}}</strong> 태그명령어가 사용된 부분에 적용됩니다.<br>
	- 템플릿(HTML)파일에 {{배경색상}} 태그명령어 내용이 있으면, 현재 여기 이미지 배경색상 선택을 원하는 색상으로 선택한 후 적용을 하게되면, 템플릿파일에 설정된 색상값으로 변경하게 됩니다.<br>
	- 템플릿파일에서 그룹별로 색상을 사용하고 싶을 경우 <strong style='color:#0080FF'>{{배경색.그룹A}} ~ {{배경색.그룹K}}</strong>
	</p>
</div>

<form name='banner_frm' action='?type=reg_conf' method='post' enctype='multipart/form-data'>
<input type='hidden' name='colorpicker' size=40 value='#F3F3F3'>
<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' class='bg_style'>
	<tr>
		<th style='width:150px;'>아이콘 배경 색상</th>
		<td>
			<input type='hidden' name='group' value='$group'>
			<input id="conf_bgcolor" name="conf_bgcolor" type="text" size="13" value='$MenuConf[conf_bgcolor]' style='background-color:$MenuConf[conf_bgcolor];color:white' class='color' />
		</td>
	</tr>
	</table>
</div>
<div align='center' style='padding-bottom:20px;'><input type='submit' value='저장하기' class='btn_big_round'></div>
</form>

<script type="text/javascript">
$('.color').colorPicker({
		customBG: '#222',
		margin: '4px -2px 0',
		doRender: 'div div',
		cssAddon:'.cp-xy-slider:active {cursor:none;}',
		opacity: false
});
</script>

<div class="help_style">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>
	<span class="help">도움말</span>
	<p>
	<b>아이콘관리의 활용목적은 여기 등록된 아이콘들을 뉴스 사이트의 템플릿파일에 사용하기 위해서 추가된 기능입니다.</b><br/>
		등록된 아이콘을 템플릿파일에 적용하여 사용하실려면 아래 태그명령어 형식으로 적용하시면 됩니다.
		<font style='background-color:#DFD; border:1px solid #6A6; padding:3px 2px 0 2px;'><b>{{아이콘.<font color=red>아이콘제목명</font>}}</b></font><br/>
		위 붉은색 부분에 등록한 아이콘 제목만 넣어서 사용하시면 됩니다.<br/>
		예){{아이콘.test3}}, {{아이콘.자유게시판타이틀}}<br/><br/>
		<b>활용 예시설명 :</b> <br>이 기능을 이용하면 기존 템플릿파일 디자인 구성을 그대로 활용한다고 가정하고 각 뉴스출력부분의 이미지타이틀만 변경해서<br/>
		사용하고 싶다면, 해당 템플릿파일에 여기 등록된 아이콘들을 태그명령어를 사용하여 미리 적용시켜놓고, 나중에 해당 적용된<br/>
		부분의 타이틀 아이콘만 수정해서 사용하고 싶을 때 현재 아이콘관리의 해당 등록아이콘을 수정해서 사용하시면 유용한 기능입니다.<br/>
		아이콘을 만들때 지정색이 적용되도록 하기위해 해당부분을 투명하게 만들면 됩니다. 해당 부분을 투명하게 하면 적용할 수 없는 특수한 상황에서는<br>RGB코드 <b>R:0 G:255 B:26 (HTML색상코드 : 00ff1a)</b>코드를 사용하여 강재로 투명하게 할 수 있습니다.
	</p>
</div>


<div class='main_title'>아이콘관리
	<a href='?type=add&group=$group' class='btn_small_blue'>신규 아이콘 추가</a>
	<span class='small_btn input_style_adm' style="top:-7px">
		<form action='happy_icon_admin.php' style='margin:0;'>
		<input type='hidden' name='group' value='$group'>
			$groupSelect
			<select name="search_field">
				<option value="icon_name" $select_icon_name>이미지제목</option>
				<option value="icon_png_file" $select_icon_png_file>png파일명</option>
				<option value="icon_jpg_file" $select_icon_jpg_file>jpg파일명</option>
			</select>
			<input type='text' name='search_keyword' value='$_GET[search_keyword]' size='15' class="input_type1">
			<input type='submit' value='검색하기' class="btn_small_dark">
		</form>
	</span>
</div>

<form name="icon_copy" action="happy_icon_admin.php?type=copy" style="margin:0px;" method="post" onsubmit="return checkchk(this);">
<div id='list_style'>
	<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
	<tr>
		<th>이미지제목</th>
		<th>합성된이미지</th>
		<th style='width:100px;'>사이즈</th>
		<th style='width:40px;'>볼드</th>
		<th style='width:80px;'>정렬</th>
		<th style='width:80px;'>등록일</th>
		<th style='width:110px;'>관리툴</th>
	</tr>

END;


		$WHERE	= ( $group == '' )? "" : " WHERE `group`='$group' ";

		if ( $_GET['search_keyword'] != '' )
		{
			if ( $_GET['search_field'] == "icon_name" )
			{
				$WHERE	.= $WHERE == '' ? ' WHERE ' : ' AND ';
				$WHERE	.= " icon_name like '%$_GET[search_keyword]%' ";
			}
			else if ( $_GET['search_field'] == "icon_png_file" )
			{
				$WHERE	.= $WHERE == '' ? ' WHERE ' : ' AND ';
				$WHERE	.= " icon_png_file like '%$_GET[search_keyword]%' ";
			}
			else if ( $_GET['search_field'] == "icon_jpg_file" )
			{
				$WHERE	.= $WHERE == '' ? ' WHERE ' : ' AND ';
				$WHERE	.= " icon_jpg_file like '%$_GET[search_keyword]%' ";
			}
		}

		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 20;

		$Sql	= "select count(*) from $happy_icon_list $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Count	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 6;

		$searchMethod	= "&group=$group&search_keyword=$_GET[search_keyword]";
		$searchMethod	.= "&search_field=$_GET[search_field]";

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################




		$Sql	= "SELECT * FROM $happy_icon_list $WHERE ORDER BY number desc LIMIT $start,$scale";
		$Record	= query($Sql);
		#echo $Sql;


		while ( $Data = happy_mysql_fetch_array($Record) )
		{

			$Data[reg_date]	= substr($Data[reg_date],0,10);
			$Data['checkbox'] = '<input type="checkbox" name="chk[]" style="width:13px; height:13px; vertical-align:middle;" value="'.$Data['number'].'">';

			echo "
				<tr>
					<td>$Data[checkbox] $Data[icon_name] $reg_button</td>
					<td><div style='max-width:380px; height:50px; padding:3px 0 3px 10px; border:0px solid red; overflow:hidden;' class='table_bd'><img src='../$Data[icon_jpg_file]' align='absmiddle' style='max-height:100%'></div></td>
					<td style='text-align:center;'>$Data[icon_width] X $Data[icon_height]</td>
					<td style='text-align:center;'>$Data[icon_border]</td>
					<td style='text-align:center;'>$Data[icon_align]</td>
					<td style='text-align:center;'>$Data[reg_date]</td>
					<td style='text-align:center;'>
						<a href='?type=add&group=$Data[group]&number=$Data[number]&start=$start&search_order=$search_order&keyword=$keyword' class='btn_small_red' style='display:inline-block !important; width:36px;'>수정</a><a href='#1' onClick=review_del('$Data[number]','$Data[group]') class='btn_small_dark' style='display:inline-block !important; width:36px; margin-left:3px;'>삭제</a><a href='./happy_icon_admin_download.php?file_name=$Data[icon_png_file]' class='btn_small_blue' style='display:block; width:93px; margin-top:3px; display:block !important'>PNG다운</a><a href='javascript:void(0);' onClick=cripboard_copy('$Data[icon_jpg_file]') class='btn_small_green' style='display:block; width:93px; margin-top:3px; display:block !important'>링크복사</a><a href='javascript:void(0);' onClick=cripboard_copy('$Data[icon_png_file]') class='btn_small_orange' style='display:block; width:93px; margin-top:3px; display:block !important'>원본링크</a>
					</td>
				</tr>
			";
		}
		echo "
			</table>
		</div>
		<div align='center' style='padding:20px 0 20px 0;'>$paging</div>

		<div class='search_style'>
			<table cellspacing='0' cellpadding='0' style='width:100%;'>
			<tr>
				<td class='input_style_adm'>선택 복사 : $groupSelectCopy <input type='submit' value='복사' class='btn_small_dark' style='height:29px'></td>
				<td align='right'><a href='?type=add&group=$group' class='btn_small_blue'>신규 아이콘 추가</a></td>
			</tr>
			</table>
		</div>
		</form>
		";


	}
	else if ( $type == "add" )							# 아이콘 작성하기 ##################################################
	{

		if ( $number != '' )		## 수정모드일때 ##
		{
			$Sql	= "SELECT * FROM $happy_icon_list WHERE number='$number' ";
			$Data	= happy_mysql_fetch_array(query($Sql));



			$button_title				= '수정';
			$button_img					= 'img/btn_reg_complete2.gif';

			$icon_png	= "<br><img src='../$Data[icon_png_file]' >";
		}
		else						## 새로작성할때 ##
		{
			$Data['menu_sort']			= '1';
			$Data['menu_point_color']	= '127FAA';
			$Data['menu_text_color']	= 'FF0000';

			$button_title				= '등록';
			$button_img					= 'img/btn_reg_complete2.gif';

			$icon_png					= '';
			$Data['icon_align']			= 'absmiddle';
			$Data['icon_border']		= '0';
		}

		if ( $_GET['parent'] != '' )
		{
			$Sql	= "SELECT menu_name FROM $happy_icon_list WHERE menu_parent='$_GET[parent]' AND menu_depth=0";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			$addMessage	= "<br>[<font color='red'><b>$Tmp[0]</b></font> 하부에 아이콘를 등록합니다.]";
		}

		$hidden_TR		= '';
		$onload_script	= '';
		if ( ( $number == '' && $_GET['parent'] == '' ) || ( $number != '' && $Data['menu_depth'] == '0' ) )
		{
			$hidden_TR		= " style='display:none' ";
			$onload_script	= "toggle('plugin');";
		}

		$groupBox	= str_replace("__onChange__","onChange='changeGroup()'",$groupBox);
		$groupBox	= str_replace("- 그룹선택 -","그룹명직접입력",$groupBox);
		$groupBox	.= "<script>document.banner_frm.group_select.value='$Data[groupid]';changeGroup();</script>";

		$wys_url	= eregi_replace("\/$","",$wys_url);


		$group	= '';
		if ( is_array($happy_icon_group) )
		{
			$group			= $_GET['group'] == '' ? $_POST['group'] : $_GET['group'];
			$group			= ( $number != '' ) ? $Data['group'] : $group;

			$groupSelect	= "<select name='group' >";
			$groupSelect	.= "<option value=''>그룹없음</option>";

			foreach( $happy_icon_group AS $key )
			{
				$selected		= $group == $key ? 'selected' : '';
				$groupSelect	.= "<option value='$key' $selected >$key</option>";
			}
			$groupSelect	.= "</select>";
		}


		#폼출력
		echo "

			<style>
			.heightTR{height:27; padding:3 0 2 0;}
			.padding{padding:0 20 0 0;}
			</style>

			<script>

				var icon_png_file_chk	= '$number';
				function sendit( frm )
				{

					if ( frm.icon_name.value == '' )
					{
						alert('아이콘제목을 입력해주세요.');
						frm.icon_name.focus();
						return false;
					}

					if ( icon_png_file_chk == '' && frm.icon_png_file.value == '' )
					{
						alert('파일선택을 해주세요.');
						frm.icon_png_file.focus();
						return false;
					}

					if ( frm.icon_width.value == '' )
					{
						alert('생성될 아이콘 가로 크기를 입력해주세요.');
						frm.icon_width.focus();
						return false;
					}

					if ( frm.icon_height.value == '' )
					{
						alert('생성될 아이콘 세로 크기를 입력해주세요.');
						frm.icon_height.focus();
						return false;
					}


					return true;
				}
			</script>

<p class='main_title'>이미지$button_title 하기</p>

<form name='banner_frm' action='?type=reg' method='post' enctype='multipart/form-data' onSubmit='return sendit(this);'>
<input type='hidden' name='colorpicker' size=40 value='F3F3F3'>
<input type='hidden' name='number' value='$number'>
<input type='hidden' name='parent' value='$_GET[parent]'>
<input type='hidden' name='group' value='$group'>
<input type='hidden' name='start' value='$_GET[start]'>
<input type='hidden' name='search_order' value='$_GET[search_order]'>
<input type='hidden' name='keyword' value='$_GET[keyword]'>

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
	<tr>
		<th>아이콘제목</th>
		<td class='input_style_adm'><input type='text' name='icon_name' size=30 value='$Data[icon_name]' > $groupSelect</td>
	</tr>
	<tr>
		<th>합성할 PNG 파일</th>
		<td>
			<input type='file' name='icon_png_file' size='35'>
			<div style='width:780px; overflow:hidden;'>$icon_png</div>
		</td>
	</tr>
	<tr>
		<th>아이콘 크기</th>
		<td>
			<p class='short'>이미지의 크기를 설정해 주세요.</p>
			<input type='text' name='icon_width' value='$Data[icon_width]' size='3' onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'>  X <input type='text' name='icon_height' value='$Data[icon_height]' size='3' onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'>
		</td>
	</tr>
	<tr>
		<th>테두리 굵기</th>
		<td>
			<p class='short'>
				이미지 테두리 값을 설정해주요. 기본값: 0
			</p>
			<input type='text' name='icon_border' value='$Data[icon_border]' size='3' onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'>
		</td>
	</tr>
	<tr>
		<th>아이콘 정렬</th>
		<td class='input_style_adm'>
			<select name='icon_align' id='icon_align' >
				<option value='absmiddle'>absmiddle</option>
				<option value='left'>left</option>
				<option value='right'>right</option>
				<option value='texttop'>texttop</option>
				<option value='baseline'>baseline</option>
				<option value='absbottom'>absbottom</option>
				<option value='texttop'>texttop</option>
				<option value='top'>top</option>
			<option value='middle'>middle</option>
			</select>
			<script>
				document.getElementById('icon_align').value = '$Data[icon_align]';
			</script>
		</td>
	</tr>
	<tr>
		<th>추가속성입력</th>
		<td>
			<p class='short'>
				필요에 따라 IMG 태그속성 또는 스타일시트(CSS) 속성을 입력하시면 됩니다.
			</p>
			<input type='text' name='icon_option' value='$Data[icon_option]' size='50' >
		</td>
	</tr>
	</table>
</div>
<div align='center' style='padding:20px 0 20px 0;'>
<input type='submit' value='등록하기' class='btn_big'> <a onClick=\"window.location.href='?group=$_GET[group]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]';\" class='btn_big_gray'>목록보기</a></div>
</form>

		";
	}
	else if ( $type == "reg" )
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 업데이트가 불가능합니다.");
			exit;
		}
		#넘어온 변수값 정리
		$number				= $_POST['number'];
		$icon_name			= $_POST['icon_name'];
		$icon_width			= $_POST['icon_width'];
		$icon_height		= $_POST['icon_height'];
		$icon_border		= $_POST['icon_border'];
		$icon_align			= $_POST['icon_align'];
		$icon_option		= $_POST['icon_option'];
		$group				= $_POST['group'];
		$start				= $_POST['start'];
		$search_order		= $_POST['search_order'];
		$keyword			= $_POST['keyword'];



		if ( $auto_addslashe == '1' )
		{
			$icon_name			= addslashes($icon_name);
			$menu_link			= addslashes($menu_link);
		}

		$now_time				= happy_mktime();
		$rand_number			= rand(0,100);
		if ( $_FILES['icon_png_file']['name'] != '' )
		{
			$temp_name = explode(".",$_FILES['icon_png_file']['name']);
			$ext = strtolower($temp_name[sizeof($temp_name)-1]);

			if ( $ext != "png" )
			{
				error("png 파일만 등록 가능 합니다.");
				exit;
			}

			$icon_png_fileUrl		= "$happy_org_path/$skin_icon_folder/$now_time-$rand_number".".$ext";
			$icon_png_fileSrc		= "$skin_icon_folder/$now_time-$rand_number".".$ext";

			move_uploaded_file($_FILES['icon_png_file']['tmp_name'], $icon_png_fileUrl);

			$icon_png_file_Sql		.= " , icon_png_file		= '$icon_png_fileSrc'";

		}
		else if ( $number == '' )
		{
			error("PNG파일을 첨부해주세요.");
			exit;
		}



		#쿼리문 생성
		$SetSql		= "
						icon_name			= '$icon_name',
						icon_jpg_file		= '$icon_jpg_file',
						icon_width			= '$icon_width',
						icon_height			= '$icon_height',
						icon_border			= '$icon_border',
						icon_align			= '$icon_align',
						icon_option			= '$icon_option',
						`group`				= '$group'
						$icon_png_file_Sql
		";

		if ( $number == '' )
		{
			$Sql	= "
						INSERT INTO
								$happy_icon_list
						SET
								$SetSql ,
								reg_date		= now()
			";
			$okMsg	= "등록되었습니다.";
		}
		else
		{
			$Sql	= "
						UPDATE
								$happy_icon_list
						SET
								$SetSql
						WHERE
								number	= '$number'
			";
			$okMsg	= "수정되었습니다.";
		}

		#echo nl2br($Sql);exit;
		query($Sql);

		if ( $number == '' )
		{
			news_icon_maker('','number desc','1');
		}
		else
		{
			news_icon_maker("number='$number'");
		}


		gomsg($okMsg, "?group=$group&start=$start&search_order=$search_order&keyword=$keyword");


	}
	else if ( $type == "del" )							#아이콘 삭제하기 ##################################################
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 업데이트가 불가능합니다.");
			exit;
		}

		$Sql	= "DELETE FROM $happy_icon_list WHERE number='$number' ";
		query($Sql);

		gomsg("삭제되었습니다.","?group=$group");
	}
	else if ( $type == 'reg_conf' )
	{
		$conf_bgcolor	= $_POST['conf_bgcolor'];
		$group			= $_POST['group'];

		$Sql	= "SELECT number FROM $happy_menu_conf where type='$group' ORDER BY number DESC LIMIT 0,1 ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		$number	= $Tmp['number'];

		if ( $number == '' )
		{
			$Sql	= "
						INSERT INTO
								$happy_menu_conf
						SET
								type			= '$group',
								conf_bgcolor	= '$conf_bgcolor'
			";
		}
		else
		{
			$Sql	= "
						UPDATE
								$happy_menu_conf
						SET
								type			= '$group',
								conf_bgcolor	= '$conf_bgcolor'
						WHERE
								number			= '$number'
			";
		}
		#echo nl2br($Sql);exit;
		query($Sql);

		#xml_menu_create();
		news_icon_maker();

		gomsg("수정되었습니다.","happy_icon_admin.php?group=$group");
		exit;

		#echo "<pre>";
		#print_r($_POST);
		#echo "</pre>";


	}
	else if ( $type == 'copy' )
	{
		#print_r($_GET);
		#print_r($_POST);
		asort($_POST['chk']);
		if ( is_array($_POST['chk']) )
		{
			foreach($_POST['chk'] as $k => $v)
			{
				$sql = "insert into ".$happy_icon_list." ( icon_name,icon_jpg_file,icon_png_file,icon_width,icon_height,icon_border,icon_align,icon_option,`group`,reg_date ) select icon_name,icon_jpg_file,icon_png_file,icon_width,icon_height,icon_border,icon_align,icon_option,'".$_POST['group']."',now() from ".$happy_icon_list." where number = '".$v."' ";
				#echo $sql."<bR>";
				query($sql);
				news_icon_maker('','number desc','1');
			}
		}

		gomsg("복사되었습니다..","happy_icon_admin.php?group=".$_POST['group']);
	}







	#하단 공통 HTML
	echo "";


	include ("tpl_inc/bottom.php");


?>