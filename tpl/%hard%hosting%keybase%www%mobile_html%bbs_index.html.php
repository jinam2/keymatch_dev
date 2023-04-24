<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 11:07:52 */
function SkyTpl_Func_3729292827 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<h3 class="sub_tlt_st01">
	<span style="color:#<?=$_data['배경색']['모바일_기본색상']?>"></span>
	<b>커뮤니티</b>	
</h3>
<div style="padding:10px">
	<!-- 취업꿀팁 -->
	<h3 class="board_tit font_16 noto400">
		<?board_name_out('게시판영역_05','텍스트') ?>

		<span class="more font_10" onclick="location.href='<?board_link('게시판영역_05') ?>'">
			더보기
		</span>
	</h3>
	<div>
		<?board_extraction_list('총3개','가로3개','제목길이140자','본문길이300자','게시판영역_05','bbs_index_rows_photo_text_01.html','누락0개') ?>

	</div>
	<!-- 취준생뉴스 -->
	<h3 class="board_tit font_16 noto400">
		<?board_name_out('게시판영역_01','텍스트') ?>

		<span class="more font_10" onclick="location.href='<?board_link('게시판영역_01') ?>'">
			더보기
		</span>
	</h3>
	<div class="bbs_tbl">
		<?board_extraction_list('총5개','가로1개','제목길이100자','본문길이300자','게시판영역_01','bbs_index_rows_text_01.html','누락0개') ?>

	</div>
	<!-- 직장인뉴스 -->
	<h3 class="board_tit font_16 noto400">
		<?board_name_out('게시판영역_11','텍스트') ?>

		<span class="more font_10" onclick="location.href='<?board_link('게시판영역_11') ?>'">
			더보기
		</span>
	</h3>
	<div class="bbs_tbl">
		<?board_extraction_list('총5개','가로1개','제목길이100자','본문길이300자','게시판영역_11','bbs_index_rows_text_01.html','누락0개') ?>

	</div>
	<!-- 인재인터뷰 -->
	<h3 class="board_tit font_16 noto400">
		<?board_name_out('게시판영역_03','텍스트') ?>

		<span class="more font_10" onclick="location.href='<?board_link('게시판영역_03') ?>'">
			더보기
		</span>
	</h3>
	<div class="bbs_tbl">
		<?board_extraction_list('총2개','가로1개','제목길이140자','본문길이300자','게시판영역_03','bbs_index_rows_photo_text_02.html','누락0개') ?>

	</div>
	<!-- 직무인터뷰 -->
	<h3 class="board_tit font_16 noto400">
		<?board_name_out('게시판영역_13','텍스트') ?>

		<span class="more font_10" onclick="location.href='<?board_link('게시판영역_13') ?>'">
			더보기
		</span>
	</h3>
	<div class="bbs_tbl">
		<?board_extraction_list('총5개','가로1개','제목길이100자','본문길이300자','게시판영역_13','bbs_index_rows_text_02.html','누락0개') ?>

	</div>
	<!-- 직장인보고서 -->
	<h3 class="board_tit font_16 noto400">
		<?board_name_out('게시판영역_12','텍스트') ?>

		<span class="more font_10" onclick="location.href='<?board_link('게시판영역_12') ?>'">
			더보기
		</span>
	</h3>
	<div class="bbs_tbl">
		<?board_extraction_list('총5개','가로1개','제목길이100자','본문길이300자','게시판영역_12','bbs_index_rows_text_02.html','누락0개') ?>

	</div>
</div>
<? }
?>