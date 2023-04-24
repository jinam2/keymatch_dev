<?PHP
header("Content-type: text/html; charset=utf-8");
require_once('../secure_config.php') ;												//보안설정
require_once('../config.php') ;																	//에디터 모듈 통합설정

function getcontent( $get_search, $scale='', $start='' )
{
	global $naver_search_key;
	$cont		= "";
	$start		= preg_replace("/\D/","",$start);
	$start		= $start == '' ? 1 : $start+1;
	$scale		= preg_replace("/\D/","",$scale);
	$scale		= $start == '' ? 10 : $scale;
	$naver_key	= $_GET['naver_key'];
	$get_search	= iconv("euc-kr","utf-8",$get_search);

	$server		= "openapi.naver.com";
	$file		= "/search?key=". $naver_search_key ."&query=". $get_search ."&target=local&start=$start&display=$scale&sort=vote";

	$fp			= pfsockopen($server, 80, $errno, $errstr);
	if (!$fp)
	{
		echo "$errstr ($errno)<br/>\n";
		exit;
	}
	else
	{
		fputs($fp, "GET $file  HTTP/1.1\r\n");
		fputs($fp, "Host: $server\r\n");
		fputs($fp, "Connection: close\r\n\r\n");

		fwrite($fp, $out);

		while (!feof($fp))
		{
			$cont .= fgets($fp, 128);
			#echo fgets($fp, 128);
		}
		fclose($fp);
		return $cont;
	}
}

function getpoint($data,$start_str,$end_str)
{
	$i=0;
	while( is_int($pos = strpos($data, $start_str, $i)) )
	{
		$pos			+= strlen($start_str);
		$endpos			= strpos($data,$end_str, $pos);
		$value			= substr($data, $pos, $endpos-$pos);
		//echo $value."<br>";

		$value_array[]	= $value;
		$i				= $endpos;
	}
	return $value_array;
}

#echo $_GET['keyword'];


############################################################################################################################

$start			= $_GET['start'] == '' ? 0 : $_GET['start'];
$scale			= 10;
$pageScale		= 3;

$SearchResult	= getcontent($_GET['keyword'], $scale, $start);
$total			= getpoint($SearchResult,"<total>","</total>");

//print_r($SearchResult);

$searchMethod	= "&naver_key=$_GET[naver_key]";
$searchMethod	.= "&keyword=". urlencode($_GET[keyword]);

$paging			= newPaging( $total[0], $scale, $pageScale, $start, "", "", $searchMethod);



#$SearchResult	= getpoint($SearchResult,"<item>","</item>");
$xpoint			= getpoint($SearchResult,"<mapx>","</mapx>");
$ypoint			= getpoint($SearchResult,"<mapy>","</mapy>");
$title			= getpoint($SearchResult,"<title>","</title>");
$phone			= getpoint($SearchResult,"<telephone>","</telephone>");
$address		= getpoint($SearchResult,"<address>","</address>");



$maxSize		= sizeof($title)-1;
$outContent		= '';
$outScript		= '';

for( $i=0,$j=1 ; $i<$maxSize ; $i++,$j++ )
{
	$start++;
	$title[$j]	= addslashes($title[$j]);
	$title[$j]	= str_replace("&lt;", "<", $title[$j]);
	$title[$j]	= str_replace("&gt;", ">", $title[$j]);

	$outContent	.= "
		<div>
			<img src='images/lpos_$j.gif' align='absmiddle'><a href='#maplink' onClick=\"parent.navermap_move('$xpoint[$i]','$ypoint[$i]',3);\">$title[$j]</a><br>
			$phone[$i]<br>
			$address[$i]
		</div>
	";

	$outScript	.= "parent.navermap_marker_add( $j, '$title[$j]', '$xpoint[$i]','$ypoint[$i]' );\n\t\t\t";
}
for ( ; $j<=20 ; $j++ )
{
	//$outScript	.= "parent.navermap_marker_add( $j, '$title[$j]', '','' );\n\t\t\t";
}
//$outScript	.= "parent.navermap_move('388628','390920',11);parent.navermap_zoom_now();";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- 해피CGI 솔루션외 사용을 금합니다. -->
<html>
	<head>
		<title>Naver Map</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="noindex, nofollow" name="robots">
		<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">

		<script>
			<?=$outScript?>
		</script>
	</head>
	<body xstyle="OVERFLOW: hidden" scroll="no">

		<table width='100%' border=0 cellspacing=0 cellpadding=0>
		<tr>
			<td align='center' style='padding:8px;'><table border=0 align='center'><tr><td align='center'><?=$paging?></td></tr></table></td>
		</tr>
		<tr>
			<td height=1 bgcolor='#CCCCCC'></td>
		</tr>
		<tr>
			<td>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td style='padding:10px 4px 10px 4px; font-size:8pt;'>

					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td><div style='color:white; font-size:8pt; width:91; height:19; padding:4px 0 0 12px; background:url(images/bg_search_tbar.gif)'>총 검색결과</div></td>
						<td style='font-size:8pt;' align='right'><font style='font-family:tahoma; font-size:11pt; font-weight:bold; color:#FF3A00;'><?=$total[0]?></font> 개</td>
					</tr>
					</table>

					</td>
				</tr>
				<tr>
					<td style='font-size:8pt; padding:6px 8px 6px 8px;'><font color=#CC8888>검색결과의 마크아이콘는 저장시 노출은 되지 않습니다.</font><br><br></td>
				</tr>
				<tr>
					<td style='font-size:8pt; padding:0 8px 0 8px;'>
						<?=$outContent?>
					</td>
				</tr>
				</table>


			</td>
		</tr>
		<tr>
			<td align='center' style='padding:8px;'><table border=0 align='center'><tr><td align='center'><?=$paging?></td></tr></table></td>
		</tr>
		</table>

	</body>
</html>


<?
function newPaging( $totalList, $listScale, $pageScale, $startPage, $prexImgName, $nextImgName, $search) {
	$paging	= "<font style='font-size:13px'>";

	$nowPage	= ($startPage / $listScale) + 1;

	$Start		= ( $nowPage - $pageScale > 0 )?$nowPage-$pageScale:0;
	$Start		= ( $Start - 1 < 0 )?0:$Start-1;
	$End		= $nowPage+$pageScale;
	//$paging	= $nowPage." - ".$Start."<br>";


	if( $totalList > $listScale ) {

		if ( $nowPage - 1 > 0 )
		{
			$prePage	= ($nowPage-2)*$listScale;
			$paging	.= "<a href='$_SERVER[PHP_SELF]?start=".$prePage.$search."' onfocus=this.blur()>$prexImgName</a>";
		}
		else
			$paging	.= "$prexImgName";

		for( $j=$Start; $j<$End; $j++ ) {
			$nextPage = $j * $listScale;
			$pageNum = $j+1;
			if( $nextPage < $totalList ) {
				if( $nextPage!= $startPage ) {

					$paging	.= "<div style='float:left; width:16px; height:16px; padding:2px; border:1px solid #BBB;'><div><a href='$_SERVER[PHP_SELF]?start=".$nextPage.$search."' onfocus=this.blur()>$pageNum</a></div></div>";
				} else {
					$paging	.= "<div style='float:left; width:22px; height:16px; padding:2px; border:1px solid red; background-color:red;><div><a href='$_SERVER[PHP_SELF]?start=".$nextPage.$search."' onfocus=this.blur()><font color=white><b>$pageNum</b></font></a></div></div>";
				}
			}
		}

		if ( ($nowPage*$listScale) < $totalList )
		{
			$nNextPage	= ($nowPage)*$listScale;
			$paging	.= "<a href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."' onfocus=this.blur()>$nextImgName</a>";
		}
		else
			$paging	.= "$nextImgName";

	}
	if( $totalList <= $listScale) {
		$paging	.= "<div style='float:left; width:16px; height:16px; padding:2px; border:1px solid #BBB; background-color:red;><div><a href='$_SERVER[PHP_SELF]?start=0".$search."' onfocus=this.blur()><font color='white'>1</font></b></a></div></div>";
	}
	$paging	.= "</font>";
	return $paging;
}
?>