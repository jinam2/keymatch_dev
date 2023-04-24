<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 20:43:44 */
function SkyTpl_Func_2424969095 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('우대등록 채용정보') ?>

<h3 class="sub_tlt_st01">
	<b style="color:#<?=$_data['배경색']['기본색상']?>">주요</b>
	<span> 초빙정보</span>
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
						<b>의료기관별</b>
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
						<b>진료과별</b>
						<div>
							<?=$_data['직급선택']?>

						</div>
					</div>
				</li>
				<li>
					<div>
						<b>고용형태</b>
						<div>
							<?=$_data['구인타입']?>

						</div>
					</div>
					<div>
						<b>급여조건</b>
						<div class="h_form">
<!------------------------ 새로추가:: 프로그램 ---------------------------->

			<p class="inline01">
				<label class="h-radio" for="salaryc01"><input type="radio" id="salaryc01" name="salaryc01" value="GROSS(세전)"> <span class="noto400 font_14">GROSS(세전)</span></label>
				<label class="h-radio" for="salaryc02"><input type="radio" id="asalaryc02" name="salaryc02" value="NET(세후)"> <span class="noto400 font_14">NET(세후)</span></label>
			</p>
			<p class="inline02">
			<select id="" name="" style="width:200px;">
					<option value="">구분</option>
					<option value="의사">면접 후 결정</option>
					<option value="연봉">연봉</option>
					<option value="월급">월급</option>
					<option value="일급">일급</option>
					<option value="건급">건급</option>
				</select>
				<input type="text" placeholder="0"  style="width:200px;">
				만원이상
			</p>
		</div>
</div>
<!-- //new_career_background_sec -->
<!------------------------ //새로추가:: 프로그램 ---------------------------->
					</li>
	</ul>
			<a href="javascript:void(0);" onClick="search_bar_open();" class="search_detail_close"><img src="img/close_ico.png" alt="" /></a>
			<a href="javascript:void(0);" class="search_detail_search_btn" onClick="document.a_f_guin.submit();">검색하기</a>
		</div>
	</form>
</div>



<div class="container_c">
	<div class="sub_tab_menu01">
		<ul>
			<li style="border-top:4px solid #<?=$_data['배경색']['기본색상']?>; box-sizing:border-box;"><a href="/html_file.php?file=guin_woodae.html" style="color:#<?=$_data['배경색']['기본색상']?>; font-weight:500;">우대등록 초빙정보</a></li>
			<li><a href="/html_file.php?file=guin_premium.html">프리미엄 초빙정보</a></li>
			<li><a href="/html_file.php?file=guin_special.html">스페셜 초빙정보</a></li>
<!-- 			<li><a href="/html_file.php?file=guin_speed.html">스피드 초빙정보</a></li>
			<li><a href="/html_file.php?file=guin_pick.html">추천 초빙정보</a></li> -->
		</ul>
	</div>
	<div>
		<h3 class="m_tlt">
			<strong>우대등록 초빙정보 리스트</strong>
			<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
			<p class="h_form sub_list_select"><span><?=$_data['채용정보정렬']?></span></p>
		</h3>
		<div style="padding:40px 0 40px 0" class="sub_wodae_list2 sub_wodae_ect">
			<style type="text/css">
				.sub_wodae_ect > table > tbody > tr > td {width:25%; text-align:left;}
				.sub_wodae_ect > table > tbody > tr > td > div.hire_listing_none{text-align:center;}
			</style>
			<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

			<?guin_extraction('총8개','가로4개','제목길이200자','자동','자동','자동','자동','우대등록','자동','sub_guin_wodae_list_rows.html','누락0개','사용함','','최근등록일순') ?>

		</div>
	</div>
</div>




<? }
?>