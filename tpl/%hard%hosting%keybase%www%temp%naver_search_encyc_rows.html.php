<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:08 */
function SkyTpl_Func_4294302106 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width='100%'>
<tr>
	<td valign='top' align="left">
		<a href='<?=$_data['Data']['link']?>' target='_blank'><img src='<?=$_data['Data']['thumbnail']?>' width='80' height="80" border='0' align='right' onError="this.style.display = 'none';" style="border:1px solid #EAEAEA"></a>
	</td>
	<td align="left">

		<table width='100%'>
		<tr>
			<td>
				<a href='<?=$_data['Data']['link']?>' target='_blank'><u><font color="#0246ab"><?=$_data['Data']['title']?></font></u></a>
				<div style="padding-top:5px;"></div>
			</td>
		</tr>
		<tr>
			<td style="line-height:17px;"><?=$_data['Data']['description']?></td>
		</tr>
		</table>

	</td>
</tr>
</table>


<div style="padding-top:10px;"></div>

<? }
?>