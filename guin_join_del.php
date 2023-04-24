<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] )
	{
		gomsg("로그인 후 이용하세요","./happy_member_login.php");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[4]) )
	{
		error($happy_member_secure_text[4]." 권한이 없습니다.");
		exit;
	}
	
	if ( isset($_GET) )
	{
		if ( $_GET['mode'] == 'del' )
		{
			if ( $HAPPY_CONFIG['OnlineCancelAble'] != 'Y' )
			{
				error("잘못된경로로 접근하셨습니다.");
				exit;
			}
			
			if ( $_GET['number'] == '' )
			{
				error("잘못된경로로 접근하셨습니다.");
				exit;
			}
			
			$sql = "select * from ".$com_guin_per_tb." where number = '".$_GET['number']."'";
			$result = query($sql);
			$Row = happy_mysql_fetch_assoc($result);

			if ( $Row['per_id'] != $mem_id )
			{
				error("잘못된경로로 접근하셨습니다.");
				exit;
			}

			$sql = "delete from ".$com_guin_per_tb." where number = '".$_GET['number']."'";
			query($sql);

			msg("온라인입사지원건이 취소되었습니다.");
			go("./html_file_per.php?file=my_guin_add.html");
			exit;
		}
	}





?>