<?php

	ini_set('memory_limit', -1);
	set_time_limit(0);

	$config_include_folder		= ( is_file("../master/config.php") ) ? "../master" : "../inc";

	include($config_include_folder."/config.php");
	include("../inc/function.php");
	include("inc/monitor_config.php");
	include("inc/monitor_lib.php");

	if ( !is_admin() )
	{
		exit;
	}

	$folder_volume_list			= Array();
	$folder_dir_count_list		= Array();
	$folder_file_count_list		= Array();

	$fp			= opendir($server_path);

	while( ($entry = readdir($fp)) !== false )
	{
		if ( $entry != "." && $entry != ".." )
		{
			if ( is_dir($server_path."/".$entry) )
			{
				$dir_size						= 0;
				$dir_count						= 0;
				$file_count						= 0;

				$dir_data						= dirsize($server_path."/".$entry);
				$folder_volume_list[$entry]		= $dir_data['volume'];
				$folder_dir_count_list[$entry]	= $dir_data['dir_count'];
				$folder_file_count_list[$entry]	= $dir_data['file_count'];
			}
		}
	}

	$max_volume					= max($folder_volume_list);
	$max_volume_folder			= array_search($max_volume, $folder_volume_list);
?>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>솔루션 용량 자세히보기</title>

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
			<td class="font_14 font_dotum"><strong>솔루션 용량 자세히보기</strong></td>
			<td class="font_11 font_dotum" style="text-align:right">용량이 가장 높은 디렉토리는 <font color="#FF0000">붉은색</font>으로 표시됩니다.</td>
		</tr>
		</table>

		<?php //echo get_volume_unit($dirsize)."<br>"; ?>

		<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1; margin-top:10px;">
		<tr>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim"><strong>폴더명</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:110px;"><strong>용량</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:90px;"><strong>폴더개수</strong></td>
			<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:90px;"><strong>파일개수</strong></td>
		</tr>

		<?php foreach ( $folder_volume_list as $folder => $volume ) : ?>
			<?php $font_color_style = ( $folder == $max_volume_folder ) ? "color:#FF0000;" : ""; ?>
		<tr>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:left; <?php echo $font_color_style; ?>">
				<strong ><?php echo $folder; ?></strong>
			</td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:right; <?php echo $font_color_style; ?>">
				<?php echo get_volume_unit($volume); ?>
			</td>
			<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:right; <?php echo $font_color_style; ?>">
				<?php echo number_format($folder_dir_count_list[$folder]); ?>
			</td>
			<td class="info_td_content line-bottom_st_02 font_12 font_gulim" style="text-align:right; <?php echo $font_color_style; ?>">
				<?php echo number_format($folder_file_count_list[$folder]); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
	</td>
</tr>
</table>




</body>
</html>