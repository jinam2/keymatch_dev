<? /* Created by SkyTemplate v1.1.0 on 2023/04/18 13:32:20 */
function SkyTpl_Func_890063237 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<script>
	var prevLayerName	= "";

	function noViewGo(layerName)
	{
		document.all[layerName].style.display = 'none';
	}

	function startPopup(layerName)
	{
		if ( prevLayerName != "" )
		{
			document.all[prevLayerName].style.display="none";
		}
		document.all[layerName].style.display = '';
		prevLayerName	= layerName;

	}

	function chek_fileNameText(){
		if("<?=$_data['Data']['fileNameText']?>" != ""){
			document.getElementById(1).style.display='';
		}else{
			document.getElementById(1).style.display='none';
		}
	}
</script>
<div class="container_c">
	<h3 class="sub_tlt_st02">
		<p>인재정보 상세보기</p>		
	</h3>
	<div class="guzic_d_top_info_wrap">
		<div class="guin_d_top_btns">
			<p><?=$_data['admin_action']?></p>
			<p><span class="sns_img_size"><?=$_data['tweeter_url']?> <?=$_data['facebook_url']?> <?echo kakaotalk_link('img/sns_icon/icon_kakaotalk.png','20','20') ?> <?=$_data['naverBand']?></span> <?=$_data['쪽지보내기']?><?=$_data['문의하기']?> <?=$_data['프린트버튼']?> <?report_button('img/detail_report.gif') ?></p>
		</div>
		<p class="guzic_d_tltinfo">		
			<strong class="sub_tlt_st_03"><?=$_data['Data']['title']?></strong>
			<span>수정일 <?=$_data['Data']['modifydate']?></span>
		</p>
		<div class="guzic_d_tltinfo_content">
			<div>
				<b><img src="<?=$_data['작은이미지']?>" align="absmiddle" width="<?=$_data['HAPPY_CONFIG']['doc_pic_width_1']?>" height="<?=$_data['HAPPY_CONFIG']['doc_pic_height_1']?>" border="0" onclick="<?=$_data['미니앨범링크']?>"></b> <!-- 대표이미지 -->
				<span onclick="<?=$_data['미니앨범링크']?>" style="color:#<?=$_data['배경색']['기본색상']?>; border:1px solid #<?=$_data['배경색']['기본색상']?>;">미니앨범보기</span><!-- 미니앨범보기 버튼 -->
				<p>
					<strong><?=$_data['Data']['user_name']?></strong> <!-- 이름 -->
					<span>(<?=$_data['Data']['user_prefix']?>, <?=$_data['Data']['user_age']?>세) / <?=$_data['Data']['user_id']?></span> <!-- (성별,나이)/아이디 -->
					<button><?=$_data['첨부파일보기']?></button><!-- 첨부파일 버튼 -->
					<!-- 첨부파일내용 팝업창 -->
					<div id="subfile" style="display:none; position:absolute; top:30px ;left:0px; background-color:#FFFFFF; border:1px solid #121212; padding:10px; width:200px;">
						<table cellspacing="0" style="width:100%;">
						<tr>
							<td>
								<?=$_data['Data']['fileNameText']?>

								<?=$_data['Data']['fileNameValue']?>

							</td>
							<td align="right"><input type="button" value="" title="닫기" onClick="document.getElementById('subfile').style.display='none'" style="background:url('img/btn_file_del.gif') no-repeat; width:12px; height:14px; cursor:pointer; border:0px solid red;"></td>
						</tr>
						</table>
					</div>
				</p>
			</div>
			<ul>
				<li>
					<strong>기본정보</strong>
					<table>
						<colgroup>
							<col width="14%"/>
							<col width="36%"/>
							<col width="14%"/>
							<col width="36%"/>
						</colgroup>
						<tbody>
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>휴대폰</span></th>
								<td><?=$_data['Data']['user_hphone']?></td>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>주소</span></th>
								<td><?=$_data['Data']['user_addr1']?> <?=$_data['Data']['user_addr2']?></td>
							</tr>	
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>전화번호</span></th>
								<td><?=$_data['Data']['user_phone']?></td>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>홈페이지</span></th>
								<td><?=$_data['Data']['user_homepage']?></td>
							</tr>	
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>이메일</span></th>
								<td colspan="3"><?=$_data['Data']['email']?><br>( 추가이메일 : <?=$_data['Data']['user_email2']?>)</td>
							</tr>
						</tbody>
					</table>
				</li>
				<li>
					<strong>지원정보</strong>
					<table>
						<colgroup>
							<col width="14%"/>
							<col width="36%"/>
							<col width="14%"/>
							<col width="36%"/>
						</colgroup>
						<tbody>
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>학력사항</span></th>
								<td>
									<table class="tb_st_02">
									<colgroup>
										<col width="20%"/>
										<col width="20%"/>
										<col width="20%"/>
										<col width="20%"/>
										<col width="20%"/>
									</colgroup>
									<thead>
									<tr>
										<th>입학년월</th>
										<th>졸업년월</th>
										<th>졸업상태</th>
										<th>학교명</th>
										<th>학위</th>
									</tr>
									</thead>
									<tbody>
									<?=$_data['학력리스트내용']?>

									</tbody>
									</table>
								</td>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>고용형태</span></th>
								<td><?=$_data['Data']['grade_gtype']?></td>
							</tr>	
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>경력사항</span></th>
								<td>
									<?=$_data['경력사항내용']?>

								</td>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;" rowspan="2"><span>특기사항</span></th>
								<td rowspan="2">
									<p><span style="font-size:16px;">TOEIC</span><span style="font-size:16px; padding-left:5px;"><?=$_data['토익점수']?></span></p>
									<p><span style="font-size:16px;">해외연수</span><span style="font-size:16px; padding-left:5px;"><?=$_data['해외연수여부']?></span></p>
									<p><span style="font-size:16px;">자격증</span><span style="font-size:16px; padding-left:5px;"><?=$_data['자격증개수']?>개</span></p>
								</td>
							</tr>	
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>희망연봉</span></th>
								<td><?=$_data['Data']['grade_money_type']?><span style="display:inline-block"><?=$_data['Data']['grade_money']?></span></td>
							</tr>
						</tbody>
					</table>
				</li>
				<li>
					<strong>희망 근무 조건</strong>
					<table>
						<colgroup>
							<col width="14%"/>
							<col width="86%"/>
						</colgroup>
						<tbody>
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>희망근무지</span></th>
								<td colspan="3"><?=$_data['Data']['job_where']?></td>
							</tr>	
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>희망근무일</span></th>
								<td colspan="3"><?=$_data['Data']['etc7_text']?></td>
							</tr>	
							<tr>
								<th style="color:#<?=$_data['배경색']['기본색상']?>;"><span>희망진료과</span></th>
								<td colspan="3"><?=$_data['Data']['job_type']?></td>
							</tr>	

						</tbody>
					</table>
				</li>
			</ul>
		</div>
	</div>
	<div class="guzic_d_content_wrap">
		<ul>
			<li>
				<h3 class="m_tlt">
					<strong>학력사항</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;" class="doc_view_detail_table">
						<tr>
							<th class="th_style" style="width:235px;">재학기간</th>
							<th class="th_style">학교명</th>
							<th class="th_style" style="width:265px;">학위</th>
							<th class="th_style" style="width:155px;">졸업상태</th>
<!-- 							<th class="th_style" style="width:200px; border-right:none;">학점</th>
							 -->	
							 </tr>
					</table>
					<div><?=$_data['학력리스트내용']?></div>
				</div>
			</li>
			<li>
				<h3 class="m_tlt">
					<strong>경력사항</strong>
				</h3>
				<div class="noto400 font_15" style="color:#666666; letter-spacing:-1px; line-height:2.5; padding:30px; border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<?=$_data['Data']['work_list']?>

				</div>
			</li>
			<li style="<?=$_data['Data']['completion_style']?>">
				<h3 class="m_tlt">
					<strong>보유기술 및 보유이수 내용</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<table cellspacing="0" cellpadding="0" style="width:100%;" class="doc_view_detail_table">
						<tr>
							<th class="th_style" style="border-right:none; border-bottom:1px solid #ddd;">보유기술</th>
						</tr>
						<tr>
							<td class="noto400 font_15" style="color:#666666; padding:35px; letter-spacing:-1px; line-height:1.8;"><?nl2br_print('Data','skill_list') ?></td>
						</tr>
					</table>
				</div>
			</li>
			<li style="<?=$_data['Data']['license_style']?>">
				<h3 class="m_tlt">
					<strong>자격증</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5; ">
					<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;" class="doc_view_detail_table">
						<tr>
							<th class="th_style" style="width:235px;">취득일</th>
							<th class="th_style">자격증명</th>
							<th class="th_style" style="width:330px; border-right:none;">발행처</th>
						</tr>
					</table>
					<div><?=$_data['자격증리스트내용']?></div>
				</div>
			</li>
			<li style="<?=$_data['Data']['foreign_style']?>">
				<h3 class="m_tlt">
					<strong>어학시험 및 외국어 구사능력</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;" class="doc_view_detail_table">
						<tr>
							<th class="th_style" style="width:235px;">외국어명</th>
							<th class="th_style" style="border-right:none;">구사능력 / 공인시험</th>
						</tr>
					</table>
					<div><?=$_data['언어리스트내용']?></div>
				</div>				
			</li>
			<li style="<?=$_data['Data']['training_style']?>">
				<h3 class="m_tlt">
					<strong>해외연수</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;" class="doc_view_detail_table">
						<tr>
							<th class="th_style" style="width:250px;">연수기간</th>
							<th class="th_style" style="width:210px;">연수국가</th>
							<th class="th_style" style="border-right:none;">목적 및 내용</th>
						</tr>
					</table>
					<div><?=$_data['연수리스트내용']?></div>
				</div>
			</li>
			<li style="<?=$_data['Data']['givespecial_style']?>">
				<h3 class="m_tlt">
					<strong>개인부가정보</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse; table-layout:fixed;" class="doc_view_detail_table">
						<tr>
							<th class="th_style">보훈대상여부</th>
							<th class="th_style">장애대상여부</th>
							<th class="th_style" style="border-right:none;">병역사항</th>
						</tr>
						<tr>
							<td class="td_style">
								<?=$_data['Data']['user_bohun']?>

							</td>
							<td class="td_style">
								<?=$_data['Data']['user_jangae']?>

							</td>
							<td class="td_style" style="border-right:none;">
								<?=$_data['Data']['user_army']?> <?=$_data['Data']['user_army_status']?>

							</td>
						</tr>
					</table>
				</div>
			</li>
			<li>
				<?=$_data['문자전송']?>

			</li>
			<li>
				<h3 class="m_tlt">
					<strong>자기소개서</strong>
					<span style="position:absolute; top:5px; right:0">
						<?=$_data['상세이력서보기버튼']?>

					</span>
				</h3>
				<div class="noto400 font_15" style="color:#666666; letter-spacing:-1px; text-align:left; line-height:1.8; padding:35px; border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<?=$_data['Data']['profile']?>

				</div>
			</li>
			<li>
				<div class="guzic_d_btns" style="text-align:center; padding:50px 0 50px">
					<?=$_data['예비합격버튼']?> <?=$_data['입사지원요청버튼']?> <?=$_data['면접제의버튼']?> <?=$_data['스크랩버튼']?> <?=$_data['프린트버튼1']?> <?=$_data['수정1']?>

				</div>
			</li>
		</ul>
	</div>
	<div style="padding:5px 0 5px 0;">
	<!--관리자와 초빙정보를 등록한 기업회원에게 온라인입사지원을 한경우 온라인입사지원 변경내역-->
	<?echo online_jiwon_list('전체','가로1개','rows_online_jiwon.html','rows_online_jiwon_h.html') ?>

	</div>
	<div style="padding:10px 0; text-align:right">
		<table cellspacing="0" cellpadding="0" style="float:right;">
			<tr>
				<td class="h_form" style="width:200px;"><?=$_data['Data']['select_stats']?></td>
				<td style="padding-left:5px;"><?=$_data['Data']['btn_change']?></td>
			</tr>
		</table>
		<div style="clear:both;"></div>
	</div>
</div>
<? }
?>