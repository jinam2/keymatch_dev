<?

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	#$left_menu_display = 'none';

	if ( !admin_secure("회원관리") )
	{
		error("접속권한이 없습니다.");
		exit;
	}
/*
CREATE TABLE happy_member_field (
 number int not null auto_increment primary key,
 field_name varchar(50) not null default '',
 field_title varchar(50) not null default '',
 field_use enum('y','n','admin') not null default 'y',
 field_sureInput enum('y','n') not null default 'n',
 field_type varchar(10) not null default '',
 field_template text not null default '',
 field_option varchar(250) not null default '',
 field_style varchar(250) not null default '',
 field_group varchar(20) not null default '',
 field_sort tinyint not null default 0,
 key(field_name),
 key(field_use),
 key(field_group)
);

ALTER TABLE happy_member_field ADD field_modify enum('y','n') not null default 'n' AFTER field_use;
ALTER TABLE happy_member_field ADD field_view enum('y','n') not null default 'n' AFTER field_modify;

CREATE TABLE happy_member_out (
 number int not null auto_increment primary key,
 out_id varchar(50) not null default '',
 out_date datetime not null default '',
 out_ip varchar(15) not null default '',
 key(out_id)
);

CREATE TABLE happy_member_nick_history (
 number int not null auto_increment primary key,
 user_id varchar(50) not null default '',
 user_nick varchar(20) not null default '',
 change_date datetime not null default '0000-00-00 00:00:00'
);

CREATE TABLE happy_member_state_open (
 number int not null auto_increment primary key,
 user_id varchar(50) not null default '',
 state_open enum('y','n') not null default 'n',
 change_date datetime not null default '0000-00-00 00:00:00'
);
*/
	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################





	#include "../inc/function_happy_member.php";


	#등록된 그룹명 뽑아오기
	$Sql				= "SELECT * FROM $happy_member_group WHERE number != '$_GET[group_number]'";
	$Record				= query($Sql);
	$i					= 0;
	$groupBox			= "<select name='copy_group_number' id='copy_group_number' ><option value=''>-- 회원그룹별 보기 --</option>";
	$Copy_Group_Name	= '';
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$GROUP[$Data['number']]	= $Data['group_name'];
		$selected				= $Data['number'] == $group_select ? "selected" : "";
		$groupBox				.= "<option value='$Data[number]' $selected>$Data[group_name]</option>";

		if ( $_GET['copy_group_number'] == $Data['number'] )
		{
			$Copy_Group_Name	= $Data['group_name'];
		}
	}
	$groupBox	.= "</select>";


	#현재 타이틀용 yoon
	$Sql2		= "SELECT * FROM $happy_member_group WHERE number = '$_GET[group_number]'";
	$Record2		= query($Sql2);
	$groupMemberTitle = '';
	while ( $Data = happy_mysql_fetch_array($Record2) )
	{
		$groupMemberTitle =  "<span style='color:#08F;'>".$Data[group_name]."</span>";
	}


	if ( $_GET['copy_group_number'] != '' )
	{
		$group_number	= $_GET['copy_group_number'];
	}


	$td_display		= $_GET['sangse'] != '1' ? " happydisplay='on' " : '';
	$table_width	= $_GET['sangse'] != '1' ? " width='600' " : " width='900' ";

	$maxCount	= 0;
	$tabCount	= 0;
	for ( $Cnt=0, $maxCnt=sizeof($field) ; $Cnt<$maxCnt ; $Cnt++ )
	{
		$editForm[$Cnt]	='';
		$tabCount++;
		for ( $x=0,$max=sizeof($field[$Cnt]) ; $x< $max ; $x++ )
		{
			$i			= $maxCount;
			$maxCount++;
			$fieldName	= $field[$Cnt][$x];

			$Sql		= "SELECT * FROM $happy_member_field WHERE field_name='$fieldName' AND member_group='$group_number' ";
			$Values		= happy_mysql_fetch_array(query($Sql));



			if ( $Values['field_group'] == '' )
			{
				$Values['field_group']	= $defaultGroup[$Cnt];
			}

			switch ( $fieldType[$Cnt][$x] )
			{
				case "i":	$fieldColor = '#ff0000';break;
				case "e":	$fieldColor = '#0000ff';break;
				default :	$fieldColor = '#000000';break;
			}

			switch ( $fieldModify[$Cnt][$x] )
			{
				case 'n':	$fieldModifyDisabled = ' disabled ';break;
				default :	$fieldModifyDisabled = '';break;
			}


			if ( $Values['number'] == '' )
			{
				if ( $fieldModifyDisabled == '' )
				{
					$Values['field_modify']	= 'y';
				}
			}


			$Values['field_sureInput']	= $Values['field_sureInput'] == 'y' ? 'checked' : '';
			$Values['field_use']		= $Values['field_use'] == 'y' ? 'checked' : '';
			$Values['field_modify']		= $Values['field_modify'] == 'y' ? 'checked' : '';
			$Values['field_view']		= $Values['field_view'] == 'y' ? 'checked' : '';
			$Values['field_use_admin']	= $Values['field_use_admin'] == 'y' ? 'checked' : '';
			$Values['admin_list_print']	= $Values['admin_list_print'] == 'y' ? 'checked' : '';


			#테스트
			#$field_noEdit[$Cnt][$x]	= '';
			#$Values[field_title]	= $fieldName;
			#$Values[field_sort]	= $maxCount * 10;

			$tabIndex	= ( $tabCount * 10 ) + 1;

			//싱글,더블 쿼테이션 때문에 추가됨 2011-01-31 kad
			$Values['field_style'] = htmlspecialchars(stripslashes($Values['field_style']));

			$text_selectd		= $Values['field_type'] == 'text' ? 'selected' : '';
			$text_num_selectd	= $Values['field_type'] == 'text_num' ? 'selected' : '';
			$password_selectd	= $Values['field_type'] == 'password' ? 'selected' : '';
			$file_selectd		= $Values['field_type'] == 'file' ? 'selected' : '';
			$textarea_selectd	= $Values['field_type'] == 'textarea' ? 'selected' : '';
			$radio_selectd		= $Values['field_type'] == 'radio' ? 'selected' : '';
			$checkbox_selectd	= $Values['field_type'] == 'checkbox' ? 'selected' : '';
			$select_selectd		= $Values['field_type'] == 'select' ? 'selected' : '';

			$메인_selected		= $Values['field_group'] == '메인' ? 'selected' : '';
			$서브_selected		= $Values['field_group'] == '서브' ? 'selected' : '';
			$기타1_selected		= $Values['field_group'] == '기타1' ? 'selected' : '';
			$이미지1_selected	= $Values['field_group'] == '이미지1' ? 'selected' : '';
			$이미지2_selected	= $Values['field_group'] == '이미지2' ? 'selected' : '';

			$editForm[$Cnt]	.= <<<END
			<tr>
				<td style='padding-right:10px;'><input type=hidden name='field_name_$i' value='$fieldName'> <input type=hidden name='fieldIndex_$i' value='$i'><input type=text name='field_title_$i' value='$Values[field_title]' tabindex='".$tabIndex++."' $optionHelp style='width:100%;'></td>

				<td style='text-align:center;' class='bg_green'><input type=checkbox name='field_use_$i' value='Y' $Values[field_use] tabindex='".$tabIndex++."' data-tooltip="happy_member_field_01_$tootip_layer_count" style='vertical-align:middle; margin-right:7px;'><input type=checkbox name='field_sureInput_$i' value='Y' $Values[field_sureInput] tabindex='".$tabIndex++."' data-tooltip="happy_member_field_02_$tootip_layer_count" style='vertical-align:middle; margin-right:7px;'><input type=checkbox name='field_modify_$i' value='Y' $Values[field_modify] tabindex='".$tabIndex++."' data-tooltip="happy_member_field_03_$tootip_layer_count" $fieldModifyDisabled style='vertical-align:middle; margin-right:7px;'><input type=checkbox name='field_view_$i' value='Y' $Values[field_view] tabindex='".$tabIndex++."' data-tooltip="happy_member_field_04_$tootip_layer_count" style='vertical-align:middle;'></td>

				<td style='text-align:center;' class='bg_yellow' $td_display><input type=checkbox name='field_use_admin_$i' value='Y' $Values[field_use_admin] tabindex='".$tabIndex++."' data-tooltip="happy_member_field_05_$tootip_layer_count" style='vertical-align:middle; margin-right:7px;'><input type=checkbox name='admin_list_print_$i' value='Y' $Values[admin_list_print] tabindex='".$tabIndex++."' data-tooltip="happy_member_field_06_$tootip_layer_count" style='vertical-align:middle;'></td>

				<td><input type=text name='fieldNameView_$i' value='$fieldName' readonly style='width:90px; color:$fieldColor' ></td>

				<td $td_display>
					<select name='field_type_$i' id='field_type_$i' tabindex='".$tabIndex++."'>
						<option value='text' $text_selectd>TEXT</option>
						<option value='text_num' $text_num_selectd>TEXT(숫자만)</option>
						<option value='password' $password_selectd>PASSWORD</option>
						<option value='file' $file_selectd>FILE(image)</option>
						<option value='textarea' $textarea_selectd>TEXTAREA</option>
						<option value='radio' $radio_selectd>RADIO BUTTON</option>
						<option value='checkbox' $checkbox_selectd>CHECK BOX</option>
						<option value='select' $select_selectd>SELECT BOX</option>
					</select>
				</td>

				<td $td_display><input type=text name='field_template_$i' size=15 value='$Values[field_template]' tabindex='".$tabIndex++."' data-tooltip="happy_member_field_07_$tootip_layer_count" style='width:70px;'></td>

				<td $td_display><input type=text name='field_option_$i' value='$Values[field_option]' tabindex='".$tabIndex++."' data-tooltip="happy_member_field_08_$tootip_layer_count" style='width:70px;'></td>

				<td $td_display><input type=text class='input_type1' name='field_style_$i' value="$Values[field_style]" tabindex='".$tabIndex++."' data-tooltip="happy_member_field_09_$tootip_layer_count"  style='width:100px;'></td>

				<td class='bg_sky'>
					<select name='field_group_$i' id="field_group_$i" tabindex='".$tabIndex++."'>
						<option value='메인' $메인_selected class=opt1>메인</option>
						<option value='서브' $서브_selected class=opt2>서브</option>
						<option value='이미지1' $이미지1_selected class=opt3>이미지1</option>
						<option value='이미지2' $이미지2_selected class=opt4>이미지2</option>
						<option value='기타1' $기타1_selected class=opt5>기타1</option>
					</select>
				</td>

				<td><input type=text name='field_sort_$i' value='$Values[field_sort]'  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'  tabindex='".$tabIndex++."' data-tooltip="happy_member_field_10_$tootip_layer_count"  style='width:20px; text-align:right; padding-right:3px;'></td>

				<!-- 관리자 페이지 리스트 항목 출력시 소팅 순서 woo -->
				<td><input type="text" name="admin_list_sort_$i" style="width:20px; text-align:right; padding-right:3px;"  value="$Values[admin_list_sort]" onKeyPress="if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;" onmouseover="ddrivetip('관리자 페이지 리스트 항목 출력 여부에 따른<br />정렬 순서입니다.<br />큰 숫자 일수록 오른쪽에 정렬됩니다.','','250')" onmouseout="hideddrivetip()"></td>
				<!-- 관리자 페이지 리스트 항목 출력시 소팅 순서 woo -->
			</tr>
END;

			# NEW 툴팁
			$happy_member_field_tooltip_layer		.= "
			<div id='happy_member_field_01_$tootip_layer_count' class='atip'>필드사용 여부</div>
			<div id='happy_member_field_02_$tootip_layer_count' class='atip'>필수항목 여부</div>
			<div id='happy_member_field_03_$tootip_layer_count' class='atip'>수정권한 여부</div>
			<div id='happy_member_field_04_$tootip_layer_count' class='atip'>보기권한 여부</div>
			<div id='happy_member_field_05_$tootip_layer_count' class='atip'>관리자페이지 회원관리 수정페이지에서만 출력</div>
			<div id='happy_member_field_06_$tootip_layer_count' class='atip'>관리자페이지 회원관리 리스트항목 출력여부</div>
			<div id='happy_member_field_07_$tootip_layer_count' class='atip'>
				<table width=300 border=1 cellpadding=1 cellspacing=1>
				<tr>
					<td colspan='3'>
						SELECTBOX, CHECKBOX, RADIO, FILE 제외한 나머지 입력형식 폼출력 태그명
					</td>
				</tr>
				<tr>
					<td>폼출력</td>
					<td>:</td>
					<td>%폼%</td>
				</tr>
				<tr>
					<td>필수아이콘 종류1</td>
					<td>:</td>
					<td>%아이콘1%</td>
				</tr>
				<tr>
					<td>필수아이콘 종류2</td>
					<td>:</td>
					<td>%아이콘2%</td>
				</tr>
				</table>
			</div>
			<div id='happy_member_field_08_$tootip_layer_count' class='atip'>
				<table width=300 border=1 cellpadding=1 cellspacing=1>
				<tr>
					<td>
						SELECTBOX, CHECKBOX, RADIO 일 경우 <br>
						항목 입력형식은 텍스트:값,텍스트:값,...<br>
						예) 가을:1,겨울:2,여름:3)
					</td>
				</tr>
				</table>
			</div>
			<div id='happy_member_field_09_$tootip_layer_count' class='atip'>
				<table width=300 border=1 cellpadding=1 cellspacing=1>
				<tr>
					<td>
						폼속성, 자바스크립트 이벤트, Style(CSS) 내용 입력가능<br>
						중복체크 필요시 onKeyUp=&quot;startRequest2(this)&quot; onFocus=&quot;startRequest2(this);happyShowLayer_nick_check()&quot; onBlur=&quot;happyCloseLayer_nick_check()&quot; 추가입력
					</td>
				</tr>
				</table>
			</div>
			<div id='happy_member_field_10_$tootip_layer_count' class='atip'>다른 필드항목과 비교하여 작은 숫자일 수록 우선 출력</div>
			";

			$tootip_layer_count++;

		}
	}






print <<<END

		<script language="javascript" src="../inc/lib.js"></script>
		<script language="javascript" src="../js/bubble-tooltip.js"></script>
		<link rel="stylesheet" href="../css/bubble-tooltip.css" type="text/css">

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



		<!-- 회원그룹 필드관리 (기본필드) [ start ] -->
		<form name=regiform action='happy_member_field_reg.php' method=post ENCTYPE='multipart/form-data'   style=margin:0px onSubmit="return validate(this)">
		<input type=hidden name='maxCount' value='$maxCount'>
		<input type=hidden name=member_group value='$_GET[group_number]'>

		<p class="main_title">
			{$groupMemberTitle}그룹 필드관리 <span style="font-weight:normal;">(기본필드)</span>
			<label class="font_st_11">[user_jumin1] 필드명은 사용자 회원정보 수정시 자동으로 숨겨지게 됩니다. &nbsp;&nbsp;
			<input type='button' id="happyDisplayButton" onClick="changeDisplay()" value="상세보기" class="btn_small_dark">
			</label>
		</p>

		<div id="list_style">
			<table cellspacing="0" cellpadding="0" class="bg_style table_line">
			<tr>
				<th>필드이름</th>
				<th style="width:95px;">사용-필수-수정-보기</th>
				<th style="width:55px;" $td_display>리스트</th>
				<th style="width:100px;">필드명</th>
				<th style="width:95px;" $td_display>입력형식</th>
				<th style="width:85px;" $td_display>출력형식</th>
				<th style="width:85px;" $td_display>선택옵션</th>
				<th style="width:95px;" $td_display>속성-CSS</th>
				<th style="width:80px;">그룹</th>
				<th style="width:40px;">Sort</th>
				<!-- 관리자 페이지 리스트 항목 출력시 소팅 순서 woo -->
				<th style="width:40px;">Sort2</th>
				<!-- 관리자 페이지 리스트 항목 출력시 소팅 순서 woo -->
			</tr>
			$editForm[0]
			</table>
		</div>

		<br />
		<br />

		<!-- 회원그룹 필드관리 (추가필드)[ start ] -->
		<p class="main_title">
			{$groupMemberTitle}그룹 필드관리 <span style="font-weight:normal;">(추가필드)</span>
			<label class="font_st_11"><input type='button' id="happyDisplayButton2" onClick="changeDisplay()" value="상세보기" class="btn_small_dark"></label>
		</p>


		<div id="list_style">
			<table cellspacing="0" cellpadding="0" class="bg_style table_line">
			<tr>
				<th>필드이름</th>
				<th style="width:95px;">사용-필수-수정-보기</th>
				<th style="width:55px;" $td_display>리스트</th>
				<th style="width:100px;">필드명</th>
				<th style="width:95px;" $td_display>입력형식</th>
				<th style="width:85px;" $td_display>출력형식</th>
				<th style="width:85px;" $td_display>선택옵션</th>
				<th style="width:95px;" $td_display>속성-CSS</th>
				<th style="width:80px;">그룹</th>
				<th style="width:40px;">Sort</th>
				<!-- 관리자 페이지 리스트 항목 출력시 소팅 순서 woo -->
				<th style="width:40px;">Sort2</th>
				<!-- 관리자 페이지 리스트 항목 출력시 소팅 순서 woo -->
			</tr>
			$editForm[1]
			</table>
		</div>



		<script>
			function design_open()
			{
				document.getElementById('design_edit_close').style.display = 'none';
				document.getElementById('design_edit_open').style.display = '';
			}

			function design_close()
			{
				document.getElementById('design_edit_close').style.display = '';
				document.getElementById('design_edit_open').style.display = 'none';
			}
		</script>


		<script>
			function copy_call()
			{
				if ( document.getElementById('copy_group_number').selectedIndex != 0 )
				{
					var copy_group_num	= document.getElementById('copy_group_number').options[document.getElementById('copy_group_number').selectedIndex].value;
				}
				else
				{
					alert('복사할 카테고리를 선택해주세요.');
					document.getElementById('copy_group_number').focus();
					return false;
				}
				window.location.href='?group_number=$_GET[group_number]&copy_group_number='+copy_group_num;
			}

			function original_call()
			{
				history.go(-1);
				//window.location.href='?group_number=$_GET[group_number]';
			}
		</script>




		<div align="center" style="padding:20px 0 20px 0;">
			<input type=submit value='폼 정보저장' class='btn_big'> <input type=reset value='다시작성' class='btn_big_gray'> <input type=button value='그룹리스트 목차보기' onClick="window.location.href = 'happy_member_group.php'; "  class='btn_big_gray'>
		</div>

END;



if ( $_GET['copy_group_number'] == '' )
{

	echo "
		<div align='center'>
			$groupBox <input type='button' value='선택폼 복사하기' onClick='copy_call()' class='btn_small_stand'>
		</div>

	";

}
else
{
	echo "
		<script>
			alert('$Copy_Group_Name 그룹의 정보를 불러왔습니다.\\n[폼 정보저장] 버튼을 클릭하셔야 저장이 됩니다.');
		</script>
		<div align='center'>
			$groupBox <input type='button' value='선택폼 복사하기' onClick='copy_call()' class='btn_small_stand'>
		</div>
		</form>
	";
}








	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################
?>