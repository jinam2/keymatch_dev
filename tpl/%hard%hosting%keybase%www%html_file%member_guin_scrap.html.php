<? /* Created by SkyTemplate v1.1.0 on 2023/04/17 18:45:09 */
function SkyTpl_Func_3656970808 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<link rel="stylesheet" type="text/css" href="js/jRating/jRating.jquery.css" media="screen" />
<script type="text/javascript" src="js/jRating/jquery.js"></script>
<script type="text/javascript" src="js/jRating/jRating.jquery.js"></script>
<!-- 폼전송 iframe -->
<iframe width=0 height=0 name="j_blank" id="j_blank" frameborder="0" style="display:none"></iframe>

<script language="javascript">
<!--
function confirm_del(pNumber,cNumber,number){
	if (confirm("스크랩한 이력서를 삭제하시겠습니까?"))
	{
		document.location = "scrap.php?mode=com_del&pNumber=" + pNumber + "&cNumber=" + cNumber + "&number=" + number ;
	}
}
-->
</script>

<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	인재정보관리
	<span style="position:absolute; top:0; right:0">
		<a href="html_file.php?file=today_view_resume.html&file2=happy_member_default_mypage_com.html" title="오늘 본 인재정보">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">오늘 본 인재정보</span>
		</a>
		<a href="html_file.php?file=com_payendper.html&file2=happy_member_default_mypage_com.html" title="이력서 열람관리">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">이력서 열람관리</span>
		</a>
		<a href="member_guin.php?type=scrap" title="초빙공고별 스크랩">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">초빙공고별 스크랩</span>			
		</a>
		<a href="com_want_search.php?mode=setting_form" title="맞춤인재설정">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#666; padding:3px 15px; border-radius:15px;">맞춤인재설정</span>
		</a>
		<a href="com_want_search.php?mode=list" title="맞춤인재정보">			
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['서브색상']?>; padding:3px 15px; border-radius:15px;">맞춤인재정보</span>
		</a>
	</span>
</div>

<?include_template('my_point_jangboo_com.html') ?>


<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>스크랩한 인재정보
</h3>

<div style="border-top:1px solid #ddd;">
	<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

	<?document_extraction_list('가로1개','세로5개','옵션1','옵션2','인재스크랩','옵션4','최근등록일순','글자짜름','누락0개','mypage_doc_rows_scrap.html','페이징사용') ?>

</div>
<div class="paging_mypage" align="center"><?=$_data['페이징']?></div>
<? }
?>