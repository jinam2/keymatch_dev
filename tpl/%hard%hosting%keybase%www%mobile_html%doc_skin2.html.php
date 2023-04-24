<? /* Created by SkyTemplate v1.1.0 on 2023/03/27 16:14:23 */
function SkyTpl_Func_3104906037 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<!-- 카카오스토리 링크 -->
<script type="text/javascript" src="js/kakao.link.js"></script>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type="text/javascript">
function executeKakaoStoryLink()
{
    /*kakao.link("story").send({
        post : "<?=$_data['main_url']?>/document_view.php?number=<?=$_data['DETAIL']['number']?>",
        appid : document.domain,
        appver : "1.0",
        appname : "<?=$_data['site_name1']?>",
        urlinfo : JSON.stringify({title:"<?=$_data['DETAIL']['title']?>", desc:"<?=$_data['상세설명_카카오스토리']?>", imageurl:["<?=$_data['kakao_story_img']?>"], type:"article"})
    });*/
    Kakao.Story.open({
        url: '<?=$_data['main_url']?>/document_view.php?number=<?=$_data['DETAIL']['number']?>',
        text: '<?=$_data['DETAIL']['title']?>',            //공유할 텍스트
        urlInfo: {
        title: '<?=$_data['site_name1']?>',                //공유한 사이트의 제목
        images: ['<?=$_data['kakao_story_img']?>']
        }
    });
}
</script>
<style type="text/css">
	.btn_type_scrap a{background:#<?=$_data['배경색']['모바일_기본색상']?>;}
	h5.front_bar_st_tlt:before{background:#<?=$_data['배경색']['모바일_기본색상']?>;}
	.btn_type_point_line > a{border:2px solid #<?=$_data['배경색']['모바일_기본색상']?>; color:#<?=$_data['배경색']['모바일_기본색상']?>;}
	.sub_tab_menu03 > ul > li.tab_on1{border-top:4px solid #<?=$_data['배경색']['모바일_기본색상']?>;}
</style>
<!-- 카카오스토리 링크 -->
<div class="sub_wrap">
	<h3 class="sub_tlt_st01">
		<span>인재정보 상세보기</span>
	</h3>
	<div class="guzic_d_top_info_wrap02">
		<ul>
			<li>
				<p>
					<span>
						<a href="javascript:void(0);" onclick="executeKakaoStoryLink()">
							<img src="mobile_img/kakao_story_icon2.png" alt="카카오스토리" title="카카오스토리">
						</a>
					</span>
					<span><?=$_data['tweeter_url']?></span>
					<span><?=$_data['facebook_url']?></span>
					<span><?echo kakaotalk_link('mobile_img/kakao_icon2.png','','') ?></span>
					<span><?=$_data['naverBand']?></span>
				</p>
				<strong><?=$_data['Data']['title']?></strong>
				<span>수정일 : <?=$_data['Data']['modifydate']?></span>
			</li>
			<li>
				<div>
					<b><img src="<?=$_data['작은이미지']?>" align="absmiddle" width="<?=$_data['HAPPY_CONFIG']['doc_pic_width_1']?>" height="<?=$_data['HAPPY_CONFIG']['doc_pic_height_1']?>" border="0" onclick="<?=$_data['미니앨범링크']?>"></b>
					<strong><?=$_data['Data']['user_name']?></strong>
					<span>(<?=$_data['Data']['user_prefix']?>, <?=$_data['Data']['user_age']?>세) / <?=$_data['Data']['user_id']?></span>
				</div>
				<div class="guzic_d_top_info_basic">
					<ul class="info_txt_box">
						<li>
							<strong style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><img src="mobile_img/gz_d_icon01.png" alt="무선전화" /></strong>
							<p style="font-size:26px; font-weight:500; color:#<?=$_data['배경색']['모바일_모바일_기본색상']?>"><?=$_data['Data']['user_hphone']?></p>
						</li>
						<li>
							<strong><img src="mobile_img/gz_d_icon02.png" alt="유선전화" /></strong>
							<p><?=$_data['Data']['user_phone']?></p>
						</li>
						<li>
							<strong><img src="mobile_img/gz_d_icon03.png" alt="이메일" /></strong>
							<p><?=$_data['Data']['email']?> / <?=$_data['Data']['user_email2']?></p>
						</li>
						<li>
							<strong><img src="mobile_img/gz_d_icon04.png" alt="홈페이지" /></strong>
							<p><?=$_data['Data']['user_homepage']?></p>
						</li>
						<li>
							<strong><img src="mobile_img/gz_d_icon05.png" alt="주소" /></strong>
							<p><?=$_data['Data']['user_addr1']?> <?=$_data['Data']['user_addr2']?></p>
						</li>
					</ul>
					<span class="btn_type_scrap"><?=$_data['스크랩버튼']?></span>
				</div>				
			</li>
		</ul>		
	</div>
	<div class="sub_tab_menu03">
		<ul>
			<li class="tab_on1" id="class_div1" onclick="TabChange_class('class','class_div','1','1');">지원정보</li>
			<li class="tab_off1" id="class_div2" onclick="TabChange_class('class','class_div','2','1');">인재상세</li>
			<li class="tab_off1" id="class_div3" onclick="TabChange_class('class','class_div','3','1');">자기소개서</li>
		</ul>
	</div>	
	<div class="guzic_d_content_wrap">		
		<ul id="class1">
			<li>
				<h5 class="front_bar_st_tlt">희망근무조건</h5>
				<ul class="info_txt_box">
					<li>
						<strong>희망 근무지</strong>
						<p><?=$_data['Data']['job_where']?></p>
					</li>
					<li>
						<strong>희망 연봉</strong>
						<p><span style="display:block;"><?=$_data['Data']['grade_money_type']?></span><span><?=$_data['Data']['grade_money']?></span></p>
					</li>
					<li>
						<strong>희망 진료과</strong>
						<p><?=$_data['Data']['job_type']?></p>
					</li>
					<li>
						<strong>희망 요일</strong>
						<p><?=$_data['Data']['etc7_text']?></p>
					</li>
					<li>
						<strong>고용형태</strong>
						<p><?=$_data['Data']['grade_gtype']?></p>
					</li>

				</ul>
			</li>
			<li>
				<h5 class="front_bar_st_tlt">학력사항</h5>
				<table class="tb_st_02">
					<colgroup>
						<col width="40%"/>
						<col width="60%"/> 
					</colgroup>
					<tbody>
						<tr>
							<th>재학기간</th>
							<th>학교명</th>
						</tr>
						<?=$_data['학력리스트내용']?>

					</tbody>
				</table>				
			</li>
			<li>
				<h5 class="front_bar_st_tlt">경력사항</h5>
				<div>
					<p style="border:2px solid #<?=$_data['배경색']['모바일_기본색상']?>;">
						총 경력년수 <b style="color:#<?=$_data['배경색']['모바일_기본색상']?>"><?=$_data['Data']['work_year']?> <?=$_data['Data']['work_month']?></b>
					</p>
					<div style="display:block;">
						<span>수행 프로젝트 및 기타 경력사항</span>
						<p><?=$_data['Data']['work_list']?></p>
					</div>
				</div>
			</li>
		</ul>
		<ul id="class2" style="display:none;">
			<li>
				<h5 class="front_bar_st_tlt">보유기술 및 보유이수 내용</h5>
				<div>
					<div>
						<p style="border-top:none;"><?nl2br_print('Data','skill_list') ?></p>
					</div>
				</div>
			</li>
			<li>
				<h5 class="front_bar_st_tlt">자격사항</h5>
				<table class="tb_st_02">
					<colgroup>
						<col width="55%"/>
						<col width="45%"/>
					</colgroup>
					<tbody>
						<tr>
							<th>자격명</th>
							<th>발행정보</th>
						</tr>
						<?=$_data['자격증리스트내용']?>

					</tbody>
				</table>				
			</li>
			<li>
				<h5 class="front_bar_st_tlt">외국어능력</h5>
				<div class="guzic_d_con_skill">
					<ul>
						<?=$_data['언어리스트내용']?>

					</ul>
				</div>				
			</li>
			<li class="yunsoo_tb_st">
				<h5 class="front_bar_st_tlt">해외연수</h5>
				<table class="tb_st_02">
					<colgroup>
						<col width="38%"/>
						<col width="62%"/>
					</colgroup>
					<tbody>
						<tr>
							<th>국가명</th>
							<th>연수정보</th>
						</tr>
						<?=$_data['연수리스트내용']?>

					</tbody>
				</table>				
			</li>
			<li>
				<h5 class="front_bar_st_tlt">취업 우대사항</h5>
				<ul class="info_txt_box">
					<li>
						<strong>보훈대상</strong>
						<p><?=$_data['Data']['user_bohun']?></p>
					</li>
					<li>
						<strong>장애</strong>
						<p><?=$_data['Data']['user_jangae']?></p>
					</li>
					<li>
						<strong>병역사항</strong>
						<p><?=$_data['Data']['user_army']?> <?=$_data['Data']['user_army_status']?></p>
					</li>
				</ul>
			</li>
		</ul>
		<ul id="class3" style="display:none;">
			<li>
				<h5 class="front_bar_st_tlt">자기소개서</h5>
				<div>
					<div>
						<p style="border-top:none;"><?=$_data['Data']['profile']?></p>
					</div>
				</div>
			</li>
			<li>
				<div class="guin_d_bottom_info">
					<img src="./mobile_img/warning_icon.jpg" alt="안내" />
					<p style="padding:0; ">
						본 정보는 취업활동을 위해 등록한 이력서 정보이며 <b><?=$_data['COM']['com_name']?></b> 기재된 내용에 대한 오류와 사용자가 신뢰하여 취한 조치에 대한 책임을 지지 않습니다. 누구든 본 정보를 <b><?=$_data['COM']['com_name']?></b> 동의없이 재배포할 수 없으며, 본 정보를 출력 및 복사 하더라도 채용목적 이외의 용도로 사용할 수 없습니다. 아울러 본 정보를 출력 및 복사한 경우의 갱인정보보호에 대한 책임은 출력 및 복사한 당사자에게 있으며 정보통신부 고시 제 2005-18호 [제2007-3호 반영] (개인정보의 기술적, 관리적 보호조치 기준)에 따라 개인정보가 담긴 이력서 등을 불럽유출 및 배포하게 되면 법에 따라 책임지게 됨을 양지하시기 바랍니다.
						<span style="display:block">&lt;저작권자 &copy; <?=$_data['site_name_original']?>. 무단전재-재배포 금지&gt;</span>
					</p>
				</div>
			</li>
		</ul>
	</div>
	<p class="doc_view_btns">
		<span class="btn_type_scrap"><?=$_data['스크랩버튼']?></span>
		<span class="btn_type_point_line"><?=$_data['예비합격버튼']?></span>
		<span class="btn_type_light_gray"><?=$_data['입사지원요청버튼']?></span>
		<span class="btn_type_light_gray"><?=$_data['면접제의버튼']?></span>
	</p>
</div>
<? }
?>