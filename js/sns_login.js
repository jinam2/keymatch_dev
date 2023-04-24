

var sns_login_ing			= '';


// 로그인 버튼 관련 변수
var sns_login_btn_id		= '';
var sns_login_btn_src		= '';

var var_sns_id				= '';
var var_sns_site			= '';
var var_userkey				= '';


// AJAX 관련 변수
var sns_Request				= '';
var sns_HandleFunction		= '';
var sns_AJAXCall			= '';
var sns_AJAXCallTime		= 2000;
var sns_response			= '';
var sns_ajax_cancle			= '1';


var facebook_login_popup	= '';


//리턴URL 추가 hong
var return_url				= '';

//SNS 로그인 개별연동 - hong 추가
var sns_site_each			= '';

// 로그인 시도 요청
function sns_login_call(sns_site, sns_id, userkey, returnUrl)
{
	sns_site_each			= '';

	if( sns_AJAXCall != '' )
	{
		clearTimeout(sns_AJAXCall);
	}

	facebook_login_popup	= window.open('https://analytics.cafe24.com/sns/sns_call.php?sns_site='+sns_site+'&sns_id='+sns_id+'&userkey='+userkey,'facebook_login_popup', 'width=500,height=500');
	try
	 {
	  facebook_login_popup.focus();
	 }
	 catch (e)
	 {
	 }

	if ( var_userkey == '' || var_sns_site != sns_site )
	{
		var_sns_id				= sns_id;
		var_sns_site			= sns_site;
		var_userkey				= userkey;
	}

	if ( returnUrl != undefined && returnUrl != "" )
	{
		return_url				= returnUrl;
	}
	else
	{
		return_url				= window.location.href;
	}

	sns_login_ajax_start();

}


// 로그인 시도시 AJAX 호출
function sns_login_ajax_start()
{
	if (window.XMLHttpRequest)
	{
		sns_Request					= new XMLHttpRequest();
	}
	else
	{
		sns_Request					= new ActiveXObject("Microsoft.XMLHTTP");
	}

	sns_ajax_cancle				= '';
	sns_login_ajax_call()
}


function sns_login_ajax_call()
{
	if ( sns_ajax_cancle == '' )
	{
		sns_AJAXCall				= setTimeout("sns_login_ajax()", sns_AJAXCallTime);
	}
	else
	{
		//sns_ajax_cancle				= '';
	}

}


// 로그인 체크용 AJAX
function sns_login_ajax()
{
	//document.getElementById('sns_login_div').innerHTML	= document.getElementById('sns_login_div').innerHTML + 'a';
	sns_StartRequest('./ajax_sns_login.php?sns_site='+var_sns_site+'&sns_id='+var_sns_id+'&userkey='+var_userkey , 'sns_login_ajax_return');
}



// AJAX 호출 함수
function sns_StartRequest( linkUrl, handleFunc )
{
	sns_HandleFunction				= handleFunc;
	sns_Request.open("GET", linkUrl , true);
	sns_Request.onreadystatechange	= sns_HandleStateChange;
	sns_Request.send(null);
}


// AJAX handler
function sns_HandleStateChange()
{
	if (sns_Request.readyState == 4)
	{
		if (sns_Request.status == 200)
		{
			sns_response				= sns_Request.responseText;
			eval(sns_HandleFunction +"()");
		}
	}
}


// 로그인 체크용 AJAX Return Check
function sns_login_ajax_return()
{
	if ( sns_response == '' )
	{
		sns_login_ajax_call();
		return;
	}

	if ( sns_site_each == '1' )
	{
		if ( sns_response == 'ok' )
		{
			sns_login_cancle_call();
			window.location.href = return_url;
		}
		else
		{
			alert('로그인에 실패 하였습니다.['+sns_response+'] 재시도를 해주세요.');
			sns_login_cancle_call();
			return;
		}
	}
	else
	{
		sns_response_arr		= sns_response.split("___cut___");

		//alert(sns_response_arr[0]);

		if ( sns_response == '' )
		{
			sns_login_ajax_call();
		}
		else if ( sns_response == "out_member" )
		{
			alert("해당 아이디로 가입이 불가능합니다.");
			sns_login_cancle_call();
		}
		else if ( sns_response_arr[0] == 'ok' )
		{
			try
			{
				document.getElementById('sns_login_div').innerHTML	= sns_response_arr[1];
				document.sns_auto_login.returnUrl.value				= return_url;
				document.sns_auto_login.submit();
			}
			catch (e)
			{
				alert('로그인에 실패 하였습니다. 재시도를 해주세요.');
				sns_login_cancle_call();
			}

		}
		else
		{
			alert('로그인에 실패 하였습니다. 재시도를 해주세요.');
			sns_login_cancle_call();
		}
	}
}



// 로그인 취소 요청
function sns_login_cancle_call()
{
	sns_ajax_cancle				= '1';
}



//SNS 로그인 개별연동 팝업창 호출 - hong
function happy_sns_login(sns_site,returnUrl)
{
	window.open('./sns_login/call.php?sns_site=' + sns_site, 'happy_sns_login_popup', 'titlebar=1, resizable=1, scrollbars=yes, width=400,height=500');

	var_sns_site				= sns_site;
	sns_site_each				= '1';

	if ( returnUrl != undefined && returnUrl != "" )
	{
		return_url				= returnUrl;
	}
	else
	{
		return_url				= window.location.href;
	}

	sns_login_ajax_start();
}