<? /* Created by SkyTemplate v1.1.0 on 2023/03/10 10:37:54 */
function SkyTpl_Func_1628267753 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?=$_data['COM_INFO']['com_name']?> 로고 이미지 변경</title>

<?=$_data['webfont_js']?>


<!--구글통계-->
<?=$_data['google_login_track']?>

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
<style type="text/css">
	.logo_change_job5b .substence > span > input{width:100% !important; display:inline-block;}
	.logo_change_job5b .substence > p.guide_txt{margin-top:5px; margin-left:0;}
</style>
</head>

<body>

	<FORM action="logo_change.php?mode=logo_upload_reg" method="post" name="happy_member_reg" enctype='multipart/form-data'>
	<?=$_data['hidden_form']?>

	<h2 class="noto500 font_25" style="background:#efefef; padding:15px 0 15px 20px; margin:0; color:#000; letter-spacing:-1px;">
		사진등록
	</h2>
	<div class="logo_change_job5b">
		<?happy_member_user_form('자동','이미지1','happy_member_form_rows.html','happy_member_form_default.html') ?>

		<?happy_member_user_form('자동','이미지2','happy_member_form_rows.html','happy_member_form_default.html') ?>

	</div>
	<div align="center">
		<input type="image" src="img/pop_regist_btn.gif" value="등록" style="margin:10px 0 10px 0; cursor:pointer">
	</div>
	</form>

</body>
</html>
<? }
?>