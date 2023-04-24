<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 16:26:06 */
function SkyTpl_Func_1312852023 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="margin-left:20px; margin-bottom:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;">
		<tr>
			<td style="border:1px solid #dfdfdf; text-align:center; padding:40px 0">
				<span style="display:block; letter-spacing:-1px; color:#333" class="noto500 font_26">
					<?=$_data['Package']['uryo_name']?>

				</span>
				<span style="display:block; padding:10px 0 15px 0">
					<strong class="font_tahoma" style="font-size:26px; color:#333; vertical-align:middle"><?=$_data['Package']['cnt']?></strong>
					<span style="letter-spacing:-1px; color:#333; vertical-align:middle" class="noto400 font_16">개</span>
				</span>
				<span style="display:block">
					<?=$_data['Package']['type_icon']?>

				</span>
			</td>
		</tr>
		<tr>
			<td style="border:1px solid #dfdfdf; background:#f9f9f9; text-align:center">
				<a href="my_package_list.php?mode=list&option_name=<?=$_data['Package']['option_name']?>&pay_type=<?=$_data['pay_type']?>" style="display:block; letter-spacing:-1px; text-align:center; height:50px; line-height:50px" class="font_16 noto400">상세내역 바로가기</a>
			</td>
		</tr>
	</table>
</div>




<? }
?>