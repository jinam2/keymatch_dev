<?php
/**
* 뉴스 공유 기본라이브러리 파일
*
*/

//set names utf8 처리
$call_set_names_utf = 1;
if ( $call_set_names_utf )
{
	query("set names utf8");
}

$sql	= "select * from $admin_tb where number='1'";
$result	= query($sql);	list($admin_number,$admin_id,$admin_pw,$admin_email,$admin_name,$bbs_ad_id,$bbs_ad_pw,$main_url2,$pagenum,$mainnum,$gu_mainnum,$prev_stand,$pay_guin,$main2,$default,$info,$guin_list,$guzic_list,$bbs,$admin_date,$admin_etc1,$admin_etc2,$admin_etc3,$admin_etc4,$admin_etc5)	= mysql_fetch_row($result);

//2015-02-09 게시글로 보내기
if ( $use_store_news == "1" )
{
	#카테고리읽자
	$sql = "select * from $news_category ";
	$result = query($sql);
	while ($TMP = happy_mysql_fetch_array($result))
	{
		$TCATE{$TMP[thread]} = $TMP[title];
		$thread_title = $TMP[thread] . "_template";
		$TCATE[$thread_title] = $TMP[template];
	}
}

//게시판 DB구조 체크해서 변경
function board_db_setting($board_tb)
{
	global $db_prefix;
	//echo $board_tb;

	$sql = "desc $board_tb";
	$result = query($sql);
	$exists_news_shared = false;
	$exists_news_gongu = false;
	$exists_sharing_site = false;
	$exists_shared_site = false;
	$exists_shared_auto_update = false;
	$exists_shared_gudoc = false;
	while($row = happy_mysql_fetch_array($result))
	{
		//print_r($row);
		if ( $row[0] == "news_shared" )
		{
			$exists_news_shared = true;
		}

		if ( $row[0] == "news_gongu" )
		{
			$exists_news_gongu = true;
		}

		if ( $row[0] == "sharing_site" )
		{
			$exists_sharing_site = true;
		}

		if ( $row[0] == "shared_site" )
		{
			$exists_shared_site = true;
		}

		if ( $row[0] == "shared_auto_update" )
		{
			$exists_shared_auto_update = true;
		}

		if ( $row[0] == "shared_gudoc" )
		{
			$exists_shared_gudoc = true;
		}
	}


	//공유한 뉴스다 아니다 필드
	if ( $exists_news_shared == false )
	{
		$sql = "alter table `{$db_prefix}$board_tb` add news_shared int(11) not null default 0";
		query($sql);

	}

	//공유받은 뉴스다 아니다 필드
	if ( $exists_news_gongu == false )
	{
		$sql = "alter table `{$db_prefix}$board_tb` add news_gongu int(11) not null default 0";
		query($sql);
	}

	//공유한 사이트 도메인고유번호 필드
	if ( $exists_sharing_site == false )
	{
		$sql = "alter table `{$db_prefix}$board_tb` add sharing_site int(11) not null default 0";
		query($sql);
	}

	//공유받은 사이트 도메인고유번호 필드
	if ( $exists_shared_site == false )
	{
		$sql = "alter table `{$db_prefix}$board_tb` add shared_site int(11) not null default 0";
		query($sql);
	}

	//자동업데이트 여부 필드
	if ( $exists_shared_auto_update == false )
	{
		$sql = "alter table `{$db_prefix}$board_tb` add shared_auto_update int(11) not null default 0";
		query($sql);
	}

	//정기구독 고유번호 필드
	if ( $exists_shared_gudoc == false )
	{
		$sql = "alter table `{$db_prefix}$board_tb` add shared_gudoc int(11) not null default 0";
		query($sql);
	}
}


# 에러메세지
function error($text)
{
	echo "<script>window.alert('$text');history.go(-1);</script>";
	exit;
}

# 이동하기
function go($url)
{
	echo "<META HTTP-EQUIV=refresh CONTENT=0;URL=$url>";
	exit;
}

# 메세지띄우기
function msg($text)
{
	echo "<script>window.alert('$text');</script>";
}

# 메세지띄우고창닫기
function msgclose($close)
{
	$close							= addslashes($close);
	echo"<script>window.alert('$close');self.close();</script>";
	exit;
}



//뉴스 솔루션 관리자 체크
//뉴스 솔루션의 부관리자는 뉴스공유할 권한을 주지 않는다.
function news_admin_check()
{
	global $admin_id,$admin_pw;
	global $news_admin_id,$news_admin_pass;
	global $pass_encrypt_type;

	$tmp_c = '$admin_pw_enc = '.$pass_encrypt_type.'(\''.$admin_pw.'\');';
	eval($tmp_c);
	//echo $admin_pw_enc;

	if ( $news_admin_id == $admin_id && $news_admin_pass == $admin_pw_enc )
	{
		return true;
	}
	else
	{
		return false;
	}
}


//뉴스 상점 로그인 체크
function news_store_login_check()
{
	global $news_store_login;

	$row = get_news_store_info();
	//print_r($row);

	$login_ok = news_store_login_result($row['id'],$row['pass']);

	if ( $login_ok == "ok" )
	{
		return true;
	}
	else
	{
		return false;
	}

}


//뉴스상점 로그인정보
function get_news_store_info()
{
	global $news_store_login;

	$sql = "select * from $news_store_login limit 0,1";
	$result = query($sql);
	$row = happy_mysql_fetch_assoc($result);

	return $row;

}

//뉴스상점 로그인가능여부
//index.php 파일에서 설정해둔 정보로 로그인이 되나 안되나 체크용
function news_store_login_result($id,$pass)
{
	global $news_store_url,$news_store_login_check_path;


	$url = $news_store_url.$news_store_login_check_path;

	//echo $url;

	$Tmp = parse_url($url);
	$host = $Tmp['host'];
	$path = $Tmp['path'];
	$port = "80";

	$dataStr = '&id='.$id;
	$dataStr.= '&pass='.$pass;
	$dataStr.= '&login_type=check';
	$dataStr.= '&check_time='.happy_mktime();

	$fp = @fsockopen($host,$port,$errno,$errstr,30);

	if(!$fp)
	{
		//echo "$errstr ($errno)<br />\n";
	}
	else if($fp)
	{
		$header = "POST ".$path." HTTP/1.0\r\n";
		$header .= "Host: ".$host."\r\n";
		$header .= "User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n";
		$header .= "Content-type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-length: ".strlen($dataStr)."\r\n\r\n";
		$header .= $dataStr."\r\n";

		fputs ($fp, $header);

		while ( !feof($fp) )
		{
			$isSuccess =  trim(fgets($fp,1024));
			//echo $isSuccess ;
		}
		//echo $isSuccess;
		// closed socket
		fclose($fp);

		return $isSuccess;
	}

}


function json_encode2($data)
{
	switch (gettype($data))
	{
		case 'boolean':
			return $data?'true':'false';
		case 'integer':
		case 'double':
			return $data;
		case 'string':
			return '"'.strtr($data, array('\\'=>'\\\\','"'=>'\\"')).'"';
		case 'array':
			$rel = false; // relative array?
			$key = array_keys($data);
			foreach ($key as $v)
			{
				if (!is_int($v))
				{
					$rel = true;
					break;
				}
			}

			$arr = array();
			foreach ($data as $k=>$v)
			{
				$arr[] = ($rel?'"'.strtr($k, array('\\'=>'\\\\','"'=>'\\"')).'":':'').json_encode2($v);
			}

			return $rel?'{'.join(',', $arr).'}':'['.join(',', $arr).']';
		default:
			return '""';
	}
}


//html 코드에서 파일명 찾아서 파일명 배열 리턴
function upload_file_search($html_code)
{

	$upload_files = array();

	$img_patten = '/(<img [^>]*?src="(.*?)")(.*?>)/is';
	$ahref_patten = '/(<a [^>]*?href="(.*?)")(.*?>)/is';
	$embed_patten = '/(<embed [^>]*?src="(.*?)")(.*?>.*?<\/embed>)/is';

	preg_match_all($img_patten,$html_code,$match_img);
	preg_match_all($ahref_patten,$html_code,$match_a);
	preg_match_all($embed_patten,$html_code,$match_embed);

	if ( is_array($match_img[2]) )
	{
		foreach($match_img[2] as $v )
		{
			if ( !preg_match("/^http:\/\//i",$v) )
			{
				array_push($upload_files,$v);
			}
		}
	}
	if ( is_array($match_a[2]) )
	{
		foreach($match_a[2] as $v )
		{
			if ( !preg_match("/^http:\/\//i",$v) )
			{
				array_push($upload_files,$v);
			}
		}
	}
	if ( is_array($match_embed[2]) )
	{
		foreach($match_embed[2] as $v )
		{
			if ( !preg_match("/^http:\/\//i",$v) )
			{
				array_push($upload_files,$v);
			}
		}
	}

	//echo $html_code;
	//print_r2($upload_files);

	return $upload_files;
}

function socket_img_get($url,$save_file_name)
{
	$Tmp = parse_url($url);
	$host = $Tmp['host'];
	$path = $Tmp['path'];
	$port = "80";



	$fp = @fsockopen($host,80,$errno,$errstr,30);
	if (!$fp)
	{
		//echo "$errstr ($errno)<br />\n";
	}
	else if ( $fp )
	{
		$send = 'GET '.$path.' HTTP/1.1'."\r\n";
		$send.= 'Host: '.$host."\r\n";
		$send.= 'Connection: Close'."\r\n\r\n";
		fwrite($fp,$send);
		$content = '';
		while ( !feof($fp) ) $content.= fread($fp,1024);
		$content = substr($content,strpos($content,"\r\n\r\n")+4);
		fclose($fp);

		file_put_contents($save_file_name,$content);
	}
}

//뉴스상점의 첨부이미지를 뉴스솔루션서버에 저장하기 위해서 추가
if ( !function_exists("file_put_contents") )
{
	function file_put_contents($filename, $data)
	{
		$f = @fopen($filename, 'w+');
		if (!$f)
		{
			return false;
		}
		else
		{
			$bytes = fwrite($f, $data);
			fclose($f);
			return $bytes;
		}
	}
}


//파일업로드 내역
function upload_file_insert($upload_file)
{
	global $happy_upload_files;
	//global $mem_id;

	$upload_id = "news_store";

	if ( file_exists($_SERVER['DOCUMENT_ROOT'].$upload_file) )
	{
		$sql = "insert into ".$happy_upload_files." set ";
		$sql.= " upload_file = '".$upload_file."', ";
		$sql.= " using_table = '', ";
		$sql.= " using_key = '' , ";
		$sql.= " using_field = '' , ";
		$sql.= " file_stats = 'tmp' , ";
		$sql.= " upload_id = '".$upload_id."', ";
		$sql.= " remote_ip = '".$_SERVER['REMOTE_ADDR']."', ";
		$sql.= " reg_date = now() ";
		query($sql);
	}
}

//업로드파일들의 사용테이블/고유번호를 업데이트
//첨부파일 내역에 저장되는 필드(using_field)가 추가됨 2010-05-31 kad
//한테이블내에 여러개의 위지윅으로 입력받는 상황때문임
//한테이블내에 한개의 위지윅만 사용할 경우 필드이름은 빈값으로 호출해도 됨
function upload_file_update($html_code,$using_table,$using_number,$file_stats,$using_field="")
{
	global $happy_upload_files;
	//print_r(func_get_args());

	if ( $html_code != "" )
	{
		$html_code = stripslashes($html_code);
		//등록 + 수정시 html_code 안에 파일이 몇개인지를 찾아내자.
		$upload_files = upload_file_search($html_code);
	}

	if ( $file_stats == "insert" )
	{
		if ( is_array($upload_files) )
		{
			foreach($upload_files as $k)
			{
				//다른 게시글에 이미 사용되고 있는 파일을 링크 걸었다면 새로 인서트
				$cnt = "";
				$sql = "select count(*) from ".$happy_upload_files." where file_stats = 'using' and upload_file = '".$k."'";
				//echo $sql;exit;
				$result = query($sql);
				list($cnt) = happy_mysql_fetch_array($result);

				if ( $cnt >= 1 )
				{
					upload_file_insert($k);
				}

				$sql = "update ".$happy_upload_files." set ";
				$sql.= "using_table = '".$using_table."', ";
				$sql.= "using_key = '".$using_number."', ";
				$sql.= "using_field = '".$using_field."' , ";
				$sql.= "file_stats = 'using' ";
				$sql.= "where ( file_stats = 'tmp' ) and upload_file = '".$k."' ";

				//echo $sql."<br><br>";

				query($sql);
			}
		}
	}
	else if ( $file_stats == "update" )
	{
		//수정시 기존에 등록되어 있는 파일을 모두 tmp 로 업데이트
		$field_sql = "";
		if ( $using_field != "" )
		{
			$field_sql = " and using_field = '".$using_field."' ";
		}

		$sql = "update ".$happy_upload_files." set ";
		$sql.= "file_stats = 'tmp' ";
		$sql.= "where file_stats = 'using' and using_table = '".$using_table."' and using_key = '".$using_number."' ".$field_sql." ";
		query($sql);

		if ( is_array($upload_files) )
		{
			foreach($upload_files as $k)
			{
				$sql = "update ".$happy_upload_files." set ";
				$sql.= "using_table = '".$using_table."', ";
				$sql.= "using_key = '".$using_number."', ";
				$sql.= "using_field = '".$using_field."', ";
				$sql.= "file_stats = 'using' ";
				$sql.= "where file_stats = 'tmp' and upload_file = '".$k."'";
				//echo $sql."<br>";
				query($sql);
			}
		}
	}
	else if ( $file_stats == "delete" )
	{
		//삭제시에는 등록된 파일들 상태를 del 로 바꾼다.
		$sql = "update ".$happy_upload_files." set ";
		$sql.= "file_stats = 'del' ";
		$sql.= "where file_stats = 'using' and using_table = '".$using_table."' and using_key = '".$using_number."' ";
		query($sql);
	}
}

if ( !function_exists("file_put_contents") )
{
	function file_put_contents($filename, $data)
	{
		$f = @fopen($filename, 'w+');
		if (!$f)
		{
			return false;
		}
		else
		{
			$bytes = fwrite($f, $data);
			fclose($f);
			return $bytes;
		}
	}
}


//뉴스인덱스갱신을 기존 솔루션에 프로그램 추가를 하고,
//그 프로그램을 소켓으로 호출해서 해볼까 싶어서 만들어봄
function socket_news_index_reloading($news_num)
{
	global $news_site_url;
	//global $admin_id,$admin_pw;

	$url = $news_site_url."/master/news_share_index.php?news_num=".$news_num;


	$Tmp = parse_url($url);
	$host = $Tmp['host'];
	$path = $Tmp['path'];
	$port = "80";

	$path = $Tmp["path"];
	if ($Tmp["query"] != "")
		$path .= "?".$Tmp["query"];



	$fp = @fsockopen($host,$port,$errno,$errstr,30);

	if(!$fp)
	{
		//echo "$errstr ($errno)<br />\n";
	}
	else if($fp)
	{
		$header = "GET ".$path." HTTP/1.0\r\n";
		$header .= "Host: ".$host."\r\n";
		$header .= "User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n\r\n";
		//$header .= "Cookie: cook_id=".$admin_id.";cook_pass=".md5($admin_pw)."\r\n\r\n";

		fputs ($fp, $header);

		while ( !feof($fp) )
		{
			$isSuccess.=  trim(fgets($fp,1024));
			//echo $isSuccess ;
		}
		//echo $isSuccess;
		// closed socket
		fclose($fp);

		return $isSuccess;
	}
}






?>