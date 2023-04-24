<?

	include ("./inc/Template.php");
	$TPL = new Template;

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$number	= $_GET["number"];

	$Sql	= "SELECT * FROM $happy_popup WHERE number='$number'";

	$Popup	= happy_mysql_fetch_array(query($Sql));

	$cookie_name		= "happy_popup_".$Popup["number"];

	$linkUrl			= $popupLinkTypeValue[$Popup["linkType"]];
	$Popup["linkUrl"]	= str_replace(" ","",$Popup["linkUrl"]);
	if ( $linkUrl != "" && $Popup["linkUrl"] != "" )
	{
		$Popup["linkUrl"]	= "http://". preg_replace("/http:\/\//i","",$Popup["linkUrl"]);
		$linkUrl	= str_replace("{{linkUrl}}",$Popup["linkUrl"],$linkUrl);
		if ( $Popup["linkType"] != "현재창" )
		{
			$linkUrl = str_replace("{{closeScript}}","self.close();",$linkUrl);
		}
	}
	else
		$linkUrl	= "self.close();";


?>
<HTML>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<TITLE><?=$Popup["title"]?></TITLE>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<SCRIPT language="JavaScript">
		function setCookie( name, value, expiredays )
		{
			var todayDate = new Date();
			todayDate.setDate( todayDate.getDate() + expiredays );
			document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
		}
		function closeWin( cookie_name )
		{
			if ( document.popup_frm.no_popup.checked )
				setCookie( cookie_name , "no" , <?=$popupCloseCookieDate?>);
			self.close();
		}
	</SCRIPT>
</HEAD>

<BODY topmargin="0" leftmargin="0" style="cursor:pointer">


	<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
	<!--
	<tr>
		<td colspan="3" height="30" background="img/hn4_bg_box15b.gif" style="font-size:9pt;color:#FFFFFF;font-weight:600;" align="center"><?=$Popup["title"]?></td>
	</tr>
	-->
	<tr>
		<td style="padding:0 0 3 0;" valign="top" onClick="<?=$linkUrl?>"><?=$Popup["content"]?></td>
	</tr>
	<tr>
		<td>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<form name="popup_frm">
		<tr>
			<td width="15"><input type="checkbox" name="no_popup" value="Y"></td><td style="padding:3 0 0 0;"><a href="#1" onClick="document.popup_frm.no_popup.checked=true;closeWin('<?=$cookie_name?>');"><?=$popupCloseCookieMsg?></a></td><td align="right"><input type="button" value="X" style="padding:2px; background-image:url('img/btn_close2.gif'); width:18px; height:18px;" onClick="closeWin('<?=$cookie_name?>')"></td>
		</tr>
		</form>
		</table>


		</td>
	</tr>
	</table>

</BODY>
</HTML>
