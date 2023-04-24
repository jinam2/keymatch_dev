<?PHP
header("Content-type: text/html; charset=utf-8");
require_once('../secure_config.php') ;												//보안설정
require_once('../config.php') ;																	//에디터 모듈 통합설정
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">

<script language="javascript" src="js/image_upload.js"></script>

<link rel="stylesheet" type="text/css" href="../../css/common.css">
<link rel="stylesheet" type="text/css" href="../../css/style.css">

<title>사진 첨부하기 :: SmartEditor2</title>
<style type="text/css">
/* NHN Web Standard 1Team JJS 120106 */
/* Common */
body,p,h1,h2,h3,h4,h5,h6,ul,ol,li,dl,dt,dd,table,th,td,form,fieldset,legend,input,textarea,button,select{margin:0;padding:0}
body,input,textarea,select,button,table{font-family:'돋움',Dotum,Helvetica,sans-serif;font-size:12px}
img,fieldset{border:0}
ul,ol{list-style:none}
em,address{font-style:normal}
a{text-decoration:none}
a:hover,a:active,a:focus{text-decoration:underline}

/* Contents */
.blind{visibility:hidden;position:absolute;line-height:0}
#pop_wrap{width:445px; border:1px solid #dbdbdb; height:460px;}
#pop_header{padding:10px; background:#f4f4f4}
.pop_container{padding:11px 20px 0}
#pop_footer{margin:3px 2px 0;padding:3px 0 1px; text-align:center}
h1{color:#333;font-size:14px;letter-spacing:-1px}
.btn_area{word-spacing:2px}
.pop_container .drag_area{overflow:hidden;overflow-y:auto;position:relative;width:341px;height:129px;margin-top:4px;border:1px solid #eceff2}
.pop_container .drag_area .bg{display:block;position:absolute;top:0;left:0;width:341px;height:129px;background:#fdfdfd url(../../img/photoQuickPopup/bg_drag_image.png) 0 0 no-repeat}
.pop_container .nobg{background:none}
.pop_container .bar{color:#e0e0e0}
.pop_container .lst_type li{overflow:hidden;position:relative;padding:7px 0 6px 8px;border-bottom:1px solid #f4f4f4;vertical-align:top}
.pop_container :root .lst_type li{padding:6px 0 5px 8px}
.pop_container .lst_type li span{float:left;color:#222}
.pop_container .lst_type li em{float:right;margin-top:1px;padding-right:22px;color:#a1a1a1;font-size:11px}
.pop_container .lst_type li a{position:absolute;top:6px;right:5px}
.pop_container .dsc{margin-top:6px;color:#666;line-height:18px}
.pop_container .dsc_v1{margin-top:12px}
.pop_container .dsc em{color:#13b72a}
.pop_container2{padding:10px 0 0 10px}
.pop_container2 .dsc{margin-top:6px;color:#666;line-height:18px}
.pop_container2 .dsc strong{color:#13b72a}
.upload{margin:0 4px 0 0; _margin:0; padding:6px 0 4px 6px; border:1px solid #d7d7d7; height:24px; color:#a1a1a1; font-size:12px; length:300px; width:360px;}
:root  .upload{padding:6px 0 2px 6px;}

.tap_st_over {border:1px solid #c9c9c9; border-bottom:1px solid #f9f9f9;  background:#f9f9f9; color:#3b3b3b; font:bold 12px '돋움'; cursor:pointer; width:120px; height:29px;}
.tap_st_out {border:1px solid #c9c9c9;background:#efefef; color:#898989; font:12px '돋움'; cursor:pointer; width:120px; height:29px;}


/* 스킨관계없이 기본 */
.input_style input[type=text] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:28px; line-height:27px; margin:2px 0; }
.input_style input[type=password] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:28px; line-height:27px; margin:2px 0; }
.input_style input[type=file] { border:1px solid #bdbdc0; background:#f3f3f3; padding-left:5px; height:30px; line-height:29px; margin:2px 0; }
.input_style select { font-family:맑은 고딕; padding:5px; border:1px solid #bdbdc0; height:30px; line-height:24px; }
.input_style textarea { border:1px solid #bdbdc0; background:#f3f3f3; padding:5px; height:200px; }
.input_style input[type=checkbox]
.input_style input[type=radio] { vertical-align:middle; margin:-2px 0 1px;  cursor:pointer; }
.font_50 { font-size:50px; }
/* 스킨관계없이 기본 */

</style>

</head>
<body style="OVERFLOW: hidden; padding:0; margin:0;" scroll="no">

<iframe src="" width="0px" height="0px" style="display:none;" name="layer_in_frame" id="layer_in_frame"></iframe>
<table cellspacing="0" cellpadding="0" style="height:60px; background:#555555; width:100%;">
<tr>
	<td style="color:#fff; padding-left:20px; font-size:14px;"><strong>이미지 업로드하기</strong></td>
	<td></td>
</tr>
</table>

<table cellspacing="0" cellpadding="0" style="width:100%; background:#fbfbfb; border-bottom:1px solid #eaeaea;">
<tr>
	<td style="color:#999; padding:20px;">
		- <span style="color:#333;"><strong>10mb이하</strong></span> 이미지 파일만 첨부가 가능합니다<br>
		- JPG, GIF, PNG 확장자의 파일만 업로드가 가능합니다.
	</td>
</tr>
</table>
<div id="pop_wrap" style="padding:20px;">


	<!-- //header -->
	<!-- container -->

	<!-- [D] HTML5인 경우 pop_container 클래스와 하위 HTML 적용 그밖의 경우 pop_container2 클래스와 하위 HTML 적용      -->
	<div id="pop_container2" class="pop_container2" style="margin:0; padding:0;">
		<!-- content -->
		<form id="editor_upload_form" name="editor_upload_form" action="image_upload_end.php" method="post" enctype="multipart/form-data" target="layer_in_frame">
		<input type="hidden" name="editor_type" id="editor_type" value="<?=$_GET['editor_type']?>">
		<input type="hidden" name="editor_name" id="editor_name" value="<?=$_GET['editor_name']?>">

		<div id="pop_content2">

			<table cellspacing='0' cellpadding='0' border='0' style="width:400px;">
			<tr>
				<td >
					<table cellspacing='0' cellpadding='0' border='0'>
						<tr>
							<td class="input_style"><input type="file" class="upload" id="uploadInputBox" name="Filedata" style="width:400px;"></td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td style="padding-top:15px;">
					<table cellspacing='0' cellpadding='0' border='0' style="width:100%;">
					<tr>
						<td>
						<table cellspacing='0' cellpadding='0' border='0' style="border-spacing:0; border-collapse:collapse; width:100%;">
							<tr >
								<td align='center' id='happyTab1' class="tap_st_over" onClick='happyTabChange(1)'>이미지 설정</td>
								<td align='center' id='happyTab2' class="tap_st_out" onClick='happyTabChange(2)'>출력 설정</td>
								<td align='center' id='happyTab3' class="tap_st_out" onClick='happyTabChange(3)'>로고 설정</td>
							</tr>
						</table>
						</td>
					</tr>
					<tr>
						<td style="background:#f9f9f9; padding:10px; border:1px solid #c9c9c9; border-top:none;">
							<table width='100%' id='happyDiv1' cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td>
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">썸네일형식 </td>
										<td class="input_style" >
											<select name='thumb_type' onChange="thumb_type_change(this.value)" >
											<option value='가로기준'>가로기준</option>
											<option value='세로기준'>세로기준</option>
											<option value='비율대로짜름'>자동조절</option>
											<option value='비율대로축소'>비율대로축소</option>
											<option value='비율대로확대'>비율대로확대</option>
											<option value='가로기준세로짜름'>가로기준세로짜름</option>
											<option value='세로기준가로짜름'>세로기준가로짜름</option>
											</select>
											<div id='thumb_type_help' style="color:#949494; font:11px '돋움'; letter-spacing:-1px; margin-top:2px; line-height:15px;"></div>
											<script>
											thumb_type_change('가로기준');
											</script>
										</td>
									</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-top:8px;">
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">썸네일 무빙</td>
										<td  class="input_style">
											<select name='thumb_position' >
											<option value='1'>상단배치(좌측)</option>
											<option value='2'>센터배치</option>
											<option value='3'>하단배치(우측)</option>
											</select>
										</td>
									</tr>
									</table>

								</td>
							</tr>
							<tr>
								<td style="padding-top:8px;" >
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">이미지 크기</td>
										<td class="input_style">
											<input type='text' name='thumb_width' id='thumb_width' value='<?=$default_image_width?>'  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;' style="width:30px; "> px
											&nbsp;&nbsp;X&nbsp;&nbsp;
											<input type='text' name='thumb_height' id='thumb_height' value='<?=$default_image_height?>'  onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;' style="width:30px;"> px
											<div style="color:#949494; font:11px '돋움'; letter-spacing:-1px; margin-top:2px; line-height:15px;">썸네일 형식에 따라 자동 조절 됩니다.</div>
										</td>
									</tr>

									</table>
								</td>
							</tr>
							<tr>
								<td style="padding-top:8px;">
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">원본출력</td>
										<td>
											<input type="checkbox" name="print_org" id="print_org" value="y" onclick="print_org_click(this);"> <label for="print_org" style="cursor:pointer;">원본 출력을 원하실 경우 체크 하세요.</label>
										</td>
									</tr>
									</table>

									<!-- 원본출력시 추가설정 -->
									<div id="print_org_div1" style="display:none;">
										<table cellspacing='0' cellpadding='0' border='0'>
										<tr>
											<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top"></td>
											<td class="input_style">
												원본 이미지의 가로사이즈가 <input type="text" name="print_org_maxwidth" value="800" onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;' style='width:30px; "'> px 이상이면
												<br> 클릭시 팝업창으로 원본을 보여주게 됩니다.
											</td>
										</tr>
										</table>
									</div>
									<!-- 원본출력시 추가설정 -->

								</td>
							</tr>
							</table>


							<table width='100%' id='happyDiv2' style='display:none;'  cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td>
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">테두리 두께</td>
										<td style="color:#4f4f4f; font:11px '돋움'; " class="input_style">
											<input type='text' name='image_border' id='image_border' value='0' onKeyPress='if( (event.keyCode<48) || (event.keyCode>57) ) event.returnValue=false;' style='width:30px; "'> px
										</td>
										<td style="color:#949494; font:11px '돋움'; padding-left:10px;">(이미지를 감싸는 라인 두께)</td>
									</tr>
									</table>

								</td>
							</tr>

							<tr>
								<td style="padding-top:8px;">
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">테두리 색상</td>
										<td class="input_style">
											<input type='text' name='image_border_color' id='image_border_color' value='#4B4B4B'  style='width:50px;"'>
										</td>
										<td style="color:#949494; font:11px '돋움'; padding-left:10px;">(이미지를 감싸는 라인 색상)</td>
									</tr>
									</table>

								</td>
							</tr>

							<tr>
								<td style="padding-top:8px;">
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">이미지 정렬</td>
										<td class="input_style">
											<select name='image_align'>
											<option value=''>선택안함</option>
											<option value='left'>왼쪽</option>
											<option value='right'>오른쪽</option>
											<option value='top'>위</option>
											<option value='bottom'>아래</option>
											<option value='absBottom'>줄아래</option>
											<option value='absMiddle'>줄중간</option>
											<option value='baseline'>기준선</option>
											<option value='middle'>중간</option>
											<option value='textTop'>글자상단</option>
											</select>
										</td>
									</tr>
									</table>

								</td>
							</tr>

							<tr>
								<td style="padding-top:8px;">
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">이미지설명</td>
										<td class="input_style">
											<input type='text' name='image_alt' id='image_alt' value='' style='width:200px;"'>
											<div style="color:#949494; font:11px '돋움'; letter-spacing:-1px; margin-top:2px; line-height:15px;">30글자 내외로 입력 해주세요. (alt)<br>
											특수문자 사용금지</div>
									</tr>
									</table>
								</td>
							</tr>
							</table>



							<table width='100%' id='happyDiv3' style='display:none;' cellspacing='0' cellpadding='0' border='0'>
							<tr>
								<td>
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">로고합성</td>
										<td style="padding-top:3px;"><input type='checkbox' name='thumb_logo' value='y' ></td>
										<td style="padding-top:3px; color:#4f4f4f; font:11px '돋움'; padding-left:5px;">체크시 로고 합성</td>
									</tr>
									</table>

								</td>
							</tr>

							<tr>
								<td style="padding-top:15px;">
									<table cellspacing='0' cellpadding='0' border='0'>
									<tr>
										<td style="width:80px; font:12px '돋움'; color:#434343; padding-top:4px;" valign="top">로고위치</td>
										<td >
											<table cellspacing='0' cellpadding='0' border='0'>
												<tr>
													<td>
														<table cellspacing='0' cellpadding='0' style="width:90px; border:1px solid #dfdfdf;">
														<tr>
															<td style="padding:8px; background:#ffffff;">
																<table width='90' cellspacing='0' cellpadding='0'>
																<tr height='30'>
																	<td width='30' align='left' valign='top'><input type='radio' name='thumb_logo_position' value='1'></td>
																	<td width='30' align='center' valign='top'><input type='radio' name='thumb_logo_position' value='2'></td>
																	<td width='30' align='right' valign='top'><input type='radio' name='thumb_logo_position' value='3'></td>
																</tr>
																<tr height='30'>
																	<td align='left' valign='middle'><input type='radio' name='thumb_logo_position' value='4'></td>
																	<td align='center' valign='middle'><input type='radio' name='thumb_logo_position' value='5'></td>
																	<td align='right' valign='middle'><input type='radio' name='thumb_logo_position' value='6'></td>
																</tr>
																<tr height='30'>
																	<td align='left' valign='bottom'><input type='radio' name='thumb_logo_position' value='7'></td>
																	<td align='center' valign='bottom'><input type='radio' name='thumb_logo_position' value='8'></td>
																	<td align='right' valign='bottom'><input type='radio' name='thumb_logo_position' value='9' checked></td>
																</tr>
																</table>
															</td>
														</tr>
														</table>
													</td>

													<td style="padding-left:5px;"><img src="../../img/photoQuickPopup/icon_img_upload_location.gif" alt="" title="" ></td>
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
				</td>
			</tr>
			</table>


		</div>
		</form>
		<!-- //content -->
	</div>
	<div id="pop_container" class="pop_container" style="display:none;">
		<!-- content -->
		<div id="pop_content">
			<p class="dsc"><em id="imageCountTxt">0장</em>/10장 <span class="bar">|</span> <em id="totalSizeTxt">0MB</em>/50MB</p>
			<!-- [D] 첨부 이미지 여부에 따른 Class 변화
			 첨부 이미지가 있는 경우 : em에 "bg" 클래스 적용 //첨부 이미지가 없는 경우 : em에 "nobg" 클래스 적용   -->

			<div class="drag_area" id="drag_area">
				<ul class="lst_type" >
				</ul>
				<em class="blind">마우스로 드래그해서 이미지를 추가해주세요.</em><span id="guide_text" class="bg"></span>
			</div>
			<div style="display:none;" id="divImageList"></div>
			<p class="dsc dsc_v1"><em>한 장당 10MB, 1회에 50MB까지, 10개</em>의 이미지 파일을<br>등록할 수 있습니다. (JPG, GIF, PNG, BMP)</p>
		</div>
		<!-- //content -->
	</div>

	<!-- //container -->
	<!-- footer -->
	<div id="pop_footer">
		<div class="btn_area" style="border-top:1px solid #eaeaea; margin-top:15px;">
		<table cellspacing='0' cellpadding='0' border='0' style=" margin-top:10px; margin-left:150px;">
			<tr>
				<td><img src="../../img/photoQuickPopup/btn_img_upload_ok.gif" alt="저장" id="btn_confirm" onClick="image_upload_submit()"></td>
				<td style="padding-left:3px;"><img src="../../img/photoQuickPopup/btn_cancel.png" width="48" height="28" alt="취소" id="btn_cancel" onClick="parent.editor_layer_close()" style="cursor:pointer;"></td>
			</tr>
		</table>
		</div>
	</div>
	<div id="pop_footer_ing" style="display:none; margin:10px auto; width:360px;">
		<table cellspacing='0' cellpadding='0' border='0' style="">
			<tr>
				<td style="margin-right: 3px;"><img src="../../img/photoQuickPopup/small-loading.gif" alt="업로드중" height="30" width="30"/></td>
				<td>
					이미지 업로드 중입니다. 잠시만 기다려 주세요.
				</td>
			</tr>
		</table>
	</div>
	<!-- //footer -->
</div>

</body>

</html>