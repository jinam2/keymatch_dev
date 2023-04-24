<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 16:22:11 */
function SkyTpl_Func_195981201 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellspacing="0" style="width:100%; height:60px; border-collapse: collapse;">
	<tr>
		<td class="font_13 noto400" style="width:50px; height:60px; border:1px solid #dfdfdf; border-left:0 none; border-top:0 none; text-align:center">
			<?=$_data['Package']['seq']?>

		</td>
		<td class="font_16 noto400" align="left" style="width:220px; padding-left:20px; border:1px solid #dfdfdf; border-top:0 none; line-height:24px; letter-spacing:-1px;">
			<?=$_data['Package']['title']?>

		</td>
		<td class="font_14 noto400" style="padding-left:30px; text-align:left; border:1px solid #dfdfdf; border-top:0 none; letter-spacing:-1px">
			<?=$_data['Package']['type_icon']?> <?=$_data['Package']['uryo_name']?> <?=$_data['Package']['option_day']?> <?=$_data['Package']['danwi']?> 연장
		</td>
		<td class="font_13 font_tahoma" style="width:130px; border:1px solid #dfdfdf; border-top:0 none"align="center">
			<?=$_data['Package']['reg_date_Ymd']?>

		</td>
		<td class="font_13 font_tahoma payin" style="width:130px; text-align:center; border:1px solid #dfdfdf; border-top:0 none"><?=$_data['Package']['end_date']?></td>
		<td class="font_13 font_tahoma" style="width:100px; text-align:center; border:1px solid #dfdfdf; border-top:0 none">
			<?=$_data['Package']['stats_icon']?>

		</td>
	</tr>
</table>

<? }
?>