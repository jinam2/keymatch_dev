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

	$permission_data	= happy_monitor_check_permission();

	$mode				= $_GET['mode'];

	if ( $mode == "get_count" )
	{
		echo "ok___CUT___".$permission_data['count_no'];
		exit;
	}
?>



<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>솔루션 파일 및 폴더 권한</title>
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
	<td style="padding:10px;">

		<table cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<td>
				<table cellspacing="0" cellpadding="0">
				<tr>
					<td width="20" style="padding:0 5px 0 2px;"><img src="img/ico_arrow_01.gif" border="0"></td>
					<td class="font_14 font_dotum"><strong>파일 및 폴더 쓰기 권한</strong></td>
				</tr>
				</table>
			</td>
			<td align="right">
				<table cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="javascript:void(0);" onClick="view_layer('list');"><img src="img/btn_root_more.jpg" alt="경로목록보기" title="경로목록보기" border="0"></a></td>
					<td style="padding-left:3px;"><a href="javascript:void(0);" onClick="view_layer('cmd');"><img src="img/btn_cmd_more.jpg" alt="명령어보기" title="명령어보기" border="0"></a></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		<div id="permission_list_layer">
			<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1; margin-top:10px;">
			<tr>
				<td class="info_td_title line-bottom_st_01 font_12 font_gulim" ><strong>경로</strong></td>
				<td class="info_td_title line-bottom_st_01 font_12 font_gulim" style="width:80px;"><strong>점검결과</strong></td>
			</tr>


			<?php foreach ( $permission_data['path'] as $now_path ) : ?>
			<tr>
				<td class="info_td_content line-bottom_st_02 line-right_st_01 font_12 font_gulim" style="text-align:left; word-break:break-all"><strong><?php echo $now_path; ?></strong></td>
				<td class="info_td_content line-bottom_st_02" style="text-align:center;">

					<?php if ( is_writable($server_path.$now_path) ) : ?>
					<img src="img/check_icon_green.jpg" alt="정상" title="정상">
					<?php else : ?>
					<img src="img/check_icon_red.jpg" alt="비정상" title="비정상">
					<?php endif; ?>

				</td>
			</tr>
			<?php endforeach; ?>

			</table>
		</div>



		<div id="permission_cmd_layer" style="display:none">

			<table cellspacing="0" cellpadding="0" style="width:100%; border-top:1px solid #dddde1; margin-top:10px;">
			<tr>
				<td class="info_td_title line-bottom_st_01 font_12 font_gulim"><strong>명령어</strong></td>
			</tr>
			<tr>
				<td align="center"><textarea style="width:100%; height:580px; border:1px solid #eeeef0; padding:10px; line-height:18px;"><?php echo $permission_data['cmd']; ?></textarea></td>
			</tr>
			</table>
		</div>



	</td>
</tr>
</table>




</body>
</html>