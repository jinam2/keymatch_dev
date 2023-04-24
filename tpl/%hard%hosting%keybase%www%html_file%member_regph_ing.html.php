<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 10:36:53 */
function SkyTpl_Func_4222541096 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('<a href=happy_member.php?mode=mypage>마이페이지</a> > 공개이력서') ?>

<script>
	function guzicdel(url)
	{
		if ( confirm('정말 삭제 하시겠습니까?') )
		{
			window.location.href = url;
		}
	}
</script>
<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	이력서관리
	<span style="position:absolute; top:5px; right:0">
		<a href="document.php?mode=add">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['서브색상']?>; padding:3px 15px; border-radius:15px;">이력서 등록</span>
		</a>
	</span>
</div>
<?include_template('my_point_jangboo_per.html') ?>


<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>공개 이력서
</h3>

<div>
	<div style="border-top:1px solid #ccc">
		<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

		<?document_extraction_list('가로1개','세로5개','옵션1','옵션2','옵션3','내가등록한공개중인이력서','진행중','50글자짜름','누락0개','mypage_doc_rows.html','페이징사용') ?>

	</div>
	<!-- 페이지출력 -->
	<div class="paging_mypage" style="text-align:center;"><?=$_data['페이징']?></div>
	<!-- 페이지출력 -->
</div>
<? }
?>