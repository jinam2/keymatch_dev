<?

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	if ( !admin_secure("회원관리") )
	{
		error("접속권한이 없습니다.");
		exit;
	}
/*
CREATE TABLE happy_member_group (
 number int not null auto_increment primary key,
 group_name varchar(250) not null default '',
 group_member_join enum('y','n') not null default 'y',
 group_default_level int not null default 1
);

*/
	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	//include ("tpl_inc/top_side.php");
	################################################


	$mode			= $_GET["mode"];
	$search_order	= $_GET["search_order"];
	$keyword		= $_GET["keyword"];
	$nowDate		= date("Y-m-d H:i:s");


###################### 그룹 리스트 시작 #######################
	if ( $mode == "" || $mode == "list" )
	{


		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 15;
		$WHERE			= '';

		$Sql	= "select count(*) from $happy_member_group WHERE 1=1 $WHERE ";
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


		$Sql	= "SELECT * FROM $happy_member_group ORDER BY number desc LIMIT $start,$scale ";
		$Record	= query($Sql);


		echo "
			<script>
			function review_del(no)
			{
				if ( confirm('정말 삭제하시겠습니까?') )
				{
					window.location.href = '?mode=delete&start=$start&search_order=$search_order&keyword=$keyword&number='+no;
				}
			}
			</script>

			<p class='main_title'>$now_location_subtitle</p>

			<div class='help_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>
				<span class='help'>도움말</span>
				<p>
					회원그룹은 무한대로 생성이 가능합니다.<br />
					그룹별로 사용하시고자 하는 권한관리,필드관리 및 회원가입시 설정옵션등을 설정하실 수 있습니다.<br/>
					<b style='color:#000;'>비회원그룹</b>의 경우 아래의 <a href='happy_member_secure.php?group_number=900000000' style='color:#4c6191;'>비회원 권한설정</a>란에서 설정이 가능합니다.<br>
					SNS회원은 별도의 실명인증 및 회원가입을 사용하지 않습니다.&nbsp;&nbsp;<font style='font:11px 돋움; letter-spacing:-1; color:#c9c9c9;'>예) 페이스북, 구글사이트에 회원가입이 되셨다면 별도의 회원가입없이 접속이 가능합니다.</font>
				</p>
			</div>

			<div id='list_style'>
				<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
				<tr>
					<th>번호</th>
					<th>그룹명</th>
					<th>회원가입</th>
					<!-- <th>기본레벨</th> -->
					<!-- <th>실명인증</th> -->
					<!-- <th>주민번호패턴</th> -->
					<th>휴대폰인증</th>
					<th>E-mail인증</th>
					<th style='width:70px;'>권한관리</th>
					<th style='width:70px;'>필드관리</th>
					<th style='width:110px;'>관리툴</th>
				</tr>
		";

		$rowCount = 0;

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Data["group_name"]			= kstrcut($Data["group_name"], 30, "...");
			$Data[group_member_join]	= $Data[group_member_join] == 'y' ? '가입가능' : '<font color=red>가입불가능</font>';

			$Data['iso_real_name']	= ( $Data['iso_real_name'] == 'y' )? '<font color=red>사용함</font>' : '미사용';
			$Data['iso_jumin']		= ( $Data['iso_jumin'] == 'y' )? '<font color=red>사용함</font>' : '미사용';
			$Data['iso_hphone']		= ( $Data['iso_hphone'] == 'y' )? '<font color=red>사용함</font>' : '미사용';
			$Data['iso_email']		= ( $Data['iso_email'] == 'y' )? '<font color=red>사용함</font>' : '미사용';


			//$rows_color 는 top.php 에서 설정 [ YOON : 2010-06-24 ]
			$bgcolor	= ( $rowCount%2 == 0 )?"white":$rows_color;

			echo "
			<tr>
				<td style='text-align:center; height:40px'>$listNo</td>
				<td>$Data[group_name]</td>
				<td>$Data[group_member_join]</td>
				<!-- <td style='text-align:center;'>$Data[group_default_level]</td> -->
				<!-- <td class='b_border_td' style='text-align:center;'>$Data[iso_real_name]</td> -->
				<!-- <td style='text-align:center;'>$Data[iso_jumin]</td> -->
				<td style='text-align:center;'>$Data[iso_hphone]</td>
				<td style='text-align:center;'>$Data[iso_email]</td>
				<td style='text-align:center;'><a href='happy_member_secure.php?group_number=$Data[number]' class='btn_small_navy'>권한관리</a></td>
				<td class='b_border_td' style='text-align:center;'><a href='happy_member_field.php?group_number=$Data[number]' class='btn_small_dark'>필드관리</a></td>
				<td class='b_border_td' style='text-align:center;'>
					<div style='padding:5px 0 5px 0;'><a href='?mode=modify&number=$Data[number]&start=$start&search_order=$search_order&keyword=$keyword' class='btn_small_dark'>수정</a> <a href='#delete' onClick=\"review_del('$Data[number]')\" class='btn_small_stand'>삭제</a></div>
				</td>
			</tr>
			";
			$listNo--;
			$rowCount++;

		}

		echo "
				</table>
			</div>
			<div style='padding:10px 0 10px 0;'>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td align=''>
						<input type='button' value='비회원 권한설정' onClick=\"window.location.href='happy_member_secure.php?group_number=$happy_member_secure_noMember_code'\" class='btn_small_blue'>
						<input type='button' value='회원그룹추가' onClick=\"window.location.href='?mode=add'\" class='btn_small_blue'>
					</td>
					<td align='right'><a href='./happy_member.php' class='btn_small_dark'>전체회원보기</a></td>
				</tr>
				</table>
			</div>
			<div style='text-align:center; margin-top:10px;'>
				<table cellpadding='0' cellspacing='0' style='width:100%;'>
				<tr>
					<td align='center'>$paging</td>
				</tr>
				</table>
			</div>
		";



	}	############## 리스트 끝 #################


######################## 그룹 수정 시작 ###########################
	else if ( $mode == "modify" || $mode == "add" )
	{

		$jaego_attach_folder2 = "$org_path$wys_file_attach_folder";
		$thumb_jaego_attach_folder2 = "$org_path$wys_file_attach_thumb_folder";

		if (!is_dir("$jaego_attach_folder2")){
		error("첨부파일을 위한 ($jaego_attach_folder2)폴더가 존재하지 않습니다.  ");
		exit;
		}

		$oldmask = umask(0);
		if (!is_dir("$jaego_attach_folder2/$now_year")){
		mkdir("$jaego_attach_folder2/$now_year", 0777);
		}
		if (!is_dir("$jaego_attach_folder2/$now_year/$now_month")){
		mkdir("$jaego_attach_folder2/$now_year/$now_month", 0777);
		}
		if (!is_dir("$jaego_attach_folder2/$now_year/$now_month/$now_day")){
		mkdir("$jaego_attach_folder2/$now_year/$now_month/$now_day", 0777);
		}
		umask($oldmask);


		if (!is_dir("$thumb_jaego_attach_folder2")){
		error("첨부파일을 위한 ($thumb_jaego_attach_folder2)폴더가 존재하지 않습니다.  ");
		exit;
		}

		$oldmask = umask(0);
		if (!is_dir("$thumb_jaego_attach_folder2/$now_year")){
		mkdir("$thumb_jaego_attach_folder2/$now_year", 0777);
		}
		if (!is_dir("$thumb_jaego_attach_folder2/$now_year/$now_month")){
		mkdir("$thumb_jaego_attach_folder2/$now_year/$now_month", 0777);
		}
		if (!is_dir("$thumb_jaego_attach_folder2/$now_year/$now_month/$now_day")){
		mkdir("$thumb_jaego_attach_folder2/$now_year/$now_month/$now_day", 0777);
		}
		umask($oldmask);



		$number	= $_GET["number"];
		$start	= $_GET["start"];
		if ( $mode != "add" )
		{
			$Sql	= "SELECT * FROM $happy_member_group WHERE number='$number'";
			$Data	= happy_mysql_fetch_array(query($Sql));
		}


		$submit_button	= ( $mode == "add" )?"등록":"수정";



		$group_member_join_y	= ( $Data['group_member_join'] == 'y' )? ' checked ' : '';
		$group_member_join_n	= ( $Data['group_member_join'] != 'y' )? ' checked ' : '';


		$iso_real_name_y		= ( $Data['iso_real_name'] == 'y' )? ' checked ' : '';
		$iso_real_name_n		= ( $Data['iso_real_name'] != 'y' )? ' checked ' : '';

		$iso_jumin_y			= ( $Data['iso_jumin'] == 'y' )? ' checked ' : '';
		$iso_jumin_n			= ( $Data['iso_jumin'] != 'y' )? ' checked ' : '';

		$iso_hphone_y			= ( $Data['iso_hphone'] == 'y' )? ' checked ' : '';
		$iso_hphone_n			= ( $Data['iso_hphone'] != 'y' )? ' checked ' : '';

		$iso_email_y			= ( $Data['iso_email'] == 'y' )? ' checked ' : '';
		$iso_email_n			= ( $Data['iso_email'] != 'y' )? ' checked ' : '';

		// 회원가입 그룹별 메일 발송 - x2chi
		$reg_email_use_y		= ( $Data['reg_email_use'] == 'y' )? ' checked ' : '';
		$reg_email_use_n		= ( $Data['reg_email_use'] != 'y' )? ' checked ' : '';
		$reg_email_subject		= $Data['reg_email_subject'];
		//$reg_email				= str_replace("\n","",str_replace("\r","",$Data['reg_email']));
		$reg_email				= $Data['reg_email'];


		$group_img_preview		= '';
		$group_img_delete		= '';
		if ( $Data['group_img'] != '' )
		{
			$tmp	= @getimagesize('../'.$Data['group_img']);

			#print_r($tmp);

			if ( $tmp[0] > 500 )
			{
				$tmp[0]	= 500;
			}
			if ( $tmp == '' )
			{
				$group_img_preview		= "<br>$Data[group_img] 파일이 존재하지 않습니다.";
				$group_img_delete		= "<input type='hidden' name='group_img_del' value='ok'>";
			}
			else
			{
				$group_img_preview		= "<br><img src='../$Data[group_img]' width='$tmp[0]' class='group_img_preview'>";
				$group_img_delete		= "<input type='checkbox' name='group_img_del' value='ok' class='input_chk' id='group_img_del'><label for='group_img_del' style='cursor:pointer'>파일삭제</label>";
			}
		}


		$group_img_mobile_preview		= '';
		$group_img_mobile_delete		= '';
		$group_img_mobile_display		= '';
		if ( $m_version == '1' )
		{
			if ( $Data['group_img_mobile'] != '' )
			{
				$tmp	= @getimagesize('../'.$Data['group_img_mobile']);

				#print_r($tmp);

				if ( $tmp[0] > 500 )
				{
					$tmp[0]	= 500;
				}
				if ( $tmp == '' )
				{
					$group_img_mobile_preview		= "<br>$Data[group_img_mobile] 파일이 존재하지 않습니다.";
					$group_img_mobile_delete		= "<input type='hidden' name='group_img_mobile_del' value='ok'>";
				}
				else
				{
					$group_img_mobile_preview		= "<br><img src='../$Data[group_img_mobile]' width='$tmp[0]' class='group_img_mobile_preview'>";
					$group_img_mobile_delete		= "<input type='checkbox' name='group_img_mobile_del' value='ok' class='input_chk' id='group_img_mobile_del'><label for='group_img_mobile_del' style='cursor:pointer'>파일삭제</label>";
				}
			}
		}
		else
		{
			$group_img_mobile_display		= " style='display:none' ";
		}


		$mypage_default_arr	= happy_member_filelist('../'.$happy_member_skin_folder, 'happy_member_default_mypage', 'category,poll' );
		$mypage_content_arr	= happy_member_filelist('../'.$happy_member_skin_folder, 'happy_member_mypage');
#echo "######".'../'.$happy_member_skin_folder, 'happy_member_mypage';
#######../temp/happy_member_mypage

		$mypage_default	= "<select name='mypage_default' >";
		$mypage_default	.= "<option value=''> - 파일선택 - </option>";
		for ( $i=0, $max=sizeof($mypage_default_arr) ; $i<$max ; $i++ )
		{
			$nowValue		= $mypage_default_arr[$i];
			$selected		= ( $Data['mypage_default'] == $nowValue )?" selected ":"";
			$mypage_default	.= "<option value='$nowValue' $selected >$nowValue</option>";
		}
		$mypage_default	.= "</select>";

		$mypage_content	= "<select name='mypage_content' >";
		$mypage_content	.= "<option value=''> - 파일선택 - </option>";
		for ( $i=0, $max=sizeof($mypage_content_arr) ; $i<$max ; $i++ )
		{
			$nowValue		= $mypage_content_arr[$i];
			$selected		= ( $Data['mypage_content'] == $nowValue )?" selected ":"";
			$mypage_content	.= "<option value='$nowValue' $selected >$nowValue</option>";
		}
		$mypage_content	.= "</select>";



		$submit_button		= ( $mode == "add" )?"등록":"수정";
		$admin_tool_btn_bg	= ( $mode == "modify" )?"catemenu_mod":"''";


		$groupMemberNowTitle = $Data['group_name'];

        //위지윅에디터CSS
        $editor_css = happy_wys_css("ckeditor","../");
        $editor_js = happy_wys_js("ckeditor","../");

        $editor_menu_content = happy_wys("ckeditor","가로100%","세로300","reg_email","{reg_email}","../","happycgi_normal");

		echo <<<END
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

			<p class='main_title'>$now_location_subtitle [ <span style='color:#0088ff;'>{$groupMemberNowTitle}</span>그룹 {$submit_button}하기]</p>

			<div class="help_style">
				<div class="box_1"></div>
				<div class="box_2"></div>
				<div class="box_3"></div>
				<div class="box_4"></div>
				<span class="help">도움말</span>
				<p>회원그룹은 무한대로 생성이 가능합니다.<br />그룹별로 사용하시고자 하는 권한관리,필드관리 및 회원가입시 설정옵션등을 설정하실 수 있습니다.<br/><b style='color:#000;'>비회원그룹</b>의 경우 아래의 <a href='happy_member_secure.php?group_number=900000000' style='color:#4c6191;'>비회원 권한설정</a>란에서 설정이 가능합니다.<br>SNS회원은 별도의 실명인증 및 회원가입을 사용하지 않습니다.&nbsp;&nbsp;<font style='font:11px 돋움; letter-spacing:-1; color:#c9c9c9;'>예) 페이스북, 구글사이트에 회원가입이 되셨다면 별도의 회원가입없이 접속이 가능합니다.</font></p>
			</div>

			<!-- RND-TBL -->
			<form method='post' name='group_regist' action='?mode=modify_reg' onSubmit='return sendit(this)'  enctype='multipart/form-data'>
			<input type='hidden' name='number' value='$number'>
			<input type='hidden' name='mode_chk' value='$mode'>
			<input type='hidden' name='start' value='$start'>
			<input type='hidden' name='search_order' value='$search_order'>
			<input type='hidden' name='keyword' value='$keyword'>

			<div id="box_style">
				<div class="box_1"></div>
				<div class="box_2"></div>
				<div class="box_3"></div>
				<div class="box_4"></div>
				<table cellspacing="1" cellpadding="0" class="bg_style box_height">
				<tr>
					<th>그룹명</th>
					<td>
						<input type='text' name='group_name' value='$Data[group_name]'> $group_icon
						<div style='margin-top:5px;' class='font_st_11'><label style="width:400px; height:30px;">그룹아이콘 이미지경로: <label style="color:gray;">img > group_ico > <b>member_group_ico_{$Data[number]}.gif</b> <br/ > 지정된 이미지파일명으로 FTP 접속 후 해당 폴더에 넣어 주시면 됩니다.<br>그룹아이콘은 로그인박스와 마이페이지에서 출력됩니다. ( 현재 데모버전은 TEXT로 출력중 )</label></label></div>
					</td>
				</tr>
				<tr>
					<th>회원가입 가능여부</th>
					<td>
						<table cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<input type='radio' name='group_member_join' value='y' $group_member_join_y class='cfg_input_chk' id='group_member_join_y'><label for='group_member_join_y' style='cursor:pointer'>가입가능</label>&nbsp;&nbsp;
								<input type='radio' name='group_member_join' value='n' $group_member_join_n class='cfg_input_chk' id='group_member_join_n'><label for='group_member_join_n' style='cursor:pointer'>불가능(관리자모드에서 지정만 할수 있음)</label>
								<br><br><br>
								<div class="help_style">
									<div class="box_1"></div>
									<div class="box_2"></div>
									<div class="box_3"></div>
									<div class="box_4"></div>
									<span class="help">도움말</span>
									<p>회원가입이 가능하게 하려면 "가입가능" 으로 체크하세요.<br />가입가능으로 체크시 <a href="../happy_member.php?mode=joinus" target="_blank" style="color:#4556ac;">회원가입 페이지</a>에서 가입할 수 있는 링크를 확인할 수 있습니다.</p>
								</div>

							</td>
							<td><img src="img/happy_member_group01.gif" align="absmiddle"></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th>가입시 그룹선택 이미지</th>
					<td>
						<input type='file' name='group_img' size=30> $group_img_delete<br>
						$group_img_preview
						<br><br>
						<div class="help_style">
							<div class="box_1"></div>
							<div class="box_2"></div>
							<div class="box_3"></div>
							<div class="box_4"></div>
							<span class="help">도움말</span>
							<p>회원가입 가능여부를 가능하게 하셨다면 가입시 선택이미지를 등록하셔야합니다.<br />가입가능으로 체크시 <a href="../happy_member.php?mode=joinus" target="_blank" style="color:#4556ac;">회원가입 페이지</a>에서 가입할 수 있는 링크를 확인할 수 있습니다.</p>
						</div>
					</td>
				</tr>
				<tr $group_img_mobile_display>
					<th>가입시 그룹선택 이미지<br>(모바일)</th>
					<td>
						<input type='file' name='group_img_mobile' size=30> $group_img_mobile_delete<br>
						$group_img_mobile_preview
					</td>
				</tr>
				<tr style="display:none;">
					<th>가입시 회원레벨</th>
					<td>
						<input type='text' name='group_default_level' value='$Data[group_default_level]' size=4>
					</td>
				</tr>
				<tr style='display:none;'>
					<th>가입시 실명인증</th>
					<td>
						<table cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<input type='radio' name='iso_real_name' value='y' class='cfg_input_chk' id='iso_real_name_y' $iso_real_name_y ><label for='iso_real_name_y' style='cursor:pointer'> 인증 후 가입가능</label>
								<input type='radio' name='iso_real_name' value='n' class='cfg_input_chk' id='iso_real_name_n' $iso_real_name_n ><label for='iso_real_name_n' style='cursor:pointer'> 미인증</label>
								<br><br>
								<div class="help_style">
									<div class="box_1"></div>
									<div class="box_2"></div>
									<div class="box_3"></div>
									<div class="box_4"></div>
									<span class="help">도움말</span>
									<p>회원그룹별로 실명인증 가입 가능 옵션을 사용할 수 있습니다.<br />실명인증은 1차적으로 <a href="happy_config_view.php?number=17" target="" style="color:#4556ac;">실명인증 설정</a>란에서 사용유무를 설정할 수 있습니다.<br>실명인증기능은 KCB에 결제하시는 유료기능입니다.</p>
								</div>
							</td>
							<td><img src="img/happy_member_group03.gif" align="absmiddle"></td>
						</tr>
						</table>
					</td>
				</tr>

				<!-- 가입시 주민등록번호 검사확인
				<tr>
					<th>가입시 주민등록번호<br />검사확인</td>
					<td>
						<input type='radio' name='iso_jumin' value='y' class='cfg_input_chk' id='iso_jumin_y' $iso_jumin_y ><label for='iso_jumin_y' style='cursor:pointer'>주민등록번호 형식 체크</label>
						<input type='radio' name='iso_jumin' value='n' class='cfg_input_chk' id='iso_jumin_n' $iso_jumin_n ><label for='iso_jumin_n' style='cursor:pointer'>미인증</label>
						<div class="help_style">
							<div class="box_1"></div>
							<div class="box_2"></div>
							<div class="box_3"></div>
							<div class="box_4"></div>
							<span class="help">도움말</span>
							<p>실명인증 기능을 사용하셨을 경우 회원가입시 이미 주민등록번호를 검사한 상태이기때문에 <b>"미인증"</b> 설정을 권장합니다.<br />실명인증 기능을 사용하지 않을 경우 회원가입시 주민등록번호 형식을 체크하여 정상적인 주민등록번호를 받으셔야 합니다.<br>회원그룹별 필드관리에서 "주민등록번호" 필드를 사용하도록 체크하셔야 주민등록번호 검사확인 활성화가 유효합니다.</p>
						</div>
					</td>
				</tr> -->

				<tr>
					<th>가입시 휴대폰인증</th>
					<td>
						<p class="short">인증 설정시 <b>user_hphone</b> 필드뒤에 자동으로 인증아이콘이 표시되며, 해당 필드를 숨겨두실경우 가입불가능</p>
						<input type='radio' name='iso_hphone' value='y' class='cfg_input_chk' id='iso_hphone_y' $iso_hphone_y ><label for='iso_hphone_y' style='cursor:pointer'> 인증후 가입 가능</label>
						<input type='radio' name='iso_hphone' value='n' class='cfg_input_chk' id='iso_hphone_n' $iso_hphone_n ><label for='iso_hphone_n' style='cursor:pointer'> 미인증</label><br><br>
					</td>
				</tr>
				<tr>
					<th>가입시 E-mail인증</th>
					<td>
						<p class="short">인증 설정시 <b>user_email</b> 필드뒤에 자동으로 인증아이콘이 표시되며, 해당 필드를 숨겨두실경우 가입불가능</p>
						<input type='radio' name='iso_email' value='y' class='cfg_input_chk' id='iso_email_y' $iso_email_y ><label for='iso_email_y' style='cursor:pointer'> 인증후 로그인 가능</label>
							<input type='radio' name='iso_email' value='n' class='cfg_input_chk' id='iso_email_n' $iso_email_n ><label for='iso_email_n' style='cursor:pointer'> 미인증</label><br><br>
					</td>
				</tr>




				<!-- // 회원가입 그룹별 메일 발송 - x2chi -->
				<tr>
					<th>회원가입시<br>E-Mail 발송내용</th>
					<td>
						<p class="short">회원가입시 <b>user_email</b> 필드에 등록된 이메일로 가입 이메일을 발송합니다.</p>
						<input type='radio' name='reg_email_use' value='y' class='cfg_input_chk' id='reg_email_use_y' $reg_email_use_y ><label for='reg_email_use_y' style='cursor:pointer'> 사용함</label>
						<input type='radio' name='reg_email_use' value='n' class='cfg_input_chk' id='reg_email_use_n' $reg_email_use_n ><label for='reg_email_use_n' style='cursor:pointer'> 사용안함</label>
						<br /><br />
						제목 : <input type='text' name='reg_email_subject' value='$reg_email_subject' style="width:80%;">
						<br /><br />
						$editor_menu_content
						<br /><br />
						<div class="help_style">
							<div class="box_1"></div>
							<div class="box_2"></div>
							<div class="box_3"></div>
							<div class="box_4"></div>
							<span class="help">도움말</span>
							<p>
								<strong>* 제목에서 사용가능한 추출 태그</strong><br />
								{{site_name}} : 관리자에서 설정한 사이트 제목<br />
								{{user_name}} : 회원가입시 고객이 등록한 회원이름<br />
								{{user_id}} : 회원가입시 고객이 등록한 회원아이디
								<br /><br />
								<strong>* 내용에서 사용가능한 추출 태그</strong><br />
								{{site_name}} : 관리자에서 설정한 사이트 제목<br />
								{{user_name}} : 회원가입시 고객이 등록한 회원이름<br />
								{{user_id}} : 회원가입시 고객이 등록한 회원아이디<br />
								{{user_pass}} : 회원가입시 고객이 등록한 회원패스워드 (보안상 출력에 유의하시기 바랍니다.)<br />
								{{user_phone}} : 회원가입시 고객이 등록한 회원전화번호<br />
								{{user_hphone}} : 회원가입시 고객이 등록한 회원휴대폰번호<br />
								{{now_year}} : 회원가입시 현재 년도<br />
								{{main_url}} : 관리자에서 설정한 사이트 주소(도메인)
								<br /><br />
								<strong>* 메일발송시 개인정보 노출에 유의하셔서 발송메일을 수정 하시기 바랍니다.</strong>
							</p>
						</div>
					</td>
				</tr>




				<tr>
					<th>마이페이지 껍데기<br />템플릿(HTML)파일</th>
					<td class="input_style_adm">
						$mypage_default &nbsp;&nbsp;&nbsp;<label>미선택시 <strong>&quot;{$happy_member_mypage_default_file}&quot;</strong> 파일을 불러옵니다.</label>
						<br><br><br>
						<div class="help_style">
							<div class="box_1"></div>
							<div class="box_2"></div>
							<div class="box_3"></div>
							<div class="box_4"></div>
							<span class="help">도움말</span>
							<p>마이페이지 껍데기 템플릿(HTML)파일의 파일명은 <strong>&quot;happy_member_default_mypage&quot;</strong> 단어를 포함시켜 주세요.<br>
							예시) my_room_default_가나다.html, my_room_default_100.html<br>
							새로 만드신 껍데기 템플릿파일을 FTP 접속 후 html 폴더 안에 업로드하여 주시면 여기 선택폼 목록에 새로 업로드된 템플릿파일명이 표시가 됩니다.</p>
						</div>
					</td>
				</tr>
				<tr>
					<th>마이페이지 내용물<br />템플릿(HTML)파일</th>
					<td class="input_style_adm">
						$mypage_content &nbsp;&nbsp;&nbsp;<label>미선택시 <strong>&quot;{$happy_member_mypage_content_file}&quot;</strong> 파일을 불러옵니다.</label>
						<br><br><br>
						<div class="help_style">
							<div class="box_1"></div>
							<div class="box_2"></div>
							<div class="box_3"></div>
							<div class="box_4"></div>
							<span class="help">도움말</span>
							<p>마이페이지 내용물 템플릿(HTML)파일의 파일명은 <strong>&quot;happy_member_mypage&quot;</strong> 단어를 포함시켜 주세요.<br>
							예시) happy_member_mypage_가나다.html, happy_member_mypage_100.html<br>
							새로 만드신 껍데기 템플릿파일을 FTP 접속 후 html 폴더 안에 업로드하여 주시면 여기 선택폼 목록에 새로 업로드된 템플릿파일명이 표시가 됩니다.</p>
						</div>
					</td>
				</tr>
				</table>
			</div>
			<div align="center">
				<input type='submit' value='저장하기' class='btn_big'> <A HREF="javascript:history.go(-1);" class='btn_big_gray'>목록보기</A>
			</div>

			</form>




END;
	}	############# 그룹 수정 끝 #############



######################## 그룹 수정 DB입력 시작 ###########################
	else if ( $mode == "modify_reg" )
	{
		$number				= $_POST['number'];
		$start				= $_POST['start'];
		$search_order		= $_POST['search_order'];
		$keyword			= $_POST['keyword'];
		$mode_chk			= $_POST['mode_chk'];

		$group_name			= $_POST['group_name'];
		$group_member_join	= $_POST['group_member_join'];
		$group_default_level= $_POST['group_default_level'];

		$iso_real_name		= $_POST['iso_real_name'];
		$iso_jumin			= $_POST['iso_jumin'];
		$iso_hphone			= $_POST['iso_hphone'];
		$iso_email			= $_POST['iso_email'];

		$mypage_default		= $_POST['mypage_default'];
		$mypage_content		= $_POST['mypage_content'];

		if ( $auto_addslashe )
		{
			$group_name			= addslashes($_POST["group_name"]);
		}


		if ( $mode_chk != 'add' && $number != '' )
		{
			$Sql		= "SELECT * FROM $happy_member_group WHERE number='$number' ";
			$GroupData	= happy_mysql_fetch_array(query($Sql));
		}



		$SetSql	= "
				group_name			= '$group_name',
				group_member_join	= '$group_member_join',
				group_default_level	= '$group_default_level',
				iso_real_name		= '$iso_real_name',
				iso_jumin			= '$iso_jumin',
				iso_hphone			= '$iso_hphone',
				iso_email			= '$iso_email',
				mypage_default		= '$mypage_default',
				mypage_content		= '$mypage_content',
		";


		// 회원가입 그룹별 메일 발송 - x2chi
		$reg_email_use		= $_POST['reg_email_use'];
		$reg_email_subject	= addslashes($_POST['reg_email_subject']);
		$reg_email			= $_POST['reg_email'];
		$SetSql	.= "
				reg_email_use		= '$reg_email_use',
				reg_email_subject	= '$reg_email_subject',
				reg_email			= '$reg_email'
		";

		if ( $_POST['group_img_del'] == 'ok' && $GroupData['group_img'] != '' && $_FILES['group_img']['name'] == "")
		{
			$nowFile		= $GroupData['group_img'];

			happy_member_image_unlink("../$nowFile",Array());


			$SetSql			.= ( $SetSql == '' )? '' : ', ';
			$SetSql			.= " group_img = '' \n";
		}
		else if ( $_FILES['group_img']['name'] != "" )
		{
			#echo 'group_img'."<br>";
			$upImageName	= $_FILES['group_img']['name'];
			$upImageTemp	= $_FILES['group_img']['tmp_name'];


			$temp_name		= explode(".",$upImageName);
			$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

			$options		= explode(",",'jpg,jpeg,gif,png');


			for ( $z=0,$m=sizeof($options),$ext_check='' ; $z<$m ; $z++ )
			{
				#echo " $ext = ".$options[$z] ."<br>";
				if ( $ext == trim($options[$z]))
				{
					$ext_check	= 'ok';
					break;
				}
			}


			if ( $ext_check != 'ok' && $_POST['group_img'.'_del'] != 'ok' )
			{
				$addMessage	= "\\n\\n'group_img' 필드 : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $Form[field_option] 입니다.";
				#echo $addMessage;
				continue;
			}
			else
			{
				$rand_number		= rand(0,1000000);
				$now_time			= happy_mktime();
				$img_url_re			= "${happy_member_group_upload_path}$now_time-$rand_number.$ext";
				$img_url_file_name	= "${happy_member_group_upload_folder}$now_time-$rand_number.$ext";

				if (copy($upImageTemp,"$img_url_re"))
				{

					${'group_img'}	= $img_url_file_name;
					$SetSql			.= ( $SetSql == '' )? '' : ', ';
					$SetSql			.= " group_img = '".${'group_img'}."' \n";


					# 새로운 파일이 업로드 되었으니 기존 파일 제거
					if ( $GroupData['group_img'] != '' )
					{
						$nowFile		= $GroupData['group_img'];
						happy_member_image_unlink("../$nowFile",Array());
					}

				} #copy 완료마지막
			}
		}


		if ( $_POST['group_img_mobile_del'] == 'ok' && $GroupData['group_img_mobile'] != '' && $_FILES['group_img_mobile']['name'] == "")
		{
			$nowFile		= $GroupData['group_img_mobile'];

			happy_member_image_unlink("../$nowFile",Array());


			$SetSql			.= ( $SetSql == '' )? '' : ', ';
			$SetSql			.= " group_img_mobile = '' \n";
		}
		else if ( $_FILES['group_img_mobile']['name'] != "" )
		{
			#echo 'group_img_mobile'."<br>";
			$upImageName	= $_FILES['group_img_mobile']['name'];
			$upImageTemp	= $_FILES['group_img_mobile']['tmp_name'];


			$temp_name		= explode(".",$upImageName);
			$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

			$options		= explode(",",'jpg,jpeg,gif,png');


			for ( $z=0,$m=sizeof($options),$ext_check='' ; $z<$m ; $z++ )
			{
				#echo " $ext = ".$options[$z] ."<br>";
				if ( $ext == trim($options[$z]))
				{
					$ext_check	= 'ok';
					break;
				}
			}


			if ( $ext_check != 'ok' && $_POST['group_img_mobile'.'_del'] != 'ok' )
			{
				$addMessage	= "\\n\\n'group_img_mobile' 필드 : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $Form[field_option] 입니다.";
				#echo $addMessage;
				continue;
			}
			else
			{
				$rand_number		= rand(0,1000000);
				$now_time			= happy_mktime();
				$img_url_re			= "${happy_member_group_upload_path}$now_time-$rand_number.$ext";
				$img_url_file_name	= "${happy_member_group_upload_folder}$now_time-$rand_number.$ext";

				if (copy($upImageTemp,"$img_url_re"))
				{

					${'group_img_mobile'}	= $img_url_file_name;
					$SetSql			.= ( $SetSql == '' )? '' : ', ';
					$SetSql			.= " group_img_mobile = '".${'group_img_mobile'}."' \n";


					# 새로운 파일이 업로드 되었으니 기존 파일 제거
					if ( $GroupData['group_img_mobile'] != '' )
					{
						$nowFile		= $GroupData['group_img_mobile'];
						happy_member_image_unlink("../$nowFile",Array());
					}

				} #copy 완료마지막
			}
		}



		if ( $mode_chk == "add" )
		{
			$msg	= "등록되었습니다.";
			$Sql	= "
						INSERT INTO
								$happy_member_group
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
							$happy_member_group
					SET
							$SetSql
					WHERE
							number = '$number'
			";
		}
		query($Sql);

		gomsg($msg,"?start=$start&search_order=$search_order&keyword=$keyword");

	}	############# 그룹 수정 DB입력 끝 #############



######################## 그룹 삭제 시작 ###########################
	else if ( $mode == "delete" )
	{
		$number	= $_GET["number"];
		$start	= $_GET["start"];

		$Sql	= "DELETE FROM $happy_member_group WHERE number='$number' ";
		query($Sql);

		gomsg("삭제완료 되었습니다.","?start=$start&search_order=$search_order&keyword=$keyword");

	}	############# 그룹 삭제 끝 #############




	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################

?>