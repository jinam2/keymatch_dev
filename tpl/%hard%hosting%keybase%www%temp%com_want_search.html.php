<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 17:39:40 */
function SkyTpl_Func_1515412185 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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

<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	인재정보관리
	<span style="position:absolute; top:0; right:0">
		<a href="html_file.php?file=today_view_resume.html&file2=happy_member_default_mypage_com.html" title="오늘 본 인재정보">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">오늘 본 인재정보</span>
		</a>
		<a href="html_file.php?file=com_payendper.html&file2=happy_member_default_mypage_com.html" title="이력서 열람관리">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">이력서 열람관리</span>
		</a>
		<a href="member_guin.php?type=scrap" title="채용공고별 스크랩">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">채용공고별 스크랩</span>			
		</a>
		<a href="com_want_search.php?mode=setting_form" title="맞춤인재설정">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#666; padding:3px 15px; border-radius:15px;">맞춤인재설정</span>
		</a>
		<a href="com_want_search.php?mode=list" title="맞춤인재정보">			
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['서브색상']?>; padding:3px 15px; border-radius:15px;">맞춤인재정보</span>
		</a>
	</span>
</div>

<?include_template('my_point_jangboo_com.html') ?>


<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>맞춤인재정보 설정하기
</h3>
<form name="a_f_guin" action="com_want_search.php?mode=setting" method="post" >
	<table cellspacing="0" cellpadding="0" style="width:100%" class="my_tablecell">
		<tr>
			<th class="title">분야</th>
			<td class="sub h_form">
				<?=$_data['맞춤업종설정']?>

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
			<th class="title">학력</th>
			<td class="sub h_form">
				<?=$_data['맞춤학력설정']?>

			</td>
		</tr>
		<tr>
			<th class="title">경력</th>
			<td class="sub h_form sell_140">
				<?=$_data['맞춤경력시작설정']?>~<?=$_data['맞춤경력종료설정']?>

			</td>
		</tr>
		<tr>
			<th class="title">급여</th>
			<td class="sub h_form sell_140">
				<select name="grade_money_type"><?=$_data['희망연봉타입']?></select><input name='grade_money' id='grade_money' type='text' value="<?=$_data['WantSearchDoc']['grade_money']?>" style=" width:150px; text-align:right; margin-left:5px; padding-right:2px;">
			</td>
		</tr>
		<tr>
			<th class="title">성별</th>
			<td class="sub h_form sell_140">
				<?=$_data['맞춤성별설정']?>

			</td>
		</tr>
		<tr>
			<th class="title">연령</th>
			<td class="sub h_form sell_140">
				<?=$_data['맞춤연령시작설정']?> ~ <?=$_data['맞춤연령종료설정']?>

			</td>
		</tr>
		<tr>
			<th class="title">검색범위</th>
			<td class="sub h_form sell_140">
				<?=$_data['등록일차이']?> <span class="noto400 font_14" style="vertical-align:middle">까지</span>
			</td>
		</tr>
	</table>

	<div align="center" style="margin:50px 0 0;">
		<a href="com_want_search.php?mode=list&file=guzic_want_search.html&file2=happy_member_default_mypage_com.html">
			<img src="img/btn_com_want_page.gif" style="vertical-align:middle">
		</a>
		<input type="submit" value="저장하기" alt="저장하기" style="text-indent:-1000px; width:180px; height:60px; background:url('img/skin_icon/make_icon/skin_icon_709.jpg') 0 0 no-repeat; cursor:pointer">
	</div>
</form>
<? }
?>