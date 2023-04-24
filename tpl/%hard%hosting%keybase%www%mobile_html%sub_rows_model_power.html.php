<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 11:07:57 */
function SkyTpl_Func_220621582 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="m_hr_list_03">
	<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>">
		<img src="<?echo happy_image('자동','가로48','세로48','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로확대','2') ?>" alt="" />
	</a>
	<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>">
		<b><?=$_data['Data']['adult_guzic_icon']?> <?=$_data['Data']['user_name_cut']?><span>(<?=$_data['Data']['user_prefix']?> · <?=$_data['Data']['age']?>세)</span></b>
		<strong class="ellipsis_line1">
			<?=$_data['OPTION']['bgcolor1']?>

				<?=$_data['OPTION']['bolder']?>

					<?=$_data['OPTION']['color']?>

						<?=$_data['Data']['title']?>

					<?=$_data['OPTION']['color2']?>

				<?=$_data['OPTION']['bolder2']?>

			<?=$_data['OPTION']['bgcolor2']?>

			 <?=$_data['OPTION']['icon']?>&nbsp;<?=$_data['OPTION']['user_photo']?>

		</strong>	
		<p class="ellipsis_line1">
			<?=$_data['Data']['job_type']?> <span class="font_6" style='vertical-align:middle; display:inline-block; margin:0 5px; color:#ddd'>|</span> <?=$_data['Data']['job_where']?>

		</p>
	</a>
</div>
<? }
?>