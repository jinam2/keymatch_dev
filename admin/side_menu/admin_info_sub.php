<?
	#관리자정보
	echo adminMain_site_stat();

	#카운트정보
	//echo adminMain_site_count();

	#======================================================================================================================

	#관리자정보
	function adminMain_site_stat()
	{
		global $site_name, $master_name, $admin_email, $admin_id, $main_url;
		$site_stat	= "
						<!-- 관리자정보 -->
						<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin:0 0 15 0;\">
						<tr>
							<td height=27 class=\"admin_info01\"></td>
						</tr>
						<tr>
							<td class=\"admin_info02\">

								<UL id=admin_info_list>
									<LI>사이트관리자<br>
									<div class=\"admin_info_list_value\"><strong>$master_name</strong></div>

									<LI>관리자이메일주소<br>
									<div class=\"admin_info_list_value\">$admin_email</div>
								</UL>

							</td>
						</tr>
						</table>
					";

		return $site_stat;
	}


	#======================================================================================================================


	#카운트정보
	function adminMain_site_count()
	{
		global $per_tb, $links, $admin_member, $happy_banner_tb, $board_list;
		$Sql	= "SELECT COUNT(*) FROM $per_tb ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$MemberCount	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $links ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$LinksCount	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $admin_member ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$AdminCount	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $links where pop > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$pop_count	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $links where new > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$new_count	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $links where pick > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$pick_count	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $links where spec > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$spec_count	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $links where hompi_end_date > curdate() ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$hompi_count	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $links WHERE wait = '1' ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$wait_upso_count	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $links WHERE coopon!='' ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$coopon_upso_count	= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $happy_banner_tb ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$banner_count		= $Data[0];

		$Sql	= "SELECT COUNT(*) FROM $board_list ";
		$Data	= happy_mysql_fetch_array(query($Sql));
		$board_count		= $Data[0];

		$site_count	= "
						<!-- 카운트정보 -->
						<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						<tr>
							<td height=27 class=\"count_info01\"></td>
						</tr>
						<tr>
							<td class=\"count_info02\">

								<UL id=count_info_list>
									<LI>전체회원수<br>
									<div class=\"count_info_list_value\">$MemberCount <font class=unit>명</font></div>

									<LI>부관리자수<br>
									<div class=\"count_info_list_value\">$AdminCount <font class=unit>명</font></div>
									<div class=\"admin_line\"><div></div></div> <!-- Line -->

									<LI>전체업체정보수<br>
									<div class=\"count_info_list_value\">$LinksCount <font class=unit>개</font></div>

									<LI>대기업체수<br>
									<div class=\"count_info_list_value\">$wait_upso_count <font class=unit>개</font></div>

									<LI>신규업체수<br>
									<div class=\"count_info_list_value\">$new_count <font class=unit>개</font></div>

									<LI>추천업체수<br>
									<div class=\"count_info_list_value\">$pick_count  <font class=unit>개</font></div>

									<LI>인기업체수<br>
									<div class=\"count_info_list_value\">$pop_count  <font class=unit>개</font></div>

									<LI>프리미엄업체수<br>
									<div class=\"count_info_list_value\">$spec_count <font class=unit>개</font></div>

									<LI>쿠폰등록업체수<br>
									<div class=\"count_info_list_value\">$coopon_upso_count  <font class=unit>개</font></div>
									<div class=\"admin_line\"><div></div></div> <!-- Line -->

									<LI>미니홈등록업체수<br>
									<div class=\"count_info_list_value\">$hompi_count  <font class=unit>개</font></div>
									<div class=\"admin_line\"><div></div></div> <!-- Line -->

									<LI>등록된 배너수<br>
									<div class=\"count_info_list_value\">$banner_count <font class=unit>개</font></div>

									<LI>등록된 게시판수<br>
									<div class=\"count_info_list_value\">$board_count  <font class=unit>개</font></div>
								</UL>


							</td>
						</tr>
						</table>
		";
		return $site_count;

	}

?>