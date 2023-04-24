<?php

	$config_include_folder		= ( is_file("../master/config.php") ) ? "../master" : "../inc";

	include($config_include_folder."/config.php");
	include("../inc/function.php");
	include("inc/monitor_config.php");
	include("inc/monitor_lib.php");

	if ( !is_admin() )
	{
		exit;
	}

	happy_monitor_config_load();

	//CPU 부하
	$cpu	= happy_monitor_check_load_time();

	//MySQL 접속
	$mysql	= happy_monitor_check_load_time('mysql');

	echo round(( $cpu['score'] + $mysql['score'] ) / 2);

?>