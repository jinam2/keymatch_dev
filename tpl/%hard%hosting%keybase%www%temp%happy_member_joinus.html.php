<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 10:01:10 */
function SkyTpl_Func_3974299008 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 약관 / 개인정보 보호정책 동의 JS [ start ] -->
<SCRIPT LANGUAGE="JavaScript">
<!--

function chk_form() {

	var chkok;
	var form;


	form = document.getElementById("chkform");
	chkok = document.getElementById("chk_ok").checked;
	chkok1 = document.getElementById("chk_ok1").checked;

	if (form.chk_ok.checked == false) {
		alert("이용약관에 동의를 하셔야지만 가입하실수 있습니다.");
		form.chk_ok.focus();
		return false;
	}

	if (form.chk_ok1.checked == false) {
		alert("개인정보 보호정책에 동의를 하셔야지만 가입하실수 있습니다.");
		form.chk_ok1.focus();
		return false;
	}

	if (form.chk_ok2.checked == false) {
		alert("개인정보 수집ㆍ이용에 동의를 하셔야지만 가입하실수 있습니다.");
		form.chk_ok2.focus();
		return false;
	}

	if ( form.member_group.value == '' )
	{
		alert('가입하실 그룹을 선택해주세요.');
		return false;
	}



	<?=$_data['nameCheck_js']?>



	form.action = "?mode=joinus2&member_group="+ form.member_group.value;
		form.method = "post";
		form.submit();

	}

	//-->
</SCRIPT>
<!-- 약관 / 개인정보 보호정책 동의 JS [ end ] -->

<?call_now_nevi('<a href="happy_member.php?mode=joinus">회원약관 및 개인정보보호정책</a>') ?>

<h3 class="sub_tlt_st01" style="margin-bottom:40px;">
	<span style="color:#<?=$_data['배경색']['기본색상']?>">회원가입</span>
	<b>약관동의</b>	
</h3>

<div style=" margin-bottom:10px; ">
	<form name="chkform" id="chkform">
	<input type='hidden' name='member_group' value=''>

	<?=$_data['본인인증필수값']?>		<!-- 아이핀추가 hun -->
	<div style="padding:30px; background:#FAFAFA; border:1px solid #cccccc">
		<table cellspacing="0" style="width:100%;">
		<tr>
			<td class="font_20 noto400" style="padding-bottom:5px; letter-spacing:-1px; color:#000;">
				이용약관
			</td>
		</tr>
		<tr>
			<td>
				<div style="overflow-y:scroll; height:300px; padding:10px; border:1px solid #d7d7d7; background-color:#fdfdfd; color:#7e7e7e; line-height:15px;" class="h_form smfont3"><?=$_data['MemberRegistAgreement']?></div>
			</td>
		</tr>
		<tr>
			<td align="right;" style="border-top:1px solid ##e6e6e6">
				<table cellspacing="0" style="margin-top:15px; width:100%">
					<tr>
						<td style="color:#666; text-align:right" class="h_form"><label class="h-check" for='chk_ok'><INPUT TYPE="checkbox" NAME="chk_ok" id="chk_ok"><span class="noto400 font_14">회원이용약관 내용에 동의합니다.</span></label></td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>
	<div style="padding:30px; background:#FAFAFA; border-top:0 none !important; border:1px solid #cccccc">
		<table cellspacing="0" style="width:100%;">
			<tr>
				<td class="font_20 noto400" style="padding-bottom:5px; letter-spacing:-1px; color:#000;">
					개인정보 보호정책
				</td>
			</tr>
			<tr>
				<td>
					<div style="overflow-y:scroll; height:300px; padding:10px; border:1px solid #d7d7d7; background-color:#fdfdfd; color:#7e7e7e; line-height:15px;" class="h_form smfont3"><?=$_data['MemberRegistPrivate']?></div>
				</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right">
					<table cellspacing="0" style="margin-top:15px; width:100%">
					<tr>
						<td style="color:#666; text-align:right" class="h_form"><label class="h-check" for='chk_ok1'><INPUT TYPE="checkbox" NAME="chk_ok1" id="chk_ok1" value="on"><span class="noto400 font_14">개인정보 보호정책에 동의합니다.</span></label></td>
					</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div style="padding:30px; background:#FAFAFA;  border-top:0 none !important; border:1px solid #cccccc">
		<table cellspacing="0" style="width:100%;">
		<tr>
			<td class="font_20 noto400" style="padding-bottom:5px; letter-spacing:-1px; color:#000;">
				개인정보 수집ㆍ이용
			</td>
		</tr>
		<tr>
			<td>
				<div style="overflow-y:scroll; height:300px; padding:10px; border:1px solid #d7d7d7; background-color:#fdfdfd; color:#7e7e7e; line-height:15px;" class="h_form smfont3"><?=$_data['MemberRegistPrivate2']?></div>
			</td>
		</tr>
		<tr>
			<td align="right" style="text-align:right">
				<table cellspacing="0" style="margin-top:15px; width:100%">
				<tr>
					<td style="color:#666; text-align:right" class="h_form"><label class="h-check" for='chk_ok2'><INPUT TYPE="checkbox" NAME="chk_ok2" id="chk_ok2" value="on"><span class="noto400 font_14">개인정보 수집ㆍ이용에 동의합니다.</span></label></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>
	</form>

	<div style="padding:10px;"></div><!--구분-->
		<table cellspacing="0" style="width:100%; margin:0 auto;" bgcolor="#ffffff">
		<tr>
			<td style="border:1px solid #e7e7e7; padding:20px;" align="left">
				<table cellspacing="0" style="width:100%;">
				<tr>
					<td style="width:180px">
						<table cellspacing="0">
						<tr>
							<td><img src="img/icon_join_sns.gif" title="SNS" alt="SNS"></td>
							<td><a href="happy_member_login.php"><img src="img/icon_join_go.gif" title="로그인바로가기" alt="로그인바로가기" border="0"></a></td>
						</tr>
						</table>
					</td>
					<td  class="noto400 font_14" style="color:#7b7b7b; line-height:140%; padding-left:30px;" align="left">페이스북 및 구글에 회원가입이 되어있으시다면 <span style="color:#121212;">별도의 회원가입 없이 SNS 회원으로 로그인이 가능</span>하며, <br>
					사이트의 기본적인 서비스를 이용하실수 있습니다. SNS회원으로 로그인하시려면 “로그인 바로가기” 버튼을 클릭하여<br>로그인 페이지로 이동 후  페이스북,구글 로그인버튼을 클릭하세요.</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>
	<div style="padding:5px;"></div><!--구분-->
	<div style="width:100%; margin:0 auto;" align="left">
	<?=$_data['본인인증수단']?>

	</div>

</div>
<div style="margin:20px 0 30px 0;" align="center"><?=$_data['그룹선택']?></div>

<? }
?>