<?php
include("config.php");
//현재접속자
$session_dir = $path."data/session";
session_save_path($session_dir);

session_start();


if ( $_GET['old'] == '' )	# old 인자값이 전달되면 옛날 기능 그대로 이용
{
	######### 새버전 도배방지키 소스 ########### 20190311 kwak16

	# 합성될 이미지 배경영역
	$back			= ImageCreate(93,30);
	$back			= imagecreatetruecolor(93,30);

	# 배경 색상 설정 (추후 투명 영역으로 지정될 색상)
	$white			= imagecolorallocate($back, 255, 255, 255);
	imagefilledrectangle ($back,0,0,93,30,$white);
	#imagealphablending($back, true);


	# 배경 패턴 합성
	$back_skin		= rand()%4;
	$back_skin		= $back_skin + 1;
	$back_img		= ImageCreateFromPng("./antispam/bg_${back_skin}.png");
	imagecopyresampled($back,$back_img,0,0,0,0,93,30,93,30);


	# 숫자 합성 시작
	$num			= 0;
	$chkCnt			= 0;
	$chkChr			= "";
	$randSize		= 5;

	while ( $chkCnt < $randSize)
	{
		$num			= rand()%10;
		$img_skin		= rand()%3;
		$img_skin		= $img_skin + 1;

		# 숫자합성
		$number_img		= ImageCreateFromPng("./antispam/${img_skin}/${img_skin}_${num}.png");
		imagecopyresampled($back,$number_img,19*$chkCnt,0,0,0,19,30,19,30);

		$chars	.= $num;
		$chkCnt++;
	}

	# 랜덤 숫자 세션 저장
	$_SESSION["antispam"]	= $chars;


	# 배경 투명 처리
	$white = imagecolorallocate($back, 255, 255, 255);
	imagecolortransparent($back, $white);


	# 이미지 출력
	header("Content-type: image/png");
	imagepng($back);
	exit;
}
else
{

		// Antispam example using a random string
		require_once "jgraph/src/jpgraph_antispam-digits.php";

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

}

?>

