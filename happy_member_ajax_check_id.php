<?
	include ("./inc/config.php");
	include ("./inc/function.php");

	$_GET['id']	= strtolower($_GET['id']);

	$idlen_org	= strlen($_GET['id']);

	$id		= trim($_GET["id"]);
	$idlen	= strlen($id);

	$id2 = preg_replace("/[0-9a-zA-Z]/","",$id);
	$id2len = strlen($id2);

	$Sql	= "SELECT count(*) FROM $happy_member WHERE user_id='$id' ";
	$Data	= happy_mysql_fetch_array(query($Sql));

	$Sql	= "SELECT count(*) FROM $happy_member_out WHERE out_id='$id' ";
	$Data2	= happy_mysql_fetch_array(query($Sql));

	$Sql	= "SELECT count(*) FROM $happy_member_quies WHERE user_id='$id' ";
	$Data3	= happy_mysql_fetch_array(query($Sql));

	if ( $id2len >= 1 || $idlen_org != $idlen)
	{
		echo "isnotcharacter";
	}
	else if ( $id == "" ) {
		echo "input";
	}
	else if ( $idlen < 4 )
	{
		echo "short";
	}
	else if ( $Data[0] == 0 && $Data2[0] == 0 && $Data3[0] == 0 ) {
		echo "ok";
	}
	else {
		echo "no";
	}

?>