<?php
	header("Content-type: text/html; charset=utf-8");
	include_once("../config.php");


	//print_r($_GET);
	$default_fcolor = "#000000";
	$default_bgcolor = "#FFFFFF";
	$default_check1 = " checked ";
	$default_check2 = " checked ";


	if ( is_array($_GET) )
	{
		function happy_rgb2html($r, $g=-1, $b=-1)
		{
			if (is_array($r) && sizeof($r) == 3)
				list($r, $g, $b) = $r;

			$r = intval($r); $g = intval($g);
			$b = intval($b);

			$r = dechex($r<0?0:($r>255?255:$r));
			$g = dechex($g<0?0:($g>255?255:$g));
			$b = dechex($b<0?0:($b>255?255:$b));

			$color = (strlen($r) < 2?'0':'').$r;
			$color .= (strlen($g) < 2?'0':'').$g;
			$color .= (strlen($b) < 2?'0':'').$b;
			return '#'.$color;
		}

		if ( $_GET['outfont'] != "" )
		{
			$HAPPY_IMGMAKER_DEFAULT_FONT_TYPE = $_GET['outfont'];
		}
		if ( $_GET['news_title'] != "" )
		{
			$news_title = $_GET['news_title'];
		}
		if ( $_GET['width'] != "" )
		{
			$HAPPY_IMGMAKER_DEFAULT_WIDEE = intval($_GET['width']);
			if ( $HAPPY_IMGMAKER_DEFAULT_WIDEE != "" )
			{
				$default_check1 = "";
			}
		}
		if ( $_GET['height'] != "" )
		{
			$HAPPY_IMGMAKER_DEFAULT_HEIGHT = intval($_GET['height']);
			if ( $HAPPY_IMGMAKER_DEFAULT_HEIGHT != "" )
			{
				$default_check2 = "";
			}
		}
		if ( $_GET['fsize'] != "" )
		{
			$HAPPY_IMGMAKER_DEFAULT_FONT_SIZE = intval($_GET['fsize']);
		}
		if ( $_GET['format'] != "" )
		{
			$image_type_select = $_GET['format'];
		}
		if ( $_GET['quality'] != "" )
		{
			$HAPPY_IMGMAKER_DEFAULT_QUALITY = intval($_GET['quality']);
		}
		if ( $_GET['fcolor'] != "" )
		{
			list($r,$g,$b) = explode(",",$_GET['fcolor']);
			$HAPPY_IMGMAKER_DEFAULT_FONT_COLOE	= "$r,$g,$b";
			$default_fcolor = happy_rgb2html($r,$g,$b);
		}
		if ( $_GET['bgcolor'] != "" )
		{
			list($r,$g,$b) = explode(",",$_GET['bgcolor']);
			$HAPPY_IMGMAKER_DEFAULT_FONT_BGCOLOR	= "$r,$g,$b";
			$default_bgcolor = happy_rgb2html($r,$g,$b);
		}
	}



	/*		이미지 종류 만들기		*/
	$image_type_option		= "";
	foreach( $HAPPY_IMGMAKER_IMG_TYPE as $key => $value )
	{
		$selected = "";
		if ( $value == $image_type_select )
		{
			$selected = "selected";
		}

		$image_type_option		.= "<option value='$value' $selected>$value</option>";
	}
	/*		이미지 종류 만들기		*/

	/*		FONT 종류 만들기		*/
	$font_type_option		= "";
	foreach( $HAPPY_IMGMAKER_FONT_TYPE as $key => $value )
	{
		$selected				= "";
		if( $HAPPY_IMGMAKER_DEFAULT_FONT_TYPE == $value )
		{
			$selected				= "selected";
		}
		$font_type_option		.= "<option value='$value' $selected>$key</option>";
	}
	/*		FONT 종류 만들기		*/




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>텍스트 이미지</title>


<link rel="stylesheet" type="text/css" href="../../css/common.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<link rel="stylesheet" type="text/css" href="js/colorpicker/spectrum.css">
<!-- <link rel="stylesheet" type="text/css" href="js/colorpicker/docs/bootstrap.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="js/colorpicker/docs/docs.css"> -->
<script type="text/javascript" src="js/colorpicker/docs/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/colorpicker/spectrum.js"></script>


</head>

<body style="OVERFLOW: hidden" scroll="no">

	<table cellspacing="0" cellpadding="0" style="height:60px; background:#555555; width:100%;">
	<tr>
		<td style="color:#fff; padding-left:20px; font-size:14px;"><strong>이미지 텍스트</strong></td>
		<td></td>
	</tr>
	</table>

	<table cellspacing="0" cellpadding="0" style="width:100%; background:#fbfbfb; border-bottom:1px solid #eaeaea;">
	<tr>
		<td style="color:#999; padding:20px; line-height:17px;">
			- 이미지 텍스트란 폰트를 이미지화시켜 출력하는 기능입니다.<br>
			- 텍스트 입력 후 원하는 폰트종류를 선택해주세요.<br>
			- IE8 이하 브라우저에서 정상적으로 보이지 않을 수 있습니다.
		</td>
	</tr>
	</table>


	<div style="padding:20px;">
		<iframe src="" width="0px" height="0px" style="display:none;" name="layer_in_frame" id="layer_in_frame"></iframe>
		<form id="editor_upload_form" name="editor_upload_form" action="text_image_end.php" method="post" enctype="multipart/form-data" target="layer_in_frame">
		<input type="hidden" name="editor_name" id="editor_name" value="<?=$_GET['editor_name']?>">

			<table cellspacing='0' cellpadding='0' style='width:100%;' class='table_com input_st'>
			<tr>
				<th style="width:90px; border-right:1px solid #eaeaea; padding-left:10px; ">텍스트</th>
				<td colspan="3"><input type="text" name="title" id="title" style="width:97%;" value="<?=$news_title?>"></td>
			</tr>
			<tr>
				<th style="border-right:1px solid #eaeaea; padding-left:10px; ">폰트종류</th>
				<td>
					<select name="outfont">
					<?=$font_type_option?>
					</select>
				</td>
				<th style="width:90px; border-right:1px solid #eaeaea; border-left:1px solid #eaeaea; padding-left:10px; ">가로길이</th>
				<td><input type="text" name="width" id="width" value="<?=$HAPPY_IMGMAKER_DEFAULT_WIDEE?>" style="width:50px;"> &nbsp;<input type="checkbox" id="width_auto" name="width_auto" value="y" style="width:20px;" <?=$default_check1?>><label for='width_auto' style='cursor:pointer;'>자동</label></td>
			</tr>
			<tr>
				<th style="border-right:1px solid #eaeaea; padding-left:10px; ">폰트크기</th>
				<td><input type="text" name="font_size" id="font_size" value="<?=$HAPPY_IMGMAKER_DEFAULT_FONT_SIZE?>" style="width:50px;"></td>
				<th style="border-right:1px solid #eaeaea; padding-left:10px; border-left:1px solid #eaeaea;">세로길이</th>
				<td><input type="text" name="height" id="height" value="<?=$HAPPY_IMGMAKER_DEFAULT_HEIGHT?>" style="width:50px;"> &nbsp;<input type="checkbox" id="height_auto" name="height_auto" value="y" style="width:20px;" <?=$default_check2?>><label for='height_auto' style='cursor:pointer;'>자동</label></td>
			</tr>
			<tr>
				<th style="border-right:1px solid #eaeaea; padding-left:10px; ">폰트색상</th>
				<td><input type="text" name="fcolor" id="fcolor" style="width:100px;" value="<?=$HAPPY_IMGMAKER_DEFAULT_FONT_COLOE?>"></td>
				<th style="border-right:1px solid #eaeaea; padding-left:10px; border-left:1px solid #eaeaea;">이미지종류</th>
				<td>
					<select name="format">
					<?=$image_type_option?>
					</select>
				</td>
			</tr>
			<tr>
				<th style="border-right:1px solid #eaeaea; padding-left:10px; ">배경색상</th>
				<td><input type="text" name="bgcolor" id="bgcolor" value="<?=$HAPPY_IMGMAKER_DEFAULT_FONT_BGCOLOR?>"></td>
				<th style="border-right:1px solid #eaeaea; border-left:1px solid #eaeaea; padding-left:10px; ">이미지품질</th>
				<td><input type="text" name="quality" id="quality" value="<?=$HAPPY_IMGMAKER_DEFAULT_QUALITY?>" style='width:50px;'> %</td>
			</tr>
			</table>


			<table cellspacing="0" cellpadding="0" style="width:100%; margin-top:10px;">
			<tr>
				<td align="center" style="border-top:1px solid #eaeaea; padding-top:10px;">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td><div id="submit_div"><img src="../../img/btn_save.gif"  onClick="document.editor_upload_form.submit();" title="파일전송" alt="파일전송" style='cursor:pointer;'></div></td>
						<td style="padding-left:5px;"><img src="http://cgimall.co.kr/happy_board/wys3/img/photoQuickPopup/btn_cancel.png" width="48" height="28" alt="취소" id="btn_cancel" onClick="parent.editor_layer_close()"  style="cursor:pointer;"></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>


		</form>

		<script type="text/javascript">
		<!--
			$(function() {
				$("#fcolor").spectrum({
					flat: false,
					showInput: true,
					preferredFormat: "rgb",
					color: "<?=$default_fcolor?>"
				});
			});

			$(function() {
				$("#bgcolor").spectrum({
					flat: false,
					showInput: true,
					preferredFormat: "rgb",
					color: "<?=$default_bgcolor?>"
				});
			});
		//-->
		</script>
	</div>
</body>
</html>