<?php

include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");
include ("../inc/Template.php");
$TPL = new Template;


//$_GET
//$_POST
//$_COOKIE

// 과거의 날짜
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// 항상 변경됨
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");



if ( !admin_secure("환경설정") ) {
	error("접속권한이 없습니다.");
	exit;
}

################################################
include ("tpl_inc/top_new.php");
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
//include ("tpl_inc/top_side.php");
################################################

if( $mode == "add_ok" )
{
	//고유번호 1번 단어 삭제 - hong
	$Sql		= "SELECT COUNT(number) FROM $auto_search_tb";
	list($cnt)	= happy_mysql_fetch_array(query($Sql));

	if ( $cnt == 0 )
	{
		query("INSERT INTO $auto_search_tb SET date = now()");
	}
	else
	{
		query("UPDATE $auto_search_tb SET auto_word = '' WHERE number = 1");
	}

	$list = happy_mysql_fetch_array(query("select * from $auto_search_tb where auto_word = '$add_word'"));

	if( $list["number"] )
	{
		error("이미 등록된 단어입니다.");
		exit;
	}

	$sql = "
				insert into $auto_search_tb set
						auto_word	= '$add_word',
						date			= now()
	";
	$result = query($sql);

	if( $result )
	{
		gomsg("해당 단어를 등록하였습니다.","auto_search_word.php");
		exit;
	}
	else
	{
		error("해당 단어를 등록하지 못하였습니다.");
		exit;
	}

}
else if( $mode == "del" )
{
	$result = query("delete from $auto_search_tb where number=$num");

	if( $result )
	{
		gomsg("해당 단어를 삭제하였습니다.","auto_search_word.php");
		exit;
	}
	else
	{
		error("해당 단어를 삭제하지 못하였습니다.");
		exit;
	}
}
else if( $mode == "config_ok" )
{
	//고유번호 1번 단어 삭제 - hong
	$Sql		= "SELECT COUNT(number) FROM $auto_search_tb";
	list($cnt)	= happy_mysql_fetch_array(query($Sql));

	if ( $cnt == 0 )
	{
		$result = query("INSERT INTO $auto_search_tb SET auto_use = '$auto_search_use', date = now()");
	}
	else
	{
		$result = query("update $auto_search_tb set auto_use = '$auto_search_use' where number =1");
	}

	if( $result )
	{
		gomsg("자동완성 기능설정을 수정하였습니다.","auto_search_word.php");
		exit;
	}
	else
	{
		error("자동완성 기능설정을 수정하지 못하였습니다.");
		exit;
	}
}
else
{
/*
$sql ="
create table auto_search_word (
 number int not null auto_increment primary key,
 auto_word varchar(50) not null,
 date datetime not null default '0000-00-00 00:00:00',
 key(number),
 key(auto_word)
);
";
query($sql);
*/



	####################### 페이징처리 ########################
	$start			= ( $_GET["start"]=="" )?0:$_GET["start"];
	$scale			= 15;

	$Sql	= "select count(*) from $auto_search_tb WHERE number != 1 $WHERE";
	$Temp	= happy_mysql_fetch_array(query($Sql));
	//$Total	= $Count	= $Temp[0];
	$Total	= $Count	= $Temp[0];
	//마지막페이지 버그
	$Count = $Count - $start;


	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= 6;

	$searchMethod	= "";
		#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
			$searchMethod	.= "&search_word=$search_word&search_type=$search_type&group_select=$group_select";
		#검색값 입력완료

	$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	###################### 페이징처리 끝 #######################
	$config_search = happy_mysql_fetch_array(query("select auto_use from $auto_search_tb where number = 1"));
	if( $config_search["auto_use"] )
	{
		$checked1 = "checked";
		$checked2 = "";
	}
	else
	{
		$checked1 = "";
		$checked2 = "checked";
	}
	$sql = "select * from $auto_search_tb where number != 1 order by number desc LIMIT $start,$scale";
	$result = query($sql);
	include ("./html/auto_search_word.html");
}


include ("tpl_inc/bottom.php");
################################################
#하단부분 HTML 소스코드
//include ("tpl_inc/bottom.php");
################################################
?>