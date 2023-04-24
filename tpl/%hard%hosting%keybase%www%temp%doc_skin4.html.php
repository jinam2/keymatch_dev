<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 09:17:19 */
function SkyTpl_Func_3254192921 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

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
<style type="text/css">
	.guzic_d_tltinfo_content04{border-top:2px solid #c1d0e0; border-bottom:2px solid #c1d0e0; padding:30px 0; overflow:hidden;}
	.guzic_d_tltinfo_content04 > li{width:70%; float:left; padding-left:5%; box-sizing:border-box;}
	.guzic_d_tltinfo_content04 > li:first-child{width:30%; box-sizing:border-box;padding-left:0;}

	.gz_d_con0401{text-align:center; padding-top:80px; }
	.gz_d_con0401 > b{display:block; position:relative; width:160px; height:160px; border-radius:50%; border:1px solid #ddd; margin:-80px auto 0; overflow:hidden;}
	.gz_d_con0401 > b > img{position:absolute; top:0; left:0; bottom:0; right:0; margin:auto;}
	.gz_d_con0401 > div{padding-top:90px; box-sizing:border-box; border-radius:15px; border:1px solid #c1d0e0; overflow:hidden; margin-top:-80px; box-shadow:5px 5px 5px rgba(0,0,0,0.2)}
	.gz_d_con0401 > div > p{text-align:center;}
	.gz_d_con0401 > div > p > strong{display:block; font-size:20px; font-weight:500; color:#333;}
	.gz_d_con0401 > div > p > span{display:block; font-size:14px; color:#999;}
	.gz_d_con0401 > div > strong{text-align:center; display:inline-block; position:relative; padding-left:28px; font-size:24px; letter-spacing:1px;}
	.gz_d_con0401 > div > strong:before{content:''; width:21px; height:21px; display:block; position:absolute; top:9px; left:0; margin:auto; background: url('img/gz_d_icon01.png') no-repeat;}
	.gz_d_con0401 > div > span{display:block; font-size:14px; font-weight:400; color:#999; letter-spacing:-0.5px; text-align:center; border:1px solid #ddd; border-radius:3px; width:116px; margin:10px auto 25px; }

	.gz_d_con0401 > div > table{width:100%; box-sizing:border-box; padding:25px 30px; background:#f0f7ff; text-align:left; border-top:1px solid #c1d0e0;}
	.gz_d_con0401 > div > table th, .gz_d_con0401 > div > table td{font-size:16px; padding:5px 0; color:#333;}

	.gz_d_con0402 > strong,
	.gz_d_con0403 > strong{display:block; font-size:20px; color:#333; letter-spacing:-2px; border-radius:5px; border:1px solid #c1d0e0; background:#f0f7ff; padding:10px 15px; font-weight:500;}
	.gz_d_con0402 > table,
	.gz_d_con0403 > table{width:100%; padding:20px; box-sizing:border-box; }
	.gz_d_con0402 > table th,
	.gz_d_con0402 > table td,
	.gz_d_con0403 > table th,
	.gz_d_con0403 > table td{font-size:16px; vertical-align:top; padding:5px;}
	.gz_d_con0402 > table th,
	.gz_d_con0403 > table th{font-weight:400;}
	.gz_d_con0402 > table th > span,
	.gz_d_con0403 > table th > span{font-size:16px; font-weight:400; width:100%; display:block; position:relative;}
	.gz_d_con0402 > table th > span:after,
	.gz_d_con0403 > table th > span:after{content:'|'; font-size:14px; color:#e9e9e9; position:absolute; right:20px; font-weight:100;}
	.gz_d_con0402 > table td,
	.gz_d_con0403 > table td{}
	.gz_d_con0402 > table td > p,
	.gz_d_con0403 > table td > p{}
	.gz_d_con0402 > table td > p > span,
	.gz_d_con0403 > table td > p > span{font-size:16px; display:inline-block; width:95px;}
	

</style>
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
		<ul class="guzic_d_tltinfo_content04">
			<li class="gz_d_con0401">
				<b><img src="<?=$_data['작은이미지']?>" align="absmiddle" width="<?=$_data['HAPPY_CONFIG']['doc_pic_width_1']?>" height="<?=$_data['HAPPY_CONFIG']['doc_pic_height_1']?>" border="0" onclick="<?=$_data['미니앨범링크']?>"></b> <!-- 대표이미지 -->
				 <div>					
					<p><strong><?=$_data['Data']['user_name']?></strong><span>(<?=$_data['Data']['user_prefix']?>, <?=$_data['Data']['user_age']?>세) / <?=$_data['Data']['user_id']?></span></p>
					<strong style="color:#<?=$_data['배경색']['기본색상']?>;"><?=$_data['Data']['user_hphone']?></strong>
					<span onclick="<?=$_data['미니앨범링크']?>" style="color:#<?=$_data['배경색']['기본색상']?>; ">미니앨범보기</span><!-- 미니앨범보기 버튼 -->			
					<table>
						<colgroup>
							<col width="10%"/>
							<col width="90%"/>
						</colgroup>
						<tbody>
							<tr>
								<th><img src="img/gz_d_icon02.png" alt="전화번호" /></th>
								<td><?=$_data['Data']['user_phone']?></td>
							</tr>
							<tr>
								<th><img src="img/gz_d_icon03.png" alt="이메일" /></th>
								<td colspan="3"><?=$_data['Data']['email']?></td>
							</tr>
							<tr>								
								<th><img src="img/gz_d_icon04.png" alt="홈페이지" /></th>
								<td><?=$_data['Data']['user_homepage']?></td>
							</tr>	
							<tr>								
								<th><img src="img/gz_d_icon05.png" alt="주소" /></th>
								<td><?=$_data['Data']['user_addr1']?> <?=$_data['Data']['user_addr2']?></td>
							</tr>														
						</tbody>
					</table>			
				</div>											
			</li>
			<li class="gz_d_con0402">
				<strong>지원정보</strong>
				<table>
					<colgroup>
						<col width="18%"/>
						<col width="32%"/>
						<col width="18%"/>
						<col width="32%"/>
					</colgroup>
					<tbody>
						<tr>
							<th style="color:#3d6ba7"><span>학력사항</span></th>
							<td><?=$_data['Data']['grade_lastgrade']?></td>
							<th style="color:#3d6ba7"><span>특기사항</span></th>
							<td rowspan="2">	
								<p><span>TOEIC</span><span><?=$_data['토익점수']?></span></p>
								<p><span>해외연수</span><span><?=$_data['해외연수여부']?></span></p>
								<p><span>자격증</span><span><?=$_data['자격증개수']?>개</span></p>							
							</td>
						</tr>
						<tr>
							<th style="color:#3d6ba7"><span>경력사항</span></th>
							<td>
								<?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?>

								<span><?=$_data['Data']['work_otherCountry']?></span>
							</td>
						</tr>
						<tr>
							<th style="color:#3d6ba7"><span>고용형태</span></th>				
							<td><?=$_data['Data']['grade_gtype']?></td>
						</tr>					
					</tbody>
				</table>
			</li>
			<li class="gz_d_con0403">
				<strong>희망 근무 조건</strong>
				<table>
					<colgroup>
						<col width="18%"/>
						<col width="82%"/>
					</colgroup>
					<tbody>
						<tr>
							<th style="color:#3d6ba7;"><span>희망 근무지</span></th>
							<td><?=$_data['Data']['job_where']?></td>
						</tr>
						<tr>
							<th style="color:#3d6ba7;"><span>희망연봉</span></th>
							<td><?=$_data['Data']['grade_money_type']?><?=$_data['Data']['grade_money']?></td>
						</tr>
						<tr>
							<th style="color:#3d6ba7;"><span>희망근무일</span></th>
							<td><?=$_data['Data']['etc7_text']?></td>
						</tr>
						<tr>
							<th style="color:#3d6ba7;"><span>희망업종</span></th>
							<td><?=$_data['Data']['job_type']?></td>
						</tr>
						<tr>
							<th style="color:#3d6ba7;"><span>키워드</span></th>
							<td><?=$_data['Data']['grade_gtype']?></td>
						</tr>
					</tbody>
				</table>
			</li>
		</ul>
	</div>
	
<div class="guzic_d_content_wrap">
		<ul>
			<li class="guzic_d_con_albm">
				<h3 class="m_tlt">
					<strong>앨범</strong>
				</h3>
				<div style="padding:30px; border:1px solid #c5c5c5">
					<?mini_album_view('218','145') ?>

				</div>
				<div class="guzic_d_doc_read_env"><?=$_data['doc_read_env']?></div>
			</li>
			<li>
				<h3 class="m_tlt">
					<strong>학력사항</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;" class="doc_view_detail_table">
						<tr>
							<th class="th_style" style="width:235px;">재학기간</th>
							<th class="th_style">학교명</th>
							<th class="th_style" style="width:265px;">전공</th>
							<th class="th_style" style="width:155px;">소재지</th>
							<th class="th_style" style="width:200px; border-right:none;">학점</th>
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
			<li style="<?=$_data['Data']['oa_style']?>">
				<h3 class="m_tlt">
					<strong style="">OA 능력</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;table-layout:fixed;" class="doc_view_detail_table">
						<tr>
							<th class="th_style">워드(한글/MS워드)</th>
							<th class="th_style">프리젠테이션(파워포인트)</th>
							<th class="th_style">스프레드시트(엑셀)</th>
							<th class="th_style" style="border-right:none;">인터넷(정보검색/Outlook)</th>
						</tr>
						<tr>
							<td class="td_style" style="height:90px;">
								<img src="img/graph/graph<?=$_data['Data']['skill_word']?>.png" alt="<?=$_data['Data']['skill_word_han']?>">
							</td>
							<td class="td_style">
								<img src="img/graph/graph<?=$_data['Data']['skill_ppt']?>.png" alt="<?=$_data['Data']['skill_ppt_han']?>">
							</td>
							<td class="td_style">
								<img src="img/graph/graph<?=$_data['Data']['skill_excel']?>.png" alt="<?=$_data['Data']['skill_excel_han']?>">
							</td>
							<td class="td_style" style="border-right:none;">
								<img src="img/graph/graph<?=$_data['Data']['skill_search']?>.png" alt="<?=$_data['Data']['skill_search_han']?>">
							</td>
						</tr>
					</table>
				</div>
			</li>
			<li style="<?=$_data['Data']['completion_style']?>">
				<h3 class="m_tlt">
					<strong>보유기술 및 보유이수 내용</strong>
				</h3>
				<div style="border-top:2px solid #666666 !important; border:1px solid #c5c5c5;">
					<table cellspacing="0" cellpadding="0" style="width:100%;" class="doc_view_detail_table">
						<tr>
							<th class="th_style" style="border-right:none;">보유기술</th>
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
							<td class="td_style" style="height:65px;">
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
				<div style="text-align:center; padding:50px 0 50px">
					<?=$_data['예비합격버튼']?> <?=$_data['입사지원요청버튼']?> <?=$_data['면접제의버튼']?> <?=$_data['스크랩버튼']?> <?=$_data['프린트버튼1']?> <?=$_data['수정1']?>

				</div>
			</li>
		</ul>
	</div>
	<div class="guzic_d_btns" style="padding:5px 0 5px 0;">
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