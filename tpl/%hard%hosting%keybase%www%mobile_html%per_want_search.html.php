<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 15:20:04 */
function SkyTpl_Func_260919845 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
			<script type="text/javascript">
			<!--
				var request;
				function createXMLHttpRequest()
				{
					if (window.XMLHttpRequest) {
						request = new XMLHttpRequest();
					} else {
						request = new ActiveXObject("Microsoft.XMLHTTP");
					}
				}

				function startRequest(sel,target,size)
				{
					var trigger = sel.options[sel.selectedIndex].value;
					var form = sel.form.name;
					createXMLHttpRequest();
					request.open("GET", "sub_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
					request.onreadystatechange = handleStateChange;
					request.send(null);
				}

				function startRequest2(sel,target,size)
				{
					var trigger = sel.options[sel.selectedIndex].value;
					var form = sel.form.name;
					createXMLHttpRequest();
					request.open("GET", "sub_type_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
					request.onreadystatechange = handleStateChange;
					request.send(null);
				}

				function handleStateChange()
				{
					if (request.readyState == 4) {
						if (request.status == 200) {
						var response = request.responseText.split("---cut---");
						eval(response[0]+ '.innerHTML=response[1]');
						window.status="완료"
						}
					}
					if (request.readyState == 1)  {
						window.status="로딩중....."
					}
				}

				function searchbox()
				{
					for(i=1;i<=2;i++){
						if(document.getElementById(i).style.display == 'none'){
							document.getElementById(i).style.display='';
						}else{
							document.getElementById(i).style.display='none';
						}
					}
				}

				function no_change_pay()
				{
					var obj	= document.getElementById('grade_money_type')

					if ( obj.selectedIndex == 0 )
					{
						document.getElementById('grade_money').disabled = true;
					}
					else
						document.getElementById('grade_money').disabled = false;
				}
			//-->
			</script>



			<!-- 현재위치 -->
			<hr class="hide">
			<h3 class="hide">현재위치</h3>
			<div id="now_location" title="현재위치" style="border-top:1px solid #2F9E3F;">
				<ul>
					<?=$_data['현재위치']?>

					<li class="btn_toggle_search"><a href="javascript:toggleTraySearchViewHide2('on');"><img src="./img/btn_toggle_search_off.png" alt="상세검색토글버튼" title="상세검색토글버튼" width="50" height="18" id="btn_tray_toggle"></a></li>
				</ul>
			</div>


			<!-- 상세검색 (채용정보) start -->
			<!-- temp/search_form_advance.html -->
			<hr class="hide">
			<h3 class="hide">상세검색</h3>
			<?=$_data['확장검색부분']?>

			<!-- 상세검색 (채용정보) end -->


			<!-- 마이페이지 네비게이션바 start -->
			<hr class="hide">
			<h3 class="hide">마이페이지 네비게이션바</h3>
			<div id="navigation">
				<div id="recruite_ico">아이콘</div>
				<ul>
					<li class="start"><a href="./happy_member.php?mode=mypage">개인회원홈</a></li>
					<li class="separator"><label>|</label></li>
					<li class="n2"><a href="./html_file_per.php?mode=resume_my_manage">내이력서관리</a></li>
					<!-- <li class="n2"><a href="./document.php?mode=add">이력서등록</a></li> -->
					<li class="separator"><label>|</label></li>
					<li class="n3"><a href="./per_guin_want.php">입사지원<!-- <label class="point">●</label> -->관리</a></li>
					<li class="separator"><label>|</label></li>
					<li class="n4 ov"><a href="./per_want_search.php?mode=list">회원서비스관리</a></li>
					<li class="separator"><label>|</label></li>
					<li class="end"><a href="./guin_scrap.php">채용스크랩</a></li>
				</ul>
			</div>
			<!-- 마이페이지 네비게이션바 end -->



			<!-- 현재페이지 타이틀 start -->
			<hr class="hide">
			<h3 class="hide">현재페이지 타이틀</h3>
			<div id="now_title"><span>맞춤<label>채용정보설정</label></span></div>
			<!-- 현재페이지 타이틀 end -->



			<!-- 맟춤채용정보 설정페이지 start -->
			<hr class="hide">
			<h3 class="hide">맟춤채용정보 설정페이지</h3>

			<!-- Form start -->
			<!-- 맞춤인재정보 페이지와 'action'만 달라짐-->
			<form name="a_f_guin" action="per_want_search.php?mode=setting" method="post">

				<div class="resume_custom resume_custom_pref">
					<div class="cap_bg">배경 Cap 이미지</div>

					<div class="title_express title_express_pref"><label>맞춤정보설정</label></div>

					<!-- 맞춤채용 설정폼 Wrapper start -->
					<div class="resume_custom_contents">

						<!-- 안내글 -->
						<div class="resume_custom_guide">
							<table>
							<tr>
								<td class="bg_corner_topleft"></td>
								<td class="bgwhite"></td>
								<td class="bg_corner_topright"></td>
							</tr>
							<tr class="bgwhite">
								<td></td>
								<td class="content">
									<ul>
										<li>맞춤 채용정보 설정은 입사지원 하실려는 채용정보를 설정하신 조건에 맞게 검색하기 위한 설정 페이지입니다.</li>

										<li>맞춤 채용정보 설정에 대해서 검색조건의 각 항목에 맞게 설정하신 다음 아래 [저장하기] 버튼을 클릭하여 설정을 저장하시면 됩니다.</li>
									</ul>
								</td>
								<td></td>
							</tr>
							<tr>
								<td class="bg_corner_bottomleft"></td>
								<td class="bgwhite"></td>
								<td class="bg_corner_bottomright"></td>
							</tr>
							</table>
						</div>

						<!-- 맞춤채용 설정폼 start -->
						<div class="custom_pref_info">
							<table>
							<tr>
								<td class="item2">채용분야</td>
								<td class="clone">:</td>
								<td class="value3"><?=$_data['맞춤업종설정']?></td>
							</tr>
							<tr>
								<td class="item2">근무지역</td>
								<td class="clone">:</td>
								<td class="value3"><?=$_data['맞춤지역설정']?></td>
							</tr>
							<tr>
								<td class="item2">근무형태</td>
								<td class="clone">:</td>
								<td class="value3"><?=$_data['맞춤고용형태설정']?></td>
							</tr>
							<tr>
								<td class="item2">학력</td>
								<td class="clone">:</td>
								<td class="value3"><?=$_data['맞춤학력설정']?></td>
							</tr>
							<tr>
								<td class="item2">경력</td>
								<td class="clone">:</td>
								<td class="value3 view3_career">
									<input type='radio' name='guin_career' id="guin_career1" value='무관' <?=$_data['guin_career_check_0']?>> <label for="guin_career1">무관</label> <input type='radio' name='guin_career' id="guin_career2" value='신입' <?=$_data['guin_career_check_1']?>><label for="guin_career2">신입</label> <input type='radio' name='guin_career' id="guin_career3" value='경력' <?=$_data['guin_career_check_2']?>><label for="guin_career3">경력</label> <span><?=$_data['맞춤경력설정']?></span> 이상
								</td>
							</tr>
							<tr>
								<td class="item2">희망급여형태</td>
								<td class="clone">:</td>
								<td class="value3">
									<select name="grade_money_type"><?=$_data['희망연봉타입']?></select>
									<!-- <select name="grade_money"><?=$_data['희망연봉옵션']?></select> -->
								</td>
							</tr>
							<tr>
								<td class="item2">채용국적</td>
								<td class="clone">:</td>
								<td class="value3 value_custom_national"><?=$_data['맞춤국적설정']?></td>
							</tr>
							<tr>
								<td class="item2">성별</td>
								<td class="clone">:</td>
								<td class="value3"><?=$_data['맞춤성별설정']?></td>
							</tr>
							<tr>
								<td class="item2">채용나이</td>
								<td class="clone">:</td>
								<td class="value3"><?=$_data['맞춤연령시작설정']?> ~ <?=$_data['맞춤연령종료설정']?></td>
							</tr>
							<tr>
								<td class="item2">검색기간</td>
								<td class="clone">:</td>
								<td class="value3"><?=$_data['등록일차이']?> 까지 채용정보 검색하기</td>
							</tr>
							<tr>
								<td colspan="3"><label for=""><input type="checkbox" name="check_want_mail" id="check_want_mail" value="y" <?=$_data['check_want_mail_checked']?> />조건에 맞는 채용정보 등록시 이메일발송 발송</label></td>
							</tr>
							<tr>
								<td colspan="3"><label for=""><input type="checkbox" name="check_want_sms" id="check_want_sms" value="y" <?=$_data['check_want_sms_checked']?> />조건에 맞는 채용정보 등록시 SMS 발송</label></td>
							</tr>
							</table>
						</div>
						<!-- 맞춤채용 설정폼 end -->

					</div>
					<!-- 맞춤채용 설정폼 Wrapper end -->
				</div>
				<!-- 맟춤채용정보 설정페이지 end -->



				<!-- 맟춤채용정보  설정저장 버튼 -->
				<p class="pref_btn">

					<!-- 컷팅종이 그림자 이미지 -->
					<span class="cut_shadow"></span>

					<input type="submit" value="저장하기" class="btn_resume_custom_pref_save">
				</p>

			</form>
			<!-- Form end -->
<? }
?>