<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 09:41:42 */
function SkyTpl_Func_2899640531 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript">
function want_del(want_number,jiwon_type) {
	str = "입사제의 한 내역을 삭제하시겠습니까?";
	if ( confirm( str ) )
	{
		document.location = "com_guin_want.php?mode=del&cNumber=" + want_number+'&jiwon_type='+jiwon_type;
	}
}
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
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>입사제의 인재정보
</h3>

<div>
	<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

	<?guin_extraction('총20개','가로1개','제목길이400자','자동','자동','자동','자동','일반','입사제의','mypage_guin_want_list_row.html','','','','최근등록일순') ?>

</div>

<? }
?>