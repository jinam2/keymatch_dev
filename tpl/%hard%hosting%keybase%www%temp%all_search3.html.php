<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 02:07:00 */
function SkyTpl_Func_1627051938 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 페이지내 rows디자인 색생 변경을 위한 css입니다 -->
<style type="text/css">
	.allsearch_wodae_01 .wodae_in:hover .wdisplay{display:block; left:0; top:0; right:0; bottom:0; position:absolute; border:2px solid #<?=$_data['배경색']['서브색상']?>; overflow:hidden; z-index:10}
	.allsearch_wodae_01 .wodae_in .d_day{color:#<?=$_data['배경색']['서브색상']?>;}
	.allsearch_spe_guin_01{margin-left:10px; margin-top:10px; border-left:2px solid #<?=$_data['배경색']['서브색상']?> !important; border:1px solid #dfdfdf}
	.allsearch_spe_guin_01:hover{ border-left:2px solid #<?=$_data['배경색']['서브색상']?> !important; border:1px solid #<?=$_data['배경색']['서브색상']?>}
	.allsearch_spe_guin_01 .d_day{color:#<?=$_data['배경색']['서브색상']?>;}
	.allsearch_guin_list .d_day{color:#<?=$_data['배경색']['서브색상']?>;}

	.search_tab{display:block; font-size:18px; text-align:center; padding:12px 20px; letter-spacing:-1px; color:#666; border-bottom:3px solid transparent; box-sizing:border-box;}
	.search_tab.on{border-bottom:3px solid #<?=$_data['배경색']['메인페이지']?>; color:#333;}
</style>


<script>
var all_search_result	= '';		// 검색결과 없음 체크용 변수
</script>

<div style="margin-top:10px; border-bottom:1px solid #dcdfe5;" title="현재 사이트에 등록된 모든 정보의 통합검색결과 입니다.
클릭하시면 본문 내용을 보실 수 있습니다.">
	<img src="img/sub_banner_allsearch.jpg" alt="통합검색결과">
</div>

<div class="scrollMoveBox3">
	<div class="Movebox_hidden" style="display:none; border-bottom:1px solid #f3f5f9; background:#fcfcfc">
		<div style="width:1200px; margin:0 auto; padding:15px 0; background:#fcfcfc; text-align:left">
			<a href="./"><img src="<?=$_data['main_logo']?>" title="<?=$_data['site_name']?>"></a>
		</div>
	</div>
	<div class="scrollMoveBox3_inner">
		<div style="position:relative; background:url('./img/all_sch_bgline.gif') 0 0 repeat-x" >
			<table cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td>
							<a href="all_search.php?all_keyword=<?=$_data['_GET']['all_keyword']?>&file=all_search.html" class="search_tab">
								전체검색
							</a>
						</td>
						<td>
							<a href="all_search.php?all_keyword=<?=$_data['_GET']['all_keyword']?>&file=all_search2.html" class="search_tab">
								구인/구직검색
							</a>
						</td>
						<td >
							<a href="all_search.php?all_keyword=<?=$_data['_GET']['all_keyword']?>&file=all_search3.html" class="search_tab on">
								게시판검색
							</a>
						</td>
						<td >
							<a href="all_search.php?all_keyword=<?=$_data['_GET']['all_keyword']?>&file=all_search4.html" class="search_tab">
								네이버검색
							</a>
						</td>
					</tr>
				</tbody>						
			</table>
			<div style="position:absolute; top:12px; right:0px">
				<?include_template('search_part2.html') ?>

			</div>
		</div>
	</div>
</div>

<div style="width:940px; float:left; padding-top:30px">
	<div class="allsearch_wodae_01"><?search_keyword_result('제목999글자','가로3개','세로3개','all_search_guin_pay_woodae.html','all_search_guin_pay_rows.html','구인','우대등록') ?></div>
	<div class="allsearch_pre_guin_area_01" style="margin-top:40px;"><?search_keyword_result('제목999글자','가로3개','세로3개','all_search_guin_pay_premium.html','all_search_guin_pay2_rows.html','구인','프리미엄') ?></div>
	<div class="allsearch_spe_guin_area_01" style="margin-top:40px;"><?search_keyword_result('제목999글자','가로2개','세로4개','all_search_guin_pay_special.html','all_search_guin_pay3_rows.html','구인','스페셜') ?></div>
	<div class="allsearch_guzic_area_01" style="margin-top:40px;"><?search_keyword_result('제목45글자','가로1개','세로4개','all_search_guzic_pay_power.html','all_search_guzic_pay_rows.html','구직','파워') ?></div>
	<div class="allsearch_guzic_area_02" style="margin-top:40px;"><?search_keyword_result('제목45글자','가로2개','세로3개','all_search_guzic_pay_special.html','all_search_guzic_pay2_rows.html','구직','스페셜') ?></div>
	<div class="allsearch_guzic_area_03" style="margin-top:40px;"><?search_keyword_result('제목30글자','가로2개','세로4개','all_search_guzic_pay_focus.html','all_search_guzic_pay3_rows.html','구직','포커스') ?></div>

	<div style="margin:40px 0 0 0"><?echo happy_banner('PC통합검색_01','배너제목','랜덤') ?></div>

	<div style="margin-top:40px;"><?search_keyword_result('제목42글자','가로2개','세로5개','all_search_bbs_default.html','all_search_board_normal_rows.html','잡(JOB)뉴스') ?></div>
	<div class="all_search_list" style="margin-top:40px;"><?search_keyword_result('제목999글자','가로3개','세로1개','all_search_bbs_default.html','all_search_bbs_photo_rows.html','포토갤러리') ?></div>
	<div style="margin-top:40px;"><?search_keyword_result('제목999글자','가로1개','세로3개','all_search_bbs_default2.html','search_board_normal_rows2.html','구인구직 가이드') ?></div>
	<div style="margin-top:40px;"><?search_keyword_result('제목999글자','가로1개','세로3개','all_search_bbs_default.html','all_search_board_photo_rows.html','인재인터뷰') ?></div>
	<div style="margin-top:40px;"><?search_keyword_result('제목42글자','가로2개','세로5개','all_search_bbs_default.html','all_search_board_normal_rows.html','행사/이벤트') ?></div>
</div>

<div style="width:230px; float:right; margin-top:30px;">
	<?include_template('aside_normal.html') ?>

</div>
<div style="clear:both;"></div>

<script>
	if ( all_search_result == '' )
	{
		if ( "<?=$_data['keyword_save_all']?>" == "Y" )
		{
			var keyword_ajax	= new GLM.AJAX();
			keyword_ajax.callPage('keyword_input.php?keyword=<?=$_data['search_word']?>',keyword_input_return);
		}
	}
	else
	{
		var keyword_ajax	= new GLM.AJAX();
		keyword_ajax.callPage('keyword_input.php?keyword=<?=$_data['search_word']?>',keyword_input_return);
	}

	function keyword_input_return(response)
	{
		//alert(response);
		return ;
	}
</script>

<? }
?>