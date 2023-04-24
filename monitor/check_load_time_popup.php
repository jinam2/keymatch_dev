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

	//CPU 부하
	$cpu				= happy_monitor_check_load_time();

	//MySQL 접속
	$mysql				= happy_monitor_check_load_time('mysql');

	//종합
	$total_score		= round(( $cpu['score'] + $mysql['score'] ) / 2);
?>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>서버부하 자세히보기</title>

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
			<td class="font_14 font_dotum"><strong>서버부하 자세히보기</strong></td>
		</tr>
		</table>

		<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1; margin-top:10px;">
		<tr>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:150px;"><strong>점검 항목</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:100px;"><strong>점검수치</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim"><strong>점검결과</strong></td>
		</tr>
		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:left;"><strong>CPU 부하</strong></td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:center;"><strong style="color:#0f70e9;"><?php echo $cpu['average_time']; ?>초</strong></td>
			<td class="info_td_content line-bottom_st_02 font_12 font_gulim" style="text-align:center;">

				<table cellspacing="0" cellpadding="0" style="height:46px;">
				<tr>
					<td class="font_gulim font_12"><strong><?php echo $MONITOR_CONFIG['load_time_average_end']; ?>초</strong></td>
					<td style="width:215px; padding:0 3px;" align="center"><img src="img/score_icon_<?php echo $cpu['score']; ?>.jpg" border="0"></td>
					<td class="font_gulim font_12"><strong><?php echo $MONITOR_CONFIG['load_time_average_start']; ?>초</strong></td>
				</tr>
				</table>

			</td>


		</tr>
		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:left;"><strong>MySQL 연결</strong></td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:center;"><strong style="color:#0f70e9;"><?php echo $mysql['average_time']; ?>초</strong></td>
			<td class="info_td_content line-bottom_st_02 font_12 font_gulim" style="text-align:center;">

				<table cellspacing="0" cellpadding="0" style="height:46px;">
				<tr>
					<td class="font_gulim font_12" ><strong><?php echo $MONITOR_CONFIG['load_time_average_end_db']; ?>초</strong></td>
					<td style="width:215px; padding:0 3px;" align="center"><img src="img/score_icon_<?php echo $mysql['score']; ?>.jpg" border="0"></td>
					<td class="font_gulim font_12"><strong><?php echo $MONITOR_CONFIG['load_time_average_start_db']; ?>초</strong></td>
				</tr>
				</table>

			</td>

		</tr>
		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:left;"><strong>종합 평가</strong></td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:center;"><strong style="color:#0f70e9;"><?php echo $total_score; ?>점</strong></td>
			<td class="info_td_content line-bottom_st_02 font_12 font_gulim" style="text-align:center;">

				<table cellspacing="0" cellpadding="0" style="height:46px;">
				<tr>
					<td class="font_gulim font_12" ><strong>0점</strong></td>
					<td style="width:215px; padding:0 3px;" align="center"><img src="img/score_icon_<?php echo $total_score; ?>.jpg" border="0"></td>
					<td class="font_gulim font_12"><strong>10점</strong></td>
				</tr>
				</table>

			</td>
		</tr>
		</table>


	</td>
</tr>
</table>




</body>
</html>