<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 14:07:00 */
function SkyTpl_Func_2897822421 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript">
<!--
	function want_del(want_number,jiwon_type) {
		str = "입사제의 받은 내역을 삭제하시겠습니까?";
		if ( confirm( str ) )
		{
			document.location = "per_guin_want.php?mode=del&cNumber=" + want_number+'&jiwon_type='+jiwon_type;
		}
	}
	//-->

</script>

<script>
function date_value_input(i_day)
{
	var S_DATE		= new Date();
	S_DATE.setMonth(S_DATE.getMonth() - i_day);

	var s_yyyy		= S_DATE.getFullYear();
	var s_mm		= S_DATE.getMonth()+1;
	var s_dd		= S_DATE.getDate();
	s_mm			= (s_mm < 10)?"0"+s_mm:s_mm;
	s_dd			= (s_dd < 10)?"0"+s_dd:s_dd;
	$('#guin_per_start_date').val(s_yyyy+"-"+s_mm+"-"+s_dd);


	var E_DATE		= new Date();

	var e_yyyy		= E_DATE.getFullYear();
	var e_mm		= E_DATE.getMonth()+1;
	var e_dd		= E_DATE.getDate();
	e_mm			= (e_mm < 10)?"0"+e_mm:e_mm;
	e_dd			= (e_dd < 10)?"0"+e_dd:e_dd;
	$('#guin_per_end_date').val(e_yyyy+"-"+e_mm+"-"+e_dd);

}
</script>
<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	입사지원관리
	<span style="position:absolute; top:5px; right:0">
		<a href="html_file_per.php?file=my_guin_activities.html" title="취업활동 증명서">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">취업활동 증명서</span>
		</a>
		<a href="html_file_per.php?mode=per_guin_view" title="채용공고 열람관리">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">채용공고 열람관리</span>
		</a>
		<a href="per_no_view_list.php" title="이력서 열람불가 설정">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">이력서 열람불가 설정</span>
		</a>
		<a href="per_want_search.php?mode=setting_form" title="맞춤 채용공고 설정">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">맞춤 채용공고 설정</span>
		</a>
		<a href="per_want_search.php?mode=list" title="맞춤 채용공고">
			<span  style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">맞춤채용공고</span>
		</a>
	</span>
</div>

<?include_template('my_point_jangboo_per2.html') ?>


<h3 class="guin_d_tlt_st02">
	 <span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0;"></span>면접제의받은 채용공고
</h3>


<?job_type_list('세로1','가로10','job_type_rows_guin.html','누락0','페이징사용안함') ?>


<form name="guin_per_search" action="" method="get">
	<input type="hidden" name="guin_per_action" value="search">
	<input type="hidden" name="file" value="<?=$_data['_GET']['file']?>">
	<input type="hidden" name="file2" value="<?=$_data['_GET']['file2']?>">
	<input type="hidden" name="job_type_read" value="<?=$_data['_GET']['job_type_read']?>">
	<div style="padding:15px 0">
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<td class="h_form" style="text-align:left">
					<a class="h_btn_st2" onClick="date_value_input(1)">1개월</a>
					<a class="h_btn_st2" onClick="date_value_input(2)">2개월</a>
					<a class="h_btn_st2" onClick="date_value_input(3)">3개월</a>
					<input type="text" name="guin_per_start_date" id="guin_per_start_date" maxlength="10" value='<?=$_data['_GET']['guin_per_start_date']?>' style="width:120px;" placeholder="기간선택" onfocus="this.placeholder = ''"onblur="this.placeholder = '기간선택'"> <a class="h_btn_square uk-icon" uk-icon="icon:calendar; ratio:1" href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.guin_per_search.guin_per_start_date);return false;" HIDEFOCUS></a>
					~
					<input type="text" name="guin_per_end_date" id="guin_per_end_date" maxlength="10" value='<?=$_data['_GET']['guin_per_end_date']?>' style="width:120px;" placeholder="기간선택" onfocus="this.placeholder = ''"onblur="this.placeholder = '기간선택'"> <a class="h_btn_square uk-icon" uk-icon="icon:calendar; ratio:1" href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.guin_per_search.guin_per_end_date);return false;" HIDEFOCUS></a>
				</td>
				<td style="text-align:right" class="h_form">
					<input type="text" name="search_word" value="<?=$_data['_GET']['search_word']?>" style="width:335px;" placeholder="검색어를 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '검색어를 입력하세요.'">
					<button class="h_btn_st1 icon_m uk-icon search_color" uk-icon="icon:search; ratio:0.8">검색</button>
				</td>
			</tr>
		</table>
	</div>
</form>
<div style="border-top:1px solid #dfdfdf">
	<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

	<?guin_extraction('총20개','가로1개','제목길이48자','자동','자동','자동','자동','일반','면접요청','mypage_guin_want_list_row_per1.html') ?>

</div>
<!-- 페이지출력 -->
<div class="paging_mypage" style="text-align:center;"><?=$_data['페이징']?></div>
<!-- 페이지출력 -->
<? }
?>