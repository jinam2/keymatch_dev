<? /* Created by SkyTemplate v1.1.0 on 2023/03/06 16:47:03 */
function SkyTpl_Func_3838284787 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="dp_table hire_listing_04 ">
	<ul>
		<li><?=$_data['스크랩버튼']?></li>
		<li>
			<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>">		
				<strong class="ellip"><?=$_data['NEW']['bgcolor1']?><?=$_data['NEW']['title']?><?=$_data['NEW']['bgcolor2']?></strong>		
				<b><?=$_data['NEW']['name']?></b>
			</a>
		</li>
		<li><span class="ellipsis_line2"><?=$_data['NEW']['si1']?> <?=$_data['NEW']['gu1']?> <?=$_data['NEW']['adult_guin_icon']?></span></li>
		<li><span class="ellipsis_line2"><?=$_data['NEW']['guin_end_date']?></span></li>
		<li><b><?=$_data['NEW']['guin_career']?></b></li>
	</ul>	
</div>
<? }
?>