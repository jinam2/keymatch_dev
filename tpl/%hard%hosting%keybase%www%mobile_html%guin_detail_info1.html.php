<? /* Created by SkyTemplate v1.1.0 on 2023/03/24 19:08:58 */
function SkyTpl_Func_398295789 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<ul id="class1">
	<li>
		<div class="guin_content_detail" style="overflow-x:scroll;-ms-overflow-style: none; scrollbar-width: none;"><?=$_data['DETAIL']['guin_main']?></div>
	</li>
	<li>
		<div>
			<h5 class="front_bar_st_tlt" style="margin-bottom:15px;">사진정보</h5>
			<div class="detail_m_img">
				<?=$_data['이미지1']?>

				<?=$_data['이미지2']?>

				<?=$_data['이미지3']?>

				<?=$_data['이미지4']?>

			</div>
		</div>
	</li>
	<li>
		<div>
			<h5 class="front_bar_st_tlt">초빙개요</h5>
			<ul class="info_txt_box">
				<li>
					<strong>진료과</strong>
					<p class="list_type01" style="color:#<?=$_data['배경색']['모바일_기본색상']?>;"><?=$_data['DETAIL']['type']?></p>
				</li>
				<li>
					<strong>유형</strong>
					<p><?=$_data['DETAIL']['guin_grade']?></p>
				</li>
<!-- 				<li>
					<strong>담당업무</strong>
					<p><?=$_data['DETAIL']['guin_work_content']?></p>
				</li> -->
				<li>
					<strong>모집인원</strong>
					<p><?=$_data['DETAIL']['howpeople']?></p>
				</li>
			<!-- 	<li>
					<strong>우대사항</strong>
					<p><?=$_data['우대사항']?></p>
				</li> -->
				<li>
					<strong>경력</strong>
					<p style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['DETAIL']['guin_career_temp']?></p>
				</li>
				<li>
					<strong>유형</strong>
					<p style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['DETAIL']['guin_edu']?></p>
				</li>
					<!-- <li>
					<strong>진료과</strong>
					<p style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['DETAIL']['guin_gender']?></p>
				</li>
			<li>
					<strong>나이</strong>
					<p style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['DETAIL']['guin_age_temp']?></p>
				</li> -->
			</ul>
		</div>
	</li>
	<li>
		<div>
			<h5 class="front_bar_st_tlt">고용형태</h5>
			<ul class="info_txt_box">
				<li>
					<strong>급여조건</strong>
					<p style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['DETAIL']['guin_pay_type']?> <?=$_data['DETAIL']['guin_pay']?></p>
				</li>
				<li>
					<strong>근무지역</strong>
					<p class="m_area_no_img"><?=$_data['DETAIL']['area']?></p>
				</li>
<!-- 				<li>
					<strong>인근지하철</strong>
					<p><?=$_data['DETAIL']['underground1']?> / <?=$_data['DETAIL']['underground2']?> / <?=$_data['DETAIL']['subway_txt']?></p>
				</li> -->
				<li>
					<strong>근무시간 및 요일</strong>
					<p><?=$_data['DETAIL']['work_week']?> / <?=$_data['DETAIL']['start_worktime']?> ~ <?=$_data['DETAIL']['finish_worktime']?></p>
				</li>
<!-- 				<li>
					<strong>복리후생</strong>
					<p><?=$_data['DETAIL']['guin_age_temp']?></p>
				</li> -->
			</ul>
		</div>
	</li>
	<li>
		<div>
			<h5 class="front_bar_st_tlt">접수방법</h5>
			<ul class="info_txt_box">
				<li>
					<strong>접수기간</strong>
					<p style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['접수기간']?></p>
				</li>
				<li>
					<strong>접수방법</strong>
					<p><?=$_data['DETAIL']['howjoin']?>

						<span class="job3b_exp_box">
							이메일 입사지원은 PC화면에서만 가능합니다.
						</span>
					</p>
				</li>
			</ul>
		</div>
	</li>
</ul>

<? }
?>