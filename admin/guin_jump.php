<?php
$t_start = array_sum(explode(' ', microtime()));
include ("../inc/Template.php");
$TPL = new Template;
include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");

if ( !admin_secure("구인리스트") )
{
	error("접속권한이 없습니다.");
	exit;
}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################


function output_array($Data)
{
	$OutData = array();

	//제목 자르기
	if ( $Data['guin_title'] != "" )
	{
		$Data['guin_title_cut'] = kstrcut($Data["guin_title"],40,"...");
	}

	$OutData = $Data;

	return $OutData;
}

if ( $_GET['mode'] == "" )
{
	$TemplateFile = "guin_jump.html";
	//한페이지에 몇개
	$ex_limit = 10;



	$wheres = array();
	$search_type_0 = "";
	$search_type_1 = "";
	$search_type_2 = "";

	if ( $_GET['search_word'] != "" )
	{
		if ( $_GET['search_type'] == "guin_id" )
		{
			$wheres[] = " id = '".$_GET['search_word']."' ";
			$search_type_0 = " checked ";
		}
		else if ( $_GET['search_type'] == "guin_number" )
		{
			$wheres[] = " guin_number = '".$_GET['search_word']."' ";
			$search_type_1 = " checked ";
		}
		else if ( $_GET['search_type'] == "guin_title" )
		{
			$wheres[] = " guin_title like '%".$_GET['search_word']."%' ";
			$search_type_2 = " checked ";
		}

		$plus .= "&search_type=".urlencode($_GET['search_type']);
		$plus .= "&search_word=".urlencode($_GET['search_word']);
	}

	if ( count($wheres) > 0 )
	{
		$where_sql = " WHERE 1 = 1 AND ".implode(" and ", (array) $wheres);
	}

	$sql = "select count(*) from $job_guin_jump $where_sql";
	$result = query($sql);
	list($numb) = happy_mysql_fetch_array($result);

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


	$sql = "select * from $job_guin_jump $where_sql order by reg_date desc ";
	$sql.= " LIMIT ".$view_rows.",".$ex_limit;
	//echo $sql;
	$result = query($sql);

	$Datas = array();
	$auto_number = $co;

	while($Data = happy_mysql_fetch_assoc($result))
	{
		$OutData = array();
		//print_r($Data);
		$OutData = output_array($Data);
		$OutData['auto_number'] = $auto_number;

		array_push($Datas,$OutData);
		$auto_number--;
	}

	//print_r2($Datas);
	include ("./page.php");

	//unset($Datas);

	$TPL->define("결과물", "./$skin_folder/$TemplateFile");
	$TPL->assign("LOOP", $Datas);
	$TPL->assign("결과물");
	$TPL->tprint();
}
else if ( $_GET['mode'] == "del" )
{
	if ( $_GET['number'] == "" )
	{
		error("잘못된 접근");
		exit;
	}

	$jump_number = preg_replace("/\D/","",$_GET['number']);
	$sql = "delete from $job_guin_jump where number = '".$jump_number."'";
	query($sql);

	error("점프사용내역이 삭제되었습니다.");
	exit;

}





include ("tpl_inc/bottom.php");

if ($demo)
{
	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	print "<center><font color=gray size=1>Query Time : $exec_time sec";
}
exit;

?>