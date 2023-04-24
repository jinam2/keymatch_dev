<?php
/*
CREATE TABLE `happy_message` (
  `number` int(11) NOT NULL auto_increment,
  `sender_id` varchar(50) NOT NULL default '',
  `sender_name` varchar(50) NOT NULL default '',
  `sender_admin` enum('y','n') NOT NULL default 'n',
  `receive_id` varchar(50) NOT NULL default '',
  `receive_name` varchar(50) NOT NULL default '',
  `receive_admin` enum('y','n') NOT NULL default 'n',
  `message` text NOT NULL,
  `regdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `readok` enum('y','n') NOT NULL default 'n',
  `readdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `chkok` enum('y','n') NOT NULL default 'n',
  `del_sender` enum('y','n') NOT NULL default 'n',
  `del_receive` enum('y','n') NOT NULL default 'n',
  PRIMARY KEY  (`number`),
  KEY `sender_id` (`sender_id`),
  KEY `receive_id` (`receive_id`),
  KEY `readok` (`readok`)
);
*/

	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	if ( !happy_member_secure("쪽지발송") )
	{
		msgclose("쪽지발송 권한이 없습니다.");
		exit;
	}

	$mode	= ( $_GET['mode'] == '' )?'receivelist':$_GET['mode'];
	$number	= preg_replace("/\D/","",$_GET['number']);
	$userid	= $message_loginVal;

	$senderAdmin	= $_GET['senderAdmin'];
	$receiveAdmin	= $_GET['receiveAdmin'];
	$rAdminName		= $_GET['rAdminName'];
	$_GET['adminMode']	= $_GET['adminMode'] == '' ? 'n' : $_GET['adminMode'];

	//2017-01-13 sum부분업그레이드(쪽지기능 개선)
	$search_type		= $_GET["search_type"];
	$search_word		= $_GET["search_word"];
	$email_forwarding	= $_GET['email_forwarding'];
	$sms_forwarding		= $_GET['sms_forwarding'];
	$state_open			= $_GET['state_open'];
	$group_select		= $_GET['group_select'];
	$startdate			= $_GET['startdate'];
	$enddate			= $_GET['enddate'];
	$start_point		= $_GET['start_point'];
	$end_point			= $_GET['end_point'];
	//2017-01-13 sum부분업그레이드(쪽지기능 개선)

	#if ( $_GET['adminMode'] == 'y' && $_COOKIE["admin_id"] == '' )
	if ( $_GET['adminMode'] == 'y' && $_COOKIE["ad_id"] == '' )
	{
		msgclose("관리자 로그인후 이용가능합니다.");
		exit;
	}

	$content	= "";
	$random		= rand(0,10000);

	$delNumber	= $_GET["delNumber"];
	$delType	= $_GET["delType"];

	#로그인체크
	if ( happy_member_login_check() == "" && $_COOKIE['ad_id'] == '' )
	{
		msgclose('로그인후 이용가능합니다.');
		exit;
	}
	#일반회원 로그인 상태가 아니면서 관리자 로그인 중일때 => 쪽지 발송할수 있도록 설정
	else if ( happy_member_login_check() == "" && $_COOKIE['ad_id'] != '' )
	{
		$senderAdmin	= 'y';
	}



	#관리자모드에서 쪽지 볼때
	if ( $_GET['adminMode'] == 'y' && $_COOKIE["ad_id"] != '' )
	{
		$mem_id				= $_COOKIE["ad_id"];
		$사용자이름			= '관리자';
		$adminChk			= 'y';
		$receive_id_WHERE	= "";
		$sender_id_WHERE	= "";
	}
	else
	{
		$mem_id				= $message_loginVal;
		$adminChk			= 'n';
		$receive_id_WHERE	= "receive_id = '$mem_id' AND";
		$sender_id_WHERE	= "sender_id = '$mem_id' AND";
	}


	$where_array	= Array(
						" $receive_id_WHERE receive_admin='$adminChk' AND del_receive='n' ",
						" $sender_id_WHERE sender_admin='$adminChk' AND del_sender='n' ",
						" $receive_id_WHERE receive_admin='$adminChk' AND readok = 'n' AND del_receive='n' ",
						" $sender_id_WHERE sender_admin='$adminChk' AND readok = 'n' AND del_sender='n' "
					);
	$where_names	= Array(
						"받은쪽지수",
						"보낸쪽지수",
						"읽지않은쪽지수",
						"읽히지않은쪽지수"
					);

	for ( $i=0, $max=sizeof($where_names) ; $i<$max ; $i++ )
	{
		$Sql	= "SELECT Count(*) FROM $message_tb WHERE $where_array[$i] ";
		$tmp	= happy_mysql_fetch_array(query($Sql));

		${$where_names[$i]}	= $tmp[0];
	}



	//자신의 쪽지메세지만 확인하기 START - 2016-09-28 hong
	if ( $delNumber != "" && ( $delType == "receive" || $delType == "sender" ) && $adminChk != 'y')
	{
		$Sql		= "SELECT * FROM $message_tb WHERE number='$delNumber'";
		$Tmp		= happy_mysql_fetch_assoc(query($Sql));

		if ( $Tmp[$delType.'_id'] != $userid )
		{
			error("자신의 쪽지메세지만 삭제할 수 있습니다.");
			exit;
		}
	}

	if ( $number != "" && $adminChk != 'y' )
	{
		$Sql			= "SELECT * FROM $message_tb WHERE number='$number'";
		$Tmp			= happy_mysql_fetch_assoc(query($Sql));

		$error_msg		= "";

		if ( $mode == 'receivelist' )
		{
			if ( $Tmp['receive_id'] != $userid )
			{
				$error_msg		= "자신이 받은 쪽지메세지만 확인할 수 있습니다.";
			}
			else if ( $Tmp['del_receive'] == 'y' )
			{
				$error_msg		= "삭제된 쪽지메세지입니다.";
			}

		}
		else if ( $mode == 'senderlist' )
		{
			if ( $Tmp['sender_id'] != $userid )
			{
				$error_msg		= "자신이 보낸 쪽지메세지만 확인할 수 있습니다.";
			}
			else if ( $Tmp['del_sender'] == 'y' )
			{
				$error_msg		= "삭제된 쪽지메세지입니다.";
			}
		}

		if ( $error_msg != "" )
		{
			error($error_msg);
			exit;
		}
	}
	//자신의 쪽지메세지만 확인하기 END



	if ( $delNumber != "" && ( $delType == "receive" || $delType == "sender" ))
	{
		//$userid		= ( $_GET['adminMode'] == 'y' )? $_COOKIE['ad_id'] : $userid;
		if ( $_GET['adminMode'] == 'y' )
		{
			$Sql		= "UPDATE $message_tb SET del_${delType} = 'y' WHERE number='$delNumber' AND ${delType}_admin='$_GET[adminMode]' ";
		}
		else
		{
			$Sql		= "UPDATE $message_tb SET del_${delType} = 'y' WHERE number='$delNumber' AND ${delType}_id='$userid' AND ${delType}_admin='$_GET[adminMode]' ";
		}
		query($Sql);
	}


	if ( $number != '' )
	{
		//$userid		= ( $_GET['adminMode'] == 'y' )? $_COOKIE['ad_id'] : $userid;
		if ( $_GET['adminMode'] == 'y' )
		{
			$Sql		= "UPDATE $message_tb SET readok='y', readdate=now() WHERE number='$number' AND receive_admin='$_GET[adminMode]' ";
		}
		else
		{
			$Sql		= "UPDATE $message_tb SET readok='y', readdate=now() WHERE number='$number' AND receive_id='$userid' AND receive_admin='$_GET[adminMode]' ";
		}
		query($Sql);
		$Sql		= "SELECT * FROM $message_tb WHERE number='$number' ";
		$Message	= happy_mysql_fetch_array(query($Sql));

		#$Message['message']		= nl2br(strip_tags($Message['message']));
		$Message['message']		= nl2br($Message['message']);

		#슈퍼 관리자가 발송한 쪽지의 경우 아이디 대신 슈퍼관리자 출력
		#부관리자는 그냥 부관리자 아이디 출력
		if ( $Message['sender_admin'] == 'y' )
		{
			$Message['sender_id_view']	= ( $Message['sender_id'] == $admin_id )?'슈퍼관리자':$Message['sender_id'];
			$Message['sender_name']		= '관리자';
		}
		else
		{
			$Message['sender_id_view']	= $Message['sender_id'];

			# SNS LOGIN 처리 추가
			$comment_user				= happy_mysql_fetch_array(query("SELECT user_nick, sns_site FROM $happy_member WHERE user_id='$Message[sender_id]'"));
			$Message['sender_id_view']	= ( $comment_user['user_nick'] == '' ) ? $Message['sender_id'] : $comment_user['user_nick'];

			$SNS_CHECK					= $happy_sns_array[$comment_user['sns_site']];
			if ( is_array($SNS_CHECK) === true )
			{
				if ( $SNS_CHECK['icon_use_messageView'] !== false )
				{
					$Message['sender_id_view']	= "<img src='". $SNS_CHECK['icon_use_messageView']. "' border='0' align='absmiddle'>". $Message['sender_id_view'];
				}
			}
		}

		if ( $Message['receive_admin'] == 'y' )
		{
			$Message['receive_id_view']	= ( $Message['receive_id'] == $admin_id )?'슈퍼관리자':$Message['receive_id'];
			$Message['receive_name']	= '관리자';
		}
		else
		{
			$Message['receive_id_view']	= $Message['receive_id'];

			# SNS LOGIN 처리 추가
			$comment_user				= happy_mysql_fetch_array(query("SELECT user_nick, sns_site FROM $happy_member WHERE user_id='$Message[receive_id]'"));
			$Message['receive_id_view']	= ( $comment_user['user_nick'] == '' ) ? $Message['receive_id'] : $comment_user['user_nick'];

			$SNS_CHECK					= $happy_sns_array[$comment_user['sns_site']];
			if ( is_array($SNS_CHECK) === true )
			{
				if ( $SNS_CHECK['icon_use_messageView'] !== false )
				{
					$Message['receive_id_view']	= "<img src='". $SNS_CHECK['icon_use_messageView']. "' border='0' align='absmiddle'>". $Message['receive_id_view'];
				}
			}
		}


		$file		= ( $_GET["file"] == "" )?"message_view.html":$_GET["file"];

		$목록링크	= "?mode=$_GET[mode]&start=$_GET[start]&kfield=$_GET[kfield]&kword=$_GET[kword]&adminMode=$_GET[adminMode]";
		$TPL->define("쪽지보기_$random", "$skin_folder/$file");
		$content	= &$TPL->fetch();
		echo $content;

		exit;
	}

	if ( $mode == 'receivelist' )
	{
		$file		= ( $_GET["file"] == "" )?"message_receive_rows.html":$_GET["file"];
		$file2		= ( $_GET["file2"] == "" )?"message_receive_default.html":$_GET["file2"];
		message_list( 10 , '받은쪽지', $file2, $file,60);
	}
	else if ( $mode == 'receivelist2' )
	{
		$file		= ( $_GET["file"] == "" )?"message_receive_rows2.html":$_GET["file"];
		$file2		= ( $_GET["file2"] == "" )?"message_receive2_default.html":$_GET["file2"];
		message_list( 10 , '읽지않은쪽지', $file2, $file,60);
	}
	else if ( $mode == 'senderlist' )
	{
		$file		= ( $_GET["file"] == "" )?"message_sender_rows.html":$_GET["file"];
		$file2		= ( $_GET["file2"] == "" )?"message_sender_default.html":$_GET["file2"];
		message_list( 10 , '보낸쪽지', $file2, $file,40);
	}
	else if ( $mode =='send' && ($_GET['send_type'] == "all_user" || $_GET['send_type'] == "search_user"))		//전체회원에게 쪽지보내기
	{
		/*
		$sql = "select $message_field_id,$message_field_name from $message_pertb";
		$result = query($sql);

		while($AllUser = happy_mysql_fetch_array($result)) {
			$receiveid .= $AllUser[$message_field_id].",";
		}

		$receiveid = preg_replace("{,$}","",$receiveid);

		$_GET["receiveid"] = $receiveid;
		*/
		$file		= ( $_GET["file"] == "" )?"message_send_form.html":$_GET["file"];

		//2017-01-13 sum부분업그레이드(쪽지기능 개선)
		if($_GET['send_type'] == "all_user")
		{
			$receiveid = "전체회원";
		}

		$search_query	= $_GET['search_query'];
		$send_type		= $_GET['send_type'];
		//2017-01-13 sum부분업그레이드(쪽지기능 개선)


		$TPL->define("쪽지발송폼_$random", "$skin_folder/$file");
		$content	= &$TPL->fetch();
		echo $content;

	}
	else if ( $mode == 'send' )
	{

		// 검색회원, 체크회원 쪽지발송 POST로 변경 hong
		if ( $_GET['senderAdmin'] == "y" && $_POST['receiveid'] != "" )
		{
			$_GET['receiveid'] = $_POST['receiveid'];
		}

		$receiveid			= ( $_GET['receiveAdmin'] == 'y' )? $_GET['receiveid'] : $_GET['receiveid'];
		$receiveid_readonly	= ( $_GET['receiveAdmin'] == 'y' )? ' readonly ' : '';

		//비회원에게는 쪽지발송불가
		$temp = explode('.', $_GET['receiveid']);
		if ( sizeof($temp) == 4 )
		{
			$is_ip = true;
			foreach ( $temp as $val )
			{
				if ( intval($val) != $val )
				{
					$is_ip = false;
					break;
				}
			}

			if ( $is_ip == true )
			{
				error('비회원에게는 쪽지발송이 불가능합니다.');
				exit;
			}
		}
		//비회원에게는 쪽지발송불가

		#쪽지발송시 포인트 차감
		$check_point = "";
		//$MEM['point'] = "900";
		//$HAPPY_CONFIG['MessageSendPoint'] = "800";
		if ( $receiveAdmin != 'y' && $senderAdmin != 'y' )
		{
			if ( $HAPPY_CONFIG['MessageSendPoint'] > 0 )
			{
				$check_point = ' onsubmit = "return check_point(this);" ';
			}
		}
		#쪽지발송시 포인트 차감

		$file		= ( $_GET["file"] == "" )?"message_send_form.html":$_GET["file"];

		//2017-01-13 sum부분업그레이드(쪽지기능 개선)
		$search_query	= $_GET['search_query'];
		$send_type		= $_GET['send_type'];
		//2017-01-13 sum부분업그레이드(쪽지기능 개선)

		$TPL->define("쪽지발송폼_$random", "$skin_folder/$file");
		$content	= &$TPL->fetch();
		echo $content;
	}
	else if ( $mode == 'send_reg' )
	{
		if ( !$_POST ) {
			error("잘못된 접근입니다.");
			exit;
		} else if ( !$_POST["receiveid"] ) {
			error("받는 아이디를 입력하세요.");
			exit;
		} else if ( !$_POST["message"] ) {
			error("내용을 입력하세요.");
			exit;
		}

		$receiveid	= explode(",",$_POST["receiveid"]);
		$senderid	= $userid;
		$message	= html_remove($_POST["message"]);
		$sendok		= '';
		$sendno		= '';


		if ( $user_id != '' )
		{
			$Sql		= "Select $message_field_name FROM $message_pertb WHERE $message_field_id = '$userid' ";
			$USER		= happy_mysql_fetch_array(query($Sql));
			$senderName	= $USER[$message_field_name];
		}

		#받는사람이 관리자인지 보내는사람이 관리자인지
		$senderAdmin	= $_POST['senderAdmin'] == 'y' || $_GET['adminMode'] == 'y' ? 'y' : 'n';
		$receiveAdmin	= $_POST['receiveAdmin'] == 'y' ? 'y' : 'n';
		$rAdminName		= $_POST['rAdminName'];
		//$max=sizeof($receiveid);

		#보내는사람이 관리자인데 보내는사람 아이디가 없을때 admin 입력
		$senderid	= ( $senderAdmin == 'y' && $sAdminName == '' )? $_COOKIE['ad_id'] : $senderid;
		$senderName	= ( $senderAdmin == 'y' && $sAdminName == '' )? '관리자' : $senderName;

		//2017-01-13 sum부분업그레이드(쪽지기능 개선)
		if($_GET['send_type'] == "all_user" || $_GET['send_type'] == "search_user")
		{
			$receiveid = array();

			$WHERE		= "";
			if ( $search_word != "" )
			{
				if ( $search_type == '' )
				{
					$WHERE	.= "
									AND
									(
										user_id			like '%${search_word}%'
										OR
										user_homepage	like '%${search_word}%'
										OR
										user_email		like '%${search_word}%'
										OR
										user_name		like '%${search_word}%'
										OR
										user_nick		like '%${search_word}%'
										OR
										user_phone		like '%${search_word}%'
										OR
										user_hphone		like '%${search_word}%'
									)
					";
				}
				else
				{
					$WHERE	.= " AND $search_type like '%${search_word}%' ";
				}
			}

			#가입기간검색
			if ($startdate != "" && $enddate != "")
			{
				$WHERE .= " AND reg_date BETWEEN '$startdate' AND '$enddate' ";
			}
			else if ($startdate != "" && $enddate == "")
			{
				$WHERE .= " AND  reg_date >= '$startdate' ";
			}
			else if ($startdate == "" && $enddate != "")
			{
				$WHERE .= " AND reg_date <= '$enddate' ";
			}

			#포인트검색
			if ($start_point != "" && $end_point != "")
			{
				$WHERE .= " AND point BETWEEN $start_point AND $end_point ";
			}
			else if ($start_point != "" && $end_point == "")
			{
				$WHERE .= " AND point >= $start_point ";
			}
			else if ($start_point == "" && $end_point != "")
			{
				$WHERE .= " AND point <= $end_point ";
			}

			#수신동의
			$WHERE		.= ($email_forwarding == "y")	?" AND email_forwarding='y' "	:"";
			$WHERE		.= ($sms_forwarding == "y")		?" AND sms_forwarding='y' "		:"";
			$WHERE		.= ($state_open == "y")			?" AND state_open='y' "			:"";
			$WHERE		.= ($group_select == '')		? ""							: " AND `group`='$group_select' ";

			$Sql = "SELECT $message_field_id,$message_field_name FROM $happy_member WHERE 1=1 $WHERE";
			$result = query($Sql);

			while($REV = happy_mysql_fetch_array($result))
			{
				$user_id	= $REV[$message_field_id];
				$user_name	= $REV[$message_field_name];

				$MESSAGE[$user_id][$message_field_id]		= $user_id;
				$MESSAGE[$user_id][$message_field_name]		= $user_name;
				$MESSAGE[$user_id][$message_field_name]		= ( $MESSAGE[$user_id][$message_field_name] == "" )		? $MESSAGE[$user_id][$message_field_id] : $MESSAGE[$user_id][$message_field_name];

				#받는사람이 관리자일경우 넘어온 관리자아이디(부관리자) 없을경우 admin 으로 입력
				$MESSAGE[$user_id]['receiveName']			= ( $receiveAdmin == 'y' && $rAdminName == '' )			? $_COOKIE['admin_id'] : $MESSAGE[$user_id][$message_field_name];
			}
		}
		else
		{
			$REV		= explode(",",$_POST["receiveid"]);

			foreach($REV as $user_id)
			{
				$Sql		= "SELECT $message_field_id,$message_field_name FROM $happy_member WHERE $message_field_id ='$user_id'";
				list($MESSAGE[$user_id][$message_field_id], $MESSAGE[$user_id][$message_field_name]) = happy_mysql_fetch_array(query($Sql));

				#받는사람이 관리자일경우 넘어온 관리자아이디(부관리자) 없을경우 admin 으로 입력
				$MESSAGE[$user_id]['receiveName']		= ( $receiveAdmin == 'y' && $rAdminName == '' )			? $_COOKIE['admin_id'] : $MESSAGE[$user_id][$message_field_name];
				$MESSAGE[$user_id][$message_field_name] = ( $MESSAGE[$user_id][$message_field_name] == "" )		? $MESSAGE[$user_id][$message_field_id] : $MESSAGE[$user_id][$message_field_name];
			}
		}

		$max = sizeof($MESSAGE);

		#받는사람이 관리자인데 다중발송일 경우 일반회원과 같이 보내는 경우이므로 쪽지발송불가능
		if ( $receiveAdmin == 'y' && $max > 1 )
		{
			error("관리자에게 발송시 일반회원에게 쪽지를 동시발송 하실수 없습니다.");
			exit;
		}

		flush();
		echo "
				<HTML>
				<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<style>
						body { font-size : 9pt; }
					</style>
				</HEAD>

				<BODY>
					<table width='100%' height='100%' border='0'>
					<tr>
						<td align='center'>
							<div id='message' ></div>
						</td>
					</tr>
					</table>
		";
		flush();

		$i						= 0;
		$TotalMessageSendPoint	= 0;
		foreach($MESSAGE as $key => $value)
		{
			if ( $value[$message_field_id] != '' || $receiveAdmin == 'y' )
			{
				#쪽지발송시 포인트 차감
				if ( $receiveAdmin != 'y' && $senderAdmin != 'y' )
				{
					if ( $HAPPY_CONFIG['MessageSendPoint'] > 0 )
					{
						if ( $MEM['point'] > $HAPPY_CONFIG['MessageSendPoint'] )
						{
							$gou_number = $mem_id."-".happy_mktime();

							$sql = "INSERT INTO ".$point_jangboo." SET ";
							$sql.= "id = '".$mem_id."', ";
							$sql.= "point = '".$HAPPY_CONFIG['MessageSendPoint']."|".$HAPPY_CONFIG['MessageSendPoint']."', ";
							$sql.= "pay_type = '포인트결제', ";
							$sql.= "in_check = 2, ";
							$sql.= "or_no = '".$gou_number."', ";
							$sql.= "links_number = '".$number."', ";
							$sql.= "links_title = '쪽지발송으로 인한 포인트 차감', ";
							$sql.= "reg_date = NOW(), ";
							$sql.= "member_type = '".$_COOKIE['level']."' ";

							//query($sql);

							$sql = "update ".$happy_member." set point = point - ".$HAPPY_CONFIG['MessageSendPoint']." where user_id = '".$mem_id."'";
							query($sql);

							$TotalMessageSendPoint = $TotalMessageSendPoint + $HAPPY_CONFIG['MessageSendPoint'];
						}
						else
						{
							$alert_msg = "포인트가 부족하여 쪽지를 발송할수가 없습니다.";
							msgclose($alert_msg);
							exit;
						}
					}
				}
				#쪽지발송시 포인트 차감

				$Sql	= "
							INSERT INTO
									$message_tb
							SET
									sender_id		= '".$senderid."',
									sender_name		= '".$senderName."',
									sender_admin	= '".$senderAdmin."',
									receive_id		= '".$value[$message_field_id]."',
									receive_name	= '".$value['receiveName']."',
									receive_admin	= '".$receiveAdmin."',
									message			= '".$message."',
									regdate			= now(),
									readok			= 'n',
									chkok			= 'n'
				";
				query($Sql);

				$sendok	.= ( $sendok == '' )?$value[$message_field_id]:', '.$value[$message_field_id];
			}
			else
			{
				$sendno	.= ( $sendno == '' )?$value[$message_field_id]:', '.$value[$message_field_id];
			}

			if($_GET['send_type'] == "all_user" || $_GET['send_type'] == "search_user")
			{
				$count = $i+1;

				if($i % 500 == 0 || $i < 100 || $count == $max)
				{
					flush();
					echo "
					<script> document.getElementById('message').innerHTML	= '${count} / ${max} 쪽지 발송중';</script>
					";
					flush();
				}
			}

			$i++;
		}
		//2017-01-13 sum부분업그레이드(쪽지기능 개선)

		$sendok		= ( $sendok == '' )?'전송에 성공한 사람이 없습니다.':$sendok;
		$sendno		= ( $sendno == '' )?'':'\\n발송실패 : '.$sendno;

		if ( $endMode == 'close' )
		{
			if ( $receiveAdmin == 'y' || $senderAdmin == 'y' )
			{
				$alert_msg = "전송완료되었습니다.";
			}
			else
			{
				$alert_msg = "전송완료되었습니다.";

				if ( $HAPPY_CONFIG['MessageSendPoint'] > 0 )
				{
					$alert_msg = "쪽지 발송으로 인해서 ".$TotalMessageSendPoint."포인트 차감합니다.";
				}

			}

			msgclose($alert_msg);
		}
		else
		{
			#$alert_msg = "전송완료되었습니다.".$sendno;

			if ( $receiveAdmin == 'y' || $senderAdmin == 'y' )
			{
				$alert_msg = "전송완료되었습니다.";
			}
			else
			{
				$alert_msg = "전송완료되었습니다.".$sendno;

				if ( $HAPPY_CONFIG['MessageSendPoint'] > 0 )
				{
					$alert_msg = "쪽지 발송으로 인해서 ".$TotalMessageSendPoint."포인트 차감합니다.";
				}
			}

			gomsg($alert_msg,"?mode=senderlist&adminMode=$_GET[adminMode]");
		}

	}




?>