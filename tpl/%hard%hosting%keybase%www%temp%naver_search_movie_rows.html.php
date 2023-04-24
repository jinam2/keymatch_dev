<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:07 */
function SkyTpl_Func_1042607459 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table width='110' height="110" style="margin:5px 16px 10px 16px;" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><a href='<?=$_data['Data']['link']?>' target='_blank'><img src='<?=$_data['Data']['image']?>' border='0' width="100" height="130" onError="this.src='img/img_noimage.jpg';" style="border:1px solid #E5E2DC;"></a></td>
</tr>
<tr>
	<td width='100'>
		<table cellpadding="0" cellspacing="0" border="0" style="margin-top:5px;">
		<tr>
			<td valign='top' width='95'>
				<a href='<?=$_data['Data']['link']?>' target='_blank'><font color="#0246ab"> <?=$_data['Data']['title']?> (<?=$_data['Data']['subtitle']?>)</font></a>
				<div style="padding-top:5px;"></div>
				<font color="#777777">개봉일<?=$_data['Data']['pubDate']?></font>
				<div style="padding-top:5px;"></div>
				<font color="#777777">평점 <?=$_data['Data']['userRating']?> </font><br>
				<div style="padding-top:1px;"></div>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- 감독 {{Data.director} } -->
<!-- 배우 {{Data.actor} } -->

<? }
?>