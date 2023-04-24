<?php
	//뉴스 상점 로그인 아이디 세팅
	$t_start = array_sum(explode(' ', microtime()));

	include ("../../inc/config.php");
	include ("../../inc/config_server.php");
	include("../../inc/ns_Template.php");
	$TPL = new Template;
	include("../../inc/ns_Template_make.php");
	include("inc/function.php");
	include("../../inc/ns_lib_encode.php");
	include("inc/lib.php");


	if ( $demo_lock == 1 )
	{
		//msgclose("뉴스 솔루션 데모에서는 사용하실수 없는 기능입니다.");
		//exit;
	}


	//뉴스 솔루션 관리자 체크
	if ( news_admin_check() == false )
	{
		error("접속 권한이 없습니다.");
		exit;
	}


	//뉴스 사이트 DB구조 체크해서 변경
	function news_store_db_setting()
	{
		global $news_store_login,$news_article;

		$sql = "show tables";
		$result = query($sql);
		$exist_login_table = false;
		while($row = happy_mysql_fetch_array($result))
		{
			//print_r($row);
			if ( $row[0] == $news_store_login )
			{
				$exist_login_table = true;
				break;
			}
		}


		if ( $exist_login_table == false )
		{
			$sql = "
			CREATE TABLE `$news_store_login` (
			`number` int(11) NOT NULL auto_increment,
			`id` varchar(100) NOT NULL default '',
			`pass` varchar(100) NOT NULL default '',
			`reg_date` datetime not null default '0000-00-00 00:00:00',
			`last_login` datetime not null default '0000-00-00 00:00:00',
			PRIMARY KEY  (`number`),
			KEY `id` (`id`)
			) DEFAULT CHARSET=euckr;
			";
			query($sql);

			$sql = "insert into $news_store_login set reg_date = now();";
			query($sql);
		}
	}

	news_store_db_setting();





	//뉴스상점아이디 세팅폼
	if ( $_GET['mode'] == "setting" )
	{

		$storeInfo = get_news_store_info();

		if ( $demo_lock == 1 )
		{
			$storeInfo['id'] = "test2";
			$storeInfo['pass2'] = "test2@";
		}


		$TPL->define("로그인정보", "./$skin_folder/store_login.html");
		$TPL->assign("로그인정보");
		$TPL->tprint();
	}
	//뉴스상점아이디 저장
	else if ( $_GET['mode'] == "save" )
	{
		if ( trim($_POST['store_id']) == "" )
		{
			error("잘못된 접근입니다.");
			exit;
		}

		if ( trim($_POST['store_pass']) == "" )
		{
			error("잘못된 접근입니다.");
			exit;
		}

		$sql = "update $news_store_login set ";
		$sql.= "id = '".$_POST['store_id']."',";
		$sql.= "pass = '".Happy_Secret_Code($_POST['store_pass'])."',";
		$sql.= "reg_date = now() ";
		$sql.= "where number = '1' ";
		query($sql);

		$returnUrl = $_POST['returnUrl'];
		if ( $returnUrl == "" )
		{
			msgclose("설정이 변경되었습니다.");
		}
		else
		{
			msg("설정이 변경되었습니다.");
			go("./index.php");
		}
		exit;
	}


	if ($demo_lock)
	{
		$exec_time = array_sum(explode(' ', microtime())) - $t_start;
		$exec_time = round ($exec_time, 2);
		print   "<center><font color=gray size=1>Query Time : $exec_time sec";
	}

?>