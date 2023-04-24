<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");

	if ( !admin_secure("슈퍼관리자전용") )
	{
		error("접속권한이 없습니다.");
		exit;
	}

	$filename = $_POST['filename'];

	if (file_exists("./log/init/".$filename))
	{
		unlink("./log/init/".$filename);
	}
	echo "파일이 삭제되었습니다";
?> 
