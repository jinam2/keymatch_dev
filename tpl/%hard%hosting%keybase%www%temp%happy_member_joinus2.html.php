<? /* Created by SkyTemplate v1.1.0 on 2023/03/07 10:01:17 */
function SkyTpl_Func_1955124082 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript" src="js/happy_member.js" type="text/javascript"></script>
<script language="JavaScript" src="inc/lib.js" type="text/javascript"></script>

<!-- 회원가입 정보입력 체크 JS [ start ] -->
<SCRIPT language="JavaScript">

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


		if (isValidPassword(happy_member_reg.user_pass.value) === false)
		{
			happy_member_reg.user_pass.focus();
			return false;
		}


		if ( happy_member_reg.user_pass.value != happy_member_reg.user_pass2.value )
		{
			alert('비밀번호가 일치하지 않습니다.');
			happy_member_reg.user_pass2.focus();
			return false;
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
		request.open("GET", "happy_member_ajax_check_id.php?id=" + encodeURIComponent(str) , true);
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
		request2.open("GET", "happy_member_ajax_check_nick.php?nick=" + encodeURI(str) , true);
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
				document.happy_member_reg.nick_check.value			= response;
				document.happy_member_reg.nick_check.style.color	= inputColor;
			}
		}
	}
</SCRIPT>

<?call_now_nevi('회원가입') ?>

<h3 class="sub_tlt_st01" style="margin-bottom:40px;">
	<span style="color:#<?=$_data['배경색']['기본색상']?>">회원가입</span>
	<b><?=$_data['회원그룹명']?></b>	
	<p>회원가입에 필요한 정보를 입력해주세요.</p>
</h3>

<!-- 폼체크 [ start ] -->
<FORM action="happy_member.php?mode=joinus_reg" method="post" name="happy_member_reg" onsubmit="return happyMemberCheckForm(this);"  enctype='multipart/form-data'>
<input type='hidden' name='id_check' value='input'>
<input type='hidden' name='nick_check' value='input'>
<input type='hidden' name='blank_3' value='<?=$_data['new_ssn']?>'>
<input type='hidden' name='group' value='<?=$_data['_GET']['member_group']?>'>
<input type='hidden' name='iso_hphone' value=''>

<input type='hidden' name='coinfo1' value='<?=$_data['_POST']['kcb_coinfo1']?>'>		<!-- 아이핀인증 hun -->
<input type='hidden' name='duinfo' value='<?=$_data['_POST']['kcb_duinfo']?>'>		<!-- 아이핀인증 hun -->
<input type='hidden' name='cl' value='<?=$_data['_POST']['cl']?>'>					<!-- 휴대폰인증 hun -->


<div style="border:1px solid #e7e7e7; border-bottom:1px solid #cccccc; margin-bottom:10px; padding:30px;">
	<!-- {회원폼 자동,메인,happy_member_form_rows.html,happy_member_form_default.html}}
	{회원폼 자동,서브,happy_member_form_rows.html,happy_member_form_default.html}} -->
	<?happy_member_user_form('자동','전체','happy_member_form_rows.html','happy_member_form_default.html') ?>

</div>
<div align="center" style="margin:20px 0 30px 0;">
	<table cellspacing="0">
	<tr>
		<td style="padding-right:10px;"><INPUT  type="image" value="회원가입정보입력" src="img/btn_member_join.gif" border="0" ></td>
		<td><A href="javascript:history.back()"><img src="img/btn_member_cancel.gif" border="0"></a></td>
	</tr>
	</table>
</div>

</FORM>

<? }
?>