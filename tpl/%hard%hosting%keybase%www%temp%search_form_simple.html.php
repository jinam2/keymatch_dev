<? /* Created by SkyTemplate v1.1.0 on 2023/03/06 16:47:03 */
function SkyTpl_Func_519394836 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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

<form  method='get' action='guin_list.php' name='s_f_guin' style='border:0 margin:0'>
<div style="border:1px solid #dfdfdf; background-color:#f7f7f7; padding:10px;" align="center">
	<table cellspacing="0">
	<tr>
		<td style="padding-right:3px;"><?=$_data['지역검색']?></td>
		<td style="padding-right:3px;"><?=$_data['업종검색']?></td>
		<td style="padding-right:3px;"><input type=text name='title_read' value='<?=$_data['title_read']?>' class="sminput3" style="width:200px;"></td>
		<td><input type='image' src='img/btn_ad_find.gif'  border='0' value='검색' align='absmiddle'></td>
	</tr>
	</table>
</div>
</form>
<? }
?>