<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:11:16 */
function SkyTpl_Func_1894291910 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
<style type="text/css">
	.search_box > form > p > a{border:1px solid #<?=$_data['배경색']['모바일_기본색상']?>; color:#<?=$_data['배경색']['모바일_기본색상']?>; }

	/* 검색자동완성 CSS */
	#autoSearchPartWrap{position:absolute;	margin-top:3px;	width:100%;}
	#autoSearchPart	{background-color:#ffffff;border:4px solid #3d3d3d; border-top:none;	display:none;	height:200px; overflow:hidden; overflow-y:auto; width:100%; }
	#autoSearchPart td{font-size:1.429em; line-height:1.429em; padding-left:15px !important}
	.listIn{	background-color:#f5f5f5;	cursor:pointer;}
	.listOut{}
	#autoposition{position:relative; z-index:100; margin-left:-24px; margin-right:1px}
</style>
<form  method='get' action='guin_list.php' name=s_f_guin style='border:0 margin:0'>
	<input type=hidden name='action' value='search'>
	<p>
		<img src="<?=$_data['HAPPY_CONFIG']['m_main_logo']?>" alt="<?=$_data['site_name']?>">
		<span>나에게 맞는 초빙정보,<br>기관이 찾는 인재정보 찾기!</span>
	</p>
	<div>
		<input type="text" name="title_read" size="15" value='<?=$_data['title_read']?>' placeholder="검색어를 입력하세요" class="win_input">
		<label for=""><input type="submit" value="검색"><img src="mobile_img/main_search_icon.png" alt="검색하기" /></label>
		<div id="autoposition">
			<div id="autoSearchPartWrap">
				<div id="autoSearchPart"></div>
			</div>
		</div>
	</div>
	<p><?=$_data['추천키워드']?></p>	
</form>
<a href="javascript:toggle_sch_box();" class="sch_close_btn"><img src="mobile_img/close_ico.png" alt="닫기" /></a>


<? }
?>