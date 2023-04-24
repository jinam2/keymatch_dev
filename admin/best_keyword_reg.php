<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");

	if ( !admin_secure("추천키워드") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	$mode			= $_POST["mode"];

	$cdate			= $keyword_rank_day;
	$year			= ( $_POST["key_year"]== "" )?date("Y"):$_POST["key_year"];
	$mon			= ( $_POST["key_mon"] == "" )?date("m"):$_POST["key_mon"];
	$day			= ( $_POST["key_day"] == "" )?date("d"):$_POST["key_day"];
	$key_size		= $_POST["key_size"];

	$nowDate		= date("Y-m-d", happy_mktime(0,0,0,$mon,$day+1,$year));
	$nowDate2		= date("Y-m-d", happy_mktime(0,0,0,$mon,$day,$year));
	$firstDate		= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-$cdate+1,$year));
	$lastDate		= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-($cdate*2)+1,$year));


	if ( $mode == "add" )
	{

		$Sql	 = "	INSERT INTO								";
		$Sql	.= "			$keyword_tb						";
		$Sql	.= "	SET										";
		$Sql	.= "			year	= '$year',				";
		$Sql	.= "			mon		= '$mon',				";
		$Sql	.= "			day		= '$day',				";
		$Sql	.= "			count	= '$count',				";
		$Sql	.= "			keyword	= '$keyword',			";
		$Sql	.= "			regdate	= '$nowDate2 01:01:01'	";

		query($Sql);
		$msg	= "추가되었습니다.";
	}
	else if ( $mode == "modify" )
	{
		$allcount = count($_POST["keyword"]);
		for( $i=1; $i<=$allcount; $i++ )
		{
			$keyword[$i]		= $_POST["keyword"][$i];
			$prev_keyword[$i]	= $_POST["prev_keyword"][$i];
			$prev_count[$i]	= $_POST["prev_count"][$i];
			$count[$i]			= $_POST["count"][$i];
			$delch[$i]			= $_POST["delch"][$i];
			//echo $count[$i]."    <br>";
			if($delch[$i]=="Y")
			{
				$Sql	 = "	DELETE FROM									";
				$Sql	.= "			$keyword_tb							";
				$Sql	.= "	WHERE										";
				$Sql	.= "			regdate > '$firstDate'				";
				$Sql	.= "			AND									";
				$Sql	.= "			regdate < '$nowDate'				";
				$Sql	.= "			AND									";
				$Sql	.= "			keyword = '$prev_keyword[$i]'			";
				//echo "삭제 ".$Sql."<br>";
				query($Sql);
			}
			else if ( $prev_keyword[$i] != $keyword[$i] || $prev_count[$i] != $count[$i] )
			{
				$Sql	 = "	SELECT										";
				$Sql	.= "			count(*) AS cnt						";
				$Sql	.= "	FROM										";
				$Sql	.= "			$keyword_tb							";
				$Sql	.= "	WHERE										";
				$Sql	.= "			regdate > '$firstDate'				";
				$Sql	.= "			AND									";
				$Sql	.= "			regdate < '$nowDate'				";
				$Sql	.= "			AND									";
				$Sql	.= "			keyword = '$prev_keyword[$i]'			";

				$tmp	= happy_mysql_fetch_array(query($Sql));

				$cCount	= round($count[$i]/$tmp["cnt"]);

				$Sql	 = "	UPDATE										";
				$Sql	.= "			$keyword_tb							";
				$Sql	.= "	SET											";
				$Sql	.= "			keyword	= '$keyword[$i]',				";
				$Sql	.= "			count	= '$cCount'					";
				$Sql	.= "	WHERE										";
				$Sql	.= "			regdate > '$firstDate'				";
				$Sql	.= "			AND									";
				$Sql	.= "			regdate < '$nowDate'				";
				$Sql	.= "			AND									";
				$Sql	.= "			keyword = '$prev_keyword[$i]'			";

				//echo "수정 ".$Sql."<br>";
				query($Sql);
			}

		}
		$msg	= "수정되었습니다.";
	}
	else
		exit;

	$returnUrl	= "best_keyword.php?key_year=".$year."&key_mon=".$mon."&key_day=".$day."&key_size=".$key_size;
	gomsg($msg,$returnUrl);
?>