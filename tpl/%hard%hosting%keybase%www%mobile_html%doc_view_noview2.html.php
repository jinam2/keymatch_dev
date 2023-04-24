<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:42:34 */
function SkyTpl_Func_2832863885 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<table class="no_view_resume">
<tr>
	<td>
		<dl>
			<dt>취업활동이 목적인 회원의 신상정보 보호를 위해 비회원, 또는 기업회원이라도 인재열람 서비스를 이용하지않으시면 해당 내용을 열람하실 수 없습니다. <br>
			기업회원 회원으로 로그인한 후 인재열람 서비스를 이용하시기 바랍니다. 
			<br><br>
			<dd class="btn_member">
				<input type="button" value="로그인" class="login" onClick="location.href='./happy_member_login.php'">
				<input type="button" value="회원가입" class="regist" onClick="location.href='./happy_member.php?mode=joinus'">
				<input type="button" value="인재열람서비스 신청" class="service"  onClick="location.href='./member_option_pay2.php'" title="기업회원 서비스입니다.">

			<br><br>채용을 목적으로 하는 경우에만 이용하실 수 있으며 기업의 영업, 마케팅 등 채용 이외의 용도로는 이용하실 수 없습니다.
		</dl>
	</td>
</tr>
</table>
<? }
?>