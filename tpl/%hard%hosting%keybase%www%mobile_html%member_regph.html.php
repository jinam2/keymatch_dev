<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 11:12:01 */
function SkyTpl_Func_316968154 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 이력서삭제 JS -->
<script type="text/javascript">
<!--
	function guzicdel(url)
	{
		if ( confirm('정말 삭제 하시겠습니까?') )
		{
			window.location.href = url;
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
		<strong style="margin-bottom:20px; display:block;">전체 이력서 관리 <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['PERMEMBER']['guzic_total_cnt_comma']?> 건</span></strong>				
	</h3>
	<div>
		<?newPaging_option('번호양쪽1개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

		<?document_extraction_list('가로1개','세로5개','옵션1','옵션2','옵션3','내가등록한이력서','최근등록일순','80글자짜름','누락0개','mypage_doc_rows.html','페이징사용') ?>

	</div>
	<div style="text-align:center;"><?=$_data['페이징']?></div>
	
</div>
<? }
?>