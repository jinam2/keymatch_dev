<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");

/* 이력서정보가 없는 장부내역은 삭제해주자
$sql = "select * from $jangboo2";
$result = query($sql);
while($MONEY = happy_mysql_fetch_assoc($result)) {
	$sql1 = "select count(*) as cnt1 from $per_document_tb where number = '$MONEY[links_number]'";
	$result1 = query($sql1);
	$guin_tb2 = happy_mysql_fetch_assoc($result1);

	if ($guin_tb2[cnt1] == "0") {
		$sql2 = "delete from $jangboo2 where number='$MONEY[number]'";
		echo "이력서정보에 없는 $MONEY[number] 번 내역은 삭제합니다.<br>".$sql2."<br>";
		query($sql2);
	}
}
*/

#$ex_limit = '20';

if ( happy_member_login_check() == "" && !$HTTP_COOKIE_VARS["ad_id"] )
{
	gomsg("회원로그인후 사용할수 있는 페이지입니다","./happy_member_login.php");
	exit;
}

$서비스이용항목 = get_uryo_cnt(2,2);

$TPL->define("리스트", "$skin_folder/my_jangboo_per.html");
$TPL->assign("리스트");
$내용 = &$TPL->fetch();


$현재위치 = "$prev_stand > <a href=member_info.php>마이페이지</a> > 유료결제내역";


$happy_member_login_id	= happy_member_login_check();

if ( $happy_member_login_id == "" && happy_member_secure( '마이페이지' ) )
{
	error("관리자라도 마이페이지에 접근하기 위해서는 회원으로 로그인을 하셔야 합니다.");
	exit;
}

$Member					= happy_member_information($happy_member_login_id);
$member_group			= $Member['group'];

$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
$Group					= happy_mysql_fetch_array(query($Sql));

$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
$Template				= $happy_member_skin_folder.'/'.$Template;


$TPL->define("껍데기", "./$skin_folder/$Template_Default");
$TPL->assign("껍데기");
$ALL = &$TPL->fetch();
echo $ALL;
exit;




?>