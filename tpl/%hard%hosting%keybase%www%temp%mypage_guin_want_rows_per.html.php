<? /* Created by SkyTemplate v1.1.0 on 2023/04/17 13:25:20 */
function SkyTpl_Func_2356756847 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse: collapse; background:#<?=$_data['배경색']['메인페이지']?>">
		<tr>
			<td style="width:107px; text-align:center; border-bottom:1px dashed #dedede">
				<a href="./com_info.php?com_info_id=<?=$_data['GUIN_INFO']['guin_id']?>&guin_number=<?=$_data['GUIN_INFO']['number']?>" target="_blank"><img src="<?=$_data['GUIN_INFO']['logo']?>" alt="기관로고" width="80" height="36" onError="this.src='./img/img_noimage_100x36.jpg'" style="border:1px solid #dedede;"></a>
			</td>
			<td style="padding:17px 15px; text-align:left; border-bottom:1px dashed #dedede; line-height:22px">
				<span style="display:block; letter-spacing:-1px;" class="font_17 noto400">
					<?=$_data['NEW']['bgcolor1']?><a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>" style="color:#333;">
						<?=$_data['NEW']['title']?>

					</a>
					<?=$_data['NEW']['bgcolor2']?>

				</span>
				<span style="color:#666666; display:block; letter-spacing:-1px;" class="font_14 noto400">
					담당업무 : <?=$_data['NEW']['guin_work_content']?>

				</span>
			</td>
			<td style="width:70px; border-bottom:1px dashed #dedede; text-align:left; border-top:0; letter-spacing:-1px; color:#333" class="font_16 noto400">
				<?=$_data['NEW']['guin_end_text']?>

			</td>
			<td style="width:100px; border-bottom:1px dashed #dedede;text-align:center; border-top:0; color:#<?=$_data['배경색']['기타페이지']?>" class="font_16 noto400">
				<?=$_data['NEW']['guin_end_date']?>

			</td>
			<td style="width:243px; border-bottom:1px dashed #dedede; text-align:center; letter-spacing:-1px; color:#333;" class="font_14 noto400">
				<?=$_data['NEW']['guin_pay_icon']?> 급여 : <?=$_data['NEW']['guin_pay']?>

			</td>
			<td style="width:120px; border-bottom:1px dashed #dedede; text-align:center">
				<a href="guin_detail.php?num=<?=$_data['NEW']['number']?>&pg=<?=$_data['pg']?>&cou=<?=$_data['NEW']['guin_count']?>&clickChk=<?=$_data['clickChk']?>" class="" style="color:#333; letter-spacing:-1px; ">
					<img src="img/btn_detail_guzic.gif" alt="상세보기">
				</a>
			</td>
		</tr>
	</table>
</div>
<div style="border-bottom:1px solid #dfdfdf;">
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse: collapse;">
		<tr>
			<td style="width:107px; text-align:center">
				<img src="img/skin_icon/make_icon/skin_icon_717.jpg">
			</td>
			<td style="padding:20px 15px; text-align:center; ">
				<table cellpadding="0"cellspacing="0" style="width:100%; line-height:22px" class="resister_rows">
					<tr>
						<th class="font_14 noto400">
							<img src="<?echo happy_image('DocData.img','가로60','세로72','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/logo_img.gif','비율대로확대') ?>" border="0" align="absmiddle">
						</th>
						<td class="font_14 noto400" style="text-align:left; padding-left:10px;">
							<h4 class="font_17 noto400" style="letter-spacing:-1px; margin:0 0 5px 0;">
								<a href="document_view.php?number=<?=$_data['DocData']['number']?><?=$_data['searchMethod2']?>" style="color:#333">
									<span style="letter-spacing:0">[<?=$_data['DocData']['number']?>]</span><a href="document_view.php?number=<?=$_data['DocData']['number']?>" style="color:#333"><?=$_data['DocData']['title']?></a>
								</a>
							</h4>
							<table cellpadding="0"cellspacing="0" style="width:100%; line-height:22px" class="resister_rows">
								<tr>
									<th class="font_14 noto400">희망직종</th>
									<td class="font_14 noto400">
										<?=$_data['DocData']['job_type1']?>,<?=$_data['DocData']['job_type2']?>,<?=$_data['DocData']['job_type3']?>

									</td>
								</tr>
								<tr>
									<th class="font_14 noto400">희망급여</th>
									<td class="font_14 noto400"><?=$_data['DocData']['grade_money_type']?> <?=$_data['DocData']['grade_money']?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:120px; text-align:center">
				<div style="line-height:24px">
					<span style="display:block;" >
						<a href="document_view.php?number=<?=$_data['NEW']['doc_number']?>">
							<img src="img/btn_detail_guzic.gif" alt="상세보기">
						</a>
					</span>
					<span style="display:block; margin-top:3px" >
						<a href="javascript:;" onclick="want_del('<?=$_data['NEW']['want_number']?>')">
							<img src="img/btn_scrap_del2.gif" border="0" align="middle" alt="삭제버튼">
						</a>
					</span>
				</div>
			</td>
		</tr>
	</table>
</div>

<? }
?>