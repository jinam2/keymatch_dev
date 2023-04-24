// ajax
var request;
function createXMLHttpRequest()
{
	if (window.XMLHttpRequest) {
	request = new XMLHttpRequest();
	} else {
	request = new ActiveXObject("Microsoft.XMLHTTP");
	}
}

// 도로명 woo
function happy_startRequest_road(sel,sel2,target,target2,size,level,form_name)
{
	//alert(form_name);
	var trigger = sel.options[sel.selectedIndex].value;
	var form = form_name;
	createXMLHttpRequest();

	request.open("GET", "../ajax_sub_select_road.php?form=" + form + "&trigger=" + trigger +"&trigger2=" + sel2 + "&target=" + target + "&target2=" + target2 + "&level=" + level, true);
	request.onreadystatechange = handleStateChange_road;
	request.send(null);
}

function happy_startRequest_juso2road(sel,sel2,target,target2,size,level,form_name,addr,addr2)
{
	//var trigger	= sel.options[sel.selectedIndex].value;
	var form	= form_name;

	addr	= encodeURI(addr);
	addr2	= encodeURI(addr2);

	createXMLHttpRequest();
	request.open("GET", "../ajax_sub_select_road.php?form=" + form + "&trigger=" + sel +"&trigger2=" + sel2 + "&target=" + target + "&target2=" + target2 + "&level=" + level + '&addr=' + addr + '&addr2=' + addr2, true);
	request.onreadystatechange = handleStateChange_road;
	request.send(null);
}
// 도로명 woo

function handleStateChange_road()
{
	if (request.readyState == 4)
	{
		if (request.status == 200)
		{
			//alert(request.responseText);
			var response = request.responseText.split("---cut---");


			if(response[0])
			{
				response[0] = response[0].replace(/(^\s*)|(\s*$)/g,""); // 공백제거
				//alert(response[0]);
				//alert(response[1]);
				//alert(document.getElementsByName(response[0]).length);
				if ( document.getElementById(response[0]) != null )
				{
					document.getElementById(response[0]).innerHTML = response[1];
				}
			}

			/* 도로명주소레이어
			if (response[2])
			{
				response[2] = response[2].replace(/(^\s*)|(\s*$)/g,""); // 공백제거
				if ( document.getElementById(response[2]) != null )
				{
					document.getElementById(response[2]).innerHTML = response[3];
				}

			}
			*/

			if (response[4])
			{
				response[4] = response[4].replace(/(^\s*)|(\s*$)/g,""); // 공백제거
				if ( document.getElementById(response[4]) != null )
				{
					document.getElementById(response[4]).innerHTML = response[5];
				}
			}

			if (response[6])
			{
				response[6] = response[6].replace(/(^\s*)|(\s*$)/g,""); // 공백제거
				if ( document.getElementById(response[6]) != null )
				{
					document.getElementById(response[6]).innerHTML = response[7];
				}
			}

			window.status="전송완료"
		}
	}

	if (request.readyState == 1)
	{
		window.status="로딩중"
	}
}




//도로명을 이용하여 주소로 변경하기			hun
function Road_happy_member_address(form_name)
{
	var frm				= eval("document."+form_name);

	if(frm.road_si.selectedIndex == 0)
	{
		alert('시를 선택해주세요.');
		frm.road_si.focus();
		return false;
	}
	else if(frm.road_gu.selectedIndex == 0 && frm.road_si.options[frm.road_si.selectedIndex].text != '세종시')
	{
		alert('구를 선택해주세요.');
		frm.road_gu.focus();
		return false;
	}
	/*
	else if(frm.road_addr.selectedIndex == 0)
	{
		alert('도로명을 선택해주세요.');
		frm.road_addr.focus();
		return false;
	}
	else if(frm.road_addr2.value == '')
	{
		alert('건물번호본번과 건물번호부번을 입력해주세요..');
		frm.road_addr2.focus();
		return false;
	}
	*/

	var road_si_text		= frm.road_si.options[frm.road_si.selectedIndex].text;
	var road_addr_text		= frm.road_addr.options[frm.road_addr.selectedIndex].text;
	var geonmul1			= frm.road_addr2.value;


	if(road_si_text != '세종시')
	{
		var road_gu_text		= frm.road_gu.options[frm.road_gu.selectedIndex].text;
		var addr				= road_si_text+'|'+road_gu_text;
		var doro				= road_addr_text;


		if(frm.road_addr.selectedIndex == 0)
		{
			doro = "";
			geonmul1 = "";
		}
	}
	else			//세종시는 특수상황 ㅋ
	{
		var addr				= road_si_text+"|";
		var doro				= road_addr_text;
	}

	addr		= encodeURI(addr);
	doro		= encodeURI(doro);

	var ajax_addr			= new GLM.AJAX();
	ajax_addr.callPage(
		'../ajax_happy_address.php?addr='+addr+'&doro='+doro+'&geonmul1='+geonmul1,
		function(response)
		{
			//alert(response);
			ajax_receive_message	= response.split("___CUT___");

			if( ajax_receive_message[0] == 'SUCCESS' )
			{
				frm.user_zip.value		= ajax_receive_message[6];
				frm.user_addr1.value	= ajax_receive_message[1]+' '+ajax_receive_message[2]+' '+ajax_receive_message[3];

				frm.user_addr2.value	= ajax_receive_message[4];
				if(ajax_receive_message[5] != 0)
				{
					frm.user_addr2.value	= frm.user_addr2.value+'-'+ajax_receive_message[5];
				}
			}
			else if( ajax_receive_message[0] == 'LIMIT_ZERO' )
			{
				alert("일치하는 주소가 없습니다.");
			}
			else if( ajax_receive_message[0] == 'LIMIT_OVER' )
			{
				alert("정확한 건물번호본번과 건물번호부번을 입력해주세요.");
			}
		}
	);
}
//도로명을 이용하여 주소로 변경하기			hun








var sp_gu	= new Array(
	'포항시 남구',			// 경상북도
	'포항시 북구',

	'창원시 마산합포구',	// 경상남도
	'창원시 마산회원구',
	'창원시 성상구',
	'창원시 의창구',
	'창원시 진해구',

	'전주시 덕진구',		// 전라북도
	'전주시 완산구',

	'고양시 덕양구',		// 경기도
	'고양시 일산동구',
	'고양시 일산서구',
	'부천시 소사구',
	'부천시 오정구',
	'부천시 원미구',
	'성남시 분당구',
	'성남시 수정구',
	'성남시 중원구',
	'수원시 권선구',
	'수원시 영통구',
	'수원시 장안구',
	'수원시 팔달구',
	'안산시 단원구',
	'안산시 상록구',
	'안양시 동안구',
	'안양시 만안구',
	'용인시 기흥구',
	'용인시 수지구',
	'용인시 처인구',

	'천안시 동남구',		// 충청남도
	'천안시 서북구',

	'청주시 상당구',		// 충청북도
	'청주시 흥덕구',
	'청주시 청원구'
);


function Road_address(form_name)
{
	var frm		= eval("document."+form_name);
	// 도로명주소레이어
	//tmp			= frm.user_addr1.value.replace(/(^\s*)|(\s*$)/gi, "").replace(/(\s+)/g," ").split(' ');
	// 2014-06-23 패치
	tmp_addr1	= frm.user_addr1.value.replace(/(^\s*)|(\s*$)/gi, "").replace(/(\s+)/g," ")
	tmp			= tmp_addr1.split(' ');

	var road_address_Obj		= document.getElementById("road_address_layer");

	if(frm.user_addr1.value.substring(0,2) != '세종')
	{
		if(tmp.length < 3)
		{
			alert('주소를 올바르게 입력하세요.');
			if(road_address_Obj != undefined)
				road_address_Obj.style.display = 'none';
			return false;
		}
		else if(tmp.length == 3)
		{
			var user_addr2	= document.getElementsByName('user_addr2')[0];
			if(user_addr2 != undefined)
			{
				// 동까지 입력하면 번지수를 꼭 넣어야 한다.
				if(user_addr2.value == '')
				{
					alert('지번을 입력해주세요.');
					return false;
				}
			}
		}
		// 2014-06-23 패치
		else if( tmp.length == 4 && tmp_addr1.substring(tmp_addr1.length - 1, tmp_addr1.length) == '리' )
		{
			var user_addr2	= document.getElementsByName('user_addr2')[0];
			if(user_addr2 != undefined)
			{
				// 동까지 입력하면 번지수를 꼭 넣어야 한다.
				if(user_addr2.value == '')
				{
					alert('지번을 입력해주세요.');
					return false;
				}
			}
			tmp[3]	= '';
		}
	}
	else
	{
		if(tmp.length < 2)
		{
			alert('주소를 올바르게 입력하세요.');
			if(road_address_Obj != undefined)
				road_address_Obj.style.display = 'none';
			return false;
		}
		else if(tmp.length == 2 || tmp.length == 3)
		{
			var user_addr2	= document.getElementsByName('user_addr2')[0];
			if(user_addr2 != undefined)
			{
				// 동까지 입력하면 번지수를 꼭 넣어야 한다.
				if(user_addr2.value == '')
				{
					alert('지번을 입력해주세요.');
					return false;
				}
			}
		}
	}

	if(road_address_Obj != undefined)
	{
		if( road_address_Obj.style.display == 'none' )
		{
			road_address_Obj.style.display = "";
		}
	}

	var si			= encodeURI(tmp[0]);
	var gu			= encodeURI(tmp[1]);
	var dong		= encodeURI(tmp[2]);
	// 도로명주소레이어
	var geonmul		= '';
	if(tmp[3] != undefined)
		geonmul		= encodeURI(tmp[3]);
	var addr2		= encodeURI(frm.user_addr2.value);
	var user_zip	= frm.user_zip.value;

	var ajax_addr2			= new GLM.AJAX();

	// 도로명주소레이어
	if(document.getElementById('road_address_select') != undefined)
	{
		document.getElementById('road_address_select').innerHTML	= '도로명 주소 정보를 가져오고 있습니다.';
	}
	if(document.getElementById('road_addr2') != undefined)
	{
		document.getElementById('road_addr2').value	= '';
	}

	//1차 Ajax 자신의 DB에서 시 구 동에 해당하는 값을 가져오자.
	ajax_addr2.callPage(
		'../ajax_happy_road_address.php?form='+form_name+'&zip='+user_zip+'&si='+si+'&gu='+gu+'&dong='+dong+'&addr2='+addr2+'&zipcode='+frm.user_zip.value+'&geonmul='+geonmul,
		function(response)
		{
			// 도로명주소레이어
			if(response == '')
			{
				if(document.getElementById('road_address_select') != undefined)
				{
					document.getElementById('road_address_select').innerHTML	= '결과값이 없습니다.';
				}
			}
			//alert(response);
			ajax_receive_message	= response.split("---cut---");
			frm.road_si.value	= ajax_receive_message[0];			//시 선택해주기

			if(ajax_receive_message[1])
			{
				ajax_receive_message[1] = ajax_receive_message[1].replace(/(^\s*)|(\s*$)/g,""); // 공백제거
				if ( document.getElementById(ajax_receive_message[1]) != null )
				{
					document.getElementById(ajax_receive_message[1]).innerHTML = ajax_receive_message[2];
				}
			}

			if(ajax_receive_message[3])
			{
				ajax_receive_message[3] = ajax_receive_message[3].replace(/(^\s*)|(\s*$)/g,""); // 공백제거
				if ( document.getElementById(ajax_receive_message[3]) != null )
				{
					document.getElementById(ajax_receive_message[3]).innerHTML = ajax_receive_message[4];
				}
			}

			if(ajax_receive_message[5])
			{
				ajax_receive_message[5] = ajax_receive_message[5].replace(/(^\s*)|(\s*$)/g,""); // 공백제거
				if ( document.getElementById(ajax_receive_message[5]) != null )
				{
					document.getElementById(ajax_receive_message[5]).innerHTML = ajax_receive_message[6];
				}
			}
		}
	);
}


function in_array(needle, haystack, argStrict) {
  //  discuss at: http://phpjs.org/functions/in_array/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: vlado houba
  // improved by: Jonas Sciangula Street (Joni2Back)
  //    input by: Billy
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //   example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
  //   returns 1: true
  //   example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
  //   returns 2: false
  //   example 3: in_array(1, ['1', '2', '3']);
  //   example 3: in_array(1, ['1', '2', '3'], false);
  //   returns 3: true
  //   returns 3: true
  //   example 4: in_array(1, ['1', '2', '3'], true);
  //   returns 4: false

  var key = '',
    strict = !! argStrict;

  //we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] == ndl)
  //in just one for, in order to improve the performance 
  //deciding wich type of comparation will do before walk array
  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}
