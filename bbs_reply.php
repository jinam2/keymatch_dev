<?php
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$sql1 = "select * from $board_list where tbname = '$tb'";
	$result1 = query($sql1);
	$B_CONF = happy_mysql_fetch_array($result1);


	if (  admin_secure("게시판관리")  )
	{
		$master_check = '1';
	}

	#게시판의 list를 읽자
	$게시판상단 = $B_CONF[up];
	$게시판하단 = $B_CONF[down];



	//실제 테이블이 있는가?
	$result3 = happy_mysql_list_tables("$db_name");
	while( list($ex_table) = mysql_fetch_row($result3) )
	{
		if ($ex_table == "$B_CONF[tbname]" )
		{
			$check_board = "1";
		}
	}

	if ($check_board != "1")
	{
		error("해당 테이블이 존재하지 않습니다");
		exit;
	}

	if (admin_secure("게시판관리"))
	{
		$공지선택노출	= "";
	}
	else
	{
		$공지선택노출	= " style='display:none' ";
	}

	if( !(is_file("$skin_folder_bbs/$B_CONF[board_temp_reply]")) )
	{
		print "리스트페이지 $skin_folder_bbs/$B_CONF[board_temp_reply] 파일이 존재하지 않습니다. <br>";
		return;
	}


	#읽을수 있는 회원인가?
	if ( $master_check !='1'  )
	{
		if ( !happy_member_secure('%게시판%'.$tb.'-reply') )
		{
			if ( $happy_member_login_value == "" )
			{
				gomsg("로그인이 필요한 페이지입니다.","happy_member_login.php");
				exit;
			}
			else
			{
				error ("접속권한이 없습니다.");
				exit;
			}
		}
	}


	#관리자가 아닌데 게시글을 쓸 경우
	if ($_GET[top_gonggi] == '1')
	{
		error('공지사항에 대한 답변글은 작성하실수 없습니다.   ');
		exit;
	}

	if ( !(is_writable("./data")) )
	{
		error("data 폴더의 퍼미션을 777로 조정하세요");
	}
	if ( !(file_exists("./data/$tb")))
	{
		mkdir("./data/$tb", 0777);
	}
	if ( !(is_writable("./data/$tb")) )
	{
		error("./data/$tb 폴더의 퍼미션을 777로 조정하세요");
	}

	#게시판읽기
	$sql = "select * from $tb where number='$bbs_num'";
	$result = query($sql);
	$BOARD = happy_mysql_fetch_array($result);

	//$BOARD[bbs_review] =str_replace("\n",'',$BOARD[bbs_review]);
	//$BOARD[bbs_review] =str_replace("\r",'',$BOARD[bbs_review]);
	//$BOARD[bbs_review] =str_replace("'",'"',$BOARD[bbs_review]);
	$BOARD[bbs_title] =str_replace("'",'"',$BOARD[bbs_title]);

	#######################################################################################################
	# 도배방지키 : NeoHero 2009.08.01
	#######################################################################################################
	$dobae_1 = rand(1,9);$dobae_2 = rand(1,9);$dobae_3 = rand(1,9);$dobae_4 = rand(1,9);
	$gara1 = "<font color=#ffffff>".rand(0,9)."</font>";
	$gara2 = "<font color=#ffffff>".rand(0,9)."</font>";
	$gara3 = "<font color=#ffffff>".rand(0,9)."</font>";
	$gara4 = "<font color=#ffffff>".rand(0,9)."</font>";
	$rand1 = rand(100,9000);
	$rand2 = rand(100,9000);
	$rand3 = rand(100,9000);
	$rand4 = rand(100,9000);
	@eval('$dobae_org =' .$dobae_1.$dobae_2.$dobae_3.$dobae_4. ';');
	$dobae_org = $dobae_number - $dobae_org;
	$BOARD[bbs_dobae] = "&nbsp;" . $dobae_1 . "$gara1<img src=img/dot.gif name=bbs_name0 $rand1><span style=disply:none bt_adminlogout_login></span>" .
									 $dobae_2 . "$gara2<img src=img/dot.gif name=pass happycgi.com=test$rand2>" .
									 $dobae_3 . "$gara3<img src=img/dot.gif name=email happycgi.com=cgimall.co.kr-$rand3>" .
									 $dobae_4 . "$gara4<img src=img/dot.gif name=comment happycgi.com=$rand4>" ;
	#######################################################################################################

	#권한이 없는자는 인용글이 나오지 않도록 하자.
	$view_lock_chk	= "no";
	if ( $mem_id != '' && $mem_id == $BOARD['bbs_id'] )
	{
		#자신의글에 권한획득
		$view_lock_chk = "yes";
	}
	elseif ( $mem_id != '' )
	{
		#회원이면 원본글을 조사하여 권한획득
		$uDepth	= $BOARD['depth'] - 1;
		$Sql	= "SELECT bbs_name FROM $tb WHERE groups='$BOARD[groups]' AND ( depth='$uDepth' or depth='0' )";
		$rTmp	= query($Sql);

		while ( $Tmp = happy_mysql_fetch_array($rTmp) )
		{
			if ( $Tmp[0] == $mem_id )
			{
				$view_lock_chk	= "yes";
			}
		}
	}


if ($view_lock_chk == 'no')
{
	$BOARD[bbs_review_re] = '';
}
else
{
		$BOARD[bbs_review_re] = <<<END
		<font style="font-size:11px"><b>인용글</b></font>
		<table cellspacing=0 cellpadding=2 bordercolorlight="black" bordercolordark="#FFFFFF" bgcolor="#FFFFFF" border=1 > <tr bgcolor=#f4f4f4><td>$BOARD[bbs_review]</td></tr></table>
END;
	//$BOARD[bbs_review_re] = str_replace("\n",'',$BOARD[bbs_review_re]);
	//$BOARD[bbs_review_re] = str_replace("\r",'',$BOARD[bbs_review_re]);
}




	if ($_GET[id])
	{
		$add_search_board = "and bbs_etc7 = '$_GET[id]' ";
		$add_search_page = "&id=$_GET[id]";
		$plus .= "&id=$_GET[id]";
		$add_normal_board = "where bbs_etc7 = '$_GET[id]'";

		$sql = "select * from $happy_member where user_id='$_GET[id]'";
		$result = query($sql);
		$DEAL = happy_mysql_fetch_array($result);
		$large_template = "$minihome_folder/".$DEAL[minihome_template];
	}
	else
	{
		$large_template = "$skin_folder_bbs/".$B_CONF[board_temp];
	}

	if (!$master_check)
	{
		if ( $BOARD['view_lock'] )
		{
			$BOARD[bbs_review] = '본글은 잠긴글입니다.';
		}
	}

	#로그인회원 정보 가져오기
	$pass_display	= "";
	$pass_display2	= "";
	$pass_required	= "hname='비밀번호' required";
	if ($mem_id)
	{
		$sql		= "select * from $happy_member where user_id='$mem_id'";
		$result		= query($sql);
		$MEMBER		= happy_mysql_fetch_array($result);

		$readonly		= "readonly";
		if ($MEMBER['user_pass'] != "")
		{
			$pass_display	= "style='display:none;'";
			$pass_display2	= "display:none;";
			$pass_required	= "";
			$MEMBER['pass']	= $MEMBER['user_pass'];
		}

		$MEMBER['id']		= $MEMBER['user_id'];
		$MEMBER['email']	= $MEMBER['user_email'];

		//이메일 필드 분리 - 2019-08-30 hong
		if ( $MEMBER['user_email'] != "" )
		{
			list($MEMBER['user_email_at_user'],$MEMBER['user_email_at_host']) = explode("@",$MEMBER['user_email']);
		}
		//이메일 필드 분리 - 2019-08-30 hong
	}

	//이메일 필드 분리 - 2019-08-30 hong
	$happy_board_email_host			= explode("\r\n",$happy_board_email_host);
	$happy_board_email_options		= "";

	foreach ( $happy_board_email_host as $email_host )
	{
		$selected = ( $email_host == $MEMBER['user_email_at_host'] ) ? "selected" : "";
		$happy_board_email_options		.= "<option value='$email_host' $selected>$email_host</option>";
	}
	//이메일 필드 분리 - 2019-08-30 hong






if ( $mode == "reply_ok" )
{
	$now_time = happy_mktime();

	#######################################################################################################
	# 도배방지키 : NeoHero 2009.08.01
	#######################################################################################################
	if (!$_POST[dobae])
	{
		msg('도배방지키를 입력하세요');
		exit;
	}
	$_POST[dobae] = preg_replace('/\D/', '', $_POST[dobae]);
	$G_dobae = $_POST[dobae_org] + $_POST[dobae];


	if ( $G_dobae != $dobae_number || strlen($_POST[dobae]) != 4  )
	{
		msg('도배방지키를 정확히 입력하세요   ');
		exit;
	}
	#######################################################################################################x1

	//////////////////////////이미지 등록
	for ( $i=0;$i<10 ;$i++ )
	{
		if( $_FILES['img']['name'][$i] != "" )
		{
			$rand_number =  rand(0,100);
			$temp_name = explode(".",$_FILES['img']['name'][$i]);
			$ext = strtolower($temp_name[sizeof($temp_name)-1]);
			$img_url_re = "$now_time-$rand_number.$ext";
			$img_url_re_thumb = "$now_time-$rand_number-thumb.$ext";

			if ( $ext=="html" || $ext=="htm" || $ext=="php" || $ext=="cgi" || $ext=="inc" || $ext=="php3" || $ext=="pl" )
			{
				msg("jpg,gif,jpeg 확장자만 등록할수 있습니다.");
				exit;
			}

			$_FILES['img']['tmp_name'][$i]		= HAPPY_EXIF_READ_CHANGE($_FILES['img']['tmp_name'][$i]);

			if (copy($_FILES['img']['tmp_name'][$i],"$path/data/$tb/$img_url_re"))
			{
				if ($gi_joon && eregi('.jp',$img_url_re)  )
				{
					if ($B_CONF[mini_thumb])
					{
						#썸네일은 다 만들자
						#추출썸네일을 만들어보자
						$imagehw = GetImageSize("$path/data/$tb/$img_url_re");
						$imagewidth = $imagehw[0];
						$imageheight = $imagehw[1];
						$new_height = $imageheight * $B_CONF[mini_thumb] / $imagewidth ;
						$new_height=ceil($new_height);
						$new_width = $B_CONF[mini_thumb];
						$src = ImageCreateFromJPEG("$path/data/$tb/$img_url_re");
						$thumb2 = ImageCreate($new_width,$new_height);
						$thumb2 = imagecreatetruecolor($new_width,$new_height);
						imagecopyresampled($thumb2,$src,0,0,0,0,$new_width,$new_height,imagesx($src),imagesy($src));
						ImageJPEG($thumb2,"$path/data/$tb/$img_url_re_thumb",90);
						ImageDestroy($thumb2);
					}

					if ($B_CONF[img_width] <= $imagewidth)
					{
						#게시판설정된 이미지보다 클때만
						#썸네일을 만들어보자
						$imagehw = GetImageSize("$path/data/$tb/$img_url_re");
						$imagewidth = $imagehw[0];
						$imageheight = $imagehw[1];
						$new_height = $imageheight * $B_CONF[img_width] / $imagewidth ;
						$new_height=ceil($new_height);
						$new_width = $B_CONF[img_width];
						$src = ImageCreateFromJPEG("$path/data/$tb/$img_url_re");
						$thumb = ImageCreate($new_width,$new_height);
						$thumb = imagecreatetruecolor($new_width,$new_height);
						imagecopyresampled($thumb,$src,0,0,0,0,$new_width,$new_height,imagesx($src),imagesy($src));
						#새 이미지에 글자위치 정하자
						if( is_file($Logo_Img_Name) !== false )
						{
							$logo = ImageCreateFromPng($Logo_Img_Name);
							$logo_width = imagesx($logo);
							$logo_height = imagesy($logo);
							imagecopy($thumb,$logo,0,$new_height-$logo_height,0,0,$logo_width,$logo_height);
							ImageJPEG($thumb,"$path/data/$tb/$img_url_re",90);
							ImageDestroy($thumb);
							ImageDestroy($logo);
						}
					}
				}

				unlink( $_FILES['img']['tmp_name'][$i]);
				$file_arr[$i] = "$now_time-$rand_number.$ext";
				if ($i == '0' && $B_CONF[mini_thumb] )
				{
					#한개만
					if (preg_match("/\.jp/i",$img_url_re))
					{
						$extract_thumb = "$now_time-$rand_number-thumb.$ext";
					}
					elseif (preg_match("/\.gif/i",$img_url_re))
					{
						$extract_thumb = "$now_time-$rand_number.$ext";
					}
				}

			}
		}
	}



	$sql = "update $tb set seq = seq + 1 where groups = '$BOARD[groups]' and seq > '$BOARD[seq]'";
	$result = query($sql);
	$BOARD[seq] ++;
	$BOARD[depth] ++;

#$sql = "insert into $tb values('','$bbs_name','$bbs_pass','$bbs_email','$bbs_title','','$bbs_review','0',now(),'$BOARD[groups]','$BOARD[seq]',
#'$BOARD[depth]','$file_arr[0]','','','',''	,'$file_arr[1]','$file_arr[2]','','$bbs_etc7')";

	$write_ip = getenv("REMOTE_ADDR");
	if ($mem_id)
	{
		$bbs_id = $mem_id;
	}
	else
	{
		$bbs_id = '';
	}

	if (!$text1)
	{
		$text1 = $file_arr[3];
	}
	if (!$text2)
	{
		$text2 = $file_arr[4];
	}

	if ( $b_category == '' )
	{
		$Sql	= "SELECT b_category FROM $tb WHERE number = '$bbs_num' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		$b_category	= $Tmp[0];
	}

	#넘어온 비밀번호 없을때
	if ($mem_id != '' && $bbs_pass == "" && $MEMBER['user_pass'] != "")
	{
		$bbs_pass	= $MEMBER['user_pass'];
	}

	$sql = "insert into $tb set
	bbs_name = '$bbs_name',
	bbs_pass = '$bbs_pass',
	bbs_email = '$bbs_email',
	bbs_title = '$bbs_title',
	bbs_img = '$bbs_img',
	bbs_review = '$bbs_review',
	bbs_count = '$bbs_count',
	bbs_date = now(),
	groups = '$BOARD[groups]',
	seq = '$BOARD[seq]',
	depth = '$BOARD[depth]',
	bbs_etc1 = '$file_arr[0]',
	bbs_etc2 = '$bbs_etc2',
	bbs_etc3 = '$bbs_etc3',
	bbs_etc4 = '$bbs_etc4',
	bbs_etc5 = '$bbs_etc5',
	bbs_attach2 = '$file_arr[1]',
	bbs_attach3 = '$file_arr[2]',
	bbs_etc6 = '$extract_thumb',
	bbs_etc7 = '$bbs_etc7',
	phone = '$phone',
	hphone = '$hphone',
	address = '$address',
	zip = '$zip',
	select1 = '$select1',
	select2 = '$select2',
	select3 = '$select3',
	radio1 = '$radio1',
	radio2 = '$radio2',
	radio3 = '$radio3',
	text1 = '$text1',
	text2 = '$text2',
	text3 = '$text3',
	gou_number = '$gou_number',
	delivery = '$delivery',
	money_in = '$money_in',
	total_price = '$total_price',
	b_category = '$b_category',
	reply_stats = '$reply_stats',
	write_ip = '$write_ip',
	org_writer = '$BOARD[bbs_id]',
	view_lock = '$view_lock',
	notice = '$notice',
	bbs_id = '$bbs_id'
	";
	$result = query($sql);


	#게시글에 답변이 달렸을 경우 원본글작성자에게 SMS보내기 2009-09-17 kad
	$org_writer = $BOARD['bbs_id'];

	$sql = "select * from ".$happy_member." where user_id = '".$org_writer."'";
	$result = query($sql);
	$Tmem = happy_mysql_fetch_assoc($result);

	$Tmem['hphone'] = $Tmem['user_hphone'];
	$Tmem['name'] = $Tmem['user_name'];



	if ( $HAPPY_CONFIG['SmsBoardReplyUse'] == '1' || $HAPPY_CONFIG['SmsBoardReplyUse'] == 'kakao' )
	{
		if ( $Tmem['sms_forwarding'] == 'y' )
		{
			if ( $Tmem['user_hphone'] != '' )
			{
				$받는번호 = $Tmem['user_hphone'];
				$받는아이디 = $Tmem['user_id'];

				#sms_convert($sms_text,$per_name='',$or_no='',$stats='',$per_pass='',$per_cell='',$product_name='',$etc='',$confirm_number='',$per_id = '')
				#문자보낼문자열,이름,주문번호,상태,비밀번호,휴대폰번호,상품명,기타,인증번호,아이디
				$SMSMSG["SmsBoardReply"] = sms_convert($HAPPY_CONFIG["SmsBoardReply"],'','','','',$site_phone,'','','',$받는아이디);

				#사용법 echo sms_send(전송후반응타입,받을사람전번,회신전번,전송후이동주소,sms메세지,암호화여부(on/off));
				//echo $regist_send = sms_send(0,$받는번호,$site_phone,"",$SMSMSG["SmsBoardReply"],"1000","","",$HAPPY_CONFIG['SmsBoardReplyUse'],$HAPPY_CONFIG['SmsBoardReply_ktplcode']);
				$dataStr = send_sms_msg($sms_userid,$받는번호,$site_phone,$SMSMSG['SmsBoardReply'],5,$sms_testing,'',$HAPPY_CONFIG['SmsBoardReplyUse'],$HAPPY_CONFIG['SmsBoardReply_ktplcode']);
				send_sms_socket($dataStr);
				#gomsg("아이디를 SMS문자로 발송했습니다.","index.php");
			}
		}
	}

	#게시글에 답변이 달렸을 경우 원본글작성자에게 SMS보내기 2009-09-17 kad
	if ( $HAPPY_CONFIG['MessageBoardReplyUse'] == '1' )
	{
		$HAPPY_CONFIG['MessageBoardReply'] = str_replace("{{아이디}}",$org_writer,$HAPPY_CONFIG['MessageBoardReply']);

		$HAPPY_CONFIG['MessageBoardReply'] = addslashes($HAPPY_CONFIG['MessageBoardReply']);

		$sql = "INSERT INTO ";
		$sql.= $message_tb." ";
		$sql.= "SET ";
		$sql.= "sender_id = '".$admin_id."', ";
		$sql.= "sender_name = '관리자', ";
		$sql.= "sender_admin = 'y', ";
		$sql.= "receive_id = '".$Tmem['user_id']."', ";
		$sql.= "receive_name = '".$Tmem['user_name']."', ";
		$sql.= "receive_admin = 'n', ";
		$sql.= "message = '".$HAPPY_CONFIG['MessageBoardReply']."', ";
		$sql.= "regdate = now() ";
		//echo $sql;

		query($sql);
	}
	#게시글에 답변이 달렸을 경우 원본글작성자에게 쪽지보내기 2009-09-17 kad

	if ($bbs_etc7)
	{
		go_top("./bbs_list.php?tb=$tb&pg=$pg&id=$bbs_etc7");
	}
	else
	{
		go_top("./bbs_list.php?tb=$tb&pg=$pg");
	}
	exit;
}


	#게시판정보
	if ($B_CONF[board_write] == "0")
	{
		$게시판권한 = "공개게시판";
	}
	elseif ($B_CONF[board_write] == "1")
	{
		$게시판권한 = "회원이상쓰기";
	}
	elseif ($B_CONF[board_write] == "2")
	{
		$게시판권한 = "딜러이상쓰기";
	}
	elseif ($B_CONF[board_write] == "5")
	{
		$게시판권한 = "관리자전용쓰기";
	}
	else
	{
		$게시판권한 = "머죠!";
	}

	#관리자 로그인정보
	if ( admin_secure("게시판관리")  )
	{
		$관리자로그인 = "<A HREF='./bbs_logout.php?id=$_GET[id]&tb=$tb'><img src='bbs_img/bt_admin_logout.gif' border=0 align=absmiddle></A>";
	}
	else
	{
		$관리자로그인 = "<img src='bbs_img/bt_admin_login.gif' border=0 align=absmiddle>";
	}

	#게시판버튼
	$reply_button = $HAPPY_CONFIG['IconReply2'];
	$list_button = $HAPPY_CONFIG['IconList1'];

#게시판버튼
$게시판버튼 = <<<END
<input type=hidden name=bbs_etc7 value='$_GET[id]'>
<a href='./bbs_list.php?b_category=$b_category&pg=$pg&id=$_GET[id]&tb=$tb' class='h_btn_b icon_b' uk-icon='icon:list; ratio:1'>목록보기</a><button class="h_btn_b icon_b h_btn_st1" uk-icon="icon:pencil; ratio:1">답변</button>
END;

	$현재위치 = "$prev_stand_bbs >  <a href=bbs_list.php?&id=$_GET[id]&tb=$tb>$B_CONF[board_name]</a> > 답변하기 ";

	$BOARD['bbs_review']	= "<div style=\"border:1px solid #dbdbdb; background:#f4f4f4; padding:10px;\"><div style=\"margin-bottom:5px;\"><strong>인용글</strong></div><div>{$BOARD['bbs_review']}</div></div><br>";


	$TPL->define("게시판답변", "$skin_folder_bbs/$B_CONF[board_temp_reply]");
	$내용 = &$TPL->fetch();


	#오늘날짜 뽀너스로 구하기
	setlocale (LC_TIME, "ko_KR.UTF-8");
	$TPL->define("전체", "$large_template");
	$TPL->assign("전체");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();

?>