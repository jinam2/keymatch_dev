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


	#관리자 로그인정보
	if ( admin_secure("게시판관리")  )
	{
		$관리자로그인 = "<A HREF='./bbs_logout.php?id=$_GET[id]&num=$num&tb=$tb'><img src='bbs_img/bt_admin_logout.gif' border=0 align=absmiddle></A>";
		$master_check = '1';
	}
	else
	{
		$관리자로그인 = "<A HREF='./admin/' target=_blank><img src='bbs_img/bt_admin_login.gif' border=0 align=absmiddle></A>";
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

	if( !(is_file("$skin_folder_bbs/$B_CONF[board_temp_detail]")) )
	{
		print "리스트페이지 $skin_folder_bbs/$B_CONF[board_temp_detail] 파일이 존재하지 않습니다. <br>";
		return;
	}


	#읽을수 있는 회원인가?
	if ($master_check != "1")
	{
		if ( !happy_member_secure('%게시판%'.$tb.'-modify') )
		{
			if ( $happy_member_login_value == "" )
			{
				gomsg("로그인이 필요한 페이지입니다.","happy_member_login.php");
				exit;
			}
			else
			{
				error ("\\n\'$B_CONF[board_name]\' 수정 권한이 없습니다.");
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



	#게시판읽기
	$sql = "select * from $tb where number='$bbs_num'";
	$result = query($sql);
	$BOARD = happy_mysql_fetch_array($result);

	if ( $B_CONF['admin_etc6'] == "스케쥴게시판" ) {
		$시작날짜	= $BOARD['startdate'];
		$끝날짜		= $BOARD['enddate'];

		$BOARD['barcolor']		= $BOARD['barcolor'];
		$BOARD['barcolor_noshop']		= str_replace("#","",$BOARD['barcolor']);
		$BOARD['fontcolor']		= $BOARD['fontcolor'];
		$BOARD['fontcolor_noshop']		= str_replace("#","",$BOARD['fontcolor']);
		//print_r($GetMycolor1);
	}

	$notice_check	= ( $BOARD['notice'] == '1' ) ? 'checked' : '';

	//뉴스상점 START
	if ( $BOARD['news_gongu'] == "1" )
	{
		$news_store_alert = "
		<!-- newsstorealert -->
		<img src='http://newsstore.co.kr/img/news_detail_anne.gif' alt='안내'>


		<!-- newsstorealert -->
		";

		$BOARD['bbs_review'] = preg_replace("/<!--\snewsstorealert\s-->(.*?)<!--\snewsstorealert\s-->/is","",$BOARD['bbs_review']);

		//echo $Data['bbs_review'];exit;
		$BOARD['bbs_review'] = $news_store_alert;
	}
	//뉴스상점 END


	#글잠금추가
	if ($BOARD[view_lock])
	{
		$BOARD[view_lock_info] = 'checked';
	}

	/*	2022-05-27 hun	MOBILE 에서 작성한 글 PC에서 수정시 문제 발생함. 그래서 수정할 수 있도록 변경 및 PC에서 등록하거나 수정한 글을 MOBILE에서 수정할 수 없도록 제한함.
	if ( $_COOKIE['happy_mobile'] == 'on' )
	{
		$BOARD[bbs_review] = strip_tags($BOARD[bbs_review]);
	}
	else
	{
		//$BOARD[bbs_review] =str_replace("\n",'\\n',$BOARD[bbs_review]);
		//$BOARD[bbs_review] =str_replace("\r",'\\r',$BOARD[bbs_review]);
		//$BOARD[bbs_review] =str_replace("'","\\'",$BOARD[bbs_review]);
	}
	*/
	if ( $_COOKIE['happy_mobile'] == 'on' )
	{
		$BOARD[bbs_review_org] = $BOARD[bbs_review];
		$BOARD[bbs_review] = strip_tags($BOARD[bbs_review]);

		if( $BOARD[bbs_review_org] != $BOARD[bbs_review] ){
			error("PC에서 작성 또는 수정한 글은 모바일에서 수정할 수 업습니다.\\nPC에서 수정해 주세요."); exit;
		}
	}
	else
	{
		if( preg_match('/<\s?[^\>]*\/?\s?>/i', $BOARD['bbs_review']) == false )
		{
			$BOARD['bbs_review']	= nl2br($BOARD['bbs_review']);
		}
		//$BOARD[bbs_review] =str_replace("\n",'\\n',$BOARD[bbs_review]);
		//$BOARD[bbs_review] =str_replace("\r",'\\r',$BOARD[bbs_review]);
		//$BOARD[bbs_review] =str_replace("'","\\'",$BOARD[bbs_review]);
	}
	$BOARD[bbs_title] =str_replace("'",'"',$BOARD[bbs_title]);

	#첨부파일이 있으면 미리보기
	#이미지필드선언
	$attach_array = array('bbs_etc1','bbs_attach2','bbs_attach3','text1','text2');
	foreach ($attach_array as $list)
	{
		if ( preg_match("/\.gif|\.jp/i", $BOARD[$list]) )
		{
			$tmp_array_name_p = $list . "_preview";

			$temp_name = explode(".",$BOARD[$list]);
			$ext = strtolower($temp_name[sizeof($temp_name)-1]);
			$t_file_name = strtolower($temp_name[sizeof($temp_name)-2]);
			$org_file_name = "$t_file_name.$ext";
			if ( preg_match("/\.jp/i", $BOARD[$list]) )
			{
				#jpg thumb 불러냄
				$main_img_temp = "./data/$tb/${t_file_name}-thumb.$ext";
			}
			else
			{
				#gif는 원본을 불러냄
				$main_img_temp = "./data/$tb/$t_file_name.$ext";
			}

			$BOARD[$tmp_array_name_p] = "<img src=bbs_img/icon_exphoto.gif align=absmiddle border=0 onMouseover=\"ddrivetip('<IMG src=\'$main_img_temp\' border=0 width=200>','white', 200)\"; onMouseout=\"hideddrivetip()\">";

			//$BOARD[$tmp_array_name_p] = "";
		}
	}

	#첨부파일이 있으면 첨부파일 삭제를 보여주자.
	if ( $BOARD[bbs_etc1] != "" )
	{
		$BOARD[bbs_etc1_del] = "
			<div class='h_form noto400' style='margin-top:3px;'><img src='bbs_img/data3.gif' align='absmiddle'> 첨부파일 : &nbsp;$BOARD[bbs_etc1]
			<label for='bbs_etc1_del' class='h-check'><input type='checkbox' name='bbs_etc1_del' value='y' id='bbs_etc1_del' style='vertical-align:middle; margin-right:3px;'><span class='noto400'>파일삭제</span></label></div>
		";
	}
	if ( $BOARD[bbs_attach2] != "" )
	{
		$BOARD[bbs_attach2_del] .= "
			<div class='h_form noto400' style='margin-top:3px;'><img src='bbs_img/data3.gif' align='absmiddle'> 첨부파일 : &nbsp;$BOARD[bbs_attach2]
			<label for='bbs_attach2_del' class='h-check'><input type='checkbox' name='bbs_attach2_del' value='y' id='bbs_attach2_del' style='vertical-align:middle; margin-right:3px;'><span class='noto400'>파일삭제</span></label></div>
		";
	}
	if ( $BOARD[bbs_attach3] != "" )
	{
		$BOARD[bbs_attach3_del] .= "
			<div class='h_form noto400' style='margin-top:3px;'><img src='bbs_img/data3.gif' align='absmiddle'> 첨부파일 : &nbsp;$BOARD[bbs_attach3]
			<label for='bbs_attach3_del' class='h-check'><input type='checkbox' name='bbs_attach3_del' value='y' id='bbs_attach3_del' style='vertical-align:middle; margin-right:3px;'><span class='noto400'>파일삭제</span></label></div>
		";
	}
	if ( $BOARD[text1] != "" )
	{
		$BOARD[text1_del] .= "
			<div style='margin-top:3px;'><img src='bbs_img/data3.gif' align='absmiddle'> 첨부파일 : &nbsp;$BOARD[text1]
			<input type='checkbox' name='text1_del' value='y' id='text1_del' style='vertical-align:middle; margin-right:3px;'><label for='text1_del' style='cursor:pointer'>파일삭제</label></div>
		";
	}
	if ( $BOARD[text2] != "" )
	{
		$BOARD[text2_del] .= "
			<div style='margin-top:3px;'><img src='bbs_img/data3.gif' align='absmiddle'> 첨부파일 : &nbsp;$BOARD[text2]
			<input type='checkbox' name='text2_del' value='y' id='text2_del' style='vertical-align:middle; margin-right:3px;'><label for='text2_del' style='cursor:pointer'>파일삭제</label></div>
		";
	}



	if ($_GET[id])
	{
		$add_search_board = "and bbs_etc7 = '$_GET[id]' ";
		$add_search_page = "&id=$_GET[id]";
		$plus .= "&id=$_GET[id]";
		$add_normal_board = "where bbs_etc7 = '$_GET[id]'";

		$sql = "select *  from $links where minihome_id='$_GET[id]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);

		if ($DETAIL[id] == $_COOKIE[member_id])
		{
			$master_check = '1';
		}

		$large_template = "$minihome_folder/".$DETAIL[minihome_default];
	}
	else
	{
		$large_template = "$skin_folder_bbs/".$B_CONF[board_temp];
	}

	#라디오버튼에 대한 대비
	if ($BOARD[radio1])
	{
		$BOARD[radio1_check] = "checked";
	}
	else
	{
		$BOARD[radio0_check] = "checked";
	}

	#게시판의 list를 읽자
	$게시판상단 = $B_CONF[up];
	$게시판하단 = $B_CONF[down];



	#로그인회원정보 읽기
	$pass_display	= "";
	$pass_display2	= "";
	$pass_required	= "hname='비밀번호' required";
	if ($mem_id)
	{
		$sql = "select * from $happy_member where user_id='$mem_id'";
		$result = query($sql);
		$MEMBER = happy_mysql_fetch_array($result);

		$MEMBER['id']		= $MEMBER['user_id'];
		$MEMBER['pass']		= $MEMBER['user_pass'];
		$MEMBER['email']	= $MEMBER['user_email'];

		$readonly		= "readonly";
		$pass_display	= "style='display:none;'";
		$pass_display2	= "display:none;";
		$pass_required	= "";
	}

	//이메일 필드 분리 - 2019-08-30 hong
	if ( $BOARD['bbs_email'] != "" )
	{
		list($BOARD['bbs_email_at_user'],$BOARD['bbs_email_at_host']) = explode("@",$BOARD['bbs_email']);
	}

	$happy_board_email_host			= explode("\r\n",$happy_board_email_host);
	$happy_board_email_options		= "";

	foreach ( $happy_board_email_host as $email_host )
	{
		$selected = ( $email_host == $BOARD['bbs_email_at_host'] ) ? "selected" : "";
		$happy_board_email_options		.= "<option value='$email_host' $selected>$email_host</option>";
	}
	//이메일 필드 분리 - 2019-08-30 hong


	#관리자도 아니고,글쓴이도 아니라면 비밀번호를 보자
	if ($B_CONF[board_write] >= "1")
	{
		if ($BOARD[bbs_id] == $mem_id && $mem_id)
		{
			$mod_ok = "1";
		}
	}


	#본인작성
	if ($mem_id == $BOARD[bbs_id] && $BOARD[bbs_id])
	{
		$mod_ok = "1";
	}

	#인증 변수를 두개를 사용 : 2009.05.10 NeoHero
	if ($mod_ok == '1')
	{
		$master_check = '1';
	}
	if ($master_check == '1')
	{
		$mod_ok = '1';
	}

	if ($master_check == '1')
	{
		$mod_ok = "1";
	}
	if ($bbs_pass == $BOARD[bbs_pass])
	{
		$mod_ok = "1";
	}
	//if ($bbs_pass == $B_CONF[board_pass]){	$mod_ok = "1";}
	//if ($mod_ok != '1'){error("게시글의 비밀번호가 틀렸거나 수정할 권한이 없습니다  ");exit;}

	if ($mod_ok == '1')
	{
		$BOARD[bbs_pass_input] = $BOARD[bbs_pass];
	}


if ( $mode == "mod_ok" )
{
	#금지단어 체크
	if ( DenyWordCheck($_POST['bbs_title'],$TDenyWordList) )
	{
		error(" 사용하실수 없는 금지단어가 제목에 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크

	#금지단어 체크
	if ( DenyWordCheck($_POST['bbs_review'],$TDenyWordList) )
	{
		error(" 사용하실수 없는 금지단어가 게시글본문에 포함되어 있습니다.");
		exit;
	}
	#금지단어 체크


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
				error("jpg,gif,jpeg 확장자만 등록할수 있습니다.");
				exit;
			}

			$_FILES['img']['tmp_name'][$i]		= HAPPY_EXIF_READ_CHANGE($_FILES['img']['tmp_name'][$i]);

			if (copy($_FILES['img']['tmp_name'][$i],"$path/data/$tb/$img_url_re"))
			{
				if (preg_match("/\.jp/i",$img_url_re)  )
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
						ImageJPEG($thumb2,"$path/data/$tb/$img_url_re_thumb",$picture_quality);
						ImageDestroy($thumb2);
					}


					if ($B_CONF[img_width])
					{
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
							ImageJPEG($thumb,"$path/data/$tb/$img_url_re",$picture_quality);
							ImageDestroy($thumb);
							ImageDestroy($logo);
						}
					}
				}

				unlink( $_FILES['img']['tmp_name'][$i]);
				$file_arr[$i] = "$now_time-$rand_number.$ext";
				if ($i == '0' && $B_CONF[mini_thumb] ){ #한개만
					if (preg_match("/\.jp/i",$img_url_re)){
					$extract_thumb = "$now_time-$rand_number-thumb.$ext";
					}
					elseif (preg_match("/\.gif/i",$img_url_re)){
					$extract_thumb = "$now_time-$rand_number.$ext";
					}
				}

			}
		}
	}


	$img_update = "";
	if ( $_POST['bbs_etc1_del'] == 'y' )
	{
		$img_update1 = "bbs_etc1 = '' , ";
	}

	if ( $_POST['bbs_attach2_del'] == 'y' )
	{
		$img_update2 = "bbs_attach2 = '' , ";
	}

	if ( $_POST['bbs_attach3_del'] == 'y' )
	{
		$img_update3 = "bbs_attach3 = '' , ";
	}

	if ( $_POST['text1_del'] == 'y' )
	{
		$img_update4 = "text1 = '' , ";
	}

	if ( $_POST['text2_del'] == 'y' )
	{
		$img_update5 = "text2 = '' , ";
	}



	if ($file_arr[0])
	{
		$img_update1 = "bbs_etc1 = '$file_arr[0]' , ";
	}
	if ($file_arr[1])
	{
		$img_update2 = "bbs_attach2 = '$file_arr[1]' , ";
	}
	if ($file_arr[2])
	{
		$img_update3 = "bbs_attach3 = '$file_arr[2]' , ";
	}


	/*
	if (!$_POST[text1] && $file_arr[3])
	{
		$img_update4 = "text1 = '$file_arr[3]' , ";
	}
	else if ($_POST[text1])
	{
		$img_update4 = "text1 = '$_POST[text1]' , ";
	}
	*/

	if (!$_POST[text2] && $file_arr[4])
	{
		$img_update5 = "text2 = '$file_arr[4]' , ";
	}
	else if ($_POST[text2])
	{
		$img_update5 = "text2 = '$_POST[text2]' , ";
	}

	if ($extract_thumb)
	{
		$img_update6 = "bbs_etc6 = '$extract_thumb' , ";
	}


	#$sql = "update $tb set $img_update1 $img_update2 $img_update3
	#bbs_name='$bbs_name',bbs_email='$bbs_email',bbs_pass='$bbs_pass',bbs_title='$bbs_title',bbs_review='$bbs_review' where number='$bbs_num' ";

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

	//echo $text1;exit;

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

	if ($bbs_pass == "" && $mem_id != "" && $MEMBER['user_pass'] != "")
	{
		if ($BOARD[bbs_pass] == "")
		{
			$bbs_pass	= $MEMBER['user_pass'];
		}
		else
		{
			$bbs_pass	= $BOARD[bbs_pass];
		}
	}

	if ($_POST[gong_ok] == "1" && admin_secure("게시판관리") )
	{
		$_POST['top_gonggi'] = '1';
	}
	else
	{
		$_POST['top_gonggi'] = '0';
	}

	$sql = "update  $tb set
	$img_update1 $img_update2 $img_update3 $img_update4 $img_update5 $img_update6
	text1 = '$text1',
	bbs_name = '$bbs_name',
	bbs_pass = '$bbs_pass',
	bbs_email = '$bbs_email',
	bbs_title = '$bbs_title',
	bbs_img = '$bbs_img',
	bbs_review = '$bbs_review',
	#bbs_etc2 = '$bbs_etc2',
	bbs_etc3 = '$bbs_etc3',
	bbs_etc4 = '$bbs_etc4',
	bbs_etc5 = '$bbs_etc5',
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
	startdate = '$startdate',
	enddate = '$enddate',
	barcolor = '$barcolor',
	fontcolor = '$fontcolor'
	where number='$bbs_num'
	";


	#echo "$sql";exit;

	$result = query($sql);
	//echo "$sql";

	//뉴스상점 START
	//위 로직중 insert 로직은 사용되지 않는 걸로 확인
	if ( $BOARD['news_gongu'] == "1" && $BOARD['number'] != "" )
	{
		$contents_file_name = "upload/news_data/bbs_contents/".$tb."/".$BOARD['sharing_site']."_".$BOARD['shared_site']."/bbs_".$BOARD['number'].".html";

		if ( file_exists($contents_file_name) )
		{
			$BOARD['bbs_review'] = file_get_contents($contents_file_name);
		}

		$sql = "update $tb set bbs_review = '".addslashes($BOARD['bbs_review'])."' where number = '".$BOARD['number']."'";
		query($sql);

		$bbs_review = addslashes($BOARD['bbs_review']);

		$sql = "select * from $tb where number = '".$bbs_num."'";
		$result = query($sql);
		$NEWS = happy_mysql_fetch_assoc($result);
		//공유받은 카테고리가 게시판 테이블명
		$NEWS['category'] = $tb;

		include_once("master/news_share/inc/function.php");
		news_store_data_put2($NEWS,"update");
	}
	//뉴스상점 END

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


	#exit;
	if ($bbs_etc7)
	{
		go("./bbs_list.php?tb=$tb&pg=$pg&b_category=$b_category&id=$_POST[bbs_etc7]");
	}
	else
	{
		go("./bbs_list.php?category=$b_category&tb=$tb&pg=$pg");
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


	$현재위치 = "$prev_stand_bbs >  <a href=bbs_list.php?id=$_GET[id]&tb=$tb>$B_CONF[board_name]</a> > 수정하기 ";


$게시판버튼 = <<<END
<input type=hidden name=bbs_etc7 value='$_GET[id]'>
<a href='./bbs_list.php?pg=$pg&id=$_GET[id]&b_category=$b_category&tb=$tb' class='h_btn_b icon_b' uk-icon='icon:list; ratio:1'>목록보기</a><input type=hidden name=bbs_etc7 value='$_GET[id]'><button class="h_btn_b icon_b h_btn_st1" uk-icon="icon:pencil; ratio:1">수정</button>
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
		$category_info = make_selectbox2($BOARD_CATE,$BOARD_CATE,'',b_category,$BOARD[b_category]);

		$category_select = <<<END
			<tr>
				<th>카테고리선택</th>
				<td class="h_form">$category_info</td>
			</tr>
END;

		$category_select2 = $category_info;
	}
}


	#잠긴글 비밀번호를 넣었다.
	if ($_POST[write_password])
	{
		#비밀번호가 글 비밀번호나 혹은 게시판전체비밀번호와 같은지 비교한다.
		if (  $_POST[write_password] == $B_CONF[board_pass] || $_POST[write_password] == $BOARD[bbs_pass]  )
		{
			$master_check = '1';
		}
		else
		{
			error("\\n비밀번호가 일치하지 않습니다.   \\n\\n다시 입력해주세요 ");
			exit;
		}
	}


#########################################################################################
#권한허가가 없으면 일반 비밀번호 폼으로 바로감.
if ($mode == "" && $master_check != '1' )
{
	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		$내용 = <<<END
		<div align="center">
			<form name='regiform' method='post' action='./bbs_mod.php?id=$_GET[id]&mod=mod&num=$_GET[num]&'  >
			<input type=hidden name='tb' value='$tb'>
			<input type=hidden name='minihome_id' value='$_GET[minihome_id]'>
			<input type=hidden name='bbs_num' value='$bbs_num'>
			<input type=hidden name='top_gonggi' value='$_GET[top_gonggi]'>

			<div style='border:1px solid #e2e2e2; background:#f9f9f9; padding:30px 0px; margin:10px;'>
				<div style='color:#222222; text-align:center;' class="font_18">게시글수정</div>
				<div style='color:#999999; text-align:center; margin-top:10px;' class="font_15">작성시 입력하신 비밀번호를 입력하여 주세요.</div>
				<div class='h_form' style='text-align:center; margin-top:10px;'>
					<input type=password name='write_password' style='width:150px;'/><button style='background:#ffffff; margin-left:5px;'>확인</button>
				</div>
			</div>

			</form>
		</div>

END;
	}
	else
	{
		$내용 = <<<END
		<form name='regiform' method='post' action='./bbs_mod.php?id=$_GET[id]&mod=mod&num=$_GET[num]&'  >
			<input type=hidden name='tb' value='$tb'>
			<input type=hidden name='minihome_id' value='$_GET[minihome_id]'>
			<input type=hidden name='bbs_num' value='$bbs_num'>
			<input type=hidden name='top_gonggi' value='$_GET[top_gonggi]'>

			<div style='width:350px; margin:0 auto; border:1px solid #e2e2e2; background:#f9f9f9; padding:30px; margin-top:60px;'>
				<div style='color:#222222; text-align:center; font-size:20px;' class='noto400'>게시글수정</div>
				<div style='color:#999999; text-align:center; font-size:15px; margin-top:10px;' class='noto400'>작성시 입력하신 비밀번호를 입력하여 주세요.</div>
				<div class='h_form' style='text-align:center; margin-top:10px;'>
					<input type=password name='write_password' style='width:150px;'/><button style='background:#ffffff; margin-left:3px;'>확인</button>
				</div>
			</div>
		</form>
END;
	}
}
else
{
	//echo "$skin_folder_bbs/$B_CONF[board_temp_modify]";
	$TPL->define("게시판수정", "$skin_folder_bbs/$B_CONF[board_temp_modify]");
	$내용 = &$TPL->fetch();
}

	#오늘날짜 뽀너스로 구하기
	setlocale (LC_TIME, "ko_KR.UTF-8");
	$매장매물갯수 = $numb;
	$투표내용 = vote_read();
	$오늘날짜 = strftime("%Y년 %b %d일(%a)");

	$삽니다내용 = $main_buy;
	$메인주소 = $main_url;
	$현재카테고리 = $number_category;



	$투표내용 = vote_read();


	$TPL->define("전체", "$large_template");
	$TPL->assign("전체");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	if ($demo){
	$쿼리시간 =  "<center><font color=gray size=1>Query Time : $exec_time sec";
	}
	$TPL->tprint();

?>