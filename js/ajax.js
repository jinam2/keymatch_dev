// happyStartRequest(아작스링크주소 , 호출후에 반환값을 받을 함수명)
// 예제) happyStartRequest('area.php?mode=get&si=3' , 'area_select')
	var happyRequest;
	var happyHandleFunction	= '';

	if (window.XMLHttpRequest) {
	happyRequest = new XMLHttpRequest();
	} else {
	happyRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}


	function happyStartRequest( linkUrl, handleFunc )
	{
		if (window.XMLHttpRequest) {
			happyRequest = new XMLHttpRequest();
		} else {
			happyRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}

		happyHandleFunction	= handleFunc;
		happyRequest.open("GET", linkUrl , true);
		happyRequest.onreadystatechange = happyHandleStateChange;
		happyRequest.send(null);
	}


	function happyHandleStateChange()
	{
		if (happyRequest.readyState == 4)
		{
			if (happyRequest.status == 200)
			{
				response = happyRequest.responseText;
				window.status="전송완료"
				eval(happyHandleFunction +"(\""+ response +"\")");
			}
		}
		if (happyRequest.readyState == 1)  {
			window.status="로딩중"
		}
	}