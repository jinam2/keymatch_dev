<?php
	//게시판리스트용 xml
	include ("../../inc/config.php");
	include("inc/function.php");
	include("../../inc/ns_lib_encode.php");
	include("inc/lib.php");
	include("../../inc/ns_Template.php");
	$TPL = new Template;
	include("../../inc/ns_Template_make.php");
	Header("Content-type: text/html; charset=utf-8");

	//print_r($_POST);
	$news_site = get_news_store_info();

	//일단 클라이이언트 로그인설정 체크
	if ( news_store_login_check() != true )
	{
		$rows_str = '<?xml version="1.0" encoding="UTF-8"?>';
		$rows_str.= '<category_list>';
		$rows_str.= '<status>error01</status>';
		$rows_str.= '</category_list>';
		//exit;
	}
	//뉴스상점에서 받은 값이 제대로 된건지 체크
	else if ( $_POST['store_id'] != $news_site['id'] || $_POST['store_pass'] != $news_site['pass'] )
	{
		$rows_str = '<?xml version="1.0" encoding="UTF-8"?>';
		$rows_str.= '<category_list>';
		$rows_str.= '<status>error01</status>';
		$rows_str.= '</category_list>';
		//exit;
	}
	else
	{


		$sql = "select count(*) from $board_list ";
		$result = query($sql);
		list($category_cnt) = happy_mysql_fetch_array($result);


		$random	= rand(1000,9999);
		$TPL->define("New_temp$random", "$skin_folder/rows_board.html");

		$rows_str = '<?xml version="1.0" encoding="UTF-8"?>';
		$rows_str.= '<category_list>';
		$rows_str.= '<status>ok</status>';
		$rows_str.= '<category_cnt>'.$category_cnt.'</category_cnt>';
		//print_r($_SERVER);

		$sql = "select * from $board_list order by number desc ";
		$result = query($sql);
		while($row = happy_mysql_fetch_assoc($result))
		{
			$number = $row['number'];
			$thread = $row['tbname'];
			$title = $row['board_name'];

			board_db_setting($thread);
			
			//print_r($TCATE);
			$title	= htmlspecialchars($title);
			
			//게시판 1개에 대한 xml 포맷
			$one_row = &$TPL->fetch("New_temp$random");

			$rows_str.= $one_row;
		}
		$rows_str.= '</category_list>';


	}


	//뉴스상점에 전달하는 데이터는 ut-f8
	if ( $news_encoding == "e" )
	{
		$return_xml2 = iconv("euc-kr","utf-8//IGNORE",$rows_str);
	}
	else
	{
		$return_xml2 = $rows_str;
	}


	echo $return_xml2;


?>