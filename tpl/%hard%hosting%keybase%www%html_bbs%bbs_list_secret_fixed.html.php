<? /* Created by SkyTemplate v1.1.0 on 2023/03/13 15:58:05 */
function SkyTpl_Func_2323852740 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- { {TEXT_ALERT} } -->
<div style="width:<?=$_data['B_CONF']['table_size']?>;">

	<!-- 게시판상단 -->
	<div><?=$_data['게시판상단']?></div>
	<!-- 게시판상단 -->

	<!-- 게시판검색 -->
	<div class="h_form bbs_top_search">
		<div class="bbs_top_search_left"><?=$_data['select_category']?><?=$_data['select_reply_choose']?></div>
		<div class="bbs_top_search_right">
			<form method='get' action='./bbs_list.php'>
			<input type=hidden name='action' value='search'>
			<input type=hidden name='tb' value='<?=$_data['_GET']['tb']?>'>
			<input type=hidden name='num' value='<?=$_data['num']?>'>
			<input type=hidden name='links_number' value='<?=$_data['links_number']?>'>
			<input type=hidden name='boardCallType' value='<?=$_data['boardCallType']?>'>
				<select name="search" id="search" style="width:110px;">
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
				<input type="text" name="keyword" value="<?=$_data['_GET']['keyword']?>" style="width:220px;" placeholder="검색어를 입력해주세요">
				<button class="icon_m h_btn_st1" uk-icon="icon:search; ratio:1">검색</button>
			</form>
		</div>
		<div style="clear:both;"></div>
	</div>
	<!-- 게시판검색 -->

	<!-- 게시판리스트 -->
	<div style="border-top:1px solid <?=$_data['B_CONF']['bar_color']?>;">
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%; border-bottom:1px solid <?=$_data['B_CONF']['body_color']?>;" class="bbs_list_title_bar">
		<tr>
			<td style="width:80px;">번호</td>
			<td >제목</td>
			<td style="width:150px;">작성자</td>
			<td style="width:130px;">등록일</td>
		</tr>
		</table>
		<?board_extraction_list('페이지당5개','가로1개','제목길이999자','본문길이0자','공지게시글','bbs_rows_notice01_fixed.html','누락0개','첫페이지만출력') ?>


		<?newPaging_option('번호양쪽4개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>


		<?board_extraction_list('페이지당18개','가로1개','제목길이999자','본문길이0자','현재게시판','bbs_rows_list_secret_fixed.html','누락0개','','','0/0') ?>

	</div>
	<!-- 게시판리스트 -->

	<!-- 게시판버튼 -->
	<div class="h_form bbs_bottom_btn">
		<div class="bbs_bottom_btn_left"><?=$_data['게시판버튼2']?></div>
		<div class="bbs_bottom_btn_right"><?=$_data['게시판버튼']?></div>
		<div style="clear:both;"></div>
	</div>
	<!-- 게시판버튼 -->

	<!-- 게시판관리팝업레이어 -->
	<div><?=$_data['bbs_movepage']?></div>
	<!-- 게시판관리팝업레이어 -->

	<!-- 페이지출력 -->
	<div class="bbs_page"><?=$_data['페이지출력']?></div>
	<!-- 페이지출력 -->

	<!-- 게시판하단 -->
	<div><?=$_data['게시판하단']?></div>
	<!-- 게시판하단 -->

</div>

<? }
?>