<? /* Created by SkyTemplate v1.1.0 on 2023/03/23 09:55:58 */
function SkyTpl_Func_190346192 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 약관 / 개인정보 보호정책 동의 JS [ start ] -->
<SCRIPT LANGUAGE="JavaScript">
<!--
	function chk_form() {

		form = document.chkform;

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



<h3 class="sub_tlt_st01" style="padding-bottom:30px; border-bottom:1px solid #ddd; box-sizing:border-box;">
	<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>">사이트 </b>
	<span>회원가입</span>
</h3>

<form name="chkform" id="chkform">
<input type='hidden' name='member_group' value=''>
<?=$_data['본인인증필수값']?>		<!-- 아이핀추가 hun -->
<div style="padding:0 10px 13px 10px" style="position:relative;">
	<table cellpadding="0" class="tbl" style="width:100%">
		<tr>
			<td>
				<h3 class="font_18" style="padding:10px 0; letter-spacing:-0.4px">
					이용약관
				</h3>
			</td>
		</tr>
		<tr>
			<td>
				<div class="terms">
					<?=$_data['MemberRegistAgreement']?>

				</div>
				<p class="terms_chk h_form">
					<label for='chk_ok' class="h-check"><input type="checkbox" name="chk_ok" id="chk_ok" class="chk_ok"/><span style="color:#000">위 이용약관에 동의합니다.</span></label>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<h3 class="font_18" style="padding:10px 0; letter-spacing:-0.4px">
					개인정보 보호정책
				</h3>
			</td>
		</tr>
		<tr>
			<td>
				<div class="terms">
					<?=$_data['MemberRegistPrivate']?>

				</div>
				<p class="terms_chk h_form">
					<label for='chk_ok1' class="h-check"><input type="checkbox" name="chk_ok1" id="chk_ok1" value="on" class="chk_ok"/><span style="color:#000">위 개인정보보호정책에 동의합니다</span></label>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<h3 class="font_16" style="padding:10px 0; letter-spacing:-0.4px">
					개인정보 수집이용
				</h3>
			</td>
		</tr>
		<tr>
			<td>
				<div class="terms">
					<?=$_data['MemberRegistPrivate2']?>

				</div>
				<p class="terms_chk h_form">
					<label for='chk_ok2' class="h-check"><input type="checkbox" name="chk_ok2" id="chk_ok2" value="on" class="chk_ok"/><span style="color:#000">위 개인정보 수집 이용에 동의합니다</span></label>
				</p>
			</td>
		</tr>
	</table>
	<?=$_data['본인인증수단']?>

</form>
<table cellspacing="0" style="width:100%;padding:5px">
<tr>
	<td align="center" style="padding-top:20px">
		<table cellspacing="0" style="width:100%;">
		<tr>
			<td align="center"><?=$_data['그룹선택']?></td>
		</tr>
		</table>
	</td>
</tr>
</table>

<? }
?>