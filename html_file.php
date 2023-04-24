<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");
	guzic_search_form();

	if ( happy_member_login_check() != "" )
	{
		//회원 정보
		$sql = "select * from $happy_member where user_id='$user_id' ";
		$result = query($sql);
		$MEM = happy_mysql_fetch_array($result);
		$MEM[level] = '1';

		$MEM['point_comma'] = number_format($MEM['point']);

		$MEM['etc1'] = $MEM['photo1'];

		if ($MEM[etc1] == "")
		{
			$MEM[etc1] = 'no_image.gif';
		}


		$Sql	= "SELECT viewListCount,fileName1,fileName2,fileName3,fileName4,fileName5 FROM $per_document_tb WHERE user_id='$user_id' ";
		$Record	= query($Sql);

		$fileCount_doc	= 0;
		$fileCount_img	= 0;
		$fileCount_etc	= 0;
		$viewCount		= 0;
		$docCount		= 0;
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$docCount++;
			$viewCount	+= $Data["viewListCount"];

			for ( $i=1 ; $i<=5 ; $i++ )
			{
				$file	= $Data["fileName".$i];
				$tmp	= explode(".",$file);
				$file	= strtolower( $tmp[sizeof($tmp)-1] );
				if ( $file=="jpg" || $file=="jpeg" || $file=="gif" || $file=="png" )
					$fileCount_img++;
				else if ( $file=="txt" || $file=="doc" || $file=="hwp" || $file=="xls" || $file=="cvs" || $file=="ppt" )
					$fileCount_doc++;
				else if ( $file!="" )
					$fileCount_etc++;
			}
		}

		$이력서수			= $docCount;
		$문서첨부파일수		= $fileCount_doc;
		$이미지첨부파일수	= $fileCount_img;
		$기타첨부파일수		= $fileCount_etc;
		$이력서열람기업수	= $viewCount;
		$today_view_cnt2 = sizeof(explode(",", $_COOKIE["HappyTodayGuin"]));
	}

	$sql01 = "SELECT count(*) FROM job_guin AS A INNER JOIN job_scrap AS B ON A.number = B.cNumber WHERE ( A.guin_end_date >= curdate() OR A.guin_choongwon = '1' ) AND B.userid = '$user_id'";

	list($scrap_cnt) = mysql_fetch_row(query($sql01));
	$채용정보스크랩수 = number_format($scrap_cnt);

	$오늘본이력서수 = 0;
	if ( $_COOKIE["HappyTodayGuzic"] != "" )
	{
		$today_view_cnt = sizeof(explode(",", $_COOKIE["HappyTodayGuzic"]));
		$오늘본이력서수 = number_format($today_view_cnt);
	}

	$file		= $_GET["file"];
	$tmp		= explode(".",$file);
	$file_ext	= $tmp[sizeof($tmp)-1];
	if ( $file_ext != "html" && $file_ext != "htm" )
	{
		echo "파일명이 잘못되었습니다.";
		exit;
	}
	$file		= str_replace($file_ext,"",$file);
	$file		= preg_replace("/\W/","",$file) .".". $file_ext;

	//
	if($kcb_namecheck_use == '1' || $mode == "adult_check")
	{
		$TPL->define("실명인증파일", "./$skin_folder/namecheck.html");
		$nameCheck = &$TPL->fetch();
	}
	else
	{
		$TPL->define("실명인증파일", "./$skin_folder/namecheck.html");
		$nameCheck = &$TPL->fetch();
		//$nameCheck = "<form style=margin:0px name=regiform></form>";
	}


	if( $demo_lock == '1' )		//데모 로그인 기능 개선.		2018-12-13 hun
	{
		ob_start();
		main_top_menu("happy_member_demo_login.html");	//{{HTML호출 happy_member_demo_login.html}} <!--데모일때만 나타날 레이어-->
		$demo_login_layer = ob_get_contents();
		ob_end_clean();
	}

	if($_GET['mode'] == 'member_out')
	{
		$happy_member_login_id	= happy_member_login_check();
		$MEMBER = happy_member_information($happy_member_login_id);

		$id_pass_display	= "";
		$sns_member			= "";
		if ($MEMBER['sns_site'] !="")
		{
			$id_pass_display	= "display:none;";
			$sns_member			= "y";
		}

		//print_r2($MEMBER);
		$Sql = "select * from $happy_member_field where member_group = '".$MEMBER['group']."' AND field_name = 'user_jumin1'";
		$Result = query($Sql);
		$Field_data = happy_mysql_fetch_array($Result);

		if($Field_data['field_use'] == 'y' || $Field_data['field_use'] == 'Y')
		{
			$group_check = "";
			$group_script = "
					if(Obj.jumin1.value.length < 6 || Obj.jumin2.value.length < 7)
					{
						alert('정확한 주민번호를 입력해주세요.');
						return false;
					}";
		}
		else
		{
			$group_check = "style='display:none;'";
		}
	}

	if ( $_GET['search_si'] == "" && $_GET['guzic_si'] != "" )
	{
		$_GET['search_si'] = $_GET['guzic_si'];
	}

	$area_read		= $SI[$_GET['search_si']];
	$area_read_tmp	= ($area_read == "" || $_GET["search_si"] == $SI_NUMBER['전국']) ? "서울" : $area_read;
	$flash_file		= $xml_flash[$area_read_tmp];

	if ( $_GET['search_si'] == "" )
	{
		$검색지역제목 = "전체";
	}
	else
	{
		$검색지역제목 = $siSelect[$_GET['search_si']];
	}


	//모바일일때 지역검색시 지역검색부분 가리기 위해서 2013-07-22 kad
	$img_style_display_10 = "mobile_img/btn_area_on.gif";
	if ( $_GET['close_layer'] == "1" )
	{
		$style_display_10 = "display:none;";
		$img_style_display_10 = "mobile_img/btn_area_off.gif";
	}
	//모바일일때 지역검색시 지역검색부분 가리기 위해서 2013-07-22 kad



	//모바일일때 역세권검색시 역세권검색부분 가리기 위해서 2013-07-22 jini
	$img_style_display_11 = "mobile_img/btn_subway_on.gif";
	if ( $_GET['close_layer'] == "1" )
	{
		$style_display_11 = "display:none;";
		$img_style_display_11 = "mobile_img/btn_subway_off.gif";
	}
	//모바일일때 역세권검색시 역세권검색부분 가리기 위해서 2013-07-22 jini


	$sort_how = sort_how_return();

	$채용정보정렬 = $sort_how;

	$인재정보정렬 = sort_how_return('');


	if ( $file == "guin_new.html" )
	{
		if ( $career_read != "" )
		{
			$채용정보리스트제목 = $career_read;
		}
		else
		{
			$채용정보리스트제목 = "경력무관";
		}
	}






	//상단 카테고리명 출력
	$카테고리명			= Array();
	$카테고리명['1차']	= ( $_GET['guzic_jobtype1'] != "" ) ? $TYPE[$_GET['guzic_jobtype1']]		: "전체";
	$카테고리명['2차']	= ( $_GET['guzic_jobtype2'] != "" ) ? $TYPE_SUB[$_GET['guzic_jobtype2']]	: "";

	//보안패치 hong
	if ( !is_file("./$skin_folder_file/$file") )
	{
		echo "./$skin_folder_file/$file 파일이 존재하지 않습니다.";
		exit;
	}

	$TPL->define("상세", "./$skin_folder_file/$file");
	$TPL->assign("상세");
	$내용 = &$TPL->fetch();

	if (!$_GET["file2"])
	{
		$file2 = 'default.html';
	}
	else
	{
		$file2		= $_GET["file2"];
		$tmp		= explode(".",$file2);
		$file_ext	= $tmp[sizeof($tmp)-1];
		if ( $file_ext != "html" && $file_ext != "htm" )
		{
			echo "파일명이 잘못되었습니다.";
			exit;
		}
		$file2		= str_replace($file_ext,"",$file2);
		$file2		= preg_replace("/\W/","",$file2) .".". $file_ext;
	}


	//$fullTemp	= ( $_GET["file"] == "login.html" )?"login_default.html":"default.html";

	//게시판 제목 가리기 위해서 mobile_html/bbs_default.html
	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		$display_none = "display:none;";
	}

	//보안패치 hong
	if ( !is_file("./$skin_folder/$file2") )
	{
		echo "./$skin_folder/$file2 파일이 존재하지 않습니다.";
		exit;
	}

	//echo "./$skin_folder/$file2";
	$TPL->define("껍데기", "./$skin_folder/$file2");
	$TPL->assign("껍데기");
	echo $TPL->fetch();

	exit;



?>