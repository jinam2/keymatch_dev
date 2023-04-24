<?php

	include("inc/monitor_config.php");

	$path				= base64_decode($_GET['path']);
	$var_name			= base64_decode($_GET['var_name']);

	if ( $path == "" || $var_name == "" )
	{
		echo "error";
		exit;
	}

	$demo_lock_path		= $server_path.$path;

	if ( !is_file($demo_lock_path) )
	{
		exit;
	}

	include($demo_lock_path);

	if ( ${$var_name} != "" )
	{
		echo "lock";
	}
	else
	{
		echo "unlock";
	}
?>