<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 09:37:39 */
function SkyTpl_Func_1923480106 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding:15px; border-bottom:1px solid #eaeaea">
	<table cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<td class="font_18 noto400" style="letter-spacing:-1.5px; color:#262626; font-weight:bold"><span style="letter-spacing:0; color:#<?=$_data['배경색']['모바일_기본색상']?>;">Q<?=$_data['질문번호']?>.</span> <?=$_data['질문']?></td>
		</tr>
		<tr>
			<td style="padding:15px 0;">
				<textarea name="answer<?=$_data['질문번호']?>" style="width:100%; height:68px; background:#fcfcfc; border:1px solid #ddd"></textarea>
			</td>
		</tr>
	</table>
</div>

<? }
?>