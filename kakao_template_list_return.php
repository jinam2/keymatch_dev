<?php
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$msg_name		= $_GET['msg_name'];
	$code_name		= $_GET['code_name'];
	$var_type		= $_GET['var_type'];
	$tpl			= preg_replace('/\D/', '', $_GET['tpl']);

	if ( $msg_name == "" || $code_name == "" || $tpl == "" )
	{
		gomsg("템플릿 선택 오류입니다.[1]",$KAKAO_CONFIG['close_url']);
		exit;
	}

	$xml_url		= $KAKAO_CONFIG['xml_url'];
	$xml_url		.= "&var_type=".$var_type;
	$xml_url		.= "&tpl=".$tpl;

	switch( $KAKAO_CONFIG['connect_type'] )
	{
		case 'curl' :
			$xml_data			= curl_get_file_contents($xml_url);
		break;
		case 'fsock' :
			$xml_data			= file_get_contents_fsockopen($xml_url);
		break;
		case 'snoopy' :
			$xml_data			= snoopy_class($xml_url);
		break;
		default :
			$xml_data			= file_get_contents_fsockopen($xml_url);
		break;
	}

	if ( $xml_data == "error" )
	{
		gomsg("템플릿 선택 오류입니다.[2]",$KAKAO_CONFIG['close_url']);
		exit;
	}

	if ( $xml_data == "secure" )
	{
		gomsg("사용권한이 없습니다.",$KAKAO_CONFIG['close_url']);
		exit;
	}

	$xml_arr			= simplexml_load_string($xml_data);

	if ( is_object($xml_arr) )
	{
		$템플릿코드			= (string)$xml_arr->code;
		$템플릿내용			= (string)$xml_arr->content;
	}
	else
	{
		gomsg("템플릿 선택 오류입니다.[3]",$KAKAO_CONFIG['close_url']);
		exit;
	}
?>
<!doctype html>
<html lang="ko">
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<meta charset="euc-kr">
<title>카카오 알림톡 템플릿 찾기</title>
</head>
<body>

<textarea id="template_content_val"><?=$템플릿내용?></textarea>

<script type="text/javascript">

var close_url		= "<?=$KAKAO_CONFIG['close_url']?>";
var msg_obj			= parent.opener.document.getElementsByName('<?=$msg_name?>')[0];
var code_obj		= parent.opener.document.getElementsByName('<?=$code_name?>')[0];
var is_error		= false;

if ( !msg_obj )
{
	is_error			= true;
	alert("발송 내용 폼을 찾을 수 없습니다.\n창을 다시 열어주세요.");
	window.location.href = close_url;
}

if ( !code_obj && !is_error )
{
	is_error			= true;
	alert("템플릿 코드 폼을 찾을 수 없습니다.\n창을 다시 열어주세요.");
	window.location.href = close_url;
}

if ( !is_error )
{
	msg_obj.value		= document.getElementById('template_content_val').value;
	code_obj.value		= "<?=$템플릿코드?>";
}

window.location.href = close_url;
</script>

</body>
</html>