<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 17:42:55 */
function SkyTpl_Func_2093532241 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="letter-spacing:-1px; padding-bottom:10px; border-bottom:1px solid #eaeaea">
	<span class="font_20 noto500" style="color:#333;"><?=$_data['타이틀명']?> 검색결과</span>
</div>
<div style="padding:10px 0 10px 0"><?=$_data['검색결과리스트']?></div>
<div style="text-align:right; padding:10px 0; border-top:1px solid #eaeaea">
	<a href="<?=$_data['더많은결과링크주소']?>" style="color:#0000cc; font-size:15px;">
		검색결과 더보기 <img src="img/search_plus_03.png" align="absmiddle" alt="더많은검색결과" style="vertical-align:middle">
	</a>
</div>



<? }
?>