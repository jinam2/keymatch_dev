<?
	//개인회원이 채용정보에 온라인 입사지원 하는 프로그램
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");


	if ( happy_member_login_check() == "" && !$_COOKIE["ad_id"] )
	{
		gomsg("로그인 후 이용하세요","./happy_member_login.php");
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[4]) )
	{
		error($happy_member_secure_text[4]." 권한이 없습니다.");
		exit;
	}

	if ( $_POST["com_id"] == "" || $_POST["per_id"] != $user_id )
	{
		error("잘못된경로로 접근하셨습니다.");
		exit;
	}

	if ( $_POST["mode"] == "action" )
	{
		$cNumber		= $_POST["cNumber"];
		$pNumber		= $_POST["pNumber"];
		$com_id			= $_POST["com_id"];
		$per_id			= $_POST["per_id"];
		$com_name		= $_POST["com_name"];
		$per_name		= $_POST["per_name"];
		$maxAnswer		= $_POST["maxAnswer"];
		$secure			= @implode(",", (array) $_POST["secure"]);

		if ( $pNumber == "" )
		{
			error("접수할 이력서를 선택해주세요.");
			exit;
		}

		if ( $cNumber == "" )
		{
			error("이상한 경로로 접근하셨네요~!");
			exit;
		}

		//헤드헌팅
		$Add_Set		= '';
		if ( $hunting_use == true )
		{
			//헤드헌팅 회사고유번호 뽑기
			$Sql			= "
								SELECT
										company_number
								FROM
										$guin_tb
								WHERE
										number = '$cNumber'
			";
			$H_Temp			= happy_mysql_fetch_assoc(query($Sql));
			$company_number	= $H_Temp['company_number'];

			$Add_Set		= "company_number = '$company_number',";
		}
		//헤드헌팅

		$interview		= "";
		for ( $i=1 ; $i<=$maxAnswer ; $i++ )
		{
			$interview	.= $_POST["answer".$i]."\r\n";
		}

		$Sql		= "SELECT Count(*) FROM $com_guin_per_tb WHERE cNumber='$cNumber' AND per_id='$per_id' ";
		$Temp		= happy_mysql_fetch_array(query($Sql));

		$Sql		= "SELECT number,user_name,user_id FROM $happy_member WHERE user_id='$user_id'";
		$Tmp		= happy_mysql_fetch_array(query($Sql));
		$per_name	= $Tmp["per_name"];

		if ( $Temp[0] != 0 )
		{
			error("이미 온라인 접수한 회사 입니다.");
			#exit;
		}
		else if ( $user_id != $per_id )
		{
			error("해킹시도중?");
			#exit;
		}

		$Sql	= "
				INSERT INTO
						$com_guin_per_tb
				SET
						$Add_Set #헤드헌팅

						pNumber		= '$pNumber',
						cNumber		= '$cNumber',
						com_id		= '$com_id',
						per_id		= '$per_id',
						com_name	= '$com_name',
						per_name	= '$per_name',
						interview	= '$interview',
						read_ok		= 'N',
						doc_ok		= 'N',
						regdate		= now(),
						secure		= '$secure',
						online_stats= online_stats+1
		";

		query($Sql);			// kad 작업하려고 임시

		#온라인입사지원한 이력서의 경우 입사지원의 고유번호를 추가로 넘겨주도록 변경함
		$Sql22	= "SELECT LAST_INSERT_ID();";
		$result22	= query($Sql22);
		list($bNumber)= mysql_fetch_row($result22);


		#템플릿에서 사용가능한 변수
		#지원자이름 : {{per_name}}
		#지원자아이디 : {{per_id}}
		#지원자전화번호: {{per_phone}}
		#지원자이메일 : {{per_email}}
		#지원자이력서제목 : {{PER.title}}
		#지원자성별 : {{PER.user_prefix}}
		#지원자연령 : {{PER.user_age}}
		#지원자주소 : {{PER.user_zipcode}} {{PER.user_addr1}} {{PER.user_addr2}}
		#지원자총경력 : {{PER.work_year}} 년 {{PER.work_month}} 월
		#현재지원현황 : {{read_ok}} : 항상 미열람

		#채용정보이름 : {{guin_name}}
		#채용회사아이디 : {{com_id}}
		#채용회사이름 : {{com_name}}
		#채용회사이메일 : {{com_email}}
		#채용공고제목 : {{COM.guin_title}}
		#채용공고마감일 : {{guin_end_date}} {{COM.guin_choongwon}} : 1=충원시



		#이력서정보
		$sql = "select * from $per_document_tb where number = '$pNumber'";
		$result = query($sql);
		$PER = happy_mysql_fetch_assoc($result);
		//print_r($PER );

		#메일보내기
		$subject	= "온라인 입사지원이 접수가 되었습니다";
		$subject	= "[$site_name] {$PER['user_name']}님의 온라인 입사지원이 접수되었습니다.";

		if ( $PER['user_prefix'] == "man" )
		{
			$PER['user_prefix'] = $HAPPY_CONFIG['MsgUserPrefixMan1'];
		}
		else if ( $PER['user_prefix'] == "girl" )
		{
			$PER['user_prefix'] = $HAPPY_CONFIG['MsgUserPrefixGirl1'];
		}

		//$PER['work_year'] = "02";
		//$PER['work_month'] = "05";
		/*
		if ( $PER['work_year'] == "" && $PER['work_month'] == "" )
		{
			$경력사항	= "경력없음";
		}
		else if ( $PER['work_year'] != "" && $PER['work_month'] == "" )
		{
			$경력사항	= intval($PER['work_year'])."년";
		}
		else if ( $PER['work_year'] == "" && $PER['work_month'] != "" )
		{
			$경력사항	= intval($PER['work_month'])."개월";
		}
		else
		{
			$경력사항	= intval($PER['work_year'])."년 ".intval($PER['work_month'])."개월";
		}
		*/

		$career_html	= "";
		if( $PER['is_no_career'] == 'n' )
		{
			$sql	= "SELECT * FROM {$per_career_tb} WHERE doc_number = '{$PER['number']}' ORDER BY number ASC";
			$rec	= query($sql);
			while($row = mysql_fetch_assoc($rec))
			{
				$TYPE_SUB{$row[career_type_sub]}	= ( $TYPE_SUB{$row[career_type_sub]} == '' )?"":$TYPE_SUB{$row[career_type_sub]};
				$TYPE_SUB_SUB{$row[career_type_sub_sub]}	= ( $TYPE_SUB_SUB{$row[career_type_sub_sub]} == '' )?"":$TYPE_SUB_SUB{$row[career_type_sub_sub]};

				$row[type]	.= "".$TYPE{$row[career_type]} ;
				$row[type]	.= $row[type] != '' && $TYPE_SUB{$row[career_type_sub]} != '' ? "-" . $TYPE_SUB{$row[career_type_sub]} : '';
				$row[type]	.= $row[type] != '' && $TYPE_SUB_SUB{$row[career_type_sub_sub]} != '' ? "-" . $TYPE_SUB_SUB{$row[career_type_sub_sub]} : '';

				$row['career_msg']	= nl2br($row['career_msg']);

				$row['career_area']			= ( $row['career_area'] == 'in' ) ? '국내' : '해외';
				$row['career_work_type']	= ( $row['career_work_type'] == 'in' ) ? '재직중' : '퇴사';

				if( $row['career_work_type'] == '재직중' )
				{
					$row['career_out']	= "~";
				}

				if( $row['career_work_name_nodisplay'] == 'y' )
				{
					$row['career_work_name']	= preg_replace('/(?<=.{1})./u','*',$row['career_work_name']);
				}

				$career_html	.= "
				<tr>
					<td>{$row['career_area']}</td>
					<td>{$row['career_work_name']}</td>
					<td>{$row['type']}</td>
					<td>{$row['career_in']}</td>
					<td>{$row['career_out']}</td>
					<td>{$row['career_duty']}</td>
					<td>{$row['career_work_type']}</td>
					<td>{$row['career_msg']}</td>
				</tr>";
			}
			if( $career_html == '' )
			{
				$경력사항	= "경력없음";
			}
			else
			{
				$경력사항	= "<table class=\"tb_st_02\">
				<thead>
				<tr>
					<th>지역</th>
					<th>근무처명</th>
					<th>직종</th>
					<th>입사년월</th>
					<th>퇴사년월</th>
					<th>직위/직책</th>
					<th>재직상태</th>
					<th>상세내용</th>
				</tr>
				</thead>
				<tbody>
				{$career_html}
				</tbody>
				</table>";
			}
		}
		else
		{
			$경력사항	= "경력없음";
		}


		#구인정보
		$sql = "select * from $guin_tb where number = '$cNumber'";
		$result = query($sql);
		$COM = happy_mysql_fetch_assoc($result);

		$per_name = $PER["user_name"];
		$per_id = $PER["user_id"];
		$per_phone = $PER["user_hphone"];
		$per_email = $PER["user_email1"];

		$guin_name = $COM["guin_title"];
		$com_id = $COM["guin_id"];
		$com_name = $COM["guin_com_name"];
		$com_email = $COM["guin_email"];
		$guin_end_date	= $COM['guin_end_date'];

		if ($COM["guin_choongwon"] == "0")
		{
			$guin_end_date = $guin_end_date;
		}
		else
		{
			$guin_end_date = "충원시";
		}

		$read_ok = "미열람";

		// 이력서 상세페이지 주소
		#온라인입사지원한 이력서의 경우 입사지원의 고유번호를 추가로 넘겨주도록 변경함
		$이력서상세페이지주소 = "{$main_url}/document_view.php?number=".$pNumber."&read=N&bNumber=".$bNumber;

		// 로고이미지 src
		$main_logo_src		= $main_url.str_replace("//","/",("/".$wys_url."/upload/happy_config/main_logo.png"));

		$TPL->define("온라인입사지원","$skin_folder/email_jiwon.html");
		$content = &$TPL->fetch();

		#메일 보내기 함수 ( 보내는사람 , 받는사람 , 메일제목, 메일내용)
		//$admin_email= "kadrien@happycgi.com";
		//$com_email = "cgi_kad@nate.com,iamsun222@nate.com,upapa2@naver.com";
		sendmail($admin_email, $com_email, $subject, $content);

		// SMS N 쪽지 보내기 :: 개인회원
		if( $happy_member_login_value != '' )
		{
			$Member			= happy_member_information($happy_member_login_value);

			if ( $HAPPY_CONFIG['msg_online_in_indi_use'] == "1" )
			{
				$HAPPY_CONFIG['msg_online_in_indi']		= str_replace("{{아이디}}",$Member['user_id'],$HAPPY_CONFIG['msg_online_in_indi']);
				$HAPPY_CONFIG['msg_online_in_indi']		= str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['msg_online_in_indi']);

				$HAPPY_CONFIG['msg_online_in_indi']		= addslashes($HAPPY_CONFIG['msg_online_in_indi']);

				$sql = "INSERT INTO ";
				$sql.= $message_tb." ";
				$sql.= "SET ";
				$sql.= "sender_id = '".$Member['user_id']."', ";
				$sql.= "sender_name = '".$Member['user_name']."', ";
				$sql.= "sender_admin = 'n', ";
				$sql.= "receive_id = '".$admin_id."', ";
				$sql.= "receive_name = '관리자', ";
				$sql.= "receive_admin = 'y', ";
				$sql.= "message = '".$HAPPY_CONFIG['msg_online_in_indi']."', ";
				$sql.= "regdate = now() ";
				query($sql);
			}

			if ( $HAPPY_CONFIG['sms_online_in_indi_use'] == "1" || $HAPPY_CONFIG['sms_online_in_indi_use'] == "kakao" )
			{
				$SMSMSG["sms_online_in_indi"] = sms_convert($HAPPY_CONFIG["sms_online_in_indi"],'','','','',$site_phone,'','','',$mem_id);

				$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['sms_online_in_indi'],5,$sms_testing,'',$HAPPY_CONFIG['sms_online_in_indi_use'],$HAPPY_CONFIG['sms_online_in_indi_ktplcode']);
				send_sms_socket($dataStr);
			}
		}

		// SMS N 쪽지 보내기 :: 기업회원
		if( $COM['guin_id'] != '' )
		{
			$Member			= happy_member_information($COM['guin_id']);
			$Member_per		= happy_member_information($happy_member_login_value);

			if ( $HAPPY_CONFIG['msg_online_in_corp_use'] == "1" )
			{
				$HAPPY_CONFIG['msg_online_in_corp']		= str_replace("{{아이디}}",$Member_per['user_id'],$HAPPY_CONFIG['msg_online_in_corp']);
				$HAPPY_CONFIG['msg_online_in_corp']		= str_replace("{{사이트이름}}",$site_name,$HAPPY_CONFIG['msg_online_in_corp']);

				$HAPPY_CONFIG['msg_online_in_corp']		= addslashes($HAPPY_CONFIG['msg_online_in_corp']);

				$sql = "INSERT INTO ";
				$sql.= $message_tb." ";
				$sql.= "SET ";
				$sql.= "sender_id = '".$Member['user_id']."', ";
				$sql.= "sender_name = '".$Member['user_name']."', ";
				$sql.= "sender_admin = 'n', ";
				$sql.= "receive_id = '".$admin_id."', ";
				$sql.= "receive_name = '관리자', ";
				$sql.= "receive_admin = 'y', ";
				$sql.= "message = '".$HAPPY_CONFIG['msg_online_in_corp']."', ";
				$sql.= "regdate = now() ";
				query($sql);
			}

			if ( $HAPPY_CONFIG['sms_online_in_corp_use'] == "1" || $HAPPY_CONFIG['sms_online_in_corp_use'] == "kakao" )
			{
				$SMSMSG["sms_online_in_corp"] = sms_convert($HAPPY_CONFIG["sms_online_in_corp"],'','','','',$site_phone,'','','',$Member_per['user_id']);

				$dataStr = send_sms_msg($sms_userid,$Member['user_hphone'],$site_phone,$SMSMSG['sms_online_in_corp'],5,$sms_testing,'',$HAPPY_CONFIG['sms_online_in_corp_use'],$HAPPY_CONFIG['sms_online_in_corp_ktplcode']);
				send_sms_socket($dataStr);
			}
		}


		//echo $content;exit;		// kad 작업하려고 임시
		gomsg("온라인접수가 완료되었습니다.","guin_detail.php?num=$cNumber");
		exit;
	}
	else
	{
		$cNumber	= $_POST["cNumber"];
		$Sql		= "SELECT guin_interview,type1,type_sub1 FROM $guin_tb WHERE number='$cNumber' ";
		$Data		= happy_mysql_fetch_array(query($Sql));
		$interview	= $Data["guin_interview"];


		if ($Data[type1])
		{
			$add_location1 = " > <a href=guin_list.php?guzic_jobtype1=$Data[type1]>".$TYPE[$Data['type1']] . "</a>";
		}
		if ($Data[type_sub1])
		{
			$add_location2 = " > <a href=guin_list.php?guzic_jobtype1=$Data[type1]&guzic_jobtype2=$Data[type_sub1]>". $TYPE_SUB[$Data["type_sub1"]] . "</a>";
		}


		//무료화로 운영중일경우에는 개인정보 공개 / 비공개 체크박스 안보이도록 패치
		$display_secure = '';
		if ( $CONF['guin_docview'] == "" && $CONF['guin_docview2'] == ""  )
		{
			$display_secure = " style='display:none;' ";
		}
		//무료화로 운영중일경우에는 개인정보 공개 / 비공개 체크박스 안보이도록 패치


		$현재위치 = "$prev_stand > <a href=./guin_list.php>채용정보</a> $add_location1 $add_location2  > <a href='guin_detail.php?num=$cNumber'>상세보기</a> > 온라인 입사 지원";


		if ( trim($interview) != '' )
		{
			$인터뷰		= guin_interview_call( "guin_join_interview_rows.html", "guin_join_interview_default.html", $interview );
		}

		$TPL->define("본문내용", "$skin_folder/guin_join.html");
		$TPL->assign("본문내용");
		$내용 = &$TPL->fetch();

		$TPL->define("껍데기", "$skin_folder/default.html");
		$TPL->assign("껍데기");
		echo $TPL->fetch();

	}
?>