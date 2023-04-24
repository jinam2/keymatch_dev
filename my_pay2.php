<?php
###############################################################################
#개인회원 결제창
#
#
#
#
#
###############################################################################

$t_start = array_sum(explode(' ', microtime()));
include ("./inc/Template.php");
$TPL = new Template;

include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");
include ("./inc/lib_pay.php");

# in_check 값
# 0 미결제
# 1 결제완료
# 2 결제실패
# 3 해쉬에러 (데이콤이외는 기타에러)

#장부의 정보를 읽어낸다
$sql = "select * from $jangboo2 where or_no='$gou_number' ";
$result = query($sql);
$JANGBOO = happy_mysql_fetch_array($result);







if ($type == 'bank_soodong')
{
	//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
	/*
	if ($JANGBOO[number] )
	{
		gomsg("\\n이미결제한 동일내역이 존재합니다. \\n\\n재결제를 위해 마이페이지로 이동하셔서 새로 결제를 시도하십시오  ","happy_member.php?mode=mypage");
		exit;
	}
	*/
	if ($JANGBOO[in_check] == "1")
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
	#if (!($total_price)){
	#error("결제금액이 없습니다");
	#exit;
	#}

	if (!($number))
	{
		error("잘못된 접근입니다");
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
	#if (!($total_price)){
	#msgclose("결제금액이 없습니다");
	#exit;
	#}

	if (!($number))
	{
		msgclose("잘못된 접근입니다");
		exit;
	}
}




#넘어온 유료값으로 string 만들자.
#$names		= Array("guin_special","guin_focus","guin_powerlink","guin_docskin","guin_icon","guin_bolder","guin_color","guin_freeicon","guin_bgcolor","GuzicUryoDate1","GuzicUryoDate2","GuzicUryoDate3","GuzicUryoDate4","GuzicUryoDate5");
$names = $PER_ARRAY_DB;


// 선택한 옵션의 유효성 체크 2022-02-23 kad
$is_option_check		= true;
for ( $i=0,$max=sizeof($names) ; $i<$max ; $i++ )
{
	// 0:0 은 DB에는 없는데 선택하는 화면에는 있다.
	if ( $_POST[$names[$i]] != "" && $_POST[$names[$i]] != "0:0" )
	{
		// 선택한 옵션
		$string		= str_replace("\r","",$_POST[$names[$i]]);

		// DB에 설정된 옵션
		$DB_ARR		= split("\n",str_replace("\r","",$CONF[$names[$i]]));

		if ( array_search(trim($string),$DB_ARR) === false )
		{
			//echo "$names[$i] 없다<br>";
			$is_option_check		= false;
			break;
		}
		else
		{
			//echo "$names[$i] 있다<br>";
		}
	}
}
//echo var_dump($is_option_check);
//print_r2($_POST); exit;
if ( $is_option_check == false )
{
	msgclose("해킹시도중? ");
	exit;
}
// 선택한 옵션의 유효성 체크 2022-02-23 kad



$priceSum	= 0;
$priceStr	= "";
for ( $i=0,$max=sizeof($names) ; $i<$max ; $i++ )
{
	$string		= $_POST[$names[$i]];
	${$names[$i]}	= $string;
	$priceStr	.= $string .",";
	$Temp		= explode(":",$string);
	$string		= $Temp[1];
	$priceSum	= $priceSum + $string;
}






if ($priceSum != $total_price)
{
	msgclose("해킹시도중? ");
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
	$type_text = '무통장입금';
}
elseif ( $type == 'point' )
{
	$type_text = '포인트결제';
}

if ($target == 'member')
{
	$member_type = $MEM[level];
}
else
{
	$member_type = '';
}

if ( $_POST['pay_type'] != "per_member" )
{
	#이력서결제
	$member_type = "0";
}
else
{
	#회원결제
	$member_type = "1";
}


//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
$setsql_jang	= "";
$setsql_jang.= "or_id = '".$mem_id."',";
$setsql_jang.= "or_phone = '".$MEM['user_phone']."',";
$setsql_jang.= "goods_name = '".$priceStr."',";
$setsql_jang.= "goods_price = '".$priceSum."',";
$setsql_jang.= "or_method = '".$type_text."',";
$setsql_jang.= "or_no = '".$gou_number."',";
$setsql_jang.= "links_number = '".$number."',";
$setsql_jang.= "jangboo_date = now(),";
$setsql_jang.= "in_check = '".$in_check."',";
$setsql_jang.= "admin_message = '".$admin_message."',";
$setsql_jang.= "member_type = '".$member_type."',";
$setsql_jang.= "etc2 = '".$etc2."',";
$setsql_jang.= "doc_skin = '".$doc_skin."',";
$setsql_jang.= "freeicon = '".$freeicon."'";

if ($JANGBOO[number] )
{
	$sql = "update ".$jangboo2." set ";
	$sql .= $setsql_jang;

	$sql.= "where or_no = '".$gou_number."'";
}
else
{
	$sql = "insert into ".$jangboo2." set ";
	$sql .= $setsql_jang;
}
$result = query ($sql);


#장부의 정보를 읽어낸다
$sql = "select * from $jangboo2 where or_no='$gou_number' ";
$result = query($sql);
$JANGBOO = happy_mysql_fetch_array($result);
if ($JANGBOO[number] == '')
{
	msgclose("장부에 해당 내역이 존재하지 않습니다");
	exit;
}
if ($JANGBOO[in_check] == "1")
{
	msgclose("이미 입금완료된 내역입니다","document.php?mode=uryo&number=$number");
	exit;
}


#결제금액이 0원일경우 바로 입금처리
if ( !$total_price || $total_price == 0 )
{
	#날짜정보를 읽어서 업데이트를 실시한다.
	$GET_DAY = split(",",$JANGBOO[goods_name]);
	#장부에 해당정보를 찍자
	$sql = "update $jangboo2 set in_check = '1' where or_no='$gou_number'";
	$result2 = query($sql);


	######################### 결제성공 했으니 관련 처리 해줍시다 ############################
	if ( $JANGBOO['member_type'] == "0" )
	{
		$Sql		= "SELECT * FROM $per_document_tb WHERE number='$JANGBOO[links_number]' ";
		$Data		= happy_mysql_fetch_array(query($Sql));

		$SetSql		= "";
		$options	= explode(",",$JANGBOO["goods_name"]);

		if ( $JANGBOO["doc_skin"] != "" ) {
			$SetSql	.= ( $SetSql == "" )?"":",";
			$SetSql	.= " skin_html='$JANGBOO[doc_skin]' ";
		}
		if ( $JANGBOO["freeicon"] != "" ) {
			$SetSql	.= ( $SetSql == "" )?"":",";
			$SetSql	.= " freeicon='$JANGBOO[freeicon]' ";
		}

		$names		= $PER_ARRAY;
		$nowstamp	= happy_mktime();
		$nowDate	= date("Y-m-d h:i:s");

		for ( $i=0 , $max=sizeof($names) ; $i<$max ; $i++ )
		{
			if ( $options[$i] != "" && $options[$i] != "0:0" )
			{
				$option	= explode(":",$options[$i]);

				$chkDate	= ( $Data[$names[$i]] < $nowDate )?$nowDate:$Data[$names[$i]];
				$chkDate	= explode(" ",$chkDate);
				$Dates		= explode("-", $chkDate[0]);
				$outDate	= date("Y-m-d 00:00:00",happy_mktime(0,0,0,$Dates[1],$Dates[2]+$option[0],$Dates[0]));
				$SetSql	.= ( $SetSql == "" )?"":",";
				$SetSql	.= $names[$i] ." = '$outDate' ";
			}
		}

		$Sql	= "
					UPDATE
							$per_document_tb
					SET
							$SetSql
					WHERE
							number='$JANGBOO[links_number]'
		";

		if ($SetSql)
		{
			query($Sql);
			$alert_msg = '옵션추가가 완료되었습니다.';
		}
		else
		{
			$sql = "delete from $jangboo2 where or_no = '$gou_number'";
			query($sql);
			$alert_msg = '등록이 완료되었습니다.';

			/*
			if ($type != 'bank_soodong'){
				echo "<script>alert('선택한 옵션이 없습니다.');window.close();</script>";
			exit;
			} else {
				echo "<script>alert('선택한 옵션이 없습니다.');window.history.back();</script>";
			exit;
			}
			*/
		}
	}
	else
	{
		#추가된 회원결제
		$options	= explode(",",$JANGBOO["goods_name"]);

		$sql = "select * from ".$happy_member." where user_id = '".$JANGBOO['or_id']."' ";
		$result = query($sql);
		$MEM = happy_mysql_fetch_assoc($result);

		$MEM['guzic_view'] = happy_member_option_get($happy_member_option_type,$MEM['user_id'],'guzic_view');
		$MEM['guzic_view2'] = happy_member_option_get($happy_member_option_type,$MEM['user_id'],'guzic_view2');
		$MEM['guzic_smspoint'] = happy_member_option_get($happy_member_option_type,$MEM['user_id'],'guzic_smspoint');

		for ( $i=14;$i<=16;$i++ )
		{
			$option = "";
			$update_value = "";

			if ( $options[$i] != "" )
			{
				$field_name = $PER_ARRAY_DB[$i];
				$option	= explode(":",$options[$i]);
				if ( $i == 14 )
				{
					if ( $MEM['guzic_view'] <= $real_gap )
					{
						$update_value = $real_gap + $option[0];
					}
					else
					{
						$update_value = $MEM['guzic_view'] + $option[0];
					}
				}
				else
				{
					$update_value = $MEM[$field_name] + $option[0];
				}

				//echo $field_name.":".$update_value."<br>";
				happy_member_option_set($happy_member_option_type,$MEM['user_id'],$field_name,$update_value,'int(11)');
			}
		}
		$alert_msg = '옵션추가가 완료되었습니다.';
		#추가된 회원결제
	}


	if ( $type != 'bank_soodong' && $type != 'point' )
	{
		echo "<script>alert('$alert_msg');opener.window.location.href='happy_member.php?mode=mypage';self.close();</script>";
		exit;
	}
	else
	{
		echo "<script>alert('$alert_msg');window.location.href='happy_member.php?mode=mypage';</script>";
		exit;
	}

	################################### 처리 끝ㅌㅌㅌㅌ #####################################


}


//이력서 스킨은 일단 이력서 테이블에 집어넣어 놓고 결제가 완료 되어야지만 출력되도록 미리 넣자
$Sql	= "
			UPDATE
					$per_document_tb
			SET
					skin_html = '$_POST[doc_skin]',
					freeicon = '$_POST[freeicon]'
			WHERE
					number='$JANGBOO[links_number]'
		";

if ($_POST[doc_skin] || $_POST[freeicon])
{
	query($Sql);
}


$MEM = happy_member_information(happy_member_login_check());
$MEM['per_name'] = $MEM['user_name'];
$MEM['per_phone'] = $MEM['user_phone'];
$MEM['per_email'] = $MEM['user_email'];

////////////////////////////////////////////////////////////////////////////////////////////////////
$oid		= $gou_number;    //주문번호
$amount		= $priceSum;  //결제금액
//////////////////////////////////////////////////////////////////////////////////////////////////


if ( $type == "card" || $type == "bank" || $type == "phone" )
{
	//REQ_VAL 키값은 다른페이지도 동일해야합니다
	$REQ_VAL						= Array();
	$REQ_VAL['oid']					= $oid;
	$REQ_VAL['amount']				= $amount;
	$REQ_VAL['buyer_name']			= $MEM["user_name"];
	$REQ_VAL['product_title']		= preg_replace ("/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "","유료옵션 결제");
	$REQ_VAL['buyer_email']			= $MEM['user_email'];
	$REQ_VAL['buyer_id']			= $MEM['user_id'];
	$REQ_VAL['pay_type']			= $type;
	$REQ_VAL['pay_type_option']		= "person";

	$REQ_VAL['daoupay_success_page']= $main_url."/"."my_pay_success2.php?oid=$oid&respcode=0000";

	pg_req($REQ_VAL);
	exit;
}
elseif ($type == "bank_soodong")
{
	go("html_file.php?file=my_pay_bank_end.html&file2=default_non.html");
	exit;
}
elseif ( $type == 'point' )
{

	$sql = "SELECT point FROM $happy_member WHERE user_id='$mem_id' ";
	$result = query($sql);
	$Data = happy_mysql_fetch_array($result);



	$total_price = $priceSum;		#다른솔루션과 아래 코드는 같음

	#포인트 부족일 경우
	if ( $Data['point'] < $total_price )
	{
		gomsg("포인트가 부족합니다","/");
		echo "<script>window.open('./my_point_charge.php','charge_win','width=388,height=340,scrollbars=no')</script>";
		exit;
	}
	else
	{

		$point_sql = "UPDATE $happy_member SET point=point-$total_price WHERE user_id='$mem_id' ";
		query($point_sql);
		$total_price_out = $total_price."|".$total_price;
		$sql = "INSERT INTO $point_jangboo SET
				id = '$mem_id',
				point = '$total_price_out',
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
		pay_ok();

		go("my_pay_success2.php?type=$type&respcode=0000");

		exit;
	}
}





?>