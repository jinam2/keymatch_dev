<?php
	$t_start = array_sum(explode(' ', microtime()));
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$TPL = new Template;
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


	if( !(is_file("$skin_folder_bbs/$B_CONF[board_temp_detail]")) )
	{
		print "리스트페이지 $skin_folder_bbs/$B_CONF[board_temp_detail] 파일이 존재하지 않습니다. <br>";
		return;
	}


	#읽을수 있는 회원인가?
	if ($master_check != "1")
	{
		if ( !happy_member_secure('%게시판%'.$tb.'-view') )
		{
			error ("접속 권한이 없습니다.");
			exit;
		}
	}


	########################################################################
	# 게시판읽기
	########################################################################
	$sql = "select * from $tb where number='$bbs_num'";
	$result = query($sql);
	$BOARD = happy_mysql_fetch_array($result);

	#잠긴글일 경우 처리해줌 2009-10-13 kad
	$can_view = false;
	if ( $BOARD['view_lock'] )
	{
		#게시글 볼 권한 체크
		$can_view = can_view($BOARD,$tb);
	}
	else
	{
		$can_view = true;
	}
	#echo var_dump($can_view);

	if ( $can_view == false )
	{
		$BOARD['bbs_review'] = '잠긴글입니다.';
	}

	function can_view($BOARD,$tb)
	{
		global $mem_id;

		#자기가 작성한것은 볼수 있다
		if ( $BOARD['bbs_id'] == $mem_id && $mem_id)
		{
			return true;
		}

		#관리자면 다 봐야 한다.
		#echo var_dump(admin_secure("게시판관리"));
		if ( admin_secure("게시판관리") )
		{
			return true;
		}

		#답글일경우 원본글 작성자면 답글을 봐야 한다
		$uDepth	= $BOARD['depth'] - 1;
		$Sql	= "SELECT bbs_id FROM $tb WHERE groups='$BOARD[groups]' AND ( depth='$uDepth' or depth='0' )";
		$rTmp	= query($Sql);

		while ( $Tmp = happy_mysql_fetch_array($rTmp) )
		{
			if ( $Tmp[0] == $mem_id && $mem_id)
			{
				return true;
			}
		}

		#비밀번호가 존재하는 글이면 넘어온 비번과 같은지 확인
		if ( $BOARD['bbs_pass'] != '' )
		{
			if ( $BOARD['bbs_pass'] == $_GET['write_password'] )
			{
				return true;
			}
		}

		return false;

	}

	print <<<END

	<html>
	<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<!--수정시작-->
	<title>$site_name</title>

	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" type="text/css" href="css/common.css"/>

	<!-- 폼/SVG/게시판 -->
	<link rel="stylesheet" type="text/css" href="css/uikit/uikit.css" />
	<link rel="stylesheet" type="text/css" href="css/theme1/h_form.css">
	<link rel="stylesheet" type="text/css" href="css/bbs_style.css"/>
	<!-- 폼/SVG/게시판 -->

	<!-- SVG 아이콘-->
	<script language="javascript" type="text/javascript" src="js/uikit/uikit.js"></script>
	<script language="javascript" type="text/javascript" src="js/uikit/uikit-icons.js"></script>
	<!-- SVG 아이콘-->

	<script language="javascript" type="text/javascript" src="js/jquery-1.11.3.js"></script>

	<script language="javascript">
	<!--
		function copyit(param) {

			/*
			var val=eval("document."+param);
			val.focus();
			val.select();
			therange=val.createTextRange();
			therange.execCommand("Copy");
			*/

			//textarea value를 선택
			$('#area').select();

			try //복사 성공
			{
				var successful = document.execCommand('copy');
				alert('복사되었습니다.');

			}
			catch (err) //복사 실패
			{
				alert('이 브라우저는 지원하지 않습니다.')
			}
		}

	//-->
	</script>
	</head>
	<body>
		<form name="frm" style='margin:0px'>
		<div style='padding:20px;'>
			<div class='font_20 font_malgun'><strong>소스보기</strong></div>
			<div class='h_form' style="margin-top:10px;"><textarea name="area" id="area" style='width:100%; height:250px; background:#fafafa;'>$BOARD[bbs_review]</textarea></div>
			<div class='h_form' style="margin-top:20px; text-align:center;">
				<a href='javascript:void(0);' uk-icon="icon:copy; ratio:1.0" class="icon_m uk-icon" onclick="copyit('frm.area')">복사하기</a>
			</div>
		</div>
		</form>
	</body>
	<!--수정끝-->
	</html>

END;

?>