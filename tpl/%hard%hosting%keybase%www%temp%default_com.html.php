<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 15:44:18 */
function SkyTpl_Func_1109829767 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<!-- 사이트 타이틀 -->
<title><?=$_data['site_name2']?> <?=$_data['master_msg']?></title>

<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">

<?=$_data['webfont_js']?>


<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/common.css?ver=<?=$_data['css_make_date']?>">
<link rel="stylesheet" type="text/css" href="css/style.css?ver=<?=$_data['css_make_date']?>">

<!--uikit 소스-->
<link rel="stylesheet" type="text/css" href="css/uikit/uikit.css?ver=<?=$_data['css_make_date']?>" />
<link rel="stylesheet" type="text/css" href="css/theme1/h_form.css?ver=<?=$_data['css_make_date']?>">

<script language="javascript" type="text/javascript" src="js/uikit/uikit.js?ver=<?=$_data['js_make_date']?>"></script>
<script language="javascript" type="text/javascript" src="js/uikit/uikit-icons.js?ver=<?=$_data['js_make_date']?>"></script>
<!--uikit 소스-->

<script src="js/happy_job.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/flash.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/skin_tab.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/default.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script language='JavaScript' src='js/glm-ajax.js?ver=<?=$_data['js_make_date']?>'></SCRIPT>
<script language='JavaScript' src='js/select_ajax.js?ver=<?=$_data['js_make_date']?>'></script>
<script language='JavaScript' src='js/jquery-1.9.1.min.js?ver=<?=$_data['js_make_date']?>'></script>
<script language="javascript" type="text/javascript" src="js/happy_function.js?ver=<?=$_data['js_make_date']?>"></script>

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
				<?=$_data['내용']?>

			</div>
		</div>
		<footer id="footer">
			<?include_template('in_bottom_copyright.html') ?>

		</footer>
	</div>
</body>
</html>
<?=$_data['cgialert']?><!--데모용소스-->
<?=$_data['쪽지레이어']?><!--쪽지레이어-->
<? }
?>