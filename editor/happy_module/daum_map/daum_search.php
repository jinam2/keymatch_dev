<?
	//  해피CGI 솔루션외 사용을 금합니다. //
	header("Content-Type: text/html; charset=utf-8");
	include "daum_page.php";

	function print_r2($var)
	{
		ob_start();
		print_r($var);
		$str = ob_get_contents();
		ob_end_clean();
		$str = preg_replace("/ /", "&nbsp;", $str);
		echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
	}

	function getcontent( $get_search, $scale='', $start='', $page='' )
	{
		$get_search			= urlencode($get_search);

		$cont				= "";
		$start				= preg_replace("/\D/","",$start);
		$start				= $start == '' ? 1 : $start+1;
		$scale				= preg_replace("/\D/","",$scale);
		$scale				= $start == '' ? 10 : $scale;
		$page				= preg_replace("/\D/","",$page);
		$page				= $start == '' ? 1 : $page;

		$daum_key			= $_GET['daum_key'];
		$daum_local_key		= $_GET['daum_local_key'];

		// API : https://developers.kakao.com/docs/restapi/local#키워드로-장소-검색
		// KakaoAK : {app_key} 는 REST_API 키(다음 로컬 키)
		$curl_url	= "https://dapi.kakao.com/v2/local/search/keyword.xml?query=".$get_search."&page=".$page."&size=".$scale;
		$curl_header= Array(
							"Host: dapi.kakao.com",
							"User-Agent: curl/7.43.0",
							"Accept: */*",
							"Content-Type: application/xml",
							"Authorization: KakaoAK {$daum_local_key}"
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

	############################################################################################################################

	$start			= $_GET['start'] == '' ? 0 : $_GET['start'];
	$page			= $_GET['page'] == '' ? 1 : $_GET['page'];
	$scale			= 15; //default:10 / max:15
	$pageScale		= 3;

	$SearchResult	= getcontent($_GET['keyword'], $scale, $start, $page);

	$object			= simplexml_load_string($SearchResult);

	$total			= $object->meta->total_count;

	//최대 page가 45 이며, 한페이지당 15개까지 보여줄 수 있음
	$maxCount		= $scale * 45;
	if ( $total > $maxCount )
	{
		$total			= $maxCount;
	}

	$total			= ( $total == "" ) ? 0 : $total;

	$title			= Array();
	$phone			= Array();
	$address		= Array();
	$address2		= Array();
	$xpoint			= Array();
	$ypoint			= Array();

	foreach ( $object->documents as $item )
	{
		array_push($title,$item->place_name);
		array_push($phone,$item->phone);
		array_push($address,$item->address_name);
		array_push($address2,$item->road_address_name);
		array_push($xpoint,$item->y);
		array_push($ypoint,$item->x);
	}

	$searchMethod	= "&daum_key=$_GET[daum_key]";
	$searchMethod	.= "&daum_local_key=$_GET[daum_local_key]";
	$searchMethod	.= "&keyword=". urlencode($_GET[keyword]);

	$paging			= newPaging( $total, $scale, $pageScale, $start, "", "", $searchMethod);

	$outContent		= '';
	$outScript		= '';

	for( $i=0,$j=1 ; $i<count($title) ; $i++,$j++ )
	{
		$start++;
		$title[$i]	= addslashes($title[$i]);
		$title[$i]	= str_replace("&lt;", "<", $title[$i]);
		$title[$i]	= str_replace("&gt;", ">", $title[$i]);

		$outContent	.= "
				<img src='images/lpos_$j.gif' align='absmiddle' style='margin-bottom:5px;'><a href='#maplink' onClick=\"parent.daummap_move('$xpoint[$i]','$ypoint[$i]',5);\">$title[$i]</a><br>
				$phone[$i]
				<div style='margin-top:5px; margin-bottom:5px; padding-bottom:10px; border-bottom:1px solid #dedede;'>$address[$i]<br>$address2[$i]</div>
		";

		$outScript	.= "parent.daummap_marker_add( $j, '$title[$i]', '$xpoint[$i]','$ypoint[$i]' );\n\t\t\t";
	}
	for ( ; $j<=20 ; $j++ )
	{
		$outScript	.= "parent.daummap_marker_add( $j, '$title[$i]', '','' );\n\t\t\t";
	}
	$outScript	.= "parent.daummap_move('36.785372','127.65514',13);parent.daummap_zoom_now();";


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
					<tr>
						<td style='font-size:12px; padding:10px 8px 0 8px;'>$outContent</td>
					</tr>
					</table>


				</td>
			</tr>
			<tr>
				<td align='center' style='padding:8px;'><table border=0 align='center'><tr><td align='center'>$paging</td></tr></table></td>
			</tr>
			</table>
		";
	}


?>