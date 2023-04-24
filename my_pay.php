<?php
###############################################################################
#기업회원 결제창
#채용정보 유료옵션
#이력서 보기 유료결제
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
$sql = "select * from $jangboo where or_no='$gou_number' ";
$result = query($sql);
$JANGBOO = happy_mysql_fetch_array($result);

if ($type == 'bank_soodong')
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
	if (!($CONF["paid_conf"]))
	{
		error("유료결제가 활성화된상태가 아닙니다.");
		exit;
	}

	if (!($number))
	{
		error("잘못된 접근입니다 $number");
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

	if (!($number))
	{
		msgclose("잘못된 접근입니다 $number");
		exit;
	}
}


//유료채용공고 신청하기(채용정보 등록 후 유료옵션결제)시 필수결제 체크 - 2017-01-13 hong
if ( $_POST['is_repay'] == "y" )
{
	#기존의 구인결재정보를 읽어
	$sql = "select * from $guin_tb where number='$number'";
	$DETAIL = happy_mysql_fetch_array(query($sql));

	#패키지(즉시적용)
	$PACK2_CHK						= Array();	//패키지옵션에 일반필수결제 항목들어가있을시 exit하지않기위함 - ranksa
	if($_POST['pack2_all_number'] != "")
	{
		$pp							= 0;
		$pack2_cnt					= 0;
		$pack2_number_explode		= explode(",",$_POST['pack2_all_number']);
		foreach($pack2_number_explode AS $pne_key => $pne_val)
		{
			$pp++;

			if($_POST['pack2_uryo_'.$pne_val] != "")
			{
				$pack2_cnt++;

				//패키지옵션에 일반필수결제 항목들어가있을시 exit하지않기위함 - ranksa
				$Sql_pack2				= "SELECT price,title,uryo_detail FROM $job_money_package2 WHERE number=$pne_val";
				$Rec_pack2				= query($Sql_pack2);
				$PACK2					= happy_mysql_fetch_assoc($Rec_pack2);

				$PACK2['ud_ex']			= explode(",",$PACK2['uryo_detail']);
				foreach($PACK2['ud_ex'] AS $UD_VAL)
				{
					$ud_val_ex			= explode(":",$UD_VAL);
					if($ud_val_ex[1] == 1)
					{
						$PACK2_CHK[$ud_val_ex[0]]	= $ud_val_ex[1];
					}
				}
			}
		}
		unset($pp,$pack2_cnt,$pne_key,$pne_val);

	}
	//exit;
	#패키지(즉시적용) END

	#필수결제항목체크
	$cnt = count($ARRAY);
	for ( $i=0; $i<$cnt; $i++ )
	{
		$n_name = $ARRAY[$i]."_necessary";
		$u_name = $ARRAY[$i]."_use";
		$u_option = $ARRAY[$i]."_option";
		$op_name = $ARRAY_NAME[$i];

		//사용함 이거나, 빈값일때
		if ( $CONF[$ARRAY[$i]]
			&& $CONF[$n_name] == '필수결제'
			&& ( $CONF[$u_name] == '사용함' || $CONF[$u_name] == '') )
		{
			if ($CONF[$u_option] == '기간별')
			{
				$now_end_date = $DETAIL[$ARRAY[$i]] - $real_gap;

				if ( $now_end_date < 0 )
				{
					$now_end_date = 0;
				}
			}
			else
			{
				$now_end_date = $DETAIL[$ARRAY[$i]];
			}

			if ( $now_end_date <= 0 )
			{
				//echo $_POST[$ARRAY[$i]]." / ".$ARRAY[$i]."<br>";
				if ( ($_POST[$ARRAY[$i]] == '' || $_POST[$ARRAY[$i]] == "0:0") && $PACK2_CHK[$ARRAY[$i]] == '' )
				{
					if( $_COOKIE['happy_mobile'] == 'on' )
					{
						error(" $op_name 옵션은 결제를 하셔야만 등록이 됩니다.");exit;
					}
					else
					{
						msg(" $op_name 옵션은 결제를 하셔야만 등록이 됩니다.");exit;
					}
				}
			}
		}
	}
	#필수결제항목체크
	//print_r2($PACK2_CHK);exit;
}
//유료채용공고 신청하기(채용정보 등록 후 유료옵션결제)시 필수결제 체크 - 2017-01-13 hong



#패키지(즉시적용)
#패키지(즉시적용)안에서도 중복되는 옵션 카운트 다 더하고 여기서 정리한것을 다른루틴(개별옵션)과 더할 수 있도록 정리
$CNT_URYO	= pack2_cnt($_POST);
//print_r2($_POST);
//print_r2($CNT_URYO);
//exit;
#패키지(즉시적용)안에서도 중복되는 옵션 카운트 다 더하고 여기서 정리한것을 다른루틴(개별옵션)과 더할 수 있도록 정리
#패키지(즉시적용) END


// 선택한 옵션의 유효성 체크 2022-02-23 kad
$is_option_check		= true;
foreach ($ARRAY as $list)
{
	// 0:0 은 DB에는 없는데 선택하는 화면에는 있다.
	if ( $_POST[$list] != "" && $_POST[$list] != "0:0" )
	{
		// 선택한 옵션
		$string		= str_replace("\r","",$_POST[$list]);

		// DB에 설정된 옵션
		$DB_ARR		= split("\n",str_replace("\r","",$CONF[$list]));

		if ( array_search(trim($string),$DB_ARR) === false )
		{
			//echo "$list 없다<br>";
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
//print_r2($_POST);exit;
if ( $is_option_check == false )
{
	msgclose("해킹시도중?");
	exit;
}
// 선택한 옵션의 유효성 체크 2022-02-23 kad


$cal_price = "0";

#유료옵션선택 가공단계
foreach ($ARRAY as $list)
{
	$get_tmp = $$list;
	$get_tmp = str_replace("\n", "", $get_tmp);
	$get_tmp = str_replace("\r", "", $get_tmp);
	$get_tmp = str_replace(" ", "", $get_tmp);
	$get_tmp = str_replace(",", "", $get_tmp);
	list($tmp_day,$tmp_price) = split("\:",$get_tmp);

	if($CNT_URYO[$list] > 0) //옵션카운트 합계 = 단일옵션 + 패키지(즉시적용)
	{
		$tmp_day	= $tmp_day + $CNT_URYO[$list];
		$pack2_title= $CNT_URYO['title'];
	}

	$colon			= ($tmp_day == "")?"":":";
	if($tmp_day != "" && $tmp_price == "") //패키지(즉시적용) 으로 인해 카운트는 되었는데 가격정보 없을때 예외처리
	{
		$tmp_price	= 0;
	}

	#가격합산을 다시한다.
	$cal_price		= $cal_price + $tmp_price;
	//$pay_content	.="$get_tmp,";
	$pay_content	.= "$tmp_day{$colon}$tmp_price,";
}
$cal_price			= $cal_price + $CNT_URYO['price']; //패키지(즉시적용) 가격 더함

unset($CNT_URYO);
//echo $pay_content."<br>";
//exit;
//echo $guin_jump;
#유료옵션선택 가공단계 END


if ($cal_price != $total_price)
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
	$type_text = '무통장입금';
}
elseif ( $type == 'point' )
{
	$type_text = '포인트결제';
}


//결제회원정보
$sql = "select * from $happy_member where user_id ='$member_id'";
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


$MEM["per_phone"] = ($MEM["com_phone"] != "")?$MEM["com_phone"]:$MEM["user_phone"];
$MEM["per_name"] = ($MEM["com_name"] != "")?$MEM["com_name"]:$MEM["com_name"];
$MEM["per_email"] = ($MEM['com_email'] != "")?$MEM["com_email"]:$MEM["com_email"];




#장부에 쓰자
//결제시도시 주문번호 존재 예외처리 커스터 - ranksa
$setsql_jang= "";
$setsql_jang.= "or_id = '".$mem_id."',";
$setsql_jang.= "or_phone = '".$MEM['per_phone']."',";
$setsql_jang.= "goods_name = '".$pay_content."',";
$setsql_jang.= "goods_price = '".$cal_price."',";
$setsql_jang.= "or_method = '".$type_text."',";
$setsql_jang.= "or_no = '".$gou_number."',";
$setsql_jang.= "links_number = '".$number."',";
$setsql_jang.= "jangboo_date = now(),";
$setsql_jang.= "in_check = '".$in_check."',";
$setsql_jang.= "admin_message = '".$admin_message."',";
$setsql_jang.= "member_type = '".$member_type."',";
$setsql_jang.= "etc2 = '".$etc2."',";
$setsql_jang.= "freeicon = '".$freeicon."', ";
$setsql_jang.= "pack2_title = '".$pack2_title."' ";

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

//echo $sql;exit;
$result = query ($sql);












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

#데이콤장부업데이를 위한 임시(기업회원)
/*
function company_pay_ok(){

	global $guin_tb,$oid,$jangboo,$boodong_tb,$option_array_name,$last_date_read,$USER_ID,$CONF,$guin_tb,$ARRAY,$ARRAY_NAME,$ARRAY_NAME2,$jangboo;

	global $real_gap;
	global $happy_member,$happy_member_option_type;


	#장부에 해당저장정보를 읽어오자
	$sql = "select * from $jangboo where or_no='$oid' ";
	$result = query($sql);
	$JANGBOO = happy_mysql_fetch_array($result);


	if ($JANGBOO[in_check] == "1")
	{
		//note_url 로 함수 이동시에는 return 으로 함수 종료만 해야함
		gomsg("이미 입금완료 처리된 내역입니다.   ",'happy_member.php?mode=mypage');
		exit;
	}


	if ($JANGBOO[number] == "")
	{
		//note_url 로 함수 이동시에는 return 으로 함수 종료만 해야함
		gomsg("잘못된 접근입니다   ",'happy_member.php?mode=mypage');
		exit;
	}


	#날짜정보를 읽어서 업데이트를 실시한다.
	$GET_DAY = split(",",$JANGBOO[goods_name]);

	#장부에 해당정보를 찍자
	$sql = "update $jangboo set in_check = '1' where or_no='$oid'";
	$result2 = query($sql);

	if ( $JANGBOO[member_type] )
	{
		#넘어온 번호로 GUIN_INFO를 구하자
		$sql = "select * from $happy_member where number='$JANGBOO[links_number]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);
	}
	else
	{
		#넘어온 번호로 GUIN_INFO를 구하자
		$sql = "select * from $guin_tb where number='$JANGBOO[links_number]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);
	}

	#NOTI값이 왔다고 가정한다
	#$P_NOTI = "10 : 800|1:2|1:10|1:2|1 : 100|1:2|1 : 100|101|test";
	$JANGBOO[goods_name] = str_replace(" ", "", "$JANGBOO[goods_name]");
	list($guin_banner1,$guin_banner2,$guin_banner3,$guin_bold,$guin_list_hyung,$guin_pick,$guin_ticker,$guin_docview,$guin_docview2,$guin_smspoint,$guin_bgcolor,$guin_freeicon,$guin_uryo1,$guin_uryo2,$guin_uryo3,$guin_uryo4,$guin_uryo5,$guin_jump) = split(",",$JANGBOO[goods_name]);

	list($guin_banner1,$tmp)	= split(":",$guin_banner1);
	list($guin_banner2,$tmp)	= split(":",$guin_banner2);
	list($guin_banner3,$tmp)	= split(":",$guin_banner3);
	list($guin_bold,$tmp)		= split(":",$guin_bold);
	list($guin_list_hyung,$tmp)	= split(":",$guin_list_hyung);
	list($guin_pick,$tmp)		= split(":",$guin_pick);
	list($guin_ticker,$tmp)		= split(":",$guin_ticker);
	list($guin_docview,$tmp)	= split(":",$guin_docview);
	list($guin_docview2,$tmp)	= split(":",$guin_docview2);
	list($guin_smspoint,$tmp)	= split(":",$guin_smspoint);
	#배경색+아이콘 추가됨
	list($guin_bgcolor,$tmp)	= split(":",$guin_bgcolor);
	list($guin_freeicon,$tmp)	= split(":",$guin_freeicon);
	#추가옵션 5개
	list($guin_uryo1,$tmp)	= split(":",$guin_uryo1);
	list($guin_uryo2,$tmp)	= split(":",$guin_uryo2);
	list($guin_uryo3,$tmp)	= split(":",$guin_uryo3);
	list($guin_uryo4,$tmp)	= split(":",$guin_uryo4);
	list($guin_uryo5,$tmp)	= split(":",$guin_uryo5);

	//채용정보 점프
	list($guin_jump,$tmp)	= split(":",$guin_jump);

	if ($JANGBOO[member_type])
	{
		#회원정보에 업데이트 찍자

		//이력서보기기간
		$MemberDataOption['guin_docview'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_docview');
		$MemberDataOption['guin_docview'] = $MemberDataOption['guin_docview'] < $real_gap ? $real_gap : $MemberDataOption['guin_docview'];
		$tmp_guin_docview = $MemberDataOption['guin_docview'] + $guin_docview;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_docview',$tmp_guin_docview,'int(11)');

		//이력서보기회수
		$MemberDataOption['guin_docview2'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_docview2');
		$tmp_guin_docview2 = $MemberDataOption['guin_docview2'] + $guin_docview2;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_docview2',$tmp_guin_docview2,'int(11)');

		//sms발송포인트
		$MemberDataOption['guin_smspoint'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_smspoint');
		$guin_smspoint2 = $MemberDataOption['guin_smspoint'] + $guin_smspoint;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_smspoint',$guin_smspoint2,'int(11)');


		//채용정보 점프
		$MemberDataOption['guin_jump'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_jump');
		$guin_jump2 = $MemberDataOption['guin_jump'] + $guin_jump;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_jump',$guin_jump2,'int(11)');

	}
	else
	{
		#guin 정보를 업데이트 한다.
		if ( $CONF['guin_banner1_option'] == '기간별' )
		{
			$DETAIL['guin_banner1']		= $DETAIL['guin_banner1'] < $real_gap ? $real_gap : $DETAIL['guin_banner1'];
		}
		else
		{
			$DETAIL['guin_banner1']		= $DETAIL['guin_banner1'] < 0 ? 0 : $DETAIL['guin_banner1'];
		}

		if ( $CONF['guin_banner2_option'] == '기간별' )
		{
			$DETAIL['guin_banner2']		= $DETAIL['guin_banner2'] < $real_gap ? $real_gap : $DETAIL['guin_banner2'];
		}
		else
		{
			$DETAIL['guin_banner2']		= $DETAIL['guin_banner2'] < 0 ? 0 : $DETAIL['guin_banner2'];
		}

		if ( $CONF['guin_banner3_option'] == '기간별' )
		{
			$DETAIL['guin_banner3']		= $DETAIL['guin_banner3'] < $real_gap ? $real_gap : $DETAIL['guin_banner3'];
		}
		else
		{
			$DETAIL['guin_banner3']		= $DETAIL['guin_banner3'] < 0 ? 0 : $DETAIL['guin_banner3'];
		}

		if ( $CONF['guin_bold_option'] == '기간별' )
		{
			$DETAIL['guin_bold']		= $DETAIL['guin_bold'] < $real_gap ? $real_gap : $DETAIL['guin_bold'];
		}
		else
		{
			$DETAIL['guin_bold']		= $DETAIL['guin_bold'] < 0 ? 0 : $DETAIL['guin_bold'];
		}

		if ( $CONF['guin_list_hyung_option'] == '기간별' )
		{
			$DETAIL['guin_list_hyung']	= $DETAIL['guin_list_hyung'] < $real_gap ? $real_gap : $DETAIL['guin_list_hyung'];
		}
		else
		{
			$DETAIL['guin_list_hyung']	= $DETAIL['guin_list_hyung'] < 0 ? 0 : $DETAIL['guin_list_hyung'];
		}

		if ( $CONF['guin_pick_option'] == '기간별' )
		{
			$DETAIL['guin_pick']		= $DETAIL['guin_pick'] < $real_gap ? $real_gap : $DETAIL['guin_pick'];
		}
		else
		{
			$DETAIL['guin_pick']		= $DETAIL['guin_pick'] < 0 ? 0 : $DETAIL['guin_pick'];
		}

		if ( $CONF['guin_ticker_option'] == '기간별' )
		{
			$DETAIL['guin_ticker']		= $DETAIL['guin_ticker'] < $real_gap ? $real_gap : $DETAIL['guin_ticker'];
		}
		else
		{
			$DETAIL['guin_ticker']		= $DETAIL['guin_ticker'] < 0 ? 0 : $DETAIL['guin_ticker'];
		}

		#배경색+아이콘 추가됨
		if ( $CONF['guin_bgcolor_com_option'] == '기간별' )
		{
			$DETAIL['guin_bgcolor_com']		= $DETAIL['guin_bgcolor_com'] < $real_gap ? $real_gap : $DETAIL['guin_bgcolor_com'];
		}
		else
		{
			$DETAIL['guin_bgcolor_com']		= $DETAIL['guin_bgcolor_com'] < 0 ? 0 : $DETAIL['guin_bgcolor_com'];
		}

		#아이콘
		if ( $CONF['freeicon_comDate_option'] == '기간별' )
		{
			$DETAIL['freeicon_comDate']		= $DETAIL['freeicon_comDate'] < $real_gap ? $real_gap : $DETAIL['freeicon_comDate'];
		}
		else
		{
			$DETAIL['freeicon_comDate']		= $DETAIL['freeicon_comDate'] < 0 ? 0 : $DETAIL['freeicon_comDate'];
		}

		#추가5개
		if ( $CONF['guin_uryo1_option'] == '기간별' )
		{
			$DETAIL['guin_uryo1']		= $DETAIL['guin_uryo1'] < $real_gap ? $real_gap : $DETAIL['guin_uryo1'];
		}
		else
		{
			$DETAIL['guin_uryo1']		= $DETAIL['guin_uryo1'] < 0 ? 0 : $DETAIL['guin_uryo1'];
		}
		if ( $CONF['guin_uryo2_option'] == '기간별' )
		{
			$DETAIL['guin_uryo2']		= $DETAIL['guin_uryo2'] < $real_gap ? $real_gap : $DETAIL['guin_uryo2'];
		}
		else
		{
			$DETAIL['guin_uryo2']		= $DETAIL['guin_uryo2'] < 0 ? 0 : $DETAIL['guin_uryo2'];
		}
		if ( $CONF['guin_uryo3_option'] == '기간별' )
		{
			$DETAIL['guin_uryo3']		= $DETAIL['guin_uryo3'] < $real_gap ? $real_gap : $DETAIL['guin_uryo3'];
		}
		else
		{
			$DETAIL['guin_uryo3']		= $DETAIL['guin_uryo3'] < 0 ? 0 : $DETAIL['guin_uryo3'];
		}
		if ( $CONF['guin_uryo4_option'] == '기간별' )
		{
			$DETAIL['guin_uryo4']		= $DETAIL['guin_uryo4'] < $real_gap ? $real_gap : $DETAIL['guin_uryo4'];
		}
		else
		{
			$DETAIL['guin_uryo4']		= $DETAIL['guin_uryo4'] < 0 ? 0 : $DETAIL['guin_uryo4'];
		}
		if ( $CONF['guin_uryo5_option'] == '기간별' )
		{
			$DETAIL['guin_uryo5']		= $DETAIL['guin_uryo5'] < $real_gap ? $real_gap : $DETAIL['guin_uryo5'];
		}
		else
		{
			$DETAIL['guin_uryo5']		= $DETAIL['guin_uryo5'] < 0 ? 0 : $DETAIL['guin_uryo5'];
		}

		$guin_banner1		= $DETAIL['guin_banner1'] + $guin_banner1;
		$guin_banner2		= $DETAIL['guin_banner2'] + $guin_banner2;
		$guin_banner3		= $DETAIL['guin_banner3'] + $guin_banner3;
		$guin_bold			= $DETAIL['guin_bold'] + $guin_bold;
		$guin_list_hyung	= $DETAIL['guin_list_hyung'] + $guin_list_hyung;
		$guin_pick			= $DETAIL['guin_pick'] + $guin_pick;
		$guin_ticker		= $DETAIL['guin_ticker'] + $guin_ticker;
		#배경색+아이콘 추가됨
		$guin_bgcolor		= $DETAIL['guin_bgcolor_com'] + $guin_bgcolor;
		$freeicon_comDate		= $DETAIL['freeicon_comDate'] + $guin_freeicon;
		#추가5개
		$guin_uryo1 = $DETAIL['guin_uryo1'] + $guin_uryo1;
		$guin_uryo2 = $DETAIL['guin_uryo2'] + $guin_uryo2;
		$guin_uryo3 = $DETAIL['guin_uryo3'] + $guin_uryo3;
		$guin_uryo4 = $DETAIL['guin_uryo4'] + $guin_uryo4;
		$guin_uryo5 = $DETAIL['guin_uryo5'] + $guin_uryo5;


		$sql = "update $guin_tb set
		guin_banner1 = '$guin_banner1',
		guin_banner2 = '$guin_banner2',
		guin_banner3 = '$guin_banner3',
		guin_bold  = '$guin_bold',
		guin_list_hyung   = '$guin_list_hyung',
		guin_pick   = '$guin_pick',
		guin_ticker = '$guin_ticker',
		guin_bgcolor_com = '$guin_bgcolor',
		freeicon_comDate = '$freeicon_comDate',
		guin_uryo1 = '$guin_uryo1',
		guin_uryo2 = '$guin_uryo2',
		guin_uryo3 = '$guin_uryo3',
		guin_uryo4 = '$guin_uryo4',
		guin_uryo5 = '$guin_uryo5'
		where number='$JANGBOO[links_number]'";
		#print $sql;
		#exit;
		query($sql);
	}

}
*/

#결제금액이 0원일경우 바로 입금처리
if ( !$total_price || $total_price == 0 )
{
/*
	#날짜정보를 읽어서 업데이트를 실시한다.
	$GET_DAY = split(",",$JANGBOO[goods_name]);
	#장부에 해당정보를 찍자
	$sql = "update $jangboo set in_check = '1' where or_no='$gou_number'";
	$result2 = query($sql);
*/
	/*
	#넘어온 번호로 GUIN_INFO를 구하자
	$sql = "select * from $happy_member where number='$JANGBOO[links_number]'";
	$result = query($sql);
	$MEMBER = happy_mysql_fetch_array($result);
	*/
/*
	#넘어온 번호로 GUIN_INFO를 구하자
	$sql = "select * from $guin_tb where number='$JANGBOO[links_number]'";
	$result = query($sql);
	$DETAIL = happy_mysql_fetch_array($result);
*/
	/*
	if ( $JANGBOO["etc2"] == "user" )
	{
		#넘어온 번호로 GUIN_INFO를 구하자
		$sql = "select * from $happy_member where number='$JANGBOO[links_number]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);
	}
	else
	{
		#넘어온 번호로 GUIN_INFO를 구하자
		$sql = "select * from $guin_tb where number='$JANGBOO[links_number]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);
	}
	*/
/*
	#NOTI값이 왔다고 가정한다
	#$P_NOTI = "10 : 800|1:2|1:10|1:2|1 : 100|1:2|1 : 100|101|test";
	$JANGBOO[goods_name] = str_replace(" ", "", "$JANGBOO[goods_name]");
	list($guin_banner1,$guin_banner2,$guin_banner3,$guin_bold,$guin_list_hyung,$guin_pick,$guin_ticker,$guin_docview,$guin_docview2,$guin_smspoint,$guin_bgcolor,$guin_freeicon,$guin_uryo1,$guin_uryo2,$guin_uryo3,$guin_uryo4,$guin_uryo5,$guin_jump) = split(",",$JANGBOO[goods_name]);

	list($guin_banner1,$tmp)	= split(":",$guin_banner1);
	list($guin_banner2,$tmp)	= split(":",$guin_banner2);
	list($guin_banner3,$tmp)	= split(":",$guin_banner3);
	list($guin_bold,$tmp)		= split(":",$guin_bold);
	list($guin_list_hyung,$tmp)	= split(":",$guin_list_hyung);
	list($guin_pick,$tmp)		= split(":",$guin_pick);
	list($guin_ticker,$tmp)		= split(":",$guin_ticker);
	list($guin_docview,$tmp)	= split(":",$guin_docview);
	list($guin_docview2,$tmp)	= split(":",$guin_docview2);
	list($guin_smspoint,$tmp)	= split(":",$guin_smspoint);
	#배경색+아이콘 추가됨
	list($guin_bgcolor,$tmp)	= split(":",$guin_bgcolor);
	list($guin_freeicon,$tmp)	= split(":",$guin_freeicon);
	#추가옵션 5개
	list($guin_uryo1,$tmp)	= split(":",$guin_uryo1);
	list($guin_uryo2,$tmp)	= split(":",$guin_uryo2);
	list($guin_uryo3,$tmp)	= split(":",$guin_uryo3);
	list($guin_uryo4,$tmp)	= split(":",$guin_uryo4);
	list($guin_uryo5,$tmp)	= split(":",$guin_uryo5);

	//채용정보 점프
	list($guin_jump,$tmp)	= split(":",$guin_jump);



	#기간별 때문에 오늘날짜와 비교하여 일단값을 구한다.
	$sql = "select (TO_DAYS(curdate())-TO_DAYS('2005-10-21')) ";
	$result = query($sql);
	list($get_gap) = mysql_fetch_row($result);

	$pay_option = "";
	$j = '0';
	foreach ($ARRAY as $list){
		$list_option = $list . "_option";

		if ($CONF[$list_option] == '기간별') {
			#날짜가 마이너스인 사람은 광고가 끝인사람임
			$DETAIL[$list] = $DETAIL[$list] - $get_gap;
		}

		if ($DETAIL[$list] < 0 && $CONF[$list_option] == '기간별'){
			#마이너스는 기간별이외 생길수가 없다.
			$$ARRAY[$j] = $$ARRAY[$j] + $get_gap  ;
		}

		#print "$CONF[$list_option] $ARRAY[$j]" . $$ARRAY[$j] . "// $DETAIL[$list]남음  ($get_gap)<br>";
		$j++;
	}




	#회원정보에 업데이트 찍자

	//이력서보기기간
	$MemberDataOption['guin_docview'] = happy_member_option_get($happy_member_option_type,$member_id,'guin_docview');
	$tmp_guin_docview = $MemberDataOption['guin_docview'] + $guin_docview;

	happy_member_option_set($happy_member_option_type,$member_id,'guin_docview',$tmp_guin_docview,'int(11)');

	//이력서보기회수
	$MemberDataOption['guin_docview2'] = happy_member_option_get($happy_member_option_type,$member_id,'guin_docview2');
	$tmp_guin_docview2 = $MemberDataOption['guin_docview2'] + $guin_docview2;

	happy_member_option_set($happy_member_option_type,$member_id,'guin_docview2',$tmp_guin_docview2,'int(11)');

	//sms발송포인트
	$MemberDataOption['sms_point'] = happy_member_option_get($happy_member_option_type,$member_id,'sms_point');
	$guin_smspoint2 = $MemberDataOption['sms_point'] + $guin_smspoint;

	happy_member_option_set($happy_member_option_type,$member_id,'sms_point',$guin_smspoint2,'int(11)');

	//채용정보 점프
	$MemberDataOption['guin_jump'] = happy_member_option_get($happy_member_option_type,$member_id,'guin_jump');
	$guin_jump2 = $MemberDataOption['guin_jump'] + $guin_jump;

	happy_member_option_set($happy_member_option_type,$member_id,'guin_jump',$guin_jump2,'int(11)');

	#guin 정보를 업데이트 한다.
	$sql = "update $guin_tb set
					guin_banner1 = guin_banner1+'$guin_banner1',
					guin_banner2 = guin_banner2+'$guin_banner2',
					guin_banner3 = guin_banner3+'$guin_banner3',
					guin_bold  = guin_bold+'$guin_bold',
					guin_list_hyung   = guin_list_hyung+'$guin_list_hyung',
					guin_pick   = guin_pick+'$guin_pick',
					guin_ticker = guin_ticker+'$guin_ticker',
					guin_bgcolor_com = guin_bgcolor_com + '$guin_bgcolor',
					freeicon_comDate = freeicon_comDate + '$guin_freeicon',
					guin_uryo1 = guin_uryo1 + '$guin_uryo1',
					guin_uryo2 = guin_uryo2 + '$guin_uryo2',
					guin_uryo3 = guin_uryo3 + '$guin_uryo3',
					guin_uryo4 = guin_uryo4 + '$guin_uryo4',
					guin_uryo5 = guin_uryo5 + '$guin_uryo5'
					where number='$JANGBOO[links_number]'";
	#print $sql;
	query($sql);
*/

	/*
	if ($JANGBOO[member_type])
	{
		#회원정보에 업데이트 찍자

		//이력서보기기간
		$MemberDataOption['guin_docview'] = happy_member_option_get($happy_member_option_type,$member_id,'guin_docview');
		$tmp_guin_docview = $MemberDataOption['guin_docview'] + $guin_docview;

		happy_member_option_set($happy_member_option_type,$member_id,'guin_docview',$tmp_guin_docview,'int(11)');

		//이력서보기회수
		$MemberDataOption['guin_docview2'] = happy_member_option_get($happy_member_option_type,$member_id,'guin_docview2');
		$tmp_guin_docview2 = $MemberDataOption['guin_docview2'] + $guin_docview2;

		happy_member_option_set($happy_member_option_type,$member_id,'guin_docview2',$tmp_guin_docview2,'int(11)');

		//sms발송포인트
		$MemberDataOption['sms_point'] = happy_member_option_get($happy_member_option_type,$member_id,'sms_point');
		$guin_smspoint2 = $MemberDataOption['sms_point'] + $guin_smspoint;

		happy_member_option_set($happy_member_option_type,$member_id,'sms_point',$guin_smspoint2,'int(11)');

		//채용정보 점프
		$MemberDataOption['guin_jump'] = happy_member_option_get($happy_member_option_type,$member_id,'guin_jump');
		$guin_jump2 = $MemberDataOption['guin_jump'] + $guin_jump;

		happy_member_option_set($happy_member_option_type,$member_id,'guin_jump',$guin_jump2,'int(11)');

	}
	else
	{
		#guin 정보를 업데이트 한다.
		$sql = "update $guin_tb set
						guin_banner1 = guin_banner1+'$guin_banner1',
						guin_banner2 = guin_banner2+'$guin_banner2',
						guin_banner3 = guin_banner3+'$guin_banner3',
						guin_bold  = guin_bold+'$guin_bold',
						guin_list_hyung   = guin_list_hyung+'$guin_list_hyung',
						guin_pick   = guin_pick+'$guin_pick',
						guin_ticker = guin_ticker+'$guin_ticker',
						guin_bgcolor_com = guin_bgcolor_com + '$guin_bgcolor',
						freeicon_comDate = freeicon_comDate + '$guin_freeicon',
						guin_uryo1 = guin_uryo1 + '$guin_uryo1',
						guin_uryo2 = guin_uryo2 + '$guin_uryo2',
						guin_uryo3 = guin_uryo3 + '$guin_uryo3',
						guin_uryo4 = guin_uryo4 + '$guin_uryo4',
						guin_uryo5 = guin_uryo5 + '$guin_uryo5'
						where number='$JANGBOO[links_number]'";
		#print $sql;
		query($sql);
	}
	*/
	$oid = $gou_number;
	company_pay_ok();

	if ( $type != 'bank_soodong' && $type != 'point' )
	{
		echo "<script>alert('옵션추가가 완료되었습니다.');opener.window.location.href='happy_member.php?mode=mypage';self.close();</script>";
	}
	else
	{
		#등록시에는 메세지 안나오도록
		if ( preg_match("/guin_regist.php/",$_SERVER['HTTP_REFERER']) )
		{
			echo "<script>window.location.href='happy_member.php?mode=mypage';</script>";
		}
		else
		{
			echo "<script>alert('옵션추가가 완료되었습니다.');window.location.href='happy_member.php?mode=mypage';</script>";
		}
	}
}


//아이콘은 출력되도록 미리 넣자
$icon_bg_query			= "";
if ($_POST['freeicon']) {
	$icon_bg_query		= "freeicon_com = '$_POST[freeicon]'";
}

if ($_POST['guin_bgcolor_select']) {
	$icon_bg_query		.= ($icon_bg_query!= '')?",":"";
	$icon_bg_query		.= "guin_bgcolor_select = '$_POST[guin_bgcolor_select]'";
}




if ($_POST['freeicon'] || $_POST['guin_bgcolor_select']) {
	$Sql	= "
			UPDATE
					$guin_tb
			SET
					$icon_bg_query
			WHERE
					number='$JANGBOO[links_number]'
	";
	query($Sql);
}


////////////////////////////////////////////////////////////////////////////////////////////////////
$oid		= $gou_number;    //주문번호
$amount		= $cal_price;  //결제금액
////////////////////////////////////////////////////////////////////////////////////////////////////


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
	$REQ_VAL['pay_type_option']		= "company";

	$REQ_VAL['daoupay_success_page']= $main_url."/"."my_pay_success.php?oid=$oid&respcode=0000";

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

	$total_price = $cal_price;		#다른솔루션과 아래 코드는 같음

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
		company_pay_ok();

		go("my_pay_success.php?type=$type&respcode=0000");
		exit;
	}
}



#데이콤장부업데이를 위한 임시(기업회원)
function company_pay_ok2_bak(){

	global $guin_tb,$oid,$jangboo,$boodong_tb,$option_array_name,$last_date_read,$USER_ID,$CONF,$guin_tb,$ARRAY,$ARRAY_NAME,$ARRAY_NAME2,$jangboo;

	global $real_gap;
	global $happy_member,$happy_member_option_type;


	#장부에 해당저장정보를 읽어오자
	$sql = "select * from $jangboo where or_no='$oid' ";
	$result = query($sql);
	$JANGBOO = happy_mysql_fetch_array($result);


	if ($JANGBOO[in_check] == "1")
	{
		//note_url 로 함수 이동시에는 return 으로 함수 종료만 해야함
		gomsg("이미 입금완료 처리된 내역입니다.   ",'happy_member.php?mode=mypage');
		exit;
	}


	if ($JANGBOO[number] == "")
	{
		//note_url 로 함수 이동시에는 return 으로 함수 종료만 해야함
		gomsg("잘못된 접근입니다   ",'happy_member.php?mode=mypage');
		exit;
	}


	#날짜정보를 읽어서 업데이트를 실시한다.
	$GET_DAY = split(",",$JANGBOO[goods_name]);

	#장부에 해당정보를 찍자
	$sql = "update $jangboo set in_check = '1' where or_no='$oid'";
	$result2 = query($sql);



	#넘어온 번호로 GUIN_INFO를 구하자
	$sql = "select * from $guin_tb where number='$JANGBOO[links_number]'";
	$result = query($sql);
	$DETAIL = happy_mysql_fetch_array($result);

	/*
	if ( $JANGBOO[member_type] )
	{
		#넘어온 번호로 GUIN_INFO를 구하자
		$sql = "select * from $happy_member where number='$JANGBOO[links_number]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);
	}
	else
	{
		#넘어온 번호로 GUIN_INFO를 구하자
		$sql = "select * from $guin_tb where number='$JANGBOO[links_number]'";
		$result = query($sql);
		$DETAIL = happy_mysql_fetch_array($result);
	}
	*/

	#NOTI값이 왔다고 가정한다
	#$P_NOTI = "10 : 800|1:2|1:10|1:2|1 : 100|1:2|1 : 100|101|test";
	$JANGBOO[goods_name] = str_replace(" ", "", "$JANGBOO[goods_name]");
	list($guin_banner1,$guin_banner2,$guin_banner3,$guin_bold,$guin_list_hyung,$guin_pick,$guin_ticker,$guin_docview,$guin_docview2,$guin_smspoint,$guin_bgcolor,$guin_freeicon,$guin_uryo1,$guin_uryo2,$guin_uryo3,$guin_uryo4,$guin_uryo5,$guin_jump) = split(",",$JANGBOO[goods_name]);

	list($guin_banner1,$tmp)	= split(":",$guin_banner1);
	list($guin_banner2,$tmp)	= split(":",$guin_banner2);
	list($guin_banner3,$tmp)	= split(":",$guin_banner3);
	list($guin_bold,$tmp)		= split(":",$guin_bold);
	list($guin_list_hyung,$tmp)	= split(":",$guin_list_hyung);
	list($guin_pick,$tmp)		= split(":",$guin_pick);
	list($guin_ticker,$tmp)		= split(":",$guin_ticker);
	list($guin_docview,$tmp)	= split(":",$guin_docview);
	list($guin_docview2,$tmp)	= split(":",$guin_docview2);
	list($guin_smspoint,$tmp)	= split(":",$guin_smspoint);
	#배경색+아이콘 추가됨
	list($guin_bgcolor,$tmp)	= split(":",$guin_bgcolor);
	list($guin_freeicon,$tmp)	= split(":",$guin_freeicon);
	#추가옵션 5개
	list($guin_uryo1,$tmp)	= split(":",$guin_uryo1);
	list($guin_uryo2,$tmp)	= split(":",$guin_uryo2);
	list($guin_uryo3,$tmp)	= split(":",$guin_uryo3);
	list($guin_uryo4,$tmp)	= split(":",$guin_uryo4);
	list($guin_uryo5,$tmp)	= split(":",$guin_uryo5);

	//채용정보 점프
	list($guin_jump,$tmp)	= split(":",$guin_jump);



	#회원정보에 업데이트 찍자

	//이력서보기기간
	$MemberDataOption['guin_docview'] = happy_member_option_get($happy_member_option_type,$JANGBOO['or_id'],'guin_docview');
	$MemberDataOption['guin_docview'] = $MemberDataOption['guin_docview'] < $real_gap ? $real_gap : $MemberDataOption['guin_docview'];
	$tmp_guin_docview = $MemberDataOption['guin_docview'] + $guin_docview;

	happy_member_option_set($happy_member_option_type,$JANGBOO['or_id'],'guin_docview',$tmp_guin_docview,'int(11)');

	//이력서보기회수
	$MemberDataOption['guin_docview2'] = happy_member_option_get($happy_member_option_type,$JANGBOO['or_id'],'guin_docview2');
	$tmp_guin_docview2 = $MemberDataOption['guin_docview2'] + $guin_docview2;

	happy_member_option_set($happy_member_option_type,$JANGBOO['or_id'],'guin_docview2',$tmp_guin_docview2,'int(11)');

	//sms발송포인트
	$MemberDataOption['guin_smspoint'] = happy_member_option_get($happy_member_option_type,$JANGBOO['or_id'],'guin_smspoint');
	$guin_smspoint2 = $MemberDataOption['guin_smspoint'] + $guin_smspoint;

	happy_member_option_set($happy_member_option_type,$JANGBOO['or_id'],'guin_smspoint',$guin_smspoint2,'int(11)');


	//채용정보 점프
	$MemberDataOption['guin_jump'] = happy_member_option_get($happy_member_option_type,$JANGBOO['or_id'],'guin_jump');
	$guin_jump2 = $MemberDataOption['guin_jump'] + $guin_jump;

	happy_member_option_set($happy_member_option_type,$JANGBOO['or_id'],'guin_jump',$guin_jump2,'int(11)');



	#guin 정보를 업데이트 한다.
	if ( $CONF['guin_banner1_option'] == '기간별' )
	{
		$DETAIL['guin_banner1']		= $DETAIL['guin_banner1'] < $real_gap ? $real_gap : $DETAIL['guin_banner1'];
	}
	else
	{
		$DETAIL['guin_banner1']		= $DETAIL['guin_banner1'] < 0 ? 0 : $DETAIL['guin_banner1'];
	}

	if ( $CONF['guin_banner2_option'] == '기간별' )
	{
		$DETAIL['guin_banner2']		= $DETAIL['guin_banner2'] < $real_gap ? $real_gap : $DETAIL['guin_banner2'];
	}
	else
	{
		$DETAIL['guin_banner2']		= $DETAIL['guin_banner2'] < 0 ? 0 : $DETAIL['guin_banner2'];
	}

	if ( $CONF['guin_banner3_option'] == '기간별' )
	{
		$DETAIL['guin_banner3']		= $DETAIL['guin_banner3'] < $real_gap ? $real_gap : $DETAIL['guin_banner3'];
	}
	else
	{
		$DETAIL['guin_banner3']		= $DETAIL['guin_banner3'] < 0 ? 0 : $DETAIL['guin_banner3'];
	}

	if ( $CONF['guin_bold_option'] == '기간별' )
	{
		$DETAIL['guin_bold']		= $DETAIL['guin_bold'] < $real_gap ? $real_gap : $DETAIL['guin_bold'];
	}
	else
	{
		$DETAIL['guin_bold']		= $DETAIL['guin_bold'] < 0 ? 0 : $DETAIL['guin_bold'];
	}

	if ( $CONF['guin_list_hyung_option'] == '기간별' )
	{
		$DETAIL['guin_list_hyung']	= $DETAIL['guin_list_hyung'] < $real_gap ? $real_gap : $DETAIL['guin_list_hyung'];
	}
	else
	{
		$DETAIL['guin_list_hyung']	= $DETAIL['guin_list_hyung'] < 0 ? 0 : $DETAIL['guin_list_hyung'];
	}

	if ( $CONF['guin_pick_option'] == '기간별' )
	{
		$DETAIL['guin_pick']		= $DETAIL['guin_pick'] < $real_gap ? $real_gap : $DETAIL['guin_pick'];
	}
	else
	{
		$DETAIL['guin_pick']		= $DETAIL['guin_pick'] < 0 ? 0 : $DETAIL['guin_pick'];
	}

	if ( $CONF['guin_ticker_option'] == '기간별' )
	{
		$DETAIL['guin_ticker']		= $DETAIL['guin_ticker'] < $real_gap ? $real_gap : $DETAIL['guin_ticker'];
	}
	else
	{
		$DETAIL['guin_ticker']		= $DETAIL['guin_ticker'] < 0 ? 0 : $DETAIL['guin_ticker'];
	}

	#배경색+아이콘 추가됨
	if ( $CONF['guin_bgcolor_com_option'] == '기간별' )
	{
		$DETAIL['guin_bgcolor_com']		= $DETAIL['guin_bgcolor_com'] < $real_gap ? $real_gap : $DETAIL['guin_bgcolor_com'];
	}
	else
	{
		$DETAIL['guin_bgcolor_com']		= $DETAIL['guin_bgcolor_com'] < 0 ? 0 : $DETAIL['guin_bgcolor_com'];
	}

	#아이콘
	if ( $CONF['freeicon_comDate_option'] == '기간별' )
	{
		$DETAIL['freeicon_comDate']		= $DETAIL['freeicon_comDate'] < $real_gap ? $real_gap : $DETAIL['freeicon_comDate'];
	}
	else
	{
		$DETAIL['freeicon_comDate']		= $DETAIL['freeicon_comDate'] < 0 ? 0 : $DETAIL['freeicon_comDate'];
	}

	#추가5개
	if ( $CONF['guin_uryo1_option'] == '기간별' )
	{
		$DETAIL['guin_uryo1']		= $DETAIL['guin_uryo1'] < $real_gap ? $real_gap : $DETAIL['guin_uryo1'];
	}
	else
	{
		$DETAIL['guin_uryo1']		= $DETAIL['guin_uryo1'] < 0 ? 0 : $DETAIL['guin_uryo1'];
	}
	if ( $CONF['guin_uryo2_option'] == '기간별' )
	{
		$DETAIL['guin_uryo2']		= $DETAIL['guin_uryo2'] < $real_gap ? $real_gap : $DETAIL['guin_uryo2'];
	}
	else
	{
		$DETAIL['guin_uryo2']		= $DETAIL['guin_uryo2'] < 0 ? 0 : $DETAIL['guin_uryo2'];
	}
	if ( $CONF['guin_uryo3_option'] == '기간별' )
	{
		$DETAIL['guin_uryo3']		= $DETAIL['guin_uryo3'] < $real_gap ? $real_gap : $DETAIL['guin_uryo3'];
	}
	else
	{
		$DETAIL['guin_uryo3']		= $DETAIL['guin_uryo3'] < 0 ? 0 : $DETAIL['guin_uryo3'];
	}
	if ( $CONF['guin_uryo4_option'] == '기간별' )
	{
		$DETAIL['guin_uryo4']		= $DETAIL['guin_uryo4'] < $real_gap ? $real_gap : $DETAIL['guin_uryo4'];
	}
	else
	{
		$DETAIL['guin_uryo4']		= $DETAIL['guin_uryo4'] < 0 ? 0 : $DETAIL['guin_uryo4'];
	}
	if ( $CONF['guin_uryo5_option'] == '기간별' )
	{
		$DETAIL['guin_uryo5']		= $DETAIL['guin_uryo5'] < $real_gap ? $real_gap : $DETAIL['guin_uryo5'];
	}
	else
	{
		$DETAIL['guin_uryo5']		= $DETAIL['guin_uryo5'] < 0 ? 0 : $DETAIL['guin_uryo5'];
	}

	$guin_banner1		= $DETAIL['guin_banner1'] + $guin_banner1;
	$guin_banner2		= $DETAIL['guin_banner2'] + $guin_banner2;
	$guin_banner3		= $DETAIL['guin_banner3'] + $guin_banner3;
	$guin_bold			= $DETAIL['guin_bold'] + $guin_bold;
	$guin_list_hyung	= $DETAIL['guin_list_hyung'] + $guin_list_hyung;
	$guin_pick			= $DETAIL['guin_pick'] + $guin_pick;
	$guin_ticker		= $DETAIL['guin_ticker'] + $guin_ticker;
	#배경색+아이콘 추가됨
	$guin_bgcolor		= $DETAIL['guin_bgcolor_com'] + $guin_bgcolor;
	$freeicon_comDate		= $DETAIL['freeicon_comDate'] + $guin_freeicon;
	#추가5개
	$guin_uryo1 = $DETAIL['guin_uryo1'] + $guin_uryo1;
	$guin_uryo2 = $DETAIL['guin_uryo2'] + $guin_uryo2;
	$guin_uryo3 = $DETAIL['guin_uryo3'] + $guin_uryo3;
	$guin_uryo4 = $DETAIL['guin_uryo4'] + $guin_uryo4;
	$guin_uryo5 = $DETAIL['guin_uryo5'] + $guin_uryo5;


	$sql = "update $guin_tb set
	guin_banner1 = '$guin_banner1',
	guin_banner2 = '$guin_banner2',
	guin_banner3 = '$guin_banner3',
	guin_bold  = '$guin_bold',
	guin_list_hyung   = '$guin_list_hyung',
	guin_pick   = '$guin_pick',
	guin_ticker = '$guin_ticker',
	guin_bgcolor_com = '$guin_bgcolor',
	freeicon_comDate = '$freeicon_comDate',
	guin_uryo1 = '$guin_uryo1',
	guin_uryo2 = '$guin_uryo2',
	guin_uryo3 = '$guin_uryo3',
	guin_uryo4 = '$guin_uryo4',
	guin_uryo5 = '$guin_uryo5'
	where number='$JANGBOO[links_number]'";
	#print $sql;
	#exit;
	query($sql);


	/*
	if ($JANGBOO[member_type])
	{
		#회원정보에 업데이트 찍자

		//이력서보기기간
		$MemberDataOption['guin_docview'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_docview');
		$MemberDataOption['guin_docview'] = $MemberDataOption['guin_docview'] < $real_gap ? $real_gap : $MemberDataOption['guin_docview'];
		$tmp_guin_docview = $MemberDataOption['guin_docview'] + $guin_docview;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_docview',$tmp_guin_docview,'int(11)');

		//이력서보기회수
		$MemberDataOption['guin_docview2'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_docview2');
		$tmp_guin_docview2 = $MemberDataOption['guin_docview2'] + $guin_docview2;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_docview2',$tmp_guin_docview2,'int(11)');

		//sms발송포인트
		$MemberDataOption['guin_smspoint'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_smspoint');
		$guin_smspoint2 = $MemberDataOption['guin_smspoint'] + $guin_smspoint;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_smspoint',$guin_smspoint2,'int(11)');


		//채용정보 점프
		$MemberDataOption['guin_jump'] = happy_member_option_get($happy_member_option_type,$DETAIL['user_id'],'guin_jump');
		$guin_jump2 = $MemberDataOption['guin_jump'] + $guin_jump;

		happy_member_option_set($happy_member_option_type,$DETAIL['user_id'],'guin_jump',$guin_jump2,'int(11)');

	}
	else
	{
		#guin 정보를 업데이트 한다.
		if ( $CONF['guin_banner1_option'] == '기간별' )
		{
			$DETAIL['guin_banner1']		= $DETAIL['guin_banner1'] < $real_gap ? $real_gap : $DETAIL['guin_banner1'];
		}
		else
		{
			$DETAIL['guin_banner1']		= $DETAIL['guin_banner1'] < 0 ? 0 : $DETAIL['guin_banner1'];
		}

		if ( $CONF['guin_banner2_option'] == '기간별' )
		{
			$DETAIL['guin_banner2']		= $DETAIL['guin_banner2'] < $real_gap ? $real_gap : $DETAIL['guin_banner2'];
		}
		else
		{
			$DETAIL['guin_banner2']		= $DETAIL['guin_banner2'] < 0 ? 0 : $DETAIL['guin_banner2'];
		}

		if ( $CONF['guin_banner3_option'] == '기간별' )
		{
			$DETAIL['guin_banner3']		= $DETAIL['guin_banner3'] < $real_gap ? $real_gap : $DETAIL['guin_banner3'];
		}
		else
		{
			$DETAIL['guin_banner3']		= $DETAIL['guin_banner3'] < 0 ? 0 : $DETAIL['guin_banner3'];
		}

		if ( $CONF['guin_bold_option'] == '기간별' )
		{
			$DETAIL['guin_bold']		= $DETAIL['guin_bold'] < $real_gap ? $real_gap : $DETAIL['guin_bold'];
		}
		else
		{
			$DETAIL['guin_bold']		= $DETAIL['guin_bold'] < 0 ? 0 : $DETAIL['guin_bold'];
		}

		if ( $CONF['guin_list_hyung_option'] == '기간별' )
		{
			$DETAIL['guin_list_hyung']	= $DETAIL['guin_list_hyung'] < $real_gap ? $real_gap : $DETAIL['guin_list_hyung'];
		}
		else
		{
			$DETAIL['guin_list_hyung']	= $DETAIL['guin_list_hyung'] < 0 ? 0 : $DETAIL['guin_list_hyung'];
		}

		if ( $CONF['guin_pick_option'] == '기간별' )
		{
			$DETAIL['guin_pick']		= $DETAIL['guin_pick'] < $real_gap ? $real_gap : $DETAIL['guin_pick'];
		}
		else
		{
			$DETAIL['guin_pick']		= $DETAIL['guin_pick'] < 0 ? 0 : $DETAIL['guin_pick'];
		}

		if ( $CONF['guin_ticker_option'] == '기간별' )
		{
			$DETAIL['guin_ticker']		= $DETAIL['guin_ticker'] < $real_gap ? $real_gap : $DETAIL['guin_ticker'];
		}
		else
		{
			$DETAIL['guin_ticker']		= $DETAIL['guin_ticker'] < 0 ? 0 : $DETAIL['guin_ticker'];
		}

		#배경색+아이콘 추가됨
		if ( $CONF['guin_bgcolor_com_option'] == '기간별' )
		{
			$DETAIL['guin_bgcolor_com']		= $DETAIL['guin_bgcolor_com'] < $real_gap ? $real_gap : $DETAIL['guin_bgcolor_com'];
		}
		else
		{
			$DETAIL['guin_bgcolor_com']		= $DETAIL['guin_bgcolor_com'] < 0 ? 0 : $DETAIL['guin_bgcolor_com'];
		}

		#아이콘
		if ( $CONF['freeicon_comDate_option'] == '기간별' )
		{
			$DETAIL['freeicon_comDate']		= $DETAIL['freeicon_comDate'] < $real_gap ? $real_gap : $DETAIL['freeicon_comDate'];
		}
		else
		{
			$DETAIL['freeicon_comDate']		= $DETAIL['freeicon_comDate'] < 0 ? 0 : $DETAIL['freeicon_comDate'];
		}

		#추가5개
		if ( $CONF['guin_uryo1_option'] == '기간별' )
		{
			$DETAIL['guin_uryo1']		= $DETAIL['guin_uryo1'] < $real_gap ? $real_gap : $DETAIL['guin_uryo1'];
		}
		else
		{
			$DETAIL['guin_uryo1']		= $DETAIL['guin_uryo1'] < 0 ? 0 : $DETAIL['guin_uryo1'];
		}
		if ( $CONF['guin_uryo2_option'] == '기간별' )
		{
			$DETAIL['guin_uryo2']		= $DETAIL['guin_uryo2'] < $real_gap ? $real_gap : $DETAIL['guin_uryo2'];
		}
		else
		{
			$DETAIL['guin_uryo2']		= $DETAIL['guin_uryo2'] < 0 ? 0 : $DETAIL['guin_uryo2'];
		}
		if ( $CONF['guin_uryo3_option'] == '기간별' )
		{
			$DETAIL['guin_uryo3']		= $DETAIL['guin_uryo3'] < $real_gap ? $real_gap : $DETAIL['guin_uryo3'];
		}
		else
		{
			$DETAIL['guin_uryo3']		= $DETAIL['guin_uryo3'] < 0 ? 0 : $DETAIL['guin_uryo3'];
		}
		if ( $CONF['guin_uryo4_option'] == '기간별' )
		{
			$DETAIL['guin_uryo4']		= $DETAIL['guin_uryo4'] < $real_gap ? $real_gap : $DETAIL['guin_uryo4'];
		}
		else
		{
			$DETAIL['guin_uryo4']		= $DETAIL['guin_uryo4'] < 0 ? 0 : $DETAIL['guin_uryo4'];
		}
		if ( $CONF['guin_uryo5_option'] == '기간별' )
		{
			$DETAIL['guin_uryo5']		= $DETAIL['guin_uryo5'] < $real_gap ? $real_gap : $DETAIL['guin_uryo5'];
		}
		else
		{
			$DETAIL['guin_uryo5']		= $DETAIL['guin_uryo5'] < 0 ? 0 : $DETAIL['guin_uryo5'];
		}

		$guin_banner1		= $DETAIL['guin_banner1'] + $guin_banner1;
		$guin_banner2		= $DETAIL['guin_banner2'] + $guin_banner2;
		$guin_banner3		= $DETAIL['guin_banner3'] + $guin_banner3;
		$guin_bold			= $DETAIL['guin_bold'] + $guin_bold;
		$guin_list_hyung	= $DETAIL['guin_list_hyung'] + $guin_list_hyung;
		$guin_pick			= $DETAIL['guin_pick'] + $guin_pick;
		$guin_ticker		= $DETAIL['guin_ticker'] + $guin_ticker;
		#배경색+아이콘 추가됨
		$guin_bgcolor		= $DETAIL['guin_bgcolor_com'] + $guin_bgcolor;
		$freeicon_comDate		= $DETAIL['freeicon_comDate'] + $guin_freeicon;
		#추가5개
		$guin_uryo1 = $DETAIL['guin_uryo1'] + $guin_uryo1;
		$guin_uryo2 = $DETAIL['guin_uryo2'] + $guin_uryo2;
		$guin_uryo3 = $DETAIL['guin_uryo3'] + $guin_uryo3;
		$guin_uryo4 = $DETAIL['guin_uryo4'] + $guin_uryo4;
		$guin_uryo5 = $DETAIL['guin_uryo5'] + $guin_uryo5;


		$sql = "update $guin_tb set
		guin_banner1 = '$guin_banner1',
		guin_banner2 = '$guin_banner2',
		guin_banner3 = '$guin_banner3',
		guin_bold  = '$guin_bold',
		guin_list_hyung   = '$guin_list_hyung',
		guin_pick   = '$guin_pick',
		guin_ticker = '$guin_ticker',
		guin_bgcolor_com = '$guin_bgcolor',
		freeicon_comDate = '$freeicon_comDate',
		guin_uryo1 = '$guin_uryo1',
		guin_uryo2 = '$guin_uryo2',
		guin_uryo3 = '$guin_uryo3',
		guin_uryo4 = '$guin_uryo4',
		guin_uryo5 = '$guin_uryo5'
		where number='$JANGBOO[links_number]'";
		#print $sql;
		#exit;
		query($sql);
	}
	*/

}


?>