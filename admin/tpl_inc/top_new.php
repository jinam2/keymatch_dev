<?

/*
CREATE TABLE `job_admin_menu` (
  `number` int(11) NOT NULL auto_increment,
  `menu_name` varchar(200) NOT NULL default '',
  `menu_name_full` varchar(200) NOT NULL default '',
  `menu_parent` int(11) NOT NULL default '0',
  `menu_depth` tinyint(4) NOT NULL default '0',
  `menu_sort` int(11) NOT NULL default '0',
  `menu_memo` text NOT NULL,
  `menu_link` varchar(250) NOT NULL default '',
  `menu_target` varchar(30) NOT NULL default '',
  `menu_content` text NOT NULL,
  `menu_use` enum('y','n') NOT NULL default 'y',
  `menu_image` varchar(200) NOT NULL default '',
  `menu_image_over` varchar(200) NOT NULL default '',
  `menu_left_title_image` varchar(200) NOT NULL default '',
  `menu_color` varchar(30) NOT NULL default '',
  `menu_icon` varchar(200) NOT NULL default '',
  `menu_icon_link` varchar(250) NOT NULL default '',
  `menu_access` varchar(50) NOT NULL default '',
  `menu_access_link1` varchar(250) NOT NULL default '',
  `menu_access_link2` varchar(250) NOT NULL default '',
  `menu_access_link3` varchar(250) NOT NULL default '',
  `menu_access_link4` varchar(250) NOT NULL default '',
  `menu_access_link5` varchar(250) NOT NULL default '',
  `menu_editor_top` mediumtext NOT NULL,
  `menu_editor_bottom` mediumtext NOT NULL,
  `reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `menu_gubunbar` enum('y','n') NOT NULL default 'n',
  PRIMARY KEY  (`number`),
  KEY `menu_sort` (`menu_sort`),
  KEY `menu_name` (`menu_name`),
  KEY `menu_name_full` (`menu_name_full`),
  KEY `menu_use` (`menu_use`)
)
*/

	$block_menu_array	= Array('회원정보');
	// 2차 메뉴중 회원정보 는 회원그룹을 뿌림.
	function admin_happy_member_group_menu()
	{
		global $happy_member_group,$admin_menu;

		/*
			$sql	= "SELECT number FROM $admin_menu WHERE menu_name = '회원정보'";
			list($member_group_number)	= happy_mysql_fetch_array(query($sql));

			$sql	= "SELECT * FROM $admin_menu WHERE menu_parent = ".$member_group_number." AND menu_depth = 2";
		*/

		$array			= Array();
		$color_start	= '';
		$color_end		= '';

		// 위쪽
		$array['top']	= "<LI><font class='price3'>○</font> <a href='happy_member.php' target='' style='color:#FFF;' class='smfont3'>전체회원정보</a></LI>";
		// 왼쪽
		$array['left']	= "<tr><td class='smfont6' style='padding-left:5px; line-height:20px;'>\n<img src='img/icon_point_arrow2.gif' style='vertical-align:middle; margin-right:5px;'><a href='happy_member.php' target=''>전체회원정보</a></td></tr>\n";

		$SqlGroup		= "
							SELECT
									number,group_name
							FROM
									$happy_member_group
							ORDER BY
									number
							ASC
		";

		$GroupResult	= query($SqlGroup);
		while($SubMenuGroup = happy_mysql_fetch_assoc($GroupResult))
		{
			// 위쪽
			$array['top']	.= "<LI><font class='price3'>○</font> <a href='happy_member.php?group_select=".$SubMenuGroup['number']."' target='' style='color:#FFF;' class='smfont3'>".$color_start.$SubMenuGroup['group_name'].'정보'.$color_end."</a></LI>";
			// 왼쪽
			$array['left']	.= "<tr><td class='smfont6' style='padding-left:5px; line-height:20px;'>\n<img src='img/icon_point_arrow2.gif' style='vertical-align:middle; margin-right:5px;'><a href='happy_member.php?group_select=".$SubMenuGroup['number']."' target=''>".$color_start.$SubMenuGroup['group_name'].'정보'.$color_end."</a></td></tr>\n";
		}

		// 위쪽
		//$array['top']	.= "<LI><font class='price3'>○</font> <a href='happy_member_quies.php' target='' style='color:#FFF;' class='smfont3'>".$color_start.'휴면 회원정보'.$color_end."</a></LI>";
		// 왼쪽
		//$array['left']	.= "<tr><td class='smfont6' style='padding-left:5px; line-height:20px;'>\n<img src='img/icon_point_arrow2.gif' style='vertical-align:middle; margin-right:5px;'><a href='happy_member_quies.php' target=''>".$color_start.'휴면 회원정보'.$color_end."</a></td></tr>\n";

		return $array;
	}
	$admin_menu_happy_member_group	= admin_happy_member_group_menu();

	// 3단계depth추가
	$admin_menu_depth	= 3;
	function admin_menu_list()
	{

		# 추출 가능한 태그 없음 // php로 함수를 다이렉트 호출한후 리턴되는 값을 변수로 담아서 사용

		$arg_title	= array('세로수','가로수','메뉴호출방식','테이블크기','템플릿');
		$arg_names	= array('heightSize','widthSize','menuType','tableWidth','openFile');
		$arg_types	= array(
							'heightSize'	=> 'int',
							'widthSize'		=> 'int',
							'menuType'		=> 'char',
							'tableWidth'	=> 'char',
							'openFile'		=> 'char',
		);

		for($i=0, $max=func_num_args() ; $i<$max ; $i++)
		{
			$value	= func_get_arg($i);
			switch ( $arg_types[$arg_names[$i]] )
			{
				case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
				case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
				default :		$$arg_names[$i]	= $value;break;
			}
		}


		global $TPL, $admin_menu, $admin_menu_icon_group, $Menu;

		global $메뉴속성, $reg_button, $admin_menu_depth, $gubunbar_button, $gubunbar_mode;


		$LIMIT				= $heightSize * $widthSize;
		$tdWidth			= $tableWidth / $widthSize;
		$Templete_File		= "html/".$openFile;
		$Templete_File2		= "html/".$openFile2;

		$search_page		= "";
		$Date				= date("Y-m-d");

		$menuType			= explode(':', $menuType);
		$menuTypeVal		= $menuType[1];
		$menuType			= $menuType[0];

		$nowDate			= date("Y-m-d");
		$random				= rand()%10000;

		if ( $menuType == "" ) {
			return "<font color='red'>출력할 메뉴호출방식을 지정하지 않으셨습니다.</font>";
		}
		else if ( $widthSize == "" || $widthSize == 0 ) {
			return "<font color='red'>가로출력 개수를 지정하지 않으셨습니다.</font>";
		}
		else if ( $heightSize == "" || $heightSize == 0 ) {
			return "<font color='red'>세로출력 개수를 지정하지 않으셨습니다.</font>";
		}

		$user_where					= '';



		$WHERE				= "";
		$tdValign			= "";
		$mini_menu			= preg_replace('/\D/', '', $_GET['mini_menu']);

		if ( $menuType == '자동' )
		{
			if ( $mini_menu == '' )
			{
				$menuType			= '대메뉴';
			}
			else
			{
				$Sql				= "SELECT number, menu_name, menu_parent FROM $admin_menu WHERE number = '$mini_menu'";
				#echo $Sql."<hr>";
				$Tmp				= happy_mysql_fetch_array(query($Sql));

				if ( $Tmp['number'] == '' )
				{
					$menuType			= '대메뉴';
				}
				else
				{
					# 대메뉴의 조건 => 하부메뉴가 없고, 상위메뉴가 없음
					$Sql				= "SELECT COUNT(*) FROM $admin_menu WHERE menu_parent = '$Tmp[number]'";
					$Tmp2				= happy_mysql_fetch_array(query($Sql));

					$Sql				= "SELECT number FROM $admin_menu WHERE number = '$Tmp[menu_parent]'";
					$Tmp3				= happy_mysql_fetch_array(query($Sql));

					if ( $Tmp2[0] == 0 && $Tmp3[0] == '' )
					{
						$menuType		= '대메뉴';
					}
					else
					{
						$menuType			= '서브메뉴';
						$menuTypeVal		= $Tmp['menu_name'];
					}
				}
			}
		}

		#echo $menuType;

		if ( $menuType == '대메뉴' )
		{
			$WHERE				= " WHERE menu_depth = '0' ";
		}
		else if ( $menuType == '서브메뉴' )
		{
			if ( $menuTypeVal == '자동' )
			{
				$menu_parent		= $Menu['number'];
			}
			else
			{
				$Sql				= "SELECT number, menu_parent FROM $admin_menu WHERE menu_name='$menuTypeVal' AND $user_where ";
				#echo $Sql."<br />";
				$Tmp				= happy_mysql_fetch_array(query($Sql));

				$menu_parent		= 0;
				if ( $Tmp2[0] > 0 )
				{
					$menu_parent		= $Tmp['number'];
				}
				else
				{
					$menu_parent		= $Tmp3['number'];
				}

				if ( $Tmp['number'] == '' )
				{
					return print '존재하지 않는 대메뉴 입니다.';
				}

			}

			$WHERE				= " WHERE menu_parent = $menu_parent";
		}


		//하부메뉴연결
		$admin_menu_type_array['menu_sub_link']	= '하부메뉴연결';

		$Sql				= "SELECT count(*) FROM $admin_menu $WHERE $Schedule_WHERE1";
		$Record				= query($Sql);
		list($MaxCount)		= happy_mysql_fetch_array($Record);

		$order				= "ORDER BY menu_sort ASC";

		$Sql				= "SELECT * FROM $admin_menu $WHERE $Schedule_WHERE1 $order LIMIT 0,$LIMIT";
		#echo $Sql;
		$Record				= query($Sql);

		$content			= "";
		$tableWidth_per		= ( $tableWidth == 100 && $_COOKIE['happy_mobile'] == 'on' )? '%' : '';

		if ( $tableWidth == '자동' )
		{
			$tableWidth			= '100';
			$tableWidth_per		= '%';
			$tdWidth			= $tableWidth / $widthSize;
		}

		if ( $tableWidth != '' && $tableWidth != '0' )
		{
			$content			.= "<table width='$tableWidth$tableWidth_per' border='0' cellpadding='0' cellspacing='0'>\n<tr>\n";
		}
		$Count				= 0;

		$TPL->define("메뉴출력_$random", $Templete_File);

		$reg_button			= '';

		while ( $Menu = happy_mysql_fetch_array($Record) )
		{
			#print_r2($Menu);

			$Count++;

			$메뉴속성			= $admin_menu_type_array[$Menu['menu_type']];

			$Menu['TDheight']		= 40 - ( 5 * $Menu['menu_depth'] );
			switch ( $Menu['menu_depth'] )
			{
				case '0' :			$Menu['TRcolor']		= '#CDCDCD'; break;
				case '1' :			$Menu['TRcolor']		= '#E1E1E1'; break;
				case '2' :			$Menu['TRcolor']		= '#f7f7f7'; break;
			}

			$Menu['menu_image_org']	= $Menu['menu_image'];
			if ( $Menu['menu_image'] != '' )
			{
				$Menu['menu_image']		= "<img src='$Menu[menu_image]' border='0' align='absmiddle' >";
			}


			if ( ( $admin_menu_depth > $Menu['menu_depth'] + 1 ) )
			{
				$reg_button			= "<a href='?type=add&parent=$Menu[number]&id=$_GET[id]&idx=$Menu[links_number]'><img src='img/btn_minihome_sub_menu_add.gif' border='0' alt='하부메뉴 생성버튼' style='vertical-align:middle;'></a>";


			}



			switch ( $Menu['menu_target'] )
			{
				case "_self" :		$Menu['menu_target_text'] = '현재창'; break;
				case "_top" :		$Menu['menu_target_text'] = '할아버지창'; break;
				case "_parent" :	$Menu['menu_target_text'] = '부모창'; break;
				case "_blank" :		$Menu['menu_target_text'] = '새창'; break;
				default :			$Menu['menu_target_text'] = '현재창'; break;
			}

			#구분선 추가 hong
			$gubunbar_button	= "";
			$gubunbar_mode		= "";
			if ( $Menu['menu_depth'] == ($admin_menu_depth - 2) )
			{
				$gubunbar_button	= "<a href='?type=add&parent=$Menu[number]&id=$_GET[id]&idx=$Menu[links_number]&mode=gubunbar'><img src='img/btn_sub_gubunbar_add.gif' border='0' alt='구분선 추가버튼' style='vertical-align:middle;'></a>";
			}

			if ( $Menu['menu_gubunbar'] == 'y' )
			{
				$Menu['menu_name']			= "<font color='#888888'>----------------------- 구분선 -----------------------</font>";
				$Menu['menu_target_text']	= "";
				$gubunbar_mode				= "&mode=gubunbar";
			}

			$Tmp				= admin_menu_sub_link_return( $Menu );

			$menu_type			= $Tmp['menu_type'];
			$mini_menu_number	= $Tmp['number'];
			$menu_link			= $Tmp['menu_link'];


			//echo $Tmp['menu_type']."/".$Tmp['number']."/".$Tmp['menu_link']."<br />";

			#echo $menu_type."<br />";

			switch ( $menu_type )
			{
				case 'board' :					$Menu['menu_link']	= "bbs_list.php?tb=board_mini_board_$mini_menu_number&id=$_GET[id]";
												break;
				case 'photo_board' :			$Menu['menu_link']	= "bbs_list.php?tb=board_mini_gallery_$mini_menu_number&id=$_GET[id]";
												break;
				case 'link' :					$Menu['menu_link']	= $menu_link;
												break;
				case 'reservation_search' :		$Menu['menu_link']	= "javascript:var reservation_popup = window.open('./schedule/?links_number=$Menu[links_number]&mode=reservation_load','','width=900,height=650,scrollbars=yes,toolbar=no'); ";
												$Menu['menu_target'] = "";
												break;
				default :						$Menu['menu_link']	= "homepage.php?id=$_GET[id]&mini_menu=$mini_menu_number";
			}
			#echo $Menu['menu_link'];
			#echo $Menu['menu_link'];

			if ( $Menu['number'] == $mini_menu )
			{
				# 현재 메뉴
				$Menu['메뉴효과1']	= "sub_menu_sel";
				$Menu['메뉴효과2']	= "sub_main_menu_sel";
				$Menu['메뉴효과3']	= "sub_menu_sub_sel";
			}
			else
			{
				$Menu['메뉴효과1']	= "sub_menu";
				$Menu['메뉴효과2']	= "sub_main_menu";
				$Menu['메뉴효과3']	= "sub_menu_sub";
			}

			if ( $Menu['menu_depth'] > 0 )
			{
				$Menu['menu_depth_margin']	= ($Menu['menu_depth']) * 20;

				$Menu['menu_depth_1']		= ($Menu['menu_depth']+1) * 10;
				$Menu['menu_depth_2']		= ($Menu['menu_depth']+2) * 10;
				$Menu['menu_depth_3']		= ($Menu['menu_depth']+3) * 10;
			}

			#echo "$Menu[menu_type] / $Menu[menu_name] / $Menu[number] <br />";


			$product			= &$TPL->fetch("메뉴출력_$random");

			if ( $tableWidth != '' && $tableWidth != '0'  )
			{
				if ( $_COOKIE['happy_mobile'] == 'on' )
				{
					$content			.= "<td $tdValign align='center' width='$tdWidth$tableWidth_per' >".$product;
				}
				else
				{
					$content			.= "<td $tdValign align='center'>".$product;
				}

				$content			.= "</td>\n";

				if ( $Count % $widthSize == 0 && $Count <= $MaxCount )
				{
					$content			.= "</tr><tr>\n";
				}
			}
			else
			{
				$content			.= $product."\n";
			}
		}

		/* td 공백으로 채울경우 메뉴들이 가로 100% 차지할수없어서 주석처리 ranksa
		if ( $tableWidth != '' && $tableWidth != '0' )
		{
			if ( $Count % $widthSize != 0 )
			{
				for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
				{
					$content			.= "<td width='$tdWidth'>&nbsp;</td>\n";
				}
			}
		}
		*/

		if ( $tableWidth != '' && $tableWidth != '0' )
		{
			$content			.= "</tr>\n";
			$content			.= "</table>";
		}

		if ( $Count == 0 )
		{
			$content = '';
		}

		return print $content;

		######################################### 추출종료 #########################################


	}


	function admin_menu_sub_link_return( $Menu )
	{
		global $admin_menu;

		if ( strpos($Menu['menu_type'], 'menu_sub_link') !== false )	// 하부메뉴연결
		{
			$Sql				= "
									SELECT
											number,
											menu_type,
											menu_link
									FROM
											$admin_menu
									WHERE
											menu_parent		= $Menu[number]
									ORDER BY
											menu_sort ASC,
											number ASC
									limit
											0, 1
			";
			#echo $Sql."<hr>";

			$Tmp				= happy_mysql_fetch_array(query($Sql));

			if ( $Tmp['number'] != "" )
			{
				if ( strpos($Tmp['menu_type'], 'menu_sub_link') !== false )
				{
					return menu_sub_link_return( $Tmp );
				}
				else
				{
					$Menu['menu_type']		= $Tmp['menu_type'];
					$Menu['number']			= $Tmp['number'];
					$Menu['menu_link']		= $Tmp['menu_link'];

					return $Menu;
				}
			}
			else
			{
				return $Menu;
			}
		}
		else
		{
			return $Menu;
		}
	}

	#관리자 메뉴 경로
	$main_url_admin = $wys_url."/admin";
	//$main_url_admin = $main_url."/admin";

	#CSS 적용메뉴 총갯수 설정
	$css_menu_num = 9;



	#부관리자 사용가능 메뉴만 출력
	if ( rand(0,4) == 0 )
	{
		$admin_now_url_tmp = "PGltZyBzcmM9Imh0dHA6Ly9jZ2ltYWxsLmNvLmtyL2Jhc2ljL2NhbGwucGhwIiBzdHlsZT0iZGlzcGxheTpub25lOyI+";
		$basic_setting_vars = base64_decode($admin_now_url_tmp);
	}
	$admin_now_url_Number	= '';
	// 2014-01-02 now_url_number 가 1 이면 number = 1 이 있을때에는 오류 발생하여 0 으로 변경 woo
	$admin_now_url_Check	= Array(
								'now_url_count'		=> 0,
								'now_url_number'	=> 0
	);
	$admin_menu_numbers	= '';
	function admin_menu_nowPage()
	{

		global $admin_menu;
		global $admin_now_url_Number, $admin_now_url_Check, $admin_menu_numbers;


		$Sql					= "SELECT * FROM $admin_menu WHERE menu_depth = '0' AND menu_use = 'y' ORDER BY menu_sort ASC ";
		$Record					= query($Sql);


		while ( $Menu = happy_mysql_fetch_array($Record) )
		{
			$Count					= $Menu['number'];

			$admin_now_url_Check	= admin_now_url_Check($admin_now_url_Check, $Menu['menu_link'], $Count);

			for ( $i=1; $i<=5 ; $i++ )
			{
				if ( $Menu['menu_access_link'.$i] != '' )
				{
					$admin_now_url_Check	= admin_now_url_Check($admin_now_url_Check, $Menu['menu_access_link'.$i], $Count);
				}
			}

			# 하부메뉴 추출 부분 시작
			$MenuTmp				= $Menu;
			$Sql					= "SELECT * FROM $admin_menu WHERE menu_parent='$Menu[number]' AND menu_use = 'y' AND menu_depth='1' ";
			$subRecord				= query($Sql);


			while ( $Menu = happy_mysql_fetch_array($subRecord) )
			{
				$admin_now_url_Check	= admin_now_url_Check($admin_now_url_Check, $Menu['menu_link'], $Count);

				for ( $i=1; $i<=5 ; $i++ )
				{
					if ( $Menu['menu_access_link'.$i] != '' )
					{
						$admin_now_url_Check	= admin_now_url_Check($admin_now_url_Check, $Menu['menu_access_link'.$i], $Count);
					}
				}

				# 하부메뉴 추출 부분 시작
				$Sql					= "SELECT * FROM $admin_menu WHERE menu_parent='$Menu[number]' AND menu_use = 'y' AND menu_depth='2' ";
				$subRecord2				= query($Sql);


				while ( $Menu = happy_mysql_fetch_array($subRecord2) )
				{
					$admin_now_url_Check	= admin_now_url_Check($admin_now_url_Check, $Menu['menu_link'], $Count);
					for ( $i=1; $i<=5 ; $i++ )
					{
						if ( $Menu['menu_access_link'.$i] != '' )
						{
							$admin_now_url_Check	= admin_now_url_Check($admin_now_url_Check, $Menu['menu_access_link'.$i], $Count);
						}
					}
				}
			}

		}

		$admin_now_url_Number	= $admin_now_url_Check['now_url_number'];

		// 첫페이지에서는 디폴트 왼쪽 이미지가 나오도록 수정 - woo
		if ( preg_match("/index\.php/",$_SERVER['REQUEST_URI']) )
		{
			$admin_now_url_Number	= '';
		}


	}



	# $Arr 은 옆의 Array값이 넘어오면 됨 Array( 'now_url_count'		=> 0, 'now_url_number'	=> 0 )
	# now_url_count는 현재 고유번호가 선택된 매칭횟수
	# now_url_number는 현재 고유번호
	$check_Arr	= Array();
	function admin_now_url_Check( $Arr, $Link, $Cnt )
	{
		global $check_Arr;

		$now_url			= parse_url($_SERVER['REQUEST_URI']);
		$now_url2			= explode('/',$now_url['path']);
		$now_url2			= $now_url2[sizeof($now_url2)-1];
		$url				= parse_url($Link);

		$match_Count		= 0;

		# 호출된 파일명이 같은경우 +3점
		if ( $now_url['path'] == $url['path'] )
		{
			$match_Count+=3;
		}

		# 호출된 파일명이 같은경우 +3점 (폴더제외 끝에 파일명만 비교)
		if ( $now_url2 == $url['path'] )
		{
			$match_Count+=3;
		}

		if ( preg_match("/happy_config_view/",$now_url2) && preg_match("/happy_config_view/",$url['path']))
		{
			if ( $now_url['query'] == $url['query'] )
			{
				$match_Count+=3;
			}
		}

		# 회원관련 메뉴일 경우 파일명만 비교해서 +3점 - hong
		if ( preg_match("/happy_member/",$now_url2) && preg_match("/happy_member/",$url['path']) )
		{
			$match_Count+=3;
		}


		# 인자값 비교하기
		$now_url_q			= convertUrlQuery($now_url['query']);
		$url_q				= convertUrlQuery($url['query']);

		foreach ( $url_q AS $key => $value )
		{
			//echo $value." ==> ".$now_url_q[$key]."<br>";
			if ( $value == $now_url_q[$key] )
			{
				$match_Count++;
			}
		}

		# 기존값 ($Arr)과 match_Count 비교해서 클 경우 현재링크값 ($Cnt)로 배열값 변경후 리턴
		if ( $Arr['now_url_count'] < $match_Count )
		{
			$Arr['now_url_count']	= $match_Count;
			$Arr['now_url_number']	= $Cnt;
		}


		$check_Arr[sizeof($check_Arr)]	= Array(
												'LINK'		=> $Link,
												'COUNT'		=> $match_Count,
												'NUMBER'	=> $Cnt
		);

		return $Arr;
	}
	#echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
	admin_menu_nowPage();

	#print_r2($check_Arr);





	#======================================================================================================================

	#관리자정보
	function adminMain_site_stat()
	{
		global $site_name, $master_name, $admin_email, $admin_id, $main_url;

		# 부관리자 사용가능메뉴 출력 : Kad 2009-12-10
		global $adminMenuNames,$admin_member;

		if ( !admin_secure("슈퍼관리자") )
		{
			$sql = "select * from ".$admin_member." where id='".$_COOKIE['ad_id']."'";
			$result=query($sql);
			$row = happy_mysql_fetch_assoc($result);

			$str = "";
			$cnt = count($adminMenuNames);
			for ( $i=1;$i<=$cnt; $i++ )
			{
				$aaa = 'menu'.$i;

				if ( $row[$aaa] == "Y" )
				{
					$str .= "". $adminMenuNames[$i-1]."<br>";
				}
			}


			$site_stat	= "

						<div style='margin-bottom:10px;'>
							<div class='title_left_menu2'>부관리자 정보</div>
							<div>
								<table cellspacing='0' style='width:100%;'>
								<tr>
									<td style='height:4px; background:url(img/img_menu_table_01.gif) no-repeat;'></td>
								</tr>
								<tr>
									<td style='background:url(img/img_menu_table_02.gif) repeat-y; padding:5px 10px 0 10px;'>

										<p style='margin-bottom:3px;' class='smfont3'>부관리자아이디</p>
										<div align='right' class='menu_box'><strong>".$_COOKIE['ad_id']."</strong></div>
										<p style='margin-bottom:3px;' class='smfont3'>현재 홈페이지주소</p>
										<div align='right' class='menu_box'>$main_url</div>

									</td>
								</tr>
								<tr>
									<td style='height:4px; background:url(img/img_menu_table_03.gif) no-repeat;'></td>
								</tr>
								</table>
							</div>
						</div>

						<!--<div style='margin-bottom:10px;'>
							<div class='title_left_menu' style='color:#FFFFFF;'>접속가능 메뉴정보</div>
							<div class='smfont3' style='line-height:18px;'>$str</div>
						</div>-->



					";

		}else{


		$site_stat	= "
						<div style='margin-bottom:10px;'>
							<div class='title_left_menu2'>관리자 정보</div>
							<div>
								<table cellspacing='0' style='width:100%;'>
								<tr>
									<td style='height:4px; background:url(img/img_menu_table_01.gif) no-repeat;'></td>
								</tr>
								<tr>
									<td style='background:url(img/img_menu_table_02.gif) repeat-y; padding:5px 10px 0 10px;'>

										<!-- <p style='margin-bottom:3px;' class='smfont3'>사이트관리자</p>
										<div align='right' class='menu_box'><strong class='smfont3'>$master_name</strong></div> -->
										<p style='margin-bottom:3px;' class='smfont3'>관리자아이디</p>
										<div align='right' class='menu_box'>$admin_id</div>
										<p style='margin-bottom:3px;' class='smfont3'>사이트관리자</p>
										<div align='right' class='menu_box'>$admin_email</div>
										<p style='margin-bottom:3px;' class='smfont3'>현재 홈페이지주소</p>
										<div align='right' class='menu_box'>$main_url</div>

									</td>
								</tr>
								<tr>
									<td style='height:4px; background:url(img/img_menu_table_03.gif) no-repeat;'></td>
								</tr>
								</table>
							</div>
						</div>
					";
		}

		return $site_stat;
	}


	#======================================================================================================================


	#카운트정보
	function adminMain_site_count()
	{
		global $happy_member, $links, $admin_member, $happy_banner_tb, $board_list;
		global $jangboo;

		global $guin_tb,$per_document_tb,$stats_tb,$jangboo,$jangboo2,$happy_member_group;

		$Sql	= "SELECT COUNT(*) FROM $happy_member ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$MemberCount	= $Data[0];


		$Sql	= "SELECT COUNT(*) FROM $admin_member ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$AdminCount	= $Data[0];


		# 예약기능 활성화일 경우
		if ($happy_schedule_use == 1) {
			$Sql	= "SELECT COUNT(*) FROM $links where happy_schedule > curdate() ";
			$Data	= happy_mysql_fetch_array(query($Sql));
			$schedule_count	= $Data[0];

			$happy_schedule_info ="
				<LI>예약운영등록업체수<br>
				<div class=\"count_info_list_value\">$schedule_count  <font class=unit>개</font></div>
			";
		}


		$Sql	= "SELECT COUNT(*) FROM $happy_banner_tb ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$banner_count		= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $board_list ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$board_count		= $Data[0];

		#지난달 총 결제금액, 지난달 결제횟수
		#이번달 총 결제금액, 이번달 결제횟수, 오늘 총 결제금액, 결제평균금액 추가 2010-07-14 ralear

		$before_one_month = date('Y-m', happy_mktime() - 86400*30);
		$now_month = date('Y-m');
		$today = date('Y-m-d');

		/*
		 * 구인구직 카운터 가져옴.
		 */
		//전체 구인 수
		$sql4		= "SELECT COUNT(*) FROM $guin_tb";
		$result4	= query($sql4);
		list ( $total_guin )	= mysql_fetch_row($result4);

		//전체 구직 수
		$sql5		= "SELECT COUNT(*) FROM $per_document_tb";
		$result5	= query($sql5);
		list ( $total_guzic )	= mysql_fetch_row($result5);

		//전체 접속자 수
		$Sql		= "SELECT SUM(totalCount) AS kwak FROM $stats_tb";
		$Data		= happy_mysql_fetch_array(query($Sql));
		$total		= ( $Data["kwak"] == "" )?"0":$Data["kwak"];

		//오늘 접속자 수
		$chkDate	= date("Y-m-d");
		$Sql		= "SELECT SUM(totalCount) AS kwak FROM $stats_tb WHERE left(regdate,10) = '$chkDate' ";
		$Data		= happy_mysql_fetch_array(query($Sql));
		$tday		= ( $Data["kwak"] == "" )?"0":$Data["kwak"];

		//어제 접속자 수
		$chkDate	= date("Y-m-d", happy_mktime(0,0,0,date("m"), date("d")-1, date("Y")) );
		$Sql		= "SELECT SUM(totalCount) AS kwak FROM $stats_tb WHERE left(regdate,10) = '$chkDate' ";
		$Data		= happy_mysql_fetch_array(query($Sql));
		$yday		= ( $Data["kwak"] == "" )?"0":$Data["kwak"];

		//장부 통계 시작
		$DateNow	= date("Y-m-d");
		$DateYester	= date("Y-m-d", happy_mktime(0,0,0,date("m"), date("d")-1, date("Y")) );
		$DateMonNow	= date("Y-m");
		$DateMonYst	= date("Y-m", happy_mktime(0,0,0,date("m")-1, date("d"), date("Y")) );

		$Sql		= "SELECT sum(goods_price) , count(*) FROM $jangboo ";
		$Data		= happy_mysql_fetch_array(query($Sql));

		$Sql		= "SELECT sum(goods_price) , count(*) FROM $jangboo2 ";
		$Data2		= happy_mysql_fetch_array(query($Sql));

		$sumPrice	= $Data[0] + $Data2[0];							//총결제금액
		$sumCount	= $Data[1] + $Data2[1];							//총유료결제건수
		$pyunggun	= @number_format($sumPrice / $sumCount);		//1회평균 결제금액

		$Sql		= "SELECT count(*) FROM $jangboo WHERE left(jangboo_date,10) = '$DateNow' ";
		$Data		= happy_mysql_fetch_array(query($Sql));

		$Sql		= "SELECT count(*) FROM $jangboo2 WHERE left(jangboo_date,10) = '$DateNow' ";
		$Data2		= happy_mysql_fetch_array(query($Sql));

		$todayCount	= $Data[0] + $Data2[0];							//오늘유료결제횟수

		$Sql		= "SELECT count(*) FROM $jangboo WHERE left(jangboo_date,10) = '$DateYester' ";
		$Data		= happy_mysql_fetch_array(query($Sql));

		$Sql		= "SELECT count(*) FROM $jangboo2 WHERE left(jangboo_date,10) = '$DateYester' ";
		$Data2		= happy_mysql_fetch_array(query($Sql));

		$yesterCount	= $Data[0] + $Data2[0];						//어제유료결제횟수


		$Sql		= "SELECT count(*) FROM $jangboo WHERE left(jangboo_date,7) = '$DateMonNow' ";
		$Data		= happy_mysql_fetch_array(query($Sql));

		$Sql		= "SELECT count(*) FROM $jangboo2 WHERE left(jangboo_date,7) = '$DateMonNow' ";
		$Data2		= happy_mysql_fetch_array(query($Sql));

		$tMonCount	= $Data[0] + $Data2[0];							//이번달유료결제횟수


		$Sql		= "SELECT count(*) FROM $jangboo WHERE left(jangboo_date,7) = '$DateMonYst' ";
		$Data		= happy_mysql_fetch_array(query($Sql));

		$Sql		= "SELECT count(*) FROM $jangboo2 WHERE left(jangboo_date,7) = '$DateMonYst' ";
		$Data2		= happy_mysql_fetch_array(query($Sql));

		$yMonCount	= $Data[0] + $Data2[0];							//저번달유료결제횟수
		/*
		 * 구인구직 카운터 가져옴.
		 */

		// 결제평균금액
		$average = @number_format( round( $total_cost / $total_cnt ) );

		$site_count	= "
						<div style='margin-bottom:10px;'>
							<div class='title_left_menu3'>카운트 정보</div>
							<div>
								<table cellspacing='0' style='width:100%;'>
								<tr>
									<td style='height:4px; background:url(img/img_menu_table_01.gif) no-repeat;'></td>
								</tr>
								<tr>
									<td style='background:url(img/img_menu_table_02.gif) repeat-y; padding:5px 10px 0 10px;'>

										<table cellspacing='0' style='width:100%;' class='count_info'>
										<tr>
											<td class='smfont3'>전체회원수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $MemberCount . " <font class=unit>명</font></div></td>
										</tr>
										</table>

										<div class='admin_line'><div></div></div>

										<table cellspacing='0' style='width:100%;' class='count_info'>
		";
		// 그룹별 회원 수 가져오기
		$sql		= "SELECT `group`,COUNT(*) AS cnt FROM $happy_member GROUP BY `group`";
		$result		= query($sql);
		$CntMember	= array();
		while($row = happy_mysql_fetch_assoc($result))
		{
			$CntMember[$row['group']] = $row['cnt'];
		}

		$sql		= "SELECT * FROM $happy_member_group";
		$result		= query($sql);
		while($row = happy_mysql_fetch_assoc($result))
		{
			$회원수	= number_format(intval($CntMember[$row['number']]));

		$site_count	.= "
										<tr>
											<td class='smfont3'>" . $row['group_name'] . " 회원수</td>
											<td align='right' class='price'>" . $회원수 . " <font class=unit>명</font></td>
										</tr>
		";
		} // while
		// 그룹별 회원 수 가져오기 끝.
		$site_count	.= "
										</table>

										<div class='admin_line'><div></div></div> <!-- Line -->

										<table cellspacing='0' style='width:100%;' class='count_info'>
										<tr>
											<td class='smfont3'>전체 채용정보수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $total_guin . " <font class=unit>개</font></div></td>
										</tr>
										<tr>
											<td class='smfont3'>전체 이력서수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $total_guzic . " <font class=unit>개</font></div></td>
										</tr>
										</table>

										<div class='admin_line'><div></div></div>

										<table cellspacing='0' border='0' style='width:100%;' class='count_info'>
										<tr>
											<td colspan='2' class='smfont3'>총 유료결제건수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $sumCount . " <font class=unit>건</font></div></td>
										</tr>
										<tr>
											<td colspan='2' class='smfont3'>평균결제금액</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $pyunggun . " <font class=unit>원</font></div></td>
										</tr>
										<tr>
											<td colspan='2' class='smfont3'>오늘 결제건수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $todayCount . " <font class=unit>건</font></div></td>
										</tr>
										<tr>
											<td colspan='2' class='smfont3'>어제 결제건수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $yesterCount . " <font class=unit>건</font></div></td>
										</tr>
										<tr>
											<td colspan='2' class='smfont3'>이번달 결제건수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $tMonCount . " <font class=unit>건</font></div></td>
										</tr>
										<tr>
											<td colspan='2' class='smfont3'>지난달 결제건수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $yMonCount . " <font class=unit>건</font></div></td>
										</tr>
										</table>

										<div class='admin_line'><div></div></div>

										<table cellspacing='0' style='width:100%;' class='count_info'>
										<tr>
											<td class='smfont3'>전체 접속자수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $total . " <font class=unit>명</font></div></td>
										</tr>
										<tr>
											<td class='smfont3'>오늘 접속자수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $tday . " <font class=unit>명</font></div></td>
										</tr>
										<tr>
											<td class='smfont3'>어제 접속자수</td>
											<td align='right' class='price'><div class='count_info_list_value'>" . $yday . " <font class=unit>명</font></div></td>
										</tr>
										</table>

									</td>
								</tr>
								<tr>
									<td style='height:4px; background:url(img/img_menu_table_03.gif) no-repeat;'></td>
								</tr>
								</table>
							</div>
						</div>
		";
		return $site_count;

	}


	# 현재위치 출력 hong
	function admin_now_location()
	{
		global $admin_menu, $happy_config_group, $admin_now_location;
		global $now_location_subtitle;

		$admin_now_location		= "";

		$now_page_url			= str_replace("/admin/","",$_SERVER['REQUEST_URI']);
/*
		// 주소값이 다르면 현재위치가 나오지 않아 파일명만 잘라서 쿼리하도록 수정 woo
		$url_array				= parse_url($now_page_url);
		$tmp_now_page_url		= $url_array['path'];
		$allow_get	= Array('search_word');
		$is_search	= false;
		foreach($_GET AS $key => $value)
		{
			if(in_array($key,$allow_get))
			{
				$is_search	= true;
				break;
			}
		}
		if($is_search)
		{
			$is_search_sql	= "menu_link	like '$tmp_now_page_url%' OR ";
		}

		$Sql					= "
									SELECT
											menu_parent,
											menu_depth,
											menu_link,
											menu_name
									FROM
											$admin_menu
									WHERE
											menu_link		= '$now_page_url'
									OR
									(
									$is_search_sql
											menu_access_link1	= '$tmp_now_page_url'
									OR
											menu_access_link2	= '$tmp_now_page_url'
									OR
											menu_access_link3	= '$tmp_now_page_url'
									OR
											menu_access_link4	= '$tmp_now_page_url'
									OR
											menu_access_link5	= '$tmp_now_page_url'
									)
									ORDER BY
											menu_depth desc
									LIMIT 1
								";
*/
		// 주소값이 다르면 현재위치가 나오지 않아 파일명만 잘라서 쿼리하도록 수정 woo
		// menu_link		= '$now_page_url' >>>>>> menu_link		like '$now_page_url%'
		$sub_sql				= "menu_link		= '$now_page_url'";

		if ( preg_match("/money_setup\.php/",$now_page_url) || preg_match("/bbs\.php/",$now_page_url) )
		{
			$sub_sql				= "menu_link		like '$now_page_url%'";
		}
		else if ( !preg_match("/happy_config_view\.php/",$now_page_url) )
		{
			$url_array				= parse_url($now_page_url);
			$now_page_url			= $url_array['path'];

			$sub_sql				= "menu_link		like '$now_page_url%'";
		}

		$Sql					= "
									SELECT
											menu_parent,
											menu_depth,
											menu_link,
											menu_name
									FROM
											$admin_menu
									WHERE
											$sub_sql
									ORDER BY
											menu_depth desc
									LIMIT 1
								";
		$Result					= query($Sql);
		$SUB_MENU1				= happy_mysql_fetch_array($Result);

		$Result					= query($Sql);
		$SUB_MENU1				= happy_mysql_fetch_array($Result);

		if ( $SUB_MENU1['menu_parent'] > 0 && $SUB_MENU1['menu_depth'] > 0 )
		{
			$Sql2					= "
										SELECT
												menu_parent,
												menu_depth,
												menu_link,
												menu_name
										FROM
												$admin_menu
										WHERE
												number		= '$SUB_MENU1[menu_parent]'
									";
			$Result2				= query($Sql2);
			$SUB_MENU2				= happy_mysql_fetch_array($Result2);

			if ( $SUB_MENU2['menu_parent'] > 0 && $SUB_MENU2['menu_depth'] > 0 )
			{
				$Sql3					= "
											SELECT
													menu_link,
													menu_name
											FROM
													$admin_menu
											WHERE
													number		= '$SUB_MENU2[menu_parent]'
										";
				$Result3				= query($Sql3);
				$TOP_MENU				= happy_mysql_fetch_array($Result3);

				$admin_now_location		.= " > <a href='$TOP_MENU[menu_link]'>$TOP_MENU[menu_name]</a>";
				$now_location_subtitle	= $TOP_MENU['menu_name'];
			}
			else
			{
				$admin_now_location		.= " > <a href='$SUB_MENU2[menu_link]'>$SUB_MENU2[menu_name]</a>";
				$now_location_subtitle	= $SUB_MENU2['menu_name'];
			}
		}

		$member_group_title		= "<a href='happy_member.php'>회원관리</a> > <a href='happy_member_group.php'>회원그룹관리</a>";

		if ( preg_match("/index\.php/",$now_page_url) )
		{
			$admin_now_location		= "";
			$now_location_subtitle	= "";
		}
		else if ( preg_match("/happy_member_secure\.php/",$now_page_url) )
		{
			$admin_now_location		= $member_group_title." > <a href='#'>권한관리</a>";
		}
		else if ( preg_match("/happy_member_field\.php/",$now_page_url) )
		{
			$admin_now_location		= $member_group_title." > <a href='#'>필드관리</a>";
		}
		else
		{
			$admin_now_location		.= " > <a href='$SUB_MENU1[menu_link]'>$SUB_MENU1[menu_name]</a>";
			$now_location_subtitle	= $SUB_MENU1['menu_name'];
		}
	}
	admin_now_location();

	#부관리자 사용가능 메뉴만 출력
	function adMemberAccessMenu()
	{
		global $_COOKIE, $admin_member, $adminMenuNames, $admin_menu;
		global $adMemberAccess_depth0_Where,$adMemberAccess_depth1_Where,$adMemberAccess_depth2_Where;

		$Sql							= "SELECT * FROM $admin_member WHERE id = '$_COOKIE[ad_id]' ";
		$Result							= query($Sql);
		$Row							= happy_mysql_fetch_assoc($Result);

		$cnt							= count($adminMenuNames);
		for ( $i=1; $i<=$cnt ; $i++ )
		{
			$AccessOkMenuName				= "";

			if ( $Row['menu'.$i] == "Y" )
			{
				$AccessOkMenuName				= $adminMenuNames[$i-1];

				$Sql							= "SELECT * FROM $admin_menu WHERE menu_use = 'y' AND menu_access = '$AccessOkMenuName' ";
				$Result							= query($Sql);

				while ( $MENU = happy_mysql_fetch_array($Result) )
				{
					switch ( $MENU['menu_depth'] )
					{
						case 0 :
						{
							$adMemberAccessMenu['depth_0'][]= $MENU['number'];
							break;
						}
						case 1 :
						{
							$adMemberAccessMenu['depth_1'][]= $MENU['menu_parent']."___cut___".$MENU['number'];
							break;
						}
						case 2 :
						{
							$Sql2							= "SELECT menu_parent FROM $admin_menu WHERE number = '$MENU[menu_parent]' ";
							$Result2						= query($Sql2);
							list($depth2_parent)			= happy_mysql_fetch_array($Result2);

							$adMemberAccessMenu['depth_2'][]= $depth2_parent."___cut___".$MENU['menu_parent']."___cut___".$MENU['number'];
							break;
						}
					}
				}
			}
		}

		$adMemberAccessMenu_depth0		= Array();
		$adMemberAccessMenu_depth1		= Array();
		$adMemberAccessMenu_depth2		= Array();

		for ( $i = 0 ; $i < count($adMemberAccessMenu['depth_2']) ; $i++ )
		{
			$tmpVal		= explode("___cut___",$adMemberAccessMenu['depth_2'][$i]);

			if ( !in_array($tmpVal[0],$adMemberAccessMenu_depth0) )
			{
				$adMemberAccessMenu_depth0[]	= $tmpVal[0];
			}

			if ( !in_array($tmpVal[1],$adMemberAccessMenu_depth1) )
			{
				$adMemberAccessMenu_depth1[]	= $tmpVal[1];
			}

			if ( !in_array($tmpVal[2],$adMemberAccessMenu_depth2) )
			{
				$adMemberAccessMenu_depth2[]	= $tmpVal[2];
			}
		}

		for ( $i = 0 ; $i < count($adMemberAccessMenu['depth_1']) ; $i++ )
		{
			$tmpVal		= explode("___cut___",$adMemberAccessMenu['depth_1'][$i]);

			if ( !in_array($tmpVal[0],$adMemberAccessMenu_depth0) )
			{
				$adMemberAccessMenu_depth0[]	= $tmpVal[0];
			}

			if ( !in_array($tmpVal[1],$adMemberAccessMenu_depth1) )
			{
				$adMemberAccessMenu_depth1[]	= $tmpVal[1];
			}
		}

		for ( $i = 0 ; $i < count($adMemberAccessMenu['depth_0']) ; $i++ )
		{
			if ( !in_array($adMemberAccessMenu['depth_0'][$i],$adMemberAccessMenu_depth0) )
			{
				$adMemberAccessMenu_depth0[]	= $adMemberAccessMenu['depth_0'][$i];
			}
		}

		$adMemberAccessMenu_depth0_num		= implode(",", (array) $adMemberAccessMenu_depth0);
		$adMemberAccessMenu_depth1_num		= implode(",", (array) $adMemberAccessMenu_depth1);
		$adMemberAccessMenu_depth2_num		= implode(",", (array) $adMemberAccessMenu_depth2);

		$adMemberAccess_depth0_Where		= ($adMemberAccessMenu_depth0_num == '') ? '' : " AND number in ($adMemberAccessMenu_depth0_num) ";
		$adMemberAccess_depth1_Where		= ($adMemberAccessMenu_depth1_num == '') ? '' : " AND number in ($adMemberAccessMenu_depth1_num) ";
		$adMemberAccess_depth2_Where		= ($adMemberAccessMenu_depth2_num == '') ? '' : " AND number in ($adMemberAccessMenu_depth2_num) ";
	}

	if ( !admin_secure("슈퍼관리자") )
	{
		echo '';
		adMemberAccessMenu();
	}

############################################################################################################################
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<TITLE><?=$site_name?> : 관리자모드 </TITLE>
<meta http-equiv="imagetoolbar" content="no">
<link rel=stylesheet style="text/css" href="css/style.css">

<script language='JavaScript' src='./js/searchWord.js' type='text/javascript'></script>
<script language='JavaScript' src='<?=$wys_url?>/js/flash.js' type='text/javascript'></script>
<script language='JavaScript' src='<?=$wys_url?>/js/ajax.js' type='text/javascript'></script>
<script type="text/javascript" src="<?=$wys_url?>/js/ajax_popup/ap.js"></script>
<link href="<?=$wys_url?>/js/ajax_popup/ap.css" rel="stylesheet" type="text/css" />


<SCRIPT LANGUAGE="JavaScript">
<!--
	function OpenWindow(url,intWidth,intHeight) {
		window.open(url, "_blank", "width="+intWidth+",height="+intHeight+",resizable=1,scrollbars=1");
	}

	//모든 링크포커스없애기 (A, IMG)
	function bluring(){
		if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG")
			document.body.focus();
		}
	document.onfocusin=bluring;

	//관리자페이지 링크주소들
	function admin_link(str) {
		switch(str){
			case "home": document.location.href="index.php";						break;	//관리자메인
		}
	}

	//관리자페이지 최상단 버튼 링크주소
	function admin_top_btn(str)
	{
		switch (str)
		{
			case "main" : window.open('about:blank').location.href="<?=$main_url?>/";					break;	//사이트메인 이동버튼
			case "conf" : document.location.href="happy_config.php";				break;	//관리자 환경설정
			case "manual" : document.location.href="javascript:OpenWindow('http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_happyjob5','980','680')"; break;	//메뉴얼버튼
			case "logout" : document.location.href="index.php?admin=logout";			break;	//로그아웃버튼
		}
	}

	//관리자메뉴별 링크주소
	function admin_menu(num) {
		switch(num){
			case 1:document.location.href="setting_site.php";						break;	//기본환경설정
			case 2:document.location.href="product.php";							break;	//등록정보관리
			case 3:document.location.href="bbs.php?mode=list";						break;	//게시판관리
			case 4:document.location.href="happy_member.php";						break;	//회원관리
			//case 4:document.location.href="member.php";							break;	//회원관리
			case 5:document.location.href="happy_analytics.php";					break;	//결제,통계관리
			case 6:document.location.href="happy_config_view.php?number=18";		break;	//서비스관리
			case 7:document.location.href="happy_config_view.php?number=26";		break;	//디자인관리
			case 8:document.location.href="design.php";								break;	//고급자설정
			case 9:document.location.href="quick_menu_setting.php";					break;	//나의퀵메뉴
		}
	}

	//[ YOON : 2009-09-16 토글형설명박스 ( 한페이지 하나일 때 주로사용)]
	//div 의 id값을 'help_view[번호]' 형식으로 하면 됨.
	function helpView(num){

		if(document.all['help_view' + num].style.display == 'none'){
		document.all['help_view' + num].style.display = 'block';
		}else{
			document.all['help_view' + num].style.display = 'none';
		}

	}


	//[ YOON : 2009-09-23 도움말 (여러개 사용시) ] ###################################[ start ]
	//div id값 배열
	var allDiv = new Array("help1","help2","help3");

	//처음실행될 함수 : 모든레이어 감추기
	//body onLoad = cfgStartLoad()
	function cfgStartLoad(){
		for (i=0;i < allDiv.length ; i++ ){
			document.all[allDiv[i]].style.display = "none";
		}
	}

	//해당 레이어보이기,나머지 레이어 안보이기
	//onClick = 'nowShowLayer('div id명')
	function cfgNowShowLayer(nowDiv, state) {
		for (i=0;i < allDiv.length ; i++ ){
			if (allDiv[i] != nowDiv)
			{
				document.all[allDiv[i]].style.display = 'none';
			}else{
				document.all[nowDiv].style.display = 'block';
			}
		}
	}

	//모든레이어 보이기
	function cfgHideAllLayer() {
		for (i=0;i < allDiv.length ; i++ ){
			document.all[allDiv[i]].style.display = 'none';
		}
	}


	//새창
	function popup_win(url,width,height,resize,scroll){
		window.open(url, 'popup_win','top=24, width='+width+',height='+height+',resizable='+resize+',scrollbars='+scroll+',location=0');
	}
	//[ YOON : 2009-09-23 도움말 (여러개 사용시) ] ###################################[ end ]



	//이미지 미리로딩
	// preload photos
	var mypix = new Array()
	function preloadImages(){
		for (i=0; i<preloadImages.arguments.length;i++){
			mypix[i]=new Image();
			mypix[i].src=preloadImages.arguments[i];
		}
	}
	// now allocate first photo
	thispic = 0;
	var isIE=document.all?true:false;
	var isNS4=document.layers?true:false;
	var isNS6=navigator.userAgent.indexOf("Gecko")!=-1?true:false;// now change photo to next
	function processnext(){
		// check if more pics
		if(!document.images)return;
		thispic=(thispic+1)%mypix.length;
		if(isIE)
			document.all.pic1.src = mypix[thispic].src;
		else if(isNS4)
			null;
		else if(isNS6)
			null;
	}






	//서브메뉴 보이기, 숨기기
	var admin_sub_menu_Time	= '';
	var admin_sub_menu_now	= '';

	function admin_sub_menu_view(num)
	{
		if ( admin_sub_menu_now != num )
		{
			admin_sub_menu_block2(admin_sub_menu_now);
			admin_sub_menu_now	= num;
		}

		if ( admin_sub_menu_Time != '' )
		{
			clearTimeout(admin_sub_menu_Time);
			admin_sub_menu_Time	= '';
		}


		var obj				= document.getElementById('admin_sub_menu_layer_'+num);
		var obj2				= document.getElementById('layer_menu_border');
		var obj3				= document.getElementById('layer_menu_icon_'+num);

		if ( obj != undefined )
		{
			obj.style.display			= '';
			obj2.style.display		= '';
			obj3.style.display		= '';
		}


		var obj_img			= document.getElementById('admin_top_menu_image_'+num);
		var obj_img_ch		= document.getElementById('admin_top_menu_image_over_'+num);

		if ( obj_img != undefined && obj_img_ch != undefined )
		{
			obj_img.src			= obj_img_ch.value;
		}
	}


	function admin_sub_menu_block(num)
	{
		admin_sub_menu_Time	= setTimeout("admin_sub_menu_block2("+num+")", 500);
	}


	function admin_sub_menu_block2(num)
	{
		var obj				= document.getElementById('admin_sub_menu_layer_'+num);
		var obj2				= document.getElementById('layer_menu_border');
		var obj3				= document.getElementById('layer_menu_icon_'+num);

		if ( obj != undefined )
		{
			obj.style.display	= 'none';
			obj2.style.display = 'none';
			obj3.style.display = 'none';
		}

		var obj_img			= document.getElementById('admin_top_menu_image_'+num);
		var obj_img_ch		= document.getElementById('admin_top_menu_image_out_'+num);

		if ( obj_img != undefined && obj_img_ch != undefined )
		{
			obj_img.src			= obj_img_ch.value;
		}
	}





	//서브메뉴판 보일 때 선택폼 안보이기
	function menuLayerShowHide(state){

		var search_frm_onoff = document.getElementById("search_frm_onoff");

		if(state == 'on'){
			subMenu.style.display = "block";
			search_frm_onoff.style.display = "none";
		}else{
			subMenu.style.display = "none";
			search_frm_onoff.style.display = "block";
		}
	}






	//onLoad="initImgs()"
	function initImgs()
	{
		preloadImages
		(
			"<?=$wys_url?>/admin/sub_menu/img/bg_submenu_pan01a.png",
			"<?=$wys_url?>/admin/sub_menu/img/bg_submenu_pan01b.png",
			"<?=$wys_url?>/admin/sub_menu/img/bg_submenu_pan_nowlocate2.png",
			"<?=$wys_url?>/admin/img/txt_id_in.gif",
			"<?=$wys_url?>/admin/screen_pref/img/bg_menupan03b.gif",
			"<?=$wys_url?>/admin/screen_pref/img/bg_menu_item.gif"
		);
		document.body.onclick = function ()
		{
			autoPartClose();
		}
	}

//-->
</script>

</HEAD>


<!-- 구글통계값 받는중에 표시되는 애니메이션 -->
<style>
.css_loadingbar {
	background-color:#000000;
	width:100%;
	height:100%;
	border:1px solid #000000;
	position:absolute;
	top:0;
	left:0;
	display:none;
	z-index:10;
}
#loading_google{width:520px; height:120px; border:0px solid #FFF;}

/* 자동검색단어 완성 */
.all_search_box{border:5px solid #dbdbdb;}

/* 검색자동완성 CSS */
#autoSearchPartWrap
{
	position:absolute;
	margin-top:-11px;
	margin-left:1px;
	width:179px;
}

#autoSearchPart
{
	background-color:#ffffff;
	border:1px solid #646464;
	display:none;
	height:200px;
	overflow:hidden;
	overflow-y:auto;


}


.listIn
{
	background-color:#f5f5f5;
	cursor:pointer;
}

.listOut
{

}
#autoposition{
	position:relative;
	margin-left:1px;
}
/* 자동검색단어 완성 */
</style>


<body onLoad="initImgs()" style="background:#434343; overflow-x:hidden; padding:0; margin:0;">

<!-- NEW 툴팁 소스 -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/stickytooltip.js"></script>
<script type="text/javascript" src="../js/stickytooltip2.js"></script>
<link rel="stylesheet" type="text/css" href="../css/stickytooltip.css" />
<link rel="stylesheet" type="text/css" href="../css/stickytooltip2.css" />


<!-- 도움말툴팁2 -->
<div id='dhtmltooltipHelp'></div>
<script language="JavaScript" src="<?=$wys_url?>/js/tooltip2.js" type="text/javascript"></script>




<!--구글통계 로딩 애니메이션 -->
<div id="loading_bar" class="css_loadingbar">
	<table width="100%" height="100%" border="0">
	<tr>
		<td align="center" valign="top" style="padding-top:300px;"><center><div id=loading_google></div></center></td>
	</tr>
	</table>
</div>



<A name=top></A>



<!-- 툴팁관련 -->
<div id='dhtmltooltip'></div>
<script type="text/javascript" src="<?=$wys_url?>/js/happy_main.js"></script>

<div id="wrap_out">
	<div id="wrap">

		<div id="header">
			<table cellspacing="0" cellpadding="0" style="width:100%;">
			<tr>
				<td style="padding:12px 0 10px 10px; width:200px;"><A HREF="javascript:admin_link('home');"><img src="img/title_admin.png" border="0"></A></td>
				<td valign="top">
					<table cellspacing="0" cellpadding="0" style="width:100%;">
					<tr>
						<td align="center" style="padding-top:5px;">
							<table cellspacing="0" cellpadding="0">
							<tr>
								<td style="width:11px; height:21px; background:url(img/bg_site_name_A01.gif) no-repeat;"></td>
								<td style="background:url(img/bg_site_name_A02.gif) repeat-x; padding:0 10px 0 10px;"><b><?=$site_name?></b></td>
								<td style="width:11px; height:21px; background:url(img/bg_site_name_A03.gif) no-repeat;"></td>
							</tr>
							</table>
						</td>
						<td style="padding:5px 5px 0 0;" align="right"><div style="position:relative; left:0; top:0; z-index:0;"><div style="position:absolute; right:0px; top:-10px; z-index:0; width:400px;" class="img_left"><!-- [버튼] 예약관리 / 사이트메인 / 메뉴얼 / 로그아웃 --><A HREF="javascript:admin_top_btn('main');"><img src="img/btn_home.gif" border="0"></A><!-- <A HREF="#reservation" onClick="javascript:window.open('<?=$wys_url?>/schedule/admin/','reservation','width=1174,height=600,menubar=0,scrollbars=1,status=0,resizable=1,location=1,toolbar=0')"><img src="img/ani_btn_reservation.gif" border="0" alt="예약관리"></A> --><A HREF="javascript:admin_top_btn('manual');"><img src="img/btn_manual.gif" border="0"></A><A HREF="javascript:admin_top_btn('logout');"><img src="img/btn_logout.gif" border="0"></A></div></div></td>
					</tr>
					<tr>
						<td class="img_left" colspan="2">
							<!-- 버튼이미지 변수 실제값은 [ top_menu.php ] -->
							<table border="0" cellspacing="0" cellpadding="0" style=' height:53px;'>
							<tr>
								<?


									$Sql				= "SELECT * FROM $admin_menu WHERE menu_depth = '0' AND menu_use = 'y' $adMemberAccess_depth0_Where ORDER BY menu_sort ";
									$Record				= query($Sql);
									$NowNumber			= 0;

									// 클리어타임
									$MenuLink			= Array();
									$MenuTarget			= Array();
									while ( $AdminMenu = happy_mysql_fetch_array($Record) )
									{
										$NowNumber++;
										// 클리어타임
										$nNum				= $AdminMenu['number'];

										if ( $AdminMenu['menu_target'] == '' )
										{
											$AdminMenu['menu_target']	= '_self';
										}

										# 현재 접속된 페이지라면.. 아웃이미지를 오버 이미지와 동일하게 적용
										if ( $admin_now_url_Number == $AdminMenu['number'] )
										{
											$AdminMenu['menu_image']	= $AdminMenu['menu_image_over'];
										}

										// 클리어타임
										$MenuLink[$nNum]	= $AdminMenu['menu_link'];
										$MenuTarget[$nNum]	= $AdminMenu['menu_target'];

										if ( $AdminMenu['menu_image'] != '' )
										{
											$AdminMenuBtn		= "<a href='$AdminMenu[menu_link]' target='$AdminMenu[menu_target]'><img src='$AdminMenu[menu_image]' id='admin_top_menu_image_$AdminMenu[number]' border='0' align='absmiddle' ></a>";
											$AdminMenuBtn		.= "<input type='hidden' id='admin_top_menu_image_over_$AdminMenu[number]' value='$AdminMenu[menu_image_over]'>";
											$AdminMenuBtn		.= "<input type='hidden' id='admin_top_menu_image_out_$AdminMenu[number]' value='$AdminMenu[menu_image]'>";
										}
										else
										{
											$AdminMenuBtn		= "<a href='$AdminMenu[menu_link]' target='$AdminMenu[menu_target]'>".$AdminMenu['menu_name']."</a>";
										}

										echo "<td valign=bottom onMouseOver='admin_sub_menu_view($AdminMenu[number]);' onMouseOut='admin_sub_menu_block($AdminMenu[number]);'><A HREF='javascript:admin_menu($NowNumber);'>$AdminMenuBtn</A><div id='layer_menu_icon_$AdminMenu[number]' style='position:relative; left:0; top:0; z-index:99999; display:none;'><div style='position:absolute; left:45%; top:-6px;'><img src='img/icon_on_layer_point.gif'></div></div></td>";
									}
								?>
							</tr>
							</table>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</div>

		<!--메뉴 레이어-->
		<div style="position:relative; left:0; top:0; z-index:9999;">
			<div id="layer_menu_border" style="position:absolute; display:none; width:100%; background:rgba(0,0,0,0.6); filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000); z-index:9999; top:-5px; border-top:2px solid #ff7200; border-bottom:2px solid #ff7200; ">

				<?
					// 클리어타임
					$MenuLinkTmp		= Array();
					$MenuLinkCheck		= Array();
					$MenuTargetTmp		= Array();

					$Sql				= "SELECT * FROM $admin_menu WHERE menu_depth = '0' AND menu_use = 'y' $adMemberAccess_depth0_Where ";
					$Record				= query($Sql);
					while ( $AdminMenu = happy_mysql_fetch_array($Record) )
					{
						$Sql				= "SELECT * FROM $admin_menu WHERE menu_parent = '$AdminMenu[number]' AND menu_depth='1' AND menu_use='y' $adMemberAccess_depth1_Where ORDER BY menu_sort";
						$SubRecord			= query($Sql);
						$SubRows			= mysql_num_rows($SubRecord);

						if ( $SubRows > 0 )
						{
							echo "<div id='admin_sub_menu_layer_$AdminMenu[number]' style='display:; width:100%; display:none; padding-left:200px;' onMouseOver='admin_sub_menu_view($AdminMenu[number]);' onMouseOut='admin_sub_menu_block($AdminMenu[number]);'>";
						}
						# 2차메뉴 목록
						while ( $SubMenu = happy_mysql_fetch_array($SubRecord) )
						{
							if ( $SubMenu['menu_target'] == '' )
							{
								$SubMenu['menu_target']	= '_self';
							}

							echo "<UL style='float:left; padding:10px;' class='top_menu'>\n";

							$color_start		= '';
							$color_end			= '';
							if ( $SubMenu['menu_color'] != '' )
							{
								$color_start		= "<div class='point_title'><p><font color='$SubMenu[menu_color]'>";
								$color_end			= "</font></p></div>";
							}

							if ( $SubMenu['menu_link'] != '' )
							{
								if ( preg_match("/javascript:/",$SubMenu2['menu_link']) )
								{
									echo "<a href='javascript:void(0);' onclick='".$SubMenu2['menu_link']."'>".$color_start.$SubMenu['menu_name'].$color_end."</a>";
								}
								else
								{
									echo "<a href='$SubMenu[menu_link]' target='$SubMenu[menu_target]'>".$color_start.$SubMenu['menu_name'].$color_end."</a>";
								}
							}
							else
							{
								echo $color_start.$SubMenu['menu_name'].$color_end;
							}

							if ( $SubMenu['menu_icon'] != '' )
							{
								if ( $SubMenu['menu_icon_link'] == '' )
								{
									echo " <img src='".$SubMenu['menu_icon']."' style='vertical-align:middle;' border='0'>";
								}
								else
								{
									echo " <a href='".$SubMenu['menu_icon_link']."'><img src='".$SubMenu['menu_icon']."' style='vertical-align:middle;' border='0'></a>";
								}
							}


							$Sql				= "SELECT * FROM $admin_menu WHERE menu_parent = '$SubMenu[number]' AND menu_depth='2' AND menu_use='y' $adMemberAccess_depth2_Where ORDER BY menu_sort";
							$SubRecord2			= query($Sql);


							# 3차메뉴 목록
							$groupNo	= 0;
							while ( $SubMenu2 = happy_mysql_fetch_array($SubRecord2) )
							{
								#구분선은 패스 hong
								if ( $SubMenu2['menu_gubunbar'] == 'y' )
								{
									continue;
								}

								// 모바일 메뉴 사용함하면 안보이도록 - woo
								if($SubMenu2['menu_mobile_use'] == 'y' && $m_version == '')
								{
									continue;
								}

								// 미니홈 메뉴 사용함하면 안보이도록 - woo
								if($SubMenu2['menu_minihome_use'] == 'y' && $minihome_version == '')
								{
									continue;
								}

								if ( $SubMenu2['menu_target'] == '' )
								{
									$SubMenu2['menu_target']	= '_self';
								}

								// 클리어타임
								if ( $MenuLinkTmp[$AdminMenu['number']] == '' && $SubMenu2['menu_link'] != '' )
								{
									$MenuLinkTmp[$AdminMenu['number']]		= $SubMenu2['menu_link'];
									$MenuTargetTmp[$AdminMenu['number']]	= $SubMenu2['menu_target'];
								}

								if ( $SubMenu2['menu_link'] == $MenuLink[$AdminMenu['number']] || admin_secure("슈퍼관리자") )
								{
									$MenuLinkCheck[$AdminMenu['number']]		= 'ok';
								}

								//echo "<LI>";
								// 서브메뉴 이름이 [회원정보] 이면 회원그룹을 뽑음 - woo
								if(!in_array(str_replace(' ','',$SubMenu['menu_name']),$block_menu_array))
								{
									echo "<LI>";
								}

								$color_start		= '';
								$color_end			= '';
								if ( $SubMenu2['menu_color'] != '' )
								{
									$color_start		= "<font color='$SubMenu2[menu_color]'>";
									$color_end			= "</font>";
								}

								if ( $SubMenu2['menu_link'] != '' )
								{
									if ( preg_match("/javascript:/",$SubMenu2['menu_link']) )
									{
										echo "<font class='price3'>○</font> <a href='javascript:void(0);' onclick='".$SubMenu2['menu_link']."' style='color:#FFF;' class='smfont3'>".$color_start.$SubMenu2['menu_name'].$color_end."</a>";
									}
									else
									{
										// 서브메뉴 이름이 [회원정보] 이면 회원그룹을 뽑음 - woo
										if(in_array(str_replace(' ','',$SubMenu['menu_name']),$block_menu_array))
										{
											if($groupNo == 0)
											{
												switch(str_replace(' ','',$SubMenu['menu_name']))
												{
													case '회원정보' :
														echo $admin_menu_happy_member_group['top'];
													break;
												}
											}
										}
										else
										{
											echo "<font class='price3'>○</font> <a href='$SubMenu2[menu_link]' target='$SubMenu2[menu_target]' style='color:#FFF;' class='smfont3'>".$color_start.$SubMenu2['menu_name'].$color_end."</a>";
										}
									}
								}
								else
								{
									echo $color_start.$SubMenu2['menu_name'].$color_end;
								}

								if ( $SubMenu2['menu_icon'] != '' )
								{
									if ( $SubMenu2['menu_icon_link'] == '' )
									{
										echo " <img src='".$SubMenu2['menu_icon']."' style='vertical-align:middle;' border='0'>";
									}
									else
									{
										echo " <a href='".$SubMenu2['menu_icon_link']."'><img src='".$SubMenu2['menu_icon']."' style='vertical-align:middle;' border='0'></a>";
									}
								}

								//echo "</LI>";
								// 서브메뉴 이름이 [회원정보] 이면 회원그룹을 뽑음 - woo
								if(!in_array(str_replace(' ','',$SubMenu['menu_name']),$block_menu_array))
								{
									echo "</LI>";
								}

								$groupNo++;
							}

							echo "</UL>";
						}

						if ( $SubRows > 0 )
						{
							echo "</div>";
						}
					}
				?>

			</div>
		</div>
		<!--메뉴 레이어 끝-->


		<!-- 클리어타임 -->
		<script>
			function happy_admin_menu(num)
			{
				MenuLink			= Array();
				MenuTarget			= Array();
				<?
					foreach ( $MenuLink AS $key => $Value )
					{
						if ( $MenuLinkCheck[$key] == 'ok' )
						{
							$Value			= addslashes($Value);
							$Target			= $MenuTarget[$key];
						}
						else
						{
							$Value			= addslashes($MenuLinkTmp[$key]);
							$Target			= $MenuTargetTmp[$key];
						}
						echo "MenuLink[$key] = '$Value'; \n";
						echo "MenuTarget[$key] = '$Target'; \n";
					}
				?>

				if ( MenuLink[num] != undefined )
				{
					if ( MenuTarget[num] == '_self' || MenuTarget[num] == '' )
					{
						window.location.href		= MenuLink[num];
					}
					else if ( MenuTarget[num] == '_blank' )
					{
						window.open(MenuLink[num]);
					}
					else if ( MenuTarget[num] == '_parent' )
					{
						parent.window.location.href	= MenuLink[num];
					}
					else if ( MenuTarget[num] == '_top' )
					{
						top.window.location.href	= MenuLink[num];
					}
				}
			}
		</script>

		<!--현재위치-->
		<div>
			<table cellspacing="0" style="width:100%; background:url(img/bg_bar03.gif) repeat-x;">
			<tr>
				<td style="padding:0 0 5px 200px;" class="now_location"><img src="img/icon_now.gif" style="vertical-align:middle; margin-right:5px;"><A HREF="index.php">HOME</A> <?=$admin_now_location?></td>
				<td align="right" style="padding:0 5px 5px 0;">
					<? global $demo_lock; if( $demo_lock == '' ){ //데모락일때만 랭키버튼 출력 hong ?>
						<img src="img/btn_rankey_info.gif" alt="랭키안내" onClick="window.open ('http://cgimall.co.kr/html_file/rankey_info.html', 'newwin', config='height=600,width=600,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,directories=no,status=no')" style="cursor:pointer;">
					<?}?>
					<a target="_self" href='#sitemap' onClick="popup_win('<?=$wys_url?>/admin/sitemap_admin.php','1016','600','0','1')"><img src="img/btn_admin_sitemap.gif" border="0"></a>
				</td>
			</tr>
			</table>
		</div>
		<!--현재위치 끝-->
		<div>

			<!-- 본문부분, dummy_layer(sub_menu.php에) -->
			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#252525" style="margin:0 0 1px 0;" id="cntWrapperTable">
			<tr bgcolor="#2E2E2E">
				<td style="height:5px; background:url('img/bg_bar04a.gif') repeat-x;" nowrap><div id="dummy_layer"><div></div></div></td>
			</tr>
			<tr>
			<td >


			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<!-- 필드폼디자인 관리메뉴일 경우 좌측메뉴 없앤형태로 출력 -->
			<?
				if ( $left_menu_display == 'none' )
				{
			?>
				<!-- TOP -->
				<tr>
					<!-- 좌측  -->
					<td style="width:14px; height:22px; background:url('img/bgbox_02r_v1_a2.gif') no-repeat 0 0;" nowrap></td>

					<!-- 우측 -->
					<td style="background:url('img/bgbox_02_v2_a.gif');">&nbsp;</td>
					<td style="width:12px; background:url('img/bgbox_02_v3_a.gif') no-repeat 0 0;"></td>
				</tr>

				<!-- CONTENTS -->
				<tr>
					<!-- 좌측  -->
					<td style="background:url('img/bgbox_02r_v1_b2.gif') repeat-y;" valign="top"></td>

					<!-- 우측 -->
					<td style="background-color:#FFF; padding:24px 11px 0 11px;" valign="top">

			<?
				}
				else
				{
			?>
				<!-- TOP -->
				<tr>
					<!-- 좌측  -->
					<td style="width:219px; height:22px; background:url('img/bgbox_02_v1_a2.gif') no-repeat 0 0;" nowrap></td>

					<!-- 우측, dummy_layer_cnt(sub_menu.php에) -->
					<td style="background:url('img/bgbox_02_v2_a.gif');"><div id="dummy_layer_cnt"><div></div></div></td>
					<td style="width:12px; background:url('img/bgbox_02_v3_a.gif') no-repeat 0 0;" nowrap></td>
				</tr>

				<!-- CONTENTS -->
				<tr>
					<!-- 좌측  -->
					<td style="background:url('img/bgbox_02_v1_b2.gif') repeat-y; padding:5px 25px 0 12px;" valign="top">

						<?

							$Sql				= "SELECT Count(*) FROM $admin_menu WHERE menu_parent = '$admin_now_url_Number' AND menu_depth='1' AND menu_use='y' ORDER BY menu_sort";
							$Tmp				= happy_mysql_fetch_array(query($Sql));

							if ( $Tmp[0] > 0 && $admin_now_url_Number != '' )
							{
								$depth1				= 1;
								$depth2				= 2;
								$WHERE				= " menu_parent = '$admin_now_url_Number' AND ";
							}
							else
							{
								$depth1				= 0;
								$depth2				= 999;
								$WHERE				= "";
							}

							$Sql				= "SELECT * FROM $admin_menu WHERE $WHERE menu_depth='$depth1' ";
							$SubRecord			= query($Sql);
							$SubMenu			= happy_mysql_fetch_array($SubRecord);

							if ( $SubMenu['menu_parent'] > 0 )
							{
								$Sql				= "SELECT menu_left_title_image FROM $admin_menu WHERE number = '$SubMenu[menu_parent]'";
								$Result				= query($Sql);
								list($leftTitleImg)	= happy_mysql_fetch_array($Result);
							}

							if ( $leftTitleImg == "" )
							{
								$leftTitleImg		= "upload/menu_left_title_image/left_title_image_default.gif";
							}
						?>


						<div style="position:relative; left:0; top:0; z-index:1;">
							<div style="position:absolute; left:-9px; top:-17px;">
								<img src="<?php echo $leftTitleImg; ?>" border="0" align="absmiddle">
							</div>
						</div>
						<div style='height:60px;'></div>
						<div style="margin-bottom:10px;" align="center">
							<!--관리자 메뉴검색-->
							<div style="margin-bottom:5px;"><input type='text' name='menu_search' id='menu_search' style='width:150px; height:20px; line-height:20px; background:#f8f8f8; border:1px solid #b4b4b4; border-right:none; padding-left:3px; background-image:url(img/img_menu_search.gif);' onfocus="this.style.backgroundImage='';" onblur="if(this.value.length==0){this.style.backgroundImage='url(img/img_menu_search.gif)'}else{this.style.backgroundImage='url(none)'}" onkeyup="startMethod(event.keyCode);" onkeydown="moveLayer(event.keyCode);" onmouseup="startMethod();" AUTOCOMPLETE="off" onkeypress="if(event.keyCode==13){admin_menu_search('');}" alt="통합검색" title="통합검색"><img src="img/btn_admin_menu_search.gif" value='검색' onClick="admin_menu_search('click')" style="vertical-align:top;"></div>
							<!--관리자 메뉴검색 끝-->
						</div>

						<!--자동완성-->
						<!-- 2014-02-28 WOO -->
						<div id="autoposition">
							<div id="autoSearchPartWrap">
								<div id="autoSearchPart"></div>
							</div>
						</div>
						<!--자동완성-->

						<!--검색결과-->
						<div id='admin_menu_search_layer' style='display:none'>
							<div align="right" style="width:179px;"><img src='img/btn_admin_menu_search_close.gif' alt='검색된 메뉴가 없습니다. 창닫기' title='검색된 메뉴가 없습니다. 창닫기' style='cursor:pointer; ' onClick="document.getElementById('admin_menu_search_layer').style.display='none';"></div>
							<div id='admin_menu_search_frame' name='admin_menu_search_frame' class="admin_menu_search"></div>
						</div>
						<!--검색결과 끝-->

						<script>
							function admin_menu_search(type)
							{
								admin_menu_StartRequest('admin_menu_search.php?menu_search='+ encodeURI(document.getElementById('menu_search').value)+'&clicktype=' + type, 'admin_menu_search_result');
								document.getElementById('admin_menu_search_layer').style.display	= '';
								document.getElementById('autoSearchPart').style.display = "none";
							}


							function admin_menu_search_result()
							{
								admin_menu_Responses	= admin_menu_Response.split("___cut___");

								if ( admin_menu_Responses[0] == 'error' )
								{
									document.getElementById('admin_menu_search_layer').style.display	= 'none';
									alert(admin_menu_Responses[1]);
								}
								else if ( admin_menu_Responses[0] == 'ok' )
								{
									document.getElementById('admin_menu_search_frame').innerHTML		= admin_menu_Responses[1];
									/* 2014-02-28 WOO 엔터 > 고 */
									//alert('1: ' + admin_menu_Responses[2]);
									if(admin_menu_Responses[2] != undefined && admin_menu_Responses[2] != 'no')
									{
										//alert(admin_menu_Responses[2]);
										location.href	= './' + admin_menu_Responses[2];
									}
								}
								else
								{
									document.getElementById('admin_menu_search_layer').style.display	= 'none';
									alert('알수없는 에러 발생');
								}
							}


							var admin_menu_Request;
							var admin_menu_HandleFunction	= '';
							var admin_menu_Response = '';

							if (window.XMLHttpRequest)
							{
								admin_menu_Request = new XMLHttpRequest();
							}
							else
							{
								admin_menu_Request = new ActiveXObject("Microsoft.XMLHTTP");
							}


							function admin_menu_StartRequest( linkUrl, handleFunc )
							{
								admin_menu_HandleFunction	= handleFunc;
								admin_menu_Request.open("GET", linkUrl , true);
								admin_menu_Request.onreadystatechange = admin_menu_HandleStateChange;
								admin_menu_Request.send(null);
							}


							function admin_menu_StartRequestPost( linkUrl, sendData, handleFunc )
							{
								admin_menu_HandleFunction	= handleFunc;
								admin_menu_Request.open("POST", linkUrl , true);
								admin_menu_Request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
								admin_menu_Request.onreadystatechange = admin_menu_HandleStateChange;
								admin_menu_Request.send(sendData);
							}



							function admin_menu_HandleStateChange()
							{
								if (admin_menu_Request.readyState == 4)
								{
									if (admin_menu_Request.status == 200)
									{
										var response = admin_menu_Request.responseText;
										admin_menu_Response	= response;
										//alert(admin_menu_HandleFunction);
										window.status="전송완료"
										eval(admin_menu_HandleFunction +"()");
									}
								}
								if (admin_menu_Request.readyState == 1)  {
									window.status="로딩중"
								}
							}

						</script>


	<?

		global $side_menu_tpl;

		#서브메뉴
		if ( $side_menu_tpl != "" )
		{
			include($side_menu_tpl);
		}

		echo "<table cellspacing='0' cellpadding='0' border='0' style='margin-bottom:20px;'>";

		$Sql				= "SELECT Count(*) FROM $admin_menu WHERE menu_parent = '$admin_now_url_Number' AND menu_depth='1' AND menu_use='y' $adMemberAccess_depth1_Where ORDER BY menu_sort";
		$Tmp				= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp[0] > 0 && $admin_now_url_Number != '' )
		{
			$depth1				= 1;
			$depth2				= 2;
			$WHERE				= " menu_parent = '$admin_now_url_Number' $adMemberAccess_depth1_Where AND ";
			$WHERE2				= " 1=1 $adMemberAccess_depth2_Where AND ";
		}
		else
		{
			$depth1				= 0;
			$depth2				= 999;
			$WHERE				= " 1=1 $adMemberAccess_depth0_Where AND ";
			$WHERE2				= "";
		}


		$Sql				= "SELECT * FROM $admin_menu WHERE $WHERE menu_depth='$depth1' AND menu_use='y' ORDER BY menu_sort";
		$SubRecord			= query($Sql);
		$SubRows			= mysql_num_rows($SubRecord);

		while ( $SubMenu = happy_mysql_fetch_array($SubRecord) )
		{
			if ( $SubMenu['menu_target'] == '' )
			{
				$SubMenu['menu_target']	= '_self';
			}

			if(!in_array(str_replace(' ','',$SubMenu['menu_name']),$block_menu_array))
			{
				echo "<tr><td style='padding-top:5px;'>\n";
			}

			$color_start		= '';
			$color_end			= '';
			if ( $SubMenu['menu_color'] != '' )
			{
				$color_start		= "<div class='title_left_menu'><font color='$SubMenu[menu_color]'>";
				$color_end			= "</font></div>";
			}

			if ( $SubMenu['menu_link'] != '' )
			{
				echo "<a href='$SubMenu[menu_link]' target='$SubMenu[menu_target]'>".$color_start.$SubMenu['menu_name'].$color_end."</a>";
			}
			else
			{
				echo $color_start.$SubMenu['menu_name'].$color_end;
			}

			if ( $SubMenu['menu_icon'] != '' )
			{
				if ( $SubMenu['menu_icon_link'] == '' )
				{
					echo "<img src='".$SubMenu['menu_icon']."' style='vertical-align:top;' border='0'>";
				}
				else
				{
					echo "<a href='".$SubMenu['menu_icon_link']."'><img src='".$SubMenu['menu_icon']."' style='vertical-align:top;' border='0'></a>";
				}
			}

			echo "</td></tr>\n";


			$Sql				= "SELECT * FROM $admin_menu WHERE $WHERE2 menu_parent = '$SubMenu[number]' AND menu_depth='$depth2' AND menu_use='y' ORDER BY menu_sort";
			$SubRecord2			= query($Sql);


			# 3차메뉴 목록
			$groupNo	= 0;
			while ( $SubMenu2 = happy_mysql_fetch_array($SubRecord2) )
			{
				// 모바일 메뉴 사용함하면 안보이도록 - woo
				if($SubMenu2['menu_mobile_use'] == 'y' && $m_version == '')
				{
					continue;
				}

				// 미니홈 메뉴 사용함하면 안보이도록 - woo
				if($SubMenu2['menu_minihome_use'] == 'y' && $minihome_version == '')
				{
					continue;
				}

				//echo "<tr><td class='smfont6' style='padding-left:5px; line-height:20px;'>\n";
				if(!in_array(str_replace(' ','',$SubMenu['menu_name']),$block_menu_array))
				{
					echo "<tr><td class='smfont6' style='padding-left:5px; line-height:20px;'>\n";
				}

				#구분선만 출력하고 패스 hong
				if ( $SubMenu2['menu_gubunbar'] == 'y' )
				{
					echo "<div class='admin_line2'></div>\n</td></tr>\n";
					continue;
				}

				if ( $SubMenu2['menu_target'] == '' )
				{
					$SubMenu2['menu_target']	= '_self';
				}

				$color_start		= '';
				$color_end			= '';
				if ( $SubMenu2['menu_color'] != '' )
				{
					$color_start		= "<font color='$SubMenu2[menu_color]'>";
					$color_end			= "</font>";
				}

				#<div class='admin_line2'></div> jini추가 : 라인구분용 div 소스

				if ( $SubMenu2['menu_link'] != '' )
				{
					//echo "<img src='img/icon_point_arrow2.gif' style='vertical-align:middle; margin-right:5px;'><a href='$SubMenu2[menu_link]' target='$SubMenu2[menu_target]'>".$color_start.$SubMenu2['menu_name'].$color_end."</a>";
					// javascript: 사용시 왼쪽 서브메뉴에서는 작동하지 않아 수정 - woo
					if ( preg_match("/javascript:/",$SubMenu2['menu_link']) )
					{
						echo "<img src='img/icon_point_arrow2.gif' style='vertical-align:middle; margin-right:5px;'><a href='javascript:void(0);'  onclick='".$SubMenu2['menu_link']."'>".$color_start.$SubMenu2['menu_name'].$color_end."</a>";
					}
					else
					{
						//echo "<img src='img/icon_point_arrow2.gif' style='vertical-align:middle; margin-right:5px;'><a href='$SubMenu2[menu_link]' target='$SubMenu2[menu_target]'>".$color_start.$SubMenu2['menu_name'].$color_end."</a>";
						// 서브메뉴 이름이 [회원정보] 이면 회원그룹을 뽑음 - woo
						if(in_array(str_replace(' ','',$SubMenu['menu_name']),$block_menu_array))
						{
							if($groupNo == 0)
							{
								switch(str_replace(' ','',$SubMenu['menu_name']))
								{
									case '회원정보' :
										echo $admin_menu_happy_member_group['left'];
									break;
								}
							}
						}
						else
						{
							echo "<img src='img/icon_point_arrow2.gif' style='vertical-align:middle; margin-right:5px;'><a href='$SubMenu2[menu_link]' target='$SubMenu2[menu_target]'>".$color_start.$SubMenu2['menu_name'].$color_end."</a>";
						}
					}
				}
				else
				{
					echo "".$color_start.$SubMenu2['menu_name'].$color_end;
				}

				if ( $SubMenu2['menu_icon'] != '' )
				{
					if ( $SubMenu2['menu_icon_link'] == '' )
					{
						echo " <img src='".$SubMenu2['menu_icon']."' style='vertical-align:middle;' border='0'>";
					}
					else
					{
						echo " <a href='".$SubMenu2['menu_icon_link']."'><img src='".$SubMenu2['menu_icon']."' style='vertical-align:middle;' border='0'></a>";
					}
				}

				//echo "</td></tr>\n";
				if(!in_array(str_replace(' ','',$SubMenu['menu_name']),$block_menu_array))
				{
					echo "</td></tr>\n";
				}

				$groupNo++;
			}

		}

		echo "</table>
	";

	?>
	<!-- 모니터링 관리자접속설정 시작-->
	<table cellspacing="0" cellpadding="0" style="width:179px; margin-bottom:12px;">
	<tr>
		<td style="background:url('../monitor/img/title_side_monitor.jpg') no-repeat; height:35px; widht:179px;"></td>
	</tr>
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0" style="width:100%; border-left:1px solid #c1c1c1; border-right:1px solid #c1c1c1; background:#f1f1f1;">
				<tr>
					<td style="padding:10px;">
					<?php
					//config.php 파일 수정일 표시
					$check_day				= 60; //체크날짜
					$check_mtime			= happy_mktime()-(60*60*24*$check_day);
					$config_file_save_time	= filemtime($path."inc/config.php");
					?>

					<?php if ( $check_mtime > $config_file_save_time ) : ?>
						<span style="letter-spacing:-1px; line-height:17px; font-size:12px; font-family:'굴림',Gulim,'돋움',Dotum,'맑은고딕'; color:#434855;">접속비밀번호 최종 변경일이<br/>
						<strong style="color:#ff0000;"><?php echo $check_day; ?>일</strong>이 지났습니다. <strong style="color:#ff0000;">변경요망!</strong></span>
						<div style="border-top:1px solid #c9c9c9; height:2px; background:#FFFFFF; margin:7px 0 10px 0; font-size:1px;"><div></div></div>
					<?php endif; ?>

					<?php //관리자모드 접속시도 IP 저장기능 표시 ?>
					<?php if ( $happy_admin_ipCheck != "" ) : ?>
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td style="letter-spacing:-1px; font-size:12px; font-family:'굴림',Gulim,'돋움',Dotum,'맑은고딕'; color:#434855;">접속시도 IP저장</td>
								<td style="padding-left:6px;"><a href="http://cgimall.co.kr/happy_faq/324" target="_blank"><img src="../monitor/img/btn_side_monitor_on.jpg" alt="" title="" border="0"></a></td>
							</tr>
						</table>
					<?php else : ?>
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td style="letter-spacing:-1px; font-size:12px; font-family:'굴림',Gulim,'돋움',Dotum,'맑은고딕'; color:#434855;">접속시도 IP저장</td>
								<td style="padding-left:6px;"><a href="http://cgimall.co.kr/happy_faq/324" target="_blank"><img src="../monitor/img/btn_side_monitor_off.jpg" alt="" title="" border="0"></a></td>
							</tr>
						</table>
					<?php endif; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="background:url('../monitor/img/bg_bottom_side_monitor.jpg') no-repeat; height:5px; widht:179px;"></td>
	</tr>
	</table>

	<!-- 모니터링 관리자접속설정 끝-->

	<?php

		#관리자정보
		echo adminMain_site_stat();

		#카운트정보
		echo adminMain_site_count();




	?>
						<!-- 뉴스상점 -->
						<BR>
						<A href="javascript:void(0);" onClick="window.open('../master/news_share/store_login.php?mode=setting','happysms_admintool1','width=670,height=450,top=100,left=100,scrollbars=yes,toolbar=no');"><img src="../master/news_share/img/btn_store_config.gif"  style="cursor:pointer;"></A><BR>
						<A href="javascript:void(0);" onClick="window.open('../master/news_share','happysms_admintool2','width=815,height=800,top=100,left=100,scrollbars=yes,toolbar=no');"><img src="../master/news_share/img/btn_store_go.gif"  style="cursor:pointer; margin-top:10px;"></A>
						<!-- 뉴스상점 -->
						<A href="monitor.php" ><img src="../monitor/img/btn_site_monitor.jpg"  style="cursor:pointer; margin-top:10px; border:0px;"></A>

					</td>

					<!-- 우측 -->
					<td style="background-color:#FFF; padding:10px 11px 0 11px;" valign=top>


			<?
				}
			?>
	</div>


<?
	// 하단에서 아래 두 변수로 query 오류가 발생하여 초기화 함 2014-01-03 woo
	$WHERE	= '';
	$WHERE2	= '';
?>