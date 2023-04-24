/*		happycgi_module 을 layer 로 오픈하는 스크립트		*/
function editor_layer_open(editor_name,type,f_width,f_height,func)
{
	var temp = $('#layer_pop');
	var bg = temp.prev().hasClass('bg');

	temp.find('a.cbtn').click(function(e){
		if(bg){
			$('.editor_layer').fadeOut(1);
		}else{
			temp.fadeOut(1);
		}
		e.preventDefault();
	});

	$('.editor_layer .bg').click(function(e){
		$('.editor_layer').fadeOut(1);
		e.preventDefault();
	});

	//창크기가 레이어보다 작으면
	//alert($(document).height() + "==="+ f_height + ":::" + $(document).width() + "===" + f_width);
	if ( f_height >= $(document).height() )
	{
		f_height = ($(document).height()*0.95);
	}
	if ( f_width >= $(document).width() )
	{
		f_width = ($(document).width()*0.95);
	}
	//alert(f_width + "X" + f_height);

	$('#editor_layer_content_frame').height(f_height+'px');
	$('#editor_layer_content_frame').width(f_width+'px');

	prev_no		= '1';
	call_editor_tool(editor_name,type,func);


}

//이전에 설정한것 읽어내기
function editor_layer_open2(editor_name,type,f_width,f_height,func)
{
	var temp = $('#layer_pop');
	var bg = temp.prev().hasClass('bg');

	temp.find('a.cbtn').click(function(e){
		if(bg){
			$('.editor_layer').fadeOut(1);
		}else{
			temp.fadeOut(1);
		}
		e.preventDefault();
	});

	$('.editor_layer .bg').click(function(e){
		$('.editor_layer').fadeOut(1);
		e.preventDefault();
	});

	$('#editor_layer_content_frame').height(f_height+'px');
	$('#editor_layer_content_frame').width(f_width+'px');

	prev_no		= '1';

	//이전에 설정한것 읽어내기
	str = $("#"+editor_name).val();
	str2 = '';
	tmpVals = new Array();
	tmpVals2 = new Array();
	if ( str != "" )
	{
		//str = str.replace('<img src="/happy_imgmaker.php?','&');
		//str = str.replace('">','');

		tmpVals = str.split("?");
		if ( tmpVals[1] != undefined )
		{
			tmpVals[1] = tmpVals[1].replace('">','');
			//alert(tmpVals[1]);
			tmpVals2 = tmpVals[1].split("&");
			for ( i=0; i<tmpVals2.length ;i++ )
			{
				//alert(tmpVals2[i]);
				if ( tmpVals2[i].match("news_title") )
				{
					str2 += "&" + tmpVals2[i];
				}
				if ( tmpVals2[i].match("width") )
				{
					str2 += "&" + tmpVals2[i];
				}
				if ( tmpVals2[i].match("height") )
				{
					str2 += "&" + tmpVals2[i];
				}
				if ( tmpVals2[i].match("fsize") )
				{
					str2 += "&" + tmpVals2[i];
				}
				if ( tmpVals2[i].match("outfont") )
				{
					str2 += "&" + tmpVals2[i];
				}
				if ( tmpVals2[i].match("format") )
				{
					str2 += "&" + tmpVals2[i];
				}
				if ( tmpVals2[i].match("fcolor") )
				{
					str2 += "&" + tmpVals2[i];
				}
				if ( tmpVals2[i].match("bgcolor") )
				{
					str2 += "&" + tmpVals2[i];
				}
				if ( tmpVals2[i].match("quality") )
				{
					str2 += "&" + tmpVals2[i];
				}
			}
		}

		editor_name += str2;
	}
	//이전에 설정한것 읽어내기

	call_editor_tool(editor_name,type,func);
}


function editor_layer_close()
{
	//$('#editor_layer_content_frame').attr('src', '');
	//뒤로가기시 오류
	var iFrame = $('#editor_layer_content_frame');
	var iFrameParent = iFrame.parent();
	iFrame.remove();
	iFrame.attr('src', '');
	iFrameParent.append(iFrame);
	//뒤로가기시 오류
	
	$('.editor_layer').fadeOut(1);
}
/*		happycgi_module 을 layer 로 오픈하는 스크립트		*/


function editor_layer_resizeing()
{
	var temp = $('#layer_pop');
	var bg = temp.prev().hasClass('bg');

	var temp = $('#layer_pop');
	var bg = temp.prev().hasClass('bg');

	temp.find('a.cbtn').click(function(e){
		if(bg){
			$('.editor_layer').fadeOut(1);
		}else{
			temp.fadeOut(1);
		}
		e.preventDefault();
	});

	$('.editor_layer .bg').click(function(e){
		$('.editor_layer').fadeOut(1);
		e.preventDefault();
	});

	if(bg){
		$('.editor_layer').fadeIn(1);	//'bg' 클래스가 존재하면 레이어가 나타나고 배경은 dimmed 된다.
	}else{
		temp.fadeIn(1);
	}

	// 화면의 중앙에 레이어를 띄운다.
	if(temp.outerHeight() < $(document).height())
	{
		temp.css('margin-top', '-'+temp.outerHeight()/2+'px');
	}
	else
	{
		temp.css('top', '0px');
	}

	if(temp.outerWidth() < $(document).width())
	{
		temp.css('margin-left', '-'+temp.outerWidth()/2+'px');
	}
	else
	{
		temp.css('left', '0px');
	}
}


/*		happycgi_module 을 Ajax 로 호출하는 스크립트		*/
var editor_glm			= new GLM.AJAX();			//Ajax 객체선언
function call_editor_tool(editor_name,type,func)
{
	var temp = $('#layer_pop');
	var bg = temp.prev().hasClass('bg');

	if( type != 'image_upload' && type != 'multy_image_upload' && type != 'file_upload' && type != 'naver_map' && type != 'daum_map' && type != 'text_image' && type != 'youtube' && type != 'html5_image_upload' )
	{
		$('#editor_layer_content').html("<div style='width:300px;height:50px;padding-top:20px;padding-left:10px;'>"+ type +" Loading Failed.</div>");
		return false;
	}

	if ( type == 'multy_image_upload' )
	{
		var multy_image_upload_html		= $("#multy_image_upload_container").html();
		multy_image_upload_html			= multy_image_upload_html.replace(/%editor_name%/g,editor_name);

		$('#editor_layer_content_multy_image').html(multy_image_upload_html);
		
		$('#editor_layer_content_multy_image').show();
		$('#editor_layer_content_frame').hide();
	}
	else
	{
		//$('#editor_layer_content_frame').attr('src', EDITOR_BASE_PATH+'happy_module/'+type+'/'+type+'.php?editor_type='+EDITOR_TYPE+'&editor_name='+editor_name);
		//뒤로가기시 오류
		var iFrame = $('#editor_layer_content_frame');
		var iFrameParent = iFrame.parent();
		iFrame.remove();
		iFrame.attr('src', EDITOR_BASE_PATH+'happy_module/'+type+'/'+type+'.php?editor_type='+EDITOR_TYPE+'&editor_name='+editor_name);
		iFrameParent.append(iFrame);
		//뒤로가기시 오류
		
		$('#editor_layer_content_multy_image').hide();
		$('#editor_layer_content_frame').show();
	}

	if( type == 'naver_map' )
	{
		//alert('준비1중입니다.');
		//return false;

		//temp.css('width', '790px');
		//temp.css('height', '840px');
		//$('#editor_layer_content_frame').css('width', '750px');
		//$('#editor_layer_content_frame').css('height', '750px');
		editor_layer_resizeing();
	}
	else
	{
		editor_layer_resizeing();
	}
/*
	(function(){
		editor_glm.callPage(
			EDITOR_BASE_PATH+'happy_module/'+type+'/'+type+'.php?editor_type='+EDITOR_TYPE,
			function(response) {
				//alert(response);
				document.getElementById('editor_layer_content').innerHTML	= response;

				if( func != undefined && typeof func == 'function' )
				{
					func();
				}
				editor_layer_resizeing();
			}
		);
	}());
*/
}
/*		happycgi_module 을 Ajax 로 호출하는 스크립트		*/


/*		happycgi_module 에서 결과값을 에디터로 전송할때 사용되는 스크립트		*/
function ckeditor_insertcode(edtior_name,type,str)
{
	var editor = eval("CKEDITOR.instances."+edtior_name);
	if( type == 'text' )
	{
		editor.insertText(str);								//본문 에디터에 Text 추가하기.
	}
	else						//html 로 간주한다.
	{
		editor.insertHtml(str);								//본문 에디터에 html 추가하기
	}
}

function ckeditor_error_msg( str )
{
	alert(str);
}


/*		에디터의 본문을 선택한 값을 가져와서 태그 추가하는 함수		*/
function ckeditor_set_attribute(file_url,file_tag,editor_names)
{
	var editor				= eval("CKEDITOR.instances."+EDITOR_NAME);
	var selected_text		= editor.getSelection().getSelectedText();

	if( selected_text == '' )				//no selection
	{
		ckeditor_insertcode(editor_names,"html",file_tag);
	}
	else									//yes selection
	{
		var newElement			= new CKEDITOR.dom.element("a");              // Make Paragraff
		newElement.setAttributes({href: file_url})                 // Set Attributes
		newElement.setAttributes({target: '_blank'})                 // Set Attributes
		newElement.setText(selected_text);                           // Set text to element
		editor.insertElement(newElement);
	}
}
/*		에디터의 본문을 선택한 값을 가져와서 태그 추가하는 함수		*/


/*		Ajax submit 시키는 스크립트			*/
/*
function ajax_upload_submit()
{
	$('#editor_upload_form').ajaxForm({
		beforeSend: function() {													//SUBMIT 하기전 검사할 구문을 넣으세요.
			return true;
		},
		complete: function(xhr) {													//전송완료시 넣으세요.
			//alert(xhr.responseText);
			result_code		= xhr.responseText.split("___CUT___");

			if( result_code[0] == 'SUCCESS' )			//파일업로드가 정상적으로 된 경우
			{
				ckeditor_insertcode('html',result_code[1]);
				editor_layer_close();
			}
			else
			{
				if( result_code[1] == 'ERROR_CODE_ALERT' )				//오류내용 뛰우기
				{
					alert(result_code[2]);
				}
				else													//알수 없는 오류 디버깅이 필요함.
				{
					alert(" Error CGimall 에 문의하여 정검 받으시기 바랍니다.");
				}
				return false;
			}
		}

	  });
	$('#editor_upload_form').submit();
}
*/
/*		Ajax submit 시키는 스크립트			*/


/*		naver map 관련 스크립트		*/
function naver_map_start()
{
	naver_map_loading_v2();
	naver_search_loading();
	//마커 함수도 호출해야 한다.
}

function naver_search_loading()
{
	//alert(document.getElementById("naver_search").value);
	document.navermap_search_form.keyword.value		= document.getElementById("naver_search").value;
	document.navermap_search_form.submit();
}


var CK_oMap			= null;
var oTrafficGuide	= null;
var oMarker			= null;
var oLabel			= null;
function naver_map_loading_v2()
{
	nDate					= new Date();

	nowYear					= nDate.getFullYear();
	nowMonth				= nDate.getMonth();
	nowDate					= nDate.getDate();
	nowMin					= nDate.getMinutes();
	nowSec					= nDate.getSeconds();

	nowTimeChk				= nowYear +""+ nowMonth +""+ nowDate +""+ nowMin +""+ nowSec;

	outContent				= "";
	naver_map_default_width	= document.getElementById('naver_map_default_width').value;
	naver_map_default_height= document.getElementById('naver_map_default_height').value;
	naver_map_default_zoom	= document.getElementById('naver_map_default_zoom').value;
	naver_map_enableWheelZoom= (document.getElementById('naver_map_enableWheelZoom').value == 'true')?true:false;
	naver_map_enableDragPan	= (document.getElementById('naver_map_enableDragPan').value == 'true')?true:false;
	naver_map_enableDblClickZoom= (document.getElementById('naver_map_enableDblClickZoom').value == 'true')?true:false;
	naver_map_default_mapMode= document.getElementById('naver_map_default_mapMode').value;
	naver_map_default_activateTrafficMap= (document.getElementById('naver_map_default_activateTrafficMap').value == 'true')?true:false;
	naver_map_default_activateBicycleMap= (document.getElementById('naver_map_default_activateBicycleMap').value == 'true')?true:false;
	naver_map_default_minLevel= document.getElementById('naver_map_default_minLevel').value;
	naver_map_default_MaxLevel= document.getElementById('naver_map_default_MaxLevel').value;

	naver_map_BicycleGuide_use= (document.getElementById('naver_map_BicycleGuide_use').value == 'true')?true:false;
	naver_map_TrafficGuide_use= (document.getElementById('naver_map_TrafficGuide_use').value == 'true')?true:false;
	naver_map_ZoomControl_use= (document.getElementById('naver_map_ZoomControl_use').value == 'true')?true:false;


	outContent			+= "<div id='mapContainer_"+nowTimeChk+"' style='width:"+naver_map_default_width+"px;height:"+naver_map_default_height+"px'></div";
	document.getElementById('happymap_Container').innerHTML		= outContent;

	//alert('zoom : '+naver_map_default_zoom+',\n enableWheelZoom :'+naver_map_enableWheelZoom+', \n enableDragPan : '+naver_map_enableDragPan+', \n enableDblClickZoom : '+naver_map_enableDblClickZoom+', \n mapMode : '+naver_map_default_mapMode+', \n activateTrafficMap :'+naver_map_default_activateTrafficMap+', \n activateBicycleMap : '+naver_map_default_activateBicycleMap+', \n minMaxLevel : [ '+naver_map_default_minLevel+', '+naver_map_default_MaxLevel+' ]');



	var oPoint			= new nhn.api.map.LatLng(37.5010226, 127.0396037);
	nhn.api.map.setDefaultPoint('LatLng');
	CK_oMap				= new nhn.api.map.Map('mapContainer_'+nowTimeChk ,{
							point : oPoint,
							zoom : naver_map_default_zoom,
							enableWheelZoom : naver_map_enableWheelZoom,
							enableDragPan : naver_map_enableDragPan,
							enableDblClickZoom : naver_map_enableDblClickZoom,
							mapMode : naver_map_default_mapMode,
							activateTrafficMap : naver_map_default_activateTrafficMap,
							activateBicycleMap : naver_map_default_activateBicycleMap,
							minMaxLevel : [ naver_map_default_minLevel, naver_map_default_MaxLevel ],
							size : new nhn.api.map.Size(naver_map_default_width, naver_map_default_height),
							detectCoveredMarker : true
						});

	mapTypeChangeButton = new nhn.api.map.MapTypeBtn();			// - 지도 타입 버튼 선언
	mapTypeChangeButton.setPosition({bottom : 25, right:10});	// - 지도 타입 버튼 위치 지정
	CK_oMap.addControl(mapTypeChangeButton);

	trafficButton = new nhn.api.map.TrafficMapBtn();			// - 실시간 교통지도 버튼 선언
	trafficButton.setPosition({top:10, right:80});				// - 실시간 교통지도 버튼 위치 지정
	CK_oMap.addControl(trafficButton);

	themeMapButton = new nhn.api.map.ThemeMapBtn();				// - 자전거지도 버튼 선언
	themeMapButton.setPosition({top:10, right:10});				// - 자전거지도 버튼 위치 지정
	CK_oMap.addControl(themeMapButton);

	if(naver_map_BicycleGuide_use == true)
	{
		var oBicycleGuide = new nhn.api.map.BicycleGuide();		// - 자전거 범례 선언
		oBicycleGuide.setPosition({top : 10,right : 150});		// - 자전거 범례 위치 지정
		CK_oMap.addControl(oBicycleGuide);							// - 자전거 범례를 지도에 추가.
	}

	if(naver_map_TrafficGuide_use == true)
	{
		var oTrafficGuide = new nhn.api.map.TrafficGuide();		// - 교통 범례 선언
		oTrafficGuide.setPosition({bottom : 25,left : 10});		// - 교통 범례 위치 지정.
		CK_oMap.addControl(oTrafficGuide);							// - 교통 범례를 지도에 추가.
	}

	if(naver_map_ZoomControl_use == true)
	{
		var oSlider = new nhn.api.map.ZoomControl();
		CK_oMap.addControl(oSlider);
		oSlider.setPosition({top : 10,left : 10});
	}

	/*	마커관련 객체들 기본적으로 선언되어 있어야함 */
	var markerCount = 0;
	var oSize = new nhn.api.map.Size(28, 37);
	var oOffset = new nhn.api.map.Size(14, 37);
	var oIcon = new nhn.api.map.Icon('http://static.naver.com/maps2/icons/pin_spot2.png', oSize, oOffset);

	oLabel = new nhn.api.map.MarkerLabel();					// - 마커 라벨 선언.
	CK_oMap.addOverlay(oLabel);									// - 마커 라벨 지도에 추가. 기본은 라벨이 보이지 않는 상태로 추가됨.
	/*	마커관련 객체들 기본적으로 선언되어 있어야함 */

	CK_oMap.attach('mouseenter', function(oCustomEvent) {
		var oTarget = oCustomEvent.target;
		// 마커위에 마우스 올라간거면
		if (oTarget instanceof nhn.api.map.Marker) {
				var oMarker = oTarget;
				oLabel.setVisible(true, oMarker); // - 특정 마커를 지정하여 해당 마커의 title을 보여준다.
		}
	});

	CK_oMap.attach('mouseleave', function(oCustomEvent) {
			var oTarget = oCustomEvent.target;
			// 마커위에서 마우스 나간거면
			if (oTarget instanceof nhn.api.map.Marker) {
					oLabel.setVisible(false);
			}
	});

	CK_oMap.attach('click', function(oCustomEvent) {

		var oPoint = oCustomEvent.point;
		var oTarget = oCustomEvent.target;

		// 마커 클릭하면
		if (oTarget instanceof nhn.api.map.Marker) {
			if ( confirm('마커를 제거하시겠습니까?') )
			{
				removeMark(oCustomEvent)
			}
			// 겹침 마커 클릭한거면
			if (oCustomEvent.clickCoveredMarker) {
					return;
			}
			return;
		}

		if( markAddCheck == false )
		{

			return;
		}
		mark_message			= document.getElementById('markMessage').value;

		mark_positon_arr[markerCount]		= oPoint;
		mark_title_arr[mark_message]		= oPoint;
		mark_icon_arr[mark_message]			= mark_img_url;


		markAddCheck		= false;
		oIcon = new nhn.api.map.Icon(mark_img_url, oSize, oOffset);
		var oMarker = new nhn.api.map.Marker(oIcon, { title : mark_message });
		oMarker.setPoint(oPoint);
		CK_oMap.addOverlay(oMarker);

		document.getElementById('markMessage').value		= "";

		if( mark_message != '' )
		{
			oLabel.setVisible(true, oMarker); // - 특정 마커를 지정하여 해당 마커의 title을 보여준다.
		}
		markerCount++;
		document.getElementById('naver_search').value		= mark_positon_arr;
	});
}



var markerCount			= 0;
var mark_img_url		= null;
var markAddCheck		= false;
var mark_positon_arr	= new Array();
var mark_title_arr		= new Array();
var mark_icon_arr		= new Array();


var markadd_count		= 0;
function addMark( markUrl )
{
	if (!markAddCheck)
	{
		mark_img_url	= markUrl;
		markAddCheck  = true;
	}
}

function removeMark(oCustomEvent)
{
	CK_oMap.removeOverlay(oCustomEvent.target);
	oLabel.setVisible(false,oCustomEvent.target); // - 특정 마커를 지정하여 해당 마커의 title을 보여준다.
}

function removeMarkAll()
{
	if ( confirm('모든 마커를 제거하시겠습니까?') )
	{
		CK_oMap.clearOverlay();
	}
}

function navermap_marker_add( no, mark_message, xpoint, ypoint )
{
	//현재 마킹된 코드들이 있는지 검수하자.
	//CK_oMap.clearOverlay();																		//일단 오버레이 초기화
	var mark_img_url			= "./editor/happy_module/naver_map/images/pos_"+no+".png";
	var oSize					= new nhn.api.map.Size(28, 37);
	var oOffset					= new nhn.api.map.Size(14, 37);
	var oIcon					= new nhn.api.map.Icon(mark_img_url, oSize, oOffset);
	var oMarker					= new nhn.api.map.Marker(oIcon, { title : mark_message });

	oPoint = new nhn.api.map.TM128(xpoint, ypoint).toLatLng();
	oMarker.setPoint(oPoint);
	CK_oMap.addOverlay(oMarker);

	//setBound 를 사용해라. 그래서 한번에 축적과 지도의 레벨을 정리 할 수 있다.

	//alert(xpoint);
	CK_oMap.setCenterAndLevel(oMarker.getPoint(),CK_oMap.getLevel());

	if( mark_message != '' )
	{
		oLabel.setVisible(true, oMarker); // - 특정 마커를 지정하여 해당 마커의 title을 보여준다.
	}
}