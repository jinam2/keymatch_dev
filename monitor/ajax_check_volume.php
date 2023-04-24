<?php

	ini_set('memory_limit', -1);
	set_time_limit(0);

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

	//체크 용량
	$volume_check_limit_byte	= intval($MONITOR_CONFIG['volume_check_limit_byte']); //MB 단위

	//솔루션 전체 용량
	$dir_size			= 0;
	$size				= dirsize($server_path);
	$total_size			= get_volume_unit($size['volume']);

	//현재 용량정보 저장
	happy_monitor_volume_save($size);

	echo "ok___CUT___" . $total_size;

	//남은 용량
	if ( !is_dir($volume_check_folder_path) )
	{
		mkdir($volume_check_folder_path,0777);
	}

	$copy_limit_size	= $volume_check_limit_byte + 10; //10MB 더함

	for ( $n = 1 ; $n <= $copy_limit_size ; $n++ )
	{
		copy($volume_check_file_path,$volume_check_folder_path."/".$n);
	}

	$mbyte				= 1024 * 1024;
	$empty_size			= dirsize($volume_check_folder_path);
	$empty_size			= $empty_size['volume']/$mbyte;

	echo "___CUT___";

	$is_empty			= "";

	if ( $empty_size > $volume_check_limit_byte )
	{
		$is_empty			= "y";
	}
	else
	{
		$is_empty			= "n";
	}

	echo $is_empty;

	if ( $is_empty == "n" )
	{
		echo "___CUT___" . round($empty_size);
	}

	if ( is_dir($volume_check_folder_path) )
	{
		del_dir($volume_check_folder_path);
	}

	//업데이트 날짜 저장
	$last_update		= date("Y-m-d H:i:s");
	happy_monitor_config_save('check_volume_last_update',$last_update);
	happy_monitor_config_save('check_volume_last_value',$total_size);
	happy_monitor_config_save('check_volume_is_empty',$is_empty);
	happy_monitor_config_save('check_volume_empty_size',round($empty_size));

	echo "___CUT___" . $last_update;
?>