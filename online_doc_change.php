<?php
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	//온라인입사지원한 이력서에 평점,메모기능 추가 2015-10-05 kad
	//alter table job_com_guin_per add point int(11) not null default 0;
	//alter table job_com_guin_per add memo text not null default '';



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

		//print_r2($row);exit;

		//로그가 있는지 확인
		$sql = "select count(*) from $com_guin_per_tb_log where pNumber = $row[pNumber] and cNumber = $row[cNumber]";
		//echo $sql;exit;
		$cnt = happy_mysql_fetch_array(query($sql));

		if ( $row['online_stats'] != $online_stats || $cnt[0] < 1 )
		{
			$sql = "insert into $com_guin_per_tb_log set ";
			$sql.= "bNumber = '".$bNumber."',";
			$sql.= "pNumber = '".$row['pNumber']."',";
			$sql.= "cNumber = '".$row['cNumber']."',";
			$sql.= "com_id = '".$row['com_id']."',";
			$sql.= "per_id = '".$row['per_id']."',";
			$sql.= "online_stats = '".$online_stats."',";
			$sql.= "regdate = now()";

			//echo $sql."<br>";exit;
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


	if ( $_POST['mode'] == "com_memo" )
	{
		//print_r($_POST);exit;
		$point	= preg_replace("/\D/","",$_POST['point']);
		$memo = $_POST['memo'];
		$bNumber = preg_replace("/\D/","",$_POST['bNumber']);

		$sql = "select * from $com_guin_per_tb where number = '$bNumber'";
		$result = query($sql);
		$row = happy_mysql_fetch_assoc($result);

		if ( $row['com_id'] !=  $mem_id &&  $mem_id && $_COOKIE['ad_id'] == "" )
		{
			msg("잘못된 접근입니다.");
			exit;
		}

		$sql = "update $com_guin_per_tb set ";
		$sql.= "point = '$point',";
		$sql.= "memo = '$memo' ";
		$sql.= "where number = '$bNumber'";
		query($sql);
	}
	else if ( $_GET['mode'] != "multi" )
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