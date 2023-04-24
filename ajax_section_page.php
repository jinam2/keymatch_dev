<?php
$pageviewsu = 5;                                                     //한 페이지에 몇개의 페이지를 보여주나
$page_print = "";
$pagegroup = ceil($pg/$pageviewsu);                    //페이지 그룹 결정
$pagestart = ($pageviewsu*($pagegroup-1))+1;     //시작 페이지 결정
$pageend = $pagestart+$pageviewsu-1;                 //끝 페이지 결정


/////////////////시작 페이지
if ( $pg - 1 > 0 ) {
	//echo "<a href='?pg=1$plus'>1</a>....";
	$page_print .= "<div class='page_prev0' onclick='gopaging${ajaxNum}(1)'><a href=\"javascript:gopaging${ajaxNum}(1)\"><<</a></div>";
}
else
{
	$page_print .= "<span style='display:inline-block; margin-top:30px;'><div class='page_prev0_no'><<</div>";
}

/*
////////////////이전 그룹으로 가기
if ( $pagegroup >1 ) {
	$prestart = $pagestart-$pageviewsu;                   //이전 목록 그룹의 시작페이지 결정
	//$page_print .= "<a href='$PHP_SELF?pg=$prestart$plus'>[이전]</a>..";
	$page_print .= "<a href='javascript:gopaging${ajaxNum}($prestart)'><img src=img/page/btn_pageing_prev0.gif align='absmiddle' border='0'></a>";
}

*/


/////////////////이전 페이지로 가기

$prevpage = $pg-1;
if ( $prevpage != 0 ) {
	$page_print .= "<span style='display:inline-block; margin-top:30px;'><div class='page_prev0' onclick='gopaging${ajaxNum}($prevpage)'><a href=\"javascript:gopaging${ajaxNum}($prevpage)\">이전</a></div>";
}
else
{
	$page_print .= "<span style='display:inline-block; margin-top:30px;'><div class='page_prev0_no'>이전</div>";
}



////////////////현재 그룹의 페이지 보여주기
for ( $i=$pagestart; $i<=$pageend; $i++) {
	if ( $total_page<$i ) {
		break;
	}
	if ( $pg == $i ) {
$page_print .= "<div class='page_now'>$i</div>";
	}
	else {
$page_print .= "<div class='page_nomal' style='cursor:pointer;' onclick=\"javascript:gopaging${ajaxNum}($i)\"><a href='javascript:gopaging${ajaxNum}($i)' class='font_number'>$i</a></div>";
	}
}


/////////////////다음 페이지로 가기

#if ( $pg != $total_page && $total_page != "0") {
	$nextpage = $pg+1;
	#$page_print .= "&nbsp;[<a href='?pg=$nextpage$plus'>next</a>]";

	if ( $pg < $total_page )
	{
		$page_print .= "<div class='page_next0' onclick=\"javascript:gopaging${ajaxNum}($nextpage)\"><a href='javascript:gopaging${ajaxNum}($nextpage)'>다음</a></div></span>";
	}
	else
	{
		$page_print .= "<div class='page_next0_no'>다음</div></span>";
	}
#}



/*
/////////////////다음 그룹으로 가기
if ( $total_page > $pageend ) {
	$nextstart = $pageend+1;                                       //다음 목록 그룹의 시작페이지 결정
	$page_print .= "<a href='javascript:gopaging${ajaxNum}($nextstart)'><img src=img/page/btn_pageing_next0.gif align='absmiddle' border='0'></a>";
	//$page_print .= "..<a href='?pg=$nextstart$plus'>[다음]</a>";
}
*/



/////////////////마지막 페이지
if ( $total_page != $pg ) {
	//echo "....<a href='?pg=$total_page$plus'>$total_page</a>";

	$page_print .= "<div class='page_prev0' onclick='gopaging${ajaxNum}($total_page)'><a href=\"javascript:gopaging${ajaxNum}($total_page)\">>></a></div>";
}
else
{
	$page_print .= "<span style='display:inline-block; margin-top:30px;'><div class='page_prev0_no'>>></div>";
}

?>