<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$kind			= $_GET["kind"];
	$search_word	= $_GET["all_keyword"];


	$area_read_tmp	= ( $_GET['area_read'] == "" )?"서울":$_GET['area_read'];
	$flash_file		= $xml_flash[$area_read_tmp];

	$현재위치		= "<img src=img/icon_home.gif border=0> <a href='$main_url'>메인</a> &gt; 네이버 검색결과";


	$keyword_chk	= preg_replace("/([a-zA-Z0-9_.,-?@]|[\xA1-\xFE][\xA1-\xFE]|\s)/",'', $search_word);

	if ( $keyword_chk != "" && $server_character == "euckr")
	{
		error(" 잘못된 검색단어 입니다.   \\n 영문,숫자,한글만 허용됩니다.   ");
		exit;
	}




	# 네이버 로컬 검색 위한 시작지점 위경도 지정
	$data				= getcontent_wgs($naver_search_local_st);
	$xpoint				= getpoint($data,"<x>","</x>");
	$ypoint				= getpoint($data,"<y>","</y>");

	$wgsArr				= get_wgs_point($xpoint, $ypoint);

	$member_near_xpoint	= $wgsArr['x_point'];
	$member_near_ypoint	= $wgsArr['y_point'];

	$_GET['map_point']	= $wgsArr['x_point'] .','. $wgsArr['y_point'];





	if ( $_GET["file"] == '' )
	{
		error('ERROR');
		exit;
	}

	$file				= $_GET["file"];
	$tmp				= explode(".",$file);
	$file_ext			= $tmp[sizeof($tmp)-1];
	$file				= str_replace($file_ext,"",$file);
	$file				= preg_replace("/\W/","",$file) .".". $file_ext;

	if( !(is_file("$skin_folder/$file")) ) {
		print "$skin_folder/$file 파일이 존재하지 않습니다.";
		return;
	}

	if ( is_file("$skin_folder/$file") )
	{
		$TPL->define("알맹이", "$skin_folder/$file");
		$content			= &$TPL->fetch();
	}




	$내용	= $content;



	$TPL->define("껍데기", "$skin_folder/default_all_search.html");
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