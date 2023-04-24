<? /* Created by SkyTemplate v1.1.0 on 2023/04/11 10:19:58 */
function SkyTpl_Func_1395591492 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?=$_data['site_name']?> <?=$_data['master_msg']?></title>
<meta name="description" content="<?=$_data['site_name']?>">
<?=$_data['webfont_js']?>

<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/common.css?ver=<?=$_data['css_make_date']?>">
<link rel="stylesheet" type="text/css" href="css/style.css?ver=<?=$_data['css_make_date']?>">
<script src="js/happy_job.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<script src="js/flash.js?ver=<?=$_data['js_make_date']?>" type="text/javascript"></script>
<SCRIPT language='JavaScript' src='js/glm-ajax.js?ver=<?=$_data['js_make_date']?>'></SCRIPT>
<script language="javascript" type="text/javascript" src="js/happy_function.js?ver=<?=$_data['js_make_date']?>"></script>


<!--구글통계-->
<?=$_data['google_login_track']?>

</head>

<body>
	<?=$_data['내용']?>

</body>
</html>
<? }
?>