<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	if ($demo == "1")
	{
		error("데모버젼은 삭제되지 않습니다");
		exit;
	}

	if (!$master_check)
	{
		if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] )
		{
			gomsg("회원 로그인 후 사용하세요","./happy_member_login.php");
			exit;
		}
	}
	else
	{
		print "<html><title>슈퍼관리자로그인중</title>";
	}


	if ( $mode == "guzic" )
	{
		$sql = "delete from $job_per_document where number='$num'";
		$result = query($sql);
		go("./happy_member.php?mode=mypage");
	}
	elseif ( $mode == "guin" )
	{
		$num = $_GET[num];
		#자신이 등록한 채용정보인지 확인
		$sql = "select * from $guin_tb where number='$num'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);


		if (!$master_check)
		{
			if ($DETAIL[guin_id] != $member_id)
			{
				error("자신이 등록한 채용정보만 삭제가 가능합니다.");
				exit;
			}
		}

		//첨부1~5 이미지 파일삭제
		for( $i=1; $i<=5; $i++ )
		{
			$fname = "img".$i;
			if( $DETAIL[$fname] != "" )
			{
				unlink_with_thumb($DETAIL[$fname]);
			}
		}


		$sql = "delete from $guin_tb where number='$num'";
		$result = query($sql);

		if ( admin_secure("구인리스트") )
		{
			go("admin/guin.php?a=guin&mode=list");
		}
		else
		{
			go("./happy_member.php?mode=mypage");
		}
	}


?>