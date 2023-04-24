<? /* Created by SkyTemplate v1.1.0 on 2023/03/30 13:21:59 */
function SkyTpl_Func_2212218680 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript" src="js/happy_member.js" type="text/javascript"></script>
<script language="JavaScript" src="inc/lib.js" type="text/javascript"></script>
<!-- 회원가입 정보입력 체크 JS [ start ] -->
<script language="Javascript">

	function happyMemberCheckForm(theForm)
	{
		//특수필드체크

		if ( theForm.user_id != undefined )
		{
			if (theForm.id_check.value == 'input'	)
			{
				alert("아이디를 입력해주세요.");
				theForm.user_id.focus();
				return (false);
			}

			if (theForm.id_check.value == 'short'	)
			{
				alert("아이디가 너무 짧습니다.");
				theForm.user_id.focus();
				return (false);
			}

			if (theForm.id_check.value == 'no'	)
			{
				alert("사용중인 아이디입니다.");
				theForm.user_id.focus();
				return (false);
			}

			if (theForm.id_check.value == 'isnotcharacter'	)
			{
				alert("아이디에 사용불가능한 문자가 포함되어 있습니다.");
				theForm.user_id.focus();
				return (false);
			}

		}

		if ( theForm.user_nick != undefined )
		{
			if (theForm.nick_check.value == 'input'	)
			{
				alert("닉네임을 입력해주세요.");
				theForm.user_nick.focus();
				return (false);
			}

			if (theForm.nick_check.value == 'short'	)
			{
				alert("닉네임이 너무 짧습니다.");
				theForm.user_nick.focus();
				return (false);
			}

			if (theForm.nick_check.value == 'no'	)
			{
				alert("사용중인 닉네임 입니다.");
				theForm.user_nick.focus();
				return (false);
			}
		}

		if (happy_member_reg.user_pass != undefined && happy_member_reg.user_pass2 != undefined)
		{
			if (happy_member_reg.user_pass.value != "")
			{
				if (isValidPassword(happy_member_reg.user_pass.value) === false)
				{
					happy_member_reg.user_pass.focus();
					return false;
				}
			}

			if ( happy_member_reg.user_pass.value != happy_member_reg.user_pass2.value )
			{
				alert('비밀번호가 일치하지 않습니다.');
				happy_member_reg.user_pass.focus();
				return false;
			}
		}

		// 주민등록 번호 체크
		<?=$_data['주민등록번호체크']?>


		//핸드폰체크
		<?=$_data['핸드폰체크']?>


		//자동체크
		return validate(theForm);

	}

	function check_jumin()
	{
		var obj	= document.happy_member_reg;

		if ( obj.user_jumin1 && obj.user_jumin2 )
		{
			jumin1	= obj.user_jumin1.value;
			jumin2	= obj.user_jumin2.value;
		}
		else
		{
			alert('정상적인 주민번호 입력이 불가능한 상태 입니다.\n관리자에게 문의 해주세요.');
			return false;
		}

		if(obj.user_jumin1.value.length < 6 || obj.user_jumin2.value.length < 7)
		{
			alert("주민등록번호에 오류가 있습니다. 다시 확인하여 주십시오.");
			obj.user_jumin1.focus();
			return false;
		}

		var rn;
		rn		= obj.user_jumin1.value + obj.user_jumin2.value;
		var sum	= 0;
		for(i=0;i<8;i++) {
			sum+=rn.substring(i,i+1)*(i+2);
		}
		for(i=8;i<12;i++) {
			sum+=rn.substring(i,i+1)*(i-6);
		}
		sum		= 11 - ( sum % 11 );
		if (sum>=10) {
			sum-=10;
		}

		if (rn.substring(12,13) != sum || (rn.substring(6,7) !=1 && rn.substring(6,7) != 2))
		{
			alert("주민등록번호에 오류가 있습니다. 다시 확인하십시오.");
			obj.user_jumin1.focus();
			return false;
		}
		else
		{
			return true;
		}
	}

	var request;
	function createXMLHttpRequest()
	{
		if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
		} else {
		request = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}

	function startRequest(obj)
	{
		str	= obj.value;
		createXMLHttpRequest();
		request.open("GET", "happy_member_ajax_check_id.php?id=" + str , true);
		request.onreadystatechange = handleStateChange;
		request.send(null);
	}

	function handleStateChange()
	{
		if (request.readyState == 4)
		{
			if (request.status == 200)
			{
				var response = request.responseText;
				//alert(request.responseText);

				if ( response == "isnotcharacter" )
				{
					msg			= "<font color='red' style='font-size:11px'>사용할 수 없습니다.</font>";
					inputColor	= "red";
				}
				else if ( response == "ok" )
				{
					msg			= "<font color='#32aa57' style='font-size:11px'>사용가능한 아이디 입니다.</font>";
					inputColor	= "blue";
				}
				else if ( response == "input" )
				{
					msg			= "<font color='red' style='font-size:11px'>아이디를 입력해주세요.</font>";
					inputColor	= "red";
				}
				else if ( response == "short" )
				{
					msg			= "<font color='red' style='font-size:11px'>아이디가 너무 짧습니다.</font>";
					inputColor	= "red";
				}
				else
				{
					msg			= "<font color='red' style='font-size:11px'>사용중인 아이디입니다.</font>";
					inputColor	= "red";
				}
				document.getElementById('id_check_msg').innerHTML	= msg;

				document.all.id_check_msg.innerHTML	= msg;
				document.happy_member_reg.id_check.value	= response;
				document.happy_member_reg.id_check.style.color	= inputColor;
			}
		}
	}

	var request2;
	function createXMLHttpRequest2()
	{
		if (window.XMLHttpRequest) {
		request2 = new XMLHttpRequest();
		} else {
		request2 = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}

	function startRequest2(obj)
	{
		str	= obj.value;
		createXMLHttpRequest2();
		request2.open("GET", "happy_member_ajax_check_nick.php?nick=" + encodeURI(str) +"&nowid=<?=$_data['happy_member_login_id']?>", true);
		request2.onreadystatechange = handleStateChange2;
		request2.send(null);
	}

	function handleStateChange2()
	{
		if (request2.readyState == 4)
		{
			if (request2.status == 200)
			{
				var response = request2.responseText;
				//alert(request2.responseText);

				if ( response == "ok" )
				{
					msg			= "<font color='#32aa57' style='font-size:11px'>사용가능한 닉네임 입니다.</font>";
					inputColor	= "blue";
				}
				else if ( response == "input" )
				{
					msg			= "<font color='red' style='font-size:11px'>닉네임을 입력해주세요.</font>";
					inputColor	= "red";
				}
				else if ( response == "short" )
				{
					msg			= "<font color='red' style='font-size:11px'>닉네임이 너무 짧습니다.</font>";
					inputColor	= "red";
				}
				else
				{
					msg			= "<font color='red' style='font-size:11px'>사용중인 닉네임입니다.</font>";
					inputColor	= "red";
				}
				document.getElementById('nick_check_msg').innerHTML		= msg;

				document.all.nick_check_msg.innerHTML				= msg;
				document.happy_member_reg.nick_check.value			= response;
				document.happy_member_reg.nick_check.style.color	= inputColor;
			}
		}
	}
</script>
<!-- 회원가입 정보입력 체크 JS [ end ] -->

<?=$_data['핸드폰인증레이어']?>


<style>
	.mobile_send_btn{display:block; display:block; padding:15px 0; text-align:center; background:#707070; color:#fff; letter-spacing:-1.5px; font-weight:bold; font-size: 1rem; line-height: 1rem; background:#<?=$_data['배경색']['모바일_서브색상']?>}
	.guide_txt {display:none;}
</style>
<h3 class="sub_tlt_st01" style="padding-bottom:30px; border-bottom:1px solid #ddd; box-sizing:border-box; position:relative;">
	<b style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['회원그룹명']?> </b>
	<span>정보수정</span>
	<i class="font_8" style="position:absolute; bottom:15px; right:15px; font-weight:normal; font-style:normal;">
		<img src="img/form_icon1.gif">필수입력항목
	</i>
</h3>
<div style="margin:20px 10px; background:#f5f5f5; border:1px solid #ddd; border-radius:5px; box-sizing:border-box; color:#999; line-height:140%; padding:15px 10px" class="font_malgun font_14">
	<ul class="list_front_dot_st" style="margin-top:0;">
		<li>아이디는 4자 이상 입력해주시기 바랍니다</li>
		<li>비밀번호는 영문, 숫자조합으로 8자 이상 입력해 주세요.</li>
		<li>이름은 실명인증시 자동으로 입력됩니다.</li>
		<li>닉네임은 영문이나 한글로 작성하실 수 있습니다.</li>
	</ul>
</div>

<!-- 회원정보수정 start -->
<form action="happy_member.php?mode=modify_reg" method="post" name="happy_member_reg" onsubmit="return happyMemberCheckForm(this);"  enctype="multipart/form-data">
<input type="hidden" name="nick_check" value="ok">
<input type="hidden" name="blank_3" value="<?=$_data['new_ssn']?>">

<div style="padding:0 10px;"><?happy_member_user_form('회원그룹','전체','happy_member_form_rows.html','happy_member_form_default.html') ?></div>

<div style="margin:20px 0 40px 0;" align="center">
	<div style="padding:0 10px">
		<table  style="width:100%;" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td width="49%">
					<input type="submit" value="수정하기" class="mobile_send_btn" style="width:100%">
				</td>
				<td width="5px"></td>
				<td width="49%" style="text-align:center" >
					<input type="button" value="취소" onClick="history.back();" class="font_20 font_malgun btn_gra2" style="width:100%; display: block;padding:15px 0; text-align: center;border:1px solid #dddddd;color: #333; letter-spacing: -1.5px;font-weight: bold;font-size:1rem; line-height: 1rem;">
				</td>
			</tr>
		</table>
	</div>
</div>
</form>
<!--
<?=$_data['회원탈퇴']?>

<input type="button" value="정보보기" onClick="location.href='./happy_member_view.php?view_user_id=<?=$_data['MEM']['user_id']?>'" class="btnbg_regular_cancel">
 -->
<? }
?>