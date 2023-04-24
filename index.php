<?php

	$t_start = array_sum(explode(' ', microtime()));

	include ("./inc/Template.php");
	$TPL = new Template;

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");



	//print_r2($_COOKIE);
	//query("alter table $board_short_comment add column parent_number int(11) not null default 0");
	//query("alter table $board_short_comment add column depth int(11) not null default 0");
	//query("alter table $board_short_comment add column comment_group int(11) not null default 0");
	//query("alter table $board_short_comment add column comment_seq int(11) not null default 0");

//	query("alter table board_short_comment add key(comment_group, comment_seq)");

	if ($demo_lock)
	{
		$Tmp	= happy_mysql_fetch_array(query("SELECT Count(*) FROM job_temp"));

		if ( $Tmp[0] == 0 )
		{
			$auto_skin_update	= "1";
			news_icon_maker();

			query("insert into job_temp set title='auto_skin_update'");

			go("/");
			exit;
		}
	}

	/*
	if ( $mem_id == '' )
	{
		msg("로그인후이용하세요");
		go("html_file.php?file=join.html&file2=default_non.html");
		exit;
	}
	*/
	#$_COOKIE[job_adultcheck];

	# 메인페이지 제네레이팅 By Kwak16 #
	function main_page_login_print()
	{
		global $main_page_login;
		foreach ( $main_page_login AS $key => $val )
		{
			echo "
				<div id='main_page_login_org_$key' style='display:none'>".$val."</div>
				<script>
					var login_box_obj	= document.getElementById('main_page_login_$key');
					var login_box_obj2	= document.getElementById('main_page_login_org_$key');

					if ( login_box_obj != undefined && login_box_obj2 != undefined )
					{
						login_box_obj.innerHTML	= login_box_obj2.innerHTML;
					}
				</script>
			";
		}
	}

	$main_page_make_now	= '';
	$main_page_remake	= false;
	if ( $main_page_make_use == 1 && $_COOKIE['happy_mobile'] != 'on' )
	{
		$main_page_make_now	= rand(0,$main_page_make_count);
		$nowTimeStamp		= happy_mktime() - $main_page_make_time;

		$login_member_id	= trim($happy_member_login_value);																		# 솔루션별로 다름. ★☆★ 이줄만.
		$main_page_login[0]	= happy_member_login_form('top_login.html','top_logout.html','return');								# 솔루션별로 다름. ★☆★ 이줄만.
		$main_page_login[1]	= happy_member_login_form('main_login.html','main_logout.html','return');	# 솔루션별로 다름. ★☆★ 이줄만.

		if (!admin_secure("슈퍼관리자전용"))																						# 솔루션별로 다름. ★☆★ 이줄만.
		{
			$main_page_make_group	= 'master_';
		}
		else if ( $login_member_id != '' )
		{
			$Sql					= "SELECT `group` FROM $happy_member WHERE user_id = '$login_member_id' ";
			$Tmp					= happy_mysql_fetch_array(query($Sql));
			$main_page_make_group	= $Tmp['group']. '_';
		}
		else
		{
			$main_page_make_group	= '';
		}
		$main_page_make_now	= $main_page_make_group. $main_page_make_now;

		if ( $handle = opendir($main_page_make_folder) )
		{
			$i					= 0;
			while ( false !== ($file = readdir($handle)) )
			{
				if ( $file != "." && $file != ".." )
				{
					$tmp					= explode('.', $file);
					$MAINS[$tmp[0]]['name']	= $file;
					$MAINS[$tmp[0]]['time']	= filemtime($main_page_make_folder.'/'.$file);
				}
			}
			closedir($handle);
		}

		if ( $MAINS[$main_page_make_now]['name'] == '' || $nowTimeStamp > $MAINS[$main_page_make_now]['time'] )
		{
			$main_page_remake	= true;
		}
		else if ( $MAINS[$main_page_make_now]['name'] != '' && $nowTimeStamp <= $MAINS[$main_page_make_now]['time'] )
		{
			include $main_page_make_folder.'/'.$main_page_make_now.'.html';

			main_page_login_print();

			if ( $demo_lock == '1' )
			{
				$exec_time = array_sum(explode(' ', microtime())) - $t_start;
				$exec_time = round ($exec_time, 2);
				$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";
				print $쿼리시간;
			}

			exit;
		}

	}
	# 메인페이지 제네레이팅 By Kwak16 #

	$main_flash = main_flash();

	$TPL->define("메인", "./$skin_folder/main.html");
	$content = $TPL->fetch("메인");
	//$TPL->assign("메인");
	//$TPL->tprint();
	echo $content;

	# 메인페이지 제네레이팅 By Kwak16 #
	if ( $main_page_make_use == 1 && $main_page_remake == true && $main_page_make_now != '' && $_COOKIE['happy_mobile'] != 'on' )
	{
		#echo $main_page_make_folder.'/'.$main_page_make_now.'.html'.' 생성됨';
		$fp					= fopen($main_page_make_folder.'/'.$main_page_make_now.'.html', 'w');
		fwrite($fp,$content);
		fclose($fp);

		main_page_login_print();
	}
	# 메인페이지 제네레이팅 By Kwak16 #

	if ($demo)
	{
		$exec_time = array_sum(explode(' ', microtime())) - $t_start;
		$exec_time = round ($exec_time, 2);
		print   "<center><font color=gray size=1>Query Time : $exec_time sec";
	}


	#$CONF['document_year_update']	= 22;
	#년도가 바뀔경우 이력서 나이 정리
	if ( $CONF['document_year_update'] < date("Y") )
	{
		$Sql	= "SELECT user_id as id,user_birth_year as per_birth FROM $happy_member ";
		$Record	= query($Sql);

		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Data["age"]	= date("Y") - substr($Data["per_birth"],0,4) + 1;
			query("UPDATE $per_document_tb SET user_age='$Data[age]' WHERE user_id='$Data[id]'");
		}

		query("UPDATE $conf_table SET value='". date("Y") ."' WHERE title='document_year_update'");

		#echo "<br>업데이트완료";
	}




?>