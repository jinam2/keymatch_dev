<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_475398426 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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

<table cellpadding="0" cellspacing="0" width="100%" align="center">
    <tr><form  method='get' action='guin_list.php' name=s_f_guin style='border:0 margin:0'>
			<input type=hidden name='action' value='search'>
        <td width="4" height="4"><img src="img/table_search_1.gif" width="4" height="4" border="0"></td>
        <td bgcolor="#F9F9F9"></td>
        <td width="4" height="4"><img src="img/table_search_2.gif" width="4" height="4" border="0"></td>
    </tr>
    <tr>
        <td bgcolor="#F9F9F9"></td>
        <td bgcolor="#F9F9F9" align="center" height="40"><?=$_data['지역검색']?>&nbsp;<?=$_data['업종검색']?>&nbsp;<input type=text name=title_read size=15 value='<?=$_data['title_read']?>'>&nbsp;<input type=image src='img/skin_icon/make_icon/skin_icon_101.jpg'  border=0 value=검색 align='absmiddle'>
</td>
        <td bgcolor="#F9F9F9"></td>
    </tr>
    <tr>
        <td width="4" height="4"><img src="img/table_search_4.gif" width="4" height="4" border="0"></td>
        <td bgcolor="#F9F9F9"></td>
        <td width="4" height="4"><img src="img/table_search_3.gif" width="4" height="4" border="0"></td>
    </tr></form>
</table>

<? }
?>