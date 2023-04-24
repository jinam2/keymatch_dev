<?php
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$sql1 = "select * from $board_list where tbname = '$tb'";
	$result1 = query($sql1);
	$B_CONF = happy_mysql_fetch_array($result1);
	//실제 테이블이 있는가?
	$result3 = happy_mysql_list_tables("$db_name");
	while( list($ex_table) = mysql_fetch_row($result3) )
	{
		if ($ex_table == "$B_CONF[tbname]" )
		{
			$check_board = "1";
		}
	}

	if ($check_board != "1")
	{
		error("해당 테이블이 존재하지 않습니다");
		exit;
	}

	if( !(is_file("$skin_folder_bbs/$B_CONF[board_temp_detail]")) )
	{
		print "리스트페이지 $skin_folder_bbs/$B_CONF[board_temp_detail] 파일이 존재하지 않습니다. <br>";
		return;
	}



	#게시글중복추천방지로그 2010-04-14 kad
	/* 중복추천 방지를 위한 추천 로그 테이블 생성 2010-04-14 kad
	create table `board_pick_log` (
		`number` int(11) not null auto_increment,
		`tbname` varchar(30) not null default '',
		`mem_id` varchar(30) not null default '',
		`board_number` int(11) not null default '',
		`remote_ip` varchar(20) not null default '',
		`reg_date` datetime not null default '0000-00-00 00:00:00',
		PRIMARY KEY  (`number`),
		KEY `tbname` (`tbname`),
		KEY `mem_id` (`mem_id`),
		KEY `board_number` (`board_number`),
		KEY `remote_ip` (`remote_ip`)
		);
	*/
	$board_pick_log = "board_pick_log";


	#공지사항이면 tb를 바꾸자
	if ($_GET['top_gonggi'] == '1')
	{
		$tb = $board_top_gonggi;
	}
	else
	{
		$tb = $tb;
	}

	if ( $mem_id == "" )
	{
		$sql = "select count(*) from ".$board_pick_log." where remote_ip = '".$_SERVER['REMOTE_ADDR']."' and tbname='".$tb."' and board_number = '".$bbs_num."' and mem_id = '' ";
	}
	else
	{
		$sql = "select count(*) from ".$board_pick_log." where remote_ip = '".$_SERVER['REMOTE_ADDR']."' and tbname='".$tb."' and board_number = '".$bbs_num."' and mem_id = '".$mem_id."'";
	}

	$result = query($sql);
	list($ip_check)= happy_mysql_fetch_array($result);

	if ( $ip_check )
	{
		msg("중복추천은 하실수 없습니다.");
		go($_SERVER['HTTP_REFERER']);
		exit;
	}
	else
	{
		$sql = "insert ".$board_pick_log." set ";
		$sql.= "tbname = '".$tb."',";
		$sql.= "mem_id = '".$mem_id."',";
		$sql.= "board_number = '".$bbs_num."',";
		$sql.= "remote_ip = '".$_SERVER['REMOTE_ADDR']."',";
		$sql.= "reg_date = now()";

		query($sql);

		$sql = "update $tb set bbs_etc4=bbs_etc4 + 1 where number='$bbs_num' ";
		$result = query($sql);

		msg("해당 게시글이 추천되었습니다    ");
		go($_SERVER['HTTP_REFERER']);
		exit;
	}


?>