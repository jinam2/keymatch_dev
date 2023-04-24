<?php
	// step 3

	$profile_id		= $_COOKIE['profile_id'];
	$start_date		= $_COOKIE['start_date'];
	$end_date		= $_COOKIE['end_date'];

	if ( $profile_id == "" || $start_date == "" || $end_date == "" )
	{
		echo "ERROR:2001";
		exit;
	}

?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
	<meta http-equiv='Cache-Control' content='No-Cache'>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	<title>Google Analytics Reporting</title>
	<style>
		/* Reset */
		html,body{width:100%;height:100%;}

		html>/**/body { overflow-y:scroll; }

		body,div,table,th,td,h1,h2,h3,h4,h5,form,fieldset,p,button,legend,input,textarea,button,select{margin:0;padding:0; font-family:'돋움',Dotum,'굴림',tahoma,Gulim,'맑은고딕',NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif; font-size:12px; color:#6c6c6c;}
		body{background-color:#fff;*word-break:break-all;-ms-word-break:break-all}
		h1,h2,h3,h4,h5,h6{text-align:left;}
		img,fieldset,iframe,input,button{border:0 none;}
		input,select,button{vertical-align:middle;}
		img{vertical-align:middle;}
		i,em,address{font-style:normal;}
		button{cursor:pointer;}
		button{margin:0;padding:0;}
		a{color:#6c6c6c;text-decoration:none;}
		a:hover{color:#6c6c6c;text-decoration:none;}
		legend{*width:0; position:absolute; width:1px; height:1px; font-size:0; line-height:0; overflow:hidden;}
		caption {padding:0; height:0; font-size:0; line-height:0; overflow:hidden;}
	</style>
</head>

<body style="background:#f4f4f4;">

	<iframe src="returnback.php" style="display:none"></iframe>

	<table cellspacing="0" cellpadding="0" style="width:100%; background:#f4f4f4;">
	<tr>
		<td style="background:#f6f6f6; border-bottom:1px solid #d9d9d9; padding:25px 0;" align="center"><img src="img/title_google_anly.jpg" alt="구글통계정보 수집중" title="구글통계정보 수집중"></td>
	</tr>
	<tr>
		<td style="padding:70px 0; background:#ffffff; " align="center"><img src="img/loding.gif" alt="구글통계정보 수집중" title="구글통계정보 수집중"></td>
	</tr>
	<tr>
		<td style="border-top:1px solid #d9d9d9; padding:15px 0;"  align="center"><img src="img/bottom_google_anly.jpg" alt="구글통계정보 수집중" title="구글통계정보 수집중"></td>
	</tr>
	</table>

</body>
</html>