<? /* Created by SkyTemplate v1.1.0 on 2023/03/09 15:18:08 */
function SkyTpl_Func_806660323 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellspacing="0" style="width:100%; height:60px; border-collapse: collapse;">
	<tr>
		<td class="font_14 noto400" style="width:70px; height:60px; border:1px solid #dfdfdf; border-left:0 none; border-top:0 none; text-align:center">
			<?=$_data['Jangboo']['listNo']?>

		</td>
		<td class="font_14 noto400" align="left" style="padding:20px 20px 20px 30px; border:1px solid #dfdfdf; border-top:0 none; line-height:24px">
			<?=$_data['Jangboo']['goods_name_info']?>

		</td>
		<td class="font_14 noto400" style="width:150px; padding-right:30px; text-align:right; border:1px solid #dfdfdf; border-top:0 none;">
			<strong class="font_16 font_tahoma"><?=$_data['Jangboo']['goods_price']?></strong>원
		</td>
		<td class="font_14 noto400" style="width:120px; border:1px solid #dfdfdf; border-top:0 none"align="center">
			<?=$_data['Jangboo']['or_method']?>

		</td>
		<td class="font_14 noto400 payin" style="width:120px; text-align:center; border:1px solid #dfdfdf; border-top:0 none"><?=$_data['Jangboo']['info_maemool']?></td>
		<td class="font_14 font_tahoma" style="width:180px; text-align:center; border:1px solid #dfdfdf; border-top:0 none">
			<?=$_data['Jangboo']['jangboo_date']?>

		</td>
		<td style="width:100px; border:1px solid #dfdfdf; text-align:center; border-top:0 none; border-right:0 none"><?=$_data['Jangboo']['in_check']?></td>
	</tr>
</table>

<? }
?>