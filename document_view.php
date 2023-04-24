<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( !happy_member_secure($happy_member_secure_text[0].'보기') )
	{
		if ( $happy_member_login_value == '' )
		{
			gomsg("로그인을 해주세요.","happy_member_login.php");
			exit;
		}
		else
		{
			error($happy_member_secure_text[0].'보기'." 권한이 없습니다.");
			exit;
		}
	}

	$number	= preg_replace("/\D/","",$_GET["number"]);

	$sql = "select * from $per_document_tb where number = '$number'";
	$result = query($sql);
	$DETAIL = happy_mysql_fetch_assoc($result);

	// 온라인 입사지원한 이력서를 볼 때
	$bNumber	= preg_replace("/\D/","",$_GET["bNumber"]);
	if ( $bNumber != "" )
	{
		if ( !admin_secure("구인리스트") )
		{
			$sql		= "SELECT * FROM $com_guin_per_tb WHERE number = '$bNumber'";
			$result		= query($sql);
			$onLineData	= happy_mysql_fetch_assoc($result);

			if ( $onLineData['number'] == "" )
			{
				gomsg("잘못된 접근입니다.","index.php");
				exit;
			}

			if ( $happy_member_login_value == '' )
			{
				$returnUrl = urlencode($_SERVER['REQUEST_URI']);
				//gomsg("로그인이 필요한 페이지입니다.","happy_member_login.php?returnUrl=$returnUrl");
				go("happy_member_login.php?returnUrl=$returnUrl");
				exit;
			}
			else if ( $happy_member_login_value != $onLineData['com_id'] )
			{
				gomsg("잘못된 접근입니다.","index.php");
				exit;
			}
		}
	}

	//생년월일 추가
	$user_age_chk			= (date("Y") - $DETAIL['user_birth_year'] + 1);
	if ( $DETAIL['number'] != "" && $DETAIL['user_age'] != $user_age_chk )
	{
		$sql = "UPDATE $per_document_tb SET user_age = '".$user_age_chk."' WHERE number = '$number' ";
		query($sql);
	}

	//성인인증 여부
	$adult_check = happy_adult_check();
	if ( $adult_check != "1" && $DETAIL['use_adult'] )
	{
		#echo $_SERVER['REQUEST_URI']; exit;
		$go_url = urlencode($_SERVER['REQUEST_URI']);

		if ( happy_member_login_check() != "" )
		{
			gomsg("회원로그인 이후 성인인증을 1번이라도 하셔야 합니다.","$main_url/html_file.php?file=adultcheck_only.html&file2=login_default.html&mode=adult_check&go_url=$go_url");
		}
		else
		{
			gomsg("성인인증을 하셔야 합니다.", "$main_url/html_file.php?file=adultcheck.html&file2=login_default.html&mode=adult_check&go_url=$go_url");
		}
		exit;
	}
	//성인인증 여부



	if ( $number == '' )
	{
		error("필요한 매개변수가 넘어오지 않았습니다.");
		exit;
	}
	else
	{
		$HappyTodayGuzic	= $_COOKIE["HappyTodayGuzic"];

		//쿠키 정리 및 시간 지난건 지우기 (오늘본 채용정보)
		$timeChk	= happy_mktime() - 86400;
		$nowNumChk	= "no";
		$cookieVal	= "";

		$arr		= explode(",",$HappyTodayGuzic);
		for ( $i=0, $Count=0, $max=sizeof($arr) ; $i<$max ; $i++ )
		{
			$tmp	= explode("_",$arr[$i]);
			if ( $tmp[1] > $timeChk )
			{
				$cookieVal	.= ( $Count == 0 )?"":",";
				$cookieVal	.= $arr[$i];
				if ( $number == $tmp[0] )
				{
					$nowNumChk	= "ok";
				}
				$Count++;
			}
		}
		if ( $nowNumChk != "ok" )
		{
			$cookieVal	.= ( $Count == 0 )?"":",";
			$cookieVal	.= $number ."_". happy_mktime();
		}

		cookie("HappyTodayGuzic",$cookieVal,1);
		$_COOKIE["HappyTodayGuzic"]	= $cookieVal;
		#echo $_COOKIE["HappyTodayGuzic"]."<hr>";
	}


	if ($Data[job_type1])
	{
		$add_location1 = " > <a href=guin_list.php?guzic_jobtype1=$Data[type1]>".$TYPE[$Data['job_type1']] . "</a>";
	}

	if ($Data[job_type_sub1])
	{
		$add_location2 = " > <a href=guin_list.php?guzic_jobtype1=$Data[type1]&guzic_jobtype2=$Data[job_type_sub1]>". $TYPE_SUB[$Data["job_type_sub1"]] . "</a>";
	}
	$현재위치	= " $prev_stand > <a href='guzic_list.php?k=1$searchMethod'>인재정보</a> > <a href='document_view.php?number=$_GET[number]$searchMethod2'>인재정보보기</a> $add_location1 $add_location2";


	$mainTemplate	= "doc_view_main.html";
	$workTemplate	= "doc_view_work.html";
	$skillTemplate	= "doc_view_skill.html";
	$langTemplate	= "doc_view_lang.html";
	$yunsooTemplate	= "doc_view_yunsoo.html";
	$schoolTemplate	= "doc_view_school.html";

	if ( $_GET["viewfile"] != "" && eregi(".html",$_GET["viewfile"]) )
	{
		$mainTemplate	= $_GET["viewfile"];
	}
	//echo $mainTemplate;


	# 프린트 버튼
	if ( $_GET['nowPrint'] == '1' )
	{
		$defaultTemplate	= 'default_regist_print.html';
		$프린트버튼			= "<script>window.print();</script><a href='#print' onClick=\"window.print();\"><img src='img/print_btn_guin.gif' border='0' align='absmiddle' alt='프린트'></a>";
		$프린트버튼1			= "<script>window.print();</script><a href='#print' onClick=\"window.print();\"><img src='img/print_btn_guzic.gif' border='0' align='absmiddle' alt='프린트'></a>";
	}
	else
	{
		$defaultTemplate	= 'default_regist.html';
		$프린트버튼			= "<a href='#print' onClick=\"guinPrint = window.open('?number=$_GET[number]&nowPrint=1','guin_print','width=800,height=600,scrollbars=yes,toolbar=no');\"><img src='img/print_btn_guin.gif' border='0' align='absmiddle' alt='프린트'></a>";
		$프린트버튼1			= "<a href='#print' onClick=\"guinPrint = window.open('?number=$_GET[number]&nowPrint=1','guin_print','width=800,height=600,scrollbars=yes,toolbar=no');\"><img src='img/btn_in_print_02.gif' border='0' align='absmiddle' alt='프린트'></a>";
	}



	//kakao
	$상세설명텍스트2 = kstrcut(nl2br($DETAIL['profile']),132,"...");
	$상세설명_카카오스토리 = str_replace("\n","",str_replace("\r","",$상세설명텍스트2));

	//카카오스토리
	$site_name1 = $site_name;

	//카카오스토리 & 카톡으로 보낼 이미지1
	$kakao_story_img	= "";
	$story_img			= array();
	$story_img[0]		= "";

	if ( !preg_match("/(http|https):\/\//",$DETAIL['user_image']) )
	{
		$story_img[0]		= $DETAIL['user_image'];
	}
	$src_thumb			= happy_image("story_img.0",300,200,"로고사용안함","로고위치7번","100","gif원본출력",$HAPPY_CONFIG['ImgNoImage1'],"비율대로확대","2");
	$kakao_story_img	= $main_url."/".$src_thumb;
	//echo $kakao_story_img;

	$title_img			= array();
	$title_img[0]		= $DETAIL['user_image'];


	//관리자일때 네이버블로그전송내용 작성
	if ( admin_secure('슈퍼관리자전용') && is_file("$skin_folder/naver_blog_documentview.html") !== false )
	{
		$TPL->define("네이버블로그전송내용", "$skin_folder/naver_blog_documentview.html");
		$네이버블로그전송내용	= &$TPL->fetch('네이버블로그전송내용');
	}

	#echo "$mainTemplate, $workTemplate, $skillTemplate, $langTemplate, $yunsooTemplate, $schoolTemplate";

	$SMS포인트 = happy_member_option_get($happy_member_option_type,$user_id,'guin_smspoint');
	//$SMS포인트 = happy_member_option_get($happy_member_option_type,$user_id,'guzic_smspoint');
	$SMS포인트 = @number_format($SMS포인트);

	$내용	= document_view( $mainTemplate, $workTemplate, $skillTemplate, $langTemplate, $yunsooTemplate, $schoolTemplate );

	$TPL->define("상세보기화면껍데기", "./$skin_folder/$defaultTemplate");
	$TPL->assign("상세보기화면껍데기");
	echo $TPL->fetch("상세보기화면껍데기");

	exit;



?>