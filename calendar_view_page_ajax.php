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
	$page_print .= "<div class='page_prev_small font_12 font_number' onclick=bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$prestart','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word') style='cursor:pointer;'><a href='#1' > << </a></div>";

	//$page_print .= "<a href='#1' onclick=bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$prestart','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word')>[이전]</a>][$i]..";
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
		//$page_print .= "<b>[<a href='#33' onclick=bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$i','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word')>$i</a>]</b>";
		$page_print .= "<div class='page_now_small font_12 font_number' onclick=\"bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$i','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word')\" style='cursor:pointer;'><a href='#33' >$i</a></div>";
	}
	else {
		//$page_print .= "[<a href='#33' onclick=bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$i','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word')>$i</a>]";
		$page_print .= "<div class='page_nomal_small font_12 font_number' onclick=\"bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$i','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word')\" style='cursor:pointer;'><a href='#33' class='font_12 font_number'>$i</a></div>";
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
	//$page_print .= "..[$i]<a href='#33' onclick=bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$nextstart','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word')>[다음]</a>";

	$page_print .= "<div class='page_next_small font_12 font_number' onclick=\"bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$nextstart','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word')\" style='cursor:pointer;'><a href='#33' class='font_12 font_number'> >> </a></div>";
}


/////////////////마지막 페이지
if ( $total_page != $pg ) {
	//echo "....<a href='$PHP_SELF?pg=$total_page$plus'>$total_page</a>";
}

?>