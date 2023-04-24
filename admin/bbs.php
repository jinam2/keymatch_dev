<?php
include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/function.php");
include ("../inc/lib.php");

include ("../class/color.php");

if ( !admin_secure("게시판관리") ) {
		error("접속권한이 없습니다.   ");
		exit;
}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

//query("ALTER TABLE $board_list ADD admin_sms_send int(1) DEFAULT '0' NOT NULL");
//query("ALTER TABLE $board_list ADD admin_sms_phone text DEFAULT '' NOT NULL");
//query("ALTER TABLE $board_list ADD admin_sms_msg varchar(255) DEFAULT '' NOT NULL");

	function board_date_updater()
	{
		global $board_list;

		$Sql	= "SELECT tbname FROM $board_list";
		$Record	= query($Sql);

		while ( $Boards = happy_mysql_fetch_array($Record) )
		{
			$tbName = $Boards['tbname'];

			$Sql		= "SELECT Count(*) FROM $tbName";
			$Tmp		= happy_mysql_fetch_array(query($Sql));

			$minusDay	= $Tmp[0] * 4;


			$Sql		= "SELECT number FROM $tbName ORDER BY number ASC ";
			$BoardRec	= query($Sql);

			while ( $Data = happy_mysql_fetch_array($BoardRec) )
			{
				$bbs_date	= date("Y-m-d H:i:s",happy_mktime( date("H"), date("i"), date("s"), date("m"), date("d")-$minusDay, date("Y")));
				query("UPDATE $tbName SET bbs_date='$bbs_date' WHERE number='$Data[number]'");

				$tmpMinus	= rand(0,9) % 3 == 0 ? 0 : rand(0,10);
				$minusDay	= $minusDay - $tmpMinus;
				if ( $minusDay < 1 )
				{
					$minusDay = 0;
				}
			}

		}
		echo '<h1>업데이트 완료!! 주석을 하세요!!!!!!!!!!!!! - 이것이 보이면 안되용~</h1>';
	}
	// board_date_updater(); #주석 해제하고 한번 돌리면 됩니다.


	///////////////////////////////////게시판 생성
	if ( $mode == "list" ) {
		$sql = "select * from $board_list";
		$result = query($sql);
		include ("./html/bbs_list.html");
	}
	else if ( $mode == 'add' )
	{

		$GetMycolor1 = color::hex2rgb("#EAEAEA") ;
		$GetMycolor2 = color::hex2rgb("#F3F3F3") ;
		$GetMycolor3 = color::hex2rgb("#FFFFFF") ;
		$GetMycolor4 = color::hex2rgb("#FFFFFF") ;
		$GetMycolor5 = color::hex2rgb("#FCFCFC") ;


		# 권한설정 #
		$Sql	= "SELECT * FROM $happy_member_group ORDER BY group_default_level DESC ";
		$Rec	= query($Sql);


		$group_checkbox_names	= Array('write', 'modify', 'delete', 'view', 'list', 'reply', 'comment_write', 'comment_view', 'comment_delete', 'write_close');
		$group_checkbox_max		= sizeof($group_checkbox_names);

		for ( $i=0 ; $i<$group_checkbox_max ; $i++ )
		{
			${'group_checkbox_'.$nowName}	= '';
		}

		while ( $Group = happy_mysql_fetch_array($Rec) )
		{
			for ( $i=0 ; $i<$group_checkbox_max ; $i++ )
			{
				$nowName	= $group_checkbox_names[$i];

				${'group_checkbox_'.$nowName}	.= "<div class='group_name'><input type='checkbox' name='${nowName}[]' id='$tbname-${nowName}-$Group[number]' class='input_chk' value='$Group[number]' $checked > <label for='$tbname-${nowName}-$Group[number]'>$Group[group_name]</label></div>";
			}
		}

		$Group['group_name']	= '비회원';
		$Group['number']		= $happy_member_secure_noMember_code;

		for ( $i=0 ; $i<$group_checkbox_max ; $i++ )
		{
				$nowName	= $group_checkbox_names[$i];

				${'group_checkbox_'.$nowName}	.= "<div class='group_name'><input type='checkbox' name='${nowName}[]' id='$tbname-${nowName}-$Group[number]' class='input_chk' value='$Group[number]' $checked > <label for='$tbname-${nowName}-$Group[number]'>$Group[group_name]</label></div>";
		}
		# 권한설정 #




		include ("./html/bbs_add.html");
	}

	elseif ( $mode == "add_ok" ) {

			//게시판이름 중복 체크
			$sql = "select count(*) from $board_list where board_name='$board_name'";
			$result2 = query($sql);
			$board_check = happy_mysql_fetch_array($result2);
			if($board_check[0]>0)
			{
				error("동일이름의 게시판이 있습니다");
				echo "<script>location.href='$HTTP_REFERER';</script>";
				exit;
			}

			//테이블이름 중복 체크
			$sql = "select count(*) from $board_list where  tbname='$tbname'";
			$result3 = query($sql);
			$tb_check = happy_mysql_fetch_array($result3);
			if($tb_check[0]>0)
			{
				error("이미 등록되어 있는 테이블입니다.");
				echo "<script>location.href='$HTTP_REFERER';</script>";
				exit;
			}

			//이미 존재하는 테이블인가?
			$result3 = happy_mysql_list_tables($db_name);
			while( $ex_table = happy_mysql_fetch_array($result3) )
			{
				if ($ex_table[0] == "$tbname" ) error("이미 사용하는 있는 테이블입니다.");

			}

		$admin_etc6 = $_POST[board_type];




		# 권한설정 저장 #
		$group_checkbox_names	= Array('write', 'modify', 'delete', 'view', 'list', 'reply', 'comment_write', 'comment_view', 'comment_delete', 'write_close');
		$group_checkbox_max		= sizeof($group_checkbox_names);


		for ( $i=0 ; $i<$group_checkbox_max ; $i++ )
		{
			$nowName	= $group_checkbox_names[$i];
			$nowArr		= $_POST[$nowName];
			$nowMax		= sizeof($nowArr);

			#echo "$nowName <br>";		continue;

			$menu_title = $tbname."-".$nowName;
			for ( $y=0 ; $y<$nowMax ; $y++ )
			{
				$nowGroup	= $nowArr[$y];
				$Sql		= "
								INSERT INTO
										$happy_member_secure
								SET
										group_number	= '$nowGroup',
										user_id			= '',
										menu_title		= '$happy_member_secure_board_code$menu_title',
										menu_use		= 'y'
				";

				query($Sql);

			}

		}



		// 자신이 작성한 댓글 출력 여부 - 16.10.10 x2chi
		if( $_POST['comment_view_me'] )
		{
			$Sql		= "
							INSERT INTO
									$happy_member_secure
							SET
									menu_title		= '".$happy_member_secure_board_code.$tbname."-comment_view_me',
									menu_use		= 'y'
			";
			query($Sql);
		}



		# 권한설정 저장 #
		#echo "<pre>"; print_r($_POST); echo "</pre>";exit;


		//'$number','$board_name','$tbname','$pass','$board_view','$img_width','$bar_color','$up_color','$down_color','$body_color','$table_size','$pagenum','$temp','$up','$down','$control','$date','$admin_etc1','$admin_etc2','$admin_etc3','$admin_etc4','$admin_etc5','$admin_etc6',

		//$number,$board_read,$board_name,$tbname,$skin,$pass,$board_view,$img_width,$bar_color,$up_color,$down_color,$body_color,$table_size,$pagenum,$temp,$up,$down,$control,$date,$admin_etc1,$admin_etc2,$admin_etc3,$admin_etc4,$admin_etc5,$admin_etc6,
		//alter table board_list add `keyword` varchar(200) not null default '';
		//alter table board_list add `sorting_number` int(10) not null default 0;

		// 공지게시물 출력 설정 - 16.10.26 - x2chi
		$notice_list_view	= $_POST['notice_list_view'];

		if ( !(is_writable("../data")) )
		{
			error("../data 폴더의 퍼미션을 777로 조정하세요");
		}
		if ( !(file_exists("../data/$tbname")))
		{
			mkdir("../data/$tbname", 0777);
		}
		if ( !(is_writable("../data/$tbname")) )
		{
			error("../data/$tbname 폴더의 퍼미션을 777로 조정하세요");
		}

		$sql = "insert into $board_list values('','$board_read','$board_name','$board_keyword','$tbname','$board_write','$pass','$board_view','$img_width','$bar_color','$up_color','$down_color','$body_color','$detail_color','$table_size','$board_pagenum','$board_temp','$up','$down','$control',curdate(),
		'$board_temp_list','$board_temp_detail','$board_temp_modify','$board_temp_regist','$board_temp_reply','$admin_etc6','$category','$mini_thumb','$auto_img','$keyword','$sorting_number', '$notice_list_view', '$admin_sms_send', '$admin_sms_phone', '$admin_sms_msg', '$admin_sms_msg_ktplcode')";
		$result = query($sql);
		$sql2 ="

			CREATE TABLE $tbname (
				  `number` int(11) NOT NULL auto_increment,
				  `bbs_name` varchar(30) NOT NULL default '',
				  `bbs_pass` varchar(30) NOT NULL default '',
				  `bbs_email` varchar(100) NOT NULL default '',
				  `bbs_title` varchar(100) NOT NULL default '',
				  `bbs_img` varchar(50) NOT NULL default '',
				  `bbs_review` text NOT NULL,
				  `bbs_count` int(11) NOT NULL default '0',
				  `bbs_date` datetime default NULL,
				  `groups` int(11) NOT NULL default '0',
				  `seq` int(11) NOT NULL default '0',
				  `depth` int(11) NOT NULL default '0',
				  `bbs_etc1` varchar(100) NOT NULL default '',
				  `bbs_etc2` int(5) NOT NULL default '0',
				  `bbs_etc3` varchar(50) NOT NULL default '',
				  `bbs_etc4` int(5) NOT NULL default '0',
				  `bbs_etc5` varchar(50) NOT NULL default '',
				  `bbs_attach2` varchar(100) NOT NULL default '',
				  `bbs_attach3` varchar(100) NOT NULL default '',
				  `bbs_etc6` varchar(100) NOT NULL default '',
				  `bbs_etc7` varchar(100) NOT NULL default '',
				  `phone` varchar(150) NOT NULL default '',
				  `hphone` varchar(150) NOT NULL default '',
				  `address` text NOT NULL,
				  `zip` varchar(100) NOT NULL default '',
				  `select1` varchar(100) NOT NULL default '0',
				  `select2` varchar(100) NOT NULL default '0',
				  `select3` varchar(100) NOT NULL default '',
				  `radio1` varchar(100) NOT NULL default '',
				  `radio2` varchar(100) NOT NULL default '',
				  `radio3` varchar(100) NOT NULL default '',
				  `text1` varchar(100) NOT NULL,
				  `text2` varchar(100) NOT NULL,
				  `text3` varchar(100) NOT NULL,
				  `gou_number` varchar(50) NOT NULL default '',
				  `delivery` int(10) NOT NULL default '0',
				  `money_in` int(10) NOT NULL default '0',
				  `total_price` int(100) NOT NULL default '0',
				  `b_category` varchar(150) NOT NULL default '',
				  `reply_stats` int(10) NOT NULL default '0',
				  `write_ip` varchar(100) NOT NULL default '',
				  `org_writer` varchar(100) NOT NULL default '',
				  `view_lock` int(1) NOT NULL default '0',
				  `notice` int(1) NOT NULL default '0',
				  `bbs_id` varchar(150) NOT NULL default '',
				  `startdate` date NOT NULL default '0000-00-00',
				  `enddate` date NOT NULL default '0000-00-00',
				  `barcolor` varchar(20) NOT NULL default '',
				  `fontcolor` varchar(20) NOT NULL default '',
				  PRIMARY KEY  (`number`),
				  KEY `bbs_name` (`bbs_name`),
				  KEY `bbs_title` (`bbs_title`),
				  KEY `select1` (`select1`),
				  KEY `select2` (`select2`),
				  KEY `groups` (`groups`),
				  KEY `seq` (`seq`),
				  KEY `b_category` (`b_category`),
				  KEY `org_writer` (`org_writer`),
				  KEY `bbs_id` (`bbs_id`),
				  KEY `gou_number` (`gou_number`),
				  KEY `startdate` (`startdate`),
				  KEY `enddate` (`enddate`)
			)

	  ";

		 $result2 = query($sql2);
		 //echo "$sql<BR>$sql2";
		 go("$PHP_SELF?mode=list");
	}


	///////////////////////////////////////////////게시판 수정
	elseif ( $mode == "mod" ) {


		$sql = "select * from $board_list where number='$num'";
		$result = query($sql);
		list ($number,$board_read,$board_name,$board_keyword,$tbname,$board_write,$board_pass,$board_view,$img_width,$bar_color,$up_color,$down_color,$body_color,$detail_color,$table_size,$board_pagenum,$board_temp,$up,$down,$control,$date,$board_temp_list,$board_temp_detail,$board_temp_modify,$board_temp_regist,$board_temp_reply,$admin_etc6,$category,$mini_thumb,$auto_img,$keyword,$sorting_number, $notice_list_view, $admin_sms_send, $admin_sms_phone, $admin_sms_msg, $admin_sms_msg_ktplcode) = happy_mysql_fetch_array($result);

		$body_color_con = str_replace("#",'',$body_color);

		$GetMycolor1 = color::hex2rgb($bar_color);
		$GetMycolor2 = color::hex2rgb($up_color);
		$GetMycolor3 = color::hex2rgb($down_color);
		$GetMycolor4 = color::hex2rgb($body_color);
		$GetMycolor5 = color::hex2rgb($detail_color);

		if ($auto_img == '1'){
		$auto_img_1 = 'checked';
		}
		elseif ($auto_img == '2'){
		$auto_img_2 = 'checked';
		}
		else {
		$auto_img_0 = 'checked';
		}

		if ( $board_read == "5" ) {
			$opt_temp = "<input type='radio' name='board_read' size=40 value='5' checked> 관리자 전용 <input type='radio' name='board_read' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_read' size=40 value='1'> 회원 이상 <input type='radio' name='board_read' size=40 value='0'> 일반인용";
		}
		elseif ( $board_read == "1" ) {
			$opt_temp = "<input type='radio' name='board_read' size=40 value='5'> 관리자 전용 <input type='radio' name='board_read' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_read' size=40 value='1' checked> 회원 이상 <input type='radio' name='board_read' size=40 value='0'> 일반인용";
		}
		elseif ( $board_read == "2" ) {
			$opt_temp = "<input type='radio' name='board_read' size=40 value='5'> 관리자 전용 <input type='radio' name='board_read' size=40 value='2' checked> 기업회원 이상 <input type='radio' name='board_read' size=40 value='1' > 회원 이상 <input type='radio' name='board_read' size=40 value='0'> 일반인용";
		}
		else {
			$opt_temp = "<input type='radio' name='board_read' size=40 value='5'> 관리자 전용 <input type='radio' name='board_read' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_read' size=40 value='1'> 회원 이상 <input type='radio' name='board_read' size=40 value='0' checked> 일반인용";
		}

		if ( $board_write == "5" ) {
			$opt_temp_write = "<input type='radio' name='board_write' size=40 value='5' checked> 관리자 전용 <input type='radio' name='board_write' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_write' size=40 value='1'> 회원 이상 <input type='radio' name='board_write' size=40 value='0'> 일반인용";
		}
		elseif ( $board_write == "1" ) {
			$opt_temp_write = "<input type='radio' name='board_write' size=40 value='5'> 관리자 전용 <input type='radio' name='board_write' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_write' size=40 value='1' checked> 회원 이상 <input type='radio' name='board_write' size=40 value='0'> 일반인용";
		}
		elseif ( $board_write == "2" ) {
			$opt_temp_write = "<input type='radio' name='board_write' size=40 value='5'> 관리자 전용 <input type='radio' name='board_write' size=40 value='2' checked> 기업회원 이상 <input type='radio' name='board_write' size=40 value='1' > 회원 이상 <input type='radio' name='board_write' size=40 value='0'> 일반인용";
		}
		else {
			$opt_temp_write = "<input type='radio' name='board_write' size=40 value='5'> 관리자 전용 <input type='radio' name='board_write' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_write' size=40 value='1'> 회원 이상 <input type='radio' name='board_write' size=40 value='0' checked> 일반인용";
		}

		if ( $board_view == "5" ) {
			$opt_temp_view = "<input type='radio' name='board_view' size=40 value='5' checked> 관리자 전용 <input type='radio' name='board_view' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_view' size=40 value='1'> 회원 이상 <input type='radio' name='board_view' size=40 value='0'> 일반인용";
		}
		elseif ( $board_view == "1" ) {
			$opt_temp_view = "<input type='radio' name='board_view' size=40 value='5'> 관리자 전용 <input type='radio' name='board_view' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_view' size=40 value='1' checked> 회원 이상 <input type='radio' name='board_view' size=40 value='0'> 일반인용";
		}
		elseif ( $board_view == "2" ) {
			$opt_temp_view = "<input type='radio' name='board_view' size=40 value='5'> 관리자 전용 <input type='radio' name='board_view' size=40 value='2' checked> 기업회원 이상 <input type='radio' name='board_view' size=40 value='1' > 회원 이상 <input type='radio' name='board_view' size=40 value='0'> 일반인용";
		}
		else {
			$opt_temp_view = "<input type='radio' name='board_view' size=40 value='5'> 관리자 전용 <input type='radio' name='board_view' size=40 value='2'> 기업회원 이상 <input type='radio' name='board_view' size=40 value='1'> 회원 이상 <input type='radio' name='board_view' size=40 value='0' checked> 일반인용";
		}



		# 권한설정 #
		$Sql	= "SELECT * FROM $happy_member_group ORDER BY group_default_level DESC ";
		$Rec	= query($Sql);


		$group_checkbox_names	= Array('write', 'modify', 'delete', 'view', 'list', 'reply', 'comment_write', 'comment_view', 'comment_delete', 'write_close');
		$group_checkbox_max		= sizeof($group_checkbox_names);

		for ( $i=0 ; $i<$group_checkbox_max ; $i++ )
		{
			${'group_checkbox_'.$nowName}	= '';
		}

		while ( $Group = happy_mysql_fetch_array($Rec) )
		{
			for ( $i=0 ; $i<$group_checkbox_max ; $i++ )
			{
				$nowName	= $group_checkbox_names[$i];
				$Sql		= "
								SELECT
										Count(*)
								FROM
										$happy_member_secure
								WHERE
										group_number	= '$Group[number]'
										AND
										menu_title		= '$happy_member_secure_board_code$tbname-$nowName'
										AND
										menu_use		= 'y'
				";
				list($chk)	= happy_mysql_fetch_array(query($Sql));
				$checked	= $chk > 0 ? 'checked' : '';

				${'group_checkbox_'.$nowName}	.= "<div class='group_name'><input type='checkbox' name='$tbname-${nowName}[]' id='$tbname-${nowName}-$Group[number]' class='input_chk' value='$Group[number]' $checked > <label for='$tbname-${nowName}-$Group[number]'>$Group[group_name]</label></div>";
			}
		}

		$Group['group_name']	= '비회원';
		$Group['number']		= $happy_member_secure_noMember_code;

		for ( $i=0 ; $i<$group_checkbox_max ; $i++ )
		{
				$nowName	= $group_checkbox_names[$i];
				$Sql		= "
								SELECT
										Count(*)
								FROM
										$happy_member_secure
								WHERE
										group_number	= '$Group[number]'
										AND
										menu_title		= '$happy_member_secure_board_code$tbname-$nowName'
										AND
										menu_use		= 'y'
				";
				list($chk)	= happy_mysql_fetch_array(query($Sql));
				$checked	= $chk > 0 ? 'checked' : '';

				${'group_checkbox_'.$nowName}	.= "<div class='group_name'><input type='checkbox' name='$tbname-${nowName}[]' id='$tbname-${nowName}-$Group[number]' class='input_chk' value='$Group[number]' $checked > <label for='$tbname-${nowName}-$Group[number]'>$Group[group_name]</label></div>";
		}
		# 권한설정 #


		// 자신이 작성한 댓글 출력 여부 - 16.10.10 x2chi
		$Sql		= "
						SELECT
								Count(*)
						FROM
								$happy_member_secure
						WHERE
								menu_title		= '".$happy_member_secure_board_code.$tbname."-comment_view_me'
								AND
								menu_use		= 'y'
		";
		list($chk)	= happy_mysql_fetch_array(query($Sql));
		$comment_view_me_checked	= $chk > 0 ? 'checked' : '';

		// 공지게시물 출력 설정 - 16.10.26 - x2chi
		${"notice_list_view".$notice_list_view}	= "checked";

		include ("./html/bbs_mod.html");

	}

	elseif ( $mode == "mod_ok" ) {


		if ($demo == "1") {	#데모이면 삭제안됨
		gomsg("데모버젼은 수정이 되지 않습니다  ","bbs.php?mode=add");
		exit;
		}



		# 권한설정 저장 #
		$group_checkbox_names	= Array('write', 'modify', 'delete', 'view', 'list', 'reply', 'comment_write', 'comment_view', 'comment_delete', 'write_close');
		$group_checkbox_max		= sizeof($group_checkbox_names);

		$board_num	= preg_replace("/\D/", "", $_POST['num'] );
		list($tb)	= happy_mysql_fetch_array(query("SELECT tbname FROM $board_list WHERE number='$board_num'"));


		$Sql		= "
						UPDATE
								$happy_member_secure
						SET
								menu_use		= 'n'
						WHERE
								menu_title		like '$happy_member_secure_board_code$tb-%'
		";
		query($Sql);


		for ( $i=0 ; $i<$group_checkbox_max ; $i++ )
		{
			$nowName	= $tb .'-'. $group_checkbox_names[$i];
			$nowArr		= $_POST[$nowName];
			$nowMax		= sizeof($nowArr);

			#echo "$nowName <br>";		continue;


			for ( $y=0 ; $y<$nowMax ; $y++ )
			{
				$nowGroup	= $nowArr[$y];
				$Sql		= "
								SELECT
										Count(*)
								FROM
										$happy_member_secure
								WHERE
										menu_title		= '$happy_member_secure_board_code$nowName'
										AND
										group_number	= '$nowGroup'
				";
				list($chk)	= happy_mysql_fetch_array(query($Sql));

				if ( $chk > 0 )
				{
					$Sql		= "
									UPDATE
											$happy_member_secure
									SET
											menu_use		= 'y'
									WHERE
											menu_title		= '$happy_member_secure_board_code$nowName'
											AND
											group_number	= '$nowGroup'
					";
				}
				else
				{
					$Sql		= "
									INSERT INTO
											$happy_member_secure
									SET
											group_number	= '$nowGroup',
											user_id			= '',
											menu_title		= '$happy_member_secure_board_code$nowName',
											menu_use		= 'y'
					";
				}
				query($Sql);

			}

		}
		# 권한설정 저장 #
		#echo "<pre>"; print_r($_POST); echo "</pre>";exit;




		// 자신이 작성한 댓글 출력 여부 - 16.10.10 x2chi
		if( $_POST['comment_view_me'] )
		{
			$Sql		= "
							SELECT
									Count(*)
							FROM
									$happy_member_secure
							WHERE
									menu_title		= '".$happy_member_secure_board_code.$tb."-comment_view_me'
			";
			list($chk)	= happy_mysql_fetch_array(query($Sql));

			if ( $chk > 0 )
			{
				$Sql		= "
								UPDATE
										$happy_member_secure
								SET
										menu_use		= 'y'
								WHERE
										menu_title		= '".$happy_member_secure_board_code.$tb."-comment_view_me'
				";
			}
			else
			{
				$Sql		= "
								INSERT INTO
										$happy_member_secure
								SET
										menu_title		= '".$happy_member_secure_board_code.$tb."-comment_view_me',
										menu_use		= 'y'
				";
			}
			query($Sql);
		}






		if ($_POST[board_type]){
		$admin_etc6_sql = " admin_etc6 = '$_POST[board_type]' , ";
		}

		// 공지게시물 출력 설정 - 16.10.26 - x2chi
		$notice_list_view	= $_POST['notice_list_view'];

		$sql = "update $board_list set board_read='$board_read',
		board_write='$board_write',
		board_name='$board_name',
		board_keyword='$board_keyword',#추출명칭 추가
		board_view='$board_view',
		img_width='$img_width',
		bar_color='$bar_color',
		up_color='$up_color',
		down_color='$down_color',
		body_color='$body_color',
		detail_color='$detail_color',
		table_size='$table_size',
		board_pagenum='$board_pagenum',
		board_temp='$board_temp',
		up='$up',
		down='$down',
		control='$control'
		,board_temp_list = '$board_temp_list',board_temp_detail = '$board_temp_detail'
		,board_temp_modify = '$board_temp_modify',board_temp_regist = '$board_temp_regist' ,
		board_temp_reply = '$board_temp_reply',
		category = '$category',
		mini_thumb = '$mini_thumb',
		$admin_etc6_sql
		auto_img = '$auto_img',
		keyword = '$keyword',
		sorting_number = '$sorting_number',
		notice_list_view		= '$notice_list_view',
		admin_sms_send			= '$admin_sms_send',
		admin_sms_phone			= '$admin_sms_phone',
		admin_sms_msg			= '$admin_sms_msg',
		admin_sms_msg_ktplcode	= '$admin_sms_msg_ktplcode'
		where number=$num";
		$result = query($sql);
//				go("$PHP_SELF?mode=mod&num=$num");
		go("bbs.php?mode=list");
	}

	///////////////////////////////////////////////게시판 삭제
	elseif ( $mode == "del_ok" ) {
		if ($demo == "1") {	#데모이면 삭제안됨
		gomsg("데모버젼은 삭제가 되지 않습니다  ","bbs.php?mode=add");
		exit;
		}

		$sql = "delete from $board_list where number=$num";
		$result = query($sql);

		//뉴스상점 START
		echo "<div style='display:none'>";
		$sql = "select shared_site from $tbname where shared_site != 0 limit 0,1";
		$result = query($sql);
		list($shared_site) = happy_mysql_fetch_array($result);

		if ( $shared_site != "0" )
		{
			include_once("../master/news_share/inc/function.php");
			$Data = array();
			$Data['board_tbname'] = $tbname;
			$Data['shared_site'] = $shared_site;
			news_store_data_put2($Data,"board_delete");
		}
		echo "</div>";
		//exit;
		//뉴스상점 END

		$sql2 = "DROP TABLE $tbname";
		$result2 = query($sql2);
		go("$PHP_SELF?mode=list");
	}





include ("tpl_inc/bottom.php");


?>