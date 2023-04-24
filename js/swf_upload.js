var frameHeight	= "";
var frameSrc	= "";

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

function makeSwfSingleUpload(){
	var flashvars = "flash_width="+flash_width+"&amp;";
	flashvars += "limit_size="+limit_size+"&amp;";
	flashvars += "file_type_name="+file_type_name+"&amp;";
	flashvars += "allow_filetype="+allow_filetype+"&amp;";
	flashvars += "deny_filetype="+deny_filetype+"&amp;";
	flashvars += "upload_exe="+upload_exe+"&amp;";
	flashvars += "upload_id="+movie_id+"&amp;";
	flashvars += "browser_id="+getCookie("PHPSESSID"); // FF에서 upload.php에게 별도의 PHPSESSID를 부여하므로 강제로 전달해 줌.

	var flashStr = "<embed src='single_upload.swf' method='single_upload' width='"+flash_width+"' height='50' quality='high'";
	flashStr += "bgcolor='#ffffff' name='"+movie_id+"' id='"+movie_id+"' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'";
	flashStr += "pluginspage='http://www.macromedia.com/go/getflashplayer' flashvars='"+flashvars+"' />";
	flashStr += "</embed>";
	document.write(flashStr); 
}

function makeSwfMultiUpload(){
	var flashvars = "flash_width="+flash_width+"&amp;";
	flashvars += "list_rows="+list_rows+"&amp;";
	flashvars += "limit_size="+limit_size+"&amp;";
	flashvars += "file_type_name="+file_type_name+"&amp;";
	flashvars += "allow_filetype="+allow_filetype+"&amp;";
	flashvars += "deny_filetype="+deny_filetype+"&amp;";
	flashvars += "upload_exe="+upload_exe+"&amp;";
	flashvars += "upload_id="+movie_id+"&amp;";
	flashvars += "max_file_count="+max_file_count+"&amp;";
	flashvars += "browser_id="+getCookie("PHPSESSID"); // FF에서 upload.php에게 별도의 PHPSESSID를 부여하므로 강제로 전달해 줌.

	frameHeight	= get_frameHeight;
	frameSrc	= get_frameSrc;	
	

	var flashStr = "<embed src='multi_upload.swf' method='multi_upload' width='"+flash_width+"' height='"+parseInt(list_rows*21+25,10)+"' quality='high'";
	flashStr += "bgcolor='#ffffff' name='"+movie_id+"' id='"+movie_id+"' align='middle' wmode='Transparent' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'";
	flashStr += "pluginspage='http://www.macromedia.com/go/getflashplayer' flashvars='"+flashvars+"' />";
	flashStr += "</embed>";
	document.write(flashStr); 
}




var multiUpload_movie_id		= '';
var multiUpload_flash_width		= '';
var multiUpload_list_rows		= '';
var multiUpload_limit_size		= '';
var multiUpload_file_type_name	= '';
var multiUpload_allow_filetype	= '';
var multiUpload_deny_filetype	= '';
var multiUpload_upload_exe		= '';
var multiUpload_max_file_count	= '';
var multiUpload_get_frameHeight	= '';
var multiUpload_get_frameSrc	= '';
var multiUpload_div_id			= '';

function makeSwfMultiUpload_div(){

	if ( document.getElementById(div_id) == undefined )
	{
		return false;
	}

	multiUpload_movie_id		= movie_id;
	multiUpload_flash_width		= flash_width;
	multiUpload_list_rows		= list_rows;
	multiUpload_limit_size		= limit_size;
	multiUpload_file_type_name	= file_type_name;
	multiUpload_allow_filetype	= allow_filetype;
	multiUpload_deny_filetype	= deny_filetype;
	multiUpload_upload_exe		= upload_exe;
	multiUpload_max_file_count	= max_file_count;
	multiUpload_get_frameHeight	= get_frameHeight;
	multiUpload_get_frameSrc	= get_frameSrc;
	multiUpload_div_id			= div_id;

	viewSwfMultiUpload_div();
}



function viewSwfMultiUpload_div()
{
	if ( multiUpload_div_id == '' )
	{
		return false;
	}


	happyStartRequest('multi_upload_count_ajax.php?count='+ multiUpload_max_file_count , 'viewSwfMultiUpload_div2');

}



function viewSwfMultiUpload_div2()
{

	max_file_count		= response;


	var flashvars = "flash_width="+multiUpload_flash_width+"&amp;";
	flashvars += "list_rows="+multiUpload_list_rows+"&amp;";
	flashvars += "limit_size="+multiUpload_limit_size+"&amp;";
	flashvars += "file_type_name="+multiUpload_file_type_name+"&amp;";
	flashvars += "allow_filetype="+multiUpload_allow_filetype+"&amp;";
	flashvars += "deny_filetype="+multiUpload_deny_filetype+"&amp;";
	flashvars += "upload_exe="+multiUpload_upload_exe+"&amp;";
	flashvars += "upload_id="+multiUpload_movie_id+"&amp;";
	flashvars += "max_file_count="+max_file_count+"&amp;";
	flashvars += "browser_id="+getCookie("PHPSESSID"); // FF에서 upload.php에게 별도의 PHPSESSID를 부여하므로 강제로 전달해 줌.

	frameHeight	= multiUpload_get_frameHeight;
	frameSrc	= multiUpload_get_frameSrc;


	flashStr = "<embed src='multi_upload.swf' method='multi_upload' width='"+multiUpload_flash_width+"' height='"+parseInt(multiUpload_list_rows*20+25,10)+"' quality='high'";
	flashStr += "bgcolor='#ffffff' name='"+multiUpload_movie_id+"' id='"+multiUpload_movie_id+"' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'";
	flashStr += "pluginspage='http://www.macromedia.com/go/getflashplayer' flashvars='"+flashvars+"' />";
	flashStr += "</embed>";



	document.getElementById(multiUpload_div_id).innerHTML	= flashStr;
}




function makeDragImg(){
	var flashvars = "get_cntt="+get_cntt+"&amp;";
	flashvars += "get_Width="+get_Width+"&amp;";
	flashvars += "get_Height="+get_Height+"&amp;";
	flashvars += "get_wcount="+get_wcount+"&amp;";
	flashvars += "get_limitimg="+get_limitimg+"&amp;";
	flashvars += "get_Xpoint="+get_Xpoint+"&amp;";
	flashvars += "get_Ypoint="+get_Ypoint+"&amp;";
	flashvars += "get_boxcolor="+get_boxcolor+"&amp;";
	flashvars += "get_overcolor="+get_overcolor+"&amp;";
	flashvars += "get_extla="+get_extla+"&amp;";
	flashvars += "get_images="+get_images+"&amp;";
	flashvars += "get_boxtext="+get_boxtext+"&amp;";
	flashvars += "get_noimage="+get_noimage;

	list_rows	= parseInt(get_cntt / get_wcount,10);
	list_rows	= get_cntt % get_wcount == 0 ? list_rows : list_rows+1;
	list_rows_Width = get_Width+15;
	list_rows_Height = get_Height+25;

	var flashStr = "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000'";
	flashStr += "codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0'";
	flashStr += "width='"+parseInt(get_wcount*list_rows_Width+10,10)+"' height='"+parseInt(list_rows*list_rows_Height+35,10)+"' align='middle' id='"+movie_id+"' method='multi_upload'>";
	flashStr += "<param name='allowScriptAccess' value='sameDomain' />";
	flashStr += "<param name='movie' value='dragimg.swf' />";
	flashStr += "<param name='scale' value='noscale' />";
	flashStr += "<param name='quality' value='high' />";
	flashStr += "<param name='bgcolor' value='#ffffff' />";
	flashStr += "<param name='salign' value='lt' />";
	flashStr += "<param name='flashvars' value='"+flashvars+"' />";
	flashStr += "<embed src='dragimg.swf' scale='noscale' salign='lt' width='"+parseInt(get_wcount*list_rows_Width+10,10)+"' height='"+parseInt(list_rows*list_rows_Height+35,10)+"' quality='high'";
	flashStr += "bgcolor='#ffffff' name='"+movie_id+"' align='middle' allowScriptAccess='sameDomain' type='application/x-shockwave-flash'";
	flashStr += "pluginspage='http://www.macromedia.com/go/getflashplayer' flashvars='"+flashvars+"' />";
	flashStr += "</object>";

	document.write(flashStr); 
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
			if(movie.GetVariable("totalSize")>0){				
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
		alert('업로드가 완료되었습니다. 이미지를 배치시켜주세요.');
		/*
		document.getElementById('swf_upload_layer').innerHTML	= makeDragImg(
				get_cntt		= "10",
				get_wcount		= "5",
				get_boxcolor	= "CC0000",
				get_overcolor	= "666666",
				get_extla		= "zip,rar,tar,gz,hwp,pdf,xls,ppt",
				get_images		= "upload/2008/02/14/1202996493-4-1.jpg||upload/2008/02/14/1202996544-15-0.jpg||upload/2008/02/14/1202996493-4-1.jpg||upload/2008/02/14/1202996544-44-1.jpg||upload/2008/02/14/1202996544-44-1.jpg||upload/2008/02/14/1202996544-15-0.jpg||upload/2008/02/14/1202996544-44-1.jpg||upload/2008/02/14/1202996493-56-0.jpg",
				movie_id		= "kkk",
				types			= "return"
			);*/

		document.getElementById('swf_upload_layer').innerHTML	= "<iframe src='"+frameSrc+"' width='100%' height='"+frameHeight+"' frameborder='0' scrolling='no'></iframe>";

		if ( multiUpload_div_id != '' )
		{
			viewSwfMultiUpload_div();
		}
	}	
}




function swf_img_change( no1 , no2 )
{
	//alert( no1 +" --- "+ no2 );

	val1	= parent.document_frm['img'+no1].value;
	val2	= parent.document_frm['img'+no2].value;

	parent.document_frm['img'+no1].value	= val2;
	parent.document_frm['img'+no2].value	= val1;
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