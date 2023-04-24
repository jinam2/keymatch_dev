<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:50:17 */
function SkyTpl_Func_937184921 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; border-collapse:collapse; border-top:none !important;" class="doc_view_detail_table">
	<tr>
		<td class="td_style" style="width:250px;"><?=$_data['rData']['startYear']?>년 <?=$_data['rData']['startMonth']?>월 ~ <?=$_data['rData']['endYear']?>년 <?=$_data['rData']['endMonth']?>월</td>
		<td class="td_style" style="width:210px;"><?=$_data['rData']['country']?></td>
		<td class="td_style" style="text-align:left; padding:15px 30px; border-right:none;"><?=$_data['rData']['content']?></td>
	</tr>
</table>
<? }
?>