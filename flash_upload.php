<?

	$HAPPY_REFERER_CHECK_DEFAULT = 'off';
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$_GET["browser_id"]	= str_replace(".","",str_replace("/","",$_GET["browser_id"]));
	$_GET["upload_id"]	= str_replace(".","",str_replace("/","",$_GET["upload_id"]));

	$folder_name = "./upload/tmp/".$_GET["browser_id"];


	if(!is_dir($folder_name)) mkdir($folder_name, 0777);
	chmod($folder_name, 0777);


	###########

	$fileName	= $_FILES['Filedata']['name'];
	$temp_name	= explode(".",$fileName);
	$ext		= strtolower($temp_name[sizeof($temp_name)-1]);



	$temp	= array();
	$max	= 0;
	if ($handle = opendir("$folder_name")) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				$temp[]	= $file;
				$files	= explode(".",preg_replace('/\D/', '',$file));
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

	$upFileName	= $max.".".$ext;

	move_uploaded_file($_FILES['Filedata']['tmp_name'], $folder_name."/".$_GET["upload_id"]."__swfupload__".$upFileName);

	$rand_number =  rand(0,100);
	$img_url_re = $folder_name."/".$_GET["upload_id"]."__swfupload__".$upFileName;

	$temp_name = explode(".",$img_url_re);
	$ext = strtolower($temp_name[sizeof($temp_name)-1]);

	$img_url_re_thumb = str_replace(".$ext","_thumb.$ext",$img_url_re);
	$img_url_re_big = str_replace(".$ext","_big.$ext",$img_url_re);

	if ( preg_match("/jp/i",$ext) ){

		imageUpload2($img_url_re, $img_url_re_big, $doc_img_width_big, $doc_img_height_big, $doc_img_quality);

		imageUpload2($img_url_re, $img_url_re_thumb, $doc_img_width_small, $doc_img_height_small, $doc_img_quality, 'no');
	}
?>