<? /* Created by SkyTemplate v1.1.0 on 2023/03/21 17:49:38 */
function SkyTpl_Func_1837414386 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<!-- 사이트 타이틀 -->
<title>입사지원 제의하기</title>

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

<style>
	.sel2 select{width:100%;}
</style>
</head>
<body>
<form method="post" name="comeon_frm" style="margin:0;">
<input type="hidden" name="number" value="<?=$_data['number']?>">
<input type="hidden" name="mode" value="okletsmoveout">
<input type="hidden" name="mail" value="1">

<h2 class="noto500 font_25" style="margin:0; background:#efefef; padding:15px 0 15px 20px; color:#000; letter-spacing:-1px;">
	이메일 입사지원
</h2>
<table cellspacing="0" cellspacing="0" style="table-layout:fixed; width:100%;  border-collapse: collapse;" class="memview">
	<tr>
		<th class="title" style="vertical-align:middle">이력서 선택</th>
		<td class="substence sel2 h_form"><?=$_data['구인선택']?></td>
	</tr>
	<tr>
		<th class="title" style="vertical-align:middle">보내는이</th>
		<td class="substence h_form">
			<input type="text" name="mail_name" value="<?=$_data['USER']['per_name']?>" style="width:99%; padding-left:5px;">
		</td>
	</tr>
	<tr>
		<th class="title" style="vertical-align:middle">연락처</th>
		<td class="substence h_form">
			<input type="text" name="mail_phone" value="<?=$_data['USER']['per_cell']?>" style="width:99%; padding-left:5px;">
		</td>
	</tr>
	<tr>
		<th class="title" style="vertical-align:middle">이메일</th>
		<td class="substence h_form">
			<input type="text" name="mail_email" value="<?=$_data['USER']['per_email']?>"  style="width:99%; padding-left:5px;">
		</td>
	</tr>
	<tr <?=$_data['display_secure']?>>
		<th class="title" style="vertical-align:middle">공개할 연락처</th>
		<td class="substence h_form">
			<span style="display:block">
				<label class="h-check" for="check_secure1"><input type="checkbox" name="secure[]" id="check_secure1" value="홈페이지" checked><span class="font_14">홈페이지</span></label>
			</span>
			<span style="display:block; margin-top:3px;">
				<label for="check_secure2" class="h-check"><input type="checkbox" name="secure[]" id="check_secure2" value="전화번호" checked><span class="font_14">전화번호</span></label>
			</span>
			<span style="display:block; margin-top:3px;">
				<label for="check_secure3" class="h-check"><input type="checkbox" name="secure[]" id="check_secure3" value="핸드폰" checked><span class="font_14">핸드폰</span></label>
			</span>
			<span style="display:block; margin-top:3px;">
				<label for="check_secure4"  class="h-check"><input type="checkbox" name="secure[]" id="check_secure4" value="주소" checked><span class="font_14">주소</span></label>
			</span>
			<span style="display:block; margin-top:3px;">
				<label for="check_secure5" class="h-check"><input type="checkbox" name="secure[]" id="check_secure5" value="E-mail" checked><span class="font_14">E-mail</span></label>
			</span>
		</td>
	</tr>
	<tr>
		<th class="title">추가내용</th>
		<td class="substence h_form">
			<textarea name="mail_content" cols="43" rows="4" style="width:99%; padding:5px 0 0 5px;"></textarea>
		</td>
	</tr>
	<tr>
		<th class="title" style="vertical-align:middle">중복방지키</th>
		<td class="substence h_form">
			<img src='inc/image_maker.php?code=<?=$_data['trick_code']?>' align="absmiddle">
				<input type="text" name="spamcheck" style="width:130px;">
		</td>
	</tr>
</table>
<table cellspacing="0" style="width:100%;">
	<tr>
		<td align="center" style="padding-top:10px; padding-bottom:10px;">
			<input type="image" src="img/pop_email_btn.gif" style="cursor:pointer">
		</td>
	</tr>
</table>
</form>
</body>
</html>
<? }
?>