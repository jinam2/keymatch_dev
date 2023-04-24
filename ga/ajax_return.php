<?php
	include "inc/config.php";
	include "inc/function.php";

	header("Content-Type: text/html; charset=UTF-8");

	$profile_id		= trim(preg_replace('/\D/', '', $_GET['profile_id']));

	$Sql			= "SELECT * FROM $analytics_list_tb WHERE profileId = '$profile_id' ";
	$Result			= query($Sql);
	$Data			= mysql_fetch_assoc($Result);

	if ( $Data['number'] != "" )
	{
		query("DELETE FROM $analytics_list_tb WHERE profileId = '$profile_id' ");

		echo serialize($Data); //배열 그대로 return
	}
?>