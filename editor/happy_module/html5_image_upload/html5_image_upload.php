<?PHP
	header("Content-type: text/html; charset=utf-8");
	require_once('../secure_config.php') ;												//보안설정
	require_once('../config.php') ;																	//에디터 모듈 통합설정
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert Code</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="noindex, nofollow" name="robots">
<link rel="stylesheet" type="text/css" href="../../css/common.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<style type="text/css">
/* NHN Web Standard 1Team JJS 120106 */
/* Common */
body,p,h1,h2,h3,h4,h5,h6,ul,ol,li,dl,dt,dd,table,th,td,form,fieldset,legend,input,textarea,button,select{margin:0;padding:0}
body,input,textarea,select,button,table{font-family:'돋움',Dotum,Helvetica,sans-serif;font-size:12px}
img,fieldset{border:0}
ul,ol{list-style:none}
em,address{font-style:normal}
a{text-decoration:none}
a:hover,a:active,a:focus{text-decoration:underline}
</style>

<link rel="stylesheet" href="css/upload_tool.css"/>

<script language='JavaScript' src='js/jquery-1.11.3.js' type="text/javascript"></script>
<script language='JavaScript' src="js/jquery-ui.1.12.1.js" type="text/javascript"></script>

</head>
<body scroll="no">
<table cellspacing="0" cellpadding="0" style="height:60px; background:#555555; width:100%;">
	<tr>
		<td style="color:#fff; padding-left:20px; font-size:14px;"><strong>다중 이미지 업로드(HTML5)</strong></td>
		<td></td>
	</tr>
</table>
<form name="html5_upload_frm" id="html5_upload_frm" method="post" enctype="multipart/form-data">
	<div style="padding:10px 10px 0 10px">
		<div style="position:relative">
			<p style="padding-top:10px; line-height:150%">
				- 확장자가 JPG, JPEG, GIF, PNG 파일만 업로드 가능합니다.<br/>
				- 파일추가/선택 하신 후 이미지를 드래그하여 순서를 지정하시고 "등록" 버튼을 클릭해주세요.
			</p>
			<div class="progress_num noto400 font_14" style="color:#919191; position:absolute; bottom:0px; right:0; ; text-align:right; display:none">
				214KB/300KB
			</div>
		</div>
		<div class="drapzone_fix">
			<div style="width:100%; height:280px; position:relative; z-index:10">
				<div  id="happy_upload_file_drop_zone_msg">
					<div id="html5_no_browser" class="upload_clip_nohtml5">
						해당 브라우져는 이미지 드래그 업로드가 지원하지 않는 브라우져입니다.<br/>
						본 영역을 클릭하여 파일을 선택하시거나 , 하단의 파일추가 버튼을 클릭하여 이미지를 업로드 해주세요.<br/>
						<span style="color:#a3a3a3; font-size:14px" >(최대 20장의 사진업로드가 가능합니다.)</span>
					</div>
					<div id="html5_browser" class="upload_clip_html5">
						본 영역에 파일을 드래그하거나 클릭하여 파일을 선택하세요.<br/>
						<span style="color:#a3a3a3; font-size:14px">(최대 20장의 사진업로드가 가능합니다.)</span>
					</div>
				</div>
			</div>
			<div style="position:absolute; width:100%; height:280px; top:0; background:#f8f8f8">
				<div id="sortable_out" class="sortable_out">
					<div id="sortable" class="files" style="z-index:100;" onClick="dropbox_click(event);"></div>
					<!-- The global progress state -->
					<div class="progress_bar_field fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-striped " role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="progress-bar progress-bar-success" style="width:0;"></div>
						</div>
						<!-- The extended global progress state -->
						<div class="progress-extended noto400 font_14" style="display:none">&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row fileupload-buttonbar">
			<div class="upload_tool_btn text-left" style="position:relative">
				<!-- The fileinput-button span is used to style the file input field as button -->
				<span class="fileinput-button add_btn" style="vertical-align:middle" title="파일추가">
					<input type="file" name="files[]" id="happy_html5_file" multiple />
				</span>

				<button type="button" class="delete choose_btn"  style="vertical-align:middle; text-indent:-1000px" title="선택삭제"></button>

				<label  style="letter-spacing:-1px; color:#434343; font-weight:normal; cursor:pointer">
					<input type="checkbox" class="toggle" style="vertical-align:middle"/>
					<span class="font_gulim" style="color:#636363; font-size:12px; font-family:'굴림'; vertical-align:middle">모두선택</span>
				</label>

				<button type="submit" class="btn btn-primary start" style="display:none" id="html5_upload_btn">
					<i class="glyphicon glyphicon-upload"></i>
					<span>Start upload</span>
				</button>
				<button type="reset" class="btn btn-warning cancel" style="display:none">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>Cancel upload</span>
				</button>

				<!-- The global file processing state -->
				<span class="fileupload-process"></span>
				<div class="itemBoxHighlight"></div>
			</div>
			<div class="upload_tool_submit" style="position:relative; text-align:center;">
				<span class="btn btn-success fileinput-button" style="vertical-align:middle; display:inline-block; height:22px; line-height:24px"  onclick="editor_insert_img()" title="등록">
					<span class="font_gulim" style="color:#636363; font-size:12px; font-family:'굴림'">등록</span>
				</span>
				<span class="btn btn-success fileinput-button" style="vertical-align:middle; display:inline-block; height:22px; line-height:24px" onclick="parent.parent.editor_layer_close()" title="취소">
					<span class="font_gulim" style="color:#636363; font-size:12px; font-family:'굴림'">취소</span>
				</span>
			</div>
		</div>

	</div>
	<!-- 이미지 소팅 결과보기 레이어
	<div id="sort_result">

	</div> -->


		<script>
		function check_broswer () {
			var word;
			var agent			= navigator.userAgent.toLowerCase();

			if ( navigator.appName == "Microsoft Internet Explorer" ){		// IE old version ( IE 10 or Lower )
				word			= "msie ";
				var reg = new RegExp( word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})" );
				if (  reg.exec( agent ) != null  ) return parseFloat( RegExp.$1 + RegExp.$2 );
			}
			else
			{
				return 100;
			}
		}
		var is_image_preload		= check_broswer();;
		if( is_image_preload < 10 ){				//10 이하는 html5 파일 드래그 불가.
			$("#html5_browser").hide();
		}
		else{
			$("#html5_no_browser").hide();
		}
		</script>

<script id="template-upload" type="text/x-tmpl">
/*
	자동 업로드 되는 경우는 사용되지 않습니다.
	자동 업로드를 사용하지 않을 경우 업로드 하기전 보여지는 디자인 형태입니다.
	삭제 하지 마시고 그대로 두시기 바랍니다.
*/
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<div class="ui-state-default template-upload">
		<div class="inner">
			<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
			<span class="preview">
			</span>
			<strong class="error text-danger"></strong>

			<p class="name" style="display:none;">
				<happy_upload_file_name id="{%=file.name%}"></happy_upload_file_name>
			</p>
			<p class="size" style="display:none;">Processing...</p>
		{% if (!o.options.autoUpload && o.options.edit && o.options.loadImageFileTypes.test(file.type)) { %}
			<button class="btn btn-success edit" data-index="{%=i%}" disabled>
				<i class="glyphicon glyphicon-edit"></i>
				<span>Edit</span>
			</button>
		{% } %}
		{% if (!i && !o.options.autoUpload) { %}
			<button class="btn btn-primary start" disabled style="position:absolute; bottom:0; display:none">
				<i class="glyphicon glyphicon-upload"></i>
				<span>Start</span>
			</button>
		{% } %}
		{% if (!i) { %}
			<button class="btn btn-warning cancel" style="position:absolute; bottom:20px; display:none">
				<i class="glyphicon glyphicon-ban-circle"></i>
				<span>Cancel</span>
			</button>
		{% } %}
		</div>
	</div>
{% } %}
</script>


<script id="template-download" type="text/x-tmpl">
/*
	업로드 후 보여지는 디자인 형태 입니다.
	해당 코드를 디자인해 주시기 바랍니다.
*/
{% for (var i=0, file; file=o.files[i]; i++) { %}

		<div class="ui-state-default template-download" xtitle="클릭하여 이미지확대">
			<div class="inner">
				<span class="preview">
		{% if (file.thumbnailUrl) { %}
					<!-- <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery> --><img src="{%=file.thumbnailUrl%}" style="border:1px solid #red" xonClick="happy_multi_modal_open('{%=file.url%}')"><!-- </a> -->
		{% } %}
				</span>
		{% if (window.innerWidth > 480 || !file.thumbnailUrl) { %}
				<p class="name" style="display:none;">
					<happy_upload_file_name id="{%=file.name%}"></happy_upload_file_name>
				</p>
		{% } %}

		{% if (file.error) { %}
				<div><span class="label label-danger">Error</span> {%=file.error%}</div>
		{% } %}

				<!-- <span class="size">{%=o.formatFileSize(file.size)%}</span> -->

		{% if (file.deleteUrl) { %}
				<button class="delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
					<i class="ico_trash2" title="이미지삭제"></i>
				</button>
				<input type="checkbox" name="delete" value="1" class="toggle" title="클릭시 선택">
		{% } else { %}
				<button class="btn btn-warning cancel">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>Cancel</span>
				</button>
		{% } %}
			</div>
		</div>


  {% } %}
</script>





		<!-- <script src="js/vendor/jquery.ui.widget.js"></script> -->
		<script src="js/tmpl.min.js"></script>
		<script src="js/load-image.all.min.js"></script>


		<script src="js/jquery.iframe-transport.js"></script>
		<script src="js/jquery.fileupload.js"></script>
		<script src="js/jquery.fileupload-process.js"></script>
		<script src="js/jquery.fileupload-image.js"></script>
		<!-- <script src="js/jquery.fileupload-validate.js"></script> -->
		<script src="js/jquery.fileupload-ui.js"></script>
		<script src="js/happy_multi_upload.js"></script>


		<script>
		var one_mb_size				= 1024 * 1024;							//1MB
		var max_file_size			= one_mb_size * <?=$FILE_UPLOAD_SIZE;?>;		//1개 파일의 최대용량 설정(서버의 설정에 따를것) //one_mb_size * 20 = 20MB
		//var max_file_size			= one_mb_size * 1;						//1개 파일의 최대용량 설정(서버의 설정에 따를것) //one_mb_size * 20 = 20MB
		var max_file_count			= <?=$FILE_MAX_COUNT;?>;
		var file_ext_types			= new Array("jpg","jpeg","gif","png");	//업로드 허용 확장자 jpg, jpeg, gif, png 만 허용되며 기타 확장자는 허용하더라도 썸네일 이미지 생성이 되지 않습니다.
		var drop_zone_obj			= $("#sortable");	//드래그존 입니다.
		var data_key_number			= '';
		var form_name				= 'html5_upload_frm';
		var upload_Handler			= "Html5_Image_Upload_Handler.php";
		var upload_delay_time		= 300;
		var editor_name				= '<?=$_GET[editor_name];?>';

		happy_multi_img_upload();
		</script>


	</form>

</body>


</html>
