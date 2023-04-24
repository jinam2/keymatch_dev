<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");
include ("./inc/lib_pay.php");
//$category_info = category_read();

# in_check 값
# 0 미결재
# 1 결재완료
# 2 결재실패
# 3 해쉬에러 (데이콤이외는 기타에러)

//기업회원
//패키지구매는 구분값 100 : 기업회원, 200 : 일반회원
if ( $_GET['pay_type'] == "" )
{
	$jangboo = $jangboo;

	$member_type = '100';
}
//개인회원
else if ( $_GET['pay_type'] == "person" )
{
	$jangboo = $jangboo2;

	$member_type = '200';
}



$sql = "select * from $jangboo where or_no='$gou_number' ";
$result = query($sql);
$JANGBOO = happy_mysql_fetch_array($result);

if ($type == 'bank_soodong' || $type == 'point')
{
	//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
	/*
	if ($JANGBOO["number"] )
	{
		gomsg("\\n이미결제한 동일내역이 존재합니다. \\n\\n재결제를 위해 마이페이지로 이동하셔서 새로 결제를 시도하십시오  ","happy_member.php?mode=mypage");
		exit;
	}
	*/

	if ($JANGBOO["in_check"] == "1")
	{
		//gomsg("이미 입금완료된 내역입니다","happy_member.php?mode=mypage");
		echo "
				<script>
					alert('이미 입금완료된 내역입니다');
					parent.location.href='happy_member.php?mode=mypage';
				</script>
		";
		exit;
	}

	if( $mem_id == ""  )
	{
		gomsg("회원로그인후 사용할수 있는 페이지입니다","./happy_member_login.php");
		exit;
	}

	if( $gou_number == ""  )
	{
		error("고유번호가 없습니다");
		exit;
	}

	#매물번호넘어와야함.
	if (!($CONF[paid_conf]))
	{
		error("유료결제가 활성화된상태가 아닙니다.");
		exit;
	}

	if (!($_POST['total_price']))
	{
		error("결제금액이 없습니다");
		exit;
	}
}
else
{
	if( $mem_id == ""  )
	{
		msgclose("회원로그인후 사용할수 있는 페이지입니다");
		exit;
	}

	if( $gou_number == "" )
	{
		error("고유번호가 없습니다");
		exit;
	}

	//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
	/*
	if ($JANGBOO[number] )
	{
		msgclose("\\n이미결제한 동일내역이 존재합니다. \\n\\n재결제를 위해 마이페이지로 이동하셔서 새로 결제를 시도하십시오  ");
		exit;
	}
	*/

	if ($JANGBOO[in_check] == "1")
	{
		//msgclose("이미 입금완료 처리된 내역입니다.   ");
		echo "
				<script>
					alert('이미 입금완료된 내역입니다');
					parent.location.href='happy_member.php?mode=mypage';
				</script>
		";
		exit;
	}


	#매물번호넘어와야함.
	if (!($CONF[paid_conf]))
	{
		msgclose("유료결제가 활성화된상태가 아닙니다.");
		exit;
	}

	if (!($_POST['total_price']))
	{
		msgclose("결제금액이 없습니다");
		exit;
	}
}


#회원정보를 읽자
$sql = "select * from $happy_member where user_id='$mem_id'";
$result = query($sql);
$MEM = happy_mysql_fetch_array($result);

$MEM['id'] = $MEM['user_id'];
$MEM['etc1'] = $MEM['photo2'];
$MEM['etc2'] = $MEM['photo3'];
$MEM['com_job'] = $MEM['extra13'];
$MEM['com_profile1'] = nl2br($MEM['message']);
$MEM['com_profile2'] = nl2br($MEM['memo']);
$MEM['boss_name'] = $MEM['extra11'];
$MEM['com_open_year'] = $MEM['extra1'];
$MEM['com_worker_cnt'] = $MEM['extra2'];
$MEM['com_zip'] = $MEM['user_zip'];
$MEM['com_addr1'] = $MEM['user_addr1'];
$MEM['com_addr2'] = $MEM['user_addr2'];
$MEM['regi_name'] = $MEM['extra12'];
$MEM['com_phone'] = $MEM['user_hphone'];
$MEM['com_fax'] = $MEM['user_fax'];
$MEM['com_email'] = $MEM['user_email'];
$MEM['com_homepage'] = $MEM['user_homepage'];


$MEM["per_phone"] = $MEM["com_phone"];
$MEM["per_name"] = $MEM["com_name"];
$MEM["per_email"] = $MEM['com_email'];


//print_r2($_POST);

// 선택한 옵션의 유효성 체크 2022-02-23 kad
$is_option_check		= true;
if ( is_array($_POST['package_product']) )
{
	foreach($_POST['package_product'] as $list)
	{
		// 선택한 옵션
		list($pack_key,$pack_price) = explode("|",$list);

		// DB에 설정된 옵션
		$sql		= "SELECT * FROM $job_money_package WHERE number = '$pack_key'";
		$result		= query($sql);
		$PackageDB	= happy_mysql_fetch_assoc($result);

		if ( $PackageDB['price'] != $pack_price )
		{
			$is_option_check		= false;
			break;
		}
		else
		{
			//echo $PackageDB['number']."|".$PackageDB['price']." 있다 <br>";
		}
	}
}
//echo var_dump($is_option_check);
//print_r2($_POST); exit;
if ( $is_option_check == false )
{
	msgclose("해킹시도중?");
	exit;
}
// 선택한 옵션의 유효성 체크 2022-02-23 kad



//패키지 유료옵션 결제금액 + 유료옵션비교
$cal_price = "0";
$pack_keys = array();
if ( is_array($_POST['package_product']) )
{
	foreach($_POST['package_product'] as $list)
	{
		list($pack_key,$pack_price) = explode("|",$list);

		$pack_keys[] = $pack_key;
		$cal_price += $pack_price;
	}

	$pay_content = implode(",", (array) $pack_keys);
}
else
{
	msgclose("해킹시도중?");
	exit;
}


if ($cal_price != $_POST['total_price'])
{
	msgclose("해킹시도중?");
	exit;
}

#장부에 해당정보를 찍자
if ($type == 'card')
{
	$type_text = '카드결제';
}
elseif ($type == 'bank')
{
	$type_text = '실시간계좌이체';
}
elseif ($type == 'phone')
{
	$type_text = '핸드폰결제';
}
elseif ($type == 'bank_soodong')
{
	$type_text = '계좌이체';
}
elseif ($type == 'point')
{
	$type_text = '포인트결제';
}


//장부 인서트 코드 변경 2011-06-20 kad insert into set 으로 변경함
//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
$setsql_jang= "";
$setsql_jang.= "or_id = '".$mem_id."', ";
$setsql_jang.= "or_phone = '".$MEM['user_phone']."', ";
$setsql_jang.= "goods_name = '".$pay_content."', ";
$setsql_jang.= "goods_price = '".$cal_price."', ";
$setsql_jang.= "or_method = '".$type_text."', ";
$setsql_jang.= "or_no = '".$gou_number."', ";
$setsql_jang.= "links_number = '".$number."', ";
$setsql_jang.= "jangboo_date = now(), ";
$setsql_jang.= "in_check = '".$in_check."', ";
$setsql_jang.= "admin_message = '".$admin_message."', ";
$setsql_jang.= "member_type = '".$member_type."', ";
$setsql_jang.= "etc2 = '".$etc2."' ";
if ($JANGBOO[number] )
{
	$sql = "update $jangboo set ";
	$sql .= $setsql_jang;

	$sql.= "where or_no = '".$gou_number."' ";
}
else
{
	$sql = "insert into $jangboo set ";
	$sql .= $setsql_jang;
}
//$sql.= "banking_name = '".$banking_name."',";
//$sql.= "banking_date = '".$banking_date."'";
//echo $sql;
//exit;
$result = query($sql);



#장부의 정보를 읽어낸다
$sql = "select * from $jangboo where or_no='$gou_number' ";
$result = query($sql);
$JANGBOO = happy_mysql_fetch_array($result);

if ($JANGBOO[number] == '')
{
	gomsg("장부에 해당 내역이 존재하지 않습니다","happy_member.php?mode=mypage");
	exit;
}

if ($JANGBOO[in_check] == "1")
{
	gomsg("이미 입금완료된 내역입니다","happy_member.php?mode=mypage");
	exit;
}

//패키지옵션이 변경되어도 결제내역에는 영향을 안주도록
if ( is_array($pack_keys) )
{
	foreach($pack_keys as $v)
	{
		$sql = "select * from $job_money_package where number = '".$v."'";
		$result = query($sql);
		$row = happy_mysql_fetch_assoc($result);

		$sql = "insert into $job_jangboo_package set ";
		$sql.= "package_number = '".$v."',";
		$sql.= "uryo_detail = '".$row['uryo_detail']."',";
		$sql.= "or_no = '".$gou_number."',";
		$sql.= "id = '".$mem_id."',";
		$sql.= "title = '".$row['title']."',";
		$sql.= "jangboo_number = '".$JANGBOO['number']."',";
		$sql.= "end_day = '".$row['end_day']."',";

		$sql.= "reg_date = now()";
		query($sql);
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////
$oid = $gou_number;				//주문번호
$amount = $cal_price;		//결제금액
//////////////////////////////////////////////////////////////////////////////////////////////////


if ( $type == "card" || $type == "bank" || $type == "phone" )
{
	$package_pay_type				= ($_GET['pay_type'] == "")?"company_package":"person_package";
	//REQ_VAL 키값은 다른페이지도 동일해야합니다
	$REQ_VAL						= Array();
	$REQ_VAL['oid']					= $oid;
	$REQ_VAL['amount']				= $amount;
	$REQ_VAL['buyer_name']			= $MEM["user_name"];
	$REQ_VAL['product_title']		= preg_replace ("/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "","패키지 결제");
	$REQ_VAL['buyer_email']			= $MEM['user_email'];
	$REQ_VAL['buyer_id']			= $MEM['user_id'];
	$REQ_VAL['pay_type']			= $type;
	$REQ_VAL['pay_type_option']		= $package_pay_type;

	$REQ_VAL['daoupay_success_page']= $main_url."/"."my_pay_point_success.php?oid=$oid&respcode=0000";

	pg_req($REQ_VAL);
	exit;
}
elseif ($type == "bank_soodong")
{

	$happy_member_login_id	= happy_member_login_check();

	if ( $happy_member_login_id == "" )
	{
		error('로그인후 이용가능 합니다.');
		exit;
	}

	#happy_member_nick_history_change( 'testasdf', 'tester', 'execute' );
	#happy_member_state_open_change( 'testasdf', 'y', 'execute' );

	$Member			= happy_member_information($happy_member_login_id);
	$member_group	= $Member['group'];

	/*
	$Sql	= "SELECT * FROM $happy_member_group WHERE number='$member_group' ";
	$Tmp	= happy_mysql_fetch_array(query($Sql));
	$Template_Default		= ( $Tmp['mypage_default'] == '' )? $happy_member_mypage_default_file : $Tmp['mypage_default'];
	*/

	# 유저그룹별 껍데기 파일 추출	2010-06-29 ralear
	$sql				= "select * from $happy_member_group where number='$member_group' ";
	$result				= query($sql);
	$Data				= happy_mysql_fetch_array($result);
	$Template_Default	= $Data['mypage_default'];



	go("html_file.php?file=my_pay_bank_end.html&file2=$Template_Default");
	exit;
}
elseif ($type == "point"){

	$sql = "SELECT point FROM $happy_member WHERE user_id='$mem_id' ";
	$result = query($sql);
	$Data = happy_mysql_fetch_array($result);

	#포인트 부족일 경우
	if ( $Data['point'] < $amount )
	{
		gomsg("포인트가 부족합니다","/");
		echo "<script>window.open('./my_point_charge.php','charge_win','width=388,height=340,scrollbars=no')</script>";
		exit;
	}

	$point_sql = "UPDATE $happy_member SET point=point-$amount WHERE user_id='$mem_id' ";
	query($point_sql);

	$sql = "INSERT INTO $point_jangboo SET
			id = '$mem_id',
			point = $amount,
			pay_type = '포인트결제',
			in_check = 2,
			or_no = '$gou_number',
			links_number = '$number',
			links_title = '$p_title $memool_title',
			reg_date = NOW()
		";
	query($sql);

	#포인트 업데이트 여기서 해주자.
	$oid = $gou_number;
	pay_ok_package();

	go("my_pay_success.php?type=$type&respcode=0000&oid=$gou_number");
	exit;
}



?>