<?php

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template();
	include ("./inc/lib.php");


	#query("set names utf8");

	if ($_GET[opt1] == '')
	{
		$ticker_list = "
		<List url=\"http://www.cgimall.co.kr/bbs_index.cgi\" target=\"_blank\" keyword=\"opt1 변수값에 빈값이 전달되었습니다\"/>
		<List url=\"http://www.cgimall.co.kr/bbs_index.cgi\" target=\"_blank\" keyword=\"{{티커뉴스 태그가 올바르게 \"/>
		<List url=\"http://www.cgimall.co.kr/bbs_index.cgi\" target=\"_blank\" keyword=\"적용되었는지 확인해보세요\"/>
		";
		$speed_time = '1500';
		$keycolor = 'FF394C';
	}
	else
	{
		#print_r2($_GET);
		#플래시에서 넘어가는 것이라고 일부러 표시해줌
		$_GET['opt8'] = $_GET['opt8']."_flash";
		$ticker_list = guin_main_extraction($_GET['opt1'],$_GET['opt2'],$_GET['opt3'],$_GET['opt4'],$_GET['opt5'],$_GET['opt6'],$_GET['opt7'],$_GET['opt8'],$_GET['opt9'],$_GET['opt10'],$_GET['opt11']);

		//echo $_GET['opt10'];



		if (!$ticker_list){
			$ticker_list = "<List url=\"\" target=\"_blank\" keyword=\"해당 채용정보가 없습니다.\"/>";
		}

		$times	= 3000;
		//앞에 값이 포토티커일때 속도
		//뒤에값이 텍스트 티커일때 속도
		//속도값은 3초 이하(3000m/s) 설정금지!!

		$speed_time = $times;
		$keycolor = '#666666';
		trim($ticker_list);
	}

print <<<END
<?xml version="1.0" encoding="EUC-KR"?>
<xmlstart>

<banner>
$ticker_list
</banner>

<speed speed="$speed_time"/>
<color keycolor="$keycolor"/>

</xmlstart>

END;

?>