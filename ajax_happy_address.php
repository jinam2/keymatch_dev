<?php

$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/lib.php");

$return_site_name	= $_SERVER['SERVER_NAME'];

$server_char		= strtolower($server_character);

$url_encoding		= '';
if($server_char != 'euckr' && $server_char != 'euc-kr')
{
	$url_encoding	= '&encoding=utf8';
}
else
{
	$_GET[addr]		= iconv("utf-8","euc-kr",$_GET[addr]);
	$_GET[doro]		= iconv("utf-8","euc-kr",$_GET[doro]);
}

$geonmul		= explode("-",$_GET[geonmul1]);

//생성할 URL
if( $_GET[addr] != '')
{
	//http://post.cgimall.co.kr/zipcode_juso_return.php?addr=대구|달서구||&site=testmall2.happycgi.com&test=ok&doro=성당로&geonmul1=289
	$get_url			= $zipcode_site . '/' . $zipcode_juso_file . '?addr=' . urlencode(iconv("utf-8","euc-kr",$_GET[addr])).'&doro='.urlencode(iconv("utf-8","euc-kr",$_GET[doro])).'&geonmul1='.urlencode(iconv("utf-8","euc-kr",$geonmul[0])).'&geonmul2='.urlencode(iconv("utf-8","euc-kr",$geonmul[1]));
}


$url				= 'http://' . $get_url . '&site=' . $_SERVER['SERVER_NAME'] . $url_encoding;

//쿼리문 확인하고 싶을때 아래 주석해제.		hun
//$url .= "&test=ok";

//echo $url; exit;
switch($sock_connect_type)
{
	case 'curl' :
		$contents		= curl_get_file_contents($url);
	break;
	case 'fsock' :
		$contents		= file_get_contents_fsockopen($url);
	break;
	case 'snoopy' :
		$contents		= snoopy_class($url);
	break;
	default :
		$contents		= file_get_contents_fsockopen($url);
	break;
}

if($contents == '')
{
	exit;
}

//XML 확인하고 싶을때 아래 주석해제.		hun
//echo $contents; exit;


$total_sejong		= getXMLValue($contents, '<TOTAL>', '</TOTAL>',1);
$result_code_sejong	= getXMLValue($contents, '<RESULT_CODE>', '</RESULT_CODE>',1);

if($total_sejong == 0 )
{
	$RETURN_MSG			= "LIMIT_ZERO";
}
/*		완벽히 매칭되는것만 검새하게 하려면.. 아래의 주석을 해제하시오.
else if($total_sejong > 1)
{
	$RETURN_MSG	= "LIMIT_OVER";
}
*/
//else if($result_code_sejong == '99' && $total_sejong == '1')
else if($result_code_sejong == '99')
{
	$RETURN_MSG	= "SUCCESS";
	$SI			= getXMLValue($contents, '<SI>', '</SI>',1);

	if(!preg_match("/세종시/i",$_GET[addr]))
	{
		$GU			= getXMLValue($contents, '<GU>', '</GU>',1);
		$EUP		= getXMLValue($contents, '<EUP>', '</EUP>',1);
		$DONG		= getXMLValue($contents, '<DONG>', '</DONG>',1);
		$DONG		= ( $DONG == '' ) ? $EUP : $DONG;
		$RI			= getXMLValue($contents, '<RI>', '</RI>',1);

		$DONG		.= ( $RI != '' ) ? ' ' . $RI : '';
	}
	else
	{
		$GU			= getXMLValue($contents, '<EUP>', '</EUP>',1);
		$DONG		= getXMLValue($contents, '<RI>', '</RI>',1);
	}

	$JIBEON1	= getXMLValue($contents, '<JIBEON1>', '</JIBEON1>',1);
	$JIBEON2	= getXMLValue($contents, '<JIBEON2>', '</JIBEON2>',1);
	$ZIPCODE	= getXMLValue($contents, '<ZIPCODE>', '</ZIPCODE>',1);
	$GEONMUL3	= getXMLValue($contents, '<GEONMUL3>', '</GEONMUL3>',1);
	$GEONMUL4	= getXMLValue($contents, '<GEONMUL4>', '</GEONMUL4>',1);

	// 도로명주소레이어
	$DONG		= ($GEONMUL3 == '') ? $DONG : $DONG . ' ' . $GEONMUL3;

	$ZIPCODE2 = SubStr($ZIPCODE,0,3)."-".SubStr($ZIPCODE,3,6);
}

echo $RETURN_MSG."___CUT___".$SI."___CUT___".$GU."___CUT___".$DONG."___CUT___".$JIBEON1."___CUT___".$JIBEON2."___CUT___".$ZIPCODE;

?>