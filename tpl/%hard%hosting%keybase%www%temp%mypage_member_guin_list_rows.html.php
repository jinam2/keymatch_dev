<? /* Created by SkyTemplate v1.1.0 on 2023/03/13 17:31:23 */
function SkyTpl_Func_2317826288 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse: collapse;">
		<tr>
			<td style="width:180px; background:#f5f7fb; text-align:center; border:1px solid #dfdfdf; border-left:0 none; border-top:0 none !important">
				<span style="display:block">
					<a href="com_info.php?com_info_id=<?=$_data['GUIN_INFO']['guin_id']?>&guin_number=<?=$_data['GUIN_INFO']['number']?>" target="_blank">
						<img src="<?echo happy_image('GUIN_INFO.logo','가로85','세로33','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로축소','2') ?>" alt="기업로고" width="80" height="36" onError="this.src='./img/img_noimage_100x36.jpg'" style="border:1px solid #dedede;">
					</a>
				</span>
				<span style="padding:8px 0; display:block; letter-spacing:-1px; color:#333" class="font_16 noto400">
					<?=$_data['GUIN_INFO']['guin_end_text']?>

				</span>
				<span class="font_13 noto400" style="display:block; color:#fff; margin:0 auto; width:80px; height:20px; border-radius:10px; background:#<?=$_data['배경색']['메인페이지']?>; text-align:center;">
					<?=$_data['GUIN_INFO']['guin_end_dday']?>

				</span>
			</td>
			<td style="border:1px solid #dfdfdf; padding:25px 30px; vertical-align:top; text-align:left; border-top:0 none !important">
				<h4 class="font_17 noto400" style="letter-spacing:-1px; padding-bottom:15px; margin:0;">
					<a href='./guin_detail.php?num=<?=$_data['GUIN_INFO']['number']?>' style="color:#333"><?=$_data['GUIN_INFO']['guin_title']?></a>
				</h4>
				<table cellpadding="0"cellspacing="0" style="width:100%; line-height:23px" class="resister_rows">
					<tr>
						<th class="font_14 noto400">담당업무</th>
						<td class="font_14 noto400"><?=$_data['GUIN_INFO']['guin_work_content']?></td>
					</tr>
					<tr>
						<th class="font_14 noto400">직종</th>
						<td class="font_14 noto400"><?=$_data['GUIN_INFO']['guin_job_1']?></td>
					</tr>
					<tr>
						<th class="font_14 noto400">급여</th>
						<td class="font_14 noto400"><?=$_data['GUIN_INFO']['guin_pay']?></td>
					</tr>
					<tr>
						<th class="font_14 noto400">학력</th>
						<td class="font_14 noto400"><?=$_data['GUIN_INFO']['guin_edu']?></td>
					</tr>
					<tr>
						<th class="font_14 noto400">경력</th>
						<td class="font_14 noto400"><?=$_data['GUIN_INFO']['guin_career']?></td>
					</tr>
				</table>
			</td>
			<td style="width:220px; border:1px solid #dfdfdf; background:#f1f7f6; border-top:0 none !important">
				<div style="padding:40px 30px; line-height:24px">
					<span style="display:block; letter-spacing:-1px" class="font_15 noto500">
						<a href="guzic_list.php?file=member_guin_chong&number=<?=$_data['GUIN_INFO']['number']?>" style="">
							전체지원자 <span style="color:#47acc2"><?=$_data['GUIN_STATS']['total_jiwon']?></span> 명
						</a>
					</span>
					<span style="display:block; letter-spacing:-1px" class="font_15 noto400">
						<a href="guzic_list.php?file=member_guin_noview&number=<?=$_data['GUIN_INFO']['number']?>&myroom=&read_ok=N">
							미열람 <span style="color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['GUIN_STATS']['total_mi']?></span> 명
						</a>
					</span>
					<span style="display:block; letter-spacing:-1px" class="font_15 noto400">
						<a href="guzic_list.php?file=member_guin_ok&number=<?=$_data['GUIN_INFO']['number']?>&myroom=&doc_ok=Y">
							예비합격 <span style="color:#333"><?=$_data['GUIN_STATS']['total_pre_pass']?></span> 명
						</a>
					</span>
					<span style="display:block; letter-spacing:-1px" class="font_15 noto400">
						<a href="guzic_list.php?file=member_guin_scrap&number=<?=$_data['GUIN_INFO']['number']?>">
							스크랩 <span style="color:#333"><?=$_data['GUIN_STATS']['total_scrap']?></span> 명
						</a>
					</span>
				</div>
			</td>
			<td style="width:230px; text-align:center; border:1px solid #dfdfdf; border-right:0 none; border-top:0 none !important">
				<div style="padding:40px 30px; line-height:24px">
					<span style="display:block; letter-spacing:-1px" class="font_15 noto400">
						등록일 : <?=$_data['GUIN_INFO']['guin_date']?>

					</span>
					<span style="display:block; letter-spacing:-1px" class="font_15 noto400">
						수정일 : <?=$_data['last_update_date']?>

					</span>
					<span style="display:block; letter-spacing:-1px" class="font_15 noto400">
						마감일 : <?=$_data['GUIN_INFO']['guin_end_date']?>

					</span>
				</div>
			</td>
		</tr>
	</table>
	<div style="padding:5px 0; border-bottom:1px solid #dfdfdf">
		<table cellpadding="0" cellspacing="0" style="width:100%;">
			<tr>
				<td>
					<?=$_data['GUIN_INFO']['btn_jump']?>

					<a href='./member_option_pay.php?mode=pay&number=<?=$_data['GUIN_INFO']['number']?>'>
						<img src="img/bt_myroom_com_sth_btn.gif" border="0" align="absmiddle" style="margin-right:2px;">
					</a>
					<?=$_data['banner_info']?>

					<a href="<?=$_data['GUIN_INFO']['doc_searched_link']?>">
						<img src="img/bt_myroom_com_ppl.gif" border="0" align="absmiddle">
					</a>
				</td>
				<td style="text-align:right">
					<a href='./guin_mod.php?mode=mod&num=<?=$_data['GUIN_INFO']['number']?>'>
						<img src="img/bt_myroom_com_mod.gif" border="0" align="absmiddle" style="margin-right:2px;">
					</a>
					<a href="javascript:magam('./member_guin.php?mode=magam&num=<?=$_data['GUIN_INFO']['number']?>');">
						<img src="img/bt_myroom_com_end.gif" border="0" align="absmiddle" style="margin-right:2px;">
					</a>
					<a href="javascript:bbsdel2('./del.php?mode=guin&num=<?=$_data['GUIN_INFO']['number']?>');">
						<img src="img/bt_myroom_com_del.gif" border="0" align="absmiddle" >
					</a>
				</td>
			</tr>
		</table>
	</div>
</div>





<? }
?>