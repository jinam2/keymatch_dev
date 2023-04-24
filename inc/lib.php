<?php

if ( $happy_admin_ipCheck != "" )
{
	happy_admin_ipCheck();
}
	happy_inquiry_button_print();

	include "lib_happy_member.php";

	//데모 로그인 기능 개선.		2018-12-13 hun
	$SELLER_TYPE_STYLE	= Array(
								"upche"		=> '',
								"normal"	=> 'display:none;'
	);

	$tmp_cook					= $_COOKIE[$happy_member_admin_id_cookie_val];		//관리자 권한이 있을 경우 반드시 등록권한이 있기 때문에 잠시 가로채기 합시다.
	$_COOKIE[$happy_member_admin_id_cookie_val]		= "";

	if ( happy_member_secure( $happy_member_secure_text[0].'등록' ) )				//상품등록 권한 없을 경우 내판매관리 버튼 안보이게
	{
		$SELLER_TYPE_STYLE['upche']		= 'display:none;';
		$SELLER_TYPE_STYLE['normal']	= '';
	}

	$_COOKIE[$happy_member_admin_id_cookie_val]			= $tmp_cook;

	$비회원일때숨김		= '';
	if ( happy_member_login_check() == "" )
	{
		$비회원일때숨김		= 'display:none;';
	}
	//데모 로그인 기능 개선.		2018-12-13 hun

	# 추천인 기능 추가 - 13.01.15 hong
	recommend_check();

	//hun	2013-07-19	로그인되지 않은 상황에서 자동로그인을 허용한 경우... 자동로그인 시켜주기
	if ( $_COOKIE['happy_member_auto_login_id'] != '' && $_COOKIE['happy_member_auto_login_pass'] != '' && $_COOKIE["happyjob_userid"] == '' )
	{
		$Sql				= "select * from $happy_member WHERE user_id='".$_COOKIE['happy_member_auto_login_id']."' ";
		$User				= happy_mysql_fetch_array(query($Sql));

		$User['user_pass']	= Happy_Secret_Code($User['user_pass']);

		if ( $User['user_pass'] == $_COOKIE['happy_member_auto_login_pass'] )
		{

			if ( $happy_member_login_value_type == 'session' )
			{
				$_SESSION[$happy_member_login_value_name]	= $_COOKIE['happy_member_auto_login_id'];
			}
			else if ( $happy_member_login_value_type == 'cookie' )
			{
				$_COOKIE[$happy_member_login_value_name]	= $_COOKIE['happy_member_auto_login_id'];
				setcookie($happy_member_login_value_name,$_COOKIE['happy_member_auto_login_id'],0,"/",$happy_member_login_value_url);
			}
			else
			{
				return print "<font color=red>잘못된 \$happy_member_login_value_type 설정입니다.</font>";
			}

			$happy_member_login_value	= $_COOKIE['happy_member_auto_login_id'];
			$message_loginVal			= $_COOKIE['happy_member_auto_login_id'];


			$max	= sizeof( $happy_member_login_sub_value_type );

			for ( $i=0 ; $i<$max ; $i++ )
			{
				$value_type		= $happy_member_login_sub_value_type[$i];
				$value_name		= $happy_member_login_sub_value_name[$i];
				$value_DB		= $happy_member_login_sub_value_DB[$i];
				$value_Table	= $happy_member_login_sub_value_Table[$i];
				$value_Field	= $happy_member_login_sub_value_Field[$i];
				$value_secure	= $happy_member_login_sub_value_secure[$i];
				$value_where	= $happy_member_login_sub_value_where[$i];

				if ( $value_type == '' || $value_name == '' || $value_DB == '' || $value_Table == '' || $value_Field == '' )
				{
					continue;
				}

				$value_where	= str_replace('%회원아이디%', $User['user_id'], $value_where );
				$value_where	= str_replace('%회원고유번호%', $User['number'], $value_where );


				$Sql		= "SELECT $value_Field FROM $value_Table $value_where ";
				$Tmp		= happy_mysql_fetch_array(query($Sql));

				$cookie_val	= $Tmp[$value_Field];

				if ( $value_secure == 'md5' )
				{
					$cookie_val	= Happy_Secret_Code($cookie_val);
				}
				else if ( $value_secure == 'password' )
				{
					list($cookie_val)	= happy_mysql_fetch_array(query("SELECT password('$cookie_val')"));
				}
				else if ( $value_secure == 'old_password' )
				{
					list($cookie_val)	= happy_mysql_fetch_array(query("SELECT old_password('$cookie_val')"));
				}

				if ( $value_type == 'session' )
				{
					$_SESSION[$value_name]	= $cookie_val;
				}
				else if ( $value_type == 'cookie' )
				{
					$_COOKIE[$value_name]	= $cookie_val;
					setcookie($value_name,$cookie_val,0,"/",$happy_member_login_value_url);
				}
				else
				{
					continue;
				}
			}

			//오늘날짜를 비교해서 검색하자.
			$Sql = "Select count(*) from $happy_member where user_id = '$happy_member_login_value' AND LEFT(login_date,10) = curdate()";
			list($login_check_ct) = happy_mysql_fetch_array(query($Sql));

			query("UPDATE $happy_member SET login_date = now(), login_count = login_count + 1 where user_id='$happy_member_login_value' ");

			if ( $_GET['login_return'] != '' )
			{
				go(str_replace('http','',$_GET['login_return']));exit;
			}
		}
	}
	//hun	2013-07-19	로그인되지 않은 상황에서 자동로그인을 허용한 경우... 자동로그인 시켜주기


function happy_weather_conf_set($conf_name,$conf_value)
{
	global $happy_config;

	$Sql				= "SELECT COUNT(*) FROM $happy_config WHERE conf_name = '$conf_name' ";
	list($ChkCnt)		= happy_mysql_fetch_array(query($Sql));

	if ( $ChkCnt == 0 )
	{
		$Sql				= "
								INSERT INTO
										$happy_config
								SET
										conf_name		= '$conf_name',
										conf_value		= '$conf_value',
										reg_date		= NOW(),
										mod_date		= NOW()
		";
	}
	else
	{
		$Sql				= "
								UPDATE
										$happy_config
								SET
										conf_value		= '$conf_value',
										mod_date		= NOW()
								WHERE
										conf_name		= '$conf_name'
		";
	}
	query($Sql);
}

function happy_weather_calltime_update()
{
	global $happy_config, $HAPPY_CONFIG;

	$update_term			= 10; //업데이트 간격(일)

	$is_update				= false;

	if ( $HAPPY_CONFIG['happy_weather_calltime_update'] == "" )
	{
		$is_update				= true;
	}
	else
	{
		$temp_date				= explode(" ",$HAPPY_CONFIG['happy_weather_calltime_update']);
		list($year,$month,$day)	= explode("-",$temp_date[0]);
		list($hour,$min,$sec)	= explode(":",$temp_date[1]);

		$check_date				= happy_mktime($hour,$min,$sec,$month,$day+$update_term,$year);

		if ( $check_date < happy_mktime() ) //업데이트 간격만큼 지남
		{
			$is_update				= true;
		}
	}

	//UPDATE START
	if ( $is_update == true )
	{
		$wthr_calltime_url		= "http://weather.cgimall.co.kr/calltime.txt";

		$get_wthr_calltime		= weather_fsockopen($wthr_calltime_url);
		$get_wthr_calltime_cut	= explode("_",$get_wthr_calltime);

		if ( $get_wthr_calltime_cut[0] != "OK" )
		{
			return;
		}

		$now_date				= date("Y-m-d H:i:s");

		happy_weather_conf_set('happy_weather_calltime',$get_wthr_calltime_cut[1]);
		happy_weather_conf_set('happy_weather_calltime_update',$now_date);

		$HAPPY_CONFIG['happy_weather_calltime']			= $get_wthr_calltime_cut[1];
		$HAPPY_CONFIG['happy_weather_calltime_update']	= $now_date;
	}
	//UPDATE END
}

$happy_weather_count = 0;
function happy_weather_print($file_name, $area_selectbox_class=’’,$happy_img_color_c='',$happy_img_color_h='',$happy_weather_count_in = '')
{
	global $TPL,$skin_folder;
	global $happy_weather_count,$happy_weather_areas;
	global $upso2_weather_info,$auction_weather_info;
	global $날씨아이콘,$날씨텍스트,$지역명,$지역명아이콘,$온도,$온도아이콘,$지역변경스크립트,$지역선택박스,$is_ajax_weather;

	$upso2_weather_info		= $auction_weather_info;
	$wthr_xml_url			= "http://weather.cgimall.co.kr/today.php";
	$now_hour				= date("H");

	$wthr_img_path			= "./img/weather/";
	$area_textimg_size		= 9;	// 지역명 happy_imgmaker 폰트 사이즈
	$ta_textimg_size		= 9;	// 온도 happy_imgmaker 폰트 사이즈

	$happy_weather_count	= ( $happy_weather_count_in != '' ) ? $happy_weather_count_in : $happy_weather_count;

	//날씨API 기능수정 hong
	global $HAPPY_CONFIG;

	happy_weather_calltime_update();

	if ( $HAPPY_CONFIG['happy_weather_last_update'] == "" )
	{
		$chk_h					= date("H");
		$check_time_1			= happy_mktime($chk_h,0,0,date("m"),date("d"),date("Y"));
	}
	else
	{
		$last_update_cut		= explode(" ",$HAPPY_CONFIG['happy_weather_last_update']);
		list($chk_y,$chk_m,$chk_d) = explode("-",$last_update_cut[0]);
		list($chk_h,$chk_i,$chk_s) = explode(":",$last_update_cut[1]);

		$check_time_1			= happy_mktime($chk_h,$chk_i,$chk_s,$chk_m,$chk_d,$chk_y);
	}

	$check_time_2			= happy_mktime(date("H"),$HAPPY_CONFIG['happy_weather_calltime'],0,date("m"),date("d"),date("Y"));

	$is_new_update			= false;

	if ( $check_time_1 <= $check_time_2 && $chk_h == date("H") && $HAPPY_CONFIG['happy_weather_calltime'] <= date("i") )
	{
		$is_new_update			= true;
	}
	//날씨API 기능수정 hong END

	$sql					= "
								SELECT
										number,xml_info
								FROM
										$upso2_weather_info
								WHERE
										city		= '$now_hour'
								AND
										xml_date	= CURDATE()
	";
	//echo $sql;
	list($chk_number,$chk_xml)	= mysql_fetch_row(query($sql));

	if( $chk_number == '' && $chk_xml == '' || $is_new_update == true ) //날씨API 기능수정 hong
	{
		$get_wthr_info		= weather_fsockopen($wthr_xml_url);
		#구글에서 에러를 보내는 경우는 담지 말자.
		if (preg_match("/^<\?xml/",$get_wthr_info,$mat))
		{
			//날씨API 기능수정 hong
			if ( $chk_number != '' )
			{
				$sql			= "DELETE FROM $upso2_weather_info WHERE number = '$chk_number' ";
				query($sql);
			}

			$sql			= "
								INSERT INTO
											$upso2_weather_info
								SET
											city		= '$now_hour',
											xml_info	= '$get_wthr_info',
											xml_date	= CURDATE()
			";
			query($sql);

			//날씨API 기능수정 hong
			happy_weather_conf_set('happy_weather_last_update',date("Y-m-d H:i:s"));
		}
	}

	$random					= rand()%1000;
	$TPL->define("날씨_$random", $skin_folder."/".$file_name);

	$sql					= "
								SELECT
										xml_info
								FROM
										$upso2_weather_info
								WHERE
										city		= '$now_hour'
								AND
										xml_date	= CURDATE()
	";
	list($wthr_xml)			= mysql_fetch_row(query($sql));

	$W_icon					= Array(
									'맑음'					=> 'sunny.png',
									'흐림'					=> 'cloudy.png',
									'구름많음'				=> 'haze.png',
									'구름조금'				=> 'cloudy.png',
									'비'					=> 'mist.png',
									'구름많고 비'			=> 'flurries.png',
									'대부분맑음'			=> 'mostly_sunny.png',
									'눈'					=> 'snow.png',
									'폭설'					=> 'snow.png',
									'황사'					=> 'sand.png',
									'모래'					=> 'sand.png',
									'박무'					=> 'mist.png',
									'연무'					=> 'mist.png',
									'구름많고 눈'			=> 'snow.png',
									'구름많고 비 또는 눈'	=> 'snow.png'
	);
	//print_r2($_COOKIE);
	$city_match				= urldecode($_COOKIE['wthr_city' . $happy_weather_count]);
	$city_match				= ( $city_match == '' ) ? '서울' : $city_match;

	preg_match("/<local icon=\"(.*?)\" desc=\"(.*?)\" ta=\"(.*?)\">{$city_match}<\/local>/",$wthr_xml,$matches);
	//print_r2($matches);
	$wt						= $matches[2];
	$weather_icon			= $W_icon[$wt];
	switch( $weather_icon )
	{
		case "-" :
			$weather_icon	= 'sunny.png';
		break;
	}
	$weather_icon			= ( $weather_icon == '' ) ? "mostly_sunny.png" : $weather_icon;
	$matches[2]				= ( $matches[2] == "-" ) ? "맑음" : $matches[2];

	$area_options_tags		= "";
	foreach($happy_weather_areas AS $area_v)
	{
		$area_v_encode		= urlencode($area_v);
		$selected			= ( $area_v == $city_match ) ? "selected" : "";
		$area_options_tags	.= "<option value=\"{$area_v_encode}\" {$selected}>{$area_v}</option>";
	}
	$happy_imgmaker			= "happy_imgmaker.php";
	$unit					= "°C";

	$happy_img_color_c_a	= explode("/",$happy_img_color_c);
	$fcolor_city			= str_replace('|',',',$happy_img_color_c_a[0]);
	$bgcolor_city			= str_replace('|',',',$happy_img_color_c_a[1]);

	$happy_img_color_h_a	= explode("/",$happy_img_color_h);
	$fcolor_heat			= str_replace('|',',',$happy_img_color_h_a[0]);
	$bgcolor_heat			= str_replace('|',',',$happy_img_color_h_a[1]);

	$날씨아이콘				= "<img src=\"{$wthr_img_path}{$weather_icon}\" alt=\"{$matches[2]}\" />";
	$날씨텍스트				= "$matches[2]";
	$지역명					= "$city_match";
	$지역명아이콘			= "<img src=\"{$happy_imgmaker}?fsize={$area_textimg_size}&news_title={$city_match}&fcolor={$fcolor_city}&bgcolor={$bgcolor_city}\" alt=\"{$city_match}\" />";
	$온도					= "{$matches[3]}&nbsp;{$unit}";
	$온도아이콘				= "<img src=\"{$happy_imgmaker}?fsize={$ta_textimg_size}&news_title={$matches[3]}{$unit}&fcolor={$fcolor_heat}&bgcolor={$bgcolor_heat}\" alt=\"{$city_match}\" />";
	$지역변경스크립트		= " onclick=\"happy_weather_area_selectbox_view({$happy_weather_count});\" ";
	$지역선택박스			= "<div id=\"wthr_area_opt__box_{$happy_weather_count}\" style=\"display:none;\"><select size=\"10\" name=\"wthr_area_opt_{$happy_weather_count}\" id=\"wthr_area_opt_{$happy_weather_count}\" class=\"{$area_selectbox_class}\" onchange=\"happy_weather_area_change_start({$happy_weather_count});\">{$area_options_tags}</select></div>";

	$wthr_Content			= $TPL->fetch("날씨_$random");

	if( $is_ajax_weather != "ok" )
	{
		$Content				= "
		<div id=\"happy_weather_layer_{$happy_weather_count}\">{$wthr_Content}</div>";
	}
	else
	{
		$Content				= $wthr_Content;
	}

	$Content				.= "
	<input type=\"hidden\" name=\"happy_weather_template_{$happy_weather_count}\" id=\"happy_weather_template_{$happy_weather_count}\" value=\"{$file_name}\" />
	<input type=\"hidden\" name=\"happy_weather_template_css_{$happy_weather_count}\" id=\"happy_weather_template_css_{$happy_weather_count}\" value=\"{$area_selectbox_class}\" />
	<input type=\"hidden\" name=\"happy_weather_template_count_{$happy_weather_count}\" id=\"happy_weather_template_count_{$happy_weather_count}\" value=\"{$happy_weather_count}\" />
	<input type=\"hidden\" name=\"happy_weather_template_img_c_{$happy_weather_count}\" id=\"happy_weather_template_img_c_{$happy_weather_count}\" value=\"{$happy_img_color_c}\" />
	<input type=\"hidden\" name=\"happy_weather_template_img_h_{$happy_weather_count}\" id=\"happy_weather_template_img_h_{$happy_weather_count}\" value=\"{$happy_img_color_h}\" />";

	$happy_weather_count++;
	return $Content;
}


# 소켓 통신 함수
function weather_fsockopen($url)
{
	$URL_parsed		= @parse_url($url);
	$host			= $URL_parsed["host"];
	$port			= $URL_parsed["port"];

	if( $port == 0 ) { $port = 80; }

	$path			= $URL_parsed["path"];

	if($URL_parsed["query"] != "")
	{
		$path		.= "?".$URL_parsed["query"];
	}

	$fp				= fsockopen($host, $port, $errno, $errstr, 30);

	if( $fp )
	{
		$data		= '';
		fputs($fp, "GET ${url} HTTP/1.0\r\n\r\n");
		//fputs($fp, "Host: ${host}\r\n");
		//fputs($fp, "Connection: close\r\n\r\n");
		while (!feof($fp))
		{
			$data	.= fgets($fp, 128);
		}
		fclose($fp);

		$data		= explode("\r\n\r\n", $data, 2);

		return $data[1];
	}
}



	//취업활동증명서 - 회원정보
	$HMember			= happy_member_information(happy_member_login_check());
	$HMember['jumin']	= substr($HMember['user_birth_year'],2,2);
	if ( $HMember['user_birth_month']<10)
	{
		$HMember['user_birth_month'] = "0".$HMember['user_birth_month'];
	}
	$HMember['jumin']	= $HMember['jumin'].$HMember['user_birth_month'];
	if ( $HMember['user_birth_day']<10)
	{
		$HMember['user_birth_day'] = "0".$HMember['user_birth_day'];
	}
	$HMember['jumin']	= $HMember['jumin'].$HMember['user_birth_day'];
	//취업활동증명서

	if ((!preg_match("/admin/",$SCRIPT_NAME) && !(eregi("com_sms_send", $_SERVER['REQUEST_URI']))) && !preg_match("/tagview\.php/",$SCRIPT_NAME) )
	{
		if ( file_exists("$skin_folder/in_bottom_copyright.html") )
		{
			//jini추가[2011.12.28] - 카피라이터인클루트
			$TPL->define("하단카피라이트내용", "$skin_folder/in_bottom_copyright.html");
			$하단카피라이트 = &$TPL->fetch();
		}

		//따라다니는 배너
		if ( file_exists("$skin_folder/my_view_right_scroll.html") )
		{
			$TPL->define("my_view_right_scroll", "$skin_folder/my_view_right_scroll.html");
			$my_view_right_scroll = &$TPL->fetch();
		}
	}

	$today = date("Ymd");

	$현재위치	= "&nbsp;";
	##################################################
	#메뉴의 해당파일을 선언하여 셀렉트값던져주기

	$menu1_array = array('file=guin','guin_list.php','com_info.php','guin_detail.php');
	$menu2_array = array('file=guzic','guzic_list.php','document_view.php');
	$menu3_array = array('guin_regist.php');
	$menu4_array = array('document.php');
	$menu5_array = array('scrap','my','member_');

	//print $REQUEST_URI  ;

	$return_number = '1';

	if (!$match_word)
	{
		foreach ($menu3_array as $list)
		{
			if (preg_match("/$list/",$REQUEST_URI))
			{
				$match_word = '1';
				$return_number = '3';
				break;
			}
		}
	}

	if (!$match_word)
	{
		foreach ($menu4_array as $list)
		{
			if (preg_match("/$list/",$REQUEST_URI))
			{
				$match_word = '1';
				$return_number = '4';
				break;
			}
		}
	}

	if (!$match_word)
	{
		foreach ($menu1_array as $list)
		{
			if (preg_match("/$list/",$REQUEST_URI))
			{
				$match_word = '1';
				$return_number = '1';
				break;
			}
		}
	}

	if (!$match_word)
	{
		foreach ($menu2_array as $list)
		{
			if (preg_match("/$list/",$REQUEST_URI))
			{
				$match_word = '1';
				$return_number = '2';
				break;
			}
		}
	}

	if (!$match_word)
	{
		foreach ($menu5_array as $list)
		{
			if (preg_match("/$list/",$REQUEST_URI))
			{
				$match_word = '1';
				$return_number = '5';
				break;
			}
		}
	}

	$return_number = $return_number +4;
	##################################################

	if ( $_COOKIE["ad_id"] != "" )
	{
		$master_check	= "1";
		$master_msg		= "[관리자로그인중]";
	}


	$userid = happy_member_login_check();
	$user_id = $userid;
	$member_id = $user_id;
	$회원아이디 = $user_id;


	$COMMEMBER = init_member_variable($user_id);
	//print_r($COMMEMBER);

	$PERMEMBER = $COMMEMBER;


	$PERMEMBER['guzic_total_cnt_comma']	= number_format($PERMEMBER['guzic_total_cnt']);
	$PERMEMBER['use_cnt_comma']			= number_format($PERMEMBER['use_cnt']);
	$PERMEMBER['wait_cnt_comma']		= number_format($PERMEMBER['wait_cnt']);
	$PERMEMBER['req_cnt_comma']			= number_format($PERMEMBER['req_cnt_per']);
	$PERMEMBER['jiwon_cnt_comma']		= number_format($PERMEMBER['jiwon_cnt_per']);
	$PERMEMBER['view_cnt_comma']		= number_format($PERMEMBER['view_cnt']);
	$PERMEMBER['guzic_smspoint_comma']	= number_format($PERMEMBER['guzic_smspoint']);
	$PERMEMBER['online_cnt_comma']	= number_format($PERMEMBER['online_cnt']);
	$PERMEMBER['email_cnt_comma']	= number_format($PERMEMBER['email_cnt']);
	$PERMEMBER['new_cnt_comma']	= number_format($PERMEMBER['new_cnt']);
	$PERMEMBER['want1_cnt_comma']	= number_format($PERMEMBER['want1_cnt']);
	$PERMEMBER['interview_cnt_comma']	= number_format($PERMEMBER['interview_cnt_per']);

	$COMMEMBER['guin_total_cnt_comma']	= number_format($COMMEMBER['guin_total_cnt']);
	$COMMEMBER['ing_cnt_comma']			= number_format($COMMEMBER['ing_cnt']);
	$COMMEMBER['magam_cnt_comma']		= number_format($COMMEMBER['magam_cnt']);
	$COMMEMBER['jiwon_cnt_comma']		= number_format($COMMEMBER['jiwon_cnt']);
	$COMMEMBER['req_cnt_comma']			= number_format($COMMEMBER['req_cnt']);
	$COMMEMBER['scrap_cnt1_comma']		= number_format($COMMEMBER['scrap_cnt1']);
	$COMMEMBER['scrap_cnt2_comma']		= number_format($COMMEMBER['scrap_cnt2']);
	$COMMEMBER['scrap_sum_comma']		= number_format($COMMEMBER['scrap_cnt1'] + $COMMEMBER['scrap_cnt2']); //YOON : 2011-11-28 추가
	$COMMEMBER['docview_period_comma']	= number_format($COMMEMBER['docview_period']);
	$COMMEMBER['docview_count_comma']	= number_format($COMMEMBER['docview_count']);
	$COMMEMBER['smspoint_comma']		= number_format($COMMEMBER['smspoint']);
	$COMMEMBER['interview_cnt_comma']		= number_format($COMMEMBER['interview_cnt']);



	$message_pertb		= $happy_member;
	$message_loginVal	= $user_id;			#사용자ID 값 입력 ex) $_COOKIE[member_id]
	$message_field_id	= 'user_id';		#회원테이블의 ID 필드명 입력
	$message_field_name	= 'user_name';		#회원테이블의 NAME 필드명 입력




	if( $message_loginVal != ""
		&& !eregi( "xml",$_SERVER['PHP_SELF'] )
		&& !eregi( "admin",$_SERVER['PHP_SELF'] )
		&& !eregi( "wys2",$_SERVER['PHP_SELF'] )
		&& !eregi( "pg_module",$_SERVER['PHP_SELF'] )
	)
	{
		message_loading();
	}


	#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
	$searchMethod2	.= "&file=".urlencode($_GET['file']);
	$searchMethod2	.= "&file2=".urlencode($_GET['file2']);
	$searchMethod2	.= "&category=".urlencode($nowCategory);
	$searchMethod2	.= "&sort=".urlencode($_GET['sort']);
	$searchMethod2	.= "&search_word=".urlencode($_GET["search_word"]);
	$searchMethod2	.= "&get_si=".urlencode($_GET['get_si']);
	$searchMethod2	.= "&guzic_money=".urlencode($_GET['guzic_money']);
	$searchMethod2	.= "&guzic_school=".urlencode($_GET['guzic_school']);
	$searchMethod2	.= "&guzic_level=".urlencode($_GET['guzic_level']);
	$searchMethod2	.= "&guzic_keyword=".urlencode($_GET['guzic_keyword']);
	$searchMethod2	.= "&guzic_si=".urlencode($_GET['guzic_si']);
	$searchMethod2	.= "&guzic_gu=".urlencode($_GET['guzic_gu']);
	$searchMethod2	.= "&guzic_jobtype1=".urlencode($_GET['guzic_jobtype1']);
	$searchMethod2	.= "&guzic_jobtype2=".urlencode($_GET['guzic_jobtype2']);
	$searchMethod2	.= "&guzic_word=".urlencode($_GET['guzic_word']);
	$searchMethod2	.= "&guzic_ppt=".urlencode($_GET['guzic_ppt']);
	$searchMethod2	.= "&guzic_excel=".urlencode($_GET['guzic_excel']);
	$searchMethod2	.= "&guzic_internet=".urlencode($_GET['guzic_internet']);
	$searchMethod2	.= "&guzic_prefix=".urlencode($_GET['guzic_prefix']);
	$searchMethod2	.= "&my=".urlencode($_GET['my']);
	$searchMethod2	.= "&guzic_school_type=".urlencode($_GET['guzic_school_type']);
	$searchMethod2	.= "&guzic_age=".urlencode($_GET['guzic_age']);
	$searchMethod2	.= "&guzic_age_end=".urlencode($_GET['guzic_age_end']);
	$searchMethod2	.= "&guzic_age_start=".urlencode($_GET['guzic_age_start']);

	$searchMethod2	.= "&mode=".urlencode($_GET['mode']);
	$searchMethod2	.= "&job_type_read=".urlencode($_GET['job_type_read']);
	$searchMethod2	.= "&guziceducation=".urlencode($_GET['guziceducation']);
	$searchMethod2	.= "&career_read_start=".urlencode($_GET['career_read_start']);
	$searchMethod2	.= "&career_read_end=".urlencode($_GET['career_read_end']);
	$searchMethod2	.= "&grade_money_type=".urlencode($_GET['grade_money_type']);
	$searchMethod2	.= "&grade_money_type=".urlencode($_GET['grade_money_type']);
	$searchMethod2	.= "&guzicnational=".urlencode($_GET['guzicnational']);
	$searchMethod2	.= "&diff_regday=".urlencode($_GET['diff_regday']);

	//추가검색
	$searchMethod2	.= "&grade_schoolName=".urlencode($_GET['grade_schoolName']);	//학교
	$searchMethod2	.= "&grade_schoolType=".urlencode($_GET['grade_schoolType']);	//전공
	$searchMethod2	.= "&HopeSize=".urlencode($_GET['HopeSize']);

	#검색값 입력완료
	$searchMethod	= $searchMethod2 . "&number=".urlencode($_GET['number']);
	#검색되도록


	if ( !(eregi("admin", $_SERVER['PHP_SELF'])) && !(eregi("wys2", $_SERVER['PHP_SELF'])) && !(eregi("banktown", $_SERVER['PHP_SELF'])) && !(eregi("xml", $_SERVER['PHP_SELF'])) && !(eregi("pg_module", $_SERVER['PHP_SELF']))  )
	{
		# 성인인증체크 # 2009/10/12 # kwak16
		# !(eregi("login", $_SERVER['REQUEST_URI']))
		if ( $_COOKIE["ad_id"] == ""
			&& $CONF['kcb_adultcheck_use'] == '1'
			&& strpos($_SERVER['REQUEST_URI'], 'happy_member_login.php?mode=login_reg') === false
			&& !(eregi("adultcheck", $_SERVER['REQUEST_URI']))
			&& !(eregi("join", $_SERVER['REQUEST_URI']))
			&& !(eregi("regist", $_SERVER['REQUEST_URI']))
			&& !(eregi("lostpass", $_SERVER['REQUEST_URI']))
			&& !(eregi("lostid", $_SERVER['REQUEST_URI']))
			&& !(eregi("happy_zipcode", $_SERVER['REQUEST_URI']))
			&& !(eregi("happy_member_check_email", $_SERVER['REQUEST_URI']))
			&& !(eregi("happy_member_iso_email", $_SERVER['REQUEST_URI']))
			&& !(eregi("happy_member_check_phone", $_SERVER['REQUEST_URI']))
			&& !(eregi("pg_module", $_SERVER['REQUEST_URI']))
			&& !(eregi("com_sms_send.php", $_SERVER['REQUEST_URI'])) )
		{
			if ( happy_member_login_check() == "" && $_COOKIE['job_adultcheck'] == '' )
			{
				go("html_file.php?file=adultcheck.html&file2=login_default.html&returnUrl=$_SERVER[HTTP_REFERER]");
				exit;
			}
		}

		//회원통합관련 함수 정리됨
		adultjob_login();


		$투표			= vote_read();
		$아이콘			= call_icon_list();
		$추천키워드		= pick_list(trim($CONF["pick_keyword"]), $CONF["pick_keyword_setting"], $CONF["pick_keyword_size"]);

		#숫자간단통계
		now_stats();
		#홈페이지 카운트 호출
		input_stats();
		#심플검색부분,확장검색부분,검색부분
		search_form();
		#이력서,채용정보 검색부분
		guzic_search_form();


		$fileName	= "";
		if ( happy_member_secure($happy_member_secure_text[0].'등록') && happy_member_secure($happy_member_secure_text[1].'등록') )
		{
			//구직정보등록권한 + 구인정보등록권한 둘다 있으면
			$fileName = "_all";
		}
		else if ( happy_member_secure($happy_member_secure_text[0].'등록') )
		{
			//구직정보등록권한
			$fileName = "_per";
		}
		else if ( happy_member_secure($happy_member_secure_text[1].'등록') )
		{
			//구인정보등록권한
			$fileName = "_com";
		}

		$TPL->define("좌측메뉴", "./$skin_folder/leftmenu${fileName}.html");
		$TPL->assign("좌측메뉴");

		$좌측메뉴 = &$TPL->fetch();

		//echo $좌측메뉴;

	}



	#시이름, 구이름 변수에 담아두기
	$Sql	= "SELECT * FROM $si_tb ";
	$Record	= query($Sql);
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$siSelect[$Data["number"]]	= $Data["si"];
		$siNumber[$Data["si"]]		= $Data["number"];
	}

	$Sql	= "SELECT * FROM $gu_tb ";
	$Record	= query($Sql);
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$guSelect[$Data["number"]]	= $Data["gu"];
		$guNumber[$Data["gu"]]		= $Data["number"];
	}

	#역세권 지하철명 변수에 담아두기
	$Sql	= "SELECT number,title FROM $job_underground_tb ";
	$Record	= query($Sql);
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$undergroundTitle[$Data['number']]	= $Data['title'];
		$undergroundNumber[$Data['title']]	= $Data['number'];
	}



	if ( happy_member_login_check() != "" )
	{
		$Sql	= "SELECT COUNT(*) FROM $com_want_doc_tb WHERE per_id='$user_id' AND alert_ok='N' ";
		$Data	= happy_mysql_fetch_array(query($Sql));

		$Sql	= "UPDATE $com_want_doc_tb SET alert_ok='Y' WHERE per_id='$user_id' AND alert_ok='N' ";
		query($Sql);

		if ( $Data[0] != 0 )
		{
			$HAPPY_CONFIG['MsgRequestJoin'] = str_replace("\r\n","\\n",$HAPPY_CONFIG['MsgRequestJoin']);
			$HAPPY_CONFIG['MsgRequestJoin'] = str_replace("{{요청건수}}",$Data[0],$HAPPY_CONFIG['MsgRequestJoin']);

			echo "
				<script>
					if ( confirm('".$HAPPY_CONFIG['MsgRequestJoin']."'))
					{
						window.location.href = 'per_guin_want.php';
					}
				</script>
			";
		}
	}


	#일반회원결제활성
	$일반회원유료결제버튼 = '<a href="member_option_pay3.php"><img src="img/btn_mypage_perpay.gif" border="0" align="absmiddle" alt="유료결제"></a>';
	$열람가능한구인스타일 = '';
	if ( $CONF['paid_conf'] == "0" || ( $CONF['guzic_view'] == "" && $CONF['guzic_view2'] == "" ) )
	{
		$일반회원유료결제버튼 = '';
		$열람가능한구인스타일 = ' style="display:none;" ';
	}
	#일반회원결제활성



function call_icon_list()
{
	global $happy_icon_list;

	$Sql	= "SELECT * FROM $happy_icon_list ";
	$Record	= query($Sql);

	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$ICONS[$Data['icon_name']]	= "<img src='$Data[icon_jpg_file]' width='$Data[icon_width]' height='$Data[icon_height]' border='$Data[icon_border]' align='$Data[icon_align]' alt='$Data[icon_name]' $Data[icon_option] >";
	}

	return $ICONS;
}




function print_make($ALL)
{

	#$pattern		= "/%게시판보기-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-게시판보기%/e";
	#$replacement	= "board_extraction_list('$1','$2','$3','$4','$5','$s6');";
	#$ALL			= preg_replace ($pattern, $replacement, $ALL);
	#$pattern		= "/%구인추출-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-구인추출%/e";
	#$replacement	= "guin_main_extraction('$1','$2','$3','$4','$5','$6','$7','$8','$9','$10');";
	#$ALL			= preg_replace ($pattern, $replacement, $ALL);
	#$pattern		= "/%구인리스트-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-(.*)-구인리스트%/e";
	#$replacement	= "guin_extraction('$1','$2','$3','$4','$5','$6','$7','$8','$9','$10');";
	#$ALL			= preg_replace ($pattern, $replacement, $ALL);
	print $ALL;
}


function make_guin_selectbox($array,$mod,$var_name,$type_name)
{
	#자동선택은 필요없음.
	$array_co = count($array);
	if ($type_name == "기간별")
	{
		$type_print = "일간";
	}
	elseif ($type_name == "노출별")
	{
		$type_print = "회 노출시";
	}
	elseif ($type_name == "클릭별")
	{
		$type_print = "회 클릭시";
	}
	//추가된것
	elseif ($type_name == "프로필보기기간")
	{
		$type_name = "프로필 보기";
		$type_print = "일간";
	}
	elseif ($type_name == "프로필보기회")
	{
		$type_name = "프로필 보기";
		$type_print = "회";
	}
	elseif ($type_name == "SMS발송")
	{
		$type_print = "회";
	}
	//추가된것
	else
	{
		$type_print = "";
	}

	$main_area = "<select name=$var_name onChange=\"figure(document.payform)\"><option value=''>$mod</option>";

	for ( $i=0; $i<$array_co; $i++ )
	{
		list($day,$money) = split(":",$array[$i]);
		$money = number_format($money);
		$main_area .= "<option value='$array[$i]'>$type_name  $day$type_print $money"."원</option>";
	}

	$main_area .= "</select>";
	return $main_area;
}


function make_guin_checkbox($array,$mod,$var_name,$type_name)
{
	#자동선택은 필요없음.
	$array_co = count($array);
	if ($type_name == "기간별")
	{
		$type_print = "일간";
	}
	elseif ($type_name == "노출별")
	{
		$type_print = "회 노출시";
	}
	elseif ($type_name == "클릭별")
	{
		$type_print = "회 클릭시";
	}
	//추가된것
	elseif ($type_name == "프로필보기기간")
	{
		$type_name = "프로필 보기";
		$type_print = "일간";
	}
	elseif ($type_name == "프로필보기회")
	{
		$type_name = "프로필 보기";
		$type_print = "회";
	}
	elseif ($type_name == "SMS발송")
	{
		$type_print = "회";
	}
	elseif ($type_name == "이력서보기기간")
	{
		$type_name = "이력서 보기";
		$type_print = "일간";
	}
	elseif ($type_name == "이력서보기회")
	{
		$type_name = "이력서 보기";
		$type_print = "회";
	}
	//추가된것
	else
	{
		$type_print = "";
	}

	//$main_area = "<select name=$var_name onChange=\"figure(document.payform)\"><option value=''>$mod</option>";
	for ( $i=0; $i<$array_co; $i++ )
	{
		list($day,$money) = split(":",$array[$i]);
		$money = number_format($money);
		//$main_area .= "<option value='$array[$i]'>$type_name  $day$type_print $money"."원</option>";
		$main_area .= "<input type='checkbox' name=$var_name value='$array[$i]' onclick=\"SingleCheckBox(this);\" style='cursor:pointer'>$type_name  $day$type_print $money"."원<br>";
	}
	//$main_area .= "</select>";
	return $main_area;
}

function make_guin_checkbox_pay($array,$mod,$var_name,$type_name)
{
	#자동선택은 필요없음.
	$array_co = count($array);
	if ($type_name == "기간별")
	{
		//$type_print = "일";
	}
	elseif ($type_name == "노출별")
	{
		$type_print = "회";
	}
	elseif ($type_name == "클릭별")
	{
		$type_print = "회";
	}
	//추가된것
	elseif ($type_name == "프로필보기기간")
	{
		$type_name = "프로필 보기";
		$type_print = "일";
	}
	elseif ($type_name == "프로필보기회")
	{
		$type_name = "프로필 보기";
		$type_print = "회";
	}
	elseif ($type_name == "SMS발송")
	{
		$type_name = "건수별";
		$type_print = "회";
	}
	elseif ($type_name == "이력서보기기간")
	{
		$type_name = "이력서 보기";
		$type_print = "일";
	}
	elseif ($type_name == "이력서보기회")
	{
		$type_name = "이력서 보기";
		$type_print = "회";
	}
	elseif ($type_name == "구인정보보기기간")
	{
		$type_name = "기간별";
		$type_print = "일";
	}
	elseif ($type_name == "구인정보보기회")
	{
		$type_name = "회수별";
		$type_print = "회";
	}
	//추가된것
	else
	{
		$type_print = "";
	}

	$main_area = "<table border='0' cellpadding='0' cellspacing='0' style='width:100%; border-collapse: collapse; table-layout:fixed;'>";

	for ( $i=0; $i<$array_co; $i++ )
	{
		list($day,$money) = split(":",$array[$i]);
		$money = number_format($money);

		if( $_COOKIE['happy_mobile'] == 'on' )
		{
			$main_area .= "
			<tr>
				<td style=' height:40px;' class='pay_line_th'>
					$type_name (<strong style='color:#000; letter-spacing:0'>$day$type_print</strong>)
				</td>
				<td style='height:40px; text-align:right' class='pay_line_td'>
					<span style='color:#fc8476; margin-right:10px'>$money 원</span>"."
				</td>
				<td style='text-align:center;'>
					<span class='h_form'><label class='h-check'><input type='checkbox' name=$var_name value='$array[$i]' onclick=\"SingleCheckBox(this);\" style='cursor:pointer'><span style='font-weight:500; color:#000;'>신청하기</span></label></span>
				</td>
			</tr>";
		}
		else
		{
			$main_area .= "
			<tr>
				<td style='min-width:94px; height:40px; text-align:center; border:1px solid #c5c5c5; border-left:none; border-top:none;' class='pay_line noto400 font_15'>
					$type_name
				</td>
				<td style='min-width:95px; height:40px;padding-right:10px; box-sizing:border-box; text-align:right; border:1px solid #c5c5c5;border-top:none;' class='pay_line noto400 font_15'>
					<strong class='font_tahoma'>$day</strong> $type_print
				</td>
				<td style='min-width:95px; height:40px; padding-right:10px; box-sizing:border-box; text-align:right; border:1px solid #c5c5c5;border-top:none;' class='pay_line noto400 font_15'>
					<span class='font_tahoma' style='color:#fc8476;'>$money</span>"." 원
				</td>
				<td align='center' class='h_form' style='width:60px; height:40px; border:1px solid #c5c5c5; box-sizing:border-box; border-right:none;border-top:none;'>
					<label class='h-check'><input type='checkbox' name=$var_name value='$array[$i]' onclick=\"SingleCheckBox(this);\" style='cursor:pointer'><span style='margin-right:-5px;'></span></label>
				</td>
			</tr>";
		}
	}

	$main_area .= "</table>";
	return $main_area;
}


function make_guin_radiobox($array,$mod,$var_name,$type_name)
{
	$array_co = count($array);
	if ($type_name == "기간별")
	{
		$type_print = "일간";
	}
	elseif ($type_name == "노출별")
	{
		$type_print = "회 노출시";
	}
	elseif ($type_name == "클릭별")
	{
		$type_print = "회 클릭시";
	}
	else
	{
		$type_print = "";
	}

	$i	= 0;
	$main_area = "<table cellspacing='0' cellpadding='0' border='0' width=100% border=0><tr>";
	if(@($i%$mod)==0 && $i!=0 )
	{
		$main_area .= "</tr><tr>";
	}
	$main_area .= "<td style='padding-left:25px; border-top:1px solid #c5c5c5; height:45px; text-align:left' class='guzic_pay h_form'>
							<label for='{$var_name}_adnope' class='h-radio'><input type=radio id='{$var_name}_adnope' name='$var_name' value='0:0' onClick=\"figure(document.payform)\" checked><span class='noto400 font_14'>광고하지않음</span></label>
						</td>";

	for ( $i=1; $i<=$array_co; $i++ )
	{
		list($day,$money) = split(":",$array[$i-1]);
		$money = number_format($money);

		if(@($i%$mod)==0 && $i!=0 )
		{
			$main_area .= "</tr><tr>";
		}
		$main_area .= "<td style='padding-left:25px; border-top:1px solid #c5c5c5;  height:45px; text-align:left' class='guzic_pay h_form'><label class='h-radio' for='". $array[$i-1] ."' ><input type=radio id='". $array[$i-1] ."' name='$var_name' value='". $array[$i-1] ."' onClick=\"figure(document.payform)\"><span class='noto400 font_14'>$type_name 광고 $day$type_print $money"."원</span></label></td>";
	}
	$main_area .= "</table>";

	return $main_area;
}

function make_si_selectbox($or_name,$next,$sel1,$sel2,$size1,$size2,$form_name,$use_gu = "")
{
	global $SI,$SI_ARRAY,$c_j_j_selected,$gu_tb;
	global $HAPPY_CONFIG;
	$next_form_con = $next . $form_name;

	foreach ($SI_ARRAY as $list)
	{
		$tmp_select	= ( $sel1 == $list )?"selected style='background-color:#E5EDFF' ":"";
		$si_option .="<option value='$list' $tmp_select>$SI[$list]</option>	";
	}

	if ($size1)
	{
		if ( $_COOKIE['happy_mobile'] == "on" && $size1 == "100%" )
		{
			$size1_width = "width:100%";
		}
		else
		{
			$size1_width = "width:{$size1}px;";
		}
	}
	if ($size2)
	{
		if ( $_COOKIE['happy_mobile'] == "on" && $size2 == "100%" )
		{
			$size2_width = "width:100%";
		}
		else
		{
			$size2_width = "width:{$size2}px;";
		}
	}

	/*
	if ($form_name == 'regiform')
	{
		$must_fill = "hname='지역선택' required";
	}
	*/

	$r_o_select = "
		<select name='$or_name' onChange=\"startRequest(this,'$next','$size2')\" style='$size1_width'>
			<option value=''>".$HAPPY_CONFIG['SelectAreaSiTitle1']."</option>
			$si_option
		</select>
		<SPAN id='$next_form_con'></SPAN>
	";

	if ( $use_gu == "시만출력" )
	{
		//시 셀렉트박스만 나오게 하자
	}
	else
	{
		if ($sel1 )
		{
			$sql = "select * from $gu_tb where si='$sel1' order by gu asc ";
			$result = query($sql);
			$tmp_div = "<select name='$next' style='$size2_width '><option value=''>".$HAPPY_CONFIG['SelectAreaGuTitle1']."</option>";

			while ($TMP = happy_mysql_fetch_array($result))
			{
				$tmp_select	= ( $TMP["number"] == $sel2 )?"selected style='background-color:#E5EDFF' ":"";
				$tmp_div	.= "<option value='$TMP[number]' $tmp_select>$TMP[gu]</option>	";
			}
			$tmp_div	.= "</select> ";
		}
		else
		{
			$tmp_div = "<select name='$next' style='$size2_width '><option value=''>".$HAPPY_CONFIG['SelectAreaGuTitle1']."</option></select> ";
		}
	}

	$r_o_select .= "
		<script>
		var tmp_div = \"$tmp_div\";
		//eval('$next_form_con.innerHTML=tmp_div');
		//eval('document.getElementById(\'$next_form_con\').innerHTML=tmp_div');
		document.getElementById('$next_form_con').innerHTML=tmp_div;
		</script>
	";

	return $r_o_select;
}


function make_type_selectbox($or_name,$next,$sel1,$sel2,$size1,$size2,$form_name)
{
	global $TYPE,$TYPE_ARRAY,$c_j_j_selected,$type_tb,$type_sub_tb;
	global $HAPPY_CONFIG, ${"type_job_".$or_name};

	$next_form_con = $next . $form_name;

	foreach ($TYPE_ARRAY as $list)
	{
		$tmp_select	= ( $sel1 == $list )?"selected style='background-color:#E5EDFF' ":"";
		$si_option .="<option value='$list' $tmp_select>$TYPE[$list]</option>";
	}

	if ($size1)
	{
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$size1_width = "width:100%;";
		}
		else
		{
			$size1_width = "width:${size1}px;";
		}
	}
	if ($size2)
	{
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$size2_width = "width:100%;";
		}
		else
		{
			$size2_width = "width:${size2}px;";
		}
	}


	$returnGlobalSelect = array();

	$r_o_select1 = "
		<select name='$or_name' onChange=\"startRequest2(this,'$next','$size2')\" style='$size1_width'>
		<option value=''>".$HAPPY_CONFIG['SelectTypeTitle1']."</option>
		$si_option
		</select>
	";

	array_push( $returnGlobalSelect, $r_o_select1);
	$r_o_select		= $r_o_select1;



	if ($sel1 )
	{
		$sql		= "select * from $type_sub_tb where type='$sel1' ORDER BY sort_number ASC, number ASC";
		$result		= query($sql);
		$tmp_div	= "<select name='$next' style='$size2_width'><option value=''>".$HAPPY_CONFIG['SelectSubTypeTitle1']."</option>";

		while ($TMP	= happy_mysql_fetch_array($result))
		{
			$tmp_select	= ( $TMP["number"] == $sel2 )?"selected style='background-color:#E5EDFF' ":"";
			$tmp_div	.= "<option value='$TMP[number]' $tmp_select>$TMP[type_sub]</option>";
		}
		$tmp_div	.="</select>";
	}
	else
	{
		$tmp_div	= "<select name='$next' style='$size2_width'><option value=''>".$HAPPY_CONFIG['SelectSubTypeTitle1']."</option></select>";
	}

	$r_o_select2	= "
		<SPAN id='$next_form_con'></SPAN>
		<script>
		var tmp_div = \"$tmp_div\";
		eval('$next_form_con.innerHTML=tmp_div');
		</script>
	";

	array_push( $returnGlobalSelect, $r_o_select2);
	$r_o_select		.= $r_o_select2;

	${"type_job_".$or_name}		= $returnGlobalSelect;

	return $r_o_select;
}



function make_selectbox($array,$mod,$var_name,$select_name)
{
	$array_co = count($array);
	$main_area = "<select name=$var_name><option value=''>$mod</option>";

	for ( $i=0; $i<$array_co; $i++ )
	{
		if ($select_name == $array[$i])
		{
			$main_area .= "<option value='$array[$i]' selected style='background-color:#E5EDFF'>$array[$i]</option>";
		}
		else
		{
			$main_area .= "<option value='$array[$i]'>$array[$i]</option>";
		}
	}
	$main_area .= "</select>";
	return $main_area;
}

function make_selectbox2($array_name,$array_value,$mod,$var_name,$select_name,$select_width=""){
	$array_co = count($array_name);
	$main_area = "<select name=$var_name id=$var_name style=\"width:$select_width;\">";
	if ($mod)
	{
		$main_area .= "<option value=''>$mod</option>";
	}

	for ( $i=0; $i<$array_co; $i++ )
	{
		if ($array_name[$i])
		{
			if ($select_name == $array_value[$i])
			{
				$main_area .= "<option value='$array_value[$i]' selected style='background-color:#E5EDFF'>$array_name[$i]</option>";
			}
			else
			{
				$main_area .= "<option value='$array_value[$i]'>$array_name[$i]</option>";
			}
		}

	}
	$main_area .= "</select>";
	return $main_area;
}



function make_checkbox($array,$mod,$var_name,$id_name,$select_name)
{
	$array_co = count($array);
	$main_area = "<table cellspacing='0' cellpadding='0' border='0' width=100% style='table-layout:fixed;'><tr>";

	for ( $i=0; $i<$array_co; $i++ )
	{
		if($i%$mod==0 && $i!=0 )
		{
			$main_area .= "</tr><tr>";
		}
		#패턴으로 매칭이 안되는 상황이 많이 발생함
		#if (preg_match("/$array[$i]/",$select_name)) {
		if ( strpos($select_name,$array[$i]) !== false )
		{
			//$main_area .= "<td style='width:20px; padding-bottom:2px;'><input type=checkbox id=$id_name  name='$var_name" ."[$i]' value=on checked style='cursor:pointer'></td><td class='font_12'>$array[$i]</td>";
			$main_area .= "<td class='h_form' style='padding:10px 5px;'><label class='h-check'><input type=checkbox id=$id_name  name='$var_name" ."[$i]' value=on checked style='cursor:pointer'><span class='noto400 font_13'>$array[$i]</span></label></td>";
		}
		else
		{
			//$main_area .= "<td style='width:20px; padding-bottom:2px;'><input type=checkbox id=$id_name  name='$var_name" ."[$i]' value=on style='cursor:pointer'></td><td class='font_12'>$array[$i]</td>";
			$main_area .= "<td class='h_form' style='padding:10px 5px;'><label class='h-check'><input type=checkbox id=$id_name  name='$var_name" ."[$i]' value=on style='cursor:pointer'><span class='noto400 font_13'>$array[$i]</span></label></td>";
		}
	}
	$main_area .= "</table>";

	return $main_area;
}


function make_checkbox2($array,$array_val,$mod,$var_name,$id_name,$select_name,$search_add="")
{
	$array_co = count($array);
	$main_area = "<table cellspacing='0' cellpadding='0' border='0' width=100%; style='table-layout:fixed;'><tr>";

	for ( $i=0; $i<$array_co; $i++ )
	{
		$id_name2 = $id_name."_".$i;

		if($i%$mod==0 && $i!=0 )
		{
			$main_area .= "</tr><tr>";
		}

		if ($select_name != '' && strpos(" ".$select_name,trim($array[$i]).$search_add))
		{
			$main_area .= "<td style='width:25px; padding:5px;' class='h_form'><label for='$id_name2' class='h-check'><input type=checkbox id=$id_name2  name='${id_name}[]' value='$array[$i]' checked><span></span></label></td><td class='days' style='vertical-align:middle;'> <label for='$id_name2' class='noto400 font_14' style='cursor:pointer;' >$array_val[$i]</label></td>";
		}
		else
		{
			$main_area .= "<td style='width:25px; padding:5px; min-height:22px' class='h_form'><label for='$id_name2' class='h-check'><input type=checkbox id=$id_name2  name='${id_name}[]' value='$array[$i]'><span></span></label></td><td class='days' style='vertical-align:middle;'> <label for='$id_name2' class='noto400 font_14' style='cursor:pointer;'>$array_val[$i]</label></td>";
		}
	}
	$main_area .= "</table>";

	return $main_area;
}

function make_radiobox($array,$mod,$var_name,$id_name,$select_name)
{
	$array_co = count($array);
	$main_area = "<table cellspacing='0' cellpadding='0' border='0' width=100% border=0><tr>";

	for ( $i=0; $i<$array_co; $i++ )
	{
		$id_name2 = $id_name."_".$i;

		if($i%$mod==0 && $i!=0 )
		{
			$main_area .= "</tr><tr>";
		}

		if ( strpos($select_name , $array[$i]) !== false)
		{
			$main_area .= "<td class='h_form' style='height:30px;'><label class='h-radio' for='$id_name2'><input type=radio id=$id_name2  name='$var_name' value='$array[$i]' checked><span  class='noto400 font_14'>$array[$i]</span></label></td>";
		}
		else
		{
			$main_area .= "<td class='h_form' style='height:30px;'><label class='h-radio' for='$id_name2'><input type=radio id=$id_name2  name='$var_name' value='$array[$i]'><span  class='noto400 font_14'>$array[$i]</span></label></td>";
		}
	}
	$main_area .= "</table>";

	return $main_area;
}


function make_radiobox2($array,$array2,$mod,$var_name,$id_name,$select_name,$selectbox_tb_width = '')
{
	if ($selectbox_tb_width)
	{
		$selectbox_tb_width_info = "width=$selectbox_tb_width";
	}
	$array_co = count($array);
	$main_area = "<table cellspacing='0' cellpadding='0' border='0' $selectbox_tb_width_info border=0><tr>";

	for ( $i=0; $i<$array_co; $i++ )
	{
		$array2[$i]	= ( $array2[$i] == "[none]" )?"":$array2[$i];
		$id_name2 = $id_name."_".$i;

		if($i%$mod==0 && $i!=0 )
		{
			$main_area .= "</tr><tr>";
		}

		if ( $array2[$i] == $select_name )
		{
			$main_area .= "<td class='h_form'><label class='h-radio' for='$id_name2'><input type=radio id='$id_name2'  name='$var_name' value='$array2[$i]' checked> <span class='noto400 font_14'>$array[$i]</span></label></td>";
		}
		else
		{
			$main_area .= "<td class='h_form'><label class='h-radio' for='$id_name2'><input type=radio id='$id_name2'  name='$var_name' value='$array2[$i]'> <span class='noto400 font_14'>$array[$i]</span></label></td>";
		}
	}
	$main_area .= "</table>";

	return $main_area;
}


function now_stats()
{

	global $per_document_tb,$guin_tb,$오늘채용,$전체채용,$이번달채용,$오늘인재,$전체인재;
	$today	= date("Y-m-d");
	$today2	= date("Y-m-");

	//구인정보 필수결제 옵션적용
	global $ARRAY,$CONF,$real_gap;
	$guin_sql1 = "";
	$guin_sql2 = "";
	if ( is_array($ARRAY) && $CONF['paid_conf'] == 1 )
	{
		foreach($ARRAY as $k => $v )
		{
			$wait_query2 = "";
			$wait_query3 = "";
			$n_name = $v."_necessary";
			$o_name = $v."_option";

			if( $CONF[$n_name] == "필수결제" )
			{
				if ($CONF[$o_name] == '기간별')
				{
					$wait_query2 = $ARRAY[$k]." > ".$real_gap;
					$wait_query3 = "A.".$ARRAY[$k]." > ".$real_gap;
				}
				else
				{
					$wait_query2 = $ARRAY[$k]." > 0 ";
					$wait_query3 = "A.".$ARRAY[$k]." > 0 ";
				}
				$guin_sql1.= " AND $wait_query2 ";
				$guin_sql2 = " AND $wait_query3 ";
			}
		}
	}
	//print_r($guin_sql1);

	//구직정보 필수결제 옵션적용
	global $PER_ARRAY_DB,$PER_ARRAY;
	$guzic_sql1 = "";
	if ( is_array($PER_ARRAY_DB) && $CONF['paid_conf'] == 1 )
	{
		foreach($PER_ARRAY_DB as $k => $v )
		{
			$wait_query2 = "";
			$n_name = $v."_necessary";
			$o_name = $v."_option";

			if( $CONF[$n_name] == "필수결제" )
			{
				$wait_query2 = " AND ".$PER_ARRAY[$k]." >= curdate() ";
				$guzic_sql1 .= $wait_query2;
			}
		}
	}
	//print_r($guzic_sql1);



	//전체 채용
	$sql2 = "select count(*) from $guin_tb where (guin_end_date >= '$today' or guin_choongwon = '1') $guin_sql1 ";
	$result2 = query($sql2);
	list ( $전체채용 ) = mysql_fetch_row($result2);

	//오늘 채용
	$sql3 = "select count(*) from $guin_tb where guin_date between '$today 00:00:00' AND '$today 23:59:59' $guin_sql1 ";
	$result3 = query($sql3);
	list ( $오늘채용 ) = mysql_fetch_row($result3);

	//이번달 채용
	$today3 = date("Y-m-01 00:00:00");
	$today4 = date("Y-m-31 23:59:59");
	$sql3 = "select count(*) from $guin_tb where guin_date between '$today3' AND '$today4' $guin_sql1 ";
	$result3 = query($sql3);
	list ( $이번달채용 ) = mysql_fetch_row($result3);

	//전체 인재
	$sql4 = "select count(*) from $per_document_tb where display = 'y' $guzic_sql1 ";
	$result4 = query($sql4);
	list ( $전체인재 ) = mysql_fetch_row($result4);

	//오늘 인재
	$sql5 = "select count(*) from $per_document_tb where regdate like '$today%' and display = 'y' $guzic_sql1 ";
	$result5 = query($sql5);
	list ( $오늘인재 ) = mysql_fetch_row($result5);

	//신입사원 - hong
	global $신입사원채용;
	$sql = "select count(*) from $guin_tb where (guin_career = '신입' or guin_career = '무관') and (guin_end_date >= '$today' or guin_choongwon ='1') $guin_sql1 ";
	list ( $신입사원채용 ) = mysql_fetch_row(query($sql));

	//헤드헌팅 - hong
	global $헤드헌팅채용;
	$sql = "select count(*) from $guin_tb where company_number != '0' and (guin_end_date >= '$today' or guin_choongwon ='1') $guin_sql1 ";
	list ( $헤드헌팅채용 ) = mysql_fetch_row(query($sql));

	//지역별 채용정보 - hong
	global $si_tb, $SI_NUMBER, $SI_COUNT, $지역별카운트;

	$SI_COUNT = Array();

	foreach ( $SI_NUMBER as $si_name => $si_number )
	{
		$SI_COUNT[$si_name] = 0;
	}

	$sql = "select si1, si2, si3 from $guin_tb where guin_end_date >= '$today' or guin_choongwon ='1' $guin_sql1 ";
	$result = query($sql);

	while ( $Tmp = happy_mysql_fetch_assoc($result) )
	{
		foreach ( $SI_NUMBER as $si_name => $si_number )
		{
			if ( $Tmp['si1'] == $SI_NUMBER['전국'] || $Tmp['si2'] == $SI_NUMBER['전국'] || $Tmp['si3'] == $SI_NUMBER['전국'] )
			{
				$SI_COUNT[$si_name]++;
			}

			if ( $Tmp['si1'] == $si_number || $Tmp['si2'] == $si_number || $Tmp['si3'] == $si_number )
			{
				$SI_COUNT[$si_name]++;
			}
		}
	}

	$지역별카운트 = $SI_COUNT;

	//채용정보 스크랩수 - hong
	global $scrap_tb, $user_id, $채용정보스크랩수;

	$채용정보스크랩수 = 0;

	if ( $user_id != "" )
	{
		$sql01 = "SELECT count(*) FROM $guin_tb AS A INNER JOIN $scrap_tb AS B ON A.number = B.cNumber WHERE ( A.guin_end_date >= '$today' OR A.guin_choongwon = '1' ) AND B.userid = '$user_id' $guin_sql2 ";
		list($채용정보스크랩수) = mysql_fetch_row(query($sql01));
	}

	//오늘 본 채용정보수 - hong
	global $오늘본채용정보수;

	$arr				= explode(",",$_COOKIE["HappyTodayGuin"]);
	$cookieVal			= '';
	for ( $i = 0, $Count = 0 ; $i < count($arr) ; $i++ )
	{
		$tmp		= explode("_",$arr[$i]);

		if ( $tmp[0] != "" )
		{
			$cookieVal	.= ( $Count == 0 )?"":",";
			$cookieVal	.= $tmp[0];
			$Count++;
		}
	}

	$where_query		= ( $cookieVal != "" ) ? " number in ($cookieVal) " : "  number = '0' ";

	$sql = "select count(*) from $guin_tb where $where_query and (guin_end_date >= '$today' or guin_choongwon = '1') $guin_sql1 ";
	list($오늘본채용정보수) = happy_mysql_fetch_array(query($sql));
}




# {{페이징노출옵션 번호양쪽5개노출,구간이동버튼제외,이전다음버튼제외,버튼명칭(<<),버튼명칭(이전),버튼명칭(다음),버튼명칭(>>)}}
# {{페이징노출옵션 번호양쪽5개노출,구간이동버튼제외,이전다음버튼제외,<<</이전페이지/다음페이지/>>>}}
# 각 옵션 자동으로 지정시 기본값(프로그램에서 설정된값)
# 버튼명칭은 << 이전 다음 >> 순서대로 슬러시 기준
$PagingOption		= Array();
function newPaging_option($pageScale='', $paging_btn1='', $paging_btn2='',$paging_button_title1='',$paging_button_title2='',$paging_button_title3='',$paging_button_title4='')
{
	global $PagingOption;

	if ( $pageScale != '자동' && $pageScale != '' )
	{
		$pageScale			= preg_replace("/\D/", "", $pageScale);

		if ( $pageScale != '' )
		{
			$PagingOption['pageScale']	= $pageScale;
		}
	}

	if ( $paging_btn1 == '구간이동버튼제외' )
	{
		$PagingOption['paging_btn1']	= 'no';
	}

	if ( $paging_btn2 == '이전다음버튼제외' )
	{
		$PagingOption['paging_btn2']	= 'no';
	}

	if ( $paging_button_title1 != '자동' && $paging_button_title1 != '' )
	{
		$PagingOption['btn_title1']		= $paging_button_title1;
	}

	if ( $paging_button_title2 != '자동' && $paging_button_title2 != '' )
	{
		$PagingOption['btn_title2']		= $paging_button_title2;
	}

	if ( $paging_button_title3 != '자동' && $paging_button_title3 != '' )
	{
		$PagingOption['btn_title3']		= $paging_button_title3;
	}

	if ( $paging_button_title4 != '자동' && $paging_button_title4 != '' )
	{
		$PagingOption['btn_title4']		= $paging_button_title4;
	}
}


function newPaging( $totalList, $listScale, $pageScale, $startPage, $prexImgName, $nextImgName, $search) {
	global $paging_color1, $paging_color2, $paging_color3 ;
	global $PagingOption, $newPaging_prexImgName_section, $newPaging_nextImgName_section;

	if ( $PagingOption['pageScale'] != '' )
	{
		$pageScale		= $PagingOption['pageScale'];
	}

	$paging_btn1	= $PagingOption['paging_btn1'];
	$paging_btn2	= $PagingOption['paging_btn2'];

	if ( $newPaging_prexImgName_section != '' )
	{
		$prexImgName_section	= $newPaging_prexImgName_section;
	}
	else
	{
		$prexImgName_section	= '<<';
	}

	if ( $newPaging_nextImgName_section != '' )
	{
		$nextImgName_section	= $newPaging_nextImgName_section;
	}
	else
	{
		$nextImgName_section	= '>>';
	}


	if ( $PagingOption['btn_title1'] != '' )
	{
		$prexImgName_section	= $PagingOption['btn_title1'];
	}

	if ( $PagingOption['btn_title2'] != '' )
	{
		$prexImgName			= $PagingOption['btn_title2'];
	}


	if ( $PagingOption['btn_title3'] != '' )
	{
		$nextImgName			= $PagingOption['btn_title3'];
	}


	if ( $PagingOption['btn_title4'] != '' )
	{
		$nextImgName_section	= $PagingOption['btn_title4'];
	}

	# 한번 호출후에는 초기화
	$PagingOption	= Array();

	$paging_color1	= $paging_color1 == '' ? 'black' : $paging_color1;
	$paging_color2	= $paging_color2 == '' ? 'green' : $paging_color2;
	$paging_color3	= $paging_color3 == '' ? 'red' : $paging_color3;
	$paging	= "<span style='display:inline-block; margin-top:50px;'>";

	$nowPage	= ($startPage / $listScale) + 1;

	$Start		= ( $nowPage - $pageScale > 0 )?$nowPage-$pageScale:0;
	$Start		= ( $Start - 1 < 0 )?0:$Start-1;
	$End		= $nowPage+$pageScale;
	//$paging	= $nowPage." - ".$Start."<br>";

	#실장님의 지시로 페이징 변경.
	if ( $End < $pageScale * 2 + 1 )
	{
		$End		= $pageScale * 2 + 1;
	}

	if ( $totalList % $listScale == 0 )
	{
		$totalPage	= $totalList / $listScale;
	}
	else
	{
		$totalPage	= floor($totalList / $listScale)+1;
	}

	if ( $totalPage < $End )
	{
		$gap		= $End - $totalPage ;
		$Start		= $Start - $gap;
		if ( $Start < 0 )
		{
			$Start		= 0;
		}
	}
	#echo "$Start - $End - $totalList - $totalPage - $gap";

	//prePageCnt 페이지만큼 앞뒤로
	$prePageCnt = $pageScale * 2;
	$lastPageCnt = ($totalList % $listScale == 0)?$listScale:$totalList % $listScale;
	$prePageCnt2 = ($startPage-($listScale*$prePageCnt));
	$prePage2 = ($prePageCnt2 <= 0)?0:$prePageCnt2;

	$nNextPageCnt2 = ($startPage+($listScale*$prePageCnt));
	$nNextPage2 = ($nNextPageCnt2>=$totalList)?$totalList-$lastPageCnt:$nNextPageCnt2;

	#if( $totalList > $listScale ) {

		if ( $nowPage - 1 > 0 )
		{
			$prePage	= ($nowPage-2)*$listScale;
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_prev'><a href='$_SERVER[PHP_SELF]?start=".$prePage2.$search."'  onfocus=this.blur()>$prexImgName_section</a></div>";
			}
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_prev0'><a href='$_SERVER[PHP_SELF]?start=".$prePage.$search."' onfocus=this.blur()>$prexImgName</a></div>";
			}
			#$paging	.= "<div class='page_prev'> << </div>";
		}
		else
		{
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_prev_no'>$prexImgName_section</div>";
			}
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_prev0_no'>$prexImgName</div>";
			}

		}
		for( $j=$Start; $j<$End; $j++ ) {
			$nextPage = $j * $listScale;
			$pageNum = $j+1;
			if( $nextPage < $totalList ) {
				if( $nextPage!= $startPage ) {

					$paging	.=  "<div class='page_nomal' onclick=\"location.href='$_SERVER[PHP_SELF]?start=".$nextPage.$search."'\" style='cursor:pointer;'><a href='$_SERVER[PHP_SELF]?start=".$nextPage.$search."' onfocus=this.blur()>$pageNum</a></div>";
				} else {
					$paging	.= "<div class='page_now'>$pageNum</div>";
				}
			}
		}
		if ( ($nowPage*$listScale) < $totalList )
		{
			$nNextPage	= ($nowPage)*$listScale;
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_next0'><a href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."' onfocus=this.blur() >$nextImgName</a></div>";
			}
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_next'><a href='$_SERVER[PHP_SELF]?start=".$nNextPage2.$search."' onfocus=this.blur() >$nextImgName_section</a></div>";
			}
			#$paging	.= "<div class='page_next' onclick=\"location.href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."'\" style='cursor:pointer;'><a href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."' onfocus=this.blur()> >> </a></div>";
		}
		else
		{
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_next0_no'>$nextImgName</div>";
			}
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_next_no'>$nextImgName_section</div>";
			}
		}

	#}
	#if( $totalList <= $listScale) {
	#	$paging	.= "<div class='page_now'>1</div>";
	#}
	$paging	.= "</span>";
	return $paging;
}


function newPaging_ajax( $totalList, $listScale, $pageScale, $startPage, $prexImgName, $nextImgName, $search) {

	global $ajaxNum;

	global $paging_color1, $paging_color2, $paging_color3 ;
	global $PagingOption, $newPaging_prexImgName_section, $newPaging_nextImgName_section;

	if ( $PagingOption['pageScale'] != '' )
	{
		$pageScale		= $PagingOption['pageScale'];
	}

	$paging_btn1	= $PagingOption['paging_btn1'];
	$paging_btn2	= $PagingOption['paging_btn2'];

	if ( $newPaging_prexImgName_section != '' )
	{
		$prexImgName_section	= $newPaging_prexImgName_section;
	}
	else
	{
		$prexImgName_section	= '<<';
	}

	if ( $newPaging_nextImgName_section != '' )
	{
		$nextImgName_section	= $newPaging_nextImgName_section;
	}
	else
	{
		$nextImgName_section	= '>>';
	}


	if ( $PagingOption['btn_title1'] != '' )
	{
		$prexImgName_section	= $PagingOption['btn_title1'];
	}

	if ( $PagingOption['btn_title2'] != '' )
	{
		$prexImgName			= $PagingOption['btn_title2'];
	}


	if ( $PagingOption['btn_title3'] != '' )
	{
		$nextImgName			= $PagingOption['btn_title3'];
	}


	if ( $PagingOption['btn_title4'] != '' )
	{
		$nextImgName_section	= $PagingOption['btn_title4'];
	}

	# 한번 호출후에는 초기화
	$PagingOption	= Array();

	$paging_color1	= $paging_color1 == '' ? 'black' : $paging_color1;
	$paging_color2	= $paging_color2 == '' ? 'green' : $paging_color2;
	$paging_color3	= $paging_color3 == '' ? 'red' : $paging_color3;
	$paging	= "<span style='display:inline-block;'>";

	$nowPage	= ($startPage / $listScale) + 1;

	$Start		= ( $nowPage - $pageScale > 0 )?$nowPage-$pageScale:0;
	$Start		= ( $Start - 1 < 0 )?0:$Start-1;
	$End		= $nowPage+$pageScale;
	//$paging	= $nowPage." - ".$Start."<br>";

	#실장님의 지시로 페이징 변경.
	if ( $End < $pageScale * 2 + 1 )
	{
		$End		= $pageScale * 2 + 1;
	}

	if ( $totalList % $listScale == 0 )
	{
		$totalPage	= $totalList / $listScale;
	}
	else
	{
		$totalPage	= floor($totalList / $listScale)+1;
	}

	if ( $totalPage < $End )
	{
		$gap		= $End - $totalPage ;
		$Start		= $Start - $gap;
		if ( $Start < 0 )
		{
			$Start		= 0;
		}
	}
	#echo "$Start - $End - $totalList - $totalPage - $gap";

	//prePageCnt 페이지만큼 앞뒤로
	$prePageCnt = $pageScale * 2;
	$lastPageCnt = ($totalList % $listScale == 0)?$listScale:$totalList % $listScale;
	$prePageCnt2 = ($startPage-($listScale*$prePageCnt));
	$prePage2 = ($prePageCnt2 <= 0)?0:$prePageCnt2;

	$nNextPageCnt2 = ($startPage+($listScale*$prePageCnt));
	$nNextPage2 = ($nNextPageCnt2>=$totalList)?$totalList-$lastPageCnt:$nNextPageCnt2;

	#if( $totalList > $listScale ) {

		if ( $nowPage - 1 > 0 )
		{
			$prePage	= ($nowPage-2)*$listScale;
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_prev'><a href=\"javascript:gopaging${ajaxNum}($prePage2);\" onfocus=this.blur()>$prexImgName_section</a></div>";
			}
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_prev0'><a href=\"javascript:gopaging${ajaxNum}($prePage);\" onfocus=this.blur()>$prexImgName</a></div>";
			}
			#$paging	.= "<div class='page_prev'> << </div>";
		}
		else
		{
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_prev_no'>$prexImgName_section</div>";
			}
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_prev0_no'>$prexImgName</div>";
			}

		}
		for( $j=$Start; $j<$End; $j++ ) {
			$nextPage = $j * $listScale;
			$pageNum = $j+1;
			if( $nextPage < $totalList ) {
				if( $nextPage!= $startPage ) {

					$paging	.=  "<div class='page_nomal' onclick=\"gopaging${ajaxNum}($nextPage)\" style='cursor:pointer;'><a href=\"javascript:gopaging${ajaxNum}($nextPage);\" onfocus=this.blur()>$pageNum</a></div>";
				} else {
					$paging	.= "<div class='page_now'>$pageNum</div>";
				}
			}
		}
		if ( ($nowPage*$listScale) < $totalList )
		{
			$nNextPage	= ($nowPage)*$listScale;
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_next0'><a href=\"javascript:gopaging${ajaxNum}($nNextPage);\" onfocus=this.blur() >$nextImgName</a></div>";
			}
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_next'><a href=\"javascript:gopaging${ajaxNum}($nNextPage2);\" onfocus=this.blur() >$nextImgName_section</a></div>";
			}
			#$paging	.= "<div class='page_next' onclick=\"location.href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."'\" style='cursor:pointer;'><a href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."' onfocus=this.blur()> >> </a></div>";
		}
		else
		{
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_next0_no'>$nextImgName</div>";
			}
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_next_no'>$nextImgName_section</div>";
			}
		}

	#}
	#if( $totalList <= $listScale) {
	#	$paging	.= "<div class='page_now'>1</div>";
	#}
	$paging	.= "</span>";
	return $paging;
}

function newPaging_ajax_bbs( $totalList, $listScale, $pageScale, $startPage, $prexImgName, $nextImgName, $search, $getVals="") {

	global $paging_color1, $paging_color2, $paging_color3 ;
	global $PagingOption, $newPaging_prexImgName_section, $newPaging_nextImgName_section;

	list($ex_limit,$ex_width,$ex_cut,$ex_category,$ex_template,$ex_paging,$ex_ajax_id_name,$ex_get_id,$ex_garbage,$ex_action,$ex_number,$ex_search_type,$ex_search_word) = explode(",",$getVals);

	if ( $PagingOption['pageScale'] != '' )
	{
		$pageScale		= $PagingOption['pageScale'];
	}

	$paging_btn1	= $PagingOption['paging_btn1'];
	$paging_btn2	= $PagingOption['paging_btn2'];

	if ( $newPaging_prexImgName_section != '' )
	{
		$prexImgName_section	= $newPaging_prexImgName_section;
	}
	else
	{
		$prexImgName_section	= '<<';
	}

	if ( $newPaging_nextImgName_section != '' )
	{
		$nextImgName_section	= $newPaging_nextImgName_section;
	}
	else
	{
		$nextImgName_section	= '>>';
	}


	if ( $PagingOption['btn_title1'] != '' )
	{
		$prexImgName_section	= $PagingOption['btn_title1'];
	}

	if ( $PagingOption['btn_title2'] != '' )
	{
		$prexImgName			= $PagingOption['btn_title2'];
	}


	if ( $PagingOption['btn_title3'] != '' )
	{
		$nextImgName			= $PagingOption['btn_title3'];
	}


	if ( $PagingOption['btn_title4'] != '' )
	{
		$nextImgName_section	= $PagingOption['btn_title4'];
	}

	# 한번 호출후에는 초기화
	$PagingOption	= Array();

	$paging_color1	= $paging_color1 == '' ? 'black' : $paging_color1;
	$paging_color2	= $paging_color2 == '' ? 'green' : $paging_color2;
	$paging_color3	= $paging_color3 == '' ? 'red' : $paging_color3;
	$paging	= "<span style='display:inline-block;'>";

	$nowPage	= ($startPage / $listScale) + 1;

	$Start		= ( $nowPage - $pageScale > 0 )?$nowPage-$pageScale:0;
	$Start		= ( $Start - 1 < 0 )?0:$Start-1;
	$End		= $nowPage+$pageScale;
	//$paging	= $nowPage." - ".$Start."<br>";

	#실장님의 지시로 페이징 변경.
	if ( $End < $pageScale * 2 + 1 )
	{
		$End		= $pageScale * 2 + 1;
	}

	if ( $totalList % $listScale == 0 )
	{
		$totalPage	= $totalList / $listScale;
	}
	else
	{
		$totalPage	= floor($totalList / $listScale)+1;
	}

	if ( $totalPage < $End )
	{
		$gap		= $End - $totalPage ;
		$Start		= $Start - $gap;
		if ( $Start < 0 )
		{
			$Start		= 0;
		}
	}
	#echo "$Start - $End - $totalList - $totalPage - $gap";

	//prePageCnt 페이지만큼 앞뒤로
	$prePageCnt = $pageScale * 2;
	$lastPageCnt = ($totalList % $listScale == 0)?$listScale:$totalList % $listScale;
	$prePageCnt2 = ($startPage-($listScale*$prePageCnt));
	$prePage2 = ($prePageCnt2 <= 0)?0:$prePageCnt2;

	$nNextPageCnt2 = ($startPage+($listScale*$prePageCnt));
	$nNextPage2 = ($nNextPageCnt2>=$totalList)?$totalList-$lastPageCnt:$nNextPageCnt2;

	#if( $totalList > $listScale ) {

		if ( $nowPage - 1 > 0 )
		{
			$prePage	= ($nowPage-2)*$listScale;
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_prev'><a href=\"javascript:bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$prePage2','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word');\" onfocus=this.blur()>$prexImgName_section</a></div>";
			}
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_prev0'><a href=\"javascript:bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$prePage','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word');\" onfocus=this.blur()>$prexImgName</a></div>";
			}
			#$paging	.= "<div class='page_prev'> << </div>";
		}
		else
		{
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_prev_no'>$prexImgName_section</div>";
			}
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_prev0_no'>$prexImgName</div>";
			}

		}
		for( $j=$Start; $j<$End; $j++ ) {
			$nextPage = $j * $listScale;
			$pageNum = $j+1;
			if( $nextPage < $totalList ) {
				if( $nextPage!= $startPage ) {
					$paging	.=  "<div class='page_nomal' onclick=\"bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$nextPage','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word');\" style='cursor:pointer;'><a href=\"javascript:bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$nextPage','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word');\" onfocus=this.blur()>$pageNum</a></div>";
				} else {
					$paging	.= "<div class='page_now'>$pageNum</div>";
				}
			}
		}
		if ( ($nowPage*$listScale) < $totalList )
		{
			$nNextPage	= ($nowPage)*$listScale;
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_next0'><a href=\"javascript:bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$nNextPage','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word');\" onfocus=this.blur() >$nextImgName</a></div>";
			}
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_next'><a href=\"javascript:bbs_list_get('$ex_limit','$ex_width','$ex_cut','$ex_category','$ex_template','$ex_paging','bbs_list_page','$ex_ajax_id_name','$nNextPage2','$ex_ajax_id_name','$ex_get_id','$ex_garbage','$ex_action','$ex_number','$ex_search_type','$ex_search_word');\" onfocus=this.blur() >$nextImgName_section</a></div>";
			}
			#$paging	.= "<div class='page_next' onclick=\"location.href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."'\" style='cursor:pointer;'><a href='$_SERVER[PHP_SELF]?start=".$nNextPage.$search."' onfocus=this.blur()> >> </a></div>";
		}
		else
		{
			if ( $paging_btn2 != 'no' )
			{
				$paging	.= "<div class='page_next0_no'>$nextImgName</div>";
			}
			if ( $paging_btn1 != 'no' )
			{
				$paging	.= "<div class='page_next_no'>$nextImgName_section</div>";
			}
		}

	#}
	#if( $totalList <= $listScale) {
	#	$paging	.= "<div class='page_now'>1</div>";
	#}
	$paging	.= "</span>";
	return $paging;
}




//게시판
function board_extraction_list($ex_limit,$ex_width,$ex_cut,$ex_content_cut,$ex_category,$ex_template,$ex_garbage = '0',$ex_exp = '')
{
	#{{게시판보기 페이지당20개,가로1개,제목길이50자,질문과 답변,bbs_list.html}}
	#{{게시판보기 페이지당20개,가로1개,제목길이50자,현재테이블,bbs_list.html}}
	if( $ex_template == ""  )
	{
		print "껍데기 템플릿에서 상세화면의 템플릿지정을 하지 않았습니다<br>";
		return;
	}

	global $board_title_color,$board_new_cut,$_GET,$skin_folder_bbs,$level,$mem_id,$tb,$board_list,$B_CONF,$skin_folder,$tb,$BOARD,$TPL,$페이지출력,$pg,$board_short_comment,$board_pick_cut_day,$action,$search,$keyword,$게시판권한,$numb,$search_board,$search_page,$master_check,$board_top_gonggi,$MEM;

	global $HAPPY_CONFIG;
	global $happy_member,$happy_sns_array, $배경색,$happy_member_login_value;

	#문자열을 정리해서 숫자만 뽑아주자
	$ex_limit = preg_replace('/\D/', '', $ex_limit);
	$ex_width = preg_replace('/\D/', '', $ex_width);
	$ex_cut = preg_replace('/\D/', '', $ex_cut);
	$ex_content_cut = preg_replace('/\D/', '', $ex_content_cut);
	$ex_garbage = preg_replace('/\D/', '', $ex_garbage);
	$ex_category  = preg_replace('/\n/', '', $ex_category);
	$ex_template  = preg_replace('/\n/', '', $ex_template);
	$ex_exp  = preg_replace('/\n/', '', $ex_exp);

	/** 패치 - 2015-03-27 - x2chi
	* 추출태그 여러개 사용시 상단에 '첫페이지만출력' 이 있으면 $pg가 1로 강제 변경됨 global로 계속 참조 됨.
	* $_GET['pg']가 있다면 $pg 를 $_GET['pg']으로 변경.
	**/
	$pg = ( $_GET['pg'] > 0 ? $_GET['pg'] : $pg );


	if ($ex_exp == '첫페이지만출력')
	{
		if ($pg > 1)
		{
			$pg = 1;
		}
	}



	// 공지게시물 출력 설정 - 16.10.26 - x2chi
	if( ( $ex_gong == '공지게시글' || $ex_category == '공지게시글' ) && $B_CONF['notice_list_view'] == 0 )
	{
		return;
	}

	$order_query = "groups desc,depth asc,seq desc";
	#외부명으로 게시판 table을 구한다
	if ($ex_category == "")
	{
		print "<br>존재하지 않는 게시판입니다<br>";
		return;
	}
	elseif ($ex_category == "현재게시판")
	{
		#현재테이블인 경우 tb의 값으로 찾자

		#읽을수 있는 회원인가?
		if ($master_check != "1")
		{
			if ( !happy_member_secure('%게시판%'.$tb.'-list') )
			{
				print "<br><font style='font-size:14px'><center>현재 회원님의 레벨로는 <font color=red>$ex_category</font> 게시판리스팅 권한이 없습니다 <br>";
				return;
			}
		}

		#존재하는 게시판인가?
		$sql1 = "select * from $board_list where tbname = '$tb'";
		$result1 = query($sql1);
		$B_CONF = happy_mysql_fetch_array($result1);

		if ($search_board)
		{
			$add_where_query = " and notice = '0' ";
		}
		else
		{
			$add_where_query = " where notice = '0' ";
		}

		if ($B_CONF[tbname] == "")
		{
			print "<br><font color=red>$ex_category</font>은 존재하지 않는 게시판입니다 <br>";
			return;
		}
	}
	elseif ($ex_category == "현재게시판전체")
	{
		#현재테이블인 경우 tb의 값으로 찾자

		#읽을수 있는 회원인가?
		if ($master_check != "1")
		{
			if ( !happy_member_secure('%게시판%'.$tb.'-list') )
			{
				print "<br><font style='font-size:11px'><center>현재 회원님의 레벨로는 <font color=red>$ex_category</font> 게시판리스팅 권한이 없습니다 <br>";
				return;
			}
		}

		#존재하는 게시판인가?
		$sql1 = "select * from $board_list where tbname = '$tb'";
		$result1 = query($sql1);
		$B_CONF = happy_mysql_fetch_array($result1);

		$add_where_query = "";
		// 공지 출력하지 않음
		if( $B_CONF['notice_list_view'] == 0 )
		{
			if ($search_board)
			{
				$add_where_query = " and notice = '0' ";
			}
			else
			{
				$add_where_query = " where notice = '0' ";
			}
		}

		if ($B_CONF[tbname] == "")
		{
			print "<br><font color=red>$ex_category</font>은 존재하지 않는 게시판입니다 <br>";
			return;
		}

		$order_query = "notice desc, groups desc,depth asc,seq desc";
	}
	elseif ($ex_category == "추천게시글")
	{
		#현재테이블인 경우 tb의 값으로 찾자

		#읽을수 있는 회원인가?
		if ($master_check != "1")
		{
			if ( !happy_member_secure('%게시판%'.$tb.'-list') )
			{
				print "<br><font style='font-size:14px'><center>현재 회원님의 레벨로는 <font color=red>$ex_category</font> 게시판리스팅 권한이 없습니다 <br>";
				return;
			}
		}

		#존재하는 게시판인가?
		$sql1 = "select * from $board_list where tbname = '$tb' ";
		$result1 = query($sql1);
		$B_CONF = happy_mysql_fetch_array($result1);

		if ($B_CONF[tbname] == "")
		{
			print "<br><font color=red>$ex_category</font>은 존재하지 않는 게시판입니다 <br>";
			return;
		}

		$order_query = "bbs_etc4 desc,number desc";

		if ($search_board)
		{
			$add_where_query = " and bbs_date >= DATE_SUB(  now(),  INTERVAL $board_pick_cut_day day  ) ";
		}
		else
		{
			$add_where_query = " where bbs_date >= DATE_SUB(  now(),  INTERVAL $board_pick_cut_day day  ) ";
		}
	}
	elseif ($ex_category == "공지게시글")
	{
		#현재테이블인 경우 tb의 값으로 찾자

		#읽을수 있는 회원인가?
		if ($master_check != "1")
		{
			if ( !happy_member_secure('%게시판%'.$tb.'-list') )
			{
				print "<br><font style='font-size:14px'><center>현재 회원님의 레벨로는 <font color=red>$ex_category</font> 게시판리스팅 권한이 없습니다 <br>";
				return;
			}
		}

		#존재하는 게시판인가?
		$sql1 = "select * from $board_list where tbname = '$tb' ";
		$result1 = query($sql1);
		$B_CONF = happy_mysql_fetch_array($result1);

		if ($B_CONF[tbname] == "")
		{
			print "<br><font color=red>$ex_category</font>은 존재하지 않는 게시판입니다 <br>";
			return;
		}

		$order_query = "bbs_etc4 desc,number desc";

		if ($search_board)
		{
			$add_where_query = " and notice = '1' ";
		}
		else
		{
			$add_where_query = " where notice = '1' ";
		}
	}
	else
	{
		#목록으로 추려읽을수도 있도록
		$add_where_query = "";

		//게시판 추출명칭으로 추출
		$Sql		= "SELECT * FROM $board_list WHERE board_keyword = '$ex_category'";
		$B_CONF		= happy_mysql_fetch_assoc(query($Sql));
		if ( $B_CONF['tbname'] == '' )
		{
			$Sql		= "SELECT * FROM $board_list WHERE board_name = '$ex_category'";
			$B_CONF		= happy_mysql_fetch_assoc(query($Sql));
		}
		//게시판 추출명칭으로 추출


		#읽을수 있는 회원인가?
		if ($master_check != "1")
		{
			if ( !happy_member_secure('%게시판%'.$B_CONF['tbname'].'-list') )
			{
				//print "<br><font style='font-size:11px'><center>현재 회원님의 레벨로는 <font color=red>$ex_category</font> 게시판리스팅 권한이 없습니다 <br>";
					print "<div style='background:rgba(0,0,0,0.4); border-radius:5px; text-align:center;'><p class='font_16 noto400' style='color:#fff; padding:15px;'>현재 회원님의 레벨로는 <span style='color:#{{배경색.기본색상}};'>$ex_category</span><br>게시판리스팅 권한이 없습니다.</p></div>";
				return;
			}
		}

		#존재하는 게시판인가?
		if ($B_CONF[tbname] == "")
		{
			print "<font color=red>$ex_category</font> 존재하지 않는 게시판입니다 <br>";
			return;
		}
	}

	if( !(is_file("$skin_folder_bbs/$ex_template")) )
	{
		print "상세화면페이지의 $skin_folder/$ex_template 파일이 존재하지 않습니다. <br>";
		return;
	}
	#####################################

	#정렬부분
	if ($ex_garbage == "")
	{
		$ex_garbage = '0';
		$tmp_limit = '0';
	}
	else
	{
		$tmp_limit = $ex_garbage;
		$tmp_limit = $view_rows + $ex_garbage;
	}

	if ($start == "")
	{
		$start = $_GET[start];
	}
	if($start==0 || $start=="")
	{
		$start=0;
	}

	//페이지 나누기
	$numb = $numb - $ex_garbage; #추가

	$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
	$total_page = floor($total_page);

	$view_rows = $start+$ex_garbage;
	$auto_number  =  $numb - $start;

	if ($ex_exp == '첫페이지만출력')
	{
		if ($start > 0)
		{
			$view_rows = 0;
		}
	}

	if ($ex_category == "추천게시글")
	{
		$view_rows = '0';
	}

	$main_new = "";

	$sql = "select * from $B_CONF[tbname]  $search_board $add_where_query order by $order_query limit $view_rows,$ex_limit";

	$result = query($sql);
	//print "$sql <br>(110번째줄 삭제해야함)<br>";
	$게시판갯수 = mysql_num_rows($result);
	#####################################

	$i = "1";
	$main_new_out = "<table cellspacing='0' cellpadding='0' border='0' width=100% border=0>";
	$TPL->define("그림_$ex_template", "$skin_folder_bbs/$ex_template");
	$TPL->assign("그림_$ex_template");


	while  ($BOARD = happy_mysql_fetch_array($result))
	{
		#radio1 에 대한 답변
		if ($BOARD[radio1])
		{
			$BOARD[radio1_info] = "<span class='bbs_radio_info_01'>완료</span>";
		}
		else if ( $BOARD['depth'] == 0 )
		{
			$BOARD[radio1_info] = "<span class='bbs_radio_info_02'>접수</span>";
		}

		#자동번호
		if( $BOARD['notice'] == '1' )
		{
			$BOARD[auto_number] = "<span uk-icon=\"icon:bell; ratio:1\" style=\"color:#{$배경색['게시판1']};\"></span>";
		}
		else
		{
			$BOARD[auto_number] = $auto_number;
		}

		#파일...
		if ( $BOARD[bbs_etc1] != "" )
		{
			$BOARD[attach] = "<span uk-icon='icon:link; ratio:1' style='color:#222222;'></span>";
			$BOARD[attach_admin] = "<span uk-icon='icon:link; ratio:1' style='color:#222222;'></span>";

			$BOARD[inFile] = "<span uk-icon='icon:link; ratio:1' style='color:#222222;'></span>";
		}
		else
		{
			$BOARD[attach] = "<span uk-icon='icon:link; ratio:1' style='color:#999999;'></span>";
			$BOARD[attach_admin] = "<span uk-icon='icon:link; ratio:1' style='color:#999999;'></span>";

			$BOARD[inFile] = "<span uk-icon='icon:link; ratio:1' style='color:#999999;'></span>";
		}

		#잠긴글
		if ( $BOARD[view_lock])
		{
			$BOARD[attach] = "<span uk-icon='icon:lock; ratio:1' style='color:#222222; margin-right:6px; margin-bottom:4px; vertical-align:middle;'></span>";
			$BOARD[lock] = "<span uk-icon='icon:lock; ratio:1' style='color:#222222; margin-right:6px; margin-bottom:4px; vertical-align:middle;'></span>";
		}

		if ($B_CONF[category])
		{
			$BOARD[b_category_dis] = "";

			if ($BOARD[b_category] == "")
			{
				$BOARD[b_category] = '전체';
			}
			$BOARD[b_category_con] = '[' . $BOARD[b_category] . '] ';
		}
		else
		{
			$BOARD[b_category_dis] = "display:none;";
		}


		#new 아이콘
		list($BOARD[bbs_date],$BOARD[bbs_time]) = explode(" ",$BOARD[bbs_date]);
		$today = date("Y-m-d");

		$gap_day = (strtotime($today)-strtotime($BOARD[bbs_date]))/(60*60*24);

		if ( $gap_day <= $board_new_cut )
		{
			$BOARD[bbs_date] = "$BOARD[bbs_date]";
			$new_icon = "<img src='".$HAPPY_CONFIG['IconNew1']."' align=absmiddle>&nbsp; ";
			$new_icon2 = "<img src='".$HAPPY_CONFIG['IconNew1']."' align=absmiddle>&nbsp; ";
		}
		else
		{
			$new_icon = "";
			$new_icon2 = "";
		}

		$BOARD['new_icon']	= $new_icon;
		$BOARD['new_icon2']	= $new_icon2;

		#자동툴팁
		$BOARD['img']	= '';
		if (eregi('.jp', $BOARD[bbs_etc1]) || eregi('.gif', $BOARD[bbs_etc1]) )
		{
			if ($BOARD[bbs_etc6])
			{
				$main_img_temp = "./data/$B_CONF[tbname]/$BOARD[bbs_etc6]";
			}
			else
			{
				$main_img_temp = "./data/$B_CONF[tbname]/$BOARD[bbs_etc1]";
			}

			$BOARD[tool_tip] = " onMouseover=\"ddrivetip('<IMG src=\'$main_img_temp\' border=0 width=200>','white', 200)\"; onMouseout=\"hideddrivetip()\"";
			$BOARD[thumb] = "$main_img_temp";
			$BOARD[img_width] = $imagehw[0];
			$BOARD[img_height] = $imagehw[1];
			$BOARD['img']		= "<img src='$main_img_temp' align='absmiddle' border='0' width='$img_width' height='$img_height'>";
			$BOARD['img_none']	= $BOARD['img'];
		}
		else
		{
			$BOARD[tool_tip] = "";
			#$BOARD[thumb] = "img/no_photo.gif";
			$BOARD[thumb] = $HAPPY_CONFIG['ImgNoImage1'];
		}


		//게시판본문이 처음선언되는곳 & 스크립트제거 - ranksa
		$BOARD['bbs_review'] = preg_replace("!<script(.*?)<\/script>!is","",$BOARD['bbs_review']);

		#추출시 첨부에서 이미지가 없을때 src="/wys2/file_attach/2008/05/20/1211276747-39.jpg"
		if ($BOARD['img']=='')
		{
			preg_match("/<img(.*?)src=\"\/(.*?)\"/i",$BOARD[bbs_review],$matches);

			if (preg_match("/\.jpg|\.jpeg|\.png|\.gif/i",$matches[2] ,$matchess ))
			{
				$matches2tmp	= $matches[2];
				$matches[2]		= str_replace("/file_attach/","/file_attach_thumb/",$matches[2]);
				if ( !is_file($matches[2]) )
				{
					$matches[2] = $matches2tmp;
				}
				$BOARD[tool_tip] = " onMouseover=\"ddrivetip('<IMG src=\'$matches[2]\' border=0 width=200>','white', 200)\"; onMouseout=\"hideddrivetip()\"";
				$BOARD[thumb] = $matches[2];
				$BOARD['img']		= "<img src='$matches[2]' align='absmiddle' border='0' width='$img_width' height='$img_height'>";
				$BOARD['img_none']	= $BOARD['img'];
			}
			else
			{
				$BOARD[tool_tip] = "";
				$BOARD[thumb] = "img/no_photo.gif";
				$BOARD[thumb] = $HAPPY_CONFIG['ImgNoImage1'];
			}
		}

		#답변글 안으로 밀기
		$re = "";
		if($BOARD[depth]>0)
		{
			for($k=0; $k<$BOARD[depth]; $k++)
			{
				$re .= ""; //$re. 을 해줘야지 다시 반복된다
			}
			#$re .= "<img src='./board_img/reply_icon.gif' border=0>&nbsp;";
			$re .= "<span uk-icon='icon:arrow-right; ratio:1' class='uk-icon'></span>";
		}

		#제목을 잘라준다
		if ($ex_cut)
		{
			$ex_cut_new = $ex_cut - ($k * 4);
			$BOARD[bbs_title] = kstrcut($BOARD[bbs_title], $ex_cut_new, "...");

			if ( $BOARD[view_lock] )
			{
				if( !admin_secure('슈퍼관리자전용') && $BOARD['bbs_id'] != $happy_member_login_value )
				{
					$BOARD['bbs_title']	= preg_replace('/(?<=.{1})./u','*',$BOARD['bbs_title']);
				}
			}
		}

		if ($BOARD['view_lock'] != "1")
		{
			//덩달아 내용도 잘라주자
			$BOARD[bbs_review]= strip_tags($BOARD[bbs_review]);

			if ($ex_content_cut)
			{
				$BOARD[bbs_review] = kstrcut($BOARD[bbs_review], $ex_content_cut, "...");
			}
		}
		else
		{
			$BOARD[bbs_review] = "<font color='gray'>비밀글 입니다.</font>";
		}

		if ($BOARD[bbs_etc2] > 0)
		{
			$BOARD[댓글] = "[$BOARD[bbs_etc2]]";
		}
		else
		{
			$BOARD[댓글] = "";
		}

		if (!($BOARD[bbs_etc4]))
		{
			$BOARD[bbs_etc4] = "0";
		}

		$BOARD[bbs_title_none] = "$re $BOARD[bbs_title]";

		if ($ex_category == '공지게시글')
		{
			#공지글은 링크추가
			$add_link = "&top_gonggi=1";
		}
		else
		{
			$add_link = '';
		}

		$BOARD[bbs_title] = "$re<a href='./bbs_detail.php?bbs_num=$BOARD[number]$add_link&tb=$B_CONF[tbname]&id=$_GET[id]&pg=$pg'><font color=$board_title_color>$BOARD[bbs_title]</font></a> $new_icon";

		$BOARD['bbs_link1'] = "<a href='./bbs_detail.php?bbs_num=$BOARD[number]$add_link&tb=$B_CONF[tbname]&id=$_GET[id]&pg=$pg'>";
		$BOARD['bbs_link2'] = "</a>";

		# SNS LOGIN 처리 추가
		$BOARD['bbs_name']	= outputSNSID($BOARD['bbs_id'], "icon_use_bbs",$BOARD['bbs_name']);

		$k = "";
		$main_new = &$TPL->fetch();

		#TD를 정리하자
		if ($i % $ex_width == "1")
		{
			$main_new = "<tr><td valign=top align=center>" . $main_new . "</td>";
		}
		elseif ($i % $ex_width == "0")
		{
			$main_new = "<td valign=top align=center>" . $main_new . "</td></tr>";
		}
		else
		{
			$main_new = "<td valign=top align=center>" . $main_new . "</td>";
		}
		$main_new_out .= $main_new;

		$auto_number --;
		$i ++;
	}

	$main_new_out .= "</table>";

	if ( $게시판갯수 == 0 )
	{
		if ($ex_category == '공지게시글')
		{
			$main_new_out	.= "";
		}
		else
		{
			$main_new_out	.= "<table border='0' cellpadding='0' cellspacing='0' style='margin: 30px 0px;' width='100%'>
										<tr>
											<td align='center'><span style='color: rgb(255, 0, 0);'><font style='color: gray; font-size: 14px;'>게시물이 없습니다.</font></span></td>
										</tr>
									</table>
									";
		}
	}

	//include ("./bbs_page.php");

	$Total			= $numb;
	$scale			= $ex_limit;
	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 2 : 6;

	$searchMethod	.= "&tb=$tb";
	$searchMethod	.= $search_page;
	$searchMethod	.= $plus;
	$searchMethod	.= "&links_number=$_GET[links_number]";
	$searchMethod	.= "&bbs_num=$_GET[bbs_num]";
	//include ("./bbs_page.php");
	$page_print		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);

	//print $main_new_out . "<center><br>" . $page_print . "</center> ";
	print "$main_new_out ";
	$페이지출력 = $page_print;
}








######################################################
# 지역이 있을 경우 지역만 검색 / 자동일경우 해당카테고리만 검색
//구인추출
$mobile_scroll_count = 0; //모바일
$guin_main_extraction_count = 0;
function guin_main_extraction($ex_limit,$ex_width,$ex_title_cut,$ex_category1,$ex_category2,$ex_area1,$ex_area2,$ex_type,$ex_job_type,$ex_template,$order="",$startLimit="",$extract_type = "",$ex_guin_career="",$use_headhunting="",$extraction_type="") {//jobwork14

	global $search_si;
	global $search_gu;
	global $search_type;
	global $search_type_sub;
	global $SI_NUMBER;
	global $GU_NUMBER;
	global $TYPE_NUMBER;
	global $TYPE_SUB_NUMBER;
	global $ARRAY;
	global $ARRAY_FILE;
	global $CONF;
	global $ARRAY_NAME;
	global $area_read;
	global $clickChk;
	global $siSelect;
	global $guSelect;
	global $real_gap;
	global $guin_area;
	global $ADMIN;
	global $guin_tb;
	global $TPL;
	global $NEW ;
	global $skin_folder;
	global $undergroundTitle;
	global $want_money_img_arr, $want_money_img_arr2, $TYPE, $TYPE_SUB;
	global $guin_title_bgcolor;

	global $HAPPY_CONFIG;
	global $TDayIcons;
	global $pay_read,$edu_read,$edu_arr,$career_read,$job_underground_tb;
	global $title_read;
	global $mem_id;

	global $guin_title_color;
	global $Happy_Img_Name;
	#구인추출은 지역/업종/유료옵션/고용형태 에만 영향을 받는다.
	global $mobile_scroll_count; //모바일
	global $guin_title_bold;

	global $hunting_use, $job_company;

	global $ticker_use,$job_type_read;

	//회사로고 gif 원본출력여부 hong
	global $is_logo_gif_org_print;

	global $스크랩버튼,$스크랩버튼2,$happy_member_login_value,$scrap_tb,$happy_member_secure_text;
	global $guin_main_extraction_count;

	$guin_main_extraction_count++;

	#문자열을 정리해서 숫자만 뽑아주자
	$ex_limit		= preg_replace('/\D/', '', $ex_limit);
	$ex_width		= preg_replace('/\D/', '', $ex_width);
	$ex_title_cut	= preg_replace('/\D/', '', $ex_title_cut);
	$ex_type		= preg_replace('/\n/', '', $ex_type);
	$ex_category1	= preg_replace('/\n/', '', $ex_category1);
	$ex_category2	= preg_replace('/\n/', '', $ex_category2);
	$ex_template	= preg_replace('/\n/', '', $ex_template);
	$ex_area1		= preg_replace('/\n/', '', $ex_area1);
	$ex_area2		= preg_replace('/\n/', '', $ex_area2);
	$ex_job_type	= preg_replace('/\n/', '', $ex_job_type);
	$startLimit		= preg_replace('/\D/', '', $startLimit);
	$extract_type = preg_replace('/\n/', '', $extract_type); //모바일


	$스크랩권한 = happy_member_secure($happy_member_secure_text[1].'스크랩');


	if ( $startLimit == "" )
	{
		$startLimit	= 0;
	}

	#템플릿을 지정한다. (배너형,좁은배너형,넓은배너형,줄광고형)
	#배너형 wait	= 2
	$subQuery		= "";
	$clickChk		= "";
	$group_query	= "";
	$QUERY			= array();

	//jobwork jobwork, 14번째 인자값
	if ( $ex_guin_career != '전체' && $ex_guin_career != '' )
	{
		$career_read	= $ex_guin_career;
	}

	#필수결제항목은 추출시 검사하자.
	//if ($ex_type == "")
	//{
		if ( is_array($ARRAY) && $CONF['paid_conf'] == 1 )
		{
			foreach($ARRAY as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					if ($CONF[$o_name] == '기간별')
					{
						$wait_query2 = $ARRAY[$k]." > ".$real_gap;
					}
					else
					{
						$wait_query2 = $ARRAY[$k]." > 0 ";
					}
					array_push($QUERY, $wait_query2);
				}
			}
		}
	//}
	#필수결제항목은 추출시 검사하자.

	//print_r2($QUERY);

	#플래시 XML 추가
	$return_type = "";
	if ( preg_match("/_flash/",$ex_type) )
	{
		$ex_type_extension = $ex_type;
		$ex_type = preg_replace("/_flash/","",$ex_type);
		$return_type = "xml";
	}
	#플래시 XML 추가


	if ($ex_type == '일반' || $ex_type == '전체')
	{
		$wait_query	= "";
		$check_ex	= '1';
	}
	else if ( $ex_type == "기업추출" )
	{
		$group_query	= " GROUP BY guin_id ";
		$check_ex		= '1';
	}
	else if ( $ex_type == "오늘본채용정보" )
	{
		$arr		= explode(",",$_COOKIE["HappyTodayGuin"]);
		$todayOrder	= "";
		for ( $i=sizeof($arr)-1, $Count=0 ; $i>=0 && $Count<$ex_limit ; $i-- )
		{
			$tmp	= explode("_",$arr[$i]);
			$cookieVal	.= ( $Count == 0 )?"":",";
			$cookieVal	.= $tmp[0];
			$ttt		= ( $Count == 0 )?" number = $tmp[0]":" number = $tmp[0],";
			$todayOrder	= $ttt . $todayOrder;
			$Count++;
		}
		if ( $cookieVal != "" )
			array_push($QUERY, " number in ($cookieVal) ");
		else
		{
			array_push($QUERY, " number = '0' ");
			$todayOrder	= " number ";
		}
		$check_ex		= '1';

	}
	else
	{
		for ($i = 0; $i <=16 ; $i++)
		{
			#이력서보기기간,회수별보기,SMS제외
			if ( $i >= 7 && $i <= 9 )
			{
				continue;
			}

			if ($ex_type == $ARRAY_NAME[$i])
			{
				$check_ex = '1';
				$tmp_option = $ARRAY[$i] . "_option";
				if ($CONF[$tmp_option] == '기간별')
				{
					#무료로 사용할때는 모두 나오도록
					if ( $CONF[$ARRAY[$i]] != "" )
					{
						$wait_query = "$ARRAY[$i] > $real_gap ";
					}
				}
				else if ( $CONF[$tmp_option] == '노출별' )
				{
					$wait_query = "$ARRAY[$i] > '0' ";
					$subQuery	= "update $guin_tb SET $ARRAY[$i] = $ARRAY[$i]-1 WHERE number='kwak' ";
				}
				else
				{
					$clickChk	= $ARRAY[$i];
					$wait_query = "$ARRAY[$i] > '0' ";
				}
				break;
			}
		}


	}


	if ($check_ex != '1')
	{
		return print $main_new_out = "<font color=red>$ex_type</font>로 지정된 옵션은 존재하지 않습니다. <br>템플릿 파일을 다시 설정 하세요";
		exit;
	}

	if ($ex_template == "")
	{
		#전체출력용 (유,무료상관없이)
		return $main_new_out = "<font color=red>템플릿 파일을 지정하세요";
		exit;
	}

	$plus	.=	"com_info_id=$_GET[com_info_id]&";

	#직종별 작업해야함.
	if ($ex_category1 == "전체" || $ex_category1 == "")
	{
		$category_query1 = "";
	}
	elseif ($ex_category1 == "자동")
	{
		$ex_category1 = $search_type;
		$ex_category2 = $search_type_sub;

		if ($ex_category1 && $ex_category2)
		{
			$category_query1 = " ( (type1 = '$ex_category1' and type_sub1 = '$ex_category2') or (type2 = '$ex_category1' and type_sub2 = '$ex_category2') or (type3 = '$ex_category1' and type_sub3 = '$ex_category2') )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&search_sub_type=$ex_category2&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1] $TYPE_SUB[$ex_category2]</font> ";
		}
		elseif ($ex_category1 && $ex_category2 == '')
		{
			$category_query1 = " (type1 = '$ex_category1' or type2 = '$ex_category1' or type3 = '$ex_category1' )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1]"."</font> ";
		}
		else
		{
			$category_query1 = '';
		}
	}
	elseif ($ex_category1 )
	{
		$ex_category1 = $TYPE_NUMBER[$ex_category1];
		$ex_category2 = $TYPE_SUB_NUMBER[$ex_category2];

		if ($ex_category1 && $ex_category2)
		{
			$category_query1 = " ( (type1 = '$ex_category1' and type_sub1 = '$ex_category2') or (type2 = '$ex_category1' and type_sub2 = '$ex_category2') or (type3 = '$ex_category1' and type_sub3 = '$ex_category2') )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&search_sub_type=$ex_category2&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1] $TYPE_SUB[$ex_category2]</font> ";
		}
		elseif ($ex_category1 && $ex_category2 == '')
		{
			$category_query1 = " (type1 = '$ex_category1' or type2 = '$ex_category1' or type3 = '$ex_category1' )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1]"."</font> ";
		}
		else
		{
			$category_query1 = '';
		}
	}

	#지역별 검색 다시
	if ($ex_area1 == "전체" || $ex_area1 == '전국' || $_GET["search_si"] == "$SI_NUMBER[전국]")
	{
		$area_query1 = "";
	}
	elseif ($ex_area1 == "자동" )
	{
		#ex_area2도 자동일것임.
		$ex_area1 = $_GET["search_si"];
		$ex_area2 = $_GET["search_gu"];

		if ($ex_area1 && $ex_area2)
		{
			#시구까지 존재
			$area_query_total	= "
									(
										gu1		= '$ex_area2'
										or
										gu2		= '$ex_area2'
										or
										gu3		= '$ex_area2'
										or
										si1		= '$SI_NUMBER[전국]'
										or
										si2		= '$SI_NUMBER[전국]'
										or
										si3		= '$SI_NUMBER[전국]'
									)
			";

			$plus .= "search_si=$ex_area1&search_gu=$ex_area2&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] $GU[$ex_area2] 지역내 </font>";
			array_push($QUERY, "$area_query_total");
		}
		elseif ($ex_area1)
		{
			$area_query_total = "  ( (si1='$SI_NUMBER[전국]' or si2='$SI_NUMBER[전국]' or si3='$SI_NUMBER[전국]' ) or (si1='$ex_area1' or si2='$ex_area1' or si3='$ex_area1')   ) ";
			$plus .= "search_si=$ex_area1&search_gu=$ex_area2&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] 지역내</font>";
			array_push($QUERY, "$area_query_total");
		}
		else
		{
			$area_query_total = '';
			$plus .= "search_si=$ex_area1&";
		}
	}
	elseif ($ex_area1  )
	{
		#ex_area1 글자일때
		$ex_area1 = $SI_NUMBER[$ex_area1];
		$ex_area2 = $GU_NUMBER[$ex_area2];

		if ($ex_area1 && $ex_area2)
		{
			#시구까지 존재
			$area_query_total = "  ( (si1='$ex_area1' and gu1='$ex_area2') or (si2='$ex_area1' and gu2='$ex_area2') or (si3='$ex_area1' and gu3='$ex_area2') or (si1='$SI_NUMBER[전국]' or si2='$SI_NUMBER[전국]' or si3='$SI_NUMBER[전국]' ) or (si1='$ex_area1' and gu1='') or (si2='$ex_area1' and gu2='') or (si3='$ex_area1' and gu3='')   ) ";
			$plus .= "search_si=$ex_area1&search_gu=$ex_area2&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] $GU[$ex_area2] 지역내 </font>";
			array_push($QUERY, "$area_query_total");
		}
		elseif ($ex_area1)
		{
			$area_query_total = "  ( (si1='$SI_NUMBER[전국]' or si2='$SI_NUMBER[전국]' or si3='$SI_NUMBER[전국]' ) or (si1='$ex_area1' or si2='$ex_area1' or si3='$ex_area1')   ) ";
			$plus .= "search_si=$ex_area1&search_gu=$ex_area2&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1]지역내</font>";
			array_push($QUERY, "$area_query_total");
		}
		else
		{
			$area_query_total = '';
			$plus .= "search_si=$ex_area1&";
		}
	}


	//고용형태
	if ($ex_job_type == '전체')
	{
		$plus .= "";
	}
	elseif ($ex_job_type == '자동' )
	{
		//채용종류 검색 안되는 오류 있어서 추가 - sun
		if ($_GET['job_type_read'] != "" && $_GET['job_type_read'] != "전체")
		{
			$job_type_read2 = $_GET['job_type_read'];
		}
		//채용종류 검색 안되는 오류 있어서 추가 - sun

		//전체는 검색안하게 2018-10-22 kad
		if ( $_GET['job_type_read'] == "전체" )
		{
			$job_type_read2 = "";
		}
		//전체는 검색안하게 2018-10-22 kad

		if ($job_type_read2)
		{
			$type_search = "guin_type = '$job_type_read2' ";
			array_push($QUERY, "$type_search");
		}
	}
	elseif ($ex_job_type)
	{
		$type_search = "guin_type = '$ex_job_type' ";
		array_push($QUERY, "$type_search");
	}

	//희망연봉정리
	if ($pay_read) {
		$pay_search = "guin_pay = '$pay_read' ";
		array_push($QUERY, "$pay_search");
		$ai_comment .= "연봉"."(<font color=#AE029F>$pay_read</font>) ";
		$plus .= "pay_read=$pay_read&";
	}


	// 학력정리
	$job_type_read	= ( is_Array($_GET["job_type_read"]) )?@implode("___",$_GET["job_type_read"]):$_GET["job_type_read"];
	$edu_read		= ( is_Array($_GET["edu_read"]) )?@implode("___",$_GET["edu_read"]):$_GET["edu_read"];

	$job_type_read	= explode("___",$job_type_read);
	$edu_read		= explode("___",$edu_read);


	#최종학력 이상/이하 선택시
	if ( $_GET['guzic_school_type'] != '' && $_GET["edu_read"] != '' )
	{
		$edu_read	= $edu_read[0];
		$guin_in	= '';
		$plus		.= "edu_read=".$edu_read."&guzic_school_type=$_GET[guzic_school_type]&";
		$ai_comment .= " <font color=#AE06A0>$edu_read 학력 $_GET[guzic_school_type]</font> ";

		if (  $_GET['guzic_school_type'] == '이상' )
		{
			for ( $guin_key = array_search($edu_read, $edu_arr) ; $guin_key < sizeof($edu_arr) ; $guin_key++ )
			{
				$guin_in	.= ( $guin_in == '' )? '' : ',' ;
				$guin_in	.= "'". $edu_arr[$guin_key] ."'";
			}
		}
		else if (  $_GET['guzic_school_type'] == '이하' )
		{
			for ( $guin_key = array_search($edu_read, $edu_arr) ; $guin_key >= 0 ; $guin_key-- )
			{
				$guin_in	.= ( $guin_in == '' )? '' : ',' ;
				$guin_in	.= "'". $edu_arr[$guin_key] ."'";
			}
		}

		if ( $guin_in != '' )
		{
			//$WHERE	= " ( guin_edu in ( $guin_in ) OR guin_edu = '무관' )";
			$WHERE	= " ( guin_edu in ( $guin_in ) )"; //학력무관도 하나의 옵션으로
			array_push($QUERY, " $WHERE ");
		}
	}
	else if ( sizeof($edu_read) > 0 )
	{
		$WHERE_T	= "";
		for ( $i=0, $j=0, $max=sizeof($edu_read) ; $i<$max ; $i++ )
		{
			if ( str_replace(" ","",$edu_read[$i]) != "" )
			{
				$WHERE_T	.= ( $j != 0 )?" OR ":"";
				$WHERE_T	.= " guin_edu = '".$edu_read[$i]."' ";
				$plus		.= "edu_read[]=".$edu_read[$i]."&";
				$j++;
			}
		}
		#echo $WHERE_T;

		if ( $WHERE_T != "" )
		{
			//$WHERE_T	.= " OR guin_edu = '무관' ";
			//$ai_comment .= " <font color=#AE06A0>다중 학력</font> ";
			array_push($QUERY, " ( $WHERE_T ) ");
		}
	}

	#단순학력 추가됨
	if ( $_GET['guziceducation'] != '' )
	{
		array_push($QUERY, " ( guin_edu='".$_GET['guziceducation']."' ) ");
	}
	#단순학력 추가됨

	// 경력 정리
	if ($career_read == '무관' ) {
		$career_search  = "";
		$ai_comment .= " <font color=#7EA105>경력"."$career_read </font>";
	}
	else if ( $career_read == '신입' )
	{
		$career_search  = "(guin_career = '신입' or guin_career = '무관')";
		$ai_comment .= " <font color=#7EA105>경력"."$career_read </font>";
		array_push($QUERY, "$career_search");
	}
	else if ( $career_read == '경력' )//jobwork
	{
		$career_search	= "(guin_career = '경력' or guin_career = '무관')";
		$ai_comment .= " <font color=#7EA105>경력</font>";
		array_push($QUERY, "$career_search");
	}
	elseif ($career_read ) {
		//echo $career_read."<hr>";
		$ai_comment .= " <font color=#7EA105>경력"."$career_read </font>";
		$plus .= "career_read=$career_read&";

		$career_read_arr	= explode("~",$career_read);
		if ( sizeof($career_read_arr) == 2 )
		{
			$career_read_arr	= preg_replace("/\D/","",$career_read_arr);
			$career_search  = " (guin_career = '경력' or guin_career = '무관') AND ( CAST(guin_career_year as SIGNED) >= $career_read_arr[0] AND ( CAST(guin_career_year as SIGNED) <= $career_read_arr[1] ) )  ";
			array_push($QUERY, "$career_search");
		}
		else
		{
			$career_read	= preg_replace("/\D/","",$career_read);
			$career_search  = " (guin_career = '경력' or guin_career = '무관') and CAST(guin_career_year as SIGNED) >= $career_read  ";
			array_push($QUERY, "$career_search");
		}
	}

	if ( $_GET["grade_read"] != "" )
	{
		$grade_search  = " guin_grade = '$_GET[grade_read]' ";
		array_push($QUERY, "$grade_search");
		$ai_comment .= " <font color=#1EAd0v>$_GET[grade_read] </font>";
		$plus .= "grade_read=$_GET[grade_read]&";
	}

	$현재역이름	= "";
	#지하철 검색값 넘어왔을때 - 역세권
	if ( $_GET['underground1'] != '' )
	{
		array_push($QUERY, " underground1='$_GET[underground1]'");
		$Sql		= "SELECT title FROM $job_underground_tb WHERE number='$_GET[underground1]' ";
		$Tmp		= happy_mysql_fetch_array(query($Sql));
		$ai_comment	.= "<font color='#0066FF'>$Tmp[title]</font> ";
		$현재역이름	= "$Tmp[title] ";
	}
	if ( $_GET['underground2'] != '' )
	{
		array_push($QUERY, " underground2='$_GET[underground2]'");
		$Sql		= "SELECT title FROM $job_underground_tb WHERE number='$_GET[underground2]' ";
		$Tmp		= happy_mysql_fetch_array(query($Sql));
		$ai_comment	.= "<font color='#0066FF'>$Tmp[title]역</font> ";
		$현재역이름	.= "$Tmp[title]역 ";
	}



	#category_query 와 wait_query 를 where로 정리해보자
	if ($wait_query)
	{
		array_push($QUERY, "$wait_query");
	}


	if ($area_query_total)
	{
		array_push($QUERY, "$area_query_total");
	}

	if ( $hunting_use == true && ( $use_headhunting == '헤드헌팅' || $_GET['hunting'] == 'y' ) )//헤드헌팅
	{
		array_push($QUERY, "company_number != '0'");
	}

	//제목 키워드 정리
	if ($title_read) {
		$title_search = "(guin_title like '%$title_read%' OR guin_com_name  like '%$title_read%' OR keyword like '%$title_read%' )";
		array_push($QUERY, "$title_search");
	}

	#마지막 쿼리문정리
	$last_query = "where $add_query ";
	foreach ($QUERY as $list)
	{
		if ($list)
		{
			$last_query .= " $list and";
		}
	}
	#echo $last_query;


	//채용정보 점프
	//print_r($HAPPY_CONFIG);
	if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
	{
		$order = "최근등록순";
	}
	//채용정보 점프

	switch ( $order )
	{
		case "랜덤추출"		: $orderby	= " rand() ";break;
		case "최근등록순"		: $orderby	= " guin_date desc ";break;
		default				: $orderby	= " guin_choongwon asc, guin_end_date  asc ";break;
	}

	if ( $ex_type == "오늘본채용정보" )
	{
		$orderby	= $todayOrder;
	}

	$sql_today = date("Y-m-d");
	#####################################
	$sql = "select * from $guin_tb $last_query  (guin_end_date >= '$sql_today' or guin_choongwon ='1') $group_query order by $orderby limit $startLimit, $ex_limit";
	//print "$sql ";
	#####################################

	if ( $ticker_use == true ) //티커구인
	{
		return $sql;
	}

	$result = query($sql);
	$numb = mysql_num_rows($result);//총레코드수

	//$Sql	= "select Count(*) from $guin_tb $last_query  (guin_end_date >= '$sql_today' or guin_choongwon ='1') $group_query";
	//echo "구인추출쿼리 = ".$Sql;//구인추출쿼리
	//$Tmp	= happy_mysql_fetch_array(query($Sql));
	//$구인수	= $Tmp[0];

	#if ( !($numb) ){
	#	return $main_new_out = "[<font color=#0000C3>$ex_type</font> 광고가 없습니다]";
	#	exit;
	#}

	$i = "0";
	$OUT = array();
	$OUT_XML = array();
	$Happy_Img_Name = array();

	$rand_number	= rand(0,1000);
	$rand2			= rand(0,1000);
	$tplFileName	= "${rand_number}-$ex_job_type-$ex_type-New-$ex_template-$rand2";
	$TPL->define("$tplFileName", "./$skin_folder/$ex_template");
	$TPL->assign("$tplFileName");



	$ex_template_b	= str_replace(".html","_bold.html",$ex_template);
	$TPL->define("$tplFileName-bold", "./$skin_folder/$ex_template_b");
	$TPL->assign("$tplFileName-bold");



	//19금 일경우 아이콘 출력해 주자!
	//if(!$_COOKIE['ad_id'] && !$_COOKIE['adult_check'] && !$mem_id)
	//{
	//	$adult_check = "1";
	//}

	//성인인증여부 체크변수 성인증되면1 안되면0
	$adult_check = happy_adult_check();

	//echo $ex_template;

	//guin_main_extraction
	while  ($NEW = happy_mysql_fetch_array($result))
	{
		if ( $hunting_use == true && $NEW['company_number'] != 0 )
		{
			//헤드헌팅
			$sql = "select * from $job_company where number = '$NEW[company_number]'";
			$head_info = happy_mysql_fetch_assoc(query($sql));

			$NEW['guin_com_name'] = $head_info['company_name'];
			//echo $NEW['name'].':::'.$NEW['number'].'<br />';
		}

		$NEW["guin_pay_icon"]	= $want_money_img_arr[$NEW['guin_pay_type']];		#급여형식
		$NEW["guin_pay_icon2"]	= $want_money_img_arr2[$NEW['guin_pay_type']];	#급여형식

		preg_match("/<img(.*?)src=[\"|\'](.*?)[\"|\']/i",$NEW["guin_pay_icon"],$matches);
		$NEW["guin_pay_icon3"]	= $matches[2];	#급여형식이미지경로
		#10000원 또는 급여협의 등으로 추출할 태그가 없어서 추가함
		if ( $NEW["guin_pay"] == preg_replace("/\D/","",$NEW["guin_pay"]) )
		{
			$NEW["guin_pay"] = number_format($NEW["guin_pay"])."원";
		}

		// 급여조건(세전/세후)
		$NEW['pay_type_txt'] = ( $NEW['pay_type'] == 'gross' ) ? '세전' : '세후';

			//$NEW["guin_pay"] = number_format($NEW["guin_pay"])."원";
		#10000원 또는 급여협의 등으로 추출할 태그가 없어서 추가함

		$NEW['guin_modify'] = $NEW['guin_modify'] == '0000-00-00 00:00:00' ? "미수정" : $NEW['guin_modify'];

		//19금 일경우 아이콘 넣어 주자!
		$NEW[adult_guin_icon] = "";
		if( $adult_check != "1" && $NEW['use_adult'])
		{
			$NEW[adult_guin_icon] = "<img src=".$HAPPY_CONFIG['adult_guin_list']." border='0' alt='성인전용' align=absmiddle>";
			#echo $NEW[adult_guin_icon];
		}


		$j ='0'; #type
		$this_bold = "";
		$NEW[icon] = "";
		foreach ($ARRAY as $list)
		{
			$list_option = $list . "_option";

			if ($CONF[$list_option] == '기간별')
			{
				$NEW[$list] = $NEW[$list] - $real_gap; #날짜가 마이너스인 사람은 광고가 끝인사람임
			}

			if ($NEW[$list] > 0 && $j != '3')
			{
				#볼드는 아이콘을 안보여준다
				$NEW[icon] .= "<img src=$ARRAY_NAME2[$j] border=0 align=absmiddle>&nbsp;";
			}

			if ($NEW[$list] > 0 && $j == '3')
			{
				$this_bold = "1";
			}
			$j++;
		}
		#echo $NEW['icon']."<br>";

		if ( $subQuery != "" )
		{
			$Sql	= str_replace("kwak",$NEW["number"],$subQuery);
			query($Sql);
		}

		if ( $NEW[guin_choongwon] )
		{
			$NEW[guin_end_date] = "<span>상시채용</span>";
		}
		else
		{
			$tnow = date("Y-m-d H:i:s");

			if ( happy_date_diff($tnow,$NEW[guin_end_date]) < 0 )
			{
				$NEW['guin_end_date']	= "<span class='d_day' style='letter-spacing:0'>마감</span>";
			}
			else
			{
				$dday_interval = date("Y-m-d",strtotime($NEW["guin_end_date"]."-{$HAPPY_CONFIG[guin_end_date_dday]} day"));
				if(date("Y-m-d") == $NEW["guin_end_date"])
				{
					$NEW['guin_end_date']	= "D-day";
				}
				else if(date("Y-m-d") >= $dday_interval)
				{
					$NEW['guin_end_date']	= "<span class='d_day'>"."D-".happy_date_diff(date("Y-m-d"),$NEW['guin_end_date'])."</span>";
				}
			}
		}


		#경력 여부
		if ( $NEW[guin_career] == "경력" )
		{
			$NEW[guin_career] = "$NEW[guin_career_year]↑";
			//$NEW[guin_career] = "경력 $NEW[guin_career_year]↑";
		}

		$NEW['guin_grade']	= $NEW['guin_grade'] == '' ? $HAPPY_CONFIG['MsgNoInputGuinGrade1'] : $NEW['guin_grade'];

		$NEW['underground1']	= ( $NEW['underground1'] == 0 )? $HAPPY_CONFIG['MsgNoInputUnderground1'] :$undergroundTitle[$NEW['underground1']];
		$NEW['underground2']	= $undergroundTitle[$NEW['underground2']];

		$NEW["si1"]		= $siSelect[$NEW["si1"]] == '' ? $HAPPY_CONFIG['MsgNoInputArea1'] : $siSelect[$NEW["si1"]];
		$NEW["gu1"]		= $guSelect[$NEW["gu1"]] == '' ? '' : $guSelect[$NEW["gu1"]];
		$NEW["si2"]		= $siSelect[$NEW["si2"]] == '' ? $HAPPY_CONFIG['MsgNoInputArea1'] : $siSelect[$NEW["si2"]];
		$NEW["gu2"]		= $guSelect[$NEW["gu2"]] == '' ? '' : $guSelect[$NEW["gu2"]];
		$NEW["si3"]		= $siSelect[$NEW["si3"]] == '' ? $HAPPY_CONFIG['MsgNoInputArea1'] : $siSelect[$NEW["si3"]];
		$NEW["gu3"]		= $guSelect[$NEW["gu3"]] == '' ? '' : $guSelect[$NEW["gu3"]];
//echo $NEW[si1]."<br>";
		if ( $NEW[guin_choongwon] )
		{
			#$NEW[guin_choongwon] = "충원시";
			$NEW[guin_choongwon] = $HAPPY_CONFIG['MsgGuinChoongwon1'];
		}
		else
		{
			$NEW[guin_choongwon] = "$NEW[guin_end_date]";
		}

		if ( $NEW[guin_age] == "0" )
		{
			#$NEW[guin_age] = "제한 없음";
			$NEW[guin_age] = $HAPPY_CONFIG['MsgNoGuinAge1'];
		}
		else
		{
			$NEW[guin_age] = "$NEW[guin_age] 년 이후 출생자";
		}

		#채용분야
		$NEW[type]	= '';
		$NEW[type_short]	= '';
		if ($NEW[type1])
		{
			$TYPE_SUB{$NEW[type_sub1]}	= ( $TYPE_SUB{$NEW[type_sub1]} == '' )?"":$TYPE_SUB{$NEW[type_sub1]};
			$TYPE_SUB_SUB{$NEW[type_sub_sub1]}	= ( $TYPE_SUB_SUB{$NEW[type_sub_sub1]} == '' )?"":$TYPE_SUB_SUB{$NEW[type_sub_sub1]};

			$NEW[type]	.= $NEW[type] == '' ? '' : ', ';
			$NEW[type]	.= "".$TYPE{$NEW[type1]} ;
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB{$NEW[type_sub1]} != '' ? "-" . $TYPE_SUB{$NEW[type_sub1]} : '';
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB_SUB{$NEW[type_sub1]} != '' ? "-" . $TYPE_SUB_SUB{$NEW[type_sub1]} : '';

			$NEW[type_short]	.= $NEW[type_short] == '' ? '' : ', ';
			$NEW[type_short]	.= "".$TYPE{$NEW[type1]} ;
		}

		if ($NEW[type2])
		{
			$TYPE_SUB{$NEW[type_sub2]}	= ( $TYPE_SUB{$NEW[type_sub2]} == '' )?"":$TYPE_SUB{$NEW[type_sub2]};
			$TYPE_SUB_SUB{$NEW[type_sub_sub2]}	= ( $TYPE_SUB_SUB{$NEW[type_sub_sub2]} == '' )?"":$TYPE_SUB_SUB{$NEW[type_sub_sub2]};

			$NEW[type]	.= $NEW[type] == '' ? '' : ', ';
			$NEW[type]	.= "".$TYPE{$NEW[type2]} ;
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB{$NEW[type_sub2]} != '' ? "-" . $TYPE_SUB{$NEW[type_sub2]} : '';
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB_SUB{$NEW[type_sub2]} != '' ? "-" . $TYPE_SUB_SUB{$NEW[type_sub2]} : '';

			$NEW[type_short]	.= $NEW[type_short] == '' ? '' : ', ';
			$NEW[type_short]	.= "".$TYPE{$NEW[type2]} ;
		}

		if ($NEW[type3])
		{
			$TYPE_SUB{$NEW[type_sub3]}	= ( $TYPE_SUB{$NEW[type_sub3]} == '' )?"":$TYPE_SUB{$NEW[type_sub3]};
			$TYPE_SUB_SUB{$NEW[type_sub_sub3]}	= ( $TYPE_SUB_SUB{$NEW[type_sub_sub3]} == '' )?"":$TYPE_SUB_SUB{$NEW[type_sub_sub3]};
			$NEW[type]	.= $NEW[type] == '' ? '' : ', ';
			$NEW[type]	.= "".$TYPE{$NEW[type3]} ;
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB{$NEW[type_sub3]} != '' ? "-" . $TYPE_SUB{$NEW[type_sub3]} : '';
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB_SUB{$NEW[type_sub3]} != '' ? "-" . $TYPE_SUB_SUB{$NEW[type_sub3]} : '';

			$NEW[type_short]	.= $NEW[type_short] == '' ? '' : ', ';
			$NEW[type_short]	.= "".$TYPE{$NEW[type3]} ;
		}

		$NEW[type]	= $NEW[type] == '' ? "<font color='gray'>".$HAPPY_CONFIG['MsgNoInputType1']."</font>":$NEW[type];

		#xml 출력
		$NEW['type_xml'] = htmlspecialchars($NEW['type']);
		$NEW['title_xml'] = htmlspecialchars($NEW['guin_title']);


		/////////////////날짜 자르고 비교하기
		$chk_guin_date = explode(" ",$NEW[guin_date]);
		$today = date("Y-m-d");

		if ( $chk_guin_date[0] == $today )
		{
			#$NEW[new_icon] = "<img src='bbs_img/icon_new.gif' align=absmiddle>&nbsp; ";
			$NEW[new_icon] = "<img src='".$HAPPY_CONFIG['IconGuinNew1']."' align=absmiddle>";
		}
		else
		{
			$NEW[new_icon] = "";
		}


		$NEW[title]				= kstrcut($NEW[guin_title], $ex_title_cut, "...");
		$NEW[title_no_color]	= $NEW[title];


		if ($this_bold)
		{
			$NEW[title] = "<font style='color:$guin_title_color; font-weight:$guin_title_bold;'>$NEW[title]</font>";
			//$NEW['title_xml'] = htmlspecialchars($NEW[title]);
		}

		$NEW[name] = kstrcut($NEW[guin_com_name], 20, "...");
		$NEW["guin_date_cut"]	= substr($NEW["guin_date"],0,10);

		#업체로고구하기
		#bnl 로고 , bns 배너광고용
		//photo3 채용정보 추출시 작은 배너
		//photo2 회사소개에서 쓰이는 큰 이미지
		$Tmem = happy_member_information($NEW['guin_id']);
		//$bns_img = $Tmem['photo2'];
		//$bnl_img = $Tmem['photo3'];

		//개별 채용정보에 저장된 이미지를 사용하기 위해서 DB 컨버팅함
		//update job_guin set photo2 = (select photo2 from happy_member where user_id = guin_id), photo3 = (select photo3 from happy_member where user_id = guin_id)
		$bns_img = $NEW['photo2'];
		$bnl_img = $NEW['photo3'];
		$NEW['com_name'] = $Tmem['com_name'];


		#echo $bns_img." // ".$bnl_img." // ".$NEW['use_adult']."  <br>";

		if ( $bnl_img == "" )
		{
			if( $adult_check != "1" && $NEW['use_adult'] )
			{
				$NEW[logo] = $HAPPY_CONFIG['adult_guin'];
				$Happy_Img_Name[0] = "./".$HAPPY_CONFIG['adult_guin'];
				/*
					[adult_guin] => upload/happy_config/adult_guin.gif
					[adult_guin_list] => upload/happy_config/adult_guin_list.gif
					[adult_guzic] => upload/happy_config/adult_guzic.gif
					[adult_guzic_list] => upload/happy_config/adult_guzic_list.gif
				*/
			}
			else
			{
				$NEW[logo] = "./".$HAPPY_CONFIG['IconComNoLogo1']."";
			}
		}
		else
		{
			//2010-09-30 Hun 추가함 19금에 걸릴 경우.. 19금 이미지를 넣어주자!
			if( $adult_check != "1" && $NEW['use_adult'])
			{
				$NEW[logo] = $HAPPY_CONFIG['adult_guin'];
				$Happy_Img_Name[0] = "./".$HAPPY_CONFIG['adult_guin'];
			}
			else	//기존소스 입니다.
			{
				$logo_img = explode(".",$bnl_img);

				//회사로고 gif 원본출력여부 hong
				if ( $is_logo_gif_org_print && preg_match("/gif/i",$logo_img[1]) )
				{
					$logo_temp = $logo_img;
				}
				else
				{
					$logo_temp = $logo_img[0].".".$logo_img[1];
				}

				if ( file_exists("./$logo_temp" ) )
				{
					$NEW[logo] = "./$logo_temp";
					$Happy_Img_Name[0] = "./".$logo_temp;
				}
				else
				{
					$NEW[logo] = "./$bnl_img";
				}
			}
		}
		#echo $NEW[logo];
		if ( $bns_img == "" )
		{
			$NEW[com_logo] = "./".$HAPPY_CONFIG['IconComNoBanner1']."";
		}
		else
		{
			$banner_img = explode(".",$bns_img);

			//회사로고 gif 원본출력여부 hong
			if ( $is_logo_gif_org_print && preg_match("/gif/i",$banner_img[1]) )
			{
				$banner_temp = $banner_img;
			}
			else
			{
				$banner_temp = $banner_img[0].".".$banner_img[1];
			}

			if ( file_exists("./$banner_temp" ) )
			{
				$NEW[com_logo] = "./$banner_temp";
				$Happy_Img_Name[0] = "./".$banner_temp;
			}
			else
			{
				$NEW[com_logo] = "./$bns_img";
			}
		}

		#볼드
		$list			= $ARRAY[3];
		$list_option	= $list . "_option";
		$bold_option = 0;

		if ($CONF[$list_option] == '기간별')
		{
			//$NEW[$list] = $NEW[$list] - $real_gap; #날짜가 마이너스인 사람은 광고가 끝인사람임
			if ( $NEW[$list] > 0 )
			{
				$bold_option = 1;
			}
		}
		else
		{
			if ( $NEW[$list] > 0 )
			{
				$bold_option = 1;
			}
		}

		#bgcolor 옵션
		$NEW['bgcolor1'] = "";
		$NEW['bgcolor2'] = "";
		$list = $ARRAY[10];
		$list_option = $list . "_option";
		//echo $list."<br>";
		//echo $NEW[$list].":".$real_gap."<br>";
		if ($CONF[$list_option] == '기간별')
		{
			//$NEW[$list] = $NEW[$list] - $real_gap;
			if ( $NEW[$list] > 0 )
			{
				if($NEW['guin_bgcolor_select'] == '')
				{
					$NEW['guin_bgcolor_select'] = $guin_title_bgcolor;
				}
				$NEW['bgcolor1'] = "<span style='margin:5px 0; padding:2px; box-sizing:border-box; background:$NEW[guin_bgcolor_select];'>";
				$NEW['bgcolor2'] = "</span>";
			}
		}

		#아이콘옵션
		$NEW['freeicon_com_out'] = "";
		$list = $ARRAY[11];
		$list_option = $list . "_option";

		if ($CONF[$list_option] == '기간별')
		{
			//$NEW[$list] = $NEW[$list] - $real_gap;
			if ( $NEW[$list] > 0 )
			{
				if ( $NEW['freeicon_com'] != '' )
				{
					$NEW['freeicon_com_out'] = '<img src="img/'.$NEW['freeicon_com'].'" align=absmiddle>';
				}
			}
		}

		$tplFileNameOut	= ( $bold_option == 1 )?$tplFileName."-bold":$tplFileName;

		#채용형태는 아이콘으로 추가됨
		$NEW['guin_type_icon'] = guin_type_icon($NEW['guin_type']);

		#활동가능요일
		$TempDays = explode(" ",$NEW['work_day']);
		$NEW['work_day'] = '';
		foreach($TempDays as $k => $v)
		{
			$Yicon = $TDayIcons[$v];
			if ( $v != '' )
			{
				$NEW['work_day'] .= '<img src="'.$Yicon.'" border="0" align="absmiddle">';
			}
		}
		if ( $NEW['work_day'] == '' )
		{
			$NEW['work_day'] = $HAPPY_CONFIG['MsgNoInputDay1'];
		}
		#활동가능요일

		#근무시간
		if ( $NEW['start_worktime'] != '' )
		{
			$TStartWorkTime = explode("-",$NEW['start_worktime']);
			$NEW['start_worktime'] = $TStartWorkTime[0]." ".$TStartWorkTime[1]."시".$TStartWorkTime[2];
		}
		else
		{
			$NEW['start_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
		}

		if ( $NEW['finish_worktime'] != '' )
		{
			$TFinishWorkTime = explode("-",$NEW['finish_worktime']);
			$NEW['finish_worktime'] = $TFinishWorkTime[0]." ".$TFinishWorkTime[1]."시".$TFinishWorkTime[2];
		}
		else
		{
			$NEW['finish_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
		}

		#구직자
		if ( $NEW['guinperson'] == '' )
		{
			$NEW['guinperson'] = $HAPPY_CONFIG['MsgNoInputguzicperson1'];
		}

		#학력
		if ( $NEW['guineducation'] == '' )
		{
			$NEW['guineducation'] = $HAPPY_CONFIG['MsgNoInputguziceducation1'];
		}

		#국적
		if ( $NEW['guinnational'] == '' )
		{
			$NEW['guinnational'] = $HAPPY_CONFIG['MsgNoInputguzicnational1'];
		}

		#파견업체
		if ( $NEW['guinsicompany'] == '' )
		{
			$NEW['guinsicompany'] = $HAPPY_CONFIG['NoInputguzicsicompany1'];
		}



		//리스트에서 스크랩하기 기능 추가
		$스크랩버튼				= "";
		$스크랩버튼2			= "";
		$script_scrap_empty		= "onClick=\"happy_scrap_change('per','per',$NEW[number],1,$guin_main_extraction_count);\"";
		$script_scrap_fill		= "onClick=\"happy_scrap_change('per','per_del',$NEW[number],1,$guin_main_extraction_count);\"";
		$script_scrap_empty2	= "onClick=\"happy_scrap_change('per','per',$NEW[number],2,$guin_main_extraction_count);\"";
		$script_scrap_fill2		= "onClick=\"happy_scrap_change('per','per_del',$NEW[number],2,$guin_main_extraction_count);\"";
		$scrap_msg_id			= "<span id='per_scrap_msg_{$guin_main_extraction_count}_{$NEW[number]}' style='display:none'></span>";
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$scrap_img_empty	= "<img src='mobile_img/star_ico_01.png' alt='☆' $script_scrap_empty style='vertical-align:middle'>";
			$scrap_img_fill		= "<img src='mobile_img/star_ico_fill_01.png' alt='★' $script_scrap_fill style='vertical-align:middle'>";
			$scrap_img_empty2	= "<img src='mobile_img/star_ico_02.png' alt='☆2' $script_scrap_empty2 style='vertical-align:middle'>";
			$scrap_img_fill2	= "<img src='mobile_img/star_ico_fill_02.gif' alt='★2' $script_scrap_fill2 style='vertical-align:middle'>";
		}
		else
		{
			$scrap_img_empty	= "<img src='img/star_ico_01.png' alt='☆' $script_scrap_empty style='vertical-align:middle'>";
			$scrap_img_fill		= "<img src='img/star_ico_fill_01.png' alt='★' $script_scrap_fill style='vertical-align:middle'>";
			$scrap_img_empty2	= "<img src='img/star_ico_02.png' alt='☆2' $script_scrap_empty2 style='vertical-align:middle'>";
			$scrap_img_fill2	= "<img src='img/star_ico_fill_02.gif' alt='★2' $script_scrap_fill2 style='vertical-align:middle'>";
		}


		if ( $happy_member_login_value == "" )
		{
			$스크랩버튼		= "<a href=\"javascript:void(0);\" onclick=\"if(confirm('로그인 후 이용 가능한 서비스입니다.\\n지금 로그인 하시겠습니까?')){location.replace('happy_member_login.php?returnUrl=$_SERVER[PHP_SELF]');}\" style='vertical-align:middle'>$scrap_img_empty</a>";
			$스크랩버튼2		= "<a href=\"javascript:void(0);\" onclick=\"if(confirm('로그인 후 이용 가능한 서비스입니다.\\n지금 로그인 하시겠습니까?')){location.replace('happy_member_login.php?returnUrl=$_SERVER[PHP_SELF]');}\" style='vertical-align:middle'>$scrap_img_empty2</a>";
		}
		else if ( !$스크랩권한 )
		{
			$스크랩버튼		= "<a href='javascript:void(0);' onclick='alert(\"스크랩 권한이 없습니다.\");'>$scrap_img_empty<a>";
			$스크랩버튼2		= "<a href='javascript:void(0);' onclick='alert(\"스크랩 권한이 없습니다.\");'>$scrap_img_empty2<a>";
		}
		else if ( $스크랩권한 && $happy_member_login_value != "" )
		{
			$Sql	= "SELECT Count(*) FROM $scrap_tb WHERE cNumber='$NEW[number]' AND userid='$happy_member_login_value' AND userType='per' ";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			if ( $Tmp[0] == 0 )
			{
				$returnUrl	= $_SERVER["REQUEST_URI"];
				$returnUrl	= str_replace("&","??",$returnUrl);

				$스크랩버튼		= "<span id='per_scrap_img_{$guin_main_extraction_count}_{$NEW[number]}' style='cursor:pointer;     vertical-align: middle;'>".$scrap_img_empty."</span> $scrap_msg_id";
				$스크랩버튼2	= "<span id='per_scrap_img_{$guin_main_extraction_count}_{$NEW[number]}' style='cursor:pointer;     vertical-align: middle;'>".$scrap_img_empty2."</span> $scrap_msg_id";
			}
			else
			{
				$스크랩버튼		= "<span id='per_scrap_img_{$guin_main_extraction_count}_{$NEW[number]}' style='cursor:pointer; vertical-align:middle '>".$scrap_img_fill."</span> $scrap_msg_id";
				$스크랩버튼2	= "<span id='per_scrap_img_{$guin_main_extraction_count}_{$NEW[number]}' style='cursor:pointer; vertical-align:middle'>".$scrap_img_fill2."</span> $scrap_msg_id";
			}
		}
		//리스트에서 스크랩하기 기능 추가


		$main_new = &$TPL->fetch("$tplFileNameOut");
		array_push($OUT,$main_new);
		array_push($OUT_XML,$main_new);
		$i ++;
	}

	$main_new_out = '';

	if ($extract_type == "모바일스크롤")
	{
		$mobile_scroll_count++;					//모바일스크롤 그룹 추출태그개수
		$paging_limit	= 1;					//모바일스크롤 그룹 페이징개수
		if ($numb >= $ex_width)
		{
			for ($pp=$ex_width; $numb>$pp; $pp=($pp+$ex_width))
			{
				$paging_limit++;
			}
		}



		//모바일스크롤 그룹별 이미지체인징
		$main_new_out .= "
				<script>
					var stabSPhoto_on_{$mobile_scroll_count} = new Array() ;
					var stabSPhoto_off_{$mobile_scroll_count} = new Array() ;
					for (i=0; i<{$paging_limit}; i++){
					 stabSPhoto_on_{$mobile_scroll_count}[i] = new Image() ;
					 stabSPhoto_on_{$mobile_scroll_count}[i].src = 'mobile_img/water_drop_on.gif' ;
					 stabSPhoto_off_{$mobile_scroll_count}[i] = new Image() ;
					 stabSPhoto_off_{$mobile_scroll_count}[i].src = 'mobile_img/water_drop_off.gif' ;
					}
					var stabSPhotoImgName_{$mobile_scroll_count} ;


					function stabSPhotoAct_{$mobile_scroll_count}(c_num,now_index)
					{
						for (i=0; i<{$paging_limit}; i++)
						{
							stabSPhotoImgName_{$mobile_scroll_count} = 'stabSPhoto_'+c_num+'_' + i ;
							document.images[stabSPhotoImgName_{$mobile_scroll_count}].src = stabSPhoto_off_{$mobile_scroll_count}[i].src ;
						}
						stabSPhotoImgName_{$mobile_scroll_count} = 'staPhoto_'+c_num+'_' + now_index ;
						document.images[stabSPhotoImgName_{$mobile_scroll_count}].src = stabSPhoto_on_{$mobile_scroll_count}[now_index].src ;
					}bS
				</script>
		";
		//모바일스크롤 그룹별 이미지체인징 END
	}
	if ($paging_limit > 1) //페이징 필요없다면 id를 안줘서 돌지않게한다
	{
		$container_id	= "id='container_{$mobile_scroll_count}'";
		$prev_id		= "id='prev_{$mobile_scroll_count}'";
		$next_id		= "id='next_{$mobile_scroll_count}'";
	}





	#main_new_out 정리
	#if ( $ex_type != "뉴스티커" )
	if ($extract_type == "모바일스크롤") //모바일스크롤 추출물 디자인 감싸기 시작
	{
		$main_new_out .= "<div $container_id class='container' style='border:0px solid #0000ff; width:100%;'>";
	}
	else if ( $return_type != "xml" )
	{
		$main_new_out = "\n\n<table  width=100% border=0 cellspacing='0' cellpadding='0' border='0'>";
	}

	$tmp_width = 100 / $ex_width;
	$tmp_width = round($tmp_width,0);
	$tmp_width .= '%';

	$ex_template	= str_replace(".html","_no.html",$ex_template);
	#$NEW[logo] = "./img/no_ad.gif";	#확인안됨


	$TPL->define("공백_${rand_number}", "./$skin_folder/$ex_template");
	$TPL->assign("공백_${rand_number}");
	$blank_ad = &$TPL->fetch("공백_${rand_number}");

	if ($ex_width == '나중에필요시1로값변경')
	{
		#가로로 한줄만 출력할때는 빈공백출력이 없다.
		$ex_limit = $i ;
		if ($i == '0')
		{
			return print $main_new_out = "<center><font color=red>$ex_type</font><br>가 없습니다" ;
		}
	}
	//extraction_type 기능 추가함.		hun 2019-02-01
	//총개수 80개, 가로 4개 설정하면 원래는 가로4개씩 세로 20개가 생성되는 상태이며 정보가 없을 경우 등록대기중 rows 가 출력되는 상태.
	//$extraction_type 에 자동 값으로 전달 받으면 정보가 3개 밖에 없을 경우에는 3개 + 등록대기중 1개만 추가하여 보여주고
	//정보가 4개 밖에 없을 경우에는 4 + 등록대기중 4개만 보여줌으로 채용정보 유료 자리가 남아 있음을 보여주기 위한 기능.
	//기존에는 무조건 개수만큼 등록대기 중으로는 나오는 기능이였음.
	else if( $extraction_type == '자동' )
	{
		#echo "i = $i / ex_width = $ex_width / ex_limit = $ex_limit <br>";
		if( $ex_limit > $i )
		{
			if( $i > 0 )
			{
				$Rows나머지		= ( $i % $ex_width );
				if( $Rows나머지 > 0 )
				{
					$ex_limit		= $i + ( $ex_width - $Rows나머지 );
				}
				else
				{
					$ex_limit		= $i + $ex_width;
				}
			}
			else
			{
				$ex_limit		= $ex_width;
			}
		}
		#echo "i = $i / ex_width = $ex_width / ex_limit = $ex_limit <br>";
	}

	if ( $ex_type == "오늘본채용정보" && $i == '0' )
	{
		return print $main_new_out = "<center><font color=red>$ex_type</font><br>가 없습니다" ;
	}

	for ($out_p ='0' ; $out_p < $ex_limit ; $out_p ++)
	{
		#if (!$OUT[$out_p] && $ex_type != "뉴스티커" && $ex_type != "오늘본채용정보" && || !preg_match("/_flash/",$ex_type_extension) )
		if (!$OUT[$out_p] && $ex_type != "뉴스티커" && $ex_type != "오늘본채용정보" && $return_type != "xml" )
		{
			$OUT[$out_p] = "$blank_ad";
		}
		$k = $out_p % $ex_width;
		#TD를 정리하자
		if ($extract_type == "모바일스크롤")
		{

			$out_p2 = $out_p+1;

			//echo $out_p2."<br>";

			if ($ex_width == '1')
			{
				$main_new_out.= "<div class='panel' style='border:0px solid #0000ff; width:100%;'><table width='100%'><tr>" . $OUT[$out_p] . "</tr></table></div>\n\n";
			}
			elseif ($out_p2 % $ex_width == "1")
			{
				if ($numb == $out_p2)
				{
					$main_new_out.= "<div class='panel' style='border:0px solid #0000ff; width:100%;'><table width='100%'><tr>" . $OUT[$out_p] . "</tr></table></div>";
				}
				else
				{
					$main_new_out.= "<div class='panel' style='border:0px solid #0000ff; width:100%;'><table width='100%'><tr>" . $OUT[$out_p] . "";
				}
			}
			elseif ($out_p2 % $ex_width == "0")
			{
				$main_new_out.= "" . $OUT[$out_p] . "</tr></table></div>\n\n";
			}
			else
			{
				if ($numb == $out_p2)
				{
					$main_new_out.= "" . $OUT[$out_p] . "</tr></table></div>\n\n";
				}
				else
				{
					$main_new_out.= "" . $OUT[$out_p] . "";
				}
			}

		}
		else
		{

			#if ( $ex_type == "뉴스티커" )
			if ( $return_type == "xml" )
			{
				$main_new_out .= $OUT[$out_p];
			}
			elseif ($ex_width == "1")
			{
				$main_new_out .= "<tr><td class='type' valign=top align=center width=$tmp_width>" . $OUT[$out_p] . "</td></tr>\n";
			}
			elseif ($out_p % $ex_width == "0")
			{
				$main_new_out .= "<tr><td class='type'  valign=top align=center width=$tmp_width>" . $OUT[$out_p] . "</td>\n";
			}
			elseif ($out_p % $ex_width == $ex_width - 1)
			{
				$main_new_out .= "<td class='type'  valign=top align=center width=$tmp_width>" . $OUT[$out_p] . "</td></tr>\n";
			}
			else
			{
				$main_new_out .= "<td class='type'  valign=top align=center width=$tmp_width>" . $OUT[$out_p] . "</td>\n";
			}
		}
	}


	if ($extract_type == "모바일스크롤")
	{
		$main_new_out .= "</div>\n\n"; //모바일스크롤 추출물 디자인 감싸기 끝

		//모바일스크롤 페이징
		$main_new_out .= "
				<div id='navigator_{$mobile_scroll_count}' class='navigator'>
				<p>
					<img src='mobile_img/slide_prev.gif' style='vertical-align:middle;' $prev_id>
		";

		for ($pp=0;$pp<$paging_limit;$pp++)
		{
			if ($pp == 0)
			{
				$main_new_out .= "
							<img src='mobile_img/water_drop_on.gif' border='0' style='vertical-align:middle;' name='stabSPhoto_{$mobile_scroll_count}_{$pp}'>
				";
			}
			else
			{
				$main_new_out .= "
							<img src='mobile_img/water_drop_off.gif' border='0' style='vertical-align:middle;' name='stabSPhoto_{$mobile_scroll_count}_{$pp}'>
				";
			}
		}

		$main_new_out .= "
					<img src='mobile_img/slide_next.gif' style='vertical-align:middle;' $next_id>
				</p>
			</div>

			<script>
				$('#prev_{$mobile_scroll_count}').click(function(){
					$('#container_{$mobile_scroll_count}').trigger('cf-slide-panel-prev');
				});
				$('#next_{$mobile_scroll_count}').click(function(){
					$('#container_{$mobile_scroll_count}').trigger('cf-slide-panel-next');
				});


				$('#container_{$mobile_scroll_count}').cfSlidePanel({
					getIndex: function(index) {
						stabSPhotoAct_{$mobile_scroll_count}({$mobile_scroll_count},index);
						$('#navigator_{$mobile_scroll_count} .index').text(index + 1);		// index가 zero-base(0부터 시작)로 오기 때문에 1을 더해줌
					}
				});
			</script>
		";
	}
	#if ( $ex_type != "뉴스티커" )
	else if ( $return_type != "xml" )
	{
		$main_new_out .= "</table>";
	}
	#else if ( $ex_type_extension == '뉴스티커_flash' )
	else if ( $return_type == "xml" )
	{
		#$OUT 를 재가공하자
		#print_r2($OUT_XML);
		$xml_return = '';
		foreach ( $OUT_XML as $k => $v)
		{
			$xml_return .= $v;
		}
		return $xml_return;
	}
	else
	{
		$main_new_out	= str_replace("\r","",str_replace("\n","--",$main_new_out));
		$main_new_out	= preg_replace("/--$/","",$main_new_out);
		$main_new_out = addslashes($main_new_out);

		$main_new_out	= "
			<span style=\"width: 100%; position: relative; height=100%\" id=\"main2\">
			<div style=\"left: 10px; width: 100%; clip: rect(0px 100% 12px 0px); position: absolute; top: 0px; height: 13px\" onMouseover=\"bMouseOver=0\" onMouseout=\"bMouseOver=1\" id=\"scroll_image\">
				<script>
					startscroll(\"$main_new_out\");
				</script>
			</div>
			</span>
		";
	}

	return print $main_new_out;
}


######################################################

$section_ajax_num	= 1;

function guin_extraction_ajax($ex_limit,$ex_width,$ex_title_cut,$ex_category1,$ex_category2,$ex_area1,$ex_area2,$ex_type,$ex_job_type,$ex_template,$startLimit="",$ex_paging="사용안함",$ex_extraction_type="",$ex_order="",$ex_option="",$loading_type="",$ex_guin_career="",$use_headhunting="")//jobwork 17
{
	global $section_ajax_num;
	global $HAPPY_CONFIG,$happy_wide_map_fileName;
	global $현재역이름,$job_underground_tb;

	//스크랩 버튼 처리 hong
	global $guin_main_extraction_count;
	$section_ajax_num = ( $guin_main_extraction_count > 0 ) ? $guin_main_extraction_count : $section_ajax_num;


	$현재역이름	= "";
	#지하철 검색값 넘어왔을때 - 역세권
	if ( $_GET['underground1'] != '' )
	{
		$Sql		= "SELECT title FROM $job_underground_tb WHERE number='$_GET[underground1]' ";
		$Tmp		= happy_mysql_fetch_array(query($Sql));
		$ai_comment	.= "<font color='#0066FF'>$Tmp[title]</font> ";
		$현재역이름	= "$Tmp[title] ";
	}
	if ( $_GET['underground2'] != '' )
	{
		$Sql		= "SELECT title FROM $job_underground_tb WHERE number='$_GET[underground2]' ";
		$Tmp		= happy_mysql_fetch_array(query($Sql));
		$ai_comment	.= "<font color='#0066FF'>$Tmp[title]역</font> ";
		$현재역이름	.= "$Tmp[title]역 ";
	}

	$idName		= "section_ajax_$section_ajax_num";
	$layerName	= "section_ajax_layer_$section_ajax_num";

	$value		= urlencode("$ex_limit,$ex_width,$ex_title_cut,$ex_category1,$ex_category2,$ex_area1,$ex_area2,$ex_type,$ex_job_type,$ex_template,$startLimit,$ex_paging,$ex_extraction_type,$ex_order,$ex_option,$loading_type,$ex_guin_career,$use_headhunting");//jobwork

	$query_string = "&".$_SERVER['QUERY_STRING'];

	//echo "loading_type = $loading_type ::: ex_paging = $ex_paging";

	if ( $loading_type == '' )
	{
		$content	= "
						<div id='$layerName' name='$layerName' $layerOption>
							<table width='100%' height='100%'>
								<tr>
									<td align='center' height='200'><img src='img/ajax_loading.gif'></td>
								</tr>
							</table>
						</div>

						<input type='hidden' id='$idName' name='$idName' value=\"$value\">
						<input type='hidden' id='happy_map_latlng' name='happy_map_latlng' value=\"\">

						<script>
							var ajax$section_ajax_num	= new GLM.AJAX();

							ajax${section_ajax_num}.callPage(
									'ajax_guin_list.php?ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}&${query_string}&vals='+document.getElementById('$idName').value + '&happy_ajax_map_start=ok'
									,
									function(response)
									{
										//alert(response);
										Temp		= response.split('___C_COUNT___');
										response	= Temp[0];
										Counting	= Temp[1];

										if ( document.getElementById('guin_counting') != undefined )
										{
											document.getElementById('guin_counting').innerHTML = Counting;
										}

										document.getElementById('$layerName').innerHTML	= response;

										//setTimeout('happy_map_my_point_change_end()',1500);
										//happy_map_markAdd_ALL();
									}
							);



							//alert('ajax_guin_list.php?vals='+document.getElementById('$idName').value);
						</script>
		";

	}
	else
	{
		$content	= "
						<div id='$layerName' name='$layerName' $layerOption>
							<table width='100%' height='100%'>
								<tr>
									<td align='center' height='200'><img src='img/ajax_loading.gif'></td>
								</tr>
							</table>
						</div>

						<input type='hidden' id='$idName' name='$idName' value=\"$value\">
						<input type='hidden' id='map_point_now' name='map_point_now' value=\"$_GET[map_point]\">
						<input type='hidden' id='happy_map_latlng' name='happy_map_latlng' value=\"\">

						<script>
							var ajax${section_ajax_num}	= new GLM.AJAX();


							var ajax${section_ajax_num}_func	= function()
							{
								ajax${section_ajax_num}.callPage(
										'ajax_guin_list.php?map_point=$_GET[map_point]&file=$_GET[file]&ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}&${query_string}&vals='+document.getElementById('$idName').value+'&happy_ajax_map_start=ok',
										function(response)
										{
											//alert(response);

											Temp		= response.split('___C_COUNT___');
											response	= Temp[0];
											Counting	= Temp[1];

											if ( document.getElementById('guin_counting') != undefined )
											{
												document.getElementById('guin_counting').innerHTML = Counting;
											}

											document.getElementById('$layerName').innerHTML	= response;
										}
								);
							}

							oldonload = window.onload;

							if ( typeof window.onload != 'function' )
							{
								//window.onload = ajax${section_ajax_num}_func;
								window.onload	= function() { setTimeout('happy_map_my_point_change_end()',1500); }
							}
							else
							{
								window.onload = function() {
									oldonload();
									//ajax${section_ajax_num}_func();
									setTimeout('happy_map_my_point_change_end()',1500);
								}
							}

							//alert('ajax_guin_list.php?vals='+document.getElementById('$idName').value);
						</script>
		";
	}


	#구인구직은 페이징옵션이 없음
	if ( $ex_paging != '사용안함' )
	{
		//PC화면
		if ( $_COOKIE['happy_mobile'] != 'on' )
		{
			$content	.= "
				<script>

					function gopaging${section_ajax_num}( pageNo )
					{
						scrollToAnchor('guin_list_top');

						document.getElementById('$layerName').innerHTML	= \"<table width='100%' height='100%'><tr><td align=center height='200'><img src='img/ajax_loading.gif'></td></tr></table>\";


						ajax${section_ajax_num}.callPage(
								'ajax_guin_list.php?ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}${query_string}&start='+pageNo+'&vals='+document.getElementById('$idName').value,
								function(response) {
									//alert(response);

									Temp		= response.split('___C_COUNT___');
									response	= Temp[0];
									Counting	= Temp[1];

									document.getElementById('$layerName').innerHTML	= response;
								}
						);
					}

				</script>
			";
		}
		//모바일
		else
		{
			if ( $_SERVER['PHP_SELF'] != $happy_wide_map_fileName )
			{
				$content	.= "
					<script>

						function gopaging${section_ajax_num}( pageNo )
						{
							document.getElementById('$layerName').innerHTML	= \"<table width='100%' height='100%'><tr><td align=center height='200'><img src='img/ajax_loading.gif'></td></tr></table>\";


							ajax${section_ajax_num}.callPage(
									'ajax_guin_list.php?ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}${query_string}&start='+pageNo+'&vals='+document.getElementById('$idName').value,
									function(response) {
										//alert(response);

										Temp		= response.split('___C_COUNT___');
										response	= Temp[0];
										Counting	= Temp[1];

										document.getElementById('$layerName').innerHTML	= response;
									}
							);
						}

					</script>
				";
			}
			else if( $HAPPY_CONFIG['wide_map_type'] == 'google' && $_SERVER['PHP_SELF'] == $happy_wide_map_fileName )
			{
				$map_point_script		= "map_point='+map_point";
				$map_size_script		= "'&map_size='+happy_map_mapObj.getZoom()";

				$content	.= "
					<script>

						function gopaging${section_ajax_num}( pageNo )
						{
							document.getElementById('$layerName').innerHTML	= \"<table width='100%' height='100%'><tr><td align=center height='200'><img src='img/ajax_loading.gif'></td></tr></table>\";

								//alert(document.getElementById('map_point_now').value);
								happy_map_markRemoveAll();
								happy_map_setZoom_level	= 1;

								happy_map_search_word	= ( happy_map_ie == '1' )? document.getElementById('happy_map_search').value : encodeURI(document.getElementById('happy_map_search').value) ;

								if ( document.getElementById('happy_map_si') != undefined )
								{
									happy_map_search_si_tmp	= document.getElementById('happy_map_si').options[document.getElementById('happy_map_si').selectedIndex].value;
								}
								else
								{
									happy_map_search_si_tmp	= '';
								}

								if ( happy_map_search_si_tmp != '' )
								{
									happy_map_search_si_tmp	= happy_map_search_si_tmp.split('__');

									happy_map_search_si		= happy_map_search_si_tmp[0];
									happy_map_search_si_x	= happy_map_search_si_tmp[1];
									happy_map_search_si_y	= happy_map_search_si_tmp[2];

									happy_map_mapObj.setCenter(new google.maps.LatLng(happy_map_search_si_x,happy_map_search_si_y));
									happy_map_mapObj.setZoom(happy_map_search_si_map_size);

								}
								else
								{
									happy_map_search_si		= '';
									happy_map_search_si_x	= '';
									happy_map_search_si_y	= '';
								}

								if ( document.getElementById('happy_map_latlng') == undefined || document.getElementById('happy_map_type') == undefined || document.getElementById('happy_map_type').checked == false )
								{
									happy_map_latlng_value	= '';
								}
								else
								{
									happy_map_bound_func();
									happy_map_latlng_value	= document.getElementById('happy_map_latlng').value;
								}

								// google woo
								var map_point	= happy_map_mapObj.getCenter().lat() + ',' + happy_map_mapObj.getCenter().lng();

								//직종검색
								search_type_value = '';
								search_type_sub_value = '';
								if ( document.happy_map_search_form.search_type != undefined )
								{
									search_type_value = document.happy_map_search_form.search_type[document.happy_map_search_form.search_type.selectedIndex].value;
								}
								if ( document.happy_map_search_form.search_type_sub != undefined )
								{
									search_type_sub_value = document.happy_map_search_form.search_type_sub[document.happy_map_search_form.search_type_sub.selectedIndex].value;
								}


							ajax${section_ajax_num}.callPage(
									'ajax_guin_list.php?$map_point_script
									+'&ajaxNum=${section_ajax_num}'
									+'&ajaxLayer=${layerName}'
									+'${query_string}'
									+'&start='+pageNo
									+'&vals='+document.getElementById('$idName').value
									+'&happy_map_latlng='+happy_map_latlng_value
									+'&now_map_search='+ document.getElementById('happy_map_type').checked
									+'&happy_map_search='+happy_map_search_word
									+'&happy_map_category='+document.getElementById('happy_map_category').value
									+'&happy_map_ie='+happy_map_ie
									+'&get_si='+happy_map_search_si
									+'&search_metor=".$_GET['search_metor']."'
									+'&search_type='+search_type_value
									+'&search_type_sub='+search_type_sub_value
									,
									function(response) {
										//alert(response);
										Temp		= response.split('___C_COUNT___');
										response	= Temp[0];
										Counting	= Temp[1];

										document.getElementById('$layerName').innerHTML	= response;

										happy_map_markAdd_ALL();
									}
							);
						}

					</script>
				";


			}
			//네이버지도쓸때
			else
			{
				//$map_point_script		= "map_point='+happy_map_mapObj.fromTM128ToLatLng(happy_map_mapObj.getCenter())";
				//$map_size_script		= "'&map_size='+happy_map_mapObj.getZoom()";
				$map_point_script		= "map_point='+happy_map_my_point_x+','+happy_map_my_point_y";
				$map_size_script		= "'&map_size='+happy_map_mapObj.getLevel()";


				$content	.= "
					<script>

						function gopaging${section_ajax_num}( pageNo )
						{
							document.getElementById('$layerName').innerHTML	= \"<table width='100%' height='100%'><tr><td align=center height='200'><img src='img/ajax_loading.gif'></td></tr></table>\";


									//alert(document.getElementById('map_point_now').value);
									happy_map_markRemoveAll();
									happy_map_setZoom_level	= 1;

									if ( document.getElementById('happy_map_si') != undefined )
									{
										happy_map_search_si_tmp	= document.getElementById('happy_map_si').options[document.getElementById('happy_map_si').selectedIndex].value;
									}
									else
									{
										happy_map_search_si_tmp	= '';
									}

									if ( happy_map_search_si_tmp != '' )
									{
										happy_map_search_si_tmp	= happy_map_search_si_tmp.split('__');

										happy_map_search_si		= happy_map_search_si_tmp[0];
										happy_map_search_si_x	= happy_map_search_si_tmp[1];
										happy_map_search_si_y	= happy_map_search_si_tmp[2];

										//happy_map_center_change(happy_map_search_si_x,happy_map_search_si_y,happy_map_search_si_map_size);
										//happy_map_mapObj.setCenterAndZoom(new NLatLng(happy_map_search_si_x,happy_map_search_si_y),happy_map_search_si_map_size);
										happy_map_mapObj.setCenter(new naver.maps.LatLng(happy_map_search_si_x,happy_map_search_si_y),happy_map_search_si_map_size);
									}
									else
									{
										happy_map_search_si		= '';
										happy_map_search_si_x	= '';
										happy_map_search_si_y	= '';
									}

									if ( document.getElementById('happy_map_latlng') == undefined || document.getElementById('happy_map_type') == undefined || document.getElementById('happy_map_type').checked == false )
									{
										happy_map_latlng_value	= '';
									}
									else
									{
										happy_map_bound_func();
										happy_map_latlng_value	= document.getElementById('happy_map_latlng').value;
									}

									happy_map_new_points	= happy_map_mapObj.getCenter();
									happy_map_my_point_value= happy_map_new_points.y+','+happy_map_new_points.x;
									happy_map_my_point_chk	= '';

									happy_map_search_word	= ( happy_map_ie == '1' )? document.getElementById('happy_map_search').value : encodeURI(document.getElementById('happy_map_search').value) ;

									//console.log(happy_map_search_word);


									//직종검색
									search_type_value = '';
									search_type_sub_value = '';
									if ( document.happy_map_search_form.search_type != undefined )
									{
										search_type_value = document.happy_map_search_form.search_type[document.happy_map_search_form.search_type.selectedIndex].value;
									}
									if ( document.happy_map_search_form.search_type_sub != undefined )
									{
										search_type_sub_value = document.happy_map_search_form.search_type_sub[document.happy_map_search_form.search_type_sub.selectedIndex].value;
									}

							ajax${section_ajax_num}.callPage(
									'ajax_guin_list.php?ajaxNum=${section_ajax_num}'
									+'&ajaxLayer=${layerName}'
									+'${query_string}'
									+'&start='+pageNo
									+'&vals='+document.getElementById('$idName').value
									+'&map_point='+ happy_map_my_point_value
									+'&happy_map_latlng='+happy_map_latlng_value
									+'&now_map_search='+ document.getElementById('happy_map_type').checked
									+'&happy_map_search='+  happy_map_search_word
									+'&happy_map_category='+  document.getElementById('happy_map_category').value
									+'&happy_map_ie='+happy_map_ie
									+'&get_si='+ happy_map_search_si
									+'&search_metor=".$_GET['search_metor']."'
									+'&search_type='+search_type_value
									+'&search_type_sub='+search_type_sub_value
									,
									function(response) {
										//alert(response);
										Temp		= response.split('___C_COUNT___');
										response	= Temp[0];
										Counting	= Temp[1];

										document.getElementById('$layerName').innerHTML	= response;

										happy_map_markAdd_ALL();
									}
							);
						}

					</script>
				";
			}
		}


	}
	$section_ajax_num++;
	return print $content;
}


//구인리스트
$guin_extraction_count = 0;
function guin_extraction($ex_limit,$ex_width,$ex_title_cut,$ex_category1,$ex_category2,$ex_area1,$ex_area2,$ex_type,$ex_job_type,$ex_template,$startLimit="",$ex_paging="사용안함",$ex_extraction_type="",$ex_order="",$ex_option="", $ex_guin_career="",$use_headhunting="")//jobwork 16
{

	global $job_type_read,$search_si,$search_gu,$search_type,$search_type_sub,$SI_NUMBER,$GU_NUMBER,$TYPE_NUMBER,$TYPE_SUB_NUMBER,$SI,$GU,$TYPE,$TYPE_SUB, $per_guin_want, $com_want_doc_tb, $per_document_tb, $DocData,$numb,$ARRAY,$ARRAY_FILE,$CONF,$ARRAY_NAME,$real_gap,$ARRAY_NAME2,$page_print,$guin_tb,$TPL,$NEW,$main_new ,$페이지출력,$main_new_out ,$real_gap,$user_id, $확인여부,$area_read,$jobclass_read,$edu_read,$career_read,$gender_read,$title_read,$type_read,$pay_read,$skin_folder,$scrap_tb;
	global $undergroundTitle, $undergroundNumber, $job_underground_tb, $현재역이름, $edu_arr, $want_money_img_arr, $want_money_img_arr2;
	global $siSelect,$guSelect;
	global $keyword_read;
	global $guin_title_bgcolor;
	global $HAPPY_CONFIG;
	global $TDayIcons;
	global $ajax_paging,$ajaxNum;
	global $WantSearchGuin;		#맞춤구인정보
	global $job_per_guin_view_tb;		#열람가능구인
	global $guin_title_color, $guin_title_bold;
	global $boodong_metor,$search_metor,$naver_no_member_call_id;

	global $스크랩버튼,$스크랩버튼2,$happy_member_login_value,$scrap_tb,$user_id,$happy_member_secure_text;
	global $guin_extraction_count;

	//스크랩 버튼 처리 hong
	global $guin_main_extraction_count;
	$guin_extraction_count = $guin_main_extraction_count;

	$guin_extraction_count++;

	global $채용지역정보, $per_want_doc_tb;
	global $job_per_want_search;

	global $hunting_use, $job_company;

	global $happy_member;

	global $채용정보수,$jiwon_type;

	global $COM_INFO2, $TYPE_SUB_SUB;

	$스크랩권한		= happy_member_secure($happy_member_secure_text[1].'스크랩');

	//print_r(func_get_args());

	//echo $ex_order;



	#문자열을 정리해서 숫자만 뽑아주자
	$ex_limit		= preg_replace('/\D/', '', $ex_limit);
	$ex_width		= preg_replace('/\D/', '', $ex_width);
	$ex_title_cut	= preg_replace('/\D/', '', $ex_title_cut);
	$ex_type		= preg_replace('/\n/', '', $ex_type);
	$ex_category1	= preg_replace('/\n/', '', $ex_category1);
	$ex_category2	= preg_replace('/\n/', '', $ex_category2);
	$ex_area1		= preg_replace('/\n/', '', $ex_area1);
	$ex_area2		= preg_replace('/\n/', '', $ex_area2);
	$ex_template	= preg_replace('/\n/', '', $ex_template);
	$ex_job_type	= preg_replace('/\n/', '', $ex_job_type);
	$guin_age		= str_replace(" ","",$_GET["guin_age"]);

	#누락기능 추가됨
	#echo $startLimit."<br>";
	#echo $ex_job_type;


	$startLimit	= preg_replace('/\D/', '', $startLimit);

	$se_order		= $_GET["se_order"];
	$se_key			= $_GET["se_key"];

	$user_id		= $happy_member_login_value;

	#템플릿을 지정한다. (배너형,좁은배너형,넓은배너형,줄광고형)
	#배너형 wait = 2

	//채용정보 유료옵션별 검색 추가 hong
	global $ARRAY_SEARCH, $ARRAY_SEARCH_NAME;

	if ( $_GET['search_option'] != "" )
	{
		$opt_key	= array_search($_GET['search_option'],$ARRAY_SEARCH);

		if ( "$opt_key" != "" ) // key가 0일때는 인식이 안되서 따옴표 처리
		{
			$ex_type = $ARRAY_SEARCH_NAME[$opt_key];
		}
	}
	//채용정보 유료옵션별 검색 추가 hong

	if ($ex_type == '일반')
	{
		$wait_query = "";
		$check_ex = '1';
	}
	else if ( $ex_type == "오늘본채용정보" )
	{
		$arr		= explode(",",$_COOKIE["HappyTodayGuin"]);
		$todayOrder	= "";

		//for ( $i=sizeof($arr)-1, $Count=0 ; $i>=0 && $Count<$ex_limit ; $i-- )
		for ( $i=sizeof($arr)-1, $Count=0 ; $i>=0 ; $i-- )
		{
			$tmp	= explode("_",$arr[$i]);

			if ( $tmp[0] != "" )
			{
				$cookieVal	.= ( $Count == 0 )?"":",";
				$cookieVal	.= $tmp[0];
				$ttt		= ( $Count == 0 )?" number = $tmp[0]":" number = $tmp[0],";
				$todayOrder	= $ttt . $todayOrder;
				$Count++;
			}
		}
		if ( $cookieVal != "" )
		{
			$wait_query = " number in ($cookieVal) ";
		}
		else
		{
			$wait_query = " number = '0' ";
			$todayOrder	= " number ";
		}
		$check_ex		= '1';
	}
	else
	{

		if ( $ex_type == '전체' )
		{
			$check_ex = '1';
		}

		for ($i = 0; $i <=16 ; $i ++)
		{
			#이력서보기기간,회수별보기,SMS제외
			if ( $i >= 7 && $i <= 9 )
			{
				continue;
			}

			if ($ex_type == $ARRAY_NAME[$i])
			{
				$check_ex = '1';
				$tmp_option = $ARRAY[$i] . "_option";
				if ($CONF[$tmp_option] == '기간별')
				{
					#무료로 사용할때는 모두 나오도록
					if ( $CONF[$ARRAY[$i]] != "" )
					{
						$wait_query = "$ARRAY[$i] > $real_gap ";
					}
				}
				else
				{
					$wait_query = "$ARRAY[$i] > '0' ";
				}
				break;
			}
		}
	}


	if ($check_ex != '1')
	{
		return print $main_new_out = "<font color=red>$ex_type</font>로 지정된 옵션은 존재하지 않습니다. <br>템플릿 파일을 다시 설정 하세요";
		exit;
	}

	if ($ex_template == "")
	{
		#전체출력용 (유,무료상관없이)
		return $main_new_out = "<font color=red>템플릿파일을</font> 지정해주세요";
		exit;
	}

	//echo $ex_template."<bR>";
	if( !(is_file("./$skin_folder/$ex_template")) )
	{
		return $main_new_out = "템플릿폴더 ./$skin_folder/$ex_template 파일이 존재하지 않습니다. <br>";
		exit;
	}

	$QUERY = array();
	$ai_comment = "";
	$plus = "&com_info_id=$_GET[com_info_id]&sort_order=$_GET[sort_order]&";

	#필수결제항목은 추출시 검사하자.
	//if ($ex_type == "") //정보추출할때 guin_banner1 옵션을 우선적으로 부르고 있어서 패치함 - ranksa
	//{
		if ( is_array($ARRAY) && $CONF['paid_conf'] == 1 )
		{
			foreach($ARRAY as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					if ($CONF[$o_name] == '기간별')
					{
						$wait_query2 = $ARRAY[$k]." > ".$real_gap;
					}
					else
					{
						$wait_query2 = $ARRAY[$k]." > 0 ";
					}
					array_push($QUERY, $wait_query2);
				}
			}
		}
	//}
	#필수결제항목은 추출시 검사하자.


	//지역개선작업
	global $gu_temp_array;

	$guAddC		= "";
	$temp		= $ex_area2 == '자동' ? $_GET['search_gu'] : $ex_area2;
	if ( $gu_temp_array["부모값_".$temp] == 'sub' )
	{
		$guAddC		= "_ori";
	}
	//지역개선작업

	#지역별 검색 다시
	if ($ex_area1 == "전체" || $ex_area1 == '전국' || $_GET["search_si"] == "$SI_NUMBER[전국]")
	{
		$area_query1 = "";
	}
	elseif ($ex_area1 == "자동" )
	{
		#ex_area2도 자동일것임.
		$ex_area1 = $_GET["search_si"];
		$ex_area2 = $_GET["search_gu"];
		$ex_area2_name = $_GET['search_guName'];

		if ( $ex_area1 && $ex_area2_name != "" )
		{
			//print_r2($GU_NUMBER);
			// [서구] => 168 식으로 키가 지명, 값이 번호
			$area_query_total	= " ( ";
			$or = "";
			foreach($GU_NUMBER as $guNameTmp => $guNumTmp)
			{
				list($guN1,$guN2) = explode(" ",$guNameTmp);
				if ( $guN1 == $ex_area2_name )
				{
					//echo '['.$guNumTmp.']'.$guNameTmp.'<br>';
					$area_query_total.= $or." gu1{$guAddC}	= '$guNumTmp' or gu2{$guAddC}	= '$guNumTmp' or gu3{$guAddC}	= '$guNumTmp' ";
					$or = " or ";
				}
			}

			$area_query_total.= $or." si1 = '$SI_NUMBER[전국]' or si2 = '$SI_NUMBER[전국]' or si3 = '$SI_NUMBER[전국]' ";
			$area_query_total.= " ) ";

			$plus .= "search_si=$ex_area1&search_guName=".urlencode($ex_area2_name)."&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] $ex_area2_name 지역내 </font>";
			array_push($QUERY, "$area_query_total");
		}
		else if ($ex_area1 && $ex_area2)
		{
			#시구까지 존재
			$area_query_total	= "
									(
										gu1{$guAddC}	= '$ex_area2'
										or
										gu2{$guAddC}	= '$ex_area2'
										or
										gu3{$guAddC}	= '$ex_area2'
										or
										si1				= '$SI_NUMBER[전국]'
										or
										si2				= '$SI_NUMBER[전국]'
										or
										si3				= '$SI_NUMBER[전국]'
									)
			";
			$plus .= "search_si=$ex_area1&search_gu=$ex_area2&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] $GU[$ex_area2] 지역내 </font>";
			array_push($QUERY, "$area_query_total");
		}
		elseif ($ex_area1)
		{
			$area_query_total = "  ( (si1='$SI_NUMBER[전국]' or si2='$SI_NUMBER[전국]' or si3='$SI_NUMBER[전국]' ) or (si1='$ex_area1' or si2='$ex_area1' or si3='$ex_area1')   ) ";
			$plus .= "search_si=$ex_area1&search_gu=$ex_area2&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] 지역내</font>";
			array_push($QUERY, "$area_query_total");
		}
		else
		{
			$area_query_total = '';
			$plus .= "search_si=$ex_area1&";
		}
	}
	elseif ($ex_area1 )
	{
		#ex_area1 글자일때
		$ex_area1 = $SI_NUMBER[$ex_area1];
		$ex_area2 = $GU_NUMBER[$ex_area2];
		if ($ex_area1 && $ex_area2)
		{
			#시구까지 존재
			$area_query_total	= "
									(
										gu1{$guAddC}	= '$ex_area2'
										or
										gu2{$guAddC}	= '$ex_area2'
										or
										gu3{$guAddC}	= '$ex_area2'
										or
										si1				= '$SI_NUMBER[전국]'
										or
										si2				= '$SI_NUMBER[전국]'
										or
										si3				= '$SI_NUMBER[전국]'
									)
			";

			$plus .= "search_si=$ex_area1&search_gu=$ex_area2&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1] $GU[$ex_area2] 지역내 </font>";
			array_push($QUERY, "$area_query_total");
		}
		elseif ($ex_area1)
		{
			$area_query_total = "  ( (si1='$SI_NUMBER[전국]' or si2='$SI_NUMBER[전국]' or si3='$SI_NUMBER[전국]' ) or (si1='$ex_area1' or si2='$ex_area1' or si3='$ex_area1')   ) ";
			$plus .= "search_si=$ex_area1&search_gu=$ex_area2&";
			$ai_comment .= "<font color=#AE06A0>$SI[$ex_area1]지역내</font>";
			array_push($QUERY, "$area_query_total");
		}
		else
		{
			$area_query_total = '';
		}
	}

	#직종별 작업해야함.
	if ($ex_category1 == "전체" || $ex_category1 == "")
	{
		$category_query1 = "";
	}
	elseif ($ex_category1 == "자동")
	{
		#자동일 경우 검색값에서 받아온다.
		$ex_category1 = $search_type;
		$ex_category2 = $search_type_sub;
		$ex_category3 = $_GET['search_type_sub_sub'];

		if ($ex_category1 && $ex_category2 && $ex_category3)
		{
			$category_query1 = " ( (type1 = '$ex_category1' and type_sub1 = '$ex_category2' and type_sub_sub1 = '$ex_category3') or (type2 = '$ex_category1' and type_sub2 = '$ex_category2' and type_sub_sub2 = '$ex_category3') or (type3 = '$ex_category1' and type_sub3 = '$ex_category2' and type_sub_sub3 = '$ex_category3') )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&search_sub_type=$ex_category2&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1] $TYPE_SUB[$ex_category2] $TYPE_SUB_SUB[$ex_category3]</font> ";
		}
		else if ($ex_category1 && $ex_category2 && $ex_category3 == '0')
		{
			$category_query1 = " ( (type1 = '$ex_category1' and type_sub1 = '$ex_category2') or (type2 = '$ex_category1' and type_sub2 = '$ex_category2') or (type3 = '$ex_category1' and type_sub3 = '$ex_category2') )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&search_sub_type=$ex_category2&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1] $TYPE_SUB[$ex_category2]</font> ";
		}
		elseif ($ex_category1 && $ex_category2 == '' && $ex_category3 == '0')
		{
			$category_query1 = " (type1 = '$ex_category1' or type2 = '$ex_category1' or type3 = '$ex_category1' )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1]"."</font> ";
		}
		else
		{
			$category_query1 = '';
		}
	}
	elseif ($ex_category1 )
	{
		$ex_category1 = $TYPE_NUMBER[$ex_category1];
		$ex_category2 = $TYPE_SUB_NUMBER[$ex_category2];
		if ($ex_category1 && $ex_category2)
		{
			$category_query1 = " ( (type1 = '$ex_category1' and type_sub1 = '$ex_category2') or (type2 = '$ex_category1' and type_sub2 = '$ex_category2') or (type3 = '$ex_category1' and type_sub3 = '$ex_category2') )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&search_sub_type=$ex_category2&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1] $TYPE_SUB[$ex_category2]</font> ";
		}
		elseif ($ex_category1 && $ex_category2 == '')
		{
			$category_query1 = " (type1 = '$ex_category1' or type2 = '$ex_category1' or type3 = '$ex_category1' )  ";
			array_push($QUERY, "$category_query1");
			$plus .= "search_type=$ex_category1&";
			$ai_comment .= " <font color=#464BB7>$TYPE[$ex_category1]"."</font> ";
		}
		else
		{
			$category_query1 = '';
		}
	}


	#plus jobclass_read ,area_read

	//연령검색
	if ( $guin_age != "" )
	{
		$guin_age_search  = " (guin_age = '$guin_age' or guin_age = '0')  ";
		array_push($QUERY, "$guin_age_search");
		$ai_comment .= " <font color=#7EA105>$guin_age 년생 </font>";
		$plus .= "guin_age=$guin_age&";
	}


	if ( $_GET["grade_read"] != "" )
	{
		$grade_search  = " guin_grade = '$_GET[grade_read]' ";
		array_push($QUERY, "$grade_search");
		$ai_comment .= " <font color=#1EAd0v>$_GET[grade_read] </font>";
		$plus .= "grade_read=$_GET[grade_read]&";
	}

	if ( $se_order != "" && $se_key != "" )
	{
		array_push($QUERY, "$se_order like '%{$se_key}%'");
		$ai_comment .= " <font color=#1EAd0v>$se_key </font>";
		$plus .= "se_order=$_GET[se_order]&se_key=$_GET[se_key]&";
	}

	// 학력정리
	$job_type_read	= ( is_Array($_GET["job_type_read"]) )?@implode("___",$_GET["job_type_read"]):$_GET["job_type_read"];
	$edu_read		= ( is_Array($_GET["edu_read"]) )?@implode("___",$_GET["edu_read"]):$_GET["edu_read"];

	$job_type_read	= explode("___",$job_type_read);
	$edu_read		= explode("___",$edu_read);


	#최종학력 이상/이하 선택시
	if ( $_GET['guzic_school_type'] != '' && $_GET["edu_read"] != '' )
	{
		$edu_read	= $edu_read[0];
		$guin_in	= '';
		$plus		.= "edu_read=".$edu_read."&guzic_school_type=$_GET[guzic_school_type]&";
		$ai_comment .= " <font color=#AE06A0>$edu_read 학력 $_GET[guzic_school_type]</font> ";

		if (  $_GET['guzic_school_type'] == '이상' )
		{
			for ( $guin_key = array_search($edu_read, $edu_arr) ; $guin_key < sizeof($edu_arr) ; $guin_key++ )
			{
				$guin_in	.= ( $guin_in == '' )? '' : ',' ;
				$guin_in	.= "'". $edu_arr[$guin_key] ."'";
			}
		}
		else if (  $_GET['guzic_school_type'] == '이하' )
		{
			for ( $guin_key = array_search($edu_read, $edu_arr) ; $guin_key >= 0 ; $guin_key-- )
			{
				$guin_in	.= ( $guin_in == '' )? '' : ',' ;
				$guin_in	.= "'". $edu_arr[$guin_key] ."'";
			}
		}

		if ( $guin_in != '' )
		{
			//$WHERE	= " ( guin_edu in ( $guin_in ) OR guin_edu = '무관' )";
			$WHERE	= " ( guin_edu in ( $guin_in ) )"; //학력무관도 하나의 옵션으로
			array_push($QUERY, " $WHERE ");
		}
	}
	else if ( sizeof($edu_read) > 0 )
	{
		$WHERE_T	= "";
		for ( $i=0, $j=0, $max=sizeof($edu_read) ; $i<$max ; $i++ )
		{
			if ( str_replace(" ","",$edu_read[$i]) != "" )
			{
				$WHERE_T	.= ( $j != 0 )?" OR ":"";
				$WHERE_T	.= " guin_edu = '".$edu_read[$i]."' ";
				$plus		.= "edu_read[]=".$edu_read[$i]."&";
				$j++;
			}
		}
		#echo $WHERE_T;

		if ( $WHERE_T != "" )
		{
			//$WHERE_T	.= " OR guin_edu = '무관' ";
			//$ai_comment .= " <font color=#AE06A0>다중 학력</font> ";
			array_push($QUERY, " ( $WHERE_T ) ");
		}
	}



	//jobwork , 16번째 인자값
	//echo "$career_read ::: $ex_guin_career";
	if ( $ex_guin_career != '전체' && $ex_guin_career != '' )
	{
		$career_read	= $ex_guin_career;
	}

	// 경력 정리
	if ( $career_read == '무관' )
	{
		$career_search		= "";
		$ai_comment			.= " <font color='#7EA105'>경력 $career_read</font>";
	}
	else if ( $career_read == '신입' )
	{
		$career_search		= "(guin_career = '신입' or guin_career = '무관')";
		$ai_comment			.= " <font color='#7EA105'>경력 $career_read</font>";
		array_push($QUERY, $career_search);
	}
	else if ( strpos( $career_read, '신입' ) !== false )//jobwork, 신입이상
	{
		$career_search		= "(guin_career != '무관')";
		$ai_comment			.= " <font color='#7EA105'>신입이상 $career_read </font>";
		array_push($QUERY, $career_search);
	}
	else if ( $career_read == '경력' )//jobwork
	{
		$career_search		= "(guin_career = '경력' or guin_career = '무관')";
		$ai_comment			.= " <font color='#7EA105'>경력</font>";
		array_push($QUERY, $career_search);
	}
	else if ( $career_read )
	{
		//echo $career_read."<hr>";
		$ai_comment			.= " <font color='#7EA105'>경력 $career_read </font>";
		$plus				.= "career_read=$career_read&";

		$career_read_arr	= explode("~",$career_read);
		if ( sizeof($career_read_arr) == 2 )
		{
			$career_read_arr	= preg_replace("/\D/","",$career_read_arr);
			//경력 검색시 경력무관인 채용정보는 같이 검색되도록
			$career_search		= "
									(
										(
											guin_career = '경력'
											AND
											(
												CAST(guin_career_year as SIGNED) >= $career_read_arr[0]
												AND
												(
													CAST(guin_career_year as SIGNED) <= $career_read_arr[1]
												)
											)
										)
										or
										guin_career = '무관'
									)
			";
			array_push($QUERY, $career_search);
		}
		else
		{
			$career_read		= preg_replace("/\D/","",$career_read);
			//경력 검색시 경력무관인 채용정보는 같이 검색되도록
			$career_search		= "
									(
										(
											guin_career = '경력'
											and
											CAST(guin_career_year as SIGNED) >= $career_read
										)
										or
										guin_career = '무관'
									)

			";
			array_push($QUERY, $career_search);
		}
	}



	//성별정리
	if ($gender_read == '무관')
	{
		$gender_search = "";
		$ai_comment .= " 성별"."(<font color=#A18C03>$gender_read</font>) ";
	}
	elseif ($gender_read)
	{
		$gender_search = " (guin_gender = '$gender_read'  or guin_gender = '무관' ) ";
		array_push($QUERY, "$gender_search");
		$ai_comment .= " 성별"."(<font color=#A18C03>$gender_read</font>) ";
		$plus .= "gender_read=$gender_read&";
	}

	//제목 키워드 정리
	if ($title_read)
	{
		$title_search = "(guin_title like '%$title_read%' OR guin_com_name  like '%$title_read%' OR keyword like '%$title_read%' )";
		array_push($QUERY, "$title_search");
		$plus .= "title_read=$title_read&";
	}

	#키워드 셀렉트 박스로 검색하기 기능(현재는 사용안하는 검색방식임)
	if ($keyword_read)
	{
		$keyword_search = "( keyword like '%$keyword_read%' )";
		array_push($QUERY, "$keyword_search");
		$plus .= "keyword_read=$keyword_search&";
	}

	//고용형태
	if ($ex_job_type == '전체')
	{
		$plus .= "";
	}
	elseif ($ex_job_type == '자동')
	{
		if ( sizeof($job_type_read) > 0 && $_GET[job_type_read] != "전체" )
		{
			$WHERE_T	= "";
			for ( $i=0, $j=0, $max=sizeof($job_type_read) ; $i<$max ; $i++ )
			{
				if ( str_replace(" ","",$job_type_read[$i]) != "" )
				{
					$WHERE_T	.= ( $j != 0 )?" OR ":"";
					$WHERE_T	.= " guin_type = '".$job_type_read[$i]."' ";
					$plus		.= "job_type_read[]=".$job_type_read[$i]."&";
					$j++;
				}
			}
			#echo $WHERE_T;

			if ( $WHERE_T != "" )
			{
				$ai_comment .= " <font color=#AE06A0>다중 채용종류</font> ";
				array_push($QUERY, " ( $WHERE_T ) ");
			}
		}
	}
	else if ( $ex_job_type == "회사관련구인" )
	{
		if ( $_GET["com_info_id"] == "" )
		{
			error("필요한 인자가 부족합니다.");
			exit;
		}

		$type_search = " guin_id = '$_GET[com_info_id]' ";
		array_push($QUERY, "$type_search");

		if($hunting_use == true && $COM_INFO2['number'] != '')
		{
			$type_search = " company_number = '$COM_INFO2[number]' ";
			array_push($QUERY, "$type_search");
		}
	}
	elseif ($ex_job_type != "" && $ex_job_type != "스크랩" )
	{
		$type_search = "guin_type = '$ex_job_type' ";
		array_push($QUERY, "$type_search");
		$plus .= "job_type_read=$job_type_read&";
	}

	//희망연봉정리
	if ($pay_read)
	{
		$pay_search = "guin_pay = '$pay_read' ";
		array_push($QUERY, "$pay_search");
		$ai_comment .= "연봉"."(<font color=#AE029F>$pay_read</font>) ";
		$plus .= "pay_read=$pay_read&";
	}

	#급여조건
	if ( $_GET['guin_pay_type'] != '' )
	{
		$pay_type_search = " ( guin_pay_type = '".$_GET['guin_pay_type']."' ) ";
		array_push($QUERY, $pay_type_search);
	}

	#category_query 와 wait_query 를 where로 정리해보자
	if ($wait_query)
	{
		array_push($QUERY, "$wait_query");
	}

	$현재역이름	= "";
	#지하철 검색값 넘어왔을때 - 역세권
	if ( $_GET['underground1'] != '' )
	{
		array_push($QUERY, " underground1='$_GET[underground1]'");
		$Sql		= "SELECT title FROM $job_underground_tb WHERE number='$_GET[underground1]' ";
		$Tmp		= happy_mysql_fetch_array(query($Sql));
		$ai_comment	.= "<font color='#0066FF'>$Tmp[title]</font> ";
		$현재역이름	= "$Tmp[title] ";
	}
	if ( $_GET['underground2'] != '' )
	{
		array_push($QUERY, " underground2='$_GET[underground2]'");
		$Sql		= "SELECT title FROM $job_underground_tb WHERE number='$_GET[underground2]' ";
		$Tmp		= happy_mysql_fetch_array(query($Sql));
		$ai_comment	.= "<font color='#0066FF'>$Tmp[title]역</font> ";
		$현재역이름	.= "$Tmp[title]역 ";
	}

	#단순학력 추가됨
	if ( $_GET['guziceducation'] != '' )
	{
		//array_push($QUERY, " ( guziceducation='".$_GET['guziceducation']."' ) ");
		//array_push($QUERY, " ( grade_lastgrade='".$_GET['guziceducation']."' ) ");

		array_push($QUERY, " ( guin_edu='".$_GET['guziceducation']."' ) ");
	}
	#단순학력 추가됨

	#국적추가됨
	if ( $_GET['guzicnational'] != '' )
	{
		array_push($QUERY, " ( guinnational='".$_GET['guzicnational']."' ) ");
	}
	#국적추가됨

	#연령검색
	if ( $_GET['guzic_age_start'] != '' )
	{
		$age_start = date("Y") - $_GET['guzic_age_start'] + 1;
		array_push($QUERY, " ( guin_age <= '".$age_start."' ) ");
	}

	if ( $_GET['guzic_age_end'] != '' )
	{
		$age_end = date("Y") - $_GET['guzic_age_end'] + 1;
		array_push($QUERY, " ( guin_age >= '".$age_end."' ) ");
	}
	#연령검색

	#등록일
	if ( $_GET['diff_regday'] != '' )
	{
		array_push($QUERY, " ( guin_date >= date_add(guin_date,interval -".$_GET['diff_regday']." day) ) " );
	}
	#등록일

	/*
	//슈퍼관리자가 아니면서...성인인증을 받지 않았거나 로그인(성인)을 하지 않은 경우는 성인 리스트를 보여주지 말자!
	if(!$_COOKIE[ad_id] && !$_COOKIE[adult_check])
	{
		$add_query = "use_adult != '1' AND ";
	}
	*/


	//인접순추출 or 회원인접업체 2010-10-12 kad
	$ext_query = array();
	$happy_map_latlng	= trim($_GET['happy_map_latlng']);
	if ( ( $ex_option == '인접순추출' || $ex_option == '회원인접업체' ) && $happy_map_latlng == '' )
	{
		$search_info	= "
			<img src='img/dot.gif' onLoad=\"try { happy_map_markRemoveAll(); } catch (e) { }\" style='display:none'>
			인접매물
		";
		$_GET['num']	= preg_replace('/\D/','',$_GET['number']);
		if ( $_GET['num'] == '' && $ex_option == '인접순추출' )
		{
			return print "<font color='red'>인접순추출 기능은 뷰페이지에서만 작동합니다.</font>";
		}

		if ( $ex_option == '인접순추출' )
		{
			$Sql	= "SELECT x_point2,y_point2 FROM $links WHERE number='$_GET[num]' ";
		}
		else if ( $ex_option == '회원인접업체' )
		{
			#global $member_near_xpoint, $member_near_ypoint;
			if ( $mem_id == '' && $_GET['map_point'] == '' )
			{
				$naver_find_addr_id	= $naver_no_member_call_id;
			}
			else if ( $mem_id != '' )
			{
				$naver_find_addr_id	= $mem_id;
			}
			$Sql	= "SELECT x_point2,y_point2 FROM $happy_member WHERE user_id='$naver_find_addr_id' ";
			//echo $Sql;

		}

		if ( $_GET['map_point'] == '' )
		{
			list($x_point2, $y_point2 )	= happy_mysql_fetch_array(query($Sql));
		}
		else
		{
			#echo $_GET['map_point'];
			list($x_point2, $y_point2 )	= explode(',', $_GET['map_point'] );

			$x_point				= str_replace(' ','',$x_point2);
			$y_point				= str_replace(' ','',$y_point2);

			list($x_do, $x_min)		= explode('.',$x_point);

			$x_min					= $x_point - $x_do;
			$x_min					= $x_min * 60;
			$x_min_check			= $x_min;
			list($x_min, $x_sec)	= explode('.',$x_min);

			$x_sec					= $x_min_check - $x_min;
			$x_sec					= $x_sec * 60;


			#echo "<hr>$x_do , $x_min , $x_sec";



			list($y_do, $y_min)		= explode('.',$y_point);

			$y_min					= $y_point - $y_do;
			$y_min					= $y_min * 60;
			$y_min_check			= $y_min;
			list($y_min, $y_sec)	= explode('.',$y_min);

			$y_sec					= $y_min_check - $y_min;
			$y_sec					= $y_sec * 60;


			#echo "<hr>$y_do , $y_min , $y_sec";


			$x_point2	= $x_do * 3600 + $x_min * 60 + $x_sec;
			$y_point2	= $y_do * 3600 + $y_min * 60 + $y_sec;

			$x_point2	= round($x_point2);
			$y_point2	= round($y_point2);
			#echo "$x_point2,$y_point2";

		}

		$order_by = ' metor asc';

		$map_size		= preg_replace("/\D/", "", $_GET['map_size']);
		$map_small_size	= preg_replace("/\D/", "", $_GET['map_small_size']);

		if($map_small_size =='')
		{
			//$map_small_size = 700;
		}

		$find_metor		= $boodong_metor;

		if ( $search_metor != '' )
			$find_metor	= $search_metor;

		if ( $map_size != '' )
		{
			$find_metor	= 25;
			for ( $z=0 ; $z<$map_size ; $z++ )
			{
				$find_metor	*= 2;
			}
			#$find_metor	= $find_metor - ( $find_metor * 0.2 );
			$find_metor	= round($find_metor);

			$find_metor	= $find_metor * ( ceil($map_small_size / 100)  );

			#$order_by = ' order by rand() ';
		}

		#반경검색

		$wgs_point	= wgs_point_get($xpoint);

		array_push($ext_query, " x_point2 > 1 AND y_point2 > 1 AND number != '$_GET[num]' AND ( sqrt( pow( ( greatest( x_point2, $x_point2 ) - least( x_point2, $x_point2 ) ) * $wgs_point[xpoint] , 2 ) + pow( ( greatest( y_point2, $y_point2 ) - least( y_point2, $y_point2 ) ) * $wgs_point[ypoint] , 2 ) ) ) < $find_metor ");


		$add_field	= " , ( sqrt( pow( ( greatest( x_point2, $x_point2 ) - least( x_point2, $x_point2 ) ) * $wgs_point[xpoint] , 2 ) + pow( ( greatest( y_point2, $y_point2 ) - least( y_point2, $y_point2 ) ) * $wgs_point[ypoint] , 2 ) ) ) AS metor ";


		switch ( $ex_option )
		{
			case "인접순추출":
				$WHERE .= " AND ".$ext_query[0];
				$order = $order_by;
				break;
			case "회원인접업체":
				$WHERE .= " AND ".$ext_query[0];
				$order = $order_by;
				break;
			default:
				break;
		}
	}
	//인접순추출 or 회원인접업체 2010-10-12 kad
	else if ( $ex_option == '회원인접업체' && $happy_map_latlng != '' )
	{
		#echo $happy_map_latlng;
		$WHERE = " 1 = 1 ";


		$happy_map_latlngs	= str_replace(' ', '', $happy_map_latlng);
		$happy_map_latlngs	= explode(',', $happy_map_latlngs);

		$happy_map_latlng_x	= Array( $happy_map_latlngs[0], $happy_map_latlngs[2] );
		$happy_map_latlng_y	= Array( $happy_map_latlngs[1], $happy_map_latlngs[3] );

		$now_map_search		= $_GET['now_map_search'];

		sort($happy_map_latlng_x);
		sort($happy_map_latlng_y);

		#echo '<hr>'.$_GET['happy_map_category'].'<hr>';



		/*
		$WHERE		.= "
							AND
							x_point	> 0
							AND
							y_point	> 0
		";
		*/

		if ( $now_map_search == 'true' )
		{
			$WHERE		.= "
							AND
							(
								x_point >= '$happy_map_latlng_x[0]'
								AND
								x_point <= '$happy_map_latlng_x[1]'
								AND
								y_point >= '$happy_map_latlng_y[0]'
								AND
								y_point <= '$happy_map_latlng_y[1]'
							)
			";
			if ( $HAPPY_CONFIG['happy_map_now_sorting'] == '1' )
			{
				$order = ' metor asc';
			}
		}
		else
		{
			if ( $HAPPY_CONFIG['happy_map_sorting'] == '1' )
			{
				$order = ' metor asc';
			}
		}


			#echo '<hr>now_map_search : '.$_GET['now_map_search'].'<hr>';
			list($x_point2, $y_point2 )	= explode(',', $_GET['map_point'] );

			$x_point				= str_replace(' ','',$x_point2);
			$y_point				= str_replace(' ','',$y_point2);

			list($x_do, $x_min)		= explode('.',$x_point);

			$x_min					= $x_point - $x_do;
			$x_min					= $x_min * 60;
			$x_min_check			= $x_min;
			list($x_min, $x_sec)	= explode('.',$x_min);

			$x_sec					= $x_min_check - $x_min;
			$x_sec					= $x_sec * 60;


			#echo "<hr>$x_do , $x_min , $x_sec";



			list($y_do, $y_min)		= explode('.',$y_point);

			$y_min					= $y_point - $y_do;
			$y_min					= $y_min * 60;
			$y_min_check			= $y_min;
			list($y_min, $y_sec)	= explode('.',$y_min);

			$y_sec					= $y_min_check - $y_min;
			$y_sec					= $y_sec * 60;


			#echo "<hr>$y_do , $y_min , $y_sec";


			$x_point2	= $x_do * 3600 + $x_min * 60 + $x_sec;
			$y_point2	= $y_do * 3600 + $y_min * 60 + $y_sec;

			$x_point2	= round($x_point2);
			$y_point2	= round($y_point2);

			$add_field	= " , ( sqrt( pow( ( greatest( x_point2, $x_point2 ) - least( x_point2, $x_point2 ) ) * 30.828 , 2 ) + pow( ( greatest( y_point2, $y_point2 ) - least( y_point2, $y_point2 ) ) * 24.697 , 2 ) ) ) AS metor ";

			#$order = ' metor asc';

			$ext_query[0] = $WHERE;

	}

	if ( $ex_option == '인접순추출' || $ex_option == '회원인접업체' )
	{
		$happy_map_search	= trim($_GET['happy_map_search']);
		if ( $happy_map_search != '' )
		{
			$ext_query[0]		.= " AND (guin_title like '%$happy_map_search%' OR guin_com_name  like '%$happy_map_search%' OR keyword like '%$happy_map_search%' ) ";
		}
	}


	//print_r($ext_query);
	if ( $ext_query[0] != "" )
	{
		array_push($QUERY,$ext_query[0]);
	}

	if ( $hunting_use == true && ( $use_headhunting == '헤드헌팅' || $_GET['hunting'] == 'y' ) )//헤드헌팅
	{
		array_push($QUERY, "company_number != '0'");
	}


	#마지막 쿼리문정리
	$last_query = "where $add_query";
	foreach ($QUERY as $list)
	{
		$last_query .= " $list and";
	}

	#맞춤구인정보는 DB에서 쿼리 불러와서 사용
	if ( $ex_extraction_type == '맞춤구인정보' )
	{
		if ( !is_array($WantSearchGuin) )
		{
			#맞춤구인설정 가져오자.
			$sql = "select * from ".$job_per_want_search." where id = '".$happy_member_login_value."'";
			$result = query($sql);
			$WantSearchGuin = happy_mysql_fetch_assoc($result);
		}

		if ( $WantSearchGuin['query_str'] == "" )
		{
			$WantSearchGuin['query_str'] = " 1=2 ";
		}
		$last_query =" where ".$WantSearchGuin['query_str']." AND ";
	}
	#맞춤구인정보는 DB에서 쿼리 불러와서 사용

	$last_query .= "  (guin_end_date >= curdate() or guin_choongwon ='1')";

	//echo $last_query;


	// 마감일검색 - sun
	if ($_GET["search_guin_end_date"] != "")
	{
		if ($last_query != "")
		{
			$last_query	.= " AND ";
		}
		else
		{
			$last_query	= " WHERE ";
		}

		switch ( $_GET["search_guin_end_date"] )
		{
			case "오늘마감":
								$last_query	.= "guin_end_date = curdate() and guin_choongwon=0";
								break;
			case "마감1일전":
								$d_1	= date("Y-m-d", strtotime(date("Y-m-d")." +1 days"));
								$last_query	.= "guin_end_date >= curdate() and guin_end_date <= '$d_1' and guin_choongwon = 0 ";
								break;
			case "마감2일전":
								$d_2	= date("Y-m-d", strtotime(date("Y-m-d")." +2 days"));
								$last_query	.= "guin_end_date >= curdate() and guin_end_date <= '$d_2' and guin_choongwon = 0 ";
								break;
			case "마감3일전":
								$d_3	= date("Y-m-d", strtotime(date("Y-m-d")." +3 days"));
								$last_query	.= "guin_end_date >= curdate() and guin_end_date <= '$d_3' and guin_choongwon = 0 ";
								break;
			case "상시채용":
								$last_query	.= "guin_choongwon = 1 ";
								break;
			default:
								$last_query .= "1=1 ";
								break;
		}

	}

	if ( $ex_job_type == "입사요청" || $ex_job_type == "면접요청" )
	{
		$WHERE2	= "";

		//온라인지원, 지원자관리 검색조건값 - ranksa
		//이력서리스트에 있는 소스 가져옴 - hong
		if($_GET['guin_per_action'] == 'search')
		{
			if($_GET['guin_per_start_date'] != "" && $_GET['guin_per_end_date'] != "")
			{
				$WHERE2	.= " AND C.regdate >= '$_GET[guin_per_start_date]' AND C.regdate <= '$_GET[guin_per_end_date]' ";
			}
			else if($_GET['guin_per_start_date'] != "")
			{
				$WHERE2	.= " AND C.regdate >= '$_GET[guin_per_start_date]' ";
			}
			else if($_GET['guin_per_end_date'] != "")
			{
				$WHERE2	.= " AND C.regdate <= '$_GET[guin_per_end_date]' ";
			}

			if($_GET['search_word'] != "")
			{
				$WHERE2	.= " AND (C.title like '%{$_GET[search_word]}%' OR A.guin_com_name like '%{$_GET[search_word]}%' OR A.guin_title like '%{$_GET[search_word]}%' ) ";
			}
		}

		$job_type_read	= ( is_Array($_GET["job_type_read"]) )?@implode("___",$_GET["job_type_read"]):$_GET["job_type_read"];
		$job_type_read	= explode("___",$job_type_read);

		$WHERE_T	= "";
		for ( $i=0, $j=0, $max=sizeof($job_type_read) ; $i<$max ; $i++ )
		{
			if ( str_replace(" ","",$job_type_read[$i]) != "" )
			{
				$WHERE_T	.= ( $j != 0 )?" OR ":"";
				$WHERE_T	.= " C.grade_gtype like '%".$job_type_read[$i]."%' ";
				$j++;
			}
		}
		#echo $WHERE_T;

		if ( $WHERE_T != "" )
		{
			$WHERE2	.= " AND ( $WHERE_T ) ";
		}
	}

	if ( $ex_job_type == "스크랩" )
	{
		$sql1	= "
				SELECT
						Count(A.number)
				FROM
						$guin_tb AS A
						INNER JOIN
						$scrap_tb AS B
				ON
						A.number = B.cNumber
				WHERE
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon = '1'
						)
						AND
						B.userid = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
		";
	}
	else if ( $ex_job_type == "인재스크랩" )
	{
		$sql1	= "
				SELECT
						Count(A.number)
				FROM
						$guin_tb AS A
						INNER JOIN
						$scrap_tb AS B
				ON
						A.number = B.cNumber
				WHERE
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon = '1'
						)
						AND
						B.userid = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
				GROUP BY A.number
		";
	}
	else if ( $ex_job_type == "입사요청" )
	{
		#기업 -> 일반 : 입사제의한 리스트 ( 일반회원이 보는 화면 )
		$sql1	= "
					SELECT
							Count(A.number)
					FROM
							$guin_tb AS A
					INNER JOIN
							$com_want_doc_tb AS B
					ON
							A.number = B.guin_number
					INNER JOIN
							$per_document_tb AS C
					ON
							B.doc_number = C.number
					WHERE
							B.per_id = '$user_id'
							AND
							(
								A.guin_end_date >= curdate()
								OR
								A.guin_choongwon ='1'
							)
							$WHERE2
		";
	}
	else if ( $ex_job_type == "면접요청" )
	{
		#기업 -> 일반 : 입사제의한 리스트 ( 일반회원이 보는 화면 )
		$sql1	= "
				SELECT
						Count(A.number)
				FROM
						$guin_tb AS A
						INNER JOIN
						$per_want_doc_tb AS B
				ON
						A.number = B.guin_number
				INNER JOIN
						$per_document_tb AS C
				ON
						B.doc_number = C.number
				WHERE
						B.per_id = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
						$WHERE2
		";
		#echo $sql1;
	}
	else if ( $ex_job_type == "입사제의" )
	{
		#기업 -> 일반 : 입사제의한 리스트 ( 기업회원이 보는 화면 )
		$sql1	= "
				SELECT
						Count(A.number)
				FROM
						$guin_tb AS A
						INNER JOIN
						$com_want_doc_tb AS B
				ON
						A.number = B.guin_number
				WHERE
						B.com_id = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
		";
		#echo $sql1;
	}
	else if ( $ex_job_type == "면접제의" )
	{
		#기업 -> 일반 : 면접제의한 리스트 ( 기업회원이 보는 화면 )
		$sql1	= "
				SELECT
						*
				FROM
						$guin_tb AS A
						INNER JOIN
						$per_want_doc_tb AS B
				ON
						A.number = B.guin_number
				WHERE
						B.com_id = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
				GROUP BY A.number
		";
		#echo $sql1;
	}
	else if ( $ex_job_type == "신입채용" )
	{
		$sql1 = "select count(*) from   $guin_tb where guin_career='신입'";
	}
	else if ( $ex_job_type == "열람가능" )
	{
		$sql1 = "select count(*) from $guin_tb AS A INNER JOIN $job_per_guin_view_tb as B ON A.number = B.guin_number where B.per_id = '$user_id'  ";
	}
	else
	{
		$sql1 = "select count(*) from   $guin_tb $last_query  ";
		//echo $sql1;
	}
	//echo "last_query = ".$last_query."<br>";
	//echo "구인리스트쿼리 = ".$sql1."<br>";//구인리스트쿼리

	$result1 = query($sql1);

	if ( $ex_job_type == "면접제의" )
	{
		$numb = mysql_num_rows($result1);
	}
	else
	{
		$get_tt = mysql_fetch_row($result1);
		$numb = $get_tt[0];
	}

	$채용정보수	= $numb;

	if (!$numb)
	{
		#초기화
		$main_new_out  = "";
		if ( $ex_job_type == "스크랩" || $ex_job_type == "인재스크랩" )
		{
			#$main_new_out	.= "<table width='100%' height='100'><tr><td align='center'>스크랩된 구인정보가 없습니다.</td></tr></table>";
			$main_new_out	.= $HAPPY_CONFIG['MsgScrapNoGuzic1'];
		}
		else if ( $ex_job_type == "입사요청" )
		{
			#$main_new_out	.= "<table width='100%' height='100'><tr><td align='center'>입사지원요청된 구인정보가 없습니다.</td></tr></table>";
			$main_new_out	.= $HAPPY_CONFIG['MsgWantNoGuin1'];
		}
		else if ( $ex_job_type == "입사제의" )
		{
			#$main_new_out	.= "<table width='100%' height='100'><tr><td align='center'>입사지원요청한 구인정보가 없습니다.</td></tr></table>";
			$main_new_out	.= $HAPPY_CONFIG['MsgWantNoGuin2'];
		}
		else if ( $ex_job_type == "면접제의" )
		{
			#$main_new_out	.= "<table width='100%' height='100'><tr><td align='center'>입사지원요청한 구인정보가 없습니다.</td></tr></table>";
			$main_new_out	.= $HAPPY_CONFIG['MsgWantNoGuin2'];
		}
		else if ( $ai_comment != "" )
		{
			$main_new_out = "<table width='100%' height='100'><tr><td align='center'>$ai_comment"."로 검색결과 <br>등록된 채용정보가 없습니다 </td></tr></table>";
		}
		else
		{
			#$main_new_out = "<table width='100%' height='100'><tr><td align='center'>등록된 채용정보가 없습니다 </td></tr></table>";
			$main_new_out = $HAPPY_CONFIG['MsgRegNoGuin1'];
		}

		return print $main_new_out;
		exit;
	}

	if ($start == "")
	{
		$start = $_GET[start];
	}
	if($start==0 || $start=="")
	{
		$start=0;
	}

	//페이지 나누기
	$numb = $numb - $startLimit; #추가

	$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = $start;

	#누락기능 추가됨
	if ( $startLimit )
	{
		$view_rows = $view_rows + $startLimit;
	}
	#누락기능 추가됨


	//채용정보 점프
	//print_r($HAPPY_CONFIG);
	if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
	{
		$ex_order = "최근등록일순";
	}
	//채용정보 점프


	if ( $_GET["sort_order"] != '' )
	{
		#정렬방법 (2011-11-15, [hyo])
		switch ( $_GET["sort_order"] )
		{
			case "제목순":			$orderby = "guin_title asc";break;
			case "제목역순":		$orderby = "guin_title desc";break;
			case "경력순":			$orderby = "guin_career = '무관', guin_career = '신입', guin_career = '경력', guin_career_year desc";break;
			case "경력역순":		$orderby = "guin_career = '무관', guin_career = '경력', guin_career = '신입', guin_career_year asc";break;
			case "최근등록일순":	$orderby = "guin_date desc";break;
			case "최근등록일역순":	$orderby = "guin_date asc";break;
			case "최근수정일순":	$orderby = "guin_modify desc";break;
			case "최근마감일순":	$orderby = "guin_choongwon, guin_end_date asc";break;
			case "채용마감일순":	$orderby = "guin_end_date desc";break;
			case "채용마감일역순":	$orderby = "guin_end_date asc";break;
			default:				$orderby = "guin_choongwon asc, guin_end_date  asc";break;
		}

		#정렬방법2 (2011-11-15, [hyo])
		switch ( $_GET["sort_order"] )
		{
			case "제목순":			$orderby2 = "title asc";break;
			case "제목역순":		$orderby2 = "title desc";break;
			case "경력순":			$orderby2 = "work_year desc, work_month asc";break;
			case "경력역순":		$orderby2 = "work_year asc, work_month desc";break;
			case "나이순":			$orderby2 = "user_age desc";break;
			case "나이역순":		$orderby2 = "user_age asc";break;
			case "연봉순":			$orderby2 = "grade_money desc";break;
			case "연봉역순":		$orderby2 = "grade_money asc";break;
			case "제의등록일순": case "스크랩등록일순":	$orderby2 = "reg_date desc";break;
			case "제의등록일역순": case "스크랩등록일역순":	$orderby2 = "reg_date asc";break;
			default:				$orderby2 = "number desc";break;
		}
	}
	else
	{
		//정렬순서 추가됨 2011-11-22 kad
		switch ( $ex_order )
		{
			case "최근등록일순":	$orderby = "guin_date desc";break;
			case "등록일순":		$orderby = "guin_date asc";break;
			case "오래된순":		$orderby = "guin_date asc";break;
			case "랜덤추출":		$orderby = "rand()";break;
			case "최근수정순":		$orderby = "guin_modify desc";break;
			case "수정순":			$orderby = "guin_modify asc";break;
			case "최근등록순":		$orderby = "number desc";break;
			case "등록순":			$orderby = "number asc";break;
			case "아이디순":		$orderby = "guin_id asc";break;
			case "아이디역순":		$orderby = "guin_id desc";break;
			default:				$orderby = "guin_choongwon asc, guin_end_date asc";break;
		}



		switch ( $ex_order )
		{
			case "최근등록일순":	$orderby2 = "A.guin_date desc";break;
			case "등록일순":		$orderby2 = "A.guin_date asc";break;
			case "오래된순":		$orderby2 = "A.guin_date asc";break;
			case "랜덤추출":		$orderby2 = "A.rand()";break;
			case "최근수정순":		$orderby2 = "A.guin_modify desc";break;
			case "수정순":			$orderby2 = "A.guin_modify asc";break;
			case "최근등록순":		$orderby2 = "A.number desc";break;
			case "등록순":			$orderby2 = "A.number asc";break;
			case "아이디순":		$orderby2 = "A.guin_id asc";break;
			case "아이디역순":		$orderby2 = "A.guin_id desc";break;
			default:				$orderby2 = "A.guin_choongwon asc, A.guin_end_date asc";break;
		}
		//정렬순서 추가됨 2011-11-22 kad
	}


	#####################################
	if ( $ex_job_type == "스크랩" )
	{
		$sql	= "
				SELECT
						A.*,
						B.number AS bNumber,
						B.pNumber,
						B.cNumber,
						B.userid AS bUserid,
						B.userType,
						B.scrapdate,
						B.point as bPoint,
						B.memo as bMemo
				FROM
						$guin_tb AS A
						INNER JOIN
						$scrap_tb AS B
				ON
						A.number = B.cNumber
				WHERE
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon = '1'
						)
						AND
						B.userid = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
				ORDER BY
						$orderby2
				LIMIT
						$view_rows,$ex_limit
		";

		//echo $sql;

	}
	else if ( $ex_job_type == "입사요청" )
	{
		$sql	= "
				SELECT
						A.*,
						B.number as want_number,
						B.doc_number,
						B.read_ok
				FROM
						$guin_tb AS A
				INNER JOIN
						$com_want_doc_tb AS B
				ON
						A.number = B.guin_number
				INNER JOIN
						$per_document_tb AS C
				ON
						B.doc_number = C.number
				WHERE
						B.per_id = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
						$WHERE2
				LIMIT
						$view_rows,$ex_limit
		";
	}
	else if ( $ex_job_type == "인재스크랩" )
	{
		$sql	= "
				SELECT
						A.*,
						B.scrapdate
				FROM
						$guin_tb AS A
						INNER JOIN
						$scrap_tb AS B
				ON
						A.number = B.cNumber
				WHERE
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon = '1'
						)
						AND
						B.userid = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
				GROUP BY A.number
				ORDER BY
						A.guin_choongwon asc,
						A.guin_end_date asc
				LIMIT
						$view_rows,$ex_limit
		";

		//echo $sql;

	}
	else if ( $ex_job_type == "면접요청" )
	{
		$sql	= "
				SELECT
						A.*,
						B.number as want_number,
						B.doc_number
				FROM
						$guin_tb AS A
						INNER JOIN
						$per_want_doc_tb AS B
				ON
						A.number = B.guin_number
				INNER JOIN
						$per_document_tb AS C
				ON
						B.doc_number = C.number
				WHERE
						B.per_id = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
						$WHERE2
				LIMIT
						$view_rows,$ex_limit
		";
		$jiwon_type		= "per_want";
	}
	else if ( $ex_job_type == "입사제의" )
	{
		$sql	= "
				SELECT
						A.*,
						B.number as want_number,
						B.doc_number,
						B.read_ok
				FROM
						$guin_tb AS A
						INNER JOIN
						$com_want_doc_tb AS B
				ON
						A.number = B.guin_number
				WHERE
						B.com_id = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
				ORDER BY $orderby2
				LIMIT
						$view_rows,$ex_limit
		";
		$jiwon_type		= "com_want";
	}
	else if ( $ex_job_type == "면접제의" )
	{
		$sql	= "
				SELECT
						A.*,
						B.doc_number,
						B.number as want_number
				FROM
						$guin_tb AS A
						INNER JOIN
						$per_want_doc_tb AS B
				ON
						A.number = B.guin_number
				WHERE
						B.com_id = '$user_id'
						AND
						(
							A.guin_end_date >= curdate()
							OR
							A.guin_choongwon ='1'
						)
				GROUP BY A.number
				ORDER BY $orderby2
				LIMIT
						$view_rows,$ex_limit
		";
		$jiwon_type		= "per_want";
	}
	else if ( $ex_job_type == "신입채용" )
	{
		$sql = "select * from $guin_tb where guin_career='신입' order by $orderby limit $view_rows,$ex_limit";
	}
	else if ( $ex_job_type == "열람가능" )
	{
		$sql = "select A.* from $guin_tb AS A INNER JOIN $job_per_guin_view_tb as B ON A.number = B.guin_number where B.per_id = '$user_id' limit $view_rows,$ex_limit ";
	}
	else if ( $ex_type == "오늘본채용정보" )
	{
		$sql = "select * from $guin_tb $last_query  order by $todayOrder limit $view_rows,$ex_limit";
	}
	else
	{
		//$sql = "select * from $guin_tb $last_query  order by $orderby limit $view_rows,$ex_limit";
		$sql = "select * $add_field from $guin_tb $last_query  order by $orderby limit $view_rows,$ex_limit";
	}


	//echo $sql."<br>";

	#####################################
	$result = query($sql);
	#echo "<br>구인리스트쿼리=".$sql;//구인리스트쿼리

	//if(!$_COOKIE['ad_id'] && !$_COOKIE['adult_check'] && !$mem_id)
	//	$adult_check = "1";

	//성인인증여부 체크변수 성인증되면1 안되면0
	$adult_check = happy_adult_check();

	//$총갯수 = mysql_num_rows($result);//총레코드수
	$i = "1";
	$main_new_out = "<table width=100% border=0  cellspacing='0' cellpadding='0' border='0' id='guin_list_top'>";
	//guin_extraction
	while  ($NEW = happy_mysql_fetch_array($result))
	{
		if ( $hunting_use == true && $NEW['company_number'] != 0 )
		{
			//헤드헌팅
			$sql = "select * from $job_company where number = '$NEW[company_number]'";
			$head_info = happy_mysql_fetch_assoc(query($sql));

			$NEW['guin_com_name'] = $head_info['company_name'];
			//echo $NEW['name'].':::'.$NEW['number'].'<br />';
		}

		/*
		$NEW["si1"]		= $siSelect[$NEW["si1"]];
		$NEW["gu1"]		= $guSelect[$NEW["gu1"]];
		$NEW["si2"]		= $siSelect[$NEW["si2"]];
		$NEW["gu2"]		= $guSelect[$NEW["gu2"]];
		$NEW["si3"]		= $siSelect[$NEW["si3"]];
		$NEW["gu3"]		= $guSelect[$NEW["gu3"]];
		*/

		$area_arrow = "&nbsp;";
		$area_slush = " <font color='#CCCCCC'>|</font> ";

		#YOON : 2011-07-21
		$채용지역정보시1	= "";
		$채용지역정보구1	= "";
		$채용지역정보시2	= "";
		$채용지역정보구2	= "";
		$채용지역정보시3	= "";
		$채용지역정보구3	= "";

		$NEW["si1"]			= $siSelect[$NEW["si1"]];
		$NEW["gu1"]			= $guSelect[$NEW["gu1"]];
		$NEW["si2"]			= $siSelect[$NEW["si2"]];
		$NEW["gu2"]			= $guSelect[$NEW["gu2"]];
		$NEW["si3"]			= $siSelect[$NEW["si3"]];
		$NEW["gu3"]			= $guSelect[$NEW["gu3"]];

		if( $NEW["si1"] )
			$채용지역정보시1	= $NEW["si1"];

		if( $NEW["gu1"] )
			$채용지역정보구1	= $area_arrow.$NEW["gu1"];

		if( $NEW["si2"] )
			$채용지역정보시2	= $area_slush.$NEW["si2"];

		if( $NEW["gu2"] )
			$채용지역정보구2	= $area_arrow.$NEW["gu2"];

		if( $NEW["si3"] )
			$채용지역정보시3	= $area_slush.$NEW["si3"];

		if( $NEW["gu3"] )
			$채용지역정보구3	= $area_arrow.$NEW["gu3"];

		$채용지역정보	= $채용지역정보시1.$채용지역정보구1.$채용지역정보시2.$채용지역정보구2.$채용지역정보시3.$채용지역정보구3;

		$NEW["guin_modify_cut"]	= substr($NEW["guin_modify"],0,10);

		if( $NEW["guin_modify_cut"] == "0000-00-00" )
		{
			$NEW["guin_modify_cut"]	= "수정없음";
		}
		else
		{
			$NEW["guin_modify_cut"] = date_view($NEW["guin_modify_cut"], "Y-m-d");
		}

		//위치기반
		$NEW['listNo']	= $i;

		$NEW['ajax_map_num']	= 0;
		if ( $_GET['map_point'] == '' || $_GET['happy_ajax_map_start'] == 'ok' )
		{
			$NEW['ajax_map_num']	= $i;
			//echo $Data['ajax_map_num']."<br>";
		}


		if ( $NEW['metor'] != '' )
		{
			$NEW['중심점거리']	= round($NEW['metor']/1000,2);
		}

		$NEW['metor']			= round($NEW['metor']);

		if ( $NEW['metor'] / 1000 >= 1  )
		{
			$NEW['metor_comma']	= number_format($NEW['metor'] / 1000, 1)." km";
		}
		else
		{
			$NEW['metor_comma']	= number_format($NEW['metor'])." 미터";
		}
		//위치기반

		//print_r($NEW);
		#10000원 또는 급여협의 등으로 추출할 태그가 없어서 추가함
		//echo "$NEW[guin_pay_type] == $HAPPY_CONFIG[WantMoneyArr1] <br />";

		if ( $NEW["guin_pay"] == preg_replace("/\D/","",$NEW["guin_pay"]) )
		{
			$NEW["guin_pay"] = number_format($NEW["guin_pay"])."원";
		}
		#10000원 또는 급여협의 등으로 추출할 태그가 없어서 추가함

		// 급여조건(세전/세후)
		$NEW['pay_type_txt'] = ( $NEW['pay_type'] == 'gross' ) ? '세전' : '세후';

		$NEW['guin_modify'] = $NEW['guin_modify'] == '0000-00-00 00:00:00' ? "미수정" : $NEW['guin_modify'];

		$NEW["guin_pay_icon"]	= $want_money_img_arr[$NEW['guin_pay_type']];
		$NEW["guin_pay_icon2"]	= $want_money_img_arr2[$NEW['guin_pay_type']];

		//print_r2( $NEW );
		$확인여부	= ( $NEW["read_ok"] == "Y" )?"":"(미확인)";
		if ( $ex_job_type == "입사요청" || $ex_job_type == "면접요청" )
		{
			$Sql		= "SELECT * FROM $per_document_tb WHERE number='$NEW[doc_number]' ";
			$DocData	= happy_mysql_fetch_array(query($Sql));
		}
		else if ( $ex_job_type == "입사제의" )
		{
			$Sql		= "SELECT * FROM $per_document_tb WHERE number='$NEW[doc_number]' ";
			$DocData	= happy_mysql_fetch_array(query($Sql));
		}

		if ( $DocData['number'] != '' )
		{
			$DocData["job_type1"]	= $TYPE[$DocData["job_type1"]];
			$DocData["job_type2"]	= $TYPE[$DocData["job_type2"]];
			$DocData["job_type3"]	= $TYPE[$DocData["job_type3"]];

			$DocData['secure']		= $DocData['secure'] == '' ? "없음" : $DocData['secure'];

			global $per_document_pic, $happy_member_upload_folder;

			if ( $DocData["user_image"] == "" )
			{
				$큰이미지	= $main_url."/".$HAPPY_CONFIG['IconGuzicNoImg1'];
				$작은이미지	= $main_url."/".$HAPPY_CONFIG['IconGuzicNoImg1'];
			}
			else if ( !eregi($per_document_pic,$DocData["user_image"]) && strpos($DocData["user_image"],$happy_member_upload_folder) === false )
			{
				if ( !preg_match("/^http/i",$DocData["user_image"]) )
				{
					$큰이미지	= $main_url."/".$DocData["user_image"];
					$작은이미지	= $main_url."/".$DocData["user_image"];
				}
				else
				{
					$큰이미지	= $DocData["user_image"];
					$작은이미지	= $DocData["user_image"];
				}
			}
			else
			{
				$Tmp		= explode(".",$DocData["user_image"]);
				if (preg_match("/jpg/i",$Tmp[sizeof($Tmp)-1]))
				{
					$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], "_thumb.".$Tmp[sizeof($Tmp)-1], $DocData["user_image"]);
				}
				else
				{
					$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], ".".$Tmp[sizeof($Tmp)-1], $DocData["user_image"]);
				}
				$큰이미지	= $DocData["user_image"];
				$작은이미지	= $Tmp2;

				if ( !preg_match("/^http/i",$DocData["user_image"]) )
				{
					$큰이미지	= $main_url."/".$DocData["user_image"];
					$작은이미지	= $main_url."/".$DocData["user_image"];
				}
				else
				{
					$큰이미지	= $DocData["user_image"];
					$작은이미지	= $DocData["user_image"];
				}
			}

			//if( $adult_check != "1" && $Data['use_adult'])
			//{
			//	$이미지정보 = $HAPPY_CONFIG['adult_guzic'];
			//
			//	//새로운썸네일
			//	$Happy_Img_Name[0] = "".$HAPPY_CONFIG['adult_guzic'];
			//}
			//else{
				$이미지정보	= $작은이미지;

				//새로운썸네일
				//$Happy_Img_Name[0] = ".".$작은이미지;
				$DocData['img']	= ".".$작은이미지;
			//}
		}

		$NEW[adult_guin_icon] = "";

		//19금 일경우 아이콘 넣어 주자!
		if( $adult_check != "1" && $NEW['use_adult'])
		{
			$NEW[adult_guin_icon] = "<img src=".$HAPPY_CONFIG['adult_guin_list']." border='0' alt='성인전용' align=absmiddle style='margin-bottom:3px; margin-left:4px;'>";
		}




		$j ='0'; #type
		$this_bold = "";
		$NEW[icon] = "";
		foreach ($ARRAY as $list)
		{
			$list_option = $list . "_option";

			if ($CONF[$list_option] == '기간별')
			{
				$NEW[$list] = $NEW[$list] - $real_gap; #날짜가 마이너스인 사람은 광고가 끝인사람임
			}

			if ($NEW[$list] > 0 && $j != '3')
			{
				#볼드는 아이콘을 안보여준다
				$NEW[icon] .= "<img src=$ARRAY_NAME2[$j] border=0 align=absmiddle>&nbsp;";
			}

			if ($NEW[$list] > 0 && $j == '3')
			{
				$this_bold = "1";
			}
			$j++;
		}
		#echo $NEW['icon']."<br>";

		#$NEW['underground1']	= ( $NEW['underground1'] == 0 )?"정보없음":$undergroundTitle[$NEW['underground1']];
		$NEW['underground1']	= ( $NEW['underground1'] == 0 )? $HAPPY_CONFIG['MsgNoInputUnderground1'] :$undergroundTitle[$NEW['underground1']];
		$NEW['underground2']	= $undergroundTitle[$NEW['underground2']];


		$NEW['guin_age_real'] = "";
		if ( $NEW[guin_age] == "0" )
		{
			#$NEW[guin_age] = "제한 없음";
			$NEW[guin_age] = $HAPPY_CONFIG['MsgNoGuinAge1'];
		}
		else
		{
			$NEW[guin_age] = "$NEW[guin_age] 년 이후 출생자";


			//echo (date("Y")-$NEW[guin_age]+1)."<br>";
			$NEW['guin_age_real'] = (date("Y")-$NEW[guin_age]+1)."세 이하";
		}

		#채용분야
		$NEW[type]	= '';
		$NEW[type_short]	= '';
		if ($NEW[type1])
		{
			$TYPE_SUB{$NEW[type_sub1]}	= ( $TYPE_SUB{$NEW[type_sub1]} == '' )?"":$TYPE_SUB{$NEW[type_sub1]};
			$NEW[type]	.= $NEW[type] == '' ? '' : ', ';
			$NEW[type]	.= "".$TYPE{$NEW[type1]} ;
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB{$NEW[type_sub1]} != '' ? "-" . $TYPE_SUB{$NEW[type_sub1]} : '';

			$NEW[type_short]	.= $NEW[type_short] == '' ? '' : ', ';
			$NEW[type_short]	.= "".$TYPE{$NEW[type1]} ;
		}
		if ($NEW[type2])
		{
			$TYPE_SUB{$NEW[type_sub2]}	= ( $TYPE_SUB{$NEW[type_sub2]} == '' )?"":$TYPE_SUB{$NEW[type_sub2]};
			$NEW[type]	.= $NEW[type] == '' ? '' : ', ';
			$NEW[type]	.= "".$TYPE{$NEW[type2]} ;
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB{$NEW[type_sub2]} != '' ? "-" . $TYPE_SUB{$NEW[type_sub2]} : '';

			$NEW[type_short]	.= $NEW[type_short] == '' ? '' : ', ';
			$NEW[type_short]	.= "".$TYPE{$NEW[type2]} ;
		}
		if ($NEW[type3])
		{
			$TYPE_SUB{$NEW[type_sub3]}	= ( $TYPE_SUB{$NEW[type_sub3]} == '' )?"":$TYPE_SUB{$NEW[type_sub3]};
			$NEW[type]	.= $NEW[type] == '' ? '' : ', ';
			$NEW[type]	.= "".$TYPE{$NEW[type3]} ;
			$NEW[type]	.= $NEW[type] != '' && $TYPE_SUB{$NEW[type_sub3]} != '' ? "-" . $TYPE_SUB{$NEW[type_sub3]} : '';

			$NEW[type_short]	.= $NEW[type_short] == '' ? '' : ', ';
			$NEW[type_short]	.= "".$TYPE{$NEW[type3]} ;
		}

		#$NEW[type]	= $NEW[type] == '' ? "<font color='gray'>정보없음</font>":$NEW[type];
		$NEW[type]	= $NEW[type] == '' ? "<font color='gray'>".$HAPPY_CONFIG['MsgNoInputType1']."</font>":$NEW[type];

		$NEW["scrapdate"]	= explode(" ",$NEW["scrapdate"]);

		#경력 여부
		$NEW['guin_career_icon'] = '';
		if ( $NEW[guin_career] == "경력" )
		{
			$NEW[guin_career] = "경력 $NEW[guin_career_year]↑";

			$NEW['guin_career_icon'] = '<img src="img/guin_career_yes.gif" align="absmiddle" border="0" alt="경력">';
		}
		elseif ( $NEW[guin_career] == "무관" )
		{
			$NEW[guin_career] = "경력 무관";

			$NEW['guin_career_icon'] = '<img src="img/guin_career_no.gif" align="absmiddle" border="0" alt="무관">';
		}
		else if ( $NEW['guin_career'] == "신입" )
		{
			$NEW[guin_career] = "신입";

			$NEW['guin_career_icon'] = '<img src="img/guin_career_new.gif" align="absmiddle" border="0" alt="신입">';
		}


		//성별
		$NEW['guin_gender_icon'] = '';
		if ( $NEW['guin_gender'] == "무관" )
		{
			$NEW['guin_gender_icon'] = '<img src="img/guin_gender_no.gif" align="absmiddle" border="0" alt="무관">';
		}
		else if ( $NEW['guin_gender'] == "여자" )
		{
			$NEW['guin_gender_icon'] = '<img src="img/guin_gender_woman.gif" align="absmiddle" border="0" alt="여자">';
		}
		else if ( $NEW['guin_gender'] == "남자" )
		{
			$NEW['guin_gender_icon'] = '<img src="img/guin_gender_man.gif" align="absmiddle" border="0" alt="남자">';
		}

		//진행or마감여부
		if ( $NEW['guin_choongwon'] || $NEW['guin_end_date'] > date("Y-m-d") )
		{
			$NEW['guin_end_text']	= "진행중";
		}
		else
		{
			$NEW['guin_end_text']	= "마감";
		}

		//채용마감일의 D-day
		$NEW['guin_end_date_dday'] = "";
		if ( $NEW[guin_choongwon] )
		{
			$NEW[guin_end_date] = "<span class='font_st_11' style='color:#3f3f3f;'>상시채용</span>";
		}
		else
		{
			//채용마감일의 D-day
			$tnow = date("Y-m-d H:i:s");
			$NEW['guin_end_date_dday'] = '<div style=" color:#4a4a4a;" class=font_12_tahoma><b >'."D-".happy_date_diff($tnow,$NEW[guin_end_date]).'</b></div>';

			//<div style="border:1px solid #dbdbdb; background-color:#f9f9f9;"></div>

			if ( happy_date_diff($tnow,$NEW[guin_end_date]) < 0 )
			{
				$NEW['guin_end_date']	= "<span class='d_day' style='letter-spacing:0'>마감</span>";
			}
			else
			{
				$dday_interval = date("Y-m-d",strtotime($NEW["guin_end_date"]."-{$HAPPY_CONFIG[guin_end_date_dday]} day"));
				if(date("Y-m-d") == $NEW["guin_end_date"])
				{
					$NEW['guin_end_date']	= "D-day";
				}
				else if(date("Y-m-d") >= $dday_interval)
				{
					$NEW['guin_end_date']	= "<span class='d_day' style='letter-spacing:0'>D-".happy_date_diff(date("Y-m-d"),$NEW['guin_end_date'])."</span>";
				}
			}
		}

		#식사제공, 보너스, 주5일근무 jobwork
		if( $NEW["guin_bokri"] )
		{
			if( preg_match( "/식사제공/", $NEW["guin_bokri"] ) )
			{
				$NEW["식사제공"] = "<img src='./img/ico_txt_food.gif' title='식사제공' style='vertical-align:middle'>";
				$NEW["식사제공2"] = "<span class='food_text_icon'>식사제공</span>";
			}

			if( preg_match( "/보너스/", $NEW["guin_bokri"] ) )
			{
				$NEW["보너스"] = "<img src='./img/ico_txt_bonus.gif' title='보너스' style='vertical-align:middle'>";
				$NEW["보너스2"] = "<span class='bouns_text_icon'>보너스</span>";
			}

			if( preg_match( "/주5일근무/", $NEW["guin_bokri"] ) )
			{
				$NEW["식사제공"] = "<img src='./img/ico_txt_week5.gif' title='주5일근무' style='vertical-align:middle'>";
				$NEW["주5일근무2"] = "<span class='ju4_text_icon'>주4일</span>";
			}
		}

		#우대조건 jobwork
		if( $NEW["guin_woodae"] )
		{
			$NEW["우대조건"] = "<img src='./img/ico_commercial_udae.gif' title='우대조건' style='vertical-align:middle'>";
			$NEW["우대조건2"] = "<span class='woodae_text_icon'>우대조건</span>";
		}

		/////////////////날짜 자르고 비교하기
		$NEW["guin_date_cut"]	= substr($NEW["guin_date"],0,10);
		$NEW[guin_date] = explode(" ",$NEW[guin_date]);
		$today = date("Y-m-d");
		if ( $NEW[guin_date][0] == $today )
		{
			#$NEW[new_icon] = "<img src='bbs_img/icon_new.gif' align=absmiddle>&nbsp; ";
			$NEW[new_icon] = "<img src='".$HAPPY_CONFIG['IconGuinNew1']."' align=absmiddle>";
		}
		else
		{
			$NEW[new_icon] = "";
		}

		$NEW[title] = kstrcut($NEW[guin_title], $ex_title_cut, "..."); #type
		if ($this_bold)
		{
			$NEW[title] = "<font style='color:$guin_title_color; font-weight:$guin_title_bold;'>$NEW[title]</font>";
		}
		$NEW[name] = kstrcut($NEW[guin_com_name], $ex_title_cut, "...");

		#업체로고구하기
		#bnl 로고 , bns 배너광고용
		$Tmem = happy_member_information($NEW['guin_id']);
		//$bns_img = $Tmem['photo2'];
		//$bnl_img = $Tmem['photo3'];

		//개별 채용정보에 저장된 이미지를 사용하기 위해서 DB 컨버팅함
		$bns_img = $NEW['photo2'];
		$bnl_img = $NEW['photo3'];

		$NEW['com_name'] = $Tmem['com_name'];

		if ( $bnl_img == "" )
		{
			#$NEW[com_logo] = "./img/logo_img.gif";
			$NEW[com_logo] = "./".$HAPPY_CONFIG['IconComNoLogo1']."";
		}
		else
		{
			$logo_img = explode(".",$bnl_img);
			$logo_temp = $logo_img[0].".".$logo_img[1];

			if ( file_exists("./$logo_temp" ) )
			{
				$NEW[com_logo] = "./$logo_temp";
			}
			else
			{
				$NEW[com_logo] = "./$bnl_img";
			}
		}

		if ( $bns_img == "" )
		{
			#$NEW[logo] = "./img/logo_img.gif";
			$NEW[logo] = "./".$HAPPY_CONFIG['IconComNoBanner1']."";
		}
		else
		{
			$banner_img = explode(".",$bns_img);
			$banner_temp = $banner_img[0].".".$banner_img[1];
			if ( file_exists("./$banner_temp" ) )
			{
				$NEW[logo] = "./$banner_temp";
			}
			else
			{
				$NEW[logo] = "./$bns_img";
			}
		}



		#bgcolor 옵션
		$NEW['bgcolor1'] = "";
		$NEW['bgcolor2'] = "";
		$list = $ARRAY[10];
		$list_option = $list . "_option";
		if ($CONF[$list_option] == '기간별')
		{
			#$NEW[$list] = $NEW[$list] - $real_gap;		#위에서 미리 빼므로 주석
			#echo $NEW[$list]."<br>";
			if ( $NEW[$list] > 0 )
			{
				if($NEW['guin_bgcolor_select'] == '')
				{
					$NEW['guin_bgcolor_select'] = $guin_title_bgcolor;
				}
				$NEW['bgcolor1'] = "<span style='margin:5px 0; padding:2px; box-sizing:border-box; background:$NEW[guin_bgcolor_select];'>";
				$NEW['bgcolor2'] = "</span>";
			}
		}
		#bgcolor 옵션

		#아이콘옵션
		$NEW['freeicon_com_out'] = "";
		$list = $ARRAY[11];
		$list_option = $list . "_option";

		if ($CONF[$list_option] == '기간별')
		{
			#$NEW[$list] = $NEW[$list] - $real_gap;		#위에서 미리 빼므로 주석
			if ( $NEW[$list] > 0 )
			{
				if ( $NEW['freeicon_com'] != '' )
				{
					$NEW['freeicon_com_out'] = '<img src="img/'.$NEW['freeicon_com'].'" align=absmiddle>';
				}
			}
		}
		#아이콘옵션

		#채용형태는 아이콘으로 추가됨
		$NEW['guin_type_icon'] = guin_type_icon($NEW['guin_type']);

		#활동가능요일
		$TempDays = explode(" ",$NEW['work_day']);
		$NEW['work_day'] = '';
		foreach($TempDays as $k => $v)
		{
			$Yicon = $TDayIcons[$v];
			if ( $v != '' )
			{
				$NEW['work_day'] .= '<img src="'.$Yicon.'" border="0" align="absmiddle">';
			}
		}
		if ( $NEW['work_day'] == '' )
		{
			$NEW['work_day'] = $HAPPY_CONFIG['MsgNoInputDay1'];
		}
		#활동가능요일

		#근무시간
		if ( $NEW['start_worktime'] != '' )
		{
			$TStartWorkTime = explode("-",$NEW['start_worktime']);
			$NEW['start_worktime'] = $TStartWorkTime[0]." ".$TStartWorkTime[1]."시".$TStartWorkTime[2];
		}
		else
		{
			$NEW['start_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
		}

		if ( $NEW['finish_worktime'] != '' )
		{
			$TFinishWorkTime = explode("-",$NEW['finish_worktime']);
			$NEW['finish_worktime'] = $TFinishWorkTime[0]." ".$TFinishWorkTime[1]."시".$TFinishWorkTime[2];
		}
		else
		{
			$NEW['finish_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
		}

		#구직자
		if ( $NEW['guinperson'] == '' )
		{
			$NEW['guinperson'] = $HAPPY_CONFIG['MsgNoInputguzicperson1'];
		}

		#학력
		if ( $NEW['guineducation'] == '' )
		{
			$NEW['guineducation'] = $HAPPY_CONFIG['MsgNoInputguziceducation1'];
		}

		#국적
		if ( $NEW['guinnational'] == '' )
		{
			$NEW['guinnational'] = $HAPPY_CONFIG['MsgNoInputguzicnational1'];
		}

		#파견업체
		if ( $NEW['guinsicompany'] == '' )
		{
			$NEW['guinsicompany'] = $HAPPY_CONFIG['NoInputguzicsicompany1'];
		}

		#총개수
		$sub_cnt = "SELECT count(*) FROM $per_want_doc_tb as A LEFT JOIN $per_document_tb as B ON A.doc_number = B.number WHERE A.guin_number='$NEW[number]'";
		list($NEW["총개수"]) = mysql_fetch_row(query($sub_cnt));


		//리스트에서 스크랩하기 기능 추가
		$스크랩버튼				= "";
		$스크랩버튼2			= "";
		$script_scrap_empty		= "onClick=\"happy_scrap_change('per','per',$NEW[number],1,$guin_extraction_count);\"";
		$script_scrap_fill		= "onClick=\"happy_scrap_change('per','per_del',$NEW[number],1,$guin_extraction_count);\"";
		$script_scrap_empty2	= "onClick=\"happy_scrap_change('per','per',$NEW[number],2,$guin_extraction_count);\"";
		$script_scrap_fill2		= "onClick=\"happy_scrap_change('per','per_del',$NEW[number],2,$guin_extraction_count);\"";
		$scrap_msg_id			= "<span id='per_scrap_msg_{$guin_extraction_count}_{$NEW[number]}' style='display:none'></span>";
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$scrap_img_empty	= "<img src='mobile_img/star_ico_01.png' alt='☆' $script_scrap_empty style='vertical-align:middle'>";
			$scrap_img_fill		= "<img src='mobile_img/star_ico_fill_01.png' alt='★' $script_scrap_fill style='vertical-align:middle'>";
			$scrap_img_empty2	= "<img src='mobile_img/star_ico_02.gif' alt='☆2' $script_scrap_empty2 style='vertical-align:middle'>";
			$scrap_img_fill2	= "<img src='mobile_img/star_ico_fill_02.gif' alt='★2' $script_scrap_fill2 style='vertical-align:middle'>";
		}
		else
		{
			$scrap_img_empty	= "<img src='img/star_ico_01.png' alt='☆' $script_scrap_empty style='vertical-align:middle'>";
			$scrap_img_fill		= "<img src='img/star_ico_fill_01.png' alt='★' $script_scrap_fill style='vertical-align:middle'>";
			$scrap_img_empty2	= "<img src='img/star_ico_02.gif' alt='☆2' $script_scrap_empty2 style='vertical-align:middle'>";
			$scrap_img_fill2	= "<img src='img/star_ico_fill_02.gif' alt='★2' $script_scrap_fill2 style='vertical-align:middle'>";
		}


		if ( $happy_member_login_value == "" )
		{
			$returnUrl		= (preg_match("/ajax_guin_list/",$_SERVER['PHP_SELF']))?"guin_list.php":$_SERVER['PHP_SELF'];
			$스크랩버튼		= "<a href=\"javascript:void(0);\" onclick=\"if(confirm('로그인 후 이용 가능한 서비스입니다.\\n지금 로그인 하시겠습니까?')){location.replace('happy_member_login.php?returnUrl=$returnUrl');}\" style='vertical-align:middle'>$scrap_img_empty</a>";
			$스크랩버튼2		= "<a href=\"javascript:void(0);\" onclick=\"if(confirm('로그인 후 이용 가능한 서비스입니다.\\n지금 로그인 하시겠습니까?')){location.replace('happy_member_login.php?returnUrl=$returnUrl');}\" style='vertical-align:middle'>$scrap_img_empty2</a>";
		}
		else if ( !$스크랩권한 )
		{
			$스크랩버튼		= "<a href='javascript:void(0);' onclick='alert(\"스크렙 권한이 없습니다.\");'>$scrap_img_empty<a>";
			$스크랩버튼2		= "<a href='javascript:void(0);' onclick='alert(\"스크렙 권한이 없습니다.\");'>$scrap_img_empty2<a>";
		}
		else if ( $스크랩권한 && $happy_member_login_value != "" )
		{
			$Sql	= "SELECT Count(*) FROM $scrap_tb WHERE cNumber='$NEW[number]' AND userid='$happy_member_login_value' AND userType='per' ";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			if ( $Tmp[0] == 0 )
			{
				$returnUrl	= $_SERVER["REQUEST_URI"];
				$returnUrl	= str_replace("&","??",$returnUrl);

				$스크랩버튼		= "<span id='per_scrap_img_{$guin_extraction_count}_{$NEW[number]}' style='cursor:pointer; vertical-align:middle'>".$scrap_img_empty."</span> $scrap_msg_id";
				$스크랩버튼2	= "<span id='per_scrap_img_{$guin_extraction_count}_{$NEW[number]}' style='cursor:pointer; vertical-align:middle'>".$scrap_img_empty2."</span> $scrap_msg_id";
			}
			else
			{
				$스크랩버튼		= "<span id='per_scrap_img_{$guin_extraction_count}_{$NEW[number]}' style='cursor:pointer; vertical-align:middle'>".$scrap_img_fill."</span> $scrap_msg_id";
				$스크랩버튼2	= "<span id='per_scrap_img_{$guin_extraction_count}_{$NEW[number]}' style='cursor:pointer; vertical-align:middle'>".$scrap_img_fill2."</span> $scrap_msg_id";
			}
		}
		//리스트에서 스크랩하기 기능 추가


		#수정날짜 글 자르기
		$NEW['guin_modify']	= substr($NEW['guin_modify'],0,10);

		#echo $ex_template;
		$TPL->define("$i-$ex_template", "./$skin_folder/$ex_template");
		$TPL->assign("$i-$ex_template");
		$main_new = &$TPL->fetch("$i-$ex_template");


		#TD를 정리하자
		if ($ex_width == "1")
		{
			$main_new = "<tr><td valign=top align=center class='type'>" . $main_new . "</td></tr>";
		}
		elseif ($i % $ex_width == "1")
		{
			$main_new = "<tr><td valign=top align=center class='type'>" . $main_new . "</td>";
		}
		elseif ($i % $ex_width == "0")
		{
			$main_new = "<td valign=top align=center class='type'>" . $main_new . "</td></tr>";
		}
		else
		{
			$main_new = "<td valign=top align=center class='type'>" . $main_new . "</td>";
		}
		$main_new_out .= $main_new;


		$i ++;
	}

	// 빈 TD  붙여주기
	//echo "총개수 : ".$채용정보수.", 현재 페이지 출력개수 : ".($i-1).", 가로 출력개수 : ".$ex_width."<br>";
	if ( $ex_width > 1 )
	{
		$blank_html		= "";
		$ex_template2	= str_replace(".html","_no.html",$ex_template);
		if ( file_exists("./$skin_folder/$ex_template2") )
		{
			$rand2222		= rand(0,10000);
			$TPL->define("빈자리$rand2222", "./$skin_folder/$ex_template2");
			$TPL->assign("빈자리$rand2222");
			$blank_html		= $TPL->fetch("빈자리$rand2222");
		}

		for( $j = 0; $j < ($ex_width-($i-1)); $j++ )
		{
			$main_new_out .= "
			<td valign=top align=center class='type'>
				{$blank_html}
			</td>";
		}
	}
	// 빈 TD  붙여주기

	$main_new_out .= "</table>";

	#검색값 한글들 모두 인코딩 되도록 수정함 2010-01-15 kad
	$plus	.= "action=search";
	if ( $_GET['search_si'] != "" )
	{
		$plus	.= "&search_si=".urlencode($_GET['search_si']);
	}
	if ( $_GET['search_gu'] != "" )
	{
		$plus	.= "&search_gu=".urlencode($_GET['search_gu']);
	}
	if ( $_GET['search_type'] != "" )
	{
		$plus	.= "&search_type=".urlencode($_GET['search_type']);
	}
	if ( $_GET['search_type_sub'] != "" )
	{
		$plus	.= "&search_type_sub=".urlencode($_GET['search_type_sub']);
	}
	if ( $_GET['career_read'] != "" )
	{
		$plus	.= "&career_read=".urlencode($_GET['career_read']);
	}
	if ( $_GET['gender_read'] != "" )
	{
		$plus	.= "&gender_read=".urlencode($_GET['gender_read']);
	}
	if ( $_GET['pay_read'] != "" )
	{
		$plus	.= "&pay_read=".urlencode($_GET['pay_read']);
	}

	if ( is_array($_GET['edu_read']) && count($_GET['edu_read']) >= 1 )
	{
		foreach( $_GET['edu_read'] as $edu_read_val )
		{
			if ( $edu_read_val != "" )
			{
				$plus	.= "&edu_read[]=".urlencode($edu_read_val);
			}
		}
	}
	else
	{
		if ( $_GET['edu_read'] != "" )
		{
			$plus	.= "&edu_read=".urlencode($_GET['edu_read']);
		}
	}

	if ( $_GET['job_type_read'] != "" )
	{
		$plus	.= "&job_type_read=".urlencode($_GET['job_type_read']);
	}
	if ( $_GET['grade_read'] != "" )
	{
		$plus	.= "&grade_read=".urlencode($_GET['grade_read']);
	}
	if ( $_GET['title_read'] != "" )
	{
		$plus	.= "&title_read=".urlencode($_GET['title_read']);
	}
	if ( $_GET['guzic_jobtype1'] != "" )
	{
		$plus	.= "&guzic_jobtype1=".urlencode($_GET['guzic_jobtype1']);
	}
	if ( $_GET['guzic_jobtype2'] != "" )
	{
		$plus	.= "&guzic_jobtype2=".urlencode($_GET['guzic_jobtype2']);
	}
	if ( $_GET['file'] != "" )
	{
		$plus	.= "&file=".urlencode($_GET['file']);
	}
	if ( $_GET['underground1'] != "" )
	{
		$plus	.= "&underground1=".urlencode($_GET['underground1']);
	}
	if ( $_GET['underground2'] != "" )
	{
		$plus	.= "&underground2=".urlencode($_GET['underground2']);
	}
	if ( $_GET['file2'] != "" )
	{
		$plus	.= "&file2=".urlencode($_GET['file2']);
	}
	#추가된 검색필드들
	if ( $_GET['guin_pay_type'] != "" )
	{
		$plus	.= "&guin_pay_type=".urlencode($_GET['guin_pay_type']);
	}
	if ( $_GET['guzicnational'] != "" )
	{
		$plus	.= "&guzicnational=".urlencode($_GET['guzicnational']);
	}
	if ( $_GET['guzic_age_start'] != "" )
	{
		$plus	.= "&guzic_age_start=".urlencode($_GET['guzic_age_start']);
	}
	if ( $_GET['guzic_age_end'] != "" )
	{
		$plus	.= "&guzic_age_end=".urlencode($_GET['guzic_age_end']);
	}
	if ( $_GET['diff_regday'] != "" )
	{
		$plus	.= "&diff_regday=".urlencode($_GET['diff_regday']);
	}
	if ( $_GET['mode'] != "" )
	{
		$plus	.= "&mode=".urlencode($_GET['mode']);
	}

	$plus	.= "&guin_per_start_date=".urlencode($_GET['guin_per_start_date']);
	$plus	.= "&guin_per_end_date=".urlencode($_GET['guin_per_end_date']);
	$plus	.= "&search_word=".urlencode($_GET['search_word']);

	$Total			= $numb;
	$scale			= $ex_limit;
	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 2 : 6;

	$searchMethod	.= $plus;

	if ( $ajax_paging == '1' )
	{
		$page_print = newPaging_ajax( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		//include ("ajax_section_page.php");
		#print "ddddddddddddddddd".$total_count_script;
	}
	else
	{
		if ($ex_category =="검색")
		{
			include ("./search_page.php");
		}
		else
		{
			//$page_print = '';
			//include ("./page.php");
			$page_print		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		}
	}

	#print "$main_new_out ";
	#ex_paging 페이징사용안함 루틴 추가됨
	if ( $ex_paging != "사용안함" )
	{
		$main_new_out = $main_new_out . "<center class='paging'>" . $page_print . "</center> ";
	}

	return print $main_new_out;
}

######################################################

function vote_read()
{
////////////////////////////////////매장정보를 읽어온다.
	global $skin_folder,$vote_tb,$TPL,$투표제목,$투표내용,$투표버튼,$가로,$세로,$위쪽여백,$왼쪽여백;


	$sql4 = "select * from $vote_tb where number ='0'";
	$result4 = query($sql4);
	list($number,$title1,$title2,$title3,$title4,$title5,$vote1,$vote2,$vote3,$vote4,$vote5,$real_title,$last_ip,$width,$height,$graph_width,$w_top,$w_left,$reg_date) = mysql_fetch_row($result4);

	if ($title1)
	{
		$title1_info = "<INPUT type=radio value=1 name=option_selected  checked >$title1<br>";
	}
	if ($title2)
	{
		$title2_info = "<INPUT type=radio value=2 name=option_selected >$title2<br>";
	}
	if ($title3)
	{
		$title3_info = "<INPUT type=radio value=3 name=option_selected >$title3<br>";
	}
	if ($title4)
	{
		$title4_info = "<INPUT type=radio value=4 name=option_selected >$title4<br>";
	}
	if ($title5)
	{
		$title5_info = "<INPUT type=radio value=5 name=option_selected >$title5<br>";
	}
	$투표내용 = "$title1_info$title2_info$title3_info$title4_info$title5_info";
	$투표버튼 = "
		<input type=image src='img/bt_poll_1.gif' border='0' ></a>
		<img src='img/bt_poll_2.gif'  border='0' onclick=\"window.open('job_vote.php','hero','width=$width,height=$height,scrollbars=no,top=$w_top,left=$w_left')\"
		onmouseover=\"this.style.cursor='pointer'\">
	";


	$vote = "
	<form method=post action=job_vote.php name=poll onsubmit=\"open('wait.html','hero','height=$height,width=$width,top=$w_top,left=$w_left')\"  target=hero >
	  <table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
		<tr>
		  <td align=\"left\">

	  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			<tr>
			  <td height=\"20\" align=\"left\" valign=\"middle\">

	  <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				<tr>
				  <td><font color=\"#666666\"><b>$real_title</b></font></td>
				</tr>
			  </table>

				</td>
			</tr>
				<td height=\"5\"></td>
			<tr>
			</tr>
			<tr>
			  <td height=\"\" align=\"left\" valign=\"top\">

			<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				<tr>
				  <td>$투표내용</td>
				</tr>
			  </table>

			</td>
			</tr>
			<tr>
				<td height=\"5\"></td>
			</tr>
			<tr>
			  <td align=\"center\" valign=\"middle\">$투표버튼</td>
			</tr>
		  </table>

		</td>
		</tr>
	  </table>
</form>
	";

	return $vote;
}






#{{설문 세로1개,가로1개,자동,전체,poll_main.html,poll_rows_list.html,최근등록순}}
function poll_read($heightSize,$widthSize,$keyword,$progress,$poll_templete,$poll_templete2,$poll_sort="") {

	global $upso2_poll_1,$upso2_poll_2,$TPL;
	global $skin_folder,$poll_template,$poll_template2,$vote_graph,$percent,$radio_name,$vote_percent,$random;
	global $VOTE_HEAD,$Data2,$Data6, $답변내용, $답변결과, $radio_disabled,$progress_end;

	$heightSize		= preg_replace('/\D/', '', $heightSize);
	$widthSize		= preg_replace('/\D/', '', $widthSize);
	if ( $heightSize == "" || $heightSize == 0 )
	{
		return print "<font color='red'>세로출력 개수를 지정하지 않으셨습니다.</font>";
	}
	else if ( $widthSize == "" || $widthSize == 0 )
	{
		return print "<font color='red'>가로출력 개수를 지정하지 않으셨습니다.</font>";
	}
	else if ( $keyword == "" )
	{
		return print "<font color='red'>키워드가 없습니다.</font>";
	}
	else if ( ($progress != "전체" && $progress != "진행" && $progress != "마감") || $progress == "" )
	{
		return print "<font color='red'>진행중 여부를 지정하지 않으셨습니다.</font>";
	}


	if ($keyword == "자동")
	{
		$keyword = $_GET["poll_keyword"];
	}

	if ($keyword != "" && $keyword != "자동")
	{
		$keyword_sql = "AND keyword like '%$keyword%'";
	}

	$start	= 0;
	$offset	= $heightSize * $widthSize;
	$scale	= $offset;



	switch ( $progress )
	{
		case "전체":	$add_sql	 = "";break;
		case "진행":	$add_sql	 = "AND progress='Y' AND NOW() between startDate AND endDate";break;
		case "마감":	$add_sql	 = "AND progress='N'";break;
		default :		$add_sql	 = "";break;
	}

	switch ( $poll_sort )
	{
		case "등록번호순":	$orderBy = "number asc";break;
		case "최근등록순":	$orderBy = "number desc";break;
		case "제목순":		$orderBy = "real_title asc";break;
		case "제목역순":	$orderBy = "real_title desc";break;
		case "랜덤":		$orderBy = "rand() ";break;
		default :			$orderBy = "number desc";break;
	}


	$sql4	 = "select * from $upso2_poll_1 where 1=1 $keyword_sql $add_sql order by $orderBy limit $start,$scale";
	$result4 = query($sql4);

	$now_time = date('Y-m-d H:i:s');

	$random	= rand(0,9999);

	$Count		= 0;

	$content	= "<table align='center' border='0' width='100%'>\n<tr>\n";

	$content	.= "<form method='post' action='job_poll.php' name='poll$random' onsubmit=\"open('about:blank','hero','height=$height,width=$width,top=$top,left=$left,scrollbars=yes')\"  target='hero' id=''pollFrm'>
	<input type='hidden' name='votetype' value=''>
	";

	$TPL->define("설문제목".$random, "$skin_folder/$poll_templete");
	$TPL->define("설문내용".$random, "$skin_folder/$poll_templete2");

	$radio_chk_script = "";
	while($VOTE_HEAD = happy_mysql_fetch_array($result4))
	{
		$top	= $VOTE_HEAD["w_top"];
		$left	= $VOTE_HEAD["w_left"];
		$width	= $VOTE_HEAD["width"];
		$height = $VOTE_HEAD["height"];
		$graph_width = $VOTE_HEAD["graph_width"];

		$VOTE_HEAD["gigan"] = "";

		if ( $VOTE_HEAD["progress"] != "N" && $VOTE_HEAD['endDate'] > $now_time)
		{
			$start_Date = substr($VOTE_HEAD["startDate"],2,11) . '시';
			$end_Date = substr($VOTE_HEAD["endDate"],2,11) . '시';

			## [ YOON : 2008-10-17 ] #############################
			$VOTE_HEAD["gigan"] = "
			$start_Date ~ $end_Date
			";

			#$VOTE_HEAD["gigan"] = $start_Date." ~ ".$end_Date;
		}

		$Count++;
		$content .= "<td>\n";


		$sql6 = "select count(*),SUM(vote) from $upso2_poll_2 where poll_1_number ='$VOTE_HEAD[number]' AND title !='' order by sort asc";
		$result6 = query($sql6);
		$row	= happy_mysql_fetch_array($result6);


		$sql5 = "select * from $upso2_poll_2 where poll_1_number ='$VOTE_HEAD[number]' AND title !='' order by sort asc";
		$result5 = query($sql5);

		if ( $VOTE_HEAD['progress'] == 'Y' )
		{
			$radio_disabled	= "";
		}
		else
		{
			$radio_disabled	= "disabled";
		}

		$radio_name = "check_vote_".$VOTE_HEAD[number];


		$답변내용	= "";
		while($Data2 = happy_mysql_fetch_array($result5))
		{
			$vote_graph = @(($Data2['vote'] / $row[1]) * $graph_width);
			$vote_graph = @ceil($vote_graph);

			$vote_percent = @ceil(($Data2['vote']  / $row[1]) * 100);

			$답변내용 .= $TPL->fetch("설문내용".$random);
		}
		$답변결과	= $답변내용;

		if( $VOTE_HEAD['progress'] == 'N' || $VOTE_HEAD['endDate'] < $now_time )
		{
			$답변내용	= $progress_end;
		}
		else
		{
			$radio_chk_script .= "
				 var radio_arr=document.poll${random}['${radio_name}'];
				 var radio_cnt=radio_arr.length;
				 var chk=false;
				 for(i=0;i<radio_cnt;i++){
				   if(radio_arr[i].checked){
					 chk=true;
					 break;
				   }
				 }
				 if(!chk){
				   alert('투표를 선택 해주세요');
				   radio_arr[0].focus();
				   return false;
				 }

			";
		}

		$content .= $TPL->fetch("설문제목".$random);

		$content	.= "</td>\n";
		if ( $Count % $widthSize == 0 )
		{
			$content .= "</tr><tr>\n";
		}
	}

	if ( $Count % $widthSize != 0 )
	{
		for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
		{
			$content	.= "<td>&nbsp;</td>\n";
		}
		//$content	.= "</tr><tr><td colspan='$widthSize' background=img/img_dot.gif height=1></td>";
	}

	$content	.= "</tr>\n";
	$content	.= "</form>\n";
	$content	.= "</table>";

	if ( $Count == 0 )
	{
		$content	= "<table height='100' border='0' width='100%'><tr><td align='center'>검색된 설문이 없습니다.</td></tr></table>";
	}

	$content	.= "
		<script>
			function go_vote_$random( votetype_val )
			{
				if (votetype_val == 'in_enter' || votetype_val == 'up_vote' )
				{
					$radio_chk_script
				}

				if ( votetype_val != 'up_vote')
				{
					window.open('','vote_result_popup','top=$top,left=$left,width=$width,height=$height,toolbar=no,scrollbars=yes');
					document.poll$random.target = 'vote_result_popup';
					poll$random.action = 'job_poll.php';
					document.poll$random.votetype.value = votetype_val;
					document.poll$random.submit();
				}
				else
				{
					document.poll$random.target = '';
					document.poll$random.votetype.value = votetype_val;
					poll$random.action = 'job_poll_file.php?file=poll_multi_detail_result.html&poll_keyword=$keyword';
					document.poll$random.submit();
				}
			}
		</script>
	";


	/*$content	.= "<center><img src='img/poll_multi/btn_vote.gif' border='0' onClick=\"go_vote_$random( 'in_enter' )\" style='cursor:pointer'>
			<img src='img/poll_multi/btn_vote_result.gif' border='0' onclick=\"window.location.href='html_file.php?file=poll_multi_detail_result.html';\" style='cursor:pointer'>";*/

	return print $content;

}







function input_stats()
{
	global $stats_name, $stats_file,$duplication,$stats_tb,$cookie_url;

	$php_self	= $_SERVER["PHP_SELF"];
	$stats_size	= sizeof($stats_name);
	$nowDate	= date("Y-m-d");
	$nowTime	= date("H");
	$nowWeek	= date("w");

	if ($duplication == "1")
	{
		if ( !isset($_COOKIE[check_stats]) )
		{
			#중복카운팅방지
			setcookie("check_stats",1,0,"/",$cookie_url);
		}
		else
		{
			return; #중복방지가 켜있으면 끝낸다
		}
	}

	$Sql	= "SELECT number FROM $stats_tb WHERE regdate='$nowDate' AND regtime='$nowTime' ";
	$Data	= happy_mysql_fetch_array(query($Sql));

	if ( $Data["number"] != "" )
	{
		$setQuery	= " totalCount=totalCount+1 ";

		for ( $i=0, $j=1, $Colum="" ; $i<$stats_size ; $i++,$j++ )
		{
			if ( eregi($stats_file[$i],$php_self) )
			{
				$Colum	= "page".$j."Count";
				$setQuery	.= " , $Colum = $Colum + 1 ";
				break;
			}
		}
		if ( $Colum == "" )
		{
			$setQuery	.= " , etcPageCount = etcPageCount + 1 ";
		}

		$Sql	= "UPDATE $stats_tb SET $setQuery WHERE number='". $Data["number"] ."' ";
	}
	else
	{
		$setQuery	 = " regdate='$nowDate' ";
		$setQuery	.= " , regtime='$nowTime' ";
		$setQuery	.= " , regweek='$nowWeek' ";
		$setQuery	.= " , totalCount='1' ";

		for ( $i=0, $j=1, $Colum="" ; $i<$stats_size ; $i++,$j++ )
		{
			if ( eregi($stats_file[$i],$php_self) )
			{
				$Colum	= "page".$j."Count";
				$setQuery	.= " , $Colum = '1' ";
				break;
			}
		}

		if ( $Colum == "" )
		{
			$setQuery	.= " , etcPageCount = '1' ";
		}

		$Sql	= "INSERT INTO $stats_tb SET $setQuery ";
	}

	query($Sql);

}


function dateSelectBox( $inputName, $start, $end, $values="", $printText="", $default="", $option="", $step=1 , $optionOnly="no" )
{
	# $yearSelect		= dateSelectBox( "year", 2004, 2012, $year, "년", "선택", "onChange='this.form.submit()'" );
	# $monSelect		= dateSelectBox( "mon", 1, 12, $mon, "월", "선택", "onChange='this.form.submit()'" );
	# $daySelect		= dateSelectBox( "day", 1, 31, $day, "일", "선택", "onChange='this.form.submit()'" );
	# $scaleSelect		= dateSelectBox( "scale", 5, 100, $scale, "개", "선택", "onChange='this.form.submit()'" , 5);
	# 사용법 : dateSelectBox( 셀렉트이름, 시작번호, 종료번호, 셀렉트될값, 옵션숫자뒤표시될글, 첫옵션명, 셀렉트옵션, 숫자증가치)

	$select	 = ( $optionOnly=="no" )?"<select name='$inputName' $option>\n":"";

	if ( $default != "" )
	{
		$select	.= "\t	<option value=''>$default</option>\n";
	}

	if ( $step > 0 )
	{
		for ( $i=$start ; $i<=$end ; $i=$i+$step )
		{
			$selectd	= ( $i == $values )?"selected":"";
			$val		= ( $i < 10 && $end > 10 )?"0".$i:$i;
			$select		.= "\t	<option value='$val' $selectd>".$i." $printText</option>\n";
		}
	}

	if ( $step < 0 )
	{
		for ( $i=$start ; $i>=$end ; $i=$i+$step )
		{
			$selectd	= ( $i == $values )?"selected":"";
			$val		= ( $i < 10 && $end > 10 )?"0".$i:$i;
			$select		.= "\t	<option value='$val' $selectd>".$i." $printText</option>\n";
		}
	}

	$select	.= ( $optionOnly=="no" )?"</select>":"";

	return $select;
}



###############################################################
#######################     이미지 업로드 함수     ##########################
###############################################################


function imageUpload($folder_path, $gi_joon, $height_gi_joon, $garo_gi_joon, $sero_gi_joon, $picture_quality, $img_name, $ii, $checkExt="", $mark="" )
{
	# 사용법
	# imgaeUpload(업로드경로, 큰이미지가로, 큰이미지세로, 작은이미지가로, 작은이미지세로, 품질, 업로드된이름, 업로드배열, 확장자)
	# imageUpload("./upload/imsi","400","600","120","150","90","user_image","");
	# 업로드된 이름은.. <input type="file" name="업로드된이름" >
	# 업로드된 이름을 입력하면 됩니다.
	# 업로드배열 부분에는 업로드된 이미지들의 이름이 배열일경우 ( img[0] , img[1]...) 이름부분에는 img 배열부분에는 0,1,2,.....
	# $path는 홈디렉토리의 pwd

	global $path, $_FILES;
	global $pic_ok_ext;

	$ii					= preg_replace("/\D/","",$ii);
	$upImageName		= ($ii=="")?$_FILES[$img_name]["name"]:$_FILES[$img_name]["name"][$ii];
	$upImageTemp		= ($ii=="")?$_FILES[$img_name]["tmp_name"]:$_FILES[$img_name]["tmp_name"][$ii];
	#echo "$ii $upImageName $upImageTemp ";
	$now_time			= happy_mktime();

	$rand_number		= rand(1000,9999). $ii;
	$temp_name			= explode(".",$upImageName);
	$ext				= strtolower($temp_name[sizeof($temp_name)-1]);
	$img_url_re			= "$folder_path/$now_time-$rand_number.$ext";
	$img_url_re_thumb	= "$folder_path/$now_time-$rand_number"."_thumb.$ext";


	#파일 확장자 체크때문에 추가됨
	if ($ext != "")
	{
		if (in_array($ext,$pic_ok_ext))
		{
			if ( $upImageTemp != '' )
			{
				$imgchk				= copy($upImageTemp,"$img_url_re");
			}
		}
		else
		{
			$comma = "";
			foreach($pic_ok_ext as $an => $av)
			{
				$ext_list .= $comma." ".$av." ";
				$comma = ",";
			}
			error("업로드가 가능한 파일의 확장자는 $ext_list 입니다.");
			return;
		}
	}



	#파일 확장자 체크때문에 추가됨

	if ( $imgchk && eregi("jp",$ext) )
	{
		#썸네일을 만들어보자
		$imagehw		= GetImageSize("$img_url_re");
		$imagewidth		= $imagehw[0];
		$imageheight	= $imagehw[1];

		//가로기준 세로사이즈 계산
		$new_height		= $gi_joon * $imageheight / $imagewidth ;
		$new_height		= ceil($new_height);

		#썸네일을 만들어보자2
		$bg				= ImageCreateFromJPEG("$path/img/logo/800600.jpg");
		$thumb			= ImageCreate($gi_joon,$new_height);
		$thumb			= imagecreatetruecolor($gi_joon,$new_height);
		imagecopyresampled($thumb,$bg,0,0,0,0,$gi_joon,$new_height,$gi_joon,$height_gi_joon);

		$src			= ImageCreateFromJPEG("$img_url_re");
		imagecopyresampled($thumb,$src,0,0,0,0,$gi_joon,$new_height,$imagewidth,$imageheight);

		#일단 쪼끄만거부터 맹글자
		ImageJPEG($thumb,"$img_url_re",$picture_quality);


		#새 이미지에 글자위치 정하자
		/*
		if ( $mark == "" && is_file("$path/img/logo/logo.png") !== false )
		{
			$logo			= ImageCreateFromPng("$path/img/logo/logo.png");
			$logo_width		= imagesx($logo);
			$logo_height	= imagesy($logo);
			imagecopy($thumb,$logo,0,$height_gi_joon-$logo_height,0,0,$logo_width,$logo_height);
			ImageDestroy($logo);
		}
		*/


		ImageJPEG($thumb,"$img_url_re",$picture_quality);
		ImageDestroy($thumb);
		ImageDestroy($bg);

		return $img_url_re;

	}
	else if ( $imgchk )
	{
		return $img_url_re;
	}
	else
	{
		return "";
	}


}





function imageUpload2($img_name, $img_name_new, $gi_joon, $height_gi_joon, $picture_quality, $mark="" )
{
	# 사용법
	# imgaeUpload(업로드경로& 파일네임, 생성할이미지경로& 파일네임, 큰이미지가로, 큰이미지세로, 품질,  확장자)
	# $path는 홈디렉토리의 pwd

	global $path, $_FILES;
	global $pic_ok_ext;

	$img_url_re			= $img_name_new;

	#썸네일을 만들어보자
	$imagehw		= GetImageSize("$img_name");
	$imagewidth		= $imagehw[0];
	$imageheight	= $imagehw[1];
	$new_height		= $gi_joon * $imageheight / $imagewidth ;
	$new_height		= ceil($new_height);

	#썸네일을 만들어보자2
	$bg				= ImageCreateFromJPEG("$path/img/logo/800600.jpg");
	$thumb			= ImageCreate($gi_joon,$height_gi_joon);
	$thumb			= imagecreatetruecolor($gi_joon,$height_gi_joon);
	imagecopyresampled($thumb,$bg,0,0,0,0,$gi_joon,$height_gi_joon,$gi_joon,$height_gi_joon);

	$imagehw		= GetImageSize("$img_name");
	$imagewidth		= $imagehw[0];
	$imageheight	= $imagehw[1];
	$new_height		= $gi_joon * $imageheight / $imagewidth ;
	$new_height		= ceil($new_height);

	$src			= ImageCreateFromJPEG("$img_name");
	imagecopyresampled($thumb,$src,0,0,0,0,$gi_joon,$new_height,$imagewidth,$imageheight);

	#일단 쪼끄만거부터 맹글자
	ImageJPEG($thumb,"$img_name_new",$picture_quality);

	#새 이미지에 글자위치 정하자
	/*
	if ( $mark == "" && is_file("$path/img/logo/logo.png") !== false )
	{
		$logo			= ImageCreateFromPng("$path/img/logo/logo.png");
		$logo_width		= imagesx($logo);
		$logo_height	= imagesy($logo);
		imagecopy($thumb,$logo,0,$height_gi_joon-$logo_height,0,0,$logo_width,$logo_height);
		ImageDestroy($logo);
	}
	*/

	ImageJPEG($thumb,"$img_name_new",$picture_quality);
	ImageDestroy($thumb);
	ImageDestroy($bg);

	return $img_url_re;

}






####################### 이미지 업로드 함수 끝 ############################


function call_document()
{
}


##############################################################


function jikjok_extraction_list( $widthSize, $heightSize , $tableSize, $Template1 , $Template2 , $cutSize="")
{
	global $type_tb , $type_sub_tb, $skin_folder, $Data, $DataSub, $직무분야내용, $TPL ,$체크된수, $checked, $per_document_tb, $subMode;

	$widthSize	= preg_replace("/\D/","",$widthSize);
	$heightSize	= preg_replace("/\D/","",$heightSize);
	$tableSize	= preg_replace("/\D/","",$tableSize);
	$cutSize	= preg_replace("/\D/","",$cutSize);

	$number		= $_GET["number"];

	if ( $number == "" && $subMode != 'all' )
	{
		error("잘못된경로로 접근하셨습니다.");
		exit;
	}
	else
	{
		$Sql	= "
			SELECT
					job_type_sub1,
					job_type_sub2,
					job_type_sub3
			FROM
					$per_document_tb
			WHERE
					number	= '$number'
		";

		$Temp		= happy_mysql_fetch_array(query($Sql));
		$jType[0]	= "kwak1004";
		$jType[1]	= $Temp["job_type_sub1"];
		$jType[2]	= $Temp["job_type_sub2"];
		$jType[3]	= $Temp["job_type_sub3"];
	}

	if ( $widthSize == "" )
	{
		echo "<font color='red'>가로출력수가 입력되지 않았습니다.</font>";
		exit;
	}
	if ( $heightSize == "" )
	{
		echo "<font color='red'>세로출력수가 입력되지 않았습니다.</font>";
		exit;
	}
	if ( $tableSize == "" )
	{
		echo "<font color='red'>테이블가로사이즈가 입력되지 않았습니다.</font>";
		exit;
	}
	if ( $Template1 == "" )
	{
		echo "<font color='red'>내용물 템플릿 파일이 지정되지 않았습니다.</font>";
		exit;
	}
	if ( $Template2 == "" )
	{
		echo "<font color='red'>껍데기 템플릿 파일이 지정되지 않았습니다.</font>";
		exit;
	}
	if ( $cutSize == "" )
	{
		$cutSize	= 20;
	}

	$maxSize	= $widthSize * $heightSize;
	$tdSize		= floor($tableSize / $widthSize);


	$Sql	= "SELECT * FROM $type_tb ORDER BY sort_number ASC";
	$Record	= query($Sql);


	$TPL->define("직무분야내용", "./$skin_folder/$Template1");
	$TPL->define("직무분야껍데기", "./$skin_folder/$Template2");


	$content	= "";
	$startSize	= 1;
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$Sql	= "SELECT * FROM $type_sub_tb WHERE type='$Data[number]' order by number ASC LIMIT 0,$maxSize";
		$RecSub	= query($Sql);

		$count	= 0;
		$subContent	= "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";

		while ( $DataSub = happy_mysql_fetch_array($RecSub) )
		{
			$DataSub["type_sub_cut"]	= kstrcut($DataSub["type_sub"],$cutSize,"...");

			if ( $DataSub["number"] == $jType[$startSize] )
			{
				$checked	= "checked";
				$startSize++;
			}
			else
			{
				$checked	= "";
			}

			$subContent	.= ( $count % $widthSize == 0 )?"</tr><tr>":"";
			$subContent	.= "<td width='$tdSize'>".$TPL->fetch("직무분야내용")."</td>";

			$count++;
		}

		if ( $count % $widthSize != 0 )
		{
			for ( $i = $count % $widthSize ; $i < $widthSize ; $i++ )
			{
				$subContent	.= "<td width='$tdSize'>&nbsp;</td>";
			}
		}
		$subContent		.= "</tr></table>";

		$직무분야내용	= $subContent;
		$체크된수	= $startSize;
		$content	.= $TPL->fetch("직무분야껍데기");
	}

	return print $content;

}

//document.php
//guin_regist.php
//guin_mod.php 파일에서 사용됨
function keyword_extraction_list( $widthSize, $heightSize , $tableSize, $Template1 , $Template2 , $cutSize="",$mode)
{
	global $document_keyword, $skin_folder, $Data, $DataSub, $키워드내용, $TPL ,$key, $per_document_tb, $guin_tb, $checked, $키워드, $subMode;
	global $happy_member_secure_text;

	$widthSize	= preg_replace("/\D/","",$widthSize);
	$heightSize	= preg_replace("/\D/","",$heightSize);
	$tableSize	= preg_replace("/\D/","",$tableSize);
	$cutSize	= preg_replace("/\D/","",$cutSize);

	$number		= $_GET["number"];
	$num		= $_GET["num"];

	//이력서 수정이고 이력서 등록권한이 있거나 관리자거나
	if ( $mode == "document" && ( $number != "" && happy_member_secure($happy_member_secure_text[0].'등록') || ( $number != "" && $_COOKIE["ad_id"] != "" ) ) )
	{
		$Sql	= "SELECT keyword FROM $per_document_tb WHERE number='$number' ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$keyword	= $Temp["keyword"];

		#키워드가 변경될 경우 실제 존재하는 것만 보이도록 패치
		$TmpKeyword = explode("/",$keyword);
		$keyword = "";
		if ( is_array($TmpKeyword) )
		{
			foreach($TmpKeyword as $k => $v)
			{
				#echo $v."<br>";
				if ( in_array($v,$document_keyword) )
				{
					$keyword.= $slash.$v;
					$slash = "/";
				}
			}
		}
		#echo $keyword;
		#키워드가 변경될 경우 실제 존재하는 것만 보이도록 패치

		$키워드		= $keyword;

	}
	//채용정보 수정이고 채용정보 등록권한이 있거나 관리자거나
	else if ( $mode == "guin" && ( $num != "" && happy_member_secure($happy_member_secure_text[1].'등록') ) || ( $num != "" && $_COOKIE["ad_id"] != "" ) )
	{
		$Sql	= "SELECT keyword FROM $guin_tb WHERE number='$num' ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$keyword	= $Temp["keyword"];

		#키워드가 변경될 경우 실제 존재하는 것만 보이도록 패치
		$TmpKeyword = explode(", ",$keyword);		#기업회원은 , 으로 잘라야함
		$keyword = "";
		if ( is_array($TmpKeyword) )
		{
			foreach($TmpKeyword as $k => $v)
			{
				#echo $v."<br>";
				if ( in_array($v,$document_keyword) )
				{
					$keyword.= $slash.$v;
					$slash = ", ";
				}
			}
		}
		#echo $keyword;
		#키워드가 변경될 경우 실제 존재하는 것만 보이도록 패치

		$키워드		= $keyword;
	}
	else if ( happy_member_secure($happy_member_secure_text[1].'등록') )
	{
		//채용정보 등록시에 호출될 경우
		$keyword	= "";
		$키워드		= "";
	}
	else if ( $subMode != 'all' )
	{
		error("잘못된 경로로 접근하셨습니다.");
	}


	if ( $widthSize == "" )
	{
		echo "<font color='red'>가로출력수가 입력되지 않았습니다.</font>";
		exit;
	}
	if ( $heightSize == "" )
	{
		echo "<font color='red'>세로출력수가 입력되지 않았습니다.</font>";
		exit;
	}
	if ( $tableSize == "" )
	{
		echo "<font color='red'>테이블가로사이즈가 입력되지 않았습니다.</font>";
		exit;
	}
	if ( $Template1 == "" )
	{
		echo "<font color='red'>내용물 템플릿 파일이 지정되지 않았습니다.</font>";
		exit;
	}
	if ( $Template2 == "" )
	{
		echo "<font color='red'>껍데기 템플릿 파일이 지정되지 않았습니다.</font>";
		exit;
	}
	if ( $cutSize == "" )
	{
		$cutSize	= 20;
	}

	$maxSize	= $widthSize * $heightSize;
	$tdSize		= floor($tableSize / $widthSize);

	$TPL->define("키워드내용", "./$skin_folder/$Template1");
	$TPL->define("키워드껍데기", "./$skin_folder/$Template2");

	$content	= "";

	$subContent	= "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
	for ( $i=0 , $max = sizeof($document_keyword) ; $i<$max && $i<$maxSize ; $i++ )
	{
		$key		= $document_keyword[$i];
		if ( $key != "")
		{
			$key_cut	= kstrcut($key,$cutSize,"...");

			$key = str_replace("+","\+",$key);
			if ( strpos($keyword , $key) !== false )
			{
				$checked	= "checked";
			}
			else
			{
				$checked	= "";
			}

			$subContent = str_replace("\+","+",$subContent);
			$subContent	.= ( $i % $widthSize == 0 )?"</tr><tr>":"";
			$subContent	.= "<td width='$tdSize' class='font_14' style='height:22px'>".$TPL->fetch("키워드내용")."</td>";
		}
	}

	if ( $i % $widthSize != 0 )
	{
		for ( $i = $i % $widthSize ; $i < $widthSize ; $i++ )
		{
			$subContent	.= "<td width='$tdSize'>&nbsp;</td>";
		}
	}
	$subContent		.= "</tr></table>";

	$키워드내용	= $subContent;

	$content	.= $TPL->fetch("키워드껍데기");

	return $content;

}

//이력서리스트아작스
function document_extraction_list_ajax( $widthSize, $heightSize, $option1, $option2, $option3, $option4, $orderBy, $cutSize, $limitStart, $template1, $pagingCheck="사용안함", $extract_type = "",$ex_option="",$loading_type="",$ex_career_read="")//jobwork 15
{
	global $section_ajax_num;
	global $HAPPY_CONFIG,$happy_wide_map_fileName2;

	$idName		= "section_ajax_$section_ajax_num";
	$layerName	= "section_ajax_layer_$section_ajax_num";

	$value		= urlencode("$widthSize,$heightSize,$option1,$option2,$option3,$option4,$orderBy,$cutSize,$limitStart,$template1,$pagingCheck,$extract_type,$ex_option,$loading_type,$ex_career_read");//jobwork 15

	$query_string = "&".$_SERVER['QUERY_STRING'];

	if ( $loading_type == '' )
	{
		$content	= "
						<div id='$layerName' name='$layerName' $layerOption><table width='100%' height='100%'><tr><td align=center><img src='img/ajax_loading.gif'></td></tr></table></div>
						<input type='hidden' id='$idName' name='$idName' value=\"$value\">
						<input type='hidden' id='happy_map_latlng' name='happy_map_latlng' value=\"\">

						<script>
							var ajax$section_ajax_num	= new GLM.AJAX();

							ajax${section_ajax_num}.callPage(
									'ajax_guzic_list.php?ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}${query_string}&vals='+document.getElementById('$idName').value + '&happy_ajax_map_start=ok',
									function(response) {
										//alert(response);
										document.getElementById('$layerName').innerHTML	= response;

										if ( document.getElementById('guzic_counting') != undefined )
										{
											document.getElementById('guzic_counting').innerHTML = document.getElementById('happy_map_total_count_tmp').value;
										}
										//happy_map_markAdd_ALL();
									}
							);

							//alert('ajax_guzic_list.php?vals='+document.getElementById('$idName').value);
						</script>
		";
	}
	else
	{
		$content	= "
						<div id='$layerName' name='$layerName' $layerOption>
							<table width='100%' height='100%'>
								<tr>
									<td align='center' height='200'><img src='img/ajax_loading.gif'></td>
								</tr>
							</table>
						</div>

						<input type='hidden' id='$idName' name='$idName' value=\"$value\">
						<input type='hidden' id='map_point_now' name='map_point_now' value=\"$_GET[map_point]\">
						<input type='hidden' id='happy_map_latlng' name='happy_map_latlng' value=\"\">

						<script>
							var ajax${section_ajax_num}	= new GLM.AJAX();


							var ajax${section_ajax_num}_func	= function()
							{
								ajax${section_ajax_num}.callPage(
										'ajax_guzic_list.php?ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}${query_string}&vals='+document.getElementById('$idName').value+'&happy_ajax_map_start=ok',
										function(response) {
											//alert(response);
											document.getElementById('$layerName').innerHTML	= response;
										}
								);
							}

							oldonload = window.onload;

							if ( typeof window.onload != 'function' )
							{
								//window.onload = ajax${section_ajax_num}_func;
								window.onload	= function() { setTimeout('happy_map_my_point_change_end()',1500); }
							}
							else
							{
								window.onload = function() {
									oldonload();
									//ajax${section_ajax_num}_func();
									setTimeout('happy_map_my_point_change_end()',1500);
								}
							}

							//alert('ajax_guzic_list.php?vals='+document.getElementById('$idName').value);
						</script>
		";
	}


	#구인구직은 페이징옵션이 없음
	if ( $pagingCheck != '사용안함' )
	{
		//PC화면
		if ( $_COOKIE['happy_mobile'] != 'on' )
		{
			$content	.= "
				<script>

					function gopaging${section_ajax_num}( pageNo )
					{
						document.getElementById('$layerName').innerHTML	= \"<table width='100%' height='100%'><tr><td align=center><img src='img/ajax_loading.gif'></td></tr></table>\";

						ajax${section_ajax_num}.callPage(
								'ajax_guzic_list.php?ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}${query_string}&start='+pageNo+'&vals='+document.getElementById('$idName').value,
								function(response) {
									document.getElementById('$layerName').innerHTML	= response;
								}
						);
					}

				</script>
			";
		}
		else
		{
			if( $HAPPY_CONFIG['wide_map_type'] == 'google' && $_SERVER['PHP_SELF'] == $happy_wide_map_fileName2 )
			{
				$map_point_script		= "map_point='+map_point";
				$map_size_script		= "'&map_size='+happy_map_mapObj.getZoom()";

				$content	.= "
					<script>

						function gopaging${section_ajax_num}( pageNo )
						{
							document.getElementById('$layerName').innerHTML	= \"<table width='100%' height='100%'><tr><td align=center height='200'><img src='img/ajax_loading.gif'></td></tr></table>\";

								//alert(document.getElementById('map_point_now').value);
								happy_map_markRemoveAll();
								happy_map_setZoom_level	= 1;

								happy_map_search_word	= ( happy_map_ie == '1' )? document.getElementById('happy_map_search').value : encodeURI(document.getElementById('happy_map_search').value) ;

								if ( document.getElementById('happy_map_si') != undefined )
								{
									happy_map_search_si_tmp	= document.getElementById('happy_map_si').options[document.getElementById('happy_map_si').selectedIndex].value;
								}
								else
								{
									happy_map_search_si_tmp	= '';
								}

								if ( happy_map_search_si_tmp != '' )
								{
									happy_map_search_si_tmp	= happy_map_search_si_tmp.split('__');

									happy_map_search_si		= happy_map_search_si_tmp[0];
									happy_map_search_si_x	= happy_map_search_si_tmp[1];
									happy_map_search_si_y	= happy_map_search_si_tmp[2];

									happy_map_mapObj.setCenter(new google.maps.LatLng(happy_map_search_si_x,happy_map_search_si_y));
									happy_map_mapObj.setZoom(happy_map_search_si_map_size);

								}
								else
								{
									happy_map_search_si		= '';
									happy_map_search_si_x	= '';
									happy_map_search_si_y	= '';
								}

								if ( document.getElementById('happy_map_latlng') == undefined || document.getElementById('happy_map_type') == undefined || document.getElementById('happy_map_type').checked == false )
								{
									happy_map_latlng_value	= '';
								}
								else
								{
									happy_map_bound_func();
									happy_map_latlng_value	= document.getElementById('happy_map_latlng').value;
								}

								// google woo
								var map_point	= happy_map_mapObj.getCenter().lat() + ',' + happy_map_mapObj.getCenter().lng();

								//직종검색
								search_type_value = '';
								search_type_sub_value = '';
								if ( document.happy_map_search_form.search_type != undefined )
								{
									search_type_value = document.happy_map_search_form.search_type[document.happy_map_search_form.search_type.selectedIndex].value;
								}
								if ( document.happy_map_search_form.search_type_sub != undefined )
								{
									search_type_sub_value = document.happy_map_search_form.search_type_sub[document.happy_map_search_form.search_type_sub.selectedIndex].value;
								}

							ajax${section_ajax_num}.callPage(
									'ajax_guzic_list.php?$map_point_script
									+'&ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}${query_string}&start='+pageNo
									+'&vals='+document.getElementById('$idName').value
									+'&happy_map_latlng='+happy_map_latlng_value
									+'&now_map_search='+document.getElementById('happy_map_type').checked
									+'&happy_map_search='+happy_map_search_word
									+'&happy_map_category='+document.getElementById('happy_map_category').value
									+'&happy_map_ie='+happy_map_ie
									+'&get_si='+ happy_map_search_si
									+'&search_metor=".$_GET['search_metor']."'
									+'&guzic_jobtype1='+search_type_value
									+'&guzic_jobtype2='+search_type_sub_value,
									function(response) {
										//alert(response);
										document.getElementById('$layerName').innerHTML	= response;

										happy_map_markAdd_ALL();
									}
							);
						}

					</script>
				";

			}
			//네이버지도쓸때
			else if( $HAPPY_CONFIG['wide_map_type'] == 'naver' && $_SERVER['PHP_SELF'] == $happy_wide_map_fileName2 )
			{
				$map_point_script		= "map_point='+happy_map_mapObj.fromTM128ToLatLng(happy_map_mapObj.getCenter())";
				$map_size_script		= "'&map_size='+happy_map_mapObj.getZoom()";


				$content	.= "
					<script>

						function gopaging${section_ajax_num}( pageNo )
						{
							document.getElementById('$layerName').innerHTML	= \"<table width='100%' height='100%'><tr><td align=center height='200'><img src='img/ajax_loading.gif'></td></tr></table>\";

									//alert(document.getElementById('map_point_now').value);
									happy_map_markRemoveAll();
									happy_map_setZoom_level	= 1;

									happy_map_search_word	= ( happy_map_ie == '1' )? document.getElementById('happy_map_search').value : encodeURI(document.getElementById('happy_map_search').value) ;

									if ( document.getElementById('happy_map_si') != undefined )
									{
										happy_map_search_si_tmp	= document.getElementById('happy_map_si').options[document.getElementById('happy_map_si').selectedIndex].value;
									}
									else
									{
										happy_map_search_si_tmp	= '';
									}

									if ( happy_map_search_si_tmp != '' )
									{
										happy_map_search_si_tmp	= happy_map_search_si_tmp.split('__');

										happy_map_search_si		= happy_map_search_si_tmp[0];
										happy_map_search_si_x	= happy_map_search_si_tmp[1];
										happy_map_search_si_y	= happy_map_search_si_tmp[2];

										//happy_map_center_change(happy_map_search_si_x,happy_map_search_si_y,happy_map_search_si_map_size);
										//happy_map_mapObj.setCenterAndZoom(new NLatLng(happy_map_search_si_x,happy_map_search_si_y),happy_map_search_si_map_size);
										happy_map_mapObj.setCenter(new naver.maps.LatLng(happy_map_search_si_x,happy_map_search_si_y),happy_map_search_si_map_size);
									}
									else
									{
										happy_map_search_si		= '';
										happy_map_search_si_x	= '';
										happy_map_search_si_y	= '';
									}

									happy_map_new_points	= happy_map_mapObj.getCenter();
									happy_map_my_point_value= happy_map_new_points.y+','+happy_map_new_points.x;
									happy_map_my_point_chk	= '';

									if ( document.getElementById('happy_map_latlng') == undefined || document.getElementById('happy_map_type') == undefined || document.getElementById('happy_map_type').checked == false )
									{
										happy_map_latlng_value	= '';
									}
									else
									{
										happy_map_bound_func();
										happy_map_latlng_value	= document.getElementById('happy_map_latlng').value;
									}

									//직종검색
									search_type_value = '';
									search_type_sub_value = '';
									if ( document.happy_map_search_form.search_type != undefined )
									{
										search_type_value = document.happy_map_search_form.search_type[document.happy_map_search_form.search_type.selectedIndex].value;
									}
									if ( document.happy_map_search_form.search_type_sub != undefined )
									{
										search_type_sub_value = document.happy_map_search_form.search_type_sub[document.happy_map_search_form.search_type_sub.selectedIndex].value;
									}



							ajax${section_ajax_num}.callPage(
									'ajax_guzic_list.php?ajaxNum=${section_ajax_num}'
									+'&ajaxLayer=${layerName}'
									+'${query_string}'
									+'&start='+pageNo
									+'&vals='+document.getElementById('$idName').value
									+'&happy_map_latlng='+happy_map_latlng_value
									+'&now_map_search='+ document.getElementById('happy_map_type').checked
									+'&happy_map_search='+  happy_map_search_word
									+'&happy_map_category='+  document.getElementById('happy_map_category').value
									+'&happy_map_ie='+happy_map_ie
									+'&get_si='+ happy_map_search_si
									+'&search_metor=".$_GET['search_metor']."'
									+'&search_type='+search_type_value
									+'&search_sub_type='+search_type_sub_value
									+'&guzic_jobtype1='+search_type_value
									+'&guzic_jobtype2='+search_type_sub_value
									+'&map_point='+happy_map_my_point_value
									,
									function(response) {
										//alert(response);
										document.getElementById('$layerName').innerHTML	= response;

										happy_map_markAdd_ALL();
									}
							);
						}

					</script>
				";

			}
			//모바일에서 지도아닌 일반 페이징
			else
			{
				$content	.= "
					<script>

						function gopaging${section_ajax_num}( pageNo )
						{
							document.getElementById('$layerName').innerHTML	= \"<table width='100%' height='100%'><tr><td align=center><img src='img/ajax_loading.gif'></td></tr></table>\";

							ajax${section_ajax_num}.callPage(
									'ajax_guzic_list.php?ajaxNum=${section_ajax_num}&ajaxLayer=${layerName}${query_string}&start='+pageNo+'&vals='+document.getElementById('$idName').value,
									function(response) {
										document.getElementById('$layerName').innerHTML	= response;
									}
							);
						}

					</script>
				";
			}
			//모바일에서 지도아닌 일반 페이징
		}

	}
	$section_ajax_num++;
	return print $content;
}
##############################################################

//{{이력서리스트 가로,세로,옵션1,옵션2,옵션3,옵션4,정렬순서,글자짜름,누락개수,알맹이html,껍데기html}}
// 2011-11-22 kad
//추출태그에서 페이징사용유무를 선택하지 못하도록
//항상 페이징을 사용하도록 변경함
$doc_extraction_unique_number = 5000;	//이력서 마다 고유출력번호
function document_extraction_list( $widthSize, $heightSize, $option1, $option2, $option3, $option4, $orderBy, $cutSize, $limitStart, $template1,$pagingCheck="페이징사용",$extract_type = "",$ex_option="",$ex_career_read = "")//jobwork 14
{
	#{{이력서리스트 가로,세로,옵션1,옵션2,옵션3,옵션4,정렬순서,글자짜름,누락개수,알맹이html,껍데기html,페이징사용유무}}
	#옵션1 -> 지역선택
	#옵션2 -> 직종선택
	#옵션3 -> 특별/신규/전체/총지원자/미열람/예비합격자등 선택
	#옵션4 -> 회원선택(마이페이지에서 주로 이용) , (경력)3년이상 , (학력)대학졸업이상
	#각 옵션에 값에 (검색안함)을 붙이시면 검색이 안됩니다..

	//print_r(func_get_args());

	global $TPL, $skin_folder, $siSelect, $siNumber, $guSelect, $guNumber, $TYPE, $TYPE_SUB;
	global $per_document_tb, $per_worklist_tb, $per_skill_tb, $per_language_tb, $per_yunsoo_tb, $document_keyword, $per_document_pic, $skillArray, $doc_search_color;
	global $com_guin_per_tb, $scrap_tb, $searchMethod, $TYPE_SUB_NUMBER, $doc_title_color,$doc_title_bgcolor;
	global $Data, $OPTION, $회사수 ,$기술수, $언어수, $파일수, $연수횟수, $페이징, $내용, $큰이미지, $작은이미지, $이미지정보, $페이징, $이력서수, $비공개, $사용중인옵션;
	global $mem_id,$real_gap,$job_com_doc_view_tb, $edu_arr, $want_money_img_arr, $want_money_img_arr2;
	global $keyword_read;

	global $HAPPY_CONFIG;
	global $TDayIcons;
	global $CONF;
	global $PER_ARRAY_DB,$PER_ARRAY,$PER_ARRAY_NAME;
	global $ajax_paging,$ajaxNum,$page_print;
	global $doc_extraction_return;
	global $TYPE_NUMBER;
	global $guin_tb;
	global $WantSearchDoc ;			#맞춤인재정보
	global $TYPE_NUMBER;
	global $happy_member_secure_text;
	global $happy_member_option_type;
	global $online_stats;			//온라인입사지원 단계
	global $Happy_Img_Name;

	//패키지옵션 사용하는데서 사용
	global $구직정보유료옵션;

	global $mobile_scroll_count; //모바일
	global $boodong_metor,$search_metor,$naver_no_member_call_id;

	global $hunting_use, $happy_member_login_value; //헤드헌팅
	global $happy_member_upload_folder;

	global $tool_tip_layer;

	global $job_underground_tb;
	global $채용지역정보,$지원방식;

	global $happy_member;

	global $cgp_all_cnt,$doc_ok_y_cnt,$doc_ok_n_cnt,$read_ok_n_cnt;	//전체지원자,예비합격,불합격,미열람 카운트 - ranksa

	global $GUIN_INFO;
	global $doc_extraction_unique_number;
	global $SI_NUMBER;

	//검색폼의 이름을 고유하게 만들기 위해서
	$doc_extraction_unique_number++;


	$widthSize		= preg_replace("/\D/","",$widthSize);
	$heightSize		= preg_replace("/\D/","",$heightSize);
	$limitStart		= preg_replace("/\D/","",$limitStart);
	$cutSize		= preg_replace("/\D/","",$cutSize);
	$extract_type = preg_replace('/\n/', '', $extract_type); //모바일


	$limitStart		= ( $limitStart == "" )?0:$limitStart;
	$cutSize		= ( $cutSize == "" )?500:$cutSize;
	$error			= "";

	if ( $widthSize == "" )
	{
		$error	.= "프로필리스트 태그의 첫번째인자(가로출력개수)가 빠졌거나 잘못되었습니다.\n";
	}
	if ( $heightSize == "" )
	{
		$error	.= "프로필리스트 태그의 두번째인자(세로출력개수)가 빠졌거나 잘못되었습니다.\n";
	}
	if ( $option1 == "" )
	{
		$error	.= "프로필리스트 태그의 세번째인자(옵션1)가 빠졌거나 잘못되었습니다.\n";
	}
	if ( $option2 == "" )
	{
		$error	.= "프로필리스트 태그의 네번째인자(옵션2)가 빠졌거나 잘못되었습니다.\n";
	}
	if ( $orderBy == "" )
	{
		$error	.= "프로필리스트 태그의 다섯번째인자(정렬순서)가 빠졌거나 잘못되었습니다.\n";
	}
	if ( $cutSize == "" )
	{
		$error	.= "프로필리스트 태그의 여섯번째인자(글자짜를수)가 빠졌거나 잘못되었습니다.\n";
	}
	if ( $limitStart == "" )
	{
		$limitStart	= 0;
	}
	if ( $template1 == "" )
	{
		$error	.= "프로필리스트 태그의 여덟번째인자(알맹이템플릿파일명)가 빠졌거나 잘못되었습니다.\n";
	}
	if ( $template1 == "" )
	{
		$error	.= "프로필리스트 태그의 아홉번째인자(껍데기템플릿파일명)가 빠졌거나 잘못되었습니다.\n";
	}


	if ( $extract_type == "모바일스크롤" )
	{
		if ( $pagingCheck == "사용안함" )
		{
			$error	.= "모바일 스크롤로 추출을 할때는 페이징을 사용하셔야 합니다.\n";
		}
	}

	if ( $error != "" )
	{
		return print "<font color='red'>$error</font>";
	}


	//로그인한회원
	$userid = happy_member_login_check();
	$user_id	= $userid;

	$offset		= $widthSize * $heightSize;
	$tdWidth	= 100 / $widthSize ;

	$WHERE	= "";

	$option1_chk	= ( preg_match("(검색안함)",$option1) )?"no":"ok";
	$option2_chk	= ( preg_match("(검색안함)",$option2) )?"no":"ok";
	$option3_chk	= ( preg_match("(검색안함)",$option3) )?"no":"ok";
	$option4_chk	= ( preg_match("(검색안함)",$option4) )?"no":"ok";

	$option1		= str_replace("(검색안함)","",$option1);
	$option2		= str_replace("(검색안함)","",$option2);
	$option3		= str_replace("(검색안함)","",$option3);
	$option4		= str_replace("(검색안함)","",$option4);


	#----------------------------------------------------------------- 검색에의한 조건문 만들기

	$guzic_money	= addslashes($_GET["guzic_money"]);
	$guzic_school	= addslashes($_GET["guzic_school"]);
	$guzic_level	= addslashes($_GET["guzic_level"]);
	$guzic_keyword	= addslashes($_GET["guzic_keyword"]);
	$guzic_si		= addslashes($_GET["guzic_si"]);
	$guzic_gu		= addslashes($_GET["guzic_gu"]);
	$guzic_si2		= addslashes($_GET["guzic_si2"]);
	$guzic_gu2		= addslashes($_GET["guzic_gu2"]);
	$guzic_si3		= addslashes($_GET["guzic_si3"]);
	$guzic_gu3		= addslashes($_GET["guzic_gu3"]);
	$guzic_jobtype1	= addslashes($_GET["guzic_jobtype21"]);
	$guzic_jobtype2	= addslashes($_GET["guzic_jobtype22"]);
	$guzic_jobtype3	= addslashes($_GET["guzic_jobtype23"]);
	$guzic_type		= addslashes($_GET["guzic_jobtype1"]);
	$guzic_type_sub	= addslashes($_GET["guzic_jobtype2"]);
	$guzic_word		= addslashes($_GET["guzic_word"]);
	$guzic_ppt		= addslashes($_GET["guzic_ppt"]);
	$guzic_excel	= addslashes($_GET["guzic_excel"]);
	$guzic_internet	= addslashes($_GET["guzic_internet"]);
	$guzic_prefix	= addslashes($_GET["guzic_prefix"]);
	#$guzic_prefix	= ( $_GET["career_read"] != "" )?addslashes($_GET["career_read"]):$guzic_prefix;
	$career_read	= addslashes($_GET["career_read"]);
	$job_type_read	= addslashes($_GET["job_type_read"]);
	$guzic_keyword	= addslashes($_GET["guzic_keyword"]);
	$guzic_age		= addslashes($_GET["guzic_age"]);
	$guzic_age_start	= addslashes($_GET["guzic_age_start"]);
	$guzic_age_end		= addslashes($_GET["guzic_age_end"]);
	$career_read_start	= addslashes($_GET["career_read_start"]);
	$career_read_end	= addslashes($_GET["career_read_end"]);

	#guziceducation
	$guziceducation = addslashes($_GET["guziceducation"]);
	$grade_money_type = addslashes($_GET['grade_money_type']);
	$guzicnational = addslashes($_GET['guzicnational']);
	$diff_regday = addslashes($_GET['diff_regday']);

	//추가된 검색 2010-11-26 kad
	$grade_schoolName = addslashes($_GET['grade_schoolName']);
	$grade_schoolType = addslashes($_GET['grade_schoolType']);
	$HopeSize = addslashes($_GET['HopeSize']);

	$job_type_read	= ( is_Array($_GET["job_type_read"]) )?@implode("___",$_GET["job_type_read"]):$_GET["job_type_read"];
	$guzic_school	= ( is_Array($_GET["guzic_school"]) )?@implode("___",$_GET["guzic_school"]):$_GET["guzic_school"];

	$job_type_read	= explode("___",$job_type_read);
	$guzic_school	= explode("___",$guzic_school);

	$all_si			= $siNumber["전국"];

	$option_all_chk	= "ok";
	$search_si_chk	= "";
	if ( $option1_chk == "ok" )	#지역선택관련
	{
		if ( $guzic_si != "" || $guzic_si2 != "" || $guzic_si3 != "")
		{
			$WHERE_T	= "";

			if ( $guzic_si != "" && $guzic_si != "0" && $guzic_si != $SI_NUMBER['전국'] )
			{
				$WHERE_T	.= "
							job_where1_0 = '$guzic_si'
							OR
							job_where2_0 = '$guzic_si'
							OR
							job_where3_0 = '$guzic_si'
				";
				$search_si_chk	= "ok";
			}
			if ( $guzic_si2 != "" && $guzic_si2 != "0" && $guzic_si2 != $SI_NUMBER['전국'] )
			{
				$WHERE_T	.= ( $WHERE_T == "" )?"":" OR ";
				$WHERE_T	.= "
							job_where1_0 = '$guzic_si2'
							OR
							job_where2_0 = '$guzic_si2'
							OR
							job_where3_0 = '$guzic_si2'
				";
				$search_si_chk	= "ok";
			}
			if ( $guzic_si3 != "" && $guzic_si3 != "0" && $guzic_si3 != $SI_NUMBER['전국'] )
			{
				$WHERE_T	.= ( $WHERE_T == "" )?"":" OR ";
				$WHERE_T	.= "
							job_where1_0 = '$guzic_si3'
							OR
							job_where2_0 = '$guzic_si3'
							OR
							job_where3_0 = '$guzic_si3'
				";
				$search_si_chk	= "ok";
			}
			if ( $search_si_chk == "ok" && $all_si != "" )
			{
				$WHERE_T	.= "
							OR
							job_where1_0 = '$all_si'
							OR
							job_where2_0 = '$all_si'
							OR
							job_where3_0 = '$all_si'
				";
			}

			if ( $WHERE_T != "" )
			{
				$WHERE	.= " AND ( $WHERE_T ) ";
			}

			$WHERE_T	= str_replace("job_where","A.job_where",$WHERE_T);


			if ( $WHERE_T != "" )
			{
				$WHERE2	.= " AND ( $WHERE_T ) ";
			}
		}

		$WHERE_T		= "";

		if ( $guzic_gu != "" || $guzic_gu2 != "" || $guzic_gu3 != "" )
		{
			$search_si_chk	= "";
			$Count			= 0;
			if ( $guzic_gu != "" && $guzic_gu != "0" )
			{
				$WHERE_T	.= "
							job_where1_1 = '$guzic_gu'
							OR
							job_where2_1 = '$guzic_gu'
							OR
							job_where3_1 = '$guzic_gu'
				";
				$Count++;
				$search_si_chk	= "ok";
			}
			if ( $guzic_gu2 != "" && $guzic_gu2 != "0" )
			{
				$WHERE_T	.= ( $WHERE_T == "" )?"":" OR ";
				$WHERE_T	.= "
							job_where1_1 = '$guzic_gu2'
							OR
							job_where2_1 = '$guzic_gu2'
							OR
							job_where3_1 = '$guzic_gu2'
				";
				$Count++;
				$search_si_chk	= "ok";
			}
			if ( $guzic_gu3 != "" && $guzic_gu3 != "0" )
			{
				$WHERE_T	.= ( $WHERE_T == "" )?"":" OR ";
				$WHERE_T	.= "
							job_where1_1 = '$guzic_gu3'
							OR
							job_where2_1 = '$guzic_gu3'
							OR
							job_where3_1 = '$guzic_gu3'
				";
				$Count++;
				$search_si_chk	= "ok";
			}
			if ( $search_si_chk == "ok" && $all_si != "" )
			{
				$WHERE_T	.= "
							OR
							job_where1_0 = '$all_si'
							OR
							job_where2_0 = '$all_si'
							OR
							job_where3_0 = '$all_si'
				";
			}

			if ( $WHERE_T != "" )
			{
				$WHERE	.= " AND ( $WHERE_T ) ";
			}

			$WHERE_T	= str_replace("job_where","A.job_where",$WHERE_T);

			if ( $WHERE_T != "" )
			{
				$WHERE2	.= " AND ( $WHERE_T ) ";
			}

		}
	}
	else
	{
		$option_all_chk	= "no";
	}

	if ( $option2_chk == "ok" )
	{
		#직종선택관련
		$WHERE_T	= "";
		if ( $guzic_jobtype1 != "" || $guzic_jobtype2 != "" || $guzic_jobtype3 != "" )
		{
			#echo "$guzic_jobtype1 <br><br> ";
			$Count		= 0;
			if ( $guzic_jobtype1 != "" && $guzic_jobtype1 != "0" )
			{
				$Count++;
				$WHERE_T	.= ( $WHERE_T == "" )?"":" OR ";
				$WHERE_T	.= "
							job_type1 = '$guzic_jobtype1'
							OR
							job_type2 = '$guzic_jobtype1'
							OR
							job_type3 = '$guzic_jobtype1'
				";
			}
			if ( $guzic_jobtype2 != "" && $guzic_jobtype2 != "0" )
			{
				$Count++;
				$WHERE_T	.= ( $WHERE_T == "" )?"":" OR ";
				$WHERE_T	.= "
							job_type1 = '$guzic_jobtype2'
							OR
							job_type2 = '$guzic_jobtype2'
							OR
							job_type3 = '$guzic_jobtype2'
				";
			}
			if ( $guzic_jobtype3 != "" && $guzic_jobtype3 != "0" )
			{
				$Count++;
				$WHERE_T	.= ( $WHERE_T == "" )?"":" OR ";
				$WHERE_T	.= "
							job_type1 = '$guzic_jobtype3'
							OR
							job_type2 = '$guzic_jobtype3'
							OR
							job_type3 = '$guzic_jobtype3'
				";
			}
		}

		if ( $WHERE_T != "" )
		{
			$WHERE	.= " AND ( $WHERE_T )";
		}

		$WHERE_T	= str_replace("job_type","A.job_where",$WHERE_T);

		if ( $WHERE_T != "" )
		{
			$WHERE2	.= " AND ( $WHERE_T ) ";
		}

		$WHERE_T	= "";

		if ( $guzic_type != "" )
		{
			$WHERE_T	.= "
						(
							job_type1 = '$guzic_type'
							OR
							job_type2 = '$guzic_type'
							OR
							job_type3 = '$guzic_type'
						)
			";
		}

		if ( $guzic_type_sub != "" && $WHERE_T != "")
		{
			$WHERE_T	.= "
						AND
						(
							job_type_sub1 = '$guzic_type_sub'
							OR
							job_type_sub2 = '$guzic_type_sub'
							OR
							job_type_sub3 = '$guzic_type_sub'
						)
			";
		}

		if ( $WHERE_T != "" )
		{
			$WHERE	.= " AND ( $WHERE_T )";
		}

		$WHERE_T	= str_replace("job_type","A.job_where",$WHERE_T);

		if ( $WHERE_T != "" )
		{
			$WHERE2	.= " AND ( $WHERE_T ) ";
		}
		#echo $WHERE;
	}
	else
	{
		$option_all_chk	= "no";
	}

	if ( $option3_chk == "ok" )	#특별/신규/전체등등
	{
	}
	else
	{
		$option_all_chk	= "no";
	}

	if ( $option4_chk == "ok" )	#회원관련
	{
		if ( $guzic_prefix != "" && $guzic_prefix != "무관" )
		{
			$WHERE	.= " AND user_prefix = '$guzic_prefix' ";
			$WHERE2	.= " AND A.user_prefix = '$guzic_prefix' ";
		}

		if ( $guzic_age != "" )
		{
			$WHERE	.= " AND user_age = '$guzic_age' ";
			$WHERE2	.= " AND A.user_age = '$guzic_age' ";
		}

		if ( $guzic_age_start != "" )
		{
			$WHERE	.= " AND user_age >= '$guzic_age_start' ";
			$WHERE2	.= " AND A.user_age >= '$guzic_age_start' ";
		}

		if ( $guzic_age_end != "" )
		{
			$WHERE	.= " AND user_age <= '$guzic_age_end' ";
			$WHERE2	.= " AND A.user_age <= '$guzic_age_end' ";
		}

		#최종학력 이상/이하 선택시
		if ( $_GET['guzic_school_type'] != '' && $_GET["guzic_school"] != '' )
		{
			$guzic_school	= $guzic_school[0];
			$guzic_in		= '';

			if (  $_GET['guzic_school_type'] == '이상' )
			{
				for ( $guzic_key = array_search($guzic_school, $edu_arr) ; $guzic_key < sizeof($edu_arr) ; $guzic_key++ )
				{
					$guzic_in	.= ( $guzic_in == '' )? '' : ',' ;
					$guzic_in	.= "'". $edu_arr[$guzic_key] ."'";
				}
			}
			else if (  $_GET['guzic_school_type'] == '이하' )
			{
				for ( $guzic_key = array_search($guzic_school, $edu_arr) ; $guzic_key >= 0 ; $guzic_key-- )
				{
					$guzic_in	.= ( $guzic_in == '' )? '' : ',' ;
					$guzic_in	.= "'". $edu_arr[$guzic_key] ."'";
				}
			}

			if ( $guzic_in != '' )
			{
				$WHERE	= " AND grade_lastgrade in ( $guzic_in ) ";
				$WHERE2	= " AND A.grade_lastgrade in ( $guzic_in ) ";
			}
		}
		else if ( sizeof($guzic_school) > 0 )
		{
			$WHERE_T	= "";
			for ( $i=0, $j=0, $max=sizeof($guzic_school) ; $i<$max ; $i++ )
			{
				if ( str_replace(" ","",$guzic_school[$i]) != "" )
				{
					$WHERE_T	.= ( $j != 0 )?" OR ":"";
					$WHERE_T	.= " grade_lastgrade = '".$guzic_school[$i]."' ";
					$j++;
				}
			}
			#echo $WHERE_T;

			if ( $WHERE_T != "" )
			{
				$WHERE	.= " AND ( $WHERE_T ) ";
				$WHERE_T	= str_replace("grade_lastgrade","A.grade_lastgrade",$WHERE_T);
				$WHERE2	.= " AND ( $WHERE_T ) ";
			}
		}

		if ( $guzic_money != "" )
		{
			$WHERE	.= " AND grade_money = '$guzic_money' ";
			$WHERE2	.= " AND A.grade_money = '$guzic_money' ";
		}

		if ( $career_read == "경력" )
		{
			$WHERE	.= " AND ( work_year > 0 OR work_month > 0 ) ";
			$WHERE2	.= " AND ( A.work_year > 0 OR A.work_month > 0 ) ";
		}
		elseif ( $career_read == "신입" )
		{
			$WHERE	.= " AND ( work_year = 0 OR work_year = '' ) AND ( work_month = 0 OR work_month = '' ) ";
			$WHERE2	.= " AND ( A.work_year = 0 OR A.work_year = '' ) AND ( A.work_month = 0 OR A.work_month = '' ) ";
		}
		elseif ($career_read != "")
		{
			$career_read_arr	= explode("~",$career_read);
			if ( sizeof($career_read_arr) == 2 )
			{
				$career_read_arr	= preg_replace("/\D/","",$career_read_arr);
				$WHERE	.= " AND ( work_year >= $career_read_arr[0] AND ( work_year < $career_read_arr[1] OR ( work_year = $career_read_arr[1] AND work_month = 0 ) ) ) ";
				$WHERE2	.= " AND ( A.work_year >= $career_read_arr[0] AND ( A.work_year < $career_read_arr[1] OR ( A.work_year = $career_read_arr[1] AND A.work_month = 0 ) ) ) ";
			}
			else
			{
				$career_read	= preg_replace("/\D/","",$career_read);
				$WHERE	.= " AND ( work_year >= $career_read ) ";
				$WHERE2	.= " AND ( A.work_year >= $career_read ) ";
			}
		}

		if ( $career_read_start != '' && !preg_match('/신입/',$career_read_start) )
		{
			$career_read_start	= preg_replace("/\D/","",$career_read_start);

			if ( $career_read_start != '' )
			{
				$WHERE	.= " AND ( work_year >= $career_read_start )";
				$WHERE2	.= " AND ( A.work_year >= $career_read_start ) ";
			}
		}

		if ( preg_match('/신입/',$career_read_end) )
		{
			$WHERE	.= " AND ( work_year = 0 OR work_year = '' ) AND ( work_month = 0 OR work_month = '' ) ";
			$WHERE2	.= " AND ( A.work_year = 0 OR A.work_year = '' ) AND ( A.work_month = 0 OR A.work_month = '' ) ";
		}
		else if ( $career_read_end != '' )
		{
			$career_read_end	= preg_replace("/\D/","",$career_read_end);

			if ( $career_read_end != '' )
			{
				$WHERE	.= " AND ( work_year < $career_read_end OR ( work_year = $career_read_end AND work_month = 0 ) ) ";
				$WHERE2	.= " AND ( A.work_year < $career_read_end OR ( A.work_year = $career_read_end AND A.work_month = 0 ) ) ";
			}
		}

		if ( sizeof($guzic_school) > 0 )
		{
			$WHERE_T	= "";
			for ( $i=0, $j=0, $max=sizeof($job_type_read) ; $i<$max ; $i++ )
			{
				if ( str_replace(" ","",$job_type_read[$i]) != "" )
				{
					$WHERE_T	.= ( $j != 0 )?" OR ":"";
					$WHERE_T	.= " grade_gtype like '%".$job_type_read[$i]."%' ";
					$j++;
				}
			}
			#echo $WHERE_T;

			if ( $WHERE_T != "" )
			{
				$WHERE	.= " AND ( $WHERE_T ) ";
				$WHERE_T	= str_replace("grade_gtype","A.grade_gtype",$WHERE_T);
				$WHERE2	.= " AND ( $WHERE_T ) ";
			}
		}



		//대학명 추가 검색 2010-11-26 kad
		if ( $_GET['grade_schoolName'] != "" )
		{
			$WHERE	.= " AND ( grade2_schoolName like '".$_GET['grade_schoolName']."%'
								OR grade3_schoolName like '".$_GET['grade_schoolName']."%'
								OR grade4_schoolName like '".$_GET['grade_schoolName']."%' ) ";
			$WHERE2	.= " AND ( A.grade2_schoolName like '".$_GET['grade_schoolName']."%'
								OR A.grade3_schoolName like '".$_GET['grade_schoolName']."%'
								OR A.grade4_schoolName like '".$_GET['grade_schoolName']."%' ) ";
		}

		//전공별 추가 검색 2010-11-26 kad
		if ( $_GET['grade_schoolType'] != "" )
		{
			$WHERE	.= " AND ( grade2_schoolType like '".$_GET['grade_schoolType']."%'
								OR grade3_schoolType like '".$_GET['grade_schoolType']."%'
								OR grade4_schoolType like '".$_GET['grade_schoolType']."%' ) ";
			$WHERE2	.= " AND ( A.grade2_schoolType like '".$_GET['grade_schoolType']."%'
								OR A.grade3_schoolType like '".$_GET['grade_schoolType']."%'
								OR A.grade4_schoolType like '".$_GET['grade_schoolType']."%' ) ";
		}

		if ( $_GET['HopeSize'] != "" )
		{
			$WHERE	.= " AND ( HopeSize = '".$_GET['HopeSize']."' ) ";
			$WHERE2	.= " AND ( A.HopeSize = '".$_GET['HopeSize']."' ) ";
		}



		if ( $guzic_keyword != "" )
		{
			#관리자모드에서 이력서를 검색할때는 이름으로도 검색이 되도록 수정
			#2009-04-07 kad
			if ( preg_match("/^\/admin/",dirname($_SERVER['PHP_SELF'])) )
			{
				$WHERE	.= " AND ( title like '%$guzic_keyword%' OR keyword like '%$guzic_keyword%' OR user_name like '%$guzic_keyword%' ) ";
				$WHERE2	.= " AND ( A.title like '%$guzic_keyword%' OR A.keyword like '%$guzic_keyword%' OR A.user_name like '%$guzic_keyword%' ) ";
			}
			else
			{
				$WHERE	.= " AND ( title like '%$guzic_keyword%'
									OR keyword like '%$guzic_keyword%'
									OR user_name like '%$guzic_keyword%'
									OR user_homepage like '%$guzic_keyword%'
									OR user_addr2 like '%$guzic_keyword%'
									OR user_addr1 like '%$guzic_keyword%' ) ";

				$WHERE2	.= " AND ( A.title like '%$guzic_keyword%'
									OR A.keyword like '%$guzic_keyword%'
									OR A.user_name like '%$guzic_keyword%'
									OR A.user_homepage like '%$guzic_keyword%'
									OR A.user_addr2 like '%$guzic_keyword%'
									OR A.user_addr1 like '%$guzic_keyword%'
									) ";
			}
		}

		#키워드 검색 기능 추가
		if ( $keyword_read != "" )
		{
			$WHERE	.= " AND keyword like '%$keyword_read%' ";
			$WHERE2	.= " AND A.keyword like '%$keyword_read%' ";
		}
		#키워드 검색 기능 추가

	}
	else
	{
		$option_all_chk	= "no";
	}

	if ( $option_all_chk == "ok" )//option_chk 가 모두 ok 라면
	{
		if ( $guzic_word != "" )
		{
			$WHERE	.= " AND skill_word = '$guzic_word' ";
		}
		if ( $guzic_ppt != "" )
		{
			$WHERE	.= " AND skill_ppt = '$guzic_ppt' ";
		}
		if ( $guzic_excel != "" )
		{
			$WHERE	.= " AND skill_excel = '$guzic_excel' ";
		}
		if ( $guzic_internet != "" )
		{
			$WHERE	.= " AND skill_search = '$guzic_internet' ";
		}

		#학력검색 추가됨
		if ( $guziceducation != '' )
		{
			//$WHERE.= " AND ( guziceducation = '$guziceducation' ) ";
			//$WHERE2.= " AND ( A.guziceducation = '$guziceducation' ) ";
			$WHERE.= " AND ( grade_lastgrade = '$guziceducation' ) ";
			$WHERE2.= " AND ( A.grade_lastgrade = '$guziceducation' ) ";
		}
		#학력검색 추가됨

		#급여방식
		if ( $grade_money_type != '' )
		{
			$WHERE.= " AND ( grade_money_type = '$grade_money_type' ) ";
			$WHERE2.= " AND ( A.grade_money_type = '$grade_money_type' ) ";
		}
		#급여방식

		#국적
		if ( $guzicnational != '' )
		{
			$WHERE.= " AND ( guzicnational = '$guzicnational' ) ";
			$WHERE2 .= " AND ( A.guzicnational = '$guzicnational' ) ";
		}
		#국적
	}

	//echo $ex_career_read.'///';
	if ( $ex_career_read != '' && $career_read == '' )//추출태그(14)의 경력으로 인식, jobwork
	{
		if ( $ex_career_read == "경력" )
		{
			$WHERE	.= " AND ( work_year > 0 OR work_month > 0 ) ";
			$WHERE2	.= " AND ( A.work_year > 0 OR A.work_month > 0 ) ";
		}
		elseif ( $ex_career_read == "신입" )
		{
			$WHERE	.= " AND ( work_year = 0 OR work_year = '' ) AND ( work_month = 0 OR work_month = '' ) ";
			$WHERE2	.= " AND ( A.work_year = 0 OR A.work_year = '' ) AND ( A.work_month = 0 OR A.work_month = '' ) ";
		}
	}

	#----------------------------------------------------------------- 조건문 만들기

	if ( $option4 == "내가등록한이력서" )
	{
		$WHERE		.= " AND user_id='$user_id' ";
	}
	else if ( $option4 == "내가등록한공개중인이력서" )
	{
		$WHERE		.= " AND user_id='$user_id' AND display = 'Y' ";
	}
	else if ( $option4 == "내가등록한비공개중인이력서" )
	{
		$WHERE		.= " AND user_id='$user_id' AND display = 'N' ";
	}
	else if ( eregi("(아이디)",$option4) )
	{
		$option4	= str_replace("(아이디)","",$option4);
		$WHERE		.= " AND user_id='$user_id' ";
	}
	else if ( $option4 == "오늘본구직정보" )
	{
		$arr		= explode(",",$_COOKIE["HappyTodayGuzic"]);
		$todayOrder	= "";
		//for ( $i=sizeof($arr)-1, $Count=0 ; $i>=0 && $Count<$offset ; $i-- )
		for ( $i=sizeof($arr)-1, $Count=0 ; $i>=0 ; $i-- )
		{
			$tmp	= explode("_",$arr[$i]);
			$cookieVal	.= ( $Count == 0 )?"":",";
			$cookieVal	.= $tmp[0];
			$ttt		= ( $Count == 0 )?" number = $tmp[0]":" number = $tmp[0],";
			$todayOrder	= $ttt . $todayOrder;
			$Count++;
		}

		if ( $cookieVal != "" )
		{
			$WHERE	.= " AND number in ($cookieVal) ";
		}
		else
		{
			$WHERE	.= " AND number = '0' ";
			$todayOrder	= " number ";
		}
		$check_ex		= '1';
	}
	else
	{
		if ( $option3 != "관리자모드" )
		{
			$WHERE	.= " AND display = 'Y' ";
		}
	}

	$option1	= $siNumber[$option1];
	if ( $option1 != "" )
	{
		$WHERE		.= "
				AND
				(
						job_where1_0 = '$option1'
						OR
						job_where2_0 = '$option1'
						OR
						job_where3_0 = '$option1'
				)
		";
	}

	if ( $option2 != "" && $option2 != "전체" && $option2 != "옵션2" )
	{
		$option2	= $TYPE_NUMBER[$option2];

		if ( $option2 != "" )
		{
			$WHERE		.= "
					AND
					(
							job_type1	= '$option2'
							OR
							job_type2	= '$option2'
							OR
							job_type3	= '$option2'
					)
			";
		}
	}





	//총지원자 미열람 예비합격자 인재스크랩 상세보기이력서 는 기업회원 권한이었으나,
	//내가신청한구인은 일반회원의 권한 (입사지원)
	//회원통합으로 코드 변경됨
	//$option3 = "내가신청한구인";
	if ( $option3 == "총지원자" )
	{
		if ( !happy_member_secure($happy_member_secure_text[0].'보기') )
		{
			return print $happy_member_secure_text[0].'보기'." 권한이 없습니다.";
			exit;
		}

		//전체지원자, 예비합격, 불합격, 미열람 카운트 - ranksa
		$cgp_all_cnt	= 0;	//전체지원자
		$doc_ok_y_cnt	= 0;	//예비합격
		$doc_ok_n_cnt	= 0;	//불합격
		$read_ok_n_cnt	= 0;	//미열람
		$Sql			= "
							SELECT
								*
							FROM
								$per_document_tb AS A
							INNER JOIN
								$com_guin_per_tb AS B
							ON
								A.number = B.pNumber
							WHERE
								B.cNumber = '$_GET[number]'
							AND
								A.display = 'Y'
		";
		$Rec			= query($Sql);
		while($CGP_DATA	= happy_mysql_fetch_assoc($Rec))
		{
			$cgp_all_cnt++;
			if($CGP_DATA['doc_ok'] == "Y")
			{
				$doc_ok_y_cnt++;
			}
			if($CGP_DATA['doc_ok'] == "N")
			{
				$doc_ok_n_cnt++;
			}
			if($CGP_DATA['read_ok'] == "N")
			{
				$read_ok_n_cnt++;
			}
		}
	}
	else if ( $option3 == "미열람" )
	{
		if ( !happy_member_secure($happy_member_secure_text[0].'보기') )
		{
			return print $happy_member_secure_text[0].'보기'." 권한이 없습니다.";
			exit;
		}
	}
	else if ( $option3 == "예비합격자" )
	{
		if ( !happy_member_secure($happy_member_secure_text[0].'보기') )
		{
			return print $happy_member_secure_text[0].'보기'." 권한이 없습니다.";
			exit;
		}
	}
	else if ( $option3 == "인재스크랩" )
	{
		if ( !happy_member_secure($happy_member_secure_text[0].'스크랩') )
		{
			return print $happy_member_secure_text[0].'스크랩'." 권한이 없습니다.";
			exit;
		}
	}
	else if ( $option3 == "상세보기이력서" )
	{
		if ( !happy_member_secure($happy_member_secure_text[0].'보기') )
		{
			return print $happy_member_secure_text[0].'보기'." 권한이 없습니다.";
			exit;
		}
	}
	else if ( $option3 == "내가신청한구인" || $option3 == "내가신청한구인(온라인)" || $option3 == "내가신청한구인(이메일)" )
	{
		if ( !happy_member_secure($happy_member_secure_text[4]) )
		{
			return print $happy_member_secure_text[4]." 권한이 없습니다.";
			exit;
		}
	}

	#$option3 = "1번구직옵션";

	switch ( $option3 )
	{
		case "특별":			$WHERE .= " AND specialDate >= curdate() ";break;
		case "스페셜":			$WHERE .= " AND specialDate >= curdate() ";break;
		case "포커스":			$WHERE .= " AND focusDate >= curdate() ";break;
		case "파워링크":		$WHERE .= " AND powerlinkDate >= curdate() ";break;
		case "이력서스킨":		$WHERE .= " AND docskinDate >= curdate() ";break;
		case "아이콘":			$WHERE .= " AND iconDate >= curdate() ";break;
		case "볼드":			$WHERE .= " AND bolderDate >= curdate() ";break;
		case "컬러":			$WHERE .= " AND colorDate >= curdate() ";break;
		case "자유아이콘":		$WHERE .= " AND freeiconDate >= curdate() AND freeicon != '' ";break;
		case "총지원자":		$WHERE2 .= " ";break;
		case "미열람":			$WHERE2 .= " AND B.read_ok = 'N' ";break;
		case "예비합격자":		$WHERE2 .= " AND B.doc_ok = 'Y' ";break;
		case "인재스크랩":		$WHERE2 .= " AND B.userid='$userid' ";break;
		case "상세보기이력서":	$WHERE2 .= " AND B.com_id='$userid' ";break;
		case "내가신청한구인":	$WHERE2	.= " AND B.per_id='$userid' ";
								if ( $_POST['print_activities_ch'] == "ok" )
								{
									if ( sizeof($_POST['print_ch']) > 0 )
									{
										$print_ch	= implode(',', (array)  $_POST['print_ch']);
										$WHERE2	.= " AND B.number IN ( $print_ch ) ";
									}
									else
									{
										$WHERE2	.= " AND B.number IN ( 0 ) ";
									}
								}
								break;
		case "내가신청한구인(온라인)":	$WHERE2	.= " AND B.per_id='$userid' AND B.online_stats = 1 ";break;
		case "내가신청한구인(이메일)":	$WHERE2	.= " AND B.per_id='$userid' AND B.email_stats = 1 ";break;
		case "배경색":			$WHERE .= " AND bgcolorDate >= curdate() ";break;
		#추가옵션 5개
		#무료일때는 쿼리 안만들도록 됨
		case $PER_ARRAY_NAME[9]:
			if ( $CONF['GuzicUryoDate1'] != '' )
			{
				$WHERE .= " AND GuzicUryoDate1 >= curdate() ";
			}
			break;
		case $PER_ARRAY_NAME[10]:
			if ( $CONF['GuzicUryoDate2'] != '' )
			{
				$WHERE .= " AND GuzicUryoDate2 >= curdate() ";
			}
			break;
		case $PER_ARRAY_NAME[11]:
			if ( $CONF['GuzicUryoDate3'] != '' )
			{
				$WHERE .= " AND GuzicUryoDate3 >= curdate() ";
			}
			break;
		case $PER_ARRAY_NAME[12]:
			if ( $CONF['GuzicUryoDate4'] != '' )
			{
				$WHERE .= " AND GuzicUryoDate4 >= curdate() ";
			}
			break;
		case $PER_ARRAY_NAME[13]:
			if ( $CONF['GuzicUryoDate5'] != '' )
			{
				$WHERE .= " AND GuzicUryoDate5 >= curdate() ";
			}
			break;
	}

	#필수결제항목은 추출시 검사하자.
	if ( !( $option3 == "관리자모드" || $option4 == '내가등록한이력서' || $option4 == '내가등록한공개중인이력서' || $option4 == '내가등록한비공개중인이력서' ) )			//관리자 모드에서 보는 경우와 내가등록한 이력서를 보는 경우는 필수결제 체크를 안한다.
	{
		if ( is_array($PER_ARRAY_DB) && $CONF['paid_conf'] == 1 )
		{
			foreach($PER_ARRAY_DB as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					$wait_query2 = " AND ".$PER_ARRAY[$k]." >= curdate() ";
					$WHERE .= $wait_query2;
				}
			}
		}
	}
	#필수결제항목은 추출시 검사하자.
	#echo $WHERE."<br>";



	//온라인지원, 지원자관리 검색조건값 - ranksa
	if($_GET['guin_per_action'] == 'search')
	{
		if($_GET['guin_per_start_date'] != "" && $_GET['guin_per_end_date'] != "")
		{
			$WHERE2	.= " AND B.regdate >= '$_GET[guin_per_start_date]' AND B.regdate <= '$_GET[guin_per_end_date]' ";
		}
		else if($_GET['guin_per_start_date'] != "")
		{
			$WHERE2	.= " AND B.regdate >= '$_GET[guin_per_start_date]' ";
		}
		else if($_GET['guin_per_end_date'] != "")
		{
			$WHERE2	.= " AND B.regdate <= '$_GET[guin_per_end_date]' ";
		}

		if($_GET['search_word'] != "")
		{
			$WHERE2	.= " AND (A.title like '%{$_GET[search_word]}%' OR B.com_name like '%{$_GET[search_word]}%') ";
		}
	}


	if($_GET['doc_ok'] != "")
	{
		$WHERE2			.= " AND B.doc_ok = '$_GET[doc_ok]' ";
	}

	if($_GET['read_ok'] != "")
	{
		$WHERE2			.= " AND B.read_ok = '$_GET[read_ok]' ";
	}


	#----------------------------------------------------------------- 조건문 만들기 끝ㅌㅌㅌㅌㅌㅌ

	#----------------------------------------------------------------- 정렬순서 만들기
	//document_extraction_list , 이력서리스트
	//echo $_GET['sort_order'];
	$orderBy = $_GET['sort_order'] == '' ? $orderBy : $_GET['sort_order'];
	switch ( $orderBy )
	{
		case "최근등록일순":	$orderby = "regdate desc";break;
		case "등록일순":		$orderby = "regdate asc";break;
		case "오래된순":		$orderby = "regdate asc";break;
		case "랜덤추출":		$orderby = "rand()";break;
		case "최근수정순":		$orderby = "modifydate desc";break;
		case "수정순":			$orderby = "modifydate asc";break;
		case "최근등록순":		$orderby = "number desc";break;
		case "등록순":			$orderby = "number asc";break;
		case "아이디순":		$orderby = "user_id asc";break;
		case "아이디역순":		$orderby = "user_id desc";break;
		case "경력많은순":		$orderby = "work_year desc, work_month desc";break;
		case "경력작은순":		$orderby = "work_year asc, work_month asc";break;
		default:				$orderby = "number desc";break;
	}

	//orderby2 재생산 ralear 2013-12-19
	//echo $orderby;
	if ( $orderby != '' )
	{
		$orderby2		= Array();
		$orderBy_Ex		= explode(',', $orderby);
		foreach ( $orderBy_Ex as $orderTmp )
		{
			$orderTmp		= trim($orderTmp);
			array_push($orderby2, "A.".$orderTmp);
		}

		$orderby2		= implode(",", (array)  $orderby2);
		//echo $orderby2;
	}

	if( $option3 == "내가신청한구인" || $option3 == "내가신청한구인(온라인)" || $option3 == "내가신청한구인(이메일)" )
	{
		switch ( $orderBy )
		{
			case "최근등록일순":	$orderby2 = "C.guin_date desc";break;
			case "최근등록일역순":	$orderby2 = "C.guin_date asc";break;
			case "채용마감일":		$orderby2 = "C.guin_end_date desc";break;
			case "채용마감일역순":	$orderby2 = "C.guin_end_date asc";break;
			case "최근수정일순":	$orderby2 = "C.guin_modify desc";break;
			case "제목순":			$orderby2 = "guin_title asc";break;
			case "제목역순":		$orderby2 = "guin_title desc";break;
			default:				$orderby2 = "guin_number desc";break;
		}
	}

	if ( $option4 == "오늘본구직정보" )
	{
		$orderby	= $todayOrder;
	}
	#----------------------------------------------------------------- 정렬순서 만들기 끝ㅌㅌㅌㅌㅌㅌㅌ

	#등록일
	if ( $diff_regday != '' )
	{
		$WHERE.= " AND ( regdate >= date_add(regdate,interval -$diff_regday day) ) ";
		$WHERE2 .= " AND ( A.regdate >= date_add(A.regdate,interval -$diff_regday day) ) ";
	}
	#등록일


	//인접순추출 or 회원인접업체 2010-10-12 kad
	$ext_query = array();
	$happy_map_latlng	= trim($_GET['happy_map_latlng']);
	if ( ( $ex_option == '인접순추출' || $ex_option == '회원인접업체' ) && $happy_map_latlng == '' )
	{
		$search_info	= "
			<img src='img/dot.gif' onLoad=\"try { happy_map_markRemoveAll(); } catch (e) { }\" style='display:none'>
			인접매물
		";
		$_GET['num']	= preg_replace('/\D/','',$_GET['number']);
		if ( $_GET['num'] == '' && $ex_option == '인접순추출' )
		{
			return print "<font color='red'>인접순추출 기능은 뷰페이지에서만 작동합니다.</font>";
		}

		if ( $ex_option == '인접순추출' )
		{
			$Sql	= "SELECT x_point2,y_point2 FROM $links WHERE number='$_GET[num]' ";
		}
		else if ( $ex_option == '회원인접업체' )
		{
			#global $member_near_xpoint, $member_near_ypoint;
			if ( $mem_id == '' && $_GET['map_point'] == '' )
			{
				$naver_find_addr_id	= $naver_no_member_call_id;
			}
			else if ( $mem_id != '' )
			{
				$naver_find_addr_id	= $mem_id;
			}
			$Sql	= "SELECT x_point2,y_point2 FROM $happy_member WHERE user_id='$naver_find_addr_id' ";
			//echo $Sql;

		}

		if ( $_GET['map_point'] == '' )
		{
			list($x_point2, $y_point2 )	= happy_mysql_fetch_array(query($Sql));
		}
		else
		{
			#echo $_GET['map_point'];
			list($x_point2, $y_point2 )	= explode(',', $_GET['map_point'] );

			$x_point				= str_replace(' ','',$x_point2);
			$y_point				= str_replace(' ','',$y_point2);

			list($x_do, $x_min)		= explode('.',$x_point);

			$x_min					= $x_point - $x_do;
			$x_min					= $x_min * 60;
			$x_min_check			= $x_min;
			list($x_min, $x_sec)	= explode('.',$x_min);

			$x_sec					= $x_min_check - $x_min;
			$x_sec					= $x_sec * 60;


			#echo "<hr>$x_do , $x_min , $x_sec";



			list($y_do, $y_min)		= explode('.',$y_point);

			$y_min					= $y_point - $y_do;
			$y_min					= $y_min * 60;
			$y_min_check			= $y_min;
			list($y_min, $y_sec)	= explode('.',$y_min);

			$y_sec					= $y_min_check - $y_min;
			$y_sec					= $y_sec * 60;


			#echo "<hr>$y_do , $y_min , $y_sec";


			$x_point2	= $x_do * 3600 + $x_min * 60 + $x_sec;
			$y_point2	= $y_do * 3600 + $y_min * 60 + $y_sec;

			$x_point2	= round($x_point2);
			$y_point2	= round($y_point2);
			#echo "$x_point2,$y_point2";

		}

		$order_by = ' metor asc';

		$map_size		= preg_replace("/\D/", "", $_GET['map_size']);
		$map_small_size	= preg_replace("/\D/", "", $_GET['map_small_size']);

		if($map_small_size =='')
		{
			//$map_small_size = 700;
		}

		$find_metor		= $boodong_metor;

		if ( $search_metor != '' )
			$find_metor	= $search_metor;

		if ( $map_size != '' )
		{
			$find_metor	= 25;
			for ( $z=0 ; $z<$map_size ; $z++ )
			{
				$find_metor	*= 2;
			}
			#$find_metor	= $find_metor - ( $find_metor * 0.2 );
			$find_metor	= round($find_metor);

			$find_metor	= $find_metor * ( ceil($map_small_size / 100)  );

			#$order_by = ' order by rand() ';
		}

		#반경검색

		$wgs_point	= wgs_point_get($xpoint);

		array_push($ext_query, " x_point2 > 1 AND y_point2 > 1 AND number != '$_GET[num]' AND ( sqrt( pow( ( greatest( x_point2, $x_point2 ) - least( x_point2, $x_point2 ) ) * $wgs_point[xpoint] , 2 ) + pow( ( greatest( y_point2, $y_point2 ) - least( y_point2, $y_point2 ) ) * $wgs_point[ypoint] , 2 ) ) ) < $find_metor ");


		$add_field	= " , ( sqrt( pow( ( greatest( x_point2, $x_point2 ) - least( x_point2, $x_point2 ) ) * $wgs_point[xpoint] , 2 ) + pow( ( greatest( y_point2, $y_point2 ) - least( y_point2, $y_point2 ) ) * $wgs_point[ypoint] , 2 ) ) ) AS metor ";


		switch ( $ex_option )
		{
			case "인접순추출":
				$WHERE .= " AND ".$ext_query[0];
				$order = $order_by;
				break;
			case "회원인접업체":
				$WHERE .= " AND ".$ext_query[0];
				$order = $order_by;
				break;
			default:
				break;
		}

	}
	//인접순추출 or 회원인접업체 2010-10-12 kad
	else if ( $ex_option == '회원인접업체' && $happy_map_latlng != '' )
	{
		#echo $happy_map_latlng;
		$happy_map_latlngs	= str_replace(' ', '', $happy_map_latlng);
		$happy_map_latlngs	= explode(',', $happy_map_latlngs);

		$happy_map_latlng_x	= Array( $happy_map_latlngs[0], $happy_map_latlngs[2] );
		$happy_map_latlng_y	= Array( $happy_map_latlngs[1], $happy_map_latlngs[3] );

		$now_map_search		= $_GET['now_map_search'];

		sort($happy_map_latlng_x);
		sort($happy_map_latlng_y);

		#echo '<hr>'.$_GET['happy_map_category'].'<hr>';


		/*
		$WHERE		.= "
							AND
							x_point	> 0
							AND
							y_point	> 0
		";
		*/

		if ( $now_map_search == 'true' )
		{
			$WHERE		.= "
							AND
							(
								x_point >= '$happy_map_latlng_x[0]'
								AND
								x_point <= '$happy_map_latlng_x[1]'
								AND
								y_point >= '$happy_map_latlng_y[0]'
								AND
								y_point <= '$happy_map_latlng_y[1]'
							)
			";
			if ( $HAPPY_CONFIG['happy_map_now_sorting'] == '1' )
			{
				$order = ' metor asc';
			}
		}
		else
		{
			if ( $HAPPY_CONFIG['happy_map_sorting'] == '1' )
			{
				$order = ' metor asc';
			}
		}


			#echo '<hr>now_map_search : '.$_GET['now_map_search'].'<hr>';
			list($x_point2, $y_point2 )	= explode(',', $_GET['map_point'] );

			$x_point				= str_replace(' ','',$x_point2);
			$y_point				= str_replace(' ','',$y_point2);

			list($x_do, $x_min)		= explode('.',$x_point);

			$x_min					= $x_point - $x_do;
			$x_min					= $x_min * 60;
			$x_min_check			= $x_min;
			list($x_min, $x_sec)	= explode('.',$x_min);

			$x_sec					= $x_min_check - $x_min;
			$x_sec					= $x_sec * 60;


			#echo "<hr>$x_do , $x_min , $x_sec";



			list($y_do, $y_min)		= explode('.',$y_point);

			$y_min					= $y_point - $y_do;
			$y_min					= $y_min * 60;
			$y_min_check			= $y_min;
			list($y_min, $y_sec)	= explode('.',$y_min);

			$y_sec					= $y_min_check - $y_min;
			$y_sec					= $y_sec * 60;


			#echo "<hr>$y_do , $y_min , $y_sec";


			$x_point2	= $x_do * 3600 + $x_min * 60 + $x_sec;
			$y_point2	= $y_do * 3600 + $y_min * 60 + $y_sec;

			$x_point2	= round($x_point2);
			$y_point2	= round($y_point2);

			$add_field	= " , ( sqrt( pow( ( greatest( x_point2, $x_point2 ) - least( x_point2, $x_point2 ) ) * 30.828 , 2 ) + pow( ( greatest( y_point2, $y_point2 ) - least( y_point2, $y_point2 ) ) * 24.697 , 2 ) ) ) AS metor ";

			#$order = ' metor asc';

			$ext_query[0] = $WHERE;

	}

	if ( $ex_option == '인접순추출' || $ex_option == '회원인접업체' )
	{
		$happy_map_search	= trim($_GET['happy_map_search']);
		if ( $happy_map_search != '' )
		{
			$WHERE		.= " AND title like '%$happy_map_search%' ";
		}
	}
	//echo $WHERE;
	//print_r($ext_query);


	############ 페이징처리 ############
	$start			=  ( $pagingCheck == "페이징사용" )?$_GET["start"]+$limitStart:$limitStart;
	$scale			= $offset;

	if ( $option3 == "총지원자" || $option3 == "미열람" || $option3 == "예비합격자" )
	{
		$Sql	= "SELECT COUNT(A.number) FROM $per_document_tb AS A INNER JOIN $com_guin_per_tb AS B ON A.number = B.pNumber WHERE B.cNumber = '$_GET[number]' $WHERE2 ";
	}
	else if ( $option3 == '헤드헌팅' && $happy_member_login_value != '' && $hunting_use == true ) //헤드헌팅
	{
		if ( $_GET['company_document'] != '' )
		{
			$WHERE2		.= "
							AND
							B.company_number	= '$_GET[company_document]'
			";
		}
		else
		{
			$WHERE2		.= "
							AND
							B.com_id			= '$happy_member_login_value'
							AND
							B.company_number	!= '0'
			";
		}

		$Sql		= "
						SELECT
								COUNT(A.number)
						FROM
								$per_document_tb AS A
						INNER JOIN
								$com_guin_per_tb AS B
						ON
								A.number			= B.pNumber
						WHERE
								1=1
								$WHERE2
		";
	}
	else if ( $option3 == "인재스크랩" )
	{
		$Sql	= "SELECT COUNT(A.number) FROM $per_document_tb AS A INNER JOIN $scrap_tb AS B ON A.number = B.pNumber WHERE B.cNumber = '$_GET[number]' $WHERE2 ";
	}
	else if ( $option3 == "상세보기이력서" )
	{
		$Sql	= "SELECT COUNT(A.number) FROM $per_document_tb AS A INNER JOIN $job_com_doc_view_tb AS B ON A.number = B.doc_number WHERE A.display = 'Y' $WHERE2 ";
	}
	else if ( $option3 == "내가신청한구인" || $option3 == "내가신청한구인(온라인)" || $option3 == "내가신청한구인(이메일)" )
	{
		$Sql	= "
					SELECT
							COUNT(A.number)
					FROM
							$per_document_tb AS A
					INNER JOIN
							$com_guin_per_tb AS B
					ON
							A.number = B.pNumber
					INNER JOIN
							$guin_tb AS C
					ON
							B.cNumber = C.number
					WHERE
							A.display = 'Y'
							$WHERE2
		";
	}
	else if ( $option3 == "관리자모드" )
	{
		$Sql	= "select count(*) from $per_document_tb WHERE 1=1 $WHERE ";
	}
	else if ( $option3 == '맞춤구직정보' )
	{
		#print_r2($WantSearchDoc);
		#맞춤구직정보는 DB에서 쿼리 가져오도록
		if ( $WantSearchDoc['query_str'] != '' )
		{
			$WHERE3 = " AND display = 'Y' AND ".$WantSearchDoc['query_str'];
		}
		else
		{
			$WHERE3 = " AND 1=2 ";
		}
		#맞춤구직정보는 DB에서 쿼리 가져오도록

		$Sql	= "select count(*) from $per_document_tb WHERE 1=1 $WHERE3 ";
	}
	else
	{
		$Sql	= "select count(*) from $per_document_tb WHERE 1=1 $WHERE ";
	}
	#echo "이력서리스트쿼리=".$Sql."<br>";//이력서리스트쿼리

	$Temp	= happy_mysql_fetch_array(query($Sql));
	$Total	= $Count	= $Temp[0];
	$이력서수	= $Total;

	if( $start )
	{
		$listNo = $Total - $start;
	}
	else
	{
		$listNo = $Total; $start = 0;
	}
	$pageScale		= 6;


	if ( $_GET["sort"] == "" )
	{
		$order_query	= $order;
	}
	else
	{
		$order_query	= str_replace("_", " ", $_GET["sort"]);
	}


	//$searchMethod		.= ($_GET['start'])?"&start=$_GET[start]":"";
	$searchMethod		.= ($_GET['file'])?"&file=$_GET[file]":"";
	$searchMethod		.= ($_GET['file2'])?"&file2=$_GET[file2]":"";
	$searchMethod		.= ($_GET['number'])?"&number=$_GET[number]":"";
	$searchMethod		.= ($_GET['myroom'])?"&myroom=$_GET[myroom]":"";
	$searchMethod		.= ($_GET['doc_ok'])?"&doc_ok=$_GET[doc_ok]":"";
	$searchMethod		.= ($_GET['read_ok'])?"&read_ok=$_GET[read_ok]":"";
	$searchMethod		.= ($_GET['guin_per_action'])?"&guin_per_action=$_GET[guin_per_action]":"";
	$searchMethod		.= ($_GET['job_type_read'])?"&job_type_read=$_GET[job_type_read]":"";
	$searchMethod		.= ($_GET['guin_per_start_date'])?"&guin_per_start_date=$_GET[guin_per_start_date]":"";
	$searchMethod		.= ($_GET['guin_per_end_date'])?"&guin_per_end_date=$_GET[guin_per_end_date]":"";
	$searchMethod		.= ($_GET['search_word'])?"&search_word=$_GET[search_word]":"";

	if ( $ajax_paging == '1' )
	{
		$page_print = newPaging_ajax( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		//include ("ajax_section_page.php");
		#print "ddddddddddddddddd".$total_count_script;
	}
	else
	{
		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		$페이징	= $paging;
	}
	########### 페이징처리 끝 ############


	if ($extract_type == "모바일스크롤")
	{
		$scale = $이력서수;
		$paging_limit = $scale/($widthSize*$heightSize);

		if ( $paging_limit > 10 )
		{
			//이력서는 총개수가 없어서 모바일스크롤시 가로X세로X10개 로 출력
			$scale = ($widthSize*$heightSize)*10;
			$paging_limit = 10;
			$extract_type_cut = 1;
		}
	}


	//echo $option3;

	if ( $option3 == "관리자모드" )
	{
		$Sql	= "select * from $per_document_tb WHERE 1=1 $WHERE ORDER BY $orderby LIMIT $start, $scale";
	}
	else if ( $option3 == "총지원자" || $option3 == "미열람" || $option3 == "예비합격자" )
	{
		$Sql	= "
				SELECT
						A.number,
						A.grade_money,
						A.skin_html,
						A.skin_date,
						A.title,
						A.user_id,
						A.user_name,
						A.user_age,
						A.user_prefix,
						A.user_phone,
						A.user_hphone,
						A.user_email1,
						A.user_email2,
						A.user_homepage,
						A.user_image,
						A.job_where1_0,
						A.job_where1_1,
						A.job_where2_0,
						A.job_where2_1,
						A.job_where3_0,
						A.job_where3_1,
						A.job_type1,
						A.job_type2,
						A.job_type3,
						A.job_type_sub1,
						A.job_type_sub2,
						A.job_type_sub3,
						A.keyword,
						A.grade_gtype,
						A.grade_money,
						A.grade_money_type,
						A.grade_lastgrade,
						A.grade2_schoolType,
						A.grade3_schoolType,
						A.grade4_schoolType,
						A.grade5_schoolType,
						A.grade6_schoolType,
						A.work_year,
						A.work_month,
						A.work_otherCountry,
						A.filename1,
						A.filename2,
						A.filename3,
						A.filename4,
						A.filename5,
						A.skill_word,
						A.skill_ppt,
						A.skill_excel,
						A.skill_search,
						A.skill_list,
						A.skill_etc,
						A.viewListCount,
						A.regdate,
						A.modifydate,
						A.etc1,
						A.etc2,
						A.etc3,
						A.etc4,
						A.etc5,
						A.etc6,
						A.etc7,
						A.etc8,
						A.etc9,
						A.etc10,
						A.specialDate,
						A.focusDate,
						A.powerlinkDate,
						A.iconDate,
						A.bolderDate,
						A.colorDate,
						A.freeiconDate,
						A.freeicon,
						A.display,
						A.bgcolorDate,
						A.start_worktime,
						A.finish_worktime,
						A.guzicperson,
						A.guziceducation,
						A.guzicnational,
						A.guzicmarried,
						A.guzicchild,
						A.guziclicence,
						A.guziclicence_title,
						A.guzicsicompany,
						A.GuzicUryoDate1,
						A.GuzicUryoDate2,
						A.GuzicUryoDate3,
						A.GuzicUryoDate4,
						A.GuzicUryoDate5,
						A.use_adult,
						A.user_birth_year,
						A.user_birth_month,
						A.user_birth_day,
						B.number AS bNumber,
						B.pNumber,
						B.cNumber,
						B.com_id,
						B.per_id,
						B.com_name,
						B.per_name,
						B.interview,
						B.read_ok,
						B.doc_ok,
						B.regdate AS bregdate,
						B.secure,
						B.online_stats as online_stats,
						B.point as bPoint,
						B.memo as bMemo,
						B.app_im,
						A.bgcolorDate
				FROM
						$per_document_tb AS A
						INNER JOIN
						$com_guin_per_tb AS B
				ON
						A.number = B.pNumber
				WHERE
						B.cNumber = '$_GET[number]'
						AND
						A.display = 'Y'
						$WHERE2
				ORDER BY
						$orderby2
				LIMIT
						$start, $scale
		";
	}
	else if ( $option3 == '헤드헌팅' && $happy_member_login_value != '' && $hunting_use == true ) //헤드헌팅
	{
		$Sql	= "
				SELECT
						A.number,
						A.grade_money,
						A.skin_html,
						A.skin_date,
						A.title,
						A.user_id,
						A.user_name,
						A.user_age,
						A.user_prefix,
						A.user_phone,
						A.user_hphone,
						A.user_email1,
						A.user_email2,
						A.user_homepage,
						A.user_image,
						A.job_where1_0,
						A.job_where1_1,
						A.job_where2_0,
						A.job_where2_1,
						A.job_where3_0,
						A.job_where3_1,
						A.job_type1,
						A.job_type2,
						A.job_type3,
						A.job_type_sub1,
						A.job_type_sub2,
						A.job_type_sub3,
						A.keyword,
						A.grade_gtype,
						A.grade_money,
						A.grade_money_type,
						A.grade_lastgrade,
						A.grade2_schoolType,
						A.grade3_schoolType,
						A.grade4_schoolType,
						A.grade5_schoolType,
						A.grade6_schoolType,
						A.work_year,
						A.work_month,
						A.work_otherCountry,
						A.filename1,
						A.filename2,
						A.filename3,
						A.filename4,
						A.filename5,
						A.skill_word,
						A.skill_ppt,
						A.skill_excel,
						A.skill_search,
						A.skill_list,
						A.skill_etc,
						A.viewListCount,
						A.regdate,
						A.modifydate,
						A.etc1,
						A.etc2,
						A.etc3,
						A.etc4,
						A.etc5,
						A.etc6,
						A.etc7,
						A.etc8,
						A.etc9,
						A.etc10,
						A.specialDate,
						A.focusDate,
						A.powerlinkDate,
						A.iconDate,
						A.bolderDate,
						A.colorDate,
						A.freeiconDate,
						A.freeicon,
						A.display,
						A.bgcolorDate,
						A.start_worktime,
						A.finish_worktime,
						A.guzicperson,
						A.guziceducation,
						A.guzicnational,
						A.guzicmarried,
						A.guzicchild,
						A.guziclicence,
						A.guziclicence_title,
						A.guzicsicompany,
						A.GuzicUryoDate1,
						A.GuzicUryoDate2,
						A.GuzicUryoDate3,
						A.GuzicUryoDate4,
						A.GuzicUryoDate5,
						A.use_adult,
						A.user_birth_year,
						A.user_birth_month,
						A.user_birth_day,
						B.number AS bNumber,
						B.pNumber,
						B.cNumber,
						B.com_id,
						B.per_id,
						B.com_name,
						B.per_name,
						B.interview,
						B.read_ok,
						B.doc_ok,
						B.regdate AS bregdate,
						B.secure,
						B.online_stats as online_stats,
						B.point as bPoint,
						B.memo as bMemo,
						A.bgcolorDate
				FROM
						$per_document_tb AS A
						INNER JOIN
						$com_guin_per_tb AS B
				ON
						A.number = B.pNumber
				WHERE
						1=1
						$WHERE2
				ORDER BY
						$orderby2
				LIMIT
						$start, $scale
		";
		//echo $Sql;
	}
	else if ( $option3 == "인재스크랩" )
	{
		#채용정보없이 그냥 스크랩할 경우 0으로 고정
		if ( $_GET['number'] == '' )
		{
			$cNumber = '0';
		}
		else
		{
			$cNumber = $_GET['number'];
		}
		#채용정보없이 그냥 스크랩할 경우

		$Sql	= "
				SELECT
						A.number,
						A.grade_money,
						A.skin_html,
						A.skin_date,
						A.title,
						A.user_id,
						A.user_name,
						A.user_age,
						A.user_prefix,
						A.user_phone,
						A.user_hphone,
						A.user_email1,
						A.user_email2,
						A.user_homepage,
						A.user_image,
						A.job_where1_0,
						A.job_where1_1,
						A.job_where2_0,
						A.job_where2_1,
						A.job_where3_0,
						A.job_where3_1,
						A.job_type1,
						A.job_type2,
						A.job_type3,
						A.job_type_sub1,
						A.job_type_sub2,
						A.job_type_sub3,
						A.keyword,
						A.grade_gtype,
						A.grade_money,
						A.grade_money_type,
						A.grade_lastgrade,
						A.grade2_schoolType,
						A.grade3_schoolType,
						A.grade4_schoolType,
						A.grade5_schoolType,
						A.grade6_schoolType,
						A.work_year,
						A.work_month,
						A.work_otherCountry,
						A.filename1,
						A.filename2,
						A.filename3,
						A.filename4,
						A.filename5,
						A.skill_word,
						A.skill_ppt,
						A.skill_excel,
						A.skill_search,
						A.skill_list,
						A.skill_etc,
						A.viewListCount,
						A.regdate,
						A.modifydate,
						A.etc1,
						A.etc2,
						A.etc3,
						A.etc4,
						A.etc5,
						A.etc6,
						A.etc7,
						A.etc8,
						A.etc9,
						A.etc10,
						A.specialDate,
						A.focusDate,
						A.powerlinkDate,
						A.iconDate,
						A.bolderDate,
						A.colorDate,
						A.freeiconDate,
						A.freeicon,
						A.display,
						A.bgcolorDate,
						A.start_worktime,
						A.finish_worktime,
						A.guzicperson,
						A.guziceducation,
						A.guzicnational,
						A.guzicmarried,
						A.guzicchild,
						A.guziclicence,
						A.guziclicence_title,
						A.guzicsicompany,
						A.GuzicUryoDate1,
						A.GuzicUryoDate2,
						A.GuzicUryoDate3,
						A.GuzicUryoDate4,
						A.GuzicUryoDate5,
						A.use_adult,
						A.user_birth_year,
						A.user_birth_month,
						A.user_birth_day,
						B.number AS bNumber,
						B.pNumber,
						B.cNumber,
						B.userid AS bUserid,
						B.userType,
						B.scrapdate,
						B.point as bPoint,
						B.memo as bMemo,
						A.bgcolorDate
				FROM
						$per_document_tb AS A
						INNER JOIN
						$scrap_tb AS B
				ON
						A.number = B.pNumber
				WHERE
						B.cNumber = '$cNumber'
						AND
						A.display = 'Y'
						$WHERE2
				ORDER BY
						$orderby2
				LIMIT
						$start, $scale
		";
	}
	else if ( $option3 == "상세보기이력서" )
	{
		$Sql	= "
				SELECT
						A.*,
						B.com_id AS bUserid
				FROM
						$per_document_tb AS A
						INNER JOIN
						$job_com_doc_view_tb AS B
				ON
						A.number = B.doc_number
				WHERE
						A.display = 'Y'
						$WHERE2
				ORDER BY
						$orderby2
				LIMIT
						$start, $scale
		";
		//echo $Sql;
	}
	else if ( $option3 == "내가신청한구인" || $option3 == "내가신청한구인(온라인)" || $option3 == "내가신청한구인(이메일)" )
	{
		$Sql	= "
				SELECT
						A.number,
						A.grade_money,
						A.skin_html,
						A.skin_date,
						A.title,
						A.user_id,
						A.user_name,
						A.user_age,
						A.user_prefix,
						A.user_phone,
						A.user_hphone,
						A.user_email1,
						A.user_email2,
						A.user_homepage,
						A.user_image,
						A.job_where1_0,
						A.job_where1_1,
						A.job_where2_0,
						A.job_where2_1,
						A.job_where3_0,
						A.job_where3_1,
						A.job_type1,
						A.job_type2,
						A.job_type3,
						A.job_type_sub1,
						A.job_type_sub2,
						A.job_type_sub3,
						A.keyword,
						A.grade_gtype,
						A.grade_money,
						A.grade_money_type,
						A.grade_lastgrade,
						A.grade2_schoolType,
						A.grade3_schoolType,
						A.grade4_schoolType,
						A.grade5_schoolType,
						A.grade6_schoolType,
						A.work_year,
						A.work_month,
						A.work_otherCountry,
						A.filename1,
						A.filename2,
						A.filename3,
						A.filename4,
						A.filename5,
						A.skill_word,
						A.skill_ppt,
						A.skill_excel,
						A.skill_search,
						A.skill_list,
						A.skill_etc,
						A.viewListCount,
						A.regdate,
						A.modifydate,
						A.etc1,
						A.etc2,
						A.etc3,
						A.etc4,
						A.etc5,
						A.etc6,
						A.etc7,
						A.etc8,
						A.etc9,
						A.etc10,
						A.specialDate,
						A.focusDate,
						A.powerlinkDate,
						A.iconDate,
						A.bolderDate,
						A.colorDate,
						A.freeiconDate,
						A.freeicon,
						A.display,
						A.bgcolorDate,
						A.start_worktime,
						A.finish_worktime,
						A.guzicperson,
						A.guziceducation,
						A.guzicnational,
						A.guzicmarried,
						A.guzicchild,
						A.guziclicence,
						A.guziclicence_title,
						A.guzicsicompany,
						A.GuzicUryoDate1,
						A.GuzicUryoDate2,
						A.GuzicUryoDate3,
						A.GuzicUryoDate4,
						A.GuzicUryoDate5,
						A.use_adult,
						A.user_birth_year,
						A.user_birth_month,
						A.user_birth_day,
						B.number AS bNumber,
						B.pNumber,
						B.cNumber,
						B.com_id,
						B.per_id,
						B.com_name,
						B.per_name,
						B.interview,
						B.read_ok,
						B.doc_ok,
						B.secure,
						B.online_stats as online_stats,
						B.regdate as com_guin_regdate,
						A.bgcolorDate,
						C.number as guin_number,
						C.guin_title as guin_title,
						C.guin_type,
						C.underground1,
						C.underground2,
						C.subway_txt,
						C.si1,
						C.gu1,
						C.si2,
						C.gu2,
						C.si3,
						C.gu3,
						C.guin_choongwon,
						C.guin_date,
						C.guin_end_date,
						C.work_week,
						C.guin_phone,
						C.user_addr1 as addr1,
						C.user_addr2 as addr2
				FROM
						$per_document_tb AS A
						INNER JOIN
						$com_guin_per_tb AS B
				ON
						A.number = B.pNumber
				INNER JOIN
						$guin_tb AS C
				ON
						B.cNumber = C.number
				WHERE
						A.display = 'Y'
						$WHERE2
				ORDER BY
						$orderby2
				LIMIT
						$start, $scale
		";
		//echo print_r2($Sql);
	}
	else if ( $option3 == '맞춤구직정보' )
	{
		#맞춤구직정보는 DB에서 쿼리 가져오도록
		//print_r2($WantSearchDoc);
		if ( $WantSearchDoc['query_str'] != '' )
		{
			$WHERE3 = " AND ".$WantSearchDoc['query_str'];
		}
		else
		{
			$WHERE3 = " AND 1=2 ";
		}
		#맞춤구직정보는 DB에서 쿼리 가져오도록

		$Sql	= "
				SELECT
						number,
						grade_money,
						skin_html,
						skin_date,
						title,
						user_id,
						user_name,
						user_age,
						user_prefix,
						user_phone,
						user_hphone,
						user_email1,
						user_email2,
						user_homepage,
						user_image,
						job_where1_0,
						job_where1_1,
						job_where2_0,
						job_where2_1,
						job_where3_0,
						job_where3_1,
						job_type1,
						job_type2,
						job_type3,
						job_type_sub1,
						job_type_sub2,
						job_type_sub3,
						keyword,
						grade_gtype,
						grade_money,
						grade_money_type,
						grade_lastgrade,
						grade2_schoolType,
						grade3_schoolType,
						grade4_schoolType,
						grade5_schoolType,
						grade6_schoolType,
						work_year,
						work_month,
						work_otherCountry,
						filename1,
						filename2,
						filename3,
						filename4,
						filename5,
						skill_word,
						skill_ppt,
						skill_excel,
						skill_search,
						skill_list,
						skill_etc,
						viewListCount,
						regdate,
						modifydate,
						etc1,
						etc2,
						etc3,
						etc4,
						etc5,
						etc6,
						etc7,
						etc8,
						etc9,
						etc10,
						specialDate,
						focusDate,
						powerlinkDate,
						iconDate,
						bolderDate,
						colorDate,
						freeiconDate,
						freeicon,
						display,
						bgcolorDate,
						start_worktime,
						finish_worktime,
						guzicperson,
						guziceducation,
						guzicnational,
						guzicmarried,
						guzicchild,
						guziclicence,
						guziclicence_title,
						guzicsicompany,
						GuzicUryoDate1,
						GuzicUryoDate2,
						GuzicUryoDate3,
						GuzicUryoDate4,
						GuzicUryoDate5,
						use_adult,
						user_birth_year,
						user_birth_month,
						user_birth_day
				FROM
						$per_document_tb
				WHERE
						1=1
						$WHERE3
				ORDER BY
						$orderby
				LIMIT
						$start, $scale
		";
	}
	else
	{
		$Sql	= "
				SELECT
						number,
						grade_money,
						skin_html,
						skin_date,
						title,
						user_id,
						user_name,
						user_age,
						user_prefix,
						user_phone,
						user_hphone,
						user_email1,
						user_email2,
						user_homepage,
						user_image,
						job_where1_0,
						job_where1_1,
						job_where2_0,
						job_where2_1,
						job_where3_0,
						job_where3_1,
						job_type1,
						job_type2,
						job_type3,
						job_type_sub1,
						job_type_sub2,
						job_type_sub3,
						keyword,
						grade_gtype,
						grade_money,
						grade_money_type,
						grade_lastgrade,
						grade2_schoolType,
						grade3_schoolType,
						grade4_schoolType,
						grade5_schoolType,
						grade6_schoolType,
						work_year,
						work_month,
						work_otherCountry,
						filename1,
						filename2,
						filename3,
						filename4,
						filename5,
						skill_word,
						skill_ppt,
						skill_excel,
						skill_search,
						skill_list,
						skill_etc,
						viewListCount,
						regdate,
						modifydate,
						etc1,
						etc2,
						etc3,
						etc4,
						etc5,
						etc6,
						etc7,
						etc8,
						etc9,
						etc10,
						specialDate,
						focusDate,
						powerlinkDate,
						iconDate,
						bolderDate,
						colorDate,
						freeiconDate,
						freeicon,
						display,
						bgcolorDate,
						start_worktime,
						finish_worktime,
						guzicperson,
						guziceducation,
						guzicnational,
						guzicmarried,
						guzicchild,
						guziclicence,
						guziclicence_title,
						guzicsicompany,
						GuzicUryoDate1,
						GuzicUryoDate2,
						GuzicUryoDate3,
						GuzicUryoDate4,
						GuzicUryoDate5,
						use_adult,
						user_birth_year,
						user_birth_month,
						user_birth_day

						$add_field
						,x_point,y_point
				FROM
						$per_document_tb
				WHERE
						1=1
						$WHERE
				ORDER BY
						$orderby
				LIMIT
						$start, $scale
		";
	}

	$Record	= query($Sql);
	//echo $Sql;
	//echo nl2br($Sql)."<br>";//이력서리스트쿼리

	#---------- 루프시작전 기본셋팅 ----------#

	$content = "";


	if ($extract_type == "모바일스크롤")
	{

		$mobile_scroll_count++;					//모바일스크롤 그룹 추출태그개수

		if ( $extract_type_cut != 1 )
		{
			$paging_limit	= 1;					//모바일스크롤 그룹 페이징개수

			if ( $이력서수 >= ($widthSize*$heightSize) )
			{
				for ($pp=($widthSize*$heightSize); $이력서수>$pp; $pp=($pp+($widthSize*$heightSize)))
				{
					$paging_limit++;
				}
			}
		}



		//모바일스크롤 그룹별 이미지체인징
		$content .= "
				<script>
					var stabSPhoto_on_{$mobile_scroll_count} = new Array() ;
					var stabSPhoto_off_{$mobile_scroll_count} = new Array() ;
					for (i=0; i<{$paging_limit}; i++){
					 stabSPhoto_on_{$mobile_scroll_count}[i] = new Image() ;
					 stabSPhoto_on_{$mobile_scroll_count}[i].src = 'mobile_img/water_drop_on.gif' ;
					 stabSPhoto_off_{$mobile_scroll_count}[i] = new Image() ;
					 stabSPhoto_off_{$mobile_scroll_count}[i].src = 'mobile_img/water_drop_off.gif' ;
					}
					var stabSPhotoImgName_{$mobile_scroll_count} ;


					function stabSPhotoAct_{$mobile_scroll_count}(c_num,now_index)
					{
						for (i=0; i<{$paging_limit}; i++)
						{
							stabSPhotoImgName_{$mobile_scroll_count} = 'stabSPhoto_'+c_num+'_' + i ;
							document.images[stabSPhotoImgName_{$mobile_scroll_count}].src = stabSPhoto_off_{$mobile_scroll_count}[i].src ;
						}
						stabSPhotoImgName_{$mobile_scroll_count} = 'stabSPhoto_'+c_num+'_' + now_index ;
						document.images[stabSPhotoImgName_{$mobile_scroll_count}].src = stabSPhoto_on_{$mobile_scroll_count}[now_index].src ;
					}
				</script>
		";
		//모바일스크롤 그룹별 이미지체인징 END
	}
	if ($paging_limit > 1) //페이징 필요없다면 id를 안줘서 돌지않게한다
	{
		$container_id	= "id='container_{$mobile_scroll_count}'";
		$prev_id		= "id='prev_{$mobile_scroll_count}'";
		$next_id		= "id='next_{$mobile_scroll_count}'";
	}

	if ($extract_type == "모바일스크롤") //모바일스크롤 추출물 디자인 감싸기 시작
	{
		$content .= "<div $container_id class='container' style='border:0px solid #0000ff; width:100%;'>";
		$content .= "<div class='panel' style='border:0px solid #0000ff; width:100%;'>";
		$content .= "<table cellspacing='0' cellpadding='0' border='0' width='100%' border='1'>\n<tr>\n";
	}
	else if ( $doc_extraction_return != "return" )
	{
		$content	= "<table cellspacing='0' cellpadding='0' border='0' align='center' width='100%' border='0'>\n<tr>\n";
	}
	else
	{
		$content = "";
	}


	$Happy_Img_Name = array();
	#-------------------- 루프시작 --------------------#
	$Count	= 0;
	$rand	= rand(0,10000);
	if ( !file_exists("$skin_folder/$template1") )
	{
		echo "<font color='red'>$skin_folder/$template1 파일이 없습니다.</font>";
		return;
	}
	$TPL->define("알맹이".$rand, "$skin_folder/$template1");
	//echo nl2br($Sql);
	//echo "$skin_folder/$template1";
	//echo $Sql;


	//$adult_check = "";
	//if(!$_COOKIE['ad_id'] && !$_COOKIE['adult_check'] && !$mem_id)
	//	$adult_check = "1";

	//성인인증여부 체크변수 성인증되면1 안되면0
	$adult_check = happy_adult_check();

	//구직정보보기 유료결제 권한
	$secure_guzic_view_pay_option		= happy_member_secure($happy_member_secure_text[0].'보기 유료결제');
	//구직정보보기 권한
	$secure_guzic_view_option			= happy_member_secure($happy_member_secure_text[0].'보기');

	//document_extraction_list
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		//print_r2($Data);exit;
		$Count++;

		$Data['secure'] = $Data['secure'] == '' ? "없음" : $Data['secure'];

		//위치기반
		$Data['listNo']	= $Count;

		$Data['ajax_map_num']	= 0;
		if ( $_GET['map_point'] == '' || $_GET['happy_ajax_map_start'] == 'ok' )
		{
			$Data['ajax_map_num']	= $Count;
			//echo $Data['ajax_map_num']."<br>";
		}


		if ( $Data['metor'] != '' )
		{
			$Data['중심점거리']	= round($Data['metor']/1000,2);
		}

		$Data['metor']			= round($Data['metor']);

		if ( $Data['metor'] / 1000 >= 1  )
		{
			$Data['metor_comma']	= number_format($Data['metor'] / 1000, 1)." km";
		}
		else
		{
			$Data['metor_comma']	= number_format($Data['metor'])." 미터";
		}
		//위치기반


		if($_GET['a'] == "guzic"){
			$popHeight = 400;
		}else{
			$popHeight = 600;
		}

		#관리자모드 로고변경링크 2010-11-10 kad
		$GuzicMem = happy_member_information($Data['user_id']);
		$Data['logo_change'] = "<a href='#1' onClick=\"window.open('../logo_change.php?number=".$GuzicMem['number']."&member_group=".$GuzicMem['group']."&member_id=".$GuzicMem['user_id']."','com_log','width=450,height=".$popHeight.",toolbar=no')\" class='btn_small_stand'>사진수정</a>";
		#관리자모드 로고변경링크 2010-11-10 kad

		#echo "1 = ".$Data[job_type1]." // 2 = ".$Data[job_type2]." // 3 = ".$Data[job_type3]."<br>";
		//19금 일경우 아이콘 넣어 주자!
		if( $adult_check != "1" && $Data['use_adult'])
		{
			$Data[adult_guzic_icon] = "<img src=".$HAPPY_CONFIG['adult_guzic_list']." border='0' alt='성인전용' align=absmiddle>";
		}

		#$비공개		= ( $Data["display"] == "N" )?"(비공개)":"";
		$비공개		= ( $Data["display"] == "N" )?"(".$HAPPY_CONFIG['MsgGuzicNoDisplay1'].")":"";

		$SubSql		= "SELECT Count(number) FROM $per_worklist_tb WHERE pNumber='$Data[number]'";
		$Temp		= happy_mysql_fetch_array(query($SubSql));
		$회사수		= $Temp[0];

		$SubSql		= "SELECT Count(number) FROM $per_skill_tb WHERE userid='$Data[user_id]' ";
		$Temp		= happy_mysql_fetch_array(query($SubSql));
		$기술수		= $Temp[0];

		$SubSql		= "SELECT Count(number) FROM $per_language_tb WHERE userid='$Data[user_id]' ";
		$Temp		= happy_mysql_fetch_array(query($SubSql));
		$언어수		= $Temp[0];

		$SubSql		= "SELECT Count(number) FROM $per_yunsoo_tb WHERE userid='$Data[user_id]' ";
		$Temp		= happy_mysql_fetch_array(query($SubSql));
		$연수횟수	= $Temp[0];

		# 관리자모드에서 비공개인지 아닌지 확인을 위한 태그추가 # 2009/05/09 kwak16
		#$Data['display_print']	= $Data['display'] == 'Y' ? '' : '<font color=red>[비공개]</font>';
		$Data['display_print']	= $Data['display'] == 'Y' ? '' : '<font color=red>['.$HAPPY_CONFIG['MsgGuzicNoDisplay1'].']</font>';
		$Data['display_print2']	= $Data['display'] == 'Y' ? '공개' : '<font color=red>'.$HAPPY_CONFIG['MsgGuzicNoDisplay1'].'</font>';
		$Data['display_print_none']	= $Data['display'] == 'Y' ? '공개' : $HAPPY_CONFIG['MsgGuzicNoDisplay1'];

		$Data["age"]	= $Data["user_age"];
		if ( $option3 == "내가신청한구인" || $option3 == "내가신청한구인(온라인)" || $option3 == "내가신청한구인(이메일)" )
		{
			$MEM = happy_member_information($Data['com_id']);
			$MEM['etc1'] = $MEM['photo2'];
			$MEM['etc2'] = $MEM['photo3'];
			$MEM['com_profile1'] = $MEM['message'];
			$MEM['com_profile2'] = $MEM['extra16'];

			if ($MEM[etc1] == "")
			{
				#$Data[etc1] = 'no_image.gif';
				$Data['etc1'] = $HAPPY_CONFIG['IconComNoLogo1'];
			}

			$Data['com_profile1'] = nl2br($MEM['com_profile1']);
			$Data['com_profile2'] = nl2br($MEM['com_profile2']);

			if ( file_exists ("./$MEM[etc1]") && $MEM['etc1'] != "" )
			{
				$Data['logo_temp'] = "./$MEM[etc1]";
			}
			else
			{
				$Data['logo_temp'] =  $HAPPY_CONFIG['IconComNoLogo1'];
			}

			if ( file_exists ("./$MEM[etc2]") && $MEM['etc2'] != "" )
			{
				$Data['banner'] = "./$MEM[etc2]";
			}
			else
			{
				$Data['banner'] =  $HAPPY_CONFIG['IconComNoBanner1'];
			}

			#온라인입사지원의 취소
			if ( $Data['read_ok'] == 'N' )
			{
				$Data['read_ok_info'] = '확인전';
				$Data['read_ok_info'] = $HAPPY_CONFIG['OnlineDontCheckText'];
			}
			else
			{
				$Data['read_ok_info'] = '확인함';
				$Data['read_ok_info'] = $HAPPY_CONFIG['OnlineCheckedText'];
			}

			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$Data['OnlineCancelBtn'] = '<a href="javascript:void(0);" style="color:#ccc;">취소불가</a>';
				if ( $HAPPY_CONFIG['OnlineCancelAble'] == 'Y' )
				{
					if ( $Data['read_ok'] == 'N' )
					{
						$Data['OnlineCancelBtn'] = '<a href="javascript:OnlineDel(\''.$Data['bNumber'].'\');" style="color:#666; display:block">취소가능</a>';
					}
				}
			}
			else
			{
				$Data['OnlineCancelBtn'] = '<img src="img/cancel_not_btn.gif" border="0" align="absmiddle" alt="취소안됨">';
				if ( $HAPPY_CONFIG['OnlineCancelAble'] == 'Y' )
				{
					if ( $Data['read_ok'] == 'N' )
					{
						$Data['OnlineCancelBtn'] = '<a href="javascript:OnlineDel(\''.$Data['bNumber'].'\');"><img src="img/cancel_btn.gif" border="0" align="absmiddle" alt="취소가능"></a>';
					}
				}
			}

			#온라인입사지원의 취소

			//채용정보 출력 hong
			$Sql			= "SELECT * FROM $guin_tb WHERE number = '{$Data['guin_number']}'";
			$GUIN_INFO		= happy_mysql_fetch_assoc(query($Sql));

			//채용마감일의 D-day
			$GUIN_INFO['guin_end_date_dday'] = "";
			if ( $GUIN_INFO[guin_choongwon] )
			{
				$GUIN_INFO[guin_end_date] = "<span class='font_st_11' style='color:#3f3f3f;'>상시채용</span>";
			}
			else
			{
				//채용마감일의 D-day
				$tnow = date("Y-m-d H:i:s");
				$GUIN_INFO['guin_end_date_dday'] = '<div style=" color:#4a4a4a;" class=font_12_tahoma><b >'."D-".happy_date_diff($tnow,$GUIN_INFO[guin_end_date]).'</b></div>';

				//<div style="border:1px solid #dbdbdb; background-color:#f9f9f9;"></div>
				if ( happy_date_diff($tnow,$GUIN_INFO[guin_end_date]) < 0 )
				{
					$GUIN_INFO['guin_end_date']	= "<span class='d_day' style='letter-spacing:0'>마감</span>";
				}
				else
				{
					$dday_interval = date("Y-m-d",strtotime($GUIN_INFO["guin_end_date"]."-{$HAPPY_CONFIG[guin_end_date_dday]} day"));
					if(date("Y-m-d") == $GUIN_INFO["guin_end_date"])
					{
						$GUIN_INFO['guin_end_date']	= "D-day";
					}
					else if(date("Y-m-d") >= $dday_interval)
					{
						$GUIN_INFO['guin_end_date']	= "<span class='d_day' style='letter-spacing:0'>D-".happy_date_diff(date("Y-m-d"),$GUIN_INFO['guin_end_date'])."</span>";
					}
				}
			}

			if ( $GUIN_INFO["guin_pay"] == preg_replace("/\D/","",$GUIN_INFO["guin_pay"]) )
			{
				$GUIN_INFO["guin_pay"] = number_format($GUIN_INFO["guin_pay"])."원";
			}

			// 급여조건(세전/세후)
			$GUIN_INFO['pay_type_txt'] = ( $GUIN_INFO['pay_type'] == 'gross' ) ? '세전' : '세후';

			$GUIN_INFO["guin_pay_icon"]		= $want_money_img_arr[$GUIN_INFO['guin_pay_type']];
			$GUIN_INFO["guin_pay_icon2"]	= $want_money_img_arr2[$GUIN_INFO['guin_pay_type']];

			#업체로고구하기
			#bnl 로고 , bns 배너광고용
			$Tmem = happy_member_information($GUIN_INFO['guin_id']);
			//$bns_img = $Tmem['photo2'];
			//$bnl_img = $Tmem['photo3'];

			//개별 채용정보에 저장된 이미지를 사용하기 위해서 DB 컨버팅함
			$bns_img = $GUIN_INFO['photo2'];
			$bnl_img = $GUIN_INFO['photo3'];

			$GUIN_INFO['com_name'] = $Tmem['com_name'];

			if ( $bnl_img == "" )
			{
				#$NEW[com_logo] = "./img/logo_img.gif";
				$GUIN_INFO[com_logo] = "./".$HAPPY_CONFIG['IconComNoLogo1']."";
			}
			else
			{
				$logo_img = explode(".",$bnl_img);
				$logo_temp = $logo_img[0].".".$logo_img[1];

				if ( file_exists("./$logo_temp" ) )
				{
					$GUIN_INFO[com_logo] = "./$logo_temp";
				}
				else
				{
					$GUIN_INFO[com_logo] = "./$bnl_img";
				}
			}

			if ( $bns_img == "" )
			{
				#$NEW[logo] = "./img/logo_img.gif";
				$GUIN_INFO[logo] = "./".$HAPPY_CONFIG['IconComNoBanner1']."";
			}
			else
			{
				$banner_img = explode(".",$bns_img);
				$banner_temp = $banner_img[0].".".$banner_img[1];
				if ( file_exists("./$banner_temp" ) )
				{
					$GUIN_INFO[logo] = "./$banner_temp";
				}
				else
				{
					$GUIN_INFO[logo] = "./$bns_img";
				}
			}

			//진행or마감여부
			if ( $GUIN_INFO['guin_end_date'] == "충원시" || $GUIN_INFO['guin_end_date'] > date("Y-m-d") )
			{
				$GUIN_INFO['guin_end_text']	= "진행중";
			}
			else
			{
				$GUIN_INFO['guin_end_text']	= "마감";
			}
		}

		$Count2	= 0;
		for ( $i=1 ; $i<=5 ; $i++ )
		{
			if ( $Data["file".$i] != "" )
			{
				$Count2++;
			}
		}
		$파일수	= $Count2;

		$OPTION["user_photo"]	= "";


		if ( $Data["user_image"] == "" )
		{
			#$큰이미지	= "img/noimg.gif";
			#$작은이미지	= "img/noimg.gif";
			$큰이미지	= $main_url."/".$HAPPY_CONFIG['IconGuzicNoImg1'];
			$작은이미지	= $main_url."/".$HAPPY_CONFIG['IconGuzicNoImg1'];
		}
		else if ( !eregi($per_document_pic,$Data["user_image"]) && strpos($Data["user_image"],$happy_member_upload_folder) === false )
		{
			if ( !preg_match("/^http/i",$Data["user_image"]) )
			{
				$큰이미지	= $main_url."/".$Data["user_image"];
				$작은이미지	= $main_url."/".$Data["user_image"];
			}
			else
			{
				$큰이미지	= $Data["user_image"];
				$작은이미지	= $Data["user_image"];
			}
		}
		else
		{
			$Tmp		= explode(".",$Data["user_image"]);
			if (preg_match("/jpg/i",$Tmp[sizeof($Tmp)-1]))
			{
				$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], "_thumb.".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
			}
			else
			{
				$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], ".".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
			}
			$큰이미지	= $Data["user_image"];
			$작은이미지	= $Tmp2;

			if ( !preg_match("/^http/i",$Data["user_image"]) )
			{
				$큰이미지	= $main_url."/".$Data["user_image"];
				$작은이미지	= $main_url."/".$Data["user_image"];
			}
			else
			{
				$큰이미지	= $Data["user_image"];
				$작은이미지	= $Data["user_image"];
			}

			#$OPTION["user_photo"]	= "<img src='img/photo_user.gif' alt='사진있음'>";
			$OPTION["user_photo"]	= "<img src='".$HAPPY_CONFIG['IconGuzicPhoto1']."' alt='사진있음' align='absmiddle'>";
		}

		if( $adult_check != "1" && $Data['use_adult'])
		{
			$이미지정보 = $HAPPY_CONFIG['adult_guzic'];

			//새로운썸네일
			$Happy_Img_Name[0] = "".$HAPPY_CONFIG['adult_guzic'];
		}
		else{
			$이미지정보	= $작은이미지;

			//새로운썸네일
			$Happy_Img_Name[0] = ".".$작은이미지;
		}
		//echo $이미지정보."<br>";


		#자기 이력서 이거나 유료옵션을 사용중인 기업회원은 이름을 다 보여주자
		$com_id_secure = "no";

		if ( $secure_guzic_view_pay_option )
		{
			$Sql2	= "SELECT count(*) FROM $job_com_doc_view_tb WHERE com_id='$mem_id' AND doc_number='$Data[number]' ";
			$Tmp	= happy_mysql_fetch_array(query($Sql2));

			if ( $Tmp[0] != 0 )
			{
				$com_id_secure		= "ok";
			}

			//기간별 이력서보기
			$tmp_array = array("guin_docview","guin_docview2","guin_smspoint");
			$Tmp = happy_member_option_get_array($happy_member_option_type,$mem_id,$tmp_array);

			if ( $Tmp["guin_docview"] > $real_gap )
			{
				$com_id_secure		= "ok";
			}

			#무료화로 이용
			if ( $CONF['guin_docview'] == "" && $CONF['guin_docview2'] == "" )
			{
				$com_id_secure		= "ok";
			}
			#무료화로 이용
		}

		if ( $Data["user_id"] == $mem_id || $com_id_secure == "ok")
		{
			$Data["user_name_cut"] = kstrcut($Data["user_name"],"6","");
		}
		else
		{
			$Data["user_name_cut"]	= kstrcut($Data["user_name"],2,"") . "○○";
		}
		#자기 이력서 이거나 유료옵션을 사용중인 기업회원은 이름을 다 보여주자

		for ( $i=0,$max=sizeof($skillArray) ; $i<$max ; $i++ )
		{
			switch ( $Data[$skillArray[$i]] )
			{
				case "3": $Data[$skillArray[$i]."_han"] = "상";break;
				case "2": $Data[$skillArray[$i]."_han"] = "중";break;
				case "1": $Data[$skillArray[$i]."_han"] = "하";break;
				default : $Data[$skillArray[$i]."_han"] = "";$Data[$skillArray[$i]] = "0";break;
			}
		}

		$nowDate				= date("Y-m-d H:i:s");

		#자유아이콘
		$Data["freeicon"]		= ( $Data["freeicon"] == "" )?"freeicon_default.gif":$Data["freeicon"];
		#스페셜
		#$OPTION["special"]		= ( $Data["specialDate"] >= $nowDate )?"<img src='img/icon_spec.gif' border='0' align=absmiddle>":"";
		$OPTION["special"]		= ( $Data["specialDate"] >= $nowDate )?"<img src='".$HAPPY_CONFIG['IconGuzicSpec1']."' border='0' align=absmiddle>":"";
		$OPTION["special2"]		= ( $Data["specialDate"] >= $nowDate )?"<span class='special_txt_icon'>special</span>":"";
		#포커스
		#$OPTION["focus"]		= ( $Data["focusDate"] >= $nowDate )?"<img src='img/icon_focus.gif' border='0' align=absmiddle>":"";
		$OPTION["focus"]		= ( $Data["focusDate"] >= $nowDate )?"<img src='".$HAPPY_CONFIG['IconGuzicFocus1']."' border='0' align=absmiddle>":"";
		$OPTION["focus2"]		= ( $Data["focusDate"] >= $nowDate )?"<span class='focus_txt_icon'>focus</span>":"";
		#파워링크
		#$OPTION["powerlink"]	= ( $Data["powerlinkDate"] >= $nowDate )?"<img src='img/icon_powerlink.gif' border='0' align=absmiddle>":"";
		$OPTION["powerlink"]	= ( $Data["powerlinkDate"] >= $nowDate )?"<img src='".$HAPPY_CONFIG['IconGuzicPowerLink1']."' border='0' align=absmiddle>":"";
		$OPTION["powerlink2"]	= ( $Data["powerlinkDate"] >= $nowDate )?"<span class='powerlink_txt_icon'>power</span>":"";
		#아이콘
		#$OPTION["icon"]			= ( $Data["iconDate"] >= $nowDate )?"<img src='img/icon_icon.gif' border='0' align=absmiddle>":"";
		$OPTION["icon"]			= ( $Data["iconDate"] >= $nowDate )?"<img src='".$HAPPY_CONFIG['IconGuzicIcon2']."' border='0' align=absmiddle>":"";
		#볼드[s]
		$OPTION["bolder"]		= ( $Data["bolderDate"] >= $nowDate )?"<b>":"";
		#볼드[e]
		$OPTION["bolder2"]		= ( $Data["bolderDate"] >= $nowDate )?"</b>":"";
		#볼드xml용
		$OPTION["bolder_xml"]		= ( $Data["bolderDate"] >= $nowDate )?htmlspecialchars("<b>"):"";

		#컬러[s]
		$OPTION["color"]		= ( $Data["colorDate"] >= $nowDate )?"<font color='$doc_title_color'>":"";
		#컬러[e]
		$OPTION["color2"]		= ( $Data["colorDate"] >= $nowDate )?"</font>":"";

		$OPTION["freeicon"]		= ( $Data["freeiconDate"] >= $nowDate )?"<img src='img/$Data[freeicon]' border='0' align=absmiddle>":"";
		#배경색추가
		$OPTION["bgcolor1"]		= ( $Data["bgcolorDate"] >= $nowDate )?"<span style='padding:2px;background:$doc_title_bgcolor;'>":"";
		$OPTION["bgcolor2"]		= ( $Data["bgcolorDate"] >= $nowDate )?"</span>":"";

		$Data["skin_date"]		= substr($Data["skin_date"],0,10);
		$Data["specialDate"]	= substr($Data["specialDate"],0,10);
		$Data["focusDate"]		= substr($Data["focusDate"],0,10);
		$Data["powerlinkDate"]	= substr($Data["powerlinkDate"],0,10);
		$Data["iconDate"]		= substr($Data["iconDate"],0,10);
		$Data["bolderDate"]		= substr($Data["bolderDate"],0,10);
		$Data["colorDate"]		= substr($Data["colorDate"],0,10);
		$Data["freeiconDate"]	= substr($Data["freeiconDate"],0,10);
		$Data["bgcolorDate"]	= substr($Data["bgcolorDate"],0,10);
		#추가된옵션5
		$Data["GuzicUryoDate1"]	= substr($Data["GuzicUryoDate1"],0,10);
		$Data["GuzicUryoDate2"]	= substr($Data["GuzicUryoDate2"],0,10);
		$Data["GuzicUryoDate3"]	= substr($Data["GuzicUryoDate3"],0,10);
		$Data["GuzicUryoDate4"]	= substr($Data["GuzicUryoDate4"],0,10);
		$Data["GuzicUryoDate5"]	= substr($Data["GuzicUryoDate5"],0,10);



		$사용중인옵션	= "";

		$사용중인옵션	.= ( $Data["skin_date"] >= $nowDate )?"<table cellpadding=0 cellspacing=0><tr><td class='font_12_tahoma'>유료 스킨 : <b>$Data[skin_date]</b> 까지 사용</td></tr></table>":"";

		for ( $i=0 , $max=sizeof($PER_ARRAY) ; $i<$max ; $i++ )
		{
			if ( $사용중인옵션 != "" && $Data[$PER_ARRAY[$i]] >= $nowDate )
			{
				$사용중인옵션	.= "";
			}
			$사용중인옵션	.= ( $Data[$PER_ARRAY[$i]] >= $nowDate )?"<table cellpadding=0 cellspacing=0><tr><td class='font_12_tahoma'>".$PER_ARRAY_NAME[$i]." : <b>".$Data[$PER_ARRAY[$i]]."</b> 까지 사용</td></tr></table>":"";
		}

		if ( $사용중인옵션 != "" )
		{
			#내용이 없다면
			//$사용중인옵션 = "<a  onMouseover=\"stickytooltip('<table cellpadding=0 cellspacing=0><tr><td width=5 height=5></td><td ></td><td  width=5 height=5></td></tr><tr><td></td><td style=padding:5;>$사용중인옵션</td><td ></td></tr><tr><td width=5 height=5></td><td ></td><td  width=5 height=5></td></tr></table>','', 250)\"; onMouseout=\"hidestickytooltip()\"><font color=#15A9D4 onmouseover=\"this.style.cursor='pointer'\">".$HAPPY_CONFIG['MsgGuzicUseOption1']."";

			//새로운툴팁
			$tooltip_layer_id_opt	= 'document_tooltip_'.$doc_extraction_unique_number."_".$Data['number'];
			$opt_tool_tip			= " data-tooltip='$tooltip_layer_id_opt' ";

			$tool_tip_layer			.= "<div id='$tooltip_layer_id_opt' class='atip' style='width:250px'><table cellpadding=0 cellspacing=0><tr><td width=5 height=5></td><td ></td><td  width=5 height=5></td></tr><tr><td></td><td style=padding:5;>$사용중인옵션</td><td ></td></tr><tr><td width=5 height=5></td><td ></td><td  width=5 height=5></td></tr></table></div>";
			$사용중인옵션			= "<a $opt_tool_tip><span style='color:#666666; cursor:pointer'>".$HAPPY_CONFIG['MsgGuzicUseOption1']."</a>";
		}
		else
		{
			#$사용중인옵션 = "<font style='font-size:9pt'>유료옵션을 사용하고 있지 않습니다.</font>";
			$사용중인옵션 = "<span style=''>".$HAPPY_CONFIG['MsgGuzicNoUseOption1']."</span>";
		}

		//패키지용 유료옵션
		$구직정보유료옵션 = "";

		for ( $i=0 , $max=sizeof($PER_ARRAY) ; $i<$max ; $i++ )
		{
			//echo $PER_ARRAY_DB[$i]."_use".":".$CONF[$PER_ARRAY_DB[$i]."_use"]."<br>";
			if ( $CONF[$PER_ARRAY_DB[$i]] != "" && $CONF[$PER_ARRAY_DB[$i]."_use"] == "사용함" )
			{
				//echo $PER_ARRAY[$i]."<br>";
				if ( $Data[$PER_ARRAY[$i]] >= $nowDate )
				{
					if( $_COOKIE['happy_mobile']  == 'on' )
					{
						$구직정보유료옵션	.= "
						<table cellspacing='0' cellpadding='0' style='width:100%; border-collapse: collapse;' class='regist_chart_01'>
							<tr>
								<td class='pay_line_th' style='height:40px'>
									".$PER_ARRAY_NAME[$i]."
								</td>
								<td class='pay_line_td' style='text-align:right; color:#4587de'>
									".$Data[$PER_ARRAY[$i]]."</b> 까지 사용가능
								</td>
							</tr>
						</table>
						";
					}
					else
					{
						$구직정보유료옵션	.= "
						<table cellspacing='0' cellpadding='0' style='width:100%; border-collapse: collapse;'>
							<tr>
								<td class='font_14 noto400' style='width:200px; height:60px; border:1px solid #c5c5c5; border-left:0 none; border-top:0 none; text-align:center'>
									".$PER_ARRAY_NAME[$i]."
								</td>
								<td class='font_16 noto500' align='' style='width:240px; text-align:center; border:1px solid #c5c5c5; border-top:0 none; line-height:24px; letter-spacing:-1px;'>
									".$PER_ARRAY_NAME[$i]."
								</td>
								<td class='font_14 noto400' style='padding-right:30px; text-align:right; border:1px solid #c5c5c5; border-right:0 none; border-top:0 none; letter-spacing:-1px'>
									".$Data[$PER_ARRAY[$i]]."</b> 까지 사용가능
								</td>
							</tr>
						</table>
						";
					}
				}
				else
				{
					if( $_COOKIE['happy_mobile']  == 'on' )
					{
						$구직정보유료옵션	.= "
						<table cellspacing='0' cellpadding='0' style='width:100%; border-collapse: collapse;'>
							<tr>
								<td class='pay_line_th' style='height:40px'>
									".$PER_ARRAY_NAME[$i]."
								</td>
								<td class='pay_line_td' style='text-align:right; color:#ff6600'>
									옵션사용안함
								</td>
							</tr>
						</table>
						";
					}
					else
					{
						$구직정보유료옵션	.= "
						<table cellspacing='0' cellpadding='0' style='width:100%; border-collapse: collapse;'>
							<tr>
								<td class='font_14 noto400' style='width:200px; height:60px; border:1px solid #c5c5c5; border-left:0 none; border-top:0 none; text-align:center'>
									".$PER_ARRAY_NAME[$i]."
								</td>
								<td class='font_16 noto500' align='' style='width:240px; text-align:center; border:1px solid #c5c5c5; border-top:0 none; line-height:24px; letter-spacing:-1px;'>
									".$PER_ARRAY_NAME[$i]."
								</td>
								<td class='font_14 noto400' style='padding-right:30px; text-align:left; border:1px solid #c5c5c5; border-right:0 none; border-top:0 none; letter-spacing:-1px; text-align:right'>
									옵션사용안함
								</td>
							</tr>
						</table>
						";
					}
				}
			}
		}

		if( $_COOKIE['happy_mobile']  == 'on' )
			{
				$Data['btn_package_use'] = '<input type="button" value="패키지 옵션사용" onclick="location.href=\'my_package_use.php?mode=use&guzic_number='.$Data['number'].'&pack_number='.$_GET['pack_number'].'&pay_type=person\'" style="color:#fff; background:#4587de">';
			}
			else
			{
				$Data['btn_package_use'] = '<a href="my_package_use.php?mode=use&guzic_number='.$Data['number'].'&pack_number='.$_GET['pack_number'].'&pay_type=person">';
				$Data['btn_package_use'].= '<img src="img/skin_icon/make_icon/skin_icon_712.jpg" align="absmiddle" border="0" alt="패키지옵션사용">';
				$Data['btn_package_use'].= '</a>';
			}


		//echo $구직정보유료옵션;
		//패키지용 유료옵션



		#$Data["title_cut"]		= ( $Data["title"] == "" )?"[설정된 제목이 없습니다.]":kstrcut($Data["title"], $cutSize, "...");
		$Data["title_cut"]		= ( $Data["title"] == "" )?$HAPPY_CONFIG['MsgGuzicNoTitle1']:kstrcut($Data["title"], $cutSize, "...");



		#2차직종 - 맞춤채용정보검색 버그로 수정함 2010-01-14 kad
		#$Data["job_type1_original"]	= $Data["job_type1"];
		#$Data["job_type2_original"]	= $Data["job_type2"];
		#$Data["job_type3_original"]	= $Data["job_type3"];

		$Data["job_type1_original"]	= $Data["job_type_sub1"];
		$Data["job_type2_original"]	= $Data["job_type_sub2"];
		$Data["job_type3_original"]	= $Data["job_type_sub3"];

		#1차직종 - 맞춤채용정보검색 버그로 수정함 2010-01-14 kad
		#$Data["job_type1_top"]		= $TYPE_SUB_NUMBER[$Data["job_type1"]];
		#$Data["job_type2_top"]		= $TYPE_SUB_NUMBER[$Data["job_type2"]];
		#$Data["job_type3_top"]		= $TYPE_SUB_NUMBER[$Data["job_type3"]];

		$Data["job_type1_top"]		= $Data["job_type1"];
		$Data["job_type2_top"]		= $Data["job_type2"];
		$Data["job_type3_top"]		= $Data["job_type3"];

		#$Data["work_year_search"]	= ( $Data["work_year"] == 0 )?"신입":"경력";
		$Data["work_year_search"]	= ( $Data["work_year"] == 0 )?$HAPPY_CONFIG['MsgGuzicWorkYearNo1']:$HAPPY_CONFIG['MsgGuzicWorkYearYes1'];

		if ( $Data["user_prefix"] == "man" )
		{
			#$Data["user_prefix"] = "남";
			$Data["user_prefix"] = $HAPPY_CONFIG['MsgUserPrefixMan1'];
		}
		else if ( $Data["user_prefix"] == "girl" )
		{
			#$Data["user_prefix"] = "여";
			$Data["user_prefix"] = $HAPPY_CONFIG['MsgUserPrefixGirl1'];
		}
		else
		{
			$Data["user_prefix"] = "";
		}

		#$Data["work_year"]		= ( $Data["work_year"] == "" )?"경력없음":$Data["work_year"]."년";
		$Data["work_year"]		= ( $Data["work_year"] == "" )?$HAPPY_CONFIG['MsgGuzicWorkYearNo1']:sprintf("%d",$Data["work_year"])."년";

		#$Data["work_month"]		= ( $Data["work_month"] == "" )?"":$Data["work_month"]."개월";
		$Data["work_month"]		= ( $Data["work_month"] == "" )?"":sprintf("%d",$Data["work_month"])."개월";


		#$Data["grade_money"]	= ( $Data["grade_money"] != "면접후결정" )?$Data["grade_money"]."만원":$Data["grade_money"];
		#$Data["grade_money_type"]	= ( $Data["grade_money_type"] == "" )?"정보없음":$Data["grade_money_type"];
		$Data["grade_money_icon"]	= $want_money_img_arr[$Data['grade_money_type']];
		$Data["grade_money_icon2"]	= $want_money_img_arr2[$Data['grade_money_type']];
		//echo $Data["grade_money"]."<br>";
		if ( $Data["grade_money"] > 0 && $Data["grade_money"] != "" )
		{
			if ( $Data["grade_money"] == preg_replace("/\D/","",$Data["grade_money"]) )
			{
				$Data["grade_money"] = number_format($Data["grade_money"])."원";
			}

			//$Data["grade_money"] = number_format($Data["grade_money"]);
		}

		$Data["job_type1"]	= $TYPE[$Data["job_type1"]];
		$Data["job_type2"]	= $TYPE[$Data["job_type2"]];
		$Data["job_type3"]	= $TYPE[$Data["job_type3"]];

		for ( $i=1, $Data["job_type"]="" ; $i<=3 ; $i++ )
		{
			if ( $Data["job_type".$i] != "" )
			{
				$Data["job_type"]	.= ( $Data["job_type"] == "" )?"":", ";
				$Data["job_type"]	.= $Data["job_type".$i];
			}
		}

		#$Data["job_type"]	= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_type"];
		$Data["job_type"]	= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputType1']."</font>":$Data["job_type"];

		//$Data["grade_money"]	= ( trim($Data["grade_money"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputType1']."</font>":$Data["grade_money"];
		//$Data["grade_money"]	= intval($Data["grade_money"]) == '' ? '' : $Data["grade_money"];

		$Data["job_type_sub1"]	= $TYPE_SUB[$Data["job_type_sub1"]];
		$Data["job_type_sub2"]	= $TYPE_SUB[$Data["job_type_sub2"]];
		$Data["job_type_sub3"]	= $TYPE_SUB[$Data["job_type_sub3"]];

		for ( $i=1, $Data["job_type_sub"]="" ; $i<=3 ; $i++ )
		{
			if ( $Data["job_type_sub".$i] != "" )
			{
				$Data["job_type_sub"]	.= ( $Data["job_type_sub"] == "" )?"":", ";
				$Data["job_type_sub"]	.= $Data["job_type_sub".$i];
			}
		}

		for( $ii=1; $ii<=2; $ii++ )
		{
			$Sql		= "SELECT title FROM $job_underground_tb WHERE number='".$Data[underground.$ii]."' ";
			$Tmp		= happy_mysql_fetch_array(query($Sql));
			$ai_comment	.= "<font color='#0066FF'>$Tmp[title]</font> ";
			$Data["역이름"]	.= "$Tmp[title] ";
		}
		$Data["역이름"] .= $Data["subway_txt"];

		$area_arrow = "&nbsp;";
		$area_slush = " <font class='font_6' color='#ddd' style='padding:0 5px; position:relative; top:-3px;'>|</font> ";

		$Data["si1"]		= $siSelect[$Data["si1"]];
		$Data["gu1"]		= $guSelect[$Data["gu1"]];
		$Data["si2"]		= $siSelect[$Data["si2"]];
		$Data["gu2"]		= $guSelect[$Data["gu2"]];
		$Data["si3"]		= $siSelect[$Data["si3"]];
		$Data["gu3"]		= $guSelect[$Data["gu3"]];

		if( $Data["si1"] )
			$채용지역정보시1	= $Data["si1"];

		if( $Data["gu1"] )
			$채용지역정보구1	= $area_arrow.$Data["gu1"];

		if( $Data["si2"] )
			$채용지역정보시2	= $area_slush.$Data["si2"];

		if( $Data["gu2"] )
			$채용지역정보구2	= $area_arrow.$Data["gu2"];

		if( $Data["si3"] )
			$채용지역정보시3	= $area_slush.$Data["si3"];

		if( $Data["gu3"] )
			$채용지역정보구3	= $area_arrow.$Data["gu3"];

		$채용지역정보	= $채용지역정보시1.$채용지역정보구1.$채용지역정보시2.$채용지역정보구2.$채용지역정보시3.$채용지역정보구3;

		if ( $Data[guin_choongwon] )
		{
			//$Data[guin_end_date] = "<img src='img/skin_icon/make_icon/skin_icon_100.jpg' align=absmiddle>";
			$Data[guin_end_date] = "상시채용";
		}
		else
		{
			$Data[guin_end_date] = "$Data[guin_end_date]";
		}

		#$Data["job_type_sub"]	= ( trim($Data["job_type_sub"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_type_sub"];
		$Data["job_type_sub"]	= ( trim($Data["job_type_sub"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputType1']."</font>":$Data["job_type_sub"];

		$Data["job_where1"]	= $siSelect[$Data["job_where1_0"]] ." ". $guSelect[$Data["job_where1_1"]];
		$Data["job_where2"]	= $siSelect[$Data["job_where2_0"]] ." ". $guSelect[$Data["job_where2_1"]];
		$Data["job_where3"]	= $siSelect[$Data["job_where3_0"]] ." ". $guSelect[$Data["job_where3_1"]];

		$Data_job_where		= array();
		array_push($Data_job_where, $Data["job_where1"]);
		array_push($Data_job_where, $Data["job_where2"]);
		array_push($Data_job_where, $Data["job_where3"]);

		for ( $i=0, $max=sizeof($Data_job_where), $Data["job_where"]="" ; $i<$max ; $i++ )
		{
			if ( str_replace(" ","",$Data_job_where[$i]) != "" )
			{
				$Data["job_where"]	.= ( $Data["job_where"] == "" )?"":" / ";
				$Data["job_where"]	.= $Data_job_where[$i];
			}
		}

		#$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_where"];
		$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputArea1']."</font>":$Data["job_where"];

		$Data["regdate_cut"]			= substr($Data["regdate"],0,10);
		$Data["modifydate_cut"]			= substr($Data["modifydate"],0,10);
		$Data["com_guin_regdate_cut"]	= substr($Data["com_guin_regdate"],0,10);	//입사지원일
		$Data["keyword_cut"]			= ( $Data["keyword"] == "" )?"":kstrcut($Data["keyword"], $cutSize*2, "...");

		#$Data["work_otherCountry"]	= ( $Data["work_otherCountry"] == "Y" )?"해외근무경력있음":"";
		$Data["work_otherCountry"]	= ( $Data["work_otherCountry"] == "Y" )?$HAPPY_CONFIG['MsgGuzicWorkYearYes2']:"";

		if ( $Data["bNumber"] != "" )
		{
			$Data["interview"]	= str_replace("\r","",$Data["interview"]);
			$interview			= explode("\n",$Data["interview"]);

			$Data["interview"]	= "";
			for ( $i=1,$max=sizeof($interview) ; $i<=$max ; $i++ )
			{
				if ( $interview[$i-1] != "" )
				{
					$Data["interview"]	.= "답변$i : ".$interview[$i-1]."<br>";
				}
			}

			//지원자 관리 페이지 hong
			if ( preg_match("/^member_guin_/i",$_GET['file']) && $_GET['number'] != '' && $Data['com_id'] == $happy_member_login_value )
			{
				$pNumber						= $Data['number'];
				$guinNumber						= $_GET['number'];

				$Data['예비합격버튼_링크']		= "";
				$Data['예비합격버튼_텍스트']	= "";

				if ( $Data["doc_ok"] == "Y" )
				{
					$Data['예비합격버튼_링크']		= "member_guin.php?mode=docok_del&pNumber=$pNumber&guinNumber=$guinNumber";
					$Data['예비합격버튼_텍스트']	= "예비합격취소";
				}
				else
				{
					$Data['예비합격버튼_링크']		= "member_guin.php?mode=docok&pNumber=$pNumber&guinNumber=$guinNumber";
					$Data['예비합격버튼_텍스트']	= "예비합격처리";
				}
			}

			#2009-04-14 패치함
			#온라인입사지원한 이력서의 경우 입사지원의 고유번호를 추가로 넘겨주도록 변경함
			$Data["read"]			= $Data["read_ok"]."&bNumber=".$Data['bNumber'];
			#$Data["read"]			= $Data["read_ok"];

			$Data["read_ok"]		= ( $Data["read_ok"] == "Y" )?"":"미열람";
			$Data["doc_ok"]			= ( $Data["doc_ok"] == "Y" )?"예비합격자":"";
			$Data["bregdate_cut"]	= substr($Data["bregdate"],0,10);
		}

		#비공개 해야 할것들 ..
		if ( $secure_guzic_view_option && $user_id != $Data["user_id"] && !admin_secure("구인리스트"))
		{
			$tmp					= strlen($Data["user_id"]);
			$Data["user_id"]		= substr($Data["user_id"],0,$tmp-3) . "***";
		}

		if ( $guzic_keyword != "" )
		{
			$Data["title_cut"]		= str_replace($guzic_keyword, "<font color='${doc_search_color}'>$guzic_keyword</font>", $Data["title_cut"]);
		}

		$Data["doc_ok"]	= ( $Data["doc_ok"] == "" )?"미합격":$Data["doc_ok"];

		//온라인입사지원상태 구분 2011-02-17 kad
		$Data["online_stats_text"] = $online_stats[$Data['online_stats']];
		//온라인입사지원상태 구분 2011-02-17 kad


		#베이비시터관련 추가
		#활동가능요일
		$TempDays = explode(" ",$Data['etc7']);
		$Data['etc7'] = '';
		foreach($TempDays as $k => $v)
		{
			$Yicon = $TDayIcons[$v];
			if ( $v != '' )
			{
				$Data['etc7'] .= '<img src="'.$Yicon.'" border="0" align="absmiddle">';
			}
		}
		if ( $Data['etc7'] == '' )
		{
			$Data['etc7'] = $HAPPY_CONFIG['MsgNoInputDay1'];
		}
		#활동가능요일

		#근무시간
		if ( $Data['start_worktime'] != '' )
		{
			$TStartWorkTime = explode("-",$Data['start_worktime']);
			$Data['start_worktime'] = $TStartWorkTime[0]." ".$TStartWorkTime[1]."시".$TStartWorkTime[2];
		}
		else
		{
			$Data['start_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
		}

		if ( $Data['finish_worktime'] != '' )
		{
			$TFinishWorkTime = explode("-",$Data['finish_worktime']);
			$Data['finish_worktime'] = $TFinishWorkTime[0]." ".$TFinishWorkTime[1]."시".$TFinishWorkTime[2];
		}
		else
		{
			$Data['finish_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
		}

		#구직자
		if ( $Data['guzicperson'] == '' )
		{
			$Data['guzicperson'] = $HAPPY_CONFIG['MsgNoInputguzicperson1'];
		}

		#학력
		if ( $Data['guziceducation'] == '' )
		{
			$Data['guziceducation'] = $HAPPY_CONFIG['MsgNoInputguziceducation1'];
		}

		#국적
		if ( $Data['guzicnational'] == '' )
		{
			$Data['guzicnational'] = $HAPPY_CONFIG['MsgNoInputguzicnational1'];
		}

		#결혼
		if ( $Data['guzicmarried'] == '' )
		{
			$Data['guzicmarried'] = $HAPPY_CONFIG['MsgNoInputguzicmarried1'];
		}

		if ( $Data['guzicchild'] == '' )
		{
			$Data['guzicchild'] = 0;
		}

		#자격증
		if ( $Data['guziclicence'] == '무' )
		{
			$Data['guziclicence_title'] = $HAPPY_CONFIG['MsgNoInputguziclicence1'];
		}
		else
		{
			if ( $Data['guziclicence_title'] == '' )
			{
				$Data['guziclicence_title'] = $HAPPY_CONFIG['MsgNoInputguziclicence1'];
			}
		}

		#파견업체
		if ( $Data['guzicsicompany'] == '' )
		{
			$Data['guzicsicompany'] = $HAPPY_CONFIG['NoInputguzicsicompany1'];
		}
		#베이비시터관련 추가

		//최종학력 전공 출력 hong
		$Data['grade_last_schoolType'] = '정보없음';
		for ( $grd = 6 ; $grd >= 2 ; $grd-- )
		{
			//echo $grd." ==> ".$Data['grade'.$grd.'_schoolType']."<BR>";
			if ( $Data['grade'.$grd.'_schoolType'] != '' )
			{
				$Data['grade_last_schoolType'] = $Data['grade'.$grd.'_schoolType'];
				break;
			}
		}

		//지원자 중요체크 여부 - ranksa
		if($Data['app_im'] == "N")
		{
			$Data['userType']				= "per";
			$Data['update_value_change']	= "Y";
			$Data['app_im_alt']				= "☆";
		}
		else
		{
			$Data['userType']				= "per_del";
			$Data['update_value_change']	= "N";
			$Data['app_im_alt']				= "★";
		}

		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$Data['app_im_img']		= "mobile_img/app_img_{$Data[update_value_change]}.gif";
		}
		else
		{
			$Data['app_im_img']		= "img/app_img_{$Data[update_value_change]}.gif";
		}
		$Data['app_im_info']		= "<span id='app_im_img_{$Data[number]}' style='cursor:pointer'><img src='$Data[app_im_img]' alt='$Data[app_im_alt]' onClick=\"happy_app_im_change('$Data[userType]','$Data[update_value_change]','$_GET[number]','$Data[number]');\"></span>";

		$TPL->assign("알맹이".$rand);
		$content2	= &$TPL->fetch();

		#TD를 정리하자
		if ($extract_type == "모바일스크롤")
		{
			//echo ($i)."<br>";
			//$main_new = "<div class='panel'>" . $main_new . "</div>\n\n";

			$Count3 = $Count;


			//<div container>
			//<div panel>
			//<table><tr><td></td><td></tr></tr><tr><td></td> ~~~~ </tr></table>
			//</div> //panel
			//</div> //container

			$content	.= "<td width='${tdWidth}%'>\n";
			$content	.= $content2;
			$content	.= "</td>\n";

			//echo $Count.":::".$Count%($widthSize*$heightSize)."<br>";
			if ( $Count % $widthSize == 0 && $Count%($widthSize*$heightSize) != 0 ){	$content .= "</tr><tr $rowsColor>\n";	}

			//echo $Count."::".$이력서수."<br>";
			if ( $Count == $이력서수 )
			{
				if ( $Count % $widthSize != 0 )
				{
					for ( $ii=$Count%$widthSize ; $ii<$widthSize ; $ii++ )
					{
						$content	.= "<td width='$tdWidth'>&nbsp;</td>\n";
					}
				}
			}

			if ( $Count % ($widthSize*$heightSize) == 0 || $Count == $이력서수 )
			{
				//echo $Count."<br>";
				$content	.= "</tr>\n";
				$content	.= "</table>";
				$content	.= "</div>";

				if ( ($Count*($widthSize*$heightSize)) != $scale )
				{
					//echo ($Count*($widthSize*$heightSize))."!=".$scale."<br>";
				}

				if ( $Count != $이력서수 )
				{
					$content	.= "<div class='panel' style='border:0px solid #0000ff; width:100%;'>";
					$content	.= "<table cellspacing='0' cellpadding='0' border='0' width='100%' border='0'>\n<tr>\n";
				}
			}

		}
		#xml 추출관련 변수 doc_extraction_return 참조함
		else if ( $doc_extraction_return != "return" )
		{
			$content	.= "<td width='${tdWidth}%'  height='22'  class='type' valign='top'>\n";
			$content	.= $content2;
			$content	.= "</td>\n";

			if ( $Count % $widthSize == 0 ){	$content .= "</tr><tr>\n";	}
		}
		else
		{
			$content	.= $content2;
		}
	}


	if ($extract_type == "모바일스크롤")
	{

		if ( $extract_type_cut == 1 )
		{
			if ( $Count % $widthSize != 0 )
			{
				for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
				{
					$content	.= "<td width='$tdWidth'>&nbsp;</td>\n";
				}
			}
			$content	.= "</tr>\n";
			$content	.= "</table>";
			$content	.= "</div>";
		}


		$content .= "</div>\n\n"; //모바일스크롤 추출물 디자인 감싸기 끝

		//모바일스크롤 페이징
		$content .= "
				<div id='navigator_{$mobile_scroll_count}' class='navigator'>
				<p>
					<img src='mobile_img/slide_prev.gif' style='vertical-align:middle;' $prev_id>
		";


		for ($pp=0;$pp<$paging_limit;$pp++)
		{
			if ($pp == 0)
			{
				$content .= "
							<img src='mobile_img/water_drop_on.gif' border='0' style='vertical-align:middle;' name='stabSPhoto_{$mobile_scroll_count}_{$pp}'>
				";
			}
			else
			{
				$content .= "
							<img src='mobile_img/water_drop_off.gif' border='0' style='vertical-align:middle;' name='stabSPhoto_{$mobile_scroll_count}_{$pp}'>
				";
			}
		}

		$content .= "
					<img src='mobile_img/slide_next.gif' style='vertical-align:middle;' $next_id>
				</p>
			</div>

			<script>
				$('#prev_{$mobile_scroll_count}').click(function(){
					$('#container_{$mobile_scroll_count}').trigger('cf-slide-panel-prev');
				});
				$('#next_{$mobile_scroll_count}').click(function(){
					$('#container_{$mobile_scroll_count}').trigger('cf-slide-panel-next');
				});


				$('#container_{$mobile_scroll_count}').cfSlidePanel({
					getIndex: function(index) {
						stabSPhotoAct_{$mobile_scroll_count}({$mobile_scroll_count},index);
						$('#navigator_{$mobile_scroll_count} .index').text(index + 1);		// index가 zero-base(0부터 시작)로 오기 때문에 1을 더해줌
					}
				});
			</script>
		";
	}
	else if ( $doc_extraction_return != "return" )
	{
		if ( $Count % $widthSize != 0 )
		{
			for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
			{
				$content	.= "<td width='$tdWidth'>&nbsp;</td>\n";
			}
		}
		$content	.= "</tr>\n";
		$content	= str_replace("<tr>\n</tr>","",$content);
		$content	.= "</table>";
	}
	else
	{
		return $content;
	}


	if ( $Count == 0 && $option4 == "오늘본구직정보" )
	{
		#$content	= "<table cellspacing='0' cellpadding='0' border='0' height='100' border='0' width='100%'><tr><td align='center'>오늘본 프로필가 없습니다.</td></tr></table>";
		$content	= $HAPPY_CONFIG['MsgTodayNoViewGuzic1'];
	}
	if ( $Count == 0 && $option4 != "오늘본구직정보" )
	{
		#$content	= "<table cellspacing='0' cellpadding='0' border='0' height='100' border='0' width='100%'><tr><td align='center'>등록된 프로필가 없습니다.</td></tr></table>";
		$content	= $HAPPY_CONFIG['MsgRegNoGuzic1'];
	}

	#$내용	= $content;
	#-------------------- 루프종룥ㅌㅌㅌ --------------------#


	$rand	= rand(0,10000);
	#$TPL->define("껍질".$rand, "$skin_folder/$template2");
	#$TPL->parse("껍질".$rand);
	#$ALL = &$TPL->fetch();

	if ( $option3 == "맞춤구직정보" )
	{
		if ( !happy_member_secure( $happy_member_secure_text[7] ) )
		{
			return print "<h3>$happy_member_secure_text[7] 권한이 없습니다.</h3>";
		}
		else
		{
			return print $content;
		}
	}
	else
	{
		return print $content;
	}
}



//2011-11-22 kad
//{{이력서추출 가로,세로,옵션1,옵션2,옵션3,옵션4,정렬순서,글자짜름,누락개수,알맹이html,껍데기html}}
function document_extraction_list_main( $widthSize, $heightSize, $option1, $option2, $option3, $option4, $orderBy, $cutSize, $limitStart, $template1 , $pagingCheck="",$extract_type = "",$ex_option="",$ex_career_read = "")//jobwork 14
{
	document_extraction_list( $widthSize, $heightSize, $option1, $option2, $option3, $option4, $orderBy, $cutSize, $limitStart, $template1,"페이징사용안함",$extract_type,$ex_option,$ex_career_read);//jobwork
}

##################################################################


function document_view( $mainTemplate, $workTemplate, $skillTemplate, $langTemplate, $yunsooTemplate, $schoolTemplate="" ) {
	#메인템플릿 필수 그외 none 으로 입력시 데이타 안불러옴
	#메인템플릿에 각 템플릿에서 불러온 내용을 불러오는 태그는 앞에서 차례대로
	# {{직장리스트내용}} {{자격증리스트내용}} {{언어리스트내용}} {{연수리스트내용}}
	global $TPL, $skin_folder, $CONF, $job_com_doc_view_tb, $user_id, $real_gap;
	global $per_document_tb, $per_worklist_tb, $per_skill_tb, $per_language_tb, $per_yunsoo_tb, $per_noViewList, $com_guin_per_tb;
	global $siSelect, $guSelect, $document_keyword, $per_document_pic, $skillArray, $scrap_tb;
	global $직장리스트내용, $자격증리스트내용, $언어리스트내용, $연수리스트내용, $Data, $큰이미지, $작은이미지, $이미지정보, $rData;
	global $수정1, $수정2, $수정3, $수정4, $수정5, $수정6, $수정7, $예비합격버튼,$스크랩버튼,$secureMsg,$옵션수정,$상세이력서보기버튼, $문자전송, $main_url, $입사지원요청버튼, $면접제의버튼, $학력리스트내용, $User, $doc_view_secure,$TYPE, $TYPE_SUB,$TYPE_SUB_SUB;
	global $per_file_tb, $미니앨범버튼, $미니앨범버튼2, $미니앨범링크,$플래시미니앨범링크, $doc_mini_album_use;

	global $doc_read_env,$guin_docview_p,$guin_docview_c,$smsPoint,$guin_docview_p_date, $want_money_img_arr, $want_money_img_arr2;

	global $첨부파일보기;
	global $기본정보_스킨1_up,$기본정보_스킨1_bottom,$기본정보_스킨2_up,$기본정보_스킨2_bottom,$기본정보_스킨3_up,$기본정보_스킨3_bottom,$기본정보_스킨4_up,$기본정보_스킨4_bottom,$기본정보_스킨5_up,$기본정보_스킨5_bottom;

	global $쪽지보내기;
	global $HAPPY_CONFIG;
	global $TDayIcons, $TDayNames;

	global $happy_member_secure_text;
	global $happy_member_option_type;
	global $site_name;
	global $online_stats;

	global $tweeter_url, $default_meta, $tweeter_meta, $facebook_url, $me2day_url, $yozm_url, $C공감, $server_character, $SNS_logo_temp, $naverBand;

	global $happy_member_upload_folder;
	global $미니앨범사용유무;

	//자격증개수, 토익점수, 해외연부여부 추출태그 추가 - hong
	global $자격증개수, $토익점수, $해외연수여부, $경력사항내용;

	global $Happy_Img_Name;

	$number		= $_GET["number"];
	$method		= explode("?", $_SERVER["REQUEST_URI"]);

	if ( $number == "" )
	{
		return print "<font color='red'>Error</font>";
	}

	if ( $doc_view_secure == "1" && happy_member_login_check() == "" && $_COOKIE["ad_id"] == "" )
	{
		return print "<script>alert('로그인후 열람가능 합니다.');history.go(-1);</script>";
	}

	$Sql	= "SELECT * FROM $per_document_tb WHERE number='$number' ";
	//echo $Sql;
	$Data	= happy_mysql_fetch_array(query($Sql));

	// 학력사항
	global $per_academy_tb;
	$academy_html	= "";
	$sql	= "SELECT * FROM {$per_academy_tb} WHERE doc_number = '{$Data['number']}'";
	$rec	= query($sql);
	while($row = mysql_fetch_assoc($rec))
	{
		$academy_html	.= "
		<tr>
			<td>{$row['academy_in']}</td>
			<td>{$row['academy_out']}</td>
			<td>{$row['academy_out_type']}</td>
			<td>{$row['academy_name']}</td>
			<td>{$row['academy_degree']}</td>
		</tr>";
	}
	if( $academy_html == '' )
	{
		$학력리스트내용	= "<tr><td colspan='5'><span class='noto400' style='border-top:1px solid #ddd; padding:20px 0; display:block; text-align:center; font-size:15px; color:#999;'>등록된 학력정보가 없습니다.</span></td></tr>";
	}
	else
	{
		$학력리스트내용	= $academy_html;
	}

	// 경력사항
	global $per_career_tb, $TYPE, $TYPE_SUB,$TYPE_SUB_SUB, $happy_member_login_value;
	$career_html	= "";
	if( $Data['is_no_career'] == 'n' )
	{
		$sql	= "SELECT * FROM {$per_career_tb} WHERE doc_number = '{$Data['number']}' ORDER BY number ASC";
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

			if( $Data['user_id'] != $happy_member_login_value )
			{
				if( $row['career_work_name_nodisplay'] == 'y' )
				{
					$row['career_work_name']	= preg_replace('/(?<=.{1})./u','*',$row['career_work_name']);
				}
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
			$경력사항내용	= "경력없음";
		}
		else
		{
			$경력사항내용	= "<table class=\"tb_st_02\">
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
		$경력사항내용	= "경력없음";
	}

	//2011-05-16 HYO start 트위터, 페이스북, 미투데이 추가
	#tweeter 를 위한 API : 2010.11.1 NeoHero
	/*
	$tweeter_text = "$Data[title] - $main_url/document_view.php?number=$Data[number]";
	if ($server_character == 'euckr'){
		$tweeter_text = iconv("euc-kr" , "UTF-8",$tweeter_text);
	}
	$tweeter_text = urlencode($tweeter_text);
	$tweeter_url = "<a href='http://twitter.com/home?status=$tweeter_text' target=_blank onfocus='blur();'><img src=img/sns_icon/icon_twitter.png align=absmiddle border=0 alt='트위터로 보내기' width=23 height=23 class=png24></a>";
	*/
	#tweeter 를 위한 API : 2010.11.1 NeoHero


	#facebook 를 위한 API : 2010.11.1 NeoHero
	$facebook_text_u = "$main_url/document_view.php?number=$Data[number]";
	$facebook_text_t = "$Data[title]";
	if ($server_character == 'euckr'){
		$facebook_text_u = iconv("euc-kr" , "UTF-8",$facebook_text_u);
		$facebook_text_t = iconv("euc-kr" , "UTF-8",$facebook_text_t);
	}
	$facebook_text_u = urlencode($facebook_text_u);
	$facebook_text_t = urlencode($facebook_text_t);
	$facebook_url = "<a href='http://www.facebook.com/share.php?u=$facebook_text_u&t=$facebook_text_t' target=_blank onfocus='blur();'><img src=img/sns_icon/icon_facebook.png align=absmiddle border=0 alt='페이스북으로 보내기' width=23 height=23 class=png24></a>";
	#facebook 를 위한 API : 2010.11.1 NeoHero

	/*
	#me2day 를 위한 API : 2010.11.1 NeoHero
	$me2day_text_u = "\"$main_url/document_view.php?number=$Data[number]\":$main_url/document_view.php?number=$Data[number]";
	$me2day_text_t = "$Data[title]";
	if ($server_character == 'euckr'){
		$me2day_text_u = iconv("euc-kr" , "UTF-8",$me2day_text_u);
		$me2day_text_t = iconv("euc-kr" , "UTF-8",$me2day_text_t);
	}
	$me2day_text_u = urlencode($me2day_text_u);
	$me2day_text_t = urlencode($me2day_text_t);
	$me2day_url = "<a href='http://me2day.net/posts/new?new_post[body]=$me2day_text_u&new_post[tags]=$me2day_text_t' target=_blank onfocus='blur();'><img src=img/sns_icon/icon_me2day.png align=absmiddle border=0 alt='미투데이로 보내기' width=23 height=23 class=png24></a>";
	*/
	#me2day  를 위한 API : 2010.11.1 NeoHero
	//2011-05-16 HYO end 트위터, 페이스북, 미투데이 추가

	$site_name2 = $Data['title']." - ".$site_name;

	// 네이버 밴드 공유 하기 - x2chi 2015-01-28 (앱 말고 웹전용) - {{naverBand}}
	$naverBandTitle		= (preg_match('/euc/i',$server_character)) ? iconv("euc-kr", "UTF-8", $site_name2) : $site_name2;
	$naverBandTitle		= rawurlencode( $naverBandTitle." http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] );
	$naverBand = "
		<script type=\"text/javascript\">
			function naverBand ()
			{
				window.open(\"http://www.band.us/plugin/share?body=".$naverBandTitle."&route=".$_SERVER["SERVER_NAME"]."\", \"share_band\", \"width=410, height=540, resizable=no\");
			}
		</script>
		<a href='javascript:void(0);'><img src=\"img/sns_icon/icon_naver_band_02.png\" onclick=\"naverBand();\" align=\"absmiddle\" style=\"cursor:pointer;\" alt=\"네이버 밴드 공유\"></a>
	";

	//$site_name = $Data['title']."".$site_name;

	//슈퍼관리자가 아니면서...성인인증을 받지 않았거나 로그인(성인)을 하지 않은 경우는 성인 리스트를 보여주지 말자!		2010-09-30	Hun
	//if(!$_COOKIE['ad_id'] && !$_COOKIE['adult_check'] && $Data['use_adult'] && happy_member_login_check() == "" )
	//{
	//	if ( $user_id != "" && ($user_id != $Data['user_id']) )
	//	{
	//		$go_url = urlencode($_SERVER['REQUEST_URI']);
	//		gomsg("성인인증을 하셔야 합니다.", "$main_url/html_file.php?file=adultcheck.html&file2=login_default.html&mode=adult_check&go_url=$go_url");
	//		exit;
	//	}
	//}

	if ( $Data["skin_html"] != "" && $Data["skin_date"] >= date("Y-m-d") && $_POST["mail"] != "1")
	{
		$mainTemplate	= $Data["skin_html"];
		$use_skin_number = preg_replace("/\D/","",$Data["skin_html"]);
	}


	//이력서 7단계로 등록시에 사용할 스킨 파일
	//$mainTemplate = "doc_skin5.html";
	if ( $HAPPY_CONFIG['document_reg_type'] == "complex" )
	{
		$mainTemplate = str_replace(".html","_job.html",str_replace("_job.html",".html",$mainTemplate));
	}


	//이력서등록한 회원
	$User = happy_member_information($Data['user_id']);
	$User['per_birth'] = $User['user_birth_year']."-".$User['user_birth_month']."-".$User['user_birth_day'];
	$User['per_birth'] = strlen($User['per_birth']) == 2 ? "정보없음" : $User['per_birth'];

	//로그인한회원
	$MEM = happy_member_information(happy_member_login_check());

	if ( $MEM['user_id'] != "" )
	{
		//로그인한회원이 보유한 유료옵션
		$tmp_array = array("guzic_view","guzic_view2","guin_docview","guin_docview2","guin_smspoint");
		$Tmem = happy_member_option_get_array($happy_member_option_type,$MEM['user_id'],$tmp_array);
		@$MEM = array_merge($MEM,$Tmem);
		$userid = $MEM['user_id'];
		$user_id = $userid;
		$MEM['id'] = $user_id;
		$MEM['guin_smspoint'] = $MEM['guin_smspoint'];
	}



	if ( $Data['number'] == '' )
	{
		error("삭제된 프로필 입니다.");
		//msg("삭제된 프로필 입니다.");
		go($main_url);
		exit;
	}

	# 미니앨범 버튼 출력
	$미니앨범사용유무	= 'none';
	if ( $doc_mini_album_use == '1' )
	{
		$미니앨범사용유무	= '';

		$Sql	= "SELECT Count(*) FROM $per_file_tb WHERE userid='$Data[user_id]' AND doc_number='$number'";
		$mTmp	= happy_mysql_fetch_array(query($Sql));

		if ( $mTmp[0] != 0 )
		{
			$미니앨범버튼	= "<img src='img/album_btn_ok.gif' border='0' align='absmiddle' alt='미니앨범' style='cursor' onClick=\"window.open('minialbum.php?number=$number','minialbum','width=965,height=615');\"  style='cursor:pointer'>";
			$미니앨범버튼2	= "<img src='img/album_btn_ok.gif' border='0' align='absmiddle' alt='미니앨범' style='cursor' onClick=\"window.open('minialbum.php?number=$number','minialbum','width=965,height=615');\"  style='cursor:pointer'>";
			$미니앨범링크	= "window.open('minialbum.php?number=$number','minialbum','width=965,height=615');";
			$플래시미니앨범링크	= "minialbum.php?number=$number";
		}
		else
		{
			$미니앨범버튼	= "<img src='img/album_btn_no.gif' border='0' align='absmiddle' alt='미니앨범없음' onClick=\"javascript:alert('등록된 이미지가 없습니다.');\" style='cursor:pointer'>";
			$미니앨범버튼2	= '';
			$미니앨범링크	= "alert('등록된 이미지가 없습니다.');";
			$플래시미니앨범링크 = "등록된 이미지가 없습니다";
		}
	}

	$Data["grade_money_icon"]	= $want_money_img_arr[$Data['grade_money_type']];
	$Data["grade_money_icon2"]	= $want_money_img_arr2[$Data['grade_money_type']];
	$Data['work_list']			= nl2br($Data['work_list']);
	if($Data['work_list'] == ''){
		$Data['work_list'] = "<span style='display:block; text-align:center; font-size:16px; color:#999; letter-spacing:-1px;'>등록된 경력 정보가 없습니다.</span>";
	}
	if ($Data['skill_list'] == "")
	{
		$Data['skill_list']	= "<span style='font-size:16px; display:block; text-align:center; color:#999' class='noto400'>등록된 보유기술정보가 없습니다.</span>";
	}


	$User["year"]	= $User["user_birth_year"];
	$User["month"]	= $User["user_birth_month"];
	$User["day"]	= $User["user_birth_day"];

	if ( $Data["user_prefix"] == "man" )
	{
		$Data["user_prefix"] = $HAPPY_CONFIG['MsgUserPrefixMan1'];
	}
	else if ( $Data["user_prefix"] == "girl" )
	{
		$Data["user_prefix"] = $HAPPY_CONFIG['MsgUserPrefixGirl1'];
	}
	else
	{
		$Data["user_prefix"] = "";
	}

	$com_id_secure	= "no";
	$doc_read_env = "";



	$smsPoint = 0;

	if ( happy_member_secure($happy_member_secure_text[0].'보기 유료결제') )
	{
		#보기가능한 날짜
		$guin_docview_p = $MEM["guin_docview"] - $real_gap;

		if ($guin_docview_p > 0 )
		{
			$guin_docview_p_date = date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")+$guin_docview_p,date("Y")));
		}
		else
		{
			$guin_docview_p_date = "기간만료";
		}

		#보기가능한 회수
		$guin_docview_c = $MEM["guin_docview2"];
		#sms문자발송가능건수
		$smsPoint = ($MEM["guin_smspoint"] != "" )?$MEM["guin_smspoint"]:0;

		$Sql	= "SELECT count(*) as cnt FROM $job_com_doc_view_tb WHERE com_id='$user_id' AND doc_number='$number' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		#회수를 사용하여 볼수 있을때
		if ($Tmp["cnt"] != 0)
		{
			$com_id_secure		= "ok";
			$TPL->define("com_member_read_count",$skin_folder."/doc_read_count.html");
			$doc_read_env = $TPL->fetch("com_member_read_count");
			$상세이력서보기버튼	= "";
		}

		#기간을 사용하여 볼수 있을때
		if ( $MEM["guin_docview"] > $real_gap )
		{
			$com_id_secure		= "ok";
			#기간별 이력서를 볼수 있는 권한이 있을경우
			$TPL->define("com_member_read_period",$skin_folder."/doc_read_period.html");
			$doc_read_env = $TPL->fetch("com_member_read_period");
			$상세이력서보기버튼	= "";
		}



		#못보는 경우
		if ( $MEM["guin_docview2"] > 0 && $com_id_secure != "ok" )
		{
			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$상세이력서보기버튼	= "<a href='$main_url/document_uryo_view.php?$method[1]'>인재정보 열람하기</a>";
			} else {
				$상세이력서보기버튼	= "<a href='$main_url/document_uryo_view.php?$method[1]'><img src='img/btn_in_view.gif' align='absmiddle' border='0' alt='상세이력서보기'></a>";
			}


			#회수를 사용해서 볼수 있는 경우 ( 단 현재는 사용하지 않아서 못 보는 경우)
			$TPL->define("com_member_read_count",$skin_folder."/doc_read_count.html");
			$doc_read_env = $TPL->fetch("com_member_read_count");
		}
		else
		{
			if ($com_id_secure != "ok")
			{
				#못 보는 경우
				$TPL->define("com_member_read_not",$skin_folder."/doc_read_not.html");
				$doc_read_env = $TPL->fetch("com_member_read_not");
			}
		}

		#무료화로 이용할 경우
		if ( $CONF['guin_docview'] == "" && $CONF['guin_docview2'] == ""  )
		{
			$com_id_secure = "ok";
		}
		#무료화로 이용할 경우
	}
	else
	{
		if ($MEM["id"] != "")
		{
			#개인회원은 빈자리로 보이도록 임시 템플릿
			$TPL->define("per_member_read",$skin_folder."/doc_read_per.html");
			$doc_read_env = $TPL->fetch();
		}
		else
		{
			#로그인안한회원은 빈자리로 보이도록 임시 템플릿
			$TPL->define("per_member_read",$skin_folder."/doc_read_notmember.html");
			$doc_read_env = $TPL->fetch("per_member_read");
		}
	}
	#echo $com_id_secure;

	# 볼수있나 없나 권한을 체크하자 #
	$secure	= "no";
	if ( $com_id_secure == "ok" )
	{
		$secure		= "ok";
	}
	else if ( $_COOKIE["ad_id"] != "" )
	{
		$secure	= "ok";
		$a		= $Data["user_id"];
	}
	else if ( !happy_member_secure($happy_member_secure_text[0].'보기') )
	{
		$secure	= "no";
	}









	$returnUrl	= $_SERVER["REQUEST_URI"];
	$returnUrl	= str_replace("&","??",$returnUrl);
//echo happy_member_login_check()."====".$userid ."==". $Data["user_id"].$_COOKIE["ad_id"];
//echo var_dump(( ( happy_member_login_check() !="" && $userid == $Data["user_id"] ) || $_COOKIE["ad_id"] != "" ));

	if ( happy_member_secure($happy_member_secure_text[0].'보기') && $_COOKIE["ad_id"] == "" )
	{
		if ( !eregi($userid."," , $Data["viewList"] ) )
		{
			$Data["viewList"]	.= $userid.",";
		}

		//이력서를 등록한 회원이 로그인한 회원을 차단
		$Sql	= "SELECT Count(*) FROM $per_noViewList WHERE per_id='$Data[user_id]' AND com_id='$user_id' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		if ( $Tmp[0] != 0 )
		{
			$secure	= "no";
			error(" 프로필 열람이 불가능합니다.\\n 열람불가능한 회사로 지정되어있습니다.   ");
			exit;
		}

		#나중에 스크랩버튼 보이는 기준이 틀려지면 아래꺼 써보아요 ㅡㅡ
		#$Sql	= "SELECT Count(*) FROM $scrap_tb WHERE userid='$user_id' AND pNumber='$number' ";
		#$Tmp	= happy_mysql_fetch_array(query($Sql));

		#스크랩 버튼은 항상 보이도록 하기 위해서 아래로 내려감
		#$스크랩버튼	= "<a href='scrap.php?pNumber=$number&userType=com&mode=com&returnUrl=$returnUrl'><img src='img/btn_per_skin".$use_skin_number."_scrap.gif' border='0' alt='스크랩하기' align='absmiddle'></a>";
	}

	if ( ( happy_member_login_check() !="" && $userid == $Data["user_id"] ) || $_COOKIE["ad_id"] != "" )
	{
		//자기가 등록한 이력서는 정보공개
		$secure	= "ok";

		for ( $i=1 ; $i<8 ; $i++ )
		{
			${"수정".$i}	= "<a href='${main_url}/document.php?mode=modify&subMode=type${i}&number=$number&returnUrl=$returnUrl'><img src='${main_url}/img/btn_doc_edit.gif' border='0' align='absmiddle'></a>";
		}

		if ( $_COOKIE["ad_id"] != "" )
		{
			$옵션수정		= "
				<script>
					function guzicdel(url)
					{
						if ( confirm('정말 삭제 하시겠습니까?') )
						{
							window.location.href = url;
						}
					}
				</script>
			";
			$옵션수정		.= "<a target='_blank' href='admin/guzic_option.php?action=option&number=$number'><img src='img/btn_doc_option_edit.gif' border='0' align='absmiddle' alt='옵션수정'></a> ";
			$옵션수정		.= "<a href=\"javascript:guzicdel('guzic_del.php?number=$Data[number]')\"><img src='img/btn_doc_option_del.gif' border='0' align='absmiddle' alt='삭제'></a>";
		}
	}

	#관리자가 볼때는 조회수 올리지 말자.
	if ( $_COOKIE["ad_id"] == "" )
	{
		$Sql	= "UPDATE $per_document_tb SET viewList='$Data[viewList]' , viewListCount=viewListCount+1 WHERE number='$number'";
		query($Sql);
	}

	if ( $_GET["read"] == "N" )
	{
		$Sql	= "UPDATE $com_guin_per_tb SET read_ok='Y' WHERE pNumber='$number' AND com_id='$user_id' ";
		query($Sql);
	}

	if ( $_GET["read"] != "" )
	{
		#패치함 2009-04-14 kad
		#입사지원할 당시 공개할 정보를 제대로 불러오지 못하고 있었음
		#$Sql	= "SELECT doc_ok,cNumber FROM $com_guin_per_tb WHERE pNumber='$number' AND com_id='$user_id' ";
		$Sql	= "SELECT doc_ok,cNumber,online_stats,number FROM $com_guin_per_tb WHERE number='".$_GET['bNumber']."' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));
		//입사지원 상태 변경
		$JiWon = $Tmp;

		$guinNumber	= $Tmp["cNumber"];


		if ( $Tmp["doc_ok"] == "Y" )
		{
			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$예비합격버튼	= "<a href='member_guin.php?mode=docok_del&pNumber=$number&guinNumber=$guinNumber' class='font_22 noto400'>예비합격취소</a>";

				} else {

				$예비합격버튼	= "<a href='member_guin.php?mode=docok_del&pNumber=$number&guinNumber=$guinNumber'><img src='img/btn_no_maybe.gif' border='0' alt='예비합격취소' style='vertical-align:middle'></a>";
			}

		}
		else
		{
			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$예비합격버튼	= "<a href='member_guin.php?mode=docok&pNumber=$number&guinNumber=$guinNumber' class='font_22 noto400'>예비합격처리</a>";

				} else {

				$예비합격버튼	= "<a href='member_guin.php?mode=docok&pNumber=$number&guinNumber=$guinNumber'><img src='img/btn_ok_maybe.gif' border='0' alt='예비합격처리' style='vertical-align:middle'></a>";
			}

		}


		#패치함 2009-04-14 kad
		#입사지원할 당시 공개할 정보를 제대로 불러오지 못하고 있었음
		#$Sql	= "SELECT secure FROM $com_guin_per_tb WHERE pNumber='$number' AND com_id='$user_id' ";
		$Sql = "SELECT secure FROM $com_guin_per_tb WHERE number='".$_GET['bNumber']."' ";
		#echo $Sql;
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		$viewUserState	= $Tmp["secure"];
		//개인회원이 온라인 입사지원할 때 연락처 비공개를 하더라도,
		//기업회원이 이력서 열람하기 권한이 있으면 연락처를 볼수 있도록
		if ( $secure == "no" )
		{
			$secure			= "guinView";
		}
		$secureMsg		= "등록하신 구인에 신청된 프로필입니다.";

		$Data["fileName"]	= "";
		for ( $i=1 ; $i<=5 ; $i++ )
		{
			if ( $Data["fileName".$i] != "" )
			{
				$filename	= $Data["fileName".$i];
				$Data["fileName"]	.= ( $Data["fileName"] == "" )?"":", ";
				$Data["fileName"]	.= "<a href='fileDown.php?idx=$i&number=$number&file=".$filename."'>".$filename."</a>";
			}
		}

		$Data["fileNameValue"]	= ( $Data["fileName"] == "" )?"":$Data[fileName];
		$Data["fileNameText"]	= ( $Data["fileName"] == "" )?"":"첨부파일";
		$Data["fileName"]		= ( $Data["fileName"] == "" )?"":"<b>첨부파일</b> : $Data[fileName]";

		#첨부파일보기 버튼
		if($use_skin_number == "")
		{
			$첨부파일보기 = "<div id=\"1\" style=\"padding-left:5px;\"><img src=\"img/skin_icon/make_icon/skin_icon_222.jpg\" border=\"0\" align=\"absmiddle\" onClick=\"document.getElementById('subfile').style.display = '';\" style=\"cursor:pointer\"  alt=\"첨부파일보기\"></div>";
		}
		else
		{
			$첨부파일_JS = "";
			if ( $Data["fileName"] == '' )
			{
				$첨부파일_JS = "alert('첨부파일이 없습니다.');";
			}
			else
			{
				$첨부파일_JS = "document.getElementById('subfile').style.display = '';";
			}

			$첨부파일보기 = "<div id=\"1\" style=\"padding-left:5px;\"><img src=\"img/btn_down.png\" border=\"0\" align=\"absmiddle\" onClick=\"$첨부파일_JS\" style=\"cursor:pointer\"  alt=\"첨부파일보기\"></div>";
		}


		//온라인입사지원의 상태를 변경
		//echo "상태변경하자";
		$Data['select_stats'] = make_selectbox2(array_values($online_stats),array_keys($online_stats),'---선택---',"online_stats_".$JiWon['number'],$JiWon['online_stats'],$select_width="150");
		$Data['select_stats'] .= '<iframe id="change_online" width="400" height="100" style="display:none;"></iframe>';

		$Data['btn_change'] = '<input type="button" value="" style="background:url(img/btn_ch_ma.gif) no-repeat; height:40px; width:45px; cursor:pointer; border:0px solid red;" onclick="change_stats(\''.$JiWon['number'].'\');">';
		//온라인입사지원의 상태를 변경
		//print_r($Data);
	}
	else
	{
		if ( is_per_member($user_id) == false ) //기업회원이면
		{
			$Sql	= "SELECT * FROM $com_guin_per_tb WHERE pNumber='$number' AND com_id='$user_id' ";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			if ( $Tmp[0] == 0 )
			{
				if ( $_COOKIE['happy_mobile'] == "on" )
				{
					$입사지원요청버튼	= "<a href='document_add_guin.php?$method[1]'  class='font_22 noto400' style='margin-top:10px'>입사지원 제의하기</a>";
				}
				else
				{
					$입사지원요청버튼	= "<a href='#1' onClick=\"window.open('document_add_guin.php?$method[1]','document_add_guin','width=450,height=225,toolbar=no')\"><img src='img/btn_online_sugg.gif' align='absmiddle' border='0' alt='입사지원제의하기' style='margin-right:5px;'></a>";
				}
			}

			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$면접제의버튼	= "<a href='comeon.php?$method[1]' class='font_22 noto400' style='margin-top:10px'>면접 제의하기</a>";
			}
			else
			{
				$면접제의버튼	= "<a href='#1' onClick=\"window.open('comeon.php?$method[1]','document_comeon','width=450,height=725,toolbar=no')\"><img src='img/btn_view_sugg.gif' align='absmiddle' border='0' alt='면접제의하기' style='margin-right:5px;'></a>";
			}
		}

		if($use_skin_number == "")
		{
			$첨부파일보기 = "<img src=\"img/btn_down.png\" border=\"0\" align=\"absmiddle\" onClick=\"alert('입사지원한 이력서에 한해서 서비스가 가능합니다.');\" style=\"cursor:pointer\" alt=\"첨부파일보기\">";
		}
		else
		{
			$첨부파일보기 = "<img src=\"img/btn_down.png\" border=\"0\" align=\"absmiddle\" onClick=\"alert('입사지원한 이력서에 한해서 서비스가 가능합니다.');\" style=\"cursor:pointer\" alt=\"첨부파일보기\">";
		}

	}





	########################################
	#위에서 아래로 내려옴
	/*
	if ( $use_skin_number == "" ) {
		$use_skin_number = "_0";
	}
	*/

	if($use_skin_number == "")
	{
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$스크랩버튼	= "<a href='scrap.php?pNumber=$number&userType=com&mode=com&returnUrl=$returnUrl' class='font_22 noto400'>
				<img src='./mobile_img/scrap_ico.gif' style='vertical-align:middle; width:16px; '> 스크랩하기
			</a>";
			} else {
			$스크랩버튼	= "<a href='scrap.php?pNumber=$number&userType=com&mode=com&returnUrl=$returnUrl'><img src='img/btn_in_scrap.png' border='0' alt='스크랩하기' align='absmiddle'></a>";
		}

	}
	else
	{
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$스크랩버튼	= "<a href='scrap.php?pNumber=$number&userType=com&mode=com&returnUrl=$returnUrl' class='font_22 noto400'>
				<img src='./mobile_img/scrap_ico.gif' style='vertical-align:middle; width:16px; '> 스크랩하기</a>";
			} else {
			$스크랩버튼	= "<a href='scrap.php?pNumber=$number&userType=com&mode=com&returnUrl=$returnUrl'><img src='img/btn_in_scrap.png' border='0' alt='스크랩하기' align='absmiddle'></a>";
		}
	}

	#첨부파일보기 버튼 빈값일때 로그인 하라는 알림창
	if ( $첨부파일보기 == "" )
	{
		if($use_skin_number == "")
		{
			$첨부파일보기 = "<img src=\"img/skin_icon/make_icon/skin_icon_222.jpg\" border=\"0\" align=\"absmiddle\" onClick=\"alert('구인회원으로 로그인을 하셔야 합니다.');\" style=\"cursor:pointer\" alt=\"첨부파일보기\">";
		}
		else
		{
			$첨부파일보기 = "<img src=\"img/btn_down.png\" border=\"0\" align=\"absmiddle\" onClick=\"alert('구인회원으로 로그인을 하셔야 합니다.');\" style=\"cursor:pointer\" alt=\"첨부파일보기\">";
		}
	}

	#상세프로필보기 이미지 변경 그리고 언제나 출력되도록 변경
	if ( $상세이력서보기버튼 != "" )
	{
		$상세이력서보기버튼 = preg_replace("/img\/btn_in_view.gif/","img/btn_in_view.gif",$상세이력서보기버튼);
	}
	else
	{
		if ( $com_id_secure != "ok" )
		{
			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$상세이력서보기버튼 = "<a href='javascript:;' onclick=\"alert('업소회원용 서비스입니다.');\">인재정보 열람하기</a>";
				$상세이력서보기버튼 = "";
			} else {
				$상세이력서보기버튼 = "<a href='javascript:;' onclick=\"alert('업소회원용 서비스입니다.');\"><img src='img/btn_in_view.gif' align='absmiddle' border='0' alt='상세이력서보기' ></a>";
				$상세이력서보기버튼 = "";
			}

		}
		else
		{
			if ( $_COOKIE['happy_mobile'] == "on" )
			{
				$상세이력서보기버튼 = "<a href='javascript:;' onclick=\"alert('상세정보를 열람 가능한 상태입니다.');\">인재정보 열람중</a>";
			} else {
				$상세이력서보기버튼 = "<a href='javascript:;' onclick=\"alert('상세정보를 열람 가능한 상태입니다.');\"><img src='img/btn_in_open.gif' align='absmiddle' border='0' alt='상세이력서보기' ></a>";
			}

		}
		//$상세이력서보기버튼 = preg_replace("/.gif/",$use_skin_number.".gif",$상세이력서보기버튼);
		if($use_skin_number != "")
		{
			$상세이력서보기버튼 = preg_replace("/img\/btn_in_view.gif/","img/btn_in_view.gif",$상세이력서보기버튼);
		}
	}
	########################################

	$search_user_id			= $Data["user_id"];

	$Data["email"]	= $Data["user_email1"];
	if ( $Data["user_email2"] != "" )
	{
		$Data["email"]	.= ( $Data["email"] == "" )?$Data["user_email2"]:",".$Data["user_email2"];
	}

	if ( str_replace("http://","",strtolower($Data["user_homepage"])) == "" )
	{
		#$Data["user_homepage"]	= "<font style=font-size:11px>정보없음</font>";
		$Data["user_homepage"]	= "<span style=color:#909090; class='font_12'>".$HAPPY_CONFIG['MsgNoInputHomapage1']."</span>";
	}
	else
	{
		$Data["user_homepage"]	= "http://".str_replace("http://","",strtolower($Data["user_homepage"]));
		$Data["user_homepage"]	= ( $Data["user_homepage"] == 'http://' )?"":"<a href='$Data[user_homepage]' target='_blank'>".kstrcut($Data["user_homepage"],35,"...")."</a>";
	}

	// 이메일 입사지원시 보내는 이메일의 내용중 숨김처리
	if ($_POST['mode'] == "okletsmoveout")
	{
		if ($_POST['secure'] != "")
		{
			$viewUserState	= implode(",",$_POST['secure']);
		}
		else
		{
			$viewUserState	= "";
		}
		$secure			= "guinView";
	}

	if ( $secure == "guinView" )
	{
		if ( $CONF['guin_docview'] != "" || $CONF['guin_docview2'] != ""  )
		{
			if ( !eregi("홈페이지",$viewUserState) )
			{
				$Data["user_homepage"]	= "비공개";
			}
			if ( !eregi("전화번호",$viewUserState) )
			{
				$Data["user_phone"]		= "비공개";
			}
			if ( !eregi("핸드폰",$viewUserState) )
			{
				$Data["user_hphone"]	= "비공개";
			}
			if ( !eregi("주소",$viewUserState) )
			{
				$Data["user_zipcode"]	= "비공개";
				$Data["user_addr1"]		= "비공개";
				$Data["user_addr2"]		= "비공개";
			}
			if ( !eregi("E-mail",$viewUserState) )
			{
				$Data["user_email1"]	= "비공개";
				$Data["user_email2"]	= "비공개";
				$Data["email"]			= "비공개";
			}
		}
	}
	else if ( $secure != "ok" )
	{
		#$Data["title"]			= "열람불가";
		$Data["profile"]		= "열람불가";
		$tmp					= strlen($Data["user_id"]);
		$Data["user_id"]		= substr($Data["user_id"],0,$tmp-3) . "***";
		$Data["user_name"]		= kstrcut($Data["user_name"],2,"") . "○○";
		$Data["user_phone"]		= "열람불가";
		$Data["user_hphone"]	= "열람불가";
		$Data["user_email1"]	= "열람불가";
		$Data["user_email2"]	= "열람불가";
		$Data["user_homepage"]	= "열람불가";
		$Data["user_zipcode"]	= "열람불가";
		$Data["user_addr1"]		= "열람불가";
		$Data["user_addr2"]		= "";
		$Data["email"]			= "열람불가";

		for ( $i=1 ; $i<6 ; $i++ )
		{
			$tmp	= $Data["grade". $i ."_schoolName"];

			for ( $j=0,$max=strlen($tmp),$tmp2="" ; $j<$max ; $j++ )
				$tmp2	.= "○";

			$Data["grade". $i ."_schoolName"]	= $tmp2;
		}
	}
	else
	{
		#이력서 상세화면을 볼수 있는 회원만 쪽지를 보낼수 있다.
		$쪽지보내기 = "<img src='./img/btn_message.gif' align='absmiddle' alt='쪽지보내기' border='0' onclick=\"window.open('happy_message.php?mode=send&receiveid=".$Data["user_id"]."','happy_message_send','width=700,height=400,toolbar=no,scrollbars=no');\" style='cursor:pointer;'>";
	}

	$Data["user_email2"]	= $Data["user_email2"] == '' ? "<span style='color:#909090;' class='font_st_11'>정보없음</span>" : $Data["user_email2"];

	if($Data[etc8] != '있음')
	{
		$Data[etc9] = "소속사 없음";
	}

	# 기본 이력서 테이블 값 정리하기 #
	$Count2	= 0;
	for ( $i=1 ; $i<=5 ; $i++ )
	{
		if ( $Data["file".$i] != "" )
		{
			$Count2++;
		}
	}
	$파일수	= $Count2;

	if ( $Data["user_image"] == "" )
	{
		#$큰이미지	= $main_url."/img/noimg.gif";
		#$작은이미지	= $main_url."/img/noimg.gif";
		$큰이미지	=  $main_url."/".$HAPPY_CONFIG['IconGuzicNoImg1'];
		$작은이미지	= $main_url."/".$HAPPY_CONFIG['IconGuzicNoImg1'];
	}
	else if ( !eregi($per_document_pic,$Data["user_image"]) && strpos($Data["user_image"],$happy_member_upload_folder) === false )
	{
		if ( !preg_match("/^http/i",$Data["user_image"]) )
		{
			$큰이미지	= $main_url."/".$Data["user_image"];
			$작은이미지	= $main_url."/".$Data["user_image"];
		}
		else
		{
			$큰이미지	= $Data["user_image"];
			$작은이미지	= $Data["user_image"];
		}
	}
	else
	{
		$Tmp		= explode(".",$Data["user_image"]);
		if (preg_match("/jpg/i",$Tmp[sizeof($Tmp)-1]))
		{
			$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], "_thumb.".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
		}
		else
		{
			$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], ".".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
		}


		$큰이미지	= $main_url."/".$Data["user_image"];
		$작은이미지	= $main_url."/".$Tmp2;
	}
	$이미지정보	= $큰이미지;

	//해피이미지용
	$Happy_Img_Name[0]	= "./".$큰이미지;

	$SNS_logo_temp = $작은이미지;
	// user_image를 미니앨범이미지로 대체 ralear

/*
	$twitter						= array();

	$twitter['text']				= kstrcut(strip_tags($Data['title']), 100, '...');
	$twitter['text']				= str_replace("'","",$twitter['text']);		//트위터로 보내기... IE에서의 교차스크립트 방지의 원인이므로 .. 제거

	if ($server_character == 'euckr' || $server_character == '')
	{
		$twitter['text']				= iconv("euc-kr" , "UTF-8",$twitter['text']);
	}

	$twitter['text']				= urlencode($twitter['text']);
	$twitter['original_referer']	= urlencode("http://".$_SERVER['HTTP_HOST']."$_SERVER[REQUEST_URI]");
	$twitter['url']					= "http://".$_SERVER['HTTP_HOST'].urlencode($_SERVER[REQUEST_URI]);
	$twitter['return_to']			= "/intent/tweet?original_referer=$twitter[original_referer]&text=$twitter[text]&tw_p=tweetbutton&url=$twitter[url]";

	$tweeter_url					= "https://twitter.com/intent/tweet";
	$tweeter_url					.= "?original_referer=".$twitter['original_referer'];
	$tweeter_url					.= "&return_to=".$twitter['return_to'];
	$tweeter_url					.= "&text=".$twitter['text'];
	$tweeter_url					.= "&url=".$twitter['url'];
	$tweeter_url					= "<a href='$tweeter_url' target='_blank' onfocus='blur();'><img src='img/sns_icon/icon_twitter.png' align='absmiddle' border='0' alt='트위터로 보내기' class='png24'></a>";
	########### tweeter 를 위한 API : 2010.11.1 NeoHero ##########
*/

	$tweet_text				= htmlspecialchars(str_replace("'","",$Data['title']));
	//사진을 추출할 본문
	$tweet_img_text			= $Data['profile'];
	//상세페이지URL twrand 를 추가한것은 트위터가 캐싱을 해서
	$tweet_url				= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&twrand=".rand(1,10000);
	//작성자명
	$tweet_writer			= "";

	//클릭이벤트
	$onclicktweet			= 'sns_tweet(\''.$tweet_url.'\',\''.$tweet_text.'\');';

if($_COOKIE['happy_mobile'] == 'on'){ //모바일일때
	$tweeter_url = "<a href='javascript:void(0);' onclick=\"".$onclicktweet."\" onfocus='blur();'><img src='mobile_img/twitter_icon2.png' align='absmiddle' border='0' alt='트위터로 보내기'></a>";
	$tweeter_url .= '<script>';
	$tweeter_url .= 'function sns_tweet(url,title)';
	$tweeter_url .= '{';
	$tweeter_url .= 'popupURL = \'https://twitter.com/intent/tweet?text=\'+encodeURIComponent(title)+\'&url=\'+encodeURIComponent(url);';
	$tweeter_url .= 'popOption = "width=350, height=500, resizable=no, scrollbars=no, status=no;";';
	$tweeter_url .= 'window.open(popupURL,"pop",popOption);';
	$tweeter_url .= '}';
	$tweeter_url .= '</script>';
}else{ //pc일때
	$tweeter_url = "<a href='javascript:void(0);' onclick=\"".$onclicktweet."\" onfocus='blur();'><img src='img/sns_icon/icon_twitter.png' align='absmiddle' border='0' alt='트위터로 보내기' width='23' height='23' class='png24'></a>";
	$tweeter_url .= '<script>';
	$tweeter_url .= 'function sns_tweet(url,title)';
	$tweeter_url .= '{';
	$tweeter_url .= 'popupURL = \'https://twitter.com/intent/tweet?text=\'+encodeURIComponent(title)+\'&url=\'+encodeURIComponent(url);';
	$tweeter_url .= 'popOption = "width=350, height=500, resizable=no, scrollbars=no, status=no;";';
	$tweeter_url .= 'window.open(popupURL,"pop",popOption);';
	$tweeter_url .= '}';
	$tweeter_url .= '</script>';
}


	//사진 찾기
	$tweet_img_src				= "";

	if ( $Data['user_image'] != "" )
	{
		$tweet_img_src			= $main_url."/".$Data['user_image']."?".rand(111111,999999);
	}

	$tweeter_meta  = '<meta name="twitter:card"           content="summary_large_image">'."\n";
	$tweeter_meta .= '<meta name="twitter:site"           content="'.$site_name.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:title"          content="'.$tweet_text.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:creator"        content="'.$tweet_writer.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:image"          content="'.$tweet_img_src.'">'."\n";
	$tweeter_meta .= '<meta name="twitter:description"    content="'.kstrcut(strip_tags($tweet_img_text),100,"..").'">'."\n";
	##################### tweeter 를 위한 API : 2010.11.1 NeoHero ####################

	$meta_url	= $main_url.'/document_view.php?number='.$_GET[number];
	$default_meta	= '<meta property="og:title"		content="'.$tweet_text.'"/>'."\n";
	$default_meta	.= '<meta property="og:type"		content="website"/>'."\n";
	$default_meta	.= '<meta property="og:url"			content="'.$meta_url.'"/>'."\n";
	$default_meta	.= '<meta property="og:image"		content="'.$tweet_img_src.'"/>'."\n";
	$default_meta	.= '<meta property="og:description"	content="'.kstrcut(strip_tags($tweet_img_text),100,"..").'">'."\n";
	$default_meta	.= '<meta property="og:author"		content="'.$Data['user_name'].'"/>'."\n";



	#facebook 를 위한 API : 2012.04.30  NeoHero
	$facebook_p_url	= urlencode("$main_url/facebook_scrap.php?number=$_GET[number]&page_method=document_view");

	if($_COOKIE['happy_mobile'] == 'on'){ //모바일 일때
		$facebook_url	= "<a href='javascript:void(0);'><img src='mobile_img/facebook_icon2.png' align='absmiddle' style='cursor:pointer' onclick=\"window.open('https://www.facebook.com/sharer/sharer.php?sdk=joey&u=$facebook_p_url','facebook_scrap','width=640,height=460');\" /></a>";
	}else{ //PC 일때
		$facebook_url	= "<a href='javascript:void(0);'><img src='img/sns_icon/icon_facebook.png' align='absmiddle' style='cursor:pointer' onclick=\"window.open('https://www.facebook.com/sharer/sharer.php?sdk=joey&u=$facebook_p_url','facebook_scrap','width=640,height=460');\" /></a>";
	}

	#facebook 를 위한 API : 2012.04.30  NeoHero

	$C공감 = cyword_scrap('detail');


	#me2day 를 위한 API : 2010.11.1 NeoHero
	$me2day_text_u = "\"$main_url/document_view.php?number=$Data[number]\":$main_url/document_view.php?number=$Data[number]";
	$me2day_text_t = "$Data[title]";
	if ($server_character == 'euckr'){
		$me2day_text_u = iconv("euc-kr" , "UTF-8",$me2day_text_u);
		$me2day_text_t = iconv("euc-kr" , "UTF-8",$me2day_text_t);
	}
	$me2day_text_u = urlencode($me2day_text_u);
	$me2day_text_t = urlencode($me2day_text_t);
	$me2day_url = "<a href='http://me2day.net/posts/new?new_post[body]=$me2day_text_u&new_post[tags]=$me2day_text_t' target=_blank onfocus='blur();'><img src=img/sns_icon/icon_me2day.png align=absmiddle border=0 alt='미투데이로 보내기'></a>";
	#me2day  를 위한 API : 2010.11.1 NeoHero

	//2011-05-11 HYO end 트위터, 페이스북, 미투데이 추가







	for ( $i=0,$max=sizeof($skillArray) ; $i<$max ; $i++ )
	{
		switch ( $Data[$skillArray[$i]] )
		{
			case "3": $Data[$skillArray[$i]."_han"] = "상";break;
			case "2": $Data[$skillArray[$i]."_han"] = "중";break;
			case "1": $Data[$skillArray[$i]."_han"] = "하";break;
			default : $Data[$skillArray[$i]."_han"] = "";$Data[$skillArray[$i]] = "0";break;
		}
	}

	$Data["job_type1"]		= $TYPE[$Data["job_type1"]];
	$Data["job_type2"]		= $TYPE[$Data["job_type2"]];
	$Data["job_type3"]		= $TYPE[$Data["job_type3"]];

	$Data["job_type_sub1"]	= $TYPE_SUB[$Data["job_type_sub1"]];
	$Data["job_type_sub2"]	= $TYPE_SUB[$Data["job_type_sub2"]];
	$Data["job_type_sub3"]	= $TYPE_SUB[$Data["job_type_sub3"]];

	$Data["job_type_sub_sub1"]	= $TYPE_SUB_SUB[$Data["job_type_sub_sub1"]];
	$Data["job_type_sub_sub2"]	= $TYPE_SUB_SUB[$Data["job_type_sub_sub2"]];
	$Data["job_type_sub_sub3"]	= $TYPE_SUB_SUB[$Data["job_type_sub_sub3"]];

	// 이메일 입사지원할 때
	for ( $i=1, $Data["job_type_br"]="" ; $i<4 ; $i++ )
	{
		if ( $Data["job_type".$i] != "" )
		{
			$Data["job_type_br"]	.= ( $Data["job_type_br"] == "" )?"":"<br>";
			$Data["job_type_br"]	.= $Data["job_type".$i];
		}
	}

	for ( $i=1, $Data["job_type"]="" ; $i<4 ; $i++ )
	{
		if ( $Data["job_type_sub_sub".$i] != "" )
		{
			$Data["job_type"]	.= ( $Data["job_type"] == "" )?"":"";
			$Data["job_type"]	.= $Data["job_type".$i] ." > ".$Data["job_type_sub".$i] ." > ". $Data["job_type_sub_sub".$i];
		}
		else if ( $Data["job_type_sub".$i] != "" )
		{
			$Data["job_type"]	.= ( $Data["job_type"] == "" )?"":"";
			$Data["job_type"]	.= $Data["job_type".$i] ." > ". $Data["job_type_sub".$i];
		}
		else
		{
			$Data["job_type"]	.= ( $Data["job_type"] == "" )?"":"";
			$Data["job_type"]	.= $Data["job_type".$i] ."  ". $Data["job_type_sub".$i];
		}
	}

	#$Data["job_type"]		= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_type"];
	$Data["job_type"]		= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputType1']."</font>":$Data["job_type"];

	$Data["work_year"]		= ( $Data["work_year"] == "" )?$HAPPY_CONFIG['MsgGuzicWorkYearNo2']:sprintf("%d",$Data["work_year"])." 년";
	$Data["work_month"]		= ( $Data["work_month"] == "" )?"":sprintf("%d",$Data["work_month"])." 개월";

	$Data["profile"]		= str_replace(" ","&nbsp;",$Data["profile"]);
	$Data["profile"]		= nl2br($Data["profile"]);
	if ( $Data["profile"] == "비공개" )
	{
		$TPL->define("자기소개서", "./$skin_folder/doc_view_noview.html");
		$TPL->assign("자기소개서");
		$Data["profile"]	= $TPL->fetch("자기소개서");
	}
	else if ( $Data["profile"] == "열람불가" )
	{
		$TPL->define("자기소개서2", "./$skin_folder/doc_view_noview2.html");
		$TPL->assign("자기소개서2");
		$Data["profile"]	= $TPL->fetch("자기소개서2");
	}

	$Data["user_bohun"]		= ( $Data["user_bohun"] == "Y" )?"대상":"비대상";
	$Data["user_jangae"]	= ( $Data["user_jangae"] != "" )?"장애 ". $Data["user_jangae"]."급":"비장애";
	switch ( $Data["user_army"] )
	{
		case "Y":	$Data["user_army"] = "군필";break;
		case "N":	$Data["user_army"] = "미필";break;
		case "G":	$Data["user_army"] = "면제";break;
		case "NA":	$Data["user_army"] = "해당없음";break;
	}

	if ( $Data["user_army"] == "군필" && $Data["user_army_start"] != "" && $Data["user_army_end"] != ""  )
	{
		$Data["user_army_status"]	= $Data["user_army_start"]." 입대 ".$Data["user_army_end"]." 제대 ".$Data["user_army_type"]." ".$Data["user_army_level"];
	}
	else
	{
		$Data["user_army_status"]	= "";
	}

	#$Data["keyword"]	= ( $Data["keyword"] == "" )?"<font style=font-size:11px>정보없음</font>":$Data["keyword"];
	$Data["keyword"]	= ( $Data["keyword"] == "" )?"<font style='font-size:16px; color:#999'>".$HAPPY_CONFIG['MsgNoInputKeyword1']."</font>":$Data["keyword"];

	$Data["job_where1"]	= $siSelect[$Data["job_where1_0"]] ." ". $guSelect[$Data["job_where1_1"]];
	$Data["job_where2"]	= $siSelect[$Data["job_where2_0"]] ." ". $guSelect[$Data["job_where2_1"]];
	$Data["job_where3"]	= $siSelect[$Data["job_where3_0"]] ." ". $guSelect[$Data["job_where3_1"]];

	$Data_job_where		= array();
	array_push($Data_job_where, $Data["job_where1"]);
	array_push($Data_job_where, $Data["job_where2"]);
	array_push($Data_job_where, $Data["job_where3"]);

	for ( $i=0, $max=sizeof($Data_job_where), $Data["job_where"]="" ; $i<$max ; $i++ )
	{
		if ( str_replace(" ","",$Data_job_where[$i]) != "" )
		{
			$Data["job_where"]	.= ( $Data["job_where"] == "" )?"":", ";
			$Data["job_where"]	.= $Data_job_where[$i];
		}
	}

	#$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_where"];
	$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputArea1']."</font>":$Data["job_where"];

	#$Data["work_otherCountry"]	= ( $Data["work_otherCountry"] == "Y" )?"해외근무경력있음":"";
	$Data["work_otherCountry"]	= ( $Data["work_otherCountry"] == "Y" )?$HAPPY_CONFIG['MsgGuzicWorkYearYes2']:"";
	#기본 이력서 값정리끝 #

	//$학력리스트내용	= "";
	$schoolTemplate	= ( $schoolTemplate == "" )?"doc_view_school.html":$schoolTemplate;
	$rand	= rand(0,100000);
	$TPL->define("학력정보".$rand, "$skin_folder/$schoolTemplate");
	$subCnt	= 0;
	for ( $i=1 ; $i<=6 ; $i++ )
	{
		if ( $Data["grade${i}_schoolName"] != "" && $Data["grade${i}_schoolEnd"] != "" )
		{
			$subCnt++;
			$schoolLevel = "";
			switch($i)
			{
				case "1":	$schoolLevel = "고등학교";break;
				case "2":	$schoolLevel = "전문대학교";break;
				case "3":	$schoolLevel = "대학교";break;
				case "4":	$schoolLevel = "대학교";break;
				case "5":	$schoolLevel = "대학원";break;
				case "6":	$schoolLevel = "대학원";break;
			}

			$Data["startYear"]		= ( $Data["grade${i}_startYear"] == "" )?"":$Data["grade${i}_startYear"]."년";
			$Data["endYear"]		= ( $Data["grade${i}_endYear"] == "" )?"":$Data["grade${i}_endYear"]."년";
			$Data["endMonth"]		= ( $Data["grade${i}_endMonth"] == "" )?"":$Data["grade${i}_endMonth"]."월";
			$Data["schoolName"]		= $Data["grade${i}_schoolName"]." ".$schoolLevel;
			$Data["schoolType"]		= $Data["grade${i}_schoolType"];
			$Data["schoolEnd"]		= $Data["grade${i}_schoolEnd"];
			$Data["schoolCity"]		= ( $Data["grade${i}_schoolCity"] == "" )?"":$Data["grade${i}_schoolCity"];
			$Data["schoolPoint"]	= "";
			if ( $Data["grade${i}_point"] != "" && str_replace(" ","",$Data["grade${i}_pointBest"]) != "" )
			{
				if ( $_COOKIE['happy_mobile'] == "on" )
		{
					$Data["schoolPoint"]	= "<span>평점". $Data["grade${i}_point"] ."/ 만점 <strong>". $Data["grade${i}_pointBest"] ."</strong></span>";
				}
				else
				{
					$Data["schoolPoint"]	= "<span>평점</span> <span style='color:#ff6533; font-weight:500;'>". $Data["grade${i}_point"] ."</span> / <span>만점</span> <span style='color:#4fcebe; font-weight:500;'>". $Data["grade${i}_pointBest"] ."</span>";
				}

			}

			$TPL->parse("학력정보".$rand);
		}
	}
	//$학력리스트내용	= ( $subCnt != 0 )?$TPL->fetch("학력정보".$rand):"<span class='noto400' style='border-top:1px solid #ddd; padding:20px 0; display:block; text-align:center; font-size:15px; color:#999;'>등록된 학력정보가 없습니다.</span>";


	$rand	= rand(0,100000);
	$TPL->define("직장리스트".$rand, "$skin_folder/$workTemplate");
	//echo $workTemplate;
	$subCnt	= 0;
	if ( $workTemplate != "none" && $workTemplate != "없음" )
	{
		$Sql	= "SELECT * FROM $per_worklist_tb WHERE pNumber='$number' AND display1!='N' AND display2!='N' ";
		$Record	= query($Sql);

		$직장리스트내용	= "";
		$content	= "";
		while ( $rData = happy_mysql_fetch_array($Record) )
		{
			//print_r2($rData);
			$tempyear_end = $rData["endYear"]*12 + $rData["endMonth"];
			$tempyear_start = $rData["startYear"]*12 + $rData["startMonth"];

			$Data["work_year_diff"] = floor(($tempyear_end - $tempyear_start) / 12);
			$Data["work_month_diff"] = ($tempyear_end - $tempyear_start) % 12;
			$Data["work_year_diff"] = $Data["work_year_diff"]."년";
			$Data["work_month_diff"] = $Data["work_month_diff"]."개월";
			if ($Data["work_year_diff"] == "0년")
			{
				$Data["work_year_diff"] ="";
			}
			if ($Data["work_month_diff"] == "0개월")
			{
				$Data["work_month_diff"] ="";
			}
			if ($Data["work_year_diff"] == "" && $Data["work_month_diff"]=="")
			{
				$Data["work_year_diff"] = "1개월 미만";
			}

			$subCnt++;
			$TPL->parse("직장리스트".$rand);
		}
	}
	$직장리스트내용	= ( $subCnt != 0 )?$TPL->fetch("직장리스트".$rand):"<font style=font-size:11px>정보없음</font>";


	$rand	= rand(0,100000);
	$TPL->define("자격증리스트".$rand, "$skin_folder/$skillTemplate");
	$subCnt	= 0;
	if ( $skillTemplate != "none" && $skillTemplate != "없음" )
	{
		$Sql	= "SELECT * FROM $per_skill_tb WHERE userid='$search_user_id' ";
		$Record	= query($Sql);

		$자격증리스트내용	= "";
		$content	= "";
		while ( $rData = happy_mysql_fetch_array($Record) )
		{
			$subCnt++;
			$TPL->parse("자격증리스트".$rand);
		}
	}
	$자격증리스트내용	= ( $subCnt != 0 )?$TPL->fetch("자격증리스트".$rand):"<div style='width:100%; text-align:center; padding:15px 30px; border-top:1px solid #eaeaea; box-sizing:border-box;'><span style='color:#999; font-size:16px;'>자격증 정보없음</span></div>";

	$자격증개수		= $subCnt;


	$rand	= rand(0,100000);
	$TPL->define("언어리스트".$rand, "$skin_folder/$langTemplate");
	$subCnt	= 0;
	if ( $langTemplate != "none" && $langTemplate != "없음" )
	{
		$Sql	= "SELECT * FROM $per_language_tb WHERE userid='$search_user_id' ";
		$Record	= query($Sql);

		$토익점수	= "없음";
		$언어리스트내용	= "";
		$content	= "";
		while ( $rData = happy_mysql_fetch_array($Record) )
		{
			$subCnt++;
			switch ( $rData["language_skill"] )
			{
				case "3": $rData["language_skill_han"] = "<span>상</span>";break;
				case "2": $rData["language_skill_han"] = "<span>중</span>";break;
				case "1": $rData["language_skill_han"] = "<span>하</span>";break;
				default : $rData["language_skill_han"] = "";break;
			}

			if ( $rData['language_check'] == "TOEIC" )
			{
				$토익점수	= $rData['language_point']."점";
			}

			$TPL->parse("언어리스트".$rand);
		}
	}
	$언어리스트내용	= ( $subCnt != 0 )?$TPL->fetch("언어리스트".$rand):"<div style='width:100%; text-align:center; padding:15px 30px; box-sizing:border-box; border-top:1px solid #eaeaea;'><span style='color:#999; font-size:16px;'>어학 및 외국어 구사능력 정보없음</span></div>";


	$rand	= rand(0,100000);
	$TPL->define("연수리스트".$rand, "$skin_folder/$yunsooTemplate");
	$subCnt	= 0;
	if ( $yunsooTemplate != "none" && $yunsooTemplate != "없음" )
	{
		$Sql	= "SELECT * FROM $per_yunsoo_tb WHERE userid='$search_user_id' ";
		$Record	= query($Sql);

		$연수리스트내용	= "";
		$content	= "";
		while ( $rData = happy_mysql_fetch_array($Record) )
		{
			$subCnt++;
			$TPL->parse("연수리스트".$rand);
		}
	}
	$연수리스트내용	= ( $subCnt != 0 )?$TPL->fetch("연수리스트".$rand):"<div style='width:100%; text-align:center; padding:15px 30px; box-sizing:border-box; border-top:1px solid #eaeaea'><span style='color:#999; font-size:16px;'>등록된 해외연수 정보가 없습니다.</span></div>";

	$해외연수여부	= ( $subCnt == 0 ) ? "없음" : "있음";


	$문자전송	= "";
	if ( $smsPoint > 0 )
	{
		$Data["secure_phone"]	= secure_phone_number($Data["user_hphone"]);
		$smsTemplate	= str_replace(".html","_sms.html",$mainTemplate);

		$rand	= rand(0,10000);
		$TPL->define("문자전송폼".$rand, "$skin_folder/$smsTemplate");
		$TPL->assign("문자전송폼".$rand);
		$문자전송 = $TPL->fetch("문자전송폼".$rand);
	}

	#활동가능요일
	$TempDays = explode(" ",$Data['etc7']);
	$Data['etc7'] = '';
	$Data['etc7_text'] = '';
	$comma = "";
	foreach($TempDays as $k => $v)
	{
		$Yicon = $TDayIcons[$v];
		if ( $v != '' )
		{
			$Data['etc7'] .= '<img src="'.$Yicon.'" border="0" align="absmiddle">';
			$Data['etc7_text'] .= $comma.$TDayNames[$v];
			$comma = ","; //쉼표 필요시 주석해제
		}
	}

	if ( $Data['etc7'] == '' )
	{
		$Data['etc7'] = $HAPPY_CONFIG['MsgNoInputDay1'];
		$Data['etc7_text'] = $HAPPY_CONFIG['MsgNoInputDay1'];
	}
	#활동가능요일

	#근무시간
	if ( $Data['start_worktime'] != '' )
	{
		$TStartWorkTime = explode("-",$Data['start_worktime']);
		$Data['start_worktime'] = $TStartWorkTime[0]." ".$TStartWorkTime[1]."시".$TStartWorkTime[2];
	}
	else
	{
		$Data['start_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
	}

	if ( $Data['finish_worktime'] != '' )
	{
		$TFinishWorkTime = explode("-",$Data['finish_worktime']);
		$Data['finish_worktime'] = $TFinishWorkTime[0]." ".$TFinishWorkTime[1]."시".$TFinishWorkTime[2];
	}
	else
	{
		$Data['finish_worktime'] = $HAPPY_CONFIG['MsgNoInputWorkTime1'];
	}

	#구직자
	if ( $Data['guzicperson'] == '' )
	{
		$Data['guzicperson'] = $HAPPY_CONFIG['MsgNoInputguzicperson1'];
	}

	#학력
	if ( $Data['guziceducation'] == '' )
	{
		$Data['guziceducation'] = $HAPPY_CONFIG['MsgNoInputguziceducation1'];
	}

	#국적
	if ( $Data['guzicnational'] == '' )
	{
		$Data['guzicnational'] = $HAPPY_CONFIG['MsgNoInputguzicnational1'];
	}

	#결혼
	if ( $Data['guzicmarried'] == '' )
	{
		$Data['guzicmarried'] = $HAPPY_CONFIG['MsgNoInputguzicmarried1'];
	}

	if ( $Data['guzicchild'] == '' )
	{
		$Data['guzicchild'] = 0;
	}

	#자격증
	if ( $Data['guziclicence'] == '무' )
	{
		$Data['guziclicence_title'] = $HAPPY_CONFIG['MsgNoInputguziclicence1'];
	}
	else
	{
		if ( $Data['guziclicence_title'] == '' )
		{
			$Data['guziclicence_title'] = $HAPPY_CONFIG['MsgNoInputguziclicence1'];
		}
	}

	#파견업체
	if ( $Data['guzicsicompany'] == '' )
	{
		$Data['guzicsicompany'] = $HAPPY_CONFIG['NoInputguzicsicompany1'];
	}


	#희망연봉 없을경우 없다라는 표시
	if ($Data["grade_money"] == "") $Data["grade_money"] = "";

	$sql = "select * from $per_file_tb where doc_number = '$_GET[number]' order by number asc limit 5 ";
	$result = query($sql);
	$mini_total_num = mysql_num_rows($result);//총레코드수

	#doc_skin1.html,doc_skin3.html 파일에 적용됨.
	#디자인이 깨져서 1번 3번 스킨일 경우 하단/상단 을 다른 html 템플릿 파일을 사용하도록 코드 수정함
	#$mini_total_num = 0;
	if ($mini_total_num)
	{
		$rand	= rand(0,10000);

		if ( $mainTemplate == "doc_skin1.html" )
		{
			$TPL->define("기본정보스킨1하단".$rand, "$skin_folder/doc_skin1_basic_bottom.html");
			$TPL->assign("기본정보스킨1하단".$rand);
			$기본정보_스킨1_bottom = $TPL->fetch("기본정보스킨1하단".$rand);
		}

		if ( $mainTemplate == "doc_skin3.html" )
		{
			$TPL->define("기본정보스킨3하단".$rand, "$skin_folder/doc_skin3_basic_bottom.html");
			$TPL->assign("기본정보스킨3하단".$rand);
			$기본정보_스킨3_bottom = $TPL->fetch("기본정보스킨3하단".$rand);
		}
	}
	else
	{
		$rand	= rand(0,10000);

		if ( $mainTemplate == "doc_skin1.html" )
		{
			$TPL->define("기본정보스킨1상단".$rand, "$skin_folder/doc_skin1_basic_up.html");
			$TPL->assign("기본정보스킨1상단".$rand);
			$기본정보_스킨1_up = $TPL->fetch("기본정보스킨1상단".$rand);
		}

		if ( $mainTemplate == "doc_skin3.html" )
		{
			$TPL->define("기본정보스킨3상단".$rand, "$skin_folder/doc_skin3_basic_up.html");
			$TPL->assign("기본정보스킨3상단".$rand);
			$기본정보_스킨3_up = $TPL->fetch("기본정보스킨3상단".$rand);
		}
	}


	# 프린트 버튼
	if ( $_GET['nowPrint'] == '1' )
	{
		#$mainTemplate		= str_replace('.html','_print.html',$mainTemplate);
		$mainTemplate		= 'doc_view_main_print.html';
	}
	else
	{
		$defaultTemplate	= 'default_regist.html';
	}

	//관리자일때 네이버블로그전송내용 작성
	if ( admin_secure('슈퍼관리자전용') && is_file("$skin_folder/naver_blog_documentview.html") !== false )
	{
		$TPL->define("네이버블로그전송내용", "$skin_folder/naver_blog_documentview.html");
		$네이버블로그전송내용	= &$TPL->fetch('네이버블로그전송내용');
	}

	$Data['oa_style']		= 'display:none;';
	$Data['license_style']		= 'display:none;';
	$Data['completion_style']		= 'display:none;';
	$Data['foreign_style']		= 'display:none;';
	$Data['training_style']		= 'display:none;';
	$Data['givespecial_style']		= 'display:none;';

	if( $Data['skill_use_oa'] == 'y' )
	{
		$Data['oa_style']		= '';
	}

	if( $Data['skill_use_license'] == 'y' )
	{
		$Data['license_style']		= '';
	}

	if( $Data['skill_use_completion'] == 'y' )
	{
		$Data['completion_style']		= '';
	}

	if( $Data['skill_use_foreign'] == 'y' )
	{
		$Data['foreign_style']		= '';
	}

	if( $Data['skill_use_training'] == 'y' )
	{
		$Data['training_style']		= '';
	}

	if( $Data['skill_use_givespecial'] == 'y' )
	{
		$Data['givespecial_style']		= '';
	}

	#echo "$skin_folder/$mainTemplate";
	$TPL->define("중간껍데기", "$skin_folder/$mainTemplate");
	$TPL->parse("중간껍데기");
	$content	= &$TPL->fetch("중간껍데기");

	return $content;

}



function guin_interview_call ( $template1, $template2, $question )
{
	global $TPL, $skin_folder;
	global $질문, $내용, $질문번호, $질문수;

	$question	= nl2br($question);
	$question	= explode("<br />",$question);
	$content	= "";
	$내용		= "";
	$질문번호	= 0;


	$질문수		= 0;
	for ( $i=0,$max=sizeof($question) ; $i<$max ; $i++ )
	{
		if ( $question[$i] != "" )
		{
			$질문번호	= $i+1;
			$질문		= $question[$i];
			$rand		= rand(0,10000);

			$TPL->define("인터뷰알맹이".$rand, "$skin_folder/$template1");
			$TPL->parse("인터뷰알맹이".$rand);
			$content	= $TPL->fetch();

			$내용	.= $content;
			$질문수++;
		}
	}


	if ( $i == 0 )
	{
		return "";
	}
	else
	{
		$TPL->define("인터뷰껍데기", "$skin_folder/$template2");
		$TPL->assign("인터뷰껍데기");
		$ALL = &$TPL->fetch();

		return $ALL;
	}
}



##################################################################


$ADMIN_SECURE_HASH	= Array();
function admin_secure( $nowPage )
{
	global $adminMenuNames, $admin_id, $admin_pw, $admin_member, $admin_member;
	global $ADMIN_SECURE_HASH;

	$adminUserId	= $_COOKIE["ad_id"];
	$adminUserPwd	= $_COOKIE["ad_pass"];

	if ( $admin_id == $adminUserId && md5($admin_pw) == $adminUserPwd )
	{
		return true;
	}
	else
	{
		if($adminUserId != "" && $ADMIN_SECURE_HASH[$adminUserId] == "")
		{
			$Sql	= "SELECT * FROM $admin_member WHERE id='$adminUserId' ";
			$Data	= happy_mysql_fetch_array(query($Sql));

			$ADMIN_SECURE_HASH[$adminUserId]	= $Data;
		}
		$Data		= $ADMIN_SECURE_HASH[$adminUserId];

		for ( $i=0, $max=sizeof($adminMenuNames), $nowColum='0' ; $i<$max ; $i++ )
		{
			if ( $adminMenuNames[$i] == $nowPage )
			{
				$q	= $i+1;
				$nowColum	= "menu".$q;
				break;
			}
		}

		if ( $nowColum == '0' )
		{
			return false;
		}
		else if ( $Data[$nowColum] == "Y" )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}


function guzic_search_form()
{
	global $oaArray, $oaValArray, $prefixText, $prefixValue, $money_arr, $edu_arr, $grade_arr, $prefixText, $job_arr ;
	global $지역검색, $직종검색, $워드능력, $파워포인트능력, $엑셀능력, $정보검색능력, $희망연봉옵션, $최종학력옵션, $직급선택옵션, $성별선택옵션, $고용형태, $최종학력체크박스, $고용형태체크박스, $연령검색박스, $최종학력검색타입, $연령검색시작, $연령검색종료;
	global $TEducation,$TEducation,$학력검색;
	global $want_money_arr,$희망연봉타입;
	global $TNational,$TNational,$국적검색;
	global $per_document_tb,$대학별검색,$전공별검색,$규모별검색,$tHopeSize;
	global $직종검색모바일,$지역검색모바일;
	global $지역검색2,$직종검색2;

	$지역검색		= make_si_selectbox("guzic_si","guzic_gu","$_GET[guzic_si]","$_GET[guzic_gu]","327","327","search_frm");
	$지역검색2		= make_si_selectbox("guzic_si","guzic_gu","$_GET[guzic_si]","$_GET[guzic_gu]","275","275","search_frm");
	$지역검색모바일		= make_si_selectbox("guzic_si","guzic_gu","$_GET[guzic_si]","$_GET[guzic_gu]","100%","100%","search_frm");
	$직종검색		= make_type_selectbox('guzic_jobtype1','guzic_jobtype2',$_GET["guzic_jobtype1"],$_GET["guzic_jobtype2"],'327','327','search_frm');
	$직종검색2		= make_type_selectbox('guzic_jobtype1','guzic_jobtype2',$_GET["guzic_jobtype1"],$_GET["guzic_jobtype2"],'275','275','search_frm');
	$직종검색모바일		= make_type_selectbox('guzic_jobtype1','guzic_jobtype2',$_GET["guzic_jobtype1"],$_GET["guzic_jobtype2"],'100%','100%','search_frm');

	$워드능력		= make_radiobox2($oaArray,$oaValArray,4,guzic_word,guzic_word,$_GET["guzic_word"]);
	$파워포인트능력	= make_radiobox2($oaArray,$oaValArray,4,guzic_ppt,guzic_ppt,$_GET["guzic_ppt"]);
	$엑셀능력		= make_radiobox2($oaArray,$oaValArray,4,guzic_excel,guzic_excel,$_GET["guzic_excel"]);
	$정보검색능력	= make_radiobox2($oaArray,$oaValArray,4,guzic_internet,guzic_internet,$_GET["guzic_internet"]);

	$names	= Array("money_arr","edu_arr","grade_arr","prefixText");
	$values	= Array("money_arr","edu_arr","grade_arr","prefixValue");
	$return	= Array("희망연봉옵션","최종학력옵션","직급선택옵션","성별선택옵션");
	$vals	= Array($_GET["guzic_money"],$_GET["guzic_school"],$_GET["guzic_level"],$_GET["guzic_prefix"]);

	for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
	{
		$options	= "";
		for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
		{
			$checked	= ( $vals[$x] == ${$values[$x]}[$i] && ${$values[$x]}[$i] != "" )?"selected":"";
			$options	.= "<option value='".${$values[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>\n";
		}
		${$return[$x]}	= $options;
	}

	$최종학력체크박스	= make_checkbox2( $edu_arr, $edu_arr, 4, "guzic_school", "guzic_school", "__".@implode("__", (array) $_GET["guzic_school"])."__","__");

	$최종학력검색타입		= make_selectbox(array("이상","이하"),'---선택---',guzic_school_type,$_GET['guzic_school_type']);


	$고용형태	= "";
	for ( $i=0,$max=sizeof($job_arr) ; $i<$max ; $i++ )
	{
		if($ReData["grade_gtype"] != "")
		{
			$checked	= ( preg_match( "/".$job_arr[$i]."/i" , $ReData["grade_gtype"] ) )?"checked":"";
		}

		$고용형태 .= "<input type='checkbox' name='grade_gtype[]' value='$job_arr[$i]' $checked >$job_arr[$i] &nbsp;";
	}

	$고용형태체크박스	= make_checkbox2( $job_arr, $job_arr, 4, "job_type_read", "job_type_read", "__".@implode("__", (array) $_GET["job_type_read"])."__","__");

	$연령검색박스	= dateSelectBox( "guzic_age", 10, 99, $_GET["guzic_age"], "살", "연령선택", "" , 1);

	$연령검색시작	= "<select name='guzic_age_start' ><option value=''>연령선택</option>";
	for ( $i=20, $year=date("Y")-19 ; $i<60 ; $i++ , $year-- )
	{
		$selected		= $_GET['guzic_age_start'] == $i ? 'selected' : '';
		$연령검색시작	.= "<option value='$i' $selected >${i}세 (${year}년생)</option>";
	}
	$연령검색시작	.= "</select>";

	$연령검색종료	= "<select name='guzic_age_end' ><option value=''>연령선택</option>";
	for ( $i=20, $year=date("Y")-19 ; $i<60 ; $i++ , $year-- )
	{
		$selected		= $_GET['guzic_age_end'] == $i ? 'selected' : '';
		$연령검색종료	.= "<option value='$i'  $selected >${i}세 (${year}년생)</option>";
	}
	$연령검색종료	.= "</select>";

	#학력
	//$학력검색 = make_selectbox2($TEducation,$TEducation,"학력","guziceducation",$_GET['guziceducation'],$select_width="100");
	$학력검색 = make_selectbox2($edu_arr,$edu_arr,"학력","guziceducation",$_GET['guziceducation'],$select_width="327px");

	#희망연봉타입만 사용함
	$names	= Array("want_money_arr");
	$return	= Array("희망연봉타입");
	$vals	= Array($_GET["grade_money_type"]);

	for ( $x=0,$xMax=sizeof($names) ; $x<$xMax ; $x++ )
	{
		$options	= "<option value=''>- 전체 -</option>";

		/*
		if ( $names[$x] == 'want_money_arr' ) //희망연봉타입
		{
			${$names[$x]} = array_merge(${$names[$x]}, $money_arr);
		}
		*/

		for ( $i=0,$max=sizeof(${$names[$x]}) ; $i<$max ; $i++ )
		{
			$checked	= ( $vals[$x] == ${$names[$x]}[$i] )?"selected":"";
			$options	.= "<option value='".${$names[$x]}[$i]."' $checked >".${$names[$x]}[$i]."</option>\n";
		}
		${$return[$x]}	= $options;
	}
	#희망연봉타입만 사용함

	#국적
	$국적검색= make_radiobox2($TNational,$TNational,4,"guzicnational","guzicnational",$_GET['guzicnational']);

	#대학별검색
	$대학별검색 = "";
	//grade2_schoolName
	$sql = "select grade2_schoolName from $per_document_tb group by grade2_schoolName";
	$result = query($sql);
	while($row = happy_mysql_fetch_assoc($result))
	{
		if( $row['grade2_schoolName'] != "" )
		{
			$schoolNames[$row['grade2_schoolName']] = $row['grade2_schoolName']."대학교";
		}
	}
	//grade3_schoolName
	$sql = "select grade3_schoolName from $per_document_tb group by grade3_schoolName";
	$result = query($sql);
	while($row = happy_mysql_fetch_assoc($result))
	{
		if( $row['grade3_schoolName'] != "" )
		{
			$schoolNames[$row['grade3_schoolName']] = $row['grade3_schoolName']."대학교";
		}
	}
	//grade4_schoolName
	$sql = "select grade4_schoolName from $per_document_tb group by grade4_schoolName";
	$result = query($sql);
	while($row = happy_mysql_fetch_assoc($result))
	{
		if( $row['grade4_schoolName'] != "" )
		{
			$schoolNames[$row['grade4_schoolName']] = $row['grade4_schoolName']."대학교";
		}
	}
	/* 옵션만개 테스트
	for($i=0;$i<10000;$i++)
	{
		$schoolNames[$i] = "abc";
	}
	*/
	@$대학별검색 = make_selectbox2(array_values($schoolNames),array_keys($schoolNames),'---선택---',grade_schoolName,$_GET['grade_schoolName'],$select_width="100");

	#전공별검색
	$전공별검색 = "";
	$sql = "select grade2_schoolType from $per_document_tb group by grade2_schoolType";
	$result = query($sql);
	while($row = happy_mysql_fetch_assoc($result))
	{
		if( $row['grade2_schoolType'] != "" )
		{
			$schoolType[$row['grade2_schoolType']] = $row['grade2_schoolType'];
		}
	}
	$sql = "select grade3_schoolType from $per_document_tb group by grade3_schoolType";
	$result = query($sql);
	while($row = happy_mysql_fetch_assoc($result))
	{
		if( $row['grade3_schoolType'] != "" )
		{
			$schoolType[$row['grade3_schoolType']] = $row['grade3_schoolType'];
		}
	}
	$sql = "select grade4_schoolType from $per_document_tb group by grade4_schoolType";
	$result = query($sql);
	while($row = happy_mysql_fetch_assoc($result))
	{
		if( $row['grade4_schoolType'] != "" )
		{
			$schoolType[$row['grade4_schoolType']] = $row['grade4_schoolType'];
		}
	}
	@$전공별검색 = make_selectbox2(array_values($schoolType),array_keys($schoolType),'---선택---',grade_schoolType,$_GET['grade_schoolType'],$select_width="100");

	#규모별검색
	//print_r($tHopeSize);

	$규모별검색 = make_selectbox2($tHopeSize,$tHopeSize,'---선택---',"HopeSize",$_GET['HopeSize'],$select_width="100");

}


//카테고리 카운터시 쿼리개수 줄이기 2019-10-25 kad
$CATEGORY_STC_HASH = array();
$CATEGORY_CNT_HASH = array();
function get_category_count_array()
{
	global $guin_tb, $per_document_tb, $type_sub_tb;
	global $CATEGORY_STC_HASH;
	global $CATEGORY_CNT_HASH;


	if ( is_array($CATEGORY_CNT_HASH) && count($CATEGORY_CNT_HASH) == 0 )
	{
		$sql = "SELECT * FROM $type_sub_tb";
		$result = query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			$CATEGORY_STC_HASH[$row['number']] = array("type" => $row['type'], "type_sub_name" => $row['type_sub']);
		}

		$CATEGORY_CNT_HASH['구인']							= array();
		$CATEGORY_CNT_HASH['구인']['전체_1단계']			= array();
		$CATEGORY_CNT_HASH['구인']['전체_2단계']			= array();
		$CATEGORY_CNT_HASH['구인']['헤드헌팅_1단계']		= array();
		$CATEGORY_CNT_HASH['구인']['헤드헌팅_2단계']		= array();
		$CATEGORY_CNT_HASH['구인']['경력_1단계']			= array();
		$CATEGORY_CNT_HASH['구인']['경력_2단계']			= array();

		$CATEGORY_CNT_HASH['구직']							= array();
		$CATEGORY_CNT_HASH['구직']['전체_1단계']			= array();
		$CATEGORY_CNT_HASH['구직']['전체_2단계']			= array();


		//구인정보 필수결제 옵션적용
		$addQuery = "";
		global $ARRAY,$CONF,$real_gap;
		if ( is_array($ARRAY) && $CONF['paid_conf'] == 1 )
		{
			foreach($ARRAY as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					if ($CONF[$o_name] == '기간별')
					{
						$wait_query2 = $ARRAY[$k]." > ".$real_gap;
					}
					else
					{
						$wait_query2 = $ARRAY[$k]." > 0 ";
					}
					$addQuery.= " AND $wait_query2 ";
				}
			}
		}
		//print_r($addQuery);


		$sql_today = date("Y-m-d");

		$sql = "SELECT ";
		$sql.= "number, type1, type_sub1, type2, type_sub2, type3, type_sub3, guin_career, company_number ";
		$sql.= "FROM $guin_tb ";
		$sql.= "WHERE 1=1 ";
		$sql.= "AND (guin_end_date >= '$sql_today' or guin_choongwon ='1') ";
		$sql.= $addQuery;
		//$sql.= " ORDER BY number DESC ";
		//echo $sql."<br>";
		$result = query($sql);
		while($row = happy_mysql_fetch_assoc($result))
		{
			//전체를 읽어내서 WHERE 절을 처리하면 오히려 더 오래걸린다.
			//if ( $row['guin_end_date'] >= $sql_today || $row['guin_choongwon'] == "1" )
			//{
				$CATEGORY_CNT_HASH['구인']['전체_1단계'][$row['type1']]++;

				if ( $row['type1'] != $row['type2'] )
				{
					$CATEGORY_CNT_HASH['구인']['전체_1단계'][$row['type2']]++;
				}

				if ( $row['type1'] != $row['type3'] && $row['type2'] != $row['type3'] )
				{
					$CATEGORY_CNT_HASH['구인']['전체_1단계'][$row['type3']]++;
				}

				$CATEGORY_CNT_HASH['구인']['전체_2단계'][$row['type1']][$row['type_sub1']]++;

				if ( $row['type_sub1'] != $row['type_sub2'] )
				{
					$CATEGORY_CNT_HASH['구인']['전체_2단계'][$row['type2']][$row['type_sub2']]++;
				}

				if ( $row['type_sub1'] != $row['type_sub3'] && $row['type_sub2'] != $row['type_sub3'] )
				{
					$CATEGORY_CNT_HASH['구인']['전체_2단계'][$row['type3']][$row['type_sub3']]++;
				}


				if ( $row['company_number'] != 0 )
				{
					$CATEGORY_CNT_HASH['구인']['헤드헌팅_1단계'][$row['type1']]++;

					if ( $row['type1'] != $row['type2'] )
					{
						$CATEGORY_CNT_HASH['구인']['헤드헌팅_1단계'][$row['type2']]++;
					}

					if ( $row['type1'] != $row['type3'] && $row['type2'] != $row['type3'] )
					{
						$CATEGORY_CNT_HASH['구인']['헤드헌팅_1단계'][$row['type3']]++;
					}

					$CATEGORY_CNT_HASH['구인']['헤드헌팅_2단계'][$row['type1']][$row['type_sub1']]++;

					if ( $row['type_sub1'] != $row['type_sub2'] )
					{
						$CATEGORY_CNT_HASH['구인']['헤드헌팅_2단계'][$row['type2']][$row['type_sub2']]++;
					}

					if ( $row['type_sub1'] != $row['type_sub3'] && $row['type_sub2'] != $row['type_sub3'] )
					{
						$CATEGORY_CNT_HASH['구인']['헤드헌팅_2단계'][$row['type3']][$row['type_sub3']]++;
					}
				}

				if ( $row['guin_career'] == "경력" || $row['guin_career'] == "무관" )
				{
					$CATEGORY_CNT_HASH['구인']['경력_1단계'][$row['type1']]++;

					if ( $row['type1'] != $row['type2'] )
					{
						$CATEGORY_CNT_HASH['구인']['경력_1단계'][$row['type2']]++;
					}

					if ( $row['type1'] != $row['type3'] && $row['type2'] != $row['type3'] )
					{
						$CATEGORY_CNT_HASH['구인']['경력_1단계'][$row['type3']]++;
					}

					$CATEGORY_CNT_HASH['구인']['경력_2단계'][$row['type1']][$row['type_sub1']]++;

					if ( $row['type_sub1'] != $row['type_sub2'] )
					{
						$CATEGORY_CNT_HASH['구인']['경력_2단계'][$row['type2']][$row['type_sub2']]++;
					}

					if ( $row['type_sub1'] != $row['type_sub3'] && $row['type_sub2'] != $row['type_sub3'] )
					{
						$CATEGORY_CNT_HASH['구인']['경력_2단계'][$row['type3']][$row['type_sub3']]++;
					}
				}
			//}
		}





		//구직정보 필수결제 옵션적용
		$addQuery	= " AND display = 'Y' ";
		global $PER_ARRAY_DB,$PER_ARRAY,$CONF;
		if ( is_array($PER_ARRAY_DB) && $CONF['paid_conf'] == 1 )
		{
			foreach($PER_ARRAY_DB as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					$wait_query2 = " AND ".$PER_ARRAY[$k]." >= curdate() ";
					$addQuery .= $wait_query2;
				}
			}
		}
		//print_r($addQuery);

		$sql = "SELECT ";
		$sql.= "number, job_type1, job_type_sub1, job_type2, job_type_sub2, job_type3, job_type_sub3, display ";
		$sql.= "FROM $per_document_tb ";
		$sql.= "WHERE 1=1 ";
		$sql.= $addQuery;
		//echo $sql."<br>";
		$result = query($sql);
		while($row = happy_mysql_fetch_assoc($result))
		{
			$CATEGORY_CNT_HASH['구직']['전체_1단계'][$row['job_type1']]++;

			if ( $row['job_type1'] != $row['job_type2'] )
			{
				$CATEGORY_CNT_HASH['구직']['전체_1단계'][$row['job_type2']]++;
			}

			if ( $row['job_type1'] != $row['job_type3'] && $row['job_type2'] != $row['job_type3'] )
			{
				$CATEGORY_CNT_HASH['구직']['전체_1단계'][$row['job_type3']]++;
			}


			$CATEGORY_CNT_HASH['구직']['전체_2단계'][$row['job_type1']][$row['job_type_sub1']]++;

			if ( $row['job_type_sub1'] != $row['job_type_sub2'] )
			{
				$CATEGORY_CNT_HASH['구직']['전체_2단계'][$row['job_type2']][$row['job_type_sub2']]++;
			}

			if ( $row['job_type_sub1'] != $row['job_type_sub3'] && $row['job_type_sub2'] != $row['job_type_sub3'] )
			{
				$CATEGORY_CNT_HASH['구직']['전체_2단계'][$row['job_type3']][$row['job_type_sub3']]++;
			}
		}
	}

}



function call_category_count( $category, $depth=1 ,$ex_type,$use_headhunting="")
{

	#2007-06-06/neohero : category를 제목에서 number로 변경함 (제목의 경우 중복될 우려가 있음)
	global $type_tb, $type_sub_tb, $TYPE, $guin_tb , $per_document_tb;
	global $hunting_use;
	global $CATEGORY_STC_HASH, $CATEGORY_CNT_HASH;

	$depth	= preg_replace('/\D/', '', $depth);
	$category	= preg_replace('/\D/', '', $category);

	get_category_count_array();

	$arr_key1		= "";
	$arr_key2		= "";
	if ( $depth == 1 )
	{
		$arr_key3 = "1단계";
	}
	else if ( $depth == 2 )
	{
		$arr_key3 = "2단계";
	}

	if ($ex_type == '구인')
	{
		$arr_key1		= "구인";
		$arr_key2		= "전체";

		if ( $hunting_use == true && ( $use_headhunting == '헤드헌팅' || $_GET['hunting'] == 'y' ) )
		{
			$arr_key2		= "헤드헌팅";
		}
		else if ( $use_headhunting == '경력' )
		{
			$arr_key2		= "경력";
		}

	}
	else
	{
		$arr_key1		= "구직";
		$arr_key2		= "전체";
	}


	$cnt = 0;
	$arr_key2		= $arr_key2.'_'.$arr_key3;
	if ( $arr_key3 == "1단계" )
	{
		$cnt			= $CATEGORY_CNT_HASH[$arr_key1][$arr_key2][$category];
		//echo "[$arr_key1][$arr_key2][$category] == $cnt <br>";
	}
	else if ( $arr_key3 == "2단계" )
	{
		$category1		= $CATEGORY_STC_HASH[$category]['type'];

		$cnt			= $CATEGORY_CNT_HASH[$arr_key1][$arr_key2][$category1][$category];
		//echo "[$arr_key1][$arr_key2][$category1][$category] == $cnt <br>";
	}

	return intval($cnt);

}

/*
function call_category_count( $category, $depth=1 ,$ex_type,$use_headhunting="")
{

	#2007-06-06/neohero : category를 제목에서 number로 변경함 (제목의 경우 중복될 우려가 있음)
	global $type_tb, $type_sub_tb, $TYPE, $guin_tb , $per_document_tb;
	global $hunting_use;

	$depth	= preg_replace('/\D/', '', $depth);
	$category	= preg_replace('/\D/', '', $category);
	$table	= ( $depth == 1 )?$type_tb:$type_sub_tb;
	$field	= ( $depth == 1 )?"type":"type_sub";

	if ($ex_type == '구인')
	{
		$job_select_table = $guin_tb;
		$field2	= $field;
		$addQuery	= " and (guin_end_date >= curdate() or guin_choongwon ='1') ";

		if ( $hunting_use == true && ( $use_headhunting == '헤드헌팅' || $_GET['hunting'] == 'y' ) )
		{
			$addQuery	.= " and company_number != 0 ";
		}
		else if ( $use_headhunting == '경력' )
		{
			$addQuery	.= " and (guin_career = '경력' or guin_career = '무관') ";
		}
		else if ( $use_headhunting == '신입' )
		{
			$addQuery	.= " and (guin_career = '신입' or guin_career = '무관') ";
		}

		//구인정보 필수결제 옵션적용
		global $ARRAY,$CONF,$real_gap;
		if ( is_array($ARRAY) && $CONF['paid_conf'] == 1 )
		{
			foreach($ARRAY as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					if ($CONF[$o_name] == '기간별')
					{
						$wait_query2 = $ARRAY[$k]." > ".$real_gap;
					}
					else
					{
						$wait_query2 = $ARRAY[$k]." > 0 ";
					}
					$addQuery.= " AND $wait_query2 ";
				}
			}
		}
		//print_r($addQuery);

	}
	else
	{
		$job_select_table = $per_document_tb;
		$field2	= "job_".$field;
		$addQuery	= " AND display = 'Y' ";

		//구직정보 필수결제 옵션적용
		global $PER_ARRAY_DB,$PER_ARRAY,$CONF;
		if ( is_array($PER_ARRAY_DB) && $CONF['paid_conf'] == 1 )
		{
			foreach($PER_ARRAY_DB as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					$wait_query2 = " AND ".$PER_ARRAY[$k]." >= curdate() ";
					$addQuery .= $wait_query2;
				}
			}
		}
		//print_r($addQuery);
	}

	$Sql	= "SELECT number FROM $table WHERE number = '$category'  ";

	$Temp	= happy_mysql_fetch_array(query($Sql));

	if ( $Temp[0] != "" )
	{
		$WHERE	= "";
		for ( $i=1 ; $i<4 ; $i++ )
		{
			$WHERE	.= ( $WHERE == "" )?"":" OR ";
			$WHERE	.= " ${field2}${i} = '$Temp[0]' ";
		}

		if ($ex_type == "구직")
		{
			$WHERE	= " ( $WHERE )  and display = 'Y' ";
		}
		else
		{
			$WHERE	= " ( $WHERE ) ";
		}

		#$WHERE .= " AND ( job_type1 = '$category' OR job_type2 = '$category' OR job_type3='$category' )";

		$Sql	= "SELECT count(*) FROM $job_select_table WHERE $WHERE $addQuery";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		return  $Temp[0];
	}
	else
	{
		return 0;
	}

}
*/


//{{서브카테고리출력 가로4개,100자,구인,sub_category2.html,헤드헌팅}}
function make_category_list($ex_width,$ex_cut,$ex_type,$ex_template,$use_headhunting="")
{
	global $type_sub_tb,$type_tb,$guzic_jobtype1,$skin_folder,$SUB_CATE;
	global $hunting_use;

	$ex_width = preg_replace('/\D/', '', $ex_width);
	$ex_template = preg_replace('/\n/', '', $ex_template);
	$ex_cut = preg_replace('/\D/', '', $ex_cut);
	$ex_type = preg_replace('/\n/', '', $ex_type); #구인이냐 구직이냐

	$guzic_jobtype1		= ( $_GET["search_type"] != "" )?$_GET["search_type"]:$_GET["guzic_jobtype1"];

	if ($guzic_jobtype1)
	{
		#하부카테고리정보 읽기
		$sql = "select * from $type_sub_tb where type = '$guzic_jobtype1' order by sort_number asc, number asc  ";
		//echo $sql;
		$result = query($sql);
	}
	else
	{
		#최상단
		$sql = "select * from $type_tb order by sort_number asc  ";
		$result = query($sql);
	}

	$Add_Link = '';

	$TPL3 = new Template;
	$rand = rand(0,1111);
	$TPL3->define("New_temp222$ex_template$rand", "$skin_folder/$ex_template");
	$main_new_out = "<table border=0 cellpadding='0' cellspacing='0' style='width:100%;'>";
	$i = 1;

	while($SUB_CATE = happy_mysql_fetch_array($result))
	{
		#제목정리
		if ($guzic_jobtype1)
		{
			#하부다
			$SUB_CATE[title] = $SUB_CATE[type_sub];
			$SUB_CATE['count'] = call_category_count("$SUB_CATE[number]",'2단계',"$ex_type",$use_headhunting);

			if ($ex_type == '구인')
			{
				if ( $hunting_use == true && ( $use_headhunting == '헤드헌팅' || $_GET['hunting'] == 'y' ) )
				{
					$SUB_CATE['link'] = "html_file.php?file=guin_head.html&file2=default_guin.html&guzic_jobtype1=$SUB_CATE[type]&guzic_jobtype2=$SUB_CATE[number]&hunting=y";
				}
				else if ( $use_headhunting == '경력' )
				{
					$SUB_CATE['link'] = "html_file.php?file=guin_career.html&file2=default_guin.html&guzic_jobtype1=$SUB_CATE[type]&guzic_jobtype2=$SUB_CATE[number]";
				}
				else if ( $use_headhunting == '신입' )
				{
					$SUB_CATE['link'] = "html_file.php?file=guin_new.html&file2=default_guin.html&guzic_jobtype1=$SUB_CATE[type]&guzic_jobtype2=$SUB_CATE[number]";
				}
				else
				{
					$SUB_CATE['link'] = "guin_list.php?action=search&guzic_jobtype1=$SUB_CATE[type]&guzic_jobtype2=$SUB_CATE[number]";
				}
			}
			else
			{
				$SUB_CATE['link'] = "guzic_list.php?action=search&guzic_jobtype1=$SUB_CATE[type]&guzic_jobtype2=$SUB_CATE[number]";
			}
		}
		else
		{
			$SUB_CATE[title] = $SUB_CATE[type];
			$SUB_CATE['count'] = call_category_count("$SUB_CATE[number]",'1단계',"$ex_type",$use_headhunting);
			if ($ex_type == '구인')
			{
				if ( $hunting_use == true && ( $use_headhunting == '헤드헌팅' || $_GET['hunting'] == 'y' ) )
				{
					$SUB_CATE['link'] = "html_file.php?file=guin_head.html&file2=default_guin.html&guzic_jobtype1=$SUB_CATE[number]&hunting=y";
				}
				else if ( $use_headhunting == '경력' )
				{
					$SUB_CATE['link'] = "html_file.php?file=guin_career.html&file2=default_guin.html&guzic_jobtype1=$SUB_CATE[number]";
				}
				else if ( $use_headhunting == '신입' )
				{
					$SUB_CATE['link'] = "html_file.php?file=guin_new.html&file2=default_guin.html&guzic_jobtype1=$SUB_CATE[number]";
				}
				else
				{
					$SUB_CATE['link'] = "guin_list.php?action=search&guzic_jobtype1=$SUB_CATE[number]";
				}
			}
			else
			{
				$SUB_CATE['link'] = "guzic_list.php?action=search&guzic_jobtype1=$SUB_CATE[number]";
			}
		}


		$main_new = $TPL3->fetch("New_temp222$ex_template$rand");
		#TD를 정리하자
		if ($ex_width == "1")
		{
			$main_new = "<tr><td valign=top align=left> " . $main_new . "</td></tr>";
		}
		elseif ($i % $ex_width == "1") {
			$main_new = "<tr><td valign=top align=left> " . $main_new . "</td>";
		}
		elseif ($i % $ex_width == "0")
		{
			$main_new = "<td valign=top align=left> " . $main_new . "</td></tr>";
		}
		else
		{
			$main_new = "<td valign=top align=left> " . $main_new . "</td>";
		}
		$main_new_out .= $main_new;

		$i ++;
	}

	$main_new_out .= '</table>';

	echo $main_new_out;

}



#직종별 리스트도 자동으로 만들자 -- 작업덜됐음.
function make_category_jikjong_list($ex_width,$ex_cut,$ex_type,$ex_template,$ex_top_template,$ex_counter="카운터출력안함")
{
	global $type_sub_tb,$type_tb,$guzic_jobtype1,$skin_folder,$TPL,$SUB_CATE,$SUB_SUB_CATE;
	$ex_width = preg_replace('/\D/', '', $ex_width);
	$ex_template = preg_replace('/\n/', '', $ex_template);
	$ex_top_template = preg_replace('/\n/', '', $ex_top_template);
	$ex_cut = preg_replace('/\D/', '', $ex_cut);
	$ex_type = preg_replace('/\n/', '', $ex_type); #구인이냐 구직이냐

	$sql = "select * from $type_tb order by sort_number asc  ";
	$result = query($sql);

	$TPL->define("TOP$ex_top_template", "$skin_folder/$ex_top_template");
	$TPL->assign("TOP$ex_top_template");

	$TPL->define("New_temp$ex_top_template", "$skin_folder/$ex_template");
	$TPL->assign("New_temp$ex_top_template");

	$main_new_out = "<table width=100% border=0 cellpadding='0' cellspacing='0'>";
	$i = 1;
	while($SUB_CATE = happy_mysql_fetch_array($result))
	{
		$SUB_CATE[title] = $SUB_CATE[type];
		if ( $ex_counter == "카운터출력함" || $ex_counter == "1차카운터만출력함" )
		{
			$SUB_CATE['count'] = call_category_count("$SUB_CATE[number]",'1단계',"$ex_type");
		}

		if ($ex_type == '구인')
		{
			$SUB_CATE['link'] = "guin_list.php?guzic_jobtype1=$SUB_CATE[number]";
		}
		else
		{
			$SUB_CATE['link'] = "guzic_list.php?guzic_jobtype1=$SUB_CATE[number]";
		}
		$main_new_top = &$TPL->fetch("TOP$ex_top_template");

		#해당 서브를 구하자
		$sql2 = "select * from $type_sub_tb where type = '$SUB_CATE[number]' order by number asc  ";
		$result2 = query($sql2);
		$real_sub = '';
		while($SUB_SUB_CATE = happy_mysql_fetch_array($result2))
		{
			$SUB_SUB_CATE[title] = $SUB_SUB_CATE[type_sub];

			#제목을 잘라준다
			$SUB_SUB_CATE[title] = kstrcut($SUB_SUB_CATE[title], $ex_cut, "");

			if ( $ex_counter == "카운터출력함" )
			{
				$SUB_SUB_CATE['count'] = call_category_count("$SUB_SUB_CATE[number]",'2단계',"$ex_type");
			}

			if ($ex_type == '구인')
			{
				$SUB_SUB_CATE['link'] = "guin_list.php?guzic_jobtype1=$SUB_SUB_CATE[type]&guzic_jobtype2=$SUB_SUB_CATE[number]";
			}
			else
			{
				$SUB_SUB_CATE['link'] = "guzic_list.php?guzic_jobtype1=$SUB_SUB_CATE[type]&guzic_jobtype2=$SUB_SUB_CATE[number]";
			}

			$main_new = &$TPL->fetch("New_temp$ex_top_template");
			$real_sub .= $main_new;
		}

		#TD를 정리하자
		if ($ex_width == "1")
		{
			$main_new = "<tr><td valign=top align=left>$main_new_top " . $real_sub . "</td></tr>";
		}
		elseif ($i % $ex_width == "1")
		{
			$main_new = "<tr><td valign=top align=left>$main_new_top " . $real_sub . "</td>";
		}
		elseif ($i % $ex_width == "0")
		{
			$main_new = "<td valign=top align=left>$main_new_top " . $real_sub . "</td></tr>";
		}
		else
		{
			$main_new = "<td valign=top align=left>$main_new_top " . $real_sub . "</td>";
		}
		$main_new_out .= $main_new;

		$i ++;
	}
	$main_new_out .= '</table>';

	print $main_new_out;

}



##################################################################



// 추천키워드 개선 x2chi 2016-02-05
function pick_list($keyword , $setting, $printSize)
{
	global $CONF;

	$keys		= explode("\n",str_replace(array("\r\n","\n\r","\r"),"\n",$keyword)); // 줄바꿈을 배열로
	$keys		= array_filter($keys); // 공백 키워드 제거
	$keysCnt	= count($keys); // 키워드 개수
	$loopchk	= ( $keysCnt < $printSize )?$keysCnt:$printSize; // 키워드 출력 개수

	if ( $setting == "1" ) // 랜덤 키워드 정열
	{
		shuffle ( $keys );
	}

	array_splice($keys, $loopchk); // 키워드 출력 개수 만큼 자르기

	$pick_list	= "";
	if ( is_array($keys) )
	{
		foreach ( $keys as $var )
		{
			$pick_list	.= ( strlen( $pick_list ) > 0 ) ? "" : "";
			$pick_list	.= " <a href='all_search.php?action=search&all_keyword=".urlencode($var)."'>"."#".$var."</a> ";
		}
	}
	return $pick_list;
}


#################################################################






###############################################################



$검색된장르수	= 0;
function search_keyword_result( $cutSize, $widthSize, $heightSize, $Template1, $Template2, $dbs, $option='' )
{
	global $print_field, $check_part, $search_table, $search_field, $search_keyword, $search_orderby, $skin_folder,$search_date_field, $search_title_field, $search_where, $search_view_all_link;
	global $검색어, $검색결과리스트, $타이틀명, $제목, $날짜, $고유번호, $더많은결과링크주소,  $Data, $TPL;
	global $db,$dbname, $mainurls, $linkurl,$category,$option_array_icon,$option_array_name,$CATEGORY_TITLE;
	global $upso_si_gu,$upso_si,$car_type,$car_company,$car_category, $OPTION, $CONF, $ARRAY, $ARRAY_NAME2;
	global $신규,$인기,$추천,$특별,$쿠폰,$car_member, $siSelect, $guSelect, $큰이미지, $작은이미지;
	global $ARRAY, $document_keyword, $per_document_pic, $skillArray, $B_CONF, $board_list, $검색된장르수;
	global $이미지정보, $search_result_type;
	global $TYPE,$TYPE_SUB;
	global $user_id;
	global $doc_title_bgcolor;
	global $guin_title_bgcolor;
	global $want_money_img_arr;
	global $want_money_img_arr2;
	global $HAPPY_CONFIG;
	global $siNumber,$guNumber;
	global $happy_member_upload_folder;
	global $undergroundTitle;

	$dbs		= preg_replace('/\n/', '', $dbs);
	$cutSize	= preg_replace('/\D/', '', $cutSize);
	$widthSize	= preg_replace('/\D/', '', $widthSize);
	$heightSize	= preg_replace('/\D/', '', $heightSize);

	$linkurl	= $mainurls[$dbs];
	$no			= $check_part[$dbs];

	$keyword	= explode(" ",$_GET[$search_keyword]);
	$keywordLen	= sizeof($keyword);
	$검색어		= $_GET[$search_keyword];

	$타이틀명	= $dbs;
	if( $option != '' )
	{
		$타이틀명	= $타이틀명 . ' ' . $option;
	}

	#시/구 정보 구하기
	$siArray	= $siSelect;
	$guArray	= $guSelect;

	$title_field	= $search_title_field[$no];
	$date_field		= $search_date_field[$no];
	$number			= $search_orderby[$no];
	$selectTable	= $search_table[$no];
	$addWhere		= $search_where[$no];
	$view_all_link	= $search_view_all_link[$no];

	$fields			= explode("+",$search_field[$no]);
	$orderBy		= $search_orderby[$no];
	$limit			= $widthSize * $heightSize;


	$subQuery	= "";
	if( $dbs == '구인' )
	{
		global $ARRAY_NAME,$ARRAY,$real_gap,$guin_tb;
		for ($i = 0; $i <=16 ; $i++)
		{
			#이력서보기기간,회수별보기,SMS제외
			if ( $i >= 7 && $i <= 9 )
			{
				continue;
			}

			if ($option == $ARRAY_NAME[$i])
			{
				$check_ex = '1';
				$tmp_option = $ARRAY[$i] . "_option";
				if ($CONF[$tmp_option] == '기간별')
				{
					#무료로 사용할때는 모두 나오도록
					if ( $CONF[$ARRAY[$i]] != "" )
					{
						$WHERE_2	= "AND $ARRAY[$i] > $real_gap ";
					}
				}
				else if ( $CONF[$tmp_option] == '노출별' )
				{
					$WHERE_2	= "AND $ARRAY[$i] > '0' ";
					$subQuery	= "update $guin_tb SET $ARRAY[$i] = $ARRAY[$i]-1 WHERE number='kwak' ";
				}
				else
				{
					$WHERE_2	= "AND $ARRAY[$i] > '0' ";
				}
				break;
			}
		}

		//구인정보 필수결제 옵션적용
		global $ARRAY,$CONF,$real_gap;
		if ( is_array($ARRAY) && $CONF['paid_conf'] == 1 )
		{
			foreach($ARRAY as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					if ($CONF[$o_name] == '기간별')
					{
						$wait_query2 = $ARRAY[$k]." > ".$real_gap;
					}
					else
					{
						$wait_query2 = $ARRAY[$k]." > 0 ";
					}
					$WHERE_2.= " AND $wait_query2 ";
				}
			}
		}
		//print_r($WHERE_2);


		//채용정보 유료옵션별 검색 추가 hong
		global $ARRAY_SEARCH, $ARRAY_SEARCH_NAME;

		if ( $option != "" )
		{
			$opt_key = array_search($option,$ARRAY_SEARCH_NAME);

			if ( "$opt_key" != "" ) // key가 0일때는 인식이 안되서 따옴표 처리
			{
				$view_all_link = str_replace("action=search","action=search&search_option=".$ARRAY_SEARCH[$opt_key],$view_all_link);
			}
		}
		//채용정보 유료옵션별 검색 추가 hong
	}

	if( $dbs == '구직' )
	{
		global $PER_ARRAY_NAME;
		switch ( $option )
		{
			case "특별":			$WHERE_2 .= " AND specialDate >= curdate() ";break;
			case "스페셜":			$WHERE_2 .= " AND specialDate >= curdate() ";break;
			case "포커스":			$WHERE_2 .= " AND focusDate >= curdate() ";break;
			case "파워링크":		$WHERE_2 .= " AND powerlinkDate >= curdate() ";break;
			case "이력서스킨":		$WHERE_2 .= " AND docskinDate >= curdate() ";break;
			case "아이콘":			$WHERE_2 .= " AND iconDate >= curdate() ";break;
			case "볼드":			$WHERE_2 .= " AND bolderDate >= curdate() ";break;
			case "컬러":			$WHERE_2 .= " AND colorDate >= curdate() ";break;
			case "자유아이콘":		$WHERE_2 .= " AND freeiconDate >= curdate() AND freeicon != '' ";break;
			case "배경색":			$WHERE_2 .= " AND bgcolorDate >= curdate() ";break;
			#추가옵션 5개
			#무료일때는 쿼리 안만들도록 됨
			case $PER_ARRAY_NAME[9]:
				if ( $CONF['GuzicUryoDate1'] != '' )
				{
					$WHERE_2 .= " AND GuzicUryoDate1 >= curdate() ";
				}
				break;
			case $PER_ARRAY_NAME[10]:
				if ( $CONF['GuzicUryoDate2'] != '' )
				{
					$WHERE_2 .= " AND GuzicUryoDate2 >= curdate() ";
				}
				break;
			case $PER_ARRAY_NAME[11]:
				if ( $CONF['GuzicUryoDate3'] != '' )
				{
					$WHERE_2 .= " AND GuzicUryoDate3 >= curdate() ";
				}
				break;
			case $PER_ARRAY_NAME[12]:
				if ( $CONF['GuzicUryoDate4'] != '' )
				{
					$WHERE_2 .= " AND GuzicUryoDate4 >= curdate() ";
				}
				break;
			case $PER_ARRAY_NAME[13]:
				if ( $CONF['GuzicUryoDate5'] != '' )
				{
					$WHERE_2 .= " AND GuzicUryoDate5 >= curdate() ";
				}
				break;
		}


		//구직정보 필수결제 옵션적용
		global $PER_ARRAY_DB,$PER_ARRAY;
		if ( is_array($PER_ARRAY_DB) && $CONF['paid_conf'] == 1 )
		{
			foreach($PER_ARRAY_DB as $k => $v )
			{
				$wait_query2 = "";
				$n_name = $v."_necessary";
				$o_name = $v."_option";

				if( $CONF[$n_name] == "필수결제" )
				{
					$wait_query2 = " AND ".$PER_ARRAY[$k]." >= curdate() ";
					$WHERE_2 .= $wait_query2;
				}
			}
		}
		//print_r($WHERE_2);

	}
	$addWhere		.= $WHERE_2;

	for ( $i=0,$max=sizeof($fields),$WHERE="" ; $i<$max ; $i++ )
	{
		$WHERE	.= ( $i != 0 )?" OR ":"";
		$WHERE	.= " ". $fields[$i] ." like '%". $_GET[$search_keyword] ."%' ";
		/*
		$WHERE	.= " ( ";
		for ( $j=0 ; $j<$keywordLen ; $j++ )
		{
			$WHERE	.= ( $j != 0 )?" AND ":"";
			$WHERE	.= " ". $fields[$i] ." like '%". $keyword[$j] ."%' ";
		}
		$WHERE	.= " ) ";
		*/
	}


	if($dbs != '구인' && $dbs != '구직')		//기술지원 패치함 2012-07-17
	{
		#존재하는 게시판인가?
		$sql1 = "select * from $board_list where tbname = '$selectTable'";
		$result1 = query($sql1);
		$B_CONF = happy_mysql_fetch_array($result1);
		$add_where_query = "";

		if ($B_CONF[tbname] == "")
		{
			print "<br><font color=red>$ex_category</font>은 존재하지 않는 게시판입니다 <br>";
			return;
		}
	}

	$all_si = $siNumber["전국"];
	if ( $dbs == "구인" )
	{
		$tmp_where = " and 1=1 ";
		if ( $_GET['search_si'] != "" )
		{
			$tmp_where.= " and (( ";
			$tmp_where.= " si1 = '".intval($_GET['search_si'])."' ";
			$tmp_where.= " OR si2 = '".intval($_GET['search_si'])."' ";
			$tmp_where.= " OR si3 = '".intval($_GET['search_si'])."' ";
			$tmp_where.= " ) ";
		}

		if ( $_GET['search_gu'] != "" )
		{
			$tmp_where.= " and ( ";
			$tmp_where.= " gu1 = '".intval($_GET['search_gu'])."' ";
			$tmp_where.= " OR gu2 = '".intval($_GET['search_gu'])."' ";
			$tmp_where.= " OR gu3 = '".intval($_GET['search_gu'])."' ";
			$tmp_where.= " ) ";
		}

		if ( $_GET['search_si'] != "" )
		{
			//전국
			$tmp_where.= " OR ( ";
			$tmp_where.= " si1 = '$all_si' ";
			$tmp_where.= " OR si2 = '$all_si' ";
			$tmp_where.= " OR si3 = '$all_si' ";
			$tmp_where.= " ))";
		}
	}

	if ( $dbs == "구직" )
	{
		$tmp_where = " and 1=1 ";
		if ( $_GET['search_si'] != "" )
		{
			$tmp_where = " and (( ";
			$tmp_where.= " job_where1_0 = '".intval($_GET['search_si'])."' ";
			$tmp_where.= " OR job_where2_0 = '".intval($_GET['search_si'])."' ";
			$tmp_where.= " OR job_where3_0 = '".intval($_GET['search_si'])."' ";
			$tmp_where.= " ) ";

		}

		if ( $_GET['search_gu'] != "" )
		{
			$tmp_where.= " and ( ";
			$tmp_where.= " job_where1_1 = '".intval($_GET['search_gu'])."' ";
			$tmp_where.= " OR job_where2_1 = '".intval($_GET['search_gu'])."' ";
			$tmp_where.= " OR job_where3_1 = '".intval($_GET['search_gu'])."' ";
			$tmp_where.= " ) ";
		}

		if ( $_GET['search_si'] != "" )
		{
			//전국
			$tmp_where.= " OR ( ";
			$tmp_where.= " job_where1_0 = '$all_si' ";
			$tmp_where.= " OR job_where2_0 = '$all_si' ";
			$tmp_where.= " OR job_where3_0 = '$all_si' ";
			$tmp_where.= " )) ";
		}
	}

	$Sql	 = "	SELECT											";
	$Sql	.= "			*										";
	$Sql	.= "	FROM											";
	$Sql	.= "			$selectTable							";
	$Sql	.= "	WHERE											";
	$Sql	.= "			($WHERE)								";
	$Sql	.= "			$addWhere								";
	$Sql	.= "			$tmp_where								";
	$Sql	.= "	ORDER BY										";
	$Sql	.= "			$orderBy desc							";
	$Sql	.= "	LIMIT											";
	$Sql	.= "			0,$limit								";
//echo $Sql."<br>";
	$Record	= query($Sql);

	$rand = rand(1,99999);
	$TPL->define("검색결과리스트 $dbs $rand", "$skin_folder/$Template2");

	$content	= "<table align='center' width='100%' border='0'>\n<tr>\n";
	$Count		= 0;
	$tdWidth	= 100 / $widthSize;
	while ( $Data = happy_mysql_fetch_array($Record) )
	{
		$Count++;
		$today = date("Y-m-d");

		$제목		= kstrcut($Data[$title_field], $cutSize, "...");
		$날짜		= substr($Data[$date_field],0,10);
		$고유번호	= $Data[$number];

		##########################################################
		if ( $dbs == "구인" )
		{
			if ( $subQuery != "" )
			{
				$Sql2	= str_replace("kwak",$Data["number"],$subQuery);
				query($Sql2);
			}

			$j ='0'; #type
			$this_bold = "";
			$Data[icon] = "";

			foreach ($ARRAY as $list)
			{
				$list_option = $list . "_option";

				if ($CONF[$list_option] == '기간별')
				{
					$Data[$list] = $Data[$list] - $real_gap; #날짜가 마이너스인 사람은 광고가 끝인사람임
				}

				if ($Data[$list] > 0 && $j != '3')
				{
					#볼드는 아이콘을 안보여준다
					$Data[icon] .= "<img src=$ARRAY_NAME2[$j] border=0 align=absmiddle>&nbsp;";
				}

				if ($Data[$list] > 0 && $j == '3')
				{
					$this_bold = "1";
				}
				$j++;
			}

			#bgcolor 옵션
			$Data['bgcolor1'] = "";
			$Data['bgcolor2'] = "";
			$list = $ARRAY[10];
			$list_option = $list . "_option";

			if ($CONF[$list_option] == '기간별')
			{
				#$NEW[$list] = $NEW[$list] - $real_gap;		#위에서 미리 빼므로 주석
				#echo $NEW[$list]."<br>";
				if ( $Data[$list] > 0 )
				{
					if($Data['guin_bgcolor_select'] == '')
					{
						$Data['guin_bgcolor_select'] = $guin_title_bgcolor;
					}
					$Data['bgcolor1'] = "<span style='padding:2px; display:inline; background:$Data[guin_bgcolor_select];'>";
					$Data['bgcolor2'] = "</span>";
				}
			}
			#bgcolor 옵션

			#아이콘옵션
			$Data['freeicon_com_out'] = "";
			$list = $ARRAY[11];
			$list_option = $list . "_option";

			if ($CONF[$list_option] == '기간별')
			{
				#$NEW[$list] = $NEW[$list] - $real_gap;		#위에서 미리 빼므로 주석
				if ( $Data[$list] > 0 && $Data['freeicon_com'] != "")
				{
					$Data['freeicon_com_out'] = '<img src="img/'.$Data['freeicon_com'].'" align=absmiddle>';
				}
			}
			#아이콘옵션

			// 급여조건(세전/세후)
			$Data['pay_type_txt'] = ( $Data['pay_type'] == 'gross' ) ? '세전' : '세후';

			$Data["guin_pay_icon"]	= $want_money_img_arr[$Data['guin_pay_type']];
			$Data["guin_pay_icon2"]	= $want_money_img_arr2[$Data['guin_pay_type']];

			$Data["scrapdate"]	= explode(" ",$Data["scrapdate"]);

			#경력 여부
			if ( $Data[guin_career] == "경력" )
			{
				$Data[guin_career] = "경력 $Data[guin_career_year]↑";
			}
			elseif ( $Data[guin_career] == "무관" )
			{
				$Data[guin_career] = "경력 무관";
			}
			if ( $Data[guin_choongwon] )
			{
				$Data[guin_end_date] = "~ 상시채용";
			}
			else
			{
				$Data[guin_end_date] = "$Data[guin_end_date]";
			}

			if ( $Data[guin_choongwon] )
			{
				$Data[guin_choongwon] = "충원시";
			}
			else
			{
				$Data[guin_choongwon] = "$Data[guin_end_date]명";
			}


			/////////////////날짜 자르고 비교하기
			$Data["guin_date_cut"]	= substr($Data["guin_date"],0,10);
			$Data[guin_date] = explode(" ",$Data[guin_date]);
			$today = date("Y-m-d");

			if ( $Data[guin_date][0] == $today )
			{
				#$Data[new_icon] = "<img src='bbs_img/icon_new.gif' align=absmiddle>&nbsp; ";
				$Data[new_icon] = "<img src='".$HAPPY_CONFIG['IconGuinNew1']."' align=absmiddle>";
			}
			else
			{
				$Data[new_icon] = "";
			}

			$Data[title] = kstrcut($Data[guin_title], $cutSize, "..."); #type

			if ($this_bold)
			{
				$Data[title] = "<font color=red><b>$Data[title]</b></font>";
			}

			#검색은 회사명을 자르지 말자
			#$Data[name] = kstrcut($Data[guin_com_name], 10, "...");
			$Data[name] = $Data[guin_com_name];

			#업체로고구하기
			$Tmem = happy_member_information($Data['guin_id']);
			//$bns_img = $Tmem['photo2'];
			//$bnl_img = $Tmem['photo3'];

			//개별 채용정보에 저장된 이미지를 사용하기 위해서 DB 컨버팅함
			$bns_img = $Data['photo2'];
			$bnl_img = $Data['photo3'];
			$Data['com_name'] = $Tmem['com_name'];


			if ( $bnl_img == "" )
			{
				#$Data[logo] = "./img/logo_img.gif";
				$Data[logo] = "./".$HAPPY_CONFIG['IconComNoLogo1']."";
			}
			else
			{
				$Data[logo] = "./$bnl_img";
			}

			if ( $bns_img == "" )
			{
				#$Data[com_logo] = "./img/logo_img.gif";
				$Data[com_logo] = "./".$HAPPY_CONFIG['IconComNoBanner1']."";
			}
			else
			{
				$Data[com_logo] = "./$bns_img";
			}
			#지역
			$Data["si1"]		= $siSelect[$Data["si1"]];
			$Data["gu1"]		= $guSelect[$Data["gu1"]];
			$Data["si2"]		= $siSelect[$Data["si2"]];
			$Data["gu2"]		= $guSelect[$Data["gu2"]];
			$Data["si3"]		= $siSelect[$Data["si3"]];
			$Data["gu3"]		= $guSelect[$Data["gu3"]];

			#역세권
			$Data['underground1']	= ( $Data['underground1'] == 0 )? $HAPPY_CONFIG['MsgNoInputUnderground1'] :$undergroundTitle[$Data['underground1']];
			$Data['underground2']	= $undergroundTitle[$Data['underground2']];

			#채용분야
			$Data[type]	= '';
			$Data[type_short]	= '';
			if ($Data[type1])
			{
				$TYPE_SUB{$Data[type_sub1]}	= ( $TYPE_SUB{$Data[type_sub1]} == '' )?"":$TYPE_SUB{$Data[type_sub1]};
				$Data[type]	.= $Data[type] == '' ? '' : ', ';
				$Data[type]	.= "".$TYPE{$Data[type1]} ;
				$Data[type]	.= $Data[type] != '' && $TYPE_SUB{$Data[type_sub1]} != '' ? "-" . $TYPE_SUB{$Data[type_sub1]} : '';

				$Data[type_short]	.= $Data[type_short] == '' ? '' : ', ';
				$Data[type_short]	.= "".$TYPE{$Data[type1]} ;
			}
			if ($Data[type2])
			{
				$TYPE_SUB{$Data[type_sub2]}	= ( $TYPE_SUB{$Data[type_sub2]} == '' )?"":$TYPE_SUB{$Data[type_sub2]};
				$Data[type]	.= $NEW[type] == '' ? '' : ', ';
				$Data[type]	.= "".$TYPE{$Data[type2]} ;
				$Data[type]	.= $Data[type] != '' && $TYPE_SUB{$Data[type_sub2]} != '' ? "-" . $TYPE_SUB{$Data[type_sub2]} : '';

				$Data[type_short]	.= $Data[type_short] == '' ? '' : ', ';
				$Data[type_short]	.= "".$TYPE{$Data[type2]} ;
			}
			if ($Data[type3])
			{
				$TYPE_SUB{$Data[type_sub3]}	= ( $TYPE_SUB{$Data[type_sub3]} == '' )?"":$TYPE_SUB{$Data[type_sub3]};
				$Data[type]	.= $Data[type] == '' ? '' : ', ';
				$Data[type]	.= "".$TYPE{$Data[type3]} ;
				$Data[type]	.= $Data[type] != '' && $TYPE_SUB{$Data[type_sub3]} != '' ? "-" . $TYPE_SUB{$Data[type_sub3]} : '';

				$Data[type_short]	.= $Data[type_short] == '' ? '' : ', ';
				$Data[type_short]	.= "".$TYPE{$Data[type3]} ;
			}


		}
		##########################################################
		else if ( $dbs == "구직" )
		{
			$OPTION["user_photo"]	= "";

			if ( $Data["user_image"] == "" )
			{
				#$큰이미지	= "img/noimg.gif";
				#$작은이미지	= "img/noimg.gif";
				$큰이미지	= $HAPPY_CONFIG['IconGuzicNoImg1'];
				$작은이미지	= $HAPPY_CONFIG['IconGuzicNoImg1'];
			}
			else if ( !eregi($per_document_pic,$Data["user_image"]) && strpos($Data["user_image"],$happy_member_upload_folder) === false )
			{
				$큰이미지	= $Data["user_image"];
				$작은이미지	= $Data["user_image"];
			}
			else
			{
				$Tmp		= explode(".",$Data["user_image"]);
				if (preg_match("/jpg/i",$Tmp[sizeof($Tmp)-1]))
				{
					$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], "_thumb.".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
				}
				else
				{
					$Tmp2	= str_replace(".".$Tmp[sizeof($Tmp)-1], ".".$Tmp[sizeof($Tmp)-1], $Data["user_image"]);
				}
				$큰이미지	= $Data["user_image"];
				$작은이미지	= $Tmp2;
				#$OPTION["user_photo"]	= "<img src='img/photo_user.gif' alt='사진있음'>";
				$OPTION["user_photo"]	= "<img src='".$HAPPY_CONFIG['IconGuzicPhoto1']."' alt='사진있음' align='absmiddle'>";
			}

			$이미지정보	= $작은이미지;
			$Data["user_name_cut"]	= kstrcut($Data["user_name"],2,"") . "○○";

			for ( $i=0,$max=sizeof($skillArray) ; $i<$max ; $i++ )
			{
				switch ( $Data[$skillArray[$i]] )
				{
					case "3": $Data[$skillArray[$i]."_han"] = "상";break;
					case "2": $Data[$skillArray[$i]."_han"] = "중";break;
					case "1": $Data[$skillArray[$i]."_han"] = "하";break;
					default : $Data[$skillArray[$i]."_han"] = "";$Data[$skillArray[$i]] = "0";break;
				}
			}

			$nowDate				= date("Y-m-d");

			$Data["freeicon"]		= ( $Data["freeicon"] == "" )?"freeicon_default.gif":$Data["freeicon"];
			#스페셜
			#$OPTION["special"]		= ( $Data["specialDate"] >= $nowDate )?"<img src='img/icon_spec.gif'>":"";
			$OPTION["special"]		= ( $Data["specialDate"] >= $nowDate )?"<img src='".$HAPPY_CONFIG['IconGuzicSpec1']."'>":"";
			#포커스
			#$OPTION["focus"]		= ( $Data["focusDate"] >= $nowDate )?"<img src='img/icon_focus.gif'>":"";
			$OPTION["focus"]		= ( $Data["focusDate"] >= $nowDate )?"<img src='".$HAPPY_CONFIG['IconGuzicFocus1']."'>":"";
			#파워링크
			$OPTION["powerlink"]	= ( $Data["powerlinkDate"] >= $nowDate )?"<img src='".$HAPPY_CONFIG['IconGuzicPowerLink1']."'>":"";
			#아이콘
			$OPTION["icon"]			= ( $Data["iconDate"] >= $nowDate )?"<img src='".$HAPPY_CONFIG['IconGuzicIcon2']."'>":"";
			#볼드
			$OPTION["bolder"]		= ( $Data["bolderDate"] >= $nowDate )?"<b>":"";
			#컬러
			$OPTION["color"]		= ( $Data["colorDate"] >= $nowDate )?"<font color='$doc_title_color'>":"";
			#자유아이콘
			$OPTION["freeicon"]		= ( $Data["freeiconDate"] >= $nowDate )?"<img src='img/$Data[freeicon]'>":"";
			#배경색추가
			$OPTION["bgcolor1"]		= ( $Data["bgcolorDate"] >= $nowDate )?"<span style='padding:2px;background:$doc_title_bgcolor;'>":"";
			$OPTION["bgcolor2"]		= ( $Data["bgcolorDate"] >= $nowDate )?"</span>":"";

			#$Data["title_cut"]		= ( $Data["title"] == "" )?"[설정된 제목이 없습니다.]":kstrcut($Data["title"], $cutSize, "...");
			$Data["title_cut"]		= ( $Data["title"] == "" )?$HAPPY_CONFIG['MsgGuzicNoTitle1']:kstrcut($Data["title"], $cutSize, "...");

			$Data["Job_type1_original"]	= $Data["Job_type1"];
			$Data["Job_type2_original"]	= $Data["Job_type2"];
			$Data["Job_type3_original"]	= $Data["Job_type3"];

			$Data["job_type1_top"]		= $TYPE_SUB_NUMBER[$Data["job_type1"]];
			$Data["job_type2_top"]		= $TYPE_SUB_NUMBER[$Data["job_type2"]];
			$Data["job_type3_top"]		= $TYPE_SUB_NUMBER[$Data["job_type3"]];

			#$Data["work_year_search"]	= ( $Data["work_year"] == 0 )?"신입":"경력";
			$Data["work_year_search"]	= ( $Data["work_year"] == 0 )?$HAPPY_CONFIG['MsgGuzicWorkYearNo1']:$HAPPY_CONFIG['MsgGuzicWorkYearYes1'];

			if ( $Data["user_prefix"] == "man" )
			{
				#$Data["user_prefix"] = "남";
				$Data["user_prefix"] = $HAPPY_CONFIG['MsgUserPrefixMan1'];
			}
			else if ( $Data["user_prefix"] == "girl" )
			{
				#$Data["user_prefix"] = "여";
				$Data["user_prefix"] = $HAPPY_CONFIG['MsgUserPrefixGirl1'];
			}
			else
			{
				$Data["user_prefix"] = "";
			}

			#$Data["work_year"]		= ( $Data["work_year"] == "" )?"경력없음":$Data["work_year"]."년";
			#$Data["work_month"]		= ( $Data["work_month"] == "" )?"":$Data["work_month"]."개월";
			$Data["work_year"]		= ( $Data["work_year"] == "" )?$HAPPY_CONFIG['MsgGuzicWorkYearNo2']:sprintf("%d",$Data["work_year"])." 년";
			$Data["work_month"]		= ( $Data["work_month"] == "" )?"":sprintf("%d",$Data["work_month"])." 개월";

			#$Data["grade_money"]	= ( $Data["grade_money"] != "면접후결정" )?$Data["grade_money"]."만원":$Data["grade_money"];


			/* 희망분야 패치함 kad
			2009-04-06 상관없는 키워드를 불러오고 있었음
			$Data["job_type1"]	= $document_keyword[$Data["job_type1"]];
			$Data["job_type2"]	= $document_keyword[$Data["job_type2"]];
			$Data["job_type3"]	= $document_keyword[$Data["job_type3"]];
			*/
			$Data["job_type1"]	= $TYPE[$Data["job_type1"]];
			$Data["job_type2"]	= $TYPE[$Data["job_type2"]];
			$Data["job_type3"]	= $TYPE[$Data["job_type3"]];

			$Data["job_type_sub1"] = $TYPE_SUB[$Data["job_type_sub1"]];
			$Data["job_type_sub2"] = $TYPE_SUB[$Data["job_type_sub2"]];
			$Data["job_type_sub3"] = $TYPE_SUB[$Data["job_type_sub3"]];

			$Data_job_type		= array();
			array_push($Data_job_type, $Data["job_type1"]);
			array_push($Data_job_type, $Data["job_type2"]);
			array_push($Data_job_type, $Data["job_type3"]);

			$Data_job_sub_type = array();
			array_push($Data_job_sub_type, $Data["job_type_sub1"]);
			array_push($Data_job_sub_type, $Data["job_type_sub2"]);
			array_push($Data_job_sub_type, $Data["job_type_sub3"]);

			for ( $i=0, $max=sizeof($Data_job_type), $Data["job_type"]="" ; $i<$max ; $i++ )
			{
				if ( $Data_job_type[$i] != "" )
				{
					$Data["job_type"]	.= ( $Data["job_type"] == "" )?"":",";
					#$Data["job_type"]	.= $Data_job_type[$i]." ".$Data_job_sub_type[$i];		#희망분야 2단계까지 출력하려고 하면 써야 함
					$Data["job_type"]	.= $Data_job_type[$i];
				}
			}

			#$Data["job_type"]	= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_type"];
			$Data["job_type"]		= ( trim($Data["job_type"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputType1']."</font>":$Data["job_type"];

			$Data["job_where1"]	= $siSelect[$Data["job_where1_0"]] ." ". $guSelect[$Data["job_where1_1"]];
			$Data["job_where2"]	= $siSelect[$Data["job_where2_0"]] ." ". $guSelect[$Data["job_where2_1"]];
			$Data["job_where3"]	= $siSelect[$Data["job_where3_0"]] ." ". $guSelect[$Data["job_where3_1"]];

			$Data_job_where		= array();
			array_push($Data_job_where, $Data["job_where1"]);
			array_push($Data_job_where, $Data["job_where2"]);
			array_push($Data_job_where, $Data["job_where3"]);

			for ( $i=0, $max=sizeof($Data_job_where), $Data["job_where"]="" ; $i<$max ; $i++ )
			{
				if ( str_replace(" ","",$Data_job_where[$i]) != "" )
				{
					$Data["job_where"]	= ( $Data["job_where"] == "" )?"":",";
					$Data["job_where"]	= $Data_job_where[$i];
				}
			}

			#$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"<font style=font-size:11px>정보없음</font>":$Data["job_where"];
			$Data["job_where"]	= ( trim($Data["job_where"]) == "" )?"<font style=font-size:11px>".$HAPPY_CONFIG['MsgNoInputArea1']."</font>":$Data["job_where"];

			$Data["regdate_cut"]		= substr($Data["regdate"],0,10);
			$Data["modifydate_cut"]		= substr($Data["modifydate"],0,10);
			$Data["keyword_cut"]		= ( $Data["keyword"] == "" )?"":kstrcut($Data["keyword"], $cutSize*2, "...");

			#$Data["work_otherCountry"]	= ( $Data["work_otherCountry"] == "Y" )?"해외근무경력있음":"";
			$Data["work_otherCountry"]	= ( $Data["work_otherCountry"] == "Y" )?$HAPPY_CONFIG['MsgGuzicWorkYearYes2']:"";

			if ( $Data["bNumber"] != "" )
			{
				$Data["interview"]	= str_replace("\r","",$Data["interview"]);
				$interview			= explode("\n",$Data["interview"]);

				$Data["interview"]	= "";
				for ( $i=1,$max=sizeof($interview) ; $i<=$max ; $i++ )
				{
					if ( $interview[$i-1] != "" )
					{
						$Data["interview"]	.= "답변$i : ".$interview[$i-1]."<br>";
					}
				}

				$Data["read"]			= $Data["read_ok"];
				$Data["read_ok"]		= ( $Data["read_ok"] == "Y" )?"":"미열람";
				$Data["doc_ok"]			= ( $Data["doc_ok"] == "Y" )?"예비합격자":"";
				$Data["bregdate_cut"]	= substr($Data["bregdate"],0,10);
			}

			#비공개 해야 할것들 ..
			if ( happy_member_secure($happy_member_secure_text[0].'보기') && $user_id != $Data["user_id"] && !admin_secure("구인리스트"))
			{
				$tmp					= strlen($Data["user_id"]);
				$Data["user_id"]		= substr($Data["user_id"],0,$tmp-3) . "***";
			}

			if ( $guzic_keyword != "" )
			{
				$Data["title_cut"]		= str_replace($guzic_keyword, "<font color='${doc_search_color}'>$guzic_keyword</font>", $Data["title_cut"]);
			}

			$Data["doc_ok"]	= ( $Data["doc_ok"] == "" )?"미합격":$Data["doc_ok"];

		}
		##########################################################

		#if ( $dbs=="공지사항" || $dbs=="구인구직뉴스" || $dbs=="행사/이벤트" || $dbs=="자주묻는질문" || $dbs=="모델가이드" || $dbs=="포토갤러리" || $dbs=="모델인터뷰" )
		else if ( in_array($dbs, $check_part) )
		{
			#파일...
			if ( $Data[bbs_etc1] != "" )
			{
				#$Data[attach] = "<img src='bbs_img/data.gif' align=absmiddle border=0>";
				$Data[attach] = "<img src='".$HAPPY_CONFIG['IconData1']."' align=absmiddle border=0>";
			}
			else
			{
				$Data[attach] = "<img src='".$HAPPY_CONFIG['IconData2']."' align=absmiddle border=0>";
			}

			#new 아이콘
			list($Data[bbs_date],$Data[bbs_time]) = explode(" ",$Data[bbs_date]);
			$today = date("Y-m-d");

			$gap_day = (strtotime($today)-strtotime($Data[bbs_date]))/(60*60*24);

			if ( $gap_day <= $Data_new_cut )
			{
				$Data[bbs_date] = "<font color=red>$Data[bbs_date]</font>";
				#$new_icon = "<img src='bbs_img/icon_new.gif' align=absmiddle>&nbsp; ";
				$new_icon = "<img src='".$HAPPY_CONFIG['IconGuinNew1']."' align=absmiddle>";
			}
			else
			{
				$new_icon = "";
			}

			#자동툴팁
			if (eregi('.jp', $Data[bbs_etc1]) || eregi('.gif', $Data[bbs_etc1]) )
			{
				if ($Data[bbs_etc6])
				{
					$main_img_temp = "./data/$B_CONF[tbname]/$Data[bbs_etc6]";
				}
				else
				{
					$main_img_temp = "./data/$B_CONF[tbname]/$Data[bbs_etc1]";
				}

				$Data[tool_tip] = " onMouseover=\"ddrivetip('<IMG src=\'$main_img_temp\' border=0 width=200>','white', 200)\"; onMouseout=\"hideddrivetip()\"";
				$Data['img'] = $Data[thumb] = "$main_img_temp";
				$Data[img_width] = $imagehw[0];
				$Data[img_height] = $imagehw[1];
			}
			else
			{
				$Data[tool_tip] = "";
				#$Data[thumb] = "img/no_photo.gif";
				$Data[thumb] = $HAPPY_CONFIG['ImgNoImage1'];
			}

			#추출시 첨부에서 이미지가 없을때 src="/wys2/file_attach/2008/05/20/1211276747-39.jpg"
			if ($Data['img']=='')
			{
				preg_match("/<img(.*?)src=\"(.*?)\"/i",$Data[bbs_review],$matches);

				if (preg_match("/\.jpg|\.jpeg|\.png|\.gif/i",$matches[2] ,$matchess ))
				{
					$matches2tmp	= $matches[2];
					$matches[2]		= str_replace("/file_attach/","/file_attach_thumb/",$matches[2]);
					if ( !is_file($matches[2]) )
					{
						$matches[2] = $matches2tmp;
					}
					$Data[tool_tip] = " onMouseover=\"ddrivetip('<IMG src=\'$matches[2]\' border=0 width=200>','white', 200)\"; onMouseout=\"hideddrivetip()\"";
					$Data[thumb] = $matches[2];
					$Data['img']		= "<img src='$matches[2]' align='absmiddle' border='0' width='$img_width' height='$img_height'>";
				}
				else
				{
					$Data[tool_tip] = "";
					$Data[thumb] = "img/no_photo.gif";
					$Data[thumb] = $HAPPY_CONFIG['ImgNoImage1'];
				}
			}

			#답변글 안으로 밀기
			$re = "";
			if($Data[depth]>0)
			{
				for($k=0; $k<$Data[depth]; $k++)
				{
					$re .= "&nbsp;&nbsp;&nbsp;"; //$re. 을 해줘야지 다시 반복된다
				}
				$re .= "<img src='".$HAPPY_CONFIG['IconReply1']."' border=0>&nbsp;";
			}

			#제목을 잘라준다
			$ex_cut_new = $ex_cut - ($k * 4);
			$Data[bbs_title] = kstrcut($Data[bbs_title], $cutSize, "...");
			//덩달아 내용도 잘라주자
			$Data[bbs_review]= strip_tags($Data[bbs_review]);
			$Data[bbs_review] = kstrcut($Data[bbs_review], $cutSize*3, "...");

			if ($Data[bbs_etc2] > 0)
			{
				$Data[댓글] = "[$Data[bbs_etc2]]";
			}
			else
			{
				$Data[댓글] = "";
			}

			if (!($Data[bbs_etc4]))
			{
				$Data[bbs_etc4] = "0";
			}

			$Data[bbs_title_none] = "$re $Data[bbs_title] $new_icon";
			$Data[bbs_title] = "$re<a href='./bbs_detail.php?bbs_num=$Data[number]&tb=$B_CONF[tbname]&id=$_GET[id]&pg=$pg'><font color=$Data_title_color>$Data[bbs_title]</font></a> $new_icon";
			$k = "";
		}
		##########################################################

		$search_temps	= &$TPL->fetch("검색결과리스트 $dbs $rand");

		$content		.= "<td width='$tdWidth%' valign='top' class='type'>\n";
		$content		.= $search_temps;
		$content		.= "</td>\n";

		if ( $Count % $widthSize == 0 )
		{
			$content .= "</tr>\n<tr>\n";
		}
	}

	if ( $Count % $widthSize != 0 )
	{
		for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
		{
			$content	.= "<td width='$tdWidth%'>&nbsp;</td>\n";
		}
		//$content	.= "</tr><tr><td colspan='$widthSize' background=img/img_dot.gif height=1></td>";
	}
	$content	.= "</tr>\n";
	$content	.= "</table>";

	if ( $Count == 0 && $search_result_type != '1' )
	{
		$search_result	= "";
	}
	else
	{
		if ( $Count == 0 )
		{
			$content	= "<table width='100%' height='100' ><tr><td align='center'><div style='background:rgba(0,0,0,0.4); border-radius:5px; text-align:center;'><p class='font_16 noto400' style='color:#fff; padding:15px;'>검색된 결과가 없습니다.</p></div></td></tr></table>";
		}
		$검색된장르수++;

		$검색결과리스트			= $content;
		$더많은결과링크주소		= $view_all_link . urlencode($_GET[$search_keyword]);

		$TPL->define("결과껍데기 $rand", "$skin_folder/$Template1");
		$search_result	= &$TPL->fetch("결과껍데기 $rand");
	}

	return print $search_result;

}



#################################################################




	function keyword_rank_read($rankPrintSize , $keyword_template1 , $keyword_template2, $checkField="",$returnType="")
	{
		global $TPL , $keyword_tb , $keyword_rank_day, $skin_folder;
		global $rankIcon_new , $rankIcon_up , $rankIcon_down , $rankIcon_equal, $rank_color;
		global $rank_word, $rank_num, $rank, $rank_keyword, $rank_change, $rank_icon, $checkfield, $rank_cnt;
		global $rankIcon_new_color,$rankIcon_up_color,$rankIcon_down_color,$rankIcon_equal_color;
		global $rank_word_encode, $rank_color;
		#클라우드 추가됨
		global $Cloudtag_FontBg;
		global $cloudtagFont,$cloudtagBg, $rank_icon_html,$keyword_rank_read_roll_x,$rankRowsSize,$rank_cnt_chk,$HAPPY_CONFIG,$실시간검색내용;

		$rankPrintSize	= preg_replace("/\D/","",$rankPrintSize);

		$cdate	= $keyword_rank_day;

		if ( $cdate == "" || $cdate == "0" )
		{
			return "keyword_rank_day 설정이 잘못되었습니다.";
		}

		$year		= ( $_GET["key_year"]== "" )?date("Y"):$_GET["key_year"];
		$mon		= ( $_GET["key_mon"] == "" )?date("m"):$_GET["key_mon"];
		$day		= ( $_GET["key_day"] == "" )?date("d"):$_GET["key_day"];

		$nowDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day+1,$year));
		$firstDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-$cdate+1,$year));
		$lastDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-($cdate*2)+1,$year));

		$Sql	 = "	SELECT											";
		$Sql	.= "			keyword,								";
		$Sql	.= "			sum(count) AS cnt						";
		$Sql	.= "	FROM											";
		$Sql	.= "			$keyword_tb								";
		$Sql	.= "	WHERE											";
		$Sql	.= "			regdate < '$firstDate'					";
		$Sql	.= "			AND										";
		$Sql	.= "			regdate > '$lastDate'					";
		$Sql	.= "			AND										";
		$Sql	.= "			replace(keyword,' ','') != ''			";
		$Sql	.= "	GROUP BY										";
		$Sql	.= "			keyword									";
		$Sql	.= "	ORDER BY										";
		$Sql	.= "			cnt desc								";
		$Sql	.= "	LIMIT	0,30									";

		$Rs2	= query($Sql);

		$실시간검색내용	= "";
		$rank	= 1;
		while ( $Hash = happy_mysql_fetch_array($Rs2) )
		{
			$pRank[$Hash["keyword"]]	= $rank;
			$rank++;
		}


		$Sql	 = "	SELECT											";
		$Sql	.= "			*,										";
		$Sql	.= "			sum(count) AS cnt						";
		$Sql	.= "	FROM											";
		$Sql	.= "			$keyword_tb								";
		$Sql	.= "	WHERE											";
		$Sql	.= "			regdate > '$firstDate'					";
		$Sql	.= "			AND										";
		$Sql	.= "			regdate < '$nowDate'					";
		$Sql	.= "			AND										";
		$Sql	.= "			replace(keyword,' ','') != ''			";
		$Sql	.= "	GROUP BY										";
		$Sql	.= "			keyword									";
		$Sql	.= "	ORDER BY										";
		$Sql	.= "			cnt desc							";
		$Sql	.= "	LIMIT											";
		$Sql	.= "			0,$rankPrintSize						";

		$Rs1	= query($Sql);

		$rank	= 1;
		$random	= rand(1000,9999);
		#	rank_num	-> 현재순위
		#	rank_word	-> 검색단어
		#	rank_cnt	-> 검색횟수
		#	rank_icon	-> 순위변동아이콘
		#	rank_change	-> 순위변동된 숫자

		$TPL->define("실시간검색하부_$random", $skin_folder."/".$keyword_template2 );

		$ReturnRank = array();
		$rank_keyword	= '';

		while ( $Data = happy_mysql_fetch_array($Rs1) )
		{
			$rankChk	= $pRank[$Data["keyword"]];
			$rank_word_encode	= urlencode($Data["keyword"]);
			$rank_word	= $Data["keyword"];
			$rank_num	= $rank;
			$rank_cnt	= $Data["cnt"];

			$rank_cnt_chk		= "1";
			if( $rank > 3 )
			{
				$rank_cnt_chk	= "2";
			}

			if ( $rankChk == "" ) {
				$rank_icon		= $rankIcon_new;
				$rank_icon_html	= '3';
				$rank_change	= "";
				$rank_color		= $rankIcon_new_color;
			}
			else if ( $rankChk > $rank ) {
				$tmp	= $rankChk - $rank;
				$rank_icon		= $rankIcon_up;
				$rank_icon_html	= '4';
				$rank_change	= $tmp;
				$rank_color		= $rankIcon_up_color;
			}
			else if ( $rankChk < $rank ) {
				$tmp	= $rank - $rankChk;
				$rank_icon		= $rankIcon_down;
				$rank_icon_html	= '1';
				$rank_change	= $tmp;
				$rank_color		= $rankIcon_down_color;
			}
			else if ( $rankChk == $rank ) {
				$rank_icon		= $rankIcon_equal;
				$rank_icon_html	= '2';
				$rank_change	= "";
				$rank_color		= $rankIcon_equal_color;
			}

			$checkfield = ( $rank != 1 )?$checkField:"";

			#클라우드 태그 추가
			$cloudtagFont = '';
			$cloudtagBg = '';

			//echo  key(&$Cloudtag_FontBg)." : ".$rank."\r\n";
			if ( key($Cloudtag_FontBg) == $rank )
			{
				$current_rank = current($Cloudtag_FontBg);
				next($Cloudtag_FontBg);
			}
			$cloudtagFont = htmlspecialchars($current_rank['font']);
			$cloudtagBg = htmlspecialchars($current_rank['bg']);
			#클라우드 태그 추가

			$temp						= &$TPL->fetch();
			array_push($ReturnRank,$temp);
			$rank_keyword["m".$rank]	= str_replace("\n","",$temp);
			$실시간검색내용						.= $temp;
			$rank++;
		}

		$TPL->define("실시간검색", $skin_folder."/". $keyword_template1 );
		$content = &$TPL->fetch();

		if ( $returnType == 'return' )
		{
			shuffle($ReturnRank);
			return $ReturnRank;
		}
		else if ( $returnType == 'content' )
		{
			return $실시간검색내용;
		}
		else
		{
			return print $content;
		}

	}


	# {{실시간인기검색어롤링 랭킹10개,리스트1개,껍데기탬플릿,알맹이탬플릿,속도,정지시간,애니메이션(fade/공백),마우스오버시롤링정지여부(true/false)}}
	# {{실시간인기검색어롤링 10개,3개,keyword_html_roll.html,keyword_html_roll_sub.html,속도100ms,멈춤시간8000ms,fade,true}}
	# {{실시간검색 10개,keyword_html.html,keyword_html_sub.html}}
	$keyword_rank_read_roll_x = 0;
	function keyword_rank_read_roll($rankPrintSize,$rank_row_size = "1",$keyword_template1,$keyword_template2,$speed = "500",$pause="3000",$animation="fade",$mousePause="false")
	{
		global $TPL,$skin_folder,$keyword_rank_read_roll_x,$rankRowsSize,$실시간롤링개수, $실시간롤링필수스크립트,$실시간롤링스크립트, $실시간검색롤링내용;

		$rank_row_size			= preg_replace("/\D/","",$rank_row_size);
		$rank_row_size			= ( $rank_row_size == '' ) ? '1' : $rank_row_size;

		$speed					= preg_replace("/\D/","",$speed);
		$speed					= ( $speed == '' ) ? '500' : $speed;

		$pause					= preg_replace("/\D/","",$pause);
		$pause					= ( $pause == '' ) ? '3000' : $pause;

		$실시간검색롤링내용		= keyword_rank_read($rankPrintSize,$keyword_template1,$keyword_template2,$checkField,"content");

		$실시간롤링필수스크립트	= "";
		if( $keyword_rank_read_roll_x == 0 )
		{
			$실시간롤링필수스크립트	= "
				<script type=\"text/javascript\">
				<!--
					if ( !window.jQuery )
					{
						document.write(\"<sc\"+\"ript type='text/javascript' src='js/jquery_min.js'></sc\"+\"ript>\");
					}
				//-->
				</script>

				<script type=\"text/javascript\">
					/*
					* vertical news ticker
					* Tadas Juozapaitis ( kasp3rito@gmail.com )
					* http://plugins.jquery.com/project/vTicker
					*/
					(function(a){a.fn.vTicker=function(b){var c={speed:700,pause:4000,showItems:3,animation:\"\",mousePause:true,isPaused:false,direction:\"up\",height:0};var b=a.extend(c,b);moveUp=function(g,d,e){if(e.isPaused){return}var f=g.children(\"ul\");var h=f.children(\"li:first\").clone(true);if(e.height>0){d=f.children(\"li:first\").height()}f.animate({top:\"-=\"+d+\"px\"},e.speed,function(){a(this).children(\"li:first\").remove();a(this).css(\"top\",\"0px\")});if(e.animation==\"fade\"){f.children(\"li:first\").fadeOut(e.speed);if(e.height==0){f.children(\"li:eq(\"+e.showItems+\")\").hide().fadeIn(e.speed)}}h.appendTo(f)};moveDown=function(g,d,e){if(e.isPaused){return}var f=g.children(\"ul\");var h=f.children(\"li:last\").clone(true);if(e.height>0){d=f.children(\"li:first\").height()}f.css(\"top\",\"-\"+d+\"px\").prepend(h);f.animate({top:0},e.speed,function(){a(this).children(\"li:last\").remove()});if(e.animation==\"fade\"){if(e.height==0){f.children(\"li:eq(\"+e.showItems+\")\").fadeOut(e.speed)}f.children(\"li:first\").hide().fadeIn(e.speed)}};return this.each(function(){var f=a(this);var e=0;f.css({overflow:\"hidden\",position:\"relative\"}).children(\"ul\").css({position:\"absolute\",margin:0,padding:0}).children(\"li\").css({margin:0,padding:0});if(b.height==0){f.children(\"ul\").children(\"li\").each(function(){if(a(this).height()>e){e=a(this).height()}});f.children(\"ul\").children(\"li\").each(function(){a(this).height(e)});f.height(e*b.showItems)}else{f.height(b.height)}var d=setInterval(function(){if(b.direction==\"up\"){moveUp(f,e,b)}else{moveDown(f,e,b)}},b.pause);if(b.mousePause){f.bind(\"mouseenter\",function(){b.isPaused=true}).bind(\"mouseleave\",function(){b.isPaused=false})}})}})(jQuery);
				</script>
			";
		}

		$실시간롤링필수스크립트	.= "
			<script type=\"text/javascript\">
			$(function(){
				$('#news-container{$keyword_rank_read_roll_x}').removeClass(\"hideuntilready\").vTicker({
					speed: $speed,
					pause: $pause,
					animation: '$animation',
					mousePause: $mousePause,
					showItems: $rank_row_size
				});
			});
			</script>
		";

		$TPL->define("실시간검색", $skin_folder."/". $keyword_template1 );
		$content = &$TPL->fetch();

		$keyword_rank_read_roll_x++;

		print $content;
	}


	function call_now_nevi( $nevi )
	{
		global $prev_stand, $현재위치;
		global $현재메뉴명;


		if ( $현재메뉴명 != "" )
		{
			//$nevi	= $현재메뉴명;
		}

		$현재위치	= "$prev_stand > $nevi";
	}

	#특정경로($folder)의 $filename이 속한 파일명들을 배열로 리턴 $noFile은 제외파일
	function filelist( $folder, $filename, $noFile = "")
	{
		$noFile	= $noFile == "" ?"adjflksdajflkasdjflkasdsaf":$noFile;
		$temp	= array();
		if ($handle = opendir("$folder"))
		{
			while (false !== ($file = readdir($handle)))
			{
				if ($file != "." && $file != "..")
				{
					$temp[]	= $file;
				}
			}
			closedir($handle);
		}
		sort($temp);

		$filename	= explode(",", $filename);
		$max		= sizeof($filename);
		$return		= Array();

		// 뺄 파일명 넣기
		$block_file	= Array('my_view_rightsub_scroll.html');

		foreach ($temp as $value)
		{
			for ( $i=0 ; $i<$max ; $i++ )
			{
				if ( eregi($filename[$i],$value) && !eregi($noFile,$value) )
				{
					if(in_array($value,$block_file))
					{
						continue;
					}

					//$value = iconv("euc-kr","utf-8",$value);
					array_push($return,$value);
				}
			}
		}

		return $return;

	}



##################################################################


function subway_flash( $underground )
{
	//{{지하철플레쉬 대구1호선}}
	global $xml_under_folder;

	$underground	= preg_replace('/\n/', '', $underground);

	$fileName		= "${xml_under_folder}/xml_under_${underground}.xml";

	if ( !is_file($fileName) )
	{
		return print "$fileName 이 존재하지 않습니다.";
	}
	else
	{
		//##### 파싱 기본 루틴 시작
		$xml = file_get_contents("$fileName");
		$parser = new XMLParser($xml);
		$parser->Parse();
		//##### 파싱 기본 루틴 종료

		$iconWidth		= $parser->document->option[0]->tagAttrs['linewidth'];		// 아이콘가로크기
		$iconHeight		= $parser->document->option[0]->tagAttrs['lineheight'];		// 아이콘세로크기
		$blockWidth		= $parser->document->option[0]->tagAttrs['countx'];			// 바둑판 가로칸수
		$blockHeight	= $parser->document->option[0]->tagAttrs['county'];			// 바둑판 세로칸수

		$flashWidth		= $iconWidth * $blockWidth;
		$flashHeight	= $iconHeight * $blockHeight + 120;
	}

	return print "<SCRIPT LANGUAGE=\"JavaScript\">objectTAG(\"menu\",\"flash_swf/subway.swf?fileName=../${fileName}\",\"$flashWidth\",\"$flashHeight\",'Transparent');</SCRIPT>";
}



##################################################################



/**
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	For Support, please visit http://www.criticaldevelopment.net/xml/
*/

/**
 * XML Parser Class (php4)
 *
 * Parses an XML document into an object structure much like the SimpleXML extension.
 *
 * @author Adam A. Flynn <adamaflynn@criticaldevelopment.net>
 * @copyright Copyright (c) 2005-2007, Adam A. Flynn
 *
 * @version 1.3.0
 */
class XMLParser
{
	/**
	 * The XML parser
	 *
	 * @var resource
	 */
	var $parser;

	/**
	* The XML document
	*
	* @var string
	*/
	var $xml;

	/**
	* Document tag
	*
	* @var object
	*/
	var $document;

	/**
	* Current object depth
	*
	* @var array
	*/
	var $stack;
	/**
	 * Whether or not to replace dashes and colons in tag
	 * names with underscores.
	 *
	 * @var bool
	 */
	var $cleanTagNames;


	/**
	 * Constructor. Loads XML document.
	 *
	 * @param string $xml The string of the XML document
	 * @return XMLParser
	 */
	function XMLParser($xml = '', $cleanTagNames = true)
	{
		//Load XML document
		$this->xml = $xml;

		// Set stack to an array
		$this->stack = array();

		//Set whether or not to clean tag names
		$this->cleanTagNames = $cleanTagNames;
	}

	/**
	 * Initiates and runs PHP's XML parser
	 */
	function Parse()
	{
		//Create the parser resource
		$this->parser = xml_parser_create();

		//Set the handlers
		xml_set_object($this->parser, $this);
		xml_set_element_handler($this->parser, 'StartElement', 'EndElement');
		xml_set_character_data_handler($this->parser, 'CharacterData');

		//Error handling
		if (!xml_parse($this->parser, $this->xml))
			$this->HandleError(xml_get_error_code($this->parser), xml_get_current_line_number($this->parser), xml_get_current_column_number($this->parser));

		//Free the parser
		xml_parser_free($this->parser);
	}

	/**
	 * Handles an XML parsing error
	 *
	 * @param int $code XML Error Code
	 * @param int $line Line on which the error happened
	 * @param int $col Column on which the error happened
	 */
	function HandleError($code, $line, $col)
	{
		trigger_error('XML Parsing Error at '.$line.':'.$col.'. Error '.$code.': '.xml_error_string($code));
	}


	/**
	 * Gets the XML output of the PHP structure within $this->document
	 *
	 * @return string
	 */
	function GenerateXML()
	{
		return $this->document->GetXML();
	}

	/**
	 * Gets the reference to the current direct parent
	 *
	 * @return object
	 */
	function GetStackLocation()
	{
		$return = '';

		foreach($this->stack as $stack)
			$return .= $stack.'->';

		return rtrim($return, '->');
	}

	/**
	 * Handler function for the start of a tag
	 *
	 * @param resource $parser
	 * @param string $name
	 * @param array $attrs
	 */
	function StartElement($parser, $name, $attrs = array())
	{
		//Make the name of the tag lower case
		$name = strtolower($name);

		//Check to see if tag is root-level
		if (count($this->stack) == 0)
		{
			//If so, set the document as the current tag
			$this->document = new XMLTag($name, $attrs);

			//And start out the stack with the document tag
			$this->stack = array('document');
		}
		//If it isn't root level, use the stack to find the parent
		else
		{
			//Get the name which points to the current direct parent, relative to $this
			$parent = $this->GetStackLocation();

			//Add the child
			eval('$this->'.$parent.'->AddChild($name, $attrs, '.count($this->stack).', $this->cleanTagNames);');

			//If the cleanTagName feature is on, replace colons and dashes with underscores
			if($this->cleanTagNames)
				$name = str_replace(array(':', '-'), '_', $name);


			//Update the stack
			eval('$this->stack[] = $name.\'[\'.(count($this->'.$parent.'->'.$name.') - 1).\']\';');
		}
	}

	/**
	 * Handler function for the end of a tag
	 *
	 * @param resource $parser
	 * @param string $name
	 */
	function EndElement($parser, $name)
	{
		//Update stack by removing the end value from it as the parent
		array_pop($this->stack);
	}

	/**
	 * Handler function for the character data within a tag
	 *
	 * @param resource $parser
	 * @param string $data
	 */
	function CharacterData($parser, $data)
	{
		//Get the reference to the current parent object
		$tag = $this->GetStackLocation();

		//Assign data to it
		eval('$this->'.$tag.'->tagData .= trim($data);');
	}
}


/**
 * XML Tag Object (php4)
 *
 * This object stores all of the direct children of itself in the $children array. They are also stored by
 * type as arrays. So, if, for example, this tag had 2 <font> tags as children, there would be a class member
 * called $font created as an array. $font[0] would be the first font tag, and $font[1] would be the second.
 *
 * To loop through all of the direct children of this object, the $children member should be used.
 *
 * To loop through all of the direct children of a specific tag for this object, it is probably easier
 * to use the arrays of the specific tag names, as explained above.
 *
 * @author Adam A. Flynn <adamaflynn@criticaldevelopment.net>
 * @copyright Copyright (c) 2005-2007, Adam A. Flynn
 *
 * @version 1.3.0
 */
class XMLTag
{
	/**
	 * Array with the attributes of this XML tag
	 *
	 * @var array
	 */
	var $tagAttrs;

	/**
	 * The name of the tag
	 *
	 * @var string
	 */
	var $tagName;

	/**
	 * The data the tag contains
	 *
	 * So, if the tag doesn't contain child tags, and just contains a string, it would go here
	 *
	 * @var string
	 */
	var $tagData;

	/**
	 * Array of references to the objects of all direct children of this XML object
	 *
	 * @var array
	 */
	var $tagChildren;

	/**
	 * The number of parents this XML object has (number of levels from this tag to the root tag)
	 *
	 * Used presently only to set the number of tabs when outputting XML
	 *
	 * @var int
	 */
	var $tagParents;

	/**
	 * Constructor, sets up all the default values
	 *
	 * @param string $name
	 * @param array $attrs
	 * @param int $parents
	 * @return XMLTag
	 */
	function XMLTag($name, $attrs = array(), $parents = 0)
	{
		//Make the keys of the attr array lower case, and store the value
		$this->tagAttrs = array_change_key_case($attrs, CASE_LOWER);

		//Make the name lower case and store the value
		$this->tagName = strtolower($name);

		//Set the number of parents
		$this->tagParents = $parents;

		//Set the types for children and data
		$this->tagChildren = array();
		$this->tagData = '';
	}

	/**
	 * Adds a direct child to this object
	 *
	 * @param string $name
	 * @param array $attrs
	 * @param int $parents
	 * @param bool $cleanTagName
	 */
	function AddChild($name, $attrs, $parents, $cleanTagName = true)
	{
		//If the tag is a reserved name, output an error
		if(in_array($name, array('tagChildren', 'tagAttrs', 'tagParents', 'tagData', 'tagName')))
		{
			trigger_error('You have used a reserved name as the name of an XML tag. Please consult the documentation (http://www.criticaldevelopment.net/xml/) and rename the tag named "'.$name.'" to something other than a reserved name.', E_USER_ERROR);

			return;
		}

		//Create the child object itself
		$child = new XMLTag($name, $attrs, $parents);

		//If the cleanTagName feature is on, replace colons and dashes with underscores
		if($cleanTagName)
			$name = str_replace(array(':', '-'), '_', $name);

		//Toss up a notice if someone's trying to to use a colon or dash in a tag name
		elseif(strstr($name, ':') || strstr($name, '-'))
			trigger_error('Your tag named "'.$name.'" contains either a dash or a colon. Neither of these characters are friendly with PHP variable names, and, as such, they cannot be accessed and will cause the parser to not work. You must enable the cleanTagName feature (pass true as the second argument of the XMLParser constructor). For more details, see http://www.criticaldevelopment.net/xml/', E_USER_ERROR);

		//If there is no array already set for the tag name being added,
		//create an empty array for it
		if(!isset($this->$name))
			$this->$name = array();

		//Add the reference of it to the end of an array member named for the tag's name
		$this->{$name}[] =& $child;

		//Add the reference to the children array member
		$this->tagChildren[] =& $child;
	}

	/**
	 * Returns the string of the XML document which would be generated from this object
	 *
	 * This function works recursively, so it gets the XML of itself and all of its children, which
	 * in turn gets the XML of all their children, which in turn gets the XML of all thier children,
	 * and so on. So, if you call GetXML from the document root object, it will return a string for
	 * the XML of the entire document.
	 *
	 * This function does not, however, return a DTD or an XML version/encoding tag. That should be
	 * handled by XMLParser::GetXML()
	 *
	 * @return string
	 */
	function GetXML()
	{
		//Start a new line, indent by the number indicated in $this->parents, add a <, and add the name of the tag
		$out = "\n".str_repeat("\t", $this->tagParents).'<'.$this->tagName;

		//For each attribute, add attr="value"
		foreach($this->tagAttrs as $attr => $value)
			$out .= ' '.$attr.'="'.$value.'"';

		//If there are no children and it contains no data, end it off with a />
		if(empty($this->tagChildren) && empty($this->tagData))
			$out .= " />";

		//Otherwise...
		else
		{
			//If there are children
			if(!empty($this->tagChildren))
			{
				//Close off the start tag
				$out .= '>';

				//For each child, call the GetXML function (this will ensure that all children are added recursively)
				foreach($this->tagChildren as $child)
				{
					if(is_object($child))
						$out .= $child->GetXML();
				}

				//Add the newline and indentation to go along with the close tag
				$out .= "\n".str_repeat("\t", $this->tagParents);
			}

			//If there is data, close off the start tag and add the data
			elseif(!empty($this->tagData))
				$out .= '>'.$this->tagData;

			//Add the end tag
			$out .= '</'.$this->tagName.'>';
		}

		//Return the final output
		return $out;
	}

	/**
	 * Deletes this tag's child with a name of $childName and an index
	 * of $childIndex
	 *
	 * @param string $childName
	 * @param int $childIndex
	 */
	function Delete($childName, $childIndex = 0)
	{
		//Delete all of the children of that child
		$this->{$childName}[$childIndex]->DeleteChildren();

		//Destroy the child's value
		$this->{$childName}[$childIndex] = null;

		//Remove the child's name from the named array
		unset($this->{$childName}[$childIndex]);

		//Loop through the tagChildren array and remove any null
		//values left behind from the above operation
		for($x = 0; $x < count($this->tagChildren); $x ++)
		{
			if(is_null($this->tagChildren[$x]))
				unset($this->tagChildren[$x]);
		}
	}

	/**
	 * Removes all of the children of this tag in both name and value
	 */
	function DeleteChildren()
	{
		//Loop through all child tags
		for($x = 0; $x < count($this->tagChildren); $x ++)
		{
			//Do this recursively
			$this->tagChildren[$x]->DeleteChildren();

			//Delete the name and value
			$this->tagChildren[$x] = null;
			unset($this->tagChildren[$x]);
		}
	}
}



##################################################################




##################################################################



function getcontent($get_addr)
{
 global $naver_key;
 global $naver_secret_key;
 $get_addr = urlencode($get_addr);	#UTF환경시 이줄은 삭제
 #$get_addr	= $map_cquery =iconv("utf-8","euc-kr",$get_addr); #UTF환경시 위에소스를 지우고 이소스를 사용
 #UTF 환경에서 temp/detail_common.html 파일에 view_img 함수의 UTF관련 주석을 풀어주어야 함 (상세보기지도)
 $cont = "";

/*
 $server = "maps.naver.com";
 $file = "/api/geocode.php?key=".$naver_key."&query=".$get_addr;

 $fp = pfsockopen($server, 80, $errno, $errstr);
 if (!$fp) {
    echo "$errstr ($errno)<br/>\n";
    exit;
 } else {
    fputs($fp, "GET $file  HTTP/1.1\r\n");
    fputs($fp, "Host: $server\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fwrite($fp, $out);

    while (!feof($fp)) {
     $cont .= fgets($fp, 128);
    }
    fclose($fp);
       return $cont;
 } */
	$curl_url		= "https://naveropenapi.apigw.ntruss.com/map-geocode/v2/geocode?query=".$get_addr;
	$curl_header	= Array(
							"Host: naveropenapi.apigw.ntruss.com",
							"User-Agent: curl/7.43.0",
							"Accept: application/xml",
							"X-NCP-APIGW-API-KEY-ID: $naver_key",
							"X-NCP-APIGW-API-KEY: $naver_secret_key"
	);


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $curl_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
	$cont = curl_exec($ch);
	curl_close($ch);

	return $cont;
}


function getpoint($data,$start_str,$end_str)
{
	$i=0;
	while(is_int($pos = strpos($data, $start_str, $i)))
	{
		$pos += strlen($start_str);
		$endpos = strpos($data,$end_str, $pos);
		$value = substr($data, $pos, $endpos-$pos);
		//echo $value."<br>";
		$value_array[] = $value;
		$i = $endpos;
	}

	return $value_array;

}




##################################################################

/*
function naver_map_call( $get_addr, $map_width, $map_height, $default_map_size, $view_icon, $view_zoom_button )
{
	global $naver_key,$naver_get_addr;

	if($naver_key == '')
	{
		return "<img src='img/lost_naver_key.jpg' width='100%' height='100%' alt='지도키를 입력해주세요.'>";
		exit;
	}


	if ( preg_match("/%/",$map_width) )
	{
		$map_width_resize	= true;
	}
	else
	{
		$map_width_resize	= false;
	}

	if ( preg_match("/%/",$map_height) )
	{
		$map_height_resize	= true;
	}
	else
	{
		$map_height_resize	= false;
	}



	$get_addr			= preg_replace('/\n/','',$get_addr);
	$map_width			= preg_replace('/\D/','',$map_width);
	$map_height			= preg_replace('/\D/','',$map_height);
	$default_map_size	= preg_replace('/\D/','',$default_map_size);
	$view_icon			= preg_replace('/\n/','',$view_icon);
	$view_zoom_button	= preg_replace('/\D/','',$view_zoom_button);

	$get_addr			= ( $get_addr == '자동' )?$naver_get_addr:$get_addr;

	$wheeling	= "";
	$imagehw = @GetImageSize("$view_icon");
	$view_icon_width = $imagehw[0];
	$view_icon_width_2	= round($view_icon_width/2);
	$view_icon_height = $imagehw[1];

	if ( $view_type_button )
	{
		$view_type			= "	var oMapTypeBtn = new nhn.api.map.MapTypeBtn();
								oMap.addControl(oMapTypeBtn);
								oMapTypeBtn.setPosition
								({
									top : 10,
									right : 120
								});
		";
	}

	if ( $view_zoom_button )
	{
		$view_zoom			= "	var oSlider = new nhn.api.map.ZoomControl();
								oMap.addControl(oSlider);
								oSlider.setPosition
								({
									top : 10,
									right : 10
								});
		";
	}


	#가로 세로 값이 %로 들어왔다면 리사이즈 크기 계산 스크립트 작성.
	if ( $map_width_resize || $map_height_resize )
	{
		if($map_width_resize)
		{
			$percent_width_str		= "percent_to_size($map_width, map_width)";
		}
		else
		{
			$percent_width_str		= $map_width;
		}

		if($map_height_resize)
		{
			$percent_height_str		= "percent_to_size($map_height, map_height)";
		}
		else
		{
			$percent_height_str		= $map_height;
		}

		$change_map_resize_str		= "
										$(window).resize(function() {
												map_width			= $(window).width();
												map_height			= $(window).height()-75;
												resize_width		= $percent_width_str;
												resize_height		= $percent_height_str;
												oMap.setSize(new nhn.api.map.Size(resize_width, resize_height));
										});
		";

		$start_map_size_str			= "
										function percent_to_size(percent, size)
										{
											percent_size		= percent*(size/100);
											percent_size		= parseInt(percent_size);
											return percent_size;
										}

										map_width			= $(window).width();
										map_height			= $(window).height()-75;

										var start_map_width	= $percent_width_str;
										var start_map_height= $percent_height_str;
		";
	}
	else
	{
		$change_map_resize_str		= "";
		$start_map_size_str			= "	var start_map_width		= ${map_width};
										var start_map_height	= ${map_height};
		";
	}


	#$data=getcontent($get_addr);
	#$xpoint=getpoint($data,"<x>","</x>");
	#$ypoint=getpoint($data,"<y>","</y>");

	#echo "<b>$get_addr</b><br><br>";
	$get_addrs		= explode(" ",$get_addr);
	$get_addr_ok	= '';
	for ( $i=sizeof($get_addrs)-1 ; $i>1 ; $i-- )
	{
		$get_addr_tmp	= '';
		for ( $j=0 ; $j<=$i ; $j++ )
		{
			$get_addr_tmp	.= $get_addrs[$j].' ';
		}

		$data=getcontent($get_addr_tmp);
		$xpoint=getpoint($data,"<y>","</y>");
		$ypoint=getpoint($data,"<x>","</x>");
		$xpoint = $xpoint[0];
		$ypoint = $ypoint[0];


		if ( $xpoint != '' && $ypoint != '' )
		{
			if ( $i != sizeof($get_addrs)-1 )
			{
				$navermap_help = "<div style='border:0px solid red; padding:8px 6px 6px 6px; color:#CCC; background-color:#363636' align='center'><font color=white>[ $get_addr ]</font> 지역의 정보가 없어서 <font color=white><b>$get_addr_tmp</b></font>지역을 불러왔습니다.</div>";
				echo $navermap_help;
				//echo "<table width='680' border=0 cellspacing=0 cellpadding=0><tr><td style='padding:6 4 4 4; color:#CCC;' bgcolor='#363636' align='center'><font color=white>$get_addr</font> 지역의 정보가 없어서 <font color=white><b>$get_addr_tmp</b></font>지역을 불러왔습니다.</td></tr></table>";
			}
			$get_addr		= $get_addr_tmp;
			break;
		}
		#echo "$get_addr_tmp<br>";
	}

	$pointOmethod		= "new nhn.api.map.LatLng($xpoint, $ypoint)";
	$setDefaultPoint	= "nhn.api.map.setDefaultPoint('LatLng');";

	#echo "현재좌표 : $xpoint[0] , $ypoint[0]<br>$get_addr<br>마우스휠 가능상태임";
	#위 php에서 x,y 좌표를 얻는다.
	##########################################


	if ( $xpoint == '' || $ypoint == '' )
	{
		if ( $_COOKIE['happy_mobile'] == 'on' )
		{
			##[ YOON : 2009-03-10 ]###############
			$navermap	= "<center><table border=0 cellspacing=0 cellpadding=0 style=\"width:100%; height:174px;line-height:17px;\"><tr><td align='center' ><b>${get_addr}</b><br>지역정보가 존재하지 않아 지도정보를 표시할 수 없습니다.<br>다시 한 번 주소를 확인하여 올바르게 입력하여 주십시오.</td></tr></table></center>";
			//$navermap	= "<center><font color='gray' style='font-size:8pt'>${get_addr} 지역정보가 존재하지 않습니다.</font></center>";
		}
		else
		{
			##[ YOON : 2009-03-10 ]###############
			$navermap	= "<center><table border=0 cellspacing=0 cellpadding=0 style=\"width:750px; height:174px; background:url('img/bg_dt_map_no.gif'); background-repeat:no-repeat; background-position:center 0; line-height:17px;\"><tr><td align='center' style='color:white;'><b>${get_addr}</b><br>지역정보가 존재하지 않아 지도정보를 표시할 수 없습니다.<br>다시 한 번 주소를 확인하여 올바르게 입력하여 주십시오.</td></tr></table></center>";
			//$navermap	= "<center><font color='gray' style='font-size:8pt'>${get_addr} 지역정보가 존재하지 않습니다.</font></center>";
		}
	}
	else
	{
		$navermap			= "		<script type=\"text/javascript\" src=\"http://openapi.map.naver.com/openapi/v2/maps.js?ncpClientId=$naver_key\"></script>
									<div id=\"mapContainer\" style=\"border:0px solid #000; margin:0; padding:0;\"></div>
									<script type=\"text/javascript\">
										$start_map_size_str
										var oNaverMapPoint		= $pointOmethod;
										var defaultLevel		= $default_map_size;

										var oMap				= new nhn.api.map.Map(document.getElementById('mapContainer'), {
																		point				: oNaverMapPoint,
																		zoom				: defaultLevel,
																		enableWheelZoom		: true,
																		enableDragPan		: true,
																		enableDblClickZoom	: false,
																		mapMode				: 0,
																		activateTrafficMap	: false,
																		activateBicycleMap	: false,
																		minMaxLevel			: [ 1, 14 ],
																		size				: new nhn.api.map.Size(start_map_width, start_map_height)
										});
										//oMap.setCenter(oNaverMapPoint);

										$change_map_resize_str
										$setDefaultPoint
										$view_type
										$view_zoom

										var oSize				= new nhn.api.map.Size($view_icon_width, $view_icon_height);
										var oOffset				= new nhn.api.map.Size($view_icon_width_2, $view_icon_height);
										var oIcon				= new nhn.api.map.Icon('$view_icon', oSize, oOffset);
										var oMarker				= new nhn.api.map.Marker(oIcon);

										oMarker.setPoint($pointOmethod);
										oMap.addOverlay(oMarker);
									</script>
		";
	}
	return $navermap;

}
*/
#2015-11-23 sum부분업그레이드(네이버지도교체)
/*
function naver_map_call( $get_addr, $map_width, $map_height, $default_map_size, $view_icon, $view_type_button, $view_zoom_button)
{
	global $naver_key,$naver_get_addr,$m_version, $주소좌표사용, $x_point ,$y_point;

	if ( $naver_key == '' )
	{
		return "<img src='img/lost_naver_key.jpg' width='100%' height='100%' alt='지도키를 입력해주세요.'>";
		exit;
	}

	if ( preg_match("/%/",$map_width) )
	{
		$map_width_resize	= true;
	}
	else
	{
		$map_width_resize	= false;
	}

	if ( preg_match("/%/",$map_height) )
	{
		$map_height_resize	= true;
	}
	else
	{
		$map_height_resize	= false;
	}

	$get_addr			= preg_replace('/\n/', '', $get_addr);
	$map_width			= preg_replace('/\D/', '', $map_width);
	$map_height			= preg_replace('/\D/', '', $map_height);
	$default_map_size	= preg_replace('/\D/', '', $default_map_size);
	$view_icon			= preg_replace('/\n/', '', $view_icon);
	$view_type_button	= preg_replace('/\D/', '', $view_type_button);
	$view_zoom_button	= preg_replace('/\D/', '', $view_zoom_button);

	$get_addr			= ( $get_addr == '자동' )?$naver_get_addr:$get_addr;

	$nhn_api_map_Size	= "";
	$imagehw			= @GetImageSize("$view_icon");
	if( $imagehw[0] > 0 AND $imagehw[1] > 0 )
	{
		$view_icon_width	= $imagehw[0];
		$view_icon_width_2	= round($view_icon_width/2);
		$view_icon_height	= $imagehw[1];
		$nhn_api_map_Marker	= "
										var oSize				= new nhn.api.map.Size($view_icon_width, $view_icon_height);
										var oOffset				= new nhn.api.map.Size($view_icon_width_2, $view_icon_height);
										var oIcon				= new nhn.api.map.Icon('$view_icon', oSize, oOffset);
										var oMarker				= new nhn.api.map.Marker(oIcon);
							";
	}

	if ( $view_type_button )
	{
		$view_type			= "	var oMapTypeBtn = new nhn.api.map.MapTypeBtn();
								oMap.addControl(oMapTypeBtn);
								oMapTypeBtn.setPosition
								({
									top : 10,
									right : 120
								});
		";
	}

	if ( $view_zoom_button )
	{
		$view_zoom			= "	var oSlider = new nhn.api.map.ZoomControl();
								oMap.addControl(oSlider);
								oSlider.setPosition
								({
									top : 10,
									right : 10
								});
		";
	}

	#가로 세로 값이 %로 들어왔다면 리사이즈 크기 계산 스크립트 작성.
	if ( $map_width_resize || $map_height_resize )
	{
		if($map_width_resize)
		{
			$percent_width_str		= "percent_to_size($map_width, map_width)";
		}
		else
		{
			$percent_width_str		= $map_width;
		}

		if($map_height_resize)
		{
			$percent_height_str		= "percent_to_size($map_height, map_height)";
		}
		else
		{
			$percent_height_str		= $map_height;
		}

		$change_map_resize_str		= "
										$(window).resize(function() {
												map_width			= $(window).width();
												map_height			= $(window).height()-75;
												resize_width		= $percent_width_str;
												resize_height		= $percent_height_str;
												oMap.setSize(new nhn.api.map.Size(resize_width, resize_height));
										});
		";

		$start_map_size_str			= "
										function percent_to_size(percent, size)
										{
											percent_size		= percent*(size/100);
											percent_size		= parseInt(percent_size);
											return percent_size;
										}

										map_width			= $(window).width();
										map_height			= $(window).height()-75;

										var start_map_width	= $percent_width_str;
										var start_map_height= $percent_height_str;
		";
	}
	else
	{
		$change_map_resize_str		= "";
		$start_map_size_str			= "	var start_map_width		= ${map_width};
										var start_map_height	= ${map_height};
		";
	}


	if( $주소좌표사용 != "0" AND strlen($get_addr) > 0 )
	{
		// 주소로 좌표를 사용함
		$get_addrs			= explode(" ", $get_addr);
		$get_addr_ok		= '';

		for ( $i=sizeof($get_addrs)-1 ; $i>1 ; $i-- )
		{
			$get_addr_tmp		= '';
			for ( $j=0 ; $j<=$i ; $j++ )
			{
				$get_addr_tmp		.= $get_addrs[$j].' ';
			}

			$data				= getcontent($get_addr_tmp);
			$xpoint=getpoint($data,"<y>","</y>");
			$ypoint=getpoint($data,"<x>","</x>");
			$xpoint = $xpoint[0];
			$ypoint = $ypoint[0];



			if ( $xpoint != '' && $ypoint != '' )
			{
				if ( $i != sizeof($get_addrs)-1 )
				{
					$navermap_help		= "<div style='border:0px solid red; padding:8px 6px 6px 6px; color:#CCC; font-size:9pt; background-color:#363636' align='center'><font color=white>[ $get_addr ]</font> 지역의 정보가 없어서 <font color=white><b>$get_addr_tmp</b></font>지역을 불러왔습니다.</div>";
					echo $navermap_help;
				}
				$get_addr			= $get_addr_tmp;
				break;
			}
			#echo "$get_addr_tmp<br>";
		}

		$pointOmethod		= "new nhn.api.map.LatLng($xpoint, $ypoint)";
		$setDefaultPoint	= "nhn.api.map.setDefaultPoint('LatLng');";
	}
	else
	{
		// 지도로 설정한 좌표를 사용함
		$ypoint	= $y_point;
		$xpoint	= $x_point;

		$pointOmethod		= "new nhn.api.map.LatLng($xpoint, $ypoint)";
		$setDefaultPoint	= "nhn.api.map.setDefaultPoint('LatLng');";
	}


	#echo "현재좌표 : $xpoint[0] , $ypoint[0]<br>$get_addr<br>마우스휠 가능상태임";
	#위 php에서 x,y 좌표를 얻는다.
	##########################################


	if ( $xpoint == '' || $ypoint == '' )
	{
		##[ YOON : 2008-10-16 ]###############
		if ( $m_version && $_COOKIE['happy_mobile'] == "on" ) //모바일모드
		{
			$navermap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:100%; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:13px; font-weight:bold; letter-spacing:-1px;'>지도정보를 표시할 수 없습니다.</div></td></tr></table>";
		}
		else //PC모드
		{
			$navermap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:100%; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:13px; font-weight:bold; letter-spacing:-1px;'>지도정보를 표시할 수 없습니다.</div></td></tr></table>";
		}
	}
	else
	{
		$navermap			= "
									<script type=\"text/javascript\">
									<!--
										if ( !window.jQuery )
										{
											document.write(\"<sc\"+\"ript type='text/javascript' src='js/jquery_min.js'></sc\"+\"ript>\");
										}
									//-->
									</script>

									<script type=\"text/javascript\" src=\"http://openapi.map.naver.com/openapi/v2/maps.js?ncpClientId=$naver_key\"></script>
									<div id=\"naver_map_container\" style=\"border:0px solid #000; margin:0; padding:0;\"></div>
									<script type=\"text/javascript\">
										$start_map_size_str
										var oNaverMapPoint		= $pointOmethod;
										var defaultLevel		= $default_map_size;

										var oMap				= new nhn.api.map.Map(document.getElementById('naver_map_container'), {
																		point				: oNaverMapPoint,
																		zoom				: defaultLevel,
																		enableWheelZoom		: true,
																		enableDragPan		: true,
																		enableDblClickZoom	: false,
																		mapMode				: 0,
																		activateTrafficMap	: false,
																		activateBicycleMap	: false,
																		minMaxLevel			: [ 1, 14 ],
																		size				: new nhn.api.map.Size(start_map_width, start_map_height)
										});
										//oMap.setCenter(oNaverMapPoint);

										$change_map_resize_str
										$setDefaultPoint
										$view_type
										$view_zoom

										$nhn_api_map_Marker

										oMarker.setPoint($pointOmethod);
										oMap.addOverlay(oMarker);
									</script>
		";
	}

	return $navermap;
}
*/


function naver_map_call( $get_addr, $map_width, $map_height, $default_map_size, $view_icon, $view_type_button, $view_zoom_button)
{
	global $naver_key,$naver_get_addr,$m_version, $주소좌표사용, $x_point ,$y_point;

	if ( $naver_key == '' )
	{
		return "<div style='text-align:center; background:#f9f9f9'><img src='img/lost_naver_key.jpg' width='' height='' alt='지도키를 입력해주세요.' ></div>";
		exit;
	}

	if ( preg_match("/%/",$map_width) )
	{
		$map_width_resize	= true;
	}
	else
	{
		$map_width_resize	= false;
	}

	if ( preg_match("/%/",$map_height) )
	{
		$map_height_resize	= true;
	}
	else
	{
		$map_height_resize	= false;
	}

	$get_addr			= preg_replace('/\n/', '', $get_addr);
	$map_width			= preg_replace('/\D/', '', $map_width);
	$map_height			= preg_replace('/\D/', '', $map_height);
	$default_map_size	= preg_replace('/\D/', '', $default_map_size);
	$view_icon			= preg_replace('/\n/', '', $view_icon);
	$view_type_button	= preg_replace('/\D/', '', $view_type_button);
	$view_zoom_button	= preg_replace('/\D/', '', $view_zoom_button);

	$get_addr			= ( $get_addr == '자동' )?$naver_get_addr:$get_addr;

	if ( $get_addr == "열람불가" )
	{
		$navermap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:200px; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:11px;'>열람불가</div></td></tr></table>";

		return $navermap;
	}


	if( $주소좌표사용 != "0" AND strlen($get_addr) > 0 )
	{
		// 주소로 좌표를 사용함
		$get_addrs			= explode(" ", $get_addr);
		$get_addr_ok		= '';

		for ( $i=sizeof($get_addrs)-1 ; $i>1 ; $i-- )
		{
			$get_addr_tmp		= '';
			for ( $j=0 ; $j<=$i ; $j++ )
			{
				$get_addr_tmp		.= $get_addrs[$j].' ';
			}

			$data				= getcontent($get_addr_tmp);
			$xpoint=getpoint($data,"<y>","</y>");
			$ypoint=getpoint($data,"<x>","</x>");
			$xpoint = $xpoint[0];
			$ypoint = $ypoint[0];



			if ( $xpoint != '' && $ypoint != '' )
			{
				if ( $i != sizeof($get_addrs)-1 )
				{
					$navermap_help		= "<div style='border:0px solid red; padding:8px 6px 6px 6px; color:#CCC; font-size:9pt; background-color:#363636' align='center'><font color=white>[ $get_addr ]</font> 지역의 정보가 없어서 <font color=white><b>$get_addr_tmp</b></font>지역을 불러왔습니다.</div>";
					echo $navermap_help;
				}
				$get_addr			= $get_addr_tmp;
				break;
			}
			#echo "$get_addr_tmp<br>";
		}

		/* v2
		$pointOmethod		= "new nhn.api.map.LatLng($xpoint, $ypoint)";
		$setDefaultPoint	= "nhn.api.map.setDefaultPoint('LatLng');";
		*/

		$pointOmethod		= "new naver.maps.LatLng($xpoint, $ypoint)";
	}
	else
	{
		// 지도로 설정한 좌표를 사용함
		$ypoint	= $y_point;
		$xpoint	= $x_point;

		/* v2
		$pointOmethod		= "new nhn.api.map.LatLng($xpoint, $ypoint)";
		$setDefaultPoint	= "nhn.api.map.setDefaultPoint('LatLng');";
		*/

		$pointOmethod		= "new naver.maps.LatLng($xpoint, $ypoint)";
	}






	$imagehw			= @GetImageSize("$view_icon");
	if( $imagehw[0] > 0 AND $imagehw[1] > 0 )
	{
		$view_icon_width	= $imagehw[0];
		$view_icon_width_2	= round($view_icon_width/2);
		$view_icon_height	= $imagehw[1];
		/* v2
		$nhn_api_map_Marker	= "
										var oSize				= new nhn.api.map.Size($view_icon_width, $view_icon_height);
										var oOffset				= new nhn.api.map.Size($view_icon_width_2, $view_icon_height);
										var oIcon				= new nhn.api.map.Icon('$view_icon', oSize, oOffset);
										var oMarker				= new nhn.api.map.Marker(oIcon);
							";
		*/

		$nhn_api_map_Marker	= "
										var oSize				= new naver.maps.Size($view_icon_width, $view_icon_height);
										var oOffset				= new naver.maps.Size($view_icon_width_2, $view_icon_height);
										//var oIcon				= new naver.maps.Icon('$view_icon', oSize, oOffset);
										//var oMarker			= new naver.maps.Marker(oIcon);

										var markerOptions = {
											map: oMap,
											position: {$pointOmethod},
											icon: {
												url: '$view_icon',
												size: new naver.maps.Size($view_icon_width, $view_icon_height),
												anchor: new naver.maps.Point($view_icon_width_2, $view_icon_height)
											}
										};
										var marker = new naver.maps.Marker(markerOptions);
										marker.setMap(oMap); // 추가
										//marker.setMap(null); // 삭제
							";
	}

	if ( $view_type_button )
	{
		/* v2
		$view_type			= "	var oMapTypeBtn = new nhn.api.map.MapTypeBtn();
								oMap.addControl(oMapTypeBtn);
								oMapTypeBtn.setPosition
								({
									top : 10,
									right : 120
								});
		";
		*/

		$view_type			= "
								oMap.setOptions({
									mapTypeControl: true,
									MapTypeControlOptions: {
										style: naver.maps.MapTypeControlStyle.DROPDOWN,
										position: naver.maps.Position.TOP_RIGHT
									}
								});
		";
	}

	if ( $view_zoom_button )
	{
		/* v2
		$view_zoom			= "	var oSlider = new nhn.api.map.ZoomControl();
								oMap.addControl(oSlider);
								oSlider.setPosition
								({
									top : 10,
									right : 10
								});
		";
		*/

		$view_zoom			= "
								oMap.setOptions({
									zoomControl: true,
									zoomControlOptions: {
										position: naver.maps.Position.TOP_LEFT
									}
								});
		";
	}

	#가로 세로 값이 %로 들어왔다면 리사이즈 크기 계산 스크립트 작성.
	if ( $map_width_resize || $map_height_resize )
	{
		if($map_width_resize)
		{
			$percent_width_str		= "percent_to_size($map_width, map_width)";
		}
		else
		{
			$percent_width_str		= $map_width;
		}

		if($map_height_resize)
		{
			$percent_height_str		= "percent_to_size($map_height, map_height)";
		}
		else
		{
			$percent_height_str		= $map_height;
		}

		/* v2
		$change_map_resize_str		= "
										$(window).resize(function() {
												map_width			= $(window).width();
												map_height			= $(window).height()-75;
												resize_width		= $percent_width_str;
												resize_height		= $percent_height_str;
												oMap.setSize(new nhn.api.map.Size(resize_width, resize_height));
										});
		";
		*/

		$change_map_resize_str		= "
										$(window).resize(function() {
												map_width			= $(window).width();
												map_height			= $(window).height()-75;
												resize_width		= $percent_width_str;
												resize_height		= $percent_height_str;
												oMap.setSize(new naver.maps.Size(resize_width, resize_height));
										});
		";

		$start_map_size_str			= "
										function percent_to_size(percent, size)
										{
											percent_size		= percent*(size/100);
											percent_size		= parseInt(percent_size);
											return percent_size;
										}

										map_width			= $(window).width();
										map_height			= $(window).height()-75;

										var start_map_width	= $percent_width_str;
										var start_map_height= $percent_height_str;
		";
	}
	else
	{
		$change_map_resize_str		= "";
		$start_map_size_str			= "	var start_map_width		= ${map_width};
										var start_map_height	= ${map_height};
		";
	}





	#echo "현재좌표 : $xpoint[0] , $ypoint[0]<br>$get_addr<br>마우스휠 가능상태임";
	#위 php에서 x,y 좌표를 얻는다.
	##########################################


	if ( $xpoint == '' || $ypoint == '' )
	{
		##[ YOON : 2008-10-16 ]###############
		if ( $m_version && $_COOKIE['happy_mobile'] == "on" ) //모바일모드
		{
			$navermap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:100%; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:14px;'>${get_addr} 지역정보가 존재하지 않아 지도정보를표시할 수 없습니다. 다시 한 번 주소를 확인하여 올바르게 입력하여 주십시오.</div></td></tr></table>";
		}
		else //PC모드
		{
			$navermap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:100%; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center' style='text-align:center; color:#FFF; font-family:맑은 고딕; font-size:14px; line-height:18px;'>${get_addr} 지역정보가 존재하지 않아 지도정보를표시할 수 없습니다. <br>다시 한 번 주소를 확인하여 올바르게 입력하여 주십시오.</td></tr></table>";
		}
	}
	else
	{
		/* v2
		$navermap			= "
									<script type=\"text/javascript\">
									<!--
										if ( !window.jQuery )
										{
											document.write(\"<sc\"+\"ript type='text/javascript' src='js/jquery_min.js'></sc\"+\"ript>\");
										}
									//-->
									</script>

									<script type=\"text/javascript\" src=\"//openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=$naver_key\"></script>
									<div id=\"naver_map_container\" style=\"border:0px solid #000; margin:0; padding:0;\"></div>
									<script type=\"text/javascript\">
										$start_map_size_str
										var oNaverMapPoint		= $pointOmethod;
										var defaultLevel		= $default_map_size;

										var oMap				= new nhn.api.map.Map(document.getElementById('naver_map_container'), {
																		point				: oNaverMapPoint,
																		zoom				: defaultLevel,
																		enableWheelZoom		: true,
																		enableDragPan		: true,
																		enableDblClickZoom	: false,
																		mapMode				: 0,
																		activateTrafficMap	: false,
																		activateBicycleMap	: false,
																		minMaxLevel			: [ 1, 14 ],
																		size				: new nhn.api.map.Size(start_map_width, start_map_height)
										});
										//oMap.setCenter(oNaverMapPoint);

										$change_map_resize_str
										$setDefaultPoint
										$view_type
										$view_zoom

										$nhn_api_map_Marker

										oMarker.setPoint($pointOmethod);
										oMap.addOverlay(oMarker);
									</script>
		";
		*/

		$navermap			= "
									<script type=\"text/javascript\">
									<!--
										if ( !window.jQuery )
										{
											document.write(\"<sc\"+\"ript type='text/javascript' src='js/jquery_min.js'></sc\"+\"ript>\");
										}
									//-->
									</script>

									<script type=\"text/javascript\" src=\"//openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=$naver_key\"></script>
									<div id=\"naver_map_container\" style=\"border:0px solid #000; margin:0; padding:0;\"></div>
									<script type=\"text/javascript\">
										$start_map_size_str
										var oNaverMapPoint		= $pointOmethod;
										var defaultLevel		= $default_map_size;

										var oMap				= new naver.maps.Map(document.getElementById('naver_map_container'), {
																	mapTypeId				: naver.maps.MapTypeId.NORMAL,	//지도유형(NORMAL:일반,SATELLITE:위성,HYBRID:겹칩,TERRAIN :지형도)
																	center					: oNaverMapPoint,				//지도의 초기 중심 좌표
																	zoom					: defaultLevel,					//지도의 초기 줌 레벨
																	minZoom					: 1,							//지도의 최소 줌 레벨
																	maxZoom					: 14,							//지도의 최대 줌 레벨
																	scrollWheel				: true,							//마우스 스크롤 휠을 이용한 지도 확대/축소
																	draggable				: true,							//마우스,손가락 이용한 지도 이동 허용여부
																	disableDoubleClickZoom	: false,						//두번 클릭해 지도확대 사용여부
																	size					: naver.maps.Size(start_map_width, start_map_height)
										});



										$view_type
										$view_zoom

										$change_map_resize_str

										$nhn_api_map_Marker
									</script>
		";
	}

	return $navermap;
}
#2015-11-23 sum부분업그레이드(네이버지도교체)


function google_map_call( $get_addr, $map_width, $map_height, $default_map_size, $map_type, $view_type_button, $view_zoom_button )
{
	global $naver_get_addr,$google_get_addr,$google_map_test_addr, $google_get_addr, $m_version, $google_key;

	$get_addr			= preg_replace('/\n/','',$get_addr);

	// 구글 % 사이즈 적용 - 16.05.19 - x2chi
	$map_width_org		= $map_width;
	$map_width			= preg_replace('/\D/','',$map_width);
	$map_width_unit		= $map_width.( preg_match("/\%/",$map_width_org		) ? "%" : "px" );
	$map_height_org		= $map_height;
	$map_height			= preg_replace('/\D/','',$map_height);
	$map_height_unit	= $map_height.( preg_match("/\%/",$map_height_org	) ? "%" : "px" );

	$default_map_size	= preg_replace('/\D/','',$default_map_size);
	$map_type			= preg_replace('/\n/','',$map_type);
	$view_save_button	= preg_replace('/\D/','',$view_save_button);
	$view_zoom_button	= preg_replace('/\D/','',$view_zoom_button);

	$get_addr			= ( $get_addr == '자동' )?$naver_get_addr:$get_addr;
	$get_addr			= $google_map_test_addr != '' ? $google_map_test_addr : $get_addr;

	if ( $get_addr == "열람불가" )
	{
		$navermap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:200px; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:11px;'>열람불가</div></td></tr></table>";

		return $navermap;
	}


	$mapDivId			= 'map_canvas'.$map_width.$map_height.rand(1,9999);


	switch ( $map_type )
	{
		case '일반지도' :		$map_type_out	= 'ROADMAP'; break;
		case '위성지도' :		$map_type_out	= 'SATELLITE'; break;
		case '하이브리드' :		$map_type_out	= 'HYBRID'; break;
		case '지형지물지도' :	$map_type_out	= 'TERRAIN'; break;
		default :				$map_type_out	= 'ROADMAP'; break;
	}

	if ($view_zoom_button)
	{
		$zoomControlOptions	= ( $map_height > 250 )? 'LARGE' : 'SMALL';
		$zoomControl		= 'true';
	}
	else
	{
		$zoomControl		= 'false';
		$zoomControlOptions	= 'SMALL';
	}

	if ($view_type_button)
	{
		$mapTypeControl		= 'true';
	}
	else
	{
		$mapTypeControl		= 'false';
	}

	if ( strlen(trim($get_addr)) == 0 )
	{
		##[ YOON : 2008-10-16 ]###############
		if ( $m_version && $_COOKIE['happy_mobile'] == "on" ) //모바일모드
		{
			$googlemap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:100%; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:13px; font-weight:bold; letter-spacing:-1px;'>지도정보를 표시할 수 없습니다.</div></td></tr></table>";
		}
		else //PC모드
		{
			$googlemap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:490px; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:13px; font-weight:bold; letter-spacing:-1px;'>지도정보를 표시할 수 없습니다.</div></td></tr></table>";
		}
	}
	else
	{

		##########################################

		$googlemap	= <<<END

			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=$google_key"></script>
			<script type="text/javascript">

			function initialize()
			{

				var geocoder		= new google.maps.Geocoder();
				var latlng			= geocoder.geocode(
														{address:'$get_addr'},
														function(results, status)
														{
															if ( status == google.maps.GeocoderStatus.OK )
															{
																var myOptions		= {
																						zoom: $default_map_size,
																						center: results[0].geometry.location,
																						mapTypeId: google.maps.MapTypeId.$map_type_out,
																						scrollwheel : false,
																						rotateControl : false,
																						scaleControl : false,
																						streetViewControl : true,
																						mapTypeControl : $mapTypeControl,
																						mapTypeControlOptions : {
																												position : google.maps.ControlPosition.TOP_LEFT,
																												style : google.maps.MapTypeControlStyle.HORIZONTAL_BAR
																						},
																						zoomControl : $zoomControl,
																						zoomControlOptions : {
																												position : google.maps.ControlPosition.TOP_RIGHT,
																												style : google.maps.ZoomControlStyle.$zoomControlOptions
																						}
																};

																happy_map_mapObj	= new google.maps.Map(document.getElementById("$mapDivId"), myOptions);

																happy_map_marker	= new google.maps.Marker(
																						{
																							map:happy_map_mapObj,
																							draggable:false,
																							animation: google.maps.Animation.DROP,
																							position: happy_map_mapObj.getCenter()
																						}
																);


															}
															else
															{
																document.getElementById('$mapDivId').innerHTML	= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:100%; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:14px;'>${get_addr} 지역정보가 존재하지 않아 지도정보를표시할 수 없습니다. 다시 한 번 주소를 확인하여 올바르게 입력하여 주십시오.</div></td></tr></table>";
															}
														}
									);
			}


			</script>
			<div id="$mapDivId" style="width: ${map_width_unit}; height: ${map_height_unit}"></div>
			<script>

				map_load_func = function()
				{
					setTimeout("initialize()",1500);
				}

				var oldonload = window.onload;
				if ( typeof window.onload != 'function' )
				{
					window.onload = map_load_func;
				}
				else
				{
					window.onload = function() {
						oldonload();
						map_load_func();
					}
				}
			</script>

END;
	}

	print $googlemap;

}



###############################################################




##################
## 2010-04-30  Hun  추가  START ##
##################
# 다음지도 : {{다음지도 주소,가로800,세로600,기본확대레벨4,스카이뷰,맵타입사용함,줌버튼사용}}
$daum_map_number	= 0;
function daum_map_call( $get_addr, $map_width, $map_height, $default_map_size, $map_type, $view_map_type='', $view_zoom_button='', $view_icon='')
{
	global $daum_key,$naver_get_addr, $daum_map_test_addr, $daum_map_number,$daum_local_key;

	if($daum_key == '')
	{
		return print "<img src='img/lost_daum_key.jpg' width='100%' height='100%' alt='다음지도키를 입력해주세요.'>";
		exit;
	}

	if($view_icon == '')
	{
		$view_icon = "img/map_here.png";
	}

	$daum_map_number++;

	$get_addr			= preg_replace('/\n/','',$get_addr);
	$map_width			= preg_replace('/\D/','',$map_width);
	$map_height			= preg_replace('/\D/','',$map_height);
	$default_map_size	= preg_replace('/\D/','',$default_map_size);
	$map_type			= preg_replace('/\n/','',$map_type);
	$view_map_type		= preg_replace('/\n/','',$view_map_type);
	$view_zoom_button	= preg_replace('/\n/','',$view_zoom_button);
	$view_icon			= preg_replace('/\n/','',$view_icon);

	$imagehw			= @GetImageSize("$view_icon");
	$view_icon_width	= $imagehw[0];
	$view_icon_height	= $imagehw[1];

	if ($_GET['id'] != "")
	{
		$get_addr			= ( $get_addr == '자동' )?$naver_get_addr:$get_addr;
	}
	else
	{
		$get_addr			= ( $get_addr == '자동' )?$naver_get_addr:$get_addr;
	}
	$get_addr			= $daum_map_test_addr != '' ? $daum_map_test_addr : $get_addr;

	if ( $get_addr == "열람불가" )
	{
		$navermap			= "<table cellspacing='0' cellpadding='0' style=\"width:100%; height:200px; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:11px;'>열람불가</div></td></tr></table>";

		return $navermap;
	}


	if ($_COOKIE['happy_mobile'] != 'on') //모바일아닐때
	{
		$map_width			= $map_width == '' ? '800' : $map_width;
	}
	else
	{
		$map_width			= "";
	}
	$map_height			= $map_height == '' ? '600' : $map_height;
	$default_map_size	= $default_map_size == '' ? '4' : $default_map_size;


	$map_type_out		= 'ROADMAP';
	if ( $map_type == '위성지도' || $map_type == '스카이뷰' )
	{
		$map_type_out	= "HYBRID";
	}

	# 축소/확대 컨트롤러
	if ( $view_zoom_button != '사용안함' && $view_zoom_button != '줌버튼사용안함' )
	{
		$view_zoom_button	= "var zoomControl = new daum.maps.ZoomControl();map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);";
	}
	else
	{
		$view_zoom_button	= '';
	}

	#미니맵
	if ( $view_map_type != '사용안함' && $view_map_type != '맵타입사용안함' )
	{
		$view_map_type		= "var mapTypeControl = new daum.maps.MapTypeControl();map.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);";
	}
	else
	{
		$view_map_type		= '';
	}

	##########################################

	// Daum API -> Kakao API 로 변경 START - 2017-09-01 hong
	$get_addrs			= explode(" ", $get_addr);

	for ( $i=sizeof($get_addrs)-1 ; $i>1 ; $i-- )
	{
		$get_addr_tmp		= '';
		for ( $j=0 ; $j<=$i ; $j++ )
		{
			$get_addr_tmp		.= $get_addrs[$j].' ';
		}

		$data				= getcontent_wgs_daum($get_addr_tmp);
		$xpoint				= getpoint($data,"<y>","</y>");
		$ypoint				= getpoint($data,"<x>","</x>");
		$xpoint				= $xpoint[0];
		$ypoint				= $ypoint[0];

		if ( $xpoint != '' && $ypoint != '' )
		{
			if ( $i != sizeof($get_addrs)-1 )
			{
				$daum_help		= "<div style='border:0px solid red; padding:8px 6px 6px 6px; color:#CCC; font-size:9pt; background-color:#363636' align='center'><font color=white>[ $get_addr ]</font> 지역의 정보가 없어서 <font color=white><b>$get_addr_tmp</b></font>지역을 불러왔습니다.</div>";
				echo $daum_help;
			}
			$get_addr			= $get_addr_tmp;
			break;
		}
	}

	if ( $xpoint == '' || $ypoint == '' )
	{
		global $m_version;

		if ( $m_version && $_COOKIE['happy_mobile'] == "on" ) //모바일모드
		{
			$daummap			= "<table cellspacing='0' cellpadding='0' style=\"${map_width}px; height:${map_height}px; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center'><div style='width:300px; text-align:center; color:#FFF; font-family:맑은 고딕; font-size:14px;'>${get_addr} 지역정보가 존재하지 않아 지도정보를표시할 수 없습니다. 다시 한 번 주소를 확인하여 올바르게 입력하여 주십시오.</div></td></tr></table>";
		}
		else //PC모드
		{
			$daummap			= "<table cellspacing='0' cellpadding='0' style=\"width:${map_width}px; height:${map_height}px; background:url('../img/bg_nomap.jpg') center;\"><tr><td align='center' style='text-align:center; color:#FFF; font-family:맑은 고딕; font-size:14px; line-height:18px;'>${get_addr} 지역정보가 존재하지 않아 지도정보를표시할 수 없습니다. <br>다시 한 번 주소를 확인하여 올바르게 입력하여 주십시오.</td></tr></table>";
		}
	}
	else
	{
		$daummap	= <<<END
		<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=${daum_key}" charset="utf-8"></script>
		<div id="happy_daum_map_${daum_map_number}" style="width:${map_width}px; height:${map_height}px;"></div>
		<script type="text/javascript">

			var daumMap${daum_map_number}			= '';
			var daumIcon${daum_map_number}			= '';

			var daum_map_start${daum_map_number} = function daum_map_start${daum_map_number}()
			{
				var map =  new daum.maps.Map(document.getElementById('happy_daum_map_${daum_map_number}'), {
					center: new daum.maps.LatLng($xpoint, $ypoint),
					level : $default_map_size,
					mapTypeId: daum.maps.MapTypeId.{$map_type_out},
					scrollwheel: false
				});

				$view_zoom_button
				$view_map_type

				var icon = new daum.maps.MarkerImage(
					'$view_icon',new daum.maps.Size(21, 24),new daum.maps.Point(16,34),"poly","1,20,1,9,5,2,10,0,21,0,27,3,30,9,30,20,17,33,14,33"
				);

				var marker = new daum.maps.Marker({position: new daum.maps.LatLng($xpoint, $ypoint),image: icon});
				marker.setMap(map);

				map.panBy(0, 1);
				map.panBy(0, -1);
			}

			var	oldonload =	window.onload;
			if ( typeof	window.onload != 'function'	)
			{
				window.onload =	function() { daum_map_start${daum_map_number}(); }
			}
			else
			{
				window.onload =	function() {
					oldonload();
					daum_map_start${daum_map_number}();
				}
			}


		</script>

END;
	}
	// Daum API -> Kakao API 로 변경 END - 2017-09-01 hong

	print $daummap;
}




function getcontent_wgs_daum($get_addr)
{
	global $daum_local_key;

	$address		= urlencode(trim($get_addr));

	// Daum API -> Kakao API 로 변경 START - 2017-09-01 hong
	// API : https://developers.kakao.com/docs/restapi/local#주소-검색
	$curl_url	= "https://dapi.kakao.com/v2/local/search/address.xml?query=".$address;
	$curl_header= Array(
						"Host: dapi.kakao.com",
						"User-Agent: curl/7.43.0",
						"Accept: */*",
						"Content-Type: application/xml",
						"Authorization: KakaoAK {$daum_local_key}"
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $curl_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
	$cont = curl_exec($ch);
	curl_close($ch);

	return $cont;
}


#################################################################


	#################################
	function happy_banner( $name , $type, $orderby )
	{
		global $banner_no_banner_img, $happy_banner_tb, $happy_banner_log_tb;

		$banner_no_banner_img	= $banner_no_banner_img == "" ? "img/no_banner.gif" : $banner_no_banner_img;



		switch ( $type )
		{
			case "그룹명" :		$WHERE	= "WHERE groupid = '$name' ";break;
			case "배너제목" :	$WHERE	= "WHERE title = '$name' ";break;
			case "배너형식" :	$WHERE	= "WHERE mode = '$name' ";break;
			case "가로사이즈" :	$WHERE	= "WHERE width='$name' ";break;
			case "세로사이즈" :	$WHERE	= "WHERE height='$name' ";break;
			case "사이즈" :		$names	= explode("x",$name);
								$WHERE	= "WHERE width='$names[0]' AND height='$names[1]' ";break;
			case "전체" :		$WHERE	= "";break;
			default :			$WHERE	= "";break;
		}


		if ( $WHERE == '' )
		{
			$WHERE = " WHERE display = 'Y' and ( now() between startdate and enddate ) ";
		}
		else
		{
			$WHERE .= " AND display = 'Y' and ( now() between startdate and enddate ) ";
		}



		switch( $orderby )
		{
			case "랜덤" :		$ORDER	= "ORDER BY rand()";break;
			case "노출수" :		$ORDER	= "ORDER BY viewcount asc";break;
			case "클릭수" :		$ORDER	= "ORDER BY linkcount asc";break;
			default :			$ORDER	= "";break;
		}


		#number값 추출
		$Sql	= "SELECT number FROM $happy_banner_tb $WHERE $ORDER LIMIT 1";
		//echo $Sql;

		$Tmp	= happy_mysql_fetch_array(query($Sql));
		$number	= $Tmp['number'];



		#추출된 넘버값으로 배너 호출
		$Sql	= "SELECT * FROM $happy_banner_tb WHERE number='$number'";
		$Data	= happy_mysql_fetch_array(query($Sql));

		#print_r2($Data);
		$Data['link']	= str_replace(' ','',$Data['link']);

		if ( $Data['link'] != '' )
		{
			$link	= "banner_link.php?number=$number";
			if ( $Data['linkTarget'] == '' )
			{
				$linkScript	= "onClick=\"window.location.href = '$link'\" style='cursor:pointer'";
			}
			else if ( $Data['linkTarget'] == 'window' )
			{
				$linkScript	= "onClick=\"window.open('$link')\" style='cursor:pointer' ";
			}
		}


		if ( $Data['mode'] == 'html' )
		{
			$content	= $Data['content'];

			#로고쌓기
			$date	= date("Y-m-d");
			$nTime	= date("H");
			$dates	= explode("-",$date);
			$group	= $Data['groupid'];

			$Sql	= "SELECT count(number) FROM $happy_banner_log_tb WHERE regdate='$date' AND nTime='$nTime' AND bannerID = '$number'";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			if ( $Tmp[0] == 0 )
			{
				$Sql	= "
							INSERT INTO
									$happy_banner_log_tb
							SET
									bannerID	= '$number',
									groupID		= '$group',
									regdate		= '$date',
									year		= '$dates[0]',
									month		= '$dates[1]',
									day			= '$dates[2]',
									nTime		= '$nTime',
									viewcount	= '1',
									linkcount	= '0'
				";
			}
			else
			{
				$Sql	= "
							UPDATE
									$happy_banner_log_tb
							SET
									viewcount	= viewcount + 1
							WHERE
									regdate		= '$date'
									AND
									nTime		= '$nTime'
									AND
									bannerID	= '$number'
				";
			}
			query($Sql);

			#해당배너 정보 업그레이드
			query("UPDATE $happy_banner_tb SET viewcount=viewcount+1, viewdate=now() WHERE number='$number'");

			return "<table $linkScript ><tr><td>".$content."</td></tr></table>";

		}
		else if ( $Data['mode'] == 'image' )
		{

			$width		= $Data['width'];
			$height		= $Data['height'];
			$width_out	= $width == "0" ? "" : "width='$width'";
			$height_out	= $height == "0" ? "" : "height='$height'";


			$pngClass	= ( strpos($Data['img'],"png") )?" class='png24' ":"";
			return "<img src='banner_view.php?number=$number' $width_out $height_out border=0 align='absmiddle' $linkScript $pngClass >";
		}
		else if ( $Data['mode'] == 'flash' )
		{
			$width		= $Data['width'];
			$height		= $Data['height'];

			#해당배너 정보 업그레이드
			query("UPDATE $happy_banner_tb SET viewcount=viewcount+1, viewdate=now() WHERE number='$number'");

			#로고쌓기
			$date	= date("Y-m-d");
			$nTime	= date("H");
			$dates	= explode("-",$date);
			$group	= $Data['groupid'];

			$Sql	= "SELECT count(number) FROM $happy_banner_log_tb WHERE regdate='$date' AND nTime='$nTime' AND bannerID = '$number'";
			$Tmp	= happy_mysql_fetch_array(query($Sql));

			if ( $Tmp[0] == 0 )
			{
				$Sql	= "
							INSERT INTO
									$happy_banner_log_tb
							SET
									bannerID	= '$number',
									groupID		= '$group',
									regdate		= '$date',
									year		= '$dates[0]',
									month		= '$dates[1]',
									day			= '$dates[2]',
									nTime		= '$nTime',
									viewcount	= '1',
									linkcount	= '0'
				";
			}
			else
			{
				$Sql	= "
							UPDATE
									$happy_banner_log_tb
							SET
									viewcount	= viewcount + 1
							WHERE
									regdate		= '$date'
									AND
									nTime		= '$nTime'
									AND
									bannerID	= '$number'
				";
			}
			#echo $Sql;

			query($Sql);

			echo "<script language=javascript>FlashMainbody('$Data[img]','$width','$height','Transparent');</script>";

			#echo "<script>FlashMainbody('banner_view.php?number=$number','$width','$height');</script>";
		}


	}
	#################################

function print_r2($var)
{
	ob_start();
	print_r($var);
	$str = ob_get_contents();
	ob_end_clean();
	$str = preg_replace("/ /", "&nbsp;", $str);
	echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
}


function happy_thumb($DST_W,$DST_H,$create_num,$source_file,$img_url_re,$picture_quality,$pic_type="png") {

	global $org_path;
	global $thumb_type;

	//이미지 사이즈를 구하고
	$imagehw = GetImageSize("$source_file");
	//소스파일의 가로
	$src_width = $imagehw[0];
	//소스파일의 세로
	$src_height = $imagehw[1];

	if ( $thumb_type == "0")
	{
		//정해진 비율유지(기존에 사용하던대로) - 찌그러지는것을 방지 남는 부분은 잘라버림

		for ( $i = 0; $i < $create_num; $i++ )
		{
			//$src_h 가 변해야 이미지가 세로가 잘린다.

			//비율	=	목적가로 / 원본가로
			$rate[$i] = $DST_W[$i] / $src_width;
			$src_w[$i] = $src_width;
			//원본세로 = 목적세로 / 비율
			$src_h[$i] = $DST_H[$i] / $rate[$i];
		}

	}
	elseif ( $thumb_type == "1" )
	{
		//원본 이미지를 그대로 축소또는 확대 - 이미지가 찌그러짐

		for ( $i = 0; $i < $create_num; $i++ )
		{
			$src_w[$i] = $src_width;
			$src_h[$i] = $src_height;
		}
	}
	elseif ( $thumb_type == "2" )
	{
		//세로를 정해놓고 가로가 늘었다 줄었다 한다
		//$DST_W 가 변해야 이미지가 세로는 유지하고 가로폭이 늘었다 줄었다 한다.
		for ( $i = 0 ; $i < $create_num; $i++ )
		{
			$src_w[$i] = $src_width;
			$src_h[$i] = $src_height;

			//원본의 비율
			$rate[$i] =$src_h[$i] / $src_w[$i];

			//직접 가로세로의 크기를 구한다.
			$DST_W_TMP[$i] = $DST_W[$i] / $rate[$i];
			$DST_H_TMP[$i] = $DST_H[$i] / $rate[$i];

			if ( $rate[$i] < 1 )
			{
				//가로가 긴 이미지
				$DST_W_TMP2[$i] = ($DST_H_TMP[$i] * $src_w[$i] / $src_h[$i]) * $rate[$i];
				$DST_W[$i] = $DST_W_TMP2[$i];
				$DST_H[$i] = $DST_H[$i];
			}
			else
			{
				//세로가 긴 이미지
				$DST_W_TMP2[$i] = ($DST_H_TMP[$i] * $src_w[$i] / $src_h[$i]) * $rate[$i];
				$DST_W[$i] = $DST_W_TMP2[$i];
				$DST_H[$i] = $DST_H[$i];
			}
		}
	}
	elseif ( $thumb_type == "3" )
	{
		//기존의 해피썸은 세로를 정해놓고 가로가 왔다갔다 하는 형태고
		//세로가 왔다갔다
		//$DST_W 가 변해야 이미지가 세로는 유지하고 가로폭이 늘었다 줄었다 한다.
		for ( $i = 0 ; $i < $create_num; $i++ )
		{
			$src_w[$i] = $src_width;
			$src_h[$i] = $src_height;

			//원본의 비율
			$rate[$i] = ($src_h[$i] / $src_w[$i]);

			//직접 가로세로의 크기를 구한다.
			$DST_W_TMP[$i] = ($DST_W[$i] / $rate[$i]);
			$DST_H_TMP[$i] = ($DST_H[$i] / $rate[$i]);

			if ( $rate[$i] < 1 )
			{
				//가로가 세로보다 긴 이미지는 가로는 목적의가로 세로는 가로비율에 맞게 조절
				$DST_W[$i] = $DST_W[$i];
				$DST_H_TMP2[$i] = ($DST_W_TMP[$i] * $src_h[$i] / $src_w[$i]) * $rate[$i];
				$DST_H[$i] = $DST_H_TMP2[$i];
			}
			elseif ($rate[$i] > 1 )
			{
				//세로가 가로보다 긴 이미지는 가로는 목적의가로 세로는 가로비율에 맞게 조절
				$DST_W[$i] = $DST_W[$i];
				$DST_H_TMP2[$i] = ($DST_W_TMP[$i] * $src_h[$i] / $src_w[$i]) * $rate[$i];
				/*
				echo "($DST_W_TMP[$i] * $src_h[$i] / $src_w[$i]) * $rate[$i]<br>";
				echo $DST_H_TMP2[$i]."<br>";
				if ($i=="1") exit;
				*/
				$DST_H[$i] = $DST_H_TMP2[$i];

			}
			elseif ($rate[$i] == 1)
			{
				//정사각형인 이미지는 목적의가로크기로 세로를 조절
				$DST_W[$i] = $DST_W_TMP[$i];
				$DST_H[$i] = $DST_W_TMP[$i];
				/*
				echo "DST_W[$i] = $DST_W[$i]<br>";
				echo "DST_H[$i] = $DST_H[$i]<br>";
				*/
			}
		}
	}
	elseif ( $thumb_type == "4" )
	{
		//캔버스는 고정사이즈
		//합성할 이미지는 가로세로 다 줄여서
		//그 캔버스 안에 들어가도록

		for ( $i = 0 ; $i < $create_num; $i++ )
		{
			$src_w[$i] = $src_width;
			$src_h[$i] = $src_height;

			//원본의 비율
			$rate[$i] = ( $src_h[$i] / $src_w[$i] );
			//echo "$rate[$i] = ( $src_w[$i] / $src_h[$i] );";

			$CANVAS_W[$i] = $DST_W[$i];
			$CANVAS_H[$i] = $DST_H[$i];

			if ( $rate[$i] < 1 )
			{
				//가로가 긴이미지
				//축소/확대 되는 비율
				$rate2[$i] = ($DST_W[$i] / $src_w[$i]);
				$DST_W[$i] = $DST_W[$i];
				$DST_H[$i] = $src_h[$i] * $rate2[$i];

				//줄인게 캔버스에 안들어갈 경우 가로세로를 새로 구하자
				if ($DST_H[$i] > $CANVAS_H[$i])
				{
					$DST_H[$i] = $CANVAS_H[$i];
					$rate2[$i] = ($DST_H[$i] / $src_h[$i]);
					$DST_W[$i] = $src_w[$i] * $rate2[$i];
				}
			}
			elseif ($rate[$i] > 1 )
			{
				//세로가 긴 이미지
				//축소/확대 되는 비율
				$DST_H[$i] = $CANVAS_H[$i];
				$rate2[$i] = ($DST_H[$i] / $src_h[$i]);
				$DST_W[$i] = $src_w[$i] * $rate2[$i];
			}
			elseif ($rate[$i] == 1)
			{
				//정사각형 이미지
				$DST_W[$i] = ($DST_H[$i] * $src_w[$i] / $src_h[$i]);
				$DST_H[$i] = ($DST_W[$i] * $src_h[$i] / $src_w[$i]);
			}

			/*
			echo "비율 : ".$rate[$i]."<hr>";
			echo "원본가로 : ".$src_w[$i]."<hr>";
			echo "원본세로 : ".$src_h[$i]."<hr>";

			echo "목적가로 : ".$DST_W[$i]."<hr>";
			echo "목적세로 : ".$DST_H[$i]."<hr>";
			*/
			//exit;
		}
	}

	/*
	//로고 만들기 가로/세로를 구해서
	$logo = ImageCreateFromPng("$org_path/img/logo/my_logo.png");
	$logo_width = imagesx($logo);
	$logo_height = imagesy($logo);
	*/

	//원본이미지를 가지고
	$src = ImageCreateFromJPEG("$source_file");

	for ( $i = 0; $i < $create_num; $i++ )
	{
		//캔버스 만들고
		if ($thumb_type != "4")
		{
			$thumb[$i] = ImageCreate($DST_W[$i],$DST_H[$i]);
			$thumb[$i] = imagecreatetruecolor($DST_W[$i],$DST_H[$i]);
			//섬네일 생성
			imagecopyresampled($thumb[$i],$src,0,0,0,0,$DST_W[$i],$DST_H[$i],$src_w[$i],$src_h[$i]);
			//까만부분 하얀색으로 채우고
			$r_y = $imagehw[1] * $DST_H[$i] / $src_h[$i];		//흰색 칠 시작 할 y값
			$white = imagecolorallocate($thumb[$i], 255, 255, 255);
			imagefilledrectangle ($thumb[$i],0,$r_y,$DST_W[$i],$DST_H[$i],$white);
		}
		else
		{
			$thumb[$i] = ImageCreate($CANVAS_W[$i],$CANVAS_H[$i]);
			$thumb[$i] = imagecreatetruecolor($CANVAS_W[$i],$CANVAS_H[$i]);
			$x_center = ($CANVAS_W[$i] / 2) - ($DST_W[$i] /2);
			$y_center = ($CANVAS_H[$i] / 2) - ($DST_H[$i] /2);

			$white = imagecolorallocate($thumb[$i], 255, 255, 255);
			imagefilledrectangle ($thumb[$i],0,0,$CANVAS_W[$i],$CANVAS_H[$i],$white);

			//섬네일 생성
			imagecopyresampled($thumb[$i],$src,$x_center,$y_center,0,0,$DST_W[$i],$DST_H[$i],$src_w[$i],$src_h[$i]);
		}

		/*
		$logo_h = $DST_H[$i]-$logo_height;

		//로고합성
		if ( $i == "0" )  {
			imagecopy($thumb[$i],$logo,0,$logo_h,0,0,$logo_width,$logo_height);
		}
		*/

		//최종결과물 완성
		if ( $pic_type == "jpg" )
		{
			ImageJPEG($thumb[$i],"$img_url_re[$i]",$picture_quality);
		}
		else if ( $pic_type == "png" )
		{
			/*imagepng()함수 PHP5 패치 by kwak16*/$phpver=phpversion();$phpver=$phpver[0];$picture_quality = ($picture_quality>9&&$phpver>4)?round($picture_quality/11):$picture_quality; ImagePNG($thumb[$i],"$img_url_re[$i]",$picture_quality);
		}

		//echo $img_url_re[$i]."<br>";

		//필요없는 것들 메모리 해제
		ImageDestroy($thumb[$i]);

	}
	//로고 + 원본 도 메모리 해제
	//ImageDestroy($logo);
	ImageDestroy($src);
}

//개인회원 기업회원 마이페이지 변수 초기화
function init_member_variable($id) {

	global $guin_tb;
	global $com_want_doc_tb;
	global $com_guin_per_tb;

	global $per_document_tb;
	global $com_guin_per_tb;

	global $per_want_doc_tb;

	#이력서 보기기간뽑아내기 위해
	global $real_gap;
	global $scrap_tb;
	global $happy_member_option_type;
	global $job_per_want_search;


	#echo $real_gap;

	//채용정보등록수
	$sql = "select count(*) as guin_total_cnt from $guin_tb where guin_id = '$id'";
	$result = query($sql);
	$ROW = happy_mysql_fetch_assoc($result);

	//진행중인수
	$sql = "select count(*) as ing_cnt from $guin_tb where guin_id = '$id' and (guin_end_date >= curdate() or guin_choongwon ='1')";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	//마감된수
	$sql = "select count(*) as magam_cnt from $guin_tb where guin_id = '$id' and guin_end_date < curdate() and guin_choongwon !='1'";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	//입사제의요청건수
	$sql = "SELECT count(*) as req_cnt FROM $guin_tb AS A INNER JOIN $com_want_doc_tb AS B ON A.number = B.guin_number WHERE B.com_id = '$id' AND ( A.guin_end_date >= curdate() OR A.guin_choongwon ='1' ) ";

	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);

	$ROW = array_merge($ROW,$ROW2);

	//채용신청건
	$sql = "select count(*) as jiwon_cnt from $com_guin_per_tb as A LEFT JOIN $guin_tb as B ON A.cNumber= B.number LEFT JOIN $per_document_tb AS C on A.pNumber = C.number where A.com_id = '$id' AND (B.guin_end_date >= curdate() or B.guin_choongwon ='1') and C.display = 'Y'";
	//$sql = "select count(*) as scrap_cnt from $scrap_tb as A LEFT JOIN $per_document_tb AS B on A.pNumber = B.number where userid = '$id' AND cNumber = '0' and B.display = 'Y' ";
	//echo $sql;
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);


	#이력서 보기 기간 : guin_docview
	#이력서 보기 회수 : guin_docview2
	#채용정보 보기 기간 : guzic_view
	#채용정보 보기 회수 : guzic_view2
	#SMS전송회수 기업용 : guin_smspoint
	#SMS전송회수 개인용 : guzic_smspoint

	$tmp_array = array("guin_docview","guin_docview2","guzic_view","guzic_view2","guin_smspoint","guzic_smspoint");
	$tmp_value = happy_member_option_get_array($happy_member_option_type,$id,$tmp_array);

	//$ROW2 = array();
	$ROW2['docview_period'] = $tmp_value['guin_docview'];
	$ROW2['docview_count'] = $tmp_value['guin_docview2'];
	$ROW2['guinview_period'] = $tmp_value['guzic_view'];
	$ROW2['guinview_count'] = $tmp_value['guzic_view2'];
	$ROW2['smspoint'] = $tmp_value['guin_smspoint'];

	//SMS전송회수 개인용
	$ROW2['guzic_smspoint'] = $tmp_value['guzic_smspoint'];

	$temp_p = $ROW2["docview_period"];
	$ROW2["docview_period"] = $ROW2["docview_period"] - $real_gap;
	$ROW2['guinview_period'] = $ROW2['guinview_period'] - $real_gap;

	if ($ROW2["docview_period"] < 0)
	{
		$ROW2["docview_period"] = 0;
		$ROW2["docview_period_date"] = "결제요망";
	}
	else
	{
		$ROW2["docview_period_date"] = date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")+$ROW2["docview_period"],date("Y")));
	}

	if ($ROW2["guinview_period"] < 0)
	{
		$ROW2["guinview_period"] = 0;
		$ROW2["guinview_period_date"] = "결제요망";
	}
	else
	{
		$ROW2["guinview_period_date"] = date("Y-m-d",happy_mktime(0,0,0,date("m"),date("d")+$ROW2["guinview_period"],date("Y")));
	}
	$ROW = array_merge($ROW,$ROW2);



	#일반스크랩한 이력서 개수
	$sql = "select count(*) as scrap_cnt1 from $per_document_tb AS A INNER JOIN $scrap_tb AS B ON A.number = B.pNumber WHERE B.cNumber = '0' AND A.display = 'Y' AND B.userid='$id'";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	#채용정보 선택해서 스크랩한 개수
	//$sql = "select count(*) as scrap_cnt from $scrap_tb where userid = '$id' ";

	$sql = "select count(*) as scrap_cnt2 from $scrap_tb where userid = '$id' and cNumber != 0 and pNumber is not null ";
	//echo $sql;
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	//이력서등록수
	$sql = "select count(*) as guzic_total_cnt from $per_document_tb where user_id = '$id'";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	//사용중인이력서
	$sql = "select count(*) as use_cnt from $per_document_tb where user_id = '$id' and display='Y' ";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	//대기중인이력서
	$sql = "select count(*) as wait_cnt from $per_document_tb where user_id = '$id' and display='N' ";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	//입사지원건수
	$sql = "SELECT count(*) as req_cnt_per FROM $guin_tb AS A INNER JOIN $com_want_doc_tb AS B ON A.number = B.guin_number WHERE B.per_id = '$id' AND ( A.guin_end_date >= curdate() OR A.guin_choongwon ='1' ) ";
	//echo $sql;
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	//채용신청한건수
	$sql = "SELECT count(*) as jiwon_cnt_per FROM $per_document_tb AS A INNER JOIN $com_guin_per_tb AS B ON A.number = B.pNumber INNER JOIN $guin_tb as C ON B.cNumber = C.number WHERE A.display = 'Y' AND B.per_id='$id' ";
	//echo $sql;
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);

	//이력서열람기업
	$sql = "SELECT SUM(viewListCount) as view_cnt FROM $per_document_tb WHERE user_id='$id' ";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);
	$ROW['view_cnt'] = number_format($ROW['view_cnt']);

	//면접제의 인재
	//$sql = "SELECT count(*) as interview_cnt FROM $per_want_doc_tb WHERE com_id='$id' ";
	$sql = "SELECT * FROM $guin_tb AS A INNER JOIN $per_want_doc_tb AS B ON A.number = B.guin_number WHERE B.com_id='$id' AND ( A.guin_end_date >= curdate() OR A.guin_choongwon ='1' ) GROUP BY A.number";
	$result = query($sql);
	$ROW2 = mysql_num_rows($result);
	//$ROW = array_merge($ROW,$ROW2);
	$ROW['interview_cnt'] = $ROW2;
	//$ROW['interview_cnt'] = number_format($ROW['interview_cnt']);

	//면접제의 인재
	//$sql = "SELECT count(*) as interview_cnt FROM $per_want_doc_tb WHERE com_id='$id' ";
	$sql = "SELECT * FROM $guin_tb AS A INNER JOIN $per_want_doc_tb AS B ON A.number = B.guin_number WHERE B.per_id='$id' AND ( A.guin_end_date >= curdate() OR A.guin_choongwon ='1' ) GROUP BY A.number";
	$result = query($sql);
	$ROW2 = mysql_num_rows($result);
	//$ROW = array_merge($ROW,$ROW2);
	$ROW['interview_cnt_per'] = $ROW2;
	//$ROW['interview_cnt_per'] = number_format($ROW['interview_cnt_per']);

	//ONLINE 입사지원
	//$sql = "SELECT count(*) as online_cnt FROM $com_guin_per_tb WHERE per_id='$id' AND online_stats=1 ";
	$sql = "SELECT count(*) as online_cnt FROM $per_document_tb AS A INNER JOIN $com_guin_per_tb AS B ON A.number = B.pNumber INNER JOIN $guin_tb as C ON B.cNumber = C.number WHERE A.display = 'Y' AND B.per_id='$id' AND B.online_stats=1 ";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);
	$ROW['online_cnt'] = number_format($ROW['online_cnt']);

	//EMAIL 입사지원
	//$sql = "SELECT COUNT(A.number) AS email_cnt FROM job_per_document AS A INNER JOIN job_com_guin_per AS B ON A.number = B.pNumber WHERE B.per_id='$id' AND B.email_stats = 1 ";
	$sql = "SELECT count(*) as email_cnt FROM $per_document_tb AS A INNER JOIN $com_guin_per_tb AS B ON A.number = B.pNumber INNER JOIN $guin_tb as C ON B.cNumber = C.number WHERE A.display = 'Y' AND B.per_id='$id' AND B.email_stats=1 ";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);
	$ROW['email_cnt'] = number_format($ROW['email_cnt']);

	//신입채용정보
	$sql = "SELECT count(*) as new_cnt FROM $guin_tb WHERE guin_career='신입' ";
	$result = query($sql);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);
	$ROW['new_cnt'] = number_format($ROW['new_cnt']);

	//맞춤채용정보
	$sql = "select * from ".$job_per_want_search." where id = '".$id."'";
	$result = query($sql);
	$WantSearchGuin = happy_mysql_fetch_assoc($result);

	if ( $WantSearchGuin['query_str'] == "" )
	{
		$WantSearchGuin['query_str'] = " 1=2 ";
	}
	$last_query =" where ".$WantSearchGuin['query_str']." ";

	$sql1 = "select count(*) as want1_cnt from   $guin_tb $last_query  ";
	$result = query($sql1);
	$ROW2 = happy_mysql_fetch_assoc($result);
	$ROW = array_merge($ROW,$ROW2);
	$ROW['want1_cnt'] = number_format($ROW['want1_cnt']);


	//print_r2($ROW);

	return $ROW;

}


#메일 보내기 함수 ( 보내는사람 , 받는사람 , 메일제목, 메일내용)
function sendmail($from , $to , $subject, $content) {

	global $site_name;

	//메일 함수 통합 - hong
	HappyMail($site_name, $from,$to,$subject,$content);

	return true;

}

#메인플래시배너
function main_flash(){
	global $CONF;
	//print_r2($BANNER);

	$main_flash_banner .= <<<END

	<script>FlashXmlbody('flash_swf/ex-banner.swf','$CONF[banner_size_width]','$CONF[banner_size_height]', 'Transparent');</script>
END;


	return $main_flash_banner;
}

#팝업창
function call_popup ( $category , $layerColor="" , $call_action = '' )
{
	global $TPL, $skin_folder, $happy_popup, $popupCloseCookieDate, $popupCloseCookieMsg,$popupLinkTypeValue, $Popup;
	global $레이어내용, $레이어이름, $가로, $세로, $위쪽여백, $왼쪽여백, $이동스크립트, $폼이름, $cookie_name, $레이어색상;

	$category	= preg_replace('/\n/','',$category);
	$layerColor	= preg_replace('/\n/','',$layerColor);
	$레이어색상	= $layerColor;
	$nowDate	= date("Y-m-d H:i:s");

	#$call_action 종류 : 랜덤,전체 or 공백
	#랜덤이면 해당카테고리의 진행중인 팝업을 랜덤으로 1개만.
	#전체면 여러개뜸

	if ($call_action == '랜덤')
	{
		$order_by_Q = " order by rand() limit 1 ";
	}
	else
	{
		$order_by_Q = " order by number ASC ";
	}

	$Sql	= "
				SELECT
						*
				FROM
						$happy_popup
				WHERE
						category	= '$category'
						AND
						startDate	< '$nowDate'
						AND
						endDate		> '$nowDate'
						AND
						display		= 'Y'
				$order_by_Q
			";

	$Record	= query($Sql);

	echo "
		<script>
			function setCookie( name, value, expiredays )
			{
				var todayDate = new Date();
				todayDate.setDate( todayDate.getDate() + expiredays );
				document.cookie = name + \"=\" + escape( value ) + \"; path=/; expires=\" + todayDate.toGMTString() + \";\"
			}
			function closeWin( cookie_name, formName, layerName )
			{
				if ( document.forms[formName].no_popup.checked )
					setCookie( cookie_name , \"no\" , $popupCloseCookieDate);
				document.all[layerName].style.visibility = 'hidden';
			}

			// 메인페이지 제네레이팅 By Kwak16
			function popupGetCookie(c_name)
			{
				var i,x,y,ARRcookies=document.cookie.split(';');
				for (i=0;i<ARRcookies.length;i++)
				{
					x=ARRcookies[i].substr(0,ARRcookies[i].indexOf('='));
					y=ARRcookies[i].substr(ARRcookies[i].indexOf('=')+1);
					x=x.replace(/^\s+|\s+$/g,'');
					if (x==c_name)
					{
						return unescape(y);
					}
				}
			}

		</script>
	";
	$TPL->define("팝업레이어", "$skin_folder/popup_layer.html");
	while ( $Popup = happy_mysql_fetch_array($Record) )
	{
		$cookie_name	= "happy_popup_".$Popup["number"];

		#if ( $_COOKIE[$cookie_name] != "no" )
			if ( $Popup["openType"] == "P" )
			{
				#$Popup[widthSize]	+= 20;
				#$Popup[heightSize	+= 50;
				/*
				echo "
					<script>
						window.open('popup.php?number=$Popup[number]','hnews4_popup_$Popup[number]','width=$Popup[widthSize],height=$Popup[heightSize],top=$Popup[topSize],left=$Popup[leftSize],toolbar=no,scrolling=no');
					</script>
				";
				*/
				# 메인페이지 제네레이팅 By Kwak16 #
				echo "
						<script>
							if ( popupGetCookie('$cookie_name') != 'no' )
							{
								window.open('popup.php?number=$Popup[number]','hnews4_popup_$Popup[number]','width=$Popup[widthSize],height=$Popup[heightSize],top=$Popup[topSize],left=$Popup[leftSize],toolbar=no,scrolling=no');
							}
						</script>
				";
				# 메인페이지 제네레이팅 By Kwak16 #
			}
			else
			{

				$cookie_name		= "happy_popup_".$Popup["number"];

				$레이어내용				= $Popup["content"];
				$레이어이름			= "hnews4_popup_layer_$Popup[number]";
				$폼이름				= "popup_frm_$Popup[number]";
				$가로				= $Popup["widthSize"];
				$세로				= $Popup["heightSize"];
				$위쪽여백			= $Popup["topSize"];
				$왼쪽여백			= $Popup["leftSize"];
				$closeScript		= "document.all['${레이어이름}'].style.visibility = 'hidden';";

				$linkUrl			= $popupLinkTypeValue[$Popup["linkType"]];

					if ($Popup["openType"] == "L" && $Popup["linkType"] == "부모창" )
					{
						$linkUrl = "location.href='{{linkUrl}}';{{closeScript}}";
					}

				$Popup["linkUrl"]	= str_replace(" ","",$Popup["linkUrl"]);
				if ( $linkUrl != "" && $Popup["linkUrl"] != "" )
				{
					//$Popup["linkUrl"]	= "http://". preg_replace("/http:\/\//i","",$Popup["linkUrl"]);
					$Popup_linkUrl	= parse_url($Popup["linkUrl"]);
					if( $Popup_linkUrl['host'] != '' )
					{
						$Popup["linkUrl"]	= "http://". preg_replace("/http:\/\//i","",$Popup["linkUrl"]);
					}
					$linkUrl	= str_replace("{{linkUrl}}",$Popup["linkUrl"],$linkUrl);
					$linkUrl	= str_replace("{{closeScript}}",$closeScript,$linkUrl);
				}
				else
					$linkUrl	= $closeScript;

				$이동스크립트	= $linkUrl;



				$layer	= &$TPL->fetch();

				echo $layer;
				# 메인페이지 제네레이팅 By Kwak16 #
				echo "
						<script>
							if ( popupGetCookie('$cookie_name') != 'no' )
							{
								document.all['${레이어이름}'].style.visibility = '';
							}
						</script>
				";
				# 메인페이지 제네레이팅 By Kwak16 #
			}
	}
}

#메일링에서 사용하는 셀렉트박스
function make_selectbox3($array_name,$array_value,$mod,$var_name,$select_name,$selOption=""){
	global $font_size,$select_width,$select_color;
	$array_co = count($array_name);

	$selWidth	= ( $selWidth == "" )?$select_width:$selWidth;

	$main_area = "<select name='$var_name' style='font-size:$font_size;' $selOption>";

	if ($mod)
	{
		$main_area .= "<option value=''>$mod</option>";
	}

	for ( $i=0; $i<$array_co; $i++ )
	{
		$array_value[$i] = str_replace("\r","",$array_value[$i]);
		$array_name[$i] = str_replace("\r","",$array_name[$i]);
		if ($array_name[$i])
		{
			if ($select_name == $array_value[$i])
			{
				$main_area .= "<option value='$array_value[$i]' selected style='background-color:$select_color'>$array_name[$i]</option>";
			}
			else
			{
				$main_area .= "<option value='$array_value[$i]'>$array_name[$i]</option>";
			}
		}
	}
	$main_area .= "</select>";
	return $main_area;
}

########################################
#티커구인추출

function ticker_tag_maker() {

	global $ticker_use, $skin_folder, $TPL, $ticker_str;
	global $t_ex_width, $t_ex_height, $career_read;

	$args = func_get_args();
	#print_r2($args);
	$ex_width = preg_replace("/\D/","",$args['2']);
	$ex_height = preg_replace("/\D/","",$args['3']);
	unset($args['2']);
	unset($args['3']);

	$t_ex_width		= $ex_width;
	$t_ex_height	= $ex_height;

	//echo "$t_ex_width, $t_ex_height";

	$d = '1';
	foreach ($args as $list)
	{
		$list = str_replace('#','',$list);
		#한글을 깨야 할 경우 플래시 파일 교체후 인코딩해서 넘겨줘야 함
		#$list = urlencode($list);

		$list = urlencode(urlencode($list));

		$last_var .= "opt".$d."=$list&";
		$d ++;
	}


	$ex_limit		= preg_replace('/\D/', '', $args[0]);
	$ex_width		= preg_replace('/\D/', '', $args[1]);
	$ex_title_cut	= preg_replace('/\D/', '', $args[4]);
	$ex_category1	= preg_replace('/\n/', '', $args[5]);
	$ex_category2	= preg_replace('/\n/', '', $args[6]);
	$ex_area1		= preg_replace('/\n/', '', $args[7]);
	$ex_area2		= preg_replace('/\n/', '', $args[8]);
	$ex_type		= preg_replace('/\n/', '', $args[9]);
	$ex_job_type	= preg_replace('/\n/', '', $args[10]);
	$ex_template	= preg_replace('/\n/', '', $args[11]);
	$order			= $args[12];
	$startLimit		= $args[13];
	$extract_type	= $args[14];
	$ex_guin_career	= $args[15];

	unset($career_read);
	$ticker_use		= true;
	$ticker_sql		= guin_main_extraction
	(
		$ex_limit,
		$ex_width,
		$ex_title_cut,
		$ex_category1,
		$ex_category2,
		$ex_area1,
		$ex_area2,
		$ex_type,
		$ex_job_type,
		$ex_template,
		$order,
		$startLimit,
		$extract_type,
		$ex_guin_career
	);


	$record			= query($ticker_sql);

	//echo "$t_ex_width, $t_ex_height";

	$ticker_color	= "#42a0c2";
	$ticker_size	= "12px";

	$rank_str		= "";
	while ( $rows = happy_mysql_fetch_assoc($record) )
	{
		$rows['guin_title']	= kstrcut($rows['guin_title'], $ex_title_cut, "...");

		$ticker_str			.= "
								<LI style='text-align:left;width:{$t_ex_width}px;'>
									<a href='guin_detail.php?num=$rows[number]' style='color:$ticker_color; font-size:$ticker_size; line-height:{$t_ex_height}px;'>$rows[guin_title]</a>
								</LI>
		";

		$Count++;
	}

	$ticker_use		= false;

	$random			= rand(0,9999);
	$TPL->define("티커구인_$random", "$skin_folder/$ex_template");
	$content		= $TPL->fetch("티커구인_$random");

	print $content;

	//echo $last_var;

	/*
	print <<<END
	<SCRIPT LANGUAGE="JavaScript">FlashMainbody("flash_swf/ticker_guin.swf?${last_var}","$ex_width","$ex_height",'Transparent');</SCRIPT>
END;
	*/

}

#플래시이력서리스트
function flash_guzic_tag_maker()
{
	global $HAPPY_CONFIG;

	$args = func_get_args();
	//print_r2($args);
	#가로사이즈/세로사이즈
	$ex_width = preg_replace("/\D/","",$args['3']);
	$ex_height = preg_replace("/\D/","",$args['4']);

	$d = '1';
	foreach ($args as $list)
	{
		$list = str_replace('#','',$list);
		#한글을 깨야 할 경우 플래시 파일 교체후 인코딩해서 넘겨줘야 함
		#$list = urlencode($list);
		#$list2 = ($list);
		$list = urlencode(urlencode($list));
		$last_var .= "opt".$d."=$list&";
		#$last_var2 .= "opt".$d."=$list2&";

		$d ++;
	}

	#가로개수/세로개수
	$ex_garo = preg_replace("/\D/","",$args[1]);
	$ex_sero = preg_replace("/\D/","",$args[2]);

	#(int(Width+int(imggap*2))+int(centergap))*int(wcount) : 가로
	#(int(Height+HeightPlus)+int(centergap)) : 세로 HeightPlus = 45
	#$imggap = 3;
	#$centergap = 5;
	$centergap = $HAPPY_CONFIG['FlashGuZicCenterGap'];
	$imggap = $HAPPY_CONFIG['FlashGuZicImgGap'];
	$HeightPlus = 45;

	$ex_width = ( $ex_width + ( $imggap*2 ) + $centergap )* $ex_garo + 22;
	$ex_height = ( $ex_height + $HeightPlus + $centergap ) * $ex_sero;

	print <<<END
	<SCRIPT LANGUAGE="JavaScript">FlashMainbody("flash_swf/flash_tiker_guzic.swf?${last_var}","$ex_width","$ex_height",'Transparent');</SCRIPT>
END;
}




##############################################################


	#아이콘 생성 함수
	function news_icon_maker( $where='', $order='', $limit='', $folder='', $number='' )
	{
		global $happy_menu_conf, $happy_icon_list;
		global $skin_icon_maker_folder, $auto_skin_update;

		$sfolder	= ( $auto_skin_update == "1" )?"":"../";

		$skin_icon_maker_folder_tmp	= $skin_icon_maker_folder . $folder;

		if ( $number != '' )
		{
			$addwhere	= " WHERE number='$number' ";
		}
		else
		{
			$addwhere	= "  ";
		}

		$Sql		= "SELECT type, conf_bgcolor FROM $happy_menu_conf $addwhere ORDER BY number DESC ";
		$MenuRec	= query($Sql);

		while ( $MenuConf = happy_mysql_fetch_array($MenuRec) )
		{
			$MenuRecType	= $MenuConf['type'];
			if ( $MenuConf['type'] == '' )
			{
				$MenuRecType	= 'happy_default';
			}
			$bgcolor[$MenuRecType]	= $MenuConf['conf_bgcolor'];
			#echo $MenuRec['type']."<hr>";
		}
		#$bgcolor	= $MenuConf['conf_bgcolor'];
		#print_r($bgcolor);

		if ( $where != '' )
		{
			$WHERE	= " WHERE $where ";
		}

		if ( $order != '' )
		{
			$ORDER	= " ORDER BY $order ";
		}

		if ( $limit != '' )
		{
			$LIMIT	= " LIMIT $limit ";
		}

		$Sql	= "SELECT * FROM $happy_icon_list $WHERE $ORDER $LIMIT ";
		$Record	= query($Sql);







		while ( $ICON = happy_mysql_fetch_array($Record) )
		{
			$bg	= ( $ICON['group'] == '' )? $bgcolor['happy_default'] : $bgcolor[$ICON['group']];

			#echo $ICON['group'] ." - ".$bg."<br>";

			#색상코드 10진수로 변경
			$bgcolor_r	= hexdec(substr($bg, 1, 2));
			$bgcolor_g	= hexdec(substr($bg, 3, 2));
			$bgcolor_b	= hexdec(substr($bg, 5, 2));

			#PNG 사이즈 확인
			$imagehw		= GetImageSize($sfolder.$ICON['icon_png_file']);
			$imagewidth		= $imagehw[0];
			$imageheight	= $imagehw[1];
			#echo " $imagewidth * $imageheight <br>";


			#배경잡고
			$thumb			= ImageCreate($ICON['icon_width'],$ICON['icon_height']);
			$thumb			= imagecreatetruecolor($ICON['icon_width'],$ICON['icon_height']);
			$white			= imagecolorallocatealpha($thumb, $bgcolor_r, $bgcolor_g, $bgcolor_b,0);
			imagefilledrectangle ($thumb,0,0,$ICON['icon_width'],$ICON['icon_height'],$white);


			$src			= ImageCreateFromPng($sfolder.$ICON['icon_png_file']);
			imagecopyresampled($thumb,$src,0,0,0,0,$ICON['icon_width'],$ICON['icon_height'],imagesx($src),imagesy($src));
			imagecopy($thumb,$src,0,0,0,0,$imagewidth,$imageheight);

			#일단 쪼끄만거부터 맹글자
			$skin_icon_make	= "$skin_icon_maker_folder_tmp/skin_icon_$ICON[number].jpg";
			#특정색상투명하게
			$white = imagecolorallocate($thumb, 0, 255, 26);
			imagecolortransparent($thumb, $white);
			#ImageJPEG($thumb,"${sfolder}$skin_icon_make",100);
			/*imagepng()함수 PHP5 패치 by kwak16*/
			$phpver    =phpversion();
			$phpver    =$phpver[0];
			$picture_quality = ( $picture_quality > 9 && $phpver > 4 ) ? round( $picture_quality /11 ) : $picture_quality;
			ImagePNG($thumb,"${sfolder}$skin_icon_make",$picture_quality);


			if ( $number == '' )
			{
				$Sql	= "UPDATE $happy_icon_list SET icon_jpg_file='$skin_icon_make' WHERE number='$ICON[number]' ";
				query($Sql);
			}

			ImageDestroy($src);
			ImageDestroy($thumb);
		}

	}




##############################################################



#{{미니앨범출력 145,200}}
function mini_album_view($album_width,$album_height='')//jobwork
{
	global $skin_folder,$per_file_tb,$Data2;

	global $doc_mini_album_use;

	if ( $doc_mini_album_use != '1' )
	{
		return;
	}

	$album_width = preg_replace('/\D/', '', $album_width);
	$album_height = preg_replace('/\D/', '', $album_height);

	$sql = "select * from $per_file_tb where doc_number = '$_GET[number]' order by number asc limit 5 ";
	//echo $sql;

	$result = query($sql);

	$mini_preview = '<table cellspacing=0 cellpadding=0 width=100%><tr>';
	$TPL2 = new Template;
	$TPL2->define("mini_album1", "$skin_folder/output_model_mini.html");
	$Count = 0;
	while ($Data2 = happy_mysql_fetch_array($result))
	{
		$Data2[fileName_info] = str_replace("((thumb_name))",'',$Data2[fileName]);

		$Data2[fileName_info] = happy_image('Data2.fileName_info',$album_width,$album_height,'로고사용안함','로고위치7번','퀄리티100','gif원본출력','img/document_no_img.jpg','비율대로확대','2');

		$Data2['album_width'] = $album_width;
		if ( $album_height != '' )
		{
			$Data2['album_height'] = "height='$album_height'";

		}

		$main_new = $TPL2->fetch("mini_album1");
		$mini_preview .= "<td valign='top'>$main_new</td>";
		$Count++;
	}

	for ( $i = $Count; $i < 5; $i++ )//빈이미지 넣자
	{
		$mini_preview .= "<td valign='top' align='center'><img src='img/document_no_img.jpg' width='$album_width' height='$album_height' /></td>";
	}

	$mini_preview .= "</tr></table>";


	$미니앨범출력	= "	$mini_preview";

	//$TPL->assign("mini_album1");
	//$mini_album_view = &$TPL->fetch("mini_album1");

	echo $미니앨범출력;

}




##############################################################


	function happy_config_group_load( $group_number , $autoForm='', $saveButton = '')
	{
		global $happy_config_group, $happy_config_part, $happy_config_field, $HappyField;
		global $KAKAO_CONFIG;

		$number	= preg_replace("/\D/","",$group_number);

		if ( $number == '' )
		{
			return "그룹넘버가 지정되지 않았습니다.";
		}

		$formStart	= "";
		$formEnd	= "";
		if ( $autoForm == 'all' || $autoForm == 'start' )
		{
			$formStart	= "<form name='happy_config_save_frm' action='happy_config_reg.php' method='post' enctype='multipart/form-data'>
			<input type='hidden' name='number' value='$_GET[number]'>
			";
		}

		if ( $autoForm == 'all' || $autoForm == 'end' )
		{
			$formEnd	= "</form>";
		}

		$GROUP	= happy_mysql_fetch_array(query("SELECT * FROM $happy_config_group WHERE number='$number'"));


		#디버그모드/일반모드 버튼
		if ( $_GET['debug'] == '' )
		{
			$debug_button = "<img src='img/happy_config_view_debug.gif' alt='디버그모드' style='cursor:pointer' onClick=\"window.location.href = window.location + '&debug=1';\">";
		}
		else
		{
			$url	= $_SERVER['REQUEST_URI'];
			$url	= str_replace("&debug=1","",$url);
			$debug_button = "<img src='img/happy_config_view_debug_back.gif' alt='일반모드' style='cursor:pointer' onClick=\"window.location.href='$url'\">";
		}

		#해당 number 값일 때 해당 도움말버튼 출력 [YOON : 2011-03-10]
		if ( $_GET['number'] == 5){
			$help_btn = "<a href='http://cgimall.co.kr/xml_manual/manual_main.php?db_name=manual_adultjob&number=49' target='_blank'><img src=\"img/btn_help.gif\" border=\"0\" align='absmiddle'></a>";
		}else{
			$help_btn = "";
		}


		#감싸는 테이블 START
		$GroupContent	= "
						<p class=\"main_title cover\">
						$GROUP[group_title] $help_btn
						<span class=\"small_btn\">$debug_button <a href=\"javascript:helpView('_debug');\"><img src=\"img/btn_help_simple.gif\" border=0 style='cursor:pointer;'></a></label>
						</p>

						<div id=\"box_style\">
							<div class=\"box_1\"></div>
							<div class=\"box_2\"></div>
							<div class=\"box_3\"></div>
							<div class=\"box_4\"></div>
							<!-- 정렬방법 <img src=\"img/happy_config_txt_sort.gif\" border=\"0\"> [ $GROUP[group_sort] ]</label>  -->

							<div id='help_view_debug' style='display:none;'>
								<div style='margin-bottom:-5px;'>
									<DL class=help_dl_debug>
										<DT>디버그모드
										<DD>현재 항목에 대한 태그명을 확인합니다. 이 태그명을 템플릿파일에 태그명령어로 활용시에는 태그명 양쪽에 '<font color=red>{{</font>'와 '<font color=red>}}</font>'를 붙여서 사용하시면 됩니다.<br>
										예) <b>search_id_type  -> <font color=red>{{</font>search_id_type <font color=red>}}</font></b>
									</DL>
								</div>
							</div>
		";

		$GroupContent	.= "

						<!-- RND-TBL -->
						$formStart

						<table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" class=\"bg_style\">
						<colgroup>
							<col style='width:18%'></col>
							<col></col>
						</colgroup>
		";



		$PartRecord	= query("SELECT * FROM $happy_config_part WHERE group_number = '$GROUP[number]' AND part_sort != 44444 ORDER BY part_sort ASC, number ASC ");

		$FGCount = 0;

		while ( $Part = happy_mysql_fetch_array($PartRecord) )
		{

			$FGCount++;

			//카카오 알림톡 템플릿찾기 hong
			$Part['part_content']	= preg_replace("/%알림톡템플릿찾기-(.*)-(.*)-(.*)-알림톡템플릿찾기%/","<a href='javascript:void(0);' onClick=\"kakao_template_find('".$KAKAO_CONFIG['tpl_url']."','\\1','\\2','\\3');\">".$KAKAO_CONFIG['find_icon']."</a>", $Part['part_content']);
			$Part['part_content']	= str_replace("%알림톡도움말%", "<img alt='' border='0' onclick=\"window.open('http://cgimall.co.kr/happy_manual/faq_viewer_detail.cgi?db=board_faq&thread=340','happy_report','scrollbars=yes,width=700,height=600');\" src='img/btn_help.gif' style='vertical-align: middle; cursor: pointer; scrolling: yes;' alt='알림톡 도움말' title='알림톡 도움말' />", $Part['part_content']);

			$Sql			= "SELECT * FROM $happy_config_field WHERE part_number='$Part[number]' ";
			$FieldRecord	= query($Sql);

			while ( $Field = happy_mysql_fetch_array($FieldRecord) )
			{
				$nowForm		= happy_config_field_maker($Field['number'],'','auto');

				$field_name		= $Field['field_name'];

				$Part['part_content']	= str_replace("%".$field_name."%", $nowForm, $Part['part_content']);

				if ( $Field['field_type'] == 'file' )
				{
					$Part['part_content']	= str_replace("%".$field_name."_미리보기%", $HappyField[$field_name.'_미리보기'], $Part['part_content']);
					$Part['part_content']	= str_replace("%".$field_name."_미리보기1%", $HappyField[$field_name.'_미리보기1'], $Part['part_content']);
					$Part['part_content']	= str_replace("%".$field_name."_미리보기2%", $HappyField[$field_name.'_미리보기2'], $Part['part_content']);
					$Part['part_content']	= str_replace("%".$field_name."_미리보기3%", $HappyField[$field_name.'_미리보기3'], $Part['part_content']);

				}
			}


			if ($Part[part_sub_title] == "" ) $Part[part_sub_title] = "<font color='#999999'>짧은 설명내용이 없습니다.</font>";
			#내용물 테이블(반복되는 부분)
			$GroupContent	.= "
								<tr>
									<th>$Part[part_title]</th>
									<td>
										<p class='short'>$Part[part_sub_title]</p>
										$Part[part_content]
									</td>
								</tr>
			";
		}


		#저장된 그룹리스트가 없을 때 [ YOON : 2009-09-21 ]
		if($FGCount == 0) $GroupContent	.= "
								<tr>
									<th align=center colspan=2 style=\"color:white; font-size:10pt; font-family:맑은 고딕,돋움; padding:25 0;\">

										<b style='font-size:14px;'>$GROUP[group_title]</b>에(서) 사용중인 그룹리스트가 없습니다. <br><br>
										관리자 환경설정 관리(<b>happy_config.php</b>)에서 그룹설정을 하시기 바랍니다.<br>

										<fieldset style='width:680; padding:20; text-align:left; border:1px solid #DDD;'>
											<legend style='color:#F8EA70; font-size:14px; padding:0 10;'>알림경고</legend>
											<UL style='font-size:14px; margin-bottom:5;'>
												<LI>관리자 환경설정 관리(<b>happy_config.php</b>)는 해피CGI에서 등록 설정하는 해피CGI 전용페이지입니다.
												<LI>일반사용자는 이 기능을 이용하실 수 없습니다.
												<LI>해당항목에 아무 내용도 없을 시에는 <B><u>해피CGI 고객지원게시판</u></B> 또는 <B><u>전화: 1566 - 1621</u></B>로 문의해 주시면 처리해 드리겠습니다.
												<LI>이 기능을 이용하여 설정하신 후 오류발생에 대한 문제는 책임을 지지않으며 A/S 대상에 포함이 되지 않습니다.
											</UL>
										</fieldset>

									</th>
								</tr>";



		#감싸는 테이블 END
		$GroupContent	.= "

						</table>
						</div>
						$formEnd
		";




		if ( $saveButton != '' && $_GET['debug'] == '' )
		{

			#저장된 그룹리스트가 없을 때 버튼출력안함 [ YOON : 2009-09-21 ]
			if($FGCount == 0) {

				#확인버튼
				/*
				$GroupContent	.="
					<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=cfg_admin_tool_btn_ok>
					<tr>
						<td align=center>
							<input type='button' value='확인' onClick=\"window.location.href='happy_config.php?number=$_GET[number]'\">
						</td>
					</tr>
					</table>
				";
				*/

			}else{

				#설정저장 버튼
				#id=cfg_admin_tool_btn_tbl 버튼 안나와서 임의로 주석
				$GroupContent	.= "
					<div style='text-align:center;'><input type='button' value='설정을 저장합니다.' onClick='document.happy_config_save_frm.submit()' class='btn_big'></div>
				";
			}
		}else{

			#저장된 그룹리스트가 없을 때 버튼출력안함 [ YOON : 2009-09-21 ]
			if($FGCount == 0) {

				#확인버튼
				/*
				$GroupContent	.="
					<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=cfg_admin_tool_btn_ok>
					<tr>
						<td align=center>
							<input type='button' value='확인' onClick=\"window.location.href='happy_config.php?number=$_GET[number]'\">
						</td>
					</tr>
					</table>
				";
				*/

			}else{

				#저장된 설정 디버그모드 확인버튼
				$GroupContent	.="
					<div style='text-align:center;'><input type='button' value='확인' onClick=\"window.location.href='javascript:history.go(-1)'\" class='btn_big'></div>
				";
			}
		}




		return $GroupContent;
	}



	function happy_config_menu_list($menu_group='')
	{
		global $happy_config_group;

		if ( $menu_group != '' && $menu_group != '전체' )
		{
			$WHERE	= " AND menu_group = '$menu_group' ";
		}

		$Sql	= "SELECT * FROM $happy_config_group WHERE group_display='1' $WHERE ORDER BY group_sort ASC, number ASC ";
		$Record	= query($Sql);

		$content	= "";
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$content	.= "<LI class='submenu_now_group_$Data[number]'><A HREF='happy_config_view.php?number=$Data[number]'>$Data[group_title]</A>";
		}

		return $content;
	}

	function happy_config_menu_list_pref($menu_group='')
	{
		global $happy_config_group;

		if ( $menu_group != '' && $menu_group != '전체' )
		{
			$WHERE	= " AND menu_group = '$menu_group' ";
		}

		$Sql	= "SELECT * FROM $happy_config_group WHERE group_display='1' $WHERE ORDER BY group_sort ASC, number ASC ";
		$Record	= query($Sql);

		$content	= "";
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$content	.= "<LI class='submenu_now_group_$Data[number]'><A HREF='?type=part&number=$Data[number]&start=$_GET[start]&search_order=$_GET[search_order]&keyword=$_GET[keyword]'>$Data[group_title] <font color=gray>[편집]</font></A>";
		}

		return $content;
	}


##############################################################

	function happy_config_field_maker( $number, $number_type='', $auto_value='' )
	{
		global $happy_config_field, $HappyField, $wys_url, $HAPPY_CONFIG;

		if ( $number_type == '' )
		{
			$number_type	= 'number';
		}


		$Sql	= "SELECT * FROM $happy_config_field WHERE ${number_type}='$number' ";
		$Record	= query($Sql);
		$wys_use	= false;

		while ( $DataField = happy_mysql_fetch_array($Record) )
		{

			if ( $auto_value !='' )
			{
				#$value	= $GLOBALS[$DataField[field_name]];
				$value	= $HAPPY_CONFIG[$DataField[field_name]];
				$value	= str_replace("<!--","<!==",$value);
				$value	= str_replace("-->","==>",$value);
				if ( $DataField['field_out_type'] == 'array' )
				{
					$value	= @implode(",", (array) $value);
				}
			}
			else
			{
				//확장용..
			}

			if ( $DataField['field_type'] == 'text' )
			{
				$form	= "<input type='text' name='$DataField[field_name]' value='$value' $DataField[field_option] >";
			}
			else if ( $DataField['field_type'] == 'textarea' )
			{
				$form	= "<textarea name='$DataField[field_name]' $DataField[field_option] >$value</textarea>";
			}
			else if ( $DataField['field_type'] == 'wys' )
			{
				$value	= str_replace("\n","\\n",str_replace("\r","\\r",addslashes($value)));

				$wys_use	= true;

				#위지윅 에디터 높이
				$DataField['field_option']	= preg_replace("/\D/","",$DataField['field_option']);
				$DataField['field_option']	= $DataField['field_option'] == '' ? '300' : $DataField['field_option'];

				#위지윅 에디터 Toolbar
				$DataField['field_value']	= $DataField['field_value'] == '' ? 'happycgi' : $DataField['field_value'];

				//위지윅에디터CSS
				$form	.= happy_wys("ckeditor","가로100%",$DataField['field_option'],$DataField['field_name'],"{HAPPY_CONFIG.".$DataField['field_name']."}","../","happycgi_normal",'all');
			}
			else if ( $DataField['field_type'] == 'phone' )
			{
				$form	= "<div style='width:118px; height:90px; background:url(img/happy_config_sms.gif) no-repeat; padding:30px 0 0 15px; text-align:left;'><textarea style='width:100px; border:none; height:73px; background:none; overflow-y:hidden; line-height:16px;' name='$DataField[field_name]' maxlength='80'  $DataField[field_option] >$value</textarea></div>";
			}
			else
			{
				$fieldOptions	= explode(",",$DataField['field_value']);
				if ( $DataField['field_type'] == 'checkbox' )
				{
					$array_co	= count($fieldOptions);
					$values		= explode(",",$value);
					$form		= "";

					for ( $i=0, $j=0; $i<$array_co; $i++ )
					{
						$fieldOptions[$i]		= trim($fieldOptions[$i]);
						$fieldOptions[$i]		= explode("|",$fieldOptions[$i]);
						$fieldOptions[$i][1]	= ( sizeof($fieldOptions[$i]) == 1 )?$fieldOptions[$i][0] : $fieldOptions[$i][1];

						if ( $fieldOptions[$i][0] == $values[$j] ) {
							$j++;
							$form .= "<input type=checkbox id='$DataField[field_name]_$i'  name='".$DataField[field_name]."[]' value='".$fieldOptions[$i][0]."' checked class='input_chk'> <label for='$DataField[field_name]_$i' style='cursor:pointer;font-size:11pt;font-family:맑은 고딕,돋움;'>".$fieldOptions[$i][1]."</label> &nbsp;";
						}
						else {
							$form .= "<input type=checkbox id='$DataField[field_name]_$i'  name='".$DataField[field_name]."[]' value='".$fieldOptions[$i][0]."'class='input_chk'> <label for='$DataField[field_name]_$i' style='cursor:pointer;font-size:11pt;font-family:맑은 고딕,돋움;'>".$fieldOptions[$i][1]."</label> &nbsp;";
						}
					}
				}
				else if ( $DataField['field_type'] == 'radio' )
				{
					$array_co	= count($fieldOptions);
					$form		= "";

					for ( $i=0; $i<$array_co; $i++ )
					{
						$fieldOptions[$i]		= trim($fieldOptions[$i]);
						$fieldOptions[$i]		= explode("|",$fieldOptions[$i]);
						$fieldOptions[$i][1]	= ( sizeof($fieldOptions[$i]) == 1 )?$fieldOptions[$i][0] : $fieldOptions[$i][1];

						if ( $fieldOptions[$i][0] == $value ) {
							$j++;
							$form .= "<input type=radio id='$DataField[field_name]_$i'  name='$DataField[field_name]' value='".$fieldOptions[$i][0]."' checked class=cfg_input_chk> <label for='$DataField[field_name]_$i' class=label_txt>".$fieldOptions[$i][1]."</label>";
						}
						else {
							$form .= "<input type=radio id='$DataField[field_name]_$i'  name='$DataField[field_name]' value='".$fieldOptions[$i][0]."' class=cfg_input_chk> <label for='$DataField[field_name]_$i' class=label_txt>".$fieldOptions[$i][1]."</label>";
						}
					}
				}
				else if ( $DataField['field_type'] == 'select' )
				{
					$array_co	= count($fieldOptions);
					$form		= "<select name='$DataField[field_name]' $sureInput>";
					$form		.= "<option value=''>--- 선택 ---</option>";

					for ( $i=0; $i<$array_co; $i++ )
					{
						$fieldOptions[$i]		= trim($fieldOptions[$i]);
						$fieldOptions[$i]		= explode("|",$fieldOptions[$i]);
						$fieldOptions[$i][1]	= ( sizeof($fieldOptions[$i]) == 1 )?$fieldOptions[$i][0] : $fieldOptions[$i][1];

						if ($value == $fieldOptions[$i][0]){
							$form	.= "<option value='".$fieldOptions[$i][0]."' selected style='background-color:#E5EDFF'>".$fieldOptions[$i][1]."</option>";
						}
						else {
							$form	.= "<option value='".$fieldOptions[$i][0]."'>".$fieldOptions[$i][1]."</option>";
						}

					}
					$form		.= "</select>";
				}
				else if ( $DataField['field_type'] == 'file' )	// 상세보기 페이지 => $tplTD 그냥 출력
				{
					$form	= "<input type='file' name='$DataField[field_name]' value='' $DataField[field_option] >";
					$form	.= " <input type='checkbox' name='$DataField[field_name]_del' id='$DataField[field_name]_del' value='ok' style='vertical-align:middle;'><label for='$DataField[field_name]_del' style='cursor:pointer;'> 파일삭제</label>";
					if ( $value != '' )
					{
						$form	.= "<div style='padding-top:5px;'><img src='img/happy_config_txt_regimg.gif' border='0' align=absmiddle>&nbsp; [SRC]&nbsp; $value </div>";

						$tmp	= explode(".",$value);
						$ext	= strtolower($tmp[sizeof($tmp)-1]);

						if ( $ext == 'jpg' || $ext == 'jpeg' || $ext == 'bmp' || $ext == 'png' || $ext == 'gif' )
						{
							$preview	= "<img src='../$value' align='absmiddle' border=0>";
							$preview1	= "<img src='../$value' align='absmiddle' border=0 width='200'>";
							$preview2	= "<img src='../$value' align='absmiddle' border=0 width='500'>";
							$preview3	= "<img src='../$value' align='absmiddle' border=0 width='700'>";
						}
						else
						{
							$preview	= '';
							$preview1	= '';
							$preview2	= '';
							$preview3	= '';
						}
						$HappyField[$DataField['field_name']."_미리보기"]	= $preview;
						$HappyField[$DataField['field_name']."_미리보기1"]	= $preview1;
						$HappyField[$DataField['field_name']."_미리보기2"]	= $preview2;
						$HappyField[$DataField['field_name']."_미리보기3"]	= $preview3;
					}
					else
					{
						$HappyField[$DataField['field_name']."_미리보기"]	= '';
						$HappyField[$DataField['field_name']."_미리보기1"]	= '';
						$HappyField[$DataField['field_name']."_미리보기2"]	= '';
						$HappyField[$DataField['field_name']."_미리보기3"]	= '';
					}
				}

				$HappyField[$DataField['field_name']]	= $form;
			}
			$form	.= "<input type='hidden' name='happy_fields_name[]' value='$DataField[field_name]'>";
			$form	.= "<input type='hidden' name='happy_fields_type[]' value='$DataField[field_type]'>";
			$form	.= "<input type='hidden' name='happy_fields_option[]' value='$DataField[field_value]'>";
			$form	.= "<input type='hidden' name='happy_fields_out[]' value='$DataField[field_out_type]'>";

			if ( $_GET['debug'] != '' )
			{
				$form	= " <font color='red'><b>$DataField[field_name]</b></font>";
			}
		}

		if( $wys_use )
		{
			$wys_css_js	= happy_wys_css("ckeditor","../");
			$wys_css_js	.= happy_wys_js("ckeditor","../");
		}
		else
		{
			$wys_css_js = '';
		}

		return $wys_css_js.$form;
	}


##############################################################


	function message_list( $heightSize , $messageType, $template1 , $template2, $cutSize="")
	{
		global $TPL, $message_tb, $message_loginVal, $skin_folder, $Message, $nowCategory, $내용, $전체쪽지수, $페이징;
		global $happy_member, $happy_sns_array;

		$heightSize	= preg_replace("/\D/","",$heightSize);
		$cutSize	= preg_replace("/\D/","",$cutSize);
		$random		= rand(0,100000);

		#관리자모드에서 쪽지 볼때
		if ( $_GET['adminMode'] == 'y' && $_COOKIE["ad_id"] != '' )
		{
			$mem_id		= $_COOKIE["ad_id"];
			$adminChk	= 'y';
			$receive_id_WHERE	= "";
			$sender_id_WHERE	= "";
		}
		else if ( $message_loginVal == '' )
		{
			return print "<center>로그인후 이용가능합니다.</center>";
		}
		else
		{

			$mem_id		= $message_loginVal;
			$adminChk	= 'n';
			$receive_id_WHERE	= "receive_id = '$mem_id' AND";
			$sender_id_WHERE	= "sender_id = '$mem_id' AND";
		}


		if ( $heightSize == '' )
		{
			return print "<font color='red'><center>추출태그 사용오류</center></font>";
		}
		if ( $cutSize == '' )
		{
			$cutSize	= 40;
		}

		$WHERE		= "";
		switch ( $messageType )
		{
			case "받은쪽지":
						$WHERE = " $receive_id_WHERE receive_admin='$adminChk'  AND del_receive='n' ";
						$delType='receive';break;
			case "보낸쪽지":
						$WHERE = " $sender_id_WHERE sender_admin='$adminChk' AND del_sender='n' ";
						$delType='sender';break;
			case "읽지않은쪽지":
						$WHERE = " $receive_id_WHERE receive_admin='$adminChk' AND readok = 'n' AND del_receive='n' ";
						$delType='receive';break;
			case "읽히지않은쪽지":
						$WHERE = " $sender_id_WHERE sender_admin='$adminChk' AND readok = 'n' AND del_sender='n' ";
						$delType='sender';break;
		}

		if ( $WHERE == '' )
		{
			return print "<font color='red'><center>추출태그 사용오류(지정되지 않은 옵션)</center></font>";
		}


		$offset			= $heightSize;


		############ 페이징처리(쪽지함) ############
		$start			= $_GET["start"];
		$scale			= $offset;

		$Sql	= "select count(*) from $message_tb WHERE $WHERE ";
		$Temp	= happy_mysql_fetch_array(query($Sql));
		$Total	= $Temp[0];

		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= 4;

		$searchMethod	= "";
		#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
		$searchMethod	.= "&mode=$_GET[mode]";
		$searchMethod	.= "&kfield=$_GET[kfield]";
		$searchMethod	.= "&kword=$_GET[kword]";
		$searchMethod	.= "&adminMode=$_GET[adminMode]";
		#검색값 입력완료

		if ( $_GET["sort"] == "" )
			$order_query	= " number DESC ";
		else
			$order_query	= str_replace("_", " ", $_GET["sort"]);

		$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		########### 페이징처리 끝(쪽지함) ############
		$전체쪽지수	= $Total;
		$페이징		= $paging;



		$Sql	= "SELECT * FROM $message_tb WHERE $WHERE ORDER BY $order_query LIMIT $start,$scale";
		$Record	= query($Sql);

		$TPL->define("쪽지리스팅_$random", $skin_folder."/".$template2 );

		$Count	= 0;
		while ( $Message = happy_mysql_fetch_array($Record) )
		{
			$Message["regdate_date"]	= substr($Message["regdate"],0,10);
			$Message["regdate_date2"]	= substr($Message["regdate"],0,16);

			$Message["readdate_date"]	= substr($Message["readdate"],0,10);
			$Message["readdate_date2"]	= substr($Message["readdate"],0,16);

			if ( $Message["readok"] == "n" )
			{
				$Message["readdate"]		= "미열람";
				$Message["readdate_date"]	= "미열람";
				$Message["readdate_date2"]	= "미열람";
			}

			#보낸사람이 관리자일경우 관리자 출력
			if ( $Message['sender_admin'] == 'y' )
			{
				#$Message['sender_id']	= '<font color=orange>[관리자]'.$Message['sender_id'];
				$Message['sender_id']	= '<font color=red>[관리자]';
			}
			else
			{
				# SNS LOGIN 처리 추가
				//echo "SELECT user_nick, sns_site FROM $happy_member WHERE user_id='$Message[sender_id]'"."<br>";
				$Message['sender_id']	= outputSNSID($Message['sender_id'], "icon_use_infoReply");
			}

			#받는사람이 관리자일경우 관리자 출력
			if ( $Message['receive_admin'] == 'y' )
			{
				#$Message['sender_id']	= '<font color=orange>[관리자]'.$Message['sender_id'];
				$Message['receive_id']	= '<font color=red>[관리자]';
			}
			else
			{
				# SNS LOGIN 처리 추가
				$Message['receive_id']	= outputSNSID($Message['receive_id'], "icon_use_messageList");
			}

			$Message["message"] = strip_tags($Message["message"]);
			$Message["message"]	= kstrcut($Message["message"], $cutSize, "...");


			$Message["link"]	= "?mode=$_GET[mode]&start=$_GET[start]&kfield=$_GET[kfield]&kword=$_GET[kword]&number=$Message[number]&adminMode=$_GET[adminMode]";

			$Message["del_link"]	= "?mode=$_GET[mode]&start=$_GET[start]&kfield=$_GET[kfield]&kword=$_GET[kword]&delType=$delType&delNumber=$Message[number]&adminMode=$_GET[adminMode]";

			$temp		= $TPL->fetch();
			$content	.= $temp;
			$Count++;
		}

		$내용	= ( $Count == 0 )?"<table width='100%' height='100%'><tr><td align='center'>${messageType}가 존재하지 않습니다.</td></tr></table>":$content;


		$TPL->define("쪽지리스팅껍데기_$random", $skin_folder."/". $template1 );
		$content = $TPL->fetch();

		return print $content;

	}



	function message_loading()
	{
		###########################################
		# 기본적으로 불려지는 쪽지함수 -> 로그인후 정보창에 출력가능.. {{쪽지메세지}}		#
		# 이함수는 로그인후에만 불려지도록 함수 호출위치를 정해야합니다.					#
		# 실시간쪽지 기능을 사용할려면														#
		# {{쪽지레이어}}를 <body> 태그 아래에 넣으시면 됩니다.								#
		###########################################

		global $message_tb, $message_loginVal, $message_print, $message_print2, $TPL, $skin_folder;
		global $쪽지메세지, $쪽지스크립트, $쪽지레이어;
		global $받은쪽지수,$보낸쪽지수,$읽지않은쪽지수,$읽히지않은쪽지수;


		if ( $message_loginVal == '' )
		{
			$쪽지메세지	= "<center>로그인후 이용가능합니다.</center>";
			return;
		}

		$Sql	= "SELECT COUNT(*) FROM $message_tb WHERE receive_id = '$message_loginVal' AND receive_admin='n' AND readok='n' AND del_receive='n' ";
		$Tmp	= happy_mysql_fetch_array(query($Sql));

		$message	= ( $Tmp[0] == 0 )?$message_print:$message_print2;

		$message	= str_replace('%쪽지수%',$Tmp[0],$message);

		$쪽지메세지	= "<a href='#' style='text-decoration:none'
		onClick=\"window.open('happy_message.php','happy_message','width=730,height=610,toolbar=no,scrollbars=no')\">$message</a>";

		$TPL->define("쪽지스크립트다", "$skin_folder/message_alert.html" );
		$쪽지레이어	= $TPL->fetch("쪽지스크립트다");

	}


#금지단어 체크 함수
#@체크할문자,금지단어
#금지단어 포함시 true 리턴
function DenyWordCheck($str,$TDenyWordList)
{
	if ( $str != '' )
	{
		if ( is_array($TDenyWordList) )
		{
			foreach($TDenyWordList as $k => $v )
			{
				if ( $v != '' )
				{
					if (strpos($str,$v) !== false )
					{
						return true;
					}
				}
			}
		}
	}

	return false;
}

#고용형태 아이콘 반환
function guin_type_icon($guin_type)
{
	global $job_arr;

	$key = array_search($guin_type,$job_arr);
	$img_tag = '<img src="img/guin_type_'.$key.'.gif" align="absmiddle" alt="'.$job_arr[$key].'" border="0">';

	return $img_tag;
}


#구직회원결제내역
#{{구직회원결제내역 총4개,가로1개,output_jangboo.html,사용안함}}
function jangboo_list_per()
{
	global $jangboo2;
	global $mem_id;
	global $Jangboo;
	global $skin_folder;
	global $TPL;
	global $PER_ARRAY_ICON;
	global $결제내역페이징;
	global $job_jangboo_package,$job_money_package;

	//print_r2(func_get_args());
	$args = func_get_args();
	$ex_limit = preg_replace("/\D/","",$args[0]);
	$ex_width = preg_replace("/\D/","",$args[1]);
	$ex_template = $args[2];
	$ex_paging = $args[3];


	#토탈 등록갯수를 알려주자
	$sql21 = "select count(*) from $jangboo2 where or_id = '$mem_id' ";
	$result21 = query($sql21);
	list($numb) = happy_mysql_fetch_array($result21);
	$총갯수 = $numb;

	if ($start == "")
	{
		$start = $_GET[start];
	}
	if($start==0 || $start=="")
	{
		$start=0;
	}

	$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = $start;
	$co = $numb - $start;


	############ 페이징처리 ############
	$Total			= $numb;
	$scale			= $ex_limit;
	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 2 : 6;

	$searchMethod	.= "";

	$page_print		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	############ 페이징처리 ############

	if( $view_rows )	{ $listNo = $numb - $view_rows; } else { $listNo = $numb; $view_rows = 0; }

	if ( $ex_paging == "사용안함" )
	{
		$view_rows = 0;
	}

	$sql = "select * from $jangboo2 where or_id = '$mem_id'  order by number desc limit $view_rows,$ex_limit ";
	$result = query($sql);

	$random = rand(0,100);
	$TPL->define("결제내역_$random", $skin_folder."/".$ex_template );

	$i = 1;
	while($Jangboo = happy_mysql_fetch_assoc($result))
	{
		$Jangboo['listNo']	= $listNo;

		//print_r2($Jangboo);
		#입금인지 아닌지 정리
		if ($Jangboo['in_check'] == "0")
		{
			//$Jangboo['in_check'] = "<img src=./img/btn_20_no.gif border=0 align=absmiddle>";
			$Jangboo['in_check'] = "<span class='in_check_no_m'>입금확인중</span>";
		}
		else
		{
			//$Jangboo['in_check'] = " <img src=./img/btn_20_ok.gif border=0 align=absmiddle>";
			$Jangboo['in_check'] = "<span class='in_check_yes_m'>입금확인됨</span>";
		}
		#결제금액에숫자를

		#결제금액
		$Jangboo['goods_price'] = number_format($Jangboo['goods_price']);

		#구매내역정리
		$PAY = split(",",$Jangboo['goods_name']);
		$i = "0";
		$Jangboo['goods_name_info'] = "<table align=left border=0>";
		foreach ($PAY as $list){
			//echo $list."<br>";
			list($tmp_day,$tmp_price) = split(":",$list);
			//echo $i."=".$list."<br>";

			$day_text = "일";
			$pay_type = "기간별";

			if ( $i == 15 )
			{
				$day_text = "회";
				$pay_type = "회수별";
			}

			if ($tmp_day)
			{
				$tmp_price_comma = number_format($tmp_price);
				$type_icon = " <img src=".$PER_ARRAY_ICON[$i]." align=absmiddle border=0>";

				$Jangboo['goods_name_info'] .= "
				<tr>
					<td style='padding:5px;'>".$type_icon."</td>
					<td class='noto400 font_14' style='padding-left:5px;'>".$tmp_day.$day_text.$print_end."(".$pay_type.")</td>
					<td class='noto400 font_14' style='padding-left:5px;'>".$tmp_price_comma."원</td>
				</tr>";
			}
			$i++;
		}
		$Jangboo['goods_name_info'] .= "</tr></table>";
		#구매내역정리

		#구매내역 정리끝
		//패키지권 구매
		$tmp_str = "";
		if ( $Jangboo['member_type'] == "200" )
		{
			$option_array_icon = $PER_ARRAY_ICON;

			$goods_name = "<table width='100%' align=left border=0>";
			$tmp_str = explode(",",$Jangboo['goods_name']);
			$info_maemool = array();
			foreach($tmp_str as $p)
			{
				$sql3 = "select * from $job_money_package where number = '$p'  ";
				$result3 = query($sql3);
				$BD = happy_mysql_fetch_array($result3);

				$table_id = "pack_".$Jangboo['or_no']."_".$BD['number'];
				//echo $table_id."<br>";

				$goods_name.= "<tr><td><a href='javascript:void(0);' onclick=\"view_t('".$table_id."');\">[".$BD['title']."] 옵션상세정보</a></td></tr>";
				$goods_name.= "<tr id='".$table_id."' style='display:none;'><td><table width='100%' align=left border=0>";

				$sql3 = "select * from $job_jangboo_package where package_number = '".$p."' and or_no = '".$Jangboo['or_no']."'";
				$result3 = query($sql3);
				$Package = happy_mysql_fetch_assoc($result3);

				$tmp_a = explode(",",$Package['uryo_detail']);
				if ( is_array($tmp_a) )
				{
					$i = 0;
					foreach($tmp_a as $v)
					{
						list($t1,$t2,$t3) = explode(":",$v);
						if ( $t2 > 0 )
						{
							//if ($i == 9){
							//	$tmp_text = '회 ';
							//}
							//else {
							//	$tmp_text = '일';
							//}

							//채용정보 + 기업회원의 유료옵션은 회수별,노출별,기간별,이력서수,횟수별 이 있다.
							$opt_name = $t1."_option";
							//echo $opt_name.":".$CONF[$opt_name]."<br>";
							if ( $CONF[$opt_name] == "기간별" )
							{
								$Uryo['uryo_danwi'] = "일";
							}
							else if ( $CONF[$opt_name] == "노출별" )
							{
								$Uryo['uryo_danwi'] = "회";
							}
							else if ( $CONF[$opt_name] == "클릭별" )
							{
								$Uryo['uryo_danwi'] = "회";
							}
							else if ( $CONF[$opt_name] == "이력서수" )
							{
								$Uryo['uryo_danwi'] = "회";
							}
							else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
							{
								$Uryo['uryo_danwi'] = "회";
							}
							else
							{
								$Uryo['uryo_danwi'] = "일";
							}

							$type_icon2 = "<tr><td><img src=../$option_array_icon[$i] align=absmiddle border=0> ".$t2." ".$Uryo['uryo_danwi']." X ".$t3." 회 이용권</td></tr>";
							$goods_name.= $type_icon2;
						}
						$i++;
						//이력서의 스킨과,아이콘옵션은 패키지에서 제외
						if ( $i == 3 ) { $i++; }
						if ( $i == 7 ) { $i++; }

					}
				}

				$goods_name.= "</td></tr></table>";

				//패키지유료옵션 사용내역
				$info_maemool[] = "<a href='money_setup_package.php?mode=modify&number=".$BD['number']."&pay_type=person' style='color:#6666CC; text-decoration:underline'>[".$Package['title']."] 패키지 변경</a>";
			}

			$info_maemool = implode("<br>&nbsp;&nbsp;", (array) $info_maemool);

			$goods_name .= "</table>";

			$Jangboo['goods_name_info'] = $goods_name;
		}
		//패키지권 구매
		else if ($Jangboo['member_type'] != 0)
		{
			$Jangboo['info_maemool'] = "<a href=admin.php?a=mem&mode=m_mod&num=".$Jangboo['links_number']."&pg=1 style='color:#6666CC;text-decoration:underline;'>정보사용료</a>";
			$Jangboo['info_maemool'] = "정보사용료";
		}
		else
		{
			$Jangboo['info_maemool'] = "<a href=../document_view.php?number=".$Jangboo['links_number']." style='color:#6666CC;'>구직정보보기</a> &nbsp;";
		}

		#관리자메세지툴팁
		if ($Jangboo['admin_message'])
		{
			$Jangboo['admin_message'] = "<center><br>관리자메세지 : <font color=#565EBC>".$Jangboo['admin_message']."</font><br><br>";
		}
		else
		{
			$Jangboo['admin_message'] = "<center><br>관리자메세지 : <font color=#009100>메세지가 없습니다</font><br><br>";
		}

		$Jangboo['admin_message'] = str_replace("\n", "", $Jangboo['admin_message']);
		$Jangboo['admin_message'] = str_replace("\r", "", $Jangboo['admin_message']);
		$Jangboo['admin_message'] = str_replace("'", "", $Jangboo['admin_message']);
		#관리자메세지툴팁

		$one_row = &$TPL->fetch("결제내역_$random");
		$rows .= table_adjust($one_row,$ex_width,$i);
		$i++;
		$listNo--;
	}

	if ( $ex_paging != "사용안함" )
	{
		//include ("page.php");
		$결제내역페이징 = $page_print;
	}

	$rows = "<table cellpadding='0' cellspacing='0' border='0' width='100%'>".$rows."</table>";
	return $rows;

}

#구인회원결제내역
#{{구인회원결제내역 총20개,가로1개,output_jangboo_com.html,사용함}}
function jangboo_list_com()
{
	//print_r(func_get_args());
	global $jangboo;
	global $mem_id;
	global $Jangboo;
	global $skin_folder;
	global $TPL;
	global $ARRAY;
	global $ARRAY_NAME2;
	global $결제내역페이징;
	global $CONF;
	global $job_jangboo_package,$job_money_package;


	$args = func_get_args();
	$ex_limit = preg_replace("/\D/","",$args[0]);
	$ex_width = preg_replace("/\D/","",$args[1]);
	$ex_template = $args[2];
	$ex_paging = $args[3];

	#토탈 등록갯수를 알려주자
	$sql21 = "select count(*) from $jangboo where or_id = '$mem_id' ";
	$result21 = query($sql21);
	list($numb) = happy_mysql_fetch_array($result21);

	if ($start == "")
	{
		$start = $_GET[start];
	}
	if($start==0 || $start=="")
	{
		$start=0;
	}

	$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = $start;
	$co = $numb - $start;


	############ 페이징처리 ############
	$Total			= $numb;
	$scale			= $ex_limit;
	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 2 : 6;

	$searchMethod	.= "";

	$page_print		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	############ 페이징처리 ############

	if( $view_rows )	{ $listNo = $numb - $view_rows; } else { $listNo = $numb; $view_rows = 0; }

	$sql = "select * from $jangboo where or_id = '$mem_id'  order by number desc limit $view_rows,$ex_limit ";
	$result = query($sql);

	$random = rand(0,100);
	$TPL->define("결제내역_$random", $skin_folder."/".$ex_template );

	$i = 1;
	while($Jangboo = happy_mysql_fetch_assoc($result))
	{
		$Jangboo['listNo']	= $listNo;

		//print_r2($Jangboo);
		$Jangboo['goods_name_org'] = $Jangboo['goods_name'];

		#입금인지 아닌지 정리
		if ($Jangboo['in_check'] == "0")
		{
			$Jangboo['in_check'] = "<img src=./img/btn_20_no.gif border=0 align=absmiddle>";
		}
		else
		{
			$Jangboo['in_check'] = "<img src=./img/btn_20_ok.gif border=0 align=absmiddle>";
		}

		#결제금액에숫자를
		$Jangboo['goods_price'] = number_format($Jangboo['goods_price']);

		#구매내역정리
		$PAY = split(",",$Jangboo['goods_name']);
		$i = "0";
		$Jangboo['goods_name'] = "<table cellpadding='0' cellspacing='0'  border=0 width=100%>";
		$total_price = 0;
		foreach ($PAY as $list)
		{
			list($tmp_day,$tmp_price) = split(":",$list);

			if ($tmp_day)
			{
				$total_price += $tmp_price;
				$tmp_price_comma = number_format($tmp_price);
				$type_icon = "<img src=$ARRAY_NAME2[$i] align=absmiddle border=0 style='vertical-align:middle'>";
				#일이냐 회냐?
				$tmp_option = $ARRAY[$i] . "_option";

				if ($CONF[$tmp_option] == '기간별')
				{
					$print_end = "일";
				}
				else
				{
					$print_end = "회";
				}

				$Jangboo['goods_name'] .= "
				<tr>
					<td class='font_14 noto400' style='padding:5px;' >".$type_icon."
					<span style='margin-left:5px'>
						".$tmp_day.$print_end."(".$CONF[$tmp_option].") ".$tmp_price_comma."원
					</span>
					</td>
				</tr>";
			}

			$i ++;
		}


		//패키지(즉시적용) 구매시 문구표시 - ranksa
		if($Jangboo['pack2_title'] != "")
		{
			$pack2_price = number_format(str_replace(',','',$Jangboo['goods_price']) - $total_price);
			$Jangboo['goods_name']	.= "
										<tr>
											<td class='font_14 noto400' style='padding:5px;'>
												<img src='img/title_pack1.gif' style='vertical-align:middle'>
												<span style='margin-left:5px'>$Jangboo[pack2_title] {$pack2_price}원</span>
											</td>
										</tr>
			";
		}
		//패키지(즉시적용) 구매시 문구표시 - ranksa END

		$Jangboo['goods_name'] .= "</tr></table>";
		#구매내역정리

		#구매내역 정리끝
		//패키지권 구매
		$tmp_str = "";
		if ( $Jangboo['member_type'] == "100" )
		{
			$option_array_icon = $ARRAY_NAME2;

			$goods_name = "<table width='100%' align=left border=0>";
			$tmp_str = explode(",",$Jangboo['goods_name_org']);
			$info_maemool = array();
			foreach($tmp_str as $p)
			{
				$sql3 = "select * from $job_money_package where number = '$p'  ";
				$result3 = query($sql3);
				$BD = happy_mysql_fetch_array($result3);

				$table_id = "pack_".$Jangboo['or_no']."_".$BD['number'];
				//echo $table_id."<br>";

				$goods_name.= "<tr><td class='font_14 noto400' style='letter-spacing:-1px;'><a href='javascript:void(0);' onclick=\"view_t('".$table_id."');\">[".$BD['title']."] 옵션상세정보 <img src='img/skin_icon/make_icon/skin_icon_710.jpg' style='vertical-align:middle; margin-bottom:4px'></a></td></tr>";
				$goods_name.= "<tr id='".$table_id."' style='display:none;'><td><table width='100%' align=left border=0>";

				$sql3 = "select * from $job_jangboo_package where package_number = '".$p."' and or_no = '".$Jangboo['or_no']."'";
				$result3 = query($sql3);
				$Package = happy_mysql_fetch_assoc($result3);

				$tmp_a = explode(",",$Package['uryo_detail']);
				if ( is_array($tmp_a) )
				{
					$i = 0;
					foreach($tmp_a as $v)
					{
						list($t1,$t2,$t3) = explode(":",$v);
						if ( $t2 > 0 )
						{
							//if ($i == 9){
							//	$tmp_text = '회 ';
							//}
							//else {
							//	$tmp_text = '일';
							//}

							//채용정보 + 기업회원의 유료옵션은 회수별,노출별,기간별,이력서수,횟수별 이 있다.
							$opt_name = $t1."_option";
							//echo $opt_name.":".$CONF[$opt_name]."<br>";
							if ( $CONF[$opt_name] == "기간별" )
							{
								$Uryo['uryo_danwi'] = "일";
							}
							else if ( $CONF[$opt_name] == "노출별" )
							{
								$Uryo['uryo_danwi'] = "회";
							}
							else if ( $CONF[$opt_name] == "클릭별" )
							{
								$Uryo['uryo_danwi'] = "회";
							}
							else if ( $CONF[$opt_name] == "이력서수" )
							{
								$Uryo['uryo_danwi'] = "회";
							}
							else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
							{
								$Uryo['uryo_danwi'] = "회";
							}
							else
							{
								$Uryo['uryo_danwi'] = "일";
							}

							$type_icon2 = "<tr><td class='noto400 font_14'><img src=../$option_array_icon[$i] align=absmiddle border=0> ".$t2." ".$Uryo['uryo_danwi']." X ".$t3." 회 이용권</td></tr>";
							$goods_name.= $type_icon2;
						}
						$i++;
						//채용정보의 아이콘옵션은 패키지에서 제외
						if ( $i == 11 ) { $i++; }

					}
				}

				$goods_name.= "</td></tr></table>";

				//패키지유료옵션 사용내역
				$info_maemool[] = "<a href='money_setup_package.php?mode=modify&number=".$BD['number']."' style='color:#6666CC;text-decoration:underline'>[".$Package['title']."] 패키지 변경</a>";
			}

			$info_maemool = implode("<br>&nbsp;&nbsp;", (array) $info_maemool);

			$goods_name .= "</table>";

			$Jangboo['goods_name'] = $goods_name;
		}
		//패키지권 구매
		else if ($Jangboo['member_type'] != 0)
		{
			$Jangboo['info_maemool'] = "정보사용료";
		}
		else
		{
			/*
			#구인정보읽기
			$sql3 = "select * from $guin_tb where number = '$Jangboo[links_number]'  ";
			$result3 = query($sql3);
			$BD = happy_mysql_fetch_array($result3);
			*/

			$Jangboo['info_maemool'] = "<a href=../guin_detail.php?num=$Jangboo[links_number] style='' >채용정보보기</a>";
		}

		if ($Jangboo['admin_message'])
		{
			$Jangboo['admin_message'] = "
			<center><br>관리자메세지 :
			<font color=#565EBC>".$Jangboo['admin_message']."</font>	<br><br>
			";
		}
		else
		{
			$Jangboo['admin_message'] = "
			<center><br>관리자메세지 :
			<font color=#009100>메세지가 없습니다</font>	<br><br>
			";
		}

		$Jangboo['admin_message'] = str_replace("\n", "", $Jangboo['admin_message']);
		$Jangboo['admin_message'] = str_replace("\r", "", $Jangboo['admin_message']);
		$Jangboo['admin_message'] = str_replace("'", "", $Jangboo['admin_message']);

		$one_row = &$TPL->fetch("결제내역_$random");
		$rows .= table_adjust($one_row,$ex_width,$i);
		$i++;
		$listNo--;
	}

	if ( $ex_paging != "사용안함" )
	{
		//include ("page.php");
		$결제내역페이징 = $page_print;
	}

	$rows = "<table cellpadding='0' cellspacing='0' border='0' width='100%'>".$rows."</table>";
	return $rows;

}

#포인트결제내역
#{{포인트결제내역 총3개,가로1개,output_point_jangboo.html,사용안함}}
function point_jangboo_list()
{
	global $point_jangboo;
	global $mem_id;
	global $Jangboo;
	global $skin_folder;
	global $TPL;
	global $포인트결제내역페이징;
	global $auto_number;

	#print_r2(func_get_args());
	$args = func_get_args();
	$ex_limit = preg_replace("/\D/","",$args[0]);
	$ex_width = preg_replace("/\D/","",$args[1]);
	$ex_template = $args[2];
	$ex_paging = $args[3];

	#토탈 등록갯수를 알려주자
	$sql21 = "select count(*) from $point_jangboo where id = '$mem_id' ";
	$result21 = query($sql21);
	list($numb) = happy_mysql_fetch_array($result21);

	$총갯수 =$numb;

	if ($start == "")
	{
		$start = $_GET[start];
	}
	if($start==0 || $start=="")
	{
		$start=0;
	}

	$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = $start;
	$co = $numb - $start;

	if ( $ex_paging == "사용안함" )
	{
		$view_rows = 0;
	}

	############ 페이징처리 ############
	$Total			= $numb;
	$scale			= $ex_limit;
	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 1 : 6;

	$searchMethod	.= "";

	$page_print		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	############ 페이징처리 ############

	$sql = "select * from $point_jangboo where  id = '$mem_id' order by number desc limit $view_rows,$ex_limit ";
	$result = query($sql);

	$random = rand(0,100);
	$TPL->define("포인트결제내역_$random", $skin_folder."/".$ex_template );

	$i = 1;
	$auto_number = $co;
	while($Jangboo = happy_mysql_fetch_assoc($result))
	{
		#입금인지 아닌지 정리
		if ($Jangboo['in_check'] == "0")
		{
			//$Jangboo['in_check'] = "<img src=img/btn/in_check_0.gif border=0 align=absmiddle alt='미입'>";
			$Jangboo['in_check'] = "<span class='in_check0' style='display:inline-block; text-align:center; padding:0 8px; height:22px; line-height:22px; font-size:14px; border:1px solid #c5c5c5; color:#ccc; border-radius:3px;'>미입</span>";
			$Jangboo['text_info'] = "포인트 <span class='noto500' style=color:#30ad0a;>충전</span>";
		}
		elseif ($Jangboo['in_check'] == "1")
		{
			//$Jangboo['in_check'] = "<img src=img/btn/in_check_1.gif border=0 align=absmiddle alt='입금'>";
			$Jangboo['in_check'] = "<span class='in_check1' style='display:inline-block; text-align:center; padding:0 8px; height:22px; line-height:22px; font-size:14px; border:1px solid #c5c5c5; color:#ccc; border-radius:3px;'>입금</span>";
			$Jangboo['text_info'] = "포인트 <span class='noto500' style=color:#30ad0a;>충전</span>";
		}
		elseif ($Jangboo['in_check'] == "2")
		{
			//$Jangboo['in_check'] = "<img src=img/btn/in_check_2.gif border=0 align=absmiddle alt='소모'>";
			$Jangboo['in_check'] = "<span class='in_check2' style='display:inline-block; text-align:center; padding:0 8px; height:22px; line-height:22px; font-size:14px; border:1px solid #c5c5c5; color:#ccc; border-radius:3px;'>소모</span>";
			$Jangboo['text_info'] = "포인트 <span class='noto500' style=color:#114dc9;>결제</span>";
		}
		elseif ($Jangboo['in_check'] == "3")
		{
			//$Jangboo['in_check'] = "<img src=img/btn/in_check_3.gif border=0 align=absmiddle alt='적립'>";
			$Jangboo['in_check'] = "<span class='in_check3' style='display:inline-block; text-align:center; padding:0 8px; height:22px; line-height:22px; font-size:14px; border:1px solid #c5c5c5; color:#ccc; border-radius:3px;'>적립</span>";
			$Jangboo['text_info'] = "포인트 적립";
		}
		else
		{
			//$Jangboo['in_check'] = " <img src=img/btn/in_check_1.gif border=0 align=absmiddle>";
			$Jangboo['in_check'] = "<span class='in_check1' style='display:inline-block; text-align:center; padding:0 8px; height:22px; line-height:22px; font-size:14px; border:1px solid #c5c5c5; color:#ccc; border-radius:3px;'>입금</span>";
		}

		#결재금액에숫자를
		$tmpPoint = explode("|",$Jangboo['point']);
		$Jangboo['point_comma'] = number_format($tmpPoint[0]);
		$Jangboo['money_comma'] = number_format($tmpPoint[1]);


		$one_row = &$TPL->fetch("포인트결제내역_$random");
		$rows .= table_adjust($one_row,$ex_width,$i);
		$i++;
		$auto_number--;
	}

	if ( $ex_paging != "사용안함" )
	{
		//include ("page.php");
		$포인트결제내역페이징 = $page_print;
	}

	if ( $i == 1 )
	{
		$rows = "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td align='center'><div style='background:rgba(0,0,0,0.4); border-radius:5px; text-align:center;'><p class='font_16 noto400' style='color:#fff; padding:15px;'>결제내역이 없습니다.</p></div></td></tr></table>";
	}
	else
	{
		$rows = "<table cellpadding='0' cellspacing='0' border='0' width='100%'>".$rows."</table>";
	}

	return $rows;

}

#가로세로정리
function table_adjust($main_new,$ex_width,$i)
{
	$main_new_out = "";

	#TD를 정리하자
	if ($ex_width == "1")
	{
		$main_new = "<tr><td class='tab_col'>".$main_new."</td></tr>";
	}
	elseif ($i % $ex_width == "1")
	{
		$main_new = "<tr><td class='tab_col'>".$main_new."</td>";
	}
	elseif ($i % $ex_width == "0")
	{
		$main_new = "<td class='tab_col'>".$main_new."</td></tr>";
	}
	else
	{
		$main_new = "<td class='tab_col'>".$main_new."</td>";
	}
	$main_new_out .= $main_new;

	return $main_new_out;
}

function guin_search_sql()
{
	global $job_arr;
	global $SI_NUMBER;
	global $plus;

	$plus.= "&action=".urlencode($_GET['action']);
	$tmp_search = array();

	//채용종류
	//print_r($job_arr);
	if ( $_GET['job_type_read'] != "" )
	{
		if ( in_array($_GET['job_type_read'],$job_arr) )
		{
			$tmp_search[] = " guin_type = '".$_GET['job_type_read']."' ";
			$plus.= "&job_type_read=".urlencode($_GET['job_type_read']);
		}
	}

	//나이
	if ( $_GET['guzic_age'] != "" )
	{
		$guzic_age = preg_replace("/\D/","",$_GET['guzic_age']);
		$guzic_age = date("Y") - $guzic_age + 1;
		$tmp_search[] = " guin_age <= '".$guzic_age."' ";
		$plus.= "&guzic_age=".urlencode($_GET['guzic_age']);
	}

	//직종
	$ex_category1 = preg_replace("/\D/","",$_GET['search_type']);
	$ex_category2 = preg_replace("/\D/","",$_GET['search_type_sub']);

	if ($ex_category1 && $ex_category2)
	{
		$category_query1 = " ( (type1 = '$ex_category1' and type_sub1 = '$ex_category2') ";
		$category_query1.= "or (type2 = '$ex_category1' and type_sub2 = '$ex_category2') ";
		$category_query1.= "or (type3 = '$ex_category1' and type_sub3 = '$ex_category2') ) ";

		$tmp_search[] = " $category_query1 ";

		$plus .= "&search_type=$ex_category1&search_type_sub=$ex_category2";

	}
	elseif ($ex_category1 && $ex_category2 == '')
	{
		$category_query1 = " (type1 = '$ex_category1' or type2 = '$ex_category1' or type3 = '$ex_category1' ) ";
		$tmp_search[] = " $category_query1 ";

		$plus .= "&search_type=$ex_category1";

	}
	else
	{
		$category_query1 = '';
	}

	//역세권
	if ( $_GET['underground1'] != '' )
	{
		$underground1 = preg_replace("/\D/","",$_GET['underground1']);
		$tmp_search[] = " underground1='".$underground1."' ";

		$plus.= "&underground1=".urlencode($_GET['underground1']);
	}

	if ( $_GET['underground2'] != '' )
	{
		$underground2 = preg_replace("/\D/","",$_GET['underground2']);
		$tmp_search[] = " underground2='".$underground2."'";

		$plus.= "&underground2=".urlencode($_GET['underground2']);
	}

	//경력
	$career_read = $_GET['career_read'];

	if ( $career_read != "" )
	{
		if ( $career_read == '무관' )
		{
			$career_search  = "";
		}
		else if ( $career_read == '신입' )
		{
			$career_search  = "(guin_career = '신입' or guin_career = '무관')";
			$tmp_search[] = " $career_search ";
		}
		elseif ( $career_read )
		{
			//echo $career_read."<hr>";
			$career_read_arr	= explode("~",$career_read);
			if ( sizeof($career_read_arr) == 2 )
			{
				$career_read_arr	= preg_replace("/\D/","",$career_read_arr);
				$career_search = " (guin_career = '경력' or guin_career = '무관') ";
				$career_search.= " AND ( CAST(guin_career_year as SIGNED) >= $career_read_arr[0] AND ( CAST(guin_career_year as SIGNED) <= $career_read_arr[1] ) ) ";

				$tmp_search[] = " $career_search ";
			}
			else
			{
				$career_read	= preg_replace("/\D/","",$career_read);
				$career_search = " (guin_career = '경력' or guin_career = '무관') ";
				$career_search.= " and CAST(guin_career_year as SIGNED) >= $career_read ";

				$tmp_search[] = " $career_search ";
			}
		}

		$plus .= "&career_read=$career_read";
	}

	//지역
	#ex_area2도 자동일것임.
	$ex_area1 = preg_replace("/\D/","",$_GET["search_si"]);
	$ex_area2 = preg_replace("/\D/","",$_GET["search_gu"]);

	if ($ex_area1 && $ex_area2)
	{
		#시구까지 존재
		$area_query_total	= "
								(
									gu1		= '$ex_area2'
									or
									gu2		= '$ex_area2'
									or
									gu3		= '$ex_area2'
									or
									si1		= '$SI_NUMBER[전국]'
									or
									si2		= '$SI_NUMBER[전국]'
									or
									si3		= '$SI_NUMBER[전국]'
								)
		";

		$tmp_search[] = "$area_query_total";

		$plus .= "&search_si=$ex_area1&search_gu=$ex_area2";
	}
	elseif ($ex_area1)
	{
		$area_query_total = " ( ";
		$area_query_total.= "(si1='$SI_NUMBER[전국]' or si2='$SI_NUMBER[전국]' or si3='$SI_NUMBER[전국]' ) ";
		$area_query_total.= "or (si1='$ex_area1' or si2='$ex_area1' or si3='$ex_area1') ";
		$area_query_total.= " ) ";

		$tmp_search[] = "$area_query_total";

		$plus .= "&search_si=$ex_area1&search_gu=$ex_area2";
	}
	else
	{
		$area_query_total = '';

		$plus .= "&search_si=$ex_area1";
	}

	//검색단어
	$title_read = $_GET['title_read'];
	if ($title_read)
	{
		$title_search = "(guin_title like '%$title_read%' OR guin_com_name  like '%$title_read%' OR keyword like '%$title_read%' )";
		$tmp_search[] = "$title_search";

		$plus .= "&title_read=".urlencode($title_read);
	}

	return $tmp_search;
}

#내가등록한구인리스트
#{{내가등록한구인리스트 총5개,가로1개,제목길이40자,진행중,member_guin_list.html,사용함}}
#{{내가등록한구인리스트 총5개,가로1개,제목길이40자,마감,member_guin_list.html,사용함}}
$guin_extraction_unique_number = 10000;	//채용정보 마다 고유출력번호
function guin_extraction_myreg($ex_limit,$ex_width,$ex_cut,$ex_type,$ex_template,$ex_paging)
{
	global $plus;
	global $_GET;
	global $GUIN_STATS;
	global $guin_stats_tb;
	global $guin_tb;
	global $list_temp;
	global $MEM;
	global $ADMIN;
	global $guin_banner_tb;
	global $CONF;
	global $ARRAY;
	global $ARRAY_NAME;
	global $ARRAY_NAME2;
	global $TPL;
	global $GUIN_INFO;
	global $banner_info;
	global $com_guin_per_tb;
	global $scrap_tb;
	global $user_id;

	global $TYPE;
	global $TYPE_SUB;
	global $last_update_date;
	global $per_document_tb;
	global $skin_folder;
	global $구인리스트페이징;

	global $option_info;
	global $pay_type;

	//새로운툴팁
	global $tool_tip_layer, $tool_tip_num;
	$tool_tip_num++;

	global $hunting_use;

	global $Happy_Img_Name;

	//회사로고 gif 원본출력여부 hong
	global $is_logo_gif_org_print;

	global $job_company;
	global $guin_extraction_unique_number;

	//검색폼의 이름을 고유하게 만들기 위해서
	$guin_extraction_unique_number++;

	//print_r(func_get_args());

	$ex_limit = preg_replace("/\D/","",$ex_limit);
	$ex_width = preg_replace("/\D/","",$ex_width);
	$ex_cut = preg_replace("/\D/","",$ex_cut);
	$ex_type = $ex_type;
	$ex_template = $ex_template;
	$ex_paging = $ex_paging;


	if ( !file_exists("./".$skin_folder."/".$ex_template) )
	{
		echo "./".$skin_folder."/".$ex_template." 파일이 존재하지 않습니다.";
		return;
	}

	if ( $ex_type == '마감')
	{
		$org_query = "where guin_id = '$MEM[id]' and guin_end_date < curdate() and guin_choongwon !='1'";
	}
	else if ($ex_type == '전체' )
	{
		$org_query = "where guin_id = '$MEM[id]'";
	}
	else if ($ex_type == '헤드헌팅' )
	{
		$org_query = "where company_number != 0";
	}
	else
	{
		$org_query = "where (guin_id = '$MEM[id]') and (guin_end_date >= curdate() or guin_choongwon ='1')";
	}


	//패키지옵션 사용페이지의 검색기능을 위해서 검색기능 추가
	if ( $_GET['action'] == "search" )
	{
		$tmp_search = guin_search_sql();

		if ( count($tmp_search) >= 1 )
		{
			$org_query.= " and ".implode(" and ", (array) $tmp_search);
		}
	}


	//헤드헌팅 추가
	if ( $hunting_use == true && $_GET['company_guin'] != '' )
	{
		$org_query		.= " AND company_number = '$_GET[company_guin]' ";
	}


	$sql = "select count(*) from $guin_tb $org_query ";
	#echo $sql;
	$result = query($sql);
	list($numb) = mysql_fetch_row($result);//총레코드수

	if ($start == "")
	{
		$start = $_GET[start];
	}
	if($start==0 || $start=="")
	{
		$start=0;
	}

	//페이지 나누기
	$total_page = ( $numb - 1 ) / $ex_limit + 1; //총페이지수
	$total_page = floor($total_page);
	$view_rows = $start;
	$co = $numb - $start;

	if ( $ex_paging == "사용안함" )
	{
		$view_rows = 0;
	}
	else
	{
		$Total			= $numb;
		$scale			= $ex_limit;
		if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
		$pageScale		= $_COOKIE['happy_mobile'] == 'on' ? 2 : 6;

		$searchMethod	.= $plus;
		$searchMethod	.= "&type=".$_GET['type'];

		$page_print		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		$구인리스트페이징 = $page_print;
	}

	//채용정보 점프
	global $HAPPY_CONFIG;
	$order_query = " order by number desc ";
	if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
	{
		$order_query = " order by guin_date desc ";
	}
	//채용정보 점프

	$up_time = "$MEM[id]" . "/" . happy_mktime();
	$sql2 = "select * ,(TO_DAYS(curdate())-TO_DAYS('2005-10-21')) as gap from $guin_tb $org_query $order_query limit $view_rows,$ex_limit";
	//echo $sql2."<br>";
	$result2 = query($sql2);
	$numb = mysql_num_rows($result2);//총레코드수

	if ( $numb == "0" )
	{
		$list_temp = "
			<table width='100%' cellpadding=0 cellspacing=3 border=0>
				<tr>
					<td align=center class='font_12' style='color:#909090; height:100px'>
						<div style='background:rgba(0,0,0,0.4); border-radius:5px; text-align:center;'><p class='font_16 noto400' style='color:#fff; padding:15px;'>설정된 채용정보가 없습니다.</p></div></td>
				</tr>
			</table>";
		return $list_temp;
		exit;
	}



	$TPL->define("리스트".$up_time, "./".$skin_folder."/".$ex_template);
	$i = 1;

	//새로운툴팁
	$tooltip_width	= $img_width == '' || $img_width == '0' ? '200' : round($img_width * 1.5);

	while ( $GUIN_INFO = happy_mysql_fetch_array($result2) )
	{
		//print_r2($GUIN_INFO);
		//echo $GUIN_INFO['guin_gender']."<br>";
		//채용정보에 설정된 정보를 이용해서 이력서를 검색하기 위한 항목들 정리
		//직종1 : guzic_jobtype1 = {{GUIN_INFO.type1}}
		//직종2 : guzic_jobtype2 = {{GUIN_INFO.type_sub1}}
		//구직종류 : job_type_read = {{GUIN_INFO.guin_type}}
		//지역(시) : guzic_si = {{GUIN_INFO.si1}}
		//지역(구) : guzic_gu = {{GUIN_INFO.gu1}}
		//성별 : guzic_prefix = {{GUIN_INFO.gender}} // 채용정보 DB에는 남자, 여자 로 저장되어 있지만, man or girl 이란 값을 넘겨줘야 함
		//학력 : guziceducation = {{GUIN_INFO.guin_edu_info}} //학력무관 이란 예외 항목이 있다.
		//급여형태 : grade_money_type = {{GUIN_INFO.guin_pay_type}}
		//급여 : guzic_money = {{GUIN_INFO.guin_pay}}
		//나이 : guzic_age_start = {{GUIN_INFO.guin_age_info}} //채용정보 DB에는 1990 같은 년도가 저장되어 있지만, 20세 같은 나이를 넘겨줘야 함
		//경력시작 : career_read_start = {{GUIN_INFO.career_read_start}}
		//경력끝 : career_read_end = {{GUIN_INFO.career_read_end}}
		//기업형태 : HopeSize = {{GUIN_INFO.HopeSize}}

		$GUIN_INFO['gender_info'] = "";
		if ( $GUIN_INFO['guin_gender'] == "남자" )
		{
			$GUIN_INFO['gender_info'] = "man";
		}
		else if ( $GUIN_INFO['guin_gender'] == "여자" )
		{
			$GUIN_INFO['gender_info'] = "girl";
		}

		$GUIN_INFO['guin_age_info'] = "";
		if ( $GUIN_INFO['guin_age'] > 0 )
		{
			$GUIN_INFO['guin_age_info'] = date("Y") - $GUIN_INFO['guin_age'] + 1;
		}

		$GUIN_INFO['guin_edu_info'] = $GUIN_INFO['guin_edu'];
		if ( $GUIN_INFO['guin_edu'] == "학력무관" )
		{
			 $GUIN_INFO['guin_edu_info'] = "";
		}

		//채용정보와 매칭되는 이력서를 검색하는 페이지로 이동하는 것을 폼 서브밋에서 링크로 변경함
		$GUIN_INFO['doc_searched_link'] = "guzic_list.php";
		$GUIN_INFO['doc_searched_link'].= "?file=guzic_list";
		$GUIN_INFO['doc_searched_link'].= "&guzic_jobtype1=".urlencode($GUIN_INFO['type1']);
		$GUIN_INFO['doc_searched_link'].= "&guzic_jobtype2=".urlencode($GUIN_INFO['type_sub1']);
		$GUIN_INFO['doc_searched_link'].= "&job_type_read=".urlencode($GUIN_INFO['guin_type']);
		$GUIN_INFO['doc_searched_link'].= "&guzic_si=".urlencode($GUIN_INFO['si1']);
		$GUIN_INFO['doc_searched_link'].= "&guzic_gu=".urlencode($GUIN_INFO['gu1']);
		$GUIN_INFO['doc_searched_link'].= "&guzic_prefix=".urlencode($GUIN_INFO['gender_info']);
		$GUIN_INFO['doc_searched_link'].= "&guziceducation=".urlencode($GUIN_INFO['guin_edu_info']);
		$GUIN_INFO['doc_searched_link'].= "&grade_money_type=".urlencode($GUIN_INFO['guin_pay_type']);
		$GUIN_INFO['doc_searched_link'].= "&guzic_money=".urlencode($GUIN_INFO['guin_pay']);
		$GUIN_INFO['doc_searched_link'].= "&guzic_age_start=".urlencode($GUIN_INFO['guin_age_info']);
		$GUIN_INFO['doc_searched_link'].= "&career_read_start=".urlencode($GUIN_INFO['career_read_start']);
		$GUIN_INFO['doc_searched_link'].= "&career_read_end=".urlencode($GUIN_INFO['career_read_end']);
		$GUIN_INFO['doc_searched_link'].= "&HopeSize=".urlencode($GUIN_INFO['HopeSize']);
		$GUIN_INFO['doc_searched_link'].= "&my=1";





		//회사정보 가져오기 - 2017-06-26 hong
		if ( $hunting_use == true && $GUIN_INFO['company_number'] != '' )
		{
			$Sql = "SELECT * FROM $job_company WHERE number = '{$GUIN_INFO['company_number']}'";
			$COM_INFO = happy_mysql_fetch_array(query($Sql));

			$GUIN_INFO['guin_com_name'] = $COM_INFO['company_name'];
		}

		//새로운툴팁
		$GUIN_INFO['tooltip_layer_id']	= 'happy_memool_'.$tool_tip_num.'_'.$GUIN_INFO['number'];


		//채용정보 점프
		if ( $HAPPY_CONFIG['guin_jump_use'] == "y" )
		{
			if( $_COOKIE['happy_mobile']  == 'on' )
			{
				$GUIN_INFO['btn_jump'] = '<a href="javascript:guin_jump(\''.$GUIN_INFO['number'].'\');" style="color:#fff">';
				$GUIN_INFO['btn_jump'].= '점프하기';
				$GUIN_INFO['btn_jump'].= '</a>';
			}
			else
			{
				$GUIN_INFO['btn_jump'] = '<a href="javascript:guin_jump(\''.$GUIN_INFO['number'].'\');">';
				$GUIN_INFO['btn_jump'].= '<img src="img/skin_icon/make_icon/skin_icon_694.jpg" alt="점프하기" align="absmiddle" border="0" style="margin-right:3px;">';
				$GUIN_INFO['btn_jump'].= '</a>';
			}

		}
		//채용정보 점프


		$banner_info = "";
		//패키지옵션 사용할때 보여야 할 부분
		$option_info = "";

		$j = '0';
		$now_info = "
		<table cellpadding=0 cellspacing=0 align=center bgcolor=#dfdfdf width=100%>
		<tr>
			<td>

				<table cellpadding=0 cellspacing=0 align=center width=100% >
				<tr>
					<td height=1 bgcolor=#dfdfdf colspan=3></td>
				</tr>
				<tr>
					<td bgcolor=#f9f9f9 align=center height=30 class=font_11 >옵션이름</td>
					<td bgcolor=#f9f9f9 align=center height=30 class=font_11>노출형태</td>
					<td bgcolor=#f9f9f9 align=center height=30 class=font_11>잔여정보</td>
				</tr>
				<tr>
					<td height=1 bgcolor=#dfdfdf colspan=3></td>
				</tr>
		";

		if( $_COOKIE['happy_mobile']  == 'on' )
		{
			$option_info = "
				<table cellspacing='0' style='width:100%; border-collapse: collapse;' regist_chart_01>
			";
		}
		else
		{
			$option_info = "
			<table cellspacing='0' style='width:100%; border-collapse: collapse;'>
				<tr>
					<td class='noto400 font_14' style='width:200px; background:#fafafa; color:#999999; letter-spacing:-1px; height:40px; border-bottom:1px solid #c5c5c5;' align='center'>옵션이름</td>
					<td class='noto400 font_14 ' style='width:240px; background:#fafafa; color:#999999; letter-spacing:-1px; height:40px; border-bottom:1px solid #c5c5c5; ' align='center'>노출형태</td>
					<td class='noto400 font_14' style='color:#999999; background:#fafafa; letter-spacing:-1px; height:40px; border-bottom:1px solid #c5c5c5; ' align='center'>잔여정보</td>
				</tr>
			";
		}


		foreach ($ARRAY as $list)
		{
			//채용정보의 옵션만 보여주자
			$list_use = $list."_use";
			if ( $ARRAY[$j] == "guin_docview"
				|| $ARRAY[$j] == "guin_docview2"
				|| $ARRAY[$j] == "guin_smspoint"
				|| $ARRAY[$j] == "guin_jump"
				|| $CONF[$list_use] == "사용안함" )
			{
				$j++;
				continue;
			}


			$list_option = $list . "_option";



			if ($CONF[$list_option] == '기간별')
			{
				$GUIN_INFO[$list] = $GUIN_INFO[$list] - $GUIN_INFO[gap]; #날짜가 마이너스인 사람은 광고가 끝인사람임
				$print_end = "일 남음";
			}
			else
			{
				$print_end = "회 남음";
			}

			if ($GUIN_INFO[$list] > 0)
			{
				$now_info .= "
				<tr bgcolor=#ffffff>
					<td height=25 style=padding-left:5px; align='center' class=font_11>$ARRAY_NAME[$j]</td>
					<td align=center class=font_11> $CONF[$list_option] </td>
					<td align=right style='padding-right:5px; letter-spacing:0;' class=font_11><font color=red>$GUIN_INFO[$list]</font> $print_end</td>
				</tr>
				<tr>
					<td height=1 bgcolor=#dfdfdf colspan=3></td>
				</tr>
				";


				if( $_COOKIE['happy_mobile']  == 'on' )
				{
					$option_info.= "
					<tr>
						<td class='pay_line_th' style='height:40px'>
							$ARRAY_NAME[$j] [ $CONF[$list_option]]
						</td>
						<td class='pay_line_td' style='text-align:right; color:#4587de'>
							$GUIN_INFO[$list] $print_end
						</td>
					</tr>
					";
				}
				else
				{
					$option_info.= "
					<tr>
						<td class='font_14 noto400' style='width:50px; height:60px; border:1px solid #c5c5c5; border-left:0 none; border-top:0 none; text-align:center'>
							$ARRAY_NAME[$j]
						</td>
						<td class='font_16 noto400' align='' style='width:220px; text-align:center; border:1px solid #c5c5c5; border-top:0 none; line-height:24px; letter-spacing:-1.2px; font-weight:bold'>
							 $CONF[$list_option]
						</td>
						<td class='font_14 noto400' style='padding-right:30px; text-align:right; border:1px solid #c5c5c5; border-right:0 none; letter-spacing:-1.2px'>
							$GUIN_INFO[$list] $print_end
						</td>
					</tr>
					";
				}
			}
			else
			{
				if( $_COOKIE['happy_mobile']  == 'on' )
				{
					$option_info.= "
					<tr>
						<td class='pay_line_th' style='height:40px'>
							$ARRAY_NAME[$j] [$CONF[$list_option]]
						</td>
						<td class='pay_line_td' style='text-align:right; color:#4587de'>
							옵션사용안함
						</td>
					</tr>
					";
				}
				else
				{
					$option_info.= "
					<tr>
						<td class='font_14 noto400' style='width:50px; height:60px; border:1px solid #c5c5c5; border-left:0 none; border-top:0 none; text-align:center'>
							$ARRAY_NAME[$j]
						</td>
						<td class='font_16 noto400' align='' style='width:220px; text-align:center; border:1px solid #c5c5c5; border-top:0 none; line-height:24px; letter-spacing:-1.2px; font-weight:bold'>
							 $CONF[$list_option]
						</td>
						<td class='font_14 noto400' style='padding-right:30px; text-align:left; border:1px solid #c5c5c5; border-right:0 none; letter-spacing:-1.2px; text-align:right'>
							옵션사용안함
						</td>
					</tr>
					";
				}
			}
			$j++;
		}

		$now_info .= "</table></td></tr></table>";
		$option_info .= "</table>";



		//패키지유료권 사용버튼
		if ( $MEM[id] == $GUIN_INFO['guin_id'] && $_GET['pack_number'] != "" )
		{
			if( $_COOKIE['happy_mobile'] == 'on' )
			{
				$GUIN_INFO['btn_package_use'] = '<input type="button" value="패키지 옵션사용" onclick="location.href=\'my_package_use.php?mode=use&guin_number='.$GUIN_INFO['number'].'&pack_number='.$_GET['pack_number'].'&pay_type=\'" style="color:#fff; background:#4587de">';
			}
			else
			{
				$GUIN_INFO['btn_package_use'] = '<a href="my_package_use.php?mode=use&guin_number='.$GUIN_INFO['number'].'&pack_number='.$_GET['pack_number'].'&pay_type=">';
				$GUIN_INFO['btn_package_use'].= '<img src="img/skin_icon/make_icon/skin_icon_712.jpg" align="absmiddle" border="0" alt="패키지옵션사용">';
				$GUIN_INFO['btn_package_use'].= '</a>';
			}

		}
		//패키지유료권 사용버튼



		if (eregi(":",$now_info))
		{
			$now_info_tmp = str_replace("\n","",$now_info);
			$now_info_tmp = str_replace("\t","",$now_info_tmp);
			$now_info_tmp = addslashes($now_info_tmp);

			$GUIN_INFO[tool_tip] = " data-tooltip='$GUIN_INFO[tooltip_layer_id]' ";
			$tool_tip_layer	.= "<div id='$GUIN_INFO[tooltip_layer_id]' class='atip' style='width:${tooltip_width}px'>$now_info_tmp</div>";

			#내용이 없다면
			$banner_info = "<a $GUIN_INFO[tool_tip] title='유료옵션 사용중'><img src=img/bt_myroom_com_sth_use.gif border=0 align=absmiddle></a>";


		}
		else
		{
			$banner_info = "<a href='member_option_pay.php?mode=pay&number=$GUIN_INFO[number]' title='현재 유료채용공고를 이용하고 있지 않습니다'>
				<img src=img/bt_myroom_com_sth_none.gif border=0 align=absmiddle>
				</a>
			";
		}

		#온라인 인재관리 읽어내기
		$sql31 = "select A.* from $com_guin_per_tb as A INNER JOIN $per_document_tb as D ON A.pNumber = D.number where A.cNumber = '$GUIN_INFO[number]' AND D.display = 'Y' ";
		#echo $sql31;
		$result31 = query($sql31);
		#list($GUIN_STATS[total_jiwon]) = mysql_fetch_row($result31);
		$GUIN_STATS[total_jiwon] = mysql_num_rows($result31);

		#온라인 미열람 인재관리 읽어내기
		#$sql31 = "select count(*) from $com_guin_per_tb where cNumber = '$GUIN_INFO[number]' AND read_ok='N'";
		$sql31 = "select A.* from $com_guin_per_tb as A INNER JOIN $per_document_tb as D ON A.pNumber = D.number where A.cNumber = '$GUIN_INFO[number]' AND A.read_ok='N' AND D.display = 'Y' ";
		$result31 = query($sql31);
		#list($GUIN_STATS[total_mi]) = mysql_fetch_row($result31);
		$GUIN_STATS[total_mi] = mysql_num_rows($result31);

		#온라인 스크랩 인재관리 읽어내기
		#$sql31 = "select count(*) from $scrap_tb where cNumber='$GUIN_INFO[number]' AND userid='$user_id' ";
		$sql31 = "select
							S.*,
							D.number as Dnumber,
							D.display as Ddisplay
						FROM
							$scrap_tb as S
						INNER JOIN
							$per_document_tb as D
						ON
							S.pNumber = D.number
						WHERE
							S.cNumber='$GUIN_INFO[number]'
						AND
							S.userid='$user_id'
						AND
							D.display = 'Y'
						";
		#echo $sql31;

		$result31 = query($sql31);
		#list($GUIN_STATS[total_scrap]) = mysql_fetch_row($result31);
		$GUIN_STATS[total_scrap] = mysql_num_rows($result31);

		#예비합격자
		#$sql31 = "select count(*) from $com_guin_per_tb where cNumber = '$GUIN_INFO[number]' AND doc_ok='Y' ";
		$sql31 = "select A.* from $com_guin_per_tb as A INNER JOIN $per_document_tb as D ON A.pNumber = D.number where A.cNumber = '$GUIN_INFO[number]' AND A.doc_ok='Y' AND D.display='Y' ";
		$result31 = query($sql31);
		#list($GUIN_STATS[total_pre_pass]) = mysql_fetch_row($result31);
		$GUIN_STATS[total_pre_pass] = mysql_num_rows($result31);


		#날짜줄이기
		list($GUIN_INFO[guin_date],$g_time) = split(" ",$GUIN_INFO[guin_date]);
		list($GUIN_INFO[guin_modify],$g_time) = split(" ",$GUIN_INFO[guin_modify]);

		if ($GUIN_INFO[guin_modify] == '0000-00-00')
		{
			$GUIN_INFO[guin_modify] = "수정정보없음";
		}

		#최종수정일
		if ($GUIN_INFO["guin_modify"] != "수정정보없음")
		{
			$last_update_date = $GUIN_INFO["guin_modify"];
		}
		else
		{
			$last_update_date = $GUIN_INFO["guin_date"];
		}


	/*
	#업직종 1없애기 >는 쉼표로
	$GUIN_INFO[guin_job] = str_replace("1","",$GUIN_INFO[guin_job]);
	$GUIN_INFO[guin_job] = str_replace(">",",",$GUIN_INFO[guin_job]);
	*/

	//print_r2($GUIN_INFO);
	//업.직종 추가함
	$GUIN_INFO["guin_job"] = "";
	if ($GUIN_INFO["type1"] != "0")
	{
		$GUIN_INFO["guin_job_1"] = $TYPE[$GUIN_INFO["type1"]];
		$GUIN_INFO["guin_job"] .= "1차 직종 : ".$TYPE[$GUIN_INFO["type1"]];
		if ($GUIN_INFO["type_sub1"] != "0")
		{
			$GUIN_INFO["guin_job"] .= " / ".$TYPE_SUB[$GUIN_INFO["type_sub1"]];
		}
	}

	if ($GUIN_INFO["type2"] != "0")
	{
		$GUIN_INFO["guin_job"] .= "<br>2차 직종 : ".$TYPE[$GUIN_INFO["type2"]];
		if ($GUIN_INFO["type_sub2"] != "0")
		{
			$GUIN_INFO["guin_job"] .= " / ".$TYPE_SUB[$GUIN_INFO["type_sub2"]];
		}
	}
	if ($GUIN_INFO["type3"] != "0")
	{
		$GUIN_INFO["guin_job"] .= "<br>3차 직종 : ".$TYPE[$GUIN_INFO["type3"]];
		if ($GUIN_INFO["type_sub3"] != "0")
		{
			$GUIN_INFO["guin_job"] .= " / ".$TYPE_SUB[$GUIN_INFO["type_sub3"]];
		}
	}
	//업.직종 추가함

	#구인마감일 정리
	if ($GUIN_INFO[guin_choongwon])
	{
		$GUIN_INFO[guin_end_date] = "충원시";
	}

	$GUIN_INFO[guin_title] = kstrcut($GUIN_INFO[guin_title], $ex_cut , "...");


	//구인나이
	$GUIN_INFO['guin_age_start'] = "";
	if ( $GUIN_INFO['guin_age'] != 0 )
	{
		$GUIN_INFO['guin_age_start'] = date("Y") - $GUIN_INFO['guin_age'] + 1;
	}

	//구인경력
	if ( $GUIN_INFO['guin_career'] != "무관" )
	{
		if ( $GUIN_INFO['guin_career_year'] != "" )
		{
			list($GUIN_INFO['career_read_start'],$GUIN_INFO['career_read_end']) = explode("~",$GUIN_INFO['guin_career_year']);

			$GUIN_INFO['career_read_start'] = $GUIN_INFO['career_read_start']."이상";
			$GUIN_INFO['career_read_end'] = $GUIN_INFO['career_read_end']."이하";
		}
	}

	//진행or마감여부
	if ( $GUIN_INFO['guin_end_date'] == "충원시" || $GUIN_INFO['guin_end_date'] > date("Y-m-d") )
	{
		$GUIN_INFO['guin_end_text']	= "진행중";
	}
	else
	{
		$GUIN_INFO['guin_end_text']	= "마감";
	}

	//마감일 카운터
	$GUIN_INFO['guin_end_dday'] = "충원시";
	$GUIN_INFO['guin_end_dday_display']			= "display:block;";
	if ( $GUIN_INFO['guin_end_date'] != "충원시" )
	{
		$tnow = date("Y-m-d H:i:s");
		$end_day = happy_date_diff($tnow,$GUIN_INFO["guin_end_date"]);
		//echo $GUIN_INFO["guin_end_date"].":".$end_day."<br>";
		if ( $end_day == 0 )
		{
			$GUIN_INFO['guin_end_dday'] = "D-Day";
			$GUIN_INFO['guin_end_dday_display']			= "display:block;";
		}
		else if ( $end_day < 0 )
		{
			$end_day = str_replace("-","",$end_day);
			$GUIN_INFO['guin_end_dday'] = "D-{$end_day}";
			$GUIN_INFO['guin_end_dday'] = "D+{$end_day}";
			$GUIN_INFO['guin_end_dday_display']			= "display:none;";
		}
		else
		{
			$GUIN_INFO['guin_end_dday'] = "D-{$end_day}";
			$GUIN_INFO['guin_end_dday_display']			= "display:block;";
		}
	}

	//업체로고구하기
	//photo3 채용정보 추출시 작은 배너
	//photo2 회사소개에서 쓰이는 큰 이미지
	$bns_img = $GUIN_INFO['photo2'];
	$bnl_img = $GUIN_INFO['photo3'];

	if ( $bnl_img == "" )
	{
		$GUIN_INFO[logo] = "./".$HAPPY_CONFIG['IconComNoLogo1']."";
	}
	else
	{
		$logo_img = explode(".",$bnl_img);

		//회사로고 gif 원본출력여부 hong
		if ( $is_logo_gif_org_print && preg_match("/gif/i",$logo_img[1]) )
		{
			$logo_temp = $logo_img;
		}
		else
		{
			$logo_temp = $logo_img[0].".".$logo_img[1];
		}

		if ( file_exists("./$logo_temp" ) )
		{
			$GUIN_INFO[logo] = "./$logo_temp";
			$Happy_Img_Name[0] = "./".$logo_temp;
		}
		else
		{
			$GUIN_INFO[logo] = "./$bnl_img";
		}
	}

	if ( $bns_img == "" )
	{
		$GUIN_INFO[com_logo] = "./".$HAPPY_CONFIG['IconComNoBanner1']."";
	}
	else
	{
		$banner_img = explode(".",$bns_img);

		//회사로고 gif 원본출력여부 hong
		if ( $is_logo_gif_org_print && preg_match("/gif/i",$banner_img[1]) )
		{
			$banner_temp = $banner_img;
		}
		else
		{
			$banner_temp = $banner_img[0].".".$banner_img[1];
		}

		if ( file_exists("./$banner_temp" ) )
		{
			$GUIN_INFO[com_logo] = "./$banner_temp";
			$Happy_Img_Name[0] = "./".$banner_temp;
		}
		else
		{
			$GUIN_INFO[com_logo] = "./$bns_img";
		}
	}

	$one_row = &$TPL->fetch("리스트".$up_time);
	$rows .= table_adjust($one_row,$ex_width,$i);
	$i++;
	/*
	$TPL->parse("리스트".$up_time);
	$list_temp = &$TPL->fetch();
	*/

}
	//$list_temp .= $TPL->fetch();
	/*
	if ( $ex_paging != "사용안함" )
	{
		$plus .= "&type=".$_GET['type'];
		include ("./page.php");
	}
	*/

	$rows = "<table cellpadding='0' cellspacing='0' border='0' width='100%'>".$rows."</table>";
	return $rows;
}

//로고위치 정하기
function position_logo($logo_width,$logo_height,$new_width,$new_height) {

	global $logo_position;

	switch ($logo_position) {

		//상단 중간
		case "H_C" :
			$LOGO["logo_x"] = ($new_width / 2) - ($logo_width / 2);
			$LOGO["logo_y"] = 0;
			break;
		//상단 왼쪽
		case "H_L" :
			$LOGO["logo_x"] = 0;
			$LOGO["logo_y"] = 0;
			break;
		//상단 오른쪽
		case "H_R" :
			$LOGO["logo_x"] = $new_width - $logo_width;
			$LOGO["logo_y"] = 0;
			break;
		//중앙 중앙
		case "C_C" :
			$LOGO["logo_x"] = ($new_width / 2) - ($logo_width / 2);
			$LOGO["logo_y"] = ($new_height / 2) - ($logo_height / 2);
			break;
		//중앙 왼쪽
		case "C_L" :
			$LOGO["logo_x"] = 0;
			$LOGO["logo_y"] = ($new_height / 2)  - ($logo_height / 2);
			break;
		//중앙 오른쪽
		case "C_R" :
			$LOGO["logo_x"] = $new_width - $logo_width;
			$LOGO["logo_y"] = ($new_height / 2)  - ($logo_height / 2);
			break;

		//하단 중앙
		case "L_C" :
			$LOGO["logo_x"] = ($new_width / 2) - ($logo_width / 2);
			$LOGO["logo_y"] = $new_height - $logo_height;
			break;
		//하단 왼쪽
		case "L_L" :
			$LOGO["logo_x"] = 0;
			$LOGO["logo_y"] = $new_height - $logo_height;
			break;
		//하단 오른쪽
		case "L_R" :
			$LOGO["logo_x"] = $new_width - $logo_width;
			$LOGO["logo_y"] = $new_height - $logo_height;
			break;
		default :
			break;
	}

	return $LOGO;

}

#중복투표방지로그 2010-02-10 kad
function poll_log($number)
{
	global $upso2_poll_log;

	$sql = "insert into ".$upso2_poll_log." set ";
	$sql.= "poll_number = '".$number."',";
	$sql.= "ip_addr = '".$_SERVER['REMOTE_ADDR']."',";
	$sql.= "date = now()";

	query($sql);
}

function poll_log_check($number)
{
	global $upso2_poll_log;

	$sql = "select count(*) from ".$upso2_poll_log." where poll_number = '".$number."' and ip_addr = '".$_SERVER['REMOTE_ADDR']."' ";
	$result = query($sql);
	list($cnt) = happy_mysql_fetch_array($result);

	if ( $cnt >= 1 )
	{
		return false;
	}
	else
	{
		return true;
	}
}
#중복투표방지로그 2010-02-10 kad



#채용정보열람권한
#관리자면 모두 열람
#비회원이면 열람불가
#기업회원이면 열람불가
#기업회원이면 자기가 등록한것만 열람가능
#개인회원이면, 기간별 / 회수별 조사
#무료면 모두 열람
function guin_view_numbers($id)
{
	global $job_per_guin_view_tb;

	$guin_view_numbers = array();

	$sql = "select * from ".$job_per_guin_view_tb." where per_id = '".$id."'";
	$result = query($sql);
	while ( $row = happy_mysql_fetch_assoc($result) )
	{
		array_push($guin_view_numbers,$row['guin_number']);
	}

	return $guin_view_numbers;
}

function guin_view($Guin)
{
	global $CONF;
	global $mem_id;
	global $real_gap;
	global $guin_view_numbers;
	global $MEM;
	global $happy_member_secure_text;


	#무료
	if ( $CONF['paid_conf'] == 0 )
	{
		return true;
	}
	#관리자
	if ( $_COOKIE['ad_id'] != "" )
	{
		return true;
	}
	#설정안됨
	if ( $CONF['guzic_view'] == "" && $CONF['guzic_view2'] == "" )
	{
		return true;
	}


	if ( happy_member_login_check() != "" )
	{
		if ( happy_member_login_check() == $Guin['guin_id'] )
		{
			//등록인
			return true;
		}
		else if ( happy_member_secure($happy_member_secure_text[1].'보기 유료결제') )
		{
			if ( $MEM['guzic_view'] > $real_gap || in_array($Guin['number'],$guin_view_numbers) )
			{
				//기간별 채용정보보기 옵션이 있거나, 회수별로 볼수 있는 회원
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	else
	{
		#비회원
		return false;
	}
}

//{{실명인증 파일명}}
//{{실명인증 namecheck.html}}
function namecheck($template_file,$template_file2,$template_file3)
{
	global $TPL;
	global $skin_folder;
	global $HAPPY_CONFIG;
	$nameCheck = "";



	//실명인증이거나 성인인증이면 폼 출력됨
	//KCB실명인증을 사용함으로 해야 성인인증을 사용할수 있고,
	//실명인증을 사용하지 않으면 성인인증을
	if ( $HAPPY_CONFIG['kcb_namecheck_use'] == '1' || $HAPPY_CONFIG['kcb_adultcheck_use'] == '1' )
	{
		//휴대폰인증:hp		,아이핀인증:ipin
		if( $HAPPY_CONFIG['kcb_check_type'] == "ipin" )
		{
			$TPL->define("실명인증파일", "$skin_folder/$template_file");
		}
		else if( $HAPPY_CONFIG['kcb_check_type'] == "hp" )
		{
			$TPL->define("실명인증파일", "$skin_folder/$template_file2");
		}
		else if( $HAPPY_CONFIG['kcb_check_type'] == "ipin_hp" )
		{
			$TPL->define("실명인증파일", "$skin_folder/$template_file3");
		}

		$nameCheck = &$TPL->fetch();
	}
	else
	{
		if ( $template_file == "" )
		{
			$template_file = "namecheck.html";
		}

		//$template_file = str_replace(".html","_no.html",$template_file);
		$template_file = "namecheck_no.html";

		//echo "$skin_folder/$template_file";
		if ( !file_exists("$skin_folder/$template_file") )
		{
			echo "$skin_folder/$template_file 파일이 존재하지 않습니다.";
			return;
		}

		$TPL->define("실명인증파일X", "$skin_folder/$template_file");
		$nameCheck = &$TPL->fetch();
	}

	echo $nameCheck;
}







#게시판 캘린더 2010-05-19 ralear
//{{게시판스케쥴 자동,bbs_list_schedule_h.html,bbs_calendar_empty_rows.html,bbs_calendar_rows.html,빈공간색깔,날짜있는공간색깔,한칸가로크기}}
function board_extraction_calendar($getDate,$ex_template_h,$ex_template_blank,$ex_template_noblank, $empthColor="#ffffff", $fullColor="#ffffff",$ex_width="100",$ex_height="100")
{

	global $TPL, $skin_folder_bbs, $날짜없는공간색깔, $날짜, $날짜있는공간색깔, $날짜색깔;
	global $TodayBar;
	global $tb,$regi_startdate;
	global $table_width,$height,$width,$prev_year,$prev_month,$title_width,$year,$month,$next_year,$next_month;


	# 달력 날짜공간 크기지정
	$width = preg_replace("/\D/","",$ex_width);
	$height = preg_replace("/\D/","",$ex_height);
	$title_width = $width * 5;
	$title_height = $height * 5;
	$table_width = $width * 7;

	$날짜없는공간색깔 = $empthColor;
	$날짜있는공간색깔 = $fullColor;

	if ( $getDate == '자동' )
	{
		$year	= date("Y");
		$month	= date("m");
	}
	else
	{
		$getDate	= explode("/", $getDate);
		$year		= preg_replace("/\D/", "", $getDate[0]);
		$month		= preg_replace("/\D/", "", $getDate[1]);
	}

	# 화살표로 달력을 이동했을 경우
	if ( $_GET['year'] != '' && $_GET['month'] != '' )
	{
		$year	= $_GET['year'];
		$month	= $_GET['month'];

		$prev_year = $_GET['year'];
		$next_year = $_GET['year'];

		$prev_month = $_GET['month'] - 1;
		$next_month = $_GET['month'] + 1;
	}

	# 다음년도로 넘어가는 경우
	if ( $_GET['month'] == 13 )
	{
		$year	= $_GET['year'] + 1;
		$month	= 1;

		$next_year = $_GET['year'] + 1;
		$next_month = 2;
	}
	# 이전년도로 넘어가는 경우
	else if ( $_GET['month'] == 0 && $_GET['month'] != '' )
	{
		$year	= $_GET['year'] - 1;
		$month	= 12;

		$prev_year = $_GET['year'] - 1;
		$prev_month = 11;
	}
	else
	{
		if ( $month == 1 )
		{
			$prev_year = $year - 1;
			$next_year = $year;
			$prev_month = 12;
			$next_month = 2;
		}
		else if ( $month == 12 )
		{
			$prev_year = $year;
			$next_year = $year + 1;
			$prev_month = 11;
			$next_month = 1;
		}
		else
		{
			$prev_year = $year;
			$next_year = $year;
			$prev_month = $month - 1;
			$next_month = $month + 1;
		}
	}


	$firstday	= date("w", happy_mktime(0,0,0,$month,1,$year));	// 첫째날의 요일을 얻어옴
	$totalDays	= date("t", happy_mktime(0,0,0,$month,1,$year));	// 날짜 수를 얻어옴

	$Week = array("일","월","화","수","목","금","토");


	//달력상단 템플릿
	$TPL->define("달력상단", "$skin_folder_bbs/$ex_template_h");
	$TPL->assign("달력상단");
	$tmp_str = &$TPL->fetch("달력상단");
	echo $tmp_str;
	//달력상단 템플릿







	#################### 스케쥴배열 조립시작 ########################

	// 스케쥴배열생성
	$SchArr				= Array();

	// 한주 쿼리를 돌리기 위한 배열변수
	$WeekStartNumArr	= Array();
	$WeekEndNumArr		= Array();

	// 이번달이 몇주인지 계산
	$TotalWeekNum = 1;
	for ( $i = 1; $i <= $totalDays; $i++ )
	{
		$TodayNum = date("w", happy_mktime(0,0,0,$month,$i,$year));
		if ( $TodayNum == 0 && $i != 1 )
		{
			$TotalWeekNum++;
		}

		if ( $i == 1 || $TodayNum == 0 ){
			array_push($WeekStartNumArr, $i);
		}

		if ( $TodayNum == 6 || $i == $totalDays ){
			array_push($WeekEndNumArr, $i);
		}
	}

	if ( strlen($month) == 1 ) {
		$month = str_pad($month, 2, '0', STR_PAD_LEFT);
	}



	for ( $i = 0; $i < $TotalWeekNum; $i++ )
	{
		$StartDay = $WeekStartNumArr[$i];
		if ( strlen($StartDay) == 1 ) {
			$StartDay = str_pad($StartDay, 2, '0', STR_PAD_LEFT);
		}

		$EndDay = $WeekEndNumArr[$i];
		if ( strlen($EndDay) == 1 ) {
			$EndDay = str_pad($EndDay, 2, '0', STR_PAD_LEFT);
		}

		$Sql = "
				SELECT
				*
				FROM
					$_GET[tb]
				WHERE
					(
						startdate <= '$year-$month-$StartDay'
						AND
						enddate >= '$year-$month-$StartDay'
					)
					OR
					(
						( startdate BETWEEN '$year-$month-$StartDay' AND '$year-$month-$EndDay'
							and enddate >= '$year-$month-$StartDay' )
						OR
						( enddate BETWEEN '$year-$month-$StartDay' AND '$year-$month-$EndDay' )
					)
				ORDER BY NUMBER ASC
		";
		//echo $Sql."<br><br>";
		$Result = query($Sql);

		$SchArr[$i]	= Array();
		while ( $Data = happy_mysql_fetch_array($Result) )
		{
			$SchStartDay_Tmp	= $Data['startdate'];
			$SchStartDay_Tmp	= explode("-", $Data['startdate']);
			$SchStartDay_Year	= $SchStartDay_Tmp[0];
			$SchStartDay_Month	= $SchStartDay_Tmp[1];
			$SchStartDay		= $SchStartDay_Tmp[2];	// 스케쥴 시작날짜

			$SchEndDay_Tmp		= $Data['enddate'];
			$SchEndDay_Tmp		= explode("-", $Data['enddate']);
			$SchEndDay_Year		= $SchEndDay_Tmp[0];	// 스케쥴 끝날짜
			$SchEndDay_Month	= $SchEndDay_Tmp[1];	// 스케쥴 끝날짜
			$SchEndDay			= $SchEndDay_Tmp[2];	// 스케쥴 끝날짜



			if ( $SchStartDay < $StartDay ){
				$SchStartDay = $StartDay;
			}

			if ( $SchEndDay > $EndDay ){
				$SchEndDay = $EndDay;
			}

			#echo $year."-".$month."-".$SchStartDay."<br>";
			#echo $year."-".$month."-".$SchEndDay."<br>";
			#exit;

			$SchStartDay	= date("w", happy_mktime(0,0,0,$month,$SchStartDay,$year));
			$SchEndDay		= date("w", happy_mktime(0,0,0,$month,$SchEndDay,$year));

			if ( $month != $SchStartDay_Month ){
				$SchStartDay = date("w", happy_mktime(0,0,0,$month,1,$year));
			}

			if ( $month != $SchStartDay_Month && $i != 0 ){
				$SchStartDay = 0;
			}

			if ( $month != $SchEndDay_Month ){
				$SchEndDay = date("w", happy_mktime(0,0,0,$month,$WeekEndNumArr[$i],$year));
			}



	#################### 변수 정리시작 #####################

	#WeekStartNumArr[$i]	= 한주의 일요일날짜
	#EndDay					= 한주의 끝나는 배열번호				ex) 토요일은 [6]

	#WeekEndNumArr[$i]		= 한주의 토요일날짜
	#StartDay				= 한주의 시작하는 배열번호				ex) 일요일은 [0]

	#SchStartDay			= 스케쥴시작 배열번호					ex) 일요일은 [0]	[X][SchStartDay][X]
	#SchEndDay				= 스케쥴끝 배열번호						ex) 토요일은 [6]	[X][SchEndDay][X]

	#echo "SchStartDay = $SchStartDay || SchEndDay = $SchEndDay <br>";

	#################### 변수 정리끝   #####################

			# 스케쥴 깊이검사 시작
			$Tmp	= $SchStartDay;
			$depth	= 0;

			if ( $SchStartDay == $SchEndDay ) // 스케쥴이 하나짜리일때
			{
				while (1) // 한스케쥴당 깊이를 검사하고 깊이가 빈곳의 depth를 찾는다.
				{
					if ( $SchArr[$i][$Tmp][$depth] )
					{
						$depth++;
					}
					else
					{
						break;
					}
				}
			}
			else
			{
				while (1) // 한스케쥴당 깊이를 검사하고 깊이가 빈곳의 depth를 찾는다.
				{
					if ( $SchArr[$i][$Tmp][$depth] )
					{
						$depth++;
						$Tmp = $SchStartDay - 1;
					}

					if ( $Tmp == $SchEndDay )
					{
						break;
					}

					$Tmp++;

					# 무한루프방지용
					if( $Tmp > 6 )
					{
						//echo "무한루프 돌뻔했어용 ^^;";
						break;
					}
				}
			}
			# 스케쥴 깊이검사 끝



			// 배열에 스케쥴삽입
			//게시글제목,배경색,게시글번호,폰트색
			for ( ; $SchStartDay <= $SchEndDay; $SchStartDay++ )
			{
				$SchArr[$i][$SchStartDay][$depth] = $Data['bbs_title']."||".$Data['barcolor']."||".$Data['number']."||".$Data['fontcolor'];
				//echo "SchArr[".$i."][".$SchStartDay."][".$depth."] =  $Data[bbs_title]<br />";
			}
		}
	}

	#################### 스케쥴배열 조립끝 #########################




//print_r2($SchArr);
	ob_start();
	//echo "<table border='1' width='$table_width' cellspacing='0' cellpadding='0'>";
	//echo "<tr height='100'>";

	$TPL->define("날짜없는공간", "$skin_folder_bbs/$ex_template_blank");
	$날짜없는공간 = &$TPL->fetch("날짜없는공간");

    # 첫째날 해당 요일전까지 빈칸 출력
    $col = 0;

    for( $i = 0; $i < $firstday; $i++ )
    {
        echo "<td width='$width' valign='top'>$날짜없는공간</td>";
        $col++;
    }

    # 1일부터 마지막날까지 출력
	$DayColor	= $firstday;
	$WeekNum	= 0;
    for( $j = 1; $j <= $totalDays; $j++ )
    {
		switch( $Week[$DayColor] )
		{
			case "토"	: $날짜색깔 = "blue";	break;
			case "일"	: $날짜색깔 = "red";	break;
			default		: $날짜색깔 = "black";	break;
		}

		$날짜		= $j;
		$DayNum		= date("w", happy_mktime(0,0,0,$month,$j,$year));
		$TodayBar	= '';

		# 배열에 빈값삽입 시작
		$EmptyArr = $SchArr[$WeekNum][$DayNum];
		if ( is_array($EmptyArr) )
		{
			$EmptyArr = array_keys($EmptyArr);
			$SchArrNum = 0;
			foreach( $EmptyArr as $key )
			{
				if ( $SchArrNum < $key ){
					$SchArrNum = $key;
				}
			}

			for ( $x = 0; $x < $SchArrNum; $x++ )
			{
				if ( $SchArr[$WeekNum][$DayNum][$x] == '' )
				{
					$SchArr[$WeekNum][$DayNum][$x] = '&nbsp;';
				}
			}
		}
		# 배열에 빈값삽입 끝
		# echo "$j 일은 = 깊이숫자가 $SchArrNum";
		if ($SchArrNum >= 0 && sizeof($EmptyArr) > 0 )
		{
			for ( $z = 0; $z <= $SchArrNum; $z++ )
			{
				$bbs_tmp	= explode("||", $SchArr[$WeekNum][$DayNum][$z]);
				$bbs_title	= kstrcut($bbs_tmp[0],"14","..");
				$bbs_color	= $bbs_tmp[1];
				$bbs_number = $bbs_tmp[2];
				$font_color = $bbs_tmp[3];


				$onMouseOver	= '';
				$onMouseOut		= '';
				$cursor			= '';

				if ($bbs_title != '&nbsp;')
				{
					$onMouseOver	= "onMouseOver	= \"this.style.filter = 'alpha(opacity=50)'\"";
					$onMouseOut		= "onMouseOut	= \"this.style.filter = 'alpha(opacity=100)'\"";
					$cursor			= "cursor:pointer";
				}

				$TodayBar .= "<div style='background-color:$bbs_color;$cursor;' $onMouseOver $onMouseOut><a href='bbs_detail.php?tb=$tb&bbs_num=$bbs_number'><font color='$font_color'>$bbs_title</font></a></div>";
			}
		}

		//등록시 기본시작일
		$regi_startdate = $year."-".$month."-".sprintf("%02d",$j);

        echo "<td width='$width' valign='top'>";


		$TPL->define("날짜있는공간", "$skin_folder_bbs/$ex_template_noblank");
		$날짜있는공간 = &$TPL->fetch();

		echo "$날짜있는공간";
		echo "</td>";

        $col++;

        if( $col == 7 )	// 토요일까지 출력후 테이블 줄 바꿈처리
		{
            echo "</tr>";
            if ( $j != $totalDays ) {
               echo("<tr height='$height'>");
			}

            $col = 0;
			$WeekNum++;
		}

		if ( $DayColor % 6 == 0 && $DayColor != 0) {
		  $DayColor = 0;
		}
		else {
		  $DayColor++;
		}
    }

    # 마지막날 출력 후 마지막 줄 빈칸 채움
    while( $col > 0 && $col < 7 )
    {
        echo "<td>$날짜없는공간</td>";
        $col++;
    }

    echo "</tr></table>";

	$buffer_output = ob_get_contents();
	ob_end_clean();

	echo $buffer_output;

}


//{{온라인입사지원내역 전체,가로1개,rows_online_jiwon.html,rows_online_jiwon_h.html}}
//관리자 또는 채용정보를 등록한 기업회원은 볼수가 있도록 기능 변경됨 2011-02-18 kad
function online_jiwon_list($ex_limit,$ex_width,$ex_template,$ex_template_h)
{
	global $com_guin_per_tb,$com_guin_per_tb_log,$guin_tb,$per_document_tb;
	global $skin_folder;
	global $Online;
	global $online_stats;
	global $mem_id;

	//이력서 고유번호
	$doc_number = $_GET['number'];

	//관리자 + 채용정보를 등록한 기업회원만 볼수가 있어야 함
	if ( !admin_secure("최고관리자") )
	{
		$is_view = false;
		$guin_id_sql = "";

		$sql = "select * from $com_guin_per_tb where pNumber = '".$doc_number."'";
		$result = query($sql);
		while ( $row = happy_mysql_fetch_assoc($result) )
		{
			if ( $row['com_id'] == $mem_id )
			{
				$is_view = true;
				$guin_id_sql = " AND G.guin_id = '".$mem_id."' ";
				break;
			}
		}
		//echo var_dump($is_view);
	}

	if ( !admin_secure("최고관리자") && $is_view == false )
	{
		return;
	}

	$TPL2 = new Template;
	//print_r(func_get_args());

	$limit_sql = "";
	if ( $ex_limit != "전체" )
	{
		$ex_limit = preg_replace("/\D/","",$ex_limit);
		$limit_sql = " limit 0,$ex_limit ";
	}

	$ex_width = preg_replace("/\D/","",$ex_width);
	$ex_template = $ex_template;

	//$ex_cut = preg_replace("/\D/","",$ex_cut);
	//$ex_type = $ex_type;
	//$ex_paging = $ex_paging;



	$sql = "SELECT ";
	$sql.= "L.number as lNumber, ";
	$sql.= "L.regdate as regdate, ";
	$sql.= "L.bNumber as bNumber, ";		//입사지원 고유번호
	$sql.= "L.cNumber as cNumber, ";
	$sql.= "L.pNumber as pNumber, ";
	$sql.= "L.online_stats as online_stats, ";
	$sql.= "G.number as gNumber, ";
	$sql.= "G.guin_title as guin_title, ";
	$sql.= "G.guin_com_name as com_name, ";

	$sql.= "G.guin_id as guin_id ";
	$sql.= "FROM ".$com_guin_per_tb_log." as L ";
	$sql.= " left join ";
	$sql.= $guin_tb." as G ";
	$sql.= "ON L.cNumber = G.number ";
	$sql.= "WHERE L.pNumber = '".$doc_number."' ";
	$sql.= $guin_id_sql;
	$sql.= "ORDER BY L.bNumber asc, L.regdate asc ";
	$sql.= $limit_sql;

	//echo $sql;

	$result = query($sql);
	$last_number = mysql_num_rows($result);

	$rand = rand(0,100);
	$i = 1;
	$TPL2->define("온라인지원$rand", "$skin_folder/$ex_template");
	while ( $Online = happy_mysql_fetch_assoc($result) )
	{
		//print_r2($Online);
		$Online['last_number'] = $i;

		$tmpDate = explode(" ",$Online['regdate']);
		$Online['regdate_ymd'] = $tmpDate[0];
		$Online['regdate_his'] = $tmpDate[1];

		$Online['online_stats_text'] = $online_stats[$Online['online_stats']];



		$one_row = &$TPL2->fetch("온라인지원$rand");
		$rows .= table_adjust($one_row,$ex_width,$i);

		$i++;
		$last_number--;
	}



	if ( $i == 1 )
	{
		return "<table width='100%' border='0' cellpadding='0' cellspacing='0' style='background:#fafafa; height:100px; line-height:100px; border:1px solid #ddd;'><tr><td align='center' style='font-size:15px;'><div style='background:rgba(0,0,0,0.4); border-radius:5px; text-align:center;'><p class='font_16 noto400' style='color:#fff; padding:15px;'>온라인입사지원 상태 변경내역이 없습니다.</p></div></td></tr></table>";
	}
	else
	{
		//제목부분
		$TPL2->define("온라인지원제목$rand", "$skin_folder/$ex_template_h");
		$table_h = $TPL2->fetch("온라인지원제목$rand");

		return $table_h."<table width='100%' border='0' cellpadding='0' cellspacing='0'>$rows</table>";
	}

}





function happy_admin_ipCheck()
{
	global $happy_admin_ip, $happy_admin_ipTable;
	global $_COOKIE;
	global $admin_id, $admin_pw;

	if( $_COOKIE['ad_id'] != "" && $_COOKIE['ad_pass'] != "" )
	{
		$connect_ip_tmp = explode(".", $_SERVER['REMOTE_ADDR']);
		foreach ( $happy_admin_ip as $happy_admin_ipTable_value )
		{
			$ipCheckTmp		= explode(".", $happy_admin_ipTable_value);
			$ipCheckBool	= false;
			foreach ( $ipCheckTmp as $key => $ipCheckTmp_value )
			{
				if ( $ipCheckTmp_value == $connect_ip_tmp[$key] )
				{
					$ipCheckBool = true;
				}
				else
				{
					$ipCheckBool = false;
					break;
				}
			}

			if ( $ipCheckBool == true )
			{
				break;
			}
		}

		if ( $ipCheckBool == false )
		{
			setcookie("ad_id", "", 0, "/");
			setcookie("ad_pass", "", 0, "/");

			$_COOKIE['ad_id']	= '';
			$_COOKIE['ad_pass']	= '';
			$admin_id			= '';
			$admin_pw			= '';

			$Sql					= "
										INSERT INTO
												$happy_admin_ipTable
										SET
												ip			= '$_SERVER[REMOTE_ADDR]',
												browser		= '$_SERVER[HTTP_USER_AGENT]',
												referer		= '$_SERVER[HTTP_REFERER]',
												reg_date	= now()
			";
			query($Sql);
		}
	}
}


# 해당 플래쉬소스는 무료공개용 플래쉬소스를 이용하였습니다
# {{구름태그3d 가로300,세로300,10개출력,스피드100,000000,15}}
function cloud_tag_3d($width = 300, $height = 300, $TagCount = 10, $TagSpeed = 100, $OverColor = "000000", $FontSize = 12, $FontColor = "", $BgColor = '')
{
	$width				= preg_replace('/\D/', '', $width)."px";
	$height				= preg_replace('/\D/', '', $height)."px";
	$OverColor			= "0x".$OverColor;
	$TagSpeed			= preg_replace('/\D/', '', $TagSpeed);

	$BgColor_Tag		= "";
	if ( $BgColor == "" )
	{
		$BgColor_Tag	= "so.addParam('wmode', 'transparent')";
	}
	else
	{
		$BgColor		= "#".$BgColor;
	}

	########## XML 생성 인자들 ##########
	$TagCount			= preg_replace('/\D/', '', $TagCount);
	$FontSize			= preg_replace('/\D/', '', $FontSize);
	#############################

	$flash_folder		= "flash_swf/3d_cloud_tag";
	$xmlpath			= "xml_tagcloud.php";

	$flashtag			= "
		<script type='text/javascript' src='$flash_folder/swfobject.js'></script>
		<div id='flashcontent'></div>
		<script type='text/javascript'>
		var so = new SWFObject('$flash_folder/tagcloud.swf', 'tagcloud', '$width', '$height', '7', '$BgColor');
		$BgColor_Tag
		so.addVariable('hicolor', '$OverColor');
		so.addVariable('tspeed', '$TagSpeed');
		so.addVariable('xmlpath', '$xmlpath');
		so.addVariable('opt1', '$TagCount');
		so.addVariable('opt2', '$FontSize');
		so.addVariable('opt3', '$FontColor');
		so.addVariable('distr', 'true');
		so.write('flashcontent');
		</script>
	";

	print $flashtag;
}








#################################################################

//썸네일생성 타입
#비율대로짜름
#비율대로축소
#비율대로확대
#가로기준세로짜름
#세로기준가로짜름
#가로기준
#세로기준
//{{이미지 자동,가로135,세로100,로고사용안함,로고위치7번,퀄리티100,gif원본출력,img/noimg/noimg_w135h100.gif,비율대로짜름}}
function happy_image($img_name,$img_width,$img_height,$logo_use="로고사용안함",$logoPosition="7",$img_quality="100",$return_type="썸네일",$no_img="img/noimage.jpg",$Tthumb_type="",$thumbPosition="")
{
	#넘어온값 처리
	$img_width			= preg_replace('/\D/', '', $img_width);		#가로
	$img_height			= preg_replace('/\D/', '', $img_height);	#세로
	$img_quality_org	= $img_quality;
	$img_quality		= preg_replace('/\D/', '', $img_quality);	#퀄리티
	$logoPosition		= preg_replace('/\D/', '', $logoPosition);	#로고위치

	global $wys_url;
	global $file_attach_folder;
	global $file_attach_thumb_folder;
	global $Happy_Img_Name;
	global $Logo_Img_Name;
	global $main_url;


	# 퀄리티 기본 지정값 kwak16 - 20180416
	global $happy_image_sizes;
	if ( $img_quality_org != $img_quality )
	{
		$quality_tmp		= preg_replace("/\D/", "", $happy_image_sizes[$img_quality_org]);
		if ( $quality_tmp != '' && $quality_tmp > 20 )
		{
			$img_quality		= $quality_tmp;
		}
	}

	if ( $logo_use == "로고사용함" )
	{
		$logo_use = "Y";
		$logo_file = $Logo_Img_Name;
	}
	else
	{
		$logo_use = "N";
		$logo_file = "";
	}

	#print_r2($Happy_Img_Name);

	if ( preg_match("/자동/",$img_name) )
	{
		$tmp_colname = preg_replace("/자동/","",$img_name);
		if ( $tmp_colname == "" )
		{
			$tmp_colname = 0;
		}
		$ExArray = $Happy_Img_Name;
	}
	else
	{
		$tmp_img = explode(".",$img_name);		#출력배열
		//print_r2($tmp_img);
		$tmp_colname = $tmp_img[1];				#이미지컬럼명
		eval("global $".$tmp_img[0].";");
		$ExArray = $$tmp_img[0];
	}


	#원본이미지 솔루션마다 변경되어야 함
	//타사이트 이미지 퍼온경우 원본이미지 그대로 사용
	//$ExArray[$tmp_colname] = "http://mall6.cgimall.co.kr/admin/img/title_admin_mode2.gif";
	if ( preg_match("/http(|s):\/\//i",$ExArray[$tmp_colname]) )
	{
		//echo  preg_replace("/^\.{0,2}/","",$ExArray[$tmp_colname])."<BR>";
		return preg_replace("/^[\.]{0,2}[\/]{0,1}/","",$ExArray[$tmp_colname]);
	}

	$TmpWonFile = explode("/",$ExArray[$tmp_colname]);
	$TmpWonFileName = array_pop($TmpWonFile);
	$TmpWonFilePath = implode("/",$TmpWonFile);

	$TmpThumbFilePath = $TmpWonFilePath;


	# 이미지 생성 경로 변경 kwak16 - 20180416
	if ( preg_match("/^\.\//",$TmpWonFilePath) )
	{
		$TmpThumbFilePath	= preg_replace("/^\.\//","",$TmpThumbFilePath);
	}
	# ../ 값으로 시작시에는 ../를 제거하고 앞에 붙여주기.
	if ( preg_match("/^\.\.\//",$TmpWonFilePath) )
	{
		$TmpThumbFilePath	= preg_replace("/^\.\.\//","",$TmpThumbFilePath);
		$TmpThumbFilePath	= '../upload/happy_thumb/'.$img_width."x".$img_height."_".$img_quality.'/'. $TmpThumbFilePath;
	}
	else
	{
		$TmpThumbFilePath	= './upload/happy_thumb/'.$img_width."x".$img_height."_".$img_quality.'/'. $TmpThumbFilePath;
	}


	#상품사진
	#$TmpThumbFilePath = preg_replace("/file_attach\//","file_attach_thumb/",$TmpThumbFilePath);

	#생성파일명구분자
	switch( $Tthumb_type )
	{
		case "비율대로짜름":
			$Tthumb_type_file = "0";
			break;
		case "비율대로축소":
			$Tthumb_type_file = "1";
			break;
		case "비율대로확대":
			$Tthumb_type_file = "2";
			break;
		case "가로기준세로짜름":
			$Tthumb_type_file = "3";
			break;
		case "세로기준가로짜름":
			$Tthumb_type_file = "4";
			break;
		case "가로기준":
			$Tthumb_type_file = "5";
			break;
		case "세로기준":
			$Tthumb_type_file = "6";
			break;
		default :
			$Tthumb_type_file = "7";
			break;
	}

	if ( is_file($ExArray[$tmp_colname]) )
	{
		$TmpWon = explode(".",$TmpWonFileName);
		$wonbon_img = $TmpWonFilePath."/".$TmpWonFileName;

		#썸네일이미지파일명
		#원본파일_로고_가로x세로_퀄리티.확장자
		if ( $TmpWon[1] != "" )
		{
			//$thumb_img_name = $TmpWon[0]."_".$logo_use."_".$img_width."x".$img_height."_".$img_quality."_".$Tthumb_type_file.".".$TmpWon[1];
			$thumb_img_name = $TmpWon[0]."_".$logo_use."_".$logoPosition."_".$img_width."x".$img_height."_".$img_quality."_".$Tthumb_type_file."_".$thumbPosition.".".$TmpWon[1];
		}
		else
		{
			//$thumb_img_name = $TmpWon[0]."_".$logo_use."_".$img_width."x".$img_height."_".$img_quality."_".$Tthumb_type_file;
			$thumb_img_name = $TmpWon[0]."_".$logo_use."_".$logoPosition."_".$img_width."x".$img_height."_".$img_quality."_".$Tthumb_type_file."_".$thumbPosition;
		}

		$thumb_img = $TmpThumbFilePath."/".$thumb_img_name;

		if ( !isset($ExArray) )
		{
			return;
		}

		if ( preg_match("/gif/i",$TmpWon[1]) )
		{
			if ( $return_type == "gif원본출력" )
			{
				return $wonbon_img;
			}
		}


		if ( is_file($thumb_img) )
		{
			return $thumb_img;
		}
		else
		{
			$TmpDir = explode("/",$thumb_img);
			array_pop($TmpDir);
			dir_make($TmpDir);

			//happy_thumb(array($img_width),array($img_height),1,$wonbon_img,array($thumb_img),$img_quality,$logo_use,$Tthumb_type);

			imageUploadNew($wonbon_img, $thumb_img, $img_width, $img_height, $img_quality, $Tthumb_type, $thumbPosition, $logo_file, $logoPosition );

			return $thumb_img;
		}
	}
	else
	{
		if(!admin_secure("회원메일링") &&
		(preg_match("/news_letter\.php\?action\=submit/",$_SERVER['REQUEST_URI']) ||
		preg_match("/mailing\.php/",$_SERVER['REQUEST_URI']))
		)
		{
			$no_img = $main_url."/".$no_img;
		}

		return $no_img;
	}
}






#첨부파일디렉토리생성
function dir_make($dir_names)
{
	$upload_dir = ".";

	if ( is_array($dir_names) )
	{
		$TmpUploadDir = $upload_dir;
		$oldmask = umask(0);
		foreach($dir_names as $k => $v)
		{
			if ( $v != "." )
			{
				$TmpUploadDir .= "/".$v;

				if ( !is_dir($TmpUploadDir) )
				{
					mkdir($TmpUploadDir,0777);
				}
			}
		}
		umask($oldmask);
	}
}




$imageUploadNew_START	= false;
#예약의 썸네일생성함수를 가져와서 수정함
function imageUploadNew($img_name, $img_name_new, $gi_joon, $height_gi_joon, $picture_quality, $thumbType="", $thumbPosition="", $logo="", $logoPosition="" )
{
	# 사용법
	# imgaeUpload(원본파일네임, 생성할파일네임, 가로크기, 세로크기, 품질, 썸네일추출타입, 로고파일명, 로고포지션)
	# $path는 홈디렉토리의 pwd

	global $imageUploadNew_START;

	if ( $imageUploadNew_START !== true )
	{
		@ini_set('gd.jpeg_ignore_warning', 1);
		$imageUploadNew_START	= true;
	}

	$thumbPosition	= preg_replace("/\D/","",$thumbPosition);
	$logoPosition	= preg_replace("/\D/","",$logoPosition);

	$img_url_re		= $img_name_new;
	$image_top		= 0;
	$image_left		= 0;
	$image_top2		= 0;
	$image_left2	= 0;

	#확장자 체크
	$img_names		= explode(".",$img_name);
	$img_ext		= strtolower($img_names[sizeof($img_names)-1]);

	#단순파일확장자 체크
	if ( $img_ext != 'jpg' && $img_ext != 'jpeg' && $img_ext != 'png' && $img_ext != 'gif' )
	{
		//error("사용할수 없는 확장자 입니다.");
		//return "";
	}

	if ( $gi_joon < 1 )
	{
		return;
	}

	if ( $height_gi_joon < 1 )
	{
		return;
	}

	#기존 이미지를 불러와서 사이즈 체크
	$imagehw		= GetImageSize("$img_name");
	$imagewidth		= $imagehw[0];
	$imageheight	= $imagehw[1];

	#원본이미지타입
	#1:gif,2:jpg,3:png
	$src_type = $imagehw[2];

	if ( $src_type == "1" )
	{
		$img_ext = "gif";
	}
	else if ( $src_type == "2" )
	{
		$img_ext = "jpg";
	}
	else if ( $src_type == "3" )
	{
		$img_ext = "png";
	}
	#원본이미지타입


	$new_width		= $height_gi_joon * $imagewidth / $imageheight ;
	$new_width		= ceil($new_width);
	$new_height		= $gi_joon * $imageheight / $imagewidth ;
	$new_height		= ceil($new_height);

	$width_per	= $imagewidth / $gi_joon;
	$height_per	= $imageheight / $height_gi_joon;

	#썸네일 생성 방법별
	if ( $thumbType == '비율대로짜름' )
	{
		if ( $width_per < $height_per ) {
			$gi_joon		= $new_width;
		}
		else {
			$height_gi_joon	= $new_height;
		}
	}
	else if ( $thumbType == '비율대로축소' )
	{
		$thumbType	= ( $width_per > $height_per )? '가로기준세로짜름' : '세로기준가로짜름';
	}
	else if ( $thumbType == '비율대로확대' )
	{
		$thumbType	= ( $width_per > $height_per )? '세로기준가로짜름' : '가로기준세로짜름';
	}

	switch( $thumbType )
	{
		case "가로기준세로짜름" :
									$new_width	= $gi_joon;
									break;
		case "세로기준가로짜름" :
									$new_height	= $height_gi_joon;
									break;
		case "가로기준" :
									if ( $imagewidth < $gi_joon )
									{
										$new_width		= $imagewidth;
										$new_height		= $imageheight;
										$gi_joon		= $imagewidth;
										$height_gi_joon	= $imageheight;
									}
									else
									{
										$new_width		= $gi_joon;
										$new_height		= $imageheight / $width_per;
										$height_gi_joon	= $new_height;
									}
									break;
		case "세로기준" :
									if ( $imageheight < $height_gi_joon )
									{
										$new_width		= $imagewidth;
										$new_height		= $imageheight;
										$gi_joon		= $imagewidth;
										$height_gi_joon	= $imageheight;
									}
									else
									{
										$new_width		= $imagewidth / $height_per;
										$gi_joon		= $new_width;
										$new_height		= $height_gi_joon;
									}
									break;
		default :
									$new_width	= $gi_joon;
									$new_height	= $height_gi_joon;
									break;
	}
	#echo "$new_width - $new_height <br> ";


	#썸네일 추출 위치 ( 가로기준 , 세로기준에만 해당 )
     if ( $thumbType == '가로기준세로짜름' && $thumbPosition != '' )
     {
          if ( $thumbPosition == '2' )
          {
               if ( $new_height > $height_gi_joon )
               {
                    $image_top  = $imageheight * ( ( ( $new_height - $height_gi_joon ) / 2 ) / $new_height );
               }
               else
               {
                    $image_top2  = ( $height_gi_joon - $new_height ) / 2;
               }
          }
          else if ( $thumbPosition == '3' )
          {
               if ( $new_height > $height_gi_joon )
               {
                    $image_top  = $imageheight * ( ( $new_height - $height_gi_joon ) / $new_height );
               }
               else
               {
                    $image_top2  = $height_gi_joon - $new_height;
               }
          }
     }
     else if ( $thumbType == '세로기준가로짜름' && $thumbPosition != '' )
     {
          if ( $thumbPosition == '2' )
          {
               if ( $new_width > $gi_joon )
               {
                    $image_left  = $imagewidth * ( ( ( $new_width - $gi_joon ) / 2 ) / $new_width );
               }
               else
               {
                    $image_left2 = ( $gi_joon - $new_width ) / 2 ;
               }
          }
          else if ( $thumbPosition == '3' )
          {
               if ( $new_width > $gi_joon )
               {
                    $image_left  = $imagewidth * ( ( $new_width - $gi_joon ) / $new_width );
               }
               else
               {
                    $image_left2 = $gi_joon - $new_width;
               }
          }
     }
	#echo "$image_left - $image_top <br> ";



	#배경잡고
	$thumb			= ImageCreate($gi_joon,$height_gi_joon);
	$thumb			= imagecreatetruecolor($gi_joon,$height_gi_joon);
	$white			= imagecolorallocate($thumb, 255, 255, 255);
	imagefilledrectangle ($thumb,0,0,$gi_joon,$height_gi_joon,$white);


	if ( $img_ext == 'png' ) {
		$src		= ImageCreateFromPng("$img_name");
	}
	else if (  $img_ext == 'gif' ) {
		$src		= ImageCreateFromGif("$img_name");
	}
	else {
		$src		= ImageCreateFromJPEG("$img_name");
	}
	imagecopyresampled($thumb,$src,$image_left2,$image_top2,$image_left,$image_top,$new_width,$new_height,$imagewidth,$imageheight);


	#일단 쪼끄만거부터 맹글자
	if ( $img_ext == 'png' ) {
		/*imagepng()함수 PHP5 패치 by kwak16*/$phpver=phpversion();$phpver=$phpver[0];$picture_quality = ($picture_quality>9&&$phpver>4)?round($picture_quality/11):$picture_quality; ImagePNG($thumb,"$img_name_new",$picture_quality);
	}
	else if (  $img_ext == 'gif' ) {
		Imagegif($thumb,"$img_name_new",$picture_quality);
	}
	else {
		ImageJPEG($thumb,"$img_name_new",$picture_quality);
	}




	#로고작업
	if ( $logo != "" )
	{
		$logo			= ImageCreateFromPng("$logo");
		$logo_width		= imagesx($logo);
		$logo_height	= imagesy($logo);

		$logo_left	= 0;
		$logo_top	= 0;

		#로고 포지션 잡기
		switch( $logoPosition )
		{
			case "1":	break;
			case "2":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						break;
			case "3":
						$logo_left	= $gi_joon - $logo_width;
						break;
			case "4":
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "5":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "6":
						$logo_left	= $gi_joon - $logo_width;
						$logo_top	= ($height_gi_joon/2) - ($logo_height/2);
						break;
			case "7":
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			case "8":
						$logo_left	= ($gi_joon/2) - ($logo_width/2);
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			case "9":
						$logo_left	= $gi_joon - $logo_width;
						$logo_top	= $height_gi_joon - $logo_height;
						break;
			default:
						$logo_top	= $height_gi_joon-$logo_height;
						break;
		}

		imagecopy($thumb,$logo,$logo_left,$logo_top,0,0,$logo_width,$logo_height);
		//ImageJPEG($thumb,"$img_name_new",$picture_quality);
		if ( $img_ext == 'png' ) {
			/*imagepng()함수 PHP5 패치 by kwak16*/$phpver=phpversion();$phpver=$phpver[0];$picture_quality = ($picture_quality>9&&$phpver>4)?round($picture_quality/11):$picture_quality; ImagePNG($thumb,"$img_name_new",$picture_quality);
		}
		else if (  $img_ext == 'gif' ) {
			Imagegif($thumb,"$img_name_new",$picture_quality);
		}
		else {
			ImageJPEG($thumb,"$img_name_new",$picture_quality);
		}
		ImageDestroy($logo);
	}

	ImageDestroy($thumb);


	return $img_url_re;

}



#{{텍스트이미지 가로200,세로150,테스트입니다,폰트사이즈22,글자자름,폰트체,PNG,폰트RGB색상값,BG색상값}}
#{{텍스트이미지 가로200,세로150,테스트입니다,폰트사이즈22,22자자름,NanumGothicExtraBold,PNG,80|80|80,255|255|255}}
function happy_text_image($Width='',$Height='', $text = '', $FontSize = '22' , $str_cut = '', $font = 'NanumGothicExtraBold', $format = "PNG" , $FontColor='80,80,80', $BGColor='255,255,255'){

	$Width		= preg_replace('/\D/', '', $Width);
	$Height		= preg_replace('/\D/', '', $Height);
	$FontSize	= preg_replace('/\D/', '', $FontSize);
	$str_cut	= preg_replace('/\D/', '', $str_cut);
	$FontColor	= str_replace('|',',',$FontColor);
	$BGColor	= str_replace('|',',',$BGColor);
	$text		= urlencode($text);

	print "<img src='happy_imgmaker.php?width=$Width&height=$Height&fsize=$FontSize&news_title=$text&str_cut=$str_cut&outfont=$font&format=$format&fcolor=$FontColor&bgcolor=$BGColor'>";
}



#type (detail|board) : 게시판인경우 board를 사용.
function facebook_scrap($type='detail',$url,$width ='640',$height ='460')
{
	global $BOARD;
	global $server_character,$main_url, $img_url;
	global $SNS_logo_temp; // 구인구직전용

	############# 각 솔루션마다 컬럼및 변수설정 #############
	$title_column	= "guin_title";
	$comment_column	= "guin_main";
	$detail_var		= "DETAIL";

	// 본문내 이미지가 없을경우 이미지 필드사용
	$detail_img_arr	= Array('img1','img2','img3','img4','img5');
	#########################################

	if ( preg_match("/com_info.php/", $_SERVER['REQUEST_URI']) )
	{
		$detail_var		= "COM_INFO";
		$title_column	= "com_name";
		$comment_column	= "com_profile1";
	}
	else if ( preg_match("/guin_detail.php/", $_SERVER['REQUEST_URI']) )
	{
		$detail_var		= "DETAIL";
		$title_column	= "guin_title";
		$comment_column	= "guin_main";
	}
	else if ( preg_match("/document_view.php/", $_SERVER['REQUEST_URI']) )
	{
		$detail_var		= "Data";
		$title_column	= "title";
		$comment_column	= "profile";
	}

	global $$detail_var;



	$DETAIL			= $$detail_var;

	#변수정리
	$width			= preg_replace('/\D/', '', $width);
	$height			= preg_replace('/\D/', '', $height);
	$tb				= $_GET['tb'];

	if ($type == 'detail')
	{
		$facebook_text_t		= strip_tags($DETAIL[$title_column]);
		$facebook_text_comment	= $DETAIL[$comment_column];
	}
	else
	{
		$facebook_text_t		= $BOARD[bbs_title];
		$facebook_text_comment	= $BOARD[bbs_review];
	}

	$facebook_text_u		= $url;
	#변수정리끝.


	#facebook 를 위한 API : 2012.04.30 NeoHero
	$facebook_text_t = str_replace("'","",$facebook_text_t);
	$facebook_text_t = str_replace('"',"",$facebook_text_t);


	if ($server_character == 'euckr')
	{
		$facebook_text_u = iconv("euc-kr" , "UTF-8",$facebook_text_u);
		$facebook_text_t = iconv("euc-kr" , "UTF-8",$facebook_text_t);
		$facebook_text_comment = iconv("euc-kr" , "UTF-8",$facebook_text_comment);
	}


	#preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $facebook_text_comment, $sns_img);

	#preg_match_all("/<img[^>]*src=[\"']?([^>\"']+.jp(g|eg))[\"']?[^>]*>/i", $facebook_text_comment, $sns_img);
	#print_r2($sns_img);
	#본문내 이미지를 다중으로 받아옴 : 현재 facebook에서 지원하지 않음 : 2012-04-30 NeoHero
	#필요시 for 문을 3까지 돌리면 되겠음.
	$f_check_img = '';
	for ($i = 0; $i <2 ; $i ++ ){
		if (!preg_match('/http:\/\//',$sns_img[1][$i],$matches) && $sns_img[1][$i] ){
			$sns_img[1][$i] = "$main_url" . $sns_img[1][$i];
//				print $sns_img[1][$i] . "<br>";
		}

		if ($sns_img[1][$i] ){
			$sns_img[1][$i]        = urlencode( $sns_img[1][$i] );
			$sns_img_info .= "&p[images][$i]=" . $sns_img[1][$i] ;
			$f_check_img = '1';
		}
	}

	#본문내 이미지가 없으면  attach 되는 이미지도 check : 2012-04-30 NeoHero
	#bbs_etc6은 썸네일 추출용으로 사용되는 필드.
	if ($f_check_img == '' && $type == 'board'){
		if ($BOARD[bbs_etc6]){
			$sns_img_info = "&p[images][0]=$main_url/data/$_GET[tb]/$BOARD[bbs_etc6]";
		}
	}

	#print_r2($DETAIL);

	if ( $f_check_img == '' && $type == 'detail' )
	{
		#echo $SNS_logo_temp;
		$image_tmp		= urlencode($SNS_logo_temp);
		$sns_img_info	= "&p[images][0]=$image_tmp";
	}

	$facebook_text_u = urlencode($facebook_text_u);
	$facebook_text_t = urlencode($facebook_text_t);
	#facebook 전송을 위한 글자자름.
	$facebook_text_comment = utf8_cutstr(strip_tags($facebook_text_comment),200,"...");
	$facebook_text_comment = urlencode($facebook_text_comment);

	#구버젼용
	$facebook_url	= "<a href='http://www.facebook.com/share.php?u=$facebook_text_u&t=$facebook_text_t' target=_blank onfocus='blur();'><img src=img/sns_icon/icon_facebook.png align=absmiddle border=0 alt='페이스북으로 보내기' width=23 height=23 xclass=png24></a>";

	#신버젼용
	$facebook		= "<a href='#'><img src='img/sns_icon/icon_facebook.png' align='absmiddle' border='0' alt='페이스북으로 보내기' width='23' height='23' onclick=\"window.open('http://www.facebook.com/sharer.php?s=100&p[url]=$facebook_text_u&p[title]=$facebook_text_t&p[summary]=$facebook_text_comment$sns_img_info','bad','width=$width,height=$height,scrollbars=no')\" style='cursor:pointer;'></a>";

	return $facebook;
}


// 싸이공감 제작 ralear
function cyword_scrap($type='detail')
{
	global $BOARD;
	global $server_character,$main_url, $img_url;
	global $SNS_logo_temp; // 구인구직전용

	############# 각 솔루션마다 컬럼및 변수설정 #############
	// 본문내 이미지가 없을경우 이미지 필드사용
	$detail_img_arr	= Array('img1','img2','img3','img4','img5');
	#########################################

	if ( preg_match("/com_info.php/", $_SERVER['REQUEST_URI']) )
	{
		$detail_var		= "COM_INFO";
		$title_column	= "com_name";
		$comment_column	= "com_profile1";
	}
	else if ( preg_match("/guin_detail.php/", $_SERVER['REQUEST_URI']) )
	{
		$detail_var		= "DETAIL";
		$title_column	= "guin_title";
		$comment_column	= "guin_main";
	}
	else if ( preg_match("/document_view.php/", $_SERVER['REQUEST_URI']) )
	{
		$detail_var		= "Data";
		$title_column	= "title";
		$comment_column	= "profile";
	}

	global $$detail_var;

	$DETAIL			= $$detail_var;

	#print_r2($DETAIL);

	$cyworld_text_u	= $main_url.$_SERVER['REQUEST_URI'];



	$tb				= $_GET['tb'];
	if ($type == 'detail')
	{
		$cyworld_text_t	= strip_tags($DETAIL[$title_column]);
		$cyworld_text_h	= $DETAIL[$comment_column];
	}
	else
	{
		$cyworld_text_t	= $BOARD['bbs_title'];
		$cyworld_text_h	= $BOARD['bbs_review'];
	}

	$cyworld_thumb = "";

	if ( $type == "detail" )
	{
		$image_tmp		= urlencode($SNS_logo_temp);
		$cyworld_thumb	= $image_tmp;
	}
	else if ( $type == "board" )
	{
		if ( $BOARD['bbs_etc6'] != "" )
		{
			$cyworld_thumb	= urlencode("$main_url/data/$_GET[tb]/$BOARD[bbs_etc6]");
		}
	}

	#echo $cyworld_thumb;

	// 첨부 데이터가 없을때는 본문내에서 이미지를 긁어오자
	if ( $cyworld_thumb == "" )
	{
		preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $cyworld_text_h, $sns_img);
		#본문내 이미지를 다중으로 받아옴 : 현재 facebook에서 지원하지 않음 : 2012-04-30 NeoHero
		#필요시 for 문을 3까지 돌리면 되겠음.
		$cyworld_thumb = "";
		for ($i = 0; $i < 2; $i++ )
		{
			if (!preg_match('/http:\/\//',$sns_img[1][$i],$matches) && $sns_img[1][$i] )
			{
				$cyworld_thumb	= $main_url.$sns_img[1][$i];
				break;
			}
		}
	}

	#echo $cyworld_thumb;
	$cyworld_text_h = preg_replace("#<script(.*?)>(.*?)</script>#is", "", $cyworld_text_h);
	$cyworld_text_h	= strip_tags($cyworld_text_h);

	$call_url_add		= '';
	if($server_character == 'euckr')
	{
		/*
		$cyworld_text_u = iconv("euc-kr" , "UTF-8",$cyworld_text_u);
		$cyworld_text_t = iconv("euc-kr" , "UTF-8",$cyworld_text_t);
		$cyworld_text_h = iconv("euc-kr" , "UTF-8",$cyworld_text_h);
		*/
		$call_url_add	= '_euc';
	}

	$cyworld_text_u = urlencode($cyworld_text_u);
	$cyworld_text_t = urlencode(base64_encode($cyworld_text_t));
	$cyworld_text_h = urlencode(base64_encode($cyworld_text_h));

	$C공감 = "<a href='#'><img style='cursor: pointer;' border='0' align='absmiddle' src='img/sns_icon/icon_cyworld.png'onclick='window.open(\"http://csp.cyworld.com/bi/bi_recommend_pop${call_url_add}.php?url=$cyworld_text_u&title=$cyworld_text_t&thumbnail=$cyworld_thumb&summary=$cyworld_text_h&writer=$main_url\", \"recom_icon_pop\", \"width=400,height=364,scrollbars=no,resizable=no\");' alt='싸이월드 공감' title='싸이월드 공감' ></a>";

	return $C공감;
}


///////////////////////////문자열 자르기
function utf8_cutstr($str,$len,$tail='') {
	$pattern = array('/<!--(.*?)-->/s', '/<script[^>]*?>(.*?)<\/script>/is', '/<style[^>]*?>(.*?)<\/style>/is', '/<(.*?)>/s');
	$str = preg_replace($pattern, '', $str);

    $c = substr(str_pad(decbin(ord($str{$len})),8,'0',STR_PAD_LEFT),0,2);
    if ($c == '10')
        for (;$c != '11' && $c{0} == 1;$c = substr(str_pad(decbin(ord($str{--$len})),8,'0',STR_PAD_LEFT),0,2));
    return substr($str,0,$len) . (strlen($str)-strlen($tail) >= $len ? $tail : '');
}


//게시판 목록 추출
// {{게시판키워드추출 총20개,가로1개,20자자름,그룹2,rows_board_list.html,누락0개}}
// {{게시판키워드추출 총20개,가로3개,20자자름,전체,rows_board_list.html,누락0개}}
function board_keyword_extraction($ex_limit,$ex_width,$ex_cut,$ex_keyword,$ex_template,$ex_garbage = '0',$ex_exp = '') {
	global $board_list,$TPL,$BLIST,$skin_folder,$DB_Prefix;

	$ex_limit = preg_replace('/\D/', '', $ex_limit);
	$ex_width = preg_replace('/\D/', '', $ex_width);
	$ex_cut = preg_replace('/\D/', '', $ex_cut);
	$ex_garbage = preg_replace('/\D/', '', $ex_garbage);
	$ex_category  = preg_replace('/\n/', '', $ex_category);
	$ex_template  = preg_replace('/\n/', '', $ex_template);

	if (eregi('전체',$ex_keyword)){
		$keyword_query = '';
	}
	else {
		$keyword_query = "where keyword like '%$ex_keyword%'";
	}



	$sql = "select * from $board_list $keyword_query  order by sorting_number asc , board_name asc limit $ex_garbage,$ex_limit";
	//echo $sql;
	$result = query($sql);



	$i = "1";
	$main_new_out = "<table cellspacing='0' cellpadding='0' border='0' width='100%'>";
	$TPL->define("게시판목록추출_$ex_template", "$skin_folder/$ex_template");
	$TPL->assign("게시판목록추출_$ex_template");

	//echo "누구냐?";
	while ($BLIST = happy_mysql_fetch_array($result)){

		$BLIST[board_name] = kstrcut($BLIST[board_name], $ex_cut, "...");

		$sql22 = "select count(*) from $BLIST[tbname]";
		$result22 = query($sql22);
		list($BLIST[now_count]) = happy_mysql_fetch_array($result22);

		$tbname_length = strlen($DB_Prefix);
		$BLIST[tbname] = substr($BLIST[tbname],$tbname_length);

		//echo $BLIST['tbname']." == ".$_GET['tb']."<br>";
		//echo var_dump($BLIST['tbname'] == $_GET['tb']);
		if ( $_GET['tb']!= "" && $_GET['tb'] == $BLIST['tbname'] )
		{
			$BLIST['class_on']		= "on";
		}
		else
		{
			$BLIST['class_on']		= "";
		}

		$main_new = &$TPL->fetch("게시판목록추출_$ex_template");

		#TD를 정리하자
		if ($i % $ex_width == "1") {
		$main_new = "<tr><td >" . $main_new . "</td>";
		}
		elseif
		($i % $ex_width == "0") {
		$main_new = "<td >" . $main_new . "</td></tr>";
		}
		else {
		$main_new = "<td >" . $main_new . "</td>";
		}
		$main_new_out .= $main_new;
		$i ++;

	}
	$main_new_out .= "</table>";
	print $main_new_out;


}


#두 날짜의 차이
function happy_date_diff($date1,$date2) {

	$S_date = explode("-",$date1);
	$C_date = explode("-",$date2);

	$start_date = happy_mktime(0,0,0,$S_date[1],$S_date[2],$S_date[0]);
	$cancel_date = happy_mktime(0,0,0,$C_date[1],$C_date[2],$C_date[0]);

	$t_day = ceil(($cancel_date - $start_date) / 86400);
	return $t_day;

}


//네이버검색 api
function naver_search_api()
{
	# {{네이버검색 세로2개,가로2개,naver_search_part.html,naver_search_part_rows.html,검색타겟,api호출시추가링크}}

	$arg_title	= array('세로수','가로수','껍데기템플릿','알맹이템플릿','검색타겟','페이징','api호출시추가링크');
	$arg_names	= array('heightSize','widthSize','partFile','rowsFile','target','paging','addurl');
	$arg_types	= array(
						'heightSize'		=> 'int',
						'widthSize'			=> 'int',
						'partFile'			=> 'char',
						'rowsFile'			=> 'char',
						'target'			=> 'char',
						'addurl'			=> 'char'
	);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
		#echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}


	global $skin_folder, $TPL, $naver_search_key, $server_character, $naver_search_type;
	global $Default, $Data, $내용, $검색분야, $Count, $페이징, $더보기링크;
	global $naver_search_key,$naver_search_secret_key;
	global $검색된장르수;


	$limit				= $heightSize * $widthSize;

	if ( $target == '자동' && $_GET['target'] != '' )
	{
		$target				= $_GET['target'];
	}

	$검색분야			= $target;

	$realTarget			= $naver_search_type[$target]['target'];
	if ( $realTarget == '' )
	{
		return "지정되지 않은 속성 입니다. ($target)";
	}





	$더보기링크			= 'naver_search.php?file='.str_replace('.html', '_'.$realTarget.'_more.html', $partFile).'&target='. urlencode($target).'&all_keyword='. urlencode($_GET['all_keyword']);




	$search_word		= $_GET['all_keyword'];
	if ( $server_character == 'euckr' )
	{
		$query				= urlencode(iconv('EUC-KR','UTF-8', $search_word));
	}
	else
	{
		$query				= urlencode($search_word);
	}


	if ( $paging == '페이징사용' )
	{
		$start				= preg_replace('/\D/', '', $_GET["start"]);
		if ( $start == '' )
		{
			$start				= 0;
		}
		$start++;
	}
	else
	{
		$start				= 1;
	}


	$SearchResult		= "";
	/*
	$server				= "openapi.naver.com";
	$file				= "/search?key=$naver_search_key&target=$realTarget&query=$query&display=$limit&start=$start$addurl";
	//echo $file;
	$fp					= pfsockopen($server, 80, $errno, $errstr);
	if (!$fp)
	{
		return "$errstr ($errno)<br/>\n";
	}
	else
	{
		fputs($fp, "GET $file  HTTP/1.1\r\n");
		fputs($fp, "Host: $server\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fwrite($fp, $out);

		while (!feof($fp))
		{
			$SearchResult	.= fgets($fp);
		}
		fclose($fp);
	}
	*/

	$curl_url = "https://openapi.naver.com/v1/search/{$realTarget}.xml?query=$query&display=$limit&start=$start$addurl";
	$curl_header= Array(
		  "Host: openapi.naver.com",
		  "User-Agent: curl/7.43.0",
		  "Accept: */*",
		  "Content-Type: application/xml",
		  "X-Naver-Client-Id: $naver_search_key",
		  "X-Naver-Client-Secret: $naver_search_secret_key"
	 );


	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $curl_url);
	 curl_setopt($ch, CURLOPT_HEADER, 0);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	 curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
	 $SearchResult = curl_exec($ch);
	 curl_close($ch);







	$ITEMS				= explode('<item>', $SearchResult);
	//echo $SearchResult;exit;

	$title				= naver_search_api_getpoint($ITEMS[0], "<title>", "</title>");
	$link				= naver_search_api_getpoint($ITEMS[0], "<link>", "</link>");
	$total				= naver_search_api_getpoint($ITEMS[0], "<total>", "</total>");
	$description		= naver_search_api_getpoint($ITEMS[0], "<description>", "</description>");
	$lastBuildDate		= naver_search_api_getpoint($ITEMS[0], "<lastBuildDate>", "</lastBuildDate>");


	$Default			= Array(
							'title'				=> unhtmlspecialchars($title[0]),
							'link'				=> $link[0],
							'total'				=> $total[0],
							'total_comma'		=> number_format($total[0]),
							'description'		=> unhtmlspecialchars($description[0]),
							'lastBuildDate'		=> $lastBuildDate[0]
	);

	#echo "$title[0]<br>$link[0]<br>$total[0]<br><hr><br>%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%<br>";

	if ( $rowsFile == '자동' )
	{
		$rowsFile	= 'naver_search_'.$realTarget.'_rows.html';
	}

	//데모 네이버 지도 제거 hong
	global $HAPPY_CONFIG;

	if ( $target == '지역' && $HAPPY_CONFIG['wide_map_type'] == 'daum' )
	{
		$partFile	= str_replace(".html","_daum.html",$partFile);
		$rowsFile	= str_replace(".html","_daum.html",$rowsFile);
	}


	$random				= rand()%1000;
	$TPL->define("네이버검색_${realTarget}_$random", $skin_folder.'/'.$rowsFile);

	$Content			= "<table align='center' width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
	$Count				= 0;

	for ( $i=1, $max=sizeof($ITEMS) ; $i<$max ; $i++ )
	{
		$Data				= array();
		$Data['Count']		= $Count;
		$Count++;
		$검색된장르수++;

		for ( $z=0, $maxZ=sizeof($naver_search_type[$target]['response']) ; $z<$maxZ ; $z++ )
		{

			$nowKey				= $naver_search_type[$target]['response'][$z];
			$nowKey_c			= $nowKey.'_comma';

			$Tmp				= naver_search_api_getpoint($ITEMS[$i], "<".$nowKey.">", "</".$nowKey.">");

			if ( $nowKey == "pubDate" )
			{
				$Tmp[0] = change_RFC_date($Tmp[0]);
			}

			$Data[$nowKey]		= unhtmlspecialchars($Tmp[0]);

			if ( $server_character == 'euckr' )
			{
				$Data[$nowKey]	= iconv("UTF-8", "EUC-KR", $Data[$nowKey]);
			}

			if ( preg_replace('/\D/', '', $Tmp[0]) == $Tmp[0] )
			{
				$Data[$nowKey_c]	= @number_format($Tmp[0]);
			}
		}

		if ( $target == '지역' )
		{
			$Data['title_link']		= urlencode(strip_tags($Data['title']));
			$Data['address_link']	= urlencode(strip_tags($Data['address']));

			//데모 네이버 지도 제거 hong
			if( $HAPPY_CONFIG['wide_map_type'] == 'daum' )
			{
				$data			= getcontent_wgs_daum($Data['address']);
				$xpoint			= getpoint($data,"<x>","</x>");
				$ypoint			= getpoint($data,"<y>","</y>");
				$wgsArr			= get_wgs_point($xpoint, $ypoint);

				$Data['x_point'] = $wgsArr['x_point'];
				$Data['y_point'] = $wgsArr['y_point'];
			}
		}



		$product			= $TPL->fetch("네이버검색_${realTarget}_$random");
		$Content			.= "<td valign='top'>".$product."</td>";
		if ( $Count % $widthSize == 0 )
		{
			$Content			.= "</tr><tr>";
		}

	}


	if ( $Count % $widthSize != 0 )
	{
		for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
		{
			$Content			.= "<td width='$tdWidth'>&nbsp;</td>\n";
		}
	}

	$Content			.= "</tr>\n";
	$Content			.= "</table>";




	$내용				= $Content;



	if ( $paging == '페이징사용' )
	{
		############ 페이징처리 ############
		$start			= preg_replace('/\D/', '', $_GET["start"]);
		$scale			= $limit;

		$Total			= $Default['total'];

		$pageScale		= 5;

		$searchMethod	= "&all_keyword=".urlencode($_GET['all_keyword']);
		$searchMethod	.= "&file=".urlencode($_GET['file']);
		$searchMethod	.= "&target=".urlencode($_GET['target']);

		$paging			= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
		$페이징			= $paging;
		########### 페이징처리 끝 ############
	}





	if ( $Count > 0 )
	{
		$TPL->define("네이버검색_default_${realTarget}_$random", $skin_folder.'/'.$partFile);
		$Content			= $TPL->fetch("네이버검색_default_${realTarget}_$random");
	}
	else
	{
		$Content			= '';
	}

	return $Content;


	#print_r2($ITEMS);


#	return $SearchResult;

}

function unhtmlspecialchars( $string )
{
	$string		= str_replace ( '&amp;', '&', $string );
	$string		= str_replace ( '&#039;', '\'', $string );
	$string		= str_replace ( '&quot;', '\"', $string );
	$string		= str_replace ( '&lt;', '<', $string );
	$string		= str_replace ( '&gt;', '>', $string );
	$string		= stripslashes($string);

	return $string;
}

function naver_search_api_getpoint($data,$start_str,$end_str)
{
	$i=0;
	$z=0;
	while(is_int($pos = strpos($data, $start_str, $i)))
	{
		$pos += strlen($start_str);
		$endpos = strpos($data,$end_str, $pos);
		$value = substr($data, $pos, $endpos-$pos);
		//echo $value."<br>";
		$value_array[] = $value;
		$i = $endpos;

		if ( $z++ > 300 )
		{
			break;
		}
	}
	return $value_array;
}

// RFC 2822 형식의 날짜를 Y-m-d H:i:s 방식으로
function change_RFC_date($date)
{
	$Time_Tmp	= explode(" ", $date);
	$Time_Day	= $Time_Tmp[1];
	$Time_Month	= $Time_Tmp[2];
	$Time_Year	= $Time_Tmp[3];
	$Time_Hour	= $Time_Tmp[4];

	$Month_Array	= Array
	(
		"Jan"	=> '01',
		"Feb"	=> '02',
		"Mar"	=> '03',
		"Apr"	=> '04',
		"May"	=> '05',
		"Jun"	=> '06',
		"Jul"	=> '07',
		"Aug"	=> '08',
		"Sep"	=> '09',
		"Oct"	=> '10',
		"Nov"	=> '11',
		"Dec"	=> '12'
	);

	$date = $Time_Year."-".$Month_Array[$Time_Month]."-".$Time_Day." ".$Time_Hour;
	return $date;
}

function getcontent_wgs($get_addr)
{
	global $naver_key,$naver_secret_key;
	$get_addr = urlencode($get_addr);	#UTF환경시 이줄은 삭제
	#$get_addr	= $map_cquery =iconv("utf-8","euc-kr",$get_addr); #UTF환경시 위에소스를 지우고 이소스를 사용
	#UTF 환경에서 temp/detail_common.html 파일에 view_img 함수의 UTF관련 주석을 풀어주어야 함 (상세보기지도)
	/*
	$cont = "";
	$server = "maps.naver.com";
	$file = "/api/geocode.php?coord=latlng&key=".$naver_key."&query=".$get_addr;

	$fp = pfsockopen($server, 80, $errno, $errstr);
	if (!$fp)
	{
		echo "$errstr ($errno)<br/>\n";
		exit;
	}
	else
	{
		fputs($fp, "GET $file  HTTP/1.1\r\n");
		fputs($fp, "Host: $server\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fwrite($fp, $out);

		while (!feof($fp))
		{
			$cont .= fgets($fp, 128);
		}
		fclose($fp);
		return $cont;
	}
	*/

	$curl_url		= "https://naveropenapi.apigw.ntruss.com/map-geocode/v2/geocode?query=".$get_addr;
	$curl_header	= Array(
							"Host: naveropenapi.apigw.ntruss.com",
							"User-Agent: curl/7.43.0",
							"Accept: application/xml",
							"X-NCP-APIGW-API-KEY-ID: $naver_key",
							"X-NCP-APIGW-API-KEY: $naver_secret_key"
	);


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $curl_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
	$cont = curl_exec($ch);
	curl_close($ch);

	return $cont;

}


function get_wgs_point($y_point, $x_point)
{
	if ( is_array($x_point) )
	{
		$x_point	= $x_point[0];
	}

	if ( is_array($y_point) )
	{
		$y_point	= $y_point[0];
	}

	$x_point				= str_replace(' ','',$x_point);
	$y_point				= str_replace(' ','',$y_point);

	list($x_do, $x_min)		= explode('.',$x_point);

	$x_min					= $x_point - $x_do;
	$x_min					= $x_min * 60;
	$x_min_check			= $x_min;
	list($x_min, $x_sec)	= explode('.',$x_min);

	$x_sec					= $x_min_check - $x_min;
	$x_sec					= $x_sec * 60;


	#echo "<hr>$x_do , $x_min , $x_sec";



	list($y_do, $y_min)		= explode('.',$y_point);

	$y_min					= $y_point - $y_do;
	$y_min					= $y_min * 60;
	$y_min_check			= $y_min;
	list($y_min, $y_sec)	= explode('.',$y_min);

	$y_sec					= $y_min_check - $y_min;
	$y_sec					= $y_sec * 60;


	#echo "<hr>$y_do , $y_min , $y_sec";


	$x_point2	= $x_do * 3600 + $x_min * 60 + $x_sec;
	$y_point2	= $y_do * 3600 + $y_min * 60 + $y_sec;

	$wgsArr['x_do']		= $x_do;
	$wgsArr['x_min']	= $x_min;
	$wgsArr['x_sec']	= $x_sec;
	$wgsArr['y_do']		= $y_do;
	$wgsArr['y_min']	= $y_min;
	$wgsArr['y_sec']	= $y_sec;
	$wgsArr['x_point']	= $x_point;
	$wgsArr['y_point']	= $y_point;
	$wgsArr['x_point2']	= $x_point2;
	$wgsArr['y_point2']	= $y_point2;

	return $wgsArr;

}


//성인인증되었으면 1, 아니면 0
function happy_adult_check()
{
	global $adminMenuNames;
	global $happy_member_option_type;

	$adult_check = 0;

	//1회성 성인인증
	//echo $_COOKIE['job_adultcheck'];
	if ( $_COOKIE['adult_check'] == "OK" && strlen($_COOKIE['job_adultcheck']) == "6" )
	{
		$adult_check = "1";
	}
	//최고관리자
	else if ( admin_secure("최고관리자") )
	{
		$adult_check = "1";
	}
	//부관리자
	else if ( $_COOKIE['ad_id'] != "" )
	{
		foreach($adminMenuNames as $k => $v)
		{
			if ( $v != "" )
			{
				//var_dump(admin_secure($v));
				if ( admin_secure($v) )
				{
					$adult_check = "1";
					break;
				}
			}
		}
	}
	//회원로그인
	else if ( happy_member_login_check() != "" )
	{
		$is_adult = happy_member_option_get($happy_member_option_type,happy_member_login_check(),'is_adult');
		if ( $is_adult == "1" )
		{
			$adult_check = "1";
		}
	}

	//var_dump($adult_check);
	return $adult_check;
}



/********************************************************************************************************
	2013-02-07 도로명 주소찾기 기능이 추가 되었습니다.		hun
	startRequest_road, startRequest_juso2road 스크립트 함수는 js / happy_member.js 에 선언되어 있습니다.
	START
*********************************************************************************************************/

# 도로명주소 woo
function happy_make_road_si_selectbox($or_name,$next,$nnext,$sel1,$sel2,$sel3,$size1,$size2,$size3,$form_name,$type_inq = '')
{
	global $SI_TITLE, $GU_TITLE, $SI_NUMBER;
	global $area1_title_text,$area2_title_text,$area3_title_text,$area4_title_text;
	global $upso2_si,$upso2_si_gu,$upso2_si_gu_dong,$SI,$SI_ARRAY,$c_j_j_selected,$gu_tb,$car_company;
	global $select_category_road,$select_company_road,$select_type_road;

	global $zipcode_site, $zipcode_road_file, $server_character, $sock_connect_type;

	$next_form_con	= $next . $form_name;
	$nnext_form_con	= $nnext . $form_name;

	# UTF8
	$url_encoding		= '';
	if(preg_match("/utf/i",$server_character))
	{
		$url_encoding	= '&encoding=utf8';
	}
	# UTF8

	global $siSelect, $AREA_SI;

	$AREA_SI = $siSelect;

	$is_sejong		= true;
	if(preg_match("/세종/",$AREA_SI[$sel1]))
	{
		$is_sejong		= false;
		$sel2			= $sel3;
	}

	foreach($AREA_SI as $key => $value)
	{
		$tmp_select	= '';
		if ($sel1 == $key)
		{
			$tmp_select = "selected";
		}
		$si_option	.="<option value='$key' $tmp_select>$value</option>	";
	}

	if ($size1)
	{
		$size1_width	= "width:${size1}px;";
	}
	if ($size2)
	{
		$size2_width	= "width:${size2}px;";
	}
	if ($size3)
	{
		$size3_width	= "width:${size3}px;";
	}

	if( $type_inq != '' )
	{
		global $happy_inquiry_form;
		$road_arr				= array("road_si",'road_gu','road_addr');
		$road_required			= array();
		$road_required['si']	= "";
		$road_required['gu']	= "";
		$road_required['addr']	= "";

		$Sql	= "SELECT field_title,field_name,field_sureInput FROM $happy_inquiry_form WHERE gubun = '".base64_decode(str_replace("_p_","+",$type_inq))."'  AND field_name IN ('".implode("','",$road_arr)."') ORDER BY field_sort ASC";
		$rec					= query($Sql);
		while($inq = mysql_fetch_assoc($rec))
		{
			if( $inq['field_sureInput'] == 'y' )
			{
				if( $inq['field_name'] == $road_arr[0] )
				{
					$road_required['si']	= " required hname=\"{$inq['field_title']}\"";
				}
				else if( $inq['field_name'] == $road_arr[1] )
				{
					$road_required['gu']	= " required hname=\"{$inq['field_title']}\"";
				}
				else if( $inq['field_name'] == $road_arr[2] )
				{
					$road_required['addr']	= " required hname=\"{$inq['field_title']}\"";
				}
			}
		}
	}

	# HTML
	$select_category_road[$form_name] = <<<END
<SELECT name="$or_name" $must_input $road_required[si] onChange=happy_startRequest_road(this,'','$next','$nnext','$size2','1','$form_name','$size3','$type_inq') style="$size1_width">
	<OPTION value=''>$area1_title_text</OPTION>
	$si_option
</SELECT>
END;

	# HTML

##############################################

	if($is_sejong)
	{
		if($sel1)
		{
			$sql		= "SELECT * FROM $upso2_si_gu WHERE si='$sel1' ORDER BY gu ASC";
			$result		= query($sql);
			$GU_TITLE	= array();

			$tmp_div	= "<SELECT name='$next' id='$next' onChange=happy_startRequest_road(this,'$sel1','$next','$nnext','$size2','2','$form_name','$size3') style='$size2_width '><OPTION value=''>$area2_title_text</OPTION>";

			while($TMP = happy_mysql_fetch_array($result))
			{
				$GU_TITLE{$TMP[number]}	= $TMP[gu];

				$tmp_select	= '';
				if ($TMP[number] == $sel2)
				{
					$tmp_select		= 'selected';
				}
				$tmp_div	.="<OPTION value='$TMP[number]' $tmp_select>$TMP[gu]</OPTION>";
			}
			$tmp_div		.="</SELECT>	";
		}
		else
		{
			$tmp_div	= "<SELECT name='$next' id='$next' onChange=happy_startRequest_road(this,'','$next','$nnext','$size2','2','$form_name','$size3') style='$size2_width '><OPTION value=''>$area2_title_text</OPTION></SELECT> ";
		}
	}
	else
	{
		$tmp_div	= "<SELECT name='$next' id='$next' onChange=happy_startRequest_road(this,'','$next','$nnext','$size2','2','$form_name','$size3') style='$size2_width; display:none; '><OPTION value=''>$area2_title_text</OPTION></SELECT> ";
		$span_style = " style='display:none;'";
	}


	$select_company_road[$form_name] = <<<END
<SPAN id='$next_form_con'></SPAN>
<SCRIPT>
	var tmp_div = "$tmp_div";
	document.getElementById('$next_form_con').innerHTML = tmp_div;
</SCRIPT>
END;
	# HTML

##############################################

	if($sel2)
	{
		$sql				= "SELECT si FROM $upso2_si WHERE number = '$sel1'";
		list($si)			= happy_mysql_fetch_array(query($sql));

		$sql				= "SELECT gu FROM $upso2_si_gu WHERE number = '$sel2'";
		list($gu)			= happy_mysql_fetch_array(query($sql));

		$si					= iconv("utf-8","euc-kr",$si);
		$gu					= iconv("utf-8","euc-kr",$gu);

		$get_url			= $zipcode_site . '/' . $zipcode_road_file . '?si=' . $si . '&gu=' . $gu;
		$url				= 'http://' . $get_url . '&site=' . $_SERVER['SERVER_NAME'] . $url_encoding;

		switch($sock_connect_type)
		{
			case 'curl' :
				$contents			= curl_get_file_contents($url);
			break;
			case 'fsock' :
				$contents			= file_get_contents_fsockopen($url);
			break;
			case 'snoopy' :
				$contents			= snoopy_class($url);
			break;
			default :
				$contents			= file_get_contents_fsockopen($url);
			break;
		}

		//print_r2($contents);

		$contents_explode	= explode('||', $contents);

		$tmp_div = "<select name='$nnext' id='$nnext' style='$size3_width' onChange=happy_startRequest_road(this,'$sel2','$next','$nnext','$size2','5','$form_name','$size3') ><option value=''>$area4_title_text</option>";
		foreach($contents_explode AS $value)
		{
			$value_explode	= explode('@@', $value);

			//echo $value_explode[0]."<br>";

			$tmp_select		= '';
			if ($value_explode[0] == $sel3)
			{
				$tmp_select = 'selected';
			}

			$tmp_div		.= "<option value='$value_explode[0]' $tmp_select>$value_explode[0]</option>";
		}
		$tmp_div .="</select>";
	}
	else
	{
		$tmp_div = "<SELECT name='$nnext' id='$nnext'  style='$size3_width'><OPTION value=''>$area4_title_text</OPTION></SELECT> ";
	}

	# HTML
	$select_type_road[$form_name] = <<<END
<SPAN id='$nnext_form_con'></SPAN>
<SCRIPT>
	var tmp_div2 = "$tmp_div";
	//eval('$nnext_form_con.innerHTML=tmp_div2');
	document.getElementById('$nnext_form_con').innerHTML = tmp_div2;
</SCRIPT>
END;
	# HTML
}


# iconv 귀찮아 woo
function iconv2($str, $char = 'e')
{
	if($char == 'e' || $char == '')
		return iconv('utf8', 'euckr', $str);
	else
		return iconv('euckr', 'utf8', $str);
}


# 소켓 통신 함수
function curl_get_file_contents($URL)
{
	$c			= curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_URL, $URL);
	$contents	= curl_exec($c);
	curl_close($c);
	if ($contents)
		return $contents;
	else
		return FALSE;
}

# 소켓 통신 함수
function file_get_contents_fsockopen($url)
{
	$URL_parsed		= @parse_url($url);
	$host			= $URL_parsed["host"];
	$port			= $URL_parsed["port"];

	if( $port == 0 ) { $port = 80; }

	$path			= $URL_parsed["path"];

	if($URL_parsed["query"] != "")
	{
		$path		.= "?".$URL_parsed["query"];
	}

	$fp				= fsockopen($host, $port, $errno, $errstr, 30);

	if( !$fp )
	{
		echo "$errstr ($errno)<br> ";
		exit;
	}
	else
	{
		$data		= '';
		fputs($fp, "GET ${url} HTTP/1.0\r\n\r\n");
		//fputs($fp, "Host: ${host}\r\n");
		//fputs($fp, "Connection: close\r\n\r\n");
		while (!feof($fp))
		{
			$data	.= fgets($fp, 128);
		}
		fclose($fp);

		$data		= explode("\r\n\r\n", $data, 2);

		return $data[1];
	}
}

# 도로명 주소 XML 가져오기 woo
function getXMLValue($data,$start_str,$end_str, $onlyone = '')
{
	$i	= 0;
	while(is_int($pos = strpos($data, $start_str, $i)))
	{
		$pos			+= strlen($start_str);
		$endpos			= strpos($data,$end_str, $pos);
		$value			= substr($data, $pos, $endpos-$pos);
		$value_array[]	= $value;
		$i = $endpos;
	}
	if($onlyone == '')
		return $value_array;
	else
		return $value_array[0];
}


/********************************************************************************************************
	2013-02-07 도로명 주소찾기 기능이 추가 되었습니다.		hun
	startRequest_road, startRequest_juso2road 스크립트 함수는 js / happy_member.js 에 선언되어 있습니다.
	END
*********************************************************************************************************/



#로그삭제 함수(관리자 로그인시 실행)
function happy_auto_log_del()
{
	global $HAPPY_LOG_DELETE_DAY_ARRAY,$HAPPY_LOG_DATE_FIELD_ARRAY;

	foreach($HAPPY_LOG_DELETE_DAY_ARRAY AS $LD => $LD_VAL)
	{
		$Sql_log	= "DELETE FROM {$LD} WHERE {$HAPPY_LOG_DATE_FIELD_ARRAY[$LD]} < DATE_SUB(CURDATE(),INTERVAL $LD_VAL DAY)";
		query($Sql_log);
	}
	unset($LD,$LD_VAL);
}

function happy_config_loading()
{
	global $happy_config;
	global $HAPPY_CONFIG;

	$Sql	= "SELECT * FROM $happy_config ORDER BY number ASC";
	$Record	= query($Sql);

	while ( $Value = happy_mysql_fetch_array($Record) )
	{
		if ( $Value['conf_out_type'] == 'array' )
		{
			$Value['conf_value']	= explode(",",$Value['conf_value']);
		}
		else if ( $Value['conf_out_type'] == 'nl2br' )
		{
			$Value['conf_value']	= nl2br($Value['conf_value']);
		}
		$GLOBALS[$Value['conf_name']]	= $Value['conf_value'];
		$HAPPY_CONFIG[$Value['conf_name']]	= $Value['conf_value'];
	}
}



//위치기반
function wgs_point_get($xpoint)
{
	# upso_list_main 에서 호출되는 함수 위도,경도 1초당 거리(미터기준)

	global $wgs_setting;

	if ( $wgs_setting['type'] != 'auto' && $wgs_setting['xpoint'] != '' && $wgs_setting['ypoint'] != '' )
	{
		# type 값이 auto가 아닐경우 강제 값 지정

		$Arr['xpoint']		= $wgs_setting['xpoint'];
		$Arr['ypoint']		= $wgs_setting['ypoint'];
	}
	else
	{
		# type 값이 auto 일 경우 위도를 기준으로 위,경도 1초에 해당하는 값을 계산
		# 0.1도 단위 까지 계산을 하게 됨

		$wgs_standard_key	= Array(0,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90);
		$wgs_standard		= Array(
									0	=> Array(110.569, 111.322),
									5	=> Array(110.578, 110.902),
									10	=> Array(110.603, 109.643),
									15	=> Array(110.644, 117.553),
									20	=> Array(110.701, 114.650),
									25	=> Array(110.770, 100.953),
									30	=> Array(110.850,  96.490),
									35	=> Array(110.941,  91.290),
									40	=> Array(111.034,  85.397),
									45	=> Array(111.132,  78.850),
									50	=> Array(111.230,  71.700),
									55	=> Array(111.327,  63.997),
									60	=> Array(111.415,  55.803),
									65	=> Array(111.497,  47.178),
									70	=> Array(111.567,  38.188),
									75	=> Array(111.625,  28.904),
									80	=> Array(111.666,  19.394),
									85	=> Array(111.692,   9.735),
									90	=> Array(111.700,   0.000)
		);

		for ( $i=0, $j=1, $max=sizeof($wgs_standard)-1 ; $i<$max ; $i++, $j++ )
		{
			if ( $xpoint >= $wgs_standard_key[$i] && $xpoint < $wgs_standard_key[$j] )
			{
				$start				= $wgs_standard[$wgs_standard_key[$i]];
				$end				= $wgs_standard[$wgs_standard_key[$j]];
				$point_block		= round( $xpoint - $wgs_standard_key[$i] , 1) * 10;				# 기준 위도값과 현재 넘어온 위도값의 차이 X 100
				$point_block2		= ( $wgs_standard_key[$j] - $wgs_standard_key[$i] ) * 10;		# 기준 위도값과 다음 기준 위도값의 차이 X 100
				break;
			}
		}


		$x_start			= number_format( $start[0] * 1000 / 3600 , 3 );
		$x_end				= number_format( $end[0] * 1000 / 3600 , 3 );

		$y_start			= number_format( $start[1] * 1000 / 3600 , 3 );
		$y_end				= number_format( $end[1] * 1000 / 3600 , 3 );


		$x_block			= number_format( $x_start - $x_end , 4) / $point_block2;
		$y_block			= number_format( $y_start - $y_end , 4) / $point_block2;

		$x_plus				= $x_block * $point_block;
		$y_block			= $y_block * $point_block;

		$x_point			= $x_start + $x_plus;
		$y_point			= $y_start + $y_plus;

		#echo "<b>기준 위도 : $xpoint </b>$point_block : $point_block2 <br> ( $x_start - $x_end ) / $point_block2 = $x_block <br> ( $y_start - $y_end ) / $point_block2 = $y_block <br> 결과 : $x_point , $y_point<hr>";


		$Arr['xpoint']		= $x_point;
		$Arr['ypoint']		= $y_point;
	}
	return $Arr;
}


function getcontent_wgs_google($get_addr)
{
	global $google_key, $google_key_free;

	$curl_url	= "https://maps.google.com/maps/api/geocode/xml?address=" . urlencode($get_addr) . "&sensor=false";
	if ($google_key_free == "n" && $google_key != "")
	{
		$curl_url	.= "&key=".$google_key;
	}
	$curl_header= Array(
						"Host: maps.google.com",
						"Accept: */*"
	);

	if ($count == "")
	{
		$count2	= 1;
	}
	else
	{
		$count2	= $count+1;
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $curl_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
	$cont = curl_exec($ch);
	curl_close($ch);

	return $cont;


	/*
	## google map v3 바뀐 Geocoding 주소 woo
	$port			= 80;
	$host			= "maps.google.com";
	$get_url		= "/maps/api/geocode/xml?address=" . urlencode($get_addr) . "&sensor=false";
	//$get_url		= "/maps/api/geocode/json?address=" . urlencode($get_addr) . "&sensor=false";
	$geo_xml		= "";

	$locationXY	= Array();

	$fp = fsockopen($host, $port, $errno, $errstr);
	if (!$fp)
	{
		echo "$errstr ($errno)<br/>\n";
		exit;
	}
	else
	{
		fputs($fp, "GET ${get_url} HTTP/1.1\r\n");
		fputs($fp, "Host: ${host}\r\n");
		fputs($fp, "Content-Encoding: UTF8\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		while (!feof($fp))
		{
			$geo_xml .= fgets($fp, 128);
		}
		fclose($fp);

		$geo_xml = explode("\r\n\r\n", $geo_xml, 2);

		return $geo_xml[1];
	}
	*/

	## google map v2 버전 소스 woo
	/*
	global $google_key;
	$get_addr = urlencode($get_addr);	#UTF환경시 이줄은 삭제
	#$get_addr	= $map_cquery =iconv("utf-8","euc-kr",$get_addr); #UTF환경시 위에소스를 지우고 이소스를 사용
	#UTF 환경에서 temp/detail_common.html 파일에 view_img 함수의 UTF관련 주석을 풀어주어야 함 (상세보기지도)
	$cont		= "";
	$server		= "maps.google.com";
	#$get_addr	= "1600+Amphitheatre+Parkway,+Mountain+View,+CA";
	$file		= "/api/geocode.php?coord=latlng&key=".$naver_key."&query=".$get_addr;
	$file		= "/maps/api/geocode/xml?address=$get_addr&sensor=false";

	$fp = pfsockopen($server, 80, $errno, $errstr);
	if (!$fp)
	{
		echo "$errstr ($errno)<br/>\n";
		exit;
	}
	else
	{
		fputs($fp, "GET $file  HTTP/1.1\r\n");
		fputs($fp, "Host: $server\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fwrite($fp, $out);

		while (!feof($fp))
		{
			$cont .= fgets($fp, 128);
		}
		fclose($fp);
		return $cont;
	}
	*/
}

//{{배경이미지리스트 총10개,가로3개,rows_bgimage.html}}
function bg_image_list()
{
	global $logo_bgimage_list;
	global $TPL;
	global $skin_folder;
	global $BG_IMAGE;
	global $ComBannerDstH,$ComBannerDstW;



	$f_args = func_get_args();

	$ex_total = preg_replace("/\D/","",$f_args[0]);
	$ex_width = preg_replace("/\D/","",$f_args[1]);
	$ex_template = $f_args[2];

	//print_r($f_args);

	$rand = rand(0,9999);
	$TPL->define("bg_image$rand",$skin_folder."/".$ex_template);
	$sql = "select * from $logo_bgimage_list order by sort DESC, number desc limit 0,$ex_total";
	$result = query($sql);
	$rows = "";

	$i = 1;
	while($BG_IMAGE = happy_mysql_fetch_assoc($result))
	{
		if ( $i == 1 )
		{
			$BG_IMAGE['check'] = " checked ";
		}
		$one_row = &$TPL->fetch();
		$rows .= table_adjust($one_row,$ex_width,$i);
		$i++;
	}

	if ( $i == 1 )
	{
		return "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td>배경이미지로 사용할수 있는 이미지가 설정이 되지 않았습니다.</td></tr></table>";
	}
	else
	{
		return "<table cellpadding='0' cellspacing='0' border='0' width='100%'>$rows</table>";
	}



}


// {{메인탑메뉴 happy_menu_top.html}}
// {{HTML호출 happy_menu_top.html}}
function main_top_menu($Template, $skin = '')
{
	global $TPL, $skin_folder;

	$skin		= $skin == ''? $skin_folder : $skin;

	if( !(is_file("$skin/$Template")) )
	{
		print "$skin/$Template 파일이 존재하지 않습니다. <br>";
		return;
	}

	$random		= rand()%1000;
	$TPL->define("HTML호출_$random", "$skin/$Template");
	$content	= $TPL->fetch("HTML호출_$random");

	print $content;
}


//글자자르기 글자자를변수이름+변수이름+변수이름,10글자, 자르고 뒤에붙일문자
//변수를 합쳐서 잘라내야 할 필요가 있어서 추가(차량카테고리 명칭등등)
//{{글자자르기 {NEW.car_company}+{NEW.car_type}+{NEW.car_sub_type},10글자,33}}
function happy_string_cut($ex_val,$ex_cut,$ex_tail="..")
{
	//print_r(func_get_args());

	//자를 글자수
	$ex_cut		= preg_replace('/\D/', '', $ex_cut);

	//자를 글자의 원본변수이름
	$strs = explode("+",$ex_val);

	$cut_str = "";
	$str = "";

	$pattern = array('/<!--(.*?)-->/s', '/<script[^>]*?>(.*?)<\/script>/is', '/<style[^>]*?>(.*?)<\/style>/is', '/<(.*?)>/s');

	if ( count($strs) >= 1 )
	{
		//print_r($strs);
		foreach($strs as $k => $v)
		{
			$v = str_replace("}","",str_replace("{","",$v));

			//echo $v."<br>";

			#출력배열
			$tmp_img = explode(".",$v);
			#이미지컬럼명
			$tmp_colname = $tmp_img[1];
			eval("global $".$tmp_img[0].";");

			$ExArray = $$tmp_img[0];

			$now_str	= ( $tmp_colname != '' ) ? $ExArray[$tmp_colname] : $ExArray;
			$now_str	= preg_replace($pattern, '', $now_str);

			$cut_str	.= strip_tags($now_str);
		}
	}

	$str	= $cut_str;

	//html 제거되고 합쳐진 원본
	//잘라야 할 글자에 옵션태그가 같이 들어올경우 옵션효과를 유지시키기 위해서
	$str2 = kstrcut($str,$ex_cut,$ex_tail);
	$str = str_replace($str,"{string}",$cut_str);
	$str = str_replace("{string}",$str2,$str);

	return print $str;
}




// {{콤마 Data,etc1}}
function happy_number_format( $Arr, $Field='', $numb = 0 )
{
	global ${$Arr};

	$numb			= preg_replace("/\D/", "", $numb);
	if ( $numb == '' )
	{
		$numb			= 0;
	}

	$Arr			= ${$Arr};
	if ( is_array($Arr) === true && $Field != '' )
	{
		$price			= $Arr[$Field];
	}
	else
	{
		$price			= $Arr;
	}


	$tmp			= explode(".",$price);
	$String			= preg_replace("/\D/", "", $tmp[0]);  //숫자만 남기고 없애기
	$String			.= ( $numb == 0 ) ? "":".".$tmp[1];

	if( $String == '' )
	{
		$String = 0;
	}

	return @number_format($String, $numb);
}


#{{배너스크롤 그룹명,가로210,세로70,랜덤,속도1000,변경시간5000,현재창,자동시작}}
$happy_banner_frame_count = 0;
function happy_banner_scroll()
{
	$arg_title	= array('그룹명','가로사이즈','세로사이즈','정렬순서','속도','이미지변경시간','링크타겟','자동시작');
	$arg_names	= array('group_name','width','height','orderby','speed','interval','link_target','auto_play');
	$arg_types	= array(
						'width'			=> 'int',
						'height'		=> 'int',
						'speed'			=> 'int',
						'interval'		=> 'int',
						'orderby'		=> 'char',
						'auto_play'		=> 'char'
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
		#echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}

	global $happy_banner_frame_count;

	if ( $group_name != "" )
	{
		$group_name_encode	= urlencode($group_name);
	}
	else
	{
		return print "<font color='red'>그룹명을 입력하세요.</font>";
	}

	switch ( $orderby )
	{
		case '랜덤'		: $orderby			= 'rand';	break;
		case '등록순'	: $orderby			= 'asc';	break;
		case '등록역순'	: $orderby			= 'desc';	break;
		default			: $orderby			= '';		break;
	}

	switch ( $link_target )
	{
		case '새창'		: $link_target		= 1;		break;
		default			: $link_target		= 0;		break;
	}

	switch ( $auto_play )
	{
		case '자동시작'	: $auto_play		= 1;		break;
		default			: $auto_play		= 0;		break;
	}

	$happy_banner_frame_count++;
	$frame_name			= "happy_banner_scroll_".$happy_banner_frame_count;

	print "<iframe name='$frame_name' src='happy_banner_scroll.php?group_name=$group_name_encode&width=$width&height=$height&orderby=$orderby&speed=$speed&interval=$interval&link_target=$link_target&auto_play=$auto_play' style='width:".$width."px; height:".$height."px; _height:".$height."px;' frameborder='0' scrolling='no'></iframe>";

}

#위지윅 내용부분 업로드파일 삭제 or 파일명 배열 return 함수
function happy_unlink_wys_file($html_code,$return='')
{
	global $demo_lock;

	if ( $html_code == "" )
	{
		return;
	}

	preg_match_all('/(<img [^>]*?src="(.*?)")(.*?>)/is',$html_code,$match_img);
	preg_match_all('/(<a [^>]*?href="(.*?)")(.*?>)/is',$html_code,$match_a);
	preg_match_all('/(<embed [^>]*?src="(.*?)")(.*?>.*?<\/embed>)/is',$html_code,$match_embed);

	$upload_files_str	= "";
	$upload_files_str2	= "";

	if ( is_array($match_img[2]) )
	{
		foreach($match_img[2] as $v )
		{
			if ( !preg_match("/^http:\/\//i",$v) )
			{
				$upload_files_str		.= $v."__cut__";
			}
		}
	}
	if ( is_array($match_a[2]) )
	{
		foreach($match_a[2] as $v )
		{
			if ( !preg_match("/^http:\/\//i",$v) )
			{
				$upload_files_str		.= $v."__cut__";
			}
		}
	}
	if ( is_array($match_embed[2]) )
	{
		foreach($match_embed[2] as $v )
		{
			if ( !preg_match("/^http:\/\//i",$v) )
			{
				$upload_files_str		.= $v."__cut__";
			}
		}
	}

	if ( str_replace("__cut__","",$upload_files_str) != "" )
	{
		$upload_files		= explode("__cut__",$upload_files_str);
		$upload_files		= array_filter($upload_files);
	}

	for ( $i = 0; $i < sizeof($upload_files); $i++ )
	{
		$wys_image			= $upload_files[$i];
		$wys_image			= explode("/", $wys_image );

		if ( $wys_image[1] == "wys2" && ( $wys_image[2] == "file_attach" || $wys_image[2] == "swf_upload" ) )
		{
			$del_thumb_url		= '';

			if ( $wys_image[2] == "file_attach" )
			{
				$del_thumb_url		= str_replace("file_attach", "file_attach_thumb", $upload_files[$i]);

				$upload_files_str2	.= $del_thumb_url."__cut__";

				if ( $demo_lock == "" && $return != 'return' )
				{
					@unlink(".".$upload_files[$i]);
					@unlink(".".$del_thumb_url);
				}
			}
			else
			{
				if ( $demo_lock == "" && $return != 'return' )
				{
					@unlink(".".$upload_files[$i]);
				}
			}

			# 추출섬네일까지 삭제
			$del_thumb_folder	= "./".$wys_image[1]."/".$wys_image[2]."/".$wys_image[3]."/".$wys_image[4]."/".$wys_image[5];

			if ( $wys_image[2] == "file_attach" ){
				$del_thumb_folder	= "./".$wys_image[1]."/file_attach_thumb/".$wys_image[3]."/".$wys_image[4]."/".$wys_image[5];
			}

			$handle				= @opendir($del_thumb_folder);

			while ( $file = @readdir( $handle ) )
			{
				$del_thumb_img_tmp	= explode(".", $wys_image[6]);
				$del_thumb_img		= $del_thumb_img_tmp[0];

				if ( $file != "." && $file != ".." && preg_match("/$del_thumb_img/", $file ) )
				{
					$upload_files_str2	.= $del_thumb_folder."/".$file."__cut__";

					if ( $demo_lock == "" && $return != 'return' )
					{
						@unlink( $del_thumb_folder."/".$file );
					}

				}
			}
		}
	}

	if ( $return == 'return' )
	{
		if ( str_replace("__cut__","",$upload_files_str2) != "" )
		{
			$upload_files2		= explode("__cut__",$upload_files_str2);
			$upload_files2		= array_filter($upload_files2);
			$upload_files		= array_merge($upload_files2,$upload_files);
		}

		return $upload_files;
	}
}

#첨부파일 삭제 or 파일명 return 함수
function happy_unlink_attach_file($file_name,$upload_path='',$return='')
{
	global $demo_lock;

	if ( $file_name == "" )
	{
		return;
	}

	if ( !is_file($file_name) ) //추가
	{
		return;
	}

	$file_tmp			= explode("/",$file_name);

	if ( sizeof($file_tmp) > 1 )
	{
		$file_name_str		= $file_tmp[sizeof($file_tmp)-1];
		array_pop($file_tmp);

		$upload_path_str	= implode("/", (array) $file_tmp);
		$upload_path_str	= "./".$upload_path."/".$upload_path_str;
	}
	else
	{
		$file_name_str		= $file_name;
		$upload_path_str	= "./".$upload_path;
	}

	$upload_path_str	= str_replace("//","/",$upload_path_str);

	$del_file			= explode(".",$file_name_str);
	$del_file_name		= $del_file[0];
	$del_file_ext		= $del_file[sizeof($del_file)-1]; //추가

	$upload_files_str	= "";

	$handle				= @opendir($upload_path_str);

	while ( $file = @readdir( $handle ) )
	{
		if ( $file != "." && $file != ".." && preg_match( "/$del_file_name/", $file ) )
		{
			$file_tmp2 = explode(".",$file); //추가
			$file_ext = $file_tmp2[sizeof($file_tmp2)-1]; //추가
			if ( $del_file_ext == $file_ext ) //추가
			{ //추가
				$upload_files_str	.= $upload_path_str."/".$file."__cut__";

				if ( $return != 'return' && $demo_lock == "" )
				{
					@unlink( $upload_path_str."/".$file );
				}
			}
		}
	}

	if ( preg_match("/data\//",$upload_path_str) && is_dir("./wys2/file_attach_thumb/board_thumb") )
	{
		$upload_path2		= str_replace("data","wys2/file_attach_thumb/board_thumb",$upload_path_str);

		$handle				= @opendir($upload_path2);

		while ( $file = @readdir( $handle ) )
		{
			if ( $file != "." && $file != ".." && preg_match( "/$del_file_name/", $file ) )
			{
				$file_tmp2 = explode(".",$file); //추가
				$file_ext = $file_tmp2[sizeof($file_tmp2)-1]; //추가
				if ( $del_file_ext == $file_ext ) //추가
				{ //추가
					$upload_files_str	.= $upload_path2."/".$file."__cut__";

					if ( $return != 'return' && $demo_lock == "" )
					{
						@unlink( $upload_path2."/".$file );
					}
				}
			}
		}
	}

	if ( $return == 'return' )
	{
		if ( str_replace("__cut__","",$upload_files_str) != "" )
		{
			$upload_files		= explode("__cut__",$upload_files_str);
			$upload_files		= array_filter($upload_files);
		}

		return $upload_files;
	}
}





#패키지(즉시적용) 사용자 선택박스
function pack2_box()
{
	global $TPL,$skin_folder,$job_money_package2,$PACK2,$package2_box;
	global $script_pack2_all;

	$SWAP_NUMBER		= Array();
	$TPL->define("패키지즉시적용", "$skin_folder/package2_selectbox.html");
	$Sql_pack2		= "SELECT * FROM $job_money_package2 WHERE is_use=1 ";
	$Rec_pack2		= query($Sql_pack2);
	while($PACK2	= happy_mysql_fetch_assoc($Rec_pack2))
	{
		$SWAP_NUMBER[]					= $PACK2['number'];
		$PACK2['uryo_detail_text']		= uryo_title_convert_company($PACK2['uryo_detail']);
		$PACK2['package2_selectbox']	= "<select name='pack2_uryo_{$PACK2[number]}' id='pack2_uryo_{$PACK2[number]}' style='background-color:#EAEAEA' onChange=\"Func_pack2_now_price($PACK2[number]);figure();\" disabled>";
		$PACK2['price_explode1']		= explode(",",$PACK2['price']);
		foreach($PACK2['price_explode1'] AS $ppe1_key => $ppe1_val)
		{
			//print_r2($PACK2['price_explode1']);
			$PACK2['price_explode2']	= explode(":",$ppe1_val);
			//print_r2($PACK2['price_explode2']);

			$pp2	= 0;
			foreach($PACK2['price_explode2'] AS $ppe2_key => $ppe2_val)
			{
				$pp2++;
				if($ppe2_val != 0)
				{
					switch($pp2)
					{
						case 1:				$text_uryo_date	= "[+{$ppe2_val}일(회) 연장]";break;
						case 2:				$text_jump_cnt	= "[점프 +{$ppe2_val}회 추가]";break;
						case 3:				$text_doc_date	= "[이력서열람 +{$ppe2_val}일 연장]";break;
						case 4:				$text_doc_cnt	= "[이력서열람 +{$ppe2_val}회 추가]";break;
						case 5:				$text_money		= "== ".number_format($ppe2_val)."원";break;
					}
				}
			}
			$PACK2['package2_selectbox']	.= "<option value='$ppe1_val'>{$text_uryo_date}{$text_jump_cnt}{$text_doc_date}{$text_doc_cnt} {$text_money}</option>";
			unset($ppe2_key,$ppe2_val,$text_uryo_date,$text_jump_cnt,$text_doc_date,$text_doc_cnt,$text_money);
		}
		$PACK2['package2_selectbox']	.= "</select>";
		unset($ppe1_key,$ppe1_val);
		//echo $PACK2['package2_selectbox'];


		$PACK2['add_option']			= nl2br($PACK2['add_option']);
		if($PACK2['help_link'] != "")
		{
			$PACK2['help_link_info']	= "<span style='cursor:pointer' onClick=\"window.open('$PACK2[help_link]','help_link','toolbar=no,menubar=no,status=no,width=813,height=420,scrollbars=yes')\"><img src='img/btn_map.gif' style='margin-top:5px;'></span>";
		}

		$package2_box	.= $TPL->fetch("패키지즉시적용");
	}
	$script_pack2_all	= @implode(",", (array) $SWAP_NUMBER);


	return $package2_box;
}
#패키지(즉시적용) 사용자 선택박스 END


#패키지(즉시적용) 카운트 가공함수
function pack2_cnt($P_DATA="")
{
	global $job_money_package2,$CNT_URYO;


	//$P_DATA($_POST)
	if($P_DATA['pack2_all_number'] != "")
	{
		$CNT_URYO						= Array(); //패키지(즉시적용) 배열필드당 카운트합계 담을곳
		$pack2_number_explode			= explode(",",$P_DATA['pack2_all_number']);
		foreach($pack2_number_explode AS $pne_key => $pne_val)
		{
			if($P_DATA['pack2_uryo_'.$pne_val] != "") //패키지(즉시적용) selectbox 선택했다면
			{
				$Sql_pack2				= "SELECT price,title,uryo_detail FROM $job_money_package2 WHERE number=$pne_val";
				$Rec_pack2				= query($Sql_pack2);
				$PACK2					= happy_mysql_fetch_assoc($Rec_pack2);


				//선택한 값이 DB값과 맞는지 체크
				$bool_money_chk			= false;
				$PACK2['price_explode']	= explode(",",$PACK2['price']); //ex) 10:50:30:70:50000
				foreach($PACK2['price_explode'] AS $price_val)
				{
					if(trim($price_val) == trim($P_DATA['pack2_uryo_'.$pne_val]))
					{
						$bool_money_chk	= true;
						break;
					}
				}
				unset($price_val);

				if($bool_money_chk == false)
				{
					msg("정확한 결제금액이 아닙니다");
					exit;
				}
				//선택한 값이 DB값과 맞는지 체크 END

				$PACK2['ud_explode']	= explode(",",$PACK2['uryo_detail']);


				//체크가 된 유료옵션 뽑기
				$SWAP_USE_FIELD				= Array();
				foreach($PACK2['ud_explode'] AS $ud_key => $ud_val)
				{
					$ud_val_explode			= explode(":",$ud_val);
					if($ud_val_explode[1] == 1)
					{
						$SWAP_USE_FIELD[]	= $ud_val_explode[0];
					}
				}
				unset($ud_key,$ud_val);
				//print_r2($SWAP_USE_FIELD);exit;
				//체크가 된 유료옵션 뽑기 END


				//선택된 패키지(즉시적용) 작업
				$pu_explode					=  explode(":",$P_DATA['pack2_uryo_'.$pne_val]);
				$pp							= 0;
				foreach($pu_explode AS $pe_val)
				{
					$pp++;


					switch($pp)
					{
						//유료옵션 일(회)연장
						case 1:			foreach($SWAP_USE_FIELD AS $uf_val)
										{
											/*
											if($uf_val == "guin_bgcolor_com")
											{
												//$uf_val	= str_replace("_com","",$uf_val);
											}
											*/

											$CNT_URYO[$uf_val] = $CNT_URYO[$uf_val] + $pe_val; //guin_banner1,guin_pick.......
											//echo $CNT_URYO[$uf_val]."($uf_val) => ".$pe_val."<br>";
										}
										break;

						//점프 회
						case 2:			$CNT_URYO['guin_jump']		= $CNT_URYO['guin_jump'] + $pe_val;
										//echo "이력서열람(일) : ".$CNT_URYO['guin_jump']."<br>";
										break;

						//이력서열람 일 연장
						case 3:			$CNT_URYO['guin_docview']	= $CNT_URYO['guin_docview'] + $pe_val;
										//echo "이력서열람(일) : ".$CNT_URYO['guin_docview']."<br>";
										break;

						//이력서열람 회 연장
						case 4:			$CNT_URYO['guin_docview2']	= $CNT_URYO['guin_docview2'] + $pe_val;
										//echo "이력서열람(회) : ".$CNT_URYO['guin_docview2']."<br>";
										break;

						//패키지금액
						case 5:			$CNT_URYO['price']			= $CNT_URYO['price'] + $pe_val;
										break;
					}

				}
				unset($pe_val);
				//선택된 패키지(즉시적용) 작업 END

				$CNT_URYO['title']	= $PACK2['title'];
			}
		}
		unset($pne_key,$pne_val);

	}

	return $CNT_URYO;
}
#패키지즉시적용 카운트 가공함수 END




//유료옵션 이름
function uryo_title_convert_company($str)
{
	global $ARRAY,$ARRAY_NAME,$ARRAY_NAME2;
	global $CONF;


	//채용정보의 아이콘옵션은 패키지에서 제외
	$del_bunho = array("11");
	$tmp_arr1 = array();
	$tmp_arr2 = array();
	$tmp_arr3 = array();
	$i = 0;
	foreach($ARRAY as $k => $v)
	{
		if ( !in_array($i,$del_bunho) )
		{
			$tmp_arr1[] = $ARRAY[$i];
			$tmp_arr2[] = $ARRAY_NAME[$i];
			$tmp_arr3[] = $ARRAY_NAME2[$i];
		}
		$i++;
	}
	//print_r($tmp_arr1);

	//유료옵션 제목
	$option_array_name = $tmp_arr1;
	//유료옵션 DB필드명
	$option_array = $tmp_arr2;
	//유료옵션 아이콘
	$option_array_icon = $tmp_arr3;


	$return_str = "";

	$tmp_a = explode(",",$str);
	if ( is_array($tmp_a) )
	{
		$i = 0;
		$o_count = 0;
		foreach($tmp_a as $v)
		{
			$Uryo['uryo_danwi'] = "";

			$tmp_a2 = explode(":",$v);
			$uryo_name = $option_array[$i];

			if ( $tmp_a2[1] != 0 )
			{
				$type_icon = " <img src=../$option_array_icon[$i] align=absmiddle border=0>";

				//if ( $i != 9 )
				//{
				//	$return_str.= $type_icon." ".$uryo_name." ".$tmp_a2[1]."일";
				//}
				//else
				//{
				//	$return_str.= $type_icon." ".$uryo_name." ".$tmp_a2[1]."회";
				//}

				//채용정보 + 기업회원의 유료옵션은 회수별,노출별,기간별,이력서수,횟수별 이 있다.
				$opt_name = $option_array_name[$i]."_option";
				//echo $opt_name.":".$CONF[$opt_name]."<br>";
				if ( $CONF[$opt_name] == "기간별" )
				{
					$Uryo['uryo_danwi'] = "일";
				}
				else if ( $CONF[$opt_name] == "노출별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "클릭별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "이력서수" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else if ( $CONF[$opt_name] == "횟수별" || $CONF[$opt_name] == "회수별" )
				{
					$Uryo['uryo_danwi'] = "회";
				}
				else
				{
					$Uryo['uryo_danwi'] = "일";
				}

				$o_count++;
				$return_str.= $o_count.". ".$uryo_name."<br>";
			}

			$i++;
		}
	}

	return $return_str;
}




#{{슬라이드배너 총개수,정렬}}
#<주의사항>iframe 태그안에 넣어야하며 페이지당 1개만 호출가능
function happy_banner_slide( $Total_limit,$orderby )
{
	$arg_title	= array('총개수','정렬');
	$arg_names	= array('Total_limit','orderby');
	$arg_types	= array(
						'Total_limit'		=> 'int',
						'orderby'			=> '',
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
		#echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}


	global $main_url,$HAPPY_CONFIG;
	global $happy_banner_slide;


	if ( $WHERE == '' )
	{
		$WHERE = " WHERE display = 'Y' and ( now() between startdate and enddate ) ";
	}
	else
	{
		$WHERE .= " AND display = 'Y' and ( now() between startdate and enddate ) ";
	}



	switch( $orderby )
	{
		case "랜덤" :		$ORDER	= "ORDER BY rand()";break;
		case "등록순" :		$ORDER	= "ORDER BY regdate ASC";break;
		case "등록역순" :	$ORDER	= "ORDER BY regdate DESC";break;
		case "소팅순" :		$ORDER	= "ORDER BY sort DESC";break;
		default :			$ORDER	= "";break;
	}


	//$HAPPY_CONFIG['slide_stop_loop'] = ( $HAPPY_CONFIG['slide_stop_loop'] == 0 ) ? 1 : 0;


	$output			= "


							<script type='text/javascript'>

								jQuery(function($){

									$.supersized({

										// Functionality
										slideshow               :   1,			// Slideshow on/off
										autoplay				:	$HAPPY_CONFIG[slide_autoplay],			// Slideshow starts playing automatically
										start_slide             :   1,			// Start slide (0 is random)
										stop_loop				:	$HAPPY_CONFIG[slide_stop_loop],			// Pauses slideshow on last slide
										random					: 	0,			// Randomize slide order (Ignores start slide)
										slide_interval          :   $HAPPY_CONFIG[slide_interval],		// Length between transitions
										transition              :   $HAPPY_CONFIG[slide_transition], 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
										transition_speed		:	$HAPPY_CONFIG[slide_transition_speed],		// Speed of transition
										new_window				:	$HAPPY_CONFIG[slide_new_window],			// Image links open in new window/tab
										pause_hover             :   $HAPPY_CONFIG[slide_pause_hover],			// Pause slideshow on hover
										keyboard_nav            :   1,			// Keyboard navigation on/off
										performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
										image_protect			:	1,			// Disables image dragging and right click with Javascript

										// Size & Position
										min_width		        :   480,			// Min width allowed (in pixels)
										min_height		        :   120,			// Min height allowed (in pixels)
										vertical_center         :   1,			// Vertically center background
										horizontal_center       :   1,			// Horizontally center background
										fit_always				:	1,			// Image will never exceed browser width or height (Ignores min. dimensions)
										fit_portrait         	:   1,			// Portrait images will not exceed browser height
										fit_landscape			:   0,			// Landscape images will not exceed browser width

										// Components
										slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
										thumb_links				:	1,			// Individual thumb links for each slide
										thumbnail_navigation    :   0,			// Thumbnail navigation
										slides 					:  	[			// Slideshow Images
	";



	$Arr_domain_ext	= Array(".com",".kr",".co.kr",".net",".org",".or.kr",".biz",".info",".tv",".co",".cc",".asia",".cn",".tw",".in",".pe.kr",".me",".name",".so ");

	$Sql			= "SELECT count(*) FROM $happy_banner_slide $WHERE ";
	$Rec			= query($Sql);
	$Total_Count	= mysql_fetch_row($Rec);
	$Total_Count	= $Total_Count[0];

	$Sql			= "SELECT * FROM $happy_banner_slide $WHERE $ORDER LIMIT 0,$Total_limit";
	$Rec			= query($Sql);
	$Count_banner	= 1;
	while($Data	= happy_mysql_fetch_array($Rec))
	{
		if($Total_Count > $Count_banner)
		{
			$comma			= ",";
		}
		else
		{
			$comma			= "";
		}

		$Data['link']		= trim($Data['link']);

		if(!preg_match("/https:\/\//",$Data["link"]))
		{
			$domain_chk_bool	= false;
			foreach($Arr_domain_ext AS $ADE => $ADE_VAL)
			{
				if(stristr($Data['link'],$ADE_VAL))
				{
					$domain_chk_bool	= true;
					break;
				}
			}
			unset($ADE,$ADE_VAL);

			if($domain_chk_bool == true)
			{
				$Data["link"] = "http://". preg_replace("/http:\/\//i","",$Data["link"]);
			}
		}

		$output .= "{image : '$Data[img]', title : '$Data[title]', thumb : '$Data[img]', url : '$Data[link]'}$comma";

		$Count_banner++;
	}


	if($Total_Count == 0)
	{
		$output = "{image : '$HAPPY_CONFIG[Mall_ImgBannerNoImg1]', title : '', thumb : '$HAPPY_CONFIG[Mall_ImgBannerNoImg1]', url : ''}";
	}

	$output			.= "
										],

										// Theme Options
										progress_bar			:	1,			// Timer for each slide
										mouse_scrub				:	0
									});
								});

							</script>









								<!--Thumbnail Navigation-->
								<div id='prevthumb'></div>
								<div id='nextthumb'></div>

								<!--Arrow Navigation-->
								<a id='prevslide' class='load-item' style='cursor:pointer;'><img src='img/slide_supersized/back.png' class='png24' height='' width=''></a>
								<a id='nextslide' class='load-item' style='cursor:pointer;'><img src='img/slide_supersized/forward.png' class='png24' height='' width=''></a>

								<!-- <div id='thumb-tray' class='load-item'>
									<div id='thumb-back'></div>
									<div id='thumb-forward'></div>
								</div> -->

								<!--Time Bar
								<div id='progress-back' class='load-item'>
									<div id='progress-bar'></div>
								</div>-->

								<!--Control Bar-->
								<div id='controls-wrapper' class='load-item'>
									<div id='controls'>

										<!--<a id='play-button'><img id='pauseplay' src='../img/slide_supersized/pause.png'/></a>-->


										<!--<div id='slidecounter'>
											<span class='slidenumber'></span> / <span class='totalslides'></span>
										</div>

										Slide captions displayed here
										<div id='slidecaption'></div>
										<!--Thumb Tray button
										<a id='tray-button'><img id='tray-arrow' src='../img/slide_supersized/button-tray-up.png'/></a>-->

										<!--Navigation-->
										<ul id='slide-list'></ul>

									</div>
								</div>


	";





	return print $output;


}



//{{인코드 Data,title}}
//{{인코드 홈페이지주소}}
function happy_urlencode( $Arr, $Field='' )
{
	global ${$Arr};

	$Ori_Arr		= $Arr;

	$Arr			= ${$Arr};

	if ( is_array($Arr) === true && $Field != '' )
	{
		$String			= $Arr[$Field];
	}
	else
	{
		$String			= $Arr;
	}

	$String		= $String == '' ? $Ori_Arr : $String;

	echo urlencode($String);
}



//지역개선작업
$siXmlCreateCheck	= '';
function xmlAddressCreate( $siChangeNumber )
{
	global $guin_tb, $si_tb, $AREA_SI, $AREA_SI_NUMBER, $GU_NUMBER, $xml_area1, $xml_area2, $xml_area_file, $xml_flash;
	global $xmlAddress_NcontA, $xmlAddress_NcontB, $xmlAddress_NcontC;
	global $xmlAddress_CcontA, $xmlAddress_CcontB, $xmlAddress_CcontC, $xmlAddress_CcontD;
	global $xmlAddress_mapbg, $xmlAddress_ovcolor, $xmlAddress_linecolor, $xmlAddress_titlecolor, $xmlAddress_speed;

	global $xmlpath, $siXmlCreateCheck;
	global $SI_NUMBER;
	global $GU_NUMBER2; //지역개선작업

	$siNum		= $siChangeNumber;
	$siName		= $AREA_SI[$siNum];
	$guArray	= $xml_area2[$siName];
	$guLen		= sizeof($guArray);
	$fileName	= $xml_area_file[$siName];




	if ( $guArray == '' )
		return "<font color='red'>ERROR :: xmlAddressCreate()</font>";


	############## 전국플레쉬 xml 파일 생성 ################
	if ( $siXmlCreateCheck == '' )
	{
		$content	= "
						<?xml version='1.0' encoding='UTF-8'?>

						<xmlstart>

						<banner>
					";


		for ( $i=0,$max=sizeof($xml_area1) ; $i<$max ; $i++ )
		{
			$siNameTmp	= $xml_area1[$i];
			$siNumTmp	= $AREA_SI_NUMBER[$siNameTmp];


			$siNumTmp2 = $AREA_SI_NUMBER['전국'];

			if ( $siNameTmp != "" )
			{
				$Sql	= "
							SELECT
									COUNT(*)
							FROM
									$guin_tb
							WHERE
									(
										si1		= '$siNumTmp'
										or
										si2		= '$siNumTmp'
										or
										si3		= '$siNumTmp'
										or
										si1		= '$SI_NUMBER[전국]'
										or
										si2		= '$SI_NUMBER[전국]'
										or
										si3		= '$SI_NUMBER[전국]'
									)
									AND
									(
										guin_end_date	>= curdate()
										or
										guin_choongwon	= '1'
									)
				";
				//echo $Sql.'<br />';

				$Data	= happy_mysql_fetch_array(query($Sql));
				$Count	= $Data[0];
			}
			else
			{
				$guNum	= 0;
				$Count	= 0;
			}

			$content	.= "<List url=\"javascript:call_subflash('". $xml_flash[$siNameTmp] ."',330,300)\" target='' areaname='$siNameTmp' count='$Count'/>\n";
		}



		$content	.= "
						</banner>

						<ProductNum NcontA='$xmlAddress_NcontA' NcontB='$xmlAddress_NcontB' NcontC='$xmlAddress_NcontC' CcontA='$xmlAddress_CcontA' CcontB='$xmlAddress_CcontB' CcontC='$xmlAddress_CcontC' CcontD='$xmlAddress_CcontD'/>
						<color mapbg='$xmlAddress_mapbg' ovcolor='$xmlAddress_ovcolor' linecolor='$xmlAddress_linecolor'/>
						<speed speed='$xmlAddress_speed'/>

						</xmlstart>
					";

		$content	= str_replace("\t","",$content);

		$fp	= fopen($xmlpath."xml/mapurl.xml","w");
		fwrite($fp,$content);
		fclose($fp);

		$siXmlCreateCheck	= '1';
	}


	############## 서브플레쉬 xml 파일 생성 ################
	$content	= "
					<?xml version='1.0' encoding='UTF-8'?>

					<xmlstart>

					<banner>
				";

	//print_r($GU_NUMBER)."<Br>";

	for ( $i=0 ; $i<$guLen ; $i++ )
	{
		$guName	= str_replace(" ","",$guArray[$i]);

		//echo $guName."<br>";

		//$guNum	= $GU_NUMBER[$guName];
		//echo $guName." [$guNum]<br>";
		#if ( $guNum == "" ){ query("INSERT INTO $car_si_gu SET si='$siNum' , gu='$guName'"); }

		$guNum	= $GU_NUMBER2[$siNum][$guName]; //지역개선작업

		if ( $guNum != "" )
		{
			$Sql	= "
						SELECT
								COUNT(*)
						FROM
								$guin_tb
						WHERE
								(
									si1		= '$SI_NUMBER[전국]'
									or
									si2		= '$SI_NUMBER[전국]'
									or
									si3		= '$SI_NUMBER[전국]'
									or
									gu1_ori	= '$guNum'
									or
									gu2_ori	= '$guNum'
									or
									gu3_ori	= '$guNum'
								)
								AND
								(
									guin_end_date	>= curdate()
									or
									guin_choongwon	='1'
								)
			";
			//echo $Sql."<br>";
			$Data	= happy_mysql_fetch_array(query($Sql));
			$Count	= $Data[0];

			$guQueryString = "&search_gu={$guNum}";
		}
		else
		{

			$guNum	= 0;
			$Count	= 0;

			//echo $guName."<br>";
			$guQueryString = "&search_guName=".urlencode($guName);

			global $gu_tb;
			$guinNums = array();
			//고양시 일산동구, 고양시 일산서구 같은 지역으로 설정된 카운터
			$Sql22 = "SELECT * FROM $gu_tb WHERE gu like '{$guName}%'";
			//echo $Sql22."<br>";
			$Result22 = query($Sql22);
			while($Gu = happy_mysql_fetch_array($Result22))
			{
				$guNum = $Gu['number'];

				$Sql	= "
							SELECT
									number
							FROM
									$guin_tb
							WHERE
									(
										si1		= '$SI_NUMBER[전국]'
										or
										si2		= '$SI_NUMBER[전국]'
										or
										si3		= '$SI_NUMBER[전국]'
										or
										gu1_ori	= '$guNum'
										or
										gu2_ori	= '$guNum'
										or
										gu3_ori	= '$guNum'
									)
									AND
									(
										guin_end_date	>= curdate()
										or
										guin_choongwon	='1'
									)
				";
				//echo $Sql."<br>";
				$Result = query($Sql);
				while( $Data = happy_mysql_fetch_array($Result) )
				{
					if ( !in_array($Data['number'],$guinNums) )
					{
						$guinNums[] = $Data['number'];
						$Count++;
					}
				}
			}

		}


		$siNum = $AREA_SI_NUMBER[$siName];
		$content	.= "<List url='?file=guin_arealist.html&file2=default_guin.html&search_si=${siNum}{$guQueryString}&action=search' target='' areaname='$guName' count='$Count'/>\n";
	}

	$content	.= "
					</banner>

					<siname siname='$siName'/>
					<color mapbg='$xmlAddress_mapbg' ovcolor='$xmlAddress_ovcolor' linecolor='$xmlAddress_linecolor' titlecolor='$xmlAddress_titlecolor'/>
					<speed speed='$xmlAddress_speed'/>
					<allurl allurl='?file=guin_arealist.html&file2=default_guin.html&search_si=${siNum}' alltarget=''/>
					<ProductNum NcontA='$xmlAddress_NcontA' NcontB='$xmlAddress_NcontB' NcontC='$xmlAddress_NcontC' CcontA='$xmlAddress_CcontA' CcontB='$xmlAddress_CcontB' CcontC='$xmlAddress_CcontC' CcontD='$xmlAddress_CcontD'/>

					</xmlstart>
				";

	$content	= str_replace("\t","",$content);
	$fileName = $xmlpath.$fileName;
	$fp2	= fopen($fileName,"w");
	fwrite($fp2,$content);
	fclose($fp2);

	return;
}

//print_r2($gu_temp_array);

/*
if ( !(eregi("admin", $_SERVER['PHP_SELF'])) && !(eregi("wys2", $_SERVER['PHP_SELF'])) && !(eregi("banktown", $_SERVER['PHP_SELF'])) && !(eregi("xml", $_SERVER['PHP_SELF']))  )
{
	if ( substr_count($_SERVER['REQUEST_URI'],'/') == 1 )
	{
		for ( $i=0 , $max=sizeof($xml_area1) ; $i<$max ; $i++ )
		{
			xmlAddressCreate($AREA_SI_NUMBER[$xml_area1[$i]]);
		}
	}
}
*/
/*
for ( $i=0 , $max=sizeof($xml_area1) ; $i<$max ; $i++ )
{
	xmlAddressCreate($AREA_SI_NUMBER[$xml_area1[$i]]);
}
*/





//{{검색그룹 고용형태별,가로2개,세로2개,rows_search_group.html}}
//ralear 2013-12-17
function search_group()
{
	global $area_tb, $TPL, $skin_folder, $G_Data;
	global $si_tb, $guin_tb, $SI_NUMBER, $per_document_tb;

	$arg_names		= array('type', 'ex_width', 'ex_height', 'ex_template');
	$arg_types		= array(
							'ex_width'			=> 'int',
							'ex_height'			=> 'int'
	);

	for ( $i = 0, $max = func_num_args(); $i < $max; $i++ )
	{
		$value			= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
		#echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}

	if ( $ex_width == '' || $ex_width < 1 )
	{
		echo "가로값이 없습니다.";
		return;
	}

	if ( $ex_height == '' || $ex_height < 1 )
	{
		echo "세로값이 없습니다.";
		return;
	}

	if ( $ex_template == '' )
	{
		echo "추출태그에 템플릿 파일을 넣어주세요.";
		return;
	}

	$Limit			= $ex_width * $ex_height;


	if ( $type == '고용형태별' )
	{
		$Sql			= "
							SELECT
									root_job
							FROM
									$area_tb
							WHERE
									number = '1'
		";
		$Temp			= happy_mysql_fetch_assoc(query($Sql));

		//헤드헌팅 제거
		global $hunting_use;
		if ( $hunting_use == false )
		{
			$Temp['root_job']	= str_replace(">헤드헌팅","",$Temp['root_job']);
		}

		//print_r2($Temp);

		$Temp_Ex		= explode(">", $Temp['root_job']);
	}
	else if ( $type == '지역' || $type == '구직지역' )
	{
		$Table_Name		= '';
		$Area_Where		= '';
		$Area_Field		= Array();
		if ( $type == '지역' )
		{
			$Table_Name		= $guin_tb;
			$sql_today			= date("Y-m-d");
			$Area_Where		= "
								guin_end_date	>= '$sql_today'
								OR
								guin_choongwon	= '1'
			";

			$Area_Field		= Array('si1','si2','si3');
		}
		else
		{
			$Table_Name		= $per_document_tb;
			$Area_Where		= "
								display = 'Y'
			";

			$Area_Field		= Array('job_where1_0','job_where2_0','job_where3_0');
		}

		//지역 카운트 해쉬데이터 생성 ralear 2014-01-14
		$Sql			= "
							SELECT
									COUNT(*) as count,
									$Area_Field[0],
									$Area_Field[1],
									$Area_Field[2]
							FROM
									$Table_Name
							WHERE
									$Area_Where
							GROUP BY
									$Area_Field[0],
									$Area_Field[1],
									$Area_Field[2]
		";
		//echo nl2br($Sql);
		$Record			= query($Sql);
		$Area_Count		= Array();
		while ( $rows = happy_mysql_fetch_assoc($Record) )
		{
			$Temp			= Array(
										$Area_Field[0]	=> $rows[$Area_Field[0]],
										$Area_Field[1]	=> $rows[$Area_Field[1]],
										$Area_Field[2]	=> $rows[$Area_Field[2]]
			);

			$Temp			= array_unique($Temp);

			foreach ( $Temp as $Key => $Value )
			{
				$Area_Count[$Value] += $rows['count'];
			}
		}

		//print_r2($Area_Count);

		$Sql			= "
							SELECT
									si,
									number
							FROM
									$si_tb
							ORDER BY
									sort_number ASC
		";
		$Record			= query($Sql);
		$Temp_Ex		= Array();
		while ( $Temp = happy_mysql_fetch_assoc($Record) )
		{
			$Temp_Ex[$Temp['number']] = $Temp['si'];

			//각 지역에 전국카운트++
			if ( $Temp['number'] != $SI_NUMBER[전국] )
			{
				$Area_Count[$Temp['number']] += $Area_Count[$SI_NUMBER[전국]];
			}
		}

		//중복전국카운트 제거
		$Sql			= "
							SELECT
									$Area_Field[0],
									$Area_Field[1],
									$Area_Field[2]
							FROM
									$Table_Name
							WHERE
									$Area_Field[0]	= '$SI_NUMBER[전국]'
									OR
									$Area_Field[1]	= '$SI_NUMBER[전국]'
									OR
									$Area_Field[2]	= '$SI_NUMBER[전국]'
									AND
									(
										$Area_Where
									)
		";
		//echo nl2br($Sql);
		$Record			= query($Sql);
		while ( $rows = happy_mysql_fetch_assoc($Record) )
		{
			$Temp			= Array(
										$Area_Field[0]	=> $rows[$Area_Field[0]],
										$Area_Field[1]	=> $rows[$Area_Field[1]],
										$Area_Field[2]	=> $rows[$Area_Field[2]]
			);

			$Temp			= array_unique($Temp);

			//중복--
			foreach ( $Temp as $Key => $Value )
			{
				if ( $Value != $SI_NUMBER[전국] )
				{
					$Area_Count[$Value]--;
				}
			}
		}

		//전국은 전체개수로 출력 - 2014-12-15 hong
		$Sql			= "
							SELECT
									COUNT(*)
							FROM
									$Table_Name
							WHERE
									$Area_Where
		";
		list($전체카운트) = happy_mysql_fetch_array(query($Sql));
		$Area_Count[$SI_NUMBER[전국]] = $전체카운트;
		//전국은 전체개수로 출력 - 2014-12-15 hong
	}
	else if ( $type == '경력별' )
	{
		$Sql			= "
							SELECT
									root_career
							FROM
									$area_tb
							WHERE
									number = '1'
		";
		$Temp			= happy_mysql_fetch_assoc(query($Sql));

		//print_r2($Temp);

		$Temp_Ex		= explode(">", $Temp['root_career']);
	}
	else if ( $type == '옵션별' ) //채용정보 유료옵션별 검색 추가 hong
	{
		global $ARRAY_SEARCH, $ARRAY_SEARCH_NAME;

		$Temp_Ex		= $ARRAY_SEARCH_NAME;
	}

	if ( sizeof($Temp_Ex) > 0 )
	{
		$random			= rand(0,9999);
		$Count			= 1;
		$rows			= '';
		$TPL->define("검색그룹_$random", $skin_folder."/".$ex_template );
		foreach ( $Temp_Ex as $s_num => $s_value )
		{
			if ( $Limit < $Count )
			{
				break;
			}

			$G_Data				= Array();
			$G_Data['s_value']	= $s_value;
			$G_Data['s_num']	= $s_num;

			if ( $type == '경력별' )
			{
				$s_value_ex			= explode('~', $s_value);
				$G_Data['s_value1']	= ( $s_value_ex[0] != "" ) ? str_replace("이상","",$s_value_ex[0])."이상" : "";
				$G_Data['s_value2']	= ( $s_value_ex[1] != "" ) ? str_replace("이하","",$s_value_ex[1])."이하" : "";
			}
			else if ( $type == '지역' || $type == '구직지역' )
			{
				$G_Data['count']	= $Area_Count[$G_Data['s_num']];
			}
			else if ( $type == '옵션별' ) //채용정보 유료옵션별 검색 추가 hong
			{
				$G_Data['s_key']	= $ARRAY_SEARCH[$G_Data['s_num']];
			}

			$one_row			= $TPL->fetch("검색그룹_$random");
			$rows				.= table_adjust($one_row, $ex_width, $Count);
			$Count++;
		}

		$rows		= "
						<table cellpadding='0' cellspacing='0' border='0' width='100%'>
						".$rows."
						</table>
		";

		echo $rows;
	}
	else
	{
		echo "[ $type ]은 잘못된 추출태그이거나 값이 없습니다.";
	}
}


//구직/구인 리스트검색 셀렉트박스
function sort_how_return($type = 'guin')
{
	$plus = "file=$_GET[file]&file2=$_GET[file2]&underground1=$_GET[underground1]";

	$url_array = @parse_url($_SERVER['QUERY_STRING']);
	$queryStr = isset($url_array['query']) ? $url_array['query'] : '';
	parse_str($queryStr, $queryArr);
	if (isset($queryArr['sort_order'])) {
		unset($queryArr['sort_order']);
	}
	$plus = $url_array['path'] . http_build_query($queryArr);

	if ( $type == 'guin_end' )
	{	//마감일검색
		$sort_title = array('-- 마감일 --','오늘마감','마감1일전','마감2일전','마감3일전','상시채용');
		$plus	.= "&sort_order=".urlencode($_GET[sort_order]);
		$select_name	= "search_guin_end_date";
	}
	else if ( $type == 'guin' )
	{
		$sort_title = array('-- 정렬방법 --','제목순','제목역순','경력순','경력역순','최근등록일순','최근수정일순','최근마감일순');
		$plus	.= "&search_guin_end_date=".urlencode($_GET[search_guin_end_date]);
		$select_name	= "sort_order";
	}
	else
	{
		$sort_title = array('-- 정렬방법 --','최근등록일순','최근수정순','경력많은순','경력작은순');
		$select_name	= "sort_order";
	}

	$sort_how = "<select name='$select_name' onchange=\"window.open(this.options[this.selectedIndex].value,'_self')\">";
	$i = '0';

	foreach ($sort_title as $list)
	{
		if ($sort_title[$i] == $_GET[$select_name])
		{
			$selected = 'selected';
			$check_number = $i;
		}
		else
		{
			$selected = '';
		}

		$sort_how .= "<option value='$PHP_SELF?$plus&$select_name=".urlencode($sort_title[$i])."' $selected>$list</option>";
		$i ++;
	}
	$sort_how .= '</select>';

	return $sort_how;
}

function convertUrlQuery($query)
{
	$queryParts		= explode('&', $query);

	$params			= array();
	foreach ($queryParts as $param)
	{
		if ( $param == '' )
		{
			continue;
		}

		$item				= explode('=', $param);
		$params[$item[0]]	= $item[1];
	}

	return $params;
}



function date_view( $date, $change )
{

	$date_exp = explode("-", $date);

	$date_chk = happy_mktime(0,0,0,$date_exp[1],$date_exp[2],$date_exp[0]);

	$date = date( $change, $date_chk );

	return $date;
}



//개인회원인지 , 기업회원인지 확인
//구직정보등록 권한이 있으면 개인회원
function is_per_member($user_id)
{
	global $happy_member_secure, $happy_member_secure_text;

	$Member			= happy_member_information($user_id);

	$Sql			= "
						SELECT
								COUNT(*)
						FROM
								$happy_member_secure
						WHERE
								group_number	= '".$Member['group']."'
								AND
								menu_use		= 'y'
								AND
								menu_title		= '".$happy_member_secure_text[0].'등록'."'
	";
	//echo nl2br($Sql);
	$Temp			= happy_mysql_fetch_array(query($Sql));
	$Count			= $Temp[0];

	if ( $Count > 0 )
	{
		return true;
	}
	else
	{
		return false;
	}
}

// SNS 회원이면 회원닉네임앞에 SNS 이미지 달아주는 함수
$SNSID_HASH	= Array();
function outputSNSID($Member,$icon_type='',$board_name='')
{
	global $happy_member, $happy_member_quies, $happy_sns_array, $SNSID_HASH;


	if(preg_match("/happy_member_quies\.php/",$_SERVER['PHP_SELF']))
	{
		$member_table	= $happy_member_quies;
	}
	else
	{
		$member_table	= $happy_member;
	}

	if( is_array($Member) )
	{
		$user_id = $Member['user_id'];
	}
	else
	{
		$user_id = $Member;
	}


	if($icon_type == "")
	{
		$icon_type = "icon_use_mypage";
	}

	if($SNSID_HASH[$user_id][$icon_type] == "")
	{
		# SNS LOGIN 처리 추가
		$comment_user		= happy_mysql_fetch_array(query("SELECT user_nick, sns_site FROM $member_table WHERE user_id='$user_id'"));
		$SNS_CHECK			= $happy_sns_array[$comment_user['sns_site']];
		if ( is_array($SNS_CHECK) === true )
		{
			$아이디			= ( $comment_user['user_nick'] == '' ) ? $user_id : $comment_user['user_nick'];
			if ( $SNS_CHECK[$icon_type] !== false )
			{
				$user_id2	= "<img src='". $SNS_CHECK[$icon_type]. "' border='0' align='absmiddle'>". $아이디;
			}
		}
		else if($board_name != '')
		{
			return $board_name;
		}
		else
		{
			return $user_id;
		}

		$SNSID_HASH[$user_id][$icon_type]	= $user_id2;
	}
	else if ( $SNSID_HASH[$user_id][$icon_type] == $user_id && $board_name != "" )
	{
		return $board_name;
	}


	return $SNSID_HASH[$user_id][$icon_type];
}


//{{서비스이용항목}}
function get_uryo_cnt($divi="1",$divi2="1")
{
	global $ARRAY_NAME,$PER_ARRAY_NAME, $ARRAY;
	global $guin_tb, $per_document_tb;
	global $user_id;
	global $real_gap;

	#print_r2($PER_ARRAY_NAME);
	if( $divi2 == 1 )
	{
		$i_array	= array(0,1,2,4,5,6,10,12,13,14);
	}
	else
	{
		$i_array	= array(0,1,2,4,5,6,7,8,9,10);
	}

	$ii = 0;
	$uryo_list = "";
	for( $i=0; $i<sizeof($i_array); $i++ )
	{
		if( $divi2 == 1 )
		{
			$add_sql_sub = $ARRAY[$i_array[$i]];

			$add_sql = "and $add_sql_sub > $real_gap ";

			$sql = "select count(*) from $guin_tb where guin_id ='$user_id' $add_sql and ( guin_end_date >= curdate() or guin_choongwon ='1' ) ";

			$uryo_name = $ARRAY_NAME[$i_array[$i]];
		}
		else
		{
			$WHERE = "";
			//echo $PER_ARRAY_NAME[$i_array[$i]]."<br>";
			switch ( $PER_ARRAY_NAME[$i_array[$i]] )
			{
				case "스페셜":			$WHERE .= " AND specialDate >= NOW() ";break;
				case "포커스":			$WHERE .= " AND focusDate >= NOW() ";break;
				case "파워링크":		$WHERE .= " AND powerlinkDate >= NOW() ";break;
				case "이력서스킨":		$WHERE .= " AND docskinDate >= NOW() ";break;
				case "아이콘":			$WHERE .= " AND iconDate >= NOW() ";break;
				case "볼드":			$WHERE .= " AND bolderDate >= NOW() ";break;
				case "칼라":			$WHERE .= " AND colorDate >= NOW() ";break;
				case "자유아이콘":		$WHERE .= " AND freeiconDate >= NOW() AND freeicon != '' ";break;
				case "배경색":			$WHERE .= " AND bgcolorDate >= NOW() ";break;
				case "페이지보조노출":	$WHERE .= " AND GuzicUryoDate1 >= NOW() ";break;
				case "통합검색노출":	$WHERE .= " AND GuzicUryoDate2 >= NOW() ";break;
			}

			$sql = "select count(*) from $per_document_tb where user_id ='$user_id' $WHERE ";

			$uryo_name = $PER_ARRAY_NAME[$i_array[$i]];
		}
		//print $sql."<br>";
		$result = query($sql);
		$uryo_cnt = mysql_fetch_row($result);

		$uryo_cnt_total = $uryo_cnt_total + $uryo_cnt[0];

		$uryo_total = number_format($uryo_cnt_total);
		if( $ii % 2 == 0 )
		{
			$uryo_list .= "</tr>
				<tr>";
		}

		if( $divi == 1 )
		{
			$uryo_list .="
				<td class=\"n1\">아이콘</td>
				<td class=\"n2\" style='border-bottom:1px dashed #dedede;'>
					<dl>
						<dt>$uryo_name
						<!-- <dd><label><a href='member_guin.php?type=all&uryo=$uryo_name'>$uryo_cnt[0]</label> 건 -->
						<dd><label>$uryo_cnt[0]</label> 건
					</dl>
				</td>
			";
			$view_chk = <<<END
				<label class="notify">등록된 정보 중에서 총 <a href="#total">$uryo_total</a> 건 이용하고 있습니다.</label>
					<div style="padding:5px;"></div>
					<table class="service_use_count">
					$uryo_list
					</table>
END;

		}
		else if( $divi == 2 )
		{
			if( $_COOKIE['happy_mobile'] == 'on' )
				{
				if( $ii % 2 == 1 )
					{
						$uryo_list .="

							<th>
								<div class='sth_area'>
									<table cellpadding='0' cellspacing='0' style='width:100%'>
										<tr>
											<th class='title'>
												<div class='ellipsis_line1' style='position:relative'>
													$uryo_name
													<span class='sub'>
														$uryo_cnt[0] 건
													</span>
												</div>
											</th>
										</tr>
									</table>
								</div>
							</th>
						";
					}
					else
					{
						$uryo_list .="
							<th class='' style=''>
								<div class='sth_area'>
									<table cellpadding='0' cellspacing='0' style='width:100%'>
										<tr>
											<th class='title'>
												<div class='ellipsis_line1' style='position:relative'>
													$uryo_name
													<span class='sub'>
														$uryo_cnt[0] 건
													</span>
												</div>
											</th>
										</tr>
									</table>
								</div>
							</th>
						";
					}
				}
				else
				{
					if( $ii % 2 == 1 )
					{
						$uryo_list .="

							<th class='title noto400 font_14' style='border:1px solid #c5c5c5'>$uryo_name</th>
							<td class='sub h_form font_16 noto400' style='border:1px solid #c5c5c5; padding:10px 20px; color:#333'>
								$uryo_cnt[0] 건
							</td>
						";
					}
					else
					{
						$uryo_list .="
							<th class='title noto400 font_14' style='border:1px solid #c5c5c5'>$uryo_name</th>
							<td class='sub h_form font_16 noto400' style='border:1px solid #c5c5c5; padding:10px 20px; color:#333'>
								$uryo_cnt[0] 건
							</td>
						";
					}
				}


			$view_chk = <<<END
					<tr>
					$uryo_list
					</tr>
END;

		}
		$ii++;
	}


	return $view_chk;
}



// for ralear
function nl2br_print( $arr, $field )
{
	global ${$arr};

	$global_arr		= ${$arr};
	$field_val		= $global_arr[$field];

	echo nl2br($field_val);
}



//게시판 추출명칭
//{{게시판제목 메인페이지_좌측상단,이미지(Size=50/OutFont=NanumPen/Format=PNG/Bgcolor=255.255.255/fcolor=63.63.63)}}
//{{게시판제목 메인페이지_좌측상단,텍스트}}
function board_name_out()
{
	$arg_title	= array('명칭','출력방식');
	$arg_names	= array('board_keyword','return_type');
	$arg_types	= array(
						'board_keyword'	=> 'char',
						'return_type'	=> 'char'
	);

	for( $i = 0, $max = func_num_args(); $i < $max; $i++ )
	{
		$value = func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int'	: $$arg_names[$i] = preg_replace('/\D/','',$value); break;
			case 'char'	: $$arg_names[$i] = preg_replace('/\n/','',$value); break;
			default		: $$arg_names[$i] = $value; break;
		}
		//echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}

	global $board_list;



	$Sql		= "SELECT board_name FROM $board_list WHERE board_keyword = '$board_keyword'";
	$Board_Conf	= happy_mysql_fetch_assoc(query($Sql));
	$Board_Conf['board_name'] = $Board_Conf['board_name'] == '' ? "게시판이 없습니다." : $Board_Conf['board_name'];

	if ( $return_type == '텍스트' )
	{
		echo $Board_Conf['board_name'];
	}
	else
	{
		$Board_Conf['board_name'] = urlencode($Board_Conf['board_name']);

		preg_match("/\\(.*\\)/", $return_type, $match);
		$Opt		= str_replace('(', '', $match[0]);
		$Opt		= str_replace(')', '', $Opt);

		$Opt_Ex		= explode('/',$Opt);

		$Temp		= explode('=', $Opt_Ex[0]);
		$Size		= $Temp[1] == '' ? '30' : $Temp[1];

		$Temp		= explode('=', $Opt_Ex[1]);
		$OutFont	= $Temp[1] == '' ? 'NanumPen' : $Temp[1];

		$Temp		= explode('=', $Opt_Ex[2]);
		$Format		= $Temp[1] == '' ? 'PNG' : $Temp[1];

		$Temp		= explode('=', $Opt_Ex[3]);
		$Temp[1]	= $Temp[1] == '' ? '255,255,255' : $Temp[1];
		$Bgcolor	= str_replace(".", ",", $Temp[1]);

		$Temp		= explode('=', $Opt_Ex[4]);
		$Temp[1]	= $Temp[1] == '' ? '63,63,63' : $Temp[1];
		$fColor		= str_replace(".", ",", $Temp[1]);

		//$Size = $OutFont = $Format = $Bgcolor = '';

		$image		= "<img src='happy_imgmaker.php?fsize=".$Size."&news_title=".$Board_Conf['board_name']."&outfont=".$OutFont."&fcolor=".$fColor."&format=".$Format."&bgcolor=".$Bgcolor."' />";

		echo $image;
	}
}

//for ralear
//{{게시판링크 Free_Board}}
$tbname_hash		= array();
function board_link($board_keyword)
{
	global $tbname_hash, $board_list, $DB_Prefix;

	if ( sizeof($tbname_hash) < 1 )
	{
		$sql			= "
							SELECT
									board_keyword,
									tbname
							FROM
									$board_list
		";
		$record			= query($sql);
		while ( $rows = happy_mysql_fetch_assoc($record) )
		{
			$tbname_hash[$rows['board_keyword']] = $rows['tbname'];
		}
	}

	if ( $DB_Prefix != '' )
	{
		$link			= substr($tbname_hash[$board_keyword], strlen($DB_Prefix));
	}
	else
	{
		$link			= $tbname_hash[$board_keyword];
	}

	if ( $link == '' )
	{
		echo "javascript:alert('$board_keyword 명칭을 가진 게시판이 없습니다.');";
	}
	else
	{
		echo "bbs_list.php?tb=".$link;
	}
}



/*
//쪽지신고하기 DB작업
alter table happy_message add report_get varchar(255) not null default '';
alter table happy_message add key report_get(`report_get`);
alter table happy_message add report_post text not null default '';
*/
//{{신고버튼 img/detail_report.gif}}
function report_button($img_url)
{
	$Post_String	= Array();
	foreach ( $_POST as $Key => $Val )
	{
		$Val			= strip_tags($Val);
		array_push($Post_String, $Key.'='.$Val);
	}

	$img_url		= $img_url == '' ? 'img/detail_report.gif' : $img_url;

	$Post_String	= sizeof($Post_String) > 0 ? implode("_CUT_", $Post_String) : '';
	$Post_String	= urlencode($Post_String);

	$Report_Btn		= "<img src='$img_url' alt='쪽지신고하기' title='쪽지신고하기' align='absmiddle' onclick=\"window.open('happy_report.php?report_post=$Post_String','happy_report','width=420,height=460');\" style='cursor:pointer; vertical-align:middle'/>";

	echo $Report_Btn;
}

// 도로명주소레이어
function road_layer()
{
	$html	= "
<script type=\"text/javascript\">
function goRoadSelected(si,gu,doro,geonmul,juso)
{
	var road_si_no			= parseInt(document.getElementsByName('road_si').length - 1);
	var road_si				= document.getElementsByName('road_si')[road_si_no];
	var road_gu				= document.getElementsByName('road_gu')[0];
	var road_addr			= document.getElementsByName('road_addr')[0];
	var road_addr2			= document.getElementById('road_addr2');
	var road_address_layer	= document.getElementById('road_address_layer');

	var road_value		= '';

	if(road_address_layer != undefined)
	{
		if(road_si != undefined)
		{
			road_si.value	= si;
			road_si_value	= road_si.options[road_si.selectedIndex].value;
		}

		road_addr.value		= doro;

		// 세종시
		if(road_si_value == 29)
		{
			// 건물명이 있을때
			if(geonmul != '')
			{
				road_addr2.value	= geonmul + ' ' + juso;
			}
			else
			{
				road_addr2.value	= juso;
			}
		}
		else
		{
			road_gu.value			= gu;
			// 건물명이 있을때
			if(geonmul != '')
			{
				road_addr2.value	= geonmul + ' ' + juso;
			}
			else
			{
				road_addr2.value	= juso;
			}
		}
		document.getElementById('road_address_layer').style.display= 'none';
	}
}

function goJuso()
{
	var user_addr1	= document.getElementsByName('user_addr1')[0];
	var user_addr2	= document.getElementsByName('user_addr2')[0];
	var url			= 'http://www.juso.go.kr';
	var url_sub		= '/support/AddressMainSearch.do?searchType=TOTAL&searchKeyword=';	// 이 주소는 변경 될수도 있음

	if(user_addr1 != undefined && user_addr2 != undefined)
	{
		window.open(url + url_sub + encodeURI(user_addr1.value),'_blank');
	}
	else
	{
		window.open(url,'_blank');
	}
}
</script>
<div id=\"road_address_layer\" style=\"display:none; padding:5px 0 5px 0;\">
	<div id=\"road_address_select\" style=\"overflow-y:scroll; width:380px; padding:5px 0 5px 5px; height:150px; border:1px solid #E8E8E8; margin-bottom:5px;\"></div>
	정확한 도로명주소는 행정안전부 새주소안내시스템<br />
	(<a href=\"javascript:void(0);\" target=\"_top\" onclick=\"goJuso();\">http://www.juso.go.kr</a>) 에서 확인하시기 바랍니다.
</div>
	";

	return $html;
}






//{{카카오톡링크 /img/sns_icon/icon_kakao.gif,300,200}}
function kakaotalk_link($img_src,$img_w,$img_h)
{
	global $HAPPY_CONFIG;
	global $main_url,$title_img,$site_name;
	global $Data,$demo_lock;

	$kakao_app_key = $HAPPY_CONFIG['kakao_app_key'];

	//버튼이미지
	$btn_src = $img_src;

	//사이트 도메인
	$url = $main_url;
	if ( $_SERVER['REQUEST_URI'] != "" )
	{
		$url.= $_SERVER['REQUEST_URI'];
	}

	//링크전송시 이미지
	$src = "http://dn.api1.kage.kakao.co.kr/14/dn/btqaWmFftyx/tBbQPH764Maw2R6IBhXd6K/o.jpg";
	if ( $title_img[0] != "" )
	{
		$src_thumb = happy_image("title_img.0","600","400","로고사용안함","로고위치7번","100","gif원본출력",$HAPPY_CONFIG['ImgNoImage1'],"비율대로확대","2");
		$src = $main_url."/".$src_thumb;
	}

	//라벨
	$label = $site_name;
	if ( $Data['title'] != "" )
	{
		$label = $Data['title'];
	}

	$text = "웹사이트로 이동";


	$btn = "";

	if($demo_lock == 1)
	{
		$btn = '<a id="kakao-link-btn" href="javascript:alert(\'데모 모드에서는 사용할 수 없습니다.\');"><img src="'.$btn_src.'" alt="카카오톡" title="카카오톡" style="cursor:pointer; width:'.$img_w.'px; height:'.$img_h.'px;" align="absmiddle"/></a>';
	}
	else
	{
		// ver2.0 으로 교체됨
		$btn = '<a id="kakao-link-btn" href="javascript:;"><img src="'.$btn_src.'" alt="카카오톡" title="카카오톡" style="cursor:pointer; width:'.$img_w.'px; height:'.$img_h.'px;" align="absmiddle"/></a>
		<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
		<script>
		// 사용할 앱의 Javascript 키를 설정해 주세요.
		Kakao.init(\''.$kakao_app_key.'\');

		// 카카오톡 링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
		Kakao.Link.createDefaultButton({
		  container: \'#kakao-link-btn\',
		  objectType: \'feed\',
		  content: {
			title: \''.$label.'\',
			description: \''.$text.'\',
			imageUrl: \''.$src.'\',
			link: {
			  mobileWebUrl: \''.$url.'\',
			  webUrl: \''.$url.'\'
			}
		  }

		});

		</script>
		';
	}

	return $btn;
}


//뉴스상점 START
//공유한 뉴스를 수정하거나 삭제시 뉴스상점에 데이터 전송
function news_store_data_put($Data,$mode)
{
	//print_r($Data);
	global $news_store_url;
	global $news_store_login;

	//뉴스상점 뉴스데이터 수신 url
	$url = $news_store_url."/store_news_data_put.php";

	//뉴스상점 로그인정보
	$sql = "select * from $news_store_login";
	$result = query($sql);
	$StoreInfo = happy_mysql_fetch_assoc($result);
	//print_r($StoreInfo);


	$debug = 1;
	$dataStr = '&store_id='.$StoreInfo['id'];
	$dataStr.= '&store_pass='.$StoreInfo['pass'];
	$dataStr.= '&site_url='."http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	foreach($Data as $k => $v)
	{
		//뉴스상점으로는 항상 u-tf8 로 넘겨줘야 한다.
		$dataStr.= '&'.$k.'='.urlencode(iconv("euc-kr","utf-8",$v));
	}
	$dataStr.= '&debug='.$debug;
	$dataStr.= '&store_mode='.$mode;

	$Tmp = @parse_url($url);
	$host = $Tmp['host'];
	$path = $Tmp['path'];
	$port = "80";

	$fp = @fsockopen($host,$port,$errno,$errstr,30);

	if(!$fp)
	{
		//echo "$errstr ($errno)<br />\n";
	}
	else if($fp)
	{
		//HTTP/1.1 쓰면 왠지 모르게 느리다.
		$header = "POST ".$path." HTTP/1.0\r\n";
		$header .= "Host: ".$host."\r\n";
		$header .= "User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n";
		$header .= "Content-type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-length: ".strlen($dataStr)."\r\n\r\n";
		$header .= $dataStr."\r\n";

		fputs ($fp, $header);

		$xml = '';
		while ( !feof($fp) )
		{
			$isSuccess =  fgets($fp,1024);
			$xml.= $isSuccess;

		}
		//echo $isSuccess;
		// closed socket
		fclose($fp);

		//echo $xml;
		list($head,$body) = explode("\r\n\r\n",$xml,2);
		//echo $body;

		return $body;
	}
}

//공유받은 뉴스를 수정하거나, 삭제시 뉴스상점에 데이터 전송
function news_store_data_put2($Data,$mode)
{
	//print_r($Data);
	global $news_store_url;
	global $news_store_login;

	//뉴스상점 뉴스데이터 수신 url
	$url = $news_store_url."/store_news_data_put2.php";

	//뉴스상점 로그인정보
	$sql = "select * from $news_store_login";
	$result = query($sql);
	$StoreInfo = happy_mysql_fetch_assoc($result);
	//print_r($StoreInfo);


	$debug = 1;
	$dataStr = '&store_id='.$StoreInfo['id'];
	$dataStr.= '&store_pass='.$StoreInfo['pass'];
	$dataStr.= '&site_url='."http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	foreach($Data as $k => $v)
	{
		//뉴스상점으로는 항상 u-tf8 로 넘겨줘야 한다.
		$dataStr.= '&'.$k.'='.urlencode(iconv("euc-kr","utf-8",$v));
	}
	$dataStr.= '&debug='.$debug;
	$dataStr.= '&store_mode='.$mode;

	$Tmp = @parse_url($url);
	$host = $Tmp['host'];
	$path = $Tmp['path'];
	$port = "80";

	$fp = @fsockopen($host,$port,$errno,$errstr,30);

	if(!$fp)
	{
		//echo "$errstr ($errno)<br />\n";
	}
	else if($fp)
	{
		//HTTP/1.1 쓰면 왠지 모르게 느리다.
		$header = "POST ".$path." HTTP/1.0\r\n";
		$header .= "Host: ".$host."\r\n";
		$header .= "User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n";
		$header .= "Content-type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-length: ".strlen($dataStr)."\r\n\r\n";
		$header .= $dataStr."\r\n";

		fputs ($fp, $header);

		$xml = '';
		while ( !feof($fp) )
		{
			$isSuccess =  fgets($fp,1024);
			$xml.= $isSuccess;

		}
		//echo $isSuccess;
		// closed socket
		fclose($fp);

		//echo $xml;
		list($head,$body) = explode("\r\n\r\n",$xml,2);
		//echo $body;

		return $body;
	}
}

function news_store_cnt($type)
{
	global $news_store_url;
	//뉴스상점 뉴스카운터 수신 url
	$url = $news_store_url."/store_news_cnt.php";
	//echo $url;

	$debug = 1;
	$dataStr = '&ntype='.$type;

	$Tmp = @parse_url($url);
	$host = $Tmp['host'];
	$path = $Tmp['path'];
	$port = "80";

	$fp = @fsockopen($host,$port,$errno,$errstr,30);

	if(!$fp)
	{
		//echo "$errstr ($errno)<br />\n";
	}
	else if($fp)
	{
		//HTTP/1.1 쓰면 왠지 모르게 느리다.
		$header = "POST ".$path." HTTP/1.0\r\n";
		$header .= "Host: ".$host."\r\n";
		$header .= "User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n";
		$header .= "Content-type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-length: ".strlen($dataStr)."\r\n\r\n";
		$header .= $dataStr."\r\n";

		fputs ($fp, $header);

		$xml = '';
		while ( !feof($fp) )
		{
			$isSuccess =  fgets($fp,1024);
			$xml.= $isSuccess;

		}
		//echo $isSuccess;
		// closed socket
		fclose($fp);

		//echo $xml;
		list($head,$body) = explode("\r\n\r\n",$xml,2);
		//echo $body;

		return $body;
	}

}
//뉴스상점 END

####################################################
##																								##
##						문의하기 기능관련 함수 START - hong 추가								##
##																								##
####################################################

# {{문의하기폼 한식,입력,inquiry_form_rows.html,inquiry_form_default.html}}
function happy_inquiry_form( $category, $print_type='', $rows_html='', $default_html='', $inquiry_num='')
{
	global $happy_inquiry, $happy_inquiry_form, $happy_inquiry_links, $HAPPY_CONFIG;
	global $TPL, $skin_folder, $main_url, $inquiry_image_upload_folder;
	global $select_category_road,$select_company_road,$select_type_road, $upso2_si, $upso2_si_gu;
	global $필드타이틀, $필드아이디, $출력형식, $현재폼, $폼내용;
	global $필수체크이미지;

	$happy_member_login_id = happy_member_login_check();

	if ( $happy_member_login_id != "" )
	{
		$MEMBER			= happy_member_information($happy_member_login_id);
	}

	$links_number	= $_GET['links_number'];

	if ( $print_type == "메일발송" )
	{
		$category_org = $category;
	}

	if ( $print_type == "정보보기" && $_GET['number'] != "" && $links_number == "" )
	{
		$Sql			= "SELECT links_number FROM $happy_inquiry WHERE number = '$_GET[number]' ";
		$Result			= query($Sql);
		$TmpData		= happy_mysql_fetch_array($Result);

		$links_number	= $TmpData['links_number'];
	}

	if ( $HAPPY_CONFIG['inquiry_form_each_conf'] == "n" )
	{
		$category		= "초기화";
	}

	if ( $category == "자동" && $links_number != "" )
	{
		$Sql			= "SELECT type1 FROM $happy_inquiry_links WHERE number = '$links_number' ";
		$Result			= query($Sql);
		list($category)	= happy_mysql_fetch_array($Result);
	}
	else if ( $category != "" && $category != "자동" )
	{
		$category		= $category;
	}
	else
	{
		$category		= "초기화";
	}

	if ( $print_type == "메일발송" )
	{
		if ( $HAPPY_CONFIG['inquiry_form_each_conf'] == "y" )
		{
			$category = $category_org;
		}
	}

	if ( $category != "" )
	{
		$Sql			= "SELECT COUNT(*) FROM $happy_inquiry_form WHERE gubun ='$category'";
		$Result			= query($Sql);
		list($ChkCnt)	= happy_mysql_fetch_array($Result);

		if ( $ChkCnt == 0 )
		{
			$category		= "초기화";
		}
	}
	else
	{
		$category		= "초기화";
	}

	if ( $inquiry_num == "자동" )
	{
		$inquiry_num	= $_GET['number'];
	}

	if ( $inquiry_num != "" )
	{
		$inquiry_num	= preg_replace("/\D/","",$inquiry_num);

		$Sql			= "SELECT * FROM $happy_inquiry WHERE number = '$inquiry_num' ";
		$Result			= query($Sql);
		$Data			= happy_mysql_fetch_array($Result);
		#print_r2($Data);
	}

	$view_mode		= "";
	$return			= "";
	$MailSrc		= "";

	if ( preg_match("/admin/",$_SERVER['SCRIPT_NAME']) )
	{
		$skin_folder			= "html";
		$MailSrc				= "../";
	}

	switch ( $print_type )
	{
		case '메일발송' :
		{
			$view_mode		= "on";
			$return			= "1";
			$MailSrc		= $main_url."/";
			break;
		}
		case '정보보기' :
		{
			$view_mode		= "on";
			break;
		}
		default :
		{
			$아이콘1		= "<img src='img/form_icon1.gif' align='absmiddle'>";
			$아이콘2		= "<img src='img/form_icon2.gif' align='absmiddle'>";
			$아이콘3		= "<img src='img/form_icon3.gif' align='absmiddle'>";
			break;
		}
	}

	#폼정보 변수에 담아두기
	$Sql			= "SELECT * FROM $happy_inquiry_form WHERE gubun = '$category' ";
	//echo $Sql;
	$Record			= query($Sql);

	$SureInput		= "";
	$Cnt			= 0;
	while ( $Form = happy_mysql_fetch_array($Record) )
	{
		$fieldName		= $Form['field_name'];
		$fieldTitle		= $Form['field_title'];
		$fieldType		= $Form['field_type'];
		$fieldOptions	= $Form['field_option'];
		$fieldStyle		= $Form['field_style'];
		$fieldTemplate	= $Form['field_template'];
		$fieldSureInput	= $Form['field_sureInput'];
		$fieldUse		= $Form['field_use'];
		$value			= "";

		$readonly		= "";
		//$sureInput		= $fieldSureInput == 'y' ? " hname='". str_replace(" ","",$fieldTitle)."' required " : "";
		$sureInput		= $fieldSureInput == 'y' ? " hname='". str_replace(" ","",$fieldTitle)."' " : "";

		if ( $view_mode == 'on' )
		{
			$fieldType	= ( $fieldType == 'file' )? 'view_file' : 'view' ;
			$value		= $Data[$fieldName];
		}

		#폼박스 설정
		if ( $fieldType == 'text' )
		{
			if ( $happy_member_login_id != "" )
			{
				switch ( $fieldName )
				{
					case 'user_name'	: $value = $MEMBER['user_name'];	$readonly = "readonly";	break;
					case 'user_phone'	: $value = $MEMBER['user_phone'];	$readonly = "readonly";	break;
					case 'user_hphone'	: $value = $MEMBER['user_hphone'];	break;
					case 'user_email'	: $value = $MEMBER['user_email'];	break;
					default				: $value = $value;					break;
				}
			}

			$form	= "<span class='h_form'><input type='text' name='$fieldName' value='$value' $fieldStyle $sureInput $readonly></span>";
		}
		else if ( $fieldType=='text_num' )
		{
			$form	= "<span class='h_form'><input type='text' name='$fieldName' value='' $fieldStyle $sureInput  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.preventDefault ? event.preventDefault() : event.returnValue=false;'></span>";
		}
		else if ( $fieldType == 'password' )
		{
			$form	= "<span class='h_form'><input type='password' name='$fieldName' value='' $fieldStyle $sureInput></span>";
		}
		else if ( $fieldType == 'file' )
		{
			$form	= "<span class='h_form'><input type='file' style='margin-top:5px;' name='$fieldName' $fieldStyle ></span>";
		}
		else if ( $fieldType == 'textarea' )
		{
			$form	= "<span class='h_form'><textarea name='$fieldName' $fieldStyle $sureInput>$value</textarea></span>";
		}
		else
		{
			$fieldOptions= explode(",",$fieldOptions);

			if ( $fieldType == 'checkbox' )
			{
				$array_co	= count($fieldOptions);
				$form		= "";

				for ( $i=0, $j=0; $i<$array_co; $i++ )
				{
					$fieldOptions[$i]		= explode(":",$fieldOptions[$i]);
					$fieldOptions[$i][1]	= $fieldOptions[$i][1] == '' ? $fieldOptions[$i][0] : $fieldOptions[$i][1];

					//크롬에서 check를 다해야되는 상황을 처리
					if($i > 0)
					{
						$sureInput = "";
					}
					//크롬에서 check를 다해야되는 상황을 처리 END

					$form .= "<span class='h_form'><label class='h-check' for='${fieldName}_$i'><input type=checkbox id='${fieldName}_$i'  name='${fieldName}[]' value='".$fieldOptions[$i][1]."' $fieldStyle  $sureInput class='cfg_input_chk'><span class='noto400 font_13'>".$fieldOptions[$i][0]."</span></label></span> &nbsp;";
				}
			}
			else if ( $fieldType == 'radio' )
			{
				$array_co	= count($fieldOptions);
				$form		= "";

				for ( $i=0; $i<$array_co; $i++ )
				{
					$fieldOptions[$i]		= explode(":",$fieldOptions[$i]);
					$fieldOptions[$i][1]	= $fieldOptions[$i][1] == '' ? $fieldOptions[$i][0] : $fieldOptions[$i][1];

					$form .= "<span class='h_form'><label class='h-radio' for='${fieldName}_$i'><input type=radio id=${fieldName}_$i  name='${fieldName}' value='".$fieldOptions[$i][1]."' $fieldStyle  $sureInput class='cfg_input_chk'><span class='noto400 font_13'>".$fieldOptions[$i][0]."</span></label></span> &nbsp;";
				}
			}
			else if ( $fieldType == 'select' )
			{
				$array_co	= count($fieldOptions);
				$form		= "<span class='h_form'><select name=$fieldName $sureInput $fieldStyle >";
				$form		.= "<option value=''>--- 선택 ---</option>";

				for ( $i=0; $i<$array_co; $i++ )
				{
					$fieldOptions[$i]		= explode(":",$fieldOptions[$i]);
					$fieldOptions[$i][1]	= $fieldOptions[$i][1] == '' ? $fieldOptions[$i][0] : $fieldOptions[$i][1];

					$form	.= "<option value='".$fieldOptions[$i][1]."'>".$fieldOptions[$i][0]."</option>";
				}
				$form		.= "</select></span>";
			}
			else if ( $fieldType == 'view' )	// 상세보기 페이지 => $tplTD 그냥 출력
			{
				if ( is_array($fieldOptions) )
				{
					for ( $x=0 , $m=sizeof($fieldOptions) ; $x<$m ; $x++ )
					{
						list( $FieldText, $FieldValue )	= explode(':', $fieldOptions[$x]);

						if ( $FieldValue == $value && $value != "" )
						{
							$value	= $FieldText;
							break;
						}
					}
				}
				$form	= nl2br($value);
			}
			else if ( $fieldType == 'view_file' )	// 상세보기 페이지 => $tplTD 그냥 출력
			{
				if (preg_match("/\.jp/", $value) || preg_match("/\.gif/", $value) || preg_match("/\.png/", $value) || preg_match("/\.bmp/", $value) )
				{
					if ( is_file($MailSrc.$value) )
					{
						$wonbonLinkStart	= "";
						$wonbonLinkEnd		= "";
						$wonbonLinkAlt		= "";
						$wonbonValue		= $value;

						list($thumbFileName,$thumbFileExt) = explode(".",$value);
						$thumbFileValue = $thumbFileName."_thumb.".$thumbFileExt;

						if ( is_file($MailSrc.$thumbFileValue) )
						{
							$value = $thumbFileValue;

							$wonbonLinkStart	= "<a href='${MailSrc}$wonbonValue' target='_blank'>";
							$wonbonLinkEnd		= "</a>";
							$wonbonLinkAlt		= " alt='클릭시 원본이미지 확인이 가능합니다.' ";
						}
					}

					$form	= "$wonbonLinkStart<img src='${MailSrc}$value' border='0' class='img_preview'  onError=this.src='${MailSrc}img/noimage_del.jpg' $wonbonLinkAlt>$wonbonLinkEnd";
				}
				else if ( $value != '' )
				{
					$form	= "<a href='${MailSrc}$value' target='_blank'>첨부파일</a>";
				}
				else
				{
					$form	= $value;
				}
			}
		}

		//폼 깨짐 방지
		if ( $form == "" ){ $form .= "&nbsp;"; }

		$FormPatterns[$Cnt]		= "/%${fieldName}%/";
		$FormReplaces[$Cnt++]	= $form;
		$Forms[$fieldName]		= $form;

		//echo $fieldTitle ." : $form <br>";
	}

	#폼정보 담기 종료
	if ( $return != "1" )
	{
		$random	= rand()%1000;
		$TPL->define("문의하기폼_$random", "$skin_folder/$rows_html");
	}

	//도로명 때문에 추가됨.
	$form_name	= 'inquiry_form';

	#폼정보 출력 변수 정리
	$Sql	= "SELECT * FROM $happy_inquiry_form WHERE gubun = '$category'  AND field_use='y' ORDER BY field_sort ASC";
	$Record	= query($Sql);

	$FormCnt= mysql_num_rows($Record);
	$NowCnt	= 0;

	$category_base64    = str_replace("+","_p_",base64_encode($category));

	while ( $Form = happy_mysql_fetch_array($Record) )
	{
		$fieldName		= $Form['field_name'];
		$fieldTitle		= $Form['field_title'];
		$fieldType		= $Form['field_type'];
		$fieldOptions	= $Form['field_option'];
		$fieldStyle		= $Form['field_style'];
		$fieldTemplate	= $Form['field_template'];
		$fieldTemplate	= $fieldTemplate == '' ? '%폼%' : $fieldTemplate;

		if ( $view_mode == 'on' )
		{
			$fieldTemplate	= str_replace('<br>', '', $fieldTemplate);
			#$fieldTemplate	= '%폼%';
		}
		else
		{
			$달력 = "<span class='h_form'><a href='javascript:void(0)' uk-icon='icon:calendar; ratio:1' class='h_btn_square uk-icon' onclick='if(self.gfPop)gfPop.fPopCalendar(document.$form_name.$fieldName);return false;' ></a></span>";
		}

		if( $fieldName == "road_si" && $view_mode == '' )
		{
			happy_make_road_si_selectbox('road_si','road_gu','road_addr',"","","",'90','90','90',$form_name,$category_base64);
			$도로명지역선택		= "<span class='h_form'>$select_category_road[$form_name]&nbsp;$select_company_road[$form_name]$select_type_road[$form_name]</span>";
			//$도로명상세주소		= "<span id=\"road_addr2\"><input type=\"text\" name=\"road_addr2\" id=\"road_addr2\" value=\"\" style='width:110px;'/></span><input type=\"hidden\" name=\"site_url\" id=\"site_url\" value=\"$_SERVER[SERVER_NAME]\" />";
			/*
				도로명주소레이어
				<span id=\"road_addr2\"> 제거 </span> 제거
			*/
			$도로명상세주소		= "<span class='h_form'><input type=\"text\" name=\"road_addr2\" id=\"road_addr2\" value=\"\" style='width:110px;'/><input type=\"hidden\" name=\"site_url\" id=\"site_url\" value=\"$_SERVER[SERVER_NAME]\" /></span>";
			$지역갱신버튼		= "<a href=\"javascript:#\" onclick=\"Road_happy_member_address('$form_name'); return false;\"><img src='img/btn_change_happy_zip.gif' style='vertical-align:middle;' border=0 alt='주소로변환' title='주소로변환'></a>";
		}
		else if( $fieldName == "user_zip" && $view_mode == '' )
		{
			/*
				도로명주소레이어
				도로명갱신버튼 뒤에 $도로명주소레이어 추가
			*/
			$도로명주소레이어 = road_layer();

			$도로명갱신버튼		= "<a href=\"javascript:#\" onclick=\"Road_address('$form_name'); return false;\"><img src='img/btn_change_load_zip.gif' style='vertical-align:middle;' alt='도로명으로변환' title='도로명으로변환'  border=0></a>" . $도로명주소레이어;
		}

		$form			= str_replace("%폼%",$Forms[$fieldName],$fieldTemplate);
		$form			= str_replace("%달력%",$달력,$form);
		$form			= str_replace("%아이콘1%",$아이콘1,$form);
		$form			= str_replace("%아이콘2%",$아이콘2,$form);
		$form			= str_replace("%아이콘3%",$아이콘3,$form);
		$form			= str_replace("%도로명주소로변경%",$도로명갱신버튼,$form);
		$form			= str_replace("%도로명지역선택%",$도로명지역선택,$form);
		$form			= str_replace("%도로명상세주소%",$도로명상세주소,$form);
		$form			= str_replace("%지역갱신버튼%",$지역갱신버튼,$form);

		$postPattern	= "/%우편번호찾기-(.*)-(.*)-(.*)-우편번호찾기%/e";
		$postReplace	= "happy_member_post_finder('$1','$2','$3', '$view_mode');";
		$form			= preg_replace($postPattern, $postReplace, $form);
		$form			= preg_replace($FormPatterns, $FormReplaces, $form);

		if ( $view_mode == "on" && $fieldName == "road_si" )
		{
			$sql				= "SELECT si FROM $upso2_si WHERE number = '$Forms[road_si]'";
			list($si)			= happy_mysql_fetch_array(query($sql));

			$sql				= "SELECT gu FROM $upso2_si_gu WHERE number = '$Forms[road_gu]'";
			list($gu)			= happy_mysql_fetch_array(query($sql));

			$form			= $si." ".$gu." ".$Forms['road_addr']." ".$Forms['road_addr2'];
		}

		$필수체크이미지 = "";
		if ( $Form['field_sureInput'] == "y" || $Form['field_name'] == "user_id" )
		{
			if ( $_COOKIE['happy_mobile'] == 'on' )
			{
				$필수체크이미지	= "<img src='img/form_icon2.gif' alt='필수아이콘' title='필수아이콘' '>";
			}
			else
			{
				$필수체크이미지	= $아이콘1;
			}
		}

		$필드타이틀		= $fieldTitle;
		$필드아이디		= $fieldName;
		$출력형식		= $form;
		$현재폼			= $Forms[$fieldName];


		if ( $return != "1" )
		{
			$content	.= $TPL->fetch("문의하기폼_$random");
			#echo $fieldTitle ." : $form <br>";
		}
		else
		{
			$contentTmp	= str_replace("{{main_url}}",$main_url,$HAPPY_CONFIG['inquiry_mail_tpl_main_td']);
			$contentTmp	= str_replace("%필드이름%",$필드타이틀,$contentTmp);
			$contentTmp	= str_replace("%폼출력%",$출력형식,$contentTmp);

			$contentTD	.= $contentTmp;

			$NowCnt++;
			if ( $NowCnt < $FormCnt )
			{
				$contentTD	.= $HAPPY_CONFIG['inquiry_mail_tpl_main_tr'];
			}
		}
	}
	$폼내용	= "<input type='hidden' name='referer' value='$_SERVER[HTTP_REFERER]'>";
	$폼내용	.= $content;
	#폼정보 출력 변수 정리 끝

	if ( $return != "1" )
	{
		$TPL->define("문의하기폼껍데기_$random", "$skin_folder/$default_html");
		$content	= $TPL->fetch("문의하기폼껍데기_$random");

		return print $content;
	}
	else
	{
		$content	= str_replace("%내용%",$contentTD,$HAPPY_CONFIG['inquiry_mail_tpl_main']);
		return $content;
	}
}

$happy_inquiry_table_field	= "";
function call_inquiry_form_field( $fieldName='' )
{
	global $happy_inquiry, $happy_inquiry_table_field;

	if ( $fieldName == '' )
	{
		return false;
	}

	if ( $happy_inquiry_table_field == '' )
	{
		$happy_inquiry_table_field	= array();

		$Sql	= "DESC $happy_inquiry";
		$Rec	= query($Sql);

		while ( $tmp = happy_mysql_fetch_array($Rec) )
		{
			#print_r($tmp);
			#echo "<br>";

			if ( $tmp['Field'] != '' )
			{
				$happy_inquiry_table_field[$tmp['Field']]['Field']		= $tmp['Field'];
				$happy_inquiry_table_field[$tmp['Field']]['Type']		= $tmp['Type'];
				$happy_inquiry_table_field[$tmp['Field']]['Null']		= $tmp['Null'];
				$happy_inquiry_table_field[$tmp['Field']]['Key']		= $tmp['Key'];
				$happy_inquiry_table_field[$tmp['Field']]['Default']	= $tmp['Default'];
				$happy_inquiry_table_field[$tmp['Field']]['Extra']		= $tmp['Extra'];
			}
		}
	}

	return $happy_inquiry_table_field[$fieldName];
}

#메일발송 함수
function happy_inquiry_mail_send($idx)
{
	global $happy_inquiry, $happy_inquiry_form, $happy_inquiry_links;
	global $server_character, $HAPPY_CONFIG, $wys_url, $main_url;
	global $happy_member;

	$Sql				= "SELECT * FROM $happy_inquiry WHERE number = '$idx' ";
	$Result				= query($Sql);
	$MailData			= happy_mysql_fetch_array($Result);


	$Sql				= "SELECT * FROM $happy_inquiry_links WHERE number = '$MailData[links_number]' ";
	$Result				= query($Sql);
	$Data				= happy_mysql_fetch_array($Result);




	$inquiry_contents	= happy_inquiry_form($Data['type1'],"메일발송","","",$MailData['number']);

	//echo $inquiry_contents;exit;

	$title				= $HAPPY_CONFIG['inquiry_mail_title'];
	$title				= str_replace("%회사명%",$Data['guin_com_name'],$title);

	$contents			= $HAPPY_CONFIG['inquiry_mail_contents'];
	$contents			= str_replace("%회사명%",$Data['guin_com_name'],$contents);
	$contents			= str_replace("%담당자%",$Data['guin_name'],$contents);
	$contents			= str_replace("%이메일%",$Data['guin_email'],$contents);
	$contents			= str_replace("%연락처%",$Data['guin_phone'],$contents);
	$contents			= str_replace("%입력내용%",$inquiry_contents,$contents);
	$contents			= str_replace("$wys_url$wys_url",$wys_url,$contents);
	$contents			= str_replace("{{main_url}}",$main_url,$contents);

	//$Data["guin_email"] = "";
	//echo "MailData['user_name'] => ".$MailData['user_name']."<br>";
	//echo "MailData['user_email'] => ".$MailData['user_email']."<br>";
	//echo "Data['guin_email'] => ".$Data["guin_email"]."<br>";
	//echo "title => ".$title."<br>";
	//echo $contents;
	//exit;

	//메일 함수 통합 - hong
	HappyMail($MailData['user_name'], $MailData['user_email'],$Data["guin_email"],$title,$contents);


}

# 문의등록시 SMS발송 컨버팅 (받는번호,업체명,담당자,접수자명)
function happy_inquiry_sms_convert($receive_phone,$title,$sender,$receiver)
{
	global $site_name, $site_phone, $HAPPY_CONFIG;

	$message		= $HAPPY_CONFIG['inquiry_sms_message'];
	$message		= str_replace("%사이트이름%",$site_name,$message);
	$message		= str_replace("%회사명%",$title,$message);
	$message		= str_replace("%문의자이름%",$receiver,$message);
	$message		= str_replace("%담당자%",$sender,$message);

	$message		= addslashes($message);

	$sms_date			= date("HiYmd");

	$sms_str3			= $HAPPY_CONFIG['sms_userid'].$sms_date.$HAPPY_CONFIG['sms_userpass'];
	$sms_str_md5		= md5($sms_str3);

	$sms_str			= "";
	$sms_str			.= "&phone=".$receive_phone;
	$sms_str			.= "&userid=".$HAPPY_CONFIG['sms_userid'];
	$sms_str			.= "&userpass=".$HAPPY_CONFIG['sms_userpass'];
	$sms_str			.= "&type=1";
	$sms_str			.= "&returnUrl=";	//리턴url 받아서 이동하지 않음
	$sms_str			.= "&message=".urlencode($message);
	$sms_str			.= "&callback=".$site_phone;
	$sms_str			.= "&testing=".$HAPPY_CONFIG['sms_testing'];
	$sms_str			.= "&loginType=password";
	$sms_str			.= "&loginPass=".$sms_str_md5;
	$sms_str			.= "&secure=";

	if ( $HAPPY_CONFIG['inquiry_sms_use_conf'] == 'kakao' )
	{
		$sms_str			.= "&is_kakao=y";
		$sms_str			.= "&kakao_template_code=".$HAPPY_CONFIG['inquiry_sms_message_ktplcode'];
	}

	return $sms_str;
}

#{{문의내역출력 페이지당15개,받은내역,rows_happy_inquiry_upche.html}}
function happy_inquiry_list()
{
	$arg_title	= array('페이지당출력수','출력타입','정렬','템플릿');
	$arg_names	= array('ex_limit','type','orderby','template');
	$arg_types	= array(
						'ex_limit'		=> 'int',
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
		#echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}

	global $TPL, $skin_folder, $happy_inquiry, $happy_inquiry_links;
	global $Data, $문의내역페이징, $happy_inquiry_stats_array;
	global $happy_inquiry_comment;

	$happy_member_login_id	= happy_member_login_check();

	if ( $happy_member_login_id == "" )
	{
		return;
	}

	if ( !is_file("$skin_folder/$template") )
	{
		return print "$skin_folder/$template 파일이 존재하지 않습니다.";
	}

	$WHERE				= "";
	$WHERE2				= "";

	switch ( $type )
	{
		case '받은내역' :
		{
			$WHERE				= " AND receive_id = '$happy_member_login_id' ";
			$WHERE2				= " AND A.receive_id = '$happy_member_login_id' ";
			break;
		}
		case '보낸내역' :
		{
			$WHERE				= " AND send_id = '$happy_member_login_id' ";
			$WHERE2				= " AND A.send_id = '$happy_member_login_id' ";
			break;
		}
	}

	//검색조건 정리
	if ( $_GET['links_number'] != "" )
	{
		$WHERE				.= " AND links_number = '$_GET[links_number]' ";
		$WHERE2				.= " AND A.links_number = '$_GET[links_number]' ";
	}

	if ( $_GET['stats'] != "" )
	{
		$WHERE				.= " AND stats = '$_GET[stats]' ";
		$WHERE2				.= " AND A.stats = '$_GET[stats]' ";
	}

	if ( $_GET['search_keyword'] != "" )
	{
		$search_keyword		= $_GET['search_keyword'];
		$search_keyword2	= str_replace('-','',$_GET['search_keyword']);

		$WHERE				.= " AND ( user_name like '%$search_keyword%' ";
		$WHERE				.= " OR user_phone like '%$search_keyword%' OR user_phone like '%$search_keyword2%' ";
		$WHERE				.= " OR user_hphone like '%$search_keyword%' OR user_hphone like '%$search_keyword2%' ) ";

		$WHERE2				.= " AND ( A.user_name like '%$search_keyword%' ";
		$WHERE2				.= " OR A.user_phone like '%$search_keyword%' OR A.user_phone like '%$search_keyword2%' ";
		$WHERE2				.= " OR A.user_hphone like '%$search_keyword%' OR A.user_hphone like '%$search_keyword2%' ) ";
	}

	switch ( $orderby )
	{
		case '최근등록순' :		$ORDER = " A.number desc ";	break;
		case '최근등록역순' :	$ORDER = " A.number asc ";	break;
		case '접수상태순' :		$ORDER = " A.stats asc ";	break;
		default :				$ORDER = " A.number desc ";	break;
	}

	$Sql				= "SELECT number FROM $happy_inquiry WHERE 1=1 $WHERE";
	$Total				= mysql_num_rows(query($Sql));

	############ 페이징처리 ############
	$start				= preg_replace('/\D/', '', $_GET["start"]);
	$scale				= $ex_limit;

	if( $start ) { $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale			= 6;

	$searchMethod		= "";
	#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
	$searchMethod		.= "&mode=$_GET[mode]";
	$searchMethod		.= "&links_number=$_GET[links_number]";
	$searchMethod		.= "&stats=$_GET[stats]";
	$searchMethod		.= "&search_keyword=$_GET[search_keyword]";


	$paging				= newPaging( $Total, $scale, $pageScale, $start, "<img src='../img/page/btn_pageing_prev.gif' border='0' align='absmiddle'>", "<img src='../img/page/btn_pageing_next.gif' border='0' align='absmiddle'>", $searchMethod);
	$문의내역페이징		= $paging;

	$Sql				= "
							SELECT
									A.*,
									B.guin_title,
									B.guin_name,
									B.guin_phone,
									B.guin_email
							FROM
									$happy_inquiry AS A
							LEFT JOIN
									$happy_inquiry_links AS B
							ON
									A.links_number = B.number
							WHERE
									1=1
									$WHERE2
							ORDER BY
									$ORDER
							LIMIT
									$start, $scale
						";
	$Result				= query($Sql);

	//echo nl2br($Sql);

	$random				= rand()%1000;
	$TPL->define("문의내역출력_$random", "$skin_folder/$template");

	$print_out			= "<table width='100%' cellspacing='0' cellpadding='0' border='0'>";

	while ( $Data = happy_mysql_fetch_array($Result) )
	{
		$Data['listNo']	= $listNo;

		//메인페이지에서 문의일때 링크없앰
		$Data['detail_link_start']	= "<a href='guin_detail.php?num=$Data[links_number]' target='_blank'>";
		$Data['detail_link_end']	= "</a>";

		if ( $Data['links_number'] == "" || $Data['links_number'] == 0 )
		{
			$Data['detail_link_start']	= "";
			$Data['detail_link_end']	= "";
		}

		//댓글 개수출력
		$Sql				= "SELECT number FROM $happy_inquiry_comment WHERE links_number = '$Data[number]' ";
		$comment_total_count= mysql_num_rows(query($Sql));
		$Data['댓글개수출력']= ( $comment_total_count > 0 ) ? "[".$comment_total_count."]" : "";

		$Data['stats_info']	= $happy_inquiry_stats_array[$Data['stats']];

		$contents			= &$TPL->fetch("문의내역출력_$random");
		$print_out			.= "\n<tr>\n\t<td>".$contents."</td>\n</tr>";

		$listNo--;
	}

	if ( $Total == 0 )
	{
		$print_out			.= "\n<tr>\n\t<td height='60' align='center'>접수된 문의내역이 없습니다.</td>\n</tr>";
	}

	$print_out			.= "\n</table>";

	return print $print_out;
}

#{{문의댓글출력 페이지당10개,happy_inquiry_comment_list_rows.html}}
function happy_inquiry_comment_list()
{
	$arg_title	= array('페이지당출력수','템플릿');
	$arg_names	= array('ex_limit','template');
	$arg_types	= array(
						'ex_limit'		=> 'int',
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
		#echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}

	global $TPL, $skin_folder, $happy_inquiry_comment;
	global $Reply, $댓글페이징;

	$happy_member_login_id	= happy_member_login_check();

	if ( $happy_member_login_id == "" )
	{
		//return;
	}

	$number					= $_GET['number'];

	if ( $number == "" )
	{
		return print "문의 고유번호가 없습니다.";
	}

	if ( !is_file("$skin_folder/$template") )
	{
		return print "$skin_folder/$template 파일이 존재하지 않습니다.";
	}

	$Sql				= "SELECT number FROM $happy_inquiry_comment WHERE links_number = '$number' ";
	$Total				= mysql_num_rows(query($Sql));

	############ 페이징처리 ############
	$start				= preg_replace('/\D/', '', $_GET["start"]);
	$scale				= $ex_limit;

	if( $start ) { $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale			= 6;

	$searchMethod		= "";
	#검색값 넘겨주는거 입력 &변수명=값&변수명2=값2&변수명3=값3
	$searchMethod		.= "&mode=$_GET[mode]";
	$searchMethod		.= "&number=$_GET[number]";

	$paging				= newPaging( $Total, $scale, $pageScale, $start, "", "", $searchMethod);
	$댓글페이징			= $paging;

	if ( $Total <= $scale )
	{
		$댓글페이징			= "";
	}

	$Sql				= "
							SELECT
									*
							FROM
									$happy_inquiry_comment
							WHERE
									links_number		= '$number'
							ORDER BY
									number desc
							LIMIT
									$start, $scale
						";
	$Result				= query($Sql);

	//echo nl2br($Sql);

	$random				= rand()%1000;
	$TPL->define("문의댓글출력_$random", "$skin_folder/$template");

	$print_out			= "<table width='100%' cellspacing='0' cellpadding='0' border='0'>";

	while ( $Reply = happy_mysql_fetch_array($Result) )
	{
		if ( $Reply['id'] == '' )
		{
			$Reply['user_info']	= preg_replace("/(\d*)\.(\d*)\.(\d*)\.(\d*)/", "\\1.\\2.***.\\4", $Reply['user_ip']);
		}
		else
		{
			$MEMBER				= happy_member_information($Reply['id']);

			if ( $MEMBER['sns_site'] != "" )
			{
				$Reply['user_info']	= outputSNSID($Reply['id']);
			}
			else
			{
				$Reply['user_info']	= ( $MEMBER['user_nick'] != "" ) ? $MEMBER['user_nick'] : $MEMBER['user_name'];
			}
		}

		$Reply['comment']	= strip_tags($Reply['comment']);
		$Reply['comment']	= nl2br($Reply['comment']);

		$contents			= &$TPL->fetch("문의댓글출력_$random");
		$print_out			.= "\n<tr>\n\t<td>".$contents."</td>\n</tr>";
	}

	if ( $Total == 0 )
	{
		$print_out			.= "\n<tr>\n\t<td height='40' align='center' bgcolor='#ffffff'><div style='background:rgba(0,0,0,0.4); border-radius:5px; text-align:center;'><p class='font_16 noto400' style='color:#fff; padding:15px;'>작성된 댓글이 없습니다.</p></div></td>\n</tr>";
	}

	$print_out			.= "\n</table>";

	return print $print_out;
}

function happy_inquiry_button_print()
{
	global $메인페이지문의버튼, $HAPPY_CONFIG;

	if ( $HAPPY_CONFIG['inquiry_form_use_conf'] != "no" )
	{
		$메인페이지문의버튼 = "<a href='happy_inquiry.php'><img src='img/btn_inquiry_main.gif' alt='메인페이지에서 문의' style='margin-top:5px;'></a>";
	}
}

####################################################
##																								##
##						문의하기 기능관련 함수 END - hong 추가									##
##																								##
####################################################

//입력값으로 받은 값 정리
//int, float, alpha_number, only_number
//kisa 웹 보안 권고사항
function happy_input_str_replace($str1,$type)
{
	//네이버검색 타입
	global $naver_search_type;


	$str2 = '';

	if ( $type == "int" )
	{
		$str2 = intval($str1);
	}
	else if ( $type == "float" )
	{
		$str2 = floatval($str1);
	}
	else if ( $type == "alpha_number" )
	{
		$str2 = preg_replace("/[=\(\)\'\"\:\;]/i","",$str1);
		$str2 = str_replace("\\",'',$str2);
	}
	else if ( $type == "only_number" )
	{
		$str2 = preg_replace("/\D/","",$str1);
	}
	else if ( $type == "strip_tags" )
	{
		$str2 = strip_tags($str1);
	}
	else if ( $type == "htmlspecialchars" )
	{
		$str2 = htmlspecialchars($str1);
	}
	else if ( $type == "parse_str" )
	{
		$str2 = $_SERVER['SCRIPT_NAME'];
		parse_str($_SERVER['QUERY_STRING'],$a);

		if(count($a)>=1)
		{
			$str2.= "?";
			$i = 0;
			$amp = '';
			foreach($a as $k=>$v)
			{
				if ( $i != 0 )
				{
					$amp = '&';
				}

				$v = happy_input_str_replace($v,"htmlspecialchars");
				$v = happy_input_str_replace($v,"alpha_number");

				$str2.= $amp.$k."=".$v;
				$i++;
			}
		}

		//echo $str2."<br>";
	}
	else if ( $type == "naver_search_type" )
	{
		$tmp = array_keys($naver_search_type);

		if ( $str1 == "자동" || in_array($str1,$tmp) )
		{
			$str2 = $str1;
		}
		else
		{
			$str2 = $tmp[0];
		}
	}
	else
	{
		$str2 = '';
	}

	return $str2;

}


function HappyMail($From_name, $From,$To,$Subject,$Text,$Headers='')
{
	global $happy_mail_send_type;
	global $server_character_mail;

	//메일 함수 통합 - hong
	$From_name		= '=?' . $server_character_mail . '?B?'.base64_encode($From_name).'?=';
	$Subject		= '=?' . $server_character_mail . '?B?'.base64_encode($Subject).'?=';

	if ( $Headers == "" )
	{
		$Headers		= "From: " . $From_name. " <" . $From . ">\r\n";
		$Headers		.= "Reply-to: " . $From . "\r\n";
		$Headers		.= "Return-Path: " . $From . "\r\n";
		$Headers		.= "Content-Type: text/html; charset=" . $server_character_mail . "\r\n";
		$Headers		.= "Content-Transfer-Encoding: base64\r\n";				//이메일 발송 내용 chunck 처리 패치		-2022-05-09
	}

	if ( $happy_mail_send_type == 'default' )
	{
		if( !preg_match("/Content-Transfer-Encoding\: base64/i",$Headers))
		{
			$Headers		.= "\r\nContent-Transfer-Encoding: base64\r\n";				//Header 를 함수 밖에서 만들 경우 Content-Transfer-Encoding 누락 발생하여 패치
			$Headers		= str_replace("\r\n\r\n","\r\n",$Headers);					//\r\n 이 2번 붙으면 메일 깨짐을 방지.
		}
		$Text		= chunk_split(base64_encode($Text));						//이메일 발송 내용 chunck 처리 패치		-2022-05-09
		mail ($To,$Subject,$Text,$Headers);
	}
	else if ( $happy_mail_send_type == 'direct' )
	{
		$fp				= popen("/home/bin/sendmail -t -f $From","w"); // 주의하실 부분
		if( !$fp )
		{
			return false;
		}

		fputs($fp,"from: $From_name<$From>\n"); // from 과 : 은 붙여주세요 => from:
		fputs($fp, "to: <$To>\n");
		fputs($fp, "subject: $Subject\n");
		fputs($fp, "Content-Type: text/html; charset=" . $server_character_mail . "\n");
		fputs($fp, "$Text");
		fputs($fp, "\r\n\r\n\r\n");
		pclose($fp);
	}
	return true;
}


//SMS아이디, 받는사람번호,보내는사람번호,메시지,타입,테스트모드,암호화
function send_sms_msg($userid,$phone,$callback,$message,$type,$testing,$secure,$sms_use='',$kakao_template_code='')
{
	$dataStr = "";

	$dataStr = "&phone=".$phone;
	$dataStr.= "&userid=".$userid;
	$dataStr.= "&type=".$type;
	$dataStr.= "&returnUrl=";    //리턴url 받아서 이동하지 않음
	$dataStr.= "&message=".$message;
	$dataStr.= "&callback=".$callback;
	$dataStr.= "&testing=".$testing;
	$dataStr.= "&secure=".$secure;

	//카카오 알림톡 기능추가 hong
	if ( $sms_use == "kakao" )
	{
		$dataStr.= "&is_kakao=y";
		$dataStr.= "&kakao_template_code=".$kakao_template_code;
	}

	return $dataStr;
}

//소켓으로 SMS전송요청하려고 추가
function send_sms_socket( $dataStr )
{

	$url = "http://happysms.happycgi.com/send/send_utf.php";
	//$url = "http://happysms.happycgi.com/send/send_utf.php";

	$URL_parsed = @parse_url($url);

	$host = $URL_parsed["host"];
	$port = $URL_parsed["port"];
	if ($port==0)
		$port = 80;

	$path = $URL_parsed["path"];
	if ($URL_parsed["query"] != "")
		$path .= "?".$URL_parsed["query"];

	$out = "POST $path HTTP/1.0\r\n";
	$out.= "Host: $host\r\n";
	$out.= "Referer: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\r\n";
	$out.= "Content-type: application/x-www-form-urlencoded\r\n";
	$out.= "Content-length: ".strlen($dataStr)."\r\n\r\n";
	$out.= $dataStr."\r\n";

	//echo $out;

	$fp = fsockopen($host, $port, $errno, $errstr, 30);
	if (!$fp) {
	 echo "$errstr ($errno)<br>\n";
	} else {
		fputs($fp, $out);
		$body = false;
		while (!feof($fp)) {
			$s = fgets($fp, 128);
			if ( $body )
				$in .= $s;
			if ( $s == "\r\n" )
				$body = true;
		}

		fclose($fp);
		return $in;
	}
}

//{{즐겨찾기링크 열기}}
//{{즐겨찾기링크 닫기}}
function add_bookmark_link($type,$txt1="")
{
	if ( $type == "열기" )
	{
		$link = '<a href="#favorite" onClick="add_bookmark_click();" '.$txt1.'>';
	}
	else if ( $type == "닫기" )
	{
		$link = '</a>';
	}
	else if ( $type == "클릭")
	{
		$link = ' onClick="add_bookmark_click();" ';
	}

	return $link;
}

//업로드 폴더체크
function upload_dir_check($dir)
{
	$oldmask = umask(0);
	if (!is_dir("$dir"))
	{
		mkdir("$dir", 0777);
	}
	umask($oldmask);

	if (!is_dir("$dir"))
	{
		error("첨부파일을 위한 ($dir)폴더가 존재하지 않습니다.  ");
		exit;
	}
}

//첨부파일 썸네일만든거 찾아서 삭제(같은 폴더내에 있을때)
function unlink_with_thumb($file)
{
	global $demo_lock;

	if ( $file != "" )
	{
		$dir = dirname($file);
		list($file_name,$file_ext) = explode(".",str_replace($dir."/","",$file));
		//echo "이게 원본파일:".$file_name."::".$file_ext."<br>";

		if ( $demo_lock == "" )
		{
			if(is_dir($dir))
			{
				$dir_obj=opendir($dir);

				while(($file_str = readdir($dir_obj))!==false)
				{
					if( $file_str!="." && $file_str!=".." )
					{
						if ( strpos($file_str,$file_name) !== false )
						{
							//echo $dir."/".$file_str."<br>";
							@unlink($dir."/".$file_str);
						}
					}
				}

				closedir($dir_obj);
			}
		}
	}
}


//네이버 글전송 2015-07-23 sum
function BlogPostWrite($title, $description)
{
	global $HAPPY_CONFIG, $server_character;
	$g_blog_url		= "https://api.blog.naver.com/xmlrpc";
	$user_id		= $HAPPY_CONFIG['naver_blog_user_id'];
	$blogid			= $HAPPY_CONFIG['naver_blog_blog_id'];
	$password		= $HAPPY_CONFIG['naver_blog_password'];
	$publish		= true;

	$character		= strtolower($server_character);
	if ( $character != 'utf8' && $character != 'utf-8' )
	{
		$title			= iconv("EUC-KR", "UTF-8", $title);
		$description	= iconv("EUC-KR", "UTF-8", $description);
	}

	$client			= new xmlrpc_client($g_blog_url);

	$client->setSSLVerifyPeer(false);
	$GLOBALS['xmlrpc_internalencoding']='UTF-8';

	$struct			= array
					(
						'title'			=> new xmlrpcval($title, "string"),
						'description'	=> new xmlrpcval($description, "string")
					);

	$f				= new xmlrpcmsg
					(
								"metaWeblog.newPost",
								array(
									new xmlrpcval($blogid, "string"),
									new xmlrpcval($user_id, "string"),
									new xmlrpcval($password, "string"),
									new xmlrpcval($struct , "struct"),
									new xmlrpcval($publish, "boolean")
								)
					);
	$f->request_charset_encoding = 'UTF-8';


	return $response	= $client->send($f);
}
//네이버 글전송 2015-07-23 sum

// {{네이버블로그글전송 {news_article},{DETAIL.number},{DETAIL.title},{DETAIL.comment},img/naver_blog.jpg,img/naver_blog_re.jpg}}
// {{네이버블로그글전송 {테이블명},{해당테이블고유값},{제목},{내용},전송이미지,재전송이미지}}
$naver_blog_send_btn_func	= 0;
function naver_blog_send_btn($tb,$number,$title,$description,$img_send,$img_send_re='')
{
	global $master_check, $happy_naver_blog_send,$naver_blog_send_btn_func;

	if( $tb == '' || $number == '' || $title == '' || $description == '' )
	{
		return "오류가 발생하였습니다. 누락된 값은 없는지 확인바랍니다.";
	}

	if( !admin_secure("슈퍼관리자전용") )
	{
		return;
	}

	$val				= array('tb','number','title','description');
	foreach( $val AS $v )
	{
		$is_global			= true;
		$tmp_val			= $$v;

		if( strpos($tmp_val,"{") !== false && strpos($tmp_val,"}") !== false )
		{
			$tmp_val			= str_replace("}","",str_replace("{","",$tmp_val));
		}
		else
		{
			$is_global			= false;
		}

		if( $is_global )
		{
			$tmp_arr			= explode(".",$tmp_val);
			$tmp_name			= $tmp_arr[1];
			global ${$tmp_arr[0]};

			$ExArray			= $$tmp_arr[0];
		}
		else
		{
			$ExArray			= $tmp_val;
		}

		if( $tmp_name != '' )
		{
			$$v					= $ExArray[$tmp_name];
		}
		else
		{
			$$v					= $ExArray;
		}
	}

	$title				= base64_encode(strip_tags($title));
	$description		= base64_encode($description);

	$sql				= "
							SELECT
									COUNT(*)
							FROM
									$happy_naver_blog_send
							WHERE
									tb				= '$tb'
							AND
									links_number	= '$number'
	";
	$cnt				= mysql_fetch_row(query($sql));

	if( $cnt[0] == 0 )
	{
		$message			= "현재 게시물을 네이버로 전송을 하시겠습니까?";
		$naver_blog_img		= $img_send;
	}
	else
	{
		$message			= "이미 전송한 게시물입니다. 네이버로 다시 전송을 하시겠습니까?";
		$naver_blog_img		= $img_send_re;
	}

	$str				= "
							<img id=\"naver_blog_send_img{$naver_blog_send_btn_func}\" src=\"$naver_blog_img\" onclick=\"naver_blog_send_ok{$naver_blog_send_btn_func}();\" style=\"cursor:pointer;\" />
							<iframe width='0' height='0' frameborder='0' name='blog_send_iframe{$naver_blog_send_btn_func}'></iframe>
							<form name='blog_send_form{$naver_blog_send_btn_func}' action='naver_blog.php' method='post' target='blog_send_iframe{$naver_blog_send_btn_func}'>
							<input type='hidden' name='tb' value='$tb' />
							<input type='hidden' name='number' value='$number' />
							<input type='hidden' name='title' value='$title' />
							<input type='hidden' name='description' value='$description' />
							<input type='hidden' name='img_re' value='$img_send_re' />
							<input type='hidden' name='func_i' value='{$naver_blog_send_btn_func}' />
							</form>
							<script type=\"text/javascript\">
								function naver_blog_send_ok{$naver_blog_send_btn_func}()
								{
									if( confirm('$message') )
									{
										document.blog_send_form{$naver_blog_send_btn_func}.submit();
									}
									else
									{
										return false;
									}
								}
							</script>
	";

	$naver_blog_send_btn_func++;

	return $str;
}



//ranksa
function xml_parse_handle($type,$DATA)
{
	$RETURN_DATA			= Array();

	$xml_parser				= xml_parser_create();
	xml_parse_into_struct($xml_parser,$DATA,$xml_vals,$index);
	$xml_parser_free_bool	= xml_parser_free($xml_parser);
	if ($xml_parser_free_bool == true)
	{
		foreach($xml_vals AS $XML_ARR)
		{
			//echo $XML_ARR['tag']." / ".$XML_ARR['value']."<br>";
			if($type == "links_geocode")
			{
				switch($XML_ARR['tag'])
				{
					case "Y":				$RETURN_DATA['ypoint']	= $XML_ARR['value'];break;
					case "X":				$RETURN_DATA['xpoint']	= $XML_ARR['value'];break;
				}
			}
		}
	}

	return $RETURN_DATA;
}


#{{방문자수 오늘}}, {{방문자수 어제}}, {{방문자수 이번달}}, {{방문자수 지난달}}, {{방문자수 올해}}, {{방문자수 작년}}, {{방문자수 전체}}
function stats_print($stats_name)
{
	global $stats_tb;

	$count_field	= "totalCount";
	$date_field		= "regdate";
	$stats_tb		= $stats_tb;
	$WHERE			= "";

	switch ( $stats_name )
	{
		case "오늘" :
						$WHERE			= " WHERE $date_field = curdate()";
						break;
		case "어제" :
						$yester			= date("Y-m-d", happy_mktime(0, 0, 0, date("m"), date("d")-1, date(Y)));
						$WHERE			= " WHERE $date_field = '$yester'";
						break;
		case "이번달" :
						$first_day		= date("Y-m-d", happy_mktime(0, 0, 0, date('m'), 1, date('Y')));
						$last_day		= date("Y-m-d", happy_mktime(0, 0, 0, date('m')+1, 0, date('Y')));
						$WHERE			= " WHERE $date_field BETWEEN '$first_day' AND '$last_day'";
						break;
		case "지난달" :
						$first_day		= date("Y-m-d", happy_mktime(0, 0, 0, date('m')-1, 1, date('Y')));
						$last_day		= date("Y-m-d", happy_mktime(0, 0, 0, date('m'), 0, date('Y')));
						$WHERE			= " WHERE $date_field BETWEEN '$first_day' AND '$last_day'";
						break;
		case "올해" :
						$first_day		= date("Y-m-d", happy_mktime(0, 0, 0, 1, 1, date('Y')));
						$last_day		= date("Y-m-d", happy_mktime(0, 0, 0, 12, 31, date('Y')));
						$WHERE			= " WHERE $date_field BETWEEN '$first_day' AND '$last_day'";
						break;
		case "작년" :
						$first_day		= date("Y-m-d", happy_mktime(0, 0, 0, 1, 1, date('Y')-1));
						$last_day		= date("Y-m-d", happy_mktime(0, 0, 0, 12, 31, date('Y')-1));
						$WHERE			= " WHERE $date_field BETWEEN '$first_day' AND '$last_day'";
						break;
		case "전체" :
						$WHERE			= "";
						break;
		default		:
						return;
						break;
	}

	$Sql			= "SELECT sum($count_field) FROM $stats_tb $WHERE";
	$result			= query($Sql);
	$count			= happy_mysql_fetch_array($result);

	if ( $count[0] < 1 )
	{
		$count[0]		= 0;
	}

	return $count[0];
}









/*********************************************************************************************************************************
* 통합지도 2016-03-29 x2chi
* 관리자에서 선택된 지도록 출력
* 지도출력 ( 지도타입, 주소, 가로크기, 세로크기, 줌레벨, 아이콘, 옵션 )
*  - 지도타입	: 기본 '자동', 선택[ google(구글), naver(네이버) ]
*  - 옵션		:
*				"줌버튼" : 지도 확대 축소 버튼
*				"일반지도"|"위성지도"|"하이브리드"|"지형지물지도" : 구글지도타입
*********************************************************************************************************  happy_map_call star  **/
function happy_map_call ( $mapType = "자동", $addr = "자동", $mWidth = "780", $mHeight = "370", $scale = "", $centerIcon = "", $options = "" )
{
	global $HAPPY_CONFIG;

	// 템플릿에서 받아올때 공백제거
	$mapType				= trim($mapType);
	$addr					= trim($addr);
	$mWidth					= trim(preg_replace('/[^0-9][\%]/','',$mWidth));
	$mHeight				= trim(preg_replace('/[^0-9][\%]/','',$mHeight));
	$scale					= trim(preg_replace('/\D/','',$scale));
	$centerIcon				= trim($centerIcon);
	$options				= trim($options);


	// 지도타입
	if ( preg_match( "/자동/", $mapType ) )
	{
		$mapType			= $HAPPY_CONFIG['wide_map_type'];
	}
	else if ( preg_match( "/구글/", $mapType ) )
	{
		$mapType			= "google";
	}
	else if ( preg_match( "/네이버/", $mapType ) )
	{
		$mapType			= "naver";
	}
	else if ( preg_match( "/다음/", $mapType ) )
	{
		$mapType			= "daum";
	}



	// 옵션처리
	$scaleBtn				= "";
	$miniMap				= "";
	$photoMapBtn			= "";
	$photoMapType			= "";
	if ( strlen( $options ) > 0 )
	{
		// 줌버튼
		if ( preg_match( "/줌버튼/", $options ) )
		{
			$scaleBtn		= "1";
		}

		// 구글위성지도버튼
		preg_match("/위성지도|하이브리드|지형지물지도|지도버튼/", $options, $matches, PREG_OFFSET_CAPTURE);
		if ( is_array($matches[0]) )
		{
			$photoMapBtn	= "1";
			$photoMapType	= $matches[0][0];
		}

		// 다음지도타입
		if ( preg_match( "/스카이뷰/", $options ) AND $mapType == "daum" )
		{
			$photoMapBtn	= "1";
		}

		// 다음미니맵
		if ( preg_match( "/미니맵/", $options ) AND $mapType == "daum" )
		{
			$miniMap		= "1";
		}
	}




	if( $mapType == 'google' )
	{

		// 구글지도 --------------------------------------------------------------------------------------

		//기본설정
		$scale			= ( strlen($scale			) == 0 ) ? "15"					: $scale ;		// 줌레벨
		$scaleBtn		= ( strlen($scaleBtn		) == 0 ) ? "0"					: $scaleBtn ;	// 줌(확대/축소) 버튼 ( 0 or 1 )
		$photoMapType	= ( strlen($photoMapType	) == 0 ) ? "일반지도"			: $photoMapType;// 위성지도 보기 타입 ( 위성지도|하이브리드|지형지물지도 )
		$photoMapBtn	= ( strlen($photoMapBtn		) == 0 ) ? "0"					: $photoMapBtn;	// 위성지도 보기 버튼 ( 0 or 1 )

		// 지도출력
		@header('X-UA-Compatible: IE=Edge');
		google_map_call( $addr, $mWidth, $mHeight, $scale, $photoMapType, $photoMapBtn, $scaleBtn );

	}
	else if( $mapType == 'naver' )
	{

		// 네이버지도 ------------------------------------------------------------------------------------

		//기본설정
		$scale			= ( strlen($scale			) == 0 ) ? "10"					: $scale;		// 줌레벨
		$scaleBtn		= ( strlen($scaleBtn		) == 0 ) ? "0"					: $scaleBtn;	// 줌(확대/축소) 버튼 ( 0 or 1 )
		//$centerIcon		= ( strlen($centerIcon		) == 0 ) ? "img/map_here.gif"	: $centerIcon;	// 물방울 아이콘
		$photoMapBtn	= ( strlen($photoMapBtn		) == 0 ) ? "0"					: $photoMapBtn;	// 위성지도 보기 버튼 ( 0 or 1 )

		// 지도출력 (솔루션마다 $photoMapBtn 사용이 다를 수 있음)
		echo naver_map_call( $addr, $mWidth, $mHeight, $scale, $centerIcon, $photoMapBtn, $scaleBtn );

	}
	else if( $mapType == 'daum' )
	{
		// 관리자에서 사용안하고 있음
		// 다음지도 ------------------------------------------------------------------------------------

		//기본설정
		$scale			= ( strlen($scale			) == 0 ) ? "10"					: $scale;		// 줌레벨
		$scaleBtn		= ( strlen($scaleBtn		) == 0 ) ? "사용안함"			: "사용함";		// 줌(확대/축소) 버튼 ( 사용함, 사용안함 )
		//$centerIcon		= ( strlen($centerIcon		) == 0 ) ? "img/map_here.png"	: $centerIcon;	// 물방울 아이콘
		$miniMap		= ( strlen($miniMap			) == 0 ) ? "사용안함"			: "사용함";		// 미니맵 ( 사용함, 사용안함 )

		// 지도출력
		daum_map_call( $addr, $mWidth, $mHeight, $scale, $photoMapBtn, $miniMap, $scaleBtn, $centerIcon );

	}
}
/********************************************************************************************************  happy_map_call end  ***/

//SNS로그인 버튼 출력 - hong
function happy_sns_login($sns_site,$btn_img_src,$btn_img_width='')
{
	global $HAPPY_CONFIG, $happy_sns_id, $happy_sns_userkey, $되돌아가는주소;
	global $site_name, $db_user;

	if ( $sns_site == "" )
	{
		return "SNS 로그인 사이트명을 입력하세요.";
	}

	if ( $btn_img_src == "" )
	{
		return "SNS 로그인 버튼 경로를 입력하세요.";
	}

	$btn_img_width			= preg_replace('/\D/', '', $btn_img_width);
	$btn_img_width_style	= ( $btn_img_width != "" ) ? "width:{$btn_img_width}px" : "";
	$google_sns_login_div	= "";

	//한글 입력시 영문으로 변경
	switch ( $sns_site )
	{
		case '페이스북'	: $sns_site			= "facebook";		break;
		case '트위터'	: $sns_site			= "twitter";		break;
		case '구글'		: $sns_site			= "google";			break;
		case '카카오'	: $sns_site			= "kakao";			break;
		case '네이버'	: $sns_site			= "naver";			break;
	}

	//대문자를 소문자로 변경
	$sns_site			= strtolower($sns_site);

	switch ( $sns_site )
	{
		case 'facebook'	: $sns_site_title	= "페이스북로그인";	break;
		case 'twitter'	: $sns_site_title	= "트위터로그인";	break;
		case 'google'	: $sns_site_title	= "구글로그인";		break;
		case 'kakao'	: $sns_site_title	= "카카오로그인";	break;
		case 'naver'	: $sns_site_title	= "네이버로그인";	break;
		default			: return;
	}

	$sns_login_use		= $HAPPY_CONFIG['happy_sns_login_use_'.$sns_site];

	if ( $sns_login_use == "y" ) //CGIMALL 통합 모듈 사용
	{
		$sns_btn_onclick	= "sns_login_call('{$sns_site}', '{$happy_sns_id}', '{$happy_sns_userkey}','{$되돌아가는주소}');";
	}
	else if ( $sns_login_use == "each" ) //사이트 개별 모듈 사용
	{
		$happy_secure_key	= md5($site_name.$db_user.session_id().$_SERVER['REMOTE_ADDR']);
		$sns_login_key		= trim($HAPPY_CONFIG['happy_sns_login_key_'.$sns_site]);

		if ( $sns_login_key == "" )
		{
			return;
		}

		switch ( $sns_site )
		{
			//페이스북 로그인 연동 SATRT
			case 'facebook' :
			{
				$sns_btn_js			= "
				<script type='text/javascript'>

					window.fbAsyncInit = function() {
						FB.init({
							appId		: '" . $sns_login_key . "',
							xfbml		: true,
							cookie		: true,
							version		: 'v2.6'
						});

						document.getElementById('sns_login_btn_{$sns_site}').onclick = call_facebook_login;
					};

					(function(d, s, id){
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) {return;}
						js		= d.createElement(s); js.id = id;
						js.src	= '//connect.facebook.net/ko_KR/sdk.js';
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));

					function call_facebook_login()
					{
						//로그인 폼 초기화
						document.getElementById('sns_login_div').innerHTML	= '".happy_sns_login_form_build()."';

						FB.login(function(response) {

							if ( response.status === 'connected' )
							{

								FB.api('/me', function(user) {

									//alert(JSON.stringify(user));
									//console.log(JSON.stringify(user));

									if ( user.id )
									{
										var form = document.forms['joinus_form'];

										form.sns_site.value					= 'facebook';
										form.returnUrl.value				= '" . $되돌아가는주소 . "';
										form.post_happy_secure_key.value	= '" . $happy_secure_key . "';
										form.sns_id.value					= user.id;
										form.sns_name.value					= user.name;
										form.sns_username.value				= user.name;
										form.sns_image.value				= 'https://graph.facebook.com/' + user.id + '/picture';
										form.submit();
									}
									else
									{
										//정보 받아오기 실패
										alert(' 로그인에 실패 하였습니다. 재시도를 해주세요. \\n ERROR CODE : facebook_error 002');
									}
								});
							}
							else
							{
								//로그인 실패
								alert(' 로그인에 실패 하였습니다. 재시도를 해주세요. \\n ERROR CODE : facebook_error 001');
							}
						});
					}
				</script>
				";

				$sns_btn_onclick	= "javascript:alert('잠시후에 다시 시도해주세요.');";
				break;
			}
			//페이스북 로그인 연동 END

			//구글 로그인 연동 START
			case 'google' :
			{
				$sns_login_key		= str_replace(".apps.googleusercontent.com","",$sns_login_key);
				$sns_login_key		= $sns_login_key.".apps.googleusercontent.com";

				$google_sns_login_div	= "<div id=\"google_sns_login_div\" style=\"display:none;\"></div>";

				$sns_btn_js			= "
				<script src=\"//accounts.google.com/gsi/client\" async defer></script>
				<script src=\"./js/jwt-decode.js\"></script>
				<script>
				function handleCredentialResponse(response) {
					const responsePayload = jwt_decode(response.credential);

					/*
					console.log('ID: ' + responsePayload.sub);
					console.log('Full Name: ' + responsePayload.name);
					console.log('Given Name: ' + responsePayload.given_name);
					console.log('Family Name: ' + responsePayload.family_name);
					console.log('Image URL: ' + responsePayload.picture);
					console.log('Email: ' + responsePayload.email);
					*/

					if( responsePayload.sub != '' )
					{
						var form = document.forms['joinus_form'];

						if ( form != undefined )
						{
							form.sns_site.value					= 'google';
							form.returnUrl.value				= '" . $되돌아가는주소 . "';
							form.post_happy_secure_key.value	= '" . $happy_secure_key . "';
							form.sns_id.value					= responsePayload.sub;
							form.sns_name.value					= responsePayload.name;
							form.sns_username.value				= responsePayload.name;
							form.sns_email.value				= responsePayload.email;
							form.sns_image.value				= responsePayload.picture;
							form.submit();
						}
					}
				}

				window.onload = function () {
					google.accounts.id.initialize({
						client_id: \"{$HAPPY_CONFIG['happy_sns_login_key_google']}\",
						callback: handleCredentialResponse
					});
					google.accounts.id.renderButton(
						document.getElementById(\"google_sns_login_div\"),
					{ type: \"icon\" }
				);
				//google.accounts.id.prompt();
				}

				function call_google_login()
				{
					document.getElementById('sns_login_div').innerHTML	= '".happy_sns_login_form_build()."';

					$(\"#google_sns_login_div\").find(\"[role=button]\").click();
				}
				</script>
				";
				$sns_btn_onclick	= "call_google_login()";
				break;
			}
			//구글 로그인 연동 END

			default :
			{
				//트위터 로그인은 5.2 버전 이하인 경우 오류
				if ( $sns_site == "twitter" &&  PHP_VERSION < '5.2' )
				{
					return;
				}

				//happy_sns_login 함수는 js/sns_login.js 파일에 선언
				$sns_btn_onclick	= "happy_sns_login('".$sns_site."','".$되돌아가는주소."')";

				//데모에서는 네이버 로그인 작동안하도록 패치 - hong
				global $demo_lock;
				if ( $sns_site == "naver" && $demo_lock )
				{
					$sns_btn_onclick	= "javascript:alert('데모에서는 이용하실 수 없는 서비스입니다.');";
				}
				break;
			}
		}
	}
	else //사용안함
	{
		return;
	}

	return "{$sns_btn_js}<img src='{$btn_img_src}' id='sns_login_btn_{$sns_site}' alt='{$sns_site_title}' title='{$sns_site_title}' style='cursor:pointer; {$btn_img_width_style}' onClick=\"{$sns_btn_onclick}\">{$google_sns_login_div}";
}

function happy_sns_login_form_build()
{
	$form	= "<iframe name='sns_login_blank' id='sns_login_blank' style='display:none'></iframe>";
	$form	.= "<form name='joinus_form' action='./sns_login/joinus.php' method='post' target='sns_login_blank'>";
	$form	.= "<input type='hidden' name='returnUrl' value=''>";
	$form	.= "<input type='hidden' name='sns_site' value=''>";
	$form	.= "<input type='hidden' name='sns_id' value=''>";
	$form	.= "<input type='hidden' name='sns_name' value=''>";
	$form	.= "<input type='hidden' name='sns_username' value=''>";
	$form	.= "<input type='hidden' name='sns_email' value=''>";
	$form	.= "<input type='hidden' name='sns_image' value=''>";
	$form	.= "<input type='hidden' name='post_happy_secure_key' value=''>";
	$form	.= "</form>";

	return addslashes($form);
}


function want_job_send_msg($value)
{
	global $job_per_want_search, $HAPPY_CONFIG, $site_phone, $site_name, $happy_member, $ADMIN, $want_money_arr;
	/*
	ALTER TABLE `job_per_want_search` ADD `check_want_mail` ENUM( 'y', 'n' ) DEFAULT 'n' NOT NULL , ADD `check_want_sms` ENUM( 'y', 'n' ) DEFAULT 'n' NOT NULL ;
	*/

	$value['guin_gender']	= ( trim($value['guin_gender']) == '남자' ) ? "man" : "girl";
	$value['guin_career']	= ( $value['guin_career_year'] != "" ) ? $value['guin_career_year'] : $value['guin_career'];

	//print_r2($value);
	$send_m	= array();
	$sql	= "
				SELECT
						*
				FROM
						$job_per_want_search
				WHERE
						(
							(
								job_type1 = '$value[type1]'
							AND
								job_type2 = '$value[type_sub1]'
							)
						OR
							(
								job_type1 = '$value[type2]'
							AND
								job_type2 = '$value[type_sub2]'
							)
						OR
							(
								job_type1 = '$value[type3]'
							AND
								job_type2 = '$value[type_sub3]'
							)
						) # 분야
				AND
						(
							(
								si = '$value[si1]'
							AND
								gu = '$value[gu1]'
							)
						OR
							(
								si = '$value[si2]'
							AND
								gu = '$value[gu2]'
							)
						OR
							(
								si = '$value[si3]'
							AND
								gu = '$value[gu3]'
							)
						) # 지역
				AND
						(
							grade_gtype = '$value[guin_type]'
						OR
							grade_gtype = ''
						) # 고용형태
				ORDER BY
					regdate
				DESC
	";
	//echo $sql;
	$rec	= query($sql);
	while($dt = happy_mysql_fetch_assoc($rec))
	{
		$dt['career_read']	= ( $dt['career_read_year'] != "" ) ? $dt['career_read_year'] : $dt['career_read'];

		$is_pay	= false;
		if( $dt['grade_money_type'] != "" && $value['guin_pay_type'] != "" && trim($dt['grade_money_type']) == trim($value['guin_pay_type']) )
		{
			// 급여를 설정 했고, 시급 / 입급 / 주급 / 월급 / 건당 으로 설정 했을 경우
			$is_pay	= true;
		}
		else if( $dt['grade_money_type'] != "" && $value['guin_pay_type'] == "" && $value['guin_pay'] != "" && trim($dt['grade_money_type']) == trim($value['guin_pay']) )
		{
			// 급여를 설정 했고, 위의 상황이 아닐 경우
			$is_pay	= true;
		}
		else if( $dt['grade_money_type'] == "" )
		{
			// 설정 안했다면 그냥 true
			$is_pay	= true;
		}
		else
		{
			$is_pay	= false;
		}

		//echo "<br />$dt[guziceducation] == $value[guin_edu] && $dt[career_read] == $value[guin_career] && $dt[gender_read] == $value[guin_gender]<br />";
		if( $dt['guziceducation'] == $value['guin_edu'] && $dt['career_read'] == $value['guin_career'] && $dt['gender_read'] == $value['guin_gender'] && $is_pay )
		{
			$is_ok	= false;
			if( $dt['guzic_age_start'] == "" && $dt['guzic_age_end'] == "" && ($value['guin_age'] == '0' || $value['guin_age'] == '') )
			{
				// 연령 제한없음
				$is_ok	= true;
			}
			else
			{
				if( $dt['guzic_age_start'] != "" && $dt['guzic_age_end'] != "" )
				{
					if( $value['guin_age'] > 0 && $value['guin_age'] <= ( date("Y") - $dt['guzic_age_start'] + 1 ) && $value['guin_age'] >= ( date("Y") - $dt['guzic_age_end'] + 1 ) )
					{
						// 연령 검색
						$is_ok	= true;
					}
				}
				else if( $dt['guzic_age_start'] != "" && $dt['guzic_age_end'] == "" )
				{
					if( $value['guin_age'] > 0 && $value['guin_age'] >= ( date("Y") - $dt['guzic_age_start'] + 1 ) )
					{
						// 연령 검색
						$is_ok	= true;
					}
				}
				else if( $dt['guzic_age_start'] == "" && $dt['guzic_age_end'] != "" )
				{
					if( $value['guin_age'] > 0 && $value['guin_age'] <= ( date("Y") - $dt['guzic_age_end'] + 1 ) )
					{
						// 연령 검색
						$is_ok	= true;
					}
				}
				else
				{
					$is_ok	= false;
				}
			}

			if( $is_ok && $dt['check_want_mail'] == 'y' )
			{
				$send_m['mail'][]	= $dt['id'];
			}

			if( $is_ok && $dt['check_want_sms'] == 'y' )
			{
				$send_m['sms'][]	= $dt['id'];
			}
		}
	}

	// sms 발송
	if( sizeof($send_m['sms']) > 0 )
	{
		$id_str	= "'".@implode("','",$send_m['sms'])."'";
		if( $id_str == "" ) return;
		$sql	= "
					SELECT
							*
					FROM
							$happy_member
					WHERE
							user_id IN ( $id_str )
					AND
							sms_forwarding = 'y'
		";
		$sql	= "select * from $happy_member where user_id in ( $id_str )";
		//echo $sql;
		$rec	= query($sql);
		while($dt = happy_mysql_fetch_assoc($rec))
		{
			$mem[$dt['user_id']]	= $dt['user_hphone'];
		}

		$msg	= str_replace("%사이트명%",$site_name,$HAPPY_CONFIG['want_job_send_msg_sms']);
		foreach( $send_m['sms'] AS $sms_k => $sms_v )
		{
			if( trim($mem[$sms_v]) == "" || $HAPPY_CONFIG['want_job_send_use_sms'] == "" ) continue;
			happy_sms_send_snoopy( $HAPPY_CONFIG[sms_userid], $HAPPY_CONFIG[sms_userpass], $mem[$sms_v], $site_phone, $msg, "", '', '', $HAPPY_CONFIG['want_job_send_use_sms'], $HAPPY_CONFIG['want_job_send_msg_sms_ktplcode'] );
		}
	}

	// mail 발송
	if( sizeof($send_m['mail']) > 0 )
	{
		$id_str	= "'".@implode("','",$send_m['mail'])."'";
		if( $id_str == "" ) return;
		$sql	= "
					SELECT
							*
					FROM
							$happy_member
					WHERE
							user_id IN ( $id_str )
					AND
							email_forwarding = 'y'
		";
		$sql	= "select * from $happy_member where user_id in ( $id_str )";
		//echo $sql;
		$rec	= query($sql);
		while($dt = happy_mysql_fetch_assoc($rec))
		{
			$mem[$dt['user_id']]	= $dt['user_email'];
		}

		$title		= str_replace("%사이트명%",$site_name,$HAPPY_CONFIG['want_job_send_msg_mail_title']);
		$contents	= str_replace("%사이트명%",$site_name,$HAPPY_CONFIG['want_job_send_msg_mail_cnt']);
		foreach( $send_m['mail'] AS $mail_k => $mail_v )
		{
			if( trim($mem[$mail_v]) == "" ) continue;
			//메일 함수 통합 - hong
			HappyMail($site_name, $ADMIN['admin_email'],$mem[$mail_v],$title,$contents);
		}
	}
}

#사이트 URL값을 이용한 추천인 기능 체크함수 - 13.01.15 hong 추가
function recommend_check()
{
	global $_GET,$_SESSION,$recommend_get_id;

	if ( $_GET[$recommend_get_id] )
	{
		$_SESSION[$recommend_get_id] = $_GET[$recommend_get_id];
	}

	return;
}






//{{슬라이드배너_모바일 전체,자동,등록역순}}
function happy_banner_slide_mobile()
{
	$arg_title	= array('그룹명','총개수','정렬');
	$arg_names	= array('group_name','Total_limit','orderby');
	$arg_types	= array(
						'Total_limit'		=> '',
						'orderby'			=> ''
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
		//echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}

	global $main_url,$HAPPY_CONFIG;
	global $happy_banner_tb;
	global $skin_folder,$TPL;


	$HAPPY_CONFIG['slidesjs_width'] = $HAPPY_CONFIG['slidesjs_width_pc'];
	$HAPPY_CONFIG['slidesjs_height'] = $HAPPY_CONFIG['slidesjs_height_pc'];

	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		$HAPPY_CONFIG['slidesjs_width'] = $HAPPY_CONFIG['slidesjs_width_mobile'];
		$HAPPY_CONFIG['slidesjs_height'] = $HAPPY_CONFIG['slidesjs_height_mobile'];
	}

	//템플릿용 변수
	$HAPPY_CONFIG['slidesjs_width_pc'] = $HAPPY_CONFIG['slidesjs_width'];
	$HAPPY_CONFIG['slidesjs_height_pc'] = $HAPPY_CONFIG['slidesjs_height'];


	$WHERE		= "";
	$WHERE		.= " AND display = 'Y' and ( now() between startdate and enddate ) ";

	if($group_name != "전체")
	{
		$WHERE	.= " AND groupid='$group_name' ";
	}







	switch( $orderby )
	{
		case "랜덤" :		$ORDER	= "ORDER BY rand()";break;
		case "등록순" :		$ORDER	= "ORDER BY regdate ASC";break;
		case "등록역순" :	$ORDER	= "ORDER BY regdate DESC";break;
		default :			$ORDER	= "";break;
	}

	$Sql			= "SELECT count(*) FROM $happy_banner_tb WHERE 1=1 $WHERE ";
	$Rec			= query($Sql);
	$Total_Count	= mysql_fetch_row($Rec);
	$Total_Count	= $Total_Count[0];

	if ( $Total_Count > 0 )
	{
		$Sql			= "SELECT img FROM $happy_banner_tb WHERE 1=1 $WHERE $ORDER LIMIT 1";
		//echo $Sql."<br>";
		$Rec			= query($Sql);
		list($firstImage) = happy_mysql_fetch_array($Rec);
	}

	//이전 다음 버튼
	$prevButtonImage	= "/img/slide_supersized/back.png";
	$nextButtonImage	= "/img/slide_supersized/forward.png";



	//슬라이드 CSS
	$widthSize			= preg_replace('/\D/','',$HAPPY_CONFIG['slidesjs_width']);
	$heightSize			= preg_replace('/\D/','',$HAPPY_CONFIG['slidesjs_height']);
	$widthposition		= $widthSize/2;

	$prevBtnSize		= @GetImageSize($prevButtonImage);
	$prevBtnWidth		= $prevBtnSize[0];
	$prevBtnHeight		= $prevBtnSize[1];

	$nextBtnSize		= @GetImageSize($nextButtonImage);
	$nextBtnWidth		= $nextBtnSize[0];
	$nextBtnHeight		= $nextBtnSize[1];

	$paginationWidth	= $widthSize - ( $Total_Count * 12 );
	$paginationHeight	= $heightSize - 40;
	$navigationHeight	= ($heightSize/2)-($prevBtnHeight/2);


	//좌로, 우로버튼 위치 계산
	//좌측은 반값
	//우측은 반값-버튼의크기
	//슬라이드배너 크기가 1000 이상이면 무조건 1000으로 계산하게
	//echo $widthSize;
	if ( $widthSize > 1200 )
	{
		$prev_btn_position = (1200/2) - 20;
		$next_btn_position = (1200/2) - $nextBtnWidth - 20;
	}
	else
	{
		$prev_btn_position = $widthSize/2 - 20;
		$next_btn_position = ($widthSize/2) - $nextBtnWidth - 20;
	}



	$HAPPY_CONFIG['slide_stop_loop'] = ( $HAPPY_CONFIG['slide_stop_loop'] == 0 ) ? 1 : 0;


	global $mainSlide;

	$mainSlide = array();
	$mainSlide['heightSize'] = $heightSize;
	$mainSlide['widthposition'] = $widthposition;
	$mainSlide['widthSize'] = $widthSize;

	$mainSlide['navigationHeight'] = $navigationHeight;
	$mainSlide['prevBtnWidth'] = $prevBtnWidth;
	$mainSlide['prevBtnHeight'] = $prevBtnHeight;
	$mainSlide['prev_btn_position'] = $prev_btn_position;
	$mainSlide['prevButtonImage'] = $prevButtonImage;

	$mainSlide['nextBtnWidth'] = $nextBtnWidth;
	$mainSlide['nextBtnHeight'] = $nextBtnHeight;
	$mainSlide['next_btn_position'] = $next_btn_position;
	$mainSlide['nextButtonImage'] = $nextButtonImage;

	$mainSlide['paginationHeight'] = $paginationHeight;
	$mainSlide['paginationWidth'] = $paginationWidth;

	$random	= rand(0,9999);
	//echo "$skin_folder/main_slide_css.html";
	$TPL->define("main_slide_css{$rand}", "$skin_folder/main_slide_css.html");
	$output	= $TPL->fetch("main_slide_css{$rand}");

	//echo htmlspecialchars($output);



	$Arr_domain_ext	= Array(".com",".kr",".co.kr",".net",".org",".or.kr",".biz",".info",".tv",".co",".cc",".asia",".cn",".tw",".in",".pe.kr",".me",".name",".so ");

	if ( $Total_limit == "자동" )
	{
		$Total_limit = $Total_Count;
	}
	else
	{
		$Total_limit = preg_replace('/\D/','',$Total_limit);
	}

	$Sql			= "SELECT * FROM $happy_banner_tb WHERE 1=1 $WHERE $ORDER LIMIT 0,$Total_limit";
	$Rec			= query($Sql);
	$banner_images	= "";
	while($Data	= happy_mysql_fetch_array($Rec))
	{
		$Data['link']		= trim($Data['link']);

		if(!preg_match("/https:\/\//",$Data["link"]))
		{
			$domain_chk_bool	= false;
			foreach($Arr_domain_ext AS $ADE => $ADE_VAL)
			{
				if(stristr($Data['link'],$ADE_VAL))
				{
					$domain_chk_bool	= true;
					break;
				}
			}
			unset($ADE,$ADE_VAL);

			if($domain_chk_bool == true)
			{
				$Data["link"] = "http://". preg_replace("/http:\/\//i","",$Data["link"]);
			}
		}

		//링크 타겟
		$link_tag1 = "";
		$link_tag2 = "</a>";
		$link_src = "";
		if ( $Data['linkTarget'] == "blank" )
		{
			$link_src = " target='_BLANK' ";
		}

		$banner_link_url = "banner_link.php?number={$Data['number']}";
		$banner_view_url = "banner_view.php?number={$Data['number']}";

		if ( $Data["link"] != "" && $Data["link"] != "http://" )
		{
			$link_tag1 = "<a href='{$banner_link_url}' {$link_src}>";
		}

		// $banner_images .= "qhs<a href='$Data[link]' target='_blank'><img src='$Data[img]'></a>"; <=본소스 dalgo 링크
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$banner_images .= "{$link_tag1}<img src='{$banner_view_url}' style='width:100%; max-width:100%;'>{$link_tag2}";
		}
		else
		{
			$banner_images .= "{$link_tag1}<div style='width:100%; height:${heightSize}px; background:url({$banner_view_url}) no-repeat center top;' ></div>{$link_tag2}";
		}
	}

	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		if ( $Total_Count == 1 )
		{
			$output .= "
					$banner_images
			";
		}
		else
		{
			$output .= "
			<div id='container_slides'>
				<div id='slides'>
					$banner_images
				</div>
			</div>
			";
		}
	}
	else
	{
		//한개뿐이면 좌우버튼을 가리자
		if ( $Total_Count == 1 )
		{
			$output .= "
					$banner_images
			";
		}
		else
		{
			$output .= "
			<div id='container_slides'>
				<div id='slides'>
					$banner_images
					<a href='#' class='slidesjs-previous slidesjs-navigation'><img src='' alt='previous'></a>
					<a href='#' class='slidesjs-next slidesjs-navigation'><img src='' alt='next'></a>
				</div>
			</div>
			";
		}
	}


	global $js_file;
	if ( $_COOKIE['happy_mobile'] == "on" )
	{
		//_mobile.js 221라인에 minHeight, maxHeight 를 추가
		$js_file = "js/slidesjs/jquery.slides.min_mobile.js";
	}
	else
	{
		$js_file = "js/slidesjs/jquery.slides.min.js";
	}

	$random	= rand(0,9999);
	//echo "$skin_folder/main_slide_css.html";
	$TPL->define("main_slide_script{$rand}", "$skin_folder/main_slide_script.html");
	$output.= $TPL->fetch("main_slide_script{$rand}");
	//echo htmlspecialchars($output);

	//없으면 아예 안보이게
	//$Total_Count = 0;
	if ( $Total_Count == 0 )
	{
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$output = "
			<img src='$HAPPY_CONFIG[m_s_noimg]' style='width:100%; max-width:100%;'>
			";
		}
		else
		{
			$output = "
				<div style='width:100%; height:${heightSize}px; background:url($HAPPY_CONFIG[pc_s_noimg]) no-repeat center top;' ></div>
			";
		}
	}

	return print $output;
}



########################################
//{{위지윅에디터CSS ckeditor,경로}}
//한페이지에 한번만 요청
$wys_css_cnt = 0;
function happy_wys_css($wys_type,$p = "")
{
	global $wys_css_cnt;

	$css_code = "";

	if ( $wys_type == "ckeditor" )
	{
		$css_file = $p."editor/css/editor.css";
		$css = @file_get_contents($css_file);

		$css_code = "<!--  에디터 관련 CSS -->\n\r<style type=\"text/css\">\n\r";
		$css_code.= $css;
		$css_code.= "</style>\n\r<!--  에디터 관련 CSS -->\n\r";

		$popup_layer = "";
		$popup_layer_file = $p."editor/editor_popup_layer.html";
		$popup_layer = @file_get_contents($popup_layer_file);

		if ( $popup_layer != "" )
		{
			$css_code.= $popup_layer;
		}
		else
		{
			//기본값
			$css_code.= "
			<div class=\"editor_layer\" style=\"display:none\">
				<div class=\"bg\"></div>
				<div id=\"layer_pop\" class=\"pop-editor_layer\">
					<div class=\"pop-container\">

						<!--content-->
						<div id=\"editor_layer_content\" class=\"pop-conts\">
							<iframe src=\"\" width=\"0px\" height=\"0px\" id=\"editor_layer_content_frame\" scrolling=\"no\" frameborder=\"0\"></iframe>

							<!--크롬 브라우저 멀티 업로드 플래시 버그 패치 hong-->
							<script language='javascript' src='{$p}editor/happy_module/multy_image_upload/js/swf_upload_new.js'></script>
							<div id=\"editor_layer_content_multy_image\"></div>
							<!--크롬 브라우저 멀티 업로드 플래시 버그 패치 hong-->

						</div>
						<div class=\"btn-r\">
							<a href=\"#\" class=\"cbtn\">Close</a>
						</div>
					</div>
				</div>
			</div>
			";
		}

		//크롬 브라우저 멀티 업로드 플래시 버그 패치 hong
		$folder_session		= session_id();
		$admin_path			= ( preg_match("/admin\//",$_SERVER['SCRIPT_NAME']) ) ? "../" : "";
		$upFolder_name		= $admin_path."wys2/swf_upload/tmp";
		$swf_upload_id		= happy_mktime().'_'.$folder_session;

		#################### 멀티업로드 임시 파일 삭제하기 ######################################
		if(is_dir($upFolder_name))
		{
			$dir_obj	= opendir($upFolder_name);
			while( ($file_str = readdir($dir_obj)) !== false )
			{
				if ($file_str!="." && $file_str!="..")
				{
					#echo $upFolder_name."/".$file_str."<br>";

					$file_strs	= explode("_",$file_str);
					$rmdir		= $file_strs[0];
					$sess		= $file_strs[1];

					//if ( $rmdir < $delTime || $folder_session == $sess )
					if ( $folder_session == $sess ) //시간 체크 안함
					{
						$dir_obj2	=opendir($upFolder_name."/".$file_str);
						while ( ($file_str2 = readdir($dir_obj2)) !== false )
						{
							if ( $file_str2!="." && $file_str2!=".." )
							{
								@unlink($upFolder_name."/".$file_str."/".$file_str2);
								#echo $upFolder_name."/".$file_str."/".$file_str2.'<br>';
							}
						}
						closedir($dir_obj2);
						rmdir($upFolder_name."/".$file_str);
					}
				}
			}
			closedir($dir_obj);
		}
		###########################################################################################

		$css_code.= "
		<div id='multy_image_upload_container' style='display:none'>
			<div style='width:600px; height:380px;'>
				<table cellspacing='0' cellpadding='0' style='height:60px; width:100%;'>
				<tr>
					<td style='color:#fff; padding-left:20px; font-size:14px; background:#555555;'><strong>다중 이미지 업로드</strong></td>
				</tr>
				</table>

				<table cellspacing='0' cellpadding='0' style='width:100%; border-bottom:1px solid #eaeaea;'>
				<tr>
					<td style='color:#999; padding:20px; line-height:17px; background:#fbfbfb;'>
						- 여러개의 파일을 동시에 업로드하실 수 있습니다.<br>
						- 확장자가 <strong>JPG, JPEG, GIF, PNG</strong> 파일만 업로드가 가능합니다.<br>
						- 파일선택 완료후 <span style='color:#333;'><strong>[업로드]</strong></span> 버튼을 클릭해야 등록이 가능합니다.
					</td>
				</tr>
				</table>

				<!-- 플래시 파일 업로드 [ start ] -->
				<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
					<td align='center' valign='middle' style='padding-top:10px;'>

						<div id='%editor_name%_swf_upload_frame' style='display:none;'></div>
						<div id='%editor_name%_swf_upload_layer' style='margin-bottom:10px;'></div>

						<script language='javascript'>
							makeSwfMultiUploadEditor(
								editor_movie_id = '%editor_name%_swf_upload', //파일폼 고유ID
								editor_flash_width = '550', //파일폼 너비 (기본값 400, 권장최소 300)
								editor_list_rows = '7', // 파일목록 행 (기본값:3)
								editor_limit_size = '300', // 업로드 제한용량 (기본값 10)
								editor_file_type_name = '사진 선택', // 파일선택창 파일형식명 (예: 그림파일, 엑셀파일, 모든파일 등)
								editor_allow_filetype = '*.jpg *.jpeg *.gif *.png', // 파일선택창 파일형식 (예: *.jpg *.jpeg *.gif *.png)
								editor_deny_filetype = '*.php *.php3 *.php4 *.html *.inc *.js *.htm *.cgi *.pl *.jsp', // 업로드 불가형식
								editor_upload_exe = 'flash_upload.php', // 업로드 담당프로그램(multi_upload_new.swf 파일 기준으로 입력해야 함)
								editor_max_file_count = '100', //업로드제한
								editor_get_frameHeight = '0', // 드래그 플레쉬 호출할  iframe 세로크기 [여기부터 아래쪽변수 미사용시 아무값이나]
								editor_get_frameSrc = '{$p}editor/happy_module/multy_image_upload/flash_upload_end.php?editor_type=ck&editor_name=%editor_name%',	// 드래그 플레쉬 호출할 iframe 주소
								editor_flash_src = '{$p}editor/happy_module/multy_image_upload/multi_upload_new.swf',
								editor_upload_id = '{$swf_upload_id}'
							);
						</script>

					</td>
				</tr>
				</table>
				<!-- 플래시 파일 업로드 [ end ] -->
			</div>

			<div>
				<table cellspacing='0' cellpadding='0' style='width:100%; margin-top:10px; margin-bottom:10px;'>
				<tr>
					<td align='center' style='border-top:1px solid #eaeaea; padding-top:10px;'>
						<table cellspacing='0' cellpadding='0'>
						<tr>
							<td><img src='{$p}editor/img/btn_cancel.png' width='48' height='28' alt='취소' id='btn_cancel' onClick='parent.parent.editor_layer_close()'  style='cursor:pointer;'></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
		</div>
		";
		//크롬 브라우저 멀티 업로드 플래시 버그 패치 hong
	}

	if ( $wys_css_cnt == 0 )
	{
		$wys_css_cnt++;
		return $css_code;
	}
}

//{{위지윅에디터JS ckeditor,경로}}
//한페이지에 한번만 요청
$wys_js_cnt = 0;
function happy_wys_js($wys_type, $p = "")
{
	global $wys_js_cnt;
	$js_code = "";

	if ( $wys_type == "ckeditor" )
	{
		$js_code = "
		<!--  에디터 관련 SCRIPT -->
		<SCRIPT language=\"javascript\" src=\"{$p}js/glm-ajax.js\"></SCRIPT>
		<script>
		if ( !window.jQuery )
		{
			document.write(\"<sc\"+\"ript language='javascript' src='{$p}js/jquery.js'></sc\"+\"ript>\");
		}
		</script>
		<SCRIPT language=\"javascript\" src=\"{$p}editor/editor/ck/ckeditor.js\"></SCRIPT>
		<SCRIPT language=\"javascript\" src=\"{$p}editor/js/editor.js\"></SCRIPT>
		<!-- jquery 를 이용한 Ajax submit -->
		<SCRIPT language=\"javascript\" src=\"{$p}js/jquery.form.js\"></SCRIPT>
		<!--  에디터 관련 SCRIPT -->
		";
	}

	if ( $wys_js_cnt == 0 )
	{
		$wys_js_cnt++;
		return $js_code;
	}
}

//{{위지윅에디터 ckeditor,가로,세로,변수명,데이터변수명,경로,툴바,추가버튼}}
//{{위지윅에디터 ckeditor,가로100%,세로500,sch_comment,{Schedule.comment},./,happycgi_normal,image_upload+multy_image_upload+file_upload+text_image}}
function happy_wys($wys_type,$width,$height,$var_name,$wysdata,$p,$toolbar,$etc_btn="all",$topMenuType="")
{
	$wys_code = "";

	//가로
	if ( strpos($width,'%') !== false )
	{
		$width = preg_replace('/\D/','',$width).'%';
	}
	else
	{
		$width = preg_replace('/\D/','',$width);
	}

	//세로
	if ( strpos($height,'px') !== false )
	{
		$height = preg_replace('/\D/','',$height).'px';
	}
	else
	{
		$height = preg_replace('/\D/','',$height);
	}


	if ( $wys_type == "ckeditor" )
	{
		//툴바 조절
		switch($toolbar)
		{
			case "happycgi_full":
				$toolbar = "happycgi_full";
				break;
			case "happycgi_normal":
				$toolbar = "happycgi_normal";
				break;
			case "happycgi_simple":
				$toolbar = "happycgi_simple";
				break;
			case "happycgi_mini":
				$toolbar = "happycgi_mini";
				break;
			default:
				$toolbar = "happycgi_normal";
				break;
		}



		//all 일때 버튼은 다 보이도록
		//선별해서 보여줘야 할때 image_upload,multy_image_upload 식으로
		//빈값이면 하나도 안보여줌
		$etc_btn_arr		= array("image_upload","multy_image_upload","file_upload","naver_map","youtube","text_image");
		$editor_toolbox_style		= "display:none;";
		foreach($etc_btn_arr as $btn)
		{
			$css_name = $btn.'_view';
			if ( $etc_btn != "all" )
			{
				//image_upload+multy_image_upload 식으로 입력
				$etc_btn = str_replace("+",",",$etc_btn);
				$btns = explode(",",$etc_btn);
				if ( !in_array($btn,$btns) )
				{
					$$css_name = "display:none;";
				}
				else if( $editor_toolbox_style != '' )
				{
					$editor_toolbox_style		= "";
				}
			}
			else
			{
				$$css_name = "";
				$editor_toolbox_style		= "";
			}
		}

		//다중이미지 업로드 레이어 창 영역크기는 아래 옵션값을 수정하고, www/editor/happy_module/multy_image_upload/multy_image_upload.php 파일의 IFRAME 사이즈도 동일하게 변경하세요.
		//네이버 지도삽입 레이어창 영역크기는 아래 옵션값을 수정하고, www/editor/happy_module/naver_map/naver_map.php 파읠에서 영역을 감싸는 DIV의 높이값을 동일하게 변경하세요.
		/*
		$wys_code.= "
		<div style=\" width:100%;  background:url('{$p}editor/img/w_e_bg.gif') repeat-x; border:1px solid #c3c3c3; webkit-box-sizing: border-box;box-sizing:border-box;-moz-box-sizing: border-box;-o-box-sizing: border-box; border-bottom:none; \" >

			<table border=1 cellspacing='0' cellpadding='0'  style='height:36px !important; line-height:36px !important;'>
			<tr>
				<td style='padding:0 10px 0 10px !important; background: transparent;'><img src=\"{$p}editor/img/btn_image_upload.gif\" alt=\"이미지 업로드\" title=\"이미지 업로드\" onClick=\"editor_layer_open('{$var_name}','image_upload',445,505);\" style='{$image_upload_view}cursor:pointer; vertical-align:middle;'></td>
				<td style='padding:0 0 0 0 !important; background: transparent;'><img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'></td>
				<td style='padding:0 10px 0 10px !important; background: transparent;'><img src=\"{$p}editor/img/btn_images_upload.gif\" alt=\"여러개 이미지 업로드\" title=\"여러개 이미지 업로드\" onClick=\"editor_layer_open('{$var_name}','multy_image_upload',600,430);\" style='{$multy_image_upload_view}cursor:pointer; vertical-align:middle;'></td>
				<td style='padding:0 0 0 0 !important; background: transparent;'><img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'></td>
				<td style='padding:0 10px 0 10px !important; background: transparent;'><img src=\"{$p}editor/img/btn_file_upload.gif\" alt=\"파일첨부\" title=\"파일첨부\" onClick=\"editor_layer_open('{$var_name}','file_upload',445,265);\" style='{$file_upload_view}cursor:pointer; vertical-align:middle;'></td>
				<td style='padding:0 0 0 0 !important; background: transparent;'><img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'></td>
				<td style='padding:0 10px 0 10px !important; background: transparent;'><img src=\"{$p}editor/img/btn_naver_map.gif\" alt=\"네이버지도\" title=\"네이버지도\" onClick=\"editor_layer_open('{$var_name}','naver_map',760,710);\" style='{$naver_map_view}cursor:pointer; vertical-align:middle;'></td>
				<td style='padding:0 0 0 0 !important; background: transparent;'><img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'></td>
				<td style='padding:0 10px 0 10px !important; background: transparent;'><img src=\"{$p}editor/img/btn_youtube_link.gif\" alt=\"유투브\" title=\"유투브\" onClick=\"editor_layer_open('{$var_name}','youtube',445,400);\" style='{$youtube_view}cursor:pointer; vertical-align:middle;'></td>
				<td style='padding:0 0 0 0 !important; background: transparent;'><img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'></td>
				<td style='padding:0 10px 0 10px !important; background: transparent;'><img src=\"{$p}editor/img/btn_text_image.gif\" alt=\"텍스트 이미지\" title=\"텍스트 이미지\" onClick=\"editor_layer_open('{$var_name}','text_image',590,460);\" style='{$text_image_view}cursor:pointer; vertical-align:middle;'></td>
			</tr>
			</table>

		</div>";
		*/

		$naver_map_view = "display:none;";

		$wys_code.= "
		<div style=\"$editor_toolbox_style width:100%;  background:url('{$p}editor/img/w_e_bg.gif') repeat-x; border:1px solid #c3c3c3; webkit-box-sizing: border-box;box-sizing:border-box;-moz-box-sizing: border-box;-o-box-sizing: border-box; border-bottom:none; \" >

			<table border=0 cellspacing='0' cellpadding='0'  style='height:36px !important; line-height:36px !important;'>
			<tr>
				<td style='{$image_upload_view} padding:0 10px 0 10px !important; background: transparent;'>
					<img src=\"{$p}editor/img/btn_image_upload.gif\" alt=\"이미지 업로드\" title=\"이미지 업로드\" onClick=\"editor_layer_open('{$var_name}','image_upload',445,505);\" style='cursor:pointer; vertical-align:middle;'>
				</td>
				<td style='{$image_upload_view} padding:0 0 0 0 !important; background: transparent;'>
					<img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'>
				</td>
				<!-- HTML5 멀티업로드 추가 -->
				<td style='{$multy_image_upload_view} padding:0 10px 0 10px !important; background: transparent; cursor:pointer' onClick=\"editor_layer_open('{$var_name}','html5_image_upload',750,520);\">
					<img src=\"{$p}editor/img/html5_icon.gif\" alt=\"여러개 이미지 업로드\" title=\"여러개 이미지 업로드\" style='cursor:pointer; vertical-align:text-top; height:16px;'>
				</td>
				<!-- HTML5 멀티업로드 추가 -->
				<td style='{$multy_image_upload_view} padding:0 0 0 0 !important; background: transparent;'>
					<img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'>
				</td>
				<td style='{$file_upload_view} padding:0 10px 0 10px !important; background: transparent;'>
					<img src=\"{$p}editor/img/btn_file_upload.gif\" alt=\"파일첨부\" title=\"파일첨부\" onClick=\"editor_layer_open('{$var_name}','file_upload',445,265);\" style='cursor:pointer; vertical-align:middle;'>
				</td>
				<td style='{$file_upload_view} padding:0 0 0 0 !important; background: transparent;'>
					<img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'>
				</td>
				<td style='{$naver_map_view} padding:0 10px 0 10px !important; background: transparent;'>
					<img src=\"{$p}editor/img/btn_naver_map.gif\" alt=\"네이버지도\" title=\"네이버지도\" onClick=\"editor_layer_open('{$var_name}','naver_map',760,710);\" style='cursor:pointer; vertical-align:middle;'>
				</td>
				<td style='{$naver_map_view} padding:0 0 0 0 !important; background: transparent;'>
					<img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'>
				</td>
				<td style='{$daum_map_view}padding:0 10px 0 10px !important; background: transparent;'>
					<img src=\"{$p}editor/img/btn_daum_map.gif\" alt=\"다음지도\" title=\"다음지도\" onClick=\"editor_layer_open('{$var_name}','daum_map',760,710);\" style='cursor:pointer; vertical-align:middle;'>
				</td>
				<td style='{$daum_map_view}padding:0 0 0 0 !important; background: transparent;'>
					<img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'>
				</td>
				<td style='{$youtube_view} padding:0 10px 0 10px !important; background: transparent;'>
					<img src=\"{$p}editor/img/btn_youtube_link.gif\" alt=\"유투브\" title=\"유투브\" onClick=\"editor_layer_open('{$var_name}','youtube',445,400);\" style='cursor:pointer; vertical-align:middle;'>
				</td>
				<td style='{$youtube_view} padding:0 0 0 0 !important; background: transparent;'>
					<img src=\"{$p}editor/img/bg_w_line.gif\" align='absmiddle'>
				</td>
				<td style='{$text_image_view} padding:0 10px 0 10px !important; background: transparent;'>
					<img src=\"{$p}editor/img/btn_text_image.gif\" alt=\"텍스트 이미지\" title=\"텍스트 이미지\" onClick=\"editor_layer_open('{$var_name}','text_image',590,460);\" style='cursor:pointer; vertical-align:middle;'>
				</td>
			</tr>
			</table>

		</div>";

		if( $topMenuType == "mini" )
		{
			// 상단메뉴 아이콘 변경	:	| 일반이미지----------		| 미니이미지----------
			$wys_code	= str_replace(	"btn_image_upload.gif",		"btn_image_upload2.gif",	$wys_code );
			$wys_code	= str_replace(	"btn_images_upload.gif",	"btn_images_upload2.gif",	$wys_code );
			$wys_code	= str_replace(	"btn_file_upload.gif",		"btn_file_upload2.gif",		$wys_code );
			$wys_code	= str_replace(	"btn_naver_map.gif",		"btn_naver_map2.gif",		$wys_code );
			$wys_code	= str_replace(	"btn_youtube_link.gif",		"btn_youtube_link2.gif",	$wys_code );
			$wys_code	= str_replace(	"btn_text_image.gif",		"btn_text_image2.gif",		$wys_code );
		}

		if ( $wysdata != '' )
		{
			$wys_data = tpltag2value($wysdata);
		}

		$wys_code.= "<textarea id=\"{$var_name}\" name=\"{$var_name}\">$wys_data</textarea>";


		$wys_code.= "
		<script>
			/*			js/editor.js 에서 사용될 변수선언			*/
			var EDITOR_NAME				= '{$var_name}';
			var EDITOR_TYPE				= 'ck';
			var EDITOR_BASE_PATH		= '{$p}editor/';
			var EDITOR_SKIN				= '{$toolbar}';
			/*			js/editor.js 에서 사용될 변수선언			*/

			try {
				CKEDITOR.replace('{$var_name}',{
					width: '{$width}',
					height: '{$height}',
					toolbar : '{$toolbar}'
				});
			}
			catch (e) {
				alert(EDITOR_TYPE+' Editor 로딩 실패');
			}
		</script>";
	}

	return $wys_code;
}


//{BOARD.bbs_review} ==> $BOARD['bbs_review'] 란 값을 리턴
//{bbs_review} ==> $bbs_review 란 값을 리턴
function tpltag2value($str)
{
	$str = str_replace("}","",str_replace("{","",$str));

	if ( strpos($str,'.') !== false )
	{
		$tmp = explode(".",$str);
		$tmp_colname = $tmp[1];
		eval("global $".$tmp[0].";");
		$exArray = $$tmp[0];

		return $exArray[$tmp_colname];
	}
	else
	{
		$tmp = explode(".",$str);
		$tmp_colname = $tmp[1];
		eval("global $".$tmp[0].";");
		$exVar = $$tmp[0];

		return $exVar;
	}

}
########################################


function happy_referer_check()
{
	global $ssl_port;

	$domain	= str_replace(":$ssl_port","",str_replace("www.","",getenv('HTTP_HOST')));
	$domain	= str_replace(":80","",$domain);

	$referer = @parse_url(str_replace("www.","",getenv("HTTP_REFERER")));

	//print_r($domain); echo "<hr>"; print_r($referer); echo "<hr>";
	if ( $domain == $referer['host'] )
	{
		return true;
	}
	else
	{
		return false;
	}
}



function money_type_change($now_currency,$front,$center,$rear,$number_comma,$nation_type){
###현재금액,통화단위(앞,뒤),소수점뒤'0'의 갯수,국가###

//$now_currency = number_format($now_currency,$number_comma);

	if ($nation_type == "korea") {
		if ($now_currency % 10000 == 0 && $now_currency / 10000 != 0 ) {
			$now_currency = ($now_currency / 10000).$center;
		}
		else if($now_currency > 10000 )
		{
			$now_currency = floor($now_currency / 10000).$center.($now_currency % 10000).$rear;
		}
		else
		{
			$now_currency = ($now_currency % 10000).$rear;
		}
	} elseif ($nation_type == "us") {
		//사용할때 $MEMOOL[real_price] = money_type_change($MEMOOL[price1],'','','$','0','us');
		$now_currency = $rear.number_format($now_currency,0);
	}
	return $now_currency;

}



function job_type_list()
{
	#{{고용형태리스트 세로수,가로수,템플릿파일명,누락,페이징사용유무}}
	$arg_title	= array('세로수', '가로수', '템플릿파일명', '누락', '페이징사용유무','리턴');
	$arg_names	= array('heightSize', 'widthSize', 'template', 'omission', 'pagingCheck', 'return' );
	$arg_types	= array(
						'heightSize'		=> 'int',
						'widthSize'			=> 'int',
						'template'			=> '',
						'omission'			=> 'int',
						'pagingCheck'		=> 'char',
						'return'			=> 'char'
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
		#echo '$'.$arg_names[$i]. ' = '. $$arg_names[$i] .'<br>';
	}


	global $TPL, $skin_folder;
	global $listNo, $Count, $페이징,$HAPPY_CONFIG;
	global $job_arr,$JOB_TYPE;



	########### 전체검색 파트 ##########
	$searchMethod = "";




	$LIMIT			= $ex_limit * $widthSize;
	$tdWidth		= $tableWidth / $widthSize;
	$offset			= $heightSize * $widthSize;


	####################### 페이징처리 ########################
	$start			= $_GET["start"];
	$scale			= $offset;


	$Total			= count($job_arr);

	if( $start )	{ $listNo = $Total - $start; } else { $listNo = $Total; $start = 0; }
	$pageScale		= 6;




	$paging		= newPaging( $Total, $scale, $pageScale, $start, "이전", "다음", $searchMethod);
	###################### 페이징처리 끝 #######################
	$페이징		= $paging;

	if ( $pagingCheck != "페이징사용" )
	{
		$start	= 0;
	}

	#누락기능 추가
	if ($omission ) {
		$start = $start+$omission;
	}
	#누락기능 추가


	#echo $Sql."<br>";

	$content	= "<table cellspacing='0' cellpadding='0' style='table-layout:fixed; width:100%; border-collapse: collapse'>\n<tr>\n";
	$Count		= 0;

	$random	= rand()%1000;
	if ( !is_file($skin_folder."/".$template) )
	{
		return print"<font color='red'>$skin_folder/$template 파일이 존재하지 않습니다.</font>";
	}
	$TPL->define("고용형태_$random", $skin_folder."/".$template);


	for ($pp=0;$pp<$Total;$pp++)
	{
		$title_style						= "rsum_on";
		$JOB_TYPE['title_style']			= "";
		if($pp == 0)
		{
			$JOB_TYPE['title']				= "전체";

			if($_GET['job_type_read'] == "")
			{
				$JOB_TYPE['title_style']		= $title_style;
			}
		}
		else
		{
			$JOB_TYPE['title']				= $job_arr[$pp];
			$JOB_TYPE['title_encode']		= urlencode($job_arr[$pp]);

			if($_GET['job_type_read'] == $JOB_TYPE['title'])
			{
				$JOB_TYPE['title_style']	= $title_style;
			}
		}


		$product	 = &$TPL->fetch("고용형태_$random");
		$content	.= "<td width='$tdWidth'  height='22' align='center' valign='top' class='rsum'>".$product."\n";

		$content	.= "</td>\n";

		$Count++;
		if ( $Count % $widthSize == 0 ){	$content .= "</tr><tr>\n";	}
		$listNo--;
	}



	if ( $Count % $widthSize != 0 )
	{
		for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
		{
			//$content	.= "<td >&nbsp;</td>\n";
		}
		//$content	.= "</tr><tr><td colspan='$widthSize' background=img/img_dot.gif height=1></td>";
	}

	$content	.= "</tr>\n";
	$content	.= "</table>";


	if ( $Count == 0 && $return != 'return')
	{
		$content	= "<table height='100' border='0' width='100%'><tr><td align='center' style='color:gray;'><div style='background:rgba(0,0,0,0.4); border-radius:5px; text-align:center;'><p class='font_16 noto400' style='color:#fff; padding:15px;'>검색된 내역이 없습니다.</p></div></td></tr></table>";
	}


	$페이징		= $paging;

	if ( $return == 'return' )
		return $content;
	else
		return print $content;
}

//채용정보 열람 사용자 인원수 체크 hong
function guin_detail_view_check($guin_number='')
{
	global $cookie_url;
	global $guin_detail_view_log;
	global $HAPPY_CONFIG;
	global $happy_member_login_value;

	if ( $guin_number == '' ) return 0;

	$check_time		= preg_replace('/\D/', '', $HAPPY_CONFIG['guin_detail_view_time']);

	if ( $check_time != '' )
	{
		$Sql			= "
							DELETE FROM
									$guin_detail_view_log
							WHERE
									guin_number		= '$guin_number'
									AND
									log_date		< DATE_ADD(NOW(),INTERVAL -{$check_time} HOUR)
		";
		query($Sql);
	}

	$user_ip		= $_SERVER['REMOTE_ADDR'];
	$user_id		= $_COOKIE['guin_detail_view_id'];

	if ( $_COOKIE['guin_detail_view_id'] == "" )
	{
		$user_id		= ( $happy_member_login_value == '' ) ? "비회원" : $happy_member_login_value;
		$user_id		.= "-" . happy_mktime() . rand(1,100);

		setcookie("guin_detail_view_id",$user_id,0,"/",$cookie_url);
	}


	switch ( $HAPPY_CONFIG['guin_detail_view_check_type'] )
	{
		case 'browser' :
			$WHERE		= " AND user_id = '$user_id' ";
			$GROUP_BY	= " GROUP BY user_id ";
		break;

		case 'ip' :
			$WHERE		= " AND user_ip = '$user_ip' ";
			$GROUP_BY	= " GROUP BY user_ip ";
		break;

		default :
			$WHERE		= "";
			$GROUP_BY	= "";
		break;
	}

	$insert_ok		= true;

	if ( $HAPPY_CONFIG['guin_detail_view_check_type'] != 'no' )
	{
		$Sql			= "
							SELECT
									COUNT(*)
							FROM
									$guin_detail_view_log
							WHERE
									guin_number		= '$guin_number'
									$WHERE
		";
		list($already)	= happy_mysql_fetch_array(query($Sql));

		$insert_ok		= ( $already == 0 ) ? true : false;
	}

	if ( $insert_ok == true )
	{
		$Sql			= "
							INSERT INTO
									$guin_detail_view_log
							SET
									guin_number		= '$guin_number',
									user_id			= '$user_id',
									user_ip			= '$user_ip',
									log_date		= NOW()
		";
		query($Sql);
	}

	if ( $check_time != '' )
	{
		$Sql			= "
							SELECT
									*
							FROM
									$guin_detail_view_log
							WHERE
									guin_number		= '$guin_number'
									AND
									log_date		> DATE_ADD(NOW(),INTERVAL -{$check_time} HOUR)
							$GROUP_BY
		";
		$count			= mysql_num_rows(query($Sql));

		return $count;
	}

	return 0;
}



function happy_menu_style($Menu)
{
	global $menu_style_max, $menu_styls;


	if ( $menu_style_max > 0 )
	{
		$styles			= '';
		for ( $i=1 ; $i<=$menu_style_max ; $i++ )
		{
			$nowValues		= explode('|', $Menu['style'.$i]);
			$nowValue		= Array();
			$start			= '';
			$end			= '';
			$style			= '';
			foreach ( $nowValues AS $key => $val )
			{
				if ( $menu_styls[$val]['type'] == 'tag' )
				{
					$start			= $start. $menu_styls[$val]['start'];
					$end			= $menu_styls[$val]['end'].$end;
				}
				else if ( $menu_styls[$val]['type'] == 'style' )
				{
					$style			= $style.$menu_styls[$val]['start'].';';
				}
			}

			$Menu['style'.$i.'_start']	= $start;
			$Menu['style'.$i.'_end']	= $end;
			$Menu['style'.$i.'_style']	= " style=\"$style\" ";
			if ( $Menu['style'.$i.'_icon'] != '' )
			{
				$Menu['style'.$i.'_icon']	= "<div style='display:inline; margin-left:3px;'><img src='".$Menu['style'.$i.'_icon']."' border='0' ></div>";
			}

		}
	}
	return $Menu;
}



# 메뉴출력 함수
# {{메뉴출력 세로1개,가로10개,대메뉴,1000,happy_menu_rows.html}}
# {{메뉴출력 세로1개,가로10개,전체,1000,happy_menu_rows2.html,서브세로10개,서브가로1개,happy_menu_rows_sub.html,게시물개수추출}}
# {{메뉴출력 세로10개,가로1개,서브메뉴:영화,1000,happy_menu_rows_sub.html}}
# {{메뉴출력 세로10개,가로1개,서브메뉴:뉴스&매거진,1000,happy_menu_rows_sub.html}}
$depth0_menu_arr	= '';
$happy_menu_list_sub_number	= '';
$happy_menu_list_count = 0;
function happy_menu_list()
{

	# 추출 가능한 태그 없음 // php로 함수를 다이렉트 호출한후 리턴되는 값을 변수로 담아서 사용

	$arg_title	= array('세로수','가로수','메뉴호출방식','테이블크기','템플릿','서브메뉴세로수', '서브메뉴가로수', '템플릿2', '게시물개수추출');
	$arg_names	= array('heightSize','widthSize','menuType','tableWidth','openFile', 'heightSize2', 'widthSize2', 'openFile2', 'boardCounter');
	$arg_types	= array(
						'heightSize'		=> 'int',
						'widthSize'			=> 'int',
						'heightSize2'		=> 'int',
						'widthSize2'		=> 'int',
						'tableWidth'		=> 'char', # 모바일솔루션
						'menuType'			=> 'char',
						'imgWidth'			=> 'int',
						'boardCounter'		=> 'char'
				);

	for($i=0, $max=func_num_args() ; $i<$max ; $i++)
	{
		$value	= func_get_arg($i);
		switch ( $arg_types[$arg_names[$i]] )
		{
			case 'int':		$$arg_names[$i]	= preg_replace('/\D/','',$value);break;
			case 'char':	$$arg_names[$i]	= preg_replace('/\n/','',$value);break;
			default :		$$arg_names[$i]	= $value;break;
		}
	}


	global $HAPPY_CONFIG, $TPL, $happy_member_skin_folder, $happy_menu, $happy_menu_icon_group;
	global $happy_schedule_links_number_out, $Menu, $하부메뉴, $board_list, $Count, $path;

	# 모바일솔루션
	global $where_mobile, $now_url_Number, $배경색;

	global $depth0_menu_arr, $now_url_TopNumber, $now_url_SubNumber, $happy_menu_list_sub_number, $happy_menu_list_sub_sub_number;
	global $now_url_NowNumber, $happy_menu_list_count;

	#echo $now_url_Number.':::'.$now_url_TopNumber.':::'.$now_url_SubNumber;

	$happy_menu_list_count++;

	$addPercent			= '';
	$percentChk			= preg_replace('/\D/', '', $tableWidth);
	if ( $tableWidth == $percentChk.'%' )
	{
		$addPercent			= '%';
	}



	$LIMIT				= $heightSize * $widthSize;
	$tdWidth			= $tableWidth / $widthSize;
	$Templete_File		= $happy_member_skin_folder."/".$openFile;
	$Templete_File2		= $happy_member_skin_folder."/".$openFile2;

	$search_page		= "";
	$Date				= date("Y-m-d");

	$menuType			= explode(':', $menuType);
	$menuTypeVal		= $menuType[1];
	$menuType			= $menuType[0];

	$nowDate			= date("Y-m-d");
	$random				= rand()%10000;

	if ( $menuType == "" ) {
		return "<font color='red'>출력할 메뉴호출방식을 지정하지 않으셨습니다.</font>";
	}
	else if ( $widthSize == "" || $widthSize == 0 ) {
		return "<font color='red'>가로출력 개수를 지정하지 않으셨습니다.</font>";
	}
	else if ( $heightSize == "" || $heightSize == 0 ) {
		return "<font color='red'>세로출력 개수를 지정하지 않으셨습니다.</font>";
	}


	# 모바일솔루션
	$mainWidthPer		= '';
	$mainWidthStyle		= '';
	$subWidthPer		= '';
	$subWidthStyle		= '';
	if ( $_COOKIE['happy_mobile'] == 'on' )
	{
		if ( $widthSize != 0 )
		{
			$mainWidthPer		= ($menuType == '서브메뉴' || $menuType == '소속메뉴')? round(100 / $widthSize).'%' : '';
			$mainWidthStyle		= $menuType == '서브메뉴'? "" : '';
		}

		if ( $widthSize2 != 0 )
		{
			$subWidthPer		= round(100 / $widthSize2).'%';
			$subWidthStyle		= "";
		}
	}
	# 모바일솔루션




	$WHERE				= "";
	$tdValign			= "";


	if ( $menuType == '전체' )
	{
		$tdValign			= " valign='top' ";
		if ( $heightSize2 == '' )
		{
			$heightSize2		= $heightSize;
		}
		if ( $widthSize2 == '' )
		{
			$widthSize2			= $widthSize;
		}
		$LIMIT2				= $heightSize2 * $widthSize2;

		$TPL->define("메뉴출력2_$random", $Templete_File2);

		$WHERE				.= " WHERE menu_depth = '0' ";
	}
	else if ( $menuType == '대메뉴' )
	{
		$WHERE				.= " WHERE menu_depth = '0' ";
	}
	else if ( $menuType == '서브메뉴' )
	{
		//모바일솔루션
		if ( $menuTypeVal == '전체' )
		{
			$WHERE				.= " WHERE menu_depth = '1'";
		}
		//모바일솔루션
		else if ( $menuTypeVal == '자동' )
		{
			happy_menu_nowPage('all'); //display 상관없이 모두 체크하자

			if ( $now_url_TopNumber == '' )
			{
				return print '현재위치 파악 불가.';
			}
			$WHERE				.= " WHERE menu_depth = '1' AND menu_parent='$now_url_TopNumber' ";
		}
		//모바일솔루션
		else
		{
			$Sql				= "SELECT number FROM $happy_menu WHERE menu_name='$menuTypeVal' AND menu_depth='0' $where_mobile ";
			#echo $Sql;
			$Tmp				= happy_mysql_fetch_array(query($Sql));

			if ( $Tmp['number'] == '' )
			{
				return print '존재하지 않는 대메뉴 입니다.';
			}

			$WHERE				.= " WHERE menu_depth = '1' AND menu_parent = '$Tmp[number]'";
		}
	}
	else if ( $menuType == '자동서브메뉴' )
	{
		if ( $depth0_menu_arr == '' )
		{
			return print '자동서브메뉴 추출 옵션은 대메뉴 추출 태그 이후 사용 하셔야 됩니다.';
		}

		if ( sizeof($depth0_menu_arr) == 0 )
		{
			return '';
		}

		$n_menu_parent		= $depth0_menu_arr[0];
		array_shift($depth0_menu_arr);
		$WHERE				.= " WHERE menu_depth = '1' AND menu_parent = '$n_menu_parent'";

	}
	else if ( $menuType == '현재위치3차메뉴' )
	{
		if ( $now_url_SubNumber != $happy_menu_list_sub_number )
		{
			return '';
		}

		$WHERE				.= " WHERE menu_parent = '$happy_menu_list_sub_number'";

	}
	else if ( $menuType == '소속메뉴' )
	{
			$WHERE				.= " WHERE menu_depth = '2' AND menu_parent='$happy_menu_list_sub_sub_number' ";
			$Count3				= 0;
	}


	//헤드헌팅 메뉴 여부 hong
	global $hunting_use;

	if ( $hunting_use == true )
	{
		$hunting_use_where	= " AND menu_hunting_use != 'c' ";
	}
	else
	{
		$hunting_use_where	= " AND menu_hunting_use != 'y' ";
	}

	//내주변검색 모바일 메뉴 여부 hong
	global $happy_mobile_basic_use, $happy_mobile_geo_location_use;

	if ( $happy_mobile_geo_location_use != '' )
	{
		$geo_use_where		= " AND menu_geo_use != 'c' ";
	}
	else
	{
		$geo_use_where		= " AND menu_geo_use != 'y' ";
	}


	$order				= "ORDER BY menu_sort ASC";

	$Sql				= "SELECT * FROM $happy_menu $WHERE AND display = '1' $where_mobile $hunting_use_where $geo_use_where $order LIMIT 0,$LIMIT";	#모바일솔루션
	#echo $Sql;
	$Record				= query($Sql);

	$content			= "";
	if ( $tableWidth != '' && $tableWidth != '0' )
	{
		$id_html	= "";
		if ( $menuType == '소속메뉴' )
		{
			$id_html	= " id=\"menu_habu_3_$happy_menu_list_sub_sub_number\" ";
		}
		$content			.= "<table align='left' valign='top' width='$tableWidth{$addPercent}' border='0' cellpadding='0' cellspacing='0' $id_html>\n<tr>\n";
	}

	if ( $menuType != '소속메뉴' )
	{
		$Count				= 0;
	}

	$TPL->define("메뉴출력_$random", $Templete_File);

	if ( $menuType == '대메뉴' )
	{
		$depth0_menu_arr	= Array();
	}

	while ( $Menu = happy_mysql_fetch_array($Record) )
	{
		if ( $menuType != '소속메뉴' )
		{
			$Count++;
			$happy_menu_list_sub_sub_number	= $Menu[number];
		}

		// 최근게시글 뉴 아이콘
		if( $menuType == '자동서브메뉴' || $menuType == '서브메뉴' || $menuType == '현재위치3차메뉴' )
		{
			//$tmp_url	= array();
			preg_match_all("/(?<=\?).+$/i", $Menu['menu_link'], $tmp_url_preg_match);
			$tmp_url_explode			= explode("&",$tmp_url_preg_match[0][0]);
			foreach($tmp_url_explode as $k => $v)
			{
				$v_explode		= explode("=",$v);
				if( $v_explode[0] == 'tb' )
				{
					$tmp_url[$v_explode[0]] = $v_explode[1];
				}
			}

			if( $menuType == '현재위치3차메뉴' )
			{
				$Menu['new_icon']	= new_bbs_ok($tmp_url['tb'],'테이블명',$Menu['menu_name']);
			}
			else
			{
				$Menu['new_icon']	= new_bbs_ok($tmp_url['tb'],'테이블명');
			}
		}

		// 현재페이지
		if ( $now_url_Number == $Count )
		{
			$Menu['ChoiceTagStart']	= "<span style='color:#{$배경색[모바일_메인메뉴_오버]};'>";
			$Menu['ChoiceTagEnd']	= "</span>";
		}

		// 서브 현재페이지
		$Menu['NowMenuClassName']	= "hmlc_".$happy_menu_list_count."_".$Menu['number'];
		$Menu['NowMenuClassOnName']	= "hmlc_on_".$happy_menu_list_count."_".$Menu['number'];

		$Menu['NowMenuClass']		= $Menu['NowMenuClassName'];

		//if ( $now_url_NowNumber == $Menu['number'] ) //3차까지 모두 적용시 이 주석을 사용하세요
		if ( $now_url_SubNumber == $Menu['number'] )
		{
			$Menu['NowMenuClass']		= $Menu['NowMenuClassOnName'];
		}

		if ( $menuType == '대메뉴' )
		{
			$depth0_menu_arr[]	= $Menu['number'];
		}
		else if ( $menuType != '소속메뉴' )
		{
			$happy_menu_list_sub_number	= $Menu['number'];
		}


		$Menu				= happy_menu_style($Menu);

		$Menu['menu_name_encode']	= urlencode($Menu['menu_name']);

		#print_r2($Menu);

		# 사이즈 뽑기
		if ( $Menu['menu_icon1'] != "" )
		{
			//$image_size_tmp		= GetImageSize($_SERVER['DOCUMENT_ROOT']."/".$Menu['menu_icon1']);
			$image_size_tmp		= GetImageSize($path.$Menu['menu_icon1']);
			$Menu['width_size']	= $image_size_tmp[0];
			$Menu['height_size']	= $image_size_tmp[1];
		}

		# 하부메뉴 추출 부분 시작
		if ( $menuType == '전체' )
		{
			$MenuTmp			= $Menu;
			$Sql				= "SELECT * FROM $happy_menu WHERE menu_parent='$Menu[number]' AND menu_depth='1' AND display = '1' $hunting_use_where $geo_use_where $order LIMIT 0,$LIMIT2";
			$subRecord			= query($Sql);

			$Count2				= 0;


			$하부메뉴			= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0'>\n<tr>\n";
			while ( $Menu = happy_mysql_fetch_array($subRecord) )
			{
				if( $_COOKIE['happy_mobile'] == 'on' )
				{
					$Sql		= "SELECT count(*) FROM $happy_menu WHERE menu_parent='$Menu[number]' AND menu_depth='2' AND display = '1'";
					$depth3count	= mysql_fetch_row(query($Sql));

					if( $depth3count[0] > 0 )
					{
						$Menu['depth3img']	= "<img src=\"mobile_img/icon_category_more.png\" alt=\"\" title=\"\" style=\"width:12px; height:12px; cursor:pointer;\" onclick=\"if( document.getElementById('menu_habu_3_$Menu[number]').style.display == '' ) { document.getElementById('menu_habu_3_$Menu[number]').style.display = 'none'; } else { document.getElementById('menu_habu_3_$Menu[number]').style.display = ''; }\">";
					}
					else
					{
						$Menu['depth3img']	= "<img src=\"mobile_img/icon_more2.png\" style=\"width:6px; height:10px;\" alt=\"더보기\" title=\"더보기\" >";
					}
				}

				if ( $menuType != '소속메뉴' )
				{
					$happy_menu_list_sub_sub_number	= $Menu[number];
				}
				$Count2++;
				$Menu				= happy_menu_style($Menu);
				$Menu['CountView']	= " style='display:none' ";
				$Menu['CountView2']	= "display:none;";

				if ( $boardCounter == '게시물개수추출' )
				{
					$nowLink			= explode('tb=', $Menu['menu_link']);
					$nowLink[1]			= explode('&', $nowLink[1]);
					$nowLink[1]			= $nowLink[1][0];

					//2016-02-24 sum부분업그레이드(게시판 카테고리별 카운팅기능추가)
					$catLink			= explode('b_category=', $Menu['menu_link']);
					$catLink[1]			= explode('&', $catLink[1]);
					$catLink[1]			= urldecode($catLink[1][0]);

					if($catLink[1] != '')
					{
						$CAT_WHERE = " WHERE b_category='$catLink[1]' ";
					}
					else
					{
						$CAT_WHERE = "";
					}
					//2016-02-24 sum부분업그레이드(게시판 카테고리별 카운팅기능추가)

					if ( $nowLink[1] != '' )
					{
						$Sql				= "SELECT Count(*) FROM $board_list WHERE tbname='$nowLink[1]' ";
						$BCount				= happy_mysql_fetch_array(query($Sql));

						if ( $BCount[0] > 0 )
						{
							$Sql				= "SELECT Count(*) FROM $nowLink[1] $CAT_WHERE";
							#echo $Sql;
							$BCount				= happy_mysql_fetch_array(query($Sql));
							$Menu['boardCount']	= $BCount[0];
							$Menu['CountView']	= '';
							$Menu['CountView2']	= '';
						}
						#echo $Sql.':::'.$BCount[0].'<br>';
					}
				}

				$product2			= $TPL->fetch("메뉴출력2_$random");

				$하부메뉴			.= "<td style='width:{$subWidthPer};$subWidthStyle'>".$product2;
				$하부메뉴			.= "</td>\n";
				if ( $Count2 % $widthSize2 == 0 )
				{
					$하부메뉴		.= "</tr><tr>\n";
				}
			}

			if ( $Count2 % $widthSize2 != 0 )
			{
				for ( $i=$Count2%$widthSize2 ; $i<$widthSize2 ; $i++ )
				{
					$하부메뉴			.= "<td style='width:{$subWidthPer};$subWidthStyle'>&nbsp;</td>\n";
				}
			}
			$하부메뉴			.= "</tr>\n";
			$하부메뉴			.= "</table>";
			$Menu				= $MenuTmp;
		}
		# 하부메뉴 추출 부분 종료

		if ( $menuType == '소속메뉴' )
		{
			$Count3++;
		}

		if( $Count2 == "" )
		{
			$Menu['하부디스플레이']	= " display:none; ";
		}
		else
		{
			$Menu['하부디스플레이']	= "";
		}


		$Menu['CountView']	= " style='display:none' ";
		$Menu['CountView2']	= "display:none;";

		#echo $boardCounter;
		if ( $boardCounter == '게시물개수추출' )
		{
			$nowLink			= explode('tb=', $Menu['menu_link']);
			$nowLink[1]			= explode('&', $nowLink[1]);
			$nowLink[1]			= $nowLink[1][0];

			//2016-02-24 sum부분업그레이드(게시판 카테고리별 카운팅기능추가)
			$catLink			= explode('b_category=', $Menu['menu_link']);
			$catLink[1]			= explode('&', $catLink[1]);
			$catLink[1]			= urldecode($catLink[1][0]);

			if($catLink[1] != '')
			{
				$CAT_WHERE = " WHERE b_category='$catLink[1]' ";
			}
			else
			{
				$CAT_WHERE = "";
			}
			//2016-02-24 sum부분업그레이드(게시판 카테고리별 카운팅기능추가)

			if ( $nowLink[1] != '' )
			{
				$Sql				= "SELECT Count(*) FROM $board_list WHERE tbname='$nowLink[1]' ";
				$BCount				= happy_mysql_fetch_array(query($Sql));

				if ( $BCount[0] > 0 )
				{
					$Sql				= "SELECT Count(*) FROM $nowLink[1] $CAT_WHERE";
					$BCount				= happy_mysql_fetch_array(query($Sql));
					$Menu['boardCount']	= $BCount[0];
					$Menu['CountView']	= '';
					$Menu['CountView2']	= '';
				}
				#echo $Sql.':::'.$BCount[0].'<br>';
			}
		}

		$product			= &$TPL->fetch("메뉴출력_$random");

		if ( $tableWidth != '' && $tableWidth != '0'  )
		{
			$content			.= "<td $tdValign align='center' style='width:{$mainWidthPer};$mainWidthStyle'>".$product;
			$content			.= "</td>\n";
			if ( ($Count % $widthSize == 0 && $menuType != '소속메뉴') || ($Count3 % $widthSize == 0 && $menuType == '소속메뉴')  )
			{
				$content			.= "</tr><tr>\n";
			}
		}
		else
		{
			//$content			.= $product."<br>\n";
			$content			.= $product."\n"; // 모바일솔루션
		}
	}


	if ( $tableWidth != '' && $tableWidth != '0' )
	{
		if ($Count % $widthSize != 0 && $menuType != '소속메뉴')
		{
			for ( $i=$Count%$widthSize ; $i<$widthSize ; $i++ )
			{
				$content			.= "<td width='$tdWidth' style='width:{$mainWidthPer};$mainWidthStyle'>&nbsp;</td>\n";
			}
		}
		else if ($Count3 % $widthSize != 0 && $menuType == '소속메뉴')
		{
			for ( $i=$Count3%$widthSize ; $i<$widthSize ; $i++ )
			{
				$content			.= "<td width='$tdWidth' style='width:{$mainWidthPer};$mainWidthStyle'>&nbsp;</td>\n";
			}
		}
	}

	if ( $tableWidth != '' && $tableWidth != '0' )
	{
		$content			.= "</tr>\n";
		$content			.= "</table>";
	}


	return print $content;

	##################### 추출종료 #####################


}






##################### 현재위치 값 전송 처리 #####################

$now_url_Number		= 0;
$now_url_TopNumber	= '';
$now_url_TopTitle	= '';
$now_url_SubNumber	= '';
$now_url_NowNumber	= '';
$now_url_Check		= Array(
							'now_url_count'		=> 0,
							'now_url_number'	=> 0,
							'now_url_TopNumber'	=> '',
							'now_url_TopTitle'	=> '',
							'now_url_SubNumber'	=> '',
							'now_url_NowNumber'	=> ''
);
$happy_menu_numbers	= '';
function happy_menu_nowPage($display = '')
{

	global $HAPPY_CONFIG, $TPL, $happy_member_skin_folder, $happy_menu, $happy_menu_icon_group;
	global $now_url_Number, $now_url_TopNumber, $now_url_TopTitle, $now_url_SubNumber, $now_url_Check, $happy_menu_numbers;
	global $now_url_NowNumber;
	global $where_mobile; //모바일솔루션

	$display_where		= $display == "all" ? "" : " AND display = '1'";

	$Sql				= "SELECT * FROM $happy_menu WHERE menu_depth = '0' $display_where $where_mobile ORDER BY menu_sort ASC ";//모바일솔루션
	$Record				= query($Sql);

	$Count				= 0;

	while ( $Menu = happy_mysql_fetch_array($Record) )
	{
		$Count++;
		$nTopNumber			= $Menu['number'];
		$nTopTitle			= $Menu['menu_name'];
		$nNowNumber			= $Menu['number'];

		$now_url_Check		= now_url_Check($now_url_Check, $Menu['menu_link'], $Count, $nTopNumber,'',$nTopTitle, $nNowNumber);


		# 하부메뉴 추출 부분 시작
		$MenuTmp			= $Menu;
		$Sql				= "SELECT * FROM $happy_menu WHERE menu_parent='$Menu[number]' AND menu_depth='1' $display_where $where_mobile";//모바일솔루션
		$subRecord			= query($Sql);


		$하부메뉴			= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0'>\n<tr>\n";
		while ( $Menu = happy_mysql_fetch_array($subRecord) )
		{
			$nSubNumber			= $Menu['number'];
			$nNowNumber			= $Menu['number'];

			$now_url_Check		= now_url_Check($now_url_Check, $Menu['menu_link'], $Count, $nTopNumber, $nSubNumber, $nTopTitle, $nNowNumber);

			# 3차메뉴 추출 부분 시작
			$MenuTmp			= $Menu;
			$Sql				= "SELECT * FROM $happy_menu WHERE menu_parent='$Menu[number]' AND menu_depth='2' $display_where $where_mobile";//모바일솔루션
			$subRecord2			= query($Sql);


			$하부메뉴			= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0'>\n<tr>\n";
			while ( $Menu = happy_mysql_fetch_array($subRecord2) )
			{
				$nNowNumber			= $Menu['number'];

				$now_url_Check		= now_url_Check($now_url_Check, $Menu['menu_link'], $Count, $nTopNumber, $nSubNumber, $nTopTitle, $nNowNumber);
			}
		}

	}

	$now_url_Number		= $now_url_Check['now_url_number'];
	$now_url_TopNumber	= $now_url_Check['now_url_TopNumber'];
	$now_url_TopTitle	= $now_url_Check['now_url_TopTitle'];
	$now_url_SubNumber	= $now_url_Check['now_url_SubNumber'];
	$now_url_NowNumber	= $now_url_Check['now_url_NowNumber'];


}



# $Arr 은 옆의 Array값이 넘어오면 됨 Array( 'now_url_count'		=> 0, 'now_url_number'	=> 0 )
# now_url_count는 현재 고유번호가 선택된 매칭횟수
# now_url_number는 현재 고유번호
$check_Arr	= Array();
function now_url_Check( $Arr, $Link, $Cnt, $nTopNumber, $nSubNumber='' , $nTopTitle='', $nNowNumber='')
{
	global $check_Arr;
	$now_url		= @parse_url($_SERVER['REQUEST_URI']);
	$url			= @parse_url($Link);

	$match_Count	= 0;


	# 호출된 파일명이 같은경우 +1점
	if ( $now_url['path'] == $url['path'] || $now_url['path'] == '/'.$url['path'] )
	{
		$match_Count++;
	}


	# 인자값 비교하기
	$now_url_q		= convertUrlQuery($now_url['query']);
	$url_q			= convertUrlQuery($url['query']);

	foreach ( $url_q AS $key => $value )
	{
		if ( $value == $now_url_q[$key] && $value != '' )
		{
			$match_Count++;
		}
	}

	# 기존값 ($Arr)과 match_Count 비교해서 클 경우 현재링크값 ($Cnt)로 배열값 변경후 리턴
	if ( $Arr['now_url_count'] < $match_Count )
	{
		$Arr['now_url_count']		= $match_Count;
		$Arr['now_url_number']		= $Cnt;
		$Arr['now_url_TopNumber']	= $nTopNumber;
		$Arr['now_url_TopTitle']	= $nTopTitle;
		$Arr['now_url_SubNumber']	= $nSubNumber;
		$Arr['now_url_NowNumber']	= $nNowNumber;
	}





	$check_Arr[sizeof($check_Arr)]	= Array(
											'LINK'		=> $Link,
											'COUNT'		=> $match_Count,
											'NUMBER'	=> $Cnt
	);

	return $Arr;
}

happy_menu_nowPage();
#print_r2($check_Arr);

$현재메뉴명 = happy_menu_now_menu_name();
function happy_menu_now_menu_name()
{
	global $my;
	global $search_mode;
	global $now_url_NowNumber, $happy_menu;


	if ( $my == "1" )
	{
		$현재메뉴명 = "맞춤";
	}
	else
	{
		if ( $search_mode == "all" )
		{
			$현재메뉴명 = "전체";
		}
		else if ( $search_mode == "search" )
		{
			$현재메뉴명 = "검색된";
		}
		else
		{
			//$현재메뉴명 = "현재메뉴의이름이 먼데?";
			if ( $now_url_NowNumber != "" )
			{
				$sql		= "SELECT * FROM $happy_menu WHERE number = '$now_url_NowNumber' ";
				$result		= query($sql);
				$Mmm		= happy_mysql_fetch_assoc($result);

				$현재메뉴명 = $Mmm['menu_name'];
			}
			else
			{
				$현재메뉴명 = "직종별";
			}
		}
	}

	return $현재메뉴명;
}


##################### 현재위치 값 전송 종료 #####################



// 최근게시글 뉴 아이콘
// 새글확인 게시판명칭
function new_bbs_ok($tbname,$type = '테이블명',$b_category = '')
{
	if( $tbname == '' ) return;

	global $board_list,$new_icon_url,$HAPPY_CONFIG;

	if ( $_COOKIE['happy_mobile'] == 'on' ) // 모바일솔루션
	{
		$new_icon_url		= $HAPPY_CONFIG['m_icon_new'];
		$new_button_size	= mobile_btn_size_return('m_icon_new');
	}
	else
	{
		$new_icon_url		= $HAPPY_CONFIG['IconNew1'];
	}

	if($type == '테이블명')
	{
		//$chk[0]		= $tbname;
		$sql		= "SELECT tbname FROM $board_list WHERE tbname = '$tbname'";
		$chk		= mysql_fetch_row(query($sql));
	}
	else
	{
		$sql		= "SELECT tbname FROM $board_list WHERE board_name = '$tbname'";
		$chk		= mysql_fetch_row(query($sql));
	}

	if( $chk[0] != '')
	{
		$b_category_sql = ( $b_category != '' ) ? " AND b_category = '{$b_category}'" : "";
		$sql	= "select count(*) from $chk[0] where bbs_date > DATE_ADD(now(), INTERVAL -24 hour) {$b_category_sql}";
		$chk	= mysql_fetch_row(query($sql));

		if($chk[0] > 0 && $new_icon_url != '')
		{
			$new_icon				= "<img src='".$new_icon_url."' $new_button_size>";
			return $new_icon;

		}
		else
		{
			return;
		}
	}
	else
	{
		return;
	}
}


//에디터 네이버지도 모바일 크기 조절 - ranksa
function mobile_naver_map_replace($content_val)
{
	global $m_version;

	if( $m_version && $_COOKIE['happy_mobile'] == 'on' )
	{
		if(preg_match("/naver_map/",$content_val))
		{
			$N_MAP_SIZE		= Array();
			preg_match_all("/naver.maps.Size\([^()]+\)/",$content_val,$N_MAP_SIZE);

			if(sizeof($N_MAP_SIZE) > 0)
			{
				foreach($N_MAP_SIZE AS $M_CODE)
				{
					foreach($M_CODE AS $n_val)
					{
						$n_val_ex		= explode(",",$n_val);
						$n_map_width	= preg_replace("/\D/", "", $n_val_ex[0]);
						$n_map_height	= preg_replace("/\D/", "", $n_val_ex[1]);

						//아이콘 크기를 걸러내기위함
						if($n_map_width > 200)
						{
							$content_val		= str_replace("naver.maps.Size($n_map_width,$n_map_height)","naver.maps.Size(300,300)",$content_val);
							$content_val		= str_replace("/editor/happy_module/naver_map/images/naver_map_intro.jpg","",$content_val);
						}
					}
				}
			}
		}
	}

	return $content_val;
}

//{{모바일이미지업로드 총20개,20MB,가로3개}}
function happy_mobile_image_upload($img_count,$file_size=20,$ex_width,$iframe_style)
{
	$img_count				= preg_replace("/\D/", "", $img_count);
	$ex_width				= preg_replace("/\D/", "", $ex_width);
	$file_size				= preg_replace("/\D/", "", $file_size);
	$multi_upload_contents	= "";

	if( $img_count < 1 )
	{
		return;
	}
	else
	{
		$file_contents			= "";
		for( $i = 0 ; $i < $img_count ; $i++ )
		{
			$file_contents			.= "		<input type=hidden name='img".$i."' id='img".$i."' value='' size=60>\n";
		}
		echo "$file_contents
		<iframe id='flash_no_iframe' src='./happy_mobile_image_upload.php?img_count=${img_count}&file_size=${file_size}&ex_width=${ex_width}&number=$_GET[number]' style='$iframe_style border:0px;' frameborder='0' scrolling=''></iframe>";
	}
}


//{{네이버톡톡버튼 style="border:0px;"}}
function naver_talktalk_btn($style_tag)
{
	global $HAPPY_CONFIG;
	global $demo_lock;

	$tag = "";

	if( $demo_lock == "1" || preg_match("/aaa\.com/i",$_SERVER['HTTP_HOST']) )
	{
		$HAPPY_CONFIG['naver_talk_id'] = "demo";
	}

	if( $HAPPY_CONFIG['naver_talk_id'] != "" )
	{
		if ( $_COOKIE['happy_mobile'] == "on" )
		{
			$HAPPY_CONFIG['naver_talk_img'] = $HAPPY_CONFIG['naver_talk_img_mobile'];
		}

		$talktalk_link			= 'https://talk.naver.com/'.$HAPPY_CONFIG['naver_talk_id'].'?ref=\'+encodeURIComponent(location.href)';
		if( $HAPPY_CONFIG['naver_talk_id'] == 'demo' )
		{
			$talktalk_link			= ( $_COOKIE['happy_mobile'] == 'on' )? "naver_talktalk_mobile.html'" : "naver_talktalk.html'";		//스크립트 전달과 Text 전달으로 인해 ' 가 추가로 붙어 있음을 유의.
		}

		if ( $HAPPY_CONFIG['naver_talk_img'] != "" )
		{
			$onclick = ' onclick="javascript:window.open(\''.$talktalk_link.', \'talktalk\', \'width=503, height=762,scrollbars=0,toolbar=0,menubar=0,top=110,left=110,resizable=0\');return false;" ';
			$tag = '<a href="javascript:void(0);" '.$onclick.'><img src="'.$HAPPY_CONFIG['naver_talk_img'].'" alt="네이버톡톡" title="네이버톡톡" '.$style_tag.'></a>';
		}
	}

	return $tag;
}


function cloud_tag_txt($width,$height,$rand_style1,$rand_style2,$rankPrintSize)
{
	global $TPL , $keyword_tb , $keyword_rank_day, $skin_folder , $_GET;
	global $rankIcon_new , $rankIcon_up , $rankIcon_down , $rankIcon_equal, $rank_color;
	global $rank_word, $rank_num, $rank, $rank_keyword, $rank_change, $rank_icon, $checkfield, $rank_cnt;
	global $rankIcon_new_color,$rankIcon_up_color,$rankIcon_down_color,$rankIcon_equal_color;
	global $rank_word_encode, $rank_color;

	$rankPrintSize		= preg_replace("/\D/","",$rankPrintSize);
	$arr_rand_style1	= explode("/",$rand_style1);
	$arr_rand_style2	= explode("/",$rand_style2);

	$arr_rand_style1_cnt	= sizeof($arr_rand_style1);
	$arr_rand_style2_cnt	= sizeof($arr_rand_style2);

	$cdate	= $keyword_rank_day;

	$height_org		= preg_replace("/\D/","",$height);

	// 25배수
	if( ($height_org % 25) != 0 )
	{
		$height	= ($height_org - ($height_org % 25)) . 'px';
	}

	if ( $cdate == "" || $cdate == "0" )
	{
		return "keyword_rank_day 설정이 잘못되었습니다.";
	}

	$year		= ( $_GET["key_year"]== "" )?date("Y"):$_GET["key_year"];
	$mon		= ( $_GET["key_mon"] == "" )?date("m"):$_GET["key_mon"];
	$day		= ( $_GET["key_day"] == "" )?date("d"):$_GET["key_day"];

	$nowDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day+1,$year));
	$firstDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-$cdate+1,$year));
	$lastDate	= date("Y-m-d", happy_mktime(0,0,0,$mon,$day-($cdate*2)+1,$year));

	$Sql	 = "	SELECT											";
	$Sql	.= "			*,										";
	$Sql	.= "			sum(count) AS cnt						";
	$Sql	.= "	FROM											";
	$Sql	.= "			$keyword_tb								";
	$Sql	.= "	WHERE											";
	$Sql	.= "			regdate > '$firstDate'					";
	$Sql	.= "			AND										";
	$Sql	.= "			regdate < '$nowDate'					";
	$Sql	.= "			AND										";
	$Sql	.= "			replace(keyword,' ','') != ''			";
	$Sql	.= "	GROUP BY										";
	$Sql	.= "			keyword									";
	$Sql	.= "	ORDER BY										";
	$Sql	.= "			cnt desc								";
	$Sql	.= "	LIMIT											";
	$Sql	.= "			0,$rankPrintSize						";

	$Rs1	= query($Sql);

	while ( $Data = happy_mysql_fetch_array($Rs1) )
	{
		$rank_word	= $Data["keyword"];

		$rand1	= rand(0,$arr_rand_style1_cnt-1);
		$rand2	= rand(0,$arr_rand_style2_cnt-1);

		$class[]	= ".cloud_tag_txt_{$Data[number]} { cursor:pointer; float:left; margin: 0 5px 5px 0; " . $arr_rand_style1[$rand1] . " } .cloud_tag_txt_{$Data[number]}:hover { " . $arr_rand_style2[$rand2] . "}";

		$tag[]		= "<div style=\"font-size:14px; font-weight:bold; padding:5px;\"class=\"cloud_tag_txt_{$Data[number]}\" onclick=\"location.href='all_search.php?search_action=search&search_type=title&search_word=".urlencode($rank_word)."';\">{$rank_word}</div>";
	}

	$tags		= @implode("",$tag);
	$classs		= @implode("",$class);

	$content	= "
	<style>
		$classs
	</style>
	<div style=\"width: $width; height: $height; overflow: hidden;\">$tags</div>";

	return print $content;
}


// {{메인탑메뉴 happy_menu_top.html}}
// {{HTML호출 happy_menu_top.html}}
// {{인클루드 top_menu.html}}
function include_template($Template)
{
	global $TPL, $skin_folder;

	global $happy_solution_exception_html_file;
	global $happy_hunting_use;
	global $happy_mobile_geo_location_use;

	if ( $happy_hunting_use == "" )
	{
		if ( $happy_solution_exception_html_file['happy_hunting_use'][$Template] == "NO" )
		{
			//echo "헤드헌팅 기능이 없고 아무것도 안보여줘야 할때";
			return;
		}
		else if ( $happy_solution_exception_html_file['happy_hunting_use'][$Template] != "" )
		{
			//echo "헤드헌팅 기능이 없고 HTML파일을 교체 할때";
			$Template		= $happy_solution_exception_html_file['happy_hunting_use'][$Template];
		}
	}

	if ( $happy_mobile_geo_location_use == "" )
	{
		if ( $happy_solution_exception_html_file['happy_mobile_geo_location_use'][$Template] == "NO" )
		{
			//내주변검색이 없고 아무것도 안보여줘야 할때";
			return;
		}
		else if ( $happy_solution_exception_html_file['happy_mobile_geo_location_use'][$Template] != "" )
		{
			//내주변검색이 없고 아무것도 안보여줘야 할때";
			$Template		= $happy_solution_exception_html_file['happy_mobile_geo_location_use'][$Template];
		}
	}

	if( !(is_file("$skin_folder/$Template")) )
	{
		print "$skin_folder/$Template 파일이 존재하지 않습니다. <br>";
		return;
	}

	$random = rand()%1000;
	$TPL->define("인클루드_$random", "$skin_folder/$Template");
	$content = $TPL->fetch("인클루드_$random");

	print $content;
}


// 카테고리 추가
function get_type_selectbox($set_type1 = '',$set_type2 = '',$set_type3 = '')
{
	global $type_tb, $type_sub_tb, $type_sub_sub_tb,$_TYPE_DEPTH_TXT_ARR;

	$return_arr	= array();

	// 1차
	$type_opt	= "<option value=\"\">{$_TYPE_DEPTH_TXT_ARR[0]}</option>";
	$sql		= "SELECT * FROM {$type_tb} ORDER BY sort_number ASC";
	$rec		= query($sql);
	while($row = mysql_fetch_assoc($rec))
	{
		$selected	= ( $set_type1 == $row['number'] ) ? "selected" : "";
		$type_opt	.= "<option value=\"{$row['number']}\" {$selected}>{$row['type']}</option>";
	}

	// 2차
	$type_sub_opt	= "";
	if( $set_type1 != '' )
	{
		$sql		= "SELECT * FROM {$type_sub_tb} WHERE type = '{$set_type1}' ORDER BY sort_number ASC";
		$rec		= query($sql);
		while($row = mysql_fetch_assoc($rec))
		{
			$selected	= ( $set_type2 == $row['number'] ) ? "selected" : "";
			$type_sub_opt	.= "<option value=\"{$row['number']}\" {$selected}>{$row['type_sub']}</option>";
		}
	}

	// 3차
	$type_sub_sub_opt	= "";
	if( $set_type2 != '' )
	{
		$sql		= "SELECT * FROM {$type_sub_sub_tb} WHERE type_sub = '{$set_type2}' ORDER BY sort_number ASC";
		$rec		= query($sql);
		while($row = mysql_fetch_assoc($rec))
		{
			$selected	= ( $set_type3 == $row['number'] ) ? "selected" : "";
			$type_sub_sub_opt	.= "<option value=\"{$row['number']}\" {$selected}>{$row['title']}</option>";
		}
	}

	$return_arr['type_opt']			= $type_opt;
	$return_arr['type_sub_opt']		= $type_sub_opt;
	$return_arr['type_sub_sub_opt']	= $type_sub_sub_opt;

	return $return_arr;
}


?>