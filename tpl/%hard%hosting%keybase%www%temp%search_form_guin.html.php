<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:48:56 */
function SkyTpl_Func_924844004 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style>
	/* 역세권 자동완성 CSS */
	#autoSearchPartWrapUnder{
		position:absolute;
		background: transparent;
		text-align:left;
	}

	#autoSearchPartUnder{
		border:1px solid #bebec1;
		border-top:none;
		display:none;
		width:432px;
		background:#fff;
		/*height:150px;*/
		overflow:hidden;
		overflow-y:auto;
	}

	.listInUnder{
		padding:0 10px;
		background-color:#ececec;
		cursor:pointer;
	}

	.listOutUnder{

	}

	#autopositionUnder{
		position:relative;
		margin-left:0px;
		z-index:1000;
		top:-3px
	}
	/* 역세권 자동완성 CSS */
</style>
<script language="javascript">

function changeIMGS3(num){
	if (num == 1)
	{
		document.getElementById('title_read').style.backgroundImage="";
		//document.getElementById('all_keyword').value = "";
	}
}
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

function searchbox(){

	for(i=1;i<=2;i++){
		if(document.getElementById(i).style.display == 'none'){
			document.getElementById(i).style.display='';
		}else{
			document.getElementById(i).style.display='none';
		}
	}

}

//역세권 검색으로 인해 onSubmit return false 함
function go_search_guin(event)
{
	if ( event.keyCode == 13 )
	{
		document.a_f_guin.submit();
	}
}

</script>
<div class="sch_default sch_guin">
	<form  method='get' action='guin_list.php' name=a_f_guin style='margin:0' onSubmit="return false;">
	<input type="hidden" name="search_mode" value="search">
		<div class="sch_form_default">
			<!-- { {확장업종검색}} -->
			<?=$_data['직급선택']?>

			<p class="keyword_box">
				<input type="text" name="title_read" id="title_read" value="<?=$_data['title_read']?>" placeholder="검색어를 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '검색어를 입력하세요'" onKeyUp="go_search_guin(event)" onKeyDown="go_search_guin(event)" >
				<button class="search_color" onClick="document.a_f_guin.submit();" style="background:#<?=$_data['배경색']['기본색상']?>;">검색하기</button>
			</p>	
			<a href="javascript:void(0);" onClick="search_bar_open()">+ 상세검색</a>
		</div>
		<div class="hidden sch_form_detail" style="background:#f5f5f5;">
			<ul>
				<li>
					<div>
						<b>지역별</b>
						<div class="insert_bracket" style="font-size:0;"><?=$_data['확장지역검색']?></div>
					</div>
					<div>
						<b>지하철</b>
						<div>
							<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT>
							<SCRIPT language="javascript" src="./js/underground_search.js"></SCRIPT>
							<input type="hidden" name="underground1" value="<?=$_data['_GET']['underground1']?>">
							<input type="hidden" name="underground2" value="<?=$_data['_GET']['underground2']?>">
							<input type="hidden" name="underground_text" value="<?=$_data['_GET']['underground_text']?>">
							<div style="display:none">
								<script>make_underground_search('<?=$_data['_GET']['underground1']?>','<?=$_data['_GET']['underground2']?>')</script>
							</div>
							<div>
								<input type="text" name="underground_search_text" id="underground_search_text" value="<?=$_data['_GET']['underground_text']?>" placeholder="원하시는 역세권 정보를 입력하세요." onKeyUp="startMethodUnder(event.keyCode);" onKeyDown="moveLayerUnder(event.keyCode);" onMouseUp="startMethodUnder(event.keyCode);" onFocus="this.value=''" onBlur="returnValueUnder()" autocomplete="off">
							</div>
							<div id="autopositionUnder">
								<div id="autoSearchPartWrapUnder">
									<div id="autoSearchPartUnder"></div>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div>
						<b>초빙종류</b>
						<div><?=$_data['구인타입']?></div>
					</div>
					<div>
						<b>연봉</b>
						<div><?=$_data['연봉검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>경력</b>
						<div><?=$_data['경력검색']?></div>
					</div>
					<div>
						<b>학력</b>
						<div><?=$_data['학력검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>나이제한</b>
						<div><?=$_data['연령검색시작']?><span class="insert_wave"><?=$_data['연령검색종료']?></span></div>
					</div>					
				</li>
			</ul>
			<a href="javascript:void(0);" class="search_detail_close" onClick="search_bar_open();"><img src="img/close_ico.png" alt="" /></a>	
			<a href="javascript:void(0);" class="search_detail_search_btn"  onClick="document.a_f_guin.submit();">검색하기</a>	
		</div>
	</form>
</div>
<? }
?>