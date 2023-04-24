<? /* Created by SkyTemplate v1.1.0 on 2023/03/21 15:35:34 */
function SkyTpl_Func_3320698668 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="border-bottom:1px solid <?=$_data['B_CONF']['body_color']?>; padding:20px 0px; text-align:left;" onClick="location.href='bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?>&top_gonggi=1'">
	<!-- 제목 -->
	<div class="dp_table_cell">
		<div class="dp_table">
			<div class="dp_table_row">
				<div class="dp_table_cell">
					<div class="font_15 bbs_rows_title ellipsis_line1">
						<a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?>&top_gonggi=1"><span uk-icon="icon:bell; ratio:1" style="color:#<?=$_data['배경색']['게시판1']?>; margin-right:6px;"></span><?=$_data['BOARD']['lock']?><span class="bbs_cate"><?=$_data['BOARD']['b_category_con']?></span><?=$_data['BOARD']['bbs_title_none']?></a>
					</div>
				</div>
				<div class="dp_table_cell" style="padding-left:5px;">
					<span class="font_15 bbs_rows_reply"><?=$_data['BOARD']['댓글']?><?=$_data['BOARD']['new_icon']?></span>
				</div>
			</div>
		</div>
	</div>
	<!-- 제목 -->
	<!-- 등록일 -->
	<div style="margin-top:8px;">
		<span class="font_12 bbs_rows_date"><?=$_data['BOARD']['bbs_date']?></span>
	</div>
	<!-- 등록일 -->
</div>
<? }
?>