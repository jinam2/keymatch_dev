<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 19:14:33 */
function SkyTpl_Func_1177187858 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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



//패키지(즉시적용) + 단일유료옵션
var swap_now_price				= Array();
function Func_pack2_now_price(chk_num)
{
	var pack2_uryo_val			= document.getElementById('pack2_uryo_'+chk_num).value;
	var pack2_uryo_val_split	= pack2_uryo_val.split(':');


	swap_now_price[chk_num]		= 0; //초기화

	if(document.getElementById('pack2_use_'+chk_num).checked == true)
	{
		swap_now_price[chk_num]	= parseInt(swap_now_price[chk_num]) + parseInt(pack2_uryo_val_split[4]);
	}


	var total				= 0;
	for(var idx in swap_now_price)
	{
		total				= parseInt(total) + parseInt(swap_now_price[idx]);
	}

	if ( document.getElementById('uryo_button_layer') && document.getElementById('free_button_layer') )
	{
		if ( total > 0 )
		{
			document.getElementById('uryo_button_layer').style.display = "";
			document.getElementById('free_button_layer').style.display = "none";
		}
		else
		{
			document.getElementById('uryo_button_layer').style.display = "none";
			document.getElementById('free_button_layer').style.display = "";
		}
	}

	document.getElementById('pack2_now_price').value	= total;
}
//패키지(즉시적용) + 단일유료옵션 END
</script>
<style type="text/css">
	.tb_in_tb_border_ect > table tr:last-child td{border-bottom:none !important;}
</style>

<!-- 폼정보 -->
<form name='payform' method='post' style="margin:0px;">
<span style="position:absolute; top:-10000px; left:-10000px"><?=$_data['pay_java']?></span>
<!-- 폼정보 -->
<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px; border-bottom:1px solid #c5c5c5;">
유료서비스 신청
	<span style="position:absolute; top:10px; right:0">
		<a href="my_jangboo_com.php" title="유료결제 내역보기">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">유료결제 내역보기</span>
		</a>
	</span>
</div>

<div style="margin-top:20px; border:1px solid #ddd; box-sizing:border-box;">
	<?echo happy_banner('등록페이지유료배너','배너제목','랜덤') ?>

</div>



<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>광고노출 서비스
</h3>

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
		<td style="border:1px solid #c5c5c5; text-align:center; vertical-align:top;" rowspan="15">
			<img src="img/member_option_pay.gif">
		</td>
		<td  style="text-align:left; padding:15px; border:1px solid #c5c5c5; ">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['서브색상']?>">우대등록</span> 채용정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				메인 - 메인 화면의 상단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 font_dotun">
				서브 - 서브 화면의 상단에 배치
			</span>
		</td>
		<td style="text-align:center; vertical-align:top; border:1px solid #c5c5c5; " colspan="4" class="tb_in_tb_border_ect">			
			<?=$_data['PAY']['guin_banner1']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px;; border:1px solid #c5c5c5; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['서브색상']?>">프리미엄</span> 채용정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				메인 - 우대등록 하단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 font_dotun">
				서브 - 우대등록 하단에 배치
			</span>
		</td>
		<td style="text-align:center; border:1px solid #c5c5c5;" colspan="4" class="tb_in_tb_border_ect">
			<?=$_data['PAY']['guin_banner2']?>

		</td>
	</tr>
	<tr>
		<td  style="text-align:left; padding:0 15px;; border:1px solid #c5c5c5; border-bottom:0 none !important">
			<span class="noto400 font_16" style="display:block; color:#333">
				<span style="color:#<?=$_data['배경색']['서브색상']?>">스페셜</span> 채용정보
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999; margin-top:10px" class="font_14 font_dotun">
				메인 - 프리미엄채용정보 하단에 배치
			</span>
			<span style="display:block; letter-spacing:-1px; color:#999" class="font_14 font_dotun">
				서브 - 프리미엄채용정보 하단에 배치
			</span>
		</td>
		<td style="text-align:center; border:1px solid #c5c5c5" colspan="4" class="tb_in_tb_border_ect">
			<?=$_data['PAY']['guin_list_hyung']?>

		</td>
	</tr>
	
</table>



<?=$_data['select_guin_list']?>


<input type="text" value='0' name="total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#ca2222; display:none" class="sminput" align="absmiddle" readonly>

<table cellspacing="0" style="width:100%; margin-top:30px">
	<tr>
		<td style="text-align:right; letter-spacing:-1px; height:65px; background:#666666; padding-right:30px; color:#fff" class="font_18 noto400">
			<span style="vertical-align:middle">총 신청 금액</span> <input type="text" value='0' name="out_total" size="10" style="text-align:right; font-weight:bold; padding-right:5px; background:none; border:0px solid red; color:#fff; font-size:30px; vertical-align:middle; margin-bottom:3px" class="font_tahoma" align="absmiddle" readonly> <span style="vertical-align:middle">원</span>
		</td>
	</tr>
</table>

<div align="center" style="margin:20px 0 30px 0;">
	<span id="uryo_button_layer"><?=$_data['PAY']['bank']?> <?=$_data['PAY']['card']?> <?=$_data['PAY']['phone']?> <?=$_data['PAY']['bank_soodong']?> <?=$_data['PAY']['point']?></span><span id="free_button_layer" style="display:none"><?=$_data['PAY']['free']?></span>
</div>

</form>
<? }
?>