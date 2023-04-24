<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 09:17:16 */
function SkyTpl_Func_4064722724 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding='0' cellspacing='0' width='778' height='126'>
<tr>
	<td background='img/bg_per_skin3_maininfo2.gif' valign='top' style='padding-top:7px;'>

		<table cellpadding='0' cellspacing='0' align='center' width='100%'>
		<tr>
			<td height='27' style='padding-left:110px;' class='skin3' colspan='2'><?=$_data['Data']['job_where']?></td>
		</tr>
		<tr>
			<td width='300' height='27' style='padding-left:110px;' class='skin3'><?=$_data['Data']['grade_money_type']?> <?=$_data['Data']['grade_money']?></td>
			<td style='padding-left:115px;' class='skin3'><?=$_data['Data']['etc7']?></td>
		</tr>
		<tr>
			<td width='300' height='27' style='padding-left:110px;' class='skin3'><?=$_data['Data']['user_army']?>  (<?=$_data['Data']['user_army_status']?>)</td>
			<td style='padding-left:115px;' class='skin3'><?=$_data['Data']['user_bohun']?></td>
		</tr>
		</table>

	</td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' align='center' width='100%'>
<tr>
	<td style='padding-left:15px;padding-top:3px;padding-bottom:3px;' class='skin3'><?=$_data['Data']['job_type']?></td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='778' height='43'>
<tr>
	<td background='img/bg_per_skin3_maininfo3.gif' valign='top' style='padding-top:7px;'>

		<table cellpadding='0' cellspacing='0' align='center' width='100%'>
		<tr>
			<td height='27' style='padding-left:110px;' class='skin3'><?=$_data['Data']['keyword']?></td>
		</tr>
		</table>

	</td>
</tr>
</table>

<? }
?>