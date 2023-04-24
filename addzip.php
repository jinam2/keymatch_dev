<?
	include ("./inc/config.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/function.php");


	if ( $mode == "zipform" )
	{
		$TPL->define("우편번호찾기",$skin_folder."/addzip_zipform.html");
		$TPL->tprint();
		exit;
	}

	if ( $mode == "search" )
	{
		
		if ( $_POST['gu'] == "" )
		{
			error("동/읍/면을 입력하세요");
			exit;
		}
		
		$sql = "select * from $zip_tb where dong like '%$gu%'";
		$result = query($sql);	
		$TPL->define("우편번호찾기결과",$skin_folder."/addzip_search_rows.html");
		while($ZIP = happy_mysql_fetch_array($result))
		{
			$우편번호검색결과 .= $TPL->fetch();
		}
		
		$TPL->define("우편번호찾기결과껍데기",$skin_folder."/addzip_search.html");
		$TPL->tprint();
		exit;	
	}

?>

