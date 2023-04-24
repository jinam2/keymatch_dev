
var var_profile_id		= '';
var var_start_date		= '';
var var_end_date		= '';

// AJAX 관련 변수
var happy_analytics_Request			= '';
var happy_analytics_HandleFunction	= '';
var happy_analytics_AJAXCall		= '';
var happy_analytics_AJAXCallTime	= 2000;
var happy_analytics_response		= '';
var happy_analytics_ajax_cancle		= '1';

var happy_analytics_popup			= '';

// 통계 갱신 폼 세팅
function happy_analytics_form_submit(form)
{
	if ( form.demo_lock.value )
	{
		alert('데모에서는 구글통계정보 수집을 이용할 수 없습니다.');
		return false;
	}

	var_start_date		= form.s_date.value;
	var_end_date		= form.e_date.value;
	var_profile_id		= form.profile_id.value;

	happy_analytics_call();

	return false;
}


// 통계 갱신 시도 요청
function happy_analytics_call()
{
	var happy_analytics_popup	= window.open('../ga/call.php?profile_id='+var_profile_id+'&start_date='+var_start_date+'&end_date='+var_end_date,'google_analytics_popup', 'width=450,height=500,scrollbars=yes'); //팝업주소 변경.

	try
	{
		happy_analytics_popup.focus();
	}
	catch (e)
	{
	}

	happy_analytics_ajax_start();

}


// 통계 갱신 시도시 AJAX 호출
function happy_analytics_ajax_start()
{
	if (window.XMLHttpRequest)
	{
		happy_analytics_Request					= new XMLHttpRequest();
	}
	else
	{
		happy_analytics_Request					= new ActiveXObject("Microsoft.XMLHTTP");
	}

	happy_analytics_ajax_cancle				= '';
	happy_analytics_ajax_call();
}


function happy_analytics_ajax_call()
{
	if ( happy_analytics_ajax_cancle == '' )
	{
		happy_analytics_AJAXCall				= setTimeout("happy_analytics_ajax()", happy_analytics_AJAXCallTime);
	}
}


// 통계 갱신 체크용 AJAX
function happy_analytics_ajax()
{
	happy_analytics_StartRequest('./ajax_happy_analytics.php?profile_id='+var_profile_id, 'happy_analytics_ajax_return');
}



// 통계 갱신 AJAX 호출 함수
function happy_analytics_StartRequest( linkUrl, handleFunc )
{
	happy_analytics_HandleFunction				= handleFunc;
	happy_analytics_Request.open("GET", linkUrl , true);
	happy_analytics_Request.onreadystatechange	= happy_analytics_HandleStateChange;
	happy_analytics_Request.send(null);
}


// 통계 갱신 AJAX handler
function happy_analytics_HandleStateChange()
{
	if (happy_analytics_Request.readyState == 4)
	{
		if (happy_analytics_Request.status == 200)
		{
			happy_analytics_response				= happy_analytics_Request.responseText;
			eval(happy_analytics_HandleFunction +"()");
		}
	}
}


// 통계 갱신 AJAX Return Check
function happy_analytics_ajax_return()
{
	//alert(happy_analytics_response);

	if ( happy_analytics_response == '' )
	{
		happy_analytics_ajax_call();
	}
	else if ( happy_analytics_response == 'ok' )
	{
		try
		{
			alert('성공! 통계 정보를 갱신하였습니다.');
			window.location.reload();
		}
		catch (e)
		{
			alert('통계 정보 갱신에 실패하였습니다. 다시 시도해주세요.');
			happy_analytics_cancle_call();
		}
	}
	else
	{
		alert('통계 정보 갱신에 실패하였습니다. 다시 시도해주세요.');
		happy_analytics_cancle_call();
	}
}



// 통계 갱신 취소 요청
function happy_analytics_cancle_call()
{
	happy_analytics_ajax_cancle				= '1';
}