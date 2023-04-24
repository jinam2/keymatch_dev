

var upload_file_array			= new Array;
var total_data_size				= 0;
var add_cnt						= 0;
var check_add_cnt				= 0;
function happy_multi_img_upload()
{
	tmp_file_ext_types				= file_ext_types.join('|');
	file_ext_patten					= "("+tmp_file_ext_types+")";

	var play_trigger				= true;

	var completed_cnt				= 0;

	//드랍영역외의 다른곳에 드랍할 경우를 막자.
	$(document).bind('drop dragover', function (e, data) {
		e.preventDefault();
	});

	$(function() {
		'use strict';

		//옵션 등을 모두 여기에 설정하고 테스트 해보자.
		$('#'+form_name).fileupload({
			formAcceptCharset	: 'utf-8',
			borwser_version		: is_image_preload,
			url					: upload_Handler,
			dropZone			: drop_zone_obj,
			fileInput			: $('#happy_html5_file'),
			formData			: {loading_type: 'submit', number: data_key_number},
			singleFileUploads	: true,
			autoUpload			: false,
			progressall			: function(e, data) {
				if (e.isDefaultPrevented()) {
					return false;
				}
				var $this = $(this),
				progress = Math.floor((data.loaded / data.total) * 100),
				globalProgressNode = $this.find('.fileupload-progress'),
				extendedProgressNode = globalProgressNode.find('.progress-extended');
				if (extendedProgressNode.length) {
					if( data.total > one_mb_size ){			// 1MB 보다 크면 MB 단위로 보여준다.
						var data_send_result = number_format( data.loaded / one_mb_size , 2)+'MB/'+number_format( data.total / one_mb_size , 2)+'MB';
					}
					else{									// KB 단위로 보여준다.
						var data_send_result = number_format( data.loaded / 1024 , 2)+'KB/'+number_format( data.total / 1024 , 2)+'KB';
					}
					$(".progress_num").html(data_send_result);
				}
				globalProgressNode
					.find('.progress')
					.attr('aria-valuenow', progress)
					.children()
					.first()
					.css('width', progress + '%');
			}
		});

		$('#'+form_name)
		.bind('fileuploadcompleted', function (e,data){												//파일 업로드가 완료되면 sort table 정리 + 선택 파일 수 초기화 + 업로드 용량 숨기기 처리.
			//console.log('CALL :: fileuploadcompleted');
			if( data.files != undefined )
			{
				completed_cnt++;
			}
			happy_file_resort();

			if( completed_cnt == add_cnt )
			{
				add_cnt					= 0;
				completed_cnt			= 0;
				total_data_size			= 0;
				check_add_cnt			= 0;
				$(".progress_num").hide();
				//console.log('★★ FILE UPLOAD ALL COMPLETED ★★');
				happy_file_resort('set_editor');
			}
		})
		.bind('fileuploadchange', function (e, data) {												//파일을 1개씩 선택할 경우 ...
			file_check(data);
		})
		.bind('fileuploaddrop', function (e, data) {												//파일을 드랍한 경우 ...
			file_check(data);
		})
		.bind('fileuploadadd', function (e, data){													//업로드 전 파일 체크를 담당하는 녀석.
			check_add_cnt++;

			if( add_cnt == check_add_cnt )
			{
				//console.log('★★ FILE UPLOAD START ★★');
				var upload_delay_time_sum	= upload_delay_time * add_cnt;
				var play_trigger			= true;
				if( play_trigger ){
					setTimeout(function(){
						$(this).addClass('fileupload-processing')
						$('#html5_upload_btn').trigger("click");
						//add_cnt					= 0;
						//total_data_size			= 0;
						//console.log('upload start');
					},upload_delay_time_sum);
					play_trigger		= false;
				}
			}
		})
		.bind('fileuploaddestroyed', function (e){
			happy_file_resort();
		});
	});

	$(".files" ).sortable({
		scroll: false,
		//placeholder:"itemBoxHighlight",															//디자인 작업하실때 꼭 쓰세요.
		update: function(event, ui) {
			happy_file_resort();
		}
	});
}


function happy_file_resort( action )
{
	upload_file_array			= new Array;

	this_index			= 0;
	$('.files happy_upload_file_name').each( function(e) {
		upload_file_array[this_index]	= $(this).attr('id');
		this_index++;
	});

	//console.log(upload_file_array);
	var images_value_test	= "";
	var images_value		= "";
	for( var idx in upload_file_array){
		images_value_test		+= "<img src='/"+upload_file_array[idx]+"' style='width:100px;height:100px;'>";
		images_value		+= "<img src='/"+upload_file_array[idx]+"' border=0 align=absmiddle><br><br>";

	}
	//$('#sort_result').html(images_value_test);

	if( this_index > 0 ){
		$('#happy_upload_file_drop_zone_msg').hide();
	}
	else if ( this_index == 0 ){
		$('#happy_upload_file_drop_zone_msg').show();
	}

	if( images_value != '' && action != undefined ){												//에디터에 이미지 태그를 반영하는 최종파트.

		//parent.editor_layer_close();
		//parent.ckeditor_insertcode(editor_name,'html',images_value);
	}
}


function editor_insert_img()
{
	upload_file_array			= new Array;

	this_index			= 0;
	$('.files happy_upload_file_name').each( function(e) {
		upload_file_array[this_index]	= $(this).attr('id');
		this_index++;
	});

	if( upload_file_array.length > 0 )
	{
		$.ajax({
					url: "html5_image_upload_end.php",
					type: "POST",
					data: JSON.stringify(upload_file_array),				//Array를 JSON string형태로 변환
					dataType: "json",								//ajax 통신 후 반환되는 값의 종류 xml, html, script, json, jsonp, text 등의 값을 사용할 수 있다.
					contentType: "application/json; charset=UTF-8",
					success: function(response) {
						//console.log(response);
						if( response.status == 'success' )			//업데이트 완료.
						{
							parent.ckeditor_insertcode(editor_name,'html',response.contents);
							parent.editor_layer_close();
						}
						else if( response.status == 'error' )
						{
							alert(response.message);
						}
					},
					error:function(xhr,status,error,data){
						//console.log('error');
					}
				});
	}
}

function number_format(num, decimals, dec_point, thousands_sep) {
	num = parseFloat(num);
	if(isNaN(num)) return '0';

	if(typeof(decimals) == 'undefined') decimals = 0;
	if(typeof(dec_point) == 'undefined') dec_point = '.';
	if(typeof(thousands_sep) == 'undefined') thousands_sep = ',';
	decimals = Math.pow(10, decimals);

	num = num * decimals;
	num = Math.round(num);
	num = num / decimals;

	num = String(num);
	var reg = /(^[+-]?\d+)(\d{3})/;
	var tmp = num.split('.');
	var n = tmp[0];
	var d = tmp[1] ? dec_point + tmp[1] : '';

	while(reg.test(n)) n = n.replace(reg, "$1"+thousands_sep+"$2");

	return n + d;
}


function dropbox_click(e)
{
	if(e.target.id == 'sortable'){		//실제 클릭 이벤트 일 경우에만 .. 작동한다.
		$('#happy_html5_file').focus().trigger('click');
	}
}


function file_check(data)
{
	if( ( add_cnt + data.files.length ) > max_file_count ){											//한번에 업로드 가능한 개수를 체크하는 기능.
		alert((add_cnt + data.files.length)+"최대  "+max_file_count+"개의 파일만 선택 가능합니다.");
		data.files.length = 0;
		return false;
	}

	var is_failed_array		= new Array();															//업로드 하면 안되는 file 을 배열에 담고 유효성 체크를 모두 마무리 한 후에 삭제하자.
	for(var idx in data.files){
		//확장자 체크
		var uploadFile			= data.files[idx];
		var Filename_tmp		= uploadFile.name.split('.');
		var File_ext			= Filename_tmp[Filename_tmp.length-1];
		var now_file_name		= '';
		var is_success			= true;

		if(!(new RegExp(file_ext_patten,'i')).test(File_ext)){										//업로드 확장자 체크
			var file_ext_types_str	= file_ext_types.join(', ');
			alert(data.files[idx].name+' 파일은 업로드 불가능 합니다. \n\n( '+file_ext_types_str+' 파일을 업로드 해 주세요.)');
			is_failed_array.push(idx);
		}
		else if (uploadFile.size > max_file_size ){													//업로드 파일 사이즈 체크
			alert(data.files[idx].name+' 파일은 업로드 불가능 합니다. \n\n업로드는 최대 '+(max_file_size/one_mb_size)+'MB 까지만 가능합니다.');
			is_failed_array.push(idx);
		}
		else{
			total_data_size		+= data.files[idx].size;
			add_cnt++;
		}
	}

	if( total_data_size > 0  ){
		$(".progress_num").show();
	}

	if( is_failed_array.length > 0 ){																//원하는 용량, 확장자가 아닌 경우 제거하는 파트
		for(var idx in is_failed_array){
			data.files.splice(is_failed_array[idx],1);
		}
	}

	if( total_data_size > one_mb_size ){															// 1MB 보다 크면 MB 단위로 보여준다.
			var data_send_result = '0MB/'+number_format( total_data_size / one_mb_size , 2)+'MB';
	}
	else{									// KB 단위로 보여준다.
		var data_send_result = '0KB/'+number_format( total_data_size / 1024 , 2)+'KB';
	}

	$(".progress_num").html(data_send_result);														//업로드할 총용량을 보여주자.
	( add_cnt > 0 ) ? $('#happy_upload_file_drop_zone_msg').hide() : "";							//드랍존 메시지 숨기기.
}