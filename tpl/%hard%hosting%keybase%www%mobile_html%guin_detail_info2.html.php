<? /* Created by SkyTemplate v1.1.0 on 2023/03/29 17:23:29 */
function SkyTpl_Func_4236917230 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<ul id="class2" style="display:none;">
	<li>
		<div class="guin_logo_box">
			<a href="com_info.php?com_info_id=<?=$_data['DETAIL']['guin_id']?>&guin_number=<?=$_data['DETAIL']['number']?>">
				<img src="<?echo happy_image('자동','가로240','세로72','로고사용안함','로고위치7번','퀄리티100','gif원본출력','img/logo_img.gif','가로기준') ?>" border="0" align="absmiddle">
			</a>
			<p>
				<b><?=$_data['DETAIL']['guin_com_name']?></b>
				<a href="com_info.php?com_info_id=<?=$_data['DETAIL']['guin_id']?>&guin_number=<?=$_data['DETAIL']['number']?>">기관정보 상세보기&nbsp&nbsp&nbsp&nbsp <span style="font-family:'굴림', sans-serif; letter-spacing:-6px; font-weight:bold; color:inherit;">>></span></a>
			</p>
		</div>
		
	</li>
	<li>
		<div>
			<h5 class="front_bar_st_tlt" style="margin-bottom:15px;">기관정보</h5>
			<ul class="info_txt_box">
				<li>
					<strong>기관명</strong>
					<p><?=$_data['DETAIL']['guin_com_name']?></p>
				</li>
				<li>
					<strong>홈페이지</strong>
					<p><?=$_data['COM']['com_homepage']?></p>
				</li>
				<li>
					<strong>주소</strong>
					<p>(<?=$_data['COM']['com_zip']?>) <?=$_data['COM']['com_addr1']?> <?=$_data['COM']['com_addr2']?></p>
				</li>
			<!-- 		<li>
					<strong>대표자명</strong>
					<p><?=$_data['COM']['extra11']?></p>
				</li>
				<li>
					<strong>사원수</strong>
					<p><?=$_data['COM']['extra2']?> 명</p>
				</li>
				<li>
					<strong>설립연도</strong>
					<p><?=$_data['COM']['extra1']?> 년</p>
				</li>
				<li>
					<strong>매출액</strong>
					<p><?=$_data['COM']['com_maechul']?></p>
				</li>
			<li>
					<strong>업·직종</strong>
					<p><?=$_data['COM']['com_job']?></p>
				</li> -->
				<li>
					<strong>사업내용</strong>
					<p><?=$_data['COM']['extra14']?></p>
				</li>
			</ul>
		</div>
	</li>
	<li>
		<div>
			<h5 class="front_bar_st_tlt">담당자 정보</h5>
			<ul class="info_txt_box">
				<li>
					<strong>담당자</strong>
					<p><?=$_data['DETAIL']['guin_name']?></p>
				</li>
				<li>
					<strong>연락처</strong>
					<p><?=$_data['DETAIL']['guin_phone']?></p>
				</li>
				<li>
					<strong>팩스</strong>
					<p><?=$_data['DETAIL']['guin_fax']?></p>
				</li>
				<li>
					<strong>E-MAIL</strong>
					<p><?=$_data['DETAIL']['guin_email']?></p>
				</li>
				<li>
					<strong>홈페이지</strong>
					<p><?=$_data['DETAIL']['guin_homepage']?></p>
				</li>
				<li>
					<strong>회사주소</strong>
					<p><?=$_data['DETAIL']['user_zip']?> <?=$_data['DETAIL']['user_addr1']?> <?=$_data['DETAIL']['user_addr2']?></p>
				</li>
			</ul>
		</div>
	</li>
	<li>
		<div class="guin_d_bottom_info">
			<img src="./mobile_img/warning_icon.jpg" alt="안내" />
			<p>
				본 정보는 <?=$_data['COM']['com_name']?> 에서 제공한 자료를 바탕으로 <?=$_data['site_name_original']?>에서 편집 및 그 표현방법을 수정하여 완성한 것입니다. 본 정보는 <?=$_data['site_name_original']?>의 동의없이 무단전재 또는 재배포, 재가공할 수 없으며, 게재된 초빙기관과 초빙담당자의 정보는 구직활동 이외의 다른 용도로 사용될 수 없습니다.<br/>
				&lt;저작권자 ©<?=$_data['site_name_original']?>. 무단전재-재배포 금지&gt;
			</p>
		</div>
	</li>
</ul>

<? }
?>