<?
	include ("../../inc/config.php");
	include ("../../inc/function.php");

	################################################################################################

	$update_setting		= '';		//접속통계 오늘날짜로 업데이트

	################################################################################################

	$Sql				= "select * from $happy_analytics_tb order by number desc limit 1";
	$Result				= query($Sql);
	$Data				= happy_mysql_fetch_array($Result);

	list($sDateY,$sDateM,$sDateD) = explode("-",$Data['sdate']);	//기존 시작날짜
	list($eDateY,$eDateM,$eDateD) = explode("-",$Data['edate']);	//기존 마감날짜

	$mktime_sDate		= happy_mktime(0,0,0,$sDateM,$sDateD,$sDateY);
	$mktime_eDate		= happy_mktime(0,0,0,$eDateM,$eDateD,$eDateY);

	$term				= happy_mktime() - $mktime_eDate;

	$visitorsArray		= explode("\n",$Data['getVisitors']);
	$visitorsArray2		= array();

	$vPlue				= 0;

	foreach ( $visitorsArray as $list )
	{
		list($Vdate,$Vvalue)	= explode("|",$list);
		$mktime_vDate			= $mktime_sDate+$vPlue;
		$visitorsArray2[]		= date("Y-m-d",$mktime_vDate+$term)."|".$Vvalue;
		$vPlue					= $vPlue + (60*60*24);
	}

	$pageviewsArray		= explode("\n",$Data['getPageviews']);
	$pageviewsArray2	= array();

	$pPlus				= 0;

	foreach ( $pageviewsArray as $list )
	{
		list($Pdate,$Pvalue)	= explode("|",$list);
		$mktime_pDate			= $mktime_sDate+$pPlus;
		$pageviewsArray2[]		= date("Y-m-d",$mktime_pDate+$term)."|".$Pvalue;
		$pPlus					= $pPlus + (60*60*24);
	}

	$update_sdate		= date("Y-m-d",$mktime_sDate+$term);
	$update_edate		= date("Y-m-d",$mktime_eDate+$term);
	$update_Visitors	= implode("\n",$visitorsArray2);
	$update_Pageviews	= implode("\n",$pageviewsArray2);

	$Sql			= "
						UPDATE
								$happy_analytics_tb
						SET
								sdate		= '$update_sdate',
								edate		= '$update_edate',
								getVisitors	= '$update_Visitors',
								getPageviews= '$update_Pageviews',
								regdate		= now()
	";


	if ( $update_setting == '1' )
	{
		query($Sql);
		echo "<h1><font color=red>업데이트 완료!!!</font></h1>";
	}
	else
	{
		echo "<h1><font color=blue>update_setting 변수에 1 값을 넣어주세요! </font></h1>";
	}

	echo "<br> 쿼리보기 ===============================================<br>";
	echo nl2br($Sql);


?>