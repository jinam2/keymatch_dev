<? /* Created by SkyTemplate v1.1.0 on 2023/03/21 17:38:44 */
function SkyTpl_Func_3622243218 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse: collapse;">
		<tr>
			<td style="width:195px; background:#f9f9f9; padding:15px 0; text-align:center; border:1px solid #dfdfdf; border-left:0 none; border-top:0 none">
				<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="display:inline-block; width:80px; height:80px; border-radius:50%; overflow:hidden; border:1px solid #ddd;">
					<img src="<?echo happy_image('자동','가로80','세로80','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로확대','2') ?>" alt="" style="width:100%; ">
				</a>
				<span style="display:block; letter-spacing:-1px; color:#333" class="font_16 noto500">
					<?=$_data['Data']['user_name_cut']?>

				</span>
				<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 noto400">
					( <?=$_data['Data']['user_prefix']?>, <?=$_data['Data']['age']?> )
				</span>
			</td>
			<td style="border:1px solid #dfdfdf; border-right:0 none; border-top:0 none; padding:25px 0 25px 30px; vertical-align:top; text-align:left;">
				<h4 class="font_18 noto500 ellipsis_line_1" style="width:500px; letter-spacing:-1px; margin:0;">
					[<?=$_data['Data']['number']?>]  <?=$_data['OPTION']['bgcolor1']?>

					<a href="./document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>" title="<?=$_data['Data']['title']?>" class="" style="color:#333"><?=$_data['OPTION']['color']?><?=$_data['OPTION']['bolder']?> <?=$_data['Data']['title']?> </a><?=$_data['OPTION']['bgcolor2']?>

				</h4>
				<ul style="margin-top:15px;">
					<li style="color:#666666; letter-spacing:-1px;" class="font_15 noto400"><?=$_data['Data']['job_type']?></li>
					<li style="letter-spacing:-1px; color:#999; margin-top:3px;" class="font_15 noto400"><?=$_data['Data']['grade_lastgrade']?> : <?=$_data['Data']['grade_last_schoolType']?></li>
					<li style="color:#999999; letter-spacing:-1px; margin-top:3px;" class="font_15 noto400"><?=$_data['Data']['job_where']?> &nbsp;<?=$_data['Data']['work_otherCountry']?></li>
				</ul>
			</td>
			<td style="width:290px; border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; border-top:0 none">
				<div style="padding:28px 30px; line-height:22px; margin:0 auto">
					<span style="display:block; letter-spacing:-1px; color:#999999" class="font_15 noto400">
						희망급여 : <span style="letter-spacing:0"><?=$_data['Data']['grade_money_type']?> <?=$_data['Data']['grade_money']?></span>
					</span>
				</div>
			</td>
			<td style="width:140px; border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf; border-top:0 none; text-align:right">
				<div style="padding:30px 0; line-height:24px;">
					<span class="font_14 noto400" style="color:#333; letter-spacing:-1.2px; display:inline-block; width:136px; text-align:center; height:30px; line-height:30px; background:url('./img/main_latest_bg.png') 0 0 no-repeat">
						<?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?>

					</span>
				</div>
			</td>
		</tr>
	</table>
</div>
<? }
?>