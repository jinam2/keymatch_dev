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

if ( !happy_member_secure($happy_member_secure_text[1].'보기 유료결제') )
{
	error($happy_member_secure_text[1].'보기 유료결제'."권한이 없습니다.");
	exit;
}

#회원아이디를 구한다.
$gou_number = $mem_id . "-" . happy_mktime();

$현재위치 = "$prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='member_option_pay3.php'>열람/SMS서비스</a>";


//결제 페이지로 이동
if ( $mode == "" )
{
	//개인회원 정보
	$sql = "select * from $happy_member where user_id='$user_id' ";
	$result = query($sql);
	$MEM = happy_mysql_fetch_array($result);

	$아이디		= $Data['user_id'];
	$이름		= $Data['user_name'];
	$닉네임		= $Data['user_nick'];
	$이메일		= $Data['user_email'];
	$휴대폰		= $Data['user_hphone'];
	$사진		= "<img src=".$Data['photo1']." border=0 width='$PERPOTHO_DST_W[0]' height='$PERPOTHO_DST_H[0]' onError=this.src='img/noimage_del.jpg'>";

	$MEM['etc1'] = $MEM['photo1'];
	$MEM['etc2'] = $MEM['photo2'];
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
	$MEM['per_birth'] = $MEM['user_birth_year']."-".$MEM['user_birth_month']."-".$MEM['user_birth_day'];
	$MEM['per_phone'] = $MEM['user_phone'];
	$MEM['per_cell'] = $MEM['user_hphone'];
	$MEM['per_email'] = $MEM['user_email'];
	$MEM['per_zip'] = $MEM['user_zip'];
	$MEM['per_addr1'] = $MEM['user_addr1'];
	$MEM['per_addr2'] = $MEM['user_addr2'];

	$MEM['point_comma'] = number_format($MEM['point']);

		if ( $MEM['per_email'] == "" )
		{
			$MEM['per_email'] = "정보없음";
		}
		if ( $MEM['per_phone'] == "" )
		{
			$MEM['per_phone'] = "정보없음";
		}
		if ( $MEM['per_cell'] == "" )
		{
			$MEM['per_cell'] = "정보없음";
		}
		if ( $MEM['per_zip'] == "" )
		{
			$MEM['per_zip'] = "정보없음";
		}
		if ( $MEM['user_homepage'] == "" )
		{
			$MEM['user_homepage'] = "정보없음";
		}

	$number	= $MEM["number"];

	if ( $MEM['etc1'] != '' )
	{
		#등록한 사진 있을때
		$tmp_memphoto = explode(".",$MEM[etc1]);
		$memphoto_temp = $tmp_memphoto[0]."_thumb.".$tmp_memphoto[1];

		if (file_exists("./".$memphoto_temp))
		{
			$mem_photo = "<img src='$memphoto_temp' align='absmiddle' width='$PERPOTHO_DST_W[0]' height='$PERPOTHO_DST_H[0]'>";
		}
		else
		{
			$mem_photo = "<img src='$MEM[etc1]' width='$PERPOTHO_DST_W[0]' height='$PERPOTHO_DST_H[0]' align='absmiddle'>";
		}
	}
	else
	{
		#사진 없을때
		$mem_photo = "<img src='img/noimg.gif' width='$PERPOTHO_DST_W[0]' height='$PERPOTHO_DST_H[0]' align='absmiddle'>";
	}

	$Sql	= "SELECT viewListCount,fileName1,fileName2,fileName3,fileName4,fileName5 FROM $per_document_tb WHERE user_id='$user_id' ";
	$Record	= query($Sql);

	$fileCount_doc	= 0;
	$fileCount_img	= 0;
	$fileCount_etc	= 0;
	$viewCount		= 0;
	$docCount		= 0;
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$docCount++;
		$viewCount	+= $Data["viewListCount"];

		for ( $i=1 ; $i<=5 ; $i++ )
		{
			$file	= $Data["fileName".$i];
			$tmp	= explode(".",$file);
			$file	= strtolower( $tmp[sizeof($tmp)-1] );
			if ( $file=="jpg" || $file=="jpeg" || $file=="gif" || $file=="png" )
			{
				$fileCount_img++;
			}
			else if ( $file=="txt" || $file=="doc" || $file=="hwp" || $file=="xls" || $file=="cvs" || $file=="ppt" )
			{
				$fileCount_doc++;
			}
			else if ( $file!="" )
			{
				$fileCount_etc++;
			}
		}
	}

	$이력서수			= $docCount;
	$문서첨부파일수		= $fileCount_doc;
	$이미지첨부파일수	= $fileCount_img;
	$기타첨부파일수		= $fileCount_etc;
	$이력서열람기업수	= $viewCount;




	#해당하는 유료결재정보를 읽어온다.
	#추천/누네띠네/배너1/배너2/배너3/뉴스티커/등록유료화
	#배너형/좁은배너형/넓은배너형/누네띠네형/리스트형/추천형/뉴스티커형/일반형
	$guzic_view	= split("\n",$CONF['guzic_view']);
	$guzic_view2	= split("\n",$CONF['guzic_view2']);
	$guzic_smspoint	= split("\n",$CONF['guzic_smspoint']);


	$PAY = array();
	/*
	$PAY[guin_docview] = make_guin_selectbox($guin_docview,"-- $CONF[guin_docview_option] 결재금액선택 --",guin_docview,"이력서보기기간");
	$PAY[guin_docview2] = make_guin_selectbox($guin_docview2,"-- $CONF[guin_docview2_option] 결재금액선택 --",guin_docview2,"이력서보기회");
	$PAY[guin_smspoint] = make_guin_selectbox($guin_smspoint,"-- $CONF[guin_smspoint_option] 결재금액선택 --",guin_smspoint,"SMS발송");
	*/
	$PAY['guzic_view'] = make_guin_checkbox_pay($guzic_view,"-- $CONF[guzic_view_option] 결재금액선택 --",guzic_view,"구인정보보기기간");
	$PAY['guzic_view2'] = make_guin_checkbox_pay($guzic_view2,"-- $CONF[guzic_view2_option] 결재금액선택 --",guzic_view2,"구인정보보기회");
	$PAY['guzic_smspoint'] = make_guin_checkbox_pay($guzic_smspoint,"-- $CONF[guzic_smspoint_option] 결재금액선택 --",guzic_smspoint,"SMS발송");

	$시간 = happy_mktime();


	for ($i=14;$i<=16;$i++)
	{
		#max 를 구하자
		$tmp_option = $PER_ARRAY_DB[$i] . "_option";
		$tmp_max = $PER_ARRAY_DB[$i] . "_max";

		if ($CONF[$tmp_option] == '기간별')
		{
			$sql = "select count(*) from $happy_member_option where option_field = '".$PER_ARRAY_DB[$i]."' and option_value > $real_gap  ";
			$result = query($sql);
			list($NOW_MAX{$PER_ARRAY_DB[$i]}) = mysql_fetch_row($result);
		}
		else
		{
			$sql = "select count(*) from $happy_member_option where option_field = '".$PER_ARRAY_DB[$i]."' and option_value > '0'  ";
			$result = query($sql);
			list($NOW_MAX{$PER_ARRAY_DB[$i]}) = mysql_fetch_row($result);
		}


		if ($CONF{$PER_ARRAY_DB[$i]} && $CONF[$tmp_max] > $NOW_MAX{$PER_ARRAY_DB[$i]} )
		{
			$lista = $PER_ARRAY_DB[$i] ."a";
			$lista2 = $PER_ARRAY_DB[$i] . "a2";
			/*
			$java_insert .= "
			var $lista = document.payform.$ARRAY[$i].options[document.payform.$ARRAY[$i].selectedIndex].value;
			$lista = $lista.split(\":\");
			var $lista2 = $lista"."[$lista.length -1];
			";
			*/
			$java_insert .= "
				max = \"\";
				max = document.payform.$PER_ARRAY_DB[$i].length;
				//alert('$ARRAY[$i] : ' + max);
				ChkVal = \"0:0\";

				if ( max == undefined )
				{
					if (document.payform.$PER_ARRAY_DB[$i].checked)
					{
						ChkVal = document.payform.$PER_ARRAY_DB[$i].value;
					}
				}
				else
				{
					for ( x=0; x<max; x++)
					{
						//alert('$ARRAY[$i]'+document.payform.$PER_ARRAY_DB[$i][x].value);

						if ( document.payform.$PER_ARRAY_DB[$i][x].checked )
						{
							ChkVal = document.payform.$PER_ARRAY_DB[$i][x].value;
						}
					}
				}

				var $lista = ChkVal;
				$lista = $lista.split(\":\");
				var $lista2 = $lista"."[$lista.length -1];
			";
			$total_plus .= '+' . "($lista2-0)";

		}
		elseif ($CONF{$PER_ARRAY_DB[$i]} && $CONF[$tmp_max] <= $NOW_MAX{$PER_ARRAY_DB[$i]} )
		{
			$PAY{$PER_ARRAY_DB[$i]} = "<font class=small_gray>유료광고 최대건수를 넘었습니다 <br>(" . $NOW_MAX{$PER_ARRAY_DB[$i]} . "건 현재 광고중)</font>";
		}
		else
		{
			$PAY{$PER_ARRAY_DB[$i]} = "유료설정이 되지 않음 ";
		}

	}




//결제요청시 팝업 / 프레임 / 액티브엑스설치 처리 통합결제모듈 ranksa
$pay_button_script = "";

if( $_COOKIE['happy_mobile'] != 'on' )
{
	$pay_frame = '<iframe width="0" height="0" name="pay_page" id="pay_page"></iframe>';
	$pay_button_script = 'myform.target = "pay_page";';//결제요청시 팝업 및 프레임 처리
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

		$pay_button_script
		myform.action = "my_pay2.php?type=phone";
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
		myform.action = "my_pay2.php?type=card";
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


		$pay_button_script
		myform.action = "my_pay2.php?type=bank";
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
			alert("옵션을 하나라도 선택을 하셔야만 합니다");
			return;
		}
		myform.target = "_top";
		myform.action = "my_pay2.php?type=bank_soodong";
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
		myform.action = "my_pay2.php?type=point";
		myform.submit();
	}

</script>

	$pay_frame

	<input type=hidden name=total_price value="0">
	<input type=hidden name=pay_type value='per_member'>
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
if( $_COOKIE['happy_mobile'] == 'on' )
{
	if ($CONF[bank_conf_mobile]){
	$PAY[bank] =<<<END
		<input type=hidden name=number value=$number>
		<input type="button" value="실시간 계좌이체" onclick="on_click_bank_pay()" >
END;
	}

	if ($CONF[card_conf_mobile]){
	$PAY[card] =<<<END
		<input type=hidden name=number value=$number>
		<input type="button" value="신용카드 결제" onclick="on_click_card_pay()" >
END;
	}

	if ($CONF[phone_conf_mobile]){
	$PAY[phone] =<<<END
		<input type=hidden name=number value=$number>
		<input type="button" value="휴대폰결제" onclick="on_click_phone_pay()">
END;
	}

	if ($CONF[bank_soodong_conf_mobile]){
	$PAY[bank_soodong] =<<<END
		<input type=hidden name=number value=$number>
		<input type="button" value="무통장 입금" onclick="on_click_bank_soodong_pay()" >
END;
	}

	if ($CONF[point_conf_mobile]){
	$PAY[point] =<<<END
		<input type=hidden name=number value=$number>
		<input type="button" value="포인트결제" onclick="on_click_point_pay()" >
END;
	}
}
else
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



	$happy_member_login_id	= happy_member_login_check();
	$Member					= happy_member_information($happy_member_login_id);

	//템플릿 파일 읽어오기
	$TPL->define("결재폼", "./$skin_folder/member_option_pay3.html");
	$TPL->assign("결재폼");
	$내용 = &$TPL->fetch();


	if ( $happy_member_login_id == "" && happy_member_secure( '마이페이지' ) )
	{
		error("관리자라도 마이페이지에 접근하기 위해서는 회원으로 로그인을 하셔야 합니다.");
		exit;
	}

	$member_group			= $Member['group'];

	$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
	$Group					= happy_mysql_fetch_array(query($Sql));

	$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
	$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];



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