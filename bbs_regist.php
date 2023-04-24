<?php


	#필드사용
	#bbs_etc2 : 댓글갯수
	#bbs_etc3 : 추천방지 ip
	#bbs_etc4 : 추천횟수
	#bbs_etc5 : 공백
	#bbs_etc6 : 미니 썸네일명
	#bbs_etc7 : 글쓴회원



	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");
	include ("./inc/happy_sms.php");



	if (admin_secure("게시판관리"))
	{
		$master_check = '1';
	}


	$sql1 = "select * from $board_list where tbname = '$tb'";
	$result1 = query($sql1);
	$B_CONF = happy_mysql_fetch_array($result1);

	#게시판의 list를 읽자
	$게시판상단 = $B_CONF[up];
	$게시판하단 = $B_CONF[down];

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

	// 공지게시물 출력 설정 - 16.10.26 - x2chi - notice_list_view
	if (admin_secure("게시판관리") && $B_CONF['notice_list_view'] )
	{
		$공지선택노출	= "";
	}
	else
	{
		$공지선택노출	= " style='display:none' ";
	}

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
		error("해당 테이블이 존재하지 않습니다 ");
		exit;
	}



	if( !(is_file("$skin_folder_bbs/$B_CONF[board_temp_regist]")) )
	{
		print "리스트페이지 $skin_folder_bbs/$B_CONF[board_temp_regist] 파일이 존재하지 않습니다. <br>";
		return;
	}




	#읽을수 있는 회원인가? 5/관리자 , 2/기업 , 1/회원
	if ($B_CONF[board_write] == '5')
	{
		$msg_title = '관리자';
	}
	elseif ($B_CONF[board_write] == '2')
	{
		$msg_title = '기업회원';
	}
	elseif ($B_CONF[board_write] == '1')
	{
		$msg_title = '개인회원';
	}
	else
	{
		$msg_title = '전체회원';
	}

	if (!admin_secure("게시판관리") )
	{
		if ( !happy_member_secure('%게시판%'.$tb.'-write') )
		{
			if ( $happy_member_login_value == "" )
			{
				gomsg("로그인이 필요한 페이지입니다.","happy_member_login.php");
				exit;
			}
			else
			{
				error ("글작성 권한이 없습니다.");
				exit;
			}
		}
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


	#show columns 시키자. 업그레이드시킴
	$sql = "show columns from $tb";
	$result = query ($sql);
	while ($COL = happy_mysql_fetch_array($result))
	{
		if ($COL[Field] == 'b_category' )
		{
			$new_board = '1';
		}
	}

	if (!$new_board && $tb)
	{
		$sql = "ALTER TABLE $tb
		modify `bbs_etc2` int( 5 ) NOT NULL ,
		modify `bbs_etc4` int( 5 ) NOT NULL ,

		ADD `phone` VARCHAR( 150 ) NOT NULL,
		ADD `hphone` VARCHAR( 150 ) NOT NULL,
		ADD `address` text NOT NULL,
		ADD `zip` varchar(10) NOT NULL,
		ADD `select1` varchar(100) NOT NULL,
		ADD `select2` varchar(100) NOT NULL,
		ADD `select3` varchar(100) NOT NULL,
		ADD `radio1` varchar(100) NOT NULL,
		ADD `radio2` varchar(100) NOT NULL,
		ADD `radio3` varchar(100) NOT NULL,
		ADD `text1` text NOT NULL,
		ADD `text2` text NOT NULL,
		ADD `text3` text NOT NULL,
		ADD `gou_number` varchar(50) NOT NULL,
		ADD `delivery` int(10) NOT NULL,
		ADD `money_in` int(10) NOT NULL,
		ADD `total_price` int(100) NOT NULL,

		ADD `b_category` VARCHAR( 150 ) NOT NULL,
		ADD `reply_stats` int( 10 ) NOT NULL,
		ADD `write_ip` varchar(100) NOT NULL,
		ADD `org_writer` varchar(100) NOT NULL,
		ADD `view_lock` int(1) NOT NULL,
		ADD `notice` int(1) NOT NULL


		";
		$result = query ($sql);
	}



	$sql = "select MAX(number) AS number from $tb";
	$result = query ($sql);
	$row = mysql_fetch_row($result);
	$groups = $row[0];
	if ( $groups == null ) { $groups=0; }
	else { $groups++; }


	#로그인회원정보 읽기
	$pass_display	= "";
	$pass_display2	= "";
	$pass_required	= "hname='비밀번호' required";
	if ($mem_id)
	{
		$sql			= "select * from $happy_member where user_id='$mem_id'";
		$result			= query($sql);
		$MEMBER			= happy_mysql_fetch_array($result);
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


if ( $mode == "add_ok" )
{
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
	#######################################################################################################

	//레퍼러 체크
	if ( happy_referer_check() == false )
	{
		exit;
	}


	#금지단어 체크
	if ( DenyWordCheck($_POST['bbs_title'],$TDenyWordList) )
	{
		msg(" 사용하실수 없는 금지단어가 제목에 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크

	#금지단어 체크
	if ( DenyWordCheck($_POST['bbs_review'],$TDenyWordList) )
	{
		msg(" 사용하실수 없는 금지단어가 게시글본문에 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크



	#관리자가 아닌데 게시글을 쓸 경우
	if ($master_check != '1' && $_POST[gong_ok] == '1')
	{
		msg('공지사항은 관리자 및 부관리자만 작성할수 있습니다.');
		exit;
	}
	$now_time = happy_mktime();

	//////////////////////////이미지 등록
	for ( $i=0;$i<10 ;$i++ )
	{
		if( $_FILES['img']['tmp_name'][$i] != '' )
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

					if ($B_CONF[img_width] <= $imagewidth && $B_CONF[img_width] > 0)
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



	$write_ip = getenv("REMOTE_ADDR");


	if (is_array($text1))
	{
		#복리는 1이없다
		$bokri_co = count($bokri_arr);
		for ( $h=0; $h<$bokri_co; $h++)
		{
			if ( $text1[$h] == "on" )
			{
				$guin_bokri .= "$bokri_arr[$h]>";
			}
		}
		$guin_bokri = substr($guin_bokri,0,-1);
		$text1 = $guin_bokri;
	}

	if (!$_POST[text1])
	{
		$text1 = $file_arr[3];
	}
	if (!$_POST[text2])
	{
		$text2 = $file_arr[4];
	}


	#게시판 업그레이드 함 2009-06-03 kad
	$write_ip = getenv("REMOTE_ADDR");
	if ($mem_id)
	{
		$bbs_id = $mem_id;
	}
	else
	{
		$bbs_id = '';
	}




	#스케쥴게시판일 경우 DB에 입력할 변수 생성
	if ( $B_CONF['admin_etc6'] == "스케쥴게시판" )
	{
		$sFullTime	= explode(' ', $_POST['startdate']);
		$startdate		= $sFullTime[0];		// 시,분,초를 제외한 년,월,일값만 추출

		$eFullTime	= explode(' ', $_POST['enddate']);
		$enddate		= $eFullTime[0];		// 시,분,초를 제외한 년,월,일값만 추출

		$barcolor		= "#".$_POST['barcolor'];
		$fontcolor		= "#".$_POST['fontcolor'];
	}

	if( $B_CONF['admin_etc6'] == '비밀형' && $_POST['gong_ok'] == '1' )
	{
		$view_lock = $_POST['view_lock'] = '';
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
	groups = '$groups',
	seq = '1',
	depth = '0',
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
	org_writer = '$org_writer',
	view_lock = '$view_lock',
	notice = '$_POST[gong_ok]',
	bbs_id = '$bbs_id',
	startdate = '$startdate',
	enddate = '$enddate',
	barcolor = '$barcolor',
	fontcolor = '$fontcolor'

	";
	$result = query($sql);


	if ( happy_member_secure('%게시판%'.$tb.'-write_close') && !admin_secure( '게시판관리' ) )
	{


		echo "<script type='text/javascript'>
				top.window.open('about:blank','_self');
				opener=window;
				top.window.close();
			</script>
		";
		exit;
	}

	//게시글등록시 지정된 회신번호, sms내용이 존재하면 발송해주자.
	if( ( trim($B_CONF[admin_sms_send]) == "1" || trim($B_CONF[admin_sms_send]) == "kakao" ) && trim($B_CONF[admin_sms_msg]) != "" && str_replace(" ", "", $B_CONF[admin_sms_phone]) != "" )
	{
		$Sql22	= "SELECT LAST_INSERT_ID();";
		$result22	= query($Sql22);
		list($board_number)= mysql_fetch_row($result22);
		$B_CONF[admin_sms_msg] = preg_replace("/{{게시판명}}/", $B_CONF[board_name], $B_CONF[admin_sms_msg]);
		$B_CONF[admin_sms_msg] = preg_replace("/{{글쓴이}}/", $bbs_name, $B_CONF[admin_sms_msg]);
		$B_CONF[admin_sms_msg] = preg_replace("/{{게시글제목}}/", $bbs_title, $B_CONF[admin_sms_msg]);
		$B_CONF[admin_sms_msg] = preg_replace("/{{링크}}/", $main_url."/bbs_detail.php?bbs_num=".$board_number."&tb=".$tb, $B_CONF[admin_sms_msg]);
		happy_sms_send_snoopy( $HAPPY_CONFIG[sms_userid], $HAPPY_CONFIG[sms_userpass], $B_CONF[admin_sms_phone], $site_phone, $B_CONF[admin_sms_msg], "", '', '', $B_CONF[admin_sms_send], $B_CONF[admin_sms_msg_ktplcode] );
	}


	#광고문의게시판(board_bannerreg) 이면 부모창을 메인으로
	if ( $tb == 'board_bannerreg' )
	{
		msg("신청내용이 잘 등록되었습니다. ");
		go_top("./bbs_list.php?category=$b_category&tb=$tb&pg=$pg&id=$bbs_etc7");
		/*
		echo "
		<script>
		if ( top.opener )
		{
			try
			{
				top.opener.location = './index.php';
				top.close();
			}
			catch (e)
			{
				top.location = './index.php';
			}
		}
		</script>
		";
		*/
		exit;
	}
	else
	{
		//echo "$sql";
		if ($bbs_etc7)
		{
			go_top("./bbs_list.php?category=$b_category&tb=$tb&pg=$pg&id=$bbs_etc7");
		}
		else
		{
			go_top("./bbs_list.php?category=$b_category&tb=$tb&pg=$pg");
		}
		exit;
	}
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
	if ( $master_check  )
	{
		$관리자로그인 = "<A HREF='./bbs_logout.php?id=$_GET[id]&tb=$tb'><img src='bbs_img/bt_admin_logout.gif' border=0 align=absmiddle></A>";
	}
	else
	{
		$관리자로그인 = "<A HREF='./admin/admin.php' target=_blank><img src='bbs_img/bt_admin_login.gif' border=0 align=absmiddle></A>";
	}



	#게시판읽기
	$sql = "select * from $tb where number='$bbs_num'";
	$result = query($sql);
	$BOARD = happy_mysql_fetch_array($result);


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



	#게시판버튼

$게시판버튼 = <<<END
<input type=hidden name=bbs_etc7 value='$_GET[id]'>
<A HREF='./bbs_list.php?tb=$tb&id=$_GET[id]' class='h_btn_b icon_b' uk-icon='icon:list; ratio:1'>목록보기</A><button class='h_btn_b icon_b h_btn_st1' uk-icon='icon:pencil; ratio:1'>글쓰기</button><a href='./bbs_regist.php?tb=$tb&id=$_GET[id]'  class='h_btn_b icon_b' uk-icon='icon:refresh; ratio:1'>다시쓰기</a>
END;

if ($B_CONF[category])
{
	$B_CONF[category] = str_replace("\r",'',$B_CONF[category]);
	$BOARD_CATE = split("\n",$B_CONF[category]);

	if ( $_COOKIE['happy_mobile'] == 'on' )
	{
		$category_info = make_selectbox2($BOARD_CATE,$BOARD_CATE,'',b_category,$_GET[b_category]);

		$category_select = <<<END
			<div class="bbs_reg_form_list">
				<span class="bbs_reg_form_title">카테고리선택</span>
				<span class="bbs_reg_form_info">$category_info</span>
			</div>
END;

		$category_select2 = $category_info;
	}
	else
	{
		$category_info = make_selectbox2($BOARD_CATE,$BOARD_CATE,'',b_category,$_GET[b_category]);

		$category_select = <<<END
			<tr>
				<th>카테고리선택</th>
				<td class="h_form">$category_info</td>
			</tr>
END;

		$category_select2 = $category_info;
	}
}


	$현재위치 = "$prev_stand_bbs >  <a href=bbs_list.php?&id=$_GET[id]&tb=$tb>$B_CONF[board_name]</a> > 글쓰기 ";

	$regi_startdate = "";
	if ( $_GET['regi_startdate'] != "" )
	{
		$regi_startdate = $_GET['regi_startdate'];
	}







	$TPL->define("게시판등록", "$skin_folder_bbs/$B_CONF[board_temp_regist]");
	$내용 = &$TPL->fetch();

	if( !(is_file("$large_template")) )
	{
		print "껍데기페이지 $large_template 파일이 존재하지 않습니다. <br>";
		return;
	}


	#오늘날짜 뽀너스로 구하기
	setlocale (LC_TIME, "ko_KR.UTF-8");
	$TPL->define("전체", "$large_template");
	$TPL->assign("전체");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();

?>