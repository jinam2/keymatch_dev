<?php
	include ("./inc/config.php");
	include ("./inc/function.php");


	$number		= preg_replace('/\D/','',$_GET['number']);
	$groupid	= preg_replace('/\D/','',$_GET['groupid']);

	$banner_no_banner_img	= $banner_no_banner_img == "" ? "img/no_banner.gif" : $banner_no_banner_img;

	if ( !$number && !$groupid )	# number , groupid 값이 모두 없을경우엔 빈배너이미지로
	{
		$FileName	= $banner_no_banner_img;
	}
	else
	{
		#그룹아이디가 있을경우 그룹아이디를 기준으로 number값 추출
		if ( $groupid )
		{
			$Sql	= "SELECT number FROM $happy_banner_tb WHERE groupid='$groupid' ORDER BY rand() LIMIT 1";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			$number	= $Tmp['number'];
		}

		$Sql	= "SELECT img,groupid FROM $happy_banner_tb WHERE number='$number'";
		$Data	= happy_mysql_fetch_array(query($Sql));

		#파일네임 지정 파일이 없을경우 빈배너이미지로
		$FileName	= is_file($Data['img'])?$Data['img']:$banner_no_banner_img;

		#해당배너 정보 업그레이드
		query("UPDATE $happy_banner_tb SET viewcount=viewcount+1, viewdate=now() WHERE number='$number'");

		#로고쌓기
		$date	= date("Y-m-d");
		$nTime	= date("H");
		$dates	= explode("-",$date);
		$group	= $Data['groupid'];

		$Sql	= "SELECT count(number) FROM $happy_banner_log_tb WHERE regdate='$date' AND nTime='$nTime' AND bannerID = '$number'";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp[0] == 0 )
		{
			$Sql	= "
						INSERT INTO
								$happy_banner_log_tb
						SET
								bannerID	= '$number',
								groupID		= '$group',
								regdate		= '$date',
								year		= '$dates[0]',
								month		= '$dates[1]',
								day			= '$dates[2]',
								nTime		= '$nTime',
								viewcount	= '1',
								linkcount	= '0'
			";
		}
		else
		{
			$Sql	= "
						UPDATE
								$happy_banner_log_tb
						SET
								viewcount	= viewcount + 1
						WHERE
								regdate		= '$date'
								AND
								nTime		= '$nTime'
								AND
								bannerID	= '$number'
			";
		}
		query($Sql);


	}


	#파일체크
	$file_url	= $FileName;

	if ( !is_file($file_url) )
	{
		echo "해당 파일이나 경로가 존재하지 않습니다.";
		exit;
	}

	$file_size	= filesize($file_url);
	$ext		= explode(".",$FileName);
	$ext		= $ext[sizeof($ext)-1];
	$file_name	= rand(1884234310,3000221101).".".$ext;






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