<? /* Created by SkyTemplate v1.1.0 on 2023/04/17 19:15:54 */
function SkyTpl_Func_2365258418 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script type="text/javascript" src="js/happy_member.js"></script>
<script type="text/javascript" src="m/js/skin_tab.js"></script>
<script type='text/javascript'>
	function sendit( frm )
	{
		//최종학력
		if ( frm.grade_lastgrade.selectedIndex < 1 )
		{
			alert('최종학력을 선택해주세요.');
			frm.grade_lastgrade.focus();
			return false;
		}

		//고용형태
		var chk_obj		= document.getElementsByName('grade_gtype[]');

		if ( chk_obj )
		{
			var is_chk		= false;

			for ( var i = 0 ; i < chk_obj.length ; i++ )
			{
				if ( chk_obj[i].checked == true )
				{
					is_chk		= true;
				}
			}

			if ( is_chk == false )
			{
				alert('고용형태를 1개 이상 선택해주세요.');
				chk_obj[0].focus();
				return false;
			}
		}

		//업/직종
		if ( frm.type1.selectedIndex < 1 )
		{
			alert('업/직종을 선택해주세요.');
			frm.type1.focus();
			return false;
		}

		if ( frm.type_sub1.selectedIndex < 1 )
		{
			alert('업/직종을 선택해주세요.');
			frm.type_sub1.focus();
			return false;
		}

		//희망근무지
		if ( frm.job_where1_0.selectedIndex < 1 )
		{
			alert('희망근무지를 선택해주세요.');
			frm.job_where1_0.focus();
			return false;
		}

		if ( frm.job_where1_1.selectedIndex < 1 )
		{
			alert('희망근무지를 선택해주세요.');
			frm.job_where1_1.focus();
			return false;
		}

		//희망연봉
		if ( frm.grade_money.value == '' && frm.grade_money2.selectedIndex < 1 )
		{
			alert('희망연봉을 입력해주세요.');
			return false;
		}

		if ( frm.title.value == '' )
		{
			alert('이력서제목을 입력해주세요.');

			guzic_viewLayer('guzic_layer_1',0);
			guzic_changeImg('guzic_img_1',0);

			frm.title.focus();
			return false;
		}
		if ( frm.user_birth_year.value == '' )
		{
			alert('태어난 년도를 입력해주세요.');

			guzic_viewLayer('guzic_layer_1',0);
			guzic_changeImg('guzic_img_1',0);

			frm.user_birth_year.focus();
			return false;
		}
		if ( frm.user_phone.value == '' )
		{
			alert('전화번호를 입력해주세요.');

			guzic_viewLayer('guzic_layer_1',0);
			guzic_changeImg('guzic_img_1',0);

			frm.user_phone.focus();
			return false;
		}
		if ( frm.profile.value == '' )
		{
			alert('자기소개를 입력해주세요.');

			guzic_viewLayer('guzic_layer_1',0);
			guzic_changeImg('guzic_img_1',0);

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


	//<!-- 업/직종 선택 갯수 제한 -->

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


	//<!-- 키워드 선택 갯수 제한 (아래 것으로 사용) -->

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


	//<!-- 키워드 선택 갯수 / 학력사항 관련 -->
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

	//<!-- 학력사항 관련 by kwak : edited yoon : 2011-10-27-->

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
				gradeView_6('no');
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
			gradeView_6('none');
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
			gradeView_6('none');
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
			gradeView_6('none');
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
			gradeView_6('none');
		}
		else
		{
			notify_disable_default.style.display = "none";
			grade4ViewCheckNum = 0;		//추가버튼 초기화

			gradeView_1('view','view');
			gradeView_2('view');
			gradeView_3('view');

			if(document.document_frm.grade4_schoolName.value != '')
			{
				gradeView_4('view');
			}
			else
			{
				gradeView_4('none');
			}

			if(document.document_frm.grade5_schoolName.value != '')
			{
				gradeView_5('view');
			}
			else
			{
				gradeView_5('none');
			}

			if(document.document_frm.grade6_schoolName.value != '')
			{
				gradeView_6('view');
			}
			else
			{
				gradeView_6('none');
			}
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
		frm.grade1_schoolOur.disabled	= disab;
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

	//대학원이상 추가학력
	function gradeView_6( Ch )
	{
		disab	= ( Ch == "view" )?false:true;
		displ	= ( Ch == "view" )?"":"none";

		var frm	= document.document_frm;

		document.getElementById("gViewLayer6").style.display	= displ;

		frm.grade6_startYear.disabled			= disab;
		frm.grade6_endYear.disabled				= disab;
		frm.grade6_endMonth.disabled			= disab;
		//frm.grade6_lastSchoolType.disabled		= disab;
		frm.grade6_point.disabled				= disab;
		frm.grade6_pointBest.disabled			= disab;
		frm.grade6_schoolName.disabled			= disab;
		frm.grade6_schoolType.disabled			= disab;
		frm.grade6_schoolKwa.disabled			= disab;
		frm.grade6_schoolEnd.disabled			= disab;
		frm.grade6_schoolCity.disabled			= disab;
		frm.grade6_schoolOur.disabled			= disab;
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
				gradeView_4('view');
			}
			else if (grade4ViewCheckNum < 3)
			{
				gradeView_5('view');
			}
			else if (grade4ViewCheckNum < 4)
			{
				gradeView_6('view');
			}
			else
			{
				grade4ViewCheckNum = 4;
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
	var color2	= '#FFFFFF';

	function work_layer_add1()
	{
		//originalHTML	= document.getElementById("kwak1").innerHTML;
		originalHTML	= $("#kwak1").html();
		originalHTML	= originalHTML.replace(/\kwak/g,nowLayerNo1);
		nowLayerNo1++;

		nowColor		= ( nowLayerNo1 % 2 == 0 )?color1:color2;
		originalHTML	= "<div style=' padding:5px 0 10px 0'>"+originalHTML+"</div>";
		document.document_frm.worklist_size1.value	= nowLayerNo1;
		//document.getElementById("kwak_view1").innerHTML	+= originalHTML;
		$("#kwak_view1").before(originalHTML);

	}
//-->
</script>

<!-- 외국어능력 관련 : by kwak : edited yoon : 2011-10-26 -->
<script type="text/javascript">
<!--
	nowLayerNo2	= 1;
	var color1	= '#FFFFFF';
	var color2	= '#FFFFFF';

	function work_layer_add2()
	{
		//originalHTML	= document.getElementById("kwak2").innerHTML;
		originalHTML	= $("#kwak2").html();
		originalHTML	= originalHTML.replace(/\kwak/g,nowLayerNo2);
		nowLayerNo2++;

		nowColor		= ( nowLayerNo2 % 2 == 0 )?color1:color2;
		originalHTML	= "<div style='padding:5px 0 10px 0'>"+originalHTML+"</div>";
		document.document_frm.worklist_size2.value	= nowLayerNo2;

		//document.getElementById("kwak_view2").innerHTML	+= originalHTML;
		$("#kwak_view2").before(originalHTML);
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
		//originalHTML	= document.getElementById("kwak3").innerHTML;
		originalHTML	= $("#kwak3").html();
		originalHTML	= originalHTML.replace(/\kwak/g,nowLayerNo3);
		nowLayerNo3++;

		nowColor		= ( nowLayerNo3 % 2 == 0 )?color1:color2;
		originalHTML	= "<div style='border-bottom:1px solid #e9e9e9; padding:5px 0'>"+originalHTML+"</div>";
		document.document_frm.worklist_size3.value	= nowLayerNo3;
		//document.getElementById("kwak_view3").innerHTML	+= originalHTML;
		$("#kwak_view3").before(originalHTML);

	}

	//입력형 희망연봉 값 초기화
	function gradeMoneyReset() {
		document.getElementById("grade_money").value = "";
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
				Ext != "png" &&
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

	var aai = 0;
	var aaj = 0;
	var aaz = 0;

	//근무지역 추가
	function formAreaAdd(){
		aai++;
		if(aai < area_sel.length) {
			area_sel[aai].style.display = "block";
		}else{
			alert("최대 3개 까지이며 더 이상 추가하실 수 없습니다.");
		}

	}

	//업,직종선택 추가
	function formJobtypeAdd(){
		aaj++;
		if(aaj < jobtype_sel.length) {
			jobtype_sel[aaj].style.display = "block";
		}else{
			alert("최대 3개 까지이며 더 이상 추가하실 수 없습니다.");
		}

	}

	//첨부파일등록 추가
	function formImageFormAdd(state)
	{
		var frm	= document.document_frm;

		if (state == "add")
		{
			aaz++;
			//alert(z);
			if(aaz < image_regist.length) {
				image_regist[aaz].style.display = "block";
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

			aaz = 0;
		}
	}

	var area_sel		= new Array();
	var jobtype_sel		= new Array();
	function display_start()
	{
		mod_number = '<?=$_data['_GET']['number']?>';
		disp =  mod_number == '' ? 'none' : '';

		//근무지역
		area_sel[0] = document.getElementById("area_sel1");
		area_sel[1] = document.getElementById("area_sel2");
		area_sel[2] = document.getElementById("area_sel3");
		area_sel[1].style.display = disp;
		area_sel[2].style.display = disp;

		//업,직종선택
		jobtype_sel[0] = document.getElementById("jobtype_sel1");
		jobtype_sel[1] = document.getElementById("jobtype_sel2");
		jobtype_sel[2] = document.getElementById("jobtype_sel3");
		jobtype_sel[1].style.display = disp;
		jobtype_sel[2].style.display = disp;

		//첨부파일등록
		var image_regist		= new Array();
		image_regist[0] = document.getElementById("num1");
		image_regist[1] = document.getElementById("num2");
		image_regist[2] = document.getElementById("num3");
		image_regist[3] = document.getElementById("num4");
		image_regist[4] = document.getElementById("num5");
	}

	addLoadEvent(display_start);//happy_job.js

//선택사항 레이어 오픈 스크립트
function etc_option_change(obj,layer_id)
{
	if( obj.checked == true )
	{
		document.getElementById(layer_id).style.display		= "";
	}
	else
	{
		document.getElementById(layer_id).style.display		= "none";
	}
}

//-->
</script>
<style>
	.sub_tab_menu03 > ul > li.tab_on1{border-top:4px solid #<?=$_data['배경색']['모바일_기본색상']?>;}
	h5.front_bar_st_tlt:before{background:#<?=$_data['배경색']['모바일_기본색상']?>;}
</style>
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
	

		<h3 class="sub_tlt_st01" >
			<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>">이력서 </b>
			<span><?=$_data['mode_title']?>하기</span>
		</h3>

		<div class="sub_tab_menu03">
			<ul>
				<li class="tab_on1" id="class_div1" onclick="TabChange_class('class','class_div','1','1');">이력서정보입력</li>
<!-- 				<li class="tab_off1" id="class_div2" onclick="TabChange_class('class','class_div','2','1');">유료서비스 결제</li> -->
			</ul>
		</div>	
		<div id="class1" class="guzic_regist_content_wrap" style="">

<table style="width:100%; margin-top:30px;" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
						<colgroup>
							<col style="width:30%">
							<col style="width:70%">
						</colgroup>
						<tr>
							<th class="h_form" colspan="2" style="background:#<?=$_data['배경색']['메인페이지']?>;">
								<input type="text" name="title" value="<?=$_data['DataType1']['title']?>" style="width:100%; border:1px solid #ddd;" placeholder="이력서 제목을 입력해주세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '이력서 제목을 입력해주세요'"">
							</th>						
						</tr>
				</table>


			<ul>
				<li><!-- 학력사항 레이어 [s]-->
					<h5 class="front_bar_st_tlt">기본정보</h5>
					<table class="tb_st_04">
						<colgroup>
							<col width="30%;"/>
							<col width="70%;"/>
						</colgroup>
						<tbody>
							<tr>
								<th>사진</th>
								<td>								
									<img src="<?=$_data['이미지정보']?>" width="100" height="130" title="<?=$_data['Data']['user_name']?>">							
									<p class="exp_txt_st_01">사진은 마이페이지 메인에서 수정 가능합니다.</p>							
								</td>
							</tr>
							<tr>
								<th>휴대폰</th>
								<td class="h_form info">
									<input type="text" name="user_hphone" value="<?=$_data['DataType1']['user_hphone']?>" >
								</td>
							</tr>
							<tr>
								<th>생년월일</th>
								<td class="h_form info">
									<input type="text" name="user_birth_year" value="<?=$_data['DataType1']['user_birth_year']?>" style="width:55px;"> - <input type="text" name="user_birth_month" value="<?=$_data['DataType1']['user_birth_month']?>" style="width:40px;"> - <input type="text" name="user_birth_day" value="<?=$_data['DataType1']['user_birth_day']?>" style="width:40px;">
								</td>
							</tr>
							<tr>
								<th>전화번호</th>
								<td class="h_form info">
									<input type="text" name="user_phone" value="<?=$_data['DataType1']['user_phone']?>">
								</td>
							</tr>
							<tr>
								<th>홈페이지</th>
								<td class="h_form info">
									<input type="text" name="user_homepage" value="<?=$_data['DataType1']['user_homepage']?>" style="">
								</td>
							</tr>
							<tr>
								<th>주소</th>
								<td class="info h_form">
									<p style="margin-bottom:5px; position:relative; padding-right:95px; max-width:460px; ">
										<input type="text" name="user_zipcode" value="<?=$_data['DataType1']['user_zipcode']?>" style="width:100%;">
										<span class="btn_zipcode" style="padding:0 10px; height:40px; line-height:40px; text-align:center; color:#fff; letter-spacing:-1.2px; background:#666666; border-radius:5px; display:inline-block; position:absolute; right:0; top:0; bottom:0; margin:auto;" onClick="window.open('http://<?=$_data['zipcode_site']?>/zonecode/happy_zipcode.php?ht=1&hys=<?=$_data['base64_main_url']?>&hyf=user_zipcode|user_addr1|user_addr2|<?=$_data['zipcode_add_get']?>','happy_zipcode_popup_<?=$_data['base64_main_url']?>', 'width=600,height=600,scrollbars=yes');">우편번호검색	</span>
									</p>
									<input type="text" name="user_addr1" value="<?=$_data['DataType1']['user_addr1']?>" style="width:100%; margin-bottom:5px;">
									<input type="text" name="user_addr2" value="<?=$_data['DataType1']['user_addr2']?>"	style="width:100%;">							
								</td>
							</tr>
							<tr>
								<th>이메일</th>
								<td class="h_form info">
									<input type="text" name="user_email1" value="<?=$_data['DataType1']['user_email1']?>" >
								</td>
							</tr>
							<tr>
								<th>추가이메일</th>
								<td class="h_form info">
									<input type="text" name="user_email2" value="<?=$_data['DataType1']['user_email2']?>" >
								</td>
							</tr>
						
						</tbody>
					</table>
				</li>
				<li>
					<div id="notify_disable_default" style="display:none;"></div><!-- 초기화 상태 알림내용 -->
					<h5 class="front_bar_st_tlt">학력사항</h5>


				
<!------------------------ 새로추가:: 프로그램 ---------------------------->
<style>
.new_edu_background_sec { border-top:1px solid #ddd; margin-top:15px;}
.new_edu_background_sec div,
.new_edu_background_sec div p { overflow:hidden; box-sizing:border-box;}
.new_edu_background_sec div{ 
padding:55px 10px 10px 10px; position:relative; border-bottom:1px solid #ddd;}
.new_edu_background_sec div p select,
.new_edu_background_sec div p input {margin-top:2px; margin-bottom:2px;}
.new_edu_background_sec div p{padding:3px 10px; width:100%;}
.new_edu_background_sec div p.inline01 input[type='text']{width:calc(50% - 2px);}
.new_edu_background_sec div p.inline02 input[type='text']{width:calc(100% -2px)}
.new_edu_background_sec div select{width:100%;}
.new_edu_background_sec div a {display:inline-block; position:absolute;
top:10px; right:20px; border:none;
background: #e9f2ff;color:#4587DE; 
font-weight:500;
font-size:15px; line-height:37px; padding:0; width:70px;  text-align:center;  }
.new_edu_background_sec div a span {padding-right:6px;}
</style>
<!-- new_edu_background_sec ------>
<!-- 
학교 종류 (고등학교, 대학교 등) 구분 삭제
졸업상태 :  
졸업, 졸업예정, 재학중(재학중 선택 시 ‘졸업년월' 필드 입력상태가 비활성화 되어야 함)
중퇴, 수료, 휴학
학위  : 학사, 석사,박사
----->


<!-- 프로그램새로추가한거 -->
	<div style="margin-top:20px; border:1px solid red;">
					<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_rsum">
					<tr>
						<td>
							<table id="table_academy">
							<tr id="0" class="academy_tr_clone" style="display:none;">
								<td class="h_form">
									<input type="text" name="academy_in[]" id="academy_in_0" maxlength="7" placeholder="입학년월(YYYY/MM)" style="width: 150px;">
									<input type="text" name="academy_out[]" id="academy_out_0" maxlength="7" placeholder="졸업년월(YYYY/MM)" style="width: 150px;">
									<select name="academy_out_type[]" id="academy_out_type_0" style="width: 150px;">
										<option value="">졸업상태</option>
										<option value="졸업">졸업</option>
										<option value="졸업예정">졸업예정</option>
										<option value="재학중">재학중</option>
										<option value="중퇴">중퇴</option>
										<option value="수료">수료</option>
										<option value="휴학">휴학</option>
									</select>
									<input type="text" name="academy_name[]" id="academy_name_0" placeholder="학교명" style="width: 250px;">
									<select name="academy_degree[]" id="academy_degree_0" style="width: 150px;">
										<option value="">학위</option>
										<option value="학사">학사</option>
										<option value="석사">석사</option>
										<option value="박사">박사</option>
									</select>
								</td>
								<td>
									%BTN_HTML%
								</td>
							</tr>
							<?=$_data['per_academy_html']?>

							</table>
						</td>
					</tr>
					</table>
				</div>

<!-- //프로그램새로추가한거 -->






<div class="new_edu_background_sec  h_form">
		<div>
			<a href="'#"><span>+</span>추가</a>

			<p class="inline01">
				<input type="text" placeholder="입학년월(YYY,MM)">
				<input type="text" placeholder="졸업년월(YYY,MM)">
				<select id="grade3_schoolEnd" name="grade3_schoolEnd">
					<option value="">졸업상태</option>
					<option value="졸업">졸업</option>
					<option value="졸업예정">졸업예정</option>
					<option value="편입">편입</option>
					<option value="휴학">휴학</option>
					<option value="중퇴">중퇴</option>
				</select>
			</p>
			<p class="inline02">
				<input type="text" placeholder="학교명">
				<select>
					<option >학위</option>
					<option value="학사">학사</option>
					<option value="석사">석사</option>
					<option value="박사">박사</option>
				</select>
			</p>
		</div>
		<div>
			<a href="'#"><span>-</span>삭제</a>
			<p class="inline01">
				<input type="text" placeholder="입학년월(YYY,MM)">
				<input type="text" placeholder="졸업년월(YYY,MM)">
				<select id="grade3_schoolEnd" name="grade3_schoolEnd">
					<option value="">졸업상태</option>
					<option value="졸업">졸업</option>
					<option value="졸업예정">졸업예정</option>
					<option value="편입">편입</option>
					<option value="휴학">휴학</option>
					<option value="중퇴">중퇴</option>
				</select>
			</p>
			<p class="inline02">
				<input type="text" placeholder="학교명">
				<select>
					<option >학위</option>
					<option value="학사">학사</option>
					<option value="석사">석사</option>
					<option value="박사">박사</option>
				</select>
			</p>
		</div>


</div>
<!-- //new_edu_background_sec -->

<!------------------------ //새로추가:: 프로그램 ---------------------------->



				<!-- 	<table class="tb_st_04">
						<colgroup>
							<col width="30%;"/>
							<col width="70%;"/>
						</colgroup>
						<tbody>
							<tr>
								<th style="background:#<?=$_data['배경색']['모바일_메인페이지']?>;">최종학력</th>
								<td>
									<div style="text-align:right;">
										<p class="h_form"><select name="grade_lastgrade" onChange="gradeView()" style="width:100%; margin-bottom:10px;"><?=$_data['최종학력옵션']?></select>	</p>
										<input type="button" name="resetButton" value="다시입력" onClick="gradeViewReset()" style="border:1px solid #ddd; border-radius:3px; display:inline-block; padding:5px 10px; color:#666; background:#f5f5f5; width:100%">
										<input type="button" name="" value="추가" onClick="grade4ViewCheck()" style="border:1px solid #<?=$_data['배경색']['모바일_기본색상']?>; border-radius:3px; display:inline-block; padding:5px 10px; color:#fff; width:100%; margin-top:5px; background:#<?=$_data['배경색']['모바일_기본색상']?>;">
										<p class="font_14 exp_txt_st_01" style="text-align:left; color:#999; margin-top:5px; letter-spacing:-1px; line-height:1.333em; word-break:keep-all;">
											 최종학력을 선택하셔야 아래 사항 입력이 가능합니다.( 4년제 다중 학적자는 [추가] 버튼을 눌러 작성 )
										</p>									
									</div>								
								</td>
							</tr>						
							<tr id="gViewLayer1">
								<th>고등학교</th>
								<td>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade1_schoolCity" name="grade1_schoolCity"><?=$_data['지역선택옵션']?></select>
												</td>
												<td class="h_form select_width" style="padding-left:3px;">
													<?=$_data['DataType4']['select_grade1_schoolOur']?>

												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form">
													<input type="text" id="grade1_schoolName" name="grade1_schoolName" value="" >
												</td>
												<td class="regist_info" style="width:60px; padding-left:5px">
													고등학교
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade1_endYear" name="grade1_endYear"><?=$_data['년도옵션']?></select>
												</td>
												<td class="h_form select_width" style="padding-left:3px;">
													<select id='grade1_schoolEnd' name="grade1_schoolEnd">
														<option value="졸업">졸업</option>
														<option value="졸업예정">졸업예정</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr id="gViewLayer2">
								<th>대학 (2,3년)</th>
								<td>
									<div style="margin:5px 0">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td>
													<div style="padding-right:25px; position:relative;" class="h_form select_width">
														<select id="grade2_startYear" name="grade2_startYear"><?=$_data['년도옵션']?></select>
														<span style="position:absolute; top:5px; right:8px">~</span>
													</div>
												</td>
												<td  class="h_form select_width">
													<select id="grade2_endYear" name="grade2_endYear"><?=$_data['년도옵션']?></select>
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade2_endMonth" name="grade2_endMonth"><?=$_data['월옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade2_schoolCity" name="grade2_schoolCity"><?=$_data['지역선택옵션']?></select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade2_schoolName" name="grade2_schoolName" value="" >
												</td>
												<td class="regist_info" style="width:30px; padding-left:5px">
													대학
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<?=$_data['DataType4']['select_grade2_schoolOur']?>

												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade2_schoolType" name="grade2_schoolType"><?=$_data['계열선택옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form">
													<input type="text" id="grade2_schoolKwa" name="grade2_schoolKwa" title="학과를 입력하세요." style="color:#999" placeholder="학과를 입력하세요." onfocus="this.placeholder = ''"onblur="this.placeholder = '학과를 입력하세요.'">
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade2_schoolEnd" name="grade2_schoolEnd">
														<option value="졸업">졸업</option>
														<option value="졸업예정">졸업예정</option>
														<option value="편입">편입</option>
														<option value="휴학">휴학</option>
														<option value="중퇴">중퇴</option>
													</select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade2_point" name="grade2_point" size="2" value="" style="width:100%; "maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" placeholder="학점" onfocus="this.placeholder = ''"onblur="this.placeholder = '학점'">
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade2_pointBest" name="grade2_pointBest" class="">
														<option value="4">4.0</option>
														<option value="4.3">4.3</option>
														<option value="4.5">4.5</option>
														<option value="100">100</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr id="gViewLayer3">
								<th>대학</th>
								<td>
									<div style="margin:5px 0">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td>
													<div style="padding-right:25px; position:relative;" class="h_form select_width">
														<select id="grade3_startYear" name="grade3_startYear"><?=$_data['년도옵션']?></select>
														<span style="position:absolute; top:5px; right:8px">~</span>
													</div>
												</td>
												<td  class="h_form select_width">
													<select id="grade3_endYear" name="grade3_endYear"><?=$_data['년도옵션']?></select>
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade3_endMonth" name="grade3_endMonth"><?=$_data['월옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade3_schoolCity" name="grade3_schoolCity"><?=$_data['지역선택옵션']?></select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade3_schoolName" name="grade3_schoolName" value="" >
												</td>
												<td class="regist_info" style="width:30px; padding-left:5px">
													대학
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<?=$_data['DataType4']['select_grade3_schoolOur']?>

												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade3_schoolType" name="grade3_schoolType"><?=$_data['계열선택옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form">
													<input type="text" id="grade3_schoolKwa" name="grade3_schoolKwa" title="학과를 입력하세요." style="color:#999" placeholder="학과를 입력하세요." onfocus="this.placeholder = ''"onblur="this.placeholder = '학과를 입력하세요.'">
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade3_schoolEnd" name="grade3_schoolEnd">
														<option value="졸업">졸업</option>
														<option value="졸업예정">졸업예정</option>
														<option value="편입">편입</option>
														<option value="휴학">휴학</option>
														<option value="중퇴">중퇴</option>
													</select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade3_point" name="grade3_point" size="2" value="" style="width:100%; "maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" placeholder="학점" onfocus="this.placeholder = ''"onblur="this.placeholder = '학점'">
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade3_pointBest" name="grade3_pointBest" class="">
														<option value="4">4.0</option>
														<option value="4.3">4.3</option>
														<option value="4.5">4.5</option>
														<option value="100">100</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr id="gViewLayer4">
								<th>대학</th>
								<td>
									<div style="margin:5px 0">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td>
													<div style="padding-right:25px; position:relative;" class="h_form select_width">
														<select id="grade4_startYear" name="grade4_startYear"><?=$_data['년도옵션']?></select>
														<span style="position:absolute; top:5px; right:8px">~</span>
													</div>
												</td>
												<td  class="h_form select_width">
													<select id="grade4_endYear" name="grade4_endYear"><?=$_data['년도옵션']?></select>
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade4_endMonth" name="grade4_endMonth"><?=$_data['월옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade4_schoolCity" name="grade4_schoolCity"><?=$_data['지역선택옵션']?></select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade4_schoolName" name="grade4_schoolName" value="" >
												</td>
												<td class="regist_info" style="width:30px; padding-left:5px">
													대학
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<?=$_data['DataType4']['select_grade4_schoolOur']?>

												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade4_schoolType" name="grade4_schoolType"><?=$_data['계열선택옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form">
													<input type="text" id="grade4_schoolKwa" name="grade4_schoolKwa" title="학과를 입력하세요." style="color:#999" placeholder="학과를 입력하세요." onfocus="this.placeholder = ''"onblur="this.placeholder = '학과를 입력하세요.'">
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade4_schoolEnd" name="grade4_schoolEnd">
														<option value="졸업">졸업</option>
														<option value="졸업예정">졸업예정</option>
														<option value="편입">편입</option>
														<option value="휴학">휴학</option>
														<option value="중퇴">중퇴</option>
													</select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade4_point" name="grade4_point" size="2" value="" style="width:100%; "maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" placeholder="학점" onfocus="this.placeholder = ''"onblur="this.placeholder = '학점'">
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade4_pointBest" name="grade4_pointBest" class="">
														<option value="4">4.0</option>
														<option value="4.3">4.3</option>
														<option value="4.5">4.5</option>
														<option value="100">100</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr id="gViewLayer5">
								<th>대학원</th>
								<td>
									<div style="margin:5px 0">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td>
													<div style="padding-right:25px; position:relative;" class="h_form select_width">
														<select id="grade5_startYear" name="grade5_startYear"><?=$_data['년도옵션']?></select>
														<span style="position:absolute; top:5px; right:8px">~</span>
													</div>
												</td>
												<td  class="h_form select_width">
													<select id="grade5_endYear" name="grade5_endYear"><?=$_data['년도옵션']?></select>
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade5_endMonth" name="grade5_endMonth"><?=$_data['월옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade5_schoolCity" name="grade5_schoolCity"><?=$_data['지역선택옵션']?></select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade5_schoolName" name="grade5_schoolName" value="" >
												</td>
												<td class="regist_info" style="width:30px; padding-left:5px">
													대학
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<?=$_data['DataType4']['select_grade5_schoolOur']?>

												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade5_schoolType" name="grade5_schoolType"><?=$_data['계열선택옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form">
													<input type="text" id="grade5_schoolKwa" name="grade5_schoolKwa" title="학과를 입력하세요." style="color:#999" placeholder="학과를 입력하세요." onfocus="this.placeholder = ''"onblur="this.placeholder = '학과를 입력하세요.'">
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade5_schoolEnd" name="grade5_schoolEnd">
														<option value="졸업">졸업</option>
														<option value="졸업예정">졸업예정</option>
														<option value="편입">편입</option>
														<option value="휴학">휴학</option>
														<option value="중퇴">중퇴</option>
													</select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade5_point" name="grade5_point" size="2" value="" style="width:100%; "maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" placeholder="학점" onfocus="this.placeholder = ''"onblur="this.placeholder = '학점'">
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade5_pointBest" name="grade5_pointBest" class="">
														<option value="4">4.0</option>
														<option value="4.3">4.3</option>
														<option value="4.5">4.5</option>
														<option value="100">100</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
							<tr id="gViewLayer6">
								<th>대학원</th>
								<td>
									<div style="margin:5px 0">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td>
													<div style="padding-right:25px; position:relative;" class="h_form select_width">
														<select id="grade6_startYear" name="grade6_startYear"><?=$_data['년도옵션']?></select>
														<span style="position:absolute; top:5px; right:8px">~</span>
													</div>
												</td>
												<td  class="h_form select_width">
													<select id="grade6_endYear" name="grade6_endYear"><?=$_data['년도옵션']?></select>
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade6_endMonth" name="grade6_endMonth"><?=$_data['월옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade6_schoolCity" name="grade6_schoolCity"><?=$_data['지역선택옵션']?></select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade6_schoolName" name="grade6_schoolName" value="" >
												</td>
												<td class="regist_info" style="width:30px; padding-left:5px">
													대학
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<?=$_data['DataType4']['select_grade6_schoolOur']?>

												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade6_schoolType" name="grade6_schoolType"><?=$_data['계열선택옵션']?></select>
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form">
													<input type="text" id="grade6_schoolKwa" name="grade6_schoolKwa" title="학과를 입력하세요." style="color:#999" placeholder="학과를 입력하세요." onfocus="this.placeholder = ''"onblur="this.placeholder = '학과를 입력하세요.'">
												</td>
											</tr>
										</table>
									</div>
									<div style="margin-bottom:5px">
										<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
											<tr>
												<td class="h_form select_width">
													<select id="grade6_schoolEnd" name="grade6_schoolEnd">
														<option value="졸업">졸업</option>
														<option value="졸업예정">졸업예정</option>
														<option value="편입">편입</option>
														<option value="휴학">휴학</option>
														<option value="중퇴">중퇴</option>
													</select>
												</td>
												<td class="h_form" style="padding-left:3px">
													<input type="text" id="grade6_point" name="grade6_point" size="2" value="" style="width:100%; "maxlength="3" onKeyPress="if( ((event.keyCode<48) || (event.keyCode>57) )&& event.keyCode!=46 ) event.returnValue=false;" placeholder="학점" onfocus="this.placeholder = ''"onblur="this.placeholder = '학점'">
												</td>
												<td class="h_form select_width" style="padding-left:3px">
													<select id="grade6_pointBest" name="grade6_pointBest" class="">
														<option value="4">4.0</option>
														<option value="4.3">4.3</option>
														<option value="4.5">4.5</option>
														<option value="100">100</option>
													</select>
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</tbody>
					</table>				 -->
					<?=$_data['defaultSettingType4']?>

					<script type="text/javascript">
					//<!--
						gradeView();
					//-->
					</script>
				</li><!-- 학력사항 레이어 [e]-->
				<li><!-- 경력사항 [s] -->
					<h5 class="front_bar_st_tlt">경력사항</h5>
<!------------------------ 새로추가:: 프로그램 ---------------------------->
<style>
.new_career_background_sec div,
.new_career_background_sec div p { overflow:hidden; box-sizing:border-box;}
.new_career_background_sec div{ 
padding:55px 10px 10px 10px; position:relative;
border-bottom:1px solid #ddd;}
.new_career_background_sec div p{padding:3px 10px;}
.new_career_background_sec div p.inline01  {padding-top:10px; padding-bottom:10px;}
.new_career_background_sec div p.inline01 span.part-clear {
display:inline-block; width:30px;}

.new_career_background_sec div p.inline02 select{width:400px;}
.new_career_background_sec div p.inlinn03 {border:1px solid red;}

.new_career_background_sec div p.inline03,
.new_career_background_sec div p.inline04,
.new_career_background_sec div p.inline05{display:flex;
flex-direction: row;
flex-wrap: nowrap; justify-content: space-between; 
}

.new_career_background_sec div p.inline03 select{width:calc(33% - 2px);}
.new_career_background_sec div p.inline02 input[type='text']{width:180px;}
.new_career_background_sec div p.inline04 input[type='text'],
.new_career_background_sec div p.inline05 input[type='text'],
.new_career_background_sec div p.inline05 select {width:calc(50% - 2px)}

.new_career_background_sec div select{width:240px;}
.new_career_background_sec div a {display:inline-block; position:absolute;
top:15px; right:20px; border:none;
background: #e9f2ff;color:#4587DE; 
font-weight:500;
font-size:15px; line-height:37px; padding:0; width:70px;  text-align:center;  }
.new_career_background_sec div a span {padding-right:10px;}
.new_career_background_sec div textarea {width:100% ; height:100px;}
</style>


<!-- 
 국내 / 해외 구분 필요
‘추가하기' & ‘삭제하기' 버튼 필요 : repeater 기능
[1차분류] - [2차분류] - [3차분류] 선택 형식
1차분류값은 회원정보에 따라 자동 불러오기하여 선택값이 적용되어있어야 함
2차분류 중 3차분류에 해당하는 value가 없는 경우에는 3차분류 select 창이 비활성화 되어야 함 
1차분류(의사선택) - value : 의사, 치과의사
2차분류 : 대표진료과 / 3차분류 : 세부진료과
치과의사일 경우 : 3차분류 없음 (비활성화)
일반의 
구강내과 
구강병리과 
구강악안면외과 
소아치과 
영상치의학과 
예방치과 
치과교정과 
치과보존과 
치과보철과 
치주과 
통합치의학과
의사일 경우 :
일반의 : 해당없음 (비활성화)
가정의학과 : 해당없음 (비활성화)
건강의학과 : 해당없음 (비활성화)
결핵과 : 해당없음 (비활성화)
내과 :
감염내과
내분비내과
류마티스내과
소화기내과
순환기내과
신장내과
심장내과
알레르기내과
혈액종양내과
호흡기내과
마취통증의학과 : 해당없음 (비활성화)
방사선종양학과 : 해당없음 (비활성화)
병리과 : 해당없음 (비활성화)
비뇨의학과 : 해당없음 (비활성화)
산부인과 
산과
부인과
성형외과 : 해당없음 (비활성화)
소아청소년과 : 해당없음 (비활성화)
신경과 : 해당없음 (비활성화)
신경외과 : 해당없음 (비활성화)
안과 : 해당없음 (비활성화)
영상의학과 : 해당없음 (비활성화)
외과 :
간담도체외과
간이식/간담도외과
내분비외과
대장항문과
소아외과
소화기외과
신/췌장이식외과
심장외과
유방외과
위장관외과
이식혈관외과
응급의학과 : 해당없음 (비활성화)
이비인후과 : 해당없음 (비활성화)
임상약리학과 : 해당없음 (비활성화)
재활의학과 : 해당없음 (비활성화)
정신건강의학과 : 해당없음 (비활성화)
정형외과 : 해당없음 (비활성화)
직업환경의학과 : 해당없음 (비활성화)
진단검사의학과 : 해당없음 (비활성화)
피부과 
피부미용
피부질환
핵의학과 : 해당없음 (비활성화)
흉부외과 : 해당없음 (비활성화)
법의학과 : 해당없음 (비활성화)
재직상태
재직중
퇴사 -->

<!-- new_career_background_sec ------>


<div class="new_career_background_sec  h_form">
		<div>
			<a href="'#"><span>+</span>추가</a>
			<p class="inline01">
				<label for="no_career" class="h-check"><input type="checkbox" id="no_career" name="no_career" value="0"><span></span></label>
				<label for="no_career" class="noto400 font_14" style="cursor:pointer;">경력없음</label>
				<span class="part-clear"></span>
				<label class="h-radio" for="area_selec01"><input type="radio" id="area_selec01" name="area_selec01" value="국내"> <span class="noto400 font_14">국내</span></label>
				<label class="h-radio" for="area_selec02"><input type="radio" id="area_selec02" name="area_selec02" value="해외"> <span class="noto400 font_14">해외</span></label>
			</p>

			<p class="inline02">
				<input type="text" placeholder="근무처명">
				<label for="no_company_name" class="h-check"><input type="checkbox" id="no_company_name" name="no_company_name" value="0"><span></span></label>
				<label for="no_company_name" class="noto400 font_14" style="cursor:pointer;">근무처명 비공개</label>
			</p>

			<p class="inline03">
				<select id="" name="">
					<option value="">의사선택</option>
					<option value="의사">의사</option>
					<option value="치과의사">치과의사</option>

				</select>
				<select id="" name="">
					<option value="">대표진료과</option>
					<option value="일반의">일반의 </option>
					<option value="구강내과">구강내과 </option>
					<option value="구강병리과">구강병리과 </option>
					<option value="구강악안면외과">구강악안면외과 </option>
					<option value="소아치과">소아치과 </option>
					<option value="영상치의학과">영상치의학과  </option>
					<option value="예방치과">예방치과  </option>
					<option value="치과교정과">치과교정과  </option>
					<option value="치과보존과">치과보존과  </option>
					<option value="치과보철과">치과보철과  </option>
					<option value="치주과">치주과  </option>
					<option value="통합치의학과">통합치의학과 </option>

				</select>
				<select id="" name="">
					<option value="">세부진료과</option>
					<option value="">--내과일때 시작--</option>
					<option value="감염내과">감염내과</option>
					<option value="내분비내과">내분비내과</option>
					<option value="류마티스내과">류마티스내과</option>
					<option value="소화기내과">소화기내과</option>
					<option value="순환기내과">순환기내과</option>
					<option value="신장내과">신장내과</option>
					<option value="심장내과">심장내과</option>
					<option value="알레르기내과">알레르기내과</option>
					<option value="혈액종양내과">혈액종양내과</option>
					<option value="호흡기내과">호흡기내과</option>
					<option value="">--외과일때 시작--</option>
					<option value="간담도체외과">간담도체외과</option>
					<option value="간이식/간담도외과">간이식/간담도외과</option>
					<option value="내분비외과">내분비외과</option>
					<option value="대장항문과">대장항문과</option>
					<option value="소아외과">소아외과</option>
					<option value="소화기외과">소화기외과</option>
					<option value="신/췌장이식외과">신/췌장이식외과</option>
					<option value="심장외과">심장외과</option>
					<option value="유방외과">유방외과</option>
					<option value="위장관외과">위장관외과</option>
					<option value="이식혈관외과">이식혈관외과</option>
					<option value="">--피부과일때 시작--</option>
					<option value="피부과">피부과 </option>
					<option value="피부미용">피부미용</option>
					<option value="피부질환">피부질환</option>
				</select>
			</p>
			<p class="inline04">
				<input type="text" placeholder="입사년월(YYY,MM)">
				<input type="text" placeholder="퇴사년월(YYY,MM)">
				<input type="text" placeholder="직위/직책">
				<select id="" name="">
					<option value="">재직상태</option> 
				</select>
			</p>
			<p class="inline05">
  <textarea name="" placeholder="진행 가능한 시술명, 외래진료과 등 경력 관련 상세내용을 적어주세요."></textarea>
			</p>
		</div>
		<div>
			<a href="'#"><span>-</span>삭제</a>
				<p class="inline01">
				<label for="no_career" class="h-check"><input type="checkbox" id="no_career" name="no_career" value="0"><span></span></label>
				<label for="no_career" class="noto400 font_14" style="cursor:pointer;">경력없음</label>
				<span class="part-clear"></span>
				<label class="h-radio" for="area_selec01"><input type="radio" id="area_selec01" name="area_selec01" value="국내"> <span class="noto400 font_14">국내</span></label>
				<label class="h-radio" for="area_selec02"><input type="radio" id="area_selec02" name="area_selec02" value="해외"> <span class="noto400 font_14">해외</span></label>
			</p>

			<p class="inline02">
				<input type="text" placeholder="근무처명">
				<label for="no_company_name" class="h-check"><input type="checkbox" id="no_company_name" name="no_company_name" value="0"><span></span></label>
				<label for="no_company_name" class="noto400 font_14" style="cursor:pointer;">근무처명 비공개</label>
			</p>

			<p class="inline03">
				<select id="" name="">
					<option value="">의사선택</option>
					<option value="의사">의사</option>
					<option value="치과의사">치과의사</option>

				</select>
				<select id="" name="">
					<option value="">대표진료과</option>
					<option value="일반의">일반의 </option>
					<option value="구강내과">구강내과 </option>
					<option value="구강병리과">구강병리과 </option>
					<option value="구강악안면외과">구강악안면외과 </option>
					<option value="소아치과">소아치과 </option>
					<option value="영상치의학과">영상치의학과  </option>
					<option value="예방치과">예방치과  </option>
					<option value="치과교정과">치과교정과  </option>
					<option value="치과보존과">치과보존과  </option>
					<option value="치과보철과">치과보철과  </option>
					<option value="치주과">치주과  </option>
					<option value="통합치의학과">통합치의학과 </option>

				</select>
				<select id="" name="">
					<option value="">세부진료과</option>
					<option value="">--내과일때 시작--</option>
					<option value="감염내과">감염내과</option>
					<option value="내분비내과">내분비내과</option>
					<option value="류마티스내과">류마티스내과</option>
					<option value="소화기내과">소화기내과</option>
					<option value="순환기내과">순환기내과</option>
					<option value="신장내과">신장내과</option>
					<option value="심장내과">심장내과</option>
					<option value="알레르기내과">알레르기내과</option>
					<option value="혈액종양내과">혈액종양내과</option>
					<option value="호흡기내과">호흡기내과</option>
					<option value="">--외과일때 시작--</option>
					<option value="간담도체외과">간담도체외과</option>
					<option value="간이식/간담도외과">간이식/간담도외과</option>
					<option value="내분비외과">내분비외과</option>
					<option value="대장항문과">대장항문과</option>
					<option value="소아외과">소아외과</option>
					<option value="소화기외과">소화기외과</option>
					<option value="신/췌장이식외과">신/췌장이식외과</option>
					<option value="심장외과">심장외과</option>
					<option value="유방외과">유방외과</option>
					<option value="위장관외과">위장관외과</option>
					<option value="이식혈관외과">이식혈관외과</option>
					<option value="">--피부과일때 시작--</option>
					<option value="피부과">피부과 </option>
					<option value="피부미용">피부미용</option>
					<option value="피부질환">피부질환</option>
				</select>
			</p>
			<p class="inline04">
				<input type="text" placeholder="입사년월(YYY,MM)">
				<input type="text" placeholder="퇴사년월(YYY,MM)">
			</p>
			<p class="inline05">
				<input type="text" placeholder="직위/직책">
				<select id="" name="">
					<option value="">재직상태</option> 
				</select>
			</p>
			<p class="inline06">
  <textarea name="" placeholder="진행 가능한 시술명, 외래진료과 등 경력 관련 상세내용을 적어주세요."></textarea>
			</p>
		</div>

</div>
<!-- //new_career_background_sec -->

<!------------------------ //새로추가:: 프로그램 ---------------------------->


<!-- 


					<table class="tb_st_04 h_form">
						<colgroup>
							<col width="30%;"/>
							<col width="70%;"/>
						</colgroup>
						<tbody>
							<tr>
								<th>총 경력년수</th>
								<td>
									<ul>
										<li style="overflow:hidden;">
											<select id="work_year" name="work_year" style="float:left; width:49.5%;"><?=$_data['경력옵션']?></select>
											<select id="work_month" name="work_month" style="float:right; width:49.5%;"><?=$_data['경력월옵션']?></select>
										</li>
										<li style="margin-top:10px;">
											<label for="work_otherCountry" class="h-check"><input type="checkbox" id="work_otherCountry" name="work_otherCountry" value="Y" <?=$_data['DataType5']['work_otherCountry']?> id="work_otherCountry" style="vertical-align:middle; cursor:pointer"><span></span></label>
											<label for="work_otherCountry" style="cursor:pointer; font-size:14px; letter-spacing:-1.2px; font-weight:400">해외근무 경험있음</label>
										</li>
									</ul>								
								</td>
							</tr>
							<tr>
								<th>수행프로젝트 및 기타경력사항</th>
								<td>
									<textarea name="work_list" style="width:100%; height:180px;"><?=$_data['DataType5']['work_list']?></textarea>
									<ul class="list_front_dot_st">
										<li>정확한 경력사항은 이직/전직의 기본입니다.</li>
										<li>경력사항 내용부터 작성을 권장합니다.</li>
										<li>총 경력년수와 수행 프로젝트 및 기타 경력사항은 이력서마다 별도로 작성하실 수 있습니다.</li>
									</ul>
								</td>
							</tr>
						</tbody>					
					</table> -->
				</li><!-- 경력사항 [e] -->
				<li><!-- 희망근무조건 [s] -->
					<h5 class="front_bar_st_tlt">희망근무조건</h5>
					<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
						<colgroup>
							<col style="width:30%">
							<col style="width:70%">
						</colgroup>
						<tr>
							<th style="border-bottom:1px solid #dedede">기관형태</th>
							<td style="border-bottom:1px solid #dedede">
								<div class="scale_com_tb_wrap" style="margin-bottom:5px">
									<?=$_data['희망회사규모']?>

								</div>
							</td>
						</tr>
						<tr>
							<th style="border-bottom:1px solid #dedede">고용형태</th>
							<td style="border-bottom:1px solid #dedede">
								<div class="scale_com_tb_wrap" style="margin:5px 0">
									<?=$_data['고용형태']?>

								</div>
							</td>
						</tr>
						<tr>
							<th style="border-bottom:1px solid #dedede">급여</th>
							<td style="border-bottom:1px solid #dedede" >
								<style>
									#tabmenu{display:table; width:100%;}
									#tabmenu li{display:table-cell; width:50%; text-align:center}
									#tabmenu li a{display:block; width:100%; height:36px; line-height:36px; background:#fff; border:1px solid #<?=$_data['배경색']['기본색상']?>; color:#<?=$_data['배경색']['기본색상']?>; box-sizing:border-box;}
									#tabmenu li .selected{background:#<?=$_data['배경색']['기본색상']?>; color:#fff;}
								</style>
								<div style="margin:10px 0;">
									<ul id="tabmenu" style="">
										<li><a style="cursor:pointer;">선택형</a></li>
										<li><a style="cursor:pointer;">입력형</a></li>
									</ul>
								</div>
								<ul class="tabcontent" id="select1" style="margin-bottom:10px">
									<li class="h_form"><select name='grade_money2'><?=$_data['희망연봉옵션']?></select></li>
								</ul>
								<ul class="tabcontent" id="select2" style="margin-bottom:10px">
									<li class="h_form sel_x_p">
										<select name='grade_money_type' id='grade_money_type' onChange='no_change_pay()'><?=$_data['희망연봉타입']?></select>
										<p class="input_x_span">
											<input type='text' name='grade_money' id='grade_money' value='<?=$_data['DataType4']['grade_money']?>' placeholder="희망급여입력" onfocus="this.placeholder = ''"onblur="this.placeholder = '희망급여입력'">
											<span>원</span>
										</p>
									</li>
									<li class="h_form">
										<input type='button' value='다시입력' onClick='gradeMoneyReset()' style="margin-top:5px; background:#f5f5f5; border:1px solid #ddd; border-radius:3px; width:100%; cursor:pointer; font-size: 1.143em; color:#666; letter-spacing:-1.5px">
									</li>						
								</ul>
								<ul class="list_front_dot_st">
									<li>원하시는 급여조건에 대해서 선택형 또는 입력형 둘 중 하나를 선택하여 설정하여 주세요.</li>
									<li>입력형으로 작성하실 경우 금액입력 (만)원 단위 글자를 포함해서 작성하여 주세요. (예: 2400~3600만원)</li>
								</ul>
								<script type="text/javascript">
								tabMenu('<?=$_data['DataType4']['grade_money_type_ori']?>');/*텝소스 실행소스*/
								</script>
							</td>
						</tr>
						<tr>
							<th style="border-bottom:1px solid #dedede">희망근무지</th>
							<td style="border-bottom:1px solid #dedede" class="guzic_info_hope_area">
								<ul>
									<li id="area_sel1" style="" class="h_form"><?=$_data['지역검색1']?></li>
									<li id="area_sel2" style="display:none;"  class="h_form"><?=$_data['지역검색2']?></li>
									<li id="area_sel3" style="display:none;"  class="h_form"><?=$_data['지역검색3']?></li>
								</ul>
								<input type='button' value='추가하기'  onClick="formAreaAdd()" style="background:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>; border-radius:5px; box-sizing:border-box; padding:4px; width:100%; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px; margin-top:10px;">
								<ul class="list_front_dot_st">
									<li>최대 3개까지 입력 가능합니다.</li>
								</ul>
							</td>
						</tr>

						<tr>
							<th style="border-bottom:1px solid #dedede">진료과</th>
							<td style="border-bottom:1px solid #dedede" class="guzic_info_hope_area">
								<ul>
									<li id="jobtype_sel1"  class="sel_x_span_in_sel h_form"><?=$_data['type_info_1']?></li>
									<li id="jobtype_sel2" style="display:none;"  class="sel_x_span_in_sel h_form"><?=$_data['type_info_2']?></li>
									<li id="jobtype_sel3" style="display:none;"  class="sel_x_span_in_sel h_form"><?=$_data['type_info_3']?></li>
								</ul>
								<input type='button' value='추가하기'  onClick="formJobtypeAdd()" style="background:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>; border-radius:5px; box-sizing:border-box; padding:4px; width:100%; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px; margin-top:10px;">								
								<ul class="list_front_dot_st">
									<li>최대 3개까지 입력 가능합니다.</li>
								</ul>
							</td>
						</tr>
						<tr>
							<th>희망근무요일</th>
							<td class="check_radio">
								<div style="margin:5px 0;">
									<?=$_data['WeekDaysText']?> <input type="hidden" name="etc7_use" value="1">
								</div>
							</td>
						</tr>
					</table>
				</li><!-- 희망근무조건 [e] -->
				<li><!-- 이력서 정보 [s] -->
					<h5 class="front_bar_st_tlt">자기소개서</h5>
					<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
						<colgroup>
							<col style="width:30%">
							<col style="width:70%">
						</colgroup>
						<!-- <tr>
							<th class="h_form" colspan="2" style="background:#<?=$_data['배경색']['메인페이지']?>;">
								<input type="text" name="title" value="<?=$_data['DataType1']['title']?>" style="width:100%; border:1px solid #ddd;" placeholder="이력서 제목을 입력해주세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '이력서 제목을 입력해주세요'"">
							</th>						
						</tr> -->
						<tr>
							<td class="h_form" colspan="2" style="padding-top:10px">
								<textarea name="profile" style="width:100%; height:200px; " placeholder="자기소개서를  작성해주세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '자기소개서를  작성해주세요'"><?=$_data['DataType1']['profile']?></textarea>
								<p class="h_form" style="display:flex; justify-content:flex-end; align-items:center;margin-top:10px; padding:10px; background:#f5f5f5; border-radius:5px; text-align:right;">
									<label for="security" class="h-check"><input type="checkbox" name="display" value="N" <?=$_data['DataType1']['display']?> id="security" style="vertical-align:middle; "><span></span></label>
									<label for="security" style="cursor:pointer; color:#909090; letter-spacing:-1px; vertical-align:middle; margin-right:10px" class="font_14 font_dotum">비공개시 체크</label>
								</p>
								<ul class="list_front_dot_st">
									<li>이력서 제목과 자기소개서는 반드시 입력하셔야 합니다.</li>
								</ul>
							</td>
						</tr>
						<tr>
							<th style="border-bottom:1px solid #dedede">첨부파일</th>
							<td style="border-bottom:1px solid #dedede" class="check_radio">
								<ul>
									<li>
										<input type="file" name="file1" id="file1" onChange="fileCheck(this)" style="width:100%;">
										<label class="file_down_preview" style="letter-spacing:-1px"><?=$_data['미리보기1']?></label> 
										<label class="image_del" style="letter-spacing:-1px;"><?=$_data['삭제1']?></label>
									</li>
									<li style="margin-top:5px;">
										<input type="file" name="file2" id="file2" onChange="fileCheck(this)" style="width:100%;">
										<label class="file_down_preview" style="letter-spacing:-1px"><?=$_data['미리보기2']?></label> 
										<label class="image_del" style="letter-spacing:-1px;"><?=$_data['삭제2']?></label>
									</li>
									<li style="margin-top:5px;">
										<input type="file" name="file3" id="file3" onChange="fileCheck(this)" style="width:100%;">
										<label class="file_down_preview" style="letter-spacing:-1px"><?=$_data['미리보기3']?></label> 
										<label class="image_del" style="letter-spacing:-1px;"><?=$_data['삭제3']?></label>
									</li>
									<li style="margin-top:5px;">
										<input type="file" name="file4" id="file4" onChange="fileCheck(this)" style="width:100%;">
										<label class="file_down_preview" style="letter-spacing:-1px"><?=$_data['미리보기4']?></label> 
										<label class="image_del" style="letter-spacing:-1px;"><?=$_data['삭제4']?></label>
									</li>
									<li style="margin-top:5px;">
										<input type="file" name="file5" id="file5" onChange="fileCheck(this)" style="width:100%;">
										<label class="file_down_preview" style="letter-spacing:-1px"><?=$_data['미리보기5']?></label> 
										<label class="image_del" style="letter-spacing:-1px;"><?=$_data['삭제5']?></label>
									</li>
								</ul>
								<input type='button' value='다시입력'  onClick="formImageFormAdd('reset')" style="margin-top:10px; border:1px solid #ddd; background:#666; width:100%; height:30px; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px">
								<ul class="list_front_dot_st" style="margin-top:10px;">
									<li>각종 문서파일 및 이미지파일을 필요에 따라 첨부파일을 등록합니다.</li>
									<li>별도 작성한 이력서, 경력요약서, 기획서, 포트폴리오 등 입사지원시 선택하여 첨부하실 수 있습니다.</li>
									<li>첨부파일 등록은 최대 5개까지 등록하실 수 있습니다.</li>
									<li>등록가능 첨부파일 확장자는 JPG, JPEG, GIF, ZIP, RAR, PPT, DOC, PPT, XLS  입니다.</li>
									<li>다시를 클릭하시면 선택한 파일의 파일경로명, 값이 초기화 됩니다.</li>
								</ul>
							</td>
						</tr>
					</table>
				</li><!-- 이력서 정보 [e] -->
				<!-- 이력서 키워드 [s] -->
						<!-- <li><h5 class="front_bar_st_tlt">이력서 키워드</h5>
					<table class="tb_st_04">
						<tbody>
							<tr>
								<td>
									<?=$_data['키워드내용']?>	
									<input type="text" name="keyword" id="keyword" readonly value="<?=$_data['키워드']?>" >
								</td>
							</tr>
							<tr>
								<td>
									<ul class="list_front_dot_st" style="margin-top:10px;">
										<li>키워드는 이력서 검색에 사용되므로 신중하게 이력서 내용에 적합한 키워드를 선택하시기 바랍니다.</li>	
										<li>키워드 단어를 선택하면 선택된 키워드 단어는 선택 단어폼에 표시가 됩니다.</li>
										<li>첨부파일 등록은 최대 5개까지 등록하실 수 있습니다.</li>
										<li>키워드 선택 단어폼에 선택된 키워드 단어를 전체 복사하여 이력서 제목으로 그대로 활용하셔도 됩니다</li>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
									</li> --><!-- 이력서 키워드 [e] -->
				<li><!-- 선택사항 추가 [s] -->
					<h5 class="front_bar_st_tlt">면허 및 자격사항</h5>
					<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
						<colgroup>
							<col style="width:30%">
							<col style="width:70%">
						</colgroup>
						<tr>
							<th>선택</th>
							<td style="" class="regist_info check_radio">
								<table cellpadding="0" cellspacing="0" style="width:100%" class="tb_st_04_in_tb" >
						<!-- 			<tr>
										<td class="h_form">
											<label for="oa" class="h-check"><input type="checkbox" id="oa" name="oa" id="oa" value="y"  <?=$_data['Data']['oa_checked']?> onChange="etc_option_change(this,'oa_layer')"><span></span></label>
											<label for="oa" >OA 능력</label>
										</td>
									</tr>
									<tr> -->
										<td class="h_form">
											<label for="license" class="h-check"><input type="checkbox" id="license" name="license" id="license" value="y"  <?=$_data['Data']['license_checked']?> onChange="etc_option_change(this,'license_layer')"><span></span></label>
											<label for="license" >자격사항</label>
										</td>
									</tr>
									<tr>
										<td class="h_form">
											<label for="completion" class="h-check"><input type="checkbox" id="completion" name="completion" id="completion" value="y" style="" <?=$_data['Data']['completion_checked']?> onChange="etc_option_change(this,'completion_layer')"><span></span></label>
											<label for="completion">보유기술 및 보유이수 내용</label>
										</td>
									</tr>
									<tr>
										<td class="h_form">
											<label for="foreign" class="h-check"><input type="checkbox" id="foreign" name="foreign" id="foreign" value="y" style="cursor:pointer" <?=$_data['Data']['foreign_checked']?> onChange="etc_option_change(this,'foreign_layer')"><span></span></label>
											<label for="foreign" >외국어능력</label>
										</td>
									</tr>
									<tr>
										<td class="h_form">
											<label for="training" class="h-check"><input type="checkbox" id="training" name="training" id="training" value="y" style="cursor:pointer" <?=$_data['Data']['training_checked']?> onChange="etc_option_change(this,'training_layer')"><span></span></label>
											<label for="training" >해외연수</label>
										</td>
									</tr>
									<tr>
										<td class="h_form">
											<label for="givespecial" class="h-check"><input type="checkbox" id="givespecial" name="givespecial" id="givespecial" value="y" style="width:14px; height:14px;  cursor:pointer" <?=$_data['Data']['givespecial_checked']?> onChange="etc_option_change(this,'givespecial_layer')"><span></span></label>
											<label for="givespecial">초빙우대사항</label>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<!-- OA능력-->
					<div style="margin-top:20px; border:1px solid #dddddd; border-top:0 none; <?=$_data['Data']['oa_style']?>"  id="oa_layer">
						<table style="width:100%; border-bottom:none;" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
							<tr>
								<th class="font_14">
									OA능력
								</th>
							</tr>
							<tr>
								<td style="padding: 15px 0; border-bottom:none;">
									<table style="width:100%" cellspacing="0" cellpadding="0" border="0">
										<colgroup>
											<col style="width:30%">
											<col style="width:70%">
										</colgroup>
										<tr>
											<th rowspan="3">워드<br/>(한글/M워드)</th>		
											<td class="h_form" style="padding-top:0px">
												<label for="skill_word3" class="h-radio"><input type="radio" name="skill_word" value="3" id="skill_word3" <?=$_data['Data']['skill_word3']?> style=" width:13px; height:13px; cursor:pointer"><span></span></label>
												<label class="skill_word3" for="skill_word3" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_high.gif" title="상" alt="상" style="vertical-align:middle"> 스타일/고급편집기능
												</label>
											</td>
										</tr>
										<tr>
											<td class="h_form" style="padding-top:5px">
												<label for="skill_word2" class="h-radio"><input type="radio" name="skill_word" value="2" id="skill_word2" <?=$_data['Data']['skill_word2']?> style=" width:13px; height:13px; cursor:pointer"><span></span></label>
												<label class="skill_word2" for="skill_word2" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_middle.gif" title="중" alt="중" style="vertical-align:middle"> 표/도구 활용가능
												</label>
											</td>
										</tr>
										<tr style="border-bottom:1px solid #dedede">
											<td class="h_form" style="padding-top:5px; padding-bottom:15px;">
												<label for="skill_word1" class="h-radio"><input type="radio" name="skill_word" value="1" id="skill_word1" <?=$_data['Data']['skill_word1']?> style=" width:13px; height:13px; cursor:pointer"><span></span></label>
												<label class="skill_word1" for="skill_word1" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_low.gif" title="하" alt="하" style="vertical-align:middle"> 문서 편집 가능
												</label>
											</td>
										<tr>
										<tr>
											<th rowspan="3">프리젠테이션<br/>(파워포인트)</th>											
											<td class="h_form" style="padding-top:15px">
												<label for="skill_ppt3" class="h-radio"><input type="radio" name="skill_ppt" value="3" id="skill_ppt3" <?=$_data['Data']['skill_ppt3']?> style=" cursor:pointer"><span></span></label>
												<label class="skill_ppt3" for="skill_ppt3" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_high.gif" title="상" alt="상" style="vertical-align:middle"> 멀티미디어/애니메이션 효과 가능
												</label>
											</td>
										</tr>
										<tr>
											<td class="h_form" style="padding-top:5px">
												<label for="skill_ppt2" class="h-radio"><input type="radio" name="skill_ppt" value="2" id="skill_ppt2" style=" cursor:pointer" <?=$_data['Data']['skill_ppt2']?> ><span></span></label>
												<label class="skill_ppt2" for="skill_ppt2" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_middle.gif" title="중" alt="중" style="vertical-align:middle"> 차트/그래픽 가능
												</label>
											</td>
										</tr>
										<tr style="border-bottom:1px solid #dedede">
											<td class="h_form" style="padding-top:5px; padding-bottom:15px;">
												<label for="skill_ppt1" class="h-radio"><input type="radio" name="skill_ppt" value="1" id="skill_ppt1" style="cursor:pointer" <?=$_data['Data']['skill_ppt1']?> ><span></span></label>
												<label class="skill_ppt1" for="skill_ppt1" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_low.gif" title="하" alt="하" style="vertical-align:middle"> 서식/도형가능
												</label>
											</td>
										</tr>
										<tr>
											<th rowspan="3" >스프레드시트<br/>(엑셀)</th>											
											<td class="h_form" style="padding-top:15px">
												<label for="skill_excel3" class="h-radio"><input type="radio" name="skill_excel" value="3" id="skill_excel3" style="cursor:pointer" <?=$_data['Data']['skill_excel3']?> ><span></span></label>
												<label class="skill_excel3" for="skill_excel3" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_high.gif" title="상" alt="상" style="vertical-align:middle"> 고급함수/피벗테이블 가능
												</label>
											</td>
										</tr>
										<tr>
											<td class="h_form" style="padding-top:5px">
												<label for="skill_excel2" class="h-radio"><input type="radio" name="skill_excel" value="2" id="skill_excel2" style="cursor:pointer"<?=$_data['Data']['skill_excel2']?> ><span></span></label>
												<label class="skill_excel2" for="skill_excel2" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_middle.gif" title="중" alt="중" style="vertical-align:middle"> 일반함수/수식 가능
												</label>
											</td>
										</tr>
										<tr style="border-bottom:1px solid #dedede">
											<td class="h_form" style="padding-top:5px; padding-bottom:15px;">
												<label for="skill_excel1" class="h-radio"><input type="radio" name="skill_excel" value="1" id="skill_excel1" style="cursor:pointer" <?=$_data['Data']['skill_excel1']?> ><span></span></label>
												<label class="skill_excel1" for="skill_excel1" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_low.gif" title="하" alt="하" style="vertical-align:middle"> 데이터 편집 가능
												</label>
											</td>
										</tr>
										<tr>
											<th rowspan="3">인터넷 <br/>(정보검색)</th>											
											<td class="h_form" style="padding-top:15px">
												<label for="skill_search3" class="h-radio"><input type="radio" name="skill_search" value="3" id="skill_search3" style="cursor:pointer"<?=$_data['Data']['skill_search3']?> ><span></span></label>
												<label class="skill_search3" for="skill_search3" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_high.gif" title="상" alt="상" style="vertical-align:middle"> 스타일/고급편집 가능
												</label>
											</td>
										</tr>
										<tr>
											<td class="h_form" style="padding-top:5px">
												<label for="skill_search2" class="h-radio"><input type="radio" name="skill_search" value="2" id="skill_search2" style="cursor:pointer" <?=$_data['Data']['skill_search2']?> ><span></span></label>
												<label class="skill_search2" for="skill_search2" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_middle.gif" title="중" alt="중" style="vertical-align:middle"> 표/도구 활용 가능
												</label>
											</td>
										</tr>
										<tr>
											<td class="h_form" style="padding-top:5px;">
												<label for="skill_search1" class="h-radio"><input type="radio" name="skill_search" value="1" id="skill_search1" style="cursor:pointer" <?=$_data['Data']['skill_search1']?> ><span></span></label>
												<label class="skill_search1" for="skill_search1" style="letter-spacing:-1px; cursor:pointer">
													<img src="img/ico_level_low.gif" title="하" alt="하" style="vertical-align:middle"> 문서 편집 가능
												</label>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div><!-- OA능력-->
					<!--자격사항-->
					<div id="license_layer" style="margin-top:20px; <?=$_data['Data']['license_style']?>; border:1px solid #dddddd; border-top:0 none">
						<table style="width:100%; border-bottom:none;" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
							<tr>
								<th>
									자격사항
								</th>
							</tr>
							<tr>
								<td style="padding:10px; background:#fff; border:1px solid #dddddd; border-top:0 none">
									<div  id="kwak1" style="display:none;">
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form">
														<input type="text" name="skill_name__kwak" placeholder="자격증명" onfocus="this.placeholder = ''"onblur="this.placeholder = '자격증명'">
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form">
														<input type="text" name="skill_from__kwak" placeholder="발행처" onfocus="this.placeholder = ''"onblur="this.placeholder = '발행처'">
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form select_width">
														<select name="skill_getYear__kwak" id="skill_getYear__kwak">
															<?=$_data['년도옵션']?>

														</select>
													</td>
													<td class="h_form select_width" style="padding-left:3px;">
														<select name="skill_getMonth__kwak" id ="skill_getMonth__kwak">
															<?=$_data['월옵션']?>

														</select>
													</td>
													<td class="h_form select_width" style="padding-left:3px;">
														<select name="skill_getDay__kwak" id="skill_getDay__kwak">
															<?=$_data['일옵션']?>

														</select>
													</td>
												</tr>
												<tr>
													<td class="h_form" style="padding-top:5px" colspan="3">
														<label for="delete_skill__kwak" class="h-check"><input type="checkbox" name="delete_skill__kwak" value="1" id="delete_skill__kwak" style="vertical-align:middle; margin:0 5px;"><span></span></label>
														<label for="delete_skill__kwak" style="cursor:pointer; font-weight:bold; letter-spacing:-1px; color:#666" class="">삭제시 체크</label>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div id="kwak_view1"></div>									
									<input type="button" name="" value="추가" onClick="work_layer_add1()" style="background:#666; border-radius:5px;width:100%; height:30px; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px">								
									<ul class="list_front_dot_st">
										<li>이전 이력서 등록시 여기 기록한 정보가 있을 경우 이전 기록한 정보가 자동 출력됩니다.</li>
									</ul>
								</td>
							</tr>
						</table>
					</div>
					<!-- 보유기술 -->
					<div id="completion_layer" style="margin-top:20px; <?=$_data['Data']['completion_style']?>; border:1px solid #dddddd; border-top:0 none">
						<table style="width:100%; border-bottom:none;" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
							<tr>
								<th>
									보유기술 및 보유이수 내용
								</th>
							</tr>
							<tr>
								<td style="padding:10px; background:#fff; border:1px solid #dddddd; border-top:0 none" class="regist_info">
									<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="regist_chart_01">
										<tr>
											<td class="info">
												<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
													<tr>
														<td class="h_form select_width">
															<textarea name="skill_list" style="width:100%; height:180px; "><?=$_data['Data']['skill_list']?></textarea>
														</td>
													</tr>
												</table>
												<ul class="list_front_dot_st">
													<li>예제)
														<br>[보유기술]
														<br/>PHP, MySQL, JavaScript, HTML, CSS, Illustraoter, Flash, Photoshop
														<br/>[교육사항]
														<br/>2001년 02월 ~ 2001년 08월 : 해피 교육센터 웹디자인 과정 수료
														<br/>2002년 04월 ~ 2001년 10월 : 대한 교육센터 컴퓨터시스템 과정 수료
													</li>
												</ul>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<!-- 외국어능력 -->
					<div id="foreign_layer" style="margin-top:20px; <?=$_data['Data']['foreign_style']?>; border:1px solid #dddddd; border-top:0 none">
						<table style="width:100%; border-bottom:none" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
							<tr>
								<th>
									외국어능력
								</th>
							</tr>
							<tr>
								<td style="padding:10px; background:#fff; border:1px solid #dddddd; border-top:0 none" class="regist_info">
									<div id="kwak2" style="display:none">
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form select_width">
														<select id="language_title__kwak"  name="language_title__kwak" style="width:100%"><?=$_data['외국어능력옵션']?></select>
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form select_width">
														<select id="language_check__kwak" name="language_check__kwak" style="width:100%"><?=$_data['외국어자격증옵션']?></select>
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form select_width">
														<select id="language_year__kwak" name="language_year__kwak" title="취득일자(년)">
															<?=$_data['년도옵션']?>

														</select>
													</td>
													<td class="h_form select_width" style="padding-left:3px;">
														<select id="language_month__kwak" name="language_month__kwak" title="취득일자(월)">
															<?=$_data['월옵션']?>

														</select>
													</td>
													<td class="h_form select_width" style="padding-left:3px;">
														<select id="language_day__kwak" name="language_day__kwak" title="취득일자(일)">
															<?=$_data['일옵션']?>

														</select>
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form">
														<input type="text" name="language_point__kwak" style="" placeholder="점수" onfocus="this.placeholder = ''"onblur="this.placeholder = '점수'">
													</td>
													<td style="width:30px; text-align:center">점</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<colgroup>
													<col style="width:25%">
													<col style="width:75%">
												</colgroup>
												<tr>
													<td>
														능력
													</td>
													<td class="h_form select_width">
														<label for="language_skill__kwak3" class="h-radio"><input type="radio" name="language_skill__kwak" value="3" id="language_skill__kwak3" style="cursor:pointer" <?=$_data['Data']['language_skill3']?> ><span></span></label>
														<label for="language_skill__kwak3" style="cursor:pointer; ">
															<img src="img/ico_level_high.gif" alt="상" title="상" style="vertical-align:middle">
														</label>
														<label for="language_skill__kwak2" class="h-radio"><input type="radio" name="language_skill__kwak" value="2" id="language_skill__kwak2" style="cursor:pointer" <?=$_data['Data']['language_skill2']?> ><span></span></label>
														<label for="language_skill__kwak2" style="cursor:pointer; ">
															<img src="img/ico_level_middle.gif" alt="중" title="중"  style="vertical-align:middle">
														</label>
														<label for="language_skill__kwak1" class="h-radio"><input type="radio" name="language_skill__kwak" value="1" id="language_skill__kwak1" style="cursor:pointer" <?=$_data['Data']['language_skill1']?> ><span></span></label>
														<label for="language_skill__kwak1" style="cursor:pointer; ">
															<img src="img/ico_level_low.gif" alt="하" title="하"  style="vertical-align:middle">
														</label>
													</td>
												</tr>
												<tr>
													<td class="h_form" style="padding-top:5px" colspan="2">
														<label for="delete_language_skill__kwak" class="h-check"><input type="checkbox" name="delete_language_skill__kwak" value="1" id="delete_language_skill__kwak" style="vertical-align:middle; margin:0 5px;"><span></span></label>
														<label for="delete_language_skill__kwak" style="cursor:pointer; font-weight:bold; letter-spacing:-1px; color:#666" class="">삭제시 체크</label>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div id="kwak_view2"></div>
									<div id="kwak_view2" style="float:left; clear:both; width:100%; height:auto; margin-bottom:-1px; border:0px solid red;"></div>

									<!-- 요까이 -->									
									<input type="button" name="" value="추가"  onClick="work_layer_add2()"  style="background:#666; border-radius:5px; width:100%; height:30px; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px">
									<ul class="list_front_dot_st">
										<li>외국어능력에 대한 내용이 있으시면 작성을 하시면 됩니다.</li>
										<li>외국어능력 내용이 2개 이상일 경우 필요한 만큼 추가 버튼을 클릭하시면 됩니다.</li>
										<li>추가생성된 항목을 삭제하실 경우 삭제시체크에 체크하시면 됩니다.</li>
										<li>이전 이력서 등록시 여기 기록한 정보가 있을 경우 이전 기록한 정보가 자동 출력됩니다.</li>
									</ul>
								</td>
							</tr>
						</table>
					</div>
					<!-- 해외연수 -->
					<div id="training_layer" style="margin-top:20px; <?=$_data['Data']['training_style']?>; border:1px solid #dddddd; border-top:0 none">
						<table style="width:100%; border-bottom:none" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
							<tr>
								<th>
									해외연수
								</th>
							</tr>
							<tr>
								<td style="padding:10px; background:#fff; border:1px solid #dddddd; border-top:0 none" class="info">
									<div id="kwak3" style="display:none">
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form select_width">
														<select id="country__kwak" name="country__kwak" style="width:100%;"><?=$_data['연수국가옵션']?></select>
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form select_width">
														<select id="startYear__kwak"name="startYear__kwak"><?=$_data['년도옵션']?></select>
													</td>
													<td class="h_form select_width" style="padding-left:3px">
														<select id="startMonth__kwak" name="startMonth__kwak"><?=$_data['월옵션']?></select>
													</td>
													<td style="width:30px; text-align:center;">
														부터
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form select_width">
														<select id="endYear__kwak" name="endYear__kwak"><?=$_data['년도옵션']?></select>
													</td>
													<td class="h_form select_width" style="padding-left:3px">
														<select id="endMonth__kwak" name="endMonth__kwak"><?=$_data['월옵션']?></select>
													</td>
													<td style="width:30px; text-align:center;">
														까지
													</td></tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form select_width">
														<select id="language_year__kwak" name="language_year__kwak" title="취득일자(년)">
															<?=$_data['년도옵션']?>

														</select>
													</td>
													<td class="h_form select_width" style="padding-left:3px">
														<select id="language_month__kwak" name="language_month__kwak" title="취득일자(월)">
															<?=$_data['월옵션']?>

														</select>
													</td>
													<td class="h_form select_width" style="padding-left:3px">
														<select id="language_day__kwak" name="language_day__kwak" title="취득일자(일)">
															<?=$_data['일옵션']?>

														</select>
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form">
														<input type="text" name="content__kwak" placeholder="목적 및 내용" onfocus="this.placeholder = ''"onblur="this.placeholder = '목적 및 내용'">
													</td>
												</tr>
											</table>
										</div>
										<div style="margin-bottom:5px">
											<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
												<tr>
													<td class="h_form" style="padding-top:5px" colspan="2">
														<label for="delete_yunsoo__kwak" class="h-check"><input type="checkbox" name="delete_yunsoo__kwak" value="1" id="delete_yunsoo__kwak" style="vertical-align:top;"><span></span></label>
														<label class="delete_yunsoo__kwak guzic_text" for="delete_yunsoo__kwak" style="cursor:pointer;">삭제시체크</label>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div id="kwak_view3"></div>
									<div id="kwak_view3" style="float:left; clear:both; width:100%; height:auto; margin-bottom:-1px; border:0px solid red;"></div>

									<!-- 요까이 -->									
									<input type="button" name="" value="추가"  onClick="work_layer_add3()"  style="background:#666; border-radius:5px; width:100%; height:30px; cursor:pointer; font-size: 1.143em; color:#fff; letter-spacing:-1.5px">
									<ul class="list_front_dot_st">
										<li>이전 이력서 등록시 여기 기록한 정보가 있을 경우 이전 기록한 정보가 자동 출력됩니다.</li>
									</ul>
								</td>
							</tr>
						</table>
					</div>
					<div id="givespecial_layer" style="margin-top:20px; <?=$_data['Data']['givespecial_style']?>; ">
						<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
							<tr>
								<th class="font_14">
									초빙우대사항
								</th>
							</tr>
							<tr>
								<td class="info">
									<table style="width:100%" cellspacing="0" cellpadding="0" border="0" class="regist_chart_01">
										<colgroup>
											<col style="width:25%">
											<col style="width:75%">
										</colgroup>
										<tr>
											<th style="border-bottom:1px solid #dedede">보훈대상여부</th>
											<td style="border-bottom:1px solid #dedede">
												<div style="padding:5px 0 10px 0" class="check_radio">
													<?=$_data['bohunRadio']?>

												</div>
											</td>
										</tr>
										<tr>
											<th style="border-bottom:1px solid #dedede">장애여부</th>
											<td style="border-bottom:1px solid #dedede">
												<div style="padding:10px 0" class="check_radio">
													<?=$_data['jangaeRadio']?>

												</div>
												<div style="padding:0 0 10px 0" class="check_radio">
													<table cellpadding="0" cellspacing="0" style="width:100%">
														<tr>
															<td class="h_form select_width">
																<?=$_data['jangaeSelect']?>

															</td>
															<td style="width:30px">
																급
															</td>
														</tr>
													</table>
												</div>
											</td>
										</tr>
										<tr>
											<th style="">병역사항</th>
											<td style="">
												<div style="padding:10px 0" class="check_radio">
													<?=$_data['armyRadio']?>

												</div>
												<div style="padding-bottom:5px" class="check_radio" >
													<table cellpadding="0" cellspacing="0" style="width:100%;">
														<colgroup>
															<col width="*"/>
															<col width="30px"/>
														</colgroup>
														<tbody>
															<tr>
																<td class="h_form twin_select_wrap" style="padding-bottom:5px">
																	<?=$_data['armySelect1']?>

																</td>
																<td style="width:30px" style="padding-bottom:5px">
																	입대
																</td>
															</tr>
															<tr>
																<td class="h_form twin_select_wrap" style="">
																	<?=$_data['armySelect2']?>

																</td>
																<td style="width:30px; ">
																	제대
																</td>
															</tr>
														</tbody>														
													</table>
												</div>
												<div style="margin-bottom:5px">
													<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
														<tr>
															<td class="h_form select_width" style="padding-bottom:5px">
																<?=$_data['armySelect3']?>

															</td>
															<td class="h_form select_width" style="padding:0 0 5px 3px;">
																<?=$_data['armySelect4']?> <?=$_data['armyStart']?>

															</td>
														</tr>
													</table>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<!-- 이전에 입력된 내용을 기본으로 불러옴 -->
					<?=$_data['defaultSetting']?>

				</li><!-- 선택사항 추가 [e] -->
			</ul>
		</div><!-- 이력서 수정 [e] --> 

		<div style="display:none" id="class2">
			<a name='pay_move'></a>
			<div class="banner_img" >
				<?echo happy_banner('모바일이력서배너','배너제목','랜덤') ?>

			</div>
			<div style="margin-top:40px;">
				<h5 class="front_bar_st_tlt">광고노출 서비스</h5>
				<?=$_data['이력서결제페이지']?>  <!--mobile_html/guzic_pay.html-->
			</div>
			
		</div>
		<ul class="pay_btns_wrap">
			<li id="uryo_button_layer" class="pay_btn_ver_b" ><?=$_data['등록버튼']?></li>
			<li id="free_button_layer" class="pay_free_btn"style="display:<?=$_data['mod_dis']?>;"><?=$_data['PAY']['free']?></li>
		<!-- 	<li>
				<a href='#pay_move'  id="class_kwak_div_2" onClick="happy_tab_menu('class_kwak_div','2');">
					<input type="button" value="유료서비스 결제" style="width:100%; border:1px solid #ddd; height:35px; line-height:35px; font-size:14px; font-weight:400; letter-spacing:-1px; text-align:center; color:#fff; background:#<?=$_data['배경색']['기본색상']?>" >
				</a>
			</li>
			<li><input type="button" value="패키지옵션 결제" style="width:100%; border:1px solid #ddd; height:35px; line-height:35px; font-size:14px; font-weight:400; letter-spacing:-1px; text-align:center; color:#fff; background:#<?=$_data['배경색']['서브색상']?>;" onclick="window.open('member_option_pay_package.php?pay_type=personp')"></li> -->
		</ul>
	</div>
	</form>

	<?=$_data['PAY']['loading_script']?>


<? }
?>