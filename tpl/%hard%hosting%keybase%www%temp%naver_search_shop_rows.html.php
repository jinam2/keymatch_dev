<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:07 */
function SkyTpl_Func_1243278424 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table height="110" style="margin:5px 12px 10px 12px;" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>
		<a href='<?=$_data['Data']['link']?>' target='_blank'><img src='<?=$_data['Data']['image']?>' width='110' height='110' border='0' onError="this.src='img/img_noimage.jpg';" style="border:1px solid #EAEAEA;"></a>
	</td>
</tr>
<tr>
	<td width='110'>
		<table width="100%" style="margin-top:5px;" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td valign='top' width='120'>
				<a href='<?=$_data['Data']['link']?>' target='_blank'> <u><font color="#0246ab"><?=$_data['Data']['title']?></font></u></a>
				<div style="padding-top:5px;"></div>
				<font color="#777777">판매처</font> <?=$_data['Data']['mallName']?>

				<div style="padding-top:1px;"></div>
				<font color="#777777">판매가</font> <font color="#FF3E00"><?=$_data['Data']['lprice_comma']?>원</font>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>


<? }
?>