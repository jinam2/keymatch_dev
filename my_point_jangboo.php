<?php
	$t_start = array_sum(explode(' ', microtime()));

	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/lib.php");

	#load_config();

	#포인트 장부사용여부 - sun
	if ( $HAPPY_CONFIG['point_jangboo_use'] != "" )
	{
		error("포인트 장부는 사용할 수 없습니다.");
		exit;
	}


	$ex_limit = '20';

	if( happy_member_login_check() == "" )
	{
		gomsg("로그인 후 이용가능합니다.",$main_url."/happy_member_login.php");
		exit;
	}

	if ( !happy_member_secure('포인트기능') )
	{
		msg('포인트기능'." 권한이 없습니다.");
		go("./happy_member.php?mode=mypage");
		exit;
	}

	$happy_member_login_id	= happy_member_login_check();

	#토탈 등록갯수를 알려주자
	$sql21		= "select count(*) from $point_jangboo where id = '$happy_member_login_id' ";
	$result21	= query($sql21);
	list($numb)	= happy_mysql_fetch_array($result21);

	$현재위치 = "<img src='img/icon_home.gif' align='absmiddle' style='margin-right:5px; margin-bottom:2px;'><a href='".$main_url."' class='now_location_link'>홈</a> &gt; <a href='happy_member.php?mode=mypage' class='now_location_link'>마이페이지</a> &gt; 포인트결제 내역정보";


	$총갯수 =$numb;

	if ($start == "")
	{
		$start = $_GET[start];
	}
	if($start==0 || $start=="")
	{
		$start=0;
	}

	############ 페이징처리 ############
	$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = $start;
	$co = $numb - $start;

	$Total			= $numb;
	$scale			= $ex_limit;
	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 2 : 6;

	$searchMethod	.= "";

	$page_print		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	############ 페이징처리 ############


	$sql = "select * from $point_jangboo where id = '$happy_member_login_id' order by number desc limit $view_rows,$ex_limit ";
	$result = query($sql);

	$i = "1";
	$main_new_out = "";
	while  ($MONEY = happy_mysql_fetch_array($result))
	{
		//print_r2($MONEY);

		#입금인지 아닌지 정리
		if ($MONEY[in_check] == "0")
		{
			$MONEY[in_check] = "<img src=img/btn/in_check_0.gif border=0 align=absmiddle alt='미입'>";
			$text_info = "포인트 충전";
		}
		elseif ($MONEY[in_check] == "1")
		{
			$MONEY[in_check] = "<img src=img/btn/in_check_1.gif border=0 align=absmiddle alt='입금'>";
			$text_info = "포인트 충전";
		}
		elseif ($MONEY[in_check] == "2")
		{
			$MONEY[in_check] = "<img src=img/btn/in_check_2.gif border=0 align=absmiddle alt='소모'>";
			$text_info = "포인트 결제";
		}
		elseif ($MONEY[in_check] == "3")
		{
			$MONEY[in_check] = "<img src=img/btn/in_check_3.gif border=0 align=absmiddle alt='적립'>";
			$text_info = "포인트 적립";
		}
		else
		{
			$MONEY[in_check] = " <img src=img/btn/in_check_1.gif border=0 align=absmiddle>";
		}
		#결재금액에숫자를
		$tmpPoint = explode("|",$MONEY['point']);

		#$MONEY[point_comma] = number_format($MONEY[point],$LANG[number_format_2]);
		$MONEY[point_comma] = number_format($tmpPoint[0],$LANG[number_format_2]);
		$MONEY[money_comma] = number_format($tmpPoint[1],$LANG[number_format_2]);

		#구매내역 정리끝

		$main_new_out .= <<<END
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rowsTBLheight_mySettleMain">
			<tr onMouseOver="this.style.backgroundColor='#F4F4F4';"  onMouseOut="this.style.backgroundColor='';">
				<!-- 왼쪽여백 -->
				<td class="mypg_myPoint_list_itemTD_blankN01"></td>

				<!-- 결제내역 -->
				<td class="mypg_myPoint_list_itemTDN01" style="text-align:right; padding-right:10;"><font class=1a>$MONEY[point_comma]</font> &nbsp;$text_info</td>
				<td class="mypg_myPoint_list_itemTD_separator"></td>

				<!-- 결제금액 -->
				<td class="mypg_myPoint_list_itemTDN02" style="text-align:right; padding-right:10;"><font class=2a>$MONEY[money_comma]</font> <font class=2b>원</font></td>
				<td class="mypg_myPoint_list_itemTD_separator"></td>

				<!-- 결제방식 -->
				<td class="mypg_myPoint_list_itemTDN03" style="padding:0 0 0 0;"><font>$MONEY[pay_type]</font></td>
				<td class="mypg_myPoint_list_itemTD_separator"></td>

				<!-- 결제일 -->
				<td class="mypg_myPoint_list_itemTDN04"><font>$MONEY[reg_date]</fotn></td>
				<td class="mypg_myPoint_list_itemTD_separator"></td>

				<!-- 입금확인 -->
				<td class="mypg_myPoint_list_itemTDN05">$MONEY[in_check]</td>

				<!-- 오른쪽여백 -->
				<td class="mypg_myPoint_list_itemTD_blankN02"></td>
			</tr>
			</table>
			<!-- 점선라인 -->
			<div class="hrDotLine04"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td></td></tr></table></div>
END;

		$i ++;
	}

	//include ("./page.php");

	if ($numb == "0")
	{
		$내용 = "<tr><td colspan=6 bgcolor=white height=50><center>마일리지 충전 및 사용내역이 없습니다</td></tr> ";
	}
	else
	{
		$내용 =  "$main_new_out ";
		$페이징 = $page_print;
	}


	if ($CONF[point_conf])
	{

		$포인트내역조회 = "
						<tr>
						<td style='padding:0 0 3 0;'><a href='my_point_jangboo.php'><img src='img/tit_mypage_menu_6.gif' align='absmiddle' border='0' alt='포인트내역조회하기'></a></td>
						</tr>
		";
	}


	if ( happy_member_secure( $happy_member_secure_text[1].'등록' ) )
	{
		$Template_file = "member_count_com.html";
		$TPL->define("채용활동정보", $skin_folder."/".$Template_file);
		$채용활동정보 = &$TPL->fetch();
	}

	if ( happy_member_secure( $happy_member_secure_text[0].'등록' ) )
	{
		$Template_file = "member_count_per.html";
		$TPL->define("구직활동정보", $skin_folder."/".$Template_file);
		$구직활동정보 = &$TPL->fetch();
	}


	#$껍데기 = "default.html";



	$Template_file = "my_point_jangboo.html";

	if( !(is_file($skin_folder."/".$Template_file)) )
	{
		print $skin_folder."/".$Template_file." 파일이 존재하지 않습니다. ";
		exit;
	}
	$TPL->define("알맹이", $skin_folder."/".$Template_file);
	$내용 = &$TPL->fetch();


	$Member					= happy_member_information($happy_member_login_id);
	$member_group			= $Member['group'];

	$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
	$Group					= happy_mysql_fetch_array(query($Sql));

	$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];
	$Template_Default		= $Template_Default == '' ? $happy_member_mypage_default_file : $Template_Default;

	if( !(is_file("$skin_folder/$Template_Default")) )
	{
		print "$skin_folder/$Template_Default 파일이 존재하지 않습니다. ";
		exit;
	}

	$TPL->define("리스트", "$skin_folder/$Template_Default");
	$TPL->assign("리스트");

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "Query Time : $exec_time sec";
	$TPL->tprint();



?>