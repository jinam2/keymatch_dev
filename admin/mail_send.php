<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");

	if ( !admin_secure("회원메일링") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	$number		= $_GET["number"];
	$sendSize	= $_GET["sendSize"];
	$start		= $_GET["start"];

	#구인구직 회원테이블 받아서 처리 0:일반회원 / 1:기업회원
	$keyword1 = $_GET["keyword1"];

	if ( $keyword1 == "0" )
	{
		$email_col = "user_email";
	}
	else if ( $keyword1 == "1" )
	{
		$email_col = "user_email";
	}
	else
	{
		echo "err01";
	}

	if ( $number == "" || $sendSize == "" || $start == "" )
	{
		echo "err01";
		exit;
	}

	$Sql		= "SELECT title,content,whereQuery FROM $happy_mailing WHERE number='$number' ";
	$Mail		= happy_mysql_fetch_array(query($Sql));
	$title		= $Mail["title"];
	$content	= $Mail["content"];
	#이미지는 절대경로로 변경
	$content = str_replace("$wys_url/wys2/",$main_url.$wys_url."/wys2/",$content);
	$whereQuery	= $Mail["whereQuery"];
	#print_r2($Mail);

	$Sql		= "SELECT Count(number) FROM $happy_member $whereQuery";

	$Data		= happy_mysql_fetch_array(query($Sql));
	$Total		= ( $demo_lock )?"1500":$Data[0];

	$Sql		= "SELECT $email_col FROM $happy_member $whereQuery ORDER BY number ASC LIMIT $start,$sendSize";
	#echo $Sql;
	$Record		= query($Sql);

	$Count		= 0;

	if ( $demo_lock == '' )
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			//메일 함수 통합 - hong
			HappyMail($site_name, $admin_email,$Data[$email_col],$title,$content);
		}
	$start		= $start+$sendSize;

	$addSql		= ( $Total <= $start )?" , mailok='Y' ":"";

	$Sql		= "UPDATE $happy_mailing SET lastNumber=$start $addSql WHERE number='$number'";
	query($Sql);
	#sleep(1);

	echo "ok";
?>