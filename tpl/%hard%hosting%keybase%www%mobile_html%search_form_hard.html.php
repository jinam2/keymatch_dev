<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_543454051 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
<table style="width:100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="center">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="select_c"></td>
			<td style="width:47px;height:29px;padding-left:5px"><input type="image" src="./mobile_img/btn_detail_search2.gif" style="-webkit-border-radius:0; -webkit-appearance:none;"></td>
		</tr>
		</table>
	</td>
</tr>
</table>
</form>
<? }
?>