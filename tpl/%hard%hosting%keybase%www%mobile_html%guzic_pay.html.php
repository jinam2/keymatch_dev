<? /* Created by SkyTemplate v1.1.0 on 2023/04/17 19:13:52 */
function SkyTpl_Func_1720361273 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
var prevLayerName	= "";

function noViewGo(layerName)
{
	document.all[layerName].style.display = 'none';
}

function startPopup(layerName)
{

	if ( prevLayerName != "" )
	{
		document.all[prevLayerName].style.display="none";
	}
	document.all[layerName].style.display = '';
	prevLayerName	= layerName;

}
</script>

<?=$_data['pay_java']?>

<ul class="ad_service_info">
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>파워링크 인재정보</th>
				</tr>
				<tr>
					<td style="text-align:center;">
						메인 - 최근초빙정보 하단에 배치<br/>
						서브 - 스페셜 인재정보 하단에 배치
					</td>
				</tr>
				<tr>
					<td>
						<?=$_data['PAY']['guin_powerlink']?>

					</td>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>포커스 인재정보</th>
				</tr>
				<tr>
					<td>
						메인 - 최근초빙정보 하단에 배치<br/>
						서브 - 검색창 하단에 배치
					</td>
				</tr>
				<tr>
					<td><?=$_data['PAY']['guin_focus']?></td>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>스페셜 인재정보</th>
				</tr>
				<tr>
					<td>
						메인 - 최근초빙정보 하단에 배치<br/>
						서브 - 포커스 인재정보 하단에 배치
					</td>
				</tr>
				<tr>
					<td><?=$_data['PAY']['guin_special']?></td>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>아이콘 효과</th>
				</tr>
				<tr>
					<td>
						이력서 리스트제목에  <img src="img/icon_icon.gif" align="absmiddle" style="vertical-align:middle"> 아이콘을 보여줍니다.
					</td>
				</tr>
				<tr>
					<td><?=$_data['PAY']['guin_icon']?></td>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>굵은글씨 효과</th>
				</tr>
				<tr>
					<td>
						이력서 제목글씨를<br>
						<strong style="color:#333; letter-spacing:-1px" class="font_dotum">볼드효과</strong>를 주어 눈에 띄게 합니다.
					</td>
				</tr>
				<tr>
					<td><?=$_data['PAY']['guin_bolder']?></td>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>컬러폰트 효과</th>
				</tr>
				<tr>
					<td>
						이력서 제목글씨에<br>컬러를 주어 눈에 띄게 합니다.
					</td>
				</tr>
				<tr>
					<td><?=$_data['PAY']['guin_color']?></td>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>형광펜 효과</th>
				</tr>
				<tr>
					<td>
						인재정보 제목에 배경색이 표시되어<br>어디든 눈에 띌수 있도록 표시
					</td>
				</tr>
				<tr>
					<td><?=$_data['PAY']['guin_bgcolor']?></td>
				</tr>
			</tbody>
		</table>
	</li>
	<li <?=$_data['Sty']['GuzicUryoDate1']?>>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th><?=$_data['PER_ARRAY_NAME']['9']?></th>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>관리자모드에서 임의 추가가능</th>
				</tr>
				<tr>
					<td>
						<?=$_data['PAY']['GuzicUryoDate1']?>

					</td>
				</tr>
			</tbody>
		</table>
	</li>
	<li <?=$_data['Sty']['GuzicUryoDate2']?>>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th><?=$_data['PER_ARRAY_NAME']['10']?></th>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>관리자모드에서 임의 추가가능</th>
				</tr>
				<tr>
					<td>
						<?=$_data['PAY']['GuzicUryoDate2']?>

					</td>
				</tr>
			</tbody>
		</table>
	</li>
	<li <?=$_data['Sty']['GuzicUryoDate3']?>>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th><?=$_data['PER_ARRAY_NAME']['11']?></th>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>관리자모드에서 임의 추가가능</th>
				</tr>
				<tr>
					<td>
						<?=$_data['PAY']['GuzicUryoDate3']?>

					</td>
				</tr>
			</tbody>
		</table>
	</li>
	<li <?=$_data['Sty']['GuzicUryoDate4']?>>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th><?=$_data['PER_ARRAY_NAME']['12']?></th>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>관리자모드에서 임의 추가가능</th>
				</tr>
				<tr>
					<td>
						<?=$_data['PAY']['GuzicUryoDate4']?>

					</td>
				</tr>
			</tbody>
		</table>
	</li>
	<li <?=$_data['Sty']['GuzicUryoDate5']?>>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th><?=$_data['PER_ARRAY_NAME']['12']?></th>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>관리자모드에서 임의 추가가능</th>
				</tr>
				<tr>
					<td>
						<?=$_data['PAY']['GuzicUryoDate5']?>

					</td>
				</tr>
			</tbody>
		</table>
	</li>
</ul>
<h5 class="front_bar_st_tlt" style="margin-top:40px; margin-bottom:20px;">이력서 스킨</h5>
<ul>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>사용여부</th>
				</tr>
				<tr>
					<td style="padding:0;">
						<div class="pay_guin_tb_noline_m"><?=$_data['PAY']['guin_docskin']?></div>
					</td>
				</tr>
			</tbody>
		</table>
	</li>
	<li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>스킨선택</th>
				</tr>
				<tr>
					<td>
						<div>
							<table cellpadding="0" cellspacing="0" style="width:100%" class="tb_st_04_in_tb">
								<tr>
									<td class="guzic_pay" style="text-align: left; text-align:center">
										<label for="skin_1"><img src="img/skinview1.gif"></label>
										<span class="s_b h_form" style="display:block; padding-top:5px;">
											<label for="skin_1" class="h-radio"><input type="radio" name="doc_skin" id="skin_1" value="doc_skin1.html" style="margin-bottom:2px"><span></span></label>
											<label for="skin_1">1번스킨</label>
										</span>
									</td>
								</tr>
								<tr>
									<td class="guzic_pay"  style="text-align: left; text-align:center">
										<label for="skin_2"><img src="img/skinview2.gif"></label>
										<span class="s_b h_form" style="display:block; padding-top:5px;">
											<label for="skin_2" class="h-radio"><input type="radio" name="doc_skin"  id="skin_2" value="doc_skin2.html" style="margin-bottom:2px"><span></span></label>
											<label for="skin_2">2번스킨</label>
										</span>
									</td>
								</tr>
								<tr>
									<td class="guzic_pay"  style="text-align: left; text-align:center">
										<label for="skin_3"><img src="img/skinview3.gif"></label>
										<span class="s_b h_form" style="display:block; padding-top:5px;">
											<label for="skin_3" class="h-radio"><input type="radio" name="doc_skin"  id="skin_3" value="doc_skin3.html" style="margin-bottom:2px"><span></span></label>
											<label for="skin_3">3번스킨</label>
										</span>
									</td>
								</tr>
								<tr>
									<td class="guzic_pay"  style="text-align:left; text-align:center">
										<label for="skin_4"><img src="img/skinview4.gif"></label>
										<span class="s_b h_form" style="display:block; padding-top:5px;">
											<label for="skin_4" class="h-radio"><input type="radio" name="doc_skin" id="skin_4" value="doc_skin4.html" style="margin-bottom:2px"><span></span></label>
											<label for="skin_4"> 4번스킨</label>
										</span>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</li>	
</ul>
<!-- <h5 class="front_bar_st_tlt" style="margin-top:40px; margin-bottom:20px;">아이콘 추가</h5>
 --><!-- <ul>
 	<li>
 		<table class="tb_st_04">
 			<tbody>
 				<tr>
 					<th>아이콘 출력결제</th>
 				</tr>
 				<tr>
 					<td style="padding:0"><div class="pay_guin_tb_noline_m"><?=$_data['PAY']['guin_freeicon']?></div></td>
 				</tr>
 			</tbody>
 		</table>	
 	</li> -->
	<!-- <li>
		<table class="tb_st_04">
			<tbody>
				<tr>
					<th>아이콘 선택</th>
				</tr>
				<tr>
					<td>
						<div>
							<table cellpadding="0" cellspacing="0" style="width:100%" class="">
								<tr>
									<td class="guzic_pay h_form" style="height: 40px; text-align: left;">
										<label for="ico_1" class="h-radio"><input type="radio" name="freeicon" id="ico_1" value="freeicon1.gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_1" style="cursor:pointer">1 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon1.gif" border="0" align="absmiddle">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
										<label for="ico_2" class="h-radio"><input type="radio" name="freeicon"  id="ico_2" value="freeicon2.gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_2" style="cursor:pointer">2 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon2.gif" border="0" align="absmiddle">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
										<label for="ico_3" class="h-radio"><input type="radio" name="freeicon" id="ico_3" value="freeicon3.gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_3" style="cursor:pointer">3 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;" >
										<img src="img/freeicon3.gif" border="0" align="absmiddle" style=";">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
										<label for="ico_4" class="h-radio"><input type="radio" name="freeicon" id="ico_4" value="freeicon4.gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_4" style="cursor:pointer">4 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon4.gif" border="0" align="absmiddle" style=";">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
										<label for="ico_5" class="h-radio"><input type="radio" name="freeicon" id="ico_5" value="freeicon5.gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_5" style="cursor:pointer">5 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon5.gif" border="0" align="absmiddle" style=";">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
										<label for="ico_6" class="h-radio"><input type="radio" name="freeicon" id="ico_6" value="freeicon6gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_6" style="cursor:pointer">6 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon6.gif" border="0" align="absmiddle">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
										<label for="ico_7" class="h-radio"><input type="radio" name="freeicon" id="ico_7" value="freeicon7.gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_7" style="cursor:pointer">7 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon7.gif" border="0" align="absmiddle">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
										<label for="ico_8" class="h-radio"><input type="radio" name="freeicon" id="ico_8" value="freeicon8.gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_8" style="cursor:pointer">8 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon8.gif" border="0" align="absmiddle" style=";">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
										<label for="ico_9" class="h-radio"><input type="radio" name="freeicon" id="ico_9" value="freeicon9.gif" style="margin-bottom:2px;"><span></span></label>
										<label for="ico_9" style="cursor:pointer">9 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon9.gif" border="0" align="absmiddle" style=";">
									</td>
								</tr>
								<tr>
									<td class="guzic_pay h_form"  style="height: 40px; text-align: left;">
											<label for="ico_10" class="h-radio"><input type="radio" name="freeicon" id="ico_10" value="freeicon10.gif" style="margin-bottom:2px;"><span></span></label>
											<label for="ico_10" style="cursor:pointer">10 번아이콘</label>
									</td>
									<td class="guzic_pay" style="height:40px; text-align:right;">
										<img src="img/freeicon10.gif" border="0" align="absmiddle" style=";">
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
		</table>	
	</li> -->
</ul>
<table cellspacing="0" style="width:100%; margin-top:30px">
	<tr>
		<td style="text-align:right; letter-spacing:-1.2px; height:65px; background:#666666; padding-right:30px; color:#fff" class="font_18 noto400">
			<span style="vertical-align:middle">총 신청 금액</span> <input type="text" value='0' name="out_total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#fff; font-size:30px; vertical-align:middle; margin-bottom:3px" class="font_tahoma" align="absmiddle" readonly> <span style="vertical-align:middle">원</span>
		</td>
	</tr>
</table>
<input type="text" value='0' name="total" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#ca2222; display:none" class="font_st_12_tahoma" align="absmiddle" readonly>
<? }
?>