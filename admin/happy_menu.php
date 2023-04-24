<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../class/color.php");

	if ( !admin_secure("메뉴관리") ) {
		error("접속권한이 없습니다.");
		exit;
	}

	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);
	$group_select	= $_GET['group_select'];



	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################

	//모바일솔루션
	$mobile_mode	= $_GET['mobile_mode'];
	$mobile_where	= " and mobile_mode = '$mobile_mode' ";
	$mobile_text	= '';

	if ( $mobile_mode == 'y' )
	{
		$mobile_text	= "<b style='color:blue;'>(모바일)</b>";
	}

	#메뉴아래 상단 HTML
	echo "
";

echo "

<div class='main_title'>
	메뉴 설정관리 $mobile_text
</div>
<table width=\"100%\" border='0' cellspacing='0' cellpadding='0'>
<tr>
	<td>


";


	if ( $type == "" )									# 메뉴 리스트출력 ################################################
	{



		echo "

		<script>
		function review_del(no)
		{
			if ( confirm('정말 삭제하시겠습니까?') )
			{
				window.location.href = '?type=del&mobile_mode=$mobile_mode&start=$start&search_order=$search_order&keyword=$keyword&number='+no;
			}
		}
		</script>

		<div class='help_style' style='margin-top:20px'>
			<div class='box_1'></div>
			<div class='box_2'></div>
			<div class='box_3'></div>
			<div class='box_4'></div>
			<span class='help'>도움말</span>
			<p style='text-align:left; margin-top:5px;' class='font-s'>
				메인메뉴 및 각 서브메뉴를 설정할 수 있습니다.<br>
				메인메뉴 출력 디자인은 <span style='font-weight:bold; color:#ff0000;'>happy_menu_rows.html</span> 파일에서 수정하시면 됩니다.<br>
				서브메뉴 출력 디자인은 <span style='font-weight:bold; color:#ff0000;'>happy_menu_rows_sub.html</span> 파일에서 수정하시면 됩니다.<br/>
				그 외에 출력 디자인은 해당 row파일에서 수정하시면 됩니다.<br/>
				각 대메뉴별 <span style='font-weight:bold; color:#ff0000;'>하부메뉴 생성버튼</span>을 클릭하시면 하부메뉴를 생성할 수 있습니다.<br/>
				소팅순서가 낮은 숫자일수록 우선 출력됩니다.<br/><br/>
				<!--<img src='img/358.gif' style='border:1px dashed #ddd;'>-->
			</p>
		</div>
		<div style='text-align:right; padding:20px 0'>
			<a href='?type=add&mobile_mode=$mobile_mode' class='btn_big_round'>대메뉴추가</a>
		</div>

		<!--// 내용을 둘러싸는 테두리 [START] //-->
		<div id='list_style'>
			<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
				<tr>
					<th>메뉴명</th>
					<th>소팅</th>
					<th>타겟</th>
					<th>등록일</th>
					<th>관리자툴</th>
				</tr>
		";

		//헤드헌팅 메뉴 여부 hong
		if ( $hunting_use == false )
		{
			$hunting_use_where	= " AND menu_hunting_use != 'y' ";
		}

		//내주변검색 모바일 메뉴 여부
		if ( $happy_mobile_geo_location_use == '' )
		{
			$geo_use_where		= " AND menu_geo_use != 'y' ";
		}

		$Sql	= "SELECT * FROM $happy_menu WHERE menu_depth='0' $mobile_where $hunting_use_where $geo_use_where ORDER BY menu_sort asc , number asc"; //모바일솔루션
		#echo $Sql;
		$Record	= query($Sql);
		$SqlArr	= array();

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Data['menu_language']	= $Data['menu_language'] == '1' ? '영어' : '한글';
			$Data['menu_point']		= $Data['menu_point'] == '1' ? '<font color=blue>색상사용</font>' : '사용안함';


			$nbsp			= '';


			$Data['menu_point']			= '';
			$Data['menu_point_color']	= '';

			$TR_bgcolor		= '#F0F0F0';
			$reg_button		= "&nbsp;<a href='happy_menu.php?type=add&parent=$Data[number]&mobile_mode=$mobile_mode'><img src='img/btn_add_sub_sect.gif' border='0' alt='하부섹션 생성버튼' align='absmiddle'></a>";


			switch ( $Data['menu_target'] )
			{
				case "_self" :		$Data['menu_target'] = '현재창'; break;
				case "_top" :		$Data['menu_target'] = '할아버지창'; break;
				case "_parent" :	$Data['menu_target'] = '부모창'; break;
				case "_blank" :		$Data['menu_target'] = '새창'; break;
				default :			$Data['menu_target'] = '현재창'; break;
			}




			echo "
						<tr height='35' align='left' onMouseOver=this.style.backgroundColor='#F8E0E0' onMouseOut=this.style.backgroundColor='$TR_bgcolor' bgcolor='$TR_bgcolor'>
							<td style='font-weight:bold; color:#0080ff'><font color='ef4900' >▶</font> $nbsp$Data[menu_name] $reg_button</td>
							<td style='text-align:center; width:80px;'>$Data[menu_sort]</td>
							<td style='text-align:center; width:80px;'>$Data[menu_target]</td>
							<td style='text-align:center; width:150px;'>$Data[reg_date]</td>
							<td style='text-align:center; width:150px;'>
								<a href='?type=add&number=$Data[number]&start=$start&search_order=$search_order&keyword=$keyword&mobile_mode=$mobile_mode' class='btn_small_dark'>수정</a> <a href='#1' onClick=\"review_del('$Data[number]')\"  class='btn_small_red'>삭제</a>
							</td>
						</tr>

			";


			$SqlSub		= "SELECT * FROM $happy_menu WHERE menu_depth='1' AND menu_parent='$Data[number]' $hunting_use_where $geo_use_where ORDER BY menu_sort asc , number asc";
			$RecordSub	= query($SqlSub);


			while ( $DataSub = happy_mysql_fetch_array($RecordSub) )
			{
				$DataSub['menu_language']	= $DataSub['menu_language'] == '1' ? '영어' : '한글';
				$DataSub['menu_point']		= $DataSub['menu_point'] == '1' ? '<font color=blue>배경사용</font>' : '미사용';
				$reg_button					= "&nbsp;<a href='happy_menu.php?type=add&parent=$DataSub[number]&mobile_mode=$mobile_mode'><img src='img/btn_add_sub_sect.gif' border='0' alt='하부섹션 생성버튼' align='absmiddle'></a>";

				#$SqlArr[]	= "UPDATE happy_menu SET menu_parent = '$Data[number]' WHERE number='$DataSub[number]'";


				$nbsp			= '';

				for ( $i=0, $max=$DataSub['menu_depth'] * 4 ; $i<$max ; $i++ )
				{
					$nbsp		.= '&nbsp;';
				}
				$nbsp			.= '<b style=color:#afafaf>▶</b> ';
				$TR_bgcolor		= '#FFFFFF';

				switch ( $DataSub['menu_target'] )
				{
					case "_self" :		$DataSub['menu_target'] = '현재창'; break;
					case "_top" :		$DataSub['menu_target'] = '할아버지창'; break;
					case "_parent" :	$DataSub['menu_target'] = '부모창'; break;
					case "_blank" :		$DataSub['menu_target'] = '새창'; break;
					default :			$DataSub['menu_target'] = '현재창'; break;
				}

				echo "
						<tr height='33' align='left' onMouseOver=this.style.backgroundColor='#F0F4F0' onMouseOut=this.style.backgroundColor='$TR_bgcolor' bgcolor='$TR_bgcolor'>
							<td><font color='#0080ff' style='font-weight:bold;'> $nbsp$DataSub[menu_name] $reg_button</font></td>
							<td style='text-align:center; width:80px;'>$DataSub[menu_sort]</td>
							<td style='text-align:center; width:80px;'>$DataSub[menu_target]</td>
							<td style='text-align:center; width:150px;'>$DataSub[reg_date]</td>
							<td style='text-align:center; width:150px;'><a href='?type=add&number=$DataSub[number]&start=$start&search_order=$search_order&keyword=$keyword&mobile_mode=$mobile_mode'  class='btn_small_dark'>수정</a>
							<a href='#1' onClick=\"review_del('$DataSub[number]')\" class='btn_small_gray'>삭제</a></td>
						</tr>
				";



					$SqlSub		= "SELECT * FROM $happy_menu WHERE menu_depth='2' AND menu_parent='$DataSub[number]' ORDER BY menu_sort asc , number asc";
					$RecordSub2	= query($SqlSub);


					while ( $DataSub2 = happy_mysql_fetch_array($RecordSub2) )
					{
						$DataSub2['menu_language']	= $DataSub2['menu_language'] == '1' ? '영어' : '한글';
						$DataSub2['menu_point']		= $DataSub2['menu_point'] == '1' ? '<font color=blue>배경사용</font>' : '미사용';
						$reg_button					= "";


						$nbsp			= '';

						for ( $i=0, $max=$DataSub2['menu_depth'] * 8 ; $i<$max ; $i++ )
						{
							$nbsp		.= '&nbsp;';
						}
						$nbsp			.= '<b style=color:#afafaf>▶</b> ';
						$TR_bgcolor		= '#FFFFFF';

						switch ( $DataSub2['menu_target'] )
						{
							case "_self" :		$DataSub2['menu_target'] = '현재창'; break;
							case "_top" :		$DataSub2['menu_target'] = '할아버지창'; break;
							case "_parent" :	$DataSub2['menu_target'] = '부모창'; break;
							case "_blank" :		$DataSub2['menu_target'] = '새창'; break;
							default :			$DataSub2['menu_target'] = '현재창'; break;
						}

						echo "
								<tr height='33' align='left' onMouseOver=this.style.backgroundColor='#F0F4F0' onMouseOut=this.style.backgroundColor='$TR_bgcolor' bgcolor='$TR_bgcolor'>
									<td><font color='#0080ff' style='font-weight:bold;'> $nbsp$DataSub2[menu_name] $reg_button</font></td>
									<td style='text-align:center; '>$DataSub2[menu_sort]</td>
									<td style='text-align:center; '>$DataSub2[menu_target]</td>
									<td style='text-align:center; '>$DataSub2[reg_date]</td>
									<td style='text-align:center; '><a href='?type=add&number=$DataSub2[number]&start=$start&search_order=$search_order&keyword=$keyword&mobile_mode=$mobile_mode'  class='btn_small_dark'>수정</a>
									<a href='#1' onClick=\"review_del('$DataSub2[number]')\" class='btn_small_gray' >삭제</a></td>
								</tr>
						";

					}




			}


		}

/*
		foreach($SqlArr AS $key=>$val)
		{
			query($val);
		}
		query("UPDATE happy_menu SET menu_parent=0 where menu_depth=0");
*/

		echo "
					</table>
				</div>
				<!--//모바일솔루션-->
				<div style='padding:20px 0; text-align:center'>
					<a href='?type=add&mobile_mode=$mobile_mode' class='btn_big_round'>대메뉴추가</a>
				</div>

		<!--// 내용을 둘러싸는 테두리 [END] //-->
		";


	}
	else if ( $type == "add" )							# 메뉴 작성하기 ##################################################
	{

		if ( $number != '' )		## 수정모드일때 ##
		{
			$Sql						= "SELECT * FROM $happy_menu WHERE number='$number' ";
			$Data						= happy_mysql_fetch_array(query($Sql));

			$Data['menu_link']			= urldecode($Data['menu_link']);

			$button_title				= '수정';
			$button_img					= '../img/btn_modify.gif';
		}
		else						## 새로작성할때 ##
		{
			$Data['menu_sort']			= '1';
			$Data['menu_point_color']	= '127FAA';
			$Data['menu_text_color']	= '000000';

			$button_title				= '등록';
			$button_img					= '../img/btn_regist.gif';
		}

		if ( $_GET['parent'] != '' )
		{
			$Sql						= "SELECT menu_name FROM $happy_menu WHERE menu_parent='$_GET[parent]' AND menu_depth=0";
			$Tmp						= happy_mysql_fetch_array(query($Sql));

			$addMessage					= "<br>[<font color='red'><b>$Tmp[0]</b></font> 하부에 메뉴를 등록합니다.]";
		}

		$hidden_TR					= '';
		$onload_script				= '';
		if ( ( $number == '' && $_GET['parent'] == '' ) || ( $number != '' && $Data['menu_depth'] == '0' ) )
		{
			$hidden_TR					= " style='display:none' ";
			$onload_script				= "toggle('plugin');";
		}

		$hidden_TR					= " style='display:' ";

		$groupBox					= str_replace("__onChange__","onChange='changeGroup()'",$groupBox);
		$groupBox					= str_replace("- 그룹선택 -","그룹명직접입력",$groupBox);
		$groupBox					.= "<script>document.banner_frm.group_select.value='$Data[groupid]';changeGroup();</script>";

		$wys_url					= eregi_replace("\/$","",$wys_url);


		$GetMycolor1				= color::hex2rgb("$Data[menu_point_color]") ;
		$GetMycolor2				= color::hex2rgb("$Data[menu_text_color]") ;


		# 게시판 리스트 읽어오기
		$readonly					= '';
		$board_list_link			= "<select name='board_list_link' id='board_list_link' onChange='board_list_link_change()'><option value=''>링크직접입력</option>";
		$Sql						= "SELECT tbname, board_name FROM $board_list WHERE tbname not like 'happy_package_%' ORDER BY board_name";
		$Record						= query($Sql);

		while ( $Board = happy_mysql_fetch_array($Record) )
		{
			$nowLink					= 'bbs_list.php?tb='. $Board['tbname'];
			$selected					= '';

			if ( $nowLink == $Data['menu_link'] )
			{
				$readonly					= ' readonly ';
				$selected					= ' selected ';
			}
			$board_list_link			.= "<option value='$nowLink' $selected >$Board[board_name]</option>";
		}
		$board_list_link			.= "</select>";



		# 아이콘 그룹 호출
		$group_list					= "<table width='99%' border='0' cellspacing='0' cellpadding='0' bgcolor='#dddddd'>";
		$group_count				= 0;
		foreach ( $happy_menu_icon_group AS $key => $value )
		{
			$group_count++;
			if ( $group_count > 10 )
			{
				break;
			}

			$group_del					= '';
			if ( $Data['menu_icon'.$group_count] != '' )
			{
				$Tmp						= GetImageSize('../'.$Data['menu_icon'.$group_count]);
				$group_icon_width			= ( $Tmp[0] > 150 ) ? 150 : $Tmp[0];
				$group_del					= "
												<img src='../".$Data['menu_icon'.$group_count]."' align='absmiddle' border='0' width='$group_icon_width'>
												&nbsp;
												<input type='checkbox' class='input_checkbox' name='menu_icon${group_count}_del' id='menu_icon${group_count}_del' value='ok' >
												<label for='menu_icon${group_count}_del'>파일삭제</label>
												<br>
				";
			}

			$group_list					.= "
											<tr bgcolor='white'>
												<!-- <td width='120' align='center'>$value</td> -->
												<td>$group_del<br/><input type='file' name='menu_icon${group_count}' id='menu_icon${group_count}' style='width:600px; '></td>
											</tr>
			";
		}
		$group_list					.= "</table>";


		$메인메뉴이미지 = "";

		// 1차 depth만 이미지 등록가능
		if ( $Data['menu_depth'] == 0 && $_GET['parent'] == "" && $mobile_mode != 'y' ) // 모바일솔루션
		{
			$메인메뉴이미지 = "
						<tr>
							<th>메인메뉴 이미지</th>
							<td class='input_style_adm'>
								<p class='short'>본 이미지는 메인메뉴 이미지로써 하위메뉴 생성시 사용되지 않습니다.</p>
								$group_list
							</td>
						</tr>
			";
		}


		$메뉴스타일		= '';
		if ( $menu_style_max > 0 )
		{
			$styles			= '';
			$helps			= '';
			for ( $i=1 ; $i<=$menu_style_max ; $i++ )
			{
				# 수정시 기존에 저장된 값이 뭔지 체킹하기
				$nowValues		= explode('|', $Data['style'.$i]);
				$nowValue		= Array();
				foreach ( $nowValues AS $key => $val )
				{
					$nowValue[$val]	= 'y';
				}


				# 체크박스폼 출력
				$style_sub		= "<table width='660'><tr>";
				$j				= 0;
				foreach ( $menu_styls AS $key => $val )
				{
					$checked		= ( $nowValue[$key] == 'y' )? 'checked' : '';

					if ( $j % 6 == 0 )
					{
						$style_sub		.= "</tr><tr>";
					}

					if ( $val['type'] == 'tag' )
					{
						$style_sub		.= "
											<td width='110' class='input_style_adm' valign='top'>
												<input type='checkbox' name='style_${i}[]' id='style_${i}_$j' value='$key' style='width:20px' $checked>
												<label for='style_${i}_$j'>$val[start]$val[title]$val[end]</label>
											</td>
						";
					}
					else if ( $val['type'] == 'style' )
					{
						$style_sub		.= "
											<td width='110' class='input_style_adm' valign='top'>
												<input type='checkbox' name='style_${i}[]' id='style_${i}_$j' value='$key' style='width:20px; height:20px; vertical-align:middle;' $checked>
												<label for='style_${i}_$j' style='$val[start];'>$val[title]</label> &nbsp;
											</td>
						";
					}
					$j++;
				}
				$style_sub		.= "</tr></table>";


				# 첨부된 파일 삭제루틴
				$style_del		= '';
				if ( $Data['style'.$i.'_icon'] != '' )
				{
					$Tmp			= @GetImageSize('../'.$Data['style'.$i.'_icon']);
					$Tmp_width		= ( $Tmp[0] > 150 ) ? 150 : $Tmp[0];
					$style_del		= "
										<img src='../".$Data['style'.$i.'_icon']."' align='absmiddle' border='0' width='$Tmp_width'>
										&nbsp;
										<input type='checkbox' class='input_checkbox' name='style${i}_icon_del' id='style${i}_icon_del' value='ok' >
										<label for='style${i}_icon_del'>파일삭제</label>
										<br>
					";
				}

				$style_title	= $menu_style_name[$i-1];

				$styles			.= "
									<table width='820' cellspacing='1' cellpadding='0' bgcolor='#dddddd'>
									<tr>
										<td width='140' align='center' bgcolor='white'>$style_title</td>
										<td width='680' bgcolor='white' style='padding:10px'>$style_sub</td>
									</tr>
									<tr>
										<td align='center' bgcolor='white'>$style_title<br>아이콘</td>
										<td bgcolor='white' style='padding:10px'>$style_del<input type='file' name='style${i}_icon' id='style${i}_icon' style='width:500px;'></td>
									</tr>
									</table>
									<br>
				";

				$helps			.= "$style_title : {{Menu.style${i}_start}}, {{Menu.style${i}_end}}, {{Menu.style${i}_style}}, {{Menu.style${i}_icon}}<br>";

			}


			$메뉴스타일		= "
						<th>스타일지정</th>
						<td class=tbl_box2_padding style='line-height:160%;'>
							$styles
							<hr>
							★ {{메뉴출력 태그로 호출된 ROWS파일에서 사용 할 수 있습니다.<br>
							$helps
							<br>
							<div class='help_style' style='margin:20px 0 0 0;'>
								<div class='box_1'>&nbsp;</div>
								<div class='box_2'>&nbsp;</div>
								<div class='box_3'>&nbsp;</div>
								<div class='box_4'>&nbsp;</div>
								<span class='help'>도움말</span>
								<p class='font-s'>
									사용방법 : &lt;a href='aaaaa' {{Menu.style1_style}}&gt;{{Menu.style1_start}}{{Menu.menu_name}}{{Menu.style1_end}}&lt;/a&gt; 등과 같이 사용 가능합니다<br>
									<font color='red'>※주의 : 동일한 속성을 지정시 오류가 발생할 수 있으니 설정시 주의하시길 바랍니다 ※</font>
								</p>
							</div>

						</td>
			";
		}

		$display_checked1	= $Data['display'] == '1'? 'checked' : '';
		$display_checked2	= $Data['display'] == '0'? 'checked' : '';

		$menu_hunting_use_checked_y	= $Data['menu_hunting_use'] == 'y' ? 'checked' : '';
		$menu_hunting_use_checked_c	= $Data['menu_hunting_use'] == 'c' ? 'checked' : '';
		$menu_hunting_use_checked_n	= $Data['menu_hunting_use'] == 'n' ? 'checked' : '';

		$menu_geo_use_checked_y		= $Data['menu_geo_use'] == 'y' ? 'checked' : '';
		$menu_geo_use_checked_c		= $Data['menu_geo_use'] == 'c' ? 'checked' : '';
		$menu_geo_use_checked_n		= $Data['menu_geo_use'] == 'n' ? 'checked' : '';
		$menu_geo_use_display		= ( $mobile_mode != 'y' || $happy_mobile_geo_location_use == '' ) ? 'display:none;' : '';

		if ( is_array($GetMycolor1) )
		{
			$GetMycolor1_red	= $GetMycolor1['red'];
			$GetMycolor1_blue	= $GetMycolor1['green'];
			$GetMycolor1_green	= $GetMycolor1['blue'];
		}

		#폼출력
		echo <<<END

			<style>
			.heightTR{height:27; padding:3px 0 2px 0;}
			.padding{padding:0 20px 0 0;}
			</style>


		<!-- colorpicker2-->
		<link rel="stylesheet" href="../js/colorpicker2/mooRainbow.css" type="text/css" />
		<script src="../js/colorpicker2/mootools.js" type="text/javascript"></script>
		<script src="../js/colorpicker2/mooRainbow.js" type="text/javascript"></script>
		<script type="text/javascript">

			function board_list_link_change()
			{
				var obj		= document.getElementById('board_list_link');
				var obj_in	= document.getElementById('menu_link');

				if ( obj != undefined )
				{
					var obj_sel	= obj.selectedIndex;
					var obj_val	= obj.options[obj_sel].value;

					if ( obj_val == '' )
					{
						obj_in.value	= '';
						obj_in.readOnly	= false;
					}
					else
					{
						obj_in.value	= obj_val;
						obj_in.readOnly	= true;
					}
				}
			}

			window.addEvent('load', function() {

				var ex1 = new MooRainbow('HappyPicker1', {
					'id': 'ex1',
					'wheel': true,
					'imgPath': '../js/colorpicker2/images/',
					'startColor': ['$GetMycolor1_red', '$GetMycolor1_green', '$GetMycolor1_blue'],
					'onChange': function(color) {
						$('menu_point_color').value = color.hex;
						$('menu_point_color').setStyle('background-color', color.hex);
						$('menu_preview').setStyle('background-color', color.hex); //미리보기 배경


					} ,
					'onComplete': function(color) {
						$('menu_point_color').value = color.hex;
						$('menu_point_color').setStyle('background-color', color.hex);
						$('menu_preview').setStyle('background-color', color.hex); //미리보기 배경

					}

				});
			});

			/*
			window.addEvent('load', function() {
				var ex2 = new MooRainbow('HappyPicker2', {
					'id': 'ex2',
					'imgPath': '../js/colorpicker2/images/',
					'startColor': ['$GetMycolor1_red', '$GetMycolor1_green', '$GetMycolor1_blue'],
					'onChange': function(color) {
						$('menu_text_color').value = color.hex;
						$('menu_text_color').setStyle('background-color', color.hex);
						$('menu_preview').setStyle('color', color.hex); //미리보기 글자색

					} ,
					'onComplete': function(color) {
						$('menu_text_color').value = color.hex;
						$('menu_text_color').setStyle('background-color', color.hex);
						$('menu_preview').setStyle('color', color.hex); //미리보기 글자색

					}
				});
			});
			*/

		</script>


		<!-- colorpicker2 END -->




			<!--<body onload="call_plugin();updateH('F3F3F3');$onload_script">-->
				<body>
					<form name='banner_frm' action='?type=reg' method='post' enctype='multipart/form-data'>
						<input type='hidden' name='colorpicker' size=40 value='F3F3F3'>
						<input type='hidden' name='number' value='$number'>
						<input type='hidden' name='parent' value='$_GET[parent]'>
						<!--// 모바일솔루션 // -->
						<input type='hidden' name='mobile_mode' value='$_GET[mobile_mode]'>
						<!--// 내용을 둘러싸는 테두리 [START] //-->
						<div id="box_style">
							<div class="box_1"></div>
							<div class="box_2"></div>
							<div class="box_3"></div>
							<div class="box_4"></div>
								<table cellspacing="1" cellpadding="0" class='bg_style'>
									<tr>
										<th style="width:150px">메뉴명</th>
										<td>
											<p class="short">
												쉼표(,) 및 세미콜론(:) 문자를 사용하시면 추출태그를 통한 메뉴를 추출시 문제가 생깁니다.
											</p>
											<input type='text' name='menu_name' style='width:570px;' value='$Data[menu_name]'>
										</td>
									</tr>

									<tr>
										<th>소팅번호</th>
										<td >
											<p class="short">
												메뉴 출력순서를 입력해주세요. 낮은 숫자일수록 상위 출력됩니다.
											</p>
											<input type='text' name='menu_sort' value='$Data[menu_sort]' style='width:200px;' onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'>
										</td>
									</tr>

									<tr>
										<th>링크주소</th>
										<td class="input_style_adm">
											$board_list_link
											<input type='text' name='menu_link' id='menu_link' value='$Data[menu_link]' style='width:450px;' $readonly>
										</td>
									</tr>

									<tr>
										<th>링크타겟</th>
										<td class="input_style_adm">

											<select name='menu_target' id='menu_target'>
												<option value=''>현재창</option>
												<option value='_blank'>새창</option>
												<option value='_parent'>부모창</option>
												<option value='_top'>할아버지창</option>
											</select>
											<script>
												document.getElementById('menu_target').value = '$Data[menu_target]';
											</script>
											<div class="help_style" style='margin-top:10px'>
												<div class="box_1"></div>
												<div class="box_2"></div>
												<div class="box_3"></div>
												<div class="box_4"></div>
												<span class="help">도움말</span>
												<p style="text-align:left; margin-top:5px;" class="font-s">
													현재창: 현재창에서 엽니다<br>
													새창: 새 창에서 엽니다.<br>
													부모창: 현재창의 부모창에서 엽니다.<br/>
													할아버지창: 현재창의 최상위창에서 엽니다.
												</p>
											</div>
										</td>
									</tr>

									<tr>
										<th>노출여부</th>
										<td>
											<label><input type="radio" name="display" value='1' style='width:20px; height:20px; vertical-align:middle;' $display_checked1 /> 노출</label>
											<label><input type="radio" name="display" value='0' style='width:20px; height:20px; vertical-align:middle;' $display_checked2 /> 숨김</label>
										</td>
									</tr>

									<tr style="display:$hunting_use_dis;">
										<th>헤드헌팅 메뉴 여부</th>
										<td>
											<label><input type="radio" name="menu_hunting_use" value='y' style='width:15px; height:15px; vertical-align:middle;' $menu_hunting_use_checked_y /> 헤드헌팅 메뉴</label>
											<label><input type="radio" name="menu_hunting_use" value='c' style='width:15px; height:15px; vertical-align:middle;' $menu_hunting_use_checked_c /> 대체 메뉴</label>
											<label><input type="radio" name="menu_hunting_use" value='n' style='width:15px; height:15px; vertical-align:middle;' $menu_hunting_use_checked_n /> 관련없음</label>

											<UL style='margin:8px 0 5px 0px; line-height:18px;'>
												<LI>- "헤드헌팅 메뉴" 선택시 헤드헌팅 기능 포함 버전에서 노출됩니다.
												<LI>- "대체 메뉴" 선택시 헤드헌팅 기능 미포함 버전에서 노출됩니다.
											</UL>
										</td>
									</tr>

									<tr style="$menu_geo_use_display;">
										<th>내주변검색 모바일<br/>메뉴 여부</th>
										<td>
											<label><input type="radio" name="menu_geo_use" value='y' style='width:15px; height:15px; vertical-align:middle;' $menu_geo_use_checked_y /> 내주변검색 모바일 메뉴</label>
											<label><input type="radio" name="menu_geo_use" value='c' style='width:15px; height:15px; vertical-align:middle;' $menu_geo_use_checked_c /> 대체 메뉴</label>
											<label><input type="radio" name="menu_geo_use" value='n' style='width:15px; height:15px; vertical-align:middle;' $menu_geo_use_checked_n /> 관련없음</label>

											<UL style='margin:8px 0 5px 0px; line-height:18px;'>
												<LI>- "내주변검색 모바일 메뉴" 선택시 내주변검색 모바일 기능 포함 버전에서 노출됩니다.
												<LI>- "대체 메뉴" 선택시 내주변검색 모바일 기능 미포함 버전에서 노출됩니다.
											</UL>
										</td>
									</tr>



									$메뉴스타일
									$메인메뉴이미지

								</table>
							</div>


							<table border='0' cellspacing='0' cellpadding='0' align=center style='margin-top:10px; margin:0 auto'>
								<tr>
									<td align=center >
										<input type='submit' value='등록' class='btn_big'>
										<input type='button' value='취소' class='btn_big_gray' onClick=location.href='happy_menu.php' style='curosr:pointer'>
									</td>
								</tr>
							</table>
						</form>


					<!--// 내용을 둘러싸는 테두리 [END] //-->

<!-------------------// 메뉴수정하기 [END] //--------------------------------------------------------->

END;
	}
	else if ( $type == "reg" )
	{
		#print_r2($_POST);exit;
		if ( $demo_lock )
		{
			error("데모버젼에서는 수정이 불가능합니다.");
			exit;
		}
		#넘어온 변수값 정리
		$number				= $_POST['number'];
		$menu_name			= $_POST['menu_name'];
		$menu_parent		= $_POST['parent'];
		$menu_sort			= $_POST['menu_sort'];

		//모바일솔루션
		$mobile_mode		= $_POST['mobile_mode'];

		function urlencode_temp($str,$str2,$str3) {

			$str3 = stripslashes($str3);

			return $str.urlencode($str2).$str3;
		}


		$_POST['menu_link'] = preg_replace("/(now_category=|area=|now_location=)(.*?)(\"|&|$)/e","urlencode_temp('\\1','\\2','\\3')",$_POST['menu_link']);





		$menu_link			= $_POST['menu_link'];
		$menu_target		= $_POST['menu_target'];
		$menu_language		= $_POST['menu_language'];
		$menu_point			= $_POST['menu_point'];
		$menu_point_color	= $_POST['menu_point_color'];
		$menu_text_color	= $_POST['menu_text_color'];
		$display			= $_POST['display'];

		//헤드헌팅 메뉴 여부
		$menu_hunting_use	= $_POST['menu_hunting_use'];

		//내주변검색 모바일 메뉴 여부
		$menu_geo_use		= $_POST['menu_geo_use'];


		if ( $auto_addslashe == '1' )
		{
			$menu_name			= addslashes($menu_name);
			$menu_link			= addslashes($menu_link);
		}

		if ( $menu_parent == '' )
		{
			$menu_parent	= 0;
			$menu_depth		= 0;

		}
		else
		{
			$Sql	= "SELECT menu_depth FROM $happy_menu WHERE number='$menu_parent'";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			$menu_depth		= $Tmp['menu_depth']+1;
		}





		########### 스타일 관련 저장루틴 ###########
		if ( $number != '' )
		{
			$Data				= happy_mysql_fetch_array(query("SELECT * FROM $happy_menu WHERE number='$number'"));
			#print_r2($Data);
		}

		$group_msg		= '';
		$style_icon_Sql	= '';
		if ( $menu_style_max > 0 )
		{
			for ( $i=1 ; $i<=$menu_style_max ; $i++ )
			{
				# 체크박스로 넘어온값 저장
				$style_now				= @implode('|', (array)  $_POST['style_'.$i]);
				$style_icon_Sql			.= " , style${i} = '$style_now' ";


				# 기존 첨부파일 삭제
				if ( $_POST['style'.$i.'_icon_del'] == 'ok' && $number != '' )
				{
					unlink('../'.$Data['style'.$i.'_icon']);
					query("UPDATE $happy_menu SET style${i}_icon = '' WHERE number='$number' ");
				}

				# 새 첨부파일 처리
				if ( $_FILES['style'.$i.'_icon']['name'] != '' )
				{
					$rand					= happy_mktime() . rand(10000,99999);
					$temp_name				= explode(".",$_FILES['style'.$i.'_icon']['name']);
					$ext					= strtolower($temp_name[sizeof($temp_name)-1]);

					if ( $ext != 'jpg' && $ext != 'gif' && $ext != 'png' )
					{
						$group_msg	= "<script>alert('jpg , gif, png 파일만 등록 가능 합니다. \\n첨부안된 파일은 수정을 통해 재업로드를 해주세요.');</script>";
					}

					$menu_icon_fileUrl		= "$happy_org_path/$happy_menu_icon_group_folder/style_icon_$rand-$i".".$ext";
					$menu_icon_fileSrc		= "$happy_menu_icon_group_folder/style_icon_$rand-$i".".$ext";

					move_uploaded_file($_FILES['style'.$i.'_icon']['tmp_name'], $menu_icon_fileUrl);

					$style_icon_Sql			.= " , style${i}_icon	= '$menu_icon_fileSrc'";
				}


			}
		}
		########### 스타일 관련 저장루틴 끝 ###########



		#쿼리문 생성
		$SetSql			= "
							#모바일솔루션
							mobile_mode			= '$mobile_mode',

							display				= '$display',

							menu_name			= '$menu_name',
							menu_sort			= '$menu_sort',
							menu_link			= '$menu_link',
							menu_target			= '$menu_target',
							menu_language		= '$menu_language',
							menu_point			= '$menu_point',
							menu_point_color	= '$menu_point_color',
							menu_text_color		= '$menu_text_color',
							menu_hunting_use	= '$menu_hunting_use',
							menu_geo_use		= '$menu_geo_use'
							$style_icon_Sql
		";



		if ( $number == '' )
		{
			$Sql			= "
								INSERT INTO
										$happy_menu
								SET
										$SetSql ,
										menu_depth		= '$menu_depth',
										menu_parent		= '$menu_parent',
										reg_date		= now()
			";
			$okMsg			= "등록되었습니다.";
		}
		else
		{
			$Sql			= "
								UPDATE
										$happy_menu
								SET
										$SetSql
								WHERE
										number	= '$number'
			";
			$okMsg			= "수정되었습니다.";
		}

		#echo nl2br($Sql);exit;
		query($Sql);

		//xml_menu_create();



		if ( $number == '' )
		{
			$Sql			= "
								SELECT
										number
								FROM
										$happy_menu
								WHERE
										mobile_mode		= '$mobile_mode' #모바일솔루션
										AND
										menu_name		= '$menu_name'
										AND
										menu_sort		= '$menu_sort'
										AND
										menu_depth		= '$menu_depth'
										AND
										menu_parent		= '$menu_parent'
								ORDER BY
										number DESC
								LIMIT
										0,1
			";
			$Tmp			= happy_mysql_fetch_array(query($Sql));

			$number			= $Tmp['number'];

		}



		# 노출 아이콘 업로드
		$Data				= happy_mysql_fetch_array(query("SELECT * FROM $happy_menu WHERE number='$number'"));
		$group_count		= 0;
		#$group_msg			= '';
		$menu_icon_file_Sql	= '';
		foreach ( $happy_menu_icon_group AS $key => $value )
		{
			$group_count++;
			if ( $group_count > 10 )
			{
				break;
			}

			if ( $_POST['menu_icon'.$group_count.'_del'] == 'ok' )
			{
				@unlink('../'.$Data['menu_icon'.$group_count]);
				query("UPDATE $happy_menu SET menu_icon${group_count} = '' WHERE number='$number' ");
			}

			if ( $_FILES['menu_icon'.$group_count]['name'] != '' )
			{
				$temp_name = explode(".",$_FILES['menu_icon'.$group_count]['name']);
				$ext = strtolower($temp_name[sizeof($temp_name)-1]);

				if ( $ext != 'jpg' && $ext != 'gif' && $ext != 'png' )
				{
					$group_msg	= "<script>alert('jpg , gif, png 파일만 등록 가능 합니다. \\n첨부안된 파일은 수정을 통해 재업로드를 해주세요.');</script>";
				}

				$menu_icon_fileUrl		= "$happy_org_path/$happy_menu_icon_group_folder/menu_icon_$number-$group_count".".$ext";
				$menu_icon_fileSrc		= "$happy_menu_icon_group_folder/menu_icon_$number-$group_count".".$ext";

				move_uploaded_file($_FILES['menu_icon'.$group_count]['tmp_name'], $menu_icon_fileUrl);

				$menu_icon_file_Sql		.= ( $menu_icon_file_Sql == '' ) ? '' : ',';
				$menu_icon_file_Sql		.= " menu_icon${group_count}	= '$menu_icon_fileSrc'";

			}

		}

		if ( $menu_icon_file_Sql != '' )
		{
			$Sql	= "UPDATE $happy_menu SET $menu_icon_file_Sql WHERE number='$number' ";
			query($Sql);
		}

		if ( $group_msg != '' )
		{
			echo $group_msg;
		}

		#echo $Sql;exit;



		#gomsg($okMsg, "?");
		go("?mobile_mode=$mobile_mode");


	}
	else if ( $type == "del" )							#메뉴 삭제하기 ##################################################
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 삭제가 불가능합니다.");
			exit;
		}
		$Sql	= "SELECT menu_depth,menu_parent FROM $happy_menu WHERE number='$number'";
		$Tmp	= happy_mysql_fetch_array(query($Sql));
		$depth	= $Tmp[0];
		$parent	= $Tmp[1];

		$Sql	= "DELETE FROM $happy_menu WHERE number = '$number' ";
		query($Sql);

		if ( $depth == '0' )
		{
			$sql		= "select number from $happy_menu where menu_parent = '$number'";
			$record		= query($sql);
			while ( $rows = happy_mysql_fetch_assoc($record) )
			{
				$sql		= "delete from $happy_menu where menu_parent = '$rows[number]' ";
				query($sql);
			}
		}

		$Sql		= "DELETE FROM $happy_menu WHERE menu_parent = '$number' ";
		query($Sql);

		//xml_menu_create();
		gomsg("삭제되었습니다.","?mobile_mode=$mobile_mode");
	}










	#하단 공통 HTML
	echo "</td></tr></table>";



	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################


?>