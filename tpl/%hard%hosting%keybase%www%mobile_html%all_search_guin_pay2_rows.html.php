<? /* Created by SkyTemplate v1.1.0 on 2023/04/11 10:35:11 */
function SkyTpl_Func_2833961544 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="position:relative; padding:13px 0; border-bottom:2px solid #e8e8e8" class="sub_list_in" >
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td>
				<div>
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td onclick="location.href='./guin_detail.php?num=<?=$_data['Data']['number']?>&pg=<?=$_data['pg']?>&cou=0&action=search&area_read=&jobclass_read=&edu_read=&career_read=&gender_read=&title_read=&type_read=&pay_read='">
								<table class="tbl" style="width:100%">
									<tr>
										<td>
											<div class="ellipsis_line1 font_14 font_malgun" style="letter-spacing:-1px; font-weight:bold; color:#<?=$_data['배경색']['모바일_서브색상']?>">
												<?=$_data['Data']['name']?>

											</div>
										</td>
									</tr>
									<tr>
										<td style="padding-top:10px">
											<div class="ellipsis_line2 font_16 font_malgun" style="line-height:150%;">
												<?=$_data['Data']['title']?>

											</div>
										</td>
									</tr>
									<tr>
										<td style="padding-top:10px">
											<div class="ellipsis_line1 font_14 font_malgun" style="line-height:150%;">
												<span style="letter-spacing:-1px; color:#396ed0"><?=$_data['Data']['si1']?> <?=$_data['Data']['gu1']?></span>&nbsp;&nbsp;|&nbsp;&nbsp;~<?=$_data['Data']['guin_end_date']?>&nbsp;&nbsp;|&nbsp;&nbsp;<span style="letter-spacing:-1px;"><?=$_data['Data']['guin_career']?></span>
											</div>
										</td>
									</tr>
									<tr>
										<td style="padding:5px 0">
											<?=$_data['Data']['adult_guin_icon']?> <?=$_data['Data']['식사제공']?> <?=$_data['Data']['보너스']?> <?=$_data['Data']['주5일근무']?> <?=$_data['Data']['우대조건']?> <?=$_data['Data']['freeicon_com_out']?>

										</td>
									</tr>
								</table>
							</td>
							<td style="padding-left:10px; text-align:right; width:23px">
								<img src="mobile_img/rows_open_btn.png"  style="width:23px;"alt="정보 더보기" onClick="change2_text('room2_text_1_<?=$_data['NEW']['number']?>','category1_on_<?=$_data['NEW']['number']?>','category1_off_<?=$_data['NEW']['number']?>','1', 'off')"  id="category1_off_<?=$_data['NEW']['number']?>"><img src="./mobile_img/rows_close_btn.png" style=" display:none; width:23px" alt="정보 더보기 닫기" onClick="change2_text('room2_text_1_<?=$_data['NEW']['number']?>','category1_on_<?=$_data['NEW']['number']?>','category1_off_<?=$_data['NEW']['number']?>','1', 'on')"  id="category1_on_<?=$_data['NEW']['number']?>">
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
	<div id='room2_text_1_<?=$_data['NEW']['number']?>' style="display:none;">
		<table class="tbl" style="width:100%; margin:10px 0" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<th class="font_malgun font_14" style="width:10%px; letter-spacing:-1px; color:#1a1a1a; text-align:left; padding:5px 10px 5px 0;">급여조건</th>
				<td class="font_malgun font_14" style="letter-spacing:-1px; color:#1a1a1a; text-align:left; padding:5px 0;"><?=$_data['Data']['guin_pay_type']?> <?=$_data['Data']['guin_pay']?></td>
			</tr>
			<tr>
				<th class="font_malgun font_14" style="width:80px; letter-spacing:-1px; color:#1a1a1a; text-align:left; padding:5px 10px 5px 0;">초빙직급</th>
				<td class="font_malgun font_14" style="letter-spacing:-1px; color:#1a1a1a; text-align:left; padding:5px 0;"><?=$_data['Data']['guin_grade']?></td>
			</tr>
			<tr>
				<th class="font_malgun font_14" style="width:80px; vertical-align:top; letter-spacing:-1px; color:#1a1a1a; text-align:left; padding:5px 10px 5px 0;">담당업무</td>
				<td class="font_malgun font_14" style="letter-spacing:-1px; color:#1a1a1a; text-align:left; padding:5px 0;">
					<span class="ellipsis_line2" style="line-height:140%"><?=$_data['Data']['guin_work_content']?></span></th>
			</tr>
			<tr>
				<th class="font_malgun font_14" style="width:80px; letter-spacing:-1px; color:#1a1a1a; text-align:left; padding:5px 10px 5px 0;">학력조건</th>
				<td class="font_malgun font_14" style="letter-spacing:-1px; color:#1a1a1a; text-align:left; padding:5px 0;"><?=$_data['Data']['guin_edu']?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:right">
					<?=$_data['스크랩버튼']?>

					<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>" style="vertical-align:middle">
						<img src="img/rows_more.gif" style="vertical-align:middle" class="onepx">
					</a>
				</td>
			</tr>
		</table>
	</div>
</div>

<? }
?>