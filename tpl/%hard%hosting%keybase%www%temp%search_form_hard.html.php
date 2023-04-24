<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:09:49 */
function SkyTpl_Func_2240032532 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
var request;
function createXMLHttpRequest()
{
	if (window.XMLHttpRequest) {
	request = new XMLHttpRequest();
	} else {
	request = new ActiveXObject("Microsoft.XMLHTTP");
	}
}

function startRequest(sel,target,size)
{
var trigger = sel.options[sel.selectedIndex].value;
var form = sel.form.name;
createXMLHttpRequest();
request.open("GET", "sub_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
request.onreadystatechange = handleStateChange;
request.send(null);
}

function startRequest2(sel,target,size)
{
var trigger = sel.options[sel.selectedIndex].value;
var form = sel.form.name;
createXMLHttpRequest();
request.open("GET", "sub_type_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
request.onreadystatechange = handleStateChange;
request.send(null);
}

function handleStateChange() {
	if (request.readyState == 4) {
		if (request.status == 200) {
		var response = request.responseText.split("---cut---");
		//eval(response[0]+ '.innerHTML=response[1]');
		eval('document.getElementById(\''+response[0]+'\')' + '.innerHTML=response[1]');
		window.status="완료"
		}
	}
	if (request.readyState == 1)  {
	window.status="로딩중....."
	}
}
</script>
<form  method='get' action='html_file.php' name=a_f_guin style='margin:0'>
<input type=hidden name='action' value='search'>
<input type=hidden name='file' value='<?=$_data['_GET']['file']?>'>
<input type=hidden name='underground1' id='underground1' value='<?=$_data['_GET']['underground1']?>'>
<input type=hidden name='underground2' id='underground2' value='<?=$_data['_GET']['underground2']?>'>
<input type=hidden name='underground_text' id='underground_text' value='<?=$_data['_GET']['underground_text']?>'>

<div style="margin-bottom:15px; border:1px solid #dbdbdb; background-color:#FFF;">
	<table cellspacing="0" style="width:100%; border-top:2px solid #f8f8f8;">
	<tr>
		<td style="padding:10px 0 10px 20px; width:350px;" align="left">
			<table cellspacing="0" style="width:100%;">
			<tr>
				<td style="width:70px; height:25px; color:#6c6c6c;"><img src="img/icon_arrows_01.gif" align="absmiddle"> 초빙종류</td>
				<td><?=$_data['구인타입']?></td>
			</tr>
			<tr>
				<td style="color:#6c6c6c; height:25px;"><img src="img/icon_arrows_01.gif" align="absmiddle"> 직종</td>
				<td><?=$_data['확장업종검색']?></td>
			</tr>
			</table>
		</td>
		<td style="padding:10px;" align="left">
			<table cellspacing="0" style="width:100%;">
			<tr>
				<td style="width:70px; height:25px; color:#6c6c6c;"><img src="img/icon_arrows_01.gif" align="absmiddle"> 경력</td>
				<td><?=$_data['경력검색']?></td>
			</tr>
			<tr>
				<td style="color:#6c6c6c; height:25px;"><img src="img/icon_arrows_01.gif" align="absmiddle"> 성별</td>
				<td><?=$_data['성별검색']?></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>

</form>
<? }
?>