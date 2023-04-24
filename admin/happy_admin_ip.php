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
	$Sql = "delete from $happy_admin_ipTable where number = '$_GET[number]'";
	query($Sql);
	gomsg("삭제되었습니다.", "happy_admin_ip.php");
	exit;
}

print <<<END
	<a name="top"></a>
	<p class='main_title'>$now_location_subtitle</p>

	<div class='help_style'>
		<div class='box_1'></div>
		<div class='box_2'></div>
		<div class='box_3'></div>
		<div class='box_4'></div>
		<span class='help'>도움말</span>
		<p>
			관리자 접속 아이피정보 기능은 정상적인 경로로 관리자 페이지에 접속이 되었는지 확인하기 위한 기능입니다.<br>
			그리고 관리자 페이지 접속하는 방법은 관리자 계정정보 또는 허용된 아이피정보와 관리자계정으로 접속할 수 있도록 방법을 제공합니다.<br>
			관련 설정은 PHP 프로그램 파일에서 수동으로 직접 설정해 주셔야 합니다. 설정은 다음과 같습니다.<br><br>
			<ol>
				<li><b>inc</b> 폴더 안 <b>function.php</b> 파일을 엽니다.</li>
				<li><b>happy_admin_ipCheck</b> 변수 항목을 글찾기로 찾습니다.</li>
				<li><b>happy_admin_ipCheck = '1';</b> 이면 허용된 아이피정보와 관리자계정으로 관리자접속</li>
					이 경우는 아래 <b>happy_admin_ip</b> 항목에 설정된 아이피정보 기준으로만 접속가능</li>
				<li><b>happy_admin_ipCheck = '';</b> (빈값)이면 관리자계정 정보만으로 관리자접속가능</li>
			</ol>
		</p>
	</div>

	<div id='list_style'>
		<table cellspacing='0' cellpadding='0' class='bg_style table_line'>
		<tr>
			<th style='width:50px;'>번호</th>
			<th>접속아이피</th>
			<th>브라우저 정보</th>
			<th style='width:130px;'>접속시간</th>
			<th style='width:70px;'>관리자툴</th>
		</tr>

END;

list($Count)	= mysql_fetch_row(query("select count(*) from $happy_admin_ipTable"));

####################### 페이징처리 ########################
$start			= $_GET["start"];
$scale			= 3;

$Total = $Count;

if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
$pageScale		= 6;
$페이징			= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
###################### 페이징처리 끝 #######################

$Sql	= "select * from $happy_admin_ipTable order by number desc limit $start, $scale";
$Result	= query($Sql);
while ( $Data = happy_mysql_fetch_array($Result) )
{
	$Data[browser] = kstrcut($Data[browser],'100','...');

	print <<<END
		<tr>
			<td style='text-align:center;'>$listNo</td>
			<td>$Data[ip]</td>
			<td>$Data[browser]</td>
			<td style='text-align:center;'>$Data[reg_date]</td>
			<td style='text-align:center;'><a onClick="if ( confirm ( '삭제하시겠습니까?' ) ) { location.href='?mode=del&number=$Data[number]'; }" class='btn_small_gray'>삭제</a></td>
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