<?
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	if ( !happy_member_secure($happy_member_secure_text[0].'등록') && !$_COOKIE["ad_id"] )
	{
		error($happy_member_secure_text[0].'등록'." 권한이 없습니다.");
		exit;
	}

	## 썸네일 크기 설정
	$garo_gi_joon		= 125;
	$sero_gi_joon		= 125;
	$picture_quality	= 100;

	#$allow_ext_array	= Array(".png",".jpg",".jpeg",".gif"); // 허용 확장자
	$files_input_name	= 'noflash_img';
	$upload_folder		= "./upload/tmp/";
	$upload_folder2		= "./upload/";
	$no_img_file_name	= "mobile_img/btn_img_upload_noimg.jpg";

	$number				= $_GET['number'];

	if(!session_id()) session_start();
	$_GET["browser_id"]	= session_id();
	$_GET["upload_id"]	= 'img';

	$folder_name		= $upload_folder . $_GET["browser_id"];

	if (is_dir($folder_name))
	{
		$dh = opendir("$folder_name");
		while (($file = readdir($dh)) !== false)
		{
			if ($file == "." || $file == "..") continue;
			{
				if(strpos($file, 'thumb') === false)
				{
					$return_array[]	= $file;
				}
			}
		}
		closedir($dh);
		if(is_array($return_array))
			sort($return_array);
	}

	$TPL->define("이미지업로드",$skin_folder."/rows_happy_mobile_image_upload.html");
	$이미지업로드			= "<table cellspacing='0' cellpadding='0' border='0' style='width:100%;'>";

	if( $number == '')
	{
		for($i = 1, $z = 0; $i <= 20; $i++, $z++)
		{
			if($return_array[$z] != '')
			{
				$img_url_re_thumb	= $folder_name . '/' . $return_array[$z];
			}
			else
			{
				$img_url_re_thumb	= $no_img_file_name;
			}

			$input_type_file_name		= "noflash_img_".$z;
			$form_name					= "form".$z;
			$btn_img					= "btn_img_".$z;
			$img_url_re_thumb_id		= "img_url_re_thumb".$z;

			$rows				= $TPL->fetch("이미지업로드");

			#TD를 정리하자
			if ($i % $ex_width == "1")
			{
				$이미지업로드 .= "<tr><td valign=top align=center>" . $rows . "</td>";
			}
			elseif ($i % $ex_width == "0")
			{
				$이미지업로드 .= "<td valign=top align=center>" . $rows . "</td></tr>";
			}
			else
			{
				$이미지업로드 .= "<td valign=top align=center>" . $rows . "</td>";
			}
		}
	}
	else
	{
		$Sql				= "SELECT * FROM $per_file_tb WHERE doc_number = '$number' order by number  ";
		$Record				= query($Sql);

		#echo $Sql;

		#$tmp	= explode(",",$fields);
		$file_array	= Array();
		$i		= 0;
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			#print_r($Data);
			$Data['fileName']	= str_replace("((thumb_name))","_thumb",$Data['fileName']);
			//echo $upfolder; exit;
			$fileName	= $Data['fileName'] ;


			#$fileNames	.= ( $i==0 )?"":"||";
			#$fileNames	.= ( $fileName == "" ) ?"":$upfolder.$fileName;

			$startScript	.= "parent.document_frm.img${i}.value	= '".$Data['fileName']."';\n";
			$file_array[]	=  $Data['fileName'];

			$i++;
		}

		for($i=1,$z = 0; $i <= 20; $i++,$z++)
		{
			if($file_array[$z] != '')
			{
				$img_url_re_thumb	= $file_array[$z];
			}
			else
			{
				$img_url_re_thumb	= $no_img_file_name;
			}

			$input_type_file_name		= "noflash_img_".$z;
			$form_name					= "form".$z;
			$btn_img					= "btn_img_".$z;
			$img_url_re_thumb_id		= "img_url_re_thumb".$z;


			$rows				= $TPL->fetch("이미지업로드");

			#TD를 정리하자
			if ($i % $ex_width == "1")
			{
				$이미지업로드 .= "<tr><td valign=top align=center>" . $rows . "</td>";
			}
			elseif ($i % $ex_width == "0")
			{
				$이미지업로드 .= "<td valign=top align=center>" . $rows . "</td></tr>";
			}
			else
			{
				$이미지업로드 .= "<td valign=top align=center>" . $rows . "</td>";
			}
		}
	}


	$이미지업로드 .= "</table>";


	$TPL->define("껍데기", "$skin_folder/default_happy_mobile_image_upload.html");
	$TPL->assign("껍데기");
	$ALL = &$TPL->fetch();
	echo $ALL;


?>