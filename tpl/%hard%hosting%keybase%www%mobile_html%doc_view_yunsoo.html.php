<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:42:34 */
function SkyTpl_Func_3711259326 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<tr>
	<td><?=$_data['rData']['country']?></td>
	<td>
		<p><?=$_data['rData']['content']?></p>
		<span><?=$_data['rData']['startYear']?>.<?=$_data['rData']['startMonth']?>.<?=$_data['rData']['startMonth']?> ~ <?=$_data['rData']['endYear']?>.<?=$_data['rData']['endMonth']?></span>
	</td>
</tr>

<? }
?>