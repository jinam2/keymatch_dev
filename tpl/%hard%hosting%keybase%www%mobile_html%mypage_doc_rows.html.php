<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 11:16:29 */
function SkyTpl_Func_2116337283 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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


<!-- { {Data.display_print_none} } -->
<div style=" background:#fff; border-bottom:1px solid #ddd; position:relative; overflow:hidden; padding:0 0 15px 0; " onclick="location.href='./document_view.php?file=doc_view_main2.html&number=<?=$_data['Data']['number']?>'">
	<div style="padding:15px; height:34px; border-top:1px solid #ddd; background:#<?=$_data['배경색']['모바일_메인페이지']?>; text-align:left; color:#333; letter-spacing:-1px; font-weight:bold; line-height:202%" class="ellipsis_line1 noto500 font_20">
		<span style="letter-spacing:0" class="font_tahoma">[<?=$_data['Data']['number']?>]</span> <?=$_data['Data']['title']?>

	</div>
	<table cellpadding="0" cellspacing="0" style="width:100%; margin-top:15px">
		<colgroup>
			<col style="width:30%">
			<col style="width:70%">
		</colgroup>
		<tbody>
			<tr>
				<td style="padding:10px; box-sizing:border-box; vertical-align:top">
					<img src="<?=$_data['작은이미지']?>" style="width:110px; height:110px; border-radius:100%">
				</td>
				<td style="padding:10px 10px 10px 15px; line-height:24px; vertical-align:top">
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td class="font_20 noto500" style="letter-spacing:-1px">
								<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="color:#333333;"><strong style="font-weight:500;"><?=$_data['Data']['user_name_cut']?></strong></a> <span style="color:#1b1b1b; font-weight:500;">(<?=$_data['Data']['user_id']?>)</span> - <?=$_data['Data']['display_print_none']?>

							</td>
						</tr>
						<tr>
							<td class="noto400 font_16" style="color:#999; letter-spacing:-1px; padding-top:12px">
								<span style="color:#3d3d3d" class="ellipsis_line1">
									<?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?> | <?=$_data['Data']['grade_lastgrade']?>

								</span>
							</td>
						</tr>
							<tr>
							<td class="noto400 font_16" style="color:#999; letter-spacing:-1px; padding:5px 0">
								<span style="color:#3d3d3d" class="ellipsis_line1"><?=$_data['Data']['grade_money_icon']?> <?=$_data['Data']['grade_money']?></span>
							</td>
						</tr>
						<tr>
							<td class="noto400 font_16" style="color:#999; letter-spacing:-1px">
								<span style="color:#3d3d3d" class="ellipsis_line1">
									<?=$_data['Data']['job_where']?>

								</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>		
	</table>
</div>
<div style="padding-bottom:20px; padding:20px; margin-bottom:20px; border-bottom:1px solid #ddd;">
	<table style="width:100%; " cellspacing="0" cellpadding="0" border="0" class="tb_st_03">
		<colgroup>
			<col style="width:30%">
			<col style="width:70%">
		</colgroup>
		<tr>
			<th>등록/수정일</th>
			<td>
				<?=$_data['Data']['regdate_cut']?> / <span style="color:#d00303"><?=$_data['Data']['modifydate_cut']?></span>
			</td>
		</tr>
		<tr>
			<th>키워드</th>
			<td>
				<?=$_data['Data']['keyword']?>

			</td>
		</tr>
		<tr>
			<th>열람기업수</th>
			<td><?=$_data['Data']['viewListCount']?></td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td><?=$_data['Data']['user_phone']?></td>
		</tr>
		<tr>
			<th>핸드폰</th>
			<td><?=$_data['Data']['user_hphone']?></td>
		</tr>
		<tr>
			<th>이메일</th>
			<td><?=$_data['Data']['user_email1']?></td>
		</tr>
<!-- 		<tr>
			<th>유료옵션</th>
			<td><?=$_data['사용중인옵션']?></td>
		</tr> -->
	</table>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; margin-bottom:20px" class="tb_st_btns">
	<tr>
		<td >
			<span style="letter-spacing:-1.5px; display:block" onClick="document.search_guzic_<?=$_data['doc_extraction_unique_number']?>_<?=$_data['Data']['number']?>_frm.submit()" class="mobile_del_btn font_16 noto400">맞춤채용정보</span>
		</td>
		<td >
			<span style="letter-spacing:-1.5px; " onClick="location.href='document.php?mode=modify&subMode=type1&number=<?=$_data['Data']['number']?>'" class="gray_btn2 font_16 noto400" >이력서수정</span>
		</td>
	</tr>
	<tr>
		<td >
			<span style="letter-spacing:-1.5px; " onClick="javascript:guzicdel('guzic_del.php?number=<?=$_data['Data']['number']?>')" class="gray_btn2 font_16 noto400" >이력서삭제</span>
		</td>
		<td >
			<span style="letter-spacing:-1.5px; " onClick="location.href='document.php?mode=uryo&number=<?=$_data['Data']['number']?>'" class="gray_btn2 font_16 noto400" >유료옵션신청</span>
		</td>
	</tr>
</table>


<? }
?>