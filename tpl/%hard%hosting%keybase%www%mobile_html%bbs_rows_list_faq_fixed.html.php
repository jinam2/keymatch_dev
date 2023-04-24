<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 13:28:17 */
function SkyTpl_Func_3116119230 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="border-bottom:1px solid <?=$_data['B_CONF']['body_color']?>; text-align:left;" >
	<div class="dp_table_100">
		<div class="dp_table_row">
			<div class="dp_table_cell" onClick="location.href='bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?>'" style="padding:20px 0px;">
				<!-- 제목 -->
				<div class="dp_table">
					<div class="dp_table_row">
						<div class="dp_table_cell">
							<div class="font_15 bbs_rows_title ellipsis_line1">
								<?=$_data['BOARD']['bbs_title_re']?><a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?>"><span uk-icon="icon:question; ratio:1" style="margin-right:6px; color:#222222;"></span><?=$_data['BOARD']['lock']?><strong><span class="bbs_cate"><?=$_data['BOARD']['b_category_con']?></span><?=$_data['BOARD']['bbs_title_none']?></strong></a>
							</div>
						</div>
						<div class="dp_table_cell" style="padding-left:5px;">
							<span class="font_15 bbs_rows_reply"><?=$_data['BOARD']['댓글']?><?=$_data['BOARD']['new_icon']?></span>
						</div>
					</div>
				</div>
				<!-- 제목 -->
			</div>
			<div class="dp_table_cell" style="width:40px; text-align:right;">
				<span class="sel_menu" onClick="view_layer_rotate('view<?=$_data['BOARD']['number']?>',this);">
					<span uk-icon="icon:chevron-down; ratio:1.0" style="color:#222222;" class="sel_menu_hover"></span>
				</span>
			</div>
		</div>
	</div>
	<div id="view<?=$_data['BOARD']['number']?>" style="display:none; background:#f9f9f9; padding:20px 20px; border-top:1px solid <?=$_data['B_CONF']['body_color']?>; text-align:left;">
		<div class="ellipsis_line3 font_15 bbs_rows_review " style="line-height:1.4em;"><?=$_data['BOARD']['bbs_review']?></div>
	</div>
</div>

<? }
?>