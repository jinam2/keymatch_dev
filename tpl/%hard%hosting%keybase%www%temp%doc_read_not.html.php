<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:50:17 */
function SkyTpl_Func_1247388468 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!--
기본적으로 이력서의 상세화면을 볼수없을때 들어가야 하는 페이지이므로
결제페이지의 링크가 출력이 되어야 합니다.
sms 문자 발송 건수가 출력이 되어야 합니다.
-->
<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse: collapse; table-layout:fixed;">
	<tr>
		<td>
			<div style="padding:15px 30px; ">
				<table cellpadding="0" cellspacing="0" style="">
					<tr>
						<td>
							<img src="./img/doc_view_ico_01.gif">
						</td>
						<td>
							<div style="padding-left:20px">
								<table cellpadding="0" cellspacing="0" style="width:100%">
									<tr>
										<td class="font_16 noto400" style="letter-spacing:-1px; color:#333">인재정보보기 서비스 (횟수별)</td>
									</tr>
									<tr>
										<td class="font_22 noto500" style="color:#333; padding-left:5px">0 회</td>
									</tr>
									<tr>
										<td class="font_16 noto400" style="letter-spacing:-1px; color:#333; padding-top:5px">인재정보보기 서비스 (기간별)</td>
									</tr>
									<tr>
										<td class="font_22 noto500" style="color:#333; padding-left:5px">0 회</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td>
			<div style="padding:15px 30px; ">
				<table cellpadding="0" cellspacing="0" style="">
					<tr>
						<td>
							<img src="./img/doc_view_ico_02.gif">
						</td>
						<td style="">
							<div style="padding-left:20px">
								<table cellpadding="0" cellspacing="0" style="">
									<tr>
										<td class="font_16 noto400" style="letter-spacing:-1px; color:#333">문자메세지 발송 ( 남은횟수 )</td>
									</tr>
									<tr>
										<td class="font_22 noto500" style="color:#333; padding-left:5px">0 회</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td>
			<div style="padding:20px 40px; text-align:center">
				<p class="font_14 noto400" style="color:#999999; letter-spacing:-1px; text-align:center; padding-bottom:10px">열람중인 이력서의 주인공에게</br>연락하고 싶으세요 ?</p>
				<a href="member_option_pay2.php"><img src="img/btn_service.png" title="서비스신청" alt="서비스신청" style="border-radius:5px;"></a>
			</div>
		</td>
	</tr>
</table>

<? }
?>