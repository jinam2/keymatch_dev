<?php

	$config_include_folder		= ( is_file("../master/config.php") ) ? "../master" : "../inc";

	include($config_include_folder."/config.php");
	include("../inc/function.php");
	include("inc/monitor_config.php");
	include("inc/monitor_lib.php");
	include("inc/Snoopy.class.php");

	$monitor_snoopy	= new Snoopy;

	if ( !is_admin() )
	{
		exit;
	}

	$print_array	= Array();

	foreach ( $CHECK_API_CONFIG as $type => $conf_array )
	{
		$result			= happy_monitor_check_solution($type);

		if ( strpos($result,'exists') === false )
		{
			array_push($print_array,$conf_array['title'] . "," . $conf_array['explain'] . "," . $result);
		}
	}

	//마지막 테스트 날짜 저장
	$now_date		= date("Y-m-d H:i:s");

	happy_monitor_config_save('check_solution_date',$now_date);

	if ( count($print_array) > 0 )
	{
		echo "ok___CUT___".$now_date."___CUT___".implode("||",$print_array);
	}
	else
	{
		echo "no___CUT___".$now_date;
	}
?>