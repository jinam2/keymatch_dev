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

	//패키지권으로 추가된 설정 2011-06-23 kad
	//회원관련 유료옵션 분리
	$member_options				= array('guin_docview','guin_docview2','guin_smspoint','guin_jump');
	//회원테이블에 있는 유료옵션
	$member_option_pertb		=  array('guin_docview','guin_docview2','guin_smspoint','guin_jump');
	//패키지권으로 추가된 설정 2011-06-23 kad

	$서비스이용항목 = get_uryo_cnt(2);


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

	$서비스이용항목 = get_uryo_cnt(2,2);
}


//패키지권 검색셀렉트박스
$var_name = 'is_use';
$select_name = $_GET['is_use'];
$title_name = array('전체','사용가능','사용불가');
$title_value = array('','1','0');
$search_sangtae_info = make_selectbox2($title_name,$title_value,$mod,$var_name,$select_name);


$var_name = 'option_name';
$select_name = $_GET['option_name'];
$title_name = array_merge(array("전체"),array_values($option_array));
$title_value = array_merge(array(""),$option_array_name);
$search_option_info = make_selectbox2($title_name,$title_value,$mod,$var_name,$select_name);




//템플릿 파일 읽어오기
if ( $_GET['mode'] == "" )
{
	$template_file = "my_package.html";

	if ( $_GET['pay_type'] == "person" )
	{
		$template_file = "my_package_person.html";
	}
}
else if ( $_GET['mode'] == "list" )
{
	$template_file = "my_package_list.html";

	if ( $_GET['pay_type'] == "person" )
	{
		$template_file = "my_package_list_person.html";
	}
}

$TPL->define("package_list", "$skin_folder/$template_file");
$내용 = &$TPL->fetch();



$Member			= happy_member_information($mem_id);
$member_group	= $Member['group'];

# 유저그룹별 껍데기 파일 추출	2010-06-29 ralear
$sql				= "select * from $happy_member_group where number='$member_group' ";
$result				= query($sql);
$Data				= happy_mysql_fetch_array($result);
$Template_Default	= $Data['mypage_default'];


//{{패키지보유리스트 가로1개,rows_package.html}}
function package_have_list()
{
	global $TPL;
	global $skin_folder;
	global $option_array,$option_array_name,$option_array_icon;
	global $mem_id;
	global $job_money_package,$job_package,$job_jangboo_package;
	global $Package;

	global $pay_type;

	global $CONF;
	//print_r($CONF);

	//print_r(func_get_args());
	$args = func_get_args();

	$ex_width = preg_replace('/\D/','',$args[0]);
	$ex_template = $args[1];

	if ( !file_exists($skin_folder."/".$ex_template) )
	{
		echo $skin_folder."/".$ex_template." 파일이 존재하지 않습니다.";
		return;
	}

	if ( is_array($option_array_name) )
	{
		$OptionCnt = array();
		$sql = "select id,option_name,count(*) as cnt from $job_package where id = '".$mem_id."' and use_date = '0000-00-00 00:00:00' and end_date >= curdate() group by option_name";
		$result = query($sql);
		//echo $sql."<br>";
		while($row = happy_mysql_fetch_assoc($result))
		{
			$OptionCnt[$row['option_name']] = $row['cnt'];
		}
		//print_r($OptionCnt);

		$TPL->define("패키지보유현황",$skin_folder."/".$ex_template);
		$i = 1;
		$k = 0;
		foreach($option_array_name as $uryo)
		{
			//echo $uryo.":".$option_array[$k].":".$CONF[$uryo."_use"]."<br>";
			if ( $CONF[$uryo."_use"] != "사용안함" )
			{
				//echo $uryo."<br>";
				$Package['uryo_name'] = $option_array[$k];
				$Package['option_name'] = $option_array_name[$k];
				$Package['type_icon'] = "<img src=$option_array_icon[$k] align=absmiddle border=0>";
				$Package['cnt'] = ($OptionCnt[$option_array_name[$k]] == "")?0:number_format($OptionCnt[$option_array_name[$k]]);

				$one_row = &$TPL->fetch();
				$rows .= table_adjust($one_row,$ex_width,$i);
				$i++;
			}
			$k++;
		}

		echo "<table cellpadding='0' cellspacing='0' border='0' width='100%' style='table-layout:fixed;'>$rows</table>";
	}
}

//{{패키지리스트 페이지당10개,가로1개,rows_package_list.html}}
function package_list()
{
	//print_r(func_get_args());
	global $TPL;
	global $skin_folder;
	global $option_array,$option_array_name,$option_array_icon;
	global $mem_id;
	global $job_money_package,$job_package,$job_jangboo_package;
	global $Package;
	global $패키지페이징;
	global $member_options,$member_option_pertb,$member_option_minihometb;

	global $pay_type;
	global $CONF;

	$args = func_get_args();

	$ex_limit = preg_replace('/\D/','',$args[0]);
	$ex_width = preg_replace('/\D/','',$args[1]);
	$ex_template = $args[2];
	//패키지권 유형 : 전체 or 사용가능 or 사용불가
	$ex_type = $args[3];
	//정렬순서 : 등록순 or 등록역순 or 마감일순 or 마감일역순
	$ex_order = $args[4];


	if ( !file_exists($skin_folder."/".$ex_template) )
	{
		echo $skin_folder."/".$ex_template." 파일이 존재하지 않습니다.";
		return;
	}

	$SearchQ = array();

	if ( $ex_type != "자동" )
	{
		if ( $ex_type == "사용가능" )
		{
			array_push($SearchQ," ( use_date = '0000-00-00 00:00:00' AND end_date >= curdate() ) ");
		}
		else if ( $ex_type == "사용불가" )
		{
			array_push($SearchQ," ( use_date != '0000-00-00 00:00:00' OR end_date <= curdate() ) ");
		}
	}
	else if ( $ex_type == "자동" )
	{
		if ( $_GET['is_use'] == "0" )
		{
			//사용불가
			array_push($SearchQ," ( use_date != '0000-00-00 00:00:00' OR end_date <= curdate() ) ");
			$plus .= "&is_use=".$_GET['is_use'];
		}
		else if ( $_GET['is_use'] == "1" )
		{
			//사용가능
			array_push($SearchQ," ( use_date = '0000-00-00 00:00:00' AND end_date >= curdate() ) ");
			$plus .= "&is_use=".$_GET['is_use'];
		}
	}

	//패키지권 제목검색
	if ( $_GET['pack_title'] != "" )
	{
		array_push($SearchQ," title like '%".$_GET['pack_title']."%' ");
		$plus .= "&pack_title=".urlencode($_GET['pack_title']);
	}

	//패키지권 종류검색
	if ( $_GET['option_name'] != "" )
	{
		array_push($SearchQ," option_name = '".$_GET['option_name']."' ");
		$plus .= "&option_name=".urlencode($_GET['option_name']);
	}

	//정렬순서
	$order_query = "";
	switch($ex_order)
	{
		case "등록순" :
			$order_query = " order by reg_date asc ";
			break;
		case "등록역순" :
			$order_query = " order by reg_date desc ";
			break;
		case "마감일순" :
			$order_query = " order by end_date asc ";
			break;
		case "마감일역순" :
			$order_query = " order by end_date desc ";
			break;
		default :
			break;
	}
	//echo $order_query;


	//print_r($SearchQ);
	if ( count($SearchQ) > 0 )
	{
		$search_query = " AND ".implode(" AND ", (array) $SearchQ);
	}

	$sql = "select count(*) from $job_package where id = '$mem_id' ".$search_query;
	$result = query($sql);
	//echo $sql;
	list($numb) = happy_mysql_fetch_array($result);


	if ($start == "")
	{
		$start = $_GET[start];
	}
	if($start==0 || $start=="")
	{
		$start=0;
	}

	$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = $start;
	$co = $numb - $start;


	############ 페이징처리 ############
	$Total			= $numb;
	$scale			= $ex_limit;
	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 2 : 6;

	$searchMethod	.= $plus;
	$searchMethod	.= "&mode=".$_GET['mode'];
	$searchMethod	.= "&pay_type=".$_GET['pay_type'];

	$page_print		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	############ 페이징처리 ############


	$limit_sql = " LIMIT ".$view_rows.",".$ex_limit;


	$sql = "select * from $job_package ";
	$sql.= "where id = '$mem_id' ".$search_query." ";
	$sql.= $order_query." ";
	$sql.= $limit_sql;
	//echo $sql;

	$result = query($sql);

	//echo $skin_folder."/".$ex_template;
	$TPL->define("패키지리스트",$skin_folder."/".$ex_template);
	$i = 1;
	$auto_number = $numb-$view_rows;
	$now_date = date("Y-m-d");


	while($Package = happy_mysql_fetch_assoc($result))
	{
		//print_r($Package);
		$use_link1 = "";
		$use_link2 = "";

		$Package['seq'] = $auto_number;
		$k = array_search($Package['option_name'],$option_array_name);
		$Package['uryo_name'] = $option_array[$k];
		$Package['type_icon'] = "<img src=$option_array_icon[$k] align=absmiddle border=0>";

		$opt_key = $Package['option_name'];
		$opt_name = $opt_key."_option";
		//echo $CONF[$opt_name]."<br>";
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


		//$Package['danwi'] = ($Package['option_name'] == "reg_end_date")?"회":"일";

		list($Package['reg_date_Ymd'],$Package['reg_date_His']) = explode(" ",$Package['reg_date']);

		//패키지권 현재상태
		$Package['stats_icon'] = "";
		//echo $Package['use_date']."___".$Package['end_date']."___".$now_date."<br>";

		if ( ($Package['use_date'] == "0000-00-00 00:00:00" && $Package['end_date'] >= $now_date) )
		{
			//사용가능
			//사용하기 페이지
			//회원관련 옵션이면 바로 늘려주자
			if ( in_array($Package['option_name'],$member_options) )
			{
				$tmp_str = "패키지권 사용을 하시면 ".$Package['uryo_name']."을 ".$Package['option_day']." ".$Package['danwi']." 만큼 연장되게 됩니다.";
				$tmp_url = base64_encode($_SERVER['REQUEST_URI']);
				$use_link1 = '<a href="javascript:void(0);" onclick="use_package_member(\''.$Package['number'].'\',\''.$tmp_str.'\',\''.$tmp_url.'\');">';
				$use_link2 = '</a>';
			}
			else
			{
				$use_link1 =<<<END
				<a href="#" onClick="window.open('my_package_use.php?search_type=package_use&pack_number=$Package[number]&pay_type=$pay_type','bada','width=1160px,height=760px,scrollbars=yes')" style='cursor:pointer;'>
END;
				$use_link2 = '</a>';
			}

			$Package['stats_icon'] = $use_link1.'<img src="img/package_icon_1.gif" align="absmiddle" border="0" alt="사용가능">'.$use_link2;
		}
		else
		{
			list($Package['use_date_Ymd'],$Package['use_date_His']) = explode(" ",$Package['use_date']);

			if ( $Package['use_date_Ymd'] == "0000-00-00" )
			{
				//$Package['stats_icon'] = '<img src="img/package_icon_0.gif" align="absmiddle" border="0" alt="사용불가능">';
				$Package['stats_icon'] = '<span style="display:inline-block; padding:0 8px; height:22px; line-height:22px; text-align:center; border:1px solid #ddd; color:#999; border-radius:3px;">사용불가능</span>';
			}
			else
			{
				$Package['stats_icon'] = $Package['use_date_Ymd'];
			}
		}


		$one_row = &$TPL->fetch();
		$rows .= table_adjust($one_row,$ex_width,$i);
		$i++;
		$auto_number--;
	}

	if ( $_GET['mode'] != "" )
	{
		$plus .= "&mode=".$_GET['mode'];
	}

	if ( $pay_type != "" )
	{
		$plus .= "&pay_type=".$pay_type;
	}



	if ( $numb == 0 )
	{
		$page_print = "";
		$패키지페이징 = $page_print;
		echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td align='center' style='padding-top:10px; color:#909090;'><div style='background:rgba(0,0,0,0.4); border-radius:5px; text-align:center;'><p class='font_16 noto400' style='color:#fff; padding:15px;'>패키지권이 없습니다.</p></div></td></tr></table>";
	}
	else
	{
		//include ("./page.php");
		$패키지페이징 = $page_print;
		echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'>$rows</table>";
	}
}








$TPL->define("출력", "$skin_folder/$Template_Default");
$TPL->tprint();
$exec_time = array_sum(explode(' ', microtime())) - $t_start;
$exec_time = round ($exec_time, 2);
$쿼리시간 =  "Query Time : $exec_time sec";
if ($print_query_time)
{
	print "<center><font color=gray style='font-size:11px' face=arial>$쿼리시간</font>";
}
?>