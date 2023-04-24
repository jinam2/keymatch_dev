<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 11:50:19 */
function SkyTpl_Func_2013070971 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

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
	if (confirm("스크랩한 채용정보를 삭제하시겠습니까?"))
	{
		document.location = "scrap.php?mode=per_del&cNumber=" + cNumber;
	}
}
//-->
</script>



<script language="JavaScript">
<!--
var request;
function createXMLHttpRequest()
{
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}
	else {
		request = new ActiveXObject("Microsoft.XMLHTTP");
	}
}

function startRequest(sel,target,size)
{
	var trigger = sel.options[sel.selectedIndex].value;
	var form = sel.form.name;
		createXMLHttpRequest();
	request.open("GET", "sub_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
	request.onreadystatechange = handleStateChange;
	request.send(null);
}

function startRequest2(sel,target,size)
{
	var trigger = sel.options[sel.selectedIndex].value;
	var form = sel.form.name;
		createXMLHttpRequest();
	request.open("GET", "sub_type_select.php?form=" + form + "&trigger=" + trigger + "&target=" + target + "&size=" + size, true);
	request.onreadystatechange = handleStateChange;
	request.send(null);
}

function handleStateChange() {
	if (request.readyState == 4) {
		if (request.status == 200) {
			var response = request.responseText.split("---cut---");
			eval(response[0]+ '.innerHTML=response[1]');
			window.status="완료"
		}
	}
	if (request.readyState == 1)  {
		window.status="로딩중....."
	}
}

function searchbox(){

	for(i=1;i<=2;i++){
		if(document.getElementById(i).style.display == 'none'){
			document.getElementById(i).style.display='';
		}
		else{
			document.getElementById(i).style.display='none';
		}
	}

}
//-->
</script>
<script language="javascript" src="./js/underground.js"></script>
<h3 class="sub_tlt_st01" style="padding-bottom:30px; border-bottom:1px solid #ddd; box-sizing:border-box;" onclick="location.href='happy_member.php?mode=mypage'">
	<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['MEM']['user_name']?>님의 </b>
	<span>마이페이지</span>
</h3>

<div style="padding:10px">
	<!-- 회원정보 -->
	<div style="position:relative; padding:15px 10px; border-bottom:1px solid #dedede;text-align:left">
		<table style="width:100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td align="right" style="vertical-align:top; padding-right:20px; width:95px" class="mypage_per_img">
					<?=$_data['mem_photo']?>

				</td>
				<td style="">
					<table style="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%; table-layout:fixed">
					<tr>
						<td class="font_20 noto400" style="letter-spacing:-1px; font-weight:500">
							<?=$_data['MEM']['user_name']?> (<?=$_data['MEM']['userid_info']?>)
						</td>
					</tr>
					<tr>
						<td class="font_20 noto400" style="letter-spacing:-1px;">
							<?=$_data['MEM']['user_prefix']?> / <span style="letter-spacing:0;" class="font_tahoma"><?=$_data['MEM']['user_birth_year']?>-<?=$_data['MEM']['user_birth_month']?>-<?=$_data['MEM']['user_birth_day']?></span>
						</td>
					</tr>
					<tr>
						<td style="padding-top:5px">
							<span style="padding: 7px 0;text-align: center; display:inline-block;  border-radius: 5px; border: 1px solid #<?=$_data['배경색']['모바일_기본색상']?>; color:#<?=$_data['배경색']['모바일_기본색상']?>; letter-spacing:-1px; padding:7px;" onclick="location.href='./logo_change.php?per_info_id=<?=$_data['MEM']['id']?>'" >
								사진 등록/수정
							</span>
							<span style="padding: 7px 0; text-align: center; display:inline-block;  border-radius: 5px; border: 1px solid #bfbfbf; letter-spacing:-1px; padding:7px;" onclick="location.href='happy_member.php?mode=modify'" >
								<?=$_data['회원그룹명']?> 정보수정
							</span>
						</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" style="width:100%">
			<tr>
				<td style="padding-top:10px">
					<table style="100%" cellspacing="0" cellpadding="0" style="width:100%; " >
						<colgroup>
							<col width="115px"/>
							<col width="*"/>
						</colgroup>	
						<tbody>
							<tr>
								<th style="width:115px; color:#333; padding:5px 0; vertical-align:top; " class="noto400 font_16">
									전화
								</th>
								<td style="color:#666; padding:5px 0; vertical-align:top" class="font_16 font_tahoma"><?=$_data['MEM']['per_phone']?></td>
							</tr>
							<tr>
								<th style="color:#333; padding:5px 0; vertical-align:top" class="noto400 font_16">
									휴대폰
								</th>
								<td style="color:#666; padding:5px 0; vertical-align:top" class="font_16 font_tahoma"><?=$_data['MEM']['per_cell']?></td>
							</tr>
							<tr>
								<th style="color:#333; padding:5px 0; vertical-align:top " class="noto400 font_16">
									이메일
								</th>
								<td style="color:#666; padding:5px 0; vertical-align:top; word-break:break-all" class="font_16 font_tahoma"><?=$_data['MEM']['per_email']?></td>
							</tr>
							<tr>
								<th style="; color:#333; padding:5px 0; vertical-align:top" class="noto400 font_16">
									홈페이지
								</th>
								<td style="color:#666; padding:5px 0; vertical-align:top; word-break:break-all" class="font_16 font_tahoma"><?=$_data['Data']['user_homepage']?></td>
							</tr>
							<tr>
								<th style="color:#333; padding:5px 0; vertical-align:top" class="noto400 font_16">
									주소
								</th>
								<td class="noto400 font_16" style="letter-spacing:-1px; color:#666; padding:5px 0; vertical-align:top">
									(<?=$_data['MEM']['per_zip']?>)</label> <?=$_data['MEM']['per_addr1']?> <?=$_data['MEM']['per_addr2']?>

								</td>
							</tr>
							<tr>
								<th style="letter-spacing:-1px; color:#333; padding:5px 0; vertical-align:top" class="noto400 font_16">
									최근수정일
								</th>
								<td class="font_tahoma font_16" style="color:#666; padding:5px 0; vertical-align:top">
									<?=$_data['MEM']['mod_date']?>

								</td>
							</tr>
						</tbody>
						
					</table>
				</td>
			</tr>
		</table>
	</div>
	<br>
	<a href="document.php?mode=add" class="font_18 noto400" style="display:block; text-align:center; padding:15px 0; letter-spacing:-1px; border:1px solid #<?=$_data['배경색']['모바일_기본색상']?>; color:#fff; font-size:22px; border-radius:5px;background:#<?=$_data['배경색']['모바일_기본색상']?>; box-sizing:border-box; ">이력서등록</a>
	<br>
	<!-- 이력서 및 입사지원 카운트 -->
	<div style="border-top:1px solid #ddd;">
	<br>
		<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse:collapse;">
			<tr>
				<td class="font_16 noto400"  colspan="2" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center" onclick="location.href='html_file_per.php?file=member_regph.html'">
					<strong class="font_22 font_tahoma" style="display:block;" >
						<?=$_data['PERMEMBER']['guzic_total_cnt_comma']?>

					</strong>
					<span style="padding-top:5px">전체이력서</span>
				</td>
				<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center"  onclick="location.href='html_file_per.php?file=member_regph_ing.html'" style="display:block;">
					<strong class="font_22 font_tahoma" style="display:block;">
						<?=$_data['PERMEMBER']['use_cnt_comma']?>

					</strong>
					<span style="padding-top:5px">맞춤초빙정보</span>
				</td>
			
			</tr>
			<tr>
				<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center" onclick="location.href='html_file_per.php?mode=resume_job_application'">
					<strong class="font_22 font_tahoma" style="display:block;">
						<?=$_data['PERMEMBER']['jiwon_cnt_comma']?>

					</strong>
					<span style="padding-top:5px">전체입사지원</span>
				</td>
				<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center" onclick="location.href='html_file_per.php?mode=resume_job_application_online'">
					<strong class="font_22 font_tahoma" style="display:block;" >
					<?=$_data['PERMEMBER']['online_cnt_comma']?>

					</strong>
					<span style="padding-top:5px">온라인<br/>입사지원</span>
				</td>
				<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center" onclick="location.href='html_file_per.php?mode=resume_job_application_email'">
					<strong class="font_22 font_tahoma" style="display:block;" >
						<?=$_data['PERMEMBER']['email_cnt_comma']?>

					</strong>
					<span style="padding-top:5px">최근 열람한<br>초빙정보</span>
				</td>
			</tr>
			<tr>
				<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center" onclick="location.href='guin_scrap.php'">
					<strong class="font_22 font_tahoma" style="display:block;" >
						<?=$_data['채용정보스크랩수']?>

					</strong>
					<span style="padding-top:5px">채용정보<br/> 스크랩</span>
				</td>
				<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center" onclick="location.href='per_guin_want.php'">
					<strong class="font_22 font_tahoma" style="display:block;">
						<?=$_data['PERMEMBER']['req_cnt_comma']?></span>
					</strong>
					<span style="padding-top:5px">스크랩한<br>초빙정보</span>
				</td>
				<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center">
					<strong class="font_22 font_tahoma" style="display:block;">
						<?=$_data['PERMEMBER']['guinview_count']?><span style="font-weight:normal" class="font_10 noto400">회</span>
					</strong>
					<span style="padding-top:5px">채용열람가능</span>
				</td>
			</tr>
		</table>
	</div>
	
	<br>
	<table style="width:100%;" cellspacing="0" cellpadding="0" border="0" class="detail_chart_02">
		<colgroup>
			<col style="width:40%">
			<col style="">
		</colgroup>
		<tr>
			<th  class="" style="line-height:180%">채용열람가능일</th>
			<td style="text-align:right; padding-right:10px"  >
				<?=$_data['PERMEMBER']['guinview_period']?>일
			</td>
		</tr>
		<tr>
			<th  class="">내 이력서 열람회수</th>
			<td style="text-align:right; padding-right:10px" >
				<?=$_data['PERMEMBER']['view_cnt_comma']?>회
			</td>
		</tr>
		<tr style="display:<?=$_data['HAPPY_CONFIG']['point_charge_use']?>;">
			<th style="display:<?=$_data['HAPPY_CONFIG']['point_charge_use']?>;" onclick="location.href='my_point_jangboo.php'">나의포인트</th>
			<td style="display:<?=$_data['HAPPY_CONFIG']['point_charge_use']?>;text-align:right; padding-right:10px; color:#<?=$_data['배경색']['모바일_서브색상']?>; letter-spacing:0" class="font_tahoma" onclick="location.href='my_point_jangboo.php'">
				<?=$_data['MEM']['point_comma']?> point
			</td>
		</tr>
	</table>
<!-- 	<div class="font_16 noto400" style="letter-spacing:-1px; margin-top:15px">
		<a href="./my_jangboo_per.php" style="display:block; border:1px solid #bfbfbf; padding:10px 0; text-align:center">유료결제내역</a>
	</div> -->
</div>
<!-- 입사지원 및 제의목록 -->
<table cellspacing="0" cellpadding="0" class="mypage_tab" style="margin-top:25px">
	<tr>
		<td class="mypage_on" overClass="mypage_on" outClass="mypage_off" id="class_kwak_div_1" onClick="happy_tab_menu('class_kwak_div','1');" style="border-top:2px solid #d8d8d8; border-left:2px solid #d8d8d8;">
			입사지원목록</td>
		<td class="mypage_off" overClass="mypage_on" outClass="mypage_off" id="class_kwak_div_2" onClick="happy_tab_menu('class_kwak_div','2');" style="border-top:2px solid #d8d8d8; border-left:2px solid #d8d8d8; border-right:2px solid #d8d8d8">입사제의목록</td>
	</tr>
</table>
<div style="padding:10px">
	<div id="class_kwak_div_layer_1" class="dday">
		<?document_extraction_list('가로1개','세로3개','옵션1','옵션2','내가신청한구인','옵션4','최근등록일순','글자60글자짜름','누락0개','mypage_output_regadd_guin.html') ?>

		<div class="font_16 noto400" style="letter-spacing:-1px; margin-top:30px; ">
			<a href="html_file_per.php?mode=resume_job_application" style="display:block; border:1px solid #bfbfbf; padding:10px 0; text-align:center">더보기</a>
		</div>
	</div>
	<div style="display:none;" id="class_kwak_div_layer_2">
		<div style="border-top:1px solid #ddd;">
			<?guin_extraction('총20개','가로1개','제목길이200자','자동','자동','자동','자동','일반','입사요청','mypage_guin_want_list_row_per.html') ?>

		</div>		
		<div class="font_16 noto400" style="letter-spacing:-1px; margin-top:20px">
			<a href="per_guin_want.php" style="display:block; border:1px solid #bfbfbf; padding:10px 0; text-align:center">더보기</a>
		</div>
	</div>
	<br><br>
	<!-- 채용정보 스크랩-->
	<h3 class="m_tlt_m_01">
		<strong style="margin-bottom:20px; display:block;">채용정보 스크랩 <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['채용정보스크랩수']?> 건</span></strong>	
		<span class="noto400 font_10"style="position:absolute; top:25px; right:5px; letter-spacing:-1.5px" onclick="location.href='guin_scrap.php'"> 더보기</span>			
	</h3>	
	<div style="border-top:1px solid #ddd;">
		<?guin_extraction('총3개','가로1개','제목길이200자','자동','자동','자동','자동','일반','스크랩','mypage_guin_list_scrap_rows2.html') ?>

	</div>
	<br><br>
	<!-- 신입채용공고-->
	<h3 class="m_tlt_m_01">
		<strong style="margin-bottom:20px; display:block;">신입 채용공고 <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['PERMEMBER']['new_cnt_comma']?> 건</span></strong>	
		<span class="noto400 font_10"style="position:absolute; top:25px; right:5px; letter-spacing:-1.5px" onclick="location.href='html_file_per.php?mode=per_recruit_new'"> 더보기</span>			
	</h3>
	<div style="border-top:1px solid #ddd;">
		<?guin_extraction('총3개','가로1개','제목길이38자','자동','자동','자동','자동','일반','신입채용','mypage_guin_new_member_rows.html','사용안함') ?>

	</div>
	<br><br>
	<!-- 오늘 본 채용공고-->
	<h3 class="m_tlt_m_01">
		<strong style="margin-bottom:20px; display:block;">오늘 본 채용공고</strong>	
		<span class="noto400 font_10"style="position:absolute; top:25px; right:5px; letter-spacing:-1.5px" onclick="location.href='html_file_per.php?mode=today_view_recruit'"> 더보기</span>			
	</h3>
	<div style="border-top:1px solid #ddd;">
		<?guin_extraction('총4개','가로1개','제목길이70자','전체','전체','전체','전체','오늘본채용정보','전체','mypage_rows_todayview_recruit_main.html') ?>

	</div>

</div>


<!-- 기업회원꺼 복사시작 -->

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


	function bbsdel2(strURL) {
		var msg = "삭제하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

		}
	}

	function magam(strURL) {
		var msg = "해당 구인정보를 마감하시겠습니까?";
		if (confirm(msg)){
			window.location.href= strURL;

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
//-->
</script>

<div style="padding:10px">
	<div style="text-align:center; padding:10px 0">
		<?=$_data['MEM']['logo_temp']?>

	</div>
	<a href="happy_member.php?mode=modify" style="display:table; margin:0 auto; border:1px solid #bfbfbf; padding:5px 10px; border-radius:3px; text-align:center"><?=$_data['회원그룹명']?> 정보수정</a>
	<!-- 사용자 정보 -->
	<table style="width:100%; border-top:2px solid #ddd; margin-top:25px" cellspacing="0" cellpadding="0" border="0" class="tb_st_04">
		<colgroup>
			<col style="width:30%">
			<col style="width:70%">
		</colgroup>
		<tr>
			<th>대표자명</th>
			<td>
				<?=$_data['MEM']['boss_name']?>

			</td>
		</tr>
		<tr>
			<th>사원수</th>
			<td><?=$_data['MEM']['com_worker_cnt']?> 명</td>
		</tr>
		<tr>
			<th>설립연도</th>
			<td><?=$_data['MEM']['com_open_year']?> 년도</td>
		</tr>
		<tr>
			<th>업종</th>
			<td><?=$_data['MEM']['com_job']?></td>
		</tr>
		<tr>
			<th>자본금</th>
			<td><?=$_data['MEM']['extra15']?> 원</td>
		</tr>
		<tr>
			<th>매출액</th>
			<td><?=$_data['MEM']['extra17']?> 원</td>
		</tr>
		<tr>
			<th>사업내용</th>
			<td><?=$_data['MEM']['extra13']?></td>
		</tr>
		<tr>
			<th>주소</th>
			<td>(<?=$_data['MEM']['com_zip']?>) <?=$_data['MEM']['com_addr1']?> <?=$_data['MEM']['com_addr2']?></td>
		</tr>
	</table>

	<br>
	<a href="guin_regist.php" class="font_18 noto400" style="display:block; text-align:center; padding:5px 0; letter-spacing:-1px; border:1px solid #<?=$_data['배경색']['모바일_기본색상']?>; color:#fff; border-radius:5px;background:#<?=$_data['배경색']['모바일_기본색상']?>; box-sizing:border-box; ">채용공고 등록</a>
	<br>
	<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse:collapse; margin-top:10px">
		<tr>
			<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center" onclick="location.href='member_guin.php?type=all'">
				<strong class="font_22 font_tahoma" style="display:block;">
					<?=$_data['COMMEMBER']['guin_total_cnt_comma']?>

				</strong>
				<span style="padding-top:5px;">전체채용공고</span>
			</td>
			<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center"  onclick="location.href='member_guin.php'">
				<strong class="font_22 font_tahoma"  style="display:block;">
					<?=$_data['COMMEMBER']['ing_cnt_comma']?>

				</strong>
				<span style="padding-top:5px;">진행중인공고</span>
			</td>
			<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center" onclick="location.href='member_guin.php?type=magam'">
				<strong class="font_22 font_tahoma"  style="display:block;">
					<?=$_data['COMMEMBER']['magam_cnt_comma']?>

				</strong>
				<span style="padding-top:5px;">마감된채용공고</span>
			</td>
		</tr>
		<tr>
			<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center">
				<strong class="font_22 font_tahoma" style="display:block;">
					<?=$_data['COMMEMBER']['docview_count_comma']?>

				</strong>
				<span style="padding-top:5px;">이력서열람횟수</span>
			</td>
			<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center">
				<strong class="font_22 font_tahoma"  style="display:block;">
					<?=$_data['COMMEMBER']['docview_period_comma']?><span style="font-weight:normal" class="font_10 noto400">일</span>
				</strong>
				<span style="padding-top:5px;">이력서열람기간</span>
			</td>
			<td class="font_16 noto400" style="border:2px solid #cccccc; background:#f9f9f9; padding:15px 0; text-align:center">
				<strong class="font_22 font_tahoma"  style="display:block;">
					<?=$_data['COMMEMBER']['smspoint_comma']?><span style="font-weight:normal" class="font_10 noto400">회</span>
				</strong>
				<span style="padding-top:5px;">남은 문자발송</span>
			</td>
		</tr>
	</table>
	<br>
	<table style="width:100%;" cellspacing="0" cellpadding="0" border="0" class="detail_chart_02">
		<colgroup>
			<col width="25%">
			<col width="75%">
		</colgroup>
		<tr>
			<th onclick="location.href='./com_guin_want.php?mode=interview'">입사제의인재</th>
			<td style="text-align:right; padding-right:10px"  onclick="location.href='./com_guin_want.php?mode=interview'">
				<?=$_data['COMMEMBER']['req_cnt_comma']?>건
			</td>
		</tr>
		<tr>
			<th onclick="location.href='./com_guin_want.php?mode=perview'">면접제의인재</th>
			<td style="text-align:right; padding-right:10px" onclick="location.href='./com_guin_want.php?mode=perview'">
				<?=$_data['COMMEMBER']['interview_cnt_comma']?>건
			</td>

		</tr>
		<tr>
			<th onclick="location.href='./guzic_list.php?file=member_guin_scrap_normal&groupmode=com'">인재스크랩</th>
			<td style="text-align:right; padding-right:10px" onclick="location.href='./guzic_list.php?file=member_guin_scrap_normal&groupmode=com'">
				<?=$_data['COMMEMBER']['scrap_cnt1_comma']?>건
			</td>
		</tr>
		<tr>
			<th onclick="location.href='com_want_search.php?mode=list'">맞춤인재정보</th>
			<td style="text-align:right; padding-right:10px; letter-spacing:0" onclick="location.href='com_want_search.php?mode=list'">
				<span  class="ellipsis_line1"><?=$_data['맞춤인재정보수']?> 건</span>
			</td>
		</tr>
		<tr>
			<th style="display:<?=$_data['HAPPY_CONFIG']['point_charge_use']?>;" onclick="location.href='my_point_jangboo.php'">
				나의 포인트
			</th>
			<td style="display:<?=$_data['HAPPY_CONFIG']['point_charge_use']?>;text-align:right; padding-right:10px; color:#<?=$_data['배경색']['모바일_서브색상']?>; letter-spacing:0" onclick="location.href='my_point_jangboo.php'" colspan="3">
				<span  class="ellipsis_line1"><?=$_data['MEM']['point_comma']?> point</span>
			</td>
		</tr>
	</table>
<!-- 	<div class="font_16 noto400" style="letter-spacing:-1px; margin-top:15px">
		<a href="./my_jangboo_com.php" style="display:block; border:1px solid #bfbfbf; padding:10px 0; text-align:center">유료결제내역</a>
	</div> -->
	<!-- 채용공고 리스트 -->
	<?include_template('happy_member_mypage_com_mobile_head.html') ?>

	<!-- 스크랩한 이력서-->
	<div style="margin-top:30px;">
		<h3 class="m_tlt_m_01" style="position:relative;">
			<strong style="margin-bottom:20px; display:block;">인재정보 스크랩 <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['COMMEMBER']['scrap_cnt1_comma']?> 건</span></strong>			
			<span class="noto400 font_10"style="position:absolute; top:25px; right:5px; letter-spacing:-1.5px" onclick="location.href='guzic_list.php?file=member_guin_scrap'">
				더보기
			</span>
		</h3>
		<div>
			<?document_extraction_list('가로1개','세로3개','자동','자동','인재스크랩','옵션4','최근등록일순','글자짜름','누락0개','mypage_guin_scrap_list_rows.html','페이징사용안함') ?>

		</div>
	</div>
	<div style="margin-top:30px;">
		<!-- 오늘 본 이력서-->
		<h3 class="m_tlt_m_01" style="position:relative;">
			<strong style="margin-bottom:20px; display:block;">오늘본 인재정보 <span style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['오늘본이력서수']?> 건</span></strong>			
			<span class="noto400 font_10"style="position:absolute; top:25px; right:5px; letter-spacing:-1.5px" onclick="location.href='guzic_list.php?file=member_guin_scrap'">
				더보기
			</span>
		</h3>
		<div style="border-top:1px solid #ddd;">
			<?document_extraction_list('가로1개','세로3개','자동','자동','자동','오늘본구직정보','랜덤추출','글자짜름','누락0개','mypage_guin_scrap_list_rows.html','페이징사용안함') ?>

		</div>
	</div>	

</div>


<div class="new_button_area">
<a href="/bbs_list.php?tb=board_qna">1:1 문의</a>
</div>

<? }
?>