<?php

	###################################################################
	###		SNS 로그인 사이트 개별 연동 파일 - 로그인 요청페이지	###
	###################################################################

	include ("../inc/config.php");
	include ("../inc/function.php");

	$happy_secure_key	= md5($site_name.$db_user.session_id().$_SERVER['REMOTE_ADDR']);

	$sns_site			= $_GET['sns_site'];
	$returnUrl			= $_GET['returnUrl'];

	$sns_login_key		= trim($HAPPY_CONFIG['happy_sns_login_key_'.$sns_site]);
	$sns_login_secret	= trim($HAPPY_CONFIG['happy_sns_login_secret_'.$sns_site]);
	$callback_url		= $main_url."/".trim($HAPPY_CONFIG['happy_sns_login_callback_'.$sns_site]);

	//callback 페이지에서 사용할 쿠키 생성
	setcookie('happy_secure_key', $happy_secure_key, 0, "/", $cookie_url);
	setcookie('sns_site', $sns_site, 0, "/", $cookie_url);
	setcookie('returnUrl', $returnUrl, 0, "/", $cookie_url);
	setcookie('sns_login_key', $sns_login_key, 0, "/", $cookie_url);
	setcookie('sns_login_secret', $sns_login_secret, 0, "/", $cookie_url);
	setcookie('callback_url', $callback_url, 0, "/", $cookie_url);

	switch ( $sns_site )
	{
		//트위터
		case 'twitter' :
		{
			//5.2 버전 이하인 경우 오류
			if ( PHP_VERSION < '5.2' )
			{
				msgclose(" 트위터(twitter) 로그인을 사용할 수 없습니다. \\n 관리자에게 문의하세요. ");
				exit;
			}

			require_once 'inc/twitteroauth.php';

			/* Build TwitterOAuth object with client credentials. */
			$connection			= new TwitterOAuth($sns_login_key, $sns_login_secret);

			/* Get temporary credentials. */
			$request_token		= $connection->getRequestToken($callback_url);

			/* Save temporary credentials to session. */
			$_SESSION['oauth_token']			= $token = $request_token['oauth_token'];
			$_SESSION['oauth_token_secret']		= $request_token['oauth_token_secret'];

			/* If last connection failed don't display authorization link. */

			switch ($connection->http_code)
			{
				case 200:
					/* Build authorize URL and redirect user to Twitter. */
					$url = $connection->getAuthorizeURL($token);
					header('Location: ' . $url);
					break;
				default:
					/* Show notification if something went wrong. */
					msgclose("트위터 연결에 실패 했습니다. 잠시후 다시 시도 해주십시오.");
			}
			exit;
		}

		//카카오
		case 'kakao' :
		{
			header("Location: https://kauth.kakao.com/oauth/authorize?client_id=".$sns_login_key."&redirect_uri=".urlencode($callback_url)."&response_type=code");
			exit;
		}

		//네이버
		case 'naver' :
		{
			echo "
			<!DOCTYPE html>
			<html>
			<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<title>Naver Login</title>
			<script type='text/javascript' src='js/naver_login.js'></script>
			</head>
			<body>

			<script type='text/javascript'>
				var naver_id_login	= new naver_id_login('" . $sns_login_key . "', '" . $callback_url . "');
				var state			= naver_id_login.getUniqState();

				naver_id_login.setDomain('" . $cookie_url . "');
				naver_id_login.setState(state);
				naver_id_login.setPopup();

				window.onload = function() { window.location.href = naver_id_login.getNaverIdLoginLink(); }
			</script>

			</body>
			</html>
			";
			exit;
		}
	}

?>