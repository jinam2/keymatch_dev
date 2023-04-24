<?
	$t_start = array_sum(explode(' ', microtime()));

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");


	if ( !admin_secure("직종설정") ) {
			error("접속권한이 없습니다.");
			exit;
	}


	//관리자메뉴 [ YOON :2009-10-07 ]
	################################################
	//관리자메뉴, 상단, 좌측메뉴, HTML 소스코드파일
	include ("tpl_inc/top_new.php");
	################################################


	$inquiry_number			= ( $_GET['number'] != "" ) ? $_GET['number'] : $_POST['number'];
	$mode					= ( $_GET['mode'] != "" ) ? $_GET['mode'] : $_POST['mode'];

	if ( $inquiry_number == "" )
	{
		error("문의내역 고유번호가 없습니다.");
		exit;
	}

	$Sql					= "SELECT * FROM $happy_inquiry WHERE number = '$inquiry_number' ";
	$Result					= query($Sql);
	$Data					= happy_mysql_fetch_array($Result);

	$Sql					= "SELECT * FROM $happy_inquiry_links WHERE number ='$Data[links_number]' ";
	$Result					= query($Sql);
	$Links					= happy_mysql_fetch_array($Result);

	if ( $Links['number'] == "" )
	{
		$Links['number']		= "없음";
		$Links['guin_id']		= "";
		$Links['guin_title']		= "메인페이지 문의";
	}


	if ( $mode == "mod_reg" )
	{
		if ( $_POST['select_info_number'] != "" )
		{
			$Sql				= "SELECT * FROM $happy_inquiry_links WHERE number ='$_POST[select_info_number]'";
			$Result				= query($Sql);
			$Links				= happy_mysql_fetch_array($Result);
		}

		$Sql				= "
								UPDATE
										$happy_inquiry
								SET
										admin_memo		= '$_POST[admin_memo]',
										links_number	= '$Links[number]',
										links_title		= '$Links[guin_title]',
										receive_id		= '$Links[guin_id]',
										stats			= '$_POST[stats]'
								WHERE
										number			= '$inquiry_number'";
		query($Sql);

		if ( $_POST['re_send'] == "y" && $Links['number'] != "" )
		{
			# 메일발송
			if ( preg_match("/mail/",$_POST['resend_type'] ) )
			{
				msg("메일발송");
				happy_inquiry_mail_send($inquiry_number);
			}

			# SMS발송
			if ( preg_match("/sms/",$_POST['resend_type'] ) )
			{
				msg("SMS발송");
				$receive_phone = $LinksData['guin_phone'];

				//SMS발송 컨버팅 (받는번호,업체명,담당자,접수자명)
				$sms_str = happy_inquiry_sms_convert($receive_phone,$Links['guin_com_name'],$Links['guin_name'],$Data['user_name']);
				send_sms_socket($sms_str); //SMS 소켓 발송
			}
		}

		go("happy_inquiry_view.php?number=$inquiry_number");
		exit;
	}



	if ( $Links['number'] != "" )
	{
		$links_img		= "..".$Links['img_0'];
		$info_maemool	= "
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td>
				<table width='100%' cellspacing='0' cellpadding='0'>
				<tr>
					<td><font class=item_txt>채용정보명 : $Links[guin_title]</font></td>
				</tr>
				<tr>
					<td><font class=item_txt>담당자 : $Links[guin_name]</font></td>
				</tr>
				<tr>
					<td><font class=item_txt>이메일 : $Links[guin_email]</font></td>
				</tr>
				<tr>
					<td><font class=item_txt>연락처 : $Links[guin_phone]</font></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		"; // 정보보기
	}
	else
	{
		$info_maemool = "채용정보가 없습니다. ";
	}

	$Data['links_number'] = ( $Data['links_number'] == 0 ) ? "" : $Data['links_number'];

	$처리상태			= make_selectbox2($happy_inquiry_stats_array,array_keys($happy_inquiry_stats_array),"-- 처리상태 --",'stats',$Data['stats'],'120');

	#장부수정페이지
	print <<<END

	<SCRIPT type="text/javascript">
	<!--
		function select_info_window(number)
		{
			window.open("happy_inquiry_select_info.php?number=" + number ,"select_info","width=700, height=750, scrollbars=yes");
		}
	//-->
	</SCRIPT>


	<!-- 결제장부수정 [ start ] -->
	<form action=happy_inquiry_view.php method=post name=fForm>
	<input type="hidden" name="mode" value="mod_reg">
	<input type="hidden" name="number" value="$Data[number]">

	<div class="main_title">고유번호: <font color="#0080FF">$Data[number]</font> 문의내역 상세보기</div>



	<!-- RND-TBL -->
		<div id="box_style">
			<div class="box_1"></div>
			<div class="box_2"></div>
			<div class="box_3"></div>
			<div class="box_4"></div>

			<table cellspacing="1" cellpadding="0" class='bg_style'>


			<!-- 업체번호 -->
			<tr>
				<th style='width:120px;'><font class=item_txt>채용정보번호</font></th>
				<td>

					<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><input type="text" name='select_info_number' id='select_info_number' value="$Data[links_number]" class="input_type1"></td>
						<td>
							<a href='javascript:void(0);' onclick='select_info_window($_GET[number]);' class="btn_small_blue">
								채용정보지정
							</a>
						</td>
					</tr>
					</table>
					<div class="help_style" style="margin-top:15px">
						<div class="box_1"></div>
						<div class="box_2"></div>
						<div class="box_3"></div>
						<div class="box_4"></div>
						<span class="help">도움말</span>
						<p>
						채용정보 고유번호를 모르실 경우 [펜션지정] 버튼을 클릭하여 원하는 채용정보를 선택할 수 있습니다.
						</p>
					</div>
				</td>
			</tr>

			<!-- 업체정보 -->
			<tr>
				<th><font class=item_txt>채용정보</font></th>
				<td class=tbl_box2_padding>
					$info_maemool
				</td>
			</tr>

			<!-- 문의내용 -->
			<tr>
				<th><font class=item_txt>문의내용</font></th>
				<td>

END;
			happy_inquiry_form("자동","정보보기","happy_inquiry_view_rows.html","happy_inquiry_view_rows_default.html","자동");

			print <<<END
				</td>
			</tr>

			<!-- 처리상태 -->
			<tr>
				<th>처리상태</th>
				<td class=input_style_adm>
					$처리상태
				</td>
			</tr>

			<!-- 문의댓글 -->
			<tr>
				<th><font class=item_txt>댓글</font></th>
				<td>

END;
					happy_inquiry_comment_list("페이지당5개","happy_inquiry_comment_list_rows.html");

				print <<<END
					$댓글페이징
				</td>
			</tr>

			<!-- 관리자메모 -->
			<tr>
				<th><font class=item_txt>관리자메모</font></th>
				<td><textarea name=admin_memo rows=6 style="width:98%; height:50px;">$Data[admin_memo]</textarea></td>
			</tr>

			<!-- 재발송 -->
			<tr>
				<th><font class=item_txt>알림 재발송 여부</font></th>
				<td class="input_style_adm">
					<select name="resend_type">
						<option value="mail_sms">이메일+SMS</option>
						<option value="mail">이메일만</option>
						<option value="sms">SMS만</option>
					</select>
					<input type="checkbox" name="re_send" value="y" id="re_send" style="width:17; height:17; border:0px; background-color:white; "> <label for="re_send">재발송</label>

					<div class="help_style" style="margin-top:15px">
						<div class="box_1"></div>
						<div class="box_2"></div>
						<div class="box_3"></div>
						<div class="box_4"></div>
						<span class="help">도움말</span>
						<p>
							채용정보 등록인에게 문의내용 재발송을 원하시면 체크 후 수정하시면 됩니다.<br>
							단, 채용정보가 지정된 상태여야 발송이 가능합니다.
						</p>
					</div>
				</td>
			</tr>

			</table>
		</div>



	<!-- 수정 / 취소 버튼 -->
	<div align='center'><input type='submit' value='수정' class='btn_big'> <A HREF="happy_inquiry_list.php" class='btn_big_gray'>취소</A></div>
	</form>

END;

	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}


	# YOON : 2009-10-29 ###
	################################################
	#하단부분 HTML 소스코드
	include ("tpl_inc/bottom.php");
	################################################
?>