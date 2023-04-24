<?
	include ("inc/Template.php");
	$TPL = new Template;

	include ("inc/config.php");

	include ("inc/function.php");
	include ("inc/lib.php");


	$num	= $_GET["number"];


	if ( !admin_secure("구인리스트") )
	{
		$Sql	= "select user_id from $per_document_tb WHERE number='$num' ";
		$Data	= happy_mysql_fetch_array(query($Sql));

		if ( !happy_member_secure($happy_member_secure_text[0].'등록') )
		{
			error("접속권한이 없습니다.");
			exit;
		}
		else if ( $Data["user_id"] != $user_id )
		{
			error("접속권한이 없습니다.");
			exit;
		}
	}

//exit;

	// 파일삭제 - 2015-09-30 - x2chi
	//구인구직A는 하나의 사진으로 모든 이력서의 사진으로 공유해서 user_image 에 저장된 파일은 삭제하지 않도록 제거 2015-10-29 kad
	$perSQL	= "
		SELECT
			`user_id`, `fileName1`, `fileName2`, `fileName3`, `fileName4`, `fileName5`
		FROM
			".$per_document_tb."
		WHERE
			number='".$num."';
	";
	$perREG		= query($perSQL);
	$perInfo	= mysql_fetch_assoc ($perREG);

	//print_r2($perInfo);

	$re = delFiles($per_document_file."/".$perInfo['user_id']."_".$num."|","|","*");
	//echo $re;

	// 파일삭제 - 2015-09-30 - x2chi
	foreach ( $perInfo as $key => $var )
	{
		if( strlen($var) > 0 )
		{
			if ($key != "user_id" )
			{
				if ($key == "user_image" )
				{
					$files = $var;
				}
				else
				{
					$files = $per_document_file."/".$var;
				}
				$re =  delFiles($files,".","_*");
				//echo $re;
			}
		}
	}

	$sql	= "delete FROM {$per_academy_tb} WHERE doc_number = '{$num}'";
	query($sql);

	$sql	= "delete FROM {$per_career_tb} WHERE doc_number = '{$num}'";
	query($sql);

	query("delete from $per_document_tb where number='$num' ");


	// 파일삭제 - 2015-09-30 - x2chi
	$per_fileSQL	= "
		SELECT
			`fileName`
		FROM
			".$per_file_tb."
		WHERE
			doc_number = '".$num."';
	";
	$per_fileREG		= query($per_fileSQL);

	while ( $per_fileInfo	= mysql_fetch_assoc ($per_fileREG) )
	{
		//print_r2($per_fileInfo);

		// 파일삭제 - 2015-09-30 - x2chi
		foreach ( $per_fileInfo as $key => $var )
		{
			if( strlen($var) > 0 )
			{
				$re = delFiles($var,"((thumb_name))","*");
				//echo $re;
			}
		}
	}

	query("DELETE FROM $per_file_tb WHERE doc_number = '$num' ");


	//PC와 모바일모드의 페이지가 다름 - 2017-01-11 버그패치 hong
	$go_url = ( $_COOKIE['happy_mobile'] == "on" ) ? "html_file_per.php?mode=resume_open" : "html_file_per.php?file=member_regph.html";
	gomsg("삭제되었습니다. ",$go_url);
?>