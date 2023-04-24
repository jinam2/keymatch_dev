<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	# 솔루션 마다 달라서 꼭 변경
	$file_url				= "/all_search.php?all_keyword=";

	#$_GET['opt1'] = 10;$_GET['opt2'] = 20;

	$TagCount				= preg_replace("/\D/", "", $_GET['opt1']);
	$FontSize				= preg_replace("/\D/", "", $_GET['opt2']);
	$FontColor				= $_GET['opt3'];

	if ( $TagCount == '' || $FontSize == '' || $FontColor == '' )
	{
		exit;
	}


	$HAPPY_CONFIG['Cloud_Period_Day']				= $HAPPY_CONFIG['Cloud_Period_Day'] == ""? "355" : $HAPPY_CONFIG['Cloud_Period_Day'];

	$year		= date("Y");
	$mon		= date("m");
	$day		= date("d");

	$nowDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day+1,$year));
	$firstDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-$HAPPY_CONFIG['Cloud_Period_Day']+1,$year));
	$lastDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-($HAPPY_CONFIG['Cloud_Period_Day']*2)+1,$year));


	$Sql	 = "	SELECT											";
	$Sql	.= "			*,										";
	$Sql	.= "			sum(count) AS cnt						";
	$Sql	.= "	FROM											";
	$Sql	.= "			$keyword_tb								";
	$Sql	.= "	WHERE											";
	$Sql	.= "			regdate > '$firstDate'					";
	$Sql	.= "			AND										";
	$Sql	.= "			regdate < '$nowDate'					";
	$Sql	.= "			AND										";
	$Sql	.= "			replace(keyword,' ','') != ''			";
	$Sql	.= "	GROUP BY										";
	$Sql	.= "			keyword									";
	$Sql	.= "	ORDER BY										";
	$Sql	.= "			cnt desc								";
	$Sql	.= "	LIMIT											";
	$Sql	.= "			0,$TagCount								";

	$result	= query($Sql);



	$tagcloud			= "<tags>";
	while($array = happy_mysql_fetch_array($result))
	{
		$Color				= $FontColor;
		$Color				= $Color == ""? "0x".dechex(rand(0,10000000)) : "0x".$FontColor;
		$encode_keyword		= urlencode($array['keyword']);

		if ( $server_character != "utf8" )
		{
			$array['keyword']	= iconv("EUC-KR", "UTF-8", $array['keyword']);
		}

		$array['keyword']	= htmlspecialchars($array['keyword']);

		$url = $main_url.$file_url.$encode_keyword;

		$tagcloud			.= "<a href='".$url."' style='font-size:".$FontSize."pt;' color='".$Color."'>".$array['keyword']."</a>";
	}

	// 마지막에 닫아준다.
	$tagcloud			.= "</tags>";

	print $tagcloud;
?>