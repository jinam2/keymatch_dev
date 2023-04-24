<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/lib.php");
include ("./inc/lib_pay.php");

if($pg_company_info == "daoupay")
{
	$pg_target	= ($_COOKIE['happy_mobile'] != "on")?"opener.top.opener":"top";
	if($_GET['location_chk'] != 1)
	{
		echo "
				<script>
					{$pg_target}.location.href='$_SERVER[REQUEST_URI]&location_chk=1';
					window.close();
					opener.top.close();
				</script>
		";
		exit;
	}
}

#$category_info = category_read();
#member_check(); #서버부하↑


$res_cd = $_REQUEST[respcode];
$oid = $_REQUEST['or_no'];


if( happy_member_login_check() == "" )
{
	gomsg("회원로그인후 사용할수 있는 페이지입니다","index.php");
	exit;
}


if ($res_cd == "0000")  //결제 성공
{
	$현재위치	= "$prev_stand > <a href='./member_index.php'>마이페이지</a> > 포인트결제성공";
	$template	= $main_url."/html_file.php?file=point_pay_success.html&file2=default.html";
}
else
{
	$현재위치 = "$prev_stand > <a href='./member_index.php'>마이페이지</a> > 포인트유료결제실패";
	$template	= $main_url."/html_file.php?file=my_pay_failure.html&file2=default.html";
}



echo "<script>window.location.href = '$template';</script>";
/*
echo "
	<script>
	top.opener.top.location.href= '".$template."';
	top.self.close();
	</script>
";
*/
exit;





?>