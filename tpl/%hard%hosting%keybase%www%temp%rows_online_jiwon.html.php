<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:50:17 */
function SkyTpl_Func_2668778827 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="border-bottom:1px solid #cccccc; border-left:1px solid #cccccc; border-right:1px solid #cccccc;">
	<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; border-collapse:collapse; border-top:none !important;" class="doc_view_detail_table">
		<tr>
			<td class="td_style" style="width:70px;"><?=$_data['Online']['last_number']?></td>
			<td class="td_style" style="width:200px"><?=$_data['Online']['regdate_ymd']?> <?=$_data['Online']['regdate_his']?> </td>
			<td class="td_style" style="width:180px;"><?=$_data['Online']['com_name']?></td>
			<td class="td_style"><a href="guin_detail.php?num=<?=$_data['Online']['cNumber']?>"><?=$_data['Online']['guin_title']?></a></td>
			<td style="width:250px; border-right:none;"class="td_style scpoint"><?=$_data['Online']['online_stats_text']?></td>
		</tr>
	</table>
</div>
<? }
?>