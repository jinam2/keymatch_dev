<? /* Created by SkyTemplate v1.1.0 on 2023/03/31 09:26:53 */
function SkyTpl_Func_829748885 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('<a href=member_info.php>마이페이지</a> > 맞춤채용공고') ?>

<script language="JavaScript">
<!--
	function want_del(want_number) {
		str = "입사제의 한 이력서를 삭제하시겠습니까?";
		if ( confirm( str ) )
		{
			document.location = "per_guin_want.php?mode=del&cNumber=" + want_number;
		}
	}
	//-->

</script>
<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	입사지원관리
	
</div>

<?include_template('my_point_jangboo_per2.html') ?>


<div style="border:2px solid #666666; margin-top:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td class="font_16 noto500" style="padding-left:20px; background:#f8f8f8; color:#333; letter-spacing:-1px; height:46px; border-bottom:1px solid #dfdfdf; font-weight:bold">
				현재 맞춤채용공고 설정
			</td>
			<td  class="font_16 noto500" style="padding-right:20px; background:#f8f8f8;  letter-spacing:-1px; height:46px; border-bottom:1px solid #dfdfdf; text-align:right; font-weight:bold">
				<a href="per_want_search.php?mode=setting_form" style="color:#<?=$_data['배경색']['기타페이지']?>;">설정하기</a>
			</td>
		</tr>
		<tr>
			<td style="padding:20px" colspan="2">
				<table cellspacing="0" cellpadding="0" style="width:100%" class="my_tablecell">
					<tr>
						<th class="title">진료과</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchGuin']['job_type1_name']?> <?=$_data['WantSearchGuin']['job_type2_name']?> <?=$_data['WantSearchGuin']['job_type3_name']?>

						</td>
						<th class="title">지역</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchGuin']['si_name']?> <?=$_data['WantSearchGuin']['gu_name']?>

						</td>
					</tr>
					<tr>
						<th class="title">근무형태</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchGuin']['grade_gtype']?>

						</td>
						<th class="title">유형</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchGuin']['guziceducation']?>

						</td>
						</tr>
					<tr>
						<th class="title">의료기관</th>
						<td class="sub h_form sell_140 noto400 font_15">
							<?=$_data['WantSearchGuin']['career_read_message']?>

						</td>
						<th class="title"></th>
						<td class="sub h_form sell_140 noto400 font_15">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>맞춤 채용공고
</h3>

<div style="border-top:1px solid #ddd;">
	<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

	<?guin_extraction('총10개','가로1개','제목길이999자','자동','자동','자동','자동','일반','자동','guin_want_search_rows.html','누락0개','페이징사용함','맞춤구인정보') ?>

</div>
<!-- 페이지출력 -->
<div class="paging_mypage"><?=$_data['페이징']?></div>
<!-- 페이지출력 -->
<? }
?>