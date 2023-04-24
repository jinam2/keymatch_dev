<?php
	$t_start = array_sum(explode(' ', microtime()));

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	#포인트 충전사용여부 - sun
	if ( $HAPPY_CONFIG['point_charge_use'] != "" )
	{
		msgclose("포인트충전 기능은 사용할 수 없습니다.");
		exit;
	}


	if ( happy_member_login_check() == "" )
	{
		msgclose("회원로그인후 사용할수 있는 페이지입니다","index.php");
		exit;
	}
	else
	{
		if ( !happy_member_secure('포인트기능') )
		{
			msgclose('포인트기능'."권한이 없습니다.","index.php");
			exit;
		}
	}

	#고유번호생성
	$gou_number = "$mem_id"."-".happy_mktime();


	//결제요청시 팝업 / 프레임 / 액티브엑스설치 처리 통합결제모듈 ranksa
	$pay_button_script = "";
	$pay_frame = "";
	$activex_script = "";

	if( $_COOKIE['happy_mobile'] != 'on' )
	{
		$pay_frame = '<iframe width="0" height="0" name="pay_page" id="pay_page"></iframe>';
		$pay_button_script = 'myform.target = "pay_page";';
	}

	//결제요청시 팝업 및 프레임 처리



	#포인트는 무통장입금이 없음
	$btn_card = "";
	$btn_bank = "";
	$btn_bank_soodong = "";
	$btn_point = "";
	$btn_phone = "";

	if ( $HAPPY_CONFIG['bank_soodong_conf'] == '1' )
	{
		$btn_bank_soodong = "";
	}

	if( $_COOKIE['happy_mobile'] == 'on' )
	{
		if ( $HAPPY_CONFIG['phone_conf_mobile'] == '1' )
		{
			$btn_phone = '<span class="btn_small_dark" onclick="on_click_phone_pay()" onmouseover="this.style.cursor=\'pointer\'" alt="휴대폰결제">휴대폰결제</span>';
		}

		if ( $HAPPY_CONFIG['card_conf_mobile'] == '1' )
		{
			$btn_card = '<span class="btn_small_dark" onclick="on_click_card_pay()" onmouseover="this.style.cursor=\'pointer\'" alt="카드결제">카드결제</span>';
		}

		if ( $HAPPY_CONFIG['bank_conf_mobile'] == '1' )
		{
			$btn_bank = '<span class="btn_small_dark"  onclick="on_click_bank_pay()" onmouseover="this.style.cursor=\'pointer\'" alt="실시간계좌이체">실시간계좌이체</span>';
		}
	}
	else
	{
		if ( $HAPPY_CONFIG['phone_conf'] == '1' )
		{
			$btn_phone = '<img src="img/pay/phone2.gif" border=0 onclick="on_click_phone_pay()" onmouseover="this.style.cursor=\'pointer\'" alt="휴대폰결제">';
		}

		if ( $HAPPY_CONFIG['card_conf'] == '1' )
		{
			$btn_card = '<img src="img/pay/card2.gif" border=0 onclick="on_click_card_pay()" onmouseover="this.style.cursor=\'pointer\'" alt="카드결제">';
		}

		if ( $HAPPY_CONFIG['bank_conf'] == '1' )
		{
			$btn_bank = '<img src="img/pay/bank2.gif" border=0 onclick="on_click_bank_pay()" onmouseover="this.style.cursor=\'pointer\'" alt="실시간계좌이체">';
		}
	}

	if ( $HAPPY_CONFIG['point_conf'] == '1' )
	{
		$btn_point = "";
	}

	function money_select($string,$name,$option)
	{
		$Select	= "\n<select name='$name' $option style='width:100%; color:#333; background-color:#efefef;'>\n";
		$Select	.= "\t<option value='0'>금액을 선택하세요</option>\n";

		$string	= nl2br($string);
		$Temp	= explode("<br />",$string);

		for ( $i=0,$max=sizeof($Temp) ; $i<$max ; $i++ )
		{
			if ( trim($Temp[$i]) != "" )
			{
				$moneys		= explode(":",str_replace(" ","",$Temp[$i]));
				$moneys[0]	= str_replace("\n","",str_replace("\r","",$moneys[0]));
				$Select	.= "\t<option value='$moneys[0]|$moneys[1]'>".$moneys[0]."포인트 : ". number_format($moneys[1]) ."원</option>\n";
			}
		}

		$Select	.= "</select>\n";

		return $Select;
	}

	$point_select_box = money_select($CONF["money_point"],"total_price","");

	if( !(is_file("$skin_folder/my_point_charge.html")) ) {
		print "$skin_folder/my_point_charge.html 파일이 존재하지 않습니다. ";
		exit;
	}

	if ($demo_lock == '1')
	{
		msg('\n데모버젼에서는 핸드폰결제로 테스트하시면 됩니다.   \n모든 핸드폰번호 및 인증번호는\n1을 모두 입력하세요');
	}

	$TPL->define("본체", "$skin_folder/my_point_charge.html");
    $TPL->tprint();


?>