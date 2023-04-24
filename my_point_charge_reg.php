<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/lib.php");
include ("./inc/lib_pay.php");

#전체템플릿 읽어준다.

#포인트 충전사용여부 - sun
if ( $HAPPY_CONFIG['point_charge_use'] != "" )
{
	msgclose("포인트충전 기능은 사용할 수 없습니다.");
	exit;
}


#load_config(); #설정을 읽어낸다

# in_check 값
# 0 미결재
# 1 결재완료
# 2 결재실패
# 3 해쉬에러 (데이콤이외는 기타에러)

#장부의 정보를 읽어낸다
$sql = "select * from $point_jangboo  where or_no='$gou_number' ";
$result = query($sql);
$JANGBOO = happy_mysql_fetch_array($result);


if ($type == 'bank_soodong')
{
	//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
	/*
	if ($JANGBOO[number] )
	{
		error("\\n이미 결제시도한 정보입니다.   \\n\\n새로 결제를 시도하십시오  \\n");
		exit;
	}
	*/
	if ($JANGBOO[in_check] == "1")
	{
		//error("이미 입금완료된 내역입니다");
		echo "
			<script>
				alert('이미 입금완료 처리된 내역입니다.');
				parent.close();
			</script>
		";
		exit;
	}

	if( $mem_id == ""  )
	{
		error("회원로그인후 사용할수 있는 페이지입니다");
		exit;
	}
	if( $gou_number == ""  )
	{
		error("고유번호가 없습니다");
		exit;
	}

	if (!($total_price))
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
	if( $gou_number == ""  )
	{
		msgclose("고유번호가 없습니다");
		exit;
	}
	//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
	/*
	if ($JANGBOO[number] )
	{
		msgclose("\\n이미 결제시도한 정보입니다.  \\n\\n새로 결제를 시도하십시오  \\n");
		exit;
	}
	*/
	if ($JANGBOO[in_check] == "1")
	{
		//msgclose("이미 입금완료 처리된 내역입니다.   ");
		echo "
			<script>
				alert('이미 입금완료 처리된 내역입니다.');
				parent.close();
			</script>
		";
		exit;
	}


	if (!($total_price))
	{
		msgclose("결제금액이 없습니다");
		exit;
	}

}


// 선택한 옵션의 유효성 체크 2022-02-23 kad
$is_option_check	= true;
if ( $total_price != "" )
{
	// 선택한 옵션
	$string		= str_replace("|",":",str_replace("\r","",$total_price));

	// DB에 설정된 옵션
	$DB_ARR		= split("\n",str_replace("\r","",$CONF['money_point']));

	if ( array_search(trim($string),$DB_ARR) === false )
	{
		//echo "$string 없다<br>";
		$is_option_check		= false;
	}
	else
	{
		//echo "$string 있다<br>";
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



#회원정보를 읽자
$sql = "select * from $happy_member where user_id='$mem_id'";
$result = query($sql);
$MEMBER = happy_mysql_fetch_array($result);



$MEM = $MEMBER;

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
	$type_text = '무통장입금';
}

if ($member_type == $MEMBER[number])
{
	$member_type = $MEMBER[number];
}
else
{
	$member_type = '';
}



//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
$setsql_jang= "";
$setsql_jang.= "id = '$mem_id', ";
$setsql_jang.= "point = '$total_price', ";
$setsql_jang.= "pay_type = '$type_text', ";
$setsql_jang.= "in_check = '0', ";
$setsql_jang.= "or_no = '$gou_number', ";
$setsql_jang.= "reg_date = now(), ";
$setsql_jang.= "member_type = '".$_COOKIE['level']."'";		#기업 or 일반 / 2 / 1
if ($JANGBOO[number] )
{
	$sql = "update $point_jangboo set ";
	$sql .= $setsql_jang;

	$sql.= "where or_no = '".$gou_number."'";
}
else
{
	$sql = "insert $point_jangboo set ";
	$sql .= $setsql_jang;
}
$result = query ($sql);

#장부의 정보를 읽어낸다
$sql = "select * from $point_jangboo where or_no='$gou_number' ";
$result = query($sql);
$JANGBOO = happy_mysql_fetch_array($result);

if ($JANGBOO[number] == '')
{
	msgclose("오류 : 장부에 해당 내역이 존재하지 않습니다");
	exit;
}
if ($JANGBOO[in_check] == "1")
{
	msgclose("오류 : 이미 입금완료된 내역입니다");
	exit;
}


#결제금액
$tmpPrice = explode("|",$total_price);
$total_price = $tmpPrice[1];

////////////////////////////////////////////////////////////////////////////////////////////////////
$oid = $gou_number;				//주문번호
$amount = $total_price;		//결제금액
//////////////////////////////////////////////////////////////////////////////////////////////////


#결제자이름
$MEMBER['per_name'] = $MEMBER[$name_field];
#결제자휴대폰
$MEMBER['phone'] = $MEMBER[$tel_field];
$MEM['id'] = $MEMBER['user_id'];
$MEM['per_name'] = $MEMBER['user_name'];
$MEM['per_phone'] = $MEMBER['user_phone'];







if ( $type == "card" || $type == "bank" || $type == "phone" )
{
	//REQ_VAL 키값은 다른페이지도 동일해야합니다
	$REQ_VAL						= Array();
	$REQ_VAL['oid']					= $oid;
	$REQ_VAL['amount']				= $amount;
	$REQ_VAL['buyer_name']			= $MEMBER["user_name"];
	$REQ_VAL['product_title']		= preg_replace ("/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "","포인트 결제");
	$REQ_VAL['buyer_email']			= $MEMBER['user_email'];
	$REQ_VAL['buyer_id']			= $MEMBER['user_id'];
	$REQ_VAL['pay_type']			= $type;
	$REQ_VAL['pay_type_option']		= "point";

	$REQ_VAL['daoupay_success_page']= $main_url."/"."my_pay_success.php?oid=$oid&respcode=0000";

	pg_req($REQ_VAL);
	exit;
}
elseif ($type == "bank_soodong")
{
	msgclose_url('무통장입금이 신청되었습니다.',"html_file.php?file=my_pay_buy_bank_end.html");
	exit;
}


?>