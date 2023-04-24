<?
############################################################################################################################

$회원그룹별정보	= Array();
if ( $happy_member_login_value != '' )
{
	$Sql			= "SELECT * FROM $happy_member WHERE user_id = '$happy_member_login_value'";
	$회원정보		= happy_mysql_fetch_assoc(query($Sql));

	$is_upche		= is_per_member($happy_member_login_value);

	if ( $is_upche == true ) //개인회원이면
	{
		$회원그룹별정보['mobile_top_link']	= "per_want_search.php?mode=list";
		$회원그룹별정보['mobile_top_img']	= "btn_myguzic.png";
		$회원그룹별정보['mobile_txt']	= "맞춤채용정보";
	}
	else //기업회원이면
	{
		$회원그룹별정보['mobile_top_link']	= "com_want_search.php?mode=list";
		$회원그룹별정보['mobile_top_img']	= "btn_myguin.png";
		$회원그룹별정보['mobile_txt']	= "맞춤인재정보";
	}
}
else
{
	$회원그룹별정보['mobile_top_link']	= "per_want_search.php?mode=list";
	$회원그룹별정보['mobile_top_img']	= "btn_myguzic.png";
	$회원그룹별정보['mobile_txt']	= "맞춤채용정보";
}

#{{회원폼 자동,메인,happy_member_form_rows.html,happy_member_form_default.html}}

$happyMemberAdminMode	= '';
$happyMemberMode		= '';
function happy_member_user_form( $user_group, $group='', $rows_html='', $default_html='', $view_userid='', $view_level='' )
{
	global $TPL, $happy_member_field, $happy_member_skin_folder, $필드타이틀, $필드아이디, $출력형식, $현재폼, $폼내용;
	global $MemberData, $happyMemberAdminMode, $happyMemberSrc, $happyMemberMode, $happy_member_group;
	global $happy_member_kcb_namecheck_use;
	global $happy_member_nick_history, $happy_member_state_open, $happy_member_nick_change_day, $happy_member_state_change_day;

	global $_SESSION,$recommend_get_id; #추천인 기능 추가 - 13.01.15 hong - 16.10.17 x2chi 이전

	//어덜트잡
	global $업종분류;

	global $select_category_road,$select_company_road,$select_type_road;

	global $필수체크이미지;

	global $HAPPY_CONFIG;


	$whereUseField	= 'field_use';
	$WHERE			= '';
	$nick_check		= true;
	$state_check	= true;
	$view_mode		= '';

	if ( $group != '' && $group != '전체'  )
	{
		$WHERE	= " AND field_group='$group' ";
	}

	if ( $user_group == '자동' )
	{
		$user_group	= preg_replace("/\D/","",$_GET['member_group']);
		if ( $user_group == '' )
		{
			#error("잘못된 경로로 접근하셨습니다.");exit;
			return print "<font color='red'>테스트용 : 주소뒤에 &member_group=2 주세요.</font>";
		}
	}
	else if ( $user_group == '회원그룹' )
	{
		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			return print "<font color='red'>로그인후 이용가능 합니다.</font>";
		}

		$MemberData					= happy_member_information($happy_member_login_id);
		$MemberData['user_pass']	= '';
		$user_group					= $MemberData['group'];

		$whereUseField				= 'field_modify';
		$WHERE						.= " AND field_name != 'user_jumin1' ";



		$nick_check					= happy_member_nick_history_change( $happy_member_login_id, $MemberData['user_nick'] );		# 닉네임 수정이 가능한지 체크 #
		$state_check				= happy_member_state_open_change( $happy_member_login_id, $MemberData['state_open'] );		# 닉네임 수정이 가능한지 체크 #

	}
	else if ( $user_group == '정보보기' )
	{
		$view_mode					= 'on';
		$happy_member_login_id		= happy_member_login_check();
		$view_user_id				= $_GET['view_user_id'];
		$admin_mode_check			= !admin_secure('회원관리');

		if ( $view_user_id == '' )
		{
			msgclose('확인할 회원 아이디가 넘어오지 않았습니다.');
			exit;
		}

		if ( $happy_member_login_id == "" && !$admin_mode_check )
		{
			error('로그인후 이용가능 합니다.');
			exit;
		}

		$myData						= happy_member_information($happy_member_login_id);
		$MemberData					= happy_member_information($view_user_id);
		$MemberData['number']		= preg_replace('/\D/', '', $MemberData['number']);

		$user_group					= $MemberData['group'];

		if ( $view_user_id == $happy_member_login_id )
		{
			$admin_mode_check	= true;
		}

		if ( $myData['number'] == '' && !$admin_mode_check )
		{
			msgclose( $happy_member_login_id .' 님의 회원정보가 존재하지 않습니다.   ' );
			return false;
		}

		if ( $myData['state_open'] != 'y' && !$admin_mode_check )
		{
			msgclose( $happy_member_login_id .' 님은 정보공개를 하지 않으셨기 때문에 다른회원정보를 확인이 불가능합니다.   ' );
			return false;
		}

		if ( $MemberData['number'] == '' )
		{
			msgclose( $view_user_id .' 회원이 존재하지 않습니다.   ' );
			return false;
		}

		if ( $MemberData['state_open'] != 'y'  && !$admin_mode_check)
		{
			msgclose( $view_user_id .' 님은 회원정보를 공개하지 않으셨습니다.   ' );
			return false;
		}


		$MemberData['user_jumin2'] = "XXXXXXX";

	}


	$Sql	= "SELECT * FROM $happy_member_group WHERE number='$user_group' ";
	$GROUP	= happy_mysql_fetch_array(query($Sql));


	$아이콘1		= "<img src='${happyMemberSrc}img/form_icon1.gif' align='absmiddle'>";
	$아이콘2		= "<img src='${happyMemberSrc}img/form_icon2.gif' align='absmiddle'>";
	$아이콘3		= "<img src='${happyMemberSrc}img/form_icon3.gif' align='absmiddle'>";

	#폼정보 변수에 담아두기
	$Sql			= "SELECT * FROM $happy_member_field WHERE member_group = '$user_group' $WHERE ";
	//echo $Sql;
	$Record			= query($Sql);

	$SureInput		= "";
	$fieldPreview	= Array();
	$Cnt			= 0;
	while ( $Form = happy_mysql_fetch_array($Record) )
	{

		$fieldName		= $Form['field_name'];
		$fieldTitle		= $Form['field_title'];
		$fieldType		= $Form['field_type'];
		$fieldOptions	= $Form['field_option'];
		$fieldStyle		= $Form['field_style'];
		$fieldTemplate	= $Form['field_template'];
		$fieldSureInput	= $Form['field_sureInput'];

		if ( $view_mode == 'on' )
		{
			$fieldType	= ( $fieldType == 'file' )? 'view_file' : 'view' ;
		}

		$fieldUse		= $happyMemberAdminMode == 'happyOk' ? $Form['field_use_admin'] : $Form[$whereUseField];

		$value			= $MemberData[$fieldName];

		if ( $fieldName == "user_id" && ( $_GET['mode'] == 'modify' || $view_mode == 'on' ) )
		{
			$value		= outputSNSID($MemberData['user_id']);
		}

		#print_r($Form);
		#echo "<hr>";

		#echo $fieldTitle."<br>";

		if ( ( $fieldName == 'user_pass' || $fieldName == 'user_pass2' ) && $whereUseField == 'field_modify' )
		{
			$sureInput	= '';
		}
		else
		{
			//$sureInput	= $fieldSureInput == 'y' ? " hname='". str_replace(" ","",$fieldTitle)."' required " : "";
			$sureInput	= $fieldSureInput == 'y' ? " hname='". str_replace(" ","",$fieldTitle)."' " : "";
			/*
				크롬에서 필수입력검사 활성화로 회원정보 수정이 되지 않아 수정
				관리자에서 user_pass2 는 필수입력검사 하지 않도록 함.
			*/
			if ($fieldName == 'user_pass2' && preg_match("/admin/",$_SERVER['SCRIPT_NAME']))
			{
				$sureInput	= '';
			}
		}
		# echo " $Form[field_name] = $fieldUse <br>";

		#폼박스 설정
		if ( ( $value != '' && $fieldUse != 'y' ) || ( $whereUseField == 'field_modify' && $Form['field_modify'] != 'y' )  )
		{
			if ( $fieldType == 'checkbox' || $fieldType == 'radio' || $fieldType == 'select' )
			{
				$fieldOption	= explode(",",$fieldOptions);
				foreach ( $fieldOption AS $nFO )
				{
					$nFO	= explode(':', $nFO);
					if ( $nFO[1] == $value )
					{
						$form	= $nFO[0];
					}
				}
			}
			else
			{
				$form	= $value;
			}
		}
		else if ( $fieldType == 'text' )
		{
			#추천인 아이디 세션값 있을경우 추천인 필드를 막아둠 - 13.01.15 hong 추가 - 16.10.17 x2chi 이전
			$readonly	= "";
			if ( $_GET['mode'] == "joinus2"  && $_SESSION[$recommend_get_id] && $fieldName == "recommend")
			{
				$value = $_SESSION[$recommend_get_id];
				$readonly	= "readonly";
			}

			$form	= "<span class='h_form'><input type='text' name='$fieldName' value='$value' $fieldStyle $sureInput $readonly></span>";
		}
		else if ( $fieldType=='text_num' )
		{
			$form	= "<span class='h_form'><input type='text' name='$fieldName' value='$value' $fieldStyle $sureInput  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.preventDefault ? event.preventDefault() : event.returnValue=false;'></span>";
		}
		else if ( $fieldType == 'password' )
		{
			if(($fieldName == "user_pass" || $fieldName == "user_pass2") && preg_match("/admin\/happy_member/",$_SERVER['PHP_SELF']))
			{
				$value			= "";
				$sureInput		= "";
			}
			$form	= "<span class='h_form'><input type='password' name='$fieldName' value='$value' $fieldStyle $sureInput></span>";
		}
		else if ( $fieldType == 'file' )
		{
			$form	= "<span class='h_form'><input type='file' name='$fieldName' $fieldStyle $sureInput \"></span>";
			if ( ( $happyMemberMode == 'mod' || $whereUseField == 'field_modify' ) && $value != '' || ( strlen($_GET['per_info_id']) > 0 && "field_use" == $whereUseField ) )
			{
				$form	= "<span class='h_form'><input type='file' name='$fieldName' $fieldStyle \"></span>";
				$form			.= "<br><span class='h_form' style='padding:5px 0 0 0; display:inline-block;'><label for='${fieldName}_del' class='h-check'><input type='checkbox' name='${fieldName}_del' id='${fieldName}_del' value='ok' class='cfg_input_chk' style='height:13px; width:13px; vertical-align:middle;'><span class='font_13'>파일삭제</span></label></span>";
				if (preg_match("/http:\/\/|https:\/\//",$value))
				{
					if(eregi('googleusercontent.com', $value))
					{
						$value	= str_replace("?sz=50?sz=100","",$value);
					}
					$fieldPreview[$fieldName]	= "<div style='clear:both'><img src='$value' class='img_preview' style='border:1px solid #ccc; margin:5px 0;' onError=this.src='./img/noimage_del.jpg' ></div>";
				}
				else if (eregi('.jp', $value) || eregi('.gif', $value) || eregi('.png', $value) || eregi('.bmp', $value) )
				{
					$value_thumb		= $value;
					if (eregi('.jp', $value) )
					{
						$value_thumb = str_replace(".jpg","_thumb.jpg",$value);
					}
					// class='img_preview'
					$fieldPreview[$fieldName]	= "<img src='${happyMemberSrc}$value_thumb' border='0' onError=this.src='./img/noimage_del.jpg' style='margin-top:5px;'>";
				}
			}
		}
		else if ( $fieldType == 'textarea' )
		{
			$form	= "<span class='h_form'><textarea name='$fieldName' $fieldStyle $sureInput>$value</textarea></span>";
		}
		else
		{
			$fieldOptions	= explode(",",$fieldOptions);
			if ( $fieldType == 'checkbox' )
			{
				$array_co	= count($fieldOptions);
				$values		= explode(",",$value);
				$form		= "";

				for ( $i=0, $j=0; $i<$array_co; $i++ )
				{
					$fieldOptions[$i]		= explode(":",$fieldOptions[$i]);
					$fieldOptions[$i][1]	= $fieldOptions[$i][1] == '' ? $fieldOptions[$i][0] : $fieldOptions[$i][1];


					//크롬에서 check를 다해야되는 상황을 처리
					if($i > 0)
					{
						$sureInput = "";
					}
					//크롬에서 check를 다해야되는 상황을 처리 END



					if ( $fieldOptions[$i][1] == $values[$j] ) {
						$j++;
						$form .= "<span class='h_form'><label class='h-check' for='${fieldName}_$i'><input type=checkbox id='${fieldName}_$i'  name='${fieldName}[]' value='".$fieldOptions[$i][1]."' checked $fieldStyle  $sureInput class='cfg_input_chk'><span class='font_14'>".$fieldOptions[$i][0]."</span></label></span> &nbsp;";
					}
					else {
						$form .= "<span class='h_form'><label class='h-check' for='${fieldName}_$i'><input type=checkbox id='${fieldName}_$i'  name='${fieldName}[]' value='".$fieldOptions[$i][1]."' $fieldStyle  $sureInput class='cfg_input_chk'><span class='font_14'>".$fieldOptions[$i][0]."</span></label></span> &nbsp;";
					}
				}
			}
			else if ( $fieldType == 'radio' )
			{
				$array_co	= count($fieldOptions);
				$form		= "";

				for ( $i=0; $i<$array_co; $i++ )
				{
					$fieldOptions[$i]		= explode(":",$fieldOptions[$i]);
					$fieldOptions[$i][1]	= $fieldOptions[$i][1] == '' ? $fieldOptions[$i][0] : $fieldOptions[$i][1];

					if ( $fieldOptions[$i][1] == $value ) {
						$j++;
						$form .= "<span class='h_form'><label class='h-radio' for='${fieldName}_$i'><input type=radio id=${fieldName}_$i  name='${fieldName}' value='".$fieldOptions[$i][1]."' checked $fieldStyle  $sureInput class='cfg_input_chk'><span class='font_14'>".$fieldOptions[$i][0]."</span></label></span> &nbsp;";
					}
					else {
						$form .= "<span class='h_form'><label class='h-radio' for='${fieldName}_$i'><input type=radio id=${fieldName}_$i  name='${fieldName}' value='".$fieldOptions[$i][1]."' $fieldStyle  $sureInput class='cfg_input_chk'><span class='font_14'>".$fieldOptions[$i][0]."</span></label></span> &nbsp;";
					}
				}
			}
			else if ( $fieldType == 'select' )
			{
				$array_co	= count($fieldOptions);
				$form		= "<span class='h_form'><select name=$fieldName $sureInput $fieldStyle >";
				$form		.= "<option value=''>--- 선택 ---</option>";

				for ( $i=0; $i<$array_co; $i++ )
				{
					$fieldOptions[$i]		= explode(":",$fieldOptions[$i]);
					$fieldOptions[$i][1]	= $fieldOptions[$i][1] == '' ? $fieldOptions[$i][0] : $fieldOptions[$i][1];

					if ($value == $fieldOptions[$i][1]){
						$form	.= "<option value='".$fieldOptions[$i][1]."' selected style='background-color:#E5EDFF'>".$fieldOptions[$i][0]."</option>";
					}
					else {
						$form	.= "<option value='".$fieldOptions[$i][1]."'>".$fieldOptions[$i][0]."</option>";
					}

				}
				$form		.= "</select></span>";
			}
			else if ( $fieldType == 'view' )	// 상세보기 페이지 => $tplTD 그냥 출력
			{
				if ( is_array($fieldOptions) )
				{
					for ( $x=0 , $m=sizeof($fieldOptions) ; $x<$m ; $x++ )
					{
						list( $FieldText, $FieldValue )	= explode(':', $fieldOptions[$x]);

						if ( $FieldValue == $value )
						{
							$value	= $FieldText;
							break;
						}
					}
				}
				$form	= nl2br($value);
			}
			else if ( $fieldType == 'view_file' )	// 상세보기 페이지 => $tplTD 그냥 출력
			{
				if (eregi('.jp', $value) || eregi('.gif', $value) || eregi('.png', $value) || eregi('.bmp', $value) )
				{
					$form	= "<img src='${happyMemberSrc}$value' border='0' class='img_preview'  onError=this.src='./img/noimage_del.jpg'>";
				}
				else if ( $value != '' )
				{
					$form	= "<a href='${happyMemberSrc}$value' target='_blank'>첨부파일</a>";
				}
			}




		}

		if ( $fieldType != 'view' && $fieldType != 'view_file' )
		{
			if ( $fieldName == 'user_pass' && $whereUseField == 'field_modify' )
			{
				$form	.= "&nbsp;<span class='font_st_11'>미 입력시 비밀번호는 변경하지 않습니다.</span>";
			}

			if ( $fieldName == 'user_name' && $happy_member_kcb_namecheck_use && $happyMemberAdminMode != 'happyOk' && $_COOKIE['ad_id'] == "" )
			{
				$form	= str_replace("<input ", "<input readonly value='".$_POST['name']."' ", $form);
			}

			else if ( $fieldName == 'user_jumin1' && $happy_member_kcb_namecheck_use && $happyMemberAdminMode != 'happyOk' && $_COOKIE['ad_id'] == "" )
			{
				$form	= str_replace("<input ", "<input readonly value='".$_POST['joomin1']."' ", $form);
			}

			else if ( $fieldName == 'user_jumin2' && $happy_member_kcb_namecheck_use && $happyMemberAdminMode != 'happyOk' && $_COOKIE['ad_id'] == "" )
			{
				$form	= str_replace("<input ", "<input readonly value='".$_POST['joomin2']."' ", $form);
			}
			/*
			else if ( $fieldName == 'user_email' && $whereUseField == 'field_modify' )
			{
				$form	= str_replace("<input ", "<input onKeyUp='email_input_check()' ", $form);
			}
			*/
			else if ( $fieldName == 'user_hphone' && $whereUseField == 'field_modify' )
			{
				if( $GROUP['iso_hphone'] == 'y' )
				{
					$form	= str_replace("<input ", "<input onKeyUp='hphone_input_check()' ", $form);
				}
			}
			else if ( $fieldName == 'user_nick' && $nick_check == false )
			{
				$form	= str_replace("<input ", "<input readonly onClick=\"alert('닉네임 수정후 ${happy_member_nick_change_day}일간 수정이 불가능합니다.');\"  onFocus=\"alert('닉네임 수정후 ${happy_member_nick_change_day}일간 수정이 불가능합니다.');this.blur();\" ", $form);
			}
			else if ( $fieldName == 'state_open' && $state_check == false )
			{
				$checked	= $MemberData['state_open'] == 'y' ? 'true' : 'false';
				$form	= str_replace("<input ", "<input readonly onChange=\"alert('정보공개여부 수정후 ${happy_member_nick_change_day}일간 수정이 불가능합니다.');this.checked = $checked ;\" ", $form);
			}
			else if ( $fieldName == 'user_prefix' && $happy_member_kcb_namecheck_use && $happyMemberAdminMode != 'happyOk' )	//아이핀연동	hun
			{
				if($_POST['prefix'] == 'man')
				{
					$form	= str_replace("<input type=radio id=user_prefix_0 ", "<input type=radio id=user_prefix_0 checked ", $form);
				}
				else if($_POST['prefix'] == 'girl')
				{
					$form	= str_replace("<input type=radio id=user_prefix_1 ", "<input type=radio id=user_prefix_1 checked ", $form);
				}
			}
			else if ( $fieldName == 'user_hphone' && $happy_member_kcb_namecheck_use && $happyMemberAdminMode != 'happyOk' && ( $HAPPY_CONFIG['kcb_check_type'] == 'hp' || $HAPPY_CONFIG['kcb_check_type'] == 'ipin_hp' ) )	//아이핀연동	hun
			{
				//$form	= str_replace("<input ", "<input readonly value='".$_POST['user_hphone']."' ", $form);
				if( $Form['field_template'] != '%연락처폼%' )
				{
					$form	= str_replace("<input ", "<input readonly value='".$_POST['user_hphone']."' ", $form);
				}
				else
				{
					$MemberData['user_hphone']		= $_POST['user_hphone'];
				}
			}
		}

		$FormPatterns[$Cnt]		= "/%${fieldName}%/";
		$FormReplaces[$Cnt++]	= $form;
		$Forms[$fieldName]		= $form;

		#echo $fieldTitle ." : $form <br>";
	}

	//어덜트잡
	$FormPatterns[$Cnt]		= "/%업종분류%/";
	$FormReplaces[$Cnt++]	= $업종분류;
	$Forms['업종분류']		= $업종분류;
	#폼정보 담기 종료



	$random	= rand()%1000;
	$TPL->define("회원폼_$random", "$happy_member_skin_folder/$rows_html");

	$field_use	= $happyMemberAdminMode == 'happyOk' ? " AND ( field_use_admin = 'y' or field_use='y' ) " : " AND field_use='y' ";
	if ( $happyMemberAdminMode == 'happyOk' )
	{
		$field_use	= " AND ( field_use_admin = 'y' or field_use='y' ) AND field_template != '' ";
	}
	else if ( $view_mode == 'on' )
	{
		$field_use	= " AND field_view='y' ";
	}
	else
	{
		$field_use	= " AND field_use='y' ";
	}

	//sns 회원은 패스워드 변경폼 필요없음 - ranksa
	if ( $MemberData['sns_site'] != '' )
	{
		$WHERE  .= " AND field_name != 'user_pass' AND field_name != 'user_pass2' ";
	}
	//sns 회원은 패스워드 변경폼 필요없음 - ranksa END

	//도로명 때문에 추가됨.
	$form_name	= ( preg_match("/admin/i",$_SERVER['SCRIPT_NAME']) )? 'banner_frm' : 'happy_member_reg';


	#폼정보 출력 변수 정리
	$Sql	= "SELECT * FROM $happy_member_field WHERE member_group = '$user_group'  $field_use $WHERE ORDER BY field_sort ASC";
	$Record	= query($Sql);
	while ( $Form = happy_mysql_fetch_array($Record) )
	{
		$fieldName		= $Form['field_name'];
		$fieldTitle		= $Form['field_title'];
		$fieldType		= $Form['field_type'];
		$fieldOptions	= $Form['field_option'];
		$fieldStyle		= $Form['field_style'];
		$fieldTemplate	= $Form['field_template'];
		$fieldTemplate	= $fieldTemplate == '' ? '%폼%' : $fieldTemplate;

		if ( $view_mode == 'on' )
		{
			$fieldTemplate	= str_replace('<br>', '', $fieldTemplate);
			#$fieldTemplate	= '%폼%';
		}

		if ( $fieldName == 'user_hphone' && $GROUP['iso_hphone'] == 'y' && $happyMemberAdminMode != 'happyOk' && $view_mode == '' )
		{
			if ( $whereUseField != 'field_modify' )
			{
				$fieldTemplate	.= "<input type=hidden name='user_hphone_check' value=''><input type='button' value='휴대폰인증' onclick='check_phone()' class='btn_m_join' id='iso_button_hphone' ><input type=hidden name='user_hphone_original' value=''>";
			}
			else
			{
				$iso_hphone_display	= $MemberData['iso_hphone'] == 'y' ? 'none' : '';
				$fieldTemplate	.= "<input type=hidden name='user_hphone_original' value='$MemberData[user_hphone]'><input type=hidden name='iso_hphone' value='$MemberData[iso_hphone]'><input type=hidden name='user_hphone_check' value='$MemberData[iso_hphone]'><input type='button' value='휴대폰인증' onclick='check_phone()' class='btn_m_join' id='iso_button_hphone' style='display:$iso_hphone_display'>";
			}
		}

		else if ( $fieldName == 'user_email' && $GROUP['iso_email'] == 'y' && $happyMemberAdminMode != 'happyOk' && $view_mode == '' )
		{
			if ( $whereUseField != 'field_modify'  )
			{
				$fieldTemplate	.= " <input type=hidden name='user_email_check' value=''><input type='button' value='이메일인증' onclick='check_email()' class='btn_m_join'>";
			}
			else
			{
				$Forms[$fieldName]	= "<input type='text' name='user_email' value='$MemberData[user_email]' readonly>";
				//$iso_email_display	= $MemberData['iso_email'] == 'y' ? 'none' : '';
				$fieldTemplate	.= " <input type=hidden name='user_email_original' value='$MemberData[user_email]'><input type=hidden name='iso_email' value='$MemberData[iso_email]'><input type=hidden name='user_email_check' value=''><input type='button' value='이메일인증' onclick='check_email()' class='btn_m_join' id='iso_button_email'>";
			}
		}
		else if( $fieldName == "road_si" && $view_mode == '' )
		{
			happy_make_road_si_selectbox('road_si','road_gu','road_addr',"$MemberData[road_si]","$MemberData[road_gu]","$MemberData[road_addr]",'90','90','110',$form_name);
			$도로명지역선택		= "<span class='h_form memeber_select_m'>$select_category_road[$form_name] $select_company_road[$form_name]$select_type_road[$form_name]</span>";
			//$도로명상세주소		= "<span id=\"road_addr2\"><input type=\"text\" name=\"road_addr2\" id=\"road_addr2\" value=\"$MemberData[road_addr2]\" style='width:110px;'/></span><input type=\"hidden\" name=\"site_url\" id=\"site_url\" value=\"$_SERVER[SERVER_NAME]\" />";
			/*
				도로명주소레이어
				<span id=\"road_addr2\"> 제거 </span> 제거
			*/
			$도로명상세주소		= "<span class='h_form memeber_input_m'><input type=\"text\" name=\"road_addr2\" id=\"road_addr2\" value=\"$MemberData[road_addr2]\" style='width:110px;'/><input type=\"hidden\" name=\"site_url\" id=\"site_url\" value=\"$_SERVER[SERVER_NAME]\" /></span>";
			$지역갱신버튼		= "<a href=\"javascript:#\" onclick=\"Road_happy_member_address('$form_name'); return false;\" class=\"h_btn_st13\" style=\"margin-left:3px;\">주소로변환</a>";
		}
		else if( $fieldName == "user_zip" && $view_mode == '' )
		{
			/*
				도로명주소레이어
				도로명갱신버튼 뒤에 $도로명주소레이어 추가
			*/
			$도로명주소레이어 = road_layer();

			$도로명갱신버튼		= "<a href=\"javascript:#\" onclick=\"Road_address('$form_name'); return false;\" class=\"h_btn_st13\" style=\"margin-left:3px\">도로명으로 변환</a>" . $도로명주소레이어;
		}




		$달력	= "<SPAN id='iCalendar$fieldName' name='iCalendar$fieldName'><img src='admin/img/btn_calender.gif' width='25' height='21' onclick='ret_name = document.register.$fieldName;showXY(document.all.iCalendar$fieldName);' align=absmiddle style='cursor:pointer'></SPAN>";


		// 회원 폼양식에 이메일폼 전화번호폼 추가 2017-01-31 x2chi
		if( $view_mode == 'on')
		{
			$이메일폼	= $MemberData[$fieldName];
			$연락처폼	= $MemberData[$fieldName];
		}
		else
		{
			$이메일폼	= mailInputForm($Form, $MemberData[$fieldName]);
			$연락처폼	= telInputForm($Form, $MemberData[$fieldName]);

			if ( $fieldName == 'user_hphone' && $whereUseField == 'field_modify' && $GROUP['iso_hphone'] == 'y' )
			{
				$연락처폼	= str_replace("<input ", "<input onKeyUp='hphone_input_check()' ", $연락처폼);
				$연락처폼	= str_replace("<select ", "<select onChange='hphone_input_check()' ", $연락처폼);
			}
		}


		$form	= str_replace("%폼%",$Forms[$fieldName],$fieldTemplate);
		$form	= str_replace("%달력%",$calendar,$form);
		$form	= str_replace("%아이콘1%",$아이콘1,$form);
		$form	= str_replace("%아이콘2%",$아이콘2,$form);
		$form	= str_replace("%아이콘3%",$아이콘3,$form);
		$form	= str_replace("%미리보기%",$fieldPreview[$fieldName],$form);
		$form	= str_replace("%도로명주소로변경%",$도로명갱신버튼,$form);
		$form	= str_replace("%도로명지역선택%",$도로명지역선택,$form);
		$form	= str_replace("%도로명상세주소%",$도로명상세주소,$form);
		$form	= str_replace("%지역갱신버튼%",$지역갱신버튼,$form);
		$form	= str_replace("%이메일폼%",$이메일폼,$form);
		$form	= str_replace("%연락처폼%",$연락처폼,$form);

		$postPattern	= "/%우편번호찾기-(.*)-(.*)-(.*)-우편번호찾기%/e";
		$postReplace	= "happy_member_post_finder('$1','$2','$3', '$view_mode');";
		$form			= preg_replace ($postPattern, $postReplace, $form);

		$form	= preg_replace($FormPatterns, $FormReplaces, $form);

		$필수체크이미지 = "";
		if ( $Form['field_sureInput'] == "y" || $Form['field_name'] == "user_id" )
		{
			if ( $_COOKIE['happy_mobile'] == 'on' )
			{
				$필수체크이미지	= "<img src='img/form_icon2.gif' alt='필수아이콘' title='필수아이콘' '>";
			}
			else
			{
				$필수체크이미지	= $아이콘1;
			}
		}

		$필드타이틀	= $fieldTitle;
		$필드아이디	= $fieldName;
		$출력형식	= $form;
		$현재폼		= $Forms[$fieldName];


		$content	.= $TPL->fetch("회원폼_$random");
		#echo $fieldTitle ." : $form <br>";
	}
	$폼내용	= $content;
	#폼정보 출력 변수 정리 끝


	$TPL->define("회원폼껍데기_$random", "$happy_member_skin_folder/$default_html");
	$content	= $TPL->fetch("회원폼껍데기_$random");

	return print $content;

}



function happy_member_nick_history_change( $user_id, $user_nick, $execute='' )
{
	global $happy_member, $happy_member_nick_history, $happy_member_nick_change_day;

	# 닉네임 수정이 가능한지 체크 #
	$nick_check_date	= date('Y-m-d H:i:s', happy_mktime(date('H'), date('i'), date('s'), date('m'), date('d')-$happy_member_nick_change_day, date('Y')));
	$Sql				= "SELECT count(*) FROM $happy_member_nick_history WHERE change_date > '$nick_check_date' AND user_id = '$user_id' ";
	list($nick_check)	= happy_mysql_fetch_array(query($Sql));

	if ( $nick_check > 0 )
	{
		return false;
	}
	else
	{
		if ( $execute == 'execute' )
		{
			$Sql	= "
						UPDATE
								$happy_member
						SET
								user_nick	= '$user_nick'
						WHERE
								user_id		= '$user_id'
			";
			query($Sql);

			$Sql	= "
						INSERT INTO
								$happy_member_nick_history
						SET
								user_id		= '$user_id',
								user_nick	= '$user_nick',
								change_date	= now()
			";
			query($Sql);
		}
		return true;
	}
}





function happy_member_state_open_change( $user_id, $state_open, $execute='' )
{
	global $happy_member, $happy_member_state_open, $happy_member_state_change_day;

	# 닉네임 수정이 가능한지 체크 #
	$state_check_date	= date('Y-m-d H:i:s', happy_mktime(date('H'), date('i'), date('s'), date('m'), date('d')-$happy_member_state_change_day, date('Y')));
	$Sql				= "SELECT count(*) FROM $happy_member_state_open WHERE change_date > '$state_check_date' AND user_id = '$user_id' AND state_open = 'y'";
	list($state_check)	= happy_mysql_fetch_array(query($Sql));

	if ( $state_check > 0 )
	{
		return false;
	}
	else
	{
		if ( $execute == 'execute' )
		{
			$Sql	= "
						UPDATE
								$happy_member
						SET
								state_open	= '$state_open'
						WHERE
								user_id		= '$user_id'
			";
			query($Sql);

			$Sql	= "
						INSERT INTO
								$happy_member_state_open
						SET
								user_id		= '$user_id',
								state_open	= '$state_open',
								change_date	= now()
			";
			query($Sql);
		}
		return true;
	}
}



function happy_member_post_finder($happy_post, $happy_addr1, $happy_addr2, $view_mode='' )
{
	global $zipcode_site, $server_character,$base64_main_url,$zipcode_add_get;
	$return	= "<a href='javascript:void(0)' onClick=\"window.open('http://$zipcode_site/zonecode/happy_zipcode.php?hpyhtt=y&hys=$base64_main_url&hyf=$happy_post|$happy_addr1|$happy_addr2$zipcode_add_get','happy_zipcode_popup_main_url', 'width=600,height=600,scrollbars=yes');\" class='h_btn_st13' style='vertical-align:middle; margin-left:3px'>우편번호찾기</a>";
	#$return	= "<img src='img/happy_member_btn_findPost.gif' onClick=\"happy_member_post_finder('$happy_post', '$happy_addr1', '$happy_addr2');\" border=0 align='absmiddle' alt='우편번호찾기' style='cursor:hand'>";

	if ( $view_mode == 'on' )
	{
		$return	= '';
	}

	return $return;
}




$happy_member_table_field	= "";
function call_happy_member_field( $fieldName='' )
{
	global $happy_member, $happy_member_table_field;

	if ( $fieldName == '' )
	{
		return false;
	}

	if ( $happy_member_table_field == '' )
	{
		$happy_member_table_field	= array();

		$Sql	= "DESC $happy_member";
		$Rec	= query($Sql);

		while ( $tmp = happy_mysql_fetch_array($Rec) )
		{
			#print_r($tmp);
			#echo "<br>";

			if ( $tmp['Field'] != '' )
			{
				$happy_member_table_field[$tmp['Field']]['Field']	= $tmp['Field'];
				$happy_member_table_field[$tmp['Field']]['Type']	= $tmp['Type'];
				$happy_member_table_field[$tmp['Field']]['Null']	= $tmp['Null'];
				$happy_member_table_field[$tmp['Field']]['Key']		= $tmp['Key'];
				$happy_member_table_field[$tmp['Field']]['Default']	= $tmp['Default'];
				$happy_member_table_field[$tmp['Field']]['Extra']	= $tmp['Extra'];
			}
		}
	}


	return $happy_member_table_field[$fieldName];

}








function happyMemberimageUpload($img_name, $img_name_new, $gi_joon, $height_gi_joon, $picture_quality, $thumbType="", $thumbPosition="", $logo="", $logoPosition="" )
{
	# 사용법
	# imgaeUpload(원본파일네임, 생성할파일네임, 가로크기, 세로크기, 품질, 썸네일추출타입, 로고파일명, 로고포지션)
	# $happy_member_path는 홈디렉토리의 pwd

	global $happy_member_path, $_FILES;

	$thumbPosition	= preg_replace("/\D/","",$thumbPosition);
	$logoPosition	= preg_replace("/\D/","",$logoPosition);

	$img_url_re		= $img_name_new;
	$image_top		= 0;
	$image_left		= 0;

	#확장자 체크
	$img_names		= explode(".",$img_name);
	$img_ext		= strtolower($img_names[sizeof($img_names)-1]);
	if ( $img_ext != 'jpg' && $img_ext != 'jpeg' && $img_ext != 'png' && $img_ext != 'gif' )
	{
		error("사용할수 없는 확장자 입니다.");
		return "";
	}


	#기존 이미지를 불러와서 사이즈 체크
	$imagehw		= GetImageSize("$img_name");
	$imagewidth		= $imagehw[0];
	$imageheight	= $imagehw[1];

	$new_width		= $height_gi_joon * $imagewidth / $imageheight ;
	$new_width		= ceil($new_width);
	$new_height		= $gi_joon * $imageheight / $imagewidth ;
	$new_height		= ceil($new_height);

	$width_per	= $imagewidth / $gi_joon;
	$height_per	= $imageheight / $height_gi_joon;

	#썸네일 생성 방법별
	if ( $thumbType == '비율대로짜름' )
	{
		if ( $width_per < $height_per ) {
			$gi_joon		= $new_width;
		}
		else {
			$height_gi_joon	= $new_height;
		}
	}
	else if ( $thumbType == '비율대로축소' )
	{
		$thumbType	= ( $width_per > $height_per )? '가로기준세로짜름' : '세로기준가로짜름';
	}
	else if ( $thumbType == '비율대로확대' )
	{
		$thumbType	= ( $width_per > $height_per )? '세로기준가로짜름' : '가로기준세로짜름';
	}

	switch( $thumbType )
	{
		case "가로기준세로짜름" :
									$new_width	= $gi_joon;
									break;
		case "세로기준가로짜름" :
									$new_height	= $height_gi_joon;
									break;
		case "가로기준" :
									if ( $imagewidth < $gi_joon )
									{
										$new_width		= $imagewidth;
										$new_height		= $imageheight;
										$gi_joon		= $imagewidth;
										$height_gi_joon	= $imageheight;
									}
									else
									{
										$new_width		= $gi_joon;
										$new_height		= $imageheight / $width_per;
										$height_gi_joon	= $new_height;
									}
									break;
		case "세로기준" :
									if ( $imageheight < $height_gi_joon )
									{
										$new_width		= $imagewidth;
										$new_height		= $imageheight;
										$gi_joon		= $imagewidth;
										$height_gi_joon	= $imageheight;
									}
									else
									{
										$new_width		= $imagewidth / $height_per;
										$gi_joon		= $new_width;
										$new_height		= $height_gi_joon;
									}
									break;
		default :
									$new_width	= $gi_joon;
									$new_height	= $height_gi_joon;
									break;
	}
	#echo "$new_width - $new_height <br> ";


	#썸네일 추출 위치 ( 가로기준 , 세로기준에만 해당 )
	if ( $thumbType == '가로기준세로짜름' && $thumbPosition != '' && $new_height > $height_gi_joon )
	{
		if ( $thumbPosition == '2' )
		{
			$image_top	= $imageheight * ( ( ( $new_height - $height_gi_joon ) / 2 ) / $new_height );
		}
		else if ( $thumbPosition == '3' )
			$image_top	= $imageheight * ( ( $new_height - $height_gi_joon ) / $new_height );
	}
	else if ( $thumbType == '세로기준가로짜름' && $thumbPosition != '' && $new_width > $gi_joon )
	{
		if ( $thumbPosition == '2' )
			$image_left	= $imagewidth * ( ( ( $new_width - $gi_joon ) / 2 ) / $new_width );
		else if ( $thumbPosition == '3' )
			$image_left	= $imagewidth * ( ( $new_width - $gi_joon ) / $new_width );
	}
	#echo "$image_left - $image_top <br> ";



	#배경잡고
	$thumb			= ImageCreate($gi_joon,$height_gi_joon);
	$thumb			= imagecreatetruecolor($gi_joon,$height_gi_joon);
	$white			= imagecolorallocate($thumb, 255, 255, 255);
	imagefilledrectangle ($thumb,0,0,$gi_joon,$height_gi_joon,$white);


	if ( $img_ext == 'png' ) {
		$src		= ImageCreateFromPng("$img_name");
	}
	else if (  $img_ext == 'gif' ) {
		$src		= ImageCreateFromGif("$img_name");
	}
	else {
		$src		= ImageCreateFromJPEG("$img_name");
	}
	imagecopyresampled($thumb,$src,0,0,$image_left,$image_top,$new_width,$new_height,$imagewidth,$imageheight);


	#일단 쪼끄만거부터 맹글자
	if ( $img_ext == 'png' ) {
		/*imagepng()함수 PHP5 패치 by kwak16*/$phpver=phpversion();$phpver=$phpver[0];$picture_quality = ($picture_quality>9&&$phpver>4)?round($picture_quality/11):$picture_quality; ImagePNG($thumb,"$img_name_new",$picture_quality);
	}
	else if (  $img_ext == 'gif' ) {
		Imagegif($thumb,"$img_name_new",$picture_quality);
	}
	else {
		ImageJPEG($thumb,"$img_name_new",$picture_quality);
	}




	#로고작업
	if ( $logo != "" )
	{
		$logo			= ImageCreateFromPng("$happy_member_path/$logo");
		$logo_width		= imagesx($logo);
		$logo_height	= imagesy($logo);

		$logo_left	= 0;
		$logo_top	= 0;

		#로고 포지션 잡기
		switch( $logoPosition )
		{
			case "1":	break;
			case "2":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						break;
			case "3":
						$logo_left	= $gi_joon - $logo_width;
						break;
			case "4":
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "5":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "6":
						$logo_left	= $gi_joon - $logo_width;
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "7":
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			case "8":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			case "9":
						$logo_left	= $gi_joon - $logo_width;
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			default:
						$logo_top	= $height_gi_joon-$logo_height;
						break;
		}

		imagecopy($thumb,$logo,$logo_left,$logo_top,0,0,$logo_width,$logo_height);
		ImageJPEG($thumb,"$img_name_new",$picture_quality);
		ImageDestroy($logo);
	}

	ImageDestroy($thumb);


	return $img_url_re;

}




############################################################################################################################


# 파일 삭제 루틴 happy_member_image_unlink( 파일명, Array('_thumb','_thumb2') );
function happy_member_image_unlink( $nowFile , $thumb_file_name = array() )
{
	global $demo_lock;

	$temp_name		= explode(".",$nowFile);
	$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

	//솔루션데모일때는 파일삭제를 하지 않음
	if ( $demo_lock == "" )
	{
		for ( $i=0, $max=sizeof($thumb_file_name) ; $i<$max ; $i++ )
		{
			@unlink(str_replace(".$ext",$thumb_file_name[$i].".$ext",$nowFile));
		}

		@unlink($nowFile);
	}
	return true;
}



############################################################################################################################






function happy_member_group_list()
{

	# 추출 가능한 태그 없음 // php로 함수를 다이렉트 호출한후 리턴되는 값을 변수로 담아서 사용

	$arg_title	= array('세로수','가로수','그룹타입','테이블크기','템플릿','정렬','이미지크기');
	$arg_names	= array('heightSize','widthSize','groupType','tableWidth','openFile','orderby','imgWidth');
	$arg_types	= array(
						'heightSize'		=> 'int',
						'widthSize'			=> 'int',
						'tableWidth'		=> 'int',
						'groupType'			=> 'char',
						'imgWidth'			=> 'int'
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
	}


	global $HAPPY_CONFIG, $TPL, $happy_member_skin_folder, $happy_member_group;
	global $happy_schedule_links_number_out, $그룹이미지, $Data;


	$LIMIT			= $ex_limit * $widthSize;
	$tdWidth		= $tableWidth / $widthSize;
	$offset			= $heightSize * $widthSize;
	$Templete_File	= $happy_member_skin_folder."/".$openFile;

	$search_page	= "";
	$Date			= date("Y-m-d");



	if ( $groupType == "" ) {
		return "<font color='red'>출력할 그룹형식을 지정하지 않으셨습니다.</font>";
	}
	else if ( $widthSize == "" || $widthSize == 0 ) {
		return "<font color='red'>가로출력 개수를 지정하지 않으셨습니다.</font>";
	}
	else if ( $heightSize == "" || $heightSize == 0 ) {
		return "<font color='red'>세로출력 개수를 지정하지 않으셨습니다.</font>";
	}


	$WHERE	= "";



	switch ( $groupType )
	{
		case "전체":				$WHERE .= "  ";break;
		case "가입가능":			$WHERE .= " WHERE group_member_join = 'y' AND group_img_mobile = '' ";break;
		case "가입가능_모바일":		$WHERE .= " WHERE group_member_join = 'y' AND group_img_mobile != '' ";break;
		case "가입불가능":			$WHERE .= " WHERE group_member_join != 'y' ";break;
	}



	$order	= "order by number desc";
	switch ( $orderby )
	{
		case "랜덤추출":			$order = "order by rand()";break;
		case "기본레벨낮은순":		$order = "order by group_default_level asc";break;
		case "기본레벨높은순":		$order = "order by group_default_level desc";break;
		case "그룹명순":			$order = "order by group_name asc";break;
		case "그룹명역순":			$order = "order by group_name desc";break;
	}


	$Sql		= "SELECT * FROM $happy_member_group $WHERE $order ";
	$Record		= query($Sql);


	$content	= "";
	if ( $tableWidth != '' && $tableWidth != '0' )
	{
		$content	.= "<table align='center' width='$tableWidth' border='0' cellpadding='0' cellspacing='5'>\n<tr>\n";
	}
	$Count		= 0;


	$nowDate	= date("Y-m-d");
	$random		= rand()%1000;
	$TPL->define("그룹정보출력_$random", $Templete_File);

	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$Count++;

		if ( $Data['group_img_mobile'] != '' && $_COOKIE['happy_mobile'] == 'on' )
		{
			$Data['group_img']		= $Data['group_img_mobile'];
		}


		$group_img_preview		= '';
		$group_img_delete		= '';
		if ( $Data['group_img'] != '' )
		{
			$tmp	= @getimagesize($Data['group_img']);

			#print_r($tmp);

			if ( $imgWidth != '' )
			{
				$tmp[0]	= $imgWidth;
			}
			else if ( $tmp[0] > 500 )
			{
				$tmp[0]	= 500;
			}
			if ( $tmp == '' )
			{
				$group_img_preview		= "$Data[group_name] 그룹으로 가입";
			}
			else
			{
				$group_img_preview		= "<img src='.$wys_url/$Data[group_img]' width='$tmp[0]' border='0' align='absmiddle'>";
			}
		}
		else
		{
			$group_img_preview		= "$Data[group_name] 그룹으로 가입";
		}

		$그룹이미지	= $group_img_preview;




		$product	 = &$TPL->fetch("그룹정보출력_$random");


		if ( $tableWidth != '' && $tableWidth != '0'  )
		{
			$content	.= "<td>".$product;
			$content	.= "</td>\n";
			if ( $Count % $widthSize == 0 )
			{
				$content .= "</tr><tr>\n";
			}
		}
		else
		{
			$content	.= $product."<br>\n";
		}
	}


	if ( $tableWidth != '' && $tableWidth != '0' )
	{
		if ( $Count % $widthSize != 0 )
		{
			for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
			{
				$content	.= "<td width='$tdWidth'></td>\n";
			}
		}
	}

	if ( $tableWidth != '' && $tableWidth != '0' )
	{
		$content	.= "</tr>\n";
		$content	.= "</table>";
	}

	$S_Count	= $Total;
	if ( $Count == 0 )
	{
		global $admin_email;
		$content	= "
			<table height='100' border='0' width='100%' cellspacing='0' cellpadding='0' class='no_member_group'>
			<tr>
				<td align='center'>
					가입이 가능한 멤버그룹이 없습니다.<br>
					<label class='more_help'>
						현재 사이트 관리자가 <u>가입가능한 멤버그룹</u>(관리자페이지 > 회원관리 > 통합회원관리 > 회원그룹관리)을 설정하지 않고 있습니다. 궁금하신 점에 대해서 사이트 관리자(<a href='mailto:$admin_email'>$admin_email</a>)에게 문의하여 주세요.
					</label>
				</td>
			</tr>
			</table>
			";
	}

	$페이징		= $paging;

	return $content;

	######################################### 추출종료 #########################################


}






############################################################################################################################



function happy_member_sms_convert( $sms_text, $changeTag=Array() ){
	global $site_name;
	$sms_text = str_replace("{{사이트이름}}",$site_name,$sms_text);
	foreach ( $changeTag AS $key => $value )
	{
		$sms_text = str_replace($key, $value, $sms_text);
	}
	return $sms_text;
}




############################################################################################################################


function happy_member_login_check()
{
	global $happy_member_login_value_type, $happy_member_login_value_name;

	$happy_member_login_id	= '';
	if ( $happy_member_login_value_type == 'session' )
	{
		$happy_member_login_id	= $_SESSION[$happy_member_login_value_name];
	}
	else if ( $happy_member_login_value_type == 'cookie' )
	{
		$happy_member_login_id	= $_COOKIE[$happy_member_login_value_name];
	}
	else
	{
		return print "<font color=red>잘못된 \$happy_member_login_value_type 설정입니다.</font>";
	}


	$happy_member_login_id	= str_replace(' ', '', $happy_member_login_id);

	return $happy_member_login_id;
}


$MEMBER_INFO_HASH	= Array();		# HASH 추가 2015-08-28 ranksa
function happy_member_information($login_id)
{
	global $happy_member,$MEMBER_INFO_HASH;

	if($login_id != "" && $MEMBER_INFO_HASH[$login_id]	 == "")
	{
		$Sql		= "select * from $happy_member WHERE user_id='$login_id' ";
		$HMember	= happy_mysql_fetch_array(query($Sql));

		$MEMBER_INFO_HASH[$login_id]	= $HMember;
	}

	if($MEMBER_INFO_HASH[$login_id] == '')
	{
		return false;
	}
	else
	{
		return $MEMBER_INFO_HASH[$login_id];
	}
}

# 메인제네레이팅 소스 작업으로 인해 리턴여부 (HTML_RETURN) 추가 및 DEFINE 랜덤값 추가.
# 메인제네레이팅 소스 작업으로 $main_page_remake <= global 변수 추가 및 관련 소스 추가됨.
# 메인제네레이팅 소스 작업으로 $main_page_remake_num <= global 변수 추가 및 관련 소스 추가됨.
$main_page_remake_num	= 0;
function happy_member_login_form()
{

	# 사용법
	# {{로그인박스 로그인템플릿,로그아웃템플릿}}

	$arg_title	= array('로그인템플릿','로그아웃템플릿','리턴여부');
	$arg_names	= array('Login_Templete_File','Logout_Templete_File','HTML_RETURN');
	$arg_types	= array(
						'Login_Templete_File'			=> 'char',
						'Logout_Templete_File'			=> 'char'
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
	}






	global $HAPPY_CONFIG, $TPL, $happy_member_skin_folder, $happy_member_group;
	global $demo_lock, $demo_id, $demo_pass, $save_id_checked;
	global $happy_member_login_value_type, $happy_member_login_value_name, $happy_member_login_save_id_cookie;
	global $happy_member_login_id, $happy_member_login_mypage_link;
	global $happy_member;


	global $happy_member_main_url, $몰주소, $로그인주소, $회원가입주소 ,$비밀번호찾기주소, $사용자이름, $사용자아이디,$회원그룹명아이콘,$회원그룹명;
	global $로그아웃주소, $회원정보변경주소, $마이페이지주소, $per_tb;
	global $아이디찾기주소;
	global $save_id_check, $save_id_value, $SELLER_TYPE_STYLE;

	# 메인페이지 제네레이팅 By Kwak16 #
	global $main_page_remake, $main_page_remake_num;
	if ( $main_page_remake === true )
	{
		return print "<div id='main_page_login_".$main_page_remake_num++."'></div>";
	}
	# 메인페이지 제네레이팅 By Kwak16 #

	$몰주소				= $happy_member_main_url;
	$로그인주소			= "javascript:login()";
	$회원가입주소		= "happy_member.php?mode=joinus";
	$비밀번호찾기주소	= "happy_member.php?mode=lostpass";
	$로그아웃주소		= "happy_member_login.php?mode=logout";
	$회원정보변경주소	= "happy_member.php?mode=modify";
	$마이페이지주소		= $happy_member_login_mypage_link;

	$아이디찾기주소		= "happy_member.php?mode=lostid";


	$happy_member_login_id	= happy_member_login_check();



	$MemberData					= happy_member_information($happy_member_login_id);

	$Sql		= "SELECT * FROM $happy_member_group where number='".$MemberData['group']."'";
	$Record		= query($Sql);
	$Data		= happy_mysql_fetch_array($Record);
	$회원그룹명	= $Data['group_name'];


	if ( $happy_member_login_id == '' )
	{
		if ( $_COOKIE[$happy_member_login_save_id_cookie] != '' )
		{
			$save_id_check	= "checked = 'checked' ";
			$demo_id			= $_COOKIE[$happy_member_login_save_id_cookie];
			$demo_pass			= '';
			$save_id_checked	= 'checked';

			$save_id_value	= "y";
		}
		else if ( $demo_lock == '1' )
		{
			//$demo_id			= 'test';
			//$demo_pass			= 'test';
			$save_id_checked	= '';
		}
		else
		{
			//$demo_id			= '';
			//$demo_pass			= '';
			$save_id_checked	= '';
		}

		if ( $_GET['get_id'] != '' )
		{
			$demo_id	= $_GET['get_id'];
			$demo_pass	= '';
		}

		$Templete_File	= $Logout_Templete_File;
	}
	else
	{
		$Templete_File	= $Login_Templete_File;

		$HMember			= happy_member_information($happy_member_login_id);
		$사용자이름			= $HMember['user_name'];
		$사용자아이디		= $HMember['user_id'];
		$회원그룹명아이콘	= "<img src='img/ico_alert.gif' border='0' ONMOUSEOVER=\"ddrivetip('$회원그룹명','','70')\" ONMOUSEOUT=\"hideddrivetip()\">";

		# SNS LOGIN 처리
		global $happy_sns_array;
		$SNS_CHECK			= $happy_sns_array[$HMember['sns_site']];
		if ( is_array($SNS_CHECK) === true )
		{
			$사용자아이디		= "";
			if ( $SNS_CHECK['icon_use_main'] !== false )
			{
				$사용자아이디		= "<img src='". $SNS_CHECK['icon_use_main']. "' border='0' align='absmiddle'> ";
			}
			$사용자아이디		.= $HMember[$SNS_CHECK['id_field']];
		}

		//기업회원 or 개인회원 구분 hong
		global $happy_member_secure_text, $기업회원Display, $개인회원Display;
		global $happy_member_admin_id_cookie_val;

		$admin_login_value	= $_COOKIE[$happy_member_admin_id_cookie_val];

		if ( ( $admin_login_value != "" && $MemberData['group'] == 2 ) || ( $admin_login_value == "" && happy_member_secure($happy_member_secure_text[1].'등록') ) )
		{
			$기업회원Display	= "";
			$개인회원Display	= "display:none;";
		}
		else
		{
			$기업회원Display	= "display:none;";
			$개인회원Display	= "";
		}

	}



	$TPL->define("로그인창", $happy_member_skin_folder.'/'.$Templete_File);
	$content = &$TPL->fetch();


	# 메인페이지 제네레이팅 By Kwak16 #
	if ( $HTML_RETURN == 'return' )
	{
		return $content;
	}
	else
	{
		return print $content;
	}
	# 메인페이지 제네레이팅 By Kwak16 #
}






$MEMBER_SECURE_HASH	= Array();		# HASH 추가 2015-08-07 kwak16
function happy_member_secure( $nowPage )
{
	global $happy_member_admin_id, $happy_member_admin_pw, $happy_member_admin_id_cookie_val, $happy_member_admin_pw_cookie_val;
	global $happy_member_login_id, $happy_member_secure, $happy_member, $happy_member_secure_noMember_code;
	global $happy_member_secure_board_code, $happy_member_secure_text;
	global $MEMBER_SECURE_HASH;

	$adminUserId	= $_COOKIE[$happy_member_admin_id_cookie_val];
	$adminUserPwd	= $_COOKIE[$happy_member_admin_pw_cookie_val];
	$loginUserID	= trim(happy_member_login_check());
	$nowPage		= str_replace('%게시판%', $happy_member_secure_board_code, $nowPage);
	$nowPage		= str_replace("%타이틀%", $happy_member_secure_text[0], $nowPage);
	for ( $i=0 ; $i<5 ; $i++ )
	{
		$nowPage		= str_replace("%타이틀${i}%", $happy_member_secure_text[$i], $nowPage);
	}

	// 부관리자 권한체크
	global $admin_member;
	if ( 0 < mysql_num_rows ( query( "SELECT * FROM `".$admin_member."` WHERE `id` = '".$adminUserId."' AND md5(`pass`) = '".$adminUserPwd."' " ) ) AND admin_secure("게시판관리") )
	{
		return true;
	}

	if ( $happy_member_admin_id == $adminUserId && md5($happy_member_admin_pw) == $adminUserPwd )
	{
		return true;
	}




	# HASH 추가 2015-08-07 kwak16
	$hash_id	= $loginUserID;
	if ( $loginUserID == '' )
	{
		$hash_id	= 'no_member_hash_user';
	}
	# HASH 추가 2015-08-07 kwak16



	if ( $MEMBER_SECURE_HASH[$nowPage][$hash_id] == '' )	# HASH 추가 2015-08-07 kwak16
	{
		if ( $loginUserID == '' )
		{
			$nowGroup	= $happy_member_secure_noMember_code;
		}
		else
		{
			$Sql			= "SELECT `group` FROM $happy_member WHERE user_id='$loginUserID' ";
			list($nowGroup)	= happy_mysql_fetch_array(query($Sql));
		}

		$Sql			= "
							SELECT
									Count(*)
							FROM
									$happy_member_secure
							WHERE
									group_number	= '$nowGroup'
									AND
									menu_title		= '$nowPage'
									AND
									menu_use		= 'y'
		";
		list($sChk)		= happy_mysql_fetch_array(query($Sql));

		$MEMBER_SECURE_HASH[$nowPage][$hash_id]	= $sChk;
	}


	if ( $MEMBER_SECURE_HASH[$nowPage][$hash_id] > 0 )
	{
		return true;
	}
	else
	{
		return false;
	}


	return false;
}








function happy_member_filelist( $folder, $filename, $noFile = "")
{
		$noFile	= $noFile == "" ?"adjflksdajflkasdjflkasdsaf":$noFile;
		$temp	= array();

		#폴더의 파일들을 읽어서 배열에 담는다!
		if ($handle = opendir("$folder")) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					$temp[]	= $file;
				}
			}
			closedir($handle);
		}
		sort($temp);


		$filename	= explode(",", $filename);
		$max		= sizeof($filename);
		$return		= Array();
		$return_t	= Array();

		#폴더내의 파일에서 원하는 변수이 있으면 모두 배열에 담아라!
		foreach ($temp as $value)
		{
			for ( $i=0 ; $i<$max ; $i++ )
			{
				if ( eregi($filename[$i],$value) ){
					array_push($return_t,$value);
				}
			}
		}

		$noFile		= explode(",", $noFile);
		$max_noFile	= sizeof($noFile);

		#필터링을 해주자!(필터링 갯수에 상관없다!)
		foreach ($return_t as $value2)
		{
			$bool = true;
			for($j=0 ; $j<$max_noFile ; $j++)
			{

				#value2에 필터링할 값이 들어가 있다면... fasle를 넣는다.
				if(eregi($noFile[$j], $value2))
				{
					$bool = false;
					break;
				}
			}
			if($bool)
			{
				array_push($return, $value2);
			}
		}

		return array_unique($return);
}


############################################################################################################################


	function happy_member_make_group_box($select_name, $first_message='', $select_value='')
	{
		global $happy_member_group, $groupMemberTitle;

		$first_message	= $first_message == '' ? '-- 회원그룹별 보기 --' : $first_message;
		if ( $select_value == '' )
		{
			$select_value	= $_POST[$select_name] == '' ? $_GET[$select_name] : $_POST[$select_name];
		}

		$Sql		= "SELECT * FROM $happy_member_group ";
		$Record		= query($Sql);
		$i			= 0;
		$groupBox	= "<select id='$select_name' name='$select_name' __onChange__ ><option value=''>$first_message</option>";

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$GROUP[$Data['number']]	= $Data['group_name'];
			$selected				= $Data['number'] == $select_value ? "selected" : "";
			$groupBox				.= "<option value='$Data[number]' $selected>$Data[group_name]</option>";

			if ($Data['number'] == $select_value )
			{
				$groupMemberTitle	= $Data['group_name'];
			}
		}
		$groupBox	.= "</select>";

		return $groupBox;
	}



############################################################################################################################
//솔루션마다 존재하는 특수필드들 happy_member_option 테이블에 rows 형태로 저장되고, 불러오도록 추가됨

//happy_member_option_get(솔루션구분,회원아이디,필드명)
//@필드값
$MEMBER_OPTION_HASH	= Array();		# HASH 추가 2015-08-07 kwak16
function happy_member_option_get($option_type,$user_id,$option_field)
{

	global $happy_member_option, $MEMBER_OPTION_HASH;

	//print_r(func_get_args());


	if ( $user_id == '' )
	{
		return '';
	}


	if ( $MEMBER_OPTION_HASH[$user_id][$option_type][$option_field] == '' )
	{
		$sql = "select * from $happy_member_option where user_id = '$user_id' and option_type = '$option_type' and option_field = '$option_field'";
		//echo $sql;
		$result = query($sql);
		$row = happy_mysql_fetch_assoc($result);

		$option_value = $row['option_value'];

		if ( $row['data_format'] == "int" )
		{
			$option_value = intval($option_value);
		}
		else if ( preg_match("/^float/i",$row['data_format']) )
		{
			$option_value = floatval($option_value);
		}

		$MEMBER_OPTION_HASH[$user_id][$option_type][$option_field]	= $option_value;
	}

	return $MEMBER_OPTION_HASH[$user_id][$option_type][$option_field];
}

//list 추출시 한번 쿼리로 한개씩 가져오면 부하가 심해서 한방에 가져오는 함수를 만듬
//$option_field 를 배열로 넘김
function happy_member_option_get_array($option_type,$user_id,$option_field)
{

	global $happy_member_option;

	//print_r(func_get_args());

	$option_field_sql = "";
	if ( is_array($option_field) )
	{
		$tmp_sql = array();
		foreach( $option_field as $v )
		{
			$tmp_sql[] = " option_field = '".$v."' ";
		}

		$option_field_sql = " ( ".implode(" or ", (array) $tmp_sql)." ) ";
	}


	$sql = "select * from $happy_member_option where user_id = '$user_id' and option_type = '$option_type' and $option_field_sql ";
	$result = query($sql);

	$option_values = array();

	while ( $row = happy_mysql_fetch_assoc($result) )
	{
		$option_value = $row['option_value'];

		if ( $row['data_format'] == "int" )
		{
			$option_values[$row['option_field']] = intval($option_value);
		}
		else if ( preg_match("/^float/i",$row['data_format']) )
		{
			$option_values[$row['option_field']] = floatval($option_value);
		}
		else
		{
			$option_values[$row['option_field']] = $option_value;
		}
	}

	return $option_values;
}


//happy_member_option_set(솔루션구분,회원아이디,필드명,필드값,데이터형)
//@none
function happy_member_option_set($option_type,$user_id,$option_field,$option_value,$data_format)
{

	global $happy_member_option;

	//print_r(func_get_args());

	$sql = "select count(*) from $happy_member_option where user_id = '$user_id' and option_type = '$option_type' and option_field = '$option_field' ";
	$result = query($sql);
	list($cnt) = happy_mysql_fetch_array($result);

	if ( $cnt == 0 )
	{
		//insert
		$sql = "insert into $happy_member_option set ";
		$sql.= "user_id = '$user_id', ";
		$sql.= "option_type = '$option_type', ";
		$sql.= "option_field = '$option_field', ";
		$sql.= "option_value = '$option_value', ";
		$sql.= "data_format = '$data_format', ";
		$sql.= "reg_date = now()";
	}
	else
	{
		//update
		$sql = "update $happy_member_option set ";
		$sql.= "option_value = '$option_value', ";
		$sql.= "reg_date = now() ";
		$sql.= "where user_id = '$user_id' and option_type = '$option_type' and option_field = '$option_field' ";
	}
	//echo nl2br($sql)."<br>";exit;
	query($sql);
}





//그룹번호 -> 그룹명
function happy_member_group_name($number)
{
	global $happy_member_group;

	$sql = "select * from $happy_member_group where number = '$number'";
	$result = query($sql);
	$row = happy_mysql_fetch_assoc($result);

	return $row['group_name'];
}



//SNS 로그인시 회원가입 처리 함수 통합 - hong
function happy_sns_login_member_join($snsArr=Array())
{
	global $happy_member;
	global $happy_sns_member_group;
	global $server_character;

	if ( !is_array($snsArr) || $snsArr['sns_site'] == '' )
	{
		return;
	}

	# 이미 동일한 SNS로 로그인한 사례가 있는지 체크
	$Sql					= "
								SELECT
										Count(*)
								FROM
										$happy_member
								WHERE
										user_id			= '$snsArr[sns_site]_$snsArr[sns_id]'
										AND
										sns_site		= '$snsArr[sns_site]'
	";
	$Tmp					= happy_mysql_fetch_array(query($Sql));

	# 즉시 비밀번호 생성 랜덤값
	$password				= microtime() . rand(0,10000);
	$password_secret		= Happy_Secret_Code($password);

	$snsArr['user_id']		= $snsArr['sns_site']."_".$snsArr['sns_id'];
	$snsArr['sns_name']		= str_replace(' ', '', $snsArr['sns_name']) == '' ? $snsArr['user_id'] : $snsArr['sns_name'];
	$snsArr['sns_username']	= str_replace(' ', '', $snsArr['sns_username']) == '' ? $snsArr['sns_name'] : $snsArr['sns_username'];

	if( preg_match("/euc/i",$server_character) && $snsArr['is_ajax'] == true )
	{
		$snsArr['sns_name']		= iconv("UTF-8", "EUC-KR", $snsArr['sns_name']);
		$snsArr['sns_username']	= iconv("UTF-8", "EUC-KR", $snsArr['sns_username']);
	}

	// 2014-02-11 - woo / SNS 로그인시 닉네임 중복 체크를 하지 않아 체크하도록 수정
	$sql					= "SELECT COUNT(user_nick) FROM $happy_member WHERE user_nick	= '$snsArr[sns_username]'";
	list($chk_user_nick)	= mysql_fetch_row(query($sql));
	if($chk_user_nick > 0) $snsArr['sns_username']	= $snsArr['sns_username'] . '_' . $chk_user_nick;

	if ( $Tmp[0] == 0 )
	{
		global $sns_forwarding;
		if ($sns_forwarding == 'y')
		{
			$forwarding	= "
							email_forwarding	= 'y',
							sms_forwarding	= 'y',
						";
		}
		else
		{
			$forwarding	= "";
		}

		$Sql					= "
									INSERT INTO
											$happy_member
									SET
											user_id			= '$snsArr[sns_site]_$snsArr[sns_id]',
											user_pass		= '$password_secret',
											user_name		= '$snsArr[sns_name]',
											user_nick		= '$snsArr[sns_username]',
											user_email		= '$snsArr[sns_email]',
											photo1			= '$snsArr[sns_image]',
											`group`			= '$happy_sns_member_group',
											sns_site		= '$snsArr[sns_site]',
											user_hphone  = '$snsArr[sns_hphone]',
											user_birth_year = '$snsArr[sns_birthyear]',
											user_birth_month= '$snsArr[sns_birthmonth]',
											user_birth_day = '$snsArr[sns_birthday]',
											user_prefix  = '$snsArr[sns_gender]',
											$forwarding
											reg_date		= now(),
											login_date		= now()
		";

		//구인구직 전용필드
		global $happy_member_option_type;

		//성인인증여부
		happy_member_option_set($happy_member_option_type,"$snsArr[sns_site]_$snsArr[sns_id]",'is_adult',0,'int(11)');

		//구인정보(채용) 기간별 보기
		happy_member_option_set($happy_member_option_type,"$snsArr[sns_site]_$snsArr[sns_id]",'guzic_view',0,'int(11)');
		//구인정보(채용) 회수별 보기
		happy_member_option_set($happy_member_option_type,"$snsArr[sns_site]_$snsArr[sns_id]",'guzic_view2',0,'int(11)');
		//구직정보(이력서) 기간별 보기
		happy_member_option_set($happy_member_option_type,"$snsArr[sns_site]_$snsArr[sns_id]",'guin_docview',0,'int(11)');
		//구직정보(이력서) 회수별 보기
		happy_member_option_set($happy_member_option_type,"$snsArr[sns_site]_$snsArr[sns_id]",'guin_docview2',0,'int(11)');
		//SMS발송포인트
		happy_member_option_set($happy_member_option_type,"$snsArr[sns_site]_$snsArr[sns_id]",'guin_smspoint',0,'int(11)');
		happy_member_option_set($happy_member_option_type,"$snsArr[sns_site]_$snsArr[sns_id]",'guzic_smspoint',0,'int(11)');
	}
	else
	{
		$Sql					= "
									UPDATE
											$happy_member
									SET
											login_date		= now(),
											user_pass		= '$password_secret'
									WHERE
											user_id			= '$snsArr[sns_site]_$snsArr[sns_id]'
											AND
											sns_site		= '$snsArr[sns_site]'
		";
	}
	query($Sql);

	return $password;
}





/*** 휴면회원 처리 관련 함수 ***/

//휴면회원 존재시 휴면회원 리스트로 이동 - ranksa
function happy_member_quies_chk_url() //관리자 로그인시 실행
{
	global $happy_member_quies,$demo_lock;

	if($_SERVER['SERVER_ADDR'] == "192.168.10.90"|| $_SERVER['SERVER_ADDR'] == "211.233.5.218")
	{
		return false;
	}

	happy_member_quies_mail(); //휴면회원 메일발송 & 휴면회원 테이블로 이동
	$Sql		= "SELECT COUNT(*) FROM $happy_member_quies ";
	$Rec		= query($Sql);
	$QUIES_CNT	= mysql_fetch_row($Rec);

	if($demo_lock != 1 && $QUIES_CNT[0] > 0)
	{
		go("happy_member_quies.php");
		exit;
	}
	else
	{
		return false;
	}
}


//휴면회원 추출태그 치환 - ranksa
function happy_member_quies_tag_replace($tag_text,$user_id='',$quies_date='',$quies_day='')
{
	global $site_name,$site_phone,$main_url,$now_year;

	$tag_text		= str_replace("{{site_name}}",$site_name,$tag_text);		//사이트이름
	$tag_text		= str_replace("{{site_phone}}",$site_phone,$tag_text);		//사이트전화
	$tag_text		= str_replace("{{main_url}}",$main_url,$tag_text);			//메인주소
	$tag_text		= str_replace("{{user_id}}",$user_id,$tag_text);			//대상아이디
	$tag_text		= str_replace("{{quies_date}}",$quies_date,$tag_text);		//휴면회원 되는날짜

	$tag_text		= str_replace("{{quies_day}}",$quies_day,$tag_text);		//휴면회원이 될수 있는날짜(몇일전)
	$tag_text		= str_replace("{{now_year}}",$now_year,$tag_text);			//년도

	return $tag_text;
}

//휴면회원 메일링 발송 - ranksa
function happy_member_quies_mail($manual_type='')
{
	global $HAPPY_CONFIG,$site_name,$site_phone,$main_url,$admin_email,$happy_member_login_value;
	global $happy_config,$happy_member,$demo_lock,$happy_member_option_type;

	if($demo_lock == 1)
	{
		return;
	}

	if($HAPPY_CONFIG['quies_use'] == 1)
	{
		//print_r2($HAPPY_CONFIG);
		//if(0)
		if($HAPPY_CONFIG['quies_mail_send_date'] >= date("Y-m-d"))
		{
			return;
		}
		else
		{
			$Sql							= "UPDATE $happy_config SET conf_value=CURDATE() WHERE conf_name='quies_mail_send_date' ";
			query($Sql);


			$quies_day						= $HAPPY_CONFIG['quies_day'];						//휴면회원 기준일

			$quies_mail_title_handling		= $HAPPY_CONFIG['quies_mail_title_handling'];		//휴면회원 처리 메일제목
			$quies_mail_title_expect		= $HAPPY_CONFIG['quies_mail_title_expect'];			//휴면회원 처리예정 메일제목

			$quies_mail_contents_handling	= $HAPPY_CONFIG['quies_mail_contents_handling'];	//휴면회원 처리 메일내용
			$quies_mail_contents_expect		= $HAPPY_CONFIG['quies_mail_contents_expect'];		//휴면회원 처리예정 메일내용

			$quies_chk_date					= date("Y-m-d", strtotime(date("Y-m-d")."-{$HAPPY_CONFIG[quies_day]} day"));		//휴면회원 처리 기준일
			$quies_chk_mail_date			= date("Y-m-d", strtotime(date("Y-m-d")."-{$HAPPY_CONFIG[quies_mail_day]} day"));	//휴면회원 예정 처리 기준일 몇일전
			//echo $quies_chk_date." / ".$quies_chk_mail_date;exit;



			$WHERE_ARR						= Array(
													"handling"		=> " AND '$quies_chk_date' >= login_date ",			//휴면회원 처리 조건
													"expect"		=> " AND '$quies_chk_mail_date' >= login_date ",	//휴면회원 처리예정 조건
			);

			foreach($WHERE_ARR AS $w_key => $w_val)
			{
				$mail_cnt						= 0;
				$Sql							= "SELECT * FROM $happy_member WHERE 1=1 $w_val order by login_date asc limit 100";
				$Rec							= query($Sql);
				while($MEMBER					= happy_mysql_fetch_assoc($Rec))
				{
					$send_check					= false;
					$quies_date					= date("Y년 m월 d일", strtotime($MEMBER['login_date']."+{$HAPPY_CONFIG[quies_day]} day"));

					if($w_key == "handling") //휴면회원 처리 메일발송
					{
						if($quies_chk_date >= date("Y-m-d", strtotime($MEMBER['login_date'])))
						{
							$send_check				= true;
							$send_title				= happy_member_quies_tag_replace($quies_mail_title_handling,$MEMBER['user_id'],$quies_date,$quies_day);
							$send_contents			= $quies_mail_contents_handling;

							happy_member_quies_move("encrypt",$MEMBER); //휴면회원 DB테이블로 이동
							happy_member_option_set($happy_member_option_type,$MEMBER['user_id'],'quies_mail_chk',0,'int'); //휴면회원 처리예정메일 발송체크 초기화
						}
					}

					if($w_key == "expect") //휴면회원 처리예정 메일발송
					{
						if($manual_type != "quies_mail_expect") //관리자 수동 메일발송일때 중복발송허용
						{
							$quies_mail_chk			= happy_member_option_get($happy_member_option_type,$MEMBER['user_id'],'quies_mail_chk'); //휴면회원 처리예정메일 발송체크 확인
						}
						if($quies_mail_chk != 1 && $quies_chk_mail_date >= date("Y-m-d", strtotime($MEMBER['login_date'])))
						{
							$send_check				= true;
							$send_title				= happy_member_quies_tag_replace($quies_mail_title_expect,$MEMBER['user_id'],$quies_date,$quies_day);
							$send_contents			= $quies_mail_contents_expect;

							happy_member_option_set($happy_member_option_type,$MEMBER['user_id'],'quies_mail_chk',1,'int');
						}
					}

					//$MEMBER['user_email'] = "ranksa@happycgi.com"; ###############

					if($send_check == true)
					{
						$mail_cnt++;

						if($mail_cnt % 37 == 0)
						{
							ob_flush();
							flush();
							usleep(1000000);
						}


						preg_match_all("/<img[^>]*src=[\"\"]?([^>\"\"]+)[\"\"]?[^>]*>/i",$send_contents,$IMG_RESULT);
						if(sizeof($IMG_RESULT[1]) > 0)
						{
							foreach($IMG_RESULT[1] AS $img_val)
							{
								$send_contents	= str_replace($img_val,$main_url.$img_val,$send_contents);
							}
							unset($img_val);
						}
						$send_contents		= happy_member_quies_tag_replace($send_contents,$MEMBER['user_id'],$quies_date,$quies_day);

						//if(1)
						//if($demo_lock == '' && !preg_match("/aaa\.com/",$_SERVER['HTTP_HOST']))
						if($demo_lock == '')
						{
							HappyMail($site_name, $admin_email,$MEMBER['user_email'],$send_title,$send_contents);
						}
					}
				}
				//echo $mail_cnt;
				//exit;
			}
			unset($w_key,$w_val);
		}
	}
}
//happy_member_quies_mail();




//휴면회원 암복호화 - ranksa
function happy_member_quies_crypt($crypt_type='',$MEMBER)
{
	global $CRYPT_FIELD;

	//print_r2($MEMBER);
	$key				= pack('H*', "bcb04b7e103a0cd");

	foreach($MEMBER AS $m_key => $m_val)
	{
		if(in_array($m_key,$CRYPT_FIELD))
		{
			if($m_val != "")
			{
				if($crypt_type == "encrypt")
				{
					if($m_key == "user_phone" || $m_key == "user_hphone")
					{
						$m_val						= preg_replace("/\D/","",$m_val);
					}
				}


				$iv_size						= mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
				$iv								= mcrypt_create_iv($iv_size, MCRYPT_RAND);
				if($crypt_type == "encrypt")
				{
					$ciphertext					= mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$m_val, MCRYPT_MODE_CBC, $iv);
					$ciphertext					= $iv . $ciphertext;
					$ciphertext_base64			= base64_encode($ciphertext);
					//echo $ciphertext_base64."<br>";
					$MEMBER[$m_key]				= $ciphertext_base64;
				}

				if($crypt_type == "decrypt")
				{
					//$ciphertext_dec			= base64_decode($ciphertext_base64);
					$ciphertext_dec				= base64_decode($m_val);
					$iv_dec						= substr($ciphertext_dec, 0, $iv_size);
					$ciphertext_dec				= substr($ciphertext_dec, $iv_size);
					$plaintext_dec				= mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
					//echo $plaintext_dec."<br><br>";

					//복호화 과정에서 바이트 단위로 미리 버퍼가 생성되는데
					//복호화 한 이후에도 미리 잡았던 버퍼가 남아 decrypt 에서 남은
					//버퍼까지 함께 아웃풋되어 아래와 같이 남는 버퍼 0을 replace함
					//(32비트로 블럭하는 과정에서 남는 바이트 특정 문자로 패딩)
					$MEMBER[$m_key]			= str_replace("\0","",$plaintext_dec);
				}
			}
		}
	}
	unset($m_key,$m_val);

	return $MEMBER;
}


//휴면회원 옮기기 - ranksa
function happy_member_quies_move($crypt_type='',$MEMBER)
{
	global $happy_member_quies,$happy_member,$HAPPY_CONFIG,$demo_lock;

	if($demo_lock == 1)
	{
		return;
	}

	if($HAPPY_CONFIG['quies_use'] == 1)
	{
		$MEMBER					= happy_member_quies_crypt($crypt_type,$MEMBER);

		//print_r2($MEMBER);
		$NOT_IN_FIELD		= Array("number");
		$l_cnt				= 0;
		$SetSql				= "";
		foreach($MEMBER AS $m_key => $m_val)
		{
			if($crypt_type == "decrypt")		//휴면해제시 로그인날짜를 오늘로
			{
				if($m_key == "login_date")
				{
					$m_val	= date("Y-m-d h:i:s");
				}
			}

			$comma				= ($l_cnt == 0)?"":",";
			if(!in_array($m_key,$NOT_IN_FIELD))
			{
				$m_val		= addslashes($m_val);
				$SetSql		.= "{$comma}`$m_key` = '$m_val' ";
				$l_cnt++;
			}
		}
		unset($m_key,$m_val);


		if($crypt_type == "encrypt")
		{
			$inset_table	= $happy_member_quies;
			$delete_table	= $happy_member;
		}
		else if($crypt_type == "decrypt")
		{
			$inset_table	= $happy_member;
			$delete_table	= $happy_member_quies;
		}


		$Sql_in				= "
								INSERT INTO
									$inset_table
								SET
									$SetSql
		";
		$query_result		= query($Sql_in);

		if($query_result == 1)
		{
			$Sql_del			= "DELETE FROM $delete_table WHERE number='$MEMBER[number]' ";
			query($Sql_del);
		}
	}
}


//회원가입,아이디 및 비번 찾기시 사용 - ranksa
function happy_member_quies_decrypt($REQ_VAL=Array())
{
	global $happy_member_quies,$CRYPT_FIELD;

	$RETURN_MEMBER				= Array();

	$coinfo1					= $REQ_VAL['coinfo1'];
	$cl							= $REQ_VAL['cl'];

	$user_id					= $REQ_VAL['user_id'];
	$user_name					= $REQ_VAL['user_name'];

	$user_phone					= preg_replace("/\D/", "",$REQ_VAL['user_phone']);
	$user_hphone				= preg_replace("/\D/", "",$REQ_VAL['user_hphone']);
	$user_email					= $REQ_VAL['user_email'];


	$WHERE						= "";
	if($user_id != "")
	{
		$WHERE					.= " AND user_id='$user_id' ";
	}

	if($user_name != "")
	{
		$WHERE					.= " AND user_name='$user_name' ";
	}


	$Sql						= "SELECT * FROM $happy_member_quies WHERE 1=1 $WHERE ";
	$Rec						= query($Sql);
	while($MEMBER_QUIES			= happy_mysql_fetch_assoc($Rec))
	{
		$DECRYPT_VAL			= happy_member_quies_crypt('decrypt',$MEMBER_QUIES);

		if(($coinfo1 != "" && $coinfo1 == $MEMBER_QUIES['coinfo1']) || ($cl != "" && $cl == $MEMBER_QUIES['cl']))
		{
			$RETURN_MEMBER		= $MEMBER_QUIES;
			break;
		}

		foreach($REQ_VAL AS $r_key => $r_val)
		{
			if(in_array($r_key,$CRYPT_FIELD))
			{
				if($r_val != "")
				{
					if($r_key == "user_phone" || $r_key == "user_hphone")
					{
						$r_val				= preg_replace("/\D/","",$r_val);
					}

					//user_phone,user_hphone,user_email
					if($r_val == $DECRYPT_VAL[$r_key])
					{
						$RETURN_MEMBER		= $MEMBER_QUIES;
						break;
					}
				}
			}
		}
	}

	return $RETURN_MEMBER;
}
/*** 휴면회원 처리 관련 함수 END ***/






// 회원 폼양식에 이메일폼 전화번호폼 추가 2017-01-31 x2chi

// 이메일 폼 양식 - mailForm_hostSelect() 함수
function mailInputForm( $Form, $mailAddr='' )
{
	$fieldName		= $Form['field_name'];
	$fieldTitle		= $Form['field_title'];
	$fieldOptions	= $Form['field_option'];
	$fieldStyle		= $Form['field_style'];
	$fieldSureInput	= $Form['field_sureInput'];

	$mailHostArray	= explode(",", $fieldOptions);
	$mailAddrUser	= substr($mailAddr,0,strrpos($mailAddr,"@"));
	$mailAddrHost	= substr(strrchr($mailAddr,"@"),1);
	$userInputChk	= in_array($mailAddrHost,$mailHostArray);
	$userInputDef	= ( !$userInputChk ? $mailAddrHost : "" );
	//$sureInputChk	= ( $fieldSureInput == "y" ? "HNAME='".str_replace(" ","",$fieldTitle)."' required" : "" ); // 필수 체크
	$sureInputChk	= ( $fieldSureInput == "y" ? "HNAME='".str_replace(" ","",$fieldTitle)."' " : "" ); // 필수 체크

	$RETURN			= "";
	$RETURN			.= "<span class='h_form'><input type='text' name='".$fieldName."_at_user' style='width:20%' value='".$mailAddrUser."' ".$sureInputChk." ".$fieldStyle." class='join_input_e_01'></span>";
	$RETURN			.= " <span class='noto400 font_14'>@</span> ";
	$RETURN			.= "<span class='h_form'><input type='text' name='".$fieldName."_at_host' id='".$fieldName."_at_host' value='".$mailAddrHost."' ".($userInputChk?"readOnly":"")." ".$sureInputChk." ".$fieldStyle." style='width:100px;' class='join_input_e_02'></span>";
	$RETURN			.= " <span class='h_form'><select name='".$fieldName."_at_hostSel' id='".$fieldName."_at_hostSel' onchange=\"mailForm_hostSelect('".$fieldName."',this.form,this.value, '".$userInputDef."');\" ".$fieldStyle." style='width:100px;' class='join_select_e'>";
	foreach ( $mailHostArray as $host )
	{
		if( strlen($host) == 0 )
		{
			continue;
		}
		$userInputSet	= ( $host == $mailAddrHost ? "selected" : "" );
		$RETURN			.= "<option value='".$host."' ".$userInputSet.">".$host."</option>";
	}
	$RETURN			.= "<option value='userInput' ".($userInputChk?"":"selected").">직접입력</option>";
	$RETURN			.= "</select></span>";

	return $RETURN;
}

// 연락처 폼 양식
function telInputForm( $Form, $telNum='' )
{
	$fieldName		= $Form['field_name'];
	$fieldTitle		= $Form['field_title'];
	$fieldOptions	= $Form['field_option'];
	$fieldStyle		= $Form['field_style'];
	$fieldSureInput	= $Form['field_sureInput'];

	$netNumberArray		= explode(",", $fieldOptions);
	$telNum			= preg_replace("/\D/","",$telNum);

	//$sureInputChk	= ( $fieldSureInput == "y" ? "HNAME='".str_replace(" ","",$fieldTitle)."' required" : "" ); // 필수 체크
	$sureInputChk	= ( $fieldSureInput == "y" ? "HNAME='".str_replace(" ","",$fieldTitle)."' " : "" ); // 필수 체크

	$RETURN				= "";
	$RETURN				.= "<span class='h_form'><select class='join_select_p' name='".$fieldName."_tel_first' ".$sureInputChk." ".$fieldStyle.">";
	$RETURN				.= "	<option value=''>선택</option>";
	foreach ( $netNumberArray AS $locals )
	{
		if( strlen($locals) == 0 )
		{
			continue;
		}
		$setNetNumSel	= "";
		if( strpos($telNum, $locals) === 0 )
		{
			$setNetNum		= $locals;
			$setNetNumSel	= "selected";
		}
		$RETURN			.= "	<option value='".$locals."' ".$setNetNumSel.">".$locals."</option>";
	}
	$RETURN				.= "</select></span>";


	$userNumbers		.= strlen($telNum) - strlen($setNetNum);
	if( $userNumbers <= 4 )
	{
		$tel_second_val	= substr($telNum,strlen($setNetNum),4);
		$tel_third_val	= "";
	}
	else
	{
		$tel_second_val	= substr($telNum,strlen($setNetNum),$userNumbers-4);
		$tel_third_val	= substr($telNum,-4);
	}

	$RETURN				.= " - ";
	$RETURN				.= "<span class='h_form'><input type='text' class='join_input_p_01' name='".$fieldName."_tel_second' value='".$tel_second_val."' ".$sureInputChk." ".$fieldStyle." ></span>";
	$RETURN				.= " - ";
	$RETURN				.= "<span class='h_form'><input type='text' class='join_input_p_02' name='".$fieldName."_tel_third' value='".$tel_third_val."' ".$sureInputChk." ".$fieldStyle." ></span>";
	return $RETURN;
}
?>