<? /* Created by SkyTemplate v1.1.0 on 2023/03/17 08:52:04 */
function SkyTpl_Func_1474740761 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="6" height="6"><img src="img/skin_icon/make_icon/skin_icon_21.jpg" border="0" align="absmiddle"></td>
		<td background="img/skin_icon/make_icon/skin_icon_22.jpg"><img src="img/binimg.gif" border="0" width="1" height="1" align="absmiddle"></td>
		<td width="6" height="6"><img src="img/skin_icon/make_icon/skin_icon_23.jpg" border="0" align="absmiddle"></td>
	</tr>
	<tr>
		<td background="img/skin_icon/make_icon/skin_icon_28.jpg"></td>
		<td style="padding:4;" class="now_location"><?=$_data['현재위치']?></td>
		<td background="img/skin_icon/make_icon/skin_icon_24.jpg"></td>
	</tr>
	<tr>
		<td width="6" height="6"><img src="img/skin_icon/make_icon/skin_icon_27.jpg" border="0" align="absmiddle"></td>
		<td background="img/skin_icon/make_icon/skin_icon_26.jpg"><img src="img/binimg.gif" border="0" width="1" height="1" align="absmiddle"></td>
		<td width="6" height="6"><img src="img/skin_icon/make_icon/skin_icon_25.jpg" border="0" align="absmiddle"></td>
	</tr>
</table>
<div style="padding-top:10px;"></div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td><img src="img/my_com_banner.jpg" border="0">
</td>
</tr>
</table>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
    <tr>
		<td background="img/skin_icon/make_icon/skin_icon_491.jpg" width="6" height="369"></td>
		<td background="img/skin_icon/make_icon/skin_icon_492.jpg" width="270" height="369" align="center" valign="top" style="padding-top:20;">

			<table cellpadding="0" cellspacing="0">
				<tr>
					<td >
					<table cellpadding="0" cellspacing="2" background="img/skin_icon/make_icon/skin_icon_485.jpg">
						<tr>
							<td style="padding:5;" bgcolor="#FFFFFF"><?=$_data['MEM']['logo_temp']?></td>
						</tr>
					</table>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td height="6" background="img/bg_table_grad.gif"><img src="img/binimg.gif" width="1" height="1"></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td style="padding-top:5;padding-right:5;padding-bottom:5;" align="center"><font color="<?=$_data['배경색']['기본색상']?>">[SIZE : 240 X 150 pixel]</font></td>
				</tr>
				<tr>
					<td >

						<table cellpadding="0" cellspacing="0">
							<tr>
								<td style="padding-right:5;">
								<table cellpadding="0" cellspacing="2" background="img/skin_icon/make_icon/skin_icon_485.jpg">
									<tr>
										<td style="padding:5;" bgcolor="#FFFFFF"><?=$_data['MEM']['banner']?></td>
									</tr>
								</table>

								</td>
							</tr>
						</table>

					</td>
				</tr>
				<tr>
					<td style="padding-top:5;" ><font color="<?=$_data['배경색']['기본색상']?>">[SIZE : 85 X 45 pixel]</font></td>
				</tr>
				<tr>
					<td style="padding-top:10;padding-right:5;" align="center"><a href="javascript:open_window('com_log', './logo_change.php?per_info_id=<?=$_data['MEM']['id']?>', 0, 0, 400, 500, 0, 0, 0, 0, 0)"><img src="img/btn_mypage_myphotomod.gif" align="absmiddle" border="0"></a></td>
				</tr>
			</table>

		</td>
		<td background="img/skin_icon/make_icon/skin_icon_493.jpg" width="6" height="369"></td>
		<td background="img/skin_icon/make_icon/skin_icon_468.jpg" valign="top" style="padding-top:10;padding-left:5;">

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>

						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td height="30">

									<script type="text/javascript">
										var aaa = encodeURI('<?=$_data['MEM']['com_name']?> 회원님 등록정보');
										printSWF("titles", "/flash_swf/mypage_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>&color2=666666", "350", "18", "opaque", "#FFFFFF");
									</script>

								</td>
							</tr>
							<tr>
								<td height="2" background="img/skin_icon/make_icon/skin_icon_485.jpg"></td>
							</tr>
							<tr>
								<td height="30">

									<table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td width="75" height="30" style="padding-left:15;"><b><font color="<?=$_data['배경색']['기본색상']?>">업종</font></b></td>
											<td width="150" style="padding-top:5;padding-bottom:5;padding-right:5;" class="smfont"><?=$_data['MEM']['com_job']?></td>
											<td width="75" height="30" style="padding-left:15;"><b><font color="<?=$_data['배경색']['기본색상']?>">대표자</font></b></td>
											<td style="padding-top:5;padding-bottom:5;padding-right:5;" class="smfont"><?=$_data['MEM']['boss_name']?></td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="img/skin_icon/make_icon/skin_icon_485.jpg"></td>
										</tr>
										<tr>
											<td width="75" height="30" style="padding-left:15;"><b><font color="<?=$_data['배경색']['기본색상']?>">설립연도</font></b></td>
											<td style="padding-top:5;padding-bottom:5;padding-right:5;" class="smfont"><?=$_data['MEM']['com_open_year']?> 년도</td>
											<td width="75" height="30" style="padding-left:15;"><b><font color="<?=$_data['배경색']['기본색상']?>">직원수</font></b></td>
											<td style="padding-top:5;padding-bottom:5;padding-right:5;" class="smfont"><?=$_data['MEM']['com_worker_cnt']?> 명</td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="img/skin_icon/make_icon/skin_icon_485.jpg"></td>
										</tr>
										<tr>
											<td width="75" height="30" style="padding-left:15;"><b><font color="<?=$_data['배경색']['기본색상']?>">업소주소</font></b></td>
											<td style="padding-top:5;padding-bottom:5;padding-right:5;" colspan="3" class="smfont">(<?=$_data['MEM']['com_zip']?>) <?=$_data['MEM']['com_addr1']?> <?=$_data['MEM']['com_addr2']?></td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="img/skin_icon/make_icon/skin_icon_485.jpg"></td>
										</tr>
										<tr>
											<td colspan="4" align="right" style="padding-top:5;padding-bottom:5;padding-right:5;">




												<a href="member_option_pay2.php"><img src="img/btn_mypage_optionpay.gif" border="0" align="absmiddle"></a> <a href="happy_member.php?mode=modify"><img src='img/btn_mypage_memmod.gif' border="0" align="absmiddle">
												</a>

											</td>
										</tr>
									</table>

								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td height="30">

						<script type="text/javascript">
							var aaa = encodeURI('<?=$_data['MEM']['com_name']?> 회원님의 채용활동');
							printSWF("titles", "/flash_swf/mypage_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>&color2=666666", "270", "18", "opaque", "#FFFFFF");
						</script>

					</td>
				</tr>
				<tr>
					<td>

						<table cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
							<tr>
								<td bgcolor="#FFFFFF">

									<table cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
										<tr>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">채용정보<br>등록수</td>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">진행중인<br>채용정보</td>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">마감된<br>채용정보</td>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">입사요망<br>신청수</td>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">입사제의<br>요청수</td>
										</tr>
										<tr>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="member_guin.php?type=all"><u><?=$_data['COMMEMBER']['guin_total_cnt_comma']?>개</u></a></b></td>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="member_guin.php"><u><?=$_data['COMMEMBER']['ing_cnt_comma']?>개</u></a></b></td>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="member_guin.php?type=magam"><u><?=$_data['COMMEMBER']['magam_cnt_comma']?>개</u></a></b></td>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="member_guin.php"><u><?=$_data['COMMEMBER']['jiwon_cnt_comma']?>건</u></a></b></td>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="com_guin_want.php"><u><?=$_data['COMMEMBER']['req_cnt_comma']?>건</u></a></b></td>
										</tr>
										<tr>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">스크랩한<br>이력서</td>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">이력서뷰<br>유효일</td>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">이력서뷰<br>가능수</td>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">문자발송<br>포인트</td>
											<td align="center" width="20%" height="40" bgcolor="#f9f9f9" class="smfont">마일리지<br>포인트</td>
										</tr>
										<tr>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="guzic_list.php?file=member_guin_scrap"><u><?=$_data['COMMEMBER']['scrap_cnt_comma']?>개</u></a></b></td>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="member_option_pay2.php"><u><?=$_data['COMMEMBER']['docview_period_comma']?>일</u></a></b></td>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="member_option_pay2.php"><u><?=$_data['COMMEMBER']['docview_count_comma']?>회</u></a></b></td>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a href="member_option_pay2.php"><u><?=$_data['COMMEMBER']['smspoint_comma']?>P</u></a></b></td>
											<td align="center" width="20%" height="35" bgcolor="#FFFFFF"><b><a id="div_pay_more" href="my_point_jangboo.php"><u><?=$_data['MEM']['point_comma']?>P</u></a></b></td>
										</tr>
									</table>

								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>


		</td>
		<td background="img/skin_icon/make_icon/skin_icon_469.jpg" width="8" height="369"></td>
	</tr>
</table>
<div style="padding-top:5;"></div>

<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="50%" style="padding-right:5;" valign="top">
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td height="30">

						<script type="text/javascript">
							var aaa = encodeURI('<?=$_data['MEM']['com_name']?> 회원님의 업소소개');
							printSWF("titles", "/flash_swf/mypage_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>&color2=666666", "200", "18", "opaque", "#FFFFFF");
						</script>

					</td>
				</tr>
			</table>

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_470.jpg" width="6" height="6"></td>
					<td background="img/skin_icon/make_icon/skin_icon_471.jpg"></td>
					<td background="img/skin_icon/make_icon/skin_icon_472.jpg" width="6" height="6"></td>
				</tr>
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_477.jpg" width="6" height="6"></td>
					<td height="200"><?=$_data['MEM']['com_profile1']?></td>
					<td background="img/skin_icon/make_icon/skin_icon_473.jpg" width="6" height="6"></td>
				</tr>
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_476.jpg" width="6" height="6"></td>
					<td background="img/skin_icon/make_icon/skin_icon_475.jpg"></td>
					<td background="img/skin_icon/make_icon/skin_icon_474.jpg" width="6" height="6"></td>
				</tr>
			</table>
		</td>
		<td style="padding-left:5;" valign="top">
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td height="30">

						<script type="text/javascript">
							var aaa = encodeURI('<?=$_data['MEM']['com_name']?> 회원님의 업소위치');
							printSWF("titles", "/flash_swf/mypage_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>&color2=666666", "200", "18", "opaque", "#FFFFFF");
						</script>

					</td>
				</tr>
			</table>

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_470.jpg" width="6" height="6"></td>
					<td background="img/skin_icon/make_icon/skin_icon_471.jpg"></td>
					<td background="img/skin_icon/make_icon/skin_icon_472.jpg" width="6" height="6"></td>
				</tr>
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_477.jpg" width="6" height="6"></td>
					<td align="center" style="height:200px;"><?happy_map_call('자동','자동','363','200','','img/map_here.gif','지도버튼/줌버튼') ?></td>
					<td background="img/skin_icon/make_icon/skin_icon_473.jpg" width="6" height="6"></td>
				</tr>
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_476.jpg" width="6" height="6"></td>
					<td background="img/skin_icon/make_icon/skin_icon_475.jpg"></td>
					<td background="img/skin_icon/make_icon/skin_icon_474.jpg" width="6" height="6"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div style="padding-top:10;"></div>

<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_479.jpg" width="13" height="34"></td>
					<td background="img/skin_icon/make_icon/skin_icon_480.jpg">

						<table cellpadding="0" cellspacing="0">
							<tr>
								<td height="34" align="center">

									<table cellpadding="0" cellspacing="0" style="cursor:hand;">
										<tr id="div_guin_1">
											<td width="6" height="34" background="img/skin_icon/make_icon/skin_icon_482.jpg"></td>
											<td height="34" background="img/skin_icon/make_icon/skin_icon_483.jpg" style="padding-left:10;padding-right:10;padding-top:5;" onclick="ChangeTab1('1');"><b>진행중인 채용정보</b></td>
											<td width="6" height="34" background="img/skin_icon/make_icon/skin_icon_484.jpg"></td>
										</tr>
										<tr id="div_guin_2" style="display:none;">
											<td width="6" height="34"></td>
											<td height="34" style="padding-left:10;padding-right:10;"><b><font color="#FFFFFF" onclick="ChangeTab1('1');">진행중인 채용정보</font></b></td>
											<td width="6" height="34"></td>
										</tr>
									</table>

								</td>
								<td height="34" align="center">

									<table cellpadding="0" cellspacing="0" style="cursor:hand;">
										<tr id="div_guin_3" style="display:none;">
											<td width="6" height="34" background="img/skin_icon/make_icon/skin_icon_482.jpg"></td>
											<td height="34" background="img/skin_icon/make_icon/skin_icon_483.jpg" style="padding-left:10;padding-right:10;padding-top:5;" onclick="ChangeTab1('2');"><b>마감된 채용정보</b></td>
											<td width="6" height="34" background="img/skin_icon/make_icon/skin_icon_484.jpg"></td>
										</tr>
										<tr id="div_guin_4">
											<td width="6" height="34"></td>
											<td height="34" style="padding-left:10;padding-right:10;" onclick="ChangeTab1('2');"><b><font color="#FFFFFF" >마감된 채용정보</font></b></td>
											<td width="6" height="34"></td>
										</tr>
									</table>

								</td>
							</tr>
						</table>

					</td>
					<td background="img/skin_icon/make_icon/skin_icon_480.jpg" align="right" style="padding-right:5;"><a id="div_guin_more" href="member_guin.php"><font color="#FFFFFF"><b><img src="img/btn_mypage_more.gif" border="0" align="absmiddle"></b></font></a></td>
					<td background="img/skin_icon/make_icon/skin_icon_481.jpg" width="5" height="34"></td>
				</tr>
			</table>

			<table cellpadding="0" cellspacing="0" width="100%" border="0" id="div_guin_5">
			<tr>
				<td><?echo guin_extraction_myreg('총2개','가로1개','제목길이40자','진행중','member_guin_list.html','사용안함') ?></td>
			</tr>
			</table>

			<table cellpadding="0" cellspacing="0" width="100%" border="0" id="div_guin_6" style="display:none;">
			<tr>
				<td><?echo guin_extraction_myreg('총2개','가로1개','제목길이40자','마감','member_guin_list.html','사용안함') ?></td>
			</tr>
			</table>

		</td>
	</tr>
</table>

<div style="padding-top:10;"></div>

<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="50%" valign="top" style="padding-right:5;">

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td background="img/skin_icon/make_icon/skin_icon_479.jpg" width="13" height="34"></td>
					<td background="img/skin_icon/make_icon/skin_icon_480.jpg">

						<table cellpadding="0" cellspacing="0">
							<tr>
								<td height="34" align="center">

									<table cellpadding="0" cellspacing="0" style="cursor:hand;">
										<tr id="div_pay_1">
											<td width="6" height="34" background="img/skin_icon/make_icon/skin_icon_482.jpg"></td>
											<td height="34" background="img/skin_icon/make_icon/skin_icon_483.jpg" style="padding-left:10;padding-right:10;padding-top:5;" onclick="ChangeTab2('1');"><b>포인트결제 내역</b></td>
											<td width="6" height="34" background="img/skin_icon/make_icon/skin_icon_484.jpg"></td>
										</tr>
										<tr id="div_pay_2" style="display:none;" >
											<td width="6" height="34"></td>
											<td height="34" style="padding-left:10;padding-right:10;" onclick="ChangeTab2('1');"><b><font color="#FFFFFF">포인트결제 내역</font></b></td>
											<td width="6" height="34"></td>
										</tr>
									</table>

								</td>
								<td height="34" align="center">

									<table cellpadding="0" cellspacing="0" style="cursor:hand;">
										<tr id="div_pay_3" style="display:none;">
											<td width="6" height="34" background="img/skin_icon/make_icon/skin_icon_482.jpg"></td>
											<td height="34" background="img/skin_icon/make_icon/skin_icon_483.jpg" style="padding-left:10;padding-right:10;padding-top:5;" onclick="ChangeTab2('2');"><b>유료결제목록</b></td>
											<td width="6" height="34" background="img/skin_icon/make_icon/skin_icon_484.jpg"></td>
										</tr>
										<tr id="div_pay_4" onclick="ChangeTab2('2');">
											<td width="6" height="34"></td>
											<td height="34" style="padding-left:10;padding-right:10;"><b><font color="#FFFFFF">유료결제목록</font></b></td>
											<td width="6" height="34"></td>
										</tr>
									</table>

								</td>
							</tr>
						</table>

					</td>
					<td background="img/skin_icon/make_icon/skin_icon_480.jpg" align="right" style="padding-right:5;"><a id="div_pay_more" href="my_point_jangboo.php"><font color="#FFFFFF"><b><img src="img/btn_mypage_more.gif" border="0" align="absmiddle"></b></font></td>
					<td background="img/skin_icon/make_icon/skin_icon_481.jpg" width="5" height="34"></td>
				</tr>
			</table>


			<table cellpadding="0" cellspacing="0" width="100%" border="0" id="div_pay_5">
			<tr>
				<td><?echo point_jangboo_list('총5개','가로1개','output_point_jangboo_per.html','사용안함') ?></td>
			</tr>
			</table>

			<table cellpadding="0" cellspacing="0" width="100%" border="0" id="div_pay_6" style="display:none;">
			<tr>
				<td><?echo jangboo_list_com('총5개','가로1개','output_jangboo_com2.html','사용안함') ?></td>
			</tr>
			</table>


		</td>
		<td style="padding-left:5;" valign="top">

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td height="30">

						<script type="text/javascript">
							var aaa = encodeURI('입사제의 목록');
							printSWF("titles", "/flash_swf/mypage_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>&color2=666666", "250", "18", "opaque", "#FFFFFF");
						</script>

					</td>
					<td align="right"><b><a href="com_guin_want.php"><font color="<?=$_data['배경색']['기본색상']?>"><img src="img/btn_mypage_more.gif" border="0" align="absmiddle"></font></a></b></td>
				</tr>
				<tr>
					<td height="2" colspan="2" background="img/skin_icon/make_icon/skin_icon_485.jpg"></td>
				</tr>
			</table>

			<?guin_extraction('총3개','가로1개','제목길이48자','자동','자동','자동','자동','일반','입사제의','guin_want_list_row_com.html') ?>


		</td>
	</tr>
</table>

<div style="padding-top:10;"></div>

<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="7" height="40" background="img/table_bartitle_1.gif"></td>
		<td background="img/table_bartitle_2.gif">

			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td style="padding-bottom:5;">

						<script type="text/javascript">
							var aaa = encodeURI('맞춤인재정보 서비스란?');
							printSWF("titles", "/flash_swf/mypage_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>&color2=666666", "150", "18", "transparent", "#FFFFFF");
						</script>

					</td>
					<td class="smfont">회원님이 등록한 맞춤정보를 바탕으로 사이트에 등록된 이력서를 자동으로 검색해주는 서비스 입니다.</td>
				</tr>
			</table>

		</td>
		<td width="7" height="40" background="img/table_bartitle_3.gif"></td>
	</tr>
</table>

<div style="padding-top:10;"></div>


<table align="center" cellpadding="2" cellspacing="0" width="100%">
<tr>
	<td height="25">

		<script type="text/javascript">
			var aaa = encodeURI('맞춤인재정보 서비스');
			printSWF("titles", "/flash_swf/mypage_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>&color2=666666", "150", "18", "transparent", "#FFFFFF");
		</script>

	</td>
	<td align="right"><b><a href="com_want_search.php?mode=list"><font color="<?=$_data['배경색']['기본색상']?>"><img src="img/btn_mypage_more.gif" border="0" align="absmiddle"></font></a></b></td>
</tr>
</table>
<div style="padding:2;"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td background="img/skin_icon/make_icon/skin_icon_487.jpg" width="1" height="30"></td>
		<td background="img/skin_icon/make_icon/skin_icon_488.jpg" height="30">

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center" width="80">

						<script type="text/javascript">
							var aaa = encodeURI('사진');
							printSWF("titles", "/flash_swf/listtable_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>", "25", "18", "transparent", "#FFFFFF");
						</script>

					</td>
					<td width="1">

						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="1" height="30" background="img/skin_icon/make_icon/skin_icon_490.jpg"></td>
							</tr>
						</table>

					</td>
					<td align="center">

						<script type="text/javascript">
							var aaa = encodeURI('제  목');
							printSWF("titles", "/flash_swf/listtable_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>", "35", "18", "transparent", "#FFFFFF");
						</script>

					</td>
					<td width="1">

						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="1" height="30" background="img/skin_icon/make_icon/skin_icon_490.jpg"></td>
							</tr>
						</table>

					</td>
					<td align="center" width="60">

						<script type="text/javascript">
							var aaa = encodeURI('성별/나이');
							printSWF("titles", "/flash_swf/listtable_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>", "55", "18", "transparent", "#FFFFFF");
						</script>

					</td>
					<td width="1">

						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="1" height="30" background="img/skin_icon/make_icon/skin_icon_490.jpg"></td>
							</tr>
						</table>

					</td>
					<td align="center" width="90">

						<script type="text/javascript">
							var aaa = encodeURI('경력');
							printSWF("titles", "/flash_swf/listtable_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>", "25", "18", "transparent", "#FFFFFF");
						</script>

					</td>
					<td width="1">

						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="1" height="30" background="img/skin_icon/make_icon/skin_icon_490.jpg"></td>
							</tr>
						</table>

					</td>
					<td align="center" width="110">

						<script type="text/javascript">
							var aaa = encodeURI('희망급여');
							printSWF("titles", "/flash_swf/listtable_title.swf?titletext="+aaa+"&color=<?=$_data['배경색']['기본색상']?>", "50", "18", "transparent", "#FFFFFF");
						</script>

					</td>
				</tr>
			</table>

		</td>
		<td background="img/skin_icon/make_icon/skin_icon_489.jpg" width="1" height="30"></td>
	</tr>
</table>

<table cellpadding="0" cellspacing="0">
	<tr>
		<td width="100" height="2"></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td><?document_extraction_list('가로1개','세로3개','옵션1','옵션2','맞춤구직정보','옵션4','최근등록일순','글자70글자짜름','누락0개','doc_rows_default.html','페이징사용함') ?></td>
	</tr>
</table>

<? }
?>