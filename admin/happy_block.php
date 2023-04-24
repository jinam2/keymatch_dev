<?php

include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");
include ("../inc/Template.php");
$TPL = new Template;


if ( !admin_secure("슈퍼관리자전용") )
{
	error("접속권한이 없습니다.");
	exit;
}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

if ( $_GET['mode'] == 'del' )
{
	$Sql = "delete from $happy_hack_block_list where block_ip = '$_GET[ip]'";
	query($Sql);
	$Sql = "delete from $happy_hack_check_log where log_ip = '$_GET[ip]'";
	query($Sql);
	gomsg("삭제되었습니다.", "happy_block.php");
	exit;
}

print <<<END


<!--// 현재위치 [START] //----------->
<table cellspacing='0' cellpadding='0' style='width:100%; margin-bottom:5px;'>
<tr>
	<td class='item_title'><img src='img/ico_arrow_01.gif' border='0' style='vertical-align:middle;'>차단 IP 리스트</td>
	<td align='right'><a href='happy_block_log.php' class="btn_small_dark">로그보기</a></td>
</tr>
</table>
<!--// 현재위치 [END] //----------->




<div id='list_style'>
	<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
	<tr>
		<th style='width:80px;'>번호</th>
		<th>접속IP</th>
		<th>차단시간</th>
		<th>차단만료시간</th>
		<th>관리자툴</th>
	</tr>


END;


list($Count)	= happy_mysql_fetch_array(query("select count(*) from $happy_hack_block_list"));


####################### 페이징처리 ########################
$start			= $_GET["start"];
$scale			= 10;

$Total = $Count;

if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
$pageScale		= 6;
$페이징			= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
###################### 페이징처리 끝 #######################

$Sql	= "select * from $happy_hack_block_list order by number desc limit $start, $scale";
$Result	= query($Sql);
while ( $Data = happy_mysql_fetch_array($Result) )
{
	print <<<END
	<tr>
		<td style='text-align:center;'>$listNo</td>
		<td style='text-align:center;'>$Data[block_ip]</td>
		<td style='text-align:center;'>$Data[block_time]</td>
		<td style='text-align:center;'>$Data[block_end]</td>
		<td style='text-align:center;'>
			<a onClick="location.href='happy_block_log.php?search_type=log_ip&search_word=$Data[block_ip]';" class='btn_small_gray'>IP로그보기</a>
			<a onClick="if ( confirm ( '$Data[block_ip] 내역이 모두 삭제됩니다. 삭제하시겠습니까?' ) ) { location.href='?mode=del&ip=$Data[block_ip]'; }" class='btn_small_gray'>삭제</a>
		</td>
	</tr>
END;


	$listNo--;
}

print <<<END
	</table>
</div>
<div align='center' style='padding:20px 0 20px 0;'>$페이징</div>
END;


################################################
#하단부분 HTML 소스코드
include ("tpl_inc/bottom.php");
################################################



?>