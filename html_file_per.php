<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");
	guzic_search_form();

	if ( $happy_member_login_value == "" )
	{
		gomsg("로그인 후 이용하세요","./happy_member_login.php");
		exit;
	}

	$happy_member_login_id	= happy_member_login_check();

	$Member					= happy_member_information($happy_member_login_id);
	$member_group			= $Member['group'];

	$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
	$Group					= happy_mysql_fetch_array(query($Sql));

	$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
	$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
	$Template				= $happy_member_skin_folder.'/'.$Template;

	//솔루션마다 다름
	################################################################################
	//일반회원영역
	$아이디		= $Data['user_id'];
	$이름		= $Data['user_name'];
	$닉네임		= $Data['user_nick'];
	$이메일		= $Data['user_email'];
	$휴대폰		= $Data['user_hphone'];
	$사진		= "<img src=".$Data['photo1']." border=0 width='$PERPOTHO_DST_W[0]' height='$PERPOTHO_DST_H[0]' onError=this.src='img/noimage_del.jpg'>";

	$mem_photo = $사진;
	$MEM['id'] = $Data['user_id'];
	$MEM['per_birth'] = $Data['user_birth_year']."-".$Data['user_birth_month']."-".$Data['user_birth_day'];
	$MEM['per_phone'] = $Data['user_phone'];
	$MEM['per_cell'] = $Data['user_hphone'];
	$MEM['per_email'] = $Data['user_email'];
	$MEM['per_zip'] = $Data['user_zip'];
	$MEM['per_addr1'] = $Data['user_addr1'];
	$MEM['per_addr2'] = $Data['user_addr2'];
	$MEM['etc1'] = $Data['photo1'];
	$MEM['point_comma'] = number_format($MEM['point']);

	$Sql	= "SELECT viewListCount,fileName1,fileName2,fileName3,fileName4,fileName5 FROM $per_document_tb WHERE user_id='$user_id' ";
	$Record	= query($Sql);

	$fileCount_doc	= 0;
	$fileCount_img	= 0;
	$fileCount_etc	= 0;
	$viewCount		= 0;
	$docCount		= 0;
	while ( $Data2 = happy_mysql_fetch_array($Record) )
	{
		$docCount++;
		$viewCount	+= $Data2["viewListCount"];

		for ( $i=1 ; $i<=5 ; $i++ )
		{
			$file	= $Data2["fileName".$i];
			$tmp	= explode(".",$file);
			$file	= strtolower( $tmp[sizeof($tmp)-1] );
			if ( $file=="jpg" || $file=="jpeg" || $file=="gif" || $file=="png" )
			{
				$fileCount_img++;
			}
			else if ( $file=="txt" || $file=="doc" || $file=="hwp" || $file=="xls" || $file=="cvs" || $file=="ppt" )
			{
				$fileCount_doc++;
			}
			else if ( $file!="" )
			{
				$fileCount_etc++;
			}
		}
	}

	$이력서수			= $docCount;
	$문서첨부파일수		= $fileCount_doc;
	$이미지첨부파일수	= $fileCount_img;
	$기타첨부파일수		= $fileCount_etc;
	$이력서열람기업수	= $viewCount;

	$file		= $_GET["file"];
	$tmp		= explode(".",$file);
	$file_ext	= $tmp[sizeof($tmp)-1];
	if ( $file_ext != "html" && $file_ext != "htm" && strlen($file) > 0 )
	{
		echo "파일명이 잘못되었습니다.";
		exit;
	}
	$file		= str_replace($file_ext,"",$file);
	$file		= preg_replace("/\W/","",$file) .".". $file_ext;


	//이력서 열람관리 > 기업회원 마이페이지 분류에 속함 (YOON : 2011-08-18)
	if ($_GET["mode"] == "today_view_recruit")
	{
		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "today_view_recruit.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//전체 이력서
	else if ($_GET["mode"] == "resume_my_manage")
	{
		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error("회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "resume_my_manage.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//공개 이력서
	else if ($_GET["mode"] == "resume_open")
	{
		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error("회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "resume_open.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//대기이력서
	else if ($_GET["mode"] == "resume_wait")
	{
		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error("회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "resume_wait.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//신입.공채 채용정보
	else if ($_GET["mode"] == "per_recruit_new")
	{
		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error("회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "per_recruit_new.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//입사지원 채용정보
	else if ($_GET["mode"] == "resume_job_application")
	{

		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error("회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "resume_job_application.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//온라인 입사지원 채용정보 : YOON : 2011-10-06
	else if ($_GET["mode"] == "resume_job_application_online")
	{

		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error("회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "resume_job_application_online.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//이메일 입사지원 채용정보 : YOON : 2011-10-06
	else if ($_GET["mode"] == "resume_job_application_email")
	{
		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error("회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "resume_job_application_email.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//열람가능 채용정보
	else if ($_GET["mode"] == "per_guin_view")
	{
		$happy_member_login_id	= happy_member_login_check();

		if ( $happy_member_login_id == "" )
		{
			error("회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "per_guin_view.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");

		$Sql			= "select count(*) from $guin_tb AS A INNER JOIN $job_per_guin_view_tb as B ON A.number = B.guin_number where B.per_id = '$user_id'  ";
		$Record			= query($Sql);
		$PGV			= mysql_fetch_row($Record);
		$열람가능개수	= $PGV[0];

	}
	//결제성공 알림 페이지
	else if ($_GET["mode"] == "my_pay_success")
	{
		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
		";

		$file		= "my_pay_success_per.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	//무통장입금으로 결제했을 때 나오는 계좌번호 안내페이지 (YOON : 2011-10-14)
	else if ($_GET["mode"] == "bank_number")
	{


		$현재위치	= "
						<table cellspacing='0' style='width:100%;'>
						<tr>
							<td align='right'>
								<table cellspacing='0'>
								<tr>
									<td><img src='./img/icon_home.gif' alt='아이콘'></td>
									<td class='font_st_11'>&nbsp;홈 > <a href='./happy_member.php?mode=mypage'>마이페이지</a></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>

		";

		$file		= "my_pay_bank_number_per.html";
		$tmp		= explode(".",$file);
		$file_ext	= $tmp[sizeof($tmp)-1];
		$file		= str_replace($file_ext,"",$file);
		$file		= preg_replace("/\W/","",$file) .".". $file_ext;

		$TPL->define("상세", "./$skin_folder/$file");
	}
	else
	{
		//보안패치 hong
		if ( !is_file("./$skin_folder_file/$file") )
		{
			echo "./$skin_folder_file/$file 파일이 존재하지 않습니다.";
			exit;
		}

		$TPL->define("상세", "./$skin_folder_file/$file");
	}

	if ( $_GET['file2'] != '' )
	{
		$file2		= $_GET["file2"];
		$tmp		= explode(".",$file2);
		$file2_ext	= $tmp[sizeof($tmp)-1];
		if ( $file2_ext != "html" && $file2_ext != "htm" && strlen($file2) > 0 )
		{
			echo "파일명이 잘못되었습니다.";
			exit;
		}
		$file2		= str_replace($file2_ext,"",$file2);
		$file2		= preg_replace("/\W/","",$file2) .".". $file2_ext;

		$Template_Default	= $file2;
	}

	$TPL->assign("상세");
	$내용 = &$TPL->fetch();


	$fullTemp	= ( $_GET["file"] == "login.html" )?$skin_folder_file."/login_default.html":$skin_folder."/".$Template_Default;

	$TPL->define("껍데기", $fullTemp);
	$TPL->assign("껍데기");
	echo $TPL->fetch();

	exit;



?>