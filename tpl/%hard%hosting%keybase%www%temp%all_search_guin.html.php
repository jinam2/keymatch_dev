<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_2599031252 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="letter-spacing:-1px; padding-bottom:10px;">
	<span class="font_20 noto500" style="color:#333"><?=$_data['타이틀명']?> 검색결과</span>
</div>
<div class="sub_guin_list">
	<ul class="sub_guin_th">
		<li>모집내용</li>
		<li>근무조건</li>
		<li>지원자격</li>
		<li>마감일</li>
	</ul>
	<div class="sub_guin_td all_search_guin_normal_row" style="border-bottom:1px solid #c5c5c5;">
		<style type="text/css">
			.all_search_guin_normal_row > table{margin-bottom:0;}
		</style>
		<?=$_data['검색결과리스트']?>

	</div>			
</div>
<div style="text-align:right; padding:10px 0">
	<a href="<?=$_data['더많은결과링크주소']?>" style="color:#0000cc; font-size:15px;">
	<?=$_data['타이틀명']?> 더보기 <img src="img/search_plus_03.png" align="absmiddle" alt="더많은검색결과" style="vertical-align:middle">
	</a>
</div>



<? }
?>