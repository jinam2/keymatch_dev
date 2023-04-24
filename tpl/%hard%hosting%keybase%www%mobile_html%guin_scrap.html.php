<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 15:16:25 */
function SkyTpl_Func_3984550977 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script type="text/javascript">
<!--
	function confirm_del(cNumber){
		if (confirm("스크랩한 채용정보를 삭제하시겠습니까?"))
		{
			document.location = "scrap.php?mode=per_del&cNumber=" + cNumber;
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
		<strong style="margin-bottom:20px; display:block;">채용정보 스크랩 <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['채용정보스크랩수']?> 건</span></strong>				
	</h3>
	<div style="border-top:1px solid #ddd;">
		<?newPaging_option('번호양쪽1개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

		<?guin_extraction('총10개','가로1개','제목길이200자','자동','자동','자동','자동','일반','스크랩','mypage_guin_list_scrap_rows2.html','','사용함') ?>

		<div style="padding-bottom:10px"><?=$_data['구인리스트페이징']?></div>
	</div>
</div>
<? }
?>