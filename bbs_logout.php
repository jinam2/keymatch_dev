<?php
	ob_start();
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$buffer_output = ob_get_contents();
	ob_end_clean();

	setcookie("ad_id","",0,"/",$cookie_url);
	setcookie("ad_pass","",0,"/",$cookie_url);
	setcookie("level","",0,"/",$cookie_url);

	msg("관리자 로그오프 되었습니다.");
	go("./bbs_list.php?id=$_GET[id]&num=$num&tb=$tb");
?>

