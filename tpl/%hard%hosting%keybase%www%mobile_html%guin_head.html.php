<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 21:05:58 */
function SkyTpl_Func_2410056213 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="sub_wrap">
	<h3 class="sub_tlt_st01">
		<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>">헤드헌팅 </b>
		<span>채용정보</span>
	</h3>
	<?include_template('search_form_guin.html') ?>

	<ul class="guin_optionlist_wrap">
		<li>
			<h3 class="m_tlt_m">
				<strong>우대등록 채용정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_woodae.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총1개','가로1개','제목길이34자','자동','자동','자동','자동','우대등록','자동','sub_rows_guin_woodae_01.html','전체','누락0개','','','헤드헌팅') ?></div>
		</li>
		<li>		
			<h3 class="m_tlt_m">
				<strong>프리미엄 채용정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_premium.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총1개','가로1개','제목길이34자','자동','자동','자동','자동','프리미엄','자동','sub_rows_guin_premium_01.html','전체','누락0개','','','헤드헌팅') ?></div>		
		</li>
		<li>		
			<h3 class="m_tlt_m">
				<strong>스페셜 채용정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_premium.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_03"><?guin_main_extraction('총1개','가로1개','제목길이34자','자동','자동','자동','자동','스페셜','자동','sub_rows_guin_premium_01.html','전체','누락0개','','','헤드헌팅') ?></div>
		</li>
	</ul>
	<div class="sub_guin_list_wrap">
		<h3 class="m_tlt_m_01">
			<strong style="margin-bottom:20px; display:block;"><?=$_data['카테고리명']['1차']?> 채용정보 리스트  <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><span id="guin_counting" >로딩중</span> 건</span></strong>		
			<p class="h_form sub_list_select">
				<span><?=$_data['채용정보정렬']?></span>
				<span><?=$_data['채용정보마감일정렬']?></span>
			</p>
		</h3>
		<div class="sub_guin_list">
			<div class="sub_guin_td">
				<?guin_extraction_ajax('총20개','가로1개','제목길이200자','자동','자동','자동','자동','일반','자동','sub_guin_list_rows_01.html','누락0개','사용함','','최근등록일순','','','','헤드헌팅') ?>

			</div>			
		</div>
	</div>
</div>

<? }
?>