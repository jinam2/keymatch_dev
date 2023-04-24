<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 17:42:55 */
function SkyTpl_Func_479431050 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="letter-spacing:-1px; padding-bottom:10px;">
	<span class="font_20 noto500" style="color:#333"><?=$_data['타이틀명']?> 검색결과</span>
</div>
<div class="sub_guzic_list" style="margin-bottom:0;">
	<ul class="sub_guzic_th">
		<li>이력서 정보</li>
		<li>이름</li>
		<li>희망근무지역</li>
		<li>등록일</li>
	</ul>
	<div class="sub_guzic_td all_search_guzic_normal_row" style="border-bottom:1px solid #c5c5c5;">
		<style type="text/css">
			.all_search_guzic_normal_row > table{margin-bottom:0;}
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