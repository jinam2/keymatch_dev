<?

######################################################################
# ���λ�� ���� swf ��������
######################################################################


	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/config.php");
	include ("./inc/function.php");
	query("set names euckr");

	$upso2_weather_info = $auction_weather_info;


#update �� �Ʒ� �ڵ峡������ �����ϼ���. NeoHero
#�Ʒ� üũ������ �׻� ���︸ ��µ�.
#setcookie("g_city","",happy_mktime() - 3600,"/","$cookie_url");



	//��Ű�� ������ �Ⱦ��� �÷��ÿ��� �Ѿ���� ������ �����λ����
	//use_get �̶� ���� �߰���Ŵ 2010-07-02 kad
	$Tcity = $google_weather_area;

	if ( $_COOKIE['g_city'] != '' )
	{
		$Tcity = $_COOKIE['g_city'];
	}
	else {
		$Tcity = 'Seoul';
	}

	/* ��������
	if ( $_GET['use_get'] == "yes" )
	{
		$Tcity = $_GET['city'];
	}
	else
	{
		if ( $_COOKIE['g_city'] != '' )
		{
			$Tcity = $_COOKIE['g_city'];
		}
		else
		{
			$Tcity = $_GET['city'];

			if ( $_GET['city'] == '' )
			{
				$Tcity = $google_weather_area;
			}
		}
	}
	*/

	$now_hour = date("H");
	# �켱 DB���� ���� �ڷᰡ �ִ��� ����.
	$sql					= "
								SELECT
										*
								FROM
										$upso2_weather_info
								WHERE
										city		= '$now_hour'
										AND
										xml_date	= curdate()
	";
	$result = query($sql);

	#���� ���̺��� ���� ��� ���������.
	if (!$result){
		$sql33 = "
		CREATE TABLE `$upso2_weather_info` (
		  `number` int(10) NOT NULL auto_increment,
		  `city` varchar(100) NOT NULL default '',
		  `xml_info` text NOT NULL,
		  `xml_date` date NOT NULL default '0000-00-00',
		  PRIMARY KEY  (`number`),
		  KEY `city_2` (`city`),
		  KEY `xml_date` (`xml_date`)
		)
		";
		$result33 = query($sql33);
		exit;
	}

	$WEA = happy_mysql_fetch_array($result);

	#���� �ڷᰡ �ִ�?
	if ($WEA[number] && $WEA[xml_info] ){
		#print $WEA[xml_info];
		$w_info = kma2google("$WEA[xml_info]","$Tcity");
		print "$w_info <hr>";
	}
	else {
		$get_weather_info =  get_url_fsockopen("http://www.kma.go.kr/XML/weather/sfc_web_map.xml");
	    $get_weather_info = iconv("utf-8","euc-kr" , $get_weather_info);
		$get_weather_info	= str_replace("�뱸(��)","�뱸",$get_weather_info);		//��ġ��.	2013-11-06	hun

		#���ۿ��� ������ ������ ���� ���� ����.
		if (preg_match("/^<\?xml/",$get_weather_info,$mat)){
			$sql = "insert into $upso2_weather_info set city = '$now_hour'  , xml_info = '$get_weather_info' , xml_date = curdate()   ";
			$result = query($sql);
		}
		$w_info = kma2google("$get_weather_info","$Tcity");
		print "$w_info <hr>";


	}
	exit;


function get_url_fsockopen( $url ) {
	$URL_parsed = parse_url($url);

	$host = $URL_parsed["host"];
	$port = $URL_parsed["port"];
	if ($port==0)
		$port = 80;

	$path = $URL_parsed["path"];
	if ($URL_parsed["query"] != "")
		$path .= "?".$URL_parsed["query"];

	$out = "GET $path HTTP/1.0\r\nHost: $host\r\n\r\n";

	$fp = fsockopen($host, $port, $errno, $errstr, 30);
	if (!$fp) {
	 echo "$errstr ($errno)<br>\n";
	} else {
		fputs($fp, $out);
		$body = false;
		while (!feof($fp)) {
			$s = fgets($fp, 128);
			if ( $body )
				$in .= $s;
			if ( $s == "\r\n" )
				$body = true;
		}

		fclose($fp);
		return $in;
	}
}

function kma2google($xml,$city){
	global $WEA;
	$W_icon	= Array('����'=>'sunny.png', '�帲'=>'cloudy.png', '��������'=>'haze.png', '��������'=>'cloudy.png', '��'=>'mist.png' ,'�������� ��'=>'flurries.png' ,'��κи���'=>'mostly_sunny.png','��'=>'snow.png','����'=>'snow.png',
	'Ȳ��'=>'sand.png','��'=>'sand.png'	,'�ڹ�'=>'mist.png','�������� ��'=>'snow.png','�������� �� �Ǵ� ��'=>'snow.png'
	);
	$W_area	= Array('Seoul'=>'����', 'Incheon'=>'��õ', 'Daejeon'=>'����', 'Daegu'=>'�뱸' , 'Gwangju'=>'����' , 'Ulsan'=>'���' , 'Busan'=>'�λ�' , 'Jeju'=>'����' , 'Gangneung-si'=>'����' , 'Gyeongju'=>'���ֽ�' , 'Goyang-si'=>'����' , 'Gwangmyeong-si'=>'��õ'
	, 'Gumi'=>'����', 'Gunsan'=>'����', 'Gunpo-si'=>'����'  , 'Gimhae'=>'â��', 'Donghae-si'=>'����' , 'Mokpo'=>'����' , 'Bucheon'=>'��õ' , 'Seogwipo'=>'������' ,  'Seongnam-si'=>'����' , 'Suwon'=>'����' , 'Siheung-si'=>'��õ' , 'Ansan'=>'��õ'
	, 'Anyang'=>'��õ' , 'Yongin'=>'����' , 'Wonju'=>'����' , 'Uijeongbu-si'=>'����' , 'Iksan'=>'����'
	, 'Jeonju'=>'����' , 'Jinju'=>'����' , 'Changwon'=>'â��' , 'Cheongju'=>'û��' , 'Chuncheon'=>'��õ' , 'Paju'=>'����' , 'Pyeongtaek'=>'����' , 'Pohang'=>'����'
	);
	$city_match = $W_area[$city];
	if (!$city_match){		$city_match = '����';	}

	preg_match("/<local stn_id=\"(.*?)\" icon=\"(.*?)\" desc=\"(.*?)\" ta=\"(.*?)\">$city_match<\/local>/",$xml,$matches);
	$wt = $matches[3];
	$weather_icon = $W_icon[$wt];
	if (!$weather_icon){ $weather_icon = 'mostly_sunny.png';	}

#		print_r2($matches);
#		print "<hr>$W_icon[����]";
#		exit;

	return <<<END
	<?xml version="1.0"?>
	<xml_api_reply version="1">
	<weather module_id="0" tab_id="0" mobile_row="0" mobile_zipped="1" row="0" section="0" >
	<forecast_information>
	<city data="$city"/>
	<postal_code data="$city"/>
	</forecast_information>
	<current_conditions>
	<condition data="$matches[3]"/>
	<temp_f data="0"/>
	<temp_c data="$matches[4]"/>
	<humidity data="����: 66%"/>
	<icon data="/ig/images/weather/$weather_icon"/>
	<wind_condition data=""/>
	</current_conditions>
	</weather>
	</xml_api_reply>
END;

}




?>