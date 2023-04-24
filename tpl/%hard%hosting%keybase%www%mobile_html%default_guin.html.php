<? /* Created by SkyTemplate v1.1.0 on 2023/03/24 20:15:36 */
function SkyTpl_Func_1295830518 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
<link rel="stylesheet" type="text/css" href="m/css/style.css?ver=<?=$_data['css_make_date']?>">
<link rel="stylesheet" type="text/css" href="m/css/common.css?ver=<?=$_data['css_make_date']?>">

<!--uikit 소스-->
<link rel="stylesheet" type="text/css" href="css/uikit/uikit.css?ver=<?=$_data['css_make_date']?>" />
<link rel="stylesheet" type="text/css" href="css/theme1/h_form.css?ver=<?=$_data['css_make_date']?>">

<script language="javascript" type="text/javascript" src="js/uikit/uikit.js?ver=<?=$_data['js_make_date']?>"></script>
<script language="javascript" type="text/javascript" src="js/uikit/uikit-icons.js?ver=<?=$_data['js_make_date']?>"></script>
<!--uikit 소스-->

<!-- 자바스크립트 파일 링크처리 -->
<script language="javascript" src="m/js/default.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script language="javascript" src="m/js/layer.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script language="javascript" src="js/happy_job.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script type='text/javascript' src='js/jquery_min.js?ver=<?=$_data['js_make_date']?>'></script>
<script language='JavaScript' src='./js/glm-ajax.js?ver=<?=$_data['js_make_date']?>'></script>
<script language="javascript" type="text/javascript" src="js/happy_function_mobile.js?ver=<?=$_data['js_make_date']?>"></script>


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

</head>

<body>
<div id="wrap">
	<!-- header.html -->
	<header id="header">
	<?include_template('header.html') ?>

	</header>
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