<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	################################################################################
	$happy_member_login_id	= happy_member_login_check();

	$Member					= happy_member_information($happy_member_login_id);
	$member_group			= $Member['group'];

	$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
	$Group					= happy_mysql_fetch_array(query($Sql));

	$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
	$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
	$Template				= $happy_member_skin_folder.'/'.$Template;


	#마이페이지에서 보여줄 회원정보
	$sql		= "select * from $happy_member where user_id='$happy_member_login_id'";
	$result		= query($sql);
	$Data		= happy_mysql_fetch_array($result);

	$naver_get_addr	= $Data['user_addr1'] ." ". $Data['user_addr2'];
	$MEM['etc1'] = $Data['photo2'];
	$MEM['etc2'] = $Data['photo3'];
	$MEM['com_job'] = $Data['extra13'];
	$MEM['com_profile1'] = nl2br($Data['message']);
	$MEM['com_profile2'] = nl2br($Data['memo']);
	$MEM['boss_name'] = $Data['extra11'];
	$MEM['com_open_year'] = $Data['extra1'];
	$MEM['com_worker_cnt'] = $Data['extra2'];
	$MEM['com_zip'] = $Data['user_zip'];
	$MEM['com_addr1'] = $Data['user_addr1'];
	$MEM['com_addr2'] = $Data['user_addr2'];

	if ( file_exists ("./$MEM[etc1]") && $MEM[etc1] != "" )
	{
		$logo_img = explode(".",$MEM["etc1"]);
		$logo_temp = $logo_img[0]."_thumb.".$logo_img[1];

		if ( file_exists ("./$logo_temp" ) )
		{
			$MEM[logo_temp] = "<img src='./$logo_temp'  align='absmiddle'  border='0'>";
		}
		else
		{
			$MEM[logo_temp] = "<img src='./$MEM[etc1]' width='$COMLOGO_DST_W[0]' height='$COMLOGO_DST_H[0]' align='absmiddle' border='0'>";
		}
	}
	else
	{
		$MEM[logo_temp] = "<img src='./img/logo_img.gif' >";
	}

	if ( file_exists ("./$MEM[etc2]") && $MEM[etc2] != "" )
	{
		$banner_img = explode(".",$MEM["etc2"]);
		$banner_temp = $banner_img[0]."_thumb.".$banner_img[1];

		if ( file_exists("./$banner_temp" ) )
		{
			$MEM[banner] = "<img src='./$banner_temp'  align='absmiddle' border='0'>";
		}
		else
		{
			$MEM[banner] = "<img src='./$MEM[etc2]' width='$COMBANNER_DST_W[0]' height='$COMBANNER_DST_H[0]' align='absmiddle' border='0'>";
		}
	}
	else
	{
		$MEM[banner] = "<img src='./img/logo_img.gif' >";
	}
	################################################################################

	#입사제의 이력서 삭제 추가
	if ( $_GET['mode'] == "del" && $_GET['cNumber'])
	{
		if( $jiwon_type == 'per_want' )
		{
			$sql				= "select * from $per_want_doc_tb where number = '$_GET[cNumber]'";
			$result				= query($sql);
			$WANT				= happy_mysql_fetch_array($result);
		}
		else
		{
			$sql				= "select * from $com_want_doc_tb where number = '$_GET[cNumber]'";
			$result				= query($sql);
			$WANT				= happy_mysql_fetch_array($result);
		}

		if ( $WANT['com_id'] != $MEM['id'] )
		{
			error("삭제할 권한이 없습니다");
			exit;
		}
		else
		{
			if( $jiwon_type == 'per_want' )
			{
				$sql = "delete from $per_want_doc_tb where number = '$_GET[cNumber]'";
				query($sql);
				gomsg("면접제의 내역을 삭제하였습니다.","com_guin_want.php?mode=perview");
			}
			else
			{
				$sql = "delete from $com_want_doc_tb where number = '$_GET[cNumber]'";
				query($sql);
				gomsg("입사제의 내역을 삭제하였습니다.","com_guin_want.php?mode=interview");
			}
			exit;
		}
	}
	else
	{





		if( $mode == "perview" )
		{
			$인재수 = $COMMEMBER["interview_cnt_comma"];

			$현재위치 = "$prev_stand > 마이페이지 > 면접제의 인재관리";
			$file	= "member_want_guin_interview_list.html";

			//YOON : 2011-11-28 - 면접제의 부분인데 면접제의는 이메일로 발송되기 때문에 제의삭제 버튼이 필요없음
			$제의삭제버튼감추기 = "none";
		}


		else if( $mode == "interview" )
		{
			$인재수 = $COMMEMBER["req_cnt_comma"];
			$제의삭제버튼감추기 = "block";

			$현재위치 = "$prev_stand > 마이페이지 > 입사제의 인재관리";
			$file	= "member_want_guin_com_list.html";
		}

		if ( !is_file("$skin_folder/$file") )
		{
			echo "$skin_folder/$file 파일이 없습니다.";
			exit;
		}

		//echo "$skin_folder/$file";
		$TPL->define("상세", "$skin_folder/$file");
		$TPL->assign("상세");
		$내용 = &$TPL->fetch();


		$fullTemp	= ( $_GET["file"] == "login.html" )?$skin_folder_file."/login_default.html":$skin_folder."/".$Template_Default;

		$TPL->define("껍데기", $fullTemp);
		$TPL->assign("껍데기");
		echo $TPL->fetch();
	}
?>