<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 15:25:35 */
function SkyTpl_Func_988237000 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
function changeIMGS(num){
	if (num == 1)
	{
		document.getElementById('guzic_keyword').style.backgroundImage="";
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
	//alert(form + ':::' + sel + ':::' + target + ':::' + size);
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
<script>
	function no_change_pay()
	{
		var obj	= document.getElementById('grade_money_type')

		if ( obj.selectedIndex == 0 )
		{
			document.getElementById('guzic_money').disabled = true;
		}
		else
			document.getElementById('guzic_money').disabled = false;
	}
</script>
<div class="sch_default sch_guin">
	<form name="search_frm" style="margin:0;">
		<input type="hidden" name="file" value="<?=$_data['file']?>">
		<div class="sch_form_default">
			<?=$_data['직종검색2']?>

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
						<div class="insert_bracket" style="font-size:0;"><?=$_data['지역검색']?></div>
					</div>
					<div>
						<b>구직종류</b>
						<div><?=$_data['구인타입']?></div>
					</div>
				</li>
				<li>	
					<div>
						<b>경력</b>
						<div><?=$_data['경력검색시작']?><span class="insert_wave"><?=$_data['경력검색종료']?></span></div>
					</div>
					<div>
						<b>학력</b>
						<div><?=$_data['학력검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>연봉</b>
						<div style="display:flex; justify-content:space-between;">
							<select name="grade_money_type" id="grade_money_type"><?=$_data['희망연봉타입']?></select>
							<p class="insert_and">
								<span ></span>
								<input name='guzic_money' id='guzic_money' type='text' value="<?=$_data['_GET']['guzic_money']?>">
								<span style="color:#676565;">원</span>
							</p>
						</div>
					</div>
					<div>
						<b>기관형태</b>
						<div><?=$_data['규모별검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>나이제한</b>
						<div><?=$_data['연령검색시작']?><span class="insert_wave"><?=$_data['연령검색종료']?></span></div>
					</div>	
					<div>
						<b>성별선택</b>
						<div>
							<select name="guzic_prefix">
								<option value="">성별선택</option>
								<?=$_data['성별선택옵션']?>

							</select>
						</div>
					</div>	
				</li>
				<li>
					<div style="width:100%; padding:20px 27px; display:flex; justify-content:flex-end;"><a href="javascript:void(0);" class="search_detail_search_btn2" onClick="document.a_f_guin.submit();">검색하기</a></div>
				</li>
			</ul>
			<a href="javascript:void(0);" class="search_detail_close" onClick="search_bar_open();"><img src="img/close_ico.png" alt="" /></a>	
		</div>
	</form>
</div><!--검색부분 [e]-->

<? }
?>