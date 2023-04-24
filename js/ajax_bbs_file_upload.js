function AjaxFileSearch(file_id)
{
	$("#img_"+file_id).click();
}

function AjaxFileUpload(file_id)
{
	var img_name_html_org = $("#img_name_"+file_id).html();
	$("#img_name_"+file_id).html("<img src='img/ajax_loading.gif' border='0'>");

	var form		= $("form[name='regiform']")[0];
	var formData	= new FormData(form);

	formData.append("file_id", file_id);

	$.ajax({
		url				: "./ajax_bbs_file_upload.php",
		processData		: false,
		contentType		: false,
		data			: formData,
		type			: 'POST',
		success			: function(response){
			
			var responses	= response.split("___cut___");

			if ( responses[0] == "ok" )
			{
				$("input[name='img_val_"+file_id+"']").val(responses[1]);
				$("#img_name_"+file_id).html(responses[1]);
				$("#img_name_"+file_id).show();
				$("#img_del_"+file_id).show();
			}
			else
			{
				alert(response);
				
				$("#img_name_"+file_id).html(img_name_html_org);
				return false;
			}
		}
	});
}

function AjaxFileDelete(file_id)
{
	if ( confirm("파일을 삭제하시겠습니까?") )
	{
		$("input[name='img_val_"+file_id+"']").val("");
		$("#img_name_"+file_id).html("");
		$("#img_name_"+file_id).hide();
		$("#img_del_"+file_id).hide();
	}
}