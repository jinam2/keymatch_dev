<?php
/*
 * jQuery File Upload Plugin PHP Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

#error_reporting(E_ALL | E_STRICT);

include ("../inc/config.php");
include ("../inc/Template.php");
include ("../inc/function.php");

#usleep(5000);

$upload_folder				= "../upload/tmp/";
$upload_id					= "img";

//tmp 에 업로드 되었을 경우 ${upload_id}__swfupload__0001.jpg 형식으로 업로드 된다. 이때 html5 업로드에서 임시 파일을 지우길 원하는지 체크하기 위해 __swfupload__ 는 키워드가 된다. DELETE 함수에서 $match_keyword 변수가 포함된 코드를 보라.
$match_keyword				= "__swfupload__";
$imageUploadNew_START	= false;
#예약의 썸네일생성함수를 가져와서 수정함
function imageUploadNewHTML5($img_name, $img_name_new, $gi_joon, $height_gi_joon, $picture_quality, $thumbType="", $thumbPosition="", $logo="", $logoPosition="", $sharpen='0' )
{
	# 사용법
	# imgaeUpload(원본파일네임, 생성할파일네임, 가로크기, 세로크기, 품질, 썸네일추출타입, 로고파일명, 로고포지션)
	# $path는 홈디렉토리의 pwd

	global $imageUploadNew_START;

	if ( $imageUploadNew_START !== true )
	{
		@ini_set('gd.jpeg_ignore_warning', 1);
		$imageUploadNew_START	= true;
	}

	$thumbPosition	= preg_replace("/\D/","",$thumbPosition);
	$logoPosition	= preg_replace("/\D/","",$logoPosition);

	$img_url_re		= $img_name_new;
	$image_top		= 0;
	$image_top2		= 0;
	$image_left		= 0;
	$image_left2	= 0;

	#확장자 체크
	$img_names		= explode(".",$img_name);
	$img_ext		= strtolower($img_names[sizeof($img_names)-1]);

	#단순파일확장자 체크
	if ( $img_ext != 'jpg' && $img_ext != 'jpeg' && $img_ext != 'png' && $img_ext != 'gif' )
	{
		//error("사용할수 없는 확장자 입니다.");
		//return "";
	}

	#기존 이미지를 불러와서 사이즈 체크
	$imagehw		= GetImageSize("$img_name");
	$imagewidth		= $imagehw[0];
	$imageheight	= $imagehw[1];

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


	$new_width		= $height_gi_joon * $imagewidth / $imageheight ;
	$new_width		= ceil($new_width);
	$new_height		= $gi_joon * $imageheight / $imagewidth ;
	$new_height		= ceil($new_height);

	$width_per	= $imagewidth / $gi_joon;
	$height_per	= $imageheight / $height_gi_joon;

	#썸네일 생성 방법별
	if ( $thumbType == '비율대로짜름' )
	{
		if ( $width_per < $height_per ) {
			$gi_joon		= $new_width;
		}
		else {
			$height_gi_joon	= $new_height;
		}
	}
	else if ( $thumbType == '비율대로축소' )
	{
		$thumbType	= ( $width_per > $height_per )? '가로기준세로짜름' : '세로기준가로짜름';
	}
	else if ( $thumbType == '비율대로확대' )
	{
		$thumbType	= ( $width_per > $height_per )? '세로기준가로짜름' : '가로기준세로짜름';
	}


	if ( ( $thumbPosition == '4' ||  $thumbPosition == '5' || $thumbPosition == '6' ) && ( $thumbType == '가로기준세로짜름' || $thumbType == '세로기준가로짜름' ) && $gi_joon > $imagewidth && $height_gi_joon > $imageheight )
	{
		$new_width		= $imagewidth;
		$new_height		= $imageheight;
		$thumbType		= '작은이미지';
	}
	else
	{
		switch( $thumbType )
		{
			case "가로기준세로짜름" :
										$new_width	= $gi_joon;
										break;
			case "세로기준가로짜름" :
										$new_height	= $height_gi_joon;
										break;
			case "가로기준" :
										if ( $imagewidth < $gi_joon )
										{
											$new_width		= $imagewidth;
											$new_height		= $imageheight;
											$gi_joon		= $imagewidth;
											$height_gi_joon	= $imageheight;
										}
										else
										{
											$new_width		= $gi_joon;
											$new_height		= $imageheight / $width_per;
											$height_gi_joon	= $new_height;
										}
										break;
			case "세로기준" :
										if ( $imageheight < $height_gi_joon )
										{
											$new_width		= $imagewidth;
											$new_height		= $imageheight;
											$gi_joon		= $imagewidth;
											$height_gi_joon	= $imageheight;
										}
										else
										{
											$new_width		= $imagewidth / $height_per;
											$gi_joon		= $new_width;
											$new_height		= $height_gi_joon;
										}
										break;
			default :
										$new_width	= $gi_joon;
										$new_height	= $height_gi_joon;
										break;
		}
	}
	#echo "$new_width - $new_height <br> ";

	if ( $thumbPosition > 3 )
	{
		$thumbPosition	= $thumbPosition - 3;
	}

	#썸네일 추출 위치 ( 가로기준 , 세로기준에만 해당 )
	if ( $thumbType == '작은이미지' && $thumbPosition != '' )
	{
		if ( $thumbPosition == '2' )
		{
			$image_top2		= ( $height_gi_joon - $new_height ) / 2;
			$image_left2	= ( $gi_joon - $new_width ) / 2 ;
		}
		else if ( $thumbPosition == '3' )
		{
			$image_top2		= $height_gi_joon - $new_height;
			$image_left2	= $gi_joon - $new_width;
		}
	}
	else if ( $thumbType == '가로기준세로짜름' && $thumbPosition != '' )
	{
		if ( $thumbPosition == '2' )
		{
			if ( $new_height > $height_gi_joon )
			{
				$image_top		= $imageheight * ( ( ( $new_height - $height_gi_joon ) / 2 ) / $new_height );
			}
			else
			{
				$image_top2		= ( $height_gi_joon - $new_height ) / 2;
			}
		}
		else if ( $thumbPosition == '3' )
		{
			if ( $new_height > $height_gi_joon )
			{
				$image_top		= $imageheight * ( ( $new_height - $height_gi_joon ) / $new_height );
			}
			else
			{
				$image_top2		= $height_gi_joon - $new_height;
			}
		}
	}
	else if ( $thumbType == '세로기준가로짜름' && $thumbPosition != '' )
	{
		if ( $thumbPosition == '2' )
		{
			if ( $new_width > $gi_joon )
			{
				$image_left		= $imagewidth * ( ( ( $new_width - $gi_joon ) / 2 ) / $new_width );
			}
			else
			{
				$image_left2	= ( $gi_joon - $new_width ) / 2 ;
			}
		}
		else if ( $thumbPosition == '3' )
		{
			if ( $new_width > $gi_joon )
			{
				$image_left		= $imagewidth * ( ( $new_width - $gi_joon ) / $new_width );
			}
			else
			{
				$image_left2	= $gi_joon - $new_width;
			}
		}
	}
	#echo "$image_left - $image_top <br> ";



	#배경잡고
	#$thumb			= ImageCreate($gi_joon,$height_gi_joon);
	$thumb			= imagecreatetruecolor($gi_joon,$height_gi_joon);
	$white			= imagecolorallocate($thumb,255, 255, 255);
	imagefilledrectangle ($thumb,0,0,$gi_joon,$height_gi_joon,$white);


	if ( $img_ext == 'png' ) {
		$src		= ImageCreateFromPng("$img_name");
	}
	else if (  $img_ext == 'gif' ) {
		$src		= ImageCreateFromGif("$img_name");
	}
	else {
		$src		= ImageCreateFromJPEG("$img_name");
	}

	#$thumb		= imagecrop($src, array('x'=>$image_left, 'y'=>$image_top, 'width'=>$new_width, 'height' => $new_height));
	imagecopyresampled($thumb,$src,$image_left2,$image_top2,$image_left,$image_top,$new_width,$new_height,$imagewidth,$imageheight);


	if ( $sharpen == '1' )
	{
		$sharpen_data	= array(
			array(0.0, 0.0, 0.0),
			array(-1.0, 5.0, -1.0),
			array(0.0, 0.0, 0.0)
		);
	}
	else if ( $sharpen == '2' )
	{
		$sharpen_data	= array(
			array(0.0, -0.5, 0.0),
			array(-0.5, 5.0, -0.5),
			array(0.0, -0.5, 0.0)
		);
	}
	else if ( $sharpen == '3' )
	{
		$sharpen_data	= array(
			array(2.0, -0.5, 2.0),
			array(-0.5, 5.0, -0.5),
			array(0.5, -0.5, 0.5)
		);
	}

	if ( $sharpen != '0' )
	{
		$divisor = array_sum(array_map('array_sum', $sharpen_data));
		imageconvolution($thumb, $sharpen_data, $divisor, 0);
	}


	#일단 쪼끄만거부터 맹글자
	if ( $img_ext == 'png' ) {
		$phpver    =phpversion();
		$phpver    =$phpver[0];
		$picture_quality = ( $picture_quality > 9 && $phpver > 4 ) ? round( $picture_quality /11 ) : $picture_quality;
		Imagepng($thumb,"$img_name_new",$picture_quality);
	}
	else if (  $img_ext == 'gif' ) {
		Imagegif($thumb,"$img_name_new",$picture_quality);
	}
	else {
		ImageJPEG($thumb,"$img_name_new",$picture_quality);
	}




	#로고작업
	if ( $logo != "" )
	{
		$logo			= ImageCreateFromPng("$logo");
		$logo_width		= imagesx($logo);
		$logo_height	= imagesy($logo);

		$logo_left	= 0;
		$logo_top	= 0;

		#로고 포지션 잡기
		switch( $logoPosition )
		{
			case "1":	break;
			case "2":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						break;
			case "3":
						$logo_left	= $gi_joon - $logo_width;
						break;
			case "4":
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "5":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "6":
						$logo_left	= $gi_joon - $logo_width;
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "7":
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			case "8":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			case "9":
						$logo_left	= $gi_joon - $logo_width;
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			default:
						$logo_top	= $height_gi_joon-$logo_height;
						break;
		}

		imagecopy($thumb,$logo,$logo_left,$logo_top,0,0,$logo_width,$logo_height);
		ImageJPEG($thumb,"$img_name_new",$picture_quality);
		ImageDestroy($logo);
	}

	ImageDestroy($thumb);


	return $img_url_re;

}


//happy_image 이용하도록 개선 2021-10-11
if( !function_exists('dir_make') ){
	#첨부파일디렉토리생성
	function dir_make($dir_names)
	{
		$upload_dir = ".";

		if ( is_array($dir_names) )
		{
			$TmpUploadDir = $upload_dir;
			$oldmask = umask(0);
			foreach($dir_names as $k => $v)
			{
				if ( $v != "." )
				{
					$TmpUploadDir .= "/".$v;

					if ( !is_dir($TmpUploadDir) )
					{
						mkdir($TmpUploadDir,0777);
					}
				}
			}
			umask($oldmask);
		}
	}
}


function happy_image_HTML5($img_name,$img_width,$img_height,$logo_use="로고사용안함",$logoPosition="7",$img_quality="100",$return_type="썸네일",$no_img="img/no_photo.gif",$Tthumb_type="",$thumbPosition="")
{
	#넘어온값 처리
	$img_width = preg_replace('/\D/', '', $img_width);		#가로
	$img_height = preg_replace('/\D/', '', $img_height);	#세로
	$img_quality_org	= $img_quality;
	$img_quality = preg_replace('/\D/', '', $img_quality);	#퀄리티
	$logoPosition = preg_replace('/\D/', '', $logoPosition);	#로고위치

	global $wys_url;
	global $file_attach_folder;
	global $file_attach_thumb_folder;
	global $Happy_Img_Name;
	global $Logo_Img_Name;

	# 퀄리티 기본 지정값 kwak16 - 20180416
	global $happy_image_sizes;
	if ( $img_quality_org != $img_quality )
	{
		$quality_tmp		= preg_replace("/\D/", "", $happy_image_sizes[$img_quality_org]);
		if ( $quality_tmp != '' && $quality_tmp > 20 )
		{
			$img_quality		= $quality_tmp;
		}
	}

	if ( $logo_use == "로고사용함" )
	{
		$logo_use = "Y";
		$logo_file = $Logo_Img_Name;
	}
	else
	{
		$logo_use = "N";
		$logo_file = "";
	}


	/*-----------------------------------------------------------------------------------------------------------------------
	2021-10-08	기존 happy_image 함수와 다른점 : 아래의 자동 치환 사용하지 않고 이미지 파일명을 그대로 사용하도록 변경
	-----------------------------------------------------------------------------------------------------------------------*/
	$ExArray				= array();
	$tmp_colname			= 0;
	$ExArray[$tmp_colname]	= $img_name;
	/*
	if ( preg_match("/자동/",$img_name) )
	{
		$tmp_colname = preg_replace("/자동/","",$img_name);
		if ( $tmp_colname == "" )
		{
			$tmp_colname = 0;
		}
		$ExArray = $Happy_Img_Name;
	}
	else
	{
		$tmp_img = explode(".",$img_name);		#출력배열
		$tmp_colname = $tmp_img[1];				#이미지컬럼명
		eval("global $".$tmp_img[0].";");
		$ExArray = $$tmp_img[0];
	}

	#원본이미지 솔루션마다 변경되어야 함
	//타사이트 이미지 퍼온경우 원본이미지 그대로 사용
	//$ExArray[$tmp_colname] = "http://mall6.cgimall.co.kr/admin/img/title_admin_mode2.gif";
	if ( preg_match("/http(|s):\/\//i",$ExArray[$tmp_colname]) )
	{
		//echo  preg_replace("/^\.{0,2}/","",$ExArray[$tmp_colname])."<BR>";
		return preg_replace("/^[\.]{0,2}[\/]{0,1}/","",$ExArray[$tmp_colname]);
	}
	*/

	$TmpWonFile = explode("/",$ExArray[$tmp_colname]);
	$TmpWonFileName = array_pop($TmpWonFile);
	$TmpWonFilePath = implode("/",$TmpWonFile);

	$TmpThumbFilePath = $TmpWonFilePath;

	# 이미지 생성 경로 변경 kwak16 - 20180416
	if ( preg_match("/^\.\//",$TmpWonFilePath) )
	{
		$TmpThumbFilePath	= preg_replace("/^\.\//","",$TmpThumbFilePath);
	}
	# ../ 값으로 시작시에는 ../를 제거하고 앞에 붙여주기.
	if ( preg_match("/^\.\.\//",$TmpWonFilePath) )
	{
		$TmpThumbFilePath	= preg_replace("/^\.\.\//","",$TmpThumbFilePath);
		$TmpThumbFilePath	= '../upload/happy_thumb/'.$img_width."x".$img_height."_".$img_quality.'/'. $TmpThumbFilePath;
	}
	else
	{
		$TmpThumbFilePath	= './upload/happy_thumb/'.$img_width."x".$img_height."_".$img_quality.'/'. $TmpThumbFilePath;
	}

	/*
	#게시판첨부사진
	if ( preg_match("/^\.\/data/",$TmpWonFilePath) )
	{
		$TmpThumbFilePath = preg_replace("/^\.\/data/","./wys2/file_attach_thumb/board_thumb",$TmpThumbFilePath);
	}

	#상품사진
	$TmpThumbFilePath = preg_replace("/file_attach\//","file_attach_thumb/",$TmpThumbFilePath);
	*/
	# 이미지 생성 경로 변경 kwak16 - 20180416

	#생성파일명구분자
	switch( $Tthumb_type )
	{
		case "비율대로짜름":
			$Tthumb_type_file = "0";
			break;
		case "비율대로축소":
			$Tthumb_type_file = "1";
			break;
		case "비율대로확대":
			$Tthumb_type_file = "2";
			break;
		case "가로기준세로짜름":
			$Tthumb_type_file = "3";
			break;
		case "세로기준가로짜름":
			$Tthumb_type_file = "4";
			break;
		case "가로기준":
			$Tthumb_type_file = "5";
			break;
		case "세로기준":
			$Tthumb_type_file = "6";
			break;
		default :
			$Tthumb_type_file = "7";
			break;
	}


	if ( is_file($ExArray[$tmp_colname]) )
	{

		$TmpWon = explode(".",$TmpWonFileName);
		$wonbon_img = $TmpWonFilePath."/".$TmpWonFileName;

		#썸네일이미지파일명
		#원본파일_로고_가로x세로_퀄리티.확장자
		//$thumb_img_name = $TmpWon[0]."_".$logo_use."_".$logoPosition."_".$img_width."x".$img_height."_".$img_quality."_".$Tthumb_type_file.".".$TmpWon[1];
		$thumb_img_name = $TmpWon[0]."_".$logo_use."_".$logoPosition."_".$img_width."x".$img_height."_".$img_quality."_".$Tthumb_type_file."_".$thumbPosition.".".$TmpWon[1];

		$thumb_img = $TmpThumbFilePath."/".$thumb_img_name;

		if ( !isset($ExArray) )
		{
			return;
		}

		if ( preg_match("/gif/i",$TmpWon[1]) )
		{
			if ( $return_type == "gif원본출력" )
			{
				return $wonbon_img;
			}
		}


		if ( is_file($thumb_img) )
		{
			return $thumb_img;
		}
		else
		{
			$TmpDir = explode("/",$thumb_img);
			array_pop($TmpDir);
			dir_make($TmpDir);

			//happy_thumb(array($img_width),array($img_height),1,$wonbon_img,array($thumb_img),$img_quality,$logo_use,$Tthumb_type);

			imageUploadNewHTML5($wonbon_img, $thumb_img, $img_width, $img_height, $img_quality, $Tthumb_type, $thumbPosition, $logo_file, $logoPosition );

			return $thumb_img;
		}
	}
	else
	{
		return $no_img;
	}
}
//happy_image 이용하도록 개선 2021-10-11



class UploadHandler
{

    protected $options;

    // PHP File Upload error message codes:
    // https://php.net/manual/en/features.file-upload.errors.php
	/*
    protected $error_messages = array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',				//허용된 파일 용량 초과 파일 용량 초과
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
        'post_max_size' => 'The uploaded file exceeds the post_max_size directive in php.ini',
        'max_file_size' => 'File is too big',
        'min_file_size' => 'File is too small',
        'accept_file_types' => 'Filetype not allowed',
        'max_number_of_files' => 'Maximum number of files exceeded',
        'max_width' => 'Image exceeds maximum width',
        'min_width' => 'Image requires a minimum width',
        'max_height' => 'Image exceeds maximum height',
        'min_height' => 'Image requires a minimum height',
        'abort' => 'File upload aborted',
        'image_resize' => 'Failed to resize image'
    );
	*/
	protected $error_messages = array(
        1 => '서버에서 허용하는 업로드 용량을 초과 하였습니다.',				//허용된 파일 용량 초과 파일 용량 초과
        2 => '허용된 업로드 용량을 초과 하였습니다.',
        3 => '업로드 된 파일중 일부만 업로드 되었습니다.',
        4 => '업로드 된 파일이 없습니다.',
        6 => '임시폴더가 존재하지 않습니다..',
        7 => '임시폴더의 퍼미션을 707로 변경 바랍니다.',
        8 => 'PHP 확장자는 업로드 불가능 합니다.',
        'post_max_size' => 'The uploaded file exceeds the post_max_size directive in php.ini',
        'max_file_size' => 'File is too big',
        'min_file_size' => 'File is too small',
        'accept_file_types' => 'Filetype not allowed',
        'max_number_of_files' => 'Maximum number of files exceeded',
        'max_width' => 'Image exceeds maximum width',
        'min_width' => 'Image requires a minimum width',
        'max_height' => 'Image exceeds maximum height',
        'min_height' => 'Image requires a minimum height',
        'abort' => 'File upload aborted',
        'image_resize' => 'Failed to resize image'
    );


    const IMAGETYPE_GIF = 1;
    const IMAGETYPE_JPEG = 2;
    const IMAGETYPE_PNG = 3;

    protected $image_objects = array();
    protected $response = array();

    public function __construct($options = null, $initialize = true, $error_messages = null) {
        $this->options = array(
            'script_url' => $this->get_full_url().'/'.$this->basename($this->get_server_var('SCRIPT_NAME')),
            'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')).'/files/',
            'upload_url' => $this->get_full_url().'/files/',
            'input_stream' => 'php://input',
            'user_dirs' => false,
            'mkdir_mode' => 0755,
            'param_name' => 'files',
            // Set the following option to 'POST', if your server does not support
            // DELETE requests. This is a parameter sent to the client:
            'delete_type' => 'DELETE',
            'access_control_allow_origin' => '*',
            'access_control_allow_credentials' => false,
            'access_control_allow_methods' => array(
                'OPTIONS',
                'HEAD',
                'GET',
                'POST',
                'PUT',
                'PATCH',
                'DELETE'
            ),
            'access_control_allow_headers' => array(
                'Content-Type',
                'Content-Range',
                'Content-Disposition'
            ),
            // By default, allow redirects to the referer protocol+host:
            'redirect_allow_target' => '/^'.preg_quote(
                    parse_url($this->get_server_var('HTTP_REFERER'), PHP_URL_SCHEME)
                    .'://'
                    .parse_url($this->get_server_var('HTTP_REFERER'), PHP_URL_HOST)
                    .'/', // Trailing slash to not match subdomains by mistake
                    '/' // preg_quote delimiter param
                ).'/',
            // Enable to provide file downloads via GET requests to the PHP script:
            //     1. Set to 1 to download files via readfile method through PHP
            //     2. Set to 2 to send a X-Sendfile header for lighttpd/Apache
            //     3. Set to 3 to send a X-Accel-Redirect header for nginx
            // If set to 2 or 3, adjust the upload_url option to the base path of
            // the redirect parameter, e.g. '/files/'.
            'download_via_php' => false,
            // Read files in chunks to avoid memory limits when download_via_php
            // is enabled, set to 0 to disable chunked reading of files:
            'readfile_chunk_size' => 10 * 1024 * 1024, // 10 MiB
            // Defines which files can be displayed inline when downloaded:
            'inline_file_types' => '/\.(gif|jpe?g|png)$/i',
            // Defines which files (based on their names) are accepted for upload.
            // By default, only allows file uploads with image file extensions.
            // Only change this setting after making sure that any allowed file
            // types cannot be executed by the webserver in the files directory,
            // e.g. PHP scripts, nor executed by the browser when downloaded,
            // e.g. HTML files with embedded JavaScript code.
            // Please also read the SECURITY.md document in this repository.
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
            // Replaces dots in filenames with the given string.
            // Can be disabled by setting it to false or an empty string.
            // Note that this is a security feature for servers that support
            // multiple file extensions, e.g. the Apache AddHandler Directive:
            // https://httpd.apache.org/docs/current/mod/mod_mime.html#addhandler
            // Before disabling it, make sure that files uploaded with multiple
            // extensions cannot be executed by the webserver, e.g.
            // "example.php.png" with embedded PHP code, nor executed by the
            // browser when downloaded, e.g. "example.html.gif" with embedded
            // JavaScript code.
            'replace_dots_in_filenames' => '-',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            // The maximum number of files for the upload directory:
            'max_number_of_files' => null,
            // Reads first file bytes to identify and correct file extensions:
            'correct_image_extensions' => false,
            // Image resolution restrictions:
            'max_width' => null,
            'max_height' => null,
            'min_width' => 1,
            'min_height' => 1,
            // Set the following option to false to enable resumable uploads:
            'discard_aborted_uploads' => true,
            // Set to 0 to use the GD library to scale and orient images,
            // set to 1 to use imagick (if installed, falls back to GD),
            // set to 2 to use the ImageMagick convert binary directly:
            'image_library' => 1,
            // Uncomment the following to define an array of resource limits
            // for imagick:
            /*
            'imagick_resource_limits' => array(
                imagick::RESOURCETYPE_MAP => 32,
                imagick::RESOURCETYPE_MEMORY => 32
            ),
            */
            // Command or path for to the ImageMagick convert binary:
            'convert_bin' => 'convert',
            // Uncomment the following to add parameters in front of each
            // ImageMagick convert call (the limit constraints seem only
            // to have an effect if put in front):
            /*
            'convert_params' => '-limit memory 32MiB -limit map 32MiB',
            */
            // Command or path for to the ImageMagick identify binary:
            'identify_bin' => 'identify',
            'image_versions' => array(
                // The empty image version key defines options for the original image.
                // Keep in mind: these image manipulations are inherited by all other image versions from this point onwards.
                // Also note that the property 'no_cache' is not inherited, since it's not a manipulation.
                '' => array(
                    // Automatically rotate images based on EXIF meta data:
                    'auto_orient' => true
                ),
                // You can add arrays to generate different versions.
                // The name of the key is the name of the version (example: 'medium').
                // the array contains the options to apply.
                /*
                'medium' => array(
                    'max_width' => 800,
                    'max_height' => 600
                ),
                */
                'thumbnail' => array(
                    // Uncomment the following to use a defined directory for the thumbnails
                    // instead of a subdirectory based on the version identifier.
                    // Make sure that this directory doesn't allow execution of files if you
                    // don't pose any restrictions on the type of uploaded files, e.g. by
                    // copying the .htaccess file from the files directory for Apache:
                    //'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')).'/thumb/',
                    //'upload_url' => $this->get_full_url().'/thumb/',
                    // Uncomment the following to force the max
                    // dimensions and e.g. create square thumbnails:
                    // 'auto_orient' => true,
                    // 'crop' => true,
                    // 'jpeg_quality' => 70,
                    // 'no_cache' => true, (there's a caching option, but this remembers thumbnail sizes from a previous action!)
                    // 'strip' => true, (this strips EXIF tags, such as geolocation)
                    'max_width' => 130, // either specify width, or set to 0. Then width is automatically adjusted - keeping aspect ratio to a specified max_height.
                    'max_height' => 120 // either specify height, or set to 0. Then height is automatically adjusted - keeping aspect ratio to a specified max_width.
                )
            ),
            'print_response' => true
        );
        if ($options) {
            $this->options = $options + $this->options;
        }
        if ($error_messages) {
            $this->error_messages = $error_messages + $this->error_messages;
        }
        if ($initialize) {
            $this->initialize();
        }
    }

    protected function initialize() {
		#print_r($_POST);
        switch ($this->get_server_var('REQUEST_METHOD')) {
            case 'OPTIONS':
            case 'HEAD':
                $this->head();
                break;
            case 'GET':
                $this->get($this->options['print_response']);
                break;
            case 'PATCH':
            case 'PUT':
            case 'POST':
                $this->post($this->options['print_response']);
                break;
            case 'DELETE':
                $this->delete($this->options['print_response']);
                break;
            default:
                $this->header('HTTP/1.1 405 Method Not Allowed');
        }
    }

	/*	DB 에 저장되어 있는 파일을 로딩하는 함수	*/
	public function load_db_image()
	{
		global $per_file_tb,$main_url,$wys_url;

		$number				= $_POST['number'];
		if( !$number )
		{
			return;
		}
		//$number				= 627;

		$uploads_array		= Array();

		$Sql				= "SELECT * FROM $per_file_tb WHERE doc_number = '$number' order by number ";
		$Result				= query($Sql);
		while( $Data =  happy_mysql_fetch_assoc($Result))
		{
			//((thumb_name)) 을 치환해서 _thmub 로 전달해줘야 한다. 그래야지 DB 에 저장할때 thumb를 ((thumb_name)) 으로 치환해서 저장한다.
			//파일명 전달 예시 : upload/per_img/asdf/2-61-8597((thumb_name)).jpg

			$Data['fileName']	= "../".str_replace("((thumb_name))","",$Data['fileName']);

			if( strlen($Data['fileName']) > 10 )
			{
				$file_info				= getimagesize($Data['fileName']);
				$file_info['size']		= filesize($Data['fileName']);
				$tmp					= explode(".",str_replace("../","",$Data['fileName']));
				$file_name				= strtolower($tmp[sizeof($tmp)-2]).".".strtolower($tmp[sizeof($tmp)-1]);
				$file_info['file_name']	= $file_name;
				#$file_info['file_name_thumb']= str_replace(".","_thumb.",$file_name);

				//썸네일
				$img_url_re						= $Data['fileName'];			//원본 이미지 파일
				$tmpArr							= explode(".",$Data['fileName']);
				$tmpArr[count($tmpArr)-2]		.= "_thumb";		//썸네일 이미지 파일명

				$img_url_re_thumb				= implode(".",$tmpArr);


				//happy_image 이용하도록 개선 2021-10-11
				if( $_POST['thumb_image_option'] != '' ){
					$thumb_options			= explode(",",$_POST['thumb_image_option']);
					$img_url_re_thumb				= happy_image_HTML5($img_url_re,$thumb_options[0],$thumb_options[1],$thumb_options[2],$thumb_options[3],$thumb_options[4],$thumb_options[5],$thumb_options[6],$thumb_options[7],$thumb_options[8]);
					#echo $img_url_re_thumb."\n";
				}
				$file_info['file_name_thumb']		= $img_url_re_thumb;

				/*
				$garo_gi_joon		= $_POST['thumb_width'];
				$sero_gi_joon		= $_POST['thumb_height'];
				$picture_quality	= 100;

				#$imagehw = GetImageSize("$img_url_re");
				$imagewidth = $file_info[0];
				$imageheight = $file_info[1];
				//print_r($imagehw);

				if ( $garo_gi_joon > $imagewidth && $sero_gi_joon > $imageheight )
				{
					$garo_gi_joon = $imagewidth;
					$sero_gi_joon = $imageheight;
				}

				if ( !is_file($img_url_re_thumb) )
				{
					$img_url_re_thumb = imageUploadNewHTML5($img_url_re, $img_url_re_thumb, $garo_gi_joon, $sero_gi_joon, $picture_quality, "비율대로확대", 5, "", "" , "0" );
				}
				$file_info['file_name_thumb']		= str_replace("../","",$img_url_re_thumb);		//급한데로 패치
				*/

				$file = new stdClass();
				$file->name				= $file_info['file_name'];
				$file->size				= $file_info['size'];
				$file->type				= $file_info['mime'];
				$file->url				= $main_url.$wys_url."/".$file_info['file_name'];
				$file->thumbnailUrl		= $main_url.$wys_url."/".$file_info['file_name_thumb'];
				$file->deleteUrl		= $main_url.$wys_url."/html5_uploader/index.php?file=".$file_info['file_name'];
				$file->deleteType		= "DELETE";
				array_push($uploads_array,$file);

				#print_r($uploads_array);
			}
		}

		return $uploads_array;


	}


	public function post($print_response = true)
	{
		global $upload_folder, $upload_id, $main_url, $wys_url, $match_keyword;

		$folder_name			= $upload_folder.$_COOKIE["PHPSESSID"];

		$upload_files			= Array();
		if( $_POST['loading_type'] != 'submit' )
		{
			$upload_files			= $this->load_db_image();			//DB에 저장된 이미지 불러와서 기본 배열에 담아줘라.
		}
		else
		{
			#print_r($_FILES); exit;
		}

/*
		if ($this->get_query_param('_method') === 'DELETE') {
			return $this->delete($print_response);
		}
*/

		$upload = $this->get_upload_data($this->options['param_name']);

		if( $upload )
		{
			$_FILES['Filedata']		= $upload;
			if(!is_dir($folder_name)) mkdir($folder_name, 0777);
			chmod($folder_name, 0777);

			$fileName				= $_FILES['Filedata']['name'][0];
			$temp_name				= explode(".",$fileName);
			$ext					= strtolower($temp_name[sizeof($temp_name)-1]);

			$temp					= array();
			$max					= 0;
			if ($handle = opendir("$folder_name")) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && !preg_match('/thumb/',$file) ) {
						$temp[]					= $file;
						$files					= explode(".",preg_replace('/\D/', '',$file));
						if ( $max < $files[0] )
						{
							$max					= $files[0];
						}
					}
				}
				closedir($handle);
			}

			$max++;
			$max					= str_pad($max , 4 , "0", STR_PAD_LEFT);

			$upFileName				= $max.".".$ext;
			$file_name				= $upload_id.$match_keyword.$upFileName;
			$file_name_thumb		= str_replace(".","_thumb.",$file_name);

			$_FILES['Filedata']['tmp_name'][0]		= HAPPY_EXIF_READ_CHANGE($_FILES['Filedata']['tmp_name'][0]);

			move_uploaded_file($_FILES['Filedata']['tmp_name'][0], $folder_name."/".$file_name);

			$rand_number			=  rand(0,100);
			$img_url_re				= $folder_name."/".$file_name;
			$img_url_re_thumb		= $folder_name."/".$file_name_thumb;

			if ( preg_match("/jpg|jpeg|png|gif/i",$ext) )
			{
				//happy_image 이용하도록 개선 2021-10-11
				#$garo_gi_joon		= $_POST['thumb_width'];
				#$sero_gi_joon		= $_POST['thumb_height'];

				$thumb_options		= explode(",",$_POST['thumb_image_option']);
				$garo_gi_joon		= preg_replace('/\D/', '', $thumb_options[0]);
				$sero_gi_joon		= preg_replace('/\D/', '', $thumb_options[1]);
				$thumbType			= $thumb_options[7];
				$thumbPosition		= $thumb_options[8];
				//happy_image 이용하도록 개선 2021-10-11


				$picture_quality	= 100;

				$img_url_re_thumb = imageUploadNewHTML5($img_url_re, $img_url_re_thumb, $garo_gi_joon, $sero_gi_joon, $picture_quality, $thumbType, $thumbPosition, "", "" , "0" );

				$imagehw['size']		= filesize($img_url_re);

				$rnd_code				= date('ymdHis', time()) . str_pad((int)(microtime()*100), 2, "0", STR_PAD_LEFT);

				$file = new stdClass();
				$file->name				= $file_name;
				$file->size				= $imagehw['size'];
				$file->type				= $imagehw['mime'];
				$file->url				= $main_url.$wys_url.str_replace("..","",$img_url_re)."?rnd={$rnd_code}";
				$file->thumbnailUrl		= $main_url.$wys_url.str_replace("..","",$img_url_re_thumb)."?rnd={$rnd_code}";
				$file->deleteUrl		= $main_url.$wys_url."/html5_uploader/index.php?file=".$file_name;
				$file->deleteType		= "DELETE";
			}

			//파일이 있으면 배열에 담아줘라.
			if( is_file( $img_url_re ) )
			{
				array_push( $upload_files, $file );
			}
		}

		$total_file_array		= Array();
		$total_file_array['files']	= $upload_files;

		#print_r2($total_file_array);

		return $this->generate_response($total_file_array, $print_response);
	}

	public function delete($print_response = true)
	{
		global $upload_folder, $match_keyword;

		$file_names = $this->get_file_names_params();

		if (empty($file_names)) {
			$file_names = array($this->get_file_name_param());
		}

		#print_r2($file_names);

        $response = array();
        foreach ($file_names as $file_name)
		{
			//임시파일 일 경우에만 즉시삭제.
			if( preg_match( "/$match_keyword/i",$file_name )  )
			{
				$file_path				= $upload_folder.$_COOKIE["PHPSESSID"]."/".$file_name;
				$file_path_thumb		= $upload_folder.$_COOKIE["PHPSESSID"]."/".str_replace(".","_thumb.",$file_name);
				@unlink($file_path);
				@unlink($file_path_thumb);
				$success				= true;
			}
			else
			{
				$success				= false;
			}
            $response[$file_name] = $success;
        }
        return $this->generate_response($response, $print_response);
    }

    protected function get_full_url() {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
            !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
                ($https && $_SERVER['SERVER_PORT'] === 443 ||
                $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

    protected function get_user_id() {
        @session_start();
        return session_id();
    }

    protected function get_user_path() {
        if ($this->options['user_dirs']) {
            return $this->get_user_id().'/';
        }
        return '';
    }

    protected function get_upload_path($file_name = null, $version = null) {
        $file_name = $file_name ? $file_name : '';
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_dir = @$this->options['image_versions'][$version]['upload_dir'];
            if ($version_dir) {
                return $version_dir.$this->get_user_path().$file_name;
            }
            $version_path = $version.'/';
        }
        return $this->options['upload_dir'].$this->get_user_path()
            .$version_path.$file_name;
    }

    protected function get_query_separator($url) {
        return strpos($url, '?') === false ? '?' : '&';
    }

    protected function get_download_url($file_name, $version = null, $direct = false) {
        if (!$direct && $this->options['download_via_php']) {
            $url = $this->options['script_url']
                .$this->get_query_separator($this->options['script_url'])
                .$this->get_singular_param_name()
                .'='.rawurlencode($file_name);
            if ($version) {
                $url .= '&version='.rawurlencode($version);
            }
            return $url.'&download=1';
        }
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_url = @$this->options['image_versions'][$version]['upload_url'];
            if ($version_url) {
                return $version_url.$this->get_user_path().rawurlencode($file_name);
            }
            $version_path = rawurlencode($version).'/';
        }
        return $this->options['upload_url'].$this->get_user_path()
            .$version_path.rawurlencode($file_name);
    }

    protected function set_additional_file_properties($file) {
        $file->deleteUrl = $this->options['script_url']
            .$this->get_query_separator($this->options['script_url'])
            .$this->get_singular_param_name()
            .'='.rawurlencode($file->name);
        $file->deleteType = $this->options['delete_type'];
        if ($file->deleteType !== 'DELETE') {
            $file->deleteUrl .= '&_method=DELETE';
        }
        if ($this->options['access_control_allow_credentials']) {
            $file->deleteWithCredentials = true;
        }
    }

    // Fix for overflowing signed 32 bit integers,
    // works for sizes up to 2^32-1 bytes (4 GiB - 1):
    protected function fix_integer_overflow($size) {
        if ($size < 0) {
            $size += 2.0 * (PHP_INT_MAX + 1);
        }
        return $size;
    }

    protected function get_file_size($file_path, $clear_stat_cache = false) {
        if ($clear_stat_cache) {
            if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                clearstatcache(true, $file_path);
            } else {
                clearstatcache();
            }
        }
        return $this->fix_integer_overflow(filesize($file_path));
    }

    protected function is_valid_file_object($file_name) {
        $file_path = $this->get_upload_path($file_name);
        if (strlen($file_name) > 0 && $file_name[0] !== '.' && is_file($file_path)) {
            return true;
        }
        return false;
    }

    protected function get_file_object($file_name) {
        if ($this->is_valid_file_object($file_name)) {
            $file = new stdClass();
            $file->name = $file_name;
            $file->size = $this->get_file_size(
                $this->get_upload_path($file_name)
            );
            $file->url = $this->get_download_url($file->name);
            foreach ($this->options['image_versions'] as $version => $options) {
                if (!empty($version)) {
                    if (is_file($this->get_upload_path($file_name, $version))) {
                        $file->{$version.'Url'} = $this->get_download_url(
                            $file->name,
                            $version
                        );
                    }
                }
            }
            $this->set_additional_file_properties($file);
            return $file;
        }
        return null;
    }

    protected function get_file_objects($iteration_method = 'get_file_object') {
        $upload_dir = $this->get_upload_path();
        if (!is_dir($upload_dir)) {
            return array();
        }
        return array_values(array_filter(array_map(
            array($this, $iteration_method),
            scandir($upload_dir)
        )));
    }

    protected function count_file_objects() {
        return count($this->get_file_objects('is_valid_file_object'));
    }

    protected function get_error_message($error) {
        return isset($this->error_messages[$error]) ?
            $this->error_messages[$error] : $error;
    }

    public function get_config_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        if (is_numeric($val)) {
            $val = (int)$val;
        } else {
            $val = (int)substr($val, 0, -1);
        }
        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $this->fix_integer_overflow($val);
    }

    protected function validate($uploaded_file, $file, $error, $index) {
        if ($error) {
            $file->error = $this->get_error_message($error);
            return false;
        }
        $content_length = $this->fix_integer_overflow(
            (int)$this->get_server_var('CONTENT_LENGTH')
        );
        $post_max_size = $this->get_config_bytes(ini_get('post_max_size'));
        if ($post_max_size && ($content_length > $post_max_size)) {
            $file->error = $this->get_error_message('post_max_size');
            return false;
        }
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            $file->error = $this->get_error_message('accept_file_types');
            return false;
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = $this->get_file_size($uploaded_file);
        } else {
            $file_size = $content_length;
        }
        if ($this->options['max_file_size'] && (
                $file_size > $this->options['max_file_size'] ||
                $file->size > $this->options['max_file_size'])
        ) {
            $file->error = $this->get_error_message('max_file_size');
            return false;
        }
        if ($this->options['min_file_size'] &&
            $file_size < $this->options['min_file_size']) {
            $file->error = $this->get_error_message('min_file_size');
            return false;
        }
        if (is_int($this->options['max_number_of_files']) &&
            ($this->count_file_objects() >= $this->options['max_number_of_files']) &&
            // Ignore additional chunks of existing files:
            !is_file($this->get_upload_path($file->name))) {
            $file->error = $this->get_error_message('max_number_of_files');
            return false;
        }
        $max_width = @$this->options['max_width'];
        $max_height = @$this->options['max_height'];
        $min_width = @$this->options['min_width'];
        $min_height = @$this->options['min_height'];
        if (($max_width || $max_height || $min_width || $min_height)
            && $this->is_valid_image_file($uploaded_file)) {
            list($img_width, $img_height) = $this->get_image_size($uploaded_file);
            // If we are auto rotating the image by default, do the checks on
            // the correct orientation
            if (
                @$this->options['image_versions']['']['auto_orient'] &&
                function_exists('exif_read_data') &&
                ($exif = @exif_read_data($uploaded_file)) &&
                (((int) @$exif['Orientation']) >= 5)
            ) {
                $tmp = $img_width;
                $img_width = $img_height;
                $img_height = $tmp;
                unset($tmp);
            }
        }
        if (!empty($img_width) && !empty($img_height)) {
            if ($max_width && $img_width > $max_width) {
                $file->error = $this->get_error_message('max_width');
                return false;
            }
            if ($max_height && $img_height > $max_height) {
                $file->error = $this->get_error_message('max_height');
                return false;
            }
            if ($min_width && $img_width < $min_width) {
                $file->error = $this->get_error_message('min_width');
                return false;
            }
            if ($min_height && $img_height < $min_height) {
                $file->error = $this->get_error_message('min_height');
                return false;
            }
        }
        return true;
    }

    protected function upcount_name_callback($matches) {
        $index = isset($matches[1]) ? ((int)$matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return ' ('.$index.')'.$ext;
    }

    protected function upcount_name($name) {
        return preg_replace_callback(
            '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/',
            array($this, 'upcount_name_callback'),
            $name,
            1
        );
    }

    protected function get_unique_filename($file_path, $name, $size, $type, $error,
        $index, $content_range) {
        while(is_dir($this->get_upload_path($name))) {
            $name = $this->upcount_name($name);
        }
        // Keep an existing filename if this is part of a chunked upload:
        $uploaded_bytes = $this->fix_integer_overflow((int)$content_range[1]);
        while (is_file($this->get_upload_path($name))) {
            if ($uploaded_bytes === $this->get_file_size(
                    $this->get_upload_path($name))) {
                break;
            }
            $name = $this->upcount_name($name);
        }
        return $name;
    }

    protected function fix_file_extension($file_path, $name, $size, $type, $error,
        $index, $content_range) {
        // Add missing file extension for known image types:
        if (strpos($name, '.') === false &&
            preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $name .= '.'.$matches[1];
        }
        if ($this->options['correct_image_extensions']) {
            switch ($this->imagetype($file_path)) {
                case self::IMAGETYPE_JPEG:
                    $extensions = array('jpg', 'jpeg');
                    break;
                case self::IMAGETYPE_PNG:
                    $extensions = array('png');
                    break;
                case self::IMAGETYPE_GIF:
                    $extensions = array('gif');
                    break;
            }
            // Adjust incorrect image file extensions:
            if (!empty($extensions)) {
                $parts = explode('.', $name);
                $extIndex = count($parts) - 1;
                $ext = strtolower(@$parts[$extIndex]);
                if (!in_array($ext, $extensions)) {
                    $parts[$extIndex] = $extensions[0];
                    $name = implode('.', $parts);
                }
            }
        }
        return $name;
    }

    protected function trim_file_name($file_path, $name, $size, $type, $error,
        $index, $content_range) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $name = trim($this->basename(stripslashes($name)), ".\x00..\x20");
        // Replace dots in filenames to avoid security issues with servers
        // that interpret multiple file extensions, e.g. "example.php.png":
        $replacement = $this->options['replace_dots_in_filenames'];
        if (!empty($replacement)) {
            $parts = explode('.', $name);
            if (count($parts) > 2) {
                $ext = array_pop($parts);
                $name = implode($replacement, $parts).'.'.$ext;
            }
        }
        // Use a timestamp for empty filenames:
        if (!$name) {
            $name = str_replace('.', '-', microtime(true));
        }
        return $name;
    }

    protected function get_file_name($file_path, $name, $size, $type, $error,
        $index, $content_range) {
        $name = $this->trim_file_name($file_path, $name, $size, $type, $error,
            $index, $content_range);
        return $this->get_unique_filename(
            $file_path,
            $this->fix_file_extension($file_path, $name, $size, $type, $error,
                $index, $content_range),
            $size,
            $type,
            $error,
            $index,
            $content_range
        );
    }

    protected function get_scaled_image_file_paths($file_name, $version) {
        $file_path = $this->get_upload_path($file_name);
        if (!empty($version)) {
            $version_dir = $this->get_upload_path(null, $version);
            if (!is_dir($version_dir)) {
                mkdir($version_dir, $this->options['mkdir_mode'], true);
            }
            $new_file_path = $version_dir.'/'.$file_name;
        } else {
            $new_file_path = $file_path;
        }
        return array($file_path, $new_file_path);
    }

    protected function gd_get_image_object($file_path, $func, $no_cache = false) {
        if (empty($this->image_objects[$file_path]) || $no_cache) {
            $this->gd_destroy_image_object($file_path);
            $this->image_objects[$file_path] = $func($file_path);
        }
        return $this->image_objects[$file_path];
    }

    protected function gd_set_image_object($file_path, $image) {
        $this->gd_destroy_image_object($file_path);
        $this->image_objects[$file_path] = $image;
    }

    protected function gd_destroy_image_object($file_path) {
        $image = (isset($this->image_objects[$file_path])) ? $this->image_objects[$file_path] : null ;
        return $image && imagedestroy($image);
    }

    protected function gd_imageflip($image, $mode) {
        if (function_exists('imageflip')) {
            return imageflip($image, $mode);
        }
        $new_width = $src_width = imagesx($image);
        $new_height = $src_height = imagesy($image);
        $new_img = imagecreatetruecolor($new_width, $new_height);
        $src_x = 0;
        $src_y = 0;
        switch ($mode) {
            case '1': // flip on the horizontal axis
                $src_y = $new_height - 1;
                $src_height = -$new_height;
                break;
            case '2': // flip on the vertical axis
                $src_x  = $new_width - 1;
                $src_width = -$new_width;
                break;
            case '3': // flip on both axes
                $src_y = $new_height - 1;
                $src_height = -$new_height;
                $src_x  = $new_width - 1;
                $src_width = -$new_width;
                break;
            default:
                return $image;
        }
        imagecopyresampled(
            $new_img,
            $image,
            0,
            0,
            $src_x,
            $src_y,
            $new_width,
            $new_height,
            $src_width,
            $src_height
        );
        return $new_img;
    }

    protected function gd_orient_image($file_path, $src_img) {
        if (!function_exists('exif_read_data')) {
            return false;
        }
        $exif = @exif_read_data($file_path);
        if ($exif === false) {
            return false;
        }
        $orientation = (int)@$exif['Orientation'];
        if ($orientation < 2 || $orientation > 8) {
            return false;
        }
        switch ($orientation) {
            case 2:
                $new_img = $this->gd_imageflip(
                    $src_img,
                    defined('IMG_FLIP_VERTICAL') ? IMG_FLIP_VERTICAL : 2
                );
                break;
            case 3:
                $new_img = imagerotate($src_img, 180, 0);
                break;
            case 4:
                $new_img = $this->gd_imageflip(
                    $src_img,
                    defined('IMG_FLIP_HORIZONTAL') ? IMG_FLIP_HORIZONTAL : 1
                );
                break;
            case 5:
                $tmp_img = $this->gd_imageflip(
                    $src_img,
                    defined('IMG_FLIP_HORIZONTAL') ? IMG_FLIP_HORIZONTAL : 1
                );
                $new_img = imagerotate($tmp_img, 270, 0);
                imagedestroy($tmp_img);
                break;
            case 6:
                $new_img = imagerotate($src_img, 270, 0);
                break;
            case 7:
                $tmp_img = $this->gd_imageflip(
                    $src_img,
                    defined('IMG_FLIP_VERTICAL') ? IMG_FLIP_VERTICAL : 2
                );
                $new_img = imagerotate($tmp_img, 270, 0);
                imagedestroy($tmp_img);
                break;
            case 8:
                $new_img = imagerotate($src_img, 90, 0);
                break;
            default:
                return false;
        }
        $this->gd_set_image_object($file_path, $new_img);
        return true;
    }

    protected function gd_create_scaled_image($file_name, $version, $options) {
        if (!function_exists('imagecreatetruecolor')) {
            error_log('Function not found: imagecreatetruecolor');
            return false;
        }
        list($file_path, $new_file_path) =
            $this->get_scaled_image_file_paths($file_name, $version);
        $type = strtolower(substr(strrchr($file_name, '.'), 1));
        switch ($type) {
            case 'jpg':
            case 'jpeg':
                $src_func = 'imagecreatefromjpeg';
                $write_func = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                    $options['jpeg_quality'] : 75;
                break;
            case 'gif':
                $src_func = 'imagecreatefromgif';
                $write_func = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                $src_func = 'imagecreatefrompng';
                $write_func = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                    $options['png_quality'] : 9;
                break;
            default:
                return false;
        }
        $src_img = $this->gd_get_image_object(
            $file_path,
            $src_func,
            !empty($options['no_cache'])
        );
        $image_oriented = false;
        if (!empty($options['auto_orient']) && $this->gd_orient_image(
                $file_path,
                $src_img
            )) {
            $image_oriented = true;
            $src_img = $this->gd_get_image_object(
                $file_path,
                $src_func
            );
        }
        $max_width = $img_width = imagesx($src_img);
        $max_height = $img_height = imagesy($src_img);
        if (!empty($options['max_width'])) {
            $max_width = $options['max_width'];
        }
        if (!empty($options['max_height'])) {
            $max_height = $options['max_height'];
        }
        $scale = min(
            $max_width / $img_width,
            $max_height / $img_height
        );
        if ($scale >= 1) {
            if ($image_oriented) {
                return $write_func($src_img, $new_file_path, $image_quality);
            }
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        if (empty($options['crop'])) {
            $new_width = $img_width * $scale;
            $new_height = $img_height * $scale;
            $dst_x = 0;
            $dst_y = 0;
            $new_img = imagecreatetruecolor($new_width, $new_height);
        } else {
            if (($img_width / $img_height) >= ($max_width / $max_height)) {
                $new_width = $img_width / ($img_height / $max_height);
                $new_height = $max_height;
            } else {
                $new_width = $max_width;
                $new_height = $img_height / ($img_width / $max_width);
            }
            $dst_x = 0 - ($new_width - $max_width) / 2;
            $dst_y = 0 - ($new_height - $max_height) / 2;
            $new_img = imagecreatetruecolor($max_width, $max_height);
        }
        // Handle transparency in GIF and PNG images:
        switch ($type) {
            case 'gif':
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
                break;
            case 'png':
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
                imagealphablending($new_img, false);
                imagesavealpha($new_img, true);
                break;
        }
        $success = imagecopyresampled(
                $new_img,
                $src_img,
                $dst_x,
                $dst_y,
                0,
                0,
                $new_width,
                $new_height,
                $img_width,
                $img_height
            ) && $write_func($new_img, $new_file_path, $image_quality);
        $this->gd_set_image_object($file_path, $new_img);
        return $success;
    }

    protected function imagick_get_image_object($file_path, $no_cache = false) {
        if (empty($this->image_objects[$file_path]) || $no_cache) {
            $this->imagick_destroy_image_object($file_path);
            $image = new Imagick();
            if (!empty($this->options['imagick_resource_limits'])) {
                foreach ($this->options['imagick_resource_limits'] as $type => $limit) {
                    $image->setResourceLimit($type, $limit);
                }
            }
            try {
                $image->readImage($file_path);
            } catch (ImagickException $e) {
                error_log($e->getMessage());
                return null;
            }
            $this->image_objects[$file_path] = $image;
        }
        return $this->image_objects[$file_path];
    }

    protected function imagick_set_image_object($file_path, $image) {
        $this->imagick_destroy_image_object($file_path);
        $this->image_objects[$file_path] = $image;
    }

    protected function imagick_destroy_image_object($file_path) {
        $image = (isset($this->image_objects[$file_path])) ? $this->image_objects[$file_path] : null ;
        return $image && $image->destroy();
    }

    protected function imagick_orient_image($image) {
        $orientation = $image->getImageOrientation();
        $background = new ImagickPixel('none');
        switch ($orientation) {
            case imagick::ORIENTATION_TOPRIGHT: // 2
                $image->flopImage(); // horizontal flop around y-axis
                break;
            case imagick::ORIENTATION_BOTTOMRIGHT: // 3
                $image->rotateImage($background, 180);
                break;
            case imagick::ORIENTATION_BOTTOMLEFT: // 4
                $image->flipImage(); // vertical flip around x-axis
                break;
            case imagick::ORIENTATION_LEFTTOP: // 5
                $image->flopImage(); // horizontal flop around y-axis
                $image->rotateImage($background, 270);
                break;
            case imagick::ORIENTATION_RIGHTTOP: // 6
                $image->rotateImage($background, 90);
                break;
            case imagick::ORIENTATION_RIGHTBOTTOM: // 7
                $image->flipImage(); // vertical flip around x-axis
                $image->rotateImage($background, 270);
                break;
            case imagick::ORIENTATION_LEFTBOTTOM: // 8
                $image->rotateImage($background, 270);
                break;
            default:
                return false;
        }
        $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT); // 1
        return true;
    }

    protected function imagick_create_scaled_image($file_name, $version, $options) {
        list($file_path, $new_file_path) =
            $this->get_scaled_image_file_paths($file_name, $version);
        $image = $this->imagick_get_image_object(
            $file_path,
            !empty($options['crop']) || !empty($options['no_cache'])
        );
        if (is_null($image)) return false;
        if ($image->getImageFormat() === 'GIF') {
            // Handle animated GIFs:
            $images = $image->coalesceImages();
            foreach ($images as $frame) {
                $image = $frame;
                $this->imagick_set_image_object($file_name, $image);
                break;
            }
        }
        $image_oriented = false;
        if (!empty($options['auto_orient'])) {
            $image_oriented = $this->imagick_orient_image($image);
        }
        $image_resize = false;
        $new_width = $max_width = $img_width = $image->getImageWidth();
        $new_height = $max_height = $img_height = $image->getImageHeight();
        // use isset(). User might be setting max_width = 0 (auto in regular resizing). Value 0 would be considered empty when you use empty()
        if (isset($options['max_width'])) {
            $image_resize = true;
            $new_width = $max_width = $options['max_width'];
        }
        if (isset($options['max_height'])) {
            $image_resize = true;
            $new_height = $max_height = $options['max_height'];
        }
        $image_strip = (isset($options['strip']) ? $options['strip'] : false);
        if ( !$image_oriented && ($max_width >= $img_width) && ($max_height >= $img_height) && !$image_strip && empty($options["jpeg_quality"]) ) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $crop = (isset($options['crop']) ? $options['crop'] : false);

        if ($crop) {
            $x = 0;
            $y = 0;
            if (($img_width / $img_height) >= ($max_width / $max_height)) {
                $new_width = 0; // Enables proportional scaling based on max_height
                $x = ($img_width / ($img_height / $max_height) - $max_width) / 2;
            } else {
                $new_height = 0; // Enables proportional scaling based on max_width
                $y = ($img_height / ($img_width / $max_width) - $max_height) / 2;
            }
        }
        $success = $image->resizeImage(
            $new_width,
            $new_height,
            isset($options['filter']) ? $options['filter'] : imagick::FILTER_LANCZOS,
            isset($options['blur']) ? $options['blur'] : 1,
            $new_width && $new_height // fit image into constraints if not to be cropped
        );
        if ($success && $crop) {
            $success = $image->cropImage(
                $max_width,
                $max_height,
                $x,
                $y
            );
            if ($success) {
                $success = $image->setImagePage($max_width, $max_height, 0, 0);
            }
        }
        $type = strtolower(substr(strrchr($file_name, '.'), 1));
        switch ($type) {
            case 'jpg':
            case 'jpeg':
                if (!empty($options['jpeg_quality'])) {
                    $image->setImageCompression(imagick::COMPRESSION_JPEG);
                    $image->setImageCompressionQuality($options['jpeg_quality']);
                }
                break;
        }
        if ( $image_strip ) {
            $image->stripImage();
        }
        return $success && $image->writeImage($new_file_path);
    }

    protected function imagemagick_create_scaled_image($file_name, $version, $options) {
        list($file_path, $new_file_path) =
            $this->get_scaled_image_file_paths($file_name, $version);
        $resize = @$options['max_width']
            .(empty($options['max_height']) ? '' : 'X'.$options['max_height']);
        if (!$resize && empty($options['auto_orient'])) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $cmd = $this->options['convert_bin'];
        if (!empty($this->options['convert_params'])) {
            $cmd .= ' '.$this->options['convert_params'];
        }
        $cmd .= ' '.escapeshellarg($file_path);
        if (!empty($options['auto_orient'])) {
            $cmd .= ' -auto-orient';
        }
        if ($resize) {
            // Handle animated GIFs:
            $cmd .= ' -coalesce';
            if (empty($options['crop'])) {
                $cmd .= ' -resize '.escapeshellarg($resize.'>');
            } else {
                $cmd .= ' -resize '.escapeshellarg($resize.'^');
                $cmd .= ' -gravity center';
                $cmd .= ' -crop '.escapeshellarg($resize.'+0+0');
            }
            // Make sure the page dimensions are correct (fixes offsets of animated GIFs):
            $cmd .= ' +repage';
        }
        if (!empty($options['convert_params'])) {
            $cmd .= ' '.$options['convert_params'];
        }
        $cmd .= ' '.escapeshellarg($new_file_path);
        exec($cmd, $output, $error);
        if ($error) {
            error_log(implode('\n', $output));
            return false;
        }
        return true;
    }

    protected function get_image_size($file_path) {
        if ($this->options['image_library']) {
            if (extension_loaded('imagick')) {
                $image = new Imagick();
                try {
                    if (@$image->pingImage($file_path)) {
                        $dimensions = array($image->getImageWidth(), $image->getImageHeight());
                        $image->destroy();
                        return $dimensions;
                    }
                    return false;
                } catch (Exception $e) {
                    error_log($e->getMessage());
                }
            }
            if ($this->options['image_library'] === 2) {
                $cmd = $this->options['identify_bin'];
                $cmd .= ' -ping '.escapeshellarg($file_path);
                exec($cmd, $output, $error);
                if (!$error && !empty($output)) {
                    // image.jpg JPEG 1920x1080 1920x1080+0+0 8-bit sRGB 465KB 0.000u 0:00.000
                    $infos = preg_split('/\s+/', substr($output[0], strlen($file_path)));
                    $dimensions = preg_split('/x/', $infos[2]);
                    return $dimensions;
                }
                return false;
            }
        }
        if (!function_exists('getimagesize')) {
            error_log('Function not found: getimagesize');
            return false;
        }
        return @getimagesize($file_path);
    }

    protected function create_scaled_image($file_name, $version, $options) {
        try {
            if ($this->options['image_library'] === 2) {
                return $this->imagemagick_create_scaled_image($file_name, $version, $options);
            }
            if ($this->options['image_library'] && extension_loaded('imagick')) {
                return $this->imagick_create_scaled_image($file_name, $version, $options);
            }
            return $this->gd_create_scaled_image($file_name, $version, $options);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    protected function destroy_image_object($file_path) {
        if ($this->options['image_library'] && extension_loaded('imagick')) {
            return $this->imagick_destroy_image_object($file_path);
        }
    }

    protected function imagetype($file_path) {
        $fp = fopen($file_path, 'r');
        $data = fread($fp, 4);
        fclose($fp);
        // GIF: 47 49 46 38
        if ($data === 'GIF8') {
            return self::IMAGETYPE_GIF;
        }
        // JPG: FF D8 FF
        if (bin2hex(substr($data, 0, 3)) === 'ffd8ff') {
            return self::IMAGETYPE_JPEG;
        }
        // PNG: 89 50 4E 47
        if (bin2hex(@$data[0]).substr($data, 1, 4) === '89PNG') {
            return self::IMAGETYPE_PNG;
        }
        return false;
    }

    protected function is_valid_image_file($file_path) {
        if (!preg_match('/\.(gif|jpe?g|png)$/i', $file_path)) {
            return false;
        }
        return !!$this->imagetype($file_path);
    }

    protected function handle_image_file($file_path, $file) {
        $failed_versions = array();
        foreach ($this->options['image_versions'] as $version => $options) {
            if ($this->create_scaled_image($file->name, $version, $options)) {
                if (!empty($version)) {
                    $file->{$version.'Url'} = $this->get_download_url(
                        $file->name,
                        $version
                    );
                } else {
                    $file->size = $this->get_file_size($file_path, true);
                }
            } else {
                $failed_versions[] = $version ? $version : 'original';
            }
        }
        if (count($failed_versions)) {
            $file->error = $this->get_error_message('image_resize')
                .' ('.implode($failed_versions, ', ').')';
        }
        // Free memory:
        $this->destroy_image_object($file_path);
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
        $index = null, $content_range = null) {
        $file = new stdClass();
        $file->name = $this->get_file_name($uploaded_file, $name, $size, $type, $error,
            $index, $content_range);
        $file->size = $this->fix_integer_overflow((int)$size);
        $file->type = $type;
        if ($this->validate($uploaded_file, $file, $error, $index)) {
            $this->handle_form_data($file, $index);
            $upload_dir = $this->get_upload_path();
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, $this->options['mkdir_mode'], true);
            }
            $file_path = $this->get_upload_path($file->name);
            $append_file = $content_range && is_file($file_path) &&
                $file->size > $this->get_file_size($file_path);
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                        $file_path,
                        fopen($uploaded_file, 'r'),
                        FILE_APPEND
                    );
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                    $file_path,
                    fopen($this->options['input_stream'], 'r'),
                    $append_file ? FILE_APPEND : 0
                );
            }
            $file_size = $this->get_file_size($file_path, $append_file);
            if ($file_size === $file->size) {
                $file->url = $this->get_download_url($file->name);
                if ($this->is_valid_image_file($file_path)) {
                    $this->handle_image_file($file_path, $file);
                }
            } else {
                $file->size = $file_size;
                if (!$content_range && $this->options['discard_aborted_uploads']) {
                    unlink($file_path);
                    $file->error = $this->get_error_message('abort');
                }
            }
            $this->set_additional_file_properties($file);
        }
        return $file;
    }

    protected function readfile($file_path) {
        $file_size = $this->get_file_size($file_path);
        $chunk_size = $this->options['readfile_chunk_size'];
        if ($chunk_size && $file_size > $chunk_size) {
            $handle = fopen($file_path, 'rb');
            while (!feof($handle)) {
                echo fread($handle, $chunk_size);
                @ob_flush();
                @flush();
            }
            fclose($handle);
            return $file_size;
        }
        return readfile($file_path);
    }

    protected function body($str) {
        echo $str;
    }

    protected function header($str) {
        header($str);
    }

    protected function get_upload_data($id) {
        return @$_FILES[$id];
    }

    protected function get_post_param($id) {
        return @$_POST[$id];
    }

    protected function get_query_param($id) {
        return @$_GET[$id];
    }

    protected function get_server_var($id) {
        return @$_SERVER[$id];
    }

    protected function handle_form_data($file, $index) {
        // Handle form data, e.g. $_POST['description'][$index]
    }

    protected function get_version_param() {
        return $this->basename(stripslashes($this->get_query_param('version')));
    }

    protected function get_singular_param_name() {
        return substr($this->options['param_name'], 0, -1);
    }

    protected function get_file_name_param() {
        $name = $this->get_singular_param_name();
        return $this->basename(stripslashes($this->get_query_param($name)));
    }

    protected function get_file_names_params() {
        $params = $this->get_query_param($this->options['param_name']);
        if (!$params) {
            return null;
        }
        foreach ($params as $key => $value) {
            $params[$key] = $this->basename(stripslashes($value));
        }
        return $params;
    }

    protected function get_file_type($file_path) {
        switch (strtolower(pathinfo($file_path, PATHINFO_EXTENSION))) {
            case 'jpeg':
            case 'jpg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            default:
                return '';
        }
    }

    protected function download() {
        switch ($this->options['download_via_php']) {
            case 1:
                $redirect_header = null;
                break;
            case 2:
                $redirect_header = 'X-Sendfile';
                break;
            case 3:
                $redirect_header = 'X-Accel-Redirect';
                break;
            default:
                return $this->header('HTTP/1.1 403 Forbidden');
        }
        $file_name = $this->get_file_name_param();
        if (!$this->is_valid_file_object($file_name)) {
            return $this->header('HTTP/1.1 404 Not Found');
        }
        if ($redirect_header) {
            return $this->header(
                $redirect_header.': '.$this->get_download_url(
                    $file_name,
                    $this->get_version_param(),
                    true
                )
            );
        }
        $file_path = $this->get_upload_path($file_name, $this->get_version_param());
        // Prevent browsers from MIME-sniffing the content-type:
        $this->header('X-Content-Type-Options: nosniff');
        if (!preg_match($this->options['inline_file_types'], $file_name)) {
            $this->header('Content-Type: application/octet-stream');
            $this->header('Content-Disposition: attachment; filename="'.$file_name.'"');
        } else {
            $this->header('Content-Type: '.$this->get_file_type($file_path));
            $this->header('Content-Disposition: inline; filename="'.$file_name.'"');
        }
        $this->header('Content-Length: '.$this->get_file_size($file_path));
        $this->header('Last-Modified: '.gmdate('D, d M Y H:i:s T', filemtime($file_path)));
        $this->readfile($file_path);
    }

    protected function send_content_type_header() {
        $this->header('Vary: Accept');
        if (strpos($this->get_server_var('HTTP_ACCEPT'), 'application/json') !== false) {
            $this->header('Content-type: application/json');
        } else {
            $this->header('Content-type: text/plain');
        }
    }

    protected function send_access_control_headers() {
        $this->header('Access-Control-Allow-Origin: '.$this->options['access_control_allow_origin']);
        $this->header('Access-Control-Allow-Credentials: '
            .($this->options['access_control_allow_credentials'] ? 'true' : 'false'));
        $this->header('Access-Control-Allow-Methods: '
            .implode(', ', $this->options['access_control_allow_methods']));
        $this->header('Access-Control-Allow-Headers: '
            .implode(', ', $this->options['access_control_allow_headers']));
    }

    public function generate_response($content, $print_response = true) {
        $this->response = $content;
        if ($print_response) {
            $json = json_encode($content);
            $redirect = stripslashes($this->get_post_param('redirect'));
            if ($redirect && preg_match($this->options['redirect_allow_target'], $redirect)) {
                return $this->header('Location: '.sprintf($redirect, rawurlencode($json)));
            }
            $this->head();
            if ($this->get_server_var('HTTP_CONTENT_RANGE')) {
                $files = isset($content[$this->options['param_name']]) ?
                    $content[$this->options['param_name']] : null;
                if ($files && is_array($files) && is_object($files[0]) && $files[0]->size) {
                    $this->header('Range: 0-'.(
                        $this->fix_integer_overflow((int)$files[0]->size) - 1
                    ));
                }
            }
            $this->body($json);
        }
        return $content;
    }

    public function get_response () {
        return $this->response;
    }

    public function head() {
        $this->header('Pragma: no-cache');
        $this->header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->header('Content-Disposition: inline; filename="files.json"');
        // Prevent Internet Explorer from MIME-sniffing the content-type:
        $this->header('X-Content-Type-Options: nosniff');
        if ($this->options['access_control_allow_origin']) {
            $this->send_access_control_headers();
        }
        $this->send_content_type_header();
    }

	public function get($print_response = true) {
        if ($print_response && $this->get_query_param('download')) {
            return $this->download();
        }
        $file_name = $this->get_file_name_param();
        if ($file_name) {
            $response = array(
                $this->get_singular_param_name() => $this->get_file_object($file_name)
            );
        } else {
            $response = array(
                $this->options['param_name'] => $this->get_file_objects()
            );
        }
		#echo "<pre>"; print_r($_REQUEST); echo "call_the_get";
        return $this->generate_response($response, $print_response);
    }

    protected function basename($filepath, $suffix = null) {
        $splited = preg_split('/\//', rtrim ($filepath, '/ '));
        return substr(basename('X'.$splited[count($splited)-1], $suffix), 1);
    }

/*	원형함수 보관함.
	public function post($print_response = true) {
        if ($this->get_query_param('_method') === 'DELETE') {
            return $this->delete($print_response);
        }
        $upload = $this->get_upload_data($this->options['param_name']);
        // Parse the Content-Disposition header, if available:
        $content_disposition_header = $this->get_server_var('HTTP_CONTENT_DISPOSITION');
        $file_name = $content_disposition_header ?
            rawurldecode(preg_replace(
                '/(^[^"]+")|("$)/',
                '',
                $content_disposition_header
            )) : null;
        // Parse the Content-Range header, which has the following form:
        // Content-Range: bytes 0-524287/2000000
        $content_range_header = $this->get_server_var('HTTP_CONTENT_RANGE');
        $content_range = $content_range_header ?
            preg_split('/[^0-9]+/', $content_range_header) : null;
        $size =  $content_range ? $content_range[3] : null;
        $files = array();
        if ($upload) {
            if (is_array($upload['tmp_name'])) {
                // param_name is an array identifier like "files[]",
                // $upload is a multi-dimensional array:
                foreach ($upload['tmp_name'] as $index => $value) {
                    $files[] = $this->handle_file_upload(
                        $upload['tmp_name'][$index],
                        $file_name ? $file_name : $upload['name'][$index],
                        $size ? $size : $upload['size'][$index],
                        $upload['type'][$index],
                        $upload['error'][$index],
                        $index,
                        $content_range
                    );
                }
            } else {
                // param_name is a single object identifier like "file",
                // $upload is a one-dimensional array:
                $files[] = $this->handle_file_upload(
                    isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                    $file_name ? $file_name : (isset($upload['name']) ?
                        $upload['name'] : null),
                    $size ? $size : (isset($upload['size']) ?
                        $upload['size'] : $this->get_server_var('CONTENT_LENGTH')),
                    isset($upload['type']) ?
                        $upload['type'] : $this->get_server_var('CONTENT_TYPE'),
                    isset($upload['error']) ? $upload['error'] : null,
                    null,
                    $content_range
                );
            }
        }
        $response = array($this->options['param_name'] => $files);
        return $this->generate_response($response, $print_response);
    }

	public function delete($print_response = true) {
        $file_names = $this->get_file_names_params();
        if (empty($file_names)) {
            $file_names = array($this->get_file_name_param());
        }
        $response = array();
        foreach ($file_names as $file_name) {
            $file_path = $this->get_upload_path($file_name);
            $success = strlen($file_name) > 0 && $file_name[0] !== '.' && is_file($file_path) && unlink($file_path);
            if ($success) {
                foreach ($this->options['image_versions'] as $version => $options) {
                    if (!empty($version)) {
                        $file = $this->get_upload_path($file_name, $version);
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }
                }
            }
            $response[$file_name] = $success;
        }
        return $this->generate_response($response, $print_response);
    }

*/
}



#require('UploadHandler_org.php');
$upload_handler = new UploadHandler();
?>