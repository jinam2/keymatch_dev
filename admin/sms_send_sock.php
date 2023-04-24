<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/happy_sms.php");


	if ( !admin_secure("회원관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
	}

	if( sizeof($_POST['phoneArray']) > 0 )
	{
		$per_cell = implode(",",$_POST['phoneArray']);
	}
	else
	{
		$per_cell = $_POST['phone'];
	}

	//$per_cell = "";
	$message = $_POST['message'];

	// CURL 로 보내기
	$aPostData    = array();
	$aPostData['phone']        = $per_cell;
	$aPostData['userid']    = $sms_userid;
	$aPostData['message']    = $message;
	$aPostData['callback']    = $site_phone;
	$aPostData['testing']    = $sms_testing;
	$aPostData['type']        = '5';
	if( $_POST['send_date'] != '' )
	{
		$aPostData['send_date']        = $_POST['send_date'];
	}
	//print_r($aPostData);
	$aData = array();
	$aData['sUrl'] = "http://happysms.happycgi.com/send/send_utf.php";
	$curl = null;
	$curl = curl_init();
	$headers = array("Content-Type:multipart/form-data");
	curl_setopt($curl,CURLOPT_URL, $aData['sUrl']);
	curl_setopt($curl,CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($curl,CURLOPT_HEADER, 0);
	curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl,CURLOPT_REFERER, "{$main_url}/sms_send_sock.php");
	curl_setopt($curl,CURLOPT_POST, 1);
	curl_setopt($curl,CURLOPT_POSTFIELDS, $aPostData);
	$gData = curl_exec($curl);
	curl_close($curl);

	msg('발송완료');

	exit;

?>