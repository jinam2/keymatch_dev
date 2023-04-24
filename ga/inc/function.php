<?php

/*
CREATE TABLE `happy_analytics_list` (
  `number` int(11) NOT NULL auto_increment,
  `profileId` int(11) NOT NULL,
  `sdate` date NOT NULL default '0000-00-00',
  `edate` date NOT NULL default '0000-00-00',
  `getVisitors` mediumtext NOT NULL,
  `getPageviews` mediumtext NOT NULL,
  `getVisitsPerHour` mediumtext NOT NULL,
  `getBrowsers` mediumtext NOT NULL,
  `getReferrers` mediumtext NOT NULL,
  `getSearchWords` mediumtext NOT NULL,
  `getScreenResolution` mediumtext NOT NULL,
  `getManyviews` mediumtext NOT NULL,
  `getOntime` mediumtext NOT NULL,
  `getOutpage` mediumtext NOT NULL,
  `regdate` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`number`),
  KEY `profileId` (`profileId`),
  KEY `sdate` (`sdate`),
  KEY `edate` (`edate`),
  KEY `regdate` (regdate),
  KEY (`profileId`, `sdate`, `edate`)
);
*/

#################################################################################################################################
#                                                         함수시작                                                              #
#################################################################################################################################

	// 구글 통계 정보 가져오기
	// https://developers.google.com/analytics/devguides/reporting/core/v3/reference
	function gaGetData($analytics,$dimensions='',$metrics,$sort='',$max_results=30)
	{
		global $profile_id,$start_date, $end_date;

		################################### 필수 파라미터 ###################################
		$parameters			= array(
									'ids'			=> 'ga:' . $profile_id,
									'start-date'	=> $start_date,
									'end-date'		=> $end_date,
							);

		//metrics 가공
		if( is_array($metrics) )
		{
			$metrics_tmp		= array();

			foreach($metrics as $metric)
			{
				array_push($metrics_tmp,'ga:'.$metric);
			}

			$parameters['metrics'] = implode(",",$metrics_tmp);
		}
		else
		{
			$parameters['metrics'] = 'ga:'.$metrics;
		}
		#####################################################################################


		################################### 옵션 파라미터 ###################################
		$parameters_option	= array();

		//dimensions 가공
		if ( $dimensions != "" )
		{
			if( is_array($dimensions) )
			{
				$dimensions_tmp		= array();

				foreach($dimensions as $dimension)
				{
					array_push($dimensions_tmp,'ga:'.$dimension);
				}

				$parameters_option['dimensions'] = implode(",",$dimensions_tmp);
			}
			else
			{
				$parameters_option['dimensions'] = 'ga:'.$dimensions;
			}
		}

		//sort 가공
		if( $sort == "" && isset($parameters['metrics']) )
		{
			$parameters_option['sort'] = $parameters['metrics'];
		}
		elseif( is_array($sort) )
		{
			$sort_tmp			= array();

			foreach($sort as $sort_val)
			{
				$sort_string		= "";

				if (substr($sort_val, 0, 1) == "-")
				{
					$sort_string		= ',-ga:' . substr($sort_val, 1);
				}
				else
				{
					$sort_string		= ',ga:' . $sort_val;
				}

				array_push($sort_tmp,$sort_string);
			}

			$parameters_option['sort'] = implode(",",$sort_tmp);
		}
		else
		{
			if (substr($sort, 0, 1) == "-")
			{
				$parameters_option['sort'] = '-ga:' . substr($sort, 1);
			}
			else
			{
				$parameters_option['sort'] = 'ga:' . $sort;
			}
		}

		//max-results 가공
		$parameters_option['max-results'] = $max_results;
		#####################################################################################

		//에러 체크
		$error_check		= gaErrorCheck($parameters,$parameters_option);

		if ( $error_check )
		{
			gaError($error_check);
			exit;
		}

		#####################################################################################

		//통계정보 받아오기
		//get($ids, $startDate, $endDate, $metrics, $optParams = array())
		$results			= $analytics->data_ga->get(
								$parameters['ids'],
								$parameters['start-date'],
								$parameters['end-date'],
								$parameters['metrics'],
								$parameters_option
							);

		//통계정보 내보내기
		$content			= "";

		if ( count($results->getRows()) > 0)
		{
			foreach ( $results->getRows() as $row )
			{
				foreach ( $row as $key => $data )
				{
					if ( $key == (count($row)-1) )
					{
						$content		.= "|".preg_replace('/\D/', '', $data);
					}
					else
					{
						if (preg_match("/(\d{4})(\d{2})(\d{2})/",$data,$matches))
						{
							$data			= $matches[1] . "-" . $matches[2] . "-" . $matches[3];
						}

						if ( $key > 0 )
						{
							$content		.= " ";
						}

						$content		.= $data;
					}
				}

				$content		.= "\n";
			}
		}

		$content			= preg_replace('/\n$/','',$content);

		if ( $content == "" )
		{
			$content			= "null";
		}

		return $content;
	}


	//오류 체크
	function gaErrorCheck($param=array(),$param_opt=array())
	{
		global $profile_id,$start_date,$end_date;

		$url			= "https://www.googleapis.com/analytics/v3/data/ga?";

		$and			= "";

		if ( count($param) > 0 )
		{
			foreach ( $param as $key => $val )
			{
				$url			.= $and.$key."=".urlencode($val);
				$and			= "&";
			}
		}
		else
		{
			$url			.= "ids=ga:{$profile_id}&start-date={$start_date}&end-date={$end_date}&metrics=ga%3Asessions";
		}

		if ( count($param_opt) > 0 )
		{
			foreach ( $param_opt as $key => $val )
			{
				$url			.= $and.$key."=".urlencode($val);
				$and			= "&";
			}
		}

		$accessToken	= json_decode($_SESSION['access_token']);

		$ch				= curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken->access_token));
		$response		= curl_exec($ch);
		curl_close($ch);

		$error_check	= json_decode($response);
		$error_code		= $error_check->error->code;
		$error_reason	= $error_check->error->errors[0]->reason;

		if (isset($error_code) && $error_code >= 300 ) //오류
		{
			return $error_code."|".$error_reason;
		}
		else //정상
		{
			return false;
		}
	}


	//오류코드별 안내문구 변경
	function gaError($error_check='',$go_url='')
	{
		global $profile_id;

		if ( $error_check == '' )
		{
			return;
		}

		list($code,$reason) = explode("|",$error_check);

		switch ( $reason )
		{
			case 'invalidCredentials' :
				$reason		= "인증 토큰이 잘못되었거나 만료되었습니다. \\n\\n다시 시도해주세요.";
			break;

			case 'insufficientPermissions' :
				$reason		= "프로필ID($profile_id)에 대한 권한이 없습니다.\\n\\n구글 계정과 프로필ID를 다시 확인해주세요.";
			break;

			case 'backendError' :
				$reason		= "구글 서버에 문제가 있습니다.\\n\\n잠시 후 다시 시도해주세요.";
			break;
		}

		$message	= "ERROR($code) : {$reason}";

		if ( $go_url != "" )
		{
			gomsg($message,$go_url);
		}
		else
		{
			msgclose($message);
		}

		// https://developers.google.com/analytics/devguides/reporting/core/v3/coreErrors
		/*
		(400) invalidParameter
		요청 매개 변수에 잘못된 값이 있는지를 나타냅니다.
		locationType에 및 위치에 있는 값이 유효하도록 오류 응답의 필드 정보를 제공합니다.
		문제를 해결하지 않고 다시 시도하지 마십시오. 사용자는 에러 응답에서 지정된 파라미터에 대한 유효 값을 제공해야한다.

		(400) badRequest
		쿼리가 잘못되었음을 나타냅니다.
		예를 들면, 부모 ID가 누락되었거나 요청 치수 또는 메트릭의 조합이 올바르지 않습니다.
		문제를 해결하지 않고 다시 시도하지 마십시오. 당신은 그것이 작동하기 위해서는 API 쿼리를 변경해야합니다.

		(401) invalidCredentials
		인증 토큰이 잘못되었거나 만료되었음을 나타냅니다.
		문제를 해결하지 않고 다시 시도하지 마십시오. 새 인증 토큰을 얻을 필요가있다.

		(403) insufficientPermissions
		사용자가 쿼리에 지정된 엔티티에 대한 충분한 권한이 없음을 나타냅니다.
		문제를 해결하지 않고 다시 시도하지 마십시오. 당신은 지정된 개체에서 작업을 수행 할 수있는 권한을 얻을 필요가있다.

		(403) dailyLimitExceeded
		사용자가 ((프로필) 프로젝트마다 또는 뷰 당 하나) 매일 할당량을 초과했음을 나타냅니다.
		문제를 해결하지 않고 다시 시도하지 마십시오. 당신은 당신의 매일 할당량을 사용하고 있습니다. 참조 API 제한 및 할당량 .

		(403) usageLimits.userRateLimitExceededUnreg
		구글 개발자 콘솔에서 응용 프로그램이 등록 될 필요가 있음을 나타냅니다
		문제를 해결하지 않고 다시 시도하지 마십시오. 당신은 전체 할당량을 얻기 위해 개발자 콘솔에 등록해야합니다.

		(403) userRateLimitExceeded
		사용자 속도 제한이 초과되었음을 나타냅니다.
		최대 속도 제한은 IP 주소 당 10 QPS입니다. 구글 코드 콘솔에 설정된 디폴트 값은 IP 어드레스 당 1 QPS이다. 당신은이 제한을 증가시킬 수있다
		구글 개발자 콘솔을 10 QPS 최대.	사용하여 다시 시도 지수 백 오프를 . 당신은 당신이 요청을 전송되는 속도를 느리게 할 필요가있다.

		(403) quotaExceeded
		핵심보고 API의보기 당 10 동시 요청 (프로파일)에 도달했음을 나타냅니다.
		사용하여 다시 시도 지수 백 오프를 . 당신은 완료하는 데이보기 (프로필) 적어도 하나의 진행 요청을 기다릴 필요가있다.

		(503) backendError
		서버에서 오류를 반환했습니다.
		한 번 이상이 쿼리가 더 시도하지 마십시오.
		*/
	}

############################################################################################################################
#                                                        기본함수들                                                        #
############################################################################################################################


	// connect, select, query databae
	/*
	function query($sql)
	{

		global $db_host, $db_user, $db_pass, $db_name;

		if (!$db = @mysql_connect($db_host, $db_user, $db_pass))
		{
			$result			= 0;
			echo ( "Unable to connect to database !<br><font color=red>$sql</font><hr>\n" . mysql_errno() . " <- 오류번호<br>" . mysql_error() .  "<br>") ;
		}
		else
		{
			if (!@mysql_select_db($db_name, $db))
			{
				$result = 0;
				echo ( "Unable to connect to database !<br><font color=red>$sql</font><hr>\n" . mysql_errno() . " <- 오류번호<br>" . mysql_error() .  "<br>") ;
			}
			else
			{
				if (!$result = @mysql_query($sql, $db))
				{
					$result = 0;
					echo ( "Unable to connect to database !<br><font color=red>$sql</font><hr>\n" . mysql_errno() . " <- 오류번호<br>" . mysql_error() .  "<br>") ;
				}

			}

		}

		return $result;
	}



	# 이동하기
	function go($url)
	{
		//echo "<META HTTP-EQUIV=refresh CONTENT=0;URL=$url>";
		echo "
				if ( top )
				{
					top.window.location.replace('$url');
				}
				else
				{
					window.location.replace('$url');
				}
		";
		exit;
	}


	# 메세지띄우기
	function msg($text)
	{
		echo "
				<script>
					window.alert('$text');
				</script>
		";
	}


	# 에러메세지
	function error($text)
	{
		echo "
				<script>
					window.alert('$text');
					history.go(-1);
				</script>
		";
		exit;
	}


	# 메세지띄우고 이동
	function gomsg($text,$url)
	{
		echo"
				<script>
					window.alert('$text');

					if ( top )
					{
						top.window.location.replace('$url');
					}
					else
					{
						window.location.replace('$url');
					}
				</script>
		";
	}


	# 쿠키굽기
	function cookie($name,$value,$time)
	{
		if ( $time )
		{
			$time			= 24*3600*100;
		}
		else
		{
			$time			= 0;
		}
		setcookie("$name","$value",$time,"/");
		global $HTTP_COOKIE_VARS;
	}


	# 메세지띄우고창닫기
	function msgclose($close)
	{
		echo "
				<script>
					window.alert('$close');

				if ( top )
				{
					top.window.close();
				}
				else
				{
					window.close();
				}
				</script>
		";
		exit;
	}


	# 메세지띄우고창닫기
	function msgclose_url($close,$url)
	{
		echo "
				<script>
					window.alert('$close');

					if ( top )
					{
						top.window.opener.location.href = \"$url\";
						top.window.close();
					}
					else
					{
						window.opener.location.href = \"$url\";
						window.close();
					}

				</script>
		";
		exit;
	}


	function print_r2($val)
	{
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	}
	*/





 ?>