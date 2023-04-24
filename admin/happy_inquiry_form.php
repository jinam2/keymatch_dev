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


	##################################################################################################################
	#  필드 정리 #### (PHP를 능숙하게 다루실줄 아시는 개발자만 수정하세요. 동일하게 Database도 변경되어야 합니다. )  #
	#  에러 발생시를 대비하여, 원본을 따로 백업해두시길 바랍니다.                                                    #
	##################################################################################################################

	#기본필드
	$field[0]	= Array(
					'user_name',		'user_phone',		'user_hphone',		'user_email',		'user_fax',
					'start_date',		'end_date',			'comment',			'user_prefix',		'user_birth_type',
					'user_birth_year',	'user_birth_month',	'user_birth_day',	'photo1',			'photo2',
					'photo3',			'user_zip',			'user_addr1',		'user_addr2',		'road_si',
					'road_gu',			'road_addr',		'road_addr2'
	);

	$fieldType[0]	= Array(
					'',					'',					'',					'',					'',
					'd',				'd',				'',					'',					'',
					'i',				'i',				'i',				'',					'',
					'',					'',					'',					'',					'',
					'',					'',					''
	);

	$fieldSure[0]	= Array(
					'y',				'y',					'',				'y',					'',
					'',					'',					'',					'',					'',
					'',					'',					'',					'',					'',
					'',					'',					'',					'',					'',
					'',					'',					''
	);

	#여유필드
	$field[1]	= Array(
					'extra1',			'extra2',			'extra3',			'extra4',			'extra5',
					'extra6',			'extra7',			'extra8',			'extra9',			'extra10',
					'extra11',			'extra12',			'extra13',			'extra14',			'extra15',
					'extra16',			'extra17',			'extra18',			'extra19',			'extra20',
					'extra21',			'extra22',			'extra23',			'extra24',			'extra25',
					'extra26',			'extra27',			'extra28',			'extra29',			'extra30'
	);

	$fieldType[1]	= Array(
					'',					'',					'',					'',					'',
					'',					'',					'',					'',					'',
					'i',				'i',				'i',				'i',				'i',
					't',				't',				't',				't',				't',
					'',					'',					'',					'',					'',
					'',					'',					'',					'',					''
	);

	##################################################################################################################
	#  필드 정리 #### (PHP를 능숙하게 다루실줄 아시는 개발자만 수정하세요. 동일하게 Database도 변경되어야 합니다. )  #
	#  에러 발생시를 대비하여, 원본을 따로 백업해두시길 바랍니다.                                                    #
	##################################################################################################################

	# 카테고리별 폼출력
	if ( $_GET['gubun'] )
	{
		$formreset				= 'no';
		$gubunTitle				= "";
		$category_upper			= "";

		if ( $_GET['gubun'] != "초기화" )
		{
			$직종명 = $TYPE[$_GET['gubun']];
			$gubunTitle				= "<span style='color:#08F;'>".$직종명."</span>";
			$category_upper			= "<input type='checkbox' name='upper_category_apply' value='Y' /> 하위직종에 동일한 폼 적용";
		}
	}
	else
	{
		$_GET['gubun']			= '초기화';
	}

	#등록된 그룹명 뽑아오기
	$sql = "select * from $type_tb order by sort_number asc";
	$result = query($sql);
	$category_options = "";
	while($row = happy_mysql_fetch_assoc($result))
	{
		$category_options.= "<option value='".$row['number']."'>".$row['type']."</option>\n\r";
	}

	$categorySelectBox		= "<select name='copy_select' id='copy_select'>";
	$categorySelectBox		.= "<option value=''>-------- 직종 선택 --------</option>";
	$categorySelectBox		.= $category_options;
	//$categorySelectBox		.= Category_loading($_GET['gubun']);
	$categorySelectBox		.= "</select>";

	#등록된 폼이 있는지 없는지 체크 없을시 초기화 정보 출력
	$Sql					= "SELECT Count(*) FROM $happy_inquiry_form WHERE gubun='$_GET[gubun]'";
	$Chk					= happy_mysql_fetch_array(query($Sql));

	if ( $Chk[0] > 0 && $formreset != 'ok' )
	{
		$queryGubun				= $_GET['gubun'];
	}
	else
	{
		$queryGubun				= '초기화';
	}

	if ( $_GET['copy_select'] != "" )
	{
		$queryGubun				=  $_GET['copy_select'];
	}

	$td_display				= $_GET['sangse'] != '1' ? " happydisplay='on' " : '';

	$maxCount				= 0;
	$tabCount				= 0;
	for ( $Cnt=0, $maxCnt=sizeof($field) ; $Cnt<$maxCnt ; $Cnt++ )
	{
		$editForm[$Cnt]			= '';
		$tabCount++;
		for ( $x=0,$max=sizeof($field[$Cnt]) ; $x< $max ; $x++ )
		{
			$i						= $maxCount;
			$maxCount++;
			$fieldName				= $field[$Cnt][$x];

			$Sql					= "SELECT * FROM $happy_inquiry_form WHERE field_name='$fieldName' AND gubun='$queryGubun' ";
			$Values					= happy_mysql_fetch_array(query($Sql));

			if ( $Values['field_group'] == '' )
			{
				$Values['field_group']	= $defaultGroup[$Cnt];
			}

			switch ( $fieldType[$Cnt][$x] )
			{
				case "i":	$fieldColor = '#ff0000';break;
				case "e":	$fieldColor = '#0000ff';break;
				case "t":	$fieldColor = '#007403';break;
				case "d":	$fieldColor = '#A100CF';break;
				default :	$fieldColor = '#000000';break;
			}

			$sureInputOnclick			= "";
			if ( $fieldSure[$Cnt][$x] == 'y' )
			{
				$sureInputOnclick			= " onClick=\"alert('이름,연락처,이메일은 반드시 입력하여야 합니다.'); this.checked = true;\" ";
			}

			$Values['field_sureInput']	= $Values['field_sureInput'] == 'y' ? 'checked' : '';
			$Values['field_use']		= $Values['field_use'] == 'y' ? 'checked' : '';

			#테스트
			#$field_noEdit[$Cnt][$x]	= '';
			#$Values[field_title]	= $fieldName;
			#$Values[field_sort]	= $maxCount * 10;

			$tabIndex	= ( $tabCount * 10 ) + 1;

			//싱글,더블 쿼테이션 때문에 추가됨 2011-01-31 kad
			$Values['field_style'] = htmlspecialchars(stripslashes($Values['field_style']));

			$editForm[$Cnt]	.= <<<END
			<tr>
				<td class='bg_green' style="padding-right:10px">
				<input type=hidden name='field_name_$i' value='$fieldName'>
				<input type=hidden name='fieldIndex_$i' value='$i'>
				<input type=text name='field_title_$i' class=input_Box value='$Values[field_title]' size=12 tabindex='".$tabIndex++."' style='width:99%; '></td>
				<td align='center'><input type=checkbox name='field_use_$i' value='Y' $Values[field_use] tabindex='".$tabIndex++."' ONMOUSEOVER="ddrivetip('필드사용 여부','#FFEEEE','70')" ONMOUSEOUT="hideddrivetip()"></td>
				<td align='center'>
					<input type=checkbox name='field_sureInput_$i' value='Y' $Values[field_sureInput] tabindex='".$tabIndex++."' ONMOUSEOVER="ddrivetip('필수입력 여부','','70')" ONMOUSEOUT="hideddrivetip()" $sureInputOnclick>
				</td>
				<td  style='background:#eff8f9;'><input type=text name='fieldNameView_$i' class=input_Box value='$fieldName' size=9 readonly  style='width:90%; border:0px solid red; background:#eff8f9; color:$fieldColor' ></td>
				<td $td_display class='input_style_adm'>
					<select name='field_type_$i' id='field_type_$i' tabindex='".$tabIndex++."'>
						<option value='text'>TEXT</option>
						<option value='text_num'>TEXT(숫자만)</option>
						<option value='password'>PASSWORD</option>
						<option value='file'>FILE(image)</option>
						<option value='textarea'>TEXTAREA</option>
						<option value='radio'>RADIO BUTTON</option>
						<option value='checkbox'>CHECK BOX</option>
						<option value='select'>SELECT BOX</option>
					</select>
					<script>
						document.getElementById('field_type_$i').value	= '$Values[field_type]';
					</script>
				</td>
				<td><input type=text name='field_template_$i' size=15 value='$Values[field_template]' tabindex='".$tabIndex++."' ONMOUSEOVER="ddrivetip('SELECTBOX, CHECKBOX, RADIO, FILE 제외한 나머지 입력형식 폼출력 태그명<table width=100% border=1 cellpadding=1 cellspacing=1><tr><td>폼출력</td><td>:</td><td>%폼%</td></tr><tr><td>필수아이콘 종류1</td><td>:</td><td>%아이콘1%</td></tr><tr><td>필수아이콘 종류2</td><td>:</td><td>%아이콘2%</td></tr></table>','','200')" ONMOUSEOUT="hideddrivetip()"></td>
				<td $td_display><input type=text name='field_option_$i' size=15 value='$Values[field_option]' tabindex='".$tabIndex++."' ONMOUSEOVER="ddrivetip('SELECTBOX, CHECKBOX, RADIO 일 경우 <br>항목 입력형식은 텍스트:값,텍스트:값,...<br>예) 가을:1,겨울:2,여름:3','','200')" ONMOUSEOUT="hideddrivetip()"></td>
				<td $td_display><input type=text name='field_style_$i' size=15 value="$Values[field_style]" tabindex='".$tabIndex++."' ONMOUSEOVER="ddrivetip('폼속성, 자바스크립트 이벤트, Style(CSS) 내용 입력가능','','300')" ONMOUSEOUT="hideddrivetip()"></td>
				<td align='center'>
					<select name='field_group_$i' id='field_group_$i' tabindex='".$tabIndex++."'>
						<option value='메인' class=opt1>메인</option>
						<option value='서브' class=opt2>서브</option>
						<option value='기타1' class=opt3>기타1</option>
						<option value='기타2' class=opt4>기타2</option>
						<option value='기타3' class=opt5>기타3</option>
					</select>
					<script>
						document.getElementById('field_group_$i').value	= '$Values[field_group]';
					</script>
				</td>
				<td align='center'><input type=text name='field_sort_$i' size=2 value='$Values[field_sort]'  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'  tabindex='".$tabIndex++."' ONMOUSEOVER="ddrivetip('회원 가입(수정)폼에서 해당 필드를 정렬합니다.<br />큰 숫자일수록 아래로 정렬됩니다.','','250')" ONMOUSEOUT="hideddrivetip()"></td>
			</tr>
END;

		}
	}



	print <<<END

	<script language="javascript" src="../inc/lib.js"></script>
	<script language="javascript" src="../js/bubble-tooltip.js"></script>
	<link rel="stylesheet" href="../css/bubble-tooltip.css" type="text/css">

	<script type="text/javascript" src="../js/ajax_popup/ap.js"></script>
	<link href="../js/ajax_popup/ap.css" rel="stylesheet" type="text/css" />

	<script language="javascript">
		function OpenWindow(url,intWidth,intHeight) {
			window.open(url, "_blank", "width="+intWidth+",height="+intHeight+",resizable=1,scrollbars=1");
		}

		window.onload = function(){
			changeDisplay();
		}

		var happyDisplayNow	= '';

		function changeDisplay()
			{
				var obj_th	= document.getElementsByTagName('th');
				var obj	= document.getElementsByTagName('td');

				happyDisplayNow	= happyDisplayNow == '' ? 'none' : '';
				document.getElementById('happyDisplayButton').value	= happyDisplayNow == '' ? '상세설정 닫기' : '상세설정 열기';
				document.getElementById('happyDisplayButton2').value	= happyDisplayNow == '' ? '상세설정 닫기' : '상세설정 열기';

				for ( i=0 , max=obj_th.length ; i < max ; i++ )
				{
					if ( obj_th[i].getAttribute('happydisplay') != null )
					{
						obj_th[i].style.display	= happyDisplayNow;
					}
				}

				for ( i=0 , max=obj.length ; i < max ; i++ )
				{
					if ( obj[i].getAttribute('happydisplay') != null )
					{
						obj[i].style.display	= happyDisplayNow;
					}
				}
			}
	</script>

	<div class="main_title">{$gubunTitle} 문의하기 폼관리(기본필드) <span class="small_btn"><input type='button' id="happyDisplayButton" onClick="changeDisplay()" value="상세보기" class="btn_small_blue"></label></div>

	<table width="100%" border="0" cellspacing="2" cellpadding="0" style="border:1px solid #e9e9e9;">
	<tr height="30">
		<td colspan="2" bgcolor="#e9e9e9" style="padding-left:10px; font-size:13px;">필드 색상별 타입 설명</td>
	</tr>
	<tr height="26">
		<td bgcolor="#f2f2f2" width="90" style="padding-left:10px;"><b>검정색</b> 필드</td>
		<td bgcolor="#f8f8f8" style="padding-left:10px;">최대 250Byte까지 문자열 입력이 가능한 문자형(Varchar) 필드 입니다. </td>
	</tr>
	<tr height="26">
		<td bgcolor="#f2f2f2" width="90" style="padding-left:10px;"><b><font color="#ff0000">붉은색</font></b> 필드</td>
		<td bgcolor="#f8f8f8" style="padding-left:10px;">최대 11자리까지 숫자값(정수) 입력이 가능한 숫자형(Int) 필드 입니다.</td>
	</tr>
	<tr height="26">
		<td bgcolor="#f2f2f2" width="90" style="padding-left:10px;"><b><font color="#007403">초록색</font></b> 필드</td>
		<td bgcolor="#f8f8f8" style="padding-left:10px;">최대 64KB(65,535Byte)까지 문자열 입력이 가능한 텍스트형(Text) 필드 입니다. </td>
	</tr>
	<tr height="26">
		<td bgcolor="#f2f2f2" width="90" style="padding-left:10px;"><b><font color="#A100CF">보라색</font></b> 필드</td>
		<td bgcolor="#f8f8f8" style="padding-left:10px;">날짜와 시간값을 "년-월-일 시:분:초" 와 같은 형태로 저장이 가능한 날짜형(DATETIME) 필드 입니다. </td>
	</tr>
	</table>

	<br>


	<!-- 회원그룹 필드관리 (기본필드) [ start ] -->
	<form name=regiform action='happy_inquiry_form_reg.php' method=post ENCTYPE='multipart/form-data'   style=margin:0px onSubmit="return validate(this)">
	<input type=hidden name='maxCount' value='$maxCount'>
	<input type=hidden name="gubun" value='$_GET[gubun]'>

	<div id="list_style">
		<table cellspacing="0" cellpadding="0" class="bg_style table_line">
		<tr>
			<th>필드이름</th>
			<th style="width:95px;">사용여부</th>
			<th style="width:95px;">필수입력</th>
			<th style="width:100px;">필드명</th>
			<th style="width:95px;" $td_display>입력형식</th>
			<th style="width:85px;" >출력형식</th>
			<th style="width:85px;" $td_display>선택옵션</th>
			<th style="width:95px;" $td_display>속성-CSS</th>
			<th style="width:80px;">그룹</th>
			<th style="width:40px;">Sort</th>
		</tr>

		$editForm[0]

		</table>
	</div>
	<br />

	<!-- 회원그룹 필드관리 (추가필드)[ start ] -->
	<div class="main_title">{$gubunTitle} 문의하기 폼관리(추가필드) <span class='small_btn'><input type='button' id="happyDisplayButton2" onClick="changeDisplay()" value="상세보기" class="btn_small_blue"></span></div>

	<div id="list_style">
		<table cellspacing="0" cellpadding="0" class="bg_style table_line">
		<tr>
			<th>필드이름</th>
			<th style="width:95px;">사용여부</th>
			<th style="width:95px;">필수입력</th>
			<th style="width:100px;">필드명</th>
			<th style="width:95px;" $td_display>입력형식</th>
			<th style="width:85px;" >출력형식</th>
			<th style="width:85px;" $td_display>선택옵션</th>
			<th style="width:95px;" $td_display>속성-CSS</th>
			<th style="width:80px;">그룹</th>
			<th style="width:40px;">Sort</th>
		</tr>

		$editForm[1]

		</table>
	</div>

	<script>
		function copy_call()
		{
			if ( document.getElementById('copy_select').selectedIndex != 0 )
			{
				var copy_group_num	= document.getElementById('copy_select').options[document.getElementById('copy_select').selectedIndex].value;
			}
			else
			{
				alert('복사할 직종을 선택해주세요.');
				document.getElementById('copy_select').focus();
				return false;
			}
			window.location.href='?gubun=$_GET[gubun]&amp;copy_select='+copy_group_num;
		}

		function original_call()
		{
			history.go(-1);
			//window.location.href='?group_number=$_GET[group_number]';
		}
	</script>



	<center>

	$category_upper
	<br>

	<div  style='margin:25px 0px 25px 0px;'><input type=submit value='${get_title}폼 정보저장' class='btn_big'>
	<input type=reset value=' 다시작성 '  class='btn_big_gray'>
	<input type=button value='직종 리스트' onClick="window.location.href = 'type_setting.php'; "  class='btn_big_gray'></div>
	</center>

END;


	if ( $_GET['copy_select'] == '' )
	{

		echo "
			<div align='center'>$categorySelectBox <input type='button' value='선택한 폼 정보를 현재 폼으로 복사' onClick='copy_call()' class='btn_small_dark'></div>
			</form>
		";
	}
	else
	{
		$직종명 = $TYPE[$_GET['copy_select']];
		echo "
			<center>
			<table border='0' cellspacing='0' cellpadding='0' align='center' class='if_form_btn' style='margin:15px 0px 30px 0px;'>
			<tr>
				<td>
					<script>
						alert('[".$직종명."] 직종의 정보를 불러왔습니다.\\n[폼 정보저장] 버튼을 클릭하셔야 저장이 됩니다.');
					</script>
					$categorySelectBox
				</td>
				<td><input type='button' value='원래 폼 정보로 복귀' onClick='original_call()' class='form_copy'></td>
			</tr>
			</form>
			</table>
			</center>
		";
	}


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