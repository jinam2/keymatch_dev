<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 15:34:53 */
function SkyTpl_Func_706040777 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style=" background:#fff; position:relative; overflow:hidden; padding:15px 0; border-bottom:1px solid #ddd;" >
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td style="padding:0 30px 10px 15px; line-height:24px; vertical-align:top">
				<table cellpadding="0" cellspacing="0" style="width:100%" onclick="location.href='./guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=0&action=search&area_read=&jobclass_read=&edu_read=&career_read=&gender_read=&title_read=&type_read=&pay_read='">
					<tr>
						<td class="font_16 noto400" style="letter-spacing:-1.5px; color:#<?=$_data['배경색']['모바일_서브색상']?>; font-weight:bold">
							<?=$_data['NEW']['com_name']?>

						</td>
					</tr>
					<tr>
						<td style="padding:10px 0">
							<div style="overflow:hidden; letter-spacing:-1.5px; line-height:140%" class="noto500 font_18 ellipsis_line2">
								<?=$_data['NEW']['title']?>

							</div>
						</td>
					</tr>
					<tr>
						<td class="noto400 font_14" style="color:#999; letter-spacing:-1px; color:#1a1a1a">
							<span class="ellipsis_line1">
								<span style="color:#<?=$_data['배경색']['모바일_기타페이지2']?>"><?=$_data['채용지역정보']?></span> | <?=$_data['NEW']['guin_career']?>

							</span>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:100px; text-align:center; border-left:1px solid #e9e9e9" class="font_tahoma noto400 font_20">
				<span style="letter-spacing:0;" class="dday"><?=$_data['NEW']['guin_end_date']?></span>

			</td>
		</tr>
	</table>
</div>
<? }
?>