<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$is_ajax	= $_GET['is_ajax'];
	$file		= $_GET['file'];
	$city		= $_GET['city'];
	$stylecss	= $_GET['stylecss'];
	$wthr_count	= $_GET['wthr_count'];
	$img_c		= $_GET['img_c'];
	$img_h		= $_GET['img_h'];

	if( $is_ajax != "ajax" )
	{
		echo 'error___cut___';
		exit;
	}

	if( $file == '' || $city == '' )
	{
		echo 'error___cut___';
		exit;
	}

	$is_ajax_weather = "ok";
	echo "ok___cut___".happy_weather_print($file,$stylecss,$img_c,$img_h,$wthr_count);

?>