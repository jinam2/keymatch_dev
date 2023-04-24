<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 09:17:16 */
function SkyTpl_Func_3561909164 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hr_listing_02 dp_table">
	<ul>
		<li><img src="<?echo happy_image('자동','가로48','세로48','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/no_photo.gif','비율대로확대','2') ?>" alt="" /></li>
		<li>
			<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="color:#666666;">
				<strong class="ellipsis_line_1">
						<?=$_data['OPTION']['bgcolor1']?>

							<?=$_data['OPTION']['bolder']?>

								<?=$_data['OPTION']['color']?>

									<?=$_data['Data']['title']?>

								<?=$_data['OPTION']['color2']?>

							<?=$_data['OPTION']['bolder2']?>

						<?=$_data['OPTION']['bgcolor2']?>

						 <?=$_data['OPTION']['icon']?>&nbsp;<?=$_data['OPTION']['user_photo']?>

					</strong>
				<b><?=$_data['Data']['adult_guzic_icon']?> <?=$_data['Data']['user_name_cut']?><span>(<?=$_data['Data']['user_prefix']?> · <?=$_data['Data']['age']?>세)</span></b>
			</a>
		</li>
		<li><span class="ellipsis_line2"><?=$_data['Data']['job_type']?></span></li>
		<li><span class="ellipsis_line2"><?=$_data['Data']['job_where']?></span></li>		
		<li><b style="background:#<?=$_data['배경색']['기본색상']?>"><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?></b></li>
	</ul>
</div>
<? }
?>