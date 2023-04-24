<? /* Created by SkyTemplate v1.1.0 on 2023/03/22 09:51:33 */
function SkyTpl_Func_2833436780 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<!-- 사이트 타이틀 -->
<title></title>

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

<!--트래킹코드-->
<?=$_data['google_login_track']?>


</head>
<body scroll=auto style="overflow-x:hidden">
<div style="position:relative; overflow-x:hidden">
	<?happy_member_user_form('정보보기','전체','happy_member_form_rows.html','happy_member_form_view_default.html') ?>

</div>
</body>
</html>
<? }
?>