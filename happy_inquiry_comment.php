<?php
	$t_start = array_sum(explode(' ', microtime()));

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	#load_config();

	$happy_member_login_id	= happy_member_login_check();

	if( $happy_member_login_id == ""  ) {
		$returnUrl = $_SERVER['PHP_SELF']."?mode=".$_GET['mode'];

		gomsg("로그인후 이용가능합니다.",$main_url."/happy_member_login.php?returnUrl=".$returnUrl);
		exit;
	}

	$mode					= ( $_GET['mode'] != "" ) ? $_GET['mode'] : $_POST['mode'];

	switch ( $mode )
	{
		case 'reg_ok' :
		{
			$inquiry_number		= ( $_GET['inquiry_number'] != "" ) ? $_GET['inquiry_number'] : $_POST['inquiry_number'];
			$view_mode			= ( $_GET['view_mode'] != "" ) ? $_GET['view_mode'] : $_POST['view_mode'];

			if ( $inquiry_number == "" )
			{
				error("문의 고유번호가 없습니다.");
				exit;
			}

			$Sql				= "SELECT * FROM $happy_inquiry WHERE number = '$inquiry_number' ";
			$Result				= query($Sql);
			$Data				= happy_mysql_fetch_array($Result);

			$Sql				= "SELECT * FROM $happy_inquiry_links WHERE number='$Data[links_number]' ";
			$Result				= query($Sql);
			$Links				= happy_mysql_fetch_array($Result);

			if ( $happy_member_login_id != $Data['send_id'] && $happy_member_login_id != $Data['receive_id'] )
			{
				error('권한이 없습니다.');
				exit;
			}

			$comment			= $_POST['comment'];
			$user_ip			= $_SERVER['REMOTE_ADDR'];

			$Sql				= "
									INSERT INTO
											$happy_inquiry_comment
									SET
											links_number		= '$inquiry_number',
											id					= '$happy_member_login_id',
											comment				= '$comment',
											user_ip				= '$user_ip',
											reg_date			= now()
			";
			query($Sql);

			gomsg("댓글이 작성 되었습니다.","happy_inquiry_view.php?mode=$view_mode&number=$inquiry_number");
			break;
		}

		case 'del' :
		{
			$comment_number		= ( $_GET['comment_number'] != "" ) ? $_GET['comment_number'] : $_POST['comment_number'];
			$view_mode			= ( $_GET['view_mode'] != "" ) ? $_GET['view_mode'] : $_POST['view_mode'];

			if ( $comment_number == "" )
			{
				error("댓글 고유번호가 없습니다.");
				exit;
			}

			$Sql				= "SELECT * FROM $happy_inquiry_comment WHERE number = '$comment_number' ";
			$Result				= query($Sql);
			$Reply				= happy_mysql_fetch_array($Result);

			if ( $happy_member_login_id != $Reply['id'] )
			{
				error('자신의 댓글만 삭제할 수 있습니다.');
				exit;
			}

			$Sql				= "SELECT * FROM $happy_inquiry WHERE number = '$Reply[links_number]' ";
			$Result				= query($Sql);
			$Data				= happy_mysql_fetch_array($Result);

			if ( $happy_member_login_id != $Data['send_id'] && $happy_member_login_id != $Data['receive_id'] )
			{
				error('권한이 없습니다.');
				exit;
			}

			query("DELETE FROM $happy_inquiry_comment WHERE number = '$comment_number'");

			gomsg("댓글이 삭제 되었습니다.","happy_inquiry_view.php?mode=$view_mode&number=$Reply[links_number]");
			break;
		}

	}
?>