<?php
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	include ("../inc/function.php");
	include ("../inc/lib.php");

	if ( !admin_secure("환경설정") ) {
		error("접속권한이 없습니다.");
		exit;
	}

	//환경설정
	if ( $mode == "info_mod" )
	{
		include ("tpl_inc/top_new.php");

		if ($demo_lock)
		{
			$ADMIN['main_url'] = $main_url;
			$ADMIN['cookie_url'] = $cookie_url;
			$ADMIN['admin_etc2'] = $demo_admin_etc2;
		}

		include ("./html/info_mod.html");
	}
	elseif ( $mode == "info_mod_ok" )
	{
		if ($demo_lock)
		{
			error("데모사이트는 환경설정이 적용되지 않습니다.");
			exit;
		}

		# 보안패치 2023-01-02 / 관리자 비밀번호 강화
		$CheckId	= $_POST['mod_admin_id'];	// 솔루션별 변경 필요
		$CheckPass	= $_POST['mod_admin_pw'];	// 솔루션별 변경 필요

		if ( $CheckId == "" || $CheckPass == "" || preg_match("/\s/u", $CheckId) || preg_match("/\s/u", $CheckPass) )
		{
			error("관리자 아이디/비밀번호는 공백없이 입력해주세요.");
			exit;
		}

		$pattern1	= "/[0-9]/u";
		$pattern2	= "/[a-z]/u";
		$pattern3	= "/[\~\!\@\#\$\%\^\&\*\(\)\_\+\|\<\>\?\:\{\}]/u";

		if ( strlen($CheckPass) < 8 || !preg_match($pattern1, $CheckPass) || !preg_match($pattern2, $CheckPass) || !preg_match($pattern3,$CheckPass) )
		{
			error("관리자 비밀번호는 8자리 이상 영문, 숫자, 특수문자 조합으로 입력해주세요.");
			exit;
		}

		if ( $CheckId == $CheckPass )
		{
			error("관리자 아이디와 비밀번호는 동일하게 설정할 수 없습니다.");
			exit;
		}
		# 보안패치 2023-01-02 / 관리자 비밀번호 강화

		$db_connect	= true;
		$msg		= "저장되었습니다.";

		$db2 = @mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass'],true);
		if (!$db2)
		{
			$db_connect	= false;
			$msg	= "SQL 접속 정보를 \\nHost : ".$_POST['db_host']."\\nId/Password : ".$_POST['db_user']. "/".$_POST['db_pass']."로 변경하려고 하였으나 \\nDB 연결에 실패하여 업데이트 하지 않습니다.\\n\\nDB접속정보를 변경하고자 하시는 경우에는 \\nDB 접속정보를 확인하신후 다시 설정을 해주세요.";
		}
		else if (!@mysql_select_db($_POST['db_name'], $db2))
		{
			$db_connect	= false;
			$msg	= "SQL DB명을 " .$_POST['db_name']."로 변경하려고 하였으나 \\nDB 연결에 실패하여 업데이트 하지 않습니다.\\n\\nDB접속정보를 변경하고자 하시는 경우에는 \\nDB 접속정보를 확인하신후 다시 설정을 해주세요.";
		}
		else
		{
			$Sql	= "select count(number) from $happy_config where conf_value != ''";
			if (!$Result_check = @mysql_query($Sql, $db2))	{
				$db_connect	= false;
				$msg	= $_POST['db_name']." DB에는 주요 테이블이 확인되지 않아 업데이트 하지 않습니다.\\n\\nDB접속정보를 변경하고자 하시는 경우에는 \\nDB 데이터를 확인하신후 다시 설정을 해주세요.";
			}
			else
			{
				$Temp	= mysql_fetch_array($Result_check);
				$Total	= $Temp[0];
				if ($Total == 0)
				{
					$db_connect	= false;
					$msg	= $_POST['db_name']." DB에는 저장된 데이터가 없어 업데이트 하지 않습니다.\\n\\nDB접속정보를 변경하고자 하시는 경우에는 \\nDB 데이터를 확인하신후 다시 설정을 해주세요.";
				}
			}
		}

		if ($db_connect	== false)
		{
			$_POST["db_host"]	= $db_host;
			$_POST["db_user"]	= $db_user;
			$_POST["db_pass"]	= $db_pass;
			$_POST["db_name"]	= $db_name;
		}
		else
		{
			if ($_POST["db_host"] != $db_host || $_POST["db_user"] != $db_user || $_POST["db_pass"] != $db_pass || $_POST["db_name"] != $db_name)
			{
				// connect to database
				if (!$db = @mysql_connect($_POST["db_host"], $_POST["db_user"], $_POST["db_pass"])) {
					echo ( "Unable to connect to database !<br>\n" . mysql_errno() . " <- 오류번호<hr>$sql<hr>" . mysql_error() .  "<br>") ;
				}
				else {
					// Select DB
					if (!@mysql_select_db($_POST["db_name"], $db)) {
						echo ( "Unable to connect to database !<br>\n" . mysql_errno() . " <- 오류번호<hr>$sql<hr>" . mysql_error() .  "<br>") ;
					}
				}
			}
		}

		################################################################################
		#inc/config.php 파일을 수정해야 하는 부분
		$config_content = "
		\$site_name=\"$_POST[site_name]\";
		\$master_name=\"$_POST[master_name]\";
		\$db_host=\"$_POST[db_host]\";
		\$db_user=\"$_POST[db_user]\";
		\$db_pass=\"$_POST[db_pass]\";
		\$db_name=\"$_POST[db_name]\";
		\$path=\"$_POST[path]\";
		\$org_path=\"$mod_admin_etc1\";
		\$img_url=\"$mod_main_url\";
		\$main_url=\"$mod_main_url\";
		\$cookie_url=\"$mod_main_cookie\";
		\$wys_url=\"$_POST[wys_url]\";
		include_once('happy_function.php');
		\n";
		$file=@fopen("../inc/config.php","w") or Error("config.php 파일을 열 수 없습니다..\\n \\n디렉토리의 퍼미션을 707로 주십시오");
		@fwrite($file,"<?php $config_content ?>") or Error("config.php 수정 실패 \\n \\n디렉토리의 퍼미션을 707로 주십시오");
		@fclose($file);

		################################################################################
		#inc/config.php 파일을 수정해야 하는 부분

		$sql = "update $admin_tb
					set
						admin_id='$mod_admin_id',
						admin_pw='$mod_admin_pw',
						admin_email='$mod_admin_email',
						admin_name='$mod_admin_name',
						bbs_ad_id='$mod_bbs_ad_id',
						bbs_ad_pw='$mod_bbs_ad_pw',
						main_url='$mod_main_url',
						pagenum='$mod_pagenum',
						mainnum='$mod_mainnum',
						gu_mainnum='$mod_gu_mainnum',
						pay_guin='$mod_pay_guin',
						main='$mod_main',
						admin_default='$mod_admin_default',
						admin_info_guin='$mod_admin_info_guin',
						admin_info_guzic='$mod_admin_info_guzic',
						guin_list='$mod_guin_list',
						guzic_list='$mod_guzic_list',
						bbs='$mod_bbs',
						admin_etc1='$mod_admin_etc1',
						admin_etc2='$mod_admin_etc2',
						admin_etc3='$mod_admin_etc3',
						admin_etc4='$mod_admin_etc4' ,
						cookie_url = '$mod_main_cookie' ,
						guin_term = '$guin_term' ,
						guzic_term = '$guzic_term'
					";

		#로그아웃
		setcookie("ad_id","",0,"/",$cookie_url);
		setcookie("ad_pass","",0,"/",$cookie_url);
		#로그아웃
		#로그인
		setcookie("ad_id","$mod_admin_id",0,"/",$mod_main_cookie);
		setcookie("ad_pass",md5($mod_admin_pw),0,"/",$mod_main_cookie);
		#로그인

		$result = query($sql);

		gomsg($msg,"$PHP_SELF?mode=info_mod");
		//include ("tpl_inc/top_new.php");

		//go("$PHP_SELF?mode=info_mod");
	}

	include ("tpl_inc/bottom.php");

?>