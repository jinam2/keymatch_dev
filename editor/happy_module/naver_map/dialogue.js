// 해피CGI 솔루션외 사용을 금합니다.
	naverMaps_Key			= naver_key;								// 네이버 client id
	naverMaps_Secret_Key	= naver_secret_key;							// 네이버 secret 값
	naverMaps_Zoom			= '10';										// 시작할때 줌 배율 1~14 숫자가 높을수록 확대된 지도
	naverMaps_CenterLat		= '304945';									// 시작 좌표
	naverMaps_CenterLon		= '550418';									// 시작 좌표
	naverMaps_Width			= '400';									// 시작할때 가로 크기
	naverMaps_Height		= '400';									// 시작할때 세로 크기

	// 시작할때 상호 검색 배열 (random 지정됨)	// 2009.04.09 kwak16
	naverMaps_StartSearch		= Array('해피CGI','관광','해수욕장');
	// 사용하길 원치 않을경우 위 구문 주석처리후 아래 주석을 풀것.
	//naverMaps_StartSearch		= Array();

	// 창크기 지정 // 2009.04.09 kwak16
	naverMaps_Tool_Width		= 650;									// 시작시 가로 창 크기
	naverMaps_Tool_Height		= 650;									// 시작시 세로 창 크기

	// naver map mark setting	// 2009.04.06 kwak16
	// 아이콘 변경/추가/삭제시 기존 파일은 그냥 두시는것을 권장합니다. ( 기존에 사용하던 마크들의 이미지 깨짐 방지 )
	naverMaps_Mark_Name		= Array();
	naverMaps_Mark_Width		= Array();
	naverMaps_Mark_Height		= Array();

	naverMaps_Mark_Name[0]	= "images/mark_ico01.png";					// 마커 URL ( editor/plugins/navermaps/ 기준)
	naverMaps_Mark_Width[0]	= "24";										// 마커 이미지 가로 크기
	naverMaps_Mark_Height[0]	= "24";									// 마커 이미지 세로 크기

	naverMaps_Mark_Name[1]	= "images/mark_ico02.png";
	naverMaps_Mark_Width[1]	= "24";
	naverMaps_Mark_Height[1]	= "24";

	naverMaps_Mark_Name[2]	= "images/mark_ico03.png";
	naverMaps_Mark_Width[2]	= "24";
	naverMaps_Mark_Height[2]	= "24";

	naverMaps_Mark_Name[3]	= "images/mark_ico04.png";
	naverMaps_Mark_Width[3]	= "24";
	naverMaps_Mark_Height[3]	= "24";

	naverMaps_Mark_Name[4]	= "images/mark_ico05.png";
	naverMaps_Mark_Width[4]	= "24";
	naverMaps_Mark_Height[4]	= "24";

	naverMaps_Mark_Name[5]	= "images/mark_ico06.png";
	naverMaps_Mark_Width[5]	= "24";
	naverMaps_Mark_Height[5]	= "24";

	naverMaps_Mark_Name[6]	= "images/mark_ico07.png";
	naverMaps_Mark_Width[6]	= "24";
	naverMaps_Mark_Height[6]	= "24";

	naverMaps_Mark_Name[7]	= "images/mark_ico08.png";
	naverMaps_Mark_Width[7]	= "24";
	naverMaps_Mark_Height[7]	= "24";

	naverMaps_Mark_Name[8]	= "images/mark_ico09.png";
	naverMaps_Mark_Width[8]	= "24";
	naverMaps_Mark_Height[8]	= "24";

	naverMaps_Mark_Name[9]	= "images/mark_ico10.png";
	naverMaps_Mark_Width[9]	= "24";
	naverMaps_Mark_Height[9]	= "24";

	naverMaps_Mark_Name[10]	= "images/mark_ico_def.png";
	naverMaps_Mark_Width[10]	= "24";
	naverMaps_Mark_Height[10]	= "24";

	nDate	= new Date();

	nowYear		= nDate.getFullYear();
	nowMonth	= nDate.getMonth();
	nowDate		= nDate.getDate();
	nowMin		= nDate.getMinutes();
	nowSec		= nDate.getSeconds();

	nowTimeChk	= nowYear +""+ nowMonth +""+ nowDate +""+ nowMin +""+ nowSec;


	function Ok()
	{
		point					= mapObj.getCenter();
		getZoom_info			= mapObj.getZoom();

		//alert(document.getElementById('mapContainer_'+nowTimeChk).innerHTML);


		outContent	= '';
		//alert(document.getElementById("mapContainer_"+nowTimeChk).style.width);
		//return false;

		mapWidth	= document.getElementById("mapContainer_"+nowTimeChk).style.width;
		mapHeight	= document.getElementById("mapContainer_"+nowTimeChk).style.height;
		mapWidth	= mapWidth.replace('px','');
		mapHeight	= mapHeight.replace('px','');


		var save_Zoom	= document.navermap_form.save_Zoom.checked == true ? '1' : '';
		//var save_Btn	= document.navermap_form.save_Btn.checked == true ? '1' : '';
		//var save_Index	= document.navermap_form.save_Index.checked == true ? '1' : '';
		var save_Wheel	= document.navermap_form.save_Wheel.checked == true ? true : false;

		//outContent	+= "<SCR"+"IPT type='text/javasc"+"ript' src='http://map.naver.com/js/naverMap.naver?key="+naverMaps_Key+"'></SCR"+"IPT>";
		//outContent	+="var naverMapObj"+nowTimeChk+" = new NMap(document.getElementById('mapContainer_"+nowTimeChk+"'),"+mapWidth+","+mapHeight+");" ;
		//outContent	+="naverMapObj"+nowTimeChk+".setCenterAndZoom(new NPoint("+mapObj.getCenter()+"),"+mapObj.getZoom()+");\n" ;
		//outContent	+="naverMapObj"+nowTimeChk+".setCenterAndLevel(new nhn.api.map.LatLng("+mapObj.getCenter()+"),"+mapObj.getLevel()+");\n" ;
		//outContent	+="navermap_zoom_now()" ;


		outContent	+="<div id='mapContainer_"+nowTimeChk+"' style='width:"+mapWidth+"px;height:"+mapHeight+"px'><img src='/editor/happy_module/naver_map/images/naver_map_intro.jpg' border='1' width='"+mapWidth+"' height='"+mapHeight+"'></div>" ;
		/* v2
		outContent	+= "<SCR"+"IPT type='text/javasc"+"ript' src='http://openapi.map.naver.com/openapi/v2/maps.js?ncpClientId="+naverMaps_Key+"'></SCR"+"IPT>";
		outContent	+="<SC"+"RIPT LANGUAGE='JavaSc"+"ript'>" ;
		outContent	+="function map_insert_"+nowTimeChk+"(){" ;
		outContent	+="document.getElementById('mapContainer_"+nowTimeChk+"').innerHTML='';;" ;
		outContent	+="if ( document.getElementById('mapContainer_"+nowTimeChk+"') ) { ";
		outContent	+="var naverMapObj"+nowTimeChk+" = new nhn.api.map.Map(document.getElementById('mapContainer_"+nowTimeChk+"'), { ";
		outContent	+="zoom : "+naverMaps_Zoom+",";
		outContent	+="enableWheelZoom : "+save_Wheel+",";
		outContent	+="enableDragPan : true,";
		outContent	+="enableDblClickZoom : false,";
		outContent	+="mapMode : 0,";
		outContent	+="activateTrafficMap : false,";
		outContent	+="activateBicycleMap : false,";
		outContent	+="minMaxLevel : [ 1, 14 ],";
		outContent	+="size : new nhn.api.map.Size("+mapWidth+","+ mapHeight+")		});";
		outContent	+="naverMapObj"+nowTimeChk+".setCenterAndLevel(new nhn.api.map.LatLng("+point_x+","+point_y+"),"+mapObj.getLevel()+");\n" ;
		*/

		outContent	+= "<SCR"+"IPT type='text/javasc"+"ript' src='http://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId="+naverMaps_Key+"&submodules=geocoder'></SCR"+"IPT>";
		outContent	+="<SC"+"RIPT LANGUAGE='JavaSc"+"ript'>" ;
		outContent	+="function map_insert_"+nowTimeChk+"(){" ;
		outContent	+="document.getElementById('mapContainer_"+nowTimeChk+"').innerHTML='';;" ;
		outContent	+="if ( document.getElementById('mapContainer_"+nowTimeChk+"') ) { ";
		outContent	+="var naverMapObj"+nowTimeChk+" = new naver.maps.Map(document.getElementById('mapContainer_"+nowTimeChk+"'), { ";
		outContent	+="zoom : "+getZoom_info+",";
		outContent	+="scrollWheel : "+save_Wheel+",";
		outContent	+="draggable : true,";
		outContent	+="disableDoubleClickZoom : false,";
		outContent	+="mapTypeId : naver.maps.MapTypeId.NORMAL,";
		outContent	+="minZoom : 1,";
		outContent	+="maxZoom : 14,";
		outContent	+="size : new naver.maps.Size("+mapWidth+","+ mapHeight+")		});";
		outContent	+="naverMapObj"+nowTimeChk+".setCenter(new naver.maps.LatLng("+point.y+","+point.x+"));\n" ;



		if ( save_Zoom == '1' )
		{
			/*
			outContent	+= "var zoomObj"+nowTimeChk+" =new NZoomControl();";
			outContent	+= "zoomObj"+nowTimeChk+".setAlign('left');";
			outContent	+= "zoomObj"+nowTimeChk+".setValign('bottom');";
			outContent	+= "naverMapObj"+nowTimeChk+".addControl(zoomObj"+nowTimeChk+");\n";
			*/

			/* v2
			outContent	+= "var oSlider"+nowTimeChk+" = new nhn.api.map.ZoomControl();";
			outContent	+= "naverMapObj"+nowTimeChk+".addControl(oSlider"+nowTimeChk+");";
			outContent	+= "oSlider"+nowTimeChk+".setPosition({";
			outContent	+= "top : 10,";
			outContent	+= "left : 10";
			outContent	+= "});";
			*/

			outContent	+= "naverMapObj"+nowTimeChk+".setOptions({";
			outContent	+= "zoomControl: true,";
			outContent	+= "zoomControlOptions: {";
			outContent	+= "position: naver.maps.Position.TOP_LEFT";
			outContent	+= "}";
			outContent	+= "});";
		}

		/*
		if ( save_Btn == '1' )
		{
			outContent	+= "var saveObj"+nowTimeChk+" =new NSaveBtn();";
			outContent	+= "saveObj"+nowTimeChk+".setAlign('right');";
			outContent	+= "saveObj"+nowTimeChk+".setValign('bottom');";
			outContent	+= "naverMapObj"+nowTimeChk+".addControl(saveObj"+nowTimeChk+");\n";
		}
		*/

		/*
		if ( save_Index == '1' )
		{
			outContent	+= "var indexObj"+nowTimeChk+" =new NIndexMap();";
			outContent	+= "indexObj"+nowTimeChk+".setAlign('right');";
			outContent	+= "indexObj"+nowTimeChk+".setValign('bottom');";
			outContent	+= "naverMapObj"+nowTimeChk+".addControl(indexObj"+nowTimeChk+");\n";
		}
		*/

		/*
		if ( save_Wheel == '1' )
		{
			outContent	+= "naverMapObj"+nowTimeChk+".enableWheelZoom();\n";
		}
		*/
		outContent		+= "}";



		document.navermap_form.naver_width.value	= naverMaps_Width;
		document.navermap_form.naver_height.value	= naverMaps_Height;

		markLength	= markAddWidthList.length;
		//for ( i=0 ; i<markLength ; i++ )
		for ( var i in markAddWidthList)
		{
			//alert( markAddPointList[i] +" - "+ markAddUrlList[i] +" - "+ markAddWidthList[i] +" - "+ markAddHeightList[i] +" - "+ markAddMessageList[i] );

			if ( markAddShowList[i] == 'show' )
			{
				point					= markAddPointList[i];

				markMessage	= markAddMessageList[i];
				markIcon	= "./editor/happy_module/naver_map/"+ markAddUrlList[i];
				markWidth	= markAddWidthList[i];
				markHeight	= markAddHeightList[i];

				//if ( markMessage != '' )
				//{
				//	outContent	+= "var naverMsgObj"+nowTimeChk+i+"	= new NInfoWindow();";
				//	outContent	+= "naverMsgObj"+nowTimeChk+i+".set(new NPoint("+point+"),'"+markMessage+"');";
				//	outContent	+= "naverMapObj"+nowTimeChk+".addOverlay(naverMsgObj"+nowTimeChk+i+");";

				//	outContent	+= "naverMsgObj"+nowTimeChk+i+".setOpacity(1);";
				//	outContent	+= "naverMsgObj"+nowTimeChk+i+".showWindow();\n";
				//}


				


				/*
				outContent	+= "var naverMarkObj"+nowTimeChk+i+" = new NMark(new NPoint("+point+"),new NIcon('"+markIcon+"',new NSize("+markWidth+","+markHeight+")));";
				outContent	+= "naverMapObj"+nowTimeChk+".addOverlay(naverMarkObj"+nowTimeChk+i+");\n";
				*/

				/* v2
				outContent	+= "var oSize = new nhn.api.map.Size("+markWidth+", "+markHeight+");\n";
				outContent	+= "var oIcon = new nhn.api.map.Icon('"+markIcon+"', oSize, '');\n";
				outContent	+= "var naverMarkObj"+nowTimeChk+i+" = new nhn.api.map.Marker(oIcon, { title : '' });\n";
				outContent	+= "naverMarkObj"+nowTimeChk+i+".setPoint(new nhn.api.map.LatLng("+point_add_x+","+point_add_y+"));\n";
				outContent	+= "naverMapObj"+nowTimeChk+".addOverlay(naverMarkObj"+nowTimeChk+i+");\n";
				*/

				outContent	+= "var markerOptions"+nowTimeChk+i+" = {";
				outContent	+= "	map: naverMapObj"+nowTimeChk+",";
				outContent	+= "	position: new naver.maps.LatLng("+point.y+","+point.x+"),";
				outContent	+= "	icon: {";
				outContent	+= "		url: '"+markIcon+"',";
				outContent	+= "		size: new naver.maps.Size("+markWidth+", "+markHeight+")";
				outContent	+= "	}";
				outContent	+= "};";
				outContent	+= "var naverMarkObj"+nowTimeChk+i+" = new naver.maps.Marker(markerOptions"+nowTimeChk+i+");";
				outContent	+= "naverMarkObj"+nowTimeChk+i+".setMap(naverMapObj"+nowTimeChk+"); ";




				if ( markMessage != '' )
				{

					//markMessage	= "<table height=23 ><tr><td width=7></td><td height=23 bgcolor=white>"+markMessage+"</td><td width=7></td></tr><tr><td height=5 colspan=3></td></tr></table>";
					//markMessage	= "<DIV style='border-top:1px solid; border-bottom:2px groove black; border-left:1px solid; border-right:2px groove black;margin-bottom:1px;color:black;background-color:white; width:auto; height:auto;'><span style='color: #000000 !important;display: inline-block;font-size: 12px !important;font-weight: bold !important;letter-spacing: -1px !important;white-space: nowrap !important; padding: 2px 5px 2px 2px !important'>"+markMessage+"<br /><span></div>"; //v2
					markMessage		= '<div style="position:absolute;left:0;top:0;width:120px;height:30px;line-height:30px;text-align:center;background-color:#fff;border:2px solid #f00;">'+markMessage+'</div>'


					/*
					outContent	+= "var naverMsgObj"+nowTimeChk+i+"	= new NInfoWindow();";
					outContent	+= "naverMsgObj"+nowTimeChk+i+".set(new NPoint("+point+"),'"+markMessage+"');";
					outContent	+= "naverMapObj"+nowTimeChk+".addOverlay(naverMsgObj"+nowTimeChk+i+");";
					outContent	+= "naverMsgObj"+nowTimeChk+i+".setOpacity(1);";
					//outContent	+= "naverMsgObj"+nowTimeChk+i+".showWindow();\n";
					*/


					/* v2
					outContent	+= "var naverMsgObj"+nowTimeChk+i+"	= new nhn.api.map.InfoWindow();";
					outContent	+= "naverMsgObj"+nowTimeChk+i+".setVisible(true);";
					outContent	+= "naverMsgObj"+nowTimeChk+i+".setPoint(new nhn.api.map.LatLng("+point_add_x+","+point_add_y+"));";
					outContent	+= "naverMsgObj"+nowTimeChk+i+".setContent(\""+markMessage+"\");";
					outContent	+= "naverMsgObj"+nowTimeChk+i+".setOpacity(1);";
					outContent	+= "naverMapObj"+nowTimeChk+".addOverlay(naverMsgObj"+nowTimeChk+i+");";
					*/

					outContent	+= "var naverMsgObj"+nowTimeChk+i+"	= new naver.maps.InfoWindow({";
					outContent	+= "content: '"+markMessage+"'";
					outContent	+= "});";
				}



				if ( markMessage != '' )
				{
					/*
					outContent	+= "NEvent.addListener(naverMarkObj"+nowTimeChk+i+", 'mouseover', markMouseOverEvent );";
					outContent	+= "NEvent.addListener(naverMarkObj"+nowTimeChk+i+", 'mouseout', markMouseOutEvent );";
					outContent	+= "NEvent.addListener(naverMarkObj"+nowTimeChk+i+", 'click', markClickEvent );";
					*/

					/* v2
					outContent	+= "var markMouseOverEvent	= function() {";
					//outContent	+= "naverMsgObj"+nowTimeChk+i+".showWindow();"; //v1
					outContent	+= "naverMsgObj"+nowTimeChk+i+".setVisible(true);";
					outContent	+= "};\n";

					outContent	+= "var markMouseOutEvent	= function() {";
					//outContent	+= "naverMsgObj"+nowTimeChk+i+".hideWindow();"; //v1
					outContent	+= "naverMsgObj"+nowTimeChk+i+".setVisible(false);";
					outContent	+= "};\n";
					outContent	+= "var markClickEvent	= function() {";
					//outContent	+= "zoomLevel	= naverMapObj"+nowTimeChk+".getZoom();"; //v1
					outContent	+= "zoomLevel	= naverMapObj"+nowTimeChk+".getLevel();";
					outContent	+= "zoomLevel	= ( zoomLevel > 0 )? zoomLevel-1 : 0;";
					//outContent	+= "naverMapObj"+nowTimeChk+".setCenterAndZoom(naverMarkObj"+nowTimeChk+i+".getPoint(),zoomLevel);"; //v1
					outContent	+= "naverMapObj"+nowTimeChk+".setCenterAndLevel(naverMarkObj"+nowTimeChk+i+".getPoint(),zoomLevel);\n" ;
					outContent	+= "navermap_zoom_now();";
					outContent	+= "};\n";
					

					outContent	+= "naverMarkObj"+nowTimeChk+i+".attach('mouseenter', markMouseOverEvent );";
					outContent	+= "naverMarkObj"+nowTimeChk+i+".attach('mouseleave', markMouseOutEvent );";
					outContent	+= "naverMarkObj"+nowTimeChk+i+".attach('click', markClickEvent );";
					*/

					
					outContent	+= "var markMouseOverEvent	= function() {";
					outContent	+= "naverMsgObj"+nowTimeChk+i+".open(naverMapObj"+nowTimeChk+",naverMarkObj"+nowTimeChk+i+");";
					outContent	+= "};\n";

					outContent	+= "var markMouseOutEvent	= function() {";
					outContent	+= "naverMsgObj"+nowTimeChk+i+".close();";
					outContent	+= "};\n";

					outContent	+= "var markClickEvent	= function() {";
					outContent	+= "zoomLevel	= naverMapObj"+nowTimeChk+".getZoom();";
					outContent	+= "zoomLevel	= ( zoomLevel > 0 )? zoomLevel+1 : 0;";
					outContent	+= "naverMapObj"+nowTimeChk+".setCenter(naverMarkObj"+nowTimeChk+i+".getPosition());\n" ;
					outContent	+= "naverMapObj"+nowTimeChk+".setZoom(zoomLevel);\n" ;
					outContent	+= "};\n";

					outContent	+= "naver.maps.Event.addListener(naverMarkObj"+nowTimeChk+i+", 'mouseover', markMouseOverEvent );";
					outContent	+= "naver.maps.Event.addListener(naverMarkObj"+nowTimeChk+i+", 'mouseout', markMouseOutEvent );";
					outContent	+= "naver.maps.Event.addListener(naverMarkObj"+nowTimeChk+i+", 'click', markClickEvent );";
				}


			}


		}

		outContent	+="}" ;
		outContent	+="setTimeout('map_insert_"+nowTimeChk+"()',500);" ;

		outContent	+="</SC"+"RIPT>" ;

		parent.ckeditor_insertcode(editor_name,'html',outContent);
		parent.editor_layer_close();
		return true ;

	}


	function ResizeParent()
	{
		var oParentWindow = window.parent;
	//2.6
		if (window.parent.Sizer)
		{
			oParentWindow.Sizer.RefreshSize() ;
			return;
		}
		var oInnerWindow = window ;
		var oInnerDoc = oInnerWindow.document ;
		var iDiff, iFrameHeight, iFrameWidth ;

		if ( document.all )
			iFrameHeight = oInnerDoc.body.offsetHeight ;
		else
			iFrameHeight = oInnerWindow.innerHeight ;

		var iInnerHeight = oInnerDoc.body.scrollHeight ;
		iDiff = iInnerHeight - iFrameHeight ;

		if ( iDiff !== 0 )
		{
			if ( document.all )
				oParentWindow.dialogHeight = ( parseInt( oParentWindow.dialogHeight, 10 ) + iDiff ) + 'px' ;
			else
				oParentWindow.resizeBy( 0, iDiff ) ;
		}

		// Width:
		if ( document.all )
			iFrameWidth = oInnerDoc.body.offsetWidth ;
		else
			iFrameWidth = oInnerWindow.innerWidth ;

		var iInnerWidth = oInnerDoc.body.scrollWidth ;
		iDiff = iInnerWidth - iFrameWidth ;

		if ( iDiff !== 0 )
		{
			if ( document.all )
				oParentWindow.dialogWidth = ( parseInt( oParentWindow.dialogWidth, 10 ) + iDiff ) + 'px' ;
			else
				oParentWindow.resizeBy( iDiff, 0 ) ;
		}

	}

	function navermap_resize()
	{
		var nWidth	= parseInt(document.getElementById('naver_width').value) ;
		var nHeight	= parseInt(document.getElementById('naver_height').value) ;

		if ( nWidth > 1000 ) {
			nWidth	= 1000;
			alert("최대 1000 까지 입력하실수 있습니다");
			document.getElementById('naver_width').value = 1000;
		}

		if ( nHeight > 800 ) {
			nHeight	= 800;
			alert("최대 800 까지 입력하실수 있습니다");
			document.getElementById('naver_height').value = 800;
		}

		//alert(nWidth + " : " + nHeight);

		document.getElementById('mapContainer_'+nowTimeChk).style.width	= nWidth + 'px';
		document.getElementById('mapContainer_'+nowTimeChk).style.height	= nHeight + 'px';
		//mapObj.setSize(new nhn.api.map.Size(nWidth,nHeight)); //v2
		mapObj.setSize(new naver.maps.Size(nWidth,nHeight));

		ResizeParent();
	}

	function Import(aSrc) {
		document.write('<scr'+'ipt type="text/javascript" src="' + aSrc + '"></sc' + 'ript>');
	}

	//Import('http://map.naver.com/js/naverMap.naver?key='+naverMaps_Key);
	Import('http://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId='+naverMaps_Key+'&submodules=geocoder');

	function naver_data_loading()
	{
		var search_keyword	= document.getElementById('naver_search').value;

		document.navermap_search_form.keyword.value				= search_keyword;
		//document.navermap_search_form.naver_key.value			= naverMaps_Normal_Key;
		document.navermap_search_form.naver_key.value			= naverMaps_Key;
		document.navermap_search_form.naver_secret_key.value	= naverMaps_Secret_Key;

		document.navermap_search_form.submit();

		document.getElementById('mapSearch').style.display	= '';
		ResizeParent();

		//document.getElementById('mapSearchFrame').src	= 'naversearch.php?naver_key='+ naverMaps_Normal_Key +'&keyword='+ search_keyword;

		//Import("http://openapi.naver.com/search?key="+ naverMaps_Normal_Key +"&query=%EA%B0%88%EB%B9%84%EC%A7%91&target=local&start=1&display=10 ");

	}

	function naver_data_loading2()
	{
		var search_keyword	= document.getElementById('naver_search2').value;

		document.navermap_search_form2.keyword.value			= search_keyword;
		document.navermap_search_form2.naver_key.value			= naverMaps_Key;
		document.navermap_search_form2.naver_secret_key.value	= naverMaps_Secret_Key;

		document.navermap_search_form2.submit();

		document.getElementById('mapSearch').style.display	= '';
		ResizeParent();

	}

	function navermap_move(api_type, xpoint, ypoint, zoomlevel)
	{
		if ( xpoint == '' || ypoint == '' )
		{
			alert('지역정보가 존재하지 않습니다.');
			return false;
		}

		//xpoint	= parseInt(xpoint);
		//ypoint	= parseInt(ypoint);
		zoomlevel	= zoomlevel == '' ? 2 : zoomlevel;

		if(api_type == 'api_search')
		{
			/* v2
			var tm_point		= new nhn.api.map.TM128(xpoint,ypoint);
			var l_point			= String(tm_point.toLatLng());
			*/

			var tm_point		= new naver.maps.Point(xpoint,ypoint);
			var l_point			= new naver.maps.TransCoord.fromTM128ToLatLng(tm_point);

			//mapObj.setCenterAndLevel(new nhn.api.map.LatLng(l_point_split[1],l_point_split[0]),zoomlevel); //v2
			mapObj.setCenter(new naver.maps.LatLng(l_point.y, l_point.x));
			mapObj.setZoom(zoomlevel);
		}
		else if(api_type == 'api_map')
		{
			//mapObj.setCenterAndLevel(new nhn.api.map.LatLng(xpoint,ypoint),zoomlevel); //v2
			mapObj.setCenter(new naver.maps.LatLng(xpoint,ypoint));
			mapObj.setZoom(zoomlevel);
		}
		navermap_zoom_now();

		//var iconUrl	= 'images/AddMarker.png';
		//var markObj	= new NMark(new NPoint(xpoint,ypoint),new NIcon(iconUrl,new NSize(32,27)));
		//mapObj.addOverlay(markObj);

	}

	var marker_add_check	= Array('','','','','','','','','','','','','','','','','','','','');
	var message_add_check	= Array('','','','','','','','','','','','','','','','','','','','');
	var markObj2			= Array();
	var messageObj2			= Array();

	function navermap_marker_add( api_type, no, title, xpoint, ypoint )
	{

		if ( marker_add_check[no] != '' && markObj2[no] != undefined )
		{
			//mapObj.removeOverlay(markObj2[no]); //v2
			markObj2[no].setMap(null);
		}
		if ( message_add_check[no] != '' && messageObj2[no] != undefined )
		{
			//mapObj.removeOverlay(messageObj2[no]); //v2
			messageObj2[no].setMap(null);
			message_add_check[no]	= '';
		}

		if ( xpoint == '' || ypoint == '' )
		{
			return false;
		}

		marker_add_check[no]	= 'ok';



		var iconUrl			= "images/pos_"+no+".png";
		//markObj2[no]		= new NMark(new NPoint(xpoint,ypoint),new NIcon(iconUrl,new NSize(24,23)));

		/* v2
		var oSize = new nhn.api.map.Size(24, 23);
		//var oOffset = new nhn.api.map.Size(14, 37);
		var oIcon = new nhn.api.map.Icon(iconUrl, oSize, '');

		markObj2[no]		= new nhn.api.map.Marker(oIcon, { zIndex : no });
		if(api_type == 'api_search')
		{
			var tm_point		= new nhn.api.map.TM128(xpoint,ypoint);
			var l_point			= String(tm_point.toLatLng());
			var l_point_split	= l_point.split(",");

			markObj2[no].setPoint(new nhn.api.map.LatLng(l_point_split[1],l_point_split[0]));
		}
		else if(api_type == 'api_map')
		{
			markObj2[no].setPoint(new nhn.api.map.LatLng(xpoint,ypoint));
		}
		mapObj.addOverlay(markObj2[no]);
		*/


		if(api_type == 'api_search')
		{
			//var tm_point		= new naver.maps.TM128(xpoint,ypoint); //v2
			//var l_point		= String(tm_point.toLatLng()); //v2
			var tm_point		= new naver.maps.Point(xpoint,ypoint);
			var l_point			= new naver.maps.TransCoord.fromTM128ToLatLng(tm_point);

			var pointOmethod	= new naver.maps.LatLng(l_point.y,l_point.x);
		}
		else if(api_type == 'api_map')
		{
			var pointOmethod	= new naver.maps.LatLng(xpoint,ypoint);
		}

		var markerOptions = {
			map: mapObj,
			position: pointOmethod,
			zIndex: no,
			icon: {
				url: iconUrl,
				size: new naver.maps.Size(24, 23)
			}
		};
		markObj2[no] = new naver.maps.Marker(markerOptions);
		markObj2[no].setMap(mapObj); // 추가


		
		if ( title != '' )
		{
			message_add_check[no]	= 'ok';

			title	= "<table border='0' style='width:150px; border:1px dashed #909090; background:#fff;' cellspacing='0' cellpadding='0' height='30' ><tr><td style='padding:13px 10px 10px 10px; ' align='center'>"+title+"</td></tr></table>";

			//messageObj2[no]	= new NInfoWindow();
			//messageObj2[no].set(new NPoint(xpoint,ypoint),title);
			//messageObj2[no].set(new nhn.api.map.LatLng(xpoint,ypoint),title);

			/* v2
			messageObj2[no]	= new nhn.api.map.InfoWindow();
			messageObj2[no].setVisible(false);
			messageObj2[no].setContent(title);
			messageObj2[no].setOpacity(1);
			mapObj.addOverlay(messageObj2[no]);
			*/

			
			messageObj2[no]	= new naver.maps.InfoWindow({
								content: title
			});

			naver.maps.Event.addListener(markObj2[no], "click", function(e) {
				if (messageObj2[no].getMap()) {
					messageObj2[no].close();
				} else {
					messageObj2[no].open(mapObj, markObj2[no]);
				}
			});
		}



		if ( message_add_check[no] == 'ok' )
		{
			/*
			var markMouseOverEvent	= function() {
				messageObj2[no].showWindow();
			}

			var markMouseOutEvent	= function() {
				messageObj2[no].hideWindow();
			}
			var markClickEvent	= function() {
				zoomLevel	= mapObj.getZoom();
				zoomLevel	= ( zoomLevel > 0 )? zoomLevel-1 : 0;
				mapObj.setCenterAndZoom(markObj2[no].getPoint(),zoomLevel);
				navermap_zoom_now();
			}

			NEvent.addListener(markObj2[no], "mouseover", markMouseOverEvent );
			NEvent.addListener(markObj2[no], "mouseout", markMouseOutEvent );
			NEvent.addListener(markObj2[no], "click", markClickEvent );
			*/


			/* v2
			mapObj.attach('mouseenter', function(oCustomEvent) {

				var oTarget		= oCustomEvent.target;

				// 마커위에 마우스 올라간거면
				if (oTarget instanceof nhn.api.map.Marker) {
					//var oMarker = oTarget;
					//oLabel.setVisible(true, oMarker); // - 특정 마커를 지정하여 해당 마커의 title을 보여준다.

					var getZIndex	= oTarget.getZIndex();
					if(messageObj2[getZIndex] != undefined)
					{
						messageObj2[getZIndex].setPoint(oTarget.getPoint());
						messageObj2[getZIndex].setPosition({right : 15, top : 10});
						messageObj2[getZIndex].setVisible(true);
					}
					//messageObj2[getZIndex].autoPosition();
				}
			});
			*/



			/* v2
			mapObj.attach('mouseleave', function(oCustomEvent) {

				var oTarget = oCustomEvent.target;

				// 마커위에서 마우스 나간거면
				if (oTarget instanceof nhn.api.map.Marker) {
					//oLabel.setVisible(false);

					var getZIndex	= oTarget.getZIndex();

					if(messageObj2[getZIndex] != undefined)
					{
						messageObj2[getZIndex].setVisible(false);
					}
				}
			});
			*/


			/* v2
			mapObj.attach('click', function(oCustomEvent) {

				var oPoint = oCustomEvent.point;
				var oTarget = oCustomEvent.target;

				// 마커 클릭하면
				if (oTarget instanceof nhn.api.map.Marker) {
					// 겹침 마커 클릭한거면
					if (oCustomEvent.clickCoveredMarker) {
						//return;
					}

					var getZIndex	= oTarget.getZIndex();

					zoomLevel	= mapObj.getLevel();
					zoomLevel	= ( zoomLevel > 0 )? zoomLevel+1 : 0;
					mapObj.setCenterAndLevel(markObj2[getZIndex].getPoint(),zoomLevel);
					navermap_zoom_now();

					return;
				}

				/*
				var oMarker = new nhn.api.map.Marker(oIcon, { title : '마커 : ' + oPoint.toString() });
				oMarker.setPoint(oPoint);
				mapObj.addOverlay(oMarker);

				var aPoints = oPolyline.getPoints(); // - 현재 폴리라인을 이루는 점을 가져와서 배열에 저장.
				aPoints.push(oPoint); // - 추가하고자 하는 점을 추가하여 배열로 저장함.
				oPolyline.setPoints(aPoints); // - 해당 폴리라인에 배열에 저장된 점을 추가함
				*/
			//});

			// naver 지도 v3 부터는 다시 v1 과 마찬가지로 마커에 이벤트를 등록함(상단 addListener)
		}
	}



	function navermap_zoom_now()
	{
		//nowZoom	= parseInt(mapObj.getZoom());
		//nowZoom	= parseInt(mapObj.getLevel()); //v2
		nowZoom		= parseInt(mapObj.getZoom());
		for ( var i=1 ; i<=14 ; i++ )
		{
			if ( nowZoom == i )
			{
				//outHTML	= "<a href='#onClickZoom' onClick='mapObj.setLevel("+i+");navermap_zoom_now();' style='text-decoration:none;'><img src='images/btn_zoom_select.gif' border='0' width='22' height='12'></a>"; //v2
				outHTML		= "<a href='#onClickZoom' onClick='mapObj.setZoom("+i+");navermap_zoom_now();' style='text-decoration:none;'><img src='images/btn_zoom_select.gif' border='0' width='22' height='12'></a>";
			}
			else
			{
				//outHTML	= "<a href='#onClickZoom' onClick='mapObj.setLevel("+i+");navermap_zoom_now();' style='text-decoration:none;'><img src='images/btn_zoom" + (-(i - 14)) + ".gif' border=0 width='22' height='12'></a>"; //v2
				outHTML	= "<a href='#onClickZoom' onClick='mapObj.setZoom("+i+");navermap_zoom_now();' style='text-decoration:none;'><img src='images/btn_zoom" + (-(i - 14)) + ".gif' border=0 width='22' height='12'></a>";
			}
			document.getElementById('zoomLayer'+ i).innerHTML	= outHTML;
		}
	}


	var markAddCheck	= false;
	var markIcon		= '';
	var markWidth		= 24;
	var markHeight		= 24;

	var markAddWidthList	= Array();
	var markAddHeightList	= Array();
	var markAddMessageList	= Array();
	var markAddPointList	= Array();
	var markAddUrlList		= Array();
	var markAddShowList		= Array();
	var msgObj				= Array();
	var markObj				= Array();

	function addMark( markUrl, markW, markH )
	{
		markIcon	= markUrl;
		markWidth	= markW;
		markHeight	= markH;

		//document.getElementById('mapContainer_'+nowTimeChk).style.cursor = 'hand';

		if (!markAddCheck)
		{
			//NEvent.addListener(mapObj,"click",addMarkEvent);
			//mapObj.attach('click', addMarkEvent); //v2
			var listener = naver.maps.Event.addListener(mapObj, "click", function(e) {
				addMarkEvent(e);

				naver.maps.Event.removeListener(listener);
			});
			markAddCheck  = true;
		}
	}

	function removeMark()
	{
		//NEvent.removeListener(mapObj,"click",addMarkEvent);
		//mapObj.detach('click', addMarkEvent); //v2
		//v3 에서는 바로 addMark 함수에서 바로 리스너제거
		markAddCheck  = false;
	}

	function addMarkEvent(oCustomEvent)
	{
		var point	= oCustomEvent.latlng;

		markMessage	= document.navermap_form.markMessage.value;


		markAddListLen	= markAddWidthList.length+1000 ;
		//alert(markAddListLen);

		markAddWidthList[markAddListLen]	= markWidth;
		markAddHeightList[markAddListLen]	= markHeight;
		markAddPointList[markAddListLen]	= point;
		markAddUrlList[markAddListLen]		= markIcon;
		markAddShowList[markAddListLen]		= 'show';
		msgObj[markAddListLen]				= '';
		markObj[markAddListLen]				= '';


		if ( markMessage != '' )
		{
			maxSpace	= markWidth / 6;
			var space	= '';
			for ( i=0 ; i<maxSpace ; i++ )
			{
				//space	+= "&nbsp;";
			}

			markMessage	= space + markMessage;

			document.navermap_form.markMessage.value	= '';

			markAddMessageList[markAddListLen]	= markMessage;

			//markMessage	= "<table height='23' ><tr><td width='7'></td><td height='23' bgcolor='white'>"+markMessage+"</td><td width='7'></td></tr><tr><td height='5' colspan='3'></td></tr></table>";
			//markMessage	= "<DIV style='border-top:1px solid; border-bottom:2px groove black; border-left:1px solid; border-right:2px groove black;margin-bottom:1px;color:black;background-color:white; width:auto; height:auto;'><span style='color: #000000 !important;display: inline-block;font-size: 12px !important;font-weight: bold !important;letter-spacing: -1px !important;white-space: nowrap !important; padding: 2px 5px 2px 2px !important'>"+markMessage+"<br /><span></div>";


			/*
			msgObj[markAddListLen]	= new NInfoWindow();
			msgObj[markAddListLen].set(point,markMessage);
			mapObj.addOverlay(msgObj[markAddListLen]);

			msgObj[markAddListLen].setOpacity(1);
			msgObj[markAddListLen].showWindow();
			*/

			/* v2
			msgObj[markAddListLen]	= new nhn.api.map.InfoWindow();
			msgObj[markAddListLen].setPoint(point);
			msgObj[markAddListLen].setContent(markMessage);
			mapObj.addOverlay(msgObj[markAddListLen]);
			msgObj[markAddListLen].setOpacity(1);
			msgObj[markAddListLen].setVisible(true);
			msgObj[markAddListLen].setPosition({
				top : -30,
				left :-60
			});
			*/


			var CustomOverlay = function(options) {
				this._element = $('<div style="position:absolute;left:0;top:0;width:120px;height:30px;line-height:30px;text-align:center;background-color:#fff;border:2px solid #f00;">'+markMessage+'</div>')

				this.setPosition(options.position);
				this.setMap(options.map || null);
			};

			// CustomOverlay는 OverlayView를 상속 받습니다.
			CustomOverlay.prototype = new naver.maps.OverlayView();

			CustomOverlay.prototype.constructor = CustomOverlay;

			CustomOverlay.prototype.onAdd = function() {
				var overlayLayer = this.getPanes().overlayLayer;

				this._element.appendTo(overlayLayer);
			};

			CustomOverlay.prototype.draw = function() {
				// 지도 객체가 설정되지 않았으면 draw 기능을 하지 않습니다.
				if (!this.getMap()) {
					return;
				}

				// projection 객체를 통해 LatLng좌표를 화면좌표로 변경합니다.
				var projection = this.getProjection(),
					position = this.getPosition();

				var pixelPosition = projection.fromCoordToOffset(position);

				this._element.css('left', pixelPosition.x);
				this._element.css('top', pixelPosition.y);
			};

			CustomOverlay.prototype.onRemove = function() {
				this._element.remove();

				// 이벤트 핸들러를 설정했다면 정리합니다.
				//this._element.off();
			};

			CustomOverlay.prototype.setPosition = function(position) {
				this._position = position;
				this.draw();
			};

			CustomOverlay.prototype.getPosition = function() {
				return this._position;
			};

			/**
			 * 사용자 정의 오버레이 사용하기
			 */
			// 오버레이를 생성
			msgObj[markAddListLen] = new CustomOverlay({
				position: point,
				map: mapObj
			});
		}
		else
		{
			markAddMessageList[markAddListLen]	= '';
		}

		//var iconUrl	= 'images/AddMarker.png';
		//markObj[markAddListLen]	= new NMark(point,new NIcon(markIcon,new NSize(markWidth,markHeight)));

		/* v2
		var oSize = new nhn.api.map.Size(markWidth, markHeight);
		//var oOffset = new nhn.api.map.Size(14, 37);
		var oIcon = new nhn.api.map.Icon(markIcon, oSize, '');

		markObj[markAddListLen] = new nhn.api.map.Marker(oIcon, { zIndex : markAddListLen });
		markObj[markAddListLen].setPoint(point);

		mapObj.addOverlay(markObj[markAddListLen]);


		var no	= markAddListLen;
		deleteMark	= function() {
			if ( confirm('마크를 제거하시겠습니까?') )
			{
				//alert(no);return;
				mapObj.removeOverlay(markObj[no]);
				if ( markAddMessageList[no] != '' ) {
					mapObj.removeOverlay(msgObj[no]);
				}

				markAddWidthList[no]	= undefined;
				markAddHeightList[no]	= undefined;
				markAddMessageList[no]	= undefined;
				markAddPointList[no]	= undefined;
				markAddUrlList[no]		= undefined;
				markAddShowList[no]		= undefined;
				msgObj[no]				= undefined;
				markObj[no]				= undefined;
			}

		}

		//NEvent.addListener(markObj[markAddListLen],"click",deleteMark); //v1
		markObj[markAddListLen].attach('click', deleteMark);
		*/


		var markerOptions = {
			map: mapObj,
			position: point,
			zIndex: markAddListLen,
			icon: {
				url: markIcon,
				size: new naver.maps.Size(markWidth, markHeight)
			}
		};
		markObj[markAddListLen] = new naver.maps.Marker(markerOptions);
		markObj[markAddListLen].setMap(mapObj); // 추가




		var no	= markAddListLen;
		deleteMark	= function() {
			if ( confirm('마크를 제거하시겠습니까?') )
			{
				//alert(no);return;
				markObj[no].setMap(null);
				if ( markAddMessageList[no] != '' ) {
					msgObj[no].setMap(null);
				}

				markAddWidthList[no]	= undefined;
				markAddHeightList[no]	= undefined;
				markAddMessageList[no]	= undefined;
				markAddPointList[no]	= undefined;
				markAddUrlList[no]		= undefined;
				markAddShowList[no]		= undefined;
				msgObj[no]				= undefined;
				markObj[no]				= undefined;
			}
		}
		naver.maps.Event.addListener(markObj[markAddListLen], 'click', deleteMark);
		

		removeMark();
	}

	function removeMarkAll()
	{
		if ( confirm('모든 마커를 제거하시겠습니까?') )
		{
			/*
			markLength	= markAddWidthList.length;
			for ( i=0 ; i<markLength ; i++ )
			{
				mapObj.removeOverlay(markObj[i]);
				if ( markAddMessageList[i] != '' ) {
					mapObj.removeOverlay(msgObj[i]);
				}
			}
			*/

			for(var ma_key in markAddWidthList)
			{
				if(markObj[ma_key] != undefined)
				{
					markObj[ma_key].setMap(null);
				}

				if(msgObj[ma_key] != undefined)
				{
					if ( markAddMessageList[ma_key] != '' ) {
						msgObj[ma_key].setMap(null);
					}
				}
			}

			markAddWidthList	= new Array();
			markAddHeightList	= new Array();
			markAddMessageList	= new Array();
			markAddPointList	= new Array();
			markAddUrlList		= new Array();
			markAddShowList		= new Array();
			msgObj				= new Array();
			markObj				= new Array();

			//mapObj.clearOverlays();
		}
	}


	function naver_map_loading()
	{
		document.write( "<div id='mapContainer_"+nowTimeChk+"' style='width:"+naverMaps_Width+"px;height:"+naverMaps_Height+"px'></div>" );
		document.write( "<SC"+"RIPT LANGUAGE='JavaSc"+"ript'>" );
		//document.write( "var mapObj = new NMap(document.getElementById('mapContainer_"+nowTimeChk+"'),"+naverMaps_Width+","+naverMaps_Height+");" );
		//document.write( "mapObj.setCenterAndZoom(new NPoint("+naverMaps_CenterLat+","+naverMaps_CenterLon+"),"+naverMaps_Zoom+");" );

		/* v2
		document.write( "var centerpoint = new nhn.api.map.LatLng(36.1397715, 128.1136148);");
		document.write( "mapObj	= new nhn.api.map.Map(document.getElementById('mapContainer_'+nowTimeChk), {");
		document.write( "			point : centerpoint,");
		document.write( "			zoom : naverMaps_Zoom,");
		document.write( "			enableWheelZoom : true,");
		document.write( "			enableDragPan : true,");
		document.write( "			enableDblClickZoom : false,");
		document.write( "			mapMode : 0,");
		document.write( "			activateTrafficMap : false,");
		document.write( "			activateBicycleMap : false,");
		document.write( "			minMaxLevel : [ 1, 14 ],");
		document.write( "			size : new nhn.api.map.Size(naverMaps_Width, naverMaps_Height)		});");
		document.write( "var oSlider = new nhn.api.map.ZoomControl();");
		document.write( "mapObj.addControl(oSlider);");
		document.write( "oSlider.setPosition({");
		document.write( "	top : 10,");
		document.write( "	left : 10");
		document.write( "});");
		*/

		document.write( "var centerpoint = new naver.maps.LatLng(35.8557070, 128.5721620);");
		document.write( "mapObj	= new naver.maps.Map(document.getElementById('mapContainer_'+nowTimeChk), {");
		document.write( "			center : centerpoint,");
		document.write( "			zoom : 2,");
		document.write( "			scrollWheel : true,");
		document.write( "			draggable : true,");
		document.write( "			disableDoubleClickZoom : false,");
		document.write( "			mapTypeId : naver.maps.MapTypeId.NORMAL,");
		document.write( "			minZoom : 1,");
		document.write( "			maxZoom : 14,");
		document.write( "			size : new naver.maps.Size(naverMaps_Width, naverMaps_Height)		});");

		document.write( "mapObj.setOptions({");
		document.write( "	zoomControl: true,");
		document.write( "	zoomControlOptions: {");
		document.write( "		position: naver.maps.Position.TOP_LEFT");
		document.write( "	}");
		document.write( "});");


		document.write( "navermap_zoom_now();" );
		document.write( "</SC"+"RIPT>" );

		document.navermap_form.naver_width.value	= naverMaps_Width;
		document.navermap_form.naver_height.value	= naverMaps_Height;
	}

	function naver_map_mark_loading()
	{
		markLen	= naverMaps_Mark_Name.length;


		//YOON: 2009-04-10
		document.write("<table border=0 cellspacing=0 cellpadding=0><tr>");

		for ( i=0 ; i<markLen ; i++ )
		{
			markName	= naverMaps_Mark_Name[i];
			markWidth	= naverMaps_Mark_Width[i];
			markHeight	= naverMaps_Mark_Height[i];

			markWidth	= ( markWidth == "" )? 24 : markWidth;
			markHeight	= ( markHeight == "" )? 24 : markHeight;


			document.write("<td width='30' align='center'><a href='#addmark' onClick=\"addMark('"+markName+"',"+markWidth+","+markHeight+")\"><img src='"+markName+"' border='0'></a></td>");
		}

		//YOON: 2009-04-10
		document.write("</tr></table>");
	}

