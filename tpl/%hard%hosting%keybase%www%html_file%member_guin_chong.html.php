<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 16:22:12 */
function SkyTpl_Func_2629759922 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	.tab td{border:1px solid #dfdfdf; border-bottom:2px solid #<?=$_data['배경색']['서브색상']?> !important; font-weight:bold; color:#999999; background:#fafafa; font-size:16px; letter-spacing:-1.2px; text-align:center; font-family:'맑은 고딕'; font-weight:bold; cursor:pointer; height:50px}
	.tab .menu_on{background:#<?=$_data['배경색']['서브색상']?>; font-size:16px; letter-spacing:-1.2px; text-align:center; font-family:'맑은 고딕'; font-weight:bold; cursor:pointer;  height:50px;}
	.tab .menu_on a{color:#fff}

	.tab2 td{border:1px solid #dfdfdf; border-bottom:2px solid #<?=$_data['배경색']['서브페이지']?> !important; font-weight:bold}
	.tab2 .menu_off2{color:#999999; background:#fafafa; font-size:16px; letter-spacing:-1.2px; text-align:center; font-family:'맑은 고딕'; font-weight:bold; cursor:pointer; height:50px}
	.tab2 .menu_on2{background:#<?=$_data['배경색']['서브페이지']?>; font-size:16px; letter-spacing:-1.2px; text-align:center; font-family:'맑은 고딕'; font-weight:bold; cursor:pointer;  height:50px;}
	.tab2 .menu_on2 a{color:#fff}
</style>
<link rel="stylesheet" type="text/css" href="js/jRating/jRating.jquery.css" media="screen" />
<script type="text/javascript" src="js/jRating/jquery.js"></script>
<script type="text/javascript" src="js/jRating/jRating.jquery.js"></script>
<!-- 폼전송 iframe -->
<iframe width=0 height=0 name="j_blank" id="j_blank" frameborder="0" style="display:none;"></iframe>


<h2 class="font_malgun font_24" style="position:relative; color#333333; padding:15px 0;">
	<img src='happy_imgmaker.php?fsize=19&news_title=지원자 관리&outfont=NanumGothicExtraBold&fcolor=51,51,51&format=PNG&bgcolor=250,250,250' style="vertical-align:middle">
</h2>
<div style="border:2px solid #686868; background:#fafafa; padding:30px; margin-bottom:40px">
	<h3 style="position:relative; padding:15px 0 15px 40px; letter-spacing:-1.2px; font-weight:bold; border-bottom:1px solid #e0e0e0; background:url('./img/title_ico_000.png') 0 15px no-repeat" class="font_20 font_malgun">
		<a href='./guin_detail.php?num=<?=$_data['GUIN_INFO']['number']?>' style="font-weight:bold"><span style="letter-spacing:0">[<?=$_data['GUIN_INFO']['number']?>]</span> <?=$_data['GUIN_INFO']['guin_title']?></a>
		<span style="position:absolute; top:15px; right:0">
			<?=$_data['GUIN_INFO']['guin_end_text']?> <span style="color:#<?=$_data['배경색']['서브색상']?>; letter-spacing:0"><?=$_data['GUIN_INFO']['guin_end_date']?></span>
		</span>
	</h3>
	<div style="padding:10px 0; border-top:1px solid #fff">
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<td style="text-align:left; vertical-align:top">
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<th class="font_malgun" style="letter-spacing:-1px; color:#999999; width:72px; height:24px">담당업무</th>
							<td class="font_malgun" style="text-align:left; letter-spacing:-1px; color:#666">
								<?=$_data['GUIN_INFO']['guin_work_content']?>

							</td>
						</tr>
						<tr>
							<th class="font_malgun" style="vertical-align:top; letter-spacing:-1px; color:#999999; width:72px; height:24px">직종</th>
							<td class="font_malgun" style="letter-spacing:-1px; color:#666; padding:3px 0">
								<?=$_data['GUIN_INFO']['guin_job']?>

							</td>
						</tr>
						<tr>
							<th class="font_malgun" style="letter-spacing:-1px; color:#999999; width:72px; height:24px">급여</th>
							<td class="font_malgun" style="letter-spacing:-1px; color:#666; padding:3px 0">
								<?=$_data['GUIN_INFO']['guin_pay_icon']?> 급여 : <?=$_data['GUIN_INFO']['guin_pay']?>

							</td>
						</tr>
						<tr>
							<th class="font_malgun" style="letter-spacing:-1px; color:#999999; width:72px; height:24px">학력</th>
							<td class="font_malgun" style="letter-spacing:-1px; color:#666; padding:3px 0">
								<?=$_data['GUIN_INFO']['guin_edu']?>

							</td>
						</tr>
						<tr>
							<th class="font_malgun" style="letter-spacing:-1px; color:#999999; width:72px; height:24px">경력</th>
							<td class="font_malgun" style="letter-spacing:-1px; color:#666; padding:3px 0">
								<?=$_data['GUIN_INFO']['guin_career']?>

							</td>
						</tr>
					</table>
				</td>
				<td style="width:300px; vertical-align:top">
					
				</td>
			</tr>
		</table>
	</div>
</div>

<form name="guin_per_search" action="" method="get">
	<input type="hidden" name="guin_per_action" value="search">
	<input type="hidden" name="file" value="<?=$_data['_GET']['file']?>">
	<input type="hidden" name="file2" value="<?=$_data['_GET']['file2']?>">
	<input type="hidden" name="number" value="<?=$_data['_GET']['number']?>">
	<input type="hidden" name="myroom" value="<?=$_data['_GET']['myroom']?>">
	<input type="hidden" name="doc_ok" value="<?=$_data['_GET']['doc_ok']?>">
	<input type="hidden" name="read_ok" value="<?=$_data['_GET']['read_ok']?>">


	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed" class="tab">
		<tr>
			<td class="<?if($_GET[doc_ok] == '' && $_GET['read_ok'] == '')echo 'menu_on'?>">
				<a href='?file=<?=$_data['_GET']['file']?>&number=<?=$_data['_GET']['number']?>&myroom=<?=$_data['_GET']['myroom']?>' style="display:block; line-height:53px">전체지원자(<span id='cgp_all_cnt_val'>-</span>)</a>
			</td>
			<td class="<?if($_GET[doc_ok] == 'Y')echo 'menu_on'?>">
				<a href='?file=<?=$_data['_GET']['file']?>&number=<?=$_data['_GET']['number']?>&myroom=<?=$_data['_GET']['myroom']?>&doc_ok=Y' style="display:block; line-height:53px">예비합격(<span id='doc_ok_y_cnt_val'>-</span>)</a>
			</td>
			<td class="<?if($_GET[doc_ok] == 'N')echo 'menu_on'?>">
				<a href='?file=<?=$_data['_GET']['file']?>&number=<?=$_data['_GET']['number']?>&myroom=<?=$_data['_GET']['myroom']?>&doc_ok=N' style="display:block; line-height:53px">불합격(<span id='doc_ok_n_cnt_val'>-</span>)</a>
			</td>
			<td class="<?if($_GET['read_ok'] == 'N')echo 'menu_on'?>">
				<a href='?file=<?=$_data['_GET']['file']?>&number=<?=$_data['_GET']['number']?>&myroom=<?=$_data['_GET']['myroom']?>&read_ok=N' style="display:block; line-height:53px">미열람(<span id='read_ok_n_cnt_val'>-</span>)</a>
			</td>
		</tr>
	</table>
	<div style="text-align:right; padding:15px 0" class="input_style">
		<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop:plugins_time.js' id='gToday:datetime:agenda.js:gfPop:plugins_time.js' src='./js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>

		<input type="text" name="guin_per_start_date" id="guin_per_start_date" maxlength="10" value='<?=$_data['_GET']['guin_per_start_date']?>' style="width:130px; border-right:0 none" placeholder="기간선택" onfocus="this.placeholder = ''"onblur="this.placeholder = '기간선택'" ><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.guin_per_search.guin_per_start_date);return false;" HIDEFOCUS><img src="img/btn_clock.gif" style="vertical-align:middle;"></a>
		~
		<input type="text" name="guin_per_end_date" id="guin_per_end_date" maxlength="10" value='<?=$_data['_GET']['guin_per_end_date']?>' style="width:130px; border-right:0 none" placeholder="기간선택" onfocus="this.placeholder = ''"onblur="this.placeholder = '기간선택'"><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.guin_per_search.guin_per_end_date);return false;" HIDEFOCUS><img src="img/btn_clock.gif" style="vertical-align:middle;"></a>

		<input type="text" name="search_word" value="<?=$_data['_GET']['search_word']?>" style="border-right:0 none; width:300px; margin-left:5px" placeholder="검색어를 입력하세요." onfocus="this.placeholder = ''"onblur="this.placeholder = '검색어를 입력하세요'"><input type='submit' value="검색하기" class="font_13 font_malgun" style="background:#<?=$_data['배경색']['서브색상']?>; color:#fff; height:30px; line-height:30px; letter-spacing:-1.2px; text-align:center; padding:0 20px; cursor:pointer" >
	</div>
</form>


<div style="border-top:1px solid #dfdfdf">
	<?document_extraction_list('가로1개','세로5개','옵션1','옵션2','총지원자','옵션4','최근등록일순','글자짜름','누락0개','mypage_doc_rows_guin2.html','페이징사용') ?>

	<script>
		var cgp_all_cnt			= "<?=$_data['cgp_all_cnt']?>";	//전체지원자
		var doc_ok_y_cnt		= "<?=$_data['doc_ok_y_cnt']?>";	//예비합격
		var doc_ok_n_cnt		= "<?=$_data['doc_ok_n_cnt']?>";	//불합격
		var read_ok_n_cnt		= "<?=$_data['read_ok_n_cnt']?>";	//미열람

		if(cgp_all_cnt != '')$('#cgp_all_cnt_val').html(cgp_all_cnt);
		if(doc_ok_y_cnt != '')$('#doc_ok_y_cnt_val').html(doc_ok_y_cnt);
		if(doc_ok_n_cnt != '')$('#doc_ok_n_cnt_val').html(doc_ok_n_cnt);
		if(read_ok_n_cnt != '')$('#read_ok_n_cnt_val').html(read_ok_n_cnt);
	</script>
</div>
<div align="center" style="margin:20px 0 30px 0;"><?=$_data['페이징']?></div>


<? }
?>