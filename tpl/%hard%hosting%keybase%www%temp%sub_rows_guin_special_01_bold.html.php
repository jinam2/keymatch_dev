<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:15:50 */
function SkyTpl_Func_3495078186 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hire_listing_03">
	<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>">
		<b><?=$_data['NEW']['name']?></b>
		<strong><?=$_data['NEW']['bgcolor1']?><?=$_data['NEW']['title']?><?=$_data['NEW']['bgcolor2']?></strong>		
	</a>
	<p>
		<?=$_data['NEW']['guin_end_date']?>

		<b><?=$_data['스크랩버튼']?></b>
	</p>
</div>
<? }
?>