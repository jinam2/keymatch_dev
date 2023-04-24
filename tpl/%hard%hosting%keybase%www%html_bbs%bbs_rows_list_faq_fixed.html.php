<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 16:14:17 */
function SkyTpl_Func_370981896 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="border-bottom:1px solid <?=$_data['B_CONF']['body_color']?>;">
	<div style="padding:20px 0px;" onMouseOver="this.style.backgroundColor='<?=$_data['B_CONF']['up_color']?>'" onMouseOut="this.style.backgroundColor=''">
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
		<tr>
			<td style="width:80px; text-align:center;"><span uk-icon="icon:question; ratio:1" style="color:#222222;"></span></td>
			<td style="text-align:left;">
				<!-- 제목이 길어도 댓글과 뉴아이콘이 출력되도록 -->
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<div class="noto500 font_18 bbs_rows_title ellipsis_line_1" style="height:27px;">
							<span class="h_form"><?=$_data['BOARD']['checkbox']?></span><?=$_data['BOARD']['bbs_title_re']?><a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?> "><span class="bbs_cate"><?=$_data['BOARD']['b_category_con']?></span><?=$_data['BOARD']['bbs_title_none']?></a>
						</div>
					</td>
					<td class="noto500 font_18 bbs_rows_reply" style="padding-left:5px;"><?=$_data['BOARD']['댓글']?><?=$_data['BOARD']['댓글채택']?><?=$_data['BOARD']['new_icon']?></td>
				</tr>
				</table>
			</td>
			<td style="width:80px; text-align:center;">
				<span class="sel_menu" onClick="view_layer_rotate('view<?=$_data['BOARD']['number']?>',this);">
					<span uk-icon="icon:chevron-down; ratio:1.5" style="color:#222222;" class="sel_menu_hover"></span>
				</span>
			</td>
		</tr>
		</table>
	</div>
	<div id="view<?=$_data['BOARD']['number']?>" style="display:none; background:#f9f9f9; padding:20px 0px; border-top:1px solid <?=$_data['B_CONF']['body_color']?>; text-align:left;">
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
		<tr>
			<td style="width:80px; text-align:center; vertical-align:top; "><span uk-icon="icon:comments; ratio:1" style="color:#222222;"></span></td>
			<td style="text-align:left;">
				<div class="noto400 font_15 bbs_rows_review ellipsis_line_5" style="height:110px;">
					<a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?>"><?=$_data['BOARD']['bbs_review']?></a>
				</div>
			</td>
			<td style="width:80px; text-align:center; vertical-align:top;"></td>
		</tr>
		</table>
	</div>
</div>

<? }
?>