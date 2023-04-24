<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] )
	{
		gomsg("로그인 후 이용하세요","./happy_member_login.php");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[0].'열람불가 설정') )
	{
		error($happy_member_secure_text[0].'열람불가 설정'."권한이 없습니다.");
		exit;
	}

	$현재위치 = "$prev_stand > <a href='per_no_view_list.php'>열람불가회사 설정하기</a>";

	if ( $mode == "" )
	{
		$template	= "job_per_noviewlist.html";
		$template3	= "job_per_noviewlist_serows.html";


		$Sql	= "
				SELECT
						a.*
				FROM
						$happy_member a
						LEFT JOIN
						$per_noViewList b
				ON
						a.user_id = b.com_id
				WHERE
						b.per_id = '$user_id'
				ORDER BY
						b.number
		";
		//echo $Sql;

		$Record	= query($Sql);

		$template2	= "job_per_noviewlist_serows.html";
		$Content	= "";
		$Count		= 0;

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Count++;

			/*
			$Data['id'] = $Data['user_id'];
			$Data['main_item'] = $Data['extra14'];
			*/
			$rand		= rand(0,10000);

			$회사명		= $Data['com_name'];
			$업종		= $Data['extra13'];
			$대표자		= $Data['extra11'];
			$직원수		= $Data['extra2']."명";
			$설립연도	= $Data['extra1']."년";
			$주소		= $Data['user_addr1']." ".$Data['user_addr2']." (".$Data['user_zip'].")";

			$TPL->define("열람불가리스트".$rand, "$skin_folder/$template3");
			$TPL->assign("열람불가리스트".$rand);
			$Content .= $TPL->fetch();
		}

		if ( $Count == 0 )
		{
			$Content	= "<div align='center' style='padding:10px; color:#909090;' class='font_st_11'>열람불가로 설정된 회사가 없습니다</div>";
		}

		$열람불가리스트	= $Content;
		$mode			= "del";

	}

####################################################################################################################################








####################################################################################################################################

	//echo "$skin_folder/$template";
	$TPL->define("본문내용", "$skin_folder/$template");
	$TPL->assign("본문내용");
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


	$TPL->define("껍데기", "$skin_folder/$Template_Default");
	$TPL->assign("껍데기");
	$ALL = &$TPL->fetch();
	echo $ALL;


?>