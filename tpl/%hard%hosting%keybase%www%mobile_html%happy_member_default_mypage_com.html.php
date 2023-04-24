<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 15:34:53 */
function SkyTpl_Func_2581569246 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!doctype html>
<html>
<head>
<!--모바일 전용 meta소스-->
<TITLE><?=$_data['site_name']?></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<meta name="format-detection" content="telephone=no"/>
<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<!-- 스타일시트 파일 링크처리 -->
<link rel="stylesheet" type="text/css" href="m/css/style.css">
<link rel="stylesheet" type="text/css" href="m/css/common.css">

<!--uikit 소스-->
<link rel="stylesheet" type="text/css" href="css/uikit/uikit.css" />
<link rel="stylesheet" type="text/css" href="css/theme1/h_form.css">

<script language="javascript" type="text/javascript" src="js/uikit/uikit.js"></script>
<script language="javascript" type="text/javascript" src="js/uikit/uikit-icons.js"></script>
<!--uikit 소스-->

<!-- 자바스크립트 파일 링크처리 -->
<script language="javascript" src="m/js/default.js" type="text/javascript"></script>
<script language="javascript" src="m/js/layer.js" type="text/javascript"></script>
<script language="javascript" src="js/happy_job.js" type="text/javascript"></script>
<script type='text/javascript' src='js/jquery_min.js'></script>
<script language='JavaScript' src='./js/glm-ajax.js'></script>
<script language="javascript" type="text/javascript" src="js/happy_function_mobile.js"></script>

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
<style>
	/* dday 출력시 색상지정 */
	.dday .d_day{color:#<?=$_data['배경색']['모바일_서브색상']?>}
	/* 제의삭제버튼 */
	.mobile_del_btn {padding:10px 0; text-align:center;  border:1px solid #<?=$_data['배경색']['모바일_서브색상']?>; color:#fff; letter-spacing:-1px; background:#<?=$_data['배경색']['모바일_서브색상']?>}
	.guzic_view_btn a{color:#fff; border-radius:15px; display:inline-block; padding:5px 10px; background:#<?=$_data['배경색']['모바일_기타페이지2']?>}
	.guzic_pass_btn a{display:block; padding:10px 0; text-align:center; border:1px solid #9e9e9e; background:#<?=$_data['배경색']['모바일_서브색상']?>; font-weight:bold; color:#fff}

</style>
</head>

<body>
<div id="wrap">
	<!-- header.html -->
	<header id="header">
	<?include_template('header.html') ?>

	</header>
	<!--내용-->
	<div id="container">
		<div class="sub_guin_list_wrap2"><?=$_data['내용']?></div>
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