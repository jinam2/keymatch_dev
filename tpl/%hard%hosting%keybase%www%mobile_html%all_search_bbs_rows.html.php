<? /* Created by SkyTemplate v1.1.0 on 2023/04/11 10:35:11 */
function SkyTpl_Func_2360804700 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding:10px 0;border-bottom:1px solid #dedede">
	<table style="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="board_title_text">
				<div class="ellipsis_line1" style="letter-spacing:-1.5px">
					<a href="./bbs_detail.php?bbs_num=<?=$_data['Data']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>" <?=$_data['Data']['tool_tip']?> class="font_18 font_malgun"><?=$_data['제목']?></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="board_con_text" style="padding:2px 0">
				<?=$_data['Data']['bbs_date']?>&nbsp;&nbsp;|&nbsp;&nbsp;조회수:<?=$_data['Data']['bbs_count']?><span>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$_data['Data']['bbs_name']?></span>
			</td>
		</tr>
		<tr>
			<td class="board_con_text" style="padding-top:5px">
				<div class="ellipsis_line2 font_16 font_malgun" style="letter-spacing:-1.5px; line-height:150%">
					<?=$_data['Data']['bbs_review']?>

				</div>
			</td>
		</tr>
	</table>
</div>



<? }
?>