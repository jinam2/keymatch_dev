<? /* Created by SkyTemplate v1.1.0 on 2023/04/10 15:52:14 */
function SkyTpl_Func_1478577379 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" style="width:100%; border:1px solid #ebebeb; solid #00b4c8; margin-bottom:5px;">
<tr>
	<td style="border-bottom:1px solid #dedede; background:#f1f1f1;"><b><?=$_data['Reply']['user_info']?></b>&nbsp;&nbsp;&nbsp;<font style="color:#888888; font-size:11px; letter-spacing:0px; "><?=$_data['Reply']['reg_date']?></font></td>
</tr>
<tr>
	<td style="padding:10px;"><?=$_data['Reply']['comment']?></td>
</tr>
</table>

<? }
?>