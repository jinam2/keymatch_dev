<?
	// happy_img_resize_ajax.php
	//업로드된 이미지중 파일용량이 큰 이미지를 찾아서
	//적당한 사이즈로 줄이도록 추가
	set_time_limit(0);
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/function.php");

	include ("../inc/lib.php");
	//include ("../inc/board_function.php");

	if ( !admin_secure("환경설정") )
	{
		error("접속권한이 없습니다.");
		exit;
	}


	$result		= "error[none]";
	$file		= $_GET['file'];
	$width_size	= $_GET['width_size'];


	/****    설정    **********************************************************************************************/

	$cwd = getcwd();
	$folder_name = preg_replace("/\/admin$/","",$cwd); //뉴스는 master

	$min_width = "600"; //이 프로그램으로 줄일수 있는 최소 가로사이트

	/*************************************************************************************************************/


	if( $demo_lock != "" )
	{
		exit("데모에서는 파일변환작업이 불가능합니다.");
	}


	#파일 크기 반환
	if ( !function_exists("byteConvert") )
	{
		function byteConvert($bytes) {

			$s = array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
			$e = floor(log($bytes)/log(1024));

			if ( $bytes != '' )
			{
				return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
			}
			else
			{
				return '0';
			}
		}
	}


	// 파일 변화처리
	// happy_img_resize.php 파일 에서 참조함.
	function imageUploadNew_resize($img_name, $img_name_new, $gi_joon, $height_gi_joon, $picture_quality)
	{
		global $min_width;

		$img_url_re		= $img_name_new;
		$image_top		= 0;
		$image_left		= 0;

		#확장자 체크
		$img_names		= explode(".",$img_name);
		$img_ext		= strtolower($img_names[sizeof($img_names)-1]);

		#기존 이미지를 불러와서 사이즈 체크
		$imagehw		= GetImageSize("$img_name");

		$imagewidth		= $imagehw[0];
		$imageheight	= $imagehw[1];

		if ( $imagewidth < $min_width )
		{
			return "최소가로사이즈(".$min_width."px) 보다 작음(1)";
		}

		#원본이미지타입
		#1:gif,2:jpg,3:png
		$src_type = $imagehw[2];

		if ( $src_type == "1" )
		{
			$img_ext = "gif";
		}
		else if ( $src_type == "2" )
		{
			$img_ext = "jpg";
		}
		else if ( $src_type == "3" )
		{
			$img_ext = "png";
		}
		#원본이미지타입


		$new_width		= $gi_joon;
		$new_width		= ceil($new_width);
		$new_height		= $gi_joon * $imageheight / $imagewidth ;
		$new_height		= ceil($new_height);

		#배경잡고
		$thumb			= ImageCreate($gi_joon,$new_height);
		$thumb			= imagecreatetruecolor($gi_joon,$new_height);
		$white			= imagecolorallocate($thumb, 255, 255, 255);
		imagefilledrectangle ($thumb,0,0,$gi_joon,$new_height,$white);


		if ( $img_ext == 'png' ) {
			$src		= ImageCreateFromPng("$img_name");
		}
		else if (  $img_ext == 'gif' ) {
			$src		= ImageCreateFromGif("$img_name");
		}
		else {
			$src		= ImageCreateFromJPEG("$img_name");
		}
		//$src		= ImageCreateFromJPEG("$img_name");
		imagecopyresampled($thumb,$src,0,0,$image_left,$image_top,$new_width,$new_height,$imagewidth,$imageheight);

		ImageJPEG($thumb,"$img_name_new",$picture_quality);


		//return $img_url_re;
		return "OK";

	}









	// 변환체크 및 변환요청
	if( strlen($file) > 0 )
	{
		$chk = true;
		$img_path = $file;
		if ( !preg_match("/\.jp/i",$img_path) )
		{
			$result	= "JPG 파일이 아님";
			$chk	= false;
		}

		$cwd_patten = str_replace("/","\/",$folder_name);
		if ( !preg_match("/".$cwd_patten."/",$img_path) )
		{
			$result	= "이미지 경로 오류";
			$chk	= false;
		}

		if ( !is_writable($img_path) )
		{
			$result	= "쓰기권한 오류";
			$chk	= false;
		}

		$gi_joon = $width_size;
		if ( $gi_joon < $min_width )
		{
			$result	= "최소가로사이즈(".$min_width."px) 보다 작음(0)";
			$chk	= false;
		}

		// 실제이미지 사이즈가 변경사이즈(gi_joon)와 같을경우
		$imagehw		= GetImageSize("$img_path");
		$imagewidth		= $imagehw[0];
		$imageheight	= $imagehw[1];
		if ( $imagewidth <= $gi_joon )
		{
			$result	= "이미지 사이즈 : ".$imagewidth."x".$imageheight;
			$chk	= false;
		}

		if( $chk )
		{
			// 원본 이미지 정보
			$org_file_size		= byteConvert(filesize($img_path));
			$org_file_wdith		= $imagewidth;
			$org_file_height	= $imageheight;

			$result				= imageUploadNew_resize($img_path,$img_path, $gi_joon, 0, 100);
			//$result				= "OK";

			// 변환 이미지 정보
			clearstatcache();
			$conv_file_size		= byteConvert(filesize($img_path));
			$conv_imagehw		= GetImageSize("$img_path");
			$conv_file_wdith	= $conv_imagehw[0];
			$conv_file_height	= $conv_imagehw[1];
		}

	}


	$file = strtr( $file, array($folder_name => "") );

	// 결과__cut__파일경로__cut__원본용량__cut__원본크기__cut__변경용량__cut__변경크기

	echo $result."__cut__".$file."__cut__".$org_file_size."__cut__".($org_file_wdith."x".$org_file_height)."__cut__".$conv_file_size."__cut__".($conv_file_wdith."x".$conv_file_height);
?>