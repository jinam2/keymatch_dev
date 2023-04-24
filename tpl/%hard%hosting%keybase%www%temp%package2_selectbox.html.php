<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 09:48:27 */
function SkyTpl_Func_1156423250 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellspacing="0" style="width:100%;" border="0">
	<tr>
		<td class="h_form" style="border-right:1px solid #ccc; border-bottom:1px solid #ccc; border-left:1px solid #ccc; width:260px; text-align:center">
			<label class="h-check" for="pack2_use_<?=$_data['PACK2']['number']?>"><input type="checkbox" name="pack2_use_<?=$_data['PACK2']['number']?>" id="pack2_use_<?=$_data['PACK2']['number']?>" onClick="Func_pack2_now_price(<?=$_data['PACK2']['number']?>);figure();if(this.checked){document.getElementById('pack2_uryo_<?=$_data['PACK2']['number']?>').style.background='';document.getElementById('pack2_uryo_<?=$_data['PACK2']['number']?>').disabled=false;}else{document.getElementById('pack2_uryo_<?=$_data['PACK2']['number']?>').style.background='#EAEAEA';document.getElementById('pack2_uryo_<?=$_data['PACK2']['number']?>').disabled=true;}"><span class="noto400 font_15"><?=$_data['PACK2']['title']?></span></label><br/><?=$_data['PACK2']['help_link_info']?>

		</td>
		<td style="padding:20px; border-bottom:1px solid #ccc; border-right:1px solid #ccc">
			<div style="margin-bottom:15px;" class="h_form">
				<?=$_data['PACK2']['package2_selectbox']?>

			</div>
			<div class="font_15 noto400" style="margin-bottom:15px; color:#333333; letter-spacing:-1px;">
				<strong class="font_15 noto400"><?=$_data['PACK2']['comment']?></strong>
			</div>
			<table cellspacing="0" style="width:430px;">
				<tr>
					<td class="font_15 noto400" style="color:#8c8c8c; line-height:150%; letter-spacing:-1px;" valign="top"><?=$_data['PACK2']['uryo_detail_text']?></td>
					<td class="font_15 noto400" style="color:#8c8c8c; line-height:150%; letter-spacing:-1px;" valign="top"><?=$_data['PACK2']['add_option']?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? }
?>