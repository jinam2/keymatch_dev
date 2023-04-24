<?php
	#맞춤인재정보 설정
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	if ( !happy_member_secure($happy_member_secure_text[7]) )
	{
		if ( $_COOKIE["ad_id"] )
			error("관리자라도 마이페이지에 접근하실려면 기업회원으로 로그인 후 이용가능합니다.");
		else
			error("$happy_member_secure_text[7] 을 이용하실수 없습니다.");
		exit;
	}

	#맞춤인재설정 가져오자.
	$sql = "select * from ".$job_com_want_search." where id = '".$MEM['id']."'";
	$result = query($sql);
	$WantSearchDoc = happy_mysql_fetch_assoc($result);
	#print_r2($WantSearchDoc);

	#맞춤인재설정 가져오자.


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
			$guzic_age_start = $_POST['guzic_age_start'];					#나이
			$guzic_age_end = $_POST['guzic_age_end'];					#나이

			#이력서를 검색하기 위한 쿼리를 만들자
			if ( $search_type != '' )
			{
				$WHERE[] = " ( job_type1 = '$search_type' OR job_type2 = '$search_type' OR job_type3 = '$search_type' ) ";
			}

			if ( $search_type_sub != '' )
			{
				$WHERE[] = " ( job_type_sub1 = '$search_type_sub' OR job_type_sub2 = '$search_type_sub' OR job_type_sub3 = '$search_type_sub' ) ";
			}

			if ( $search_si != '' )
			{
				$WHERE[] = " ( job_where1_0 = '$search_si' OR job_where2_0 = '$search_si' OR job_where3_0 = '$search_si' OR job_where1_0 = '$SI_NUMBER[전국]' OR job_where2_0 = '$SI_NUMBER[전국]' OR job_where3_0 = '$SI_NUMBER[전국]' ) ";
			}

			if ( $search_gu != '' )
			{
				$WHERE[] = " ( job_where1_1 = '$search_gu' OR job_where2_1 = '$search_gu' OR job_where3_1 = '$search_gu' ) ";
			}

			if ( $job_type_read != '' )
			{
				$WHERE[] = " ( grade_gtype like '%$job_type_read%' ) ";
			}

			if ( $guziceducation != '' )
			{
				$WHERE[] = " ( grade_lastgrade = '$guziceducation' ) ";
			}

			if ( $grade_money_type != '' )
			{
				$WHERE[] = " ( grade_money_type = '$grade_money_type' ) ";
			}

			if ( $grade_money != '' )
			{
				$WHERE[] = " ( grade_money = '$grade_money' ) ";
			}

			if ( $guzicnational != '' )
			{
				$WHERE[] = " ( guzicnational = '$guzicnational' ) ";
			}

			if ( $gender_read != '' )
			{
				if ( $gender_read == 'man' )
				{
					$WHERE[] = " ( user_prefix = 'man' ) ";
				}
				else
				{
					$WHERE[] = " ( user_prefix = 'girl' ) ";
				}
			}

			//print_r2($WHERE);
			#나이
			if ( $guzic_age_start != '' && $guzic_age_end != '' )
			{
				$WHERE[] = " ( user_age >= $guzic_age_start AND user_age <= $guzic_age_end ) ";
			}
			else if ( $guzic_age_start != '' )
			{
				$WHERE[] = " ( user_age >= $guzic_age_start ) ";
			}
			else if ( $guzic_age_end != '' )
			{
				$WHERE[] = " ( user_age <= $guzic_age_end ) ";
			}

			if ( $diff_regday != '' )
			{
				$WHERE[] = " ( regdate >= date_add(regdate,interval -$diff_regday day) ) ";
			}

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

			$query_str = " ( ".implode(" AND ", (array) $WHERE)." ) ";
			$query_str = addslashes($query_str);
			#이력서를 검색하기 위한 쿼리를 만들자

			if ( is_array($WantSearchDoc) )
			{
				$sql = "update ".$job_com_want_search." set ";
				#$sql.= "id = '".$MEM['id']."', ";
				$sql.= "job_type1 = '".$_POST['search_type']."', ";
				$sql.= "job_type2 = '".$_POST['search_type_sub']."', ";
				$sql.= "si = '".$_POST['search_si']."', ";
				$sql.= "gu = '".$_POST['search_gu']."', ";
				$sql.= "grade_gtype = '".$job_type_read."', ";
				$sql.= "guziceducation = '".$_POST['guziceducation']."', ";
				$sql.= "career_read_start = '".$_POST['career_read_start']."', ";
				$sql.= "career_read_end = '".$_POST['career_read_end']."', ";
				$sql.= "grade_money_type = '".$_POST['grade_money_type']."', ";
				$sql.= "grade_money = '".$_POST['grade_money']."', ";
				$sql.= "guzicnational = '".$_POST['guzicnational']."', ";
				$sql.= "guzic_age_start = '".$_POST['guzic_age_start']."', ";
				$sql.= "guzic_age_end = '".$_POST['guzic_age_end']."', ";
				$sql.= "diff_regday = '".$_POST['diff_regday']."', ";
				$sql.= "gender_read = '".$_POST['gender_read']."', ";
				$sql.= "query_str = '".$query_str."', ";
				$sql.= "regdate = now() ";
				$sql.= "where id = '".$MEM['id']."'";
				query($sql);
			}
			else
			{
				$sql = "insert into ".$job_com_want_search." set ";
				$sql.= "id = '".$MEM['id']."', ";
				$sql.= "job_type1 = '".$_POST['search_type']."', ";
				$sql.= "job_type2 = '".$_POST['search_type_sub']."', ";
				$sql.= "si = '".$_POST['search_si']."', ";
				$sql.= "gu = '".$_POST['search_gu']."', ";
				$sql.= "grade_gtype = '".$job_type_read."', ";
				$sql.= "guziceducation = '".$_POST['guziceducation']."', ";
				$sql.= "career_read_start = '".$_POST['career_read_start']."', ";
				$sql.= "career_read_end = '".$_POST['career_read_end']."', ";
				$sql.= "grade_money_type = '".$_POST['grade_money_type']."', ";
				$sql.= "grade_money = '".$_POST['grade_money']."', ";
				$sql.= "guzicnational = '".$_POST['guzicnational']."', ";
				$sql.= "guzic_age_start = '".$_POST['guzic_age_start']."', ";
				$sql.= "guzic_age_end = '".$_POST['guzic_age_end']."', ";
				$sql.= "diff_regday = '".$_POST['diff_regday']."', ";
				$sql.= "gender_read = '".$_POST['gender_read']."', ";
				$sql.= "query_str = '".$query_str."', ";
				$sql.= "regdate = now() ";
				query($sql);
			}
			msg("맞춤인재정보 설정이 완료되었습니다.");
			go("./com_want_search.php?mode=setting_form");

		}
		else if ( $_GET['mode'] == "setting_form" )
		{
			$현재위치 = "$prev_stand > 마이페이지 > 맞춤인재정보 설정하기";


			if ( !is_array($WantSearchDoc) )
			{
				$WantSearchDoc['guzicnational'] = $TNational[0];
			}
			#print_r2($WantSearchDoc);

			$맞춤업종설정	= make_type_selectbox("search_type","search_type_sub",$WantSearchDoc['job_type1'],$WantSearchDoc['job_type2'],"250","250","a_f_guin");

			$맞춤지역설정	= make_si_selectbox("search_si","search_gu",$WantSearchDoc['si'],$WantSearchDoc['gu'],"140","140","a_f_guin");

			$맞춤고용형태설정		= make_selectbox($job_arr,'--선택--',grade_gtype,$WantSearchDoc['grade_gtype']);

			#학력
			$맞춤학력설정 = make_selectbox2($edu_arr,$edu_arr,"학력","guziceducation",$WantSearchDoc['guziceducation'],$select_width="200px");

			#경력
			$career_start	= $career_start_arr;
			$career_end		= $career_end_arr;
			$맞춤경력시작설정	= make_selectbox($career_start,'--선택--',career_read_start,$WantSearchDoc['career_read_start']);
			$맞춤경력종료설정	= make_selectbox($career_end,'--선택--',career_read_end,$WantSearchDoc['career_read_end']);

			#국적
			$맞춤국적설정 = make_radiobox2($TNational,$TNational,4,"guzicnational","guzicnational",$WantSearchDoc['guzicnational']);

			#희망연봉타입만 사용함
			$names	= Array("want_money_arr");
			$return	= Array("희망연봉타입");
			$vals	= Array($WantSearchDoc["grade_money_type"]);

			for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
			{
				$options	= "<option value=''>- 전체 -</option>";

				/*
				if ( $names[$x] == 'want_money_arr' ) //희망연봉타입
				{
					${$names[$x]} = array_merge(${$names[$x]}, $money_arr);
				}
				*/

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

			$맞춤성별설정		= make_selectbox2($gendern,$gender,'--선택--',gender_read,$WantSearchDoc['gender_read']);



			$맞춤연령시작설정	= "<select name='guzic_age_start' ><option value=''>연령선택</option>";
			for ( $i=10, $year=date("Y")-9 ; $i<100 ; $i++ , $year-- )
			{
				$selected		= $WantSearchDoc['guzic_age_start'] == $i ? 'selected' : '';
				$맞춤연령시작설정	.= "<option value='$i' $selected >${i}세 (${year}년생)</option>";
			}
			$맞춤연령시작설정	.= "</select>";

			$맞춤연령종료설정	= "<select name='guzic_age_end' ><option value=''>연령선택</option>";
			for ( $i=10, $year=date("Y")-9 ; $i<100 ; $i++ , $year-- )
			{
				$selected		= $WantSearchDoc['guzic_age_end'] == $i ? 'selected' : '';
				$맞춤연령종료설정	.= "<option value='$i'  $selected >${i}세 (${year}년생)</option>";
			}
			$맞춤연령종료설정	.= "</select>";


			$등록일차이 = make_selectbox2($TLastRegDayN,$TLastRegDay,"","diff_regday",$WantSearchDoc['diff_regday'],$select_width="80");

			$TPL->define("마춤인재정보설정", "./$skin_folder/com_want_search.html");
			$TPL->assign("마춤인재정보설정");
			$내용 = &$TPL->fetch();

			$tmp_file = $ADMIN[admin_info_guin];



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




			$TPL->define("껍데기", "./$skin_folder/$Template_Default");
			$TPL->assign("껍데기");
			$ALL = &$TPL->fetch();
			echo $ALL;
			exit;
		}
		else if ( $_GET['mode'] == "list" )
		{
			$file = "guzic_want_search.html";
			$file2 = "default_com.html";
			$현재위치 = "$prev_stand > 마이페이지 > 맞춤인재정보";

			//print_r2($WantSearchDoc);
			//unset($WantSearchDoc);
			#검색되도록
			$_GET["guzic_jobtype1"] = $WantSearchDoc['job_type1'];
			$_GET["guzic_jobtype2"] = $WantSearchDoc['job_type2'];
			$_GET["guzic_si"] = $WantSearchDoc['si'];
			$_GET["guzic_gu"] = $WantSearchDoc['gu'];
			$_GET["job_type_read"] = $WantSearchDoc['grade_gtype'];
			$_GET['guziceducation'] = $WantSearchDoc['guziceducation'];
			$_GET["career_read_start"] = $WantSearchDoc['career_read_start'];
			$_GET["career_read_end"] = $WantSearchDoc['career_read_end'];
			$_GET['grade_money_type'] = $WantSearchDoc['grade_money_type'];
			$_GET["guzic_money"] = $WantSearchDoc['grade_money'];
			$_GET['guzicnational'] = $WantSearchDoc['guzicnational'];
			$_GET['guzic_age_start'] = $WantSearchDoc['guzic_age_start'];
			$_GET['guzic_age_end'] = $WantSearchDoc['guzic_age_end'];
			$_GET['diff_regday'] = $WantSearchDoc['diff_regday'];
			$_GET['guzic_prefix'] = $WantSearchDoc['gender_read'];

			$searchMethod2	= "";
			#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
			$searchMethod2	.= "&file=".urlencode($_GET['file']);
			$searchMethod2	.= "&file2=".urlencode($_GET['file2']);
			$searchMethod2	.= "&category=".urlencode($nowCategory);
			$searchMethod2	.= "&sort=".urlencode($_GET['sort']);
			$searchMethod2	.= "&search_word=".urlencode($_GET["search_word"]);
			$searchMethod2	.= "&get_si=".urlencode($_GET['get_si']);
			$searchMethod2	.= "&guzic_money=".urlencode($_GET['guzic_money']);
			$searchMethod2	.= "&guzic_school=".urlencode($_GET['guzic_school']);
			$searchMethod2	.= "&guzic_level=".urlencode($_GET['guzic_level']);
			$searchMethod2	.= "&guzic_keyword=".urlencode($_GET['guzic_keyword']);
			$searchMethod2	.= "&guzic_si=".urlencode($_GET['guzic_si']);
			$searchMethod2	.= "&guzic_gu=".urlencode($_GET['guzic_gu']);
			$searchMethod2	.= "&guzic_jobtype1=".urlencode($_GET['guzic_jobtype1']);
			$searchMethod2	.= "&guzic_jobtype2=".urlencode($_GET['guzic_jobtype2']);
			$searchMethod2	.= "&guzic_word=".urlencode($_GET['guzic_word']);
			$searchMethod2	.= "&guzic_ppt=".urlencode($_GET['guzic_ppt']);
			$searchMethod2	.= "&guzic_excel=".urlencode($_GET['guzic_excel']);
			$searchMethod2	.= "&guzic_internet=".urlencode($_GET['guzic_internet']);
			$searchMethod2	.= "&guzic_prefix=".urlencode($_GET['guzic_prefix']);
			$searchMethod2	.= "&my=".urlencode($_GET['my']);
			$searchMethod2	.= "&guzic_school_type=".urlencode($_GET['guzic_school_type']);
			$searchMethod2	.= "&guzic_age=".urlencode($_GET['guzic_age']);
			$searchMethod2	.= "&guzic_age_end=".urlencode($_GET['guzic_age_end']);
			$searchMethod2	.= "&guzic_age_start=".urlencode($_GET['guzic_age_start']);

			$searchMethod2	.= "&mode=".urlencode($_GET['mode']);
			$searchMethod2	.= "&job_type_read=".urlencode($_GET['job_type_read']);
			$searchMethod2	.= "&guziceducation=".urlencode($_GET['guziceducation']);
			$searchMethod2	.= "&career_read_start=".urlencode($_GET['career_read_start']);
			$searchMethod2	.= "&career_read_end=".urlencode($_GET['career_read_end']);
			$searchMethod2	.= "&grade_money_type=".urlencode($_GET['grade_money_type']);
			$searchMethod2	.= "&grade_money_type=".urlencode($_GET['grade_money_type']);
			$searchMethod2	.= "&guzicnational=".urlencode($_GET['guzicnational']);
			$searchMethod2	.= "&diff_regday=".urlencode($_GET['diff_regday']);

			#검색값 입력완료
			$searchMethod	= $searchMethod2 . "&number=".urlencode($_GET['number']);
			//echo $searchMethod;
			$더보기링크 = "./guzic_list.php?".$searchMethod."&file=&file2=&diff_regday=";

			#검색되도록

			$WantSearchDoc["job_type1_name"]	= $TYPE[$WantSearchDoc["job_type1"]];
			$WantSearchDoc["job_type2_name"]	= $TYPE_SUB[$WantSearchDoc["job_type2"]];

			if ( $WantSearchDoc["job_type1_name"] == "" && $WantSearchDoc["job_type2_name"] == "" )
			{
				$WantSearchDoc["job_type1_name"] = "설정안됨";
			}

			$WantSearchDoc['si_name'] = $SI[$WantSearchDoc['si']];
			$WantSearchDoc['gu_name'] = $GU[$WantSearchDoc['gu']];
			if ( $WantSearchDoc['si_name'] == "" && $WantSearchDoc['gu_name'] == "" )
			{
				$WantSearchDoc['si_name'] = "설정안됨";
			}

			if ( $WantSearchDoc['grade_gtype'] == "" )
			{
				$WantSearchDoc['grade_gtype'] = "설정안됨";
			}

			if ( $WantSearchDoc['guziceducation'] == "" )
			{
				$WantSearchDoc['guziceducation'] = "설정안됨";
			}

			if ( $WantSearchDoc['grade_money'] == "" )
			{
				$WantSearchDoc['grade_money'] = "";
			}

			if ( $WantSearchDoc['guzicnational'] == "" )
			{
				$WantSearchDoc['guzicnational'] = "설정안됨";
			}

			#나이
			if ( $WantSearchDoc['guzic_age_start'] != "" && $WantSearchDoc['guzic_age_end'] != "")
			{
				$WantSearchDoc['guzic_age_message'] = $WantSearchDoc['guzic_age_start'].' 세 ~ '.$WantSearchDoc['guzic_age_end'].' 세';
			}
			else if ( $WantSearchDoc['guzic_age_start'] != "" )
			{
				$WantSearchDoc['guzic_age_message'] = $WantSearchDoc['guzic_age_start'].' 세 이상';
			}
			else if ( $WantSearchDoc['guzic_age_end'] != "" )
			{
				$WantSearchDoc['guzic_age_message'] = $WantSearchDoc['guzic_age_end'].' 세 이하';
			}
			else
			{
				$WantSearchDoc['guzic_age_message'] = "설정안됨";
			}

			if ( $WantSearchDoc['diff_regday'] == "" )
			{
				$WantSearchDoc['diff_regday'] = "설정안됨";
			}

			if ( $WantSearchDoc['gender_read'] == "" )
			{
				$WantSearchDoc['gender_read'] = "설정안됨";
			}


			#경력
			if ( $WantSearchDoc['career_read_start'] != '' && $WantSearchDoc['career_read_end'] != '' )
			{
				$WantSearchDoc['career_read_message'] = $WantSearchDoc['career_read_start'].' '.$WantSearchDoc['career_read_end'];
			}
			else if ( $WantSearchDoc['career_read_start'] != '' )
			{
				$WantSearchDoc['career_read_message'] = $WantSearchDoc['career_read_start'];
			}
			else if ( $WantSearchDoc['career_read_end'] != '' )
			{
				$WantSearchDoc['career_read_message'] = $WantSearchDoc['career_read_end'];
			}
			else
			{
				$WantSearchDoc['career_read_message'] = '설정안됨';
			}

			if ( $WantSearchDoc['gender_read'] == "man" )
			{
				$WantSearchDoc['gender_read'] = "남자";
			}
			else if ( $WantSearchDoc['gender_read'] == "girl" )
			{
				$WantSearchDoc['gender_read'] = "여자";
			}
			else
			{
				$WantSearchDoc['gender_read'] = "무관";
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


			$TPL->define("껍데기", "./$skin_folder/$Template_Default");
			$TPL->assign("껍데기");
			echo $TPL->fetch();

		}
	}


?>