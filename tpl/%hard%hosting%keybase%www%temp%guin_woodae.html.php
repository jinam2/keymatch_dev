<? /* Created by SkyTemplate v1.1.0 on 2023/04/05 15:41:53 */
function SkyTpl_Func_2900416969 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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


<SCRIPT LANGUAGE=JAVASCRIPT>
<!--

	function happy_set(p_name) {
		last_pname = document.form.preference.value
		if (last_pname=="") {
			document.form.preference.value = last_pname + p_name
			}
		else
			{
			if  ((last_pname.indexOf(p_name)) == -1) {
						document.form.preference.value = last_pname + ", " + p_name
					}
				else {
					Start_Pos = parseInt(last_pname.indexOf(p_name)) - 1
					End_Pos = parseInt(last_pname.indexOf(p_name)) + parseInt(p_name.length)
					last_pname = last_pname.substring(0,Start_Pos)  + last_pname.substring(End_Pos)
					if (last_pname.charAt(0) == ",") last_pname = last_pname.substring(1)
					document.form.preference.value = last_pname
				}
		}
	}

function reset() {

		document.form.reset();

	}

function  send() {

	if (document.form.preference.value == "" ) {
			//alert("우대조건을 선택하세요")
			//return;
	}

// copy
top.opener.document.regiform.woodae.value = document.form.preference.value;
// close this window
parent.window.close();
}

window.onload = function()
{
	if (top.opener.document.regiform.woodae != undefined)
	{
		var woodae_val	= top.opener.document.regiform.woodae.value;
		if (woodae_val != "")
		{
			woodae_arr	= woodae_val.split(", ");
			for(var i=0; i<woodae_arr.length; i++)
			{
				for (var j=0; j< document.getElementsByName('p_value').length; j++)
				{
					if (document.getElementById('woodae_text_'+j).innerHTML == woodae_arr[i])
					{
						document.getElementsByName('p_value')[j].checked	= true;
						happy_set(woodae_arr[i]);
					}
				}
			}
		}

	}
}


//-->
</SCRIPT>
<head>
<body>
<form name="form" method="post" action="Gi_preference_input_Ok.asp" >
	<h2 class="noto500 font_25" style="background:#efefef; padding:15px 0 15px 20px; margin:0; color:#000; letter-spacing:-1px;">
		우대조건 입력
	</h2>
	<div style="padding:10px;">
		<table width=100% cellspacing=0 style="border:1px solid #dedede;">
			<tr>
				<td bgcolor="#F4F4F4" align="center" style="padding:10px;">
					<span class="h_form"><input type="text" name="preference" style="width:315px" readonly ></span> <a href="javascript:send()"><img src="img/bt_guin_popup_reg.gif" align="absmiddle" border="0" style="border-radius:3px;"></a> <a href="javascript:reset();"><img src="img/bt_guin_popup_reset.gif" align="absmiddle" border="0" style="border-radius:3px;"></a>
				</td>
			</tr>
		</table>
		<div style="border:1px solid #d2d2d2; margin-top:10px; padding:10px 10px 0 10px">
			<?=$_data['우대옵션']?>

		</div>
	</div>

</form>
</body>
</html>
<? }
?>