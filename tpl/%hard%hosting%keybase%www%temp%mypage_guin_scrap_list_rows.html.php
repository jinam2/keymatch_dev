<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 09:48:22 */
function SkyTpl_Func_3112879656 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse: collapse;">
		<tr>
			<td style="width:160px; background:#f5f5f5; text-align:center; border:1px solid #dfdfdf; border-left:0 none; border-top:0 none !important">
				<span style="display:block; letter-spacing:-1px; color:#333" class="font_18 noto500">
					<a href="./document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>" style="color:#333"><?=$_data['Data']['user_name_cut']?></a>
				</span>
				<span style="padding:5px 0 0 0; display:block; font-weight:bold; letter-spacing:-1.2px; color:#999" class="font_14 noto400">
					( <?=$_data['Data']['user_prefix']?>,<?=$_data['Data']['age']?> )
				</span>
			</td>
			<td style="width:300px; border:1px solid #dfdfdf; padding:25px 30px; vertical-align:top; text-align:left; border-top:0 none !important">
				<h4 class="font_18 noto400 ellipsis_line_1" style="height:26px; line-height:26px; overflow:hidden;  letter-spacing:-1px; width:300px; margin:0 0 5px 0;color:#333">
					<a href="./document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>" title="<?=$_data['Data']['title']?>" style="color:#333;"><?=$_data['Data']['title']?></a>
				</h4>
				<table cellpadding="0"cellspacing="0" style="width:100%; line-height:22px" class="resister_rows">
					<tr>
						<td class="font_14 noto400"><?=$_data['Data']['grade_lastgrade']?> : <?=$_data['Data']['grade_last_schoolType']?></td>
					</tr>
					<tr>
						<td class="font_14 noto400" style="color:#<?=$_data['배경색']['서브색상']?>">
							<?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?>&nbsp;&nbsp;
							<span class="font_st_12" style="color:#909090;"><?=$_data['Data']['work_otherCountry']?></span>
						</td>
					</tr>
				</table>
			</td>
			<td style="border:1px solid #dfdfdf; border-top:0 none !important">
				<div style="padding:28px 30px; line-height:22px;">
					<span style="height:22px; overlfow:hidden; display:block; letter-spacing:-1px; color:#999999" class="font_14 noto400 ellipsis_line_1">
						<span>
							희망직종 <span style="color:#333; margin-left:10px; letter-spacing:0" class=""> <?=$_data['Data']['job_type']?></span>
						</span>
					</span>
					<span style="display:block; letter-spacing:-1.2px; color:#999999" class="font_14 noto400">
						희망급여 <span style="color:#333; margin-left:10px; letter-spacing:0"><?=$_data['Data']['grade_money_type']?> <?=$_data['Data']['grade_money']?></span>
					</span>
					<span style="display:block; letter-spacing:-1.2px; color:#999999" class="font_14 noto400">
						희망지역 <span style="color:#333; margin-left:10px; letter-spacing:0"><?=$_data['Data']['job_where']?></span>
					</span>
				</div>
			</td>
			<td style="width:150px; border:1px solid #dfdfdf; border-right:0 none; border-top:0 none !important; text-align:center">
				<div style="padding:30px 30px; line-height:24px;">
					<span style="display:block; letter-spacing:-1.2px" class="font_14 font_malgun">
						<a href="document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>">
							<img src="img/btn_guzic_view.gif" border="0" align="absmiddle" alt="이력서명 : <?=$_data['DocData']['title']?>">
						</a>
					</span>
					<span style="display:block; letter-spacing:-1.2px; margin-top:5px" class="font_14 font_malgun">
						<a href="#" onclick="confirm_del(<?=$_data['Data']['pNumber']?>,<?=$_data['Data']['cNumber']?>,<?=$_data['Data']['cNumber']?>);"><img src="img/btn_scrap_del.gif" border="0" align="absmiddle" alt="삭제버튼">
					</span>
				</div>
			</td>
		</tr>
	</table>
</div>
<? }
?>