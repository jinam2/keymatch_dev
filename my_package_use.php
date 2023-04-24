<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");

//member_check(); #서버부하↑


if ( $mem_id == "" )
{
	go('happy_member_login.php?returnUrl=my_package_list.php');
	exit;
}

$plus.= "&pack_number=".$_GET['pack_number']."&";


//print_r2($_GET);

if ( $_GET['pay_type'] == "" )
{
	//채용정보 등록가능하면
	if ( !happy_member_secure( '구인정보등록' ) )
	{
		error('접속권한이 없습니다.');
		exit;
	}

	//채용정보의 아이콘옵션은 패키지에서 제외
	$del_bunho = array("11");
	$tmp_arr1 = array();
	$tmp_arr2 = array();
	$tmp_arr3 = array();
	$i = 0;
	foreach($ARRAY as $k => $v)
	{
		if ( !in_array($i,$del_bunho) && $CONF[$v."_use"] != "사용안함" )
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
	$plus.= "&pay_type=".$pay_type;

	//패키지권으로 추가된 설정 2011-06-23 kad
	//회원관련 유료옵션 분리
	$member_options				= array('guin_docview','guin_docview2','guin_smspoint','guin_jump');
	//회원테이블에 있는 유료옵션
	$member_option_pertb		=  array('guin_docview','guin_docview2','guin_smspoint','guin_jump');
	//패키지권으로 추가된 설정 2011-06-23 kad


}
else if ( $_GET['pay_type'] == "person" )
{
	//이력서 등록가능하면
	if ( !happy_member_secure( '구직정보등록' ) )
	{
		error('접속권한이 없습니다.');
		exit;
	}

	//이력서의 스킨과,아이콘옵션은 패키지에서 제외
	$del_bunho = array(3,7);
	$tmp_arr1 = array();
	$tmp_arr2 = array();
	$tmp_arr3 = array();
	$i = 0;
	foreach($PER_ARRAY_DB as $k => $v)
	{
		if ( !in_array($i,$del_bunho) && $CONF[$v."_use"] != "사용안함" )
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

	//패키지권으로 추가된 설정 2011-06-23 kad
	//회원관련 유료옵션 분리
	$member_options				= array('guzic_view','guzic_view2','guzic_smspoint');
	//회원테이블에 있는 유료옵션
	$member_option_pertb		=  array('guzic_view','guzic_view2','guzic_smspoint');
	//패키지권으로 추가된 설정 2011-06-23 kad

	$pay_type = "person";
	$plus.= "&pay_type=".$pay_type;

	//이력서 페이징
	$searchMethod	.= "&pay_type=".urlencode($_GET['pay_type']);
	$searchMethod	.= "&pack_number=".urlencode($_GET['pack_number']);
}





if ( $_GET['mode'] != "use" )
{


	//사용할 패키지정보
	$pack_number = intval($_GET['pack_number']);
	$sql = "select * from $job_package where number = '".$pack_number."'";
	$result = query($sql);
	$Package = happy_mysql_fetch_assoc($result);


	$k = array_search($Package['option_name'],$option_array_name);
	$Package['uryo_name'] = $option_array[$k];
	$Package['type_icon'] = "<img src=$option_array_icon[$k] align=absmiddle border=0>";
	$Package['danwi'] = ($Package['option_name'] == "reg_end_date")?"회":"일";

	$opt_name = $Package['option_name']."_option";
	if ( $CONF[$opt_name] == "기간별" )
	{
		$Package['danwi'] = "일";
	}
	else if ( $CONF[$opt_name] == "노출별" )
	{
		$Package['danwi'] = "회";
	}
	else if ( $CONF[$opt_name] == "클릭별" )
	{
		$Package['danwi'] = "회";
	}
	else if ( $CONF[$opt_name] == "이력서수" )
	{
		$Package['danwi'] = "회";
	}
	else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
	{
		$Package['danwi'] = "회";
	}
	else
	{
		$Package['danwi'] = "일";
	}
	//print_r($Package);

	if ( $pay_type == "" )
	{
		$TPL->define("package_use", "$skin_folder/my_package_use.html");
	}
	else if ( $pay_type == "person" )
	{
		$TPL->define("package_use", "$skin_folder/my_package_use_person.html");
	}

	$내용 = &$TPL->fetch();
}
else
{
	//패키지권 사용
	//패키지권 업데이트
	//매물에 옵션 변경

	//기업회원
	if ( $pay_type == "" )
	{
		$guin_number = intval($_GET['guin_number']);
		$sql = "select * from $guin_tb where number = '".$guin_number."'";
		$result = query($sql);
		$Guin = happy_mysql_fetch_assoc($result);

		$pack_number = intval($_GET['pack_number']);
		$sql = "select * from $job_package where number = '".$pack_number."'";
		$result = query($sql);
		$Package = happy_mysql_fetch_assoc($result);

		$update_type = "";

		if ( in_array($Package['option_name'],$member_options) )
		{
			if ( $mem_id != $Package['id'] )
			{
				error("잘못된접근");
				exit;
			}

			$update_type = "member";
		}
		else if ( $Guin['guin_id'] != $Package['id'] )
		{
			error("잘못된접근");
			exit;
		}

		$cur_date = date("Y-m-d");
		if ( $Package['use_date'] != "0000-00-00 00:00:00" )
		{
			error("이미 사용을 하신 패키지 옵션입니다.");
			exit;
		}
		else if ( $Package['end_date'] < $cur_date )
		{
			error("패키지의 사용기간이 지났습니다.");
			exit;
		}
		else
		{

			//최대광고허용개수 체크
			//채용정보에만 있네
			if ( $update_type == "" )
			{
				//print_r($CONF);
				//print_r($Package);

				//conf_array 와 option_array의 키를 찾아서 비교해야함
				$opt_key = $Package['option_name'];
				$tmp_max_cnt = $CONF[$opt_key."_max"];

				//기간제 옵션이면 $real_gap 을 빼서 플러스면 유료옵션 활성화되어 있다.
				//회수 옵션이면 DB에 저장된 숫자가 회수이다.
				$opt_name = $opt_key."_option";
				if ( $CONF[$opt_name] == "기간별" )
				{
					$opt_v = $real_gap;
				}
				else if ( $CONF[$opt_name] == "노출별" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "클릭별" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "이력서수" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
				{
					$opt_v = 0;
				}
				else
				{
					$opt_v = $real_gap;
				}

				//진행중인 채용정보만
				$view_where = " AND ( guin_end_date >= curdate() OR guin_choongwon = '1' ) and number != '".$Guin['number']."' ";
				$sql = "select count(*) from $guin_tb where ".$opt_key." >= ".$opt_v." ".$view_where;
				//echo $sql;
				$result = query($sql);
				list($cur_cnt) = happy_mysql_fetch_array($result);

				//echo $cur_cnt;
				if ( $tmp_max_cnt != "" && $tmp_max_cnt <= $cur_cnt )
				{
					if ( $_GET['prev_url'] != "" )
					{
						msg("최대 광고허용개수를 초과했습니다. \\n패키지권을 사용하실수가 없습니다.\\n");
						go(base64_decode($_GET['prev_url']));
					}
					else
					{
						msg("최대 광고허용개수를 초과했습니다. \\n패키지권을 사용하실수가 없습니다.\\n");
						//echo "<script>parent.document.location.reload()</script>";
						echo "<script>history.back(-1);</script>";
					}
					exit;
				}


				//채용정보 유료옵션 업데이트
				$opt_value = 0;
				/*
				if ( $Guin[$opt_key] >= $real_gap )
				{
					$opt_value = $Guin[$opt_key] + $Package['option_day'];
				}
				else
				{
					$opt_value = $real_gap + $Package['option_day'];
				}
				*/

				if ( $CONF[$opt_name] == "기간별" )
				{
					if ( $Guin[$opt_key] >= $real_gap )
					{
						$opt_value = $Guin[$opt_key] + $Package['option_day'];
					}
					else
					{
						$opt_value = $real_gap + $Package['option_day'];
					}
				}
				else
				{
					$opt_value = $Guin[$opt_key] + $Package['option_day'];
				}
				//echo "real_gap:".$real_gap."<br>";

				$sql = "update $guin_tb set ".$opt_key." = ".$opt_value." where number = '".$Guin['number']."'";
				//echo $sql;
				query($sql);
			}
			//회원유료옵션
			else if ( $update_type == "member" )
			{
				$opt_key = $Package['option_name'];
				$opt_name = $opt_key."_option";
				//echo $CONF[$opt_name]."<br>";
				if ( $CONF[$opt_name] == "기간별" )
				{
					$opt_v = $real_gap;
				}
				else if ( $CONF[$opt_name] == "노출별" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "클릭별" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "이력서수" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
				{
					$opt_v = 0;
				}
				else
				{
					$opt_v = $real_gap;
				}

				//print_r($Package);
				$cur_opt = happy_member_option_get($happy_member_option_type,$Package['id'],$Package['option_name']);
				//echo $cur_opt;

				//회수별이다
				if ( $opt_v == 0 )
				{
					$opt_value = $cur_opt + $Package['option_day'];
				}
				//기간별이다.
				else if ( $opt_v == $real_gap )
				{
					//옵션이 예전에 끝났다.
					if ( $cur_opt < $real_gap )
					{
						$opt_value = $real_gap + $Package['option_day'];
					}
					//아직 옵션이 남았다
					else
					{
						$opt_value = $cur_opt + $Package['option_day'];
					}
				}

				happy_member_option_set($happy_member_option_type,$Package['id'],$Package['option_name'],$opt_value,'int(11)');
			}

			//여기서 부터 패키지권 사용하는 부분
			$sql = "update $job_package set use_date = now() where number = '".$pack_number."'";
			//echo $sql."<hr>";
			query($sql);


			//echo $update_type; exit;

		}
	}
	//개인회원
	else if ( $pay_type == "person" )
	{
		//print_r($_GET);
		$guzic_number = intval($_GET['guzic_number']);
		$sql = "select * from $per_document_tb where number = '".$guzic_number."'";
		$result = query($sql);
		$Guzic = happy_mysql_fetch_assoc($result);

		$pack_number = intval($_GET['pack_number']);
		$sql = "select * from $job_package where number = '".$pack_number."'";
		$result = query($sql);
		$Package = happy_mysql_fetch_assoc($result);
		//print_r($Package);

		$update_type = "";

		if ( in_array($Package['option_name'],$member_options) )
		{
			if ( $mem_id != $Package['id'] )
			{
				error("잘못된접근");
				exit;
			}

			$update_type = "member";
		}
		else if ( $Guzic['user_id'] != $Package['id'] )
		{
			error("잘못된접근");
			exit;
		}

		$cur_date = date("Y-m-d");
		if ( $Package['use_date'] != "0000-00-00 00:00:00" )
		{
			error("이미 사용을 하신 패키지 옵션입니다.");
			exit;
		}
		else if ( $Package['end_date'] < $cur_date )
		{
			error("패키지의 사용기간이 지났습니다.");
			exit;
		}
		else
		{
			//이력서 유료옵션 변경
			if ( $update_type == "" )
			{
				//DB필드이름
				$opt_key = $PER_ARRAY[array_search($Package['option_name'],$PER_ARRAY_DB)];

				if ( $opt_key != "" )
				{
					//이력서 유료옵션날짜 업데이트
					if ( $Guzic[$opt_key] >= date("Y-m-d H:i:s") )
					{
						$opt_query = $opt_key." = DATE_ADD(".$opt_key.", INTERVAL ".$Package['option_day']." DAY) ";
					}
					else
					{
						$opt_query = $opt_key." = DATE_ADD(now(), INTERVAL ".$Package['option_day']." DAY) ";
					}

					$sql = "update $per_document_tb set ".$opt_query." where number = '".$Guzic['number']."'";
					//echo $sql;
					query($sql);
				}
			}
			//회원 유료옵션 변경
			else if ( $update_type == "member" )
			{
				//print_r($_GET);

				$opt_key = $Package['option_name'];
				$opt_name = $opt_key."_option";
				//echo $CONF[$opt_name]."<br>";
				if ( $CONF[$opt_name] == "기간별" )
				{
					$opt_v = $real_gap;
				}
				else if ( $CONF[$opt_name] == "노출별" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "클릭별" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "이력서수" )
				{
					$opt_v = 0;
				}
				else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
				{
					$opt_v = 0;
				}
				else
				{
					$opt_v = $real_gap;
				}

				//print_r($Package);
				$cur_opt = happy_member_option_get($happy_member_option_type,$Package['id'],$Package['option_name']);
				//echo $cur_opt;

				//회수별이다
				if ( $opt_v == 0 )
				{
					$opt_value = $cur_opt + $Package['option_day'];
				}
				//기간별이다.
				else if ( $opt_v == $real_gap )
				{
					//옵션이 예전에 끝났다.
					if ( $cur_opt < $real_gap )
					{
						$opt_value = $real_gap + $Package['option_day'];
					}
					//아직 옵션이 남았다
					else
					{
						$opt_value = $cur_opt + $Package['option_day'];
					}
				}

				happy_member_option_set($happy_member_option_type,$Package['id'],$Package['option_name'],$opt_value,'int(11)');
			}

			//echo $update_type; exit;


			//여기서 부터 패키지권 사용하는 부분
			$sql = "update $job_package set use_date = now() where number = '".$pack_number."'";
			//echo $sql."<hr>";
			query($sql);

		}



	}



	msg("패키지권을 사용했습니다.");


	if ( $update_type == "" )
	{
		if ( $_GET['prev_url'] != "" )
		{
			go(base64_decode($_GET['prev_url']));
		}
		else
		{
			//echo "<script>parent.document.location.reload()</script>";
			echo "<script>history.back(-1);</script>";
		}
	}
	else
	{
		go(base64_decode($_GET['prev_url']));
	}
	exit;

}







$temp = "default_blank_pop.html";

$TPL->define("출력", "$skin_folder/$temp");
$TPL->tprint();
$exec_time = array_sum(explode(' ', microtime())) - $t_start;
$exec_time = round ($exec_time, 2);
$쿼리시간 =  "Query Time : $exec_time sec";
if ($print_query_time)
{
	print "<center><font color=gray style='font-size:11px' face=arial>$쿼리시간</font>";
}


?>