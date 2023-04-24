<?php

############## 관리자모드 설정툴 관련 셋팅 ##############
$happy_config					= $DB_Prefix.'happy_config';
$happy_config_group				= $DB_Prefix.'happy_config_group';
$happy_config_part				= $DB_Prefix.'happy_config_part';
$happy_config_field				= $DB_Prefix.'happy_config_field';
$happy_config_auto_addslashe	= '1';
$happy_config_upload_folder		= 'upload/happy_config';	# 맨앞에 슬러쉬 없이 경로 작성. 끝에도 슬러쉬 없음. 폴더/폴더/폴더

############################ HAPPY_CONFIG 읽기 ############################
$HAPPY_CONFIG_FILE				= $server_path."inc/happy_config/happy_config_file.php";
$HAPPY_CONFIG_FILE2				= $server_path."inc/happy_config/happy_config_file2.php";
$HAPPY_CONFIG_FILE_TEMP			= $server_path."inc/happy_config/happy_config_file_temp.php";
$HAPPY_CONFIG_FILE_LOCK			= $server_path."data/happy_config_file_lock";
$HAPPY_CONFIG_FILE_SAVE			= false;

if ( file_exists($HAPPY_CONFIG_FILE) && file_exists($HAPPY_CONFIG_FILE2) )
{
	if ( readlastline($HAPPY_CONFIG_FILE) == '?>' )
	{
		include ($HAPPY_CONFIG_FILE);

		if ( !is_array($HAPPY_CONFIG) || count($HAPPY_CONFIG) == 0 )
		{
			$HAPPY_CONFIG_FILE_SAVE  = true;
		}
	}
	else
	{
		$HAPPY_CONFIG_FILE_SAVE		= true;
	}
}
else //파일이 없으니 새로 만들어주자
{
	for ( $hf = 1 ; $hf <= 2 ; $hf++ )
	{
		$hfn		= ( $hf == 1 ) ? "" : $hf;

		if ( !file_exists(${'HAPPY_CONFIG_FILE'.$hfn}) )
		{
			$hfp		= fopen(${'HAPPY_CONFIG_FILE'.$hfn}, "w");
			@chmod(${'HAPPY_CONFIG_FILE'.$hfn}, 0707);
			fwrite($hfp, "");
			fclose($hfp);
		}
	}

	$HAPPY_CONFIG_FILE_SAVE		= true;
}

//파일을 다시 저장해야 하는 경우 DB에서 불러옴
if ( $HAPPY_CONFIG_FILE_SAVE )
{
	$db = @mysql_connect($db_host, $db_user, $db_pass);
	@mysql_select_db($db_name, $db);

	//set names utf8 처리
	if ( $call_set_names_utf )
	{
		@mysql_query("set names utf8",$db);
	}

	$Sql				= "SELECT * FROM {$db_prefix}{$happy_config} ORDER BY number ASC";
	$Record				= @mysql_query($Sql,$db);

	while ( $TmpValue = @happy_mysql_fetch_array($Record) )
	{
		if ( $TmpValue['conf_out_type'] == 'array' )
		{
			$TmpValue['conf_value']		= explode(",",$TmpValue['conf_value']);
		}
		else if ( $Value['conf_out_type'] == 'nl2br' )
		{
			$TmpValue['conf_value']		= nl2br($TmpValue['conf_value']);
		}

		$HAPPY_CONFIG[$TmpValue['conf_name']]	= $TmpValue['conf_value'];
		${$TmpValue['conf_name']}				= $TmpValue['conf_value'];
	}
}

//LOCK 파일 검사
if ( file_exists($HAPPY_CONFIG_FILE_LOCK) )
{
	if ( @filemtime($HAPPY_CONFIG_FILE_LOCK) < happy_mktime()-30 )
	{
		@unlink($HAPPY_CONFIG_FILE_LOCK);
	}
}

//파일 마지막줄 읽어오기 함수
function readlastline($file)
{
	$fp			= @fopen($file, "r");
	$pos		= -1;
	$t			= " ";
	while ($t != "\n")
	{
		fseek($fp, $pos, SEEK_END);
		$t			= fgetc($fp);
		$pos		= $pos - 1;

		if ( $pos < -100 ) break;
	}

	$t			= fgets($fp);
	fclose($fp);

	return $t;
}

// HAPPY_CONFIG 를 불러와 FILE 로 생성하는 함수
function HAPPY_CONFIG_FILE($save = '')
{
	global $db_host, $db_user, $db_pass, $db_name;
	global $happy_config, $call_set_names_utf, $db_prefix;
	global $HAPPY_CONFIG_FILE, $HAPPY_CONFIG_FILE2, $HAPPY_CONFIG_FILE_TEMP, $HAPPY_CONFIG_FILE_LOCK;

	$enter_key					= chr(13) . chr(10);

	if( !is_file($HAPPY_CONFIG_FILE_LOCK) && (!is_file($HAPPY_CONFIG_FILE) || $save != ''))
	{
		$fp		= fopen($HAPPY_CONFIG_FILE_LOCK, "w");
		fwrite($fp, "happy_config_file_lock");
		fclose($fp);

		if ( function_exists('query') )
		{
			$Sql	= "SELECT * FROM $happy_config ORDER BY conf_name ASC";
			$Record	= query($Sql);
		}
		else
		{
			$db = @mysql_connect($db_host, $db_user, $db_pass);
			@mysql_select_db($db_name, $db);

			//set names utf8 처리
			if ( $call_set_names_utf )
			{
				@mysql_query("set names utf8",$db);
			}

			$Sql	= "SELECT * FROM {$db_prefix}{$happy_config} ORDER BY conf_name ASC";
			$Record	= @mysql_query($Sql,$db);
		}

		$fp		= fopen($HAPPY_CONFIG_FILE2, "w");
		flock($fp, LOCK_EX);
		@chmod($HAPPY_CONFIG_FILE2, 0707);

		fwrite($fp, "<?${enter_key}");
		fwrite($fp, "${enter_key}${enter_key}############################ HAPPY_CONFIG ############################${enter_key}${enter_key}${enter_key}");

		while ( $Value = happy_mysql_fetch_array($Record) )
		{
			if ( $Value['conf_out_type'] == 'array' )
			{
				$Value['conf_value']	= explode(",",$Value['conf_value']);
			}
			else if ( $Value['conf_out_type'] == 'nl2br' )
			{
				$Value['conf_value']	= nl2br($Value['conf_value']);
			}

			$config_happy_value	= '$HAPPY_CONFIG[\'' . $Value['conf_name'] . '\']	= "' . addslashes($Value['conf_value']) . "\";${enter_key}";

			fwrite($fp, $config_happy_value);
		}

		fwrite($fp, $enter_key . $enter_key . 'foreach ( $HAPPY_CONFIG as $k => $v ) { $HAPPY_CONFIG[$k] = stripslashes($v); ${$k} = $HAPPY_CONFIG[$k];}' . $enter_key);
		fwrite($fp, "${enter_key}?>");
		fclose($fp);

		rename($HAPPY_CONFIG_FILE2,$HAPPY_CONFIG_FILE_TEMP);
		rename($HAPPY_CONFIG_FILE,$HAPPY_CONFIG_FILE2);
		rename($HAPPY_CONFIG_FILE_TEMP,$HAPPY_CONFIG_FILE);

		@unlink($HAPPY_CONFIG_FILE_LOCK);
	}
}
###########################################################################
?>