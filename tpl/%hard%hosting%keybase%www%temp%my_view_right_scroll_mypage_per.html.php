<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 13:18:28 */
function SkyTpl_Func_336942742 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>
  $( document ).ready( function() {
	var jbOffset = $( '.scroll_menu' ).offset();

	$( window ).scroll( function() {
	  if ( $( document ).scrollTop() > jbOffset.top - 100) {
		$( '.scroll_menu' ).addClass( 'Fixed' );
	  }
	  else {
		$( '.scroll_menu' ).removeClass( 'Fixed' );
	  }
	});
  } );
</script>

<script language="JavaScript">
function top_click() {
	window.scrollTop(0,0)
}
</script>

<style>
/* 우측스크롤 - 필수style */
.Fixed {position: fixed !important; top:120px !important;}
.quick_st{width:0; left:50%; position:absolute;  z-index:999;}
.scroll_menu{top:260px}
@media all and (max-width:1477px){
	.scroll_menu{display:none;}
}
</style>
<style>
	.menu_on, .menu_off{cursor:pointer}
	.menu_off{}
</style>

<div id="quick" class="quick_st scroll_menu">
	<div style="text-align:center; right:0px; margin-left:620px; left:50%; position:relative;">
		<table cellspacing="0" cellpadding="0" >
			<tr>
				<td style="font-size:0">
					<a href="happy_member.php?mode=mypage" title="mypage">
						<img src="img/mypage_menu_tit.gif" alt="mypage">
					</a>
				</td>
			</tr>
			<tr>
				<td style="cursor:pointer; font-size:0" onmouseover="change_main_top3('1');" onmouseout="sub_menu_out3()">
					<a href="html_file_per.php?file=member_regph.html" title="이력서관리">
						<img src="img/mypage_menu_05.gif" alt="이력서관리">
					</a>
				</td>
			</tr>
			<tr>
				<td style="cursor:pointer; font-size:0" onmouseover="change_main_top3('2');" onmouseout="sub_menu_out3()">
					<a href="html_file_per.php?mode=resume_job_application" title="입사지원관리">
						<img src="img/mypage_menu_06.gif" alt="입사지원관리">
					</a>
				</td>
			</tr>
			<tr>
				<td style="cursor:pointer; font-size:0" onmouseover="change_main_top3('3');" onmouseout="sub_menu_out3()">
					<a href="my_jangboo_per.php" title="유료서비스">
						<img src="img/mypage_menu_03.gif" alt="유료서비스">
					</a>
				</td>
			</tr>
			<tr>
				<td style="cursor:pointer; font-size:0" onmouseover="change_main_top3('4');" onmouseout="sub_menu_out3()">
					<a href="happy_member.php?mode=modify" title="회원정보관리">
						<img src="img/mypage_menu_07.gif" alt="회원정보관리">
					</a>
				</td>
			</tr>
		</table>
		<div  id="top_layerc1" class="mymene_layer" style="top:-377px; display:none" onmouseover="sub_menu_over3()" onmouseout="sub_menu_out3()">
			<span class="arrow">
				<img src="img/mymenu_arrow.png">
			</span>
			<table cellpadding="0"cellspacing="0" style="width:100%">
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="document.php?mode=add" style="color:#<?=$_data['배경색']['기타페이지2']?>;">이력서등록</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="html_file_per.php?file=member_regph.html">내 이력서 관리</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="html_file_per.php?file=member_regph_ing.html">공개 이력서</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="html_file_per.php?file=member_regph_stop.html">비공개 이력서</a>
					</td>
				</tr>
			</table>
		</div>
		<div  id="top_layerc2" class="mymene_layer" style="display:none; top:-283px" onmouseover="sub_menu_over3()" onmouseout="sub_menu_out3()">
			<span class="arrow">
				<img src="img/mymenu_arrow.png">
			</span>
			<table cellpadding="0"cellspacing="0" style="width:100%">
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="html_file_per.php?file=my_guin_add.html">온라인 입사지원</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="html_file_per.php?mode=resume_job_application_email">이메일 입사지원</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="per_guin_want.php">입사제의받은 채용공고</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="per_guin_want.php?mode=preview">면접제의받은 채용공고</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="per_want_search.php?mode=setting_form" style="vertical-align:middle; color:#<?=$_data['배경색']['서브색상']?>;">
							맞춤채용공고 설정하기
						</a>
						<img src="img/skin_icon/make_icon/skin_icon_689.jpg" style="vertical-align:middle">
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="per_want_search.php?mode=list">맞춤채용공고</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="html_file_per.php?mode=per_guin_view">채용공고 열람관리</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="per_no_view_list.php">이력서 열람불가 설정</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="html_file_per.php?file=my_guin_activities.html">취업활동 증명서</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="guin_scrap.php">스크랩한 채용공고</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="html_file_per.php?mode=today_view_recruit">오늘 본 채용공고</a>
					</td>
				</tr>
			</table>
		</div>
		<div  id="top_layerc3" class="mymene_layer" style="display:none; top:-184px" onmouseover="sub_menu_over3()" onmouseout="sub_menu_out3()">
			<span class="arrow">
				<img src="img/mymenu_arrow.png">
			</span>
			<table cellpadding="0"cellspacing="0" style="width:100%">
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="my_jangboo_per.php">유료결제내역</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="member_option_pay3.php">열람/SMS서비스</a>
					</td>
				</tr>
				<tr style="display:<?=$_data['HAPPY_CONFIG']['point_charge_jangboo_use']?>;">
					<td class="font_16 noto400" style="letter-spacing:-1px; display:<?=$_data['HAPPY_CONFIG']['point_jangboo_use']?>;">
						<a href="my_point_jangboo.php">포인트결제내역</a>
					</td>
				</tr>
				<tr style="display:<?=$_data['HAPPY_CONFIG']['point_charge_use']?>;">
					<td class="font_16 noto400" style="letter-spacing:-1px; display:<?=$_data['HAPPY_CONFIG']['point_charge_use']?>;">
						<a href="#point_charge" onclick="window.open('my_point_charge.php','charge_win','width=540,height=360,scrollbars=no')" onfocus='this.blur();' style="color:#333">포인트충전</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="member_option_pay_package.php?pay_type=person" style=" color:#<?=$_data['배경색']['기타페이지']?>">패키지옵션결제</a>
						<img src="img/skin_icon/make_icon/skin_icon_689.jpg" alt="" style="vertical-align:middle">
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="my_package_list.php?pay_type=person">패키지옵션 보유현황</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="my_package_list.php?mode=list&pay_type=person">패키지 결제사용내역</a>
					</td>
				</tr>
			</table>
		</div>
		<div  id="top_layerc4" class="mymene_layer" style="display:none; top:-92px" onmouseover="sub_menu_over3()" onmouseout="sub_menu_out3()">
			<span class="arrow">
				<img src="img/mymenu_arrow.png">
			</span>
			<table cellpadding="0"cellspacing="0" style="width:100%">
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="happy_member.php?mode=modify"><?=$_data['회원그룹명']?> 정보수정</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="javascript:open_window('com_log', './logo_change.php?com_info_id=<?=$_data['MEM']['id']?>', 0, 0, 480, 400, 0, 0, 0, 0, 0)"><?=$_data['회원그룹명']?> 사진수정</a>
					</td>
				</tr>
				<tr style="display:<?=$_data['HAPPY_CONFIG']['point_charge_jangboo_use']?>;">
					<td class="font_16 noto400" style="letter-spacing:-1px; display:<?=$_data['HAPPY_CONFIG']['point_jangboo_use']?>;">
						<a href='#' onclick="javascript:window.open('recommend_link.php','recommend_link','width=500, height=350,scrollbars=no,titlebar=no,status=no,resizable=no,fullscreen=no');">추천인링크발급</a>
					</td>
				</tr>
				<tr>
					<td class="font_16 noto400" style="letter-spacing:-1px">
						<a href="happy_inquiry_list.php?mode=normal">내가 문의한 내역</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<? }
?>