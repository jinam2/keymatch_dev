<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:57:24 */
function SkyTpl_Func_3525562972 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('아르바이트 > 아르바이트 채용정보') ?>

<style>
	.sub_guin_list .d_day{color:#<?=$_data['배경색']['서브색상']?>; letter-spacing:0}
</style>
<?
	global $지역검색1,$지역검색2,$BOARD,$select_name_eq_search,$text2_select_info;
	$지역검색1		= make_si_selectbox("zip","select1","$_GET[zip]","$_GET[select1]","110","110","b_search_form1");
	$지역검색2		= make_si_selectbox("zip","select1","$_GET[zip]","$_GET[select1]","80","100","b_search_form2");

	$array_name = array('채용공고제목','회사명','담당자연락처','기타사항');
	$array_value = array('bbs_title','phone','address','bbs_review');
	$mod = '-필드선택-';
	$var_name = 'search';
	if( $_GET['action'] == 'search' )
	{
		$_GET[search] = ( $_GET[search] == '' ) ? $array_value[0] : $_GET[search];
	}
	$select_name = $_GET[search];
	$select_name_eq_search = make_selectbox2($array_name,$array_value,$mod,$var_name,$select_name);

	$array_name = array('일당','주당','월급','건당','시간당','추후협의');
	$array_value = $array_name;
	$mod = '-급여방식-';
	$var_name = 'text2';
	$select_name = $_GET[text2];
	$text2_select_info = make_selectbox2($array_name,$array_value,$mod,$var_name,$select_name);



?>
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
function sel(check1,d1)
{
var tmp1 = eval('document.regiform.'+check1);
var tmp2 = eval('document.regiform.'+d1);
	if (tmp1.checked == true ) {
	tmp2.disabled = true;
	}
	else {
	tmp2.disabled = false;
	}
}

</script>
<!-- { {게시판상단} } -->
<h3 class="sub_tlt_st01">
	<span style="color:#<?=$_data['배경색']['기본색상']?>">아르바이트 </span>
	<b>채용정보</b>	
</h3>
<div class="alba_search_wrap sch_default">
	<form  method='get' action='./bbs_list.php' name=b_search_form1>
		<input type=hidden name='action' value='search'>
		<input type=hidden name='tb' value='<?=$_data['tb']?>'>
		<div>
			<p>
				<span><?=$_data['지역검색1']?></span>
				<span><?=$_data['b_category_search_form']?></span>
				<span><?=$_data['text2_select_info']?></span>
			</p>
			<p>
				<span><?=$_data['select_name_eq_search']?></span>
				<input type='text' name='keyword' value='<?=$_data['keyword']?>' placeholder="검색어를 입력하세요">
				<button style="background:#<?=$_data['배경색']['기본색상']?>;">검색하기</button>
			</p>
		</div>
	</form>
</div>
<div>
	<h3 class="m_tlt">
		<strong>아르바이트 채용정보<span class="font_18" style="color:#<?=$_data['배경색']['기본색상']?>;"> ( <?=$_data['total_board_numb']?>건 )</span></strong>
		<p class="h_form sub_list_select"><span><?=$_data['select_category']?></span></p>
	</h3>
	<div class="bbs_alba_list">
		<ul class="bbs_alba_th">
			<li>모집내용</li>
			<li>근무지역</li>
			<li>급여조건</li>
			<li>등록/마감일</li>
		</ul>
		<div class="bbs_alba_td">
			<?newPaging_option('번호양쪽4개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

			<?board_extraction_list('페이지당10개','가로1개','제목길이200자','본문길이0자','현재게시판','bbs_rows_sub_albaguin_02.html') ?>

		</div>			
	</div>
</div>
<!-- 게시판버튼 -->
<div class="h_form bbs_bottom_btn">
	<div class="bbs_bottom_btn_right"><?=$_data['게시판버튼']?></div>
	<div style="clear:both;"></div>
</div>
<!-- 게시판버튼 -->

<!-- 페이지출력 -->
<div class="bbs_page">
	<?=$_data['페이지출력']?>

</div>
<!-- 페이지출력 -->

<script>//document.all.total_news_number.innerHTML = '<?=$_data['total_board_numb']?>';</script>

<!-- { {게시판하단} } -->

<? }
?>