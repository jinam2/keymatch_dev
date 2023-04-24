<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:49:01 */
function SkyTpl_Func_2663836164 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding:20px 0;">
	<table cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<td class="font_18 noto500" style="letter-spacing:-1px; color:#262626;"><span style="letter-spacing:0">Q<?=$_data['질문번호']?></span> <?=$_data['질문']?></td>
		</tr>
		<tr>
			<td class="h_form" style="padding:20px 0">
				<textarea name="answer<?=$_data['질문번호']?>" style="height:68px;"></textarea>
			</td>
		</tr>
	</table>
</div>

<? }
?>