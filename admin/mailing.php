<?

	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/Template.php");
	$TPL = new Template;
	include ("../inc/lib.php");

	if ( !admin_secure("회원메일링") ) {
			error("접속권한이 없습니다.");
			exit;
	}

	include ("tpl_inc/top_new.php");

	$mode	= $_GET["mode"];
	$number	= $_GET["number"];

	#구인구직회원 per=0 / com=1
	if ($_REQUEST['keyword1'] == "0")
	{
		$member_type_text = "개인회원";
		$member_search_name		= Array("전체검색","아이디","이름","닉네임","이메일","주소검색","상세주소검색");
		$member_search_value	= Array("all","user_id","user_name","user_nick","user_email","user_addr1","user_addr2");

		$member_prefix_name		= Array("성별검색","남성","여성");
		$member_prefix_value	= Array("all","man","girl");


		//회원그룹쿼리
		$mem_group_sql = " WHERE `group` = '1' ";

	}
	else if ($_REQUEST['keyword1'] == "1" )
	{
		$member_type_text = "기업회원";
		$member_search_name		= Array("전체검색","아이디","이름","닉네임","이메일","주소검색","상세주소검색");
		$member_search_value	= Array("all","user_id","user_name","user_nick","user_email","user_addr1","user_addr2");

		$member_prefix_name		= Array("성별검색","남성","여성");
		$member_prefix_value	= Array("all","man","girl");


		//회원그룹쿼리
		$mem_group_sql = " WHERE `group` = '2' ";
	}
	else
	{
		$keyword1 = "0";
		$member_search_name		= Array("전체검색","아이디","이름","닉네임","이메일","주소검색","상세주소검색");
		$member_search_value	= Array("all","user_id","user_name","user_nick","user_email","user_addr1","user_addr2");

		$member_prefix_name		= Array("성별검색","남성","여성");
		$member_prefix_value	= Array("all","man","girl");


		//회원그룹쿼리
		$mem_group_sql = " WHERE `group` = '1' ";
	}
	#구인구직회원 per=0 / com=1

	if ( $mode == "" )
	{

		$Tmp		= happy_mysql_fetch_array(query("SELECT COUNT(*) FROM $happy_member $mem_group_sql"));
		//echo "SELECT COUNT(*) FROM $happy_member $mem_group_sql";
		$MemCount	= ( $demo_lock )?1500:$Tmp[0];

		#구인구직 업소/개인 보낸 메일 따로 불러오도록 변경
		$Sql		= "SELECT * FROM $happy_mailing WHERE keyword1 = '$_REQUEST[keyword1]' ORDER BY number desc ";
		#$Sql		= "SELECT * FROM $happy_mailing ORDER BY number desc ";
		$Record		= query($Sql);

		$mailList	= "
						<select name='number' id='number' style='width:320px;'>
							<option value=''>--------- 지난 보낸 메일불러오기 ---------</option>
					";
		$Count		= 0;
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$Count++;
			if ( $Data["mailok"] == "Y" )
			{
				$color	= "white";
				$msg	= "<font color='blue'>(전송완료)</font>";
			}
			else
			{
				$color	= "#FFECF1";
				$msg	= "<font color='red'>(마지막전송번호:$Data[lastNumber])</font>";
			}

			if ( $number == $Data["number"] )
			{
				$selected	= "selected";
				$Mail		= $Data;
			}
			else
				$selected	= "";

			$Data["regdate"]	= substr($Data["regdate"],0,10);
			$Data["title"]		= kstrcut($Data["title"], 28, "..");

			$mailList			.= "	<option value='$Data[number]' style='background-color:$color' $selected>[$Data[regdate]]$Data[title] $msg</option>";
		}
		$mailList	.= "</select>";

		//$Mail[content]		= addslashes(str_replace("\n","",str_replace("\r","",$Mail[content])));

		$sendStartSize		= ( $Mail['lastNumber'] > $mailing_send_size )?$Mail['lastNumber']+$mailing_send_size:$mailing_send_size;

		$sending_stop_select	= dateSelectBox( "sending_stop", $sendStartSize, $MemCount, '', "명의 회원까지 발송", "선택", "" , $mailing_send_size);


		// 검색필드 폼 및 값 입력 //

			#$search_out		= make_selectbox3($memtype_search_name,$memtype_search_value,'','keyword1',$Mail['keyword1'],"");
			#성별에 따른 메일링
			$search_out2	= make_selectbox3($member_prefix_name,$member_prefix_value,'','keyword2',$Mail['keyword2']);
			$search_out3	= make_selectbox3($member_search_name,$member_search_value,'','keyword3',$Mail['keyword3']);

			$_GET['email_ok']	= ( $_GET['email_ok'] == '' ) ? 'y' : $_GET['email_ok'];
			$array_name			= array("전체","이메일 수신허용");
			$array_value		= array("all","y");
			$email_ok_info		= make_selectbox3($array_name,$array_value,'','email_ok',$_GET['email_ok'],120);

			$whereText	= "

				$email_ok_info
				$search_out2
				$search_out3
				<input type='text' name='keyword4' value='$Mail[keyword4]' size='20'>
				<!--<b>포인트 : </b>
				<input type='text' name='keyword5' value='$Mail[keyword5]' size='4'  onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" >점이상 ~
				<input type='text' name='keyword6' value='$Mail[keyword6]' size='4'  onKeyPress=\"if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;\" >점이하
				-->
			";
		// 검색필드 폼 및 값 입력 완료 //

		//위지윅에디터CSS
		$editor_css = happy_wys_css("ckeditor","../");
		$editor_js = happy_wys_js("ckeditor","../");

		$editor_menu_content = happy_wys("ckeditor","가로100%","세로300","content","{Mail.content}","../","happycgi_normal");

		echo "
				<!--// 회원관리 메일보내기 [START] // --------------------------------------------------------------------------------->

				<script>
					function delete_mail()
					{
						var mailText	= document.getElementById('number')[document.getElementById('number').selectedIndex].text;
						var mailValue	= document.getElementById('number')[document.getElementById('number').selectedIndex].value;
						var keyword1 = document.getElementById('keyword1').value;
						//alert(keyword1);

						if ( confirm(' 메일 \''+ mailText +'\'을 삭제 하시겠습니까? ') )
						{
							window.location.href='?mode=delete&number='+ mailValue + '&keyword1=' + keyword1;
						}
						return false;
					}

					function sendit()
					{
						if ( document.getElementById('title').value == '' )
						{
							alert('메일제목을 입력해주세요');
							return false;
						}
					}
				</script>

				$editor_css
				$editor_js

				<!-------------------// 내용 CONTENT [START] //--------------------------------------------------------->
<p class='main_title'>$now_location_subtitle <label><a href='http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=26' target='_blank'><img src='img/btn_help.gif' border='0'></a></label></p>

<div id='box_style'>
	<div class='box_1'></div>
	<div class='box_2'></div>
	<div class='box_3'></div>
	<div class='box_4'></div>

	<table cellspacing='1' cellpadding='0' class='bg_style box_height'>
	<!-- 메일링 안내사항 -->
	<tr>
		<th colspan='2'><b>메일링 안내사항</b></th>
	</tr>
<tr bgcolor=white>
	<td class=tbl_box2_padding style='line-height:165%; font-size:11px;'  class='spanbox' colspan='5'>
		<strong style='color:#5670c7;'>메일발송전 유의사항</strong><br/>
		<div style='color:#777; padding:5px 0px 15px 0px; clear:both; width:100%; font-size:11px;'>
			- <span style='color:#5670c7; font-family:돋움; font-weight:normal; font-size:11px; '>HTML 형식</span>으로 메일링이 발송됩니다.<br/>
			- <span style='color:#5670c7; font-family:돋움; font-weight:normal; font-size:11px; '>정식회원 전체</span>에게 메일링이 발송이 됩니다. 단, 대기회원은 메일이 발송되지 않습니다.<br/>
			- 메일링에 사용할 <span style='color:#5670c7; font-family:돋움; font-weight:normal;font-size:11px;  '>이미지의 경로는 FULL URL</span>을 입력하셔야 합니다. 예:&lt;img src='http://test.com/test_image.jpg'&gt; <br/>
		</div>
		<strong style='color:#d50000;'>메일발송이 되지 않을 때</strong><br/>
		<div style='color:#777; font-size:11px; padding:5px 0px; clear:both; width:100%; font-size:11px;'>
			- 고객님의 <span style='color:#d50000; font-size:11px; font-family:돋움; font-weight:normal; '>웹호스팅사에 메일함수</span>가 정상작동하는지 점검요청합니다. <br/>
			- 각 웹호스팅사 <span style='color:#d50000;font-size:11px;  font-family:돋움; font-weight:normal; '>일일발송량 제한</span>에 따라 발송되지 않을 수 있습니다.
			<span style='color:#d50000; font-family:돋움; font-size:11px; font-weight:normal; '>(카페24: 한번에 30통이하 / 하루에 500통이하만 발송가능</span>) <br/>
			- 서버에서 발송이 정상일 경우 각 메일회사 스팸정책에 의해 차단될 수 있으므로 <span style='color:#d50000;font-size:11px;  font-family:돋움; font-weight:normal; '>화이트도메인 신청여부를 확인</span>해 보셔야 합니다.<br/>
		</div>
		<div style='padding:5px 0px 8px 10px; width:100%; clear:both;'>
			<a href='http://cgimall.co.kr/happy_faq/board_detail.cgi?db=board_faq&thread=304&page=1&search_type=&search_word=' target='_blank'><img src='img/btn_noemail.gif' border='0'></a>&nbsp;<a href='http://cgimall.co.kr/happy_faq/board_detail.cgi?db=board_faq&thread=173&page=1&search_type=&search_word=' target='_blank'><img src='img/btn_whitedomain.gif' border='0'></a>
		</div>
	</td>
</tr>

	<tr>
		<th colspan='2'><b>$member_type_text 메일링</b></th>
	</tr>
	<tr>
		<td colspan='2'>
			<form>
			<input type='hidden' name='mode' value=''>
			<table cellspacing='0' cellpadding='0' border='0'>
			<tr>
				<td>
					<input type='submit' value='메일선택' class='btn_small_blue'>
					<input type='button' value='메일삭제' class='btn_small_dark'>
					<input type='button' value='새로작성' class='btn_small_navy'>
				</td>
				<td>$mailList</td>
			</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
			<form method='post' name='popup_regist' action='mailing.php?mode=mail_reg' onSubmit='return sendit(this)'>
				<input type='hidden' name='number' value='$number'>
				<!--구인구직 회원타입-->
				<input type='hidden' name='keyword1' value='$_REQUEST[keyword1]'>
				<!--구인구직 회원타입-->
				$whereText
		</td>
	</tr>
	<tr>
		<th>메일제목</th>
		<td><input type='text' name='title' style='width:90%' value='$Mail[title]'></td>
	</tr>
	<tr>
		<th colspan='2'>메일내용</th>
	</tr>
	<tr>
		<td colspan='2'>
			$editor_menu_content
		</td>
	</tr>
	<tr>
		<th colspan='2'>
		$sending_stop_select <input type='submit' value='메일발송' class='btn_small_dark'> <input type='button' value='취소' onClick='history.back()' class='btn_small_stand'>
		</th>
	</tr>
	</table>
</div>


</form>


		";
	}

	else if ( $mode == "mail_reg" )
	{

		#keyword1 : 0 = 개인회원 / 1 = 업소회원
		#print_r2($_POST);



		$title		= $_POST["title"];
		$number		= $_POST["number"];
		$content	= $_POST["content"];

		$keyword1	= $_POST["keyword1"];
		#$keyword2	= $_POST["keyword2"];
		$keyword3	= $_POST["keyword3"];
		$keyword4	= $_POST["keyword4"];
		$keyword5	= $_POST["keyword5"];
		$keyword6	= $_POST["keyword6"];
		$keyword7	= $_POST["keyword7"];
		$keyword8	= $_POST["keyword8"];

		#수신동의회원 추가함
		$email_ok = $_POST['email_ok'];

		if ( $auto_addslashe )
		{
			$title		= addslashes($title);
			//$content	= addslashes($content);
			$keyword1	= addslashes($keyword1);
			#$keyword2	= addslashes($keyword2);
			$keyword3	= addslashes($keyword3);
			$keyword4	= addslashes($keyword4);
			$keyword5	= addslashes($keyword5);
			$keyword6	= addslashes($keyword6);
			$keyword7	= addslashes($keyword7);
			$keyword8	= addslashes($keyword8);
		}

		////////// 넘어온 회원 검색을 토대로 쿼리문 제작 //////////////
		#구인구직이라 쿼리 변경됨
		$whereQuery	= '';

		if ( $email_ok == 'y' )
		{
			$whereQuery	= " WHERE email_forwarding = 'y' ";
		}


		//일반회원
		if ( $keyword1 == "0" )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';
			$whereQuery	.= "  `group` = '1'  ";
		}
		//기업회원
		else if ( $keyword1 == "1" )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';
			$whereQuery	.= "  `group` = '2'  ";
		}


		#성별별로 보내기 남자=남자 / 여자=여자
		if ( $keyword1 == '0' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';

			if ( $keyword2 == 'man' )
			{
				$whereQuery	.= "  user_prefix = 'man'  ";
			}
			else if ($keyword2 == 'girl' )
			{
				$whereQuery	.= " user_prefix = 'girl' ";
			}
			else
			{
				$whereQuery	.= ' 1 = 1 ';
			}
		}

		if ( $keyword4 != '' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';

			if ( $keyword3 == 'all' )
			{
				#개인회원 컬럼 Array("all","id","per_name","per_email","per_addr1","per_addr2");
				if ( $keyword1 == '0' ) {
					$whereQuery	.= "
									(
										user_id like '%$keyword4%' OR
										user_name like '%$keyword4%' OR
										user_email like '%$keyword4%' OR
										user_addr1 like '$keyword4%' OR
										user_addr2 like '%$keyword4%'
									)
							";
				} else {
				#업소회원 컬럼 Array("all","id","com_name","com_email","com_addr1","com_addr2");
					$whereQuery	.= "
									(
										user_id like '%$keyword4%' OR
										user_name like '%$keyword4%' OR
										user_email like '%$keyword4%' OR
										user_addr1 like '$keyword4%' OR
										user_addr2 like '%$keyword4%'
									)
							";
				}
			}
			else if ( $keyword3 == 'address1' )
			{
				$whereQuery	.= " user_addr1 like '$keyword4%' ";
			}
			else
			{
				$whereQuery	.= " $keyword3 like '%$keyword4%' ";
			}
		}

		$keyword5	= preg_replace("/\D/","",$keyword5);
		$keyword6	= preg_replace("/\D/","",$keyword6);

		if ( $keyword5 != '' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';
			$whereQuery	.= " point >= $keyword5 ";
		}

		if ( $keyword6 != '' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';
			$whereQuery	.= " point <= $keyword6 ";
		}

		$searchQuery		= $whereQuery;
		$whereQuery			= addslashes($whereQuery);


		/*
		$whereQuery	= '';
		if ( $keyword1 != 'all' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';
			$whereQuery	.= " gija = '$keyword1' ";
		}

		if ( $keyword2 != 'all' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';

			if ( $keyword2 == '1' )
			{
				$whereQuery	.= " ( left(joomin2,1)='1' OR left(joomin2,1)='3' OR left(joomin2,1)='5' ) ";
			}
			else
			{
				$whereQuery	.= " ( left(joomin2,1)='2' OR left(joomin2,1)='4' OR left(joomin2,1)='6' ) ";
			}

		}

		if ( $keyword4 != '' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';

			if ( $keyword3 == 'all' )
			{
				$whereQuery	.= "
								(
									id like '%$keyword4%' OR
									name like '%$keyword4%' OR
									email like '%$keyword4%' OR
									address1 like '$keyword4%' OR
									address2 like '%$keyword4%'
								)
						";
			}
			else if ( $keyword3 == 'address1' )
			{
				$whereQuery	.= " address1 like '$keyword4%' ";
			}
			else
			{
				$whereQuery	.= " $keyword3 like '%$keyword4%' ";
			}
		}

		$keyword5	= preg_replace("/\D/","",$keyword5);
		$keyword6	= preg_replace("/\D/","",$keyword6);

		if ( $keyword5 != '' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';
			$whereQuery	.= " point >= $keyword5 ";
		}

		if ( $keyword6 != '' )
		{
			$whereQuery	.= ( $whereQuery == '' )?' WHERE ':' AND ';
			$whereQuery	.= " point <= $keyword6 ";
		}

		$searchQuery		= $whereQuery;
		$whereQuery			= addslashes($whereQuery);
		*/
		///////////////////////////////////////////////////////////////

		$SetSql	= "
						,
						keyword1	= '$keyword1',
						keyword2	= '$keyword2',
						keyword3	= '$keyword3',
						keyword4	= '$keyword4',
						keyword5	= '$keyword5',
						keyword6	= '$keyword6',
						keyword7	= '$keyword7',
						keyword8	= '$keyword8',
						whereQuery	= '$whereQuery'
				";

		if ( $title == "" || $content == "" )
		{
			error("제목과 메일내용을 입력해주세요");
			exit;
		}

		#echo $SetSql;


		if ( $number == "" )
		{
			$Sql	= "INSERT INTO $happy_mailing SET title='$title', content='$content', lastNumber=0, mailok='N', regdate=now() $SetSql ";
			query($Sql);

			$Sql	= "SELECT number FROM $happy_mailing ORDER BY number desc LIMIT 1";
			$Data	= happy_mysql_fetch_array(query($Sql));
			$number	= $Data["number"];
		}
		else
		{
			$Sql	= "UPDATE $happy_mailing SET title='$title', content='$content' $SetSql WHERE number='$number'";
			query($Sql);
		}

		$Sql	= "SELECT * FROM $happy_mailing WHERE number='$number' ";
		$Data	= happy_mysql_fetch_array(query($Sql));

		$Sql	= "SELECT Count(*) FROM $happy_member $searchQuery ";
		$MEM	= happy_mysql_fetch_array(query($Sql));
		$Total	= ( $demo_lock )?"1500":$MEM[0];


		$addMessage	= ( $demo_lock )?"<SCRIPT LANGUAGE='JavaScript'>objectTAG('sendmailing','swf/sendmailing.swf','400','110','Transparent');</SCRIPT><br><font color=red>데모버젼은 실제발송되지 않습니다.</font><br>메일발송건수는 데모일경우 1500건으로 고정됩니다.<br>":"<SCRIPT LANGUAGE='JavaScript'>objectTAG('sendmailing','swf/sendmailing.swf','400','110','Transparent');</SCRIPT>";

		$sending_stop	= $sending_stop == '' ? 99999999 : $sending_stop ;


		echo "


			<!-------------------// 내용 CONTENT [START] //--------------------------------------------------------->
			<table width='650' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td align='center'>

					<!--// 현재위치 [START] //----------->
					<table border='0' cellspacing='0' cellpadding='0'>
					<tr height='30'>
						<td width='15' background='img/bg_box02a.gif'></td>
						<td background='img/bg_box02b.gif' style='padding:0 5 0 5; font-weight:600; color:#CF0000'><img src='img/ico_arrow_red01.gif'> <font color='#000000'>$member_type_text 메일보내기</font> <font style='font-weight:100'>></font> 메일보내기<img src='img/ico_arrow_red01.gif'></td>
						<td width='15' background='img/bg_box02c.gif'></td>
					</tr>
					</table>
					<!--// 현재위치 [END] //----------->

				</td>
			</tr>
			<tr>
				<td height='20'></td>
			</tr>
			<tr>
				<td>



					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td style='padding-bottom:3px;'>

							<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td style='padding-left:3px;' height='22'>


								</td>

							</tr>
							</table>

						</td>
					</tr>
					</table>


					<!--// 내용을 둘러싸는 테두리 [START] //-->
					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td width='4' height='4' background='img/sin_bg_box11a.gif'></td>
						<td background='img/sin_bg_box11b.gif'></td>
						<td width='4' background='img/sin_bg_box11c.gif'></td>
					</tr>
					<tr>
						<td background='img/sin_bg_box11d.gif'></td>
						<td bgcolor='#FFFFFF' align='center' style='padding:30 70 30 70;'>

							<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td>

									<!--// 내용 //-->
									<script>
									var request;
									var startNumber		= $Data[lastNumber];
									var endNumber		= $Total;
									var sending_stop	= $sending_stop;
									var sendSize		= $mailing_send_size;
									var stopWant		= 'no';
									var mail_percent	= 0;
									var now_width1		= 0;
									var now_width2		= 0;

									function createXMLHttpRequest()
									{
										if (window.XMLHttpRequest) {
										request = new XMLHttpRequest();
										} else {
										request = new ActiveXObject(\"Microsoft.XMLHTTP\");
										}
									}

									function startRequest(linkUrl)
									{
										createXMLHttpRequest();
										request.open(\"GET\", linkUrl , true);
										request.onreadystatechange = handleStateChange;
										request.send(null);
									}


									function handleStateChange()
									{
										if (request.readyState == 4)
										{
											if (request.status == 200)
											{
												var response = request.responseText;
												//alert(request.responseText);

												if ( response == 'ok' )
												{
													go_send_mail('ok');
												}
												else if ( response == 'nomail' )
												{
													document.getElementById('send_message2').innerHTML	= \"<font color='red'>선택하신 메일이 디비에 존재하지 않습니다.</font>\";
												}
												else if ( response == 'err01' )
												{
													alert('필요한 값들이 전송되지 않았습니다. 프로그램을 확인해주십시오.');
												}
												else
												{
													alert('잘못된 접근입니다');
												}

											}
										}
									}

									function go_send_mail( chk )
									{
										if ( stopWant == 'yes' )
										{
											document.getElementById('send_message1').innerHTML	= \"<img src=img/img_sendmail_cancel.gif>\";
											//document.getElementById('send_message1').innerHTML	= \"<font color='red'>메일발송을 취소하셨습니다.</font>\";
										}
										else
										{
											startNumber		= ( chk == 'start' )?startNumber:startNumber + sendSize;
											startNumber		= ( startNumber > endNumber )?endNumber:startNumber;

											if ( sending_stop <= startNumber )
											{
												document.getElementById('send_message1').innerHTML	= \"<font color='blue'>원하시는 번호까지 발송을 마쳤습니다..</font>\";
											}
											else
											{
												document.getElementById('send_message2').innerHTML	= '('+ endNumber +'/'+ startNumber +')';

												mail_percent	= ( startNumber == endNumber )?100:Math.floor( ( startNumber / endNumber ) * 100 );
												now_width1		= mail_percent * 6;
												now_width2		= 600 - now_width1;

												document.getElementById('sending').innerHTML	= \"<table width='100%' align='center' cellspacing='0' cellpadding='0' border='0'><tr height='15'><td width='100%'><table width='100%' height='10' bgcolor='gray' align='right' cellspacing='1' cellpadding='0' border='0'><tr><td height='10' width='\"+ now_width1 +\"' bgcolor='gray' align='center'><font style='font:bold 9pt verdana; color:white;'>\"+ mail_percent +\"%</font></td><td height='10' width='\"+ now_width2 +\"' bgcolor='white'></td></tr></table></td></tr></table>\";

												if ( startNumber < endNumber )
													startRequest('mail_send.php?start='+ startNumber +'&sendSize='+ sendSize +'&number=$number' + '&keyword1=$_REQUEST[keyword1]');
												else
												{
													document.getElementById('send_message1').innerHTML		= \"<img src=img/img_sendmail_ok.gif>\";
													//document.getElementById('send_message1').innerHTML		= \"<font color='red'>메일 발송이 완료되었습니다.</font>\";
													document.getElementById('send_message3').innerHTML		= '';
													document.getElementById('mail_button1').style.display	= 'none';
													document.getElementById('mail_button2').style.display	= '';
												}
											}
										}
									}


								</script>




								<table align='center' width='100%'>
								<tr>
									<td align='center' style='padding:10 0 5 0;'>
										<div align='center' id='send_message1'>$addMessage</div>
										<div align='center' id='send_message2' style='font:bold 12pt verdana;'>($Data[lastNumber]/$Total)</div>
									</td>
								</tr>
								<tr>
									<td align='center'>

										<div align='center' id='sending'>
											<table width='100%' align='center' cellspacing='0' cellpadding='0' border='0'>
											<tr height='21'>
												<td width='100%'>

													<table width='100%' height='10' bgcolor='gray' align='right' cellspacing='0' cellpadding='0' border='0'>
													<tr>
														<td height='10' width='125' bgcolor='blue'></td>
														<td height='10' width='275' bgcolor='white'></td>
													</tr>
													</table>

												</td>
												<td width='40' style='padding-left:5px'>30%</td>
											</tr>
											</table>
										</div>

									</td>
								</tr>
								<tr>
									<td align='center' height='35' valign='bottom' style='padding:20 0 20 0;'><input type='image' src='img/btn_sendmail_cancel.gif' id='mail_button1' value='메일전송중단' onClick=\"stopWant='yes';document.getElementById('mail_button1').style.display= 'none';document.getElementById('mail_button2').style.display= '';\"><input type='image' src='img/btn_sendmail_prev.gif' id='mail_button2' value='이전화면으로' onClick=\"window.location.href='mailing.php?keyword1=$_REQUEST[keyword1]';\" style='display:none'><div align='center' id='send_message3' style='padding:15 0 0 0;'>메일을 추후 발송을 원하시면 메일전송중단 버튼을 누르십시오.<br>추후에 연결되어 전송이 가능해집니다.</div></td>
								</tr>
								</table>


								<script>
									go_send_mail('start'); //전송시작
								</script>

								<!--// 내용 //-->



							</td>
						</tr>
						</table>

					</td>
					<td  background='img/sin_bg_box11e.gif'></td>
				</tr>
				<tr>
					<td height='4' background='img/sin_bg_box11f.gif'></td>
					<td background='img/sin_bg_box11g.gif'></td>
					<td background='img/sin_bg_box11h.gif'></td>
				</tr>
				</table>


				<!--// 내용을 둘러싸는 테두리 [END] //-->

			</td>
			</tr>

			<!----------------------------------------------------------------------------------------------------------->

			</table>
			<!-------------------// 내용 CONTENT [END] //--------------------------------------------------------->

			<!--// 회원관리 메일보내기 [END] //--------------------------------------------------------------------------------->
		";
	}


	else if ( $mode == "delete" )
	{
		$Sql	= "DELETE FROM $happy_mailing WHERE number='$number' ";
		query($Sql);
		go("?keyword1=$_REQUEST[keyword1]");
		exit;
	}



include ("tpl_inc/bottom.php");

?>