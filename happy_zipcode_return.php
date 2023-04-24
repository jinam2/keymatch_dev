<?php
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$code	= trim($_GET['code']);
	$addr	= trim($_GET['addr']);
	$addr2	= trim($_GET['addr2']);
	$hyf	= trim($_GET['hyf']);

	$hyf_arr	= explode("|",$hyf);
	if(sizeof($hyf_arr) < 3)
	{
		echo "<script type=\"text/javascript\">
	alert('$site 사용 권한이 없습니다.');
	window.close();
</script>";
		exit;
	}
?>
<!doctype html>
<html lang="ko">
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<meta charset="euc-kr">
<title>[CGIMALL] 우편번호 찾기</title>
</head>
<body>

<script type="text/javascript">

var code	= parent.opener.document.getElementById('<?= $hyf_arr[0] ?>');
var addr	= parent.opener.document.getElementById('<?= $hyf_arr[1] ?>');
var addr2	= parent.opener.document.getElementById('<?= $hyf_arr[2] ?>');

var n_code	= parent.opener.document.getElementsByName('<?= $hyf_arr[0] ?>')[0];
var n_addr	= parent.opener.document.getElementsByName('<?= $hyf_arr[1] ?>')[0];
var n_addr2	= parent.opener.document.getElementsByName('<?= $hyf_arr[2] ?>')[0];

if( code != undefined )
{
	code.value = '<?= $code ?>';
} else {
	if( n_code != undefined )
	{
		n_code.value = '<?= $code ?>';
	}
}
if( addr != undefined )
{
	addr.value = '<?= $addr ?>';
}
else
{
	if( n_addr != undefined )
	{
		n_addr.value = '<?= $addr ?>';
	}
}
if( addr2 != undefined )
{
	addr2.value = '<?= $addr2 ?>';
}
else
{
	if( n_addr2 != undefined )
	{
		n_addr2.value = '<?= $addr2 ?>';
	}
}
//parent.window.close();
window.location.href = "http://<?= $zipcode_site ?>/zonecode/self_close.html";
</script>

</body>
</html>