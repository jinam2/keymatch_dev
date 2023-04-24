<?php

	include "config_option.php";

	//내부 개발용, 솔루션 데모
	if
	(
		( $_SERVER['SERVER_ADDR'] == "192.168.10.90" && strpos($_SERVER['HTTP_HOST'],base64_decode("YWFhLmNvbQ==")) !== false )
		|| $_SERVER['SERVER_ADDR'] == "211.233.5.218"
	){

		$demoOnlyPath				= "";
		//echo var_dump(getenv("document_root"));
		if ( getenv("document_root") != "" )
		{
			$demoOnlyPath			= preg_replace("/\/www$/","",getenv("document_root"));
		}

		include "{$demoOnlyPath}/demo_only.php";
	}
	//내부 개발용, 솔루션 데모


	function happy_mktime($hour='',$min='',$sec='',$mon='',$day='',$year='')
	{
		if ( $hour == '' && $min == '' && $sec == '' && $mon == '' && $day == '' && $year == '' )
		{
			return time();
		}
		else
		{
			return happy_mktime_32bit($hour,$min,$sec,$mon,$day,$year);
		}

		/*
		$Array					= Array(
										'H'		=> 'hour',
										'i'		=> 'min',
										's'		=> 'sec',
										'm'		=> 'mon',
										'd'		=> 'day',
										'Y'		=> 'year'
		);

		foreach ( $Array AS $k => $n )
		{
			//${$n}					= preg_replace("/\D/", "", ${$n});
			${$n}					= intval(${$n}); // 마이너스가 들어올 수도 있다
			if ( ${$n} == '' )
			{
				${$n}					= 0;
				#${$n}					= date($k);
			}
		}

		return mktime($hour,$min,$sec,$mon,$day,$year);
		*/
	}


	function happy_mysql_list_tables($get_db_name)
	{
		global $db_name;

		if ( $get_db_name != $db_name )
		{
			return '';
		}

		return query("show tables");
	}




	# 4000년도 테스트 결과 64bit mktime 값과 동일함.
	function happy_mktime_32bit($hour='',$min='',$sec='',$mon='',$day='',$year='')
	{
		# 각 월별로 날짜수가 다르니..
		$endday				= array( 31, 28, 31, 30 , 31, 30, 31, 31, 30 ,31 ,30, 31 );

		# 윤년 체크
		# https://terms.naver.com/entry.nhn?docId=1133190&cid=40942&categoryId=32295
		if( ($year%4 == 0 && $year%100 != 0) || $year%400 == 0 )
		{
			$endday[1]			= 29;
		}
		else
		{
			$endday[1]			= 28;
		}


		# 1970년 이후 윤년 횟수 체크 (넘어온 년도 제외)
		$add_day_count		= 0;
		for ( $i=1970 ; $i<$year ; $i++ )
		{
			if( ($i%4 == 0 && $i%100 != 0) || $i%400 == 0 )
			{
				$add_day_count++;
			}
		}

		# 윤년수만큼 일수에 해당하는 초를 더해주기.
		$add_time			= $add_day_count * 60*60*24;



		$t_year				= ($year-1970) * 60*60*24*365;
		$t_month			= 0;

		# 월이 양수일때
		if ( $mon > 0 )
		{
			for ( $i=0 ; $i<$mon-1 ; $i++ )
			{
				$ii					= $i % 12;
				$yun_check			= floor($i/12);
				$year_tmp			= $year + $yun_check;
				if( ($year_tmp%4 == 0 && $year_tmp%100 != 0) || $year_tmp%400 == 0 )
				{
					$endday[1]			= 29;
				}
				else
				{
					$endday[1]			= 28;
				}
				$t_month			= $t_month + ( 60*60*24*$endday[$ii]);
			}
		}
		# 월이 음수일때
		else
		{
			$endday				= array_reverse($endday);
			$mon_t				= $mon * -1;
			for ( $i=0 ; $i<$mon_t+1 ; $i++ )
			{
				$ii					= $i % 12;
				$yun_check			= floor($i/12);
				$year_tmp			= $year - $yun_check -1;
				if( ($year_tmp%4 == 0 && $year_tmp%100 != 0) || $year_tmp%400 == 0 )
				{
					$endday[10]			= 29;
				}
				else
				{
					$endday[10]			= 28;
				}
				#echo $i.':::'.$year_tmp.'-'. $endday[10]. '<br>';

				$t_month			= $t_month + ( 60*60*24*$endday[$ii]);
			}

			$t_month			= $t_month * -1;
		}


		# day는 시작점에서 하루 빼줘야됨. 1일 00시00분01초는 => 1초 지난거니깐. 2일00일00분01초는 1일+1초 지난거니깐.
		$t_day				= ($day-1) * 60*60*24;

		$t_hour				= $hour * 60*60;
		$t_min				= $min * 60;
		$t_sec				= $sec;



		# MKTIME() 함수 시작값을 기준으로. 1970-01-01 00:00:00 => -32400 (GMT9 때문에 마이너스임)
		$time_stamp			= -32400 + $t_year + $t_month + $t_day + $t_hour + $t_min + $t_sec + $add_time;

		return $time_stamp;


	}


	# 테스트용 소스
	/*
	for ( $i=0 ; $i<100; $i++ )
	{
		$year			= rand(2000,2499);
		$month			= rand(-30,12);
		$day			= rand(-50,28);

		$hour			= rand(-50,23);
		$min			= rand(-50,59);
		$sec			= rand(-50,59);

		$datetime		= "$year-$month-$day $hour:$min:$sec";
		$time1			= mktime($hour,$min,$sec,$month,$day,$year);
		$time2			= happy_mktime($hour,$min,$sec,$month,$day,$year);


		echo "$datetime => $time1 , $time2";
		if ( $time1 != $time2 )
		{
			echo " <font color=red>다른값임</font><br>";
		}
		else
		{
			echo " 같음<br>";
		}
	}
	exit;
	*/



	# happy_msql_*() 함수에서 나타나는 에러를 숨기고 싶다면 1을 없애면 됩니다.
	$happy_mysql_error_print	= '1';

	function happy_mysql_fetch_array($Resource)
	{
		# 로딩속도 개선을 위해 mysql_fetch_assoc 로 값을 받아내고 이후 happy_mysql_data_check() 함수에서 배열을 맞춰줌 3분의1 ~ 5분의2 정도 빨라짐
		$error				= '';
		$Data				= @mysql_fetch_assoc($Resource) or $error = mysql_error();

		if ( $error != '' )
		{
			happy_debug_backtrace(1);
		}
		else
		{
			$Data				= happy_mysql_data_check($Data, 'array');
			return $Data;
		}
	}


	function happy_mysql_fetch_assoc($Resource)
	{
		$error				= '';
		$Data				= @mysql_fetch_assoc($Resource) or $error = mysql_error();

		if ( $error != '' )
		{
			happy_debug_backtrace(1);
		}
		else
		{
			$Data				= happy_mysql_data_check($Data);
			return $Data;
		}
	}


	# 시작값, 종료값
	# happy_debug_backtrace(1); 호출시에는 일반 PHP오류문처럼 보여짐
	# happy_debug_backtrace(1,5); 해당 오류가 오기까지의 과정을 보여줌 (1,2,3,4,5 -> 5단계까지 추적하는 의미)
	function happy_debug_backtrace($start_num, $end_num='')
	{
		global $happy_mysql_error_print;

		$start_num			= preg_replace("/\D/", "", $start_num);
		$end_num			= preg_replace("/\D/", "", $end_num);

		if ( $happy_mysql_error_print != '1' || $start_num == '' || $start_num == 0 )
		{
			return;
		}

		ob_start();
		debug_print_backtrace();
		$trace				= ob_get_contents();
		ob_end_clean();

		if ( $end_num == '' )
		{
			$end_num			= $start_num;
		}

		if ( $start_num > $end_num )
		{
			return;
		}

		for ( $j=1, $i=$end_num ; $i>=$start_num ; $i-- )
		{
			preg_match("/#".$i." (.*)\((.*)\) called at \[(.*):(\d+)\]/iU", $trace, $Matches);
			if ( $Matches[1] != '' && $Matches[2] != '' && $Matches[3] != '' && $Matches[4] != '' )
			{
				$print_number			= '';
				if ( $start_num != $end_num )
				{
					$print_number			= "<font color=red>호출위치 경로 추적 : ${j}번째 호출</font><br>";
					$j++;
				}
				echo "$print_number<b>Warning</b>: $Matches[1](): supplied argument is not a valid MySQL result resource in <b>$Matches[3]</b> on line <b>$Matches[4]</b><br>";

				//에러 로그 저장
				if ( function_exists('HAPPY_ERROR_LOG_WRITE') )
				{
					$errno		= 2;
					$errstr		= "$Matches[1](): supplied argument is not a valid MySQL result resource";
					$errfile	= $Matches[3];
					$errline	= $Matches[4];

					HAPPY_ERROR_LOG_WRITE($errno, $errstr, $errfile, $errline);
				}
			}
		}

	}




	# 스크립트 URL 검증 기능 사용 여부 (true or false)
	$script_url_check	= true;

	# 스크립트 URL 호출 허용할 URL 설정 (/<script(.*)>/iUs 으로 매칭)
	$script_access_url	= Array(
								#"/src=\"http:\/\/hopememory.co.kr(.*)\"/iU",
								"/src=\"http:\/\/pagead2.googlesyndication.com(.*)\"/iU",
								"/src='h*t*t*p*:*\/\/openapi.map.naver.com\/(.*)/",
								"/src=\"http:\/\/wcs.naver.net\/(.*)\"/iU",
								"/src='\/\/dapi.kakao.com\/(.*)/",
								"/src=\"https:\/\/www\.googletagmanager\.com\/gtag\/js\?id=(.*)\"/",
	);

	# 스크립트 코드 검증 기능 사용 여부 (true or false)
	$script_code_check	= true;

	# 스크립트 허용할 코드 설정 세미콜론 기준으로 체크가 됨 (/<script(.*)>(.*)<\/script>/iUs 으로 매칭)
	$script_access_code	= Array(
								# 주석문 //주석 형태만
								"/^\/\/(.*)$/",

								# 구글 analytics 관련 소스
								"/var gaJsHost =/iU",
								"/write\(unescape\(\"%3Cscript src=\'\" \+ gaJsHost \+ \"google-analytics.com\/(.{4,10})\' type='text\/javascript'%3E%3C\/script%3E\"\)\)/iU",
								"/pageTracker \= \_gat.\_getTracker\(\"(.*)\"\)/iU",
								"/pageTracker._trackPageview\(\)/iU",
								"/\} catch\(err\) \{\}/iU",

								"/var _gaq = _gaq/iU",
								"/_gaq\.push\(\[(.*)\]\)/iU",
								"/var ga = document.createElement\('script'\)/",
								"/ga.(.{4,5}) = (.*)/",
								"/ga.src = (.*) \+ '.google-analytics.com\/ga.js/",
								"/var s = document.getElementsByTagName\('script'\)\[0\]/",
								"/s.parentNode.insertBefore\(ga, s\)/",

								"/window\.dataLayer = window\.dataLayer || \[\]/iU",
								"/function gtag\(\){dataLayer.push\(arguments\)/iU",
								"/gtag\(\'js\', new Date\(\)\)/iU",
								"/gtag\(\'config\', \'(.*)\'\)/iU",

								# 구글 애드센스 관련
								"/google_ad_(.{3,6}) = \"(.*)\"/iU",
								"/google_ad_(.{3,6}) = \d/iU",

								"/window.googleAfmcRequest = \{(.*)\}/iU",

								# 위지윅으로 첨부하는 네이버지도 관련 소스
								"/function map_insert_\d+\(\)\{/U",
								"/document.getElementById\('mapContainer_\d+'\)/U",
								"/naverMapObj20\d+.(.*)\(/U",
								"/markerOptions20\d+\t+= \{(.*)\}/U",
								"/naverMarkObj20\d+\t+=/U",
								"/naverMarkObj20\d+.(.*)\(/U",
								"/naver.maps.Event.addListener\(/U",
								"/var markMouse(.{3,4})Event(.*)=/U",
								"/zoomLevel(\t+|)= \((.*)\)\?(.*):/U",
								"/naverMsgObj20\d+\t+=/U",
								"/^(\}*)(\s*)\}setTimeout\(\'map_insert_\d+\(\)\',\d+\)$/",

								# 네이버 체크아웃 (커머스계열 제외 솔루션들은 해당 기능이 없으므로 없어도 됨)
								"/if\(!wcs_add\) var wcs_add = \{\}/",
								"/wcs_add\[\"wa\"\] = \"(.*)\"/",
								"/wcs_do\(\)/",
								"/wcs.checkoutWhitelist = \[(.*)\]/",
								"/wcs.wcs.inflow\((.*)\)/",

								# 위지윅으로 첨부하는 다음지도 관련 소스
								"/mapObj20\d+\t+=/U",
								"/mapObj20\d+.(.*)/U",
								"/latlng20\d+.(.*)\(/U",
								"/daumMapObj20\d+.(.*)\(/U",
								"/daumMarkObj20\d+\t+=/U",
								"/daumMarkObj20\d+.(.*)\(/U",
								"/daumMarkLatlng20\d/U",
								"/daumMarkImg20\d/U",
								"/daumMsgObj20\d+\t+=/U",
								"/daum.maps.event.addListener\(/U",
								"/daum.maps.ZoomControl\(\)/U",


	);

	$total_check_time	= 0;
	function happy_mysql_data_check($Data, $array_type='')
	{
		global $script_url_check, $script_code_check, $script_access_url, $script_access_code, $total_check_time, $HAPPY_EMOJI_USE;

		$t_start			= array_sum(explode(' ', microtime()));

		# 데이타 배열이 없다면
		if ( is_array($Data) === false )
		{
			$exec_time			= array_sum(explode(' ', microtime())) - $t_start;
			$exec_time			= round ($exec_time, 7);
			$total_check_time	= $total_check_time + $exec_time;

			if ( $HAPPY_EMOJI_USE == 'on' )
			{
				$Data				= happy_emoji_add($Data);
			}

			return $Data;
		}



		$DataOut			= Array();
		$Array_no			= 0;
		foreach ( $Data AS $k => $v )
		{
			if ( $HAPPY_EMOJI_USE == 'on' )
			{
				$v					= happy_emoji_add($v);
			}

			# 10글자 미만의 데이타 또는 체크를 하지 않는 경우에는 패스 (속도개선)
			if ( strlen($v) < 10 || ( $script_url_check == false && $script_code_check == false ) )
			{
				$DataOut[$k]		= $v;

				# mysql_fetch_array 일 경우 0,1,2,3 값 채워주기
				if ( $array_type == 'array' )
				{
					$DataOut[$Array_no]	= $v;
					$Array_no++;
				}
				continue;
			}


			$test_text			= '';
			# 대소문자 구분없이 script 태그 확인
			if ( stripos($v, '<script') !== false )
			{

				if ( $script_url_check === true )
				{
					###### SRC 링크 걸린 Javascript부터 검증 시작 ######
					preg_match_all("/<script(.*)>/iUs", $v, $Matches);

					# 테스트용 출력 #
					if ( 0 )
					{
						$Matches_tmp		= $Matches;
						ob_start();
						foreach ( $Matches_tmp as $kk => $vv )
						{
								foreach ( $vv AS $kkk => $vvv )
								{
									$Matches_tmp[$kk][$kkk]	= str_replace("<", "&lt;",$vvv);
								}

						}
						echo "<pre>"; print_r($Matches_tmp); echo "</pre>======================================<br>";
						$test_text			= ob_get_contents();
						ob_end_clean();
					}
					# 테스트용 출력 #


					foreach ( $Matches[0] AS $sc )
					{
						if ( preg_match("/src/i", $sc, $SrcCheckMatch) )
						{
							$code_check			= false;
							foreach ( $script_access_url AS $access_url )
							{
								#echo "<pre>"; print_r($nMatch); echo "</pre>";
								if ( preg_match($access_url, $sc, $nMatch) )
								{
									$code_check			= true;
									break;
								}
							}

							if ( $code_check === false )
							{
								#$v					= str_replace($sc, str_replace("<", "<h1>A</h1>&lt;", $sc), $v);	# 어디서 치환 되었는지 궁금할때 사용하는 소스
								$v					= str_replace($sc, str_replace("<", "&lt;", $sc), $v);
							}
						}
					}
					###### SRC 링크 걸린 Javascript부터 검증 종료 ######
				}






				if ( $script_code_check == true )
				{
					###### SRC 링크 없는 Javascript 검증 시작 ######
					preg_match_all("/<script(.*)>(.*)<\/script>/iUs", $v, $Matches);

					# 테스트용 출력 #
					if ( 0 )
					{
						$Matches_tmp		= $Matches;
						ob_start();
						foreach ( $Matches_tmp as $kk => $vv )
						{
								foreach ( $vv AS $kkk => $vvv )
								{
									$Matches_tmp[$kk][$kkk]	= str_replace("<", "&lt;",$vvv);
								}

						}
						echo "<pre>"; print_r($Matches_tmp); echo "</pre>======================================<br>";
						$test_text			.= ob_get_contents();
						ob_end_clean();
					}
					# 테스트용 출력 #


					foreach ( $Matches[2] AS $sc_key => $sc )
					{
						# 스크립트 내의 HTML 소스중에 style소스는 제거
						$sc_tmp				= preg_replace("/style=\"(.*)\"/", "", $sc);
						#$sc_tmp				= preg_replace("/\/\/(.*)/", "---<주석시작>---$1---<주석종료---;", $sc_tmp);
						# 검증전에 세미콜론 기준으로 명령어 분리
						$sc_list			= explode(";", str_replace("\n", "", str_replace("\r", "", str_replace("<!==", "", $sc_tmp))));

						if ( 0 )
						{
							ob_start();
							echo "<pre>"; print_r($sc_list); echo "</pre>===ㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇㅇ==<br>";
							$test_text			.= ob_get_contents();
							ob_end_clean();
						}

						$code_check			= true;
						foreach ( $sc_list AS $now_sc )
						{
							# 6글자 이하 코드는 검증 패스
							if ( strlen(str_replace(" ", "", str_replace("\t", "", $now_sc))) < 6 )
							{
								continue;
							}


							# 허용 스크립트에서 한개라도 포함이 되어 있는지 체크
							$code_check_sub		= false;
							foreach ( $script_access_code AS $access_code )
							{
								if ( preg_match($access_code, $now_sc, $nMatch) )
								{
									$code_check_sub		= true;
									break;
								}
							}

							# 허용된 스크립트가 아닐 경우.
							if ( $code_check_sub === false )
							{
								$code_check			= false;

								# 비허용된 코드 출력 테스트용
								if ( 0 )
								{
									$test_text			.= "\n<br><font color=red>비검출 : $now_sc</font><br>\n";
								}
								else
								{
									break;
								}
							}
						}




						$sc_org				= $sc;
						$sc					= $Matches[0][$sc_key];

						# 현재 스크립트가 문제가 있다면 < 를 &lt;로 변경
						if ( $code_check === false )
						{
							#$v					= str_replace($sc, str_replace("<", "<h1>B</h1>&lt;", $sc), $v);	# 어디서 치환 되었는지 궁금할때 사용하는 소스
							$v					= str_replace($sc, str_replace("<", "&lt;", $sc), $v);
						}

						# 현재 스크립트에 문제가 없다면 개행문자만 없애서 return
						else
						{
							# 개행문자 및 탭 소스 제거.
							$sc_change			= str_replace("\n", "", str_replace("\r", "", str_replace("\t", "", $sc)));

							# 소스내의 주석문은 개행문자를 다시 붙여준다. 단 //주석문 형태만 적용.
							if ( preg_match_all("/\/\/(.*)\n/", $sc_org, $sc_match) )
							{
								foreach ( $sc_match[1] AS $change_source )
								{
									$change_source		= str_replace("\n", "", $change_source);
									$change_source		= str_replace("\r", "", $change_source);
									$sc_change			= str_replace("//".$change_source, "//".$change_source."\n", $sc_change);
								}
							}

							# 본문에 적용
							$v					= str_replace($sc, $sc_change, $v);
						}



					}
					###### SRC 링크 없는 Javascript 검증 종료 ######
				}

				$v					= $test_text.$v;
			}

			$DataOut[$k]		= $v;

			# mysql_fetch_array 일 경우 0,1,2,3 값 채워주기
			if ( $array_type == 'array' )
			{
				$DataOut[$Array_no]	= $v;
				$Array_no++;
			}
		}

		$exec_time			= array_sum(explode(' ', microtime())) - $t_start;
		$exec_time			= round ($exec_time, 7);
		$total_check_time	= $total_check_time + $exec_time;

		return $DataOut;
	}


	# find ./ -name "*.php" | xargs tar cvzf php_backup.tar.gz
	# /usr/local/php/bin/php ./mysql_fetch_change.php /hard/hosting/contents/www/


	/*
	2019-08-16 hun 만듬.
	임시폴더 정리용 함수이며 폴더의 ctime 읽고 하루 이상 지난 파일는 정리하도록
	설정된 폴더의 하부에 있는 모든것들을 정리하므로 폴더 설정에 주의가 필요함.

	해당 함수의 1가지 문제점이 있다.
	unlink 하게 되는 경우 파일을 삭제하게 되므로 폴더의 ctime 이 현재시간으로 갱신된다.
	그래서 파일이 삭제된 후 폴더가 사라지지 않는다.
	하지만 다음에 재 가동되는 경우 정상적으로 삭제되니 문제될것은 없다고 판단하여 여기까지만 작업함.
	*/
	function happy_tmp_clear( $happy_dir, $clear_limit_time, $clear_files_ext='' )
	{
		global $E​xception_Array;

		if(!is_dir($happy_dir) || $happy_dir == '' )
		{
			return print "happy_tmp_clear() 를 실행하기 위한 폴더 설정이 잘못되었습니다.";
		}

		if( $clear_limit_time == '' )
		{
			return print "삭제하기 위한 기준시간을 설정하세요.";
		}

		if( sizeof($clear_files_ext) == 0 )
		{
			return print "삭제할 파일의 확장자를 설정하세요.";
		}

		$clear_files_preg_ext		= implode("|",$clear_files_ext);
		#print_r($clear_files_ext); exit;

		if( $handle = opendir( $happy_dir ) )
		{
			/* This is the correct way to loop over the directory. */
			while( false !== ( $entry = readdir( $handle ) ) )
			{
				if( $entry == "." || $entry == ".." || $entry == '.htaccess' )
				{
					continue;
				}

				if( is_dir( $happy_dir.$entry ) )
				{
					$now_dir				= $happy_dir.$entry."/";
					happy_tmp_clear( $now_dir, $clear_limit_time, $clear_files_ext);

					if( !in_array( $entry, $E​xception_Array ) )			//예외처리에 설정된 폴더명이 아닐 경우에만 삭제해라.
					{
						$ctime_gap				= time() - filectime($happy_dir.$entry);
						if( $ctime_gap > $clear_limit_time )
						{
							#echo " $ctime_gap 차이 나므로 $happy_dir$entry 는 삭제해야 한다. @rmdir($happy_dir$entry);<br>";
							@rmdir($happy_dir.$entry);
						}
					}
				}
				else			//파일이므로 unlink 해야 한다.
				{
					$ctime_gap				= time() - filectime($happy_dir.$entry);
					if( $ctime_gap > $clear_limit_time )
					{
						$tmp					= explode(".",$entry);
						$ext					= strtolower($tmp[sizeof($tmp)-1]);

						if( preg_match("/($clear_files_preg_ext)/i", $ext) )
						{
							#echo " $ctime_gap 차이 나므로 $happy_dir$entry 는 삭제해야 한다. @unlink($happy_dir$entry);<br>";
							@unlink($happy_dir.$entry);
						}
					}
				}
			}
			closedir($handle);
		}
	}

	function happy_emoji_add($str)
	{

		#$pattern		= '/-emo\[\"\\\u[a-zA-Z0-9]{4,6}\"\]ji-/';
		#$str			= preg_replace_callback($pattern, "emoji_decode", $str);

		$pattern		= '/-emo\[\"\\\u[a-zA-Z0-9\\\]{4,12}\"\]ji-/';
		$str			= preg_replace_callback($pattern, "happy_emoji_decode", $str);
		return $str;
	}

	function happy_emoji_decode($str)
	{

		#print json_decode('"\u2600"');

		$str			= str_replace("-emo[", "", $str[0]);
		$str			= str_replace("]ji-", "", $str);
		#print_r($str);
		return json_decode($str);
	}

	function happy_microtime($is_true)
	{
		if($is_true !== false)
		{
			return str_replace(".","",microtime(true));
		}
		else
		{
			return microtime();
		}
	}
?>