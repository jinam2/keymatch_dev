<?
	include ("./inc/config.php");
	include ("./inc/function.php");

	header("Content-Type: text/html; charset=utf-8");

	$word			= str_replace(" ", "", $_GET["word"]);
	$is_submit		= $_GET['is_submit'];

	if ( $is_submit == 1 )
	{
		$submit_script	= "underground_search();";
	}
	else
	{
		$submit_script	= "underground_search2();";
	}

	$Sql			= "SELECT * FROM $job_underground_tb WHERE depth = 1 ORDER BY title ASC";
	$Result			= query($Sql);

	$chk			= 0;

	while( $list = happy_mysql_fetch_array($Result) )
	{
		$view_word		= str_replace($word, "<font style='color:#f65400;font-weight:bold;'>$word</font>", $list["title"] );

		$Sql2			= "SELECT COUNT(*) FROM $job_underground_tb WHERE depth = 2 AND underground1 = '$list[number]' AND title like '%$word%' ";
		list($list2_count) = happy_mysql_fetch_array(query($Sql2));

		if ( $list2_count > 0 || strpos($list["title"],$word) !== false )
		{
			if( $chk == 0 )
			{
				echo "<table style=\"width:100%;\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
			}

			$chk++;

			$underground_text	= "$list[title]";

			echo "
			<tr onmousedown=\"underground_select('$list[number]','','$underground_text'); $submit_script\">
				<td height='25' style='padding-left:5px;' id='under_search_word_td_$chk'>
					<input type='hidden' id='h_underground_$chk' value='$list[number]____$underground_text'>
					<label id='under_search_word_$chk' style='cursor:pointer'>$view_word</label>
				</td>\n
			</tr>\n
			";
		}

		$Sql3			= "SELECT * FROM $job_underground_tb WHERE depth = 2 AND underground1 = '$list[number]' AND title like '%$word%' ORDER BY title ASC";
		$Result3		= query($Sql3);

		while ( $list2 = happy_mysql_fetch_array($Result3) )
		{
			$view_word2		= str_replace($word, "<font style='color:#f65400;font-weight:bold;'>$word</font>", $list2["title"] );

			$chk++;

			$underground_text2	= "$list[title] > $list2[title]";

			echo "
			<tr onmousedown=\"underground_select('$list[number]','$list2[number]','$underground_text2'); $submit_script\">
				<td height='25' style='padding-left:5px;' id='under_search_word_td_$chk'>
					<input type='hidden' id='h_underground_$chk' value='$list[number]__$list2[number]__$underground_text2'>
					<label id='under_search_word_$chk' style='cursor:pointer'>$view_word > $view_word2</label>
				</td>\n
			</tr>\n
			";
		}
	}

	if( $chk != 0 )
	{
		echo "</table>";
	}

	echo "___cut___".$chk;
?>