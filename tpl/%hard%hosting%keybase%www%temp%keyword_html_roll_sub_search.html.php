<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:13 */
function SkyTpl_Func_1353671399 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<li style="height:25px; margin:2px 0;">
	<p style="position:relative; padding-right:50px; box-sizing:border-box;">
		<span class="rankIcon_<?=$_data['rank_cnt_chk']?> font_12" style="width:20px; height:20px; line-height:20px; display:inline-block; font-family:tahoma; text-align:center; margin-top:2px; border-radius:3px; text-align:center; box-sizing:border-box;"><?=$_data['rank_num']?></span>
		<a href="all_search.php?action=search&amp;file=all_search.html&amp;all_keyword=<?=$_data['rank_word_encode']?>" class="font_15 noto400" style="letter-spacing:-0.5px; display:inline-block; padding-left:10px;"><?=$_data['rank_word']?></a>
		<span style="position:absolute; right:0; text-align:right;"><img src="upload/happy_config/<?=$_data['rank_icon_html']?>.gif" alt="" /><?=$_data['rank_change']?></span>
	</p>
</li>


<? }
?>