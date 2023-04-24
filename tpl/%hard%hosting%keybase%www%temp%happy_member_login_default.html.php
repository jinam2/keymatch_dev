<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 09:58:02 */
function SkyTpl_Func_227283185 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<!-- 사이트 타이틀 -->
<title><?=$_data['site_name']?> <?=$_data['master_msg']?></title>

<?=$_data['webfont_js']?>


<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">

<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

<!--uikit 소스-->
<link rel="stylesheet" type="text/css" href="css/uikit/uikit.css" />
<link rel="stylesheet" type="text/css" href="css/theme1/h_form.css">

<script language="javascript" type="text/javascript" src="js/uikit/uikit.js"></script>
<script language="javascript" type="text/javascript" src="js/uikit/uikit-icons.js"></script>
<!--uikit 소스-->

<script src="js/happy_job.js" type="text/javascript"></script>
<script src="js/flash.js" type="text/javascript"></script>
<script src="js/skin_tab.js" type="text/javascript"></script>
<script src="js/default.js" type="text/javascript"></script>
<script language='JavaScript' src='js/glm-ajax.js'></SCRIPT>
<script language='JavaScript' src='js/select_ajax.js'></script>
<script language='JavaScript' src='js/jquery-1.9.1.min.js'></script>
<script language="javascript" type="text/javascript" src="js/happy_function.js"></script>

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
			<div class="container_c">
				<div>
					<?=$_data['내용']?>

				</div>
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