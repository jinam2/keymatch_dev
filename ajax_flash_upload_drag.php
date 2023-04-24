<?

	include "./inc/config.php";
	include "./inc/function.php";
	include "./inc/Template.php";
	$TPL			= new Template;
	include "./inc/lib.php";

	//등록페이지에서 이미지를 업로드 했을 경우,
	//수정페이지가 로딩되거나 수정페이지에서 이미지를 업로드 했을 경우에만 속함



		$folder_name		= "upload/tmp/".session_id();
		$file_count			= 0;
		$file_size			= 0;
		$fileNames			= '';
		$fileNamesInput		= '';

		$upfolder			= $_POST['swf_upload_forder'];

		//수정페이지에서 로딩되었을 경우.( 이미지를 업로드하는 상황에서도 이전에 등록되어 있던 이미지를 호출해야 하므로 포함됨.
		if( $_POST[number] != '' )
		{
			$fields				= $_POST['fields'] == "" ? "fileName" : $_POST['fields'];

			$Sql				= "SELECT $fields FROM $per_file_tb WHERE doc_number = '$_POST[number]' order by number  ";
			$Record				= query($Sql);

			$tmp	= explode(",",$fields);
			$i		= 0;
			while ( $Data = happy_mysql_fetch_array($Record) )
			{
				$Data['fileName']	= str_replace("((thumb_name))","_thumb",$Data['fileName']);
				//echo $upfolder; exit;
				$fileName	= $Data['fileName'] ;

				$fileNames	.= ( $i==0 )?"":"||";
				$fileNames	.= ( $fileName == "" ) ?"":$upfolder.$fileName;

				$fileNamesInput		.= ( $i==0 )?"":"||";
				$fileNamesInput		.= ( $Data['fileName'] == "" ) ?"":$Data['fileName'];

				$i++;
			}
		}

		//이미지 업로드를 한 상황에만 관련 폴더에 업로드된 이미지를 조회함.
		if(is_dir($folder_name))
		{
			$dir_obj			=opendir($folder_name);
			while(($file_str = readdir($dir_obj))!==false)
			{
				if($file_str!="." && $file_str!=".." && eregi("_thumb",$file_str))
				{
					$fileList[]			= $file_str;
				}
				else
				{
					//echo $file_str."<br>";
					$temp_name2	= explode(".",$file_str);
					$ext2		= $temp_name2[sizeof($temp_name2)-1];
					//echo $ext2."<br>";
					if ( preg_match("/gif/i",$ext2) )
					{
						$fileList[]	= $file_str;
					}
				}
			}
			closedir($dir_obj);
			sort($fileList);

			for ( $j=0 , $max=sizeof($fileList) ; $j<$max ; $j++, $i++ )
			{
				$file_str			= $fileList[$j];
				$split_str			= explode("__swfupload__",$file_str);
				$temp_name			= explode(".",$file_str);
				$ext				= $temp_name[sizeof($temp_name)-1];

				$file_str2			= str_replace(".$ext","_thumb.$ext",$file_str);
				$fileName			= is_file($folder_name."/".$file_str2) ? $file_str2 : $file_str;

				$fileNames			.= ( $fileNames == "" )?"":"||";
				$fileNames			.= $upfolder.$folder_name."/".$fileName;

				$fileNamesInput		.= ( $fileNamesInput == "" )?"":"||";
				$fileNamesInput		.= $file_str;

				$file_size			+= filesize($folder_name."/".$file_str);			//업로드 된 용량 체크
				$file_count++;														//업로드 된 파일 개수 체크
			}
			$now_cntt2			= $j;
		}
		$file_size			= ceil($file_size / (1024*1024));							//업로드 된 총용량 계산하자.





		$cntt				= $_POST['max_file_limit'] == "" ? "40" : ($_POST['max_file_limit']*2);


		# 드래그툴 노출이 될 파일명 리턴 : $fileNames
		# hidden input값 적용 용 파일명 : $fileNamesInput


	$MAX_FILE_LIMIT		= $_POST['max_file_limit'] - $file_count;
	$UPLOAD_LIMIT_SIZE	= $_POST['upload_limit_size'] - $file_size;



	# 업로드 용량 제한 : $UPLOAD_LIMIT_SIZE
	# 업로드 가능 개수 : $MAX_FILE_LIMIT


	echo $MAX_FILE_LIMIT."___cut___".$UPLOAD_LIMIT_SIZE."___cut___".$fileNames."___cut___".$fileNamesInput;
	exit;
?>

