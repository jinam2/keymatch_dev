<? /* Created by SkyTemplate v1.1.0 on 2023/03/21 09:54:42 */
function SkyTpl_Func_3587317574 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="">
	<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;">
		<tr>
			<td style="width:175px; text-align:left; background:#fafafa; padding:25px 30px 25px 30px; border:1px solid #e9e9e9; border-top:0 none; line-height:24px">
				<strong style="color:#333; display:block; letter-spacing:-1px;" class="font_18 noto400">
					<?=$_data['rows']['company_name']?>

				</strong>
				<span style="color:#333; display:block; word-break:break-all" class="font_16 noto400">
					<a href="<?=$_data['rows']['homepage']?>" target="_blank" style="color:#333;"><?=$_data['rows']['homepage']?></a>
				</span>
			</td>
			<td style="width:180px; padding:25px 0 25px 25px; border:1px solid #e9e9e9; border-top:0 none; line-height:24px">
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_15 noto400">
					기업형태<span style="margin-left:10px; color:#666666"><?=$_data['rows']['company_shape']?></span>
				</span>
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_15 noto400">
					사원수<span style="margin-left:10px; color:#666666"><?=$_data['rows']['worker_count']?></span>
				</span>
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_15 noto400">
					매출액<span style="margin-left:10px; color:#666666"><?=$_data['rows']['sales_money']?></span>
				</span>
			</td>
			<td style="padding:25px; border:1px solid #e9e9e9; border-top:0 none; line-height:24px">
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_15 noto400">
					담당자<span style="margin-left:10px; color:#666666"><?=$_data['rows']['take_person']?></span>
				</span>
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_15 noto400">
					연락처<span style="margin-left:10px; color:#666666"><?=$_data['rows']['phone']?></span>
				</span>
				<span style="color:#999; display:block; letter-spacing:-1px;" class="font_15 noto400">
					이메일<span style="margin-left:10px; color:#666666"><?=$_data['rows']['email']?></span>
				</span>
			</td>
			<td style="width:90px; padding:0 10px; text-align:right; border:1px solid #e9e9e9; border-top:0 none">
				<span style="display:block; text-align:center;">
					<a href="?mode=mod&number=<?=$_data['rows']['number']?>"><img src='img/btn_mod.gif' alt='수정' title='수정' /></a>
				</span>
				<span style="display:block; text-align:center;">
					<a href="javascript:void(0);" onclick="if(confirm('삭제하시겠습니까?')){location.href='?mode=del&number=<?=$_data['rows']['number']?>'}"><img src='img/btn_del_my.gif' alt='삭제' title='삭제' style="margin-top:3px;" /></a>
				</span>
			</td>
		</tr>
	</table>
</div>
<? }
?>