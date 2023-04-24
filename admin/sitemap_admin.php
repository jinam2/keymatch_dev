<?
	#################################################################################
	#
	#
	#								[ 관리자 사이트맵 ]
	#
	#
	#	작업명: 관리자 사이트맵 디자인작업 1.0
	#	작업자: YOON DONG GI
	#	작성일: 2009-11-11
	#	회사명: HAPPYCGI, CGIMALL
	#	U R L : www.happycgi.com, www.cgimall.co.kr
	#	부서명: HAPPYCGI 디자인팀
	#
	#
	#################################################################################


	include "../inc/config.php";
	include "../inc/function.php";
	include "../inc/lib.php";

	if ( !admin_secure("슈퍼관리자전용") ) {
			error("접속권한이 없습니다.");
			exit;
	}



	$link_target = "_parent";
	$main_url_admin = $main_url."/admin";



	#happyConfig 메뉴 사이트맵용
	function happy_config_menu_list_sitemap($menu_group='')
	{
		global $happy_config_group, $link_target, $main_url_admin;;

		if ( $menu_group != '' && $menu_group != '전체' )
		{
			$WHERE	= " AND menu_group = '$menu_group' ";
		}

		$Sql	= "SELECT * FROM $happy_config_group WHERE group_display='1' $WHERE ORDER BY group_sort ASC, number ASC ";
		$Record	= query($Sql);

		$content	= "";
		while ( $Data = happy_mysql_fetch_array($Record) )
		{
			$content	.= "<LI><A href=\"javascript:siteOpen_selfClose('$main_url_admin/happy_config_view.php?number=$Data[number]')\">$Data[group_title]</A>";
			#$content	.= "<LI><A TARGET='$link_target' HREF='$main_url_admin/happy_config_view.php?number=$Data[number]'>$Data[group_title]</A>";
		}

		return $content;
	}
?>



<HTML>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<TITLE> 관리자 사이트맵 </TITLE>


<STYLE TYPE="text/css">
	body{margin:0; background:url('./sitemap/img/title_main_sitemap2.jpg') no-repeat 0 0;}
	font.thin{font-weight:100;}



	/* 타이틀이미지, 솔루션명 */
	div#main_title_image{position:relative; width:980; height:145;}
	div#main_title_image div#solution_title{position:absolute; top:31; left:580; width:240; height:; font-family:맑은 고딕,돋움; font-size:13pt; font-weight:bold; text-align:center; letter-spacing:-1px; border:0px solid;}

	/* 본문전체 감싸는 레이어 */
	div#wrapper_all{width:100%; padding:0 0 50 0; border:0 solid;}

	/* 메뉴 */
	div#stiemap_menu_wrapper{padding:40 0 0 24;} /* 메뉴 감싸는레이어 */

	div#sitemap_menu{float:left; width:210; margin-right:25; margin-bottom:0; border:0 solid;}
	div#sitemap_menu div.menu_title{color:white; font-family:맑은 고딕,돋움; font-size:14pt; font-weight:bold; text-align:center; letter-spacing:-1px; margin-bottom:10;}

	div#sitemap_menu div.submenu{width:198; margin-left:3;}
	div#sitemap_menu div.submenu div.menu_subtitle{width:100%; height:33;  color:white; font-family:돋움체; font-size:10pt; font-weight:bold; letter-spacing:-2px; background:url('sitemap/img/bg_submenu2.jpg') no-repeat; border:0px solid red;padding:9 0 0 15; margin-bottom:0;}

	div#sitemap_menu div.submenu table td ul{font-family:돋움; font-size:10pt; margin:0 0 20 0; line-height:auto; list-style:circle; letter-spacing:-2px; list-style-image:url('sitemap/img/ico_arrow_menu01.gif');}
	div#sitemap_menu div.submenu table td ul li a{color:black; text-decoration:none;}
	div#sitemap_menu div.submenu table td ul li a:hover{color:#F7613C; text-decoration:none;}

	/* 구분선 */
	hr#hr_thin{clear:both; border:1px dotted #CCC; margin-left:-20; margin-bottom:50;}

</STYLE>




<!--[if IE]>
<STYLE TYPE="text/css">
	div#sitemap_menu div.submenu table td ul{font-family:돋움; font-size:10pt; margin:0 0 20 2.4em; line-height:24px; list-style:circle; letter-spacing:-1px; list-style-image:url('sitemap/img/ico_arrow_menu01.gif');}
</STYLE>
<![endif]-->



<SCRIPT LANGUAGE="JavaScript">
<!--
	//자신의 팝업창은 닫고 팝업창을 열게해준 창으로 주소이동
	function siteOpen_selfClose(url){
		opener.location.href = url;
		//self.close();
	}
//-->
</SCRIPT>


</HEAD>

<BODY>


<div id=wrapper_all>

	<div id=main_title_image>
		<div id=solution_title><?=$site_name?></div>
	</div>


	<div id=stiemap_menu_wrapper>


		<!-- [1] -->
		<!-- 메뉴 - 기본관리 [ start ] -->
		<div id=sitemap_menu>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!-- 메인메뉴명 -->
				<td height=66 background="sitemap/img/bgbox_menu02a.jpg"><div class=menu_title>기본관리</div></td>
			</tr>
			<tr>
				<td align=center style="padding-top:20px;" background="sitemap/img/bgbox_menu02b.jpg">

					<!-- 서브메뉴 [미니홈,업체관련설정] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>기본설정</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/env_setup.php?mode=info_mod')">사이트정보 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/area_setting.php')">지역 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/underground_maker.php')">역세권설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=35')">첨부이미지 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/best_keyword.php')">실시간인기검색어 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=7')">실시간인기검색어 환경설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=41')">각종메세지 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=44')">온라인 입사지원 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=16')">추천 키워드 설정</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [API, 광고, 통계설정] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>쪽지<font class=thin>|</font> 부관리자</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/admin_member.php')">부관리자 설정</A>
									<LI><A href="javascript:void(0);" onclick="javascript:window.open('../happy_message.php?adminMode=y','','width=700,height=500')">관리자 쪽지발송</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [지역정보관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>기타설정</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=15')">도배방지키 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=8')">실시간 쪽지설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=36')">성별검색 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=43')">금지단어 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=50')">차단단어 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=51')">현재접속자 환경설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/auto_search_word.php')">자동완성단어</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=14')">클라우드태그 환경설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=49')">3D클라우드 환경설정</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>



				</td>
			</tr>
			<tr>
				<td height=17 background="sitemap/img/bgbox_menu02c.jpg"></td>
			</tr>
			</table>
		</div>
		<!-- 메뉴 - 기본관리 [ end ] -->




		<!-- 메뉴 - 등록관리 [ start ] -->
		<div id=sitemap_menu>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!-- 메인메뉴명 -->
				<td height=66 background="sitemap/img/bgbox_menu02a.jpg"><div class=menu_title>등록관리</div></td>
			</tr>
			<tr>
				<td align=center style="padding-top:20px;" background="sitemap/img/bgbox_menu02b.jpg">

					<!-- 서브메뉴 [카테고리 정보관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>채용정보</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/guin.php?a=guin&mode=list')">채용등록리스트</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=40')">채용정보 등록설정</font></A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/admin_online.php')">온라인입사지원 관리</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [업체정보관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>이력서정보</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/guin.php?a=guzic&mode=list')">이력서등록리스트</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=33')">상세보기 권한 및 아이콘</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=34')">미니앨범 사용설정</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [대기업체정보관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>기타 옵션설정</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/type_setting.php')">직종(카테고리) 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/admin.php?area=mod')">채용/이력서 등록옵션</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

				</td>
			</tr>
			<tr>
				<td height=17 background="sitemap/img/bgbox_menu02c.jpg"></td>
			</tr>
			</table>
		</div>
		<!-- 메뉴 - 등록관리 [ end ] -->



		<!-- 메뉴 - 게시판관리 [ start ] -->
		<div id=sitemap_menu>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!-- 메인메뉴명 -->
				<td height=66 background="sitemap/img/bgbox_menu02a.jpg"><div class=menu_title>게시판관리</div></td>
			</tr>
			<tr>
				<td align=center style="padding-top:20px;" background="sitemap/img/bgbox_menu02b.jpg">

					<!-- 서브메뉴 [게시판정보관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>전체 게시판 관리</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/bbs.php?mode=list')">게시판 리스트</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/bbs.php?mode=add')">게시판 등록</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=3')">게시판 환경설정</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

				</td>
			</tr>
			<tr>
				<td height=17 background="sitemap/img/bgbox_menu02c.jpg"></td>
			</tr>
			</table>
		</div>
		<!-- 메뉴 - 게시판관리 [ end ] -->



		<!-- 메뉴 - 회원관리 [ start ] -->
		<div id=sitemap_menu>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!-- 메인메뉴명 -->
				<td height=66 background="sitemap/img/bgbox_menu02a.jpg"><div class=menu_title>회원관리</div></td>
			</tr>
			<tr>
				<td align=center style="padding-top:20px;" background="sitemap/img/bgbox_menu02b.jpg">

					<!-- 서브메뉴 [회원정보] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>회원정보</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member.php')">전체회원정보</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member.php?group_select=1')">개인회원정보</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member.php?group_select=2')">기업회원정보</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member.php?group_select=3')">특별회원정보</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member.php?group_select=4')">대기회원정보</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member.php?group_select=10')">SNS회원정보</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member.php?group_select=11')">모바일회원정보</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [회원서비스관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>회원그룹</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member_group.php')">회원그룹 관리</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member_group.php?mode=add')">회원그룹 등록</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_member.php?type=outList')">탈퇴회원 관리</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [관리자서비스] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>기업회원 관리</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/sms_send_com.php')">기업회원 SMS발송</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/mailing.php?keyword1=1')">기업회원 메일링발송</A>
									<LI><A HREF="#admin_memo"onClick="window.open('<?=$main_url_admin?>/member_statistics_com.php')" >기업회원 통계</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [관리자서비스] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>개인회원 관리</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/sms_send.php')">개인회원 SMS발송</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/mailing.php?keyword1=0')">개인회원 메일링발송</A>
									<LI><A HREF="#admin_memo"onClick="window.open('<?=$main_url_admin?>/member_statistics_per.php')" >개인회원 통계</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [관리자서비스] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>기타 회원설정</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=19')">회원가입 관련설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=48')">출석체크 포인트설정</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

				</td>
			</tr>
			<tr>
				<td height=17 background="sitemap/img/bgbox_menu02c.jpg"></td>
			</tr>
			</table>
		</div>
		<!-- 메뉴 - 회원관리 [ end ] -->



		<hr size=0 id=hr_thin>



		<!-- [2] -->
		<!-- 메뉴 - 결제/통계관리 [ start ] -->
		<div id=sitemap_menu style="clear:both;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!-- 메인메뉴명 -->
				<td height=66 background="sitemap/img/bgbox_menu02a.jpg"><div class=menu_title>결제/통계관리</div></td>
			</tr>
			<tr>
				<td align=center style="padding-top:20px;" background="sitemap/img/bgbox_menu02b.jpg">

					<!-- 서브메뉴 [결제관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>기업 유료결제관리</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/money_setup.php?action=option')">채용광고 유료설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/money_setup.php?action=option2')">기업회원 관련 결제설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/jangboo.php')">기업 결제장부내역</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/guin_jump.php')">채용점프 이용내역</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/money_setup_package.php')">패키지 유료설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/money_setup_package2.php')">패키지 즉시적용 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=38')">유료옵션 아이콘 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/stats_jangboo.php')">결제통계 관리 l</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/jangboo_statistics_com.php')">결제통계 관리 ll</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [통계관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>개인 유료결제관리</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/money_setup.php?action=member')">이력서광고 유료설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/money_setup.php?action=member2')">개인회원 관련 결제설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/jangboo2.php')">개인 결제장부내역</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/money_setup_package.php?pay_type=person')">패키지 유료설정(선택)</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/stats_jangboo2.php')">결제통계 관리 l</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/jangboo_statistics_per.php')">결제통계 관리 ll</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [통계관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>기타 결제 및 통계</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=6')">결제 환경설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/money_setup.php?action=common')">공통 유료설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/jangboo_point.php')">포인트 결제관리</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=37')">유료옵션 구인/구직 색상설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=52')">유료옵션 구인/구직 색상설정(모바일)</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=23')">통계 계정 및 코드설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_analytics.php')">접속통계 요약정보</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>


				</td>
			</tr>
			<tr>
				<td height=17 background="sitemap/img/bgbox_menu02c.jpg"></td>
			</tr>
			</table>
		</div>
		<!-- 메뉴 - 결제/통계관리 [ end ] -->



		<!-- 메뉴 - 서비스관리 [ start ] -->
		<div id=sitemap_menu>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!-- 메인메뉴명 -->
				<td height=66 background="sitemap/img/bgbox_menu02a.jpg"><div class=menu_title>서비스관리</div></td>
			</tr>
			<tr>
				<td align=center style="padding-top:20px;" background="sitemap/img/bgbox_menu02b.jpg">

					<!-- 서브메뉴 [SMS관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle><font style="letter-spacing:0;">SMS</font>관리</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:void(0);" onclick="javascript:window.open('sms','happysms_admintool','width=560,height=650,scrolling=no,toolbar=no')">SMS 관리설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=32')">SMS/쪽지 발송설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=18')">SMS계정 및 발송설정</A>
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
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=17')">실명인증 및 성인인증</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=4')">지도 API 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/weather_reset.php')">날씨정보리셋 바로실행</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

				</td>
			</tr>
			<tr>
				<td height=17 background="sitemap/img/bgbox_menu02c.jpg"></td>
			</tr>
			</table>
		</div>
		<!-- 메뉴 - 서비스관리 [ end ] -->


		<!-- 메뉴 - 디자인관리 [ start ] -->
		<div id=sitemap_menu>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!-- 메인메뉴명 -->
				<td height=66 background="sitemap/img/bgbox_menu02a.jpg"><div class=menu_title>디자인관리</div></td>
			</tr>
			<tr>
				<td align=center style="padding-top:20px;" background="sitemap/img/bgbox_menu02b.jpg">

					<!-- 서브메뉴 [이미지관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>이미지관리</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/main_logo_admin.php')">사이트로고 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_icon_admin.php')">이미지 관리 및 색상설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_icon_admin.php?type=add')">템플릿 이미지등록</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/logo_bgimage.php')">회사로고 배경이미지 관리</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=30')">기타 아이콘 설정</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [플래시관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>배너 ㅣ 팝업관리</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/banner_admin.php')">통합배너관리</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=24')">외부 광고태그</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/banner_admin_slide.php')">슬라이드 배너관리</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/popup_admin.php')">팝업관리</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/popup_admin.php?mode=add')">팝업정보등록</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=5')">팝업환경설정</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>

					<!-- 서브메뉴 [배너관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>기타설정</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/poll_admin.php')">투표관리</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=31')">회사소개 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=25')">템플릿 파일명보기</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/tagview.php')">태그생성기</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>



				</td>
			</tr>
			<tr>
				<td height=17 background="sitemap/img/bgbox_menu02c.jpg"></td>
			</tr>
			</table>
		</div>
		<!-- 메뉴 - 디자인관리 [ end ] -->



		<!-- 메뉴 - 고급자설정 [ start ] -->
		<div id=sitemap_menu>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!-- 메인메뉴명 -->
				<td height=66 background="sitemap/img/bgbox_menu02a_rux.jpg"><div class=menu_title>고급자설정</div></td>
			</tr>
			<tr>
				<td align=center style="padding-top:20px;" background="sitemap/img/bgbox_menu02b.jpg">

					<!-- 서브메뉴 [디자인관리] -->
					<div class=submenu>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><div class=menu_subtitle>고급설정</div></td>
						</tr>
						<tr>
							<td>
								<UL>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/dbinfo.php')">DB 테이블정보</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_config_view.php?number=9')">개발자용 설정</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_admin_ip.php')">관리자 접속리스트</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/happy_img_resize.php?step=2')">이미지 사이즈변경</A>
									<LI><A href="javascript:siteOpen_selfClose('<?=$main_url_admin?>/data_initialization.php')">자료 초기화</A>
								</UL>
							</td>
						</tr>
						</table>
					</div>


				</td>
			</tr>
			<tr>
				<td height=17 background="sitemap/img/bgbox_menu02c.jpg"></td>
			</tr>
			</table>
		</div>
		<!-- 메뉴 - 고급자설정 [ end ] -->

	</div>

</div>


</BODY>
</HTML>
