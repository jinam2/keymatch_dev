<?php

//현재접속자
$NowConnects = array(array(),array());

$connect_id = $_COOKIE['happyjob_userid'];

if ( $connect_id == "" )
{
	$_SESSION['CID'] = "nomember";
}
else
{
	$_SESSION['CID'] = $connect_id;
}
//접속자IP
if($_SESSION['CIP'] == '')
{
	$_SESSION['CIP'] = $_SERVER['REMOTE_ADDR'];
}
//echo $_SESSION['CID'];

//마지막에 본 페이지의 url
/*
if ( $_COOKIE['happy_mobile'] != 'on'
	&& !preg_match("/admin/i",$_SERVER['REQUEST_URI'])
	&& !preg_match("/xml_/i",$_SERVER['REQUEST_URI'])
	&& !preg_match("/banner_/i",$_SERVER['REQUEST_URI'])
	&& !preg_match("/xml/i",$_SERVER['REQUEST_URI'])
	&& !preg_match("/happy_conn/i",$_SERVER['REQUEST_URI'])
	&& !preg_match("/ajax/i",$_SERVER['REQUEST_URI'])
	&& !preg_match("/loadview/i",$_SERVER['REQUEST_URI'])
	&& !preg_match("/sns_login/i",$_SERVER['REQUEST_URI'])
)
{
	$_SESSION['LASTURL'] = $_SERVER['REQUEST_URI'];
}
*/


//print_r($NowConnectIds);
//echo session_id()."<br>";
//print_r($_SESSION);
//현재접속자


//{{접속자리스트 가로1개,rows_connect.html,가로500픽셀,세로100픽셀}}
function call_connection()
{
	$args = func_get_args();
	$ex_width = preg_replace('/\D/', '', $args[0]);
	$ex_template = $args[1];
	$ex_framewidth = preg_replace('/\D/', '', $args[2]);
	$ex_frameheight = preg_replace('/\D/', '', $args[3]);

	$call_url = "happy_conn.php";
	$call_url.= "?ex_width=".urlencode($ex_width);
	$call_url.= "&ex_template=".urlencode($ex_template);
	$call_url.= "&ex_framewidth=".urlencode($ex_framewidth);

	return '<iframe style="overflow-y:auto;" frameborder="0" marginwidth="0" marginheight="0" width="'.$ex_framewidth.'px" height="'.$ex_frameheight.'px" src="'.$call_url.'" id="ConnectingFrame"></iframe>';
}


$guest_num = 1;
function connection_list()
{

	global $TPL;
	global $skin_folder;
	global $Connecting;
	global $happy_member;
	global $now_connect_cnt;
	global $HAPPY_CONFIG;

	global $session_dir;

	$session_file = $session_dir."/sess_".session_id();
	$NowConnects = nowconnect();
	//print_r2($NowConnects);
	$NowConnectIds = parseconnect($NowConnects);
	//print_r2($NowConnectIds);

	$args = func_get_args();
	//가로몇개
	$ex_width = preg_replace('/\D/', '', $args[0]);
	//rows 파일
	$ex_template = $args[1];

	$guest_text = "<span style='font-size:11px; color:#777;'>손님</span>";

	$TPL->define("현재접속자", "$skin_folder/$ex_template");
	$TmpConnecting = $NowConnectIds[0];

	//print_r($TmpConnecting);
	$TmpWaiting = $NowConnectIds[1];

	$현재접속자 = count($TmpConnecting);
	$자리비움자 = count($TmpWaiting);
	$전체접속자 = $현재접속자 + $자리비움자;

	$i = 1;

	//동일ip에 동일id 예외처리
	$exists_ids = array();


	foreach ( $TmpConnecting as $k => $v )
	{
		$Connecting = array();
		$LoginM = array();

		list($c_id,$sess_id,$last_url,$c_ip) = explode("_c_",$v);

		//회원이면 한ip에서 여러개로 접속해도 한번만 보여주자.
		//화면에 출력되는 거는 브라우져중 어느것인지 알수가 없다.
		if ( $c_id != "nomember" )
		{
			if ( in_array($c_id."|".$c_ip,$exists_ids) )
			{
				continue;
			}
			else
			{
				$exists_ids[] = $c_id."|".$c_ip;
			}
		}
		//회원이면 한ip에서 여러개로 접속해도 한번만 보여주자.

		//현재접속자 출력설정에 의해서 보여줄지 안보여줄지
		if ( $HAPPY_CONFIG['connect_out_type'] == "전체" )
		{

		}
		else if ( $HAPPY_CONFIG['connect_out_type'] == "회원만" )
		{
			if ( $c_id == "nomember" )
			{
				continue;
			}
		}
		else if ( $HAPPY_CONFIG['connect_out_type'] == "비회원만" )
		{
			if ( $c_id != "nomember" )
			{
				continue;
			}
		}
		//현재접속자 출력설정에 의해서 보여줄지 안보여줄지


		if ( $c_id != "nomember" )
		{
			$sql = "select * from $happy_member where user_id = '$c_id'";
			//echo $sql;
			$result = query($sql);
			$LoginM = happy_mysql_fetch_assoc($result);
		}
		else
		{
			$LoginM['user_name'] = "";
			$guest_num++;
		}

		$c_id= str_replace("nomember",$guest_text.$guest_num,$c_id);

		$Connecting['ip_info'] = ip_address_replace($c_ip);

		if ( $LoginM['user_name'] != "" )
		{

			if ( $LoginM['sns_site'] != '' )
			{
				$c_id_tmp				= explode('_', $c_id);
				$LoginM['user_nick']	= $LoginM['user_nick'] == '' ? $LoginM['user_name'] : $LoginM['user_nick'];

				$c_id2					= "<img src='img/sns_icon/icon_conn_".$LoginM['sns_site'].".png' border='0' align='absmiddle' style='width:16px;'>". $LoginM['user_nick'] ;
			}
			else
			{
				$c_id2					= "<span style='font-size:11px;'>".$c_id."</span>";
			}

			$Connecting['id_info'] = "<a href='#' style='text-decoration:none'		onClick=\"window.open('happy_message.php?mode=send&receiveid=".$c_id."','happy_message','width=700,height=600,toolbar=no,scrollbars=no')\" style='font-size:11px;'>".$c_id2."</a>";
			$Connecting['name_info'] = "<a href='#' style='text-decoration:none'		onClick=\"window.open('happy_message.php?mode=send&receiveid=".$c_id."','happy_message','width=700,height=600,toolbar=no,scrollbars=no')\" style='font-size:11px;'>".'<img src="img/message/icon_messicon3.gif" alt="쪽지" border="0" align="absmiddle">'."</a>";
			$Connecting['ip_info'] = "";
		}
		else
		{
			$Connecting['id_info'] = "<span style='font-size:11px;'>".$c_id."</span>";
			$Connecting['name_info'] = '<img src="img/message/icon_messicon2.gif" alt="쪽지" border="0" align="absmiddle">';
		}

		if ( $sess_id == session_id() )
		{
			$Connecting['me_info'] = '<img src="img/connect_me.gif" alt="나" border="0" align="absmiddle">';
		}

		if ( $last_url != "" )
		{
			$Connecting['last_info'] = '<a href="'.$last_url.'" target="_BLANK"><img src="img/last_con.gif" alt="마지막본페이지" border="0" align="absmiddle">';
		}

		$Connecting['stat_info'] = '<img src="img/connect_on.gif" alt="접속중" border="0" align="absmiddle">';

		$one_row = &$TPL->fetch("현재접속자");
		$rows .= table_adjust($one_row,$ex_width,$i);
		$i++;
	}

	//print_r2($exists_ids);



	foreach ( $TmpWaiting as $k => $v )
	{
		$Connecting = array();
		$LoginM = array();

		list($c_id,$sess_id,$last_url,$c_ip) = explode("_c_",$v);

		//회원이면 한ip에서 여러개로 접속해도 한번만 보여주자.
		if ( $c_id != "nomember" )
		{
			if ( in_array($c_id."|".$c_ip,$exists_ids) )
			{
				continue;
			}
			else
			{
				$exists_ids[] = $c_id."|".$c_ip;
			}
		}
		//회원이면 한ip에서 여러개로 접속해도 한번만 보여주자.

		//현재접속자 출력설정에 의해서 보여줄지 안보여줄지
		if ( $HAPPY_CONFIG['connect_out_type'] == "전체" )
		{

		}
		else if ( $HAPPY_CONFIG['connect_out_type'] == "회원만" )
		{
			if ( $c_id == "nomember" )
			{
				continue;
			}
		}
		else if ( $HAPPY_CONFIG['connect_out_type'] == "비회원만" )
		{
			if ( $c_id != "nomember" )
			{
				continue;
			}
		}
		//현재접속자 출력설정에 의해서 보여줄지 안보여줄지

		if ( $c_id != "nomember" )
		{
			$sql = "select * from $happy_member where user_id = '$c_id'";
			//echo $sql;
			$result = query($sql);
			$LoginM = happy_mysql_fetch_assoc($result);
		}
		else
		{
			$LoginM['user_name'] = "";
			$guest_num++;
		}

		$c_id = str_replace("nomember",$guest_text.$guest_num,$c_id);
		$Connecting['ip_info'] = ip_address_replace($c_ip);


		if ( $LoginM['user_name'] != "" )
		{
			if ( $LoginM['sns_site'] != '' )
			{
				$c_id_tmp				= explode('_', $c_id);
				$LoginM['user_nick']	= $LoginM['user_nick'] == '' ? $LoginM['user_name'] : $LoginM['user_nick'];

				$c_id2					= "<img src='img/sns_icon/s_icon_".$LoginM['sns_site'].".png' border='0' align='absmiddle'>". $LoginM['user_nick'] ;
			}
			else
			{
				$c_id2					= "<span style='font-size:11px;'>".$c_id."</span>";
			}

			$Connecting['id_info'] = "<a href='#' style='text-decoration:none'		onClick=\"window.open('happy_message.php?mode=send&receiveid=".$c_id."','happy_message','width=700,height=500,toolbar=no,scrollbars=no')\" style='font-size:11px;'>".$c_id2."</a>";
			$Connecting['name_info'] = " <a href='#' style='text-decoration:none'		onClick=\"window.open('happy_message.php?mode=send&receiveid=".$c_id."','happy_message','width=700,height=500,toolbar=no,scrollbars=no')\" style='font-size:11px;'>".'<img src="img/message/icon_messicon3.gif" alt="쪽지" border="0" align="absmiddle">'."</a>";
			$Connecting['ip_info'] = "";
		}
		else
		{
			$Connecting['id_info'] = "<span style='font-size:11px;'>".$c_id."</span>";
			$Connecting['name_info'] = '<img src="img/message/icon_messicon2.gif" alt="쪽지" border="0" align="absmiddle">';
		}

		if ( $sess_id == session_id() )
		{
			$Connecting['me_info'] = '<img src="img/connect_me.gif" alt="나" border="0" align="absmiddle">';
		}

		if ( $last_url != "" )
		{
			$Connecting['last_info'] = '<a href="'.$last_url.'" target="_BLANK"><img src="img/last_con.gif" alt="마지막본페이지" border="0" align="absmiddle">';
		}




		$Connecting['stat_info'] = '<img src="img/connect_off.gif" alt="자리비움" border="0" align="absmiddle">';

		$one_row = &$TPL->fetch("현재접속자");
		$rows .= table_adjust($one_row,$ex_width,$i);
		$i++;
	}



	//접속자 수
	$now_connect_cnt = number_format(($i-1));

	//$전체접속자 = 0;
	if ( $전체접속자 == 0 || $HAPPY_CONFIG['connect_out_type'] == "출력안함" )
	{
		$now_connect_cnt = 0;
		return "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td align='center'>접속자가 없습니다.</td></tr></table>";
	}
	else
	{
		return "<table cellpadding='0' cellspacing='0' border='0' width='100%'>$rows</table>";
	}

}

//세션파일에서 접속자 구하기
function nowconnect()
{
	global $session_dir;
	global $LoginTime;
	global $WaitTime;

	$ReturnArr = array(array(),array());

	if(is_dir($session_dir))
	{
		$dir_obj=opendir($session_dir);
		while(($file_str = readdir($dir_obj))!==false)
		{
			if( $file_str!="." && $file_str!=".." && preg_match("/^sess_/",$file_str) && file_exists($session_dir."/".$file_str) && is_readable($session_dir."/".$file_str) )
			{
				$LastConnectTime = filemtime($session_dir."/".$file_str) + $LoginTime;
				$WaitConnectTime = filemtime($session_dir."/".$file_str) + $WaitTime;

				if ( $LastConnectTime > happy_mktime() )
				{
					$tmpv = file_get_contents($session_dir."/".$file_str);
					#$tmpv .= "로그인중";
					if ( !in_array($tmpv,$ReturnArr) )
					{
						$sess_id = str_replace("sess_","",$file_str);
						array_push($ReturnArr[0],$tmpv."_c_".$sess_id);
					}
				}
				else if ( $WaitConnectTime > happy_mktime() )
				{
					$tmpv = file_get_contents($session_dir."/".$file_str);
					#$tmpv.= "자리비움중";
					if ( !in_array($tmpv,$ReturnArr) )
					{
						$sess_id = str_replace("sess_","",$file_str);
						array_push($ReturnArr[1],$tmpv."_c_".$sess_id);
					}
				}
			}
		}
		closedir($dir_obj);
	}


	return $ReturnArr;

}


//세션파일내용으로 회원아이디, 마지막에 본 url 추출
function parseconnect($Array)
{
	//회원아이디
	$patten = "/CID\|\S:\d{0,4}:\"([a-zA-Z0-9_]*)\";/";
	//마지막에 본 url
	$patten2 = "/LASTURL\|\S:\d{0,4}:\"(.*?)\";/s";
	//접속자 아이피
	$patten3 = "/CIP\|\S:\d{0,4}:\"(.*?)\";/s";


	$ids = array(array(),array());

	foreach( $Array as $k => $v )
	{
		if ( is_array($v) )
		{
			foreach( $v as $kk => $vv )
			{
				$last_url = "";
				$c_ip = "";

				list($tmp,$sess_id) = explode("_c_",$vv);

				preg_match($patten,$vv,$m);
				//마지막에 본 url
				preg_match($patten2,$vv,$m2);
				//접속자 ip
				preg_match($patten3,$vv,$m3);

				//echo $vv."<br>";
				//print_r($m2);
				//echo "<br>";
				//echo "<br>";

				if ( $m2[1] != "" )
				{
					$last_url = $m2[1];
				}

				if ( $m3[1] != "" )
				{
					$c_ip = $m3[1];
				}

				if ( $m[1] != '' )
				{
					//echo $m[1]."<br>";
					array_push($ids[$k],$m[1]."_c_".$sess_id."_c_".$last_url."_c_".$c_ip);
				}
			}
		}
	}

	return $ids;
}


function ip_address_replace($ip)
{
	$str = "";

	if ( $ip != "" )
	{
		$ips = explode(".",$ip);
		$ips[2] = "***";
		$str = implode(".", (array) $ips);
	}

	return $str;
}
?>