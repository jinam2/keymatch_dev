<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");


	#관리자 접속 체크 루틴
	if ( !admin_secure("접속통계") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	#관리자 접속 체크 루틴


	header("Content-Type: text/html; charset=UTF-8");

	$profile_id			= $_GET['profile_id'];

	$ga_info			= get_url_fsockopen("http://analytics.cafe24.com/ga/ajax_return.php?profile_id=$profile_id");

	if ( $ga_info != "" )
	{
		$GA_DATA			= unserialize($ga_info);

		foreach ( $GA_DATA as $key => $val )
		{
			$GA_DATA[$key]		= addslashes($val);

			if ( preg_match("/euc/i",$server_character) )
			{
				$GA_DATA[$key]		= iconv("utf-8","euc-kr",$GA_DATA[$key]);
			}
		}

		query("TRUNCATE $happy_analytics_tb");

		$Sql				= "
								INSERT INTO
										$happy_analytics_tb
								SET
										sdate				= '$GA_DATA[sdate]',
										edate				= '$GA_DATA[edate]',
										getVisitors			= '$GA_DATA[getVisitors]',
										getPageviews		= '$GA_DATA[getPageviews]',
										getVisitsPerHour	= '$GA_DATA[getVisitsPerHour]',
										getBrowsers			= '$GA_DATA[getBrowsers]',
										getReferrers		= '$GA_DATA[getReferrers]',
										getSearchWords		= '$GA_DATA[getSearchWords]',
										getScreenResolution	= '$GA_DATA[getScreenResolution]',
										getManyviews		= '$GA_DATA[getManyviews]',
										getOntime			= '$GA_DATA[getOntime]',
										getOutpage			= '$GA_DATA[getOutpage]',
										regdate				= NOW(),
										last_read			= '1'
							";
		query($Sql);

		echo "ok";
	}


	function get_url_fsockopen( $url )
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
			//echo "$errstr ($errno)<br>\n";
			return "";
		}
		else
		{
			fputs($fp, $out);
			$body			= false;
			while (!feof($fp))
			{
				$s				= fgets($fp, 128);
				if ( $body )
				{
					$in				.= $s;
				}
				if ( $s == "\r\n" )
				{
					$body			= true;
				}
			}

			fclose($fp);
			return $in;
		}
	}
?>