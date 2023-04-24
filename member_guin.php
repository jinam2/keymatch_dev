<?php


	#guin_wait 0 이면 그냥 출력
	#guin_wait 1 이면 대기
	#guin_wait 2 이면 마감

	include ("./inc/Template.php");
	$TPL = new Template;

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$type		= $_GET[type];
	$img_view1	= ( $type == "" )?"1":"2";
	$img_view2	= ( $type == "" )?"2":"1";

	$img_view3	= ( $type == "" )?"2":"3";
	$img_view4	= ( $type == "" )?"3":"2";

	if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] )
	{
		gomsg("로그인 후 이용하세요","./happy_member_login.php");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[1].'등록') )
	{
		error($happy_member_secure_text[1].'등록'." 권한이 없습니다.");
		exit;
	}

	if ($_GET[mode] == 'magam' )
	{
		$sql = "update $guin_tb set guin_end_date =DATE_SUB(  curdate(),  INTERVAL '1' DAY  ), guin_choongwon='' where number = '$_GET[num]'";
		$result2 = query($sql);
		gomsg('구인정보가 마감되었습니다.','member_guin.php');
		exit;
	}

	if ( $_GET["mode"] == "docok" || $_GET["mode"] == "docok_del" )
	{
		$guinNumber		= $_GET['guinNumber'];

		if ( $guinNumber != "" )
		{
			$doc_ok_val		= ( $_GET["mode"] == "docok" ) ? "Y" : "N";

			$Sql			= "UPDATE $com_guin_per_tb SET doc_ok='$doc_ok_val' WHERE pNumber='$_GET[pNumber]' AND cNumber='$guinNumber' AND com_id='$user_id' ";
			query($Sql);

			go("guzic_list.php?file=member_guin_chong&number=$guinNumber&myroom=com_yes");
		}
		else
		{
			error("오류 : 채용정보 번호 누락!");
		}
		exit;
	}

	$MEM[com_profile1] = nl2br($MEM[com_profile1]);
	$MEM[com_profile2] = nl2br($MEM[com_profile2]);

	if (  file_exists ("./upload/$MEM[etc1]") && $MEM[etc1] != "" )
	{
		$MEM[logo_temp] = "<img src='./upload/$MEM[etc1]' width=$gi_joon[0] >";
	}
	else
	{
		$MEM[logo_temp] = "<img src='./img/logo_img.gif' >";
	}

	if (  file_exists ("./upload/$MEM[etc2]") && $MEM[etc2] != "" )
	{
		$MEM[banner] = "<img src='./upload/$MEM[etc2]' width=$gi_joon[1] >";
	}
	else
	{
		$MEM[banner] = "<img src='./img/logo_img.gif' >";
	}

	if ($_GET[type] == 'magam')
	{
		$현재위치 = "$prev_stand > <a href=happy_member.php?mode=mypage>마이페이지</a> > 마감된 채용정보";
		#$TPL->define("리스트", "./$skin_folder/member_guin_magam_list.html");
		$template_file = "member_guin_magam.html";
	}
	else if ( $_GET['type'] == 'all' )
	{
		$현재위치 = "$prev_stand > <a href=happy_member.php?mode=mypage>마이페이지</a> > 모든 채용정보";
		#$TPL->define("리스트", "./$skin_folder/member_guin_list.html");
		$template_file = "member_guin_all.html";
	}
	else if ( $_GET['type'] == 'scrap' )
	{
		$현재위치 = "$prev_stand > <a href=happy_member.php?mode=mypage>마이페이지</a> > 채용정보별 인재스크랩";
		#$TPL->define("리스트", "./$skin_folder/member_guin_list.html");
		$template_file = "member_scrap.html";
	}
	else
	{
		$현재위치 = "$prev_stand > <a href=happy_member.php?mode=mypage>마이페이지</a> > 진행중인 채용정보";
		#$TPL->define("리스트", "./$skin_folder/member_guin_list.html");
		$template_file = "member_guin.html";
	}


	//$list_temp = guin_info_list();
	//echo "$skin_folder/$template_file";
	$TPL->define("기업정보", "$skin_folder/$template_file");
	$TPL->assign("기업정보");
	$내용 = &$TPL->fetch();


	$happy_member_login_id	= happy_member_login_check();

	if ( $happy_member_login_id == "" && happy_member_secure( '마이페이지' ) )
	{
		error("관리자라도 마이페이지에 접근하기 위해서는 회원으로 로그인을 하셔야 합니다.");
		exit;
	}

	$Member					= happy_member_information($happy_member_login_id);
	$member_group			= $Member['group'];

	$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
	$Group					= happy_mysql_fetch_array(query($Sql));

	$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
	$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
	$Template				= $happy_member_skin_folder.'/'.$Template;


	//echo $Template_Default;

	$TPL->define("껍데기", "./$skin_folder/$Template_Default");
	$TPL->assign("껍데기");
	$ALL = &$TPL->fetch();
	echo $ALL;
	exit;

?>