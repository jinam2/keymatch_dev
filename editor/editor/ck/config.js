/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/******************************************************************************
HappyCGI Hun Editing
CKEditor Version 4.5.6
2015-12-22 업데이트된 CkEditor Full Package 로 작업되었음을 알립니다.
페이지 하단에 각 툴바들 명칭에 따른 설명이 추가되어 있습니다.
편집을 위하실 경우 참고하세요.
******************************************************************************/

CKEDITOR.editorConfig = function( config ) {
	//config.enterMode				= CKEDITOR.ENTER_P;														//엔터모드 엔터를 P로 사용함.(CKEDITOR.ENTER_P 기본속성)	다른 속성으로는 CKEDITOR.ENTER_BR , CKEDITOR.ENTER_DIV 가 있다.

	config.font_names				= '맑은 고딕;고딕;굴림;돋움;궁서;Arial;Times New Roman;Verdana';		//폰트선언
	config.toolbar					= 'happycgi_full';
	config.height					= 400;																	//500 pixels high.
	config.allowedContent			= true;																	//false 는 에디터가 지정한 형식에 맞지 않는 스타일들을 무시하거나 제거해 버린다. 참고로 iframe 을 사용하지 못함. youtube 기능 사용불가.
	config.toolbar_happycgi_full	=
	[
		['Source','-','NewPage','Preview','Templates'],
		['Cut','Copy','Paste','PasteText','PasteFromWord'],
		['Bold','Italic','Strike','Underline','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['Maximize'],
		'/',
		['Styles','Format','Font','FontSize'],
		['TextColor', 'BGColor','Table','HorizontalRule'],
		['Smiley','SpecialChar','PageBreak'],
		['Link','Unlink','Anchor'],
		'/',
		['Undo','Redo','-','Find','Replace','-','RemoveFormat'],
		['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
		['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField']
	];

	config.toolbar					= 'happycgi_normal';
	config.toolbar_happycgi_normal	=
	[
		['Source','-','NewPage','Preview','Templates'],
		['Bold','Italic','Strike','Underline','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['Undo','Redo','-','Find','Replace','-','RemoveFormat'],
		'/',
		['Font','FontSize'],
		['TextColor', 'BGColor','Table','HorizontalRule'],
		['Smiley','SpecialChar','PageBreak'],
		['Link','Unlink','Anchor'],
		['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
		['Maximize']
	];

	config.toolbar					= 'happycgi_simple';
	config.toolbar_happycgi_simple	=
	[
		['NewPage','Preview'],
		['Bold','Italic','Strike','Underline','Table'],
		['TextColor', 'BGColor','Smiley','SpecialChar'],
		['Font','FontSize'],
		['NumberedList','BulletedList','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ]
	];

	config.toolbar					= 'happycgi_mini';
	config.toolbar_happycgi_mini	=
	[
		['Bold','Italic','Strike','Underline','Subscript','Superscript','-','RemoveFormat'],
		['Link','Unlink','Anchor']
	];

	config.filebrowserUploadUrl = CKEDITOR.basePath + '/uploader/upload.php';			//Link dialog 에 upload 기능 추가.
	config.extraPlugins = 'basicstyles';

	/*	basicstyles plugins 설정	*/
	config.coreStyles_bold = {
		element: 'span',
		//attributes: { 'style': 'font-weight:Bold' }
		styles: { 'font-weight': 'Bold' }
	};
	config.colorButton_backStyle = {
		element: 'span',
		styles: { 'background-color': '#(color)' }
	};
	/*	basicstyles plugins 설정	*/

	config.entities = false;
};

/******************************************************************************
toolbar 옵션 설명.
*******************************************************************************

/									툴바줄바꿈

Source								소스보기
NewPage								새문서
Preview								미리보기
Templates							템플릿 문서
Cut									글자르기
Copy								복사하기
Paste								붙여넣기
PasteText							Text 문서 붙여넣기
PasteFromWord						MS Word 문서 붙여넣기
Bold								Bold
Italic								Italic
Strike								Strike
Underline							Underline
Subscript							아래첨자
Superscript							위첨자
NumberedList						번호 있는 정렬태그
BulletedList						번호 없는 정렬태그
Outdent								내어쓰기
Indent								들여쓰기
Blockquote							인용단락
Styles								스타일
Format								문단형태
Font								글꼴
FontSize							글씨크기
TextColor							글자색상
BGColor								배경색상
Table								표
HorizontalRule						가로 줄 삽입
Flash								플래시 입력툴
Smiley								이모티콘
SpecialChar							특수문자
PageBreak							인쇄시 페이지 나누기 삽입
Undo								실행 취소
Redo								다시 실행
Find								찾기
Replace								바꾸기
RemoveFormat						형식 지우기
Link								링크 삽입/변경
Unlink								링크 지우기
Anchor								책깔피
JustifyLeft							왼쪽 정렬
JustifyCenter						중앙 정렬
JustifyRight						오른쪽 정렬
JustifyBlock						양쪽 맞춤
Form								폼 만들기
Checkbox							체크박스
Radio								라디오버튼
TextField							한줄 입력칸
Textarea							여러줄 입력칸
Select								선택목록
Button								버튼
ImageButton							이미지 버튼
HiddenField							숨은 입력칸
Maximize']							최대화
******************************************************************************/