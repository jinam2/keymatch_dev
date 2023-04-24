<? /* Created by SkyTemplate v1.1.0 on 2023/04/11 10:35:11 */
function SkyTpl_Func_1312167868 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="position:relative; color:#424242; padding:12px 0; letter-spacing:-1.5px; border-bottom:2px solid #000; font-weight:bold" class="font_20 font_malgun">
	<span style="color:#<?=$_data['배경색']['모바일_서브색상']?>"><?=$_data['타이틀명']?></span> 검색결과
	<span style="position:absolute; top:15px; right:0;" class="font_8">
		<a href="html_file.php?file=guzic_special.html&guzic_keyword=<?=$_data['검색어']?>">
			<img src="img/btn_more_main.gif" align="absmiddle" alt="더많은검색결과">
		</a>
	</span>
</div>
<div style="margin-bottom:20px; padding-top:10px"><?=$_data['검색결과리스트']?></div>

<? }
?>