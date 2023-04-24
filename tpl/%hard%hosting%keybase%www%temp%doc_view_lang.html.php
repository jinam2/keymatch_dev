<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:50:17 */
function SkyTpl_Func_1035316809 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" width="100%" style="width:100%; border-collapse:collapse; border-top:none !important;" class="doc_view_detail_table">
	<tr>
		<td class="td_style" style="width:235px;"><?=$_data['rData']['language_title']?></td>
		<td class="td_style" style="border-right:none; padding:15px 30px;">
			<table cellspacing="0" cellpadding="0" style="width:100%;">
				<tr>
					<td class="noto400 font_15" style="color:#696969; text-align:left; letter-spacing:-1px;">[공인시험] <?=$_data['rData']['language_check']?> (<?=$_data['rData']['language_skill']?>) (<?=$_data['rData']['language_point']?>점)&nbsp;&nbsp;<?=$_data['rData']['language_year']?>년 <?=$_data['rData']['language_month']?>월 <?=$_data['rData']['language_day']?>일</td>
					<td align="right"><img src="img/graph/graph<?=$_data['rData']['language_skill']?>_2.png" alt="" align="absmiddle" border="0"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? }
?>