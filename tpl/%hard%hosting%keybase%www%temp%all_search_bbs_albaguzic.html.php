<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 17:42:55 */
function SkyTpl_Func_3788398422 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="letter-spacing:-1px; padding-bottom:10px;">
	<span class="font_20 noto500" style="color:#333;"><?=$_data['타이틀명']?> 검색결과</span>
</div>
<div class="bbs_alba_list">
	<ul class="bbs_alba_th">
		<li>인재정보</li>
		<li>희망 근무조건</li>
		<li>희망급여</li>
		<li>등록일</li>
	</ul>
	<div class="bbs_alba_td bbs_alba_gz_td">
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