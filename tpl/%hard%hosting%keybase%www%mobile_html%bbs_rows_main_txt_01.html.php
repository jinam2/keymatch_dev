<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_2570350114 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<p class="text_gall">
	<a href='bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>' class="ellipsis_line1"><?=$_data['BOARD']['bbs_title_none']?></a>
	<span><?=$_data['BOARD']['bbs_date']?></span>
</p>

<? }
?>