<?
	//  해피CGI 솔루션외 사용을 금합니다. //
	header("Content-Type: text/html; charset=utf-8");

	include "naverpg.php";
	function getcontent( $get_search, $scale='', $start='' )
	{
		$get_search	= iconv("utf-8","utf-8",$get_search);
		$get_search	= urlencode($get_search);

		$cont				= "";
		$start				= preg_replace("/\D/","",$start);
		$start				= $start == '' ? 1 : $start+1;
		$scale				= preg_replace("/\D/","",$scale);
		$scale				= $start == '' ? 10 : $scale;
		$naver_key			= $_GET['naver_key'];
		$naver_secret_key	= $_GET['naver_secret_key'];

		//$server	= "maps.naver.com";
		//$file		= "/api/geocode.php?key=".$naver_key."&query=".$get_search;

		/*
		$fp			= pfsockopen($server, 80, $errno, $errstr);
		if (!$fp)
		{
			echo "$errstr ($errno)<br/>\n";
			exit;
		}
		else
		{
			fputs($fp, "GET $file  HTTPS/1.1\r\n");
			fputs($fp, "Host: $server\r\n");
			fputs($fp, "Connection: close\r\n\r\n");

			fwrite($fp, $out);

			while (!feof($fp))
			{
				$cont .= fgets($fp, 128);
				#echo fgets($fp, 128);
			}
			fclose($fp);
		}
		*/


		$curl_url		= "https://naveropenapi.apigw.ntruss.com/map-geocode/v2/geocode?query=".$get_search;
		$curl_header	= Array(
								"Host: naveropenapi.apigw.ntruss.com",
								"User-Agent: curl/7.43.0",
								"Accept: application/xml",
								"X-NCP-APIGW-API-KEY-ID: $naver_key",
								"X-NCP-APIGW-API-KEY: $naver_secret_key"
		);


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
		$cont = curl_exec($ch);
		curl_close($ch);

		return $cont;


	}

	function getpoint($data,$start_str,$end_str)
	{
		$i=0;
		while( is_int($pos = strpos($data, $start_str, $i)) )
		{
			$pos			+= strlen($start_str);
			$endpos			= strpos($data,$end_str, $pos);
			$value			= substr($data, $pos, $endpos-$pos);
			$value			= iconv("euc-kr", "utf-8", $value);
			$value_array[]	= $value;
			$i				= $endpos;
		}

		return $value_array;
	}






	$start			= $_GET['start'] == '' ? 0 : $_GET['start'];
	$scale			= 10;
	$pageScale		= 3;

	$SearchResult	= getcontent($_GET['keyword'], $scale, $start);

	$total			= 0;

	$xml_parser				= xml_parser_create();
	xml_parse_into_struct($xml_parser,$SearchResult,$xml_vals,$index);
	$xml_parser_free_bool	= xml_parser_free($xml_parser);
	if ($xml_parser_free_bool == true)
	{
		foreach($xml_vals AS $XML_ARR)
		{
			//echo $XML_ARR['tag']." / ".$XML_ARR['value']."<br>";
			switch($XML_ARR['tag'])
			{
				case "TOTAL":			$total		= $XML_ARR['value'];break;
				case "ADDRESS":			$address[]	= $XML_ARR['value'];break;
				case "Y":				$xpoint[]	= $XML_ARR['value'];break;
				case "X":				$ypoint[]	= $XML_ARR['value'];break;
			}
		}
	}

	//$total			= getpoint($SearchResult,"<total>","</total>");


	$searchMethod	= "&naver_key=$_GET[naver_key]";
	$searchMethod	.= "&keyword=". urlencode($_GET[keyword]);

	$paging			= newPaging( $total, $scale, $pageScale, $start, "", "", $searchMethod);

	#echo $_GET['keyword'];
	#echo $SearchResult;exit;

	/*
	$ypoint			= getpoint($SearchResult,"<x>","</x>");
	$xpoint			= getpoint($SearchResult,"<y>","</y>");
	$address		= getpoint($SearchResult,"<address>","</address>");
	*/





//echo $xpoint."sdfsdfsf";exit;
	/*
	print_r($address);
	print_r($xpoint);
	print_r($ypoint);
	*/


	$maxSize		= sizeof($address);
	$outContent		= '';
	//$outScript		= 'parent.mapObj.clearOverlays();';
	//$outScript		= 'parent.mapObj.clearOverlay();';
	$outScript		= "
						for(var ii in parent.markObj2)
						{
							parent.markObj2[ii].setMap(null);
						}
	";

	$k = 0;
	for( $i=0,$j=1 ; $i<$maxSize ; $i++,$j++ )
	{
		if ( $i > $start-1 && $i < $scale+$start )
		{
			$k++;

			$outContent	.= "<img src='images/lpos_$k.gif' align='absmiddle'><a href='#maplink' onClick=\"parent.navermap_move('api_map','$xpoint[$i]','$ypoint[$i]',10);\" onMouseOver=this.style.backgroundColor='#FE9' onMouseOut=this.style.backgroundColor='#FFF'>$address[$i]</a><br /><br />";
			$outScript	.= "parent.navermap_marker_add( 'api_map', $k, '', '$xpoint[$i]', '$ypoint[$i]' );\n\t\t\t";
		}
	}

	$outScript	.= "parent.navermap_move('api_map','36.785372','127.65514',2);parent.navermap_zoom_now();";


	#출력 시작#########################################
	if($total == 0)
	{
		echo "
			<HTML>
			<HEAD>
			<TITLE>검색결과</TITLE>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=EUC-KR\">
			<link rel='stylesheet' type='text/css' href='css/style.css'>
			<script>
				$outScript
			</script>

			</HEAD>

			<body >
			<table width='100%' border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td>
					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td style='padding:5px 4px 10px 4px; font-size:11px; border-bottom:1px solid #dedede;'>

						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td><div style='color:000; font-size:12px; font-family:맑은 고딕; width:91px; height:19px; padding:4px 0 0 0;'>총 검색결과</div></td>
							<td style='font-size:12px;' align='right'><font style='font-family:tahoma; font-size:12px; font-weight:bold; color:#FF3A00;'>$total</font> 개</td>
						</tr>
						</table>

						</td>
					</tr>
					</table>
					<div style='font-size:11px; font-family:돋움; padding:10px 8px 10px 4px; color:#909090; border-bottom:1px solid #dedede;'>검색된 결과가 없습니다</div>
					</tr>
				</tr>
			</tr>
			</table>
			";
	}
	else
	{
		echo "
			<HTML>
			<HEAD>
			<TITLE>검색결과</TITLE>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=EUC-KR\">
			<link rel='stylesheet' type='text/css' href='css/style.css'>
			<script>
				$outScript
			</script>

			</HEAD>


			<body >
			<table width='100%' border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td>
					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td style='padding:5px 4px 10px 4px; font-size:11px; border-bottom:1px solid #dedede;'>

						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
						<tr>
							<td><div style='color:000; font-size:12px; font-family:맑은 고딕; width:91px; height:19px; padding:4px 0 0 0;'>총 검색결과</div></td>
							<td style='font-size:12px;' align='right'><font style='font-family:tahoma; font-size:12px; font-weight:bold; color:#FF3A00;'>$total</font> 개</td>
						</tr>
						</table>

						</td>
					</tr>
					<tr>
						<td style='font-size:11px; font-family:돋움; padding:10px 8px 10px 4px; color:#909090; border-bottom:1px solid #dedede;'>검색결과의 마크아이콘는 저장시 노출은 되지 않습니다</td>
					</tr>
					</table>
					<table width='100%' border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td style='font-size:12px; padding:10px 8px 0 8px;'>$outContent</td>
					</tr>
					</table>
					</tr>
				</tr>
			</tr>
			</table>
			";
	}
	//?naver_key=54c0ff396ff9794f673d97c1be9683c1&keyword=%EB%8C%80%ED%95%99#maplink
?>