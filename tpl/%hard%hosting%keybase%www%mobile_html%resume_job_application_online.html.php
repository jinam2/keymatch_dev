<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 10:44:16 */
function SkyTpl_Func_2957847947 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<h2 style="padding:20px 0; background:url('./mobile_img/m_tit_bg.gif') 0 0 repeat; text-align:center; letter-spacing:-1.5px; font-weight:bold; border-bottom:2px solid #dbdbdb; line-height:130%" class="font_24 font_malgun" onclick="location.href='happy_member.php?mode=mypage'">
	<span style="color:#<?=$_data['배경색']['모바일_서브색상']?>"><?=$_data['MEM']['user_name']?>님의</span> 마이페이지
</h2>
<div style="padding:10px">
	<h3 class="font_malgun font_22" style="position:relative; padding:10px 0; letter-spacing:-1.5px; color:#333; border-bottom:4px solid #000; margin-top:10px">
		<span style="color:#<?=$_data['배경색']['모바일_서브색상']?>">온라인</span> 입사지원
	</h3>
	<?newPaging_option('번호양쪽1개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

	<?document_extraction_list('가로1개','세로10개','옵션1','옵션2','내가신청한구인(온라인)','옵션4','최근등록일순','글자100글자짜름','누락0개','mypage_output_regadd_guin.html','페이징사용') ?>

	<table style="width:100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td align="center" style="padding:40px 0 40px 0;"><?=$_data['페이징']?></td>
	</tr>
	</table>
</div>
<? }
?>