<?
	#########################################
	#
	#
	#								[ 관리자 서브메뉴 ]
	#
	#
	#	작업명: 관리자 서브메뉴 디자인작업 1.0
	#	작업자: YOON DONG GI
	#	작성일: 2009-11-12
	#	회사명: HAPPYCGI, CGIMALL
	#	U R L : www.happycgi.com, www.cgimall.co.kr
	#	부서명: HAPPYCGI 디자인팀
	#
	#
	#########################################
	#
	#	서브메뉴 추가는 레이어번호로 계속 추가합니다.
	#	레이어메뉴 총 갯수 관련 설정을 점검하세요.
	#
	#########################################



	#관리자 메뉴 경로
	$main_url_admin = $main_url."/admin";

	#CSS 적용메뉴 총갯수 설정
	$css_menu_num = 8;



	#서브메뉴 자바스크립트
	$submenu_javascript = <<<END
		<SCRIPT LANGUAGE='JavaScript'>
		<!--

			//서브메뉴 번호 설정 #######################
			var submenu_num = new Array
			(
				1,//기본관리
				2,//등록관리
				3,//게시판관리
				4,//회원관리
				5,//결졔/통계관리
				6,//서비스관리
				7,//디자인관리
				8 //고급자설정
			);

			//각 서브메뉴 현재위치 아이콘  X좌표 위치설정 ###########
			var submenu_arrow_left = new Array
			(
				-100,
				235,//기본관리
				315,//등록관리
				405,//게시판관리
				495,//회원관리
				590,//결제,통계관리
				690,//서비스관리
				785,//디자인관리
				875//고급자설정
			);
			//#################################


			var subMenu = document.getElementById('admin_sub_menu_wrapper');
			var subMenuArrow = document.getElementById('sub_menu_arrow');


			//서브메뉴 보이기
			function admin_sub_menu(num) {
				for(var i=0; i<submenu_num.length; i++){

					//처음실행시 모든서브메뉴 레이어 감추기
					document.getElementById(["submenu" + (i+1)]).style.display = "none";

					if(num == submenu_num[i]){
						subMenu.style.display = "block";
						subMenuArrow.style.left = submenu_arrow_left[num];
						document.getElementById(["submenu" + num]).style.display = "block";
					}
				}
			}

			//관리자 서브메뉴 안보이기
			function admin_sub_menu_off(num){
				subMenu.style.display = "none";
			}
		//-->
		</SCRIPT>
END;


	#happyConfig 서브메뉴용
	function happy_config_menu_list_submenu($menu_group='')
	{
		global $happy_config_group, $link_target, $main_url_admin;

		if ( $menu_group != '' && $menu_group != '전체' )
		{
			$WHERE	= " AND menu_group = '$menu_group' ";
		}

		$Sql	= "SELECT * FROM $happy_config_group WHERE group_display='1' $WHERE ORDER BY group_sort ASC, number ASC ";
		$Record	= query($Sql);

		$content	= "";
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$content	.= "<LI><A href=\"$main_url_admin/happy_config_view.php?number=$Data[number]\">$Data[group_title]</A>";
			#$content	.= "<LI><A TARGET='$link_target' HREF='$main_url_admin/happy_config_view.php?number=$Data[number]'>$Data[group_title]</A>";
		}

		return $content;
	}
?>

<?
	#CSS 적용 서브메뉴
	function submenu_contents_css($s_num){
		$max_submenu = $s_num;
		for($i=1; $i<=$max_submenu; $i++){
			echo <<<END

				/* 서브메뉴 내용 */
				div#admin_sub_menu div#submenu${i} div.submenu{float:left; width:170; margin-right:20; margin-bottom:15; border:0px solid;}

				/* 서브메뉴 제목*/
				div#admin_sub_menu div#submenu${i} div.submenu div.menu_subtitle{width:100%; height:21; background:url('sub_menu/img/bg_title_submenu2a.png') no-repeat; _background:none; _filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='sub_menu/img/bg_title_submenu2a.png', sizingMethod='crop');
				color:white; font-family:돋움; font-size:8pt; font-weight:bold; letter-spacing:-1px; margin-bottom:10; padding:5 15 0 10;}

				/* 서브메뉴항목 */
				div#admin_sub_menu div#submenu${i} div.submenu table td ul{color:#EEE; font-family:돋움; font-size:10pt; margin:-0.5em 0 0 -1.5em; line-height:19px; list-style:circle; letter-spacing:-2px; list-style-image:url('');}
				div#admin_sub_menu div#submenu${i} div.submenu table td ul li a{color:#EEE; text-decoration:none;}
				div#admin_sub_menu div#submenu${i} div.submenu table td ul li a:hover{color:white; text-decoration:underline;}
				div#admin_sub_menu div#submenu${i} div.submenu table td ul li.strong{font-weight:100;} /* 굵은 표시 */
				div#admin_sub_menu div#submenu${i} div.submenu table td ul li.strong a{color:#FCC;} /* 굵은 표시 */

END;
		}
	}

	#CSS 적용 서브메뉴 iE전용
	function submenu_contents_css_ie($s_num){
		$max_submenu = $s_num;
		for($i=1; $i<=$max_submenu; $i++){
			echo <<<END
				div#admin_sub_menu div#submenu${i} div.submenu table td ul{font-family:돋움; font-size:8pt; margin:0 0 0 2.4em; line-height:19px; list-style:circle; letter-spacing:-1px; list-style-image:url('');}
END;
		}
	}

	//채용정보 점프
	$guin_jump_link = "";
	if ($HAPPY_CONFIG['guin_jump_use'] == "y" )
	{
		$guin_jump_link = '<LI><A href="'.$main_url_admin.'/guin_jump.php">구인점프 이용내역</A>';
	}
	//채용정보 점프

?>




<!-- CSS -->
<STYLE TYPE="text/css">

	/* 서브메뉴 전체감싸는 레이어*/
	div#admin_sub_menu_wrapper{position:relative; top:0; height:0; z-index:15; display:none;}

	/* 서브메뉴 현재위치 아이콘*/
	div#admin_sub_menu_wrapper div#sub_menu_arrow{position:absolute; top:73; left:-100; z-index:2;}

	/* 서브메뉴 + 배경이미지 */
	div#admin_sub_menu_wrapper div#admin_sub_menu_bg{position:absolute; top:80; width:100%; z-index:1; border:0px solid;}
	div#admin_sub_menu_wrapper div#admin_sub_menu_bg table td.tr1{height:6; background:url('sub_menu/img/bg_submenu_pan01a.png');}

	div#admin_sub_menu_wrapper div#admin_sub_menu_bg table td.tr2{color:black; font:8pt 돋움; padding:6 0 12 0; background-color:black; filter:alpha(opacity=60);}

	div#admin_sub_menu_wrapper div#admin_sub_menu_bg table td.tr3{height:8; background:url('sub_menu/img/bg_submenu_pan01b.png') repeat-x 0 bottom;}

	/* 서브메뉴 레이어 */
	div#admin_sub_menu_wrapper div#admin_sub_menu{position:relative; top:0; left:200; margin:8 0; width:800; height:; border:0px solid;}

	/* CSS 적용 서브메뉴 */
	<? submenu_contents_css($css_menu_num) ?>

</STYLE>

<!--[if IE 6]>
<STYLE TYPE="text/css">
	div#admin_sub_menu_wrapper div#admin_sub_menu_bg table td.tr1{height:6; background:url('sub_menu/img/bg_submenu_pan01a.png'); _background:none; _filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='sub_menu/img/bg_submenu_pan01a.png', sizingMethod='crop');}
	div#admin_sub_menu_wrapper div#admin_sub_menu_bg table td.tr3{height:8; background:url('sub_menu/img/bg_submenu_pan01b.png') repeat-x 0 bottom; _background:none; _filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='sub_menu/img/bg_submenu_pan01b.png', sizingMethod='crop');}
	<? submenu_contents_css_ie($css_menu_num) ?>
</STYLE>
<![endif]-->

<!--[if IE]>
<STYLE TYPE="text/css">
	<? submenu_contents_css_ie($css_menu_num) ?>
</STYLE>
<![endif]-->










<!-- 여기서부터 실질적인 서브메뉴 내용 ############################################# -->

<!-- 서브메뉴 레이어 -->
<div id="admin_sub_menu_wrapper" onMouseOver="this.style.display='block'" onMouseOut="this.style.display='none'">

	<!-- 서브메뉴 현재위치 아이콘 -->
	<div id="sub_menu_arrow"><img src="sub_menu/img/bg_submenu_pan_nowlocate2.png" border="0" width=30 height=14 class=png24 ></div>

	<!-- 서브메뉴 배경이미지 -->
	<div id="admin_sub_menu_bg">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td class=tr1></td></tr>
		<tr>
			<td class=tr2>





				<!-- 서브메뉴 내용 [ start ] ################################## -->
				<div id="admin_sub_menu">


					<!-- [기본관리] -->
					<div id="submenu1">

						<!-- 서브메뉴 [미니홈,업체관련설정] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>기본 <font class=thin>|</font> 환경설정</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/env_setup.php?mode=info_mod">환경설정</A>
										<LI><A href="<?=$main_url_admin?>/area_setting.php">지역 설정</A>
										<LI><A href="<?=$main_url_admin?>/underground_maker.php">역세권 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=35">첨부이미지 설정</A>
										<LI><A href="<?=$main_url_admin?>/best_keyword.php">실시간 인기검색어</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=15">도배방지키 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=8">실시간쪽지 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=36">검색관련 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=41">각종텍스트 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=43">금지단어 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=44">온라인입사지원 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=16">추천키워드</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=50">차단 단어 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=51">현재접속자 환경설정</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [API, 광고, 통계설정] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>부관리자 <font class=thin>|</font> 쪽지</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/admin_member.php">부관리자</A>
										<LI><A HREF="#admin_memo"onClick="window.open('<?=$main_url?>/happy_message.php?adminMode=y','adminHappyMessage','width=700,height=500,toolbar=no,scrollbars=no')" >관리자 쪽지</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

					</div>


					<!-- ############### -->


					<!-- [등록관리] -->
					<div id="submenu2">
						<!-- 서브메뉴 [카테고리 정보관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>채용정보 <font class=thin>|</font> 이력서</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/guin.php?a=guin&mode=list">채용정보 리스트</A>
										<LI><A href="<?=$main_url_admin?>/guin.php?a=guzic&mode=list">이력서 리스트</font></A>
										<LI><A href="<?=$main_url_admin?>/type_setting.php">직종(카테고리) 설정</font></A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=40">채용정보 등록설정</font></A>
										<LI><A href="<?=$main_url_admin?>/admin_online.php">온라인입사지원 관리</font></A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [업체정보관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>등록옵션 설정</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/admin.php?area=mod">채용/이력서 등록 옵션 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=33">이력서 관리 및 아이콘 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=34">미니앨범 설정</A>
										<!--<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=42">베이비시터 등록관련설정</A>-->
									</UL>
								</td>
							</tr>
							</table>
						</div>

					</div>

					<!-- ############### -->


					<!-- [게시판관리] -->
					<div id="submenu3">
						<!-- 서브메뉴 [게시판정보관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>게시판 정보관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/bbs.php?mode=list">전체게시판 리스트</A>
										<LI><A href="<?=$main_url_admin?>/bbs.php?mode=add">게시판 등록하기</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=3">게시판환경 설정</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

					</div>


					<!-- ############### -->


					<!-- [회원관리] -->
					<div id="submenu4">

						<!-- 서브메뉴 [통합회원관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>회원정보</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/happy_member.php">전체회원정보</A>
<?
								$Sql		= "SELECT * FROM $happy_member_group";
								$Record		= query($Sql);
								while ( $Data = happy_mysql_fetch_array($Record) )
								{
									echo "<LI><A href='$main_url_admin/happy_member.php?group_select=".$Data[number]."'>".$Data[group_name]."정보</A>";

								}
?>
										<LI><A href="<?=$main_url_admin?>/happy_member_quies.php">휴면 회원정보</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [통합회원관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>회원그룹관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/happy_member_group.php">회원그룹관리</A>
										<LI class=strong><A href="<?=$main_url_admin?>/happy_member_group.php?mode=add">회원그룹등록</A>
										<LI class=strong><A href="<?=$main_url_admin?>/happy_member.php?type=outList">탈퇴회원관리</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [회원서비스관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>회원관리 설정</div></td>
							</tr>
							<tr>
								<td>
									<UL>

										<LI><A href="<?=$main_url_admin?>/sms_send_com.php">기업회원 SMS 발송</A>
										<LI><A href="<?=$main_url_admin?>/mailing.php?keyword1=1">기업회원 메일링 발송</A>
										<LI><A href="<?=$main_url_admin?>/member_statistics_com.php">기업회원 통계</A>

										<LI><A href="<?=$main_url_admin?>/sms_send.php">개인회원 SMS 발송</A>
										<LI><A href="<?=$main_url_admin?>/mailing.php?keyword1=0">개인회원 메일링 발송</A>
										<LI><A href="<?=$main_url_admin?>/member_statistics_per.php">개인회원 통계</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=19">회원가입 관리 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=48">출석 포인트설정</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

					</div>


					<!-- ############### -->


					<!-- [결제/통계관리] -->
					<div id="submenu5">
						<!-- 서브메뉴 [결제관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>구인관련 유료관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/money_setup.php?action=option">구인정보 유료설정</A>
										<LI><A href="<?=$main_url_admin?>/money_setup.php?action=option2">구인회원 유료설정</A>
										<LI><A href="<?=$main_url_admin?>/jangboo.php">구인관련 결제내역</A>
										<LI><A href="<?=$main_url_admin?>/stats_jangboo.php">구인관련 결제통계</A>
										<LI><A href="<?=$main_url_admin?>/jangboo_statistics_com.php">구인관련 결제통계2</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=38">유료옵션 아이콘설정</A>
										<!-- 채용정보 점프 -->
										<?=$guin_jump_link?>
										<!-- 채용정보 점프 -->
										<LI><A href="<?=$main_url_admin?>/money_setup_package.php">구인 패키지유료설정</A>
										<LI><A href="<?=$main_url_admin?>/money_setup_package2.php">구인 패키지즉시적용 설정</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [결제관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>구직관련 유료관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/money_setup.php?action=member">구직정보 유료설정</A>
										<LI><A href="<?=$main_url_admin?>/money_setup.php?action=member2">구직회원 유료설정</A>
										<LI><A href="<?=$main_url_admin?>/jangboo2.php">구직관련 결제내역</A>
										<LI><A href="<?=$main_url_admin?>/stats_jangboo2.php">구직관련 결제통계</A>
										<LI><A href="<?=$main_url_admin?>/jangboo_statistics_per.php">구직관련 결제통계2</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=39">유료옵션 아이콘설정</A>
										<LI><A href="<?=$main_url_admin?>/money_setup_package.php?pay_type=person">구직 패키지유료설정(선택)</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [통계관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>통계 <font class=thin>|</font> 결제 관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=6">결제 환경설정</A>
										<LI><A href="<?=$main_url_admin?>/money_setup.php?action=common">공통 유료설정</A>
										<LI><A href="<?=$main_url_admin?>/jangboo_point.php">포인트 결제내역</A>
										<LI><A href="<?=$main_url_admin?>/happy_analytics.php">접속통계 요약정보</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=23">외부통계 및 코드</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=37">유료옵션 색상설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=52">유료옵션 색상설정(모바일)</A>
										<LI class=strong><A href="<?=$main_url_admin?>/happy_config_view.php?number=8">실시간쪽지 체크시간설정</A>
										<LI><A href="<?=$main_url_admin?>/jangboo_statistics_com.php"> 딜러 결제 통계</A>
										<LI><A href="<?=$main_url_admin?>/jangboo_statistics_per.php"> 개인 결제 통계</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>
					</div>


					<!-- ############### -->


					<!-- [서비스관리] -->
					<div id="submenu6">
						<!-- 서브메뉴 [SMS관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle><font style="letter-spacing:0;">SMS</font>관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><a href="#1" onMouseOver="MM_showHideLayers('menu1','','hide','menu2','','hide','menu3','','hide','menu4','','hide') " onClick="window.open('sms','happysms_admintool','width=560,height=650,scrolling=no,toolbar=no')" >SMS 관리설정</A>
										<LI><a href="happy_config_view.php?number=32">SMS 발송조건 설정</A>
										<LI><a href="happy_config_view.php?number=18">SMS 계정 및 발송설정</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [기타서비스관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>기타서비스 관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><a href="happy_config_view.php?number=17">실명인증 및 성인인증 서비스</A>
										<LI><a href="happy_config_view.php?number=4">네이버 지도 API</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>
					</div>


					<!-- ############### -->


					<!-- [디자인관리] -->
					<div id="submenu7">
						<!-- 서브메뉴 [이미지관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>이미지관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/main_logo_admin.php">사이트 로고 설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_icon_admin.php">템플릿이미지 및 색상관리</A>
										<LI><A href="<?=$main_url_admin?>/happy_icon_admin.php?type=add">템플릿이미지 등록</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=30">기타 이미지 설정</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [플래시관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>플래시관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=14">클라우드 태그</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=7">실시간검색어 환경설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=49">3D클라우드 태그 설정</A>
										<LI><A href="<?=$main_url_admin?>/weather_reset.php">날씨정보리셋실행</A>

									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [배너관리] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>배너 <font class=thin>|</font> 팝업 관리</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/banner_admin.php">통합배너관리</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=24">외부광고태그</A>
										<LI><A href="<?=$main_url_admin?>/popup_admin.php">팝업관리</A>
										<LI><A href="<?=$main_url_admin?>/popup_admin.php?mode=add">팝업정보등록</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=5">팝업 환경설정</A>

										<LI><A href="<?=$main_url_admin?>/logo_bgimage.php">회사로고 배경이미지설정</A>
										<LI><A href="banner_admin_slide.php">슬라이드 배너관리</A><span style='text-decoration:none'>(<A href="/admin/happy_config_view.php?number=54"><font color='red'>설정</font></A>)</span>
									</UL>
								</td>
							</tr>
							</table>
						</div>


						<!-- 서브메뉴 [자동완성] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>자동완성기능 설정</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/auto_search_word.php">자동완성 기능설정</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>

						<!-- 서브메뉴 [정보관리, 기타설정] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>기타설정</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/poll_admin.php">투표관리</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=31">회사소개 변경</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=25">템플릿 파일보기</A>
										<LI><A href="<?=$main_url_admin?>/tagview.php">태그생성기</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>
					</div>


					<!-- ############### -->


					<!-- [고급자설정] -->
					<div id="submenu8">

						<!-- 서브메뉴 [기타정보, 설정] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle>기타설정</div></td>
							</tr>
							<tr>
								<td>
									<UL>
										<LI><A href="<?=$main_url_admin?>/dbinfo.php">DB테이블정보보기</A>
										<LI><A href="<?=$main_url_admin?>/happy_config_view.php?number=9">개발자용설정</A>
										<LI><A href="<?=$main_url_admin?>/happy_admin_ip.php">관리자 접속리스트</A>
										<LI><A href="<?=$main_url_admin?>/happy_img_resize.php?step=2">이미지 사이즈 변경</A>
										<LI><A href="<?=$main_url_admin?>/data_initialization.php">자료초기화</A>
									</UL>
								</td>
							</tr>
							</table>
						</div>
					</div>

					<!-- ############### -->
					<!-- [나의퀵메뉴] -->
					<div id="submenu9">
<?
	//나의 퀵메뉴 설정에서 설정한 정보들을 가져와서 퀵메뉴를 만들어 주자!
	$Sql = "
			SELECT * FROM $happy_quick_menu
				WHERE menu_depth = 0
					ORDER BY sort ASC
			";
	$Record	= query($Sql);

	while($Data = happy_mysql_fetch_array($Record))
	{
?>
						<!-- 서브메뉴 [] -->
						<div class=submenu>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><div class=menu_subtitle><?=$Data['menu_name']?></div></td>
							</tr>
<?
		$Sql2 = "
				SELECT * FROM $happy_quick_menu
					WHERE
						menu_depth > $Data[menu_depth] AND
						menu_group = $Data[menu_group]
							ORDER BY sort ASC
		";
		$Record2 = query($Sql2);
		$Depth = $Data['menu_depth'];


		while ( $Data2 = happy_mysql_fetch_array($Record2) )
		{
			//뎁스에 따른 상 하위 카테고리 구분! 이미지도 다르게 처리한다!
			$levelImg	= ($Data2['menu_depth'] == 0 ) ? "<img src='img/ico_cate_top.gif' border=0>":"<img src='img/ico_cate_sub.gif' border=0>";
			$print_sort2 =1 + $Data2['sort'] ;
			$Depth = $Data2['menu_depth'];

			?>
							<tr>
								<td>
									<UL>
										<LI class=strong><A href="<?=$Data2['url']?>" target="<?=$Data2['target']?>" ONMOUSEOVER="ddrivetip('<?=$Data2['menu_explain']?>','','180')"; ONMOUSEOUT="hideddrivetip()"><?=$Data2['menu_name']?></A>
									</UL>
								</td>
							</tr>
			<?
		}
			?>
							</table>
						</div>
			<?
	}
?>
					</div>
				</div>
				<!-- 서브메뉴 내용 [ end ] ################################## -->


			</td>
		</tr>
		<tr><td class=tr3></td></tr>
		</table>
	</div>

</div>





<?
	#서브메뉴관련 자바스크립트
	echo $submenu_javascript;
?>