<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 15:47:03 */
function SkyTpl_Func_1928019354 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div id="bbs_sns_layer" style="position:relative; display:none">
	<div class="bbs_talk_box_sns">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="bbs_sns_img"><?=$_data['tweeter_url']?></td>
			<td class="bbs_sns_img"><?=$_data['facebook_url']?></td>
			<td class="bbs_sns_img"><?echo kakaotalk_link('img/sns_icon/icon_kakaotalk.png','32','32') ?></td>
			<td class="bbs_sns_img"><?=$_data['naverBand']?></td>
			<td style="text-align:right; padding-left:30px;"><span uk-icon="icon:close; ratio:1.5" onClick="view_layer('bbs_sns_layer');" style="cursor:pointer; color:#bcbcbc; width:30px;"></span></td>
		</tr>
		</table>
	</div>
</div>

<? }
?>