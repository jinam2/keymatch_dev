<? /* Created by SkyTemplate v1.1.0 on 2023/03/09 15:18:08 */
function SkyTpl_Func_1913420466 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript">
<!--
	function want_del(want_number) {
		str = "입사제의 한 이력서를 삭제하시겠습니까?";
		if ( confirm( str ) )
		{
			document.location = "per_guin_want.php?mode=del&cNumber=" + want_number;
		}
	}

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
	//-->

</script>
<style>
	.payin a{color:#<?=$_data['배경색']['서브색상']?> !important}	
	.in_check_no_m{display:inline-block; padding:0 8px; border:1px solid #ccc; box-sizing:border-box; border-radius:5px; font-size:14px; color:#999; letter-spacing:-1px;}
	.in_check_yes_m{display:inline-block; padding:0 8px; border:1px solid #<?=$_data['배경색']['기본색상']?>; box-sizing:border-box; border-radius:5px; font-size:14px; color:#<?=$_data['배경색']['기본색상']?>; letter-spacing:-1px;}
</style>

<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	유료서비스
</div>

<?include_template('member_count_per.html') ?>


<div style="border:2px solid #666666; margin-top:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td class="font_16 noto500" style="padding-left:20px; background:#f8f8f8; color:#333; letter-spacing:-1px; height:46px; border-bottom:1px solid #dfdfdf;">
				유료옵션별 이력서
			</td>
			<td  class="font_14 noto400" style="padding-right:20px; background:#f8f8f8;  letter-spacing:-1.2px; height:46px; border-bottom:1px solid #dfdfdf; text-align:right;">
				내가 등록한 이력서 중 옵션이 적용된 이력서의 개수입니다
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

<table cellspacing="0" style="width:100%; background:#fafafa; border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf">
	<tr>
		<td class="font_16 noto400" style="width:70px; color:#999999; letter-spacing:-1px; height:40px" align="center">번호</td>
		<td class="font_16 noto400 " style="color:#999999; letter-spacing:-1px; height:40px" align="center">결제내역</td>
		<td class="font_16 noto400" style="width:180px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #dfdfdf;" align="center">결제금액</td>
		<td class="font_16 noto400" style="width:120px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #dfdfdf;" align="center">보기</td>
		<td class="font_16 noto400" style="width:120px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #dfdfdf;" align="center">결제방식</td>
		<td class="font_16 noto400" style="width:180px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #dfdfdf;" align="center">결제일</td>
		<td class="font_16 noto400" style="width:100px; color:#999999; letter-spacing:-1px; height:40px; border-left:1px solid #dfdfdf;" align="center">확인</td>
	</tr>
</table>
<div><?echo jangboo_list_per('총20개','가로1개','mypage_jangboo_per2_rows.html','사용함') ?></div>
<table cellspacing="0" cellpadding="0" style="width:100%; margin:20px 0 50px 0;">
	<tr>
		<td align="center"><?=$_data['결제내역페이징']?></td>
	</tr>
</table>
<? }
?>