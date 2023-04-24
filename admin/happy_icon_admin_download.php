<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");

	#관리자 접속 체크 루틴
	if ( !admin_secure("환경설정") ) {
		error("접속권한이 없습니다.   ");
		exit;
	}
	#관리자 접속 체크 루틴

	$file_name = $_GET['file_name'];

	$allow_ext	= Array("jpg","jpeg","gif","png");
	$temp_name	= explode(".",$file_name);
	$ext		= strtolower($temp_name[sizeof($temp_name)-1]);
	if ( !in_Array($ext,$allow_ext) )
	{
		msg("잘못된 파일형식 입니다.");
		exit;
	}

	$file_url	= "../".$file_name;
	$file_size	= @filesize($file_url);
	fileDownLoad();


	function fileDownLoad()
	{
		global $file_name,$file_url,$file_size, $HTTP_USER_AGENT;

		Header("Content-type: application/octet-stream");
		Header("Content-length: $file_size");
		Header("Content-Disposition: inline; filename=$file_name");


		if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT))
		{
		  if(strstr($HTTP_USER_AGENT, "MSIE 5.5"))
		  {
				header("Content-Type: doesn/matter");
				header("Content-disposition: filename=$file_name");
				header("Content-Transfer-Encoding: binary");
				header("Pragma: no-cache");
				header("Expires: 0");
		  }

		  if(strstr($HTTP_USER_AGENT, "MSIE 5.0"))
		  {
				Header("Content-type: file/unknown");
				header("Content-Disposition: attachment; filename=$file_name");
				Header("Content-Description: PHP3 Generated Data");
				header("Pragma: no-cache");
				header("Expires: 0");
		  }

		  if(strstr($HTTP_USER_AGENT, "MSIE 5.1"))
		  {
				Header("Content-type: file/unknown");
				header("Content-Disposition: attachment; filename=$file_name");
				Header("Content-Description: PHP3 Generated Data");
				header("Pragma: no-cache");
				header("Expires: 0");
		  }

		  if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
		  {
				Header("Content-type: application/x-msdownload");
				Header("Content-Length: ".(string)(filesize("$file_url")));
				Header("Content-Disposition: attachment; filename=$file_name");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
		  }
		} else {
		  Header("Content-type: file/unknown");
		  Header("Content-Length: ".(string)(filesize("$file_url")));
		  Header("Content-Disposition: attachment; filename=$file_name");
		  Header("Content-Description: PHP3 Generated Data");
		  Header("Pragma: no-cache");
		  Header("Expires: 0");
		}

		if (is_file("$file_url")) {
		  $fp = fopen("$file_url", "rb");

		if (!fpassthru($fp))
				fclose($fp);

		} else {
		  echo "해당 파일이나 경로가 존재하지 않습니다.";
		}

	}
?>