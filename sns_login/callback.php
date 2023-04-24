<?php

	###########################################################################
	###		SNS 로그인 사이트 개별 연동 파일 - 로그인 요청 callbak 페이지	###
	###########################################################################

	include ("../inc/config.php");
	include ("../inc/function.php");

	// 키메디 SSO
	if( $_POST['userIdx'] != '' && $_POST['accessToken'] != '' )
	{
		$happy_secure_key	= md5($site_name.$db_user.session_id().$_SERVER['REMOTE_ADDR']);
		$sns_site			= "keymedi";
		$returnUrl_sso		= $_POST['returnUrl_sso'];

		setcookie('happy_secure_key', $happy_secure_key, 0, "/", $cookie_url);
		setcookie('sns_site', $sns_site, 0, "/", $cookie_url);
		setcookie('returnUrl', $returnUrl_sso, 0, "/", $cookie_url);

		$_COOKIE['happy_secure_key']	= $happy_secure_key;
		$_COOKIE['sns_site']			= $sns_site;
		$_COOKIE['returnUrl']			= $returnUrl_sso;
	}

	//callback 페이지에서는 cookie로 전달받음
	$happy_secure_key		= $_COOKIE['happy_secure_key'];
	$sns_site				= $_COOKIE['sns_site'];
	$returnUrl				= $_COOKIE['returnUrl'];
	$sns_login_key			= $_COOKIE['sns_login_key'];
	$sns_login_secret		= $_COOKIE['sns_login_secret'];
	$callback_url			= $_COOKIE['callback_url'];

	$sns_login_js			= Array();
	$sns_login_js['body']	= "
	<script type='text/javascript'>
		window.onload = function() { document.forms['joinus_form'].submit(); }
	</script>
	";

	$is_login_ok			= false;
	$error_code				= "";

	switch ( $sns_site )
	{
		// 키메디 SSO
		case 'keymedi' :
		{
			( $_POST['userIdx'] )? $userIdx = $_POST['userIdx'] : $userIdx = '' ;
			( $_POST['accessToken'] )? $accessToken = $_POST['accessToken'] : $accessToken = '' ;

			$result		= array() ;
			if( $userIdx!='' && $accessToken!='' ) {
				$s_token	= generate_s_token($userIdx) ;
				$result		= get_my_info($accessToken, $s_token) ;

				if( $result['code'] == 0 )
				{
					$sns_id			= $result['data']['uid'];
					$sns_name		= $result['data']['name'];
					$sns_username	= $result['data']['name'];
					$sns_image		= '';
					$sns_email		= $result['data']['email'];
					$sns_hphone		= $result['data']['mobile'];
					$sns_gender		= $result['data']['gender'];
					switch($sns_gender)
					{
						case "male":	$sns_gender = "man";break;
						case "female":	$sns_gender = "girl";break;
						default :		$sns_gender = "";break;
					}

					$sns_license_number		= $result['data']['license_number'];	// 면허번호
					$sns_main_medical_part	= $result['data']['main_medical_part'];	// 대표진료과

					$is_login_ok		= true;

				}
				else
				{
					$error_code			= "keymedi : {$result['code']}";
				}

			} else {
				/*
				$result['code'] = 0 ;
				$result['message'] = "Error" ;
				$result['data'] = array() ;
				*/

				$error_code			= "keymedi : no idx";
			}

			break;
		}
		case 'twitter' :
		{
			require_once 'inc/twitteroauth.php';

			$error_code			= "twitter 001";

			/* If the oauth_token is old redirect to the connect page. */
			if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token'])
			{
				$error_code			= "twitter 002";
			}

			/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
			$connection			= new TwitterOAuth($sns_login_key, $sns_login_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

			/* Request access tokens from twitter */
			$access_token		= $connection->getAccessToken($_REQUEST['oauth_verifier']);

			/* Remove no longer needed request tokens */
			unset($_SESSION['oauth_token']);
			unset($_SESSION['oauth_token_secret']);

			/* If HTTP response is 200 continue otherwise send to connect page to retry */
			if (200 == $connection->http_code)
			{
				/* The user has been verified and the access tokens can be saved for future use */
				/* Create a TwitterOauth object with consumer/user tokens. */
				$connection			= new TwitterOAuth($sns_login_key, $sns_login_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

				/* If method is set change API call made. Test is called by default. */
				$user_profile		= $connection->get('account/verify_credentials');
			}
			else
			{
				/* Save HTTP status for error dialog on connnect page.*/
				$error_code			= "twitter 003";
			}

			#echo '<pre>'; print_r($user_profile); echo '</pre>';		exit;


			if ($user_profile->id != '' )
			{
				$sns_id				= $user_profile->id;
				$sns_name			= $user_profile->name;
				$sns_username		= $user_profile->username;
				$sns_image			= $user_profile->profile_image_url;
				$sns_email			= $user_profile->email;

				if ( preg_match("/euc/i",$server_character) )
				{
					$sns_name			= iconv("utf-8","euc-kr",$sns_name);
					$sns_username		= iconv("utf-8","euc-kr",$sns_username);
				}

				$is_login_ok		= true;
			}
			else
			{
				$error_code			= "twitter 004";
			}

			break;
		}

		case 'kakao' :
		{
			if ( !function_exists('json_decode') )
			{
				include ("inc/JSON.php");

				function json_decode($value)
				{
					$json = new Services_JSON();
					return $json->decode($value);
				}
			}

			# CURL로 카카오 호출시 CURLOPT_SSLVERSION 이 원래는 3이였고 잘 되는 상황이였는데 어느순간 안되길래 이것저것 찾다가 마지막으로 CURLOPT_SSLVERSION 값을 1로 바꾸니 되더라는
			# 추후 문제가 발생시 CURLOPT_SSLVERSION 의심해볼만할듯
			# CURLOPT_SSLVERSION 값은 메뉴얼에 2 or 3 이라고 나와 있는데.. 2,3 모두 안되고 1로 하면 되고..

			$code			= $_GET["code"];

			# 로그인 페이지에서 값이 넘어왔다면
			if ( $code != '' )
			{
				$curlUrl		= 'https://kauth.kakao.com/oauth/token';
				$curlParams		= sprintf( 'grant_type=authorization_code&client_id=%s&redirect_uri=%s&code=%s', $sns_login_key, $callback_url, $code);

				$curlSession	= curl_init();
				curl_setopt($curlSession, CURLOPT_URL, $curlUrl);
				curl_setopt($curlSession, CURLOPT_HEADER, false);
				curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curlSession, CURLOPT_SSLVERSION, 1);
				curl_setopt($curlSession, CURLOPT_POST, true);
				curl_setopt($curlSession, CURLOPT_POSTFIELDS, $curlParams);
				$accessTokenJson = curl_exec($curlSession);
				curl_close($curlSession);

				$accessToken = json_decode($accessTokenJson);
				# print_r2($accessToken);exit;
				# echo $accessTokenJson;


				# 토큰을 정상적으로 가지고 왔다면
				if ( $accessToken->access_token != '' )
				{
					$curlUrl		= 'https://kapi.kakao.com/v2/user/me';
					$curlHeader		= array(
											"Authorization: Bearer " . $accessToken->access_token
									);

					$curlSession	= curl_init();
					curl_setopt($curlSession, CURLOPT_URL, $curlUrl);
					curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curlSession, CURLOPT_SSLVERSION, 1);
					curl_setopt($curlSession, CURLOPT_POST, true);
					curl_setopt($curlSession, CURLOPT_POSTFIELDS, false);
					curl_setopt($curlSession, CURLOPT_HTTPHEADER, $curlHeader);
					$accessTokenJson = curl_exec($curlSession);
					curl_close($curlSession);

					$USER			= json_decode($accessTokenJson);

					if ($USER->id != '' )
					{
						$sns_id				= $USER->id;
						$sns_name   = $USER->kakao_account->name;
						if($sns_name == '')
						{
						  $sns_name  = $USER->properties->nickname;
						}
						$sns_username		= $USER->properties->nickname;
						$sns_image   = $USER->kakao_account->profile->thumbnail_image_url;
						$sns_email			= $USER->kakao_account->email;
						$sns_hphone   = str_replace("+82 ","0",$USER->kakao_account->phone_number);
						$sns_birthyear  = $USER->kakao_account->birthyear;
						$sns_birthday_info = $USER->kakao_account->birthday;
						$sns_birthmonth  = substr($sns_birthday_info,0,2);
						$sns_birthday  = substr($sns_birthday_info,2,2);
						$sns_gender   = $USER->kakao_account->gender;
						switch($sns_gender)
						{
						   case "male":   $sns_gender = "man";break;
						   case "female": $sns_gender = "girl";break;
						   default :          $sns_gender = "";break;
						}

						if ( preg_match("/euc/i",$server_character) )
						{
							$sns_name			= iconv("utf-8","euc-kr",$sns_name);
							$sns_username		= iconv("utf-8","euc-kr",$sns_username);
						}

						$is_login_ok		= true;
					}
					else
					{
						$error_code			= "kakao 003";
					}
				}
				# 토큰을 못가져 왔을때
				else
				{
					$error_code			= "kakao 002";
				}

			}
			# 로그인 페이지에서 값이 안넘어왔다면
			else
			{
				$error_code			= "kakao 001";
			}

			/*

			error code

			설명

			HTTP 상태 코드

			-1 내부 처리 오류. 에러 코드로 상세 분류되어 있지 않은 경우 400
			-2 잘못된 파라미터. 호출 인자값이 잘못되었거나 필수 인자가 포함되지 않은 경우 400
			-3 지원되지 않는 서비스 API에 대한 호출. 해당 앱의 호출된 API가 설정에서 off되어 있을 경우 400
			-4 계정 제재 또는 특정 서비스에서 해당 사용자의 제재로 인해 API 호출이 금지된 경우 400
			-5 해당 API에 대한 권한/퍼미션이 없는 경우 403
			-10 허용된 요청 횟수가 초과된 경우. 자세한 내용은 쿼터 및 제한을 참고 400
			-101 해당 앱에 연결이 되지 않은 사용자의 요청. 로그인 기반 API의 경우 앱 연결이 선행되어야 함 400
			-102 이미 해당 앱에 연결된(가입/등록) 사용자가 재연결을 시도할 경우 400
			-103 존재하지 않는 카카오계정에 대한 호출 400
			-201 사용자 관리 API 호출시 파라미터가 부적절히 구성되었을 경우. 주로 개발자 웹사이트의 (내 애플리케이션 > 설정 > 사용자 관리)에서 사용자 정보의 설정과 요청의 파라미터가 불일치 할 경우 발생 400
			-301 등록되지 않은 앱키의 요청 또는 존재하지 않는 앱으로의 요청 400
			-401 사용자 토큰이 잘못되었을 경우. 주로 만료된 토큰에 대한 요청 401
			-402 해당 API에 대한 사용자의 동의 퍼미션이 없는 경우 403
			-501 카카오톡 미가입 사용자가 카카오톡 API를 호출 하였을 경우 400
			-601 카카오스토리 미가입 사용자가 카카오스토리 API를 호출 하였을 경우 400
			-602 카카오스토리 이미지 업로드시 최대 용량(현재 5MB. 단,gif 파일은 3MB)을 초과하였을 경우 400
			-603 카카오스토리 이미지 업로드/스크랩 정보 요청시 타임아웃 발생 400
			-604 카카오스토리에서 스크랩이 실패하였을 경우 400
			-605 카카오스토리에 존재하지 않는 내스토리를 요청을 했을 경우 400
			-606 카카오스토리 이미지 업로드시, 최대 이미지 갯수(현재 5개. 단, gif 파일은 1개)를 초과하였을 경우 400
			-901 등록된 푸시토큰이 없는 기기로 푸시 메시지를 보낸 경우 400
			-9798 서비스 점검중 503
			*/
			break;
		}

		case 'naver' :
		{
			if ( $_GET['error'] == "" )
			{
				$is_login_ok			= true;

				$sns_login_js['head']	= "
				<script type='text/javascript' src='js/naver_login.js'></script>
				<script type='text/javascript' src='//code.jquery.com/jquery-1.11.3.min.js'></script>
				";

				$sns_login_js['body'] = "
				<script type='text/javascript'>

					var naver_id_login	= new naver_id_login('" . $sns_login_key . "', '" . $callback_url . "');

					function callback_naver_login()
					{
						var form = document.forms['joinus_form'];

						form.sns_id.value   = naver_id_login.getProfileData('id');

						if ( naver_id_login.getProfileData('nickname') != undefined )
						{
							form.sns_username.value  = naver_id_login.getProfileData('nickname');
						}
						else
						{
							form.sns_username.value  = 'naver_' + naver_id_login.getProfileData('id');
						}

						if ( naver_id_login.getProfileData('name') != undefined )
						{
							form.sns_name.value  = naver_id_login.getProfileData('name');
						}
						else
						{
							form.sns_name.value  = form.sns_username.value;
						}

						if ( naver_id_login.getProfileData('email') != undefined )
						{
							form.sns_email.value  = naver_id_login.getProfileData('email');
						}

						if ( naver_id_login.getProfileData('profile_image') != undefined )
						{
							form.sns_image.value  = naver_id_login.getProfileData('profile_image');
						}

						form.submit();
					}

					naver_id_login.get_naver_userprofile('callback_naver_login()');
				</script>
				";
			}
			else
			{
				$error_code				= $_GET['error']."(".$_GET['error_description'].")";
			}
			break;
		}
	}

	//callback 페이지에서 사용한 쿠키 삭제
	setcookie('secure_key', '', 0, "/", $cookie_url);
	setcookie('sns_site', '', 0, "/", $cookie_url);
	setcookie('returnUrl', '', 0, "/", $cookie_url);
	setcookie('sns_login_key', '', 0, "/", $cookie_url);
	setcookie('sns_login_secret', '', 0, "/", $cookie_url);
	setcookie('callback_url', '', 0, "/", $cookie_url);

	if ( $is_login_ok === false )
	{
		msgclose(" 로그인에 실패 하였습니다. 재시도를 해주세요. \\n ERROR CODE : ".$error_code);
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<title>Happy SNS Login</title>
	<?=$sns_login_js['head']?>
</head>
<body>
<form name="joinus_form" action="joinus.php" method="post">
	<input type="hidden" name="returnUrl" value="<?=$returnUrl?>">
	<input type="hidden" name="sns_site" value="<?=$sns_site?>">
	<input type="hidden" name="sns_id" value="<?=$sns_id?>">
	<input type="hidden" name="sns_name" value="<?=$sns_name?>">
	<input type="hidden" name="sns_username" value="<?=$sns_username?>">
	<input type="hidden" name="sns_email" value="<?=$sns_email?>">
	<input type="hidden" name="sns_image" value="<?=$sns_image?>">
	<input type="hidden" name="post_happy_secure_key" value="<?=$happy_secure_key?>">

	<input type="hidden" name="sns_hphone" value="<?=$sns_hphone?>">
	<input type="hidden" name="sns_birthyear" value="<?=$sns_birthyear?>">
	<input type="hidden" name="sns_birthmonth" value="<?=$sns_birthmonth?>">
	<input type="hidden" name="sns_birthday" value="<?=$sns_birthday?>">
	<input type="hidden" name="sns_gender" value="<?=$sns_gender?>">
</form>

<?=$sns_login_js['body']?>

</body>
</html>