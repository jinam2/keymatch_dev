<? /* Created by SkyTemplate v1.1.0 on 2023/03/14 16:42:42 */
function SkyTpl_Func_937441568 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellspacing="0" cellpadding="0" style="width:100%; table-layout:fixed">
	<tr>
		<td style="height:50px; border-bottom:1px dashed #dedede;">
			<table cellspacing="0" cellpadding="0" style="width:100%;">
			<tr>
				<td align="left" >
					<div class="ellipsis_line_1 font_15 noto400" style="height:24px;">
						<a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>"  style="color:#666" ><?=$_data['BOARD']['bbs_title_none']?></a>
					</div>
				</td>
				<td align="right" style="width:70px; text-align:right; color:#a3a3a3;" class="font_12 noto400">
					<?=$_data['BOARD']['bbs_date']?>

				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>



<? }
?>