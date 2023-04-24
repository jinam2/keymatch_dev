<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 13:52:45 */
function SkyTpl_Func_61341659 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

			<!-- 지하철 노선도 선택폼 관련 JS -->
			<script language="javascript" src="./js/underground.js"></script>

			<!-- 이력서 기본정보 입력 체크사항 -->
			<script language="javascript">
			<!--
				function sendit( frm )
				{
					if ( frm.title.value == '' )
					{
						alert('이력서 제목을 입력해주세요.');
						frm.title.focus();
						return false;
					}
					if ( frm.user_phone.value == '' )
					{
						alert('전화번호를 입력해주세요.');
						frm.user_phone.focus();
						return false;
					}
					if ( frm.profile.value == '' )
					{
						alert('자기소개를 입력해주세요.');
						frm.profile.focus();
						return false;
					}

					return true;
				}

				function no_change_pay()
				{
					var obj	= document.getElementById('grade_money_type')

					if( typeof document_frm.grade_money_type != "undefined" )
					{
						if ( obj.selectedIndex == 0 )
						{
							document.getElementById('grade_money').disabled = true;
						}
						else
							document.getElementById('grade_money').disabled = false;
					}
				}

				function no_incom()
				{
					var obj	= document.getElementById('etc8')

					if ( obj.checked == true )
					{
						document.getElementById('etc9').disabled = true;
						document.getElementById('etc9').value = '소속사없음';
					}else{
						document.getElementById('etc9').disabled = false;
						if (document.getElementById('etc9').value == '소속사없음')
						{
							document.getElementById('etc9').value = '';
						}
					}
				}
			//-->
			</script>

			<script language="javascript">
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

				function handleStateChange() {
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
			//-->
			</script>

			<!-- 업/직종 선택 갯수 제한 -->
			<script type="text/javascript">
			<!--
				var checkedSize	= 1;
				function checkSize(val)
				{
					if ( val == true )
					{
						if ( checkedSize > 3 )
						{
							alert("직무분야는 3가지 이상 선택이 불가능합니다.");
							return false;
						}
						else
							checkedSize++;
					}
					else
					{
						checkedSize--;
					}
				}
			//-->
			</script>

			<!-- 키워드 선택 갯수 제한 (아래 것으로 사용) -->
			<script type="text/javascript">
			<!--
				var keyword_size	= 1;
				function checkSize2(val , key)
				{
					var frm		= document.document_frm;

					key_word	= frm.keyword.value;
					if ( key_word == "" )
					{
						keyword_size	= 0;
					}
					else
					{
						keywords		= key_word.split("/");
						keyword_size	= keywords.length;
					}
					//alert(keyword_size);

					if ( val == true )
					{
						if ( keyword_size > 15 )
						{
							alert("더이상 선택이 불가능합니다.");
							return false;
						}
						else
						{
							frm.keyword.value	+= ( keyword_size == 0 )?"":"/";
							frm.keyword.value	+= key;
						}
					}
					else
					{
						frm.keyword.value	= "";
						for ( i=0 ; i<keyword_size ; i++ )
						{
							if ( keywords[i] != key )
							{
								frm.keyword.value	+= ( frm.keyword.value != "" )?"/":"";
								frm.keyword.value	+= keywords[i];
							}
						}
					}
				}
			//-->
			</script>

			<!-- 키워드 선택 갯수 / 학력사항 관련 -->
			<script type="text/javascript">
			<!--

				//키워드 선택 갯수 제한
				var checkedSize	= 1;
				function checkSize(val , key)
				{
					var frm		= document.document_frm;

					key_word	= frm.keyword.value;
					if ( key_word == "" )
					{
						keyword_size	= 0;
					}
					else
					{
						keywords		= key_word.split("/");
						keyword_size	= keywords.length;
					}
					//alert(keyword_size);


					if ( val == true )
					{
						if ( checkedSize > 20 )
						{
							alert("키워드 선택은 20가지 이상 선택이 불가능합니다.");
							return false;
						}
						else
						{
							frm.keyword.value	+= ( keyword_size == 0 )?"":"/";
							frm.keyword.value	+= key;
							checkedSize++;
						}
					}
					else
					{
						frm.keyword.value	= "";
						for ( i=0 ; i<keyword_size ; i++ )
						{
							if ( keywords[i] != key )
							{
								frm.keyword.value	+= ( frm.keyword.value != "" )?"/":"";
								frm.keyword.value	+= keywords[i];
							}
						}
						checkedSize--;
					}
				}
			//-->
			</script>

			<!-- 탭메뉴 관련 JS : 여기에서는 사용안함 (예비로 둠) -->
			<script type="text/javascript">
			<!--
				var stabSPhoto_on = new Array() ;
				var stabSPhoto_off = new Array() ;
				for (i=1; i<=8; i++){
				 stabSPhoto_on[i] = new Image() ;
				 stabSPhoto_on[i].src = "img/bt_myroom_per_" + i + "_1.gif" ;
				 stabSPhoto_off[i] = new Image() ;
				 stabSPhoto_off[i].src = "img//bt_myroom_per_" + i + "_2.gif" ;
				}
				var stabSPhotoImgName;

				function stabSPhotoAct(){
				 for (i=1; i<=8; i++){
				  stabSPhotoImgName = "stabSPhoto" + i ;
				  document.images[stabSPhotoImgName].src = stabSPhoto_off[i].src ;
				 }
				 stabSPhotoImgName = "stabSPhoto" + arguments[0] ;
				 document.images[stabSPhotoImgName].src = stabSPhoto_on[arguments[0]].src ;
				}
			//-->
			</script>

			<!-- 복사하기 JS -->
			<script type="text/javascript">
			<!--
				function copyText()
				{
					if (window.clipboardData)
					{
						//테이블을 선택하여 복사해준다.
						window.clipboardData.setData("Text", document.getElementById("keyword").value);
						alert("복사 되었습니다.\n필요한 곳에 붙여넣기(Ctrl+V) 하세요.");
						//document.getElementById("keyword").value = "";
					}
					else
					{
						alert("사용하실 수 없습니다. 이 기능은 Internet Explorer 로만 지원합니다.");
					}
				}
			//-->
			</script>

			<!-- 탭메뉴 자바스트립트 YOON : 2011-09-20 -->
			<script type="text/javascript">
			<!--
				function showHideLayer (num){
					var tabMenuSrc   = new Array("tabMenu1","tabMenu2");
					var tabMenuContSrc  = new Array("sample_1","sample_2");

					var tabMenuButton  = new Array ();
					var tabMenuContLayer = new Array ();

					for (var z=0; z < tabMenuSrc.length; z++ )
					{
						tabMenuButton.push (document.getElementById(tabMenuSrc[z]));
						tabMenuContLayer.push (document.getElementById(tabMenuContSrc[z]));
					}
					/*
					for (var i=0; i<tabMenuButton.length ; i++ )
					{
						if ( i != num)
						{
							tabMenuButton[i].className = "noSelectBox";
							tabMenuContLayer[i].style.display = "none";
						}
						else
						{
							tabMenuButton[num].className = "selectBox"
							tabMenuContLayer[i].style.display = "";
						}
					}
					*/
					if (num == 0)
					{
						tabMenuButton[0].className = "selectBox"
						tabMenuContLayer[0].style.display = "";
						tabMenuButton[1].className = "noSelectBox";
						tabMenuContLayer[1].style.display = "none";
						tabMenuContLayer[0].innerHTML = "<select name='grade_money' id='grade_money'><?=$_data['희망연봉옵션']?></select>";
						tabMenuContLayer[1].innerHTML = "";
					}
					else
					{
						tabMenuButton[1].className = "selectBox"
						tabMenuContLayer[1].style.display = "";
						tabMenuButton[0].className = "noSelectBox";
						tabMenuContLayer[0].style.display = "none";
						tabMenuContLayer[0].innerHTML = "";
						tabMenuContLayer[1].innerHTML = "<ul><li><select name='grade_money_type' id='grade_money_type' onChange='no_change_pay()'><?=$_data['희망연봉타입']?></select></li><li><input type='text' name='grade_money' id='grade_money' value='<?=$_data['DataType4']['grade_money']?>'> </li><li><input type='button' value='다시입력' class='gradeMoneyReset' onClick='gradeMoneyReset()'></li></ul>";
					}

				}
				//입력형 희망연봉 값 초기화
				function gradeMoneyReset() {
					document.getElementById("grade_money").value = "";
				}
				window.onload = function(){
					showHideLayer(0)
				}
			//-->
			</script>

			<!-- 학력사항 관련 by kwak : edited yoon : 2011-10-27-->
			<script type="text/javascript">
			<!--
				//작성초기화 : YOON : 2011-10-27
				function gradeViewReset() {
					var notify_disable_default = document.getElementById("notify_disable_default");
					notify_disable_default.style.display = "block";
					notify_disable_default.style.top = 62 + "px";

					if (document.document_frm.grade_lastgrade.selectedIndex != 0)
					{
						var resetValue = confirm("작성초기화 됩니다. 다시 작성하시겠습니까?");
						if (resetValue)
						{
							document.document_frm.grade_lastgrade.selectedIndex = 0
							notify_disable_default.style.display = "block";
							gradeView_1('view','no');
							gradeView_2('no');
							gradeView_3('no');
							gradeView_4('no');
							gradeView_5('no');
							return true;
						}
						else
						{
							return false;
							notify_disable_default.style.display = "none";
						}
					}
					else
					{
						window.alert("처음 상태입니다.\n최종학력을 설정하시면 됩니다.");
						document.document_frm.resetButton.disabled;
					}
				}

				//추가버튼 카운팅관련 변수
				var grade4ViewCheckNum = 0;

				function gradeView()
				{
					var No	= document.document_frm.grade_lastgrade.selectedIndex;
					var notify_disable_default = document.getElementById("notify_disable_default");
					notify_disable_default.style.display = "block";
					if ( No <= 2 )
					{
						notify_disable_default.style.display = "block";
						notify_disable_default.style.top = 62 + "px";
						gradeView_1('view','no');
						gradeView_2('none');
						gradeView_3('none');
						gradeView_4('none');
						gradeView_5('none');
					}
					//선택목록에서 고등학교 졸업예정 부터 해당
					else if ( No <= 4 )
					{
						notify_disable_default.style.display = "block";
						notify_disable_default.style.top = 102 + "px";
						gradeView_1('view','view');
						gradeView_2('none');
						gradeView_3('none');
						gradeView_4('none');
						gradeView_5('none');
					}
					else if ( No <= 7 )
					{
						notify_disable_default.style.display = "block";
						notify_disable_default.style.top = 165 + "px";
						gradeView_1('view','view');
						gradeView_2('view');
						gradeView_3('none');
						gradeView_4('none');
						gradeView_5('none');
					}
					//선택목록에서 대학교중퇴(4년)부터 해당
					else if ( No <= 10 )
					{
						notify_disable_default.style.display = "none";
						grade4ViewCheckNum = 0;		//추가버튼 초기화

						gradeView_1('view','view');
						gradeView_2('view');
						gradeView_3('view');
						gradeView_4('none');
						gradeView_5('none');
					}
					else
					{
						notify_disable_default.style.display = "none";
						grade4ViewCheckNum = 0;		//추가버튼 초기화

						gradeView_1('view','view');
						gradeView_2('view');
						gradeView_3('view');
						gradeView_4('none');
						gradeView_5('view');
					}
				}

				//고등학교
				function gradeView_1( Ch , Ch2 )
				{
					disab	= ( Ch2 == "view" )?false:true;
					displ	= ( Ch == "view" )?"":"none";

					var frm	= document.document_frm;

					document.getElementById("gViewLayer1").style.display	= displ;

					frm.grade1_endYear.disabled		= disab;
					frm.grade1_schoolName.disabled	= disab;
					frm.grade1_schoolEnd.disabled	= disab;
					frm.grade1_schoolCity.disabled	= disab;
				}

				//대학(2,3년)
				function gradeView_2( Ch )
				{
					disab	= ( Ch == "view" )?false:true;
					displ	= ( Ch == "view" )?"":"none";
					displ	= "";

					var frm	= document.document_frm;

					document.getElementById("gViewLayer2").style.display	= displ;

					frm.grade2_startYear.disabled	= disab;
					frm.grade2_endYear.disabled		= disab;
					frm.grade2_endMonth.disabled	= disab;
					frm.grade2_point.disabled		= disab;
					frm.grade2_pointBest.disabled	= disab;
					frm.grade2_schoolName.disabled	= disab;
					frm.grade2_schoolType.disabled	= disab;
					frm.grade2_schoolKwa.disabled	= disab;
					frm.grade2_schoolEnd.disabled	= disab;
					frm.grade2_schoolEnd.disabled	= disab;
					frm.grade2_schoolOur.disabled	= disab;
					frm.grade2_schoolCity.disabled	= disab;
				}

				//대학교(4년)
				function gradeView_3( Ch )
				{
					disab	= ( Ch == "view" )?false:true;
					displ	= ( Ch == "view" )?"":"none";
					displ	= "";

					var frm	= document.document_frm;

					document.getElementById("gViewLayer3").style.display	= displ;

					frm.grade3_startYear.disabled	= disab;
					frm.grade3_endYear.disabled		= disab;
					frm.grade3_endMonth.disabled	= disab;
					frm.grade3_point.disabled		= disab;
					frm.grade3_pointBest.disabled	= disab;
					frm.grade3_schoolName.disabled	= disab;
					frm.grade3_schoolType.disabled	= disab;
					frm.grade3_schoolKwa.disabled	= disab;
					frm.grade3_schoolEnd.disabled	= disab;
					frm.grade3_schoolCity.disabled	= disab;
					frm.grade3_schoolOur.disabled	= disab;
				}

				//대학교(4년) 추가학력
				function gradeView_4( Ch )
				{
					disab	= ( Ch == "view" )?false:true;
					displ	= ( Ch == "view" )?"":"none";

					var frm	= document.document_frm;

					document.getElementById("gViewLayer4").style.display	= displ;

					frm.grade4_startYear.disabled	= disab;
					frm.grade4_endYear.disabled		= disab;
					frm.grade4_endMonth.disabled	= disab;
					frm.grade4_point.disabled		= disab;
					frm.grade4_pointBest.disabled	= disab;
					frm.grade4_schoolName.disabled	= disab;
					frm.grade4_schoolType.disabled	= disab;
					frm.grade4_schoolKwa.disabled	= disab;
					frm.grade4_schoolEnd.disabled	= disab;
					frm.grade4_schoolCity.disabled	= disab;
					frm.grade4_schoolOur.disabled	= disab;
				}

				//대학원이상
				function gradeView_5( Ch )
				{
					disab	= ( Ch == "view" )?false:true;
					displ	= ( Ch == "view" )?"":"none";

					var frm	= document.document_frm;

					document.getElementById("gViewLayer5").style.display	= displ;

					frm.grade5_startYear.disabled			= disab;
					frm.grade5_endYear.disabled				= disab;
					frm.grade5_endMonth.disabled			= disab;
					//frm.grade5_lastSchoolType.disabled		= disab;
					frm.grade5_point.disabled				= disab;
					frm.grade5_pointBest.disabled			= disab;
					frm.grade5_schoolName.disabled			= disab;
					frm.grade5_schoolType.disabled			= disab;
					frm.grade5_schoolKwa.disabled			= disab;
					frm.grade5_schoolEnd.disabled			= disab;
					frm.grade5_schoolCity.disabled			= disab;
					frm.grade5_schoolOur.disabled			= disab;
				}

				//대학교(4년) 다중학적 입력위한 추가버튼
				function grade4ViewCheck()
				{
					grade4ViewCheckNum++;
					No	= document.document_frm.grade_lastgrade.selectedIndex;

					if ( No < 8 )
					{
						grade4ViewCheckNum = 0;
						window.alert(' 4년제 대학이상인 경우에만 추가입력 하실수 있습니다.   ');
					}
					else
					{
						if (grade4ViewCheckNum < 2)
						{
							gradeView_4('view')
						}
						else
						{
							grade4ViewCheckNum = 2;
							window.alert("더 이상 추가하실 수 없습니다.");
						}
					}
				}
			//-->
			</script>

			<!-- 자격사항 관련 : by kwak : edited yoon : 2011-10-26-->
			<script type="text/javascript">
			<!--
				nowLayerNo1	= 1;
				var color1	= '#FFFFFF';
				var color2	= '#FFD';

				function work_layer_add1()
				{
					originalHTML	= originalHTML1;
					originalHTML	= originalHTML.replace(/\kwak/g,nowLayerNo1);
					nowLayerNo1++;

					nowColor		= ( nowLayerNo1 % 2 == 0 )?color1:color2;
					originalHTML	= "<div style='float:left; clear:both; width:100%; background-color:"+ nowColor +";'>"+originalHTML+"</div>";
					document.document_frm.worklist_size1.value	= nowLayerNo1;
					document.getElementById("kwak_view1").innerHTML	+= originalHTML;

				}
			//-->
			</script>

			<!-- 외국어능력 관련 : by kwak : edited yoon : 2011-10-26 -->
			<script type="text/javascript">
			<!--
				nowLayerNo2	= 1;
				var color1	= '#FFFFFF';
				var color2	= '#FFD';

				function work_layer_add2()
				{
					originalHTML	= originalHTML2;
					originalHTML	= originalHTML.replace(/\kwak/g,nowLayerNo2);
					nowLayerNo2++;

					nowColor		= ( nowLayerNo2 % 2 == 0 )?color1:color2;
					originalHTML	= "<div style='float:left; clear:both; width:100%; background-color:"+ nowColor +";'>"+originalHTML+"</div>";
					document.document_frm.worklist_size2.value	= nowLayerNo2;
					document.getElementById("kwak_view2").innerHTML	+= originalHTML;

				}
			//-->
			</script>

			<!-- 해외연수관련 : by kwak : edited yoon : 2011-10-26 -->
			<script type="text/javascript">
			<!--
				nowLayerNo3	= 1;
				var color1	= '#FFFFFF';
				var color2	= '#FFD';

				function work_layer_add3()
				{
					originalHTML	= originalHTML3;
					originalHTML	= originalHTML.replace(/\kwak/g,nowLayerNo3);
					nowLayerNo3++;

					nowColor		= ( nowLayerNo3 % 2 == 0 )?color1:color2;
					originalHTML	= "<div style='float:left; clear:both; width:100%; background-color:"+ nowColor +";'>"+originalHTML+"</div>";
					document.document_frm.worklist_size3.value	= nowLayerNo3;
					document.getElementById("kwak_view3").innerHTML	+= originalHTML;

				}
			//-->
			</script>

			<!-- 첨부파일 체크 -->
			<script type="text/javascript">
			<!--
				function fileCheck( file_k )
				{
					fileName	= file_k.value;
					fileNames	= fileName.split(".");
					ExtCount	= fileNames.length;
					Ext			= fileNames[ExtCount-1];
					Ext			= Ext.toLowerCase();

					if (
							Ext != "" &&
							Ext != "jpg" &&
							Ext != "jpeg" &&
							Ext != "gif" &&
							Ext != "zip" &&
							Ext != "rar" &&
							Ext != "ppt" &&
							Ext != "doc" &&
							Ext != "ppt" &&
							Ext != "xls"
						)
					{
						alert("JPG, JPEG, GIF, ZIP, RAR, PPT, DOC, PPT, XLS 확장자만 업로드 가능합니다.");
					}
				}
			//-->
			</script>

			<!-- 도움말 내용 보기/감추기 : yoon : 2011-10-26 -->
			<script type="text/javascript">
			<!--
				var view_num1 = 0;
				var view_num2 = 0;
				var view_num3 = 0;
				function helpViewOnOff1(state){
					var help_view = document.getElementById('help_view1');
					view_num1++;

					if(state == 'view'){
						if(view_num1 % 2 == 1) {
							help_view.style.display = "block";
						}else{
							help_view.style.display = "none";
						}
					}else if (state == 'close'){
						help_view.style.display = "none";
						view_num1 = 0;
					}
				}
				function helpViewOnOff2(state){
					var help_view = document.getElementById('help_view2');
					view_num2++;

					if(state == 'view'){
						if(view_num2 % 2 == 1) {
							help_view.style.display = "block";
						}else{
							help_view.style.display = "none";
						}
					}else if (state == 'close'){
						help_view.style.display = "none";
						view_num2 = 0;
					}
				}
				function helpViewOnOff3(state){
					var help_view = document.getElementById('help_view3');
					view_num3++;

					if(state == 'view'){
						if(view_num3 % 2 == 1) {
							help_view.style.display = "block";
						}else{
							help_view.style.display = "none";
						}
					}else if (state == 'close'){
						help_view.style.display = "none";
						view_num3 = 0;
					}
				}
			//-->
			</script>



			<!-- 포커스 상단위치용 가상폼 -->
			<!-- <input type="hidden" id="dummy" value="" onFocus="this.focus()"> -->


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
					<li class="n2 ov"><a href="./html_file_per.php?mode=resume_my_manage">내이력서관리</a></li>
					<!-- <li class="n2"><a href="./document.php?mode=add">이력서등록</a></li> -->
					<li class="separator"><label>|</label></li>
					<li class="n3"><a href="./per_guin_want.php">입사지원관리</a></li>
					<li class="separator"><label>|</label></li>
					<li class="n4"><a href="./per_want_search.php?mode=list">회원서비스관리</a></li>
					<li class="separator"><label>|</label></li>
					<li class="end"><a href="./guin_scrap.php">채용스크랩</a></li>
				</ul>
			</div>
			<!-- 마이페이지 네비게이션바 end -->



			<!-- 현재페이지 타이틀 start -->
			<hr class="hide">
			<h3 class="hide">현재페이지 타이틀</h3>
			<div id="now_title"><span>이력서정보<label><?=$_data['thisPageState']?></label></span></div>
			<!-- 현재페이지 타이틀 end -->



			<!-- 이력서정보등록 및 유료서비스 탭메뉴 (상단) -->
			<hr class="hide">
			<h3 class="hide">이력서정보등록 및 유료서비스 탭메뉴 (상단)</h3>
			<?=$_data['이력서탭메뉴상단']?>



			<!-- 이력서 정보입력 레이어 : start -->
			<div id="regist_page">

				<!-- FORM start -->
				<form name="document_frm" method="post" action="document.php?mode=<?=$_data['mode']?>" ENCTYPE="multipart/form-data" onSubmit="return sendit(this)">
				<input type="hidden" name="mode" value="<?=$_data['mode']?>">
				<input type="hidden" name="subMode" value="<?=$_data['subMode']?>">
				<input type="hidden" name="number" value="<?=$_data['number']?>">
				<input type="hidden" name="user_image2" value="<?=$_data['user_image2']?>">
				<input type="hidden" name="returnUrl" value="<?=$_data['returnUrl']?>">
				<input type="hidden" name="worklist_size1" value="1">
				<input type="hidden" name="worklist_size2" value="1">
				<input type="hidden" name="worklist_size3" value="1">

				<!-- 개인 메인정보판 start -->
				<div id="main_information">
					<div class="cap_title cap_title_resume_reg">
						<dl>
							<dt>개인기본정보
							<dd>
						</dl>
					</div>

					<div class="contents">

						<div class="left">
							<!-- 이력서사진 -->
							<div id="banner_logo">
								<div id="logo">
									<table>
									<tr>
										<td><img src="<?echo happy_image('') ?>" width="130" height="160" title="<?=$_data['Data']['user_name']?>"></td>
									</tr>
									</table>
								</div>
								<div class="glass"></div>
							</div>
						</div>


						<div class="right">

							<!-- 이력서 기본정보 start -->
							<div id="item_info">
								<table class="profile_main">
								<tr>
									<td class="item item_detailview">아이디</td>
									<td class="sepr">|</td>
									<td class="cnt cnt_id">
										<?=$_data['userid']?>

										<input type="hidden" name="user_id" value="<?=$_data['userid']?>">
									</td>

									<td class="item item_detailview">이름</td>
									<td class="sepr">|</td>
									<td class="cnt cnt_name"><?=$_data['DataType1']['user_name']?></td>
								</tr>
								<tr>
									<td colspan="6" class="hr"></td>
								</tr>
								</table>

								<table>
								<tr>
									<td class="item item_detailview">전화</td>
									<td class="sepr">|</td>
									<td class="cnt_sum">
										<input type="text" name="user_phone" value="<?=$_data['DataType1']['user_phone']?>">

										<label class="guide_txt">
											(예: 053-123-4567)
										</label>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="hr"></td>
								</tr>
								<tr>
									<td class="item item_detailview">핸드폰</td>
									<td class="sepr">|</td>
									<td class="cnt_sum">
										<input type="text" name="user_hphone" value="<?=$_data['DataType1']['user_hphone']?>">

										<label class="guide_txt">
											(예: 010-1234-5678)
										</label>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="hr"></td>
								</tr>
								<tr>
									<td class="item item_detailview">e-메일(기본)</td>
									<td class="sepr">|</td>
									<td class="cnt_sum">
										<input type="text" name="user_email1" value="<?=$_data['DataType1']['user_email1']?>">

										<label class="guide_txt">
											기본으로 사용할 이메일 주소를 입력하세요.
										</label>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="hr"></td>
								</tr>
								<tr>
									<td class="item item_detailview">e-메일(추가)</td>
									<td class="sepr">|</td>
									<td class="cnt_sum">
										<input type="text" name="user_email2" value="<?=$_data['DataType1']['user_email2']?>">
									</td>
								</tr>
								<tr>
									<td colspan="3" class="hr"></td>
								</tr>
								<tr>
									<td class="item item_detailview">홈페이지</td>
									<td class="sepr">|</td>
									<td class="cnt_sum">
										<input type="text" name="user_homepage" value="<?=$_data['DataType1']['user_homepage']?>" class="full">
									</td>
								</tr>
								<tr>
									<td colspan="3" class="hr"></td>
								</tr>
								<tr>
									<td class="item item_detailview">우편번호</td>
									<td class="sepr">|</td>
									<td class="cnt_sum">
										<input type="text" name="user_zipcode" value="<?=$_data['DataType1']['user_zipcode']?>" class="short">
										<input type="button" value="우편번호검색" class="btn_zipcode" onClick="window.open('http://<?=$_data['zipcode_site']?>/zonecode/happy_zipcode.php?ht=1hys=<?=$_data['base64_main_url']?>&hyf=user_zipcode|user_addr1|user_addr2|<?=$_data['zipcode_add_get']?>','happy_zipcode_popup_<?=$_data['base64_main_url']?>', 'width=600,height=600,scrollbars=yes');">
									</td>
								</tr>
								<tr>
									<td colspan="3" class="hr"></td>
								</tr>
								<tr>
									<td class="item item_detailview item_address">주소</td>
									<td class="sepr">|</td>
									<td class="cnt_sum cnt_sum_address">
										<input type="text" name="user_addr1" value="<?=$_data['DataType1']['user_addr1']?>" class="full">

										<input type="text" name="user_addr2" value="<?=$_data['DataType1']['user_addr2']?>" class="other_address">

										<label class="guide_txt guide_txt_top">
											나머지 주소를 입력하세요.
										</label>
									</td>
								</tr>
								<!-- 가로 2영역짜리
								<tr>
									<td class="item item_detailview">대표자명</td>
									<td class="sepr">|</td>
									<td class="cnt"><?=$_data['COM']['boss_name']?></td>

									<td class="item item_detailview">사원수</td>
									<td class="sepr">|</td>
									<td class="cnt"><?=$_data['COM']['com_worker_cnt']?> 명</td>
								</tr>
								<tr>
									<td colspan="6" class="hr"></td>
								</tr>
								-->
								</table>
							</div>
							<!-- 이력서 기본정보 end -->


							<!-- 이력서 열람 알림판 start -->
							<?=$_data['doc_read_env']?>

							<!-- 이력서 열람 알림판 end  -->
						</div>
					</div>

					<!-- 이력서 사진 도움말 -->
					<div class="help_resume_photo">
						<ul>
							<li>인사담당자가 이력서에서 가장 먼저 보는 곳은 바로 사진입니다.</li>
							<li>깔끔하고 정돈된 인상을 주는 사진으로 정해진 크기로 편집하여 올려 주세요.</li>
							<li>카메라폰, 화상카메라, 스티커 사진으로 찍은 사진, 얼굴을 알아볼 수 없는 사진은 사용하지 말아 주세요.</li>
						</ul>
					</div>

					<!-- 미니앨범 도움말 -->
					<div class="mini_album_help" style='<?=$_data['mobile_album_display']?>'>
						<dl>
							<dt>
								<ul>
									<li class="title">미니앨범 사진등록</li>
									<li class="icon"></li>
								</ul>
							<dd>추가로 등록된 프로필 사진이 없으면 이력서 상세정보 페이지에서는 노출되지 않습니다.
						</dl>
					</div>
					<div class="empty_height5" style='<?=$_data['mobile_album_display']?>'></div>

					<!-- 미니앨범등록 -->
					<div class="mini_album" style='<?=$_data['mobile_album_display']?>'><?=$_data['미니앨범수정']?></div>
				</div>
				<!-- 개인 메인정보판 end -->


				<!-- 이력서정보 입력하기 : start -->
				<div class="job_detailview">
					<!-- 개인부가정보 start -->
					<hr class="hide">
					<h3 class="hide">개인부가정보</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>개인부가정보
							<dd>표시된 항목은 필수 입력사항입니다.
						</dl>

						<table class="regist_input">
						<tr>
							<td class="item essential item_detailview">
								<dl>
									<dt>■
									<dd>보훈대상여부
								</dl>
							</td>
							<td class="info_pref info_pref_tri_cut">
								<?=$_data['bohunRadio']?>

							</td>
						</tr>
						<tr>
							<td class="item essential item_detailview">
								<dl>
									<dt>■
									<dd>장애여부
								</dl>
							</td>
							<td class="info_pref info_pref_tri_cut">
								<?=$_data['jangaeRadio']?>

								<span class="user_add_info2">장애등급 <?=$_data['jangaeSelect']?> 급</label>
							</td>
						</tr>
						<tr>
							<td class="item essential item_detailview">
								<dl>
									<dt>■
									<dd>병역사항
								</dl>
							</td>
							<td class="info_pref info_pref_tri_cut">
								<dl class="army_info">
									<dt><?=$_data['armyRadio']?>

									<dd>
										<ul>
											<li><?=$_data['armySelect1']?>입대 ~ <?=$_data['armySelect2']?>제대
											<li class="armyLastInfo"><?=$_data['armySelect3']?> <?=$_data['armySelect4']?> <?=$_data['armyStart']?>

										</ul>
								</dl>
							</td>
						</tr>
						</table>
					</div>
					<!-- 개인부가정보 end -->


					<!-- 근무희망지역 및 업,직종선택 start -->
					<hr class="hide">
					<h3 class="hide">근무희망지역 및 업,직종선택</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>근무희망지역 및 업/직종 선택
							<dd>표시된 항목은 필수 입력사항입니다.
						</dl>

						<table class="regist_input">
						<tr>
							<td class="item essential">
								<dl>
									<dt>■
									<dd>근무희망지역
									<!-- <dd class="btn_add" style="display:<?=$_data['form_add_button_view']?>"><input type="button" value="추가" onClick="formAreaAdd()"> -->
								</dl>
							</td>
							<td class="info_pref paddingbottom0">
								<label class="guide_txt top">
									추가 근무희망지역 선택은 추가버튼을 클릭하시면 됩니다. 근무희망 지역은 <b class="color">최대 3까지</b> 선택가능 합니다.
								</label>
								<div id="area_sel1"><?=$_data['지역검색1']?></div>
								<div id="area_sel2"><?=$_data['지역검색2']?></div>
								<div id="area_sel3"><?=$_data['지역검색3']?></div>
							</td>
						</tr>
						<tr>
							<td class="item essential">
								<dl>
									<dt>■
									<dd>업/직종선택
									<!-- <dd class="btn_add" style="display:<?=$_data['form_add_button_view']?>"><input type="button" value="추가" onClick="formJobtypeAdd()"> -->
								</dl>
							</td>
							<td class="info_pref paddingbottom0">
								<label class="guide_txt top">
									업/직종 선택은 <b class="color">최대 3까지</b> 선택가능 합니다.
								</label>
								<div id="jobtype_sel1"><?=$_data['type_info_1']?></div>
								<div id="jobtype_sel2"><?=$_data['type_info_2']?></div>
								<div id="jobtype_sel3"><?=$_data['type_info_3']?></div>
							</td>
						</tr>
						<tr>
							<td class="item essential">
								<dl>
									<dt>■
									<dd>희망근무요일
								</dl>
							</td>
							<td class="info_pref paddingbottom0">
								<label class="guide_txt top" style="padding-bottom:8px; border-bottom:1px solid #CCC;">
									희망하는 근무 요일을 선택하여 주세요.
								</label>

								<?=$_data['WeekDays']?>

								<input type="hidden" name="etc7_use" value="1">
							</td>
						</tr>
						</table>
					</div>
					<!-- 근무지역 및 업,직종선택 end -->


					<!-- 키워드선택 start -->
					<hr class="hide">
					<h3 class="hide">키워드선택</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>키워드선택
							<dd>키워드는 이력서 검색에 사용됩니다. (최소 1개 이상 필수, 최대 15개까지 선택할 수 있습니다.)
						</dl>

						<!-- Item Help -->
						<table class="list_item_help list_item_help_top_line">
						<tr>
							<td class="bg2 bg2_keyword">
								<ul>
									<li class="point">키워드는 이력서 검색에 사용되므로 중요한 부분입니다. 신중하게 이력서 내용에 적합한 키워드를 선택하시기 바랍니다.</li>
									<li>키워드 단어를 선택하면 선택된 키워드 단어는 선택 단어폼에 표시가 됩니다.</li>
									<li>키워드 선택 단어폼에 선택된 키워드 단어를 전체 복사하여 이력서 제목으로 그대로 활용하셔도 됩니다.</li>
								</ul>
							</td>
						</tr>
						</table>

						<table class="regist_input regist_input_help">
						<tr>
							<!--
							<td class="item essential">
								<dl>
									<dt>■
									<dd>키워드
								</dl>
							</td>
							-->
							<td class="info_pref" style="padding-left:0;">
								<dl class="keyword">
									<dt>키워드 선택된 단어
									<dd><input type="text" name="keyword" id="keyword" readonly value="<?=$_data['키워드']?>">
									<dd class="btn_copy"><input type="button" value="키워드복사" onClick="copyText()" title="키워드복사 기능은 Internet Explorer 에서만 지원되는 기능입니다.">
								</dl>

								<div id="keyword_box">
									<?=$_data['키워드내용']?>

								</div>
							</td>
						</tr>
						</table>
					</div>
					<!-- 키워드선택 end -->


					<!-- 고용형태 및 희망연봉 start -->
					<hr class="hide">
					<h3 class="hide">고용형태 및 희망연봉</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>고용형태 및 희망연봉
							<dd>표시된 항목은 필수입력 사항입니다.
						</dl>

						<table class="regist_input">
						<tr>
							<td class="item essential">
								<dl>
									<dt>■
									<dd>고용형태
								</dl>
							</td>
							<td class="info_pref">
								<label class="guide_txt top guide_txt_line">
									원하시는 근무 고용형태를 선택하여 주세요.
								</label>

								<?=$_data['고용형태']?>

							</td>
						</tr>
						<tr>
							<td class="item essential">
								<dl>
									<dt>■
									<dd>희망연봉
								</dl>
							</td>
							<td class="info_pref info_pref_bg_want_money">
								<label class="guide_txt top guide_txt_line">
									원하시는 희망연봉에 대해서 <b class="color">선택형</b> 또는 <b class="color">입력형</b> 둘 중 하나를 선택하여 설정하여 주세요.<br>
									<b class="color">입력형</b>으로 작성하실 경우 금액입력 (만)원 단위 글자를 포함해서 작성하여 주세요.
									<label class="ex_txt">(예: 300만원)</label>
								</label>

								<div class="tabmenu_wrap">
									<table border="0" cellspacing="0" cellpadding="0" class="tabs">
									<tr>
										<td id="tabMenu1" onClick="showHideLayer(0)">
											선택형
										</td>
										<td id="tabMenu2" onClick="showHideLayer(1)">
											입력형
										</td>
									</tr>
									</table>

									<div id="sample_1" class="sample_1"></div>
									<div id="sample_2" class="sample_2" style="display:none;"></div>

									<!-- 내용 백업본
									<div id="sample_1" class="sample_1">
										<select name='grade_money'>{ {희망연봉옵션} }</select>
									</div>
									<div id="sample_2" class="sample_2" style="display:none;">
										<ul>
											<li><select name="grade_money_type" onChange="no_change_pay()"><?=$_data['희망연봉타입']?></select></li>
											<li><input type='text' name='grade_money' id="grade_money" value="<?=$_data['DataType4']['grade_money']?>"> </li>
											<li><input type="button" value="다시입력" class="gradeMoneyReset" onClick="gradeMoneyReset()"></li>
										</ul>
									</div>
									-->
								</div>
								<script>no_change_pay()</script>
							</td>
						</tr>
						</table>
					</div>
					<!-- 고용형태 및 희망연봉 end -->


					<!-- 학력사항 start -->
					<hr class="hide">
					<h3 class="hide">학력사항</h3>
					<div class="regist_input_regular">

						<!-- 초기화 상태 알림내용 -->
						<div id="notify_disable_default" style="display:none;"></div>

						<dl class="regist_title">
							<dt>학력사항
							<dd>표시된 항목은 필수입력 사항입니다.
						</dl>

						<table class="regist_input">
						<!-- 최종학력 -->
						<tr>
							<td class="item essential">
								<dl>
									<dt>■
									<dd>최종학력
								</dl>
							</td>
							<td class="info_pref" style="padding-bottom:0;">
								<dl class="guide_txt top guide_txt_line_right">
									<dt>자신의 최종학력을 선택하여 주세요.
									<dd><input type="button" name="resetButton" value="다시" onClick="gradeViewReset()">
								</dl>

								<select name="grade_lastgrade" onChange="gradeView()">
									<?=$_data['최종학력옵션']?>

								 </select>
							</td>
						</tr>
						<!-- 고등학교 -->
						<tr id="gViewLayer1">
							<td class="item item_academic">
								<dl>
									<dt>■
									<dd>고등학교
								</dl>
							</td>
							<td class="info_pref">
								<dl class="academic">
									<dt><select name="grade1_endYear"><?=$_data['년도옵션']?></select>
									<dd class="input_info">
										<input type="text" name="grade1_schoolName" class="grade1_schoolName" value=""> <font class="txt">고등학교</font>
									<dd class="select_gradu">
										<select name="grade1_schoolEnd">
											<option value="졸업">졸업</option>
											<option value="졸업예정">졸업예정</option>
										</select>

										<select name="grade1_schoolCity">
											<?=$_data['지역선택옵션']?>

										 </select>
								</dl>
							</td>
						</tr>
						<!-- 대학(2,3년) -->
						<tr id="gViewLayer2">
							<td class="item item_academic">
								<dl>
									<dt>■
									<dd>대학(2,3년)
								</dl>
							</td>
							<td class="info_pref">
								<dl class="academic academic_bottom">
									<dt><select name="grade2_startYear"><?=$_data['년도옵션']?></select> ~
									<dd class="input_info">
										<select name="grade2_endYear"><?=$_data['년도옵션']?></select>
										<select name="grade2_endMonth"><?=$_data['월옵션']?></select>

									<dd class="select_gradu select_gradu_univers">
										<label class="txt">평점/만점</label>
										<input type="text" name="grade2_point" class="point" size="2" value="" maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" >

										<select name="grade2_pointBest" class="pointBest">
											<option value="4">4.0</option>
											<option value="4.3">4.3</option>
											<option value="4.5">4.5</option>
											<option value="100">100</option>
										 </select>
								</dl>

								<dl class="academic">
									<dt>
										<input type="text" name="grade2_schoolName" class="schoolName" title="학교명을 입력하세요."> <label class="txt txt_rMargin">대학</label> <?=$_data['DataType4']['select_grade2_schoolOur']?>


									<dd class="input_info input_info_kwa">
										<select name="grade2_schoolType"><?=$_data['계열선택옵션']?></select>
										<input type="text" name="grade2_schoolKwa" class="schoolKwa" title="학과를 입력하세요.">

									<dd class="select_gradu">
										<select name="grade2_schoolEnd">
											<option value="졸업">졸업</option>
											<option value="졸업예정">졸업예정</option>
											<option value="편입">편입</option>
											<option value="휴학">휴학</option>
											<option value="중퇴">중퇴</option>
										 </select>

										 <select name="grade2_schoolCity"><?=$_data['지역선택옵션']?></select>
								</dl>
							</td>
						</tr>
						<!-- 대학교(4년) -->
						<tr id="gViewLayer3">
							<td class="item item_academic">
								<dl>
									<dt>■
									<dd>대학교(4년)
								</dl>
							</td>
							<td class="info_pref">
								<dl class="academic academic_bottom">
									<dt><select name="grade3_startYear"><?=$_data['년도옵션']?></select> ~
									<dd class="input_info">
										<select name="grade3_endYear"><?=$_data['년도옵션']?></select>
										<select name="grade3_endMonth"><?=$_data['월옵션']?></select>

									<dd class="select_gradu select_gradu_univers">
										<label class="txt">평점/만점</label>
										<input type="text" name="grade3_point" class="point" size="2" value="" maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" >

										<select name="grade3_pointBest" class="pointBest">
											<option value="4">4.0</option>
											<option value="4.3">4.3</option>
											<option value="4.5">4.5</option>
											<option value="100">100</option>
										 </select>
								</dl>

								<dl class="academic">
									<dt>
										<input type="text" name="grade3_schoolName" class="schoolName" title="학교명을 입력하세요."> <label class="txt txt_rMargin">대학</label> <?=$_data['DataType4']['select_grade3_schoolOur']?>


									<dd class="input_info input_info_kwa">
										<select name="grade3_schoolType"><?=$_data['계열선택옵션']?></select>
										<input type="text" name="grade3_schoolKwa" class="schoolKwa" title="학과를 입력하세요.">

									<dd class="select_gradu">
										<select name="grade3_schoolEnd">
											<option value="졸업">졸업</option>
											<option value="졸업예정">졸업예정</option>
											<option value="편입">편입</option>
											<option value="휴학">휴학</option>
											<option value="중퇴">중퇴</option>
										 </select>

										 <select name="grade3_schoolCity"><?=$_data['지역선택옵션']?></select>
								</dl>
							</td>
						</tr>
						</table>

						<!-- 4년제 다중 학적 추가버튼 -->
						<div class="btn_gradu_add">
							<dl>
								<dt>4년제 다중 학적자는 [추가] 버튼을 클릭하여 추가 학력사항을 작성하실 수 있습니다.
								<dd><input type="button" value="추가"  onClick="grade4ViewCheck()">
							</dl>
						</div>

						<!-- 4년제 추가정보 입력 -->
						<table class="regist_input" style="border-top:1px solid #CCC;">
						<!-- 대학교(4년)추가학력 -->
						<tr id="gViewLayer4">
							<td class="item item_academic">
								<dl>
									<dt>■
									<dd>대학교(4년) <label class="txt_add">추가학력</label>
								</dl>
							</td>
							<td class="info_pref">
								<dl class="academic academic_bottom">
									<dt><select name="grade4_startYear"><?=$_data['년도옵션']?></select> ~
									<dd class="input_info">
										<select name="grade4_endYear"><?=$_data['년도옵션']?></select>
										<select name="grade4_endMonth"><?=$_data['월옵션']?></select>

									<dd class="select_gradu select_gradu_univers">
										<label class="txt">평점/만점</label>
										<input type="text" name="grade4_point" class="point" size="2" value="" maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" >

										<select name="grade4_pointBest" class="pointBest">
											<option value="4">4.0</option>
											<option value="4.3">4.3</option>
											<option value="4.5">4.5</option>
											<option value="100">100</option>
										 </select>
								</dl>

								<dl class="academic">
									<dt>
										<input type="text" name="grade4_schoolName" class="schoolName" title="학교명을 입력하세요."> <label class="txt txt_rMargin">대학</label> <?=$_data['DataType4']['select_grade4_schoolOur']?>


									<dd class="input_info input_info_kwa">
										<select name="grade4_schoolType"><?=$_data['계열선택옵션']?></select>
										<input type="text" name="grade4_schoolKwa" class="schoolKwa" title="학과를 입력하세요.">

									<dd class="select_gradu">
										<select name="grade4_schoolEnd">
											<option value="졸업">졸업</option>
											<option value="졸업예정">졸업예정</option>
											<option value="편입">편입</option>
											<option value="휴학">휴학</option>
											<option value="중퇴">중퇴</option>
										 </select>

										 <select name="grade4_schoolCity"><?=$_data['지역선택옵션']?></select>
								</dl>
							</td>
						</tr>
						<!-- 대학원이상 -->
						<tr id="gViewLayer5">
							<td class="item item_academic">
								<dl>
									<dt>■
									<dd>대학원이상
								</dl>
							</td>
							<td class="info_pref">
								<dl class="academic academic_bottom">
									<dt><select name="grade5_startYear"><?=$_data['년도옵션']?></select> ~
									<dd class="input_info">
										<select name="grade5_endYear"><?=$_data['년도옵션']?></select>
										<select name="grade5_endMonth"><?=$_data['월옵션']?></select>

									<dd class="select_gradu select_gradu_univers">
										<label class="txt">평점/만점</label>
										<input type="text" name="grade5_point" class="point" size="2" value="" maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" >

										<select name="grade5_pointBest" class="pointBest">
											<option value="4">4.0</option>
											<option value="4.3">4.3</option>
											<option value="4.5">4.5</option>
											<option value="100">100</option>
										 </select>
								</dl>

								<dl class="academic">
									<dt>
										<input type="text" name="grade5_schoolName" class="schoolName" title="학교명을 입력하세요."> <label class="txt txt_rMargin">대학</label> <?=$_data['DataType4']['select_grade5_schoolOur']?>


									<dd class="input_info input_info_kwa">
										<select name="grade5_schoolType"><?=$_data['계열선택옵션']?></select>
										<input type="text" name="grade5_schoolKwa" class="schoolKwa" title="학과를 입력하세요.">

									<dd class="select_gradu">
										<select name="grade5_schoolEnd">
											<option value="졸업">졸업</option>
											<option value="졸업예정">졸업예정</option>
											<option value="편입">편입</option>
											<option value="휴학">휴학</option>
											<option value="중퇴">중퇴</option>
										 </select>

										 <select name="grade5_schoolCity"><?=$_data['지역선택옵션']?></select>
								</dl>
							</td>
						</tr>
						</table>
					</div>
					<!-- 학력사항 end -->

					<!-- 학력사항 관련 JS 불러오기 -->
					<script type="text/javascript">
					<!--
						gradeView();
					//-->
					</script>



					<!-- 경력사항 및 수행프로젝트 start -->
					<hr class="hide">
					<h3 class="hide">경력사항 및 수행프로젝트</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>경력사항 및 수행프로젝트
							<dd>
						</dl>

						<!-- Item Help -->
						<table class="list_item_help list_item_help_top_line">
						<tr>
							<td class="bg2 bg2_skill">
								<ul>
									<li class="point">정확한 경력사항은 이직/전직의 기본입니다.</li>
									<li>경력사항 및 수행 프로젝트, 기타 경력사항 내용을 작성시 최근 경력사항 내용부터 작성을 권장합니다.</li>
									<li>총 경력년수와 수행 프로젝트 및 기타 경력사항은 이력서마다 별도로 작성하실 수 있습니다.</li>
								</ul>
							</td>
						</tr>
						</table>

						<table class="regist_input" style="border-top:0px solid;">
						<tr>
							<td class="item">
								<dl>
									<dt>■
									<dd>총 경력년수
								</dl>
							</td>
							<td class="info_pref">
								<select name="work_year"><?=$_data['경력옵션']?></select>
								<select name="work_month"><?=$_data['경력월옵션']?></select>
								<input type="checkbox" name="work_otherCountry" value="Y" <?=$_data['DataType5']['work_otherCountry']?> id="work_otherCountry"> <label for="work_otherCountry" style="cursor:pointer;">해외근무 경험있음</label>
							</td>
						</tr>
						<tr>
							<td class="item">
								<dl>
									<dt>■
									<dd>수행프로젝트 및 기타 경력사항
								</dl>
							</td>
							<td class="info_pref">
								<textarea name="work_list"><?=$_data['DataType5']['work_list']?></textarea>
							</td>
						</tr>
						</table>
					</div>
					<!-- 경력사항 및 수행프로젝트 end -->


					<!-- OA능력 및 자격사항, 보유기술, 외국어능력, 해외연수 start -->
					<hr class="hide">
					<h3 class="hide">OA능력 및 자격사항, 보유기술, 외국어능력, 해외연수</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>OA능력 및 보유기술<b>ㆍ</b>자격사항
							<dd>
						</dl>

						<table class="regist_input">
						<tr>
							<td class="item">
								<dl>
									<dt>■
									<dd>OA능력
								</dl>
							</td>
							<td class="info_pref nopadding nopadding_for_ie6">
								<dl class="oa_skill">
									<dt>워드(한글/MS워드)
									<dd>
										<ul>
											<li>
												<input type="radio" name="skill_word" value="3" id="skill_word3" <?=$_data['Data']['skill_word3']?>>
												<label class="skill_word3" for="skill_word3">상</label>
											</li>
											<li>
												<input type="radio" name="skill_word" value="2" id="skill_word2" <?=$_data['Data']['skill_word2']?>>
												<label class="skill_word2" for="skill_word2">중</label>
											</li>
											<li>
												<input type="radio" name="skill_word" value="1" id="skill_word1" <?=$_data['Data']['skill_word1']?>>
												<label class="skill_word1" for="skill_word1">하</label>
											</li>
										</ul>
								</dl>
								<dl class="oa_skill">
									<dt>프리젠테이션(파워포인트)
									<dd>
										<ul>
											<li>
												<input type="radio" name="skill_ppt" value="3" id="skill_ppt3" <?=$_data['Data']['skill_ppt3']?>>
												<label class="skill_ppt3" for="skill_ppt3">상</label>
											</li>
											<li>
												<input type="radio" name="skill_ppt" value="2" id="skill_ppt2" <?=$_data['Data']['skill_ppt2']?>>
												<label class="skill_ppt2" for="skill_ppt2">중</label>
											</li>
											<li>
												<input type="radio" name="skill_ppt" value="1" id="skill_ppt1" <?=$_data['Data']['skill_ppt1']?>>
												<label class="skill_ppt1" for="skill_ppt1">하</label>
											</li>
										</ul>
								</dl>
								<dl class="oa_skill">
									<dt>스프레드시트(엑셀)
									<dd>
										<ul>
											<li>
												<input type="radio" name="skill_excel" value="3" id="skill_excel3" <?=$_data['Data']['skill_excel3']?>>
												<label class="skill_excel3" for="skill_excel3">상</label>
											</li>
											<li>
												<input type="radio" name="skill_excel" value="2" id="skill_excel2" <?=$_data['Data']['skill_excel2']?>>
												<label class="skill_excel2" for="skill_excel2">중</label>
											</li>
											<li>
												<input type="radio" name="skill_excel" value="1" id="skill_excel1" <?=$_data['Data']['skill_excel1']?>>
												<label class="skill_excel1" for="skill_excel1">하</label>
											</li>
										</ul>
								</dl>
								<dl class="oa_skill oa_skill_bottom_noline">
									<dt>인터넷 (정보검색/Outlook)
									<dd>
										<ul>
											<li>
												<input type="radio" name="skill_search" value="3" id="skill_search3" <?=$_data['Data']['skill_search3']?>>
												<label class="skill_search3" for="skill_search3">상</label>
											</li>
											<li>
												<input type="radio" name="skill_search" value="2" id="skill_search2" <?=$_data['Data']['skill_search2']?>>
												<label class="skill_search2" for="skill_search2">중</label>
											</li>
											<li>
												<input type="radio" name="skill_search" value="1" id="skill_search1" <?=$_data['Data']['skill_search1']?>>
												<label class="skill_search1" for="skill_search1">하</label>
											</li>
										</ul>
								</dl>
							</td>
						</tr>
						<tr>
							<td class="item">
								<dl style="float:left; clear:both; width:90%; margin-bottom:10px;">
									<dt>■
									<dd style="position:relative;">자격사항
										<!-- 도움말 버튼 -->
										<span class="btn_guide_help_resume"><a href="#popup" onClick="helpViewOnOff1('view');"><img src="./img/btn_help_simple3_gray.gif" alt="도움말버튼" title="참고정보" width="16" height="16"></a></span>

									<dd class="btn_add"><input type="button" value="추가" onClick="work_layer_add1()" >
									<!-- <dd class="btn_reload"><input type="button" value="다시" onClick="work_layer_add1(reset)" > -->
								</dl>
							</td>
							<td class="info_pref nopadding nopadding_for_ie6" style="padding-top:7px;">

								<label id="help_view1" class="guide_txt top guide_txt_line" style="display:none;">
									자격사항에 대한 내용이 있으시면 작성을 하시면 됩니다.<br>
									자격사항 내용이 2개 이상일 경우 필요한 만큼 <b class="color">추가</b> 버튼을 클릭하시면 됩니다.<br>
									추가생성된 항목을 삭제하실 경우 <b class="color">삭제시체크</b>에 체크하시면 됩니다.<br>
									<b class="color">다시</b> 버튼을 클릭하시면 추가 생성된 전체 항목이 초기화가 됩니다.
								</label>

								<!--  DIV kwak,kwak_view를 없애면 자바스크립트 에러가 두둥!! 뜰것입니다.  아래부터 편집 -->
								<div id="kwak1" style="display:none">
									<dl class="my_certificate my_certificate_bottom_noline">
										<dt>자격증명
										<dd>
											<ul>
												<li class="input"><input type="text" name="skill_name__kwak"></li>
												<li class="check_del"><input type="checkbox" name="delete_skill__kwak" value="1" id="delete_skill__kwak"> <label class="delete_skill__kwak" for="delete_skill__kwak">삭제시체크</label></li>
											</ul>
									</dl>
									<dl class="my_certificate">
										<dt class="title">발행처
										<dd class="inputx"><input type="text" name="skill_from__kwak">

										<dt class="sub_title">취득일자
										<dd class="select">
											<select name="skill_getYear__kwak">
											<?=$_data['년도옵션']?>

											</select>
											<select name="skill_getMonth__kwak">
											<?=$_data['월옵션']?>

											</select>
											<select name="skill_getDay__kwak">
											<?=$_data['일옵션']?>

											</select>
									</dl>
								</div>

								<!-- 요기까지 편집 하세요. -->
								<script type="text/javascript">
								<!--
									originalHTML1	= document.getElementById("kwak1").innerHTML;
								//-->
								</script>

								<!-- 요아래 DIV도 지우시면 안됩니다. 실제 출력되는 부분.. -->
								<div id="kwak_view1" style="float:left; clear:both; width:100%; height:auto; margin-bottom:-1px; border:0px solid red;">
								</div>
								<!-- 요까이 -->

							</td>
						</tr>
						<tr>
							<td class="item">
								<dl>
									<dt>■
									<dd>보유기술 및<br>교육이수 내용
								</dl>
							</td>
							<td class="info_pref" style="padding-bottom:0;">
								<textarea name="skill_list"><?=$_data['Data']['skill_list']?></textarea>

								<!-- Item Help -->
								<table class="list_item_help_ex">
								<tr>
									<td class="bg2 bg2_skill_ex">
										<dl>
											<dt>예)
											<dd class="block_a">[보유기술]
											<dd> - PHP, MySQL, JavaScript, HTML, CSS, Illustraoter, Flash, Photoshop
											<dd class="block_b">[교육사항]
											<dd> - 2001년 02월 ~ 2001년 08월 : 해피 교육센터 웹디자인 과정 수료
											<dd> - 2002년 04월 ~ 2001년 10월 : 대한 교육센터 컴퓨터시스템 과정 수료
										</dl>
									</td>
								</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td class="item">
								<dl style="float:left; clear:both; width:90%; margin-bottom:10px;">
									<dt>■
									<dd style="position:relative;">외국어능력
										<!-- 도움말 버튼 -->
										<!--
										<span class="btn_guide_help_resume"><a href="#popup" onClick="helpViewOnOff2('view');"><img src="./img/btn_help_simple3.gif" alt="도움말버튼" title="참고정보" width="16" height="16"></a></span>
										-->

									<dd class="btn_add"><input type="button" value="추가" onClick="work_layer_add2()" >
								</dl>
							</td>
							<td class="info_pref nopadding nopadding_for_ie6" style="float:left; position:relative; width:620px; padding-top:7px; ">

								<!-- 외국어능력 시험정보 및 점수(급수) 정보 팝업 레이어 start -->
								<div id="foreign_lang_help" style="display:none;">
									<h2>외국어능력 시험정보 및 등급방식 정보</h2>
									<div class="btn_popup_close"><a href="#close_popup" onClick="foreignLangInfo('close')" title="팝업닫기">닫기</a></div>

									<div class="foreign_info">
										<table>
										<tr>
											<th nowrap>외국어</th>
											<th nowrap>공인시험</th>
											<th nowrap>등급방식</th>
										</tr>

										<!-- 영어 -->
										<tr>
											<td rowspan="15" valign="top">영어</td>
											<td>TOEIC</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>TOEIC(Speaking)</td>
											<td>1급~9급</td>
										</tr>
										<tr>
											<td>TOEIC(S&W)</td>
											<td>1급~9급</td>
										</tr>
										<tr>
											<td>TOEFL(PBT)</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>TOEFL(CBT)</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>TOEFL(iBT)</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>TEPS</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>IELTS</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>G-TELP(GLT)</td>
											<td>1급~5급</td>
										</tr>
										<tr>
											<td>G-TELP(GST)</td>
											<td>1급~5급</td>
										</tr>
										<tr>
											<td>SLEP</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>GRE</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>GMAT</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>PELT</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>OPIc</td>
											<td>급수<br>S, AH, AM, AL IH<br> IM, IL, NH, NM, NL</td>
										</tr>

										<!-- 일어 -->
										<tr>
											<td rowspan="5" valign="top">일어</td>
											<td>JPT</td>
											<td>점수</td>
										</tr>
										<tr>
											<td>JLPT</td>
											<td>1급~4급</td>
										</tr>
										<tr>
											<td>新JLPT</td>
											<td>급수 (N1~N5)</td>
										</tr>
										<tr>
											<td>JTRA</td>
											<td>1급~4급</td>
										</tr>
										<tr>
											<td>NPT</td>
											<td>1급~4급</td>
										</tr>

										<!-- 중국어 -->
										<tr>
											<td rowspan="3" valign="top">중국어</td>
											<td>HSK</td>
											<td>1급~11급</td>
										</tr>
										<tr>
											<td>新HSK</td>
											<td>1급~6급</td>
										</tr>
										<tr>
											<td>HSK회화</td>
											<td>급수 (초,중,고)</td>
										</tr>

										<!-- 독일어 -->
										<tr>
											<td rowspan="4" valign="top">독일어</td>
											<td>ZDAF</td>
											<td>급 (취득)</td>
										</tr>
										<tr>
											<td>ZMP</td>
											<td>급 (취득)</td>
										</tr>
										<tr>
											<td>GDS</td>
											<td>급 (취득)</td>
										</tr>
										<tr>
											<td>KDS</td>
											<td>급 (취득)</td>
										</tr>

										<!-- 프랑스어 -->
										<tr>
											<td rowspan="2" valign="top">프랑스어</td>
											<td>DELF</td>
											<td>1급~2급</td>
										</tr>
										<tr>
											<td>DALF</td>
											<td>급 (취득)</td>
										</tr>

										<!-- 러시아어 -->
										<tr>
											<td valign="top">러시아어</td>
											<td>DELF</td>
											<td>
												기초단계, 기본단계<br> 1단계, 2단계, 3단계, 4단계
											</td>
										</tr>

										<!-- 스페인어 -->
										<tr>
											<td valign="top">스페인어</td>
											<td>DELF</td>
											<td>
												급수 (초,중,고)
											</td>
										</tr>
										</table>
									</div>
								</div>
								<!-- 외국어능력 시험정보 및 점수(급수) 정보 팝업 레이어 end -->

								<label id="help_view2" class="guide_txt top guide_txt_line" style="position:relative;">
									외국어능력에 대한 내용이 있으시면 작성을 하시면 됩니다.<br>
									외국어능력 내용이 2개 이상일 경우 필요한 만큼 <b class="color">추가</b> 버튼을 클릭하시면 됩니다.<br>
									추가생성된 항목을 삭제하실 경우 <b class="color">삭제시체크</b>에 체크하시면 됩니다.<br>
									<b class="color">다시</b> 버튼을 클릭하시면 추가 생성된 전체 항목이 초기화가 됩니다.

									<span class="btn_guide_help"><a href="#popup" onClick="foreignLangInfo('view');"><img src="./img/btn_help_simple3.gif" alt="도움말버튼" title="참고정보" width="16" height="16"></a></span>
								</label>

								<!--  DIV kwak,kwak_view를 없애면 자바스크립트 에러가 두둥!! 뜰것입니다.  아래부터 편집 -->
								<div id="kwak2" style="display:none">
									<dl class="my_foreign_lang my_foreign_lang_bottom_noline">
										<dt class="title">외국어명 및 구사능력
										<dd class="f_lang_select">
											<dl>
												<dt>
													<select name="language_title__kwak">
														<?=$_data['외국어능력옵션']?>

													</select>
												<dd class="level_select">
													<ul>
														<li>
															<input type="radio" name="language_skill__kwak" value="3" id="language_skill__kwak3" <?=$_data['Data']['language_skill3']?>>
															<label style="background:url('./img/ico_level_high.gif') no-repeat 0 0;" for="language_skill__kwak3">상</label>
														</li>
														<li>
															<input type="radio" name="language_skill__kwak" value="2" id="language_skill__kwak2" <?=$_data['Data']['language_skill2']?>>
															<label style="background:url('./img/ico_level_middle.gif') no-repeat 0 0;" for="language_skill__kwak2">중</label>
														</li>
														<li>
															<input type="radio" name="language_skill__kwak" value="1" id="language_skill__kwak1" <?=$_data['Data']['language_skill1']?>>
															<label style="background:url('./img/ico_level_low.gif') no-repeat 0 0;" for="language_skill__kwak1">하</label>
														</li>
													</ul>

												<dd class="check_del">
													<input type="checkbox" name="delete_language_skill__kwak" value="1" id="delete_language_skill__kwak"> <label class="delete_language_skill__kwak" for="delete_language_skill__kwak">삭제시체크</label>
											</dl>

									</dl>
									<dl class="my_foreign_lang">
										<dt class="title">공인시험 | 취득일자
										<dd class="inputx">
											<select name="language_check__kwak">
												<?=$_data['외국어자격증옵션']?>

											</select>
										<dd class="inputx_point" title="공인시험에 따라 점수 또는 급수를 입력하세요.">
											<input type="text" name="language_point__kwak"> <label>점/급</label>

										<dd class="select">
											<select name="language_year__kwak" title="취득일자(년)">
												<?=$_data['년도옵션']?>

											</select>
											<select name="language_month__kwak" title="취득일자(월)">
												<?=$_data['월옵션']?>

											</select>
											<select name="language_day__kwak" title="취득일자(일)">
												<?=$_data['일옵션']?>

											</select>
									</dl>
								</div>

								<!-- 요기까지 편집 하세요. -->
								<script type="text/javascript">
								<!--
									originalHTML2	= document.getElementById("kwak2").innerHTML;
								//-->
								</script>

								<!-- 요아래 DIV도 지우시면 안됩니다. 실제 출력되는 부분.. -->
								<div id="kwak_view2" style="float:left; clear:both; width:100%; height:auto; margin-bottom:-1px; border:0px solid red;">
								</div>
								<!-- 요까이 -->

							</td>
						</tr>
						<tr>
							<td class="item">
								<dl style="float:left; clear:both; width:90%; margin-bottom:10px;">
									<dt>■
									<dd style="position:relative;">해외연수
										<!-- 도움말 버튼 -->
										<span class="btn_guide_help_resume"><a href="#popup" onClick="helpViewOnOff3('view');"><img src="./img/btn_help_simple3_gray.gif" alt="도움말버튼" title="참고정보" width="16" height="16"></a></span>

									<dd class="btn_add"><input type="button" value="추가" onClick="work_layer_add3()" >
								</dl>
							</td>
							<td class="info_pref nopadding nopadding_for_ie6" style="padding-top:7px; position:relative;">
								<label id="help_view3" class="guide_txt top guide_txt_line" style="display:none;">
									해외연수에 대한 내용이 있으시면 작성을 하시면 됩니다.<br>
									해외연수 내용이 2개 이상일 경우 필요한 만큼 <b class="color">추가</b> 버튼을 클릭하시면 됩니다.<br>
									추가생성된 항목을 삭제하실 경우 <b class="color">삭제시체크</b>에 체크하시면 됩니다.<br>
									<!-- <b class="color">다시</b> 버튼을 클릭하시면 추가 생성된 전체 항목이 초기화가 됩니다. -->
								</label>

								<!--  DIV kwak,kwak_view를 없애면 자바스크립트 에러가 두둥!! 뜰것입니다.  아래부터 편집 -->
								<div id="kwak3" style="display:none">
									<dl class="my_foreign_national my_foreign_national_bottom_noline">
										<dt class="title">연수국가
										<dd class="f_national_select">
											<dl>
												<dt>
													<select name="country__kwak" style="width:150px;">
														<?=$_data['연수국가옵션']?>

													</select>

												<dd class="check_del">
													<input type="checkbox" name="delete_yunsoo__kwak" value="1" id="delete_yunsoo__kwak"> <label class="delete_yunsoo__kwak" for="delete_yunsoo__kwak">삭제시체크</label>

											</dl>
									</dl>
									<dl class="my_foreign_national my_foreign_national_bottom_noline">
										<dt class="title">연수기간
										<dd class="f_national_select">
											<dl>
												<dt>
													<select name="startYear__kwak">
														<?=$_data['년도옵션']?>

													</select>
													<label class="date_txt">년</labeL>

													<select name="startMonth__kwak">
														<?=$_data['월옵션']?>

													</select>
													<label class="date_txt">월</labeL> ~

												<dd class="level_select">
													<select name="endYear__kwak">
														<?=$_data['년도옵션']?>

													</select>
													<label class="date_txt">년</labeL>

													<select name="endMonth__kwak">
														<?=$_data['월옵션']?>

													</select>
													<label class="date_txt">월</labeL>
											</dl>
									</dl>
									<dl class="my_foreign_national">
										<dt class="title">목적 및 내용
										<dd class="inputx">
											<input type="text" name="content__kwak">
									</dl>
								</div>

								<!-- 요기까지 편집 하세요. -->
								<script type="text/javascript">
								<!--
									originalHTML3	= document.getElementById("kwak3").innerHTML;
								//-->
								</script>

								<!-- 요아래 DIV도 지우시면 안됩니다. 실제 출력되는 부분.. -->
								<div id="kwak_view3" style="float:left; clear:both; width:100%; height:auto; margin-bottom:-1px; border:0px solid red;">
								</div>
								<!-- 요까이 -->

							</td>
						</tr>
						</table>
					</div>
					<!-- OA능력 및 자격사항, 보유기술, 외국어능력, 해외연수 end -->


					<!-- 자격사항 관련 JS -->
					<!-- 이전에 입력된 내용을 기본으로 불러옴 -->
					<?=$_data['defaultSetting']?>




					<!-- 이력서제목 start -->
					<hr class="hide">
					<h3 class="hide">이력서제목</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>이력서제목
							<dd>표시된 항목은 필수입력 사항입니다.
						</dl>

						<!-- Item Help -->
						<table class="list_item_help list_item_help_top_line">
						<tr>
							<td class="bg2 bg2_resume_title">
								<ul>
									<li class="point">이력서 제목은 검색에 사용됩니다.</li>
									<li>이력서 제목은 검색에 사용되므로 이력서 열람 여부를 결정짓는 중요한 요소이기 때문에 희밍직무 또는 구체적인 지원분야를 입력하시는 것이 좋습니다.</li>
								</ul>
							</td>
						</tr>
						</table>

						<table class="regist_input" style="border-top:0px solid;">
						<tr>
							<td class="item essential">
								<dl>
									<dt>■
									<dd>이력서제목
								</dl>
							</td>
							<td class="info_pref">
								<dl class="resume_title">
									<dt><input type="text" name="title" value="<?=$_data['DataType1']['title']?>">
									<dd>
										<input type="checkbox" name="display" value="N" <?=$_data['DataType1']['display']?> id="security">
										<label for="security">비공개시 체크</label>
								</dl>

								<!-- Help -->
								<label class="guide_txt guide_txt_title" style="display:none;">
									(예 : PHP, MySQL, ASP, SQL, 웹프로그래밍, 웹디자인, 포토샵, 플래시, Javascript, Ajax, 3ds max, Maya)
								</label>
							</td>
						</tr>
						</table>
					</div>
					<!-- 이력서제목 end -->


					<!-- 자기소개서 start -->
					<hr class="hide">
					<h3 class="hide">자기소개서</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>자기소개서 <img src="./img/ico_dot_orange_4x4.gif" width="4" height="4">
							<dd>표시된 항목은 필수입력 사항입니다.
						</dl>

						<table class="regist_input">
						<tr>
							<td class="item essential item_detailview item_self_introduction">
								그림아이콘
							</td>
							<td class="info_pref">
								<textarea name="profile" class="self_introduction"><?=$_data['DataType1']['profile']?></textarea>
							</td>
						</tr>
						</table>
					</div>
					<!-- 자기소개서 end -->


					<!-- 첨부파일 start -->
					<hr class="hide">
					<h3 class="hide">첨부파일</h3>
					<div class="regist_input_regular">
						<dl class="regist_title">
							<dt>첨부파일등록
							<dd>
						</dl>

						<!-- Item Help -->
						<table class="list_item_help list_item_help_top_line">
						<tr>
							<td class="bg2 bg2_file_attach">
								<ul>
									<li class="point">각종 문서파일 및 이미지파일을 필요에 따라 첨부파일을 등록합니다.</li>
									<li>별도로 작성한 이력서, 경력요약서, 기획서, 포트폴리오 등을 입사지원시 선택하여 첨부하실 수 있습니다.</li>
									<li>첨부파일 등록은 <b class="color">최대 5개</b>까지 등록하실 수 있습니다.</li>
								</ul>
							</td>
						</tr>
						</table>

						<table class="regist_input" style="border-top:0px solid;">
						<tr>
							<td class="item">
								<dl style="float:left; clear:both; width:90%; margin-bottom:10px;">
									<dt>■
									<dd>첨부파일
									<!-- <dd class="btn_add" style="display:<?=$_data['form_add_button_view']?>"><input type="button" value="추가" onClick="formImageFormAdd('add')"> -->
									<dd class="btn_reload" style="display:<?=$_data['form_add_button_view']?>"><input type="button" value="다시" onClick="formImageFormAdd('reset')">
								</dl>
							</td>
							<td class="info_pref">
								<label class="guide_txt top">
									등록가능한 첨부파일 확장자는 <b class="color">JPG, JPEG, GIF, ZIP, RAR, PPT, DOC, PPT, XLS</b> 확장자만 업로드 가능합니다.<br>
									<font style="display:<?=$_data['form_add_button_view']?>;"><b class="color">다시</b>를 클릭하시면 선택한 파일의 파일경로명 값이 초기화 됩니다.</font>
								</label>

								<div id="num1" class="regist_image regist_image_modify">
									<dl>
										<dt><p>첨부파일</p>
										<dd><input type="file" name="file1" id="file1" onChange="fileCheck(this)"> <label class="image_del"><?=$_data['삭제1']?></label> <label class="file_down_preview"><?=$_data['미리보기1']?></label>
									</dl>
								</div>

								<div id="num2" class="regist_image regist_image_modify">
									<dl>
										<dt><p>첨부파일</p>
										<dd><input type="file" name="file2" id="file2" onChange="fileCheck(this)"> <label class="image_del"><?=$_data['삭제2']?></label> <label class="file_down_preview"><?=$_data['미리보기2']?></label>
									</dl>
								</div>

								<div id="num3" class="regist_image regist_image_modify">
									<dl>
										<dt><p>첨부파일</p>
										<dd><input type="file" name="file3" id="file3" onChange="fileCheck(this)"> <label class="image_del"><?=$_data['삭제3']?></label> <label class="file_down_preview"><?=$_data['미리보기3']?></label>
									</dl>
								</div>

								<div id="num4" class="regist_image regist_image_modify">
									<dl>
										<dt><p>첨부파일</p>
										<dd><input type="file" name="file4" id="file4" onChange="fileCheck(this)"> <label class="image_del"><?=$_data['삭제4']?></label> <label class="file_down_preview"><?=$_data['미리보기4']?></label>
									</dl>
								</div>

								<div id="num5" class="regist_image regist_image_modify">
									<dl>
										<dt><p>첨부파일</p>
										<dd><input type="file" name="file5" id="file5" onChange="fileCheck(this)"> <label class="image_del"><?=$_data['삭제5']?></label> <label class="file_down_preview"><?=$_data['미리보기5']?></label>
									</dl>
								</div>
							</td>
						</tr>
						</table>
					</div>
					<!-- 첨부파일 end -->


					<!-- 유료서비스 안내 start -->
					<hr class="hide">
					<h3 class="hide">유료서비스 안내</h3>
					<div class="regist_input_regular" style="margin-bottom:5px; display:<?=$_data['yuro_service_view']?>;">
						<dl class="regist_title">
							<dt>유료서비스 안내
							<dd style="background:url('');">이력서정보 노출에 대한 유료서비스 안내입니다.
						</dl>

						<table class="regist_input">
						<tr>
							<td class="item commercial_guide">
								<p>유료서비스 배경아이콘 이미지</p>
							</td>
							<td class="info_pref">
								<label class="guide_txt top">
									<h3>유료서비스를 이용하시면...</h3>

									<p>
										차별화된 위치에 인재정보가 노출되어 보다 효과적으로 구직 진행이 가능합니다. <font class="color_orange">또한, 인재정보를 먼저 등록하신 후에도 등록한 인재정보에 대한</font> 유료서비스를 이용하실 수 있으며, 설정은 <font class="color_green">마이페이지 > 내 이력서관리</font> 페이지로 이동 하신 후 각 <font class="color_green">등록된 이력서정보의 유료서비스 신청하기</font>를 통해서 이용하실 수 있습니다..<br><br>
										<!--
										유료 노출광고 서비스 항목은 다음과 같습니다.<br><br>
										<font class="color_green">스페셜, 파워링크, 포커스, 제목아이콘, 컬러제목, 볼드, 형광색, 페이지보조노출, 통합검색노출</font><br><br>
										-->

										유료서비스를 이용하지 않는 인재정보는 해당 인재정보 리스트에서만 등록 노출이 됩니다. 인재정보만 먼저 등록하실 경우 비결제 일반등록 버튼을 클릭하시면 됩니다. 유료서비스를 사용하여 등록하실 경우 해당 원하시는 결제버튼을 클릭하여 진행하시면 됩니다.<br><br>

										유료서비스는 선택사항이며, 필요에 따라 언제든지 서비스를 이용하시면 됩니다.<br><br>

										유료서비스를 이용하지 않고, 인재정보를 먼저 등록하실 경우 아래 <b style="color:#0AF;">비결제 일반등록</b> 버튼을 클릭하시면 됩니다.</p>
									</p>
								</label>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding:10px 0; background-color:#EEE;">
								<p align="center" class="go_here">유료서비스를 이용하실려면 <a href="#regist_start_position" onClick="registTabmenu('commercial');"><b class="color_blue"><u>여기</u></b></a>를 눌러주세요.</p>
							</td>
						</tr>
						</table>
					</div>
					<!-- 유료서비스 안내 end -->

				</div>
				<!-- 이력서정보 입력하기 end -->
			</div>
			<!-- 이력서 정보입력 레이어 : end -->


			<!-- 유료서비스 : 결제페이지 -->
			<?=$_data['이력서결제페이지']?>




			<!-- 이력서정보등록 및 유료서비스 탭메뉴 (하단) -->
			<hr class="hide">
			<h3 class="hide">이력서정보등록 및 유료서비스 탭메뉴 (하단)</h3>
			<?=$_data['이력서탭메뉴하단']?>



			<!-- 결제등록 및 무료등록 버튼 start -->
			<hr class="hide">
			<h3 class="hide">결제등록 및 무료등록 버튼</h3>
			<div id="pay_regist">

				<!-- 결제버튼 -->
				<ul id="uryo_button_layer">
					<?=$_data['등록버튼']?>

					<li><input type="button" value="되돌아가기" class="pay_cancel3" onClick="location.href='./html_file_per.php?mode=resume_my_manage'"></li>
					<!-- 원소스코드 : document.php 파일안에 내용 포함
					<li><input type="button" value="실시간계좌이체" class="pay_realtime"></li>
					<li><input type="button" value="카드결제" class="pay_card"></li>
					<li><input type="button" value="휴대폰결제" class="pay_mobile"></li>
					<li><input type="button" value="무통장입금" class="pay_mutongjang"></li>
					<li><input type="button" value="포인트결제" class="pay_point"></li>
					 -->
				</ul>

				<!-- 비결제 일반등록 버튼 -->
				<ul id="free_button_layer" style="display:none;">
					<li class="help_balloon_pay_no help_balloon_pay_cancel">
						<p>현재 유료서비스 항목에 선택되어 있지 않습니다.</p>
					</li>
					<li><?=$_data['PAY']['free']?></li>
					<li><input type="button" value="되돌아가기" class="pay_cancel3" onClick="location.href='./html_file_per.php?mode=resume_my_manage'"></li>
					<!-- 원소스코드 : guin_regist.php 파일안에 내용 포함
					<li><input type="button" value="비결제 일반등록" class="pay_noreg"></li>
					-->
				</ul>
			</div>
			<!-- 결제등록 및 무료등록 버튼 end -->


			</form>
			<!-- FORM end -->



			<!-- 금액관련 JS -->
			<?=$_data['PAY']['loading_script']?>




			<!-- 근무지역 / 업,직종선택 / 이미지등록 폼추가 관련 JS start -->
			<script type="text/javascript">
			<!--
				//근무지역
				var area_sel		= new Array();
				area_sel[0] = document.getElementById("area_sel1");
				area_sel[1] = document.getElementById("area_sel2");
				area_sel[2] = document.getElementById("area_sel3");
				//area_sel[1].style.display = "<?=$_data['form_view_switch']?>";
				//area_sel[2].style.display = "<?=$_data['form_view_switch']?>";

				//업,직종선택
				var jobtype_sel		= new Array();
				jobtype_sel[0] = document.getElementById("jobtype_sel1");
				jobtype_sel[1] = document.getElementById("jobtype_sel2");
				jobtype_sel[2] = document.getElementById("jobtype_sel3");
				//jobtype_sel[1].style.display = "<?=$_data['form_view_switch']?>";
				//jobtype_sel[2].style.display = "<?=$_data['form_view_switch']?>";

				//첨부파일등록
				var image_regist		= new Array();
				image_regist[0] = document.getElementById("num1");
				image_regist[1] = document.getElementById("num2");
				image_regist[2] = document.getElementById("num3");
				image_regist[3] = document.getElementById("num4");
				image_regist[4] = document.getElementById("num5");
				/*
				image_regist[0].style.display = "block";
				image_regist[1].style.display = "<?=$_data['form_view_switch']?>";
				image_regist[2].style.display = "<?=$_data['form_view_switch']?>";
				image_regist[3].style.display = "<?=$_data['form_view_switch']?>";
				image_regist[4].style.display = "<?=$_data['form_view_switch']?>";
				*/
				var i = 0;
				var j = 0;
				var z = 0;

				//근무지역 추가
				function formAreaAdd(){

					if(i < area_sel.length) {
						area_sel[i].style.display = "block";
					}else{
						alert("최대 3개 까지이며 더 이상 추가하실 수 없습니다.");
					}
					i++;
				}

				//업,직종선택 추가
				function formJobtypeAdd(){

					if(j < jobtype_sel.length) {
						jobtype_sel[j].style.display = "block";
					}else{
						alert("최대 3개 까지이며 더 이상 추가하실 수 없습니다.");
					}
					j++;
				}

				//첨부파일등록 추가
				function formImageFormAdd(state){

					var frm	= document.document_frm;

					if (state == "add")
					{
						z++;
						//alert(z);
						if(z < image_regist.length) {
							image_regist[z].style.display = "block";
						}else{
							alert("최대 5개 까지이며 더 이상 추가하실 수 없습니다.");
						}
					}
					else
					{
						frm.file5.select();
						document.execCommand('Delete');

						frm.file4.select();
						document.execCommand('Delete');

						frm.file3.select();
						document.execCommand('Delete');

						frm.file2.select();
						document.execCommand('Delete');

						frm.file1.select();
						document.execCommand('Delete');

						/*
						image_regist[0].style.display = "block";
						image_regist[1].style.display = "<?=$_data['form_view_switch']?>";
						image_regist[2].style.display = "<?=$_data['form_view_switch']?>";
						image_regist[3].style.display = "<?=$_data['form_view_switch']?>";
						image_regist[4].style.display = "<?=$_data['form_view_switch']?>";
						*/

						z = 0;
					}

					//포커스 위치를 상단으로 해주는 가상 Form
					//document.getElementById("dummy").focus();
				}
				//formAreaAdd();
				//formJobtypeAdd();

			//-->
			</script>
			<!-- 근무지역 / 업,직종선택 / 이미지등록 폼추가 관련 JS end -->


			<!-- //이력서정보 / 유료서비스 등록페이지 : 탭메뉴 관련 JS start -->
			<script type="text/javascript">
			<!--

				function registTabmenu(state) {

					/* 상단 탭메뉴 */
					var recruit				= document.getElementById("recruit");
					var commercial			= document.getElementById("commercial");

					/* 하단 탭메뉴 */
					var recruit_bottom			= document.getElementById("recruit_bottom");
					var commercial_bottom		= document.getElementById("commercial_bottom");

					var regist_page			= document.getElementById("regist_page");
					var commercial_page		= document.getElementById("commercial_page");

					if (state == "recruit") {
						recruit.style.backgroundImage			= "url('../img/tabmenu_resume_01on.gif')";
						commercial.style.backgroundImage		= "url('../img/tabmenu_resume_01on.gif')";
						recruit.style.backgroundPositionX		= "-700";
						recruit.style.backgroundPositionY		= "bottom";
						commercial.style.backgroundPositionX	= "-850";
						commercial.style.backgroundPositionY	= "bottom";

						recruit_bottom.style.backgroundImage			= "url('../img/tabmenu_resume_01on_bottom.gif')";
						commercial_bottom.style.backgroundImage		= "url('../img/tabmenu_resume_01on_bottom.gif')";
						recruit_bottom.style.backgroundPositionX		= "-700";
						recruit_bottom.style.backgroundPositionY		= "bottom";
						commercial_bottom.style.backgroundPositionX		= "-850";
						commercial_bottom.style.backgroundPositionY		= "bottom";

						regist_page.style.display				= "block";
						commercial_page.style.display			= "none";
					}else if (state == "commercial") {
						recruit.style.backgroundImage			= "url('../img/tabmenu_resume_regist_02on.gif')";
						commercial.style.backgroundImage		= "url('../img/tabmenu_resume_regist_02on.gif')";
						recruit.style.backgroundPositionX		= "-700";
						recruit.style.backgroundPositionY		= "bottom";
						commercial.style.backgroundPositionX	= "-850";
						commercial.style.backgroundPositionY	= "bottom";

						recruit_bottom.style.backgroundImage			= "url('../img/tabmenu_resume_regist_02on_bottom.gif')";
						commercial_bottom.style.backgroundImage			= "url('../img/tabmenu_resume_regist_02on_bottom.gif')";
						recruit_bottom.style.backgroundPositionX		= "-700";
						recruit_bottom.style.backgroundPositionY		= "bottom";
						commercial_bottom.style.backgroundPositionX		= "-850";
						commercial_bottom.style.backgroundPositionY		= "bottom";

						regist_page.style.display				= "none";
						commercial_page.style.display			= "block";
					}else if (state == "recruit_bottom")	{
						recruit.style.backgroundImage			= "url('../img/tabmenu_resume_01on.gif')";
						commercial.style.backgroundImage		= "url('../img/tabmenu_resume_01on.gif')";
						recruit.style.backgroundPositionX		= "-700";
						recruit.style.backgroundPositionY		= "bottom";
						commercial.style.backgroundPositionX	= "-850";
						commercial.style.backgroundPositionY	= "bottom";

						recruit_bottom.style.backgroundImage			= "url('../img/tabmenu_resume_01on_bottom.gif')";
						commercial_bottom.style.backgroundImage		= "url('../img/tabmenu_resume_01on_bottom.gif')";
						recruit_bottom.style.backgroundPositionX		= "-700";
						recruit_bottom.style.backgroundPositionY		= "bottom";
						commercial_bottom.style.backgroundPositionX		= "-850";
						commercial_bottom.style.backgroundPositionY		= "bottom";

						regist_page.style.display						= "block";
						commercial_page.style.display					= "none";
					}else if (state == "commercial_bottom")	{
						recruit.style.backgroundImage			= "url('../img/tabmenu_resume_regist_02on.gif')";
						commercial.style.backgroundImage		= "url('../img/tabmenu_resume_regist_02on.gif')";
						recruit.style.backgroundPositionX		= "-700";
						recruit.style.backgroundPositionY		= "bottom";
						commercial.style.backgroundPositionX	= "-850";
						commercial.style.backgroundPositionY	= "bottom";

						recruit_bottom.style.backgroundImage			= "url('../img/tabmenu_resume_regist_02on_bottom.gif')";
						commercial_bottom.style.backgroundImage			= "url('../img/tabmenu_resume_regist_02on_bottom.gif')";
						recruit_bottom.style.backgroundPositionX		= "-700";
						recruit_bottom.style.backgroundPositionY		= "bottom";
						commercial_bottom.style.backgroundPositionX		= "-850";
						commercial_bottom.style.backgroundPositionY		= "bottom";

						regist_page.style.display						= "none";
						commercial_page.style.display					= "block";
					}
				}
			//-->
			</script>
			<!-- //이력서정보 / 유료서비스 등록페이지 : 탭메뉴 관련 JS end -->
<? }
?>