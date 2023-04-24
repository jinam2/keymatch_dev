<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");

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





	//$menu_search		= iconv("UTF-8", "EUC-KR", $_GET['menu_search']);

	if ( $menu_search == '' )
	{
		echo "error___cut___검색어를 입력 해주세요.";
		exit;
	}
	else
	{
		echo "ok___cut___";

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
												menu_link like '%$menu_search%'
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

		/* 2014-02-28 WOO 엔터 > 고 */
		$AdminMenuCount	= 0;
		$AdminMenuLink	= '';
		while ( $AdminMenu = happy_mysql_fetch_array($Record) )
		{
			if ( $AdminMenu['menu_target'] == '' )
			{
				$AdminMenu['menu_target']	= '_self';
			}


			$color_start		= '';
			$color_end			= '';
			if ( $AdminMenu['menu_color'] != '' )
			{
				$color_start		= "<font >";
				$color_end			= "</font>";
			}

			if ( $AdminMenu['menu_link'] != '' )
			{
				echo "<a href='$AdminMenu[menu_link]' target='$AdminMenu[menu_target]' class='smfont5'>".$color_start.$AdminMenu['menu_name'].$color_end."</a>";

				/* 2014-02-28 WOO 엔터 > 고 */
				if ( preg_match("/javascript:/",$AdminMenu['menu_link']) )
				{
					$AdminMenuLink	= 'no';
				}
				else
				{
					$AdminMenuLink	= $AdminMenu['menu_link'];
				}
				$AdminMenuCount++;
			}
			else
			{
				echo "<font><b class='smfont4'>".$color_start.$AdminMenu['menu_name'].$color_end."</b></font>";
			}

			if ( $AdminMenu['menu_icon'] != '' )
			{
				if ( $AdminMenu['menu_icon_link'] == '' )
				{
					echo " <img src='".$AdminMenu['menu_icon']."' style='vertical-align:top;' border='0'>";
				}
				else
				{
					echo "<a href='".$AdminMenu['menu_icon_link']."'><img src='".$AdminMenu['menu_icon']."' style='vertical-align:top;' border='0'></a>";
				}
			}

			echo "<br><p class='smfont2' style='line-height:16px; margin-bottom:3px;'>".kstrcut($AdminMenu['menu_memo'], 70, '...');

			echo "</p>";


		}
		#echo "오키";
	}

	/* 2014-02-28 WOO 엔터 > 고 */
	if(trim($_GET['clicktype']) == 'click')
	{
		$AdminMenuLink	= 'no';
	}
	if($AdminMenuCount == 1)
	{
		echo "___cut___" . $AdminMenuLink;
	}
?>