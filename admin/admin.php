<?php
ob_start();
include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;
include ("../inc/function.php");
include ("../inc/lib.php");
$ddd = ob_get_contents();
ob_end_clean();

$pagenum = '20';

function admin_login_ok()
{
	global $_POST, $admin_id, $admin_pw, $admin_member;
	global $cookie_url;

	$admin_id_put	= $_POST["pass_id"];
	$admin_pass_put	= addslashes($_POST["pass_pw"]);
	$userid	= str_replace(" ","",addslashes($admin_id_put));

	if ( ($userid == $admin_id) && ($admin_pass_put == $admin_pw) )
	{
		# 보안패치 2023-01-02 / 관리자 비밀번호 강화
		$CheckId	= $admin_id;	// 솔루션별 변경 필요
		$CheckPass	= $admin_pw;	// 솔루션별 변경 필요

		$pattern1	= "/[0-9]/u";
		$pattern2	= "/[a-z]/u";
		$pattern3	= "/[\~\!\@\#\$\%\^\&\*\(\)\_\+\|\<\>\?\:\{\}]/u";

		if ( strlen($CheckPass) < 8 || !preg_match($pattern1, $CheckPass) || !preg_match($pattern2, $CheckPass) || !preg_match($pattern3,$CheckPass) )
		{
			error("관리자 비밀번호는 8자리 이상 영문, 숫자, 특수문자 조합으로 입력해주세요.\\n\\nConfig 파일을 수정한 후 다시 로그인해주세요.");
			exit;
		}

		if ( $CheckId == $CheckPass )
		{
			error("관리자 아이디와 비밀번호는 동일하게 설정할 수 없습니다.\\n\\nConfig 파일을 수정한 후 다시 로그인해주세요.");
			exit;
		}
		# 보안패치 2023-01-02 / 관리자 비밀번호 강화

		happy_auto_log_del(); //로그 테이블 정리 - ranksa

		setcookie("ad_id","$userid",0,"/",$cookie_url);
		setcookie("ad_pass",md5("$admin_pass_put"),0,"/",$cookie_url);
		//setcookie("level","10",0,"/");
		#setcookie("bbs_admin","$admin_pass_put/$pass_pw",0,"/",$cookie_url);
		//echo "$pass_id == $admin_id<BR>$pass_pw == $admin_pw";

		//휴면회원 체크 및 URL이동 main.php OR dhappy_member_quies.php - ranksa
		if(!happy_member_quies_chk_url())
		{
			go("./index.php");
		}
	}
	else
	{
		//print_r2($_POST); exit;
		$Sql	= "SELECT * FROM $admin_member WHERE id='$userid' AND pass='$admin_pass_put' ";
		$Data	= happy_mysql_fetch_array(query($Sql));

		if ( ( $Data["id"] == "" || $Data["id"] != $userid ) && $userid == $admin_id )
		{
			error("비밀번호가 일치하지 않습니다.");
			exit;
		}
		else if ( $Data["id"] == "" || $Data["id"] != $userid )
		{
			error("일치하는 아이디가 존재하지 않습니다.");
			exit;
		}
		else if ( $Data["pass"] != $admin_pass_put )
		{
			error("비밀번호가 일치하지 않습니다.");
			exit;
		}
		else
		{
			$Sql	= "UPDATE $admin_member SET lastlogin=now(), login_count=login_count+1 WHERE id='$userid' ";
			query($Sql);
			setcookie("ad_id","$userid",0,"/",$cookie_url);
			setcookie("ad_pass",md5("$admin_pass_put"),0,"/",$cookie_url);
			//setcookie("level","10",0,"/");

			//휴면회원 체크 및 URL이동 main.php OR dhappy_member_quies.php - ranksa
			if(!happy_member_quies_chk_url())
			{
				go("./index.php");
			}
		}
	}
}




if ( !isset($_COOKIE["ad_id"]) && !$admin )
{
	include ("./html/login.html");
	exit;
}

if ( $admin == "login" )
{
	admin_login_ok();
	exit;
}
elseif ( $admin == "logout" )
{
	setcookie("ad_id","",0,"/",$cookie_url);
	setcookie("ad_pass","",0,"/",$cookie_url);
	//setcookie("level","",0,"/");
	Header("Location: ./index.php");
	exit;
}
else
{
	include ("tpl_inc/top_new.php");
}


$a	= ( $_GET["a"] == "" )?$_POST["a"]:$_GET["a"];


//구인/구직옵션변경
if ( $_GET[area] == "mod" )
{
	if ( !admin_secure("구인구직옵션설정") )
	{
		error("접속권한이 없습니다.   ");
		exit;
	}

	$sql = "select * from $area_tb where number='1'";
	$result = query($sql);

	list ($area_number,$root_area,$root_job,$root_woodae,$root_bokri,$root_money,$root_edu,$root_career,$root_grade,$root_lang,$root_license, $root_keyword, $root_schooltype, $root_money2,$root_lang2,$root_country,$guin_howjoin, $root_career_start, $root_career_end,$tHopeSize) = mysql_fetch_row($result);

	//헤드헌팅 제거
	if ( $demo_lock && $hunting_use == false )
	{
		$root_job		= str_replace(">헤드헌팅","",$root_job);
	}

	include ("./html/area_mod.html");
}
elseif ( $_POST[area] == "mod_ok" )
{
	if ($demo)
	{
		error("데모사이트는 적용되지 않습니다.");
		exit;
	}

	if ( !admin_secure("환경설정") )
	{
		error("접속권한이 없습니다.   ");
		exit;
	}

	$sql = "update $area_tb set
	root_area='$_POST[root_area]',
	root_job='$_POST[root_job]',
	root_woodae='$_POST[root_woodae]' ,
	root_bokri = '$_POST[root_bokri]' ,
	root_money = '$_POST[root_money]',
	root_edu = '$_POST[root_edu]',
	root_career = '$_POST[root_career]',
	root_grade = '$_POST[root_grade]',
	root_lang = '$_POST[root_lang]'	,
	root_license = '$_POST[root_license]',
	root_keyword = '$_POST[root_keyword]',
	root_schooltype = '$_POST[root_schooltype]',
	root_money2 = '$_POST[root_money2]',
	root_lang2 = '$_POST[root_lang2]',
	root_country = '$_POST[root_country]',
	guin_howjoin = '$_POST[guin_howjoin]',
	root_career_start = '$_POST[root_career_start]',
	root_career_end = '$_POST[root_career_end]',
	tHopeSize = '$_POST[tHopeSize]'
	where number='$num'";
	//print $sql;
	$result = query($sql);
	//echo "$sql";
	go("$PHP_SELF?area=mod");
}

include ("tpl_inc/bottom.php");

?>