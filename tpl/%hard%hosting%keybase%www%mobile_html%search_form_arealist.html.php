<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 16:11:27 */
function SkyTpl_Func_3536582450 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
<script>
	function searchbox(){

		for(i=1;i<=2;i++){
			if(document.getElementById(i).style.display == 'none'){
				document.getElementById(i).style.display='';
			}else{
				document.getElementById(i).style.display='none';
			}
		}

	}

	function search_bar_open(){
		$('.sch_form_default > a').text('- 상세검색');
		$(".sch_form_detail > ul > li:nth-child(n+2)").slideToggle();
		$(".sch_form_detail > ul > li > div > b").slideToggle();
		$(".sch_form_default > b").slideToggle();
	}
</script>
<div class="sch_default">
	<form method='get' action='guin_list.php' name=a_f_guin style='margin:0'>		
		<input type=hidden name='action' value='search'>
		<input type=hidden name='file' value='<?=$_data['_GET']['file']?>'>
		<input type=hidden name='file2' value='<?=$_data['_GET']['file2']?>'>
		<div class="hidden sch_form_detail">
			<ul>				
				<li>
					<div>
						<b>지역별</b>
						<div class="h_form"><?=$_data['지역검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>직종별</b>
						<div class="h_form"><?=$_data['업종검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>지하철</b>
						<div class="h_form">
							<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT>
							<SCRIPT language="javascript" src="./js/underground_search.js"></SCRIPT>
							<input type="hidden" name="underground1" value="<?=$_data['_GET']['underground1']?>">
							<input type="hidden" name="underground2" value="<?=$_data['_GET']['underground2']?>">
							<input type="hidden" name="underground_text" value="<?=$_data['_GET']['underground_text']?>">
							<script>make_underground_search('<?=$_data['_GET']['underground1']?>','<?=$_data['_GET']['underground2']?>')</script>
						</div>
					</div>
				</li>
				<li>
					<div>
						<b>나이제한</b>
						<div class="h_form"><?=$_data['연령검색시작']?><span><?=$_data['연령검색종료']?></span></div>
					</div>					
				</li>
				<li>
					<div>
						<b>초빙종류</b>
						<div class="h_form"><?=$_data['구인타입']?></div>
					</div>				
					<div>
						<b>직급</b>
						<div class="h_form"><?=$_data['직급선택']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>연봉</b>
						<div class="h_form"><?=$_data['연봉검색']?></div>
					</div>				
					<div>
						<b>경력</b>
						<div class="h_form"><?=$_data['경력검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>학력</b>
						<div class="h_form"><?=$_data['학력검색']?></div>
					</div>
				</li>				
			</ul>
		</div>
		<div class="sch_form_default">	
			<b>키워드</b>
			<p class="keyword_box">
				<input type="text" name="title_read" id="title_read" value="<?=$_data['title_read']?>" placeholder="검색어를 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '검색어를 입력하세요'" onKeyUp="go_search_guin(event)" onKeyDown="go_search_guin(event)" >
				<button class="search_color" onClick="document.a_f_guin.submit();" style="background:#<?=$_data['배경색']['기본색상']?>;">검색하기</button>
			</p>	
			<a href="javascript:void(0);" onClick="search_bar_open()">+ 상세검색</a>
		</div>
		
	</form>

</div>
<? }
?>