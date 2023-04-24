<?php
	include ("./inc/Template.php");
	$TPL = new Template;
	include ("./inc/config.php");
	include ("./inc/function.php");
	include ("./inc/lib.php");

	if ( happy_member_login_check() == "" && !admin_secure("슈퍼관리자전용") )
	{
		gomsg("회원로그인후 사용할수 있는 페이지입니다","./happy_member_login.php");
		exit;
	}


	//$file_name_view_option	= 1;

	if ( $_GET['mode'] == "" )
	{
		logo_upload();
	}
	elseif ( $_GET['mode'] == "logo_upload_reg" )
	{
		logo_upload_reg();
	}
	else
	{
		error("잘못된 접근방법");
	}

#################################################################################
function logo_upload()
{
	global $TPL;
	global $COM_INFO;
	global $happy_member,$user_id,$happy_member_secure_text;

	global $happyMemberAdminMode;
	global $happyMemberMode,$happy_member,$happy_member_group;
	global $MemberData;
	global $hidden_form;
	global $skin_folder;




	if ( admin_secure("회원관리") )
	{
		if ( $_GET['guin_number'] == "" )
		{
			//관리자가 수정할때
			//회사 로고 + 회사 배너 + 이력서 사진 모두 수정가능해야 함
			$number		= preg_replace("/\D/", "", $_GET['number']);
			if ( $number != "" )
			{
				$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member WHERE number='$number'"));
				$hidden_form = '<input type="hidden" name="number" value="'.$number.'">';
			}
			else
			{
				$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member WHERE user_id ='$user_id'"));
			}

			if ( $MemberData['number'] == '' )
			{
				error("존재하지 않는 회원정보 입니다.");
				exit;
			}

			$_GET['member_group']	= $MemberData['group'];
			$member_group			= $MemberData['group'];

			$MemberData['user_jumin2'] = "XXXXXXX";

			$Group					= happy_mysql_fetch_array(query("SELECT * FROM $happy_member_group WHERE number='$member_group' "));

			$happyMemberAdminMode	= 'happyOk';
			$happyMemberMode		= 'mod';


			$sql = "select * from $happy_member where user_id='".$_GET['member_id']."' ";
			$result = query($sql);
			$COM_INFO  = happy_mysql_fetch_array($result);

			$TPL->define("로고관리자기업회원알맹이", "$skin_folder/logo_change_all.html");
			$TPL->assign("로고관리자기업회원알맹이");
			$내용 = &$TPL->fetch();
		}
		//채용정보별로 이미지 수정
		else
		{
			global $guin_tb;
			global $photo2_del,$photo2_미리보기,$ComLogoDstW,$ComLogoDstH;
			global $photo3_del,$photo3_미리보기,$ComBannerDstW,$ComBannerDstH;


			//관리자가 수정할때
			//회사 로고 + 회사 배너 + 이력서 사진 모두 수정가능해야 함
			$number		= preg_replace("/\D/", "", $_GET['number']);
			if ( $number != "" )
			{
				$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member WHERE number='$number'"));
				$hidden_form = '<input type="hidden" name="number" value="'.$number.'">';
			}
			else
			{
				$MemberData	= happy_mysql_fetch_array(query("SELECT * FROM $happy_member WHERE user_id ='$user_id'"));
			}

			if ( $MemberData['number'] == '' )
			{
				error("존재하지 않는 회원정보 입니다.");
				exit;
			}


			$guin_number = intval($_GET['guin_number']);

			$sql = "select * from $guin_tb where number = '$guin_number'";
			$result = query($sql);
			$COM_INFO = happy_mysql_fetch_assoc($result);

			if ( $COM_INFO['photo2'] != "" )
			{
				$value = $COM_INFO['photo2'];
				if (eregi('.jp', $value) )
				{
					$value_thumb = str_replace(".jpg","_thumb.jpg",$value);
				}
				else
				{
					$value_thumb = $value;
				}

				$photo2_del = "<span class='h_form'><label class='h-check' for='photo2_del'><input id='photo2_del' name='photo2_del' type='checkbox' value='1' style='vertical-align:middle'><span class='noto400 font_13'>파일삭제</span></label></span>";
				$photo2_미리보기 = "<img src='".$value_thumb."' border='0' width='".$ComLogoDstW."' height='".$ComLogoDstH."' onError=this.src='./img/noimage_del.jpg' style='margin-top:5px;'>";
			}

			if ( $COM_INFO['photo3'] != "" )
			{
				$value = $COM_INFO['photo3'];
				if (eregi('.jp', $value) )
				{
					$value_thumb = str_replace(".jpg","_thumb.jpg",$value);
				}
				else
				{
					$value_thumb = $value;
				}

				$photo3_del = "<span class='h_form'><label class='h-check' for='photo3_del'><input id='photo3_del' name='photo3_del' type='checkbox' value='1' style='vertical-align:middle'><span class='noto400 font_13'>파일삭제</span></label></span>";
				$photo3_미리보기 = "<img src='".$value_thumb."' border='0' width='".$ComBannerDstW."' height='".$ComBannerDstH."' onError=this.src='./img/noimage_del.jpg' style='margin-top:5px;'>";
			}


			$TPL->define("로고관리자기업회원알맹이", "$skin_folder/logo_change_guin.html");
			$TPL->assign("로고관리자기업회원알맹이");
			$내용 = &$TPL->fetch();
		}
		//채용정보별로 이미지 수정

	}
	else if ( happy_member_secure($happy_member_secure_text[0].'등록') && happy_member_secure($happy_member_secure_text[1].'등록') )
	{
		//이력서 채용정보 둘다 등록가능할때
		//회사 로고 + 회사 배너 + 이력서 사진 모두 수정가능해야 함
		$sql = "select * from $happy_member where user_id='$user_id' ";
		//echo $sql;
		$result = query($sql);
		$MemberData  = happy_mysql_fetch_array($result);

		$member_group			= $MemberData['group'];

		$happyMemberMode		= 'mod';
		$MemberData['user_jumin2'] = "XXXXXXX";

		$Group					= happy_mysql_fetch_array(query("SELECT * FROM $happy_member_group WHERE number='$member_group' "));

		$_GET['member_group'] = $MemberData['group'];


		$TPL->define("로고관리자기업회원알맹이", "$skin_folder/logo_change_all.html");
		$TPL->assign("로고관리자기업회원알맹이");
		$내용 = &$TPL->fetch();
	}
	else if ( happy_member_secure($happy_member_secure_text[0].'등록') )
	{
		//이력서만 등록가능할때
		//이력서 사진만 수정가능해야 함
		$sql = "select * from $happy_member where user_id='$user_id' ";
		//echo $sql;
		$result = query($sql);
		$MemberData = happy_mysql_fetch_array($result);

		$_GET['member_group'] = $MemberData['group'];

		$TPL->define("로고일반회원알맹이", "$skin_folder/logo_change_per.html");
		$TPL->assign("로고일반회원알맹이");
		$내용 = &$TPL->fetch();
	}
	elseif ( happy_member_secure($happy_member_secure_text[1].'등록') )
	{
		//채용정보만 등록가능할때
		//회사 로고 + 회사 배너 수정가능해야함
		$sql = "select * from $happy_member where user_id='$user_id' ";
		$result = query($sql);
		$MemberData = happy_mysql_fetch_array($result);


		$happyMemberAdminMode	= 'happyOk';
		$happyMemberMode		= 'mod';

		$_GET['member_group'] = $MemberData['group'];


		$TPL->define("로고기업회원알맹이", "$skin_folder/logo_change_com.html");
		$TPL->assign("로고기업회원알맹이");
		$내용 = &$TPL->fetch();

	}
	else
	{
		error("로그인 후 이용하세요");
		exit;
	}

	print $내용;
	exit;
}
#################################################################################

function logo_upload_reg(){


	global $happy_member_upload_folder,$happy_member_upload_path;
	global $happy_member,$happy_member_field,$happy_member_group;
	global $happy_autoslashes;


	global $happy_member_image_width, $happy_member_image_height, $happy_member_image_quality, $happy_member_image_position, $happy_member_image_logo, $happy_member_image_logo_position, $happy_member_image_type;
	global $happy_member_image_width2, $happy_member_image_height2, $happy_member_image_quality2, $happy_member_image_position2, $happy_member_image_logo2, $happy_member_image_logo_position2, $happy_member_image_type2;

	//이미지 생성변수들
	global $PerPhotoDstW,$PerPhotoDstH,$PerPhotoCreateType;
	global $ComLogoDstW,$ComLogoDstH,$ComPhotoCreateType1;
	global $ComBannerDstW,$ComBannerDstH,$ComPhotoCreateType2;


	if (!is_dir("$happy_member_upload_folder"))
	{
		error("첨부파일을 위한 ($happy_member_upload_folder)폴더가 존재하지 않습니다.  ");
		exit;
	}

	$now_year	= date("Y");
	$now_month	= date("m");
	$now_day	= date("d");

	$now_time	= happy_mktime();

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

	$happy_member_login_id	= happy_member_login_check();

	if ( !admin_secure("회원관리") )
	{
		if ( $happy_member_login_id == "" )
		{
			error('로그인후 이용가능 합니다.');
			exit;
		}
	}
	else
	{
		if ( $_POST['number'] != "" )
		{
			//관리자가 수동으로 수정해줄때
			$number = intval($_POST['number']);
			list($happy_member_login_id) = happy_mysql_fetch_array(query("select user_id from $happy_member where number = '$number'"));
			$paging_move = "no";
		}
	}


	$Member			= happy_member_information($happy_member_login_id);
	$member_group	= $Member['group'];

	$group				= $member_group;

	#그룹명으로 가입가능한 그룹인지 한번더 체크
	$Sql	= "SELECT * FROM $happy_member_group WHERE number='$group'";
	$Group	= happy_mysql_fetch_array(query($Sql));

	$WHERE	= " AND field_modify = 'y' ";
	$WHERE	.= " AND field_name != '' ";
	$WHERE	.= " AND field_name != 'user_pass' ";
	$WHERE	.= " AND field_name != 'user_pass2' ";
	$WHERE	.= " AND field_name != 'user_nick' ";
	$WHERE	.= " AND field_name != 'state_open' ";




	$Sql	= "SELECT * FROM $happy_member_field WHERE member_group = '$group' $WHERE ";
	$Record	= query($Sql);

	$Cnt	= 0;
	$SetSql	= '';
	$Img_Url = '';
	while ( $Form = happy_mysql_fetch_array($Record) )
	{
		$Fields		= call_happy_member_field($Form['field_name']);
		#echo "<pre>";			print_r($Fields);			echo "</pre>";
		#echo "$".$Fields['Field'] ."  = ". $_POST[$Fields['Field']]."<hr>";

		$nowField	= $Fields['Field'];

		if ( $nowField == '' )
		{
			continue;
		}

		${$Fields['Field']}	= $_POST[$Fields['Field']];

		if ( $happy_autoslashes )
		{
			${$nowField}	= addslashes(${$nowField});
		}

		# DB형식이 INT형일때
		if ( preg_match("/int/", $Fields['Type']) )
		{
			${$nowField}	= preg_replace("/\D/", "", ${$nowField});
		}

		# 파일 업로드
		if ( $Form['field_type'] == 'file' )
		{

			${$nowField}	= '';

			if ( $_FILES[$nowField]["name"] != "" )
			{
				//echo $nowField."<br>";
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
					continue;
				}
				else
				{
					$rand_number =  rand(0,1000000);
					$img_url_re			= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";
					$img_url_re_thumb	= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb.$ext";
					$img_url_re_thumb2	= "${happy_member_upload_path}$now_year/$now_month/$now_day/$now_time-$rand_number"."_thumb2.$ext";
					$img_url_file_name	= "${happy_member_upload_folder}$now_year/$now_month/$now_day/$now_time-$rand_number.$ext";

					if (copy($upImageTemp,"$img_url_re"))
					{

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

				if ( ${$nowField} == '' )
				{
					continue;
				}
			}
			else if ( $_POST[$nowField."_del"] != 'ok' )
			{
				continue;
			}
		}


		if ( is_array(${$nowField}) )
		{
			${$nowField}	= @implode(",", (array) ${$nowField});
		}

		if ( $Form['field_sureInput'] == 'y' && $Form['field_modify'] == 'y' && ${$nowField} == '' )
		{
			//echo $Form['field_name'] ." 필드의 값이 넘어오지 않았습니다.";
			#error( $Form['field_name'] ." 필드의 값이 넘어오지 않았습니다. ");
			#exit;
		}

		//이미지만 변경하기 위해서.
		if ( $nowField == "photo1" || $nowField == "photo2" || $nowField == "photo3" )
		{
			$SetSql	.= ( $SetSql == '' )? '' : ', ';
			$SetSql	.= " $nowField = '".${$nowField}."' \n";

			$Img_Url = ${$nowField};
		}
	}

	global $guin_tb, $per_document_tb, $happy_member_login_value;

	if ( $_GET['guin_number'] == "" ) //이력서 사진수정
	{
		if(admin_secure("슈퍼관리자전용") && $happy_member_login_id == "")
		{
			$Sql = "SELECT user_id,photo1 FROM $happy_member WHERE number=$_POST[number]";
			$Rec = query($Sql);
			$MEM_INFO = happy_mysql_fetch_assoc($Rec);

			$user_id_info = $MEM_INFO['user_id'];
		}
		else
		{
			$user_id_info = $happy_member_login_id;
		}

		if($user_id_info == "")
		{
			msgclose("잘못된 접근입니다");
			exit;
		}


		$Sql	= "
					UPDATE
							$happy_member
					SET
							$SetSql
					WHERE
							user_id	= '$user_id_info'
		";
		//query($Sql);

		if ( $Img_Url != '' )
		{
			query("update $per_document_tb set user_image = '$Img_Url' where user_id = '$user_id_info'");
		}
		else if ( $Img_Url == '' )
		{
			$sql = "select photo1 from $happy_member where user_id = '$user_id_info'";
			list($Img_Url) = mysql_fetch_row(query($sql));

			query("update $per_document_tb set user_image = '$Img_Url' where user_id = '$user_id_info'");
		}
	}
	else
	{
		$guin_number = intval($_GET['guin_number']);
		$Sql = "update $guin_tb set $SetSql where number = '".$guin_number."'";

		if ( $_POST['photo2_del'] == "1" )
		{
			$sql = "update $guin_tb set photo2 = '".$Member['photo2']."' where number = '".$guin_number."'";
			query($sql);
		}

		if ( $_POST['photo3_del'] == "1" )
		{
			$sql = "update $guin_tb set photo3 = '".$Member['photo3']."' where number = '".$guin_number."'";
			query($sql);
		}

		$opener_reload = "yes";
	}



	if ( $SetSql != "" )
	{
		query($Sql);
	}

	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		msg("이미지가 업데이트 되었습니다");
		go("happy_member.php?mode=mypage");
	}
	else
	{
		if ( $paging_move != "no" )
		{
			$go_script = "window.opener.location.href = 'happy_member.php?mode=mypage';";
		}

		if ( $opener_reload == "yes" )
		{
			$go_script = "if ( opener != undefined ) { opener.location.reload(); } ";
		}

		echo "
		<script language=javascript>
		<!--
			alert('이미지가 업데이트 되었습니다');
			".$go_script."
			window.close();
		// -->
		</script>
		";
	}

}

exit;


?>