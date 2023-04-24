/*		이미지 업로드에서 사용되는 스크립트		*/
function thumb_type_change(val)
{
	msg			= '';
	switch ( val )
	{
		case '가로기준' :			msg	= '가로크기를 기준으로 세로크기를 자동 조절'; break;
		case '세로기준' :			msg	= '세로크기를 기준으로 가로크기를 자동 조절'; break;
		case '비율대로짜름' :		msg	= '입력된 크기에 적합한 이미지크기 자동 조절'; break;
		case '비율대로축소' :		msg	= '입력된 크기로 이미지 생성<br>(모자라는 부분은 이미지안에 여백 발생)'; break;
		case '비율대로확대' :		msg	= '입력된 크기로 이미지 생성<br>(남는 부분은 이미지가 짤림)'; break;
		case '가로기준세로짜름' :	msg	= '가로를 기준으로 세로 이미지 자름<br>(세로크기가 적을경우 빈여백)'; break;
		case '세로기준가로짜름' :	msg	= '세로를 기준으로 가로 이미지 자름<br>(가로크기가 적을경우 빈여백)'; break;
		default :					msg	= '선택해주세요.'; break;
	}

	document.getElementById('thumb_type_help').innerHTML	= msg;
}

var prev_no		= '1';
function happyTabChange(no)
{
	if ( prev_no == no )
	{
		return false;
	}
	var objTab_new	= document.getElementById('happyTab'+no);
	var objTab_old	= document.getElementById('happyTab'+prev_no);
	var objDiv_new	= document.getElementById('happyDiv'+no);
	var objDiv_old	= document.getElementById('happyDiv'+prev_no);

	if ( objTab_new != undefined )
	{
		objTab_new.className	= 'tap_st_over';

	}

	if ( objTab_old != undefined )
	{
		objTab_old.className	= 'tap_st_out';
	}

	if ( objDiv_old != undefined )
	{
		objDiv_old.style.display	= 'none';
	}

	if ( objDiv_new != undefined )
	{
		objDiv_new.style.display	= '';
	}

	prev_no			= no;
}

function image_upload_submit()
{
	if( document.getElementById('uploadInputBox').value != '' )
	{
		document.getElementById("pop_footer").style.display = "none";
		document.getElementById("pop_footer_ing").style.display = "";
		document.editor_upload_form.submit();
	}
	else
	{
		alert('파일을 선택해 주세요.');
	}
}

function image_upload_submit_no()
{
	document.getElementById("pop_footer").style.display = "";
	document.getElementById("pop_footer_ing").style.display = "none";
	//document.editor_upload_form.submit();
}

//원본출력시 추가설정부분 보이고 가리기
function print_org_click(checkbox)
{
	div1 = document.getElementById('print_org_div1');
	if ( checkbox != undefined && div1 != undefined )
	{
		if ( checkbox.checked == true )
		{
			div1.style.display = "";
			parent.document.getElementById("editor_layer_content_frame").style.height = ( parseInt(parent.document.getElementById("editor_layer_content_frame").style.height.replace("px","")) + 50 ) + "px";
		}
		else
		{
			div1.style.display = "none";
			parent.document.getElementById("editor_layer_content_frame").style.height = ( parseInt(parent.document.getElementById("editor_layer_content_frame").style.height.replace("px","")) - 50 ) + "px";
		}
	}


	//alert($('#editor_layer_content_frame').parent().style( "height"));
}
/*		이미지 업로드에서 사용될 스크립트	*/