<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 09:45:03 */
function SkyTpl_Func_3590533357 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('헤드헌팅') ?>


<h3 class="sub_tlt_st01">
	<span style="color:#<?=$_data['배경색']['기본색상']?>">헤드헌팅 </span>
	<b>채용정보</b>	
</h3>
<div class="sub_search_box container_c" style="position:relative; margin-top:40px; margin-bottom:85px;">
	<form  method='get' action='html_file.php' name=a_f_guin style='margin:0' onSubmit="return false;">
		<input type=hidden name='file' value='<?=$_data['_GET']['file']?>'>
		<input type=hidden name='file2' value='<?=$_data['_GET']['file2']?>'>
		<div class="sch_form_default" style="width:49%;">			
			<p class="keyword_box">
				<input type="text" name="title_read" id="title_read" value="<?=$_data['title_read']?>" placeholder="검색어를 입력하세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '검색어를 입력하세요'" onKeyUp="go_search_guin(event)" onKeyDown="go_search_guin(event)" >
				<button class="search_color" onClick="document.a_f_guin.submit();" style="background:#<?=$_data['배경색']['기본색상']?>;">검색하기</button>
			</p>	
			<a href="javascript:void(0);" onClick="search_bar_open()">+ 상세검색</a>
		</div>
		<div class="hidden sch_form_detail" style="background:#f5f5f5;">
			<ul>
				<li>
					<div>
						<b>직종별</b>
						<div style="font-size:0;" class="insert_bracket">
							<?=$_data['확장업종검색']?>

						</div>
					</div>
					<div>
						<b>지하철</b>
						<div>
							<SCRIPT language="javascript" src="./js/underground.js"></SCRIPT>
							<SCRIPT language="javascript" src="./js/underground_search.js"></SCRIPT>
							<input type="hidden" name="underground1" value="<?=$_data['_GET']['underground1']?>">
							<input type="hidden" name="underground2" value="<?=$_data['_GET']['underground2']?>">
							<input type="hidden" name="underground_text" value="<?=$_data['_GET']['underground_text']?>">
							<div style="display:none">
								<script>make_underground_search('<?=$_data['_GET']['underground1']?>','<?=$_data['_GET']['underground2']?>')</script>
							</div>
							<div>
								<input type="text" name="underground_search_text" id="underground_search_text" value="<?=$_data['_GET']['underground_text']?>" placeholder="원하시는 역세권 정보를 입력하세요." onKeyUp="startMethodUnder(event.keyCode);" onKeyDown="moveLayerUnder(event.keyCode);" onMouseUp="startMethodUnder(event.keyCode);" onFocus="this.value=''" onBlur="returnValueUnder()" autocomplete="off">
							</div>
							<div id="autopositionUnder">
								<div id="autoSearchPartWrapUnder">
									<div id="autoSearchPartUnder"></div>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div>
						<b>지역별</b>
						<div style="font-size:0;" class="insert_bracket">
							<?=$_data['확장지역검색']?>

						</div>
					</div>
					<div>
						<b>직급</b>
						<div>
							<?=$_data['직급선택']?>

						</div>
					</div>
				</li>
				<li>
					<div>
						<b>채용종류</b>
						<div>
							<?=$_data['구인타입']?>

						</div>
					</div>
					<div>
						<b>연봉</b>
						<div>
							<?=$_data['연봉검색']?>

						</div>
					</div>
				</li>
				<li>
					<div>
						<b>경력</b>
						<div>
							<?=$_data['경력검색']?>

						</div>
					</div>
					<div style="padding-right:27px; border-right:1px solid #ddd;">
						<b>학력</b>
						<div>
							<?=$_data['학력검색']?>

						</div>
					</div>
				</li>
				<li>
					<div>
						<b>나이제한</b>
						<div><?=$_data['연령검색시작']?><span class="insert_wave"><?=$_data['연령검색종료']?></span></div>
					</div>					
				</li>
			</ul>
			<a href="javascript:void(0);" onClick="search_bar_open();" class="search_detail_close"><img src="img/close_ico2.png" alt="" /></a>	
			<a href="javascript:void(0);" class="search_detail_search_btn"  onClick="document.a_f_guin.submit();">검색하기</a>	
		</div>
	</form>
</div>
<div class="behind_bg">
	<ul class="guin_optionlist_wrap container_c">
		<li>
			<h3 class="m_tlt">
				<strong>우대등록 채용정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_woodae.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총12개','가로4개','제목길이100자','자동','자동','자동','자동','우대등록','자동','sub_rows_guin_woodae_01.html','랜덤추출','누락0개','','','헤드헌팅') ?></div>
		</li>
		<li>		
			<h3 class="m_tlt">
				<strong>프리미엄 채용정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_premium.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_01"><?guin_main_extraction('총4개','가로4개','제목길이200자','자동','자동','자동','자동','프리미엄','자동','sub_rows_guin_premium_01.html','랜덤추출','누락0개','','','헤드헌팅') ?></div>		
		</li>
		<li>		
			<h3 class="m_tlt">
				<strong>스페셜 채용정보</strong>
				<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
				<a href="html_file.php?file=guin_premium.html" class="text_hidden more_btn"><b>더보기</b></a>
			</h3>
			<div class="m_list_03" style="width:1212px;"><?guin_main_extraction('총6개','가로3개','제목길이200자','자동','자동','자동','자동','스페셜','자동','sub_rows_guin_special_01.html','랜덤추출','누락0개','','','헤드헌팅') ?></div>		
		</li>
	</ul>
</div>

<div class="container_c">
	<div>
		<h3 class="m_tlt">
			<strong>전체 채용정보</strong>
			<p class="h_form sub_list_select"><span><?=$_data['채용정보정렬']?></span> <span><?=$_data['채용정보마감일정렬']?></span></p>
		</h3>
		<div class="sub_guin_list">
			<ul class="sub_guin_th">
				<li>모집내용</li>
				<li>근무조건</li>
				<li>지원자격</li>
				<li>마감일</li>
			</ul>
			<div class="sub_guin_td">
				<?guin_extraction_ajax('총20개','가로1개','제목길이999자','자동','자동','자동','자동','일반','자동','sub_guin_list_rows_01.html','누락0개','사용함','','최근등록일순','','','','헤드헌팅') ?>

			</div>			
		</div>
	</div>
</div>




<? }
?>