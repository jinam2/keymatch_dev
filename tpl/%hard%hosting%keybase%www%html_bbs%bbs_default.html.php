<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 15:47:03 */
function SkyTpl_Func_3517703687 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<!-- 사이트 타이틀 -->
<title><?=$_data['site_name2']?> <?=$_data['master_msg']?></title>

<!-- 웹폰트 -->
<?=$_data['webfont_js']?>

<!-- 웹폰트 -->

<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">

<!-- 폼 -->
<link rel="stylesheet" type="text/css" href="css/uikit/uikit.css?ver=<?=$_data['css_make_date']?>" />
<link rel="stylesheet" type="text/css" href="css/theme1/h_form.css?ver=<?=$_data['css_make_date']?>">
<!-- 폼 -->

<!-- SVG 아이콘-->
<script language="javascript" type="text/javascript" src="js/uikit/uikit.js?ver=<?=$_data['js_make_date']?>"></script>
<script language="javascript" type="text/javascript" src="js/uikit/uikit-icons.js?ver=<?=$_data['js_make_date']?>"></script>
<!-- SVG 아이콘-->

<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/common.css?ver=<?=$_data['css_make_date']?>">
<link rel="stylesheet" type="text/css" href="css/style.css?ver=<?=$_data['css_make_date']?>">

<script src="js/happy_job.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/flash.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/skin_tab.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/default.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script language='JavaScript' src='js/glm-ajax.js?ver=<?=$_data['js_make_date']?>'></SCRIPT>
<script language='JavaScript' src='js/select_ajax.js?ver=<?=$_data['js_make_date']?>'></script>
<script language='JavaScript' src='js/jquery-1.9.1.min.js?ver=<?=$_data['js_make_date']?>'></script>
<script language="javascript" type="text/javascript" src="js/happy_function.js?ver=<?=$_data['js_make_date']?>"></script>
<script language="javascript" type="text/javascript" src="js/ajax_bbs_file_upload.js?ver=<?=$_data['js_make_date']?>"></script>

<!-- 게시판 상세에서 사용하는 커스텀 스크롤바-->
<link rel="stylesheet" type="text/css" href="css/scrollbar/scrollbar_skin_edit.css?ver=<?=$_data['css_make_date']?>">
<script language="javascript" type="text/javascript" src="js/scrollbar/jquery_scrollbar.js?ver=<?=$_data['js_make_date']?>"></script>
<!-- 게시판 상세에서 사용하는 커스텀 스크롤바-->

<!-- 게시판관련 폼/버튼/아이콘 색상 변경을 한번에 하기위해 -->
<STYLE type="text/css">
	/* 버튼 폼 관련 */
	.h_form .h_btn_st1 { background-color: #<?=$_data['배경색']['게시판1']?>; }
	.h_form .h_btn_st1:hover, .h_form .h_btn_st1:focus { background-color: #<?=$_data['배경색']['게시판2']?>; }
	.h_form .h_btn_st1:active { background-color: #<?=$_data['배경색']['게시판2']?>; }
	.h_form input[type="text"]:focus, .h_form input[type="password"]:focus, .h_form select:focus, .h_form textarea:focus { border-color: #<?=$_data['배경색']['게시판1']?>; }
	.h_form .h-switch input:checked + .h-switch-slider { background-color:#<?=$_data['배경색']['게시판1']?> !important;}
	.h_form .h-radio input[type="radio"]:checked + span::before {background-color: #<?=$_data['배경색']['게시판1']?>;}
	.h_form .h-check input[type="checkbox"]:checked + span::before {background-color: #<?=$_data['배경색']['게시판1']?>;}
	/* 제목앞 카테고리 */
	.bbs_cate { color:#<?=$_data['배경색']['게시판1']?>; }
	.bbs_rows_title a:hover .bbs_cate{ color:#<?=$_data['배경색']['게시판1']?>; }

	/* 채택된 댓글 */
	.bbs_reply_choose_ok { background:#<?=$_data['배경색']['게시판1']?> !important; color:#ffffff !important; border:none !important; }

	/* 회원아이디메뉴 */
	.bbs_user_menu:hover { background:#<?=$_data['배경색']['게시판1']?>; }

	/* 게시판 상세 전체게시글 현재게시글 타이틀 */
	.now_bbs_title { font-weight:500 !importnat; color:#<?=$_data['배경색']['게시판1']?>; }

	/* 게시판리스트 댓글채택 */
	.bbs_rows_reply_choose  { color:#<?=$_data['배경색']['게시판1']?>; }

</STYLE>
<!-- 게시판색상 -->

<?call_popup('서브페이지','#F1F1F1','랜덤') ?>


<!--구글통계-->
<?=$_data['google_login_track']?>


</head>

<body>
	<div id="wrap">
		<?include_template('my_view_right_scroll.html') ?>

		<div id="header">
			<?include_template('header.html') ?>

		</div>
		<div id="container">
			<div class="container_c" style="margin-top:20px">
				<div class="locate"><?=$_data['현재위치']?></div>
				<table cellspacing="0" style="width:100%; margin-top:15px; table-layout:fixed">
					<tr>
						<td style="width:970px; padding-right:30px" valign="top"><?=$_data['내용']?></td>
						<td style="width:200px; vertical-align:top;" valign="top">
							<?include_template('aside_bbs_com.html') ?>

						</td>
					</tr>
				</table>
			</div>
		</div>
		<footer id="footer" style="margin-top:50px;">
			<?include_template('in_bottom_copyright.html') ?>

		</footer>
	</div>
</body>
</html>
<?=$_data['cgialert']?><!--데모용소스-->
<?=$_data['쪽지레이어']?><!--쪽지레이어-->

<? }
?>