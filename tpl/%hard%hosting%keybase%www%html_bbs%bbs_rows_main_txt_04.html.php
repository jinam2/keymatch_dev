<? /* Created by SkyTemplate v1.1.0 on 2023/03/06 16:47:03 */
function SkyTpl_Func_3233444197 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="dp_table bbs_type_text04">
	<ul>
		<li>
			<a href="bbs_detail.php?bbs_num=<?=$_data['BOARD']['number']?>&tb=<?=$_data['B_CONF']['tbname']?>" class="ellipsis_line1">
				<?=$_data['BOARD']['bbs_title_none']?>

			</a>
		</li>
		<li><span><?=$_data['BOARD']['bbs_date']?></span></li>
	</ul>
</div>
<? }
?>