<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 15:24:46 */
function SkyTpl_Func_1202728345 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
<link rel="stylesheet" type="text/css" href="./css/stickytooltip.css" />

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
<script type="text/javascript" src="happy_main.js"></script>
<script type="text/javascript" src="./js/stickytooltip.js"></script>
<script language="javascript" type="text/javascript" src="js/happy_function.js"></script>

<!--구글통계-->
<?=$_data['google_login_track']?>

<style>
	.no_display2{display:none}
</style>

<!-- 스크랩 페이지 타이틀 디자인 기업회원일때 -->
<STYLE type="text/css">
	.guin_scrap_title_com img { display:none;}
	.guin_scrap_title_com  { font-size:25px; font-weight:500;}
</STYLE>

</head>
<body>
	<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop:plugins_time.js' id='gToday:datetime:agenda.js:gfPop:plugins_time.js' src='./js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>
	<?call_popup('서브페이지','#F1F1F1','랜덤') ?>

	<!-- 핸드폰 인증을 위한 DIV START-->
	<?=$_data['핸드폰인증레이어']?>

	<div id="wrap">
		<?include_template('my_view_right_scroll.html') ?>

		<?include_template('my_view_right_scroll_mypage_com.html') ?>

		<div id="header">
			<?include_template('header.html') ?>

		</div>
		<div id="container">
			<div class="container_c" style="margin-top:20px">
				<div class="locate"><?=$_data['현재위치']?></div>
				<div>
					<?=$_data['내용']?>

				</div>
			</div>
		</div>
		<footer id="footer">
			<?include_template('in_bottom_copyright.html') ?>

		</footer>
	</div>
	<div id='mystickytooltip' class='stickytooltip'><?=$_data['tool_tip_layer']?></div>
</body>
</html>
<?=$_data['cgialert']?><!--데모용소스-->
<?=$_data['쪽지레이어']?><!--쪽지레이어-->

<? }
?>