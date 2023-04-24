<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 17:29:47 */
function SkyTpl_Func_3848556034 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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

	function no_change_pay()
	{
		var obj	= document.getElementById('grade_money_type')

		if ( obj.selectedIndex == 0 )
		{
			document.getElementById('grade_money').disabled = true;
		}
		else
			document.getElementById('grade_money').disabled = false;
	}
</script>



<?include_template('my_point_jangboo_per2.html') ?>


<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>맞춤 초빙정보 설정하기
</h3>


<div style="margin-bottom:20px;">
<!-- 맞춤인재정보 페이지와 action 만 달라짐-->
<form name="a_f_guin" action="per_want_search.php?mode=setting" method="post" style="margin:0px;padding:0px;">
	<table cellspacing="0" cellpadding="0" style="width:100%" class="my_tablecell">
		<tr>
			<th class="title">진료과</th>
			<td class="sub h_form">
				<select name="search_type" id="search_type" style="width:200px;">
					<?=$_data['type_opt']?>

				</select>
				<select name="search_type_sub" id="search_type_sub" style="width:200px;">
					<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
					<?=$_data['type_sub_opt']?>

				</select>
				<select name="search_type_sub_sub" id="search_type_sub_sub" style="width:200px;">
					<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
					<?=$_data['type_sub_sub_opt']?>

				</select>
			</td>
		</tr>
		<tr>
			<th class="title">지역</th>
			<td class="sub h_form">
				<?=$_data['맞춤지역설정']?>

			</td>
		</tr>
		<tr>
			<th class="title">고용형태</th>
			<td class="sub h_form sell_140">
				<?=$_data['맞춤고용형태설정']?>

			</td>
		</tr>
		<tr>
			<th class="title">유형</th>
			<td class="sub h_form">
				<?=$_data['맞춤학력설정']?>

			</td>
		</tr>
	<!-- 	<tr>
			<th class="title">경력</th>
			<td class="sub h_form sell_140">
				<label class="h-radio" for="guin_nope"><input type='radio' name='guin_career'  id="guin_nope" value='' <?=$_data['guin_career_check_0']?> > <span class="noto400 font_14" style="margin-right:10px; vertical-align:middle">무관</span></label>
				<label class="h-radio" for="guin_new"><input type='radio' name='guin_career'  id="guin_new" value='신입' <?=$_data['guin_career_check_1']?>><span class="noto400 font_14" style="margin-right:10px; vertical-align:middle">신입</span></label>
				<label class="h-radio" for="guin_experience"><input type='radio' name='guin_career'  id="guin_experience" value='경력' <?=$_data['guin_career_check_2']?>><span class="noto400 font_14" style="margin-right:10px; vertical-align:middle">경력</span></label>
				<?=$_data['맞춤경력설정']?> <span class="noto400 font_14" style="vertical-align:middle">이상</span>
			</td>
		</tr> -->
		<tr>
			<th class="title">급여</th>
			<td class="sub h_form">
		
			<!-- 새로코딩 : 아이디값 동일하여 수정하셔야합니다 -->
			<label class="h-radio" for="guin_nope"><input type='radio' name='guin_career'  id="guin_nope" value='' <?=$_data['guin_career_check_0']?> > <span class="noto400 font_14" style="margin-right:10px; vertical-align:middle">GROSS(세전)</span></label>

			<label class="h-radio" for="guin_nope"><input type='radio' name=''  id="" value='' <?=$_data['guin_career_check_0']?> > <span class="noto400 font_14" style="margin-right:10px; vertical-align:middle">NET(세후)</span></label>
			<select name="grade_money_type" class="wd200"><?=$_data['희망연봉타입']?></select>
			<input type="text" class="wd200"> 만원이상

		<!-- //새로코딩 -->



			</td>
		</tr>
		<tr>
			<th class="title">이메일발송</th>
			<td class="sub h_form">
				<label class="h-check" for="check_want_mail"><input type="checkbox" name="check_want_mail" id="check_want_mail" value="y" <?=$_data['check_want_mail_checked']?> /> <span class="noto400 font_14">조건에 맞는 채용정보 등록시 이메일 발송</span></label>
			</td>
		</tr>
		<tr>
			<th class="title">SMS발송</th>
			<td class="sub h_form">
				<label  class="h-check" for="check_want_sms"><input type="checkbox" name="check_want_sms" id="check_want_sms" value="y" <?=$_data['check_want_sms_checked']?> />  <span class="noto400 font_14">조건에 맞는 채용정보 등록시 SMS 발송</span></label>
			</td>
		</tr>
	</table>

	<div align="center" style="margin:30px 0;">
		<input type="submit" value="저장하기" alt="저장하기" style="text-indent:-1000px; width:180px; height:60px; background:url('img/skin_icon/make_icon/skin_icon_718.jpg') 0 0 no-repeat; cursor:pointer">
		<a href="per_want_search.php?mode=list">
			<img src="img/btn_per_want_page.gif" style="vertical-align:middle">
		</a>
	</div>
</form>
<? }
?>