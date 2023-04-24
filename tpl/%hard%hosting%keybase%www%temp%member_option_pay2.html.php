<? /* Created by SkyTemplate v1.1.0 on 2023/03/17 09:47:25 */
function SkyTpl_Func_1780738449 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	유료서비스
</div>
<p class="font_14 font_dotum no_display2" style="color:#797979; border:1px solid #c5c5c5; background:#f7f7f7; margin:0 0 20px 0; padding:15px; line-height:18px; letter-spacing:-1px">
정보등록시 사용하실 수 있는 유료옵션에 대한 안내페이지로, 위치 및 강조효과등을 활용해 보다 효과적으로 채용정보를 알릴 수 있습니다.<br/>
아래 항목중 필요옵션을 체크하시면 해당 가격을 아래에서 합산하여 확인해 보실 수 있으며 결제는 <strong style="color:#333">로그인</strong>한 회원에 한해서만 가능합니다.
</p>
<div class="no_display">
<?include_template('member_count_com.html') ?>

</div>
<div style="margin:20px 0 0 0; <?=$_data['company_info_display']?>" class="">
	<table cellspacing="0" cellpadding="0" style="width:100%; border-top:2px solid #cacaca; border-left:0 none; border-right:0 none" class="my_tablecell">
		<tr>
			<th class="sub" rowspan="5" style="width:200px; background:#f4f4f4; border-right:1px solid #c5c5c5;">
				<span style="display:inline-block; padding:3px; border:1px solid #dbdbdb; background:#fff"><?=$_data['COM']['logo_temp']?></span>
				<span style="color:#333; display:block; padding:8px 0; letter-spacing:-1px" class="font_18 noto500">
					<?=$_data['COM']['com_name']?>

				</span>
			</th>
			<th class="title" >업종</th>
			<td class="sub input_style sell_140 noto400 font_14">
				<?=$_data['COM']['com_job']?>

			</td>
		</tr>
		<tr>
			<th class="title" >대표자</th>
			<td class="sub input_style sell_140 noto400 font_14">
				<?=$_data['COM']['boss_name']?>

			</td>
		</tr>
		<tr>
			<th class="title" >직원수</th>
			<td class="sub input_style sell_140 noto400 font_14">
				<?=$_data['COM']['com_worker_cnt']?> 명
			</td>
		</tr>
		<tr>
			<th class="title" >설립연도</th>
			<td class="sub input_style sell_140 noto400 font_14">
				<?=$_data['COM']['com_open_year']?> 년도
			</td>
		</tr>
		<tr>
			<th class="title" >주소</th>
			<td class="sub input_style sell_140 noto400 font_14">
				<?=$_data['COM']['com_addr1']?> <?=$_data['COM']['com_addr2']?>

			</td>
		</tr>
	</table>
</div>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>열람/SMS 서비스
</h3>


<div>
	<!-- 폼정보 -->
	<form name='payform' method='post' style="margin:0;">
	<input type="hidden" name="number" value="<?=$_data['number']?>">
	<input type="hidden" name="member_type" value="1">
	<?=$_data['pay_java']?>

	<table cellspacing="0" style="width:100%; " class=" ">
		<tr>
			<td style="text-align:right; letter-spacing:-1.2px; height:65px; background:#f8f8f9; padding-right:30px; color:#333333; border:1px solid #c5c5c5" class="font_18 noto400">
				<span style="vertical-align:middle; ">총 신청 금액</span>
				<input type="text" value='0' name="total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#<?=$_data['배경색']['서브색상']?>; font-size:30px; vertical-align:middle; margin-bottom:3px" class="font_tahoma" align="absmiddle" readonly> <span class="noto400" style="vertical-align:middle">원</span>
			</td>
		</tr>
	</table>
	<a name="resume" style=""></a>
	<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;; table-layout:fixed; background:url('./img/bg_dot.gif') 0 bottom repeat-x; margin-top:20px">
	<tr>
		<th class="font_16 noto400" style="width:330px; height:42px; border:1px solid #c5c5c5; border-top:1px solid #c5c5c5 !important; background:#f8f8f9; letter-spacing:-1px; font-weight:bold; ">서비스명</th>
		<th class="font_16 noto400"  style="border:1px solid #c5c5c5; border-top:1px solid #c5c5c5 !important; background:#f8f8f9; letter-spacing:-1px;">유형</th>
		<th class="font_16 noto400"  style="width:268px; border:1px solid #c5c5c5; border-top:1px solid #c5c5c5 !important; background:#f8f8f9; letter-spacing:-1px; ">기간/횟수</th>
		<th class="font_16 noto400"  style="width:268px; border:1px solid #c5c5c5; border-top:1px solid #c5c5c5 !important; background:#f8f8f9; letter-spacing:-1px; ">금액</th>
		<th class="font_16 noto400" style="width:60px;color:#666666; border-right:1px solid #c5c5c5 !important; border-top:1px solid #c5c5c5 !important; border:1px solid #c5c5c5; background:#f8f8f9; letter-spacing:-1px; ">신청</th>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #c5c5c5; border-bottom:0 none !important">

			<span class="noto400 font_16" style="display:block; color:#333">
				인재정보보기 <span style="color:#<?=$_data['배경색']['서브색상']?>">기간내 무제한</span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 noto400">
				인재정보의 재한정보를 볼수 있게해주는 결제입니다.<br/>
				기간을 정해 해당기간안에 모든 인재정보를 볼 수 있습니다.
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #c5c5c5" colspan="4">
			<?=$_data['PAY']['guin_docview']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #c5c5c5; border-bottom:0 none !important">
			<span class="noto400 font_15" style="display:block; color:#333">
				인재정보보기 <span style="color:#<?=$_data['배경색']['서브색상']?>">이력서수 제한</span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 noto400">
				인재정보의 재한정보를 볼수 있게해주는 결제 입니다.<br/>
				기간의 재약없이 횟수만큼 볼수 있습니다.<br/>
				한번본 인재정보에대해서는 재차감되지 않습니다.
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #c5c5c5" colspan="4">
			<?=$_data['PAY']['guin_docview2']?>

		</td>
	</tr>
	<tr>
		<td style="text-align:left; padding:0 15px; border:1px solid #c5c5c5; border-bottom:0 none !important">
			<a name="sms" style=""></a>
			<span class="noto400 font_15" style="display:block; color:#333">
				SMS <span style="color:#<?=$_data['배경색']['서브색상']?>">전송 포인트</span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 noto400">
				인재에게 발송할 SMS에 사용할 포인트 결제 입니다.<br/>
				인재에게 SMS를 발송할때 소모되는 SMS포인트를 구매 합니다.<br/>
				(1포인트에1회발송)
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #c5c5c5" colspan="4">
			<?=$_data['PAY']['guin_smspoint']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #c5c5c5;border-bottom:0 none !important">
			<span class="noto400 font_15" style="display:block; color:#333">
				채용정보  <span style="color:#<?=$_data['배경색']['서브색상']?>">점프하기</span>
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 noto400">
				채용정보를 점프시킬수 있는 결제입니다.<br/>
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #c5c5c5" colspan="4">
			<?=$_data['PAY']['guin_jump']?>

		</td>
	</tr>
	</table>

	<!--out_total 이라는 걸로 하나 더 만듬-->
	<table cellspacing="0" style="width:100%; margin-top:30px" class=" ">
		<tr>
			<td style="text-align:right; letter-spacing:-1.2px; height:65px; background:#f8f8f9; padding-right:30px; color:#333333; border:1px solid #c5c5c5" class="font_18 font_malgun">
				<span style="vertical-align:middle; ">총 신청 금액</span>
				<input type="text" value='0' name="out_total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#<?=$_data['배경색']['서브색상']?>; font-size:30px; vertical-align:middle; margin-bottom:3px" class="font_malgun" align="absmiddle" readonly> <span style="vertical-align:middle">원</span>
			</td>
		</tr>
	</table>

</div>
<div style="margin:20px 0 30px 0;" align="center" class="no_display"><?=$_data['PAY']['bank']?><?=$_data['PAY']['card']?><?=$_data['PAY']['phone']?><?=$_data['PAY']['bank_soodong']?><?=$_data['PAY']['point']?></div>
</form>
<? }
?>