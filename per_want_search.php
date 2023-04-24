<?php
	#맞춤구인정보 설정
	#com_want_search.php 와 같으나, 개인회원이 저장하며, 이력서 / 채용정보 의 차이 때문에 파일을 아예 따로 만듬

	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	if ( !happy_member_secure($happy_member_secure_text[8]) )
	{
		error($happy_member_secure_text[8]."권한이 없습니다.");
		exit;
	}

	if ( $_COOKIE["ad_id"] && $MEM['id'] == "" )
	{
		error("관리자라도 마이페이지에 접근하실려면 구직회원으로 로그인 후 이용가능합니다.");
	}
	if ( $MEM['id'] == "" )
	{
		gomsg("로그인 후 이용하세요","./happy_member_login.php");
	}


	#맞춤구인설정 가져오자.
	$sql = "select * from ".$job_per_want_search." where id = '".$MEM['id']."'";
	$result = query($sql);
	$WantSearchGuin = happy_mysql_fetch_assoc($result);
	#맞춤구인설정 가져오자.

	if ( isset($_GET['mode']) )
	{
		if ( $_GET['mode'] == "setting" )
		{

			//print_r2($MEM);
			//print_r2($_POST);

			$search_type = $_POST['search_type'];							#직종
			$search_type_sub = $_POST['search_type_sub'];				#직종서브
			$search_si = $_POST['search_si'];								#시
			$search_gu = $_POST['search_gu'];								#구
			$job_type_read = $_POST['grade_gtype'];						#근무형태
			$guziceducation = $_POST['guziceducation'];					#학력
			$grade_money_type = $_POST['grade_money_type'];		#급여
			$grade_money = $_POST['grade_money'];						#급여금액
			$guzicnational = $_POST['guzicnational'];						#국적
			$gender_read = $_POST['gender_read'];							#성별
			$diff_regday = $_POST['diff_regday'];								#등록일로부터 몇일
			$career_read_start = $_POST['career_read_start'];				#경력시작
			$career_read_end = $_POST['career_read_end'];				#경력마지막
			$career_read = $_POST['guin_career'];							#경력/무관/신입
			$career_read_year = $_POST['career_read_year'];							#채용정보의 경력검색
			$guzic_age_start = $_POST['guzic_age_start'];					#나이
			$guzic_age_end = $_POST['guzic_age_end'];					#나이


			#채용정보 검색하기 위한 쿼리를 만들자
			if ( $search_type != '' )
			{
				#type1,type2,type3
				$WHERE[] = " ( type1 = '$search_type' OR type2 = '$search_type' OR type3 = '$search_type' ) ";
			}

			if ( $search_type_sub != '' )
			{
				#type_sub1,type_sub2,type_sub3
				$WHERE[] = " ( type_sub1 = '$search_type_sub' OR type_sub2 = '$search_type_sub' OR type_sub3 = '$search_type_sub' ) ";
			}

			if ( $search_si != '' )
			{
				#si1,si2,si3
				$WHERE[] = " ( si1 = '$search_si' OR si2 = '$search_si' OR si3 = '$search_si' OR si1 = '$SI_NUMBER[전국]' OR si2 = '$SI_NUMBER[전국]' OR si3 = '$SI_NUMBER[전국]' ) ";
			}

			if ( $search_gu != '' )
			{
				#gu1,gu2,gu3
				$WHERE[] = " ( gu1 = '$search_gu' OR gu2 = '$search_gu' OR gu3 = '$search_gu' ) ";
			}

			if ( $job_type_read != '' )
			{
				#guin_type
				$WHERE[] = " ( guin_type = '$job_type_read' ) ";
			}

			if ( $guziceducation != '' )
			{
				#guineducation
				$WHERE[] = " ( guin_edu = '$guziceducation' ) ";
			}

			if ( $grade_money_type != '' )
			{
				#guin_pay_type
				if (in_array($grade_money_type,$money_arr) === true)
				{
					//$WHERE[] = " ( guin_pay_type = '' ) ";
					$grade_money		= $grade_money_type;
					$grade_money_type	= "";
				}
				else
				{
					$WHERE[] = " ( guin_pay_type = '$grade_money_type' ) ";
				}
			}

			if ( $grade_money != '' )
			{
				#guin_pay
				$WHERE[] = " ( guin_pay = '$grade_money' ) ";
			}

			if ( $guzicnational != '' )
			{
				#guinnational
				$WHERE[] = " ( guinnational = '$guzicnational' ) ";
			}

			if ( $gender_read != '' )
			{
				#guin_gender
				if ( $gender_read == '남자' )
				{
					$WHERE[] = " ( guin_gender = '남자' ) ";
				}
				else if ( $gender_read == '여자' )
				{
					$WHERE[] = " ( guin_gender = '여자' ) ";
				}
			}

			//print_r2($WHERE);

			#나이
			$guzic_age_start2 = date("Y") - $guzic_age_start + 1;
			$guzic_age_end2 = date("Y") - $guzic_age_end + 1;
			if ( $guzic_age_start != '' && $guzic_age_end != '' )
			{
				$WHERE[] = " ( guin_age <= $guzic_age_start2 AND guin_age >= $guzic_age_end2 ) ";
			}
			else if ( $guzic_age_start != '' )
			{
				$WHERE[] = " ( guin_age <= $guzic_age_start2 ) ";
			}
			else if ( $guzic_age_end != '' )
			{
				$WHERE[] = " ( guin_age >= $guzic_age_end2 ) ";
			}


			if ( $diff_regday != '' )
			{
				#guin_date
				$WHERE[] = " ( guin_date >= date_add(guin_date,interval -$diff_regday day) ) ";
			}

			/*
			if ( $career_read_start != '' && !preg_match('/신입/',$career_read_start) )
			{
				$career_read_start	= preg_replace("/\D/","",$career_read_start);

				if ( $career_read_start != '' )
				{
					$WHERE[] = " ( work_year >= $career_read_start )";
				}
			}

			if ( preg_match('/신입/',$career_read_end) )
			{
				$WHERE[] = " ( work_year = 0 OR work_year = '' ) AND ( work_month = 0 OR work_month = '' ) ";
			}
			else if ( $career_read_end != '' )
			{
				$career_read_end	= preg_replace("/\D/","",$career_read_end);

				if ( $career_read_end != '' )
				{
					$WHERE[] = " ( work_year < $career_read_end OR ( work_year = $career_read_end AND work_month = 0 ) ) ";
				}
			}
			*/

			if ( $career_read == '경력' )
			{
				$career_sql = "";
				if ( $career_read_year != '' )
				{
					#guin_career_year
					$career_sql = "( (guin_career = '$career_read' AND guin_career_year = '$career_read_year') OR guin_career = '무관' )";
				}
				else
				{
					$career_sql = "( guin_career = '$career_read' OR guin_career = '무관' )";
				}

				$WHERE[] = $career_sql;
			}
			else if ( $career_read != '' )
			{
				#guin_career
				$WHERE[] = " ( guin_career = '$career_read' OR guin_career = '무관' ) ";

				$_POST['career_read_year'] = "";
			}
			else
			{

				$_POST['career_read_year'] = "";
			}



			$query_str = " ( ".implode(" AND ", (array) $WHERE)." ) ";
			$query_str = addslashes($query_str);
			#채용정보 검색하기 위한 쿼리를 만들자

			// 맞춤채용알림
			$check_want_mail	= ( $_POST['check_want_mail'] == '' ) ? 'n' : 'y';
			$check_want_sms		= ( $_POST['check_want_sms'] == '' ) ? 'n' : 'y';

			if ( is_array($WantSearchGuin) )
			{
				$sql = "update ".$job_per_want_search." set ";
				#$sql.= "id = '".$MEM['id']."', ";
				$sql.= "job_type1 = '".$_POST['search_type']."', ";
				$sql.= "job_type2 = '".$_POST['search_type_sub']."', ";
				$sql.= "job_type3 = '".$_POST['search_type_sub_sub']."', ";
				$sql.= "si = '".$_POST['search_si']."', ";
				$sql.= "gu = '".$_POST['search_gu']."', ";
				$sql.= "grade_gtype = '".$job_type_read."', ";
				$sql.= "guziceducation = '".$_POST['guziceducation']."', ";
				$sql.= "career_read = '".$_POST['guin_career']."', ";
				$sql.= "career_read_year = '".$_POST['career_read_year']."', ";
				#$sql.= "career_read_start = '".$_POST['career_read_start']."', ";
				#$sql.= "career_read_end = '".$_POST['career_read_end']."', ";
				$sql.= "grade_money_type = '".$_POST['grade_money_type']."', ";
				$sql.= "grade_money = '".$_POST['grade_money']."', ";
				$sql.= "guzicnational = '".$_POST['guzicnational']."', ";
				$sql.= "guzic_age_start = '".$_POST['guzic_age_start']."', ";
				$sql.= "guzic_age_end = '".$_POST['guzic_age_end']."', ";
				$sql.= "diff_regday = '".$_POST['diff_regday']."', ";
				$sql.= "gender_read = '".$_POST['gender_read']."', ";
				$sql.= "query_str = '".$query_str."', ";
				$sql.= "regdate = now(), ";
				// 맞춤채용알림
				$sql.= "check_want_mail = '$check_want_mail', ";
				$sql.= "check_want_sms = '$check_want_sms' ";
				$sql.= "where id = '".$MEM['id']."'";
				query($sql);
			}
			else
			{
				$sql = "insert into ".$job_per_want_search." set ";
				$sql.= "id = '".$MEM['id']."', ";
				$sql.= "job_type1 = '".$_POST['search_type']."', ";
				$sql.= "job_type2 = '".$_POST['search_type_sub']."', ";
				$sql.= "job_type3 = '".$_POST['search_type_sub_sub']."', ";
				$sql.= "si = '".$_POST['search_si']."', ";
				$sql.= "gu = '".$_POST['search_gu']."', ";
				$sql.= "grade_gtype = '".$job_type_read."', ";
				$sql.= "guziceducation = '".$_POST['guziceducation']."', ";
				$sql.= "career_read = '".$_POST['guin_career']."', ";
				$sql.= "career_read_year = '".$_POST['career_read_year']."', ";
				#$sql.= "career_read_start = '".$_POST['career_read_start']."', ";
				#$sql.= "career_read_end = '".$_POST['career_read_end']."', ";
				$sql.= "grade_money_type = '".$_POST['grade_money_type']."', ";
				$sql.= "grade_money = '".$_POST['grade_money']."', ";
				$sql.= "guzicnational = '".$_POST['guzicnational']."', ";
				$sql.= "guzic_age_start = '".$_POST['guzic_age_start']."', ";
				$sql.= "guzic_age_end = '".$_POST['guzic_age_end']."', ";
				$sql.= "diff_regday = '".$_POST['diff_regday']."', ";
				$sql.= "gender_read = '".$_POST['gender_read']."', ";
				$sql.= "query_str = '".$query_str."', ";
				$sql.= "regdate = now(), ";
				// 맞춤채용알림
				$sql.= "check_want_mail = '$check_want_mail', ";
				$sql.= "check_want_sms = '$check_want_sms' ";
				query($sql);
			}
			msg("맞춤구인정보 설정이 완료되었습니다.");
			go("./per_want_search.php?mode=setting_form");

		}
		else if ( $_GET['mode'] == "setting_form" )
		{
			$현재위치 = "$prev_stand > <a href=member_info.php>맞춤채용공고 설정하기</a>";

			//$맞춤업종설정	= make_type_selectbox("search_type","search_type_sub",$WantSearchGuin['job_type1'],$WantSearchGuin['job_type2'],"250","250","a_f_guin");
			$js_arr1			= get_type_selectbox($WantSearchGuin['job_type1'],$WantSearchGuin['job_type2'],$WantSearchGuin['job_type3']);
			$type_opt			= $js_arr1['type_opt'];
			$type_sub_opt		= $js_arr1['type_sub_opt'];
			$type_sub_sub_opt	= $js_arr1['type_sub_sub_opt'];

			$맞춤지역설정	= make_si_selectbox("search_si","search_gu",$WantSearchGuin['si'],$WantSearchGuin['gu'],"140","140","a_f_guin");

			$맞춤고용형태설정		= make_selectbox($job_arr,'--선택--',grade_gtype,$WantSearchGuin['grade_gtype']);

			#학력 //edu_arr
			$맞춤학력설정 = make_selectbox2($edu_arr,$edu_arr,"학력","guziceducation",$WantSearchGuin['guziceducation'],$select_width="200px");

			#경력 이력서와 채용정보는 서로 다름
			/*
			$career_start	= $career_start_arr;
			$career_end		= $career_end_arr;
			$맞춤경력시작설정	= make_selectbox($career_start,'--선택--',career_read_start,$WantSearchGuin['career_read_start']);
			$맞춤경력종료설정	= make_selectbox($career_end,'--선택--',career_read_end,$WantSearchGuin['career_read_end']);
			*/

			$guin_career_check_0 = "";
			$guin_career_check_1 = "";
			$guin_career_check_2 = "";
			if ( $WantSearchGuin['career_read'] == "" )
			{
				$guin_career_check_0 = " checked ";
			}
			else if ( $WantSearchGuin['career_read'] == "신입" )
			{
				$guin_career_check_1 = " checked ";
			}
			else if ( $WantSearchGuin['career_read'] == "경력" )
			{
				$guin_career_check_2 = " checked ";
			}

			$career			= $career_arr;
			$career_start	= $career_start_arr;
			$career_end		= $career_end_arr;
			//array_unshift($career,"신입");
			$맞춤경력설정		= make_selectbox($career,'--선택--',career_read_year,$WantSearchGuin['career_read_year']);

			// 맞춤채용알림
			$check_want_mail_checked	= ( $WantSearchGuin['check_want_mail'] == "y" ) ? "checked" : "";
			$check_want_sms_checked		= ( $WantSearchGuin['check_want_sms'] == "y" ) ? "checked" : "";

			#국적
			$맞춤국적설정 = make_radiobox2($TNational,$TNational,4,"guzicnational","guzicnational",$WantSearchGuin['guzicnational']);

			#희망연봉타입만 사용함
			$names	= Array("area_arr","money_arr","edu_arr","root_schooltype","want_money_arr");
			$return	= Array("지역선택옵션","희망연봉옵션","최종학력옵션","계열선택옵션","희망연봉타입");
			$vals	= Array($ReData["grade2_schoolCity"],$ReData["grade_money"],$ReData["grade_lastgrade"],$ReData["grade3_schoolType"],$WantSearchGuin["grade_money_type"]);

			for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
			{
				$options	= "";

				if ( $names[$x] == 'want_money_arr' ) //희망연봉타입
				{
					${$names[$x]} = array_merge(${$names[$x]}, $money_arr);
				}

				for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
				{
					$checked	= ( $vals[$x] == ${$names[$x]}[$i] )?"selected":"";
					$options	.= "<option value='".${$names[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>\n";
				}
				${$return[$x]}	= $options;
			}
			#희망연봉타입만 사용함

			$gender			= array('무관','man','girl');
			$gendern			= array('','남자','여자');

			$맞춤성별설정		= make_selectbox2($gendern,$gender,'--선택--',gender_read,$WantSearchGuin['gender_read']);



			$맞춤연령시작설정	= "<select name='guzic_age_start' ><option value=''>연령선택</option>";
			for ( $i=10, $year=date("Y")-9 ; $i<100 ; $i++ , $year-- )
			{
				$selected		= $WantSearchGuin['guzic_age_start'] == $i ? 'selected' : '';
				$맞춤연령시작설정	.= "<option value='$i' $selected >${i}세 (${year}년생)</option>";
			}
			$맞춤연령시작설정	.= "</select>";

			$맞춤연령종료설정	= "<select name='guzic_age_end' ><option value=''>연령선택</option>";
			for ( $i=10, $year=date("Y")-9 ; $i<100 ; $i++ , $year-- )
			{
				$selected		= $WantSearchGuin['guzic_age_end'] == $i ? 'selected' : '';
				$맞춤연령종료설정	.= "<option value='$i'  $selected >${i}세 (${year}년생)</option>";
			}
			$맞춤연령종료설정	.= "</select>";


			$등록일차이 = make_selectbox2($TLastRegDayN,$TLastRegDay,"","diff_regday",$WantSearchGuin['diff_regday'],$select_width="80");

			$TPL->define("마춤구인정보설정", "./$skin_folder/per_want_search.html");
			$TPL->assign("마춤구인정보설정");
			$내용 = &$TPL->fetch();

			#개인회원 껍데기
			$tmp_file = $ADMIN[admin_info_guzic];

			$happy_member_login_id	= happy_member_login_check();

			if ( $happy_member_login_id == "" && happy_member_secure( '마이페이지' ) )
			{
				error("관리자라도 마이페이지에 접근하기 위해서는 회원으로 로그인을 하셔야 합니다.");
				exit;
			}

			$Member					= happy_member_information($happy_member_login_id);
			$member_group			= $Member['group'];

			$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
			$Group					= happy_mysql_fetch_array(query($Sql));

			$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
			$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
			$Template				= $happy_member_skin_folder.'/'.$Template;


			#echo "./$skin_folder/$Template_Default";
			$TPL->define("껍데기", "./$skin_folder/$Template_Default");
			$TPL->assign("껍데기");
			$ALL = &$TPL->fetch();
			echo $ALL;
			exit;
		}
		else if ( $_GET['mode'] == "list" )
		{
			#마춤구인검색 리스트 만들어주자.
			$file = "guin_want_search.html";
			$file2 = "default_per.html";
			$현재위치 = "$prev_stand > <a href=member_info.php>회원정보</a>";

			//print_r2($WantSearchGuin);
			//unset($WantSearchGuin);
			#검색되도록
			#카테고리
			$_GET['search_type'] = $WantSearchGuin['job_type1'];
			$search_type = $WantSearchGuin['job_type1'];
			$_GET["search_type_sub"] = $WantSearchGuin['job_type2'];
			$search_type_sub = $WantSearchGuin['job_type2'];
			$_GET["search_type_sub_sub"] = $WantSearchGuin['job_type3'];
			$search_type_sub_sub = $WantSearchGuin['job_type3'];

			#지역 시
			$_GET['search_si'] = $WantSearchGuin['si'];
			$search_si = $WantSearchGuin['si'];
			#지역 구
			$_GET['search_gu'] = $WantSearchGuin['gu'];
			$search_gu = $WantSearchGuin['gu'];

			#근무형태
			$_GET["job_type_read"] = $WantSearchGuin['grade_gtype'];
			$job_type_read = $WantSearchGuin['grade_gtype'];

			$_GET['guziceducation'] = $WantSearchGuin['guziceducation'];

			#채용정보 경력
			$_GET['career_read'] = $WantSearchGuin['career_read'];
			$career_read = $WantSearchGuin['career_read'];

			$_GET['career_read_year'] = $WantSearchGuin['career_read_year'];
			$career_read_year = $WantSearchGuin['career_read_year'];

			if ( $career_read != '무관' )
			{
				$_GET['career_read'] = $WantSearchGuin['career_read_year'];
				$career_read = $WantSearchGuin['career_read_year'];
			}
			else
			{
				$_GET['career_read'] = $WantSearchGuin['career_read'];
				$career_read = $WantSearchGuin['career_read'];
			}
			#채용정보 경력

			$_GET["career_read_start"] = $WantSearchGuin['career_read_start'];
			$_GET["career_read_end"] = $WantSearchGuin['career_read_end'];

			#급여조건
			$_GET['guin_pay_type'] = $WantSearchGuin['grade_money_type'];
			$guin_pay_type = $WantSearchGuin['grade_money_type'];

			#급여
			$_GET['pay_read'] = $WantSearchGuin['grade_money'];
			$pay_read = $WantSearchGuin['grade_money'];

			#국적
			$_GET['guzicnational'] = $WantSearchGuin['guzicnational'];

			#나이검색
			$_GET['guzic_age_start'] = $WantSearchGuin['guzic_age_start'];
			$_GET['guzic_age_end'] = $WantSearchGuin['guzic_age_end'];

			#최근등록일
			$_GET['diff_regday'] = $WantSearchGuin['diff_regday'];
			$diff_regday = $WantSearchGuin['diff_regday'];

			#성별
			if ( $WantSearchGuin['gender_read'] == "man" )
			{
				$WantSearchGuin['gender_read'] = "남자";
			}
			else if ( $WantSearchGuin['gender_read'] == "girl" )
			{
				$WantSearchGuin['gender_read'] = "여자";
			}
			else
			{
				$WantSearchGuin['gender_read'] = "무관";
			}

			#성별
			$_GET['gender_read'] = $WantSearchGuin['gender_read'];
			$gender_read = $WantSearchGuin['gender_read'];

			$plus2	.= "action=search";
			$plus2	.= "&search_si=".urlencode($_GET['search_si']);
			$plus2	.= "&search_gu=".urlencode($_GET['search_gu']);
			$plus2	.= "&search_type=".urlencode($_GET['search_type']);
			$plus2	.= "&search_type_sub=".urlencode($_GET['search_type_sub']);
			$plus2	.= "&career_read=".urlencode($_GET['career_read']);
			$plus2	.= "&gender_read=".urlencode($_GET['gender_read']);
			$plus2	.= "&pay_read=".urlencode($_GET['pay_read']);
			$plus2	.= "&edu_read=".urlencode($_GET['edu_read']);
			$plus2	.= "&job_type_read=".urlencode($_GET['job_type_read']);
			$plus2	.= "&grade_read=".urlencode($_GET['grade_read']);
			$plus2	.= "&title_read=".urlencode($_GET['title_read']);
			$plus2	.= "&guzic_jobtype1=".urlencode($_GET['guzic_jobtype1']);
			$plus2	.= "&guzic_jobtype2=".urlencode($_GET['guzic_jobtype2']);
			$plus2	.= "&file=".urlencode($_GET['file']);
			$plus2	.= "&underground1=".urlencode($_GET['underground1']);
			$plus2	.= "&underground2=".urlencode($_GET['underground2']);
			$plus2	.= "&file2=".urlencode($_GET['file2']);
			#추가된검색
			$plus2	.= "&guin_pay_type=".urlencode($_GET['guin_pay_type']);
			$plus2	.= "&guzicnational=".urlencode($_GET['guzicnational']);
			$plus2	.= "&guzic_age_start=".urlencode($_GET['guzic_age_start']);
			$plus2	.= "&guzic_age_end=".urlencode($_GET['guzic_age_end']);
			$plus2	.= "&diff_regday=".urlencode($_GET['diff_regday']);

			#검색값 입력완료
			$searchMethod	= $plus2;
			//echo $searchMethod;
			$더보기링크 = "./guin_list.php?".$searchMethod;

			#검색되도록

			$WantSearchGuin["job_type1_name"]	= $TYPE[$WantSearchGuin["job_type1"]];
			$WantSearchGuin["job_type2_name"]	= $TYPE_SUB[$WantSearchGuin["job_type2"]];
			$WantSearchGuin["job_type3_name"]	= $TYPE_SUB_SUB[$WantSearchGuin["job_type3"]];

			if ( $WantSearchGuin["job_type1_name"] == "" && $WantSearchGuin["job_type2_name"] == "" )
			{
				$WantSearchGuin["job_type1_name"] = "설정안됨";
			}

			$WantSearchGuin['si_name'] = $SI[$WantSearchGuin['si']];
			$WantSearchGuin['gu_name'] = $GU[$WantSearchGuin['gu']];
			if ( $WantSearchGuin['si_name'] == "" && $WantSearchGuin['gu_name'] == "" )
			{
				$WantSearchGuin['si_name'] = "설정안됨";
			}

			if ( $WantSearchGuin['grade_gtype'] == "" )
			{
				$WantSearchGuin['grade_gtype'] = "설정안됨";
			}

			if ( $WantSearchGuin['guziceducation'] == "" )
			{
				$WantSearchGuin['guziceducation'] = "설정안됨";
			}

			if ( $WantSearchGuin['grade_money'] == "" )
			{
				$WantSearchGuin['grade_money'] = "";
			}

			if ( $WantSearchGuin['guzicnational'] == "" )
			{
				$WantSearchGuin['guzicnational'] = "설정안됨";
			}

			#나이
			if ( $WantSearchGuin['guzic_age_start'] != "" && $WantSearchGuin['guzic_age_end'] != "")
			{
				$WantSearchGuin['guzic_age_message'] = $WantSearchGuin['guzic_age_start'].' 세 ~ '.$WantSearchGuin['guzic_age_end'].' 세';
			}
			else if ( $WantSearchGuin['guzic_age_start'] != "" )
			{
				$WantSearchGuin['guzic_age_message'] = $WantSearchGuin['guzic_age_start'].' 세 이상';
			}
			else if ( $WantSearchGuin['guzic_age_end'] != "" )
			{
				$WantSearchGuin['guzic_age_message'] = $WantSearchGuin['guzic_age_end'].' 세 이하';
			}
			else
			{
				$WantSearchGuin['guzic_age_message'] = "설정안됨";
			}

			#등록일
			if ( $WantSearchGuin['diff_regday'] == "" )
			{
				$WantSearchGuin['diff_regday_message'] = "설정안됨";
			}
			else
			{
				$WantSearchGuin['diff_regday_message'] = '등록일로 부터 '.$WantSearchGuin['diff_regday'].' 일 전의 이력서만 검색';
			}

			#성별
			if ( $WantSearchGuin['gender_read'] == "" )
			{
				$WantSearchGuin['gender_read'] = "설정안됨";
			}

			#경력
			if ( $WantSearchGuin['career_read'] != "" && $WantSearchGuin['career_read_year'] != "" )
			{
				if ( $WantSearchGuin['career_read'] != '무관' )
				{
					$WantSearchGuin['career_read_message'] = $WantSearchGuin['career_read']." ".$WantSearchGuin['career_read_year'];
				}
				else
				{
					$WantSearchGuin['career_read_message'] = $WantSearchGuin['career_read'];
				}
			}
			else if ( $WantSearchGuin['career_read'] != "" )
			{
				$WantSearchGuin['career_read_message'] = $WantSearchGuin['career_read'];
			}
			else if ( $WantSearchGuin['career_read_year'] != "" )
			{
				$WantSearchGuin['career_read_message'] = $WantSearchGuin['career_read_year'];
			}
			else
			{
				$WantSearchGuin['career_read_message'] = "설정안됨";
			}

			if ( $WantSearchGuin['career_read_start'] == "" )
			{
				$WantSearchGuin['career_read_start'] = "설정안됨";
			}
			if ( $WantSearchGuin['career_read_end'] == "" )
			{
				$WantSearchGuin['career_read_end'] = "설정안됨";
			}


			$TPL->define("상세", "./$skin_folder/$file");
			$TPL->assign("상세");
			$내용 = &$TPL->fetch();

			$happy_member_login_id	= happy_member_login_check();

			if ( $happy_member_login_id == "" && happy_member_secure( '마이페이지' ) )
			{
				error("관리자라도 마이페이지에 접근하기 위해서는 회원으로 로그인을 하셔야 합니다.");
				exit;
			}

			$Member					= happy_member_information($happy_member_login_id);
			$member_group			= $Member['group'];

			$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
			$Group					= happy_mysql_fetch_array(query($Sql));

			$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
			$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
			$Template				= $happy_member_skin_folder.'/'.$Template;

			$TPL->define("껍데기", "./$skin_folder/$Template_Default");
			$TPL->assign("껍데기");
			echo $TPL->fetch();
		}
	}

?>