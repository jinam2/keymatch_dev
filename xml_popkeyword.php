<?php

	include ("./inc/config.php");
	include ("./inc/function.php");

	query("set names utf8");

	$cdate	= $keyword_rank_day;

	if ( $cdate == "" || $cdate == "0" )
	{
		$cdate	= 10;
	}

	$year		= ( $_GET["key_year"]== "" )?date("Y"):$_GET["key_year"];
	$mon		= ( $_GET["key_mon"] == "" )?date("m"):$_GET["key_mon"];
	$day		= ( $_GET["key_day"] == "" )?date("d"):$_GET["key_day"];


	$nowDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day+1,$year));
	$firstDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-$cdate+1,$year));
	$lastDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-($cdate*2)+1,$year));

	$rankPrintSize	= 10;

	$Sql	 = "	SELECT											";
	$Sql	.= "			keyword,								";
	$Sql	.= "			sum(count) AS cnt						";
	$Sql	.= "	FROM											";
	$Sql	.= "			$keyword_tb								";
	$Sql	.= "	WHERE											";
	$Sql	.= "			regdate < '$firstDate'					";
	$Sql	.= "			AND										";
	$Sql	.= "			regdate > '$lastDate'					";
	$Sql	.= "			AND										";
	$Sql	.= "			replace(keyword,' ','') != ''			";
	$Sql	.= "	GROUP BY										";
	$Sql	.= "			keyword									";
	$Sql	.= "	ORDER BY										";
	$Sql	.= "			cnt desc								";
	$Sql	.= "	LIMIT	0,30									";

	$Rs2	= query($Sql);

	$rank	= 1;
	while ( $Hash = happy_mysql_fetch_array($Rs2) )
	{
		$pRank[$Hash["keyword"]]	= $rank;
		$rank++;
	}




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
	$Sql	.= "			0,$rankPrintSize						";

	$Rs1	= query($Sql);

	$rank	= 1;
	$rankList	= "";

	while ( $Data = happy_mysql_fetch_array($Rs1) )
	{
		$rankChk	= $pRank[$Data["keyword"]];

		$rank_word	= $Data["keyword"];
		$rank_word_encode = urlencode($Data["keyword"]);
		$rank_num	= $rank;
		$rank_cnt	= $Data["cnt"];



		if ( $rankChk == "" ) {
			$rank_icon		= $rankIcon_new;
			$whyicon		= "1";
			$tmp			= '';
			$rank_change	= "";
		}
		else if ( $rankChk > $rank ) {
			$tmp	= $rankChk - $rank;
			$whyicon		= '0';
			$rank_change	= $tmp;
		}
		else if ( $rankChk < $rank ) {
			$tmp	= $rank - $rankChk;
			$whyicon		= '2';
			$rank_change	= $tmp;
		}
		else if ( $rankChk == $rank ) {
			$rank_icon		= $rankIcon_equal;
			$whyicon		= '1';
			$rank_change	= "";
			$tmp			= '';
		}

		$checkfield = ( $rank != 1 )?$checkField:"";

		$rank_keyword["m".$rank]	= str_replace("\n","",$temp);


		$rankList	.= "<List url='price_search.php?search_word=$rank_word_encode' target='' keyword='$rank_word' status='$tmp' whyicon='$whyicon'/>\n";
		$rank++;
	}




print <<<END
<?xml version="1.0" encoding="euc-kr"?>

<xmlstart>

<banner>
$rankList
</banner>

<speed speed="3000"/>
<color numcolor="466ec1" keycolor="FFFFFF" stycolor="466ec1" numtextcolor="FFFFFF"/>
<imgurl imgurl="img/"/>

</xmlstart>

<!-- keyword가 길 경우 프로그램에서 잘라줄것-->
<!-- url 링크주소 -->
<!-- target 링크타겟 비워두면됨니다 -->
<!-- keyword 인기검색어 키워드명 -->
<!-- status 등락폭 -->
<!-- whyicon 키워드 상승-유지-하락 아이콘 출력 0:상승 / 1:유지 / 2:하락 -->


END;

?>