<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 10:38:22 */
function SkyTpl_Func_2907796623 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<span class="<?=$_data['JOB_TYPE']['title_style']?>">
	<div class="line"></div>
	<a href='html_file_per.php?file=<?=$_data['_GET']['file']?>&job_type_read=<?=$_data['JOB_TYPE']['title_encode']?>&mode=<?=$_data['_GET']['mode']?>&guin_per_start_date=<?=$_data['_GET']['guin_per_start_date']?>&guin_per_end_date=<?=$_data['_GET']['guin_per_end_date']?>&search_word=<?=$_data['_GET']['search_word']?>' class="noto400 font_14" style="letter-spacing:-1px; padding:3px 0;"><?=$_data['JOB_TYPE']['title']?></a>
</span>

<? }
?>