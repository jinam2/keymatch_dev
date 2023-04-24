<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$mode				= $_GET['mode'];
	$몰주소				= $main_url;

	$Template			= '';
	$Template_Default	= '';



	if ( $mode == 'joinus' || $mode == '' )						//약관페이지
	{

		//로그인체크 2013-01-11 kad
		$happy_member_login_id	= happy_member_login_check();
		if ( $happy_member_login_id != "" )
		{
			msg('이미 로그인이 되어 있는 상태입니다.');
			go("/");
			exit;
		}
		//로그인체크 2013-01-11 kad


		$Template_Default		= $happy_member_default2_template; // YOON[2010-07-14] : 가입시 마이페이지메뉴없는 껍데기 따로 지정 (function.php)
		$Template	= "$happy_member_skin_folder/happy_member_joinus.html";

		//아이핀추가 hun		START
		if($happy_member_kcb_namecheck_use == '1')
		{
			$본인인증필수값			= "
				<input type='hidden' id='kcb_coinfo1' name='kcb_coinfo1' value=''>		<!-- 아이핀인증 필수값 -->
				<input type='hidden' id='kcb_duinfo' name='kcb_duinfo' value=''>		<!-- 아이핀인증 필수값 -->
				<input type='hidden' id='cl' name='cl' value=''>						<!-- 휴대폰인증 필수값 -->
				<input type='hidden' id='name' name='name' value=''>
				<input type='hidden' id='prefix' name='prefix' value=''>
				<input type='hidden' id='user_hphone' name='user_hphone' value=''>	<!-- 휴대폰인증 필수값 -->
				<input type='hidden' id='namecheck_type' name='namecheck_type' value=''>	<!-- 휴대폰인증 필수값 -->
			";

			if( $HAPPY_CONFIG['kcb_check_type'] == "ipin" )
			{
				$nameCheck_js="
				if(form.kcb_coinfo1.value == '' || form.kcb_duinfo.value == '')
				{
					alert('아이핀을 이용하여 본인인증을 해주세요.');
					return false;
				}
				";

				$TPL->define("본인인증수단", "$happy_member_skin_folder/kcb_ipin_check.html");
			}
			else if( $HAPPY_CONFIG['kcb_check_type'] == "hp" )
			{
				$nameCheck_js="
				if(form.cl.value == '')
				{
					alert('아이핀을 이용하여 본인인증을 해주세요.');
					return false;
				}
				";
				$TPL->define("본인인증수단", "$happy_member_skin_folder/kcb_hp_check.html");
			}
			else if( $HAPPY_CONFIG['kcb_check_type'] == "ipin_hp" )
			{
				$nameCheck_js="
				if(form.kcb_coinfo1.value == '' && form.kcb_duinfo.value == '' && form.cl.value == '')
				{
					alert('아이핀을 이용하여 본인인증을 해주세요.');
					return false;
				}
				";

				$TPL->define("본인인증수단", "$happy_member_skin_folder/kcb_ipin_hp_check.html");
			}


			$본인인증수단 = &$TPL->fetch();
		}
		else
		{
			$nameCheck_js ="";
		}
		//아이핀추가 hun				END

		# 그룹 선택을 위한 그룹 정보 추출 '세로수','가로수','그룹타입','테이블크기','템플릿','정렬'
		if ( $_COOKIE['happy_mobile'] == 'on' )
		{
			$그룹선택	= happy_member_group_list('세로100개','가로2개','가입가능_모바일','90','happy_member_joinus_group_rows.html','레벨순');
		}
		else
		{
			$그룹선택	= happy_member_group_list('세로100개','가로4개','가입가능','400','happy_member_joinus_group_rows.html','레벨순');
		}
	}
	else if ( $mode == 'joinus2' )					//회원가입폼
	{
		//로그인체크 2013-01-11 kad
		$happy_member_login_id	= happy_member_login_check();
		if ( $happy_member_login_id != "" )
		{
			msg('이미 로그인이 되어 있는 상태입니다.');
			go("/");
			exit;
		}
		//로그인체크 2013-01-11 kad

		// 회원가입 1단계 페이지에서 온건지 체크 2022-02-22 kad
		//echo $_SERVER['HTTP_REFERER'];exit;
		if ( strpos($_SERVER['HTTP_REFERER'],"happy_member.php") === false
			&& strpos($_SERVER['HTTP_REFERER'],"mode=joinus") === false )
		{
			go("happy_member.php?mode=joinus");
			exit;
		}



		$Template_Default		= $happy_member_default2_template;	// YOON[2010-07-14] : 가입시 마이페이지메뉴없는 껍데기 따로 지정 (function.php)
		$Template	= "$happy_member_skin_folder/happy_member_joinus2.html";

		$member_group	= preg_replace("/\D/", "", $_GET['member_group']);

		if ( $member_group == '' )
		{
			error("잘못된 경로로 접근하셨습니다.");
			exit;
		}

		$Sql	= "SELECT * FROM $happy_member_group WHERE number='$member_group' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));


		//회원가입시 휴대폰번호인증 2011-01-18 kad
		if ( $Tmp['iso_hphone'] == "y" )
		{
			$핸드폰체크 = '
				if(theForm.iso_hphone.value != "y")
				{
					alert("핸드폰인증을 해주세요.");
					if ( theForm.user_hphone != undefined ) {
						theForm.user_hphone.focus();
					}
					return false;
				}
			';

			$TPL->define("핸드폰인증레이어", "$happy_member_skin_folder/iso_hphone_layer.html");
			$핸드폰인증레이어 = &$TPL->fetch();
		}
		//회원가입시 휴대폰번호인증 2011-01-18 kad


		$회원그룹명 = $Tmp[group_name];

		if ( $Tmp['number'] == '' )
		{
			error('존재하지 않는 그룹 입니다.');
			exit;
		}

		if ( $Tmp['group_member_join'] != 'y' )
		{
			error('가입불가능한 그룹 입니다.');
			exit;
		}

		$주민등록번호체크	= '';
		if ( $Tmp['iso_jumin'] == 'y' && $_COOKIE['ad_id'] == "" )
		{
			$주민등록번호체크	= 'if ( check_jumin() == false ) { return false; }';
		}


		//아이핀추가 hun		START
		if( $happy_member_kcb_namecheck_use == '1' )
		{
			if( $HAPPY_CONFIG['kcb_check_type'] == "ipin_hp" )
			{
				if( $_POST['namecheck_type'] == 'ipin' )
				{
					$HAPPY_CONFIG['kcb_check_type'] = "ipin";
				}
				else if( $_POST['namecheck_type'] == 'hp' )
				{
					$HAPPY_CONFIG['kcb_check_type'] = "hp";
				}
			}

			//중복가입 방지 패치		2017-01-13	hun
			if( $HAPPY_CONFIG['kcb_check_type'] == "ipin" || $HAPPY_CONFIG['kcb_check_type'] == "hp" )
			{
				$receive_code			= ( $_POST[kcb_coinfo1] != '' ) ? $_POST[kcb_coinfo1] : $_POST[cl];
				if( $receive_code == '' )
				{
					error("본인인증 정보가 넘어오지 않았습니다."); exit;
				}

				$Sql			= "Select count(*) from $happy_member where coinfo1 = '$receive_code' OR cl = '$receive_code'";
				list($Check_CT)	= happy_mysql_fetch_array(query($Sql));

				if( $Check_CT > 0 )
				{
					if ( $_COOKIE['happy_mobile'] == 'on' ) // 모바일솔루션
					{
						gomsg("이미 가입된 고객입니다.","happy_member_login.php");
					}
					else
					{
						gomsg("이미 가입된 고객입니다.","happy_member.php?mode=lostid");
					}

					exit;
				}
			}
			//중복가입 방지 패치		2017-01-13	hun
		}
		//아이핀추가 hun		END


		//유흥이라서 추가된 회원정보
		#업종 분류 com_job -> extra13
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




	}
	else if ( $mode == 'joinus_reg' )				//회원가입처리
	{
		joinus_reg();
	}
	else if ( $mode == 'modify' )					//회원가입폼
	{
		#회원정보 입력폼 문구내용
		echo "

		";
		$현재위치				= "<a href='".$main_url."' class='now_location_link'>홈</a> &gt; 마이페이지";

		$Template	= "$happy_member_skin_folder/happy_member_modify.html";

		//개인회원일 때
		//if ($modper == 'per')
		/*
		if ( is_per_member($happy_member_login_value) == true )
		{
			$Template	= "$happy_member_skin_folder/happy_member_modify_per.html";
		}
		*/

		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error('로그인후 이용가능 합니다.');
			exit;
		}

		#happy_member_nick_history_change( 'testasdf', 'tester', 'execute' );
		#happy_member_state_open_change( 'testasdf', 'y', 'execute' );

		$Member			= happy_member_information($happy_member_login_id);
		$member_group	= $Member['group'];

		/*
		$Sql	= "SELECT * FROM $happy_member_group WHERE number='$member_group' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));
		$Template_Default		= ( $Tmp['mypage_default'] == '' )? $happy_member_mypage_default_file : $Tmp['mypage_default'];
		*/

		# 유저그룹별 껍데기 파일 추출	2010-06-29 ralear
		$sql				= "select * from $happy_member_group where number='$member_group' ";
		$result				= query($sql);
		$Data				= happy_mysql_fetch_array($result);
		$Template_Default	= $Data['mypage_default'];



		//회원정보수정시 휴대폰번호인증 2011-01-18 kad
		if ( $Data['iso_hphone'] == "y" )
		{
			$핸드폰체크 = '
				if(theForm.iso_hphone.value != "y")
				{
					alert("핸드폰인증을 해주세요.");
					if ( theForm.user_hphone != undefined ) {
						theForm.user_hphone.focus();
					}
					return false;
				}
			';

			$TPL->define("핸드폰인증레이어", "$happy_member_skin_folder/iso_hphone_layer.html");
			$핸드폰인증레이어 = &$TPL->fetch();
		}
		//회원정보수정시 휴대폰번호인증 2011-01-18 kad


		if ( !happy_member_secure( '회원탈퇴' ) )
		{
			$회원탈퇴 = '';
		}
		else
		{
			$회원탈퇴	= "<A href='html_file.php?file=member_out.html&mode=member_out'><img src='img/btn_memberout.gif' border='0'>";
			//$회원탈퇴	= "<a href='html_file.php?file=member_out.html&mode=member_out'><span class='font_16 noto400' style='display:inline-block; color:#fff; background:#666;width:120px; height:50px; line-height:50px; border-radius:5px; text-align:center;'>회원탈퇴</span></a>";
		}



		//유흥이라서 추가된 회원정보
		#업종 분류 com_job -> extra13
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

		#마이페이지에서 보여줄 회원정보
		$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
		$Group					= happy_mysql_fetch_array(query($Sql));

		$sql		= "select * from $happy_member where user_id='$happy_member_login_id'";
		$result		= query($sql);
		$Data		= happy_mysql_fetch_array($result);

		$회원그룹명 = $Group['group_name'];

	}
	else if ( $mode == 'modify_reg' )
	{

		#echo '<pre>';print_r($_POST);echo '</pre>';
		modify_reg();
		exit;

	}
	else if ( $mode == 'lostpass' )					//비밀번호찾기
	{
		if ($happy_member_find_id_type == "ipin")
		{
			$Template				= "$happy_member_skin_folder/happy_member_lost_pass_ipin.html";
		}
		else if ($happy_member_find_id_type == "hp")
		{
			$Template				= "$happy_member_skin_folder/happy_member_lost_pass_hp.html";
		}
		else if ($happy_member_find_id_type == "ipin_hp")
		{
			$Template				= "$happy_member_skin_folder/happy_member_lost_pass_ipin_hp.html";
		}
		else if ($happy_member_find_id_type == "phone")
		{
			$Template	= "$happy_member_skin_folder/happy_member_lost_pass_phone.html";
		}
		else
		{
			$Template	= "$happy_member_skin_folder/happy_member_lost_pass.html";
		}

		$Template_Default = "happy_member_default_lost.html";
	}
	else if ( $mode == 'lostpass_reg' )				//비밀번호찾기처리
	{
		//휴면회원 조회관련 happy_member_quies
		$REQ_VAL				= Array();
		$REQ_VAL['coinfo1']		= $_POST['coinfo1'];
		$REQ_VAL['cl']			= $_POST['cl'];
		$REQ_VAL['user_id']		= $_POST['member_id'];
		$REQ_VAL['user_name']	= $_POST['member_name'];
		$REQ_VAL['user_hphone']	= $_POST['member_phone'];
		$REQ_VAL['user_email']	= $_POST['member_email'];


		//중복가입 방지 패치		2017-01-13	hun
		if ( $_POST['namecheck_type'] == "ipin" || $_POST['namecheck_type'] == "hp" )
		{
			$receive_code			= ( $_POST[coinfo1] != '' ) ? $_POST[coinfo1] : $_POST[cl];

			if($receive_code == '' )
			{
				error("본인인증 후 이용해 주십시요.");
				exit;
			}

			$Sql		= "SELECT * FROM $happy_member WHERE coinfo1 = '$receive_code' OR cl = '$receive_code' ";
			$Data		= happy_mysql_fetch_array(query($Sql));

			if($_POST['user_pass'] != $_POST['user_pass_re'])
			{
				error('비밀번호를 다시 확인해주세요.');
				exit;
			}

			if( $Data['user_id'] != '' )
			{
				$member_user_id			= $Data['user_id'];
			}
			else
			{
				$MEMBER_QUIES			= happy_member_quies_decrypt($REQ_VAL);
				if($MEMBER_QUIES['user_id'] != "")
				{
					$member_user_id			= $MEMBER_QUIES['user_id'];
					happy_member_quies_move('decrypt',$MEMBER_QUIES);
				}
				else
				{
					error('일치하는 회원정보가 없습니다.');
					exit;
				}
			}

			$md5_pass	= Happy_Secret_Code( $_POST['user_pass'] );
			query("UPDATE $happy_member SET user_pass = '$md5_pass' WHERE user_id = '$member_user_id' ");
			msg("비밀번호가 변경 되었습니다.");
			go("happy_member_login.php");
			exit;
		}
		//중복가입 방지 패치		2017-01-13	hun
		else if ($search_id_type == "phone")
		{
			$member_id		= $_POST['member_id'];
			$member_phone	= preg_replace("/\D/", "", $_POST['member_phone']);

			#print_r($_POST);


			$cnt = strlen($member_phone);

			if ($cnt == "10")
			{
				$phone_1 = substr($member_phone,0,3);
				$phone_2 = substr($member_phone,3,3);
				$phone_3 = substr($member_phone,6,4);
			} else {
				$phone_1 = substr($member_phone,0,3);
				$phone_2 = substr($member_phone,3,4);
				$phone_3 = substr($member_phone,7,4);
			}

			$member_phone = $phone_1."-".$phone_2."-".$phone_3;
			$member_phone_nohyphen = $phone_1.$phone_2.$phone_3;



			$Sql	= "SELECT * FROM $happy_member WHERE user_id='$member_id' AND ( user_hphone='$member_phone' OR user_hphone='$member_phone_nohyphen') ";
			$Data	= happy_mysql_fetch_array(query($Sql));

			if ( $Data['number'] != '' )
			{
				$member_user_id			= $Data['user_id'];
				$member_user_name		= $Data['user_name'];
			}
			else
			{
				$MEMBER_QUIES			= happy_member_quies_decrypt($REQ_VAL);
				if($MEMBER_QUIES['user_id'] != "")
				{
					$member_user_id			= $MEMBER_QUIES['user_id'];
					$member_user_name		= $MEMBER_QUIES['user_name'];
					happy_member_quies_move('decrypt',$MEMBER_QUIES);
				}
				else
				{
					error('일치하는 회원정보가 없습니다.');
					exit;
				}
			}


			$tmp_pass	= rand(100,9999). rand(10,999). rand(1,999);

			$md5_pass	= Happy_Secret_Code( $tmp_pass );
			query("UPDATE $happy_member SET user_pass = '$md5_pass' WHERE user_id = '$member_user_id' ");

			/* 솔루션 별로 변경필요 */
			if ( $HAPPY_CONFIG['lost_pass_text_useable'] == '1' || $HAPPY_CONFIG['lost_pass_text_useable'] == 'kakao' )
			{
				$CONF_PHONE["lost_pass_text"] = sms_convert($HAPPY_CONFIG["lost_pass_text"],$member_user_name,'','',$tmp_pass,$member_phone_nohyphen,'','','','');
				//echo sms_send(0,$member_phone_nohyphen,$site_phone,"",$CONF_PHONE["lost_pass_text"],"1000","","on",$HAPPY_CONFIG['lost_pass_text_useable'],$HAPPY_CONFIG['lost_pass_text_ktplcode']);
				$dataStr = send_sms_msg($sms_userid,$member_phone_nohyphen,$site_phone,$CONF_PHONE["lost_pass_text"],5,$sms_testing,'',$HAPPY_CONFIG['lost_pass_text_useable'],$HAPPY_CONFIG['lost_pass_text_ktplcode']);
				send_sms_socket($dataStr);
			}
			/* 솔루션 별로 변경필요 */

			gomsg("비밀번호를 SMS문자로 발송했습니다.",'happy_member_login.php');
			exit;
		}
		else
		{
			$member_id		= $_POST['member_id'];
			$member_email	= $_POST['member_email'];

			$Sql	= "SELECT * FROM $happy_member WHERE user_id='$member_id' AND user_email='$member_email' ";
			$Data	= happy_mysql_fetch_array(query($Sql));

			if ( $Data['number'] != '' )
			{
				$member_user_id			= $Data['user_id'];
				$member_user_name		= $Data['user_name'];
			}
			else
			{
				$MEMBER_QUIES			= happy_member_quies_decrypt($REQ_VAL);
				if($MEMBER_QUIES['user_id'] != "")
				{
					$member_user_id			= $MEMBER_QUIES['user_id'];
					$member_user_name		= $MEMBER_QUIES['user_name'];
					happy_member_quies_move('decrypt',$MEMBER_QUIES);
				}
				else
				{
					error('일치하는 회원정보가 없습니다.');
					exit;
				}
			}


			$tmp_pass	= rand(100,9999). rand(10,999). rand(1,999);

			$md5_pass	= Happy_Secret_Code( $tmp_pass );
			query("UPDATE $happy_member SET user_pass = '$md5_pass' WHERE user_id = '$member_user_id' ");

			/* 솔루션 별로 변경필요 */
			$title		= "${site_name}에서 요청하신 비밀번호 정보를 알려드립니다.";

			$사이트이름 = $site_name;
			$운영자이름 = $master_name;
			$회원이름 = $member_user_name;
			$회원아이디 = $member_id;
			$회원패스워드 = $tmp_pass;
			$main_url = $main_url;

			$TPL->define("비밀번호찾기이메일", "./$skin_folder/lost_pass_mail.html");
			$TPL->assign("비밀번호찾기이메일");
			$product_c = $TPL->fetch();

			//메일 함수 통합 - hong
			HappyMail($master_name, $admin_email,$member_email,$title,$product_c);

			//echo "$member_email <br><hr><br> $title <br><hr><br> $product_c <br><hr><br> $headers";

			gomsg("성공적으로 메일이 발송되었습니다.",'happy_member_login.php');
			/* 솔루션 별로 변경필요 */
			exit;
			#lostpass_reg();
		}
	}
	else if ( $mode == 'lostid' )					//아이디찾기
	{
		if ($happy_member_find_id_type == "ipin")
		{
			$Template				= "$happy_member_skin_folder/happy_member_lost_id_ipin.html";
		}
		else if ($happy_member_find_id_type == "hp")
		{
			$Template				= "$happy_member_skin_folder/happy_member_lost_id_hp.html";
		}
		else if ($happy_member_find_id_type == "ipin_hp")
		{
			$Template				= "$happy_member_skin_folder/happy_member_lost_id_ipin_hp.html";
		}
		else if ($happy_member_find_id_type == "phone")
		{
			$Template	= "$happy_member_skin_folder/happy_member_lost_id_phone.html";
		}
		else
		{
			$Template	= "$happy_member_skin_folder/happy_member_lost_id.html";
		}
		#echo $Template;

		$Template_Default = "happy_member_default_lost.html";

	}
	else if ( $mode == 'lostid_reg' )				//아이디찾기 처리
	{
		//중복가입 방지 패치		2017-01-13	hun
		if ( $_POST['namecheck_type'] == "ipin" || $_POST['namecheck_type'] == "hp" )
		{
			$receive_code			= ( $_POST[coinfo1] != '' ) ? $_POST[coinfo1] : $_POST[cl];
			if( $receive_code == '' )
			{
				error("본인인증 정보가 넘어오지 않았습니다."); exit;
			}

			$Sql	= "SELECT * FROM $happy_member WHERE coinfo1 = '$receive_code' OR cl = '$receive_code' ";
		}
		//중복가입 방지 패치		2017-01-13	hun
		else if ($search_id_type == "phone")
		{
			$member_name	= $_POST['member_name'];
			$member_phone	= preg_replace("/\D/", "", $_POST['member_phone']);

			#print_r($_POST);


			$cnt	= strlen($member_phone);

			if ($cnt == "10")
			{
				$phone_1	= substr($member_phone,0,3);
				$phone_2	= substr($member_phone,3,3);
				$phone_3	= substr($member_phone,6,4);
			}
			else
			{
				$phone_1	= substr($member_phone,0,3);
				$phone_2	= substr($member_phone,3,4);
				$phone_3	= substr($member_phone,7,4);
			}

			$member_phone			= $phone_1."-".$phone_2."-".$phone_3;
			$member_phone_nohyphen	= $phone_1.$phone_2.$phone_3;

			$Sql	= "SELECT * FROM $happy_member WHERE user_name='$member_name' AND ( user_hphone='$member_phone' OR user_hphone='$member_phone_nohyphen') ";

		}
		else
		{
			$member_name	= $_POST['member_name'];
			$member_email	= $_POST['member_email'];

			$Sql	= "SELECT * FROM $happy_member WHERE user_name='$member_name' AND user_email='$member_email' ";
		}

		$Data		= happy_mysql_fetch_array(query($Sql));
		if ( $Data['number'] != "" )
		{
			if ($happy_member_find_id_type == "ipin" || $happy_member_find_id_type == "hp" || $happy_member_find_id_type == "ipin_hp")
			{
				msg("회원님의 아이디는 [$Data[user_id]] 입니다.");
				go("happy_member_login.php?get_id=$Data[user_id]&returnUrl=".urlencode('index.php'));
			}
			else if ($search_id_type == "phone")
			{
				/* 솔루션 별로 변경필요 */
				if ( $HAPPY_CONFIG['lost_id_text_useable'] == '1' || $HAPPY_CONFIG['lost_id_text_useable'] == 'kakao' )
				{
					$lost_id_text = sms_convert($HAPPY_CONFIG["lost_id_text"],$Data["user_name"],'','','',$member_phone_nohyphen,'','','',$Data["user_id"]);
					//echo sms_send(0,$member_phone_nohyphen,$site_phone,"",$lost_id_text,"1000","","on",$HAPPY_CONFIG['lost_id_text_useable'],$HAPPY_CONFIG['lost_id_text_ktplcode']);
					$dataStr = send_sms_msg($sms_userid,$member_phone_nohyphen,$site_phone,$lost_id_text,5,$sms_testing,'',$HAPPY_CONFIG['lost_id_text_useable'],$HAPPY_CONFIG['lost_id_text_ktplcode']);
					send_sms_socket($dataStr);
				}
				/* 솔루션 별로 변경필요 */

				//gomsg("회원님의 아이디는 [$Data[user_id]] 입니다.",'happy_member_login.php?get_id='.$Data['user_id']);
				gomsg("아이디를 SMS문자로 발송했습니다.",'happy_member_login.php?get_id='.$Data['user_id']);
			}
			else
			{
				#echo "$happy_member_skin_folder/lost_id_mail.html";exit;

				/* 솔루션 별로 변경필요 */
				$title		= "${site_name}에서 요청하신 아이디 정보를 알려드립니다.";

				/*
				$product_c	= file_get("$happy_member_skin_folder/lost_id_mail.html");
				$product_c	= str_replace("{{사이트이름}}", "$site_name", $product_c);
				$product_c	= str_replace("{{운영자이름}}", "$master_name", $product_c);
				$product_c	= str_replace("{{회원이름}}", "$Data[user_name]", $product_c);
				$product_c	= str_replace("{{회원아이디}}", "$Data[user_id]", $product_c);
				$product_c	= str_replace("{{main_url}}", "$main_url", $product_c);
				$product_c	= stripslashes($product_c);
				*/

				$사이트이름 = $site_name;
				$운영자이름 = $master_name;
				$회원이름 = $Data['user_name'];
				$회원아이디 = $Data['user_id'];

				$TPL->define("아이디찾기이메일", "./$skin_folder/lost_id_mail.html");
				$TPL->assign("아이디찾기이메일");
				$product_c = $TPL->fetch();

				//메일 함수 통합 - hong
				HappyMail($master_name, $admin_email,$member_email,$title,$product_c);

				//echo "$member_email <br><hr><br> $title <br><hr><br> $product_c <br><hr><br> $headers";

				gomsg("성공적으로 메일이 발송되었습니다.",'happy_member_login.php');
				/* 솔루션 별로 변경필요 */
			}
		}
		else
		{
			//휴면회원 조회관련 happy_member_quies
			$REQ_VAL				= Array();
			$REQ_VAL['coinfo1']		= $_POST['coinfo1'];
			$REQ_VAL['cl']			= $_POST['cl'];
			$REQ_VAL['user_name']	= $_POST['member_name'];
			$REQ_VAL['user_hphone']	= $_POST['member_phone'];
			$REQ_VAL['user_email']	= $_POST['member_email'];
			$MEMBER_QUIES			= happy_member_quies_decrypt($REQ_VAL);
			if($MEMBER_QUIES['user_id'] != "")
			{
				happy_member_quies_move('decrypt',$MEMBER_QUIES);
				msg("회원님의 아이디는 [$MEMBER_QUIES[user_id]] 입니다.");
				go("happy_member_login.php?get_id=$MEMBER_QUIES[user_id]");
			}
			else
			{
				error('일치하는 회원정보가 없습니다.');
			}
		}
		exit;
	}
	else if ( $mode == 'mypage' )
	{
		$현재위치				= "<a href='".$main_url."' class='now_location_link'>홈</a> &gt; 마이페이지";
		# 접속 권한 체크

		if ( happy_member_login_check() == "" )
		{
			if ($_SERVER["REMOTE_ADDR"] !="112.216.70.108") {	//아이엔아이 ip(테스트용)
				gomsg("로그인 후 이용하세요","./happy_member_login.php");
				exit;
			}
		}

		if ( !happy_member_secure( '마이페이지' ) )
		{
			error('접속권한이 없습니다.');
			exit;
		}

		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" && happy_member_secure( '마이페이지' ) )
		{
			if ($_SERVER["REMOTE_ADDR"] !="112.216.70.108") {		//아이엔아이 ip(테스트용)
				error("관리자라도 마이페이지에 접근하기 위해서는 회원으로 로그인을 하셔야 합니다.");
				exit;
			}
		}

		$Member					= happy_member_information($happy_member_login_id);
		$member_group			= $Member['group'];

		$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
		$Group					= happy_mysql_fetch_array(query($Sql));

		$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
		$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
		$Template				= $happy_member_skin_folder.'/'.$Template;


		#마이페이지에서 보여줄 회원정보
		$sql		= "select * from $happy_member where user_id='$happy_member_login_id'";
		$result		= query($sql);
		$Data		= happy_mysql_fetch_array($result);

		$회원그룹명 = $Group['group_name'];


		//솔루션마다 다름
		################################################################################
		//일반회원영역
		$아이디		= $Data['user_id'];
		$이름		= $Data['user_name'];
		$닉네임		= $Data['user_nick'];
		$이메일		= $Data['user_email'];
		$휴대폰		= $Data['user_hphone'];
		$사진		= "<img src=".$Data['photo1']." border=0 width='$PERPOTHO_DST_W[0]' height='$PERPOTHO_DST_H[0]' onError=this.src='img/noimg.gif'>";

		$mem_photo = $사진;
		$MEM['id'] = $Data['user_id'];
		$MEM['per_birth'] = $Data['user_birth_year']."-".$Data['user_birth_month']."-".$Data['user_birth_day'];
		$MEM['per_phone'] = $Data['user_phone'];
		$MEM['per_cell'] = $Data['user_hphone'];
		$MEM['per_email'] = $Data['user_email'];
		$MEM['per_zip'] = $Data['user_zip'];
		$MEM['per_addr1'] = $Data['user_addr1'];
		$MEM['per_addr2'] = $Data['user_addr2'];
		$MEM['etc1'] = $Data['photo1'];

		//print_r2($MEM);

		if ( $MEM['per_email'] == "" )
		{
			$MEM['per_email'] = "정보없음";
		}
		if ( $MEM['per_phone'] == "" )
		{
			$MEM['per_phone'] = "정보없음";
		}
		if ( $MEM['per_cell'] == "" )
		{
			$MEM['per_cell'] = "정보없음";
		}
		if ( $MEM['per_zip'] == "" )
		{
			$MEM['per_zip'] = "정보없음";
		}
		if ( $Data['user_homepage'] == "" )
		{
			$Data['user_homepage'] = "정보없음";
		}

		if ( $Data["user_prefix"] == "man" )
		{
			#$Data["user_prefix"] = "남";
			$MEM["user_prefix"] = $HAPPY_CONFIG['MsgUserPrefixMan1'];
		}
		else if ( $Data["user_prefix"] == "girl" )
		{
			#$Data["user_prefix"] = "여";
			$MEM["user_prefix"] = $HAPPY_CONFIG['MsgUserPrefixGirl1'];
		}
		else
		{
			$MEM["user_prefix"] = "";
		}


		$sql01 = "SELECT count(*) FROM job_guin AS A INNER JOIN job_scrap AS B ON A.number = B.cNumber WHERE ( A.guin_end_date >= curdate() OR A.guin_choongwon = '1' ) AND B.userid = '$user_id'";

		list($scrap_cnt) = mysql_fetch_row(query($sql01));
		$채용정보스크랩수 = number_format($scrap_cnt);




		$Sql	= "SELECT viewListCount,fileName1,fileName2,fileName3,fileName4,fileName5 FROM $per_document_tb WHERE user_id='$user_id' ";
		$Record	= query($Sql);

		$fileCount_doc	= 0;
		$fileCount_img	= 0;
		$fileCount_etc	= 0;
		$viewCount		= 0;
		$docCount		= 0;
		while ( $Data2 = happy_mysql_fetch_array($Record) )
		{
			$docCount++;
			$viewCount	+= $Data2["viewListCount"];

			for ( $i=1 ; $i<=5 ; $i++ )
			{
				$file	= $Data2["fileName".$i];
				$tmp	= explode(".",$file);
				$file	= strtolower( $tmp[sizeof($tmp)-1] );
				if ( $file=="jpg" || $file=="jpeg" || $file=="gif" || $file=="png" )
				{
					$fileCount_img++;
				}
				else if ( $file=="txt" || $file=="doc" || $file=="hwp" || $file=="xls" || $file=="cvs" || $file=="ppt" )
				{
					$fileCount_doc++;
				}
				else if ( $file!="" )
				{
					$fileCount_etc++;
				}
			}
		}

		$이력서수			= $docCount;
		$문서첨부파일수		= $fileCount_doc;
		$이미지첨부파일수	= $fileCount_img;
		$기타첨부파일수		= $fileCount_etc;
		$이력서열람기업수	= $viewCount;

		$sql01 = "select count(*) from $per_want_doc_tb where per_id = '$user_id'";
		list($면접제의요청) = mysql_fetch_row(query($sql01));
		$개인회원유료옵션 = get_uryo_cnt(1,2);

		$today_view_cnt2 = sizeof(explode(",", $_COOKIE["HappyTodayGuin"]));
		$오늘본채용수 = number_format($today_view_cnt2);
		/*
		echo "이력서수 : ".$이력서수."<br>";
		echo "문서첨부파일수 : ".$fileCount_doc."<br>";
		echo "이미지첨부파일수 : ".$fileCount_img."<br>";
		echo "기타첨부파일수 : ".$fileCount_etc."<br>";
		echo "이력서열람기업수 : ".$viewCount."<br>";
		*/

		#마춤채용정보를 마이페이지에 추출하기 위해서 추가됨
		#맞춤구인설정 가져오자.
		$sql = "select * from ".$job_per_want_search." where id = '".$MEM['id']."'";
		$result = query($sql);
		$WantSearchGuin = happy_mysql_fetch_assoc($result);
		if ( $WantSearchGuin['query_str'] != '' )
		{
			$WHERE2 = " AND ".$WantSearchGuin['query_str'];
		}
		else
		{
			$WHERE2 = " AND 1=2 ";
		}

		$guin_cnt	= mysql_fetch_row(query("select count(*) from $guin_tb WHERE ( guin_choongwon = 1 or guin_end_date > curdate() ) $WHERE2 "));
		$맞춤채용정보수 = number_format($guin_cnt[0]);
		#맞춤구인설정 가져오자.
		//일반회원영역
		################################################################################

		################################################################################
		//기업회원영역


		$naver_get_addr	= $Data['user_addr1'] ." ". $Data['user_addr2'];
		$MEM['etc1'] = $Data['photo2'];
		$MEM['etc2'] = $Data['photo3'];
		$MEM['com_job'] = $Data['extra13'];
		$MEM['com_profile1'] = nl2br($Data['message']);
		$MEM['com_profile2'] = nl2br($Data['memo']);
		$MEM['boss_name'] = $Data['extra11'];
		$MEM['com_open_year'] = $Data['extra1'];
		$MEM['com_worker_cnt'] = $Data['extra2'];
		$MEM['com_zip'] = $Data['user_zip'];
		$MEM['com_addr1'] = $Data['user_addr1'];
		$MEM['com_addr2'] = $Data['user_addr2'];

		$MEM['com_jabon']	= ( !$MEM['extra15'] )?"0":number_format($MEM['extra15']);
		$MEM['com_maechul']	= ( !$MEM['extra17'] )?"0":number_format($MEM['extra17']);

		$유료옵션 = get_uryo_cnt();

		$오늘본이력서수 = 0;
		if ( $_COOKIE["HappyTodayGuzic"] != "" )
		{
			$today_view_cnt = sizeof(explode(",", $_COOKIE["HappyTodayGuzic"]));
			$오늘본이력서수 = number_format($today_view_cnt);
		}

		if ( file_exists ("./$MEM[etc1]") && $MEM[etc1] != "" )
		{
			$logo_img = explode(".",$MEM["etc1"]);
			$logo_temp = $logo_img[0]."_thumb.".$logo_img[1];

			if ( file_exists ("./$logo_temp" ) )
			{
				$MEM[logo_temp] = "<img src='./$logo_temp'  align='absmiddle'  border='0' width='$ComLogoDstW' height='$ComLogoDstH'>";
			}
			else
			{
				$MEM[logo_temp] = "<img src='./$MEM[etc1]' width='$COMLOGO_DST_W[0]' height='$COMLOGO_DST_H[0]' align='absmiddle' border='0'>";
			}
		}
		else
		{
			$MEM[logo_temp] = "<img src='./img/logo_img.gif' >";
		}

		if ( file_exists ("./$MEM[etc2]") && $MEM[etc2] != "" )
		{
			$banner_img = explode(".",$MEM["etc2"]);
			$banner_temp = $banner_img[0]."_thumb.".$banner_img[1];

			if ( file_exists("./$banner_temp" ) )
			{
				$MEM[banner] = "<img src='./$banner_temp'  align='absmiddle' border='0'>";
			}
			else
			{
				$MEM[banner] = "<img src='./$MEM[etc2]' width='$COMBANNER_DST_W[0]' height='$COMBANNER_DST_H[0]' align='absmiddle' border='0'>";
			}
		}
		else
		{
			$MEM[banner] = "<img src='./img/logo_img.gif' >";
		}

		#마춤인재정보를 마이페이지에 추출하기 위해서 추가됨
		#마춤인재정보를 가져오자.
		$sql = "select * from ".$job_com_want_search." where id = '".$MEM['id']."'";
		//echo $sql;
		$result = query($sql);
		$WantSearchDoc = happy_mysql_fetch_assoc($result);

		if ( $WantSearchDoc['query_str'] != '' )
		{
			$WHERE3 = " AND ".$WantSearchDoc['query_str'];
		}
		else
		{
			$WHERE3 = " AND 1=2 ";
		}
		#맞춤구직정보는 DB에서 쿼리 가져오도록

		$guzic_cnt	= mysql_fetch_row(query("select count(*) from $per_document_tb WHERE 1=1 AND display = 'Y' $WHERE3 "));
		$맞춤인재정보수 = number_format($guzic_cnt[0]);
		//print_r2($WantSearchDoc);
		#마춤인재정보를 가져오자.

		//기업회원영역
		################################################################################
		//솔루션마다 다름



		#회원그룹명 뽑기
		$MemberData	= happy_member_information($아이디);
		$user_group	= $MemberData['group'];
		$Sql		= "SELECT * FROM $happy_member_group WHERE number='$user_group' ";
		$GROUP		= happy_mysql_fetch_array(query($Sql));

		//print_r($GROUP);

		//SNS아이디출력 - 2016-07-04 hong
		$Data['userid_info']	= outputSNSID($Data['user_id']);
		$MEM['userid_info']		= $Data['userid_info'];


		#추천인 링크발급 버튼 출력 - 13.01.15 hong 추가 - 16.10.17 x2chi 이전
		$추천인링크발급 = "";
		if ( $HAPPY_CONFIG['recommend_use'] == "y" )
		{
			//$추천인링크발급 = "<a href='#' onclick=\"javascript:window.open('recommend_link.php','recommend_link','width=500, height=350,scrollbars=no,titlebar=no,status=no,resizable=no,fullscreen=no');\"><img src='img/btn_recommend.gif' alt='추천인 링크발급' title='추천인 링크발급' style='vertical-align:middle;'></a>";
			$추천인링크발급 = "<a href='#' onclick=\"javascript:window.open('recommend_link.php','recommend_link','width=500, height=350,scrollbars=no,titlebar=no,status=no,resizable=no,fullscreen=no');\"><span class='font_14 noto400' style='background:#fff; color:#666; border:1px solid #ddd; width:110px; height:30px; display:inline-block; border-radius:15px; text-align:center; line-height:30px;'>추천인 링크발급</span></a>";
		}

	}
	else if( $mode == 'delete' )
	{

		if ( !happy_member_secure( '회원탈퇴' ) )
		{
			error('권한이 없습니다.');
			exit;
		}

		$happy_member_login_id	= happy_member_login_check();

		$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member WHERE user_id='$happy_member_login_id'"));
		if ( $MemberData['number'] == '' )
		{
			error("존재하지 않는 회원정보 입니다.");
			exit;
		}
		$_GET['member_group']	= $MemberData['group'];
		$member_group			= $MemberData['group'];


		if ($MemberData['sns_site'] == "")
		{
			if($_POST['userid'] != $MemberData['user_id'])
			{
				error("입력하신 아이디가 올바르지 않습니다.");
				exit;
			}


			if(Happy_Secret_Code($_POST['userpass']) != $MemberData['user_pass'])
			{
				error("입력하신 비밀번호가 올바르지 않습니다.");
				exit;
			}

			$Sql = "select * from $happy_member_field where member_group = '".$MemberData['group']."' AND field_name = 'user_jumin1'";
			$Result = query($Sql);
			$Field_data = happy_mysql_fetch_array($Result);

			if($Field_data['field_use'] == 'y' || $Field_data['field_use'] == 'Y')
			{
				//주민번호 앞자리 검사
				if($_POST['jumin1'] != $MemberData['user_jumin1'])
				{
					error("입력하신 주민번호가 올바르지 않습니다.");
					exit;
				}

				//주민번호 뒷자리 검사
				if(Happy_Secret_Code($_POST['jumin2']) != $MemberData['user_jumin2'])
				{
					error("입력하신 주민번호가 올바르지 않습니다.");
					exit;
				}
			}
		}




		#회원정보 삭제
		$Sql	= "DELETE FROM $happy_member WHERE user_id='$happy_member_login_id' ";
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

			if ( $Form['field_use_admin'] != 'y' )
			{
				continue;
			}

			if ( $demo_lock != "" )
			{
				# 파일일때
				if ( $Form['field_type'] == 'file' && $MemberData[$nowField] != '' )
				{
					$nowFile	= $MemberData[$nowField];

					#echo $nowFile."<hr>";
					happy_member_image_unlink("./$nowFile",Array("_thumb","_thumb2"));
				}
			}
		}


		gomsg("삭제되었습니다.","happy_member_login.php?mode=logout");
		exit;
	}
	else if ( $mode == 'today_view_resume' )
	{
		$Template	= "$skin_folder/today_view_resume.html";
	}


#######################################################################################################################

	function joinus_reg()
	{
		global $happy_member, $happy_member_field, $happy_member_group, $happy_member_level, $member_auto_addslashe;
		global $happy_member_path, $happy_member_upload_folder, $happy_member_upload_path;
		global $happy_member_image_width, $happy_member_image_height, $happy_member_image_quality, $happy_member_image_position, $happy_member_image_logo, $happy_member_image_logo_position, $happy_member_image_type;
		global $happy_member_image_width2, $happy_member_image_height2, $happy_member_image_quality2, $happy_member_image_position2, $happy_member_image_logo2, $happy_member_image_logo_position2, $happy_member_image_type2;
		global $happy_member_sms_confirm, $happy_member_email_confirm, $happy_member_out;
		global $HAPPY_CONFIG, $message_tb, $admin_id, $site_name, $site_phone, $admin_email, $main_url, $wys_url;
		//이미지 생성
		global $PerPhotoDstW,$PerPhotoDstH,$PerPhotoCreateType;
		global $ComLogoDstW,$ComLogoDstH,$ComPhotoCreateType1;
		global $ComBannerDstW,$ComBannerDstH,$ComPhotoCreateType2;

		global $happy_member_kcb_namecheck_use, $sms_userid;		//아이핀인증 사용할지 여부 관련변수

		global $_SESSION,$recommend_get_id, $recommend_join, $point_jangboo;		//추천인 기능 추가 - 13.01.15 hong - 16.10.17 x2chi 이전
		global $happy_member_quies;


		/*
		$user_id			= $_POST['user_id'];
		$user_pass			= $_POST['user_pass'];
		$user_name			= $_POST['user_name'];
		$user_nick			= $_POST['user_nick'];
		$user_jumin1		= $_POST['user_jumin1'];
		$user_jumin2		= $_POST['user_jumin2'];
		$user_birth_year	= $_POST['user_birth_year'];
		$user_birth_month	= $_POST['user_birth_month'];
		$user_birth_day		= $_POST['user_birth_day'];
		$user_birth_type	= $_POST['user_birth_type'];
		$user_prefix		= $_POST['user_prefix'];
		$user_email			= $_POST['user_email'];
		$user_phone			= $_POST['user_phone'];
		$user_hphone		= $_POST['user_hphone'];
		$user_fax			= $_POST['user_fax'];
		$user_homepage		= $_POST['user_homepage'];
		$user_zip			= $_POST['user_zip'];
		$user_addr1			= $_POST['user_addr1'];
		$user_addr2			= $_POST['user_addr2'];
		$com_number1		= $_POST['com_number1'];
		$com_number2		= $_POST['com_number2'];
		$com_number3		= $_POST['com_number3'];
		$com_name			= $_POST['com_name'];
		$com_phone			= $_POST['com_phone'];
		$com_birth			= $_POST['com_birth'];
		$group				= $_POST['group'];
		$level				= $_POST['level'];
		$doing				= $_POST['doing'];
		$point				= 0;
		$bbs_point			= 0;
		$recommend			= $_POST['recomment'];
		$message			= $_POST['message'];
		$email_forwarding	= $_POST['email_forwarding'];
		$sms_forwarding		= $_POST['sms_forwarding'];
		$stats_open			= $_POST['stats_open'];
		$admin_memo			= '';

		$extra1				= $_POST['extra1'];
		$extra2				= $_POST['extra2'];
		$extra3				= $_POST['extra3'];
		$extra4				= $_POST['extra4'];
		$extra5				= $_POST['extra5'];
		$extra6				= $_POST['extra6'];
		$extra7				= $_POST['extra7'];
		$extra8				= $_POST['extra8'];
		$extra9				= $_POST['extra9'];
		$extra10			= $_POST['extra10'];
		$extra11			= $_POST['extra11'];
		$extra12			= $_POST['extra12'];
		$extra13			= $_POST['extra13'];
		$extra14			= $_POST['extra14'];
		$extra15			= $_POST['extra15'];
		$extra16			= $_POST['extra16'];
		$extra17			= $_POST['extra17'];
		$extra18			= $_POST['extra18'];
		$extra19			= $_POST['extra19'];
		$extra20			= $_POST['extra20'];

		if ( $member_auto_addslashe == '1' )
		{
			$user_id			= addslashes($user_id);
			$user_pass			= addslashes($user_pass);
			$user_name			= addslashes($user_name);
			$user_nick			= addslashes($user_nick);
			$user_jumin1		= addslashes($user_jumin1);
			$user_jumin2		= addslashes($user_jumin2);
			$user_birth_type	= addslashes($user_birth_type);
			$user_prefix		= addslashes($user_prefix);
			$user_email			= addslashes($user_email);
			$user_phone			= addslashes($user_phone);
			$user_hphone		= addslashes($user_hphone);
			$user_fax			= addslashes($user_fax);
			$user_homepage		= addslashes($user_homepage);
			$user_zip			= addslashes($user_zip);
			$user_addr1			= addslashes($user_addr1);
			$user_addr2			= addslashes($user_addr2);
			$com_number1		= addslashes($com_number1);
			$com_number2		= addslashes($com_number2);
			$com_number3		= addslashes($com_number3);
			$com_name			= addslashes($com_name);
			$com_phone			= addslashes($com_phone);
			$com_birth			= addslashes($com_birth);
			$recommend			= addslashes($recomment);
			$message			= addslashes($message);
			$email_forwarding	= addslashes($email_forwarding);
			$sms_forwarding		= addslashes($sms_forwarding);
			$stats_open			= addslashes($stats_open);

			$extra1				= addslashes($extra1);
			$extra2				= addslashes($extra2);
			$extra3				= addslashes($extra3);
			$extra4				= addslashes($extra4);
			$extra5				= addslashes($extra5);
			$extra6				= addslashes($extra6);
			$extra7				= addslashes($extra7);
			$extra8				= addslashes($extra8);
			$extra9				= addslashes($extra9);
			$extra10			= addslashes($extra10);
			$extra11			= addslashes($extra11);
			$extra12			= addslashes($extra12);
			$extra13			= addslashes($extra13);
			$extra14			= addslashes($extra14);
			$extra15			= addslashes($extra15);
			$extra16			= addslashes($extra16);
			$extra17			= addslashes($extra17);
			$extra18			= addslashes($extra18);
			$extra19			= addslashes($extra19);
			$extra20			= addslashes($extra20);

		}

		# 숫자입력필드 값정리
		$user_birth_year	= preg_replace('/\D/','',$user_birth_year);
		$user_birth_month	= preg_replace('/\D/','',$user_birth_month);
		$user_birth_day		= preg_replace('/\D/','',$user_birth_day);
		$extra1				= preg_replace('/\D/','',$extra1);
		$extra2				= preg_replace('/\D/','',$extra2);
		$extra3				= preg_replace('/\D/','',$extra3);
		$extra4				= preg_replace('/\D/','',$extra4);
		$extra5				= preg_replace('/\D/','',$extra5);

		*/


		$_POST['user_id'] = trim($_POST['user_id']);





		if (!is_dir("$happy_member_upload_folder")){
			error("첨부파일을 위한 ($happy_member_upload_folder)폴더가 존재하지 않습니다.  ");
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



		$login_count		= 0;
		$group				= $_POST['group'];

		$_POST['user_jumin2']		= Happy_Secret_Code($_POST['user_jumin2']);
		$member_group				= $_POST['group'];

		#그룹명으로 가입가능한 그룹인지 한번더 체크
		$Sql	= "SELECT * FROM $happy_member_group WHERE number='$group'";
		$Group	= happy_mysql_fetch_array(query($Sql));

		if ( $Group['group_member_join'] != 'y' )
		{
			error("가입이 불가능한 그룹입니다.");
			exit;
		}


		$_POST['user_id']	= strtolower(trim($_POST['user_id']));
		$_POST['user_id']	= preg_replace("/[^0-9a-zA-Z]/","",$_POST['user_id']);
		$user_id			= $_POST['user_id'];
		$user_nick			= trim($_POST['user_nick']);
		if ( $member_auto_addslashe == '1' )
		{
			$user_id	= addslashes($user_id);
			$user_nick	= addslashes($user_nick);
		}

		$Sql		= "SELECT Count(*) FROM $happy_member WHERE user_id = '$user_id'";
		list($Chk)	= happy_mysql_fetch_array(query($Sql));

		$Sql		= "SELECT Count(*) FROM $happy_member_quies WHERE user_id = '$user_id'";
		list($Chk2)	= happy_mysql_fetch_array(query($Sql));

		if ( $Chk > 0 || $Chk2 > 0 )
		{
			error('동일한 아이디가 존재합니다.');
			exit;
		}

		$Sql		= "SELECT Count(*) FROM $happy_member_out WHERE out_id = '$user_id' ";
		list($Chk)	= happy_mysql_fetch_array(query($Sql));

		if ( $Chk > 0 )
		{
			error('해당 아이디로 가입이 불가능합니다.');
			exit;
		}

		# 닉네임 사용 여부 체크 #
		$Sql		= "SELECT Count(*) FROM $happy_member_field WHERE field_name='user_nick' AND member_group='$group' AND field_use='Y' ";
		list($Tmp)	= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp > 0 )
		{
			$Sql		= "SELECT Count(*) FROM $happy_member WHERE user_nick = '$user_nick'";
			list($Chk)	= happy_mysql_fetch_array(query($Sql));

			$Sql		= "SELECT Count(*) FROM $happy_member_quies WHERE user_nick = '$user_nick'";
			list($Chk2)	= happy_mysql_fetch_array(query($Sql));

			if ( $Chk > 0 || $Chk2 > 0 )
			{
				error('동일한 닉네임이 존재합니다.');
				exit;
			}
		}






		$Sql	= "SELECT * FROM $happy_member_field WHERE member_group = '$group' $WHERE ";
		$Record	= query($Sql);

		$Cnt	= 0;
		$SetSql	= '';
		while ( $Form = happy_mysql_fetch_array($Record) )
		{
			$Fields		= call_happy_member_field($Form['field_name']);
			#echo "<pre>";			print_r($Fields);			echo "</pre>";
			#echo "$".$Fields['Field'] ."  = ". $_POST[$Fields['Field']]."<hr>";

			$nowField	= $Fields['Field'];

			if ( $nowField == '' )
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

					if ( $ext_check != 'ok' )
					{
						$addMessage	= $Form['field_title'] . " : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $Form[field_option] 입니다.";
						#echo $addMessage;
						msg($addMessage);
						exit;
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




						} #copy 완료마지막
					}
				}
			}

			if ( is_array(${$nowField}) )
			{
				${$nowField}	= @implode(",", (array) ${$nowField});
			}


			if ( $Form['field_sureInput'] == 'y' && $Form['field_use'] == 'y' && ${$nowField} == '' )
			{
				//echo $Form['field_name'] ." 필드의 값이 넘어오지 않았습니다.";
				#error( $Form['field_name'] ." 필드의 값이 넘어오지 않았습니다. ");
				#exit;
			}

			$SetSql	.= ( $SetSql == '' )? '' : ', ';

			# 패스워드 암호화
			if ( $nowField == "user_pass" )
			{
				${$nowField} = Happy_Secret_Code( ${$nowField} );
			}
			$SetSql	.= " $nowField = '".trim(${$nowField})."' \n";
		}

		#echo nl2br($SetSql);



		//휴면회원 조회관련 happy_member_quies
		$REQ_VAL				= Array();
		$REQ_VAL['coinfo1']		= $_POST['coinfo1'];
		$REQ_VAL['cl']			= $_POST['cl'];

		$REQ_VAL['user_phone']	= preg_replace("/\D/", "",$_POST['user_phone']);
		$REQ_VAL['user_hphone']	= preg_replace("/\D/", "",$_POST['user_hphone']);
		$REQ_VAL['user_email']	= $_POST['user_email'];
		$MEMBER_QUIES			= happy_member_quies_decrypt($REQ_VAL);
		$DECRYPT_VAL			= happy_member_quies_crypt('decrypt',$MEMBER_QUIES);
		if(strlen($_POST['user_phone']) > 2)
		{
			if(preg_replace('/\D/','',$DECRYPT_VAL['user_phone']) == preg_replace('/\D/','',$_POST['user_phone']))
			{
				msg("동일한 전화번호가 존재합니다");
				exit;
			}
		}
		if(strlen($_POST['user_hphone']) > 2)
		{
			if(preg_replace('/\D/','',$DECRYPT_VAL['user_hphone']) == preg_replace('/\D/','',$_POST['user_hphone']))
			{
				msg("동일한 휴대전화 번호가 존재합니다");
				exit;
			}
		}
		if($_POST['user_email'] != "")
		{
			if($DECRYPT_VAL['user_email'] == $_POST['user_email'])
			{
				msg("동일한 이메일이 존재합니다");
				exit;
			}
		}




		if ( $Group['iso_jumin'] == 'y' )
		{
			#받은 주민번호를 암호화하자.
			$joomin1_chk		= $_POST['user_jumin1'];
			$joomin2_chk		= $_POST['user_jumin2'];


			#기존에 등록된 주민번호인지 확인.
			$Sql	= "select * from $happy_member where user_jumin1 = '$joomin1_chk' AND user_jumin2 = '$joomin2_chk' ";
			$MEM	= happy_mysql_fetch_array(query($Sql));

			$Sql	= "select * from $happy_member_quies where user_jumin1 = '$joomin1_chk' AND user_jumin2 = '$joomin2_chk' ";
			$MEM2	= happy_mysql_fetch_array(query($Sql));

			if ($MEM['number'] != "" || $MEM2['number'] != "")
			{
				error('이미 가입된 주민번호입니다. 다시 시도해주세요. ');
				exit;
			}

		}

		if ( $Group['iso_hphone'] == 'y' )
		{
			$user_hphone_chk	= str_replace('-','',$_POST['user_hphone']);
			#기존에 등록된 휴대폰번호인지 확인.
			$Sql	= "select * from $happy_member where replace(user_hphone,'-','') = '$user_hphone_chk' ";
			$MEM	= happy_mysql_fetch_array(query($Sql));

			$Sql	= "select * from $happy_member_quies where replace(user_hphone,'-','') = '$user_hphone_chk' ";
			$MEM2	= happy_mysql_fetch_array(query($Sql));

			if ($MEM['number'] != "" || $MEM2['number'] != "")
			{
				error('이미 사용된 휴대폰번호 입니다. 다시 시도해주세요. ');
				exit;
			}
		}

		if ( $Group['iso_email'] == 'y' )
		{
			if($_POST['user_email'] != '')
			{
				$user_email_chk		= $_POST['user_email'];
			}
			else
			{
				$user_email_chk		= $_POST['user_email_at_user']."@".$_POST['user_email_at_host'];
			}

			#기존에 등록된 이메일주소인지 확인.
			$Sql	= "select * from $happy_member where user_email = '$user_email_chk' ";
			$MEM	= happy_mysql_fetch_array(query($Sql));

			$Sql	= "select * from $happy_member_quies where user_email = '$user_email_chk' ";
			$MEM2	= happy_mysql_fetch_array(query($Sql));

			if ($MEM['number'] != "" || $MEM2['number'] != "")
			{
				error('이미 사용된 이메일주소 입니다. 다시 시도해주세요. ');
				exit;
			}
		}


		# 핸드폰 인증번호 다시 체크
		$iso_hphone	= 'n';
		if ( $Group['iso_hphone'] == 'y' )
		{
			$per_cell		= preg_replace('/\D/', '', $_POST['user_hphone']);
			$confirm_code	= preg_replace('/\D/', '', $_POST['user_hphone_check']);

			$sql		= "SELECT * FROM  $happy_member_sms_confirm WHERE phone_number ='$per_cell' ";
			$result		= query($sql);
			$CHECK		= happy_mysql_fetch_array($result);


			#echo "$CHECK[confirm_code] != $confirm_code";exit;

			if ( ( $CHECK['confirm_code'] != $confirm_code ) || $confirm_code == '' )
			{
				//error('휴대폰 인증에 실패하였습니다.');
				msg('휴대폰 인증에 실패하였습니다.');
				exit;
			}
			$iso_hphone	= 'y';
		}




		$CheckSql	= "SELECT Count(*) FROM $happy_member WHERE user_id='$user_id' ";
		$Tmp		= happy_mysql_fetch_array(query($CheckSql));

		if ( $Tmp[0] > 0 )
		{
			#echo "이미 가입된 아이디";
			error("이미 가입된 아이디가 존재합니다.");
			exit;
		}


		#SMS발송 2009-09-16 kad sms수신동의한 사람만
		if ( $_POST['sms_forwarding'][0] == 'y' )
		{
			if ( $HAPPY_CONFIG['SmsMemberRegistUse'] == "1" || $HAPPY_CONFIG['SmsMemberRegistUse'] == "kakao" )
			{
				#sms_convert($sms_text,$per_name='',$or_no='',$stats='',$per_pass='',$per_cell='',$product_name='',$etc='',$confirm_number='',$per_id = '')
				#문자보낼문자열,이름,주문번호,상태,비밀번호,휴대폰번호,상품명,기타,인증번호,아이디
				$SMSMSG["SmsMemberRegist"] = sms_convert($HAPPY_CONFIG["SmsMemberRegist"],$_POST['user_name'],'','','',$_POST['user_hphone'],'','','',$_POST['user_id']);
				#사용법 echo sms_send(전송후반응타입,받을사람전번,회신전번,전송후이동주소,sms메세지,암호화여부(on/off));
				//echo $regist_send = sms_send(0,$_POST['user_hphone'],$site_phone,"",$SMSMSG["SmsMemberRegist"],"1000","","",$HAPPY_CONFIG['SmsMemberRegistUse'],$HAPPY_CONFIG['SmsMemberRegist_ktplcode']);
				$dataStr = send_sms_msg($sms_userid,$_POST['user_hphone'],$site_phone,$SMSMSG["SmsMemberRegist"],5,$sms_testing,'',$HAPPY_CONFIG['SmsMemberRegistUse'],$HAPPY_CONFIG['SmsMemberRegist_ktplcode']);
				send_sms_socket($dataStr);
				#gomsg("아이디를 SMS문자로 발송했습니다.","index.php");
			}
		}
		#SMS발송 2009-09-16 kad


		#가입자에게 쪽지보내기 2009-09-17 kad
		if ( $HAPPY_CONFIG['MessageMemberRegistUse'] == "1" )
		{
			$HAPPY_CONFIG['MessageMemberRegist'] = str_replace("{{아이디}}",$_POST['user_id'],$HAPPY_CONFIG['MessageMemberRegist']);
			$HAPPY_CONFIG['MessageMemberRegist'] = str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['MessageMemberRegist']);

			$HAPPY_CONFIG['MessageMemberRegist'] = addslashes($HAPPY_CONFIG['MessageMemberRegist']);

			$sql = "INSERT INTO ";
			$sql.= $message_tb." ";
			$sql.= "SET ";
			$sql.= "sender_id = '".$admin_id."', ";
			$sql.= "sender_name = '관리자', ";
			$sql.= "sender_admin = 'y', ";
			$sql.= "receive_id = '".$_POST['user_id']."', ";
			$sql.= "receive_name = '".$_POST['user_name']."', ";
			$sql.= "message = '".$HAPPY_CONFIG['MessageMemberRegist']."', ";
			$sql.= "regdate = now() ";
			query($sql);
		}
		#가입자에게 쪽지보내기 2009-09-17 kad


		//아이핀추가 hun		START
		if($happy_member_kcb_namecheck_use == '1' )
		{
			if( $HAPPY_CONFIG['kcb_check_type'] == "ipin" )
			{
				if( $_POST['coinfo1'] == '' )
				{
					error("아이핀 인증에 문제가 있거나 아이핀인증을 받지 않았습니다.");
					exit;
				}
			}
			else if( $HAPPY_CONFIG['kcb_check_type'] == "hp" )
			{
				if( $_POST['cl'] == '' )
				{
					error("휴대폰 본인인증에 문제가 있거나 휴대폰본인인증을 받지 않았습니다.");
					exit;
				}
			}
			else if( $HAPPY_CONFIG['kcb_check_type'] == "ipin_hp" )
			{
				if( $_POST['cl'] == '' && $_POST['coinfo1'] == '' )
				{
					error("본인인증 수단에 문제가 있거나 본인인증을 받지 않았습니다.");
					exit;
				}
			}
		}

		$ipin_sql		= ",coinfo1		= '$_POST[coinfo1]'";
		$ipin_sql		.= ",duinfo		= '$_POST[duinfo]'";
		$ipin_sql		.= ",cl			= '$_POST[cl]'";


		$Sql	= "
					INSERT INTO
							$happy_member
					SET
							$SetSql ,
							iso_hphone	= '$iso_hphone',
							iso_email	= '$iso_email',
							`group`		= '$group',
							`level`		= '$Group[group_default_level]',
							reg_date	= now(),
							login_date	= now()
							$ipin_sql

		";
		query($Sql);





		// 추천인설정 ralear (기능 수정함 - 13.01.15 hong) - 16.10.17 x2chi 이전
		if ( $HAPPY_CONFIG['recommend_use'] == "y" && $_POST['recommend'] != "" && $_SESSION[$recommend_get_id] )
		{
			$Sql	= "SELECT COUNT(*) FROM $happy_member WHERE user_id = '$_POST[recommend]'";
			$Result	= query($Sql);
			$Tmp	= happy_mysql_fetch_array($Result);

			if ( $Tmp[0] > 0 )
			{
				#추천한 사람 포인트 적립
				$Sql	= "
							UPDATE
									$happy_member
							SET
									point	= point + $HAPPY_CONFIG[recommend_point]
							WHERE
									user_id	= '$_POST[recommend]'
				";
				query($Sql);

				#추천받은 사람 포인트 적립
				$Sql	= "
							UPDATE
									$happy_member
							SET
									point	= point + $HAPPY_CONFIG[recommend_join_point]
							WHERE
									user_id	= '$_POST[user_id]'
				";
				query($Sql);

				$Sql	= "
							INSERT INTO
									$recommend_join
							SET
									join_id			= '$_POST[user_id]',
									recommend_id	= '$_POST[recommend]',
									ip				= '$_SERVER[REMOTE_ADDR]',
									reg_date		= now()
				";
				query($Sql);

				#추천한 사람 포인트장부 입력
				$or_no_reco	= $_POST['recommend']."-".happy_mktime();

				$Sql	= "
							INSERT INTO
									$point_jangboo
							SET
									id			= '$_POST[recommend]',
									point		= '$HAPPY_CONFIG[recommend_point]',
									pay_type	= '추천인 적립',
									in_check	= '1',
									or_no		= '$or_no_reco',
									reg_date	= now()
				";
				query($Sql);

				#추천받은 사람 포인트장부 입력
				$or_no_join	= $_POST['user_id']."-".happy_mktime();

				$Sql	= "
							INSERT INTO
									$point_jangboo
							SET
									id			= '$_POST[user_id]',
									point		= '$HAPPY_CONFIG[recommend_join_point]',
									pay_type	= '추천가입 적립',
									in_check	= '1',
									or_no		= '$or_no_join',
									reg_date	= now()
				";
				query($Sql);
			}
		}


		##### 회원가입후 포인트 지급 ralear #####  - 16.10.17 x2chi 이전

		if ( $HAPPY_CONFIG['join_point_use'] == "y" )
		{
			#포인트 적립
			$Sql	= "
						UPDATE
								$happy_member
						SET
								point	= point + $HAPPY_CONFIG[join_point]
						WHERE
								user_id	= '$_POST[user_id]'
			";
			query($Sql);

			#포인트장부 입력
			$or_no_reco	= "join_point-".happy_mktime();

			$Sql	= "
						INSERT INTO
								$point_jangboo
						SET
								id			= '$_POST[user_id]',
								point		= '$HAPPY_CONFIG[join_point]',
								pay_type	= '회원가입 적립',
								in_check	= '1',
								or_no		= '$or_no_reco',
								reg_date	= now()
			";
			query($Sql);
		}

		##### 회원가입후 포인트 지급 ralear #####



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
								user_id	= '$user_id'
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
								user_id	= '$user_id'
			";
			query($Sql);
		}
		//인접매물 2010-10-12 kad


		happy_member_nick_history_change( $_POST['user_id'], $_POST['user_nick'], 'execute' );

		$_POST['state_open']	= @implode(',', (array) $_POST['state_open']);
		happy_member_state_open_change( $_POST['user_id'], $_POST['state_open'], 'execute' );



		//구인구직 전용필드
		//성인인증여부
		//실명인증을 사용하면
		if ( $HAPPY_CONFIG['kcb_namecheck_use'] == "1" && $HAPPY_CONFIG['kcb_adultcheck_use'] == "1" )
		{
			if ( $_COOKIE['adult_check'] == "OK" && strlen($_COOKIE['job_adultcheck']) == 6 )
			{
				happy_member_option_set('adultjob',$_POST['user_id'],'is_adult',1,'int(11)');
			}
		}
		//실명인증 사용안하면 성인인증은 안된상태로 회원가입
		else
		{
			happy_member_option_set('adultjob',$_POST['user_id'],'is_adult',0,'int(11)');
		}
		//성인인증여부

		//구인정보(채용) 기간별 보기
		happy_member_option_set('adultjob',$_POST['user_id'],'guzic_view',0,'int(11)');
		//구인정보(채용) 회수별 보기
		happy_member_option_set('adultjob',$_POST['user_id'],'guzic_view2',0,'int(11)');
		//구직정보(이력서) 기간별 보기
		happy_member_option_set('adultjob',$_POST['user_id'],'guin_docview',0,'int(11)');
		//구직정보(이력서) 회수별 보기
		happy_member_option_set('adultjob',$_POST['user_id'],'guin_docview2',0,'int(11)');
		//SMS발송포인트
		happy_member_option_set('adultjob',$_POST['user_id'],'guin_smspoint',0,'int(11)');
		happy_member_option_set('adultjob',$_POST['user_id'],'guzic_smspoint',0,'int(11)');



		//채용정보 점프
		if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
		{
			happy_member_option_set('adultjob',$_POST['user_id'],'guin_jump',0,'int(11)');
		}
		//채용정보 점프



		// 회원가입 그룹별 메일 발송 - x2chi
		$mailChk		= '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/';
		$check_email	= preg_match( $mailChk , trim($_POST['user_email']) );
		if( $_POST['email_forwarding'][0] == 'y' && $Group['reg_email_use'] == 'y' && strlen($Group['reg_email']) > 10 && $check_email == true )
		{
			$reg_mail_send_name		= $site_name;
			$reg_mail_send_mail		= $admin_email;
			$reg_mail_user_mail		= $_POST['user_email'];

			$reg_mail_subject		= stripslashes($Group['reg_email_subject']);
			$reg_mail_subject		= str_replace("{{site_name}}",		$site_name,						$reg_mail_subject);
			$reg_mail_subject		= str_replace("{{user_name}}",		$_POST['user_name'],			$reg_mail_subject);
			$reg_mail_subject		= str_replace("{{user_id}}",		$_POST['user_id'],				$reg_mail_subject);

			$reg_mail_cont			= stripslashes($Group['reg_email']);
			$reg_mail_cont			= str_replace("{{site_name}}",		$site_name,						$reg_mail_cont);
			$reg_mail_cont			= str_replace("{{user_name}}",		$_POST['user_name'],			$reg_mail_cont);
			$reg_mail_cont			= str_replace("{{user_id}}",		$_POST['user_id'],				$reg_mail_cont);
			$reg_mail_cont			= str_replace("{{user_pass}}",		$_POST['user_pass'],			$reg_mail_cont);
			$reg_mail_cont			= str_replace("{{user_phone}}",		$_POST['user_phone'],			$reg_mail_cont);
			$reg_mail_cont			= str_replace("{{user_hphone}}",	$_POST['user_hphone'],			$reg_mail_cont);
			$reg_mail_cont			= str_replace("{{now_year}}",		date("Y"),						$reg_mail_cont);
			$reg_mail_cont			= str_replace("{{main_url}}",		$main_url,						$reg_mail_cont);
			$reg_mail_cont			= str_replace($wys_url."/wys2/",	$main_url.$wys_url."/wys2/",	$reg_mail_cont);
			$reg_mail_cont			= str_replace("/img/mail/",			$main_url."/img/mail/",			$reg_mail_cont);

			HappyMail($reg_mail_send_name, $reg_mail_send_mail, $reg_mail_user_mail, $reg_mail_subject, $reg_mail_cont);
		}


		#echo "<pre>"; print_r($_POST); echo "</pre>";exit;
		gomsg("가입되었습니다.", "/");
		exit;
	}






	function modify_reg()
	{
		global $happy_member, $happy_member_field, $happy_member_group, $happy_member_level, $member_auto_addslashe;
		global $happy_member_path, $happy_member_upload_folder, $happy_member_upload_path;
		global $happy_member_image_width, $happy_member_image_height, $happy_member_image_quality, $happy_member_image_position, $happy_member_image_logo, $happy_member_image_logo_position, $happy_member_image_type;
		global $happy_member_image_width2, $happy_member_image_height2, $happy_member_image_quality2, $happy_member_image_position2, $happy_member_image_logo2, $happy_member_image_logo_position2, $happy_member_image_type2;
		global $happy_member_sms_confirm;
		global $member_group;
		//이미지 생성
		global $PerPhotoDstW,$PerPhotoDstH,$PerPhotoCreateType;
		global $ComLogoDstW,$ComLogoDstH,$ComPhotoCreateType1;
		global $ComBannerDstW,$ComBannerDstH,$ComPhotoCreateType2;
		global $happy_member_login_value_name,$happy_member_login_value_url;
		global $happy_member_quies, $sms_userid;




		if (!is_dir("$happy_member_upload_folder")){
			error("첨부파일을 위한 ($happy_member_upload_folder)폴더가 존재하지 않습니다.  ");
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


		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error('로그인후 이용가능 합니다.');
			exit;
		}


		$user_nick	= $_POST['user_nick'];


		$Member			= happy_member_information($happy_member_login_id);

		$member_group	= $Member['group'];


		# 닉네임 사용 여부 체크 #
		$Sql		= "SELECT Count(*) FROM $happy_member_field WHERE field_name='user_nick' AND member_group='$member_group' AND field_use='Y' ";
		list($Tmp)	= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp > 0 )
		{
			$Sql		= "SELECT Count(*) FROM $happy_member WHERE user_nick = '$user_nick' AND user_id != '$happy_member_login_id' ";
			list($Chk)	= happy_mysql_fetch_array(query($Sql));

			$Sql		= "SELECT Count(*) FROM $happy_member_quies WHERE user_nick = '$user_nick' AND user_id != '$happy_member_login_id' ";
			list($Chk2)	= happy_mysql_fetch_array(query($Sql));

			if ( $Chk > 0 || $Chk2 > 0 )
			{
				error('동일한 닉네임이 존재합니다.');
				exit;
			}
		}

		$nick_check		= happy_member_nick_history_change( $happy_member_login_id, $Member['user_nick'] );		# 닉네임 수정이 가능한지 체크 #
		$state_check	= happy_member_state_open_change( $happy_member_login_id, $Member['state_open'] );		# 정보공개 수정이 가능한지 체크 #

		if ( $Member['user_nick'] != $_POST['user_nick'] && $_POST['user_nick'] != '' && $nick_check === true )
		{
			happy_member_nick_history_change( $happy_member_login_id, $_POST['user_nick'], 'execute' );
		}

		if ( $Member['state_open'] != $_POST['state_open'] && $state_check === true )
		{
			$_POST['state_open']	= implode(',', (array) $_POST['state_open']);
			happy_member_state_open_change( $happy_member_login_id, $_POST['state_open'], 'execute' );
		}


		$login_count		= 0;
		$group				= $member_group;

		$_POST['user_jumin2']		= Happy_Secret_Code($_POST['user_jumin2']);


		#그룹명으로 가입가능한 그룹인지 한번더 체크
		$Sql	= "SELECT * FROM $happy_member_group WHERE number='$group'";
		$Group	= happy_mysql_fetch_array(query($Sql));


		if ( $Group['iso_email'] == 'y' )
		{
			if($_POST['user_email'] != '')
			{
				$user_email_chk		= $_POST['user_email'];
			}
			else
			{
				$user_email_chk		= $_POST['user_email_at_user']."@".$_POST['user_email_at_host'];
			}

			$id_q = "";
			if ( $happy_member_login_id != "" )
			{
				$id_q = " and user_id <> '".$happy_member_login_id."' ";
			}

			$sql	= "select * from $happy_member where  user_email='$user_email_chk'  $id_q ";
			$result	= query($sql);
			$pid	= mysql_fetch_row($result);

			if( $pid[0] )
			{
				error("사용중인 이메일입니다.");
				exit;
			}
		}


		# 핸드폰 인증번호 다시 체크
		$iso_hphone	= '';
		$_POST['user_hphone'] = $_POST['user_hphone_tel_first']."-".$_POST['user_hphone_tel_second']."-".$_POST['user_hphone_tel_third']; //버그수정 - 2020-06-04 hong
		if (  $_POST['user_hphone_check'] != '' && $_POST['user_hphone_original'] == $_POST['user_hphone'] )
		{
			$per_cell		= preg_replace('/\D/', '', $_POST['user_hphone']);
			$confirm_code	= preg_replace('/\D/', '', $_POST['user_hphone_check']);

			$sql		= "SELECT * FROM  $happy_member_sms_confirm WHERE phone_number ='$per_cell' ";
			$result		= query($sql);
			$CHECK		= happy_mysql_fetch_array($result);

			#echo "$CHECK[confirm_code] != $confirm_code";exit;

			if ( $CHECK['confirm_code'] != $confirm_code  && $_POST[iso_hphone] != 'y')
			{
				error('휴대폰 인증에 실패하였습니다.');
				exit;
			}
			$iso_hphone	= " , iso_hphone = 'y' ";
		}
		else if (  $_POST['user_hphone_check'] != '' && $_POST['user_hphone_original'] != $_POST['user_hphone'] )
		{
			$iso_hphone	= " , iso_hphone = 'n' ";
		}
		else if (  $_POST['user_hphone_check'] == '' && $Member['user_hphone'] != $_POST['user_hphone'] )
		{
			$iso_hphone	= " , iso_hphone = 'n' ";
		}


		$WHERE	= " AND field_modify = 'y' ";
		$WHERE	.= " AND field_name != '' ";
		$WHERE	.= " AND field_name != 'user_pass' ";
		$WHERE	.= " AND field_name != 'user_pass2' ";
		$WHERE	.= " AND field_name != 'user_nick' ";
		$WHERE	.= " AND field_name != 'state_open' ";

		$Sql	= "SELECT * FROM $happy_member_field WHERE member_group = '$group' $WHERE ";
		$Record	= query($Sql);

		$Cnt	= 0;
		$SetSql	= '';
		while ( $Form = happy_mysql_fetch_array($Record) )
		{
			$Fields		= call_happy_member_field($Form['field_name']);
			#echo "<pre>";			print_r($Fields);			echo "</pre>";
			#echo "$".$Fields['Field'] ."  = ". $_POST[$Fields['Field']]."<hr>";

			$nowField	= $Fields['Field'];

			if ( $nowField == '' )
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

				if ( $_FILES[$nowField]["name"] != "" )
				{
					//echo $nowField."<br>";
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
						$addMessage	= $Form['field_title'] . " : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $Form[field_option] 입니다.";
						#echo $addMessage;
						msg($addMessage);
						exit;
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


						} #copy 완료마지막
					}

					if ( ${$nowField} == '' )
					{
						continue;
					}
				}
				else if ( $_POST[$nowField."_del"] != 'ok' )
				{
					continue;
				}
			}

			if ( is_array(${$nowField}) )
			{
				${$nowField}	= @implode(",", (array) ${$nowField});
			}


			if ( $Form['field_sureInput'] == 'y' && $Form['field_modify'] == 'y' && ${$nowField} == '' )
			{
				echo $Form['field_name'] ." 필드의 값이 넘어오지 않았습니다.";
				#error( $Form['field_name'] ." 필드의 값이 넘어오지 않았습니다. ");
				#exit;
			}

			$SetSql	.= ( $SetSql == '' )? '' : ', ';
			$SetSql	.= " $nowField = '".trim(${$nowField})."' \n";
		}


		if ( $_POST['user_pass'] != '' && $_POST['user_pass2'] != '' && $_POST['user_pass'] == $_POST['user_pass2'] )
		{
			$SetSql	.= ( $SetSql == '' )? '' : ', ';

			$_POST['user_pass'] = Happy_Secret_Code( $_POST['user_pass'] );
			$SetSql	.= " user_pass = '".$_POST['user_pass']."' \n";
		}



		$Sql	= "
					UPDATE
							$happy_member
					SET
							mod_date = now(),
							$SetSql
							$iso_hphone
					WHERE
							user_id	= '$happy_member_login_id'
		";
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
								user_id	= '$happy_member_login_id'
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
								user_id	= '$happy_member_login_id'
			";
			query($Sql);
		}
		//인접매물 2010-10-12 kad



		//이메일 변경시 처리 - ranksa
		if ($Member['user_email'] != $_POST['user_email'])
		{
			$Sql		= "UPDATE $happy_member SET iso_email = 'n' WHERE user_id = '$happy_member_login_id' ";
			query($Sql);

			setcookie($happy_member_login_value_name, '', 0, "/", $happy_member_login_value_url);
			gomsg('수정이 완료되었습니다.','/');
		}
		//이메일 변경시 처리 - ranksa 끝
		else
		{
			#echo "<pre>"; print_r($_POST); echo "</pre>";exit;
			gomsg('수정이 완료되었습니다.','happy_member.php?mode=modify');
		}
		exit;
	}









#######################################################################################################################

	if ( !is_file($Template) )
	{
		$Template	= "$happy_member_skin_folder/happy_member_joinus.html";
	}


	$TPL->define("메인내용", $Template);
	$content = &$TPL->fetch();


	$내용	= $content;


	$Template_Default	= $Template_Default == '' ? $happy_member_mypage_default_file : $Template_Default;



	if( !(is_file("$happy_member_skin_folder/$Template_Default")) ) {
		$content = "껍데기 $happy_member_skin_folder/$Template_Default 파일이 존재하지 않습니다. <br>";
		return;
	}

	//echo "$happy_member_skin_folder/$Template_Default";
	$TPL->define("껍데기", "$happy_member_skin_folder/$Template_Default");
	$content = &$TPL->fetch();


	echo $content;


	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}


?>