<? /* Created by SkyTemplate v1.1.0 on 2023/04/13 16:50:43 */
function SkyTpl_Func_3782883682 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript">
<!--
function open_window(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
{
 toolbar_str = toolbar ? 'yes' : 'no';
 menubar_str = menubar ? 'yes' : 'no';
 statusbar_str = statusbar ? 'yes' : 'no';
 scrollbar_str = scrollbar ? 'yes' : 'no';
 resizable_str = resizable ? 'yes' : 'no';
 window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
}

// -->
</script>
<script language="javascript">
<!--
	function bbsdel2(strURL) {
		var msg = "삭제하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
	-->
</script>
<script language="javascript">
<!--
	function magam(strURL) {
		var msg = "해당 구인정보를 마감하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}
	-->
</script>

<script language="JavaScript">

//신청중인채용/입사제의목록 탭
function ChangeTab1(str)
{
	if ( str == "1" )
	{
		document.getElementById('div_guin_1').style.display='';
		document.getElementById('div_guin_2').style.display='none';
		document.getElementById('div_guin_3').style.display='none';
		document.getElementById('div_guin_4').style.display='';
		document.getElementById('div_guin_5').style.display='';
		document.getElementById('div_guin_6').style.display='none';
		document.getElementById('div_guin_more').href='member_guin.php';

	}
	else if ( str == "2" )
	{
		document.getElementById('div_guin_1').style.display='none';
		document.getElementById('div_guin_2').style.display='';
		document.getElementById('div_guin_3').style.display='';
		document.getElementById('div_guin_4').style.display='none';
		document.getElementById('div_guin_5').style.display='none';
		document.getElementById('div_guin_6').style.display='';
		document.getElementById('div_guin_more').href='member_guin.php?type=magam';
	}
}

function ChangeTab2(str)
{
	if ( str == "1" )
	{
		document.getElementById('div_pay_1').style.display='';
		document.getElementById('div_pay_2').style.display='none';
		document.getElementById('div_pay_3').style.display='none';
		document.getElementById('div_pay_4').style.display='';
		document.getElementById('div_pay_5').style.display='';
		document.getElementById('div_pay_6').style.display='none';
		document.getElementById('div_pay_more').href='my_point_jangboo.php';

	}
	else if ( str == "2" )
	{
		document.getElementById('div_pay_1').style.display='none';
		document.getElementById('div_pay_2').style.display='';
		document.getElementById('div_pay_3').style.display='';
		document.getElementById('div_pay_4').style.display='none';
		document.getElementById('div_pay_5').style.display='none';
		document.getElementById('div_pay_6').style.display='';
		document.getElementById('div_pay_more').href='my_jangboo_com.php';
	}
}


function want_del(want_number) {
	str = "입사제의 한 이력서를 삭제하시겠습니까?";
	if ( confirm( str ) )
	{
		document.location = "com_guin_want.php?mode=del&cNumber=" + want_number;
	}
}
</script>
<style>
	/* 기업회원 마이페이지 내에서 사용하는 탭스타일 */
	.tab td{border:1px solid #dfdfdf; border-bottom:2px solid #<?=$_data['배경색']['서브색상']?> !important; font-weight:bold}
	.tab .menu_off{color:#999999; background:#fafafa; font-size:16px; letter-spacing:-1px; text-align:center; cursor:pointer; height:50px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
	.tab .menu_on{background:#<?=$_data['배경색']['서브색상']?>; border:1px solid #<?=$_data['배경색']['서브색상']?> !important; font-size:16px; letter-spacing:-1px; text-align:center; cursor:pointer;  height:50px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
	.tab .menu_on a{color:#fff}

	.tab2 td{border:1px solid #dfdfdf; border-bottom:2px solid #<?=$_data['배경색']['서브페이지']?> !important; font-weight:bold}
	.tab2 .menu_off2{color:#999999; background:#fafafa; font-size:16px; letter-spacing:-1px; text-align:center; cursor:pointer; height:50px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
	.tab2 .menu_on2{background:#<?=$_data['배경색']['서브색상']?>; border:1px solid #<?=$_data['배경색']['서브색상']?> !important; font-size:16px; letter-spacing:-1px; text-align:center; cursor:pointer;  height:50px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
	.tab2 .menu_on2 a{color:#fff}
</style>


<div class="tab_new">
	<a href="/happy_member.php?mode=mypage" class="on">이력서관리</a>
	<a href="/happy_member.php?mode=mypage">초빙정보관리</a>
</div>



<div class="noto500 font_25" style="position:relative; color:#333333; letter-spacing:-1px; padding-bottom:15px;">
	개인정보관리 <span class="noto400 font_15" style="color:#777777; letter-spacing:-1px;"><span style="color:#<?=$_data['배경색']['서브색상']?>;"><?=$_data['MEM']['boss_name']?></span>님은 <?=$_data['회원그룹명']?>입니다.</span>
	<span style="position:absolute; top:0px; right:0">

		<a href="happy_member.php?mode=modify">
			<span class='font_14 noto400' style='background:#<?=$_data['배경색']['기본색상']?>; color:#fff; border:1px solid #<?=$_data['배경색']['기본색상']?>; width:110px; height:30px; display:inline-block; border-radius:15px; text-align:center; line-height:30px;'>회원정보수정</span>
		</a>
	</span>
</div>

<div style="margin-bottom:20px">
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed">
		<tr>
			<td style="width:865px; vertical-align:top; padding-right:10px; background:url('./img/line_02.gif') right top repeat-y">
				<div style="padding:28px 30px; border:1px solid #d4d4d4">
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td style="width:256px; text-align:center; padding-right:20px">
								<span style="display:block; padding-bottom:10px;"><?=$_data['MEM']['logo_temp']?></span>
								<span style="display:block">
									<a href="javascript:open_window('com_log', './logo_change.php?per_info_id=<?=$_data['MEM']['id']?>',0,0,480,430,0,0,0,1,0)">
										<img src="img/btn_mypage_myphotomod.gif" align="absmiddle" border="0" style="margin-top:10px;">
									</a>
								</span>
								<span style="display:block; padding:10px 0; color:#666666" class="font_13 noto400">
									<?=$_data['MEM']['user_homepage']?>

								</span>
							</td>
							<td style="vertical-align:top">
								<h4 style="position:relative; color:#333; letter-spacing:-1px; padding-bottom:6px; margin:0;" class="font_20 noto500">
									<?=$_data['MEM']['com_name']?>

								</h4>
								<div style="position:relative">
									<div id="view1" style="position:absolute; top:0; left:0; display:none" >
										<table cellpadding="0" cellspacing="0" style="width:100%" class="mymain_cominfo">
											<tr style="display:<?=$_data['HAPPY_CONFIG']['point_charge_use']?>;">
												<th class="font_14 noto400 title_1">마일리지포인트</th>
												<td class="font_14 noto400 sub_1">
													<?=$_data['MEM']['point_comma']?> P
													<a href="#point_charge" onclick="window.open('my_point_charge.php','charge_win','width=540,height=360,scrollbars=no')" onfocus='this.blur();'>
														<img src="img/sth_more_btn.png" style="vertical-align:middle">
													</a>
												</td>
											</tr>
											<tr>
												<th class="font_14 noto400 title_1">문자발송 포인트</th>
												<td class="font_14 noto400 sub_1">
													<?=$_data['COMMEMBER']['smspoint_comma']?> P
													 <a href="member_option_pay2.php">
														<img src="img/sth_more_btn.png" style="vertical-align:middle">
													</a>
												</td>
											</tr>
											<tr>
												<th class="font_14 noto400 title_1">이력서뷰 유효일</th>
												<td class="font_14 noto400 sub_1">
													<?=$_data['COMMEMBER']['docview_period_comma']?> 일
													 <a href="member_option_pay2.php">
														<img src="img/sth_more_btn.png" style="vertical-align:middle">
													</a>
												</td>
											</tr>
											<tr>
												<th class="font_14 noto400 title_1">이력서뷰 가능횟수</th>
												<td class="font_14 noto400 sub_1">
													<?=$_data['COMMEMBER']['docview_count_comma']?> 회
													 <a href="member_option_pay2.php">
														<img src="img/sth_more_btn.png" style="vertical-align:middle">
													</a>
												</td>
											</tr>
											<tr>
												<th class="font_14 noto400 title_1">패키지옵션</th>
												<td class="font_14 noto400 sub_1">
													<a href="my_package_list.php" style="color:#333" title="보유현황 바로가기">
														보유현황 바로가기
													</a>
													<a href="my_package_list.php" title="보유현황 바로가기">
														<img src="img/sth_more_btn.png" style="vertical-align:middle">
													</a>
												</td>
											</tr>
										</table>
									</div>
									<table cellpadding="0" cellspacing="0" style="width:100%" class="mymain_cominfo">
										<tr>
											<th class="font_14 noto400 title">대표자명</th>
											<td class="font_14 noto400 sub">
												<span class="ellipsis_line_1" style="display:block; overlfow:hidden; width:161px; line-height:40px; height:40px">
													<?=$_data['MEM']['boss_name']?>

												</span>
											</td>
											<th class="font_14 noto400 title">사업내용</th>
											<td class="font_14 noto400 sub">
												<span class="ellipsis_line_1" style="display:block; overlfow:hidden; width:161px; line-height:40px; height:40px">
													<?=$_data['MEM']['extra14']?>

												</span>
											</td>
										</tr>
										<tr>
											<th class="font_14 noto400 title">직원수</th>
											<td class="font_14 noto400 sub">
												<span class="ellipsis_line_1" style="display:block; overlfow:hidden; width:161px; line-height:40px; height:40px">
													<?=$_data['MEM']['com_worker_cnt']?>명
												</span>
											</td>
											<th class="font_14 noto400 title">자본금</th>
											<td class="font_14 noto400 sub">
												<span class="ellipsis_line_1" style="display:block; overlfow:hidden; width:161px; line-height:40px; height:40px">
													<?=$_data['MEM']['extra15']?>

												</span>
											</td>
										</tr>
										<tr>
											<th class="font_14 noto400 title">설립연도</th>
											<td class="font_14 noto400 sub">
												<span class="ellipsis_line_1" style="display:block; overlfow:hidden; width:161px; line-height:40px; height:40px">
													<?=$_data['MEM']['extra1']?>년도
												</span>
											</td>
											<th class="font_14 noto400 title">매출액</th>
											<td class="font_14 noto400 sub">
												<span class="ellipsis_line_1" style="display:block; overlfow:hidden; width:161px; line-height:40px; height:40px">
													<?=$_data['MEM']['extra17']?>

												</span>
											</td>
										</tr>
										<tr>
											<th class="font_14 noto400 title">업종</th>
											<td colspan="3" class="font_14 noto400 sub">
												<span class="ellipsis_line_1" style="display:block; overlfow:hidden; width:400px; line-height:40px; height:40px">
													<?=$_data['MEM']['com_job']?>

												</span>
											</td>
										</tr>
										<tr>
											<th class="font_14 noto400 title">주소</th>
											<td colspan="3"  class="font_14 noto400 sub">
												<span class="ellipsis_line_1" style="display:block; overlfow:hidden; width:400px; line-height:40px; height:40px">
													(<?=$_data['MEM']['com_zip']?>) <?=$_data['MEM']['com_addr1']?> <?=$_data['MEM']['com_addr2']?>

												</span>
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</td>
			<td align="right" style="padding-left:10px">
				<?echo happy_banner('유료옵션신청','배너제목','랜덤') ?>

			</td>
		</tr>
	</table>
</div>

<div class="noto500 font_24" style="position:relative; color:#333333; letter-spacing:-1px; margin:50px 0 15px 0;">
	초빙공고관리
	<span style="position:absolute; right:0">
		<?include_template('happy_member_mypage_com_head.html') ?>

		<a href="member_option_pay.php?mode=pay">
			<span style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; box-sizing:border-box; padding:3px 15px; border-radius:15px;"><i style="color:#<?=$_data['배경색']['기본색상']?>; font-style:normal;">AD</i> 유료옵션신청</span>
		</a>
		<a href="guin_regist.php">
			<span style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">초빙공고등록</span>
		</a>
	</span>
</div>

<div>
<table cellspacing="0" class="tab" cellpadding="0" style="width:100%; table-layout:fixed; border-collapse: collapse">
	<tr>
		<td class="menu_on" overClass="menu_on" outClass="menu_off" id="class_div_1" onMouseOver="happy_tab_menu('class_div','1');">
			<a href="member_guin.php?type=all" style="display:block; line-height:52px">전체 초빙공고 ( <?=$_data['COMMEMBER']['guin_total_cnt_comma']?> )</a>
		</td>
		<td class="menu_off" overClass="menu_on" outClass="menu_off" id="class_div_2" onMouseOver="happy_tab_menu('class_div','2');">
			<a href="member_guin.php" style="display:block; line-height:52px">진행중인 초빙공고 ( <?=$_data['COMMEMBER']['ing_cnt_comma']?> )</a>
		</td>
		<td class="menu_off" overClass="menu_on" outClass="menu_off" id="class_div_3" onMouseOver="happy_tab_menu('class_div','3');">
			<a href="member_guin.php?type=magam" style="display:block; line-height:52px">마감된 초빙공고 ( <?=$_data['COMMEMBER']['magam_cnt_comma']?> )</a>
		</td>
	</tr>
</table>
</div>
<div style="padding:15px 0 0 0">
	<div id="class_div_layer_1" style="border-top:1px solid #dfdfdf">
		<?echo guin_extraction_myreg('총3개','가로1개','제목길이60자','전체','mypage_member_guin_list_rows.html','사용안함') ?>

		<div><?=$_data['구인리스트페이징']?></div>
	</div>
	<div id="class_div_layer_2" style="display:none; border-top:1px solid #dfdfdf">
		<?echo guin_extraction_myreg('총3개','가로1개','제목길이60자','진행중','mypage_member_guin_list_rows.html','사용안함') ?>

	</div>
	<div id="class_div_layer_3" style="display:none; border-top:1px solid #dfdfdf">
		<?echo guin_extraction_myreg('총3개','가로1개','제목길이60자','마감','mypage_member_guin_list_rows.html','사용안함') ?>

	</div>
</div>
<div style="padding:50px 0 0 0">
	<?echo happy_banner('패키지옵션','배너제목','랜덤') ?>

</div>
<!-- 인재정보관리 -->
<div class="noto500 font_24" style="position:relative; color:#333333; letter-spacing:-1px; margin:50px 0 15px 0;">
	인재정보관리
	<span style="position:absolute; bottom:3px; right:0">
		<a href="html_file.php?file=today_view_resume.html&file2=happy_member_default_mypage_com.html" title="오늘 본 인재정보">
			<img src="./img/btn_today_veiw_ppl.png" alt="오늘 본 인재정보">
		</a>
		<a href="html_file.php?file=com_payendper.html&file2=happy_member_default_mypage_com.html" title="이력서 열람관리">
			<img src="./img/btn_rsum_set.png" alt="이력서 열람관리">
		</a>
		<a href="member_guin.php?type=scrap" title="초빙공고별 스크랩">
			<img src="./img/btn_recuit_scrap.png" alt="초빙공고별 스크랩">
		</a>
		<a href="com_want_search.php?mode=setting_form" title="맞춤인재설정">
			<img src="img/btn_ppl_set.png" alt="맞춤인재설정">
		</a>
		<a href="com_want_search.php?mode=list" title="맞춤인재정보">
			<img src="img/skin_icon/make_icon/skin_icon_702.jpg" alt="맞춤인재정보">
		</a>
	</span>
</div>

<table cellspacing="0" class="tab2" cellpadding="0" style="width:100%; table-layout:fixed; border-collapse: collapse">
	<tr>
		<td class="menu_on2" overClass="menu_on2" outClass="menu_off2" id="class_div2_1" onMouseOver="happy_tab_menu('class_div2','1');">
			<a href="com_guin_want.php?mode=perview" style="display:block; line-height:52px">면접제의 인재관리 ( <?=$_data['COMMEMBER']['interview_cnt_comma']?> )</a>
		</td>
		<td class="menu_off2" overClass="menu_on2" outClass="menu_off2" id="class_div2_2" onMouseOver="happy_tab_menu('class_div2','2');">
			<a href="com_guin_want.php?mode=interview" style="display:block; line-height:52px">입사제의 인재관리 ( <?=$_data['COMMEMBER']['req_cnt_comma']?> )</a>
		</td>
		<td class="menu_off2" overClass="menu_on2" outClass="menu_off2" id="class_div2_3" onMouseOver="happy_tab_menu('class_div2','3');">
			<a href="guzic_list.php?file=member_guin_scrap" style="display:block; line-height:52px">스크랩한 이력서 ( <?=$_data['COMMEMBER']['scrap_cnt1_comma']?> )</a>
		</td>
	</tr>
</table>
<div>
	<div id="class_div2_layer_1" style="border-top:1px solid #dfdfdf">
		<?guin_extraction('총5개','가로1개','제목길이400자','자동','자동','자동','자동','일반','면접제의','mypage_guin_want_list_rows.html','','사용안함','','최근등록일순') ?>

	</div>
	<div id="class_div2_layer_2" style="display:none; border-top:1px solid #dfdfdf">
		<?guin_extraction('총3개','가로1개','제목길이400자','자동','자동','자동','자동','일반','입사제의','mypage_guin_want_list_rows.html','','사용안함','','최근등록일순') ?>

	</div>
	<div id="class_div2_layer_3" style="display:none; border-top:1px solid #dfdfdf">
		<?document_extraction_list('가로1개','세로3개','옵션1','옵션2','인재스크랩','옵션4','최근등록일순','글자짜름','누락0개','mypage_guin_scrap_list_rows.html','페이징사용안함') ?>

	</div>
</div>
<div style="border:2px solid #666666; margin-top:50px;">
	<table cellpadding="0" cellspacing="0" style="width:100%;background:#f8f8f8">
		<tr>
			<td style="padding-left:20px; letter-spacing:-1.2px; color:#333; height:50px" class="font_18 noto400">
				<a href="com_want_search.php?mode=list" style="color:#333">맞춤인재정보 ( <?=$_data['맞춤인재정보수']?> )</a>
			</td>
			<td style="text-align:right; letter-spacing:-1px; color:#bfbfbf; padding-right:20px" class="font_14 noto400">
				회원님의 등록한 맞춤정보를 바탕으로 사이트에 등록된 이력서를 자동으로 검색해주는 서비스입니다.
			</td>
		</tr>
	</table>
	<div>
		<?document_extraction_list('가로1개','세로2개','옵션1','옵션2','맞춤구직정보','옵션4','최근등록일순','글자짜름','누락0개','mypage_guin_ordered_list_rows.html','페이징사용안함') ?>

	</div>
</div>



























<!--개인회원-->
<script language="JavaScript">

	function want_del(want_number) {
		str = "입사제의 한 이력서를 삭제하시겠습니까?";
		if ( confirm( str ) )
		{
			document.location = "per_guin_want.php?mode=del&cNumber=" + want_number;
		}
	}

	//신청중인채용/입사제의목록 탭
	function ChangeTab1(str)
	{
		if ( str == "1" )
		{
			document.getElementById('div_guin_1').style.display='';
			document.getElementById('div_guin_2').style.display='none';
			document.getElementById('div_guin_3').style.display='none';
			document.getElementById('div_guin_4').style.display='';
			document.getElementById('div_guin_5').style.display='';
			document.getElementById('div_guin_6').style.display='none';
			document.getElementById('div_guin_more').href='html_file.php?file=my_guin_add.html';

		}
		else if ( str == "2" )
		{
			document.getElementById('div_guin_1').style.display='none';
			document.getElementById('div_guin_2').style.display='';
			document.getElementById('div_guin_3').style.display='';
			document.getElementById('div_guin_4').style.display='none';
			document.getElementById('div_guin_5').style.display='none';
			document.getElementById('div_guin_6').style.display='';
			document.getElementById('div_guin_more').href='per_guin_want.php';
		}
	}

	function ChangeTab2(str)
	{
		if ( str == "1" )
		{
			document.getElementById('div_pay_1').style.display='';
			document.getElementById('div_pay_2').style.display='none';
			document.getElementById('div_pay_3').style.display='none';
			document.getElementById('div_pay_4').style.display='';
			document.getElementById('div_pay_5').style.display='';
			document.getElementById('div_pay_6').style.display='none';
			document.getElementById('div_pay_more').href='my_point_jangboo.php';

		}
		else if ( str == "2" )
		{
			document.getElementById('div_pay_1').style.display='none';
			document.getElementById('div_pay_2').style.display='';
			document.getElementById('div_pay_3').style.display='';
			document.getElementById('div_pay_4').style.display='none';
			document.getElementById('div_pay_5').style.display='none';
			document.getElementById('div_pay_6').style.display='';
			document.getElementById('div_pay_more').href='my_jangboo_per.php';
		}
	}

	function confirm_del(cNumber)
	{
		if (confirm("스크랩한 초빙정보를 삭제하시겠습니까?"))
		{
			document.location = "scrap.php?mode=per_del&cNumber=" + cNumber;
		}
	}
	//-->

</script>
<style>
	.tab td{border:1px solid #dfdfdf; border-bottom:2px solid #<?=$_data['배경색']['기타페이지2']?> !important; font-weight:bold}
	.tab .menu_off{color:#999999; background:#fafafa; font-size:16px; letter-spacing:-1px; text-align:center; cursor:pointer; height:50px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
	.tab .menu_on{background:#<?=$_data['배경색']['기타페이지2']?>; border:1px solid #<?=$_data['배경색']['기타페이지2']?> !important; font-size:16px; letter-spacing:-1.2px; text-align:center; cursor:pointer;  height:50px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
	.tab .menu_on a{color:#fff}

	.tab2 td{border:1px solid #dfdfdf; border-bottom:2px solid #<?=$_data['배경색']['기타페이지']?> !important; font-weight:bold}
	.tab2 .menu_off2{color:#999999; background:#fafafa; font-size:16px; letter-spacing:-1px; text-align:center; cursor:pointer; height:50px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
	.tab2 .menu_on2{background:#<?=$_data['배경색']['기타페이지']?>; border:1px solid #<?=$_data['배경색']['기타페이지']?> !important; font-size:16px; letter-spacing:-1.2px; text-align:center; cursor:pointer;  height:50px; font-family: 'Noto Sans KR' !important; font-weight:400 !important;}
	.tab2 .menu_on2 a{color:#fff}
</style>







<div class="noto500 font_24" style="position:relative; color:#333333; letter-spacing:-1px; margin:50px 0 15px 0;">
	이력서관리
	<span style="position:absolute; bottom:3px; right:0">
		<a href="document.php?mode=add">
			<span style="display:inline-block; font-size:17px; color:#fff; background:#<?=$_data['배경색']['서브색상']?>; padding:3px 45px; line-height:40px;  border-radius:35px;">이력서 등록</span>
		</a>
	</span>
</div>

<div>
	<table cellspacing="0" class="tab" cellpadding="0" style="width:100%; table-layout:fixed; border-collapse: collapse">
		<tr>
			<td class="menu_on" overClass="menu_on" outClass="menu_off" id="class_div_1" onMouseOver="happy_tab_menu('class_div','1');">
				<a href="html_file_per.php?file=member_regph.html" style="display:block; line-height:52px">내 이력서관리 ( <?=$_data['PERMEMBER']['guzic_total_cnt_comma']?> )</a>
			</td>
	<!-- 		<td class="menu_off" overClass="menu_on" outClass="menu_off" id="class_div_2" onMouseOver="happy_tab_menu('class_div','2');">
				<a href="html_file_per.php?file=member_regph_ing.html" style="display:block; line-height:52px">맞춤초빙정보 ( <?=$_data['PERMEMBER']['use_cnt_comma']?> )</a>
			</td> -->

	<td class="menu_off" overClass="menu_on" outClass="menu_off" id="class_div_2" onMouseOver="happy_tab_menu('class_div','2');">
				<a href="html_file_per.php?mode=resume_job_application_online" style="display:block; line-height:52px">맞춤초빙정보 <!-- ( <?=$_data['PERMEMBER']['use_cnt_comma']?> ) --></a>
			</td>




		</tr>
	</table>
</div>
<div style="padding:20px 0 0 0">
	<div id="class_div_layer_1" style="border-top:1px solid #dfdfdf">
		<?document_extraction_list_main('가로1개','세로3개','옵션1','옵션2','옵션3','내가등록한이력서','최근등록일순','30글자짜름','누락0개','mypage_member_guzic_list_rows.html') ?>

	</div>
	<div id="class_div_layer_2" style="display:none; border-top:1px solid #dfdfdf">
		<?document_extraction_list_main('가로1개','세로3개','옵션1','옵션2','옵션3','내가등록한공개중인이력서','최근등록일순','30글자짜름','누락0개','mypage_member_guzic_list_rows.html') ?>

	</div>
	<div id="class_div_layer_3" style="display:none; border-top:1px solid #dfdfdf">
		<?document_extraction_list_main('가로1개','세로3개','옵션1','옵션2','옵션3','내가등록한비공개중인이력서','최근등록일순','30글자짜름','누락0개','mypage_member_guzic_list_rows.html') ?>

	</div>
</div>
<div class="noto500 font_24" style="position:relative; color:#333333; letter-spacing:-1px; margin:50px 0 15px 0;">
	입사지원 관리
<!-- 	<span style="position:absolute; bottom:3px; right:0">
		
		<a href="html_file_per.php?file=my_guin_activities.html" title="초빙활동 증명서">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">초빙활동 증명서</span>
		</a>
		<a href="html_file_per.php?mode=per_guin_view" title="초빙공고 열람관리">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">초빙공고 열람관리</span>
		</a>
		<a href="per_no_view_list.php" title="이력서 열람불가 설정">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">이력서 열람불가 설정</span>
		</a>
		<a href="per_want_search.php?mode=setting_form" title="맞춤 초빙공고 설정">
			<span class="font_15 noto400" style="display:inline-block; font-size:15px; color:#999; border:1px solid #ddd; background:#fff; padding:3px 15px; border-radius:15px;">맞춤 초빙공고 설정</span>
		</a>
		<a href="per_want_search.php?mode=list" title="맞춤 초빙공고">
			<span  style="display:inline-block; font-size:15px; color:#fff; background:#<?=$_data['배경색']['기본색상']?>; padding:3px 15px; border-radius:15px;">맞춤초빙공고</span>
		</a>
	</span> -->
</div>
<table cellspacing="0" class="tab2" cellpadding="0" style="width:100%; table-layout:fixed; border-collapse: collapse">
	<tr>
		<td class="menu_on2" overClass="menu_on2" outClass="menu_off2" id="class_div2_1" onMouseOver="happy_tab_menu('class_div2','1');">
			<a href="html_file_per.php?mode=resume_job_application_online" style="display:block; line-height:52px">온라인 입사지원 ( <?=$_data['PERMEMBER']['online_cnt_comma']?> )</a>
		</td>
		<td class="menu_off2" overClass="menu_on2" outClass="menu_off2" id="class_div2_2" onMouseOver="happy_tab_menu('class_div2','2');">
<!-- 			<a href="html_file_per.php?mode=resume_job_application_email" style="display:block; line-height:52px"> -->
			
			
						<a href="per_want_search.php?mode=list" style="display:block; line-height:52px">
			
			최근 열람한 초빙정보 ( <?=$_data['PERMEMBER']['email_cnt_comma']?> )</a>
		</td>
		<td class="menu_off2" overClass="menu_on2" outClass="menu_off2" id="class_div2_3" onMouseOver="happy_tab_menu('class_div2','3');">
			<a href="per_guin_want.php" style="display:block; line-height:52px">스크랩한 초빙정보 ( <?=$_data['PERMEMBER']['req_cnt_comma']?> )</a>
		</td>
		<td class="menu_off2" overClass="menu_on2" outClass="menu_off2" id="class_div2_4" onMouseOver="happy_tab_menu('class_div2','4');">
			<a href="per_guin_want.php?mode=preview" style="display:block; line-height:52px">면접제의받은 초빙공고 ( <?=$_data['PERMEMBER']['interview_cnt_comma']?> )</a>
		</td>
	</tr>
</table>
<div style="padding:20px 0 0 0">
	<div id="class_div2_layer_1" style="border-top:1px solid #dfdfdf">
		<?document_extraction_list('가로1개','세로3개','옵션1','옵션2','내가신청한구인(온라인)','옵션4','최근등록일순','글자30글자짜름','누락0개','mypage_regadd_guin_per_rows.html','페이징사용') ?>

	</div>
	<div id="class_div2_layer_2" style="display:none; border-top:1px solid #dfdfdf">
		<?document_extraction_list('가로1개','세로3개','옵션1','옵션2','내가신청한구인(이메일)','옵션4','최근등록일순','글자30글자짜름','누락0개','mypage_regadd_guin_per_rows.html','페이징사용') ?>

	</div>
	<div id="class_div2_layer_3" style="display:none; border-top:1px solid #dfdfdf">
		<?guin_extraction('총3개','가로1개','제목길이40자','자동','자동','자동','자동','일반','입사요청','mypage_guin_want_rows_per.html','누락0개','사용안함') ?>

	</div>
	<div id="class_div2_layer_4" style="display:none; border-top:1px solid #dfdfdf">
		<?guin_extraction('총3개','가로1개','제목길이40자','자동','자동','자동','자동','일반','면접요청','mypage_guin_want_rows_per.html','누락0개','사용안함') ?>

	</div>
</div>
<!--div style="border:2px solid #666666; margin-top:50px;">
	<table cellpadding="0" cellspacing="0" style="width:100%;background:#f8f8f8">
		<tr>
			<td style="padding-left:20px; letter-spacing:-1.2px; color:#333; height:50px" class="font_18 noto400">
				<a href="per_want_search.php?mode=list" style="color:#333">맞춤초빙공고 ( <?=$_data['맞춤초빙정보수']?> )</a>
			</td>
			<td style="text-align:right; letter-spacing:-1px; color:#bfbfbf; padding-right:20px" class="font_14 noto400">
				회원님의 등록한 맞춤정보를 바탕으로 사이트에 등록된 초빙공고를 자동으로 검색해주는 서비스입니다.
			</td>
		</tr>
	</table>
<div>
		<?guin_extraction_ajax('총2개','가로1개','제목길이999자','자동','자동','자동','자동','일반','자동','mypage_guin_set_list_rows.html','누락0개','사용안함','맞춤구인정보') ?>

	</div>
</div> -->


<div class="new_button_area">
<a href="/bbs_list.php?tb=board_qna">1:1 문의</a>
</div>

<? }
?>