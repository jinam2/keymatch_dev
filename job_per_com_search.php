<?
	//개인회원이 기업회원별로 불량회원은 이력서를 못보도록 설정

	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] )
	{
		gomsg("로그인 후 이용하세요","./happy_member_login.php");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[0].'열람불가 설정') )
	{
		error($happy_member_secure_text[0].'열람불가 설정'."권한이 없습니다.");
		exit;
	}

	$keyword	= $_POST["keyword"];
	$mode		= $_POST["mode"];

	if ( $mode == "add_Action" )
	{
		$addList	= $_POST["addList"];

		for ( $i=0,$max=sizeof($addList) ; $i<$max ; $i++ )
		{
			$Sql	= "INSERT INTO $per_noViewList SET com_id='". $addList[$i] ."', per_id='$user_id' ";
			query($Sql);
		}

		echo "<script>parent.window.location.href='per_no_view_list.php';</script>";
		exit;
	}

	if ( $mode == "del_Action" )
	{
		$addList	= $_POST["addList"];

		for ( $i=0,$max=sizeof($addList) ; $i<$max ; $i++ )
		{
			$Sql	= "DELETE FROM $per_noViewList WHERE com_id='". $addList[$i] ."' AND per_id='$user_id' ";
			query($Sql);
		}
		echo "<script>parent.window.location.href='per_no_view_list.php';</script>";
		exit;
	}





	# 키워드가 없을시 전체목록이 나오도록 변경 ralear
	if ( $keyword == "" )
	{
		#echo "<center><font color='#666666' style='font-size:12px;'>검색어를 입력하세요</font></center>";
		$add_query = " and com_name != '' ";
	}

	$Sql	= "SELECT * FROM $happy_member WHERE com_name like '%". $keyword ."%' $add_query ";
	//echo $Sql;

	$Record	= query($Sql);

	$template2	= "job_per_noviewlist_serows.html";
	$Content	= "";
	$Count		= 0;

	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		/*
		$Sql	= "SELECT Count(*) FROM $per_noViewList WHERE per_id='$user_id' AND com_id='$Data[user_id]' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));
		#echo $Sql."<br />";
		if ( $Tmp[0] == 0 )
		{
			$Count++;
			$rand	= rand(0,10000);

			$Data['id'] = $Data['user_id'];
			$Data['main_item'] = $Data['extra14'];

			$TPL->define("본문내용".$rand, "$skin_folder/$template2");
			$TPL->assign("본문내용".$rand);
			$Content .= $TPL->fetch();
		}
		*/

		#print_r2($Data);

		$Count++;
		$rand		= rand(0,10000);

		$회사명		= $Data['com_name'];
		$업종		= $Data['extra13'];
		$대표자		= $Data['extra11'];
		$직원수		= $Data['extra2']."명";
		$설립연도	= $Data['extra1']."년";
		$주소		= $Data['user_addr1']." ".$Data['user_addr2']." (".$Data['user_zip'].")";

		//echo "$skin_folder/$template2";
		$TPL->define("본문내용".$rand, "$skin_folder/$template2");
		$TPL->assign("본문내용".$rand);
		$Content .= $TPL->fetch();
	}

	if ( $Count == 0 )
	{
		$Content	= "<br><center><font color='#666666' style='font-size:12px;'>검색된 내용이 없습니다</font></center>";
	}



####################################################################################################################################


	$내용		= $Content;
	$mode		= $_POST["mode"];

	$template	= "job_per_noviewlist_search.html";
	$TPL->define("껍질", "$skin_folder/$template");
	$TPL->assign("껍질");
	$ALL = &$TPL->fetch();

	echo $ALL;


?>