<? /* Created by SkyTemplate v1.1.0 on 2023/04/07 13:47:36 */
function SkyTpl_Func_3434865565 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
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
	if( CKEDITOR.instances['bbs_review'].getData() == '' )
	{
		alert('내용을 입력하세요');
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


<form name="regiform" method="post" action="bbs_mod.php" onsubmit="return check_Valid();" enctype="multipart/form-data">
<input type="hidden" name="mode" value="mod_ok">
<input type="hidden" name="gong_ok" value="<?=$_data['top_gonggi']?>">
<input type="hidden" name="top_gonggi" value="<?=$_data['top_gonggi']?>">
<input type="hidden" name="tb" value="<?=$_data['tb']?>">
<input type="hidden" name="bbs_num" value="<?=$_data['bbs_num']?>">
<input type="hidden" name="pg" value="<?=$_data['_GET']['pg']?>">
<input type=hidden name="links_number" value="<?=$_data['_GET']['links_number']?>">
<input type=hidden name='boardCallType' value='<?=$_data['boardCallType']?>'>

<!-- Ajax 파일 업로드용 -->
<input type="hidden" name="img_val_0" value="<?=$_data['BOARD']['bbs_etc1']?>">
<input type="hidden" name="img_val_1" value="<?=$_data['BOARD']['bbs_attach2']?>">
<input type="hidden" name="img_val_2" value="<?=$_data['BOARD']['bbs_attach3']?>">
<!-- Ajax 파일 업로드용 END -->


<div style="width:<?=$_data['B_CONF']['table_size']?>;">

	<!-- 게시판상단 -->
	<div><?=$_data['게시판상단']?></div>
	<!-- 게시판상단 -->

	<div style="border-top:1px solid <?=$_data['B_CONF']['bar_color']?>;" class="bbs_reg_table">
		<table>
		<?=$_data['category_select']?>

		<tr>
			<th>등록인</th>
			<td class="h_form">
				<input type="text" name="bbs_name" value="<?=$_data['BOARD']['bbs_name']?>" <?=$_data['readonly']?> style="width:200px;">
			</td>
		</tr>
		<tr <?=$_data['pass_display']?>>
			<th>비밀번호</th>
			<td class="h_form">
				<input type="password" name="bbs_pass" value="<?=$_data['BOARD']['bbs_pass']?>" style="width:200px;">
			</td>
		</tr>
		<tr>
			<th>이메일</th>
			<td class="h_form">
				<input type="text" name="bbs_email_at_user" value="<?=$_data['BOARD']['bbs_email_at_user']?>" style="width:200px;"> <span style="color:#afafaf" class="font_15 noto400">@</span> <input type="text" name="bbs_email_at_host" value="<?=$_data['BOARD']['bbs_email_at_host']?>" style="width:200px;"><select style="width:200px; margin-left:10px;" onChange="bbs_email_at_host_select(this);"><option value="">직접입력</option><?=$_data['happy_board_email_options']?></select>
			</td>
		</tr>
		<tr>
			<th>글잠금</th>
			<td class="h_form">
				<label class="h-switch h-switch-st2" for="view_lock">
					<input type="checkbox" name="view_lock" value="1" id="view_lock" <?=$_data['BOARD']['view_lock_info']?>>
					<div class="h-switch-slider"></div>
				</label>
				<label class="font_15 noto400" style="color:#afafaf; margin-left:10px; vertical-align:middle; cursor:pointer;" for="view_lock">게시글을 잠금상태로 설정합니다.</label>
			</td>
		</tr>
		<tr <?=$_data['공지선택노출']?>>
			<th>공지사항</th>
			<td class="h_form">
				<label class="h-switch h-switch-st2" for="gong_ok">
				<input type="checkbox" name="gong_ok" value="1" id="gong_ok" <?=$_data['notice_check']?>>
				<div class="h-switch-slider"></div>
				</label>
				<label class="font_15 noto400" style="color:#afafaf; margin-left:10px; vertical-align:middle; cursor:pointer;" for="gong_ok">해당 게시판의 공지글로 설정합니다. ( 관리자만 가능 )</label>
			</td>
		</tr>
		<tr>
			<th>제목</th>
			<td class="h_form"><input name="bbs_title" type="text" value="<?=$_data['BOARD']['bbs_title']?>"></td>
		</tr>
		<tr>
			<td colspan="2" style="padding:10px 0px;">
				<!-- 위지윅 시작 -->
				<?echo happy_wys_css('ckeditor','./') ?>

				<?echo happy_wys_js('ckeditor','./') ?>

				<?echo happy_wys('ckeditor','가로100%','세로650','bbs_review','{BOARD.bbs_review}','./','happycgi_normal','all') ?>

				<!-- 위지윅끝 -->
			</td>
		</tr>
		<tr>
			<th>첨부파일1</th>
			<td class="h_form">
				<input type="file" name="img[]" class="input_text_st" style="width:80%;"> <span class="check_box_st bbs_font_st"><?=$_data['BOARD']['bbs_etc1_del']?></span>
			</td>
		</tr>
		<tr>
			<th>첨부파일2</th>
			<td class="h_form">
				<input type="file" name="img[]" class="input_text_st" style="width:80%;"> <span class="check_box_st bbs_font_st"><?=$_data['BOARD']['bbs_attach2_del']?></span>
			</td>
		</tr>
		<tr>
			<th>첨부파일3</th>
			<td class="h_form">
				<input type="file" name="img[]" class="input_text_st" style="width:80%;"> <span class="check_box_st bbs_font_st"><?=$_data['BOARD']['bbs_attach3_del']?></span>
			</td>
		</tr>
		</table>
	</div>

	<!-- 게시판버튼 -->
	<div style="border-top:1px solid <?=$_data['B_CONF']['bar_color']?>;" class="h_form bbs_reg_bottom_btn">
		<?=$_data['게시판버튼']?>

	</div>
	<!-- 게시판버튼 -->

	<!-- 게시판하단 -->
	<div><?=$_data['게시판하단']?></div>
	<!-- 게시판하단 -->

</div>

</form>

<? }
?>