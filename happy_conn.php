<?php
$t_start = array_sum(explode(' ', microtime()));

$DB_Prefix = "";

include ("./inc/config.php");
include("./inc/config_server.php"); //서버세팅 관련 소스
include("./inc/happy_config_maker.php"); //happy_config 생성
include ("./inc/Template.php");
$TPL = new Template;
include ('inc/key.php');
include("inc/happy.php");
include("inc/define_attack_check.php");

$skin_folder		= "temp";
$skin_folder_file	= "html_file";

$happy_member = $DB_Prefix.'happy_member';

include ("./inc/function_connect.php");

	$TemplateM_name	= Array(
							'접속자리스트',
	);

	$TemplateM_func	= Array(
							'echo call_connection'
	);

//include ("./inc/function.php");
//include ("./inc/lib.php");

#가로세로정리
if ( !function_exists("table_adjust") )
{
	function table_adjust($main_new,$ex_width,$i)
	{
		$main_new_out = "";

		#TD를 정리하자
		if ($ex_width == "1")
		{
			$main_new = "<tr><td>".$main_new."</td></tr>";
		}
		elseif ($i % $ex_width == "1")
		{
			$main_new = "<tr><td>".$main_new."</td>";
		}
		elseif ($i % $ex_width == "0")
		{
			$main_new = "<td>".$main_new."</td></tr>";
		}
		else
		{
			$main_new = "<td>".$main_new."</td>";
		}
		$main_new_out .= $main_new;

		return $main_new_out;
	}
}


$_GET['ex_width'] = preg_replace('/\D/', '', $_GET['ex_width']);

$내용 = connection_list($_GET['ex_width'],$_GET['ex_template'],$_GET['ex_type']);
//echo $내용;
$TPL->define("출력", "$skin_folder/default_connect.html");
$TPL->tprint();

?>