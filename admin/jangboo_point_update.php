<?php
include ("../inc/config.php");
include ("../inc/function.php");
include ("../inc/lib.php");

if ( !admin_secure("유료결재장부") ) {
	error("접속권한이 없습니다.");
	exit;
}

if ($_GET[action] == 'del_reg')
{
	del_reg();
	exit;
}
elseif ($_GET[action] == 'mod_reg')
{
	mod_reg();
	exit;
}


function del_reg()
{
	global $point_jangboo;

	$sql = "delete from $point_jangboo where number = '$_GET[number]' ";
	$result = query($sql);

	if ($_GET[pg] == '')
	{
		$pg = '1';
	}
	else
	{
		$pg = $_GET[pg];
	}

	go("jangboo_point.php?pg=$pg"); 
}

function mod_reg()
{
	global $point_jangboo;
	global $happy_member;


	

	if ($_POST[org_in_check] != $_POST[in_check])
	{
		if ($_POST[in_check] == '1')
		{
			$sql = "update $happy_member set point = point + '$_POST[org_point]' where user_id = '$_POST[id]'  ";
			$result = query($sql);
			$message = "\\n입금으로 변경되어 $_POST[id]님의 포인트가 $_POST[org_point] 올랐습니다\\n\\n";
		}
		else
		{
			$sql = "update $happy_member set point = point - '$_POST[org_point]' where user_id = '$_POST[id]'  ";
			$result = query($sql);
			$message = "\\n미입으로 변경되어 $_POST[id]님의 포인트가 $_POST[org_point] 차감되었습니다\\n\\n";
		}
	}


	$sql = "update $point_jangboo set 
	id = '$_POST[id]',
	pay_type = '$_POST[pay_type]',
	in_check = '$_POST[in_check]',
	reg_date = '$_POST[reg_date]'
	where number = '$_POST[number]' ";
	$result = query($sql);

	gomsg("$message"."업데이트가 완료되었습니다.   ",'jangboo_point.php');

}

?>