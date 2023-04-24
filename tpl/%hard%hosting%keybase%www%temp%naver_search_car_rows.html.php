<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:07 */
function SkyTpl_Func_1271852928 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width='100%'>
<tr>
	<td width='100' height="72" align='center' valign='top'>
		<a href='<?=$_data['Data']['link']?>' target='_blank'><img src='<?=$_data['Data']['image']?>' width='100' border='0' onError="this.src='img/img_noimage.jpg';" style="border:1px solid #EAEAEA;"></a>
	</td>
	<td valign='top' align="left">

		<table width='100%' style="border:0px solid red;">
		<tr>
			<td><a href='<?=$_data['Data']['link']?>' target='_blank'><font color="#0246ab"><u><?=$_data['Data']['title']?></u></font></a></td>
		</tr>
		<tr>
			<td >
				연식 : <?=$_data['Data']['pubDate']?>

				<div style="padding-top:2px;"></div>
				제조사 : <?=$_data['Data']['maker']?>

				<div style="padding-top:2px;"></div>
				차종 : <?=$_data['Data']['type']?>

			</td>
		</tr>
		</table>
	</td>
</tr>
</table>


<div style="padding-top:10px;"></div>

<? }
?>