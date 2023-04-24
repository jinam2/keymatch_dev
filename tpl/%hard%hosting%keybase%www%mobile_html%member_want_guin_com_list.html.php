<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 17:36:49 */
function SkyTpl_Func_1894739468 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript">
<!--
	function want_del(want_number) {
		str = "입사제의 한 이력서를 삭제하시겠습니까?";
		if ( confirm( str ) )
		{
			document.location = "com_guin_want.php?mode=del&cNumber=" + want_number +"&gmode=<?=$_data['_GET']['mode']?>";
		}
	}
//-->
</script>
<h3 class="sub_tlt_st01" onclick="location.href='happy_member.php?mode=mypage'" style="padding-bottom:30px; border-bottom:1px solid #ddd; box-sizing:border-box;">
	<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['MEM']['user_name']?>님의 </b>
	<span>마이페이지</span>
</h3>
<div style="padding-top:40px;">
	<h3 class="m_tlt_m_01">
		<strong style="margin-bottom:20px; display:block;">입사제의 인재관리</strong>				
	</h3>
	<div style="border-top:1px solid #ddd;">
		<?newPaging_option('번호양쪽1개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

		<?guin_extraction('총10개','가로1개','제목길이38자','자동','자동','자동','자동','일반','입사제의','mypage_guin_want_list_row.html','누락0개','사용함') ?>

	</div>
</div>

<? }
?>