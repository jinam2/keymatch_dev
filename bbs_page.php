<?php


$pageviewsu = 10;                                                     //한 페이지에 몇개의 페이지를 보여주나
$pagegroup = ceil($pg/$pageviewsu);                    //페이지 그룹 결정
$pagestart = ($pageviewsu*($pagegroup-1))+1;     //시작 페이지 결정
$pageend = $pagestart+$pageviewsu-1;                 //끝 페이지 결정


$page_print .= "
			<table border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td>
";

/////////////////시작 페이지
if ( $pagegroup !=1 ) {
	//echo "<a href='$PHP_SELF?pg=1$plus'>1</a>....";
}


////////////////이전 그룹으로 가기
if ( $pagegroup >1 ) {
	$prestart = $pagestart-$pageviewsu;                   //이전 목록 그룹의 시작페이지 결정
	$page_print .= "<div  class='page_prev0'><a href='$PHP_SELF?tb=$tb&pg=$prestart$search_page$plus'>이전</a></div>";
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
$page_print .= "<div class='page_now'><a href='$PHP_SELF?tb=$tb&pg=$i$search_page$plus' class='page'>$i</a></div>";
	}
	else {
$page_print .= "<div class='page_nomal'><a href='$PHP_SELF?tb=$tb&pg=$i$search_page$plus' class='page'>$i</a></div>";
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
	$page_print .= "<div class='page_next0'><a href='$PHP_SELF?tb=$tb&pg=$nextstart$search_page$plus'>다음</a></div>";
}

$page_print .= "</td></tr></table>";

/////////////////마지막 페이지
if ( $total_page != $pg ) {
	//echo "....<a href='$PHP_SELF?pg=$total_page$plus'>$total_page</a>";
}

?>