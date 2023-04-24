<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 15:39:34 */
function SkyTpl_Func_4194156255 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<html style="min-width:auto !important;">
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>일반 사진업로드</title>
<meta charset="utf-8" />
<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="m/css/style.css?ver=<?=$_data['css_make_date']?>">
<link rel="stylesheet" type="text/css" href="m/css/common.css?ver=<?=$_data['css_make_date']?>">


<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> -->
<script src="js/jquery_min.js?ver=<?=$_data['js_make_date']?>"></script>
<script src="js/jquery.form.js?ver=<?=$_data['js_make_date']?>"></script>
<script language="javascript" type="text/javascript" src="js/happy_function_mobile.js?ver=<?=$_data['js_make_date']?>"></script>


<script type="text/javascript">

function fileupload(file_id)
{
	var file	= $(file_id).val();
	var file_id	= $(file_id).attr("id").split("_");

	$('#form' + file_id[2]).ajaxForm({
		url : "ajax_happy_mobile_image_upload.php",
		type: "POST",
		data:file,
		success: function(html)
		{
			//$('#status').html(html);
			var returnText		= html.split("______________");
			var javascript_img	= returnText[0].split("@@@@@@@@");
			var thumb_img		= returnText[1].split("@@@@@@@@");
			for(i = 0; i < javascript_img.length; i++)
			{
				if(javascript_img[i] != '')
				{
					$("#img_url_re_thumb" + i).attr("src", thumb_img[i]);
					$("input[name=img" + i + "]", parent.document).val(javascript_img[i]);
					//$("#btn_img_" + i).css("display", "");
					$("#btn_img_" + i).attr("checked", "");
				}
			}
			$("#imguploadtype", parent.document).val('normal');
		}
	}).submit();
}

function deleteOK(delete_id)
{
	//$(delete_id).css("display", "none");
	var tmp_id		= $(delete_id).attr("id").split("_");
	var src_value	= $("#img_url_re_thumb" + tmp_id[2]).attr("src");

	if(src_value != '<?=$_data['no_img_file_name']?>')
	{
		$.ajax({
			type: "POST",
			url: "ajax_happy_mobile_image_delete.php",
			data: "value=" + src_value,
			success: function(xhr) {
				$("input[name=img" + tmp_id[2] + "]", parent.document).val('');
				$("#img_url_re_thumb" + tmp_id[2]).attr("src", '<?=$_data['no_img_file_name']?>');
				$("input[name=noflash_img" + tmp_id[2] + "]").val("");
			}
		});
	}
}
</script>

</head>
<body style="min-width:auto !important;">
	<style>
		.image_upload table{margin:0 auto}
		.image_upload td:first-child div{margin-left:0 !important;}
		.mobile_thumb{width:100%; height:100%}
	</style>
	<div style="">
		<div id="status"></div>
		<div class="image_upload">
			<?=$_data['이미지업로드']?>

			<script>
			<?=$_data['startScript']?>

			</script>
		</div>
	</div>
</body>
</html>
<? }
?>