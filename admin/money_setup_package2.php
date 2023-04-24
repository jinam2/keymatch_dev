<?php
	//기업회원 패키지옵션 설정
/*
//패키지 설정테이블
CREATE TABLE `job_money_package` (
  `number` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `price` int(11) NOT NULL default '0',
  `uryo_detail` text NOT NULL,
  `reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `end_day` int(11) NOT NULL default '0',
  `comment` varchar(250) NOT NULL default '',
  `is_use` int(11) not null default 0,
  PRIMARY KEY  (`number`),
  KEY `title` (`title`),
  KEY `reg_date` (`reg_date`),
  KEY `is_use` (`is_use`)
)
alter table `job_money_package` add pay_type varchar(10) not null default '';

//회원이 보유한 패키지권
CREATE TABLE `job_package` (
  `number` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `id` varchar(50) not null default '',
  `or_no` varchar(50) not null default '',
  `option_name` varchar(40) NOT NULL default '',
  `option_day` int(11) not null default '0',
  `reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `end_date` date NOT NULL default '0000-00-00',
  `use_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`number`),
  KEY `title` (`title`),
  KEY `id` (`id`),
  KEY `or_no` (`or_no`),
  KEY `reg_date` (`reg_date`),
  KEY `end_date` (`end_date`),
  KEY `use_date` (`use_date`)
);

//패키지 결제이후 패키지 옵션을 변경하면, 기존결제내역이 변경되는 것을 방지
CREATE TABLE `job_jangboo_package` (
  `number` int(11) NOT NULL auto_increment,
  `package_number` int(11) NOT NULL default '0',
  `jangboo_number` int(11) NOT NULL default '0',
  `uryo_detail` text not null default '',
  `or_no` varchar(50) not null default '',
  `id` varchar(40) NOT NULL default '',
  `reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(100) NOT NULL default '',
  `end_day` int(11) NOT NULL default '0',
  PRIMARY KEY  (`number`),
  KEY `id` (`id`),
  KEY `or_no` (`or_no`),
  KEY `package_number` (`package_number`),
  KEY `jangboo_number` (`jangboo_number`),
  KEY `reg_date` (`reg_date`)
);
*/



	include ("../inc/config.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/function.php");
	include ("../inc/lib.php");


	if ( !admin_secure("유료옵션설정") )
	{
		error("접속권한이 없습니다.");
		exit;
	}

	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################


	//기업회원
	if ( $_GET['pay_type'] == "" )
	{
		//채용정보의 아이콘옵션은 패키지에서 제외
		$del_bunho = array("11");
		$tmp_arr1 = array();
		$tmp_arr2 = array();
		$tmp_arr3 = array();
		$i = 0;
		foreach($ARRAY as $k => $v)
		{
			if ( !in_array($i,$del_bunho) )
			{
				$tmp_arr1[] = $ARRAY[$i];
				$tmp_arr2[] = $ARRAY_NAME[$i];
				$tmp_arr3[] = $ARRAY_NAME2[$i];
			}
			$i++;
		}
		//print_r($tmp_arr1);

		//유료옵션 제목
		$option_array_name = $tmp_arr1;
		//유료옵션 DB필드명
		$option_array = $tmp_arr2;
		//유료옵션 아이콘
		$option_array_icon = $tmp_arr3;


		$pay_type = "";
		$plus .= "&pay_type=".urlencode($pay_type);
	}
	//개인회원
	else
	{
		//이력서의 스킨과,아이콘옵션은 패키지에서 제외
		$del_bunho = array(3,7);
		$tmp_arr1 = array();
		$tmp_arr2 = array();
		$tmp_arr3 = array();
		$i = 0;
		foreach($PER_ARRAY_DB as $k => $v)
		{
			if ( !in_array($i,$del_bunho) )
			{
				$tmp_arr1[] = $PER_ARRAY_DB[$i];
				$tmp_arr2[] = $PER_ARRAY_NAME[$i];
				$tmp_arr3[] = $PER_ARRAY_ICON[$i];
			}
			$i++;
		}

		//유료옵션 제목
		$option_array_name = $tmp_arr1;
		//유료옵션 DB필드명
		$option_array = $tmp_arr2;
		//유료옵션 아이콘
		$option_array_icon = $tmp_arr3;



		$pay_type = "person";
		$plus .= "&pay_type=".urlencode($pay_type);
	}


	//echo "유료옵션패키지설정";

	if ( $_GET['mode'] == "" )
	{
		//echo "유료옵션패키지리스트";
		$TemplateFile = "money_setup_package2.html";

		$ex_limit = 10;

		if ( $_GET['search_word'] != '' )
		{
			$WHERE2 = " AND ";
			$search_type_0 = "";
			$search_type_1 = "";
			$search_type_2 = "";

			if ( $_GET['search_type'] == "" )
			{
				$WHERE2 .= " ( title like '%".$_GET['search_word']."%' OR price = '".$_GET['search_word']."' ) ";
				$search_type_0 = " selected ";
			}
			else if ( $_GET['search_type'] == 'title' )
			{
				$WHERE2 .= " title like '%".$_GET['search_word']."%' ";
				$search_type_1 = " selected ";
			}

			$plus .= "&search_type=".urlencode($_GET['search_type']);
			$plus .= "&search_word=".urlencode($_GET['search_word']);
		}

		//기업회원용인지? 개인회원용인지
		$WHERE2.= " AND pay_type = '".$pay_type."' ";



		$sql = "select * from $job_money_package2 where 1=1 ".$WHERE2;
		$result = query($sql);
		$numb = mysql_num_rows($result);

		$pg = $_GET[pg];
		if($pg==0 || $pg=="")
		{
			$pg=1;
		}

		//페이지 나누기
		$total_page = ( $numb - 1 ) / $ex_limit+1; //총페이지수
		$total_page = floor($total_page);
		$view_rows = ($pg - 1) * $ex_limit;
		$co  =  $numb  -  $ex_limit  *  ( $pg - 1 );


		$sql = "select * from $job_money_package2 where 1=1 ".$WHERE2." order by number desc limit ".$view_rows.",".$ex_limit;
		$result = query($sql);
		$Datas = array();
		$auto_number = $co;
		while($Data = happy_mysql_fetch_assoc($result))
		{
			$OutData['number'] = $Data['number'];
			$OutData['title'] = $Data['title'];
			$OutData['reg_date'] = $Data['reg_date'];



			$OutData['uryo_detail'] = uryo_title_convert($Data['uryo_detail']);
			$OutData['btn_mod'] = "<a href='money_setup_package2.php?mode=modify&number=".$Data['number']."&pay_type=".$pay_type."' class='btn_small_dark'>수정</a>";
			$OutData['btn_del'] = "<a onClick=\"if(confirm('삭제 하시겠습니까?')){location.href='money_setup_package2.php?mode=del&number=".$Data['number']."&pay_type=".$pay_type."&go_url=".base64_encode($_SERVER['REQUEST_URI'])."';}\" class='btn_small_red'>삭제</a>";

			if ( $Data['is_use'] == 0 )
			{
				$OutData['stats_text'] = "사용안함";
			}
			else
			{
				$OutData['stats_text'] = "사용중";
			}

			$OutData['auto_number'] = $auto_number;

			array_push($Datas,$OutData);
			$auto_number--;
		}

		include ("./page.php");


		$TPL->define("출력", "html/$TemplateFile");
		$TPL->assign("LOOP", $Datas);
		$TPL->tprint();
		//exit;
	}
	else if ( $_GET['mode'] == "modify" )
	{
		//echo "유료옵션패키지수정";
		$TemplateFile = "money_setup_package_modify2.html";

		$sql = "select * from $job_money_package2 where number = '".intval($_GET['number'])."'";
		$result = query($sql);
		$Package = happy_mysql_fetch_assoc($result);

		$Package['price']		= str_replace(",","\n",$Package['price']);

		$SWAP_CHECKED			= Array();
		$Package['ud_explode']	= explode(",",$Package['uryo_detail']);
		foreach($Package['ud_explode'] AS $ud_key => $ud_val)
		{
			$ud_val_explode		= explode(":",$ud_val);
			if($ud_val_explode[1] == 1)
			{
				$SWAP_CHECKED[]	= $ud_val_explode[0];
			}
		}
		//print_r2($SWAP_CHECKED);
		unset($ud_key,$ud_val);

		//유료옵션 DB꺼
		$Uryos = array();
		$tmp_a = explode(",",$Package['uryo_detail']);
		if ( is_array($tmp_a) )
		{
			$i = 0;
			foreach($tmp_a as $v)
			{
				$Uryo = array();
				$tmp_a2 = explode(":",$v);
				$uryo_name = $option_array[$i];
				$Uryo['uryo_name'] = $uryo_name;
				$Uryo['form_name'] = $tmp_a2[0];
				$Uryo['cnt_form_name'] = "cnt_".$tmp_a2[0];
				$Uryo['form_value'] = $tmp_a2[1];
				$Uryo['cnt_uryo_value'] = $tmp_a2[2];
				$type_icon = " <img src=../$option_array_icon[$i] align=absmiddle border=0>";
				$Uryo['uryo_icon'] = $type_icon;

				$Uryo['form_name_checked']	= "";
				if(in_array($Uryo['form_name'],$SWAP_CHECKED))
				{
					$Uryo['form_name_checked']	= "checked";
				}



				//if ( $i != 9 )
				//{
				//	$Uryo['uryo_danwi'] = "일";
				//}
				//else
				//{
				//	$Uryo['uryo_danwi'] = "회";
				//}


				//채용정보 + 기업회원의 유료옵션은 회수별,노출별,기간별,이력서수,횟수별 이 있다.
				$opt_name = $Uryo['form_name']."_option";
				//echo $opt_name.":".$CONF[$opt_name]."<br>";
				if ( $CONF[$opt_name] == "기간별" )
				{
					$Uryo['uryo_danwi'] = "일";
				}
				else if ( $CONF[$opt_name] == "노출별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "클릭별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "이력서수" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else
				{
					$Uryo['uryo_danwi'] = "일";
				}


				array_push($Uryos,$Uryo);
				$i++;
			}
		}

		$checked_is_use_0 = "";
		$checked_is_use_1 = "";
		if ( $Package['is_use'] == "1" )
		{
			$checked_is_use_1 = " checked ";
		}
		else
		{
			$checked_is_use_0 = " checked ";
		}



		//print_r($Uryos);
		$TPL->define("출력", "html/$TemplateFile");
		$TPL->assign("Uryos", $Uryos);
		$TPL->assign("출력");
		$TPL->tprint();
		//exit;

	}
	else if ( $_GET['mode'] == "mod" )
	{
		//echo "유료옵션패키지수정";
		//print_r($_POST);
		#옵션가격
		$pack_price_explode	= explode("\n",$_POST['pack_price']);
		$pp					= 0;
		$pack_price_info	= "";
		foreach($pack_price_explode AS $PPE_KEY => $PPE_VAL)
		{
			$pp++;
			$comma			= ($pp == 1)?"":",";
			$pack_price_info.= $comma.trim($PPE_VAL);
		}
		unset($uu,$comma,$PPE_KEY,$PPE_VAL);
		#옵션가격 END

		#선택옵션
		$uryo_detail = "";
		if ( is_array($option_array_name) )
		{
			$i = 0;
			foreach($option_array_name as $v)
			{
				if ( $_POST[$v] == "" )
				{
					$_POST[$v] = 0;
				}

				$uryo_detail.= $comma.$v.":".$_POST[$v];
				$comma = ",";
				$i++;
			}
		}
		#선택옵션 END

		$sql = "update $job_money_package2 set ";
		$sql.= "title = '".$_POST['pack_title']."',";
		$sql.= "price = '".$pack_price_info."',";
		$sql.= "end_day = '".$_POST['end_day']."',";
		$sql.= "comment = '".$_POST['pack_comment']."',";
		$sql.= "is_use = '".$_POST['pack_is_use']."',";
		//기업회원 or 개인회원
		$sql.= "pay_type = '".$_GET['pay_type']."',";
		$sql.= "uryo_detail = '".$uryo_detail."', ";
		$sql.= "add_option = '".$_POST['add_option']."',";
		$sql.= "help_link = '".$_POST['help_link']."'";
		$sql.= "where number = '".intval($_POST['number'])."'";
		//echo $sql;
		//exit;
		query($sql);
		error("패키지상품의 옵션이 수정되었습니다.");
		//exit;
	}
	else if ( $_GET['mode'] == "regist" )
	{
		$TemplateFile = "money_setup_package_regist2.html";

		//echo "유료옵션패키지등록";

		//print_r($option_array);
		$Uryos = array();
		if ( is_array($option_array_name) )
		{
			$i = 0;
			foreach($option_array_name as $v)
			{
				$Uryo = array();
				$uryo_name = $option_array[$i];
				$Uryo['uryo_name'] = $uryo_name;
				$Uryo['form_name'] = $v;
				$Uryo['cnt_form_name'] = "cnt_".$v;
				$type_icon = " <img src=../$option_array_icon[$i] align=absmiddle border=0>";
				$Uryo['uryo_icon'] = $type_icon;


				//if ( $i != 9 )
				//{
				//	$Uryo['uryo_danwi'] = "일";
				//}
				//else
				//{
				//	$Uryo['uryo_danwi'] = "회";
				//}

				//채용정보 + 기업회원의 유료옵션은 회수별,노출별,기간별,이력서수,횟수별 이 있다.
				$opt_name = $v."_option";
				//echo $opt_name.":".$CONF[$opt_name]."<br>";
				if ( $CONF[$opt_name] == "기간별" )
				{
					$Uryo['uryo_danwi'] = "일";
				}
				else if ( $CONF[$opt_name] == "노출별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "클릭별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "이력서수" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else
				{
					$Uryo['uryo_danwi'] = "일";
				}

				$Uryo['seq'] = $i;

				array_push($Uryos,$Uryo);
				$i++;
			}
		}

		//print_r($Uryos);
		$TPL->define("출력", "html/$TemplateFile");
		$TPL->assign("Uryos", $Uryos);
		$TPL->assign("출력");
		$TPL->tprint();
		//exit;

	}
	else if ( $_GET['mode'] == "reg")
	{
		#옵션가격
		$pack_price_explode	= explode("\n",$_POST['pack_price']);
		$pp					= 0;
		$pack_price_info	= "";
		foreach($pack_price_explode AS $PPE_KEY => $PPE_VAL)
		{
			$pp++;
			$comma			= ($pp == 1)?"":",";
			$pack_price_info.= $comma.trim($PPE_VAL);
		}
		unset($uu,$comma,$PPE_KEY,$PPE_VAL);
		#옵션가격 END

		#선택옵션
		$uryo_detail = "";
		if ( is_array($option_array_name) )
		{
			$i = 0;
			foreach($option_array_name as $v)
			{
				if ( $_POST[$v] == "" )
				{
					$_POST[$v] = 0;
				}

				$uryo_detail.= $comma.$v.":".$_POST[$v];
				$comma = ",";
				$i++;
			}
		}
		#선택옵션 END

		$sql = "insert into $job_money_package2 set ";
		$sql.= "title = '".$_POST['pack_title']."',";
		$sql.= "price = '".$pack_price_info."',";
		$sql.= "end_day = '".$_POST['end_day']."',";
		$sql.= "comment = '".$_POST['pack_comment']."',";
		$sql.= "is_use = '".$_POST['pack_is_use']."',";
		//기업회원 or 개인회원
		$sql.= "pay_type = '".$_GET['pay_type']."',";
		$sql.= "uryo_detail = '".$uryo_detail."',";
		$sql.= "add_option = '".$_POST['add_option']."',";
		$sql.= "help_link = '".$_POST['help_link']."',";
		$sql.= "reg_date = now()";
		//print_r2($_POST);
		//echo nl2br($sql);exit;
		query($sql);

		msg("패키지상품이 등록되었습니다.");
		go("money_setup_package2.php?pay_type=".$pay_type);
		exit;

		//echo $sql;
		//print_r($_POST);
		//exit;
	}
	else if ( $_GET['mode'] == "del" )
	{
		$sql = "delete from $job_money_package2 where number = '".intval($_GET['number'])."'";
		//echo $sql;
		query($sql);

		msg("패키지상품이 삭제되었습니다.");
		go(base64_decode($_GET['go_url']));
		//exit;

	}


	//유료옵션 이름
	function uryo_title_convert($str)
	{
		global $option_array;
		global $option_array_name;
		global $option_array_icon;

		global $CONF;

		$return_str = "";

		$tmp_a = explode(",",$str);
		if ( is_array($tmp_a) )
		{
			$i = 0;
			foreach($tmp_a as $v)
			{
				$Uryo['uryo_danwi'] = "";

				$tmp_a2 = explode(":",$v);
				$uryo_name = $option_array[$i];

				if ( $tmp_a2[1] != 0 )
				{
					$type_icon = " <img src=../$option_array_icon[$i] align=absmiddle border=0>";

					//if ( $i != 9 )
					//{
					//	$return_str.= $type_icon." ".$uryo_name." ".$tmp_a2[1]."일";
					//}
					//else
					//{
					//	$return_str.= $type_icon." ".$uryo_name." ".$tmp_a2[1]."회";
					//}

					//채용정보 + 기업회원의 유료옵션은 회수별,노출별,기간별,이력서수,횟수별 이 있다.
					$opt_name = $option_array_name[$i]."_option";
					//echo $opt_name.":".$CONF[$opt_name]."<br>";
					if ( $CONF[$opt_name] == "기간별" )
					{
						$Uryo['uryo_danwi'] = "일";
					}
					else if ( $CONF[$opt_name] == "노출별" )
					{
						$Uryo['uryo_danwi'] = "회";
					}
					else if ( $CONF[$opt_name] == "클릭별" )
					{
						$Uryo['uryo_danwi'] = "회";
					}
					else if ( $CONF[$opt_name] == "이력서수" )
					{
						$Uryo['uryo_danwi'] = "회";
					}
					else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
					{
						$Uryo['uryo_danwi'] = "회";
					}
					else
					{
						$Uryo['uryo_danwi'] = "일";
					}

					$return_str.= $type_icon." ".$uryo_name."($Uryo[uryo_danwi])"."<br>";
				}

				$i++;
			}
		}

		return $return_str;
	}





	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################

?>