<? /* Created by SkyTemplate v1.1.0 on 2023/03/08 00:51:13 */
function SkyTpl_Func_4147670780 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<!-- 사이트 타이틀 -->
<title><?=$_data['site_name']?> <?=$_data['master_msg']?></title>

<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">

<?=$_data['webfont_js']?>


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
<script src="js/menu_tab.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script language='JavaScript' src='js/jquery-1.9.1.min.js?ver=<?=$_data['js_make_date']?>'></script>
<script language="javascript" type="text/javascript" src="js/happy_function.js?ver=<?=$_data['js_make_date']?>"></script>

<?=$_data['tweeter_meta']?>

<?=$_data['default_meta']?>


<?call_popup('서브페이지','#F1F1F1','랜덤') ?>


<!--구글통계-->
<?=$_data['google_login_track']?>


<style>
	.scroll_menu{top:667px !important}
</style>
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
	</div>
	<footer id="footer">
		<?include_template('in_bottom_copyright.html') ?>

	</footer>	
</body>
</html>
<?=$_data['cgialert']?><!--데모용소스-->
<?=$_data['쪽지레이어']?><!--쪽지레이어-->
<? }
?>