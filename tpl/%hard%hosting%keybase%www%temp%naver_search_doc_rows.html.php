<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:13 */
function SkyTpl_Func_3058115015 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width='100%'>
<tr>
	<td valign='top' align="left">
		<a href='<?=$_data['Data']['link']?>' target='_blank'><u><font color="#0246ab"><?=$_data['Data']['title']?></font></u></a>
		<div style="padding-top:0px;"></div>
	</td>
</tr>
<tr>
	<td style="line-height:17px;" align="left"><?=$_data['Data']['description']?></td>
</tr>
</table>

<div style="padding-top:20px;"></div>

<? }
?>