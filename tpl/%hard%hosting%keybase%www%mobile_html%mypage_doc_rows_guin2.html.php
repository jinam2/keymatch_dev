<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 16:30:51 */
function SkyTpl_Func_3929643917 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<div style=" background:#fff; position:relative; overflow:hidden; padding:20px 0 15px 0; " onclick="location.href='./document_view.php?file=doc_view_main2.html&number=<?=$_data['Data']['number']?>'">
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td style="width:110px; vertical-align:top">
				<img src="<?=$_data['작은이미지']?>" style="width:110px; height:110px; border-radius:100%">
			</td>
			<td style="padding:0 10px 10px 15px; line-height:24px; vertical-align:top">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td class="font_16 font_malgun" style="letter-spacing:-1px">
							<a href="document_view.php?number=<?=$_data['Data']['number']?><?=$_data['searchMethod2']?>" style="color:#333333;"><strong><?=$_data['Data']['user_name_cut']?></strong></a> <span style="color:#1b1b1b; font-weight:bold">(<?=$_data['Data']['user_prefix']?>,<?=$_data['Data']['age']?>)</span>
						</td>
					</tr>
					<tr>
						<td style="padding:10px 0">
							<div style="overflow:hidden; letter-spacing:-1px; line-height:140%" class="font_malgun font_16 ellipsis_line2">
								<?=$_data['Data']['title']?>

							</div>
						</td>
					</tr>
					<tr>
						<td class="font_malgun font_14" style="color:#999; letter-spacing:-1px; padding-bottom:10px">
							<span style="color:#<?=$_data['배경색']['모바일_기타페이지2']?>"><?=$_data['Data']['grade_money_icon']?> <?=$_data['Data']['grade_money']?></span>
						</td>
					</tr>
					<tr>
						<td class="font_malgun font_14" style="color:#999; letter-spacing:-1px; font-weight:bold; padding-bottom:10px; height:17px; line-height:120%">
							<span style="color:#484848" class="ellipsis_line1">
								<?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?> | <?=$_data['Data']['grade_lastgrade']?> | <?=$_data['Data']['job_where']?>

							</span>
						</td>
					</tr>
					<tr>
						<td class="font_malgun font_14" style="color:#999; letter-spacing:-1px; font-weight:bold">
							<span style="color:#484848">
								지원 신청일 : <span style="letter-spacing:0; color:#<?=$_data['배경색']['모바일_서브색상']?>"><?=$_data['Data']['bregdate']?></span>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<div style="padding-bottom:20px; border-bottom:2px solid #E8E8E8">
	<table style="width:100%; border-top:4px solid #000; " cellspacing="0" cellpadding="0" border="0" class="detail_chart_02">
		<colgroup>
			<col style="width:30%">
			<col style="width:70%">
		</colgroup>
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
	</table>
	<table cellspacing="0" cellpadding="0" style="width:100%; margin-top:20px">
		<tr>
			<td style="letter-spacing:-1.5px" onClick="location.href='./document_view.php?number=<?=$_data['Data']['number']?>&read=<?=$_data['Data']['read']?><?=$_data['searchMethod2']?>'" class="gray_btn font_20 font_malgun">
				자세히보기
			</td>
		</tr>
	</table>
</div>


<? }
?>