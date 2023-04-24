<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 14:19:45 */
function SkyTpl_Func_3914464924 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!--관리자 색상 변경기능 을 위한 강제 스타일 빼면안됨-->

	<?happy_banner_slide_mobile('메인_모바일','자동','등록순') ?>

	<ul class="main_list_wrap">
		<li>
			<div>
				<h3 class="m_tlt_m">
					<strong>우대등록 초빙정보</strong>
					<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
					<a href="./html_file.php?file=guin_udae.html&file2=default_guin.html" class="text_hidden more_btn"><b>더보기</b></a>
				</h3>
				<div>
					<?guin_main_extraction('총6개','가로2개','제목길이200자','전체','전체','전체','전체','우대등록','전체','main_rows_guin_woodae_01.html','랜덤추출','누락0개') ?>

				</div>
			</div>
		</li>
		<li>
			<div>
				<h3 class="m_tlt_m">
					<strong>프리미엄 초빙정보</strong>
					<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
					<a href="./html_file.php?file=guin_premium.html&file2=default_guin.html" class="text_hidden more_btn"><b>더보기</b></a>
				</h3>
				<div>
					<?guin_main_extraction('총6개','가로2개','제목길이200자','전체','전체','전체','전체','프리미엄','전체','main_rows_guin_premium_01.html','랜덤추출','누락0개') ?>

				</div>
			</div>
		</li>
		<li>
			<div>
				<h3 class="m_tlt_m">
					<strong>스페셜 초빙정보</strong>
					<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
					<a href="./html_file.php?file=guin_special.html&file2=default_guin.html" class="text_hidden more_btn"><b>더보기</b></a>
				</h3>
				<div>
					<?guin_main_extraction('총6개','가로2개','제목길이200자','전체','전체','전체','전체','스페셜','전체','main_rows_guin_special_01.html','랜덤추출','누락0개') ?>

				</div>
			</div>
		</li>
	
	


		<li style="padding-top:0;">
			<div>
				<h3 class="m_tlt_m" style="margin-top:20px;">
					<strong><?board_name_out('게시판영역_02','텍스트') ?></strong>
					<a href="<?board_link('게시판영역_02') ?>" class="text_hidden more_btn"><b>더보기</b></a>
				</h3>
				<div class="text_gall_wrap">
					<?board_extraction_list('총5개','가로1개','제목길이100자','본문길이0자','게시판영역_02','bbs_rows_main_txt_01.html','누락0개') ?>

				</div>
				<h3 class="m_tlt_m" style="margin-top:50px;">
					<strong><?board_name_out('게시판영역_09','텍스트') ?></strong>
					<a href="<?board_link('게시판영역_09') ?>" class="text_hidden more_btn"><b>더보기</b></a>
				</h3>
				<div class="text_gall_wrap m_main_qna_list">
					<?board_extraction_list('총5개','가로1개','제목길이100자','본문길이0자','게시판영역_09','bbs_rows_main_txt_01.html','누락0개') ?>

				</div>
			</div>
		</li>
	</ul>
<? }
?>