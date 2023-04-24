<?php

$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/lib.php");

header("Content-Type: text/html; charset=utf-8");

$size_gu				= $_GET['size_gu'];
$size_addr				= $_GET['size_addr'];

if ( $size_gu )
{
	$size_gu				= str_replace("px","",$size_gu);
	$size_gu				= "width:{$size_gu}px;";
}

if ( $size_addr )
{
	$size_addr				= str_replace("px","",$size_addr);
	$size_addr				= "width:{$size_addr}px;";
}


$return_site_name		= $_SERVER['SERVER_NAME'];

$server_char			= strtolower($server_character);

$url_encoding			= '';
if($server_char != 'euckr' && $server_char != 'euc-kr')
{
	$url_encoding			= '&encoding=utf8';
}
else
{
	$_GET[si]		= iconv("utf-8","euc-kr",$_GET[si]);
	$_GET[gu]		= iconv("utf-8","euc-kr",$_GET[gu]);
	$_GET[dong]		= iconv("utf-8","euc-kr",$_GET[dong]);
	// 도로명주소레이어
	$_GET[geonmul]	= iconv("utf-8","euc-kr",$_GET[geonmul]);
	$_GET[addr2]	= iconv("utf-8","euc-kr",$_GET[addr2]);
}

$FULL_NAME_SI_KEY		= array_keys($xml_area_full_name,$_GET['si']);
$Si_VALUE				= $xml_area1[$FULL_NAME_SI_KEY[0]];


//시를 구해내자.
$Sql					= "
							SELECT
									*
							FROM
									$upso2_si
							WHERE
									si		= '$Si_VALUE'
						";
$Result					= query($Sql);
$Data_si				= happy_mysql_fetch_array($Result);

// 2014-06-23 패치
$tmp_gu		= $_GET['gu'];
// 2014-06-23 패치 $_GET['gu'] > $tmp_gu 로 수정
//구를 구해내자
$Sql					= "
							SELECT
									*
							FROM
									$upso2_si_gu
							WHERE
									si		= '$Data_si[number]'
								AND
									gu		= '$tmp_gu'
						";
$Result					= query($Sql);
$Data_gu				= happy_mysql_fetch_array($Result);

$str	= "$Data_si[number]---cut---";			//시 선택하기 위해.

//구 선택상자 만들기 시작.
if(substr($Data_si[si], 0, 4) != '세종')
{
	// 이쯤에서 db 처리해주고....
	$sql = "select * from $upso2_si_gu where si = '$Data_si[number]' order by gu asc ";

	//echo $sql;
	$result = query($sql);
	$numb = mysql_num_rows($result);

	if (!$numb)
	{
		$numb		= '1';
		$etc_java	.= "<option value=''>$area2_title_text</option>\n";
	}
	else
	{
		$i = "1";
		$etc_java	.= "<option value=''>$area2_title_text</option>\n";


		while ($SI = happy_mysql_fetch_array($result))
		{
			$gu_selected		= "";
			if($Data_gu[number] == $SI[number])
			{
				$gu_selected		= "selected";
			}
			$etc_java			.= "<option value='$SI[number]' $gu_selected>$SI[gu]</option>\n";

			$i ++;
		}
		$numb = $numb + 1;
	}

	$javascript_onchange	= "onChange=\"happy_startRequest_road(this,'$trigger','road_gu','$target2','$size','2','$form')\"";
	if(substr($Data_si[si], 0, 4) == '세종')
	{
		$javascript_onchange	= '';
	}

	header("Content-Type: text/html; charset=utf-8");
	$str .=<<<END
road_gu$form---cut---<select name='road_gu' id='road_gu' $javascript_onchange style='$size_gu'>
$etc_java
</select>---cut---
END;
}
else
{
	$str .=<<<END
road_gu$form---cut---<select name='road_gu' id='road_gu' $javascript_onchange style='display:none; $size_gu'>
</select>---cut---
END;
	$_GET[dong] = "";
}



	//도로명 선택상자 만들기 시작.
	//$addr_tmp			= $Data_si[si]."|".$_GET[gu]."|".preg_replace("/[0-9]/","",$_GET[dong])."|".$_GET[addr2];
	/*
		도로명주소레이어
		.'&geonmul='.urlencode($_GET[geonmul])
	*/
	if($_GET['geonmul'] != '')
		$_GET['addr2']		= '';

	$addr_tmp			= urlencode(iconv("utf-8","euc-kr",$Data_si[si]))."|".urlencode(iconv("utf-8","euc-kr",$_GET[gu]))."|".urlencode(preg_replace("/\./","",iconv("utf-8","euc-kr",$_GET[dong])))."|".urlencode($_GET[addr2]);
	$get_url			= $zipcode_site . '/' . $zipcode_juso_file . '?addr=' . $addr_tmp.'&zipcode='.$_GET['zipcode'].'&geonmul='.urlencode(iconv("utf-8","euc-kr",$_GET[geonmul]));
	$url				= 'http://' . $get_url . '&site=' . $return_site_name . '&limit=999999' . $url_encoding;

	//$url .= "&test=ok";
	//echo $url; exit;
	switch($sock_connect_type)
	{
		case 'curl' :
			$contents			= curl_get_file_contents($url);
		break;
		case 'fsock' :
			$contents			= file_get_contents_fsockopen($url);
		break;
		case 'snoopy' :
			$contents			= snoopy_class($url);
		break;
		default :
			$contents			= file_get_contents_fsockopen($url);
		break;
	}

	//echo $contents; exit;

	if($contents == '')
	{
		exit;
	}
	else
	{
		$total_sejong		= getXMLValue($contents, '<TOTAL>', '</TOTAL>',1);
		$result_code_sejong	= getXMLValue($contents, '<RESULT_CODE>', '</RESULT_CODE>',1);

		if($total_sejong == 0 )
		{
			$RETURN_MSG	= "LIMIT_ZERO";
			// 도로명주소레이어
			$road_html	= '<tr><td>검색결과가 없습니다. [001]</td></tr>';
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
			/*
			$RETURN_MSG		= "SUCCESS";
			$DORO			= getXMLValue($contents, '<DORO>', '</DORO>',1);
			$GEONMUL1		= getXMLValue($contents, '<GEONMUL1>', '</GEONMUL1>',1);
			$GEONMUL2		= getXMLValue($contents, '<GEONMUL2>', '</GEONMUL2>',1);
			*/
			/*
				도로명주소레이어
				1000건 이상 검색되면 오류 메세지를 뿜어냄
			*/
			if($total_sejong > 1000)
			{
				$road_html		= '<tr><td>검색 범위가 너무 넓습니다. 주소를 올바르게 입력해주세요.</td></tr>';
			}
			else
			{
				$RETURN_MSG		= "SUCCESS";
				$tmp_explode	= explode("</HEADER>",$contents);
				$tmp_explode	= explode("</DATA>",str_replace("</ADDRESS>","",$tmp_explode[1]));
				$road_html	= '';
				foreach($tmp_explode AS $key => $val)
				{
					if(trim($val) == '') continue;

					$ZIPCODE	= getXMLValue($val, '<ZIPCODE>', '</ZIPCODE>',1);
					$SI			= getXMLValue($val, '<SI>', '</SI>',1);
					$GU			= getXMLValue($val, '<GU>', '</GU>',1);
					$RI			= getXMLValue($val, '<RI>', '</RI>',1);
					$DORO		= getXMLValue($val, '<DORO>', '</DORO>',1);
					$GEONMUL1	= getXMLValue($val, '<GEONMUL1>', '</GEONMUL1>',1);
					$GEONMUL2	= getXMLValue($val, '<GEONMUL2>', '</GEONMUL2>',1);
					$GEONMUL3	= getXMLValue($val, '<GEONMUL3>', '</GEONMUL3>',1);
					$GEONMUL4	= getXMLValue($val, '<GEONMUL4>', '</GEONMUL4>',1);
					$JIBEON1	= getXMLValue($val, '<JIBEON1>', '</JIBEON1>',1);
					$JIBEON2	= getXMLValue($val, '<JIBEON2>', '</JIBEON2>',1);

					//$DORO_VAL	= ($GEONMUL3 == '') ? $DORO : $DORO . '||' . $GEONMUL3;
					$GEONMUL3_VAL	= ($GEONMUL3 == '') ? '' : ' (' . $GEONMUL3 . ')';
					$GEONMUL1		= ($GEONMUL2 == '') ? $GEONMUL1 : $GEONMUL1 . '-' . $GEONMUL2;

					if(substr($SI, 0, 4) == '세종')
					{
						$road_html	.=	"
						<tr>
							<td><a href=\"javascript:void(0);\" onclick=\"goRoadSelected('$Data_si[number]','','$DORO','','$GEONMUL1');\">$SI $DORO $GEONMUL1</a></td>
						</tr>
						";
					}
					else
					{
						$road_html	.=	"
						<tr>
							<td><a href=\"javascript:void(0);\" onclick=\"goRoadSelected('$Data_si[number]','$Data_gu[number]','$DORO','','$GEONMUL1');\">$SI $GU $DORO {$GEONMUL1}{$GEONMUL3_VAL}</a></td>
						</tr>
						";
					}
				}
			}

			// 도로명주소레이어
			if($road_html == '')
				$road_html	= '<tr><td>검색결과가 없습니다. [002]</td></tr>';
		}

		//echo $DORO."___".$GEONMUL1; exit;
	}


	if(substr($Data_si[si], 0, 4) != '세종')
	{
		$get_url			= $zipcode_site . '/' . $zipcode_road_file . '?si=' . iconv("utf-8","euc-kr",$Data_si[si]) . '&gu=' . iconv("utf-8","euc-kr",str_replace(" ","_",$Data_gu[gu])) . '&dong=' . iconv("utf-8","euc-kr",$Data_gu[dong]);
	}
	else
	{
		$get_url			= $zipcode_site . '/' . $zipcode_road_file . '?si=' . iconv("utf-8","euc-kr",$Data_si[si]) . '&dong=' . iconv("utf-8","euc-kr",$Data_gu[gu]);		//세종시
	}

	$url				= 'http://' . $get_url . '&site=' . $return_site_name . $url_encoding;

	switch($sock_connect_type)
	{
		case 'curl' :
			$contents			= curl_get_file_contents($url);
		break;
		case 'fsock' :
			$contents			= file_get_contents_fsockopen($url);
		break;
		case 'snoopy' :
			$contents			= snoopy_class($url);
		break;
		default :
			$contents			= file_get_contents_fsockopen($url);
		break;
	}
	if($contents == '')
	{

		exit;
	}

	$contents_explode	= explode('||', $contents);

	$etc_java			= "<option value=''>도로명선택</option>\n";

	foreach($contents_explode AS $value)
	{
		$value_explode	= explode('@@', $value);

		$DORO_SELECTED = "";
		IF($DORO == $value_explode[0])
		{
			$DORO_SELECTED = "SELECTED";
		}

		//$etc_java		.= "<option value='$value_explode[0]' $DORO_SELECTED>$value_explode[0]</option>\n";
		// 도로명주소레이어
		$etc_java		.= "<option value='$value_explode[0]'>$value_explode[0]</option>\n";
	}

	$GEONMUL_VALUE = $GEONMUL1;
	IF($GEONMUL2 != '')
	{
		$GEONMUL_VALUE .= "-".$GEONMUL2;
	}

/*
	도로명주소레이어
	---cut---road_address_select---cut---<table cellspacing='0' cellpadding='0' border='0'><thead><tr><th align='left' style='padding-bottom:5px; color:#333; text-align:left;'>도로명 주소</th></tr></thead><tbody>$road_html</tbody></table>
	로 변경
*/

	header("Content-Type: text/html; charset=utf-8");
	$str .=<<<END
road_addr$form---cut---<select name='road_addr' id='road_addr' style="$size_addr">
$etc_java
</select>---cut---road_address_select---cut---<table cellspacing='0' cellpadding='0' border='0'><thead><tr><th align='left' style='padding-bottom:5px; color:#333; text-align:left;'>도로명 주소</th></tr></thead><tbody>$road_html</tbody></table>
END;


echo $str;
exit;
?>