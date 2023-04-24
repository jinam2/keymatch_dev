<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( $_GET[number] != "")
	{
		$Sql = "SELECT * FROM $guin_tb WHERE number='$_GET[number]'";
		$Data	= happy_mysql_fetch_array(query($Sql));

		if ( $Data['guin_id'] !=  $mem_id &&  $mem_id && $_COOKIE['ad_id'] == "" )
		{
			error("잘못된 경로로 접근하셨습니다.");
			exit;
		}
	}


	$sql = "select * from $type_tb where number = '$search_type'";
	$result = query($sql);
	$Data_adult_check = happy_mysql_fetch_array($result);



	//슈퍼관리자가 아니면서...성인인증을 받지 않았거나 로그인(성인)을 하지 않은 경우는 성인 리스트를 보여주지 말자!		2010-09-30	Hun
	if(!$_COOKIE['ad_id'] && !$_COOKIE['adult_check'] && !$mem_id && $Data_adult_check['use_adult'])
	{
		$go_url = urlencode($_SERVER['REQUEST_URI']);
		gomsg("성인인증을 하셔야 합니다.", "$main_url/html_file.php?file=adultcheck.html&file2=login_default.html&mode=adult_check&go_url=$go_url");
		exit;
	}

	if ($guzic_jobtype1)
	{
		$add_location1 = " > <a href=guzic_list.php?guzic_jobtype1=$guzic_jobtype1>".$TYPE[$guzic_jobtype1] . "</a>";
	}
	if ($guzic_jobtype2)
	{
		$add_location2 = " > <a href=guzic_list.php?guzic_jobtype1=$guzic_jobtype1&guzic_jobtype2=$guzic_jobtype2>". $TYPE_SUB[$guzic_jobtype2] . "</a>";
	}

	//상단 카테고리명 출력
	$카테고리명			= Array();
	$카테고리명['1차']	= ( $_GET['guzic_jobtype1'] != "" ) ? $TYPE[$_GET['guzic_jobtype1']]		: "전체";
	$카테고리명['2차']	= ( $_GET['guzic_jobtype2'] != "" ) ? $TYPE_SUB[$_GET['guzic_jobtype2']]	: "";


	#금지단어 체크
	if ( DenyWordCheck($_GET['guzic_keyword'],$TDenyWordList) )
	{
		error(" 검색하실수 없는 금지단어가 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크

	/*원래 있던 코드*/
	$_GET["file"]	= str_replace(".html","",$_GET["file"]);
	$file	= ( $_GET["file"] == "" )?"guzic_list":$_GET["file"];
	$skin_folder_now	= ( $file == "guzic_list" )?$skin_folder:$skin_folder_file;


	switch ( $file )
	{
		case "member_guin_scrap":	$nowNevi = "스크랩한 이력서";break;
		case "member_guin_chong":	$nowNevi = "모든 지원 이력서";$chk="1";break;
		case "member_guin_noview":	$nowNevi = "미열람 지원 이력서";$chk="1";break;
		case "member_guin_ok":		$nowNevi = "예비합격자";$chk="1";break;
		default :					$nowNevi = "인재정보";break;
	}




	if ( $_GET["my"] == "1" )
	{
		$nowNevi	= "맞춤인재정보보기";
	}

	$nowNevi	= "<a href='guzic_list.php'>$nowNevi</a> $add_location1 $add_location2  ";

	if ( !eregi("guzic_",$file) || $_GET["my"] == "1" )
	{
		if ( $_GET['number'] != '' )
		{
			$nowNevi	= "<a href='member_info.php'>마이페이지</a> > <a href='member_guin.php'>채용정보</a> > $nowNevi ";
		}
		else
		{
			$nowNevi	= "<a href='member_info.php'>마이페이지</a> > $nowNevi ";
		}
	}


	if ( $chk == "1" )
	{
		$Sql = "SELECT * ,(TO_DAYS(curdate())-TO_DAYS('2005-10-21')) AS gap FROM $guin_tb WHERE number='$_GET[number]'";
		$GUIN_INFO	= happy_mysql_fetch_array(query($Sql));

		$GUIN_INFO["interview"]	= str_replace("\r","",$GUIN_INFO["guin_interview"]);
		$interview				= explode("\n",$GUIN_INFO["interview"]);

		$GUIN_INFO["interview"]	= "";
		for ( $i=1,$max=sizeof($interview) ; $i<=$max ; $i++ )
		{
			if ( $interview[$i-1] != "" )
			{
				$GUIN_INFO["interview"]	.= "질문$i : ".$interview[$i-1]."<br>";
			}
		}
	}

	//업.직종 추가함
	$GUIN_INFO["guin_job"] = "";
	if ($GUIN_INFO["type1"] != "0")
	{
		$GUIN_INFO["guin_job"] .= "1차 직종 : ".$TYPE[$GUIN_INFO["type1"]];
		if ($GUIN_INFO["type_sub1"] != "0")
		{
			$GUIN_INFO["guin_job"] .= " / ".$TYPE_SUB[$GUIN_INFO["type_sub1"]];
		}
	}
	if ($GUIN_INFO["type2"] != "0")
	{
		$GUIN_INFO["guin_job"] .= "<br>2차 직종 : ".$TYPE[$GUIN_INFO["type2"]];
		if ($GUIN_INFO["type_sub2"] != "0")
		{
			$GUIN_INFO["guin_job"] .= " / ".$TYPE_SUB[$GUIN_INFO["type_sub2"]];
		}
	}
	if ($GUIN_INFO["type3"] != "0")
	{
		$GUIN_INFO["guin_job"] .= "<br>3차 직종 : ".$TYPE[$GUIN_INFO["type3"]];
		if ($GUIN_INFO["type_sub3"] != "0")
		{
			$GUIN_INFO["guin_job"] .= " / ".$TYPE_SUB[$GUIN_INFO["type_sub3"]];
		}
	}
	//업.직종 추가함

	//진행or마감여부
	if ( $GUIN_INFO['guin_choongwon'] || $GUIN_INFO['guin_end_date'] > date("Y-m-d") )
	{
		$GUIN_INFO['guin_end_text']	= "진행중";
	}
	else
	{
		$GUIN_INFO['guin_end_text']	= "마감";
	}

	if ( $GUIN_INFO[guin_choongwon] )
	{
		$GUIN_INFO[guin_end_date] = "<span class='font_st_11_tahoma'>~ 상시채용</span>";
	}
	else
	{
		$dday_interval = date("Y-m-d",strtotime($GUIN_INFO["guin_end_date"]."-{$HAPPY_CONFIG[guin_end_date_dday]} day"));
		if(date("Y-m-d") == $GUIN_INFO["guin_end_date"])
		{
			$GUIN_INFO['guin_end_date']	= "D-day";
		}
		else if(date("Y-m-d") >= $dday_interval)
		{
			$GUIN_INFO['guin_end_date']	= "D-".happy_date_diff(date("Y-m-d"),$GUIN_INFO['guin_end_date']);
		}
	}

	if ( $GUIN_INFO["guin_pay"] == preg_replace("/\D/","",$GUIN_INFO["guin_pay"]) )
	{
		$GUIN_INFO["guin_pay"] = number_format($GUIN_INFO["guin_pay"])."원";
	}

	$GUIN_INFO["guin_pay_icon"]		= $want_money_img_arr[$GUIN_INFO['guin_pay_type']];
	$GUIN_INFO["guin_pay_icon2"]	= $want_money_img_arr2[$GUIN_INFO['guin_pay_type']];



	$guzic_money	= addslashes($_GET["guzic_money"]);
	$guzic_school	= addslashes($_GET["guzic_school"]);
	$guzic_level	= addslashes($_GET["guzic_level"]);
	$guzic_keyword	= addslashes($_GET["guzic_keyword"]);
	$guzic_si		= addslashes($_GET["guzic_si"]);
	$guzic_gu		= addslashes($_GET["guzic_gu"]);
	$guzic_type		= addslashes($_GET["guzic_jobtype1"]);
	$guzic_type_sub	= addslashes($_GET["guzic_jobtype2"]);
	$guzic_prefix	= addslashes($_GET["guzic_prefix"]);
	#$guzic_prefix	= ( $_GET["career_read"] != "" )?addslashes($_GET["career_read"]):$guzic_prefix;
	$career_read	= addslashes($_GET["career_read"]);
	$job_type_read	= addslashes($_GET["job_type_read"]);
	$guzic_keyword	= addslashes($_GET["guzic_keyword"]);

	$guzic_prefix	= ( $guzic_prefix == "man" )?"남자":$guzic_prefix;
	$guzic_prefix	= ( $guzic_prefix == "girl" )?"여자":$guzic_prefix;


	$검색어	= "";

	$검색어	.= ( $guzic_si != "" )?$siSelect[$guzic_si]." ":"";
	$검색어	.= ( $guzic_gu != "" )?$guSelect[$guzic_gu]." 지역내 ":"";
	$검색어	.= ( $guzic_type != "" )?$TYPE[$guzic_type]." ":"";
	$검색어	.= ( $guzic_type_sub != "" )?$TYPE[$guzic_type_sub]." ":"";
	$검색어	.= ( $guzic_school != "" )?$guzic_school."학력 ":"";
	$검색어	.= ( $career_read != "" )?"경력(".$career_read.") ":"";
	$검색어	.= ( $guzic_prefix != "" )?"성별(".$guzic_prefix.") ":"";
	$검색어	.= ( $guzic_money != "" )?"연봉(".$guzic_money.") ":"";
	$검색어	.= ( $job_type_read != "" )?$job_type_read." ":"";


	$검색어	.= ( $검색어 != "" )?"으로 검색한 결과":"";



	$현재위치	= " $prev_stand > $nowNevi";

	$인재정보정렬 = sort_how_return('guzic');

	if ( !is_file("$skin_folder_now/${file}.html") )
	{
		echo "$skin_folder_now/${file}.html 파일이 존재하지 않습니다.";
		exit;
	}

	#echo $file."<br>";
	#echo "$skin_folder_now/${file}.html";
	$TPL->define("상세", "$skin_folder_now/${file}.html");
	$TPL->assign("상세");
	$내용 = &$TPL->fetch();


	$Template_Default		= "default_guzic.html";
	if ( $_GET['file'] == 'member_guin_scrap' || $_GET['file'] == 'member_guin_ok' || $_GET['file'] == 'member_guin_chong' ) //마이페이지
	{
		$happy_member_login_id	= happy_member_login_check();
		$Member					= happy_member_information($happy_member_login_id);
		$member_group			= $Member['group'];

		$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
		$Group					= happy_mysql_fetch_array(query($Sql));

		$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
		$Template_Default		= $Template_Default == '' ? $happy_member_mypage_default_file : $Template_Default;
	}




	//$TPL->define("껍데기", "$skin_folder/$Template_Default");
	//$TPL->define("껍데기", "$skin_folder/default_guzic.html");

	//echo "$skin_folder/$Template_Default";
	$TPL->define("껍데기", "$skin_folder/$Template_Default");
	$TPL->assign("껍데기");
	echo $TPL->fetch();


?>