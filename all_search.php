<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");



	$현재위치		= "<a href='$main_url'>HOME</a> &gt; 검색결과";

	$kind			= $_GET["kind"];
	$search_word	= $_GET["all_keyword"];

	//print_r($_GET);

	if ( $server_character == "euckr" )
	{
		$keyword_chk	= preg_replace("/([a-zA-Z0-9_.,-?@]|[\xA1-\xFE][\xA1-\xFE]|\s)/",'', $search_word);

		if ( $keyword_chk != "" )
		{
			error(" 잘못된 검색단어 입니다.   \\n 영문,숫자,한글만 허용됩니다.   ");
			exit;
		}
	}

	# 네이버 로컬 검색 위한 시작지점 위경도 지정
	$data				= getcontent_wgs($naver_search_local_st);
	$xpoint				= getpoint($data,"<x>","</x>");
	$ypoint				= getpoint($data,"<y>","</y>");

	$wgsArr				= get_wgs_point($xpoint, $ypoint);

	$member_near_xpoint	= $wgsArr['x_point'];
	$member_near_ypoint	= $wgsArr['y_point'];

	$_GET['map_point']	= $wgsArr['x_point'] .','. $wgsArr['y_point'];



	#금지단어 체크
	if ( DenyWordCheck($search_word,$TDenyWordList) )
	{
		error(" 검색하실수 없는 금지단어가 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크


	if ( $search_word )
	{



		######### 실시간 검색을 위한 DB인설트 부분 ###########
/*
		if ( str_replace(" ","",$search_word) != "" )
		{
			$year		= date("Y");
			$mon		= date("m");
			$day		= date("d");

			$Sql	= "SELECT number FROM $keyword_tb WHERE year='$year' AND mon='$mon' AND day='$day' AND keyword='$search_word' ";
			$Data	= happy_mysql_fetch_array(query($Sql));

			if ( $Data["number"] == "" )
			{
				$Sql	 = "	INSERT INTO								";
				$Sql	.= "			$keyword_tb						";
				$Sql	.= "	SET										";
				$Sql	.= "			year	= '$year',				";
				$Sql	.= "			mon		= '$mon',				";
				$Sql	.= "			day		= '$day',				";
				$Sql	.= "			count	= '1',					";
				$Sql	.= "			keyword	= '$search_word',		";
				$Sql	.= "			regdate = now()					";
			}
			else
			{
				$Sql	 = "	UPDATE									";
				$Sql	.= "			$keyword_tb						";
				$Sql	.= "	SET										";
				$Sql	.= "			count = count+1					";
				$Sql	.= "	WHERE									";
				$Sql	.= "			number='$Data[number]'			";
			}
			query($Sql);

			if ( date("s") % 10 == 7 && $keyword_delete_day != 0 )
			{
				$chkDate	= date("Y-m-d", happy_mktime(0,0,0,date("m"),date("d") - $keyword_delete_day ,date("Y")));

				$Sql	= "DELETE FROM $keyword_tb WHERE regdate < '$chkDate' ";
				query($Sql);
				#echo "delete complate";
			}
		}
*/
		###################################################### 끝


	}
	else
	{
		//error("검색단어를 입력해 주십시오.");
		//exit;
	}




	guzic_search_form();

	$file		= $_GET["file"];
	$tmp		= explode(".",$file);
	$file_ext	= $tmp[sizeof($tmp)-1];
	$file		= str_replace($file_ext,"",$file);
	$file		= preg_replace("/\W/","",$file) .".". $file_ext;



	if ( $_GET["file"] == "" )
	{
		$file = "all_search.html";
	}

	if ( !is_file("$skin_folder/$file") )
	{
		echo "$skin_folder/$file 파일이 존재하지 않습니다.";
		exit;
	}

	$TPL->define("상세", "./$skin_folder/$file");
	$TPL->assign("상세");
	$내용 = &$TPL->fetch();

	if ( $검색된장르수 == 0 && $search_result_type != '1' )
	{
		$TPL->define("상세", "./$skin_folder/all_search_no.html");
		$TPL->assign("상세");
		$내용 = &$TPL->fetch();
	}

	$fullTemp	= ( $_GET["file"] == "login.html" )?"login_default.html":"default_all_search.html";

	$TPL->define("껍데기", "./$skin_folder/$fullTemp");
	$TPL->assign("껍데기");
	echo $TPL->fetch();

exit;



?>