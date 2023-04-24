<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 21:46:25 */
function SkyTpl_Func_2602888933 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<!--sns로그인스크립트-->
<script language="javascript" src="js/sns_login.js"></script>
<!--sns로그인스크립트-->



<script>
function toggleLayer(whichLayer) {
var elem, vis;
if(document.getElementById) // this is the way the standards work
elem = document.getElementById(whichLayer);
else if(document.all) // this is the way old msie versions work
elem = document.all[whichLayer];
else if(document.layers) // this is the way nn4 works
elem = document.layers[whichLayer];
vis = elem.style;
// if the style.display value is blank we try to figure it out here
if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
vis.display = (vis.display==''||vis.display=='block')?'none':'block';

	//
	}

	function happy_member_autologin()
	{
		if (document.happy_member_login_form.save_login.checked==true)
		{
			var check;
			check = confirm("아이디저장 기능을 사용하시겠습니까?\n\n아이디가 저장되므로 유의하세요  \n\n공공장소에서 사용시 주의요망 ^^");
			if(check==false)
			{
				document.happy_member_login_form.save_login.checked=false;
				document.happy_member_login_form.save_id.value = 'n';
			}
			else
			{
				document.happy_member_login_form.save_id.value = 'y';
			}
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

	function view_keyboard()
	{
		Obj	= document.getElementById("keyboard_display");
		if ( Obj.style.display == "" )
		{
			Obj.style.display	= 'none';
		}
		else
		{
			Obj.style.display	= '';
		}
	}
	function view_keyboard()
	{
		Obj	= document.getElementById("keyboard_display");
		if ( Obj.style.display == "" )
		{
			Obj.style.display	= 'none';
		}
		else
		{
			Obj.style.display	= '';
		}
	}
</script>
<style type="text/css">
	.h_form .h_btn_st1 { 
		background-color: #<?=$_data['배경색']['모바일메인페이지']?>; 
	}
	.h_form .h_btn_st1:hover, .h_form .h_btn_st1:focus { 
		background-color: #<?=$_data['배경색']['서브색상']?>; 
	}
	.h_form .h-check input[type="checkbox"]:checked + span::before {
		 background-color: #<?=$_data['배경색']['모바일_기본색상']?>;
	}
	.h_form input[type="text"]:focus, 
	.h_form input[type="password"]:focus, 
	.h_form select:focus, 
	.h_form textarea:focus{
		border-color:#<?=$_data['배경색']['모바일_기본색상']?>; 
	}
</style>
<div  class="login_area" style="padding:15px 10px 50px 10px; position:relative; background:#fff">
	<table class="tbl" cellpadding="0" style="width:100%;">
		<tr>
			<td>
				<h2 style="position:relative; font-size:14px" >



										<dl class="login_new_tit">
											<dt><strong>키메디 회원</strong>이신가요?</dt>
											<dd>KeyUp은 키메디에서 제공하는 서비스로, <br>
키메디 회원은 누구나 이용 가능합니다.  </dd>
										</dl>

        로그인하여 세부사항 체크를 위해 위해  임시 삭제 하지 않겠습니다.
					<span style="position:absolute; top:7px; right:5px;  color:#aaaaaa; letter-spacing:-0.5px" >
						<a href="javascript:void(0)" onClick="view_keyboard();" style="color:#aaaaaa; font-weight:500; display:block; text-align:center">
							<img src="<?=$_data['스킨폴더명']?>/mobile_img/view_keyboard.png" style="vertical-align:middle; width:50px; margin-bottom:5px"> 
							<span style="display:block; line-height: 1;" class="font_8">영타한글보기</span>
						</a>
					</span>
				</h2>
			</td>
		</tr>
		<tr id="keyboard_display" style="display:none;">
			<td align="center">
				<table width="100%" cellspacing="0" style="margin-top:20px">
					<tr>
						<td width="280px" align="center">
							<img src="<?=$_data['스킨폴더명']?>/mobile_img/keyboard.png" style="width:280px;height:110px">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<form action="./happy_member_login.php?mode=login_reg" method="post" name="happy_member_login_form" <?=$_data['demo_form']?>>
				<input type="hidden" name="returnUrl" value="<?=$_data['되돌아가는주소']?>">
				<input type='hidden' name='save_id' value="<?=$_data['save_id_value']?>" />
				<div class="login_form h_form">
					<dl>
						<dt class="blind_m">아이디</dt>
						<dd>
							<span class="id_pass_area" style="border-bottom:0">
								<input type="text" name="member_id" value="<?=$_data['demo_id']?>" placeholder="아이디">
							</span>
						</dd>
						<dt class="blind_m">비밀번호</dt>
						<dd>
							<span class="id_pass_area">
								<input type="password"name="member_pass" value="<?=$_data['demo_pass']?>" placeholder="비밀번호">
							</span>
						</dd>
						<dd>
							<span class="log_area">
								<button type="submit" name="formimage1" class="h_btn_b h_btn_st1">
									로그인
								</button>
							</span>
						</dd>
					</dl>


<a href="alert('프로그램체크 부탁드립니다');" class="new_sns_login">간편로그인</a>

<!-- joinus_btn -->
<dl class="joinus_btn">
	<dt>아직 키메디 회원이 아니신가요?</dt>
	<dd>	<a href="happy_member.php?mode=joinus" title="회원가입">회원가입</a></dd>
</dl>
	<!-- //joinus_btn -->


<!-- 					<div>
						<span class="input_chk font_14" >
							<label for="auto_login_use" class="h-check">
								<input type="checkbox" name="auto_login_use" id="auto_login_use" value="y"  onClick="happy_member_auto_login_use()">
								<span>자동로그인</span>
							</label>
							<label for="save_login" class="h-check">
								<input type="checkbox" name="save" onclick="happy_member_autologin()" value="<?=$_data['save_id']?>" <?=$_data['save_id_check']?> id="save_login" title="아이디저장">
								<span>아이디 저장</span>
							</label>
						</span>
					</div> -->
<!-- 					<div class="find_info">
						<a href="happy_member.php?mode=lostid" class="none_a_st">
							<span uk-icon="icon: user; ratio: 2.2" style="display:block;"></span>
							<span style="display:block; margin-top:5px">아이디 찾기</span>
							<span uk-icon="icon: search; ratio: 1"  style="background: #fff;position: absolute; top: 29px;border: 1px solid #e7e7e7; left: 50%; margin-left: 10px;" class="h_btn_circle"></span>
						</a>
						<a href="happy_member.php?mode=lostpass" class="none_a_st">
							<span uk-icon="icon: lock; ratio: 2.2" style="display:block;"></span>
							<span style="display:block; margin-top:5px">비밀번호 찾기</span>
							<span uk-icon="icon: search; ratio: 1"  style="background: #fff;position: absolute; top: 26px;border: 1px solid #e7e7e7; left: 50%; margin-left: 8px;" class="h_btn_circle"></span>
						</a>
						<a href="happy_member.php?mode=joinus" class="none_a_st">
							<span uk-icon="icon: file-edit; ratio: 2.2" style="display:block;"></span>
							<span style="display:block; margin-top:5px">회원가입</span>
						</a>
					</div> -->
				</div>
			</td>
		</tr>
		<!-- <tr>
			<td style="padding-top:25px;">
				<h2 style="position:relative; font-size:14px" >
					<span class="font_26" style="letter-spacing:-1px; color:#333333; font-weight:bold; line-height:1.8">간편하게 로그인</span><br/>
					<span class="font_13" style="letter-spacing:-1px; color:#999999; font-weight:normal; line-height:1">SNS 아이디로 간편하게 로그인하세요.</span>
				</h2>
				<div class="sns_log" style="margin-top:25px;">
					<script language="javascript" src="js/sns_login.js"></script>
					<?echo happy_sns_login('네이버','mobile_img/naver_btn.jpg') ?>

					<?echo happy_sns_login('카카오','mobile_img/kakao_btn.jpg') ?>

					<?echo happy_sns_login('페이스북','mobile_img/facebook_btn.jpg') ?>

					<?echo happy_sns_login('구글','mobile_img/google_btn.jpg') ?>

					<?echo happy_sns_login('트위터','mobile_img/twitter_btn.jpg') ?>

				</div><div id='sns_login_div'></div>
			</td>
		</tr> -->
	</table>	
</div>
<? }
?>