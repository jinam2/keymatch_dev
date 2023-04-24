<? /* Created by SkyTemplate v1.1.0 on 2023/03/13 16:01:59 */
function SkyTpl_Func_269779596 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" border="0" style="width:100%; height:55px; border-bottom:1px solid <?=$_data['B_CONF']['body_color']?>;" onMouseOver="this.style.backgroundColor='<?=$_data['B_CONF']['up_color']?>'" onMouseOut="this.style.backgroundColor=''">
<tr>
	<td style="width:80px; text-align:center;"><span uk-icon="icon:bell; ratio:1" style="color:#<?=$_data['배경색']['게시판1']?>;"></span></td>
	<td style="text-align:left;">
		<!-- 제목이 길어도 댓글과 뉴아이콘이 출력되도록 -->
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>
				<div class="noto400 font_15 bbs_rows_title ellipsis_line_1" style="height:22px;">
					<a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&b_category=<?=$_data['_GET']['b_category']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['tb']?>&pg=<?=$_data['pg']?>&links_number=<?=$_data['links_number']?>&start=<?=$_data['start']?>"><?=$_data['BOARD']['lock']?><span class="bbs_cate"><?=$_data['BOARD']['b_category_con']?></span><?=$_data['BOARD']['bbs_title_none']?></a>
				</div>
			</td>
			<td class="noto400 font_15 bbs_rows_reply" style="padding-left:5px;"><?=$_data['BOARD']['댓글']?><?=$_data['BOARD']['new_icon']?></td>
		</tr>
		</table>
	</td>
	<td style="width:150px; text-align:center;">
		<div class="bbs_name_cut ellipsis_line_1 noto400 font_15 bbs_rows_by"><?=$_data['BOARD']['bbs_name']?></div>
	</td>
	<td style="width:130px; text-align:center;" class="noto400 font_15 bbs_rows_date"><?=$_data['BOARD']['bbs_date']?></td>
	<td style="width:100px; text-align:center; color:#999999;" class="noto400 font_15">-</td>
</tr>
</table>
<? }
?>