<? /* Created by SkyTemplate v1.1.0 on 2023/04/12 13:42:22 */
function SkyTpl_Func_2847238690 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="javascript">

function check_Valid()
{
	//이름 체크
	if ( regiform.bbs_name.value == "" )
	{
		alert("이름을 입력해 주세요.");
		regiform.bbs_name.focus();
		return false;
	}
	//비밀번호 체크
	var pass_dis	= "<?=$_data['pass_display']?>";
	if (pass_dis == "")
	{
		if ( regiform.bbs_pass.value == "" )
		{
			alert("비밀번호를 입력해 주세요.");
			regiform.bbs_pass.focus();
			return false;
		}
	}
	//제목 체크
	if ( regiform.bbs_title.value == "" )
	{
		alert("제목을 입력해 주세요.");
		regiform.bbs_title.focus();
		return false;
	}
	//이메일 체크
	if ( regiform.bbs_email_at_user != undefined && regiform.bbs_email_at_host != undefined )
	{
		if ( regiform.bbs_email_at_user.value == "" && regiform.bbs_email_at_host.value != "" )
		{
			alert("이메일 주소를 모두 입력하세요.");
			regiform.bbs_email_at_user.focus();
			return false;
		}

		if ( regiform.bbs_email_at_user.value != "" && regiform.bbs_email_at_host.value == "" )
		{
			alert("이메일 주소를 모두 입력하세요.");
			regiform.bbs_email_at_host.focus();
			return false;
		}

		if ( regiform.bbs_email_at_user.value != "" )
		{
			var pattern = /^[_a-zA-Z0-9-\.]+$/;

			if ( !pattern.test(regiform.bbs_email_at_user.value) )
			{
				alert("이메일 주소를 올바르게 입력하세요.");
				regiform.bbs_email_at_user.focus();
				return false;
			}
		}

		if ( regiform.bbs_email_at_host.value != "" )
		{
			var pattern = /^[\.a-zA-Z0-9-]+\.[a-zA-Z]+$/;

			if ( !pattern.test(regiform.bbs_email_at_host.value) )
			{
				alert("이메일 주소를 올바르게 입력하세요.");
				regiform.bbs_email_at_host.focus();
				return false;
			}
		}

		if ( regiform.bbs_email_at_user.value != "" && regiform.bbs_email_at_host.value != "" )
		{
			if ( regiform.bbs_email != undefined )
			{
				regiform.bbs_email.value = regiform.bbs_email_at_user.value + "@" + regiform.bbs_email_at_host.value;
			}
		}
	}
	//내용 체크
	if(regiform.bbs_review.value == '') {
		alert('내용을 입력하세요');
		regiform.bbs_review.focus();
		return false;
	}
	//도배방지 체크
	if ( regiform.dobae.value == "" )
	{
		alert("도배방지키를 입력해 주세요.");
		regiform.dobae.focus();
		return false;
	}
	return true;
}
function bbs_email_at_host_select(obj)
{
	if ( regiform.bbs_email_at_host != undefined )
	{
		regiform.bbs_email_at_host.value = obj.options[obj.selectedIndex].value;

		if ( regiform.bbs_email_at_host.value == "" )
		{
			regiform.bbs_email_at_host.focus();
		}
	}
}
</script>

<form name="regiform" method="post" action="bbs_regist.php" onsubmit="return check_Valid();" enctype="multipart/form-data" target="h_blank">
<input type=hidden name="mode" value="add_ok">
<input type="hidden" name="tb" value="<?=$_data['tb']?>">
<input type="hidden" name="bbs_num" value="<?=$_data['bbs_num']?>">
<input type=hidden name="links_number" value="<?=$_data['_GET']['links_number']?>">

<div class="h_form">
	<div class="bbs_reg_form">
		<div class="dp_table_100">
			<div class="dp_table_row">
				<div class="dp_table_cell font_18" style="color:#666666; padding-left:10px;">게시글 <span style="color:#<?=$_data['배경색']['게시판1']?>;">작성</span>하기</div>
				<div class="dp_table_cell font_15" style="color:#afafaf; padding-right:10px; text-align:right;">
					<label for="view_lock">글잠금</label>
					<label class="h-switch h-switch-st2" for="view_lock">
					<input type="checkbox" name="view_lock" value="1" id="view_lock">
					<div class="h-switch-slider"></div>
					</label>
				</div>
			</div>
		</div>
		<div class="bbs_reg_form_line"></div>
		<div class="bbs_reg_form_list" <?=$_data['공지선택노출']?>>
			<span class="bbs_reg_form_title">공지사항
				<span class="bbs_notice_ch">
					<label class="font_15" style="color:#afafaf; margin-left:10px; vertical-align:middle; cursor:pointer;" for="gong_ok">공지사항인 경우 체크</label>
					<label class="h-switch h-switch-st2" for="gong_ok">
						<input type="checkbox" name="gong_ok" value="1" id="gong_ok">
						<div class="h-switch-slider"></div>
					</label>
				</span>
			</span>
		</div>
		<?=$_data['category_select']?>

		<div class="bbs_reg_form_list">
			<span class="bbs_reg_form_title">등록인</span>
			<span class="bbs_reg_form_info"><input type="text" name="bbs_name" value="<?=$_data['MEMBER']['user_nick']?>" <?=$_data['readonly']?>></span>
		</div>
		<div class="bbs_reg_form_list" <?=$_data['pass_display']?>>
			<span class="bbs_reg_form_title">비밀번호</span>
			<span class="bbs_reg_form_info"><input type="password" name="bbs_pass" value="<?=$_data['MEMBER']['pass']?>"></span>
		</div>
		<div class="bbs_reg_form_list">
			<span class="bbs_reg_form_title">이메일</span>
			<span class="bbs_reg_form_info">
				<div class="dp_table_100">
					<div class="dp_table_row">
						<div class="dp_table_cell"><input type="text" name="bbs_email_at_user" value="<?=$_data['MEMBER']['user_email_at_user']?>"></div>
						<div class="dp_table_cell" style="width:20px; text-align:center;"><span style="color:#afafaf" class="font_15">@</span></div>
						<div class="dp_table_cell" style="width:100px; text-align:center;"><input type="text" name="bbs_email_at_host" value="<?=$_data['MEMBER']['user_email_at_host']?>"></div>
						<div class="dp_table_cell" style="width:100px; text-align:center; padding-left:5px;"><select onChange="bbs_email_at_host_select(this);"><option value="">직접입력</option><?=$_data['happy_board_email_options']?></select></div>
					</div>
				</div>
			</span>
		</div>
		<div class="bbs_reg_form_list">
			<span class="bbs_reg_form_title">제목</span>
			<span class="bbs_reg_form_info"><input name="bbs_title" type="text" value="<?=$_data['BOARD']['bbs_title']?>"></span>
		</div>
		<div class="bbs_reg_form_list">
			<span class="bbs_reg_form_title">내용</span>
			<span class="bbs_reg_form_info"><textarea style="height:200px;" name="bbs_review"></textarea></span>
		</div>
		<div class="bbs_reg_form_line"></div>
		<div class="bbs_reg_form_list">
			<span class="bbs_reg_form_title">첨부파일</span>
			<div><input type="file" name="img[]" style="width:90%;"></div>
			<div style="margin-top:5px;"><input type="file" name="img[]" style="width:90%;"></div>
			<div style="margin-top:5px;"><input type="file" name="img[]" style="width:90%;"></div>
		</div>
		<div class="bbs_reg_form_line"></div>
		<div class="bbs_reg_form_list">
			<span class="bbs_reg_form_title">도배방지키</span>
			<span class="bbs_reg_form_info">
				<input name="dobae" type="text" style="width:130px;" maxlength="4" placeholder="도배방지키 입력">
				<span class="bbs_dobae"><?=$_data['BOARD']['bbs_dobae']?></span>
				<input type=hidden name="dobae_org" value="<?=$_data['dobae_org']?>">
			</span>
		</div>
	</div>
	<div class="bbs_reg_bottom_btn" style="border-top:1px solid <?=$_data['B_CONF']['bar_color']?>;">
		<?=$_data['게시판버튼']?>

	</div>
</div>

</form>

<!-- 로그인개선 : NeoHero 2009.07.30 -->
<iframe name="h_blank" id="h_blank" src="" width="0" height="0" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" style="visibility:hidden"></iframe>
<!-- 로그인개선 : NeoHero 2009.07.30 -->

<? }
?>