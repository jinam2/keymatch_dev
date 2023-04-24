<?php

	// step 3 iframe

	require_once 'inc/config.php';
	require_once 'inc/function.php';
	require_once 'api/src/Google/autoload.php';

	session_start();

	$profile_id		= $_COOKIE['profile_id'];
	$start_date		= $_COOKIE['start_date'];
	$end_date		= $_COOKIE['end_date'];

	if ( $profile_id == "" || $start_date == "" || $end_date == "" )
	{
		msgclose("ERROR:2001");
		exit;
	}

	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

		//에러 체크
	$error_check		= gaErrorCheck();

	if ( $error_check )
	{
		$auth_url = $client->createAuthUrl();

		gaError($error_check,$google_account_url."?continue=".urlencode($auth_url));
		exit;
	}

	if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
	{
		$client->setAccessToken($_SESSION['access_token']);

		$analytics	= new Google_Service_Analytics($client);

		############################################################################################
		## function gaGetData($analytics,$dimensions='',$metrics,$sort='',$max_results=30)
		############################################################################################

		#일일 방문수중 사람 (기간이 길명 오래걸림)
		$getVisitors			= gaGetData($analytics,'date','sessions','date',730);

		#일일 방문수중 페이지뷰
		$getPageviews			= gaGetData($analytics,'date','pageviews','date',730);

		#시간대별 방문수
		$getVisitsPerHour		= gaGetData($analytics,'hour','sessions','hour',25);

		#브라우져 사용율
		$getBrowsers			= gaGetData($analytics,array('browser','browserVersion'),'sessions','-sessions',25);

		#이전페이지
		$getReferrers			= gaGetData($analytics,array('source','referralPath'),'sessions','-sessions',21);

		#검색어
		$getSearchWords			= gaGetData($analytics,'keyword','sessions','-sessions',101);

		#해상도
		$getScreenResolution	= gaGetData($analytics,'screenResolution','sessions','-sessions',101);

		#가장많이 본페이지
		$getManyviews			= gaGetData($analytics,'pagePath','sessions','-sessions',21);

		#가장많이 머무른페이지 (미구현)
		$getOntime				= "null";

		#가장많이 나간페이지
		$getOutpage				= gaGetData($analytics,'exitPagePath','exits','-exits',21);

		############################################################################################


		query("truncate $analytics_list_tb");

		$Sql					= "
									INSERT INTO
											$analytics_list_tb
									SET
											sdate				= '$start_date',
											edate				= '$end_date',
											getVisitors			= '".addslashes($getVisitors)."',
											getPageviews		= '".addslashes($getPageviews)."',
											getVisitsPerHour	= '".addslashes($getVisitsPerHour)."',
											getBrowsers			= '".addslashes($getBrowsers)."',
											getReferrers		= '".addslashes($getReferrers)."',
											getSearchWords		= '".addslashes($getSearchWords)."',
											getScreenResolution	= '".addslashes($getScreenResolution)."',
											getManyviews		= '".addslashes($getManyviews)."',
											getOntime			= '".addslashes($getOntime)."',
											getOutpage			= '".addslashes($getOutpage)."',
											regdate				= NOW(),
											last_read			= '1'
								";

		query($Sql);
		echo "<HTML><HEAD><script>top.window.close();</script></HEAD><BODY></BODY></HTML>";
	}

?>