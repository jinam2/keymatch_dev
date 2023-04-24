<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 16:54:00 */
function SkyTpl_Func_197663101 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	.tb_in_tb_border_ect{vertical-align:top; border:1px solid #c5c5c5;}
	.tb_in_tb_border_ect > table tr:last-child td{border-bottom:none !important;}
</style>
<!-- 폼정보 -->
<!--<form name='payform' method='post' style="margin:0;">-->
<span style="position:absolute; top:-10000px; left:-10000px"><?=$_data['pay_java']?></span>
<!-- 폼정보 -->

<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse;; table-layout:fixed; border:1px solid #c5c5c5;;">
	<tr>
		<th class="font_16 noto400" style="height:42px; color:#666666; border:1px solid #c5c5c5; background:#f8f8f9; letter-spacing:-1px;" align="center">미리보기</th>
		<th class="font_16 noto400" style="width:230px; border:1px solid #c5c5c5;; background:#f8f8f9; letter-spacing:-1px;">서비스명</th>
		<th class="font_16 noto400" style="width:94px; border:1px solid #c5c5c5;; background:#f8f8f9; letter-spacing:-1px;">유형</th>
		<th class="font_16 noto400" style="width:95px; border:1px solid #c5c5c5;; background:#f8f8f9; letter-spacing:-1px; ">기간/횟수</th>
		<th class="font_16 noto400" style="width:95px; border:1px solid #c5c5c5;; background:#f8f8f9; letter-spacing:-1px; ">금액</th>
		<th class="font_16 noto400" style="width:60px;color:#666666; border:1px solid #c5c5c5;; background:#f8f8f9; letter-spacing:-1px; ">신청</th>
	</tr>
	<tr>
		<td style="border:1px solid #ccc; border-left:1px solid #ccc !important; border-bottom:0 none; text-align:center; vertical-align:top;;" rowspan="3">
			<img src="img/member_option_pay.gif">
		</td>
		<td  style="text-align:left; padding-left:30px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['서브색상']?>">우대등록</span> 초빙정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 noto400">
				메인 - 메인 화면의 상단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 noto400">
				서브 - 서브 화면의 상단에 배치
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4" class="tb_in_tb_border_ect">
			<?=$_data['PAY']['guin_banner1']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['서브색상']?>">프리미엄</span> 초빙정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 noto400">
				메인 - 우대등록 하단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 noto400">
				서브 - 우대등록 하단에 배치
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4" class="tb_in_tb_border_ect">
			<?=$_data['PAY']['guin_banner2']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px; border:1px solid #ccc; border-bottom:0 none !important">
			<span class="noto400 font_15" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['서브색상']?>">스페셜</span> 초빙정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 noto400">
				메인 - 프리미엄초빙정보 하단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 noto400">
				서브 - 프리미엄초빙정보 하단에 배치
			</span>
		</td>
		<td style="text-align:center; border-right:1px solid #ccc" colspan="4" class="tb_in_tb_border_ect">
			<?=$_data['PAY']['guin_list_hyung']?>

		</td>
	</tr>

</table>



<?=$_data['select_guin_list']?>


<!-- 패키지 신청금액 -->
<input type="text" value='0' name="total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#ca2222; display:none" class="sminput" align="absmiddle" readonly>
<!-- 패키지 신청금액 -->

<table cellspacing="0" style="width:100%; margin-top:30px">
	<tr>
		<td style="text-align:right; letter-spacing:-1px; height:65px; background:#666666; padding-right:30px; color:#fff" class="font_18 noto400">
			<span style="vertical-align:middle">총 신청 금액</span> <input type="text" value='0' name="out_total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#fff; font-size:30px; vertical-align:middle; margin-bottom:3px" class="font_tahoma" align="absmiddle" readonly> <span style="vertical-align:middle">원</span>
		</td>
	</tr>
</table>



<? }
?>