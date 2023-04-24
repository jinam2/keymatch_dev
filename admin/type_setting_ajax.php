<?php
	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	include ("../inc/function.php");
	include ("../inc/lib.php");

	//$_GET
	//$_POST
	//$_COOKIE

	if ( !admin_secure("직종설정") ) {
			error("접속권한이 없습니다.");
			exit;
	}


	$_get_type	= $_GET['type'];
	$_get_num	= $_GET['num'];

	if( $_get_type == 'get_3sub' )
	{
		$select_option	= "";

		$sql	= "SELECT * FROM {$type_sub_sub_tb} WHERE type_sub = '{$_get_num}' ORDER BY sort_number ASC";
		$rec	= query($sql);
		while($row = mysql_fetch_assoc($rec))
		{
			$select_option	.= "<option value='{$row['number']}'>{$row['title']}</option>";
			$i ++;
		}

		echo "ok____CUT____{$select_option}";
	}

?>