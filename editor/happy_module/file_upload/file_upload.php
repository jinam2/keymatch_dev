<?PHP
header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>파일 첨부하기</title>

<script type="text/javascript">
function submit_check()
{
	if( document.getElementById('Filedata').value != '' )
	{
		document.getElementById("submit_div").style.display = "none";
		document.getElementById("submit_div_ing").style.display = "";
		document.editor_upload_form.submit();
	}
	else
	{
		alert('파일을 선택해 주세요.');
	}
}
</script>

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

	<iframe src="" width="0px" height="0px" style="display:none;" name="layer_in_frame" id="layer_in_frame"></iframe>

	<table cellspacing="0" cellpadding="0" style="height:60px; background:#555555; width:100%;">
	<tr>
		<td style="color:#fff; padding-left:20px; font-size:14px;"><strong>파일첨부</strong></td>
		<td></td>
	</tr>
	</table>

	<table cellspacing="0" cellpadding="0" style="width:100%; background:#fbfbfb; border-bottom:1px solid #eaeaea;">
	<tr>
		<td style="color:#999; padding:20px; line-height:17px;">
			- 파일첨부시 위지윅내 첨부한 파일경로가 삽입됩니다.<br>
			- 예) 2016/07/22/1469170160_67558.zip
		</td>
	</tr>
	</table>


	<form id="editor_upload_form" name="editor_upload_form" action="file_upload_end.php" method="post" enctype="multipart/form-data" target="layer_in_frame">
	<input type="hidden" name="editor_name" id="editor_name" value="<?=$_GET['editor_name']?>">

		<div style=" margin:20px 0 20px 0;" class="input_style" align="center"><input type="file" name="Filedata" id="Filedata" style='width:90%;'></div>

		<table cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<td align="center" style="border-top:1px solid #eaeaea; padding-top:10px;">
				<table cellspacing="0" cellpadding="0">
				<tr>
					<td><div id="submit_div"><img src="../../img/btn_save.gif" onClick="submit_check()" title="파일전송" alt="파일전송" style='cursor:pointer;'></div></td>
					<td style="padding-left:5px;"><img src="http://cgimall.co.kr/happy_board/wys3/img/photoQuickPopup/btn_cancel.png" width="48" height="28" alt="취소" id="btn_cancel" onClick="parent.editor_layer_close()" style="cursor:pointer;"></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		

		<div id="submit_div_ing" style="display:none; margin:10px auto; width:360px;">
		<table cellspacing='0' cellpadding='0' border='0' style="">
			<tr>
				<td style="margin-right: 3px;"><img src="http://cgimall.co.kr/happy_board/wys3/popup/quick_photo/small-loading.gif" alt="업로드중" /></td>
				<td>
					업로드 중입니다. 잠시만 기다려 주세요.
				</td>
			</tr>
		</table>
	</div>
	</form>
</body>
</html>