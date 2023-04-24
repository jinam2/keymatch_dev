<? /* Created by SkyTemplate v1.1.0 on 2023/04/18 13:19:34 */
function SkyTpl_Func_1089561774 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	.sub_wodae_01 .wodae_in:hover .wdisplay{display:block; left:0; top:0; right:0; bottom:0; position:absolute; border:2px solid #<?=$_data['배경색']['서브색상']?>; overflow:hidden; z-index:10}
	.sub_wodae_01 .wodae_in .d_day{color:#<?=$_data['배경색']['서브색상']?>;}
	.sub_spe_guin_01{margin-left:10px; margin-top:10px; border-left:2px solid #<?=$_data['배경색']['서브색상']?> !important; border:1px solid #dfdfdf}
	.sub_spe_guin_01:hover{ border-left:2px solid #<?=$_data['배경색']['서브색상']?> !important; border:1px solid #<?=$_data['배경색']['서브색상']?>}
	.sub_spe_guin_01 .d_day{color:#<?=$_data['배경색']['서브색상']?>;}
	.sub_guin_list .d_day{color:#<?=$_data['배경색']['서브색상']?>;}
</style>

<?call_now_nevi('신입사원') ?>

<h3 class="sub_tlt_st01">
	<span style="color:#<?=$_data['배경색']['기본색상']?>">진료과별</span>
	<b>초빙정보</b>	
</h3>
<div class="container_c">
	<?include_template('search_form_advance.html') ?>

</div>
<div class="behind_bg">
	<ul class="guin_optionlist_wrap container_c">
		<li>
			<h3 class="m_tlt">
				<strong>우대등록 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_woodae.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총12개','가로4개','제목길이100자','자동','자동','자동','자동','우대등록','전체','sub_rows_guin_woodae_01.html','최신등록순','누락0개','','','','신입') ?></div>
		</li>
		<li>		
			<h3 class="m_tlt">
				<strong>프리미엄 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_premium.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총12개','가로4개','제목길이200자','자동','자동','자동','자동','프리미엄','전체','sub_rows_guin_premium_01.html','최신등록순','누락0개','','','','신입') ?></div>		
		</li>
		<li>		
			<h3 class="m_tlt">
				<strong>스페셜 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
							<a href="html_file.php?file=guin_special.html" class="text_hidden more_btn"><b>더보기</b></a>
			
			
			</h3>
			<div class="m_list_03" style="width:1212px;"><?guin_main_extraction('총9개','가로3개','제목길이200자','자동','자동','자동','자동','스페셜','전체','sub_rows_guin_special_01.html','최신등록순','누락0개','','','','신입') ?></div>		
		</li>
	</ul>
</div>
<div class="container_c">
	<h3 class="m_tlt">
		<strong>전체 초빙정보<span class="font_18 font_malgun" style="color:#<?=$_data['배경색']['서브색상']?>; vertical-align:middle; display:inline-block; margin:0 0 4px 10px">총 <span id="guin_counting" >로딩중</span> 건</span></strong>
		<p class="h_form sub_list_select"><span><?=$_data['채용정보정렬']?></span> </p>
	</h3>
	<div class="sub_guin_list">
		<ul class="sub_guin_th">
			<li>초빙내용</li>
			<li>근무지역</li>
			<li>초빙유형</li>
			<li>마감일</li>
		</ul>
		<div class="sub_guin_td">
			<?guin_extraction_ajax('총20개','가로1개','제목길이999자','자동','자동','자동','자동','일반','자동','sub_guin_list_rows_01.html','누락0개','사용함','','최근등록일순','','','신입') ?>

		</div>			
	</div>
</div>

<? }
?>