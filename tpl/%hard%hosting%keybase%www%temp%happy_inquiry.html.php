<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 00:29:06 */
function SkyTpl_Func_1921901056 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<script language="JavaScript" src="js/happy_member.js" type="text/javascript"></script>
<script language="javascript" src="inc/lib.js"></script>

<SCRIPT type="text/javascript">
<!--
	function checkForm(form)
	{
		if ( validate(form) == false )
		{
			return false;
		}

		if ( form.inquiry_private_agree.checked == false )
		{
			alert("이용약관에 동의를 하셔야지만 작성 하실수 있습니다.");
			form.inquiry_private_agree.focus();
			return false;
		}

		return true;
	}
//-->
</SCRIPT>
<div class="container_c">
	<h3 class="sub_tlt_st02">
		<p>문의하기</p>		
	</h3>
	<!-- 문의하기 시작 -->
	<div style="<?=$_data['links_info_display']?>; margin-top:20px;">
		<table width="100%" cellspacing="0" cellpadding="0" style="border-top:2px solid #777777; background-color:#fafafa;" >
		<tr>
			<td style="padding:20px; border:1px solid #e0e0e0; border-top:none;">
				<table cellspacing="0" cellpadding="0" style="width:100%; border:1px solid #eeeeee; background:#ffffff;">
				<tr>
					<td style="padding:10px;">
						<table cellspacing="0" cellpadding="0" style="width:100%;">
						<tr>
							<td align="center" style="width:150px;">
								<img src="<?=$_data['업체이미지']?>" border="0" style="width:100px; height:53px;" onError="this.src='img/img_noimage.jpg'">
							</td>
							<td align="left" style="padding-left:10px;">
								<table cellspacing="0" cellpadding="0" style="width:100%;">
								<tr>
									<td class="noto400 font_15" style=" width:120px; height:30px; color:#848484;">초빙정보제목</td>
									<td class="noto400 font_15" style="color:#3a3a3a;"><?=$_data['초빙정보제목']?></td>
								</tr>
								<tr>
									<td class="noto400 font_15" style="height:30px; color:#848484;">이메일 / 연락처</td>
									<td class="noto400 font_15" style="color:#3a3a3a;"><?=$_data['메일주소']?> / <?=$_data['연락처']?></td>
								</tr>
								<tr>
									<td class="noto400 font_15" style="height:30px; color:#848484;">담당자</td>
									<td class="noto400 font_15" style="color:#3a3a3a;"><?=$_data['담당자']?></td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</div>
	<!-- 초빙정보 끝 -->


	<div id="mailQna_input">
		<!-- 달력 frame -->
		<iframe width=188 height=166 name='gToday:datetime:agenda.js:gfPop:plugins_time.js' id='gToday:datetime:agenda.js:gfPop:plugins_time.js' src='js/time_calrendar/ipopeng.htm' scrolling='no' frameborder='0' style='visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px; border:0px solid;'></iframe>

		<form name="inquiry_form" id="inquiry_form" method="post" target="h_blank" action="happy_inquiry.php?mode=mailing<?=$_data['id_link']?>" onsubmit="return checkForm(this);" enctype='multipart/form-data'>
		<input type = "hidden" name="links_number" value='<?=$_data['고유번호']?>'>

		<!-- 정보입력폼 -->
		<div style="width:100%; color:#7d7c7c;">
			<h3 class="guin_d_tlt_st02" style="position:relative;">
				<span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>;  margin:0 10px 3px 0""></span>기본 정보 입력
				<p style="position:absolute; top:50px; right:0; color:#999" class="font_14">문의 내용은 초빙업체에 문의메일로 발송되며, 발송내역은 저장되어 마이페이지에서 확인 가능합니다.</p>
			</h3>	

			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
				<tr>
					<td style="">
						<?happy_inquiry_form('자동','입력','happy_inquiry_form_rows.html','happy_inquiry_form_default.html') ?>

					</td>
				</tr>
			</table>
			<!-- 도배방지키 폼내용 -->
			<div <?=$_data['도배방지키사용']?>>
				<table cellspacing="0" cellspacing="0" style="table-layout:fixed; width:100%;  border-collapse: collapse;" class="inquiry_list">
					<tr>
						<th class="title noto400 font_14" style="border-top:0 none">도배방지키</th>
						<td class="substence h_form" style="border-top:0 none">
							<img src='inc/antispam.php?code=yek1k' style="vertical-align:middle">
							<input type="text" name="spamcheck" maxlength="10"  value="" style="width:110px; margin:0 5px;"> 도배방지키입력 (대소문자 관계없음)
						</td>
					</tr>
				</table>
			</div>
			<!-- 도배방지키 폼내용 -->
		</div>

		<!-- 이용약관 -->
		<div style="">
			<h3 class="guin_d_tlt_st02" style="position:relative;">
				<span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>;  margin:0 10px 3px 0""></span>이용약관
			</h3>	
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin-top:10px;">
				<tr>
					<td style="border:1px solid #ababab;">
						<div style="height:300px; overflow-y:scroll;  padding:10px;"><?=$_data['HAPPY_CONFIG']['inquiry_private_agree']?></div>
					</td>
				</tr>
				<tr>
					<td align="right">
						<table border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
							<tr>
								<td class="h_form"><label class="h-check" for="inquiry_private_agree"><input type="checkbox" name="inquiry_private_agree" id="inquiry_private_agree" value="y" style=""> <span class="noto400 font_14">위 이용약관에 동의합니다.</span></label></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

		</div>
		<!-- 버튼 -->
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top:30px; margin-bottom:60px;">
			<tr>
				<td align="center">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><input type="image" src="img/btn_mail_ok.gif"></td>
							<td><a href="javascript:history.go(-1);"><img src="img/btn_mail_cancle.gif" border="0" style="margin-left:5px;"></a></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>



<!-- 폼전송 frame -->
<iframe name= "h_blank" id="h_blank" width="100%" height="500" style="display:none;"></iframe>
<? }
?>