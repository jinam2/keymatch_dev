<?PHP
require_once('../secure_config.php') ;												//보안설정
require_once('../config.php') ;																	//에디터 모듈 통합설정

$now_year					= date("Y");
$now_month					= date("m");
$now_day					= date("d");

if ( is_dir($jaego_attach_folder) === false )
{
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

$bSuccessUpload				= is_uploaded_file($_FILES['Filedata']['tmp_name']);

if( $bSuccessUpload )
{
	//성공 시 파일 사이즈와 URL 전송

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
			msg('등록이 불가능한 확장자 입니다.');
		}
	}

	$new_path				= "../../../$file_attach_folder/$now_year/$now_month/$now_day/".$file_name;
	$file_url				= str_replace("//","/","$wys_url/$file_attach_folder/$now_year/$now_month/$now_day/$file_name");

	move_uploaded_file($tmp_name, $new_path);

	print "SUCCESS___CUT___".make_link_tag($file_url);
}
else
{
	msg("선택 된 파일이 없습니다.");
}
?>