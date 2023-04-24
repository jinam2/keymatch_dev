<? /* Created by SkyTemplate v1.1.0 on 2023/03/21 09:55:05 */
function SkyTpl_Func_Package ($TPL,$DATA,$_index,$_size,$_col) { if (is_null($DATA) && $_size==1) $DATA=array($GLOBALS); $to=$_index+$_col; if ($to>$_size) $to=$_size; for (;$_index<$to;$_index++) { $_data=$DATA[$_index]; ?>


	<tr>
		<td style="border:1px solid #dce3e2; text-align:center">
			<?=$_data['chk_pay']?>

		</td>
		<td style="border:1px solid #dce3e2; text-align:left; padding:20px">
			<span class="font_16 noto500" style="color:#333; display:block; padding-bottom:7px"><?=$_data['title']?></span>
			<span class="font_11 font_dotum" style="letter-spacing:-1px; line-height:18px; color:#999">
				<?=$_data['comment']?>

			</span>
		</td>
		<td class="noto400 font_13" style="border:1px solid #dce3e2; padding:20px; line-height:24px; color:#999">
			<?=$_data['uryo_detail']?>

		</td>
		<td style="border:1px solid #dce3e2; text-align:right; padding-right:20px">
			<strong class="font_tahoma" style="font-size:30px; color:#333"><?=$_data['price_comma']?></strong>
			<span class="noto400 font_14" style="color:#333">원</span>
		</td>
	</tr>
	<? }
if (!$_size) { ?>

	<tr>
		<td align="center" colspan="4" class="noto400 font_14" style="border:1px solid #dce3e2;">결제가능한 패키지유료옵션 설정이 없습니다.</td>
	</tr>
	
<? } }

function SkyTpl_Func_2185449671 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language='JavaScript' src='./js/calendar.js' type='text/javascript'></script>
<script language=javascript>
	createLayer('Calendar');
</script>
<?call_now_nevi('패키지옵션 결제') ?>

<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	유료서비스
</div>
<?include_template('member_count_com.html') ?>

<div style="margin:20px 0;">
	<?echo happy_banner('패키지옵션배너','배너제목','랜덤') ?>

</div>

<?=$_data['msg']?><div style="display:none;"><?=$_data['pay_java']?></div>

<form method="post" name=payform>
<input type=hidden name=total_get>
<input type=hidden name=total_price value='0'>
<input type=hidden name=gou_number value='<?=$_data['gou_number']?>'>
<div style="border:2px solid #666666; margin-top:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td class="font_16 noto500" style="padding-left:20px; background:#f8f8f8; color:#333; letter-spacing:-1.2px; height:46px; border-bottom:1px solid #dfdfdf; font-weight:bold">
				유료옵션별 채용공고
			</td>
			<td  class="font_12 font_gulim" style="padding-right:20px; background:#f8f8f8;  letter-spacing:-1.2px; height:46px; border-bottom:1px solid #dfdfdf; text-align:right;">
				내가 등록한 채용공고 중 옵션이 적용된 채용공고의 개수입니다
			</td>
		</tr>
		<tr>
			<td style="padding:20px" colspan="2">
				<div style="overflow:hidden; display:inline-block; border:1px solid #dfdfdf;">
					<div <?=$_data['Count']['guin_banner1_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal; border-bottom:1px solid #dfdfdf'><?=$_data['Count']['guin_banner1']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf'>
									<?=$_data['Count']['guin_banner1_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_banner1_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_banner2_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf'><?=$_data['Count']['guin_banner2']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf'>
									<?=$_data['Count']['guin_banner2_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_banner2_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_banner3_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf'><?=$_data['Count']['guin_banner3']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf'>
									<?=$_data['Count']['guin_banner3_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_banner3_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_bold_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf'><?=$_data['Count']['guin_bold']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf'>
									<?=$_data['Count']['guin_bold_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_bold_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_list_hyung_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf'><?=$_data['Count']['guin_list_hyung']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf'>
									<?=$_data['Count']['guin_list_hyung_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_list_hyung_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_pick_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf'><?=$_data['Count']['guin_pick']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf'>
									<?=$_data['Count']['guin_pick_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_pick_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_ticker_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf'><?=$_data['Count']['guin_ticker']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf'>
									<?=$_data['Count']['guin_ticker_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_ticker_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_bgcolor_com_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf'><?=$_data['Count']['guin_bgcolor_com']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf'>
									<?=$_data['Count']['guin_bgcolor_com_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_bgcolor_com_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['freeicon_comDate_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf; border-bottom:0 none'><?=$_data['Count']['freeicon_comDate']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf; border-bottom:0 none'>
									<?=$_data['Count']['freeicon_comDate_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['freeicon_comDate_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_uryo1_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf; border-bottom:0 none'><?=$_data['Count']['guin_uryo1']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf; border-bottom:0 none'>
									<?=$_data['Count']['guin_uryo1_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_uryo1_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_uryo2_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf; border-bottom:0 none'><?=$_data['Count']['guin_uryo2']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf; border-bottom:0 none'>
									<?=$_data['Count']['guin_uryo2_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_uryo2_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_uryo3_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf; border-bottom:0 none'><?=$_data['Count']['guin_uryo3']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf; border-bottom:0 none'>
									<?=$_data['Count']['guin_uryo3_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_uryo3_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_uryo4_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf; border-bottom:0 none'><?=$_data['Count']['guin_uryo4']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf; border-bottom:0 none'>
									<?=$_data['Count']['guin_uryo4_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_uryo4_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
					<div <?=$_data['Count']['guin_uryo5_style']?> class="f_l" style="width:50%;">
						<table cellspacing="0" cellpadding="0" style="width:100%; border:0 none" class="my_tablecell">
							<tr>
								<th class='title' style='font-weight:normal;; border-bottom:1px solid #dfdfdf; border-bottom:0 none'><?=$_data['Count']['guin_uryo5']?></th>
								<td class='sub h_form font_15 noto400' style=' padding:10px 20px; color:#333; width:337px; border-bottom:1px solid #dfdfdf; border-bottom:0 none'>
									<?=$_data['Count']['guin_uryo5_cnt']?>건 광고중 <span style="color:#999999">(허용최대개수:<?=$_data['Count']['guin_uryo5_max_cnt']?>)</span>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>패키지 옵션결제
</h3>

<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;; table-layout:fixed; ">
	<tr>
		<th class="font_14 noto500" style="width:60px; height:42px; border:1px solid #dce3e2; border-top:1px solid #ccc !important; background:#f8f8f9; letter-spacing:-1px;">선택</th>
		<th class="font_14 noto500"  style="width:275px; border:1px solid #dce3e2; border-top:1px solid #ccc !important; background:#f8f8f9; letter-spacing:-1px;">광고종류</th>
		<th class="font_14 noto500"  style="width:280px; border:1px solid #dce3e2; border-top:1px solid #ccc !important; background:#f8f8f9; letter-spacing:-1px;">서비스내용</th>
		<th class="font_14 noto500"  style="border:1px solid #dce3e2; border-top:1px solid #ccc !important; background:#f8f8f9; letter-spacing:-1px;">가격안내</th>
	</tr>
	<? if (is_array($_data['Package'])) $TPL->assign('Package',$_data['Package']); $TPL->tprint('Package'); $GLOBALS['Package']=''; ?>

</table>

<table cellspacing="0" style="width:100%; margin-top:30px">
	<tr>
		<td style="text-align:right; letter-spacing:-1.2px; height:65px; background:#666666; padding-right:30px; color:#fff" class="font_18 noto400">
			<span style="vertical-align:middle">총 신청 금액</span> <input type="text" value='0' name="total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#fff; font-size:30px; vertical-align:middle; margin-bottom:3px" class="font_tahoma" align="absmiddle" readonly> <span style="vertical-align:middle">원</span>
		</td>
	</tr>
</table>

<div style="margin:20px 0 30px 0;" align="center">
	<?=$_data['PAY']['bank']?> <?=$_data['PAY']['card']?> <?=$_data['PAY']['phone']?> <?=$_data['PAY']['bank_soodong']?> <?=$_data['PAY']['point']?> <?=$_data['무료등록버튼']?>

</div>
</form>

<? }
?>