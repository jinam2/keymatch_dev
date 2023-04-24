<?
include ("./inc/config.php");
include ("./inc/Template.php");
$t_start = array_sum(explode(' ', microtime()));
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");
?>

<HTML>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<TITLE>우편번호 찾기</TITLE>
	<link rel="stylesheet" type="text/css" href="css/style_common.css">

	<script language='javascript'>
	function addr_use()
	{
		getpost		= document.zipform.getpost.options[document.zipform.getpost.selectedIndex].value;
		getaddr2	= document.zipform.getaddr2.value;

		if ( getpost == '' )
		{
			alert('지역을 선택 해주세요.');
			document.zipform.getpost.focus();
			return false;
		}

		if ( getaddr2 == '' )
		{
			alert('상세주소를 입력해주세요.');
			document.zipform.getaddr2.focus();
			return false;
		}

		posts	= getpost.split("||");

		zip		= posts[0];
		addr1	= posts[1]+' '+ posts[2];

		post_name	= document.zipform.post.value;
		addr1_name	= document.zipform.addr1.value;
		addr2_name	= document.zipform.addr2.value;

		//opener.document.getElementById(post_name).value		= zip;
		ycnt = opener.document.getElementsByName(post_name).length
		for (i=0;i<ycnt ;i++ )
		{
			opener.document.getElementsByName(post_name)[i].value		= zip;
		}
/*
		opener.document.getElementById(addr1_name).value	= addr1;
		opener.document.getElementById(addr2_name).value	= getaddr2;
		opener.document.getElementById(addr2_name).focus();
*/
		opener.document.getElementsByName(addr1_name)[0].value	= addr1;
		opener.document.getElementsByName(addr2_name)[0].value	= getaddr2;
		opener.document.getElementsByName(addr2_name)[0].focus();

		self.close();

	}


	function change_post()
	{
		getpost	= document.zipform.getpost.options[document.zipform.getpost.selectedIndex].value;

		if ( getpost == '' )
		{
			document.getElementById('getaddr2_layer').style.display = 'none';
		}
		else
		{
			document.getElementById('getaddr2_layer').style.display = '';
		}
	}
	</script>

</HEAD>

<body style='background-color:#e9e9e9;'>

<FORM action=<?=$PHP_SELF?> method='get' name='zipform' >
<input type='hidden' name='mode' value='search'>
<input type='hidden' name='post' value='<?=$_GET[post]?>'>
<input type='hidden' name='addr1' value='<?=$_GET[addr1]?>'>
<input type='hidden' name='addr2' value='<?=$_GET[addr2]?>'>

<table cellspacing='0' style='width:100%; '>
<tr>
	<td style='height:50px;'>
		<table cellspacing='0' style='width:100%; border-bottom:2px solid #b8b8b8;'>
		<tr>
			<td style='height:50px; background-color:#5c5c5c; border-bottom:1px solid #494949;'><img src='img/title_zipcode.gif' style='margin-left:10px;'></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td align='center' style='padding-top:40px; ' valign="top">
		<table cellspacing='0' style='width:350px; margin-bottom:20px;'>
		<tr>
			<td style='padding-bottom:10px;'><font class='smfont4'>동,읍,면을 입력하여 주십시오.</font> <font class='smfont3' style='color:#aeaeae;'>예) 화곡동,송현동</font></td>
		</tr>
		<tr>
			<td><INPUT maxLength='16' name='gu' value='<?=$_GET[gu]?>' style='border:1px solid #b9b9b9; background-color:#f9f9f9; height:31px; line-height:31px; padding-left:5px; width:260px;'></td>
			<td><input type='image' src='img/btn_zipcode_search.gif' alt='검색'  border='0'></td>
		</tr>
		</table>
	</td>
</tr>
</table>


<?
	if ( $mode == "" )
	{
		echo "

			<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-top:96px;'>
			<tr>
				<td style='background-color:#5c5c5c; height:35px;' align='center'><FONT  COLOR='#a5a5a5' class='smfont2'>$site_name</FONT></td>
			</tr>
			</table>
			</FORM>
		";
	}

	if ( $mode == "search" )
	{
		if ( $_GET[gu] == "" )
		{
			error("동/읍/면을 입력하세요");
			exit;
		}

		$return_site_name		= $_SERVER['SERVER_NAME'];

		// utf8
		$keyword_gu			= $_GET['gu'];
		if(str_replace('-','',$server_character) == 'utf8')
		{
			$url_encoding	= '&encoding=utf8';
			$keyword_gu		= urlencode(iconv('utf-8','euc-kr',$_GET['gu']));
		}

		$get_url			= $zipcode_site . '/' . $zipcode_return_file . '?keyword='.$keyword_gu;
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

		#echo $contents; exit;

		if($contents == '')
		{
			exit;
		}

		$data			= getXMLValue($contents, '<DATA>', '</DATA>');
		$zip_code		= getXMLValue($contents, '<ZIP>', '</ZIP>');
		$si_name		= getXMLValue($contents, '<SI>', '</SI>');
		$gu_name		= getXMLValue($contents, '<GU>', '</GU>');
		$dong_name		= getXMLValue($contents, '<DONG>', '</DONG>');
		$bun_string		= getXMLValue($contents, '<BUN>', '</BUN>');
		/*
			도로명주소레이어
			아래 소스중 $bun2_string[$key] 추가
		*/
		$bun2_string	= getXMLValue($contents, '<BUN2>', '</BUN2>');
		$result_code	= getXMLValue($contents, '<RESULT_CODE>', '</RESULT_CODE>',1);
		$total			= getXMLValue($contents, '<TOTAL>', '</TOTAL>',1);

		if($result_code == '99' && $total >= 1)
		{
			if(preg_match("/세종특별/",$si_name[0]))
			{
				foreach($data as $key => $value)
				{
					$Zip_options	.= "<option value='$zip_code[$key]||$si_name[$key]||$dong_name[$key]'>($zip_code[$key]) $bun_string[$key]</option>";
				}
			}
			else
			{
				foreach($data as $key => $value)
				{
					$Zip_options	.= "<option value='$zip_code[$key]||$si_name[$key]||$gu_name[$key] $dong_name[$key]'>($zip_code[$key]) $bun_string[$key]</option>";
				}
			}
		}

		echo "
		<div style='width:100%; border-top:1px solid #dbdbdb;'>
			<table border=0 cellspacing=0 cellpadding=0 style='margin-left:15px;'>
			<tr>
				<td style='padding-top:20px;'>
					<select name='getpost' onChange='change_post()' style='width:370px;'>
						<option value=''>지역을 선택 해주세요.</option>
						$Zip_options
					</select>
				</td>
			</tr>
			<tr id='getaddr2_layer' style='display:none; padding-top:5px;''>
				<td>
					<table cellspacing='0' style='margin-top:5px;'>
					<tr>
						<td ><input type='text' name='getaddr2' style='border:1px solid #7d7d7d; width:250px; height:21px; line-height:21px; padding-left:2px;'></td>
						<td><img src='img/btn_addr2_reg.gif' align='absmiddle' style='cursor:pointer; margin-left:5px;'' value='입력' onClick=\"addr_use();\" class='btn_entry'></td>
					</tr>
					<tr>
						<td colspan='2' class='smfont3' style='padding-top:5px;'>상세주소를 입력해주세요.</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
			</div>
		";

	}



?>

</BODY>
</HTML>
