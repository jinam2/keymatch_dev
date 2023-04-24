<? /* Created by SkyTemplate v1.1.0 on 2023/03/31 09:33:40 */
function SkyTpl_Func_1379625477 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table cellpadding="0" cellspacing="0" style="width:100%;  table-layout:fixed; margin-top:20px">
	<tr>
		<td style="padding-right:5px; padding-bottom:10px; " >
			<div style="background:#fff; border:1px solid #ddd; padding:10px">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td class="noto400 font_16">포인트</td>
					</tr>
					<tr>
						<td class="noto400 font_16"  style="padding-top:10px; font-weight:bold">
							<?=$_data['MEM']['point_comma']?> P
						</td>
					</tr>
					<tr>
						<td style="padding-top:10px">
							<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse; table-layout:fixed">
								<tr>
									<td class="noto400 " style="border:1px solid #<?=$_data['배경색']['모바일_기타페이지']?>">
										<a href="my_point_charge.php" onfocus='this.blur();'  style="display:block; height:30px; line-height:30px; letter-spacing:-1px; color:#<?=$_data['배경색']['모바일_기타페이지']?>; ; text-align:center; font-weight:bold" class="font_12 noto400">충전하기</a>
									</td>
									<td class="noto400 " style="border:1px solid #999999;">
										<a href="my_point_jangboo.php" style="display:block; text-align:center; height:30px; line-height:30px; letter-spacing:-1px; text-align:center; font-weight:bold" class="font_12 noto400">결제내역</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td style="padding-left:5px; padding-bottom:10px;">
			<div style="background:#fff; border:1px solid #ddd; padding:10px">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td class="noto400 font_16">SMS발송 포인트</td>
					</tr>
					<tr>
						<td class="noto400 font_16"  style="padding-top:10px; font-weight:bold">
							<?=$_data['COMMEMBER']['smspoint_comma']?> P
						</td>
					</tr>
					<tr>
						<td style="padding-top:10px">
							<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse; table-layout:fixed">
								<tr>
									<td class="noto400 " style="border:1px solid #<?=$_data['배경색']['모바일_기타페이지']?>">
										<a href="member_option_pay2.php" onfocus='this.blur();'  style="display:block; ; height:30px; line-height:30px; letter-spacing:-1px; color:#<?=$_data['배경색']['모바일_기타페이지']?>; ; text-align:center; font-weight:bold" class="font_12 noto400">충전하기</a>
									</td>
									<td class="noto400 " style="border:1px solid #999999;">
										<a  href="my_jangboo_com.php" style="display:block; text-align:center; height:30px; line-height:30px; letter-spacing:-1px; text-align:center; font-weight:bold" class="font_12 noto400">결제내역</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	<tr>
		<td style="padding-right:5px; padding-bottom:10px;">
			<div style="background:#fff; border:1px solid #ddd; padding:10px">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td class="noto400 font_16">이력서뷰 유효일</td>
					</tr>
					<tr>
						<td class="noto400 font_16"  style="padding-top:10px; font-weight:bold">
							<?=$_data['COMMEMBER']['docview_period_comma']?> 일
						</td>
					</tr>
					<tr>
						<td style="padding-top:10px">
							<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse; table-layout:fixed">
								<tr>
									<td class="noto400 " style="border:1px solid #<?=$_data['배경색']['모바일_기타페이지']?>">
										<a href="member_option_pay2.php" onfocus='this.blur();'  style="display:block; ; height:30px; line-height:30px; letter-spacing:-1px; color:#<?=$_data['배경색']['모바일_기타페이지']?>; ; text-align:center; font-weight:bold" class="font_12 noto400">결제하기</a>
									</td>
									<td class="noto400 " style="border:1px solid #999999;">
										<a href="my_jangboo_com.php" style="display:block; text-align:center; height:30px; line-height:30px; letter-spacing:-1px; text-align:center; font-weight:bold" class="font_12 noto400">결제내역</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td style="padding-left:5px; padding-bottom:10px;">
			<div style="background:#fff; border:1px solid #ddd; padding:10px">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td class="noto400 font_16">이력서뷰 가능횟수</td>
					</tr>
					<tr>
						<td class="noto400 font_16"  style="padding-top:10px; font-weight:bold">
							<?=$_data['COMMEMBER']['docview_count_comma']?> 일
						</td>
					</tr>
					<tr>
						<td style="padding-top:10px">
							<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse; table-layout:fixed">
								<tr>
									<td class="noto400 " style="border:1px solid #<?=$_data['배경색']['모바일_기타페이지']?>">
										<a href="member_option_pay2.php" onfocus='this.blur();'  style="display:block; ; height:30px; line-height:30px; letter-spacing:-1px; color:#<?=$_data['배경색']['모바일_기타페이지']?>; ; text-align:center; font-weight:bold" class="font_12 noto400">결제하기</a>
									</td>
									<td class="noto400 " style="border:1px solid #999999;">
										<a href="my_jangboo_com.php" style="display:block; text-align:center; height:30px; line-height:30px; letter-spacing:-1px; text-align:center; font-weight:bold" class="font_12 noto400">결제내역</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="">
			<div style="background:#fff; border:1px solid #ddd; padding:10px">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td class="noto400 font_16">보유한 패키지 옵션</td>
					</tr>
					<tr>
						<td style="padding-top:10px">
							<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse; table-layout:fixed">
								<tr>
									<td class="noto400 " style="border:1px solid #<?=$_data['배경색']['모바일_기타페이지2']?>">
										<a href="my_package_list.php" onfocus='this.blur();'  style="display:block; ; height:30px; line-height:30px; letter-spacing:-1px; color:#<?=$_data['배경색']['모바일_기타페이지2']?>; ; text-align:center; font-weight:bold" class="font_12 noto400">보유현황</a>
									</td>
									<td class="noto400 " style="border:1px solid #<?=$_data['배경색']['모바일_기타페이지']?>">
										<a href="member_option_pay_package.php" onfocus='this.blur();'  style="display:block; ; height:30px; line-height:30px; letter-spacing:-1px; color:#<?=$_data['배경색']['모바일_기타페이지']?>; ; text-align:center; font-weight:bold" class="font_12 noto400">결제하기</a>
									</td>
									<td class="noto400 " style="border:1px solid #999999;">
										<a href="my_package_list.php?mode=list" style="display:block; text-align:center; height:30px; line-height:30px; letter-spacing:-1px; text-align:center; font-weight:bold" class="font_12 noto400">결제내역</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>
<? }
?>