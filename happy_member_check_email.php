<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

?>

	<html>
	<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
	<meta name="format-detection" content="telephone=no"/>

	<style type='text/css'>
		html,body { height:100%; margin:0px; padding:0px;}
	</style>

	<script language='JavaScript' >

	//ID 체크후 값 되돌리기
	function lastsetting(per_cell) {
		opener.document.happy_member_reg.user_hphone.value = per_cell;
		self.close();
	}

	</script>
	</head>

	<body>


<?

	$happy_member_login_id	= $_COOKIE['happy_tmp_id'];

	$id_q = "";
	if ( $happy_member_login_id != "" )
	{
		$id_q = " and user_id <> '".$happy_member_login_id."' ";
	}



	if($_SESSION['user_id_quies'] != "")
	{
		$readonly	= "readonly";
	}



	$sql	= "select * from $happy_member where  user_email='$email'  $id_q ";
	$result	= query($sql);
	$pid	= mysql_fetch_row($result);


	if ( $_GET['mode'] == '' )
	{
		$email		= $_GET['email'];
		$mem_id		= $_GET['mem_id'];

		if ( $email == "" ) {
			msgclose("이메일 주소를 입력하세요");
			exit;
		}


		if( $pid[0] && $_SESSION['user_id_quies'] == "")
		{
			if($_COOKIE['happy_mobile'] != 'on')
			{
				echo "
						<form name='f' method='get' action='$PHP_SELF' style='margin:0px; padding:0px; height:100%;'>
						<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
						<tr>
							<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
								<strong>※ 이메일인증</strong>
							</td>
						</tr>
						<tr>
							<td style='text-align:center;'>
								<div style='color:#333333; font-size:12px;'>$email</div>
								<div style='color:#333333; font-size:12px; margin-top:10px; line-height:20px;'>사용중인 이메일 입니다. <br />새로운 이메일주소로 다시 입력해 주세요.</div>
								<div style='margin-top:10px;'>
									<input type='text' name='email' style='width:80%; height:30px; line-height:30px; padding-left:10px; border:2px solid #dfdfdf; background:#fafafa;'>
								</div>
							</td>
						</tr>
						<tr>
							<td style='height:40px;'>
								<input type='submit' value='창닫기' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;' onClick='self.close()'>
							</td>
						</tr>
						</table>
						</form>

				";
			}
			else
			{
				echo "
						<form name='f' method='get' action='$PHP_SELF' style='margin:0px; padding:0px; height:100%;'>
						<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
						<tr>
							<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
								<strong>※ 이메일인증</strong>
							</td>
						</tr>
						<tr>
							<td style='text-align:center;'>
								<div style='color:#333333; font-size:12px;'>$email</div>
								<div style='color:#333333; font-size:12px; margin-top:10px; line-height:20px;'>사용중인 이메일 입니다. <br />새로운 이메일주소로 다시 입력해 주세요.</div>
								<div style='margin-top:10px;'>
									<input type='text' name='email' style='width:80%; height:30px; line-height:30px; padding-left:10px; border:2px solid #dfdfdf; background:#fafafa;'>
								</div>
							</td>
						</tr>
						<tr>
							<td style='height:40px;'>
								<input type='submit' value='창닫기' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;' onClick='self.close()'>
							</td>
						</tr>
						</table>
						</form>

				";
			}
		}

		else
		{
			if($_COOKIE['happy_mobile'] != 'on')
			{
				echo "
						<form name='f' method='post' action='?mode=confirm1' style='margin:0px; padding:0px; height:100%;'>
						<input type='hidden' name='quies_mode' value='$quies_mode'> <!-- happy_member_quies -->

						<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
						<tr>
							<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
								<strong>※ 이메일인증</strong>
							</td>
						</tr>
						<tr>
							<td style='text-align:center;'>
								<input type='text' name='email' value='$email' $readonly style='width:80%; height:30px; line-height:30px; padding-left:10px; border:2px solid #dfdfdf; background:#fafafa;'>
								<div style='color:#333333; font-size:12px; line-height:20px; margin-top:10px;'>이메일 주소로 인증을 시작합니다.</div>
							</td>
						</tr>
						<tr>
							<td style='height:40px;'>
								<input type='submit' value='인증메일받기' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
							</td>
						</tr>
						</table>

						</form>
				";
			}
			else
			{
				echo "
						<form name='f' method='post' action='?mode=confirm1' style='margin:0px; padding:0px; height:100%;'>
						<input type='hidden' name='quies_mode' value='$quies_mode'> <!-- happy_member_quies -->

						<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
						<tr>
							<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
								<strong>※ 이메일인증</strong>
							</td>
						</tr>
						<tr>
							<td style='text-align:center;'>
								<input type='text' name='email' value='$email' $readonly style='width:80%; height:30px; line-height:30px; padding-left:10px; border:2px solid #dfdfdf; background:#fafafa;'>
								<div style='color:#333333; font-size:12px; line-height:20px; margin-top:10px;'>이메일 주소로 인증을 시작합니다.</div>
							</td>
						</tr>
						<tr>
							<td style='height:40px;'>
								<input type='submit' value='인증메일받기' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
							</td>
						</tr>
						</table>

						</form>
			";
			}
		}

	}
	else if ( $_GET['mode'] == 'email_mod' )
	{
		$email		= $_GET['email'];
		$mem_id		= $_GET['mem_id'];

		if ( $email == "" ) {
			msgclose("이메일 주소를 입력하세요");
			exit;
		}


		echo "
				<form name='f' method='post' action='?mode=confirm1' style='margin:0px; padding:0px; height:100%;'>
				<input type='hidden' name='email_mode' value='mod'>

				<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
				<tr>
					<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
						<strong>※ 이메일인증</strong>
					</td>
				</tr>
				<tr>
					<td style='text-align:center;'>
						<input type='text' name='email' value='$email' style='width:80%; height:30px; line-height:30px; padding-left:10px; border:2px solid #dfdfdf; background:#fafafa;'>
						<div style='color:#333333; font-size:12px; line-height:20px; margin-top:10px;'>
							이메일 주소 변경시 <b>이메일 인증전</b> 까지는 로그인이 <span color='#ff0000'>불가능</span>합니다.<br>
							회원정보 수정 즉시 로그아웃 되고수정 후 이메일 인증을 하셔야서비스 이용가능합니다.
						</div>
					</td>
				</tr>
				<tr>
					<td style='height:40px;'>
						<input type='submit' value='인증메일받기' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
					</td>
				</tr>
				</table>

				</form>
		";

	}
	else if ( $_GET['mode'] == 'confirm1' )
	{
		#echo "메일발송";
		#print_r($_POST);

		$email					= $_POST['email'];
		$email_set				= $_POST['email'];

		if ( $email == "" ) {
			error("이메일 주소를 입력하세요");
			exit;
		}

		if( $pid[0] && $_SESSION['user_id_quies'] == "")
		{
			error("사용중인 이메일입니다.");
			exit;
		}

		if ($_POST['email_mode'] == 'mod')
		{
			echo "<script>top.document.happy_member_reg.user_email.value = '$email';</script>";
		}

		//회원정보 이메일 업데이트 - ranksa
		if ($_COOKIE['happy_tmp_id'] != "") //회원가입후 로그인시 인증이면!
		{
			$Sql		= "UPDATE $happy_member SET user_email='$email_set' WHERE user_id='$_COOKIE[happy_tmp_id]' ";
			query($Sql);
		}
		//회원정보 이메일 업데이트 - ranksa 끝

		$md5_email	= md5($_POST['email']);
		$iso_number	= rand(1000000,9999999);
		$iso		= md5($happy_member_iso_email_code . $iso_number);

		$no_email	= md5(rand(10000000,900000000));
		$no_iso		= md5(rand(100000000,9000000000));
		$no_check	= md5(rand(100000000,9000000000).'abcdefghi'.$happy_member_iso_email_code.rand(100000000,9000000000));
		$timeOut	= md5($happy_member_iso_email_code);

		$인증링크	= $happy_member_main_url."happy_member_iso_email.php?email=$no_email&link=$md5_email&iso=$no_iso&style=$iso&timeOut=$timeOut&check=$no_check";


		$sql	= "DELETE  FROM $happy_member_email_confirm WHERE email_addr ='$email'";
		query($sql);

		$sql	= "
					INSERT INTO
							$happy_member_email_confirm
					SET
							email_addr		= '$email',
							confirm_code	= '$iso_number'
		";
		query($sql);

		$title		= "${site_name}에서 이메일인증 메일을 발송해드립니다.";

		$보낸시간	= date("Y-m-d h:i:s");
		$아이피		= getenv("REMOTE_ADDR");

		$TPL->define("인증메일발송","$happy_member_skin_folder/happy_member_email_iso.html");
		$content	= &$TPL->fetch();
		#echo $email	= 'kwak16@happycgi.com';

		//메일 함수 통합 - hong
		HappyMail($site_name, $happy_member_admin_email,$email,$title,$content);

		#msg('해당 이메일로 회원님의 정보가 발송되었습니다.   ');
		echo "
				<script>
					alert('해당 이메일로 인증메일이 발송되었습니다.\\n정보저장이 완료된후 해당 메일에 있는 인증버튼을 클릭해주시면 인증이 완료됩니다.');
					try
					{
						opener.document.happy_member_reg.user_email.value		= '$email';
						opener.document.happy_member_reg.user_email_check.value	= 'ok';
						opener.document.happy_member_reg.user_email.readOnly	= true;
					}
					catch (e) { }
					self.close();
				</script>
		";
		exit;
	}


?>

</body>
</html>