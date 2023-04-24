<? /* Created by SkyTemplate v1.1.0 on 2023/04/20 01:02:08 */
function SkyTpl_Func_2073494106 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	.sub_guin_list .d_day{color:#<?=$_data['배경색']['서브색상']?>;}
</style>

<h3 class="sub_tlt_st02">
	<p>기관정보 상세보기</p>		
</h3>
<ul class="com_info_wrap">
	<li class="com_info_top_wrap">		
		<div class="com_d_tlt_st01">
			<b>기관개요</b>
			<p><?=$_data['쪽지보내기']?><span class="sns_img_size" style="margin-left:5px;"><?=$_data['tweeter_url']?> <?=$_data['facebook_url']?> <?echo kakaotalk_link('img/sns_icon/icon_kakaotalk.png','20','20') ?> <?=$_data['naverBand']?></span> <?report_button('img/detail_report.gif') ?></p>
		</div>
		<div class="com_info_top">
			<?=$_data['logo_temp']?>

			<strong><?=$_data['COM_INFO']['com_name']?></strong>
			<p>
				<?=$_data['COM_INFO']['com_profile1']?>

			</p>
			<ul>
				<li>
					<img src="img/com_info_ico_01.png" style="height:50px;">
					<span><?=$_data['COM_INFO']['com_maechul']?></span>
					<span>매출액</span>
				</li>
				<li>
					<img src="img/com_info_ico_02.png"  style="width:50px; height:50px;">
					<span class="font_18 noto500" style="color:#333; letter-spacing:-1px; display:block;"><?=$_data['COM_INFO']['com_open_year']?></span>
					<span class="font_14 noto400" style="letter-spacing:-1px; color:#999">설립연도</span>
				</li>
				<li>
					<img src="img/com_info_ico_03.png"  style="width:50px; height:50px;">
					<span class="font_18 noto500" style="color:#333; letter-spacing:-1px; display:block;"><?=$_data['COM_INFO']['com_worker_cnt']?></span>
					<span class="font_14 noto400" style="letter-spacing:-1px; color:#999">사원수</span>
				</li>
				<li>
					<img src="img/com_info_ico_04.png"  style="width:50px; height:50px;">
					<span class="font_18 noto500" style="color:#333; letter-spacing:-1px; display:block;"><?=$_data['COM_INFO']['com_hopesize']?></span>
					<span class="font_14 noto400" style="letter-spacing:-1px; color:#999;">기관형태</span>
				</li>
			</ul>
		</div>		
	</li>
	<li>
		<div class="com_d_tlt_st01">
			<b>기본정보</b>
		</div>
		<table cellpadding="0" cellspacing="0" style="width:100%" class="com_info_tb">
			<tbody>
				<tr>
					<th>업종</th>
					<td><?=$_data['COM_INFO']['com_job']?></td>
					<th>설립연도</th>
					<td><?=$_data['COM_INFO']['com_open_year']?></td>
				</tr>
				<tr>
					<th>대표자</th>
					<td><?=$_data['COM_INFO']['boss_name']?></td>
					<th>직원수</th>
					<td><?=$_data['COM_INFO']['com_worker_cnt']?></td>
				</tr>
				<tr>
					<th>기관주소</th>
					<td colspan="3"><?=$_data['COM_INFO']['com_addr1']?> <?=$_data['COM_INFO']['com_addr2']?></td>
				</tr>
			</tbody>			
		</table>
	</li>
	<li>
		<div class="com_d_tlt_st01">
			<b>전체 초빙정보</b>
			<p>
				<span><?=$_data['채용정보정렬']?></span> <span><?=$_data['초빙마감일정렬']?></span>
			</p>
		</div>
		<div class="sub_guin_list">
			<ul class="sub_guin_th">
				<li>모집내용</li>
				<li>근무조건</li>
				<li>지원자격</li>
				<li>마감일</li>
			</ul>
			<div class="sub_guin_td">
				<?guin_extraction('총20개','가로1개','제목길이200자','자동','자동','자동','자동','일반','회사관련구인','sub_guin_list_rows_01.html','누락0개','사용함','','최근등록일순') ?>

			</div>			
		</div>
	</li>
	<li>
		<div class="com_d_tlt_st01">
			<b>위치정보</b>
		</div>
		<div style="margin-bottom:60px">
			<?happy_map_call('자동','자동','1200','490','','img/map_here.png','지도버튼/줌버튼') ?>

		</div>
	</li>
</ul>
	
<? }
?>