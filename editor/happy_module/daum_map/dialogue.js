	// 해피CGI 솔루션외 사용을 금합니다.
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
		point_x					= point.getLat();
		point_y					= point.getLng();

		getLevel_info			= mapObj.getLevel();

		//alert(document.getElementById('mapContainer_'+nowTimeChk).innerHTML);

		outContent	= '';
		//alert(document.getElementById("mapContainer_"+nowTimeChk).style.width);
		//return false;

		mapWidth	= document.getElementById("mapContainer_"+nowTimeChk).style.width;
		mapHeight	= document.getElementById("mapContainer_"+nowTimeChk).style.height;
		mapWidth	= mapWidth.replace('px','');
		mapHeight	= mapHeight.replace('px','');


		var save_Zoom	= document.daummap_form.save_Zoom.checked == true ? '1' : '';
		var save_Wheel	= document.daummap_form.save_Wheel.checked == true ? true : false;

		outContent	+="<div id='mapContainer_"+nowTimeChk+"' style='width:"+mapWidth+"px;height:"+mapHeight+"px'><img src='/editor/happy_module/daum_map/images/daum_map_intro.jpg' border='1' width='"+mapWidth+"' height='"+mapHeight+"'></div>" ;

		outContent	+= "<SCR"+"IPT type='text/javasc"+"ript' src='//dapi.kakao.com/v2/maps/sdk.js?appkey="+daumMaps_Key+"'></SCR"+"IPT>";
		outContent	+= "<SC"+"RIPT LANGUAGE='JavaSc"+"ript'>";
		outContent	+= "function map_insert_"+nowTimeChk+"(){";
		outContent	+= "	var mapObj"+nowTimeChk+" = document.getElementById('mapContainer_"+nowTimeChk+"');";
		outContent	+= "	if ( mapObj"+nowTimeChk+" ) { ";
		outContent	+= "		mapObj"+nowTimeChk+".innerHTML = ''; ";
		outContent	+= "		var latlng"+nowTimeChk+" = new daum.maps.LatLng("+point_x+","+point_y+"); ";
		outContent	+= "		var daumMapObj"+nowTimeChk+" = new daum.maps.Map(mapObj"+nowTimeChk+", { ";
		outContent	+= "			center : latlng"+nowTimeChk+",";
		outContent	+= "			level : "+getLevel_info+",";
		outContent	+= "			scrollwheel : "+save_Wheel+",";
		outContent	+= "			draggable : true,";
		outContent	+= "			disableDoubleClickZoom : false,";
		outContent	+= "			mapTypeId : daum.maps.MapTypeId.ROADMAP";
		outContent	+= "		});";
	
		if ( save_Zoom == '1' )
		{
			outContent	+= "var zoomControl = new daum.maps.ZoomControl();";
			outContent	+= "daumMapObj"+nowTimeChk+".addControl(zoomControl, daum.maps.ControlPosition.TOPLEFT);"; //TOP / TOPLEFT / TOPRIGHT / LEFT / RIGHT / BOTTOMLEFT / BOTTOM / BOTTOMRIGHT
		}

		for ( var i in markAddPointList)
		{
			//console.log( markAddPointList[i] +" - "+ markAddUrlList[i] +" - "+ markAddWidthList[i] +" - "+ markAddHeightList[i] +" - "+ markAddMessageList[i] );

			if ( markAddShowList[i] == 'show' )
			{
				markPoint	= markAddPointList[i];
				markMessage	= markAddMessageList[i];
				markIcon	= "./editor/happy_module/daum_map/"+ markAddUrlList[i];
				markWidth	= markAddWidthList[i];
				markHeight	= markAddHeightList[i];

				markPointX	= markPoint.getLat();
				markPointY	= markPoint.getLng();

				outContent	+= "var daumMarkLatlng"+nowTimeChk+" = new daum.maps.LatLng("+markPointX+","+markPointY+"); ";
				outContent	+= "var daumMarkImg"+nowTimeChk+i+" = new daum.maps.MarkerImage(";
				outContent	+= "	'"+markIcon+"',";
				outContent	+= "	new daum.maps.Size("+markWidth+", "+markHeight+")";
				outContent	+= ");";

				outContent	+= "daumMarkObj"+nowTimeChk+i+" = new daum.maps.Marker({";
				outContent	+= "	map				: daumMapObj"+nowTimeChk+",";
				outContent	+= "	position		: daumMarkLatlng"+nowTimeChk+",";
				outContent	+= "	zIndex			: "+i+",";
				outContent	+= "	image			: daumMarkImg"+nowTimeChk+i+"";
				outContent	+= "});";

				outContent	+= "daumMarkObj"+nowTimeChk+i+".setMap(daumMapObj"+nowTimeChk+");";

				if ( markMessage != '' )
				{
					markMessage	= '<div style="min-width:150px; padding:8px; text-align:center;">'+markMessage+'</div>'

					outContent	+= "var daumMsgObj"+nowTimeChk+i+"	= new daum.maps.InfoWindow({";
					outContent	+= "	content: '"+markMessage+"',";
					outContent	+= "	position: daumMarkLatlng"+nowTimeChk+",";
					outContent	+= "	zIndex: '"+i+"'";
					outContent	+= "});";

					outContent	+= "var markMouseOverEvent"+nowTimeChk+i+"	= function() {";
					outContent	+= "	daumMsgObj"+nowTimeChk+i+".open(daumMapObj"+nowTimeChk+",daumMarkObj"+nowTimeChk+i+");";
					outContent	+= "};\n";

					outContent	+= "var markMouseOutEvent"+nowTimeChk+i+"	= function() {";
					outContent	+= "	daumMsgObj"+nowTimeChk+i+".close();";
					outContent	+= "};\n";

					outContent	+= "var markClickEvent"+nowTimeChk+i+"	= function() {";
					outContent	+= "	zoomLevel	= daumMapObj"+nowTimeChk+".getLevel();";
					outContent	+= "	zoomLevel	= ( zoomLevel > 0 )? zoomLevel-1 : 0;";
					outContent	+= "	daumMapObj"+nowTimeChk+".setCenter(daumMarkObj"+nowTimeChk+i+".getPosition());\n" ;
					outContent	+= "	daumMapObj"+nowTimeChk+".setLevel(zoomLevel);\n" ;
					outContent	+= "};\n";

					outContent	+= "daum.maps.event.addListener(daumMarkObj"+nowTimeChk+i+", 'mouseover', markMouseOverEvent"+nowTimeChk+i+" );";
					outContent	+= "daum.maps.event.addListener(daumMarkObj"+nowTimeChk+i+", 'mouseout', markMouseOutEvent"+nowTimeChk+i+" );";
					outContent	+= "daum.maps.event.addListener(daumMarkObj"+nowTimeChk+i+", 'click', markClickEvent"+nowTimeChk+i+" );";
				}
			}
		}

		outContent	+= "}"; //end if

		outContent	+= "}" ; //end function

		outContent	+= "setTimeout('map_insert_"+nowTimeChk+"()',500);" ;

		outContent	+= "</SC"+"RIPT>" ;

		parent.ckeditor_insertcode(editor_name,'html',outContent);
		parent.editor_layer_close();
		return true ;

	}


	function ResizeParent()
	{
		var oParentWindow = window.parent;

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

	var daum_map_max_width		= 1000;
	var daum_map_max_height		= 800;

	function daummap_resize()
	{
		var nWidth	= parseInt(document.getElementById('daum_width').value) ;
		var nHeight	= parseInt(document.getElementById('daum_height').value) ;

		if ( nWidth > daum_map_max_width ) {
			nWidth	= daum_map_max_width;
			alert("최대 " + daum_map_max_width + " 까지 입력하실수 있습니다");
			document.getElementById('daum_width').value = daum_map_max_width;
		}

		if ( nHeight > daum_map_max_height ) {
			nHeight	= daum_map_max_height;
			alert("최대 " + daum_map_max_height + " 까지 입력하실수 있습니다");
			document.getElementById('daum_height').value = daum_map_max_height;
		}

		//alert(nWidth + " : " + nHeight);

		document.getElementById('mapContainer_'+nowTimeChk).style.width	= nWidth + 'px';
		document.getElementById('mapContainer_'+nowTimeChk).style.height	= nHeight + 'px';

		mapObj.relayout();

		ResizeParent();
	}

	function Import(aSrc) {
		document.write('<scr'+'ipt type="text/javascript" src="' + aSrc + '"></sc' + 'ript>');
	}

	Import('//dapi.kakao.com/v2/maps/sdk.js?appkey='+daumMaps_Key+'');

	function daum_data_loading()
	{
		var search_keyword	= document.getElementById('daum_search').value;

		document.daummap_search_form.keyword.value			= search_keyword;
		document.daummap_search_form.daum_key.value			= daumMaps_Key;
		document.daummap_search_form.daum_local_key.value	= daumMaps_Local_Key;

		document.daummap_search_form.submit();

		document.getElementById('mapSearch').style.display	= '';
		ResizeParent();
	}

	function daum_data_loading2()
	{
		var search_keyword	= document.getElementById('daum_search2').value;

		document.daummap_search_form2.keyword.value			= search_keyword;
		document.daummap_search_form2.daum_key.value		= daumMaps_Key;
		document.daummap_search_form2.daum_local_key.value	= daumMaps_Local_Key;

		document.daummap_search_form2.submit();

		document.getElementById('mapSearch').style.display	= '';
		ResizeParent();

	}

	function daummap_move( xpoint, ypoint, zoomlevel )
	{
		if ( xpoint == '' || ypoint == '' )
		{
			alert('지역정보가 존재하지 않습니다.');
			return false;
		}

		zoomlevel	= zoomlevel == '' ? 13 : zoomlevel;
		
		mapObj.setLevel(zoomlevel);
		mapObj.setCenter(new daum.maps.LatLng(xpoint,ypoint));
		

		daummap_zoom_now();
	}

	var marker_add_check	= Array('','','','','','','','','','','','','','','','','','','','');
	var message_add_check	= Array('','','','','','','','','','','','','','','','','','','','');
	var markObj2			= Array();
	var messageObj2			= Array();

	function daummap_marker_add( no, title, xpoint, ypoint )
	{

		if ( marker_add_check[no] != '' && markObj2[no] != undefined )
		{
			markObj2[no].setMap(null);
		}
		if ( message_add_check[no] != '' && messageObj2[no] != undefined )
		{
			messageObj2[no].setMap(null);
			message_add_check[no]	= '';
		}

		if ( xpoint == '' || ypoint == '' )
		{
			return false;
		}

		marker_add_check[no]	= 'ok';

		var pointOmethod	= new daum.maps.LatLng(xpoint,ypoint);

		var markerImage = new daum.maps.MarkerImage(
			"images/pos_"+no+".png",
			new daum.maps.Size(24, 23)
		);

		markObj2[no] = new daum.maps.Marker({
			map				: mapObj,
			position		: pointOmethod,
			zIndex			: no,
			image			: markerImage
		});
		markObj2[no].setMap(mapObj);


		if ( title != '' )
		{
			message_add_check[no]	= 'ok';

			title	= "<table border='0' style='width:150px; border:1px dashed #909090; background:#fff;' cellspacing='0' cellpadding='0' height='30' ><tr><td style='padding:13px 10px 10px 10px; ' align='center'>"+title+"</td></tr></table>";
			
			messageObj2[no]	= new daum.maps.InfoWindow({
								content: title
			});

			daum.maps.event.addListener(markObj2[no], "click", function(e) {
				if (messageObj2[no].getMap()) {
					messageObj2[no].close();
				} else {
					messageObj2[no].open(mapObj, markObj2[no]);
				}
			});
		}

		if ( message_add_check[no] == 'ok' )
		{
		}
	}



	function daummap_zoom_now()
	{
		nowZoom		= parseInt(mapObj.getLevel());
		
		for ( var i = 1 ; i <= 14 ; i++ )
		{
			if ( nowZoom == i )
			{
				outHTML		= "<a href='#onClickZoom' onClick='mapObj.setLevel("+i+");daummap_zoom_now();' style='text-decoration:none;'><img src='images/btn_zoom_select.gif' border='0' width='22' height='12'></a>";
			}
			else
			{
				outHTML	= "<a href='#onClickZoom' onClick='mapObj.setLevel("+i+");daummap_zoom_now();' style='text-decoration:none;'><img src='images/btn_zoom_reverse_" + (-(i - 14)) + ".gif' border=0 width='22' height='12'></a>";
			}
			document.getElementById('zoomLayer'+ i).innerHTML	= outHTML;
		}
	}


	var markAddCheck		= false;
	var markIcon			= '';
	var markWidth			= 24;
	var markHeight			= 24;

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

		if (!markAddCheck)
		{
			daum.maps.event.addListener(mapObj, "click", addMarkEvent);
			markAddCheck  = true;
		}
	}

	function removeMark()
	{
		markAddCheck  = false;
	}

	function addMarkEvent(oCustomEvent)
	{
		var point	= oCustomEvent.latLng;

		markMessage	= document.daummap_form.markMessage.value;

		markAddListLen	= markAddWidthList.length+1000 ;
		//alert(markAddListLen);

		markAddWidthList[markAddListLen]	= markWidth;
		markAddHeightList[markAddListLen]	= markHeight;
		markAddPointList[markAddListLen]	= point;
		markAddUrlList[markAddListLen]		= markIcon;
		markAddShowList[markAddListLen]		= 'show';
		msgObj[markAddListLen]				= '';
		markObj[markAddListLen]				= '';

		var markerImage = new daum.maps.MarkerImage(
			markIcon,
			new daum.maps.Size(markWidth, markHeight)
		);

		markObj[markAddListLen] = new daum.maps.Marker({
			map				: mapObj,
			position		: point,
			zIndex			: markAddListLen,
			image			: markerImage
		});

		markObj[markAddListLen].setMap(mapObj); // 추가

		if ( markMessage != '' )
		{
			document.daummap_form.markMessage.value	= '';

			markAddMessageList[markAddListLen]	= markMessage;
			
			//infowindow로 사용시
			msgObj[markAddListLen] = new daum.maps.InfoWindow({
				content			: '<div style="min-width:150px; padding:8px; text-align:center;">'+markMessage+'</div>',
				position		: point,
				zIndex			: markAddListLen
			});

			msgObj[markAddListLen].open(mapObj, markObj[markAddListLen]);
			
			//overlay로 사용시
			/*
			msgObj[markAddListLen] = new daum.maps.CustomOverlay({
				map				: mapObj,
				clickable		: true,
				content			: '<div style="position:absolute;left:0;top:0;min-width:120px;height:30px;line-height:30px;text-align:center;background-color:#fff;border:2px solid #f00; padding:3px;">'+markMessage+'</div>',
				position		: point,
				xAnchor			: 1,
				yAnchor			: 1,
				zIndex			: markAddListLen
			});
			msgObj[markAddListLen].setMap(mapObj); // 추가
			*/
		}
		else
		{
			markAddMessageList[markAddListLen]	= '';
		}

		var no	= markAddListLen;
		deleteMark	= function() {
			
			if ( confirm('마크를 제거하시겠습니까?') )
			{
				//alert(no);return;
				markObj[no].setMap(null);
				if ( markAddMessageList[no] != '' ) {
					msgObj[no].close(); //infowindow로 사용시
					//msgObj[no].setMap(null); //overlay로 사용시
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
		daum.maps.event.addListener(markObj[markAddListLen], 'click', deleteMark);

		//맵에 걸린 이벤트 제거
		daum.maps.event.removeListener(mapObj, "click", addMarkEvent);
		
		removeMark();	
	}

	function removeMarkAll()
	{
		if ( confirm('모든 마커를 제거하시겠습니까?') )
		{
			for(var ma_key in markAddWidthList)
			{
				if(markObj[ma_key] != undefined)
				{
					markObj[ma_key].setMap(null);
				}

				if(msgObj[ma_key] != undefined)
				{
					if ( markAddMessageList[ma_key] != '' ) {
						msgObj[ma_key].close(); //infowindow로 사용시
						//msgObj[ma_key].setMap(null); //overlay로 사용시
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
		}
	}


	function daum_map_loading()
	{
		document.write( "<div id='mapContainer_"+nowTimeChk+"' style='width:"+daumMaps_Width+"px;height:"+daumMaps_Height+"px'></div>" );
		document.write( "<SC"+"RIPT LANGUAGE='JavaSc"+"ript'>" );

		document.write( "var latlng = new daum.maps.LatLng(daumMaps_CenterLat, daumMaps_CenterLng);");
		document.write( "mapObj	= new daum.maps.Map(document.getElementById('mapContainer_'+nowTimeChk), {");
		document.write( "		center					: latlng,");
		document.write( "		level					: daumMaps_Level,");
		document.write( "		scrollwheel				: daumMaps_scrollwheel,");
		document.write( "		draggable				: daumMaps_draggable,");
		document.write( "		disableDoubleClickZoom	: daumMaps_disableDoubleClickZoom,");
		document.write( "		mapTypeId 				: daum.maps.MapTypeId.ROADMAP");
		document.write( "});");

		document.write( "var zoomControl = new daum.maps.ZoomControl();");
		document.write( "mapObj.addControl(zoomControl, daum.maps.ControlPosition.TOPLEFT);"); //TOP / TOPLEFT / TOPRIGHT / LEFT / RIGHT / BOTTOMLEFT / BOTTOM / BOTTOMRIGHT

		document.write( "daum.maps.event.addListener(mapObj, 'zoom_changed', function() {");
		document.write( "	daummap_zoom_now();");
		document.write( "});");
		
		document.write( "mapObj.setMinLevel(daumMaps_minLevel);");
		document.write( "mapObj.setMaxLevel(daumMaps_maxLevel);");

		document.write( "daummap_zoom_now();" );
		document.write( "</SC"+"RIPT>" );

		document.daummap_form.daum_width.value	= daumMaps_Width;
		document.daummap_form.daum_height.value	= daumMaps_Height;
	}

	function daum_map_mark_loading()
	{
		markLen	= daumMaps_Mark_Name.length;


		//YOON: 2009-04-10
		document.write("<table border=0 cellspacing=0 cellpadding=0><tr>");

		for ( i=0 ; i<markLen ; i++ )
		{
			markName	= daumMaps_Mark_Name[i];
			markWidth	= daumMaps_Mark_Width[i];
			markHeight	= daumMaps_Mark_Height[i];

			markWidth	= ( markWidth == "" )? 24 : markWidth;
			markHeight	= ( markHeight == "" )? 24 : markHeight;

			document.write("<td width='30' align='center'><a href='#addmark' onClick=\"addMark('"+markName+"',"+markWidth+","+markHeight+")\"><img src='"+markName+"' border='0'></a></td>");
		}

		//YOON: 2009-04-10
		document.write("</tr></table>");
	}

