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

	//최고관리자일때만 쪽지보내기 가능함
	$message_view = 0;
	if ( !admin_secure("슈퍼관리자전용") )
	{
		$message_view = 1;
	}

	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	if($_GET[type] != 'reg' && $_GET[type] != 'out_del' && $_GET[type] != 'del')
	{
		include ("tpl_inc/top_new.php");
	}
	################################################




	#include "../inc/function_happy_member.php";





	#변수 체크
	$type			= $_GET['type'];
	$number			= preg_replace('/\D/', '',$_GET['number']);
	$group_select	= $_GET['group_select'];



	#등록된 그룹명 뽑아오기
	$groupMemberTitle	= " 전체회원";
	$groupBox			= happy_member_make_group_box('group_select', '-- 회원그룹별 보기 --');





	if ( $type == "" )									# 회원 리스트출력 ################################################
	{
		#검색
		$search_type	= $_GET["search_type"];
		$search_word	= $_GET["search_word"];
		$email_forwarding	= $_GET['email_forwarding'];
		$sms_forwarding		= $_GET['sms_forwarding'];
		$state_open			= $_GET['state_open'];


		$email_forwarding_checked	= ($email_forwarding == "y")?"checked":"";
		$sms_forwarding_checked		= ($sms_forwarding == "y")?"checked":"";
		$state_open_checked			= ($state_open == "y")?"checked":"";


		$WHERE		= "";
		if ( $search_word != "" )
		{
			if ( $search_type == '' )
			{
				$WHERE	.= "
								AND
								(
									user_id			like '%${search_word}%'
									OR
									user_homepage	like '%${search_word}%'
									OR
									user_email		like '%${search_word}%'
									OR
									user_name		like '%${search_word}%'
									OR
									user_nick		like '%${search_word}%'
									OR
									user_phone		like '%${search_word}%'
									OR
									user_hphone		like '%${search_word}%'
								)
				";
			}
			else
			{
				$WHERE	.= " AND $search_type like '%${search_word}%' ";
			}
		}


		#수신동의
		$WHERE		.= ($email_forwarding == "y")?" AND email_forwarding='y' ":"";
		$WHERE		.= ($sms_forwarding == "y")?" AND sms_forwarding='y' ":"";
		$WHERE		.= ($state_open == "y")?" AND state_open='y' ":"";


		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 15;

		$WHERE			.= $group_select == '' ? "" : " AND `group`='$group_select' ";

		$Sql	= "select count(*) from $happy_member WHERE 1=1 $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Count	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 6;

		$searchMethod	= "";
			#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
				$searchMethod	.= "&search_word=$search_word&search_type=$search_type&group_select=$group_select";
				$searchMethod	.= "&email_forwarding=$_GET[email_forwarding]";
				$searchMethod	.= "&sms_forwarding=$_GET[sms_forwarding]";
				$searchMethod	.= "&state_open=$_GET[state_open]";
			#검색값 입력완료

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################

		#회원 정보공개 관련 카운트
		$MEM_CNT_FIELD				= Array("email_forwarding","sms_forwarding","state_open");
		foreach($MEM_CNT_FIELD AS $mcf_val)
		{
			${"Sql_".$mcf_val}			= "SELECT count(*) FROM $happy_member WHERE 1=1 AND {$mcf_val}='y' $WHERE  ";
			${"Rec_".$mcf_val}			= query(${"Sql_".$mcf_val});
			$MEM_CNT					= mysql_fetch_row(${"Rec_".$mcf_val});
			${$mcf_val."_comma"}		= number_format($MEM_CNT[0]);
		}
		#회원 정보공개 관련 카운트 END


		// 2013-03-21 woo 검색 회원 아이디 모음
		$search_member_goMessage_Array		= Array();
		$search_member_goMessage_sql		= "SELECT user_id FROM $happy_member WHERE 1=1 $WHERE ";
		$search_member_goMessage_result		= query($search_member_goMessage_sql);
		while($search_member_goMessage_data = happy_mysql_fetch_array($search_member_goMessage_result))
		{
			$search_member_goMessage_Array[]	= $search_member_goMessage_data['user_id'];
		}
		$search_member_goMessage_id			= implode(",", (array)  $search_member_goMessage_Array);
		// 2013-03-21 woo 검색 회원 아이디 모음

		$Sql	= "SELECT * FROM $happy_member WHERE 1=1 $WHERE ORDER BY number desc LIMIT $start,$scale ";
		$Record	= query($Sql);

		$groupBox	= str_replace("__onChange__","onChange='this.form.submit()'",$groupBox);




		# 리스트에서 출력할 필드 설정 가져오기
		$FieldTitleWhere	= "";
		if ( $_GET['group_select'] != '' )
		{
			$FieldTitleWhere	= " AND A.member_group='$_GET[group_select]' ";
		}else{
			$_GET['group_select'] = "0";
		}
		/*
			2012-11-05 관리자 필드 순서 woo
			ORDER BY
					admin_list_sort
			추가

			alter table happy_member_field add admin_list_sort int(11) not null default 0 after admin_list_print;
		*/
		$Sql		= "
							SELECT
									A.*
							FROM
									$happy_member_field AS A
									LEFT JOIN
									$happy_member_group AS B
							ON
									A.member_group		= B.number
							WHERE
									B.number is not null
									AND
									A.admin_list_print	= 'y'
									$FieldTitleWhere
							GROUP BY
									field_name
							ORDER BY
									admin_list_sort
		";
		$FieldRec	= query($Sql);


		$count = 5;
		#<th class=tbl_item_hm_0_1 nowrap> class 형식을 뜀 :: YOON [2010-06-21]
		#class 내용은 [ top.php ]
		$FieldTitleContent	= "<th>번호</th>";
		while ( $Tmp = happy_mysql_fetch_array($FieldRec) )
		{
			$count++;

			$tdWidth	= ( $fieldAdminTdWidth[$Tmp['field_name']] == '' )? '120' : $fieldAdminTdWidth[$Tmp['field_name']];
			$FieldTitleContent	.= "<th width=$tdWidth align=center style='color:#fff;' class= nowrap>$Tmp[field_title]</th>";
		}

		$FieldTitleContent	.= "
					<th>로고변경</th>
					<th>가입일</th>
					<th>최종로그인</th>
					<th>로그인수</th>
					<th>관리툴</th>
		";


		#필드항목
		echo "
				<script>
					function review_del(no)
					{
						if ( confirm('정말 삭제하시겠습니까?') )
						{
							window.location.href = '?type=del&start=$start&search_word=$search_word&search_type=$search_type&number='+no;
						}
					}
					</script>

					<script language='javascript'>
					function OpenWindow(url,intWidth,intHeight) {
					window.open(url, '_blank', 'width='+intWidth+',height='+intHeight+',resizable=1,scrollbars=1');
					}
				</script>

				<p class='main_title'>
					<span style='color:#0088ff;'>${groupMemberTitle}</span> 정보관리
					<span class='small_btn'>
						<span class='font_st_11'>등록회원 총</span>
						<span class='font_st_12_tahoma'>$Total </span>
						<span class='font_st_11'>명</span>

						<span class='font_st_11'>l</span>

						<span class='font_st_11'>메일링수신</span>
						<span class='font_st_12_tahoma'>{$email_forwarding_comma}</span>
						<span class='font_st_11'>명</span>

						<span class='font_st_11'>l</span>

						<span class='font_st_11'>SMS수신</span>
						<span class='font_st_12_tahoma'>{$sms_forwarding_comma}</span>
						<span class='font_st_11'>명</span>

						<span class='font_st_11'>l</span>

						<span class='font_st_11'>정보공개</span>
						<span class='font_st_12_tahoma'>{$state_open_comma}</span>
						<span class='font_st_11'>명</span>
					</span>
				</p>

				<form name='search_frm' action='happy_member.php' style='margin:0;'>
				<div class='search_style'>
					<div class='box_1'></div>
					<div class='box_2'></div>
					<div class='box_3'></div>
					<div class='box_4'></div>
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=admin_search_frm>
					<tr>
						<td class='input_style_adm'><label id='groupBox'>$groupBox</label></td>
						<td class='input_style_adm'>
							<label id='search_frm_onoff'>
							<select name='search_type'>
								<option value=''>--선택--</option>
								<option value='user_id'>아이디</option>
								<option value='user_homepage'>홈페이지</option>
								<option value='user_email'>이메일</option>
								<option value='user_name'>이름</option>
								<option value='user_nick'>닉네임</option>
								<option value='user_phone'>전화번호</option>
								<option value='user_hphone'>휴대폰</option>
							</select>
							<script>
								document.search_frm.search_type.value = '$_GET[search_type]';
							</script>
							</label>
						</td>
						<td class='input_style_adm' style='padding-left:10px;'>
							<input type='checkbox' name='email_forwarding' style='height:13px; width:13px; vertical-align:middle;' id='email_forwarding' value='y' $email_forwarding_checked> <label for='email_forwarding' style='cursor:pointer; font-size:11px;'>메일링수신</label>
							<input type='checkbox' name='sms_forwarding'  style='height:13px; width:13px; vertical-align:middle;' id='sms_forwarding' value='y' $sms_forwarding_checked> <label for='sms_forwarding' style='cursor:pointer; font-size:11px;'>SMS수신</label>
							<input type='checkbox' name='state_open' style='height:13px; width:13px; vertical-align:middle;' id='state_open' value='y' $state_open_checked> <label for='state_open' style='cursor:pointer; font-size:11px;'>정보공개</label>
						</td>
						<td class='input_style_adm' style='padding-left:15px;'><input type='text' style='border:1px solid #bdbdbd;  width:420px; background:#f1f1f1;' name='search_word' value='$_GET[search_word]' id=search_word></td>
						<td style='padding-left:5px;'><input type='submit' value='검색하기'  class='btn_small_dark' id=search_btn style='height:30px'></td>
					</tr>
					</table>
				</div>
				</form>

				<div id='list_style'>
					<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
					<tr>
						$FieldTitleContent
					</tr>
		";




		#리스트(Value)
		$nowDate			= date("Y-m-d");
		$rowCount = 0;
		#<td class=tbl_item_hm_0_1_value> class 형식을 뜀 :: YOON [2010-06-21]
		#class 내용은 [ top.php ]
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$valueCount = 5;
			$reg_date			= substr($Data['reg_date'],0,10);
			$login_date			= substr($Data['login_date'],0,10);

			$reg_date			= $nowDate == $reg_date  ? substr($Data['reg_date'],10,9)  : $reg_date;
			$login_date			= $nowDate == $login_date ? substr($Data['login_date'],10,9) : $login_date;
			$login_count		= number_format($Data['login_count']);

			if ( $Data['user_prefix'] == 'man' )
			{
				$Data['user_prefix']	= '<label class=man>남자</label>';
			}
			else if ( $Data['user_prefix'] != '' )
			{
				$Data['user_prefix']	= '<label class=women>여자</label>';
			}

			//$rows_color 는 top.php 에서 설정 [ YOON : 2010-06-24 ]
			$bgcolor	= ( $rowCount%2 == 0 )?"white":$rows_color;


			echo "
				<tr>
					<td align='center'>$listNo</td>
			";
					/*
						2012-11-05 관리자 필드 순서 woo
						ORDER BY
								admin_list_sort
						추가

					*/
					# 리스트에서 출력할 필드 설정 가져오기
					$Sql		= "
										SELECT
												A.*
										FROM
												$happy_member_field AS A
												LEFT JOIN
												$happy_member_group AS B
										ON
												A.member_group		= B.number
										WHERE
												B.number is not null
												AND
												A.admin_list_print	= 'y'
												$FieldTitleWhere
										GROUP BY
												field_name
										ORDER BY
												admin_list_sort
					";
					$FieldRec	= query($Sql);

					while ( $Tmp = happy_mysql_fetch_array($FieldRec) )
					{

						$valueCount++;
						$tdWidth	= ( $fieldAdminTdWidth[$Tmp['field_name']] == '' )? '120' : $fieldAdminTdWidth[$Tmp['field_name']];
						$tdAlign	= ( $fieldAdminTdAlign[$Tmp['field_name']] == '' )? 'left' : $fieldAdminTdAlign[$Tmp['field_name']];

						if ( $Tmp['field_type'] == 'file' )	// 상세보기 페이지 => $tplTD 그냥 출력
						{
							$value	= $Data[$Tmp['field_name']];

							# SNS LOGIN 관련 설정
							if (preg_match("/http:\/\/|https:\/\//",$value))
							{
								if(eregi('googleusercontent.com', $value))
								{
									$value	= str_replace("?sz=50?sz=100","",$value);
								}
								$Data[$Tmp['field_name']]	= "<img src='$value' border='0' class='img_preview' width='$tdWidth' onError=this.src='./img/noimage_del.jpg'>";
							}
							else if (eregi('.jp', $value) || eregi('.gif', $value) || eregi('.png', $value) || eregi('.bmp', $value) )
							{
								$Data[$Tmp['field_name']]	= "<img src='../${happyMemberSrc}$value' border='0' class='img_preview' width='$tdWidth' onError=this.src='./img/noimage_del.jpg'>";
							}
							else if ( $value != '' )
							{
								$Data[$Tmp['field_name']]	= "<a href='../${happyMemberSrc}$value' target='_blank'>첨부파일</a>";
							}

							$tdAlign					= 'center';
						}

						#사진이고 없을 때
						if ( $Tmp['field_name'] == 'photo1' )
						{
							if ( trim($Data[$Tmp['field_name']]) == '' )
							{
								$Data[$Tmp['field_name']]	= "<img src='./img/noimage.jpg' border='0' class='img_preview'>";
								$tdAlign					= 'center';
							}
						}

						if ( trim($Data[$Tmp['field_name']]) == '' )
						{
							$Data[$Tmp['field_name']]	= '<label style="font-size:11px; color:#bbbbbb;">정보없음</label>';
							$tdAlign					= 'left';
						}

						if ( $Tmp['field_name'] == "user_id" )
						{
							$user_id_info = outputSNSID($Data[$Tmp['field_name']]);

						}
						else
						{
							$user_id_info = $Data[$Tmp['field_name']];
						}

						echo "<td width='$tdWidth' align='$tdAlign'>".$user_id_info."</td>";
					}


			//최고관리자일때만 쪽지보내기 가능함
			if ( $message_view == 1 )
			{
				$btn_message = "<a href='#' style='text-decoration:none'		onClick=\"window.open('../happy_message.php?mode=send&receiveid=$Data[user_id]&senderAdmin=y&file=message_send_form_simple.html&endMode=close','happy_message','width=480,height=315,toolbar=no,scrollbars=no')\"><img src=\"img/btn_memo.gif\" border=\"0\" title=\"현재 회원 쪽지보내기\"></a>";
			}

			//유흥이라서 추가
			$logo_change = "<a href='#1' onClick=\"window.open('../logo_change.php?number=".$Data['number']."&member_group=".$Data['group']."&member_id=".$Data['user_id']."','com_log','width=480,height=400,toolbar=no')\" class='btn_small_yellow'>로고변경</a>";

			echo "
					<td style='text-align:center;'>$logo_change</td>
					<td style='text-align:center;'>$reg_date</td>
					<td style='text-align:center;'>$login_date</td>
					<td style='text-align:center;'>${login_count}<label>회</label></td>
					<td style='text-align:center; width:60px; padding:10px'>
						$btn_message
						<a href='?type=add&number=$Data[number]&group_select=$_GET[group_select]&start=$start&search_word=$search_word&search_type=$search_type' title=\"현재 회원정보 수정\" class='btn_small_dark3'>수정</a>
						<a href='#delete' onClick=\"review_del('$Data[number]')\" title=\"현재 회원정보 삭제\" class='btn_small_red2' style='margin-top:3px'>삭제</a>
					</td>
				</tr>
			";
			$listNo--;
			$rowCount++;

		}


		echo "
				</table>
			</div>
			<!-- 통합회원관리 [ end ] -->

			<div style='padding:10px 0 10px 0;'><a href='#' style='text-decoration:none' onClick=\"window.open('$main_url/happy_message.php?adminMode=y&mode=send&send_type=all_user','adminHappyMessage','width=700,height=500,toolbar=no,scrollbars=no')\" class='btn_small_orange'>회원전체쪽지</a> <a href='javascript:void(0);' style='text-decoration:none' onClick=\"popup_gomessage('${search_member_goMessage_id}','search_user');\" class='btn_small_orange'>검색된회원쪽지</a>
 <a href='./happy_member_group.php' class='btn_small_blue'>회원그룹관리</a> <a href='./happy_member.php?type=outList' class='btn_small_navy'>탈퇴회원보기</a></div>

			<script>
				// 회원 쪽지 발송 woo
				function popup_gomessage(id, type)
				{
					var form = document.forms['message_form'];
					form.receiveid.value = id;
					if ( form.receiveid.value != '' )
					{
						window.open('','targetWindow','width=700,height=500,toolbar=no,scrollbars=no');
						form.target   = 'targetWindow';
						form.action   = '../happy_message.php?mode=send&senderAdmin=y&endMode=close&send_type='+type+'&search_query=".urlencode($_SERVER[QUERY_STRING])."';
						form.submit();
					}
					else
					{
						alert('쪽지를 발송할 회원이 없습니다.');
					}
				 }
			</script>

			<div align='center'>$paging</div>
		</form>

		<!-- 검색회원, 체크회원 쪽지발송 POST로 변경 hong -->
		<form name='message_form' method='post' style='margin:0;'>
			<input type='hidden' name='receiveid' id='receiveid' value=''>
		</form>
		";


	}
	else if ( $type == "add" )							# 회원 수정하기 ##################################################
	{
		$number		= preg_replace("/\D/", "", $_GET['number']);

		if ( $number == '' )
		{
			error("고유번호가 넘어오지 않았습니다.");
			exit;
		}

		$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member WHERE number='$number'"));
		if ( $MemberData['number'] == '' )
		{
			error("존재하지 않는 회원정보 입니다.");
			exit;
		}

		$_GET['member_group']	= $MemberData['group'];
		$member_group			= $MemberData['group'];


		$Group					= happy_mysql_fetch_array(query("SELECT * FROM $happy_member_group WHERE number='$member_group' "));

		//주민번호
		$sql = "select * from $happy_member_field where member_group = '$member_group' and field_name ='user_jumin2'";
		$result = query($sql);
		$TmpField = happy_mysql_fetch_assoc($result);
		if ( $TmpField['field_use_admin'] != 'y' )
		{
			$MemberData['user_jumin2'] = "XXXXXXX";
		}
		//주민번호


		//유흥이라서 추가된 회원정보
		#업종 분류 com_job
		$sel1 = $MemberData['extra13'];

		$업종분류 = "<select name=extra13>";
		foreach ($TYPE as $list)
		{
			if ($sel1 == $list)
			{
				$tmp_select = "selected";
			}
			else
			{
				$tmp_select = '';
			}
			$업종분류 .="<option value='$list' $tmp_select>$list</option>	";
		}
		$업종분류 .= "</select>";

		$button_title = ($type == "add")?"" : "";

		#폼출력
		echo "
			<script language='JavaScript' src='../js/happy_member.js' type='text/javascript'></script>
			<SCRIPT language='JavaScript' src='../js/glm-ajax.js'></SCRIPT>
			<SCRIPT language='JavaScript' src='js/admin_happy_member.js'></SCRIPT>
			<script language='JavaScript' src='../inc/lib.js' type='text/javascript'></script>
			<script>
				happyMemberSrc	= '../';
				function happyMemberCheckForm(theForm)
				{
					if ( theForm.user_pass.value != theForm.user_pass2.value )
					{
						alert('비밀번호가 일치하지 않습니다.');
						theForm.user_pass2.focus();
						return false;
					}
					//자동체크
					return validate(theForm);
				}

					function startRequest2(d)
					{
						return false;
					}

					function happyShowLayer_nick_check()
					{
						return false;
					}

					function happyCloseLayer_nick_check()
					{
						return false;
					}
			</script>
			<style type='text/css'>
				label.guide_txt{display:none;}
			</style>


			<p class='main_title'>회원정보 수정<label class='font_st_11'><img src='../img/form_icon1.gif'> 필수입력 항목을 나타냅니다.</label></p>

			<div id='box_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>

				<form name='happysms_frm' action='sms_send_sock.php' method='post' target='sms_iframe' style='margin:0px;'>
				<input type='hidden' name='userid' value='$sms_userid'><!-- HAPPYCGI에서 발급한 아이디 입력 -->
				<input type='hidden' name='testing' value=''>

				<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
		";
		print <<<END
				<tr>
					<th>SMS문자발송</th>
					<td class=tbl_box2_padding>

						<iframe width='0' height='0' name='sms_iframe' id='sms_iframe'></iframe><!-- 반드시 필요한 frame 입니다. -->

						<div id=sms_input1>

							<!-- 문자입력 -->
							<textarea cols='16' rows='5' style='width:140px; height:78px; margin:36px 0 0 13px; color:white; background:none;scrollbars:none;border:0;overflow:hidden;font-size:9pt;' name='message' maxlength='80' ></textarea>

							<!-- 발신번호 -->
							<div style="position:absolute; top:12px; left:212px;"><input type='text' name='phone' value='$MemberData[user_hphone]' style="width:115px; height:20px; font-family:tahoma; font-size:10pt; background-color:transparent; border:0px"></div>

							<!-- 회신번호 -->
							<div style="position:absolute; top:38px; left:212px;"><input type='text' name='callback' value="$site_phone" style="width:115px; height:20px; font-family:tahoma; font-size:10pt; background-color:transparent; border:0px;"></div>

							<!-- 발송시간 -->
							<div style="position:absolute; top:64px; left:212px;"><input type='text' name='send_date' value='$nowDate' readonly style="width:90px; height:20px; font-family:tahoma; font-size:10pt; background-color:transparent; border:0px; letter-spacing:-1px;"></div>

							<!-- 달력아이콘 -->
							<div style="position:absolute; top:68px; left:306px; z-index:2;">
								<a href='javascript:void(0)' onclick='if(self.gfPop)gfPop.fPopCalendar(document.happysms_frm.send_date);return false;' ><img name='popcal' align='absmiddle' src='img/sms_btn_cal.gif' border='0' alt='달력보기'><!--<img name='popcal' align='absmiddle' src='../js/time_calrendar/calbtn2.gif' width='34' height='22' border='0' alt=''>--></a>

								<div style="position:absolute; top:-270px; left:-765px;">
									<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop:plugins_time.js' id='gToday:datetime:agenda.js:gfPop:plugins_time.js' src='../js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>
								</div>
							</div>

							<!-- 전송버튼 -->
							<div style="position:absolute; top:90px; left:164px; z-index:1;"><input type='submit' value='SMS전송' style="width:166px; height:30px; background:url(img/sms_btn_send_bg.gif); color:white; font-weight:bold; font-size:9pt; font-family:맑은 고딕,돋움; padding:; border:0px;"></div>
						</div>

						<div id=sms_input2 style='margin-top:10px;'>
							<div class=help_txt>
								<UL>
									<LI>
									회신번호의 변경을 원하시면 직접 변경하시거나 솔루션환경설정을 조작하십시오.
									<Li>
									받는사람의 전화번호는 회원정보의 휴대폰 정보의 전화번호로 문자가 발송됩니다.
									<LI>
									문자는 80Byte이상 입력시 자동으로 80Byte(한글40글자)로 조절되어 발송됩니다.
									<LI>
									SMS 문자충전은 기타설정 > SMS 관리를 클릭하십시오.
								</UL>
							</div>
						</div>


					</td>
				</tr>
				</table>
			</div>
			</form>

			<form name='banner_frm' action='?type=reg' method='post' enctype='multipart/form-data' style='margin:0px;' onSubmit="return happyMemberCheckForm(this);">
			<input type='hidden' name='number' value='$number'>
			<input type='hidden' name='start' value='$start'>
			<input type='hidden' name='search_word' value='$search_word'>
			<input type='hidden' name='search_type' value='$search_type'>
			<input type='hidden' name='group_select' value='$group_select'>

			<div id='box_style'>
				<div class='box_1'></div>
				<div class='box_2'></div>
				<div class='box_3'></div>
				<div class='box_4'></div>

				<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
END;

		$happyMemberAdminMode	= 'happyOk';
		$happyMemberMode		= 'mod';
		$happyMemberSrc			= '../';
		happy_member_user_form('자동','전체','happy_member_form_rows.html','happy_member_form_default.html');

		$groupBox = str_replace("name='group_select' __onChange__", "name='groupSelect'", $groupBox);
		// 스크립트 오류로 수정 2014-01-03 woo
		$groupBox = str_replace("id='group_select'", "id='groupSelect'", $groupBox);

		$phoneCheckY = ($MemberData['iso_hphone'] == 'y')? 'checked' : '';
		$phoneCheckN = ($MemberData['iso_hphone'] == 'n')? 'checked' : '';
		$mailCheckY = ($MemberData['iso_email'] == 'y')? 'checked' : '';
		$mailCheckN = ($MemberData['iso_email'] == 'n')? 'checked' : '';

		if ( $Group['iso_hphone'] == 'y' )
		{
			echo "
					<tr>
						<th>핸드폰인증 유무</th>
						<td><input type='radio' name='iso_hphone' value='y'class='input_chk' $phoneCheckY />인증완료 <input type='radio' name='iso_hphone' value='n' class='input_chk' $phoneCheckN />미인증</td>
					</tr>
			";
		}

		if ( $Group['iso_email'] == 'y' )
		{
			echo "
					<tr>
						<th>이메일인증 유무</th>
						<td>
							<input type='radio' name='iso_email' value='y' class='input_chk' $mailCheckY />인증완료
							<input type='radio' name='iso_email' value='n' class='input_chk' $mailCheckN />미인증
						</td>
					</tr>
			";
		}

		#포인트 변경
			echo "
					<tr>
						<th>포인트</th>
						<td>
							<input type='text' name='point' value='$MemberData[point]' />
						</td>
					</tr>
			";


		#회원그룹변경폼
		echo "
					<tr>
						<th>회원그룹선택</th>
						<td class='input_style_adm'>
							<label>$groupBox</label> <script type='text/javascript'>document.getElementById('groupSelect').value = '$MemberData[group]'</script> <a href='../happy_member_login.php?mode=admin_login_reg&member_login_id=".$MemberData['user_id']."' target='_blank' class='btn_small_stand'>회원으로 로그인</a>
						</td>
					</tr>
		";


		//성인인증여부
		$is_adult_checked = "";
		$MemberDataOption['is_adult'] = happy_member_option_get($happy_member_option_type,$MemberData['user_id'],'is_adult');
		if ( $MemberDataOption['is_adult'] == "1" )
		{
			$is_adult_checked = " checked ";
		}

		echo "
					<tr>
						<th>성인인증여부</th>
						<td>
							<input type='checkbox' name='is_adult' id='is_adult' value='1' style='width:13px; height:13px; vertical-align:middle;' $is_adult_checked> 체크시 성인인증완료
						</td>
					</tr>
		";
		//성인인증여부


		//이력서보기기간
		$MemberDataOption['guin_docview'] = happy_member_option_get($happy_member_option_type,$MemberData['user_id'],'guin_docview');

		#이력서 보기 날짜 리얼갭을 빼서 남은 날짜로 출력
		$MemberDataOption['guin_docview'] = $MemberDataOption['guin_docview'] - $real_gap;
		if ($MemberDataOption['guin_docview'] < 0 )
		{
			$MemberDataOption['guin_docview'] = "0";
		}

		echo "
					<tr>
						<th>이력서 보기기간</th>
						<td>
							<input type='text' name='guin_docview' value='$MemberDataOption[guin_docview]' />
						</td>
					</tr>
		";

		//이력서보기회수
		$MemberDataOption['guin_docview2'] = happy_member_option_get($happy_member_option_type,$MemberData['user_id'],'guin_docview2');
		echo "
					<tr>
						<th>이력서보기 회수</th>
						<td>
							<input type='text' name='guin_docview2' value='$MemberDataOption[guin_docview2]' />
						</td>
					</tr>
		";


		//SMS문자발송개수 기업회원용
		$MemberDataOption['guin_smspoint'] = happy_member_option_get($happy_member_option_type,$MemberData['user_id'],'guin_smspoint');
		echo "
					<tr>
						<th>SMS 발송가능건수<br>(일반회원에게발송시 사용)</th>
						<td>
							<input type='text' name='guin_smspoint' value='$MemberDataOption[guin_smspoint]' />
						</td>
					</tr>
		";

		//채용정보보기기간
		$MemberDataOption['guzic_view'] = happy_member_option_get($happy_member_option_type,$MemberData['user_id'],'guzic_view');

		#채용정보보기기간 리얼갭을 빼서 남은 날짜로 출력
		$MemberDataOption['guzic_view'] = $MemberDataOption['guzic_view'] - $real_gap;
		if ( $MemberDataOption['guzic_view'] < 0 )
		{
			$MemberDataOption['guzic_view'] = "0";
		}

		echo "
					<tr>
						<th>채용정보보기 기간</th>
						<td>
							<input type='text' name='guzic_view' value='$MemberDataOption[guzic_view]' />
						</td>
					</tr>
		";

		//채용정보보기회수
		$MemberDataOption['guzic_view2'] = happy_member_option_get($happy_member_option_type,$MemberData['user_id'],'guzic_view2');
		echo "
					<tr>
						<th>채용정보보기 회수</th>
						<td>
							<input type='text' name='guzic_view2' value='$MemberDataOption[guzic_view2]' />
						</td>
					</tr>
		";


		//SMS문자발송개수 개인회원용
		$MemberDataOption['guzic_smspoint'] = happy_member_option_get($happy_member_option_type,$MemberData['user_id'],'guzic_smspoint');
		echo "
					<tr>
						<th>SMS 발송가능건수<br>(기업회원에게발송시 사용)</th>
						<td>
							<input type='text' name='guzic_smspoint' value='$MemberDataOption[guzic_smspoint]' />
						</td>
					</tr>
		";


		//채용정보 점프
		if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
		{
			$MemberDataOption['guin_jump'] = happy_member_option_get($happy_member_option_type,$MemberData['user_id'],'guin_jump');
			echo "
					<tr>
						<th>채용정보점프 회수</th>
						<td>
							<input type='text' name='guin_jump' value='$MemberDataOption[guin_jump]' />
						</td>
					</tr>
			";
		}


		echo "

				</table>
			</div>

			<script>
			if (document.getElementById('user_pass2') != undefined )
			{
				document.getElementById('user_pass2').style.display	= 'none';
			}
			</script>

			<div align='center'>
				<input type='submit' value='등록' class='btn_big'> <A HREF=\"happy_member.php\" class='btn_big_gray'>목록</A>
			</div>
			</form>

		";



	}
	else if ( $type == "reg" )
	{

		#echo "<pre>";print_r($_POST);echo"</pre>";exit;







		if (!is_dir("../$happy_member_upload_folder")){
			error("첨부파일을 위한 (../$happy_member_upload_folder)폴더가 존재하지 않습니다.  ");
			exit;
		}

		$now_year	= date("Y");
		$now_month	= date("m");
		$now_day	= date("d");

		$now_time	= happy_mktime();

		$oldmask = umask(0);
		if (!is_dir("$happy_member_upload_path/$now_year")){
			mkdir("$happy_member_upload_path/$now_year", 0777);
		}
		if (!is_dir("$happy_member_upload_path/$now_year/$now_month")){
			mkdir("$happy_member_upload_path/$now_year/$now_month", 0777);
		}
		if (!is_dir("$happy_member_upload_path/$now_year/$now_month/$now_day")){
			mkdir("$happy_member_upload_path/$now_year/$now_month/$now_day", 0777);
		}
		umask($oldmask);


		$number				= preg_replace("/\D/","",$_POST['number']);
		$start				= preg_replace("/\D/","",$_POST['start']);
		$search_word		= $_POST['search_word'];
		$search_type		= $_POST['search_type'];

		if ( $number == '' )
		{
			error("고유번호가 넘어오지 않았습니다.");
			exit;
		}


		if ( strlen($_POST['user_jumin2']) != 32 )
		{
			$_POST['user_jumin2']		= Happy_Secret_Code($_POST['user_jumin2']);
		}


		$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member WHERE number='$number'"));
		if ( $MemberData['number'] == '' )
		{
			error("존재하지 않는 회원정보 입니다.");
			exit;
		}

		$_GET['member_group']	= $MemberData['group'];
		$member_group			= $MemberData['group'];

		//이력서가 없으면 사진을 지우자
		$sql33 = "select count(*) from $per_document_tb where user_id = '".$MemberData['user_id']."'";
		$result33 = query($sql33);
		list($doc_cnt) = happy_mysql_fetch_array($result33);
		//이력서가 없으면 사진을 지우자


		$Sql	= "SELECT * FROM $happy_member_field WHERE member_group = '$member_group' ";
		$Record	= query($Sql);

		$Cnt	= 0;
		$SetSql	= '';
		while ( $Form = happy_mysql_fetch_array($Record) )
		{
			//print_r($Form);

			$Fields	= call_happy_member_field($Form['field_name']);
			//echo "<pre>";			print_r($Fields);			echo "</pre>";
			//echo "$".$Fields['Field'] ."  = ". $_POST[$Fields['Field']]."<hr>";

			$nowField	= $Fields['Field'];

			if ( $nowField == '' )
			{
				continue;
			}



			if ( $Form['field_modify'] != 'y' && $Form['field_use_admin'] != 'y' )
			{
				continue;
			}



			// 회원 폼양식에 이메일폼 전화번호폼 추가 2017-01-31 x2chi
			// 이메일폼
			if(
				is_null($_POST[$Fields['Field']])
				&&
				(
					strlen($_POST[$Fields['Field']."_at_user"]) > 0
					||
					strlen($_POST[$Fields['Field']."_at_host"]) > 0
				)
			)
			{
				$_POST[$Fields['Field']]	= $_POST[$Fields['Field']."_at_user"]."@".$_POST[$Fields['Field']."_at_host"];
			}
			// 연락처폼
			if(array_key_exists($Fields['Field']."_tel_first",$_POST))
			{
				$_POST[$Fields['Field']]	= $_POST[$Fields['Field']."_tel_first"];
				$_POST[$Fields['Field']]	.= "-".$_POST[$Fields['Field']."_tel_second"];
				$_POST[$Fields['Field']]	.= "-".$_POST[$Fields['Field']."_tel_third"];
			}



			${$Fields['Field']}	= $_POST[$Fields['Field']];
			if ( $happy_autoslashes )
			{
				${$nowField}	= addslashes(${$nowField});
			}


			# DB형식이 INT형일때
			if ( preg_match("/int/", $Fields['Type']) )
			{
				${$nowField}	= preg_replace("/\D/", "", ${$nowField});
			}

			# 파일 업로드
			if ( $Form['field_type'] == 'file' )
			{

				${$nowField}	= '';

				if ( $_POST[$nowField.'_del'] == 'ok' && $MemberData[$nowField] != '' && $_FILES[$nowField]["name"] == "")
				{
					$nowFile		= $MemberData[$nowField];

					//이력서가 없으면 사진을 지우자
					if ( $demo_lock != "" && $doc_cnt == 0 )
					{
						happy_member_image_unlink("../$nowFile",Array("_thumb","_thumb2"));
					}
					//이력서가 없으면 사진을 지우자



					$SetSql			.= ( $SetSql == '' )? '' : ', ';
					$SetSql			.= " $nowField = '' \n";
				}
				if ( $_FILES[$nowField]["name"] != "" )
				{
					#echo $nowField."<br>";
					$upImageName	= $_FILES[$nowField]["name"];
					$upImageTemp	= $_FILES[$nowField]["tmp_name"];


					$temp_name		= explode(".",$upImageName);
					$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

					$options		= explode(",",$Form['field_option']);

					#echo $ext ."- ".$Form['field_option']." - ". sizeof($options)."<hr>";

					for ( $z=0,$m=sizeof($options),$ext_check='' ; $z<$m ; $z++ )
					{
						#echo " $ext = ".$options[$z] ."<br>";
						if ( $ext == trim($options[$z]))
						{
							$ext_check	= 'ok';
							break;
						}
					}


					if ( $ext_check != 'ok' && $_POST[$nowField."_del"] != 'ok' )
					{
						$addMessage	= "\\n\\n$nowField 필드 : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $Form[field_option] 입니다.";
						#echo $addMessage;
						continue;
					}
					else
					{
						$rand_number =  rand(0,1000000);
						$img_url_re			= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";
						$img_url_re_thumb	= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb.$ext";
						$img_url_re_thumb2	= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb2.$ext";
						$img_url_file_name	= "${happy_member_upload_folder}$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";

						if (copy($upImageTemp,"$img_url_re"))
						{

							${$nowField}	= $img_url_file_name;

							//$nowField : photo1 -> 개인회원 사진
							//$nowField : photo2 -> 개인회원이력서 사진
							//$nowField : photo3 -> 개인회원이력서 사진

							if ( $nowField == "photo1" )
							{
								$happy_member_image_width = $PerPhotoDstW;
								$happy_member_image_height = $PerPhotoDstH;
								$happy_member_image_type = $PerPhotoCreateType;
							}
							else if ( $nowField == "photo2" )
							{
								$happy_member_image_width = $ComLogoDstW;
								$happy_member_image_height = $ComLogoDstH;
								$happy_member_image_type = $ComPhotoCreateType1;
							}
							else if ( $nowField == "photo3" )
							{
								$happy_member_image_width = $ComBannerDstW;
								$happy_member_image_height = $ComBannerDstH;
								$happy_member_image_type = $ComPhotoCreateType2;
							}



							$SetSql			.= ( $SetSql == '' )? '' : ', ';
							$SetSql			.= " $nowField = '".${$nowField}."' \n";

							if ($happy_member_image_width && $happy_member_image_height )
							{
								happyMemberimageUpload(
										$img_url_re,								#원본파일 경로
										$img_url_re_thumb,							#썸네일 저장 경로
										$happy_member_image_width,					#썸네일 가로크기
										$happy_member_image_height,					#썸네일 세로크기
										$happy_member_image_quality,				#썸네일 퀄리티
										$happy_member_image_type,					#썸네일 추출타입
										$happy_member_image_position,				#썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
										$happy_member_image_logo,					#썸네일 로고
										$happy_member_image_logo_position			#썸네일 로고 위치
								);
							}

							if ($happy_member_image_width2 && $happy_member_image_height2 )
							{
								happyMemberimageUpload(
										$img_url_re,								#원본파일 경로
										$img_url_re_thumb2,							#썸네일 저장 경로
										$happy_member_image_width2,					#썸네일 가로크기
										$happy_member_image_height2,				#썸네일 세로크기
										$happy_member_image_quality2,				#썸네일 퀄리티
										$happy_member_image_type2,					#썸네일 추출타입
										$happy_member_image_position2,				#썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
										$happy_member_image_logo2,					#썸네일 로고
										$happy_member_image_logo_position2			#썸네일 로고 위치
								);

							}

							# 새로운 파일이 업로드 되었으니 기존 파일 제거
							if ( $MemberData[$nowField] != '' )
							{
								$nowFile		= $MemberData[$nowField];

								//이력서가 없으면 사진을 지우자
								if ( $demo_lock != "" && $doc_cnt == 0 )
								{
									happy_member_image_unlink("../$nowFile",Array("_thumb","_thumb2"));
								}
								//이력서가 없으면 사진을 지우자

							}


						} #copy 완료마지막
					}
				}
			}
			else
			{

				if ( is_array(${$nowField}) )
				{
					${$nowField}	= @implode(",", (array) ${$nowField});
				}

				if ( $Form['field_sureInput'] == 'y' && $Form['field_use'] == 'y' && ${$nowField} == '' )
				{
					#echo $Form['field_name'] ." 필드의 값이 넘어오지 않았습니다.";
					#error( $Form['field_name'] ." 필드의 값이 넘어오지 않았습니다. ");
					#exit;
				}

				if ( $nowField == "user_pass" )
				{
					if ( $MemberData['user_pass'] == ${$nowField} )
					{
						continue;
					}
					else
					{
						${$nowField} = Happy_Secret_Code( ${$nowField} );
					}
				}

				if($nowField == "user_pass" && $_POST['user_pass'] == "" && $_POST['user_pass2'] == "")
				{
				}
				else
				{
					$SetSql	.= ( $SetSql == '' )? '' : ', ';
					$SetSql	.= " $nowField = '".${$nowField}."' \n";
				}
			}
		}


		#echo nl2br($SetSql);
		$SetSql	.= ( $SetSql == '' )? '' : ', ';

		$SetSql .= "point = '$point'";
		$SetSql .= ( $iso_hphone )? ", iso_hphone	= '$iso_hphone'" : '';
		$SetSql .= ( $iso_email )? ", iso_email	= '$iso_email'" : '';
		$SetSql .= ( $_POST['groupSelect'] )? ", `group` = '$_POST[groupSelect]'" : '';

		$Sql	= "
					UPDATE
							$happy_member
					SET
							$SetSql
					WHERE
							number		= '$number'
							AND
							user_id		= '$MemberData[user_id]'
		";
		//print_R($_POST);
		//echo nl2br($Sql);exit;
		query($Sql);


		//인접매물 2010-10-12 kad
		$addr1 = $_POST['user_addr1'];
		$addr2 = $_POST['user_addr2'];


		if ( $addr1 != '' )# && $_POST['addr2'] != ''
		{



			$nowAddr		= $addr1 .' '. $addr2 ;

			global $wgs_get_type;
			if ( $wgs_get_type == 'google' )
			{
				$data			= getcontent_wgs_google($nowAddr);

				$ypoint			= getpoint($data,"<lat>","</lat>");
				$xpoint			= getpoint($data,"<lng>","</lng>");

				$wgsArr			= get_wgs_point($xpoint[0], $ypoint[0]);
			}
			else
			{
				if( $wgs_get_type == 'naver' )
				{
					$data				= getcontent_wgs($nowAddr);
				}
				else
				{
					$data				= getcontent_wgs_daum($nowAddr);
				}

				$xpoint			= getpoint($data,"<y>","</y>");
				$ypoint			= getpoint($data,"<x>","</x>");
				$xpoint			= $xpoint[0];
				$ypoint			= $ypoint[0];

				$wgsArr			= get_wgs_point($ypoint, $xpoint);
			}


			$Sql	= "
						UPDATE
								$happy_member
						SET
								x_point		= '$wgsArr[x_point]',
								y_point		= '$wgsArr[y_point]',
								x_point2	= '$wgsArr[x_point2]',
								y_point2	= '$wgsArr[y_point2]'
						WHERE
								user_id	= '$MemberData[user_id]'
			";
			query($Sql);
		}
		else
		{
			$Sql	= "
						UPDATE
								$happy_member
						SET
								x_point		= '0',
								y_point		= '0',
								x_point2	= '0',
								y_point2	= '0'
						WHERE
								user_id	= '$MemberData[user_id]'
			";
			query($Sql);
		}
		//인접매물 2010-10-12 kad



		//성인인증여부
		if ( $_POST['is_adult'] == "1" )
		{
			happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'is_adult',1,'int(11)');
		}
		else
		{
			happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'is_adult',0,'int(11)');
		}
		//성인인증여부

		//이력서보기기간
		if ( $_POST['guin_docview'] != "" )
		{
			$guin_docview = $_POST['guin_docview'] + $real_gap;
			happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'guin_docview',$guin_docview,'int(11)');
		}
		//이력서보기회수
		if ( $_POST['guin_docview2'] != "" )
		{
			happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'guin_docview2',$_POST['guin_docview2'],'int(11)');
		}
		//채용정보보기기간
		if ( $_POST['guzic_view'] != "" )
		{
			$guzic_view = $_POST['guzic_view'] + $real_gap;
			happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'guzic_view',$guzic_view,'int(11)');
		}
		//채용정보보기회수
		if ( $_POST['guzic_view2'] != "" )
		{
			happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'guzic_view2',$_POST['guzic_view2'],'int(11)');
		}
		//SMS문자발송개수 기업용
		if ( $_POST['guin_smspoint'] != "" )
		{
			happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'guin_smspoint',$_POST['guin_smspoint'],'int(11)');
		}
		//SMS문자발송개수 개인용
		if ( $_POST['guzic_smspoint'] != "" )
		{
			happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'guzic_smspoint',$_POST['guzic_smspoint'],'int(11)');
		}

		//채용정보 점프
		if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
		{
			if ( $_POST['guin_jump'] != "" )
			{
				happy_member_option_set($happy_member_option_type,$MemberData['user_id'],'guin_jump',$_POST['guin_jump'],'int(11)');
			}
		}
		//채용정보 점프

		go("?start=$start&search_word=$search_word&search_type=$search_type&group_select=$_POST[group_select]&number=$_POST[number]&type=add");
		exit;




	}
	else if ( $type == "del" )							#회원 삭제하기 ##################################################
	{
		#echo "<pre>";print_r($_GET);echo "</pre>";exit;
		$number			= preg_replace("/\D/","",$_GET['number']);
		$start			= preg_replace("/\D/","",$_GET['start']);
		$search_word	= $_GET['search_word'];
		$search_type	= $_GET['search_type'];


		$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member WHERE number='$number'"));
		if ( $MemberData['number'] == '' )
		{
			error("존재하지 않는 회원정보 입니다.");
			exit;
		}
		$_GET['member_group']	= $MemberData['group'];
		$member_group			= $MemberData['group'];


		#회원정보 삭제
		$Sql	= "DELETE FROM $happy_member WHERE number='$number' ";
		#echo $Sql."<hr>";
		query($Sql);

		#탈퇴회원 아이디 및 탈퇴IP남기기
		$Sql	= "INSERT INTO $happy_member_out SET out_id='$MemberData[user_id]', out_date=now(), out_ip='$_SERVER[REMOTE_ADDR]'";
		#echo $Sql."<hr>";
		query($Sql);



		#탈퇴회원 사진 삭제
		$Sql	= "SELECT * FROM $happy_member_field WHERE member_group = '$member_group' ";
		$Record	= query($Sql);

		$Cnt	= 0;
		$SetSql	= '';
		while ( $Form = happy_mysql_fetch_array($Record) )
		{
			$nowField	= $Form['field_name'];

			if ( $nowField == '' )
			{
				continue;
			}

			if ( $Form['field_modify'] != 'y' && $Form['field_use_admin'] != 'y' )
			{
				continue;
			}

			# 파일일때
			if ( $Form['field_type'] == 'file' && $MemberData[$nowField] != '' )
			{
				if ( $demo_lock != "" )
				{
					$nowFile	= $MemberData[$nowField];

					#echo $nowFile."<hr>";
					happy_member_image_unlink("../$nowFile",Array("_thumb","_thumb2"));
				}
			}

		}







		gomsg("삭제되었습니다.","?start=$start&search_word=$search_word&search_type=$search_type");
		exit;
	}






	############################################################################################################################
	#################################################### 탈퇴회원 관리 #########################################################
	############################################################################################################################



	if ( $type == "outList" )									# 탈퇴회원 리스트출력 ################################################
	{
		#검색
		$search_type	= $_GET["search_type"];
		$search_word	= $_GET["search_word"];

		$WHERE		= "";
		if ( $search_word != "" )
		{
			$WHERE	.= " AND $search_type like '%${search_word}%' ";
		}



		####################### 페이징처리 ########################
		$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
		$scale			= 15;

		$WHERE			.= $group_select == '' ? "" : " AND level='$group_select' ";

		$Sql	= "select count(*) from $happy_member_out WHERE 1=1 $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Count	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 6;

		$searchMethod	= "";
			#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
				$searchMethod	.= "&type=$type&search_word=$search_word&search_type=$search_type&group_select=$group_select";
			#검색값 입력완료

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################


		$Sql	= "SELECT * FROM $happy_member_out WHERE 1=1 $WHERE ORDER BY number desc LIMIT $start,$scale ";
		$Record	= query($Sql);

		$groupBox	= str_replace("__onChange__","onChange='this.form.submit()'",$groupBox);


		$FieldTitleContent	.= "
					<th style='width:40px;'>번호</th>
					<th>아이디</th>
					<th style='width:150px;'>탈퇴시간</th>
					<th style='width:120px;'>탈퇴IP</th>
					<th style='width:60px;'>관리툴</th>
		";


		#탈퇴회원리스트
		echo "
				<script>
					function review_del(no)
					{
						if ( confirm('정말 삭제하시겠습니까?') )
						{
							window.location.href = '?type=out_del&start=$start&search_word=$search_word&search_type=$search_type&number='+no;
						}
					}
					</script>

					<script language='javascript'>
					function OpenWindow(url,intWidth,intHeight) {
					window.open(url, '_blank', 'width='+intWidth+',height='+intHeight+',resizable=1,scrollbars=1');
					}
				</script>

				<div class='main_title'>
					탈퇴회원관리 <span class='font_st_11'>탈퇴회원을 삭제하면 회원이 등록한 모든 정보가 삭제됩니다.</span>
				</div>

				<div class='help_style' style='margin-top:10px;'>
					<div class='box_1'></div>
					<div class='box_2'></div>
					<div class='box_3'></div>
					<div class='box_4'></div>
					<span class='help'>검색</span>
					<p>
						<form name='search_frm' action='?'>
						<input type='hidden' name='type' value='$type'>
							<table cellspacing='0' cellpadding='0' style='width:100%;'>
							<tr>
								<td style='width:150px; height:34px;'><strong>키워드</strong></td>
								<td>
									<table cellspacing='0' cellpadding='0'>
									<tr>
										<td class='input_style_adm'>
											<label id='search_frm_onoff'>
											<!-- <font color=gray class=thin>/</font> -->
											<select name='search_type'>
											<option value='out_id' >아이디</option>
											<option value='out_date'>시간</option>
											<option value='out_ip' >IP</option>
											</select>
											</label>
										</td>
										<td class='input_style_adm' style='padding-left:3px;'><input type='text' name='search_word' value='$_GET[search_word]' id='search_word' style='width:300px; padding-left:3px; border:1px solid #ccc;'></td>
										<td style='padding-left:3px;'><input type='submit' value='검색' id='search_btn' class='btn_small_blue' style='height:29px'></td>
									</tr>
									</table>
								</td>
							</tr>
							</table>
						</form>
					</p>
				</div>

				<div class='help_style'>
					<div class='box_1'></div>
					<div class='box_2'></div>
					<div class='box_3'></div>
					<div class='box_4'></div>
					<span class='help'>도움말</span>
					<p>
					탈퇴회원을 삭제하면 회원이 등록한 모든 정보가 삭제됩니다.<br>
					단, 탈퇴회원관리 리스트에서 삭제하지않으면 탈퇴한 회원의 아이디로는 중복아이디로 체크되어 가입이 불가능합니다.
					</p>
				</div>

				<!-- <form name=\"category_del_frm\" method=\"post\" action=\"category_delete.php\" >
				<input type=\"hidden\" name=\"number\" value=\"\">
				</form> -->

				<div id='list_style'>
					<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
					<tr>
						$FieldTitleContent
					</tr>
		";




		$nowDate			= date("Y-m-d");
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$out_date			= substr($Data['out_date'],0,10);

			$out_date			= $nowDate == $out_date  ? substr($Data['out_date'],10,9)  : $out_date;



			echo "
				<tr>
					<td style='text-align:center; height:34px'>$listNo</td>
					<td>$Data[out_id]</td>
					<td style='text-align:center;'><b>$Data[out_date]</b></td>
					<td style='text-align:center;'>$Data[out_ip]</td>
					<td style='text-align:center; padding:10px 0 10px 0;'><a href='#delete' onClick=\"review_del('$Data[number]')\" title=\"탈퇴 회원정보 삭제\" class='btn_small_gray'>삭제</a></td>
				</tr>

			";
			$listNo--;

		}


		echo "

					</table>
				</div>
				<!-- 탈퇴회원 리스트 [ end ] -->
			<div style='padding:5px 0 10px 0;'>
				<a href='./happy_member.php' class='btn_small_blue'>전체회원보기</a>
				<a title='탈퇴회원 일괄삭제' alt='탈퇴회원 일괄삭제' onClick=\"if(confirm('정말 모두 삭제하시겠습니까?')){location.replace('happy_member.php?type=out_del_all');}\" class='btn_small_dark'>탈퇴회원 일괄삭제</a>
			</div>
			<div align='center'>$paging</div>
		";


	}

	else if ( $type == 'out_del' || $type == 'out_del_all' )
	{
		#echo "<pre>";print_r($_GET);echo "</pre>";exit;
		$number			= preg_replace("/\D/","",$_GET['number']);
		$start			= preg_replace("/\D/","",$_GET['start']);
		$search_word	= $_GET['search_word'];
		$search_type	= $_GET['search_type'];


		$WHERE			= "";
		if($type == "out_del")
		{
			$WHERE		.= " AND number='$number' ";
			$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member_out WHERE 1=1 $WHERE "));
			if ( $MemberData['number'] == '' )
			{
				error("존재하지 않는 회원정보 입니다.");
				exit;
			}
		}

		while(list($id)	= happy_mysql_fetch_array(query("SELECT out_id FROM $happy_member_out WHERE 1=1 $WHERE ")))
		{
			#회원정보 삭제
			$Sql	= "DELETE FROM $happy_member_out WHERE 1=1 $WHERE ";
			#echo $Sql."<hr>";
			query($Sql);



			$id	= str_replace(' ', '', $id);

			if ( $id != '' )
			{
				$result		= happy_mysql_list_tables($db_name);
				$max		= sizeof($member_out_delete_table);

				while ( $row = mysql_fetch_row($result))
				{
					for($i=0 ; $i < $max ; $i++ )
					{
						if($row[0] == $member_out_delete_table[$i])
						{
							$Sql = "DELETE FROM $member_out_delete_table[$i] WHERE $member_out_delete_where_field[$i] = '$id'";
							query($Sql);
						}
					}
				}
			}


			#삭제될 회원의 모든 게시판 글을 삭제하자!
			$Sql		= "SELECT * from $board_list";
			$Result		= query($Sql);

			while( $Data = happy_mysql_fetch_array($Result) )
			{
				query("DELETE FROM $Data[tbname] WHERE bbs_id = '$id'");
			}

			#댓글도 삭제해 주자!
			query("DELETE FROM $board_short_comment WHERE id = '$id'");

		}




		gomsg("삭제되었습니다.","?type=outList&start=$start&search_word=$search_word&search_type=$search_type");
		exit;
	}



################################################
#하단부분 HTML 소스코드
include ("tpl_inc/bottom.php");
################################################



?>