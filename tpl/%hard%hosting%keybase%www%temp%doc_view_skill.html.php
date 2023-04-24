<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:50:17 */
function SkyTpl_Func_1828505785 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; border-collapse:collapse; border-top:none !important;" class="doc_view_detail_table">
	<tr>
		<td class="td_style" style="width:235px;"><?=$_data['rData']['skill_getYear']?>/<?=$_data['rData']['skill_getMonth']?>/<?=$_data['rData']['skill_getDay']?></td>
		<td class="td_style"><?=$_data['rData']['skill_name']?></td>
		<td class="td_style" style="width:330px; border-right:none;"><?=$_data['rData']['skill_from']?></td>
	</tr>
</table>
<? }
?>