<?php
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	$ext_check = "ok"; //happy_image 안에 있는 업로드이미지함수 확장자통과
	$get_file_name = $_GET['file_name'];
	if ( !$get_file_name )	# number , groupid 값이 모두 없을경우엔 빈배너이미지로
	{
		$get_file_name	= $HAPPY_CONFIG['ImgNoImage1'];
	}

	echo "
			<!--모바일 전용 meta소스-->
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=11.0, user-scalable=20' charset='euc-kr'/>
			<meta name='format-detection' content='telephone=no'/>
			<meta name='apple-mobile-web-app-capable' content='yes'>
			<meta name='apple-mobile-web-app-status-bar-style' content='black'>

			<table cellspacing='0' cellpadding='0' border='0' style='width:100%;'>
				<tr>
					<td align='center' style='padding:10px;'>
						<a href='javascript:window.close();' >
							<div class='freeimg'><img src='$get_file_name' border='0'></div>
						</a>
					</td>
				</tr>
			</table>

	";
	exit;

?>