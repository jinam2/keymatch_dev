<? /* Created by SkyTemplate v1.1.0 on 2023/03/31 09:42:16 */
function SkyTpl_Func_2347006158 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<meta name="format-detection" content="telephone=no"/>
<title><?=$_data['COM_INFO']['com_name']?> <?=$_data['MEM']['user_name']?> <?=$_data['로고타이틀']?> 변경</title>
<meta name="Generator" content="EditPlus">
<meta name="Author" content="HAPPYCGI:YOON DONG GI">
<meta http-equiv="X-UA-Compatible" content="IE=emulateIE8">
<meta name="Keywords" content="<?=$_data['HC_meta_tag_keyword']?>">
<meta name="Description" content="<?=$_data['HC_meta_tag_description']?>">
<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<!-- CSS 연결파일 -->
<link rel="stylesheet" type="text/css" href="m/css/common.css">
<link rel="stylesheet" type="text/css" href="m/css/style.css">

<!--uikit 소스-->
<link rel="stylesheet" type="text/css" href="css/uikit/uikit.css" />
<link rel="stylesheet" type="text/css" href="css/theme1/h_form.css">

<script language="javascript" type="text/javascript" src="js/uikit/uikit.js"></script>
<script language="javascript" type="text/javascript" src="js/uikit/uikit-icons.js"></script>
<!--uikit 소스-->

<style type="text/css">
	.guide_txt {display:none;}
	.pic {display:block; clear:both; margin-top:4px;}
</style>

<!-- JS 연결파일 -->
<script language='JavaScript' src='./js/glm-ajax.js'></script>
<script type="text/javascript">
	function goback(){
		window.history.back();
	}
</script>

<!--구글통계-->
<?=$_data['google_login_track']?>


<style type="text/css">
	.guzic_view_btn{color:#fff; border-radius:15px; display:inline-block; padding:5px 10px; background:#<?=$_data['배경색']['모바일_기타페이지1']?>}
	.guzic_scrap_btn {display:block; padding:10px 0; text-align:center; border:1px solid #ddd; background:#f5f5f5; font-weight:bold}
	.guzic_pass_btn {display:block; text-align:center; border:1px solid #<?=$_data['배경색']['모바일_서브색상']?>; background:#<?=$_data['배경색']['모바일_서브색상']?>; font-weight:bold; color:#fff}
</style>

</head>

<body>
	<h2 style="background:#efefef; padding:15px 0 15px 20px; position:relative">
		<img src='happy_imgmaker.php?fsize=18&news_title=사진수정&outfont=NanumGothicExtraBold&fcolor=45,45,45&format=PNG&bgcolor=239,239,239' style="vertical-align:middle">
	</h2>

<div id="wrapper_join">

	<form action="logo_change.php?mode=logo_upload_reg" method="post" name="happy_member_reg" enctype='multipart/form-data'>
	<?=$_data['hidden_form']?>


	<?happy_member_user_form('자동','이미지1','happy_member_form_rows.html','happy_member_form_default.html') ?>

	<?happy_member_user_form('자동','이미지2','happy_member_form_rows.html','happy_member_form_default.html') ?>


	<div style="padding:10px; margin-top:10px">
		<div>
			<input type="submit" value="수정" class="guzic_pass_btn font_18 noto400" style="width:100%; padding:10px;">
		</div>
		<div>
			<input type="button" value="이전으로" class="guzic_scrap_btn font_18 noto400" style="width:100%; padding:10px; color:#333; margin-top:10px" onclick="goback();">
		</div>
	</div>

</div>
</form>

</body>
</html>
<? }
?>