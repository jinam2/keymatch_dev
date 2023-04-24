<?PHP
/********************************************************
*														*
*	CREATED BY Hun ON 2105-12-29						*
*	Copyright 1997 cgimall All rights reserved			*
*														*
********************************************************/
include "../../../../inc/config.php";
include "../../../../inc/function.php";

$relative_path				= ".".preg_replace("`\/[^/]*\.php$`i", "/", $_SERVER['PHP_SELF']);	//경로 가져오기.
$img_main_url				= '';																//위지윅이 설치된 경로,설치폴더 예를들어 /news 폴더 하부에 설치가 되어 있는 경우 "/news" 로 지정

$file_attach_folder			= "/wys2/file_attach";												//업로드 폴더 지정
$file_attach_thumb_folder	= "/wys2/file_attach_thumb";										//썸네일 업로드 폴더 지정

$jaego_attach_folder		= "../../../../$file_attach_folder";
$thumb_jaego_attach_folder	= "../../../../$file_attach_thumb_folder";


// This is the function that sends the results of the uploading process.
function SendResults( $errorNumber, $fileUrl = '', $fileName = '', $customMsg = '' )
{
	echo '<script type="text/javascript">' ;
	echo 'window.parent.OnUploadCompleted(' . $errorNumber . ',"' . str_replace( '"', '\\"', $fileUrl ) . '","' . str_replace( '"', '\\"', $fileName ) . '", "' . str_replace( '"', '\\"', $customMsg ) . '") ;' ;
	echo '</script>' ;
	exit ;
}

//ckedtior 용
function SendResults2( $funcNum, $url = '', $message = '' )
{
	//echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message')</script>";
	//exit;

	echo "<script type='text/javascript'>";
	echo "window.parent.CKEDITOR.tools.callFunction(".$funcNum.", '".$url."', '".$message."')";
	echo "</script>";
	exit ;
}


if( !is_dir("$jaego_attach_folder") )
{
	//SendResults( '1', '', '', "첨부파일을 위한 ($jaego_attach_folder)폴더가 존재하지 않습니다.  " ) ;
	SendResults2( $funcNum, '', "첨부파일을 위한 ($jaego_attach_folder)폴더가 존재하지 않습니다." ) ;
	exit;
}

$now_year					= date("Y");
$now_year					= $now_year;
$now_month					= date("m");
$now_day					= date("d");



$oldmask = umask(0);
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

if (!is_dir("$thumb_jaego_attach_folder"))
{
	//SendResults( '1', '', '', "첨부파일을 위한 ($thumb_jaego_attach_folder)폴더가 존재하지 않습니다.   " ) ;
	SendResults2( $funcNum, '', '', "첨부파일을 위한 ($thumb_jaego_attach_folder)폴더가 존재하지 않습니다." ) ;
	exit;
}

$oldmask = umask(0);
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

$attach_folder_path = "$img_main_url$jaego_attach_folder/$now_year/$now_month/$now_day/";
$attach_folder_url = "$file_attach_folder/$now_year/$now_month/$now_day/";

// SECURITY: You must explicitelly enable this "uploader".
$Config['Enabled'] = true ;

// Path to uploaded files relative to the document root.
$Config['UserFilesPath'] = $attach_folder_url;

$Config['UserFilesAbsolutePath'] = $attach_folder_path;

// Due to security issues with Apache modules, it is reccomended to leave the
// following setting enabled.
$Config['ForceSingleExtension'] = true ;

$Config['AllowedExtensions']['File']	= array() ;
$Config['DeniedExtensions']['File']		= array('php','php2','php3','php4','php5','phtml','pwml','inc','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','com','dll','vbs','js','reg','cgi') ;

$Config['AllowedExtensions']['Image']	= array('jpg','gif','jpeg','png') ;
$Config['DeniedExtensions']['Image']	= array() ;

$Config['AllowedExtensions']['Flash']	= array('swf','fla') ;
$Config['DeniedExtensions']['Flash']	= array() ;
?>