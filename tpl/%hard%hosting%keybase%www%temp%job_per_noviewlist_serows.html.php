<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 15:04:33 */
function SkyTpl_Func_968672839 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="width:1200px;">
	<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;">
		<tr>
			<td class="h_form" style="width:60px; text-align:center;  border:1px solid #e9e9e9; border-top:0 none; ">
				<label class="h-check"><input type="checkbox" name="addList[]" value="<?=$_data['Data']['user_id']?>" style="cursor:pointer"><span></span></label>
			</td>
			<td style="width:205px; text-align:left; background:#fafafa; padding:25px 0 25px 30px; border:1px solid #e9e9e9; border-top:0 none; line-height:24px">
				<span style="color:#333; display:block; letter-spacing:-1px;" class="font_16 noto500">
					<a href="com_info.php?com_info_id=<?=$_data['Data']['user_id']?>&guin_number=<?=$_data['Data']['number']?>" style="color:#333" target="_blank"><?=$_data['회사명']?></a>
				</span>
			</td>
			<td style="width:180px; padding:25px 0 25px 25px; border:1px solid #e9e9e9; border-top:0 none; line-height:24px">
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_14 noto400">
					대표<span style="margin-left:10px; color:#666666"><?=$_data['대표자']?></span>
				</span>
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_14 noto400">
					사원수<span style="margin-left:10px; color:#666666"><?=$_data['직원수']?></span>
				</span>
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_14 noto400">
					설립연도<span style="margin-left:10px; color:#666666"><?=$_data['설립연도']?></span>
				</span>
			</td>
			<td style="padding:25px; border:1px solid #e9e9e9; border-top:0 none; line-height:24px">
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_14 noto400">
					업종<span style="margin-left:10px; color:#666666"><?=$_data['업종']?></span>
				</span>
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_14 noto400">
					주소<span style="margin-left:10px; color:#666666"><?=$_data['주소']?></span>
				</span>
			</td>
		</tr>
	</table>
</div>
<? }
?>