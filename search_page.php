<?php
$pageviewsu = 10;                                                     //한 페이지에 몇개의 페이지를 보여주나
$pagegroup = ceil($pg/$pageviewsu);                    //페이지 그룹 결정
$pagestart = ($pageviewsu*($pagegroup-1))+1;     //시작 페이지 결정 
$pageend = $pagestart+$pageviewsu-1;                 //끝 페이지 결정


/////////////////시작 페이지
if ( $pagegroup !=1 ) {
	//echo "<a href='$PHP_SELF?pg=1$plus'>1</a>....";
}


////////////////이전 그룹으로 가기
if ( $pagegroup >1 ) {
	$prestart = $pagestart-$pageviewsu;                   //이전 목록 그룹의 시작페이지 결정
	$page_print .= "<a href='$PHP_SELF?action=search&pg=$prestart$plus&category=$category&area_read=$area_read&company=$company&type=$type&ym_read=$ym_read&price_read=$price_read'>[이전]</a>..";
}


/////////////////이전 페이지로 가기
/*
$prevpage = $pg-1;
if ( $prevpage != 0 ) {
	$page_print .= "[<a href='$PHP_SELF?pg=$prevpage$plus'>prev</a>]&nbsp;";
}

*/

////////////////현재 그룹의 페이지 보여주기
for ( $i=$pagestart; $i<=$pageend; $i++) {
	if ( $total_page<$i ) {
		break;
	}
	if ( $pg == $i ) {
$page_print .= "<b>[$i]</b>";
	}
	else {
$page_print .= "[<a href='$PHP_SELF?action=search&pg=$i$plus&category=$category&area_read=$area_read&company=$company&type=$type&ym_read=$ym_read&price_read=$price_read'>$i</a>]";
	}
}


/////////////////다음 페이지로 가기
/*
if ( $pg != $total_page && $total_page != "0") {
	$nextpage = $pg+1;
	$page_print .= "&nbsp;[<a href='$PHP_SELF?pg=$nextpage$plus'>next</a>]";
}

*/

/////////////////다음 그룹으로 가기
if ( $total_page > $pageend ) {
	$nextstart = $pageend+1;                                       //다음 목록 그룹의 시작페이지 결정
	$page_print .= "..<a href='$PHP_SELF?action=search&pg=$nextstart$plus&category=$category&area_read=$area_read&company=$company&type=$type&ym_read=$ym_read&price_read=$price_read'>[다음]</a>";
}


/////////////////마지막 페이지
if ( $total_page != $pg ) {
	//echo "....<a href='$PHP_SELF?pg=$total_page$plus'>$total_page</a>";
}

?>