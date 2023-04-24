<? /* Created by SkyTemplate v1.1.0 on 2023/03/24 20:15:36 */
function SkyTpl_Func_807008850 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hire_listing_02">
	<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>">
		<img src="<?echo happy_image('NEW.logo','가로120','세로36','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로축소','2') ?>" height="<?=$_data['ComBannerDstH']?>" width="<?=$_data['ComBannerDstW']?>">
	</a>
	<div>
		<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>">
			<b><?=$_data['NEW']['name']?></b>
			<strong><?=$_data['NEW']['bgcolor1']?><?=$_data['NEW']['title']?><?=$_data['NEW']['bgcolor2']?></strong>
		</a>
		<p>
			<?=$_data['NEW']['guin_end_date']?>

			<b><?=$_data['스크랩버튼']?></b>
		</p>	
	</div>		
</div>

<? }
?>