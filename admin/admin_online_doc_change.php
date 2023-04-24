<?php
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/function.php");
	include ("../inc/lib.php");


	if ( !admin_secure("구직리스트") )
	{
		error("접속권한이 없습니다.   ");
		exit;
	}


	function online_stats_change_log($bNumber,$online_stats)
	{
		global $com_guin_per_tb,$com_guin_per_tb_log,$per_tb;
		
		/*
		create table `job_com_guin_per_log` ( `number` int(11) NOT NULL auto_increment, `bNumber` int(11) not null default '0', `regdate` datetime not null default '0000-00-00 00:00:00', PRIMARY KEY (`number`), KEY `bNumber` (`bNumber`) ) DEFAULT CHARSET=utf8;

		alter table `job_com_guin_per_log` add online_stats int(1) not null default '0';
		alter table `job_com_guin_per_log` add pNumber int(11) not null default '0';
		alter table `job_com_guin_per_log` add cNumber int(11) not null default '0';
		alter table `job_com_guin_per_log` add com_id varchar(50) not null default '';
		alter table `job_com_guin_per_log` add per_id varchar(50) not null default '';
		*/

		$sql = "select * from $com_guin_per_tb where number = '$bNumber'";
		$result = query($sql);
		$row = happy_mysql_fetch_assoc($result);

		//print_r($row);

		if ( $row['online_stats'] != $online_stats )
		{
			$sql = "insert into $com_guin_per_tb_log set ";
			$sql.= "bNumber = '".$bNumber."',";
			$sql.= "pNumber = '".$row['pNumber']."',";
			$sql.= "cNumber = '".$row['cNumber']."',";
			$sql.= "com_id = '".$row['com_id']."',";
			$sql.= "per_id = '".$row['per_id']."',";
			$sql.= "online_stats = '".$online_stats."',";
			$sql.= "regdate = now()";

			//echo $sql."<br>";
			query($sql);

/* 회원통합에 맞게 새로 구현
			$sql = "select * from $per_tb where id = '".$row['per_id']."'";
			$result = query($sql);
			$Per = happy_mysql_fetch_assoc($result);

			if ( $Per['etc5'] < $online_stats )
			{
				$sql = "update $per_tb set etc5 = '".$online_stats."' where id = '".$row['per_id']."'";
				query($sql);
			}
*/


		}
	}



	if ( $_GET['mode'] != "multi" )
	{
		$_GET['bNumber'] = intval($_GET['bNumber']);
		$_GET['online_stats'] = intval($_GET['online_stats']);
		
		online_stats_change_log($_GET['bNumber'],$_GET['online_stats']);
		
		$sql = "update ".$com_guin_per_tb." set ";
		$sql.= "online_stats = '".$_GET['online_stats']."' ";
		$sql.= "where number = '".$_GET['bNumber']."'";
		//echo $sql;
		query($sql);
	}
	else
	{
		$tmpNumber = explode("_cut_",$_GET['bNumber']);

		foreach($tmpNumber as $k=> $v)
		{
			$v = intval($v);
			$_GET['online_stats'] = intval($_GET['online_stats']);

			online_stats_change_log($v,$_GET['online_stats']);
			
			$sql = "update ".$com_guin_per_tb." set ";
			$sql.= "online_stats = '".$_GET['online_stats']."' ";
			$sql.= "where number = '".$v."'";
			//echo $sql."<br>";
			query($sql);
		}
	}



	echo "<script>top.document.location.reload();</script>";
?>