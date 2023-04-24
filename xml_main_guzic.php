<?php

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template();
	include ("./inc/lib.php");

/*
	function write_log($file, $noti) {
		$fp = fopen($file, "a+");
		ob_start();
		print_r($noti);
		$msg = ob_get_contents();
		ob_end_clean();
		fwrite($fp, $msg);
		fclose($fp);
	}
*/
	#$_GET['호출url'] = $_SERVER['QUERY_STRING'];

	$log_file_name = "LOG_main_guzic.log";
	//write_log("./data/".$log_file_name, $_GET);


	if ($_GET['opt1'] == '')
	{
		$ticker_list = "";
		$speed_time = '1500';
		$keycolor = 'FF394C';
	}
	else
	{
		$doc_extraction_return = "return";
		#$_GET['opt1'] : 총개수
		#$_GET['opt2'] : 가로
		#$_GET['opt3'] : 플래시가 출력할 세로개수
		$_GET['opt1'] = preg_replace("/\D/","",$_GET['opt1']);
		$_GET['opt2'] = preg_replace("/\D/","",$_GET['opt2']);
		$_GET['opt3'] = preg_replace("/\D/","",$_GET['opt3']);

		#이력서는 가로 몇개,세로 몇개로 호출됨
		$garo = ( $_GET['opt2'] );
		$sero = ceil( $_GET['opt1'] / $_GET['opt2'] );

		$ticker_list = document_extraction_list($garo,$sero,$_GET['opt6'],$_GET['opt7'],$_GET['opt8'],$_GET['opt9'],$_GET['opt10'],$_GET['opt11'],$_GET['opt12'],$_GET['opt13'],$_GET['opt14']);

		$twidth = preg_replace("/\D/","",$_GET['opt4']);
		$theight = preg_replace("/\D/","",$_GET['opt5']);
		$twcount = $_GET['opt2'];
		$tviewcount = $_GET['opt3'];

	}

	#관리자 모드의 환경설정으로 뽑아냄 2010-01-12 kad
	$speed = $HAPPY_CONFIG['FlashGuZicSpeed'];
	$boxcolor = ( $HAPPY_CONFIG['FlashGuZicBoxColor'] != "")?$HAPPY_CONFIG['FlashGuZicBoxColor']:$배경색상;

	if ( in_array($_GET['opt15'],$happy_icon_group) )
	{
		$overboxcolor = $배경색[$_GET['opt15']];
	}
	else if ( $_GET['opt15'] == 'undefined' )
	{
		$overboxcolor = $HAPPY_CONFIG['FlashGuZicOverBoxColor'];
	}
	else
	{
		$overboxcolor = $_GET['opt15'];
	}

	$centergap = $HAPPY_CONFIG['FlashGuZicCenterGap'];
	$imggap = $HAPPY_CONFIG['FlashGuZicImgGap'];

Header("Content-type: text/html; charset=utf-8");

$print_xml = <<<END
<?xml version="1.0" encoding="UTF-8"?>
<xmlstart>

<banner>
$ticker_list
</banner>

<speed speed="$speed" boxcolor="$boxcolor" overboxcolor="$overboxcolor"/>
<option width="$twidth" height="$theight" centergap="$centergap" imggap="$imggap" wcount="$twcount" viewcount="$tviewcount"/>

</xmlstart>
END;

$print_xml = iconv("euc-kr","utf-8",$print_xml);
echo $print_xml;

?>