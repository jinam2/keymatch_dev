<?
	include ("./inc/config.php");
	include ("./inc/function.php");

	$nick	= trim($_GET['nick']);
	$nowId	= trim($_GET['nowid']);

	$where	= '';
	if ( $nowId != '' )
	{
		$where	= " AND user_id != '$nowId' ";
	}

	$Sql	= "SELECT count(*) FROM $happy_member WHERE user_nick='$nick' $where ";
	$Data	= happy_mysql_fetch_array(query($Sql));

	$Sql	= "SELECT count(*) FROM $happy_member_quies WHERE user_nick='$nick' $where ";
	$Data2	= happy_mysql_fetch_array(query($Sql));


	if ( $nick == "" ) {
		echo "input";
	}
#	else if ( $idlen < 4 )
#	{
#		echo "short";
#	}
	else if ( $Data[0] == 0 && $Data2[0] == 0 ) {
		echo "ok";
	}
	else {
		echo "no";
	}

?>