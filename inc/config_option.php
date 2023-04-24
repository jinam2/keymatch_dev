<?
	# 솔루션 옵션 정리

	$happy_hunting_use						= '1';			# 헤드헌팅 사용 여부
	$happy_mobile_basic_use					= '1';			# 기본 모바일 사용 여부
	$happy_mobile_geo_location_use			= '';			# 모바일 위치기반 사용 여부


	$happy_solution_exception_html_file = Array
	(
		// 헤드헌팅 기능이 꺼져 있을때 HTML파일명 치환. 값이 "NO"일 경우엔 html define 하지 않고 그냥 빈값 리턴.
		'happy_hunting_use'							=> Array
		(
			//상단 전체메뉴
			'header_head.html'							=> 'NO',
			//기업회원 마이페이지 메인
			'happy_member_mypage_com_head.html'			=> 'NO',
			//기업회원 마이페이지 우측 스크롤 따라다니는 메뉴
			'my_view_right_scroll_mypage_com_head.html'	=> 'NO',
			//기업회원 마이페이지 채용정보 검색부분
			'my_head_guin.html'							=> 'NO',
			//기업회원 채용정보 등록 페이지
			'guin_regist_head.html'						=> 'NO',
			//기업회원 채용정보 수정 페이지
			'guin_mod_head.html'						=> 'NO',
			//모바일 마이페이지 메인 채용정보 리스트 부분
			'happy_member_mypage_com_mobile_head.html'	=> 'happy_member_mypage_com_mobile_head_exclude.html'
		),

		// 모바일 위치기반 사용이 꺼져 있을때 HTML파일명 치환. 값이 "NO"일 경우엔 html define 하지 않고 그냥 빈값 리턴.
		'happy_mobile_geo_location_use'				=> Array
		(
			//모바일 상단 메뉴에 내주변정보
			'header_geo.html'						=> 'header_geo_exclude.html',
			//모바일 상단 메뉴에 내주변정보 클릭시 노출되는 레이어
			'header_geo_date_layer.html'			=> 'NO'
		),
	);

?>