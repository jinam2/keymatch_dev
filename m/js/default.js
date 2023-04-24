//메인 인재정보 탭메뉴 자바스트립트
function showHideLayer_main01 (num){
		var tabMenuSrc			= new Array("tabMenu1","tabMenu2","tabMenu3");
		var tabMenuContSrc		= new Array("sample_1","sample_2","sample_3");

		var tabMenuButton		= new Array ();
		var tabMenuContLayer	= new Array ();

		for (var z=0; z < tabMenuSrc.length; z++ )
		{
			tabMenuButton.push (document.getElementById(tabMenuSrc[z]));
			tabMenuContLayer.push (document.getElementById(tabMenuContSrc[z]));
		}

		for (var i=0; i<tabMenuButton.length ; i++ )
		{
			if ( i != num)
			{
				tabMenuButton[i].className = "noSelectBox";
				tabMenuContLayer[i].style.display = "none";
			}
			else
			{
				tabMenuButton[num].className = "selectBox"
				tabMenuContLayer[i].style.display = "inline";
			}
		}
	}


//메인 커뮤니티 탭메뉴 자바스트립트
function showHideLayer_main02 (num){
		var tabMenuSrc			= new Array("tabMenu4","tabMenu5","tabMenu6");
		var tabMenuContSrc		= new Array("sample_4","sample_5","sample_6");

		var tabMenuButton		= new Array ();
		var tabMenuContLayer	= new Array ();

		for (var z=0; z < tabMenuSrc.length; z++ )
		{
			tabMenuButton.push (document.getElementById(tabMenuSrc[z]));
			tabMenuContLayer.push (document.getElementById(tabMenuContSrc[z]));
		}

		for (var i=0; i<tabMenuButton.length ; i++ )
		{
			if ( i != num)
			{
				tabMenuButton[i].className = "noSelectBox";
				tabMenuContLayer[i].style.display = "none";
			}
			else
			{
				tabMenuButton[num].className = "selectBox"
				tabMenuContLayer[i].style.display = "inline";
			}
		}
	}



	//메인 커뮤니티 탭메뉴 자바스트립트
function showHideLayer_main03 (num){
		var tabMenuSrc			= new Array("tabMenu4","tabMenu5");
		var tabMenuContSrc		= new Array("sample_4","sample_5");

		var tabMenuButton		= new Array ();
		var tabMenuContLayer	= new Array ();

		for (var z=0; z < tabMenuSrc.length; z++ )
		{
			tabMenuButton.push (document.getElementById(tabMenuSrc[z]));
			tabMenuContLayer.push (document.getElementById(tabMenuContSrc[z]));
		}

		for (var i=0; i<tabMenuButton.length ; i++ )
		{
			if ( i != num)
			{
				tabMenuButton[i].className = "noSelectBox";
				tabMenuContLayer[i].style.display = "none";
			}
			else
			{
				tabMenuButton[num].className = "selectBox"
				tabMenuContLayer[i].style.display = "inline";
			}
		}
	}


// 탭메뉴 사용되는 카운트(클래스형)
TabCount_class = 10;
FirstViewNumArr_class = new Array();
for ( i = 1; i <= TabCount_class; i++ )
{
	FirstViewNumArr_class['TabCount' + i] = 1;
}

function TabChange_class( idName, imgIdName, number, TabNumber )
{
	FirstViewNum  = FirstViewNumArr_class['TabCount' + TabNumber];

	Obj = document.getElementById(idName + number);
	ImgObj = document.getElementById(imgIdName + number);

	if ( FirstViewNum != '' )
	{
		document.getElementById(idName + FirstViewNum).style.display = 'none';
		document.getElementById(imgIdName + FirstViewNum).className = 'tab_off' + TabNumber;
	}

	Obj.style.display = '';
	ImgObj.className = 'tab_on' + TabNumber;
	if ( number != FirstViewNum )
	{
		FirstViewNumArr_class['TabCount' + TabNumber] = number;
	}
}
// 탭메뉴 사용되는 카운트(클래스형)


// 내주변정보 레이어
function startPopup( Obj_Name )
{
	Obj = document.getElementById(Obj_Name);

	if ( Obj.style.display == "none" )
	{
		Obj.style.display = "";
	}
	else
	{
		Obj.style.display = "none";
	}
}


//정확한 현재위치를 전송받기 위한 옵션
var geo_options = {
	enableHighAccuracy	: true,
	maximumAge			: 1000,
	timeout				: 3000
};

var global_item		= '';
var global_add_link	= '';
var global_metor	= '';
//채용이냐 이력서냐
var global_opt1		= '';
function getMemoolList(item, search_metor, keyword, is_map, opt1 )
{
	if ( search_metor == undefined )
	{
		search_metor		= '5000';
	}

	allCookies			= HappyAllCookieGet();
	global_item			= item;
	global_metor		= search_metor;
	global_opt1			= opt1;



	if ( keyword != undefined || is_map != undefined )
	{
		global_add_link		= "&search_word="+keyword+"&is_map="+is_map;
	}


	happy_x_point		= allCookies['happy_x_point'];
	happy_y_point		= allCookies['happy_y_point'];

	if ( happy_x_point == "" || happy_y_point == "" || happy_x_point == undefined || happy_y_point == undefined || happy_x_point == "undefined" || happy_y_point == "undefined" )
	{
		try
		{
			navigator.geolocation.getCurrentPosition(
														map_location_go,
														errorHandler,
														geo_options
			);
		}
		catch(e)
		{
			if ( demo_lock )
			{
				alert("위치전송이 실패 했습니다.\n\n특정 브라우저에서 위치전송 기능이 https에서만 구동이 되므로\n솔루션 구매 이후 보안서버 설치를 통해 정상 이용이 가능합니다.");
			}
			else
			{
				alert('위치전송이 불가능한 시스템이거나, 현재 전송이 안되는 상태입니다.');
			}
			var position				= Array();
			position.coords				= Array();
			position.coords.latitude	= '';
			position.coords.longitude	= '';

			map_location_go(position);
		}
	}
	else
	{
		var position				= Array();
		position.coords				= Array();
		position.coords.latitude	= happy_x_point;
		position.coords.longitude	= happy_y_point;

		map_location_go(position);
	}

}


function map_location_go(position)
{
	happy_location_cookie_set( position.coords.latitude, position.coords.longitude, 1 );

	if ( global_opt1 == "" )
	{
		file_name = "happy_map.php";
	}
	else
	{
		file_name = "happy_map_guzic.php";
	}

	location.href			= file_name+"?search_metor="+global_metor+"&happy_x=" + position.coords.latitude + "&happy_y=" + position.coords.longitude + "&search_category=" + global_item + global_add_link;

}


function happy_location_cookie_set( xPoint, yPoint , cMin )
{
	HappySetCookie('happy_x_point', xPoint, cMin);
	HappySetCookie('happy_y_point', yPoint, cMin);
}


function happy_location_false()
{
	if ( global_opt1 == "" )
	{
		file_name = "happy_map.php";
	}
	else
	{
		file_name = "happy_map_guzic.php";
	}

	//location.href			= file_name+"?search_metor="+global_metor+"&happy_x=&happy_y=&search_category=" + global_item + global_add_link;
}


function errorHandler(error)
{
	if ( demo_lock )
	{
		msg = "위치전송이 실패 했습니다.\n\n특정 브라우저에서 위치전송 기능이 https에서만 구동이 되므로\n솔루션 구매 이후 보안서버 설치를 통해 정상 이용이 가능합니다.";
		alert(msg);
		return;
	}

	if (error.code == 0)
	{
		alert("알 수없는 오류가 발생했습니다.");
	}
	else if (error.code == 1)
	{
		alert("GPS 전송요청이 거부 되었습니다.");
	}
	else if (error.code == 2)
	{
		alert("실내에 있거나 네트워크 사정, 또는 위치 설정으로 인해 현재 위치를 찾을 수 없습니다.");
	}
	else if (error.code == 3)
	{
		alert("GPS 전송요청에 반응이 없습니다.");
	}
	else
	{
		alert("알 수없는 오류가 발생했습니다.");
	}
	happy_location_false();
}

function errorHandler_slient(error)
{
	//console.log(error);
}


//#######################################################################################


function happy_map_location_reflash_onload()
{

	if ( happy_map_mapObj == null || happy_map_mapObj == undefined )
	{
		alert('지도 Object가 활성화 되지 않은 상태 입니다.');
		return false;
	}
	else
	{
		try
		{
			navigator.geolocation.getCurrentPosition(
														happy_map_location_change,
														errorHandler_slient,
														geo_options
			);
		}
		catch(e)
		{
			alert('위치전송이 불가능한 시스템이거나, 현재 전송이 안되는 상태입니다.');
		}
	}
}

function happy_map_location_reflash()
{

	if ( happy_map_mapObj == null || happy_map_mapObj == undefined )
	{
		alert('지도 Object가 활성화 되지 않은 상태 입니다.');
		return false;
	}
	else
	{
		try
		{
			navigator.geolocation.getCurrentPosition(
														happy_map_location_change,
														errorHandler,
														geo_options
			);
		}
		catch(e)
		{
			alert('위치전송이 불가능한 시스템이거나, 현재 전송이 안되는 상태입니다.');
		}
	}
}


function happy_map_location_change(position)
{
	// 35.844005585 , 128.572814941 대구
	//alert(position.coords.latitude +" , "+ position.coords.longitude);

	happy_location_cookie_set( position.coords.latitude, position.coords.longitude, 1 );

	happy_map_my_point_x		= position.coords.latitude;
	happy_map_my_point_y		= position.coords.longitude;
	happy_map_default_x			= happy_map_my_point_x;
	happy_map_default_y			= happy_map_my_point_y;


	happy_map_my_point_center();							// 센터로 이동
	happy_map_markRemoveAll();								// 기존 마크 제거


	// 현재 나의 위치 물방울
	try
	{
		me_marker.setVisible(false);
		me_marker				= new google.maps.Marker(
																{
																	position: new google.maps.LatLng(happy_map_my_point_x, happy_map_my_point_y),
																	draggable : false,
																	map: happy_map_mapObj,
																	icon : happy_map_iconUrl
																}
		);

		me_marker.setPosition(new google.maps.LatLng(happy_map_my_point_x, happy_map_my_point_y));
		me_marker.setVisible(true);
		//console.log('구글지도다');
	}
	catch (e)
	{
		happy_map_my_point_view();
		//console.log('네이버지도다');
	}


	//happy_map_mapObj.setZoom(happy_map_default_zoom);		// 기본줌으로 변경
	if ( document.getElementById('happy_map_type').checked != true )
	{
		now_location_change_check	= 'ok';
		happy_map_loading_success	= '';
		happy_map_start				= '';						// 이 변수 초기화를 해줘야 거리를 계산해서 지도 축척이 자동으로 변경이 됨
		happy_map_start_chk			= '';						// 이 변수 초기화를 해줘야 거리를 계산해서 지도 축척이 자동으로 변경이 됨
	}
	setTimeout("happy_map_my_point_change_end()", 1000);	// AJAX 매물 리스트 갱신

}




//#######################################################################################


function HappySetCookie(cKey, cValue, cMin)  // name,pwd,min
{
	date					= new Date(); // 오늘 날짜

	// 분단위로 설정
	position_delay_time		= cMin;	// 1분단위
	validity				= eval(position_delay_time);
	date.setMinutes(date.getMinutes() + validity);


	document.cookie			= cKey + '=' + escape(cValue) + ';expires=' + date.toGMTString();
	//alert(cKey+" 쿠키 생성 완료!!! ");
}

function HappyDelCookie(cKey)
{
	// 동일한 키(name)값으로
	// 1. 만료날짜 과거로 쿠키저장
	// 2. 만료날짜 설정 않는다.
	// 브라우저가 닫힐 때 제명이 된다

	var date				= new Date(); // 오늘 날짜
	var validity			= -1;
	date.setDate(date.getDate() + validity);
	document.cookie			= cKey + "=;expires=" + date.toGMTString();
}

function HappyGetCookie(cKey)
{
	var allcookies			= document.cookie;
	var cookies				= allcookies.split("; ");
	for (var i = 0; i < cookies.length; i++)
	{
		var keyValues			= cookies[i].split("=");
		if (keyValues[0] == cKey)
		{
			return unescape(keyValues[1]);
		}
	}

	return "";
}



function HappyAllCookieGet()
{
	var allCookieArray		= new Array();

	var allcookies			= document.cookie;
	var cookies				= allcookies.split("; ");
	for (var i = 0; i < cookies.length; i++)
	{
		var keyValues					= cookies[i].split("=");
		allCookieArray[keyValues[0]]	= keyValues[1];

	}

	//alert(allCookieArray[3]);

	return allCookieArray;

}

function addLoadEvent(func)
{
	var oldonload = window.onload;

	if ( typeof window.onload != 'function' )
	{
		window.onload = func;
	}
	else
	{
		window.onload = function()
		{
			oldonload();
			func();
		}
	}
}

// 탭메뉴 자바스크립트
happy_tab_menu_now  = new Array();
function happy_tab_menu(layer, nowNumber)
{
	if ( happy_tab_menu_now[layer] == undefined )
	{
		happy_tab_menu_now[layer]	= 1;
	}

	if ( happy_tab_menu_now[layer] == nowNumber )
	{
		return false;
	}

	var obj						= document.getElementById(layer+'_'+ nowNumber);
	var obj_layer				= document.getElementById(layer+'_layer_'+ nowNumber);
	var obj_old					= document.getElementById(layer+'_'+ happy_tab_menu_now[layer]);
	var obj_old_layer			= document.getElementById(layer+'_layer_'+ happy_tab_menu_now[layer]);

	if ( obj.getAttribute("oversrc") != undefined && obj.getAttribute("outsrc") != undefined && obj.src != undefined && obj_old.src != undefined )
	{
		obj.src						= obj.getAttribute("oversrc");
		obj_old.src					= obj_old.getAttribute("outsrc");
	}
	else if ( obj.getAttribute("overClass") != undefined && obj.getAttribute("outClass") != undefined && obj.className != undefined && obj_old.className != undefined )
	{
		obj.className				= obj.getAttribute("overClass");
		obj_old.className			= obj_old.getAttribute("outClass");
	}
	else
	{
		obj_layer.innerHTML			= obj_layer.innerHTML + '<br><font color=red>happy_tab_menu() 함수 구동 오류</font>';
	}


	obj_layer.style.display		= '';
	obj_old_layer.style.display	= 'none';

	happy_tab_menu_now[layer]	= nowNumber;
}
// 탭메뉴 자바스크립트


//간단 레이어 열고 닫기소스
function view_layer( layer_id )
{
	Obj						= document.getElementById(layer_id);
	Obj.style.display		= Obj.style.display == ''? 'none' : '';
}
//간단 레이어 열고 닫기소스

//메인 rows 마우스오버 소스
function view_layer_rotate( layer_id , rotate_obj )
{
	Obj						= document.getElementById(layer_id);

	if ( Obj.style.display == '' )
	{
		Obj.style.display		= 'none';

		if ( rotate_obj )
		{
			$(rotate_obj).removeClass('uk-open');
		}
	}
	else
	{
		Obj.style.display		= '';

		if ( rotate_obj )
		{
			$(rotate_obj).addClass('uk-open');
		}
	}
}

//카테고별 메뉴 자바스트립트
function category_change(name1 , name2, name3, num, mode)
{
	//name1 = "room2_text_1"
	//name2 = "category1_on"
	//name3 = "category1_off"

	document.getElementById(name1).style.display = "block";
	document.getElementById(name1).style.display = "none";

	if ( mode == "off" )
	{
		document.getElementById(name2).style.display	= "block";
		document.getElementById(name3).style.display	= "none";
	}
	else
	{
		document.getElementById(name2).style.display	= "none";
		document.getElementById(name3).style.display	= "block";

		document.getElementById(name1).style.display = "block";
	}
}
//카테고별 메뉴 자바스트립트

function change_text(num)
{
	for ( i=1 ; i<3 ; i++ )
	{
		disp = i == num ? '' : 'none';
		document.getElementById('room_text_'+i).style.display = disp;
	}
}