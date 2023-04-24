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
		error("해당 테이블이 존재하지 않습니다 ");
		exit;
	}



	if( !(is_file("$skin_folder_bbs/$B_CONF[board_temp_detail]")) )
	{
		print "리스트페이지 $skin_folder_bbs/$B_CONF[board_temp_detail] 파일이 존재하지 않습니다. <br>";
		return;
	}


	#읽을수 있는 회원인가?
	if ( !admin_secure("게시판관리") )
	{
		if ( !happy_member_secure('%게시판%'.$tb.'-delete') )
		{
			if ( $happy_member_login_value == "" )
			{
				gomsg("로그인이 필요한 페이지입니다.","happy_member_login.php");
				exit;
			}
			else
			{
				error ("현재 회원님의 레벨로는 \'$B_CONF[board_name]\' 삭제 권한이 없습니다");
				exit;
			}
		}
	}


	########################################################################
	# 삭제루틴 시작
	########################################################################


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


	$sql = "select * from $tb where number='$bbs_num'";
	$result = query($sql);
	$BOARD = happy_mysql_fetch_array($result);

	#게시판의 list를 읽자
	$게시판상단 = $B_CONF[up];
	$게시판하단 = $B_CONF[down];


	if ($BOARD[bbs_id] == $mem_id && $mem_id)
	{
		$master_check = '1';
	}

	if ( admin_secure("게시판관리") )
	{
		$master_check = '1';
	}




#게시판정보
if ($master_check !="1" && $write_password == "")
{
	$현재위치 = "$prev_stand_bbs >  <a href=bbs_list.php?&id=$_GET[id]&tb=$tb>$B_CONF[board_name]</a> > 게시글 삭제 ";


	if ( $_COOKIE['happy_mobile'] == 'on' )
	{
		$내용	= "
			 <form name='regiform' method='post' action='./bbs_del.php?id=$_GET[id]'  >
			<input type=hidden name='tb' value='$tb'>
			<input type=hidden name='id' value='$_GET[id]'>
			<input type=hidden name='bbs_num' value='$bbs_num'>
			<input type=hidden name='top_gonggi' value='$_GET[top_gonggi]'>

			<div style='border:1px solid #e2e2e2; background:#f9f9f9; padding:30px 0px; margin:10px;'>
				<div style='color:#222222; text-align:center;' class='font_20'>게시글삭제</div>
				<div style='color:#999999; text-align:center; margin-top:10px;' class='font_15'>작성시 입력하신 비밀번호를 입력하여 주세요.</div>
				<div class='h_form' style='text-align:center; margin-top:10px;'>
					<input type=password name='write_password' style='width:150px;'/><button style='background:#ffffff; margin-left:5px;'>확인</button>
				</div>
			</div>

			</form>
		";
	}
	else
	{
		$내용 = "


		<form name='regiform' method='post' action='./bbs_del.php?id=$_GET[id]'  >
		<input type=hidden name='tb' value='$tb'>
		<input type=hidden name='id' value='$_GET[id]'>
		<input type=hidden name='bbs_num' value='$bbs_num'>
		<input type=hidden name='top_gonggi' value='$_GET[top_gonggi]'>

			<div style='width:350px; margin:0 auto; border:1px solid #e2e2e2; background:#f9f9f9; padding:30px; margin-top:60px;'>
				<div style='color:#222222; text-align:center; font-size:20px;' class='noto400'>게시글삭제</div>
				<div style='color:#999999; text-align:center; font-size:15px; margin-top:10px;' class='noto400'>작성시 입력하신 비밀번호를 입력하여 주세요.</div>
				<div class='h_form' style='text-align:center; margin-top:10px;'>
					<input type=password name='write_password' style='width:150px;'/><button style='background:#ffffff; margin-left:3px;'>확인</button>
				</div>
			</div>

		</form>
		";
	}


	#오늘날짜 뽀너스로 구하기
	setlocale (LC_TIME, "ko_KR.UTF-8");

	$매장매물갯수 = $numb;
	$투표내용 = vote_read();
	$오늘날짜 = strftime("%Y년 %b %d일(%a)");

	$메인주소 = $main_url;
	$현재카테고리 = $number_category;
	$투표내용 = vote_read();

	$TPL->define("전체", "$skin_folder_bbs/$B_CONF[board_temp]");
	$TPL->assign("전체");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();

exit;
}

	#공지사항이면 tb를 바꾸자
	if ($_GET[top_gonggi] == '1' || $_POST[top_gonggi] == '1')
	{
		$tmp_tb = $board_top_gonggi;
		$add_link = "&top_gonggi=1";
	}
	else
	{
		$tmp_tb = $tb;
		$add_link = "";
	}



#$write_password 를 입력한 상태라면
if ($write_password)
{
	#비밀번호가 글 비밀번호나 혹은 게시판전체비밀번호와 같은지 비교한다.
	if ( $write_password == $B_CONF[board_pass] || $write_password == $BOARD[bbs_pass]  )
	{
		#답글 체크후 답글 있을경우 삭제불가능
		list($groups,$seq,$depth)	= happy_mysql_fetch_array(query("SELECT groups,seq,depth FROM $tmp_tb WHERE number='$bbs_num'"));
		list($CountChk)				= happy_mysql_fetch_array(query("SELECT Count(*) FROM $tmp_tb WHERE groups='$groups' AND seq = $seq+1 AND depth > $depth"));

		if ( $CountChk > 0 )
		{
			error("답변글이 있는 게시물은 삭제가 불가능합니다.");
			exit;
		}

		#위지윅 + 첨부파일 삭제 hong 추가
		$Sql		= "SELECT * FROM $tmp_tb WHERE number='$bbs_num' ";
		$Result		= query($Sql);
		$BOARD		= happy_mysql_fetch_array($Result);

		//뉴스상점 START
		if ( $BOARD['news_gongu'] == "1" )
		{
			//공유받은 카테고리가 게시판 테이블명
			$BOARD['category'] = $tmp_tb;
			include_once("master/news_share/inc/function.php");
			news_store_data_put2($BOARD,"delete");

			//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장
			$contents_file_path = "upload/news_data/bbs_contents/".$tmp_tb."/".$BOARD['sharing_site']."_".$BOARD['shared_site']."/";
			$contents_file_name = "bbs_".$BOARD['number'].".html";
			//echo $contents_file_path.$contents_file_name;exit;
			@unlink($contents_file_path.$contents_file_name);
			//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장
		}
		//뉴스상점 END

		//위지윅
		happy_unlink_wys_file($BOARD['bbs_review']);

		//첨부파일
		happy_unlink_attach_file($BOARD['bbs_etc1'],"data/$tmp_tb");
		happy_unlink_attach_file($BOARD['bbs_attach2'],"data/$tmp_tb");
		happy_unlink_attach_file($BOARD['bbs_attach3'],"data/$tmp_tb");
		happy_unlink_attach_file($BOARD['text1'],"data/$tmp_tb");
		happy_unlink_attach_file($BOARD['text2'],"data/$tmp_tb");
		#위지윅 + 첨부파일 삭제 hong 추가

		$sql = "delete from $tmp_tb where number='$bbs_num' ";
		$result = query($sql);
		go("bbs_list.php?id=$_GET[id]&tb=$tb&pg=$pg");
		exit;
	}
	else
	{
		error("\\n비밀번호가 일치하지 않습니다.  \\n\\n다시 입력해주세요 ");
		exit;
	}
}
else
{
	#자신이 쓴글이거나 관리자인지 비교하자
	if ( ( $mem_id == $BOARD[bbs_id] && $mem_id ) || $master_check == '1'  )
	{
		#답글 체크후 답글 있을경우 삭제불가능
		list($groups,$seq,$depth)	= happy_mysql_fetch_array(query("SELECT groups,seq,depth FROM $tmp_tb WHERE number='$bbs_num'"));
		list($CountChk)				= happy_mysql_fetch_array(query("SELECT Count(*) FROM $tmp_tb WHERE groups='$groups' AND seq = $seq+1 AND depth > $depth"));

		if ( $CountChk > 0 )
		{
			error("답변글이 있는 게시물은 삭제가 불가능합니다.");
			exit;
		}

		#위지윅 + 첨부파일 삭제 hong 추가
		$Sql		= "SELECT * FROM $tmp_tb WHERE number='$bbs_num' ";
		$Result		= query($Sql);
		$BOARD		= happy_mysql_fetch_array($Result);

		//뉴스상점 START
		if ( $BOARD['news_gongu'] == "1" )
		{
			//공유받은 카테고리가 게시판 테이블명
			$BOARD['category'] = $tmp_tb;
			include_once("master/news_share/inc/function.php");
			news_store_data_put2($BOARD,"delete");

			//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장
			$contents_file_path = "upload/news_data/bbs_contents/".$tmp_tb."/".$BOARD['sharing_site']."_".$BOARD['shared_site']."/";
			$contents_file_name = "bbs_".$BOARD['number'].".html";
			//echo $contents_file_path.$contents_file_name;exit;
			@unlink($contents_file_path.$contents_file_name);
			//뉴스의 본문은 공유한 내용 그대로 나오도록 본문을 파일로 저장
		}
		//뉴스상점 END

		//위지윅
		happy_unlink_wys_file($BOARD['bbs_review']);

		//첨부파일
		happy_unlink_attach_file($BOARD['bbs_etc1'],"data/$tmp_tb");
		happy_unlink_attach_file($BOARD['bbs_attach2'],"data/$tmp_tb");
		happy_unlink_attach_file($BOARD['bbs_attach3'],"data/$tmp_tb");
		happy_unlink_attach_file($BOARD['text1'],"data/$tmp_tb");
		happy_unlink_attach_file($BOARD['text2'],"data/$tmp_tb");
		#위지윅 + 첨부파일 삭제 hong 추가

		$sql = "delete from $tmp_tb where number='$bbs_num' ";
		$result = query($sql);
		go("bbs_list.php?id=$_GET[id]&tb=$tb&pg=$pg");
		exit;
	}
	else
	{
		error("자신이 쓴글이 아니면 삭제를 하지 못합니다");
		exit;
	}
}

	#관리자 로그인정보
	if ( $master_check == "1" )
	{
		$관리자로그인 = "<A HREF='./bbs_logout.php?id=$_GET[id]&tb=$tb'><img src='bbs_img/bt_admin_logout.gif' border=0 align=absmiddle></A>";
	}
	else
	{
		$관리자로그인 = "<A HREF='./admin/admin.php' target=_blank><img src='bbs_img/bt_admin_login.gif' border=0 align=absmiddle></A>";
	}


	#게시판의 list를 읽자
	$현재위치 = "$prev_stand_bbs >  <a href=bbs_list.php?&id=$_GET[id]&tb=$tb>$B_CONF[board_name]</a> > 게시글 삭제 ";


	#게시글을 비로소 삭제하자


	#오늘날짜 뽀너스로 구하기
	setlocale (LC_TIME, "ko_KR.UTF-8");

	$TPL->define("전체", "$skin_folder_bbs/$B_CONF[board_temp]");
	$TPL->assign("전체");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();

?>