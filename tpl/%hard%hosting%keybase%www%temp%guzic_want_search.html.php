<? /* Created by SkyTemplate v1.1.0 on 2023/03/28 14:13:56 */
function SkyTpl_Func_1657743133 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	인재정보관리
	<span style="position:absolute; top:0; right:0">		
		<a href="html_file.php?file=today_view_resume.html&file2=happy_member_default_mypage_com.html" title="오늘 본 인재정보">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">오늘 본 인재정보</span>
		</a>
		<a href="html_file.php?file=com_payendper.html&file2=happy_member_default_mypage_com.html" title="이력서 열람관리">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">이력서 열람관리</span>
		</a>
		<a href="member_guin.php?type=scrap" title="채용공고별 스크랩">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; box-sizing:border-box; background:#fff; padding:3px 15px; border-radius:15px;">채용공고별 스크랩</span>			
		</a>
		<a href="com_want_search.php?mode=setting_form" title="맞춤인재설정">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#666; padding:3px 15px; border-radius:15px;">맞춤인재설정</span>
		</a>
		<a href="com_want_search.php?mode=list" title="맞춤인재정보">			
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['서브색상']?>; padding:3px 15px; border-radius:15px;">맞춤인재정보</span>
		</a>
	</span>
</div>

<?include_template('my_point_jangboo_com.html') ?>


<div style="border:2px solid #666666; margin-top:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td class="font_16 noto500" style="padding-left:20px; background:#f8f8f8; color:#333; letter-spacing:-1px; height:46px; border-bottom:1px solid #dfdfdf;">
				현재 맞춤인재설정
			</td>
			<td  class="font_16 noto500" style="padding-right:20px; background:#f8f8f8;  letter-spacing:-1px; height:46px; border-bottom:1px solid #dfdfdf; text-align:right;">
				<a href="com_want_search.php?mode=setting_form" style="color:#<?=$_data['배경색']['기타페이지2']?>;">설정하기</a>
			</td>
		</tr>
		<tr>
			<td style="padding:20px" colspan="2">
				<table cellspacing="0" cellpadding="0" style="width:100%" class="my_tablecell">
					<tr>
						<th class="title">분야</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchDoc']['job_type1_name']?> <?=$_data['WantSearchDoc']['job_type2_name']?>

						</td>
						<th class="title">급여</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchDoc']['grade_money_type']?> <?=$_data['WantSearchDoc']['grade_money']?>

						</td>
					</tr>
					<tr>
						<th class="title">지역</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchDoc']['si_name']?> <?=$_data['WantSearchDoc']['gu_name']?>

						</td>
						<th class="title">성별</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchDoc']['gender_read']?>

						</td>
					</tr>
					<tr>
						<th class="title">근무형태</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchDoc']['grade_gtype']?>

						</td>
						<th class="title">연령</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchDoc']['guzic_age_message']?>

						</td>
					</tr>
					<tr>
						<th class="title">학력</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchDoc']['guziceducation']?>

						</td>
						<th class="title">검색기간</th>
						<td class="sub h_form sell_140 noto400 font_15">
							등록일로 부터 <?=$_data['WantSearchDoc']['diff_regday']?> 일 전의 이력서만 검색
						</td>
					</tr>
					<tr>
						<th class="title">경력</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchDoc']['career_read_message']?>

						</td>
						<th class="title"></th>
						<td class="sub h_form sell_140"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<h3 class="guin_d_tlt_st02" style="position:relative;">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>맞춤 인재정보
	 <p style="position:absolute; text-align:right; right:0; top:45px; font-size:14px; font-weight:400;">맞춤인재설정의 조건에 부합하는 인재정보입니다.</p>
</h3>

<div style="border-top:1px solid #ddd;">
	<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

	<?document_extraction_list('가로1개','세로5개','옵션1','옵션2','맞춤구직정보','옵션4','최근등록일순','글자24글자짜름','누락0개','mypage_doc_rows_default.html','페이징사용') ?>

</div>
<div align="center" class="paging_mypage"><?=$_data['페이징']?></div>

<? }
?>