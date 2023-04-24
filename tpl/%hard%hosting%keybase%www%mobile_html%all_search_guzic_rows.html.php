<? /* Created by SkyTemplate v1.1.0 on 2023/04/11 10:35:11 */
function SkyTpl_Func_526713686 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="padding:15px 0; border-bottom:1px solid #dedede;text-align:left" onclick="location.href='./document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>'">
	<table style="width:100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				<table style="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="font_16 font_malgun" style="letter-spacing:-1px">
						<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="color:#333333;"><strong><?=$_data['Data']['user_name_cut']?></strong></a> <span style="color:#1b1b1b; font-weight:bold">(<?=$_data['Data']['user_prefix']?>,<?=$_data['Data']['age']?>)</span> <?=$_data['OPTION']['user_photo']?> <?=$_data['OPTION']['special']?> <?=$_data['OPTION']['powerlink']?> <?=$_data['OPTION']['focus']?> <?=$_data['OPTION']['5year']?> <?=$_data['Data']['adult_guzic_icon']?> <?=$_data['OPTION']['freeicon']?> <?=$_data['OPTION']['icon']?>

					</td>
				</tr>
				<tr>
					<td style="padding:10px 0">
						<div style="overflow:hidden; letter-spacing:-1px; line-height:140%" class="font_malgun font_16 ellipsis_line2">
							<?=$_data['OPTION']['bgcolor1']?><a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="; "><?=$_data['OPTION']['color']?><?=$_data['OPTION']['bolder']?><?=$_data['Data']['title']?><?=$_data['OPTION']['bolder2']?></a><?=$_data['OPTION']['bgcolor2']?>

						</div>
					</td>
				</tr>
				<tr>
					<td style="color:#925050; letter-spacing:-1px" class="font_malgun font_14"><?=$_data['Data']['job_where']?></td>
				</tr>
				<tr>
					<td style="padding:10px 0; letter-spacing:0;"><font color="#0e44ff"><?=$_data['Data']['grade_money_icon']?> <?=$_data['Data']['grade_money']?></td>
				</tr>
				<tr>
					<td style="color:#925050; letter-spacing:-1px" class="font_malgun font_14">
						<?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$_data['Data']['grade_lastgrade']?>

					</td>
				</tr>
				</table>
			</td>
			<td rowspan="3" align="right" style="width:28px">
				<img src="./mobile_img/btn_move_sign.png" style="width:28px; padding-left:20px">
			</td>
		</tr>
	</table>
</div>
<? }
?>