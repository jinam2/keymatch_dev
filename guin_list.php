<?
	$t_start = array_sum(explode(' ', microtime()));

	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

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


	if ($guzic_jobtype1){
		$add_location1 = " > <a href=guin_list.php?guzic_jobtype1=$guzic_jobtype1>".$TYPE[$guzic_jobtype1] . "</a>";
	}
	if ($guzic_jobtype2){
		$add_location2 = " > <a href=guin_list.php?guzic_jobtype1=$guzic_jobtype1&guzic_jobtype2=$guzic_jobtype2>". $TYPE_SUB[$guzic_jobtype2] . "</a>";
	}

	//상단 카테고리명 출력
	$카테고리명			= Array();
	$카테고리명['1차']	= ( $_GET['guzic_jobtype1'] != "" ) ? $TYPE[$_GET['guzic_jobtype1']]		: "전체";
	$카테고리명['2차']	= ( $_GET['guzic_jobtype2'] != "" ) ? $TYPE_SUB[$_GET['guzic_jobtype2']]	: "";


	#금지단어 체크
	if ( DenyWordCheck($_GET['title_read'],$TDenyWordList) )
	{
		error(" 검색하실수 없는 금지단어가 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크

	//성인인증을 받지 않았다면.. 성인인증 페이지로 이동시키자!
	if(!$_COOKIE[adult_check])
	{
		$add_sql = "use_adult != '1'";
	}

	$검색어	= "";

	$search_si			= $_GET["search_si"];
	$search_gu			= $_GET["search_gu"];
	$search_type		= ( $_GET["search_type"] != "" )?$_GET["search_type"]:$_GET["guzic_jobtype1"];
	$search_type_sub	= ( $_GET["search_type_sub"] != "" )?$_GET["search_type_sub"]:$_GET["guzic_jobtype2"];
	$career_read		= $_GET["career_read"];
	$gender_read		= $_GET["gender_read"];
	$pay_read			= $_GET["pay_read"];
	$edu_read			= $_GET["edu_read"];
	$job_type_read		= $_GET["job_type_read"];

	$검색어	.= ( $search_si != "" )?$siSelect[$search_si]." ":"";
	$검색어	.= ( $search_gu != "" )?$guSelect[$search_gu]." 지역내 ":"";
	$검색어	.= ( $search_type != "" )?$TYPE[$search_type]." ":"";
	$검색어	.= ( $search_type_sub != "" )?$TYPE_SUB[$search_type_sub]." ":"";
	$검색어	.= ( $edu_read != "" )?$edu_read." $_GET[guzic_school_type] 학력 ":"";
	$검색어	.= ( $career_read != "" )?"경력(".$career_read.") ":"";
	$검색어	.= ( $gender_read != "" )?"성별(".$gender_read.") ":"";
	$검색어	.= ( $pay_read != "" )?"연봉(".$pay_read.") ":"";
	$검색어	.= ( $job_type_read != "" )?$job_type_read." ":"";

	$검색어	.= ( $검색어 != "" )?"</b><font color=#444444>검색 결과</font>":"";

	$_GET["job_type_read"] = $_GET["job_type_read"] == ""? "전체" : $_GET["job_type_read"];

	$현재위치	= " $prev_stand > <a href='guin_list.php'>채용정보 리스트($_GET[job_type_read])</a> $add_location1 $add_location2 ";

	$file	= ( $_GET["file"] == "" )?"guin_list.html":$_GET["file"];

	$sort_how = sort_how_return();
	$채용정보정렬 = $sort_how;

	//마감일검색
	$채용정보마감일정렬 = sort_how_return('guin_end');



	if ( $file == "guin_list_after.html" )
	{
		if ( $search_si != "" )
		{
			$채용정보리스트제목 = $siSelect[$search_si];
		}
		else if ( $job_type_read != "" )
		{
			$채용정보리스트제목 = $job_type_read;
		}
		else
		{
			$채용정보리스트제목 = "전체";
		}
	}
	else if ( $file == "guin_new.html" )
	{
		if ( $career_read != "" )
		{
			//$채용정보리스트제목 = $career_read;
			$채용정보리스트제목 = "경력·형태별";
		}
		else
		{
			$채용정보리스트제목 = "전체";
		}
	}


	if ( !is_file("$skin_folder/${file}") )
	{
		echo "$skin_folder/${file} 파일이 존재하지 않습니다.";
		exit;
	}

	//echo "$skin_folder/${file}";
	$TPL->define("상세", "$skin_folder/${file}");
	$TPL->assign("상세");
	$내용 = &$TPL->fetch();

#echo $skin_folder/default_guin.html;
	$TPL->define("껍데기", "$skin_folder/default_guin.html");
	$TPL->assign("껍데기");
	echo $TPL->fetch();

	if ($demo)
	{
		$exec_time = array_sum(explode(' ', microtime())) - $t_start;
		$exec_time = round ($exec_time, 2);
		print   "<center><font color=gray size=1>Query Time : $exec_time sec";
	}
	exit;



?>