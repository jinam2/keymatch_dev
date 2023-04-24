<? /* Created by SkyTemplate v1.1.0 on 2023/03/31 16:16:38 */
function SkyTpl_Func_1998524090 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 전체를 감싸는 테이블 [ start ] -->
<table width="500" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000">
<tr>
	<td height="6"><img src="img/skin_icon/make_icon/skin_icon_223.jpg" border="0"></td>
</tr>
<!-- 폼내용 -->
<FORM action="./happy_member_login.php?mode=login_reg" method="post" name="happy_member_login_form">
<input type="hidden" name="returnUrl" value="<?=$_data['되돌아가는주소']?>">
<tr>
	<td background="img/skin_icon/make_icon/skin_icon_224.jpg" style="padding:25 30 20 30;">

		<!-- 로그인정보 입력부분 [ start ] -->
		<div style="position:relative; border:0 solid green;">
			<!-- 아이디 입력폼 [ start ] -->
			<div style="width:310px; padding-top:2px; border:0 solid red;">
				<table  width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="135"><img src="img/title_txt_id.gif" border="0"></td>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="9" height="21" background="img/log_bgbox_title01a.gif"></td>
							<td bgcolor="#D4D4D4"><?=$_data['사용자아이디']?> | <a href="<?=$_data['회원정보변경주소']?>">회원정보수정</a> | <a href="<?=$_data['마이페이지주소']?>">마이페이지</a> | <a href="<?=$_data['로그아웃주소']?>">로그아웃</a></td>
							<td width="9" background="img/log_bgbox_title01b.gif"></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
			<!-- 아이디 입력폼 [ end ] -->

			<!-- 점선라인 레이어 -->
			<div style="width:310px; height:1px; margin:5 0 5 0; border:0 solid red;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td background="img/dotline_type010.gif"></td></tr></table></div>

			<!-- 비밀번호 입력폼 [ start ] -->
			<div style="width:310px; border:0 solid red;">
				사용자이름:<?=$_data['사용자이름']?> | 쪽지메세지: <?=$_data['쪽지메세지']?> | 포인트:<?=$_data['point_form']?>

			</div>
			<!-- 비밀번호 입력폼 [ end ] -->

			<!-- 로그인버튼 [ start ] -->
			<div style="position:absolute; top:0; left:320px; width:118px;"><input type="image" name="formimage1" src="img/skin_icon/make_icon/skin_icon_236.jpg" onMouseOver="this.src='img/skin_icon/make_icon/skin_icon_237.jpg'" onMouseOut="this.src='img/skin_icon/make_icon/skin_icon_236.jpg'"></div>
			<!-- 로그인버튼 [ end ] -->

		</div>
		<!-- 로그인정보 입력부분 [ end ] -->
	</td>
</tr>
</FORM>
<tr>
	<td background="img/skin_icon/make_icon/skin_icon_228.jpg" style="padding:12 30 12 30;">
		<!-- 아이디/비밀번호찾기 안내부분 [ start ] -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<font style="font-family:맑은 고딕, 돋움; font-size:10pt; font-weight:bold;">회원정보가 잘 기억이 나지 않으세요?</font> <br>
				아이디/비밀번호찾기 <font color="#666666">서비스를 이용하여 도움을 받으시기 바랍니다.</font>
			</td>
			<td width="60"></td>
			<td align="right" valign="top" style="padding-right:8px;">
				<!-- 아이디찾기 버튼 -->
				<div style="margin-bottom:3px;"><A HREF="happy_member.php?mode=lostid"><img src="img/btn_log_search_id.gif" border="0" onMouseOver="this.src='img/btn_log_search_id_ov.gif'" onMouseOut="this.src='img/btn_log_search_id.gif'"></A></div>
				<!-- 비밀번호찾기 버튼 -->
				<div style=""><A HREF="happy_member.php?mode=lostpass"><img src="img/btn_log_search_pw.gif" border="0" onMouseOver="this.src='img/btn_log_search_pw_ov.gif'" onMouseOut="this.src='img/btn_log_search_pw.gif'"></A></div>
			</td>
		</tr>
		</table>
		<!-- 아이디/비밀번호찾기 안내부분 [ end ] -->
	</td>
</tr>
<tr>
	<td background="img/skin_icon/make_icon/skin_icon_224.jpg" style="padding:15 30 30 30;">

		<!-- 회원가입 안내부분 [ start ] -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<?=$_data['아이콘']['회원가입질문문구']?> <br>
				회원으로 가입하시면 보다 편리하게 사이트를 이용하실 수 있습니다.
			</td>
			<td width="60"></td>
			<td align="right" valign="bottom">
				<!-- 회원가입 버튼 -->
				<A HREF="happy_member.php?mode=joinus"><img src="img/skin_icon/make_icon/skin_icon_238.jpg" border="0" onMouseOver="this.src='img/skin_icon/make_icon/skin_icon_239.jpg'" onMouseOut="this.src='img/skin_icon/make_icon/skin_icon_238.jpg'" ></A>
			</td>
		</tr>
		</table>
		<!-- 회원가입 안내부분 [ end ] -->
	</td>
</tr>
<tr>
	<td height="6"><img src="img/skin_icon/make_icon/skin_icon_225.jpg" border="0"></td>
</tr>
</table>
<!-- 전체를 감싸는 테이블 [ end ] -->

<? }
?>