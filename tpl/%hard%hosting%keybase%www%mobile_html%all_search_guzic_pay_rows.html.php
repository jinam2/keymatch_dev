<? /* Created by SkyTemplate v1.1.0 on 2023/04/11 10:35:11 */
function SkyTpl_Func_380537753 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style=" background:#fff; position:relative; overflow:hidden; margin-bottom:10px" onclick="location.href='document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>'" style="cursor:pointer">
	<div class="txt font_malgun" style="top:18px">
		POWER
	</div>
	<div class="triangle2"></div>
	<div style="padding:15px; border:2px solid #d1d1d1; ">
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<td style="width:118px">
					<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>">
						<img src="<?echo happy_image('자동','가로220','세로220','로고사용안함','로고위치7번','퀄리티100','gif원본출력','img/no_photo.gif','비율대로확대','2') ?>" width="110" height="110 " style="border-radius:100%">
					</a>
				</td>
				<td style="padding:10px 10px 10px 15px; line-height:24px; vertical-align:top">
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td class="font_16 font_malgun" style="letter-spacing:-1px">
								<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="color:#333333;"><strong><?=$_data['Data']['user_name_cut']?></strong></a> <span style="color:#1b1b1b; font-weight:bold">(<?=$_data['Data']['user_prefix']?>,<?=$_data['Data']['age']?>)</span> <?=$_data['Data']['adult_guzic_icon']?> <?=$_data['Data']['adult_guzic_icon']?> <?=$_data['OPTION']['freeicon']?> <?=$_data['OPTION']['icon']?>

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
							<td class="font_malgun font_13" style="color:#999; letter-spacing:-1px">
								<span style="color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?></span> / <?=$_data['Data']['grade_lastgrade']?>

							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
<? }
?>