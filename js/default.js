/* temp/popup_window_common.html 로 옮김
//오늘 본 채용정보 (팝업창) 보기/감추기
function todayView(state){
	var btn_close_popup		= document.getElementById("btn_close_popup");
	var today_view_popup	= document.getElementById("today_view_popup");

	if(state == "on"){
		today_view_popup.style.display = "block";
	}else{
		today_view_popup.style.display = "none";
	}
}
//오늘 본 이력서정보 (팝업창) 보기/감추기
function todayResumeView(state){
	var btn_close_popup		= document.getElementById("btn_close_popup");
	var today_view_popup	= document.getElementById("today_view_popup_resume");

	if(state == "on"){
		today_view_popup.style.display = "block";
	}else{
		today_view_popup.style.display = "none";
	}
}


//마이페이지 팝업메뉴 (최상단메뉴) : 기업회원
function mypagePopupMenu(state){
	var mypage_popup_menu				= document.getElementById("mypage_popup_menu_standard");

	if(state == "view"){
		mypage_popup_menu.style.display = "";
	}else{
		mypage_popup_menu.style.display = "none";
	}
}

//마이페이지 팝업메뉴 (최상단메뉴) : 개인회원
function mypagePopupMenuPer(state){
	var mypage_popup_menu				= document.getElementById("mypage_popup_menu_standard_per");

	if(state == "view"){
		mypage_popup_menu.style.display = "";
	}else{
		mypage_popup_menu.style.display = "none";
	}
}
*/


function setCookie( name, value, expiredays )
{
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function getCookie( name )
{
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie )
		{
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
				endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}

		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
			break;
	}
	return "";
}

//로그인, 플래시배너 확장/감추기 토글버튼
var num = (parseInt(getCookie('search_expand')) == true)?getCookie('search_expand'):0;

function toggleMenuViewHide(state){
	var btn_expand			= document.getElementById("btn_expand");
	var main_login_banner	= document.getElementById("main");
	var shadow				= document.getElementById("shadow");
	var ico_tag_open		= document.getElementById("ico_tag_open");

	num++;

	if(state == "on")
	{
		//if( num%2 == 1 )
		if( num%2 == 0 )
		{
			main_login_banner.style.display = "none";
			shadow.style.width = "99%";
			btn_expand.src = "./img/btn_expand_login.png";
			ico_tag_open.style.display = "block";

			setCookie("search_expand",(num-1),1);
		}
		else
		{
			main_login_banner.style.display = "block";
			shadow.style.width = "100%";
			btn_expand.src = "./img/btn_expand_login_no.png";
			ico_tag_open.style.display = "none";

			setCookie("search_expand",(num-1),1);
		}

	}
	else if(state == "off"){
		if(num%2 == 1){
			main_login_banner.style.display = "none";
			shadow.style.width = "99%";
			btn_expand.src = "./img/btn_expand_login.png";
		}else{
			main_login_banner.style.display = "block";
			shadow.style.width = "100%";
			btn_expand.src = "./img/btn_expand_login_no.png";
		}
	}else{
		if(num%2 == 1){
			main_login_banner.style.display = "block";
			shadow.style.width = "100%";
			btn_expand.src = "./img/btn_expand_login_no.png";
		}else{
			main_login_banner.style.display = "none";
			shadow.style.width = "99%";
			btn_expand.src = "./img/btn_expand_login.png";
		}
	}
}

//상세정보검색 Tray 보이기 및 토글버튼
var count = 0;
function toggleTraySearchViewHide(state){
	var btn_tray_toggle				= document.getElementById("btn_tray_toggle");
	var tray_toggle_search			= document.getElementById("tray_toggle_search");
	var tray_toggle_search_shadow	= document.getElementById("tray_toggle_search_shadow");

	var tray_toggle_resume_option	= document.getElementById("tray_toggle_resume_option");
	var btn_toggle_resume_option	= document.getElementById("btn_toggle_resume_option");

	count++;

	if(state == "on"){
		if(count%2 == 1){
			if (tray_toggle_resume_option.style.display="block")
			{
				tray_toggle_resume_option.style.display = "none"
				btn_toggle_resume_option.style.backgroundImage = "url('./img/btn_toggle2_off.png')";
				countResumeOption = 0;
			}
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on.png";
		}else{
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}
	}else if(state == "off"){
		if(count%2 == 1){
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on.png";
		}else{
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}
	}else if(state == "--"){
		if(count%2 == 1){
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}else{
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on.png";
		}
	}else{
		if(count%2 == 1){
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}else{
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on.png";
		}
	}
}

//상세정보검색 Tray 보이기 및 토글버튼
var count2 = 0;
function toggleTraySearchViewHide2(state){
	var btn_tray_toggle				= document.getElementById("btn_tray_toggle");
	var tray_toggle_search			= document.getElementById("tray_toggle_search");
	var tray_toggle_search_shadow	= document.getElementById("tray_toggle_search_shadow");

	count2++;

	if(state == "on"){
		if(count2%2 == 1){
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on_resume.png";
		}else{
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}
	}else if(state == "off"){
		if(count2%2 == 1){
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on_resume.png";
		}else{
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}
	}else if(state == "--"){
		if(count2%2 == 1){
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}else{
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on_resume.png";
		}
	}else{
		if(count2%2 == 1){
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}else{
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on_resume.png";
		}
	}
}


//상세정보검색 Tray 보이기 및 토글버튼 (아르바이트)
var countAlab = 0;
function toggleTraySearchViewHideAlba(state){
	var btn_tray_toggle				= document.getElementById("btn_tray_toggle");
	var tray_toggle_search			= document.getElementById("tray_toggle_search_alba");
	var tray_toggle_search_shadow	= document.getElementById("tray_toggle_search_shadow");

	countAlab++;

	if(state == "on"){
		if(countAlab%2 == 1){
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on.png";
		}else{
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}
	}else if(state == "off"){
		if(countAlab%2 == 1){
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on.png";
		}else{
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}
	}else if(state == "--"){
		if(countAlab%2 == 1){
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}else{
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on.png";
		}
	}else{
		if(countAlab%2 == 1){
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}else{
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on.png";
		}
	}
}


//상세정보검색 Tray 보이기 및 토글버튼 (인재정보)
var countResume = 0;
function toggleTraySearchResumeViewHide(state){
	var btn_tray_toggle				= document.getElementById("btn_tray_toggle");
	var tray_toggle_search			= document.getElementById("tray_toggle_search");
	var tray_toggle_search_shadow	= document.getElementById("tray_toggle_search_shadow");

	var tray_toggle_resume_option	= document.getElementById("tray_toggle_resume_option");
	var btn_toggle_resume_option	= document.getElementById("btn_toggle_resume_option");

	countResume++;

	if(state == "on"){
		if(countResume%2 == 1){
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on_resume.png";

			if (tray_toggle_resume_option.style.display="block")
			{
				tray_toggle_resume_option.style.display = "none"
				btn_toggle_resume_option.style.backgroundImage = "url('./img/btn_toggle2_off.png')";
				countResumeOption = 0;
			}
		}else{
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}
	}else if(state == "off"){
		if (tray_toggle_resume_option.style.display="block")
		{
			tray_toggle_resume_option.style.display = "none"
			countResumeOption = 0;
		}
		if(countResume%2 == 1){
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on_resume.png";
		}else{
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}
	}else if(state == "--"){
		if(countResume%2 == 1){
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}else{
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on_resume.png";
		}
	}else{
		if(countResume%2 == 1){
			tray_toggle_search.style.display = "block";
			tray_toggle_search_shadow.style.display = "none";
			btn_tray_toggle.src = "./img/btn_toggle_search_off.png";
		}else{
			tray_toggle_search.style.display = "none";
			tray_toggle_search_shadow.style.display = "block";
			btn_tray_toggle.src = "./img/btn_toggle_search_on_resume.png";
		}
	}
}

//상세정보검색 Tray 토글버튼 (인재정보)
var countResumeOption = 0;
function resumeOptionView(state){
	var tray_toggle_resume_option	= document.getElementById("tray_toggle_resume_option");
	var btn_toggle_resume_option	= document.getElementById("btn_toggle_resume_option");

	countResumeOption++;

	if (countResumeOption%2 == 1)
	{
		tray_toggle_resume_option.style.display = "block";
		btn_toggle_resume_option.style.backgroundImage = "url('./img/btn_toggle2_on.png')";
	}
	else
	{
		tray_toggle_resume_option.style.display = "none";
		btn_toggle_resume_option.style.backgroundImage = "url('./img/btn_toggle2_off.png')";
	}

}


//채용정보 등록페이지 : 외국어능력 시험정보 팝업창 보이기/감추기
var flangNum = 0;
function foreignLangInfo(state){
	var foreign_lang_help = document.getElementById("foreign_lang_help");
	flangNum++;

	if(state == 'view'){
		if(flangNum % 2 == 1) {
			foreign_lang_help.style.display = "block";
		}else{
			foreign_lang_help.style.display = "none";
		}
	}else if (state == 'close'){
		foreign_lang_help.style.display = "none";
		flangNum = 0;
	}
}


//사전인터뷰 예문보기 샘플
var interViewNum = 0;
function interviewSample(state){
	var interview_sample = document.getElementById("interview_sample");
	interViewNum++;

	if(state == 'view'){
		if(interViewNum % 2 == 1) {
			interview_sample.style.display = "block";
		}else{
			interview_sample.style.display = "none";
		}
	}else if (state == 'close'){
		interview_sample.style.display = "none";
		interViewNum = 0;
	}
}


//회사위치 지도 팝업관련
var viewnum = 0;
function comMapPosView(state) {
	var com_map_position = document.getElementById("com_map_position");
	viewnum++;

	if(state == 'view'){
		if(viewnum%2 == 1) {
			com_map_position.style.visibility = "visible";
		}else{
			com_map_position.style.visibility = "hidden";
		}
	}else if (state == 'close'){
		com_map_position.style.visibility = "hidden";
		viewnum = 0;
	}
}

//진행중인 채용정보 / 마감된 채용정보 탭메뉴 관련
function changeTabMenuRecruit(state) {
	var n1_recruiting	= document.getElementById("n1_recruiting");
	var n2_endrecruit	= document.getElementById("n2_endrecruit");
	var list_recruiting = document.getElementById("list_recruiting");
	var list_endrecruit = document.getElementById("list_endrecruit");
	var tr_recruiting	= document.getElementById("tr_recruiting");
	var tr_endrecruit	= document.getElementById("tr_endrecruit");


	if (state == "1") {
		n1_recruiting.style.background = "url('./img/tabbg_recruit_ov.gif')";
		n2_endrecruit.style.background = "url('./img/tabbg_recruit.gif')";
		n1_recruiting.style.color = "#FFF";
		n2_endrecruit.style.color = "#999";
		list_recruiting.style.display = "block";
		list_endrecruit.style.display = "none";
		tr_recruiting.style.display = "block";
		tr_endrecruit.style.display = "none";
	}else if (state == "2") {
		n1_recruiting.style.background = "url('./img/tabbg_recruit.gif')";
		n2_endrecruit.style.background = "url('./img/tabbg_recruit_ov.gif')";
		n1_recruiting.style.color = "#999";
		n2_endrecruit.style.color = "#FFF";
		list_recruiting.style.display = "none";
		list_endrecruit.style.display = "block";
		tr_recruiting.style.display = "none";
		tr_endrecruit.style.display = "block";
	}
}

//입사지원 및 입사제의, 면접제의 탭메뉴 관련
function changeTabMenuResume(state) {
	var n1_recruiting	= document.getElementById("n1_recruiting");
	var n2_endrecruit	= document.getElementById("n2_endrecruit");
	var list_recruiting = document.getElementById("list_recruiting");
	var list_endrecruit = document.getElementById("list_endrecruit");
	var list_endrecruit2 = document.getElementById("list_endrecruit2");
	var tr_recruiting	= document.getElementById("tr_recruiting");
	var tr_endrecruit	= document.getElementById("tr_endrecruit");
	var tr_endrecruit2	= document.getElementById("tr_endrecruit2");


	if (state == "1") {
		n1_recruiting.style.background = "url('./img/tabbg_resume_s_ov.gif')";
		n2_endrecruit.style.background = "url('./img/tabbg_resume_s.gif')";
		n1_recruiting.style.color = "#FFF";
		n2_endrecruit.style.color = "#999";
		list_recruiting.style.display = "block";
		list_endrecruit.style.display = "none";
		list_endrecruit2.style.display = "none";
		tr_recruiting.style.display = "block";
		tr_endrecruit.style.display = "none";
		tr_endrecruit2.style.display = "none";
	}else if (state == "2") {
		n1_recruiting.style.background = "url('./img/tabbg_resume_s.gif')";
		n2_endrecruit.style.background = "url('./img/tabbg_resume_s_ov.gif')";
		n1_recruiting.style.color = "#999";
		n2_endrecruit.style.color = "#FFF";
		list_recruiting.style.display = "none";
		list_endrecruit.style.display = "block";
		list_endrecruit2.style.display = "none";
		tr_recruiting.style.display = "none";
		tr_endrecruit.style.display = "block";
		tr_endrecruit2.style.display = "none";
	}else if (state == "3") {
		n1_recruiting.style.background = "url('./img/tabbg_resume_s.gif')";
		n2_endrecruit.style.background = "url('./img/tabbg_resume_s_ov.gif')";
		n1_recruiting.style.color = "#999";
		n2_endrecruit.style.color = "#FFF";
		list_recruiting.style.display = "none";
		list_endrecruit.style.display = "none";
		list_endrecruit2.style.display = "block";
		tr_recruiting.style.display = "none";
		tr_endrecruit.style.display = "none";
		tr_endrecruit2.style.display = "block";
	}
}


//팝업윈도우
function open_window(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
{
 toolbar_str = toolbar ? 'yes' : 'no';
 menubar_str = menubar ? 'yes' : 'no';
 statusbar_str = statusbar ? 'yes' : 'no';
 scrollbar_str = scrollbar ? 'yes' : 'no';
 resizable_str = resizable ? 'yes' : 'no';
 window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
}


//온라인입사지원 삭제함수
function OnlineDel(num)
{
	TmpUrl = '';
	if ( confirm("온라인입사지원건이 확인전이므로 취소하실수 있습니다.\n\n취소하시겠습니까?") )
	{
		TmpUrl = './guin_join_del.php?mode=del';
		TmpUrl += '&number='+num;
		document.location.href = TmpUrl;
	}
}


//[ YOON : 2009-09-16 토글형설명박스 ( 한페이지 하나일 때 주로사용)]
//div 의 id값을 'help_view[번호]' 형식으로 하면 됨.
function helpView(num){
	if(document.getElementById("help_view" + num).style.display == 'none'){
		document.getElementById("help_view" + num).style.display = 'block';
	}else{
		document.getElementById("help_view" + num).style.display = 'none';
	}

}


//[ YOON : 2011-11-19 나눔글꼴 사용 라이선스 ]
function goLicense () {
	window.open("http://help.naver.com/ops/step2/faq.nhn?faqId=15879","naverfont_license","top=0,left=0,width=970,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no");
}


// 우편번호 팝업창 : 이력서등록페이지
happyMemberSrc	= '';
function happy_member_post_finder( post, addr1, addr2 )
{
	//alert(post +" "+ addr);

	window.open(happyMemberSrc+"happy_zipcode.php?post="+post+"&addr1="+addr1+"&addr2="+addr2,"happy_zipcode","width=400,height=400,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes");
}


function FlashXmlbody(Ftrans,wid,hei) {

 mainbody = "<embed src='"+ Ftrans +"' quality='high' align='middle' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='"+ wid +"' height='"+ hei +"'></embed>"

 document.write(mainbody);
 return;
}

// 탭메뉴 자바스크립트
happy_tab_menu_now  = new Array();
function happy_tab_menu(layer, nowNumber)
{
	if ( happy_tab_menu_now[layer] == undefined )
	{
		happy_tab_menu_now[layer]	= 1;
	}

	if ( happy_tab_menu_now[layer] == nowNumber )
	{
		return false;
	}

	var obj						= document.getElementById(layer+'_'+ nowNumber);
	var obj_layer				= document.getElementById(layer+'_layer_'+ nowNumber);
	var obj_old					= document.getElementById(layer+'_'+ happy_tab_menu_now[layer]);
	var obj_old_layer			= document.getElementById(layer+'_layer_'+ happy_tab_menu_now[layer]);

	if ( obj.getAttribute("oversrc") != undefined && obj.getAttribute("outsrc") != undefined && obj.src != undefined && obj_old.src != undefined )
	{
		obj.src						= obj.getAttribute("oversrc");
		obj_old.src					= obj_old.getAttribute("outsrc");
	}
	else if ( obj.getAttribute("overClass") != undefined && obj.getAttribute("outClass") != undefined && obj.className != undefined && obj_old.className != undefined )
	{
		obj.className				= obj.getAttribute("overClass");
		obj_old.className			= obj_old.getAttribute("outClass");
	}
	else
	{
		obj_layer.innerHTML			= obj_layer.innerHTML + '<br><font color=red>happy_tab_menu() 함수 구동 오류</font>';
	}


	obj_layer.style.display		= '';
	obj_old_layer.style.display	= 'none';

	happy_tab_menu_now[layer]	= nowNumber;
}
// 탭메뉴 자바스크립트


//간단 레이어 열고 닫기소스
function view_layer( layer_id )
{
	Obj						= document.getElementById(layer_id);
	Obj.style.display		= Obj.style.display == ''? 'none' : '';
}
//간단 레이어 열고 닫기소스

//메인 rows 마우스오버 소스
function view_layer_rotate( layer_id , rotate_obj )
{
	Obj						= document.getElementById(layer_id);

	if ( Obj.style.display == '' )
	{
		Obj.style.display		= 'none';

		if ( rotate_obj )
		{
			$(rotate_obj).removeClass('uk-open');
		}
	}
	else
	{
		Obj.style.display		= '';

		if ( rotate_obj )
		{
			$(rotate_obj).addClass('uk-open');
		}
	}
}

//{{메인탑메뉴 happy_menu_top.html}} 에서 사용
var main_top_b_layer = '1';
var first_loading = 0;
var topMenuView_Time = '';

function change_main_top(layer_number)
{
	if ( !document.getElementById('top_layer1') )
	{
		return;
	}

	if ( topMenuView_Time != '' )
	{
		clearTimeout(topMenuView_Time);
		topMenuView_Time		= '';
	}

	if ( first_loading == 1 )	// 최초로딩시 상위메뉴에 속하지 않은 페이지였다면 다시 감추기
	{
		document.getElementById('top_layer1').style.display = "none";
		first_loading++;
	}

	if ( document.getElementById('top_layer' + main_top_b_layer) != undefined )
	{
		document.getElementById('top_layer' + main_top_b_layer).style.display = "none";
	}

	main_top_b_layer = layer_number;

	if ( document.getElementById('top_layer' + layer_number) != undefined )
	{
		document.getElementById('top_layer' + layer_number).style.display = "";
	}
	else if ( first_loading == 0 ) // 최초로딩시 상위메뉴에 속하지 않은 페이지라면 첫번째꺼 나오게 하기
	{
		first_loading++;
		document.getElementById('top_layer1').style.display = "";
	}
}

function change_main_top_close(layer_number)
{
	topMenuView_Time		= setTimeout("change_main_top_close2("+layer_number+")", 300);
}

function change_main_top_close2(layer_number)
{
	if ( document.getElementById('top_layer' + layer_number) )
	{
		document.getElementById('top_layer' + layer_number).style.display = "none";
	}
}



var main_top_c_layer = '1';
var first_loading3 = 0;
var sub_menu_over_check3 = false;
var sub_menu_setTimeout3	= '';
function change_main_top3(layer_number)
{
	if( layer_number == '' )
	{
		return;
	}
	if ( first_loading3 == 1 )	// 최초로딩시 상위메뉴에 속하지 않은 페이지였다면 다시 감추기
	{
		document.getElementById('top_layerc1').style.display = "none";
		first_loading3++;
	}

	if ( document.getElementById('top_layerc' + main_top_c_layer) != undefined )
	{
		document.getElementById('top_layerc' + main_top_c_layer).style.display = "none";
	}

	main_top_c_layer = layer_number;

	if ( document.getElementById('top_layerc' + layer_number) != undefined )
	{
		document.getElementById('top_layerc' + layer_number).style.display = "";
		sub_menu_over3();
	}
	else if ( first_loading3 == 0 ) // 최초로딩시 상위메뉴에 속하지 않은 페이지라면 첫번째꺼 나오게 하기
	{
		first_loading3++;
		document.getElementById('top_layerc_1').style.display = "";
	}
}


function sub_menu_over3()
{
	sub_menu_over_check3	= true;
	//document.getElementById('kwak').innerText = 'true';
	if ( sub_menu_setTimeout3 != '' )
	{
		clearInterval(sub_menu_setTimeout3);
	}
}


function sub_menu_out3()
{
	sub_menu_over_check3	= false;
	//document.getElementById('kwak').innerText = 'false';

	if ( sub_menu_setTimeout3 != '' )
	{
		clearInterval(sub_menu_setTimeout3);
	}

	sub_menu_setTimeout3	= setTimeout( 'sub_menu_hidden3()', 300 );
}


function sub_menu_hidden3()
{
	if ( sub_menu_over_check3 == false )
	{
		if ( document.getElementById('top_layerc' + main_top_c_layer) != undefined )
		{
			document.getElementById('top_layerc' + main_top_c_layer).style.display = "none";
		}
	}
	sub_menu_setTimeout3	= '';
}




function str_replace(search, replace, subject, count) {
  var i = 0,
    j = 0,
    temp = '',
    repl = '',
    sl = 0,
    fl = 0,
    f = [].concat(search),
    r = [].concat(replace),
    s = subject,
    ra = Object.prototype.toString.call(r) === '[object Array]',
    sa = Object.prototype.toString.call(s) === '[object Array]';
  s = [].concat(s);
  if (count) {
   this.window[count] = 0;
  }

  for (i = 0, sl = s.length; i < sl; i++) {
    if (s[i] === '') {
      continue;
    }
    for (j = 0, fl = f.length; j < fl; j++) {
      temp = s[i] + '';
      repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
      s[i] = (temp)
    .split(f[j])
    .join(repl);
      if (count && s[i] !== temp) {
        this.window[count] += (temp.length - s[i].length) / f[j].length;
      }
    }
  }
  return sa ? s : s[0];
}