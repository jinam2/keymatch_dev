<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 16:25:13 */
function SkyTpl_Func_1223147844 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<h2 style="padding:20px 0; background:url('./mobile_img/m_tit_bg.gif') 0 0 repeat; text-align:center; letter-spacing:-1.5px; font-weight:bold; border-bottom:2px solid #dbdbdb; line-height:130%" class="font_24 font_malgun" onclick="location.href='happy_member.php?mode=mypage'">
	<span style="color:#<?=$_data['배경색']['모바일_서브색상']?>"><?=$_data['MEM']['user_name']?>님의</span> 마이페이지
</h2>
<div style="padding:10px">
	<h3 class="font_malgun font_22" style="position:relative; padding:10px 0; letter-spacing:-1.5px; color:#333; border-bottom:4px solid #000; margin-top:10px">
		<span style="color:#<?=$_data['배경색']['모바일_서브색상']?>">지원자</span> 관리
	</h3>

	<?document_extraction_list('가로1개','세로5개','옵션1','옵션2','총지원자','옵션4','최근등록일순','글자100글자짜름','누락0개','mypage_doc_rows_guin2.html','페이징사용') ?>


	<table style="width:100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td align="center" style="padding:20px 0"><?=$_data['페이징']?></td>
	</tr>
	</table>
</div>

<? }
?>