<?php
	include ("./inc/Template.php");
	$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");


	if ( $mode == "guin" ) {
		//현재위치
		$now_stand = "$prev_stand > <a href='./search.php?mode=guin'>채용정보 상세검색</a>";

		$template	= "search_guin.html";
	}

	elseif ( $mode == "guzic" ) {
		//현재위치
		$now_stand = "$prev_stand > <a href='./search.php?mode=guzic'>인재정보 상세검색</a>";

		$template	= "search_guzic.html";
		guzic_search_form();
	}


	//템플릿 파일 읽어오기
	$현재위치	= $now_stand;

	if ( !is_file("$skin_folder/$template") )
	{
		echo "$skin_folder/$template 파일이 존재하지 않습니다.";
		exit;
	}

	if ( !is_file("$skin_folder/$ADMIN[guin_list]") )
	{
		echo "$skin_folder/$ADMIN[guin_list] 파일이 존재하지 않습니다.";
		exit;
	}

	$TPL->define("본문내용", "$skin_folder/$template");
	$TPL->assign("본문내용");
	$내용 = &$TPL->fetch();


	$TPL->define("껍데기", "$skin_folder/$ADMIN[guin_list]");
	$TPL->assign("껍데기");
	$ALL = &$TPL->fetch();
	echo $ALL;



?>