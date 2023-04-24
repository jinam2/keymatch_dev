<?

	include ("./inc/config.php");
	include ("./inc/Template.php");
	$t_start = array_sum(explode(' ', microtime()));
	$TPL = new Template;
	include ("./inc/function.php");
	include ("./inc/lib.php");

	$mode	= $_GET['mode'];

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
	$per_cell	= $_GET['per_cell'];
	$mem_id		= $_GET['mem_id'];
	$per_cell2	= preg_replace("/\-/","",$per_cell);



	if ( $per_cell == "" ) {
		msgclose("핸드폰 번호를 입력하세요");
		exit;
	}

	if ( preg_match("/[a-zA-Zㄱ-힝]/",$per_cell) )
	{
		msgclose("핸드폰 번호의 형식이 틀렸습니다.");
		exit;
	}




	$happy_member_login_id	= happy_member_login_check();
	$id_q = "";
	if ( $happy_member_login_id != "" )
	{
		$id_q = " and user_id <> '".$happy_member_login_id."' ";
	}

	$sql = "select * from $happy_member where ( user_hphone='$per_cell' or user_hphone = '$per_cell2' ) $id_q ";
	$result = query($sql);
	$pid = mysql_fetch_row($result);

	if( $pid[0] && $_SESSION['user_id_quies'] == "")
	{
		if($_COOKIE['happy_mobile'] != 'on')
		{
			echo "
					<form name='f' method='get' action='$PHP_SELF' style='margin:0px; padding:0px; height:100%;'>
					<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
					<tr>
						<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
							<strong>※ 휴대폰인증</strong>
						</td>
					</tr>
					<tr>
						<td style='text-align:center;'>
							<div>$per_cell<div>
							<div style='color:#333333; font-size:12px; margin-top:10px; line-height:20px;'>사용중인 핸드폰번호입니다.<br />새로운 핸드폰번호를  입력해 주세요.</div>
							<div style='margin-top:10px;'>
								<input type='text' name='per_cell' style='width:80%; height:30px; line-height:30px; padding-left:10px; border:2px solid #dfdfdf; background:#fafafa;'>
							</div>
						</td>
					</tr>
					<tr>
						<td style='height:40px;'>
							<input type='submit' value='중복 확인' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
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
							<strong>※ 휴대폰인증</strong>
						</td>
					</tr>
					<tr>
						<td style='text-align:center;'>
							<div>$per_cell<div>
							<div style='color:#333333; font-size:12px; margin-top:10px; line-height:20px;'>사용중인 핸드폰번호입니다.<br />새로운 핸드폰번호를  입력해 주세요.</div>
							<div style='margin-top:10px;'>
								<input type='text' name='per_cell' style='width:80%; height:30px; line-height:30px; padding-left:10px; border:2px solid #dfdfdf; background:#fafafa;'>
							</div>
						</td>
					</tr>
					<tr>
						<td style='height:40px;'>
							<input type='submit' value='중복 확인' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
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
					<form name='f' method='post' action='happy_member_check_phone_confirm.php'style='margin:0px; padding:0px; height:100%;'>
					<input type=hidden name=per_cell value='$per_cell'>
					<input type='hidden' name='quies_mode' value='$quies_mode'> <!-- happy_member_quies -->
					<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
					<tr>
						<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
							<strong>※ 휴대폰인증</strong>
						</td>
					</tr>
					<tr>
						<td style='text-align:center;'>
							<div style='color:#333333; font-size:20px;'><strong>$per_cell</strong><div>
							<div style='color:#333333; font-size:12px; margin-top:10px; line-height:20px;'>휴대폰 번호로 인증을 시작합니다.</div>
						</td>
					</tr>
					<tr>
						<td style='height:40px;'>
							<input type='submit' value='인증번호받기' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
						</td>
					</tr>
					</table>
					</form>

			";
		}
		else
		{
			echo "
					<form name='f' method='post' action='happy_member_check_phone_confirm.php'style='margin:0px; padding:0px; height:100%;'>
					<input type=hidden name=per_cell value='$per_cell'>
					<input type='hidden' name='quies_mode' value='$quies_mode'> <!-- happy_member_quies -->
					<table cellpadding='0' cellspacing='0' border='0' style='width:100%; height:100%;'>
					<tr>
						<td style='height:40px; color:#ffffff; font-size:12px; background:#333333; padding-left:10px;'>
							<strong>※ 휴대폰인증</strong>
						</td>
					</tr>
					<tr>
						<td style='text-align:center;'>
							<div style='color:#333333; font-size:20px;'><strong>$per_cell</strong><div>
							<div style='color:#333333; font-size:12px; margin-top:10px; line-height:20px;'>휴대폰 번호로 인증을 시작합니다.</div>
						</td>
					</tr>
					<tr>
						<td style='height:40px;'>
							<input type='submit' value='인증번호받기' style='width:100%; background:#333333; color:#e8c643; font-size:12px; border:0px; height:40px; font-weight:bold; cursor:pointer;'>
						</td>
					</tr>
					</table>
					</form>

			";
		}
	}

?>

</body>
</html>