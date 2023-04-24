<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 16:26:06 */
function SkyTpl_Func_1093956467 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('패키지옵션 보유현황') ?>

<div style="position:absolute; top:-10000px; left:-10000px"><?=$_data['msg']?><?=$_data['pay_java']?></div>
<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	유료서비스
</div>
<?include_template('member_count_com.html') ?>


<div style="border:2px solid #666666; margin-top:20px;">
	<p style="overflow:hidden; background:#f8f8f8; border-bottom:1px solid #ccc; padding:15px 20px">
		<strong class="font_18 noto500" style="display:block; float:left; width:60%; letter-spacing:-1px;">유료옵션별 채용공고</strong>
		<span class="font_14 noto400" style="display:block; float:right; width:40%; text-align:right; letter-spacing:-1px;">내가 등록한 채용공고 중 옵션이 적용된 채용공고의 개수입니다.</span>
	</p>
	<div style=" padding:20px;">
		<table cellspacing="0" cellpadding="0" style="width:100%" class="my_tablecell">
		<?=$_data['서비스이용항목']?>

		</table>
	</div>	
</div>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>패키지 보유현황
</h3>

<style>
.package_list_align{margin-top:20px}
.package_list_align table{table-layout:fixed}
.package_list_align table tr td:first-child div{margin-left:0 !important}
</style>
<div class="package_list_align">
	<?echo package_have_list('가로4개','rows_package.html') ?>

</div>


<? }
?>