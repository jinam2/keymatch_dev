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
		<List url=\"http://www.cgimall.co.kr/bbs_index.cgi\" target=\"_blank\" keyword=\"opt1 �������� ���� ���޵Ǿ����ϴ�\"/>
		<List url=\"http://www.cgimall.co.kr/bbs_index.cgi\" target=\"_blank\" keyword=\"{{ƼĿ���� �±װ� �ùٸ��� \"/>
		<List url=\"http://www.cgimall.co.kr/bbs_index.cgi\" target=\"_blank\" keyword=\"����Ǿ����� Ȯ���غ�����\"/>
		";
		$speed_time = '1500';
		$keycolor = 'FF394C';
	}
	else
	{
		#print_r2($_GET);
		#�÷��ÿ��� �Ѿ�� ���̶�� �Ϻη� ǥ������
		$_GET['opt8'] = $_GET['opt8']."_flash";
		$ticker_list = guin_main_extraction($_GET['opt1'],$_GET['opt2'],$_GET['opt3'],$_GET['opt4'],$_GET['opt5'],$_GET['opt6'],$_GET['opt7'],$_GET['opt8'],$_GET['opt9'],$_GET['opt10'],$_GET['opt11']);

		//echo $_GET['opt10'];



		if (!$ticker_list){
			$ticker_list = "<List url=\"\" target=\"_blank\" keyword=\"�ش� ä�������� �����ϴ�.\"/>";
		}

		$times	= 3000;
		//�տ� ���� ����ƼĿ�϶� �ӵ�
		//�ڿ����� �ؽ�Ʈ ƼĿ�϶� �ӵ�
		//�ӵ����� 3�� ����(3000m/s) ��������!!

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