<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/Template.php");
	$TPL = new Template;

	if(!session_id()) session_start();
	$folder_name = "./upload/tmp/".session_id();

	if ( !admin_secure("정보관리") ) {
		$adminUserId = $_COOKIE["ad_id"];
		$adminUserPwd = $_COOKIE["ad_pass"];

		$Sql	= "SELECT * FROM $admin_member WHERE id='$adminUserId' ";
		$Data	= happy_mysql_fetch_array(query($Sql));

		if ( md5($Data['pass']) != $adminUserPwd )
		{
			error("접속권한이 없습니다.");
			exit;
		}
	}

	//query("set names utf8");

	header("Content-type: text/xml");



	$word				= str_replace(" ", "", $_GET["word"]);
	$menu_search		= $word;
	$Sql				= "
							SELECT
									*
							FROM
									$admin_menu
							WHERE
									menu_use			= 'y'
									AND
									(
											menu_name like '%$menu_search%'
											OR
											menu_name_full like '%$menu_search%'
											OR
											menu_memo like '%$menu_search%'
											OR
											menu_content like '%$menu_search%'
											OR
											menu_editor_top like '%$menu_search%'
											OR
											menu_editor_bottom like '%$menu_search%'
									)
	";
	$Record				= query($Sql);

	$chk				= 0;
	$word_array			= array();

	while( $list = happy_mysql_fetch_array($Record) )
	{
		$word_array[]		= $list['menu_name'];

		//$link_word = iconv("euc-kr", "utf-8", $list["auto_word"]);
		$link_word			= $list["menu_name"];

		$view_word			= str_replace($word, "<font style='color:#f65400;font-weight:bold;'>$word</font>", $list["menu_name"] );

		//$view_word = iconv("euc-kr", "utf-8", $view_word);

		if( $chk == 0 )
		{
			echo "<table style=\"width:100%;\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
		}
		$chk++;

		// 2014-03-04 WOO
		if($list['menu_link'] != '')
		{
			if ( preg_match("/javascript:/",$list['menu_link']) )
			{
				$onclick	= '';
			}
			else
			{
				$onclick	= "location.href='./" . $list['menu_link'] . "';";
			}
		}

		echo "<tr onmousedown=\"go_search('$link_word');" . $onclick . "\"><td height='25' align='left' style='padding-left:5px;' id='search_word_td_$chk'><label id='search_word_$chk'>$view_word</label></td>\n</tr>\n";
	}




	if( $chk != 0 )
	{
		echo "</table>";
	}

	echo "___cut___".$chk;
?>