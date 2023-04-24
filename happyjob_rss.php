<?
    include ("./inc/config.php");
    include ("./inc/Template.php");
    $t_start = array_sum(explode(' ', microtime()));
    $TPL = new Template;
    include ("./inc/function.php");
    include ("./inc/lib.php");

	//	예> $ex_cut = 30이면 30개의 글자까지만 출력 나머지는 ... 으로 출력!
    $ex_cut = "300";
	//	$limit는 화면에 출력되는 채용정보 갯수입니다.
	//	예> $limit = 10으로 설정하시면 10개의 업소만 출력 됩니다.   참고 : 출력되는 자료는 최근등록순 입니다.
	$limit = "20";

    $sql = "select * from $guin_tb order by guin_date desc limit $limit";
    $result = query($sql);

	//$test = str_replace("Ver1.4", "", $site_name);

    echo '<?xml version="1.0" encoding="utf-8" ?>';
?>
<rss version="2.0">
    <channel>
		<title><?=$site_name?></title>
		<link><?=$main_url?></link>
		<description><?=$site_name?></description>
		<language>ko</language>
		<lastBuildDate>Wed,28 Nov 2007 01:00:00 +0900</lastBuildDate>
		<webMaster><?=$admin_email?></webMaster>
		<image>
			<title><?=$site_name?></title>
			<link><?=$main_url?></link>
			<url><?=$main_url?>/img/logo.gif</url>
		</image>
<?
	while($data = happy_mysql_fetch_array($result)){
		#$data[review] DB 값에 php 코드 삽입된거 필터링!
		$review = str_replace("\r", "", $data[guin_main]);
		$pattern = array('/<!--(.*?)-->/s', '/<script[^>]*?>(.*?)<\/script>/is', '/<style[^>]*?>(.*?)<\/style>/is', '/<(.*?)>/s');
		$review = preg_replace($pattern, '', $review);
		$review = str_replace("\n", "", $review);
		$review = str_replace("\r\n", "", $review);

		$review = str_replace("&nbsp;", " ", $review);
		$review = str_replace("&sim;", " ", $review);
		$review = str_replace("&middot;", " ", $review);
		$review = str_replace("&lsquo;", " ", $review);
		$review = str_replace("&rsquo;", " ", $review);
		$review = str_replace("&rarr;", " ", $review);
		$review = str_replace("&ldquo;", " ", $review);
		$review = str_replace("&bull;", " ", $review);

		$review = strip_tags($review);
        $review = kstrcut($review, $ex_cut, " ...");

		$data[guin_date] = strip_tags($data[guin_date]);
		$tmp = explode("-",str_replace(":","-",str_replace(" ","-",$data[guin_date])));
		$data[guin_date] = happy_mktime($tmp[3],$tmp[4],$tmp[5],$tmp[1],$tmp[2],$tmp[0]);
		$data[guin_date] = date("D, j M Y H:i:s " , $data[guin_date]);

		$data[guin_title] = str_replace("&","&amp;",$data[guin_title]);

        if(trim($review) == '')
            $review = "";
?>
		<item>
			<title><?=$data[guin_title]?></title>
			<link><?=$main_url."/guin_detail.php?num=".$data[number]?></link>
			<author><?=$data[guin_com_name ]?></author>
			<description><?=$review?></description>
			<pubDate><?=$data[guin_date]?></pubDate>
			<category>11</category>
		</item>
<?
	}
?>
	</channel>
</rss>