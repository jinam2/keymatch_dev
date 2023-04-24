<?
	$happy_hack_check_log	= 'happy_hack_check_log';
	$happy_hack_block_list	= 'happy_hack_block_list';

	$hack_check_block_use	= false;				// 블럭기능 사용 여부 : 해당 설정이 false 라면 다른 설정을 무시하게 됨 : true or false
	$hack_check_block_del	= 60*60*24*365;		// 블럭된 리스트를 지우는 기간 설정
	$hack_check_chk			= '';


	function hack_check_log($HackOption)
	{
		global $happy_hack_check_log, $happy_hack_block_list, $hack_check_chk, $hack_check_block_use, $hack_check_block_del;

		if ( $HackOption['use'] !== true )
		{
			return false;
		}

		if ( $hack_check_chk != '' )
		{
			return false;
		}
		$hack_check_chk			= '1';

		$now_time				= date("Y-m-d H:i:s");
		$log_ip					= $_SERVER['REMOTE_ADDR'];
		$log_url				= addslashes($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
		ob_start();
		print_r($_POST);
		$log_post_val			= ob_get_contents();
		ob_end_clean();

		$Sql					= "
									INSERT INTO
											$happy_hack_check_log
									SET
											log_type		= '$HackOption[log_type]',
											log_ip			= '$log_ip',
											log_memo		= '$HackOption[log_memo]',
											log_url			= '$log_url',
											log_post_val	= '$log_post_val',
											log_time		= '$now_time',
											block_check		= 0
		";
		query($Sql);


		$del_time				= date("Y-m-d H:i:s", happy_mktime() - $HackOption['log_del_time']);
		$Sql					= "
									DELETE FROM
											$happy_hack_check_log
									WHERE
											log_type		= '$HackOption[log_type]'
											AND
											log_time		< '$del_time'
		";
		query($Sql);

		if ( $hack_check_block_use === true && $HackOption['block_use'] === true && sizeof($HackOption['block_check']) > 0 && $HackOption['block_time'] > 0 )
		{
			foreach ( $HackOption['block_check'] AS $Value )
			{
				$Values					= explode('/', $Value );
				$CheckTime				= preg_replace("/\D/", "", $Values[0]);
				$CheckCount				= preg_replace("/\D/", "", $Values[1]);

				$CheckTime				= date("Y-m-d H:i:s", happy_mktime() - $CheckTime);


				$Sql					= "
											SELECT
													Count(*) AS Cnt
											FROM
													$happy_hack_check_log
											WHERE
													log_type		= '$HackOption[log_type]'
													AND
													log_ip			= '$log_ip'
													AND
													log_time		> '$CheckTime'
				";
				$Data					= happy_mysql_fetch_assoc(query($Sql));

				if ( $Data['Cnt'] >= $CheckCount )
				{
					$block_end				= date("Y-m-d H:i:s", happy_mktime()+$HackOption['block_time']);
					$Sql					= "
												INSERT INTO
														$happy_hack_block_list
												SET
														block_type		= 'auto',
														block_ip		= '$log_ip',
														block_time		= '$now_time',
														block_end		= '$block_end'
					";
					query($Sql);

					$del_time				= date("Y-m-d H:i:s", happy_mktime() - $hack_check_block_del);
					$Sql					= "
												DELETE FROM
														$happy_hack_block_list
												WHERE
														block_time		< '$del_time'
					";
					query($Sql);
					hack_block_check();
					break;
				}
			}
		}
	}


	function hack_block_check()
	{
		global $happy_hack_block_list, $hack_check_block_use;

		if ( $hack_check_block_use !== true )
		{
			return false;
		}

		$block_ip				= $_SERVER['REMOTE_ADDR'];
		$now_time				= date("Y-m-d H:i:s");

		$Sql					= "
									SELECT
											Count(*) AS Cnt
									FROM
											$happy_hack_block_list
									WHERE
											block_ip = '$block_ip'
											AND
											block_end > '$now_time'
		";
		$Data					= happy_mysql_fetch_assoc(query($Sql));


		if ( $Data['Cnt'] > 0 )
		{
			HAPPY_SECURE_ERROR('저희 사이트에 접근 하실수가 없습니다.');
			exit;
		}
	}


	$Template_Config		= Array(
								// 윈도우 서버 사용시 설정 //
								'WindowServer'		=> Array(
															'use'				=> false,					// 윈도우계열 서버 사용시 true
															'drive'				=> 'D'						// 윈도우 서버 사용시 웹Root 하드 드라이브 명 (D:\ => D)
								),

								// 템플릿 기본 설정 //
								'Config'			=> Array(
															'root'				=> '.',						// Template Root 경로 -> .
															'tplRoot'			=> './tpl',				// Template 변환된 파일 저장 위치
															'webRoot'			=> '',						// Template WebRoot => 빈값
															'makeWebRoot'		=> '.',						// Template_make.php 파일의 webroot 변수
															'debug'				=> false,					// 디버그모드 true or false
															'compile'			=> daynmic,					// always, daynmic(true or anything), simple, false
															'folderMark'		=> "/",						// 윈도우 일때는 \\, 리눅스는 /
								),

								// 핵 파일 체크를 위한 document_root => 하부폴더 솔루션 설치등의 필요한 경우에는 변수로 대체 ($path등) //
								'DocumentRoot'		=> $_SERVER['DOCUMENT_ROOT'],

								// Define 악용한 공격시도 막기 //
								'HtmlPattern'		=> "/[a-zA-Z0-9\/\_\-]/",								// 파일명에 허용할 문자
								'HtmlPattern_use'	=> Array('A' => true, 'B' => true, 'C' => true ),		// A타입은 HtmlPattern 체크, B타입은 절대경로 체크, C타입은 HtmlFolder 체크 여부 true or false
								'HtmlFolder'		=> Array('temp', 'html', 'html_file', 'html_bbs', 'minihome', 'mobile', 'mobile_html'),
								'Msg'				=> Array(												// 오류 메시지 A1,A2는 A타입에 걸리는 경우 B,C는 B와 C 각각 걸렸을 경우
															'FileNotFound_A1'	=> 'define : Template File Not Found (Code:A001)',
															'FileNotFound_A2'	=> 'define : Template File Not Found (Code:A002)',
															'FileNotFound_B'	=> 'define : Template File Not Found (Code:B001)',
															'FileNotFound_C'	=> 'define : Template File Not Found (Code:C001)'
								),

								// Define 되는 파일내 비허용 단어 설정 //
								'SourceCheck'		=> Array(
															'use'				=> false,					// 소스내 비허용 단어 체크 여부
															'log_use'			=> false,					// 비허용 단어가 왔을 경우 핵체크 로그 적용 여부
															'log_type'			=> 'DefineAttackSource',	// 비허용 단어 핵체크 로그 적용시 구분 타입 (나머지 설정은 아래의 hackCheckLog 따라감)
															'filter'			=> Array(					// 필터단어 => 변환단어
																						'<?'			=> '',
																						//'<'				=> '&lt;',
																						//"\n"			=> '<br>',
																						//"\t"			=> '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;',
																						//" "				=> '&nbsp;',
															)
								),

								// Define 되는 파일 확장자 체크 설정 //
								'FileExtCheck'		=> Array(
															'use'				=> true,					// 파일 확장자 체크 여부
															'log_use'			=> true,					// 비허용 확장자가 왔을 경우 핵체크 로그 적용 여부
															'log_type'			=> 'FileExtError',			// 파일 확장자 체크 적용시 구분 타입 (나머지 설정은 아래의 hackCheckLog 따라감)
															'file_ext'			=> Array('html', 'htm')		// 허용할 파일 확장자
								),

								// 핵체크 됐을때 로그 //
								'HackCheckLog'		=> Array(
															'use'				=> true,					// 해킹 시도시 로그 저장 여부
															'block_use'			=> true,					// 블럭기능 사용 여부
															'block_check'		=> Array(					// 해킹 시도 내역을 기본으로 블럭되는 기준 설정 (초/횟수)
																						'30초/3회',
																						'100초/10회',
																						'600초/60회'
															),
															'log_type'			=> 'DefineAttack',
															'block_time'		=> 3600,				// IP 블럭 기간 60*60*24*3
															'log_del_time'		=> 60*60*24*90				// 로그 내역 지우는 기간
								),

								// 추출태그 파싱할때 <?= 함수명으로 만들지 <? 로 만들지 설정 //
								'ParsePHPMake'		=> ""
	);


	####################################################################################################
	# 관리자 로그인 상태에서 템플릿 태그 보기 설정 ON 한 경우
	# 해당 기능의 추가시 기존 템플릿 생성 폴더안에 "tag_view" 폴더를 만들고 707 권한 걸어두어야 함.
	# admin 폴더내의 템플릿 생성 폴더에도 생성 해야 됨.
	####################################################################################################

	# 체크용 변수
	$template_tag_view		= '';
	# 템플릿 태그 노출 하지 않을 태그 지정 (array)
	$template_tag_no_view	= Array(
									'이미지',
									'게시판링크',
									'즐겨찾기링크',
									'날씨출력',
									'콤마',
									'글자자르기',
									'지도출력',
									'위지윅에디터CSS',
									'위지윅에디터JS',
									'위지윅에디터',
									'일정관리달력출력',

	);

	$template_tag_view		= '';
	if ( ($_COOKIE['ad_id'] == $admin_id || $_SERVER['REMOTE_ADDR'] == "115.93.87.162") && $template_tag_view_option != '0' )
	{
		$template_tag_view		= $template_tag_view_option;
		$Template_Config['Config']['tplRoot']	.= '/tag_view';
		$Template_Config['Config']['compile']	= 'always';
	}


	if ( $demo_lock != '' )
	{
		$happy_hack_check_log	= 'solution_hack_check.happy_hack_check_log';
		$happy_hack_block_list	= 'solution_hack_check.happy_hack_block_list';
		$hack_check_block_use	= false;
	}


	if ($happy_admin_ipCheck)
	{
		foreach ($happy_admin_ip as $list)
		{
			/*
			$list_array	= explode(".",$list);
			$ip_array	= explode(".",$_SERVER['REMOTE_ADDR']);
			$max	= count($list_array);
			if ($max < 4)
			{
				$max	= count($list_array)-1;
			}
			for ($i=0; $i < $max; $i++)
			{
				$ip_ch	.= $ip_array[$i];
				if ($i < 3)
				{
					$ip_ch	.= ".";
				}
			}
			if ($list == $ip_ch )
			{
				$master_ch = '1';
				break;
			}
			*/

			if ($list == $_SERVER['REMOTE_ADDR'] )
			{
				$master_ch = '1';
				break;
			}
		}
	}

	if ($master_ch != "1")
	{
		hack_block_check();
	}
?>