<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 11:30:41 */
function SkyTpl_Func_1625527521 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 입사제의 삭제 JS -->
<script language="JavaScript">
<!--
	function want_del(want_number) {
		str = "입사제의 한 이력서를 삭제하시겠습니까?";
		if ( confirm( str ) )
		{
			document.location = "per_guin_want.php?mode=del&cNumber=" + want_number;
		}
	}
//-->
</script>
<h3 class="sub_tlt_st01" style="padding-bottom:30px; border-bottom:1px solid #ddd; box-sizing:border-box;" onclick="location.href='happy_member.php?mode=mypage'">
	<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['MEM']['user_name']?>님의 </b>
	<span>마이페이지</span>
</h3>
<div style="padding-top:20px;">
	<h3 class="m_tlt_m_01">
		<strong style="margin-bottom:20px; display:block;">스크랩한
초빙정보 <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['채용정보스크랩수']?> 건</span></strong>				
	</h3>
	<div style="border-top:1px solid #ddd;">
		<?newPaging_option('번호양쪽1개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

		<?guin_extraction('총10개','가로1개','제목길이200자','자동','자동','자동','자동','일반','입사요청','mypage_guin_want_list_row_per.html','','페이징사용') ?>

	</div>
</div>
<? }
?>