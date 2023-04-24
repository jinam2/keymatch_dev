<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:20:36 */
function SkyTpl_Func_1260289477 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div style="position:relative; border:2px solid #af9e67; padding:15px 15px 15px 20px; margin-bottom:10px; overflow:hidden" class="wodae_in">
	<div class="txt font_malgun">
		추천
	</div>
	<div class="triangle2"></div>
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td>
				<div>
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td>
								<table class="tbl" style="width:100%">
									<tr>
										<td>
											<div class="ellipsis_line1 font_14 font_malgun" style="letter-spacing:-1px">
												<strong>
													<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>" style="color:#<?=$_data['배경색']['서브색상']?>"><?=$_data['NEW']['name']?></a>
												</strong>
											</div>
										</td>
									</tr>
									<tr>
										<td style="padding-top:10px;">
											<div class="ellipsis_line2 font_16 font_malgun" style="line-height:150%;">
												<?=$_data['NEW']['bgcolor1']?>

												<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>" class="" style=" color:#333; letter-spacing:-1.4px; ">
												<?=$_data['NEW']['title']?>

												</a>
												<?=$_data['NEW']['bgcolor2']?>

											</div>
										</td>
									</tr>
								</table>
							</td>
							<td style="padding-left:10px; text-align:right">
								<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>" class="" style=" color:#333; letter-spacing:-1px; ">
									<img src="<?echo happy_image('NEW.com_logo','가로100','세로53','로고사용안함','로고위치7번','퀄리티100','gif원본출력','img/no_photo.gif','비율대로축소','2') ?>"  border="0" align="absmiddle" height="<?=$_data['ComLogoDstH']?>" width="<?=$_data['ComLogoDstW']?>" style="margin-top:10px">
								</a>
							</td>
						</tr>
						<tr>
							<td style="text-align:left; color:#333; padding-top:25px" class="font_malgun font_14">
								<?=$_data['NEW']['guin_end_date']?>

							</td>
							<td style="text-align:right; padding-top:25px">
								<?=$_data['스크랩버튼']?>

								<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>" style="vertical-align:middle">
									<img src="img/rows_more.gif" style="vertical-align:middle" class="onepx">
								</a>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>
<? }
?>