<?php
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/function.php");

	include ("../inc/lib.php");
	//include ("../inc/board_function.php");

	#관리자 접속 체크 루틴
	if ( !admin_secure("환경설정") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	#관리자 접속 체크 루틴

	include ("tpl_inc/top_new.php");

	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);
	$group_select	= $_GET['group_select'];

/*
CREATE TABLE `logo_bgimage_list` (
  `number` int(11) NOT NULL auto_increment,
  `icon_name` varchar(100) character set utf8 NOT NULL default '',
  `icon_file` varchar(150) NOT NULL default '',
  `sort` int(11) NOT NULL default '0',
  `reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`number`)
)
*/

###[ YOON : 2009-05-28 ] 현재위치용 ####
if ( $type == 'add') $nowlocate_icon = '> 배경이미지 등록하기';
if ( $type == 'add' && $number) $nowlocate_icon = ' > 배경이미지 수정하기';

	#배경아래 상단 HTML
	echo "
	<p class='main_title'>$now_location_subtitle <span class='font_st_11'>본 이미지 갯수는 최대 10개로 설정하시길 권장합니다.</span>
		<span class='small_btn'><a href='?type=add' class='btn_small_blue'>배경이미지 추가</a></span>
	</p>

	";


	if ( $type == "" )									# 배경 리스트출력 ################################################
	{


		echo "

		<script>
		function review_del(no)
		{
			if ( confirm('정말 삭제하시겠습니까?') )
			{
				window.location.href = '?type=del&start=$start&search_order=$search_order&keyword=$keyword&number='+no;
			}
		}
		</script>

		<div class='help_style'>
			<div class='box_1'></div>
			<div class='box_2'></div>
			<div class='box_3'></div>
			<div class='box_4'></div>
			<span class='help'>도움말</span>
			<p><img src='img/ex27.gif'></p>
		</div>

		<div>

		<div id='list_style'>
			<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
			<tr>
				<th style='width:100px;'>배경 이미지 이름</th>
				<th >배경 이미지</th>
				<th style='width:100px;'>등록일</th>
				<th style='width:70px;'>소팅</th>
				<th style='width:50px;'>관리</th>
			</tr>

		";

		$Sql	= "SELECT * FROM $logo_bgimage_list  ORDER BY sort DESC, number desc";
		$Record	= query($Sql);

		$total	= mysql_num_rows($Record);


		$i		= 1;
		while ( $Data = happy_mysql_fetch_array($Record) )
		{

			if ( $i == 1 )
			{
				$sort_change	= "<a href='?type=sortchange&number=$Data[number]&action=minus'><img src='img/btn_ico_down.gif' border=0 alt='DOWN'></a>";
			}
			else if ( $i == $total )
			{
				$sort_change	= "<a href='?type=sortchange&number=$Data[number]&action=plus'><img src='img/btn_ico_up.gif' border=0 alt='UP'></a>";
			}
			else
			{
				$sort_change	= "<a href='?type=sortchange&number=$Data[number]&action=plus'><img src='img/btn_ico_up.gif' border=0 alt='UP'></a>
									<a href='?type=sortchange&number=$Data[number]&action=minus'><img src='img/btn_ico_down.gif' border=0 alt='DOWN'></a>";
			}

			$Data[reg_date]	= substr($Data[reg_date],0,10);


			echo "
			<tr>
				<td style='text-align:center'>$nbsp$Data[icon_name]$reg_button</td>
				<td style='text-align:left; padding-left:20px'><img src='../$Data[icon_file]' width='$ComBannerDstW' height='$ComBannerDstH' align='absmiddle'></td>
				<td style='text-align:center;'>$Data[reg_date]</td>
				<td style='text-align:center;'>$sort_change</td>
				<td style='text-align:center;'><a href='?type=add&number=$Data[number]&start=$start&search_order=$search_order&keyword=$keyword' class='btn_small_dark3'>수정</a> <a href='#1' onClick=\"review_del('$Data[number]')\" class='btn_small_red2' style='margin-top:3px'>삭제</a></td>
			</tr>
			";

			$i++;


		}

		echo "
			</table>
		</div>



		";


	}
	else if ( $type == "add" )							# 배경 작성하기 ##################################################
	{

		if ( $number != '' )		## 수정모드일때 ##
		{
			$Sql	= "SELECT * FROM $logo_bgimage_list WHERE number='$number' ";
			$Data	= happy_mysql_fetch_array(query($Sql));



			$button_title				= '수정';
			$button_img					= 'img/btn_sendit_mod.gif';

			$icon_png	= "<br><img src='../$Data[icon_file]' >";
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

			$Sql	= "SELECT max(sort) FROM $logo_bgimage_list";
			$Tmp	= happy_mysql_fetch_array(query($Sql));
			$Data['sort']	= $Tmp[0] + 1;
		}

		if ( $_GET['parent'] != '' )
		{
			$Sql	= "SELECT menu_name FROM $logo_bgimage_list WHERE menu_parent='$_GET[parent]' AND menu_depth=0";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			$addMessage	= "<br>[<font color='red'><b>$Tmp[0]</b></font> 하부에 배경를 등록합니다.]";
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

		#폼출력
		echo "
			<script>
				function sendit( frm )
				{
					//alert(frm);
					if ( frm.icon_name.value == '' )
					{
						alert('배경제목을 입력해주세요.');
						frm.icon_name.focus();
						return false;
					}

					return true;
				}
			</script>

			<form name='banner_frm' action='?type=reg' method='post' enctype='multipart/form-data' onSubmit='return sendit(this);'>
			<input type='hidden' name='colorpicker' size=40 value='F3F3F3'>
			<input type='hidden' name='number' value='$number'>
			<input type='hidden' name='parent' value='$_GET[parent]'>

			<div id='box_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>
				<table cellspacing='1' cellpadding='0' class='bg_style'>
				<tr>
					<th colspan='2'><b>배경$button_title 하기</b>$addMessage</th>
				</tr>
				<tr>
					<th style='width:150px;'>배경제목</th>
					<td><input type='text' name='icon_name' size=70 value='$Data[icon_name]'></td>
				</tr>
				<tr>
					<th>배경</th>
					<td>
						<p class='short'>
							가로($ComBannerDstW px) X 세로($ComBannerDstH px) 사이즈의 배경 이미지를 업로드하세요.
						<br> * 업로드된 배경이미지는 원본이미지를 그대로 저장합니다.
						</p>
						<input type='file' name='icon_file' size='30'>
						<br>
						$icon_png
					</td>
				</tr>
				<tr>
					<th>소팅</th>
					<td>
						<input type='text' name='sort' size=5 value='$Data[sort]'  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'>
					</td>
				</tr>
				</table>
			</div>
			<div align='center' style='padding:0 0 20px 0;'><input type='submit' value='${button_title}하기' class='btn_big'></div>
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
		$sort				= $_POST['sort'];


		if ( $auto_addslashe == '1' )
		{
			$icon_name			= addslashes($icon_name);
			$menu_link			= addslashes($menu_link);
		}

		$now_time				= happy_mktime();
		$rand_number			= rand(0,100);
		if ( $_FILES['icon_file']['name'] != '' )
		{
			$temp_name = explode(".",$_FILES['icon_file']['name']);
			$ext = strtolower($temp_name[sizeof($temp_name)-1]);

			if ( $ext != "jpg" && $ext != "gif" )
			{
				error("jpg,gif 파일만 등록 가능 합니다.");
				exit;
			}

			$icon_fileUrl		= "$path/$logo_bgimage_folder/$now_time-$rand_number".".$ext";
			$icon_fileSrc		= "$logo_bgimage_folder/$now_time-$rand_number".".$ext";

			move_uploaded_file($_FILES['icon_file']['tmp_name'], $icon_fileUrl);

			$icon_file_Sql		.= " , icon_file		= '$icon_fileSrc'";

		}
		else if ( $number == '' )
		{
			error("이미지파일을 첨부해주세요.");
			exit;
		}



		#쿼리문 생성
		$SetSql		= "
						icon_name			= '$icon_name',
						sort				= '$sort'
						$icon_file_Sql
		";

		if ( $number == '' )
		{
			$Sql	= "
						INSERT INTO
								$logo_bgimage_list
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
								$logo_bgimage_list
						SET
								$SetSql
						WHERE
								number	= '$number'
			";
			$okMsg	= "수정되었습니다.";
		}

		#echo nl2br($Sql);exit;
		query($Sql);



		gomsg($okMsg, "?");


	}
	else if ( $type == "del" )							#배경 삭제하기 ##################################################
	{
		if ( $demo_lock == 1 )
		{
			error("데모버젼에서는 업데이트가 불가능합니다.");
			exit;
		}

		$number	= $_GET['number'];
		$Sql	= "DELETE FROM $logo_bgimage_list WHERE number='$number' ";
		query($Sql);

		gomsg("삭제되었습니다.","?");
	}
	else if ( $type == 'sortchange' )
	{
		$number	= $_GET['number'];
		$action	= $_GET['action'];

		$Sql	= "SELECT sort FROM $logo_bgimage_list WHERE number='$number' ";
		$Data	= happy_mysql_fetch_array(query($Sql));

		$Sort	= $Data['sort'];

		if ( $action == 'minus' )
		{
			$SortChange	= $Sort - 1;
			query("UPDATE $logo_bgimage_list SET sort = sort+1 WHERE sort = '$SortChange' ");
			query("UPDATE $logo_bgimage_list SET sort = sort-1 WHERE number = '$number' ");
		}
		else if ( $action == 'plus' )
		{
			$SortChange	= $Sort + 1;
			query("UPDATE $logo_bgimage_list SET sort = sort-1 WHERE sort = '$SortChange' ");
			query("UPDATE $logo_bgimage_list SET sort = sort+1 WHERE number = '$number' ");
		}
		else
		{
			error('잘못된 경로로 접근하셨습니다.');
			exit;
		}
		go("?");
		exit;
	}







	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################


?>