<?
	ob_start();	//	jinam23 - PHP 워닝 수정할려고 추가함 
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");
/*
	echo "<pre>";
	print_r($_COOKIE);
	print_r($_SESSION);
	echo "</pre>";
*/
	$되돌아가는주소 = strip_tags($_GET["returnUrl"]);
	$되돌아가는주소 = $되돌아가는주소 == "" ? $_SERVER["HTTP_REFERER"] : $되돌아가는주소;
	$url = ( $_REQUEST["returnUrl"] == "" )?"./":$_REQUEST["returnUrl"];
	$url = ( $url == "" || $url == "./" )?$_SERVER["HTTP_REFERER"]:$url;

	if ( preg_match("/happy_member_login/",$url) || preg_match("/adultcheck\.html/",$url) || ( preg_match("/happy_member\.php/",$url) && !preg_match("/mode=mypage/",$url) ) ) {
		$url = "./";
	}

	$mode					= $_GET['mode'];
	$happy_member_login_id	= happy_member_login_check();
	
	if ( $mode == '' )
	{
		if ( $happy_member_login_id != "" )
		{
			echo "<script>alert('현재 $happy_member_login_id 아이디로 로그인중입니다.');history.go(-1);</script>";
			exit;
		}
		$Templet	= "$happy_member_skin_folder/happy_member_login.html";
	}
	else if ( $mode == 'logout' )
	{
		if ( $happy_member_login_id == "" )
		{
			echo "<script>alert('로그인 상태가 아닙니다.');history.go(-1);</script>";
			exit;
		}



		if ( $happy_member_login_value_type == 'session' )
		{
			$_SESSION[$happy_member_login_value_name]	= '';
			session_destroy();
		}
		else if ( $happy_member_login_value_type == 'cookie' )
		{
			$_COOKIE[$happy_member_login_value_name]	= '';
			setcookie($happy_member_login_value_name, '', 0, "/", $happy_member_login_value_url);
		}
		else
		{
			return print "<font color=red>잘못된 \$happy_member_login_value_type 설정입니다.</font>";
		}


		$max		= sizeof( $happy_member_login_sub_value_type );
		$cookie_val	= '';

		for ( $i=0 ; $i<$max ; $i++ )
		{
			$value_type		= $happy_member_login_sub_value_type[$i];
			$value_name		= $happy_member_login_sub_value_name[$i];
			$value_DB		= $happy_member_login_sub_value_DB[$i];
			$value_Table	= $happy_member_login_sub_value_Table[$i];
			$value_Field	= $happy_member_login_sub_value_Field[$i];
			$value_secure	= $happy_member_login_sub_value_secure[$i];
			$value_where	= $happy_member_login_sub_value_where[$i];

			if ( $value_type == '' || $value_name == '' || $value_DB == '' || $value_Table == '' || $value_Field == '' )
			{
				continue;
			}



			if ( $value_type == 'session' )
			{
				$_SESSION[$value_name]	= $cookie_val;
			}
			else if ( $value_type == 'cookie' )
			{
				$_COOKIE[$value_name]	= $cookie_val;
				setcookie($value_name,$cookie_val,0,"/",$happy_member_login_value_url);
			}
			else
			{
				continue;
			}
		}


		//hun	2013-07-19		자동로그인 정보 소멸
		setcookie($happy_member_auto_login_id_cookie, '', 0, "/", $happy_member_login_value_url);
		setcookie($happy_member_auto_login_pass_cookie, '', 0, "/", $happy_member_login_value_url);
		//hun	2013-07-19		자동로그인 정보 소멸

		go("./");
		exit;
	}
	else if ( $mode == 'login_reg' )
	{
		if ( $happy_member_login_id != "" )
		{
			echo "<script>alert('현재 $happy_member_login_id 아이디로 로그인중입니다.');history.go(-1);</script>";
			exit;
		}

		//데모 로그인 기능 개선.		2018-12-13 hun
		if( $demo_lock != '' && $_GET['member_type'] != '' )
		{
			$_POST['member_id']			= $DEMO_MEMBER_ARRAY[$_GET[member_type]]['id'];
			$_POST['member_pass']		= $DEMO_MEMBER_ARRAY[$_GET[member_type]]['pass'];
		}
		//데모 로그인 기능 개선.		2018-12-13 hun

		// 네이버 로그인이면 아이디를 소문자로 변환을 안하도록
		if ( $_POST['is_sns_login_type'] == "popup" && substr($_POST['member_id'],0,6) == "naver_" )
		{
			$_POST['member_id']	= trim($_POST['member_id']);
		}
		else
		{
			$_POST['member_id']	= strtolower(trim($_POST['member_id']));
		}

		$member_id			= $_POST['member_id'];
		$member_pass		= $_POST['member_pass'];
		if ( $happy_member_autoslashes )
		{
			$member_id		= addslashes($member_id);
			$member_pass	= addslashes($member_pass);
		}

		$member_pass		= Happy_Secret_Code($member_pass);

		if ( $member_id == '' || $member_pass == '' )
		{
			error('아이디와 비밀번호를 모두 입력해주세요.');
			exit;
		}

		$Sql	= "select count(*) from $happy_member WHERE user_id='$member_id' ";
		$Chk	= happy_mysql_fetch_array(query($Sql));

		$Sql	= "select count(*) from $happy_member_quies WHERE user_id='$member_id' ";
		$Chk2	= happy_mysql_fetch_array(query($Sql));

		if ( $Chk[0] == 0 && $Chk2[0] == 0 )
		{
			//gomsg("[$member_id] 아이디가 없습니다.");
			error("[$member_id] 아이디가 없습니다.");
			exit;
		}


		if($Chk[0] > 0)
		{
			$member_table		= $happy_member;
		}
		else if($Chk2[0] > 0)
		{
			$member_table		= $happy_member_quies;
			$quies_mode			= 1;
		}


		$Sql	= "select * from $member_table WHERE user_id='$member_id' ";
		$User	= happy_mysql_fetch_assoc(query($Sql)); //happy_member,happy_member_quies

		if ( $User['user_id'] != $member_id )
		{
			error("[$member_id] 아이디가 없습니다. 아이디는 대소문자를 구분합니다.");
			exit;
		}
		elseif ( $User['user_pass'] != $member_pass )
		{
			//gomsg("비밀번호가 틀렸습니다.");
			error("비밀번호가 틀렸습니다.");
			exit;
		}
		else if ( $User['user_pass'] == $member_pass )
		{
			//휴면회원일 경우 인증페이지 이동
			if($quies_mode == 1)
			{
				$_SESSION['user_id_quies']		= $User['user_id'];
				$user_id_urlencode		= urlencode($User['user_id']);
				gomsg("휴면해제 인증페이지로 이동합니다","happy_member_quies_iso.php?user_id=$user_id_urlencode");
				exit;
			}

			$Sql	= "SELECT * FROM $happy_member_group WHERE number='$User[group]' ";
			$Group	= happy_mysql_fetch_array(query($Sql));

			# 이메일 인증 그룹인지 체크
			if ( $Group['iso_email'] == 'y' && $User['iso_email'] != 'y' )
			{
				#error('이메일 인증을 완료하신 뒤에 로그인 하실수 있습니다.');
				$User['user_email']	= urlencode($User['user_email']);
				setcookie('happy_tmp_id',$member_id,0,"/",$happy_member_login_value_url);
				echo "
					<script>
						alert('이메일 인증을 완료하신 뒤에 로그인 하실수 있습니다.');
						smscheckWindow	= window.open('./happy_member_check_email.php?email=$User[user_email]','happy_member_check_email', 'status=no,scrollbars=no,width=300,height=250')
						smscheckWindow.focus();
						history.go(-1);
					</script>
				";
				exit;
			}


			if ( $happy_member_login_value_type == 'session' )
			{
				$_SESSION[$happy_member_login_value_name]	= $member_id;
			}
			else if ( $happy_member_login_value_type == 'cookie' )
			{
				$_COOKIE[$happy_member_login_value_name]	= $member_id;
				setcookie($happy_member_login_value_name,$member_id,0,"/",$happy_member_login_value_url);
			}
			else
			{
				return print "<font color=red>잘못된 \$happy_member_login_value_type 설정입니다.</font>";
			}


			$max	= sizeof( $happy_member_login_sub_value_type );

			for ( $i=0 ; $i<$max ; $i++ )
			{
				$value_type		= $happy_member_login_sub_value_type[$i];
				$value_name		= $happy_member_login_sub_value_name[$i];
				$value_DB		= $happy_member_login_sub_value_DB[$i];
				$value_Table	= $happy_member_login_sub_value_Table[$i];
				$value_Field	= $happy_member_login_sub_value_Field[$i];
				$value_secure	= $happy_member_login_sub_value_secure[$i];
				$value_where	= $happy_member_login_sub_value_where[$i];

				if ( $value_type == '' || $value_name == '' || $value_DB == '' || $value_Table == '' || $value_Field == '' )
				{
					continue;
				}

				$value_where	= str_replace('%회원아이디%', $User['user_id'], $value_where );
				$value_where	= str_replace('%회원고유번호%', $User['number'], $value_where );


				$Sql		= "SELECT $value_Field FROM $value_Table $value_where ";
				$Tmp		= happy_mysql_fetch_array(query($Sql));

				$cookie_val	= $Tmp[$value_Field];

				if ( $value_secure == 'md5' )
				{
					$cookie_val	= Happy_Secret_Code($cookie_val);
				}
				else if ( $value_secure == 'password' )
				{
					list($cookie_val)	= happy_mysql_fetch_array(query("SELECT password('$cookie_val')"));
				}
				else if ( $value_secure == 'old_password' )
				{
					list($cookie_val)	= happy_mysql_fetch_array(query("SELECT old_password('$cookie_val')"));
				}

				if ( $value_type == 'session' )
				{
					$_SESSION[$value_name]	= $cookie_val;
				}
				else if ( $value_type == 'cookie' )
				{
					$_COOKIE[$value_name]	= $cookie_val;
					setcookie($value_name,$cookie_val,0,"/",$happy_member_login_value_url);
				}
				else
				{
					continue;
				}
			}


			//hun	2013-07-19	자동로그인 체크했을 경우 자동로그인 정보기록
			if ( $_POST['auto_login_use'] == 'y' )
			{
				$_COOKIE[$happy_member_auto_login_id_cookie]	= $member_id;
				setcookie($happy_member_auto_login_id_cookie,$member_id,happy_mktime()+60*60*24*$happy_member_auto_login_id_day,"/",$happy_member_login_value_url);

				$Tmp		= happy_mysql_fetch_array(query($Sql));
				$cookie_val	= Happy_Secret_Code($Tmp[user_pass]);
				setcookie($happy_member_auto_login_pass_cookie,$cookie_val,happy_mktime()+60*60*24*$happy_member_auto_login_id_day,"/",$happy_member_login_value_url);
			}
			else
			{
				$_COOKIE[$happy_member_auto_login_id_cookie]	= '';
				setcookie($happy_member_auto_login_id_cookie,'',happy_mktime()-36000,"/",$happy_member_login_value_url);
			}
			//hun	2013-07-19	자동로그인 체크했을 경우 자동로그인 정보기록



			if ( $_POST['save_id'] == 'y' )
			{
				$_COOKIE[$happy_member_login_save_id_cookie]	= $member_id;
				setcookie($happy_member_login_save_id_cookie,$member_id,happy_mktime()+60*60*24*$happy_member_login_save_id_day,"/",$happy_member_login_value_url);
			}
			else
			{
				$_COOKIE[$happy_member_login_save_id_cookie]	= '';
				setcookie($happy_member_login_save_id_cookie,'',happy_mktime()-36000,"/",$happy_member_login_value_url);
			}

			query("UPDATE $happy_member SET login_date = now(), login_count = login_count + 1 where user_id='$member_id' ");

			//로그인을 할때 성인인증 변수 초기화
			setcookie("job_adultcheck","",0,"/",$cookie_url);
			setcookie("adult_check","",0,"/",$cookie_url);
			//로그인을 할때 성인인증 변수 초기화


			if ( $demo_lock ) {
				query("
						INSERT INTO
								$message_tb
						SET
								sender_id  = 'HappyCGI',
								sender_name  = '해피CGI',
								receive_id  = '$member_id',
								receive_name = '$User[name]',
								message   = '해피CGI 데모페이지에 로그인하신것을 환영합니다.<br><br>데모페이지에서는 로그인하실경우 쪽지시스템의 존재를 확인시켜드리기 위해 자동으로 쪽지가 발송됩니다.<br>현재 보시는 쪽지 메세지는  AJAX로 연동되어 실시간 작동이 이루어 집니다.<br>쪽지 확인은 로그인후 로그인정보출력창에 나오는 쪽지 아이콘을 클릭하면 확인할수 있습니다.<br><br>오늘도 좋은하루 보내세요.',
								regdate   = now()
				");
			}


			//SNS 로그인 종류에 따른 location 처리 - hong
			switch ( $_POST['is_sns_login_type'] )
			{
				case 'popup' :
					$location_js	= "window.open('', '_self', '');  window.close();";
					break;

				case 'frame' :
					//	jinam23 수정 - 구인구직 SSO 서비스 처리를 위해 수정함. window.open() 으로 SSO 띄운것 처리...
					$location_js	= "opener.window.location.reload();";
					$location_js	.= "window.close();";
					//$location_js	= "parent.window.location.replace('$url');";
					break;

				default :
					$location_js	= "window.location.replace('$url');";
					break;
			}

			//echo "<script>alert('로그인되었습니다.'); {$location_js}</script>";
			echo "<script>{$location_js}</script>";
		}
		exit;
	}
	#관리자권한 회원로그인 추가 - 13.06.20 hong
	else if ( $mode == "admin_login_reg" )
	{
		if ( !admin_secure("회원관리") )
		{
			msgclose("접속권한이 없습니다.");
			exit;
		}

		if ( $_GET['member_login_id'] == "" )
		{
			msgclose("회원 아이디가 없습니다.");
			exit;
		}

		$member_id	= $_GET['member_login_id'];

		$Sql		= "select * from $happy_member WHERE user_id='$member_id' ";
		$User		= happy_mysql_fetch_array(query($Sql));

		if ( $happy_member_login_value_type == 'session' )
		{
			$_SESSION[$happy_member_login_value_name]	= $member_id;
		}
		else if ( $happy_member_login_value_type == 'cookie' )
		{
			$_COOKIE[$happy_member_login_value_name]	= $member_id;
			setcookie($happy_member_login_value_name,$member_id,0,"/",$happy_member_login_value_url);
		}
		else
		{
			return print "<font color=red>잘못된 \$happy_member_login_value_type 설정입니다.</font>";
		}


		$max		= sizeof( $happy_member_login_sub_value_type );

		for ( $i=0 ; $i<$max ; $i++ )
		{
			$value_type		= $happy_member_login_sub_value_type[$i];
			$value_name		= $happy_member_login_sub_value_name[$i];
			$value_DB		= $happy_member_login_sub_value_DB[$i];
			$value_Table	= $happy_member_login_sub_value_Table[$i];
			$value_Field	= $happy_member_login_sub_value_Field[$i];
			$value_secure	= $happy_member_login_sub_value_secure[$i];
			$value_where	= $happy_member_login_sub_value_where[$i];

			if ( $value_type == '' || $value_name == '' || $value_DB == '' || $value_Table == '' || $value_Field == '' )
			{
				continue;
			}

			$value_where	= str_replace('%회원아이디%', $User['user_id'], $value_where );
			$value_where	= str_replace('%회원고유번호%', $User['number'], $value_where );


			$Sql		= "SELECT $value_Field FROM $value_Table $value_where ";
			$Tmp		= happy_mysql_fetch_array(query($Sql));

			$cookie_val	= $Tmp[$value_Field];

			if ( $value_secure == 'md5' )
			{
				$cookie_val	= Happy_Secret_Code($cookie_val);
			}
			else if ( $value_secure == 'password' )
			{
				list($cookie_val)	= happy_mysql_fetch_array(query("SELECT password('$cookie_val')"));
			}
			else if ( $value_secure == 'old_password' )
			{
				list($cookie_val)	= happy_mysql_fetch_array(query("SELECT old_password('$cookie_val')"));
			}

			if ( $value_type == 'session' )
			{
				$_SESSION[$value_name]	= $cookie_val;
			}
			else if ( $value_type == 'cookie' )
			{
				$_COOKIE[$value_name]	= $cookie_val;
				setcookie($value_name,$cookie_val,0,"/",$happy_member_login_value_url);
			}
			else
			{
				continue;
			}
		}

		$url	= ( $_GET['admin_url'] != '' ) ? $_GET['admin_url'] : "happy_member.php?mode=mypage";

		go($url);
		exit;
	}

	if( $demo_lock == '1' )		//데모 로그인 기능 개선.		2018-12-13 hun
	{
		ob_start();
		main_top_menu("happy_member_demo_login.html");	//{{HTML호출 happy_member_demo_login.html}} <!--데모일때만 나타날 레이어-->
		$demo_login_layer = ob_get_contents();
		ob_end_clean();
	}

	if ( !is_file("$Templet") )
	{
		echo "$Templet 파일이 존재하지 않습니다.";
		exit;
	}

	//echo $Templet;
	$TPL->define("로그인페이지", $Templet);
	$content = &$TPL->fetch("로그인페이지");


	$내용	= $content;



	if( !(is_file("$happy_member_skin_folder/happy_member_login_default.html")) ) {
		$content = "껍데기 $happy_member_skin_folder/happy_member_login_default.html 파일이 존재하지 않습니다. <br>";
		return;
	}
	$TPL->define("껍데기", "$happy_member_skin_folder/happy_member_login_default.html");
	$content = &$TPL->fetch();


	echo $content;


	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}


?>