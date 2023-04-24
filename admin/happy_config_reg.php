<?php
	include ("../inc/config.php");
	include ("../inc/function.php");
	include ("../inc/lib.php");
	include ("../inc/lib_pay.php");


	#관리자 접속 체크 루틴
	/* if ( !admin_secure("슈퍼관리자") ) {
		error("접속권한이 없습니다.   ");
		exit;
	} */
	#관리자 접속 체크 루틴
	
	if ( $number == '' )
	{
		$number			= preg_replace('/\D/', '',$_POST['number']);
	}

	if ( $number == '' )
	{
		error("잘못된 경로로 접근하셨네요.");
		exit;
	}

	$Group			= happy_mysql_fetch_array(query("SELECT * FROM $happy_config_group WHERE number='$number'"));

	#print_r($Group['group_title']);
	//exit;

	#부관리자 권한 체크
	$회원관리 = array("회원가입 관련설정");
	$유료결제관리 = array("결제 환경설정","유료옵션 설정","이력서 유료옵션 아이콘 관리","채용정보 유료옵션 아이콘 관리","유료옵션 결제관련 설정");
	$플래쉬로고관리 = array("플래시지도 환경설정","메인플래시배너 환경설정","메인플래시업체출력 설정","플래시메뉴 설정","클라우드태그 환경설정");
	$게시판관리 = array("게시판 환경설정");
	$구인등록관리 = array("채용정보 등록설정");
	$구직등록관리 = array("이력서 상세화면 보기 권한");
	$미니앨범관리 = array("미니앨범 관리");
	$추천키워드 = array("추천키워드 설정");

	if ( in_array($Group['group_title'],$회원관리) )
	{
		if ( !admin_secure("회원관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$추천키워드) )
	{
		if ( !admin_secure("추천키워드") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$유료결제관리) )
	{
		if ( !admin_secure("결제관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$플래쉬로고관리) )
	{
		if ( !admin_secure("플래쉬|로고관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$게시판관리) )
	{
		if ( !admin_secure("게시판관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$구인등록관리) )
	{
		if ( !admin_secure("구인리스트") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$구직등록관리) )
	{
		if ( !admin_secure("구직리스트") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else if ( in_array($Group['group_title'],$미니앨범관리) )
	{
		if ( !admin_secure("미니앨범관리") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	else
	{
		if ( !admin_secure("최고관리자") ) {
			error("접속권한이 없습니다.   ");
			exit;
		}
	}
	#부관리자 권한 체크


	if ( $demo_lock )
	{
		error("데모버젼에서는 이용하실수 없습니다.");
		exit;
	}

	$happy_fields_name	= $_POST['happy_fields_name'];
	$happy_fields_type	= $_POST['happy_fields_type'];
	$happy_fields_out	= $_POST['happy_fields_out'];

	$number	= $_POST['number'];
	$max	= sizeof($happy_fields_name);

	for ( $i=0 ; $i<$max ; $i++ )
	{
		$type	= $happy_fields_type[$i];
		$name	= $happy_fields_name[$i];
		$option	= $happy_fields_option[$i];
		$out	= $happy_fields_out[$i];

		if ( $type == 'text' || $type == 'select' || $type == 'radio' || $type == 'textarea' || $type == 'wys' || $type == 'phone' )
		{
			$value	= $_POST[$name];
		}
		else if ( $type == 'checkbox' )
		{
			$value	= @implode(",", (array) $_POST[$name]);
		}
		else if ( $type == 'file' )
		{
			if ( $_POST[$name."_del"] == 'ok' )
			{
				$value	= '';
			}

			if ( $_FILES[$name]["name"] != "" )
			{

				$upImageName	= $_FILES[$name]["name"];
				$upImageTemp	= $_FILES[$name]["tmp_name"];


				$temp_name		= explode(".",$upImageName);
				$ext			= strtolower($temp_name[sizeof($temp_name)-1]);

				$options		= explode(",",$option);

				for ( $z=0,$m=sizeof($options),$ext_check='' ; $z<$m ; $z++ )
				{
					if ( $ext == $options[$z])
					{
						$ext_check	= 'ok';
						break;
					}
				}

				if ( $ext_check != 'ok' && $_POST[$name."_del"] != 'ok' )
				{
					$addMessage	= "\\n\\n$name 필드 : 파일업로드 가능한 확장자가 아닙니다.($ext) \\n업로드 가능한 확장자는 $option 입니다.";
					continue;
				}
				else
				{
					$img_url_re		= "../${happy_config_upload_folder}/". str_replace(" ","",$name) .".${ext}";

					if ( move_uploaded_file($upImageTemp,$img_url_re) )
					{
						@unlink($upImageTemp);
						$value	= str_replace("../","",$img_url_re);
					}
					else if ( $_POST[$name."_del"] != 'ok' )
					{
						$addMessage	= "\\n\\n$name 필드 : 업로드 실패 Error:0038";
						continue;
					}
				}
			}
			else if ( $_POST[$name."_del"] != 'ok' )
			{
				continue;
			}
		}

		if ( $happy_config_auto_addslashe == '' )
		{
			$value	= addslashes($value);
		}

		$value	= str_replace("<!==","<!--",$value);
		$value	= str_replace("==>","-->",$value);

		query(happy_config_query_make($name, $value,$out));
	}


	if(array_key_exists("pg_secure_key",$_POST))
	{
		pg_lgdacom_conf(); //U+(데이콤) 세부설정
	}

	gomsg("저장되었습니다.$addMessage","happy_config_view.php?number=$number");

	function happy_config_query_make($title, $value,$out)
	{
		global $happy_config;
		$Sql	= "select count(*) from $happy_config WHERE conf_name='$title' ";
		$Temp	= happy_mysql_fetch_array(query($Sql));

		if ( $Temp[0] == 0 )
		{
			$Sql	= "
						INSERT INTO
								$happy_config
						SET
								conf_name		= '$title',
								conf_value		= '$value',
								conf_out_type	= '$out',
								reg_date		= now(),
								mod_date		= now()
			";
		}
		else
		{
			$Sql	= "
						UPDATE
								$happy_config
						SET
								conf_name		= '$title',
								conf_value		= '$value',
								conf_out_type	= '$out',
								mod_date		= now()
						WHERE
								conf_name		= '$title'
			";
		}
		return $Sql;
	}

?>