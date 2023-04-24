<?php
/*
CREATE TABLE `job_guin_jump` (
  `number` int(11) NOT NULL auto_increment,
  `id` varchar(100) NOT NULL default '',
  `id_number` int(11) not null default '' ,
  `guin_number` int(11) NOT NULL default '0',
  `guin_title` varchar(100) not null default '',
  `guin_date` datetime NOT NULL default '0000-00-00 00:00:00', 
  `reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`number`),
  KEY `id` (`id`),
  KEY `guin_number` (`guin_number`)
)
*/


	include ("./inc/Template.php");
	$TPL = new Template;

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( intval($_GET['guin_number']) == "" )
	{
		error("잘못된 접근");
		exit;
	}
	else
	{
		$guin_number = intval($_GET['guin_number']);
	}


	$login_id = happy_member_login_check();
	if ( $login_id == "" )
	{
		error("회원으로 로그인을 하셔야 합니다.");
		exit;
	}
	
	//관리자모드 점프사용내역페이지에서 회원정보 페이지로 링크 시킬려고
	$login_id_info = happy_member_information($login_id);


	//채용정보가 있나없나
	$sql = "select count(*) from $guin_tb where number = '".$guin_number."' and guin_id = '".$login_id."'";
	//echo $sql;
	$result = query($sql);
	list($guin_cnt) = happy_mysql_fetch_array($result);

	if ( $guin_cnt != 1 )
	{
		error("점프할 채용정보가 잘못되었습니다.");
		exit;
	}

	//점프시킬 옵션이 있나없나
	$jump_cnt = 0;
	$jump_cnt = happy_member_option_get($happy_member_option_type,$login_id,'guin_jump');
	if ( $jump_cnt <= 0 )
	{
		msg("채용정보를 점프시킬수 있는 옵션이 없습니다.\\n채용정보 점프옵션을 구매해주세요");
		go("member_option_pay2.php");
		exit;
	}

	//점프시킬 당시의 채용정보 제목과, 등록일을 저장하기 위해서
	$sql = "select * from $guin_tb where number = '".$guin_number."'";
	$result = query($sql);
	$DETAIL = happy_mysql_fetch_assoc($result);


	//연속점프 제한시간 체크
	if ( $HAPPY_CONFIG['guin_jump_time_limit'] >= 1 )
	{
		$checktime = strtotime($DETAIL['guin_date']) + $HAPPY_CONFIG['guin_jump_time_limit'];

		if ( $checktime > happy_mktime() )
		{
			error("채용정보 점프는 ".$HAPPY_CONFIG['guin_jump_time_limit']."초 마다 1회씩 가능합니다.");
			exit;
		}
	}
	//연속점프 제한시간 체크


	$sql = "insert into $job_guin_jump set ";
	$sql.= "id = '".$login_id."',";
	$sql.= "id_number = '".$login_id_info['number']."',";
	$sql.= "guin_number = '".$guin_number."',";
	$sql.= "guin_title = '".addslashes($DETAIL['guin_title'])."',";
	$sql.= "guin_date = '".$DETAIL['guin_date']."',";
	$sql.= "reg_date = now() ";
	query($sql);


	happy_member_option_set($happy_member_option_type,$login_id,'guin_jump',($jump_cnt-1),'int(11)');


	$sql = "update $guin_tb set ";
	$sql.= "guin_date = now() ";
	$sql.= "where number = '".$guin_number."'";
	query($sql);


	error("채용정보가 점프되었습니다.\\n".$login_id." 회원님의 점프가능회수는 [".($jump_cnt-1)."] 회 남았습니다.");
	exit;


?>