<? /* Created by SkyTemplate v1.1.0 on 2023/04/17 18:46:29 */
function SkyTpl_Func_2601536881 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('<a href="happy_member.php?mode=mypage">마이페이지</a> > 오늘 본 인재정보') ?>


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


<h3 class="guin_d_tlt_st02" style="position:relative;">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>오늘 본 인재정보
</h3>
<div style="border-top:1px solid #ddd;">
	<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

	<?document_extraction_list('가로1개','세로15개','옵션1','옵션2','옵션3','오늘본구직정보','최근등록일순','글자80글자짜름','누락0개','mypage_rows_resume_today_view.html','페이징사용') ?>

</div>
<div align="center" class="paging_mypage"><?=$_data['페이징']?></div>
<? }
?>