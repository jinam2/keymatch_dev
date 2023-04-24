<?php
	include ("./inc/config.php");
	include ("./inc/function.php");


	$number		= preg_replace('/\D/','',$_GET['number']);

	if ( !$number )
	{
		echo "<script>alert('값이 부족합니다.');history.go(-1);</script>";
		exit;
	}

	$Sql	= "SELECT link FROM $happy_banner_tb WHERE number='$number'";
	$Data	= happy_mysql_fetch_array(query($Sql));


	if ( $Data['link'] == '' )
	{
		echo "<script>alert('링크주소가 존재하지 않습니다.');history.go(-1);</script>";
		exit;
	}


	#로고쌓기
	$date	= date("Y-m-d");
	$nTime	= date("H");
	$dates	= explode("-",$date);
	$group	= $Data['groupid'];

	$Sql	= "SELECT count(number) FROM $happy_banner_log_tb WHERE regdate='$date' AND nTime='$nTime' AND bannerID = '$number'";
	$Tmp	= happy_mysql_fetch_array(query($Sql));

	if ( $Tmp[0] == 0 )
	{
		$Sql	= "
					INSERT INTO
							$happy_banner_log_tb
					SET
							bannerID	= '$number',
							groupID		= '$group',
							regdate		= '$date',
							year		= '$dates[0]',
							month		= '$dates[1]',
							day			= '$dates[2]',
							nTime		= '$nTime',
							viewcount	= '0',
							linkcount	= '1'
		";
	}
	else
	{
		$Sql	= "
					UPDATE
							$happy_banner_log_tb
					SET
							linkcount	= linkcount + 1
					WHERE
							regdate		= '$date'
							AND
							nTime		= '$nTime'
							AND
							bannerID	= '$number'
		";
	}
	query($Sql);

	#해당배너 정보 업그레이드
	query("UPDATE $happy_banner_tb SET linkcount=linkcount+1, linkdate=now() WHERE number='$number'");

	echo "<script>window.location.href = '$Data[link]';</script>";


?>