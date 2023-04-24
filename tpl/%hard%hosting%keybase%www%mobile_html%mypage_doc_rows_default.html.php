<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 16:48:26 */
function SkyTpl_Func_3607429971 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="hire_listing_04 " style="display:block; border-bottom:1px solid #ddd; height:auto;">
	<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="width:100%;">
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
	<table style="width:100%; margin-top:20px;" class="tb_st_01" >
		<colgroup>
			<col width="33.3333%"/>
			<col width="33.3333%"/>
			<col width="33.3333%"/>
		</colgroup>
		<tbody>
			<tr>
				<td style="text-align:center;"><a href="tel:<?=$_data['Data']['user_phone']?>"><i uk-icon="icon:receiver; ratio:1.3"></i><span style="display:block; margin-top:5px;" class="font_14">일반전화</span></a></td>
				<td style="text-align:center;"><a href="tel:<?=$_data['Data']['user_hphone']?>"><i uk-icon="icon:phone; ratio:1.3"></i><span style="display:block; margin-top:5px;" class="font_14">휴대전화</span></a></td>
				<td style="text-align:center; border-right:1px solid #ddd"><a href="mailto:<?=$_data['Data']['user_email1']?>"><i uk-icon="icon:mail; ratio:1.3"></i><span style="display:block; margin-top:5px;" class="font_14">이메일</span></a></td>
			</tr>
		</tbody>
	</table>
</div>

<? }
?>