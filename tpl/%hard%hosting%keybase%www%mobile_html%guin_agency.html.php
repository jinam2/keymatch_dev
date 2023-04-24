<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 11:48:07 */
function SkyTpl_Func_2265742446 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('역세권별 초빙정보') ?>

<script type="text/javascript">
	function search_bar_open(){
		$('.sch_form_default > a').text('- 상세검색');
		$(".sch_form_detail > ul > li:nth-child(n+2)").slideToggle(); 
		$(".sch_form_default > b").slideToggle();
	}
</script>
<style>
	.sub_guin_01_area .type:first-child .sub_guin_01{margin-left:0 !important}
	.sub_guin_01{margin-left:15px; border:1px solid #dfdfdf; width:388px; position:relative;}
	.sub_guin_01:hover{ border-left:1px solid #<?=$_data['배경색']['서브색상']?> !important; border:1px solid #<?=$_data['배경색']['서브색상']?>}
	.sub_guin_list .d_day{color:#<?=$_data['배경색']['서브색상']?>;}
	#underground_list_selectbox{display:inline-block}
	#underground_list_selectbox select{width:264px;}

	/* 역세권 자동완성 CSS */
	#autoSearchPartWrapUnder{
		position:absolute;
		background: transparent;
		text-align:left;
		width:100%;
		left:1px;
		top:-3px;
	}
	#autoSearchPartWrapUnder td{
		font-size:13px;
		font-family:'맑은 고딕';
		letter-spacing:-1px;
		padding-left:10px !important
	}

	#autoSearchPartUnder{
		border:1px solid #616161;
		border-top:none;
		display:none;
		background:#fff;
		/*height:150px;*/
		overflow:hidden;
		overflow-y:auto;
		left:0 !important;
		margin-right:99px;
	}

	.listInUnder{
		background-color:#f5f5f5;

	}

	.listOutUnder, .listInUnder{
		cursor:pointer;
	}

	#autopositionUnder{
		position:relative;
		margin-left:0px;
		z-index:1000;
	}
	/* 역세권 자동완성 CSS */

	#underground1_search, 
	#underground2_search{padding:8px 10px 10px; border:1px solid #ddd; position:relative; background:#fff url('../img/select_arrow.png') 95% 55% no-repeat; -webkit-appearance:none; -moz-appearance:none; appearance:none; border-radius:5px;}
	
</style>
<div class="sub_wrap">
	<h3 class="sub_tlt_st01">
		<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>">의료기관별 </b>
		<span>초빙정보</span>
	</h3>
	<div class="sch_default">
		<div class="hidden sch_form_detail">
			<ul>	
				<li>
					<div>
						<b>지하철</b>
						<div class="h_form">
							<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT>
							<SCRIPT language="javascript" src="./js/underground_search.js"></SCRIPT>
							<input type="hidden" name="underground1" value="<?=$_data['_GET']['underground1']?>">
							<input type="hidden" name="underground2" value="<?=$_data['_GET']['underground2']?>">
							<input type="hidden" name="underground_text" value="<?=$_data['_GET']['underground_text']?>">
							<script>make_underground_search('<?=$_data['_GET']['underground1']?>','<?=$_data['_GET']['underground2']?>')</script>
						</div>
					</div>
				</li>
				<li>
					<div>
						<b>지역별</b>
						<div class="h_form"><?=$_data['지역검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>직종별</b>
						<div class="h_form"><?=$_data['업종검색']?></div>
					</div>
				</li>				
				<li>
					<div>
						<b>나이제한</b>
						<div class="h_form"><?=$_data['연령검색시작']?><span><?=$_data['연령검색종료']?></span></div>
					</div>					
				</li>
				<li>
					<div>
						<b>초빙종류</b>
						<div class="h_form"><?=$_data['구인타입']?></div>
					</div>				
					<div>
						<b>직급</b>
						<div class="h_form"><?=$_data['직급선택']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>연봉</b>
						<div class="h_form"><?=$_data['연봉검색']?></div>
					</div>				
					<div>
						<b>경력</b>
						<div class="h_form"><?=$_data['경력검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>학력</b>
						<div class="h_form"><?=$_data['학력검색']?></div>
					</div>
				</li>				
			</ul>
		</div>
		<div class="sch_form_default">	
			<b>키워드</b>
			<p class="keyword_box">
				<input type="text" name="underground_search_text" id="underground_search_text" value="<?=$_data['_GET']['underground_text']?>" placeholder="검색어를 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '검색어를 입력하세요'" onKeyUp="go_search_guin(event)" onKeyDown="go_search_guin(event)" >
				<button class="search_color" onClick="underground_search();" style="background:#<?=$_data['배경색']['모바일_기본색상']?>;">검색하기</button>
			</p>	
			<a href="javascript:void(0);" onClick="search_bar_open()">+ 상세검색</a>
		</div>
		<!-- 검색시 사용 삭제하면 안됨 -->
		<div style="display:none;"><?=$_data['상세검색부분']?> </div>
		


</div>
	<ul class="guin_optionlist_wrap">
		<li>
			<h3 class="m_tlt_m">
				<strong>우대등록 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_woodae.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총2개','가로2개','제목길이100자','자동','자동','자동','자동','우대등록','전체','sub_rows_guin_woodae_01.html','최신등록순','누락0개','','','','자동') ?></div>
		</li>
		<li>		
			<h3 class="m_tlt_m">
				<strong>프리미엄 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_premium.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총2개','가로2개','제목길이200자','자동','자동','자동','자동','프리미엄','전체','sub_rows_guin_premium_01.html','최신등록순','누락0개') ?></div>		
		</li>
		<li>		
			<h3 class="m_tlt_m">
				<strong>스페셜 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
			</h3>
			<div class="m_list_03"><?guin_main_extraction('총2개','가로2개','제목길이200자','자동','자동','자동','자동','스페셜','전체','sub_rows_guin_special_01.html','최신등록순','누락0개') ?></div>		
		</li>
	</ul>
	<div class="sub_guin_list_wrap">
		<h3 class="m_tlt_m_01">
			<strong style="margin-bottom:20px; display:block;">전체 <!-- <span id="titlebar" style="color:#<?=$_data['배경색']['모바일_기본색상']?>"></span> --> 초빙정보 리스트  <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><span id="guin_counting" >로딩중</span> 건</span></strong>		
			<p class="h_form sub_list_select">
				<span><?=$_data['초빙정보정렬']?></span>
			</p>
		</h3>
		<div class="sub_guin_list">
			<div class="sub_guin_td">
				<?guin_extraction_ajax('총20개','가로1개','제목길이999자','자동','자동','자동','자동','일반','자동','sub_guin_list_rows_01.html','누락0개','사용함','','최근등록일순') ?>

			</div>			
		</div>
	</div>
</div>

<!-- 현재 선택 지하철노선도명 -->
<script>
document.getElementById('titlebar').innerHTML	= "<?=$_data['현재역이름']?>";
</script>
<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT>
<script>//make_underground2('<?=$_data['_GET']['underground1']?>','<?=$_data['현재역이름']?>')</script>

<? }
?>