<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 17:42:55 */
function SkyTpl_Func_1061031786 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="letter-spacing:-1px; padding-bottom:10px;">
	<span class="font_20 noto400" style="color:#222"><span style="color:#<?=$_data['배경색']['서브색상']?>; font-weight:500; letter-spacing:-1px;"><?=$_data['타이틀명']?></span> 검색결과</span>
	<span style="padding-left:5px; font-size:15px;">
		<strong style="color:#666; font-weight:500;">'<?=$_data['_GET']['all_keyword']?>'</strong> 관련 광고입니다
		<img src="img/ad_ico_01.gif" alt="광고" style="padding:0 0 3px 5px; vertical-align:middle;">
	</span>
</div>
<div style="border-bottom:1px solid #b3b9ef;"><?=$_data['검색결과리스트']?></div>
<div style="text-align:right; padding:10px 0">
	<a href="html_file.php?file=guzic_power.html&guzic_keyword=<?=$_data['검색어']?>" style="color:#0000cc; font-size:15px;">
	<?=$_data['타이틀명']?> 더보기 <img src="img/search_plus_03.png" align="absmiddle" alt="더많은검색결과" style="vertical-align:middle">
	</a>
</div>

<? }
?>