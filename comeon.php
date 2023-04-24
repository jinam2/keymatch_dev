<?
	//기업회원이 개인회원에게 면접제의
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	$number		= ( $_POST["number"] != "" )?$_POST["number"]:$_GET["number"];
	$mode		= $_POST["mode"];
	$trick_code	= rand(10000,99999);

	if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] )
	{
		echo "
		<script>
		if ( opener )
		{
			opener.location.href = 'happy_member_login.php?returnUrl=".urlencode($_SERVER['REQUEST_URI'])."';
		}
		</script>
		";

		msgclose("로그인 후 이용하세요");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[5]) && $_COOKIE["ad_id"] == "")
	{
		msgclose($happy_member_secure_text[5]." 권한이 없습니다.");
		exit;
	}

	if ( $number == "" )
	{
		msgclose("잘못된 경로로 접근하셨습니다.");
		exit;
	}

	if ( $mode == "okletsmoveout" )
	{
		global $_POST, $site_name, $master_name, $admin_email, $_SESSION, $links;
		global $사이트이름, $운영자이름, $회원이름, $회원아이디, $회원패스워드;

		$name		= $_POST["mail_name"];
		$email		= $_POST["mail_email"];
		$phone		= $_POST["mail_phone"];
		$guin_number= $_POST["guin_number"];
		$comment	= nl2br($_POST["mail_content"]);
		$spamcheck	= $_POST["spamcheck"];
		$realspam	= $_SESSION["antispam"];

		if ( $guin_number == "" )
		{
			error("구직정보를 선택해주세요.");
			exit;
		}
		else if ( $spamcheck != $realspam )
		{
			msgclose("이미지의 문자와 일치하지 않습니다.");
			exit;
		}
		else
		{

			$추가내용	= $comment;
			$바로가기	= $main_url ."/guin_detail.php?num=$guin_number";
			$Sql	= "SELECT user_email1,user_name,user_id FROM $per_document_tb WHERE number='$number' ";
			$Temp	= happy_mysql_fetch_array(query($Sql));

			$Reciveemail	= $Temp["user_email1"];
			$Recivename		= $Temp["user_name"];


			##################################################################################################################
				$sql = "select * from $guin_tb where number='$guin_number'";
				$result = query($sql);
				$DETAIL = happy_mysql_fetch_array($result);
				$DETAIL["guin_date_cut"]	= substr($DETAIL["guin_date"],0,10);


				$view_ok	= $_GET["view_ok"];
				if ( $view_ok == "y" && $_COOKIE["per_id"] != "" )
				{
					$Sql	= "UPDATE $com_want_doc_tb SET read_ok='Y' WHERE per_id='$user_id' AND guin_number='$num' ";
					query($Sql);
				}

				$clickChk			= $_GET["clickChk"];
				if ( $clickChk != "" && $DETAIL[$clickChk] != "" && $DETAIL[$clickChk] != 0 )
				{
					$Sql	= "update $guin_tb SET $clickChk = $clickChk - 1 WHERE number='$num'";
					query($Sql);
				}


				$j ='0'; #type
				$this_bold = "";
				$DETAIL[icon] = "";
				foreach ($ARRAY as $list){
					$list_option = $list . "_option";

					if ($CONF[$list_option] == '기간별') {
					$DETAIL[$list] = $DETAIL[$list] - $real_gap; #날짜가 마이너스인 사람은 광고가 끝인사람임
					}
					if ($DETAIL[$list] > 0 ){ #볼드는 아이콘을 안보여준다 : detail에서는 다 보여주자
					$DETAIL[icon] .= "<img src=${main_url}/img/$ARRAY_NAME2[$j] border=0 align=absmiddle> ";
					}
				$j++;
				}

				/////////////////상시채용인지 확인
				if ( $DETAIL[guin_choongwon] ) {
					$DETAIL[guin_end_temp] = "충원시";
				}
				else {
					$DETAIL[guin_end_temp] = "$DETAIL[guin_end_date]";
				}

				for ( $i=1 ; $i<=5 ; $i++ )
				{
					if ( $DETAIL["img".$i] != "" )
					{
						$tmp		= explode(".",$DETAIL["img".$i]);
						$image_ext	= $tmp[sizeof($tmp)-1];
						$image_name	= str_replace( ".".$image_ext , "_thumb.".$image_ext , $DETAIL["img".$i]);

						${"이미지".$i}		= "<img src='${main_url}/". $image_name ."' width='$guin_pic_width[1]' height='$guin_pic_height[1]' align='absmiddle' style='cursor:pointer' onClick=\"window.open('guin_detail_img.php?num=$num&nowImage=$i','guin_img_view','width=500,height=400,scrollbars=yes,toolbar=no')\">";
						${"이미지설명".$i}	= $DETAIL["img_text".$i];
					}
					else
					{
						${"이미지".$i}		= "<img src='${main_url}/img/guin_noimg.gif' align='absmiddle'>";
						${"이미지설명".$i}	= "";
						$DETAIL["img".$i]	= "${main_url}/img/no_guin_img.gif";
					}
				}


				/////////////////나이제한
				if ( $DETAIL[guin_age] == "0" ) {
					$DETAIL[guin_age_temp] = "제한 없음";
				}
				else {
					$DETAIL[guin_age_temp] = "$DETAIL[guin_age] 년 이후 출생자";
				}

				//////////////////경력 여부
				if ( $DETAIL[guin_career] == "경력" ) {
					$DETAIL[guin_career_temp] = "경력 $DETAIL[guin_career_year] 이상";
				}
				else {
					$DETAIL[guin_career_temp] = "$DETAIL[guin_career]";
				}

				#근무지역
				if ($DETAIL[si1]){
					if ($GU{$DETAIL[gu1]} == ''){
					$GU{$DETAIL[gu1]} = '전체';
					}
				$DETAIL[area] .= "&nbsp;&nbsp;".$SI{$DETAIL[si1]} . " - " . $GU{$DETAIL[gu1]} ;
				}
				if ($DETAIL[si2]){
					if ($GU{$DETAIL[gu2]} == ''){
					$GU{$DETAIL[gu2]} = '전체';
					}
				$DETAIL[area] .= "<br>&nbsp;&nbsp;" . $SI{$DETAIL[si2]} . " - " . $GU{$DETAIL[gu2]} ;
				}
				if ($DETAIL[si3]){
					if ($GU{$DETAIL[gu3]} == ''){
					$GU{$DETAIL[gu3]} = '전체';
					}
				$DETAIL[area] .= "<br>&nbsp;&nbsp;" . $SI{$DETAIL[si3]} . " - " . $GU{$DETAIL[gu3]} ;
				}

				#채용분야
				if ($DETAIL[type1]){
				$DETAIL[type] .= "&nbsp;&nbsp;".$TYPE{$DETAIL[type1]} . " - " . $TYPE_SUB{$DETAIL[type_sub1]} ;
				}
				if ($DETAIL[type2]){
				$DETAIL[type] .= "<br>&nbsp;&nbsp;".$TYPE{$DETAIL[type2]} . " - " . $TYPE_SUB{$DETAIL[type_sub2]} ;
				}
				if ($DETAIL[type3]){
				$DETAIL[type] .= "<br>&nbsp;&nbsp;".$TYPE{$DETAIL[type3]} . " - " . $TYPE_SUB{$DETAIL[type_sub3]} ;
				}

				#외국어능력
				list($DETAIL[lang_title1],$DETAIL[lang_type1],$DETAIL[lang_point1],$DETAIL[lang_title2],$DETAIL[lang_type2],$DETAIL[lang_point2]) = split(",",$DETAIL[guin_lang]);
				#인터뷰정리 , 내용
				$DETAIL[guin_interview] = ereg_replace ("\n", "<br>", $DETAIL[guin_interview]);
				#복리후생
				$DETAIL[guin_bokri] = ereg_replace (">", ",", $DETAIL[guin_bokri]);

				#회사정보뽑기
				$sql = "select * from $happy_member where user_id='$DETAIL[guin_id]'";
				$result = query($sql);
				$COM = happy_mysql_fetch_array($result);

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


				$DETAIL[guin_title] .= $admin_action;


				if ($DETAIL[type1]){
					$add_location1 = " > <a href=guin_list.php?guzic_jobtype1=$DETAIL[type1]>".$TYPE[$DETAIL['type1']] . "</a>";
				}
				if ($DETAIL[type_sub1]){
					$add_location2 = " > <a href=guin_list.php?guzic_jobtype1=$DETAIL[type1]&guzic_jobtype2=$DETAIL[type_sub1]>". $TYPE_SUB[$DETAIL["type_sub1"]] . "</a>";
				}


				$현재위치 = "$prev_stand > <a href=./guin_list.php>구인정보</a> $add_location1 $add_location2  > 상세보기";


				if (  file_exists ("./$COM[etc1]") && $COM[etc1] != ""  )
				{
					$COM[logo_temp] = "<img src='${main_url}/$COM[etc1]' width='150' align='absmiddle'>";
				}
				else
				{
					$COM[logo_temp] = "<img src='${main_url}/img/logo_img.gif' align='absmiddle'>";
				}
			######################################################################################################################


			$접수기간	= $DETAIL['guin_end_date'];
			$복리후생	= $DETAIL['guin_bokri'];
			$우대사항	= $DETAIL['guin_woodae'];
			$키워드		= $DETAIL['keyword'];


			$TPL->define("메인내용", "$skin_folder/comeon_mail.html");
			$content = &$TPL->fetch();


			$comment	= $content;
			#$Reciveemail	= "twoblade16@naver.com,twoblade16@yahoo.co.kr";

			$title		= "$DETAIL[guin_com_name] 회사의 ${name}님 으로부터 면접제의가 들어왔습니다.";

			//메일 함수 통합 - hong
			HappyMail($name, $email,$Reciveemail,$title,$comment);

			$sql = "INSERT INTO $per_want_doc_tb SET
						com_id			= '$COM[user_id]',
						per_id			= '$Temp[user_id]',
						doc_number		= '$number',
						guin_number		= '$guin_number',
						reg_date		= now()
			";

			query($sql);


			// SMS N 쪽지 보내기 :: 개인회원
			if( $Temp["user_id"] != '' )
			{
				$Member			= happy_member_information($Temp["user_id"]);

				if ( $HAPPY_CONFIG['msg_interview_indi_use'] == "1" )
				{
					$HAPPY_CONFIG['msg_interview_indi']		= str_replace("{{아이디}}",$Member['user_id'],$HAPPY_CONFIG['msg_interview_indi']);
					$HAPPY_CONFIG['msg_interview_indi']		= str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['msg_interview_indi']);

					$HAPPY_CONFIG['msg_interview_indi']		= addslashes($HAPPY_CONFIG['msg_interview_indi']);

					$sql = "INSERT INTO ";
					$sql.= $message_tb." ";
					$sql.= "SET ";
					$sql.= "sender_id = '".$Member['user_id']."', ";
					$sql.= "sender_name = '".$Member['user_name']."', ";
					$sql.= "sender_admin = 'n', ";
					$sql.= "receive_id = '".$admin_id."', ";
					$sql.= "receive_name = '관리자', ";
					$sql.= "receive_admin = 'y', ";
					$sql.= "message = '".$HAPPY_CONFIG['msg_interview_indi']."', ";
					$sql.= "regdate = now() ";
					//echo $sql . '<br /><br /><br /><br /><br /><br />';
					query($sql);
				}

				if ( $HAPPY_CONFIG['sms_interview_indi_use'] == "1" || $HAPPY_CONFIG['sms_interview_indi_use'] == "kakao" )
				{
					$SMSMSG["sms_interview_indi"] = sms_convert($HAPPY_CONFIG["sms_interview_indi"],'','','','',$site_phone,'','','',$Member['user_id']);

					$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['sms_interview_indi'],5,$sms_testing,'',$HAPPY_CONFIG['sms_interview_indi_use'],$HAPPY_CONFIG['sms_interview_indi_ktplcode']);
					send_sms_socket($dataStr);
				}
			}

			// SMS N 쪽지 보내기 :: 기업회원
			if( $happy_member_login_value != '' )
			{
				$Member			= happy_member_information($happy_member_login_value);
				$Member_per		= happy_member_information($Temp["user_id"]);

				if ( $HAPPY_CONFIG['msg_interview_corp_use'] == "1" )
				{
					$HAPPY_CONFIG['msg_interview_corp']		= str_replace("{{아이디}}",$Member_per['user_id'],$HAPPY_CONFIG['msg_interview_corp']);
					$HAPPY_CONFIG['msg_interview_corp']		= str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['msg_interview_corp']);

					$HAPPY_CONFIG['msg_interview_corp']		= addslashes($HAPPY_CONFIG['msg_interview_corp']);

					$sql = "INSERT INTO ";
					$sql.= $message_tb." ";
					$sql.= "SET ";
					$sql.= "sender_id = '".$Member['user_id']."', ";
					$sql.= "sender_name = '".$Member['user_name']."', ";
					$sql.= "sender_admin = 'n', ";
					$sql.= "receive_id = '".$admin_id."', ";
					$sql.= "receive_name = '관리자', ";
					$sql.= "receive_admin = 'y', ";
					$sql.= "message = '".$HAPPY_CONFIG['msg_interview_corp']."', ";
					$sql.= "regdate = now() ";
					//echo $sql . '<br /><br /><br /><br /><br />';
					query($sql);
				}

				if ( $HAPPY_CONFIG['sms_interview_corp_use'] == "1" || $HAPPY_CONFIG['sms_interview_corp_use'] == "kakao" )
				{
					$SMSMSG["sms_interview_corp"] = sms_convert($HAPPY_CONFIG["sms_interview_corp"],'','','','',$site_phone,'','','',$Member_per['user_id']);

					$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['sms_interview_corp'],5,$sms_testing,'',$HAPPY_CONFIG['sms_interview_corp_use'],$HAPPY_CONFIG['sms_interview_corp_ktplcode']);
					send_sms_socket($dataStr);
				}
			}

			if ($_COOKIE['happy_mobile'] == "on")
			{
				if ($_POST['returnUrl'] != "")
				{
					gomsg("성공적으로 메일이 발송되었습니다.",$_POST['returnUrl']);
				}
				else
				{
					gomsg("성공적으로 메일이 발송되었습니다.",'document_view.php?number='.$number);
				}
			}
			else
			{
				msgclose("성공적으로 메일이 발송되었습니다.");
			}
			exit;
		}
	}

	$Sql	= "SELECT number,guin_title FROM $guin_tb WHERE guin_id='$user_id'  AND ( guin_end_date >= curdate() OR guin_choongwon='1' ) ";
	$Record	= query($Sql);

	$array			= Array();
	$array_number	= Array();

	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		array_push($array,kstrcut($Data["guin_title"], 55, "..."));
		array_push($array_number,$Data["number"]);
	}

	$구인선택	= make_selectbox2($array,$array_number,"채용공고를 선택해주세요.","guin_number","");

	#선택된 채용정보가 없을 경우 아래 템플릿 파일을 사용하도록 수정됨
	#2009-04-14 kad 수정함
	if ( count($array) <= '0' )
	{
		$file = "comeon_notguin.html";
	}
	else
	{
		$file		= "comeon.html";
	}
	#선택된 채용정보가 없을 경우 아래 템플릿 파일을 사용하도록 수정됨
	#2009-04-14 kad 수정함


	#$file		= "comeon.html";
	$fullTemp	= "login_default.html";


	$TPL->define("상세", "./$skin_folder/$file");
	$TPL->assign("상세");
	echo $TPL->fetch();


?>