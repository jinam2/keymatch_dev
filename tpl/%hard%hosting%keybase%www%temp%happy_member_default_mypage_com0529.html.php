<? /* Created by SkyTemplate v1.1.0 on 2023/03/17 08:52:04 */
function SkyTpl_Func_1223349530 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?=$_data['site_name']?> <?=$_data['master_msg']?></title>

<?=$_data['webfont_js']?>


<!-- 파비콘 지정-->
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" href="css/style.css" type="text/css">
<script src="js/happy_job.js" type="text/javascript"></script>
<script src="js/flash.js" type="text/javascript"></script>
<SCRIPT language='JavaScript' src='js/glm-ajax.js'></SCRIPT>
<script language="javascript" type="text/javascript" src="js/happy_function.js"></script>

<!--구글통계-->
<?=$_data['google_login_track']?>


<style type="text/css">
	table.regist_frm input{height:18px;}
</style>

</head>

<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" style="text-align:center;">
<div id="dhtmltooltip"></div>
<script type="text/javascript" src="happy_main.js"></script>

<!-- 핸드폰 인증을 위한 DIV START-->
<SCRIPT language='JavaScript' src='js/glm-ajax.js'></SCRIPT>
<?=$_data['핸드폰인증레이어']?>

<!-- 핸드폰 인증을 위한 DIV END -->


<table cellpadding="0" cellspacing="0" width="950">
    <tr>
		<td width="20" height="32" background="img/top_table_A01.gif"></td>
		<td background="img/top_table_A02.gif" style="padding-bottom:7;">

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td><img src="img/top_title_01.gif" border="0" align="absmiddle" onClick="this.style.behavior='url(#default#homepage)';this.setHomePage(parent.location.href)" style="cursor:point;cursor:hand">&nbsp;&nbsp;&nbsp;<img src="img/top_title_02.gif" border="0" align="absmiddle" <?echo add_bookmark_link('클릭') ?> style="cursor:point;cursor:hand"></td>
					<td align="right">

						<table cellpadding="0" cellspacing="0">
							<tr>
								<td>

									<div style="position:relative; left:0; top:0; z-index:2;">
									<div style="position:absolute;width:0; left:-120px; top:-14px; z-index:2;"><script type="text/javascript">printSWF("google_weather", "flash_swf/s_weather_api.swf", "120", "120", "Transparent", "#FFFFFF");</script></div>
									</div>

								</td>
								<td>

									<table cellpadding="0" cellspacing="0">
										<tr>
											<td><img align="absmiddle" src="img/skin_icon/make_icon/skin_icon_462.jpg" border="0"></td>
											<td background="img/skin_icon/make_icon/skin_icon_463.jpg"><img src="img/skin_icon/make_icon/skin_icon_461.jpg" border="0" align="abmiddle"></td>
											<td background="img/skin_icon/make_icon/skin_icon_463.jpg" style="padding-top:1;padding-left:10;" width="280">
											<?ticker_tag_maker('총5개','가로1개','가로270','세로15','제목길이30자','전체','전체','전체','전체','뉴스티커','전체','rows_text_ticker.html','랜덤추출') ?>

											</td>
											<td><img align="absmiddle" src="img/skin_icon/make_icon/skin_icon_464.jpg" border="0"></td>
										</tr>
									</table>

								</td>
								<td style="padding-left:5;">

									<table cellpadding="0" cellspacing="0">
										<tr>
											<td><img align="absmiddle" src="img/skin_icon/make_icon/skin_icon_462.jpg" border="0"></td>
											<td background="img/skin_icon/make_icon/skin_icon_463.jpg"><?happy_member_login_form('happy_member_logon_button.html','happy_member_logout_button.html') ?></td>
											<td><img align="absmiddle" src="img/skin_icon/make_icon/skin_icon_464.jpg" border="0"></td>
										</tr>
									</table>

								</td>
								<td width="50" style="padding-left:5;"><a href="bbs_list.php?tb=board_qna"><img align="absmiddle" src="img/skin_icon/make_icon/skin_icon_456.jpg" border="0"></a></td>
							</tr>
						</table>

					</td>
				</tr>
			</table>

		</td>
		<td width="20" height="32" background="img/top_table_A03.gif"></td>
	</tr>
</table>

<div style="padding:5;"></div>
<table cellpadding="0" cellspacing="0" width="950" align="center">
	<tr>
		<td style="padding-left:5;"><a href="./"><img align="absmiddle" src="img/skin_icon/make_icon/skin_icon_5.jpg" border="0"></a><img align="absmiddle" src="img/newlogo_2.gif" border="0"></td>
		<td width="155" align="right" style="padding-right:10;"><?echo happy_banner('righttop','그룹명','랜덤') ?></td>
	</tr>
</table>
<div style="padding:5;"></div>

<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
		<td background="img/skin_icon/make_icon/skin_icon_242.jpg" height="127" align="center">

			<table cellpadding="0" cellspacing="0" width="950">
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_242.jpg" width="180" height="127" align="center" valign="top" style="padding-top:10;">

						<div><a href='#' style='text-decoration:none' onClick="window.open('happy_message.php?mode=send&receiveid=<?=$_data['admin_id']?>&receiveAdmin=y&adminMode=n','happy_message','width=700,height=400,toolbar=no,scrollbars=no')"><img src="img/skin_icon/make_icon/skin_icon_256.jpg" border="0" align="absmiddle"></a></div>

						<table cellpadding="0" cellspacing="0" style="padding-top:10;">
							<tr>
								<td><a href="html_file.php?file=guin_arealist.html"><img src="img/skin_icon/make_icon/skin_icon_257.jpg" border="0" align="absmiddle"></a></td>
								<td style="padding-left:5;"><a href="html_file.php?file=guin_underground.html&underground1=1"><img src="img/skin_icon/make_icon/skin_icon_258.jpg" border="0" align="absmiddle"></a></td>
							</tr>
						</table>

					</td>
					<td background="img/skin_icon/make_icon/skin_icon_243.jpg" width="24" height="127" align="center"></td>
					<td background="img/skin_icon/make_icon/skin_icon_244.jpg" height="127" align="center" valign="top" style="padding-top:20;">

						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="87" height="33" background="img/skin_icon/make_icon/skin_icon_251.jpg"></td>
								<td background="img/skin_icon/make_icon/skin_icon_247.jpg" align="center" class="smfont" style="padding-bottom:2;"><?=$_data['추천키워드']?></td>
								<td width="17" height="33" background="img/skin_icon/make_icon/skin_icon_248.jpg"></td>
							</tr>
						</table>

						<div style="height:48;">

							<table cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="center" style="padding-top:4;"><script>FlashMainbody("flash_swf/xml_menu_main.swf","500","36",'Transparent');</script></td>
								</tr>
							</table>

						</div>

						<div style="width:90%;"><?=$_data['검색부분']?></div>

					</td>
					<td background="img/skin_icon/make_icon/skin_icon_245.jpg" width="24" height="127" align="center"></td>
					<td background="img/skin_icon/make_icon/skin_icon_242.jpg" width="180" height="127" align="center">

						<div style="padding-top:5;"><a href="guin_regist.php"><img src="img/skin_icon/make_icon/skin_icon_252.jpg" border="0" align="absmiddle"></a></div>

						<div style="padding-top:5;"><a href="document.php?mode=add"><img src="img/skin_icon/make_icon/skin_icon_253.jpg" border="0" align="absmiddle"></a></div>


					</td>
				</tr>
			</table>

		</td>
	</tr>
</table>

<div style="padding-top:5;"></div>

<table width="950" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="180" align="center" valign="top" style="padding-right:5;padding-top:10;">

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_277.jpg"><a href="happy_member.php?mode=mypage"><img src="img/skin_icon/make_icon/skin_icon_294.jpg" border="0" align="absmiddle"></a></td>
					<td width="55"><img src="img/skin_icon/make_icon/skin_icon_278.jpg" border="0" align="absmiddle"></td>
				</tr>
			</table>

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td bgcolor="<?=$_data['배경색']['기본색상']?>" width="2"></td>
					<td>

						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="member_guin.php"><b>진행중인 채용정보</b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="member_guin.php?type=magam"><b>마감된 채용정보</b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="com_guin_want.php"><b>입사제의 목록</b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=com_payendper.html&file2=default_com.html"><b>열람가능 인재정보</b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="my_jangboo_com.php"><b>유료결제 내역</b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr style="display:<?=$_data['HAPPY_CONFIG']['point_jangboo_use']?>;">
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="my_point_jangboo.php"><b>포인트결제 내역</b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="guin_regist.php"><b><font color="<?=$_data['배경색']['기본색상']?>">채용정보 등록</font></b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
						</table>

						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td height="30" bgcolor="<?=$_data['배경색']['기본색상']?>" style="padding-left:10;"><img src="img/skin_icon/make_icon/skin_icon_494.jpg" border="0" align="absmiddle"></td>
							</tr>
						</table>

						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<!--마춤채용정보추가됨-->
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="com_want_search.php?mode=list&file=guzic_want_search.html&file2=default_com.html"><b><font color="<?=$_data['배경색']['기본색상']?>">맞춤인재정보</font></b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="com_want_search.php?mode=setting_form"><b><font color="<?=$_data['배경색']['기본색상']?>">맞춤인재정보설정</font></b></a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<!--마춤채용정보추가됨-->
						</table>

						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td height="30" bgcolor="<?=$_data['배경색']['기본색상']?>" style="padding-left:10;"><img src="img/skin_icon/make_icon/skin_icon_293.jpg" border="0" align="absmiddle"></td>
							</tr>
						</table>

						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guin_tasklist.html">업직종별</a> <img src="img/icon_new.gif" border="0" align="absmiddle"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guin_arealist.html">지역별</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guin_underground.html&underground1=1">역세권별</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guin_woodae.html">우대등록</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guin_premium.html">프리미엄</a> <img src="img/icon_new.gif" border="0" align="absmiddle"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guin_speed.html">급구채용</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guin_pick.html">추천채용</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guin_special.html">스페셜채용</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="bbs_list.php?tb=board_albaguin">아르바이트 채용</a> <img src="img/icon_new.gif" border="0" align="absmiddle"></td>
							</tr>
						</table>


						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td height="30" bgcolor="<?=$_data['배경색']['기본색상']?>" style="padding-left:10;"><img src="img/skin_icon/make_icon/skin_icon_284.jpg" border="0" align="absmiddle"></td>
							</tr>
						</table>


						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guzic_tasklist.html">업직종별</a> <img src="img/icon_new.gif" border="0" align="absmiddle"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guzic_arealist.html">지역별</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guzic_power.html">파워링크</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guzic_focus.html">포커스</a> <img src="img/icon_new.gif" border="0" align="absmiddle"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="html_file.php?file=guzic_special.html">스페셜</a></td>
							</tr>
							<tr>
								<td colspan="2" height="1" bgcolor="#dddddd"></td>
							</tr>
							<tr>
								<td width="15" style="padding-left:5;" height="30" align="center"><img src="img/icon_menudot.gif" border="0" align="absmiddle"></td>
								<td><a href="bbs_list.php?tb=board_albaguzic">아르바이트 구직</a> <img src="img/icon_new.gif" border="0" align="absmiddle"></td>
							</tr>

						</table>


					</td>
					<td bgcolor="<?=$_data['배경색']['기본색상']?>" width="2"></td>
				</tr>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_282.jpg" width="5" height="5"></td>
					<td background="img/skin_icon/make_icon/skin_icon_281.jpg"><img src="img/binimg.gif" border="0" width="1" height="1"></td>
					<td background="img/skin_icon/make_icon/skin_icon_280.jpg" width="5" height="5"></td>
				</tr>
			</table>

			<div style="padding-top:5;"></div>

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="24" height="32" background="img/skin_icon/make_icon/skin_icon_296.jpg"></td>
					<td height="32" background="img/table_sirobox_1.gif"><img src="img/tit_inbank.gif" border="0" align="absmiddle"></td>
					<td width="5"><img src="img/table_sirobox_2.gif" border="0" align="absmiddle"></td>
				</tr>
			</table>

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td background="img/table_sirobox_7.gif"></td>
					<td style="padding-top:7;" align="center"><img src="img/table_siteinbank.gif" border="0" align="absmiddle"></td>
					<td background="img/table_sirobox_3.gif"></td>
				</tr>
				<tr>
					<td width="5" height="5" background="img/table_sirobox_6.gif"></td>
					<td background="img/table_sirobox_5.gif"></td>
					<td width="5" height="5" background="img/table_sirobox_4.gif"></td>
				</tr>
			</table>

			<div style="padding:5;"></div>

			<div style="padding-bottom:10;"><?=$_data['goole_adsense6']?></div>
			<div style="padding-bottom:10;"><?echo happy_banner('subleft2','그룹명','랜덤') ?></div>

		</td>
		<td valign="top" style="padding-left:5;padding-top:10;">


			<?=$_data['내용']?>


		</td>
	</tr>
</table>

<table width="950" height="43" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td background="img/skin_icon/make_icon/skin_icon_263.jpg" width="17"></td>
		<td background="img/skin_icon/make_icon/skin_icon_265.jpg" align="center" style="padding-bottom:5;">

			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center"><a href="html_file.php?file=site_compnay.html&file2=default_rule.html"><img src="img/copy_tit_01.gif" border="0" align="absmiddle"></a></td>
					<td><img src="img/tong_gubun_line.gif"></td>
					<td align="center"><a href="javascript:open_window('bannerreg', './bbs_regist.php?id=&b_category=&tb=board_bannerreg', 0, 0, 700, 650, 0, 0, 0, 1, 0)"><img src="img/copy_tit_02.gif" border="0" align="absmiddle"></a></td>
					<td><img src="img/tong_gubun_line.gif"></td>
					<td width="150" align="center"><a href="html_file.php?file=site_rule.html&file2=default_rule.html"><img src="img/copy_tit_03.gif" border="0" align="absmiddle"></a></td>
					<td><img src="img/tong_gubun_line.gif"></td>
					<td align="center"><a href="html_file.php?file=site_rule2.html&file2=default_rule.html"><img src="img/copy_tit_04.gif" border="0" align="absmiddle"></a></td>
					<td><img src="img/tong_gubun_line.gif"></td>
					<td align="center"><a href="bbs_list.php?tb=board_notice"><img src="img/copy_tit_05.gif" border="0" align="absmiddle"></a></td>
					<td><img src="img/tong_gubun_line.gif"></td>
					<td align="center"><a href="html_file.php?file=bbs_index.html&file2=bbs_default.html"><img src="/img/copy_tit_06.gif" border="0" align="absmiddle"></a></td>
					<td><img src="img/tong_gubun_line.gif"></td>
					<td width="150" align="center"><a href="bbs_list.php?tb=board_qna"><img src="img/copy_tit_07.gif" border="0" align="absmiddle"></a></td>
				</tr>
			</table>

		</td>
		<td background="img/skin_icon/make_icon/skin_icon_264.jpg" width="17"></td>
	</tr>
</table>

<div style="padding-top:10;"><img src="img/copyright.gif" border="0" align="absmiddle"></div>

<div class="smfont" style="padding-bottom:10;"><font color="#999999">Copyright ⓒ <?=$_data['now_year']?> <?=$_data['site_name']?> All rights reserved.</font></div>

<?=$_data['cgialert']?>


<!--쪽지 기능 추가-->


<?=$_data['쪽지레이어']?>

<!--쪽지 기능 추가-->
<? }
?>