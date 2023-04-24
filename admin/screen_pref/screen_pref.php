<?

#################################################################################
#																				#
#							[ 관리자 스크린샷 설정 ]							#
#																				#
#																				#
#	작업명: 관리자 스크린샷 설정												#
#	작업자: YOON DONG GI														#
#	작성일: 2010-02-09															#
#	회사명: HAPPYCGI, CGIMALL													#
#	U R L : www.happycgi.com, www.cgimall.co.kr									#
#	부서명: HAPPYCGI 디자인팀													#
#																				#
#################################################################################


global $num, $w, $h;
// num	: xml 문서 파일번호명
// w		: 플래시 가로크기
// h		: 플래시 세로크기


#타이틀 정하기
switch($num){
	case 01 : $title = "메인페이지"; break;
	case 02 : $title = "채용정보페이지"; break;
	case 03 : $title = "인재정보페이지"; break;
	case 04 : $title = "채용정보등록페이지"; break;
	case 05 : $title = "채용정보상세페이지"; break;
	case 06 : $title = "성인인증페이지"; break;
	case 07 : $title = "이력서등록페이지"; break;
	case 08 : $title = "지역별채용정보"; break;
	case 09 : $title = "역세권별채용정보"; break;
	case 10 : $title = "커뮤니티페이지"; break;
}


#HTML
echo<<<END
	<HTML>
	<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<TITLE> 관리자 스크린샷 설정 : ${title}</TITLE>
	<link rel=stylesheet type="text/css" href="css/style.css">

	<STYLE TYPE="text/css">
		div{border:0px solid;}
		#wrapper{}

		#help,#flash{width:100%;}
		#help{height:80;}
		#flash{clear:both; overflow-y:scroll;}
	</STYLE>

	<script language="JavaScript" src="/js/flash.js" type="text/javascript"></script>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		//새창
		function popup_win(url,width,height,resize,scroll){
			window.open(url, 'popup_win','top=24, width='+width+',height='+height+',resizable='+resize+',scrollbars='+scroll+',location=0');
			top.location.href = url;
		}

		//새 윈도우창 띄우기
		function open_window(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable){
			toolbar_str = toolbar ? 'yes' : 'no';
			menubar_str = menubar ? 'yes' : 'no';
			statusbar_str = statusbar ? 'yes' : 'no';
			scrollbar_str = scrollbar ? 'yes' : 'no';
			resizable_str = resizable ? 'yes' : 'no';
			window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
		}

		//부모창으로 열기
		function parentOpen(url){
			top.opener.location.href = url;
		}
	//-->
	</SCRIPT>

	</HEAD>

	<BODY>
END;


#플래시로딩
if($num){
	echo "<SCRIPT LANGUAGE=\"JavaScript\">FlashMainbody(\"screen_pref.swf?num=$num\",\"$w\",\"$h\",'Transparent');</SCRIPT>";
	//[1] 800,2080
}
#include("./screen_pref_".$num.".html");


echo<<<END

	</BODY>
	</HTML>
END;

?>