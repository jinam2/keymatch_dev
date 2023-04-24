

var upload_file_array			= new Array;
function happy_multi_img_upload()
{
	tmp_file_ext_types				= file_ext_types.join('|');
	file_ext_patten					= "("+tmp_file_ext_types+")";
	loading_data					= {loading_type: 'default', number: data_key_number, thumb_image_option:thumb_image_option};

	$('#max_img_count_span').html(max_file_count);

	var choice_file_cnt				= 0;
	var add_cnt						= 0;
	var play_trigger				= true;
	var total_data_size				= 0;
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
			formData			: {loading_type: 'submit', number: data_key_number, thumb_image_option:thumb_image_option},
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
			},
			/*
			//add 옵션은 드래그 시 즉시 업로드하고 싶을 경우 사용하세요.
			//.bind('fileuploadadd') 파트는 주석처리 하셔야함을 유의.

			add					: function (e, data){
				var goUpload = true;

				if( ( max_file_count < data.originalFiles.length + upload_file_array.length ) )		//최대 업로드 가능개수 체크
				{
					goUpload = false;
					alert('최대 '+max_file_count+' 개만 업로드 가능 합니다.');
				}

				//확장자 체크
				var uploadFile			= data.files[0];
				var Filename_tmp		= uploadFile.name.split('.');
				var File_ext			= Filename_tmp[Filename_tmp.length-1];

				if(!(new RegExp(file_ext_patten,'i')).test(File_ext))
				{
					goUpload = false;
					var file_ext_types_str				= file_ext_types.join(', ');
					alert(File_ext+' 확장자는 업로드 불가능 합니다. \n( '+file_ext_types_str+' 파일을 업로드 해 주세요. )');
				}

				//업로드 가능 파일 사이즈 체크
				if (uploadFile.size > max_file_size )			//1000000		= 1MB
				{
					goUpload = false;
					alert('업로드는 최대 '+(max_file_size/one_mb_size)+'MB 까지만 가능합니다.');
				}

				if (goUpload == true) {
					$('#'+form_name).addClass('fileupload-processing');
					data.submit();
				}
			}
			*/
		});

		$('#'+form_name)
		.bind('fileuploadcompleted', function (e,data){			//파일 업로드가 완료되면 sort table 정리 + 선택 파일 수 초기화 + 업로드 용량 숨기기 처리.
			if( data.files != undefined )
			{
				completed_cnt++;
			}
			happy_file_resort();

			if( completed_cnt == choice_file_cnt )
			{
				choice_file_cnt			= 0;
				completed_cnt			= 0;
				$(".progress_num").hide();
				//happy_file_resort();
			}
		})
		.bind('fileuploadchange', function (e, data) {			//파일을 1개씩 선택할 경우 ...
			//console.log(data.files);
			choice_file_cnt			= data.files.length;
			$.each(data.files, function (index, file) {
				total_data_size		+= file.size;
			});
		})

		.bind('fileuploaddrop', function (e, data) {			//파일을 드랍한 경우 ...
			choice_file_cnt			= data.files.length;
			//total_data_size			= 0 ;
			$.each(data.files, function (index, file) {
				total_data_size		+= file.size;
			});
		})

		.bind('fileuploadadd', function (e, data){					//업로드 전 파일 체크를 담당하는 녀석.
			//console.log(data.originalFiles);

			//첨부된 전체 파일중 허용된 확장자 파일이 있을 경우 return
			if( ( max_file_count < data.originalFiles.length + upload_file_array.length ) )		//최대 업로드 가능개수 체크
			{
				alert('최대 '+max_file_count+' 개만 업로드 가능 합니다.');
				choice_file_cnt--;
				return false;
			}

			//확장자 체크
			var uploadFile			= data.files[0];
			var Filename_tmp		= uploadFile.name.split('.');
			var File_ext			= Filename_tmp[Filename_tmp.length-1];
			var now_file_name		= '';
			var is_submit			= true;



			if(!(new RegExp(file_ext_patten,'i')).test(File_ext))							//업로드 확장자 체크
			{
				//data.originalFiles 에서 index 찾기
				//그런데 사용해보니 originalFiles 의 배열을 삭제하면 전체적인 오류 발생.
				/*
				now_file_name		= data.files[0].name;
				var find_index		= data.originalFiles.findIndex(function(element){
					return element.name == now_file_name;
				});
				data.originalFiles.splice(find_index,1);
				*/

				choice_file_cnt--;
				var file_ext_types_str	= file_ext_types.join(', ');
				alert(data.files[0].name+' 파일은 업로드 불가능 합니다. \n\n( '+file_ext_types_str+' 파일을 업로드 해 주세요.)');
				data.files.length = 0;

				if( add_cnt != choice_file_cnt )			//업로드 불가능한 파일이 제일 끝에 위치한 경우 ... 에는 submit 가능 상태로 처리해 주자.
				{
					is_submit				= false;
				}
			}
			else if (uploadFile.size > max_file_size )										//업로드 파일 사이즈 체크
			{
				//data.context.remove();
				alert(data.files[0].name+' 파일은 업로드 불가능 합니다. \n\n업로드는 최대 '+(max_file_size/one_mb_size)+'MB 까지만 가능합니다.');
				choice_file_cnt--;
				//return false;
				data.files.length = 0;

				if( add_cnt != choice_file_cnt )			//업로드 불가능한 파일이 제일 끝에 위치한 경우 ... 에는 submit 가능 상태로 처리해 주자.
				{
					is_submit				= false;
				}
			}
			else
			{
				add_cnt++;
			}

			if( is_submit && add_cnt > 0 )
			{
				$(".progress_num").show();

				//총용량 보여주기 위해...
				if( total_data_size > one_mb_size )			// 1MB 보다 크면 MB 단위로 보여준다.
				{
					var data_send_result = '0MB/'+number_format( total_data_size / one_mb_size , 2)+'MB';
				}
				else									// KB 단위로 보여준다.
				{
					var data_send_result = '0KB/'+number_format( total_data_size / 1024 , 2)+'KB';
				}
				$(".progress_num").html(data_send_result);

				$('#happy_upload_file_drop_zone_msg').hide();

				//console.log(add_cnt,' == ',choice_file_cnt);

				if( add_cnt == choice_file_cnt ){
					var upload_delay_time_sum	= upload_delay_time * add_cnt;
					if( play_trigger ){
						setTimeout(function(){
							$(this).addClass('fileupload-processing')
							$('#html5_upload_btn').trigger("click");
							add_cnt					= 0;
							total_data_size			= 0;
							//console.log('upload start');
						},upload_delay_time_sum);
						play_trigger		= false;
					}
				}
			}

			if( choice_file_cnt == 0 )		//잘못된 파일을 업로드 한 경우라면 프로그레스 바 초기화.
			{
				return false;
			}
		})

		.bind('fileuploadsend', function (e, data){
			//console.log('fileuploadsend');
			play_trigger		 = true;
		})

		.bind('fileuploaddestroyed', function (e){
			happy_file_resort();
		});

		// Load existing files:
		$('#'+form_name).addClass('fileupload-processing');

		/*	처음 불러올때만 사용하고 파일을 드래그하는 경우 submit 한다 */
		$.ajax({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			data			: loading_data,
			type			: 'POST',
			url				: $('#'+form_name).fileupload('option', 'url'),
			dataType		: 'json',
			context			: $('#'+form_name)[0],
		})
		.always(function() {
			$(this).removeClass('fileupload-processing');
		})
		.done(function(result) {
			$(this).fileupload('option', 'done').call(this, $.Event('done'), { result: result });
		});
		/*	처음 불러올때만 사용하고 파일을 드래그하는 경우 submit 한다 */
	});

	$(".files" ).sortable({
		//placeholder:"itemBoxHighlight",			//디자인 작업하실때 꼭 쓰세요.
		update: function(event, ui) {
			happy_file_resort();
		}
	});
}


function happy_file_resort()
{
	upload_file_array			= new Array;

	this_index			= 0;
	$('.files happy_upload_file_name').each( function(e) {
		upload_file_array[this_index]	= $(this).attr('id');
		this_index++;
	});

	for( var i = 0 ; i < max_file_count ; i++ )
	{
		tag_name		= form_img_names[i];
		document.forms[form_name][tag_name].value	= ( upload_file_array[i] != undefined) ? upload_file_array[i] : "";
	}

	if( this_index > 0 )
	{
		$('#happy_upload_file_drop_zone_msg').hide();
	}
	else if ( this_index == 0 )
	{
		$('#happy_upload_file_drop_zone_msg').show();
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


//에디터용 레이어를 같이 사용하도록 하였습니다.  만약 에디가 없다면 editor_layer  파트를 선언해 주셔야 함.
var happy_upload_layer_zIndex		= 0;
function happy_multi_modal_open(file)
{
	//console.log(file);
	$('#happy_upload_img_layer').attr("src", file);
	var temp = $('#happy_upload_in_layer');
	var happy_upload_layer_bg = temp.prev().hasClass('happy_upload_layer_bg');	//dimmed 레이어를 감지하기 위한 boolean 변수
	if(happy_upload_layer_bg){
		happy_upload_layer_zIndex = $('.happy_upload_layer').css("zIndex");
		$('.happy_upload_layer').css("zIndex",999999)
		$('.happy_upload_layer').fadeIn();	//'happy_upload_layer_bg' 클래스가 존재하면 레이어가 나타나고 배경은 dimmed 된다.
	}else{
		temp.fadeIn();
	}

	// 화면의 중앙에 레이어를 띄운다.
	if (temp.outerHeight() < $(document).height() )
		temp.css('margin-top', '-'+temp.outerHeight()/2+'px');
	else
		temp.css('top', '0px');
	/*
	if (temp.outerWidth() < $(document).width() )
		temp.css('margin-left', '-'+temp.outerWidth()/2+'px');
	else
		temp.css('left', '0px');
	*/

	$('#happy_upload_layer_close').click(function(e){
		if(happy_upload_layer_bg){
			$('.happy_upload_layer').fadeOut(); //'happy_upload_layer_bg' 클래스가 존재하면 레이어를 사라지게 한다.
		}else{
			temp.fadeOut();
		}
		e.preventDefault();
	});

	//$('.happy_upload_layer .happy_upload_layer_bg').click(function(e){	//배경을 클릭하면 레이어를 사라지게 하는 이벤트 핸들러
	$('.happy_upload_layer').click(function(e){	//배경을 클릭하면 레이어를 사라지게 하는 이벤트 핸들러
		$('.happy_upload_layer').css("zIndex",happy_upload_layer_zIndex)
		$('.happy_upload_layer').fadeOut();
		e.preventDefault();
	});
}