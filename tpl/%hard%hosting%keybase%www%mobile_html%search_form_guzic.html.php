<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 11:07:57 */
function SkyTpl_Func_4095952907 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script type="text/javascript">
<!--
	var request;
	function createXMLHttpRequest()
	{
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
		}
		else {
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

	function searchbox(){
		for(i=1;i<=2;i++){
			if(document.getElementById(i).style.display == 'none'){
				document.getElementById(i).style.display='';
			}
			else{
				document.getElementById(i).style.display='none';
			}
		}
	}
//-->
function search_bar_open(){
		$('.sch_form_default > a').text('- 상세검색');
		$(".sch_form_detail > ul > li").slideToggle();
		$(".sch_form_detail > ul > li > div > b").slideToggle();
		$(".sch_form_default > b").slideToggle();
	}
</script>

<div class="sch_default">
	<form name="search_frm">
		<div class="hidden sch_form_detail">
			<ul>
				<li style="display:none;">
					<div>
						<b>직종별</b>
						<div class="h_form"><?=$_data['업종검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>지역별</b>
						<div class="h_form"><?=$_data['지역검색']?></div>
					</div>
				</li>		
				<li>
					<div>
						<b>기업형태</b>
						<div class="h_form"><?=$_data['규모별검색']?></div>
					</div>				
					<div>
						<b>구직종류</b>
						<div class="h_form"><?=$_data['구인타입']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>성별</b>
						<div class="h_form">
							<select name="guzic_prefix">
								<option value="">성별선택</option>
								<?=$_data['성별선택옵션']?>

							</select>
						</div>
					</div>				
					<div>
						<b>학력</b>
						<div class="h_form"><?=$_data['학력검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>경력</b>						
						<div class="h_form"><?=$_data['경력검색시작']?><span><?=$_data['경력검색종료']?></span></div>
					</div>
				</li>
				<li>
					<div>
						<b>나이</b>
						<div class="h_form"><?=$_data['연령검색시작']?><span><?=$_data['연령검색종료']?></span></div>
					</div>					
				</li>
				<li>
					<div>
						<b>연봉</b>
						<div class="h_form">
							<select name="grade_money_type" id="grade_money_type"><?=$_data['희망연봉타입']?></select>
							<p>
								<input name='guzic_money' id='guzic_money' type='text' value="<?=$_data['_GET']['guzic_money']?>">
								<span style="color:#676565;">원</span>
							</p>
						</div>
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