<?

	include ("./inc/config.php");
	include ("./inc/function.php");

	$number		= $_GET["number"];
	$idx		= $_GET["idx"];
	$fileName	= $_GET["file"];
	$referer	= $_SERVER["HTTP_REFERER"];
	$referer	= str_replace(" ","",$referer);

	if ( $referer == "" )
	{
		exit;
	}
	else if ( !eregi($cookie_url,$referer) )
	{
		exit;
	}
	else if ( happy_member_login_check == "" && !$_COOKIE["ad_id"] )
	{
		exit;
	}

	$Sql	= "
		SELECT
				fileName${idx},
				user_id
		FROM
				$per_document_tb
		WHERE
				number	= '$number'
	";
	$Data	= @happy_mysql_fetch_array(query($Sql));



        $filename_real	=  $per_document_file."/". $Data["user_id"] ."_". $number ."_". $idx;
		$filesize		= @filesize($filename_real);

        if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT))
        {
          if(strstr($HTTP_USER_AGENT, "MSIE 5.5"))
          {
                header("Content-Type: doesn/matter");
                header("Content-disposition: filename=$fileName");
                header("Content-Transfer-Encoding: binary");
                header("Pragma: no-cache");
                header("Expires: 0");
          }

          if(strstr($HTTP_USER_AGENT, "MSIE 5.0"))
          {
                Header("Content-type: file/unknown");
                header("Content-Disposition: attachment; filename=$fileName");
                Header("Content-Description: PHP3 Generated Data");
                header("Pragma: no-cache");
                header("Expires: 0");
          }

          if(strstr($HTTP_USER_AGENT, "MSIE 5.1"))
          {
                Header("Content-type: file/unknown");
                header("Content-Disposition: attachment; filename=$fileName");
                Header("Content-Description: PHP3 Generated Data");
                header("Pragma: no-cache");
                header("Expires: 0");
          }

          if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
          {
                Header("Content-type: application/x-msdownload");
                Header("Content-Length: ".$filesize);
                Header("Content-Disposition: attachment; filename=$fileName");
                Header("Content-Transfer-Encoding: binary");
                Header("Pragma: no-cache");
                Header("Expires: 0");
          }
        } else {
          Header("Content-type: file/unknown");
          Header("Content-Length: ".$filesize);
          Header("Content-Disposition: attachment; filename=$fileName");
          Header("Content-Description: PHP3 Generated Data");
          Header("Pragma: no-cache");
          Header("Expires: 0");
        }

        if ( is_file($filename_real)) {
          $fp = @fopen($filename_real, "rb");

        if (!fpassthru($fp))
                @fclose($fp);

        } else {
          echo "해당 파일이나 경로가 존재하지 않습니다.";
        }
?>