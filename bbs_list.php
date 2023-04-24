<?php
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( $server_character == "euckr" )
	{
		$keyword_chk	= preg_replace("/([a-zA-Z0-9_.,-?@]|[\xA1-\xFE][\xA1-\xFE]|\s)/",'', $keyword);

		if ( $keyword_chk != "" )
		{
			error(" 잘못된 검색단어 입니다.   \\n 영문,숫자,한글만 허용됩니다.   ");
			exit;
		}
	}

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

	$unique = happy_mktime();

	#카테고리 정보를 읽어주자
	if ($B_CONF[category])
	{
		$BOARD[b_category_dis] = "";
		$BOARD_CATE = split("\n",$B_CONF[category]);
		$BOARD_CATE = str_replace("\n",'',$BOARD_CATE);
		$BOARD_CATE = str_replace("\r",'',$BOARD_CATE);

		$select_category = <<<END
		<select name=board_category onchange="window.open(this.options[this.selectedIndex].value,'_self')" style='margin-right:3px;'>
		<option value='bbs_list.php?tb=$tb'>전체보기</option>
END;

		foreach ($BOARD_CATE as $list)
		{
			if ($list)
			{
				$new_url = "bbs_list.php?tb=$tb&b_category=$list";

				if ($list == $_GET[b_category])
				{
					$selected = 'selected';
				}
				else
				{
					$selected = '';
				}
				$select_category .= "<option value='$new_url' $selected>$list</option>";
			}
		}
		$select_category .= "</select>";

		$array_name = $BOARD_CATE;
		$array_value = $BOARD_CATE;
		$mod = '직종선택';
		$var_name = 'b_category';
		$select_name = $_GET[b_category];
		$b_category_search_form = make_selectbox2($array_name,$array_value,$mod,$var_name,$select_name);
	}
	else
	{
		$BOARD[b_category_dis] = "display:none;";
	}
	#카테고리선택검색이 되도록 하자


	############################################################


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



	#검색일 경우
	$SEACH_QUERY = array();
	if ($b_category)
	{
		$category_search = " b_category = '$b_category' ";
		array_push($SEACH_QUERY,$category_search);
	}

	if ($zip)
	{
		$category_search = " zip = '$zip' ";
		array_push($SEACH_QUERY,$category_search);
	}

	if ($select1)
	{
		$category_search = " select1 = '$select1' ";
		array_push($SEACH_QUERY,$category_search);
	}

	if ($text2)
	{
		$category_search = " text2 = '$text2' ";
		array_push($SEACH_QUERY,$category_search);
	}

	$search_fields = array("bbs_title","bbs_name","bbs_review","phone","address");
	if( $search == '' )
	{
		$search = $search_fields[0];
	}
	if ($action == "search" && $search && $keyword )
	{
		if ( in_array($search,$search_fields) )
		{
			$search_board = " $search like '%$keyword%' $add_search_board ";
			array_push($SEACH_QUERY,$search_board);
		}
	}
	else
	{
		$search_board = $add_normal_board;
		$search_page = $add_search_page;
	}


	if ($SEACH_QUERY)
	{
		$search_board = "where ";
		foreach ($SEACH_QUERY as $list)
		{
			$search_board .= "$list and";
		}
		$search_board = preg_replace ("/and$/", '', $search_board);

		$search_page = "&b_category=$b_category&text2=$text2&zip=$zip&select1=$select1&search=$search&keyword=$keyword$add_search_page&action=search";
	}

	$sql = "select count(*) from $tb $search_board ";
	$result = query($sql);
	list($numb) = mysql_fetch_row($result);//총레코드수

	//공지사항까지 포함된 게시글
	$sql = "select count(*) from $board_top_gonggi where select1 = '$tb'";
	$result = query($sql);
	list($gong_numb) = mysql_fetch_row($result);

	$total_board_numb = $numb + $gong_numb;
	//공지사항까지 포함된 게시글


	#게시판정보
	if ($B_CONF[board_view] == "0")
	{
		$게시판권한 = "공개게시판";
	}
	elseif ($B_CONF[board_view] == "1")
	{
		$게시판권한 = "회원전용리스트";
	}
	elseif ($B_CONF[board_view] == "2")
	{
		$게시판권한 = "딜러전용리스트";
	}
	elseif ($B_CONF[board_view] == "5")
	{
		$게시판권한 = "관리자전용리스트";
	}
	else
	{
		$게시판권한 = "머죠!";
	}

	#관리자 로그인정보
	if ( admin_secure("게시판관리") )
	{
		$관리자로그인 = "<A HREF='./bbs_logout.php?id=$_GET[id]&num=$num&tb=$tb'><img src='bbs_img/bt_admin_logout.gif' border=0 align=absmiddle></A>";
		$master_check = '1';
	}
	else
	{
		$관리자로그인 = "<A HREF='./admin/admin.php' target=_blank><img src='bbs_img/bt_admin_login.gif' border=0 align=absmiddle></A>";
	}
	#읽을수 있는 회원인가? 5/관리자 , 2/기업 , 1/회원


	if ($B_CONF[board_view] == '5')
	{
		$msg_title = '관리자';
	}
	elseif ($B_CONF[board_view] == '2')
	{
		$msg_title = '기업회원';
	}
	elseif ($B_CONF[board_view] == '1')
	{
		$msg_title = '개인회원';
	}
	else
	{
		$msg_title = '전체회원';
	}

	if (!admin_secure("게시판관리") )
	{
		if ( !happy_member_secure('%게시판%'.$tb.'-list') )
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
					error ("\'$B_CONF[board_name]\' 접속 권한이 없습니다. ");
					exit;
				}
			}
			else
			{
				go("bbs_regist.php?id=$_GET[id]&b_category=$_GET[b_category]&tb=$_GET[tb]");
				exit;
			}
		}
	}

	#게시판버튼
	$write_button = $HAPPY_CONFIG['IconWrite1'];
	$list_button = $HAPPY_CONFIG['IconList1'];

	#자신이 글쓸수 있을때 버튼이 보이게 하자 : 091113 : Neohero
	if ( !happy_member_secure('%게시판%'.$tb.'-write') )
	{
		#게시판버튼
		$게시판버튼 = '<A HREF="./bbs_list.php?id='.$_GET['id'].'&b_category='.$b_category.'&tb='.$tb.'" class="icon_m" uk-icon="icon:list; ratio:1">목록보기</A>';
	}
	else
	{
		#게시판버튼
		$게시판버튼 = '<A HREF="./bbs_list.php?id='.$_GET['id'].'&b_category='.$b_category.'&tb='.$tb.'" class="icon_m" uk-icon="icon:list; ratio:1">목록보기</A><A HREF="./bbs_regist.php?id='.$_GET['id'].'&b_category='.$b_category.'&tb='.$tb.'" class="icon_m h_btn_st1 uk-icon" uk-icon="icon:pencil; ratio:1">글쓰기</A>';
	}

	if( !(is_file("$large_template")) )
	{
		print "리스트페이지 $skin_folder_bbs/$B_CONF[board_temp_list] 파일이 존재하지 않습니다. <br>";
		return;
	}

	#게시판의 list를 읽자
	$게시판상단 = $B_CONF[up];
	$게시판하단 = $B_CONF[down];

	$현재위치 = "$prev_stand_bbs >  <a href=bbs_list.php?&id=$_GET[id]&tb=$tb>$B_CONF[board_name]</a>";

	//echo "$skin_folder_bbs/$B_CONF[board_temp_list]";
	$TPL->define("게시판리스트", "$skin_folder_bbs/$B_CONF[board_temp_list]");
	$내용 = &$TPL->fetch();


	#echo $large_template;
	$TPL->define("전체", "$large_template");
	$TPL->assign("전체");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";
	$TPL->tprint();




?>