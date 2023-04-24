<?php
	#아작스 구인리스트
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	header("Content-Type: text/html; charset=utf-8");
	$ajax_paging	= '1';
	/*
	echo $_GET['vals'];
	print_r($_GET);
	*/

	$values	= explode(",",$_GET['vals']);

	//print_r($values);


	#if ( $values[10] == '페이징' )
	#{
		usleep(rand(100,500));
	#}
	#sleep(1);

	$ajaxNum		= $_GET['ajaxNum'];
	$ajaxLayerName	= $_GET['ajaxLayer'];

	$_GET['happy_map_search'] = urldecode($_GET['happy_map_search']);

	#마춤채용정보를 마이페이지에 추출하기 위해서 추가됨
	#맞춤구인설정 가져오자.
	$sql = "select * from ".$job_per_want_search." where id = '".$MEM['id']."'";
	$result = query($sql);
	$WantSearch = happy_mysql_fetch_assoc($result);
	#맞춤구인설정 가져오자.

	//페이징노출옵션
	if ( $_COOKIE['happy_mobile'] == "on" ) //모바일모드
	{
		newPaging_option("번호양쪽1개노출","구간이동버튼","이전다음버튼","<<","이전","다음",">>");
	}
	else //PC모드
	{
		newPaging_option("번호양쪽9개노출","구간이동버튼","이전다음버튼","<<","이전","다음",">>");
	}

	//스크랩 버튼 처리 hong
	$guin_main_extraction_count = $ajaxNum;

	guin_extraction(
						$values[0],
						$values[1],
						$values[2],
						$values[3],
						$values[4],
						$values[5],
						$values[6],
						$values[7],
						$values[8],
						$values[9],
						$values[10],
						$values[11],
						$values[12],
						$values[13],
						$values[14],
						$values[16], //jobwork
						$values[17] //jobwork
					);


	if ( $values[11] != '사용안함' )
	{
		//print $total_count_script;
		//print "<br><center>".$page_print."</center>";
	}

	if ( $values[14] == '회원인접업체' && $values[11] == '사용함' )
	{
		echo "<input type='hidden' name='happy_map_total_count_tmp' id='happy_map_total_count_tmp' value='$numb'>";
	}


	//상단 카운팅용
	echo "___C_COUNT___".number_format($numb);
?>