<? /* Created by SkyTemplate v1.1.0 on 2023/04/10 10:38:08 */
function SkyTpl_Func_2391903132 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse: collapse;">
		<tr>
			<td style="width:160px; background:#f9fcff; text-align:center; border:1px solid #dfdfdf; border-left:0 none; border-top:0 none !important">
				<span style="display:block">
					<a href="com_info.php?com_info_id=<?=$_data['NEW']['guin_id']?>&guin_number=<?=$_data['NEW']['number']?>" target="_blank"><img src="<?echo happy_image('NEW.logo','가로85','세로33','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로축소','2') ?>" alt="기업로고" width="80" height="36" onError="this.src='./img/img_noimage_100x36.jpg'" style="border:1px solid #dedede;"></a>
				</span>
				<span style="padding:8px 0; display:block; letter-spacing:-1px; color:#333" class="font_16 noto500">
					<a href="com_info.php?com_info_id=<?=$_data['NEW']['guin_id']?>&guin_number=<?=$_data['NEW']['number']?>" style="color:#333"><?=$_data['NEW']['name']?></a>
				</span>
			</td>
			<td style="border:1px solid #dfdfdf; padding:25px 30px; vertical-align:top; text-align:left; border-top:0 none !important">
				<h4 class="font_18 noto500 ellipsis_line_1" style="letter-spacing:-1px; width:560px; overflow:hidden; margin-bottom:5px">
					<a href="guin_detail.php?view_ok=y&num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=0&action=search&area_read=&jobclass_read=&edu_read=&career_read=&gender_read=&title_read=&type_read=&pay_read=" style="color:#333; "><?=$_data['NEW']['title']?></a>
				</h4>
				<table cellpadding="0"cellspacing="0" style="width:100%; line-height:22px" class="resister_rows">
					<tr>
						<td class="font_15 noto400" style="color:#666;"><?=$_data['NEW']['guin_work_content']?></td>
					</tr>
					<tr>
						<td class="font_15 noto400" style="color:#999;"><?=$_data['NEW']['guin_end_date']?></td>
					</tr>
				</table><?=$_data['NEW']['com_job']?>

			</td>
			<td style="width:240px; border:1px solid #dfdfdf; border-top:0 none !important">
				<div style="padding:25px 30px; line-height:24px">
					<span style="display:block; letter-spacing:-1px; color:#999999" class="font_15 noto400">
						<span>
							급여 <span style="color:#333; margin-left:10px; letter-spacing:-1px"> <?=$_data['NEW']['guin_pay']?></span>
						</span>
					</span>
					<span style="display:block; letter-spacing:-1px; color:#999999" class="font_15 noto400">
						학력 <span style="color:#333; margin-left:10px; "><?=$_data['NEW']['guin_edu']?></span>
					</span>
					<span style="display:block; letter-spacing:-1px; color:#999999" class="font_15 noto400">
						경력 <span style="color:#333; margin-left:10px;"><?=$_data['NEW']['guin_career']?></span>
					</span>
				</div>
			</td>
			<td style="width:175px; border:1px solid #dfdfdf; border-right:0 none; border-top:0 none !important; text-align:center">
				<div style="padding:30px 30px; line-height:24px;">
					<span style="display:block; letter-spacing:-1.2px" class="font_15 noto400">
						<a href="document_view.php?number=<?=$_data['NEW']['doc_number']?>"><img src="img/btn_guzic_view.gif" border="0" align="absmiddle" alt="이력서명 : <?=$_data['DocData']['title']?>"></a>
					</span>
					<span style="display:block; letter-spacing:-1.2px; margin-top:5px" class="font_15 noto400">
						<a href="javascript:;" onclick="want_del('<?=$_data['NEW']['want_number']?>','<?=$_data['jiwon_type']?>')"><img src="img/btn_scrap_del.gif" border="0" align="absmiddle" alt="삭제버튼">
					</span>
				</div>
			</td>
		</tr>
	</table>
</div>
<? }
?>