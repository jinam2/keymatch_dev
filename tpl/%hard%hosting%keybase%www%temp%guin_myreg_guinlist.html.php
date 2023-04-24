<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 11:08:07 */
function SkyTpl_Func_2273400899 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="">
	<h3 class="guin_d_tlt_st02" style="position:relative;">
		 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>신청할 채용정보 선택
		 <p style="position:absolute; text-align:right; right:0; top:45px; font-size:14px; font-weight:400;">자신이 등록한 채용정보를 선택하여 적용하세요</p>
	</h3>

	<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse: collapse;">
		<tr>
			<th class="font_16 noto400" style="height:42px; width:60px; text-align:center; color:#666666; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px;" class="" align="center">
				선택
			</th>
			<th align="center" class="font_16 noto400"" style="color:#666666; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px;">내가 등록한 채용정보</th>
		</tr>
	</table>
	<?=$_data['rows_myreg_guin']?>

</div>
<? }
?>