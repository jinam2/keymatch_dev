<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 15:04:22 */
function SkyTpl_Func_2129012821 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('<a href=member_info.php>마이페이지</a> > 취업활동 증명서') ?>


<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	입사지원관리
	<span style="position:absolute; top:5px; right:0">
		<a href="html_file_per.php?file=my_guin_activities.html" title="취업활동 증명서">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">취업활동 증명서</span>
		</a>
		<a href="html_file_per.php?mode=per_guin_view" title="채용공고 열람관리">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">채용공고 열람관리</span>
		</a>
		<a href="per_no_view_list.php" title="이력서 열람불가 설정">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">이력서 열람불가 설정</span>
		</a>
		<a href="per_want_search.php?mode=setting_form" title="맞춤 채용공고 설정">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">맞춤 채용공고 설정</span>
		</a>
		<a href="per_want_search.php?mode=list" title="맞춤 채용공고">
			<span  style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">맞춤채용공고</span>
		</a>
	</span>
</div>

<?include_template('my_point_jangboo_per2.html') ?>


<p class="font_14 noto400" style="color:#797979; border:1px solid #dfdfdf; background:#f7f7f7; margin:20px 0 0 0; padding:15px; line-height:18px; letter-spacing:-1px">
	구직활동을 진행하고 있는 이력서 목차로 출력하실 <span class="noto400" style='color:#333'>이력서를 체크</span> 선탁한 후 아래 <span class="noto400" style='color:#333'>"선택리스트 출력"</span> 버튼을 클릭하여 <span class="noto400" style='color:#333'>[취업할동 증명서]를 인쇄</span>하실 수 있습니다.
</p>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>취업활동 증명서
</h3>

<form name="guin" method="post" action="html_file_per.php?file=my_guin_activities_pop.html&file2=default_guin_print.html">
<input type="hidden" name="print_activities_ch" value="ok">
<div style="border-bottom:1px solid #ddd;">
	<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

	<?document_extraction_list('가로1개','세로30개','옵션1','옵션2','내가신청한구인','옵션4','입사지원순','글자40글자짜름','누락0개','mypage_output_regadd_guin_activities.html','페이징사용') ?>

</div>
<div style="margin:30px 0 30px 0; text-align:center;">
	<img src="img/skin_icon/make_icon/skin_icon_720.jpg" alt="선택리스트출력" OnClick="check_print()" style="cursor:pointer;">
</div>
</form>
<!-- 페이지출력 -->
<div class="paging_mypage" style="text-align:center;"><?=$_data['페이징']?></div>
<!-- 페이지출력 -->

<script>
function checkedall(print_all)
{
	var print_ch = document.getElementsByName("print_ch[]");
	for ( var i=0; i<print_ch.length; i++ )
	{
		print_ch[i].checked = print_all.checked;
	}
}
function check_print(){
	window.open("about:blank", "activities_pop", "left=0,top=0,width=800,height=800,scrollbars=yes,status=no,toolbars=no");

	document.guin.target="activities_pop";
	document.guin.submit();

/*
	var print_ch = document.getElementsByName("print_ch[]");
	var where = "";
	for ( var i=0; i<print_ch.length; i++ )
	{
		where = where + " and number="+print_ch[i].value;
	}
	//alert(where);
	*/
}
</script>
<? }
?>