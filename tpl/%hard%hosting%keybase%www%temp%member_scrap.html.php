<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 15:12:14 */
function SkyTpl_Func_1923991479 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="javascript">
<!--
	function bbsdel2(strURL) {
		var msg = "삭제하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
	-->
</script>
<script language="javascript">
<!--
	function magam(strURL) {
		var msg = "해당 구인정보를 마감하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

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
		<a href="member_guin.php?type=scrap" title="채용공고별 스크랩">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">채용공고별 스크랩</span>			
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
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>채용공고별 인재스크랩
	 <p style="position:absolute; text-align:right; right:0; top:45px; font-size:14px; font-weight:400;">이력서를 스크랩할때 등록된 <span style="color:#<?=$_data['배경색']['기타페이지2']?>;">채용정보를 선택</span>해서 스크랩한 인재정보입니다.</p>
</h3>

<div style="border-top:1px solid #ddd;"><?echo guin_extraction_myreg('총5개','가로1개','제목길이400자','진행중','mypage_member_guin_list_scrap.html','사용함') ?></div>
<table cellspacing="0" cellpadding="0" style="width:100%; margin-top:50px;">
	<tr>
		<td align="center"><?=$_data['구인리스트페이징']?></td>
	</tr>
</table>





<? }
?>