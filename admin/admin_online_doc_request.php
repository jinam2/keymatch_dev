<?php
	//기업회원 -> 온라인입사지원요청내역 프로그램
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/function.php");
	include ("../inc/lib.php");

	if ( !admin_secure("구직리스트") )
	{
		error("접속권한이 없습니다.   ");
		exit;
	}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################


	if ( $_GET['mode'] == "guin" )
	{
		//각 채용정보별로 온라인입사지원요청 내역
		$TemplateFile = "admin_online_doc_request.html";

		$ex_limit = 15;

		//채용정보
		$sql = "select * from $guin_tb where number = '".$_GET['guin_number']."'";
		$result = query($sql);
		$Guin = happy_mysql_fetch_assoc($result);

		$sql = "select count(*) from $com_want_doc_tb where guin_number = '".$_GET['guin_number']."'";
		$result = query($sql);
		list($numb) = happy_mysql_fetch_array($result);
		//echo $sql;

		$plus .= "&mode=".urlencode($_GET['mode']);
		$plus .= "&guin_number=".urlencode($_GET['guin_number']);


		$pg = $_GET[pg];
		if($pg==0 || $pg=="")
		{
			$pg=1;
		}

		//페이지 나누기
		$total_page = ( $numb - 1 ) / $ex_limit+1; //총페이지수
		$total_page = floor($total_page);
		$view_rows = ($pg - 1) * $ex_limit;
		$co  =  $numb  -  $ex_limit  *  ( $pg - 1 );


		$Datas = array();
		$auto_number = $co;

		$sql = "select * from $com_want_doc_tb where guin_number = '".$_GET['guin_number']."'";
		$sql.= " LIMIT ".$view_rows.",".$ex_limit;
		$result = query($sql);

		while ( $Data = happy_mysql_fetch_assoc($result) )
		{
			//채용정보쪽
			$OutData['c_id'] = $Guin['guin_id'];
			$OutData['guin_title'] = kstrcut($Guin['guin_title'],40,"...");
			$OutData['guin_number'] = $Guin['number'];

			//이력서쪽
			$sql3 = "select * from $per_document_tb where number = '".$Data['doc_number']."'";
			$result3 = query($sql3);
			$Doc = happy_mysql_fetch_assoc($result3);

			$OutData['p_id'] = $Data['per_id'];
			if ( $Doc['number'] == "" )
			{
				$OutData['doc_title'] = "삭제된 구직정보입니다.";
			}
			else
			{
				$OutData['doc_title'] = '<a href="../document_view.php?number='.$Doc['number'].'">'.kstrcut($Doc['title'],40,"...").'</a>';
			}

			if ( $Data['read_ok'] == "N" )
			{
				$OutData['icon_status'] = "<span class='btn_small_red' style='display:inline-block !important; cursor:default !important'>확인전</span>";
			}
			else if ( $Data['read_ok'] == "Y" )
			{
				$OutData['icon_status'] = "<span class='btn_small_blue' style='display:inline-block !important; cursor:default !important'>확인전</span>";
			}

			$OutData['auto_number'] = $auto_number;
			array_push($Datas,$OutData);

			//print_r($Datas);
			$auto_number--;
		}

		if ( $numb > 0 )
		{
			include ("./page.php");
		}


		$TPL->define("결과물", "./$skin_folder/$TemplateFile");
		$TPL->assign("LOOP", $Datas);
		$TPL->assign("결과물");
		$TPL->tprint();
	}
	else if ( $_GET['mode'] == "guzic" )
	{
		//각 이력서별로 온라인입사지원요청 내역
		$TemplateFile = "admin_online_doc_request_guzic.html";

		$ex_limit = 15;

		//이력서정보
		$sql = "select * from $per_document_tb where number = '".$_GET['guzic_number']."'";
		$result = query($sql);
		$Doc = happy_mysql_fetch_assoc($result);

		$sql = "select count(*) from $com_want_doc_tb where doc_number = '".$_GET['guzic_number']."'";
		$result = query($sql);
		list($numb) = happy_mysql_fetch_array($result);
		//echo $sql;

		$plus .= "&mode=".urlencode($_GET['mode']);
		$plus .= "&guzic_number=".urlencode($_GET['guzic_number']);



		$pg = $_GET[pg];
		if($pg==0 || $pg=="")
		{
			$pg=1;
		}

		//페이지 나누기
		$total_page = ( $numb - 1 ) / $ex_limit+1; //총페이지수
		$total_page = floor($total_page);
		$view_rows = ($pg - 1) * $ex_limit;
		$co  =  $numb  -  $ex_limit  *  ( $pg - 1 );


		$Datas = array();
		$auto_number = $co;

		$sql = "select * from $com_want_doc_tb where doc_number = '".$_GET['guzic_number']."'";
		$sql.= " LIMIT ".$view_rows.",".$ex_limit;
		$result = query($sql);

		while ( $Data = happy_mysql_fetch_assoc($result) )
		{
			//이력서쪽
			$OutData['p_id'] = $Data['per_id'];
			$OutData['doc_title'] = "<a href='../document_view.php?number=".$Data['doc_number']."'>".kstrcut($Doc['title'],40,"...")."</a>";


			//채용정보쪽
			$sql3 = "select * from $guin_tb where number = '".$Data['guin_number']."'";
			$result3 = query($sql3);
			$Guin = happy_mysql_fetch_assoc($result3);

			$OutData['c_id'] = $Data['com_id'];
			if ( $Guin['number'] == "" )
			{
				$OutData['guin_title'] = "삭제된 구인정보입니다.";
			}
			else
			{
				$OutData['guin_title'] = '<a href="../guin_detail.php?num='.$Guin['number'].'">'.kstrcut($Guin['guin_title'],40,"...").'</a>';
			}

			if ( $Data['read_ok'] == "N" )
			{
				$OutData['icon_status'] = "<span class='btn_small_red' style='display:inline-block !important; cursor:default !important '>확인전</span>";
			}
			else if ( $Data['read_ok'] == "Y" )
			{
				$OutData['icon_status'] = "<span class='btn_small_blue' style='display:inline-block !important; cursor:default !important'>확인함</span>";
			}


			$OutData['auto_number'] = $auto_number;
			array_push($Datas,$OutData);

			//print_r($Datas);
			$auto_number--;
		}

		if ( $numb > 0 )
		{
			include ("./page.php");
		}


		$TPL->define("결과물", "./$skin_folder/$TemplateFile");
		$TPL->assign("LOOP", $Datas);
		$TPL->assign("결과물");
		$TPL->tprint();

	}

	include ("tpl_inc/bottom.php");






?>