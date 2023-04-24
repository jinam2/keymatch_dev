<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:42:34 */
function SkyTpl_Func_1633716104 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="4" cellspacing="0" width="100%" border=10>
<tr>
	<td width="180"><?=$_data['rData']['startYear']?>년 <?=$_data['rData']['startMonth']?>월 ~ <?=$_data['rData']['endYear']?>년 <?=$_data['rData']['endMonth']?>월</td>
	<td width="200"><?=$_data['rData']['company_name']?>(<?=$_data['rData']['company_type']?>)</td>
	<td><img src="img/tit_workv_1.gif" border="0" align="absmiddle"> <?=$_data['rData']['job_type']?></td>
	<td rowspan="2" align="right"><?=$_data['rData']['job_money']?></td>
</tr>
<tr>
	<td class="smfont"><font color="#FF6600">(경력 <?=$_data['Data']['work_year_diff']?> <?=$_data['Data']['work_month_diff']?>)</td>
	<td><img src="img/tit_workv_3.gif" border="0" align="absmiddle"> <?=$_data['rData']['job_part']?></td>
	<td><img src="img/tit_workv_2.gif" border="0" align="absmiddle"> <?=$_data['rData']['job_level']?></td>
</tr>
<tr>
	<td colspan="4" bgcolor="#CCCCCC" height="1"></td>
</tr>
</table>

<? }
?>