<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 17:32:44 */
function SkyTpl_Func_1452568457 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="border-bottom:1px solid <?=$_data['B_CONF']['body_color']?>; padding:20px 0px; text-align:left;" onClick="location.href='bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?>'">
	<div class="dp_table_100">
		<div class="dp_table_row">
			<div class="dp_table_cell">
				<!-- 제목 -->
				<div class="dp_table">
					<div class="dp_table_row">
						<div class="dp_table_cell">
							<div class="font_15 bbs_rows_title ellipsis_line1">
								<?=$_data['BOARD']['bbs_title_re']?><a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?>"><?=$_data['BOARD']['lock']?><span class="bbs_cate"><?=$_data['BOARD']['b_category_con']?></span><?=$_data['BOARD']['bbs_title_none']?></a>
							</div>
						</div>
						<div class="dp_table_cell" style="padding-left:5px;">
							<span class="font_15 bbs_rows_reply"><?=$_data['BOARD']['댓글']?><?=$_data['BOARD']['new_icon']?></span>
						</div>
					</div>
				</div>
				<!-- 제목 -->
			</div>
			<div class="dp_table_cell" style="width:60px; text-align:right;">
				<span class="font_15"><?=$_data['BOARD']['radio1_info']?></span>
			</div>
		</div>
	</div>
	<!-- 등록일 -->
	<div style="margin-top:8px;">
		<span class="font_12 bbs_rows_by">BY <?=$_data['BOARD']['bbs_name']?></span>
		<span class="bbs_gubun_line_01"></span>
		<span class="font_12 bbs_rows_date"><?=$_data['BOARD']['bbs_date']?></span>
	</div>
	<!-- 등록일 -->
</div>
<? }
?>