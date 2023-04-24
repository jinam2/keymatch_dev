<?php
$t_start = array_sum(explode(' ', microtime()));
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/function.php");
include ("./inc/lib.php");
$TPL = new Template;
$category_info = category_read();
$gou_number = $mem_id . "-" . happy_mktime();

if( $mem_id == ""  ) {
gomsg("회원로그인후 사용할수 있는 페이지입니다","./html_file.php?file=login.html&file2=login_default.html");
exit;
}

#매물번호넘어와야함.
if (!($CONF[paid_conf])){
error("유료결재가 활성화된상태가 아닙니다.");
exit;
}




$PAY = array();
for ($i=8;$i<=9;$i++){
	if ($CONF{$conf_array[$i]}){

		$tmp_day = str_replace("-", "", $MEM{$option_array_name[$i]});
		if ($tmp_day < $today){
			$lista = $option_array_name[$i] ."a";
			$lista2 = $option_array_name[$i] . "a2";
			$PAY{$option_array_name[$i]} = "<select name=$option_array_name[$i] onChange=\"figure(document.payform)\" ><option value=''>결재기간선택</option>\n";
			#결재옵션을 붙이고
			$tmp = split("/",$CONF{$conf_array[$i]});
				foreach ($tmp as $list){
				#$list의 잡값을 제거
				list($tmp_day,$tmp_money) = split(",",$list);
				$tmp_day = str_replace(",", "", $tmp_day);
				$tmp_money = str_replace(",", "", $tmp_money);
				$tmp_money_comma = number_format($tmp_money);
				$PAY{$option_array_name[$i]} .= "<option value='$tmp_day|$tmp_money'>$tmp_day"."일"." &nbsp;$tmp_money_comma"."원</option>\n";
				}
			$PAY{$option_array_name[$i]} .= "</select>\n";

			$java_insert .= "
			var $lista = document.payform.$option_array_name[$i].options[document.payform.$option_array_name[$i].selectedIndex].value;
			$lista = $lista.split(\"|\");
			var $lista2 = $lista"."[$lista.length -1];
			";
			$total_plus .= '+' . "($lista2-0)";
		}
		else {
			$PAY{$option_array_name[$i]} = "유료기간중 (".$MEM{$option_array_name[$i]}. "까지)";
		}

	} else {
	$PAY{$option_array_name[$i]} = "무료사용가능";
	}

}



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
	$java_insert

    var total =  	(0) $total_plus  ;
    document.payform.total.value = total;
    document.payform.total_price.value = total;
	document.payform.total.value = cashReturn(document.payform.total.value);
}
</script>

<script language="javascript">

	function on_click_phone_pay()
	{
	myform = document.payform;
	window.name = "BTPG_CLIENT";
	BTPG_WALLET = window.open("", "BTPG_WALLET", "width=450,height=500");
	 BTPG_WALLET.focus();
	myform.target = "BTPG_WALLET";
	myform.action = "my_pay.php?type=phone&target=member";
	myform.submit();
	}


	function on_click_card_pay()
	{
	myform = document.payform;
	window.name = "BTPG_CLIENT";
	BTPG_WALLET = window.open("", "BTPG_WALLET", "width=450,height=500");
	 BTPG_WALLET.focus();
	myform.target = "BTPG_WALLET";
	myform.action = "my_pay.php?type=card&target=member";
	myform.submit();
	}


	function on_click_bank_pay()
	{
	myform = document.payform;
	window.name = "BTPG_CLIENT";
	BTPG_WALLET = window.open("", "BTPG_WALLET", "width=450,height=500");
	 BTPG_WALLET.focus();
	myform.target = "BTPG_WALLET";
	myform.action = "my_pay.php?type=bank&target=member";
	myform.submit();
	}

	function on_click_bank_soodong_pay()
	{
	myform = document.payform;
	myform.target = "_top";
	myform.action = "my_pay.php?type=bank_soodong&target=member";
	myform.submit();
	}

</script>
END;

#결재방식을 찾자.
if ($CONF[bank_conf]){
$PAY[bank] =<<<END
	<input type=hidden name=number value=$MEM[number]>
	<img src=images/pay/bank.gif border=0 onclick="on_click_bank_pay()" onmouseover="this.style.cursor='pointer'">
END;
}

if ($CONF[card_conf]){
$PAY[card] =<<<END
	<input type=hidden name=number value=$MEM[number]>
	<img src=images/pay/card.gif border=0 onclick="on_click_card_pay()" onmouseover="this.style.cursor='pointer'">
END;
}

if ($CONF[phone_conf]){
$PAY[phone] =<<<END
	<input type=hidden name=number value=$MEM[number]>
	<img src=images/pay/phone.gif border=0 onclick="on_click_phone_pay()" onmouseover="this.style.cursor='pointer'">
END;
}

if ($CONF[bank_soodong_conf]){
$PAY[bank_soodong] =<<<END
	<input type=hidden name=number value=$MEM[number]>
	<img src=images/pay/soodong_phone.gif border=0 onclick="on_click_bank_soodong_pay()" onmouseover="this.style.cursor='pointer'">
END;
}

$now_stand = "$prev_stand > <a href=member_index.php>마이페이지</a> > <font color=#417CB0>매물 옵션 유료 결재</font>";

if ($demo){
$msg = "<img src=img/dot.gif width=20><font color=blue>데모버젼에서는 실제결재가 되지 않으오니
안심하시고 결재를 끝가지 진행하셔도 됩니다.</font><br> ";
}

//템플릿 파일 읽어오기
$TPL->define("결재폼", "$skin_folder/member_view_pay.html");
$main_temp = &$TPL->fetch();
$temp = "default.html";
temp("$skin_folder/$temp");
echo "$content";


?>