<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_2066801271 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<table width='100%' style="border:0px solid red;">
<tr>
	<td valign='top'>
		<table width='100%'>
		<tr>
			<td width='30' align='center'>
				<a href="javascript:happy_map_view_info( <?=$_data['Count']?> ); happy_map_mapObj.setCenter(new daum.maps.LatLng(<?=$_data['Data']['x_point']?>,<?=$_data['Data']['y_point']?>));happy_map_mapObj.setLevel(8)"><img src='img/map/lpos_<?=$_data['Count']?>_6.png' width="18" height="28" border='0' align='absmiddle' class="png24" __onLoad="happy_map_markAdd(<?=$_data['Count']?>, 'img/map/lpos_<?=$_data['Count']?>_6.png',18 ,28 , '<?=$_data['Data']['x_point']?>', '<?=$_data['Data']['y_point']?>', 0,<?=$_data['Data']['Count']?>, document.getElementById('happy_map_info_window_<?=$_data['Count']?>').innerHTML)" onLoad="happy_map_markAdd_ALL_Call(1000)" ></a>
			</td>
			<td>
				<div style="float:left; margin-right:5px;"><a href="http://map.naver.com/?query=<?=$_data['Data']['address_link']?>" target="_blank"><u><?=$_data['Data']['title']?></u></a></div><div style="float:left;"><a href="http://map.naver.com/?query=<?=$_data['Data']['address_link']?>" target="_blank"><img src='img/icon_naver_load.gif' border='0' align='absmiddle'></a></div>
				
				<div style="padding-top:3px; clear:both;"></div>

				<font color='orange'><?=$_data['Data']['telephone']?></font>
				<?=$_data['Data']['address']?>

			</td>
		</tr>
		</table>
	</td>
</tr>
</table>



<input type='hidden' id='happy_map_mark_data1' name='happy_map_mark_data1' value='<?=$_data['Count']?>'>
<input type='hidden' id='happy_map_mark_data2' name='happy_map_mark_data2' value='img/map/lpos_<?=$_data['Count']?>_6.png'>
<input type='hidden' id='happy_map_mark_data3' name='happy_map_mark_data3' value='18'>
<input type='hidden' id='happy_map_mark_data4' name='happy_map_mark_data4' value='28'>
<input type='hidden' id='happy_map_mark_data5' name='happy_map_mark_data5' value='<?=$_data['Data']['x_point']?>'>
<input type='hidden' id='happy_map_mark_data6' name='happy_map_mark_data6' value='<?=$_data['Data']['y_point']?>'>
<input type='hidden' id='happy_map_mark_data7' name='happy_map_mark_data7' value='0'>
<input type='hidden' id='happy_map_mark_data8' name='happy_map_mark_data8' value='<?=$_data['Data']['Count']?>'>
<input type='hidden' id='happy_map_mark_data9' name='happy_map_mark_data9' value='<?=$_data['Count']?>'>



<!-- 맵상에 표시될 정보 HTML편집 -->
<div id='happy_map_info_window_<?=$_data['Count']?>' style='display:none;'>

	<table align="center" cellpadding="0" cellspacing="1" bgcolor="#bababa" >
	<tr>
		<td bgcolor="#FFFFFF" style="padding:7px;">

			<table align="center" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="smfont3"><img src='img/map/lpos_<?=$_data['Count']?>_1.png' width="18" height="28" border='0' align='absmiddle'  class="png24"> <b><a href="http://map.naver.com/?query=<?=$_data['Data']['address_link']?>" target="_blank"><?=$_data['Data']['title']?></a></td>
				<td align="right"><img src="img/btn_scrap_del2.gif" border="0" align="absmiddle" onClick="happy_map_infoWindowRemove()" style="cursor:pointer; margin-left:5px;"></td>
			</tr>

			<tr>
				<td height="5"></td>
			</tr>
			<tr>
				<td height="1" bgcolor="#c1c1c1" colspan="2"></td>
			</tr>
			</table>

			<div style="padding:5px;"></div>

			<table align="center" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>

					<font class="smfont3"><?=$_data['Data']['address']?></font>
					<div style="padding:2px;"></div>
					<font color='oragne'><?=$_data['Data']['telephone']?></font>

				</td>
			</tr>
			</table>

		</td>
	</tr>
	</table>

</div>
<!-- 맵상에 표시될 정보 HTML편집 -->
<? }
?>