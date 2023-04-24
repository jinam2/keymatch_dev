<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	if(!session_id()) session_start();
	$folder_name = "./upload/tmp/".session_id();

	if ( !admin_secure("정보관리") ) {
			error("접속권한이 없습니다.");
			exit;
	}

/*
	// 모바일 사용 여부 - woo
	alter table job_admin_menu add menu_mobile_use enum('y','n') default 'n' not null;
	// 미니홈 사용 여부 - woo
	alter table job_admin_menu add menu_minihome_use enum('y','n') default 'n' not null;
*/

	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################



	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);
	$group_select	= $_GET['group_select'];


	$idx			= preg_replace('/\D/', '', $_GET['idx']);
	$start			= $_GET['start'];
	$category		= $_GET['category'];
	$search_order	= $_GET['search_order'];
	$search_word	= $_GET['search_word'];

	$searchMethod	= '';
	#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
	$searchMethod	.= "&idx=$idx&category=$category&search_order=$search_order&search_word=$search_word";
	#검색값 입력완료





	if ( $type == "" )									# 메뉴 리스트출력 ################################################
	{



		echo "

		<script>
		function review_del(no)
		{
			if ( confirm('정말 삭제하시겠습니까?') )
			{
				window.location.href = '?idx=$idx&type=del&start=$start&search_order=$search_order&search_word=$search_word&number='+no;
			}
		}
		</script>

		<!--타이틀-->
		<div style='margin-bottom:5px;'>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td style='padding-left:2px;'>
					<img src='img/ico_arrow_01.gif' border='0' style='vertical-align:middle; margin-right:3px;'> <span class='item_title'><font color=#0080FF>관리자</font> 메뉴관리</span>
				</td>
				<td align='right' style='padding-right:5px;'><input type='image' src='img/btn_reg_menu.gif' value='대메뉴추가' onClick=\"location.href='?type=add$searchMethod'\" /></td>
			</tr>
			</table>
		</div>
		<!--타이틀 끝-->
		<!--// 내용을 둘러싸는 테두리 [START] //-->
		<div>
			<table cellspacing='0' style='width:100%; background:url(img/img_table_bar_A02.gif) repeat-x'>
			<tr>
				<td style='width:2px; height:30px; background:url(img/img_table_bar_A01.gif) no-repeat;'></td>
				<td class='smfont3' style='color:#FFF; text-align:center;'>메뉴제목</td>
				<td class='smfont3' style='color:#FFF; text-align:center; width:150px;'>메뉴이미지</td>
				<td class='smfont3' style='color:#FFF; text-align:center; width:50px;'>소팅</td>
				<td class='smfont3' style='color:#FFF; text-align:center; width:100px;'>타겟</td>
				<td class='smfont3' style='color:#FFF; text-align:center; width:120px;'>등록일</td>
				<td class='smfont3' style='color:#FFF; text-align:center; width:110px;'>관리</td>
				<td style='width:2px; height:30px; background:url(img/img_table_bar_A03.gif) no-repeat;'></td>
			</tr>
			</table>

			<table width='100%' align='center' cellspacing='0' cellpadding='0' border='0' class=tbl_box style='margin-bottom:0px;'>
			<tr>
				<td>
					";
					admin_menu_list('세로100개','가로1개','자동','자동','homeedit_menu_list_sub.html');
					echo "
				</td>
			</tr>
			</table>
		</div>
		<div style='text-align:center; margin:20px 0 20px 0;'><input type='image' src='img/btn_reg_menu2.gif' value='대메뉴추가' onClick=\"location.href='?type=add$searchMethod'\" /></div>
		<!--// 내용을 둘러싸는 테두리 [END] //-->
		";


	}
	else if ( $type == "add" )							# 메뉴 작성하기 ##################################################
	{

		if ( $number != '' )		## 수정모드일때 ##
		{
			$Sql						= "SELECT * FROM $admin_menu WHERE number='$number' ";
			$Data						= happy_mysql_fetch_array(query($Sql));

			$Data['menu_link']			= urldecode($Data['menu_link']);

			if ( $Data['menu_image'] != '' )
			{
				$menu_image_preview			= "<div style='padding-top:5px;'><img src='$Data[menu_image]' border='0' align='absmiddle'></div>";
			}

			if ( $Data['menu_image_over'] != '' )
			{
				$menu_image_over_preview	= "<div style='padding-top:5px;'><img src='$Data[menu_image_over]' border='0' align='absmiddle'></div>";
			}

			if ( $Data['menu_icon'] != '' )
			{
				$menu_icon_preview	= "<div style='padding-top:5px;'><img src='$Data[menu_icon]' border='0' align='absmiddle'></div>";
			}

			if ( $Data['menu_left_title_image'] != '' )
			{
				$menu_left_title_image_preview	= "<div style='padding-top:5px;'><img src='$Data[menu_left_title_image]' border='0' align='absmiddle'></div>";
			}

			$button_title				= '수정';
			$button_img					= '../img/btn_modify.gif';

			$parent_check				= $Data['menu_parent'];
		}
		else						## 새로작성할때 ##
		{
			$Data['menu_sort']			= '1';
			$Data['menu_point_color']	= '127FAA';
			$Data['menu_text_color']	= '000000';
			$Data['menu_use']			= 'y';

			$button_title				= '등록';
			$button_img					= '../img/btn_regist.gif';

			$parent_check				= $_GET['parent'];
		}

		if ( $parent_check != '' && $parent_check != '0' )
		{
			$menu_image_display			= 'none';
			$menu_color_display			= '';
		}
		else
		{
			$menu_image_display			= '';
			$menu_color_display			= 'none';
		}

		${'menu_use_'.$Data['menu_use']}	= ' checked ';

		// 모바일 사용여부 - woo
		${'menu_mobile_use_'.$Data['menu_mobile_use']}		= ' checked ';
		// 미니홈 사용여부 - woo
		${'menu_minihome_use_'.$Data['menu_minihome_use']}	= ' checked ';

		if ( $_GET['parent'] != '' )
		{
			$Sql						= "SELECT menu_name FROM $admin_menu WHERE menu_parent='$_GET[parent]' AND menu_depth=0";
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


		$wys_url					= eregi_replace("\/$","",$wys_url);




		// [하부메뉴연결] 을 추가하자
		if ( $number != '' && $Data['menu_depth'] < $admin_menu_depth - 1 )
		{
			$admin_menu_type_array['menu_sub_link']	= '하부메뉴연결';
		}


		$menu_content				= $Data['menu_content'];
		$menu_editor_top			= $Data['menu_editor_top'];
		$menu_editor_bottom			= $Data['menu_editor_bottom'];


		$menu_access				= "<select name='menu_access'><option value=''>── 권한선택 ──</option>";
		for ( $i=0, $max=sizeof($adminMenuNames), $chmod_n="", $chmod_nval="", $chmod_yval="" ; $i<$max ; $i++ )
		{
			$q	= $i+1;

			if ( $Data['menu_access'] == $adminMenuNames[$i] )
			{
				$menu_access				.= "<option value='".$adminMenuNames[$i]."' selected>$adminMenuNames[$i]</option>\n";
			}
			else
			{
				$menu_access				.= "<option value='".$adminMenuNames[$i]."'>$adminMenuNames[$i]</option>\n";
			}

		}
		$menu_access				.= "</select>";

		#구분선 추가 hong
		$gubunbar_style				= "";
		if ( $_GET['mode'] == "gubunbar" )
		{
			$gubunbar_style				= " style='display:none;' ";
			$button_title				= "구분선 추가";
			$addMessage					= "";
		}

		//위지윅에디터CSS
		$editor_css = happy_wys_css("ckeditor","../");
		$editor_js = happy_wys_js("ckeditor","../");

		$editor_menu_content = happy_wys("ckeditor","가로100%","세로300","menu_content","{menu_content}","../","happycgi_normal");
		$editor_menu_editor_top = happy_wys("ckeditor","가로100%","세로300","menu_editor_top","{menu_editor_top}","../","happycgi_normal");
		$editor_menu_editor_bottom = happy_wys("ckeditor","가로100%","세로300","menu_editor_bottom","{menu_editor_bottom}","../","happycgi_normal");

		#폼출력
		echo <<<END

	<!-------------------// 메뉴수정하기 [start] //--------------------------------------------------------->
	<div style='margin-bottom:5px;'><img src='img/ico_arrow_01.gif' border='0' style='vertical-align:middle; margin-right:3px;'><span class='item_title'><font color='#0080FF'>메뉴</font> <font>$button_title</font>하기</span></div>

	$editor_css
	$editor_js

	<!--// 내용 //-->
	<form name='menu_frm' action='?type=reg' method='post' enctype='multipart/form-data' onSubmit='return sendit(this)'>
	<input type='hidden' name='colorpicker' size=40 value='F3F3F3'>
	<input type='hidden' name='number' value='$number'>
	<input type='hidden' name='parent' value='$_GET[parent]'>
	<input type='hidden' name='idx' value='$idx'>
	<input type='hidden' name='category' value='$_GET[category]'>
	<input type='hidden' name='search_order' value='$_GET[search_order]'>
	<input type='hidden' name='search_word' value='$_GET[search_word]'>
	<input type='hidden' name='mode' value='$_GET[mode]'>
	<div>
		<table cellspacing='0' style='width:100%; border:1px solid #dbdbdb; border-bottom:none;'>
		<tr>
			<td colspan='2' style='padding:5px; line-height:18px; background:url(img/bgpart_bg01.gif) repeat-x bottom; text-align:center; border-bottom:1px solid #dbdbdb;'><b>메뉴 $button_title 하기</b>$addMessage</td>
		</tr>
		<tr $gubunbar_style>
			<td style='width:150px;' class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>메뉴명</td>
			<td class='t_td2'>
				<input type='text' name='menu_name' value='$Data[menu_name]' class='input_type1'>
				<div style='margin-top:5px;'>쉼표(,) 및 세미콜론(:) 문자를 사용하시면 추출태그를 통한 메뉴를 추출시 문제가 생깁니다.</div>
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>타이틀명</td>
			<td class='t_td2'>
				<input type='text' name='menu_name_full' value='$Data[menu_name_full]' class='input_type1'>
				<div style='margin-top:5px;'>각 메뉴 상세페이지 접근시 상단에 노출되는 타이틀 입니다.</div>
			</td>
		</tr>
		<!-- 모바일 메뉴 사용여부 - woo -->
		<tr>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>모바일 메뉴</td>
			<td class='t_td2'>
				<span style='color:red;'>해당 메뉴가 모바일 구입시에만 나타나야 하는 메뉴인가요?</span>
				<br />
				<input type='radio' name='menu_mobile_use' id='menu_mobile_use_y' value='y' $menu_mobile_use_y style='vertical-align:middle;'><label for='menu_mobile_use_y' style='cursor:pointer;'> 예</label>
				<input type='radio' name='menu_mobile_use' id='menu_mobile_use_n' value='n' $menu_mobile_use_n style='vertical-align:middle;'><label for='menu_mobile_use_n' style='cursor:pointer;'> 아니오</label>
			</td>
		</tr>
		<!-- 모바일 메뉴 사용여부 - woo -->
		<!-- 미니홈 메뉴 사용여부 - woo -->
		<tr>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>미니홈 메뉴</td>
			<td class='t_td2'>
				<span style='color:red;'>해당 메뉴가 미니홈 구입시에만 나타나야 하는 메뉴인가요?</span>
				<br />
				<input type='radio' name='menu_minihome_use' id='menu_minihome_use_y' value='y' $menu_minihome_use_y style='vertical-align:middle;'><label for='menu_minihome_use_y' style='cursor:pointer;'> 예</label>
				<input type='radio' name='menu_minihome_use' id='menu_minihome_use_n' value='n' $menu_minihome_use_n style='vertical-align:middle;'><label for='menu_minihome_use_n' style='cursor:pointer;'> 아니오</label>
			</td>
		</tr>
		<!-- 미니홈 메뉴 사용여부 - woo -->
		<tr>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>사용여부</td>
			<td class='t_td2'>
				<input type='radio' name='menu_use' id='menu_use_y' value='y' $menu_use_y style='vertical-align:middle;'><label for='menu_use_y' style='cursor:pointer;'> 사용함</label>
				<input type='radio' name='menu_use' id='menu_use_n' value='n' $menu_use_n style='vertical-align:middle;'><label for='menu_use_n' style='cursor:pointer;'> 사용안함</label>
			</td>
		</tr>
		<tr>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>소팅번호</td>
			<td class='t_td2'>
				<input type='text' name='menu_sort' value='$Data[menu_sort]' size=3  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;' class='input_type1'>
				(작은수가 위로)
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>링크</td>
			<td class='t_td2'><input type='text' name='menu_link' value='$Data[menu_link]' style='width:400px; margin-bottom:5px;' class='input_type1'>
				<br>(링크안에 javascript: 단어 포함시 onClick 이벤트로 연결 됩니다. 쌍따옴표 사용 가능.)
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>소속페이지링크</td>
			<td class='t_td2'>
				<input type='text' name='menu_access_link1' value='$Data[menu_access_link1]' size=80 class='input_type1' style='margin-bottom:3px;'><br>
				<input type='text' name='menu_access_link2' value='$Data[menu_access_link2]' size=80 class='input_type1' style='margin-bottom:3px;'><br>
				<input type='text' name='menu_access_link3' value='$Data[menu_access_link3]' size=80 class='input_type1' style='margin-bottom:3px;'><br>
				<input type='text' name='menu_access_link4' value='$Data[menu_access_link4]' size=80 class='input_type1' style='margin-bottom:3px;'><br>
				<input type='text' name='menu_access_link5' value='$Data[menu_access_link5]' size=80 class='input_type1' style='margin-bottom:3px;'><br>
				※ 권한이 동일시 하게 적용이 되어야 할 링크 입력 (등록/수정/삭제등의 페이지)※
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>링크타겟</td>
			<td class='t_td2'>
				<select name='menu_target' id='menu_target'>
					<option value=''>현재창</option>
					<option value='_blank'>새창</option>
					<option value='_parent'>부모창</option>
					<option value='_top'>할아버지창</option>
				</select>
				<script>
					document.getElementById('menu_target').value = '$Data[menu_target]';
				</script>

				<UL style='margin:5px 0 0 0; line-height:18px;' class='smfont3'>
					<LI>현재창: 현재창에서 엽니다.</li>
					<LI>새창: 새 창에서 엽니다.</li>
					<LI style='color:gray;'>부모창: 현재창의 부모창에서 엽니다.</li>
					<LI style='color:gray;'>할아버지창: 현재창의 최상위창에서 엽니다.</li>
				</UL>
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td_c'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>대메뉴이미지</td>
			<td class='t_td2'>
				<input type='file' name='menu_image' size='50' class='input_type1'><br>
				$menu_image_preview
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td_c'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>대메뉴이미지<br><p style='padding-left:5px;' >(마우스오버시)</p></td>
			<td class='t_td2'>
				<input type='file' name='menu_image_over' size='50' class='input_type1'><br>
				$menu_image_over_preview
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td_c'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>좌측메뉴 타이틀이미지</td>
			<td class='t_td2'>
				<input type='file' name='menu_left_title_image' size='50' class='input_type1' > (좌측 메뉴명 상단에 출력 됩니다.)<br>
				$menu_left_title_image_preview
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td_c'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>메뉴 타이틀색상</td>
			<td class='t_td2'>
				<input type='text' name='menu_color' value='$Data[menu_color]' size=10  class='input_type1' ><br>
				<div style='margin-top:5px; line-height:16px;' class='smfont'>
					색상은 "#FFFFFF" 와 같은 웹색상코드 방식으로 기입하세요.<br>
					주요 타이틀은 색상을 기입해주셔야 강조표시가 활성화 됩니다.
				</div>
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td_c'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>아이콘</td>
			<td class='t_td2'>
				<input type='file' name='menu_icon' size='50' class='input_type1' > (메뉴명 옆에 출력 됩니다.)<br>
				$menu_icon_preview
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td_c'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>아이콘 링크</td>
			<td class='t_td2'><input type='text' name='menu_icon_link' size='50' class='input_type1'></td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>사용권한</td>
			<td class='t_td2'>$menu_access</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>짧은설명</td>
			<td class='t_td2'><input type='text' name='menu_memo' value='$Data[menu_memo]' size=90 class='input_type1'></td>
		</tr $gubunbar_style>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>내용(검색됨)</td>
			<td class='t_td2'>
				$editor_menu_content
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>상단 디자인</td>
			<td class='t_td2'>
				※ 비입력시 상단 메뉴의 내용을 표시 ※
				$editor_menu_editor_top
			</td>
		</tr>
		<tr $gubunbar_style>
			<td class='t_td'><img src='/img/icon_arrow_gray.png' alt='' border=0 style='margin:0 5px 2px 0'>하단 디자인</td>
			<td class='t_td2'>
				※ 비입력시 상단 메뉴의 내용을 표시 ※
				$editor_menu_editor_bottom
			</td>
		</tr>
		</table>
	</div>
	<div align='center' style='margin:20px 0 20px 0;'>
		<input type="image" src='img/btn_reg_complete.gif' alt='등록완료' title='등록완료' value="등록완료" style='cursor:pointer; margin-right:5px;vertical-align:middle;'>
		<img src='img/btn_reg_cancel.gif' value='취소'onClick='history.go(-1);' alt='취소' title='취소' style='cursor:pointer;'>
	</div>
	</form>
	<!-- <input type='submit' value='${button_title}하기' style='font:600 9pt; padding:3 0 2 0; background-image:url('img/banner/btn_bg.gif'); border:0 solid #5678FF; width:130; height:22;'> -->
	<!-------------------// 메뉴수정하기 [END] //--------------------------------------------------------->

END;
	}
	else if ( $type == "reg" )
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 수정이 불가능합니다.");
			exit;
		}

		#print_r2($_POST);		print_r2($_FILES);		exit;
		#넘어온 변수값 정리
		$number				= $_POST['number'];
		$menu_parent		= $_POST['parent'];


		$idx				= preg_replace('/\D/', '', $_POST['idx']);
		$start				= $_POST['start'];
		$category			= $_POST['category'];
		$search_order		= $_POST['search_order'];
		$search_word		= $_POST['search_word'];



		$_POST['menu_link'] = preg_replace("/(now_category=|area=|now_location=)(.*?)(\"|&|$)/e","urlencode_temp('\\1','\\2','\\3')",$_POST['menu_link']);

		$menu_name			= $_POST['menu_name'];
		$menu_name_full		= $_POST['menu_name_full'];
		$menu_parent		= preg_replace('/\D/', '', $_POST['parent']);
		$menu_sort			= preg_replace('/\D/', '', $_POST['menu_sort']);
		$menu_memo			= $_POST['menu_memo'];
		$menu_link			= $_POST['menu_link'];
		$menu_target		= $_POST['menu_target'];
		$menu_content		= $_POST['menu_content'];
		$menu_use			= $_POST['menu_use'];
		$menu_color			= $_POST['menu_color'];
		$menu_icon_link		= $_POST['menu_icon_link'];
		$menu_access		= $_POST['menu_access'];
		$menu_access_link1	= $_POST['menu_access_link1'];
		$menu_access_link2	= $_POST['menu_access_link2'];
		$menu_access_link3	= $_POST['menu_access_link3'];
		$menu_access_link4	= $_POST['menu_access_link4'];
		$menu_access_link5	= $_POST['menu_access_link5'];
		$menu_editor_top	= $_POST['menu_editor_top'];
		$menu_editor_bottom	= $_POST['menu_editor_bottom'];



		#echo '<pre>'; print_r($_POST); echo '</pre>'; exit;


		if ( $auto_addslashe == '1' )
		{
			$menu_name			= addslashes($menu_name);
			$menu_name_full		= addslashes($menu_name_full);
			$menu_link			= addslashes($menu_link);
		}

		// 3단계depth추가
		if ( $menu_parent == '' )
		{
			$menu_depth			= 0;
			$menu_parent		= 0;
		}
		else
		{
			$Sql				= "SELECT menu_depth FROM $admin_menu WHERE number = '$menu_parent'";
			$Tmp				= happy_mysql_fetch_array(query($Sql));

			$menu_depth			= $Tmp['menu_depth'] + 1;
		}



		#첨부된 파일
		$img_names			= Array('menu_image','menu_image_over', 'menu_icon','menu_left_title_image');
		$fileSql			= '';

		foreach ( $img_names AS $key => $img_name )
		{
			$upImageName		= $_FILES[$img_name]['name'];
			$upImageTemp		= $_FILES[$img_name]['tmp_name'];
			$now_time			= happy_mktime();

			if ( $upImageName != '' && $upImageTemp != '' )
			{

				$rand_number		= rand(1,999999);
				$rand_number2		= rand(1,999999);
				$temp_name			= explode(".",$upImageName);
				$ext				= strtolower($temp_name[sizeof($temp_name)-1]);

				if ( $ext!='jpg' && $ext!='jpeg' && $ext!='gif' && $ext!='png' )
				{
					error("등록이 불가능한 확장자 입니다.");
					exit;
				}

				$imgFileName		= "${rand_number2}${now_time}${rand_number}.$ext";

				#폴더없으면 만든다 woo
				/*
				$path_upload_folder	= $path . $wys_url . "/upload/" . $img_name . "/";
				if(!file_exists($path_upload_folder))
				{
					mkdir($path_upload_folder, 0707);
				}
				*/

				$img_url_re			= "upload/$img_name/".$imgFileName;
				$img				= "upload/$img_name/".$imgFileName;

				if ($upImageTemp != "")
				{
					if ( copy($upImageTemp,"$img_url_re") )
					{
						$fileSql			.= " , $img_name = '$img' ";
						@unlink($upImageTemp);
						@chmod($img_url_re,0777);

					}
				}
			}
		}

		#구분선 추가 hong
		$menu_gubunbar		= ( $_POST['mode'] == "gubunbar" ) ? "y" : "n";

		// 모바일 사용 여부 - woo / menu_mobile_use			= '$menu_mobile_use' 추가
		// 미니홈 사용 여부 - woo / menu_minihome_use		= '$menu_minihome_use' 추가
		#쿼리문 생성
		$SetSql				= "
								menu_name				= '$menu_name',
								menu_name_full			= '$menu_name_full',
								menu_sort				= '$menu_sort',
								menu_memo				= '$menu_memo',
								menu_link				= '$menu_link',
								menu_target				= '$menu_target',
								menu_content			= '$menu_content',
								menu_use				= '$menu_use',
								menu_color				= '$menu_color',
								menu_icon_link			= '$menu_icon_link',
								menu_access				= '$menu_access',
								menu_access_link1		= '$menu_access_link1',
								menu_access_link2		= '$menu_access_link2',
								menu_access_link3		= '$menu_access_link3',
								menu_access_link4		= '$menu_access_link4',
								menu_access_link5		= '$menu_access_link5',
								menu_editor_top			= '$menu_editor_top',
								menu_editor_bottom		= '$menu_editor_bottom',
								menu_gubunbar			= '$menu_gubunbar',
								menu_mobile_use			= '$menu_mobile_use',
								menu_minihome_use		= '$menu_minihome_use'
								$fileSql
		";

		if ( $number == '' )
		{
			$Sql				= "
									INSERT INTO
											$admin_menu
									SET
											$SetSql ,
											menu_depth		= '$menu_depth',
											menu_parent		= '$menu_parent',
											reg_date		= now()
			";
			$okMsg				= "등록되었습니다.";
		}
		else
		{
			$Sql				= "
									UPDATE
											$admin_menu
									SET
											$SetSql
									WHERE
											number	= '$number'
			";
			$okMsg				= "수정되었습니다.";
		}

		query($Sql);

		//xml_menu_create();



		if ( $number == '' )
		{
			$Sql				= "
									SELECT
											number
									FROM
											$admin_menu
									WHERE
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
			$Tmp				= happy_mysql_fetch_array(query($Sql));

			$number				= $Tmp['number'];

		}

		#gomsg($okMsg, "?");
		go("?idx=$idx&category=$category&search_order=$search_order&search_word=$search_word");


	}
	else if ( $type == "del" )							#메뉴 삭제하기 ##################################################
	{
		if ( $demo_lock )
		{
			error("데모버젼에서는 삭제가 불가능합니다.");
			exit;
		}

		$idx				= preg_replace('/\D/', '', $_GET['idx']);
		$start				= $_GET['start'];
		$search_order		= $_GET['search_order'];
		$search_word		= $_GET['search_word'];

		// 3단계depth추가
		menu_del( $_GET['number'] );

		//xml_menu_create();
		gomsg("삭제되었습니다.","?idx=$idx&start=$start&search_order=$search_order&search_word=$search_word");
	}




	function urlencode_temp($str,$str2,$str3)
	{
		$str3 = stripslashes($str3);
		return $str.urlencode($str2).$str3;
	}




	function menu_del( $mini_number )
	{
		global $admin_menu;

		$Sql	= "SELECT * FROM $admin_menu WHERE menu_parent = '$mini_number'";
		$Result	= query($Sql);

		$Sql	= "DELETE FROM $admin_menu WHERE number = '$mini_number'";
		query($Sql);

		if ( !$Result )
		{
			return;
		}
		else
		{
			while ( $Data = happy_mysql_fetch_array($Result) )
			{
				menu_del( $Data['number'] );
			}
		}
	}


	#하단 공통 HTML
//	echo "</td></tr></table>";



	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################
