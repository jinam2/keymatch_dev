<? /* Created by SkyTemplate v1.1.0 on 2023/03/31 09:33:40 */
function SkyTpl_Func_Package ($TPL,$DATA,$_index,$_size,$_col) { if (is_null($DATA) && $_size==1) $DATA=array($GLOBALS); $to=$_index+$_col; if ($to>$_size) $to=$_size; for (;$_index<$to;$_index++) { $_data=$DATA[$_index]; ?>


		<div style="margin-bottom:10px">
			<div class="snb_area" style="border:1px solid #cdcdcd; border-bottom:0; position:relative; background:url('./mobile_img/search_line_bg.gif') 0 bottom repeat">
				<table class="tbl snb" cellpadding="0" style="width:100%">
					<tr>
						<td style="color:#424242; padding:12px; letter-spacing:-1.5px; font-weight:bold" class="font_20 font_malgun"><?=$_data['chk_pay']?> <?=$_data['title']?></td>
					</tr>
				</table>
			</div>
			<div>
				<table cellpadding="0" cellspacing="0" style="width:100%" class="regist_chart_01">
					<tr>
						<th  style="padding:10px; background:#fafafa; border:1px solid #dddddd">
							<?=$_data['comment']?>

						</th>
					</tr>
					<tr>
						<td class="font_18" style="border:1px solid #dddddd; border-bottom:0 none; padding:10px; line-height:180%;">
							<?=$_data['uryo_detail']?>

						</td>
					</tr>
					<tr>
						<td style="border:1px solid #dddddd; text-align:right; background:#fafafa; padding:10px; border-top:0 none">
							<strong class="font_18 font_malgun" style="color:#ff6600"><?=$_data['price_comma']?> 원</strong>
						</td>
					</tr>
				</table>
			</div>

		</div>
		<? }
if (!$_size) { ?>

		<div class="font_18 font_malgun" style="text-align:center">
			결제가능한 패키지유료옵션 설정이 없습니다.
		</div>
		
<? } }

function SkyTpl_Func_1585004056 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language='JavaScript' src='./js/calendar.js' type='text/javascript'></script>
<script language=javascript>
	createLayer('Calendar');
</script>
<style>
	.my_tablecell .sub{position:absolute; right:0; top:0; text-align:right; height:40px; line-height:40px; color:#<?=$_data['배경색']['모바일_기본색상']?>}
</style>
<h2 style="padding:20px 0; background:url('./mobile_img/m_tit_bg.gif') 0 0 repeat; text-align:center; letter-spacing:-1.5px; font-weight:bold; border-bottom:2px solid #dbdbdb; line-height:130%" class="font_24 font_malgun" onclick="location.href='happy_member.php?mode=mypage'">
	<span style="color:#<?=$_data['배경색']['모바일_서브색상']?>"><?=$_data['MEM']['user_name']?>님의</span> 마이페이지
</h2>
<div style="padding:10px; background:#ececec">
	<h3 class="font_malgun font_22" style="position:relative; padding:10px 0; letter-spacing:-1.5px; color:#333; border-bottom:2px solid #000; margin-top:10px">
		유료서비스
	</h3>
	<?include_template('member_count_com.html') ?>

	<div class="banner_img" style="">
		<?echo happy_banner('모바일기업패키지결제','배너제목','랜덤') ?>

	</div>
</div>
<div style="padding:10px">
	<h3  class="font_20 font_malgun" style="position:relative; padding:5px 0; letter-spacing:-1.5px; color:#333;  margin-top:10px">
		유료옵션별 채용공고
	</h3>
	<div style="border:1px solid #ddd; background:#fafafa; padding:10px">
		<table cellspacing="" cellpadding="10" style="width:100%" class="my_tablecell">
			<tr >
				<th class="" <?=$_data['Count']['guin_banner1_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_banner1']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_banner1_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_banner1_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
				<th <?=$_data['Count']['guin_banner2_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_banner2']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_banner2_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_banner2_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
			</tr>
			<tr>
				<th class="" <?=$_data['Count']['guin_banner3_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_banner3']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_banner3_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_banner3_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
				<th <?=$_data['Count']['guin_bold_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_bold']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_bold_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_bold_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
			</tr>
			<tr>
				<th class="" <?=$_data['Count']['guin_list_hyung_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_list_hyung']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_list_hyung_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_list_hyung_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
				<th <?=$_data['Count']['guin_pick_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_pick']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_pick_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_pick_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
			</tr>
			<tr>
				<th class="" <?=$_data['Count']['guin_ticker_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_ticker']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_ticker_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_ticker_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
				<th <?=$_data['Count']['guin_bgcolor_com_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_bgcolor_com']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_bgcolor_com_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_bgcolor_com_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
			</tr>
			<tr>
				<th class="" <?=$_data['Count']['freeicon_comDate_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0; border-bottom:0 none !important">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['freeicon_comDate']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['freeicon_comDate_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['freeicon_comDate_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>


				<th <?=$_data['Count']['guin_uryo3_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0; border-bottom:0 none !important">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_uryo3']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_uryo3_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_uryo3_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
			</tr>
			<tr>
				<th class="" <?=$_data['Count']['guin_uryo1_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_uryo1']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_uryo2_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_uryo1_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
				<th <?=$_data['Count']['guin_uryo2_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_uryo2']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_uryo2_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_uryo2_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
			</tr>
			<tr>
				<th <?=$_data['Count']['guin_uryo4_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_uryo4']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_uryo4_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_uryo4_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>

				<th <?=$_data['Count']['guin_uryo5_style']?>>
					<div class="sth_area" style="margin:0">
						<table cellpadding="0" cellspacing="0" style="width:100%">
							<tr>
								<th class="title" style="height:50px; line-height:50px; vertical-align:top; padding:0 10px 10px 0">
									<div class="ellipsis_line1" style="position:relative; letter-spacing:-1.5px">
										<?=$_data['Count']['guin_uryo5']?>

										<span class="sub" style="top:16px; line-height:130%">
											<span style="color:#<?=$_data['배경색']['모바일_기본색상2']?>; line-height:100%; letter-spacing:-1.5px"><?=$_data['Count']['guin_uryo5_cnt']?>건 광고중</span><br/>
											<span style="color:#999; font-weight:normal">(최대 <?=$_data['Count']['guin_uryo5_max_cnt']?>)</span>
										</span>
									</div>
								</th>
							</tr>
						</table>
					</div>
				</th>
			</tr>
		</table>
	</div>
	<h3 class="font_malgun font_22" style="position:relative; padding:10px 0; letter-spacing:-1.5px; color:#333;  margin-top:10px">
		패키지 옵션결제
	</h3>
	<?=$_data['msg']?><div style="display:none;"><?=$_data['pay_java']?></div>

	<form method="post" name=payform>
	<input type=hidden name=total_get>
	<input type=hidden name=total_price value='0'>
	<input type=hidden name=gou_number value='<?=$_data['gou_number']?>'>
	<div style="">
		<? if (is_array($_data['Package'])) $TPL->assign('Package',$_data['Package']); $TPL->tprint('Package'); $GLOBALS['Package']=''; ?>

	</div>
	<table cellspacing="0" style="width:100%; margin-top:20px">
		<tr>
			<td style="text-align:left; letter-spacing:-1.2px; height:65px; background:#<?=$_data['배경색']['모바일_기본색상']?>; padding-left:25px; color:#fff" class="font_18 font_malgun">
				<span style="vertical-align:middle">총 신청 금액</span>
			</td>
			<td style="text-align:right; padding-right:25px; letter-spacing:-1.2px; height:65px; background:#<?=$_data['배경색']['모바일_기본색상']?>;" class="font_18 font_malgun">
				<input type="text" value='0' name="total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#fff; vertical-align:middle; margin-bottom:3px" class="font_malgun" align="absmiddle" readonly> <span style="vertical-align:middle; color:#fff" class="font_14 font_malgun">원</span>
			</td>
		</tr>
	</table>
	<div style="margin:20px 0 30px 0;" align="center" class="pay_btn">
		<?=$_data['PAY']['bank']?> <?=$_data['PAY']['card']?> <?=$_data['PAY']['phone']?> <?=$_data['PAY']['bank_soodong']?> <?=$_data['PAY']['point']?> <?=$_data['무료등록버튼']?></div>
	</div>
	</form>
</div>
<? }
?>