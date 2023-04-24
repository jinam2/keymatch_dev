<?php
	$t_start = array_sum(explode(' ', microtime()));

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	#load_config();
	$mem_id					= happy_member_login_check();

	if( $mem_id == ""  ) {
		$returnUrl = $_SERVER['PHP_SELF']."?mode=".$_GET['mode'];

		gomsg("로그인후 이용가능합니다.",$main_url."/happy_member_login.php?returnUrl=".$returnUrl);
		#gomsg("회원로그인후 사용할수 있는 페이지입니다","index.php");
		exit;
	}

	$mode					= $_GET['mode'];

	switch ( $mode )
	{
		case 'upche' :
		{
			if ( !happy_member_secure( $happy_member_secure_text[1].'문의' ) )
			{
				error('권한이 없습니다.');
				exit;
			}

			$templateFile		= "happy_inquiry_list_upche.html";
			$now_page_title		= "내가 받은 문의내역";


			//검색부분 출력
			$links_title_array	= Array();
			$links_number_array	= Array();

			$Sql				= "
									SELECT
											links_number,
											links_title
									FROM
											$happy_inquiry
									WHERE
											receive_id		= '$mem_id'
									GROUP BY
											links_number
									ORDER BY
											links_title ASC

								";
			$Result				= query($Sql);

			$i					= 0;
			while ( $Tmp = happy_mysql_fetch_array($Result) )
			{
				$links_title_array[$i]	= $Tmp['links_title'];
				$links_number_array[$i]	= $Tmp['links_number'];
				$i++;
			}

			$업체명검색			= make_selectbox2($links_title_array,$links_number_array,"-- 채용정보명 검색 --",'links_number',$links_number,'120');
			$처리상태검색		= make_selectbox2($happy_inquiry_stats_array,array_keys($happy_inquiry_stats_array),"-- 처리상태 --",'stats',$stats,'120');
			break;
		}

		case 'normal' :
		{
			if ( !happy_member_secure( $happy_member_secure_text[1].'문의' ) )
			{
				error('권한이 없습니댜.');
				exit;
			}

			$templateFile		= "happy_inquiry_list_normal.html";
			$now_page_title		= "내가 보낸 문의내역";
			break;
		}
	}


	$현재위치 = "<a href='".$main_url."' class='now_location_link'>홈</a> &gt; <a href='happy_member.php?mode=mypage' class='now_location_link'>마이페이지</a> &gt; $now_page_title";


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