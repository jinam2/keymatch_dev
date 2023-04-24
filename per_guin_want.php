<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");
	guzic_search_form();


	$happy_member_login_id	= happy_member_login_check();

	$Member					= happy_member_information($happy_member_login_id);
	$Data					= $Member;

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


	#입사제의 이력서 삭제 추가
	if ( $_GET['mode'] == "del" && $_GET['cNumber'])
	{
		if( $jiwon_type == 'per_want' )
		{
			$sql = "select * from $per_want_doc_tb where number = '$_GET[cNumber]'";
			$result = query($sql);
			$WANT = happy_mysql_fetch_assoc($result);
		}
		else
		{
			$sql = "select * from $com_want_doc_tb where number = '$_GET[cNumber]'";
			$result = query($sql);
			$WANT = happy_mysql_fetch_assoc($result);
		}

		//echo "$WANT[per_id] != $MEM[id]";
		if ( $WANT['per_id'] != $MEM['id'] )
		{
			error("입사지원 이력서를 삭제할 권한이 없습니다");
			exit;
		} else {

			if( $jiwon_type == 'per_want' )
			{
				$sql = "delete from $per_want_doc_tb where number = '$_GET[cNumber]'";
				query($sql);
				gomsg("면접제의 내역을 삭제하였습니다.","per_guin_want.php?mode=preview");
			}
			else
			{
				$sql = "delete from $com_want_doc_tb where number = '$_GET[cNumber]'";
				query($sql);
				gomsg("입사제의 내역을 삭제하였습니다.","per_guin_want.php");
			}
			exit;
		}
	}
	else
	{
		$sql01 = "SELECT count(*) FROM job_guin AS A INNER JOIN job_scrap AS B ON A.number = B.cNumber WHERE ( A.guin_end_date >= curdate() OR A.guin_choongwon = '1' ) AND B.userid = '$user_id'";

		list($scrap_cnt) = mysql_fetch_row(query($sql01));
		$채용정보스크랩수 = number_format($scrap_cnt);

		$sql01 = "select count(*) from $com_want_doc_tb where per_id = '$user_id'";
		list($면접제의요청) = mysql_fetch_row(query($sql01));

		if( !$mode )
		{
			$현재위치 = "$prev_stand > <a href='./happy_member.php?mode=mypage'>마이페이지</a> > 입사제의받은 채용공고
					";

			$file	= "member_want_guin_list.html";
		}
		else
		{
			$현재위치 = "$prev_stand > <a href='./happy_member.php?mode=mypage'>마이페이지</a> > 면접제의받은 채용공고
					";
			$file	= "member_want_guin_list2.html";
		}

		$TPL->define("상세", "$skin_folder/$file");
		$TPL->assign("상세");
		$내용 = &$TPL->fetch();

		//echo $file;
		$fullTemp	= ( $_GET["file"] == "login.html" )?$skin_folder_file."/login_default.html":$skin_folder."/".$Template_Default;

		$TPL->define("껍데기", $fullTemp);
		$TPL->assign("껍데기");
		echo $TPL->fetch();

	}
?>