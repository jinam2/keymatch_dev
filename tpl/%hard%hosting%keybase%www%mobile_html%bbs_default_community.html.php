<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 11:07:52 */
function SkyTpl_Func_905572608 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<!doctype html>
<html>
<head>
<!--모바일 전용 meta소스-->
<TITLE><?=$_data['site_name']?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<meta name="format-detection" content="telephone=no"/>

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

<!-- 스타일시트 파일 링크처리 -->
<link rel="stylesheet" type="text/css" href="m/css/style.css?ver=<?=$_data['css_make_date']?>">
<link rel="stylesheet" type="text/css" href="m/css/common.css?ver=<?=$_data['css_make_date']?>">

<!-- 자바스크립트 파일 링크처리 -->
<script language="javascript" src="m/js/default.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script language="javascript" src="m/js/layer.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script language="javascript" src="js/happy_job.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script type='text/javascript' src='js/jquery_min.js?ver=<?=$_data['js_make_date']?>'></script>
<script language='JavaScript' src='./js/glm-ajax.js?ver=<?=$_data['js_make_date']?>'></script>
<script language="javascript" type="text/javascript" src="js/happy_function_mobile.js?ver=<?=$_data['js_make_date']?>"></script>
<script language="javascript" type="text/javascript" src="m/m_script.js?ver=<?=$_data['js_make_date']?>"></script>
<script type='text/javascript' src='js/jquery-1.9.1.min.js?ver=<?=$_data['js_make_date']?>'></script>
<script language="javascript" src='m/js/jquery-ui.js?ver=<?=$_data['js_make_date']?>'></script>
<script language="javascript" type="text/javascript" src="js/ajax_bbs_file_upload.js?ver=<?=$_data['js_make_date']?>"></script>

<script type="text/javascript">
 var demo_lock = "<?=$_data['demo_lock']?>";
</script>

<script type="text/javascript" language = "javascript">
try
{
	window.addEventListener('load', function() { setTimeout(scrollTo, 0, 0, 1); }, false);
}
catch (e)
{
}
</script>

<!-- 게시판관련 폼/버튼/아이콘 색상 변경을 한번에 하기위해 -->
<STYLE type="text/css">
	/* 버튼 폼 관련 */
	.h_form .h_btn_st1 { background-color: #<?=$_data['배경색']['모바일_기본색상']?>; }
	.h_form .h_btn_st1:hover, .h_form .h_btn_st1:focus { background-color: #<?=$_data['배경색']['모바일_서브색상']?>; }
	.h_form .h_btn_st1:active { background-color: #<?=$_data['배경색']['모바일_서브색상']?>; }
	.h_form input[type="text"]:focus, .h_form input[type="password"]:focus, .h_form select:focus, .h_form textarea:focus { border-color: #<?=$_data['배경색']['모바일_기본색상']?>; }
	.h_form .h-switch input:checked + .h-switch-slider { background-color:#<?=$_data['배경색']['모바일_기본색상']?> !important;}
	.h_form .h-radio input[type="radio"]:checked + span::before {background-color: #<?=$_data['배경색']['모바일_기본색상']?>;}
	.h_form .h-check input[type="checkbox"]:checked + span::before {background-color: #<?=$_data['배경색']['모바일_기본색상']?>;}
	/* 제목앞 카테고리 */
	.bbs_cate { color:#<?=$_data['배경색']['모바일_기본색상']?>; }
	/* 채택된 댓글 */
	.bbs_reply_choose_ok { background:#<?=$_data['배경색']['모바일_기본색상']?> !important; color:#ffffff !important; border:none !important; }
	.bbs_cate_detail { background:#<?=$_data['배경색']['모바일_기본색상']?>; }

	/* 게시판 상세 전체게시글 현재게시글 타이틀 */
	.now_bbs_title { font-weight:500 !importnat; color:#<?=$_data['배경색']['모바일_기본색상']?>; }

	/* 게시판리스트 댓글채택 */
	.bbs_rows_reply_choose  { color:#<?=$_data['배경색']['모바일_기본색상']?>; }

	/* 게시판메뉴에서 현재게시판 */
	.borad_list_now { color:#<?=$_data['배경색']['모바일_기본색상']?> !important; background:#fafafa !important;}


</STYLE>
<!-- 게시판관련 폼/버튼/아이콘 색상 변경을 한번에 하기위해 -->

</head>

<body>
<div id="wrap">
	<!-- header.html -->
	<header id="header">
	<?include_template('header.html') ?>

	</header>
	<!--카테고리 탭 [s]-->
	<div class="sub_tab_menu01">
		<?board_keyword_extraction('총50개','가로50개','999자자름','커뮤니티','sub_rows_board_list_01.html','누락0개') ?>			
	</div>
	<!--카테고리 탭 [e]-->	
	<!--내용-->
	<div id="container">		
		
		<?=$_data['내용']?>

	</div>
	<!-- footer.html -->
	<footer id="footer">
	<?include_template('in_bottom_copyright.html') ?>

	</footer>
</div>
</body>
</html>
<? }
?>