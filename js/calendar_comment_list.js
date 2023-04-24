<!-- ajax board -->
var bbs_ajax_hidden_write;
var response		= new Array();
var request_board = new Array();  //쪽지레이어와 부딪힘에 유의!!
function createXMLHttpRequest(no)
{
	if (window.XMLHttpRequest) {
	request_board[no] = new XMLHttpRequest();
	} else {
	request_board[no] = new ActiveXObject("Microsoft.XMLHTTP");
	}
}

// 함수에서는 ex_action , ex_number가 없으나 , 삭제시 ajax action을 위해 추가함. Neohero
function bbs_list_get(ex_limit,ex_width,ex_cut,ex_category,ex_template,ex_paging,form,span_id,now_ajax_page,no,ex_get_id,ex_garbage,ex_action,ex_number,ex_search_type,ex_search_word)
{

	
	if (ex_action == 'delete')
	{
		var msg = '댓글을 삭제하시겠습니까?';
		if (!confirm(msg)){
			return;
		}
	}

	createXMLHttpRequest(no);
	request_board[no].open("GET", "calendar_view_ajax.php?ex_limit=" + ex_limit + "&ex_width=" + ex_width + "&ex_cut=" + ex_cut + "&ex_category=" + ex_category + "&ex_template=" + ex_template + "&ex_paging=" + ex_paging + "&form=" + form + "&span_id=" + span_id + "&now_ajax_page=" + now_ajax_page + "&ex_get_id=" + ex_get_id + "&ex_garbage=" + ex_garbage + "&ex_action=" + ex_action + "&ex_number=" + ex_number + "&ex_search_type=" + ex_search_type + "&ex_search_word=" + encodeURI(ex_search_word) + "&start=" + now_ajax_page, true);


	request_board[no].onreadystatechange = function ()
										{
											if (request_board[no].readyState == 4) {
												if (request_board[no].status == 200 ) {
												response[no] = request_board[no].responseText.split("---cut---");
												//alert(request_board[no].status + request_board[no].responseText);
												//eval(response[no][0]+ '.innerHTML=response[no][1]');
												document.getElementById(response[no][0]).innerHTML = response[no][1];
												document.getElementById('comment_count_layer').innerHTML = response[no][2];
												window.status="전송완료"
												}
											}
											if (request_board[no].readyState == 1)  {
												eval(span_id+ '.innerHTML="<table style=width:100%;height:150px border=0><tr><td align=center><img src=img/ajax_loading.gif></td></tr></table>"');
												window.status="로딩중";
											}
										}

	request_board[no].send(null);
}



<!-- ajax board -->

