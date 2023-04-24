<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");
	include ("./inc/happy_sms.php");

	upload_dir_check($per_document_pic."/".date("Y"));
	upload_dir_check($per_document_pic."/".date("Y")."/".date("m"));
	$per_document_pic2 = $per_document_pic."/".date("Y")."/".date("m");

	//if ( happy_member_login_check() == "" && $master_check != 1 )
	if ( happy_member_login_check() == "" )
	{
		$move_url = "./happy_member_login.php";
		if( $CONF['kcb_adultcheck_use'] )
		{
			$move_url = "./html_file.php?file=adultcheck.html&file2=login_default.html";
		}

		//gomsg("로그인 후 이용하세요",$move_url);
		go($move_url);
		exit;
	}

	if ( !happy_member_secure($happy_member_secure_text[1].'등록') )
	{
		error($happy_member_secure_text[1].'등록'." 권한이 없습니다.");
		exit;
	}

	$widthSize	= 2;
	$heightSize	= 30;
	$tableSize	= 600;
	$Template1	= "job_per_doc_type3_keyword1.html";
	$Template2	= "job_per_doc_type3_keyword2.html";

	$키워드내용	= keyword_extraction_list( $widthSize, $heightSize , $tableSize, $Template1 , $Template2 , $cutSize="","guin");


	if ( $mode == "add_ok" )
	{
		//print_r2($_POST);exit;
		//print_r2($_GET);

		#복리후생 부분 패치됨
		if ( is_array($_POST['bokri_chk']) )
		{
			$guin_bokri = @implode(">", (array) $_POST['bokri_chk']);
		}
		#복리후생 부분 패치됨

		//키워드 저장 안되던것 패치 - ranksa
		if ( is_array($_POST['job_keyword']) )
		{
			$keyword = @implode(", ", (array) $_POST['job_keyword']);
		}

		/*
		echo $guin_bokri."<br>";

		#복리는 1이없다
		$bokri_co = count($bokri_arr);
		for ( $h=0; $h<$bokri_co; $h++)
		{
			if ( $bokri[$h] == "on" )
			{
				$guin_bokri .= "$bokri_arr[$h]>";
			}
		}
		$guin_bokri = substr($guin_bokri,0,-1);
		echo $guin_bokri."<br>";
		exit;
		*/

		#여러번 등록 안되도록 패치함
		if ( $_POST['gou_number'] != '' )
		{
			$sql = "select count(*) from ".$jangboo." where or_no='".$_POST['gou_number']."'";
			$result = query($sql);
			list($jcnt) = happy_mysql_fetch_array($result);

			if ( $jcnt >= 1 )
			{
				msg("이미 등록된 구인정보가 있으며, 결제시도내역이 있습니다. \\n구인정보를 수정하시거나, 유료옵션을 재결제 하셔야만 합니다.");
				echo "<script>
				if ( opener )
				{
					opener.location = 'happy_member.php?mode=mypage';
					self.close();
				}
				</script>";
				exit;
			}
		}
		#여러번 등록 안되도록 패치함

		#guin_lang값정리
		$guin_lang = "$lang_title1,$lang_type1,$lang_point1,$lang_title2,$lang_type2,$lang_point2";
		#guin_woodae
		$guin_woodae = $woodae;

		//고유의 값 지정해 주기
		$now_time = happy_mktime();
		$or_time = $b[1]."/".$now_time;

		//태그 벗기기
		$guin_license = strip_tags($guin_license);
		$guin_interview = strip_tags($guin_interview);
		$guin_title = strip_tags($guin_title);
		$guin_work_content = strip_tags($guin_work_content);

		#금지단어 체크
		if ( DenyWordCheck($guin_title,$TDenyWordList) )
		{
			error(" 사용하실수 없는 금지단어가 제목에 포함되어 있습니다.");
			exit;
		}
		#금지단어 체크

		#금지단어 체크
		if ( DenyWordCheck($guin_main,$TDenyWordList) )
		{
			error(" 사용하실수 없는 금지단어가 상세설명에 포함되어 있습니다.");
			exit;
		}
		#금지단어 체크




		#패키지(즉시적용)
		$PACK2_CHK						= Array();	//패키지옵션에 일반필수결제 항목들어가있을시 exit하지않기위함 - ranksa
		if($_POST['pack2_all_number'] != "")
		{
			$pay_form .= '<input type="hidden" name="pack2_all_number" value="'.$_POST['pack2_all_number'].'">';

			$pp							= 0;
			$pack2_cnt					= 0;
			$pack2_number_explode		= explode(",",$_POST['pack2_all_number']);
			foreach($pack2_number_explode AS $pne_key => $pne_val)
			{
				$pp++;

				if($_POST['pack2_uryo_'.$pne_val] != "")
				{
					$pack2_cnt++;
					$pay_form .= '<input type="hidden" name="pack2_uryo_'.$pne_val.'" value="'.$_POST['pack2_uryo_'.$pne_val].'">';
				}


				//패키지옵션에 일반필수결제 항목들어가있을시 exit하지않기위함 - ranksa
				$Sql_pack2				= "SELECT price,title,uryo_detail FROM $job_money_package2 WHERE number=$pne_val";
				$Rec_pack2				= query($Sql_pack2);
				$PACK2					= happy_mysql_fetch_assoc($Rec_pack2);

				$PACK2['ud_ex']			= explode(",",$PACK2['uryo_detail']);
				foreach($PACK2['ud_ex'] AS $UD_VAL)
				{
					$ud_val_ex			= explode(":",$UD_VAL);
					if($ud_val_ex[1] == 1)
					{
						$PACK2_CHK[$ud_val_ex[0]]	= $ud_val_ex[1];
					}
				}
			}
			unset($pp,$pack2_cnt,$pne_key,$pne_val);

		}




		#필수결제항목체크
		$cnt = count($ARRAY);
		for ( $i=0; $i<$cnt; $i++ )
		{
			$n_name = $ARRAY[$i]."_necessary";
			$u_name = $ARRAY[$i]."_use";
			$op_name = $ARRAY_NAME[$i];

			$pay_form .= '<input type="hidden" name="'.$ARRAY[$i].'" value="'.$_POST[$ARRAY[$i]].'">';

			if ( $CONF[$ARRAY[$i]]
				&& $CONF[$n_name] == '필수결제'
				&& $CONF[$u_name] == '사용함' )
			{
				if ( ($_POST[$ARRAY[$i]] == '' || $_POST[$ARRAY[$i]] == "0:0") && $PACK2_CHK[$ARRAY[$i]] == '' )
				{
					error(" $op_name 옵션은 결제를 하셔야만 등록이 됩니다.");
					exit;
				}
			}
		}
		#필수결제항목체크



		#guin_pay는 현재날째에 $ADMIN[guin_term]을 더한다.
		#$guin_view_end_date = "DATE_ADD(  curdate(),  INTERVAL '$ADMIN[guin_term]' DAY  )";

		$img1			= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img1","");
		$img2			= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img2","");
		$img3			= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img3","");
		$img4			= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img4","");
		$img5			= imageUpload($per_document_pic2,$guin_pic_width[0],$guin_pic_height[0],$guin_pic_width[1],$guin_pic_height[1],"90","img5","");


		$howjoin	= @implode(",", (array) $_POST["howjoin_chk"]);
		$howpeople		= $_POST["howpeople"];

		$work_day				= @implode(" ",$_POST["work_day"]);			#근무가능요일

		#근무시간
		$start_worktime = $_POST['work_time1']."-".$_POST['work_time2']."-".$_POST['work_time3'];
		$finish_worktime = $_POST['work_time4']."-".$_POST['work_time5']."-".$_POST['work_time6'];
		#구인자
		$guinperson = $_POST['guinperson'];
		#희망학력
		$guineducation = $_POST['guineducation'];
		#국적
		$guinnational = $_POST['guinnational'];
		#파견업체연락
		$guinsicompany = $_POST['guinsicompany'];

		$sql = "select count(*) as ct from $type_tb where (number = '$type1' OR number = '$type2' OR number = '$type3') AND use_adult = 1; ";
		$result = query($sql);
		$adult_check_count = happy_mysql_fetch_array($result);

		if($adult_check_count[ct]){
			$use_adult = "1";
		}

		$HopeSize = $_POST['HopeSize'];

		//이미지 추가 회원정보에 업로드 하는 것하고 같게 처리해야 함
		$Tmem = happy_member_information( happy_member_login_check());
		$photo2 = $Tmem['photo2'];
		$photo3 = $Tmem['photo3'];

		for ($i=2;$i<=3;$i++)
		{
			$nowField = 'photo'.$i;

			$WHERE = " and field_name = '$nowField' ";
			$Sql	= "SELECT * FROM $happy_member_field WHERE member_group = '$Tmem[group]' $WHERE ";
			$Record	= query($Sql);
			$Form = happy_mysql_fetch_assoc($Record);

			if ( $_FILES[$nowField]["name"] != "" )
			{
				#echo $nowField."<br>";
				$upImageName	= $_FILES[$nowField]["name"];
				$upImageTemp	= $_FILES[$nowField]["tmp_name"];


				$temp_name		= explode(".",$upImageName);
				$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

				$options		= explode(",",$Form['field_option']);

				#echo $ext ."- ".$Form['field_option']." - ". sizeof($options)."<hr>";

				for ( $z=0,$m=sizeof($options),$ext_check='' ; $z<$m ; $z++ )
				{
					#echo " $ext = ".$options[$z] ."<br>";
					if ( $ext == trim($options[$z]))
					{
						$ext_check	= 'ok';
						break;
					}
				}

				if ( $ext_check != 'ok' && $_POST[$nowField."_del"] != 'ok' )
				{
					$addMessage	= "\\n\\n$nowField 필드 : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $Form[field_option] 입니다.";
					#echo $addMessage;

					msg("로고 파일이 업로드가 가능한 확장자가 아닙니다.($ext)\\n업로드 가능한 확장자는 $Form[field_option] 입니다.");
					continue;
				}
				else
				{
					$now_time = happy_mktime();
					$rand_number =  rand(0,1000000);

					//디렉토리 생성 추가 2013-08-29 kad
					$now_year	= date("Y");
					$now_month	= date("m");
					$now_day	= date("d");

					$oldmask = umask(0);
					if (!is_dir("$happy_member_upload_path/$now_year")){
						mkdir("$happy_member_upload_path/$now_year", 0777);
					}
					if (!is_dir("$happy_member_upload_path/$now_year/$now_month")){
						mkdir("$happy_member_upload_path/$now_year/$now_month", 0777);
					}
					if (!is_dir("$happy_member_upload_path/$now_year/$now_month/$now_day")){
						mkdir("$happy_member_upload_path/$now_year/$now_month/$now_day", 0777);
					}
					umask($oldmask);
					//디렉토리 생성 추가 2013-08-29 kad

					$img_url_re			= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";
					$img_url_re_thumb	= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb.$ext";
					$img_url_re_thumb2	= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb2.$ext";
					$img_url_file_name	= "${happy_member_upload_folder}$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";

					if (copy($upImageTemp,"$img_url_re"))
					{
						//이거네.
						${$nowField}	= $img_url_file_name;


						//$nowField : photo1 -> 개인회원 사진
						//$nowField : photo2 -> 개인회원이력서 사진
						//$nowField : photo3 -> 개인회원이력서 사진

						if ( $nowField == "photo1" )
						{
							$happy_member_image_width = $PerPhotoDstW;
							$happy_member_image_height = $PerPhotoDstH;
							$happy_member_image_type = $PerPhotoCreateType;
						}
						else if ( $nowField == "photo2" )
						{
							$happy_member_image_width = $ComLogoDstW;
							$happy_member_image_height = $ComLogoDstH;
							$happy_member_image_type = $ComPhotoCreateType1;
						}
						else if ( $nowField == "photo3" )
						{
							$happy_member_image_width = $ComBannerDstW;
							$happy_member_image_height = $ComBannerDstH;
							$happy_member_image_type = $ComPhotoCreateType2;
						}


						if ($happy_member_image_width && $happy_member_image_height )
						{
							happyMemberimageUpload(
									$img_url_re,								#원본파일 경로
									$img_url_re_thumb,							#썸네일 저장 경로
									$happy_member_image_width,					#썸네일 가로크기
									$happy_member_image_height,					#썸네일 세로크기
									$happy_member_image_quality,				#썸네일 퀄리티
									$happy_member_image_type,					#썸네일 추출타입
									$happy_member_image_position,				#썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
									$happy_member_image_logo,					#썸네일 로고
									$happy_member_image_logo_position			#썸네일 로고 위치
							);
						}

						if ($happy_member_image_width2 && $happy_member_image_height2 )
						{
							happyMemberimageUpload(
									$img_url_re,								#원본파일 경로
									$img_url_re_thumb2,							#썸네일 저장 경로
									$happy_member_image_width2,					#썸네일 가로크기
									$happy_member_image_height2,				#썸네일 세로크기
									$happy_member_image_quality2,				#썸네일 퀄리티
									$happy_member_image_type2,					#썸네일 추출타입
									$happy_member_image_position2,				#썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
									$happy_member_image_logo2,					#썸네일 로고
									$happy_member_image_logo_position2			#썸네일 로고 위치
							);

						}
					} #copy 완료마지막
				}
			}
		}

		//생성한걸 쓰겠다라고 하면
		if ( $_POST['logo_photo3'] != "" )
		{
			$photo3 = $_POST['logo_photo3'];
		}
		//이미지 추가 회원정보에 업로드 하는 것하고 같게 처리해야 함

		//문의하기 사용여부
		$inquiry_use	= $_POST['inquiry_use'];


		/*
			$sql.= "type1 = '".$type1."', ";
			$sql.= "type2 = '".$type2."', ";
			$sql.= "type3 = '".$type3."', ";
		*/

		if ( $guin_pay_type == '' )
		{
			$guin_pay	= $_POST['guin_pay2'];
		}

		//지역개선작업
		$addsql		= "";
		$addsql		.= $gu_temp_array2["오리지날_".$gu1] == '' ? "gu1_ori = '".$gu1."'," : "gu1_ori = '".$gu_temp_array2["오리지날_".$gu1]."',";
		$addsql		.= $gu_temp_array2["오리지날_".$gu2] == '' ? "gu2_ori = '".$gu2."'," : "gu2_ori = '".$gu_temp_array2["오리지날_".$gu2]."',";
		$addsql		.= $gu_temp_array2["오리지날_".$gu3] == '' ? "gu3_ori = '".$gu3."'," : "gu3_ori = '".$gu_temp_array2["오리지날_".$gu3]."',";
		//지역개선작업

		#넘겨온 값 저장하기
		$sql = "insert into ".$guin_tb." set ";
		$sql.= "guin_id = '".$member_id."', ";
		$sql.= "guin_com_name = '".$com_name."', ";
		$sql.= "guin_wait = '0', ";
		$sql.= "si1 = '".$si1."', ";
		$sql.= "si2 = '".$si2."', ";
		$sql.= "si3 = '".$si3."', ";
		$sql.= "gu1 = '".$gu1."', ";
		$sql.= "gu2 = '".$gu2."', ";
		$sql.= "gu3 = '".$gu3."', ";

		$sql.= $addsql; //지역개선작업

		$sql.= "type1 = '".$type1."', ";
		$sql.= "type2 = '".$type2."', ";
		$sql.= "type3 = '".$type3."', ";
		$sql.= "type_sub1 = '".$type_sub1."', ";
		$sql.= "type_sub2 = '".$type_sub2."', ";
		$sql.= "type_sub3 = '".$type_sub3."', ";
		$sql.= "guin_name = '".$guin_name."', ";
		$sql.= "guin_phone = '".$guin_phone."', ";
		$sql.= "guin_fax = '".$guin_fax."', ";
		$sql.= "guin_email = '".$guin_email."', ";
		$sql.= "guin_homepage = '".$guin_homepage."', ";
		$sql.= "guin_method = '', ";
		$sql.= "guin_type = '".$guin_type."', ";
		$sql.= "guin_gender = '".$guin_gender."', ";
		$sql.= "guin_age = '".$guin_age."', ";
		$sql.= "guin_pay = '".$guin_pay."', ";
		$sql.= "guin_pay_type = '".$guin_pay_type."', ";
		$sql.= "guin_edu = '".$guin_edu."', ";
		$sql.= "guin_career = '".$guin_career."', ";
		$sql.= "guin_career_year = '".$guin_career_year."', ";
		$sql.= "guin_end_date = '".$guin_end_date."', ";
		$sql.= "guin_title = '".$guin_title."', ";
		$sql.= "guin_work_content = '".$guin_work_content."', ";
		$sql.= "guin_main = '".$guin_main."', ";
		$sql.= "guin_count = '0', ";
		$sql.= "guin_date = NOW(), ";
		$sql.= "guin_view_end_date = '', ";
		$sql.= "guin_choongwon = '".$guin_choongwon."', ";
		$sql.= "guin_etc2 = '".$or_time."', ";
		$sql.= "pick = '".$pick."', ";
		$sql.= "guin_modify = '".$pick_date."', ";
		$sql.= "guin_etc5 = '".$guin_etc5."', ";
		$sql.= "guin_woodae = '".$guin_woodae."', ";
		$sql.= "guin_grade = '".$guin_grade."', ";
		$sql.= "guin_lang = '".$guin_lang."', ";
		$sql.= "guin_license = '".$guin_license."', ";
		$sql.= "guin_interview = '".$guin_interview."', ";
		$sql.= "guin_bokri = '".$guin_bokri."', ";
		$sql.= "guin_banner1 = '', ";
		$sql.= "guin_banner2 = '', ";
		$sql.= "guin_banner3 = '', ";
		$sql.= "guin_bold = '', ";
		$sql.= "guin_list_hyung = '', ";
		$sql.= "guin_pick = '', ";
		$sql.= "guin_ticker = '', ";
		$sql.= "img1 = '".$img1."', ";
		$sql.= "img2 = '".$img2."', ";
		$sql.= "img3 = '".$img3."', ";
		$sql.= "img4 = '".$img4."', ";
		$sql.= "img5 = '".$img5."', ";
		$sql.= "img_text1 = '".$img_text1."', ";
		$sql.= "img_text2 = '".$img_text2."', ";
		$sql.= "img_text3 = '".$img_text3."', ";
		$sql.= "img_text4 = '".$img_text4."', ";
		$sql.= "img_text5 = '".$img_text5."', ";
		$sql.= "howpeople = '".$howpeople."', ";
		$sql.= "howjoin = '".$howjoin."', ";
		$sql.= "keyword = '".$keyword."', ";
		$sql.= "underground1 = '".$underground1."', ";
		$sql.= "underground2 = '".$underground2."', ";
		$sql.= "guin_bgcolor_com = '', ";
		$sql.= "freeicon_com = '', ";
		$sql.= "freeicon_comDate = '', ";
		$sql.= "work_day = '".$work_day."', ";
		$sql.= "start_worktime = '".$start_worktime."', ";
		$sql.= "finish_worktime = '".$finish_worktime."', ";
		$sql.= "guinperson = '".$guinperson."', ";
		$sql.= "guineducation = '".$guineducation."', ";
		$sql.= "guinnational = '".$guinnational."', ";
		$sql.= "guinsicompany = '".$guinsicompany."', ";
		$sql.= "use_adult = '".$use_adult."', ";
		$sql.= "HopeSize = '".$HopeSize."', ";
		$sql.= "subway_txt = '".$subway_txt."', ";
		$sql.= "marriage_chk = '".$marriage_chk."', ";
		$sql.= "work_week = '".$work_week."', ";

		//위치기반주소
		$sql.= "user_zip = '".$user_zip."',";
		$sql.= "user_addr1 = '".$user_addr1."',";
		$sql.= "user_addr2 = '".$user_addr2."', ";

		//큰이미지 photo2
		//작은이미지 photo3
		//alter table job_guin add photo2 varchar(250) not null default '';
		//alter table job_guin add photo3 varchar(250) not null default '';
		$sql.= "photo2 = '".$photo2."',";
		$sql.= "photo3 = '".$photo3."', ";

		$sql.= "pay_type = '".$_POST['pay_type']."', ";
		//헤드헌팅(대표자명, 설립연도, 직원수, 업소소개) 추가
		//alter table job_guin add boss_name varchar(30) not null default '';
		//alter table job_guin add com_open_year varchar(20) not null default '';
		//alter table job_guin add com_worker_cnt varchar(20) not null default '';
		//alter table job_guin add com_profile1 text not null default '';
		if ( $_POST['company_number'] != '' )
		{
			$sql.= "company_number = '".$_POST['company_number']."',";
		}

		$sql.= "boss_name = '".$boss_name."',";
		$sql.= "com_open_year = '".$com_open_year."',";
		$sql.= "com_worker_cnt = '".$com_worker_cnt."',";
		$sql.= "com_profile1 = '".$com_profile1."', ";

		//문의 수신여부
		//alter table job_guin add inquiry_use enum('y','n') not null default 'n';
		$sql.= "inquiry_use		= '".$inquiry_use."',";

		//모바일에서 구인등록
		if( $_COOKIE['happy_mobile'] == 'on' )
		{
			$sql.= "regist_mobile		= 'y',";
		}


		$sql.= "guin_bgcolor_select = '".$_POST['guin_bgcolor_select']."' ";





		#guin_bgcolor_com
		#freeicon_com
		#freeicon_comDate
		//echo $sql;
		//exit;
		$result = query($sql);
		$sql = "SELECT LAST_INSERT_ID();";
		$result = query($sql);
		list($idx)= mysql_fetch_row($result);

		// 맞춤채용알림
		$value	= array(
			'type1'				=> $type1,				// 분야
			'type2'				=> $type2,				// 분야
			'type3'				=> $type3,				// 분야
			'type_sub1'			=> $type_sub1,			// 분야
			'type_sub2'			=> $type_sub2,			// 분야
			'type_sub3'			=> $type_sub3,			// 분야
			'si1'				=> $si1,				// 시
			'si2'				=> $si2,				// 시
			'si3'				=> $si3,				// 시
			'gu1'				=> $gu1,				// 구
			'gu2'				=> $gu2,				// 구
			'gu3'				=> $gu3,				// 구
			'guin_type'			=> $guin_type,			// 고용형태(정규직 등)
			'guin_edu'			=> $guin_edu,			// 학력
			'guin_career'		=> $guin_career,		// 경력
			'guin_career_year'	=> $guin_career_year,	// 경력연수
			'guin_gender'		=> $guin_gender,		// 성별
			'guin_age'			=> $guin_age,			// 연령
			'guin_pay'			=> $guin_pay,			// 급여
			'guin_pay_type'		=> $guin_pay_type		// 급여
		);
		want_job_send_msg($value);


		//인접매물 업데이트 2013-03-08 kad
		//주소를 바로 입력받아서 좌표구하는 형태
		$now_number = $idx;

		if ( $user_addr1 != '' && $user_addr2 != '' )
		{

			$nowAddr		= $user_addr1.' '.$user_addr2;

			if ( $wgs_get_type == 'google' )
			{
				$data			= getcontent_wgs_google($nowAddr);

				$ypoint			= getpoint($data,"<lat>","</lat>");
				$xpoint			= getpoint($data,"<lng>","</lng>");

				$wgsArr			= get_wgs_point($xpoint[0], $ypoint[0]);
			}
			else
			{
				if( $wgs_get_type == 'naver' )
				{
					$data				= getcontent_wgs($nowAddr);
				}
				else
				{
					$data				= getcontent_wgs_daum($nowAddr);
				}

				$xpoint			= getpoint($data,"<y>","</y>");
				$ypoint			= getpoint($data,"<x>","</x>");
				$xpoint			= $xpoint[0];
				$ypoint			= $ypoint[0];

				$wgsArr			= get_wgs_point($ypoint, $xpoint);
			}


			$Sql	= "
						UPDATE
								$guin_tb
						SET
								x_do		= '$wgsArr[x_do]',
								x_min		= '$wgsArr[x_min]',
								x_sec		= '$wgsArr[x_sec]',
								y_do		= '$wgsArr[y_do]',
								y_min		= '$wgsArr[y_min]',
								y_sec		= '$wgsArr[y_sec]',
								x_point		= '$wgsArr[x_point]',
								y_point		= '$wgsArr[y_point]',
								x_point2	= '$wgsArr[x_point2]',
								y_point2	= '$wgsArr[y_point2]'
						WHERE
								number		= '$now_number'
			";
			//echo $Sql."<br>";

			query($Sql);
		}
		else
		{
			$x_do		= '';
			$x_min		= '';
			$x_sec		= '';

			$y_do		= '';
			$y_min		= '';
			$y_sec		= '';

			$x_point	= '';
			$y_point	= '';

			$x_point2	= '';
			$y_point2	= '';

			$Sql	= "
						UPDATE
								$guin_tb
						SET
								x_do		= '$x_do',
								x_min		= '$x_min',
								x_sec		= '$x_sec',
								y_do		= '$y_do',
								y_min		= '$y_min',
								y_sec		= '$y_sec',
								x_point		= '$x_point',
								y_point		= '$y_point',
								x_point2	= '$x_point2',
								y_point2	= '$y_point2'
						WHERE
								number	= '$now_number'
			";
			query($Sql);
		}
		//exit;
		//인접매물 업데이트


		//xml파일 생성
		for ( $i=0 , $max=sizeof($xml_area1) ; $i<$max ; $i++ )
		{
			xmlAddressCreate($AREA_SI_NUMBER[$xml_area1[$i]]);
		}
		//xml파일 생성


		#메일보내기
		$subject = "구인정보가 등록이 되었습니다";
		$TPL->define("구인정보등록","$skin_folder/email_guin_add.html");

		#템플릿에서 사용가능한 변수
		#아이디 : {{member_id}}
		#회사명 : {{com_name}}
		#구인제목 : {{guin_title}}
		#등록시간 : {{reg_date}}
		#담당업무 : {{guin_work_content}}
		#1차업직종 : {{type1_title}}{{type1_sub_title}}
		#2차업직종 : {{type2_title}}{{type2_sub_title}}
		#3차업직종 : {{type3_title}}{{type3_sub_title}}
		#학력 : {{guin_edu}}
		#경력 : {{guin_career}}
		#고용형태 : {{guin_type}}
		#1차희망지역 : {{si1_title}}{{gu1_title}}
		#2차희망지역 : {{si2_title}}{{gu2_title}}
		#3차희망지역 : {{si3_title}}{{gu3_title}}
		#접수방법 : {{how_join}}
		#마감일 : {{guin_end_date}} {{guin_choongwon}} :1 충원시
		#담당자명  : {{guin_name}}
		#담당자이메일 : {{guin_email}}
		#담당자연락처 : {{guin_phone}}

		$com_name				= $com_name;
		$com_name_email_value	= ($com_name == "")?$member_id:$com_name;
		$guin_title = $guin_title;
		$regdate = date("Y-m-d H:i:s");
		$guin_work_content = $guin_work_content;

		$TMP_TYPE = array_flip($TYPE_NUMBER);
		if ($TYPE_SUB_NUMBER != "")
		{
			$TMP_TYPE_SUB = array_flip($TYPE_SUB_NUMBER);
		}
		$TMP_SI = array_flip($SI_NUMBER);
		$TMP_GU = array_flip($GU_NUMBER);

		$type1_title = $TMP_TYPE[$type1];
		$type2_title = $TMP_TYPE[$type2];
		$type3_title = $TMP_TYPE[$type3];
		$type1_sub_title = $TMP_TYPE_SUB[$type_sub1];
		$type2_sub_title = $TMP_TYPE_SUB[$type_sub2];
		$type3_sub_title = $TMP_TYPE_SUB[$type_sub3];

		$guin_edu = $guin_edu;
		$guin_career = $guin_career;
		$guin_type = $guin_type;

		$si1_title = $TMP_SI[$si1];
		$si2_title = $TMP_SI[$si2];
		$si3_title = $TMP_SI[$si3];
		$gu1_title = $TMP_GU[$gu1];
		$gu2_title = $TMP_GU[$gu2];
		$gu3_title = $TMP_GU[$gu3];

		$howjoin = $howjoin;

		if ($guin_choongwon == "0")
		{
			$guin_end_date = $guin_end_date;
		}
		else
		{
			$guin_end_date = "충원시";
		}

		$guin_name = $guin_name;
		$guin_email = $guin_email;
		$guin_phone = $guin_phone;

		$content = &$TPL->fetch();

		#메일 보내기 함수 ( 보내는사람 , 받는사람 , 메일제목, 메일내용)
		sendmail($admin_email, $guin_email, $subject, $content);

		#최근 구인번호를 읽어서 이동한다.
		$sql = "SELECT LAST_INSERT_ID();";
		$result = query($sql);
		list($now_number)= mysql_fetch_row($result);

		//echo $CONF[paid_conf];exit;

		//유료화 여부
		if ( $CONF[paid_conf] )
		{
			#결제창
			#$gou_number = $mem_id . "-" . happy_mktime();
			$gou_number = $_POST['gou_number'];

			if ( $_POST['pay_type'] == 'bank_soodong' || $_POST['pay_type'] == 'point' )
			{
				$paypage_target = ' ';
			}
			else if( $_COOKIE['happy_mobile'] != 'on' )		//PC 일때만 타겟을 변경한다.
			{
				//2013-05-31		팝업생성 자체를 PG사 별로 이름 다르게 되어 있으나.. 여기선 처리 안되어 있어서 버그 수정함.			hun.
				if($HAPPY_CONFIG['pg_company'] == 'dacom')
				{
					$paypage_target = ' target = "BTPG_WALLET" ';
				}
				else if ( $HAPPY_CONFIG['pg_company'] == 'inicis' )
				{
					//$paypage_target = ' target = "INI" ';
				}
				//$paypage_target = ' target = "BTPG_WALLET" ';
			}

			#print_r2($ARRAY);
			#print_r2($_POST);
			#exit;

			#결제페이지로 넘길지 말지 결정
			$cnt = count($ARRAY);
			$go_pay_page = false;
			for ( $i=0; $i<$cnt; $i++ )
			{
				$tmpv = explode(":",$_POST[$ARRAY[$i]]);
				if ( $tmpv[0] != 0 && $tmpv[0] != '' )
				{
					$go_pay_page = true;
					//echo "들어왔나?";exit;
				}

				#패키지(즉시적용)
				if($_POST['pack2_all_number'])
				{
					$pan_explode	= explode(",",$_POST['pack2_all_number']);
					foreach($pan_explode AS $pe_val)
					{
						if($_POST['pack2_use_'.$pe_val] == "on") //패키지(즉시적용) 사용체크
						{
							$go_pay_page = true;
						}
					}
					unset($pe_val);
				}
				#패키지(즉시적용) END
			}
			#결제페이지로 넘길지 말지 결정

			#echo $go_pay_page.'test';exit;

			if ( $go_pay_page == true )
			{
				echo "
				<form name=payform method=post action=my_pay.php ".$paypage_target.">".$pay_form."
				<input type=hidden name=gou_number value=".$gou_number.">
				<input type=hidden name=type value=".$_POST['pay_type'].">
				<input type=hidden name=number value=".$now_number.">
				<input type=hidden name=total_price value=".$_POST['total_price'].">
				<input type=hidden name=freeicon value=".$_POST['freeicon'].">
				</form>
				<script>
					document.payform.submit();
				</script>";
				#결제창
			}
			else
			{
				//gomsg("\\n구인정보가 잘 등록되었습니다   \\n\\n유료결제옵션을 위한 페이지로 이동합니다","./member_option_pay.php?number=$now_number&mode=pay");
			}

			if ($_POST['total_price'] <= 0)
			{
				gomsg("\\n채용정보가 잘 등록되었습니다","./member_guin.php?type=all");
				exit;
			}

		}
		else
		{
			gomsg("\\n채용정보가 잘 등록되었습니다","./happy_member.php?mode=mypage");
			//go("./member_info.php");
			exit;
		}
		exit;
	}


	################################################################################
	if (!$master_check)
	{
		if ( !happy_member_secure($happy_member_secure_text[1].'등록') )
		{
			error($happy_member_secure_text[1].'등록'." 권한이 없습니다.");
			go("happy_member_login.php");
			exit;
		}
	}
	else
	{
		//print "<html><title>슈퍼관리자로그인중</title>";
	}

	$sql = "select * from $happy_member where user_id ='$member_id'";
	$result = query($sql);
	$MEM = happy_mysql_fetch_array($result);


	$MEM['etc1'] = $MEM['photo2'];
	$MEM['etc2'] = $MEM['photo3'];
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


	#관리자는 회사명수정가능
	if (!$master_check)
	{
		$MEM[read_only] = "readonly";
	}

	$si_info_1 = make_si_selectbox('si1','gu1','','','120','120','regiform');
	$si_info_2 = make_si_selectbox('si2','gu2','','','120','120','regiform');
	$si_info_3 = make_si_selectbox('si3','gu3','','','120','120','regiform');
	//$type_info_1 = make_type_selectbox('type1','type_sub1','','','200','200','regiform');
	//$type_info_2 = make_type_selectbox('type2','type_sub2','','','200','200','regiform');
	//$type_info_3 = make_type_selectbox('type3','type_sub3','','','200','200','regiform');

	// 카테고리 추가
	$js_arr1			= get_type_selectbox();
	$type_opt1			= $js_arr1['type_opt'];
	$type_sub_opt1		= $js_arr1['type_sub_opt'];
	$type_sub_sub_opt1	= $js_arr1['type_sub_sub_opt'];

	$js_arr2			= get_type_selectbox();
	$type_opt2			= $js_arr2['type_opt'];
	$type_sub_opt2		= $js_arr2['type_sub_opt'];
	$type_sub_sub_opt2	= $js_arr2['type_sub_sub_opt'];

	$js_arr3			= get_type_selectbox();
	$type_opt3			= $js_arr3['type_opt'];
	$type_sub_opt3		= $js_arr3['type_sub_opt'];
	$type_sub_sub_opt3	= $js_arr3['type_sub_sub_opt'];

	$js_arr	= get_type_selectbox_js();
	$type2_key_js = $js_arr['type2_key_js'];
	$type2_val_js = $js_arr['type2_val_js'];
	$type3_key_js = $js_arr['type3_key_js'];
	$type3_val_js = $js_arr['type3_val_js'];

	$모집인원	= dateSelectBox( "howpeople", 1, 30, $Data["howpeople"], "명", "선택", "" , 1);



	#$업종분류 = make_checkbox($job_arr,7,job,job_chk,'');
	#$복리후생 = make_checkbox($bokri_arr,5,bokri,bokri_chk,'');

	$복리후생 = make_checkbox2($bokri_arr,$bokri_arr_title,5,bokri,bokri_chk,'');
	$급여조건 = make_selectbox($money_arr,'--급여선택--',guin_pay2,'');

	//학력무관 한 채용정보 버그패치 2018-01-22 kad
	$최종학력 = make_selectbox($edu_arr2,'--학력선택--',guin_edu,'');
	$경력년수 = make_selectbox($career_arr,'--경력년수--',guin_career_year,'');
	$채용직급 = make_selectbox($grade_arr,'--직급선택--',guin_grade,'');
	$외국어명1 = make_selectbox($lang_arr,'--외국어명--',lang_title1,'');
	$외국어명2 = make_selectbox($lang_arr,'--외국어명--',lang_title2,'');
	$접수방법 = make_checkbox2($guin_howjoin,$guin_howjoin,1,howjoin,howjoin_chk,'온라인이력서접수,전화접수');
	$고용형태 = make_radiobox($job_arr,3,guin_type,guin_type,'정규직');
	//$고용형태 = make_selectbox($job_arr,'--고용형태--',guin_type,'');


	//$DETAIL[guin_pay_type]	= $DETAIL[guin_pay_type] == '' ? $want_money_arr[0] : $DETAIL[guin_pay_type];

	$names	= Array("want_money_arr");
	$return	= Array("연봉타입");
	$vals	= Array($DETAIL[guin_pay_type]);

	for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
	{
		$options	= "<option value=''>- 타입선택 -</option>";

		//echo $names[$x].'<br />';
		//print_r2(${$names[$x]});

		for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
		{
			//$checked	= ( $vals[$x] == ${$names[$x]}[$i] )?"selected":"";
			$options	.= "<option value='".${$names[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>\n";
		}
		$options = str_replace("\n","",$options);
		$options = str_replace("\r","",$options);

		${$return[$x]}	= $options;
	}


	$chkDate	= date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")+$chkDay,date("Y")));
	$nowDate	= date("Y-m-d");

	$현재위치 = "$prev_stand > <a href=\"./happy_member.php?mode=mypage\">마이페이지</a> > 채용정보등록
	";

	#추가된 필드들
	#근무가능요일
	$WeekDays = make_checkbox2(array_keys($TDayIcons),$TDayIconsTag,"7","work_day","work_day",$Data['work_day'],"");
	#근무시간
	$StartWorkTime = explode("-",$Data['start_worktime']);
	$FinishWorkTime = explode("-",$Data['finish_worktime']);
	$WorkTime1 = make_selectbox2($TTime1,$TTime1,"","work_time1",$StartWorkTime[0],$select_width="110px");
	$WorkTime2 = make_selectbox2($TTime2,$TTime2,"","work_time2",$StartWorkTime[1],$select_width="110px");
	$WorkTime3 = make_selectbox2($TTime3,$TTime3,"","work_time3",$StartWorkTime[2],$select_width="110px");
	$WorkTime4 = make_selectbox2($TTime1,$TTime1,"","work_time4",$FinishWorkTime[0],$select_width="110px");
	$WorkTime5 = make_selectbox2($TTime2,$TTime2,"","work_time5",$FinishWorkTime[1],$select_width="110px");
	$WorkTime6 = make_selectbox2($TTime3,$TTime3,"","work_time6",$FinishWorkTime[2],$select_width="110px");

	#구인자
	$GuinPerson = make_radiobox2($TGuinPerson,$TGuinPerson,2,"guinperson","guinperson",$Data['guinperson']);
	#학력
	$GuinEducation = make_selectbox2($TEducation,$TEducation,"학력","guineducation",$Data['guineducation'],$select_width="100");
	#국적
	$GuinNational = make_radiobox2($TNational,$TNational,4,"guinnational","guinnational",$Data['guinnational']);
	#파견업체연락
	$SiCompany = make_radiobox2($TSiCompany,$TSiCompany,2,"guinsicompany","guinsicompany",$Data['guinsicompany']);

	//희망회사규모
	$희망회사규모 = make_radiobox2($tHopeSize,$tHopeSize,5,"HopeSize","HopeSize",$tHopeSize[0]);


	//2018-07-27 모바일등록 추가 hun
	if( $_COOKIE['happy_mobile'] == 'on' )
	{
		$고용형태 = make_radiobox($job_arr,1,guin_type,guin_type,'정규직');
		$희망회사규모 = make_radiobox2($tHopeSize,$tHopeSize,2,"HopeSize","HopeSize",$tHopeSize[0]);
		$복리후생 = make_checkbox2($bokri_arr,$bokri_arr_title,2,bokri,bokri_chk,'');
		$접수방법 = make_checkbox2($guin_howjoin,$guin_howjoin,2,howjoin,howjoin_chk,'온라인이력서접수,전화접수');
	}
	//2018-07-27 모바일등록 추가 hun




if ( $CONF['paid_conf'] && happy_member_secure($happy_member_secure_text[1].'유료결제') )
{
	#유료결제폼 추가됨 2009-12-17 kad
	#해당하는 유료결재정보를 읽어온다.
	#추천/누네띠네/배너1/배너2/배너3/뉴스티커/등록유료화
	#배너형/좁은배너형/넓은배너형/누네띠네형/리스트형/추천형/뉴스티커형/일반형
	$guin_banner1 = split("\n",$CONF['guin_banner1']);
	$guin_banner2 = split("\n",$CONF['guin_banner2']);
	$guin_banner3 = split("\n",$CONF['guin_banner3']);
	$guin_bold = split("\n",$CONF['guin_bold']);
	$guin_list_hyung = split("\n",$CONF['guin_list_hyung']);
	$guin_pick = split("\n",$CONF['guin_pick']);
	$guin_ticker = split("\n",$CONF['guin_ticker']);
	$guin_banner1 = str_replace(" ", "", $guin_banner1);
	#배경색추가
	$guin_bgcolor_com = split("\n",$CONF['guin_bgcolor_com']);
	#자유아이콘추가
	$guin_freeicon	= explode("\n",str_replace("\r","",$CONF['freeicon_comDate']));

	$guin_uryo1 = split("\n",$CONF['guin_uryo1']);
	$guin_uryo2 = split("\n",$CONF['guin_uryo2']);
	$guin_uryo3 = split("\n",$CONF['guin_uryo3']);
	$guin_uryo4 = split("\n",$CONF['guin_uryo4']);
	$guin_uryo5 = split("\n",$CONF['guin_uryo5']);


	$PAY = array();
	$PAY['guin_banner1'] = make_guin_checkbox_pay($guin_banner1,"-- 광고 $CONF[guin_banner1_option] 결재금액선택 --",guin_banner1,$CONF['guin_banner1_option']);
	$PAY['guin_banner2'] = make_guin_checkbox_pay($guin_banner2,"-- 광고 $CONF[guin_banner2_option] 결재금액선택 --",guin_banner2,$CONF['guin_banner2_option']);
	$PAY['guin_banner3'] = make_guin_checkbox_pay($guin_banner3,"-- 광고 $CONF[guin_banner3_option] 결재금액선택 --",guin_banner3,$CONF['guin_banner3_option']);
	$PAY['guin_bold'] = make_guin_checkbox_pay($guin_bold,"-- 광고 $CONF[guin_bold_option] 결재금액선택 --",guin_bold,$CONF['guin_bold_option']);
	$PAY['guin_list_hyung'] = make_guin_checkbox_pay($guin_list_hyung,"-- 광고 $CONF[guin_list_hyung_option] 결재금액선택 --",guin_list_hyung,$CONF['guin_list_hyung_option']);
	$PAY['guin_pick'] = make_guin_checkbox_pay($guin_pick,"-- 광고 $CONF[guin_pick_option] 결재금액선택 --",guin_pick,$CONF['guin_pick_option']);
	$PAY['guin_ticker'] = make_guin_checkbox_pay($guin_ticker,"-- 광고 $CONF[guin_ticker_option] 결재금액선택 --",guin_ticker,$CONF['guin_ticker_option']);

	#배경색추가
	$PAY['guin_bgcolor_com'] = make_guin_checkbox_pay($guin_bgcolor_com,"-- 광고 $CONF[guin_bgcolor_com_option] 결재금액선택 --",guin_bgcolor_com,$CONF['guin_bgcolor_com_option']);
	#자유아이콘추가
	$PAY['guin_freeicon']		= make_guin_radiobox($guin_freeicon,$guin_freeicon,freeicon_comDate,"기간별");

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
					<span class='noto400 font_14 h_form' style='display:inline-block; background:$value; color:#333'>
						<label for='${bgcolor_cnt}' class='h-radio'><input type='radio' id='${bgcolor_cnt}'name='guin_bgcolor_select' value='$value' style='margin-bottom:2px; cursor:pointer'><span>${bgcolor_cnt}번 형광펜</span></label>
					</span>
				</td>
			";

			if( ( $bgcolor_cnt % $bgcolor_cut ) == 0 )
			{
				$PAY['guin_bgcolor_radio']	.= "</tr><tr><td colspan='4' style=''></td></tr><tr>";
			}
		}
		$PAY['guin_bgcolor_radio']	.="</tr></table>";
		//배경색상 라디오버튼
	}
	else
	{
		$bgcolor_cnt			= 0;
		$bgcolor_cut			= 4;
		$PAY['guin_bgcolor_radio']= "
		<table cellspacing='0' cellpadding='0' style='margin:0 auto'>
		<tr>
		";
		foreach($guin_title_bgcolors as $key => $value)
		{
			$bgcolor_cnt++;
			$PAY['guin_bgcolor_radio']	.= "

				<td style='text-align:center; padding:10px; line-height:18px'>
					<span class='noto400 font_14 h_form' style='display:block; background:$value; color:#333'>
						<label class='h-radio'><input type='radio' name='guin_bgcolor_select' value='$value' style='margin-bottom:2px; cursor:pointer'><span> ${bgcolor_cnt}번 형광펜</span></label>
					</span>
				</td>
			";

			if( ( $bgcolor_cnt % $bgcolor_cut ) == 0 )
			{
				$PAY['guin_bgcolor_radio']	.= "</tr><tr><td colspan='4' style=''></td></tr><tr>";
			}
		}
		$PAY['guin_bgcolor_radio']	.="</tr></table>";
		//배경색상 라디오버튼
	}

	$시간 = happy_mktime();

	for ($i=0;$i<=6;$i++)
	{
		#max 를 구하자
		$tmp_option = $ARRAY[$i] . "_option";
		$tmp_max = $ARRAY[$i] . "_max";


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

		if ($CONF{$ARRAY[$i]} && $CONF[$tmp_max] > $NOW_MAX{$ARRAY[$i]} ){

			$lista = $ARRAY[$i] ."a";
			$lista2 = $ARRAY[$i] . "a2";

			$java_insert .= "
			max = \"\";
			max = document.regiform.".$ARRAY[$i].".length;

			ChkVal = \"0:0\";

			if ( max == undefined )
			{
				if (document.regiform.".$ARRAY[$i].".checked)
				{
					ChkVal = document.regiform.".$ARRAY[$i].".value;
				}
			}
			else
			{
				for ( x=0; x<max; x++)
				{
					if ( document.regiform.".$ARRAY[$i]."[x].checked )
					{
						ChkVal = document.regiform.".$ARRAY[$i]."[x].value;
					}
				}
			}

			var ".$lista." = ChkVal;
			".$lista." = ".$lista.".split(\":\");
			var ".$lista2." = ".$lista."[".$lista.".length -1];
			";
			$total_plus .= '+' . "(".$lista2."-0)";

		}
		elseif ($CONF{$ARRAY[$i]} && $CONF[$tmp_max] <= $NOW_MAX{$ARRAY[$i]} ){
			$PAY{$ARRAY[$i]} = "<font class=small_gray>유료광고 최대건수를 넘었습니다 <br>(" . $NOW_MAX{$ARRAY[$i]} . "건 현재 광고중)</font>";
		}
		else {
			$PAY{$ARRAY[$i]} = "유료설정이 되지 않음 ";
		}

	}

	#사용안하면 안보이도록
	$Sty = "";

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

		if ($CONF{$ARRAY[$i]} && $CONF[$tmp_max] > $NOW_MAX{$ARRAY[$i]} )
		{
			$lista = $ARRAY[$i] ."a";
			$lista2 = $ARRAY[$i] . "a2";

			$java_insert .= "
			max = \"\";
			max = document.regiform.".$ARRAY[$i].".length;

			ChkVal = \"0:0\";

			if ( max == undefined )
			{
				if (document.regiform.".$ARRAY[$i].".checked)
				{
					ChkVal = document.regiform.".$ARRAY[$i].".value;
				}
			}
			else
			{
				for ( x=0; x<max; x++)
				{
					if ( document.regiform.".$ARRAY[$i]."[x].checked )
					{
						ChkVal = document.regiform.".$ARRAY[$i]."[x].value;
					}
				}
			}

			var ".$lista." = ChkVal;
			".$lista." = ".$lista.".split(\":\");
			var ".$lista2." = ".$lista."[".$lista.".length -1];
			";
			$total_plus .= '+' . "(".$lista2."-0)";

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
										if ( regiform.freeicon_comDate && regiform.freeicon_comDate[".$i."].checked ) {
											val8 = regiform.freeicon_comDate[".$i."].value;
										} else {
											if (val8 == \"0:0\")
												val8 = \"0:0\";
										}\n
										";
	}

	//print_r2($CONF);

	/*
	#필수결제항목 체크
	$cnt = count($ARRAY);
	$necessary_javascriptscript = "";
	for ( $i=0; $i<$cnt; $i++ )
	{
		$n_name = $ARRAY[$i]."_necessary";
		$u_name = $ARRAY[$i]."_use";
		$op_name = $ARRAY_NAME[$i];
		if ( $CONF[$ARRAY[$i]]
			&& $CONF[$n_name] == '필수결제'
			&& $CONF[$u_name] == '사용함' )
		{
			$necessary_javascriptscript .= "
			if ( myform.".$ARRAY[$i]." )
			{
				if ( valued(myform.".$ARRAY[$i].") == false )
				{
					alert('".$op_name." 옵션은 결제를 하셔야만 등록이 됩니다.');
					return false;
				}
			}
			";
		}
	}
	#필수결제항목 체크
	*/

	#고유번호
	$gou_number = $mem_id . "-" . happy_mktime();



	//결제요청시 팝업 / 프레임 / 액티브엑스설치 처리 통합결제모듈 ranksa
	$pay_button_script = "";
	$pay_frame = "";
	$activex_script = "";

	$pay_frame = '<iframe width="0" height="0" name="pay_page" id="pay_page" style="border:1px solid;"></iframe>';

	if ( $HAPPY_CONFIG['pg_company'] == 'dacom' )
	{
		//echo "데이콤";
		//데이콤은 히든 프레임으로 넘긴다.
		//팝업차단때문에 클릭시 미리 띄어 둔다.
		//name 은 BTPG_WALLET 이어야 한다
		$pay_button_script = '
		window.name = "BTPG_CLIENT";
		BTPG_WALLET = window.open("", "BTPG_WALLET", "width=450,height=500");
		BTPG_WALLET.focus();
		myform.target = "pay_page";
		';


		$bank_jumin_chk = '
		if ( myform.jumin1.value == "" ) {
			alert("주민등록번호 앞자리를 입력해주세요");
			myform.jumin1.focus();
			return false;
		}
		if ( myform.jumin2.value == "" ) {
			alert("주민등록번호 뒤자리를 입력해주세요");
			myform.jumin2.focus();
			return false;
		}
		';

	}
	else if ( $HAPPY_CONFIG['pg_company'] == 'allthegate' )
	{
		//echo "올더게이트";
		//올더게이트는 히든 프레임으로 넘긴다.
		if ( $HAPPY_CONFIG['pay_all_mode'] == 'test' )
		{
			$agspay_alert = "alert('올더게이트 데모결제는 카드만 이용가능합니다.');";
		}
		else
		{
			$agspay_alert = "";
		}

		$pay_button_script = '
		myform.target = "pay_page";
		';

		if(preg_match("/utf/",$server_character))
		{
			$allthegate_js		= "AGSWallet_utf8.js";
		}
		else
		{
			$allthegate_js		= "AGSWallet.js";
		}
		$activex_script = '<script language=javascript src="http://www.allthegate.com/plugin/'.$allthegate_js.'"></script><script language=javascript>StartSmartUpdate();</script>';
	}
	else if ( $HAPPY_CONFIG['pg_company'] == 'inicis' )
	{
		//echo "이니시스";
		//이니시스는 히든 프레임으로 넘긴다.
		//팝업차단때문에 클릭시 미리 띄어 둔다.
		$pay_button_script = '
		//INI = window.open("", "INI", "width=450,height=500");
		//INI.focus();
		myform.target = "pay_page";
		';
	}
	//결제요청시 팝업 및 프레임 처리



	#결재 자바스크립트
	$pay_java = <<<END
	<script language="javascript">
	function cashReturn(numValue)
	{
		//numOnly함수에 마지막 파라미터를 true로 주고 numOnly를 부른다.
		var cashReturn = "";
		for (var i = numValue.length-1; i >= 0; i--)
		{
			cashReturn = numValue.charAt(i) + cashReturn;
			if (i != 0 && i%3 == numValue.length%3) cashReturn = "," + cashReturn;
		}
		return cashReturn;
	}

	function figure()
	{
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


		document.regiform.total.value = total;
		document.regiform.total_price.value = total;
		document.regiform.total.value = cashReturn(document.regiform.total.value);
		if ( document.regiform.out_total )
		{
			document.regiform.out_total.value = document.regiform.total.value;
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

		$necessary_javascriptscript

		return true;
	}
END;



	if( $_COOKIE['happy_mobile'] == 'on' )
	{
		$pay_java .= <<<END
		function on_click_phone_pay(btn)
		{
			myform = document.regiform;
			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					$agspay_alert
					myform.pay_type.value = 'phone';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}


		function on_click_card_pay(btn)
		{
			myform = document.regiform;
			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					$agspay_alert
					myform.pay_type.value = 'card';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}


		function on_click_bank_pay(btn)
		{
			myform = document.regiform;
			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					$agspay_alert
					myform.pay_type.value = 'bank';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}

		function on_click_bank_soodong_pay(btn)
		{
			myform = document.regiform;
			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					myform.pay_type.value = 'bank_soodong';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}

		function on_click_point_pay(btn)
		{
			myform = document.regiform;
			if ( parseInt(document.regiform.total_price.value) > parseInt('$회원정보[point]') )
			{
				alert("포인트가 부족합니다.");
				return false;
			}

			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					myform.pay_type.value = 'point';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}
END;
	}
	else
	{
		$pay_java .= <<<END
		// 결제용 아이프레임 리셑 - pay_page 아이프레임 사용시 적용 - x2chi 2015-11-24
		function on_click_reset()
		{
			var payPage			= document.getElementById("pay_page");
			var pay_frame_area	= document.getElementById("pay_frame_area");
			if( payPage.location != "about:blank" )
			{
				var agt = navigator.userAgent.toLowerCase();
				if (agt.indexOf("msie") != -1 || agt.indexOf("trident") != -1)
				{
					// IE 일경우
					//payPage.location = "about:blank";
					payPage.src	= "about:blank";
				}
				else
				{
					// IE 가 아닐 경우
					payPage.remove();
					pay_frame_area.innerHTML = '$pay_frame';
				}
			}
		}


		function on_click_phone_pay(btn)
		{
			on_click_reset();

			myform = document.regiform;

			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					$agspay_alert
					$pay_button_script
					myform.pay_type.value = 'phone';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}


		function on_click_card_pay(btn)
		{
			on_click_reset();

			myform = document.regiform;

			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					$pay_button_script
					myform.pay_type.value = 'card';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}


		function on_click_bank_pay(btn)
		{
			on_click_reset();

			myform = document.regiform;

			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					$agspay_alert
					$pay_button_script
					myform.pay_type.value = 'bank';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}

		function on_click_bank_soodong_pay(btn)
		{
			on_click_reset();

			myform = document.regiform;

			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					myform.pay_type.value = 'bank_soodong';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}

		function on_click_point_pay(btn)
		{
			on_click_reset();

			myform = document.regiform;

			if ( parseInt(document.regiform.total_price.value) > parseInt('$회원정보[point]') )
			{
				alert("포인트가 부족합니다.");
				return false;
			}

			if ( PayFormCheck(myform) )
			{
				if ( check_Valid() )
				{
					//여러번 클릭을 못하게
					var btn_onclick = btn.onclick;
					var btn1 = btn;
					btn.onclick = function() { };
					//여러번 클릭을 못하게

					myform.pay_type.value = 'point';
					myform.submit();

					//여러번 클릭을 못하게
					setTimeout(function(){ btn1.onclick = btn_onclick; },3000);
					//여러번 클릭을 못하게
				}
			}
		}
END;
	}


	$pay_java .= <<<END
		function checked(obj) {

			var cnt = obj.length;

			for(i=0; i< cnt; i++) {
				if(obj[i].checked == true) {
					return true;
					break;
				}
			}
			return false;
		}

		function valued(obj)
		{
			var cnt = obj.length;

			if ( cnt != undefined )
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
				if ( obj.checked )
				{
					return obj.value;
				}
			}

			return false;
		}

		</script>

		$activex_script
		<div id="pay_frame_area">$pay_frame</div>

		<input type='hidden' name='gou_number' value="$gou_number">
		<input type='hidden' name='total_price' value="0">
		<input type='hidden' name='id' value="$member_id">
		<input type='hidden' name='pay_type' value=''>
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
		if( $_COOKIE['happy_mobile'] == 'on' )
		{
			if ($CONF['bank_conf_mobile'])
			{
				$onclick1 = ' onclick = "on_click_bank_pay(this)" ';
				$PAY['bank'] ='<input type="button" value="실시간 계좌이체" style="" '.$onclick1.'>';
			}

			if ($CONF['card_conf_mobile'])
			{
				$onclick2 = ' onclick = "on_click_card_pay(this)" ';
				$PAY['card'] ='<input type="button" value="신용카드결제" style="" '.$onclick2.'>';
			}

			if ($CONF['phone_conf_mobile'])
			{
				$onclick3 = ' onclick = "on_click_phone_pay(this)" ';
				$PAY['phone'] ='<input type="button" value="휴대폰결제" style="" '.$onclick3.'>';
			}

			if ($CONF['bank_soodong_conf_mobile'])
			{
				$onclick4 = ' onclick = "on_click_bank_soodong_pay(this)" ';
				$PAY['bank_soodong'] = '<input type="button" value="무통장입금" style="" '.$onclick4.'>';
			}

			if ($CONF['point_conf_mobile'])
			{
				$onclick5 = ' onclick = "on_click_point_pay(this)" ';
				$PAY['point'] = '<input type="button" value="포인트 결제" style="" '.$onclick5.'>';
			}

			#무료버튼추가
			$onclick6 = ' onclick = "on_click_bank_soodong_pay(this)" ';
			$PAY['free'] = '
							<style type="text/css">
									.uryo_regist{display:block}
									.free_regist{display:none}
							</style>
							<!--<li class="help_balloon_pay_no"><p>현재 유료서비스 항목에 선택되어 있지 않습니다.</p></li>-->
							<input type="button" value="비결제 일반등록" style= vertical-align:middle; cursor:pointer; color:#333; background:#fff; border:1px solid #ddd" '.$onclick6.'>
			';
		}
		else
		{
			if ($CONF['bank_conf'])
			{
				$onclick1 = ' onclick = "on_click_bank_pay(this)" ';
				$PAY['bank'] ='<input type="button" value="" style="width:180px; height:60px; background:url(img/btn_pay01.gif) no-repeat; border:0px solid red; cursor:pointer;" '.$onclick1.'>';
			}

			if ($CONF['card_conf'])
			{
				$onclick2 = ' onclick = "on_click_card_pay(this)" ';
				$PAY['card'] ='<input type="button" value="" style="width:180px; height:60px; background:url(img/btn_pay02.gif) no-repeat; border:0px solid red; cursor:pointer;" '.$onclick2.'>';
			}

			if ($CONF['phone_conf'])
			{
				$onclick3 = ' onclick = "on_click_phone_pay(this)" ';
				$PAY['phone'] ='<input type="button" value="" style="width:180px; height:60px; background:url(img/btn_pay03.gif) no-repeat; border:0px solid red; cursor:pointer;" '.$onclick3.'>';
			}

			if ($CONF['bank_soodong_conf'])
			{
				$onclick4 = ' onclick = "on_click_bank_soodong_pay(this)" ';
				$PAY['bank_soodong'] = '<input type="button" value="" style="width:180px; height:60px; background:url(img/btn_pay04.gif) no-repeat; border:0px solid red; cursor:pointer; vertical-align:middle" '.$onclick4.'>';
			}

			if ($CONF['point_conf'])
			{
				$onclick5 = ' onclick = "on_click_point_pay(this)" ';
				$PAY['point'] = '<input type="button" value="" style="width:180px; height:60px; background:url(img/btn_pay05.gif) no-repeat; border:0px solid red; cursor:pointer;" '.$onclick5.'>';
			}

			#무료버튼추가
			$onclick6 = ' onclick = "on_click_bank_soodong_pay(this)" ';
			$PAY['free'] = '
							<style type="text/css">
									.uryo_regist{display:block}
									.free_regist{display:none}
							</style>
							<!--<li class="help_balloon_pay_no"><p>현재 유료서비스 항목에 선택되어 있지 않습니다.</p></li>-->
							<input type="button" value="" style="border:0px solid red; background:url(img/btn_noadd.gif) no-repeat; width:180px; height:60px; vertical-align:middle; cursor:pointer" '.$onclick6.'>
			';
		}
	}

	#결제방식을 찾자.


	$등록버튼 = $PAY['bank']." ".$PAY['card']." ".$PAY['phone']." ".$PAY['bank_soodong']." ".$PAY['point'];


	//$PAY['free'] = '<img src="img/pay_free.jpg" border=0 '.$onclick6.' onmouseover="this.style.cursor=\'hand\'" align=absmiddle alt="무료신청">';
	$PAY['loading_script'] = '<script>figure();</script>';

	if ($HAPPY_CONFIG['pg_company'] == "dacom")
	{
		$dacom_jumin = "
					<div id='pg_lg_uplus'>
						<table>
						<tr>
							<td class='title'>
								<ul>
									<li class='logo'><img src='./img/logo_lg_uplus.png' alt='LG 유플러스 전자결제 로고' width='173' height='28'></li>
									<li class='id_card'>주민등록번호 입력</li>
								</ul>
							</td>
							<td class='input'>
								<input type='text' name='jumin1' value='' id='jumin1'> -
								<input type='password' name='jumin2' value='' id='jumin2'>
							</td>
							<td class='help'>
								LG 유플러스(데이콤) 전자결제 시스템 경우에는 실시간 계좌이체 이용시 주민등록번호를 입력하셔야 합니다.
							</td>
						</tr>
						</table>
					</div>
		";
	}

	#패키지(즉시적용) 설정이 되있다면
	$패키지즉시적용박스 = pack2_box(); //temp/package2_selectbox.html
	#패키지(즉시적용) 설정이 되있다면 END

	$TPL->define("결제폼", "./$skin_folder/guin_pay.html");
	$TPL->assign("결제폼");
	$채용정보결제페이지 = &$TPL->fetch();

}
else
{
	//무료등록버튼
	#$등록버튼 = '<input type=image src="img/bt_guin_regist.gif" value="구인등록" align="absmiddle">&nbsp;&nbsp;<a href="javascript:location.reload()"><img src="img/bt_cancel2.gif" value=다시쓰기  align="absmiddle" border="0"></a>';
	$등록버튼 = "
		<span id='commercial_page'><input type='submit' value='' style='background:url(img/btn_free_guinreg.gif) no-repeat; width:120px; height:42px; border:none; vertical-align:middle;' alt='무료구인등록하기' title='무료구인등록하기'/>
		<input type='button' onclick='javascript:location.reload()' style='background:url(img/btn_again_write.gif) no-repeat; width:90px; height:42px; border:none; vertical-align:middle;' alt='다시쓰기' title='다시쓰기'>";
	#$등록버튼 = '<input type=image src="img/bt_guin_regist.gif" value="구인등록" align="absmiddle">&nbsp;&nbsp;<a href="javascript:location.reload()"><img src="img/bt_cancel2.gif" value=다시쓰기  align="absmiddle" border="0"></a>';
}


$inquiry_use_display	= "display:none;";
if ( $HAPPY_CONFIG['inquiry_form_use_conf'] == "upche" )
{
	$inquiry_use_display	= "display:block;";
}
else if ( $HAPPY_CONFIG['inquiry_form_use_conf'] == "admin" && admin_secure("구인리스트") )
{
	$inquiry_use_display	= "display:block;";
}


$TPL->define("구인등록", "./$skin_folder/guin_regist.html");
$TPL->assign("구인등록");
$내용 = &$TPL->fetch();
$내용 = <<<END
<script language="javascript" src="calendar.js"></script>
<script>
var request;
function createXMLHttpRequest()
{
	if (window.XMLHttpRequest) {
	request = new XMLHttpRequest();
	} else {
	request = new ActiveXObject("Microsoft.XMLHTTP");
	}
}

function startRequest(sel,target,size)
{
var trigger = sel.options[sel.selectedIndex].value;
var form = sel.form.name;
createXMLHttpRequest();
request.open("GET", "sub_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
request.onreadystatechange = handleStateChange;
request.send(null);
}

function startRequest2(sel,target,size)
{
var trigger = sel.options[sel.selectedIndex].value;
var form = sel.form.name;
createXMLHttpRequest();
request.open("GET", "sub_type_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
request.onreadystatechange = handleStateChange;
request.send(null);
}

function handleStateChange() {
	if (request.readyState == 4) {
		if (request.status == 200) {
		var response = request.responseText.split("---cut---");
		eval(response[0]+ '.innerHTML=response[1]');
		window.status="완료"
		}
	}
	if (request.readyState == 1)  {
	window.status="로딩중....."
	}
}
</script>
	$내용

	<!-- 아래 자바스크립트를 삭제하시면 안됩니다. -->
	<script language="javascript" >
	createLayer('Calendar');
	</script>
END;



//YOON : 2011-08-09 : 회원그룹관리 지정 껍데기 템플릿파일로 변경
$Member					= happy_member_information($happy_member_login_id);
$member_group			= $Member['group'];

$Sql					= "SELECT * FROM $happy_member_group WHERE number='$member_group'";
$Group					= happy_mysql_fetch_array(query($Sql));


$Template_Default		= ( $Group['mypage_default'] == '' )? $happy_member_mypage_default_file : $Group['mypage_default'];

//YOON : 2011-11-26
//개인회원 로그인중이고, 관리자로 로그인중일 때 개인회원 껍데기 템플릿파일 적용되는 것을 방지
//$member_group		>> 1이면 개인회원, 2이면 기업회면
if ($member_group == 1)
{
	$Template_Default = "happy_member_default_mypage_com.html";
}


# YOON : 2011-12-16 : 출석댓글 첫 로딩에 문제가 있어 데모알림창 표시안되게 처리
if ( $demo_lock )
{
	$cgialert = <<<DEMOALERT
DEMOALERT;
}

$TPL->define("껍데기", "./$skin_folder/$Template_Default");
//$TPL->define("껍데기", "./$skin_folder/default_com.html");
$TPL->assign("껍데기");
echo $TPL->fetch();

exit;








?>