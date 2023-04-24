<? /* Created by SkyTemplate v1.1.0 on 2023/04/19 15:37:29 */
function SkyTpl_Func_2245914039 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="search_title">
<tr>
	<td style="letter-spacing:-1.2px"><strong class="font_20 noto500" style="color:#333;"><span style="color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['검색분야']?></span> 검색결과</strong></td>
	<td align="right"><a href="http://developer.naver.com/wiki/pages/OpenAPI" target="_blank"><img src="img/powered_naver_api.gif" alt="NAVER OpenAPI" border="0"/></a></td>
</tr>
<tr>
	<td height="5px"></td>
</tr>
<tr>
	<td colspan="2" style="background-color:#D9D9D9;" height="1px" width="100%"></td>
</tr>
</table>


<div style="padding:5px"></div>



<table width='100%'>
<tr>
	<td width='350' valign='top'>


		<!--<SCRIPT LANGUAGE="JavaScript" src="http://maps.naver.com/js/naverMap.naver?key=<?=$_data['naver_key']?>"></SCRIPT>-->
		<SCRIPT LANGUAGE="JavaScript" src="//openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=<?=$_data['naver_key']?>&submodules=geocoder"></SCRIPT>


		<div id='happy_map_mapContainer' style="position:relative; border-style:solid; color:#5a6fe2; border-width:2;"></div><!-- 네이버맵 구동을 위한 필수 레이어 -->
		</center>


		<!--반듯이 존재해야하는 지도추출용 script -->
			<SCRIPT LANGUAGE="JavaScript">
		<!--
			var happy_map_ie					= '';
			if ( navigator.userAgent.match(/MSIE/) )
			{
				happy_map_ie						= '1';
			}

			var happy_map_my_point_x			= <?=$_data['member_near_xpoint']?>;
			var happy_map_my_point_y			= <?=$_data['member_near_ypoint']?>;
			var happy_map_default_x				= happy_map_my_point_x;
			var happy_map_default_y				= happy_map_my_point_y;

			var happy_map_my_point_interval		= 400;		// 이벤트 발생후 실행시간 (micro second)
			var happy_map_my_point_interval2	= 1200;		// 위로 아래로 등의 버튼 클릭시 실행시간 (micro second)
			var happy_map_my_point_obj			= '';
			var happy_map_my_point_chk			= '';

			var happy_map_width					= 340;
			var happy_map_height				= 460;
			var happy_map_small_size			= happy_map_width > happy_map_height ? happy_map_width : happy_map_height;

			var happy_map_iconUrl				= 'img/map_here.gif';
			var happy_map_iconUrl_width			= 30;
			var happy_map_iconUrl_height		= 30;

			var happy_map_addMaryObj			= Array();
			var happy_map_messageObj			= Array();
			var happy_map_messageObj_last_view	= '';

			var happy_map_setZoom_timer			= 1500;
			var happy_map_setZoom_level			= 14;
			var happy_map_setZoom_obj			= '';

			var happy_map_start_loading			= 'no';

			var happy_map_search_si_map_size	= 9;		// 지역검색후 지역으로 이동이 되면서 축척이 몇으로 될것인가?


			document.getElementById('happy_map_mapContainer').style.width	= happy_map_width;
			document.getElementById('happy_map_mapContainer').style.height	= happy_map_height;

			/* v2
			var oSeoulCityPoint = new nhn.api.map.LatLng(happy_map_my_point_x, happy_map_my_point_y);
			var defaultLevel = happy_map_search_si_map_size;
			var oMap = new nhn.api.map.Map(document.getElementById('happy_map_mapContainer'), {
							point : oSeoulCityPoint,
							zoom : defaultLevel,
							enableWheelZoom : true,
							enableDragPan : true,
							enableDblClickZoom : false,
							mapMode : 0,
							activateTrafficMap : false,
							activateBicycleMap : false,
							minMaxLevel : [ 1, 14 ],
							size : new nhn.api.map.Size(happy_map_width, happy_map_height)		});

			oMap.setMoveMapThresholdPixel(5);	// 마우스 이동을 위해 최소로 이동이 될 pixel. 1보다 낮은수로 하는 경우 클릭시 마크 클릭이벤트에 반응하므로 5이상 세팅 권장


			var oSlider = new nhn.api.map.ZoomControl();
			oMap.addControl(oSlider);
			oSlider.setPosition({
				top : 10,
				left : 10
			});

			var oMapTypeBtn = new nhn.api.map.MapTypeBtn();
			oMap.addControl(oMapTypeBtn);
			oMapTypeBtn.setPosition({
				bottom : 10,
				right : 80
			});

			var oThemeMapBtn = new nhn.api.map.ThemeMapBtn();
			oThemeMapBtn.setPosition({
				bottom : 10,
				right : 10
			});
			oMap.addControl(oThemeMapBtn);
			*/


			var oSeoulCityPoint = new naver.maps.LatLng(happy_map_my_point_x, happy_map_my_point_y);
			var defaultLevel = happy_map_search_si_map_size;
			var oMap = new naver.maps.Map(document.getElementById('happy_map_mapContainer'), {
							mapTypeId : naver.maps.MapTypeId.NORMAL,	//지도유형(NORMAL:일반,SATELLITE:위성,HYBRID:겹칩,TERRAIN :지형도)
							center : oSeoulCityPoint,
							zoom : defaultLevel,
							minZoom					: 1,							//지도의 최소 줌 레벨
							maxZoom					: 14,							//지도의 최대 줌 레벨
							scrollWheel : true,
							draggable : true,
							disableDoubleClickZoom : false,
							size : new naver.maps.Size(happy_map_width, happy_map_height)		});


			oMap.setOptions({
									mapTypeControl: true,
									MapTypeControlOptions: {
										style: naver.maps.MapTypeControlStyle.DROPDOWN,
										position: naver.maps.Position.TOP_RIGHT
									}
								});

			oMap.setOptions({
									zoomControl: true,
									zoomControlOptions: {
										position: naver.maps.Position.TOP_LEFT
									}
								});



			var happy_map_mapObj	= oMap;




			// naver 지도 2.0 부터는 각각 mark에 이벤트 핸들러를 거는것이 아니라,
			// 지도 자체에 이벤트 핸들러를 걸도록 되어 있는 상황이라 mark_add 함수에서 제거하고 맵 이벤트로 등록
			/*
			happy_map_mapObj.attach('click', function(oCustomEvent) {
				var oPoint	= oCustomEvent.point;
				var oTarget = oCustomEvent.target;

				//alert('마커 ' + oCustomEvent.target.getTitle() + '를 클릭했습니다');
				//return;
				// 마커 클릭하면
				if (oTarget instanceof nhn.api.map.Marker) {

					var getZIndex	= oTarget.getZIndex();

					// 겹침 마커 클릭한거면
					if (oCustomEvent.clickCoveredMarker) {
						//return;
					}



					if ( happy_map_messageObj_last_view != '' )
					{
						happy_map_messageObj[happy_map_messageObj_last_view].setVisible(false);
					}
					happy_map_messageObj_last_view	= getZIndex;

					happy_map_messageObj[getZIndex].setPoint(oTarget.getPoint());
					happy_map_messageObj[getZIndex].setPosition({right : 0, top : 0});
					happy_map_messageObj[getZIndex].setVisible(true);
					happy_map_messageObj[getZIndex].autoPosition();
					return;

				}

			});
			*/

			// naver 지도 v3 부터는 다시 v1 과 마찬가지로 mark_add함수에서 이벤트로 등록됨






			function happy_map_my_point_center()
			{
				happy_map_mapObj.setCenter(new naver.maps.LatLng(happy_map_my_point_x,happy_map_my_point_y));
				happy_map_mapObj.setZoom(happy_map_search_si_map_size);
			}




			var mark_objs1	= '';
			var mark_objs2	= '';
			var mark_objs3	= '';
			var mark_objs4	= '';
			var mark_objs5	= '';
			var mark_objs6	= '';
			var mark_objs7	= '';
			var mark_objs8	= '';
			var mark_objs9	= '';
			var wgs_check	= Array();

			function happy_map_markAdd_ALL()
			{
				mark_objs1		= document.getElementsByName('happy_map_mark_data1');
				mark_objs2		= document.getElementsByName('happy_map_mark_data2');
				mark_objs3		= document.getElementsByName('happy_map_mark_data3');
				mark_objs4		= document.getElementsByName('happy_map_mark_data4');
				mark_objs5		= document.getElementsByName('happy_map_mark_data5');
				mark_objs6		= document.getElementsByName('happy_map_mark_data6');
				mark_objs7		= document.getElementsByName('happy_map_mark_data7');
				mark_objs8		= document.getElementsByName('happy_map_mark_data8');
				mark_objs9		= document.getElementsByName('happy_map_mark_data9');

				//alert(mark_objs.length);


				wgs_check['x_min']	= 999999;
				wgs_check['x_max']	= 0;
				wgs_check['y_min']	= 999999;
				wgs_check['y_max']	= 0;

				wgs_check['x_sum']	= 0;
				wgs_check['y_sum']	= 0;

				for ( z=0 ; z < mark_objs1.length ; z++ )
				{

					if ( wgs_check['x_min'] > mark_objs5[z].value )
					{
						wgs_check['x_min']	= mark_objs5[z].value;
					}

					if ( wgs_check['y_min'] > mark_objs6[z].value )
					{
						wgs_check['y_min']	= mark_objs6[z].value;
					}

					if ( wgs_check['x_max'] < mark_objs5[z].value )
					{
						wgs_check['x_max']	= mark_objs5[z].value;
					}

					if ( wgs_check['y_max'] < mark_objs6[z].value )
					{
						wgs_check['y_max']	= mark_objs6[z].value;
					}
				}

				//alert(wgs_check['x_min']+' , '+wgs_check['y_min']+' , '+wgs_check['x_max']+' , '+wgs_check['y_max']);

				wgs_check['x_min']		= parseInt(wgs_check['x_min']);
				wgs_check['y_min']		= parseInt(wgs_check['y_min']);
				wgs_check['x_max']		= parseInt(wgs_check['x_max']);
				wgs_check['y_max']		= parseInt(wgs_check['y_max']);

				wgs_check['x_sum']		= wgs_check['x_min'] + ( (wgs_check['x_max'] - wgs_check['x_min']) / 2 );
				wgs_check['y_sum']		= wgs_check['y_min'] + ( (wgs_check['y_max'] - wgs_check['y_min']) / 2 );

				/* v2
				var tm_point		= new nhn.api.map.TM128(wgs_check['x_sum'],wgs_check['y_sum']);
				var l_point			= String(tm_point.toLatLng());
				var l_point_split	= l_point.split(",");
				happy_map_mapObj.setCenterAndLevel(new nhn.api.map.LatLng(l_point_split[1],l_point_split[0]) ,happy_map_search_si_map_size);
				*/

				var tm_point		= new naver.maps.Point(wgs_check['x_sum'],wgs_check['y_sum']);
				var l_point			= new naver.maps.TransCoord.fromTM128ToLatLng(tm_point);

				happy_map_mapObj.setCenter(new naver.maps.LatLng(l_point.y,l_point.x));
				happy_map_mapObj.setZoom(happy_map_search_si_map_size);



				for ( z=0 ; z < mark_objs1.length ; z++ )
				{
					//alert(mark_objs1[z].value);

					happy_map_markAdd(
										mark_objs1[z].value,
										mark_objs2[z].value,
										mark_objs3[z].value,
										mark_objs4[z].value,
										mark_objs5[z].value,
										mark_objs6[z].value,
										mark_objs7[z].value,
										mark_objs8[z].value,
										document.getElementById('happy_map_info_window_'+mark_objs9[z].value).innerHTML
					);
				}

				if ( document.getElementById('happy_map_paging') != undefined && document.getElementById('happy_map_paging_tmp') != undefined)
				{
					document.getElementById('happy_map_paging').innerHTML	= document.getElementById('happy_map_paging_tmp').innerHTML;
				}

				if ( document.getElementById('happy_map_total_count') != undefined && document.getElementById('happy_map_total_count_tmp') != undefined)
				{
					document.getElementById('happy_map_total_count').innerHTML	= "업체리스트 검색결과 <b><font color='red'>"+ document.getElementById('happy_map_total_count_tmp').value +"개</font></b> 검색";
				}

				happy_map_markAdd_ALL_Chk	= '';
			}


			var happy_map_markAdd_ALL_Chk	= '';
			function happy_map_markAdd_ALL_Call(callTime)
			{
				if ( happy_map_markAdd_ALL_Chk == '' )
				{
					happy_map_markAdd_ALL_Chk	= setTimeout("happy_map_markAdd_ALL()", callTime);
				}
			}




			function happy_map_markAdd(numb, icon, icon_w, icon_h, x_point, y_point, distance, ajax_map_num, infoWindowHtml)
			{
				//happy_map_mapObj.setZoom( happy_map_distance_call_naver(happy_map_mapObj.getWidth(), distance) );
				if ( numb == 1 )
				{
					happy_map_markRemoveAll();
				}

				if ( numb == 1 && ajax_map_num != 0 )
				{
					//happy_map_my_point_center();
				}

				/* v2
				var tm_point				= new nhn.api.map.TM128(x_point,y_point);
				var l_point					= String(tm_point.toLatLng());
				var l_point_split			= l_point.split(",");
				var distance_check			= new nhn.api.map.LatLng(l_point_split[1], l_point_split[0]);

				var tm_point2				= new nhn.api.map.TM128(wgs_check['x_sum'],wgs_check['y_sum']);
				var l_point2				= String(tm_point2.toLatLng());
				var l_point_split2			= l_point2.split(",");
				var distance_check2			= new nhn.api.map.LatLng(l_point_split2[1],l_point_split2[0]);
				*/

				var tm_point				= new naver.maps.Point(x_point,y_point);
				var l_point					= new naver.maps.TransCoord.fromTM128ToLatLng(tm_point);
				var distance_check			= new naver.maps.LatLng(l_point.y, l_point.x);


				var tm_point2				= new naver.maps.Point(wgs_check['x_sum'],wgs_check['y_sum']);
				var l_point2				= new naver.maps.TransCoord.fromTM128ToLatLng(tm_point2);
				var distance_check2			= new naver.maps.LatLng(l_point2.y,l_point2.x);

				//var distance				= distance_check.getDistanceFrom(distance_check2); //v2
				var distance				= happy_map_mapObj.getProjection().getDistance(distance_check,distance_check2);


				happy_map_distance_call_naver(happy_map_small_size, distance);


				happy_map_iconUrl = icon;
				//happy_map_addMaryObj[numb] = new NMark(new NPoint(x_point,y_point),new NIcon(happy_map_iconUrl,new NSize(icon_w,icon_h)));
				//happy_map_mapObj.addOverlay(happy_map_addMaryObj[numb]);

				/* v2
				var oSize = new nhn.api.map.Size(icon_w, icon_h);
				//var oOffset = new nhn.api.map.Size(14, 37);
				var oIcon = new nhn.api.map.Icon(happy_map_iconUrl, oSize, '');

				var marker_point	= l_point_split[1]+","+l_point_split[0];
				var oMarker = new nhn.api.map.Marker(oIcon, { title : '마커 : ' + marker_point.toString(),zIndex : numb });
				oMarker.setPoint(new nhn.api.map.LatLng(l_point_split[1],l_point_split[0]));
				happy_map_mapObj.addOverlay(oMarker);
				*/


				var markerOptions = {
					map: happy_map_mapObj,
					position: new naver.maps.LatLng(l_point.y,l_point.x),
					zIndex: numb,
					icon: {
						url: happy_map_iconUrl
						//size: new naver.maps.Size(24, 23)
					}
				};
				happy_map_addMaryObj[numb] = new naver.maps.Marker(markerOptions);
				happy_map_addMaryObj[numb].setMap(happy_map_mapObj); // 추가



				/*
				happy_map_messageObj[numb]	= new NInfoWindow();
				happy_map_messageObj[numb].set(new NPoint(x_point,y_point),infoWindowHtml);
				happy_map_mapObj.addOverlay(happy_map_messageObj[numb]);

				happy_map_messageObj[numb].setOpacity(1);
				*/

				/* v2
				happy_map_messageObj[numb] = new nhn.api.map.InfoWindow();
				happy_map_messageObj[numb].setVisible(false);
				happy_map_messageObj[numb].setPoint(new nhn.api.map.LatLng(l_point_split[1],l_point_split[0]));
				happy_map_mapObj.addOverlay(happy_map_messageObj[numb]);

				happy_map_messageObj[numb].setContent(infoWindowHtml);

				happy_map_messageObj[numb].setOpacity(1);


				NEvent.addListener(
						happy_map_addMaryObj[numb]
					,
						"click"
					,
						function()
						{
							happy_map_view_info(numb);
						}
				);
				*/



				happy_map_messageObj[numb] = new naver.maps.InfoWindow({
					content: infoWindowHtml
				});

				naver.maps.Event.addListener(happy_map_addMaryObj[numb], "click", function(e) {
					/*
					if (happy_map_messageObj[numb].getMap()) {
						happy_map_messageObj[numb].close();
					} else {
						happy_map_messageObj[numb].open(happy_map_mapObj, happy_map_addMaryObj[numb]);
					}
					*/
					happy_map_view_info(numb);
				});



				if ( document.getElementById('happy_map_paging') != undefined && document.getElementById('happy_map_paging_tmp') != undefined)
				{
					document.getElementById('happy_map_paging').innerHTML	= document.getElementById('happy_map_paging_tmp').innerHTML;
				}
			}


			function happy_map_view_info( numb )
			{
				if ( happy_map_messageObj_last_view == numb )
				{
					//happy_map_messageObj[numb].hideWindow();
					//happy_map_messageObj[numb].setVisible(false); //v2
					happy_map_messageObj[numb].close();
					happy_map_messageObj_last_view	= '';
				}
				else
				{
					if ( happy_map_messageObj_last_view != '' )
					{
						//happy_map_messageObj[happy_map_messageObj_last_view].hideWindow();
						//happy_map_messageObj[happy_map_messageObj_last_view].setVisible(false); //v2
						happy_map_messageObj[happy_map_messageObj_last_view].close();
					}
					//happy_map_messageObj[numb].showWindow();
					//happy_map_messageObj[numb].setVisible(true); //v2
					happy_map_messageObj[numb].open(happy_map_mapObj,happy_map_addMaryObj[numb]);
					happy_map_messageObj_last_view	= numb;
				}
			}


			function happy_map_markRemoveAll()
			{
				happy_map_infoWindowRemove();

				/*
				for ( i=0 ; i<30 ; i++ )
				{
					if ( happy_map_addMaryObj[i] != undefined )
					{
						happy_map_mapObj.removeOverlay(happy_map_addMaryObj[i]);
					}
				}
				*/

				//happy_map_mapObj.clearOverlay(); //v2

				for ( i=0 ; i<30 ; i++ )
				{
					if ( happy_map_addMaryObj[i] != undefined )
					{
						happy_map_addMaryObj[i].setMap(null);
					}
				}
			}


			function happy_map_infoWindowRemove()
			{
				if ( happy_map_messageObj_last_view != '' )
				{
					//happy_map_messageObj[happy_map_messageObj_last_view].hideWindow();
					//happy_map_messageObj[happy_map_messageObj_last_view].setVisible(false); //v2
					happy_map_messageObj[happy_map_messageObj_last_view].close();
					happy_map_messageObj_last_view	= '';
				}
			}

			// 0 : 25
			// 1 : 50
			// 2 : 100
			// 3 : 200
			// 4 : 400

			// 14 : 12.5
			// 13 : 25
			// 12 : 50
			function happy_map_distance_call_naver(map_size, distance)
			{
				one_block_size	= Math.floor(map_size / 100);
				map_block_size	= distance/one_block_size;
				map_block_size	= map_block_size - ( map_block_size * 0.19 ) ;
				//alert(distance);


				for ( i=14, happy_map_setZoom_level=14, chk=12.5 ; i>=1 ; i--, chk *= 2 )
				{
					//alert(chk +' : '+ map_block_size);
					if ( chk > map_block_size || i == 1)
					{
						//alert(i);
						if ( happy_map_setZoom_level != 0 )
						{
							clearTimeout(happy_map_setZoom_obj);
						}

						if ( happy_map_setZoom_level >= i )
						{
							happy_map_setZoom_level	= i-1;
						}

						happy_map_setZoom_obj	= setTimeout("happy_map_setZoom()", happy_map_setZoom_timer);
						break;
					}
				}

			}


			function happy_map_setZoom()
			{
				//alert(happy_map_setZoom_level);
				//happy_map_mapObj.setLevel(happy_map_setZoom_level); v2
				happy_map_mapObj.setZoom(happy_map_setZoom_level);
			}



		//-->
			</SCRIPT>
			<!--반듯이 존재해야하는 지도추출용 script -->
	</td>

	<td valign='top' style="border:0px solid red;">
		<?=$_data['내용']?>

	</td>
</tr>
</table>


<div style="padding-top:5px;"></div>

<div style="text-align:right; padding:10px 0; border-top:1px solid #eaeaea">
	<a href="<?=$_data['더보기링크']?>" style="color:#666666">
	검색결과 더보기 <img src="img/search_plus_03.png" align="absmiddle" alt="더많은검색결과" style="vertical-align:middle">
	</a>
</div>



<div style="padding-top:30px;"></div>


<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>
<? }
?>