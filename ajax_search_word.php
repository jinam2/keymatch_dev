<?
	include ("./inc/config.php");
	include ("./inc/function.php");

	header("Content-type: text/xml");

/*
CREATE TABLE `auto_search_word` (
  `number` int(11) NOT NULL auto_increment,
  `auto_word` varchar(50) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `auto_use` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`number`),
  KEY `number` (`number`),
  KEY `auto_word` (`auto_word`)
) ENGINE=MyISAM ;

insert into auto_search_word set auto_word = '1', date = '0000-00-00 00:00:00', auto_use = '1';
*/

	//$_GET["word"] = ($server_character != "euckr")?iconv("euckr","utf8",$_GET["word"]):$_GET["word"];

	$word = str_replace(" ", "", $_GET["word"]);
	$sql = "select * from $auto_search_tb where auto_word like '%$word%'";
	$result = query( $sql );

	$chk = 0;

	while( $list = happy_mysql_fetch_array($result) )
	{
		//$link_word = iconv("euc-kr", "utf-8", $list["auto_word"]);
		$link_word = $list["auto_word"];

		$view_word = str_replace($word, "<font style='color:#f65400;font-weight:bold;'>$word</font>", $list["auto_word"] );

		//$view_word = iconv("euc-kr", "utf-8", $view_word);

		if( $chk == 0 )
		{
			echo "
					<table style=\"width:100%;\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n
					";
		}
		$chk++;

		echo "<tr onmousedown=\"go_search('$link_word')\">
					<td height='25' style='padding-left:5px;' id='search_word_td_$chk'><label id='search_word_$chk'>$view_word</label></td>\n
				</tr>\n";
	}

	if( $chk != 0 )
	{
		echo "
				</table>
		";
	}

	echo "___cut___".$chk;
?>