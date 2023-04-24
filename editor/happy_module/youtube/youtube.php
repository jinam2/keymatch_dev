<?PHP
header("Content-type: text/html; charset=utf-8");
if( $_GET['editor_type'] == 'ck' )				//CKEDITOR 일 경우 처리 구문!
{
	$editor_type_script		= "parent.ckeditor_insertcode('html',document.getElementById('youtube_code').value);parent.editor_layer_close();";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>Youtube 추가하기</title>

<link rel="stylesheet" type="text/css" href="../../css/common.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<style>
/* 스킨관계없이 기본 */
.input_style input[type=text] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:28px; line-height:27px; margin:2px 0; }
.input_style input[type=password] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:28px; line-height:27px; margin:2px 0; }
.input_style input[type=file] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:30px; line-height:29px; margin:2px 0; }
.input_style select { padding:5px; border:1px solid #bdbdc0; height:30px; line-height:24px; }
.input_style textarea { border:1px solid #bdbdc0; background:#f3f3f3; padding:5px; height:200px; }
.input_style input[type=checkbox]
.input_style input[type=radio] { vertical-align:middle; margin:-2px 0 1px;  cursor:pointer; }
/* 스킨관계없이 기본 */
</style>

</head>
<body style="OVERFLOW: hidden" scroll="no">
	<table cellspacing="0" cellpadding="0" style="height:60px; background:#555555; width:100%;">
	<tr>
		<td style="color:#fff; padding-left:20px; font-size:14px;"><strong>동영상링크</strong></td>
		<td></td>
	</tr>
	</table>

	<table cellspacing="0" cellpadding="0" style="width:100%; background:#fbfbfb; border-bottom:1px solid #eaeaea;">
	<tr>
		<td style="color:#999; padding:20px; line-height:17px;">
			- 유투브에서 제공하는 <span style="color:#333;"><strong>아이프레임</strong>(Iframe)</span> 소스를 넣어주세요.<br>
			- 아이프레임 소스 삽입시 본문내 영상이 출력됩니다.
		</td>
	</tr>
	</table>

	<div style="padding:20px;" class="input_style">
	<textarea name="youtube_code" id="youtube_code" style="width:97%; height:100px; "></textarea>
	<div style="color:#999; margin-top:10px;"> 예) < iframe width="560" height="315" src="https://www.youtube.com/
      embed/jZMdX" frameborder="0" allowfullscreen>< /iframe></div>
	</div>

	<table cellspacing="0" cellpadding="0" style="width:100%;">
	<tr>
		<td align="center" style="border-top:1px solid #eaeaea; padding-top:10px;">
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td><div id="submit_div"><img src="../../img/btn_save.gif" onClick="parent.ckeditor_insertcode('<?=$_GET['editor_name']?>','html',document.getElementById('youtube_code').value);parent.editor_layer_close();" title="파일전송" alt="파일전송" style='cursor:pointer;'></div></td>
				<td style="padding-left:5px;"><img src="http://cgimall.co.kr/happy_board/wys3/img/photoQuickPopup/btn_cancel.png" width="48" height="28" alt="취소" id="btn_cancel" onClick="parent.editor_layer_close()"  style="cursor:pointer;"></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>

</body>
</html>