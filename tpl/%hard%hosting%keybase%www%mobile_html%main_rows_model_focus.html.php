<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:51:50 */
function SkyTpl_Func_904626723 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="m_hr_list_01">
	<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="color:#666666">
		<div>
			<span><?=$_data['Data']['job_where']?></span>
			<strong class="ellipsis_line2">		
				<?=$_data['OPTION']['bgcolor1']?>			
						<?=$_data['OPTION']['bolder']?>

							<?=$_data['OPTION']['color']?>

								<?=$_data['Data']['title_cut']?>

							<?=$_data['OPTION']['color2']?>

						<?=$_data['OPTION']['bolder2']?>				
				<?=$_data['OPTION']['bgcolor2']?>

				<?=$_data['Data']['adult_guzic_icon']?>

			</strong>
			<p class="ellipsis_line1"><?=$_data['Data']['job_type_sub']?></p>	
		</div>
		<div>
			<img src="<?echo happy_image('자동','가로125','세로125','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로확대','2') ?>">
			<p>
				<span><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?>/ <?=$_data['Data']['grade_lastgrade']?></span>
				<b><?=$_data['Data']['user_name_cut']?> <small>(<?=$_data['Data']['user_prefix']?>/<?=$_data['Data']['age']?>세)<?=$_data['OPTION']['freeicon']?></small></b>
			</p>		
		</div>
	</a>
</div>
<? }
?>