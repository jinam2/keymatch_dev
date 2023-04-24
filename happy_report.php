<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	//상세페이지신고

	//print_r2($_SERVER);

	if ( $happy_member_login_value == '' )
	{
		if ( $happy_nomember_report_use == true )
		{
			//비회원 신고가능
			$report_id		= $_SERVER['REMOTE_ADDR'];
		}
		else
		{
			msgclose('로그인을 해주세요.');
			exit;
		}
	}
	else
	{
		$report_id		= $happy_member_login_value;
	}


	$mode				= $_POST['mode'];

	/*
	$Sql				= "
							SELECT
									report_get
							FROM
									$message_tb
							WHERE
									sender_id	= '$report_id'
	";
	$Temp				= happy_mysql_fetch_assoc(query($Sql));

	if ( $Temp[0] > 0 )
	{
		msgclose('이미 신고하셨습니다.');
		exit;
	}
	*/

	if ( $mode == 'insert' )
	{
		//도배방지키
		if ( $_POST['dobae'] == '' )
		{
			msg('도배방지키를 입력하세요');
			exit;
		}

		$_POST['dobae']	= preg_replace('/\D/', '', $_POST['dobae']);
		$G_dobae		= $_POST['dobae_org'] + $_POST['dobae'];

		if ( $G_dobae != $dobae_number || strlen($_POST['dobae']) != 4  )
		{
			msg('도배방지키를 정확히 입력하세요.');
			exit;
		}

		$report_get		= strip_tags($_POST['report_get']);
		$report_post	= $_POST['report_post'];

		$message		= strip_tags($_POST['message']);

		$MyInfo			= happy_member_information($report_id);

		$Sql			= "
							INSERT INTO
									$message_tb
							SET
									sender_id		= '$report_id',
									sender_name		= '$MyInfo[user_name]',
									sender_admin	= 'n',

									receive_id		= '$admin_id',
									receive_name	= '관리자',
									receive_admin	= 'y',

									message			= '$message',
									regdate			= NOW(),
									readok			= 'n',

									report_get		= '$report_get',
									report_post		= '$report_post'
		";
		query($Sql);

		echo "
				<script type='text/javascript'>
					alert('신고 되었습니다.');
					top.window.close();
				</script>
		";

		exit;
	}
	else
	{
		if ( $happy_member_login_value == '' && $happy_nomember_report_use == true )
		{
			$report_id		= "<b style='color:blue;'>비회원</b>";
		}

		$report_post	= $_GET['report_post'];

		//도배방지키
		$dobae_1		= rand(1,9);
		$dobae_2		= rand(1,9);
		$dobae_3		= rand(1,9);
		$dobae_4		= rand(1,9);
		$gara1			= "<font color=#999999>".rand(0,9)."</font>";
		$gara2			= "<font color=#999999>".rand(0,9)."</font>";
		$gara3			= "<font color=#999999>".rand(0,9)."</font>";
		$gara4			= "<font color=#999999>".rand(0,9)."</font>";
		$rand1			= rand(100,9000);
		$rand2			= rand(100,9000);
		$rand3			= rand(100,9000);
		$rand4			= rand(100,9000);
		@eval('$dobae_org =' .$dobae_1.$dobae_2.$dobae_3.$dobae_4. ';');
		$dobae_org		= $dobae_number - $dobae_org;

		$report_dobae	= "&nbsp;";
		$report_dobae	.= $dobae_1 . "$gara1<img src=img/dot.gif name=bbs_name0 $rand1><span style=disply:none bt_adminlogout_login></span>";
		$report_dobae	.= $dobae_2 . "$gara2<img src=img/dot.gif name=pass happycgi.com=test$rand2>";
		$report_dobae	.= $dobae_3 . "$gara3<img src=img/dot.gif name=email happycgi.com=cgimall.co.kr-$rand3>";
		$report_dobae	.= $dobae_4 . "$gara4<img src=img/dot.gif name=comment happycgi.com=$rand4>";
	}

	$TPL->define("신고페이지", "$skin_folder/happy_report.html");
	$content		= $TPL->fetch("신고페이지");

	echo $content;
?>