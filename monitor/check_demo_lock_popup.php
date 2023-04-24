<?php

	$config_include_folder		= ( is_file("../master/config.php") ) ? "../master" : "../inc";

	include($config_include_folder."/config.php");
	include("../inc/function.php");
	include("inc/monitor_config.php");
	include("inc/monitor_lib.php");

	if ( !is_admin() )
	{
		exit;
	}

	$demo_lock_data	= happy_monitor_check_demo_lock();
?>

<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>솔루션 기본 데모락 자세히보기</title>

<style type="text/css">
body, table, td { margin:0; padding:0;}
.font_11 { font-size:11px;}
.font_12 { font-size:12px;}
.font_14 { font-size:14px;}
.font_16 { font-size:16px;}


.font_dotum{font-family:'돋움',Dotum,'맑은고딕','굴림',Gulim,tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif;}
.font_gulim{font-family:'굴림',Gulim,'돋움',Dotum,'맑은고딕',tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif;}
.font_malgun{font-family:'맑은고딕','돋움',Dotum,'굴림',Gulim,tahoma,NanumGothic,Helvetica,'Apple SD Gothic Neo',Sans-serif !important;}

.info_td_title{
padding:12px 0;
background:#f7f7f7;
color:#20232c;
line-height:18px;
letter-spacing:0px;
text-align:center;
}


.info_td_content{
padding:15px 10px;
background:#ffffff;
color:#20232c;
line-height:18px;
letter-spacing:0px;
}


.line-bottom_st_01{border-bottom:1px solid #dddde1;}
.line-bottom_st_02{border-bottom:1px solid #eeeef0;}
.line-right_st_01{border-right:1px solid #eeeef0;}
</style>

</head>
<body>
<table cellspacing="0" cellpadding="0" style="width:100%;">
<tr>
	<td style="padding:10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		<tr>
			<td width="20" style="padding:0 5px 0 2px;"><img src="img/ico_arrow_01.gif" border="0"></td>
			<td class="font_14 font_dotum"><strong>솔루션 데모락점검</strong></td>
		</tr>
		</table>


		<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1; margin-top:10px;">
		<tr>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:150px;"><strong>점검 항목</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" ><strong>점검파일명</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:80px;"><strong>점검결과</strong></td>
		</tr>


		<?php foreach ( $demo_lock_data['data'] as $now_data ) : ?>
		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:left;"><strong><?php echo $now_data['title']; ?></strong></td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:left; word-break:break-all"><?php echo $now_data['path']; ?></td>
			<td class="info_td_content line-bottom_st_02" style="text-align:center;">

				<?php if ( !$now_data['is_lock'] ) : ?>
				<img src="img/check_icon_green.jpg" alt="정상" title="정상">
				<?php else : ?>
				<img src="img/check_icon_red.jpg" alt="비정상" title="비정상">
				<?php endif; ?>

			</td>
		</tr>
		<?php endforeach; ?>
		</table>
	</td>
</tr>
</table>




</body>
</html>