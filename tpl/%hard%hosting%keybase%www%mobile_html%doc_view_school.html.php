<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:42:34 */
function SkyTpl_Func_1720360145 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<tr>
	<td><?=$_data['Data']['startYear']?> ~ <?=$_data['Data']['endYear']?> <?=$_data['Data']['endMonth']?></td>
	<td><?=$_data['Data']['schoolName']?>(<?=$_data['Data']['schoolEnd']?>)</td>
</tr>
<? }
?>