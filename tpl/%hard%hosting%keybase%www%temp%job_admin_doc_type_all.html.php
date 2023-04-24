<? /* Created by SkyTemplate v1.1.0 on 2023/04/18 10:06:51 */
function SkyTpl_Func_3786358491 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script type="text/javascript" src="js/happy_member.js"></script>
<script type='text/javascript'>
	function sendit( frm )
	{
		//최종학력
		if ( frm.grade_lastgrade.selectedIndex < 1 )
		{
			//alert('최종학력을 선택해주세요.');
			//frm.grade_lastgrade.focus();
			//return false;
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

			frm.title.focus();
			return false;
		}
		if ( frm.user_birth_year.value == '' )
		{
			alert('태어난 년도를 입력해주세요.');

			frm.user_birth_year.focus();
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
		originalHTML	= "<div style='border-bottom:1px solid #e9e9e9; padding:5px 0'>"+originalHTML+"</div>";
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
		originalHTML	= "<div style='border-bottom:1px solid #e9e9e9; padding:5px 0'>"+originalHTML+"</div>";
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


<!-- FORM start -->
<form name="document_frm" id="document_frm" method="post" action="document.php?mode=<?=$_data['mode']?>" ENCTYPE="multipart/form-data" onSubmit="return sendit(this)">

<input type="hidden" name="mode" value="<?=$_data['mode']?>">
<input type="hidden" name="subMode" value="<?=$_data['subMode']?>">
<input type="hidden" name="number" value="<?=$_data['number']?>">
<input type="hidden" name="user_image2" value="<?=$_data['user_image2']?>">
<input type="hidden" name="returnUrl" value="<?=$_data['returnUrl']?>">
<input type="hidden" name="worklist_size1" value="1">
<input type="hidden" name="worklist_size2" value="1">
<input type="hidden" name="worklist_size3" value="1">

<div style="position:relative;">
	<h2 class="noto500 font_25" style="color#333333; padding:7px 0 19px 0; background: url(./img/menu_ling_bg.png) 0 bottom repeat-x;">
		<span style="letter-spacing:-1.2px; color:#333">
			이력서작성
		</span>
	</h2>

<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed;border-collapse: collapse;">
	<tr>
		<td>
		<h3 class="noto500 font_25" style="padding:20px 0 15px 0; margin:0; letter-spacing:-1px; color:#333;">회원정보</h3>
		<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse">
			<tr>
				<td style="width:116px; padding:28px 45px; background:#f3f6f5; border-top:2px solid #c4d0cf; border-right:1px solid #dce3e2; border-bottom:1px solid #dce3e2">
					<div style="width:100px; padding:7px; border:1px solid #dce3e2; background:#fff">
						<img src="<?=$_data['이미지정보']?>" width="100" height="130" title="<?=$_data['Data']['user_name']?>">
					</div>
					<div class="noto400 font_14" style="margin-top:10px; text-align:center; line-height:1.4; letter-spacing:-1px;">
						<?=$_data['DataType1']['user_name']?> (<?=$_data['DataType1']['user_prefix']?>) <br/> <?=$_data['userid_info']?> <input type="hidden" name="user_id" value="<?=$_data['userid']?>">
					</div>
				</td>
				<td style="border-top:2px solid #c4d0cf; border-bottom:1px solid #dce3e2; vertical-align:top">
					<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed" class="doc_resister">
						<tr>
							<th style=" border-bottom:1px solid #dce3e2; text-align:left">휴대폰</th>
							<td style="width:200px; border-bottom:1px solid #dce3e2;" class="h_form">
								<input type="text" name="user_hphone" value="<?=$_data['DataType1']['user_hphone']?>" >
							</td>
							<th style="border-bottom:1px solid #dce3e2">생년월일</th>
							<td style="border-bottom:1px solid #dce3e2" class="h_form">
								<input type="text" name="user_birth_year" value="<?=$_data['DataType1']['user_birth_year']?>" style="width:14%;"> - <input type="text" name="user_birth_month" value="<?=$_data['DataType1']['user_birth_month']?>" style="width:9%;"> - <input type="text" name="user_birth_day" value="<?=$_data['DataType1']['user_birth_day']?>" style="width:9%;">
							</td>
						</tr>
						<tr>
							<th style="border-bottom:1px solid #dce3e2">전화번호</th>
							<td style="border-bottom:1px solid #dce3e2" class="h_form">
								<input type="text" name="user_phone" value="<?=$_data['DataType1']['user_phone']?>">
							</td>
							<th style="border-bottom:1px solid #dce3e2">홈페이지</th>
							<td style="border-bottom:1px solid #dce3e2" class="h_form">
								<input type="text" name="user_homepage" value="<?=$_data['DataType1']['user_homepage']?>" style="width:60%;">
							</td>
						</tr>
						<tr>
							<th style="border-bottom:1px solid #dce3e2">이메일</th>
							<td style="border-bottom:1px solid #dce3e2" class="h_form">
								<input type="text" name="user_email1" value="<?=$_data['DataType1']['user_email1']?>" >
							</td>
							<th style="vertical-align:top; padding-top:20px" rowspan="2">주소</th>
							<td style="vertical-align:top; padding-top:15px" rowspan="2" class="h_form">
								<input type="text" name="user_zipcode" value="<?=$_data['DataType1']['user_zipcode']?>" style="width:150px; margin:0 3px 5px 0;">
								<a class="h_btn_st2" style="margin:0 0 5px 0;" onClick="window.open('http://<?=$_data['zipcode_site']?>/zonecode/happy_zipcode.php?ht=1&hys=<?=$_data['base64_main_url']?>&hyf=user_zipcode|user_addr1|user_addr2|<?=$_data['zipcode_add_get']?>','happy_zipcode_popup_<?=$_data['base64_main_url']?>', 'width=600,height=600,scrollbars=yes');">우편번호검색</a>
								<br>
								<input type="text" name="user_addr1" value="<?=$_data['DataType1']['user_addr1']?>" style="width:220px;">
								<input type="text" name="user_addr2" value="<?=$_data['DataType1']['user_addr2']?>" style="width:120px;">
							</td>
						</tr>
						<tr>
							<th style="">추가이메일</th>
							<td style="" class="h_form">
								<input type="text" name="user_email2" value="<?=$_data['DataType1']['user_email2']?>" >
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
<div style="margin-top:10px">
	<?=$_data['미니앨범수정']?>

</div>
<!-- 초기화 상태 알림내용 -->
<div id="notify_disable_default" style="display:none;"></div>
<h3 class="noto500 font_25" style="padding:50px 0 15px 0; margin:0; border-bottom:2px solid #dfdfdf; letter-spacing:-1px; color:#333;">학력사항</h3>
<div>
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
					<input type="text" name="academy_name[]" id="academy_name_0" placeholder="학교명" style="width: 150px;">
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
<style>
.new_career_background_sec div,
.new_career_background_sec div p { overflow:hidden; box-sizing:border-box;}
.new_career_background_sec div{
padding:20px 0px; position:relative;
 background: url('../img/resister_line_01.gif') 0 bottom repeat-x;}
.new_career_background_sec div p{padding:3px 0px;}

.new_career_background_sec div p.inline01  {padding-top:10px; padding-bottom:10px;}
.new_career_background_sec div p.inline01 span.part-clear {display:inline-block; width:100px;}
.new_career_background_sec div p.inline02 select{width:400px;}
.new_career_background_sec div p.inline01 input[type='text']{width:400px;}

.new_career_background_sec div p.inline02 input[type='text']{width:400px;}
.new_career_background_sec div p.inline03 select,
.new_career_background_sec div p.inline04 select{width:300px;}
.new_career_background_sec div p.inline04 input[type='text']{width:199px;}

.new_career_background_sec div select{width:240px;}
.new_career_background_sec div a {display:inline-block; position:absolute;
top:20px; right:0px;/*  background:#4587DE;  border:none;color:#fff; */
 border:1px solid #4587DE;color:#4587DE; 
font-weight:500;
font-size:13px; line-height:35px; padding:0; width:110px;  text-align:center;  }
.new_career_background_sec div a span {padding-right:10px;}
.new_career_background_sec iframe {width:100%; height:150px;}

</style>
<h3 class="noto500 font_25" style="padding:50px 0 15px 0; margin:0; border-bottom:2px solid #dfdfdf; letter-spacing:-1px; color:#333;">경력사항</h3>
<p class="inline01 " >
	<label for="no_career" class="h-check"><input type="checkbox" id="no_career" name="no_career" value="y" <?=$_data['DataType4']['is_no_career_checked']?>><span></span></label>
	<label for="no_career" class="noto400 font_14" style="cursor:pointer;">경력없음</label>
</p>

<div id="table_career" class="new_career_background_sec  h_form">
	<div id="0" class="career_tr_clone" style="display:none;">
		%BTN_HTML%
		<p class="inline01">
			<input type="hidden" name="career_cnt[]" id="career_cnt_0" value="1">
			<span class="part-clear"></span>
			<label class="h-radio" for="career_area_in_0"><input type="radio" id="career_area_in_0" name="career_area_0" value="in" checked> <span class="noto400 font_14">국내</span></label>
			<label class="h-radio" for="career_area_out_0"><input type="radio" id="career_area_out_0" name="career_area_0" value="out"> <span class="noto400 font_14">해외</span></label>
		</p>

		<p class="inline02">
			<input type="text" name="career_work_name[]" id="career_work_name_0" placeholder="근무처명">
			<label for="career_work_name_nodisplay_0" class="h-check"><input type="checkbox" name="career_work_name_nodisplay_0" id="career_work_name_nodisplay_0" value="y"><span></span></label>
			<label for="career_work_name_nodisplay_0" class="noto400 font_14" style="cursor:pointer;">근무처명 비공개</label>
		</p>

		<p class="inline03">
			<select name="career_type[]" id="career_type_0">
				<?=$_data['career_type_opt']?>

			</select>
			<select name="career_type_sub[]" id="career_type_sub_0">
				<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
				<?=$_data['career_type_sub_opt']?>

			</select>
			<select name="career_type_sub_sub[]" id="career_type_sub_sub_0">
				<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
				<?=$_data['career_type_sub_sub_opt']?>

			</select>
		</p>
		<p class="inline04">
			<input type="text" name="career_in[]" id="career_in_0" placeholder="입사년월(YYY,MM)">
			<input type="text" name="career_out[]" id="career_out_0" placeholder="퇴사년월(YYY,MM)">
			<input type="text" name="career_duty[]" id="career_duty_0" placeholder="직위/직책">
			<select name="career_work_type[]" id="career_work_type_0">
				<option value="">재직상태</option> 
				<option value="재직중">재직중</option>
				<option value="퇴사">퇴사</option>
			</select>
		</p>
		<p class="inline05">
			<textarea name="career_msg[]" id="career_msg_0" placeholder="진행 가능한 시술명, 외래진료과 등 경력 관련 상세내용을 적어주세요."></textarea>
		</p>
	</div>
	<?=$_data['per_career_html']?>

</div>



<script>

$(document).ready(function() {
	academy_tr_row_add(0);
	career_tr_row_add(0);
});
</script>

<h3 class="noto500 font_25" style="padding:50px 0 15px 0; margin:0; border-bottom:2px solid #dfdfdf; letter-spacing:-1px; color:#333;">희망근무조건</h3>
<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_rsum">
	<tr>
		<th class="title">
			기관형태
		</th>
		<td class="sub pay" >
			<?=$_data['희망회사규모']?>

		</td>
	</tr>
	<tr>
		<th class="title">
			고용형태
		</th>
		<td class="sub" >
			<?=$_data['고용형태']?>

		</td>
	</tr>
	<tr>
		<th class="title">
			희망연봉
		</th>
		<td class="sub" >
			<ul id="tabmenu" style="border-right:1px solid #dbdbdb; float:left">
				<li><a style="cursor:pointer;">선택형</a></li>
				<li><a style="cursor:pointer;">입력형</a></li>
			</ul>
			<div class="tabcontent" id="select1" style="float:left; margin-left:5px"><span class="h_form"><select name='grade_money2' style="width:160px;"><?=$_data['희망연봉옵션']?></select></span></div>
			<div class="tabcontent" id="select2" style="float:left; margin-left:5px">
				<span class="h_form"><select name='grade_money_type' id='grade_money_type' onChange='no_change_pay()' style="width:110px;"><?=$_data['희망연봉타입']?></select>
				<input type='text' name='grade_money' id='grade_money' value='<?=$_data['DataType4']['grade_money']?>' style="width:150px; text-align:right;"> <span class="noto400 font_14">원</span>
				<a onClick='gradeMoneyReset()' class="h_btn_st2">다시입력</a></span>
			</div>
			<script type="text/javascript">
			tabMenu('<?=$_data['DataType4']['grade_money_type_ori']?>');/*텝소스 실행소스*/
			</script>
			<p class="clear font_11 font_dotum" style="color:#999; letter-spacing:-1px; line-height:18px; padding-top:10px;">
				원하시는 급여조건에 대해서 선택형 또는 입력형 둘 중 하나를 선택하여 설정하여 주세요.<br/>
				입력형으로 작성하실 경우 금액입력 (만)원 단위 글자를 포함해서 작성하여 주세요. (예: 2400~3600만원)
			</p>
		</td>
	</tr>
	<tr>
		<th class="title">
			희망근무지
		</th>
		<td class="sub" >
			<div id="area_sel1" class="h_form" style="display:inline-block;"><?=$_data['지역검색1']?></div>
			<span class="h_form" style="display:<?=$_data['form_add_button_view']?>; vertical-align:middle">
				<a class="h_btn_st2 icon_m uk-icon" uk-icon="icon:plus; ratio:0.8" onclick="formAreaAdd()">추가하기</a>
				<span class="font_11 font_dotum" style="letter-spacing:-1px; color:#999">( 최대 3개 )</span>
			</span>
			<div id="area_sel2" class="h_form" style="display:none; margin:5px 0 5px 0; clear:both"><?=$_data['지역검색2']?></div>
			<div id="area_sel3" class="h_form" style="display:none;"><?=$_data['지역검색3']?></div>
		</td>
	</tr>
	<tr>
		<th class="title">
			업/직종선택
		</th>
		<td class="sub" >
			<div id="jobtype_sel1" class="h_form" style="display:inline-block;">
				<!-- { {type_info_1}} -->
				<select name="type1" id="type1" style="width:200px;">
					<?=$_data['type_opt1']?>

				</select>
				<select name="type_sub1" id="type_sub1" style="width:200px;">
					<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
					<?=$_data['type_sub_opt1']?>

				</select>
				<select name="type_sub_sub1" id="type_sub_sub1" style="width:200px;">
					<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
					<?=$_data['type_sub_sub_opt1']?>

				</select>
			</div>
			<span class="h_form" style="display:<?=$_data['form_add_button_view']?>; vertical-align:middle">
				<a class="h_btn_st2 icon_m uk-icon" uk-icon="icon:plus; ratio:0.8"  onClick="formJobtypeAdd()">추가하기</a>
				<span class="font_11 font_dotum" style="letter-spacing:-1px; color:#999">( 최대 3개 )</span>
			</span>
			<div id="jobtype_sel2" class="h_form" style="display:none; margin:5px 0 5px 0;">
				<!-- { {type_info_2}} -->
				<select name="type2" id="type2" style="width:200px;">
					<?=$_data['type_opt2']?>

				</select>
				<select name="type_sub2" id="type_sub2" style="width:200px;">
					<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
					<?=$_data['type_sub_opt2']?>

				</select>
				<select name="type_sub_sub2" id="type_sub_sub2" style="width:200px;">
					<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
					<?=$_data['type_sub_sub_opt2']?>

				</select>
			</div>
			<div id="jobtype_sel3" class="h_form">
				<!-- { {type_info_3}} -->
				<select name="type3" id="type3" style="width:200px;">
					<?=$_data['type_opt3']?>

				</select>
				<select name="type_sub3" id="type_sub3" style="width:200px;">
					<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['1']?></option>
					<?=$_data['type_sub_opt3']?>

				</select>
				<select name="type_sub_sub3" id="type_sub_sub3" style="width:200px;">
					<option value=""><?=$_data['_TYPE_DEPTH_TXT_ARR']['2']?></option>
					<?=$_data['type_sub_sub_opt3']?>

				</select>
			</div>
		</td>
	</tr>
	<tr>
		<th class="title">
			희망근무요일
		</th>
		<td class="sub week" >
			<?=$_data['WeekDaysText']?> <input type="hidden" name="etc7_use" value="1">
		</td>
	</tr>
</table>
<h3 class="noto500 font_25" style="position:relative; padding:50px 0 15px 0; margin:0; letter-spacing:-1px; color:#333;">
	이력서정보
	<span style="position:absolute; top:55px; right:0; color:#999; letter-spacing:-1px; font-weight:normal" class="font_11 font_dotum h_form">
		<label class="h-check" for="security"><input type="checkbox" name="display" value="N" <?=$_data['DataType1']['display']?> id="security" style="vertical-align:middle; "><span class="noto400 font_14" style="vertical-align:middle;">비공개시 체크</span></label>
		<img src="img/form_icon1.gif" style="vertical-align:middle; margin:0 5px 0 10px;">이력서 제목과 자기소개서는 반드시 입력하셔야 합니다..
	</span>
</h3>
<div style="border:3px solid #f69b7d; text-align:center">
	<input type="text" name="title" value="<?=$_data['DataType1']['title']?>" class="font_15" style="width:100%; height:52px; line-height:52px; text-align:center;"  placeholder="이력서 제목을 입력해주세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '이력서 제목을 입력해주세요'">
</div>
<div class="h_form" style="border:2px solid #dfdfdf; padding:20px; margin-top:10px">
	<textarea name="profile" style="height:420px; border:0 none;" class="font_14" placeholder="자기소개서를  작성해주세요" onfocus="this.placeholder = ''"onblur="this.placeholder = '자기소개서를  작성해주세요'"><?=$_data['DataType1']['profile']?></textarea>
</div>
<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_rsum">
	<tr>
		<th class="title">
			첨부파일
			<span style="display:block; margin-top:5px">
				<input type="button" value="" onClick="formImageFormAdd('reset')" style="background:url('img/btn_category_onemore.gif') no-repeat; width:85px; height:30px;cursor:pointer;">
			</span>
		</th>
		<td class="sub" >
			<span style="display:block">
				<span class="h_form"><input type="file" name="file1" id="file1" onChange="fileCheck(this)" style="width:350px"></span>
				<table cellspacing="0" cellpadding="0" style="margin-top:5px;">
					<tr>
						<td class="h_form"><label class="file_down_preview"><?=$_data['미리보기1']?></label></td>
						<td class="h_form" style="padding-left:10px;"><label class="image_del"><?=$_data['삭제1']?></label></td>
					</tr>
				</table>
			</span>
			<span style="display:block; margin-top:5px">
				<span class="h_form"><input type="file" name="file2" id="file2" onChange="fileCheck(this)" style="width:350px"></span>
				<table cellspacing="0" cellpadding="0" style="margin-top:5px;">
					<tr>
						<td class="h_form"><label class="file_down_preview"><?=$_data['미리보기2']?></label></td>
						<td class="h_form" style="padding-left:10px;"><label class="image_del"><?=$_data['삭제2']?></label></td>
					</tr>
				</table>
			</span>
			<span style="display:block; margin-top:5px">
				<span class="h_form"><input type="file" name="file3" id="file3" onChange="fileCheck(this)" style="width:350px"></span>
				<table cellspacing="0" cellpadding="0" style="margin-top:5px;">
					<tr>
						<td class="h_form"><label class="file_down_preview"><?=$_data['미리보기3']?></label></td>
						<td class="h_form" style="padding-left:10px;"><label class="image_del"><?=$_data['삭제3']?></label></td>
					</tr>
				</table>
			</span>
			<span style="display:block; margin-top:5px">
				<span class="h_form"><input type="file" name="file4" id="file4" onChange="fileCheck(this)" style="width:350px"></span>
				<table cellspacing="0" cellpadding="0" style="margin-top:5px;">
					<tr>
						<td class="h_form"><label class="file_down_preview"><?=$_data['미리보기4']?></label></td>
						<td class="h_form" style="padding-left:10px;"><label class="image_del"><?=$_data['삭제4']?></label></td>
					</tr>
				</table>
			</span>
			<span style="display:block; margin-top:5px">
				<span class="h_form"><input type="file" name="file5" id="file5" onChange="fileCheck(this)" style="width:350px"></span>
				<table cellspacing="0" cellpadding="0" style="margin-top:5px;">
					<tr>
						<td class="h_form"><label class="file_down_preview"><?=$_data['미리보기5']?></label></td>
						<td class="h_form" style="padding-left:10px;"><label class="image_del"><?=$_data['삭제5']?></label></td>
					</tr>
				</table>
			</span>
		</td>
		<td class="sub" >
			<p class="font_11 font_dotum" style="letter-spacing:-1px; text-align:left; line-height:18px; color:#999">
				<strong>각종 문서파일 및 이미지파일을 필요에 따라 첨부파일을 등록합니다.</strong><br/>
				별도로 작성한 이력서, 경력요약서, 기획서, 포트폴리오 등을 입사지원시 선택하여 첨부하실 수 있습니다.<br/>
				첨부파일 등록은 최대 5개까지 등록하실 수 있습니다.<br/>
				등록가능한 첨부파일 확장자는 <span style="color:#3bbde2">JPG, JPEG, GIF, ZIP, RAR, PPT, DOC, PPT, XLS</span> 확장자만 업로드 가능합니다.<br/>
				다시를 클릭하시면 선택한 파일의 파일경로명 값이 초기화 됩니다.
			</p>
		</td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse; margin:15px 0">
	<tr>
		<td style="width:790px;border:1px solid #dfdfdf; background:#f1f1f1">
			<div style="padding:30px" class="rsum_keyword" id="keyword_box">
				<?=$_data['키워드내용']?>

			</div>
		</td>
		<td style="border:1px solid #dfdfdf; background:#f1f1f1; vertical-align:top">
			<div style="padding:30px">
				<table cellpadding="0" cellspacing="0" style="width:100%">
					<tr>
						<td class="font_12" style="text-align:left; letter-spacing:-1.2px; color:#333; font-weight:bold; padding-bottom:10px">이력서 검색 키워드 선택</td>
					</tr>
					<tr>
						<td class="h_form">
							<input type="text" name="keyword" id="keyword" readonly value="<?=$_data['키워드']?>"><br><br>
							<a class="h_btn_st2" onClick="copyText()" title="키워드복사 기능은 Internet Explorer 에서만 지원되는 기능입니다.">복사</a>
						</td>
					</tr>
					<tr>
						<td style="line-height:18px; letter-spacing:-1px; color:#666; padding-top:20px" class="font_11 font_dotum">
							키워드는 이력서 검색에 사용되므로 신중하게 이력서 내용에<br>
							적합한 키워드를 선택하시기 바랍니다.<br/>
							키워드 단어를 선택하면 선택된 키워드 단어는 선택 단어폼에 표시가 됩니다.<br/>
							키워드 선택 단어폼에 선택된 키워드 단어를 전체 복사하여 <br/>이력서 제목으로 그대로 활용하셔도 됩니다
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>
<h3 class="noto500 font_25" style="position:relative; padding:50px 0 15px 0; margin:0; border-bottom:2px solid #dfdfdf; letter-spacing:-1px; color:#333;">
	선택사항 추가
	<span style="position:absolute; top:55px; right:0; color:#d75353; letter-spacing:-1px; font-weight:normal" class="font_11 font_dotum">
		입력하실 사항이 있으시다면 체크하신후 내용을 입력해주세요.
	</span>
</h3>

<table cellpadding="0" cellspacing="0" style="width:100%" class="resister_rsum">
	<tr>
		<td class="sub font_14" colspan="2" style="background:#f8f8f9; padding-left:20px">
			<span class="h_form" style="margin-right:40px">
				<label class="h-check" for="oa"><input type="checkbox" id="oa" name="oa" id="oa" value="y" <?=$_data['Data']['oa_checked']?> onChange="etc_option_change(this,'oa_layer')"><span class="noto400 font_15">OA 능력</span></label>
			</span>
			<span class="h_form" style="margin-right:40px">
				<label class="h-check" for="license"><input type="checkbox" id="license" name="license" id="license" value="y" <?=$_data['Data']['license_checked']?> onChange="etc_option_change(this,'license_layer')"><span class="noto400 font_15">자격사항</span></label>
			</span>
			<span class="h_form" style="margin-right:40px">
				<label class="h-check" for="completion"><input type="checkbox" id="completion" name="completion" id="completion" value="y" <?=$_data['Data']['completion_checked']?> onChange="etc_option_change(this,'completion_layer')"><span class="noto400 font_15">보유기술 및 보유이수 내용</span></label>
			</span>
			<span class="h_form" style="margin-right:40px">
				<label class="h-check" for="foreign"><input type="checkbox" id="foreign" name="foreign" id="foreign" value="y" <?=$_data['Data']['foreign_checked']?> onChange="etc_option_change(this,'foreign_layer')"><span class="noto400 font_15">외국어능력</span></label>
			</span>
			<span class="h_form" style="margin-right:40px">
				 <label class="h-check" for="training"><input type="checkbox" id="training" name="training" id="training" value="y" <?=$_data['Data']['training_checked']?> onChange="etc_option_change(this,'training_layer')"><span class="noto400 font_15">해외연수</span></label>
			</span>
			<span class="h_form" style="margin-right:40px">
				<label class="h-check" for="givespecial"><input type="checkbox" id="givespecial" name="givespecial" id="givespecial" value="y" <?=$_data['Data']['givespecial_checked']?> onChange="etc_option_change(this,'givespecial_layer')"><span class="noto400 font_15">초빙우대사항</span></label>
			</span>
		</td>
	</tr>
	<tr id="oa_layer" style="<?=$_data['Data']['oa_style']?>">
		<th class="title" >
			OA능력
		</th>
		<td class="sub" >
			<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse; table-layout:fixed">
				<tr>
					<th class="noto500 font_14" style="width:200px; text-align:left; height:50px; border:1px solid #e9e9e9; padding-left:20px">ㆍ워드(한글/M워드) </th>
					<td style="text-align:left; border:1px solid #e9e9e9; padding-left:20px">
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_word3 h-radio" for="skill_word3">
								<input  type="radio" name="skill_word" value="3" id="skill_word3" <?=$_data['Data']['skill_word3']?>>
								<span class="noto400 font_14"><img src="img/ico_level_high.gif" title="상" alt="상"> 스타일/고급편집기능</span>
							</label>
						</span>
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_word2 h-radio" for="skill_word2">
								<input type="radio" name="skill_word" value="2" id="skill_word2" <?=$_data['Data']['skill_word2']?>>
								<span  class="noto400 font_14"><img src="img/ico_level_middle.gif" title="중" alt="중"> 표/도구 활용가능</span>
							</label>
						</span>
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_word1 h-radio" for="skill_word1">
								<input type="radio" name="skill_word" value="1" id="skill_word1" <?=$_data['Data']['skill_word1']?>>
								<span  class="noto400 font_14"><img src="img/ico_level_low.gif" title="하" alt="하"> 문서 편집 가능</span>
							</label>
						</span>
					</td>
				</tr>
				<tr>
					<th class="noto500 font_14" style="width:200px; text-align:left; height:50px; border:1px solid #e9e9e9; padding-left:20px">ㆍ프리젠테이션(파워포인트) </th>
					<td style="text-align:left; border:1px solid #e9e9e9; padding-left:20px">
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_ppt3 h-radio" for="skill_ppt3">
								<input type="radio" name="skill_ppt" value="3" id="skill_ppt3" <?=$_data['Data']['skill_ppt3']?>>
								<span class="noto400 font_14"><img src="img/ico_level_high.gif" title="상" alt="상"> 멀티미디어/애니메이션 효과 가능</span>
							</label>
						</span>
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_ppt2 h-radio" for="skill_ppt2">
								<input type="radio" name="skill_ppt" value="2" id="skill_ppt2" <?=$_data['Data']['skill_ppt2']?> >
								<span class="noto400 font_14"><img src="img/ico_level_middle.gif" title="중" alt="중"> 차트/그래픽 가능</span>
							</label>
						</span>
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_ppt1 h-radio" for="skill_ppt1">
								<input type="radio" name="skill_ppt" value="1" id="skill_ppt1" <?=$_data['Data']['skill_ppt1']?> >
								<span class="noto400 font_14"><img src="img/ico_level_low.gif" title="하" alt="하"> 서식/도형가능</span>
							</label>
						</span>
					</td>
				</tr>
				<tr>
					<th class="noto500 font_14" style="width:200px; text-align:left; height:50px; border:1px solid #e9e9e9; padding-left:20px">ㆍ스프레드시트(엑셀) </th>
					<td style="text-align:left; border:1px solid #e9e9e9; padding-left:20px">
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_excel3 h-radio" for="skill_excel3" >
								<input type="radio" name="skill_excel" value="3" id="skill_excel3" <?=$_data['Data']['skill_excel3']?> >
								<span class="noto400 font_14"><img src="img/ico_level_high.gif" title="상" alt="상"> 고급함수/피벗테이블 가능</span>
							</label>
						</span>
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_excel2 h-radio" for="skill_excel2">
								<input type="radio" name="skill_excel" value="2" id="skill_excel2" <?=$_data['Data']['skill_excel2']?> >
								<span class="noto400 font_14"><img src="img/ico_level_middle.gif" title="중" alt="중"> 일반함수/수식 가능</span>
							</label>
						</span>
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_excel1 h-radio" for="skill_excel1">
								<input type="radio" name="skill_excel" value="1" id="skill_excel1" <?=$_data['Data']['skill_excel1']?> >
								<span class="noto400 font_14"><img src="img/ico_level_low.gif" title="하" alt="하"> 데이터 편집 가능</span>
							</label>
						</span>
					</td>
				</tr>
				<tr>
					<th class="noto500 font_14" style="width:200px; text-align:left; height:50px; border:1px solid #e9e9e9; padding-left:20px">ㆍ인터넷 (정보검색/Outlook) </th>
					<td style="text-align:left; border:1px solid #e9e9e9; padding-left:20px">
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_search3 h-radio" for="skill_search3">
								<input type="radio" name="skill_search" value="3" id="skill_search3" <?=$_data['Data']['skill_search3']?> >
								<span class="noto400 font_14"><img src="img/ico_level_high.gif" title="상" alt="상"> 스타일/고급편집 가능</span>
							</label>
						</span>
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_search2 h-radio" for="skill_search2">
								<input type="radio" name="skill_search" value="2" id="skill_search2" <?=$_data['Data']['skill_search2']?> >
								<span class="noto400 font_14"><img src="img/ico_level_middle.gif" title="중" alt="중"> 표/도구 활용 가능</span>
							</label>
						</span>
						<span class="h_form" style="width:250px; text-align:left; display:inline-block">
							<label class="skill_search1 h-radio" for="skill_search1">
								<input type="radio" name="skill_search" value="1" id="skill_search1" <?=$_data['Data']['skill_search1']?> >
								<span class="noto400 font_14"><img src="img/ico_level_low.gif" title="하" alt="하"> 문서 편집 가능</span>
							</label>
						</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr id="license_layer" style="<?=$_data['Data']['license_style']?>">
		<th class="title" >
			자격사항
			<span style="display:block; margin-top:5px">
				<input type="button" value="" onClick="work_layer_add1()" style="background:url('img/btn_category_add2.gif') no-repeat; width:50px; height:20px; border:0 solid red; cursor:pointer;">
			</span>
		</th>
		<td class="sub" >
			<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
				<tr>
					<th class="noto400 font_14" style="width:320px; height:40px; padding-right:30px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">자격증명</th>
					<th class="noto400 font_14" style="width:200px; padding-right:39px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">발행처</th>
					<th class="noto400 font_14" style="border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">취득일자</th>
					<th class="noto400 font_14" style="width:120px; padding-left:45px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">삭제</th>
				</tr>
			</table>
			<div id="kwak1" style="display:none; ">
				<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed;">
					<tr>
						<td class="h_form" style="width:320px; height:50px; padding-right:30px;">
							<input type="text" name="skill_name__kwak" style="width:100%">
						</td>
						<td class="h_form" style="width:200px; padding-right:30px;">
							<input type="text" name="skill_from__kwak" style="width:100%">
							</td>
						<td class="h_form" style="">
							<select name="skill_getYear__kwak" id="skill_getYear__kwak" style="width:100px;">
								<?=$_data['년도옵션']?>

							</select>
							<select name="skill_getMonth__kwak" id ="skill_getMonth__kwak" style="width:100px;">
								<?=$_data['월옵션']?>

							</select>
							<select name="skill_getDay__kwak" id="skill_getDay__kwak" style="width:100px;">
								<?=$_data['일옵션']?>

							</select>
						</td>
						<td class="h_form" style="width:120px; padding-left:45px; ">
							<label class='h-check' for="delete_skill__kwak"><input type="checkbox" name="delete_skill__kwak" value="1" id="delete_skill__kwak"><span class="noto400 font_14">삭제시 체크</span></label>
						</td>
					</tr>
				</table>
			</div>
			<!-- 요아래 DIV도 지우시면 안됩니다. 실제 출력되는 부분.. -->
			<div id="kwak_view1"></div>
			<!-- 요까이 -->
			<p class="font_11 font_dotum" style="letter-spacing:-1px; padding-top:10px; font-weight:bold; color:#999">
				이전 이력서 등록시 여기 기록한 정보가 있을 경우 이전 기록한 정보가 자동 출력됩니다.
			</p>
		</td>
	</tr>
	<tr id="completion_layer" style="<?=$_data['Data']['completion_style']?>">
		<th class="title" style="line-height:24px">
			보유기술 및<br/>
			보유이수 내용
		</th>
		<td class="sub h_form" >
			<textarea name="skill_list" style="height:177px; margin-bottom:10px;"><?=$_data['Data']['skill_list']?></textarea>
			<p class="font_11 font_dotum" style="letter-spacing:-1px; color:#999; line-height:18px">
				예제)<br/>
				[보유기술]<br/>
				PHP, MySQL, JavaScript, HTML, CSS, Illustraoter, Flash, Photoshop<br/>
				[교육사항]<br/>
				2001년 02월 ~ 2001년 08월 : 해피 교육센터 웹디자인 과정 수료<br/>
				2002년 04월 ~ 2001년 10월 : 대한 교육센터 컴퓨터시스템 과정 수료
			</p>
		</td>
	</tr>
	<tr id="foreign_layer" style="<?=$_data['Data']['foreign_style']?>">
		<th class="title">
			외국어 능력
			<span style="display:block; margin-top:5px">
				<input type="button" value="" onClick="work_layer_add2()" style="background:url('img/btn_category_add2.gif') no-repeat; width:50px; height:20px; border:0 solid red; cursor:pointer;">
			</span>
		</th>
		<td class="sub" >
			<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
				<tr>
					<th class="noto400 font_14" style="width:102px; height:40px; padding-right:10px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">외국어명</th>
					<th class="noto400 font_14" style="width:180px; padding-right:10px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">공인시험</th>
					<th class="noto400 font_14" style="border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">취득일자</th>
					<th class="noto400 font_14" style="width:95px; padding-right:10px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">
						점수
					</th>
					<th class="noto400 font_14" style="width:180px;  border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">
						능력
					</th>
					<th class="noto400 font_14" style="width:120px; padding-left:10px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">삭제</th>
				</tr>
			</table>
			<div id="kwak2" style="display:none">
				<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed;">
					<tr>
						<td class="h_form" style="width:102px; height:50px; padding-right:10px;">
							<select id="language_title__kwak"  name="language_title__kwak" style="width:100%"><?=$_data['외국어능력옵션']?></select>
						</td>
						<td class="h_form" style="width:180px; padding-right:10px;">
							<select id="language_check__kwak" name="language_check__kwak" style="width:100%"><?=$_data['외국어자격증옵션']?></select>
						</td>
						<td class="h_form" style="">
							<select id="language_year__kwak" name="language_year__kwak" title="취득일자(년)" style="width:100px;">
								<?=$_data['년도옵션']?>

							</select>
							<select id="language_month__kwak" name="language_month__kwak" title="취득일자(월)" style="width:100px;">
								<?=$_data['월옵션']?>

							</select>
							<select id="language_day__kwak" name="language_day__kwak" title="취득일자(일)" style="width:100px;">
								<?=$_data['일옵션']?>

							</select>
						</td>
						<td class="h_form" style="width:95px; padding-right:10px;">
							<input type="text" name="language_point__kwak" style="width:70px"> <span class="noto400 font_14">점</span>
						</td>
						<td class="h_form" style="width:180px;">
							<label class="h-radio" for="language_skill__kwak3">
								<input type="radio" name="language_skill__kwak" value="3" id="language_skill__kwak3" <?=$_data['Data']['language_skill3']?> >
								<span><img src="img/ico_level_high.gif" alt="상" title="상"></span>
							</label>
							<label class="h-radio" for="language_skill__kwak2">
								<input type="radio" name="language_skill__kwak" value="2" id="language_skill__kwak2" <?=$_data['Data']['language_skill2']?> >
								<span><img src="img/ico_level_middle.gif" alt="중" title="중"></span>
							</label>
							<label class="h-radio" for="language_skill__kwak2">
								<input type="radio" name="language_skill__kwak" value="1" id="language_skill__kwak1" <?=$_data['Data']['language_skill1']?> >
								<span><img src="img/ico_level_low.gif" alt="하" title="하"  style="vertical-align:middle"></span>
							</label>
						</td>
						<td class="h_form" style="width:120px; padding-left:10px; ">
							<label class='h-check' for="delete_language_skill__kwak"><input type="checkbox" name="delete_language_skill__kwak" value="1" id="delete_language_skill__kwak"><span class="noto400 font_14">삭제시 체크</span></label>
						</td>
					</tr>
				</table>
			</div>
			<!-- 요아래 DIV도 지우시면 안됩니다. 실제 출력되는 부분.. -->
			<div id="kwak_view2" style="float:left; clear:both; width:100%; height:auto; margin-bottom:-1px; border:0px solid red;"></div>
			<!-- 요까이 -->
			<p class="font_11 font_dotum" style="letter-spacing:-1px; color:#999; line-height:18px; padding-top:10px">
				외국어능력에 대한 내용이 있으시면 작성을 하시면 됩니다.<br/>
				외국어능력 내용이 2개 이상일 경우 필요한 만큼 추가 버튼을 클릭하시면 됩니다.<br/>
				추가생성된 항목을 삭제하실 경우 삭제시체크에 체크하시면 됩니다.<br/>
				<strong>이전 이력서 등록시 여기 기록한 정보가 있을 경우 이전 기록한 정보가 자동 출력됩니다.</strong>
			</p>
		</td>
	</tr>
	<tr id="training_layer" style="<?=$_data['Data']['training_style']?>">
		<th class="title">
			해외연수
			<span style="display:block; margin-top:5px">
				<input type="button" value="" onClick="work_layer_add3()" style="background:url('img/btn_category_add2.gif') no-repeat; width:50px; height:20px; border:0 solid red; cursor:pointer;">
			</span>
		</th>
		<td class="sub">
			<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
				<tr>
					<th class="noto400 font_14" style="width:110px; height:40px; padding-right:10px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">연수국가</th>
					<th class="noto400 font_14" style="padding-right:10px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px; text-align:left">
						<span style="padding-left:40px">연수기간</span>
					</th>
					<th class="noto400 font_14" style="width:280px; padding-right:20px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">
						목적 및 내용
					</th>
					<th class="noto400 font_14" style="width:120px; border-top:1px solid #d5d5d5; border-bottom:1px solid #e9e9e9; background:#fafafa; letter-spacing:-1px;">삭제</th>
				</tr>
			</table>
			<div id="kwak3" style="display:none">
				<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
					<tr>
						<th class="h_form" style="width:110px; height:50px; padding-right:10px;">
							<select id="country__kwak" name="country__kwak" style="width:100%;"><?=$_data['연수국가옵션']?></select>
						</th>
						<th class="h_form" style="padding-right:10px;">
							<select id="startYear__kwak"name="startYear__kwak" style="width:100px;"><?=$_data['년도옵션']?></select> <span class="noto400 font_14">년</span>
							<select id="startMonth__kwak" name="startMonth__kwak" style="width:100px;"><?=$_data['월옵션']?></select> <span class="noto400 font_14">월</span> ~
							<select id="endYear__kwak" name="endYear__kwak" style="width:100px;"><?=$_data['년도옵션']?></select> <span class="noto400 font_14">년</span>
							<select id="endMonth__kwak" name="endMonth__kwak" style="width:100px;"><?=$_data['월옵션']?></select> <span class="noto400 font_14">월</span>
						</th>
						<th class="h_form" style="width:280px; padding-right:20px;">
							<input type="text" name="content__kwak" style="width:100%; ">
						</th>
						<th class="h_form" style="width:120px;">
							<label class="delete_yunsoo__kwak guzic_text h-check" for="delete_yunsoo__kwak">
								<input type="checkbox" name="delete_yunsoo__kwak" value="1" id="delete_yunsoo__kwak"><span class="noto400 font_14">삭제시체크</span>
							</label>
						</th>
					</tr>
				</table>
			</div>
			<!-- 요아래 DIV도 지우시면 안됩니다. 실제 출력되는 부분.. -->
			<div id="kwak_view3"></div>
			<!-- 요까이 -->
			<p class="font_11 font_dotum" style="letter-spacing:-1px; padding-top:10px; font-weight:bold; color:#999">
				이전 이력서 등록시 여기 기록한 정보가 있을 경우 이전 기록한 정보가 자동 출력됩니다.
			</p>
		</td>
	</tr>
	<tr id="givespecial_layer" style="<?=$_data['Data']['givespecial_style']?>">
		<th class="title" >
			초빙우대사항
		</th>
		<td class="sub" >
			<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse: collapse; table-layout:fixed">
				<tr>
					<th class="noto500 font_14" style="width:200px; text-align:left; height:50px; border:1px solid #e9e9e9; padding-left:20px">ㆍ보훈대상여부 </th>
					<td style="text-align:left; border:1px solid #e9e9e9; padding-left:20px">
						<?=$_data['bohunRadio']?>

					</td>
				</tr>
				<tr>
					<th class="noto500 font_14" style="width:200px; text-align:left; height:50px; border:1px solid #e9e9e9; padding-left:20px">ㆍ장애여부 </th>
					<td style="text-align:left; border:1px solid #e9e9e9; padding:20px">
						<?=$_data['jangaeRadio']?>

						<span class="noto400 font_14" style="display:block; margin-top:10px">장애등급 <span class='h_form' style="display:inline-block; width:100px;"><?=$_data['jangaeSelect']?></span> 급</span>
					</td>
				</tr>
				<tr>
					<th class="noto500 font_14" style="width:200px; text-align:left; height:50px; border:1px solid #e9e9e9; padding-left:20px">ㆍ병역사항 </th>
					<td style="text-align:left; border:1px solid #e9e9e9; padding:20px">
						<span style="display:block">
							<?=$_data['armyRadio']?>

						</span>
						<span style="display:block; margin-top:10px">
							<span class='h_form army_select' style="display:inline-block;"><?=$_data['armySelect1']?></span>
							<span class="noto400 font_14">입대</span> ~
							<span class='h_form army_select' style="display:inline-block;"><?=$_data['armySelect2']?></span>
							<span class="noto400 font_14">제대 </span>
							<span class='h_form' style="display:inline-block; width:100px;"><?=$_data['armySelect3']?></span>
							<span class='h_form' style="display:inline-block; width:100px;"><?=$_data['armySelect4']?></span>
							<span class='h_form' style="display:inline-block; width:100px;"><?=$_data['armyStart']?></span>
						</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- 이전에 입력된 내용을 기본으로 불러옴 -->
<?=$_data['defaultSetting']?>


<div style="margin:25px 0 25px 0; text-align:center;">
	<!-- 결제버튼 -->
	<ul id="uryo_button_layer">
		<input type="submit" style="background:url('img/skin_icon/make_icon/skin_icon_701.jpg') 0 0 no-repeat; width:180px; height:60px; text-indent:-1000%; cursor:pointer">
	</ul>
</div>

</form>
<? }
?>