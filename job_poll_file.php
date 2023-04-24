<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");
$몰주소			= $main_url;


$현재위치	= " $prev_stand >  ";


$file		= $_GET["file"];
$tmp		= explode(".",$file);
$file_ext	= $tmp[sizeof($tmp)-1];
$file		= str_replace($file_ext,"",$file);
$file		= preg_replace("/\W/","",$file) .".". $file_ext;

#####투표 업데이트#####
for ( $Xi=0, $max=sizeof($_POST['number']) ; $Xi < $max ; $Xi++ )
{

	$number	= $_POST['number'][$Xi];

	#echo $number."/".$_POST["check_vote"];exit;

	$sort = $_POST["check_vote_".$number];

	$sql4 = "select * from $upso2_poll_1 where number = '$number'";
	$result4 = query($sql4);
	$Data = happy_mysql_fetch_array($result4);

	$graph_width = $Data["graph_width"];



	$sql6 = "select title,vote,last_ip from $upso2_poll_2 where poll_1_number = '$number' order by sort asc";
	$result6 = query($sql6);


	$last_ip = array();
	$i = 0;
	while ($Data6 = happy_mysql_fetch_array($result6) )
	{
		$last_ip[$i] = $Data6["last_ip"];
		$i++;
	}


	//투표 업데이트
	/*
	if ($sort != "" && $_POST["votetype"] == "up_vote") {
		$user_ip = getenv("REMOTE_ADDR");
		#중복투표가 아니면 업데이트 실행하자 .
		if ( ($last_ip[0] != $user_ip && $last_ip[1] != $user_ip && $last_ip[2] != $user_ip && $last_ip[3] != $user_ip && $last_ip[4] != $user_ip && $last_ip[5] != $user_ip ) )
		{
			$sql1 = "update $upso2_poll_2 set vote = vote + 1 , last_ip = '$user_ip' where poll_1_number='$number' AND sort= '$sort' ";
			$result1 = query($sql1);
			$$vote_target = $$vote_target + 1;
		}
		else
		{
			msg("이미 투표하셨습니다.");
		}
	}
	*/
	
	#중복투표방지로그 2010-02-10 kad
	if ( $_POST["votetype"] == "up_vote" && $sort != "" )
	{
		if ( poll_log_check($number) )
		{
			$sql1 = "update $upso2_poll_2 set vote = vote + 1 , last_ip = '$user_ip' where poll_1_number='$number' AND sort= '$sort' ";
			$result1 = query($sql1);
			poll_log($number);
		}
		else
		{
			#msg("이미 투표하셨습니다");
			continue;
		}
	}
	#중복투표방지로그 2010-02-10 kad
}
#####투표 업데이트 끝#####

	if( !(is_file("$skin_folder/$file")) ) {
		print "알맹이파일 $skin_folder/$file 파일이 존재하지 않습니다. <br>";
		return;
	}

    $TPL->define("알맹이", "$skin_folder/$file");
	$내용 = &$TPL->fetch();




	$temp = "default_poll.html";
	if( !(is_file("$skin_folder/$temp")) ) {
		print "껍데기파일 $skin_folder/$temp 파일이 존재하지 않습니다. <br>";
		return;
	}
	//echo $temp;
    $TPL->define("껍데기", "$skin_folder/$temp");
	$content = &$TPL->fetch();
	print $content;




	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}


?>