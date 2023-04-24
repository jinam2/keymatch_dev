<?

######################################################################
# 메인상단 날씨 swf 설정파일
######################################################################


	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/config.php");
	include ("./inc/function.php");
	query("set names euckr");

	$upso2_weather_info = $auction_weather_info;


#update 시 아래 코드끝까지만 교정하세요. NeoHero
#아래 체크해제시 항상 서울만 출력됨.
#setcookie("g_city","",happy_mktime() - 3600,"/","$cookie_url");



	//쿠키의 지역을 안쓰고 플래시에서 넘어오는 지역을 강제로사용함
	//use_get 이란 값을 추가시킴 2010-07-02 kad
	$Tcity = $google_weather_area;

	if ( $_COOKIE['g_city'] != '' )
	{
		$Tcity = $_COOKIE['g_city'];
	}
	else {
		$Tcity = 'Seoul';
	}

	/* 원본내용
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
	# 우선 DB에서 기존 자료가 있는지 보자.
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

	#날씨 테이블이 없는 경우 만들어주자.
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

	#정상 자료가 있니?
	if ($WEA[number] && $WEA[xml_info] ){
		#print $WEA[xml_info];
		$w_info = kma2google("$WEA[xml_info]","$Tcity");
		print "$w_info <hr>";
	}
	else {
		$get_weather_info =  get_url_fsockopen("http://www.kma.go.kr/XML/weather/sfc_web_map.xml");
	    $get_weather_info = iconv("utf-8","euc-kr" , $get_weather_info);
		$get_weather_info	= str_replace("대구(기)","대구",$get_weather_info);		//패치함.	2013-11-06	hun

		#구글에서 에러를 보내는 경우는 담지 말자.
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
	$W_icon	= Array('맑음'=>'sunny.png', '흐림'=>'cloudy.png', '구름많음'=>'haze.png', '구름조금'=>'cloudy.png', '비'=>'mist.png' ,'구름많고 비'=>'flurries.png' ,'대부분맑음'=>'mostly_sunny.png','눈'=>'snow.png','폭설'=>'snow.png',
	'황사'=>'sand.png','모래'=>'sand.png'	,'박무'=>'mist.png','구름많고 눈'=>'snow.png','구름많고 비 또는 눈'=>'snow.png'
	);
	$W_area	= Array('Seoul'=>'서울', 'Incheon'=>'인천', 'Daejeon'=>'대전', 'Daegu'=>'대구' , 'Gwangju'=>'광주' , 'Ulsan'=>'울산' , 'Busan'=>'부산' , 'Jeju'=>'제주' , 'Gangneung-si'=>'강릉' , 'Gyeongju'=>'경주시' , 'Goyang-si'=>'서울' , 'Gwangmyeong-si'=>'인천'
	, 'Gumi'=>'구미', 'Gunsan'=>'군산', 'Gunpo-si'=>'군포'  , 'Gimhae'=>'창원', 'Donghae-si'=>'동해' , 'Mokpo'=>'목포' , 'Bucheon'=>'인천' , 'Seogwipo'=>'서귀포' ,  'Seongnam-si'=>'서울' , 'Suwon'=>'수원' , 'Siheung-si'=>'인천' , 'Ansan'=>'인천'
	, 'Anyang'=>'인천' , 'Yongin'=>'서울' , 'Wonju'=>'원주' , 'Uijeongbu-si'=>'서울' , 'Iksan'=>'군산'
	, 'Jeonju'=>'전주' , 'Jinju'=>'진주' , 'Changwon'=>'창원' , 'Cheongju'=>'청주' , 'Chuncheon'=>'춘천' , 'Paju'=>'서울' , 'Pyeongtaek'=>'수원' , 'Pohang'=>'포항'
	);
	$city_match = $W_area[$city];
	if (!$city_match){		$city_match = '서울';	}

	preg_match("/<local stn_id=\"(.*?)\" icon=\"(.*?)\" desc=\"(.*?)\" ta=\"(.*?)\">$city_match<\/local>/",$xml,$matches);
	$wt = $matches[3];
	$weather_icon = $W_icon[$wt];
	if (!$weather_icon){ $weather_icon = 'mostly_sunny.png';	}

#		print_r2($matches);
#		print "<hr>$W_icon[맑음]";
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
	<humidity data="습도: 66%"/>
	<icon data="/ig/images/weather/$weather_icon"/>
	<wind_condition data=""/>
	</current_conditions>
	</weather>
	</xml_api_reply>
END;

}




?>