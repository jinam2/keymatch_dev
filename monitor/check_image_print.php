<?php

	$config_include_folder		= ( is_file("../master/config.php") ) ? "../master" : "../inc";

	include($config_include_folder."/config.php");
	include("../inc/function.php");
	include("inc/monitor_config.php");
	include("inc/monitor_lib.php");
?>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>이미지 출력 테스트</title>
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
padding:8px 10px;
background:#ffffff;
color:#20232c;
line-height:18px;
letter-spacing:0px;
}


.line-bottom_st_01{border-bottom:1px solid #dddde1;}
.line-bottom_st_02{border-bottom:1px solid #eeeef0;}
.line-right_st_01{border-right:1px solid #eeeef0;}
</style>

<SCRIPT type="text/javascript">
	function view_layer(type)
	{
		var type_array	= Array('list','cmd');

		for ( var i = 0 ; i < type_array.length ; i++ )
		{
			var now_ly		= document.getElementById('permission_' + type_array[i] + '_layer');
			now_ly.style.display = ( type == type_array[i] ) ? "" : "none";
		}
	}
</SCRIPT>
</head>
<body>

<table cellspacing="0" cellpadding="0" style="width:100%;">
<tr>
	<td style="padding:20px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		<tr>
			<td width="20" style="padding:0 5px 0 2px;"><img src="img/ico_arrow_01.gif" border="0"></td>
			<td class="font_14 font_dotum"><strong>각종 이미지출력 점검</strong></td>
		</tr>
		</table>

		<table cellspacing="0" cellpadding="0" style="width:100%; border:1px solid #dddde1; margin-top:10px;">
		<tr>
			<td class="info_td_title line-bottom_st_01 line-right_st_01 font_12 font_gulim"><strong>배너출력 점검</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim"><strong>텍스트이미지 점검</strong></td>
		</tr>
		<tr>
			<td class="info_td_content line-right_st_01 font_12 font_gulim" valign="top">
				<?php
					for ( $i = 0 ; $i < 30 ; $i++ )
					{
						$Sql		= "SELECT * FROM $happy_banner_tb WHERE mode = 'image' ORDER BY rand() LIMIT 1";
						$BANNER		= happy_mysql_fetch_assoc(query($Sql));

						$width		= $BANNER['width'];
						$height		= $BANNER['height'];
						$width_out	= $width == "0" ? "" : "width='$width'";
						$height_out	= $height == "0" ? "" : "height='$height'";
						$pngClass	= ( strpos($BANNER['img'],"png") )?" class='png24' ":"";
				?>
					<img src="../banner_view.php?number=<?php echo $BANNER['number']?>" <?php echo $width_out." ".$height_out." ".$pngClass; ?> border=0 align='absmiddle'><br />
				<?php
					}
				?>
			</td>
			<td class="info_td_content" valign="top">

				<?php
					for ( $i = 1 ; $i <= 30 ; $i++ )
					{
						$fsize		= 20 + $i;

						$url		= "?width=";
						$url		.= "&height=";
						$url		.= "&fsize=" . $fsize;
						$url		.= "&news_title=텍스트 이미지 테스트 " . $i;
						$url		.= "&str_cut=";
						$url		.= "&outfont=";
						$url		.= "&format=";
						$url		.= "&fcolor=";
						$url		.= "&bgcolor=";
				?>
					<img src="../happy_imgmaker.php<?php echo $url; ?>"><br>
				<?php
					}
				?>

			</td>
		</tr>
		</table>
	</td>
</tr>
</table>


</body>
</html>