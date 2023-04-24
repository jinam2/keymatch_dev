<?//iconv("EUC-KR","UTF-8",$_GET['keyword'])
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	if ( trim(iconv("utf-8","euc-kr",$_GET["keyword"])) == "" )
	{
		$search_word	= iconv("euc-kr","utf-8",$_GET["keyword"]);
	}
	else
	{
		$search_word	= $_GET["keyword"];
	}

	if ( preg_match('/[^\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}0-9a-zA-Z]/u',$search_word) )
	{
		error("잘못된 단어입니다");
		exit;
	}

	if ( str_replace(" ","",$search_word) != "" )
	{
		$year		= date("Y");
		$mon		= date("m");
		$day		= date("d");

		$Sql	= "SELECT number FROM $keyword_tb WHERE year='$year' AND mon='$mon' AND day='$day' AND keyword='$search_word' ";

		$Data	= happy_mysql_fetch_array(query($Sql));

		if($_SERVER[HTTP_REFERER] != ""){
			if ( $Data["number"] == "" )
			{
				$Sql	 = "	INSERT INTO								";
				$Sql	.= "			$keyword_tb						";
				$Sql	.= "	SET										";
				$Sql	.= "			year	= '$year',				";
				$Sql	.= "			mon		= '$mon',				";
				$Sql	.= "			day		= '$day',				";
				$Sql	.= "			count	= '1',					";
				$Sql	.= "			keyword	= '$search_word',		";
				$Sql	.= "			regdate = now()					";
			}
			else
			{
				$Sql	 = "	UPDATE									";
				$Sql	.= "			$keyword_tb						";
				$Sql	.= "	SET										";
				$Sql	.= "			count = count+1					";
				$Sql	.= "	WHERE									";
				$Sql	.= "			number='$Data[number]'			";
			}

			query($Sql);
		}

		if ( date("s") % 10 == 7 && $keyword_delete_day != 0 )
		{
			$chkDate	= date("Y-m-d", happy_mktime(0,0,0,date("m"),date("d") - $keyword_delete_day ,date("Y")));

			$Sql	= "DELETE FROM $keyword_tb WHERE regdate < '$chkDate' ";
			query($Sql);
			#echo "delete complate";
		}
	}
?>