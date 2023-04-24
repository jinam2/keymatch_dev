<?php
$t_start = array_sum(explode(' ', microtime()));

include ("./inc/config.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");



if( !(is_file("$skin_folder/poll_popup.html")) ) {
	print "$skin_folder/poll_popup.html 파일이 존재하지 않습니다. ";
	exit;
}
$TPL->define("리스트", "$skin_folder/poll_popup.html");
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
	if ($sort != "" && $_POST["votetype"] == "in_enter") {
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
			msg("투표하셨습니다");
		}
	}
	*/

	#중복투표방지로그 2010-02-10 kad
	/*로그 테이블
	CREATE TABLE `news_poll_log` (
	`number` int(11) NOT NULL auto_increment,
	`poll_number` int(11) NOT NULL default '0',
	`ip_addr` varchar(20) NOT NULL default '',
	`date` datetime NOT NULL default '0000-00-00 00:00:00',
	PRIMARY KEY  (`number`),
	KEY `poll_number` (`poll_number`),
	KEY `ip_addr` (`ip_addr`)
	) ENGINE=MyISAM DEFAULT CHARSET=euckr
	*/

	if ( $_POST["votetype"] == "in_enter" && $sort != ""  )
	{
		if ( poll_log_check($number) )
		{
			$sql1 = "update $upso2_poll_2 set vote = vote + 1 , last_ip = '$user_ip' where poll_1_number='$number' AND sort= '$sort' ";
			$result1 = query($sql1);

			poll_log($number);
		}
		else
		{
			msg("이미 투표하셨습니다");
		}
	}
	#중복투표방지로그 2010-02-10 kad



	// 투표 결과 보여주기 시작 ~#########################################33


	$sql5 = "select SUM(vote) from $upso2_poll_2 where poll_1_number = '$number'";
	$result5 = query($sql5);
	$row = happy_mysql_fetch_array($result5);


	$sql6 = "select title,vote,last_ip from $upso2_poll_2 where poll_1_number = '$number' order by sort asc";
	$result6 = query($sql6);


	$title = array();
	$vote = array();
	$i = 0;
	while ($Data6 = happy_mysql_fetch_array($result6) )
	{
		$title[$i] = $Data6["title"];
		$vote[$i]  = $Data6["vote"];
		$i++;
	}


	#투표결과를 보여주자
	# 100 : $VOTE_ARRAY[0] = x : 투표값들
	# x = 100 * 투표값들 / $VOTE_ARRAY[0]
	#각 나머지들의 테이블 % 값을 뽑아보자. 정수도 만들고 ceil($num_30);
	$vote1_graph = @(($vote[0] / $row[0]) * $graph_width);
	$vote1_graph = @ceil($vote1_graph);
	$vote2_graph = @(($vote[1] / $row[0]) * $graph_width);
	$vote2_graph = @ceil($vote2_graph);
	$vote3_graph = @(($vote[2] / $row[0]) * $graph_width);
	$vote3_graph = @ceil($vote3_graph);
	$vote4_graph = @(($vote[3] / $row[0]) * $graph_width);
	$vote4_graph = @ceil($vote4_graph);
	$vote5_graph = @(($vote[4] / $row[0]) * $graph_width);
	$vote5_graph = @ceil($vote5_graph);
	$vote6_graph = @(($vote[5] / $row[0]) * $graph_width);
	$vote6_graph = @ceil($vote6_graph);


	$투표제목 = $Data["real_title"];

	$title1_info = "";
	$title2_info = "";
	$title3_info = "";
	$title4_info = "";
	$title5_info = "";
	$title6_info = "";

	if ($title[0]) {
	$title1_info = "<tr><td class='noto400 font_14'>$title[0]</td><td class='pollTD3 noto400'><img src=img/poll_multi/leftbar.gif height=15 border=0><img src=img/poll_multi/mainbar.gif width=$vote1_graph height=15 border=0><img src=img/poll_multi/rightbar.gif height=15 border=0> ($vote[0] 표)</td></tr><tr><td colspan='3' ><div style=' border-bottom:1px dashed #dedede; height:5px; margin-bottom:5px; font-size:1px;'></div></td></tr>";
	}

	if ($title[1]) {
	$title2_info = "<tr><td class='noto400 font_14'>$title[1]</td><td class='pollTD3 noto400'><img src=img/poll_multi/leftbar.gif height=15 border=0><img src=img/poll_multi/mainbar.gif width=$vote2_graph height=15 border=0><img src=img/poll_multi/rightbar.gif height=15 border=0> ($vote[1] 표)</td></tr><tr><td colspan='3' ><div style=' border-bottom:1px dashed #dedede; height:5px; margin-bottom:5px; font-size:1px;'></div></td></tr>";
	}

	if ($title[2]) {
	$title3_info = "<tr><td class='noto400 font_14'>$title[2]</td><td class='pollTD3 noto400'><img src=img/poll_multi/leftbar.gif height=15 border=0><img src=img/poll_multi/mainbar.gif width=$vote3_graph height=15 border=0><img src=img/poll_multi/rightbar.gif height=15 border=0> ($vote[2] 표)</td></tr><tr><td colspan='3' ><div style=' border-bottom:1px dashed #dedede; height:5px; margin-bottom:5px; font-size:1px;'></div></td></tr>";
	}

	if ($title[3]) {
	$title4_info = "<tr><td class='noto400 font_14'>$title[3]</td><td class='pollTD3 noto400'><img src=img/poll_multi/leftbar.gif height=15 border=0><img src=img/poll_multi/mainbar.gif width=$vote4_graph height=15 border=0><img src=img/poll_multi/rightbar.gif height=15 border=0> ($vote[3] 표)</td></tr><tr><td colspan='3' ><div style=' border-bottom:1px dashed #dedede; height:5px; margin-bottom:5px; font-size:1px;'></div></td></tr>";
	}

	if ($title[4]) {
	$title5_info = "<tr><td class='noto400 font_14'>$title[4]</td><td class='pollTD3 noto400'><img src=img/poll_multi/leftbar.gif height=15 border=0><img src=img/poll_multi/mainbar.gif width=$vote5_graph height=15 border=0><img src=img/poll_multi/rightbar.gif height=15 border=0> ($vote[4] 표)</td></tr><tr><td colspan='3' ><div style=' border-bottom:1px dashed #dedede; height:5px; margin-bottom:5px; font-size:1px;'></div></td></tr>";
	}

	if ($title[5]) {
	$title6_info = "<tr><td class='noto400 font_14'>$title[5]</td><td class='pollTD3 noto400'><img src=img/poll_multi/leftbar.gif height=15 border=0><img src=img/poll_multi/mainbar.gif width=$vote6_graph height=15 border=0><img src=img/poll_multi/rightbar.gif height=15 border=0> ($vote[5] 표)</td></tr><tr><td colspan='3' ><div style=' border-bottom:1px dashed #dedede; height:5px; margin-bottom:5px; font-size:1px;'></div></td></tr>";
	}

	$투표목록 = <<<END
	<table width=100%>
	$title1_info
	$title2_info
	$title3_info
	$title4_info
	$title5_info
	$title6_info
	</table>
END;





	$내용 .= $TPL->fetch("리스트");


}

print $내용;
?>