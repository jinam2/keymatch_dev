<? /* Created by SkyTemplate v1.1.0 on 2023/03/21 09:54:50 */
function SkyTpl_Func_1031849823 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
	function view_t(t_id)
	{
		if ( document.getElementById(t_id).style.display == "" )
		{
			document.getElementById(t_id).style.display = "none";
		}
		else
		{
			document.getElementById(t_id).style.display = "";
		}
	}
</script>
<style>
	.payin a{color:#<?=$_data['배경색']['서브색상']?> !important}
</style>

<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	유료서비스
</div>

<?include_template('member_count_com.html') ?>


<div style="border:2px solid #666666; margin-top:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td class="font_16 noto500" style="padding-left:20px; background:#f8f8f8; color:#333; letter-spacing:-1px; height:46px; border-bottom:1px solid #c5c5c5;">
				유료옵션별 채용공고
			</td>
			<td  class="font_12 font_gulim" style="padding-right:20px; background:#f8f8f8;  letter-spacing:-1.2px; height:46px; border-bottom:1px solid #c5c5c5; text-align:right;">
				내가 등록한 채용공고 중 옵션이 적용된 채용공고의 개수입니다
			</td>
		</tr>
		<tr>
			<td style="padding:20px" colspan="2">
				<table cellspacing="0" cellpadding="0" style="width:100%" class="my_tablecell">
					<?=$_data['서비스이용항목']?>

				</table>
			</td>
		</tr>
	</table>
</div>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>유료 결제내역
</h3>

<table cellspacing="0" style="width:100%; background:#fafafa; border-top:1px solid #c5c5c5; border-bottom:1px solid #c5c5c5">
	<tr>
		<td class="font_16 noto400" style="width:70px; color:#999999; letter-spacing:-1px; height:40px" align="center">번호</td>
		<td class="font_16 noto400 " style="color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #c5c5c5;" align="center">결제내역</td>
		<td class="font_16 noto400" style="width:180px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #c5c5c5;" align="center">결제금액</td>
		<td class="font_16 noto400" style="width:120px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #c5c5c5;" align="center">보기</td>
		<td class="font_16 noto400" style="width:120px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #c5c5c5;" align="center">결제방식</td>
		<td class="font_16 noto400" style="width:180px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #c5c5c5;" align="center">결제일</td>
		<td class="font_16 noto400" style="width:100px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #c5c5c5;" align="center">확인</td>
	</tr>
</table>
<div><?echo jangboo_list_com('총20개','가로1개','mypage_jangboo_com_rows.html','사용함') ?></div>
<table cellspacing="0" cellpadding="0" style="width:100%;">
	<tr>
		<td align="center"><?=$_data['결제내역페이징']?></td>
	</tr>
</table>
<? }
?>