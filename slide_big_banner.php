<?php

	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if( !(is_file("$skin_folder/slide_big_banner.html")) ) {
		print "메인페이지 $skin_folder/slide_big_banner.html 파일이 존재하지 않습니다. <br>";
		return;
	}


	$TPL->define("슬라이드빅배너", "$skin_folder/slide_big_banner.html");
	$content = &$TPL->fetch();

	echo $content;
?>