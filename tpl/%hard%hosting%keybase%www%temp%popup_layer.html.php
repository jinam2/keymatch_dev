<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:32:42 */
function SkyTpl_Func_139263911 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript1.2">
<!--
var x =0
var y=0
drag = 0
move = 0
window.document.onmousemove = mouseMove
window.document.onmousedown = mouseDown
window.document.onmouseup = mouseUp
window.document.ondragstart = mouseStop
var dragObj;
function mouseUp() {
move = 0
}
function mouseDown() {
if (drag) {
clickleft = window.event.x - parseInt(dragObj.style.left)
clicktop = window.event.y - parseInt(dragObj.style.top)
dragObj.style.zIndex += 1
move = 1
}
}
function mouseMove() {
if (move) {
dragObj.style.left = window.event.x - clickleft
dragObj.style.top = window.event.y - clicktop
}
}
function mouseStop() {
window.event.returnValue = false
}
function Show(divid) {
di

vid.filters.blendTrans.apply();
divid.style.visibility = "visible";
divid.filters.blendTrans.play();
}
function Hide(divid) {
divid.filters.blendTrans.apply();
divid.style.visibility = "hidden";
divid.filters.blendTrans.play();
}
//-->
</script>

<!-- style="cursor:move;" onmousedown='ckmouse(1);' onmouseup='ckmouse(2)' onmousemove='ckmouse(3, "<?=$_data['레이어이름']?>");'-->


<!--//백업 <div style="position:absolute;width:<?=$_data['가로']?>;height:<?=$_data['세로']?>;top:<?=$_data['위쪽여백']?>px;left:<?=$_data['왼쪽여백']?>px;visibility:;z-index:<?=$_data['Popup']['number']?>" id="<?=$_data['레이어이름']?>">-->
<!--// 위 주석은 백업용으로 둔것입니다. 만약 레이어 가로를 지정하실려면 width:<?=$_data['가로']?>를 지정해주시면 됩니다. -->
<!--// 현재는 레이어 가로길이(width:<?=$_data['가로']?>)를 뺀 상태입니다. -->
<!-- background:<?=$_data['레이어색상']?> : 팝업추출태그 사용시 배경색상이 필요할 경우 div 에 반영-->
GHJGHJGHJGHJG
<div style="position:absolute; height:<?=$_data['세로']?>;top:<?=$_data['위쪽여백']?>px;left:<?=$_data['왼쪽여백']?>px;visibility:hidden;z-index:280; " id="<?=$_data['레이어이름']?>" onmouseover="dragObj=<?=$_data['레이어이름']?>; drag=1;move=0" onmouseout="drag=0">
<!-- 	<?=$_data['Popup']['title']?> -->
	<table cellspacing="0" cellpadding="0" height="100%">
		<tr>
			<td height="<?=$_data['세로']?>">

				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" style="padding:4px;" align="center">
						<span onClick="<?=$_data['이동스크립트']?>" style="cursor:hand;"><?=$_data['Popup']['content']?></span>
						<div style="position:absolute; bottom:5px; left:0; width:100%; margin-top:-30px;">
						<table width="90%" border="0" cellspacing="0" cellpadding="0" style="">
							<tr>
								<td valign="top" height="35" valign="top">
								<form name="<?=$_data['폼이름']?>">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="png24">
									<tr>
										<td width="15" align="left" class="h_form" style="padding-left:5px;">
											<label class="h-check"><input type="checkbox" name="no_popup"  id="no_popup" value="Y" style="cursor:pointer;"><span></span></label>
										</td>
										<td style="color:#aaaaaa; padding-top:2px; font-size:11px;" align="left"><label for="no_popup" style="cursor:pointer;"><?=$_data['popupCloseCookieMsg']?></label></td>
										<td align="right"  style="padding-right:5px;"><img border=0  src="img/bt_close.gif" align="absmiddle" onClick="closeWin('<?=$_data['cookie_name']?>','<?=$_data['폼이름']?>','<?=$_data['레이어이름']?>')" style="cursor:pointer;"></td>
									</tr>
								</table>
								</form>
								</td>
							</tr>
						</table>
						</div>
						</td>
					</tr>
				</table>
				
			</td>
		</tr>
	</table>
</div>
<? }
?>