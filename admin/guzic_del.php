<?

	include ("../inc/config.php");

	include ("../inc/function.php");
	include ("../inc/lib.php");


	if ( !admin_secure("구인리스트") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	$num	= $_GET["number"];


	// 파일삭제 - 2015-09-30 - x2chi
	// user_image 는 여러 곳에서 공유되는 이미지 이므로 삭제 제외 - x2chi
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

	$Sql	= "delete from $per_document_tb where number='$num' ";
	query($Sql);




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

	gomsg("삭제되었습니다. ","guin.php?a=guzic&mode=list");
?>