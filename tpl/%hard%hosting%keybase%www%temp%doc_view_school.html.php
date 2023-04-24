<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:50:17 */
function SkyTpl_Func_2355331318 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; border-collapse:collapse; border-top:none !important;" class="doc_view_detail_table">
	<tr>
		<td class="td_style" style="width:235px;"><?=$_data['Data']['startYear']?> ~ <?=$_data['Data']['endYear']?> <?=$_data['Data']['endMonth']?> </td>
		<td class="td_style"><?=$_data['Data']['schoolName']?> </td>
		<td class="td_style" style="width:265px;"><?=$_data['Data']['schoolType']?> <?=$_data['Data']['schoolEnd']?></td>
		<td class="td_style" style="width:155px;"><?=$_data['Data']['schoolCity']?></td>
		<td style="width:200px; border-right:none;"class="td_style scpoint"><?=$_data['Data']['schoolPoint']?></td>
	</tr>
</table>
<? }
?>