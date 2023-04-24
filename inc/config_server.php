<?php

//$PHP_SELF = $_SERVER['PHP_SELF']		= strip_tags($_SERVER['PHP_SELF']);

//서버 절대경로
$server_real_path			= str_replace("\\","/",realpath(__FILE__));
$server_path				= str_replace("inc/".basename(__FILE__), "", $server_real_path);

if ( $demo_lock != '' )
{
	$db_str	= "<table width='100%' height='100%'><tr><td align='center'><img src='http://cgimall.co.kr/img/demo_repair_comment.jpg' border='0' /></td></tr></table>";

	$db		= @mysql_connect($db_host, $db_user, $db_pass) or die($db_str);
	@mysql_select_db($db_name, $db) or die($db_str);

	$Sql	= "show tables like 'auto_mysql_creating' ";
	$Rec	= mysql_query($Sql,$db) or die($db_str);
	$Cnt	= mysql_num_rows($Rec);

	if ( $Cnt > 0 )
	{
		echo $db_str;
		exit;
	}
}

if($_SERVER['HTTPS'] != "on")
{
    if ($_SERVER['SERVER_PORT'] == '80') {
        if ($_SERVER['PHP_SELF'] != '/monitor/ajax_check_solution.php' AND $_SERVER['REDIRECT_URL'] != '/test' ) {
            Header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        }
    }
}
else
{
    if ($_SERVER['PHP_SELF'] == '/monitor/ajax_check_solution.php' ) {
        Header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    }
}

function session_start_samesite($options = array())
{
	$res = @session_start($options);
	$headers = headers_list();
	foreach ($headers as $header) {
	if (!preg_match('~^Set-Cookie: PHPSESSID=~', $header)) continue;
	$header = preg_replace('~; secure(; HttpOnly)?$~', '', $header) . '; secure; SameSite=None';
	header($header, false);

	}
	return $res;
}

//세션 관련 소스
$session_dir = $server_path."data/session";

session_save_path($session_dir);
session_set_cookie_params(0,"/");
ini_set("session.cookie_domain", $cookie_url);
if(preg_match('/rv/i', $_SERVER['HTTP_USER_AGENT']) && preg_match('/Trident/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT']))
{
	@session_start();
}
else
{
	session_start_samesite();
}


//헤더 소스
header("Content-type: text/html; charset=utf-8");
//header('X-UA-Compatible: IE=EmulateIE8');
@header('X-UA-Compatible: IE=edge');

//기본 날짜 지정
if (PHP_VERSION >= '5.1.0')
{
	date_default_timezone_set("Asia/Seoul");
}

//PHP 오류 출력
//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
//@ini_set("display_errors", "on");


//매직쿼터 자동ON
//http://php.net/manual/kr/function.array-map.php 하나 참조
function array_map_recursive($callback, $array)
{
	if(is_array($array))
	{
		foreach ($array as $key => $value)
		{
			if (is_array($array[$key]))
			{
				$array[$key] = array_map_recursive($callback, $array[$key]);
			}
			else
			{
				$array[$key] = call_user_func($callback, $array[$key]);
			}
		}
	}
	else
	{
		$array = call_user_func($callback, $array);
	}

	return $array;
}

if( !get_magic_quotes_gpc() )
{
	$_GET = array_map_recursive("addslashes",$_GET);
	$_POST = array_map_recursive("addslashes",$_POST);
	$_COOKIE = array_map_recursive("addslashes",$_COOKIE);
}


//전역변수 호환
$HTTP_COOKIE_VARS	= $_COOKIE;
$HTTP_POST_VARS		= $_POST;

extract($_GET,EXTR_SKIP);
extract($_POST,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);
extract($_SERVER,EXTR_SKIP);


//SSL포트 변수 (내부 소켓 통신을 위한 80 포트 허용)
$ssl_port = ( $ssl_port != '' ) ? $ssl_port : '80';

//set names utf8 처리
$call_set_names_utf = '1';




//== m.도메인사용설정 ==//
//사용시:1, 미사용시 빈값
$mdomain_use		= "";
// happy_intro_use 가 true 면 모바일이 아니더라도 첫접속시에 intro 화면이 노출 됩니다.
$happy_intro_use	= false;

/*
if( $_SERVER['HTTPS'] == "on" && (
                                preg_match("/happy_member_login\.php/", $_SERVER['REQUEST_URI'])
                                || preg_match("/happy_member\.php\?mode=lostid_reg/", $_SERVER['REQUEST_URI'])
                                || preg_match("/happy_member\.php\?mode=lostpass_reg/", $_SERVER['REQUEST_URI'])
                                || preg_match("/callback.php/", $_SERVER['REQUEST_URI'])
                                || preg_match("/joinus\.php/", $_SERVER['REQUEST_URI']) ) )
{
     $mdomain_use = "";
}
*/

//main_url 치환
if( $mdomain_use == "1" && preg_match("/^m\./i",$_SERVER['HTTP_HOST']) )
{
    $hosts = parse_url($main_url);
    $main_url = $hosts['scheme'].'://'.str_replace(":$ssl_port","",$_SERVER['HTTP_HOST']).$hosts['path'];
    //echo $main_url;
}

//m.도메인 사용시 처음 접속페이지 처리
//예를 들어 선언된 페이지가 index.php 인 경우
//도메인/index.php 파일로 접근시 - pc인경우 그대로, 모바일인 경우 m.도메인 으로 자동링크.
//도메인/category.php 파일로 접근시 - pc버전으로 접근됨.
$happy_mobile_ch	= array(
								"index.php"
);

//솔루션들 마다 다름
//모바일로 바로 접근했을때 페이지가 열려야 할 파일명들
$MOBILE_ACCESS_FILES	= array(
								"index.php"
								,"index_mobile.php"
								,"bbs_index.php"
								,"bbs_list.php"
								,"bbs_detail.php"
								,"bbs_regist.php"
								,"bbs_modify.php"
								,"bbs_reply.php"
								,"html_file.php"
								,"happy_member.php"
								,"happy_member_login.php"
								,"happy_map.php"
								,"happy_map_guzic.php"
								,"all_search.php"
								,"guin_list.php"
								,"guin_detail.php"
								,"guzic_list.php"
								,"document_view.php"
);


/* SSL 위치기반 처리 START */
$ssl_geolocation_use		= '';							# SSL 위치기반 처리 사용여부
$ssl_geolocation_file		= "happy_map.php";				# SSL 위치기반 기능 PHP파일명
$ssl_geolocation_file2		= "happy_map_guzic.php";		# SSL 위치기반 기능 PHP파일명2
$ssl_geolocation_file_ajax	= "ajax_guin_list.php";			# SSL 위치기반 기능 AJAX PHP파일명
$ssl_geolocation_file_ajax2	= "ajax_guzic_list.php";		# SSL 위치기반 기능 AJAX PHP파일명2

if ( $ssl_geolocation_use && $_COOKIE['happy_mobile'] == "on" && $ssl_port != "" )
{
	$go_url						= "";
	$ssl_geolocation_file		= str_replace(".","\.",$ssl_geolocation_file);
	$ssl_geolocation_file2		= str_replace(".","\.",$ssl_geolocation_file2);
	$ssl_geolocation_file_ajax	= str_replace(".","\.",$ssl_geolocation_file_ajax);
	$ssl_geolocation_file_ajax2	= str_replace(".","\.",$ssl_geolocation_file_ajax2);

	if ( preg_match("/".$ssl_geolocation_file."/",$_SERVER['SCRIPT_NAME']) || preg_match("/".$ssl_geolocation_file2."/",$_SERVER['SCRIPT_NAME']) )
	{
		if ( $_SERVER['HTTPS'] != "on" )
		{
			$go_url			= str_replace("http://","https://",$main_url).":".$ssl_port.$_SERVER['REQUEST_URI'];
		}

	}
	else
	{
		if (
			( ( preg_match("/".$ssl_geolocation_file."/",$_SERVER['HTTP_REFERER']) && !preg_match("/".$ssl_geolocation_file_ajax."/",$_SERVER['SCRIPT_NAME']) )
			|| ( preg_match("/".$ssl_geolocation_file2."/",$_SERVER['HTTP_REFERER']) && !preg_match("/".$ssl_geolocation_file_ajax2."/",$_SERVER['SCRIPT_NAME']) ) )
			&& $_SERVER['HTTPS'] == "on"
		)
		{
			$go_url			= $main_url.$_SERVER['REQUEST_URI'];
		}
	}

	if ( $go_url != "" )
	{
		header("Location: $go_url");
		exit;
	}
}
/* SSL 위치기반 처리 END */



# 에러 로그 저장
include("happy_solution_error_log.php");

?>