<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 16:51:31 */
function SkyTpl_Func_326287698 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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


<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;; table-layout:fixed; background:url('./img/bg_dot.gif') 0 bottom repeat-x">
	<tr>
		<th class="font_16 noto400" style="height:42px; color:#666666; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px; text-align:center;"  align="center">미리보기</th>
		<th class="font_16 noto400" style="width:230px; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px;  text-align:center;">서비스명</th>
		<th class="font_16 noto400" style="width:94px; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px; text-align:center; ">유형</th>
		<th class="font_16 noto400" style="width:95px; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px;  text-align:center;">기간/횟수</th>
		<th class="font_16 noto400" style="width:95px; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px;  text-align:center;">금액</th>
		<th class="font_16 noto400" style="width:60px;color:#666666; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px; text-align:center;">신청</th>
	</tr>
	<tr>
		<td style="border:1px solid #ccc; border-left:1px solid #ccc !important; border-bottom:0 none; text-align:center; vertical-align:top; padding-top:45px" rowspan="15">
			<img src="img/member_optionin_pay_per.gif">
		</td>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>">파워링크</span> 인재정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				메인 - 최근초빙정보 하단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 font_dotun">
				서브 - 스페셜 인재정보 하단에 배치
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['guin_powerlink']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>">포커스</span> 인재정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				메인 - 최근초빙정보 하단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 font_dotun">
				서브 - 검색창 하단에 배치
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['guin_focus']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>">스페셜</span> 인재정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				메인 - 최근초빙정보 하단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 font_dotun">
				서브 - 포커스 인재정보 하단에 배치
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['guin_special']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>">아이콘</span> 효과
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px; line-height:18px" class="font_14 font_dotun">
				이력서 리스트제목에<br>
				<img src="img/icon_icon.gif" align="absmiddle" style="vertical-align:middle"> 아이콘을 보여줍니다.
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['guin_icon']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>">굵은글씨</span> 효과
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px; line-height:18px" class="font_14 font_dotun">
				이력서 제목글씨를<br>
				<strong style="color:#333; letter-spacing:-1px" class="font_dotum">볼드효과</strong>를 주어 눈에 띄게 합니다.
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['guin_bolder']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>">컬러폰트</span> 효과
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px; line-height:18px" class="font_14 font_dotun">
				이력서 제목글씨에<br>
				컬러를 주어 눈에 띄게 합니다.
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['guin_color']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>">형광펜</span> 인재정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px; line-height:18px" class="font_14 font_dotun">
				인재정보 제목에 배경색이 표시되어<br>어디든 눈에 띌수 있도록 표시
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['guin_bgcolor']?>

		</td>
	</tr>
	<tr <?=$_data['Sty']['GuzicUryoDate1']?>>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; ">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>"><?=$_data['PER_ARRAY_NAME']['9']?></span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				관리자모드에서 임의 추가가능
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['GuzicUryoDate1']?>

		</td>
	</tr>
	<tr  <?=$_data['Sty']['GuzicUryoDate2']?>}>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; ">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>"><?=$_data['PER_ARRAY_NAME']['10']?></span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				관리자모드에서 임의 추가가능
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['GuzicUryoDate2']?>

		</td>
	</tr>
	<tr <?=$_data['Sty']['GuzicUryoDate3']?>>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>"><?=$_data['PER_ARRAY_NAME']['11']?></span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				관리자모드에서 임의 추가가능
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['GuzicUryoDate3']?>

		</td>
	</tr>
	<tr <?=$_data['Sty']['GuzicUryoDate4']?>>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>"><?=$_data['PER_ARRAY_NAME']['12']?></span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				관리자모드에서 임의 추가가능
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['GuzicUryoDate4']?>

		</td>
	</tr>
	<tr <?=$_data['Sty']['GuzicUryoDate5']?>>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['기타페이지2']?>"><?=$_data['PER_ARRAY_NAME']['13']?></span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				관리자모드에서 임의 추가가능
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4">
			<?=$_data['PAY']['GuzicUryoDate5']?>

		</td>
	</tr>
</table>

<h3 class="guin_d_tlt_st02" style="position:relative;">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>이력서 스킨
	 <p style="position:absolute; text-align:right; right:0; top:45px; font-size:14px; font-weight:400;">이력서스킨을 적용하여 자신의 이력서를 어필할 수 있습니다.</p>
</h3>

<div style="position:relative">
	<!--안내말풍선-->
	<div style="position:relative; left:0; top:0; z-index:0;" id="all">
		<div style="position:absolute; left:75px; top:-295px; z-index:0; display:none;" id="helpimg1">
			<img src="img/memo_anne_img2.png" border="0" align="absmiddle" onClick="document.all.helpimg1.style.display='none';" alt="이미지를 클릭하여 닫기" style="cursor:pointer; width:271px; height:293px;" class="png24">
		</div>
	</div>
	<!--안내말풍선 끝-->
	<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse: collapse;">
		<tr>
			<th class="font_16 noto400" style="text-align:left; height:42px; width:280px; padding-left:30px; color:#666666; border-left:1px solid #ccc !important; border-top:1px solid #ccc !important; border:1px solid #ccc; border-bottom:0 none !important; background:#f8f8f9; letter-spacing:-1px; " class="" align="">
				이력서스킨사용 <img src="img/btn_icon_question.gif" border="0" align="absmiddle" onClick="startPopup('helpimg1');" style="cursor:pointer; margin-left:10px">
			</th>
			<th align="center" class="font_16 noto400" style="color:#666666; border-right:1px solid #ccc !important; border-top:1px solid #ccc !important; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px; text-align:center;">이력서선택</th>
		</tr>
		<tr>
			<td style="border:1px solid #ccc; border-left:1px solid #ccc; border-bottom:1px solid #ccc; border-top:0 none; vertical-align:top">
				<?=$_data['PAY']['guin_docskin']?>

			</td>
			<td style="border:1px solid #ccc; border-right:1px solid #ccc; border-bottom:1px solid #ccc; padding:20px 0">
				<table cellpadding="0" cellspacing="0" style="margin:0 auto">
					<tr>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label class="h-radio"><input type="radio" name="doc_skin" value="doc_skin1.html" style="margin-bottom:2px"><span class="noto400 font_14">1번스킨</span></label>
							</span>
							<span style="display:block; padding-top:5px;">
								<img src="img/skinview1.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label class="h-radio"><input type="radio" name="doc_skin" value="doc_skin2.html" style="margin-bottom:2px"><span class="noto400 font_14">2번스킨</span></label>
							</span>
							<span style="display:block; padding-top:5px;">
								<img src="img/skinview2.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label class="h-radio"><input type="radio" name="doc_skin" value="doc_skin3.html" style="margin-bottom:2px"><span class="noto400 font_14">3번스킨</span></label>
							</span>
							<span style="display:block; padding-top:5px;">
								<img src="img/skinview3.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label class="h-radio"><input type="radio" name="doc_skin" value="doc_skin4.html" style="margin-bottom:2px"><span class="noto400 font_14">4번스킨</span></label>
							</span>
							<span style="display:block; padding-top:5px;">
								<img src="img/skinview4.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<h3 class="guin_d_tlt_st02" style="position:relative;">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>아이콘추가
	 <p style="position:absolute; text-align:right; right:0; top:45px; font-size:14px; font-weight:400;">리스트출력에서 아이콘을 선택하여 추가할 수 있습니다.</p>
</h3>

<div style="position:relative">
	<!--안내말풍선-->
	<div style="position:relative; left:0; top:0; z-index:0;" id="all">
		<div style="position:absolute; left:70px; top:-183px; z-index:0; display:none;" id="helpimg2">
			<img src="img/memo_anne_img22.png" border="0" align="absmiddle" onClick="document.all.helpimg2.style.display='none';" alt="이미지를 클릭하여 닫기" style="cursor:pointer; width:450px; height:336px;" class="png24">
		</div>
	</div>
	<!--안내말풍선 끝-->
	<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse: collapse;">
		<tr>
			<th class="font_16 noto400" style="text-align:left; height:42px; width:280px; padding-left:30px; color:#666666; border-left:1px solid #ccc !important; border-top:1px solid #ccc !important; border:1px solid #ccc; border-bottom:0 none !important; background:#f8f8f9; letter-spacing:-1px;" class="" align="">
				아이콘출력 결제 <img src="img/btn_icon_question.gif" border="0" align="absmiddle" onClick="startPopup('helpimg2');" style="cursor:pointer; margin-left:10px">
			</th>
			<th align="center" class="font_16 noto400" style="color:#666666; border-right:1px solid #ccc !important; border-top:1px solid #ccc !important; border:1px solid #ccc; background:#f8f8f9; letter-spacing:-1px; text-align:center;">아이콘선택</th>
		</tr>
		<tr>
			<td style="border:1px solid #ccc; border-left:1px solid #ccc; border-bottom:1px solid #ccc; border-top:0 none; vertical-align:top">
				<?=$_data['PAY']['guin_freeicon']?>

			</td>
			<td style="border:1px solid #ccc; border-right:1px solid #ccc; border-bottom:1px solid #ccc; padding:20px 0">
				<table cellpadding="0" cellspacing="0" style="margin:0 auto">
					<tr>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_1" class="h-radio"><input type="radio" name="freeicon" id="ico_1" value="freeicon1.gif" style="margin-bottom:2px;"><span class="noto400 font_14">1번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon1.gif" border="0" align="absmiddle">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_2" class="h-radio"><input type="radio" name="freeicon"  id="ico_2" value="freeicon2.gif" style="margin-bottom:2px;"><span class="noto400 font_14">2번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon2.gif" border="0" align="absmiddle">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_3" class="h-radio"><input type="radio" name="freeicon" id="ico_3" value="freeicon3.gif" style="margin-bottom:2px;"><span class="noto400 font_14">3번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon3.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_4" class="h-radio"><input type="radio" name="freeicon" id="ico_4" value="freeicon4.gif" style="margin-bottom:2px;"><span class="noto400 font_14">4번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon4.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_5" class="h-radio"><input type="radio" name="freeicon" id="ico_5" value="freeicon5.gif" style="margin-bottom:2px;"><span class="noto400 font_14">5번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon5.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
					</tr>
					<tr>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_6" class="h-radio"><input type="radio" name="freeicon" id="ico_6" value="freeicon6.gif" style="margin-bottom:2px;"><span class="noto400 font_14">6번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon6.gif" border="0" align="absmiddle">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_7" class="h-radio"><input type="radio" name="freeicon" id="ico_7" value="freeicon7.gif" style="margin-bottom:2px;"><span class="noto400 font_14">7번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon7.gif" border="0" align="absmiddle">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_8" class="h-radio"><input type="radio" name="freeicon" id="ico_8" value="freeicon8.gif" style="margin-bottom:2px;"><span class="noto400 font_14">8번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon8.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_9" class="h-radio"><input type="radio" name="freeicon" id="ico_9" value="freeicon9.gif" style="margin-bottom:2px;"><span class="noto400 font_14">9번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon9.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
						<td style="text-align:center; padding:10px; line-height:18px">
							<span class="h_form" style="display:block">
								<label for="ico_10" class="h-radio"><input type="radio" name="freeicon" id="ico_10" value="freeicon10.gif" style="margin-bottom:2px;"><span class="noto400 font_14">10번 아이콘</span></label>
							</span>
							<span style="display:block">
								<img src="img/freeicon10.gif" border="0" align="absmiddle" style=";">
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
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