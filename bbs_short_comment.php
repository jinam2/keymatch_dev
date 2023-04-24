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

	if ( $_POST['top_gonggi'] == "1" || $_GET['top_gonggi'] == "1" )
	{
		$tmp_tb = $board_top_gonggi;
		$check_board = "1";
		$top_gonggi_comment = "1";
	}
	else
	{
		$tmp_tb = $tb;
	}

	$bbs_num = preg_replace('/\D/', '', $bbs_num);

	if (admin_secure("게시판관리") )
	{
		$master_check = '1';
	}


	if ($check_board != "1")
	{
		error("해당 테이블이 존재하지 않습니다  ");
		exit;
	}

	if ( !happy_member_secure('%게시판%'.$tb.'-comment_write') )
	{
		error("게시글의 댓글달기가 불가능합니다  ");
		exit;
	}


	#저장할수 있는 정보인가보자
	if ($tb == "")
	{
		error("테이블 설정이 되지 않았습니다.");
		exit;
	}


	$sql = "select number from $tmp_tb where number = '$bbs_num' ";
	$result = query ($sql);
	$Board = happy_mysql_fetch_array($result);

	if($Board['number'] == "")
	{
		error("해당 게시글이 존재하지 않습니다.");
		exit;
	}

	if ($mem_id == "" && $master_check == "1")
	{
		$mem_id = "관리자";
	}

	$short_comment		= $_POST['short_comment_real'];
	$_POST['dobae']		= $_POST['dobae_real'];
	$_POST['password']	= $_POST['password_real'];
	$action				= ($_POST['action_real'] != '')?$_POST['action_real']:$action;
	$short_comment		= strip_tags($short_comment);


	if ($action == "add")
	{
		if ($short_comment == "")
		{
			error("내용을 입력하세요");
			exit;
		}
		if ($bbs_num == "")
		{
			error("게시글 번호설정이 되지 않았습니다");
			exit;
		}

		// 비회원은 도배방지키 체크
		if ( $happy_member_login_value == "" && $_COOKIE['ad_id'] == "" )
		{
			#######################################################################################################
			# 도배방지키 : NeoHero 2009.08.01
			#######################################################################################################
			if (!$_POST[dobae]){
				error('도배방지키를 입력하세요');
				exit;
			}
			$_POST[dobae] = preg_replace('/\D/', '', $_POST[dobae]);
			$G_dobae = $_POST[dobae_org] + $_POST[dobae];

			#echo var_dump($G_dobae != $dobae_number || strlen($_POST[dobae]) != 4);
			if ( $G_dobae != $dobae_number || strlen($_POST[dobae]) != 4  ){
				error('도배방지키를 정확히 입력하세요   ');
				exit;
			}
			#######################################################################################################
		}

		$sql = "select count(*) from $board_short_comment where tbname = '$tmp_tb' and board_number = '$bbs_num' ";
		$result = query ($sql);
		list($t_comment) = mysql_fetch_row($result);


		$password	= $mem_id == ""? md5($_POST['password'])	: "";

		$user_ip	= $_SERVER['REMOTE_ADDR'];
		$is_admin	= '';
		if ( $master_check == "1" )
		{
			$is_admin	= '1';
			$mem_id		= '';
		}

		if ( $_POST['parent_number'] != "" )
		{
			$parent_number		= preg_replace("/\D/", "",$_POST[parent_number]);
			$parent_number_org	= $parent_number;

			$Sql				= "select number, tbname, board_number, comment_group, depth, comment_seq from $board_short_comment where number='$parent_number_org' ";
			$Parent				= happy_mysql_fetch_array(query($Sql));


			if( $Parent['tbname'] != $tmp_tb )
			{
				error("잘못된 게시판명입니다.");
				exit;
			}
			if( $Parent['board_number'] != $bbs_num )
			{
				error("잘못된 게시글 번호입니다.");
				exit;
			}
			if( $Parent['number'] != $parent_number_org )
			{
				error("기존 댓글이 삭제 되었습니다.");
				exit;
			}

			$Depth				= $Parent[depth] + 1;
			$Groups				= $Parent[comment_group];
			$seq_num			= $Parent[comment_seq];

			if($Depth > $recomment_depth)
			{
				error("더 이상 대댓글을 달 수 없습니다.");
				exit;
			}

			for($i=0; $i<=20; $i++)
			{
				$again_sql			= "select number,comment_seq from $board_short_comment where parent_number='$parent_number' order by comment_seq desc limit 0,1 ";
				$again				= happy_mysql_fetch_array(query($again_sql));

				if($again['number'] == "")
				{
					break;
				}
				else
				{
					$parent_number	= $again[number];
					$seq_num			= $again[comment_seq];
				}
			}

			$seq_num++;
			$seq = $seq_num;

			$sql = "update $board_short_comment set comment_seq = comment_seq + 1 where comment_group = '$Groups' and comment_seq >= '$seq'";
			$result = query($sql);
		}
		else
		{
			$Depth = 0;
			$Groups = 0;
		}


		$Sql2 = "
				insert into
					$board_short_comment
				set
					tbname			= '$tmp_tb',
					board_number	= '$bbs_num',
					id				= '$mem_id',
					password		= '$password',
					comment			= '$short_comment',
					reg_date		= now(),
					user_ip			= '$user_ip',
					is_admin		= '$is_admin',
					depth			= '$Depth',
					comment_group	= '$Groups',
					parent_number = '$parent_number_org',
					comment_seq = '$seq'
		";
		$result = query($Sql2);


		if($Depth == 0)
		{
			$Sql22	= "SELECT LAST_INSERT_ID();";
			$result22	= query($Sql22);
			list($Update_Number)= mysql_fetch_row($result22);

			$Sql	= "
									UPDATE
											$board_short_comment
									SET
											comment_group = '$Update_Number'
									WHERE
											number	= '$Update_Number'
						";
			query($Sql);
		}
		else
		{
			$Sql	= "
					SELECT
							number,comment_group
					FROM
							$board_short_comment
					WHERE
							number = '$Groups'
			";
			$Tmp	= happy_mysql_fetch_array(query($Sql));
			$Update_Number	= $Tmp[number];
			if ( $Tmp['comment_group'] == 0 )
			{

				$Sql	= "
									UPDATE
											$board_short_comment
									SET
											comment_group = '$Update_Number'
									WHERE
											number	= '$Update_Number'
						";
				query($Sql);
			}
		}




		$sql = "update $tmp_tb set bbs_etc2 = $t_comment + 1 where number = '$bbs_num' ";
		$result = query($sql);
		msg("댓글이 등록되었습니다");
		echo "
		<script>
			top.location.reload();
		</script>";
		exit;
	}
	elseif ($action == "mod")
	{

		if ( !happy_member_secure('%게시판%'.$tb.'-comment_write') && $master_check != '1' && $mini_board_secure != 'ok')
		{
			error ("권한이 없습니다.");
			exit;
		}

		if ($short_comment == ""){
		error("내용을 입력하세요");
		exit;
		}
		if ($bbs_num == ""){
		error("게시글 번호설정이 되지 않았습니다");
		exit;
		}


		$number		= $_POST['parent_number'];

		if ( !admin_secure("게시판관리") )
		{
			//비회원이 작성
			if ( $happy_member_login_value == "" )
			{
				$password	= md5($_POST['password']);

				list($tmp)	= mysql_fetch_row(query("select count(*) from $board_short_comment where number = '$number' and password = '$password'"));

				if ( $tmp < 1 )
				{
					msg("패스워드가 일치하지 않습니다.");
					exit;
				}
			}
			//회원이 작성
			else if ( $happy_member_login_value != "" )
			{
				list($tmp)	= mysql_fetch_row(query("select id from $board_short_comment where number = '$number'"));

				if ( $tmp != $happy_member_login_value )
				{
					msg("댓글을 작성한 회원만 수정이 가능합니다.");
					exit;
				}
			}
		}

		$sql = "
				update
					$board_short_comment
				set
					comment = '$short_comment'
				where
					number = $number
		";

		$result = query($sql);


		msg("댓글이 수정되었습니다");

		if($tb == "board_detail_gallery")
		{
			$sql = "select links_number from $tb where number = '$bbs_num'";
			list($links_number) = happy_mysql_fetch_array(query($sql));
		}

		if($tb == $board_detail_gallery && $links_number != "")
		{
			echo "
					<script type='text/javascript'>
						parent.location.href='bbs_detail.php?id=$_GET[id]&tb=$tb&bbs_num=$bbs_num&pg=$pg&links_number=$links_number';
					</script>
				";
			exit;
		}
		else
		{
			echo "
				<script>
					top.location.reload();
				</script>
			";
		}

		exit;
	}
	elseif ($action == "del")
	{
		if ( !happy_member_secure('%게시판%'.$tb.'-comment_delete') )
		{
			error ("권한이 없습니다.");
			exit;
		}

		if ($master_check == "1" )
		{
			$id_del = "";
		}
		else
		{
			$id_del = " and id = '$mem_id' ";
		}

		if ( $happy_member_login_value == "" && $_COOKIE['ad_id'] == "" )
		{
			$password	= md5($_GET['password']);
			$number		= $_GET['number'];
			list($tmp)	= mysql_fetch_row(query("select count(*) from $board_short_comment where number = '$number' and password = '$password'"));

			if ( $tmp < 1 )
			{
				error("패스워드가 일치하지 않습니다.");
				exit;
			}
		}
		#답글 체크후 답글 있을경우 삭제불가능
		list($groups,$seq,$depth)	= happy_mysql_fetch_array(query("SELECT comment_group,comment_seq,depth FROM $board_short_comment WHERE number='$number'"));

		list($CountChk)				= happy_mysql_fetch_array(query("SELECT Count(*) FROM $board_short_comment WHERE comment_group='$groups' AND parent_number='$number'"));



		if ( $CountChk > 0 )
		{
			error("대댓글이 있는 댓글은 삭제하실 수 없습니다.");
			exit;
		}

		$sql = "delete from $board_short_comment where number = '$number' $id_del ";
		$result = query($sql);

		$sql2 = "update $tmp_tb set bbs_etc2 = bbs_etc2 - 1 where number = '$bbs_num' ";
		$result2 = query($sql2);

	//	print "$sql <br> $sql2";
		go("bbs_detail.php?id=$_GET[id]&tb=$tb&bbs_num=$bbs_num&pg=$pg&top_gonggi=$top_gonggi_comment");
		exit;
	}
	else
	{
		error("잘못된 액션경로 $action");
		exit;
	}



?>