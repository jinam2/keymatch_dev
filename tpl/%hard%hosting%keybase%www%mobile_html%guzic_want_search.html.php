<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 16:48:26 */
function SkyTpl_Func_2886411230 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<h3 class="sub_tlt_st01" style="padding-bottom:30px; border-bottom:1px solid #ddd; box-sizing:border-box;">	
	<span>맞춤인재정보</span>
</h3>
<div style="padding:0 10px">
	<div>
		<?newPaging_option('번호양쪽1개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

		<?document_extraction_list('가로1개','세로3개','옵션1','옵션2','맞춤구직정보','옵션4','최근등록일순','글자70글자짜름','누락0개','mypage_doc_rows_default.html','페이징사용') ?>

		<!-- 페이지번호 -->
	</div>
	<div style="text-align:center;"><?=$_data['페이징']?></div>
</div>
<div style="margin-top:40px;">
	<table style="width:100%; " cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
		<colgroup>
			<col style="width:30%">
			<col style="width:70%">
		</colgroup>
		<tr>
			<th>근무분야</th>
			<td>
				<span class="s_b"><?=$_data['WantSearchDoc']['job_type1_name']?></span>
				<span class="s_b" style="padding-top:5px"><?=$_data['WantSearchDoc']['job_type2_name']?></span>
			</td>
		</tr>
		<tr>
			<th>검색기간</th>
			<td>이력서 처음 등록일로부터 <br><strong style="color:#<?=$_data['배경색']['모바일_서브페이지2']?>"><?=$_data['WantSearchDoc']['diff_regday']?></strong>일 전의 이력서 검색</td>
		</tr>
		<tr>
			<th>근무형태</th>
			<td><?=$_data['WantSearchDoc']['grade_gtype']?></td>
		</tr>
		<tr>
			<th>경력</th>
			<td><?=$_data['WantSearchDoc']['career_read_message']?></td>
		</tr>
		<tr>
			<th>채용국적</th>
			<td><?=$_data['WantSearchDoc']['guzicnational']?></td>
		</tr>
		<tr>
			<th>나이</th>
			<td><?=$_data['WantSearchDoc']['guzic_age_message']?></td>
		</tr>
		<tr>
			<th>근무지역</th>
			<td><?=$_data['WantSearchDoc']['si_name']?><?=$_data['WantSearchDoc']['gu_name']?></td>
		</tr>
		<tr>
			<th>학력</th>
			<td><?=$_data['WantSearchDoc']['guziceducation']?></td>
		</tr>
		<tr>
			<th>희망급여</th>
			<td><?=$_data['WantSearchDoc']['grade_money_type']?> <?=$_data['WantSearchDoc']['grade_money']?></td>
		</tr>
		<tr>
			<th>성별</th>
			<td><?=$_data['WantSearchDoc']['gender_read']?></td>
		</tr>
	</table>
	<p style="text-align:center; letter-spacing:-1px; padding:20px 0">
		맞춤정보 설정은 <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>">PC버젼</span>에서 가능합니다.
	</p>
</div>
<? }
?>