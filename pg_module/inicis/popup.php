<?
	include ("../../inc/config.php");
	include ("../../inc/function.php");
	$inicis_SVR = ( $HAPPY_CONFIG['pg_pay_mode'] == "test" ? "stgstdpay" : "stdpay" );
?>
<script language="javascript" type="text/javascript" src="https://<?=$inicis_SVR?>.inicis.com/stdjs/INIStdPay_popup.js" charset="UTF-8"></script>