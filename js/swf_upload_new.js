

function getCookie(name) {
	var Found = false
	var start, end
	var i = 0

	while(i <= document.cookie.length) {
		start = i
		end = start + name.length

		if(document.cookie.substring(start, end) == name) {
			Found = true
			break
		}
		i++
	}

	if(Found == true) {
		start = end + 1
		end = document.cookie.indexOf(";", start)
		if(end < start)
		end = document.cookie.length
		return document.cookie.substring(start, end)
	}
	return ""
}

var swf_upload_forder = '';
var swf_form_name = 'document_frm';


var upload_image_movie_id='img'; //파일폼 고유ID
var upload_image_flash_width='700'; //파일폼 너비 (기본값 400, 권장최소 300)
var upload_image_list_rows='5'; // 파일목록 행 (기본값:3)
var upload_image_limit_size='240'; // 업로드 제한용량 (기본값 10)
var upload_image_file_type_name='이미지 파일 선택'; // 파일선택창 파일형식명 (예: 그림파일, 엑셀파일, 모든파일 등)
var upload_image_allow_filetype='*.jpg *.jpeg'; // 파일선택창 파일형식 (예: *.jpg *.jpeg *.gif *.png)
var upload_image_deny_filetype='*.php *.php3 *.php4 *.html *.inc *.js *.htm *.cgi *.pl *.doc *.jsp *.hwp *.zip *.rar *.tar'; // 업로드 불가형식
var upload_image_upload_exe='flash_upload.php'; // 업로드 담당프로그램
var upload_image_max_file_count='20'; //업로드제한
var upload_image_get_frameHeight = '500'; // 드래그 플레쉬 호출할  iframe 세로크기 [여기부터 아래쪽변수 미사용시 아무값이나]


var upload_image_limit_size_org = '';
var upload_image_max_file_count_org = '';


function makeSwfMultiUpload(){

	try { upload_image_movie_id			= movie_id; } catch (e){}
	try { upload_image_flash_width		= flash_width; } catch (e){}
	try { upload_image_list_rows		= list_rows; } catch (e){}
	try { upload_image_limit_size		= limit_size; } catch (e){}
	try { upload_image_file_type_name	= file_type_name; } catch (e){}
	try { upload_image_allow_filetype	= allow_filetype; } catch (e){}
	try { upload_image_deny_filetype	= deny_filetype; } catch (e){}
	try { upload_image_upload_exe		= upload_exe; } catch (e){}
	try { upload_image_max_file_count	= max_file_count; } catch (e){}
	try { upload_image_get_frameHeight	= get_frameHeight; } catch (e){}

	if ( upload_image_limit_size_org == '' )
	{
		upload_image_limit_size_org			= upload_image_limit_size;
	}

	if ( upload_image_max_file_count_org == '' )
	{
		upload_image_max_file_count_org		= upload_image_max_file_count;
	}

	image_upload_exe	= swf_upload_forder + upload_image_upload_exe;

	var flashvars = "flash_width="+upload_image_flash_width+"&amp;";
	flashvars += "list_rows="+upload_image_list_rows+"&amp;";
	flashvars += "limit_size="+upload_image_limit_size+"&amp;";
	flashvars += "file_type_name="+upload_image_file_type_name+"&amp;";
	flashvars += "allow_filetype="+upload_image_allow_filetype+"&amp;";
	flashvars += "deny_filetype="+upload_image_deny_filetype+"&amp;";
	flashvars += "upload_exe="+image_upload_exe+"&amp;";
	flashvars += "upload_id="+upload_image_movie_id+"&amp;";
	flashvars += "max_file_count="+upload_image_max_file_count+"&amp;";
	flashvars += "browser_id="+getCookie("PHPSESSID"); // FF에서 upload.php에게 별도의 PHPSESSID를 부여하므로 강제로 전달해 줌.



	var flashStr = "<div align='center'><embed src='"+swf_upload_forder+"multi_upload.swf' id='"+upload_image_movie_id+"' method='multi_upload' width='"+upload_image_flash_width+"' height='"+parseInt(upload_image_list_rows*20+70,10)+"' quality='high'";
	flashStr += "bgcolor='#ffffff' name='"+upload_image_movie_id+"' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'";
	flashStr += "pluginspage='http://www.macromedia.com/go/getflashplayer' flashvars='"+flashvars+"' max_file_count='"+max_file_count+"' limit_size='"+limit_size+"'/>";
	flashStr += "</embed></div>";

	document.getElementById('swf_upload_form_layer').innerHTML	= flashStr;
	//document.write(flashStr);
}







var drag_image_get_cntt			= "40";
var drag_image_get_Width		= 55;
var drag_image_get_Height		= 60;
var drag_image_get_limitimg		= 20;
var drag_image_get_Xpoint		= -42;
var drag_image_get_Ypoint		= -15;
var drag_image_get_wcount		= "10";
var drag_image_get_boxcolor		= "8ba9bf";
var drag_image_get_overcolor	= "aaaaaa";
var drag_image_get_extla		= "zip,rar,tar,gz,hwp,pdf,xls,ppt";
var drag_image_get_images		= "";
var drag_image_movie_id			= "kwak16";
var drag_image_types			= "return";
var drag_image_get_boxtext		= "[이미지1]||[이미지2]||[이미지3]||[이미지4]||[이미지5]||[이미지6]||[이미지7]||[이미지8]||[이미지9]||[이미지10]||[이미지11]||[이미지12]||[이미지13]||[이미지14]||[이미지15]||[이미지16]||[이미지17]||[이미지18]||[이미지19]||[이미지20]||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지||삭제이미지";
var drag_image_get_noimage		= "img/noimg_4.gif";
var drag_image_get_number		= '';

function makeDragImg(){


	try { drag_image_get_cntt		= drag_get_cntt; } catch (e){}
	try { drag_image_get_Width		= drag_get_Width; } catch (e){}
	try	{ drag_image_get_Height		= drag_get_Height; } catch (e){}
	try	{ drag_image_get_limitimg	= drag_get_limitimg; } catch (e){}
	try	{ drag_image_get_Xpoint		= drag_get_Xpoint; } catch (e){}
	try	{ drag_image_get_Ypoint		= drag_get_Ypoint; } catch (e){}
	try	{ drag_image_get_wcount		= drag_get_wcount; } catch (e){}
	try	{ drag_image_get_boxcolor	= drag_get_boxcolor; } catch (e){}
	try	{ drag_image_get_overcolor	= drag_get_overcolor; } catch (e){}
	try	{ drag_image_get_extla		= drag_get_extla; } catch (e){}
	try	{ drag_image_get_images		= drag_get_images; } catch (e){}
	try	{ drag_image_movie_id		= drag_image_movie_id; } catch (e){}
	try	{ drag_image_types			= drag_image_types; } catch (e){}
	try	{ drag_image_get_boxtext	= drag_get_boxtext; } catch (e){}
	try	{ drag_image_get_noimage	= drag_get_noimage; } catch (e){}
	try	{ drag_image_get_number		= drag_get_number; } catch (e){}



	image_get_noimage	= swf_upload_forder + drag_image_get_noimage;




	var flashvars = "get_cntt="+drag_image_get_cntt+"&amp;";
	flashvars += "get_Width="+drag_image_get_Width+"&amp;";
	flashvars += "get_Height="+drag_image_get_Height+"&amp;";
	flashvars += "get_wcount="+drag_image_get_wcount+"&amp;";
	flashvars += "get_limitimg="+drag_image_get_limitimg+"&amp;";
	flashvars += "get_Xpoint="+drag_image_get_Xpoint+"&amp;";
	flashvars += "get_Ypoint="+drag_image_get_Ypoint+"&amp;";
	flashvars += "get_boxcolor="+drag_image_get_boxcolor+"&amp;";
	flashvars += "get_overcolor="+drag_image_get_overcolor+"&amp;";
	flashvars += "get_extla="+drag_image_get_extla+"&amp;";
	flashvars += "get_images="+drag_image_get_images+"&amp;";
	flashvars += "get_boxtext="+drag_image_get_boxtext+"&amp;";
	flashvars += "get_noimage="+image_get_noimage;

	list_rows	= parseInt(drag_image_get_cntt / drag_image_get_wcount,10);
	list_rows	= drag_image_get_cntt % drag_image_get_wcount == 0 ? list_rows : list_rows+1;
	list_rows_Width = drag_image_get_Width+15;
	list_rows_Height = drag_image_get_Height+25;

	var flashStr = "<div align='center'>";
	flashStr += "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000'";
	flashStr += "codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0'";
	flashStr += "width='"+parseInt(drag_image_get_wcount*list_rows_Width+10,10)+"' height='"+parseInt(list_rows*list_rows_Height+35,10)+"' align='middle' id='"+movie_id+"' method='multi_upload_drag'>";
	flashStr += "<param name='allowScriptAccess' value='sameDomain' />";
	flashStr += "<param name='movie' value='"+swf_upload_forder+"dragimg.swf' />";
	flashStr += "<param name='scale' value='noscale' />";
	flashStr += "<param name='quality' value='high' />";
	flashStr += "<param name='bgcolor' value='#ffffff' />";
	flashStr += "<param name='salign' value='lt' />";
	flashStr += "<param name='flashvars' value='"+flashvars+"' />";
	flashStr += "<param name='wmode' value='transparent' />";
	flashStr += "<embed src='"+swf_upload_forder+"dragimg.swf' scale='noscale' salign='lt' width='"+parseInt(drag_image_get_wcount*list_rows_Width+10,10)+"' height='"+parseInt(list_rows*list_rows_Height+22,10)+"' quality='high'";
	flashStr += "bgcolor='#ffffff' name='multi_upload_drag' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'";
	flashStr += "pluginspage='http://www.macromedia.com/go/getflashplayer' flashvars='"+flashvars+"' />";
	flashStr += "</object>";
	flashStr += "</div>";

	document.getElementById('swf_upload_drag_layer').innerHTML	= flashStr;
	//document.write(flashStr);

}



function callSwfUpload(){ //플래쉬 파일 리스트에 추가된 파일을 전송
	arrMovie = new Array()
	var arr_num = 0;
	var objectTags = document.getElementsByTagName('embed');
	var movie;
	for (i = 0; i < objectTags.length; i++ ) {
		if(objectTags[i].getAttribute("method")=="single_upload" || objectTags[i].getAttribute("method")=="multi_upload"){
			if(document.getElementsByName(objectTags[i].getAttribute("id"))[0]) {
				movie = document.getElementsByName(objectTags[i].getAttribute("id"))[0];
			}else{
				movie = document.getElementById(objectTags[i].getAttribute("id"));
			}
			if(movie.GetVariable("totalSize")>0)
			{
				// 파일개수/ 업로드 용량 체크 패치
				chk_max_file_limit	= objectTags[i].getAttribute("max_file_count");		// 허용된 파일 업로드 개수
				chk_limit_size		= objectTags[i].getAttribute("limit_size");			// 허용된 총 파일 용량

				// 파일 개수 체크
				if ( chk_max_file_limit != undefined )
				{
					chk_max_file_limit	= chk_max_file_limit * 1;
					now_file_list		= movie.GetVariable("list");
					now_file_list_cnt	= now_file_list.split(",");
					now_file_list_cnt	= now_file_list_cnt.length;

					if ( chk_max_file_limit < now_file_list_cnt )
					{
						alert("최대 파일개수를 초과하였습니다");
						return;
					}
				}

				// 파일 용량 체크
				if ( chk_limit_size != undefined )
				{
					chk_limit_size_b	= chk_limit_size * 1024 * 1024; // Mbyte -> Byte 변경
					now_file_size		= movie.GetVariable("totalSize")*1;

					if ( chk_limit_size_b < now_file_size )
					{
						alert(chk_limit_size +" Mbyte 이상 업로드 불가능 합니다.");
						return;
					}
				}
				// END 파일개수/ 업로드 용량 체크 패치

				arrMovie[arr_num] = movie;
				arr_num++;
			}
		}
	}

	if(arrMovie.length>0){
		if(arrMovie[0].getAttribute("method")=="single_upload" || arrMovie[0].parentNode.getAttribute("method")=="single_upload") arrMovie[0].height = 45;
		if(arrMovie[0].getAttribute("method")=="multi_upload" || arrMovie[0].parentNode.getAttribute("method")=="multi_upload") arrMovie[0].height = parseInt(20*arrMovie[0].GetVariable("listRows")+25+45,10);
		arrMovie[0].SetVariable( "startUpload", "" );
		arr_mov = 0;
	}else{
		//document.forms['regiform'].submit();
		alert('업로드할 파일을 선택하신후 업로드 버튼을 눌러주세요.');
		//document.getElementById('swf_upload_layer').innerHTML	= "<iframe src='flash_upload_drag.php' width='100%' height='280' frameborder='0'></iframe>";
	}
}

function exRound(val, pos)
{
    var rtn;
    rtn = Math.round(val * Math.pow(10, Math.abs(pos)-1))
    rtn = rtn / Math.pow(10, Math.abs(pos)-1)


    return rtn;
}




function swfUploadComplete(){
	arr_mov++;
	if(arrMovie.length>arr_mov){
		if(arrMovie[arr_mov].getAttribute("method")=="single_upload" || arrMovie[arr_mov].parentNode.getAttribute("method")=="single_upload") arrMovie[arr_mov].height = 45;
		if(arrMovie[arr_mov].getAttribute("method")=="multi_upload" || arrMovie[arr_mov].parentNode.getAttribute("method")=="multi_upload") arrMovie[arr_mov].height = parseInt(20*arrMovie[arr_mov].GetVariable("listRows")+25+45,10);
		arrMovie[arr_mov].SetVariable( "startUpload", "" );
	}else{
		//document.forms['regiform'].submit();
		alert(' 업로드가 완료되었습니다.   ');

		$.ajax({
					type: "POST",
					url: swf_upload_forder+"ajax_flash_upload_drag.php",
					data: {
								number: drag_image_get_number,
								max_file_limit:upload_image_max_file_count_org,
								upload_limit_size:upload_image_limit_size_org,
								swf_upload_forder:swf_upload_forder
					},
					success: function( returnData )
					{

						returnDatas		= returnData.split("___cut___");

						//alert(returnDatas[0]);	//남은 업로드 파일 개수
						//alert(returnDatas[1]);	//남은 업로드 총 용량
						//alert(returnDatas[2]);	//드래그툴 이미지
						//alert(returnDatas[3]);	//input hidden용 이미지

						// 이미지 hidden 값 처리
						return_images	= returnDatas[3].split("||");
						for ( i=0 ; i<return_images.length ; i++ )
						{
							if ( document.forms[swf_form_name]["img"+i] != undefined )
							{
								document.forms[swf_form_name]["img"+i].value	= return_images[i];
							}
							else
							{
								alert('img'+i +" 객체가 존재하지 않습니다.");
							}
						}

						// 드래그툴 호출
						makeDragImg(
							drag_get_images = returnDatas[2]
						);

						// 멀티업로드 재로딩
						makeSwfMultiUpload(
							max_file_count = returnDatas[0],
							limit_size = returnDatas[1]
						);

					},
					error: function ()
					{
						alert('AJAX 통신 에러');
					}
		})

		//document.getElementById('swf_upload_layer').innerHTML	= makeDragImg();

		return;
		/*
		if ( parent.document.getElementById('swf_upload_layer') != undefined )
		{
			parent.document.getElementById('swf_upload_layer').innerHTML	= "<iframe id='board_multi_upload_frame' src='"+frameSrc+"' width='100%' height='"+frameHeight+"' frameborder='0' scrolling='no'></iframe>";
		}
		else
		{
			document.getElementById('swf_upload_layer').innerHTML	= "<iframe id='board_multi_upload_frame' src='"+frameSrc+"' width='100%' height='"+frameHeight+"' frameborder='0' scrolling='no'></iframe>";
		}*/
	}
}




function swf_img_change( no1 , no2 )
{
	//alert( no1 +" --- "+ no2 );

	val1	= document.forms[swf_form_name]['img'+no1].value;
	val2	= document.forms[swf_form_name]['img'+no2].value;

	document.forms[swf_form_name]['img'+no1].value	= val2;
	document.forms[swf_form_name]['img'+no2].value	= val1;
}





function fileTypeError( notAllowFileType ){ //허용하지 않은 형식의 파일일 경우 에러 메시지 출력
	alert("확장자가 " + notAllowFileType + "인 파일들은 업로드 할 수 없습니다.");
}

function overSize( limitSize ){ //허용하지 않은 형식의 파일일 경우 에러 메시지 출력
	alert("선택한 파일의 크기가 " + limitSize + "를 초과했습니다.");
}

function versionError(){ //플래쉬 버전이 8 미만일 경우 에러 메시지 출력
	//alert("플래쉬 버전이 8.0 이상인지 확인하세요.\n이미 설치하신 경우는 브라우저를 전부 닫고 다시 시작하세요.");
}

function httpError(){ //http 에러 발생시 출력 메시지
	alert("네트워크 에러가 발생하였습니다. 관리자에게 문의하세요.");
}

function ioError(){ //파일 입출력 에러 발생시 출력 메시지
	alert("입출력 에러가 발생하였습니다.\n 다른 프로그램에서 이 파일을 사용중인지 확인하세요.");
}

function onSecurityError(){ //파일 입출력 에러 발생시 출력 메시지
	alert("보안 에러가 발생하였습니다. 관리자에게 문의하세요.");
}

function max_file_countError(){
	alert("최대 파일겟수를 초과하였습니다");
}