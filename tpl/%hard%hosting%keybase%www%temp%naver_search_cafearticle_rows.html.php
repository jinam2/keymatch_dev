<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:07 */
function SkyTpl_Func_384740311 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<table width='100%'>
<tr>
	<td valign='top' align="left">
		<a href='<?=$_data['Data']['link']?>' target='_blank'><u><font color="#0246ab"><?=$_data['Data']['title']?></font></u></a>
		<div style="padding-top:5px;"></div>
		<?=$_data['Data']['description']?>

	</td>
	<tr>
		<td style="line-height:18px;" class="smfont2" align="left"><a href='<?=$_data['Data']['cafeurl']?>' target='_blank'><font color="#888888"> 카페명: <?=$_data['Data']['cafename']?></font></a></td>
	</tr>
</tr>
</table>



<div style="padding-top:20px;"></div>

<? }
?>