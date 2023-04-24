<? /* Created by SkyTemplate v1.1.0 on 2023/03/06 16:47:03 */
function SkyTpl_Func_2607223187 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="bbs_type_photo">
	<a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&id=<?=$_data['_GET']['id']?>&tb=<?=$_data['B_CONF']['tbname']?>">
		<?=$_data['BOARD']['img']?>

	</a>
	<p>		
		<strong class="ellipsis_line1"><?=$_data['BOARD']['bbs_title']?></strong>
		<span><?=$_data['BOARD']['bbs_date']?></span>		
	</p>	
</div>
<? }
?>