<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 17:32:44 */
function SkyTpl_Func_2279189180 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- { {TEXT_ALERT} } -->
<h3 class="sub_tlt_st01">
	<span style="color:#<?=$_data['배경색']['모바일_기본색상']?>"></span>
	<b><?=$_data['B_CONF']['board_name']?></b>	
</h3>
<!-- 검색 -->
<div class="h_form bbs_search">
	<form  method='get' action='./bbs_list.php'>
	<input type=hidden name='action' value='search'>
	<input type=hidden name='tb' value='<?=$_data['_GET']['tb']?>'>
	<input type=hidden name='num' value='<?=$_data['num']?>'>
	<input type=hidden name='links_number' value='<?=$_data['links_number']?>'>
		<div class="dp_table_100">
			<div class="dp_table_row">
				<div class="dp_table_cell" style="width:100px;">
					<select name="search" id="search">
					<option value="bbs_title">제목</option>
					<option value="bbs_name">이름</option>
					<option value="bbs_review">내용</option>
					</select>
					<script>
					if ( "<?=$_data['_GET']['search']?>" != "" )
					{
						document.getElementById('search').value = "<?=$_data['_GET']['search']?>";
					}
					</script>
				</div>
				<div class="dp_table_cell" style="padding-left:5px;"><input type="text" name="keyword" value="<?=$_data['_GET']['keyword']?>"></div>
				<div class="dp_table_cell" style="width:100px; text-align:right;"><button class="icon_m h_btn_st1" uk-icon="icon:search; ratio:1">검색</button></div>
			</div>
		</div>
	</form>
</div>

<!-- 카테고리 -->
<h3 class="m_tlt_m_01" style="<?=$_data['BOARD']['b_category_dis']?>">
	<p class="h_form sub_list_select"><span><?=$_data['select_category']?></span></span></p>
</h3>
		
<div class="board_list_wrap">

	<!-- 리스트 -->
	<div class="bbs_list_box">
		<?board_extraction_list('페이지당5개','가로1개','제목길이999자','본문길이0자','공지게시글','bbs_rows_notice01_fixed.html','누락0개','첫페이지만출력') ?>


		<?newPaging_option('번호양쪽1개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>


		<?board_extraction_list('페이지당18개','가로1개','제목길이999자','본문길이0자','현재게시판','bbs_rows_list_qna_fixed.html','누락0개') ?>

	</div>
	<!-- 리스트 -->

	<!-- 게시판버튼 -->
	<div class="h_form bbs_bottom_btn">
		<div class="bbs_bottom_btn_right"><?=$_data['게시판버튼']?></div>
		<div style="clear:both;"></div>
	</div>
	<!-- 게시판버튼 -->

	<!-- 페이지출력 -->
	<div class="bbs_page"><?=$_data['페이지출력']?></div>
	<!-- 페이지출력 -->
</div>
<? }
?>