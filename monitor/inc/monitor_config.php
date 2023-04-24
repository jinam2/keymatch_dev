<?php

#####################################################################################
#####																			#####
#####							솔루션 모니터링 변수 모음						#####
#####																			#####
#####################################################################################

# 모니터링 폴더명
$happy_monitor_folder		= "monitor";

# 모니터링 설정 DB 테이블
$happy_monitor_config		= $DB_Prefix."happy_monitor_config";

# 모니터링 인증 쿠키명
$happy_monitor_cookie_name	= 'happy_monitor_admin';

# 각종 솔루션 경로
$server_real_path			= str_replace("\\","/",realpath(__FILE__));
$server_path				= str_replace($happy_monitor_folder."/inc/".basename(__FILE__), "", $server_real_path);
$config_include_folder		= ( is_file($server_path."master/config.php") ) ? "master" : "inc";
$happy_monitor_path			= $server_path.$happy_monitor_folder;

# 각종 솔루션 include 파일
$happy_file					= $server_path."inc/happy.php";
$function_file				= $server_path."inc/function.php";
$happy_config_file			= $server_path."inc/happy_config/happy_config_file.php";
$config_file				= $server_path.$config_include_folder."/config.php";
$config_expend_file			= $server_path."inc/config_expend.php";

# 솔루션 용량 체크 설정
$volume_check_file_path		= $happy_monitor_path."/sample/volume_check.txt";
$volume_check_folder_path	= $server_path."data/volume_check";

# 파일 업로드 체크 설정
$upload_check_file_path		= $happy_monitor_path."/sample/upload_check.jpg";

# 메일 발송 체크 설정
$send_mail_check_conf		= Array(
									'from_name'		=> 'CGIMALL 메일발송',
									'from_mail'		=> 'webmaster@happycgi.com',
									'mail_title'	=> 'CGIMALL 메일발송 테스트 입니다.',
									'mail_content'	=> "본 메일은 CGIMALL 솔루션 메일 발송 테스트 입니다.<br />발송된 도메인은 [<a href='".$main_url."' target='_blank'>".$main_url."</a>] 입니다."
							);

# 모니터링 관련설정 기본값
$DEFAULT_SETTING_VALUE		= Array(
									'volume_check_limit_byte'		=> 50,			//남은용량체크 byte
									'load_time_check_repeat'		=> 10,			//CPU 연산 반복 횟수
									'load_time_check_limit'			=> 1000000,		//CPU 1회 반복시 연산 횟수
									'load_time_average_start'		=> 0.1,			//CPU 가장 빠른 속도
									'load_time_average_end'			=> 0.8,			//CPU 가장 느린 속도
									'load_time_check_repeat_db'		=> 10,			//MySQL 접속 반복 횟수
									'load_time_average_start_db'	=> 0,			//MySQL 접속 가장 빠른 속도
									'load_time_average_end_db'		=> 1			//MySQL 접속 가장 느린 속도
							);

# 솔루션 용량정보 관련설정
$happy_monitor_volume		= $DB_Prefix."happy_monitor_volume";

$VOLUME_SETTING				= Array(
									'update_term'	=> 12,		//업데이트 간격(시간 단위)
									'truncate_term'	=> 365		//DB 삭제 간격(일 단위)
							);

# 각종 솔루션 기능 확인 설정
# title			=> 제목
# submit_vars	=> 전송값
# submit_file	=> 전송파일
# check_value	=> 성공여부 체크값
# explain		=> 설명
$CHECK_API_CONFIG			=
Array
(
	'area2road'			=> Array(
								'title'			=> '주소 변환 (지번->도로명)',
								'submit_vars'	=> Array(
														'zipcode'		=> '42660',
														'si'			=> '대구광역시',
														'gu'			=> '달서구',
														'dong'			=> '두류동',
														'addr2'			=> '776-9'
												),
								'action_file'	=> 'ajax_happy_road_address.php',
								'check_value'	=> '대구광역시 달서구 성당로 289', //반환 주소(도로명)
								'explain'		=> "지번->도로명 변환 프로그램(ajax_happy_road_address.php)을 통해 주소 변환 정상여부 테스트 결과"
						),
	'road2area'			=> Array(
								'title'			=> '주소 변환 (도로명->지번)',
								'submit_vars'	=> Array(
														'addr'			=> '대구광역시|달서구',
														'doro'			=> '성당로',
														'geonmul1'		=> '289'
												),
								'action_file'	=> 'ajax_happy_address.php',
								'check_value'	=> '대구광역시 달서구 두류동 776-9', //반환 주소(지번)
								'explain'		=> "도로명->지번 변환 프로그램(ajax_happy_address.php)을 통해 주소 변환 정상여부 테스트 결과"
						),

	'bbs_regist'		=> Array(
								'title'			=> '게시글 작성',
								'submit_vars'	=> Array(
														'mode'			=> 'add_ok',
														'tb'			=> 'board_photo',
														'bbs_name'		=> '테스터',
														'bbs_pass'		=> 'test',
														'bbs_title'		=> '테스트',
														'bbs_review'	=> '테스트 입니다.',
														'dobae'			=> '1621'
												),
								'action_file'	=> 'bbs_regist.php',
								'check_value'	=> '', //없음
								'explain'		=> "게시글 작성 프로그램(bbs_regist.php)을 통해 게시물 작성 정상여부 테스트 결과"
						),
	'member_join'		=> Array(
								'title'			=> '회원가입',
								'submit_vars'	=> Array(
														'user_id'			=> 'happyjointester',
														'user_pass'			=> 'happyjointester',
														'user_name'			=> '회원가입테스터',
														'user_nick'			=> '회원가입테스터',
														'email_forwarding'	=> 'n',
														'sms_forwarding'	=> 'n',
														'state_open'		=> 'n'
												),
								'action_file'	=> 'happy_member.php?mode=joinus_reg',
								'check_value'	=> 'happyjointester', //user_id
								'explain'		=> "회원가입 프로그램(happy_member.php)을 통해 회원가입 정상여부 테스트 결과"
						),
	/*
	'upload_wys'		=> Array(
								'title'			=> '위지윅 단일 업로드',
								'submit_vars'	=> Array(
														'want_width'					=> '600',
														'logo_add'						=> 'ok',
														'HAPPY_REFERER_CHECK_DEFAULT'	=> 'off'
												),
								'submit_files'	=> Array(
														'NewFile'			=> $upload_check_file_path
												),
								'action_file'	=> 'wys2/editor/filemanager/connectors/php/upload.php?Type=Image',
								'explain'		=> "위지윅 에디터의 단일 업로드 프로그램을 통해 이미지 업로드 정상여부 테스트 결과"
						),
	*/
);

# 도로명 주소 변환을 통해 UTF-8 글자깨짐 테스트
if ( preg_match("/utf/i",$server_character) )
{
	$CHECK_API_CONFIG['utf8_char']		= Array(
												'title'			=> 'UTF-8 글자깨짐',
												'submit_vars'	=> Array(
																		'zipcode'		=> '42660',
																		'si'			=> '대구광역시',
																		'gu'			=> '달서구',
																		'dong'			=> '두류동',
																		'addr2'			=> '776-9'
																),
												'action_file'	=> 'ajax_happy_road_address.php',
												'check_value'	=> '대구광역시 달서구 성당로 289', //반환 주소(도로명)
												'explain'		=> "UTF-8 글자 출력 정상여부 테스트 결과"
										);
}

# 솔루션 운영 현황 기능
$CHECK_CONDITION_CONF		=
Array
(
	# 목표 기준 퍼센트별 상태 설정 (순서대로 입력할 것)
	# percent		=> 목표 기준 달성 퍼센트
	# title			=> 달성 레벨 이름
	# icon			=> 달설 레벨 아이콘
	'check_level'	=> Array(
							Array(
									'percent'		=> 10,
									'title'			=> '천둥',
									'icon'			=> $happy_monitor_folder.'/img/condition/icon_weather_05.jpg'
							),
							Array(
									'percent'		=> 30,
									'title'			=> '비',
									'icon'			=> $happy_monitor_folder.'/img/condition/icon_weather_04.jpg'
							),
							Array(
									'percent'		=> 50,
									'title'			=> '흐림',
									'icon'			=> $happy_monitor_folder.'/img/condition/icon_weather_03.jpg'
							),
							Array(
									'percent'		=> 70,
									'title'			=> '구름낌',
									'icon'			=> $happy_monitor_folder.'/img/condition/icon_weather_02.jpg'
							),
							Array(
									'percent'		=> 100,
									'title'			=> '맑음',
									'icon'			=> $happy_monitor_folder.'/img/condition/icon_weather_01.jpg'
							)
					),

	# 체크할 DB 테이블 설정
	# conf_name			=> 설정 구분자
	# title				=> 설정 이름
	# type				=> 설정 타입 (count or sum)
	# table				=> DB 테이블명
	# check_field		=> 확인할 DB 필드명
	# date_field		=> 날짜 DB 필드명
	# where_query		=> 날짜 외 추가 조건
	# demo_check_day	=> 조회일 (데모용)
	# demo_target		=> 목표 (데모용)
	# default_check_day	=> 조회일 (기본값)
	# default_target	=> 목표 (기본값)
	# unit				=> 출력 단위
	'check_table'	=> Array(
							Array(
									'conf_name'			=> 'member_join',
									'title'				=> '회원가입',
									'type'				=> 'count',
									'table'				=> $happy_member,
									'check_field'		=> 'number',
									'date_field'		=> 'reg_date',
									'where_query'		=> Array(),
									'demo_check_day'	=> 1000,
									'demo_target'		=> 20,
									'default_check_day'	=> 30,
									'default_target'	=> 30,
									'unit'				=> '명'
							),

							Array(
									'conf_name'			=> 'bbs_count',
									'title'				=> '게시글수',
									'type'				=> 'count',
									'table'				=> Array(
																'table'		=> $board_list,
																'field'		=> 'tbname'
														),
									'check_field'		=> 'number',
									'date_field'		=> 'bbs_date',
									'where_query'		=> Array(),
									'demo_check_day'	=> 365,
									'demo_target'		=> 900,
									'default_check_day'	=> 30,
									'default_target'	=> 150,
									'unit'				=> '개'
							),

							Array(
									'conf_name'			=> 'short_comment_count',
									'title'				=> '댓글수',
									'type'				=> 'count',
									'table'				=> $board_short_comment,
									'check_field'		=> 'number',
									'date_field'		=> 'reg_date',
									'where_query'		=> Array(),
									'demo_check_day'	=> 1000,
									'demo_target'		=> 100,
									'default_check_day'	=> 30,
									'default_target'	=> 300,
									'unit'				=> '개'
							)
					)
);
?>