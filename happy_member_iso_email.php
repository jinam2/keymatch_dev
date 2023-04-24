<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$Sql			= "SELECT * FROM $happy_member_email_confirm WHERE md5(email_addr) = '$_GET[link]' ";
	$confirmData	= happy_mysql_fetch_array(query($Sql));

	if ( $confirmData['number'] == '' )
	{
		msgclose("일치하는 정보가 존재하지 않습니다.");
		exit;
	}


	if ( $_GET['timeOut'] != md5($happy_member_iso_email_code) )
	{
		msgclose("비정상적인 접근입니다.");
		exit;
	}

	if ( $_GET['style'] != md5($happy_member_iso_email_code . $confirmData['confirm_code']) )
	{
		msgclose("비정상적인 접근입니다.");
		exit;
	}


	$Sql	= "SELECT user_id, iso_email FROM $happy_member WHERE user_email='$confirmData[email_addr]' ";
	$Mem	= happy_mysql_fetch_array(query($Sql));

	
	if($_SESSION['user_id_quies'] != "")
	{
		$SWAP_MEMBER			= Array();
		$Sql					= "SELECT * FROM $happy_member_quies WHERE user_id='$_SESSION[user_id_quies]' ";
		$Rec					= query($Sql);
		while($MEMBER_QUIES		= happy_mysql_fetch_assoc($Rec))
		{
			$QUIES_DECRYPT	= happy_member_quies_crypt('decrypt',Array('user_email' => $MEMBER_QUIES['user_email']));
			if($QUIES_DECRYPT['user_email'] == $confirmData['email_addr'])
			{
				$SWAP_MEMBER	= $MEMBER_QUIES;
				break;
			}
		}

		if(sizeof($SWAP_MEMBER) == 0)
		{
			$_SESSION['user_id_quies']	= "";
		}
	}


	if ( $Mem['user_id'] == '' && $SWAP_MEMBER['user_id'] == '' ) //happy_member_quies
	{
		msgclose("인증을 받을 회원이 존재하지 않습니다. \\n(회원가입 완료후 인증버튼을 클릭해주세요.)   ");
		exit;
	}

	if($SWAP_MEMBER['user_id'] != '' && sizeof($SWAP_MEMBER) > 0) //happy_member_quies 휴면회원은 항상인증가능
	{
		happy_member_quies_move('decrypt',$SWAP_MEMBER);	//휴면해제
		$_SESSION['user_id_quies']	= "";

		$Mem['user_id']	= $SWAP_MEMBER['user_id'];
	}
	else
	{
		if ( $Mem['iso_email'] == 'y' )
		{
			msgclose("이미 인증을 받으셨습니다.");
			exit;
		}
	}


	$Sql	= "UPDATE $happy_member SET iso_email='y' WHERE user_id='$Mem[user_id]' AND user_email='$confirmData[email_addr]' ";
	query($Sql);

	msgclose("인증이 완료 되었습니다.");
	exit;

/*
	echo "<pre>";print_r($confirmData);echo "</pre>";
	echo "<pre>";print_r($Mem);echo "</pre>";
	echo "<pre>";print_r($_GET);echo "</pre>";


	echo "timeOut : ". md5($happy_member_iso_email_code);
	echo "<hr>";

	echo "style : ".  md5($happy_member_iso_email_code . $confirmData['confirm_code']);;
	echo "<hr>";
*/
?>