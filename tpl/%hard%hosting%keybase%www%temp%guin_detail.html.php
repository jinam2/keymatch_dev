<? /* Created by SkyTemplate v1.1.0 on 2023/04/19 15:36:36 */
function SkyTpl_Func_2792575618 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>

<!-- 텝메뉴 스크립트 -->
<script type="text/javascript">
	//<![CDATA[
		$(document).ready(function(){
			tabScroll(".tabBt");
		});
		function tabScroll(id){
			var tabId = $(id);
			var tabIdtop = tabId.offset().top;
			var tabIdHe = tabId.height();

			$(window).scroll(function(){
				if ($(this).scrollTop() >= tabIdtop) {
					tabId.css({"position":"fixed","top":"100px","margin-top":"0"});
					$( '.conList' ).addClass( 'info_fixed' );
				} else {
					tabId.css({"position":"relative","top":"0","margin-top":"0"});
					$( '.conList' ).removeClass( 'info_fixed' );
				}
			});

			tabId.find("li").each(function(){
				var liThis = $(this);
				var divId = liThis.find("a").attr("href");
				//var divIdtop = $(divId).offset().top-tabIdHe;
				var divIdtop =  parseInt($(divId).offset().top-tabIdHe) -175;
				liThis.bind("click", function(e){
					e.preventDefault();
					$('body,html').animate({scrollTop: divIdtop},300);
				});
				$(window).scroll(function(){
					if ($(this).scrollTop() >= divIdtop ) {
						liThis.addClass("on").siblings().removeClass("on");
					}
				});
			});
		}
	//]]>
</script>

<script>
	$(document).ready(function(){

		var bottomBox			= $('#guin_detail_view_container');

		$( window ).scroll( function() {

			if ( $("#guin_detail_view_close_val").val() == "close" )
			{
				return;
			}

			var nowScrollHeight		= $(window).scrollTop() + $(window).height();
			var stopPosition		= $(document).height() - $('#in_bottom_copyright').height();

			if ( nowScrollHeight >= stopPosition )
			{
				bottomBox.fadeOut(500);
			}
			else
			{
				bottomBox.fadeIn(500);
			}
		});
	});

	function guin_detail_view_close()
	{
		var bottomBox			= $('#guin_detail_view_container');
		bottomBox.fadeOut(500);

		$("#guin_detail_view_close_val").val("close");
	}
</script>
<style type="text/css">
	/* 초빙정보 버튼 상단 카운트 */
	.guin_info_cnt:after{content:'<?=$_data['진행중인초빙정보']?>'; background:#<?=$_data['배경색']['기본색상']?>; color:#fff; font-size:16px; font-weight:bold; position:absolute; top:-18px; right:-20px; display:block; width:36px; height:36px; line-height:34px; text-align:center; border-radius:50%;}
	
</style>
<div id="guin_detail_view_container" style=" width:100%; left:0; bottom:0; position:fixed;  z-index:999; background:rgba(56,135,222,0.2);">
	<div style="width:1200px; margin:0 auto; height:60px; line-height:60px; position:relative; text-align:center">
		<span class="font_18 noto400" style="letter-spacing:-1px; color:#000000">
			최근 <span style="font-weight:500;"><?=$_data['HAPPY_CONFIG']['guin_detail_view_time']?></span> 시간 동안 <span style="font-weight:500;"><?=$_data['DETAIL']['guin_detail_view']?></span> 명이 초빙정보를 열람했습니다.
		</span>
		<span style="position:absolute; right:10px; top:24px">
			<a href="javascript:void(0);" onClick="guin_detail_view_close()" title="창닫기">
				<img src="./img/detail_line_close.png"  alt="닫기">
			</a>
		</span>
		<input type="hidden" id="guin_detail_view_close_val" value="">
	</div>
</div>
<div class="container_c">
	<h3 class="sub_tlt_st02">
		<p>초빙정보 상세보기</p>		
	</h3>
	<div class="guin_d_top_info_wrap">
		<div class="guin_d_top_btns">
			<p><?=$_data['admin_action']?></p>
			<p><!-- <span class="sns_img_size"><?=$_data['tweeter_url']?> <?=$_data['facebook_url']?> <?echo kakaotalk_link('img/sns_icon/icon_kakaotalk.png','20','20') ?> <?=$_data['naverBand']?></span> <?=$_data['쪽지보내기']?> --><?=$_data['문의하기']?> <?=$_data['프린트버튼']?> <?report_button('img/detail_report.gif') ?></p>
		</div>
		<div class="guin_d_top_info">
			<div class="guin_d_left">
				<ul>
					<li class="guin_d_tlt_st01">
						<b><?=$_data['DETAIL']['guin_com_name']?></b>
						<h4><?=$_data['DETAIL']['guin_title']?></h4>
						<span style="background:#d2e3f9; color:#<?=$_data['배경색']['기본색상']?>"><b style="font-weight:500;"><?=$_data['접수마감카운터']?></b> &nbsp( ~ <?=$_data['DETAIL']['guin_end_temp']?>)</span>
					</li>
					<li class="guin_d_info_d">
						<div class="tb_st01">
							<strong>초빙개요</strong>
							<ul>
								<li>
									<span	>경력</span>
									<span style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_career_temp']?></span>
								</li>
								<li>
									<span>유형</span>
									<span style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_edu']?></span>
								</li>
								<li>
									<span>진료과</span>
									<span style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['type']?></span>
								</li>
							<!-- 	<li>
									<span>나이</span>
									<span style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_age_temp']?></span>
								</li> -->
							</ul>
						</div>
						<div class="tb_st01">
							<strong>고용형태</strong>
							<ul>
								<li>
									<span>고용형태</span>
									<span style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_type']?></span>
								</li>
								<li>
									<span>급여조건</span>
									<span><?=$_data['DETAIL']['guin_pay_type']?> <?=$_data['DETAIL']['guin_pay']?> <?=$_data['DETAIL']['pay_type_txt']?></span>
								</li>
								<li>
									<span>근무지역</span>
									<span class="work_area_wrap"><?=$_data['DETAIL']['area']?></span>
								</li>
								<li>
									<span>근무시간 및 요일</span>
									<span><?=$_data['DETAIL']['work_week']?> / <?=$_data['DETAIL']['start_worktime']?> ~ <?=$_data['DETAIL']['finish_worktime']?></span>
								</li>
							</ul>
						</div>		
					</li>
					<li>
						<p class="guin_simg">
							<?=$_data['이미지1']?><?=$_data['이미지2']?><?=$_data['이미지3']?><?=$_data['이미지4']?><?=$_data['이미지5']?>

						</p>
					</li>
				</ul>
			</div>
			<div class="guin_d_right">
				<ul>
					<li>
						<a href="com_info.php?com_info_id=<?=$_data['DETAIL']['guin_id']?>&guin_number=<?=$_data['DETAIL']['number']?>">
							<img src="<?echo happy_image('자동','가로184','세로56','로고사용안함','로고위치7번','기본퀄리티','gif원본출력','img/logo_img.gif','가로기준') ?>" border="0" align="absmiddle">
						</a>				
					</li>
					<li>
						<div class="tb_st01">
							<strong>기관정보</strong>
							<ul>
								<li>
									<span>기관명</span>
									<span><?=$_data['DETAIL']['guin_com_name']?></span>
								</li>
								<li>
									<span>대표자명</span>
									<span><?=$_data['COM']['extra11']?></span>
								</li>
<!-- 								<li>
									<span>업종</span>
									<span><?=$_data['COM']['extra13']?></span>
								</li> 
								<li> 
									<span>매출액</span>
									<span><?=$_data['COM']['com_maechul']?></span>
								</li>
								<li>
									<span>사원수</span>
									<span><?=$_data['COM']['extra2']?></span>
								</li>
								<li>
									<span>설립연도</span>
									<span><?=$_data['COM']['extra1']?></span>
								</li>-->
								<li>
									<span>홈페이지</span>
									<span><a href="<?=$_data['COM']['com_homepage']?>" style="color:#666;"><?=$_data['COM']['com_homepage']?></a></span>
								</li>
							</ul>
						</div>
						
					</li>
				</ul>
				<p>
					<a href="com_info.php?com_info_id=<?=$_data['DETAIL']['guin_id']?>&guin_number=<?=$_data['DETAIL']['number']?>">기관정보보기</a>
					<a href="com_info.php?com_info_id=<?=$_data['DETAIL']['guin_id']?>&guin_number=<?=$_data['DETAIL']['number']?>#com_guin_list" class="guin_info_cnt">초빙정보</a>							
				</p>
			</div>
		</div>		
		<span>최종수정일 <?=$_data['최종수정일']?></span>
		<p>
			<?=$_data['온라인입사지원버튼']?><?=$_data['이메일접수버튼']?><?=$_data['스크랩버튼']?> <?=$_data['프린트버튼1']?>

		</p>
	</div>
	<!-- 탭소스 -->
	<div style="position:relative;">
		<div style="height:60px;">
			<div class="detail_menu tabBt" style="width:1198px; height:58px; border:1px solid #e0e0e0; background:#fafafa; position:relative; z-index:94;">
				<div class="detail_tab_menu">
					<ul>
						<li class="on">
						<a href="#con1">초빙개요</a>
						<div class="tab_border"></div>
						</li>
						<li>
						<a href="#con2">근무환경</a>
						<div class="line"></div>
						<div class="tab_border"></div>
						</li>
						<li>
						<a href="#con3">접수방법</a>
						<div class="line"></div>
						<div class="tab_border"></div>
						</li>
						<li>
						<a href="#con4">담당자정보</a>
						<div class="line"></div>
						<div class="tab_border"></div>
						</li>
					</ul>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div class="conList">
			<div id="con1">
				<h3 class="guin_d_tlt_st02">
					<span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>;  margin:0 10px 3px 0""></span>초빙개요
				</h3>
				<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;" class="guin_detail_table">
					<tbody>
						<tr>
							<th>고용형태</th>
							<td style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_type']?></td>
						</tr>
						<tr>
							<th>유형</th>
							<td><?=$_data['DETAIL']['guin_grade']?></td>
						</tr>
						<!-- <tr>
							<th>우대사항</th>
							<td><?=$_data['우대사항']?></td>
						</tr>
						<tr>
							<th>키워드</th>
							<td><?=$_data['키워드']?></td>
						</tr> -->
					</tbody>
				</table>
				<div style="border:1px solid #ddd; margin-top:30px;">
					<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse:collapse;"class="guin_detail_table2">
						<tbody>
							<tr>
								<th class="th_style">진료과</th>
<!-- 								<th class="th_style">담당업무</th>
								 -->			
								 <th class="th_style">자격요건</th>
								<th class="th_style" style="border-right:none;">모집인원</th>
							</tr>
							<tr>
								<td class="td_style"><?=$_data['DETAIL']['type']?></td>
<!-- 								<td class="td_style"><?=$_data['DETAIL']['guin_work_content']?></td>
								 -->								<td class="td_style">
									<table cellpadding="0" cellspacing="0" class="guin_detail_in_table">
										<tbody>
											<tr>
												<th>경력</th>
												<td style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_career_temp']?></td>
											</tr>
											<!-- 				<tr>
												<th>학력</th>
												<td style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_edu']?></td>
											</tr>
											<tr>
												<th>성별</th>
												<td style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_gender']?></td>
											</tr>
							<tr>
												<th>나이</th>
												<td style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_age_temp']?></td>
											</tr>
											<tr>
												<th>결혼유무</th>
												<td style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['marriage_chk']?></td>
											</tr> -->
											<!-- <tr>
												<th>외국어능력</th>
												<td style="color:#{ {배경색.서브색상}}">{ {DETAIL.guin_lang}}</td>
											</tr>
											<tr>
												<th>자격증</th>
												<td style="color:#{ {배경색.서브색상}}">{ {DETAIL.guin_license}}</td>
											</tr> -->
										</tbody>
									
									</table>
								</td>
								<td class="font_30 noto500" style="color:#333; text-align:center; border-right:none;">
									<?=$_data['DETAIL']['howpeople']?>

								</td>
							</tr>
						</tbody>
					
					</table>
				</div>
			<!-- 	<div style="margin-top:30px; border:1px solid #ddd; padding:20px">
					<div id="ct" style="font-size:15px;"><?=$_data['DETAIL']['guin_main']?></div>
				</div> -->
			</div>

			<div id="con2">
				<h3 class="guin_d_tlt_st02">
				<span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0"></span>근무환경
				</h3>
				<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;" class="guin_detail_table3">
					<tbody>
						<tr>
							<th class="th_style">급여조건</th>
							<td class="td_style" style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['DETAIL']['guin_pay_type']?> <?=$_data['DETAIL']['guin_pay']?></td>
						</tr>
						<tr>
							<th class="th_style">근무지역</th>
							<td class="td_style area_span"><?=$_data['DETAIL']['area']?></td>
						</tr>
<!-- 						<tr>
							<th class="th_style">인근지하철</th>
							<td class="td_style"><?=$_data['DETAIL']['underground1']?> <?=$_data['DETAIL']['underground2']?></td>
						</tr> -->
						<tr>
							<th class="th_style">근무시간 및 요일</th>
							<td class="td_style"><?=$_data['DETAIL']['work_week']?>&nbsp;&nbsp;<?=$_data['DETAIL']['start_worktime']?> ~ <?=$_data['DETAIL']['finish_worktime']?></td>
						</tr>
<!-- 						<tr>
							<th class="th_style">복리후생</th>
							<td class="td_style guin_detail_in_table2" style="padding:10px 30px;"><?=$_data['복리후생']?></td>
						</tr> -->
					</tbody>
				</table>
			</div>

			<div id="con3">
				<h3 class="guin_d_tlt_st02">
				<span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0"></span>접수방법
				</h3>
				<table cellspacing="0" cellpadding="0"  style="width:100%; border-collapse:collapse;" class="guin_detail_table">
					<tbody>
						<tr>
							<th>접수기간</th>
							<td style="color:#<?=$_data['배경색']['기본색상']?>"><?=$_data['접수기간']?></td>
							<td rowspan="2" style="text-align:center; padding-left:0; padding-top:20px;
							padding-bottom:20px;">
								<span class="noto500 font_28" style="display:inline-block; color:#333;"><?=$_data['접수마감카운터2']?></span><br>
								<span class="jiwon_btns_wrap"><?=$_data['온라인입사지원버튼']?> <?=$_data['이메일접수버튼']?></span>
							</td>
						</tr>
						<tr>
							<th>접수방법</th>
							<td><?=$_data['DETAIL']['howjoin']?></td>
						</tr>
<!-- 						<tr>
							<th>사전인터뷰</th>
							<td><label><span style="font-weight:500;"><?=$_data['COM']['com_name']?></span>에 입사지원시 아래 질문에 대한 답변을 함께 보내주세요.</label></td>
						</tr>
						<tr>
							<th>인터뷰내용</th>
							<td><?=$_data['DETAIL']['guin_interview']?></td>
						</tr> -->
					</tbody>				
				</table>
			</div>
			<div id="con4">
				<h3 class="guin_d_tlt_st02">
				<span style="display:inline-block; vertical-align:middle; width:3px; height:20px; background:#<?=$_data['배경색']['기본색상']?>; margin:0 10px 3px 0"></span>담당자정보
				</h3>
				<table cellspacing="0" cellpadding="0"  style="width:100%; border-collapse:collapse;table-layout:fixed;" class="guin_detail_table">
					<tbody>
						<tr>
							<th>담당자</th>
							<td><?=$_data['DETAIL']['guin_name']?> &nbsp;&nbsp;<?=$_data['쪽지보내기']?></td>
							<th>홈페이지</th>
							<td style="word-break:break:all;"><a href="<?=$_data['DETAIL']['guin_homepage']?>" style="color:#666;"><?=$_data['DETAIL']['guin_homepage']?></a></td>
						</tr>
						<tr>
							<th>연락처</th>
							<td><?=$_data['DETAIL']['guin_phone']?></td>
							<th>팩스</th>
							<td><?=$_data['DETAIL']['guin_fax']?></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td colspan="3"><?=$_data['DETAIL']['guin_email']?></td>
						</tr>
						<tr>
							<th>회사주소</th>
							<td colspan="3"><?=$_data['DETAIL']['user_zip']?> <?=$_data['DETAIL']['user_addr1']?> <?=$_data['DETAIL']['user_addr2']?></td>
						</tr>
					</tbody>
				</table>
				<div style="margin:40px auto;">
					<?happy_map_call('자동','자동','1200','490','','img/map_here.png','지도버튼/줌버튼') ?>

				</div>
			</div>

		</div>
	</div>
	<!-- 탭소스 END -->

	<div style="margin-bottom:50px">
		<!-- SMS 문자발송 서비스 start --><a name="sms_message_send"></a><?=$_data['문자전송']?><!-- SMS 문자발송 서비스 end -->
	</div>

	<p style="background:#fbfbfb url('./img/detail_mark.png') 30px 30px no-repeat;  padding:20px 20px 20px 110px; color:#666666; letter-spacing:-1px; border:1px solid #c5c5c5; line-height:1.6;" class="font_14 noto400">
	본 정보는 <?=$_data['DETAIL']['guin_com_name']?>에서 제공한 자료를 바탕으로 <?=$_data['site_name']?> 에서 편집 및 그 표현방법을 수정하여 완성 한 것입니다.<br/>
	본 정보는 <?=$_data['site_name']?> 의 동의없이 무단전재 또는 재배포, 재가공할 수 없으며, 게재된 초빙기관과 초빙담당자의 정보는 구직활동 이외의 다른 용도로 사용될 수 없습니다.<br/>
	(저작권자 ⓒ <?=$_data['site_name']?> 무단전재 - 재배포 금지)
	</p>
	<div class="font_gulim"style="background:url('img/bg_map_add.gif') repeat-x; height:33px; border:1px solid #d0d0d0; border-top:none; ;line-height:33px; text-align:right; padding:0 20px">
		<?=$_data['DETAIL']['howjoin']?> <?=$_data['초빙정보보기버튼']?>

	</div>

	<div style="text-align:center; padding:50px 0 60px">
		<?=$_data['온라인입사지원버튼']?><?=$_data['이메일접수버튼']?><?=$_data['스크랩버튼']?><?=$_data['프린트버튼1']?>

	</div>

	<div><?=$_data['온라인입사지원폼']?></div>


</div>


<? }
?>