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

if ( !happy_member_secure($happy_member_secure_text[1].'유료결제') )
{
	error($happy_member_secure_text[1].'유료결제 권한이 없습니다.');
	exit;
}
else
{
	$Sql	= "SELECT number,guin_title,guin_work_content,type1,type2,type3,type_sub1,type_sub2,type_sub3,keyword FROM $guin_tb WHERE guin_id='$user_id' ";
	#echo $Sql;
	$Record	= query($Sql);

	$file		= "rows_myreg_guinlist.html";
	$TPL->define("개별채용정보", "$skin_folder/$file");
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		//print_r2($Data);
		$checked_info = "";
		if ( $_GET['number'] == $Data['number'] )
		{
			$checked_info = " checked ";
		}

		//업.직종 추가함
		$Data["guin_job"] = "";
		if ($Data["type1"] != "0") {
			$Data["guin_job"] .= "1차 직종 : ".$TYPE[$Data["type1"]];
			if ($Data["type_sub1"] != "0") {
				$Data["guin_job"] .= " / ".$TYPE_SUB[$Data["type_sub1"]];
			}
		}
		if ($Data["type2"] != "0") {
			$Data["guin_job"] .= "<br>2차 직종 : ".$TYPE[$Data["type2"]];
			if ($Data["type_sub2"] != "0") {
				$Data["guin_job"] .= " / ".$TYPE_SUB[$Data["type_sub2"]];
			}
		}
		if ($Data["type3"] != "0") {
			$Data["guin_job"] .= "<br>3차 직종 : ".$TYPE[$Data["type3"]];
			if ($Data["type_sub3"] != "0") {
				$Data["guin_job"] .= " / ".$TYPE_SUB[$Data["type_sub3"]];
			}
		}
		//업.직종 추가함

		if ( $Data["guin_job"] == "" )
		{
			$Data["guin_job"] = "정보없음";
		}

		if ( $Data["guin_work_content"] == "" )
		{
			$Data["guin_work_content"] = "정보없음";
		}

		if ( $Data["keyword"] == "" )
		{
			$Data["keyword"] = "정보없음";
		}

		$rows_myreg_guin .= $TPL->fetch("개별채용정보");
	}

	if ( $rows_myreg_guin == "" )
	{
		$rows_myreg_guin = "
			<table cellpadding='0' cellspacing='0' style='width:100%'>
				<tr>
					<td style='height:100px; text-align:center'>채용정보를 등록하셔야 합니다.</td>
				</tr>
			</table>";
	}

	#$구인선택	= make_selectbox2($array,$array_number,"채용공고를 선택해주세요.","guin_number","");


	$file		= "guin_myreg_guinlist.html";


	$TPL->define("내가등록한채용정보", "$skin_folder/$file");
	$TPL->assign("내가등록한채용정보");
	$select_guin_list = $TPL->fetch("내가등록한채용정보");
}

#회원아이디를 구한다.
$gou_number = $mem_id . "-" . happy_mktime();

$현재위치 = "$prev_stand > <a href='happy_member.php?mode=mypage'>마이페이지</a> > <a href='member_guin.php'>내가등록한 채용정보</a> > <a href='member_option_pay2.php'>광고노출 유료결제</a>";


//결제 페이지로 이동
if ( $mode == "pay" ) {

	#기존의 구인결재정보를 읽어
	$sql = "select * from $guin_tb where number='$number'";
	$result = query($sql);
	$DETAIL = happy_mysql_fetch_array($result);

	#회사정보뽑기
	$sql = "select * from $happy_member where user_id='$DETAIL[guin_id]'";
	$result = query($sql);
	$COM = happy_mysql_fetch_array($result);


	$naver_get_addr	= $COM['user_addr1'] ." ". $COM['user_addr2'];
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
	else {
		$COM[logo_temp] = "<img src='./img/logo_img.gif' >";
	}



	#패키지(즉시적용) 설정이 되있다면
	$패키지즉시적용박스 = pack2_box();
	#패키지(즉시적용) 설정이 되있다면 END


	#해당하는 유료결재정보를 읽어온다.
	#추천/누네띠네/배너1/배너2/배너3/뉴스티커/등록유료화
	#배너형/좁은배너형/넓은배너형/누네띠네형/리스트형/추천형/뉴스티커형/일반형
	$guin_banner1 = split("\n",$CONF[guin_banner1]);
	$guin_banner2 = split("\n",$CONF[guin_banner2]);
	$guin_banner3 = split("\n",$CONF[guin_banner3]);
	$guin_bold = split("\n",$CONF[guin_bold]);
	$guin_list_hyung = split("\n",$CONF[guin_list_hyung]);
	$guin_pick = split("\n",$CONF[guin_pick]);
	$guin_ticker = split("\n",$CONF[guin_ticker]);
	$guin_banner1 = str_replace(" ", "", $guin_banner1);
	#배경색추가
	$guin_bgcolor_com = split("\n",$CONF[guin_bgcolor_com]);
	#자유아이콘추가
	$guin_freeicon	= explode("\n",str_replace("\r","",$CONF[freeicon_comDate]));

	$guin_uryo1 = split("\n",$CONF['guin_uryo1']);
	$guin_uryo2 = split("\n",$CONF['guin_uryo2']);
	$guin_uryo3 = split("\n",$CONF['guin_uryo3']);
	$guin_uryo4 = split("\n",$CONF['guin_uryo4']);
	$guin_uryo5 = split("\n",$CONF['guin_uryo5']);


	$PAY = array();
	#print_r($CONF);

	/*
	$PAY[guin_banner1] = make_guin_selectbox($guin_banner1,"-- 광고 $CONF[guin_banner1_option] 결재금액선택 --",guin_banner1,$CONF[guin_banner1_option]);
	$PAY[guin_banner2] = make_guin_selectbox($guin_banner2,"-- 광고 $CONF[guin_banner2_option] 결재금액선택 --",guin_banner2,$CONF[guin_banner2_option]);
	$PAY[guin_banner3] = make_guin_selectbox($guin_banner3,"-- 광고 $CONF[guin_banner3_option] 결재금액선택 --",guin_banner3,$CONF[guin_banner3_option]);
	$PAY[guin_bold] = make_guin_selectbox($guin_bold,"-- 광고 $CONF[guin_bold_option] 결재금액선택 --",guin_bold,$CONF[guin_bold_option]);
	$PAY[guin_list_hyung] = make_guin_selectbox($guin_list_hyung,"-- 광고 $CONF[guin_list_hyung_option] 결재금액선택 --",guin_list_hyung,$CONF[guin_list_hyung_option]);
	$PAY[guin_pick] = make_guin_selectbox($guin_pick,"-- 광고 $CONF[guin_pick_option] 결재금액선택 --",guin_pick,$CONF[guin_pick_option]);
	$PAY[guin_ticker] = make_guin_selectbox($guin_ticker,"-- 광고 $CONF[guin_ticker_option] 결재금액선택 --",guin_ticker,$CONF[guin_ticker_option]);
	#배경색추가
	$PAY[guin_bgcolor_com] = make_guin_selectbox($guin_bgcolor_com,"-- 광고 $CONF[guin_bgcolor_com_option] 결재금액선택 --",guin_bgcolor_com,$CONF[guin_bgcolor_com_option]);
	*/

	$PAY[guin_banner1] = make_guin_checkbox_pay($guin_banner1,"-- 광고 $CONF[guin_banner1_option] 결재금액선택 --",guin_banner1,$CONF[guin_banner1_option]);
	$PAY[guin_banner2] = make_guin_checkbox_pay($guin_banner2,"-- 광고 $CONF[guin_banner2_option] 결재금액선택 --",guin_banner2,$CONF[guin_banner2_option]);
	$PAY[guin_banner3] = make_guin_checkbox_pay($guin_banner3,"-- 광고 $CONF[guin_banner3_option] 결재금액선택 --",guin_banner3,$CONF[guin_banner3_option]);
	$PAY[guin_bold] = make_guin_checkbox_pay($guin_bold,"-- 광고 $CONF[guin_bold_option] 결재금액선택 --",guin_bold,$CONF[guin_bold_option]);
	$PAY[guin_list_hyung] = make_guin_checkbox_pay($guin_list_hyung,"-- 광고 $CONF[guin_list_hyung_option] 결재금액선택 --",guin_list_hyung,$CONF[guin_list_hyung_option]);
	$PAY[guin_pick] = make_guin_checkbox_pay($guin_pick,"-- 광고 $CONF[guin_pick_option] 결재금액선택 --",guin_pick,$CONF[guin_pick_option]);
	$PAY[guin_ticker] = make_guin_checkbox_pay($guin_ticker,"-- 광고 $CONF[guin_ticker_option] 결재금액선택 --",guin_ticker,$CONF[guin_ticker_option]);

	#배경색추가
	$PAY[guin_bgcolor_com] = make_guin_checkbox_pay($guin_bgcolor_com,"-- 광고 $CONF[guin_bgcolor_com_option] 결재금액선택 --",guin_bgcolor_com,$CONF[guin_bgcolor_com_option]);
	#자유아이콘추가
	$PAY[guin_freeicon]		= make_guin_radiobox($guin_freeicon,$guin_freeicon,freeicon_comDate,"기간별");

	#추가옵션 5개
	$PAY['guin_uryo1'] = make_guin_checkbox_pay($guin_uryo1,"-- 광고 $CONF[guin_uryo1_option] 결재금액선택 --",guin_uryo1,$CONF['guin_uryo1_option']);
	$PAY['guin_uryo2'] = make_guin_checkbox_pay($guin_uryo2,"-- 광고 $CONF[guin_uryo2_option] 결재금액선택 --",guin_uryo2,$CONF['guin_uryo2_option']);
	$PAY['guin_uryo3'] = make_guin_checkbox_pay($guin_uryo3,"-- 광고 $CONF[guin_uryo3_option] 결재금액선택 --",guin_uryo3,$CONF['guin_uryo3_option']);
	$PAY['guin_uryo4'] = make_guin_checkbox_pay($guin_uryo4,"-- 광고 $CONF[guin_uryo4_option] 결재금액선택 --",guin_uryo4,$CONF['guin_uryo4_option']);
	$PAY['guin_uryo5'] = make_guin_checkbox_pay($guin_uryo5,"-- 광고 $CONF[guin_uryo5_option] 결재금액선택 --",guin_uryo5,$CONF['guin_uryo5_option']);

	//배경색상 라디오버튼
	$guin_title_bgcolors	= explode(",",$HAPPY_CONFIG['guin_title_bgcolors']);

	if( $_COOKIE['happy_mobile'] == 'on' )
	{
		$bgcolor_cnt			= 0;
		$bgcolor_cut			= 1;
		$PAY['guin_bgcolor_radio']= "
		<table cellspacing='0' cellpadding='0' border='0' width=100% border=0>
		<tr>
		";
		foreach($guin_title_bgcolors as $key => $value)
		{
			$bgcolor_cnt++;
			$PAY['guin_bgcolor_radio']	.= "
				<td style='padding-left:25px;  height:40px; text-align:left' class='guzic_pay'>
					<span class='h_form' style='display:inline-block; background:$value; color:#333'>
						<label for='$value' class='h-radio'><input type='radio' name='guin_bgcolor_select' value='$value' id='$value' style='margin-bottom:2px; cursor:pointer'><span class='noto400 font_15'>${bgcolor_cnt}번 형광펜</span></label>
					</span>
				</td>
			";

			if( ( $bgcolor_cnt % $bgcolor_cut ) == 0 )
			{
				$PAY['guin_bgcolor_radio']	.= "</tr><tr><td colspan='4' style=''></td></tr><tr>";
			}
		}
		$PAY['guin_bgcolor_radio']	.="</tr></table>";
	}
	else
	{
		$bgcolor_cnt			= 0;
		$bgcolor_cut			= 4;
		$PAY['guin_bgcolor_radio']= "
		<table cellspacing='0'  style='margin:0 auto'>
		<tr>
		";
		foreach($guin_title_bgcolors as $key => $value)
		{
			$bgcolor_cnt++;
			$PAY['guin_bgcolor_radio']	.= "
				<td style='text-align:center; padding:10px; line-height:18px'>
					<span class='h_form' style='display:block; background:$value; color:#333'>
						<label for='$value' class='h-radio'><input type='radio' name='guin_bgcolor_select' value='$value' id='$value' style='margin-bottom:2px; cursor:pointer'><span class='noto400 font_15'>${bgcolor_cnt}번 형광펜</span></label>
					</span>
				</td>
			";

			if( ( $bgcolor_cnt % $bgcolor_cut ) == 0 )
			{
				$PAY['guin_bgcolor_radio']	.= "</tr><tr><td colspan='4' style=''></td></tr><tr>";
			}
		}
		$PAY['guin_bgcolor_radio']	.="</tr></table>";
	}
	//배경색상 라디오버튼

	$시간 = happy_mktime();

	for ($i=0;$i<=6;$i++){
		#max 를 구하자
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_max = $ARRAY[$i] . "_max";


		if ($CONF[$tmp_option] == '기간별'){
			$sql = "select count(*) from $guin_tb where $ARRAY[$i] > $real_gap AND (guin_end_date >= curdate() or guin_choongwon = '1') ";
			$result = query($sql);
			list($NOW_MAX{$ARRAY[$i]}) = mysql_fetch_row($result);
		}
		else {
			$sql = "select count(*) from $guin_tb where $ARRAY[$i] > '0' AND (guin_end_date >= curdate() or guin_choongwon = '1') ";
			$result = query($sql);
			list($NOW_MAX{$ARRAY[$i]}) = mysql_fetch_row($result);
		}

		if ($CONF{$ARRAY[$i]} && $CONF[$tmp_max] > $NOW_MAX{$ARRAY[$i]} ){

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
		elseif ($CONF{$ARRAY[$i]} && $CONF[$tmp_max] <= $NOW_MAX{$ARRAY[$i]} ){
			$PAY{$ARRAY[$i]} = "<font class=small_gray>유료광고 최대건수를 넘었습니다 <br>(" . $NOW_MAX{$ARRAY[$i]} . "건 현재 광고중)</font>";
		}
		else {
			$PAY{$ARRAY[$i]} = "유료설정이 되지 않음 ";
		}

	}

	#사용안하면 안보이도록
	$Sty = array();

	#배경색 + 아이콘
	for ($i=10;$i<=16;$i++)
	{

		#max 를 구하자
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_max = $ARRAY[$i] . "_max";
		$tmp_use = $ARRAY[$i]."_use";

		if ( $CONF[$tmp_use] == "사용안함" )
		{
			$Sty[$ARRAY[$i]] = ' style="display:none;" ';
			continue;
		}



		if ($CONF[$tmp_option] == '기간별')
		{
			$sql = "select count(*) from $guin_tb where $ARRAY[$i] > $real_gap  ";
			$result = query($sql);
			list($NOW_MAX{$ARRAY[$i]}) = mysql_fetch_row($result);
		}
		else
		{
			$sql = "select count(*) from $guin_tb where $ARRAY[$i] > '0'  ";
			$result = query($sql);
			list($NOW_MAX{$ARRAY[$i]}) = mysql_fetch_row($result);
		}
		//echo $ARRAY[$i]." : ".$CONF{$ARRAY[$i]}."<br>";
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


	for ( $i=0 , $max=sizeof($guin_freeicon), $freeicon_count=1 ; $i<$max ; $i++ )
	{
		if ( $guin_freeicon[$i] != "" )
		{
			$freeicon_count++;
		}
	}

	for ( $i=0, $freeicon_javascript="val8 = '0:0';\n" ; $i < $freeicon_count ; $i++ )
	{
		$freeicon_javascript	.= "
										if ( payform.freeicon_comDate && payform.freeicon_comDate[$i].checked ) {
											val8 = payform.freeicon_comDate[$i].value;
										} else {
											if (val8 == \"0:0\")
												val8 = \"0:0\";
										}\n
										";
	}







	//결제요청시 팝업 / 프레임 / 액티브엑스설치 처리 통합결제모듈 ranksa
	$pay_frame = "";
	if( $_COOKIE['happy_mobile'] != 'on' )
	{
		$pay_frame = '<iframe name="pay_page" id="pay_page" style="display:none;"></iframe>';
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

	$freeicon_javascript

	arrVal8	= val8.split(":");
	val8	= ( val8 == "" )?0:parseInt(arrVal8[1]);

    var total =  	(0) $total_plus;


	//패키지(즉시적용) 가격
	var	pack2_now_price_val		= document.getElementById('pack2_now_price').value;
	total						= parseInt(total) + parseInt(pack2_now_price_val);
	//패키지(즉시적용) 가격 END


	if ( document.getElementById('uryo_button_layer') && document.getElementById('free_button_layer') )
	{
		if ( total > 0 )
		{
			document.getElementById('uryo_button_layer').style.display = "";
			document.getElementById('free_button_layer').style.display = "none";
		}
		else
		{
			document.getElementById('uryo_button_layer').style.display = "none";
			document.getElementById('free_button_layer').style.display = "";
		}
	}

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

<!--<div id="debug"></div>-->
<script language="javascript">

	function PayFormCheck(myform)
	{
		//폼체크
		is_sel = false;
		ChkFreeIconDate = false;

		CheckOptions = Array('guin_banner1','guin_banner2','guin_banner3','guin_bold','guin_list_hyung','guin_pick','guin_ticker','guin_bgcolor_com','guin_uryo1','guin_uryo2','guin_uryo3','guin_uryo4','guin_uryo5');

		//채용정보
		if (typeof(myform.guin_number) == "object")
		{
			chk_number = checked(myform.guin_number);
			if ( chk_number == true )
			{
				myform.number.value = valued(myform.guin_number);
			}
		}

		if ( myform.number.value == "" )
		{
			alert("결제하실 채용정보를 선택하셔야 합니다.");
			return;
		}

		for ( TmpChk in CheckOptions )
		{
			CheckBox = document.getElementsByName(CheckOptions[TmpChk]);

			if ( CheckBox )
			{
				for ( i=0; i<CheckBox.length; i++ )
				{
					if ( CheckBox[i].checked == true )
					{
						is_sel = true;
					}
				}
			}
		}

		FreeIconDate = document.getElementsByName('freeicon_comDate');
		if ( FreeIconDate )
		{
			for ( i=0; i<FreeIconDate.length; i++ )
			{
				if ( FreeIconDate[i].checked == true )
				{
					if ( FreeIconDate[i].value != "0:0" )
					{
						ChkFreeIcon = false;
						ChkFreeIconDate = true;
						is_sel = true;
					}
					else
					{
						ChkFreeIconDate = true;
						ChkFreeIcon = true;
					}
				}
			}
		}

		if (ChkFreeIconDate == false)
		{
			alert("아이콘의 사용기간을 선택해주세요");
			return false;
		}

		if (ChkFreeIcon == false)
		{
			FreeIcon = document.getElementsByName('freeicon');
			for ( i=0;i<FreeIcon.length;i++ )
			{
				if ( FreeIcon[i].checked == true )
				{
					ChkFreeIcon = true;
				}
			}

			if ( ChkFreeIcon == false )
			{
				alert("아이콘을 선택해주세요");
				return false;
			}
		}


		//패키지(즉시적용) 선택되어있다면
		var	pack2_now_price_val		= document.getElementById('pack2_now_price').value;
		if(parseInt(pack2_now_price_val) > 0)
		{
			is_sel = true;
		}
		//패키지(즉시적용) 선택되어있다면 END

		if (is_sel == false)
		{
			alert("옵션을 하나라도 선택을 하셔야만 합니다");
			return false;
		}

		return true;
	}


	function on_click_phone_pay()
	{
		myform = document.payform;

		if ( PayFormCheck(myform) )
		{
			$pay_button_script
			myform.action = "my_pay.php?type=phone";
			myform.submit();
		}
	}


	function on_click_card_pay()
	{
		myform = document.payform;

		if ( PayFormCheck(myform) )
		{
			$pay_button_script
			myform.action = "my_pay.php?type=card";
			myform.submit();
		}
	}


	function on_click_bank_pay()
	{
		myform = document.payform;

		if ( PayFormCheck(myform) )
		{
			$agspay_alert
			$pay_button_script
			myform.action = "my_pay.php?type=bank";
			myform.submit();
		}
	}

	function on_click_bank_soodong_pay()
	{
		myform = document.payform;

		if ( PayFormCheck(myform) )
		{
			myform.target = "_top";
			myform.action = "my_pay.php?type=bank_soodong";
			myform.submit();
		}
	}

	function on_click_point_pay()
	{
		myform = document.payform;

		if ( PayFormCheck(myform) )
		{
			myform.target = "_top";
			myform.action = "my_pay.php?type=point";
			myform.submit();
		}
	}

	function checked(obj) {

		var cnt = obj.length;
		if ( cnt != undefined )
		{
			for(i=0; i< cnt; i++) {
				if(obj[i].checked == true) {
					//alert(i +"번째꺼 선택됨");
					return true;
					break;
				}
			}

			return false;
		}
		else
		{
			obj.checked = true;
			return true;
		}
	}

	function valued(obj)
	{
		var cnt = obj.length;

		if( cnt > 0 )
		{
			for(i=0;i<cnt;i++)
			{
				if ( obj[i].checked == true )
				{
					return obj[i].value;
					break;
				}
			}
		}
		else
		{
			return obj.value;
		}
	}

</script>

	$pay_frame

	<input type=hidden name=number value="$_GET[number]">
	<input type=hidden name=total_price value="0">
	<input type=hidden name=id value="$member_id">
	<input type=hidden name=joomin1 value="">
	<input type=hidden name=joomin2 value="">
	<input type=hidden name=email value="$DETAIL[guin_email]">
	<input type=hidden name=hphone_header value="">
	<input type=hidden name=hphone_footer value="">
	<input type=hidden name=select_016 value="selected">
	<input type=hidden name=gou_number value='$gou_number'>
	<input type=hidden name=is_repay value='y'> <!-- 유료옵션 연장페이지인지 여부 hong -->

END;


if ( !happy_member_secure($happy_member_secure_text[1].'유료결제') )
{
	$onclick1 = ' onclick = "alert(\''.$happy_member_secure_text[1].'유료결제'.' 권한이 없습니다.\');" ';
	$onclick2 = ' onclick = "alert(\''.$happy_member_secure_text[1].'유료결제'.' 권한이 없습니다.\');" ';
	$onclick3 = ' onclick = "alert(\''.$happy_member_secure_text[1].'유료결제'.' 권한이 없습니다.\');" ';
	$onclick4 = ' onclick = "alert(\''.$happy_member_secure_text[1].'유료결제'.' 권한이 없습니다.\');" ';
	$onclick5 = ' onclick = "alert(\''.$happy_member_secure_text[1].'유료결제'.' 권한이 없습니다.\');" ';
	$onclick6 = ' onclick = "alert(\''.$happy_member_secure_text[1].'유료결제'.' 권한이 없습니다.\');" ';
}
else
{
	$onclick1 = ' onclick = "on_click_bank_pay()" ';
	$onclick2 = ' onclick = "on_click_card_pay()" ';
	$onclick3 = ' onclick = "on_click_phone_pay()" ';
	$onclick4 = ' onclick = "on_click_bank_soodong_pay()" ';
	$onclick5 = ' onclick = "on_click_point_pay()" ';
	$onclick6 = ' onclick = "on_click_bank_soodong_pay()" ';
}


#결재방식을 찾자.
if( $_COOKIE['happy_mobile'] == 'on' )
{
	if ($CONF['bank_conf_mobile'])
	{
		$PAY['bank'] = '<input type="button" value="실시간 계좌이체" '.$onclick1.'>';
	}
	if ($CONF['card_conf_mobile'])
	{
		$PAY['card'] = '<input type="button" value="신용카드 결제" '.$onclick2.' >';
	}
	if ($CONF['phone_conf_mobile'])
	{
		$PAY['phone'] = '<input type="button" value="휴대폰 결제" '.$onclick3.'>';
	}
	if ($CONF['bank_soodong_conf_mobile'])
	{
		$PAY['bank_soodong'] = '<input type="button" value="무통장 입금" '.$onclick4.'>';
	}
	if ($CONF['point_conf_mobile'])
	{
		$PAY['point'] = '<input type="button" value="포인트 결제" '.$onclick5.'>';
	}
	//$PAY['free'] = '<img src="img/pay_free.gif" border=0 '.$onclick6.' onmouseover="this.style.cursor=\'pointer\'" align=absmiddle alt="무료신청">';
	$PAY['free'] = '<input type="button" value="결제하지 않고 바로 등록"'.$onclick6.'></input>';
}
else
{
	if ($CONF['bank_conf'])
	{
		$PAY['bank'] = '<img src=img/btn_pay_realmoney.gif border=0 '.$onclick1.' onmouseover="this.style.cursor=\'pointer\'" align=absmiddle>';
	}
	if ($CONF['card_conf'])
	{
		$PAY['card'] = '<img src=img/btn_pay_card.gif border=0 '.$onclick2.' onmouseover="this.style.cursor=\'pointer\'" align=absmiddle>';
	}
	if ($CONF['phone_conf'])
	{
		$PAY['phone'] = '<img src=img/btn_pay_hphone.gif border=0 '.$onclick3.' onmouseover="this.style.cursor=\'pointer\'" align=absmiddle>';
	}
	if ($CONF['bank_soodong_conf'])
	{
		$PAY['bank_soodong'] = '<img src=img/btn_pay_bank.gif border=0 '.$onclick4.' onmouseover="this.style.cursor=\'pointer\'" align=absmiddle>';
	}
	if ($CONF['point_conf'])
	{
		$PAY['point'] = '<img src="img/btn_pay_point.gif" border=0 '.$onclick5.' onmouseover="this.style.cursor=\'pointer\'" align=absmiddle alt="포인트결제">';
	}
	$PAY['free'] = '<img src="img/pay_free.gif" border=0 '.$onclick6.' onmouseover="this.style.cursor=\'pointer\'" align=absmiddle alt="무료신청">';
}



if ($demo)
{
	$msg = "<img src=img/dot.gif width=20><font color=blue>데모버젼에서는 실제결제가 되지 않으오니 안심하시고 결제를 끝까지 진행하셔도 됩니다.</font><br> ";
}

	//껍데기파일
	$default_file = "default_com.html";



	if ($HAPPY_CONFIG['pay_all_pg'] == "dacom")
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
	}


	//템플릿 파일 읽어오기
	$TPL->define("결재폼", "./$skin_folder/member_option_pay.html");
	$TPL->assign("결재폼");
	$내용 = &$TPL->fetch();


	if ( $happy_member_login_id == "" )
	{
		$Template_Default = "default_option.html";
	}
	else
	{
		if ( $happy_member_login_id == "" && happy_member_secure( '마이페이지' ) )
		{
			error("관리자라도 마이페이지에 접근하기 위해서는 회원으로 로그인을 하셔야 합니다.");
			exit;
		}

		$Member					= happy_member_information($happy_member_login_id);
		$member_group			= $Member['group'];

		$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
		$Group					= happy_mysql_fetch_array(query($Sql));

		$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
		$Template				= ( $Group['mypage_content'] == '' )? $happy_member_mypage_content_file : $Group['mypage_content'];
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