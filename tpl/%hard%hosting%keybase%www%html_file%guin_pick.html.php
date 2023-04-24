<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 16:20:58 */
function SkyTpl_Func_2490034839 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<?call_now_nevi('추천 채용정보') ?>

<h3 class="sub_tlt_st01">
	<b style="color:#<?=$_data['배경색']['기본색상']?>">주요</b>
	<span> 채용정보</span>
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
						<div style="font-size:0;" class="insert_bracket"><?=$_data['확장업종검색']?></div>
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
						<div style="font-size:0;" class="insert_bracket"><?=$_data['확장지역검색']?></div>
					</div>
					<div>
						<b>직급</b>
						<div><?=$_data['직급선택']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>채용종류</b>
						<div><?=$_data['구인타입']?></div>
					</div>
					<div>
						<b>연봉</b>
						<div><?=$_data['연봉검색']?></div>
					</div>
				</li>
				<li>
					<div>
						<b>경력</b>
						<div><?=$_data['경력검색']?></div>
					</div>
					<div style="padding-right:27px; border-right:1px solid #ddd;">
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
			<a href="javascript:void(0);" onClick="search_bar_open();" class="search_detail_close"><img src="img/close_ico.png" alt="" /></a>
			<a href="javascript:void(0);" class="search_detail_search_btn" onClick="document.a_f_guin.submit();">검색하기</a>
		</div>
	</form>
</div>
<div class="container_c">
	<div class="sub_tab_menu01">
		<ul>
			<li><a href="/html_file.php?file=guin_woodae.html">우대등록 채용정보</a></li>
			<li><a href="/html_file.php?file=guin_premium.html">프리미엄 채용정보</a></li>
			<li><a href="/html_file.php?file=guin_special.html">스페셜 채용정보</a></li>
			<li><a href="/html_file.php?file=guin_speed.html">스피드 채용정보</a></li>
			<li style="border-top:4px solid #<?=$_data['배경색']['기본색상']?>; box-sizing:border-box;"><a href="/html_file.php?file=guin_pick.html" style="color:#<?=$_data['배경색']['기본색상']?>; font-weight:500;">추천 채용정보</a></li>
		</ul>
	</div>
	<div>
		<h3 class="m_tlt">
			<strong>추천 채용정보 리스트</strong>
			<a href="member_option_pay.php?mode=pay" class="ad_btn"><span>?</span></a>
			<p class="h_form sub_list_select"><span><?=$_data['채용정보정렬']?></span></p>
		</h3>
		<div style="padding:20px 0 40px 0" class="sub_pick_list2">
			<?newPaging_option('번호양쪽9개노출','구간이동버튼','이전다음버튼','<<','이전','다음','>>') ?>

			<?guin_extraction('총10개','가로1개','제목길이200자','자동','자동','자동','자동','추천','자동','sub_guin_pick_list_rows.html','누락0개','사용함','','최근등록일순') ?>

		</div>
	</div>
</div>


<? }
?>