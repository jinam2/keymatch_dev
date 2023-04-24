<? /* Created by SkyTemplate v1.1.0 on 2023/04/05 09:32:24 */
function SkyTpl_Func_1158723082 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
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
<style type="text/css">
.behind_bg:before{height:16% !important;}
/* 관리자 연동 색상 지정 */
.guzic_focus_list:hover{border:2px solid #<?=$_data['배경색']['기타페이지']?>;}

</style>
<h3 class="sub_tlt_st01">
	<span style="color:#<?=$_data['배경색']['기본색상']?>">직종별</span>
	<b>인재정보</b>	
</h3>
<div class="container_c">
	<?include_template('search_form_guzic.html') ?>

</div>
<div class="behind_bg">
	<ul class="guzic_optionlist_wrap container_c">
		<li>
			<h3 class="m_tlt">
				<strong>FOCUS 인재정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guzic_focus.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="guzic_focus_list_wrap"><?document_extraction_list_main('가로3개','세로1개','옵션1','옵션2','포커스','옵션4','최근등록일순','글자100글자짜름','누락0개','sub_rows_model_focus.html') ?></div>
		</li>
		<li>
			<h3 class="m_tlt">
				<strong>SPECIAL 인재정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guzic_special.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="guzic_special_list_wrap"><?document_extraction_list_main('가로3개','세로2개','옵션1','옵션2','스페셜','옵션4','최신등록순','글자100글자짜름','누락0개','sub_rows_model_special.html') ?></div>
		</li>
		<li>
			<h3 class="m_tlt">
				<strong>POWER 인재정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guzic_power.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="guzic_power_list_wrap"><?document_extraction_list_main('가로1개','세로4개','옵션1','옵션2','파워링크','옵션4','전체','100글자짜름','누락0개','sub_rows_model_power.html') ?></div>
		</li>
	</ul>
</div>

<div class="container_c" style="margin-top:50px">
	<h3 class="m_tlt">
		<strong>전체 인재정보</strong>
		<p class="h_form sub_list_select"><span><?=$_data['인재정보정렬']?></span></p>
	</h3>
	<div class="sub_guzic_list">
		<ul class="sub_guzic_th">
			<li>이력서 정보</li>
			<li>이름</li>
			<li>희망근무지역</li>
			<li>등록일</li>
		</ul>
		<div class="sub_guzic_td">
			<?document_extraction_list_ajax('가로1개','세로20개','옵션1','옵션2','옵션3','옵션4','최근등록일순','글자999글자짜름','누락0개','sub_guzic_list_rows_01.html','페이징사용') ?>

		</div>			
	</div>
</div>

<? }
?>