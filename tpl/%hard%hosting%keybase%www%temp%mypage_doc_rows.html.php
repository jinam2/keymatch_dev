<? /* Created by SkyTemplate v1.1.0 on 2023/03/10 10:14:35 */
function SkyTpl_Func_2496504484 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- FORM -->
<form name="search_guzic_<?=$_data['doc_extraction_unique_number']?>_<?=$_data['Data']['number']?>_frm" action="guin_list.php" method="get" style="margin:0;">
<input type="hidden" name="action" value="search">
<input type="hidden" name="search_si" value="<?=$_data['Data']['job_where1_0']?>">
<input type="hidden" name="search_si2" value="<?=$_data['Data']['job_where2_0']?>">
<input type="hidden" name="search_si3" value="<?=$_data['Data']['job_where3_0']?>">
<input type="hidden" name="search_type" value="<?=$_data['Data']['job_type1_top']?>">
<input type="hidden" name="search_type2" value="<?=$_data['Data']['job_type2_top']?>">
<input type="hidden" name="search_type3" value="<?=$_data['Data']['job_type3_top']?>">
<input type="hidden" name="search_type_sub" value="<?=$_data['Data']['job_type1_original']?>">
<input type="hidden" name="search_type_sub2" value="<?=$_data['Data']['job_type2_original']?>">
<input type="hidden" name="search_type_sub3" value="<?=$_data['Data']['job_type3_original']?>">
<!-- <input type="hidden" name="career_read" value="<?=$_data['Data']['work_year_search']?>">
<input type="hidden" name="gender_read" value="<?=$_data['Data']['user_prefix']?>">
<input type="hidden" name="job_type_read" value="<?=$_data['Data']['grade_gtype']?>">
<input type="hidden" name="edu_read" value="<?=$_data['Data']['grade_lastgrade']?>">
<input type="hidden" name="pay_read" value="<?=$_data['Data']['grade_money']?>"> -->
<input type="hidden" name="my" value="1">
</form>

<div>
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse: collapse;">
		<tr>
			<td style="width:180px; background:#f3f7f8; text-align:center; border:1px solid #ccc; border-left:0 none; border-top:0 none !important">
				<span style="display:block">
					<img src="<?echo happy_image('자동','가로60','세로72','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/logo_img.gif','비율대로확대') ?>" border="0" align="absmiddle">
				</span>
				<span style="padding:8px 0; display:block; font-weight:bold; letter-spacing:-1.2px; color:#333" class="font_16 noto500">
					<?=$_data['Data']['display_print_none']?>

				</span>
			</td>
			<td style="border:1px solid #ccc; padding:25px 30px; vertical-align:top; text-align:left; border-top:0 none !important">
				<h4 class="font_18 noto500" style="letter-spacing:-1px; padding-bottom:15px; margin:0;">
					<?=$_data['OPTION']['bgcolor1']?><a href="document_view.php?number=<?=$_data['Data']['number']?>" style="color:#333;">
						<span style="letter-spacing:0">[<?=$_data['Data']['number']?>]</span><?=$_data['Data']['title']?>

					</a><?=$_data['OPTION']['bgcolor2']?>

				</h4>
				<table cellpadding="0"cellspacing="0" style="width:100%; line-height:22px" class="resister_rows">
					<tr>
						<th class="font_15 noto400">희망직종</th>
						<td class="font_15 noto400" style="padding-left:15px;"><?=$_data['Data']['job_type']?></td>
					</tr>
					<tr>
						<th class="font_15 noto400">희망지역</th>
						<td class="font_15 noto400" style="padding-left:15px;"><?=$_data['Data']['job_where']?></td>
					</tr>
					<tr>
						<th class="font_15 noto400">등록일</th>
						<td class="font_15 noto400" style="padding-left:15px;"><?=$_data['Data']['regdate']?></td>
					</tr>
					<tr>
						<th class="font_15 noto400">최종수정일</th>
						<td class="font_15 noto400" style="padding-left:15px;">
							<span style="color:#<?=$_data['배경색']['기타페이지2']?>"><?=$_data['Data']['modifydate']?></span>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:220px; text-align:center; border:1px solid #ccc; border-top:0 none !important">
				<div style="line-height:30px">
					<span style="display:block; letter-spacing:-1px" class="font_15 noto400">
						<span class="font_15 noto400" style="color:#333; letter-spacing:-1px; display:inline-block; width:136px; text-align:center; height:30px; line-height:30px; background:url('./img/main_latest_bg.png') 0 0 no-repeat; color:#<?=$_data['배경색']['기타페이지2']?>">
							<?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?>

						</span>
					</span>
					<span style="display:block; letter-spacing:-1px" class="font_15 noto400">
						 <?=$_data['Data']['work_otherCountry']?>

					</span>
					<span style="display:block; letter-spacing:-1px;" class="font_15 noto400">
						<?=$_data['Data']['grade_money_icon']?> <?=$_data['Data']['grade_money']?>

					</span>
				</div>
			</td>
			<td style="width:200px; border:1px solid #ccc; border-right:0 none; border-top:0 none !important; text-align:center">
				<div style="padding:40px; line-height:24px">
					<span style="display:block; letter-spacing:-1px; color:#333;" class="font_15 noto400">
						조회수 <span style="color:#<?=$_data['배경색']['기타페이지2']?>"><?=$_data['Data']['viewListCount']?></span> 회
					</span>
				</div>
			</td>
		</tr>
	</table>
	<div style="padding:5px 0; border-bottom:1px solid #ccc">
		<table cellpadding="0" cellspacing="0" style="width:100%;">
			<tr>
				<td>
					<a href="document.php?mode=uryo&number=<?=$_data['Data']['number']?>">
						<img src="img/bt_myroom_com_sth_btn.gif" border="0" align="absmiddle" style="margin-right:2px; vertical-align:middle">
					</a>
					<span style="width:108px; height:28px; line-height:30px; display:inline-block; background:url('img/mypage_per_sth_bg.gif') 0 0 no-repeat; letter-spacing:-1.5px; vertical-align:middle">
						<span style="padding-left:23px; color:#666;" class="font_11 font_dotum"><?=$_data['사용중인옵션']?></span>
					</span>
					<a href="javascript:void(0)" onClick="document.search_guzic_<?=$_data['doc_extraction_unique_number']?>_<?=$_data['Data']['number']?>_frm.submit()">
						<img src="img/bt_myroom_per_ppl.gif" border="0" align="absmiddle" style="vertical-align:middle">
					</a>
				</td>
				<td style="text-align:right">
					<a href="document.php?mode=modify&subMode=type1&number=<?=$_data['Data']['number']?>" title="수정">
						<img src="img/bt_myroom_com_mod.gif" border="0" align="absmiddle" style="margin-right:2px;" alt="수정">
					</a>
					<a href="javascript:guzicdel('guzic_del.php?number=<?=$_data['Data']['number']?>')" title="삭제">
						<img src="img/bt_myroom_com_del.gif" border="0" align="absmiddle" alt="삭제">
					</a>
				</td>
			</tr>
		</table>
	</div>
</div>

<!--
	<?=$_data['Data']['viewListCount']?>개
	회사수 : <?=$_data['회사수']?>개 &nbsp;
	기술수 : <?=$_data['기술수']?>개 &nbsp;
	언어수 : <?=$_data['언어수']?>개 &nbsp;
	연수횟수 : <?=$_data['연수횟수']?>개
-->






<? }
?>