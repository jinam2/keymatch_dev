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
	$groupMemberTitle	= "휴면회원";
	$groupBox			= happy_member_make_group_box('group_select', '-- 회원그룹별 보기 --');





	if ( $type == "" || $type == "quies_expect")									# 회원 리스트출력 ################################################
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

		if($type == "")
		{
			$member_table			= $happy_member_quies;
			$quies_class_01			= ""; //휴면회원 리스트
			$quies_clear_button		= "<a href='javascript:void(0);' style='text-decoration:none' onClick=\"member_move_chk('quies');\"  class='btn_small_yellow'>선택회원 휴면회원해제</a>";
			$quies_expect_button	= "";
			$clear_button_display	= "";
		}
		else if($type == "quies_expect") //휴면회원 예정
		{
			$member_table			= $happy_member;
			$quies_class_02			= ""; //휴면회원 예정 리스트
			$quies_clear_button		= "";
			$quies_expect_button	= "<a href='javascript:void(0);' style='text-decoration:none' onClick=\"location.href='happy_member_quies.php?type=quies_mail_expect&start=$start&search_word=$search_word&search_type=$search_type'\" class='btn_small_yellow'>휴면회원 처리예정메일 일괄발송</a>";
			$clear_button_display	= "display:none";
			$quies_chk_mail_date	= date("Y-m-d", strtotime(date("Y-m-d")."-{$HAPPY_CONFIG[quies_mail_day]} day"));	//휴면회원 예정 처리 기준일 몇일전
			$WHERE					.= " AND '$quies_chk_mail_date' >= login_date ";
		}


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

		$Sql	= "select count(*) from $member_table WHERE 1=1 $WHERE ";
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
				$searchMethod	.= "&type=$_GET[type]";
			#검색값 입력완료

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		###################### 페이징처리 끝 #######################

		#회원 정보공개 관련 카운트
		$MEM_CNT_FIELD				= Array("email_forwarding","sms_forwarding","state_open");
		foreach($MEM_CNT_FIELD AS $mcf_val)
		{
			${"Sql_".$mcf_val}			= "SELECT count(*) FROM $member_table WHERE 1=1 AND {$mcf_val}='y' $WHERE  ";
			${"Rec_".$mcf_val}			= query(${"Sql_".$mcf_val});
			$MEM_CNT					= mysql_fetch_row(${"Rec_".$mcf_val});
			${$mcf_val."_comma"}		= number_format($MEM_CNT[0]);
		}
		#회원 정보공개 관련 카운트 END


		// 2013-03-21 woo 검색 회원 아이디 모음
		$search_member_goMessage_Array		= Array();
		$search_member_goMessage_sql		= "SELECT user_id FROM $member_table WHERE 1=1 $WHERE ";
		$search_member_goMessage_result		= query($search_member_goMessage_sql);
		while($search_member_goMessage_data = happy_mysql_fetch_array($search_member_goMessage_result))
		{
			$search_member_goMessage_Array[]	= $search_member_goMessage_data['user_id'];
		}
		$search_member_goMessage_id			= implode(",", (array)  $search_member_goMessage_Array);
		// 2013-03-21 woo 검색 회원 아이디 모음

		$Sql	= "SELECT * FROM $member_table WHERE 1=1 $WHERE ORDER BY number desc LIMIT $start,$scale ";
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
		$FieldTitleContent	= "<th style='width:40px;'><label onclick='all_check_memberlist()' style='cursor:pointer;'>선택</label></th>";
		$FieldTitleContent	.= "<th style='width:45px;'>번호</th>";
		while ( $Tmp = happy_mysql_fetch_array($FieldRec) )
		{
			$count++;

			$tdWidth	= ( $fieldAdminTdWidth[$Tmp['field_name']] == '' )? '120' : $fieldAdminTdWidth[$Tmp['field_name']];
			$FieldTitleContent	.= "<th width=$tdWidth class=tbl_item_hm_".$Tmp[field_name]." nowrap><label>$Tmp[field_title]</label></th>";
		}

		$FieldTitleContent	.= "
					<!-- <th>로고변경</th> -->
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

					function member_move(no)
					{
						if ( confirm('휴면회원 해제를 하시겠습니까?') )
						{
							window.location.href = '?type=member_move&start=$start&search_word=$search_word&search_type=$search_type&number='+no;
						}
					}




					var ox_value = 0;
					function all_check_memberlist()
					{
						var name	= 'set_member_check[]';
						var lng		= document.getElementsByName(name).length;
						var ox		= '';

						if(ox_value == 0)
						{
							ox			= true;
							ox_value	= 1;
						} else {
							ox			= false;
							ox_value	= 0;
						}

						for( var i = 0; i < lng; i++)
						{
							document.getElementsByName(name)[i].checked = ox;
						}
					}


					function member_move_chk(move_type)
					{
						var obj		= document.getElementsByName('set_member_check[]');
						var tmp		= new Array();
						var k		= 0;

						for( var i = 0; i < obj.length; i++)
						{
							if(obj[i].checked == true)
							{
								tmp[k] = document.getElementById(obj[i].value + '_user_id').value;
								k++;
							}
						}
						tmp.join(\",\");

						member_move_action(move_type,tmp);
					}

					function member_move_action(move_type,id)
					{
						var form = document.forms['message_form'];
						form.receiveid.value = id;
						if ( form.receiveid.value != '' )
						{
							if(move_type == 'quies')
							{
								var type_var	= 'member_move';
								var type_msg	= '체크된 회원을 휴면해제를 하시겠습니까?';
							}
							else if(move_type == 'del')
							{
								var type_var	= 'del';
								var type_msg	= '체크된 회원을 삭제 하시겠습니까?';
							}

							if ( confirm(type_msg) )
							{
								form.action   = '?type='+type_var+'&start=$start&search_word=$search_word&search_type=$search_type';
								form.submit();
							}
						}
						else
						{
							alert('회원을 선택해 주세요');
						}
					}





					</script>

					<script language='javascript'>
					function OpenWindow(url,intWidth,intHeight) {
					window.open(url, '_blank', 'width='+intWidth+',height='+intHeight+',resizable=1,scrollbars=1');
					}
				</script>

				<!-- 검색회원, 체크회원 쪽지발송 POST로 변경 hong -->
				<form name='message_form' method='post' style='margin:0;'>
					<input type='hidden' name='receiveid' id='receiveid' value=''>
				</form>

				<div class='main_title'>
					<span style='color:#0088ff;'>[휴면회원]</span> 정보관리
					<label>
						<span class='font_st_11'>등록회원 총</span>
						<span class='font_st_12_tahoma'><strong>$Total</strong> </span>
						<span class='font_st_11'>명</span>
					</label>
				</div>

				<div class='help_style' style='margin-top:20px;'>
					<div class='box_1'></div>
					<div class='box_2'></div>
					<div class='box_3'></div>
					<div class='box_4'></div>
					<span class='help'>도움말</span>
					<p class='font-s'>
					* <b>데모 모드</b> 일 경우 휴면회원처리, 해제가 되지 않습니다<br>
					* 회원스스로 휴면해제를 할 수 있는 방법은 로그인, 아이디, 패스워드 찾기를 통해 가능합니다.<br>
					* 선택회원 휴면해제 : 휴면상태를 벗어나 전체회원리스트로 이동되며 마지막 로그인 날짜는 오늘로 변경됩니다.<br>
					* 선택회원 삭제 : 휴면회원에서 탈퇴회원으로 정보가 이동됩니다.<br>
					* 휴면회원 처리예정메일 일괄발송 : 휴면회원으로 처리된 회원이 아닌 처리예정인 회원에게 휴면회원 처리일을 알리는 이메일을 발송합니다.
					</p>
				</div>

				<table cellspacing='0' cellpadding='0' style='width:100%; background:#f9f9f9; border:1px solid #dfdfdf;'>
				<tr>
					<td style='padding:10px;'>
						<form name='search_frm' action='happy_member_quies.php' style='margin:0;'>
						<input type='hidden' name='type' value='$_GET[type]'>
						<table cellspacing='0' cellpadding='0' >
						<tr>
							<td class='input_style_adm' style='padding-left:5px;'>
								<select name='search_type' style='width:100px;'>
									<option value=''>--선택--</option>
									<option value='user_id'>아이디</option>
									<option value='user_homepage'>홈페이지</option>
									<option value='user_nick'>닉네임</option>
								</select>

								<script>
								document.search_frm.search_type.value = '$_GET[search_type]';
								</script>
							</td>

							<td class='input_style_adm' style='padding-left:3px;'>
								<input type='text' style='width:740px; background:#f1f1f1;' name='search_word' value='$_GET[search_word]' id='search_word' >
							</td>
							<td style='padding-left:3px;'><input type='submit' value='검색하기'  class='btn_small_dark2' id=search_btn></td>
						</tr>
						</table>
						</form>
					</td>
				</tr>
				</table>

				<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style='margin-top:30px;'>
				<tr>
					<td align='left'>
						$quies_clear_button

						<a href='javascript:void(0);' style='text-decoration:none' onClick=\"member_move_chk('del');\" class='btn_small_yellow'>선택회원 삭제</a>

						$quies_expect_button

					</td>
					<td align='right'>
						<a href='happy_member_quies.php' style='text-decoration:none' class='btn_small_dark'><span class='$quies_class_01'>휴면회원 리스트</span></a>
						<a href='happy_member_quies.php?type=quies_expect' style='text-decoration:none' class='btn_small_dark'><span class='$quies_class_02'>휴면회원 예정리스트</span></a>
					</td>

				</tr>
				</table>


				<div id='list_style' style='margin-top:10px;'>
					<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
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
					<td align='center'>
						<input type='checkbox' name=\"set_member_check[]\" value=\"$Data[number]\">
						<input type=\"hidden\" name=\"${Data[number]}_user_id\" id=\"${Data[number]}_user_id\" value=\"$Data[user_id]\" />
					</td>
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
						$tdWidth	= ( $fieldAdminTdWidth[$Tmp['field_name']] == '' )? '80' : $fieldAdminTdWidth[$Tmp['field_name']];
						$tdAlign	= ( $fieldAdminTdAlign[$Tmp['field_name']] == '' )? 'center' : $fieldAdminTdAlign[$Tmp['field_name']];

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
							$tdAlign					= 'center';
						}

						if ( $Tmp['field_name'] == "user_id" )
						{
							$user_id_info = outputSNSID($Data[$Tmp['field_name']]);

						}
						else if(preg_match("/user_email|user_phone|user_hphone/",$Tmp['field_name']))
						{
							$user_id_info	= kstrcut($Data[$Tmp['field_name']],10,"...");
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
			//$logo_change = "<a href='#1' onClick=\"window.open('../logo_change.php?number=".$Data['number']."&member_group=".$Data['group']."&member_id=".$Data['user_id']."','com_log','width=400,height=400,toolbar=no')\" class='btn_small_gray'>로고변경</a>";

			if($type == "quies_expect")
			{
				$quies_date					= "<div style='padding:5px 0px; font-size:11px; margin-top:5px; text-align:center; font-family:Dotum; color:#999;'>처리예정 :<br/> ".date("Y년 m월 d일", strtotime($Data['login_date']."+{$HAPPY_CONFIG[quies_day]} day"))."</div>";
				;
			}
			else
			{
				$quies_del_buttons   = "
											<a href='#delete' onClick=\"member_move('$Data[number]')\" class='btn_small_red2' style='width:70px; margin:0 auto; display:block; $clear_button_display'>휴면회원해제</a> <a href='#delete' onClick=\"review_del('$Data[number]')\" class='btn_small_dark3' style='display:block; width:70px; margin:3px auto 0 auto;'>회원정보삭제</a>
										";
			}

			echo "
					<!-- <td class='b_border_td' style='text-align:center;'>$logo_change</td> -->
					<td class='b_border_td' style='text-align:center;'>$reg_date</td>
					<td class='b_border_td' style='text-align:center;'>$login_date</td>
					<td class='b_border_td' style='text-align:center;'>${login_count}<label>회</label></td>
					<td class='b_border_td' style='text-align:center; width:130px;'>
						{$quies_del_buttons}
						{$quies_date}
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



			<script>
				// 회원 쪽지 발송 woo
				function popup_gomessage(id)
				{
					var form = document.forms['message_form'];
					form.receiveid.value = id;
					if ( form.receiveid.value != '' )
					{
						window.open('','targetWindow','width=700,height=500,toolbar=no,scrollbars=no');
						form.target   = 'targetWindow';
						form.action   = '../happy_message.php?mode=send&senderAdmin=y&endMode=close';
						form.submit();
					}
					else
					{
						alert('쪽지를 발송할 회원이 없습니다.');
					}
				 }
			</script>

			<div align='center' style='margin-top:20px'>$paging</div>
		</form>

		<!-- 검색회원, 체크회원 쪽지발송 POST로 변경 hong -->
		<!--
		<form name='message_form' method='post' style='margin:0;'>
			<input type='hidden' name='receiveid' id='receiveid' value=''>
		</form>
		-->
		";


	}
	else if ( $type == "member_move" )	//휴면회원 해제
	{
		if($_POST['receiveid'] == "" && $_GET['number'] == "")
		{
			error("잘못된 접근입니다");
			exit;
		}

		if($_POST['receiveid'] != "")
		{
			$receiveid_ex		= explode(",",$_POST['receiveid']);
			$SWAP_ID			= Array();
			foreach($receiveid_ex AS $r_val)
			{
				$SWAP_ID[]		= "'".$r_val."'";
			}
			$WHERE				= " AND user_id IN(".implode(",",$SWAP_ID).")";
		}
		else if($_GET['number'] != "")
		{
			$WHERE				= " AND number=$_GET[number]";
		}


		$Sql					= "SELECT * FROM $happy_member_quies WHERE 1=1 $WHERE";
		$Rec					= query($Sql);
		while($MEMBER			= happy_mysql_fetch_assoc($Rec))
		{
			happy_member_quies_move('decrypt',$MEMBER);
		}

		gomsg("처리되었습니다.","?start=$start&search_word=$search_word&search_type=$search_type");
	}
	else if ( $type == "quies_mail_expect" )	//휴면회원 처리예정메일
	{
		happy_member_quies_mail('quies_mail_expect');

		gomsg("처리되었습니다.","?type=quies_expect&start=$start&search_word=$search_word&search_type=$search_type");
		exit;
	}
	else if ( $type == "del" )							#회원 삭제하기 ##################################################
	{
		#echo "<pre>";print_r($_GET);echo "</pre>";exit;
		if($_POST['receiveid'] != "")
		{
			$receiveid_ex		= explode(",",$_POST['receiveid']);
			$SWAP_ID			= Array();
			foreach($receiveid_ex AS $r_val)
			{
				$SWAP_ID[]		= "'".$r_val."'";
			}
			$WHERE				= " AND user_id IN(".implode(",",$SWAP_ID).")";
		}
		else if($_GET['number'] != "")
		{
			$number			= preg_replace("/\D/","",$_GET['number']);
			$start			= preg_replace("/\D/","",$_GET['start']);
			$search_word	= $_GET['search_word'];
			$search_type	= $_GET['search_type'];

			$WHERE			= " AND number='$number' ";
		}


		$m_cnt					= 0;
		$Sql					= "SELECT * FROM $happy_member_quies WHERE 1=1 $WHERE";
		$Rec					= query($Sql);
		while($MemberData		= happy_mysql_fetch_assoc($Rec))
		{
			$m_cnt++;

			$_GET['member_group']	= $MemberData['group'];
			$member_group			= $MemberData['group'];

			#회원정보 삭제
			$Sql	= "DELETE FROM $happy_member_quies WHERE number='$MemberData[number]' ";
			query($Sql);

			#탈퇴회원 아이디 및 탈퇴IP남기기
			$Sql	= "INSERT INTO $happy_member_out SET out_id='$MemberData[user_id]', out_date=now(), out_ip='$_SERVER[REMOTE_ADDR]'";
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

				if ( $Form['field_use_admin'] != 'y' )
				{
					continue;
				}

				# 파일일때
				if ( $Form['field_type'] == 'file' && $MemberData[$nowField] != '' )
				{
					$nowFile	= $MemberData[$nowField];

					#echo $nowFile."<hr>";
					happy_member_image_unlink("../$nowFile",Array("_thumb","_thumb2"));
				}
			}
		}

		if( $m_cnt == 0 )
		{
			error("존재하지 않는 회원정보 입니다.");
			exit;
		}


		gomsg("삭제되었습니다.","?start=$start&search_word=$search_word&search_type=$search_type");
	}



################################################
#하단부분 HTML 소스코드
include ("tpl_inc/bottom.php");
################################################



?>