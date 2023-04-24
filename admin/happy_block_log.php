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
	$Sql = "delete from $happy_hack_check_log where number = '$_GET[number]'";
	query($Sql);
	gomsg("삭제되었습니다.", "happy_block_log.php?search_type=$_GET[search_type]&search_word=$_GET[search_word]");
	exit;
}

print <<<END


<!--// 현재위치 [START] //----------->
<table cellspacing='0' cellpadding='0' style='width:100%; margin-bottom:5px;'>
<tr>
	<td class='item_title'><img src='img/ico_arrow_01.gif' border='0' style='vertical-align:middle;'>로그 리스트</td>
	<td align='right' style='width:250px;'>
		<form name='search_frm' action='happy_block_log.php' style='margin:0;'>
			<table border='0' cellspacing='0' cellpadding='0' id=admin_search_frm>
				<tr>
					<td>
						
						<select name='search_type'>
							<option value='log_ip' $selected>아이피</option>
						</select>
						
					</td>
					<td style='padding-left:5px;'><input type='text' name='search_word' value='$_GET[search_word]' id=search_word class='input_type2'></td>
					<td style='padding-left:5px;'><input type='submit' value=''  style='background:url(img/btnAdmin_happy_member.gif) no-repeat; border:0px solid red; width:40px; height:19px; cursor:pointer;' id=search_btn></td>
				</tr>
			</table>
		</form>
	</td>
	<td align='right' style='width:78px;'><a href='happy_block.php' class="btn_small_dark">차단 IP 보기</a></td>
</tr>
</table>
<!--// 현재위치 [END] //----------->


<div id='list_style'>
	<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
	<tr>
		<th style='width:80px;'>번호</th>
		<th>접속IP</th>
		<th>구분</th>
		<th>접속URL</th>
		<th>POST값</th>
		<th>로그시간</th>
		<th>관리자툴</th>
	</tr>


END;


$WHERE	= "";
if ($search_type && trim($search_word) != "")
{
	if ($WHERE == "")
	{
		$WHERE	= " WHERE ";
	}
	else
	{
		$WHERE	= " AND ";
	}
	$WHERE	.= $search_type." like '%".$search_word."%'";
}

list($Count)	= happy_mysql_fetch_array(query("select count(*) from $happy_hack_check_log $WHERE"));


####################### 페이징처리 ########################
$start			= $_GET["start"];
$scale			= 10;

$Total = $Count;

if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
$pageScale		= 6;

$searchMethod	= "";
$searchMethod	.= "&search_type=$search_type";
$searchMethod	.= "&search_word=$search_word";

$페이징			= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
###################### 페이징처리 끝 #######################

$Sql	= "select * from $happy_hack_check_log $WHERE order by number desc limit $start, $scale";
$Result	= query($Sql);
while ( $Data = happy_mysql_fetch_array($Result) )
{
	print <<<END
	<tr>
		<td style='text-align:center;'>$listNo</td>
		<td style='text-align:center;'>$Data[log_ip]</td>
		<td style='text-align:center;'>$Data[log_type]</td>
		<td style='text-align:center;word-break:break-all;'>$Data[log_url]</td>
		<td style='text-align:center;word-break:break-all;'>$Data[log_post_val]</td>
		<td style='text-align:center;'>$Data[log_time]</td>
		<td style='text-align:center;'>
			<a onClick="if ( confirm ( '삭제하시겠습니까?' ) ) { location.href='?mode=del&number=$Data[number]&search_type=$_GET[search_type]&search_word=$_GET[search_word]'; }" class='btn_small_gray'>삭제</a>
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