<?php

	// step 1

	require_once 'inc/config.php';
	require_once 'inc/function.php';
	require_once 'api/src/Google/autoload.php';

	session_start();

	# 넘어온 프로필ID 와 검색날짜를 쿠키로 임시 저장
	$profile_id			= trim(preg_replace('/\D/', '', $_GET['profile_id']));
	$start_date			= trim($_GET['start_date']);
	$end_date			= trim($_GET['end_date']);

	if ( $profile_id == "" )
	{
		msgclose('프로필(profile)ID를 입력해주세요.');
		exit;
	}

	if ( $start_date > $end_date ){
		msgclose('검색범위를 다시 정해주세요.');
		exit;
	}

	if ( !$start_date || $start_date == "0000-00-00" ){
		msgclose('시작날짜를 정해주세요.');
		exit;
	}
	if ( !$end_date || $end_date == "0000-00-00" ){
		msgclose('마감날짜를 정해주세요.');
		exit;
	}

	$Sql		= "SELECT TO_DAYS('$end_date')-TO_DAYS('$start_date')";
	$GAP		= mysql_fetch_array(query($Sql));

	if ( $GAP[0] > 730 ){
		msgclose('시작날짜와 마지막날짜 통계일 구간이 2년을 초과할수 없습니다.');
		exit;
	}

	if ($GAP[0] > 90){
		//msg('시작날짜와 마지막날짜 통계일 구간이 90일을 초과하는 경우\\n자료양이 많아 느려질수 있습니다.');
	}


	setcookie('profile_id',$profile_id,0,"/");
	setcookie('start_date',$start_date,0,"/");
	setcookie('end_date',$end_date,0,"/");

	#query("DELETE FROM $analytics_list_tb WHERE profileId = '$profile_id' ");

	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);
	$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

	header('Location: ' . filter_var($callback_url, FILTER_SANITIZE_URL));

?>