<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 17:20:01 */
function SkyTpl_Func_1734049541 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	/* 페이지내 rows디자인 색생 변경을 위한 css입니다 */
	.sub_tab_menu02 > ul > li.on > a{color: #<?=$_data['배경색']['모바일_기본색상']?>;}
</style>
<div class="sub_wrap">
	<h3 class="sub_tlt_st01">
		<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>">주요</b>
		<span>초빙정보</span>
	</h3>
	<div class="sub_tab_menu02">
		<ul>
			<li class="on"><a href="/html_file.php?file=guin_woodae.html">우대등록 초빙정보</a></li>
			<li><a href="/html_file.php?file=guin_premium.html">프리미엄 초빙정보</a></li>
			<li><a href="/html_file.php?file=guin_special.html">스페셜 초빙정보</a></li>

		</ul>
	</div>
	<?include_template('search_form_guin.html') ?>	
	
	<div class="sub_guin_list_wrap">
		<h3 class="m_tlt_m_01">
			<strong style="margin-bottom:20px; display:block;">우대등록 초빙정보 리스트  <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><span id="guin_counting" >로딩중</span> 건</span></strong>		
			<p class="h_form sub_list_select">
				<span><?=$_data['채용정보정렬']?></span>
			</p>
		</h3>
		<div class="sub_guin_list">
			<div class="sub_guin_td">
				<?guin_extraction_ajax('총20개','가로2개','제목길이999자','자동','자동','자동','자동','우대등록','자동','sub_rows_guin_woodae_01.html','누락0개','사용함','','최근등록일순') ?>

			</div>			
		</div>
	</div>
</div>


<? }
?>