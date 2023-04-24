<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 11:07:57 */
function SkyTpl_Func_4140422072 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hire_listing_04 ">
	<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>">
		<b><?=$_data['Data']['user_name_cut']?> <span>(<?=$_data['Data']['user_prefix']?>,<?=$_data['Data']['age']?>)</span> </b>
		<strong class="ellipsis_line1">
			<?=$_data['OPTION']['bgcolor1']?>

				<?=$_data['OPTION']['bolder']?>

					<?=$_data['OPTION']['color']?>

						<?=$_data['Data']['title']?><?=$_data['Data']['adult_guzic_icon']?> <?=$_data['OPTION']['user_photo']?> <?=$_data['OPTION']['icon']?>

					<?=$_data['OPTION']['color2']?>

				<?=$_data['OPTION']['bolder2']?>

			<?=$_data['OPTION']['bgcolor2']?>

		</strong>	
		<p class="ellipsis_line1"><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?> <span>|</span> <?=$_data['Data']['grade_lastgrade']?> <span>|</span> <?=$_data['Data']['job_type']?></p>
		<p class="option_icons_wrap"><?=$_data['OPTION']['special2']?> <?=$_data['OPTION']['powerlink2']?> <?=$_data['OPTION']['focus2']?></p>
	</a>	
</div>

<? }
?>