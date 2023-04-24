<? /* Created by SkyTemplate v1.1.0 on 2023/03/24 20:23:40 */
function SkyTpl_Func_1179568476 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="margin-top:20px;">
	<table class="tb_st_04" cellpadding="0" style="width:100%">
		<tr>
			<th class="font_18 noto400 h_form">
				<label for="pack2_use_<?=$_data['PACK2']['number']?>" class="h-check"><input type="checkbox" name="pack2_use_<?=$_data['PACK2']['number']?>" id="pack2_use_<?=$_data['PACK2']['number']?>" onClick="Func_pack2_now_price(<?=$_data['PACK2']['number']?>);figure();if(this.checked){document.getElementById('pack2_uryo_<?=$_data['PACK2']['number']?>').style.background='#FFFFFF';document.getElementById('pack2_uryo_<?=$_data['PACK2']['number']?>').disabled=false;}else{document.getElementById('pack2_uryo_<?=$_data['PACK2']['number']?>').style.background='#EAEAEA';document.getElementById('pack2_uryo_<?=$_data['PACK2']['number']?>').disabled=true;}" style="cursor:pointer"><span style="vertical-align:middle;"></span></label>
				<span style="color:#<?=$_data['배경색']['모바일_기본색상']?>">
					<label for="pack2_use_<?=$_data['PACK2']['number']?>" style="color:#333; cursor:pointer; font-weight:bold;"><?=$_data['PACK2']['title']?></label>
				</span> <?=$_data['PACK2']['help_link_info']?>

			</th>
		</tr>	
		<tr>
			<td class="h_form " style="padding:10px;">
				<?=$_data['PACK2']['package2_selectbox']?>

			</td>
		</tr>
		<tr>
			<td style="line-height:160%">
				<span style="display:block">
					<strong><?=$_data['PACK2']['comment']?></strong>
				</span>
				<span style="display:block">
					<?=$_data['PACK2']['uryo_detail_text']?>

				</span>
				<span style="display:block">
					<?=$_data['PACK2']['add_option']?>

				</span>
			</td>
		</tr>
	</table>
</div>
<? }
?>