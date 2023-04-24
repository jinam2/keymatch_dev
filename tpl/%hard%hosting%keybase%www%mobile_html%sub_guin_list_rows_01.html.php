<? /* Created by SkyTemplate v1.1.0 on 2023/03/24 18:46:45 */
function SkyTpl_Func_2477490954 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hire_listing_04 ">
	<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>">
		<b><?=$_data['NEW']['name']?></b>
		<strong class="ellipsis_line1"><?=$_data['NEW']['bgcolor1']?><?=$_data['NEW']['title']?><?=$_data['NEW']['adult_guin_icon']?><?=$_data['NEW']['bgcolor2']?></strong>	
		<p><?=$_data['NEW']['si1']?> <?=$_data['NEW']['gu1']?> <span>|</span> <?=$_data['NEW']['guin_career']?></p>
		<p><?=$_data['NEW']['adult_guin_icon']?> <?=$_data['NEW']['식사제공2']?> <?=$_data['NEW']['보너스2']?> <?=$_data['NEW']['주5일근무2']?> <?=$_data['NEW']['우대조건2']?> <?=$_data['NEW']['freeicon_com_out']?></p>
	</a>
	<p>
		<?=$_data['스크랩버튼']?>

		<b><?=$_data['NEW']['guin_end_date']?></b>
	</p>
	
</div>

<? }
?>