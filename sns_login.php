<?php

	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$type			= $_GET['type'];
	if ( $type == '' )
	{
		msg('a');
	}
	else if ( $type == 'blank' )
	{
		exit;
	}

	echo '<pre>'; print_r($_POST); echo '</pre>';
?>