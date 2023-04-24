<?PHP
	header("Content-type: text/html; charset=utf-8");
	# 업로드 허용을 할 파일 리스트 설정
	$HAPPY_ALLOW_FILE_USE	= 'on';			# on 또는 off
											# on 으로 설정을 하는 경우 설정된 확장자 이외 업로드 불가능
	$HAPPY_ALLOW_FILE_EXT	= Array(
									'jpg',		'jpeg',		'gif',		'png',		'zip',
									'doc',		'docx',		'hwp',		'rar',		'ajr',
									'bmp',		'xls',		'xlsx',		'csv',		'psd',
									'ppt',		'pptx',		'avi',		'mov',		'swf',
									'flv',		'wmv',		'asf',		'mkv',		'pdf',
									'egg',		'mp3',		'mp4',		'asx',		'iso',
	);



	# 업로드 허용을 거부 할 파일 리스트 설정
	$HAPPY_DENY_FILE_USE	= 'on';			# on 또는 off
	$HAPPY_DENY_FILE_EXT	= Array(
									'php',		'php2',		'php3',		'php4',		'php5',
									'phtml',	'pwml',		'inc',		'asp',		'aspx',
									'ascx',		'jsp',		'cfm',		'cfc',		'pl',
									'bat',		'exe',		'com',		'dll',		'vbs',
									'js',		'reg',		'cgi',		'html',		'htm',
									'shtml',
	);


	# 타 사이트에서 넘어온 FILE전송은 거부
	if ($HAPPY_REFERER_CHECK_DEFAULT != '') # on 또는 off (on일경우 타 사이트에서 전송 불가능)
	{
		$HAPPY_REFERER_CHECK = $HAPPY_REFERER_CHECK_DEFAULT;
	}
	else
	{
		$HAPPY_REFERER_CHECK	= 'on';
	}



	# POST 에서 차단할 html 태그 설정
	$HAPPY_DENY_POST_USE			= 'on';			# on 또는 off
													# on 으로 설정을 하는 경우 설정된 태그를 입력시 오류
	$HAPPY_DENY_POST_TAG			= Array(
									'meta',		'location'
	);



	# GET 에서 차단할 단어 설정
	$HAPPY_DENY_GET_USE				= 'on';			# on 또는 off
													# on 으로 설정을 하는 경우 설정된 태그를 입력시 오류
	$HAPPY_DENY_GET_LOG_OPTION		= Array(
											'use'				=> true,					// 해킹 시도시 로그 저장 여부
											'block_use'			=> true,					// 블럭기능 사용 여부
											'block_check'		=> Array(					// 해킹 시도 내역을 기본으로 블럭되는 기준 설정 (초/횟수)
																		'30초/3회',
																		'100초/10회',
																		'600초/60회'
											),
											'log_type'			=> 'Injection',
											'block_time'		=> 3600,				// IP 블럭 기간 60*60*24*3
											'log_del_time'		=> 60*60*24*90				// 로그 내역 지우는 기간
	);
	$HAPPY_DENY_GET_TAG_TYPE		= 'multi';			# 필터 체크 할 때 다중언어 선언이 된 경우 다중언어가 다 걸려야 deny할지 다중언어 중에 하나만 있어도 deny할지를 선택 (single or multi)
	$HAPPY_DENY_GET_TAG_ALERT		= false;				# 필터에 걸린 단어를 알려줄것인지 여부 ( true or false )
	$HAPPY_DENY_GET_TAG				= Array(			# +로 조합이 가능 => union+select 로 입력시 하나의 GET값에 union단어와 select 가 둘다 포함된경우 DENY
											'union+select',
											'information_schema+select',
											'information_schema+concat(',
											'information_schema+tables',
											'select+from+concat(',
											'select+from+columns',
											'select+from+schema_name',
											'select+from+column_name',
											'select+from+table_name',
											'select+from+group+by',
											'schema_name+columns',
											'column_name+schema_name',
	);

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
				msg('타 사이트에서 업로드는 할 수 없습니다.');
				exit;
			}

		}
	}
?>