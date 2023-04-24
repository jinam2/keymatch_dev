<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<!-- 해피CGI 솔루션외 사용을 금합니다. -->
<html>
	<head>
		<title>Naver Map</title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
		<meta content="noindex, nofollow" name="robots">
		<script type="text/javascript" src="dialogue.js"></script>
	</head>
	<body style="OVERFLOW: hidden" scroll="no">


		<table border="0" cellspacing="0" cellpadding="0" align="center">
		<form name='navermap_search_form' target='mapSearchFrame' style='display:none' action='naversearch.php' onSubmit="return false">
			<input type='hidden' name='naver_key' value=''>
			<input type='hidden' name='keyword' value=''>
		</form>

		<form name='navermap_search_form2' target='mapSearchFrame' style='display:none' action='naversearch2.php' onSubmit="return false">
			<input type='hidden' name='naver_key' value=''>
			<input type='hidden' name='keyword' value=''>
		</form>
		<form name='navermap_form' onSubmit="return false">
		<tr>
			<td align="left" valign="middle" style="padding-bottom:10px;">

				<table width='100%' border=0 style='margin:5 0 5 0;'>
				<colgroup style="padding:0 10 0 0; text-align:right;"></colgroup>
				<colgroup></colgroup>
				<colgroup style="padding:0 10 0 0; text-align:right;"></colgroup>
				<colgroup></colgroup>
				<tr>
					<td width='90' style="color:white; background:url('images/bg_item.gif') no-repeat right 2;"><b>가로</b></td>
					<td colspan='3'>
					<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width=' 200'>
							<input type='text' name='naver_width' value='' size=4 style="height:22px; color:#3A9812; font-family:tahoma; font-size:12pt; font-weight:bold; text-align:right;" onKeyUp="navermap_resize()" onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'> px
						</td>
						<td width='90' style="color:white; background:url('images/bg_item.gif') no-repeat right 2;" align='right' style='padding:3 10 0 0;'><b>세로</b></td>
						<td style="padding:0 0 0 5;">
							<input type='text' name='naver_height' value='' size=4 style="height:22px; color:#3A9812; font-family:tahoma; font-size:12pt; font-weight:bold; text-align:right;" onKeyUp="navermap_resize()" onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;'> px
						</td>
					</tr>
					</table>
					</td>
				<tr>
				<tr>
					<td style="color:white; background:url('images/bg_item.gif') no-repeat right 2; padding-top:3;"><b>주소검색</b></td>
					<td colspan='3' >
						<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><input type='text' name='naver_search2' value='' size=100 onKeyPress="if ( event.keyCode() == 13 ){ event.returnValue=false; }"></td>
							<td style='padding:1 0 0 5;'><input type='image' src='images/btn_search.gif' onClick="naver_data_loading2()"></td>
						</tr>
						</table>
						<!-- <input type='button' value='검색' onClick="naver_data_loading2()"> -->
					</td>
				<tr>
				<tr>
					<td style="color:white; background:url('images/bg_item.gif') no-repeat right 2; padding-top:3;"><b>상호검색</b></td>
					<td colspan='3' >
						<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><input type='text' name='naver_search' value='' size=100></td>
							<td style='padding:1 0 0 5;'><input type='image' src='images/btn_search.gif' onClick="naver_data_loading()"></td>
						</tr>
						</table>
						<!-- <input type='button' value='검색' onClick="naver_data_loading()"> -->
					</td>
				<tr>
				<tr>
					<td style="color:white; background:url('images/bg_item.gif') no-repeat right 2; padding-top:3;"><b>줌설정</b></td>
					<td colspan='3' >
						<table border="0" cellspacing="2" cellpadding="0">
						<tr>
							<td style="padding:0 4 0 0;"><a href='#onClickZoom' onClick='mapObj.zoomOut();navermap_zoom_now();'><img src="images/btn_zoom_out.gif" border="0" title="축소"></a></td>
							<td><div id='zoomLayer12' title="0"></div></td>
							<td><div id='zoomLayer11' title="1"></div></td>
							<td><div id='zoomLayer10' title="2"></div></td>
							<td><div id='zoomLayer9' title="3"></div></td>
							<td><div id='zoomLayer8' title="4"></div></td>
							<td><div id='zoomLayer7' title="5"></div></td>
							<td><div id='zoomLayer6' title="6"></div></td>
							<td><div id='zoomLayer5' title="7"></div></td>
							<td><div id='zoomLayer4' title="8"></div></td>
							<td><div id='zoomLayer3' title="9"></div></td>
							<td><div id='zoomLayer2' title="10"></div></td>
							<td><div id='zoomLayer1' title="11"></div></td>
							<td><div id='zoomLayer0' title="12"></div></td>
							<td style="padding:0 0 0 4;"><a href='#onClickZoom' onClick='mapObj.zoomIn();navermap_zoom_now();'><img src="images/btn_zoom_in.gif" border="0" title="확대"></a></td>
						</tr>
						</table>
					</td>
				<tr>
				<tr>
					<td colspan="4" height='8' style="padding-left:15px;"><div style="height:1px; background-color:#AAA;"><div></div></div></td>
				</tr>
				<tr>
					<td style="color:white; background:url('images/bg_item.gif') no-repeat right 2; padding-top:1;"><b>마크아이콘</b></td>
					<td >
						<table border="0" cellspacing="1" cellpadding="0">
						<tr>
							<td><script type="text/javascript">naver_map_mark_loading();</script></td>
							<td style='padding-right:5px;'><a href='#markReset' onClick="removeMarkAll()"><img src="images/btn_reset.gif" border="0" alt="재설정"></a></td>
						</tr>
						</table>
					</td>
				<tr>
				<tr>
					<td style="color:white; background:url('images/bg_item.gif') no-repeat right 2; padding-top:3;"><b>마크메세지</b></td>
					<td >
						<input type='text' name='markMessage' value='' size=70>
					</td>
				<tr>
				<tr>
					<td style="color:#333; padding-top:3;" valign="top"><b>마크사용법</b></td>
					<td colspan='3'>
						<ol style='margin:0 0 0 25;'>
							<li> 마크메세지에서 입력후 마크아이콘을 선택하세요.<br>
							<li> 네이버맵의 원하시는 위치에 클릭하시면 마크가 추가됩니다.<br>
							<li> 마크의 제거는 등록된 마크를 클릭하시고 예를 선택해주시면 됩니다.
						</ol>
					</td>
				</tr>
				<tr>
					<td colspan="4" height='8' style="padding-left:15px;"><div style="height:1px; background-color:#AAA;"><div></div></div></td>
				</tr>

				<tr>
					<td style="color:white; background:url('images/bg_item.gif') no-repeat right 2; padding-top:2;"><b>저장옵션</b></td>
					<td colspan="3">
						<input type="checkbox" name="save_Btn" value="1" id="save_Btn_id" checked><label for="save_Btn_id" style="cursor:hand">저장버튼</label>
						<input type="checkbox" name="save_Index" value="1" id="save_index_id"><label for="save_index_id" style="cursor:hand">미니맵</label>
						<input type="checkbox" name="save_Zoom" value="1" id="save_Zoom_id" checked><label for="save_Zoom_id" style="cursor:hand">줌버튼</label>
						<input type="checkbox" name="save_Wheel" value="1" id="save_Wheel_id" checked><label for="save_Wheel_id" style="cursor:hand">휠기능(줌버튼 사용시)</label>
					</td>
				<tr>
				<tr>
					<td colspan="4" height='8'></td>
				</tr>
				</table>
			</td>
		</tr>
		</form>
		<tr>
			<td align="center" valign="middle" style="padding-bottom:10px;">
				<table height="100%" border="1" cellspacing="3" cellpadding="0" bgcolor="#3A9812" style="margin:0 6 0 6;">
				<tr bgcolor="white">
					<td align='top'>
						<div align='top' id='mapSearch' width='200' height='100%' style='display:none'><iframe id='mapSearchFrame' name='mapSearchFrame' width='200' height='100%' frameborder='0'></iframe></div>
					</td>
					<td>
						<script type="text/javascript">naver_map_loading();</script>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>


	</body>
</html>
