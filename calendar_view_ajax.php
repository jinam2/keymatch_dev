<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/lib.php");
include ("./inc/lib_calendar.php");



$mod_ok = '';


$ex_limit = $_GET['ex_limit'];
$ex_width  = $_GET['ex_width'];
$ex_cut = $_GET['ex_cut'];
$ex_category = $_GET['ex_category'];
$ex_template = $_GET['ex_template'];
$ex_paging  = $_GET['ex_paging'];
$form = $_GET['form'];
$span_id = $_GET['span_id'];
$pg = $_GET['now_ajax_page'];
$ex_get_id = $_GET['ex_get_id'];
$_GET[id] = $ex_get_id;
$ex_garbage = $_GET['ex_garbage'];
$ex_action = $_GET['ex_action'];
$ex_number = $_GET['ex_number'];
$ex_search_type = $_GET['ex_search_type'];
$ex_search_word = $_GET['ex_search_word'];


#######################################################
#삭제를 위한 루틴 --> lb_calendar.php 에 있어야 ... 패스!


	if ( $_COOKIE["ad_id"] == "$admin_id" && $_COOKIE["ad_pass"] == md5($admin_pw) ) {
		$master_check = '1';
	}
	else {
		$master_check = '';
	}

	#일단 함 읽어서 아이디가 맞는지 보자
	if ($ex_action == 'delete' && $ex_number){
		$sql22 = "select * from $calendar_view_tb where number = '$ex_number' ";
		$result22 = query($sql22);
		$TMP = happy_mysql_fetch_array($result22);

		if ($TMP[id] == $mem_id && $TMP[id]){
			$master_check = '1';
		}
	}


	if ($ex_action == 'delete' && $master_check == '1'){
		$sql123 = "delete from $calendar_view_tb where number = '$ex_number' ";
		$result = query($sql123);
		$ex_action = '';
	}

#삭제를 위한 루틴
####################################################


#깨진값이 온다 고치자.
$ex_category  = urldecode($ex_category);

#오늘 등록한 댓글갯수 카운팅
$sql  = "select count(*) from $calendar_view_tb where left(reg_date,10) = curdate()";
 $TC   = happy_mysql_fetch_array(query($sql));
 $Now_num = number_format($TC[0]);

usleep($ajax_sleep_time);

header("Content-Type: text/html; charset=utf-8");
print "$span_id---cut---";
calendar_extraction_list($ex_limit,$ex_width,$ex_cut,$ex_category,$ex_template,$ex_paging,$span_id,'sub_call',$ex_get_id,$ex_garbage,$ex_action,$ex_number,$ex_search_type,$ex_search_word);
print "---cut---".$Now_num;
?>