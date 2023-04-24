<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 11:19:06 */
function SkyTpl_Func_1031320283 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hire_listing_01">
	<a href="com_info.php?com_info_id=<?=$_data['Data']['guin_id']?>&guin_number=<?=$_data['Data']['number']?>">
		<img src="<?=$_data['Data']['logo']?>"  border="0" align="absmiddle" width="<?=$_data['ComBannerDstW']?>" height="<?=$_data['ComBannerDstH']?>">
		<b><?=$_data['Data']['name']?></b>
		<strong><?=$_data['Data']['bgcolor1']?><?=$_data['Data']['title']?><?=$_data['Data']['bgcolor2']?></strong>
	</a>
	<p>
		<?=$_data['Data']['guin_end_date']?>

		<b><?=$_data['스크랩버튼']?></b>
	</p>				
</div>
<? }
?>