<?
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/happy_sms.php");


	if ( !admin_secure("회원관리") )
	{
			error("접속권한이 없습니다.   ");
			exit;
	}
	include ("tpl_inc/top_new.php");


	if( $_POST['mode'] == "reg" )
	{
		$phoneArray				= $_POST['phoneArray'];
		$callback				= $_POST['callback'];
		$message				= $_POST['message'];
		$sms_all_send			= $_POST['sms_all_send'];
		$search_sql				= $_POST['search_sql'];

		#목록 미출력 상태에서 전체 발송인 경우 hong
		if ( $sms_all_send == "y" && $search_sql != "" )
		{
			$search_sql				= stripslashes($search_sql);

			$Sql					= "
										SELECT
												number,
												user_hphone,
												user_id,
												user_name,
												reg_date,
												user_email,
												sms_forwarding
										FROM
												$happy_member
										$search_sql
										ORDER BY
												number ASC
			";
			$Record					= query($Sql);

			$phoneArray				= Array();

			while ( $Data = happy_mysql_fetch_array($Record) )
			{
				$nowPhone				= $Data['user_hphone'];
				$nowPhone				= str_replace("'","",$nowPhone);
				$chk					= substr($nowPhone,0,3);

				if ( strlen($nowPhone) > 9 && ( $chk == '010' || $chk == '011' || $chk == '016' || $chk == '017' || $chk == '019' || $chk == '018' ) )
				{
					array_push($phoneArray,$nowPhone);
				}
			}
		}

		if(empty($phoneArray) == true)
		{
			error("보낼전화번호를 선택해주세요");
			exit;
		}


		//생성중 구문
		echo "
				<div style=`background-color:#ffffff; padding:30px 0 30px 0;`>
				<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
					<td>

						<!--// 내용을 둘러싸는 테두리 [START] //-->
						<div style='background-color:#ffffff; margin:50px auto; width:450px; border:1px solid #e0e0e0; border-radius:3px;'>
							<div style='text-align:center; padding:70px 20px;'>
						";
						flush();
						echo "<div align='center' id='happy_sms_text'>
									<img src='img/admin_sms_ing.png' style='margin-bottom:30px;'>
									<div class='font_malgun' style='font-size:24px; font-weight:bold; color:#696969;'>SMS 발송중</div>
								</div>";
						flush();
						echo"
							</div>
						</div>
						<!--// 내용을 둘러싸는 테두리 [END] //-->

					</td>
				</tr>
				</table>
				<!-------------------// 내용 CONTENT [END] //--------------------------------------------------------->
				</div>
		";

		$phone_count				= count($phoneArray);

		ob_end_clean();
		for($pp=0;$pp<$phone_count;$pp++)
		{
			$plus_cnt++;

			//happy_sms_send_snoopy( 아이디, 로그인패스워드, 전송휴대폰번호, 보낸사람전화번호,메세지내용, $sms_type = 1, $sms_returnUrl = '', $returyType = '' )
			happy_sms_send_snoopy( $sms_userid, $sms_userpass, $phoneArray[$pp], $callback, $message, '', '', '');

			if (($pp % 5) == 0)
			{
				echo "<script>document.getElementById('happy_sms_text').innerHTML = '<img src=\"img/admin_sms_ing.png\" style=\"margin-bottom:30px;\"><div class=\"font_number\" style=\"font-size:30px; font-weight:bold; color:#696969; margin-bottom:15px;\">$plus_cnt/$phone_count</div><div class=\"font_malgun\" style=\"font-size:24px; font-weight:bold; color:#696969;\">SMS 발송중</div>';</script>\n";
				echo str_pad('',256); //익스플로어에서 정상 작동되기 위해
				ob_flush();
				flush();
				usleep(20000);
			}
		}

		echo "<script>document.getElementById('happy_sms_text').innerHTML = '<img src=\"img/admin_sms_success.png\" style=\"margin-bottom:30px;\"><div class=\"font_number\" style=\"font-size:30px; font-weight:bold; color:#48cd48; margin-bottom:15px;\">$plus_cnt/$phone_count</div><div class=\"font_malgun\" style=\"font-size:24px; font-weight:bold; color:#48cd48;\">SMS 발송완료</div>';</script>\n";ob_flush();flush();


		//생성중 구문 END
		gomsg("SMS발송이 완료되었습니다",$_SERVER['HTTP_REFERER']);
		exit;
	}



	#가입일 및 SMS수신동의 검색 추가함 2009-09-18 kad
	$array_name			= array("아이디","이름","닉네임","휴대폰번호","이메일");
	$array_value		= array("user_id","user_name","user_nick","user_hphone","user_email");
	$searchtype_info	= make_selectbox2($array_name,$array_value,'검색조건','search_type',$_GET['search_type'],120);

	$groupBox			= happy_member_make_group_box('groupSelect', '회원그룹별보기');

	$_GET['sms_ok']		= ( $_GET['sms_ok'] == '' ) ? 'y' : $_GET['sms_ok'];
	$array_name			= array("전체","SMS 수신허용");
	$array_value		= array("all","y");
	$sms_ok_info		= make_selectbox2($array_name,$array_value,'','sms_ok',$_GET['sms_ok'],120);


	$search_sql	= " WHERE `group` = '2' ";

	if ( $_GET['s_date'] != '' )
	{
		$search_sql	.= " AND reg_date >= '".$_GET['s_date']."' ";
	}
	if ( $_GET['e_date'] != '' )
	{
		$search_sql	.= " AND reg_date <= '".$_GET['e_date']."' ";
	}
	if ( $_GET['search_word'] != '' )
	{
		if ( $_GET['search_type'] != '' )
		{
			if ( $_GET['search_type'] == 'hphone' )
			{
				$search_sql	.= " AND ".$_GET['search_type']." like '%".$_GET['search_word']."%' ";
			}
			else
			{
				$search_sql	.= " AND ".$_GET['search_type']." like '".$_GET['search_word']."%' ";
			}
		}
		else
		{
			$search_sql	.= "
							AND
							(
								user_id like '%".$_GET['search_word']."%'
								OR
								user_name like '%".$_GET['search_word']."%'
								OR
								user_nick like '%".$_GET['search_word']."%'
								OR
								user_hphone like '%".$_GET['search_word']."%'
								OR
								user_email like '%".$_GET['search_word']."%'
							)
			";
		}
	}

	if ( $_GET['sms_ok'] == 'y' )
	{
		$search_sql	.= " AND sms_forwarding = 'y' ";
		$smsok_checked	= " checked ";
	}


	$_GET['groupSelect']	= preg_replace("/\D/", "", $_GET['groupSelect']);
	if ( $_GET['groupSelect'] != '' )
	{
		$search_sql	.= " AND `group` = '$_GET[groupSelect]' ";
	}


	#가입일 및 SMS수신동의 검색 추가함 2009-09-18 kad





		#$Sql	= "SELECT number,hphone,id,name,date,email FROM $per_tb ";
		$Sql	= "SELECT number,user_hphone, user_id,user_name,reg_date,user_email,sms_forwarding,`group` FROM $happy_member $search_sql";
		//echo $Sql;

		$Record	= query($Sql);

		$sms_ok_count	= 0;

		$Count	= 0;
		$cutSize= 3000;
		$phones	= Array();
		$list	= "";
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Count++;

			$nowPhone	= $Data['user_hphone'];
			$nowPhone	= str_replace("'","",$nowPhone);
			$checked	= "";
			$chk		= substr($nowPhone,0,3);
			//echo $nowPhone."<br>";
			if ( strlen($nowPhone) > 9 && ( $chk == '010' || $chk == '011' || $chk == '016' || $chk == '017' || $chk == '019' || $chk == '018' ) )
			//if ( strlen($nowPhone) > 9 )
			{
				//$rows_color 는 top.php 에서 설정 [ YOON : 2010-03-23 ]
				$bgcolor	= ( $Count%2 == 0 )?"white":$rows_color;

				$phones[$Count/$cutSize]	.= $phones[$Count/$cutSize] == "" ? "" : ",";
				$phones[$Count/$cutSize]	.= $nowPhone;
				$checked	= "checked";

				$notice_text = "";

			}else{
				//[YOON : 2010-03-26]
				$bgcolor		= "#FFF2EC";
				$notice_text	= "ddrivetip('정상적인 휴대폰번호가 아닙니다.','#FFF4FB','250')";
			}

			if ( strlen($nowPhone) > 9 && ( $chk == '010' || $chk == '011' || $chk == '016' || $chk == '017' || $chk == '019' ) )
			{
				$sms_ok_count++;

				if ( $_GET['sms_ok'] != "y" )
				{
					$bgcolor	= ( $Count%2 == 0 )?"white":$rows_color;

					$phones[$Count/$cutSize]	.= $phones[$Count/$cutSize] == "" ? "" : ",";
					$phones[$Count/$cutSize]	.= $nowPhone;
					$checked	= "checked";

					$notice_text = "";
				}
			}

			if ( $Data['user_email'] == "" )
			{
				$Data['user_email']		= "<font color='#666666'>정보없음</font>";
			}

			$Data['sms_forwarding']	= $Data['sms_forwarding'] == 'y' ? '허용' : '';

			$list	.= "
					<tr height=35 onMouseOver=\"this.style.backgroundColor='#F4F4F4';$notice_text\" onMouseOut=\"this.style.backgroundColor='';hideddrivetip()\" bgcolor=$bgcolor>
						<td align='center' class='font_12' style='height:35px;'><input type='checkbox' name='phoneArray[]' value='$nowPhone' $checked id=sms_member_chk></td>
						<td align='center' class='font_12' >$Data[number]</td>
						<td class='font_12'>$Data[user_hphone]</td>
						<td class='font_12'><font color=black>$Data[user_name]</font> ($Data[user_email])</td>
						<td class='font_12'>$Data[user_id]</td>
						<td align='center' class='font_12'>$Data[sms_forwarding]</td>
						<td align='center' class='font_12'><font color=blue>기업회원</font></td>
						<td align='center' class='font_12'>$Data[reg_date]</td>
					</tr>
					";
		}
		$list	.= "";

		if ( $list == "" )
		{
			$list	= "<tr height=60><td colspan=7 align='center'>검색된 회원이 없습니다.</td></tr>";
		}

		#inc/function.php 에서 설정한 제한 인원수를 넘으면 리스트 출력 안함 hong
		$list_display	= "";
		$list_display2	= "display:none;";
		$send_confirm	= "선택된 회원에게 SMS를 발송하시겠습니까?";
		if ( $Count > $happy_sms_email_send_list_limit )
		{
			$list			= "";
			$list_display	= "display:none;";
			$list_display2	= "";
			$sms_all_send	= "y";
			$send_confirm	= "※ 발송 가능한 회원 전체에게 SMS가 발송됩니다.\\n\\n SMS를 발송하시겠습니까?";
		}

		//echo "<br><hr>". $phones[0];

		$phoneList	= $phones[0];
		$nowDate	= date("Y-m-d H:i:s");


	#검색날짜 지정
	$today		= date("Y-m-d");
	$dayArray	= Array(30,60,90,182,365,730);
	$dayChk		= Array();
	for ( $i=0,$max=sizeof($dayArray) ; $i<$max ; $i++ )
	{
		$dayChk[$dayArray[$i]]	= date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")-$dayArray[$i],date("Y")) );
	}



	#최초 검색범위는 30일로
	if ($_GET[s_date]){
		$s_date_info = $_GET[s_date];
	}
	else {
		//$s_date_info = $dayChk[30];
	}
	if ($_GET[e_date]){
		$e_date_info = $_GET[e_date];
	}
	else {
		//$e_date_info = date('Y-m-d');
	}


echo <<<END

<script language="javascript">
<!--
function bbsdel(strURL) {
	var msg = "매물을 삭제하시겠습니까?";
	if (confirm(msg)){
		window.location.href= strURL;

	}
}

function allcheck_go2()
{
	document.happysms_frm.allcheck.checked	= document.happysms_frm.allcheck.checked == true ? false : true ;
	allcheck_go();
}

function allcheck_go()
{

	var chk		= document.happysms_frm.allcheck.checked;
	var obj		= document.happysms_frm["phoneArray[]"];
	var i		= 0;

	while( 1 )
	{
		if ( obj[i] != undefined )
		{
			obj[i].checked	= chk;
		}
		else
			break;

		i++;
	}

}

function change_search_date(startDate)
{
	document.getElementById('s_date').value	= startDate;
	document.getElementById('e_date').value	= '$today';
}

function Func_check_Valid()
{
	if ( confirm("$send_confirm") )
	{
		return true;
	}

	return false;
}

-->
</script>

<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop:plugins_time.js' id='gToday:datetime:agenda.js:gfPop:plugins_time.js' src='../js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>


<style TYPE="text/css">
	.tbl_box2_padding label{font-size:12px; font-family:맑은 고딕,돋움; font-weight:bold; margin:0 0 0 0;}	/* Radio 폼선택글자  항목 전역용 */
	div.width_fixed,div.input_form{clear:both; display:block}
	div.width_fixed{width:100px; height:0px;}

	select {border:1px solid #dbdbdb; height:29px; line-height:28px; padding:4px; background:#ffffff}
</style>

<div class='main_title'>개인회원 SMS발송</div>

<div class='help_style' style='margin-top:10px;'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>
	<span class='help'>검색</span>
	<p>
	<form name='search_a' action='./sms_send.php' method='GET'>
	<table cellspacing='0' cellpadding='0' style='width:100%;'>
	<tr>
		<td style='width:150px; height:34px;'><strong>등록기간</strong></td>
		<td>
			<table cellspacing='0' cellpadding='0'>
			<tr>
				<td>
					<a onClick="change_search_date('$dayChk[30]')" alt='30일간' title="30일간" class="btn_small_navy">30 일간</a>
					<a onClick="change_search_date('$dayChk[60]')" alt='60일간' title="60일간" class="btn_small_blue">60 일간</a>
					<a onClick="change_search_date('$dayChk[90]')" alt='90일간' title="90일간" class="btn_small_green">90 일간</a>
					<a onClick="change_search_date('$dayChk[182]')" alt='6개월' title="6개월" class="btn_small_orange">6 개월</a>
					<a onClick="change_search_date('$dayChk[365]')" alt='12개월' title="12개월" class="btn_small_red">12 개월</a>
				</td>
				<td style='padding-left:3px;'>
					<table cellspacing="0" cellpadding="0" style="width:100%;">
					<tr>
						<td><input type=text name=s_date id=s_date value='$s_date_info' style='height:22px; line-height:21px; padding-left:3px; border:1px solid #ccc;'></td>
						<td><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.search_a.s_date);return false;" HIDEFOCUS><img class="PopcalTrigger" align="absmiddle" src="img/google_stats/bg_date_input01b.gif" border="0" alt=""></a></td>
						<td style='padding-left:3px;'> 부터 ~ </td>
					</tr>
					</table>
				</td>
				<td style='padding-left:3px;'>
					<table cellspacing="0" cellpadding="0" style="width:100%;">
					<tr>
						<td><input type=text name=e_date id=e_date value='$e_date_info' style='height:22px; line-height:21px; padding-left:3px; border:1px solid #ccc;'></td>
						<td><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.search_a.e_date);return false;" HIDEFOCUS><img class="PopcalTrigger" align="absmiddle" src="img/google_stats/bg_date_input01b.gif" border="0" alt=""></a></td>
						<td style='padding-left:3px;'>  까지</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style='height:34px;'><strong>키워드</strong></td>
		<td>
			<table cellspacing='0' cellpadding='0'>
				<tr>
					<td>$sms_ok_info</td>
					<td style='padding-left:3px;'>$searchtype_info</td>
					<td style='padding-left:3px;'><input type="text" name="search_word" value="$_GET[search_word]" id='search_word' style='width:300px; height:27px; line-height:26px; padding-left:3px; border:1px solid #ccc;'></td>
					<td style='padding-left:3px;'><input type='submit' value='검색' id='search_btn' class='btn_small_blue'></td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	</form>
	</p>
</div>

<form name="happysms_frm" method="post" onSubmit="return Func_check_Valid()">
<input type="hidden" name="mode" value="reg">
<input type="hidden" name="sms_all_send" value="$sms_all_send">
<input type="hidden" name="search_sql" value="$search_sql">

<div class="search_style" style="padding:15px 10px 10px 10px;">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>

	<table cellspacing="0" cellpadding="0" style='width:100%;'>
	<tr>
		<td class='tbl_box2_padding' align='left'>

			<table cellspacing="0" cellpadding="0" style='width:100%;'>
			<tr>
				<td style="width:340px;">

					<div id=sms_input1 style="background:url('http://happysms.happycgi.com/send/sms_bg03.gif') no-repeat 0 0;">

						<!-- 문자입력 -->
						<textarea style='width:135px; height:78px; margin:36px 0 0 13px; color:white; background:none; scrollbars:none; border:0; overflow:hidden; font-size:12px;' name='message' maxlength='80' >입력하세요.</textarea>

						<!-- 회신번호(SMS관리설정에서 가져옴) -->
						<div style="position:absolute; top:12px; left:212px;"><input type='text' name='callback' value="$site_phone" style="width:115px; height:20px; line-height:20px; font-family:tahoma; font-size:12px; background-color:transparent; border:0px;"></div>

						<!-- 발송시간 -->
						<div style="position:absolute; top:38px; left:212px;"><input type='text' name='send_date' value='$nowDate' readonly style="width:90px; height:20px; line-height:20px; font-family:tahoma; font-size:12px; background-color:transparent; border:0px; letter-spacing:-1;"></div>

						<!-- 달력아이콘 -->
						<div style="position:absolute; top:42px; left:306px; z-index:2; border:0px solid;">
							<a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.happysms_frm.send_date);return false;" HIDEFOCUS><img class="PopcalTrigger" align="absmiddle" src="img/sms_btn_cal.gif" border="0" alt=""></a>
						</div>

						<!-- 전송버튼 -->
						<div style="position:absolute; top:90px; left:164px; z-index:1;"><input type='submit' value='SMS전송' style="width:166px; height:30px; background:url(img/sms_btn_send_bg.gif); color:white; font-weight:bold; font-size:12px; font-family:맑은 고딕,돋움; padding:; border:0px; cursor:pointer;"></div>
					</div>

				</td>
				<td align='left'  style="border:1px dashed #CCC; padding:0 10px 0 10px; line-height:145%;">

					<UL>
						<LI>
						회신번호의 변경을 원하시면 직접 변경하시거나 솔루션환경설정을 조작하십시오.
						<Li>
						받는사람의 전화번호는 회원정보의 휴대폰 정보의 전화번호로 문자가 발송됩니다.
						<LI>
						문자는 80Byte이상 입력시 자동으로 80Byte(한글40글자)로 조절되어 발송됩니다.
						<LI>
						SMS 문자충전은 기타설정 > SMS 관리를 클릭하십시오.
					</UL>

				</td>
			</tr>
			</table>

		</td>
	</tr>
	</table>
</div>

<div class="search_style" style="padding:10px 10px 10px 10px;">
	<div class="box_1"></div>
	<div class="box_2"></div>
	<div class="box_3"></div>
	<div class="box_4"></div>

	<div style="padding:10px 0; text-align:right; font-size:13px;">발송 가능 회원수 <strong>{$sms_ok_count}</strong>명 / 검색된 회원수 <strong>{$Count}</strong>명</div>

	<div style="border:1px dashed #CCC;line-height:20px; padding:15px; background:#fafafa; color:#333;">
		<UL>
			<li>· <strong>발송 가능 회원수</strong>는 SMS 수신 허용 여부에 상관없이 휴대폰번호가 정상적으로 입력된 회원의 수입니다.</li>
			<li style="color:#1143e5;">· 검색된 회원의 수가 <strong>{$happy_sms_email_send_list_limit}</strong>명을 초과하는 경우 하단 회원 목록이 출력되지 않습니다.</li>
			<li>· 하단 회원 목록이 출력되지 않은 상태에서 SMS를 발송하는 경우 검색된 회원 중 발송 가능 회원 전체에게 SMS가 발송됩니다.</li>
			<li>· 선택 체크항목을 이용하여 전체선택 또는 선택한 회원만 SMS 발송됩니다.</li>
		</UL>
	</div>
</div>

<div style="background:url(img/img_list_member_excess.png) center no-repeat; min-height:200px; $list_display2"></div><!-- 회원초과시 출력되는 디자인 -->

<div id="list_style" style="$list_display">
	<table cellspacing="0" cellpadding="0" border="0" class="bg_style table_line">

	<tr>
		<th style='width:40px;'><input type='checkbox' name='allcheck' onClick="allcheck_go()" title="전체선택"></th>
		<th style='width:60px;'>번호</th>
		<th style='width:160px;'>휴대폰</th>
		<th>회원이름(이메일)</th>
		<th style='width:210px;'>아이디</th>
		<th style='width:70px;'>SMS</th>
		<th style='width:90px;'>회원그룹</th>
		<th style='width:140px;'>등록일</th>
	</tr>

	$list


	</table>
</div>


</form>


<div align='center' style='padding:0 0 20px 0;'><input type='button' value='회원목록' class='btn_big' onClick="parent.location.href='happy_member.php'"></div>

END;

include ("tpl_inc/bottom.php");
?>