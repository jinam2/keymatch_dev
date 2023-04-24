<? /* Created by SkyTemplate v1.1.0 on 2023/03/24 18:52:18 */
function SkyTpl_Func_1204559070 ($TPL,$DATA,$_index,$_size,$_col) { if ($DATA) $_data=$DATA; else $_data=$GLOBALS;?>
<style type="text/css">
	.sub_guin_list .d_day{color:#<?=$_data['배경색']['서브색상']?>;}
</style>

<div class="sub_wrap">
	<h3 class="sub_tlt_st01">
		<span>기관정보 상세보기</span>
	</h3>
	<div class="com_info_d_top_wrap">
		<div class="com_info_d_top">
			<p>
				<span><?=$_data['COM_INFO']['com_name']?></span>
				<b><?=$_data['logo_temp']?></b>
			</p>
			<!-- <ul>
				<li>
					<img src="img/com_info_ico_01.png">
					<span>매출액</span>
					<b><?=$_data['COM_INFO']['com_maechul']?></b>
				</li>
				<li>
					<img src="img/com_info_ico_02.png">
					<span>설립연도</span>
					<b><?=$_data['COM_INFO']['com_open_year']?></b>
				</li>
				<li>
					<img src="img/com_info_ico_03.png">
					<span>사원수</span>
					<b><?=$_data['COM_INFO']['com_worker_cnt']?></b>
				</li>
				<li>
					<img src="img/com_info_ico_04.png">
					<span>기업형태</span>
					<b><?=$_data['COM_INFO']['com_hopesize']?></b>
				</li>
			</ul> -->
		</div>	
		<ul class="com_info_d_content">
			<li class="top_bd_st_wrap">
				<h5 class="front_bar_no_st_tlt">기관정보</h5>
				<div>					
					<p><?=$_data['COM_INFO']['com_profile1']?></p>
				</div>
			</li>
			<li class="top_bd_st_wrap">
				<h5 class="front_bar_no_st_tlt">기본정보</h5>
				<div>					
					<table class="tb_st_01">
						<colgroup>
							<col width="25%;"/>
							<col width="75%;"/>
						</colgroup>
						<tbody>
<!-- 							<tr>
								<th>업종</th>
								<td><?=$_data['COM_INFO']['com_job']?></td>
							</tr>
							<tr>
								<th>설립연도</th>
								<td><?=$_data['COM_INFO']['com_open_year']?></td>
							</tr> -->
							<tr>
								<th>대표자</th>
								<td><?=$_data['COM_INFO']['boss_name']?></td>
							</tr>
					<!-- 		<tr>
								<th>직원수</th>
								<td><?=$_data['COM_INFO']['com_worker_cnt']?></td>
							</tr> -->
							<tr>
								<th>주소</th>
								<td><?=$_data['COM_INFO']['com_addr1']?> <?=$_data['COM_INFO']['com_addr2']?></td>
							</tr>
						</tbody>
					</table>
					<div>
						<?happy_map_call('자동','자동','1200','230','','img/map_here.png','지도버튼/줌버튼') ?>

					</div>
				</div>
			</li>
			<li class="top_bd_tb_in">
				<h5 class="front_bar_no_st_tlt">채용정보</h5>
				<div class="sub_guin_list" style="padding-top:0;">
					<div class="sub_guin_td">
						<?guin_extraction('총20개','가로1개','제목길이200자','자동','자동','자동','자동','일반','회사관련구인','sub_guin_list_rows_01.html','누락0개','사용함','','최근등록일순') ?>

					</div>			
				</div>
			</li>
		</ul>
	</div>
</div>

<? }
?>