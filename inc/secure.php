<?
	include 'secure_config.php';

	################################################ 수정하지 마세요 ################################################
	if ( sizeof($_FILES) > 0 )
	{
		if ( $HAPPY_REFERER_CHECK == 'on' )
		{

			$HAPPY_REFERER			= str_replace('http://','',$_SERVER['HTTP_REFERER']);
			$HAPPY_REFERER			= str_replace('https://','',$HAPPY_REFERER);
			$HAPPY_REFERER			= explode('/', $HAPPY_REFERER);
			$HAPPY_REFERER			= str_replace('www.', '', $HAPPY_REFERER[0]);

			$HAPPY_NOW_DOMAIN		= str_replace('www.', '', $_SERVER['SERVER_NAME']);

			if ( $HAPPY_REFERER == '' || $HAPPY_NOW_DOMAIN != $HAPPY_REFERER )
			{
				HAPPY_SECURE_ERROR('타 사이트에서 업로드는 할 수 없습니다.');
				exit;
			}

		}

		$HAPPY_NOW_FILE_EXT		= Array();
		foreach ( $_FILES AS $now_key => $now_file )
		{
			$now_file				= $now_file['name'];
			if ( is_array($now_file) === true )
			{
				foreach ( $now_file AS $now_key2 => $now_file2 )
				{
					$now_file2				= $now_file[$now_key2];
					if ( $now_file2 != '' )
					{
						$now_files2				= explode('.', $now_file2);
						$now_ext2				= $now_files2[sizeof($now_files2)-1];

						$HAPPY_NOW_FILE_EXT[$now_file2]	= strtolower($now_ext2);
					}
				}
			}
			else if ( $now_file != '' )
			{
				$now_files				= explode('.', $now_file);
				$now_ext				= $now_files[sizeof($now_files)-1];

				$HAPPY_NOW_FILE_EXT[$now_file]	= strtolower($now_ext);
			}
		}
		#echo '<pre>'; print_r($_FILES); echo '</pre>';
		if ( $HAPPY_ALLOW_FILE_USE == 'on' )
		{
			foreach ( $HAPPY_NOW_FILE_EXT AS $now_file => $now_ext )
			{
				if ( array_search($now_ext, $HAPPY_ALLOW_FILE_EXT) === false )
				{
					HAPPY_SECURE_ERROR($now_file.' 파일은 업로드가 불가능 합니다.');
					exit;
				}
			}
		}

		if ( $HAPPY_DENY_FILE_USE == 'on' )
		{
			foreach ( $HAPPY_NOW_FILE_EXT AS $now_file => $now_ext )
			{
				if ( array_search($now_ext, $HAPPY_DENY_FILE_EXT) !== false )
				{
					HAPPY_SECURE_ERROR($now_file.' 파일은 업로드가 불가능 합니다..');
					exit;
				}
			}
		}
	}


	# Happy Config 가져오기
	$HAPPY_CONFIG_deny_post_tag			= str_replace(" ","",$HAPPY_CONFIG['deny_post_tag']);
	$HAPPY_CONFIG_deny_post_tag			= explode(",", $HAPPY_CONFIG['deny_post_tag']);
	$HAPPY_DENY_POST_TAG				= array_merge((array)$HAPPY_DENY_POST_TAG, (array)$HAPPY_CONFIG_deny_post_tag);
	# Happy Config 가져오기

	$HAPPY_DENY_POST_TAG				= array_unique($HAPPY_DENY_POST_TAG);

	if( sizeof($_POST) > 0 && $HAPPY_DENY_POST_USE == 'on')
	{
		foreach( $_POST AS $temp_key => $POST_value )
		{
			foreach( $HAPPY_DENY_POST_TAG AS $temp_key => $value )
			{
				if( $POST_value != "" && trim($value) != "" && strpos(strtolower($_SERVER['SCRIPT_FILENAME']), "happy_config") === false && strpos(strtolower($_SERVER['SCRIPT_FILENAME']), "design.php") === false )
				{
					//넘어온값이 배열일수도 있다. 2013-07-04 kad
					//print_r($POST_value);
					if ( is_array($POST_value) )
					{
						//print_r(array_values_recursive($POST_value));
						$POST_value2 = implode("", (array) array_values_recursive($POST_value));
					}
					else
					{
						$POST_value2 = $POST_value;
					}

					//echo "<font color='red'>".$POST_value2."</font><br>";
					if( strpos(strtolower($POST_value2), strtolower($value)) !== false )
					{
						echo "
								<script type='text/javascript'>
									alert(\"" . htmlspecialchars($value) . "는(은) 사용할수 없는 단어입니다.\");

									try
									{
										// js/default.js 파일에 함수가 선언된 경우 실행
										parent.happy_secure_error();
									}
									catch(e)
									{
										//console.log(e);
									}
								</script>
						";
						exit;
					}
				}
			}
		}
	}


	if ( sizeof($_POST) > 0 && $HAPPY_EMOJI_USE == 'on')
	{
		foreach( $_POST AS $temp_key => $POST_value )
		{
			if ( is_array($POST_value) )
			{
				foreach( $POST_value AS $temp_key2 => $POST_value2 )
				{
					if ( is_array($POST_value2) ) # 3차 배열은 검사하지 않음. (일반적인 필드가 아니므로 이모지가 들어갈 가능성이 매우 희박해 보이므로)
					{
						continue;
					}

					$result_value						= happy_emoji_remove($_POST[$temp_key][$temp_key2]);

					if ( isset(${$temp_key}[$temp_key2]) === false || $_POST[$temp_key][$temp_key2] == ${$temp_key}[$temp_key2] )
					{
						${$temp_key}[$temp_key2]			= $result_value;
					}

					$_POST[$temp_key][$temp_key2]		= $result_value;
				}

			}
			else
			{
				$result_value						= happy_emoji_remove($_POST[$temp_key]);

				if ( isset(${$temp_key}) === false || $_POST[$temp_key] == ${$temp_key} )
				{
					${$temp_key}						= $result_value;
				}

				$_POST[$temp_key]					= $result_value;
			}
		}
	}


	if( sizeof($_GET) > 0 && $HAPPY_DENY_GET_USE == 'on')
	{
		foreach( $_GET AS $temp_key => $GET_value )
		{
			foreach( $HAPPY_DENY_GET_TAG AS $temp_key => $value )
			{
				if( $GET_value != "" && $value != "" && strpos(strtolower($_SERVER['SCRIPT_FILENAME']), "happy_config") === false && strpos(strtolower($_SERVER['SCRIPT_FILENAME']), "design.php") === false )
				{
					//넘어온값이 배열일수도 있다. 2013-07-04 kad
					//print_r($GET_value);
					if ( is_array($GET_value) )
					{
						//print_r(array_values_recursive($GET_value));
						$GET_value2 = implode("", (array) array_values_recursive($GET_value));
					}
					else
					{
						$GET_value2 = $GET_value;
					}

					//echo "<font color='red'>".$GET_value2."</font><br>";
					$values			= explode('+', $value);
					$deny_check		= false;
					$deny_msg		= '';
					foreach ( $values AS $val )
					{
						if( strpos(strtolower($GET_value2), strtolower($val)) === false )
						{
							$deny_check		= true;
						}
						else
						{
							$deny_msg		.= $deny_msg == '' ? '' : ', ';
							$deny_msg		.= $val;
						}
					}

					if( ($deny_check === false && $HAPPY_DENY_GET_TAG_TYPE == 'multi') || ($deny_msg!='' && $HAPPY_DENY_GET_TAG_TYPE != 'multi') )
					{
						include "define_attack_check.php";
						hack_check_log($HAPPY_DENY_GET_LOG_OPTION);
						if ( $HAPPY_DENY_GET_TAG_ALERT === true )
						{
							echo "
									<script type='text/javascript'>
										alert(\"" . htmlspecialchars($deny_msg) . "는(은) 사용할수 없는 단어입니다.\");

										try
										{
											// js/default.js 파일에 함수가 선언된 경우 실행
											parent.happy_secure_error();
										}
										catch(e)
										{
											//console.log(e);
										}
									</script>
							";
						}
						else
						{
							echo "
									<script type='text/javascript'>
										alert(\"사용할수 없는 단어가 링크에 포함이 되어 있습니다.\");

										try
										{
											// js/default.js 파일에 함수가 선언된 경우 실행
											parent.happy_secure_error();
										}
										catch(e)
										{
											//console.log(e);
										}
									</script>
							";
						}
						exit;
					}
				}
			}
		}
	}

	# PHP_SELF 로 XSS 시도할 때를 위해서 PHP_SELF 치환
	if ( $HAPPY_PHP_SELF_REPLACE_USE == 'on' )
	{
		if ( $HAPPY_PHP_SELF_REPLACE_FUNCTION == 'htmlspecialchars' )
		{
			$PHP_SELF = $_SERVER['PHP_SELF']		= htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES,"UTF-8");
		}
		else
		{
			$PHP_SELF = $_SERVER['PHP_SELF']		= htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES,"UTF-8");
		}
	}

	function array_values_recursive($ary)
	{
		$lst = array();
		foreach( array_keys($ary) as $k )
		{
			$v = $ary[$k];
			if (is_scalar($v))
			{
				$lst[] = $v;
			}
			elseif (is_array($v))
			{
				$lst = array_merge($lst,array_values_recursive($v));
			}
		}
		return $lst;
	}

	function HAPPY_SECURE_ERROR($msg)
	{
		echo "
				<HTML>
				<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<TITLE>업로드 불가</TITLE>
					<script type='text/javascript'>
						try {
							window.parent.OnUploadCompleted(1,'','', '". str_replace( '"', '\\"', $msg ) ."') ;
						}
						catch (e)
						{
						}
					</script>
				</HEAD>
				<BODY bgcolor='white' text='black' link='blue' vlink='purple' alink='red' leftmargin='0' marginwidth='0' topmargin='0' marginheight='0'>
				  <div align='center'>
					<table style='height:100%;' cellspacing='0' cellpadding='0' border='0'>
					<tr>
					  <td valign='middle'>
						<table style='width:504px; height:292px; background:url(http://www.cgimall.co.kr/img/bgpart_all_error.jpg);' cellspacing='0' cellpadding='0' border='0'>
						<tr>
						  <td style='height:210px;' align='center' valign='middle'><font style='font-size:56px; letter-spacing:-1px; font-family:맑은 고딕, 돋움; font-weight:bold; color:red;'>Error</font></td>
						</tr>
						<tr>
						  <td align='center'><font style='font-size:11px; font-family:돋움;'>$msg</font></td>
						</tr>
						</table>
					  </td>
					</tr>
					</table>
				  </div>
				</BODY>
				</HTML>
		";
	}


	function happy_emoji_remove($str)
	{
		/*
		$patterns		= Array(
								'/[\x{1F600}-\x{1F64F}]/u',
								'/[\x{1F300}-\x{1F5FF}]/u',
								'/[\x{1F680}-\x{1F6FF}]/u',
								'/[\x{2600}-\x{26FF}]/u',
								'/[\x{2700}-\x{27BF}]/u',
		);*/

		$patterns		= Array(
								'/[\xF0-\xF7].../s',
		);

		foreach ( $patterns AS $pattern )
		{
			$str			= preg_replace_callback($pattern, "happy_emoji_encode", $str);
		}

		return $str;
	}

	function happy_emoji_encode($str)
	{
		return "-emo". addslashes(json_encode($str)) ."ji-";
	}

?>