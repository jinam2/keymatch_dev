<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	//print_r2($_POST);

	if(!session_id()) session_start();
	$folder_name = "./upload/tmp/".session_id();

	if ( happy_member_login_check() == "" && $_COOKIE['ad_id'] == "" )
	//if ( happy_member_login_check() == "" )
	{
		//gomsg("로그인 후 이용하세요","./happy_member_login.php");
		go("./happy_member_login.php");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[0].'등록') && !$_COOKIE["ad_id"] )
	{
		error($happy_member_secure_text[0].'등록'." 권한이 없습니다.");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[0].'등록') && $_GET["mode"] == "add" && !$_COOKIE["ad_id"] )
	{
		error($happy_member_secure_text[0].'등록'." 권한이 없습니다.");
		exit;
	}

	$mode		= $_GET["mode"];
	$subMode	= $_GET["subMode"];
	$returnUrl	= $_GET["returnUrl"];

	if ( $returnUrl == "" )
		$returnUrl = $_POST["returnUrl"];

	/*
	#리턴url에서 필요없는것 잘라내기
	$returnUrl	= preg_replace("/(\?.*?\?\?)/",'?',$returnUrl);
	*/
	$returnUrl	= str_replace("??",'&',$returnUrl);

	#### subMode
	# type1	= 기본정보 및 디자인 템플릿
	# type2	= 근무희망지역,업직종
	# type3	= 키워드
	# type4	= 학력
	# type5	= 경력
	# type6	= 첨부파일
	# type7	= 보유자격증 및 기술
	$number		= ( $_POST["number"] == "" )?$_GET["number"]:$_POST["number"];

	if ( $_COOKIE["ad_id"] != "" && $mode != 'add' && $mode != 'addAction' )
	{
		$Sql	= "SELECT user_id FROM $per_document_tb WHERE number='$number'";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		$a		= explode(",",$Tmp[0]);
		$userid	= $Tmp[0];
	}
	else
	{
		$userid = happy_member_login_check();
	}

	$user_id	= $userid;

	if ( $mode == "" || $mode == "list" )					# 이력서 관리 초기화면 (이력서리스트/신규/수정/삭제/보기)
	{
	}
	else if ( $mode == "add" || $mode == "modify" )			# 이력서 신규등록 , 수정
	{
		if ($mode == "add" && $_GET['number'] != '')
		{
			error("잘못된 경로로 접근하셨습니다.");exit;
		}

		$mod_dis = '';
		if ( $_GET['number'] != '' )
		{
			$mod_dis = 'none;';
		}

		$upload_folder				= "upload/tmp/";
		$E​xception_Array			= Array("happy","inc","upload");			//예외처리할 폴더명을 배열로 설정하세요.
		$clear_files_ext			= Array("jpg","jpeg","gif","png");
		$clear_limit_time			= 60 * 60 * 24;		//1일

		happy_tmp_clear( $upload_folder, $clear_limit_time, $clear_files_ext, $E​xception_Array );


		//쓰레기 임시 파일 삭제하기 //
		if(is_dir($folder_name)) {
			$dir_obj=opendir($folder_name);
			while(($file_str = readdir($dir_obj))!==false){
				if($file_str!="." && $file_str!=".."){
					@unlink($folder_name."/".$file_str);
				}
			}
			closedir($dir_obj);
			rmdir($folder_name);
		}

		$number1	= "0";
		$number2	= "0";
		$number3	= "0";
		$number4	= "0";
		$number5	= "0";
		$number6	= "0";
		$number7	= "0";

		$mode_title		= "작성";

		//모바일에서 등록한 이력서 체크
		if ( $mode == "modify" && $_GET["number"] != "" )
		{
			$Sql	= "SELECT * FROM $per_document_tb WHERE number='$_GET[number]'";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			/*
			if( $_COOKIE['happy_mobile'] == 'on' && $Tmp['regist_mobile'] == 'n' )
			{
				error("PC에서 등록한 정보는 모바일에서 수정 할 수 없습니다.");exit;
			}
			*/
		}


		//수정시 등록한 이력서일때만 수정이 되도록
		if ( $mode == "modify" && $_COOKIE["ad_id"] == "" ) {

			$sql = "select count(*) as cnt from $per_document_tb where number = '$_GET[number]' and user_id = '$user_id'";
			$result = query($sql);
			$CHK = happy_mysql_fetch_assoc($result);

			if ($CHK[cnt] != 1) {
				error("자신이 등록한 프로필만 수정이 가능합니다");
				exit;
			}

			$mode_title		= "수정";
		}
		//수정시 등록한 이력서일때만 수정이 되도록

		$현재모드	= ( $number == "" )?"정보등록":"정보수정";


		if ( $subMode == "" && $mode == "add" )				# 이력서 신규등록
		{
			$subMode	= "type1";
		}

		//$subMode = "all";	#심플버젼일때 주석 해제
		//이력서 등록방식에 따라서 분기 2010-12-09 kad
		if ( $document_reg_type == "simple" )
		{
			$subMode = "all";
		}



		if ( $subMode == "type1" )							# 기본정보 및 디자인 템플릿 설정
		{
			write_type1();
			$template	= "job_per_doc_type1.html";

			#관리자모드에서 등록할 경우 Hun 2010-09-14
			if($_GET[history] == "admin" && $_COOKIE[ad_id])
				$template	= "job_admin_doc_type1.html";
			else
				$template	= "job_per_doc_type1.html";


			$number1	= "1";
			$Color1		= "<font color='$per_doc_top_color'>";
			$imgCheck1	= "_on";
			$현재위치	= " $prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='document.php?mode=$_GET[mode]&number=$number&subMode=$subMode'>구직$현재모드</a> > 기본정보";

		}
		else if ( $subMode == "type2" )						# 근무희망지역,업직종
		{
			if ( $number == "" )
				error("프로필의 기본정보를 작성해주세요.");
			write_type2();
			$template	= "job_per_doc_type2.html";
			$number2	= "1";
			$Color2		= "<font color='$per_doc_top_color'>";
			$imgCheck2	= "_on";
			$현재위치	= " $prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='document.php?mode=$_GET[mode]&number=$number&subMode=$subMode'>구직$현재모드</a> > 개인부가정보";
		}
		else if ( $subMode == "type3" )						# 키워드
		{
			if ( $number == "" )
				error("프로필의 기본정보를 작성해주세요.");
			write_type3();
			$template	= "job_per_doc_type3.html";
			$number3	= "1";
			$Color3		= "<font color='$per_doc_top_color'>";
			$imgCheck3	= "_on";
			$현재위치	= " $prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='document.php?mode=$_GET[mode]&number=$number&subMode=$subMode'>구직$현재모드</a> > 키워드";
		}
		else if ( $subMode == "type4" )						# 학력
		{
			write_type4();
			$template	= "job_per_doc_type4.html";
			$number4	= "1";
			$Color4		= "<font color='$per_doc_top_color'>";
			$imgCheck4	= "_on";
			$현재위치	= " $prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='document.php?mode=$_GET[mode]&number=$number&subMode=$subMode'>구직$현재모드</a> > 취업희망/학력정보";
		}
		else if ( $subMode == "type5" )						# 경력
		{
			write_type5();
			$template	= "job_per_doc_type5.html";
			$number5	= "1";
			$Color5		= "<font color='$per_doc_top_color'>";
			$imgCheck5	= "_on";
			$현재위치	= " $prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='document.php?mode=$_GET[mode]&number=$number&subMode=$subMode'>구직$현재모드</a> > 경력정보";
		}
		else if ( $subMode == "type6" )						# 첨부파일
		{
			write_type6();
			$template	= "job_per_doc_type6.html";
			$number6	= "1";
			$Color6		= "<font color='$per_doc_top_color'>";
			$imgCheck6	= "_on";
			$현재위치	= " $prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='document.php?mode=$_GET[mode]&number=$number&subMode=$subMode'>구직$현재모드</a> > 첨부파일";
		}
		else if ( $subMode == "type7" )						# 보유자격증 및 기술
		{
			write_type7();
			$template	= "job_per_doc_type7.html";
			$number7	= "1";
			$Color7		= "<font color='$per_doc_top_color'>";
			$imgCheck7	= "_on";
			$현재위치	= " $prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='document.php?mode=$_GET[mode]&number=$number&subMode=$subMode'>구직$현재모드</a> > OA능력 및 보유기술";
		}
		else if ( $subMode == "all" )						#type1~7까지 전체 수정
		{

			$mode2		= $mode. "Action";
			write_type1();							//QA 능력
			write_type2();
			write_type3();							//이력서 키워드 입력
			write_type4();							//학력사항
			write_type5();							//경력사항
			write_type6();							//미니앨범
			write_type7();							//선택사항 여러항목

			$frm = 'document_frm';
			uryo();

			//$CONF['paid_conf'] = 0;
			if ( $CONF['paid_conf'] && $_GET['number'] == "" )
			{
				if ( happy_member_secure($happy_member_secure_text[0].'유료결제') )
				{
					$등록버튼 = $PAY['bank']." ".$PAY['card']." ".$PAY['phone']." ".$PAY['bank_soodong']." ".$PAY['point'];

					$PAY['loading_script'] = '<script>figure();</script>';

					$TPL->define("결제폼", "./$skin_folder/guzic_pay.html");
					$TPL->assign("결제폼");
					$이력서결제페이지 = &$TPL->fetch();
				}
				else
				{
					$mod_dis = "none";

					if( $_COOKIE['happy_mobile'] == 'on' )
					{
						$등록버튼 = '<input type="submit" value="등록하기">';
					}
					else
					{
						$등록버튼 = '<input type="image" src="img/btn_noadd.gif" border="0" align="absmiddle" style="cursor:pointer;">';
					}
				}
			}
			else
			{
				if( $_COOKIE['happy_mobile'] == 'on' )
				{
					$등록버튼 = '<input type="submit" value="수정하기">';
				}
				else
				{
					$등록버튼 = '<input type="image" src="img/skin_icon/make_icon/skin_icon_701.jpg" border="0" align="absmiddle" style="cursor:pointer">';
				}
			}

			$mode		= $mode2;

			#관리자모드에서 등록할 경우 Hun 2010-09-14
			if($_GET[history] == "admin" && $_COOKIE[ad_id])
				$template	= "job_admin_doc_type_all.html";
			else
				$template	= "job_per_doc_type_all.html";

			$number1	= "1";
			$Color1		= "<font color='$per_doc_top_color'>";
			$imgCheck1	= "_on";
			$현재위치	= " $prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='document.php?mode=$_GET[mode]&number=$number&subMode=$subMode'>구직$현재모드</a> > 이력서작성";
		}
	}
	else if ( $mode == "addAction" || $mode == "modifyAction" )
	{
		if ( $_POST['gou_number'] != '' )
		{
			$sql = "select count(*) from ".$jangboo2." where or_no = '".$_POST['gou_number']."'";
			$result = query($sql);
			list($jcnt) = happy_mysql_fetch_array($result);

			if ( $jcnt >= 1 )
			{
				msg("이미 등록된 구직정보가 있으며, 결제시도내역이 있습니다. \\n구직정보를 수정하시거나, 유료옵션을 재결제 하셔야만 합니다.");
				echo "<script>
				if ( opener )
				{
					opener.location = 'happy_member.php?mode=mypage';
					self.close();
				}
				</script>";
				exit;
			}
			else
			{
				dbAction();
			}
		}
		else
		{
			dbAction();
		}
		exit;
	}
	else if ( $mode == "delete" )
	{
	}
	else if ( $mode == "uryo" )
	{
		$현재위치 = "$prev_stand
					<li class='loc_name'><a href='./happy_member.php?mode=mypage'>마이페이지</a></li>
					<li class='loc_name'><div class='n1'></div><div class='n2'><a href='./html_file_per.php?mode=resume_my_manage'>내 이력서관리</a></div></li>
					<li class='loc_name_end'><div class='n1'></div><div class='n2'>이력서 유료서비스 신청</div></li>
					";

		uryo();
		//$template	= "per_resume_uryo.html";
		$template	= "job_per_doc_uryo.html";
	}





	#######################################################################################################################

	function write_type1()
	{
		global $userid, $mode, $subMode, $number, $per_document_tb, $upload_folder, $happy_member, $DataType1;
		global $이미지정보, $Data, $bohunRadio, $jangaeRadio, $jangaeSelect, $armyRadio, $armySelect1, $armySelect2, $armySelect3, $armySelect4, $armyStart, $button, $user_image2, $per_document_pic;
		global $doc_skinfilename;
		global $TDayIcons,$TDayIconsTag,$TDayNames,$WeekDays,$WeekDaysText;		#근무요일
		global $TTime1,$TTime2,$TTime3;		#근무시간
		global $WorkTime1,$WorkTime2,$WorkTime3,$WorkTime4,$WorkTime5,$WorkTime6;
		global $GuzicPerson,$TGuzicPerson;	#구직자
		global $GuzicEducation,$TEducation;	#학력
		global $TNational,$GuzicNational;		#국적
		global $GuzicMarried,$TMarried;			#결혼
		global $guzicchild;							#자녀수
		global $GuzicLicence,$TLicence,$GuzicLicenceTitle;		#자격증
		global $TSiCompany,$SiCompany;				#파견업체연락
		global $tHopeSize,$희망회사규모;
		global $per_skill_tb,$per_language_tb,$per_yunsoo_tb;
		global $form_add_button_view;


		//개인회원 정보
		$Sql	= "SELECT * FROM $happy_member WHERE user_id='$userid'";
		$MEM	= happy_mysql_fetch_array(query($Sql));

		$MEM["etc1"] = $MEM['photo1'];
		$MEM["per_name"] = $MEM['user_name'];
		$MEM["per_gender"] = $MEM['user_prefix'];
		$MEM["per_phone"] = $MEM['user_phone'];
		$MEM["per_cell"] = $MEM['user_hphone'];
		$MEM["per_email"] = $MEM['user_email'];
		$MEM["per_zip"] = $MEM['user_zip'];
		$MEM["per_addr1"] = $MEM['user_addr1'];
		$MEM["per_addr2"] = $MEM['user_addr2'];
		$MEM["per_homepage"] = $MEM['user_homepage'];

		$Data["user_name"]		= $MEM["per_name"];
		$Data["user_nick"]		= $MEM["user_nick"];

		if ( $mode == "modify" || $number != "" )
		{
			$form_add_button_view = "none";

			$Sql	 = "	SELECT										";
			$Sql	.= "			number,								";
			$Sql	.= "			skin_html,							";
			$Sql	.= "			skin_date,							";
			$Sql	.= "			title,								";
			$Sql	.= "			profile,							";
			$Sql	.= "			user_id,							";
			$Sql	.= "			user_name,							";
			$Sql	.= "			user_prefix,						";
			$Sql	.= "			user_age,							";
			$Sql	.= "			user_phone,							";
			$Sql	.= "			user_hphone,						";
			$Sql	.= "			user_email1,						";
			$Sql	.= "			user_email2,						";
			$Sql	.= "			user_homepage,						";
			$Sql	.= "			user_zipcode,						";
			$Sql	.= "			user_addr1,							";
			$Sql	.= "			user_addr2,							";
			$Sql	.= "			user_image,							";
			$Sql	.= "			user_bohun,							";
			$Sql	.= "			user_jangae,						";
			$Sql	.= "			user_army,							";
			$Sql	.= "			user_army_start,					";
			$Sql	.= "			user_army_end,						";
			$Sql	.= "			user_army_type,						";
			$Sql	.= "			user_army_level,					";
			$Sql	.= "			etc1,etc2,etc3,etc4,etc5,etc6,etc7,etc8,etc9,etc10,	";
			#베이비시터 추가필드
			$Sql	.= "			start_worktime,finish_worktime,	";
			$Sql	.= "			guzicperson,	";
			$Sql	.= "			guziceducation,	";
			$Sql	.= "			guzicnational,	";
			$Sql	.= "			guzicmarried,	";
			$Sql	.= "			guzicchild,	";
			$Sql	.= "			guziclicence,	";
			$Sql	.= "			guziclicence_title,	";
			$Sql	.= "			guzicsicompany,	";

			//chi_first_name :한문성
			//chi_last_name : 한문이름
			//eng_first_name : 영문성
			//eng_last_name : 영문이름
			//HopeSize : 희망회사규모
			//alter table `job_per_document` add `chi_first_name` varchar(50) not null default '';
			//alter table `job_per_document` add `chi_last_name` varchar(50) not null default '';
			//alter table `job_per_document` add `eng_first_name` varchar(50) not null default '';
			//alter table `job_per_document` add `eng_last_name` varchar(50) not null default '';
			//alter table `job_per_document` add `HopeSize` varchar(50) not null default '';

			$Sql	.= "			chi_first_name,	";
			$Sql	.= "			chi_last_name,	";
			$Sql	.= "			eng_first_name,	";
			$Sql	.= "			eng_last_name,	";
			$Sql	.= "			HopeSize,	";
			$Sql	.= "			modifydate,	";

			//생년월일 추가
			$Sql	.= "			user_birth_year,	";
			$Sql	.= "			user_birth_month,	";
			$Sql	.= "			user_birth_day,	";

			$Sql	.= "			display								";
			$Sql	.= "	FROM										";
			$Sql	.= "			$per_document_tb					";
			$Sql	.= "	WHERE										";
			$Sql	.= "			number = '$number'					";
			$Sql	.= "			AND									";
			$Sql	.= "			user_id = '$userid'					";


			$Data	= happy_mysql_fetch_array(query($Sql));

			$Data["display"]	= ( $Data["display"] == "N" )?"checked":"";

			if ( $Data["user_prefix"] == "" )
				$Data["user_prefix"]	= $MEM["user_prefix"];

			$이미지정보 = ( str_replace(" ","",$Data["user_image"]) == "" )?"img/img_noimage_130x160_green.jpg": $Data["user_image"];

			if ( str_replace(" ","",$Data["user_image"]) == "" )
				$이미지정보	= "img/img_noimage_130x160_green.jpg";
			else if (preg_match("/http[|s]:\/\//",$MEM["photo1"]))
			{
				$이미지정보	= $MEM["photo1"];
			}
			else
			{
				$Tmp	= explode(".",$Data["user_image"]);
				if (preg_match("/jpg/i",$Tmp[sizeof($Tmp)-1])) {
					$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], "_thumb.".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
				} else {
					$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], ".".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
				}
				$이미지정보	= $Tmp2;
			}

			//나이계산
			if ($Data['user_age'] == "0")
			{
				$Data["user_birth_year"] = $MEM["user_birth_year"];
			}
			else
			{
				//생년월일 추가
				$Data["user_birth_year"]	= $Data['user_birth_year'];
			}


			list( $Data["user_army_start_year"] , $Data["user_army_start_month"] )	= explode("/",$Data["user_army_start"]);
			list( $Data["user_army_end_year"] , $Data["user_army_end_month"] )		= explode("/",$Data["user_army_end"]);

			if ( $Data["skin_html"] == "" || $Data["skin_date"] < date("Y-m-d") )
			{
				$Data["skin_html"]	= "이력서 기본스킨";
				$Data["skin_date"]	= "";
			} else {
				$Data["skin_html"] = $doc_skinfilename[$Data["skin_html"]];
			}
			$button	= "edit";

			//이력서 수정시 회원DB 이미지로 저장되도록 2013-11-18 kad
			$user_image2			= ( $MEM["photo1"] != "" )?$MEM["photo1"]:"";
			//이력서 수정시 회원DB 이미지로 저장되도록 2013-11-18 kad

		}
		else
		{


			$user_image2			= ( $MEM["photo1"] != "" )?$MEM["photo1"]:"";

			if ( str_replace(" ","",$MEM["photo1"]) == "" )
				$이미지정보	= "img/img_noimage_130x160_green.jpg";
			else if (preg_match("/http[|s]:\/\//",$MEM["photo1"]))
			{
				$이미지정보	= $MEM["photo1"];
			}
			else
			{
				$Tmp	= explode(".",$MEM["etc1"]);
				if (preg_match("/jpg/i",$Tmp[sizeof($Tmp)-1])) {
					$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], "_thumb.".$Tmp[sizeof($Tmp)-1], $MEM["photo1"]);
				} else {
					$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], ".".$Tmp[sizeof($Tmp)-1], $MEM["photo1"]);
				}

				if ( !preg_match("/http/i",$Tmp2) )
				{
					$이미지정보	= "./".$Tmp2;
				}
				else
				{
					$이미지정보 = $Tmp2;
				}


			}
			//나이계산
			if ($Data['user_age'] == "0")
			{
				$Data["user_birth_year"] = $MEM["user_birth_year"];
			}
			else
			{
				$modifydate_Arr	= explode("-",$Data['modifydate']);
				$Data["user_birth_year"]	= $modifydate_Arr[0] - $Data['user_age']+1;
			}


			$Data["user_name"]		= $MEM["per_name"];
			$Data["user_prefix"]	= $MEM["per_gender"];
			$Data["user_phone"]		= $MEM["per_phone"];
			$Data["user_hphone"]	= $MEM["per_cell"];
			$Data["user_email1"]	= $MEM["per_email"];
			$Data["user_zipcode"]	= $MEM["per_zip"];
			$Data["user_addr1"]		= $MEM["per_addr1"];
			$Data["user_addr2"]		= $MEM["per_addr2"];
			$Data["user_homepage"]	= $MEM["per_homepage"];

			$Data["skill_word1"] = "checked";
			$Data["skill_ppt1"] = "checked";
			$Data["skill_excel1"] = "checked";
			$Data["skill_search1"] = "checked";
			$Data["language_skill1"] = "checked";
			$Data["user_birth_year"]	= $MEM["user_birth_year"];

			//생년월일 추가
			$Data["user_birth_month"]	= $MEM["user_birth_month"];
			$Data["user_birth_day"]		= $MEM["user_birth_day"];


			#등록할때는 이력서 스킨이 기본이력서로 찍히도록 수정해둠
			$Data["skin_html"]	= "이력서 기본스킨";
			$button	= "write";
		}

		if ( $Data["user_prefix"] == "man" )
		{
			$Data["user_prefix"] = "남자";
		}
		else if ( $Data["user_prefix"] == "girl" )
		{
			$Data["user_prefix"] = "여자";
		}

		$checked1	= '';
		$checked2	= '';
		if ( $Data["user_bohun"] == "Y" )
		{
			$checked1	= "checked";
		}
		else
		{
			$checked2	= "checked";
		}
		$bohunRadio	= "<span class='h_form'><label for='user_bohun1' class='h-radio'><input type='radio' value='Y' name='user_bohun' $checked1 id='user_bohun1'><span class='noto400 font_14'>대상</span></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for='user_bohun2' class='h-radio'><input type='radio' value='N' name='user_bohun' $checked2 id='user_bohun2'><span class='noto400 font_14'>비대상</span></label></span>
		";

		$checked1	= '';
		$checked2	= '';
		if ( $Data["user_jangae"] == "" )
		{
			$checked1		= "checked";
			$jangaeDisabled	= "disabled";
		}
		else
		{
			$checked2		= "checked";
			$jangaeDisabled	= "";
		}

		$jangaeRadio	= "
			<span class='h_form'>
				<label for='jangaeRadio1' class='h-radio'><input type='radio' value='Y' name='user_jangae_chk' onClick='document.document_frm.user_jangae.disabled=false' $checked2 id='jangaeRadio1'><span class='noto400 font_14'>장애</span></label>

				&nbsp;&nbsp;

				<label for='jangaeRadio2' class='h-radio'><input type='radio' value='Y' name='user_jangae_chk' onClick=\"document.document_frm.user_jangae.disabled=true;document.document_frm.user_jangae.value=''\" $checked1 id='jangaeRadio2'><span class='noto400 font_14'>비장애</span></label>
			</span>
		";

		$jangaeSelect	= dateSelectBox( "user_jangae", 1, 6, $Data["user_jangae"], "", "선택", $jangaeDisabled , 1);

		switch ( $Data["user_army"] )
		{
			case "Y" : $checked1 = "checked";$disabled = "false";break;
			case "N" : $checked2 = "checked";$disabled = "true";break;
			case "G" : $checked3 = "checked";$disabled = "true";break;
			case "NA" : $checked4 = "checked";$disabled = "true";break;
			default  : $checked4 = "checked";$disabled = "true";break;
		}

		$armyRadio	= "
			<span class='h_form'>
				<label for='armyRadio1' class='h-radio'><input type='radio' value='Y' name='user_army' onClick='armyDisabled(false)' $checked1 id='armyRadio1'><span class='noto400 font_14'>군필</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<label for='armyRadio2' class='h-radio'><input type='radio' value='N' name='user_army' onClick='armyDisabled(true)' $checked2 id='armyRadio2' ><span class='noto400 font_14'>미필</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<label for='armyRadio3' class='h-radio'><input type='radio' value='G' name='user_army' onClick='armyDisabled(true)' $checked3 id='armyRadio3'><span class='noto400 font_14'>면제</span></label>
				<label for='armyRadio4' class='h-radio'><input type='radio' value='NA' name='user_army' onClick='armyDisabled(true)' $checked4 id='armyRadio4'><span class='noto400 font_14'>해당없음</span></label>
			</span>
			<script>
				function armyDisabled( val )
				{
					document.document_frm.user_army_start_year.disabled = val;
					document.document_frm.user_army_start_month.disabled = val;
					document.document_frm.user_army_end_year.disabled = val;
					document.document_frm.user_army_end_month.disabled = val;
					document.document_frm.user_army_type.disabled = val;
					document.document_frm.user_army_level.disabled = val;
				}
			</script>
		";

		$armySelect1 .= dateSelectBox( "user_army_start_year", date("Y"), 1980, $Data["user_army_start_year"], "년", "선택", "" , -1).' ';
		$armySelect1 .= dateSelectBox( "user_army_start_month", 1, 12, $Data["user_army_start_month"], "월", "선택", "" , 1);
		$armySelect2 .= dateSelectBox( "user_army_end_year", date("Y"), 1980, $Data["user_army_end_year"], "년", "선택", "" , -1).' ';
		$armySelect2 .= dateSelectBox( "user_army_end_month", 1, 12, $Data["user_army_end_month"], "월", "선택", "" , 1);

		$array		= array("육군","해군","공군","해병","전경","의경","공익","기타");
		$array2		= array("이병","일병","상병","병장","하사","중사","상사","원사","소위","중위","대위","소령","중령","대령","준장","소장","중장","대장","기타");
		$armySelect3 = make_selectbox($array,"선택","user_army_type",$Data["user_army_type"]);
		$armySelect4 = make_selectbox($array2,"선택","user_army_level",$Data["user_army_level"]);
		$armyStart	= "<script>armyDisabled( $disabled );</script>";


		#근무시간
		$StartWorkTime = explode("-",$Data['start_worktime']);
		$FinishWorkTime = explode("-",$Data['finish_worktime']);
		$WorkTime1 = make_selectbox2($TTime1,$TTime1,"","work_time1",$StartWorkTime[0],$select_width="50");
		$WorkTime2 = make_selectbox2($TTime2,$TTime2,"","work_time2",$StartWorkTime[1],$select_width="50");
		$WorkTime3 = make_selectbox2($TTime3,$TTime3,"","work_time3",$StartWorkTime[2],$select_width="50");
		$WorkTime4 = make_selectbox2($TTime1,$TTime1,"","work_time4",$FinishWorkTime[0],$select_width="50");
		$WorkTime5 = make_selectbox2($TTime2,$TTime2,"","work_time5",$FinishWorkTime[1],$select_width="50");
		$WorkTime6 = make_selectbox2($TTime3,$TTime3,"","work_time6",$FinishWorkTime[2],$select_width="50");
		#구직자
		$GuzicPerson = make_radiobox2($TGuzicPerson,$TGuzicPerson,2,"guzicperson","guzicperson",$Data['guzicperson']);
		#학력
		$GuzicEducation = make_selectbox2($TEducation,$TEducation,"학력","guziceducation",$Data['guziceducation'],$select_width="100");
		#국적
		$GuzicNational = make_radiobox2($TNational,$TNational,4,"guzicnational","guzicnational",$Data['guzicnational']);
		#결혼
		$GuzicMarried = make_radiobox2($TMarried,$TMarried,2,"guzicmarried","guzicmarried",$Data['guzicmarried']);
		#자녀수
		$guzicchild = $Data['guzicchild'];
		#자격증/수료
		$GuzicLicence = make_radiobox2($TLicence,$TLicence,2,"guziclicence","guziclicence",$Data['guziclicence']);
		$GuzicLicenceTitle = $Data['guziclicence_title'];
		#파견업체연락
		$SiCompany = make_radiobox2($TSiCompany,$TSiCompany,2,"guzicsicompany","guzicsicompany",$Data['guzicsicompany']);

		//희망회사규모
		if( $_COOKIE['happy_mobile'] == 'on' )
		{
			$희망회사규모 = make_radiobox2($tHopeSize,$tHopeSize,2,"HopeSize","HopeSize",$Data['HopeSize']);

			#근무가능요일
			$WeekDays = make_checkbox2(array_keys($TDayIcons),$TDayIconsTag,4,"etc7","etc7",$Data['etc7'],"");
			$WeekDaysText = make_checkbox2(array_keys($TDayIcons),$TDayNames,2,"etc7","etc7",$Data['etc7'],"");
		}
		else
		{
			$희망회사규모 = make_radiobox2($tHopeSize,$tHopeSize,5,"HopeSize","HopeSize",$Data['HopeSize']);

			#근무가능요일
			$WeekDays = make_checkbox2(array_keys($TDayIcons),$TDayIconsTag,7,"etc7","etc7",$Data['etc7'],"");
			$WeekDaysText = make_checkbox2(array_keys($TDayIcons),$TDayNames,7,"etc7","etc7",$Data['etc7'],"");
		}

		$Data["skin_html"]	= "기본 이력서스킨";

		$DataType1	= $Data;
		$mode	.= "Action";

		//SNS아이디출력 - 2016-07-04 hong
		global $userid_info;
		$userid_info = outputSNSID($userid);
	}

	#######################################################################################################################

	function write_type2()
	{
		global $userid, $mode, $subMode, $number, $per_document_tb, $upload_folder, $happy_member, $type_tb, $type_tb_sub;
		global $search_gu, $search_si, $지역검색1, $지역검색2, $지역검색3,$button, $DataType2;
		global $type_info_1,$type_info_2,$type_info_3;

		if ( $number != "" )
		{
			$Sql	= "
				SELECT
						job_where1_0,
						job_where1_1,
						job_where2_0,
						job_where2_1,
						job_where3_0,
						job_where3_1,
						job_type1,
						job_type2,
						job_type3,
						job_type_sub1,
						job_type_sub2,
						job_type_sub3,
						job_type_sub_sub1,
						job_type_sub_sub2,
						job_type_sub_sub3,
						etc1,etc2,etc3,etc4,etc5,etc6,etc7,etc8,etc9,etc10
				FROM
						$per_document_tb
				WHERE
						number	= '$number'
			";

			$Data	= happy_mysql_fetch_array(query($Sql));

		}
		else if ( $subMode != 'all' )
		{
			error("프로필의 기본정보를 작성해주세요.");
			exit;
		}

			#일단 체크박스 내용들을 담아불자
			for ( $i=0, $max=sizeof($_POST["job_type_sub"]) ; $i<$max ; $i++ )
			{
				$job_type_sub[$i]	= $_POST["job_type_sub"][$i];
			}

		//$type_info_1 = make_type_selectbox('type1','type_sub1',$Data['job_type1'],$Data['job_type_sub1'],'200','200','document_frm');
		//$type_info_2 = make_type_selectbox('type2','type_sub2',$Data['job_type2'],$Data['job_type_sub2'],'200','200','document_frm');
		//$type_info_3 = make_type_selectbox('type3','type_sub3',$Data['job_type3'],$Data['job_type_sub3'],'200','200','document_frm');

		global $type_opt1,$type_sub_opt1,$type_sub_sub_opt1,$type_opt2,$type_sub_opt2,$type_sub_sub_opt2,$type_opt3,$type_sub_opt3,$type_sub_sub_opt3,$type2_key_js,$type2_val_js,$type3_key_js,$type3_val_js;
		global $career_type_opt,$career_type_sub_opt,$career_type_sub_sub_opt;
		$js_arr1			= get_type_selectbox($Data['job_type1'],$Data['job_type_sub1'],$Data['job_type_sub_sub1']);
		$type_opt1			= $js_arr1['type_opt'];
		$type_sub_opt1		= $js_arr1['type_sub_opt'];
		$type_sub_sub_opt1	= $js_arr1['type_sub_sub_opt'];

		$js_arr2			= get_type_selectbox($Data['job_type2'],$Data['job_type_sub2'],$Data['job_type_sub_sub2']);
		$type_opt2			= $js_arr2['type_opt'];
		$type_sub_opt2		= $js_arr2['type_sub_opt'];
		$type_sub_sub_opt2	= $js_arr2['type_sub_sub_opt'];

		$js_arr3			= get_type_selectbox($Data['job_type3'],$Data['job_type_sub3'],$Data['job_type_sub_sub3']);
		$type_opt3			= $js_arr3['type_opt'];
		$type_sub_opt3		= $js_arr3['type_sub_opt'];
		$type_sub_sub_opt3	= $js_arr3['type_sub_sub_opt'];

		$js_arr4					= get_type_selectbox('','','');
		$career_type_opt			= $js_arr4['type_opt'];
		$career_type_sub_opt		= $js_arr4['type_sub_opt'];
		$career_type_sub_sub_opt	= $js_arr4['type_sub_sub_opt'];

		$js_arr	= get_type_selectbox_js();
		$type2_key_js = $js_arr['type2_key_js'];
		$type2_val_js = $js_arr['type2_val_js'];
		$type3_key_js = $js_arr['type3_key_js'];
		$type3_val_js = $js_arr['type3_val_js'];

		$지역검색1	= make_si_selectbox("job_where1_0","job_where1_1","$Data[job_where1_0]","$Data[job_where1_1]","140","140","document_frm");
		$지역검색2	= make_si_selectbox("job_where2_0","job_where2_1","$Data[job_where2_0]","$Data[job_where2_1]","140","140","document_frm");
		$지역검색3	= make_si_selectbox("job_where3_0","job_where3_1","$Data[job_where3_0]","$Data[job_where3_1]","140","140","document_frm");

		$mode	.= "Action";
		$button	= "Submit";

		$DataType2	= $Data;

	}

	#######################################################################################################################

	function write_type3()
	{
		global $키워드내용, $button, $mode, $키워드;

		$mode	.= "Action";
		$button	= "Submit";

		if( $_COOKIE['happy_mobile'] == 'on' )
		{
			$widthSize	= 2;
			$heightSize	= 30;
			$tableSize	= 700;
			$Template1	= "job_per_doc_type3_keyword1.html";
			$Template2	= "job_per_doc_type3_keyword2.html";
		}
		else
		{
			$widthSize	= 5;
			$heightSize	= 30;
			$tableSize	= 700;
			$Template1	= "job_per_doc_type3_keyword1.html";
			$Template2	= "job_per_doc_type3_keyword2.html";

		}

		$키워드내용	= keyword_extraction_list( $widthSize, $heightSize , $tableSize, $Template1 , $Template2 , $cutSize="","document");

	}

	#######################################################################################################################


	function write_type4()
	{
		global $button, $mode, $si_tb, $root_schooltype, $number, $per_document_tb, $subMode, $DataType4;
		global $job_arr,$woodae_arr, $bokri_arr, $money_arr, $edu_arr, $career_arr, $lang_arr, $guin_license_arr, $document_keyword, $want_money_arr;
		global $년도옵션, $고용형태, $희망연봉옵션, $최종학력옵션, $지역선택옵션, $계열선택옵션, $월옵션, $defaultSetting;
		global $defaultSettingType4, $희망연봉타입;

		global $학교타입셀렉트1,$학교타입셀렉트2,$학교타입셀렉트3,$학교타입셀렉트4,$학교타입셀렉트5;
		//grade1_schoolOur
		//alter table `job_per_document` add `grade1_schoolOur` varchar(20) not null default '';
		//alter table `job_per_document` add `grade2_schoolOur` varchar(20) not null default '';
		//alter table `job_per_document` add `grade3_schoolOur` varchar(20) not null default '';
		//alter table `job_per_document` add `grade4_schoolOur` varchar(20) not null default '';
		//alter table `job_per_document` add `grade5_schoolOur` varchar(20) not null default '';

		$mode	.= "Action";
		$button	= "Submit";

		if ( $number != "" )
		{
			$Sql	= "
				SELECT
					grade_gtype,
					grade_money,
					grade_money_type,
					grade_lastgrade,
					grade1_endYear,
					grade1_schoolName,
					grade1_schoolEnd,
					grade1_schoolCity,
					grade1_schoolOur,

					grade2_startYear,
					grade2_endYear,
					grade2_endMonth,
					grade2_point,
					grade2_pointBest,
					grade2_schoolName,
					grade2_schoolType,
					grade2_schoolKwa,
					grade2_schoolEnd,
					grade2_schoolCity,
					grade2_schoolOur,

					grade3_startYear,
					grade3_endYear,
					grade3_endMonth,
					grade3_point,
					grade3_pointBest,
					grade3_schoolName,
					grade3_schoolType,
					grade3_schoolKwa,
					grade3_schoolEnd,
					grade3_schoolCity,
					grade3_schoolOur,

					grade4_startYear,
					grade4_endYear,
					grade4_endMonth,
					grade4_point,
					grade4_pointBest,
					grade4_schoolName,
					grade4_schoolType,
					grade4_schoolKwa,
					grade4_schoolEnd,
					grade4_schoolCity,
					grade4_schoolOur,

					grade5_startYear,
					grade5_endYear,
					grade5_endMonth,
					grade5_point,
					grade5_pointBest,
					grade5_schoolName,
					grade5_schoolType,
					grade5_schoolKwa,
					grade5_schoolEnd,
					grade5_schoolCity,
					grade5_schoolOur,

					grade6_startYear,
					grade6_endYear,
					grade6_endMonth,
					grade6_point,
					grade6_pointBest,
					grade6_schoolName,
					grade6_schoolType,
					grade6_schoolKwa,
					grade6_schoolEnd,
					grade6_schoolCity,
					grade6_schoolOur,

					etc1,etc2,etc3,etc4,etc5,etc6,etc7,etc8,etc9,etc10,is_no_career
				FROM
						$per_document_tb
				WHERE
						number	= '$number'
			";

			$ReData	= happy_mysql_fetch_assoc(query($Sql));

		}
		else if ( $subMode != 'all' )
		{
			error("프로필의 기본정보를 작성해주세요.");
			exit;
		}

		$년도옵션	= dateSelectBox( "곽재걸님ㅋ", date("Y"), 1950, "", "년", "선택", "",-1,"on");
		$월옵션		= dateSelectBox( "곽재걸님ㅋ", 1, 12, "", "월", "선택", "", 1, "on");

		$Sql	= "SELECT si FROM $si_tb order by sort_number";
		$Record	= query($Sql,$conn);
		$Count	= 0;
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$area_arr[$Count++]	= $Data[0];
		}

		$ReData["grade_money_type_ori"] = $ReData["grade_money_type"];
		//$ReData["grade_money_type"]	= $ReData["grade_money_type"] == '' ? $want_money_arr[0] : $ReData["grade_money_type"];

		if($_GET['mode'] == 'add' && $_GET['number']=='') $ReData["grade_money_type"]	= '';

		$names	= Array("area_arr","money_arr","edu_arr","root_schooltype","want_money_arr");
		$return	= Array("지역선택옵션","희망연봉옵션","최종학력옵션","계열선택옵션","희망연봉타입");
		$vals	= Array($ReData["grade2_schoolCity"],$ReData["grade_money"],$ReData["grade_lastgrade"],$ReData["grade3_schoolType"],$ReData["grade_money_type"]);
		for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
		{
			$options	= "<option value=''>- 선택 -</option>";
			for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
			{
				$checked	= ( $vals[$x] == ${$names[$x]}[$i] )?"selected":"";
				$options	.= "<option value='".${$names[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>";
			}
			$options = str_replace("\n","",$options);
			$options = str_replace("\r","",$options);

			${$return[$x]}	= $options;
		}


		$고용형태	= "<table width='100%' border='0' cellpadding='0' cellspacing='0' style=''>";
		$widthSize	= ( $_COOKIE['happy_mobile'] == 'on' )? 2 : 5;
		$width		= ceil(100 / $widthSize);
		$Count		= 0;
		for ( $i=0,$max=sizeof($job_arr) ; $i<$max ; $i++ )
		{
			if ( $Count % $widthSize == 0 )
			{
				$고용형태			.= "<tr>";
			}

			$checked	= ( preg_match( "/".$job_arr[$i]."/i" , $ReData["grade_gtype"] ) )?"checked":"";

			/*$고용형태 .= "
								<td width='{$width}%' style='line-height:30px;' class='h_form'>
									<label class='h-check' for='goyoung[$i]'><input type='checkbox' name='grade_gtype[]' value='$job_arr[$i]' $checked id='goyoung[$i]'><span class='noto400 font_14'>$job_arr[$i]</span></label>
								</td>
			";*/

			//$Count++;
			$고용형태 .= "
								<td width='100%' style='line-height:30px;' class='h_form'>
									<label class='h-check' for='goyoung[$i]'><input type='checkbox' name='grade_gtype[]' value='$job_arr[$i]' $checked id='goyoung[$i]'><span class='noto400 font_14'>$job_arr[$i]</span></label>
								</td>
			";


			if ( $Count % $widthSize == 0 )
			{
				$고용형태			.= "</tr>";
			}
		}

		if ( $Count % $widthSize != 0 )
		{
			for ( $Count = $Count % $widthSize; $Count < $widthSize; $Count++ )
			{
				$고용형태	.= "<td width='{$width}%' style='line-height:25px;'>&nbsp;</td>\n";
			}

			$고용형태	.= "</tr>";
		}

		$고용형태	.= "</table>";

		//등록시에는 기본값 지정 안되게
		if ( $number != "" )
		{
			$count			= 0;
			$defaultSetting	= "<script>\n";
			$defaultSetting	.= "\tfunction defaultSetting() {\n";

			if ( is_array($ReData) )
			{
				/*
				foreach ( $ReData AS $val )
				{
					if ( $count > 4 && $count%2 !=0)
					{
						$kwak	= key($ReData);
						$defaultSetting	.= "\t\tdocument.document_frm.${kwak}.value = '$val';\n";
					}

					next($ReData);
					$count++;
				}
				*/
				$no_value = array("grade_gtype","grade_money","grade_money_type","grade_lastgrade","etc1","etc2","etc3","etc4","etc5","etc6","etc7","etc8","etc9","etc10","grade_money_type_ori");
				foreach ( $ReData as $k => $v )
				{

					//if ( $count > 4 && $count%2 !=0)
					//{
						if ( !in_array($k,$no_value) )
						{
							$defaultSetting	.= "\t\tdocument.document_frm.$k.value = '$v';\n";
						}
						#echo $defaultSetting."<br>";
					//}
					$count++;
				}
			}
			$defaultSetting	.= ( $ReData["grade4_schoolName"] != "" )?"\t\tgrade4ViewCheck();\n":"";
			$defaultSetting	.= "\t}\n";
			$defaultSetting	.= "\tdefaultSetting();\n";
			$defaultSetting	.= "</script>\n";

			$ReData['is_no_career_checked']	= ( $ReData['is_no_career'] == 'y' ) ? 'checked' : '';

			// 학력사항
			global $per_academy_tb, $per_academy_html;
			$x		= 1;
			$sql	= "SELECT * FROM {$per_academy_tb} WHERE doc_number = '{$number}'";
			$rec	= query($sql);
			while($row = mysql_fetch_assoc($rec))
			{
				//print_r2($row);
				if( $x == 1 )
				{
					$btn_academy	= "<input type=\"button\" value=\"+ 추가하기\" class=\"btn_academy_add\">";
				}
				else
				{
					$btn_academy	= "<input type=\"button\" value=\"- 삭제하기\" class=\"btn_academy_del\">";
				}

				$academy_out_type_checked_arr	= array();
				if( $row['academy_out_type'] == '졸업' )
				{
					$academy_out_type_checked_arr[0]	= 'selected';
					$academy_out_type_checked_arr[1]	= '';
					$academy_out_type_checked_arr[2]	= '';
					$academy_out_type_checked_arr[3]	= '';
					$academy_out_type_checked_arr[4]	= '';
					$academy_out_type_checked_arr[5]	= '';
				}
				else if( $row['academy_out_type'] == '졸업예정' )
				{
					$academy_out_type_checked_arr[0]	= '';
					$academy_out_type_checked_arr[1]	= 'selected';
					$academy_out_type_checked_arr[2]	= '';
					$academy_out_type_checked_arr[3]	= '';
					$academy_out_type_checked_arr[4]	= '';
					$academy_out_type_checked_arr[5]	= '';
				}
				else if( $row['academy_out_type'] == '재학중' )
				{
					$academy_out_type_checked_arr[0]	= '';
					$academy_out_type_checked_arr[1]	= '';
					$academy_out_type_checked_arr[2]	= 'selected';
					$academy_out_type_checked_arr[3]	= '';
					$academy_out_type_checked_arr[4]	= '';
					$academy_out_type_checked_arr[5]	= '';
				}
				else if( $row['academy_out_type'] == '중퇴' )
				{
					$academy_out_type_checked_arr[0]	= '';
					$academy_out_type_checked_arr[1]	= '';
					$academy_out_type_checked_arr[2]	= '';
					$academy_out_type_checked_arr[3]	= 'selected';
					$academy_out_type_checked_arr[4]	= '';
					$academy_out_type_checked_arr[5]	= '';
				}
				else if( $row['academy_out_type'] == '수료' )
				{
					$academy_out_type_checked_arr[0]	= '';
					$academy_out_type_checked_arr[1]	= '';
					$academy_out_type_checked_arr[2]	= '';
					$academy_out_type_checked_arr[3]	= '';
					$academy_out_type_checked_arr[4]	= 'selected';
					$academy_out_type_checked_arr[5]	= '';
				}
				else if( $row['academy_out_type'] == '휴학' )
				{
					$academy_out_type_checked_arr[0]	= '';
					$academy_out_type_checked_arr[1]	= '';
					$academy_out_type_checked_arr[2]	= '';
					$academy_out_type_checked_arr[3]	= '';
					$academy_out_type_checked_arr[4]	= '';
					$academy_out_type_checked_arr[5]	= 'selected';
				}
				else
				{
					$academy_out_type_checked_arr	= array();
				}

				$academy_degree_checked_arr	= array();
				if( $row['academy_degree'] == '학사' )
				{
					$academy_degree_checked_arr[0]	= 'selected';
					$academy_degree_checked_arr[1]	= '';
					$academy_degree_checked_arr[2]	= '';
				}
				else if( $row['academy_degree'] == '석사' )
				{
					$academy_degree_checked_arr[0]	= '';
					$academy_degree_checked_arr[1]	= 'selected';
					$academy_degree_checked_arr[2]	= '';
				}
				else if( $row['academy_degree'] == '박사' )
				{
					$academy_degree_checked_arr[0]	= '';
					$academy_degree_checked_arr[1]	= '';
					$academy_degree_checked_arr[2]	= 'selected';
				}
				else
				{
					$academy_degree_checked_arr	= array();
				}

				$per_academy_html	.= "<tr id=\"{$x}\" class=\"academy_tr_clone\">
				<td class=\"h_form\">
					<input type=\"text\" name=\"academy_in[]\" id=\"academy_in_{$x}\" maxlength=\"7\" value=\"{$row['academy_in']}\" placeholder=\"입학년월(YYYY/MM)\" style=\"width: 150px;\">
					<input type=\"text\" name=\"academy_out[]\" id=\"academy_out_{$x}\" maxlength=\"7\" value=\"{$row['academy_out']}\" placeholder=\"졸업년월(YYYY/MM)\" style=\"width: 150px;\">
					<select name=\"academy_out_type[]\" id=\"academy_out_type_{$x}\" style=\"width: 150px;\">
						<option value=\"\">졸업상태</option>
						<option value=\"졸업\" {$academy_out_type_checked_arr[0]}>졸업</option>
						<option value=\"졸업예정\" {$academy_out_type_checked_arr[1]}>졸업예정</option>
						<option value=\"재학중\" {$academy_out_type_checked_arr[2]}>재학중</option>
						<option value=\"중퇴\" {$academy_out_type_checked_arr[3]}>중퇴</option>
						<option value=\"수료\" {$academy_out_type_checked_arr[4]}>수료</option>
						<option value=\"휴학\" {$academy_out_type_checked_arr[5]}>휴학</option>
					</select>
					<input type=\"text\" name=\"academy_name[]\" id=\"academy_name_{$x}\" placeholder=\"학교명\" value=\"{$row['academy_name']}\" style=\"width: 150px;\">
					<select name=\"academy_degree[]\" id=\"academy_degree_{$x}\" style=\"width: 150px;\">
						<option value=\"\">학위</option>
						<option value=\"학사\" {$academy_degree_checked_arr[0]}>학사</option>
						<option value=\"석사\" {$academy_degree_checked_arr[1]}>석사</option>
						<option value=\"박사\" {$academy_degree_checked_arr[2]}>박사</option>
					</select>
				</td>
				<td>
					{$btn_academy}
				</td></tr>";
				$x++;
			}

			// 경력사항
			if( $ReData['is_no_career'] == 'n' )
			{
				global $per_career_tb, $per_career_html, $_TYPE_DEPTH_TXT_ARR;
				$x		= 1;
				$sql	= "SELECT * FROM {$per_career_tb} WHERE doc_number = '{$number}'";
				$rec	= query($sql);
				while($row = mysql_fetch_assoc($rec))
				{
					//print_r2($row);
					if( $x == 1 )
					{
						$btn_career	= "<a href=\"javascript:void(0);\" class=\"btn_career_add\">+ 추가하기</a>";
					}
					else
					{
						$btn_career	= "<a href=\"javascript:void(0);\" class=\"btn_career_del\">- 삭제하기</a>";
					}

					$career_area_checked	= array();
					if( $row['career_area'] == 'in' )
					{
						$career_area_checked[0]	= "checked";
						$career_area_checked[1]	= "";
					}
					else
					{
						$career_area_checked[0]	= "";
						$career_area_checked[1]	= "checked";
					}

					$career_out_disabled		= "";
					$career_work_type_checked	= array();
					if( $row['career_work_type'] == 'in' )
					{
						$career_work_type_checked[0]	= "selected";
						$career_work_type_checked[1]	= "";
						$row['career_out']				= "";
					}
					else if( $row['career_work_type'] == 'out' )
					{
						$career_work_type_checked[0]	= "";
						$career_work_type_checked[1]	= "selected";
						$career_out_disabled			= "disabled";
					}
					else
					{
						$career_work_type_checked	= array();
					}

					$career_work_name_nodisplay_checked	= "";
					if( $row['career_work_name_nodisplay'] == 'y' )
					{
						$career_work_name_nodisplay_checked	= "checked";
					}

					$js_arr4					= get_type_selectbox($row['career_type'],$row['career_type_sub'],$row['career_type_sub_sub']);
					$career_type_opt			= $js_arr4['type_opt'];
					$career_type_sub_opt		= $js_arr4['type_sub_opt'];
					$career_type_sub_sub_opt	= $js_arr4['type_sub_sub_opt'];

					/*$per_career_html	.= "<tr id=\"{$x}\" class=\"career_tr_clone\">
					<td class=\"h_form\">
						<input type=\"radio\" name=\"career_area_{$x}\" id=\"career_area_in_{$x}\" value=\"in\" {$career_area_checked[0]}><label for=\"career_area_in_{$x}\">국내</label>
						<input type=\"radio\" name=\"career_area_{$x}\" id=\"career_area_out_{$x}\" value=\"out\" {$career_area_checked[1]}><label for=\"career_area_out_{$x}\">해외</label>
						<input type=\"text\" name=\"career_work_name[]\" id=\"career_work_name_{$x}\" value=\"{$row['career_work_name']}\" placeholder=\"근무처명\" style=\"width: 150px;\">
						<input type=\"checkbox\" name=\"career_work_name_nodisplay_{$x}\" id=\"career_work_name_nodisplay_{$x}\" value=\"y\" {$career_work_name_nodisplay_checked}><label for=\"career_work_name_nodisplay_{$x}\">근무처명 비공개</label>
						<br />
						<select name=\"career_type[]\" id=\"career_type_{$x}\" style=\"width:200px;\">
							{$career_type_opt}
						</select>
						<select name=\"career_type_sub[]\" id=\"career_type_sub_{$x}\" style=\"width:200px;\">
							<option value=\"\">{$_TYPE_DEPTH_TXT_ARR[1]}</option>
							{$career_type_sub_opt}
						</select>
						<select name=\"career_type_sub_sub[]\" id=\"career_type_sub_sub_{$x}\" style=\"width:200px;\">
							<option value=\"\">{$_TYPE_DEPTH_TXT_ARR[2]}</option>
							{$career_type_sub_sub_opt}
						</select>
						<br />
						<input type=\"text\" name=\"career_in[]\" id=\"career_in_{$x}\" maxlength=\"7\" value=\"{$row['career_in']}\" placeholder=\"입사년월(YYYY/MM)\" style=\"width: 150px;\">
						<input type=\"text\" name=\"career_out[]\" id=\"career_out_{$x}\" {$career_out_disabled} maxlength=\"7\" value=\"{$row['career_out']}\" placeholder=\"퇴사년월(YYYY/MM)\" style=\"width: 150px;\">
						<input type=\"text\" name=\"career_duty[]\" id=\"career_duty_{$x}\" value=\"{$row['career_duty']}\" placeholder=\"직무/직책\" style=\"width: 150px;\">
						<select name=\"career_work_type[]\" id=\"career_work_type_{$x}\" style=\"width: 150px;\">
							<option value=\"\">재직상태</option>
							<option value=\"재직중\" {$career_work_type_checked[0]}>재직중</option>
							<option value=\"퇴사\" {$career_work_type_checked[1]}>퇴사</option>
						</select>
						<textarea name=\"career_msg[]\" id=\"career_msg_{$x}\" cols=\"30\" rows=\"10\" placeholder=\"상세내용\">{$row['career_msg']}</textarea>
					</td>
					<td>
						{$btn_career}
					</td></tr>";*/

					$per_career_html	.= "<div id=\"{$x}\" class=\"career_tr_clone\">
		{$btn_career}
		<p class=\"inline01\">
			<input type=\"hidden\" name=\"career_cnt[]\" id=\"career_cnt_{$x}\" value=\"1\">
			<span class=\"part-clear\"></span>
			<label class=\"h-radio\" for=\"career_area_in_{$x}\"><input type=\"radio\" id=\"career_area_in_{$x}\" name=\"career_area_{$x}\" value=\"in\" {$career_area_checked[0]}> <span class=\"noto400 font_14\">국내</span></label>
			<label class=\"h-radio\" for=\"career_area_out_{$x}\"><input type=\"radio\" id=\"career_area_out_{$x}\" name=\"career_area_{$x}\" value=\"out\" {$career_area_checked[1]}> <span class=\"noto400 font_14\">해외</span></label>
		</p>

		<p class=\"inline02\">
			<input type=\"text\" name=\"career_work_name[]\" id=\"career_work_name_{$x}\" placeholder=\"근무처명\" value=\"{$row['career_work_name']}\">
			<label for=\"career_work_name_nodisplay_{$x}\" class=\"h-check\"><input type=\"checkbox\" name=\"career_work_name_nodisplay_{$x}\" id=\"career_work_name_nodisplay_{$x}\" value=\"y\" {$career_work_name_nodisplay_checked}><span></span></label>
			<label for=\"career_work_name_nodisplay_{$x}\" class=\"noto400 font_14\" style=\"cursor:pointer;\">근무처명 비공개</label>
		</p>

		<p class=\"inline03\">
			<select name=\"career_type[]\" id=\"career_type_{$x}\">
				{$career_type_opt}
			</select>
			<select name=\"career_type_sub[]\" id=\"career_type_sub_{$x}\">
				<option value=\"\">{$_TYPE_DEPTH_TXT_ARR[1]}</option>
				{$career_type_sub_opt}
			</select>
			<select name=\"career_type_sub_sub[]\" id=\"career_type_sub_sub_{$x}\">
				<option value=\"\">{$_TYPE_DEPTH_TXT_ARR[2]}</option>
				{$career_type_sub_sub_opt}
			</select>
		</p>
		<p class=\"inline04\">
			<input type=\"text\" name=\"career_in[]\" id=\"career_in_{$x}\" placeholder=\"입사년월(YYY,MM)\" value=\"{$row['career_in']}\">
			<input type=\"text\" name=\"career_out[]\" id=\"career_out_{$x}\" placeholder=\"퇴사년월(YYY,MM)\" value=\"{$row['career_out']}\">
			<input type=\"text\" name=\"career_duty[]\" id=\"career_duty_{$x}\" placeholder=\"직위/직책\" value=\"{$row['career_duty']}\">
			<select name=\"career_work_type[]\" id=\"career_work_type_{$x}\">
				<option value=\"\">재직상태</option>
				<option value=\"재직중\" {$career_work_type_checked[0]}>재직중</option>
				<option value=\"퇴사\" {$career_work_type_checked[1]}>퇴사</option>
			</select>
		</p>
		<p class=\"inline05\">
			<textarea name=\"career_msg[]\" id=\"career_msg_{$x}\" placeholder=\"진행 가능한 시술명, 외래진료과 등 경력 관련 상세내용을 적어주세요.\">{$row['career_msg']}</textarea>
		</p>
	</div>";
					$x++;
				}

			}

		}


		$defaultSettingType4	= $defaultSetting;

		$array = array("본교","분교");
		$ReData['select_grade1_schoolOur'] = make_selectbox($array,"선택","grade1_schoolOur",$ReData["grade1_schoolOur"]);
		$ReData['select_grade2_schoolOur'] = make_selectbox($array,"선택","grade2_schoolOur",$ReData["grade2_schoolOur"]);
		$ReData['select_grade3_schoolOur'] = make_selectbox($array,"선택","grade3_schoolOur",$ReData["grade3_schoolOur"]);
		$ReData['select_grade4_schoolOur'] = make_selectbox($array,"선택","grade4_schoolOur",$ReData["grade4_schoolOur"]);
		$ReData['select_grade5_schoolOur'] = make_selectbox($array,"선택","grade5_schoolOur",$ReData["grade5_schoolOur"]);
		$ReData['select_grade6_schoolOur'] = make_selectbox($array,"선택","grade6_schoolOur",$ReData["grade6_schoolOur"]);


		$DataType4	= $ReData;
		//print_r2($DataType4);
	}

	#######################################################################################################################

	function write_type5()
	{
		global $root_money2, $number, $per_document_tb, $per_worklist_tb, $root_money2, $grade_arr, $userid, $subMode;
		global $연봉선택옵션, $직급선택옵션, $년도옵션, $월옵션, $경력옵션, $defaultSetting, $mode, $button, $DataType5, $경력월옵션, $defaultSettingType5;
		$mode	.= "Action";
		$button	= "Submit";

		if ( $number != "" )
		{
			$Sql	= "
				SELECT
						work_year,
						work_month,
						work_otherCountry,
						work_list,
						etc1,etc2,etc3,etc4,etc5,etc6,etc7,etc8,etc9,etc10
				FROM
						$per_document_tb
				WHERE
						number	= '$number'
			";

			$Data	= happy_mysql_fetch_array(query($Sql));
			$Data['work_otherCountry']	= $Data['work_otherCountry'] == 'Y' ? 'checked' : '';
			$DataType5	= $Data;

			$Sql	= "
				SELECT
						*
				FROM
						$per_worklist_tb
				WHERE
						pNumber	= '$number'
						AND
						userid	= '$userid'
			";

			$Record	= query($Sql);
		}
		else if ( $subMode != 'all' )
		{
			error("프로필의 기본정보를 작성해주세요.");
			exit;
		}

		//$Data[work_month]	= intval($Data[work_month]);

		$년도옵션	= dateSelectBox( "곽재걸님ㅋ", date("Y"), 1950, "", "년", "선택", "",-1,"on");
		$월옵션		= dateSelectBox( "곽재걸님ㅋ", 1, 12, $Data[work_month], "월", "선택", "", 1, "on");
		$경력옵션	= dateSelectBox( "곽재걸님ㅋ", 1, 50, $Data[work_year], "년", "선택", "", 1, "on");
		$경력월옵션	= $월옵션;



		$names	= Array("root_money2","grade_arr");
		$return	= Array("연봉선택옵션","직급선택옵션");
		$vals	= Array($ReData["grade2_schoolCity"],$ReData["grade_money"],$ReData["grade_lastgrade"],$ReData["grade3_schoolType"]);

		for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
		{
			$options	= "";
			for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
			{
				$checked	= ( $vals[$x] == ${$names[$x]}[$i] )?"selected":"";
				$options	.= "<option value='".${$names[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>";
			}
			${$return[$x]}	= $options;
		}



		## 수정을 위한 데이타 집어넣기 -.-;; 짜보니 무지 기네;; 후덜덜##
		$defaultSetting	= "<script>\n";
		$defaultSetting	.= "\tfunction defaultSetting() {\n";

		$Data[work_list]	= str_replace("\r","",$Data[work_list]);
		$Data[work_list]	= str_replace("\n","\\n",$Data[work_list]);

		$defaultSetting	.= "
			\t	document.document_frm.work_year.value = '$Data[work_year]';\n
			\t	document.document_frm.work_month.value = '$Data[work_month]';\n
			\t	document.document_frm.work_list.value = '$Data[work_list]'\n
		";

		$defaultSetting	.= ( $Data[work_otherCountry] == "checked" )?"\t document.document_frm.work_otherCountry.checked = true; \n":"";
		$defaultSetting	.= ( $ReData["grade4_pointBest"] != "" )?"\t\tgrade4ViewCheck();\n":"";
		$defaultSetting	.= "\t}\n";
		$defaultSetting	.= "\tdefaultSetting();\n";

		//print_r2($Data);
		$Count	= 1;
		if ( $Record )
		while ( $Data = happy_mysql_fetch_assoc($Record) )
		{
			//print_r2($Data);
			$Data	= str_replace("\n","\\n",$Data);
			$defaultSetting2	= "\n\twork_layer_add();\n";
			$defaultSetting2	.= "\t	document.document_frm.startYear__kwak.value = '$Data[startYear]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.startMonth__kwak.value = '$Data[startMonth]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.endYear__kwak.value = '$Data[endYear]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.endMonth__kwak.value = '$Data[endMonth]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.status__kwak.value = '$Data[status]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.company_name__kwak.value = '$Data[company_name]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.company_type__kwak.value = '$Data[company_type]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.job_type__kwak.value = '$Data[job_type]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.job_part__kwak.value = '$Data[job_part]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.job_content__kwak.value = '$Data[job_content]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.job_level__kwak.value = '$Data[job_level]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.job_money__kwak.value = '$Data[job_money]'; \n";

			if ( $Data["display1"] == "N" )
				$defaultSetting2	.= "\t	document.document_frm.display1__kwak.checked = true; \n";
			if ( $Data["display2"] == "N" || $Data["display2"] == "YN" )
				$defaultSetting2	.= "\t	document.document_frm.display2__kwak.checked = true; \n";

			$defaultSetting2	= str_replace("__kwak","__".$Count,$defaultSetting2);

			$defaultSetting	.= $defaultSetting2;
			$Count++;

		}


		$defaultSetting	.= ($Count == 1 )?"\n\twork_layer_add();\n":"";
		$defaultSetting	.= "</script>\n";

		$defaultSettingType5	= $defaultSetting;



		## 데이타 집어 넣기 끝-.- ##


	}


	#######################################################################################################################

	function write_type6()
	{
		global $button, $mode, $number, $per_document_tb, $subMode;
		global $미리보기1, $미리보기2, $미리보기3, $미리보기4, $미리보기5;
		global $삭제1, $삭제2, $삭제3, $삭제4, $삭제5, $DataType6, $load_flash_drag, $load_flash_drag_url;
		global $doc_mini_album_use, $TPL, $skin_folder, $미니앨범수정;
		global $mobile_album_display; //관리자 미니앨범사용 설정에 따른 display ranksa

		$mobile_album_display		= 'display:none';
		if ( $doc_mini_album_use == '1' )
		{
			$load_flash_drag		= '';
			$load_flash_drag_url	= 'flash_upload_drag.php';

			if ( $number != '' )
			{
				$load_flash_drag		= "<iframe src='flash_upload_drag.php?mode=db&number=$_GET[number]' width='100%' height='460' frameborder='0' scrolling='no'></iframe>";
				$load_flash_drag_url	= "flash_upload_drag.php?mode=db&number=$_GET[number]";

				###### 멀티업로드 드래그 이미지 시작 #######
				global $startScript, $fileNames, $per_file_tb, $makeDragImg;

				//수정페이지에서 로딩되었을 경우.( 이미지를 업로드하는 상황에서도 이전에 등록되어 있던 이미지를 호출해야 하므로 포함됨.
				$Sql				= "SELECT * FROM $per_file_tb WHERE doc_number = '$number' order by number  ";
				$Record				= query($Sql);

				$tmp	= explode(",",$fields);
				$i		= 0;
				while ( $Data = happy_mysql_fetch_array($Record) )
				{
					$Data['fileName']	= str_replace("((thumb_name))","_thumb",$Data['fileName']);
					//echo $upfolder; exit;
					$fileName	= $Data['fileName'] ;


					$fileNames	.= ( $i==0 )?"":"||";
					$fileNames	.= ( $fileName == "" ) ?"":$upfolder.$fileName;

					$startScript	.= "document_frm.img${i}.value	= '".$Data['fileName']."';\n";

					$i++;
				}

				$makeDragImg		= "
				makeDragImg(
					drag_get_images = '$fileNames',
					drag_get_number = '$number'
				);
				";
				###### 멀티업로드 드래그 이미지 종료 #######
			}

			$mobile_album_display	= '';

			$TPL->define("미니앨범수정", "$skin_folder/job_per_doc_minialbum.html");
			$TPL->assign("미니앨범수정");
			$미니앨범수정 = $TPL->fetch();
		}

		if ( $number != "" )
		{
			$Sql	= "
				SELECT
						fileName1,
						fileName2,
						fileName3,
						fileName4,
						fileName5,
						etc1,etc2,etc3,etc4,etc5,etc6,etc7,etc8,etc9,etc10
				FROM
						$per_document_tb
				WHERE
						number	= '$number'
			";

			$Data	= happy_mysql_fetch_array(query($Sql));

		}
		else if ( $subMode != 'all' )
		{
			error("프로필의 기본정보를 작성해주세요.");
			exit;
		}

		for ( $i=1 ; $i<=5 ; $i++ )
		{
			if ( $Data["fileName".$i] != "" )
			{
				$filename	= $Data["fileName".$i];
				${"미리보기".$i}	= "<a class='h_btn_st2' href='fileDown.php?idx=$i&number=$number&file=".$filename."' title='등록된 첨부파일 확인은 클릭하여 다운로드 후 확인하시면 됩니다.'>다운로드</a>";
				${"삭제".$i}		= "<label for='img_del".$i."' class='label_del h-check' title='등록한 첨부파일을 삭제하기 원하시면 체크해 주시면 됩니다.'><input type='checkbox' name='file${i}_del' id='img_del".$i."' value='ok'><span class='noto400 font_14'>삭제</span></label>";
				//${"삭제".$i}		= "<input type='checkbox' name='file${i}_del' value='ok'>파일삭제";
			}
			else
			{
				${"미리보기".$i}	= "";
				${"삭제".$i}		= "";
			}
		}


		$mode	.= "Action";
		$button	= "Submit";

		$DataType6	= $Data;

	}


	#######################################################################################################################

	function write_type7()
	{
		global $키워드내용, $button, $mode,$lang_arr, $root_lang, $root_country, $Data, $per_document_tb, $number;
		global $키워드, $년도옵션, $월옵션, $일옵션, $외국어능력옵션, $외국어자격증옵션, $연수국가옵션;
		global $per_skill_tb, $per_language_tb, $per_yunsoo_tb, $userid, $defaultSetting, $subMode, $DataType7;
		global $defaultSettingType7;

		$mode	.= "Action";
		$button	= "Submit";


		if ( $number != "" )
		{
			$Sql	= "
				SELECT
						skill_word,
						skill_ppt,
						skill_excel,
						skill_search,
						skill_list,
						skill_etc,
						etc1,etc2,etc3,etc4,etc5,etc6,etc7,etc8,etc9,etc10,
						skill_use_oa,
						skill_use_license,
						skill_use_completion,
						skill_use_foreign,
						skill_use_training,
						skill_use_givespecial
				FROM
						$per_document_tb
				WHERE
						number	= '$number'
			";


			$Data	= happy_mysql_fetch_array(query($Sql));

		}
		else if ( $subMode != 'all' )
		{
			error("프로필의 기본정보를 작성해주세요.");
			exit;
		}

		$Data['oa_style']		= 'display:none;';
		$Data['license_style']		= 'display:none;';
		$Data['completion_style']		= 'display:none;';
		$Data['foreign_style']		= 'display:none;';
		$Data['training_style']		= 'display:none;';
		$Data['givespecial_style']		= 'display:none;';

		if( $Data['skill_use_oa'] == 'y' )
		{
			$Data['oa_checked']		= 'checked';
			$Data['oa_style']		= '';
		}

		if( $Data['skill_use_license'] == 'y' )
		{
			$Data['license_checked']		= 'checked';
			$Data['license_style']		= '';
		}

		if( $Data['skill_use_completion'] == 'y' )
		{
			$Data['completion_checked']		= 'checked';
			$Data['completion_style']		= '';
		}

		if( $Data['skill_use_foreign'] == 'y' )
		{
			$Data['foreign_checked']		= 'checked';
			$Data['foreign_style']		= '';
		}

		if( $Data['skill_use_training'] == 'y' )
		{
			$Data['training_checked']		= 'checked';
			$Data['training_style']		= '';
		}

		if( $Data['skill_use_givespecial'] == 'y' )
		{
			$Data['givespecial_checked']		= 'checked';
			$Data['givespecial_style']		= '';
		}


		$년도옵션	= dateSelectBox( "곽재걸님ㅋ", date("Y"), 1950, "", "년", "선택", "",-1,"on");
		$월옵션		= dateSelectBox( "곽재걸님ㅋ", 1, 12, "", "월", "선택", "", 1, "on");
		$일옵션		= dateSelectBox( "곽재걸님ㅋ", 1, 31, "", "일", "선택", "", 1, "on");

		$names	= Array("lang_arr","root_lang","root_country");
		$return	= Array("외국어능력옵션","외국어자격증옵션","연수국가옵션");
		$vals	= Array($ReData["grade2_schoolCity"],$ReData["grade_money"],$ReData["grade_lastgrade"],$ReData["grade3_schoolType"]);

		for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
		{
			$options	= "";
			for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
			{
				$checked	= ( $vals[$x] == ${$names[$x]}[$i] )?"selected":"";
				$options	.= "<option value='".${$names[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>";
			}
			${$return[$x]}	= $options;
		}



		## 수정을 위한 데이타 집어넣기 -.-;; 역시 길다;; 후덜덜##

		$Data["skill_word".$Data["skill_word"]]		= "checked";
		$Data["skill_ppt".$Data["skill_ppt"]]		= "checked";
		$Data["skill_excel".$Data["skill_excel"]]	= "checked";
		$Data["skill_search".$Data["skill_search"]]	= "checked";

		$defaultSetting	= "<script>\n";

		$Sql	= "SELECT * FROM $per_skill_tb WHERE userid='$userid' order by number asc ";
		$Record	= query($Sql);
		$Count	= 1;
		while ( $rData = happy_mysql_fetch_array($Record) )
		{
			$rData	= str_replace("\n","\\n",$rData);
			$defaultSetting2	= "\n\twork_layer_add1('add');\n";
			$defaultSetting2	.= "\t	document.document_frm.skill_name__kwak.value = '$rData[skill_name]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.skill_from__kwak.value = '$rData[skill_from]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.skill_getYear__kwak.value = '$rData[skill_getYear]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.skill_getMonth__kwak.value = '$rData[skill_getMonth]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.skill_getDay__kwak.value = '$rData[skill_getDay]'; \n";

			$defaultSetting2	= str_replace("__kwak","__".$Count,$defaultSetting2);

			$defaultSetting	.= $defaultSetting2;
			$Count++;

		}
		$defaultSetting	.= ($Count == 1 )?"\n\twork_layer_add1('add');\n":"";





		$Sql	= "SELECT * FROM $per_language_tb WHERE userid='$userid' ";
		//echo $Sql;

		$Record	= query($Sql);
		$Count	= 1;
		$Onload_Script_2 = "";
		while ( $rData = happy_mysql_fetch_array($Record) )
		{
			$rData	= str_replace("\n","\\n",$rData);
			$kwak	= $rData["language_skill"]-1;

			switch ( $kwak )
			{
				case "2":	$kwak = "0";break;
				case "1":	$kwak = "1";break;
				case "0":	$kwak = "2";break;
			}


			/*
			$defaultSetting2	= "\n\twork_layer_add2('add');\n";
			$defaultSetting2	.= "\t	document.document_frm.language_title__kwak.value = '$rData[language_title]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.language_skill__kwak[". $kwak ."].checked = true ; \n";
			$defaultSetting2	.= "\t	document.document_frm.language_check__kwak.value = '$rData[language_check]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.language_point__kwak.value = '$rData[language_point]'; \n";
			#$defaultSetting2	.= "\t	document.document_frm.language_level__kwak.value = '$rData[language_level]'; \n";
			#language_level은 input에 없으므로 주석처리 - 혹시 필요시 ... 주석해제
			$defaultSetting2	.= "\t	document.document_frm.language_year__kwak.value = '$rData[language_year]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.language_month__kwak.value = '$rData[language_month]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.language_day__kwak.value = '$rData[language_day]'; \n";
			*/

			$defaultSetting2	= "
									work_layer_add2('add');
			";

			//document.document_frm.language_level__kwak.value = '$rData[language_level]';
			//language_level은 input에 없으므로 주석처리 - 혹시 필요시 ... 주석해제

			//language_skill__kwak 이 checked 가 되지 않아 onload 로 변경함 2014-01-15 ralear
			$Onload_Script_2	.= "
									document.document_frm.language_title__kwak.value = '$rData[language_title]';
									document.document_frm.language_skill__kwak[". $kwak ."].checked = true ;
									document.document_frm.language_check__kwak.value = '$rData[language_check]';
									document.document_frm.language_point__kwak.value = '$rData[language_point]';
									document.document_frm.language_year__kwak.value = '$rData[language_year]';
									document.document_frm.language_month__kwak.value = '$rData[language_month]';
									document.document_frm.language_day__kwak.value = '$rData[language_day]';
			";

			//$defaultSetting2	= str_replace("__kwak","__".$Count,$defaultSetting2);
			$Onload_Script_2	= str_replace("__kwak","__".$Count,$Onload_Script_2);

			$defaultSetting	.= $defaultSetting2;
			$Count++;

		}

		$Onload_Script_2	= "
								function modify_loading2()
								{
									$Onload_Script_2
								}

								addLoadEvent(modify_loading2);
		";
		$defaultSetting		.= "
								$Onload_Script_2
		";

		$defaultSetting		.= ($Count == 1 )?"\n\twork_layer_add2('add');\n":"";



		$Sql	= "SELECT * FROM $per_yunsoo_tb WHERE userid='$userid' ";
		$Record	= query($Sql);
		$Count	= 1;
		while ( $rData = happy_mysql_fetch_array($Record) )
		{
			$rData	= str_replace("\n","\\n",$rData);
			$defaultSetting2	= "\n\twork_layer_add3('add');\n";
			$defaultSetting2	.= "\t	document.document_frm.country__kwak.value = '$rData[country]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.startYear__kwak.value = '$rData[startYear]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.startMonth__kwak.value = '$rData[startMonth]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.endYear__kwak.value = '$rData[endYear]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.endMonth__kwak.value = '$rData[endMonth]'; \n";
			$defaultSetting2	.= "\t	document.document_frm.content__kwak.value = '$rData[content]'; \n";

			$defaultSetting2	= str_replace("__kwak","__".$Count,$defaultSetting2);

			$defaultSetting	.= $defaultSetting2;
			$Count++;

		}
		$defaultSetting	.= ($Count == 1 )?"\n\twork_layer_add3('add');\n":"";



		$defaultSetting	.= "</script>\n";


		$defaultSettingType7 = $defaultSetting;

		$DataType7		= $Data;
		## 데이타 집어 넣기 끝-.- ##



	}

	#######################################################################################################################

	#######################################################################################################################

	#######################################################################################################################

	#######################################################################################################################

	#######################################################################################################################


	function dbAction()
	{
		global $_POST, $_FILES, $per_document_tb, $mode, $subMode, $number, $userid, $per_worklist_tb, $per_document_file;
		global $per_skill_tb, $per_language_tb, $per_yunsoo_tb, $user_id, $per_document_pic, $returnUrl;
		global $doc_pic_width, $doc_pic_height,$happy_member, $per_file_tb, $folder_name, $doc_img_path , $doc_img_url;
		global $doc_mini_album_use;
		global $TDenyWordList;
		global $CONF;
		global $PER_ARRAY_DB,$PER_ARRAY_NAME,$type_tb;
		global $happy_member_secure_text;


		#금지단어 체크
		if ( DenyWordCheck($_POST['title'],$TDenyWordList) )
		{
			error(" 사용하실수 없는 금지단어가 제목에 포함되어 있습니다.");
			exit;
		}
		#금지단어 체크

		#금지단어 체크
		if ( DenyWordCheck($_POST['profile'],$TDenyWordList) )
		{
			error(" 사용하실수 없는 금지단어가 자기소개에 포함되어 있습니다.");
			exit;
		}
		#금지단어 체크


		$number				= $_POST["number"];
		$subMode			= $_POST["subMode"];

		#subMode 1
		$skin_html			= $_POST["skin_html"];
		$skin_date			= $_POST["skin_date"];
		$title				= strip_tags($_POST["title"]);
		$profile			= $_POST["profile"];
		$user_id			= $_POST["user_id"];
		$user_name			= $_POST["user_name"];
		$user_prefix		= $_POST["user_prefix"];
		$user_phone			= $_POST["user_phone"];
		$user_hphone		= $_POST["user_hphone"];
		$user_email1		= $_POST["user_email1"];
		$user_email2		= $_POST["user_email2"];
		$user_homepage		= $_POST["user_homepage"];
		$user_zipcode		= $_POST["user_zipcode"];
		$user_addr1			= $_POST["user_addr1"];
		$user_addr2			= $_POST["user_addr2"];
		$user_bohun			= $_POST["user_bohun"];
		$user_jangae		= $_POST["user_jangae"];
		$user_army			= $_POST["user_army"];
		$user_army_start	= $_POST["user_army_start"];
		$user_army_end		= $_POST["user_army_end"];
		$user_army_type		= $_POST["user_army_type"];
		$user_image			= imageUpload("./upload/imsi","400","600","120","150","90","user_image","");
		$user_image2		= $_POST["user_image2"];
		$display			= $_POST["display"];


		#subMode2
		$job_where1_0		= $_POST["job_where1_0"];
		$job_where1_1		= $_POST["job_where1_1"];
		$job_where2_0		= $_POST["job_where2_0"];
		$job_where2_1		= $_POST["job_where2_1"];
		$job_where3_0		= $_POST["job_where3_0"];
		$job_where3_1		= $_POST["job_where3_1"];
		$job_type1			= $_POST["job_type1"];
		$job_type2			= $_POST["job_type2"];
		$job_type3			= $_POST["job_type3"];

		$type1				= $_POST["type1"];
		$type2				= $_POST["type2"];
		$type3				= $_POST["type3"];
		$type_sub1			= $_POST["type_sub1"];
		$type_sub2			= $_POST["type_sub2"];
		$type_sub3			= $_POST["type_sub3"];
		$type_sub_sub1		= $_POST["type_sub_sub1"];
		$type_sub_sub2		= $_POST["type_sub_sub2"];
		$type_sub_sub3		= $_POST["type_sub_sub3"];


		#subMode3
		$keyword			= $_POST["keyword"];


		#subMode4
		$grade_gtype		= $_POST["grade_gtype"];
		$grade_money		= $_POST["grade_money"];
		$grade_money2		= $_POST["grade_money2"];
		$grade_money_type	= $_POST["grade_money_type"];
		$grade_lastgrade	= $_POST["grade_lastgrade"];

		$grade1_endYear		= $_POST["grade1_endYear"];
		$grade1_schoolName	= $_POST["grade1_schoolName"];
		$grade1_schoolEnd	= $_POST["grade1_schoolEnd"];
		$grade1_schoolCity	= $_POST["grade1_schoolCity"];
		$grade1_schoolOur	= $_POST["grade1_schoolOur"];


		$grade2_startYear	= $_POST["grade2_startYear"];
		$grade2_endYear		= $_POST["grade2_endYear"];
		$grade2_endMonth	= $_POST["grade2_endMonth"];
		$grade2_point		= $_POST["grade2_point"];
		$grade2_pointBest	= $_POST["grade2_pointBest"];
		$grade2_schoolName	= $_POST["grade2_schoolName"];
		$grade2_schoolType	= $_POST["grade2_schoolType"];
		$grade2_schoolKwa	= $_POST["grade2_schoolKwa"];
		$grade2_schoolEnd	= $_POST["grade2_schoolEnd"];
		$grade2_schoolCity	= $_POST["grade2_schoolCity"];
		$grade2_schoolOur	= $_POST["grade2_schoolOur"];

		$grade3_startYear	= $_POST["grade3_startYear"];
		$grade3_endYear		= $_POST["grade3_endYear"];
		$grade3_endMonth	= $_POST["grade3_endMonth"];
		$grade3_point		= $_POST["grade3_point"];
		$grade3_pointBest	= $_POST["grade3_pointBest"];
		$grade3_schoolName	= $_POST["grade3_schoolName"];
		$grade3_schoolType	= $_POST["grade3_schoolType"];
		$grade3_schoolKwa	= $_POST["grade3_schoolKwa"];
		$grade3_schoolEnd	= $_POST["grade3_schoolEnd"];
		$grade3_schoolCity	= $_POST["grade3_schoolCity"];
		$grade3_schoolOur	= $_POST["grade3_schoolOur"];

		$grade4_startYear	= $_POST["grade4_startYear"];
		$grade4_endYear		= $_POST["grade4_endYear"];
		$grade4_endMonth	= $_POST["grade4_endMonth"];
		$grade4_point		= $_POST["grade4_point"];
		$grade4_pointBest	= $_POST["grade4_pointBest"];
		$grade4_schoolName	= $_POST["grade4_schoolName"];
		$grade4_schoolType	= $_POST["grade4_schoolType"];
		$grade4_schoolKwa	= $_POST["grade4_schoolKwa"];
		$grade4_schoolEnd	= $_POST["grade4_schoolEnd"];
		$grade4_schoolCity	= $_POST["grade4_schoolCity"];
		$grade4_schoolOur	= $_POST["grade4_schoolOur"];

		$grade5_startYear	= $_POST["grade5_startYear"];
		$grade5_endYear		= $_POST["grade5_endYear"];
		$grade5_endMonth	= $_POST["grade5_endMonth"];
		$grade5_lastSchoolType	= $_POST["grade5_lastSchoolType"];
		$grade5_point		= $_POST["grade5_point"];
		$grade5_pointBest	= $_POST["grade5_pointBest"];
		$grade5_schoolName	= $_POST["grade5_schoolName"];
		$grade5_schoolType	= $_POST["grade5_schoolType"];
		$grade5_schoolKwa	= $_POST["grade5_schoolKwa"];
		$grade5_schoolEnd	= $_POST["grade5_schoolEnd"];
		$grade5_schoolCity	= $_POST["grade5_schoolCity"];
		$grade5_schoolOur	= $_POST["grade5_schoolOur"];

		$grade6_startYear	= $_POST["grade6_startYear"];
		$grade6_endYear		= $_POST["grade6_endYear"];
		$grade6_endMonth	= $_POST["grade6_endMonth"];
		$grade6_lastSchoolType	= $_POST["grade6_lastSchoolType"];
		$grade6_point		= $_POST["grade6_point"];
		$grade6_pointBest	= $_POST["grade6_pointBest"];
		$grade6_schoolName	= $_POST["grade6_schoolName"];
		$grade6_schoolType	= $_POST["grade6_schoolType"];
		$grade6_schoolKwa	= $_POST["grade6_schoolKwa"];
		$grade6_schoolEnd	= $_POST["grade6_schoolEnd"];
		$grade6_schoolCity	= $_POST["grade6_schoolCity"];
		$grade6_schoolOur	= $_POST["grade6_schoolOur"];

		#subMode5
		$work_year			= $_POST["work_year"];
		$work_month			= $_POST["work_month"];
		$work_otherCountry	= $_POST["work_otherCountry"];
		$work_list			= $_POST["work_list"];


		#subMode6
		$fileName1			= $_POST["fileName1"];
		$fileName2			= $_POST["fileName2"];
		$fileName3			= $_POST["fileName3"];
		$fileName4			= $_POST["fileName4"];
		$fileName5			= $_POST["fileName5"];


		#subMode7
		$skill_word			= $_POST["skill_word"];
		$skill_ppt			= $_POST["skill_ppt"];
		$skill_excel		= $_POST["skill_excel"];
		$skill_search		= $_POST["skill_search"];
		$skill_list			= $_POST["skill_list"];
		$skill_etc			= $_POST["skill_etc"];


		#etc Field
		$etc1				= $_POST["etc1"];
		$etc2				= $_POST["etc2"];
		$etc3				= $_POST["etc3"];
		$etc4				= $_POST["etc4"];
		$etc5				= $_POST["etc5"];
		$etc6				= $_POST["etc6"];
		$etc7				= @implode(" ",$_POST["etc7"]);			#근무가능요일
		$etc8				= $_POST["etc8"];
		$etc9				= $_POST["etc9"];
		$etc10				= $_POST["etc10"];

		#etc Field 사용 체크
		$etc1_use			= $_POST['etc1_use'];
		$etc2_use			= $_POST['etc2_use'];
		$etc3_use			= $_POST['etc3_use'];
		$etc4_use			= $_POST['etc4_use'];
		$etc5_use			= $_POST['etc5_use'];
		$etc6_use			= $_POST['etc6_use'];
		$etc7_use			= $_POST['etc7_use'];
		$etc8_use			= $_POST['etc8_use'];
		$etc9_use			= $_POST['etc9_use'];
		$etc10_use			= $_POST['etc10_use'];

		#베이비시터 추가
		#근무시간
		$start_worktime = $_POST['work_time1']."-".$_POST['work_time2']."-".$_POST['work_time3'];
		$finish_worktime = $_POST['work_time4']."-".$_POST['work_time5']."-".$_POST['work_time6'];
		#구직자
		$guzicperson = $_POST['guzicperson'];
		#학력
		$guziceducation = $_POST['guziceducation'];
		#국적
		$guzicnational = $_POST['guzicnational'];
		#결혼
		$guzicmarried = $_POST['guzicmarried'];
		#자녀수
		$guzicchild = $_POST['guzicchild'];
		#자격증
		$guziclicence = $_POST['guziclicence'];
		$guziclicence_title = $_POST['guziclicence_title'];
		#파견업체
		$guzicsicompany = $_POST['guzicsicompany'];
		#베이비시터 추가

		//chi_first_name :한문성
		//chi_last_name : 한문이름
		//eng_first_name : 영문성
		//eng_last_name : 영문이름
		//HopeSize : 희망회사규모
		$chi_first_name = $_POST['chi_first_name'];
		$chi_last_name = $_POST['chi_last_name'];
		$eng_first_name = $_POST['eng_first_name'];
		$eng_last_name = $_POST['eng_last_name'];
		$HopeSize = $_POST['HopeSize'];

		//생년월일 추가
		$user_birth_year			= $_POST['user_birth_year'];
		$user_birth_month			= $_POST['user_birth_month'];
		$user_birth_day				= $_POST['user_birth_day'];


		//2010-10-05 hun 추가함!
		$sql = "select count(*) as ct from $type_tb where (number = '$type1' OR number = '$type2' OR number = '$type3') AND use_adult = 1; ";
		$result = query($sql);
		$adult_check_count = happy_mysql_fetch_array($result);

		if($adult_check_count[ct]){
			$use_adult = "1";
		}


		//선택사항 추가 항목 사용여부
		$skill_use_oa						= $_POST['oa'];
		$skill_use_license					= $_POST['license'];
		$skill_use_completion				= $_POST['completion'];
		$skill_use_foreign					= $_POST['foreign'];
		$skill_use_training					= $_POST['training'];
		$skill_use_givespecial				= $_POST['givespecial'];

		$SetSql				= "skill_use_oa					= '$skill_use_oa',";
		$SetSql				.= "skill_use_license			= '$skill_use_license',";
		$SetSql				.= "skill_use_completion			= '$skill_use_completion',";
		$SetSql				.= "skill_use_foreign			= '$skill_use_foreign',";
		$SetSql				.= "skill_use_training			= '$skill_use_training',";
		$SetSql				.= "skill_use_givespecial		= '$skill_use_givespecial'";


		$message	= " 프로필 작성 다음단계로 넘어갑니다.   ";
		if ( $subMode == "type1" || $subMode == "all" )
		{
			$Sql				= "SELECT user_name,user_jumin1,user_birth_year,user_prefix FROM $happy_member WHERE user_id='$user_id' ";
			$Tmp				= happy_mysql_fetch_array(query($Sql));

			$title				= $_POST["title"];
			$profile			= $_POST["profile"];
			//$user_name			= $_POST["user_name"];
			$user_name			= $Tmp["user_name"];
			$user_phone			= $_POST["user_phone"];
			$user_hphone		= $_POST["user_hphone"];
			$user_email1		= $_POST["user_email1"];
			$user_email2		= $_POST["user_email2"];
			$user_homepage		= $_POST["user_homepage"];
			$user_zipcode		= $_POST["user_zipcode"];
			$user_addr1			= $_POST["user_addr1"];
			$user_addr2			= $_POST["user_addr2"];
			$user_bohun			= $_POST["user_bohun"];
			$user_jangae		= $_POST["user_jangae"];
			$user_army			= $_POST["user_army"];
			$user_army_start	= $_POST["user_army_start_year"]."/".$_POST["user_army_start_month"];
			$user_army_end		= $_POST["user_army_end_year"]."/".$_POST["user_army_end_month"];
			$user_army_type		= $_POST["user_army_type"];
			$user_army_level	= $_POST["user_army_level"];
			//$user_image			= imageUpload($per_document_pic,$doc_pic_width[0],$doc_pic_height[0],$doc_pic_width[1],$doc_pic_height[1],"90","user_image","","","no");
			//$user_prefix		= ( $user_prefix == "남자" )?"man":"girl";
			$user_prefix		= $Tmp['user_prefix'];

			if ( $user_prefix == "남자" )
				$user_prefix = "man";
			if ( $user_prefix == "여자" )
				$user_prefix = "girl";

/*
			#관리자로 로그인해서 이력서를 수정해줄때
			if ( $_COOKIE["ad_id"] != "" && $number != "")
			{
				$Sql		= "SELECT user_id FROM $per_document_tb WHERE number='$number' ";
				$Tmp		= happy_mysql_fetch_array(query($Sql));
				$user_id	= $Tmp["user_id"];
			}
*/

			//$birth				= $Tmp['user_birth_year'];
			$birth				= $_POST["user_birth_year"];
			$user_age			= date("Y") - $birth + 1 ;

			$display			= ( $display == "" )?"Y":$display;

			#관리자가 등록하는 경우..
			if(!$user_id && $_COOKIE["ad_id"] != "")
			{
				$user_id = $_POST[user_id];
			}

			if(!$user_name && $_COOKIE["ad_id"] != "")
			{
				$user_name = $_POST[user_name];
			}

			//print_r2($_POST);
			//echo $user_name;exit;

			$SetSql			.= ( $SetSql != "" )?",":"";
			$SetSql			.= " title				= '$title'				";
			$SetSql			.= " ,profile			= '$profile'			";
			$SetSql			.= " ,user_id			= '$user_id'			";
			$SetSql			.= " ,user_name			= '$user_name'			";
			$SetSql			.= " ,user_prefix		= '$user_prefix'		";
			$SetSql			.= " ,user_age			= '$user_age'			";
			$SetSql			.= " ,user_phone		= '$user_phone'			";
			$SetSql			.= " ,user_hphone		= '$user_hphone'		";
			$SetSql			.= " ,user_email1		= '$user_email1'		";
			$SetSql			.= " ,user_email2		= '$user_email2'		";
			$SetSql			.= " ,user_homepage		= '$user_homepage'		";
			$SetSql			.= " ,user_zipcode		= '$user_zipcode'		";
			$SetSql			.= " ,user_addr1		= '$user_addr1'			";
			$SetSql			.= " ,user_addr2		= '$user_addr2'			";
			$SetSql			.= " ,user_bohun		= '$user_bohun'			";
			$SetSql			.= " ,user_jangae		= '$user_jangae'		";
			$SetSql			.= " ,user_army			= '$user_army'			";
			$SetSql			.= " ,user_army_start	= '$user_army_start'	";
			$SetSql			.= " ,user_army_end		= '$user_army_end'		";
			$SetSql			.= " ,user_army_type	= '$user_army_type'		";
			$SetSql			.= " ,user_army_level	= '$user_army_level'	";
			$SetSql			.= " ,display			= '$display'			";
			$SetSql			.= " ,start_worktime			= '$start_worktime'			";		#근무시간
			$SetSql			.= " ,finish_worktime			= '$finish_worktime'			";
			$SetSql			.= " ,guzicperson			= '$guzicperson'			";			#구직자
			$SetSql			.= " ,guziceducation			= '$guziceducation'			";			#학력
			$SetSql			.= " ,guzicnational			= '$guzicnational'			";			#국적
			$SetSql			.= " ,guzicmarried			= '$guzicmarried'			";			#결혼
			$SetSql			.= " ,guzicchild			= '$guzicchild'			";			#자녀수
			$SetSql			.= " ,guziclicence			= '$guziclicence'			";			#자격증
			$SetSql			.= " ,guziclicence_title			= '$guziclicence_title'			";			#자격증명
			$SetSql			.= " ,guzicsicompany			= '$guzicsicompany'			";			#파견업체
			$SetSql			.= " ,use_adult			= '$use_adult'			";			#파견업체
			$no_career		= ( $_POST['no_career'] == 'y' ) ? 'y' : 'n';
			$SetSql			.= " ,is_no_career			= '$no_career'			";			// 경력없음

			//필드추가됨
			$SetSql			.= " ,chi_first_name			= '$chi_first_name'			";
			$SetSql			.= " ,chi_last_name			= '$chi_last_name'			";
			$SetSql			.= " ,eng_first_name			= '$eng_first_name'			";
			$SetSql			.= " ,eng_last_name			= '$eng_last_name'			";
			$SetSql			.= " ,HopeSize			= '$HopeSize'			";

			//생년월일 추가
			$SetSql			.= " ,user_birth_year			= '$user_birth_year'			";
			$SetSql			.= " ,user_birth_month			= '$user_birth_month'			";
			$SetSql			.= " ,user_birth_day			= '$user_birth_day'			";

			/*
			if ( $user_image != '' )
				$SetSql		.= " ,user_image		= '$user_image'			";
			if ( $user_image == '' && $user_image2 != '' )
				$SetSql		.= " ,user_image		= '$user_image2'		";
			*/

			if ($user_image2 != '')
			{
				$SetSql		.= " ,user_image		= '$user_image2'		";
			}



			//echo $SetSql;exit;
			$msg	= "수정 되었습니다.";
			$goUrl	= "document.php?mode=add&subMode=type2&number=$number";
		}


		if ( $subMode == "type2" || $subMode == "all" )
		{
			#valueprint($_POST , 0);

			$msg	= "등록되었습니다.";
			$goUrl	= "document.php?mode=add&subMode=type3&number=$number";

			#일단 체크박스 내용들을 담아불자
			for ( $i=0, $max=sizeof($_POST["job_type_sub"]) ; $i<$max ; $i++ )
			{
				$job_type_sub[$i]	= explode(":",$_POST["job_type_sub"][$i]);
			}

			if ( $subMode == 'all' )
			{
				$job_type_sub[0][0]		= $type1;
				$job_type_sub[1][0]		= $type2;
				$job_type_sub[2][0]		= $type3;
				$job_type_sub[0][1]		= $type_sub1;
				$job_type_sub[1][1]		= $type_sub2;
				$job_type_sub[2][1]		= $type_sub3;
				$job_type_sub[0][2]		= $type_sub_sub1;
				$job_type_sub[1][2]		= $type_sub_sub2;
				$job_type_sub[2][2]		= $type_sub_sub3;
			}

			//print_r($job_type_sub

			$SetSql			.= ( $SetSql != "" )?",":"";
			$SetSql			.= "  job_where1_0		= '$job_where1_0'		";
			$SetSql			.= " ,job_where1_1		= '$job_where1_1'		";
			$SetSql			.= " ,job_where2_0		= '$job_where2_0'		";
			$SetSql			.= " ,job_where2_1		= '$job_where2_1'		";
			$SetSql			.= " ,job_where3_0		= '$job_where3_0'		";
			$SetSql			.= " ,job_where3_1		= '$job_where3_1'		";
			$SetSql			.= " ,job_type1			= '".$job_type_sub[0][0]."'	";
			$SetSql			.= " ,job_type2			= '".$job_type_sub[1][0]."'	";
			$SetSql			.= " ,job_type3			= '".$job_type_sub[2][0]."'	";
			$SetSql			.= " ,job_type_sub1		= '".$job_type_sub[0][1]."'	";
			$SetSql			.= " ,job_type_sub2		= '".$job_type_sub[1][1]."'	";
			$SetSql			.= " ,job_type_sub3		= '".$job_type_sub[2][1]."'	";
			$SetSql			.= " ,job_type_sub_sub1	= '".$job_type_sub[0][2]."'	";
			$SetSql			.= " ,job_type_sub_sub2	= '".$job_type_sub[1][2]."'	";
			$SetSql			.= " ,job_type_sub_sub3	= '".$job_type_sub[2][2]."'	";

		}

		if ( $subMode == "type3" || $subMode == "all" )
		{
			$SetSql			.= ( $SetSql != "" )?",":"";
			$SetSql			.= "  keyword			= '$keyword'			";

			$msg	= "등록되었습니다.";
			$goUrl	= "document.php?mode=add&subMode=type4&number=$number";

		}

		if ( $subMode == "type4" || $subMode == "all" )
		{
			$grade_gtype = @implode(",", (array) $grade_gtype);

			$grade_money	= $grade_money_type == '' ? $grade_money2 : $grade_money;

			$SetSql			.= ( $SetSql != "" )?",":"";
			$SetSql	.= "
					grade_gtype			= '$grade_gtype',
					grade_money			= '$grade_money',
					grade_money_type	= '$grade_money_type',
					grade_lastgrade		= '$grade_lastgrade',
					grade1_endYear		= '$grade1_endYear',
					grade1_schoolName	= '$grade1_schoolName',
					grade1_schoolEnd	= '$grade1_schoolEnd',
					grade1_schoolCity	= '$grade1_schoolCity',
					grade1_schoolOur	= '$grade1_schoolOur',

					grade2_startYear	= '$grade2_startYear',
					grade2_endYear		= '$grade2_endYear',
					grade2_endMonth		= '$grade2_endMonth',
					grade2_point		= '$grade2_point',
					grade2_pointBest	= '$grade2_pointBest',
					grade2_schoolName	= '$grade2_schoolName',
					grade2_schoolType	= '$grade2_schoolType',
					grade2_schoolKwa	= '$grade2_schoolKwa',
					grade2_schoolEnd	= '$grade2_schoolEnd',
					grade2_schoolCity	= '$grade2_schoolCity',
					grade2_schoolOur	= '$grade2_schoolOur',

					grade3_startYear	= '$grade3_startYear',
					grade3_endYear		= '$grade3_endYear',
					grade3_endMonth		= '$grade3_endMonth',
					grade3_point		= '$grade3_point',
					grade3_pointBest	= '$grade3_pointBest',
					grade3_schoolName	= '$grade3_schoolName',
					grade3_schoolType	= '$grade3_schoolType',
					grade3_schoolKwa	= '$grade3_schoolKwa',
					grade3_schoolEnd	= '$grade3_schoolEnd',
					grade3_schoolCity	= '$grade3_schoolCity',
					grade3_schoolOur	= '$grade3_schoolOur',

					grade4_startYear	= '$grade4_startYear',
					grade4_endYear		= '$grade4_endYear',
					grade4_endMonth		= '$grade4_endMonth',
					grade4_point		= '$grade4_point',
					grade4_pointBest	= '$grade4_pointBest',
					grade4_schoolName	= '$grade4_schoolName',
					grade4_schoolType	= '$grade4_schoolType',
					grade4_schoolKwa	= '$grade4_schoolKwa',
					grade4_schoolEnd	= '$grade4_schoolEnd',
					grade4_schoolCity	= '$grade4_schoolCity',
					grade4_schoolOur	= '$grade4_schoolOur',

					grade5_startYear	= '$grade5_startYear',
					grade5_endYear		= '$grade5_endYear',
					grade5_endMonth		= '$grade5_endMonth',
					grade5_point		= '$grade5_point',
					grade5_pointBest	= '$grade5_pointBest',
					grade5_schoolName	= '$grade5_schoolName',
					grade5_schoolType	= '$grade5_schoolType',
					grade5_schoolKwa	= '$grade5_schoolKwa',
					grade5_schoolEnd	= '$grade5_schoolEnd',
					grade5_schoolCity	= '$grade5_schoolCity',
					grade5_schoolOur	= '$grade5_schoolOur',

					grade6_startYear	= '$grade6_startYear',
					grade6_endYear		= '$grade6_endYear',
					grade6_endMonth		= '$grade6_endMonth',
					grade6_point		= '$grade6_point',
					grade6_pointBest	= '$grade6_pointBest',
					grade6_schoolName	= '$grade6_schoolName',
					grade6_schoolType	= '$grade6_schoolType',
					grade6_schoolKwa	= '$grade6_schoolKwa',
					grade6_schoolEnd	= '$grade6_schoolEnd',
					grade6_schoolCity	= '$grade6_schoolCity',
					grade6_schoolOur	= '$grade6_schoolOur'
			";

			$msg	= "등록되었습니다.";
			$goUrl	= "document.php?mode=add&subMode=type5&number=$number";

		}

		if ( $subMode == "type5" || $subMode == "all" )
		{
			$SetSql			.= ( $SetSql != "" )?",":"";
			$SetSql	.= "
				work_year			= '$work_year',
				work_month			= '$work_month',
				work_otherCountry	= '$work_otherCountry',
				work_list			= '$work_list'
			";

			//echo $work_month;
			$max		= $_POST["worklist_size"];
			$pNumber	= $number;

			#관리자가 등록하는 경우..
			if($user_id != "" && $_COOKIE["ad_id"] != "")
			{
				$userid = $user_id;
			}
			//else
			//{
				$Sql2	= "DELETE FROM $per_worklist_tb WHERE pNumber='$pNumber' AND userid='$userid' ";
				query($Sql2);
			//}

			for ( $i=1 ; $i<=$max ; $i++ )
			{
				$startYear		= $_POST["startYear__".$i];
				$startMonth		= $_POST["startMonth__".$i];
				$endYear		= $_POST["endYear__".$i];
				$endMonth		= $_POST["endMonth__".$i];
				$status			= $_POST["status__".$i];
				$company_name	= $_POST["company_name__".$i];
				$company_type	= $_POST["company_type__".$i];
				$job_type		= $_POST["job_type__".$i];
				$job_part		= $_POST["job_part__".$i];
				$job_content	= $_POST["job_content__".$i];
				$job_level		= $_POST["job_level__".$i];
				$job_money		= $_POST["job_money__".$i];
				$display1		= $_POST["display1__".$i];
				$display2		= $_POST["display2__".$i];
				#삭제 추가
				$delete_worklist  = $_POST["delete_worklist__".$i];

				if ( $display2 == "N" && $status != "재직중" )
					$display2	= "YN";

				$display1		= ( $display1 == "" )?"Y":$display1;
				$display2		= ( $display2 == "" )?"Y":$display2;

				if ( $company_name != "" )
				{
					$Sql2	= "
						INSERT INTO
								$per_worklist_tb
						SET
								pNumber			= '$pNumber',
								userid			= '$userid',
								startYear		= '$startYear',
								startMonth		= '$startMonth',
								endYear			= '$endYear',
								endMonth		= '$endMonth',
								status			= '$status',
								company_name	= '$company_name',
								company_type	= '$company_type',
								job_type		= '$job_type',
								job_part		= '$job_part',
								job_content		= '$job_content',
								job_level		= '$job_level',
								job_money		= '$job_money',
								display1		= '$display1',
								display2		= '$display2'
					";


					if (!$delete_worklist) {
						query($Sql2);
					}
				}
			}


			$msg	= "등록되었습니다.";
			$goUrl	= "document.php?mode=add&subMode=type6&number=$number";
		}

		if ( $subMode == "type6" || $subMode == "all" )
		{
			$extCheck	= "jpg/jpeg/png/gif/zip/rar/ppt/doc/xls";

			//이력서 등록시 첨부파일 고유번호 2013-08-23 kad
			$TmpUpload = array();
			//이력서 등록시 첨부파일 고유번호 2013-08-23 kad

			for ( $i=1 ; $i<=5 ; $i++ )
			{
				if ( $_FILES["file".$i]["name"] != "" )
				{
					$tmp			= explode(".", $_FILES["file".$i]["name"]);
					$ext			= strtolower($tmp[sizeof($tmp)-1]);

					//이력서 등록시 첨부파일 고유번호 2013-08-23 kad
					if ( $number == "" )
					{
						$file1			= $userid ."_{gou_number}_". $i ;
						$TmpUpload[] = $per_document_file ."/". $file1;
					}
					else
					{
						$file1			= $userid ."_".$number."_". $i ;
					}
					//이력서 등록시 첨부파일 고유번호 2013-08-23 kad

					if ( !eregi($ext,$extCheck) )
					{
						error("JPG, JPEG, PNG, GIF, ZIP, RAR, PPT, DOC, PPT, XLS 확장자만 업로드 가능합니다.");
						exit;
					}
					$uploadfile		= $per_document_file ."/". $file1;
					move_uploaded_file($_FILES["file".$i]["tmp_name"], $uploadfile);

					#$filename		= $uploadfile	."__kwak__". $_FILES["file".$i]["name"];
					$filename		= $_FILES["file".$i]["name"];

					$SetSql			.= ( $SetSql != "" )?",":"";
					$SetSql			.= " fileName${i}	= '$filename' ";
				}
				else if ( $_POST["file".$i."_del"] == "ok" )
				{
					$SetSql			.= ( $SetSql != "" )?",":"";
					$SetSql			.= " fileName${i}	= '' ";
				}
			}


			$msg	= "등록되었습니다.";
			$goUrl	= "document.php?mode=add&subMode=type7&number=$number";
		}

		if ( $subMode == "type7" || $subMode == "all" )
		{

			$SetSql			.= ( $SetSql != "" )?",":"";
			$SetSql	.= "
				skill_word			= '$skill_word',
				skill_ppt			= '$skill_ppt',
				skill_excel			= '$skill_excel',
				skill_search		= '$skill_search',
				skill_list			= '$skill_list',
				skill_etc			= '$skill_etc'
			";

			$max1		= $_POST["worklist_size1"];
			$max2		= $_POST["worklist_size2"];
			$max3		= $_POST["worklist_size3"];
			$pNumber	= $number;

			#echo nl2br($SetSql);

			//echo "<hr> $max1 - $max2 - $max3 <hr>";exit;






			#관리자가 등록하는 경우..
			if($user_id != "" && $_COOKIE["ad_id"] != "")
			{
				$userid = $user_id;
			}
			//else
			//{
				$Sql2	= "DELETE FROM $per_skill_tb WHERE userid='$userid' ";
				query($Sql2);
			//}

			for ( $i=1 ; $i<$max1 ; $i++ )
			{
				$skill_name		= $_POST["skill_name__".$i];
				$skill_from		= $_POST["skill_from__".$i];
				$skill_getYear	= $_POST["skill_getYear__".$i];
				$skill_getMonth	= $_POST["skill_getMonth__".$i];
				$skill_getDay	= $_POST["skill_getDay__".$i];
				#삭제기능추가
				$skill_delete = $_POST["delete_skill__".$i];

				if ( $skill_name != "" )
				{
					$Sql2	= "
						INSERT INTO
								$per_skill_tb
						SET
								userid			= '$userid',
								skill_name		= '$skill_name',
								skill_from		= '$skill_from',
								skill_getYear	= '$skill_getYear',
								skill_getMonth	= '$skill_getMonth',
								skill_getDay	= '$skill_getDay'
					";

					if (!$skill_delete) {
						query($Sql2);
					}
					#echo nl2br($Sql2);
				}
			}


			#관리자가 등록하는 경우..
			if($user_id != "" && $_COOKIE["ad_id"] != "")
			{
				$userid = $user_id;
			}
			//else
			//{
				$Sql2	= "DELETE FROM $per_language_tb WHERE userid='$userid' ";
				query($Sql2);
			//}

			for ( $i=1 ; $i<=$max2 ; $i++ )
			{
				$language_title	= $_POST["language_title__".$i];
				$language_skill	= $_POST["language_skill__".$i];
				$language_check	= $_POST["language_check__".$i];
				$language_point	= $_POST["language_point__".$i];
				$language_level	= $_POST["language_level__".$i];
				$language_year	= $_POST["language_year__".$i];
				$language_month	= $_POST["language_month__".$i];
				$language_day	= $_POST["language_day__".$i];
				#삭제기능추가
				$delete_language = $_POST["delete_language_skill__".$i];

				if ( $language_skill != "" )
				{
					$Sql2	= "
						INSERT INTO
								$per_language_tb
						SET
								userid			= '$userid',
								language_title	= '$language_title',
								language_skill	= '$language_skill',
								language_check	= '$language_check',
								language_point	= '$language_point',
								language_level	= '$language_level',
								language_year	= '$language_year',
								language_month	= '$language_month',
								language_day	= '$language_day'
					";
					//echo nl2br($Sql2);

					if (!$delete_language) {
						query($Sql2);
					}
					//echo nl2br($Sql2);
				}
			}

			//print_r2($_POST);
			//exit;

			#관리자가 등록하는 경우..
			if($user_id != "" && $_COOKIE["ad_id"] != "")
			{
				$userid = $user_id;
			}
			//else
			//{
				$Sql2	= "DELETE FROM $per_yunsoo_tb WHERE userid='$userid' ";
				query($Sql2);
			//}

			for ( $i=1 ; $i<=$max3 ; $i++ )
			{
				$country		= $_POST["country__".$i];
				$startYear		= $_POST["startYear__".$i];
				$startMonth		= $_POST["startMonth__".$i];
				$endYear		= $_POST["endYear__".$i];
				$endMonth		= $_POST["endMonth__".$i];
				$content		= $_POST["content__".$i];
				#삭제기능추가
				$delete_yunsoo = $_POST["delete_yunsoo__".$i];


				if ( $country != "" && $startYear != "" )
				{
					$Sql2	= "
						INSERT INTO
								$per_yunsoo_tb
						SET
								userid			= '$userid',
								country			= '$country',
								startYear		= '$startYear',
								startMonth		= '$startMonth',
								endYear			= '$endYear',
								endMonth		= '$endMonth',
								content			= '$content'
					";


					if (!$delete_yunsoo) {
						query($Sql2);
					}
					#echo nl2br($Sql2);
				}
			}


			#echo "프로그래밍중";exit;


			$msg	= "등록 및 수정 되었습니다.";
			$goUrl	= "html_file_per.php?file=member_regph.html";
			//$goUrl	= "happy_member.php?mode=mypage";
		}


		#ETC 필드 사용시 DB에 같이 처리 ( etc1_use ~ etc10_use 히든값이 존재할경우 DB처리가 됨 )
		for ( $etcNumb=1 ; $etcNumb <= 10 ; $etcNumb++ )
		{
			if ( ${'etc'.$etcNumb.'_use'} != '' )
			{
				$SetSql			.= ( $SetSql != "" )?",":"";
				$SetSql			.= " etc".$etcNumb." = '".${'etc'.$etcNumb}."' ";
			}
		}

		//모바일에서 구인등록
		if( $_COOKIE['happy_mobile'] == 'on' )
		{
			$SetSql.= ",regist_mobile		= 'y'";
		}
		else
		{
			$SetSql.= ",regist_mobile		= 'n'";
		}

		//print_r2($_POST);exit;
		//print_r2($number);exit;

		if ( $number != "" )
		{
			$Sql	 = "	UPDATE										";
			$Sql	.= "			$per_document_tb					";
			$Sql	.= "	SET											";
			$Sql	.= "			$SetSql								";
			$Sql	.= "			,modifydate = now()					";
			$Sql	.= "	WHERE										";
			$Sql	.= "			number = '$number'					";

			#echo $Sql; exit;
		}
		else if ( $mode == "addAction" && $number == "" && ( $subMode == "type1" || $subMode == 'all' ) )
		{
			$Sql	 = "	INSERT INTO									";
			$Sql	.= "			$per_document_tb					";
			$Sql	.= "	SET											";
			$Sql	.= "			$SetSql								";
			$Sql	.= "			,regdate = now()					";
			$Sql	.= "			,modifydate = now()					";

			#메일보내기
			//print_r($_POST);
			$subject = "구직정보가 등록이 되었습니다";
			$TPL = new Template;
			$TPL->define("구직정보등록",$GLOBALS['skin_folder']."/email_doc_add.html");
			$guzic_email = $_POST['user_email1'];
			$GLOBALS['현재날짜'] = date("Y-m-d");
			$GLOBALS['현재시간'] = date("H:i:s");
			$GLOBALS['자기소개'] = nl2br($_POST['profile']);
			$content = &$TPL->fetch();
			//echo $content;
			//$guzic_email = 'kadrien@happycgi.com';

			#메일 보내기 함수 ( 보내는사람 , 받는사람 , 메일제목, 메일내용)
			sendmail($GLOBALS['admin_email'], $guzic_email, $subject, $content);
			#메일보내기
		}
		else
		{
			$error	= " 프로필의 기본정보를 작성해주세요.   ";
		}
		//echo $Sql."<br><hr>";exit;

		if ( $mode == "modifyAction" )
		{
			$goUrl	= "document.php?mode=modify&subMode=$subMode&number=$number";
			$msg	= " 수정되었습니다.   ";
		}

		if ( $error == "" )
		{
			if ( $SetSql != "" )
				query($Sql);

			if ( $number == "" )
			{
				$sql = "SELECT LAST_INSERT_ID();";
				$result = query($sql);
				list($idx)= mysql_fetch_row($result);

				//이력서 등록시 첨부파일 고유번호 2013-08-23 kad
				if ( count($TmpUpload) >= 1 )
				{
					foreach($TmpUpload as $k => $v)
					{
						$v2 = str_replace("{gou_number}",$idx,$v);
						@rename($v,$v2);
					}
				}
				//이력서 등록시 첨부파일 고유번호 2013-08-23 kad
			}
			else
			{
				$idx = $number;
			}

			// 학력사항, 경력사항
			if( $idx != '' )
			{
				global $per_academy_tb, $per_career_tb;
				// 학력사항
				$cnt_insert	= sizeof($_POST['academy_in']);

				$sql	= "DELETE FROM {$per_academy_tb} WHERE doc_number = '{$idx}'";
				query($sql);

				for($i = 1; $i < $cnt_insert; $i++)
				{
					$academy_in			= $_POST['academy_in'][$i];
					$academy_out		= $_POST['academy_out'][$i];
					$academy_out_type	= $_POST['academy_out_type'][$i];
					$academy_name		= $_POST['academy_name'][$i];
					$academy_degree		= $_POST['academy_degree'][$i];

					if( $academy_in != '' || $academy_out != '' || $academy_out_type != '' || $academy_name != '' || $academy_degree != '' )
					{
						$sql	= "
									INSERT INTO
												{$per_academy_tb}
									SET
												doc_number			= '{$idx}',
												academy_in			= '{$academy_in}',
												academy_out			= '{$academy_out}',
												academy_out_type	= '{$academy_out_type}',
												academy_name		= '{$academy_name}',
												academy_degree		= '{$academy_degree}'
						";
						query($sql);
					}
				}

				// 경력사항
				// 경력없을땐 실행할 필요가 없다
				if( $no_career != 'y' )
				{
					$cnt_insert	= sizeof($_POST['career_work_name']);

					$sql	= "DELETE FROM {$per_career_tb} WHERE doc_number = '{$idx}'";
					query($sql);

					for($i = 1; $i < $cnt_insert; $i++)
					{
						$career_area					= $_POST['career_area_' . $i];
						$career_work_name				= $_POST['career_work_name'][$i];
						$career_work_name_nodisplay		= $_POST['career_work_name_nodisplay_' . $i];
						$career_work_name_nodisplay		= ( $career_work_name_nodisplay == 'y' ) ? 'y' : 'n';
						$career_type					= $_POST['career_type'][$i];
						$career_type_sub				= $_POST['career_type_sub'][$i];
						$career_type_sub_sub			= $_POST['career_type_sub_sub'][$i];
						$career_in						= $_POST['career_in'][$i];
						$career_out						= $_POST['career_out'][$i];
						$career_duty					= $_POST['career_duty'][$i];
						$career_work_type				= $_POST['career_work_type'][$i];
						$career_msg						= $_POST['career_msg'][$i];

						if( $career_work_name != '' || $career_type != '' || $career_in != '' || $career_out != '' || $career_duty != '' || $career_work_type != '' || $career_msg != '' )
						{
							$career_work_type				= ( $career_work_type == '재직중' ) ? 'in' : 'out';

							$sql	= "
										INSERT INTO
													{$per_career_tb}
										SET
													doc_number					= '{$idx}',
													career_area					= '{$career_area}',
													career_work_name			= '{$career_work_name}',
													career_work_name_nodisplay	= '{$career_work_name_nodisplay}',
													career_type					= '{$career_type}',
													career_type_sub				= '{$career_type_sub}',
													career_type_sub_sub			= '{$career_type_sub_sub}',
													career_in					= '{$career_in}',
													career_out					= '{$career_out}',
													career_duty					= '{$career_duty}',
													career_work_type			= '{$career_work_type}',
													career_msg					= '{$career_msg}'
							";
							//echo $sql . '<br />';
							query($sql);
						}
					}
				}
				else
				{
					// 경력 없다면, 혹 기존 입력된 경력은 삭제 한다.
					$sql	= "DELETE FROM {$per_career_tb} WHERE doc_number = '{$idx}'";
					query($sql);
				}
			}

			//인접매물 업데이트 2013-03-08 kad
			//주소를 바로 입력받아서 좌표구하는 형태
			$now_number = $idx;
			$user_addr1 = $_POST['user_addr1'];
			$user_addr2 = $_POST['user_addr2'];

			if ( $user_addr1 != '' && $user_addr2 != '' )
			{

				$nowAddr		= $user_addr1.' '.$user_addr2;

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
									$per_document_tb
							SET
									x_do		= '$wgsArr[x_do]',
									x_min		= '$wgsArr[x_min]',
									x_sec		= '$wgsArr[x_sec]',
									y_do		= '$wgsArr[y_do]',
									y_min		= '$wgsArr[y_min]',
									y_sec		= '$wgsArr[y_sec]',
									x_point		= '$wgsArr[x_point]',
									y_point		= '$wgsArr[y_point]',
									x_point2	= '$wgsArr[x_point2]',
									y_point2	= '$wgsArr[y_point2]'
							WHERE
									number		= '$now_number'
				";
				//echo $Sql."<br>";

				query($Sql);
			}
			else
			{
				$x_do		= '';
				$x_min		= '';
				$x_sec		= '';

				$y_do		= '';
				$y_min		= '';
				$y_sec		= '';

				$x_point	= '';
				$y_point	= '';

				$x_point2	= '';
				$y_point2	= '';

				$Sql	= "
							UPDATE
									$per_document_tb
							SET
									x_do		= '$x_do',
									x_min		= '$x_min',
									x_sec		= '$x_sec',
									y_do		= '$y_do',
									y_min		= '$y_min',
									y_sec		= '$y_sec',
									x_point		= '$x_point',
									y_point		= '$y_point',
									x_point2	= '$x_point2',
									y_point2	= '$y_point2'
							WHERE
									number	= '$now_number'
				";
				query($Sql);
			}
			//exit;
			//인접매물 업데이트


		}
		else
		{
			error($error);
			exit;
		}

		$go_pay_page = false;

		if ( $mode == "addAction" && $number == "" )
		{
			#등록
			$Sql	= "SELECT number FROM $per_document_tb WHERE user_id='$user_id' ORDER BY number desc";
			$Temp	= happy_mysql_fetch_array(query($Sql));

			$goUrl	.= "&number=$Temp[0]";
			$number	= $Temp[0];

			#등록이후 결제페이지로
			if ( $CONF['paid_conf'] && happy_member_secure($happy_member_secure_text[0].'유료결제') )
			{
				$go_pay_page = true;
			}
			else
			{
				$go_pay_page = false;
			}
			#등록이후 결제페이지로
		}




		##### 이미지 파일 등록 루틴 시작 #####
		if ( ( $subMode == "type6" || $subMode == "all" ) && $doc_mini_album_use == '1' )
		{
			$Sql	= "DELETE FROM $per_file_tb WHERE userid='$userid' AND doc_number='$number' ";
			query($Sql);
			for ( $i=0; $i<20; $i++ )
			{

				if ( preg_match("/swfupload/",$_POST["img".$i]) )
				{

					$doc_img_path2	= $doc_img_path.$userid;
					if(!is_dir($doc_img_path2)) mkdir($doc_img_path2, 0777);
					@chmod($doc_img_path2, 0777);

					#echo $doc_img_path2;exit;

					$rand_number =  rand(0,10000);
					$rand_number2 =  rand(0,100);
					$temp_name = explode(".",$_POST["img".$i]);
					$ext = strtolower($temp_name[sizeof($temp_name)-1]);
					$ext_file_name = strtolower($temp_name[sizeof($temp_name)-2]);
					$img_url_re			= "$doc_img_path2/${now_time}${rand_number2}-$number-${rand_number}.$ext";
					#$img_url_re_big		= "$doc_img_path2/${now_time}${rand_number2}-$number-${rand_number}_big.$ext";
					$img_url_re_thumb	= "$doc_img_path2/${now_time}${rand_number2}-$number-${rand_number}_thumb.$ext";
					$img_url_file_name	= "${doc_img_url}${userid}/${now_time}${rand_number2}-$number-${rand_number}((thumb_name)).$ext";

					if ( $ext=="html" || $ext=="htm" || $ext=="php" || $ext=="cgi" || $ext=="inc" || $ext=="php3" || $ext=="pl" )
					{
						error("$ext 확장자는 등록할수 없습니다.");
						exit;
					}

					/*	멀티업로드 html5 로 바꾸면서 같이 수정함. 왠 copy 냐??
					copy(str_replace("_thumb","",$folder_name."/".$_POST["img".$i]),"$img_url_re");
					copy(str_replace("_thumb","_big",$folder_name."/".$_POST["img".$i]),"$img_url_re_big");
					copy(str_replace("_thumb","_thumb",$folder_name."/".$_POST["img".$i]),"$img_url_re_thumb");
					*/

					rename("$folder_name/${ext_file_name}.$ext","$img_url_re");
					@unlink("$folder_name/${ext_file_name}_thumb.$ext");
					#rename("$folder_name/${ext_file_name}_thumb.$ext","$img_url_re_thumb");

					$Sql	= "
								INSERT INTO
										$per_file_tb
								SET
										userid		= '$userid',
										doc_number	= '$number',
										fileName	= '$img_url_file_name'
					";
					query($Sql);

				}
				else if ( $_POST['img'.$i] != '' )
				{
					$_POST['img'.$i]	= str_replace("_thumb","((thumb_name))", $_POST['img'.$i]);
					$Sql	= "
								INSERT INTO
										$per_file_tb
								SET
										userid		= '$userid',
										doc_number	= '$number',
										fileName	= '". $_POST['img'.$i] ."'
					";

					#echo $Sql."<br><br>";
					query($Sql);
				}
			}
			#exit;
			//쓰레기 임시 파일 삭제하기 //
			if(is_dir($folder_name)) {
				$dir_obj=opendir($folder_name);
				while(($file_str = readdir($dir_obj))!==false){
					if($file_str!="." && $file_str!=".."){
						@unlink($folder_name."/".$file_str);
					}
				}
				closedir($dir_obj);
				rmdir($folder_name);
			}

		}
		################ 이미지파일등록끝

		$goUrl	= ( $returnUrl == "" )?$goUrl:$returnUrl;
		if($_POST[history] == "admin"){
			msgclose("등록이 완료되었습니다.");
		}
		else if ( $go_pay_page )
		{

			echo '
			<form action="my_pay2.php" method="post" name="payform">
			<input type="hidden" name="number" value='.$number.'>
			<input type="hidden" name="type" value='.$_POST['pay_type'].'>
			<input type="hidden" name="total_price" value='.$_POST['total_price'].'>
			<input type="hidden" name="jumin1" value='.$_POST['jumin1'].'>
			<input type="hidden" name="jumin2" value='.$_POST['jumin2'].'>
			<input type="hidden" name="gou_number" value='.$_POST['gou_number'].'>
			<input type="hidden" name="guin_special" value='.$_POST['guin_special'].'>
			<input type="hidden" name="guin_focus" value='.$_POST['guin_focus'].'>
			<input type="hidden" name="guin_powerlink" value='.$_POST['guin_powerlink'].'>
			<input type="hidden" name="guin_docskin" value='.$_POST['guin_docskin'].'>
			<input type="hidden" name="doc_skin" value='.$_POST['doc_skin'].'>
			<input type="hidden" name="guin_icon" value='.$_POST['guin_icon'].'>
			<input type="hidden" name="guin_bolder" value='.$_POST['guin_bolder'].'>
			<input type="hidden" name="guin_color" value='.$_POST['guin_color'].'>
			<input type="hidden" name="guin_freeicon" value='.$_POST['guin_freeicon'].'>
			<input type="hidden" name="freeicon" value='.$_POST['freeicon'].'>
			<input type="hidden" name="guin_bgcolor" value='.$_POST['guin_bgcolor'].'>
			<input type="hidden" name="GuzicUryoDate1" value='.$_POST['GuzicUryoDate1'].'>
			<input type="hidden" name="GuzicUryoDate2" value='.$_POST['GuzicUryoDate2'].'>
			<input type="hidden" name="GuzicUryoDate3" value='.$_POST['GuzicUryoDate3'].'>
			<input type="hidden" name="GuzicUryoDate4" value='.$_POST['GuzicUryoDate4'].'>
			<input type="hidden" name="GuzicUryoDate5" value='.$_POST['GuzicUryoDate5'].'>
			</form>
			<script>document.payform.submit();</script>
			';
		}
		else
		{
			gomsg($msg , $goUrl);
		}
	}



	#######################################################################################################################


	function uryo()
	{
		global $userid, $number, $per_document_tb, $CONF, $TPL;
		global $demo, $skin_folder;
		global $pay_java, $PAY ;
		global $Sty;
		global $frm;
		global $PER_ARRAY_NAME;
		global $PER_ARRAY_DB;
		global $HAPPY_CONFIG;
		global $per_document_tb,$doc_skinfilename,$Data;
		global $skin_checked1,$skin_checked2,$skin_checked3,$skin_checked4;
		global $회원정보;

		//이력서 등록시 오류가 나서 조건문 추가 유료신청페이지일 때만 : YOON : 2011-11-28
		if($_GET["mode"] == "uryo")
		{
			//이력서정보 : ranksa : 2011-11-28 add
			$Sql		= "SELECT skin_html,skin_date FROM $per_document_tb WHERE number=$number AND user_id = '$userid' ";
			$Record		= query($Sql);
			$Data		= happy_mysql_fetch_assoc($Record);

			if ( $Data["skin_html"] == "" || $Data["skin_date"] < date("Y-m-d") )
			{
				$Data["skin_html"]	= "기본 이력서스킨";
				$Data["skin_date"]	= "";
			} else {
				$Data["skin_html"] = $doc_skinfilename[$Data["skin_html"]];
				$Data["skin_date"] = "(~".$Data["skin_date"]."까지)";
			}

			switch ( $Data["skin_html"] )
			{
				case "1번스킨"		: $skin_checked1	= " checked ";break;
				case "2번스킨"		: $skin_checked2	= " checked ";break;
				case "3번스킨"		: $skin_checked3	= " checked ";break;
				case "4번스킨"		: $skin_checked4	= " checked ";break;
			}
		}



		//결제요청시 팝업 / 프레임 / 액티브엑스설치 처리 통합결제모듈 ranksa
		$pay_frame = "";
		$pay_frame = '<iframe width="100%" height="200" name="pay_page" id="pay_page" style="display:none;"></iframe>';

		$pay_button_script		= "";
		if( $_COOKIE['happy_mobile'] != 'on' )
		{
			$pay_button_script = 'myform.target = "pay_page";';
		}


		if ( !isset($frm) )
		{
			#기존결제페이지
			$frm = 'payform';

			$pay_phone_script = $pay_button_script.'
			myform.action = "my_pay2.php?type=phone";
			myform.submit();
			';
			$pay_card_script = $pay_button_script.'
			myform.action = "my_pay2.php?type=card";
			myform.submit();
			';
			$pay_bank_script = $pay_button_script.'
			myform.action = "my_pay2.php?type=bank";
			myform.submit();
			';
			$pay_bank_soodong_script = '
			myform.target = "_top";
			myform.action = "my_pay2.php?type=bank_soodong";
			myform.submit();
			';
			$pay_point_script = '
			myform.target = "_top";
			myform.action = "my_pay2.php?type=point";
			myform.submit();
			';
			$necessary_javascriptscript = '
			if (is_sel == false)
			{
				alert("옵션을 하나라도 선택을 하셔야만 합니다");
				return false;
			}
			';

			#필수결제항목 체크
			#$names		= Array("guin_special","guin_focus","guin_powerlink","guin_docskin","guin_icon","guin_bolder","guin_color","guin_freeicon","guin_bgcolor","GuzicUryoDate1","GuzicUryoDate2","GuzicUryoDate3","GuzicUryoDate4","GuzicUryoDate5");
			global $PER_ARRAY;
			$option_fields = "";
			for ( $i=0; $i<14; $i++ )
			{
				$option_fields .= "$comma $PER_ARRAY[$i] ";
				$comma = ",";
			}

			$Sql		= "SELECT $option_fields FROM $per_document_tb WHERE number='$number' ";
			//echo $Sql."<br>";
			$Record		= query($Sql);
			$DocOptions		= happy_mysql_fetch_array($Record);
			//print_r($DocOptions);

			$names = $PER_ARRAY_DB;
			$cnt = count($names);
			for ( $i=0; $i<$cnt; $i++ )
			{
				$n_name = $names[$i]."_necessary";
				$u_name = $names[$i]."_use";
				$op_name = $PER_ARRAY_NAME[$i];
				if ( $CONF[$names[$i]]
					&& $CONF[$n_name] == '필수결제'
					&& $CONF[$u_name] == '사용함' )
				{
					if ( $DocOptions[$i] < date("Y-m-d H:i:s") )
					{
						$necessary_javascriptscript .= "
						if ( myform.".$names[$i]." )
						{
							if ( valued(myform.".$names[$i].") == false )
							{
								alert('".$op_name." 옵션은 결제를 하셔야만 출력이 됩니다.');
								return false;
							}
						}
						";
					}
				}
			}
			#필수결제항목 체크
		}
		else
		{
			#등록폼 이므로 폼체크 루틴이 결제버튼 이전에 들어가야 함
			$pay_phone_script = '
			if ( sendit(document.'.$frm.') )
			{
				'.$pay_button_script.'
				myform.pay_type.value = "phone";
				myform.submit();
			}
			';
			$pay_card_script = '
			if ( sendit(document.'.$frm.') )
			{
				'.$pay_button_script.'
				myform.pay_type.value = "card";
				myform.submit();
			}
			';
			$pay_bank_script = '
			if ( sendit(document.'.$frm.') )
			{
				'.$pay_button_script.'
				myform.pay_type.value = "bank";
				myform.submit();
			}
			';
			$pay_bank_soodong_script = '
			if ( sendit(document.'.$frm.') )
			{
				myform.target = "_top";
				myform.pay_type.value = "bank_soodong";
				myform.submit();
			}
			';
			$pay_point_script = '
			if ( sendit(document.'.$frm.') )
			{
				myform.target = "_top";
				myform.pay_type.value = "point";
				myform.submit();
			}
			';

			$necessary_javascriptscript = '';

		}

		#회원아이디를 구한다.
		$Tmp_number = rand(0,99);
		$gou_number = $userid ."-". $Tmp_number ."-". happy_mktime();

		//결제 페이지로 이동
		#기존정보를 읽어
		if ( $_GET['number'] != '' )
		{
			$sql = "select * from $per_document_tb where number='".$_GET['number']."'";
			$result = query($sql);
			$DETAIL = happy_mysql_fetch_array($result);
		}

		#해당하는 유료결재정보를 읽어온다.
		#추천/누네띠네/배너1/배너2/배너3/뉴스티커/등록유료화
		#배너형/좁은배너형/넓은배너형/누네띠네형/리스트형/추천형/뉴스티커형/일반형
		$guin_reg		= explode("\n",str_replace("\r","",$CONF['guin_reg']));
		$guin_special	= explode("\n",str_replace("\r","",$CONF['guin_special']));
		$guin_focus		= explode("\n",str_replace("\r","",$CONF['guin_focus']));
		$guin_powerlink	= explode("\n",str_replace("\r","",$CONF['guin_powerlink']));
		$guin_docskin	= explode("\n",str_replace("\r","",$CONF['guin_docskin']));
		$guin_icon		= explode("\n",str_replace("\r","",$CONF['guin_icon']));
		$guin_bolder	= explode("\n",str_replace("\r","",$CONF['guin_bolder']));
		$guin_color		= explode("\n",str_replace("\r","",$CONF['guin_color']));
		$guin_freeicon	= explode("\n",str_replace("\r","",$CONF['guin_freeicon']));
		#배경색 옵션
		$guin_bgcolor	= explode("\n",str_replace("\r","",$CONF['guin_bgcolor']));
		#추가옵션5개
		$GuzicUryoDate1	= explode("\n",str_replace("\r","",$CONF['GuzicUryoDate1']));
		$GuzicUryoDate2	= explode("\n",str_replace("\r","",$CONF['GuzicUryoDate2']));
		$GuzicUryoDate3	= explode("\n",str_replace("\r","",$CONF['GuzicUryoDate3']));
		$GuzicUryoDate4	= explode("\n",str_replace("\r","",$CONF['GuzicUryoDate4']));
		$GuzicUryoDate5	= explode("\n",str_replace("\r","",$CONF['GuzicUryoDate5']));

		$PAY = array();
		/*
		$PAY[guin_reg]			= make_guin_selectbox($guin_reg,"-- 결재금액선택 --",guin_reg,"기간별");
		$PAY[guin_special]		= make_guin_selectbox($guin_special,"-- 결재금액선택 --",guin_special,"기간별");
		$PAY[guin_focus]		= make_guin_selectbox($guin_focus,"-- 결재금액선택 --",guin_focus,"기간별");
		$PAY[guin_powerlink]	= make_guin_selectbox($guin_powerlink,"-- 결재금액선택 --",guin_powerlink,"기간별");
		#$PAY[guin_docskin]		= make_guin_selectbox($guin_docskin,"-- 결재금액선택 --",guin_docskin,"기간별");
		$PAY[guin_docskin]		= make_guin_radiobox($guin_docskin,$guin_docskin,"guin_docskin","기간별");
		$PAY[guin_icon]			= make_guin_selectbox($guin_icon,"-- 결재금액선택 --",guin_icon,"기간별");
		$PAY[guin_bolder]		= make_guin_selectbox($guin_bolder,"-- 결재금액선택 --",guin_bolder,"기간별");
		$PAY[guin_color]		= make_guin_selectbox($guin_color,"-- 결재금액선택 --",guin_color,"기간별");
		#$PAY[guin_freeicon]		= make_guin_radiobox($guin_freeicon,$guin_freeicon,guin_freeicon,"기간별");
		$PAY[guin_freeicon]		= make_guin_selectbox($guin_freeicon,"-- 결재금액선택 --",guin_freeicon,"기간별");
		#배경색
		$PAY[guin_bgcolor]		= make_guin_selectbox($guin_bgcolor,"-- 결재금액선택 --",guin_bgcolor,"기간별");
		*/
		//print_r($guin_freeicon);
		$PAY['guin_reg']			= make_guin_checkbox_pay($guin_reg,"-- 결재금액선택 --",guin_reg,"기간별");
		$PAY['guin_special']		= make_guin_checkbox_pay($guin_special,"-- 결재금액선택 --",guin_special,"기간별");
		$PAY['guin_focus']		= make_guin_checkbox_pay($guin_focus,"-- 결재금액선택 --",guin_focus,"기간별");
		$PAY['guin_powerlink']	= make_guin_checkbox_pay($guin_powerlink,"-- 결재금액선택 --",guin_powerlink,"기간별");
		#$PAY[guin_docskin]		= make_guin_selectbox($guin_docskin,"-- 결재금액선택 --",guin_docskin,"기간별");
		$PAY['guin_docskin']		= make_guin_radiobox($guin_docskin,$guin_docskin,"guin_docskin","기간별");
		$PAY['guin_icon']			= make_guin_checkbox_pay($guin_icon,"-- 결재금액선택 --",guin_icon,"기간별");
		$PAY['guin_bolder']		= make_guin_checkbox_pay($guin_bolder,"-- 결재금액선택 --",guin_bolder,"기간별");
		$PAY['guin_color']		= make_guin_checkbox_pay($guin_color,"-- 결재금액선택 --",guin_color,"기간별");
		#$PAY[guin_freeicon]		= make_guin_radiobox($guin_freeicon,$guin_freeicon,guin_freeicon,"기간별");
		//array_unshift($guin_freeicon,"0:0");
		//print_r($guin_freeicon);
		$PAY['guin_freeicon']		= make_guin_radiobox($guin_freeicon,"-- 결재금액선택 --",guin_freeicon,"기간별");
		#배경색
		$PAY['guin_bgcolor']		= make_guin_checkbox_pay($guin_bgcolor,"-- 결재금액선택 --",guin_bgcolor,"기간별");

		#추가옵션5개
		$PAY['GuzicUryoDate1']		= make_guin_checkbox_pay($GuzicUryoDate1,"-- 결재금액선택 --",GuzicUryoDate1,"기간별");
		$PAY['GuzicUryoDate2']		= make_guin_checkbox_pay($GuzicUryoDate2,"-- 결재금액선택 --",GuzicUryoDate2,"기간별");
		$PAY['GuzicUryoDate3']		= make_guin_checkbox_pay($GuzicUryoDate3,"-- 결재금액선택 --",GuzicUryoDate3,"기간별");
		$PAY['GuzicUryoDate4']		= make_guin_checkbox_pay($GuzicUryoDate4,"-- 결재금액선택 --",GuzicUryoDate4,"기간별");
		$PAY['GuzicUryoDate5']		= make_guin_checkbox_pay($GuzicUryoDate5,"-- 결재금액선택 --",GuzicUryoDate5,"기간별");

		$시간 = happy_mktime();

		#$tmp	= array("guin_reg","guin_special","guin_focus","guin_powerlink","guin_docskin","guin_icon","guin_bolder","guin_color","guin_freeicon","guin_bgcolor","GuzicUryoDate1","GuzicUryoDate2","GuzicUryoDate3","GuzicUryoDate4","GuzicUryoDate5");

		$tmp = $PER_ARRAY_DB;

		//print_r2($CONF);

		$Sty = array();
		for ( $i=0,$max=sizeof($tmp) ; $i<$max ; $i++ )
		{
			$use_title = $tmp[$i]."_use";
			//echo $CONF[$use_title]."<br>";

			if ( $CONF[$use_title] == "사용안함" )
			{
				$Sty[$tmp[$i]] = ' style="display:none;" ';
				continue;
			}

			if ( trim($CONF[$tmp[$i]]) == "" )
			{
				$PAY[$tmp[$i]]	= "유료설정이 되지 않음";
			}
		}

		for ( $i=0 , $max=sizeof($guin_docskin), $docskin_count=1 ; $i<$max ; $i++ )
		{
			if ( $guin_docskin[$i] != "" )
			{
				$docskin_count++;
			}
		}

		for ( $i=0, $docskin_javascript="val4 = '0:0';\n" ; $i < $docskin_count ; $i++ )
		{
			$docskin_javascript	.= "
										if ( frm.guin_docskin && frm.guin_docskin[$i].checked  ) {

											val4 = frm.guin_docskin[$i].value;

										} else {
											if (val4 == \"0:0\")
												val4 = \"0:0\";

										}\n
									";
		}


		for ( $i=0 , $max=sizeof($guin_freeicon), $freeicon_count=1 ; $i<$max ; $i++ )
		{
			if ( $guin_freeicon[$i] != "" )
			{
				$freeicon_count++;
			}
		}

		for ( $i=0, $freeicon_javascript="val8 = '0:0';\n" ; $i < $freeicon_count ; $i++ )
		{
			$freeicon_javascript	.= "
											if ( frm.guin_freeicon && frm.guin_freeicon[$i].checked ) {
												val8 = frm.guin_freeicon[$i].value;
											} else {
												if (val8 == \"0:0\")
													val8 = \"0:0\";
											}\n
											";
		}

		$pay_check_script = "";
		if ( is_array($PAY) )
		{
			$i = 100;
			foreach ($PAY as $k => $v)
			{
				//echo $i."<br>";

				if ( $k == 'guin_docskin' || $k == 'guin_freeicon' || $k == 'guin_reg' )
				{
					continue;
				}
				else
				{
					$form_name = $k;
					$pay_check_script .= "
					if ( frm.".$form_name." )
					{
						//val".$i."	= frm.".$form_name.".options[frm.".$form_name.".selectedIndex].value;
						max = frm.".$form_name.".length;
						ChkVal = \"0:0\";
						if ( max == undefined )
						{
							if (frm.".$form_name.".checked)
							{
								ChkVal = frm.".$form_name.".value;
							}
						}
						else
						{
							for ( x=0; x<max; x++)
							{
								//alert(frm.".$form_name."[x].value);
								if ( frm.".$form_name."[x].checked )
								{
									ChkVal = frm.".$form_name."[x].value;
								}
							}
						}

						val".$i." = ChkVal;
					}
					else
					{
						val".$i." = \"0:0\";
					}
					";
					$i++;
				}
			}
		}


		#결재 자바스크립트
		$pay_java = <<<END
		<script language="javascript">
		function cashReturn(numValue)
		{
			//numOnly함수에 마지막 파라미터를 true로 주고 numOnly를 부른다.
			var cashReturn = "";
			for (var i = numValue.length-1; i >= 0; i--)
			{
				cashReturn = numValue.charAt(i) + cashReturn;
				if (i != 0 && i%3 == numValue.length%3)
				{
					cashReturn = "," + cashReturn;
				}
			}
			return cashReturn;
		}

		function figure()
		{
			frm		= document.$frm;

			$docskin_javascript
			$freeicon_javascript
			$pay_check_script

			arrVal4	= val4.split(":");
			arrVal8	= val8.split(":");

			arrVal100 = val100.split(":");
			arrVal101 = val101.split(":");
			arrVal102 = val102.split(":");
			arrVal103 = val103.split(":");
			arrVal104 = val104.split(":");
			arrVal105 = val105.split(":");
			arrVal106 = val106.split(":");
			arrVal107 = val107.split(":");
			arrVal108 = val108.split(":");
			arrVal109 = val109.split(":");
			arrVal110 = val110.split(":");
			arrVal111 = val111.split(":");


			val4	= ( val4 == "" )?0:parseInt(arrVal4[1]);
			val8	= ( val8 == "" )?0:parseInt(arrVal8[1]);

			val100	= ( val100 == "" )?0:parseInt(arrVal100[1]);
			val101	= ( val101 == "" )?0:parseInt(arrVal101[1]);
			val102	= ( val102 == "" )?0:parseInt(arrVal102[1]);
			val103	= ( val103 == "" )?0:parseInt(arrVal103[1]);
			val104	= ( val104 == "" )?0:parseInt(arrVal104[1]);
			val105	= ( val105 == "" )?0:parseInt(arrVal105[1]);
			val106	= ( val106 == "" )?0:parseInt(arrVal106[1]);
			val107	= ( val107 == "" )?0:parseInt(arrVal107[1]);
			val108	= ( val108 == "" )?0:parseInt(arrVal108[1]);
			val109	= ( val109 == "" )?0:parseInt(arrVal109[1]);
			val110	= ( val110 == "" )?0:parseInt(arrVal110[1]);
			val111	= ( val111 == "" )?0:parseInt(arrVal111[1]);


			total	=parseInt(val4) + parseInt(val8) + parseInt(val100) + parseInt(val101) + parseInt(val102) + parseInt(val103) + parseInt(val104) + parseInt(val105) + parseInt(val106) + parseInt(val107) + parseInt(val108) + parseInt(val109) + parseInt(val110) + parseInt(val111);


			if ( document.getElementById('uryo_button_layer') && document.getElementById('free_button_layer') )
			{
				if ( total > 0 )
				{
					document.getElementById('uryo_button_layer').style.display = "";
					document.getElementById('free_button_layer').style.display = "none";
				}
				else
				{
					document.getElementById('uryo_button_layer').style.display = "none";
					document.getElementById('free_button_layer').style.display = "";
				}
			}

			$frm.total.value = total;
			$frm.total_price.value = total;
			$frm.total.value = cashReturn($frm.total.value);
			if ( $frm.out_total )
			{
				$frm.out_total.value = $frm.total.value;
			}
		}


		function SingleCheckBox(chk)
		{
			x = document.getElementsByName(chk.name);

			for(i = 0 ; i < x.length ; i++)
			{
				if ( chk != x[i] )
				{
					x[i].checked = false;
				}
			}

			figure();

		}
		</script>

		<script language="javascript">

			function FormCheckUryo(myform)
			{
				//라디오버튼 체크
				if (typeof(myform.guin_docskin) == "object")
				{
					var guin_docskin = "0:0";
					for (i=0;i < myform.guin_docskin.length; i++)
					{
						if (myform.guin_docskin[i].checked)
						{
							guin_docskin = myform.guin_docskin[i].value;
							break;
						}
					}
				}

				if (typeof(myform.guin_freeicon) == "object")
				{
					var guin_freeicon = "0:0";

					for (i=0;i < myform.guin_freeicon.length; i++)
					{
						if (myform.guin_freeicon[i].checked)
						{
							guin_freeicon = myform.guin_freeicon[i].value;
							break;
						}
					}

					//guin_freeicon = myform.guin_freeicon[myform.guin_freeicon.selectedIndex].value;
				}

				if (typeof(myform.doc_skin) == "object" && typeof(myform.guin_docskin) == "object" && guin_docskin != "0:0")
				{
					chk_docskin = checked(myform.doc_skin);
				}
				else
				{
					chk_docskin = true;
				}

				if (typeof(myform.guin_docskin) == "object")
				{
					chk_guin_docskin = checked(myform.guin_docskin);
				}
				else
				{
					chk_guin_docskin = true;
				}

				if (typeof(myform.freeicon) == "object" && typeof(myform.guin_freeicon) == "object" &&		guin_freeicon != "0:0")
				{
					chk_freeicon = checked(myform.freeicon);
				}
				else
				{
					chk_freeicon = true;
				}

				if (typeof(myform.guin_freeicon) == "object")
				{
					//chk_guin_freeicon = ( myform.guin_freeicon.selectedIndex == 0 )?true:false;
					chk_guin_freeicon = checked(myform.guin_freeicon);
				}
				else
				{
					chk_guin_freeicon = true;
				}

				if (chk_docskin == false)
				{
					alert("이력서 스킨의 종류를 선택해주세요");
					return false;
				}
				if (chk_guin_docskin == false)
				{
					alert("이력서 스킨사용 기간을 선택해주세요");
					return false;
				}
				if (chk_freeicon == false)
				{
					alert("아이콘 옵션의 종류를 선택해주세요");
					return false;
				}
				if (chk_guin_freeicon == false)
				{
					alert("아이콘 옵션의 사용기간을 선택해주세요");
					return false;
				}
				//라디오버튼 체크

				//폼체크
				cnt = myform.elements.length;
				is_sel = false;

				for ( i = 0; i < cnt ; i++)
				{
					if(myform.elements[i].type == "select-one")
					{
						sel = myform.elements[i].selectedIndex;
						if (myform.elements[i].options[sel].value != "")
						{
							is_sel = true;
							break;
						}
					}
					else if (myform.elements[i].type == "radio")
					{
						if (myform.elements[i].checked == true)
						{
							if (myform.elements[i].name != "doc_skin" && myform.elements[i].name != "freeicon")
							{
								if (myform.elements[i].value != "0:0")
								{
									is_sel = true;
									break;
								}
							}
						}
					}
					else if (myform.elements[i].type == "checkbox")
					{
						if (myform.elements[i].checked == true)
						{
							if (myform.elements[i].name != "doc_skin" && myform.elements[i].name != "freeicon")
							{
								if (myform.elements[i].value != "0:0")
								{
									is_sel = true;
									break;
								}
							}
						}
					}
				}

				$necessary_javascriptscript

				return true;
			}

			function on_click_phone_pay()
			{
				myform = document.$frm;

				if ( FormCheckUryo(myform) )
				{
					$pay_phone_script
				}
			}


			function on_click_card_pay()
			{
				myform = document.$frm;

				if ( FormCheckUryo(myform) )
				{
					$pay_card_script
				}
			}


			function on_click_bank_pay()
			{
				myform = document.$frm;

				$bank_jumin_chk

				if ( FormCheckUryo(myform) )
				{
					$pay_bank_script
				}
			}

			function on_click_bank_soodong_pay()
			{
				myform = document.$frm;

				if ( FormCheckUryo(myform) )
				{
					$pay_bank_soodong_script
				}

			}

			function on_click_point_pay()
			{
				myform = document.$frm;

				if ( parseInt(myform.total_price.value) > parseInt($회원정보[point]) )
				{
					alert('포인트가 부족합니다.');
					return false;
				}

				if ( FormCheckUryo(myform) )
				{
					$pay_point_script
				}
			}

			function checked(obj)
			{
				var cnt = obj.length;
				//alert(cnt);
				for(i=0; i< cnt; i++)
				{
					if(obj[i].checked == true)
					{
						//alert(i +"번째꺼 선택됨");
						return true;
						break;
					}
				}
				return false;
			}

			function valued(obj)
			{
				var cnt = obj.length;

				if ( cnt != undefined )
				{
					for(i=0;i<cnt;i++)
					{
						if ( obj[i].checked == true )
						{
							return obj[i].value;
							break;
						}
					}
				}
				else
				{
					if ( obj.checked )
					{
						return obj.value;
					}
				}

				return false;
			}

		</script>


		$pay_frame

		<input type=hidden name=number value="$_GET[number]">
		<input type=hidden name=total_price value="0">
		<input type=hidden name=id value="$member_id">
		<input type=hidden name=email value="$DETAIL[guin_email]">
		<input type=hidden name=gou_number value='$gou_number'>
		<input type=hidden name=pay_type value=''>

END;

		#결재방식을 찾자.
		if( $_COOKIE['happy_mobile'] == 'on' )
		{
			if ($CONF['bank_conf_mobile']){
				$PAY['bank'] = "<input type='button' value='실시간 계좌이체' onclick='on_click_bank_pay()'>";
			}

			if ($CONF['card_conf_mobile']){
				$PAY['card'] = "<input type='button' value='신용카드결제'  onclick='on_click_card_pay()'>";
			}

			if ($CONF['phone_conf_mobile']){
				$PAY['phone'] = "<input type='button' value='휴대폰 결제' onclick='on_click_phone_pay()'>";
			}

			if ($CONF['bank_soodong_conf_mobile']){
				$PAY['bank_soodong'] = "<input type='button' value='무통장 입금'  onclick='on_click_bank_soodong_pay()'>";
			}

			#포인트결제 추가
			if ($CONF['point_conf_mobile']){
				$PAY['point'] = "<input type='button' value='포인트 결제' onclick='on_click_point_pay()'>";
			}
			#포인트결제 추가

			#무료신청버튼 추가
			$PAY['free'] = "<input type='button' value='이력서 등록'  onclick='on_click_bank_soodong_pay()'>";
		}
		else
		{
			if ($CONF['bank_conf']){
				$PAY['bank'] = "<input type='button' value='' style='width:180px; height:60px; background:url(img/btn_pay01.gif) no-repeat; border:0px solid red; cursor:pointer;' onclick='on_click_bank_pay()'>";
			}

			if ($CONF['card_conf']){
				$PAY['card'] = "<input type='button' value=''  style='width:180px; height:60px; background:url(img/btn_pay02.gif) no-repeat; border:0px solid red; cursor:pointer;'  onclick='on_click_card_pay()'>";
			}

			if ($CONF['phone_conf']){
				$PAY['phone'] = "<input type='button' value='' style='width:180px; height:60px; background:url(img/btn_pay03.gif) no-repeat; border:0px solid red; cursor:pointer;'  onclick='on_click_phone_pay()'>";
			}

			if ($CONF['bank_soodong_conf']){
				$PAY['bank_soodong'] = "<input type='button' value='' style='width:180px; height:60px; background:url(img/btn_pay04.gif) no-repeat; border:0px solid red; cursor:pointer;'  onclick='on_click_bank_soodong_pay()'>";
			}

			#포인트결제 추가
			if ($CONF['point_conf']){
				$PAY['point'] = "<input type='button' value='' style='width:180px; height:60px; background:url(img/btn_pay05.gif) no-repeat; border:0px solid red; cursor:pointer;' onclick='on_click_point_pay()'>";
			}
			#포인트결제 추가

			#무료신청버튼 추가
			$PAY['free'] = "<input type='button' value='' style='vertical-align:middle; background:url(img/btn_noadd.gif) no-repeat; width:180px; cursor:pointer; height:60px;' onclick='on_click_bank_soodong_pay()'>";
		}



		if ($demo){
			$msg = "<img src=img/dot.gif width=20><font color=blue>데모버젼에서는 실제결재가 되지 않으오니 안심하시고 결재를 끝까지 진행하셔도 됩니다.</font><br> ";
		}




	}



	if ($HAPPY_CONFIG['pay_all_pg'] == "dacom")
	{

		$dacom_jumin = "
					<div id='pg_lg_uplus'>
						<table>
						<tr>
							<td class='title'>
								<ul>
									<li class='logo'><img src='./img/logo_lg_uplus.png' alt='LG 유플러스 전자결제 로고' width='173' height='28'></li>
									<li class='id_card'>주민등록번호 입력</li>
								</ul>
							</td>
							<td class='input'>
								<input type='text' name='jumin1' value='' id='jumin1'> -
								<input type='password' name='jumin2' value='' id='jumin2'>
							</td>
							<td class='help'>
								LG 유플러스(데이콤) 전자결제 시스템 경우에는 실시간 계좌이체 이용시 주민등록번호를 입력하셔야 합니다.
							</td>
						</tr>
						</table>
					</div>
		";
	}

####################################################################################################################################


	$TPL->define("이력서상단", "$skin_folder/job_per_doc_top.html");
	$TPL->assign("이력서상단");
	$이력서상단 = &$TPL->fetch();

	#echo "$skin_folder/$template";
	$TPL->define("본문내용", "$skin_folder/$template");
	$TPL->assign("본문내용");
	$내용 = &$TPL->fetch();

	$Member				= happy_member_information($happy_member_login_value);
	$member_group		= $Member['group'];

	$sql				= "select * from $happy_member_group where number='$member_group' ";
	$result				= query($sql);
	$Data				= happy_mysql_fetch_array($result);
	$Template_Default	= $Data['mypage_default'];
	$Template_Default	= $happy_member_login_value == '' ? "default_com.html" : $Template_Default;

	//echo $Template_Default;
	$TPL->define("껍데기", "$skin_folder/$Template_Default");
	$TPL->assign("껍데기");
	$ALL = &$TPL->fetch();
	echo $ALL;
?>