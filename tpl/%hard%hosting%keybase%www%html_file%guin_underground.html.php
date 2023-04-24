<? /* Created by SkyTemplate v1.1.0 on 2023/04/18 13:28:04 */
function SkyTpl_Func_4051162208 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('역세권별 초빙정보') ?>

<style>
	.sub_guin_01_area .type:first-child .sub_guin_01{margin-left:0 !important}
	.sub_guin_01{margin-left:15px; border:1px solid #c5c5c5; width:388px; position:relative;}
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

<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT>
<SCRIPT language="javascript" src="./js/underground_search.js"></SCRIPT>
<style>
.sch_form_detail .sch_form_ect > span{display:none;}
</style>
<h3 class="sub_tlt_st01">
	<b style="color:#<?=$_data['배경색']['기본색상']?>">의료기관별</b>
	<span> 초빙정보</span>
</h3>
<div class="sub_search_box container_c" style="position:relative; margin-top:40px; margin-bottom:85px;">
		<div class="sch_form_default">	
			<script>make_underground_search('<?=$_data['_GET']['underground1']?>','<?=$_data['_GET']['underground2']?>')</script>			
			<p class="keyword_box">
				<input type="text" name="underground_search_text" id="underground_search_text" value="<?=$_data['_GET']['underground_text']?>" placeholder="검색어를 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '검색어를 입력하세요'" onKeyUp="go_search_guin(event)" onKeyDown="go_search_guin(event)" >
				<button class="search_color" onclick="underground_search();" style="background:#<?=$_data['배경색']['기본색상']?>;">검색하기</button>
			</p>	
			<a href="javascript:void(0);" onClick="search_bar_open()">+ 상세검색</a>
		</div>
		<div style="display:none;"><?=$_data['상세검색부분']?></div>
		<div class="hidden sch_form_detail" style="background:#f5f5f5;">
			<ul>
				<li>
					<div>
						<b>직종별</b>
						<div style="font-size:0;" class="sch_form_ect"><?=$_data['확장업종검색']?></div>
					</div>
					<div>
						<b>초빙종류</b>
						<div><?=$_data['구인타입']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>지역별</b>
						<div class="insert_bracket" style="font-size:0;"><?=$_data['확장지역검색']?></div>
					</div>
					<div>
						<b>직급</b>
						<div><?=$_data['직급선택']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>연봉</b>
						<div><?=$_data['연봉검색']?></div>
					</div>
					<div style="padding-right:0; border-right:none;">
						<b>경력</b>
						<div><?=$_data['경력검색']?></div>
					</div>
					<div>
						<b>학력</b>
						<div><?=$_data['학력검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>나이제한</b>
						<div><?=$_data['연령검색시작']?><span class="insert_wave"><?=$_data['연령검색종료']?></span></div>
					</div>
				</li>
			</ul>
			<a href="javascript:void(0);" class="search_detail_close" onClick="search_bar_open();"><img src="img/close_ico.png" alt="" /></a>	
			<a href="javascript:void(0);" class="search_detail_search_btn" onClick="underground_search();">검색하기</a>	
		</div>
</div>
<div class="behind_bg">
	<ul class="guin_optionlist_wrap container_c">
		<li>
			<h3 class="m_tlt">
				<strong>우대등록 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_woodae.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총12개','가로4개','제목길이100자','자동','자동','자동','자동','우대등록','자동','sub_rows_guin_woodae_01.html','최신등록순','누락0개') ?></div>
		</li>
		<li>		
			<h3 class="m_tlt">
				<strong>프리미엄 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_premium.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총12개','가로4개','제목길이200자','자동','자동','자동','자동','프리미엄','자동','sub_rows_guin_premium_01.html','최신등록순','누락0개') ?></div>		
		</li>
		<li>		
			<h3 class="m_tlt">
				<strong>스페셜 초빙정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_premium.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_03" style="width:1212px;"><?guin_main_extraction('총9개','가로3개','제목길이200자','자동','자동','자동','자동','스페셜','자동','sub_rows_guin_special_01.html','최신등록순','누락0개') ?></div>		
		</li>
	</ul>
</div>
<div class="container_c">
	<h3 class="m_tlt">
		<strong>전체 <!-- <span id="titlebar" style="color:#<?=$_data['배경색']['기본색상']?>;" ></span>  -->초빙정보</strong>
		<p class="h_form sub_list_select"><span><?=$_data['채용정보정렬']?></span><!--  <span><?=$_data['초빙정보마감일정렬']?></span> --></p>
	</h3>
	<div class="sub_guin_list">
		<ul class="sub_guin_th">
			<li>초빙내용</li>
			<li>근무지역</li>
			<li>초빙유형</li>
			<li>마감일</li>
		</ul>
		<div class="sub_guin_td">
			<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

			<?guin_extraction('총20개','가로1개','제목길이999자','자동','자동','자동','자동','일반','자동','sub_guin_list_rows_01.html','누락0개','사용함') ?>

		</div>			
	</div>
</div>

<script>
document.getElementById('titlebar').innerHTML	= "<?=$_data['현재역이름']?>";
</script>

<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT>
<script>//make_underground2('<?=$_data['_GET']['underground1']?>','<?=$_data['현재역이름']?>')</script>

<? }
?>