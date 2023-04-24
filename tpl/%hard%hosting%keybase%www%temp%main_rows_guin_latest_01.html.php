<? /* Created by SkyTemplate v1.1.0 on 2023/03/06 16:47:03 */
function SkyTpl_Func_1136746285 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hire_listing_05 ">
	<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>">
		<b><?=$_data['NEW']['name']?></b>
		<strong class="ellipsis_line1"><?=$_data['NEW']['bgcolor1']?><?=$_data['NEW']['title']?><?=$_data['NEW']['bgcolor2']?></strong>
	</a>
	<p>
		<span class="ellipsis_line2"><?=$_data['NEW']['guin_end_date']?></span>
		<b><?=$_data['스크랩버튼']?></b>
	</p>
</div>
<? }
?>