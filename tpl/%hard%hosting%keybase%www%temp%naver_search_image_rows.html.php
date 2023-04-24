<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:08 */
function SkyTpl_Func_3319371935 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<table width='115' cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
	<tr>
		<td width="10"></td>
		<td align='center' width="115" height="110" valign='top'>
			<a href="javascript:void(0)" onClick="view('<?=$_data['Data']['link']?>');" ><img src='<?=$_data['Data']['thumbnail']?>' width="115" height="110" border='0' onError="this.src='img/img_noimage.jpg';" style="border:1px solid #EAEAEA"></a>
		</td>
	</tr>
	<tr>
		<td width="10"></td>
		<td valign='top' width="115">
			<a href='<?=$_data['Data']['link']?>' target='_blank'><font color="#0246ab"><u><?=$_data['Data']['title']?></u></font></a>
		</td>
	</tr>
	</table>
</div>

<!-- ( 원본size <?=$_data['Data']['sizewidth']?> X <?=$_data['Data']['sizeheight']?>) -->

<? }
?>