<? /* Created by SkyTemplate v1.1.0 on 2023/03/17 09:45:13 */
function SkyTpl_Func_864477050 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script>

	var message = new Array();

	message[0]	= "[구인정보 <?=$_data['DETAIL']['number']?>번] 궁d금한점이 있습니다. 연락주세요";
	message[1]	= "[구인정보 <?=$_data['DETAIL']['number']?>번] 입사하고 싶습니다. 연락주세요";
	message[2]	= "[구인정보 <?=$_data['DETAIL']['number']?>번] 입사신청하였습니다. 빠른연락 바랍니다.";
	//	message[숫자] -> 0부터 차례대로 입력하실 메세지들을 입력하시면 됩니다. 개수는 제한이 없습니다.
	//	문자는 80바이트이상 전송이 불가능 하므로 입력후에 테스트를 해보시기 바랍니다.
	//	또는 SMS문자메세지 창(가로 한글8자 세로 한글5줄)보다 글이 넘칠경우 80바이트가 넘을 가능성이 큽니다.
	//	최소 한가지 이상의 문자가 입력이 되어야 합니다.


	function message_select_load()
	{
		var sSize	= message.length;
		var frm		= document.happysms_frm;

		var no		= frm.message_change.options.length;

		for ( i=0,j=1 ; i<sSize ; i++,j++ )
		{
			tmText	= j + "번째 메세지";
			tmValue	= i;
			frm.message_change.options[no]	= new Option(tmText,tmValue,true);
			no		= frm.message_change.options.length;
		}
	}

	function go_message_change()
	{
		var frm	= document.happysms_frm;
		var no	= frm.message_change.selectedIndex;
		var val	= frm.message_change.options[no].value;

		frm.message.value = message[val];
	}

	function chk_sms_point()
	{
		Sms_Count = '<?=$_data['SMS포인트']?>';
		login_id = '<?=$_data['user_id']?>';

		if ( login_id == '' )
		{
			alert('로그인을 해주세요.');
			return false;
		}
		else if ( Sms_Count < 1 )
		{
			alert('문자발송 횟수를 결제해주시기 바랍니다.');
			return false;
		}

		return true;
	}

</script>

<script language="javascript">
<!--
function changeIMG(num){
	if (num == 1)
	{
		document.happysms_frm.callback.style.backgroundImage="";
		document.happysms_frm.callback.value = "";
	}
}
//-->


function check_auto_login()
{
	 obj = document.getElementById("auto_login");

	 if ( obj.checked == true )
	 {
		document.happy_member_login_form.save_id.value = 'y';
	 }
	 else
	 {
		document.happy_member_login_form.save_id.value = 'n';
	 }
}

</script>

<style>
select::-webkit-scrollbar { display:none }
textarea { resize:none; }

.sms_input input{color:#d1d1d1 !important;}
.sms_input input::-webkit-input-placeholder { color:#d1d1d1 !important; }
.sms_input input::-moz-placeholder { color:#d1d1d1 !important; }
.sms_input input::-ms-input-placeholder { color:#d1d1d1 !important; }
.sms_input input:-ms-input-placeholder { color:#d1d1d1 !important; }
</style>

<iframe width='0' height='0' name='sms_iframe' id='sms_iframe' frameborder="0"></iframe><!-- 반드시 필요한 frame 입니다. -->
<form name='happysms_frm' action='http://happysms.happycgi.com/send/send_utf.php' method='post' target='sms_iframe' onsubmit="return chk_sms_point();">
<input type='hidden' name='phone' value='<?=$_data['Data']['secure_phone']?>'><!-- 받을사람 전화번호 예)<?=$_data['Data']['hphone']?> -->
<input type='hidden' name='userid' value='<?=$_data['sms_userid']?>'><!-- HAPPYCGI에서 발급한 아이디 입력 -->
<input type='hidden' name='testing' value='<?=$_data['sms_testing']?>'>
<input type='hidden' name='secure' value='phone_on'>
<input type='hidden' name='type' value='1'>
<input type="hidden" name="reCallUrl" value="<?=$_data['main_url']?>/com_sms_send.php">
<input type="hidden" name="extra_input1" value="<?=$_data['user_id']?>">
<input type="hidden" name="extra_input2" value="<?=$_data['extra_input2']?>">
<input type="hidden" name="extra_input3" value="extra_input3">
<div style="background:url('img/bg_detail_sms.gif') 0 0 no-repeat; height:205px;">
	<div style="padding:30px">
		<table cellpadding="0"cellspacing="0" style="width:100%">
			<tr>
				<td style="width:260px; padding-left:193px; padding-top:15px;">
					<textarea style='width:257px; height:94px; background:none; scrollbars:none; border:0;overflow:hidden;font-size:12px; color:#fff; ' class='font_12' name='message' maxlength='80' readonly></textarea>
				</td>
				<td style="width:250px; padding-left:20px">
					<select name='message_change' onChange='go_message_change()' size='8' style="width:220px; height:143px; padding:15px; background:#242932; color:#a3a4a4; border:1px solid #14171d; resize:none;"></select>
				</td>
				<td style="vertical-align:top; padding-left:30px">
					<table cellpadding="0" cellspacing="0" style="width:100%">
						<tr>
							<td class="noto400 font_14" style="letter-spacing:-1px; color:#949aa3; line-height:1.8;">
								기업회원에게 문의할 내용을 선택한 후 회신번호를 입력하세요<br/>
								장난으로 문자발송시 IP추적 후 형사처벌이 될 수 있습니다.
							</td>
						</tr>
						<tr>
							<td class="h_form sms_input" style="padding:10px 0 10px">
								<input type='text' name='callback' placeholder="회신번호입력" style="width:323px; border:1px solid #1b202a; background:#686c75;" onFocus="return changeIMG(1);">
							</td>
						</tr>
						<tr>
							<td><input type="submit" style="width:80px; height:30px; background:url('./img/btn_sms_submit.gif') 0 0 no-repeat; text-indent:-1000%; cursor:pointer" value="문자발송" <?=$_data['sms_sumit_chk']?>></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
</form>

<!-- 여기서부터 -->
<script>
	message_select_load();
	document.happysms_frm.message_change.selectedIndex = 0;
	go_message_change();
</script>
<!-- 여기까지는 붙어다녀야 하는소스 -->
<? }
?>