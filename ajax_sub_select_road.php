<?php

$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/lib.php");


$trigger	= $_GET['trigger'];
$trigger2	= $_GET['trigger2'];
$target		= $_GET['target'];
$target2	= $_GET['target2'];
$form		= $_GET['form'];
$size		= $_GET['size'];
$size2		= $_GET['size2'];
$level		= $_GET['level'];

if ($size){
	$size_style = "width:{$size}px;";
}

if ($size2){
	$size2_style = "width:{$size2}px;";
}

//print_r2($_GET);

$type_inq	= $_GET['type_inq'];
if( $type_inq != '' )
{
	$road_arr				= array('road_si','road_gu','road_addr');
	$road_required			= array();
	//$road_required['si']	= "";
	$road_required['gu']	= "";
	$road_required['addr']	= "";
	$Sql	= "SELECT field_title,field_name,field_sureInput FROM $happy_inquiry_form WHERE gubun = '".base64_decode(str_replace("_p_","+",$type_inq))."'  AND field_name IN ('".implode("','",$road_arr)."') ORDER BY field_sort ASC";
	$rec	= query($Sql);
	while($inq = mysql_fetch_assoc($rec))
	{
		if( $inq['field_sureInput'] == 'y' )
		{
			if( $inq['field_name'] == $road_arr[0] )
			{
				//$road_required['si']	= " required ";
			}
			else if( $inq['field_name'] == $road_arr[1] )
			{
				$road_required['gu']	= " required hname=\"{$inq['field_title']}\"";
			}
			else if( $inq['field_name'] == $road_arr[2] )
			{
				$road_required['addr']	= " required hname=\"{$inq['field_title']}\"";
			}
		}
	}
}

$return_site_name	= $_SERVER['SERVER_NAME'];

$server_char	= strtolower($server_character);

$url_encoding		= '';
if($server_char != 'euckr' && $server_char != 'euc-kr')
{
	$url_encoding	= '&encoding=utf8';
}
# 구
if ($level == '1')
{
	$si_sql				= "SELECT si FROM $upso2_si WHERE number = '$trigger'";
	list($check_si)		= happy_mysql_fetch_array(query($si_sql));

	$target_JI			= 'road_addr2';
	$target_JI_value	= "<input type=\"text\" name=\"road_addr2\" value=\"\" class=\"sminput5\" />";
	$target_DONG		= "---cut---road_addrregiform---cut---<select name='road_addr'  style=\"$size2_style\"><option value=\"\">도로명선택</option></select>";

	if(substr($check_si, 0, 4) == '세종')
	{
		$get_url			= $zipcode_site . '/' . $zipcode_road_file . '?si=' . $check_si;
		$url				= 'http://' . $get_url . '&site=' . $_SERVER['SERVER_NAME'] . $url_encoding;

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

		# 세종시 때문에 추가
		$addr				= $_GET['addr'];
		$addr2				= $_GET['addr2'];
		if($addr2 != '')
		{
			$sql				= "SELECT gu FROM $upso2_si_gu WHERE number = '$addr'";
			list($addr)			= happy_mysql_fetch_array(query($sql));

			if($server_char != 'euckr' && $server_char != 'euc-kr')
			{
				$addr	= urlencode($addr);
				$addr2	= urlencode($addr2);
			}

			$addr_str		= $check_si . '|' . $addr . '|' . $addr2;

			$get_url_sejong	= $zipcode_site . '/' . $zipcode_juso_file . '?addr=' . $addr_str . '&start=0&limit=999999';
			$url_sejong		= 'http://' . $get_url_sejong . '&site=' . $_SERVER['SERVER_NAME'] . $url_encoding;

			switch($sock_connect_type)
			{
				case 'curl' :
					$contents_sejong	= curl_get_file_contents($url_sejong);
				break;
				case 'fsock' :
					$contents_sejong	= file_get_contents_fsockopen($url_sejong);
				break;
				case 'snoopy' :
					$contents_sejong	= snoopy_class($url_sejong);
				break;
				default :
					$contents_sejong	= file_get_contents_fsockopen($url_sejong);
				break;
			}

			$DORO				= '';
			if($contents_sejong != '')
			{
				$total_sejong			= getXMLValue($contents_sejong, '<TOTAL>', '</TOTAL>',1);
				$result_code_sejong		= getXMLValue($contents_sejong, '<RESULT_CODE>', '</RESULT_CODE>',1);

				if($result_code_sejong == '99' && $total_sejong == '1')
				{
					$DORO		= getXMLValue($contents_sejong, '<DORO>', '</DORO>',1);
					$GEONMUL1	= getXMLValue($contents_sejong, '<GEONMUL1>', '</GEONMUL1>',1);
					$GEONMUL2	= getXMLValue($contents_sejong, '<GEONMUL2>', '</GEONMUL2>',1);

					$GEONMUL12	= $GEONMUL1;
					if($GEONMUL2 != '')
					{
						$GEONMUL12	.= '-' . $GEONMUL2;
					}

					$target_JI			= 'road_addr2';
					$target_JI_value	= "<input type=\"text\" name=\"road_addr2\" value=\"$GEONMUL12\" class=\"sminput5\" />";
				}
			}
		}

		$contents_explode	= explode('||', $contents);

		$etc_java			= "<option value=''>$area4_title_text</option>\n";
		foreach($contents_explode AS $value)
		{
			$value_explode	= explode('@@', $value);
			$tmp_selected	= '';
			if($value_explode[0] == $DORO)
			{
				$tmp_selected	= 'selected';
			}
			$etc_java		.= "<option value='$value_explode[0]' $tmp_selected >$value_explode[0]</option>\n";
		}
		$sejong_select_display_none = "style='display:none;'";
	}
	else
	{
		// 이쯤에서 db 처리해주고....
		$sql = "select * from $upso2_si_gu where si = '$trigger' order by gu asc ";
		$result = query($sql);
		$numb = mysql_num_rows($result);
		if (!$numb)
		{
			$numb = '1';
			$etc_java .= "<option value=''>$area2_title_text</option>\n";
		}
		else
		{
			$i = "1";
			$etc_java .= "<option value=''>$area2_title_text</option>\n";

			while ($SI = happy_mysql_fetch_array($result)){
				$etc_java .= "<option value='$SI[number]'>$SI[gu]</option>\n";
				$i ++;
			}
			$numb = $numb + 1;
		}
	}

	$target_DONG		= "---cut---road_addr${form}---cut---<select name='road_addr' style='$size2_style'><option value=\"\">도로명선택</option></select>";

	$javascript_onchange	= "onChange=\"happy_startRequest_road(this,'$trigger','$target','$target2','$size','2','$form','$size2','$type_inq')\"";
	if(substr($check_si, 0, 4) == '세종')
	{
		$javascript_onchange	= '';
		$target_DONG		= "---cut---road_gu${form}---cut---<select name='road_gu' $sejong_select_display_none style='$size2_style'><option value=\"\">도로명선택</option></select>";
		$target					= "road_addr";
	}
	header("Content-Type: text/html; charset=utf-8");
	print <<<END
	$target$form---cut---<select name='$target' id='$target' $javascript_onchange style="$size_style" $road_required[gu]>
	$etc_java
	</select>---cut---$target_JI---cut---$target_JI_value$target_DONG
END;
}
else if($level == '2')			# 동
{
	if($trigger == '' || $trigger2 == '')
	{
		exit;
	}

	$sql				= "SELECT si FROM $upso2_si WHERE number = '$trigger2'";
	list($si)			= happy_mysql_fetch_array(query($sql));

	$sql				= "SELECT gu FROM $upso2_si_gu WHERE number = '$trigger'";
	list($gu)			= happy_mysql_fetch_array(query($sql));

	$gu					= str_replace(" ","_",$gu);

	$si					= iconv("utf-8","euc-kr",$si);
	$gu					= iconv("utf-8","euc-kr",$gu);

	$get_url			= $zipcode_site . '/' . $zipcode_road_file . '?si=' . $si . '&gu=' . $gu;
	$url				= 'http://' . $get_url . '&site=' . $return_site_name . $url_encoding;

	//echo $url;
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
		$etc_java		.= "<option value='$value_explode[0]'>$value_explode[0]</option>\n";
	}

	header("Content-Type: text/html; charset=utf-8");
	print <<<END
	$target2$form---cut---<select name='$target2' id='$target2' style="$size2_style" $road_required[addr]>
	$etc_java
	</select>---cut---boodong_img_div---cut---<select name='boodong_img' style='width:150px;'>$etc_java2</select>---cut---boodong_img_div2---cut---$boodong_img_value
END;
}

# 해당 동의 도로명 주소를 가져와서 selectbox 를 생성
else if($level == '3')
{
	if($trigger == '' || $trigger2 == '')
	{
		exit;
	}

	$sql		= "SELECT si FROM $upso2_si WHERE number = '$trigger2'";
	list($si)	= happy_mysql_fetch_array(query($sql));

	$sql		= "SELECT gu FROM $upso2_si_gu WHERE number = '$trigger'";
	list($gu)	= happy_mysql_fetch_array(query($sql));

	## utf8
	if($server_char != 'euckr' && $server_char != 'euc-kr')
	{
		$si				= urlencode(iconv2($si));
		$gu				= urlencode(iconv2($gu));
	}
	else
	{
		$si				= urlencode($si);
		$gu				= urlencode($gu);
	}
	## utf8

	$addr				= $_GET['addr'];
	$addr2				= trim($_GET['addr2']);

	$tmp_gu				= '';
	if(strpos($addr, ' ') !== false)
	{
		$addr_explode	= explode(' ', $addr);
		$tmp_gu			= $addr_explode[0];
		$addr			= $addr_explode[1];
	}

	$target_JI			= 'road_addr2';
	$target_JI_value	= "<input type=\"text\" name=\"road_addr2\" value=\"\" class=\"sminput5\" />";
	if($addr2 != '')
	{
		if($server_char != 'utf8' && $server_char != 'utf-8')
		{
			$addr		= urlencode(iconv2($addr));
			$addr2		= urlencode(iconv2($addr2));
			if($tmp_gu != '')
			{
				$tmp_gu	= '|' . urlencode(iconv2($tmp_gu));
			}
		}

		$addr_str	= $si . '|' . $gu . $tmp_gu . '|' . $addr . '|' . $addr2;

		$get_url	= $zipcode_site . '/' . $zipcode_juso_file . '?addr=' . $addr_str . '&start=0&limit=999999';
		$url		= 'http://' . $get_url . '&site=' . $return_site_name . $url_encoding;
		#echo $url;

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

		$DORO				= '';
		if($contents != '')
		{
			$data			= getXMLValue($contents, '<DATA>', '</DATA>');
			$total			= getXMLValue($contents, '<TOTAL>', '</TOTAL>',1);
			$result_code	= getXMLValue($contents, '<RESULT_CODE>', '</RESULT_CODE>',1);

			if($result_code == '99' && $total >= 1)
			{
				$DORO				= getXMLValue($contents, '<DORO>', '</DORO>',1);
				$GEONMUL1			= getXMLValue($contents, '<GEONMUL1>', '</GEONMUL1>',1);
				$GEONMUL2			= getXMLValue($contents_sejong, '<GEONMUL2>', '</GEONMUL2>',1);

				$GEONMUL12	= $GEONMUL1;
				if($GEONMUL2 != '')
				{
					$GEONMUL12	.= '-' . $GEONMUL2;
				}

				$GEONMUL4			= getXMLValue($contents, '<GEONMUL4>', '</GEONMUL4>',1);

				$target_JI			= 'road_addr2';
				$target_JI_value	= "<input type=\"text\" name=\"road_addr2\" value=\"$GEONMUL12 $GEONMUL4\" class=\"sminput5\" />";
			}
		}
	}

	$get_url			= $zipcode_site . '/' . $zipcode_road_file . '?si=' . $si . '&gu=' . $gu;
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
		$tmp_selected		= '';
		if($value_explode[0] == $DORO)
		{
			$tmp_selected	= 'selected';
		}
		$etc_java		.= "<option value='$value_explode[0]' $tmp_selected>$value_explode[0]</option>\n";
	}

	header("Content-Type: text/html; charset=utf-8");
	print <<<END
	$target2$form---cut---<select name='$target2' id='$target2' style="$size_style">
	$etc_java
	</select>---cut---$target_JI---cut---$target_JI_value
END;
}

# 도로명 주소로 동을 찾을때
else if($level == '4')
{
	if($trigger == '' || $trigger2 == '')
	{
		exit;
	}

	$addr			= $_GET['addr'];
	$addr2			= trim($_GET['addr2']);


	$sql			= "SELECT si FROM $upso2_si WHERE number = '$trigger2'";
	list($si)		= happy_mysql_fetch_array(query($sql));

	if(substr($si, 0, 4) != '세종')
	{
		$sql		= "SELECT gu FROM $upso2_si_gu WHERE number = '$trigger'";
		list($gu)	= happy_mysql_fetch_array(query($sql));
	}
	else
	{
		$gu			= $trigger;
		$addr		= '';
	}

	## utf8
	if($server_char != 'euckr' && $server_char != 'euc-kr')
	{
		$si_encode		= urlencode(iconv2($si));
		$gu_encode		= urlencode(iconv2($gu));
	}
	else
	{
		$si_encode		= urlencode($si);
		$gu_encode		= urlencode($gu);
	}
	## utf8

	## 동을 찾아 온다.
	$target_JI			= 'addr2';
	$target_JI_value	= "<input type=\"text\" name=\"addr2\" value=\"\" />";
	if($addr2 != '')
	{
		if($server_char != 'utf8' && $server_char != 'utf-8')
		{
			$addr		= urlencode(iconv2($addr));
			$addr2		= urlencode(iconv2($addr2));
			if($tmp_gu != '')
			{
				$tmp_gu	= '|' . urlencode(iconv2($tmp_gu));
			}
		}

		$addr2_get_url	= $zipcode_site . '/' . $zipcode_road_file . '?si=' . $si_encode . '&gu=' . $gu_encode . '&addr=' . $addr . '&addr2=' . $addr2;
		$addr2_url		= 'http://' . $addr2_get_url . '&site=' . $return_site_name . $url_encoding;
		#echo $addr2_url;

		switch($sock_connect_type)
		{
			case 'curl' :
				$addr2_contents			= curl_get_file_contents($addr2_url);
			break;
			case 'fsock' :
				$addr2_contents			= file_get_contents_fsockopen($addr2_url);
			break;
			case 'snoopy' :
				$addr2_contents			= snoopy_class($addr2_url);
			break;
			default :
				$addr2_contents			= file_get_contents_fsockopen($addr2_url);
			break;
		}

		if($addr2_contents == '')
		{
			//exit;
		}

		$addr2_contents_explode		= explode('||', $addr2_contents);
		$addr2_contents_explode_sub	= explode('@@', $addr2_contents_explode[0]);

		$target_JI			= 'addr2';
		$target_JI_value	= "<input type=\"text\" name=\"addr2\" value=\"$addr2_contents_explode_sub[1]\" />";

		$tmp_dong			= $addr2_contents_explode_sub[0];
	}

	## 콤보박스를 만들고 찾은 동과 동일한 동이 있다면 선택.
	if(substr($si, 0, 4) != '세종')
	{
		$sql	= "SELECT * FROM $upso2_si_gu_dong WHERE gu_number = '$trigger' ";
		$result	= query($sql);
		$DONG	= happy_mysql_fetch_array($result);
		if (!$DONG[dong_title])
		{
			$numb		= '1';
			$etc_java	.= "<option value=''>$area3_title_text</option>\n";
		}
		else
		{
			$i			= "1";
			$etc_java	.= "<option value=''>$area3_title_text</option>\n";
			$DONG_INFO	= explode("\n",$DONG[dong_title]);

			foreach($DONG_INFO as $list)
			{
				$list	= str_replace("\r", '', $list);
				$list	= str_replace("\n", '', $list);
				if($list)
				{
					$tmp_selected		= '';
					if($list == $tmp_dong)
					{
						$tmp_selected	= 'selected';
					}
					$etc_java .= "<option value='$list' $tmp_selected >$list</option>\n";
				}
				$i ++;
			}
			$numb = $numb + 1;
		}
	}
	else
	{
		$target2	= 'gu';
		$etc_java	.= "<option value=''>$area2_title_text</option>\n";

		$sql		= "SELECT * FROM $upso2_si_gu WHERE si = '$trigger2' ORDER BY gu ASC ";
		$result		= query($sql);
		while($data = happy_mysql_fetch_array($result))
		{
			$tmp_selected		= '';
			if($data['gu'] == $tmp_dong)
			{
				$tmp_selected	= 'selected';
			}
			$etc_java .= "<option value='$data[number]' $tmp_selected >$data[gu]</option>\n";
		}
	}

	header("Content-Type: text/html; charset=utf-8");
	print <<<END
	$target2$form---cut---<select name='$target2' id='$target2' style="$size_style">
	$etc_java
	</select>---cut---$target_JI---cut---$target_JI_value
END;
}

?>