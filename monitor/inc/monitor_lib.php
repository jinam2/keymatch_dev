<?php
#####################################################################################
#####																			#####
#####							솔루션 모니터링 함수 모음						#####
#####																			#####
#####################################################################################

function happy_monitor_config_create()
{
	global $happy_monitor_config, $CHECK_CONDITION_CONF, $DEFAULT_SETTING_VALUE;

	$row = happy_mysql_fetch_array(query("SHOW TABLES LIKE '$happy_monitor_config'"), MYSQL_NUM);

	if ( $row === false )
	{
		query("
		CREATE TABLE `{$happy_monitor_config}` (
		`number` int(11) NOT NULL auto_increment,
		`conf_name` varchar(100) NOT NULL default '',
		`conf_value` mediumtext NOT NULL,
		`reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
		`mod_date` datetime NOT NULL default '0000-00-00 00:00:00',
		PRIMARY KEY  (`number`)
		);
		");
	}

	//기본값 저장
	$MONITOR_CONFIG	= Array();

	$Sql			= "SELECT conf_name,conf_value FROM $happy_monitor_config";
	$Result			= query($Sql);

	while ( list($conf_name,$conf_value) = happy_mysql_fetch_array($Result) )
	{
		$MONITOR_CONFIG[$conf_name] = $conf_value;
	}

	//솔루션 운영 현황 기본값 저장
	foreach ( $CHECK_CONDITION_CONF['check_table'] as $now_conf )
	{
		$now_key_check_day		= $now_conf['conf_name'].'_check_day';
		$now_key_target			= $now_conf['conf_name'].'_target';

		if ( $MONITOR_CONFIG[$now_key_check_day] == "" )
		{
			happy_monitor_config_save($now_key_check_day,$now_conf['default_check_day']);
		}

		if ( $MONITOR_CONFIG[$now_key_target] == "" )
		{
			happy_monitor_config_save($now_key_target,$now_conf['default_target']);
		}
	}

	//용량, 부하 체크 기본값 저장
	foreach ( $DEFAULT_SETTING_VALUE as $now_name => $now_value )
	{
		if ( $MONITOR_CONFIG[$now_name] == "" )
		{
			happy_monitor_config_save($now_name,$now_value);
		}
	}
}



function happy_monitor_config_load()
{
	global $happy_monitor_config, $MONITOR_CONFIG;

	$MONITOR_CONFIG	= Array();

	$Sql			= "SELECT conf_name,conf_value FROM $happy_monitor_config";
	$Result			= query($Sql);

	while ( list($conf_name,$conf_value) = happy_mysql_fetch_array($Result) )
	{
		$MONITOR_CONFIG[$conf_name] = $conf_value;
	}

	return $MONITOR_CONFIG;
}


function happy_monitor_config_save($conf_name,$conf_value)
{
	global $happy_monitor_config;

	if ( $conf_name == "" )
	{
		return;
	}

	$Sql			= "SELECT COUNT(number) FROM $happy_monitor_config WHERE conf_name = '$conf_name'";
	list($already)	= happy_mysql_fetch_array(query($Sql));

	if ( !$already )
	{
		$Sql		= "
						INSERT INTO
								$happy_monitor_config
						SET
								conf_name		= '$conf_name',
								conf_value		= '$conf_value',
								reg_date		= NOW(),
								mod_date		= NOW()
					";
	}
	else
	{
		$Sql		= "
						UPDATE
								$happy_monitor_config
						SET
								conf_value		= '$conf_value',
								mod_date		= NOW()
						WHERE
								conf_name		= '$conf_name'
					";
	}

	query($Sql);
}


function happy_monitor_config_delete($conf_name)
{
	global $happy_monitor_config;

	if ( $conf_name == "" )
	{
		return;
	}

	query("DELETE FROM $happy_monitor_config WHERE conf_name = '$conf_name'");
}


//관리자 인증
function is_admin()
{
	global $happy_monitor_cookie_name;

	if ( $_COOKIE[$happy_monitor_cookie_name] == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}
}

//캐릭터셋
if ( !function_exists('is_utf8') )
{
	function is_utf8()
	{
		global $server_character;

		if ( preg_match("/utf/i",$server_character) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function table_exists($tbname)
{
	global $db_host, $db_user, $db_pass, $db_name;

	if ( $tbname == '' ) return false;

	$tb_info	= explode(".",$tbname);

	if ( $tb_info[1] != "" )
	{
		$dbname		= $tb_info[0];
		$tbname		= $tb_info[1];

		$db			= @mysql_connect($db_host, $db_user, $db_pass);
		@mysql_select_db($dbname,$db);

		$result		= query("SHOW TABLES LIKE '$tbname'");
		$row		= happy_mysql_fetch_array($result);

		@mysql_select_db($db_name,$db);
	}
	else
	{
		$result		= query("SHOW TABLES LIKE '$tbname'");
		$row		= happy_mysql_fetch_array($result);
	}

	return ( $row[0] == "" )? false : true;
}

function cgimall_connect($call_type,$solution_type='')
{
	if ( !$call_type )
	{
		return false;
	}

	$url			= "http://cgimall.co.kr/solution_install_tool.php";
	$url			.= "?call_type=" . $call_type;
	$url			.= "&solution_type=" . $solution_type;

	$result			= happy_monitor_fsockopen($url);

	$result			= explode("___CUT___",$result);

	if ( $result[0] == "ok" )
	{
		return unserialize($result[1]);
	}
	else
	{
		return false;
	}
}


function dirsize($dir)
{
	global $dir_size, $dir_count, $file_count;

	if ( !is_dir($dir) )
	{
		return 0;
	}

	$fp			= opendir($dir);

	while( ($entry = readdir($fp)) !== false )
	{
		if ( $entry != "." && $entry != ".." )
		{
			if ( is_dir($dir.'/'.$entry) )
			{
				$dir_count++;

				clearstatcache();
				dirsize($dir.'/'.$entry);

			}
			else if ( is_file($dir.'/'.$entry) )
			{
				$dir_size	+= filesize($dir.'/'.$entry);
				clearstatcache();

				$file_count++;
			}
		}
	}
	closedir($fp);

	$array		= Array(
						'volume'		=> $dir_size,
						'dir_count'		=> $dir_count,
						'file_count'	=> $file_count
				);

	return $array;
}


function get_volume_unit($size=0)
{
	$kbyte				= 1024;
	$mbyte				= $kbyte * 1024;
	$gbyte				= $mbyte * 1024;

	if( $size < $kbyte )
	{
		return number_format($size,2) . ' B';
	}
	else if( $size > $kbyte && $size < $mbyte )
	{
		return number_format($size/$kbyte,2) . ' KB';
	}
	else if( $size > $mbyte && $size < $gbyte )
	{
		return number_format($size/$mbyte,2) . ' MB';
	}
	else if( $size > $gbyte )
	{
		return number_format($size/$gbyte,2) . ' GB';
	}

	return 0;
}


function del_dir($dir)
{
	if( !is_dir($dir) )
	{
		return false;
	}

	$fp		= opendir($dir);

	while( ($entry = readdir($fp)) !== false )
	{
		if ( $entry != "." && $entry != ".." )
		{
			if ( is_file($dir.'/'.$entry) )
			{
				unlink($dir.'/'.$entry);
			}
		}
	}
	closedir($fp);

	if ( rmdir($dir) )
	{
		return true;
	}
	else
	{
		return false;
	}
}

function happy_monitor_volume_save($data=array())
{
	global $happy_monitor_volume, $VOLUME_SETTING;

	if ( count($data) == 0 )
	{
		return;
	}

	$row = happy_mysql_fetch_array(query("SHOW TABLES LIKE '$happy_monitor_volume'"), MYSQL_NUM);

	if ( $row === false )
	{
		query("
		CREATE TABLE `{$happy_monitor_volume}` (
		`number` bigint(20) unsigned NOT NULL auto_increment,
		`volume` bigint(20) unsigned NOT NULL default '0',
		`dir_count` bigint(20) unsigned NOT NULL default '0',
		`file_count` bigint(20) unsigned NOT NULL default '0',
		`date` datetime NOT NULL default '0000-00-00 00:00:00',
		PRIMARY KEY  (`number`)
		);
		");
	}

	$Sql				= "SELECT date FROM $happy_monitor_volume ORDER BY date desc LIMIT 1";
	list($last_date)	= happy_mysql_fetch_array(query($Sql));

	$is_date			= false;

	if ( $last_date == "" )
	{
		$is_update			= true;
	}
	else
	{
		list($tmp_day,$tmp_time)	= explode(" ",$last_date);
		list($tmp_y,$tmp_m,$tmp_d)	= explode("-",$tmp_day);
		list($tmp_h,$tmp_i,$tmp_s)	= explode(":",$tmp_time);

		$tmp_mktime					= happy_mktime($tmp_h + intval($VOLUME_SETTING['update_term']),$tmp_i,$tmp_s,$tmp_m,$tmp_d,$tmp_y);

		if ( $tmp_mktime <= happy_mktime() )
		{
			$is_update			= true;
		}
	}

	if ( $is_update )
	{
		$Sql				= "
								INSERT INTO
										$happy_monitor_volume
								SET
										volume			= '{$data['volume']}',
										dir_count		= '{$data['dir_count']}',
										file_count		= '{$data['file_count']}',
										date			= NOW()
							";
		query($Sql);
	}

	//저장기간 지난 ROWS 제거
	query("DELETE FROM $happy_monitor_volume WHERE date < date_add(NOW(),INTERVAL -{$VOLUME_SETTING['truncate_term']} day)");
}

function happy_monitor_fsockopen( $url , $is_status=false)
{
	$URL_parsed		= parse_url($url);

	$host			= $URL_parsed['host'];
	$port			= $URL_parsed['port'];
	if ($port==0)
	{
		$port			= 80;
	}

	$path			= $URL_parsed['path'];
	if ($URL_parsed['query'] != "")
	{
		$path			.= "?".$URL_parsed['query'];
	}

	$out			= "GET $path HTTP/1.0\r\nHost: $host\r\n\r\n";

	$fp				= fsockopen($host, $port, $errno, $errstr, 30);

	if (!$fp)
	{
		echo "$errstr ($errno)<br>\n";
	}
	else
	{
		fputs($fp, $out);
		$body			= false;
		while (!feof($fp))
		{
			$s				= fgets($fp, 128);

			if ( $is_status )
			{
				$in				= $s;
				break;
			}
			else
			{
				if ( $body )
				{
					$in				.= $s;
				}
				if ( $s == "\r\n" )
				{
					$body			= true;
				}
			}
		}

		fclose($fp);
		return $in;
	}
}

function happy_monitor_snoopy($action_url,$submit_vars,$submit_files=array())
{
	if ( $action_url == "" )
	{
		return;
	}

	$monitor_snoopy = new Snoopy;
	$monitor_snoopy->referer = "http://".getenv('HTTP_HOST');
	$monitor_snoopy->set_submit_multipart();
	$monitor_snoopy->submit($action_url,$submit_vars,$submit_files);
	return $monitor_snoopy->results;
}


//데모락 검사 함수
function happy_monitor_check_demo_lock()
{
	global $server_path, $CONFIG_EXPEND, $demo_lock, $main_url;

	$return_data			= Array(
									'lock_count'	=> 0,
									'data'			=> Array()
							);

	//솔루션 기본 데모락 검사 START
	$is_lock				= false;

	if ( $demo_lock )
	{
		$is_lock				= true;
		$return_data['lock_count']++;
	}

	$tmpData				= Array(
									'title'		=> "솔루션 기본 데모락",
									'path'		=> "inc/function.php",
									'is_lock'	=> $is_lock
							);

	array_push($return_data['data'],$tmpData);
	//솔루션 기본 데모락 검사 END

	//각종 데모락 검사 START
	$demo_lock_list			= cgimall_connect('demo_lock',$CONFIG_EXPEND['happy_solution_type']);

	foreach ( $demo_lock_list as $now_conf )
	{
		$conf_value				= unserialize($now_conf['conf_value']);

		if ( !is_file($server_path.$conf_value['demo_lock_path']) )
		{
			continue;
		}

		$url					= $main_url;
		$url					.= "/monitor/check_demo_lock.php";
		$url					.= "?path=" . base64_encode($conf_value['demo_lock_path']);
		$url					.= "&var_name=" . base64_encode($conf_value['demo_lock_var_name']);

		if ( happy_monitor_fsockopen($url) == "unlock" )
		{
			$is_lock				= false;
		}
		else
		{
			$is_lock				= true;
			$return_data['lock_count']++;
		}

		//UTF-8 서버의 경우 데모락 이름 iconv
		if ( is_utf8() )
		{
			$now_conf['conf_name']	= iconv("euc-kr","utf-8",$now_conf['conf_name']);
		}

		$tmpData				= Array(
										'title'		=> $now_conf['conf_name'],
										'path'		=> $conf_value['demo_lock_path'],
										'is_lock'	=> $is_lock,
								);

		array_push($return_data['data'],$tmpData);
	}
	//각종 데모락 검사 END

	return $return_data;
}


//권한체크 함수
function happy_monitor_check_permission()
{
	global $server_path, $CONFIG_EXPEND;

	$return_data			= Array(
									'path'			=> Array(),
									'cmd'			=> "",
									'count_total'	=> 0,
									'count_ok'		=> 0,
									'count_no'		=> 0
							);

	$permission_list		= cgimall_connect('permission',$CONFIG_EXPEND['happy_solution_type']);

	foreach ( $permission_list as $now_data )
	{
		$conf_value				= unserialize($now_data['conf_value']);
		$permission_path		= explode("\r\n",$conf_value['permission_path']);

		foreach ( $permission_path as $now_path )
		{
			if ( file_exists($server_path.$now_path) )
			{
				if ( is_writable($server_path.$now_path) )
				{
					$return_data['count_ok']++;
				}
				else
				{
					$return_data['count_no']++;
				}

				$return_data['cmd']	.= $enter_key."chmod -R {$conf_value['permission']} {$now_path}";
				$enter_key				= "\r\n";

				array_push($return_data['path'],$now_path);

				$return_data['count_total']++;
			}
		}
	}

	return $return_data;
}


//각종 솔루션 기능 체크 함수
function happy_monitor_check_solution($type)
{
	global $CHECK_API_CONFIG, $main_url;

	$CONF				= $CHECK_API_CONFIG[$type];

	if ( !is_array($CONF) )
	{
		return false;
	}

	$CONF['action_url']	= $main_url."/".$CONF['action_file'];

	switch ( $type )
	{
		case 'utf8_char'		: return happy_monitor_check_area2road($CONF);
		case 'area2road'		: return happy_monitor_check_area2road($CONF);
		case 'road2area'		: return happy_monitor_check_road2area($CONF);
		case 'bbs_regist'		: return happy_monitor_check_bbs_regist($CONF);
		case 'member_join'		: return happy_monitor_check_member_join($CONF);
		case 'upload_wys'		: return happy_monitor_check_upload_wys($CONF);
		case 'short_domain'		: return happy_monitor_check_short_domain($CONF);
		case 'send_mail'		: return happy_monitor_check_send_mail($CONF);
	}
}

//주소변환 체크 함수(지번->도로명)
function happy_monitor_check_area2road($CONF)
{
	global $server_path;

	if ( !is_file($server_path.$CONF['action_file']) )
	{
		happy_monitor_config_delete('check_area2road');
		return 'exists';
	}

	$action_url		= $CONF['action_url']."?";

	foreach ( $CONF['submit_vars'] as $field => $addr )
	{
		if ( !is_utf8() )
		{
			$addr			= iconv("euc-kr","utf-8",$addr);
		}

		$action_url		.= $and_mark.$field."=".urlencode($addr);
		$and_mark		= "&";
	}

	$return_value	= happy_monitor_fsockopen($action_url);

	$contents		= explode("---cut---",$return_value);
	$content		= strip_tags($contents[count($contents)-1]);
	$content		= str_replace("도로명 주소","",$content);

	$is_ok			= "no";
	if ( strpos($content,$CONF['check_value']) !== false )
	{
		$is_ok			= "ok";
	}

	//monitor_config에 테스트 값 저장
	happy_monitor_config_save('check_area2road',$is_ok);

	if ( is_utf8() )
	{
		happy_monitor_config_save('check_utf8_char',$is_ok);
	}
	else
	{
		happy_monitor_config_delete('check_utf8_char');
	}

	if ( $is_ok == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}
}


//주소변환 체크 함수(도로명->지번)
function happy_monitor_check_road2area($CONF)
{
	global $server_path;

	if ( !is_file($server_path.$CONF['action_file']) )
	{
		happy_monitor_config_delete('check_road2area');
		return 'exists';
	}

	$action_url		= $CONF['action_url']."?";

	foreach ( $CONF['submit_vars'] as $field => $addr )
	{
		if ( !is_utf8() )
		{
			$addr			= iconv("euc-kr","utf-8",$addr);
		}

		$action_url		.= $and_mark.$field."=".urlencode($addr);
		$and_mark		= "&";
	}

	$return_value	= happy_monitor_fsockopen($action_url);

	$contents		= explode("___CUT___",$return_value);
	$return_msg		= $contents[0];
	$content		= $contents[1]." ".$contents[2]." ".$contents[3]." ".$contents[4]."-".$contents[5];

	$is_ok			= "no";

	if ( $return_msg == "SUCCESS" && strpos($content,$CONF['check_value']) !== false )
	{
		$is_ok			= "ok";
	}

	//monitor_config에 테스트 값 저장
	happy_monitor_config_save('check_road2area',$is_ok);

	if ( $is_ok == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}
}


//주소변환 체크 함수(도로명->지번)
function happy_monitor_check_bbs_regist($CONF)
{
	global $DB_Prefix, $dobae_number;

	//도배방지키 통과시키기
	$CONF['submit_vars']['dobae_org'] = $dobae_number - $CONF['submit_vars']['dobae'];

	//게시글 작성 전송
	$cont = happy_monitor_snoopy($CONF['action_url'],$CONF['submit_vars'],$CONF['submit_files']);

	//게시글 작성 검증
	$tbname				= $DB_Prefix.$CONF['submit_vars']['tb'];
	$where_array		= Array();

	foreach ( $CONF['submit_vars'] as $now_key => $now_value )
	{
		if ( preg_match("/bbs_/",$now_key) )
		{
			array_push($where_array," $now_key = '$now_value' ");
		}
	}

	$WHERE				= ( count($where_array) > 0 ) ? implode(" AND ",$where_array) : " 1=1 ";

	$is_ok				= "no";

	if ( table_exists($tbname) )
	{
		$Sql				= "SELECT * FROM $tbname WHERE write_ip = '{$_SERVER['SERVER_ADDR']}' AND $WHERE ORDER BY number desc LIMIT 1";
		$BOARD				= happy_mysql_fetch_array(query($Sql));

		if ( $BOARD['number'] != "" )
		{
			$is_ok				= "ok";

			//게시글 삭제
			$bbs_del_file		= str_replace("bbs_regist.php","bbs_del.php",$CONF['action_url']);
			$bbs_del_url		= $bbs_del_file."?tb=".$CONF['submit_vars']['tb']."&bbs_num=".$BOARD['number']."&write_password=".$BOARD['bbs_pass'];
			happy_monitor_fsockopen($bbs_del_url);
		}
	}

	//monitor_config에 테스트 값 저장
	happy_monitor_config_save('check_bbs_regist',$is_ok);

	if ( $is_ok == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}
}


function happy_monitor_check_member_join($CONF)
{
	global $happy_member, $happy_member_group;
	global $happy_config, $kcb_namecheck_use;

	if ( !table_exists($happy_member) )
	{
		happy_monitor_config_delete('check_member_join');
		return "exists";
	}

	//KCB본인인증 off
	$kcb_use_org		= $kcb_namecheck_use;

	if ( $kcb_namecheck_use == '1' )
	{
		query("UPDATE $happy_config SET conf_value = '0' WHERE conf_name = 'kcb_namecheck_use'");
	}

	$Sql				= "SELECT * FROM $happy_member_group WHERE group_member_join = 'y' ORDER BY rand() LIMIT 1";
	$Group				= happy_mysql_fetch_array(query($Sql));

	$iso_real_name_org	= $Group['iso_real_name'];
	$iso_jumin_org		= $Group['iso_jumin'];
	$iso_hphone_org		= $Group['iso_hphone'];
	$iso_email_org		= $Group['iso_email'];

	//인증여부 모두 off
	$Sql				= "
							UPDATE
									$happy_member_group
							SET
									iso_real_name		= 'n',
									iso_jumin			= 'n',
									iso_hphone			= 'n',
									iso_email			= 'n'
							WHERE
									number				= '{$Group['number']}'
						";
	query($Sql);

	//그룹번호 저장
	$CONF['submit_vars']['group']	= $Group['number'];

	happy_monitor_snoopy($CONF['action_url'],$CONF['submit_vars']);

	$Sql				= "SELECT * FROM $happy_member WHERE user_id = '{$CONF['check_value']}'";
	$MEMBER				= happy_mysql_fetch_array(query($Sql));

	$is_ok				= "no";

	if ( $MEMBER['number'] != "" )
	{
		//KCB본인인증 원상복구
		query("UPDATE $happy_config SET conf_value = '$kcb_use_org' WHERE conf_name = 'kcb_namecheck_use'");

		//인증여부 원상복구
		$Sql				= "
								UPDATE
										$happy_member_group
								SET
										iso_real_name		= '$iso_real_name_org',
										iso_jumin			= '$iso_jumin_org',
										iso_hphone			= '$iso_hphone_org',
										iso_email			= '$iso_email_org'
								WHERE
										number				= '{$Group['number']}'
							";
		query($Sql);

		//회원정보 삭제
		query("DELETE FROM $happy_member WHERE user_id = '{$CONF['check_value']}' ");

		$is_ok				= "ok";
	}

	//monitor_config에 테스트 값 저장
	happy_monitor_config_save('check_member_join',$is_ok);

	if ( $is_ok == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}
}

function happy_monitor_check_upload_wys($CONF)
{
	global $server_path;

	$return_value		= happy_monitor_snoopy($CONF['action_url'],$CONF['submit_vars'],$CONF['submit_files']);

	$is_ok				= "no";

	if ( preg_match("/OnUploadCompleted(.*),[\"|\'](.*?)[\"|\'],(.*)/",$return_value,$matches) )
	{
		$upload_file_name	= trim($matches[2]);
		$upload_file_path	= $server_path."wys2/file_attach/".date("Y/m/d").'/'.$upload_file_name;
		$thumb_file_path	= $server_path."wys2/file_attach_thumb/".date("Y/m/d").'/'.$upload_file_name;

		if ( is_file($upload_file_path) )
		{
			@unlink($upload_file_path);

			if ( is_file($thumb_file_path) )
			{
				@unlink($thumb_file_path);
			}

			$is_ok				= "ok";
		}
	}

	//monitor_config에 테스트 값 저장
	happy_monitor_config_save('check_upload_wys',$is_ok);

	if ( $is_ok == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}
}


function happy_monitor_check_short_domain($CONF)
{
	global $server_alias;

	if ( $server_alias == "" )
	{
		happy_monitor_config_delete('check_short_domain');
		return "exists";
	}

	$status				= happy_monitor_fsockopen($CONF['action_url'],true);
	$is_ok				= "no";

	if ( preg_match("/200 OK/i",$status) )
	{
		$is_ok				= "ok";
	}

	//monitor_config에 테스트 값 저장
	happy_monitor_config_save('check_short_domain',$is_ok);

	if ( $is_ok == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}
}


function happy_monitor_check_send_mail($to_mail)
{
	global $send_mail_check_conf, $server_character_mail;

	if ( $to_mail == "" )
	{
		return false;
	}

	$MAIL				= $send_mail_check_conf;

	$MAIL['to_mail']	= $to_mail;

	$is_ok				= "no";

	if ( HappyMail($MAIL['from_name'], $MAIL['from_mail'],$MAIL['to_mail'],$MAIL['mail_title'],$MAIL['mail_content']) )
	{
		$is_ok				= "ok";
	}

	//monitor_config에 테스트 값 저장
	happy_monitor_config_save('check_send_mail',$is_ok);
	happy_monitor_config_save('check_send_mail_date',date("Y-m-d H:i:s"));

	if ( $is_ok == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}
}




# 사이트 현황 정보 return 함수
function happy_condition_data()
{
	global $db_name, $demo_lock, $CHECK_CONDITION_CONF, $MONITOR_CONFIG;

	$condition_data	= Array();
	$max_level		= $CHECK_CONDITION_CONF['check_level'][count($CHECK_CONDITION_CONF['check_level'])-1];

	foreach ( $CHECK_CONDITION_CONF['check_table'] as $now_conf )
	{
		if ( $demo_lock )
		{
			$now_conf['check_day']	= $now_conf['demo_check_day'];
			$now_conf['target']		= $now_conf['demo_target'];
		}
		else
		{
			$now_conf['check_day']	= intval($MONITOR_CONFIG[$now_conf['conf_name'].'_check_day']);
			$now_conf['target']		= intval($MONITOR_CONFIG[$now_conf['conf_name'].'_target']);

			if ( $now_conf['check_day'] == "" )
			{
				$now_conf['check_day']	= $now_conf['default_check_day'];
			}

			if ( $now_conf['target'] == "" )
			{
				$now_conf['target']		= $now_conf['default_target'];
			}
		}

		$check_tables			= Array();

		// board_list 와 같이 다중 테이블을 조회하는 경우
		if ( is_array($now_conf['table']) )
		{
			$now_table				= $now_conf['table']['table'];
			$now_field				= $now_conf['table']['field'];

			if ( table_exists($now_table) )
			{
				$Sql					= "SELECT {$now_field} FROM {$now_table}";
				$Result					= query($Sql);

				while ( list($tbname) = happy_mysql_fetch_array($Result) )
				{
					if ( table_exists($tbname) )
					{
						array_push($check_tables,$tbname);
					}
				}

				unset($tbname);
			}
		}
		// 단일 테이블을 조회하는 경우
		else
		{
			if ( table_exists($now_conf['table']) )
			{
				array_push($check_tables,$now_conf['table']);
			}
		}

		array_unique($check_tables);

		if ( count($check_tables) == 0 )
		{
			continue;
		}

		$check_value_total		= 0;

		foreach ( $check_tables as $tbname )
		{
			$type_query				= "";
			$where_query			= "";

			switch ( $now_conf['type'] )
			{
				case 'count'	: $type_query	= "COUNT(".$now_conf['check_field'].")";	break;
				case 'sum'		: $type_query	= "SUM(".$now_conf['check_field'].")";		break;
				default			: $type_query	= $now_conf['check_field'];					break;
			}

			if ( count($now_conf['where_query']) > 0 )
			{
				$where_query			= implode(" ",$now_conf['where_query']);
			}

			$SetSql					= "
										SELECT
												{$type_query}
										FROM
												{$tbname}
										WHERE
												{$now_conf['date_field']} > DATE_ADD(NOW(),INTERVAL -{$now_conf['check_day']} DAY)
												{$where_query}
									";
			list($check_value)		= happy_mysql_fetch_array(query($SetSql));

			$check_value			= ( $check_value == "" ) ? 0 : intval($check_value);

			$check_value_total		+= $check_value;
		}

		$now_percent			= 0;

		if ( $now_conf['target'] > 0 )
		{
			if ( $check_value_total > 0 )
			{
				$now_percent			= $check_value_total/$now_conf['target']*100;
			}
			else
			{
				$now_percent			= 0;
			}
		}
		else
		{
			$now_percent			= 100;
		}

		$return_array			= Array(
										'title'			=> $now_conf['title'],
										'target'		=> $now_conf['target'],
										'unit'			=> $now_conf['unit'],
										'check_day'		=> $now_conf['check_day'],
										'start_date'	=> date("Y-m-d H:i:s",happy_mktime()-($now_conf['check_day']*86400)),
										'check_value'	=> $check_value_total,
										'check_percent'	=> $now_percent,
										'level'			=> Array()
								);

		foreach ( $CHECK_CONDITION_CONF['check_level'] as $now_level )
		{
			// 달성한 퍼센트가 최고 레벨보다 높을때
			if ( $now_percent >= $max_level['percent'] )
			{
				$return_array['level']		= $max_level;
				break;
			}
			// 달성한 퍼센트가 현재 레벨보다 높을때
			else if ( $now_percent > $now_level['percent'] )
			{
				continue;
			}
			// 달성한 퍼센트가 이전 레벨보다 높고 현재 레벨보다 낮을대
			else
			{
				$return_array['level']		= $now_level;
				break;
			}
		}

		array_push($condition_data,$return_array);
	}

	return $condition_data;
}

function happy_monitor_check_load_time($type='')
{
	global $happy_monitor_config;
	global $db_host, $db_user, $db_pass, $db_name;

	$MONITOR_CONFIG				= happy_monitor_config_load();

	//MySQL 접속 체크
	if ( $type == "mysql" )
	{
		$load_time_check_repeat_db	= intval($MONITOR_CONFIG['load_time_check_repeat_db']);	//평균 계산을 위한 반복 횟수
		$average_start				= $MONITOR_CONFIG['load_time_average_start_db'];		//체크 범위 시작
		$average_end				= $MONITOR_CONFIG['load_time_average_end_db'];			//체크 범위 끝

		$total_time					= 0;

		for ( $x = 0 ; $x < 100 ; $x++ )
		{
			$t_start					= array_sum(explode(' ', microtime()));

			// connect to database
			if ( !$db = @mysql_connect($db_host, $db_user, $db_pass) )
			{
				return 100;
			}
			else
			{
				// Select DB
				if ( !@mysql_select_db($db_name, $db) )
				{
					return 100;
				}

				$exec_time					= array_sum(explode(' ', microtime())) - $t_start;
				$total_time					+= $exec_time;
			}
		}

		$average_this				= round(($total_time/$load_time_check_repeat_db), 2);
	}
	//CPU 부하 체크
	else
	{
		$load_time_check_repeat		= intval($MONITOR_CONFIG['load_time_check_repeat']);	//평균 계산을 위한 반복 횟수
		$load_time_check_limit		= intval($MONITOR_CONFIG['load_time_check_limit']);		//1회 반복시 연산 횟수
		$average_start				= $MONITOR_CONFIG['load_time_average_start'];			//체크 범위 시작
		$average_end				= $MONITOR_CONFIG['load_time_average_end'];				//체크 범위 끝

		$total_time					= 0;

		for ( $x = 0 ; $x < $load_time_check_repeat ; $x++ )
		{
			$time						= 0;
			$t_start					= array_sum(explode(' ', microtime()));

			for ( $y = 0 ; $y < $load_time_check_limit ; $y++ )
			{
				$time						+= $time * $y;
			}

			$exec_time					= array_sum(explode(' ', microtime())) - $t_start;
			$total_time					+= $exec_time;
		}

		$average_this				= round(($total_time/$load_time_check_repeat), 2);
	}

	//결과를 퍼센테이지로 산출
	$term						= ($average_end - $average_start)/10;

	$print_score				= 1;

	if ( $average_start >= $average_this )
	{
		$print_score				= 10;
	}
	else
	{
		$now						= $average_start;

		for ( $i = 10 ; $i > 1 ; $i-- )
		{
			$next						= $now + $term;

			if ( $average_this < $next && $now < $average_this )
			{
				$print_score				= $i;
				break;
			}

			$now						+= $term;
		}
	}

	$array		= Array(
						'score'			=> $print_score,
						'average_time'	=> $average_this
				);

	return $array;
}

?>