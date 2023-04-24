<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 16:11:06 */
function SkyTpl_Func_2380669362 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
		eval(response[0]+ '.innerHTML=response[1]');
		window.status="완료"
		}
	}
	if (request.readyState == 1)  {
	window.status="로딩중....."
	}
}
</script>

<table width='0' border='0' cellspacing='0' cellpadding='0' bgcolor='#F6F6F6' style="display:none">
<form  method='get' action='guin_list.php' name=a_f_guin style='border:0 margin:0'>
<tr>
	<td bgcolor='#ffffff'><img src='img/blank.gif' width='2' height='1'></td>
</tr>
<tr>
	<td height='50'  border=0 align=center valign=middle >


		<input type=hidden name='action' value='search'>
		<img src='img/guzic_icon01.gif'  border=0> :
		<?=$_data['확장지역검색']?><br>
		<img src='img/guzic_icon02.gif'  border=0> :
		<?=$_data['확장업종검색']?><br>
		<img src='img/guzic_icon03.gif'  border=0> :
		<?=$_data['경력검색']?><br>
		<img src='img/guzic_icon04.gif' border=0> :
		<?=$_data['성별검색']?><br>
		<img src='img/guzic_icon05.gif'  border=0> :
		<?=$_data['연봉검색']?><br>
		학력검색 :
		<?=$_data['학력검색']?><br>
		초빙종류 :
		<?=$_data['구인타입']?><br>
		제목검색
		<input type=text name=title_read size=15 value='<?=$_data['title_read']?>'><br>
		&nbsp;<input type=image src='img/guzic_search.gif'  border=0 value=검색 align='absmiddle'>
	</td>
</tr>
<tr><td bgcolor='#ffffff'><img src='img/blank.gif' width='2' height='1'></td></tr>
</form>
</table>

<? }
?>