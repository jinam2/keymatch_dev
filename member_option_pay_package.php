<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");


//member_check(); #서버부하↑


if ( !happy_member_secure( '패키지유료옵션' ) )
{
	error('접속권한이 없습니다.');
	exit;
}


//$category_info = category_read();

$gou_number = $mem_id . "-" . happy_mktime();


//기업회원
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

	//패키지권으로 추가된 설정 2011-06-23 kad
	//회원관련 유료옵션 분리
	$member_options				= array('guin_docview','guin_docview2','guin_smspoint','guin_jump');
	//회원테이블에 있는 유료옵션
	$member_option_pertb		=  array('guin_docview','guin_docview2','guin_smspoint','guin_jump');
	//패키지권으로 추가된 설정 2011-06-23 kad



	$pay_type = "";
	$plus .= "&pay_type=".urlencode($pay_type);

	$contents_template = "member_option_pay_package.html";
}
//개인회원
else
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

	$contents_template = "member_option_pay_package_person.html";
}

//echo $contents_template;



$Member			= happy_member_information($mem_id);
$member_group	= $Member['group'];

if ($_GET[id])
{
	$Template_Default = $HOME[minihome_template];
}
else
{
	# 유저그룹별 껍데기 파일 추출	2010-06-29 ralear
	$sql				= "select * from $happy_member_group where number='$member_group' ";
	$result				= query($sql);
	$Data				= happy_mysql_fetch_array($result);
	$Template_Default	= $Data['mypage_default'];
}


//패키지 유료옵션
$sql = "select * from $job_money_package where 1=1 and is_use = '1' and pay_type = '$pay_type' order by number desc";
$result = query($sql);
$Datas = array();
while($Data = happy_mysql_fetch_assoc($result))
{
	$OutData['title'] = $Data['title'];
	$OutData['comment'] = $Data['comment'];
	$package_data = $Data['number']."|".$Data['price'];
	$OutData['chk_pay'] = '<span class="h_form"><label class="h-check"><input type="checkbox" name="package_product[]" id="package_product[]" value="'.$package_data.'" style="cursor:pointer" onclick="figure();"><span></span></label></span>';
	$OutData['price_comma'] = number_format($Data['price']);

	$OutData['uryo_detail'] = uryo_title_convert($Data['uryo_detail']);
	$OutData['배경색상RGB'] = $배경색상RGB;
	array_push($Datas,$OutData);
}


//현재 채용정보광고 개수
if ( $pay_type == "" )
{
	if ( is_array($ARRAY) )
	{
		$Count = array();
		$i = 0;
		foreach($ARRAY as $k => $v)
		{

			if ( !in_array($v,$member_options ) )
			{
				$tmp_field_name = $v;

				//echo $v.":".$CONF[$v."_option"].":".$CONF[$v."_use"].":".$CONF[$v]."<br>";
				$Count[$v."_style"] = ' ';

				if ( $CONF[$v] != "" && $CONF[$v."_use"] != "사용안함" )
				{
					$opt_name = $v."_option";
					if ( $CONF[$opt_name] == "기간별" )
					{
						$opt_type = "기간별";
					}
					else if ( $CONF[$opt_name] == "노출별" )
					{
						$opt_type = "회수별";
					}
					else if ( $CONF[$opt_name] == "클릭별" )
					{
						$opt_type = "회수별";
					}
					else if ( $CONF[$opt_name] == "이력서수" )
					{
						$opt_type = "회수별";
					}
					else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
					{
						$opt_type = "회수별";
					}
					else
					{
						$opt_type = "회수별";
					}


					if ( $opt_type == "기간별" )
					{
						$sql = "select count(*) from $guin_tb where ".$tmp_field_name." >= $real_gap ".$view_where;
					}
					else if ( $opt_type == "회수별" )
					{
						$sql = "select count(*) from $guin_tb where ".$tmp_field_name." >= 0 ".$view_where;
					}

					//echo $sql."<br>";

					$result = query($sql);
					list($cur_cnt) = happy_mysql_fetch_array($result);
					$Count[$v."_cnt"] = number_format($cur_cnt);

					$Count[$v."_max_cnt"] = number_format($CONF[$v."_max"]);

					$Count[$v] = $ARRAY_NAME[$i];
				}
				else
				{
					$Count[$v."_style"] = ' style="display:none;" ';
				}
			}


			$i++;
		}
	}
	//print_r($Count);
}
//현재 채용정보광고 개수


	//프레임 / 처리 통합결제모듈 ranksa
	$pay_button_script = "";

	if( $_COOKIE['happy_mobile'] != 'on' )
	{
		$pay_frame = '<iframe width="500" height="300" name="pay_page" id="pay_page" style="display:;"></iframe>';
		$pay_button_script = 'myform.target = "pay_page";';
	}

	//결제요청시 팝업 및 프레임 처리




#결재 자바스크립트
$pay_java = <<<END
<script language="javascript">
function cashReturn(numValue){
//numOnly함수에 마지막 파라미터를 true로 주고 numOnly를 부른다.
var cashReturn = "";
for (var i = numValue.length-1; i >= 0; i--){
cashReturn = numValue.charAt(i) + cashReturn;
if (i != 0 && i%3 == numValue.length%3) cashReturn = "," + cashReturn;
}
return cashReturn;
}
function figure() {

	total = 0;
	cnt = document.getElementsByName("package_product[]").length;
	for(i=0;i<cnt;i++)
	{
		if ( document.getElementsByName("package_product[]")[i].checked == true )
		{
			tmp_var = document.getElementsByName("package_product[]")[i].value.split("|");
			total += parseInt(tmp_var[1]);
		}
	}

	document.payform.total.value = total;
	document.payform.total_price.value = total;
	document.payform.total.value = cashReturn(document.payform.total.value);
}
</script>

<script language="javascript">

	function on_click_phone_pay()
	{
		myform = document.payform;

		if ( myform.total_price.value <= 0 )
		{
			alert("선택한 옵션이 없습니다.");
			return;
		}
		else
		{
			$pay_button_script

			myform.action = "my_pay_package.php?type=phone&pay_type=$pay_type";
			myform.submit();
		}
	}


	function on_click_card_pay()
	{
		myform = document.payform;
		if ( myform.total_price.value <= 0 )
		{
			alert("선택한 옵션이 없습니다.");
			return;
		}
		else
		{
			$pay_button_script

			myform.action = "my_pay_package.php?type=card&pay_type=$pay_type";
			myform.submit();
		}
	}


	function on_click_bank_pay()
	{
		myform = document.payform;
		if ( myform.total_price.value <= 0 )
		{
			alert("선택한 옵션이 없습니다.");
			return;
		}
		else
		{

			$pay_button_script

			myform.action = "my_pay_package.php?type=bank&pay_type=$pay_type";
			myform.submit();
		}

	}

	function on_click_bank_soodong_pay()
	{
		myform = document.payform;

		if ( myform.total_price.value <= 0 )
		{
			alert("선택한 옵션이 없습니다.");
			return;
		}
		else
		{
			myform.target = "_top";
			myform.action = "my_pay_package.php?type=bank_soodong&pay_type=$pay_type";
			myform.submit();
		}
	}

	function on_click_point_pay()
	{
		myform = document.payform;
		if ( myform.total_price.value <= 0 )
		{
			alert("선택한 옵션이 없습니다.");
			return;
		}
		else
		{
			myform.target = "_top";
			myform.action = "my_pay_package.php?type=point&pay_type=$pay_type";
			myform.submit();
		}
	}

</script>

	$pay_frame
END;

#결재방식을 찾자.
if( $_COOKIE['happy_mobile'] == 'on' )
{
	if ($CONF[bank_conf_mobile])
	{
	$PAY[bank] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><input type='button' value='실시간 계좌이체' onclick="on_click_bank_pay()" >
END;
	}

	if ($CONF[card_conf_mobile])
	{
	$PAY[card] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><input type='button'  value='신용카드 결제' onclick="on_click_card_pay()">
END;
	}

	if ($CONF[phone_conf_mobile])
	{
	$PAY[phone] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><input type='button'  value='휴대폰 결제' onclick="on_click_phone_pay()">
END;
	}

	if ($CONF[bank_soodong_conf_mobile])
	{
	$PAY[bank_soodong] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><input type='button' value='무통장 입금' onclick="on_click_bank_soodong_pay()">
END;
	}

	if ($CONF[point_conf_mobile])
	{
	$PAY[point] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><input type='button' value='포인트 결제' onclick="on_click_point_pay()">
END;
	}
}
else
{
	if ($CONF[bank_conf])
	{
	$PAY[bank] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><span class="basic_btn_st01 font_18 noto500" onclick="on_click_bank_pay()">실시간 계좌이체</span>
END;
	}

	if ($CONF[card_conf])
	{
	$PAY[card] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><span class="basic_btn_st01 font_18 noto500" onclick="on_click_card_pay()">신용카드 결제</span>
END;
	}

	if ($CONF[phone_conf])
	{
	$PAY[phone] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><span class="basic_btn_st01 font_18 noto500" onclick="on_click_phone_pay()">휴대폰 결제</span>
END;
	}

	if ($CONF[bank_soodong_conf])
	{
	$PAY[bank_soodong] =<<<END
	<input type=hidden name=number value=$DETAIL[number]><span class="basic_btn_st01 font_18 noto500" onclick="on_click_bank_soodong_pay()">무통장 입금</span>
END;
	}

	if ($CONF[point_conf])
	{
	$PAY[point] =<<<END
	 <input type=hidden name=number value=$DETAIL[number]><span class="basic_btn_st01 font_18 noto500" onclick="on_click_point_pay()">포인트 결제</span>
END;
	}
}

if ($demo)
{
	$msg = "<img src=img/dot.gif width=20><font color=blue>데모버젼에서는 실제결재가 되지 않으오니 안심하시고 결재를 끝가지 진행하셔도 됩니다.</font><br> ";
}



if ( !is_file("$skin_folder/$contents_template") )
{
	echo "$skin_folder/$contents_template 파일이 존재하지 않습니다.";
	exit;
}

if ( !is_file("$skin_folder/$Template_Default") )
{
	echo "$skin_folder/$Template_Default 파일이 존재하지 않습니다.";
	exit;
}


//템플릿 파일 읽어오기
$TPL->define("결재폼", "$skin_folder/$contents_template");
$TPL->assign("Package", $Datas);
$내용 = &$TPL->fetch();



$TPL->define("출력", "$skin_folder/$Template_Default");
$TPL->tprint();
$exec_time = array_sum(explode(' ', microtime())) - $t_start;
$exec_time = round ($exec_time, 2);
$쿼리시간 =  "Query Time : $exec_time sec";
if ($print_query_time)
{
	print "<center><font color=gray style='font-size:11px' face=arial>$쿼리시간</font>";
}



	//부동산 유료옵션 이름
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

					$return_str.= $type_icon." ".$uryo_name." ".$tmp_a2[1].$Uryo['uryo_danwi'];
					$return_str.= " X ".$tmp_a2[2]."회<br>";
				}

				$i++;
			}
		}

		return $return_str;
	}



?>