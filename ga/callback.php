<?php

	// step 2
	// 사용자계정 인증

	require_once 'inc/config.php';
	require_once 'inc/function.php';
	require_once 'api/src/Google/autoload.php';

	session_start();

	$profile_id		= $_COOKIE['profile_id'];
	$start_date		= $_COOKIE['start_date'];
	$end_date		= $_COOKIE['end_date'];

	if ( $profile_id == "" || $start_date == "" || $end_date == "" )
	{
		echo "ERROR:2001";
		exit;
	}

	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

	if ( !isset($_GET['code']) )
	{
		$auth_url = $client->createAuthUrl();
		header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
	}
	else
	{
		$client->authenticate($_GET['code']);
		$_SESSION['access_token'] = $client->getAccessToken();
		header('Location: ' . filter_var($return_url, FILTER_SANITIZE_URL));
	}

?>