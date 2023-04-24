<?php
$t_start = array_sum(explode(' ', microtime()));

include ("./inc/Template.php");
$TPL = new Template;

include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");
$현재위치 = "$prev_stand > <a href=member_info.php>회원정보</a> > 채용정보스크랩";

if ( happy_member_login_check() == "" )
{
	go("./happy_member_login.php");
	exit;
}

$sql01 = "SELECT count(*) FROM job_guin AS A INNER JOIN job_scrap AS B ON A.number = B.cNumber WHERE ( A.guin_end_date >= curdate() OR A.guin_choongwon = '1' ) AND B.userid = '$user_id'";

list($scrap_cnt) = mysql_fetch_row(query($sql01));
$채용정보스크랩수 = number_format($scrap_cnt);


//개인회원 일때만 상단을 보여준다.
$guin_scrap_top_display_tag1 = ' style="display:none;" ' ;
$guin_scrap_top_display_tag2 = ' display:none; ';
if ( !happy_member_secure($happy_member_secure_text[1].'등록') )
{
	$guin_scrap_top_display_tag1 = '' ;
	$guin_scrap_top_display_tag2 = '';
}



$TPL->define("구인리스트", "./$skin_folder/guin_scrap.html");
$TPL->assign("구인리스트");
$내용 = &$TPL->fetch();


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
echo $TPL->fetch();



if ($demo){
$exec_time = array_sum(explode(' ', microtime())) - $t_start;
$exec_time = round ($exec_time, 2);
print   "<center><font color=gray size=1>Query Time : $exec_time sec";
}
exit;



?>