<?

	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	// 파일명 확장자와 경로등을 구분하여 배열로 반환 woo
	function array_file($path)
	{
		$ext				= strrchr($path, ".");
		$filename_org		= $path;
		if(strpos($path, '/') !== false)
			$filename_org	= str_replace('/', '', strrchr($path, "/"));
		$filename			= str_replace($ext, '', $filename_org);
		$path_org			= str_replace($filename_org, '', $path);

		$array			= Array();
		$array['path']	= $path_org;
		$array['org']	= $filename_org;
		$array['file']	= $filename;
		$array['ext']	= $ext;

		return $array;
	}


	## 썸네일 크기 설정
	$garo_gi_joon		= 125;
	$sero_gi_joon		= 125;
	$picture_quality	= 100;

	#$allow_ext_array	= Array(".png",".jpg",".jpeg",".gif"); // 허용 확장자
	$files_input_name	= 'noflash_img_';
	$upload_folder		= "./upload/tmp/";
	$upload_folder2		= "./upload/";
	$no_img_file_name	= "img/no_photo.gif";

	$number				= $_GET['number'];

#if($_FILES)
#{
	#print_r2($_POST);
	#print_r2($_FILES); exit;

	$img_url_re			= Array();
	$img_url_re_thumb	= Array();
	$javascript_img		= Array();

	if(!session_id()) session_start();
	$_GET["browser_id"]	= session_id();
	$_GET["upload_id"]	= 'img';

	$folder_name		= $upload_folder . $_GET["browser_id"];
	if(!is_dir($folder_name)) mkdir($folder_name, 0777);
	chmod($folder_name, 0777);

	for($x = 0; $x < 20; $x++)
	{
		$files_input_name_x	= $files_input_name . $x;

		if($_FILES[$files_input_name_x]['name'] != '')
		{
			$temp	= array();
			$max	= 0;

			if ($handle = opendir("$folder_name"))
			{
				while (false !== ($file = readdir($handle)))
				{
					if ($file != "." && $file != ".." && !preg_match('/thumb/',$file) )
					{
						$temp[]		= $file;
						$files		= explode(".",preg_replace('/\D/', '',$file));
						if ( $max < $files[0] )
						{
							$max	= $files[0];
						}
					}
				}
				closedir($handle);
			}

			$max++;
			$max		= str_pad($max , 4 , "0", STR_PAD_LEFT);


			$files_array	= array_file($_FILES[$files_input_name_x]['name']);

			if(in_array(str_replace(".","",strtolower($files_array['ext'])), $HAPPY_ALLOW_FILE_EXT))
			{
				if(is_uploaded_file($_FILES[$files_input_name_x]['tmp_name']))
				{
					$file_path		= $folder_name . "/" . $_GET["upload_id"] . "__swfupload__" . $max . $files_array['ext'];
					if( !move_uploaded_file($_FILES[$files_input_name_x]['tmp_name'], $file_path))
					{
						echo "파일 업로드중 오류 발생!";
						exit;
					}
					else
					{
						$rand_number =  rand(0,100);
						$img_url_re = $file_path;

						$tmp_files_array		= array_file($file_path);

						$temp_name = explode(".",$img_url_re);
						$ext = strtolower($temp_name[sizeof($temp_name)-1]);

						$img_url_re_thumb2 = str_replace(".$ext","_thumb.$ext",$img_url_re);			//변수명 겹쳐서 변경함.
						$img_url_re_big = str_replace(".$ext","_big.$ext",$img_url_re);

						if ( preg_match("/jp/i",$ext) ){

							imageUpload2($img_url_re, $img_url_re_big, $doc_img_width_big, $doc_img_height_big, $doc_img_quality);

							imageUpload2($img_url_re, $img_url_re_thumb2, $doc_img_width_small, $doc_img_height_small, $doc_img_quality, 'no');
						}

						$img_url_re_thumb[$x]	= $file_path;
						$javascript_img[$x]		= $tmp_files_array['org'];
					}

				} // is_uploaded_file
			} // in_array
		} // if name ok?
		else
		{
			#$img_url_re_thumb[$x]	= $no_img_file_name;
			$img_url_re_thumb[$x]	= '';
			$javascript_img[$x]		= '';
		}
	} // for 20

	#print_r($javascript_img);
	#print_r($img_url_re_thumb);

	foreach($javascript_img AS $key => $value)
	{
		//$javascript_rows	.= "parent.regiform.img${key}.value = '" . $value . "';\n";
		$javascript_rows	.= "parent.document.getElementsByName('img${key}')[0].value = '" . $value . "';\n";
	}

	$javascript_str = "
	<script type=\"text/javascript\">
$javascript_rows
	</script>
	";



	echo implode("@@@@@@@@", (array)  $javascript_img) . "______________" . implode("@@@@@@@@", $img_url_re_thumb);
#}

?>