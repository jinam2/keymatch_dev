var request;
function createXMLHttpRequest()
{
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}
	else {
		request = new ActiveXObject("Microsoft.XMLHTTP");
	}
}

function startRequest(sel,target,size)
{
	var trigger = sel.options[sel.selectedIndex].value;
	var form = sel.form.name;
		createXMLHttpRequest();
	request.open("GET", "sub_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
	request.onreadystatechange = handleStateChange;
	request.send(null);
}

function startRequest2(sel,target,size)
{
	var trigger = sel.options[sel.selectedIndex].value;
	var form = sel.form.name;
		createXMLHttpRequest();
	request.open("GET", "sub_type_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
	request.onreadystatechange = handleStateChange;
	request.send(null);
}

function handleStateChange() {
	if (request.readyState == 4) {
		if (request.status == 200) {
			var response = request.responseText.split("---cut---");
			eval(response[0]+ '.innerHTML=response[1]');
			window.status="완료"
		}
	}
	if (request.readyState == 1)  {
		window.status="로딩중....."
	}
}

function searchbox(){

	for(i=1;i<=2;i++){
		if(document.getElementById(i).style.display == 'none'){
			document.getElementById(i).style.display='';
		}
		else{
			document.getElementById(i).style.display='none';
		}
	}

}