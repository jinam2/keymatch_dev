<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 15:42:34 */
function SkyTpl_Func_3628111369 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>


			<!--
				개인회원이 로그인 시 출력되는 HTML 파일입니다.
				기업회원으로 로그인해서 이용해야 한다는 안내 내용을 보여주는 파일입니다.
			-->

			<!--
			이력서 보기 회수를 사용해서 이력서의 상세화면을 볼수 있을때 불러오는 파일입니다.
			남아있는 이력서 보기 회수가 출력이 되어야 합니다.
			sms 전송 회수가 출력이 되어야 합니다.
			-->

			<div class="right_resume_view">
				<!-- 인재정보 보기 서비스 -->
				<span class="service1">
					<p class="text">인재의 연락처를 열람하고 싶다면</p>
					<a  href="javascript:alert('개인회원으로 로그인 중이며\n기업회원 서비스입니다.');" class="text_btn">인재정보 보기 서비스</a>
				</span>

				<!-- SMS 문자메시지 발송 서비스 -->
				<span class="service2">
					<p class="text">빠르게 인재와 연락하고 싶다면</p>
					<a href="javascript:alert('개인회원으로 로그인 중이며\n기업회원 서비스입니다.');" class="text_btn">문자메시지발송</a>
				</span>

				<!-- 도움말 -->
				<a href="#help" class="help_txt">도움말</a>

				<!--  로그인/회원가입 버튼 -->
				<span class="login_button">
					<input type="button" value="로그인" class="btn_login" title="기업회원용 서비스에 해당되며, 기업회원으로 로그인하셔야 합니다.">
					<input type="button" value="회원가입" class="btn_regist">
				</span>
			</div>
<? }
?>