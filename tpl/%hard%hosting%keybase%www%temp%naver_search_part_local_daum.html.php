<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:07 */
function SkyTpl_Func_74725606 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="search_title">
<tr>
	<td style="letter-spacing:-1.2px"><strong class="font_18 noto400"><span style="color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['검색분야']?></span> 검색결과</strong></td>
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


		<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?=$_data['daum_key']?>&libraries=services"></script>


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

			var happy_map_my_point_x			= '<?=$_data['member_near_xpoint']?>';
			var happy_map_my_point_y			= '<?=$_data['member_near_ypoint']?>';
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


			document.getElementById('happy_map_mapContainer').style.width	= happy_map_width + 'px';
			document.getElementById('happy_map_mapContainer').style.height	= happy_map_height + 'px';


			var oSeoulCityPoint = new daum.maps.LatLng(happy_map_my_point_x, happy_map_my_point_y);
			var defaultLevel = happy_map_search_si_map_size;
			var oMap = new daum.maps.Map(document.getElementById('happy_map_mapContainer'), {
							mapTypeId : daum.maps.MapTypeId.ROADMAP,	//지도유형(ROADMAP:일반,SKYVIEW:스카이뷰,HYBRID:겹칩)
							center : oSeoulCityPoint,
							level : defaultLevel,
							scrollWheel : true,
							draggable : true,
							disableDoubleClickZoom : false
			});

			oMap.setMinLevel(1); //지도의 최소 줌 레벨(기본 1)
			oMap.setMaxLevel(14); //지도의 최대 줌 레벨(기본 14)

			var mapTypeControl = new daum.maps.MapTypeControl();
			oMap.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);

			var zoomControl = new daum.maps.ZoomControl();
			oMap.addControl(zoomControl, daum.maps.ControlPosition.TOPLEFT);

			var happy_map_mapObj	= oMap;

			function happy_map_my_point_center()
			{
				happy_map_mapObj.setCenter(new daum.maps.LatLng(happy_map_my_point_x,happy_map_my_point_y));
				happy_map_mapObj.setLevel(happy_map_search_si_map_size);
			}

			var wgs_data	= Array();
			wgs_data['lat']	= Array();
			wgs_data['lng']	= Array();

			var geoCoder	= new daum.maps.services.Geocoder();

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

				wgs_check['x_min']		= parseFloat(wgs_check['x_min']);
				wgs_check['y_min']		= parseFloat(wgs_check['y_min']);
				wgs_check['x_max']		= parseFloat(wgs_check['x_max']);
				wgs_check['y_max']		= parseFloat(wgs_check['y_max']);

				wgs_check['x_sum']		= wgs_check['x_min'] + ( (wgs_check['x_max'] - wgs_check['x_min']) / 2 );
				wgs_check['y_sum']		= wgs_check['y_min'] + ( (wgs_check['y_max'] - wgs_check['y_min']) / 2 );

				happy_map_mapObj.setCenter(new daum.maps.LatLng(wgs_check['x_sum'],wgs_check['y_sum']));
				happy_map_mapObj.setLevel(happy_map_search_si_map_size);


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
				if ( numb == 1 )
				{
					happy_map_markRemoveAll();
				}

				if ( numb == 1 && ajax_map_num != 0 )
				{
					//happy_map_my_point_center();
				}

				var distanceCheck		= new daum.maps.LatLng(x_point,y_point);
				var distanceCheck2		= new daum.maps.LatLng(wgs_check['x_sum'],wgs_check['y_sum']);

				var distancePosition	= Array(distanceCheck,distanceCheck2);

				var distanceLine		= new daum.maps.Polyline({
					map: happy_map_mapObj, // 선을 표시할 지도입니다 
					path: [distancePosition], // 선을 구성하는 좌표 배열입니다 클릭한 위치를 넣어줍니다
					strokeWeight: 0, // 선의 두께입니다 
					strokeColor: '#db4040', // 선의 색깔입니다
					strokeOpacity: 0, // 선의 불투명도입니다 0에서 1 사이값이며 0에 가까울수록 투명합니다
					strokeStyle: 'solid' // 선의 스타일입니다
				});

				var distance			= Math.round(distanceLine.getLength());

				happy_map_distance_call_daum(happy_map_small_size, distance);
				

				happy_map_iconUrl			= icon;
				happy_map_iconUrl_width		= icon_w;
				happy_map_iconUrl_height	= icon_h;

				var markerPoint		= new daum.maps.LatLng(x_point,y_point);

				var markerImage		= new daum.maps.MarkerImage(
					happy_map_iconUrl,
					new daum.maps.Size(happy_map_iconUrl_width, happy_map_iconUrl_height)
				);

				var markerOptions = {
					map: happy_map_mapObj,
					position: markerPoint,
					zIndex: numb,
					image: markerImage
				};
				happy_map_addMaryObj[numb] = new daum.maps.Marker(markerOptions);
				happy_map_addMaryObj[numb].setMap(happy_map_mapObj); // 추가

				happy_map_messageObj[numb] = new daum.maps.InfoWindow({
					content: infoWindowHtml,
					position: markerPoint,
					zIndex: numb
				});

				daum.maps.event.addListener(happy_map_addMaryObj[numb], "click", function(e) {
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
					happy_map_messageObj[numb].close();
					happy_map_messageObj_last_view	= '';
				}
				else
				{
					if ( happy_map_messageObj_last_view != '' )
					{
						happy_map_messageObj[happy_map_messageObj_last_view].close();
					}

					happy_map_messageObj[numb].open(happy_map_mapObj,happy_map_addMaryObj[numb]);
					happy_map_messageObj_last_view	= numb;
				}
			}


			function happy_map_markRemoveAll()
			{
				happy_map_infoWindowRemove();

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
			var daum_map_block_size	= Array(20,30,50,100,250,500,1000,2000,4000,8000,16000,32000,64000,128000);

			function happy_map_distance_call_daum(map_size, distance)
			{
				one_block_size	= Math.floor(map_size / 100);
				map_block_size	= distance/one_block_size;
				//map_block_size	= map_block_size - ( map_block_size * 0.19 ) ;
				
				//for ( i=1, happy_map_setZoom_level=1, chk=25 ; i<=14 ; i++, chk *= 2 )
				for ( i=1, happy_map_setZoom_level=1 ; i <= 14 ; i++ )
				{
					chk = daum_map_block_size[i-1];

					//console.log(chk + ' > ' + map_block_size +' : '+ i);
					if ( chk > map_block_size || i == 14)
					{
						//console.log(happy_map_setZoom_level + ' : ' + i);
						//alert(i);
						if ( happy_map_setZoom_level != 0 )
						{
							clearTimeout(happy_map_setZoom_obj);
						}

						if ( happy_map_setZoom_level <= i )
						{
							happy_map_setZoom_level	= i+1;
						}

						happy_map_setZoom_obj	= setTimeout("happy_map_setZoom()", happy_map_setZoom_timer);
						break;
					}
				}

			}


			function happy_map_setZoom()
			{
				happy_map_mapObj.setLevel(happy_map_setZoom_level);
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


 <div style="padding-top:10px;"></div>


<div style="text-align:right; padding:10px 0; border-top:1px solid #eaeaea">
	<a href="<?=$_data['더보기링크']?>" style="color:#666666">
	검색결과 더보기 <img src="img/search_plus_03.png" align="absmiddle" alt="더많은검색결과" style="vertical-align:middle">
	</a>
</div>



<div style="padding-top:30px;"></div>


<script>all_search_result = 'ok'; // 검색결과 나왔다는 확인용 변수값에 ok값 넣기</script>
<? }
?>