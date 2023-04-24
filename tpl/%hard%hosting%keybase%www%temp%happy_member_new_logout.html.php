<? /* Created by SkyTemplate v1.1.0 on 2023/04/21 09:48:21 */
function SkyTpl_Func_2613503524 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!--sns로그인스크립트-->
<script language="javascript" src="js/sns_login.js"></script>
<div id='sns_login_div'></div>
<!--sns로그인스크립트-->

<SCRIPT language="JavaScript">

	function CheckForm(theForm)
	{
		var name_title	= new Array("회원아이디를", "회원비밀번호를");
		var name_name	= new Array("member_id", "member_pass");

		for(var i in name_name)
		{
			if (document.getElementById(name_name[i]).value == "")
			{
				alert(name_title[i] + " 입력하세요.");
				document.getElementById(name_name[i]).focus();
				return (false);
			}
		}
	}

	function happy_member_autologin()
	{
		if (document.happy_member_login_form.save_login.checked==true)
		{
			var check;
			check = confirm("\n자동로그인 기능을 사용하시겠습니까?\n\n아이디와 비밀번호가 저장되므로 유의하세요  \n\n공공장소에서 사용시 주의요망 ^^");
			if(check==false)
			{
				document.happy_member_login_form.save_login.checked=false;
			}
		}
	}

	function changeIMG(num)
	{
		if (num == 1)
		{
			document.happy_member_login_form.member_id.style.xbackgroundImage="";
		}
		else if (num == 2)
		{
			document.happy_member_login_form.member_pass.style.xbackgroundImage="";
		}
	}


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

	function happy_member_auto_login_use()
	{
		if ( document.happy_member_login_form.auto_login_use.checked == true )
		{
			var check;
			check = confirm("자동로그인 기능을 사용 하시겠습니까?\n\n자동로그인를 하시는 경우 별도의 로그오프를 하지 않는 이상 로그인이 유지 됩니다.  \n\n공공장소에서 사용시 주의요망 ^^");
			if( check == false )
			{
				document.happy_member_login_form.auto_login_use.checked = false;
			}
		}
		else
		{
			document.happy_member_login_form.auto_login_use.checked = false;
		}
	}
</SCRIPT>

<?call_now_nevi('회원로그인') ?>

<style type="text/css">
/* 우측스크롤 배너 페이지 상단고정 */
.scroll_menu{top:250px}
</style>

<?=$_data['demo_login_layer']?>		<!-- //데모 로그인 기능 개선.		2018-12-13 hun -->

<div class="contents" style="overflow:hidden; padding:30px 0 35px 0">
	<div class="login_area">
		<table class="tbl" cellpadding="0" style="width:100%">
			<tr>
				<td>
					<h2 style="padding:10px 0">
						<img src="img/login_01.gif" alt="로그인 타이틀">
					</h2>
				</td>
			</tr>
			<tr>
				<td>
					<div style="border-top:3px solid #333333 !important; border:1px solid #dcdcdc">
						<table class="tbl" style="width:100%; table-layout:fixed">
							<tr>
								<td style="background:#fff; vertical-align:top">
									<div style="margin:35px 55px">
										<h3 style="margin-bottom:20px">
							
										<dl class="login_new_tit">
											<dt><strong>키메디 회원</strong>이신가요?</dt>
											<dd>KeyUp은 키메디에서 제공하는 서비스로, <br>
키메디 회원은 누구나 이용 가능합니다.  </dd>
										</dl>
					
										</h3>

        로그인하여 세부사항 체크를 위해 위해  임시 삭제 하지 않겠습니다.
										<form action="./happy_member_login.php?mode=login_reg" method="post" name="happy_member_login_form" <?=$_data['demo_form']?>>
											<input type="hidden" name="returnUrl" value="<?=$_data['되돌아가는주소']?>">
											<input type='hidden' name='save_id' value="<?=$_data['save_id_value']?>" />
											<div class="login_form s_ib">
												<div class="h_form" style="margin-bottom:5px">
													<input type="text" name="member_id" placeholder="아이디" value="<?=$_data['demo_id']?>"  id="input_ie7" style="width:300px; ">
												</div>
												<div class="h_form">
													<input type="password"name="member_pass" value="<?=$_data['demo_pass']?>" placeholder="비밀번호"  id="input_ie7" style="width:300px; ">
												</div>
												<span class="btn_login">
													<input type="submit" name="formimage1" src="img/btn_login.gif" alt="로그인버튼" style="width:168px; height:85px; background:url('img/skin_icon/make_icon/skin_icon_730.jpg') 0 0 no-repeat; text-indent:1000%; cursor:pointer">
												</span>
		

											</div>
										</form>
										<div class="social" style="margin-top:20px">
<a href="javascript:void(0);" class="new_sns_login" onClick="kmsso_login_request()">간편로그인</a>
											<div style="overflow:hidden; padding:22px 0 0 30px; font-size:0; ">
												<script language="javascript" src="js/sns_login.js"></script>
												<?echo happy_sns_login('페이스북','img/sns_icon/btn_facebook_login_01.png') ?>

												<span class="s_ib" style="width:1px; height:38px; background:#f0f0f0; margin:0 8px"></span>
												<?echo happy_sns_login('구글','img/sns_icon/btn_google_login_01.png') ?>

												<span class="s_ib" style="width:1px; height:38px; background:#f0f0f0; margin:0 8px"></span>
												<?echo happy_sns_login('트위터','img/sns_icon/btn_twitter_login_01.png') ?>

												<span class="s_ib" style="width:1px; height:38px; background:#f0f0f0; margin:0 8px"></span>
												<?echo happy_sns_login('카카오','img/sns_icon/btn_kakao_login_01.png') ?>

												<span class="s_ib" style="width:1px; height:38px; background:#f0f0f0; margin:0 8px"></span>
												<?echo happy_sns_login('네이버','img/sns_icon/btn_naver_login_01.png') ?>

												<div id='sns_login_div'></div><!-- 로그인 폼 밖에 위치해야 합니다 -->
											</div>
										</div>

<!-- joinus_btn -->
<dl class="joinus_btn">
	<dt>아직 키메디 회원이 아니신가요?</dt>
	<dd>	<a href="happy_member.php?mode=joinus" title="회원가입">회원가입 바로가기</a></dd>
</dl>
	<!-- //joinus_btn -->

									</div>
								</td>
								<td style="width:300px; border-left:1px solid #dcdcdc">
									<?echo happy_banner('로그인혜택','배너제목','랜덤') ?>

								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<script>
	var KEYMEDI_SSO_LOGIN_URL = '<?=$_data['_KEYMEDI_LOGIN_URL']?>' ;

	//  키메디 SSO 화면 연결
	function kmsso_login_request()
	{
		//window.open(KEYMEDI_SSO_LOGIN_URL,'window','location=no, directories=no,resizable=no,status=no,toolbar=no,menubar=no, width=480,height=750,left=0, top=0, scrollbars=yes') ;
		window.open(KEYMEDI_SSO_LOGIN_URL);
	}
</script>
<? }
?>