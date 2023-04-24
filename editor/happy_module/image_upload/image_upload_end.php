<?PHP
require_once('../secure_config.php') ;												//보안설정
require_once('../config.php') ;																	//에디터 모듈 통합설정

$now_year					= date("Y");
$now_month					= date("m");
$now_day					= date("d");

if ( is_dir($jaego_attach_folder) === false )
{
	upload_btn_replay();
	msg("이미지 업로드를 위한 ($jaego_attach_folder)폴더가 존재하지 않습니다.");
}

$oldmask					= umask(0);
if (!is_dir("$jaego_attach_folder/$now_year"))
{
	mkdir("$jaego_attach_folder/$now_year", 0777);
}
if (!is_dir("$jaego_attach_folder/$now_year/$now_month"))
{
	mkdir("$jaego_attach_folder/$now_year/$now_month", 0777);
}
if (!is_dir("$jaego_attach_folder/$now_year/$now_month/$now_day"))
{
	mkdir("$jaego_attach_folder/$now_year/$now_month/$now_day", 0777);
}
umask($oldmask);

if ( is_dir("$thumb_jaego_attach_folder") === false )
{
	upload_btn_replay();
	msg("첨부파일을 위한 ($thumb_jaego_attach_folder)폴더가 존재하지 않습니다.   ");
}

$oldmask					= umask(0);
if (!is_dir("$thumb_jaego_attach_folder/$now_year"))
{
	mkdir("$thumb_jaego_attach_folder/$now_year", 0777);
}
if (!is_dir("$thumb_jaego_attach_folder/$now_year/$now_month"))
{
	mkdir("$thumb_jaego_attach_folder/$now_year/$now_month", 0777);
}
if (!is_dir("$thumb_jaego_attach_folder/$now_year/$now_month/$now_day"))
{
	mkdir("$thumb_jaego_attach_folder/$now_year/$now_month/$now_day", 0777);
}
umask($oldmask);

$thumb_type					= $_POST['thumb_type'];
$thumb_width				= preg_replace("/\D/", "", $_POST['thumb_width']);
$thumb_height				= preg_replace("/\D/", "", $_POST['thumb_height']);
$thumb_position				= preg_replace("/\D/", "", $_POST['thumb_position']);
$thumb_logo					= $_POST['thumb_logo'];
$thumb_logo_position		= preg_replace("/\D/", "", $_POST['thumb_logo_position']);

$image_border				= preg_replace("/\D/", "", $_POST['image_border']);
$image_border_color			= $_POST['image_border_color'];
$image_align				= $_POST['image_align'];
$image_alt					= $_POST['image_alt'];

if ( $thumb_type == '' )
{
	upload_btn_replay();
	msg("썸네일형식을 선택 해주세요.");
	exit;
}

if ( $thumb_width == '' || $thumb_width < 1 )
{
	upload_btn_replay();
	msg("이미지크기(가로)를 입력 해주세요.");
	exit;
}

if ( $thumb_height == '' || $thumb_height < 1 )
{
	upload_btn_replay();
	msg("이미지크기(세로)를 입력 해주세요.");
	exit;
}

if ( $thumb_position == '' )
{
	upload_btn_replay();
	msg("썸네일 무빙 위치를 선택 해주세요.");
	exit;
}

if ( $thumb_logo == 'y' && $thumb_logo_position == '' )
{
	upload_btn_replay();
	msg("로고위치를 선택 해주세요.");
	exit;
}

$bSuccessUpload				= is_uploaded_file($_FILES['Filedata']['tmp_name']);

if( $bSuccessUpload )
{
	$tmp_name				= $_FILES['Filedata']['tmp_name'];
	$name					= $_FILES['Filedata']['name'];
	$ext					= explode('.', $name);
	$ext					= strtolower($ext[sizeof($ext)-1]);
	$file_name				= happy_mktime().'_'.rand(10000,99999).'.'.$ext;
	$file_name2				= happy_mktime().'_'.rand(100000,999999).'.'.$ext;

	if( $HAPPY_ALLOW_FILE_USE == 'on' )
	{
		if ( array_search($ext, $HAPPY_ALLOW_FILE_EXT) === false )
		{
			upload_btn_replay();
			msg('등록이 불가능한 확장자 입니다.');
		}
	}

	if ( $ext != "jpg" && $ext != "gif" && $ext != "png" && $ext != "jpeg" )
	{
		upload_btn_replay();
		msg('등록이 불가능한 확장자 입니다.');
	}


	$new_path				= "../../../$file_attach_folder/$now_year/$now_month/$now_day/".$file_name;
	$new_path_tmp			= "../../../$file_attach_folder/$now_year/$now_month/$now_day/".$file_name2;
	$thumb_path				= "../../../$file_attach_thumb_folder/$now_year/$now_month/$now_day/".$file_name;

	$tmp_name		= HAPPY_EXIF_READ_CHANGE2($tmp_name);

	@move_uploaded_file($tmp_name, $new_path_tmp);

	if ( $thumb_logo == 'y' )
	{
		$thumb_logo				= $logo_file;
	}
	else
	{
		$thumb_logo				= '';
	}

	if ( $small_image_make == '1' )
	{
		$thumb_path				= imageUploadNew($new_path_tmp, $thumb_path, $small_image_width, $small_image_height, $small_image_quality, $small_image_type, $small_image_position);
	}

	$IMAGE					= ARRAY();

	/*			원본출력일 경우 원본을 그대로 사용하자.		*/
	$new_imgsize		= getimagesize($new_path_tmp);
	$IMAGE['WIDTH']		= $new_imgsize[0];
	$IMAGE['HEIGHT']	= $new_imgsize[1];

	if( $_POST['print_org'] != 'y' && $IMAGE['WIDTH'] < $_POST['print_org_maxwidth'] ){
		$_POST['print_org']			= 'n';
	}

	if( $_POST['print_org'] == 'y' )
	{
		copy($new_path_tmp,$new_path);

		//이미지 원본 출력할 경우 이미지원본의 사이즈를 구해서 width, height 를 구성해 주자.
		//$new_imgsize		= getimagesize($new_path);
		//$IMAGE['WIDTH']		= $new_imgsize[0];
		//$IMAGE['HEIGHT']	= $new_imgsize[1];
	}
	/*			애니메이션 GIF 가 아닐 경우에만 썸네일을 만든다.		*/
	else if( preg_match("/gif/i",$ext) && $multi_image_upload_gif != "gif썸네일" )		//GIF 이면서 GIF 썸네일 생성방식이 gif애니메이션원본출력 , gif원본출력 일 경우...
	{
		if ( $multi_image_upload_gif == "gif애니메이션원본출력" )
		{
			if( !is_animation($new_path_tmp) )
			{
				$new_path				= imageUploadNew($new_path_tmp, $new_path, $thumb_width, $thumb_height, 100, $thumb_type, $thumb_position, $thumb_logo, $thumb_logo_position);
			}
			else
			{
				rename($new_path_tmp,$new_path);
			}
		}
		else
		{
			rename($new_path_tmp,$new_path);
		}
	}
	else
	{
		$new_path				= imageUploadNew($new_path_tmp, $new_path, $thumb_width, $thumb_height, 100, $thumb_type, $thumb_position, $thumb_logo, $thumb_logo_position);
	}
	@unlink($new_path_tmp);


	$IMAGE['FILE_PATH']			= "$img_main_url/$file_attach_folder/$now_year/$now_month/$now_day/$file_name";
	$IMAGE['IMAGE_ALIGN']		= $image_align;
	$IMAGE['IMAGE_ALT']			= $image_alt;
	$IMAGE['IMAGE_BORDER']		= $image_border;
	$IMAGE['IMAGE_BORDER_COLOR']= $image_border_color;
	$IMAGE['WIDTH']				= ( $IMAGE['WIDTH'] == '' )?$thumb_width:$IMAGE['WIDTH'];
	$IMAGE['HEIGHT']			= ( $IMAGE['HEIGHT'] == '' )?$thumb_height:$IMAGE['HEIGHT'];
	//$IMAGE['HEIGHT']			= $thumb_height;

	print make_image_upload_tag($IMAGE);
}
else
{
	upload_btn_replay();
	msg("선택 된 파일이 없습니다.");
}
?>