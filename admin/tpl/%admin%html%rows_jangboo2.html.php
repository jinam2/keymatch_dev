<? /* Created by SkyTemplate v1.1.0 on 2023/03/21 09:28:00 */
function SkyTpl_Func_2793232655 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<tr>
	<td class="b_border_td" style="text-align:center;"><?=$_data['MONEY']['number']?></td>
	<td class="b_border_td" style="padding:20px 10px; line-height:22px"><?=$_data['goods_name']?></td>
	<td class="b_border_td" style="text-align:center;"><?=$_data['MONEY']['or_id']?></td>
	<td class="b_border_td" style="text-align:right;"><b><?=$_data['MONEY']['goods_price']?></b> 원 <br>(<?=$_data['MONEY']['or_method']?>)</td>
	<td class="b_border_td" style="text-align:center;"><?=$_data['info_maemool']?></td>
	<td class="b_border_td" style="text-align:center;"><?=$_data['MONEY']['in_check']?></td>
	<td class="b_border_td" style="text-align:center;"><?=$_data['MONEY']['jangboo_date']?></td>
	<td class="b_border_td" style="text-align:center;"><a href=jangboo2.php?action=jangboo_mod&number=<?=$_data['MONEY']['number']?>&links_number=<?=$_data['MONEY']['links_number']?>&pg=<?=$_data['pg']?> class="btn_small_dark3">수정</a> <a href="javascript:bbsdel('jangboo2.php?action=jangboo_del&number=<?=$_data['MONEY']['number']?>&pg=<?=$_data['pg']?>');" class="btn_small_red2" style='margin-top:3px'>삭제</a></td>
</tr>
<tr style='<?=$_data['pg_response_display']?>'>
	<td colspan='10' style='background:#f4f4f4; text-align:center; padding:10px 0 10px 0; '><?=$_data['pg_response_msg']?> </td>
</tr>
<? }
?>