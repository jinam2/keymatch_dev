<?php
include ("./inc/Template.php");
$TPL = new Template;
include ("./inc/config.php");
include ("./inc/function.php");
include ("./inc/lib.php");

if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] )
{
	gomsg('회원 로그인을 하셔야 합니다.',"./happy_member_login.php?returnUrl=".urlencode($_SERVER['REQUEST_URI']));
	exit;
}

if ( !happy_member_secure($happy_member_secure_text[0].'보기 유료결제') )
{
	gomsg($happy_member_secure_text[0].'보기 유료결제'."권한이 없습니다.","./happy_member.php?mode=mypage");
	exit;
}

#회원아이디를 구한다.
$gou_number = $mem_id . "-" . happy_mktime();

$현재위치 = "$prev_stand > <a href='member_info.php'>마이페이지</a> > <a href='member_option_pay2.php'>열람/SMS서비스</a>";


//결제 페이지로 이동
if ( $mode == "" )
{

	#회사정보뽑기
	$sql	= "select * from $happy_member where user_id='$user_id'";
	$result	= query($sql);
	$COM	= happy_mysql_fetch_array($result);
	$number	= $COM["number"];

	$COM['etc1'] = $COM['photo2'];
	$COM['etc2'] = $COM['photo3'];
	$COM['com_job'] = $COM['extra13'];
	$COM['com_profile1'] = nl2br($COM['message']);
	$COM['com_profile2'] = nl2br($COM['memo']);
	$COM['boss_name'] = $COM['extra11'];
	$COM['com_open_year'] = $COM['extra1'];
	$COM['com_worker_cnt'] = $COM['extra2'];
	$COM['com_zip'] = $COM['user_zip'];
	$COM['com_addr1'] = $COM['user_addr1'];
	$COM['com_addr2'] = $COM['user_addr2'];
	$COM['regi_name'] = $COM['extra12'];
	$COM['com_phone'] = $COM['user_hphone'];
	$COM['com_fax'] = $COM['user_fax'];
	$COM['com_email'] = $COM['user_email'];
	$COM['com_homepage'] = $COM['user_homepage'];

	if ( file_exists ("./$COM[etc1]") && $COM[etc1] != "" )
	{
		$logo_img = explode(".",$COM["etc1"]);
		$logo_temp = $logo_img[0]."_thumb.".$logo_img[1];

		if ( file_exists ("./$logo_temp" ) )
		{
			$COM[logo_temp] = "<img src='./$logo_temp'  align='absmiddle'  border='0'>";
		}
		else
		{
			$COM[logo_temp] = "<img src='./$COM[etc1]' width='$COMLOGO_DST_W[0]' height='$COMLOGO_DST_H[0]' align='absmiddle' border='0'>";
		}
	}
	else
	{
		$COM[logo_temp] = "<img src='./img/logo_img.gif' >";
	}




	#해당하는 유료결재정보를 읽어온다.
	#추천/누네띠네/배너1/배너2/배너3/뉴스티커/등록유료화
	#배너형/좁은배너형/넓은배너형/누네띠네형/리스트형/추천형/뉴스티커형/일반형
	$guin_docview	= explode("\n",$CONF[guin_docview]);
	$guin_docview2	= explode("\n",$CONF[guin_docview2]);
	$guin_smspoint	= explode("\n",$CONF[guin_smspoint]);


	$PAY = array();
	/*
	$PAY[guin_docview] = make_guin_selectbox($guin_docview,"-- $CONF[guin_docview_option] 결재금액선택 --",guin_docview,"이력서보기기간");
	$PAY[guin_docview2] = make_guin_selectbox($guin_docview2,"-- $CONF[guin_docview2_option] 결재금액선택 --",guin_docview2,"이력서보기회");
	$PAY[guin_smspoint] = make_guin_selectbox($guin_smspoint,"-- $CONF[guin_smspoint_option] 결재금액선택 --",guin_smspoint,"SMS발송");
	*/
	$PAY[guin_docview] = make_guin_checkbox_pay($guin_docview,"-- $CONF[guin_docview_option] 결재금액선택 --",guin_docview,"이력서보기기간");
	$PAY[guin_docview2] = make_guin_checkbox_pay($guin_docview2,"-- $CONF[guin_docview2_option] 결재금액선택 --",guin_docview2,"이력서보기회");
	$PAY[guin_smspoint] = make_guin_checkbox_pay($guin_smspoint,"-- $CONF[guin_smspoint_option] 결재금액선택 --",guin_smspoint,"SMS발송");

	$시간 = happy_mktime();




for ($i=7;$i<=9;$i++)
{
	#max 를 구하자
	$tmp_option = $ARRAY[$i] . "_option";
	$tmp_max = $ARRAY[$i] . "_max";


	if ($CONF[$tmp_option] == '기간별')
	{
		$sql = "select count(*) from $happy_member_option where option_field = '".$ARRAY[$i]."' and option_value > $real_gap  ";
		$result = query($sql);
		list($NOW_MAX{$ARRAY[$i]}) = mysql_fetch_row($result);
	}
	else
	{
		$sql = "select count(*) from $happy_member_option where option_field = '".$ARRAY[$i]."' and option_value > '0'  ";
		$result = query($sql);
		list($NOW_MAX{$ARRAY[$i]}) = mysql_fetch_row($result);
	}


	if ($CONF{$ARRAY[$i]} && $CONF[$tmp_max] > $NOW_MAX{$ARRAY[$i]} )
	{
		$lista = $ARRAY[$i] ."a";
		$lista2 = $ARRAY[$i] . "a2";
		/*
		$java_insert .= "
		var $lista = document.payform.$ARRAY[$i].options[document.payform.$ARRAY[$i].selectedIndex].value;
		$lista = $lista.split(\":\");
		var $lista2 = $lista"."[$lista.length -1];
		";
		*/
		$java_insert .= "
			max = \"\";
			max = document.payform.$ARRAY[$i].length;
			//alert('$ARRAY[$i] : ' + max);
			ChkVal = \"0:0\";

			if ( max == undefined )
			{
				if (document.payform.$ARRAY[$i].checked)
				{
					ChkVal = document.payform.$ARRAY[$i].value;
				}
			}
			else
			{
				for ( x=0; x<max; x++)
				{
					//alert('$ARRAY[$i]'+document.payform.$ARRAY[$i][x].value);

					if ( document.payform.$ARRAY[$i][x].checked )
					{
						ChkVal = document.payform.$ARRAY[$i][x].value;
					}
				}
			}

			var $lista = ChkVal;
			$lista = $lista.split(\":\");
			var $lista2 = $lista"."[$lista.length -1];
		";
		$total_plus .= '+' . "($lista2-0)";

	}
	elseif ($CONF{$ARRAY[$i]} && $CONF[$tmp_max] <= $NOW_MAX{$ARRAY[$i]} )
	{
		$PAY{$ARRAY[$i]} = "<font class=small_gray>유료광고 최대건수를 넘었습니다 <br>(" . $NOW_MAX{$ARRAY[$i]} . "건 현재 광고중)</font>";
	}
	else
	{
		$PAY{$ARRAY[$i]} = "유료설정이 되지 않음 ";
	}

}


//채용정보 점프
$style_guin_jump = ' style="display:none;" ';
if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
{
	$style_guin_jump = '';

	$guin_jump	= explode("\n",$CONF['guin_jump']);
	$PAY['guin_jump'] = make_guin_checkbox_pay($guin_jump,"-- $CONF[guin_jump_option] 결재금액선택 --",guin_jump,"클릭별");

	$i = array_search("guin_jump",$ARRAY);

	#max 를 구하자
	$tmp_option = $ARRAY[$i] . "_option";
	$tmp_max = $ARRAY[$i] . "_max";

	$lista = $ARRAY[$i] ."a";
	$lista2 = $ARRAY[$i] . "a2";

	$java_insert .= "
		max = \"\";
		max = document.payform.$ARRAY[$i].length;
		//alert('$ARRAY[$i] : ' + max);
		ChkVal = \"0:0\";

		if ( max == undefined )
		{
			if (document.payform.$ARRAY[$i].checked)
			{
				ChkVal = document.payform.$ARRAY[$i].value;
			}
		}
		else
		{
			for ( x=0; x<max; x++)
			{
				//alert('$ARRAY[$i]'+document.payform.$ARRAY[$i][x].value);

				if ( document.payform.$ARRAY[$i][x].checked )
				{
					ChkVal = document.payform.$ARRAY[$i][x].value;
				}
			}
		}

		var $lista = ChkVal;
		$lista = $lista.split(\":\");
		var $lista2 = $lista"."[$lista.length -1];
	";
	$total_plus .= '+' . "($lista2-0)";

}
//채용정보 점프



//결제요청시 팝업 / 프레임 / 액티브엑스설치 처리 통합결제모듈 ranksa
$pay_button_script = "";
$pay_frame = "";

if( $_COOKIE['happy_mobile'] != 'on' )
{
	$pay_frame = '<iframe width="0" height="0" style="display:none;" name="pay_page" id="pay_page"></iframe>';
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
	$java_insert

    var total =  	(0) $total_plus  ;
    document.payform.total.value = total;
    document.payform.total_price.value = total;
	document.payform.total.value = cashReturn(document.payform.total.value);


	if ( document.payform.out_total )
	{
		document.payform.out_total.value = document.payform.total.value;
	}
}

function SingleCheckBox(chk)
{
	x = document.getElementsByName(chk.name);

	for(i = 0 ; i < x.length ; i++)
	{
		if ( chk != x[i] )
		{
			x[i].checked = false;
		}
	}

	figure();

}

</script>

<script language="javascript">

	function on_click_phone_pay()
	{
		myform = document.payform;

		//폼체크
		cnt = myform.elements.length;
		is_sel = false;

		for ( i = 0; i < cnt ; i++)
		{
			if(myform.elements[i].type == "select-one")
			{
				sel = myform.elements[i].selectedIndex;
				if (myform.elements[i].options[sel].value != "")
				{
					is_sel = true;
					break;
				}
			}
			else if ( myform.elements[i].type == 'checkbox' )
			{
				if ( myform.elements[i].checked == true )
				{
					is_sel = true;
					break;
				}
			}
		}

		if (is_sel == false) {
			alert("옵션을 하나라도 선택을 하셔야만 합니다");
			return;
		}

		$agspay_alert
		$pay_button_script
		myform.action = "my_pay.php?type=phone";
		myform.submit();
	}


	function on_click_card_pay()
	{
		myform = document.payform;

		//폼체크
		cnt = myform.elements.length;
		is_sel = false;

		for ( i = 0; i < cnt ; i++)
		{
			if(myform.elements[i].type == "select-one")
			{
				sel = myform.elements[i].selectedIndex;
				if (myform.elements[i].options[sel].value != "")
				{
					is_sel = true;
					break;
				}
			}
			else if ( myform.elements[i].type == 'checkbox' )
			{
				if ( myform.elements[i].checked == true )
				{
					is_sel = true;
					break;
				}
			}
		}

		if (is_sel == false) {
			alert("옵션을 하나라도 선택을 하셔야만 합니다");
			return;
		}


		$pay_button_script
		myform.action = "my_pay.php?type=card";
		myform.submit();
	}


	function on_click_bank_pay()
	{
		myform = document.payform;

		//폼체크
		cnt = myform.elements.length;
		is_sel = false;

		for ( i = 0; i < cnt ; i++)
		{
			if(myform.elements[i].type == "select-one")
			{
				sel = myform.elements[i].selectedIndex;
				if (myform.elements[i].options[sel].value != "")
				{
					is_sel = true;
					break;
				}
			}
			else if ( myform.elements[i].type == 'checkbox' )
			{
				if ( myform.elements[i].checked == true )
				{
					is_sel = true;
					break;
				}
			}
		}

		if (is_sel == false) {
			alert("옵션을 하나라도 선택을 하셔야만 합니다");
			return;
		}

		$bank_jumin_chk


		$agspay_alert
		$pay_button_script
		myform.action = "my_pay.php?type=bank";
		myform.submit();
	}

	function on_click_bank_soodong_pay()
	{

		myform = document.payform;

		//폼체크
		cnt = myform.elements.length;
		is_sel = false;

		for ( i = 0; i < cnt ; i++)
		{
			if(myform.elements[i].type == "select-one")
			{
				sel = myform.elements[i].selectedIndex;
				if (myform.elements[i].options[sel].value != "")
				{
					is_sel = true;
					break;
				}
			}
			else if ( myform.elements[i].type == 'checkbox' )
			{
				if ( myform.elements[i].checked == true )
				{
					is_sel = true;
					break;
				}
			}
		}

		if (is_sel == false) {
			//alert("옵션을 하나라도 선택을 하셔야만 합니다");
			//return;
		}
		myform.target = "_top";
		myform.action = "my_pay.php?type=bank_soodong";
		myform.submit();
	}

	function on_click_point_pay()
	{

		myform = document.payform;

		//폼체크
		cnt = myform.elements.length;
		is_sel = false;

		for ( i = 0; i < cnt ; i++)
		{
			if(myform.elements[i].type == "select-one")
			{
				sel = myform.elements[i].selectedIndex;
				if (myform.elements[i].options[sel].value != "")
				{
					is_sel = true;
					break;
				}
			}
			else if ( myform.elements[i].type == 'checkbox' )
			{
				if ( myform.elements[i].checked == true )
				{
					is_sel = true;
					break;
				}
			}
		}

		if (is_sel == false) {
			alert("옵션을 하나라도 선택을 하셔야만 합니다");
			return;
		}
		myform.target = "_top";
		myform.action = "my_pay.php?type=point";
		myform.submit();
	}

</script>


	$pay_frame

	<input type=hidden name=total_price value="0">
	<input type=hidden name=id value="$member_id">
	<input type=hidden name=joomin1 value="">
	<input type=hidden name=joomin2 value="">
	<input type=hidden name=email value="$DETAIL[guin_email]">
	<input type=hidden name=hphone_header value="">
	<input type=hidden name=hphone_footer value="">
	<input type=hidden name=select_016 value="selected">
	<input type=hidden name=gou_number value='$gou_number'>

END;

#결재방식을 찾자.
if( $_COOKIE['happy_mobile'] == 'on' )			//모바일 결제버튼
{
	if ($CONF[bank_conf_mobile]){
	$PAY[bank] =<<<END
		<input type=hidden name=number value=$number>
		<input type='button' onclick="on_click_bank_pay()" value='실시간 계좌이체'>
END;
	}

	if ($CONF[card_conf_mobile]){
	$PAY[card] =<<<END
		<input type=hidden name=number value=$number>
		<input type='button' onclick="on_click_card_pay()" value='신용카드 결제'>
END;
	}

	if ($CONF[phone_conf_mobile]){
	$PAY[phone] =<<<END
		<input type=hidden name=number value=$number>
		<input type='button' onclick="on_click_phone_pay()" value='휴대폰 결제'>
END;
	}

	if ($CONF[bank_soodong_conf_mobile]){
	$PAY[bank_soodong] =<<<END
		<input type=hidden name=number value=$number>
		<input type='button' onclick="on_click_bank_soodong_pay()" value='무통장 입금'>
END;
	}

	if ($CONF[point_conf_mobile]){
	$PAY[point] =<<<END
		<input type=hidden name=number value=$number>
		<input type="button" onclick="on_click_point_pay()" value='포인트 결제'>
END;
	}
}
else										//PC 결제버튼
{
	if ($CONF[bank_conf]){
	$PAY[bank] =<<<END
		<input type=hidden name=number value=$number>
		<img src=img/btn_pay_realmoney.gif border=0 onclick="on_click_bank_pay()" onmouseover="this.style.cursor='pointer'" align=absmiddle>
END;
	}

	if ($CONF[card_conf]){
	$PAY[card] =<<<END
		<input type=hidden name=number value=$number>
		<img src=img/btn_pay_card.gif border=0 onclick="on_click_card_pay()" onmouseover="this.style.cursor='pointer'" align=absmiddle>
END;
	}

	if ($CONF[phone_conf]){
	$PAY[phone] =<<<END
		<input type=hidden name=number value=$number>
		<img src=img/btn_pay_hphone.gif border=0 onclick="on_click_phone_pay()" onmouseover="this.style.cursor='pointer'" align=absmiddle>
END;
	}

	if ($CONF[bank_soodong_conf]){
	$PAY[bank_soodong] =<<<END
		<input type=hidden name=number value=$number>
		<img src=img/btn_pay_bank.gif border=0 onclick="on_click_bank_soodong_pay()" onmouseover="this.style.cursor='pointer'" align=absmiddle>
END;
	}

	if ($CONF[point_conf]){
	$PAY[point] =<<<END
		<input type=hidden name=number value=$number>
		<img src="img/btn_pay_point.gif" border=0 onclick="on_click_point_pay()" onmouseover="this.style.cursor='pointer'" align=absmiddle alt="포인트결제">
END;
	}
}


if ($demo){
$msg = "<img src=img/dot.gif width=20><font color=blue>데모버젼에서는 실제결재가 되지 않으오니
안심하시고 결재를 끝까지 진행하셔도 됩니다.</font><br> ";
}


	if ($HAPPY_CONFIG['pg_company'] == "dacom")
	{
		$dacom_jumin = "
		<div style='padding:10px; background-color:#f6f6f6;'>
			<table cellspacing='0'>
			<tr>
				<td><img src='img/title_lgdacom_jumin.gif'></td>
				<td>
					<table cellspacing='0'>
					<tr>
					<td><input type='text' name='jumin1' value='' maxlength='6' class='sminput3'></td>
					<td style='width:15px; color:#969696;' align='center'>-</td>
					<td><input type='password' name='jumin2' value='' maxlength='6' class='sminput3'></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan='2' class='smfont3' style='color:#727272; padding:10px 0 0 5px;'>회원가입시 입력한 주민등록번호와 별도로 데이콤 실시간 계좌이체를 사용하기 위해서는 주민등록번호를 새로 입력하셔야 합니다.</td>
			</tr>
			</table>
		</div>
		";
	}

	$happy_member_login_id	= happy_member_login_check();

	//비회원이라도 유료옵션이 무엇무엇이 있나 볼수 있게 변경 kad
	$company_info_display = "";
	if ( $happy_member_login_id == "" )
	{
		//결제버튼 없애고
		$PAY['bank']
		= $PAY['card']
		= $PAY['phone']
		= $PAY['bank_soodong']
		= $PAY['point']
		= $PAY['free']
		= "";

		//회사정보 없애고
		$company_info_display = " display:none; ";
	}

	//템플릿 파일 읽어오기
	$TPL->define("결재폼", "./$skin_folder/member_option_pay2.html");
	$TPL->assign("결재폼");
	$내용 = &$TPL->fetch();




	if ( $happy_member_login_id == "" && happy_member_secure( '마이페이지' ) )
	{
		error("관리자라도 마이페이지에 접근하기 위해서는 회원으로 로그인을 하셔야 합니다.");
		exit;
	}

	//비회원이라도 유료옵션이 무엇무엇이 있나 볼수 있게 변경 kad
	if ( $happy_member_login_id != "" )
	{
		$Member					= happy_member_information($happy_member_login_id);
		$member_group			= $Member['group'];

		$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
		$Group					= happy_mysql_fetch_array(query($Sql));

		$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
		$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
	}
	else
	{
		$Template_Default = "default_option.html";
	}


	$TPL->define("껍데기", "./$skin_folder/$Template_Default");
	$TPL->assign("껍데기");
	$ALL = &$TPL->fetch();
	echo $ALL;
	exit;



}
else {
	error("잘못된 접근방법입니다.");
	exit;
}



?>