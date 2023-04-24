<?
include ("./inc/config.php");
include ("./inc/Template.php");
$t_start = array_sum(explode(' ', microtime()));
$TPL = new Template;
include ("./inc/function.php");
include ("./inc/lib.php");

	//kisa보안권고사항
	$links_number			= happy_input_str_replace($links_number,"int");
	$_GET['links_number']	= happy_input_str_replace($_GET['links_number'],"int");

	if ( !happy_member_secure( $happy_member_secure_text[1].'문의' ) )
	{
		error('권한이 없습니다.');
		exit;
	}

	$happy_member_login_id	= happy_member_login_check();


	if ( $happy_member_login_id == "" )
	{
		$happy_member_login_id	= "비회원";
	}


	$몰주소				= $main_url;
	$mode				= ( $_GET['mode'] ) ? $_GET['mode'] : $_POST['mode'];
	$links_number		= ( $_GET['links_number'] ) ? $_GET['links_number'] : $_POST['links_number'];

	$Templet			= "";

	if (!is_dir("$happy_inquiry_upload_folder")){
		error("첨부파일을 위한 ($happy_inquiry_upload_folder)폴더가 존재하지 않습니다.  ");
		exit;
	}

	$now_year			= date("Y");
	$now_month			= date("m");
	$now_day			= date("d");
	$now_time			= happy_mktime();

	$oldmask			= umask(0);
	if (!is_dir("$happy_inquiry_upload_folder/$now_year")){
		mkdir("$happy_inquiry_upload_folder/$now_year", 0777);
	}
	if (!is_dir("$happy_inquiry_upload_folder/$now_year/$now_month")){
		mkdir("$happy_inquiry_upload_folder/$now_year/$now_month", 0777);
	}
	if (!is_dir("$happy_inquiry_upload_folder/$now_year/$now_month/$now_day")){
		mkdir("$happy_inquiry_upload_folder/$now_year/$now_month/$now_day", 0777);
	}
	umask($oldmask);

	$Sql				= "SELECT * FROM $happy_inquiry_links WHERE number='$links_number' ";
	$Record				= query($Sql);
	$Cnt				= mysql_num_rows($Record);
	$LinksData			= happy_mysql_fetch_array($Record);


	//메인페이지에서 문의
	$links_info_display	= "";
	$links_data_number	=  $LinksData['number'];
	if ( $LinksData['number'] == "" )
	{
		$links_data_number		= "없음";
		$LinksData['guin_id']		= "";
		$LinksData['guin_title']		= "메인페이지 문의";
		$links_info_display		= "display:none;";
	}


	$Receiver			= happy_member_information($LinksData['id']);
	$Sender				= happy_member_information($happy_member_login_id);

	switch ( $mode )
	{
		case 'mailing' : // 문의메일전송
		{
			if ( $_POST['inquiry_private_agree'] != "y" )
			{
				msg("개인정보 보호정책에 동의를 하셔야지만 작성 하실수 있습니다.");
				exit;
			}

			$spamcheck			= $_POST["spamcheck"];
			$realspam			= $_SESSION["antispam"];

			if ( $HAPPY_CONFIG['inquiry_spam_block_conf'] == "y" && ( $spamcheck != $realspam || $realspam == '' || $spamcheck == '') )
			{
				msg("이미지의 문자와 일치하지 않습니다.");
				exit;
			}

			################################## 문의내용 저장 [ Start ] ##################################
			$category			= ( $LinksData['type1'] != "" ) ? $LinksData['type1'] : "초기화";

			$Sql			= "SELECT COUNT(*) FROM $happy_inquiry_form WHERE gubun ='$category'";
			$Result			= query($Sql);
			list($ChkCnt)	= happy_mysql_fetch_array($Result);

			// 패치
			if ( $ChkCnt == 0 || $HAPPY_CONFIG['inquiry_form_each_conf'] == "n" )
			{
				$category		= "초기화";
			}

			$Sql				= "SELECT * FROM $happy_inquiry_form WHERE gubun = '$category' ";
			//echo $Sql;
			$Record				= query($Sql);

			$SetSql				= '';
			while ( $Form = happy_mysql_fetch_array($Record) )
			{
				$Fields				= call_inquiry_form_field($Form['field_name']);
				//echo "<pre>";			print_r($Fields);			echo "</pre>";
				#echo "$".$Fields['Field'] ."  = ". $_POST[$Fields['Field']]."<hr>";

				$nowField	= $Fields['Field'];

				if ( $nowField == '' )
				{
					continue;
				}

				${$Fields['Field']}	= $_POST[$Fields['Field']];
				if ( $happy_autoslashes )
				{
					${$nowField}		= addslashes(${$nowField});
				}

				# DB형식이 INT형일때
				if ( preg_match("/int/", $Fields['Type']) )
				{
					${$nowField}		= preg_replace("/\D/", "", ${$nowField});
				}

				# 파일 업로드
				if ( $Form['field_type'] == 'file' )
				{
					${$nowField}		= '';

					if ( $_FILES[$nowField]["name"] != "" )
					{
						#echo $nowField."<br>";
						$upImageName		= $_FILES[$nowField]["name"];
						$upImageTemp		= $_FILES[$nowField]["tmp_name"];

						$temp_name			= explode(".",$upImageName);
						$ext				= strtolower($temp_name[sizeof($temp_name)-1]);

						$options			= explode(",",$Form['field_option']);

						//echo $ext ."- ".$Form['field_option']." - ". sizeof($options)."<hr>";

						for ( $z=0,$m=sizeof($options),$ext_check='' ; $z<$m ; $z++ )
						{
							#echo " $ext = ".$options[$z] ."<br>";
							if ( $ext == trim($options[$z]))
							{
								$ext_check			= 'ok';
								break;
							}
						}

						if ( $ext_check != 'ok' && $_POST[$nowField."_del"] != 'ok' )
						{
							$addMessage		= "\\n\\n$nowField 필드 : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $Form[field_option] 입니다.";
							#echo $addMessage;
							continue;
						}
						else
						{
							$rand_number		= rand(0,1000000);
							$img_url_re			= "${happy_inquiry_upload_folder}/$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";
							$img_url_re_thumb	= "${happy_inquiry_upload_folder}/$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb.$ext";
							$img_url_file_name	= "${happy_inquiry_upload_folder}/$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";

							if ( copy($upImageTemp,"$img_url_re") )
							{
								${$nowField}	= $img_url_file_name;

								if ( $HAPPY_CONFIG['inquiry_image_thumb_conf'] == 'y' )
								{
									if ( $HAPPY_CONFIG['inquiry_image_thumb_width'] && $HAPPY_CONFIG['inquiry_image_thumb_height'] )
									{
										imageUploadNew(
												$img_url_re,									#원본파일 경로
												$img_url_re_thumb,								#썸네일 저장 경로
												$HAPPY_CONFIG['inquiry_image_thumb_width'],		#썸네일 가로크기
												$HAPPY_CONFIG['inquiry_image_thumb_height'],	#썸네일 세로크기
												$HAPPY_CONFIG['inquiry_image_thumb_quality'],	#썸네일 퀄리티
												$HAPPY_CONFIG['inquiry_image_thumb_type'],		#썸네일 추출타입
												"",												#썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
												"",												#썸네일 로고
												""												#썸네일 로고 위치
										);
									}
								}
							} #copy 완료마지막
						}
					}
				}

				if ( is_array(${$nowField}) )
				{
					${$nowField}		= @implode(",", (array) ${$nowField});
				}

				if ( $Form['field_sureInput'] == 'y' && $Form['field_use'] == 'y' && ${$nowField} == '' )
				{
					msg($Form['field_title']."을 입력하세요.");
					exit;
				}

				$SetSql				.= ( $SetSql == '' )? '' : ', ';
				$SetSql				.= " $nowField = '".${$nowField}."' \n";
			}

			$Sql				= "
									INSERT INTO
											$happy_inquiry
									SET
											$SetSql,
											links_number		= '$LinksData[number]',
											links_title			= '$LinksData[guin_title]',
											send_id 			= '$happy_member_login_id',
											receive_id			= '$LinksData[guin_id]',
											reg_date			= now()
								";
			//echo nl2br($Sql);
			query($Sql);

			################################## 문의내용 저장 [ End ] ##################################

			if ( $LinksData['number'] != "" )
			{
				$Sql				= "SELECT LAST_INSERT_ID();";
				$Result				= query($Sql);
				list($idx)			= mysql_fetch_row($Result);

				# 메일발송
				happy_inquiry_mail_send($idx);

				# SMS발송
				if ( $HAPPY_CONFIG['inquiry_sms_use_conf'] == "y" )
				{
					$receive_phone = $LinksData['guin_phone'];

					//SMS발송 컨버팅 (받는번호,업체명,담당자,접수자명)
					$sms_str = happy_inquiry_sms_convert($receive_phone,$LinksData['guin_com_name'],$LinksData['guin_name'],$_POST['user_name']);
					send_sms_socket($sms_str); //SMS 소켓 발송
				}
			}

			if ( $LinksData['number'] != "" )
			{
				$go_url				= "guin_detail.php?num=$_POST[links_number]";
			}
			else
			{
				if($_REQUEST['referer'])
				{
					$go_url				= $_REQUEST['referer'];
				}
				else
				{
					$go_url				= $main_url;
				}
			}


			gomsg("정상적으로 문의사항이 접수 되었습니다.",$go_url);
			exit;
		}
		default :
		{
			$Templet	= "$skin_folder/happy_inquiry.html";

			//$nowCategory	= $Category_number[$LinksData["category"]];
			//$nevi			= call_nevigation();
			$현재위치	= " $prev_stand > 문의하기";

			$고유번호			= $links_data_number;
			$담당자			= ( $LinksData['guin_name'] == "" )	? "정보없음" : $LinksData['guin_name'];
			$메일주소			= ( $LinksData['guin_email'] == "" )		? "정보없음" : $LinksData['guin_email'];
			$연락처				= ( $LinksData['guin_phone'] == "" )		? "정보없음" : $LinksData['guin_phone'];
			$채용정보제목				= $LinksData["guin_title"];
			$업체이미지			= $LinksData["photo2"];

			$도배방지키사용		= ( $HAPPY_CONFIG['inquiry_spam_block_conf'] != "y" ) ? " style='display:none;' " : "";

			break;
		}
	}

	$TPL->define("메인내용", $Templet);
	$content = &$TPL->fetch();


	$내용	= $content;


	if( !(is_file("$skin_folder/default.html")) ) {
		$content = "껍데기 $skin_folder/default.html 파일이 존재하지 않습니다. <br>";
		return;
	}
	$TPL->define("껍데기", "$skin_folder/default.html");
	$content = &$TPL->fetch();



	echo $content;


	$exec_time = array_sum(explode(' ', microtime())) - $t_start;
	$exec_time = round ($exec_time, 2);
	$쿼리시간 =  "<br><center><font style='font-size:11px;color=gray'>Query Time : $exec_time sec";

	if ( $demo_lock=='1' )
	{
		print $쿼리시간;
	}
	if ($minihome_master_ch	== "y")
	{
		msg('유료홈페이지가 만료된 회원님입니다');
	}
?>