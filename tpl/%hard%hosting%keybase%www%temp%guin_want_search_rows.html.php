<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 14:06:48 */
function SkyTpl_Func_4071963596 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="sub_guin_list" style="border-bottom:1px solid #dfdfdf; padding:20px 0">
	<table cellpadding="0"cellspacing="0" style="width:100%">
		<tr>
			<td style="width:160px; text-align:left; line-height:24px">
				<span style="display:block; letter-spacing:-1px; width:160px" class="font_16 noto400 ellip">
					<a href="com_info.php?com_info_id=<?=$_data['NEW']['guin_id']?>&guin_number=<?=$_data['NEW']['number']?>" style="color:#3b3b3b;"><span class="noto500"><?=$_data['NEW']['name']?></span> <?=$_data['NEW']['adult_guin_icon']?></a>
				</span>
				<span style="width:160px; display:block; letter-spacing:-1px; color:#<?=$_data['배경색']['서브색상']?>" class="font_14 noto400 ellip">
					<?=$_data['NEW']['HopeSize']?>

				</span>
			</td>
			<td style="text-align:left; vertical-align:top; line-height:24px; padding-left:10px">
				<span style="display:block; letter-spacing:-1px; color:#333;" class="font_17 noto500 ">
					<?=$_data['NEW']['bgcolor1']?><a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=0&action=search&area_read=&jobclass_read=&edu_read=&career_read=&gender_read=&title_read=&type_read=&pay_read=" style=" color:#333;"><?=$_data['NEW']['title']?></a><?=$_data['NEW']['bgcolor2']?>

				</span>
				<span style="display:block; margin-top:5px">
					<?=$_data['NEW']['freeicon_com_out']?> <?=$_data['NEW']['식사제공']?> <?=$_data['NEW']['보너스']?> <?=$_data['NEW']['주5일근무']?> <?=$_data['NEW']['우대조건']?>

				</span>
				<span style="display:block; width:545px; letter-spacing:-1px; " class="font_14 noto400 ellip">
					<?=$_data['NEW']['guin_pay_icon']?> <?=$_data['NEW']['guin_pay']?>

				</span>
				<span style="display:block; width:545px; letter-spacing:-1px; " class="font_14 noto400 ellip">
					<?=$_data['NEW']['si1']?> <?=$_data['NEW']['gu1']?> <span style="margin-left:10px"><?=$_data['NEW']['underground1']?> <?=$_data['NEW']['underground2']?></span>
				</span>
			</td>
			<td style="width:170px; text-align:center; line-height:24px">
				<span style="display:block; letter-spacing:-1px; width:160px; margin:0 auto; color:#666" class="font_14 noto400 ellip">
					<?=$_data['NEW']['guin_career']?><br><?=$_data['NEW']['guin_edu']?><br/>모집인원 <span style="color:#333"><?=$_data['NEW']['howpeople']?></span> 명
				</span>
			</td>
			<td style="width:170px; text-align:center; line-height:24px">
				<span style="display:block; letter-spacing:0; width:160px; margin:0 auto; color:#999" class="font_14 noto400 ellip">
					등록일 : <?=$_data['NEW']['guin_date']['0']?><br>수정일 : <?=$_data['NEW']['guin_modify_cut']?>

				</span>
			</td>
			<td style="width:145px; text-align:center; line-height:24px" class="font_14 noto400 ">
				<span class="d_day"><?=$_data['NEW']['guin_end_date']?></span><br/>
				<?=$_data['스크랩버튼2']?>

			</td>
		</tr>
	</table>
</div>
<!-- { {NEW.guin_end_date_dday} } -->
<? }
?>