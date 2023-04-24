<?php

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template();
	include ("./inc/lib.php");
	//query("set names utf8");





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

	$_GET['호출url'] = $_SERVER['QUERY_STRING'];

	$log_file_name = "LOG_main_guin.log";
	write_log("./data/".$log_file_name, $_GET);
*/



	if ($_GET[opt1] == '')
	{
		$ticker_list = "";
		$speed_time = '1500';
		$keycolor = 'FF394C';
	}
	else
	{
		$_GET['opt10'] = $_GET['opt10']."_flash";
		$ticker_list = guin_main_extraction($_GET['opt1'],$_GET['opt2'],$_GET['opt5'],$_GET['opt6'],$_GET['opt7'],$_GET['opt8'],$_GET['opt9'],$_GET['opt10'],$_GET['opt11'],$_GET['opt12'],$_GET['opt13']);

		if (!$ticker_list)
		{
			$ticker_list = "";
		}
		else
		{

		}

		$wcount =preg_replace("/\D/","",$_GET['opt2']);
		$twidth = preg_replace("/\D/","",$_GET['opt3']);
		$viewcount = preg_replace("/\D/","",$_GET['opt4']);


		trim($ticker_list);
		//$ticker_list = iconv("euc-kr","utf-8",$ticker_list);
	}

	#관리자 모드의 환경설정으로 뽑아냄 2010-01-12 kad
	$speed = $HAPPY_CONFIG['FlashGuinSpeed'];
	if ( in_array($_GET['opt15'],$happy_icon_group) )
	{
		$boxcolor = $배경색[$_GET['opt15']];
	}
	else if ( $_GET['opt15'] == 'undefined' )
	{
		$boxcolor = ( $HAPPY_CONFIG['FlashGuinBoxColor'] != "" )?$HAPPY_CONFIG['FlashGuinBoxColor']:$배경색상;
	}
	else
	{
		$boxcolor = $_GET['opt15'];
	}

	$centergap = $HAPPY_CONFIG['FlashGuinCenterGap'];

Header("Content-type: text/html; charset=utf-8");

$print_xml = <<<END
<?xml version="1.0" encoding="UTF-8"?>
<xmlstart>

<banner>
$ticker_list
</banner>

<speed speed="$speed" boxcolor="$배경색상"/>
<option width="$twidth" centergap="$centergap" wcount="$wcount" viewcount="$viewcount"/>

</xmlstart>
END;

$print_xml = iconv("euc-kr","utf-8",$print_xml);
echo $print_xml;


?>


