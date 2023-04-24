<?php
	$t_start = array_sum(explode(' ', microtime()));

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	#load_config();

	$happy_member_login_id	= happy_member_login_check();

	if( $happy_member_login_id == ""  ) {
		$returnUrl = $_SERVER['PHP_SELF']."?mode=".$_GET['mode'];

		gomsg("로그인후 이용가능합니다.",$main_url."/happy_member_login.php?returnUrl=".$returnUrl);
		#gomsg("회원로그인후 사용할수 있는 페이지입니다","index.php");
		exit;
	}

	$mode					= ( $_GET['mode'] != "" ) ? $_GET['mode'] : $_POST['mode'];
	$number					= ( $_GET['number'] != "" ) ? $_GET['number'] : $_POST['number'];;

	if ( $number == "" )
	{
		error("문의 고유번호가 없습니다.");
		exit;
	}

	$Sql				= "SELECT * FROM $happy_inquiry WHERE number = '$number' ";
	$Result				= query($Sql);
	$Data				= happy_mysql_fetch_array($Result);

	if ( $Data['number'] == "" )
	{
		error("문의 내용이 없습니다.");
		exit;
	}

	$no_links_display	= "";
	if ( $Data['links_number'] == "" || $Data['links_number'] == 0 )
	{
		$no_links_display	= " display:none; ";
	}

	$Sql				= "SELECT * FROM $happy_inquiry_links WHERE number='$Data[links_number]' ";
	$Result				= query($Sql);
	$Links				= happy_mysql_fetch_array($Result);

	$고유번호			= $number;
	$담당자			= ( $Links['guin_name'] == "" )	? "정보없음" : $Links['guin_name'];
	$메일주소			= ( $Links['guin_email'] == "" )		? "정보없음" : $Links['guin_email'];
	$연락처				= ( $Links['guin_phone'] == "" )		? "정보없음" : $Links['guin_phone'];
	$채용정보제목				= $Links["guin_title"];
	$업체이미지			= $Links["photo2"];

	$TPL->define("댓글쓰기", "$skin_folder/happy_inquiry_view_comment_reg.html");
	$댓글쓰기 = &$TPL->fetch();

	switch ( $mode )
	{
		case 'upche' :
		{
			if ( !happy_member_secure( $happy_member_secure_text[1].'문의' ) )
			{
				error('권한이 없습니댜.');
				exit;
			}
			else if ( $happy_member_login_id != $Data['receive_id'] )
			{
				error('권한이 없습니다.');
				exit;
			}
			else
			{
				if ( $Data['stats'] == '0' )
				{
					//접수확인 상태로 자동변경
					query("UPDATE $happy_inquiry SET stats = '1' WHERE number = '$number' ");
					$Data['stats']		= '1';
				}

				if ( $_GET['action'] == "stats_mod" )
				{
					query("UPDATE $happy_inquiry SET stats = '$_GET[stats]' WHERE number = '$number' ");
					go("happy_inquiry_view.php?mode=$_GET[mode]&number=$_GET[number]");
					exit;
				}
			}

			$templateFile		= "happy_inquiry_view_upche.html";
			$now_page_title		= "내가 받은 문의내역";

			//처리상태 변경
			$처리상태			= make_selectbox2($happy_inquiry_stats_array,array_keys($happy_inquiry_stats_array),"-- 처리상태 --",'stats',$Data['stats'],'120');
			break;
		}

		case 'normal' :
		{
			if ( !happy_member_secure( $happy_member_secure_text[1].'문의' ) )
			{
				error('권한이 없습니다.');
				exit;
			}
			else if ( $happy_member_login_id != $Data['send_id'] )
			{
				error('권한이 없습니다.');
				exit;
			}

			$templateFile		= "happy_inquiry_view_normal.html";
			$now_page_title		= "내가 보낸 문의내역";
			break;
		}

	}



	$현재위치 = "<a href='".$main_url."' class='now_location_link'>홈</a> &gt; <a href='happy_member.php?mode=mypage' class='now_location_link'>마이페이지</a> &gt; <a href='happy_inquiry_list.php?mode=$mode'>$now_page_title</a> > 상세보기";


	if( !(is_file("$skin_folder/$templateFile")) ) {
		print "$skin_folder/$templateFile 파일이 존재하지 않습니다. ";
		exit;
	}

	$TPL->define("알맹이", "$skin_folder/$templateFile");
	$내용 = &$TPL->fetch();

	# 유저그룹별 껍데기 파일 추출	2010-06-29 ralear
	$Member			= happy_member_information(happy_member_login_check());
	$member_group	= $Member['group'];

	$sql			= "select * from $happy_member_group where number='$member_group'";
	$result			= query($sql);
	$Data			= happy_mysql_fetch_array($result);
	$default_skin	= $Data['mypage_default'];
	$default_skin	= $default_skin == '' ? $happy_member_mypage_default_file : $default_skin;

	if( !(is_file("$skin_folder/$default_skin")) ) {
		print "$skin_folder/$default_skin 파일이 존재하지 않습니다. ";
		exit;
	}

	$TPL->define("리스트", "$skin_folder/$default_skin");
	$TPL->assign("리스트");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();


?>