<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( $CONF['kcb_adultcheck_use'] == '1' || $mode == "adult_check")
	{
		$name	= $_POST[name];
		$ssn	= $_POST[joomin1].$_POST[joomin2];
		$ju1	= preg_replace("/\D/","",$_POST['joomin1']);
		$ju2	= preg_replace("/\D/","",$_POST['joomin2']);

		//KCB실명인증을 사용하면
		if ( $HAPPY_CONFIG['kcb_namecheck_use'] == "1" )
		{
			$cmd="./namecheck/okname $name $ssn $kcb_mid $qryBrcCd $qryBrcNm $qryId $qryKndCd $qryRsnCd $qryIP $qryDomain $qryDt $EndPointURL >/dev/null";
			system($cmd,$ret);

			# aaa.com 테스트용 #
			if ( preg_match("/".base64_decode("YWFhLmNvbQ==")."|adultjob2.cgimall.co.kr/",$_SERVER['HTTP_HOST']) )
			{
				$ret = 0;
			}
			# aaa.com 테스트용 종료 #

			if ($ret != '0')
			{
				error("성인인증에 실패하였습니다. 다시 시도해주세요.\\n\\n에러번호 [$ret]");
				exit;
			}
		}

		$birth_year	= substr($ju1,0,2);

		# 30년보다 작을경우 2000년이후로 계산 #
		if ( $birth_year < 30 )
		{
			$birth_year	= $birth_year + 2000;
		}
		# 30년보다 클경우 1900년대로 계산 #
		else
		{
			$birth_year	= $birth_year + 1900;
		}



		$now_year	= date("Y");
		$chk_year	= $now_year - 19;


		if ( $chk_year < $birth_year )
		{
			error("성인만 이용가능 합니다.");
			exit;
		}
		else
		{
			setcookie("job_adultcheck",$ju1,0,"/",$cookie_url);
			setcookie("adult_check","OK",0,"/",$cookie_url);

			//성인인증결과 저장
			$login_id = happy_member_login_check();
			if ( $login_id != "" )
			{
				happy_member_option_set($happy_member_option_type,$login_id,'is_adult',1,'int(11)');
			}
			//성인인증결과 저장


			if ($_REQUEST["go_url"] != "")
			{
				$go_url = urldecode($_REQUEST["go_url"]);
				go($go_url);
			}
			else
			{
				go("./index.php");
			}


			exit;
		}
	}
	else
	{
		gomsg("성인인증 설정이 OFF로 되어있습니다.","./index.php");
		exit;
	}

?>