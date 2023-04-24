<?

	$happy_member						= 'happy_member';
	$happy_member_out					= 'happy_member_out';
	$happy_member_field					= 'happy_member_field';
	$happy_member_group					= 'happy_member_group';
	$happy_member_level					= 'happy_member_level';
	$happy_member_zip					= 'happy_member_zip';
	$happy_member_sms_confirm			= 'happy_member_sms_confirm';
	$happy_member_email_confirm			= 'happy_member_email_confirm';
	$happy_member_nick_history			= 'happy_member_nick_history';
	$happy_member_state_open			= 'happy_member_state_open';
	$happy_member_secure				= 'happy_member_secure';
	$happy_member_quies					= 'happy_member_quies';										//휴면회원 테이블
	$happy_member_autoslashes			= '';

	//추가필드 테이블
	$happy_member_option				= 'happy_member_option';
	//추가필드 구분자
	$happy_member_option_type			= 'adultjob';


	$happy_member_admin_id				= $admin_id;												# 관리자 아이디
	$happy_member_admin_pw				= $admin_pw;												# 관리자 패스워드
	$happy_member_admin_id_cookie_val	= 'ad_id';												# 관리자 아이디 저장되는 쿠키 변수
	$happy_member_admin_pw_cookie_val	= 'ad_pass';												# 관리자 패스워드 저장되는 쿠키 변수


	$happy_member_nick_change_day		= 30;														# 몇일이내 닉네임 변경 불가능한지
	$happy_member_state_change_day		= 30;														# 몇일이내 정보공개여부 변경이 불가능한지

	$happy_member_path					= $path;													# 홈페이지 절대경로
	$happy_member_main_url				= $main_url.'/';											# 홈페이지 주소 (끝에 /로 종료)
	$happy_member_admin_email			= $admin_email;												# 관리자 이메일 주소
	$happy_member_skin_folder			= $skin_folder;												# 스킨폴더

	$happy_member_upload_folder			= 'upload/happy_member/';									# 멤버이미지 업로드 폴더
	$happy_member_upload_path			= $happy_member_path . $happy_member_upload_folder;			# 멤버이미지 업로드 패스

	$happy_member_group_upload_folder	= 'upload/happy_member_group/';								# 멤버이미지 업로드 폴더
	$happy_member_group_upload_path		= $happy_member_path . $happy_member_group_upload_folder;	# 멤버이미지 업로드 패스

	$happy_member_kcb_namecheck_use		= $kcb_namecheck_use;										# 실명인증 연동 체크 변수
	$happy_member_iso_email_code		= 'happycgi_adultjob';											# 이메일인증시 암호화 키 코드


	$happy_member_image_width			= '400';													# 멤버이미지 썸네일 가로크기 1
	$happy_member_image_height			= '300';													# 멤버이미지 썸네일 세로크기 1
	$happy_member_image_quality			= '100';													# 멤버이미지 썸네일 퀄리티
	$happy_member_image_position		= '2';														# 멤버이미지 썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
	$happy_member_image_logo			= '';														# 멤버이미지 썸네일 로고
	$happy_member_image_logo_position	= '';														# 멤버이미지 썸네일 로고 위치
	$happy_member_image_type			= '가로기준세로짜름';										# 멤버이미지 썸네일 추출타입
																									#	(가로기준세로짜름,세로기준가로짜름,가로기준,세로기준,
																									#	 비율대로짜름,비율대로축소,비율대로확대)

	$happy_member_image_width2			= '200';													# 멤버이미지 썸네일 가로크기 1
	$happy_member_image_height2			= '150';													# 멤버이미지 썸네일 세로크기 1
	$happy_member_image_quality2		= '100';													# 멤버이미지 썸네일 퀄리티
	$happy_member_image_position2		= '2';														# 멤버이미지 썸네일 포지션 (왼쪽1,중간2,오른쪽3) (상단1,중간2,하단3)
	$happy_member_image_logo2			= '';														# 멤버이미지 썸네일 로고
	$happy_member_image_logo_position2	= '';														# 멤버이미지 썸네일 로고 위치
	$happy_member_image_type2			= '가로기준세로짜름';										# 멤버이미지 썸네일 추출타입
																									#	(가로기준세로짜름,세로기준가로짜름,가로기준,세로기준,
																									#	 비율대로짜름,비율대로축소,비율대로확대)



	$happy_member_find_id_type			= $search_id_type;											# 아이디찾기방식( phone, email)


	$happy_member_mypage_default_file	= 'happy_member_default_mypage_com.html';											# 마이페이지 껍데기 기본값
	$happy_member_mypage_content_file	= 'happy_member_mypage_com.html';								# 마이페이지 내용부분 기본값

	$happy_member_secure_board_code		= 'board_secure-';											# 게시판 권한 설정 구분자(변경금지)
	$happy_member_secure_noMember_code	= 900000000;												# 게시판 비회원 그룹넘버 설정 (변경금지)




	######## 로그인 관련 설정 #########
	//	jinam23 cookie 에서 변경 .
	$happy_member_login_value_type			= 'session';												# 회원 로그인시 session / cookie 중 무엇을 사용할것인지
	$happy_member_login_value_name			= 'happyjob_userid';													# 로그인 체크 변수명
	$happy_member_login_value_url			= $cookie_url;												# 쿠키 등록시 쿠키주소

	$happy_member_login_sub_value_type		= Array( 'cookie', 'cookie', 'cookie', 'cookie' );
	$happy_member_login_sub_value_name		= Array( 'job_level', 'job_nick', 'job_name', 'job_password' );
	$happy_member_login_sub_value_DB		= Array( $db_name, $db_name, $db_name, $db_name );
	$happy_member_login_sub_value_Table		= Array( $happy_member, $happy_member, $happy_member, $happy_member );
	$happy_member_login_sub_value_Field		= Array( 'level', 'user_nick', 'user_name', 'user_pass' );
	$happy_member_login_sub_value_secure	= Array( '', '', '', '' );								# md5, mysql password , mysql old_password
	$happy_member_login_sub_value_where		= Array(
													" WHERE user_id = '%회원아이디%' ",
													" WHERE user_id = '%회원아이디%' ",
													" WHERE user_id = '%회원아이디%' ",
													" WHERE user_id = '%회원아이디%' "
											);															# %회원아이디% %회원고유번호% 이용가능

	$happy_member_login_save_id_cookie		= 'happy_member_save_id';									# 아이디 저장용 쿠키
	$happy_member_login_save_id_day			= 30;														# 아이디 저장할때 기간

	$happy_member_login_mypage_link			= 'happy_member.php?mode=mypage';							# 솔루션 마이페이지 링크주소



	//hun	2013-07-19		자동로그인 설정값
	$happy_member_auto_login_id_cookie		= "happy_member_auto_login_id";								# 자동로그인 기능용 쿠키
	$happy_member_auto_login_id_day			= 90;														# 자동로그인 기능 사용 기간
	$happy_member_auto_login_pass_cookie	= "happy_member_auto_login_pass";							# 자동로그인 기능용 쿠키
	//hun	2013-07-19		자동로그인 설정값



	if ( $happy_member_login_value_type == 'session' )
	{
		$happy_member_login_value			= $_SESSION[$happy_member_login_value_name];
	}
	else if ( $happy_member_login_value_type == 'cookie' )
	{
		$happy_member_login_value			= $_COOKIE[$happy_member_login_value_name];
	}
	else
	{
		$happy_member_login_value			= '';
	}




	# 회원삭제,탈퇴시 동일 아이디로 재가입 여부
	# 1 : 재가입 가능
	# 0 또는 빈값 : 동일한 아이디로 재가입 불가
	$happy_member_out_id_use				= '';





	# 회원삭제시 같이 업데이트 할 정보 설정 #####################################################################
	# 테이블명 지정
	$happy_member_update_table				= Array(
												'happy_message',
												'happy_message'
	);

	# 조건문 입력 %아이디% %고유번호% 입력가능
	$happy_member_update_where				= Array(
												" sender_id = '%아이디%' ",
												" receive_id = '%아이디%' "
	);

	# 변환문 입력 %아이디% 입력가능
	$happy_member_update_set				= Array(
												" sender_id = '%아이디%_%고유번호%_탈퇴회원'  ",
												" receive_id = '%아이디%_%고유번호%_탈퇴회원'  "
	);
	# 회원삭제시 같이 업데이트 할 정보 설정 #####################################################################


	$happy_member_iso_phone_message			= "$site_name 휴대폰 인증 번호는[{{인증번호}}] 입니다.";
	$happy_member_iso_phone_test			= 'test';





	##################################################################################################################
	#  권한 페이지 설정                                                                                              #
	##################################################################################################################
	$happy_member_secure_text[0]			= '구직정보';
	$happy_member_secure_text[1]			= '구인정보';
	$happy_member_secure_text[2]			= '회원';
	//$happy_member_secure_text[3]			= '입사요청';	//쓰이는데가 없어서 제거
	$happy_member_secure_text[4]			= '온라인입사지원';
	$happy_member_secure_text[5]			= '면접제의';
	$happy_member_secure_text[6]			= '이메일접수';
	$happy_member_secure_text[7]			= '맞춤인재정보';
	$happy_member_secure_text[8]			= '맞춤구인정보';
	//패키지유료옵션권한
	$happy_member_secure_text[9]			= '패키지유료옵션';


	$happy_member_secure_page				= Array(
													//구직정보
													$happy_member_secure_text[0].'등록',
													$happy_member_secure_text[0].'보기',
													$happy_member_secure_text[0].'보기 유료결제',
													$happy_member_secure_text[0].'스크랩',
													$happy_member_secure_text[0].'유료결제',
													$happy_member_secure_text[0].'열람불가 설정',
													//구인정보
													$happy_member_secure_text[1].'등록',
													$happy_member_secure_text[1].'보기',
													$happy_member_secure_text[1].'보기 유료결제',
													$happy_member_secure_text[1].'유료결제',
													$happy_member_secure_text[1].'스크랩',
													'포인트기능',
													'마이페이지',
													'쪽지발송',
													$happy_member_secure_text[2].'탈퇴',
													//기타기능
													//$happy_member_secure_text[3],
													$happy_member_secure_text[4],
													$happy_member_secure_text[4].'요청',
													$happy_member_secure_text[5],
													$happy_member_secure_text[6],
													$happy_member_secure_text[7],
													$happy_member_secure_text[8],
													//패키지유료옵션권한
													$happy_member_secure_text[9],
													$happy_member_secure_text[1].'문의',
	);
	# 쉼표, 호따옴표등의 특문 이용금지


	//헤드헌팅
	if ( $hunting_use == true )
	{
		$hunting_secure_text = '구인_헤드헌팅';
		array_push($happy_member_secure_text, $hunting_secure_text);
		array_push($happy_member_secure_page, $hunting_secure_text);
	}

	//비회원은 제외되는 권한설정들 , admin/happy_member_secure.php 에서 사용
	$no_member_not_arr						= array(
														$happy_member_secure_text[0].'등록',
														//$happy_member_secure_text[0].'보기 유료결제',
														$happy_member_secure_text[0].'스크랩',
														$happy_member_secure_text[0].'유료결제',
														$happy_member_secure_text[0].'열람불가 설정',
														$happy_member_secure_text[1].'등록',
														$happy_member_secure_text[1].'보기 유료결제',
														//$happy_member_secure_text[1].'유료결제',
														$happy_member_secure_text[1].'스크랩',
														'포인트기능',
														'마이페이지',
														'쪽지발송',
														$happy_member_secure_text[2].'탈퇴',
														//기타기능
														//$happy_member_secure_text[3],
														$happy_member_secure_text[4],
														$happy_member_secure_text[4].'요청',
														$happy_member_secure_text[5],
														$happy_member_secure_text[6],
														$happy_member_secure_text[7],
														$happy_member_secure_text[8],
														//패키지유료옵션권한
														$happy_member_secure_text[9],
	);




	##################################################################################################################
	#  필드 정리 #### (PHP를 능숙하게 다루실줄 아시는 개발자만 수정하세요. 동일하게 Database도 변경되어야 합니다. )  #
	#  에러 발생시를 대비하여, 원본을 따로 백업해두시길 바랍니다.                                                    #
	##################################################################################################################

	$field[0]	= Array(
					'user_id',			'user_pass',		'user_pass2',		'user_name',			'user_nick',
					'user_jumin1',		'user_jumin2',		'user_birth_year',	'user_birth_month',		'user_birth_day',
					'user_birth_type',	'user_prefix',		'user_email',		'user_phone',			'user_phone2',
					'user_phone3',		'user_hphone',		'user_fax',			'user_homepage',		'user_zip',
					'user_addr1',		'user_addr2',		'user_zip_2',		'user_addr1_2',			'user_addr2_2',
					'user_zip_3',		'user_addr1_3',		'user_addr2_3',		'com_number1',			'com_number2',
					'com_number3',		'com_name',			'com_phone',		'com_birth',			'photo1',
					'photo2',			'photo3',			'recommend',		'message',				'email_forwarding',
					'sms_forwarding',	'state_open',		'road_si',			'road_gu',				'road_addr',
					'road_addr2',
	);

	$fieldType[0]	= Array(
					'',		'',		'',		'',		'',
					'',		'',		'i',	'i',	'i',
					'e',	'e',	'',		'',		'',
					'',		'',		'',		'',		'',
					'',		'',		'',		'',		'',
					'',		'',		'',		'',		'',
					'',		'',		'',		'',		'',
					'',		'',		'',		'',		'e',
					'e',	'e',	'',		'',		'',
					'',
	);

	$fieldModify[0]	= Array(
					'n',	'',		'',		'n',	'',
					'n',	'n',	'',		'',		''
	);

	$field[1]	= Array(
					'extra1',			'extra2',			'extra3',			'extra4',			'extra5',
					'extra6',			'extra7',			'extra8',			'extra9',			'extra10',
					'extra11',			'extra12',			'extra13',			'extra14',			'extra15',
					'extra16',			'extra17',			'extra18',			'extra19',			'extra20'
	);

	$fieldType[1]	= Array(
					'i',		'i',		'i',		'i',		'i',
					'i',		'i',		'',			'',			'',
					'',			'',			'',			'',			'',
					'',			'',			'',			'',			''
	);

	$fieldModify[1]	= Array(
					'',		'',		'',		'',		'',
					'',		'',		'',		'',		''
	);

	$defaultGroup	= array('메인','서브');


	$fieldAdminTdWidth	= Array(
					'user_id'				=> 100,
					'user_email'			=> 150,
					'user_name'				=> 80,
					'user_nick'				=> 100,
					'user_prefix'			=> 50,
					'user_phone'			=> 100,
					'user_hphone'			=> 100,
					'user_fax'				=> 100,
					'user_homepage'			=> 150,
					'user_zip'				=> 70,
					'user_addr'				=> 150
	);


	$fieldAdminTdAlign	= Array(
					'user_id'				=> 'center',
					'user_email'			=> 'left',
					'user_name'				=> 'center',
					'user_nick'				=> 'center',
					'user_prefix'			=> 'center',
					'user_phone'			=> 'center',
					'user_hphone'			=> 'center',
					'user_fax'				=> 'center',
					'user_homepage'			=> 'left',
					'user_zip'				=> 'center',
					'user_addr'				=> 'left'
	);


	$fieldAdminStrCut	= Array(
					'user_id'				=> 100,
					'user_email'			=> 20,
					'user_name'				=> 10,
					'user_nick'				=> 15,
					'user_prefix'			=> 10,
					'user_phone'			=> 13,
					'user_hphone'			=> 13,
					'user_fax'				=> 13,
					'user_homepage'			=> 20,
					'user_zip'				=> 7,
					'user_addr'				=> 20
	);




	#########################################################################################
	#		회원탈퇴시 사용되는 테이블과 필드이름 & 값들	2010-06-03		Hun 추가함!		#
	#########################################################################################

	// 제거를 해야하는 테이블명
	 $member_out_delete_table		= Array(

					0	=> 'job_guin',						#guin_id
					1	=> 'job_per_document',						#user_id
					2	=> 'job_jangboo',			#or_id
					3	=> 'job_jangboo2',			#or_id
					4	=> 'point_jangboo',	#id
					5	=> 'job_com_guin_per',						#com_id
					6	=> 'job_com_guin_per',						#per_id
					7	=> 'job_com_want_doc',				#com_id
					8	=> 'job_com_want_doc',				#per_id
					9	=> 'job_com_want_search',						#id
					10	=> 'job_per_want_search',					#id
					11	=> 'job_per_file',				#userid
					12	=> 'job_per_guin_view',					#per_id
					13	=> 'job_per_language',						#userid
					14	=> 'job_per_noViewList',								#per_id
					15	=> 'job_per_noViewList',								#com_id
					16	=> 'job_per_skill',								#userid
					17	=> 'job_per_worklist',								#userid
					18	=> 'job_per_yunsoo',								#userid
					19	=> 'job_scrap',								#userid
					20	=> $happy_member_nick_history,
					21	=> $happy_member_state_open
	 );

	 // 아이디가 들어있는 필드명
	 $member_out_delete_where_field	= Array(
					0	=> 'guin_id',
					1	=> 'user_id',
					2	=> 'or_id',
					3	=> 'or_id',
					4	=> 'id',
					5	=> 'com_id',
					6	=> 'per_id',
					7	=> 'com_id',
					8	=> 'per_id',
					9	=> 'id',
					10	=> 'id',
					11	=> 'userid',
					12	=> 'per_id',
					13	=> 'userid',
					14	=> 'per_id',
					15	=> 'com_id',
					16	=> 'userid',
					17	=> 'userid',
					18	=> 'userid',
					19	=> 'userid',
					20	=> 'user_id',
					21	=> 'user_id'
	 );
	######################################################################################################


	//암호화 필드를 추가하실 경우 기존 휴면회원의 필드도 암호화를 해주셔야하고
	//관련된 아이디찾기,비밀번호 찾기 등에 대해 소스를 수정하여야 합니다
	$CRYPT_FIELD		= Array("user_email","user_phone","user_hphone");


	/* 솔루션 별로 변경필요 */
	# happy_member.php 에 각 솔루션별 설정이 다름
	# include/lib_happy_member.php 각 솔루션별 설정이 다름
?>