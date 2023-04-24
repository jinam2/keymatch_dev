<?php
include("config.php");
//현재접속자
$session_dir = $path."data/session";
session_save_path($session_dir);

session_start();
// Antispam example using a random string
require_once "jgraph.php";

// Create new anti-spam challenge creator
// Note: Neither '0' (digit) or 'O' (letter) can be used to avoid confusion
$spam = new AntiSpam();

// Create a random 5 char challenge and return the string generated
$chars = $spam->Rand(5);

	$num		= 0;
	$chkCnt		= 0;
	$chkChr		= "";
	$chkHex		= "";
	$randSize	= 5;

	while ( $chkCnt < $randSize)
	{
		$num	= rand()%91;

		if (($num>47 && $num<58) || ( $num>64 && $num<91 ))
		{
			$chkChr	.= chr($num);
			$chkHex	.= sprintf("%02s",dechex($num));
			$chkCnt++;
		}
	}
	$_SESSION["antispam"]	= $chars;
	//setcookie("antispam",$chars,0,"/");





// Stroke random cahllenge
if( $spam->Stroke() === false ) {
    die('Illegal or no data to plot');
}



?>

