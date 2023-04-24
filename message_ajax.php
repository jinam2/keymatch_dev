<?
	header("Content-Type: text/html; charset=utf-8");
	include ("./inc/config.php");
	include ("./inc/config_server.php");

	$message_tb	= 'happy_message';				#쪽지 DB 테이블명 입력

	$dbconn = @mysql_connect( $db_host, $db_user, $db_pass);
	@mysql_select_db( $db_name, $dbconn);

	//set names utf8 처리
	if ( $call_set_names_utf )
	{
		@mysql_query("set names utf8",$dbconn);
	}

	$receiveid	= trim($_GET["receiveid"]);


	$Sql		= "SELECT number,sender_id,sender_name FROM $message_tb WHERE receive_id='$receiveid' AND receive_admin='n' AND chkok='n' ORDER BY number ASC LIMIT 1";
	$Record		= @mysql_query($Sql,$dbconn);

	$Sql		= "UPDATE $message_tb SET chkok='y' WHERE receive_id='$receiveid' AND chkok='n' ";
	@mysql_query($Sql,$dbconn);

	$number		= "";
	while ( $Data = @happy_mysql_fetch_array($Record) )
	{
		$number.= $Data["number"]."||".$Data["sender_id"]."||".$Data["sender_name"].",";
	}

	if ( $number != '' ) {
		echo "ok__".$number;
	}
	else {
		echo "no";
	}

?>