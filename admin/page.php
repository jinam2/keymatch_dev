<?php

echo "

<style>

/* 이전버튼 */
a.prev2{background:url('../img/btn_pageing_prev.gif') no-repeat 50% 50%;}

/* 다음버튼 */
next2{background:url('../img/btn_pageing_next.gif') no-repeat 50% 50%;}
</style>

";

$pageviewsu = 10;                                                     //한 페이지에 몇개의 페이지를 보여주나
$pagegroup = ceil($pg/$pageviewsu);                    //페이지 그룹 결정
$pagestart = ($pageviewsu*($pagegroup-1))+1;     //시작 페이지 결정
$pageend = $pagestart+$pageviewsu-1;                 //끝 페이지 결정


/////////////////시작 페이지
if ( $pagegroup !=1 ) {
	//echo "<a href='$PHP_SELF?pg=1$plus'>1</a>....";
}


/*
////////////////이전 그룹으로 가기
if ( $pagegroup >1 ) {
	$prestart = $pagestart-$pageviewsu;                   //이전 목록 그룹의 시작페이지 결정
	$page_print .= "<a href='$PHP_SELF?a=$_GET[a]&pg=$prestart$plus'>◀◀..</a>";
}
*/



/////////////////이전 페이지로 가기

$prevpage = $pg-1;
if ( $prevpage != 0 ) {
	$page_print .= "<table cellpadding='0' cellspacing='2'><tr><td><div class='page_prev0'><a href=\"$PHP_SELF?a=$_GET[a]&pg=$prevpage$plus\">이전</a></div></td>";
}
else
{
	$page_print .= "<table cellpadding='0' cellspacing='2'><tr><td><div class='page_prev0_no'>이전</div></td>";
}



////////////////현재 그룹의 페이지 보여주기
for ( $i=$pagestart; $i<=$pageend; $i++) {
	if ( $total_page<$i ) {
		break;
	}
	if ( $pg == $i ) {
$page_print .= "<td><div class='page_now'>$i</div></td>";
	}
	else {
$page_print .= "<td><div class='page_nomal' style='cursor:pointer;' onclick='location.href=\"$PHP_SELF?a=$_GET[a]&pg=$i$plus\"'>$i</div></td>";
	}
}


/////////////////다음 페이지로 가기

#if ( $pg != $total_page && $total_page != "0") {
	$nextpage = $pg+1;

	if ( $pg < $total_page )
	{
		$page_print .= "<td><div class='page_next0'><a href=\"$PHP_SELF?a=$_GET[a]&pg=$nextpage$plus\">다음</a></div></td></tr></table>";
	}
	else
	{
		$page_print .= "<td><div class='page_next0_no'>다음</div></td></tr></table>";
	}

#}



/*
/////////////////다음 그룹으로 가기
if ( $total_page > $pageend ) {
	$nextstart = $pageend+1;                                       //다음 목록 그룹의 시작페이지 결정
	$page_print .= "<a href='$PHP_SELF?a=$_GET[a]&pg=$nextstart$plus'>..▶▶</a>";
}
*/



/////////////////마지막 페이지
if ( $total_page != $pg ) {
	//echo "....<a href='$PHP_SELF?pg=$total_page$plus'>$total_page</a>";
}

?>