<?
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	/* 키워트 테이블명 가져오기 */
	global
		$keyword_tb,
		
		$cloud3d_limit,
		$cloud3d_fontcolor,
		$cloud3d_fontsize,
		$cloud3d_period_day,
		$cloud3d_speed;

	/*
		링크 주소
		솔루션 마다 달라서 꼭 변경
	*/
	$file_url				= "/all_search.php?action=search&all_keyword=";

	/* [관리자] 에서 설정 */
	
	$cloud3d_fontsize	= $HAPPY_CONFIG['cloud3d_fontsize'];
	$cloud3d_fontcolor	= $HAPPY_CONFIG['cloud3d_fontcolor'];
	$cloud3d_limit		= $HAPPY_CONFIG['cloud3d_limit'];
	$cloud3d_period_day	= $HAPPY_CONFIG['Cloud_Period_Day'];
	

	/* 기본값 셋팅 */
	if( $cloud3d_limit		== "" )	$cloud3d_limit		= "10"; // 10개
	if( $cloud3d_fontcolor == "" )	$cloud3d_fontcolor	= ""; // 빈값이면 여러가지색으로 표현
	if( $cloud3d_fontsize	== "" )	$cloud3d_fontsize	= "20"; // 20pt
	if( $cloud3d_period_day	== "" )	$cloud3d_period_day	= "365"; // 365일

	$Tmp					= happy_mktime(date("H"),date("i"),date("s"),date("m"),date("d") - $cloud3d_period_day,date("Y"));
	$Tmp					= date("Y-m-d H:i:s", $Tmp);

	$sql					= "
								SELECT
										keyword,
										sum(count) AS cnt
								FROM
										$keyword_tb
								WHERE
										regdate > '$Tmp'
								GROUP BY
										keyword
								ORDER BY
										cnt DESC
								LIMIT
										0, $cloud3d_limit
	";
	//echo nl2br($sql);

	$result				= query($sql);

	// 태그 사이에 값을 넣어주면 되고, 태그를 앞에 붙이고,
	$tagcloud			= "<tags>";

	// 태그 사이에 값을 넣는다.
	while($array = happy_mysql_fetch_array($result))
	{
		// 글자색을 빈값으로 입력하면 랜덤한 색상으로
		if($cloud3d_fontcolor == "")
		{
			// 랜덤한 색상
			$color			= "0x".dechex(rand(0,10000000));
		}
		else
		{
			// 글자색을 지정하면, 지정하는 색상으로
			$color			= "0x".$cloud3d_fontcolor;
		}

		// 유니코드??
		
		$encode_keyword	= urlencode($array['keyword']);
		$array[keyword]	= iconv("EUC-KR", "UTF-8", $array[keyword]);

		$array[keyword]	= htmlspecialchars($array[keyword]);

		$url = $main_url.$file_url.$encode_keyword;

		$tagcloud		.= "<a href='".$url."' style='font-size: ".$cloud3d_fontsize."pt;' color='$color'>$array[keyword]</a>";
	}

	// 마지막에 닫아준다.
	$tagcloud			.= "</tags>";

	print $tagcloud;
?>