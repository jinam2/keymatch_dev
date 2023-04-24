<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_2204170610 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hire_listing_04 ">
	<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>">
		<b><?=$_data['NEW']['name']?></b>
		<strong class="ellip"><?=$_data['NEW']['bgcolor1']?><?=$_data['NEW']['title']?><?=$_data['NEW']['adult_guin_icon']?><?=$_data['NEW']['bgcolor2']?></strong>	
		<p><?=$_data['NEW']['si1']?> <?=$_data['NEW']['gu1']?> <span>|</span> <?=$_data['NEW']['guin_career']?></p>
	</a>
	<p>
		<?=$_data['스크랩버튼']?>

		<b><?=$_data['NEW']['guin_end_date']?></b>
	</p>
</div>
<? }
?>