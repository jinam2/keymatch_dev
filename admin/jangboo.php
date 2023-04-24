<?php
include ("../inc/config.php");
include ("../inc/Template.php");
$TPL = new Template;

include ("../inc/function.php");
include ("../inc/lib.php");


//$_GET
//$_POST
//$_COOKIE

if ( !admin_secure("결제관리") ) {
	error("접속권한이 없습니다.");
	exit;
}

################################################
//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
include ("tpl_inc/top_new.php");
################################################

#검색
$stypen = array("아이디","결제번호");
$stypev = array("or_id","or_no");
$Scnt = count($stypev);
$select_search = make_selectbox2($stypen,$stypev,"-선택-","stype",$_GET['stype']);

$ptypen = array("카드결제","실시간계좌이체","핸드폰결제","무통장입금","포인트결제");
$ptypev = array("카드결제","실시간계좌이체","핸드폰결제","무통장입금","포인트결제");
$select_ptype = make_selectbox2($ptypen,$ptypev,"-선택-","ptype",$_GET['ptype']);

if ( isset($_GET['stype']) || isset($_GET['sword']))
{
	$search_query .= " where ";
	if ( $_GET['stype'] == '' )
	{
		$search_query .= " ( ";
		for( $i=0;$i<$Scnt;$i++ )
		{
			$search_query .= $or." ".$stypev[$i]." like '".$_GET['sword']."%' ";
			$or = " OR ";
		}
		$search_query .= " ) ";
		$plus .= "&sword=".$_GET['sword'];
	}
	else
	{
		$search_query .= $_GET['stype']." like '".$_GET['sword']."%'";
		$plus .= "&stype=".$_GET['stype'];
		$plus .= "&sword=".$_GET['sword'];
	}
}

if ( isset($_GET['ptype'] ) )
{
	if ( $_GET['ptype'] )
	{
		$search_query .= " AND or_method = '".$_GET['ptype']."' ";
		$plus .= "&ptype=".$_GET['ptype'];
	}
}
#검색


if ($action == "") {
	main();
}
elseif ($action == "jangboo_mod") {
	jangboo_mod($number);
}
elseif ($action == "jangboo_mod_reg") {
	jangboo_mod_reg($number);
}
elseif ($action == "jangboo_del") {
	jangboo_del($number);
}
else {
	main();
}

include ("tpl_inc/bottom.php");

###############################################################################




function main() {

	global $ARRAY,$CONF,$guin_tb,$ARRAY_NAME2,$option_array,$id,$pg,$jangboo;
	global $TPL,$MONEY,$goods_name,$info_maemool;
	global $select_search,$search_query,$plus,$select_ptype;

	global $job_money_package,$job_package,$job_jangboo_package,$option_array_icon,$now_location_subtitle;
	global $pg_response_display,$pg_response_msg;


	$id = $_GET['id'];

	if ($id)
	{
		$id_query = "where or_id = '".$id."'";
		$ex_limit = "500";
		$id_comment = " (<font color=blue>".$id."</font> 님 구매내역확인)";
	}
	else
	{
		$ex_limit = "20";
	}

	$sql21 = "select count(*) from ".$jangboo." ".$id_query.$search_query."";
	$result21 = query($sql21);
	list($numb) = happy_mysql_fetch_array($result21);

	if ($numb == "0")
	{
		//gomsg("$id 구매내역이 없습니다   ","jangboo.php");
		error("$id 구매내역이 없습니다   ");
		exit;
	}


	if($pg==0 || $pg==""){$pg=1;}
	//페이지 나누기
	$total_page = ( $numb - 1 ) / $ex_limit+1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = ($pg - 1) * $ex_limit;
	$co  =  $numb  -  $ex_limit  *  ( $pg - 1 );

	$sql = "select * from ".$jangboo." ".$id_query.$search_query."  order by number desc limit ".$view_rows.",".$ex_limit." ";
	//echo $sql;

	$result = query($sql);

	$i = "1";
	$main_new_out = "";
	$main_new_head = "<table width=100% border=0 cellpadding=0 cellspacing=0>";

	$TPL->define("기업장부한줄", "./html/rows_jangboo.html");

	while  ($MONEY = happy_mysql_fetch_array($result))
	{
		$info_maemool = "";

		#입금인지 아닌지 정리
		if ($MONEY['in_check'] == "0")
		{
			$MONEY['in_check'] = "<img src=../img/btn_20_no.gif border=0 align=absmiddle>";
		}
		else
		{
			$MONEY['in_check'] = " <img src=../img/btn_20_ok.gif border=0 align=absmiddle>";
		}

		#결제금액에숫자를
		$MONEY['goods_price'] = number_format($MONEY['goods_price']);
		#구매내역의 정리를하자		$spec_pay,$pick_pay,$pop_pay,$speed_pay

		$PAY = split(",",$MONEY['goods_name']);
		$i = "0";
		$goods_name = "<table cellspacing='0' cellpadding='0' style='width:100%;'>";

		foreach ($PAY as $list)
		{
			list($tmp_day,$tmp_price) = split(":",$list);

			if ($tmp_day)
			{
				$tmp_price_comma = number_format($tmp_price);
				$type_icon = " <img src=../".$ARRAY_NAME2[$i]." align=absmiddle border=0>";
				#일이냐 회냐?
				$tmp_option = $ARRAY[$i] . "_option";

				if ($CONF[$tmp_option] == '기간별')
				{
					$print_end = "일";
				}
				else
				{
					$print_end = "회";
				}

				$goods_name .= "
				<tr>
					<td width=50 style='padding-bottom:3px;'> ".$type_icon." </td>
					<td style='text-align:left;'> ".$tmp_day.$print_end."(".$CONF[$tmp_option].") </td>
					<td style='text-align:right;'>".$tmp_price_comma."원</td>
				</tr>";
			}
			$i ++;
		}


		//패키지(즉시적용) 구매시 문구표시 - ranksa
		if($MONEY['pack2_title'] != "")
		{
			$goods_name	.= "<tr>
				<td colspan='3'>
					<table cellspacing='0' cellpadding='0' style='width:100%;'>
					<tr>
						<td width=50 ><img src='../img/title_pack1.gif'></td>
						<td style='padding-left:3px;'>$MONEY[pack2_title]</td>
					</tr>
					</table>
				</td>
			</tr>";
		}
		//패키지(즉시적용) 구매시 문구표시 - ranksa END


		$goods_name .= "</tr></table>";

		#구매내역 정리끝
		//패키지권 구매
		$tmp_str = "";
		if ( $MONEY['member_type'] == "100" )
		{
			$option_array_icon = $ARRAY_NAME2;

			$goods_name = "<table width='100%' align=left border=0>";
			$tmp_str = explode(",",$MONEY['goods_name']);
			$info_maemool = array();
			foreach($tmp_str as $p)
			{
				$sql3 = "select * from $job_money_package where number = '$p'  ";
				$result3 = query($sql3);
				$BD = happy_mysql_fetch_array($result3);

				$table_id = "pack_".$MONEY['or_no']."_".$BD['number'];
				//echo $table_id."<br>";

				$goods_name.= "<tr><td><a href='javascript:void(0);' onclick=\"view_t('".$table_id."');\" style='color:#333'>[".$BD['title']."] 옵션상세정보</a></td></tr>";
				$goods_name.= "<tr id='".$table_id."' style='display:none;'><td><table width='100%' align=left border=0>";

				$sql3 = "select * from $job_jangboo_package where package_number = '".$p."' and or_no = '".$MONEY['or_no']."'";
				$result3 = query($sql3);
				$Package = happy_mysql_fetch_assoc($result3);

				$tmp_a = explode(",",$Package['uryo_detail']);
				if ( is_array($tmp_a) )
				{
					$i = 0;
					foreach($tmp_a as $v)
					{
						list($t1,$t2,$t3) = explode(":",$v);
						if ( $t2 > 0 )
						{
							//if ($i == 9){
							//	$tmp_text = '회 ';
							//}
							//else {
							//	$tmp_text = '일';
							//}

							//채용정보 + 기업회원의 유료옵션은 회수별,노출별,기간별,이력서수,횟수별 이 있다.
							$opt_name = $t1."_option";
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

							$type_icon2 = "<tr><td><img src=../$option_array_icon[$i] align=absmiddle border=0> ".$t2." ".$Uryo['uryo_danwi']." X ".$t3." 회 이용권</td></tr>";
							$goods_name.= $type_icon2;
						}
						$i++;
						//채용정보의 아이콘옵션은 패키지에서 제외
						if ( $i == 11 ) { $i++; }

					}
				}

				$goods_name.= "</td></tr></table>";

				//패키지유료옵션 사용내역
				$info_maemool[] = "<a href='money_setup_package.php?mode=modify&number=".$BD['number']."' style='color:#6666CC;text-decoration:underline'>[".$Package['title']."] 패키지 변경</a>";
			}

			$info_maemool = implode("<br>&nbsp;&nbsp;", (array) $info_maemool);

			$goods_name .= "</table>";
		}
		//패키지권 구매
		else if ($MONEY['member_type'])
		{
			$info_maemool = "<a href=happy_member.php?type=add&number=$MONEY[links_number] style='color:#6666CC;text-decoration:underline'>회원정보보기</a>";
		}
		else
		{
			#구인정보읽기
			$sql3 = "select * from $guin_tb where number = '".$MONEY['links_number']."'  ";
			$result3 = query($sql3);
			$BD = happy_mysql_fetch_array($result3);
			$info_maemool = "<a href=../guin_detail.php?num=".$MONEY['links_number']." style='color:#6666CC;text-decoration:underline'>채용정보보기</a> &nbsp;";
		}


		//결제실패사유 출력 - ranksa
		$pg_response_display	= "display:none";
		$pg_response_msg		= "";
		//승인코드 pg_db_update.php 참고
		if(
			$MONEY['pg_response_code'] != "" &&
			$MONEY['pg_response_code'] != "0000" &&
			$MONEY['pg_response_code'] != "00" &&
			!preg_match("/y|ok/",$MONEY['pg_response_code'])
		)
		{
			$pg_response_msg	= "<font color='red'>".$MONEY['pg_response_msg']."</font>";
			$pg_response_display= "";
		}

		$main_new = &$TPL->fetch("기업장부한줄");

		$main_new_out .= $main_new;
		$i++;
	}

	include ("../page.php");

#리스트 출력
print <<<END
<script language="javascript">
<!--
	function bbsdel(strURL) {
		var msg = "삭제하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}

	function view_t(t_id)
	{
		if ( document.getElementById(t_id).style.display == "" )
		{
			document.getElementById(t_id).style.display = "none";
		}
		else
		{
			document.getElementById(t_id).style.display = "";
		}
	}
-->


</script>

<p class='main_title'>$now_location_subtitle</p>

<div id='list_style'>
	<table cellspacing='0' cellpadding='0' border='0' class='bg_style b_border'>
	<tr>
		<th style='width:40px;'>번호</th>
		<th>구매내역</th>
		<th style='width:120px;'>구매자</th>
		<th>결제금액</th>
		<th style='width:100px;'>상태보기</th>
		<th>입금상태</th>
		<th style='width:150px;'>결제시도일</th>
		<th style='width:50px;'>관리툴</th>
	</tr>
	$main_new_out
	</table>
</div>
<div align='center' style='padding:20px 0 10px 0;'>$page_print</div>



<!--검색폼 추가됨-->
<div class='input_text_st'>
	<form name="searchform" method="get" action="./jangboo.php" style="margin:0px;padding:0px;">
	<table cellpadding="0" cellspacing="0" style='margin:10px auto'>
		<tr>
			<td class='input_style_adm'>$select_ptype</td>
			<td style="padding:0 5px 0 5px;" class='input_style_adm'>$select_search</td>
			<td class='input_style_adm'><input type="text" name="sword" value="$_GET[sword]" style='vertical-align:middle; width:150px;'></td>
			<td style="padding-left:5px;"><input type='submit' value='검색' class='btn_small_dark' style='height:29px'></td>
		</tr>
	</table>

	</form>
</div>
<!--검색폼 추가됨-->
<br><br>

END;

}



function jangboo_mod() {

	global $real_gap;
	global $CONF;
	global $guin_tb;
	global $ARRAY_NAME;
	global $links_number;
	global $ARRAY_NAME2;
	global $ARRAY;
	global $id;
	global $pg;
	global $jangboo;
	global $number;
	global $happy_member,$happy_member_option_type;

	global $job_money_package,$job_package,$job_jangboo_package,$option_array_icon;


	$sql = "select * from $jangboo where number = '$number' ";
	$result = query($sql);
	$MONEY = happy_mysql_fetch_array($result);


	#입금인지 아닌지 정리
	if ($MONEY[in_check] == "0")
	{
		$MONEY[in_check_img] = "<img src=../img/in_check_0.gif border=0 align=absmiddle>";
		$in_check_0 = "checked";
	}
	else
	{
		$MONEY[in_check_img] = " <img src=../img/in_check_1.gif border=0 align=absmiddle>";
		$in_check_1 = "checked";
	}

	#구매내역의 정리를하자		$spec_pay,$pick_pay,$pop_pay,$speed_pay
	$PAY = split(",",$MONEY[goods_name]);


	//패키지 구매건
	if ( $MONEY['member_type'] == "100" )
	{
		//print_r($MONEY);

		//echo $MONEY['goods_name'];
		$option_array_icon = $ARRAY_NAME2;

		//$goods_name = "<table width='100%' align=left border=0>";
		$goods_name = "";
		$tmp_str = explode(",",$MONEY['goods_name']);
		$info_maemool = array();
		foreach($tmp_str as $p)
		{
			$sql3 = "select * from $job_money_package where number = '$p'  ";
			$result3 = query($sql3);
			$BD = happy_mysql_fetch_array($result3);

			$table_id = "pack_".$MONEY['or_no']."_".$BD['number'];
			//echo $table_id."<br>";

			$goods_name.= "<tr><td style='background:#606060; font-weight:bold; color:#fff'>[".$BD['title']."] 옵션상세정보</td></tr>";
			$goods_name.= "<tr><td><table border='0' cellpadding='0' cellspacing='1' class='bg_style'>";

			$sql3 = "select * from $job_jangboo_package where package_number = '".$p."' and or_no = '".$MONEY['or_no']."'";
			$result3 = query($sql3);
			$Package = happy_mysql_fetch_assoc($result3);

			$tmp_a = explode(",",$Package['uryo_detail']);
			if ( is_array($tmp_a) )
			{
				$i = 0;
				foreach($tmp_a as $v)
				{
					list($t1,$t2,$t3) = explode(":",$v);
					if ( $t2 > 0 )
					{
						//if ($i == 9)
						//{
						//	$tmp_text = '회 ';
						//}
						//else
						//{
						//	$tmp_text = '일';
						//}

						//채용정보 + 기업회원의 유료옵션은 회수별,노출별,기간별,이력서수,횟수별 이 있다.
						$opt_name = $t1."_option";
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


						$form_n1 = "pay_".$Package['number']."[".$t1."][day]";
						$form_n2 = "pay_".$Package['number']."[".$t1."][cnt]";
						$t2 = '<input type="text" style="width:25px;text-align:right; padding-right:5px" name="'.$form_n1.'" id="'.$form_n1.'" value="'.$t2.'">';
						$t3 = '<input type="text" style="width:25px;text-align:right; padding-right:5px" name="'.$form_n2.'" id="'.$form_n2.'" value="'.$t3.'">';


						$type_icon2 = "<tr><th style='width:150px;'><img src=../$option_array_icon[$i] align=absmiddle border=0></th><td>".$t2." ".$Uryo['uryo_danwi']." X ".$t3." 회 이용권</td></tr>";
						$goods_name.= $type_icon2;
					}
					$i++;
					//채용정보의 아이콘옵션은 패키지에서 제외
					if ( $i == 11 ) { $i++; }

				}
			}

			$goods_name.= "</td></tr></table>";

			//패키지유료옵션 사용내역
			$info_maemool[] = "<a href='money_setup_package.php?mode=modify&number=".$BD['number']."' style='color:#6666CC;text-decoration:underline'>[".$Package['title']."] 패키지 변경</a>";
		}

		$info_maemool = implode("<br>&nbsp;&nbsp;", (array) $info_maemool);
		//$goods_name .= "</table>";

		$r_content = $goods_name;


	}
	//패키지 구매건
	else if ($MONEY[member_type])
	{
		#이력서 보기관련 결제 타입
		#$links_number 는 회원테이블 고유번호
		#guin_docview, guin_docview2, guin_smspoint
		$sql = "select * from $happy_member where number = '$links_number'";
		$result = query($sql);
		$Buyer = happy_mysql_fetch_assoc($result);

		$BD['guin_docview'] = happy_member_option_get($happy_member_option_type,$Buyer['user_id'],'guin_docview');
		$BD['guin_docview2'] = happy_member_option_get($happy_member_option_type,$Buyer['user_id'],'guin_docview2');
		$BD['guin_smspoint'] = happy_member_option_get($happy_member_option_type,$Buyer['user_id'],'guin_smspoint');


		#배열값으로 비교하기전에 기존 장부의 내역을 읽어서 비교해주자
		$PAY = split(",",$MONEY[goods_name]);

		for($i =7;$i<=9;$i++)
		{
			#변수 초기화
			$now_end_date = "";
			$tmp_day = "";
			$tmp_price = "";

			$tmp_option = $ARRAY[$i] . "_option";
			list($tmp_day,$tmp_price) = split(":",$PAY[$i]);

			if ($tmp_day)
			{
				$sql22 = "select DATE_ADD(  curdate(),  INTERVAL '$tmp_day' DAY  ) ";
				$result22 = query($sql22);

				if ($CONF[$tmp_option] == '기간별')
				{
					$print_end = "일";

					if ($MONEY["in_check"] == "1" )
					{
						#입금완료
						$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
						if ($now_end_date < 0) $now_end_date = 0;
					}
					else
					{
						#입금요망
						$now_end_date = $BD{$ARRAY[$i]}  - $real_gap;
						if ($now_end_date < 0) $now_end_date = 0;
						$now_end_date = $now_end_date + $tmp_day;
					}

				}
				else
				{
					$print_end = "회";

					if ($MONEY["in_check"] == "1" )
					{
						#입금완료
						$now_end_date = $BD{$ARRAY[$i]};
					}
					else
					{
						#입금요망
						$now_end_date = $BD{$ARRAY[$i]} + $tmp_day;
					}
				}
				list($next_date) = mysql_fetch_row($result22);

				$msg = "<font color=blue>$tmp_day $print_end 결제시도</font>";
			}
			else
			{
				#관리자가 입금처리시 기간별 옵션+sms회수가 사라지는 버그 처리 루틴
				#2009-04-28 kad
				if ( $ARRAY[$i] == 'guin_docview' )
				{
					#기간별이기때문에 real_gap 로 빼줘야 함
					$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
				}
				else
				{
					$now_end_date = $BD{$ARRAY[$i]};
				}

				#관리자가 입금처리시 기간별 옵션+sms회수가 사라지는 버그 처리 루틴
				$msg = "결제시도없었음";
			}

			$r_content .= "
			<tr>
				<th style='width:150px;'>
					<strong>$ARRAY_NAME[$i]</strong>
				</th>
				<td><input name=\"$ARRAY[$i]\" type=\"text\" class=\"textarea\" size=\"12\" maxlength=\"12\" value='".$now_end_date."' ></td>
				<td> $msg</td>
			</tr>
			";
		}


		//채용정보 점프
		global $HAPPY_CONFIG;
		if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
		{
			$BD['guin_jump'] = happy_member_option_get($happy_member_option_type,$Buyer['user_id'],'guin_jump');

			$i = array_search("guin_jump",$ARRAY);

			#변수 초기화
			$now_end_date = "";
			$tmp_day = "";
			$tmp_price = "";

			$tmp_option = $ARRAY[$i] . "_option";
			list($tmp_day,$tmp_price) = split(":",$PAY[$i]);

			if ($tmp_day)
			{
				$sql22 = "select DATE_ADD(  curdate(),  INTERVAL '$tmp_day' DAY  ) ";
				$result22 = query($sql22);

				if ($CONF[$tmp_option] == '기간별')
				{
					$print_end = "일";

					if ($MONEY["in_check"] == "1" )
					{
						#입금완료
						$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
						if ($now_end_date < 0) $now_end_date = 0;
					}
					else
					{
						#입금요망
						$now_end_date = $BD{$ARRAY[$i]}  - $real_gap;
						if ($now_end_date < 0) $now_end_date = 0;
						$now_end_date = $now_end_date + $tmp_day;
					}

				}
				else
				{
					$print_end = "회";

					if ($MONEY["in_check"] == "1" )
					{
						#입금완료
						$now_end_date = $BD{$ARRAY[$i]};
					}
					else
					{
						#입금요망
						$now_end_date = $BD{$ARRAY[$i]} + $tmp_day;
					}
				}
				list($next_date) = mysql_fetch_row($result22);

				$msg = "<font color=blue>$tmp_day $print_end 결제시도</font>";
			}
			else
			{
				#관리자가 입금처리시 기간별 옵션+sms회수가 사라지는 버그 처리 루틴
				#2009-04-28 kad
				if ( $ARRAY[$i] == 'guin_docview' )
				{
					#기간별이기때문에 real_gap 로 빼줘야 함
					$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
				}
				else
				{
					$now_end_date = $BD{$ARRAY[$i]};
				}

				#관리자가 입금처리시 기간별 옵션+sms회수가 사라지는 버그 처리 루틴
				$msg = "결제시도없었음";
			}

			$r_content .= "
			<tr>
				<th style='width:150px;'>
					<strong>$ARRAY_NAME[$i]</strong>
				</th>
				<td><input name=\"$ARRAY[$i]\" type=\"text\" class=\"textarea\" size=\"12\" maxlength=\"12\" value='".$now_end_date."' ></td>
				<td> $msg</td>
			</tr>
			";



		}
		//채용정보 점프
	}
	else
	{
		#채용정보 관련 결제
		for($i =0;$i<=6;$i++)
		{
			$query_name .= "$ARRAY[$i],";
		}

		#추가옵션 5개
		for($i = 10; $i<=16;$i++ )
		{
			$query_name .= "$ARRAY[$i],";
		}

		#배경색+아이콘 추가됨
		$query_name .= " guin_bgcolor_com, ";
		$query_name .= " freeicon_com, ";
		$query_name .= " freeicon_comDate ";


		$query_name = ereg_replace(",$", "", $query_name);
		$sql = "select $query_name from $guin_tb where number='$links_number'";
		//echo $sql;
		$result = query($sql);
		$BD = happy_mysql_fetch_array($result);

		//print_r2($BD);
		//print_r2($ARRAY);

		for($i =0;$i<=6;$i++)
		{
			#변수 초기화
			$now_end_date = "";
			$tmp_day = "";
			$tmp_price = "";

			$tmp_option = $ARRAY[$i] . "_option";
			list($tmp_day,$tmp_price) = split(":",$PAY[$i]);

			if ($tmp_day)
			{
				if ($CONF[$tmp_option] == '기간별')
				{
					$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
					$msg = "일 남음";
					$msg3	= '일';

					if ($MONEY["in_check"] == "1" )
					{
						#입금완료
						$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
						if ($now_end_date < 0) $now_end_date = 0;
					}
					else
					{
						#입금요망
						$now_end_date = $BD{$ARRAY[$i]}  - $real_gap;
						if ($now_end_date < 0) $now_end_date = 0;
						$now_end_date = $now_end_date + $tmp_day;
					}
				}
				else {
					$now_end_date = $BD{$ARRAY[$i]};
					$msg = "회 남음";
					$msg3	= '회';

					if ($MONEY["in_check"] == "1" )
					{
						#입금완료
						$now_end_date = $BD{$ARRAY[$i]};
					}
					else
					{
						#입금요망
						$now_end_date = $BD{$ARRAY[$i]} + $tmp_day;
					}
				}

				$msg2 = " <font color=blue>(결제시도 함 : $tmp_day $msg3 결제 $tmp_price 원) </font>";
			}
			else
			{

				if ($CONF[$tmp_option] == '기간별')
				{
					$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
					$msg = "일 남음";
				}
				else
				{
					$now_end_date = $BD{$ARRAY[$i]};
					$msg = "회 남음";
				}
				$msg2 = " <font color=gray>(결제시도 하지 않음)";
			}

			#0보다 작을때는 0으로 만들어주고
			if ($now_end_date <= 0)
			{
				$now_end_date = 0;
			}

			if (!$tmp_day) $tmp_day = '0';
			#0보다 작을때는 0으로 만들어주고

			$r_content .= "
				<tr>
					<th style='width:150px;'>
						<strong>$ARRAY_NAME[$i] $CONF[$tmp_option] &nbsp;</strong>
					</th>
					<td><input name=\"$ARRAY[$i]\" type=\"text\"  size=\"5\" maxlength=\"5\" value='$now_end_date' ></td>
					<td>$msg $msg2 </td>
				</tr>
			";
		}

		#print_r($PAY);









		for($i =10;$i<=16;$i++)
		{
			#변수 초기화
			$now_end_date = "";
			$tmp_day = "";
			$tmp_price = "";

			$tmp_option = $ARRAY[$i] . "_option";
			#기업회원 아이콘
			#echo $tmp_option;

			list($tmp_day,$tmp_price) = split(":",$PAY[$i]);

			if ($tmp_day)
			{
				if ($CONF[$tmp_option] == '기간별')
				{
					$now_end_date = $BD{$ARRAY[$i]} - $real_gap;

					$msg = "일 남음";
					$msg3	= '일';

					if ($MONEY["in_check"] == "1" )
					{
						#입금완료
						$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
						if ($now_end_date < 0) $now_end_date = 0;
					}
					else
					{
						#입금요망
						$now_end_date = $BD{$ARRAY[$i]}  - $real_gap;
						if ($now_end_date < 0) $now_end_date = 0;
						$now_end_date = $now_end_date + $tmp_day;
					}
				}
				else
				{
					$now_end_date = $BD{$ARRAY[$i]};
					$msg = "회 남음";
					$msg3	= '회';

					if ($MONEY["in_check"] == "1" )
					{
						#입금완료
						$now_end_date = $BD{$ARRAY[$i]};
					}
					else
					{
						#입금요망
						$now_end_date = $BD{$ARRAY[$i]} + $tmp_day;
					}
				}

				$msg2 = " <font color=blue>(결제시도 함 : $tmp_day $msg3 결제 $tmp_price 원) </font>";
			}
			else
			{
				if ($CONF[$tmp_option] == '기간별')
				{
					$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
					$msg = "일 남음";
				}
				else
				{
					$now_end_date = $BD{$ARRAY[$i]};
					$msg = "회 남음";
				}
				$msg2 = " <font color=gray>(결제시도 하지 않음)";
			}

			#0보다 작을때는 0으로 만들어주고
			if ($now_end_date <= 0)
			{
				$now_end_date = 0;
			}

			if (!$tmp_day) $tmp_day = '0';
			#0보다 작을때는 0으로 만들어주고

			$r_content .= "
				<tr>
					<th style='width:150px;'>
						<strong>$ARRAY_NAME[$i] $CONF[$tmp_option] &nbsp;</strong>
					</th>
					<td><input name=\"$ARRAY[$i]\" type=\"text\"  size=\"5\" maxlength=\"5\" value='$now_end_date' ></td>
					<td>$msg $msg2 </td>
				</tr>
			";
		}




		#패키지(즉시적용) 때문에 추가됨 - ranksa
		if($MONEY['pack2_title'])
		{
			$BD['guin_docview'] = happy_member_option_get($happy_member_option_type,$MONEY['or_id'],'guin_docview');
			$BD['guin_docview2'] = happy_member_option_get($happy_member_option_type,$MONEY['or_id'],'guin_docview2');
			$BD['guin_smspoint'] = happy_member_option_get($happy_member_option_type,$MONEY['or_id'],'guin_smspoint');


			#배열값으로 비교하기전에 기존 장부의 내역을 읽어서 비교해주자
			$PAY = split(",",$MONEY[goods_name]);

			for($i =7;$i<=9;$i++)
			{
				#변수 초기화
				$now_end_date = "";
				$tmp_day = "";
				$tmp_price = "";

				$tmp_option = $ARRAY[$i] . "_option";
				list($tmp_day,$tmp_price) = split(":",$PAY[$i]);

				if ($tmp_day)
				{
					$sql22 = "select DATE_ADD(  curdate(),  INTERVAL '$tmp_day' DAY  ) ";
					$result22 = query($sql22);

					if ($CONF[$tmp_option] == '기간별')
					{
						$print_end = "일";

						if ($MONEY["in_check"] == "1" )
						{
							#입금완료
							$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
							if ($now_end_date < 0) $now_end_date = 0;
						}
						else
						{
							#입금요망
							$now_end_date = $BD{$ARRAY[$i]}  - $real_gap;
							if ($now_end_date < 0) $now_end_date = 0;
							$now_end_date = $now_end_date + $tmp_day;
						}

					}
					else
					{
						$print_end = "회";

						if ($MONEY["in_check"] == "1" )
						{
							#입금완료
							$now_end_date = $BD{$ARRAY[$i]};
						}
						else
						{
							#입금요망
							$now_end_date = $BD{$ARRAY[$i]} + $tmp_day;
						}
					}
					list($next_date) = mysql_fetch_row($result22);

					$msg = "<font color=blue>$tmp_day $print_end 결제시도</font>";
				}
				else
				{
					#관리자가 입금처리시 기간별 옵션+sms회수가 사라지는 버그 처리 루틴
					#2009-04-28 kad
					if ( $ARRAY[$i] == 'guin_docview' )
					{
						#기간별이기때문에 real_gap 로 빼줘야 함
						$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
					}
					else
					{
						$now_end_date = $BD{$ARRAY[$i]};
					}

					#관리자가 입금처리시 기간별 옵션+sms회수가 사라지는 버그 처리 루틴
					$msg = "결제시도없었음";
				}

				$r_content .= "
				<tr>
					<td width=120  class='font_st_12' align=right style='padding-right:5px;'>$ARRAY_NAME[$i]</td>
					<td><input name=\"$ARRAY[$i]\" type=\"text\" class=\"textarea\" size=\"12\" maxlength=\"12\" value='".$now_end_date."' ></td>
					<td> $msg</td>
				</tr>
				";
			}


			//채용정보 점프
			global $HAPPY_CONFIG;
			if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
			{
				$BD['guin_jump'] = happy_member_option_get($happy_member_option_type,$MONEY['or_id'],'guin_jump');

				$i = array_search("guin_jump",$ARRAY);

				#변수 초기화
				$now_end_date = "";
				$tmp_day = "";
				$tmp_price = "";

				$tmp_option = $ARRAY[$i] . "_option";
				list($tmp_day,$tmp_price) = split(":",$PAY[$i]);

				if ($tmp_day)
				{
					$sql22 = "select DATE_ADD(  curdate(),  INTERVAL '$tmp_day' DAY  ) ";
					$result22 = query($sql22);

					if ($CONF[$tmp_option] == '기간별')
					{
						$print_end = "일";

						if ($MONEY["in_check"] == "1" )
						{
							#입금완료
							$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
							if ($now_end_date < 0) $now_end_date = 0;
						}
						else
						{
							#입금요망
							$now_end_date = $BD{$ARRAY[$i]}  - $real_gap;
							if ($now_end_date < 0) $now_end_date = 0;
							$now_end_date = $now_end_date + $tmp_day;
						}

					}
					else
					{
						$print_end = "회";

						if ($MONEY["in_check"] == "1" )
						{
							#입금완료
							$now_end_date = $BD{$ARRAY[$i]};
						}
						else
						{
							#입금요망
							$now_end_date = $BD{$ARRAY[$i]} + $tmp_day;
						}
					}
					list($next_date) = mysql_fetch_row($result22);

					$msg = "<font color=blue>$tmp_day $print_end 결제시도</font>";
				}
				else
				{
					#관리자가 입금처리시 기간별 옵션+sms회수가 사라지는 버그 처리 루틴
					#2009-04-28 kad
					if ( $ARRAY[$i] == 'guin_docview' )
					{
						#기간별이기때문에 real_gap 로 빼줘야 함
						$now_end_date = $BD{$ARRAY[$i]} - $real_gap;
					}
					else
					{
						$now_end_date = $BD{$ARRAY[$i]};
					}

					#관리자가 입금처리시 기간별 옵션+sms회수가 사라지는 버그 처리 루틴
					$msg = "결제시도없었음";
				}

				$r_content .= "
				<tr>
					<td width=120  class='font_st_12' align='right' style='padding-right:5px;'>$ARRAY_NAME[$i]</td>
					<td><input name=\"$ARRAY[$i]\" type=\"text\" class=\"textarea\" size=\"12\" maxlength=\"12\" value='".$now_end_date."' ></td>
					<td> $msg</td>
				</tr>
				";



			}
		}
		#패키지(즉시적용) 때문에 추가됨 - ranksa END



	}

	$wait_temp = "<table border='0' cellpadding='0' cellspacing='1' class='bg_style'>$r_content</table>";

	#구매내역 정리끝

	#구매내역 정리끝
	$package_pay_hide_tag = "";
	if ($MONEY[member_type] == "100" )
	{
		$package_pay_hide_tag = ' style="display:none;" ';
		$info_maemool = "";
	}
	else if ($MONEY[member_type])
	{
		$pay_title_info = "적용될 회원정보";
		$info_maemool = "<a href=happy_member.php?type=add&number=$MONEY[links_number] style='color:#6666CC;text-decoration:underline'>회원정보보기</a>";
	}
	else
	{
		$pay_title_info = "적용될 채용정보";
		$info_maemool = "<a href=../guin_detail.php?num=$MONEY[links_number] style='color:#6666CC;text-decoration:underline'>채용정보보기</a> &nbsp;";
	}

	print <<<END

<p class='main_title'>$now_location_subtitle 상세보기</p>

<form action=jangboo.php?action=jangboo_mod_reg method=post name=fForm style='margin:0;'>
<input type=hidden name=member_type value=$MONEY[member_type]>
<input type=hidden name=number value=$MONEY[number]>
<input type=hidden name=pg value=$pg>
<input type=hidden name=links_number value=$MONEY[links_number]>
<input type=hidden name=or_id value=$MONEY[or_id]>
<input type=hidden name=pack2_title value="$MONEY[pack2_title]">

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
	<tr>
		<th>고유번호</th>
		<td>
			<p class='short'>결제장부상의 고유번호 입니다.</p>
			<b>$MONEY[number]</b>
		</td>
	</tr>
	<tr>
		<th>결제번호</th>
		<td>
			<p class='short'>PG사간의 고유번호 입니다.</p>
			<b>$MONEY[or_no]</b>
		</td>
	</tr>
	<tr>
		<th>구매옵션</th>
		<td>
			<p class='short'>PG사를 통한 결제는 실시간 적용되며, 무통장입금의 경우는 관리자가 확인후 입금상태로 변경을 하면 자동 적용 됩니다.</p>
			$wait_temp
		</td>
	</tr>
	<tr>
		<th>총 결제금액</th>
		<td>
			<p class='short'>구매한 옵션의 총합개 금액 입니다.</p>
			<input type=text name=goods_price value='$MONEY[goods_price]' size=10> 원
		</td>
	</tr>
	<tr>
		<th>결제방법</th>
		<td>
			<p class='short'>결제를 시도한 방법 입니다.</p>
			<input type=text name=or_method value='$MONEY[or_method]' size=10>
		</td>
	</tr>
	<tr>
		<th>관리자메모</th>
		<td>
			<p class='short'>해당 구매자가 결제내역에서 확인을 할 수 있는 내용 입니다.</p>
			<input type=text name=admin_message value='$MONEY[admin_message]' style='width:100%;'>
		</td>
	</tr>
	<tr $package_pay_hide_tag>
		<th>$pay_title_info</th>
		<td>
			<p class='short'>클릭하여 {$pay_title_info}를 확인할 수 있습니다.</p>
			$info_maemool
		</td>
	</tr>
	<tr>
		<th>입금여부</th>
		<td>
			<p class='short'>무통장입금일 경우 입금여부 선택으로 옵션을 바로 적용시킬수 있습니다.</p>
			<input type=hidden name=old_in_check value='$MONEY[in_check]'>
			<input type=radio name=in_check value='1' $in_check_1>입금 &nbsp;
			<input type=radio name=in_check value='0' $in_check_0>미입
		</td>
	</tr>
	<tr>
		<th>결제시도일</th>
		<td>
			<p class='short'>결제를 시도한 날짜와 시간 입니다.</p>
			$MONEY[jangboo_date]
		</td>
	</tr>
	</table>
</div>

<div align='center'><input type='submit' value='저장하기' class='btn_big'></div>
</form>
END;


}

function jangboo_mod_reg()
{
	global $real_gap,$CONF,$ARRAY,$demo,$guin_tb,$jangboo,$number,$pg;

	#SMS발송 추가
	global $HAPPY_CONFIG,$site_name,$site_phone,$sms_testing;

	#쪽지발송 추가
	global $message_tb,$admin_id;
	global $happy_member,$happy_member_option_type;


	global $job_money_package,$job_package,$job_jangboo_package,$option_array_icon;


	if ($demo == "1")
	{
		#데모이면 삭제안됨
		error("데모버젼은 작동하지 않습니다");
		exit;
	}

	#넘어온 원본 값 저장
	$_POST_ORG = $_POST;

	#개인회원
	for($i =0;$i<=6;$i++)
	{
		$tmp_option = $ARRAY[$i] . "_option";
		if ($CONF[$tmp_option] == '기간별')
		{
			$_POST{$ARRAY[$i]} = $_POST{$ARRAY[$i]} + $real_gap;
		}
		$query_name .= "$ARRAY[$i] = '".$_POST{$ARRAY[$i]}."',";
	}

	#배경,아이콘 + 추가옵션5개
	for($i =10;$i<=16;$i++)
	{
		$tmp_option = $ARRAY[$i] . "_option";
		if ($CONF[$tmp_option] == '기간별'){
			$_POST{$ARRAY[$i]} = $_POST{$ARRAY[$i]} + $real_gap;
		}
		$query_name .= "$ARRAY[$i] = '".$_POST{$ARRAY[$i]}."',";
	}

	$query_name = preg_replace ("/,$/", "", $query_name);


	#기업회원
	for($i =7;$i<=9;$i++)
	{
		$tmp_option = $ARRAY[$i] . "_option";
		if ($CONF[$tmp_option] == '기간별')
		{
			$_POST{$ARRAY[$i]} = $_POST{$ARRAY[$i]} + $real_gap;
		}
	}



	//패키지유료옵션
	if ( $_POST['member_type'] == "100" )
	{
		//print_r2($_POST);
		if ( is_array($_POST) )
		{
			$tmp_str = array();
			foreach($_POST as $k => $v)
			{
				if ( preg_match("/^pay_/",$k) )
				{
					$jangboo_package_number = preg_replace("/^pay_/","",$k);
					//echo $jangboo_package_number."<br>";

					//print_r($v);
					foreach($v as $k2 => $v2)
					{
						//옵션명:기간:회수
						$tmp_str[$jangboo_package_number][] = $k2.":".$v2['day'].":".$v2['cnt'];
					}
				}
			}
			//echo implode(",", (array) $tmp_str)."<Br>";
		}
		//print_r2($tmp_str);

		if ( is_array($tmp_str) )
		{
			foreach($tmp_str as $k => $v)
			{
				$sql = "select * from $job_jangboo_package where number = '".$k."'";
				//echo $sql."<br>";
				$result = query($sql);
				$row = happy_mysql_fetch_assoc($result);

				//echo $row['uryo_detail']."<br>";
				$tmp_w = explode(",",$row['uryo_detail']);

				//print_r($v);

				$uryo_detail = array();
				foreach($tmp_w as $o)
				{
					$wonbon = explode(":",$o);
					$is_change = "";
					foreach($v as $v2)
					{
						$modify = explode(":",$v2);

						if ( $wonbon[0] == $modify[0] )
						{
							$uryo_detail[] = $v2;
							$is_change = "1";
						}
					}

					if ( $is_change == "" )
					{
						$uryo_detail[] = $o;
					}
				}

				$uryo_detail_str = implode(",", (array) $uryo_detail);

				//echo $uryo_detail_str."<br>";
				//echo "<hr>";

				//패키지 유료옵션 내용 변경
				$sql = "update $job_jangboo_package set ";
				$sql.= "uryo_detail = '".$uryo_detail_str."' ";
				$sql.= "where number = '".$k."'";
				query($sql);
				//echo $sql."<br><Br>";
			}
		}


		if ( $_POST['old_in_check'] == 0 && $_POST['in_check'] == 1 )
		{
			//echo "미입 -> 입금으로 변경했다.<br>";

			#장부에 해당저장정보를 읽어오자
			$sql = "select * from $jangboo where number = '$number'";
			$result = query($sql);
			$JANGBOO = happy_mysql_fetch_array($result);

			$package = explode(",",$JANGBOO['goods_name']);
			if ( is_array($package) )
			{
				foreach($package as $p)
				{
					$tmp_details = "";

					//최초 결제시에는 패키지 설정에서 읽어서 패키지권 줘야 하지만,
					//여기서는 boodong_jangboo_package 에 있는 걸로 적용해야 한다.
					$sql = "select * from $job_jangboo_package where jangboo_number = '".$JANGBOO['number']."' and package_number = '".$p."'";
					//echo $sql."<br><br>";
					$result = query($sql);
					$Package = happy_mysql_fetch_assoc($result);



					if ( $Package['number'] != "" )
					{
						$tmp_details = explode(",",$Package['uryo_detail']);

						foreach($tmp_details as $v)
						{
							$tmp_str = "";
							$tmp_option_name = "";
							$tmp_option_day = "";
							$tmp_option_cnt = "";
							$tmp_end_date = "";

							//유료옵션,옵션기간또는회수,사용회수
							list($tmp_option_name,$tmp_option_day,$tmp_option_cnt) = explode(":",$v);

							//패키지권 테이블에 넣자.
							for ($i=0;$i<$tmp_option_cnt;$i++)
							{
								$sql = "insert into $job_package set ";
								$sql.= "title = '".$Package['title']."',";
								$sql.= "id = '".$JANGBOO['or_id']."',";
								$sql.= "or_no = '".$JANGBOO['or_no']."',";
								$sql.= "option_name = '".$tmp_option_name."',";
								$sql.= "option_day = '".$tmp_option_day."',";
								$sql.= "reg_date = now(),";
								$sql.= "end_date = DATE_ADD( curdate(), INTERVAL '".$Package['end_day']."' DAY ),";
								$sql.= "use_date = '0000-00-00'";
								//echo $sql."<br>";
								query($sql);
							}
						}
					}
				}
			}

		}
		else if ( $_POST['old_in_check'] == 1 && $_POST['in_check'] == 0 )
		{
			//echo "입금 -> 미입으로 변경했다.<br>";
			//echo "패키지권 다 없애자<br>";
			//print_r2($_POST);

			$sql = "select * from $jangboo where number = '".$number."'";
			$result = query($sql);
			$row = happy_mysql_fetch_assoc($result);

			//아직 안쓴거만 삭제하려 했으나, 관리자가 실수한거라, 패키지권을 초기화 해주자.
			$sql = "delete from $job_package where or_no = '".$row['or_no']."'";
			query($sql);
		}
		//exit;


	}
	//패키지유료옵션
	else if ($_POST[member_type])
	{
		#기업회원정보를 업데이트함
		//echo $_POST['guin_docview']."<br>";
		//echo $_POST['guin_docview2']."<br>";
		//echo $_POST['guin_smspoint']."<br>";

		if ( $_POST['in_check'] == 1 )
		{
			$sql = "select * from $happy_member where number = '".$_POST['links_number']."'";
			$result = query($sql);
			$Buyer = happy_mysql_fetch_assoc($result);

			happy_member_option_set($happy_member_option_type,$Buyer['user_id'],'guin_docview',$_POST['guin_docview'],'int(11)');
			happy_member_option_set($happy_member_option_type,$Buyer['user_id'],'guin_docview2',$_POST['guin_docview2'],'int(11)');
			happy_member_option_set($happy_member_option_type,$Buyer['user_id'],'guin_smspoint',$_POST['guin_smspoint'],'int(11)');

			//채용정보 점프
			if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
			{
				happy_member_option_set($happy_member_option_type,$Buyer['user_id'],'guin_jump',$_POST['guin_jump'],'int(11)');
			}
			//채용정보 점프
		}
	}
	else
	{
		/*
		#필수항목이 결제 안되어 있으면 안보이도록 끄자
		if ( $_POST['in_check'] == 1 )
		{
			$display_query = " , display = 'Y' ";
			$ccnt = count($ARRAY);

			for ( $i=0; $i<$ccnt; $i++ )
			{
				$tmp_necessary = $ARRAY[$i]."_necessary";
				//echo $tmp_necessary."<br>";

				if ( $CONF[$ARRAY[$i]] && $CONF[$tmp_necessary] == '필수결제' )
				{
					$tmp_var = $ARRAY[$i];

					if ( $_POST_ORG[$tmp_var] <= 0 )
					{
						$display_query = " , display = 'N' ";
						break;
					}
				}
			}
		}
		#필수항목이 결제 안되어 있으면 안보이도록 끄자
		*/



		if ( $_POST['in_check'] == 1 )
		{
			#패키지(즉시적용) 때문에 추가됨 - ranksa
			if ( $_POST['pack2_title'] != "" )
			{

				happy_member_option_set($happy_member_option_type,$_POST['or_id'],'guin_docview',$_POST['guin_docview'],'int(11)');
				happy_member_option_set($happy_member_option_type,$_POST['or_id'],'guin_docview2',$_POST['guin_docview2'],'int(11)');
				happy_member_option_set($happy_member_option_type,$_POST['or_id'],'guin_smspoint',$_POST['guin_smspoint'],'int(11)');

				//채용정보 점프
				if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
				{
					happy_member_option_set($happy_member_option_type,$_POST['or_id'],'guin_jump',$_POST['guin_jump'],'int(11)');
				}
				//채용정보 점프
			}
			#패키지(즉시적용) 때문에 추가됨 - ranksa END




			#채용정보를 업데이트함
			$sql = "update $guin_tb set $query_name where number='$_POST[links_number]' ";
			//echo $sql;
			$result = query($sql);
		}
	}


	#일단은 장부에 업데이트하자
	$sql = "update $jangboo set
	or_method = '$_POST[or_method]' ,
	in_check = '$_POST[in_check]' ,
	goods_price = '$_POST[goods_price]',
	admin_message = '$_POST[admin_message]'
	where number = '$number'";
	$result = query ($sql);

	#미입 -> 입금시 결제자한테 SMS 보내기
	if ( $_POST['old_in_check'] == 0 && $_POST['or_method'] == "무통장입금" )
	{
		$sql = "select * from ".$jangboo." where number = '".$_POST['number']."'";
		$result = query($sql);
		$JB = happy_mysql_fetch_assoc($result);

		$sql = "select * from ".$happy_member." where user_id = '".$JB['or_id']."'";
		$result = query($sql);
		$Tmem = happy_mysql_fetch_assoc($result);


		if ( $HAPPY_CONFIG['SmsUryoBankConfirmUse'] == "1" )
		{
			$받는번호 = $Tmem['user_hphone'];
			$받는아이디 = $Tmem['user_id'];

			#sms_convert($sms_text,$per_name='',$or_no='',$stats='',$per_pass='',$per_cell='',$product_name='',$etc='',$confirm_number='',$per_id = '')
			#문자보낼문자열,이름,주문번호,상태,비밀번호,휴대폰번호,상품명,기타,인증번호,아이디
			$SMSMSG["SmsUryoBankConfirm"] = sms_convert($HAPPY_CONFIG["SmsUryoBankConfirm"],'','','','',$site_phone,'','','',$받는아이디);

			#사용법 echo sms_send(전송후반응타입,받을사람전번,회신전번,전송후이동주소,sms메세지,암호화여부(on/off));
			//echo $regist_send = sms_send(0,$받는번호,$site_phone,"",$SMSMSG["SmsUryoBankConfirm"],"1000","on");
			$dataStr = send_sms_msg($sms_userid,$받는번호,$site_phone,$SMSMSG['SmsUryoBankConfirm'],5,$sms_testing,'','','');
			send_sms_socket($dataStr);
			#gomsg("아이디를 SMS문자로 발송했습니다.","index.php");
		}

		#결제자에게 쪽지 발송 추가함 2009-11-18 kad
		if ( $HAPPY_CONFIG['MessageUryoBankConfirmUse'] == "1" )
		{
			$HAPPY_CONFIG['MessageUryoBankConfirm'] = str_replace("{{아이디}}",$Tmem['user_id'],$HAPPY_CONFIG['MessageUryoBankConfirm']);
			$HAPPY_CONFIG['MessageUryoBankConfirm'] = str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['MessageUryoBankConfirm']);

			$HAPPY_CONFIG['MessageUryoBankConfirm'] = addslashes($HAPPY_CONFIG['MessageUryoBankConfirm']);

			$sql = "INSERT INTO ";
			$sql.= $message_tb." ";
			$sql.= "SET ";
			$sql.= "sender_id = '".$admin_id."', ";
			$sql.= "sender_name = '관리자', ";
			$sql.= "sender_admin = 'y', ";
			$sql.= "receive_id = '".$Tmem['user_id']."', ";
			$sql.= "receive_name = '".$Tmem['user_name']."', ";
			$sql.= "receive_admin = 'n', ";
			$sql.= "message = '".$HAPPY_CONFIG['MessageUryoBankConfirm']."', ";
			$sql.= "regdate = now() ";
			query($sql);
		}
		#결제자에게 쪽지 발송 추가함 2009-11-18 kad
	}

	gomsg("\\n업데이트가 완료되었습니다 ","jangboo.php?action=jangboo_mod&number=$number&links_number=$_POST[links_number]");
	exit;

}

function jangboo_del()
{
	global $demo,$jangboo,$number,$CONF,$pg;
	//패키지결제추가됨 2012-06-20 kad
	global $job_money_package,$job_package,$job_jangboo_package;

	if ($demo == "1")
	{
		#데모이면 삭제안됨
		error("데모버젼은 작동하지 않습니다");
		exit;
	}

	//장부내역
	$sql = "select * from $jangboo where number = '".$number."'";
	$result = query($sql);
	$row = happy_mysql_fetch_assoc($result);

	$sql = "delete from $jangboo where number = '$number' ";
	$result = query($sql);


	//패키지 결제시 데이터 삭제안해도 되지만 삭제
	$sql = "delete from $job_jangboo_package where jangboo_number = '".$number."' ";
	query($sql);

	//결제내역이 삭제되면 패키지권도 모두 삭제
	$sql = "delete from $job_package where or_no = '".$row['or_no']."'";
	query($sql);

	go("jangboo.php?pg=$pg");
	exit;
}

?>