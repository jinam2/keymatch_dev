<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 09:17:26 */
function SkyTpl_Func_2886903783 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hr_listing_01">
	<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>">
		<b>
			<img src="<?echo happy_image('자동','가로86','세로86','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로확대','2') ?>">
		</b>
		<div>
			<p>
				<b><?=$_data['Data']['user_name_cut']?></b>
				<span class="ellipsis_line_1"><?=$_data['Data']['job_type']?></span>
			</p>
			<p>
				<strong class="ellipsis_line_1">
					<?=$_data['OPTION']['bgcolor1']?>

						<?=$_data['OPTION']['bolder']?>

							<?=$_data['OPTION']['color']?>

								<?=$_data['Data']['title']?>

							<?=$_data['OPTION']['color2']?>

						<?=$_data['OPTION']['bolder2']?>

					<?=$_data['OPTION']['bgcolor2']?>

				</strong>
				<span><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?> / <?=$_data['Data']['grade_lastgrade']?></span>
			</p>
		</div>
	</a>
</div>
<? }
?>